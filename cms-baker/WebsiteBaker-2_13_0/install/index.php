<?php
/*
 * Copyright (C) 2017 Manuela v.d.Decken <manuela@isteam.de>
 *
 * DO NOT ALTER OR REMOVE COPYRIGHT OR THIS HEADER
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 2 of the License.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License 2 for more details.
 *
 * You should have received a copy of the GNU General Public License 2
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * Description of index.php
 *
 * @package      Installer
 * @copyright    Manuela v.d.Decken <manuela@isteam.de>
 * @author       Manuela v.d.Decken <manuela@isteam.de>
 * @license      GNU General Public License 2.0
 * @version      2.0.1
 * @revision     $Id: index.php 152 2018-10-09 15:19:47Z Luisehahne $
 * @since        File available since 04.10.2017
 * @deprecated   no
 * @description  xxx
 */

use bin\{SecureTokens,WbAdaptor};
use bin\helpers\{PreCheck};
use vendor\phplib\Template;

    $sMinPhpVersion = '7.3';
    if (\version_compare((string) (PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION), $sMinPhpVersion, '<')) {
        $sMsg = '<h3 style="color: #ff0000;">'
              . 'WebsiteBaker is not able to run with PHP-Version less then '.$sMinPhpVersion.'!!<br />'
              . 'Please change your PHP-Version to any kind from '.$sMinPhpVersion.' and up!<br />'
              . 'If you have problems to solve that, ask your hosting provider for it.<br  />'
              . 'The very best solution is the use of PHP-'.$sMinPhpVersion.' and up</h3>';
        die($sMsg);
    }

    $sAddonName     = \basename(__DIR__);
    $sScriptPath    = dirname($_SERVER["SCRIPT_FILENAME"]);
    $sAddonPath     = $sScriptPath.'/';
    $sAppDir        = str_replace(['\\','//'], '/',__DIR__).'/';
    $iSharedHosting = (\strcmp($sScriptPath,$sAppDir));
    $sDocRoot       = \str_replace(['\\','//'],'/',realpath($_SERVER["DOCUMENT_ROOT"]));
    $sScriptName    = \str_replace(['\\','//'],'/',realpath($_SERVER["SCRIPT_FILENAME"]));
    $sLink          = \str_replace(['\\','//'],'/',__DIR__).'/';
    $sAppRel        = \str_replace($sDocRoot,'',\dirname(\dirname($sScriptName)));
    $sAppRel        = (($iSharedHosting!=0) ? '' : $sAppRel);
    $sAcpRel        = $sAppRel.'admin/';
    $sAppRel        = rtrim((empty($sAppRel) ? '/' : $sAppRel),'/').'';
    $sPathPattern   = "/^(.*?\/)install\/.*$/";
    $sAppPath       = \preg_replace ($sPathPattern, "$1", $sLink, 1 );
    $sOldPath     = \str_replace(['\\','//'],'/',\getcwd()).'/';
/* */
    $sProtokol = ((!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] == 'off' ) ? 'http' : 'https') . '://';
    $sPort = (\in_array((int) $_SERVER["SERVER_PORT"], [80, 443]) ? '' : ':'.$_SERVER["SERVER_PORT"]);
    $sHostname = \str_replace($sPort, '',$_SERVER["HTTP_HOST"]);
    $sUrl = $sProtokol.$sHostname.$sPort.$sAppRel;// end new routine
//    $sScriptPath = \str_replace(DIRECTORY_SEPARATOR, '/', ($_SERVER["SCRIPT_FILENAME"]));
    $sScriptUrl = $sUrl.'/'.\str_replace($sAppPath, '', $sScriptPath);
    $sScriptUrl = \str_replace(['\\','//'],'/',$sScriptUrl).'/';
    $sAppUrl    = (isset($_SESSION['wb_url']) ? $_SESSION['wb_url'] : $sProtokol.$sHostname.$sPort.$sAppRel);
    $sAcpUrl    = $sAppUrl.'/admin/';
    $aTestLinks = [
      'Protokol' => $sProtokol,
      'Port' => $sPort,
      'Hostname' => $sHostname,
      'DOCUMENT_ROOT' => $_SERVER["DOCUMENT_ROOT"],
      'SCRIPT_FILENAME' => $_SERVER["SCRIPT_FILENAME"],
      'realpath(SCRIPT_FILENAME)' => $sScriptName,
      'realpath(DOCUMENT_ROOT)' => $sDocRoot,
      'dirname(SCRIPT_FILENAME)' => $sScriptPath,
      '__DIR__' => __DIR__,
      '$sAppDir' => $sAppDir,
      '$iSharedHosting' => (int)$iSharedHosting,
      '$sAppPath' => $sAppPath,
      '$sAcpRel' => $sAcpRel,
      '$sAppRel' => $sAppRel,
      '$sUrl' => $sUrl,
      '$sAppUrl' => $sAppUrl,
      '$sAcpUrl' => $sAcpUrl,
     '$sScriptUrl' => $sScriptUrl,
    ];

