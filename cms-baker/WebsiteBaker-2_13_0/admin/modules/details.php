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
 * Description of detail
 *
 * @package      Core package
 * @copyright    Manuela v.d.Decken <manuela@isteam.de>
 * @author       Manuela v.d.Decken <manuela@isteam.de>
 * @license      GNU General Public License 2.0
 * @version      0.0.1
 * @revision     $Id: details.php 66 2018-09-17 15:48:07Z Luisehahne $
 * @since        File available since 04.11.2017
 * @deprecated   no / since 0000/00/00
 * @description  xxx
 */
//declare(strict_types = 1);
//declare(encoding = 'UTF-8');

use bin\{WbAdaptor,SecureTokens,Sanitize};
use bin\helpers\{PreCheck};
use vendor\phplib\Template;
use bin\requester\HttpRequester;

// Include config file and admin class file
if (!defined( 'SYSTEM_RUN')){ require( dirname(dirname((__DIR__))).'/config.php' ); }
// Include the WB functions file
//if (!function_exists('make_dir')){require(WB_PATH.'/framework/functions.php');}

    // register addon vars
    $sAddonType   =  'module';
    $sAddonAppDir = '/modules/';

    $admin = new admin('Addons', $sAddonType.'s_view', true);

    $oTrans->enableAddon(ADMIN_DIRECTORY.'\\addons');
    $aTrans = $oTrans->getLangArray();

// get request method
    $oRequest = (object) filter_input_array(
        (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ? INPUT_POST : INPUT_GET),
        FILTER_UNSAFE_RAW
    );

try {

    $show_block = isset($oRequest->advanced)&&(int)$oRequest->advanced;
    $sAddonBackUrl  = ADMIN_URL.'/'.basename(__DIR__).'/index.php'.($show_block?'?advanced='.$show_block:'');
    if (!\bin\SecureTokens::checkFTAN()){
        throw new \Exception($oTrans->MESSAGE_GENERIC_SECURITY_ACCESS);
    }

// Get addon name
    $sAddonDir    = '';
    $sAddonName   = '';

    if (!isset($oRequest->file) || $oRequest->file == false) {
        throw new \Exception($oTrans->MESSAGE_GENERIC_FORGOT_OPTIONS);
    } else {
        $iAddonId = \bin\SecureTokens::checkIDKEY($oRequest->file);
    }
    if ($iAddonId === 0){
        throw new \Exception($oTrans->MESSAGE_GENERIC_SECURITY_ACCESS);
    }

// Get addon directory
    $sqlAddons = 'SELECT `directory` FROM `'.TABLE_PREFIX.'addons` '
               . 'WHERE `addon_id`='.(int)$iAddonId.' ';
    if (($sAddonDir = $database->get_one($sqlAddons))) {
        $sAddonDir = preg_replace('/[^a-z0-9_-]/i', "", $sAddonDir);  // fix secunia 2010-92-2
    }
    $sAddonInfoFile = WB_PATH.$sAddonAppDir.$sAddonDir.'/info.php';

// Check if the add-on exists
    if (!file_exists(WB_PATH.$sAddonAppDir.$sAddonDir)) {
        throw new \Exception($sAddonAppDir.$sAddonDir."\n".$oTrans->MESSAGE_GENERIC_NOT_INSTALLED);
    }

// Setup template object, parse vars to it, then parse it
// Create new template object
    $template = new Template(dirname($admin->correct_theme_source($sAddonType.'s_details.htt')));
// $template->debug = true;
    $template->set_file('page', $sAddonType.'s_details.htt');
    $template->set_block('page', 'main_block', 'main');

// Insert values
    $sql = 'SELECT * FROM `'.TABLE_PREFIX.'addons` '
    .'WHERE `type` = \''.$sAddonType.'\' '
    .'AND `directory` = \''.$sAddonDir.'\'';
    if ($oAddon = $database->query($sql)) {
        $aAddon = $oAddon->fetchRow(MYSQLI_ASSOC);
    }

// check if a addon description exists for the displayed backend language
    $tool_description = false;
    if (function_exists('file_get_contents') && file_exists(WB_PATH.$sAddonAppDir.$sAddonDir.'/languages/'.LANGUAGE .'.php')) {
        // read contents of the addon language file into string
        $data = file_get_contents(WB_PATH .$sAddonAppDir .$sAddonDir .'/languages/' .LANGUAGE .'.php');
        // use regular expressions to fetch the content of the variable from the string
        $tool_description = get_variable_content($sAddonType.'_description', $data, false, false);
        // replace optional placeholder {WB_URL} with value stored in config.php
        if($tool_description !== false && strlen(trim($tool_description)) != 0) {
            $tool_description = str_replace('{WB_URL}', WB_URL, $tool_description);
        } else {
            $tool_description = false;
        }
    }

   if($tool_description !== false) {
        // Override the addon-description with correct desription in users language
        $aAddon['description'] = $tool_description;
    }

    $template->set_var(array(
              'ADMIN_URL' => ADMIN_URL,
              'WB_URL' => WB_URL,
              'THEME_URL' => THEME_URL,
              'AddonBackUrl' => $sAddonBackUrl,
          )
    );

    $sType = ($aAddon['function']?:$aAddon['type']);
    $sTypeMsg = $oTrans->{'TEXT_' . strtoupper($sType)};

    $template->set_var(array(
              'NAME' => $aAddon['name'],
              'TYPE' => $sTypeMsg,
              'AUTHOR' => $aAddon['author'],
              'DESCRIPTION' => $aAddon['description'],
              'VERSION' => $aAddon['version'],
              'DESIGNED_FOR' => $aAddon['platform'],
          )
    );

// Insert language text and messages
    $template->set_var($aTrans);
// Parse addon object
    $template->parse('main', 'main_block', false);
    $template->pparse('output', 'page');

}catch (\Exception $ex) {
    $sErrMsg = PreCheck::xnl2br(sprintf('[%d] %s', $ex->getLine(), $ex->getMessage()));
    $admin->print_error ($sErrMsg, $sAddonBackUrl);
    exit;
}

// Print admin footer
$admin->print_footer();
