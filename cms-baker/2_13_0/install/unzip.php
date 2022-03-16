<?php
/**
 * Name:            Unzip Script For Zip Archives
 * Version:         2.5
 * Author:          Viktor Vogel =>
 * Website:         https://joomla-extensions.kubik-rubik.de
 * Download old:    https://joomla-extensions.kubik-rubik.de/downloads/php-scripts-php-skripte/unzip-script-for-zip-archives
 * Download:        https://wiki.websitebaker.org/doku.php/en/downloads
 * License:         GPLv3
 * Description:     With this script you can unzip zip archives. This file and the archive are deleted automatically after the unzip process!
 * @link            https://websitebaker.org/
 * @license         https://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.12.x
 * @requirements    PHP 7.2 and higher
 * @download Repro  https://addon.websitebaker.org/pages/en/browse-add-ons.php?id=04D6D0F4
 * @downlaod Wiki   https://wiki.websitebaker.org/doku.php/en/downloads
 */


if (version_compare(PHP_VERSION, '7.2.0', '<')) {
   header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title></title>
  </head>
  <body>
    <h3>Date:<?= "\t". date('m-d-Y')."\n" ?></h3>
    <h2 style="text-align: center;color: red;">You have a outdated version of PHP <?= PHP_VERSION ;?></h2>
    <p style="text-align: center;font-size: 24px;">Please contact your Provider for update to 7.2.x or higher</p>
  </body>
</html>
<?php
exit;
}

// Settings - START
    $defaults = [
        'empty_folder'    => true,
        'empty_files'     => true,
        'delete_archive'  => true,
        'delete_unzip'    => true,
        'debug_mode'      => false,
        'start_unzip'     => 0,
        'aFiles'          => [],
    ];

    $args = [
        'empty_folder'   => [
                            'filter'   => FILTER_VALIDATE_BOOLEAN,
                            'flags'    => FILTER_REQUIRE_SCALAR,
                            ],
        'empty_files'    => [
                            'filter'   => FILTER_VALIDATE_BOOLEAN,
                            'flags'    => FILTER_REQUIRE_SCALAR,
                            ],
        'delete_archive' => [
                            'filter'   => FILTER_VALIDATE_BOOLEAN,
                            'flags'    => FILTER_REQUIRE_SCALAR,
                            ],
        'delete_unzip'   => [
                            'filter'   => FILTER_VALIDATE_BOOLEAN,
                            'flags'    => FILTER_REQUIRE_SCALAR,
                            ],
        'debug_mode'   => [
                            'filter'   => FILTER_VALIDATE_BOOLEAN,
                            'flags'    => FILTER_REQUIRE_SCALAR,
                            ],
        'aFiles'    => [
                            'filter'   => FILTER_SANITIZE_STRING,
                            'flags'    => FILTER_REQUIRE_ARRAY,
                            'options'  => ''
                           ],
    ];
//    $aInputs = [];
    $aInputs = filter_input_array(INPUT_POST, $args);
//    unset($_GET);

    $bStartUnzip = ($aInputs['start_unzip'] ?? true);
    $sZipPattern   = '*.zip';
    $aZipFiles = \glob($sZipPattern,\GLOB_NOSORT);
// Unzip empty folders? true - yes, false - no
    $bUnzipEmptyFolders =  ($aInputs['empty_folder'] ?? true);
// Unzip empty files? true - yes, false - no
    $bUnzipEmptyFiles =  ($aInputs['empty_files'] ?? true);
// Variable for the output
    $output = '';
// delete files after finish,  prevent by reset
    $bDeleteArchive = ($aInputs['delete_archive'] ?? false);
    $bDeleteUnzip   = ($aInputs['delete_unzip'] ?? false);
    $bDebugMode     = ($aInputs['debug_mode'] ?? false);
    $aArchiveFiles  = ($bDebugMode ? [] : ($aInputs['aFiles'] ?? []));
// Settings - END
    $sChecked = ' checked="checked"';
    $sUnzipCheckFolders = ($bUnzipEmptyFolders ? $sChecked : '');
    $sUnzipCheckFiles = ($bUnzipEmptyFiles ? $sChecked : '');
    $sCheckArchive = ($bDeleteArchive ? $sChecked : '');
    $sCheckUnzip = ($bDeleteUnzip ? $sChecked : '');
    $sCheckDebug = ($bDebugMode ? $sChecked : '');