//    $requestMethod = \strtoupper($oReg->Request->getServerVar('REQUEST_METHOD'));
//    $aRequestVars = $_POST;
    $args = [
        'overwrite'   => [
                            'filter'   => FILTER_VALIDATE_BOOLEAN,
                            'flags'    => FILTER_REQUIRE_SCALAR,
                            ],
        'restart'    => [
                            'filter'   => FILTER_SANITIZE_STRING,
                            'flags'    => FILTER_REQUIRE_SCALAR,
                           ],
    ];
//    $aInputs = [];
    $aInputs = filter_input_array(INPUT_POST, $args);

    $sAction    = 'install';
    $sAction    = ($aInputs['restart'] ?? $sAction);
    $bOverwrite = ($aInputs['overwrite'] ?? null);
    if (($sAction == 'restart') && $bOverwrite){
        $sFile = $sAppPath.'config.php';
        for ($i=0; $i<=10; $i++){
            $sNewFile = $sAppPath.sprintf('config.%03d.php',$i);
            if (!is_readable($sNewFile)){break;}
        }
        rename($sFile,$sNewFile);
    }

    $sLocalDebug  = is_readable($sAddonPath.'.setDebug');
    // Only for development prevent secure token check,
    $sSecureToken = !is_readable($sAddonPath.'.setToken');
    $sPHP_EOL     = ($sLocalDebug ? "\n" : '');
