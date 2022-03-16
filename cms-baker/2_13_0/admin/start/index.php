<?php
/**
 *
 * @category        admin
 * @package         start
 * @author          WebsiteBaker Project
 * @copyright       Ryan Djurovich
 * @copyright       WebsiteBaker Org. e.V.
 * @link            http://websitebaker.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.12.2
 * @requirements    PHP 7.2.6 and higher
 * @version         $Id: index.php 141 2018-10-03 19:01:52Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/admin/start/index.php $
 * @lastmodified    $Date: 2018-10-03 21:01:52 +0200 (Mi, 03. Okt 2018) $
 *
*/

use vendor\phplib\Template;

    $ds         = DIRECTORY_SEPARATOR;
    $sAddonFile   = str_replace('\\','/',__FILE__).'/';
    $sAddonPath   = \dirname($sAddonFile).'/';
    $sModulesPath = \dirname($sAddonPath).'/';
    $sModuleDir   = basename($sModulesPath);
    $sAddonName   = basename($sAddonPath);
    $sAddonRel    = '/'.$sModuleDir.'/'.$sAddonName;
    $sPattern = "/^(.*?\/)".$sModuleDir."\/.*$/";
    $sAppPath = preg_replace ($sPattern, "$1", $sAddonPath, 1 );
    if (!defined('SYSTEM_RUN') && is_readable($sAppPath.'config.php')) {require($sAppPath.'config.php');}
    if (!defined('TABLE_PREFIX')){
    /*
     * Remark:  HTTP/1.1 requires a qualified URI incl. the scheme, name
     * of the host and absolute path as the argument of location. Some, but
     * not all clients will accept relative URIs also.
     */
        $_SERVER['REQUEST_SCHEME'] = ($_SERVER['REQUEST_SCHEME'] ?? 'http');
        $host       = $_SERVER['HTTP_HOST'];
        $sDocRoot   = ($_SERVER["PATH_TRANSLATED"] ?? $_SERVER["DOCUMENT_ROOT"]);
        $uri        = ((basename($sAppPath)==basename($sDocRoot))  ? '' : '/'.basename($sAppPath));//
        $file       = '/install/index.php';
        $target_url = $_SERVER['REQUEST_SCHEME'].'://'.$host.$uri.''.$file;
        $sResponse  = $_SERVER['SERVER_PROTOCOL'].' 307 Temporary Redirect';
        \header($sResponse);
        \header('Location: '.$target_url);
        exit;    // make sure that subsequent code will not be executed
    }

//$admin = new \admin('##skip##');
    $admin = new \admin('Start','start');
// ---------------------------------------
    if (\defined('FINALIZE_SETUP')) {
        $sql = 'DELETE FROM `'.TABLE_PREFIX.'settings` WHERE `name`=\'finalize_setup\'';
        if ($database->query($sql)) {unset($sql);}
    }
// ---------------------------------------
    $msg  = '<br />';
    $sUpgradeFile = '/install/upgrade-script.php';
// check if it is neccessary to start the uograde-script
    if (($admin->get_user_id()=='1') && \is_readable(WB_PATH.$sUpgradeFile)) {
        // check if it is neccessary to start the uograde-script
        $oldVersion = '';
        $newVersion = '';

        if (!defined('WB_REVISION')){define('WB_REVISION', '999');}
        $oldVersion  = \trim(''.WB_VERSION.'+'.WB_REVISION.'+'.(\defined('WB_SP') ? WB_SP : ''), '+');
        $newVersion  = \trim(''.VERSION.'+'.REVISION.'+'.(\defined('SP') ? SP : ''), '+');
        $sUpdateFile = ADMIN_PATH.'/interface/update';
        $mustUpgrade = is_readable($sUpdateFile);
        if ((\version_compare($oldVersion, $newVersion, '<') === true ) || $mustUpgrade) {
            if (!\headers_sent()) {
                \header('Location: '.WB_URL.$sUpgradeFile);
                exit;
            } else {
                echo "<p style=\"text-align:center;margin-top:26px;\"> The <strong>upgrade script</strong> could not start automatically.\n" .
                     "Please click <a style=\"font-weight:bold;\" " .
                     "href=\"".WB_URL.$sUpgradeFile."\">on this link</a> to start the script!</p>\n";
                // Print admin footer
                $admin->print_footer();
                exit;
            }
        }
    }
/**
 * delete stored ip adresses default after 30 days
 */
    $iSecsPerDay = 86400;
    $iTotalDays  = 30;
    $sql = 'UPDATE `'.TABLE_PREFIX.'users` SET `login_ip` = \'\' WHERE `login_when` < '.(time()-($iSecsPerDay*$iTotalDays));
    if ($database->query($sql)) {
    }

// Setup template object, parse vars to it, then parse it
    $oLang = Translate::getInstance();
    $oLang->enableAddon('templates/'.DEFAULT_THEME);
// Create new template object
    $template = new Template(dirname($admin->correct_theme_source('start.htt')));
    $template->set_file('page', 'start.htt');
    $template->set_block('page', 'main_block', 'main');

