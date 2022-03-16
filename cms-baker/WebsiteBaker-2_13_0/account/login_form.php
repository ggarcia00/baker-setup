<?php
/**
 *
 * @category        frontend
 * @package         account
 * @author          WebsiteBaker Project
 * @copyright       Ryan Djurovich
 * @copyright       Website Baker Org. e.V.
 * @link            https://websitebaker.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.10.1
 * @requirements    PHP 5.6.0 and higher
 * @version         $Id: login_form.php 346 2019-05-07 13:42:36Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/account/login_form.php $
 * @lastmodified    $Date: 2019-05-07 15:42:36 +0200 (Di, 07. Mai 2019) $
 *
 */
//declare(strict_types = 1);
//declare(encoding = 'UTF-8');

//namespace ;

use bin\{WbAdaptor,Login,SecureTokens,Sanitize};
use bin\helpers\{PreCheck,Parentlist};
use vendor\phplib\Template;

/*--------------------------------------------------------------------------------*/
// Must include code to stop this file being access directly
if (!\defined('SYSTEM_RUN')) {\header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; \flush(); exit;}
/*--------------------------------------------------------------------------------*/
    if (!isset($wb) || (isset($wb) && !($wb instanceof \frontend))) {$wb = new \frontend();}
    $oReg     = WbAdaptor::getInstance();
    $database = $oReg->getDatabase();
    $oTrans   = $oReg->getTranslate();
    $oRequest = $oReg->getRequester();
//    $wb       = $oReg->getApplication();

    $username_fieldname = 'username';
    $password_fieldname = 'password';
    if (defined('SMART_LOGIN') && SMART_LOGIN == 'true') {
        $sTmp = '_'.substr(md5(microtime()), -8);
        $username_fieldname .= $sTmp;
        $password_fieldname .= $sTmp;
    }
    if (!isset($page_id)){
        $page_id = (isset($thisApp->page_id) ? $thisApp->page_id : $_SESSION['PAGE_ID']);
    }
    $thisApp->redirect_url = (isset($thisApp->redirect_url) && ($thisApp->redirect_url!='')  ? $thisApp->redirect_url : $_SESSION['HTTP_REFERER'] );
    $action = $oRequest->getParam('action', FILTER_SANITIZE_STRING);

/*--------------------------------------------------------------------------------*/
    $error    = [];
    $aSuccess  = [];
    $aMessage = [];
//  load module default language file (EN)
    $sAddonName = basename(__DIR__);
    $oTrans = Translate::getInstance();
    $oTrans->enableAddon('\\account');
/*--------------------------------------------------------------------------------*/
//  load gdpr/dsgvo settings from db or ini file (found in your frontend template root)
    if (!$sSettings = \bin\helpers\ParentList::gdprSettings()){
        $sInifile     = '/templates/'.TEMPLATE.'/DataProtection.ini.php';
        $sIniUserfile = '/templates/'.TEMPLATE.'/DataUserProtection.ini.php';
        if (is_readable(WB_PATH .$sIniUserfile)){
            $sInifile = $sIniUserfile;
        }
        if (is_readable(WB_PATH .$sInifile)){
            $aTmp = \parse_ini_file(WB_PATH .$sInifile, true, INI_SCANNER_TYPED);
            $aSettings = $aTmp['dsgvo'];
         }
    } else {
      $aSettings = \bin\helpers\ParentList::unserialize($sSettings);
    }
