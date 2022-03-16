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
 * Description of admin/login/index.php
 *
 * @package      Core
 * @copyright    Manuela v.d.Decken <manuela@isteam.de>
 * @author       Manuela v.d.Decken <manuela@isteam.de>
 * @license      GNU General Public License 2.0
 * @version      2.0.1
 * @revision     $Id: index.php 142 2018-10-03 19:03:49Z Luisehahne $
 * @since        File available since 04.10.2017
 * @deprecated   no
 * @description  xxx
 */
//declare(strict_types = 1);
//declare(encoding = 'UTF-8');

namespace Acp\login;


use bin\{WbAdaptor,Login,wb,SecureTokens,Sanitize};


    $sAddonPath   = str_replace('\\','/',__DIR__).'/';
    $sModulesPath = \dirname($sAddonPath).'/';
    $sModuleDir   = basename($sModulesPath);
    $sAddonName   = basename($sAddonPath);
    $sAddonRel     = '/'.$sModuleDir.'/'.$sAddonName;
    // \basename(__DIR__).'/'.\basename(__FILE__);
    $sPattern = "/^(.*?\/)".$sModuleDir."\/.*$/";
    $sAppPath = preg_replace ($sPattern, "$1", $sModulesPath, 1 );
    // comment if you have to load config.php
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

    $username_fieldname = 'username';
    $password_fieldname = 'password';
    if (\defined('SMART_LOGIN') && SMART_LOGIN == 'true') {
        $sTmp = '_'.\substr(md5(microtime()), -8);
        $username_fieldname .= $sTmp;
        $password_fieldname .= $sTmp;
    }
// ---------------------------------------
if (\defined('FINALIZE_SETUP')) {
    $sql = 'DELETE FROM `'.TABLE_PREFIX.'settings` WHERE `name`=\'finalize_setup\'';
    if ($database->query($sql)) {unset($sql);}
}
// ---------------------------------------

    $admin = new \frontend();
    $aSettings = ['website_title' => 'none','jquery_version'=> ''];
    $sql = 'SELECT * FROM `'.TABLE_PREFIX.'settings` '
         . 'WHERE `name` IN (\'website_title\',\'jquery_version\') ';
    if ($oSetting = $database->query($sql)) {
        while ( $aSetting = $oSetting->fetchRow(MYSQLI_ASSOC)){
          $aSettings[$aSetting['name']] = $aSetting['value'];
        }
    }
    if ($database->is_error()){
        throw new \DatabaseException($database->get_error());
    }
    $jquery_version = (isset($aSettings['jquery_version']) && !empty(\trim($aSettings['jquery_version'])) ? $aSettings['jquery_version'] : '1.12.4').'/';
// Setup template object, parse vars to it, then parse it
    $WarnUrl = \str_replace(WB_PATH,WB_URL,$admin->correct_theme_source('warning.html'));
    $LoginTpl = 'login.htt';
    $ThemePath = \dirname($admin->correct_theme_source($LoginTpl));

    $thisApp = new Login( [
            'MAX_ATTEMPS'           => 3,
            'WARNING_URL'           => $WarnUrl,
            'USERNAME_FIELDNAME'    => $username_fieldname,
            'PASSWORD_FIELDNAME'    => $password_fieldname,
            'REMEMBER_ME_OPTION'    => SMART_LOGIN,
            'MIN_USERNAME_LEN'      => 2,
            'MIN_PASSWORD_LEN'      => 3,
            'MAX_USERNAME_LEN'      => 100,
            'MAX_PASSWORD_LEN'      => 100,
            'WB_URL'                => WB_URL,
            'ADMIN_URL'             => ADMIN_URL,
            'THEME_URL'             => THEME_URL,
            'HELPER_URL'            =>  WB_URL.'/framework/helpers',
            'JQUERY_VERSION'        => $jquery_version,
//            'LOGIN_URL'             => "\Acp\login\index.php",
            'LOGIN_URL'             => ADMIN_URL."/login/index.php",
            'DEFAULT_URL'           => ADMIN_URL."/start/index.php",
//            'REDIRECT_URL'          => ADMIN_URL."/pages/index.php",
            'TEMPLATE_DIR'          => $ThemePath,
            'TEMPLATE_FILE'         => $LoginTpl,
            'FRONTEND'              => false,
            'FORGOTTEN_DETAILS_APP' => ADMIN_URL."/login/forgot/index.php",
            'USERS_TABLE'           => TABLE_PREFIX."users",
            'GROUPS_TABLE'          => TABLE_PREFIX."groups",
        ]
    );