// create absolute/relative paths
    $sAddonName = \basename(__DIR__);
    $sDocRoot = rtrim($_SERVER["DOCUMENT_ROOT"],'/');
    $sScriptName = $_SERVER["SCRIPT_FILENAME"];
    $sLink = \str_replace('\\','/',__DIR__).'/admin/';
    $sAppRel  = \str_replace($sDocRoot,'',\dirname($sScriptName));
    $sAppRel  = rtrim((empty($sAppRel) ? '/' : $sAppRel),'/').'/';
    $sAcpRel  = $sAppRel.'admin/';
    $sPathPattern = "/^(.*?\/)admin\/.*$/";
    $sAppPath = \preg_replace ($sPathPattern, "$1", $sLink, 1 );
    $sOldPath = \str_replace('\\','/',\getcwd()).'/';

    $iStartTime = \microtime(true);
    $sTimeStamp = \strftime('%Y%m%d_%H%M%S', \time());
    $sStartTime   = \sprintf('Start unzip at %s ',\strftime('%Y-%m-%d - %H:%M:%S', \time())).\PHP_EOL;
//    unset($_GET);

    \ini_set('error_reporting', -1);
    \ini_set("gd.jpeg_ignore_warning", 1);

    $aMatch = [];
    $iMemoryLimit = (ini_get('memory_limit'));
    if ($iMemoryLimit != -1) {
        preg_match('/^\s*([0-9]+)([a-z])?\s*(_)?\s*$/i', ini_get('memory_limit').'_', $aMatch);
        $iMemoryLimit = (int)$aMatch[1];
        switch ($iMemoryLimit) {
             case 'g': case 'G':
                $iMemoryLimit *= 1024;
            case 'm': case 'M':
                $iMemoryLimit *= 1024;
            case 'k': case 'K':
                $iMemoryLimit *= 1024;
                break;
            default:
                break;
        }
        unset($aMatch);
    }
    if ($iMemoryLimit < 255000000) {
        ini_set("memory_limit", '512M');
    }
    \ini_set('max_execution_time', 3600);

    $showDebug = (function($value){
      $sRetval = \print_r ('<span  class="mod-pre rounded" function <span>'.__FUNCTION__.'</span>',true);//( '.''.' );  filename: <span>'.\basename(__FILE__).'</span>  line: '.__LINE__.' -> <br />'
      $sRetval.= \print_r( $value, true);
      $sRetval.= \print_r ('</span>, true'); //.PHP_EOL; \flush (); htmlspecialchars() ob_flush();;sleep(10); die();
      return $sRetval;
    });

    $makeDir = (function ($sAbsPath, $iDirMode = 0755, $bRecursive=true)
    {
        $bRetVal = \is_dir($sAbsPath) && \is_readable($sAbsPath);
        $iOldUmask = \umask(0);
        if (!file_exists($sAbsPath)) {
            $bRetVal = \mkdir($sAbsPath, $iDirMode,$bRecursive);
        }
        \umask($iOldUmask);
        return $bRetVal;
    });

if (!\function_exists('get_variable_content'))
{
//  extracts the content of a string variable from a string (save alternative to including files)
    function get_variable_content($search, $data, $striptags=true, $convert_to_entities=true)
    {
        $match = [];
        // search for $variable followed by 0-n whitespace then by = then by 0-n whitespace
        // then either " or ' then 0-n characters then either " or ' followed by 0-n whitespace and ;
        // the variable name is returned in $match[1], the content in $match[3]
        if (\preg_match('/(\$' .$search .')\s*=\s*("|\')(.*)\2\s*;/i', $data, $match))
        {
            if (\strip_tags(\trim($match[1])) == '$' .$search) {
                // variable name matches, return it's value
                $match[3] = ($striptags == true) ? \strip_tags($match[3]) : $match[3];
                $match[3] = ($convert_to_entities == true) ? \htmlentities($match[3]) : $match[3];
                return $match[3];
            }
        }
        return null;
    }
}

    function rm_full_dir($sBasedir, $bPreserveBaseFolder = false)
    {
        $bRetval = true;
        $sPath = \rtrim($sBasedir, '\\\\/').'/';
        if (\is_readable($sPath)) {
            $oHandle = \opendir($sPath);
            while (false !== ($sFile = \readdir($oHandle))) {
                if (($sFile != '.') && ($sFile != '..')) {
                    $sFileName = $sPath . '/' . $sFile;
                    if (\is_dir($sFileName)) {
                        $bRetval = rm_full_dir($sFileName, false);
                    } else {
                        $bRetval = \unlink($sFileName);
                    }
                    if (!$bRetval) { break; }
                }
            }  // end while
            \closedir($oHandle);
            if (!$bPreserveBaseFolder && $bRetval) { $bRetval = \rmdir($sPath); }
        }
        return $bRetval;
    }