/*--------------------------------------------------------------------------------*/
    $action =($action ?? 'show');
    $_SESSION['display_form'] = ($action=='show');
    if ($action=='send') {
        $search  = ['{SERVER_EMAIL}'];
        $replace = [SERVER_EMAIL];
/*--------------------------------------------------------------------------------*/
//  Captcha
//$MESSAGE['LOGIN_BOTH_BLANK']
// $_SESSION['ATTEMPS']
// $MESSAGE['LOGIN_BOTH_BLANK']
        $_SESSION['ATTEMPS'] = ($_SESSION['ATTEMPS'] ?? 0);
        if ($_SESSION['ATTEMPS']){
            $error[] = sprintf($oTrans->MESSAGE_LOGIN_FAILED);
        }
        if ($wb->bit_isset(ENABLED_CAPTCHA,2)){
            $aSuR = [
                '{SERVER_EMAIL}' => SERVER_EMAIL,
            ];
            $sOut = str_replace(array_keys($aSuR), $aSuR,  $oTrans->MESSAGE_MOD_FORM_INCORRECT_CAPTCHA);
//          $oTrans->MESSAGE_MOD_FORM_INCORRECT_CAPTCHA = $sOut;
            $sCaptcha = $oRequest->getParam('captcha',FILTER_SANITIZE_STRING);
            if (isset($sCaptcha) && $sCaptcha != ''){
                // Check for a mismatch
                if (!isset($sCaptcha) || !isset($_SESSION['captcha']) || ($sCaptcha != $_SESSION['captcha'])) {
                    $error[] = $sOut."\n";
                }
            } else {
                    $error[] = $sOut."\n";
            }
        $_SESSION['display_form'] = true;
        }
        if (isset($_SESSION['captcha'])) { unset($_SESSION['captcha']); }
/*--------------------------------------------------------------------------------*/
//    if ($aSettings['use_data_protection']) {
        $data_protection = $oRequest->getParam('data_protection',FILTER_SANITIZE_STRING);
        if ($wb->bit_isset($aSettings['use_data_protection'],2)) {
            if (isset($data_protection) && ($data_protection != '')){
            } else {
               $error[] = $oTrans->MESSAGE_DSGVO_ERROR;
            }
        }
        $_SESSION['display_form'] = true;
    }
/*--------------------------------------------------------------------------------*/
    $sTemplate  = 'login_form.htt';
/*--------------------------------------------------------------------------------*/
// looking for template in frontend templates  otherwise set from account templates folder
    \header("X-Robots-Tag: noindex", true);
    $sTemplatePath = WB_PATH.'/account/templates/';
    $sTemplateURL  = str_replace(['\\','//'],'/',WB_REL.'/account/templates');
    if (file_exists(WB_PATH .'/templates/'.TEMPLATE.'/templates/'.$sTemplate)) {
       $sTemplatePath = WB_PATH .'/templates/'.TEMPLATE.'/templates/';
       $sTemplateURL  = str_replace(['\\','//'],'/',WB_REL.'/templates/'.TEMPLATE.'/templates');
    }
/*--------------------------------------------------------------------------------*/
    $template = new Template($sTemplatePath);
    $template->set_file('page', $sTemplate);
    $template->set_block('page', 'main_block', 'main');
    $template->set_block('main_block', 'display_form_block', 'display_form');
    $template->set_var($oTrans->getLangArray());
/*--------------------------------------------------------------------------------*/
    $template->set_var('MESSAGE_TITLE', $oTrans->MESSAGE_LOGIN_BOTH_BLANK);
    $template->set_var('FORM_TYPE', 'login');
    $template->set_var('LOGIN_URL', WB_URL.'/account/login.php');
    $template->set_var('WB_URL', WB_URL);
    $template->set_var('DATA_TEMPLATE', $sTemplateURL);
    $template->set_var('PAGE_ID', $page_id);
    $template->set_var('URL', $thisApp->redirect_url);
    $template->set_var('REDIRECT', $thisApp->redirect_url);
    $template->set_var('HTTP_REFERER', $thisApp->redirect_url);
    $template->set_var('ADMIN_URL', ADMIN_URL );
    $template->set_var('MESSAGE', $thisApp->getMessage());
    $template->set_var('USERNAME_FIELDNAME', $username_fieldname);
    $template->set_var('PASSWORD_FIELDNAME', $password_fieldname);
    $template->set_ftan(\bin\SecureTokens::getFTAN());
/*--------------------------------------------------------------------------------*/
    $template->set_block('main_block', 'back_block', 'back');
    $template->set_block('back_block', '');