// Insert values into the template object
    $aDefaultData = [
              'WELCOME_MESSAGE' => $oLang->MESSAGE_START_WELCOME_MESSAGE,
              'CURRENT_USER' => $oLang->MESSAGE_START_CURRENT_USER,
              'DISPLAY_NAME' => $admin->get_display_name(),
              'ADMIN_URL' => ADMIN_URL,
              'WB_URL' => WB_URL,
              'THEME_URL' => THEME_URL,
              'WB_VERSION' => WB_VERSION,
              'START_LIST' => ' '
          ];

    $template->set_var($aDefaultData);

// Insert permission values into the template object
    $get_permission = (function($type='preferences', $ParentBlock='main_block') use ($admin, $template){
        $bRetVal = false;
        $sBlock  = '';
        $template->set_block($ParentBlock, 'show_'.$type.'_block', 'show_'.$type);
        if (($admin->get_permission($type) != true) && ($type!='preferences')) {
            $sBlock = 'show_'.$type;
            $template->set_block($sBlock, '');
        } else {
            $sBlock = "show_$type"."_block";
            $template->parse('show_'.$type, 'show_'.$type.'_block', true);
            $bRetVal = true;
        }
        return $bRetVal;
    });
/**/
    $get_permission ('pages');
    $get_permission ('media');
    $get_permission ('addons');
    $get_permission ('preferences');
    $get_permission ('settings');
    $get_permission ('admintools');
    $get_permission ('access');

//$msg .= (file_exists(WB_PATH.'/install/')) ?  $MESSAGE['START_INSTALL_DIR_EXISTS'] : $msg;
    $template->set_var('DISPLAY_WARNING', 'display:none;');
// Check if installation directory still exists
    if (\is_readable(WB_PATH.'/install/upgrade-script.php') ) {
// Check if user is part of Adminstrators group / better be a Systemadministrator
//      if ($admin->ami_group_member(1)){
        if ($admin->get_user_id() == 1) {
            $template->set_var('WARNING', $msg );
        } else {
            $template->set_var('DISPLAY_WARNING', 'display:none;');
        }
    } else {
        $template->set_var('DISPLAY_WARNING', 'display:none;');
    }

// Insert "Add-ons" section overview (pretty complex compared to normal)
    $addons_overview = $TEXT['MANAGE'].' ';
    $addons_count = 0;
    if($admin->get_permission('modules') == true)
    {
        $addons_overview .= '<a class="wb-bold" href="'.ADMIN_URL.'/modules/index.php">'.$oLang->MENU_MODULES.'</a>';
        $addons_count = 1;
    }
    if($admin->get_permission('templates') == true)
    {
        if($addons_count == 1) { $addons_overview .= ', '; }
        $addons_overview .= '<a class="wb-bold" href="'.ADMIN_URL.'/templates/index.php">'.$oLang->MENU_TEMPLATES.'</a>';
        $addons_count = 1;
    }
    if($admin->get_permission('languages') == true)
    {
        if($addons_count == 1) { $addons_overview .= ', '; }
        $addons_overview .= '<a class="wb-bold" href="'.ADMIN_URL.'/languages/index.php">'.$oLang->MENU_LANGUAGES.'</a>';
    }

// Insert "Access" section overview (pretty complex compared to normal)
    $access_overview = $TEXT['MANAGE'].' ';
    $access_count = 0;
    if($admin->get_permission('users') == true) {
        $access_overview .= '<a class="wb-bold" href="'.ADMIN_URL.'/users/index.php">'.$oLang->MENU_USERS.'</a>';
        $access_count = 1;
    }
    if($admin->get_permission('groups') == true) {
        if($access_count == 1) { $access_overview .= ', '; }
        $access_overview .= '<a class="wb-bold" href="'.ADMIN_URL.'/groups/index.php">'.$oLang->MENU_GROUPS.'</a>';
        $access_count = 1;
    }

// Insert section names and descriptions
    $template->set_var(array(
                    'PAGES' => $oLang->MENU_PAGES,
                    'MEDIA' => $oLang->MENU_MEDIA,
                    'ADDONS' => $oLang->MENU_ADDONS,
                    'ACCESS' => $oLang->MENU_ACCESS,
                    'PREFERENCES' => $oLang->MENU_PREFERENCES,
                    'SETTINGS' => $oLang->MENU_SETTINGS,
                    'ADMINTOOLS' => $oLang->MENU_ADMINTOOLS,
                    'HOME_OVERVIEW' => $oLang->OVERVIEW_START,
                    'PAGES_OVERVIEW' => $oLang->OVERVIEW_PAGES,
                    'MEDIA_OVERVIEW' => $oLang->OVERVIEW_MEDIA,
                    'ADDONS_OVERVIEW' => $addons_overview,
                    'ACCESS_OVERVIEW' => $access_overview,
                    'PREFERENCES_OVERVIEW' => $oLang->OVERVIEW_PREFERENCES,
                    'SETTINGS_OVERVIEW' => $oLang->OVERVIEW_SETTINGS,
                    'ADMINTOOLS_OVERVIEW' => $oLang->OVERVIEW_ADMINTOOLS
                )
            );

// Parse template object
    $template->parse('main', 'main_block', false);
    $template->pparse('output', 'page');

// Print admin footer
$admin->print_footer();