/**
 * create a new 4-digit secure token
 * @return string
 */
    function getNewToken()
    {
        $aToBase = \str_split('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $iToBaseLen = \sizeof($aToBase);
        \shuffle($aToBase);
        $iNumber = \rand($iToBaseLen**3, ($iToBaseLen**4)-1);
        $sRetval = '';
        while ($iNumber != 0) {
            $sRetval = $aToBase[($iNumber % $iToBaseLen)].$sRetval;
            $iNumber = \intval($iNumber / $iToBaseLen);
        }
        return $sRetval;
    }

    function make_dir($sRelPath, $dir_mode = 493, $recursive=true){
        $sAbsPath = dirname(__DIR__).DIRECTORY_SEPARATOR.$sRelPath;
        $bRetval = is_dir($sAbsPath);
        if (!$bRetval)
        {
            $bRetval = mkdir($sAbsPath, $dir_mode,$recursive);
        }
        return $bRetval;
    }

    function showVardump($mValue,$iLine,$mFunction){
        $sAddonPath = str_replace(['\\','//'], '/',__DIR__);
        if (is_readable($sAddonPath.'/.setDebug')){
            $sDomain = \basename(__DIR__).'/'.\basename(__FILE__);
            ob_start();
            $sHeadLine = nl2br(sprintf("function: <span>%s</span> (%s) Filename: <span>%s</span> Line %d\n",(!empty($mFunction) ? $mFunction : 'global'),'myVar',$sDomain,$iLine));
            echo '<div class="w3-margin w3-pre"><pre>'.$sHeadLine;
            \print_r( $mValue ); echo "</pre>\n</div>"; \flush (); // htmlspecialchars() ob_flush();;sleep(10); die();
            return ob_get_clean();
        }
    }
// ---------------------------------------------------------------------------------------
// check start requirements --------------------------------------------------------------
    $sMsg = ((isset($_SESSION['message']) && !empty($_SESSION['message'])) ? $_SESSION['message'] : '').PHP_EOL;
    $sCfgFile = $sAppPath.'config.php';
    $config_content = "<?php\n";
    if (!\is_readable($sCfgFile)) {
      if (!file_put_contents($sCfgFile, $config_content)) {
        $sMsg .= 'There is no \'config.php\' available. Please create an empty \'config.php\' !!'.PHP_EOL;
      }
    } else {
      if (!\is_writeable($sCfgFile)) {
            $sMsg .= 'Sorry, \'config.php\' is not writable! Please change the file mode!'.PHP_EOL;
        }
    }
    if (\is_readable($sCfgFile) && \filesize($sCfgFile) > 64) {
        $sMsg .= 'WebsiteBaker seems to be already installed. Access denied!'."\n";
        $sMsg .= '<b>WARNING!!</b> '."\n";
        $sMsg .= 'Rename or delete your config.php and pages folder then click on <b>Restart Wizard</b>';
        $sMsg .= ' and installer will be start from beginning'."\n";
        $sMsg .= 'or clicking <b>Go To Backend</b> will be jump to Backend Login';
/*
        $sMsg .= 'WebsiteBaker seems to be already installed. Access denied!'."\n";
        $sMsg .= '<b>WARNING!!</b> If you click on <b>Restart Wizard</b> the config.php file will be emptied';
        $sMsg .= ' and installer will be start from beginning and overwrite your Database '."\n";
        $sMsg .= 'Are you sure you want to overwrite your Database? ';
        $sMsg .= '<input id="overwrite" class="w3-check" type="checkbox" name="overwrite" value="true" /> ';
        $sMsg .= '<label for="overwrite">emptied config.php</label>'."\n";
        $sMsg .= 'Clicking <b>Go To Backend</b> will be jump to Backend Login';
*/
    }
    $sMsg = trim($sMsg);
    if (!empty($sMsg)) {
    // show error message and exit -------------------------------------------------------
?><!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>WebsiteBaker Installation Wizard</title>

        <link rel="stylesheet" href="<?= $sAppUrl; ?>/include/assets/w3-css/w3.css" type="text/css" />
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    </head>
    <body>
        <div class="body">
            <form id="website_baker_installation_wizard" action="#" method="post">
                <table>
                    <tbody>
                        <tr style="background-color: #a9c9ea;">
                            <td>
                                <img src="wbLogo.svg" alt="" />
                            </td>
                            <td>
                                <h1 style="border:none; margin:auto;font-size:200%;text-align: center;">Installation Wizard</h1>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="welcome">
                    Welcome to the WebsiteBaker Installation Wizard.
                </div>
                <div><?= showVardump($aTestLinks,__LINE__,__FUNCTION__);?></div>
                <div class="w3-panel w3-pale-red w3-leftbar w3-border w3-border-red w3-padding">
                    <b>Error:</b><br/><?php echo nl2br($sMsg); ?>
                </div>
                <div style="padding: 0.525em; margin: 10px auto; text-align:center;">
                        <button class="w3-btn w3-btn-default w3-blue w3-hover-green w3-medium" type="submit" name="restart" value="restart" ><span class="w3--padding w3-xlarge">&nbsp;</span><span style="vertical-align: text-bottom;">Restart Wizard</span>&nbsp;</button>
                        <button class="w3-btn w3-btn-default w3-blue w3-hover-green w3-medium" formaction="<?= $sAcpUrl;?>login/index.php" ><span class="w3-padding w3-xlarge">&#x2699;</span><span style="vertical-align: text-bottom;">Go to Backend</span></button>
                </div>
            </form>
        </div>
        <div style="font-size: 0.8em; margin: 0 0 3em; padding: 0; text-align:center;">
            <!-- Please note: the below reference to the GNU GPL should not be removed, as it provides a link for users to read about warranty, etc. -->
            <a href="https://websitebaker.org/" target="_blank" rel="noopener" style="color: #000000;">WebsiteBaker</a>
            is released under the
            <a href="https://www.gnu.org/licenses/gpl.html" target="_blank" rel="noopener" style="color: #000000;">GNU General Public License</a>
            <!-- Please note: the above reference to the GNU GPL should not be removed, as it provides a link for users to read about warranty, etc. -->
        </div >
    </body>
</html>
<?php
        exit;
    }
    unset($sMsg, $sCfgFile);
// ---------------------------------------------------------------------------------------
    if (!\defined('SESSION_STARTED')) {
        $is_secure = ((!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] == 'off' ) ? false : true);
        \session_name('wb-installer');
//        **PREVENTING SESSION HIJACKING**
//        Prevents javascript XSS attacks aimed to steal the session ID
        \ini_set('session.cookie_httponly', true);
//        **PREVENTING SESSION FIXATION**
        \ini_set('session.use_trans_sid', false);
//        Session ID cannot be passed through URLs
        \ini_set('session.use_only_cookies', true);
//        Uses a secure connection (HTTPS) if possible
        \ini_set('session.cookie_samesite', 'Strict');
        \ini_set('session.cookie_secure', $is_secure);
        \session_start();
        \define('SESSION_STARTED', true);
    } else {
        \session_regenerate_id(true); // avoids session fixation attacks
    }
/**
 * highlight input fields which contain wrong/missing data
 * @param string $field_name
 * @return string
 */
    function field_error($field_name='') {
        $sRetval = '';
        if (\defined('SESSION_STARTED') || !empty($field_name)){
            if (isset($_SESSION['ERROR_FIELD']) && ($_SESSION['ERROR_FIELD'] == $field_name)) {
                $sRetval = ' class="wrong" autofocus ';
            }
        }
        return $sRetval;
    }

    $mod_path = (str_replace(DIRECTORY_SEPARATOR, '/', __DIR__));
    $doc_root = \str_replace(DIRECTORY_SEPARATOR,'/',\rtrim(\realpath($_SERVER['DOCUMENT_ROOT']),'/'));
    $mod_name = \basename($mod_path);
    $wb_path = \str_replace(DIRECTORY_SEPARATOR,'/',(\dirname(\realpath( __DIR__))));

    if (!\defined('WB_PATH')) { \define('WB_PATH', $wb_path); }
    if (!\defined('SYSTEM_RUN')) {\define('SYSTEM_RUN', true); }
    $wb_root = \str_replace($doc_root,'',$wb_path);
