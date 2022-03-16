<?php
/**
 *
 * @category        framework
 * @package         backend login
 * @author          Ryan Djurovich, WebsiteBaker Project
 * @copyright       WebsiteBaker Org. e.V.
 * @link            https://websitebaker.org/
 * @license         https://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.12.2
 * @requirements    PHP 7.2 and higher
 * @version         $Id: Login.php 359 2019-05-26 18:52:50Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/framework/Login.php $
 * @lastmodified    $Date: 2019-05-26 20:52:50 +0200 (So, 26. Mai 2019) $
 *
 */

declare(strict_types = 1);

namespace bin;

use bin\{WbAdaptor,SecureTokens,Sanitize};
//use bin\helpers\{PreCheck,ParentList};
use vendor\phplib\Template;

// Get WB version
//require ADMIN_PATH.'/interface/version.php';
//    use includes;

class Login extends \admin {

    const IP4ADRESS = 0;
    const IP6ADRESS = 1;

//    const PASS_CHARS = '[\,w!#$%&*+\-.:=?@\|]';
    const PASS_CHARS = '[\x20-\x7E^<>]+$';
    const USER_CHARS = '[a-z0-9&\-.=@_]';

    protected $aConfig  = [];
//    protected $oDb      = null;
//    protected $oTrans   = null;
    protected $iAttemps = 0;