// Set correct permission rights - folder 0755, files 0644
    function fileList($startdir = './', $file = false, $bError = false){
        static $error = '';
        $ignoredDirectory = ['.', '..', 'unzip.php'];
        if (!empty($file)){
            $ignoredDirectory[] = $file;
        }
        if (\is_dir($startdir)){
            if ($dh = \opendir($startdir)){
                while(($file = \readdir($dh)) !== false)
                {
                    if (!(\array_search($file, $ignoredDirectory) > -1)){
                        if (\is_dir($startdir.$file.'/')){
                            $bError = fileList($startdir.$file.'/', 0, $bError);
                        }
                        $filetype = \filetype($startdir.$file);
                        if (($filetype == 'dir')){
                            if ($bError || (!$bError && (\chmod($startdir.$file, 0755) == false))){
                                $error .= 'Directory rights could not be set: '.$startdir.$file.'<br />';
                            }
                        }elseif (($filetype == 'file')){
                            if ($bError || (!$bError && (\chmod($startdir.$file, 0644) == false))){
                                $error .= 'File rights could not be set: '.$startdir.$file.'<br />';
                            }
                        }
                    }
                }
                \closedir($dh);
            }
        }
        return ($bError ? true : $error);
    }

    $deleteArchiveFile = (function ($bDelete=false, $sArchiveFile) use ($sAppPath,$sAppRel)
    {
        if ($bDelete && \unlink($sAppPath.$sArchiveFile))
        {
            $sRetval = \sprintf('<li class="w3-text-green w3-large">Installation archive %s successfully deleted</li>'.PHP_EOL,$sAppRel.$sArchiveFile);
        }else{
            $sMsg = ($bDelete ? 'could not be deleted' : 'prevent from deleting');
            $sRetval = \sprintf('<li class="w3-text-red w3-large">Archive %s %s</li>'.PHP_EOL,$sArchiveFile,$sMsg);
        }
        return $sRetval;
    });

    $deleteUnzip = (function ($bDelete=false) use($sAppPath) {
        if ($bDelete && \unlink($sAppPath.'unzip.php')){
            $sRetval = \sprintf('<li class="w3-text-green w3-large">Unzip file successfully deleted</li>'.PHP_EOL);
        }else{
            $sMsg = ($bDelete ? 'could not be deleted' : 'prevent from deleting');
            $sRetval = \sprintf('<li class="w3-text-red w3-large">Unzip file %s</li>'.PHP_EOL,$sMsg);
        }
        return $sRetval;
    });

    // Cross-platform use of the %e placeholder
    $getTimeFormat = (function($sFormat)
    {
      $sRetval = $sFormat;
// Check for Windows to replace the %e placeholder correctly
      if (\strtoupper(\substr(PHP_OS, 0, 3)) == 'WIN') {
          $format = \preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $sRetval);
      }
      return $sRetval;
    });

    $unzipArchive = (function($sFilename, $bUnzipEmptyFolders = true, $bUnzipEmptyFiles = true) use ($sAppPath,$sAppRel,$makeDir,$getTimeFormat,$bDebugMode)
    {
        $sError = '';
        $aError = [
              'numFiles' => 0,
              'files'    => 0,
              'folders'  => 0,
              'error'    => '',
        ];
        try {
            $oZip = new \ZipArchive();
            if ($oZip->open(\realpath($sFilename)))
            {
                $aError['numFiles'] = $oZip->count();
                for ($i=0; $i<$oZip->numFiles;$i++) {
                    $aItem = $oZip->statIndex($i);
                    $sItem = $aItem['name'];
                    $mTimeStamp = $aItem['mtime'];
                    $isDir = ((\substr($sItem, -1) === '/') ? true : false);
                    $sDestination = $sAppPath.$sItem;
                    if ($isDir){
                      if (!$makeDir($sAppPath.$sItem)){
                          $sError = \sprintf('Folder could not be processed: %s', \basename($sItem));
                          throw new \ErrorException ($sError);
                      }
                      \touch($sAppPath.$sItem,$aItem['mtime']);
                      $aError['folders']++;
                    } else {
//                  Returns the entry contents using its index
                        $sContent = ($oZip->getFromIndex($i) ?? 'Error loading Content');
                        if (\file_put_contents($sDestination, $sContent) === false)
                        {
                          $sError = \sprintf('File could not be processed: %s', \basename($sItem));
                        }
                        $aError['files']++;
                    }
                    \touch($sAppPath.$sItem,$aItem['mtime']);
                } // for
            } else // open
            {
                $sError = \sprintf('File could not be processed: %s', \basename($sFilename));
                throw new \ErrorException ($sError);
            }
    } catch(\ErrorException $ex){
        /* place to insert different error/logfile messages */
        $aError['error'] = '$scontent = '.$ex->getMessage();
    }
    $oZip->close();
    return $aError;
    });


    $isWrongArchive = (function($sFilename) use ($sAppPath)
    {
        $mList  = null;
        $sError = '';
        $aError = [
              'numFiles' => 0,
              'files'    => 0,
              'folders'  => 0,
              'error'    => '',
        ];
        try {
            $oZip = new \ZipArchive();
            if ($oZip->open(\realpath($sFilename)))
            {
                $aError['numFiles'] = $oZip->count();
                for ($i=0; $i<$oZip->numFiles;$i++) {
                    $aItem = $oZip->statIndex($i);
                    $sItem = $aItem['name'];
                    if ($sItem == 'info.php'){
                        $sData = ($oZip->getFromIndex($i) ?? 'Error loading Content');
                        $module_name   = get_variable_content ('module_name', $sData);
                        $template_name = get_variable_content ('template_name', $sData);
                        $mList = ($module_name ?? ($template_name ?? null));
                        break;
                    }
                }
            }
        } catch(\ErrorException $ex){
            /* place to insert different error/logfile messages */
            $aError['error'] = '$scontent = '.$ex->getMessage();
        }
        $oZip->close();
        return $mList;
    });

    $sExtractArchive = (function($bEmptyFolders=false, $bEmptyFiles=false) use ($sAppPath, $sAppRel, $sZipPattern, $deleteArchiveFile,$bDeleteArchive,$bDebugMode,$unzipArchive,$aInputs,$aArchiveFiles,$isWrongArchive){
      $sRetval = '';
      if (is_array($aInputs) && count($aInputs))
      {
// Search and load the first zip archive
        if ((count($aArchiveFiles) > 0))
        {
            foreach($aArchiveFiles as $sArchiveFile)
            {
                \chdir($sAppPath);
// Extract the archive
                $mList = $isWrongArchive($sAppPath.$sArchiveFile);
                if (is_null($mList))
                {
// first delete files an folder with camelcase values (windows) conflicts with unix filesystem, new are mostly lower case
                $aFilesToDelete = [
//                    '/include/Paragonie/',
                    '/include/',
//                    '/include/Sensio/'
                ];
                foreach ($aFilesToDelete as $sFilename){
                    if (\is_writeable($sAppPath.$sFilename)) {
                        if (\substr($sFilename, -1) == '/'){
                            rm_full_dir($sAppPath.$sFilename);
                        } else {
                            \unlink($sAppPath.$sFilename);
                        }
                    }
                } // end foreach

                    $aUnzip = $unzipArchive($sAppPath.$sArchiveFile, $bEmptyFolders, $bEmptyFiles);
                    if (empty($aUnzip['error'])){
                        $sRetval .= \sprintf('<li class="w3-text-green w3-large">%d files/folders from %s were successfully unpacked'.PHP_EOL,$aUnzip['numFiles'], $sArchiveFile);
                    }else{
                        $sRetval .= \sprintf('<li class="w3-text-red w3-large">Errors %d have occurred:'.PHP_EOL,$aUnzip['error']);
                    }
                    $sRetval .= '<ul class="w3-ul">'.PHP_EOL;
// Set permission rights
                    $permission_rights = fileList('./', $sArchiveFile,0,!empty($aUnzip['error']));
                    if (empty($permission_rights)){
                        $sRetval .= \sprintf('<li class="w3-text-green w3-large">File and directory rights completely set</li>'.PHP_EOL);
                    }else{
                        $sRetval .= \sprintf('<li class="w3-text-red w3-large">Errors have occurred::%s</li>'.PHP_EOL,$permission_rights);
                    }
                    $sRetval .= '</ul>'.PHP_EOL;
/* Delete zip archive */
                    $sRetval .= $deleteArchiveFile($bDeleteArchive,$sArchiveFile);
//              $sRetval .= '</li>'.PHP_EOL;
                } // end of isWrongArchive
                else {
                        $sRetval .= \sprintf('<li class="w3-text-red w3-large">Can\' unzip %s package, please install by WB Installer</li>'."\n", $mList);
                }
            } // foreach Archivfile
        } else {
            $sRetval .=  \sprintf('<li class="w3-text-red w3-large">No existing archivefile found in %s </li>'.PHP_EOL, $sAppRel);
        }
    }
    return $sRetval;
    }); // end of function $sExtractArchive

    if ($bStartUnzip){

// extract archive files
        $output .= $sExtractArchive($bUnzipEmptyFolders, $bUnzipEmptyFiles);
        if (!empty($aInputs) && \is_array($aInputs) && count($aInputs)){
            $output .= $deleteUnzip($bDeleteUnzip);
        }
    }

    $iRuningTime = (\microtime(true) - $iStartTime);
    $sExecutionTime = \sprintf('Execution time %.3f sec', $iRuningTime).\PHP_EOL;
    $sEndTime = \sprintf('End unzip at %s ',\strftime('%Y-%m-%d - %H:%M:%S', \time())).\PHP_EOL;