/*
// begin new routine
    $sInstallFolderRel = str_replace($doc_root,'',\dirname(\dirname($_SERVER["SCRIPT_FILENAME"])));
    $sProtokol = ((!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] == 'off' ) ? 'http' : 'https') . '://';
    $sPort = (\in_array((int) $_SERVER["SERVER_PORT"], [80, 443]) ? '' : ':'.$_SERVER["SERVER_PORT"]);
    $sHostname = \str_replace($sPort, '',$_SERVER["HTTP_HOST"]);
    $sUrl = $sProtokol.$sHostname.$sPort.$sInstallFolderRel;// end new routine
    $sScriptPath = \str_replace(DIRECTORY_SEPARATOR, '/', ($_SERVER["SCRIPT_FILENAME"]));
    $sScriptUrl = $sUrl.\str_replace($wb_path, '', $sScriptPath);
    $sAppUrl    = (isset($_SESSION['wb_url']) ? $_SESSION['wb_url'] : $sUrl);
*/
    if (isset($_SESSION['wb_url']) && ($_SESSION['wb_url']!=$sUrl)){$_SESSION['wb_url']=$sUrl;}
    $installFlag = true;
// Check if the page has been reloaded
    if (!isset($_GET['sessions_checked'])) {
        // Set session variable
        $_SESSION['session_support'] = '<span class="good">Enabled</span>';
        // Reload page
        \header('Location: index.php?sessions_checked=true');
        exit(0);
    } else {
        // Check if session variable has been saved after reload
        if (isset($_SESSION['session_support'])) {
            $session_support = $_SESSION['session_support'];
        } else {
            $installFlag = false;
            $session_support = '<span class="bad">Disabled</span>';
        }
    }
// create security tokens
    $aToken = [getNewToken(), getNewToken()];
    $_SESSION['token'] = [
        'name' => $aToken[0],
        'value' => $aToken[1],
        'expire' => \time() + 900
    ];
// Check if AddDefaultCharset is set
    $e_adc=false;
    $sapi = \php_sapi_name();
    if(\strpos($sapi, 'apache')!==FALSE || \strpos($sapi, 'nsapi')!==FALSE) {
        \flush();
        $apache_rheaders = \apache_response_headers();
        foreach($apache_rheaders AS $h) {
            if(\strpos($h, 'html; charset')!==FALSE) {
               \preg_match('/charset\s*=\s*([a-zA-Z0-9- _]+)/', $h, $match);
                $apache_charset=$match[1];
                $e_adc=$apache_charset;
            }
        }
    }

?><!DOCTYPE HTML>
<html lang="de">
<head>
  <meta charset="utf-8" />
  <title>WebsiteBaker Installation Wizard</title>

  <link rel="stylesheet" href="<?= $sAppUrl; ?>/include/assets/w3-css/w3.css" type="text/css" />
  <link rel="stylesheet" href="stylesheet.css" type="text/css" />
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

</head>
<body>
<div class="body">
<table>
<tbody>
<tr style="background: #a9c9ea;">
    <td >
        <img src="wbLogo.svg" alt="" />
    </td>
    <td>
        <h1 style="border:none; margin:auto;font-size:200%;text-align: center;">Installation Wizard</h1>
    </td>
</tr>
</tbody>
</table>

<form id="website_baker_installation_wizard" action="save.php" method="post" autocomplete="off">
    <input type="hidden" name="url" value="" />
    <input type="hidden" name="username_fieldname" value="admin_username" />
    <input type="hidden" name="password_fieldname" value="admin_password" />
    <input type="hidden" name="remember" id="remember" value="true" />
    <input type="hidden" name="ERROR_FIELD" id="ERROR_FIELD" value="" />
    <input type="hidden" name="<?php echo $aToken[0]; ?>" value="<?php echo $aToken[1]; ?>" />
    <div class="welcome">
        Welcome to the WebsiteBaker Installation Wizard.
    </div>
    <div><?= showVardump($aTestLinks,__LINE__,__FUNCTION__);?></div>

<?php
        if(isset($_SESSION['message']) && $_SESSION['message'] != '') {
?><div class="error"><b>Error:</b> <?php echo $_SESSION['message']; ?></div><?php
        }
