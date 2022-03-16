<?php
/**
 *
 * @category        frontend
 * @package         account
 * @author          WebsiteBaker Project
 * @copyright       Ryan Djurovich
 * @copyright       WebsiteBaker Org. e.V.
 * @link            https://websitebaker.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.10.1
 * @requirements    PHP 5.3.6 and higher
 * @version         $Id: preferences_form.php 352 2019-05-13 12:34:35Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/account/preferences_form.php $
 * @lastmodified    $Date: 2019-05-13 14:34:35 +0200 (Mo, 13. Mai 2019) $
 *
 */


use bin\{WbAdaptor,Login,SecureTokens,Sanitize};
use bin\helpers\{PreCheck,Parentlist};
use vendor\phplib\Template;


// prevent this file from being accesses directly
if (!\defined('SYSTEM_RUN')) {\header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; \flush(); exit;}
    $sCallingScript = WB_URL;
    $oReg     = WbAdaptor::getInstance();
    $database = $oReg->getDatabase();
    $oTrans   = $oReg->getTranslate();
    $oRequest = $oReg->getRequester();
    $oApp     = $oReg->getApplication();
    $redirect_url = (isset($_SESSION['HTTP_REFERER']) && ($_SESSION['HTTP_REFERER'] != '') ? $_SESSION['HTTP_REFERER'] : $sCallingScript );
    $redirect_url = (isset($redirect) && ($redirect!='') ? $redirect : $redirect_url);
    if ($oApp->is_authenticated() === false) {
// User needs to login first
        \header("Location: ".WB_URL."/account/login.php?redirect=".$oApp->link);
        exit(0);
    }
// load module default language file (EN)
    $sAddonName = basename(__DIR__);
    $oTrans = Translate::getInstance();
    $oTrans->enableAddon('\\account');
    $sHeading = "";
    $user_time = true;
    $error = [];
    $aSuccess = [];

    $sTemplate  = 'preferences_form.htt';
    $sTemplatePath = WB_PATH.'/account/templates/';
    $sTemplateURL  = str_replace(['\\','//'],'/',WB_REL.'/account/templates');
/* */
    if (file_exists(WB_PATH .'/templates/'.TEMPLATE.'/templates/'.$sTemplate)) {
       $sTemplatePath = WB_PATH .'/templates/'.TEMPLATE.'/templates';
       $sTemplateURL  = str_replace(['\\','//'],'/',WB_REL.'/templates/'.TEMPLATE.'/templates');
    }

    $template = new Template($sTemplatePath);
    $action = $oRequest->getParam('action');
    switch($action):
        case 'details':
            require_once(WB_PATH .'/account/details.php');
            break;
        case 'email':
            require_once(WB_PATH .'/account/email.php');
            break;
        case 'password':
            require_once(WB_PATH .'/account/password.php');
            break;
        default:
            // do nothing
    endswitch; // switch

// show template
    $template->set_file('page', $sTemplate);
    $template->set_block('page', 'main_block', 'main');

    $template->set_var($oTrans->getLangArray());
    $template->set_ftan(SecureTokens::getFTAN());

// get existing values from database
    $sql  = 'SELECT `display_name`,`username`,`email`,`timezone`,`date_format`,`time_format`,`language` '
          . 'FROM `'.TABLE_PREFIX.'users` '
          . 'WHERE `user_id` = '.(int)$oApp->get_user_id();
    $oUsers = $database->query($sql);
    if($database->is_error()) { $error[] = $database->get_error(); }
    $aUser = $oUsers->fetchRow(MYSQLI_ASSOC);

    $sDefaultString = ' '.$oTrans->TEXT_SYSTEM_DEFAULT;
    $sSelected      = ' selected="selected"';
// insert values into form
    $template->set_var('USERNAME', $aUser['username']);
    $template->set_var('DISPLAY_NAME', $aUser['display_name']);
    $template->set_var('EMAIL', $aUser['email']);
    $template->set_var('ACTION_URL', '#');
    $template->set_var('ADMIN_URL',    ADMIN_URL);
    $template->set_var('THEME_URL',    THEME_URL);
    $template->set_var('TEMPLATE_URL', TEMPLATE_DIR);
    $template->set_var('DATA_TEMPLATE', $sTemplateURL);
// read available languages from table addons and assign it to the template
    $sql  = 'SELECT * FROM `'.TABLE_PREFIX.'addons` '
          . 'WHERE `type` = \'language\' ORDER BY `directory`';
    if( $oLang = $database->query($sql) ) {
        $template->set_block('main_block', 'language_list_block', 'language_list');
        $template->set_var('IMAGE_URL', $oReg->AppUrl.'modules/WbLingual/');
        while( $aLang = $oLang->fetchRow(MYSQLI_ASSOC) )
        {
            $langIcons = (empty($aLang['directory'])) ? 'none' : strtolower($aLang['directory']);
            $template->set_var('CODE',          $aLang['directory']);
            $template->set_var('LANG_NAME',     $aLang['name']);
            $template->set_var('FLAG',          $langIcons);
            $template->set_var('LANG_SELECTED', ($aUser['language'] == $aLang['directory'] ? ' selected="selected"' : '') );
            $template->parse('language_list', 'language_list_block', true);
        }
    }

/* ------------------------------------------------------------------------ */
    $user_time = true;
    $sSelected = ' selected="selected"';