/*
    if (!empty($thisApp->redirect_url)){
        $template->set_var('REDIRECT', $thisApp->redirect_url);
        $template->set_var('REDIRECT_URL', $thisApp->redirect_url);
        $template->set_var('TEXT_BACK', $oTrans->TEXT_BACK);
        $template->parse('back', 'back_block', true);
    } else {
        $template->set_block('back_block', '');
    }
*/
/*--------------------------------------------------------------------------------*/
    $template->set_block('display_form_block', 'success_block', 'success');
    if (count($aSuccess)>0){
        $template->set_block('success_block', 'success_list_block', 'success_list');
        foreach($aSuccess as $value){
            $template->set_var('SUCCESS_MESSAGE', PreCheck::xnl2br($value));
            $template->parse('success_list', 'success_list_block', true);
        }
        $template->parse('success', 'success_block', true);
    } else {
        $template->set_block('success_block', '');
    }
/*--------------------------------------------------------------------------------*/
    $template->set_block('display_form_block', 'error_block', 'error');
    if ($_SESSION['display_form']){
        if (count($error) > 0){
        $template->set_block('error_block', 'error_list_block', 'error_list');
            foreach($error as $value) {
                $template->set_var('ERROR_MESSAGE', $value);
                $template->parse('error_list', 'error_list_block', true);
            }
            $template->parse('error', 'error_block', true);
        } else {
            $template->set_block('error_block', '');
        }
/*--------------------------------------------------------------------------------*/
        $template->set_block('display_form_block', 'heading_block', 'heading');
        $template->set_block('heading_block', '');
/*--------------------------------------------------------------------------------*/
    //  add some honeypot-fields
        $iNow = time(); $_SESSION['submitted_when']=$iNow;
        $template->set_block('display_form_block', 'honeypot_block', 'honeypot');
        if (ENABLED_ASP) {
            $template->set_var('SESSION_SUBMITTED_WHEN', $iNow);
            $template->parse('honeypot', 'honeypot_block', true);
        } else {
            $template->set_block('honeypot_block', '');
        }
/*--------------------------------------------------------------------------------*/
//  Captcha
        $template->set_block('display_form_block', 'display_captcha_block', 'display_captcha');
        if ($wb->bit_isset(ENABLED_CAPTCHA,2)){
        //  load captcha script first if captcha is enabled
            if (!function_exists('captcha_header')) {require(WB_PATH.'/include/captcha/captcha.php');}
        //  declared some default settings
            $aCaptachs['ct_color'] = 1;
            if ($oCaptcha = $database->query('SELECT * FROM `'.TABLE_PREFIX.'mod_captcha_control` ')){
                $aCaptachs = $oCaptcha->fetchRow(MYSQLI_ASSOC);
            }
            $template->set_var('CALL_CAPTCHA', call_captcha('all','','',false,$aCaptachs['ct_color']));
            $template->parse('display_captcha', 'display_captcha_block', false);
        } else{
            $template->set_block('display_captcha_block', '');
        }
/*--------------------------------------------------------------------------------*/
        $template->set_block('display_form_block', 'use_data_protection_block', 'use_data_protection');
        if ($wb->bit_isset($aSettings['use_data_protection'],2)) {
        //  $target_section_id = $aSettings[LANGUAGE];
        //  $target_section_id = $aSettings['data_protection_link'];
            $sDataLink = \bin\helpers\ParentList::getDsgvoDefaultLink();
            $template->set_var('CALL_DSGVO_LINK',sprintf($oTrans->MESSAGE_DSGVO, $sDataLink));
            $template->parse('use_data_protection', 'use_data_protection_block', false);
        } else{
            $template->set_block('use_data_protection_block', '');
        }
/*--------------------------------------------------------------------------------*/
        $template->set_block('display_form_block', 'display_extra_link_block', 'display_extra_link');
        $template->parse('display_extra_link', 'display_extra_link_block', true);
//        $template->set_block('display_extra_link_block', '');
/*--------------------------------------------------------------------------------*/
        $template->parse('display_form', 'display_form_block', true);
    } else {
        $template->set_block('display_form_block', '');
    }
/*--------------------------------------------------------------------------------*/
//  Parse template for preferences form
    $template->parse('main', 'main_block', false);
    $template->pparse('output', 'page');
/*--------------------------------------------------------------------------------*/