?>
        <table>
        <thead>
        <tr>
            <th colspan="4" class="step-row"><h1 class="step-row">Step 1</h1>
            <p>Please check the following requirements are met before continuing...</p>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php if ($session_support != '<span class="good">Enabled</span>') { ?>
        <tr>
            <td colspan="6" class="error">Please note: PHP Session Support may appear disabled if your browser does not support cookies.</td>
        </tr>
        <?php } ?>
        <tr>
            <td style="color: #666666;">PHP Version >= 7.3.0</td>
            <td>
                <?php
               if (version_compare(PHP_VERSION, '7.3.0', '>='))
               {
                    ?><span class="good"><?php echo PHP_VERSION;?></span><?php
                } else {
                    $installFlag = false;
                    ?><span class="bad"><?php echo PHP_VERSION;?></span><?php
                }
                ?>
            </td>
            <td style="color: #666666;">PHP Session Support</td>
            <td><?php echo $session_support; ?></td>
        </tr>
    <tr>
        <td style="color: #666666;">Server Default Charset</td>
            <td>
                <?php
                    $chrval = (($e_adc != '') && (strtolower($e_adc) != 'utf-8') ? true : false);
                    if($chrval == false) {
                        ?><span class="good">
                        <?php echo (($e_adc=='') ? 'OK' : $e_adc) ?>
                        </span>
                        <?php
                    } else {
                        ?><span class="bad"><?php echo $e_adc ?></span><?php
                    }

                ?>
            </td>
            <td style="color: #666666;">PHP Safe Mode</td>
            <td>
                <?php
                if(ini_get('safe_mode')=='' || strpos(strtolower(ini_get('safe_mode')), 'off')!==FALSE || ini_get('safe_mode')==0) {
                    ?><span class="good">Disabled</span><?php
                } else {
                    $installFlag = false;
                    ?><span class="bad">Enabled</span><?php
                }
                ?>
            </td>
        </tr>
        <?php if($chrval == true) {
        ?>
        <tr>
            <td colspan="6" style="font-size: 10px;" class="bad">
<p class="warning">
<b>Please note:</b> Your webserver is configured to deliver <?php echo $e_adc;?></b> charset only.<br />
To display national special characters (e.g.: ä á) in a clear manner, please switch this preset off (or request this change from your hosting provider).<br />
In any case you can choose <b><?php echo $e_adc;?></b> in the settings of WebsiteBaker.<br />
But this solution does not guaranty that content from all modules will display correctly!
</p>
</td>
</tr>
<?php } ?>
</tbody>
</table>
<table>
<thead>
<tr>
    <th colspan="4" class="step-row">
    <h1 class="step-row">Step 2</h1><p>Please check the following files/folders are writable before continuing...</p>
    </th>
</tr>
</thead>
<tbody>
<?php
    $config = '<span class="good">Writable</span>';
    $config_content = "<?php\n";
    $configFile = '/config.php';
    if (!isset($_SESSION['config_exists']) )
    {
// config.php or config.php.new
        if ((file_exists($wb_path.$configFile)==true)) {
// next operation only if file is writeable
            if (is_writeable($wb_path.$configFile)) {
// already installed? it's not empty
                if (filesize($wb_path.$configFile) > 128) {
                    $installFlag = false;
                    $config = '<span class="bad">Not empty! WebsiteBaker already installed?</span>';
// try to open and to write
                } elseif(!$handle = fopen($wb_path.$configFile, 'w')) {
                    $installFlag = false;
                    $config = '<span class="bad">Not Writable</span>';
                } else {
                    if (fwrite($handle, $config_content) === FALSE) {
                        $installFlag = false;
                        $config = '<span class="bad">Not Writable</span>';
                    } else {
                        $config = '<span class="good">Writable</span>';
                        $_SESSION['config_exists'] = true;
                    }
                    // Close file
                    fclose($handle);
                    }
            } else {
                $installFlag = false;
                $config = '<span class="bad">Not Writable</span>';
            }
// it's config.php.new
        } elseif ((file_exists($wb_path.'/config.php.new')==true))
        {
            $configFile = '/config.php.new';
            $installFlag = false;
            $config = '<span class="bad">Please rename config.php.new to config.php</span>';
        } else
        {
            $installFlag = false;
            $config = '<span class="bad">Missing!!?</span>';
        }
    }