    public function __construct($config_array) {
        // Get language vars
/*        global $MESSAGE, $database; */
        parent::__construct();
        $bSuccess = false;

// Get configuration values
//        while(list($key, $value) = each($config_array)) {
          foreach ($config_array as $key => $value) {
//            $this->{(strtolower($key))} = $value;
            $this->aConfig[\strtolower($key)] = $value;
        }
        if (!isset($this->frontend)) { $this->frontend = false; }
        if (!isset($this->redirect_url)) { $this->redirect_url = ''; }

    // calculate redirect URL
    // begin new routine
        $sProtokol = ((!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off' ) ? 'http' : 'https') . '://';
        $sInstallFolderRel = \dirname(\dirname($this->oRequest->getServerVar('SCRIPT_NAME')));
        $sServerUrl = $sProtokol.$_SERVER['HTTP_HOST'].($_SERVER['SERVER_PORT'] == 80 ? '' : $_SERVER['SERVER_PORT'].':').'/'.$sInstallFolderRel;
    // end new routine

        // If the url is blank, set it to the default url
        $this->url = $this->get_post('url')?: $this->get_post('redirect')?:$this->default_url;
        if (\preg_match('/%0d|%0a|\s/i', $this->url)) {
            throw new \Exception('Warning: possible intruder detected on login');
        }

    // get username & password and validate it
        $username_fieldname = (string)$this->get_post('username_fieldname');
        $username_fieldname = (\preg_match('/^_?[a-z][\w]+$/i', $username_fieldname) ? $username_fieldname : 'username');
        $sUsername = \strtolower(\trim((string)$this->get_post($username_fieldname)));
        $this->username = (\preg_match(
            '/^'.self::USER_CHARS.'{'.$this->min_username_len.','.$this->max_username_len.'}$/is',
            $sUsername
        ) ? $sUsername : '');

        $password_fieldname = (string)$this->get_post('password_fieldname');
        $password_fieldname = (\preg_match('/^_?[a-z][\w]+$/i', $password_fieldname) ? $password_fieldname : 'password');
        if ($this->username) {
/** @TODO implement crypting */
            $this->password = \md5(((string)$this->get_post($password_fieldname)));
            // Figure out if the "remember me" option has been checked
            $this->remember = true;
#            $this->remember = (isset($_POST['remember'])&&($_POST['remember'] == 'true') ? true : false);
        // try to authenticate
            if (($bSuccess = $this->authenticate())) {
                // Authentication successful
                $this->send_header($this->url);
            } else {
                $this->message = $this->oTrans->MESSAGE_LOGIN_AUTHENTICATION_FAILED;
                $this->increase_attemps();
            }
        } else {
            $this->message = $this->oTrans->MESSAGE_LOGIN_BOTH_BLANK;
            $this->display_login();
        }
    }
    public function __isset($name)
    {
        return isset($this->aConfig[$name]);
    }

    public function __set($name, $value)
    {
         return $this->aConfig[$name] = $value;
    }

   public function __get ($name){
        $retval = null;
        if ($this->__isset($name)) {
            $retval = $this->aConfig[$name];
        }
        return $retval;
    }

    // Authenticate the user (check if they exist in the database)
    public function authenticate()
    {
        $bRetval = false;
        // Get user information
        $aSettings = [];
        $aSettings['SYSTEM_PERMISSIONS']   = [];
        $aSettings['MODULE_PERMISSIONS']   = [];
        $aSettings['TEMPLATE_PERMISSIONS'] = [];

            $loginname = ( \preg_match('/^'.self::USER_CHARS.'+$/s',$this->username) ? $this->username : '0');
            $sql = 'SELECT * FROM `'.TABLE_PREFIX.'users` '
                 . 'WHERE `username`=\''.$this->oDb->escapeString($loginname).'\'';
            if (($oUser = $this->oDb->query($sql)))
            {
                if (($aUser = $oUser->fetchRow(MYSQLI_ASSOC)))
                {
                    if (
                        $aUser['password'] == $this->password &&
                        $aUser['active'] == 1
                    ) {
                    // valide authentcation !!
                        $user_id                   = $aUser['user_id'];
                        $this->user_id             = $user_id;
                        $aSettings['USER_ID']      = $user_id;
                        $aSettings['GROUP_ID']     = $aUser['group_id'];
                        $aSettings['GROUPS_ID']    = $aUser['groups_id'];
                        $aSettings['USERNAME']     = $aUser['username'];
                        $aSettings['DISPLAY_NAME'] = $aUser['display_name'];
                        $aSettings['EMAIL']        = $aUser['email'];
                        $aSettings['HOME_FOLDER']  = $aUser['home_folder'];
                        // Run remember function if needed
//                        $isAdmin = $this->ami_group_member($aSettings['GROUPS_ID']);
                        $isAdmin = in_array('1',explode(',',$aSettings['GROUPS_ID']));
//                        $bUserLogin = (\defined('USER_LOGIN') && (USER_LOGIN==true) ? true : false );
                        $bUserLogin  = (bool)$this->oReg->UserLogin; //
//                        $bFrontendLogin = (($bUserLogin==true) || $isAdmin);
                        $bFrontendLogin = (($bUserLogin==true) || $aSettings['USER_ID']== 1);
                        if ($bFrontendLogin)
                        {
//                            if($this->remember == true) { $this->remember($this->user_id); }
                            // Set language
                            if ($aUser['language'] != '') {
                                $aSettings['LANGUAGE'] = $aUser['language'];
                            }
                            // Set timezone
                            if ($aUser['timezone'] != '-72000') {
                                $aSettings['TIMEZONE'] = $aUser['timezone'];
                            } else {
                                // Set a session var so apps can tell user is using default tz
                                $aSettings['USE_DEFAULT_TIMEZONE'] = true;
                            }
                            // Set date format
                            if ($aUser['date_format'] != '') {
                                $aSettings['DATE_FORMAT'] = $aUser['date_format'];
                            } else {
                                // Set a session var so apps can tell user is using default date format
                                $aSettings['USE_DEFAULT_DATE_FORMAT'] = true;
                            }
                            // Set time format
                            if ($aUser['time_format'] != '') {
                                $aSettings['TIME_FORMAT'] = $aUser['time_format'];
                            } else {
                                // Set a session var so apps can tell user is using default time format
                                $aSettings['USE_DEFAULT_TIME_FORMAT'] = true;
                            }
                            // Get group information
                            $aSettings['GROUP_NAME'] = [];
                            //  && (sizeof($aGroupsIds) == 1);
                            $bOnlyAdminGroup = $this->ami_group_member('1');
                            $sql = 'SELECT * FROM `'.TABLE_PREFIX.'groups` '
                                 . 'WHERE `group_id` IN ('.$aUser['groups_id'].',0) '
                                 . 'ORDER BY `group_id`';
                            if (($oGroups = $this->oDb->query($sql))) {
                                while (($aGroup = $oGroups->fetchRow( MYSQLI_ASSOC ))) {
                                    $aSettings['GROUP_NAME'][$aGroup['group_id']] = $aGroup['name'];
                                // collect system_permissions (additively)
                                    $aSettings['SYSTEM_PERMISSIONS'] = \array_merge(
                                        $aSettings['SYSTEM_PERMISSIONS'],
                                        \explode(',', $aGroup['system_permissions'])
                                    );
                                // collect module_permission (subtractive)
                                    if (!\sizeof($aSettings['MODULE_PERMISSIONS'])) {
                                        $aSettings['MODULE_PERMISSIONS'] = \explode(',', $aGroup['module_permissions']);
                                    } else {
                                        $aSettings['MODULE_PERMISSIONS'] = \array_intersect(
                                            $aSettings['MODULE_PERMISSIONS'],
                                            \preg_split('/\s*[,;\|\+]/', $aGroup['module_permissions'], -1, PREG_SPLIT_NO_EMPTY)
                                        );
                                    }
                                // collect template_permission (subtractive)
                                    if (!\sizeof($aSettings['TEMPLATE_PERMISSIONS'])) {
                                        $aSettings['TEMPLATE_PERMISSIONS'] = \explode(',', $aGroup['template_permissions']);
                                    } else {
                                        $aSettings['TEMPLATE_PERMISSIONS'] = \array_intersect(
                                            $aSettings['TEMPLATE_PERMISSIONS'],
                                            \preg_split('/\s*[,;\|\+]/', $aGroup['template_permissions'], -1, PREG_SPLIT_NO_EMPTY)
                                        );
                                    }
                                }
                            }
                            // Update the users table with current ip and timestamp
                            $sRemoteAddress = self::ObfuscateIp();
                            $sql = 'UPDATE `'.TABLE_PREFIX.'users` '
                                 . 'SET `login_when`='.\time().', '
                                 .     '`login_ip`=\''.$sRemoteAddress.'\' '
                                 . 'WHERE `user_id`=\''.$user_id.'\'';
                            $this->oDb->query($sql);
                            $bRetval = true;
                        } else {
                          $aSettings = [];
                        }
                    }
                }
            }
            // merge settings into $_SESSION and overwrite older one values
            $_SESSION = \array_merge($_SESSION, $aSettings);
        // Return if the user exists or not
        return $bRetval;
    }

    public function getMessage ( ) {
      return $this->message;
    }

    // Function to set a "remembering" cookie for the user - removed
   protected function remember($user_id)
    {
        return true;
    }

    // Function to check if a user has been remembered - removed
    protected function is_remembered()
    {
        return false;
    }

    protected function increase_attemps()
    {
        // get the session var, sanitize it and store it into local storage
        $this->iAttemps = intval($this->get_session('ATTEMPS'));
        // increment the local storage and assign the result to the session var
        $_SESSION['ATTEMPS'] = ++$this->iAttemps;
        $this->display_login();
    }
    // Display the backend login screen
    protected function display_login($bShowOldstyle=true) {
        // Get language vars
        global $MESSAGE;
        global $MENU;
        global $TEXT;
        $oReg = WbAdaptor::getInstance();
        $Trans = $oReg->getTranslate();
        $oDb   = \database::getInstance();
        if (!\defined('VERSION')) {require (ADMIN_PATH.'/interface/version.php');}
        $ThemeName = (\defined('DEFAULT_THEME') ? DEFAULT_THEME : 'DefaultTheme');
        $Trans->enableAddon('templates\\'.$ThemeName);
        // If attemps more than allowed, warn the user
        if ($this->iAttemps > $this->max_attemps) {
            $this->warn();
        }
        // Show the backend login form
        if ($this->frontend != true) {
            // Setup template object, parse vars to it, then parse it
            $template = new Template(\dirname($this->correct_theme_source($this->template_file)));
            $template->set_file('page', $this->template_file);
            $template->set_block('page', 'mainBlock', 'main');

            $template->set_block('mainBlock', 'LoginBlockNoscript', 'LoginNoscript');
            $template->set_block('mainBlock', 'LoginBlockScript', 'LoginScript');
            $template->set_block('mainBlock', 'LoginBlockPanel', 'LoginPanel');
            $template->set_block('mainBlock', 'UnzipBlockPanel', 'UnzipBlock');
            $template->set_block('mainBlock', 'show_release_block', 'show_release');

            $template->set_var('DISPLAY_REMEMBER_ME', ($this->remember_me_option ? '' : 'display: none;'));
            $aSettings = ['website_title' => 'none','jquery_version'=> ''];
            $sql = 'SELECT * FROM `'.TABLE_PREFIX.'settings` '
                 . 'WHERE `name` IN (\'website_title\',\'jquery_version\',\'user_login\') ';
            if ($oSetting = $oDb->query($sql)) {
                while ( $aSetting = $oSetting->fetchRow(MYSQLI_ASSOC)){
                  $aSettings[$aSetting['name']] = $aSetting['value'];
                }
            }
            if ($oDb->is_error()){
                throw new \DatabaseException($oDb->get_error());
            }
            $jquery_version = (isset($aSettings['jquery_version']) && !empty(trim($aSettings['jquery_version'])) ? $aSettings['jquery_version'] : '2.2.4').'/';
            $bUserLogin = (bool)(($aSettings['user_login'] ?? true));
            $aArchiv = \glob(WB_PATH.'/*.zip');
            $bUnzipUrl = (\is_readable(WB_PATH.'/unzip.php') && count($aArchiv));
            $sActionUrl = ($bUnzipUrl ? WB_REL.'/unzip.php' : 'https://websitebaker.org/');
            $sTarget    = ((\is_readable(WB_PATH.'/unzip.php') && count($aArchiv)) ? "_self" : "_blank");
/*------------------------------------------------------------------------------------*/
            $sTemplateFunc = 'resolveTemplateImagesPath';
            $sImages       = $sTemplateFunc($this->oReg->Theme);
/*------------------------------------------------------------------------------------*/
            $aTplData = [
                'ACTION_URL' => $this->login_url,
                'ATTEMPS' => $this->get_session('ATTEMPS'),
                'USERNAME' => $this->username,
                'USERNAME_FIELDNAME' => $this->username_fieldname,
                'PASSWORD_FIELDNAME' => $this->password_fieldname,
                'MESSAGE' => $this->message,
                'INTERFACE_DIR_URL' =>  ADMIN_URL.'/interface',
                'MAX_USERNAME_LEN' => $this->max_username_len,
                'MAX_PASSWORD_LEN' => $this->max_password_len,
                'ADMIN_URL' => ADMIN_URL,
                'WB_URL' => WB_URL,
                'URL' => $this->redirect_url,
                'THEME_URL' => THEME_URL,
                'COLOR'     => ($bUserLogin ? 'header-blue-wb' : 'red'),
                'VERSION' => VERSION,
                'REVISION' => REVISION,
                'LANGUAGE' => \strtolower(LANGUAGE),
                'HELPER_URL' =>  WB_URL.'/framework/helpers',
                'JQUERY_VERSION'     => $jquery_version,
                'FORGOTTEN_DETAILS_APP' => $this->forgotten_details_app,
                'WEBSITE_TITLE'          => ($bUserLogin ? $aSettings['website_title'] : $TEXT['OF'].' '.$TEXT['ADMINISTRATORS'].' ('.$TEXT['MAINTENANCE_ON'].')'),
                'LOGIN_DISPLAY_HIDDEN'   => !$this->is_authenticated() ? 'hidden' : '',
                'LOGIN_DISPLAY_NONE'     => !$this->is_authenticated() ? 'none' : '',
                'LOGIN_LINK'             => $this->oRequest->getServerVar('SCRIPT_NAME'),
                'LOGIN_ICON'             => 'login',
                'START_ICON'             => 'blank',
                'URL_HELP'               => 'https://wiki.websitebaker.org/',
                'PAGES_DIRECTORY'        => PAGES_DIRECTORY,
                'TEXT_ADMINISTRATION'    => $TEXT['ADMINISTRATION'],
//                    'TEXT_FORGOTTEN_DETAILS' => $Trans->TEXT_FORGOTTEN_DETAILS,
                'TEXT_USERNAME' => $TEXT['USERNAME'],
                'TEXT_PASSWORD' => $TEXT['PASSWORD'],
                'TEXT_REMEMBER_ME' => $TEXT['REMEMBER_ME'],
                'TEXT_LOGIN' => $TEXT['LOGIN'],
                'TEXT_SAVE' => $TEXT['SAVE'],
                'TEXT_RESET' => $TEXT['RESET'],
                'TEXT_HOME' => $TEXT['HOME'],
                'SECTION_LOGIN' => $MENU['LOGIN'],
                'IMAGES' => $sImages,
                'UNZIP_URL'    => $sActionUrl,
                'DISPLAY_COLOR' => ($bUnzipUrl ? 'EFFF01' : 'FFF'), //62FC01
                'TARGET' => $sTarget,
                ];

            $sFtan = \bin\SecureTokens::getFTAN();
            $template->set_ftan($sFtan);

            $template->set_var($aTplData);
            $aLang = $Trans->getLangArray();
            $template->set_var($aLang);
            $template->set_var('CHARSET', (\defined('DEFAULT_CHARSET') ? DEFAULT_CHARSET : 'utf-8'));
            if ($bShowOldstyle){
                $template->parse('LoginNoscript', 'LoginBlockNoscript', true);
                $template->set_block('LoginBlockPanel', '');
                $template->set_block('LoginBlockScript', '');
            } else {
                $template->parse('LoginPanel', 'LoginBlockPanel', true);
                $template->parse('LoginScript', 'LoginBlockScript', true);
                $template->set_block('LoginBlockNoscript', '');
            }
            if ($bUnzipUrl){
                $template->parse('UnzipBlock', 'UnzipBlockPanel', true);
                $template->set_block('show_release_block', '');
            } else {
                $template->parse('show_release', 'show_release_block', true);
                $template->set_block('UnzipBlockPanel', '');
            }
            $template->parse('main', 'mainBlock', false);
            $template->pparse('output', 'page');
        }
    }

// get the client IP address
      static public function get_client_ip() {
          $ipaddress = '';
          if (\getenv('HTTP_CLIENT_IP'))
              $ipaddress = \getenv('HTTP_CLIENT_IP');
          else if (\getenv('HTTP_X_FORWARDED_FOR'))
              $ipaddress = \getenv('HTTP_X_FORWARDED_FOR');
          else if (\getenv('HTTP_X_FORWARDED'))
              $ipaddress = \getenv('HTTP_X_FORWARDED');
          else if (\getenv('HTTP_FORWARDED_FOR'))
              $ipaddress = \getenv('HTTP_FORWARDED_FOR');
          else if (\getenv('HTTP_FORWARDED'))
             $ipaddress = \getenv('HTTP_FORWARDED');
          else if (\getenv('REMOTE_ADDR'))
              $ipaddress = \getenv('REMOTE_ADDR');
          else
              $ipaddress = '000.000.000.000';
          return $ipaddress;
      }

/**
 * hidden last two blocks from user ip
 *
 * @return string
 */
     static public function ObfuscateIp()
     {
        $sIp = self::get_client_ip();
        $sClientIp = \filter_var($sIp, FILTER_VALIDATE_IP);
/*
        if (\strpos($sClientIp, '.') == true) {
            $iClientIp = \ip2long($sClientIp);
            $sClientIp = \long2ip(($iClientIp & ~65535));
        } else {
            $sClientIp = \preg_replace(['/\.\d*$/','/[\da-f]*:[\da-f]*$/'],['.000','XXXX:XXXX'],$sClientIp);
        }
*/
        return $sClientIp;
    }


    // sanities the REMEMBER_KEY cookie to avoid SQL injection
    protected function get_safe_remember_key()
    {
        $iMatches = 0;
        if (isset($_COOKIE['REMEMBER_KEY'])) {
            $sRetval = \preg_replace('/^([0-9]{11})_([0-9a-f]{11})$/i', '\1\2', $_COOKIE['REMEMBER_KEY'], -1, $iMatches);
        }
        return ($iMatches ? $sRetval : '');
    }

    // Warn user that they have had to many login attemps
    protected function warn()
    {
//      header('Location: '.$this->warning_url);
        $this->send_header($this->warning_url);
        exit;
    }

}// end class Login