/* ------------------------------------------------------------------------ */
// Insert default timezone values
    $template->set_block('main_block', 'timezone_list_block', 'timezone_list');
    $userTimezone = $aUser['timezone'];
    if (!isset($TIMEZONES)){require(ADMIN_PATH.'/interface/timezones.php');}
    $mActualTimezone = (($oReg->DefaultTimezone === $aUser['timezone']) ? 'system_default' : (int)$oApp->get_timezone());
    foreach( $TIMEZONES as $hour_offset => $title )
    {
        $mTmpOffset = (is_numeric($hour_offset) ? $hour_offset*3600 : $hour_offset);
        $isSelected = (($mTmpOffset === $mActualTimezone) ? $sSelected : '');
//        echo nl2br(sprintf("%s===%s ist %s %s\n",$mTmpOffset,$mActualTimezone,(($mTmpOffset === $mActualTimezone) ? 'wahr' : 'falsch'),$isSelected));
        $template->set_var('ZONE_NAME',     $title);
        $template->set_var('ZONE_VALUE',    $hour_offset);
        $template->set_var('ZONE_SELECTED', $isSelected);
        $template->parse('timezone_list', 'timezone_list_block', true);
    }

// Insert date format list
    $template->set_block('main_block', 'date_format_list_block', 'date_format_list');
    $userTimezone = $aUser['timezone'];
    if (!isset($DATE_FORMATS)){require ADMIN_PATH.'/interface/date_formats.php';}
    $sDateFormat = str_replace(' ', '|', $aUser['date_format']);
    $sDateFormat = (($oReg->DefaultDateFormat === $sDateFormat) ? 'system_default' : $sDateFormat);

    foreach($DATE_FORMATS as $format => $title) {
// workout to show date with setlocale
        $bSystemDateDefault = (($format === 'system_default') ? true : false);
        $sDateDefaultFormat = ($bSystemDateDefault ? 'system_default' : $format);
        $isSelected = (($sDateFormat === $format) ? $sSelected : '');
        $sDateTitleFormat = (PreCheck::dateFormatToStrftime(($bSystemDateDefault ? $oReg->DefaultDateFormat : $format)));
        $title       = (\strftime($sDateTitleFormat, \time()+ $iActualTimezone)).' ('.(($format == 'system_default') ? $TEXT['SYSTEM_DEFAULT'] : $format).')';

        $template->set_var('DATE_NAME', str_replace('|', ' ', $title));
        $template->set_var('DATE_VALUE', $sDateDefaultFormat);
        $template->set_var('DATE_SELECTED', $isSelected);
        $template->parse('date_format_list', 'date_format_list_block', true);
    }

// Insert time format list
    $template->set_block('main_block', 'time_format_list_block', 'time_format_list');
    $userTimezone = $aUser['timezone'];
    if (!isset($TIME_FORMATS)){require ADMIN_PATH.'/interface/time_formats.php';}

    $sTimeFormat = str_replace(' ', '|', $aUser['timezone']);
    $sTimeFormat = (($oReg->DefaultTimeFormat == $sTimeFormat) ? 'system_default' : $sTimeFormat);

    foreach($TIME_FORMATS as $format => $title) {

        $title = str_replace('|', ' ', $title);
        $bSystemTimeDefault = ($format == 'system_default') ? true : false;
        $format = (($bSystemDateDefault ? $oReg->DefaultDateFormat : $format));
        $sTimeSelected = (($aUser['time_format'] == $format) && ($aUser['time_format'] != DEFAULT_TIME_FORMAT) ? $sSelected : '');
        $sTimeSelected = ($bSystemTimeDefault && empty($format) && ($aUser['time_format'] == DEFAULT_TIME_FORMAT) ? $sSelected : $sTimeSelected);

        $template->set_var('TIME_NAME', $title);
        $template->set_var('TIME_VALUE', $format);
        $template->set_var('TIME_SELECTED', $sTimeSelected);
        $template->parse('time_format_list', 'time_format_list_block', true);
    }
/* ------------------------------------------------------------------------ */
// insert all translations
    $template->set_var($oTrans->getLangArray());
    $template->set_var('HTTP_REFERER', $redirect_url); //$_SESSION['HTTP_REFERER'],
// Insert error and/or success messages
    $template->set_block('main_block', 'error_block', 'error');
    $template->set_block('error_block', 'error_list_block', 'error_list');
    if(sizeof($error)>0){
        array_unshift ($error,$sHeading);
        foreach($error as $value){
            $template->set_var('ERROR_VALUE', $value);
            $template->parse('error_list', 'error_list_block', true);
        }
        $template->parse('error', 'error_block', true);
    } else {
      $template->set_block('error_block','');
    }
    $template->set_block('main_block', 'success_block', 'success');
    $template->set_block('success_block', 'success_list_block', 'success_list');
    if(sizeof($aSuccess)!=0){
        array_unshift ($aSuccess,$sHeading);
        foreach($aSuccess as $value){
            $template->set_var('SUCCESS_VALUE', $value);
            $template->parse('success_list', 'success_list_block', true);
        }
        $template->parse('success', 'success_block', true);
    } else {
      $template->set_block('success_block','');
    }
// Parse template for preferences form
    $template->parse('main', 'main_block', false);
    $template->pparse('output', 'page');