?>
        <tr>
            <td style="color: #666666;"><?php print $wb_root.$configFile ?></td>
            <td colspan="3"  ><?php echo $config ?></td>
        </tr>
        <tr>
            <td style="color: #666666;"><?php print $wb_root ?>/pages/</td>
            <td><?php if (make_dir('pages') && is_writable('../pages/')) { echo '<span class="good">Writable</span>'; } elseif (!file_exists('../pages/')) {$installFlag = false; echo '<span class="bad">Directory Not Found</span>'; } else { echo '<span class="bad">Unwritable</span>'; } ?></td>
            <td style="color: #666666;"><?php print $wb_root ?>/media/</td>
            <td><?php if(make_dir('media') && is_writable('../media/')) { echo '<span class="good">Writable</span>'; } elseif (!file_exists('../media/')) {$installFlag = false; echo '<span class="bad">Directory Not Found</span>'; } else { echo '<span class="bad">Unwritable</span>'; } ?></td>
        </tr>
        <tr>
            <td style="color: #666666;"><?php print $wb_root ?>/templates/</td>
            <td><?php if (make_dir('templates') && is_writable('../templates/')) { echo '<span class="good">Writable</span>'; } else if(!file_exists('../templates/')) {$installFlag = false; echo '<span class="bad">Directory Not Found</span>'; } else { echo '<span class="bad">Unwritable</span>'; } ?></td>
            <td style="color: #666666;"><?php print $wb_root ?>/modules/</td>
            <td><?php if (make_dir('modules') && is_writable('../modules/')) { echo '<span class="good">Writable</span>'; } else if(!file_exists('../modules/')) {$installFlag = false; echo '<span class="bad">Directory Not Found</span>'; } else { echo '<span class="bad">Unwritable</span>'; } ?></td>
        </tr>
        <tr>
            <td style="color: #666666;"><?php print $wb_root ?>/languages/</td>
            <td><?php if (make_dir('languages') && is_writable('../languages/')) { echo '<span class="good">Writable</span>'; } else if(!file_exists('../languages/')) {$installFlag = false; echo '<span class="bad">Directory Not Found</span>'; } else { echo '<span class="bad">Unwritable</span>'; } ?></td>
            <td style="color: #666666;"><?php print $wb_root ?>/temp/</td>
            <td><?php if (make_dir('temp') && is_writable('../temp/')) { echo '<span class="good">Writable</span>'; } else if(!file_exists('../temp/')) {$installFlag = false; echo '<span class="bad">Directory Not Found</span>'; } else { echo '<span class="bad">Unwritable</span>'; } ?></td>
        </tr>
        <tr>
            <td style="color: #666666;"><?php print $wb_root ?>/var/log</td>
            <td><?php if (make_dir('var/log') && is_writable('../var/')) { echo '<span class="good">Writable</span>'; } else if(!file_exists('../languages/')) {$installFlag = false; echo '<span class="bad">Directory Not Found</span>'; } else { echo '<span class="bad">Unwritable</span>'; } ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
        </tbody>
        </table>