?><!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="utf-8" />
        <meta name="referrer" content="no-referrer|same-origin"/>
        <title>Unzip Script For Zip Archives</title>
        <meta name="author" content="WebsiteBaker Org e.V." />
<!-- Mobile viewport optimisation -->
        <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=2" />
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"/>
<style>
html { height:100%; }
body { min-height:101%; }
/*-------------------------------------------------------------------------------*/

/*-------------------------------------------------------------------------------*/
input[type="checkbox"].w3-check, input[type="radio"].w3-radio {-webkit-appearance: none;-moz-appearance: none!important;appearance: none;}

input[type="checkbox"].w3-check, input[type="radio"].w3-radio {width: 24px !important;height: 24px !important;position: relative !important;top: 8px !important;background-color: #0404A9 !important;}
input[type="checkbox"].w3-check:not(:checked), input[type="radio"].w3-radio:not(:checked) {background-color: #D6D6D6 !important;z-index: 1!important;}
input[type="checkbox"].w3-check:checked + .w3-validate, input.w3-radio[type="radio"]:checked + .w3-validate {color: #3D73A8 !important;font-weight: bold !important;}
input[type="checkbox"].w3-check:checked {border: 2px #0404A9 !important;color: #0404A9 !important;}
input[type="checkbox"].w3-check {z-index: -9999 !important;}
input[type="checkbox"].w3-check + label::before {content: "\00a0" !important;display: inline-block !important;font: 12px/1.15em sans-serif !important;font-weight: bold;}
input[type="checkbox"].w3-check + label::before {border: 1px solid #959595 !important;border-radius: 0px !important;height: 24px !important;width: 24px !important;margin: 0 .5em 0 -2.5em !important;padding: 0 !important;padding: 4px !important;}
input[type="checkbox"].w3-check:checked + label::before {background: #217DA1 !important;color: #fff !important;content: "\2713" !important;text-align: center !important;border-color: #217DA1 !important;}
label, label.w3-validate {font-weight: bold !important;color: #959595;}
input[type="checkbox"].w3-check + label > span::after{content: "";}
input[type="checkbox"].w3-check:checked + label > span::after{content: "";}

.w3-select-stripped option {min-height: 24px;}
.w3-select-stripped option:hover {background-color: #FBFBE3!important;}
.w3-select-stripped option:nth-child(2n){background-color: #EAEAEA;}

.progress-bar-striped {
                overflow: hidden;
                height: 40px;
                margin-bottom: 20px;
                background-color: #f5f5f5;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
                -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
                box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            }
            .progress-bar-striped > div {
                background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
                background-size: 40px 40px;
                float: left;
                width: 0%;
                height: 100%;
                font-size: 12px;
                line-height: 2.1;
                color: #ffffff;
                text-align: center;
                -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
                -moz-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
                box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
                -webkit-transition: width 3s ease;
                -moz-transition: width 3s ease;
                -o-transition: width 3s ease;
                transition: width 3s ease;
                animation: progress-bar-stripes 2s linear infinite;
                background-color: #288ade;
            }
            .progress-bar-striped p{
                margin: 0;
            }

            @keyframes progress-bar-stripes {
                0% {
                    background-position: 40px 0;
                }
                100% {
                    background-position: 0 0;
                }
            }

/*-------------------------------------------------------------------------------*/
</style>
    </head>
    <body class="w3-sand">
      <main class="w3-margin-bottom" style="margin-top:50px;">
          <div class="w3-white w3-container w3-card-4 w3-margin w3-border" style="width:70%;margin: auto 15%!important;padding: 0!important;">
              <div class="w3-row w3-card-4 ">
                <header class="w3-container w3-blue w3-padding-large">
                  <h3><?= $sStartTime; ?> unzip to <?= $sAppRel;?></h3>
                </header>
              </div>
<?php
/* var dump
if ($bStartUnzip){ }
print '<pre  class="mod-pre rounded">function <span>'.__FUNCTION__.'( '.''.' );</span>  filename: <span>'.\basename(__FILE__).'</span>  line: '.__LINE__.' -> <br />';
\print_r( $aInputs ); print '</pre>'.PHP_EOL; \flush (); // htmlspecialchars() ob_flush();;sleep(10); die();
 */
?>
              <div class="w3-container w3-padding">
                  <h2 class="w3-text-teal w3-xxlarge w3-margin-0">Settings PHP Version (<?= PHP_VERSION;?> )</h2>
                  <form id="form-unzip" action="<?= $sAppRel;?>unzip.php" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="extract" value="1" />
                      <div class="w3-row">
                          <label class="w3-quarter" style="vertical-align: top;">Select Zipfiles to extract</label>
                          <select multiple="multiple" id="aFiles" name="aFiles[]" class="w3-select w3-select-stripped w3-margin-left w3-border w3-twothird w3-select-multi" size="4" style="height: 6.9em!important;">
<?php
      if ((count($aZipFiles))) {
          $select = ((count($aZipFiles)==1) ? ' selected="selected"' : '');
          foreach($aZipFiles as $item){
            if (is_readable(__DIR__).'/'.$item){
                $mTime = ' from '.date ("d F Y - h:i A", filemtime(__DIR__.'/'.$item));
            }
?>
                              <option value="<?= $item;?>"<?= $select;?> ><?= $item.$mTime;?></option>
<?php     }
      } else { ?>
                              <option value="" style="font-size: 18px!important;color: red;">No Archivefile found!</option>
<?php } ?>
                          </select>
                      </div>
                      <div class="w3-row">
                          <label class="w3-text-gray"><b class="w3-large">&nbsp;</b> </label>
                          <input type="checkbox" id="empty_folder" value="1" name="empty_folder" class="w3-check" <?= $sUnzipCheckFolders;?> />
                          <label class="w3-validate w3-large" title="" for="empty_folder">Unpack Empty Folders<span class="">&nbsp;</span></label>
                      </div>
                      <div class="w3-row">
                          <label class="w3-text-gray"><b class="w3-large">&nbsp;</b> </label>
                          <input type="checkbox" id="empty_files" value="1" name="empty_files" class="w3-check"<?= $sUnzipCheckFiles;?>/>
                          <label class="w3-validate w3-large" title="" for="empty_files">Unpack Empty Files<span class="">&nbsp;</span></label>
                      </div>
                      <div class="w3-row">
                          <label class="w3-text-gray"><b class="w3-large">&nbsp;</b> </label>
                          <input type="checkbox" id="delete_archive" value="1" name="delete_archive" class="w3-check"<?= $sCheckArchive;?>/>
                          <label class="w3-validate w3-large" title="" for="delete_archive">Delete Archive Files<span class="">&nbsp;</span></label>
                      </div>
                      <div class="w3-row">
                          <label class="w3-text-gray"><b class="w3-large">&nbsp;</b> </label>
                          <input type="checkbox" id="delete_unzip" value="1" name="delete_unzip" class="w3-check"<?= $sCheckUnzip;?>/>
                          <label class="w3-validate w3-large" title="" for="delete_unzip">Delete Unzip File<span class="">&nbsp;</span></label>
                      </div>
                      <div class="w3-row w3-hide">
                          <label class="w3-text-gray"><b class="w3-large">&nbsp;</b> </label>
                          <input type="checkbox" id="debug_mode" value="1" name="debug_mode" class="w3-check"<?= $sCheckDebug;?>/>
                          <label class="w3-validate w3-large" title="" for="debug_mode">Debug Mode Without Extracting Archive Files- <span class="">&nbsp;</span></label>
                      </div>
                      <div class="w3-row-padding w3-section w3-stretch">
                          <div class="w3-half">
                              <button id="start_unzip" name="start_unzip" type="submit" class=" w3-large w3-input w3-btn w3-blue w3-padding w3-hover-green w3-margin-top" value="1" style="min-width: 10em;">Start Unzip</button>
                          </div>
                          <div class="w3-half">
                              <button formaction="<?= $sAppRel;?>unzip.php" formmethod="post" id="start_reset" name="start_reset" type="reset" class=" w3-large w3-input w3-btn w3-blue w3-padding w3-hover-red w3-margin-top" style="min-width: 10em;">Reset</button>
                          </div>
                      </div>
                  </form>
              </div>

              <div class="w3-container w3-padding">
                <div id="ProgressBar" class="progress-bar-striped w3-hide">
                    <div style="width: 100%;"><b><p class="w3-text-white w3-large w3-padding-0">Extracting Archive(s)</p></b></div>
                </div>
                <ol class="w3-ul">
                  <?= $output; ?>
                </ol>
                <h3 class="w3-large"><?= $sExecutionTime; ?></h3>
              </div>
          <div class="w3-row w3-card-4">
              <footer class="w3-container w3-blue" style="height: 80px;">
                 <div class="w3-row">
                    <div class="w3-half">
                      <h3 class="w3-xlarge w3-padding"><?= $sEndTime; ?></h3>
                    </div>
                    <div class="w3-half">
<?php if (is_readable($sAppPath.'/admin')){ ?>
                      <div class="w3-right">
                          <h3 class="w3-large w3-text-white w3-padding"><a class="w3-btn w3-card w3-light-blue w3-hover-green w3-large" href="<?= $sAcpRel;?>" rel="noopener"><span class="w3-padding w3-xlarge">&#x2699;</span><span style="vertical-align: text-bottom;"> Backend</span></a></h3>
<?php }else { ?>
                      <div class="w3-right">
                          <h3 class="w3-large w3-text-white w3-padding">Error::Missing Backend Login <?= $sAcpRel;?></h3>
<?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </footer>
          </div>
      </main>
      <div class="w3-container w3-margin-top">
          <div class="w3-row">
              <p style="text-align: center;margin-bottom: 10px;">©&nbsp;<?= date('Y');?> WebsiteBaker Org e.V.
              <a href="https://www.websitebaker.org/" style="font-weight: normal;" target="_blank" rel="noopener">WebsiteBaker</a> |
          </div>
      </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        function changeProgressbar(){
            var selectedValue = document.querySelector("#progress-value").value;
            document.querySelector(".progress-bar-striped > div").textContent = selectedValue + "%";
            document.querySelector(".progress-bar-striped > div").style.width = selectedValue + "%";
        }

        let unzipForm = document.getElementById('form-unzip');
        unzipForm.addEventListener (
            "submit",
            function (evt) {
//console.log(evt);
              let progress = document.getElementById('ProgressBar');
//console.log(progress);
              progress.classList.remove("w3-hide");
//                evt.preventDefault();
        });

        let fieldsreset = document.getElementById('start_reset');
        fieldsreset.addEventListener (
            "click",
            function (evt) {
//                deleteUnzip.checked = false;
//                deleteArchive.checked = false;
                let url = window.location.protocol +'//'+ window.location.host + window.location.pathname;
                window.location.href = url;
                evt.preventDefault();
        });

    });

</script>

    </body>
</html>