<?php  if($installFlag == true) {     ?>
        <table>
            <thead>
        <tr>
            <th colspan="4" class="step-row">
            <h1 class="step-row">Step 3</h1><p>Please check URL settings, select a default timezone and default backend language...</p>
            </th>
        </tr>
            </thead>
        <tbody>
        <tr>
            <td class="name">Absolute URL:</td>
            <td class="value">
                <input <?php echo field_error('wb_url');?> type="text" tabindex="1" name="wb_url" style="width: 99%;" value="<?php echo $sAppUrl; ?>" />
            </td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="name">Default Timezone:</td>
            <td class="value"><select <?php echo field_error('default_timezone');?> tabindex="3" name="default_timezone" style="width: 100%;">
<?php
/*
 build list of TimeZone options
*/
    $aZones = array(-12,-11,-10,-9,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,6,6.5,7,8,9,9.5,10,11,12,13);
    $sOutput = PHP_EOL;
    foreach($aZones as $fOffset) {
        $sItemTitle = 'GMT '.(($fOffset>0)?'+':'').(($fOffset==0)?'':(string)$fOffset.' Hours');
        $sOutput .= '<option value="'.(string)$fOffset.'"';
        if (
            (isset($_SESSION['default_timezone']) && $_SESSION['default_timezone'] == (string)$fOffset) ||
            (!isset($_SESSION['default_timezone']) && $fOffset == 0)
        ) {
            $sOutput .= ' selected="selected"';
        }
        $sOutput .= '>'.$sItemTitle.'</option>'.PHP_EOL;
    }
// output Timezone options
    echo $sOutput;
?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="name">Default Language: </td>
            <td class="value">
<?php
/*
*/
$sLinuxSelected   = ((isset($_SESSION['operating_system']) && $_SESSION['operating_system'] == 'linux') ? ' checked="checked"' : '');
$sWindowsSelected = ((isset($_SESSION['operating_system']) && $_SESSION['operating_system'] == 'windows') ? ' checked="checked"' : '');
$sDefaultSelected = ((empty($sLinuxSelected) && empty($sWindowsSelected)) ? ' checked="checked"' : '');
$sDatabaseHost    = (isset($_SESSION['database_host']) ? $_SESSION['database_host'] : 'localhost');
$sDatabaseName    = (isset($_SESSION['database_name']) ? $_SESSION['database_name'] : 'DatabaseName');
$sTablePrefix     = (isset($_SESSION['table_prefix']) ? $_SESSION['table_prefix'] : 'wb_');

/*
 Find all available languages in /language/ folder and build option list from
*/
// -----
    $getLanguage = function($sFile) {
        $aRetval = null;
        $language_code = $language_name = '';
        include $sFile;
        if ($language_code && $language_name) {
            $aRetval = ['code' => $language_code, 'name' => $language_name];
        }
        return $aRetval;
    };
// -----
    $aMatches = [];
    $sDefaultLang = (isset($_SESSION['default_language']) ? $_SESSION['default_language'] : 'EN');
    $sLangDir = str_replace('\\', '/', dirname(__DIR__).'/languages/');
    foreach(glob($sLangDir.'*.php') as $sFilename) {
        if (preg_match('/[A-Z]{2}\.php$/s', basename($sFilename)) && is_readable($sFilename)) {
            if (!($aMatch = $getLanguage($sFilename))) {continue;}
            $aMatch['status'] = ($aMatch['code'] == $sDefaultLang);
            $aMatches[] = $aMatch;
        }
    }
// create HTML-output
    if (sizeof($aMatches) > 0) {
        $sOutput = '<select '.field_error('default_language').' tabindex="3" name="default_language" style="width: 100%;">'.PHP_EOL;
        foreach ($aMatches as $aMatch) {
            $sOutput .= '<option value="'.$aMatch['code'].'" '
                      . ($aMatch['status'] ? 'selected="selected"' : '').'>'
                      . $aMatch['name'].'</option>'.PHP_EOL;
        }
        $sOutput .= '</select>'.PHP_EOL;
// output HTML
        echo $sOutput;
        unset($sOutput);
    } else {
        echo 'WARNING: No language definition files available!!!';
        $installFlag = false;
    }
    unset($aMatches, $aMatch, $getLanguage);
?>
            </td>
            <td colspan="4">&nbsp;</td>
        </tr>
      </tbody>
        </table>

        <table>
            <thead>
        <tr>
            <th class="step-row" colspan="4">
            <h1 class="step-row">Step 4</h1><p>Please specify your operating system information below...</p>
            </th>
        </tr>
            </thead>
      <tbody style="margin-top: 10px;">
        <tr>
            <td class="name">Server Operating System: </td>
            <td style="">
                <input type="radio" tabindex="4" name="operating_system" id="operating_system_linux" value="linux"<?php echo $sLinuxSelected.$sDefaultSelected ?> />
                <label for="operating_system_linux" style="cursor: pointer;">Linux/Unix based</label>
                <br />
                <input type="radio" tabindex="5" name="operating_system" id="operating_system_windows" value="windows"<?php echo $sWindowsSelected; ?> />
                <label for="operating_system_windows" style="cursor: pointer;">Windows</label>
            </td>
        </tr>
<!--  -->
        <tr>
            <td class="name">&nbsp;</td>
            <td class="value">
                <div class="w3-hide" id="file_perms_box" style="line-height:2em; position: relative; width: 100%;float:left; margin: 0; padding: 0; display: <?php if(isset($_SESSION['operating_system']) AND $_SESSION['operating_system'] == 'windows') { echo 'none'; } else { echo 'none'; } ?>;">
                    <input type="checkbox" tabindex="6" name="world_writeable" id="world_writeable" value="true"<?php if(isset($_SESSION['world_writeable']) AND $_SESSION['world_writeable'] == true) { echo ' checked="checked'; } ?> />
                     <label style=" margin: 0;  " for="world_writeable">
                        World-writable file permissions (777)
                    </label>
                <br />
                    <p class="warning">(Please note: only recommended for testing environments)</p>
                </div>
            </td>
        </tr>

        </tbody>
        </table>
        <table>
            <thead>
            <tr>
                <th colspan="4" class="step-row">
                <h1 class="step-row">Step 5</h1>
                <p>Please enter your MySQL database server details below</p>
                </th>
            </tr>
            </thead>
          <tbody>
            <tr>
                <td class="name">Host Name</td>
                <td class="value">
                    <input <?php echo field_error('database_host');?> type="text" tabindex="7" name="database_host" value="<?php echo $sDatabaseHost; ?>" />
                </td>
            </tr>

            <tr>
                <td class="name">Database Name: </td>
                <td class="value" style="white-space: nowrap;">
                    <input <?php echo field_error('database_name')?> type="text" tabindex="8" name="database_name" value="<?php echo $sDatabaseName; ?>" />
                <span style="display: inline;">&nbsp;&nbsp;([a-zA-Z0-9_])</span>
                </td>
            </tr>

        <tr>
            <td class="name">Table Prefix: </td>
            <td class="value" style="white-space: nowrap;">
                <input <?php echo field_error('table_prefix')?> type="text" tabindex="9" name="table_prefix" value="<?php echo $sTablePrefix; ?>" />
                <span style="display: inline;">&nbsp;([a-z0-9_])</span>
            </td>
        </tr>
        <tr>
            <td class="name">DB Charset Collation</td>
            <td>
                <select name="db_collation" style="width: 100%;">
                  <option value="utf8">utf8_unicode_ci</option>
                  <option value="utf8mb4">utf8mb4_unicode_ci</option>
                </select>
            </td>
        </tr>
        <tr>
                <td class="name">Username:</td>
                <td class="value">
                    <input <?php echo field_error('database_username');?> type="text" tabindex="10" name="database_username" value="<?php if(isset($_SESSION['database_username'])) { echo $_SESSION['database_username']; } else { echo 'root'; } ?>" />
                </td>
        </tr>
        <tr>
                <td class="name">Password:</td>
                <td class="value">
                    <input <?php echo field_error('database_password');?> type="password" tabindex="11" name="database_password" autocomplete="off" value="<?php if(isset($_SESSION['database_password'])) { echo $_SESSION['database_password']; } ?>" />
                </td>
        </tr>
        <tr>
            <td class="name hide" colspan="2">
                <input type="checkbox" tabindex="12" name="install_tables" id="install_tables" value="true"<?php if(!isset($_SESSION['install_tables'])) { echo ' checked="checked"'; } elseif($_SESSION['install_tables'] == 'true') { echo ' checked="checked"'; } ?> />
                <label for="install_tables" style="color: #666666;">Install Tables</label>
                <br />
                <span style="font-size: 1px; color: #666666;">(Please note: May remove existing tables and data)</span>
            </td>
        </tr>
        </tbody>
        </table>
        <table>
        <thead>
        <tr>
            <th colspan="4" class="step-row">
            <h1 class="step-row">Step 6</h1><p>Please enter your website title below...</p>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="name">Website Title:</td>
            <td class="value">
                <input <?php echo field_error('website_title');?> type="text" tabindex="13" name="website_title" value="<?php if(isset($_SESSION['website_title'])) { echo $_SESSION['website_title']; } else { echo 'Enter your website title'; } ?>" />
            </td>
        </tr>
        </tbody>
        </table>
        <table>
        <thead>
        <tr>
            <th colspan="4" class="step-row">
            <h1 class="step-row">Step 7</h1><p>Please enter your Administrator account details below...</p>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="name">Login Name:</td>
            <td class="value">
                <input placeholder="Administrator Login Name" <?php echo field_error('admin_username');?> type="text" tabindex="14" name="admin_username" value="<?php if(isset($_SESSION['admin_username'])) { echo $_SESSION['admin_username']; } ?>" />
            </td>
        </tr>
        <tr>
            <td class="name">Email:</td>
            <td class="value">
                <input <?php echo field_error('admin_email');?> type="text" tabindex="15" name="admin_email" value="<?php if(isset($_SESSION['admin_email'])) { echo $_SESSION['admin_email']; } ?>" />
            </td>
        </tr>
        <tr>
            <td class="name">Password:</td>
            <td class="value">
                <input <?php echo field_error('admin_password');?> type="password" tabindex="16" name="admin_password" value="" autocomplete="off" />
            </td>
        </tr>
        <tr>
            <td class="name">Re-Password:</td>
            <td class="value">
                <input <?php echo field_error('admin_repassword');?> type="password" tabindex="17" name="admin_repassword" value="" autocomplete="off" />
            </td>
        </tr>
        </tbody>
        </table>
<?php  }    ?>
        <table>
        <tbody>
<?php if($installFlag == true) { ?>
                <tr>
                    <td><strong>Please note: &nbsp;</strong></td>
                </tr>
                <tr>
                    <td>

                        <div class="w3-panel w3-pale-green w3-leftbar w3-border-green w3-border">
                        <p>
                        WebsiteBaker is released under the
                        <a href="https://www.gnu.org/licenses/gpl.html" target="_blank" rel="nofollow noopener" tabindex="19">GNU General Public License</a>
                        </p>
                        <p>
                        By clicking install, you are accepting the license.
                        </p>
                        </div>
                    </td>
                </tr>
                <tr>
            <td>
<?php  }    ?>
            <p class="center w3-margin-bottom">
<?php if($installFlag == true) { ?>
                <input class="w3-btn w3-btn-default w3-blue w3-hover-green w3-padding" type="submit" tabindex="20" name="install" value="Install WebsiteBaker" />
<?php
                } else {
                    if (isset($_SESSION['token'])) { unset($_SESSION['token']); }
?>
                <input class="w3-btn w3-btn-default w3-pale-red w3-hover-green w3-medium w3-padding w3-border" type="button" tabindex="20" name="restart" value="Check your Settings in Step1 or Step2" class="submit" onclick="window.location = '<?php print $sScriptUrl ?>';" />
<?php } ?>
            </p>
            </td>
        </tr>
        </tbody>
        </table>

</form>
</div>

<div style="margin: 0 0 3em; padding: 0; text-align:center;">
    <!-- Please note: the below reference to the GNU GPL should not be removed, as it provides a link for users to read about warranty, etc. -->
    <a href="https://websitebaker.org/" target="_blank" rel="noopener" style="color: #000000;">WebsiteBaker</a>
    is released under the
    <a href="https://www.gnu.org/licenses/gpl.html" target="_blank" rel="noopener" style="color: #000000;">GNU General Public License</a>
    <!-- Please note: the above reference to the GNU GPL should not be removed, as it provides a link for users to read about warranty, etc. -->
</div >

</body>
</html>
