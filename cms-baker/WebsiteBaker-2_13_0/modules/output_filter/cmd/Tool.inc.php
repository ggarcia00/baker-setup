<?php
/**
 *
 * @category        modules
 * @package         output_filter
 * @copyright       WebsiteBaker Org. e.V.
 * @author          Christian Sommer
 * @author          Dietmar Wöllbrink
 * @author          Manuela v.d.Decken <manuela@isteam.de>
 * @link            http://websitebaker.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.3
 * @requirements    PHP 5.3.6 and higher
 * @version         $Id: cmdTool.inc 113 2018-09-28 11:34:16Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/tags/2.12.1/modules/output_filter/cmd/cmdTool.inc $
 * @lastmodified    $Date: 2018-09-28 13:34:16 +0200 (Fr, 28 Sep 2018) $
 *
 */

use bin\{WbAdaptor,SecureTokens,Sanitize};
use vendor\phplib\Template;

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!\defined('SYSTEM_RUN')) {\header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; \flush(); exit;}
/* -------------------------------------------------------- */
        $sAddonPath  = str_replace(DIRECTORY_SEPARATOR,'/',dirname(__DIR__));
        $sAddonName  = \basename($sAddonPath);
        $oReg = WbAdaptor::getInstance();
        $oRequest = $oReg->getRequester();
        $database = $oReg->getDatabase();
        $oTrans   = $oReg->getTranslate();
        $sLangFileTheme = (($oReg->Theme=='DefaultTheme') ? 'default' : $oReg->Theme);

        if (is_readable($sAddonPath.'/themes/'.$sLangFileTheme)) {
            $oTrans->enableAddon('modules\\'.$sAddonName.'\\themes\\'.(($oReg->Theme=='DefaultTheme') ? 'default' : $oReg->Theme));
        }elseif (is_readable($sAddonPath.'/languages')){
            $oTrans->enableAddon('modules\\'.$sAddonName);
        }

        $debugMessage = '';
        $msgCls  = 'sand';
        $sActionUrl = ADMIN_URL.'/admintools/tool.php';
        $ToolQuery  = '?tool='.$sAddonName;
        $ToolRel    = '/admintools/tool.php'.$ToolQuery;
        $js_back    = $sActionUrl;
        $ToolUrl    = $sActionUrl.'?tool='.$sAddonName;
        $sAdminToolRel = ADMIN_DIRECTORY.'/admintools/index.php';
        $sAdminToolUrl = $oReg->AcpUrl.$sAdminToolRel;
        $sCallingScript = $oRequest->getServerVar('SCRIPT_NAME');
        $aRequestVars   = $oRequest->getParamNames();
        $sGetOldSecureToken = (\bin\SecureTokens::checkFTAN());
        $aFtan = \bin\SecureTokens::getFTAN();
        $sFtanQuery = $aFtan['name'].'='.$aFtan['value'];

        $TEXT_CUSTOM = (\in_array('SaveSettings',$aRequestVars) ? $oTrans->TEXT_BACK : $oTrans->TEXT_CLOSE);
        if (!$admin->get_permission($sAddonName,'module' ) ) {
            $admin->print_error($oTrans->MESSAGE_ADMIN_INSUFFICIENT_PRIVELLIGES, $js_back);
        }
        $aAliasFilterNames = ['Jquery' => 'jQuery','JqueryUI' => 'jQueryUI'];
        $SettingsDenied = [
            'at_replacement',
            'dot_replacement',
            'email_filter',
            'mailto_filter',
            'OutputFilterMode',
            'W3Css_force',
            'WbLink',
            'ReplaceSysvar',
            'CssToHead',
            'ShortUrl',
            'CleanUp',
            'FilterCleanUp',
            'Abstract',
            'FilterAbstract',
//            'SnippetCss',
//            'FrontendCss',
//            'SnippetBodyJs',
//            'FrontendBodyJs',
        ];

        if (\is_readable($sAddonPath.'/OutputFilterApi.php')) {
            if (!\function_exists('getOutputFilterSettings')) {
                require($sAddonPath.'/OutputFilterApi.php');
            }
        if (!isset($module_description) && \is_readable($sAddonPath.'/info.php')) {require $sAddonPath.'/info.php';}
// read settings from the database to show
        $aFilterSettings = getOutputFilterSettings();
/*  */
// extended defaultSettings for email filter
        $aEmailDefaults = [
                'at_replacement'  => '@',
                'dot_replacement' => '.',
                'email_filter'    => 0,
                'mailto_filter'   => 0
            ];

// extended defaultSettings for special filter
        $aExentedDefaults = [
                'at_replacement'   => '[at]',
                'dot_replacement'  => '[dot]',
                'email_filter'     => 0,
                'mailto_filter'    => 0,
                'OutputFilterMode' => 0,
                'W3Css_force'      => 0,
            ];

      $aDefaultSettings=[];
/*
        $aDefaultSettings = \array_diff_key( $aFilterSettings, $aExtendedSettings );
        $aExtendedSettings = $aExentedDefaults;
        $aExtendedSettings   = \array_intersect_key( $aFilterSettings, $aExentedDefaults );
        $aDefaultSettings = \array_merge( $aFilterSettings, $aExtendedSettings );
*/
        $aFiles = \glob($sAddonPath.'/Filters/*', \GLOB_NOSORT);
        array_walk(
            $aFiles,
            function (& $sItem, $iKey) use (& $aDefaultSettings) {
                $sItem = \str_replace(['%filter', '%'], '', '%'.\basename($sItem, '.php'));
                $aDefaultSettings[$sItem] = 0;
            }
        );
        $aDefaultSettings = \array_merge($aDefaultSettings, $aExentedDefaults );

        \ksort($aDefaultSettings, \SORT_NATURAL | \SORT_FLAG_CASE );
        $aAllowedFilters  = \array_keys ( $aDefaultSettings );
        $aFilterExists    = \array_diff ( $aAllowedFilters, $SettingsDenied );

// Create new Template object
        $oTpl = new Template( $sAddonThemePath );
        $oTpl->setDebug(0);
        $oTpl->set_file('page', 'tool.htt');
        $oTpl->set_block('page', 'main_block', 'main');
        $oTpl->set_block('main_block', 'headline_block', 'headline');
        $oTpl->set_var('FTAN_NAME', $aFtan['name']);
        $oTpl->set_var('FTAN_VALUE', $aFtan['value']);
        $oTpl->set_var('CUSTOM',$TEXT_CUSTOM);
        $oTpl->set_var('ADMIN_URL', $oReg->AcpUrl);
        $oTpl->set_var('MODULE_NAME', $sAddonName);
        $msgTxt = '';
        $msgTxt = $module_description;

        $oTpl->set_var('TOOL_NAME', $toolName);
        $oTpl->set_var('REQUEST_URI', $_SERVER['REQUEST_URI']);
        $oTpl->set_var('CANCEL_URL', ADMIN_DIRECTORY.'/admintools/index.php');
        $oTpl->set_var('TOOL_URL', $oReg->AcpUrl.'admintools/tool.php?tool='.$sAddonName);
        $oTpl->set_var('WB_URL', $oReg->AppUrl);
//        $oTpl->set_var($MESSAGE);
//        $oTpl->set_var($MOD_MAIL_FILTER);
        $oTpl->set_var($aoutput_filterLang);
// check if data was submitted
        if ($doSave) {
    // save changes
            $oTpl->parse('headline', 'headline_block', true);
            $oTpl->set_var('TOOL_URL', $oReg->AcpUrl.'admintools/tool.php?tool='.$sAddonName);
            $oTpl->set_var('CANCEL_URL',ADMIN_DIRECTORY.'/admintools/tool.php?tool='.$sAddonName);
            $oTpl->set_var('DISPLAY', 'none');
            include(__DIR__.'/Save.inc.php');
            $aFilterSettings = getOutputFilterSettings();
        } else {
            $oTpl->set_block('headline', '');
            $oTpl->set_var('CANCEL_URL', $sAdminToolRel);
            $oTpl->set_var('DISPLAY', 'block');
        }
        $oTpl->set_block('main_block', 'core_info_block', 'core_info');
        if( $debugMessage != '') {
            $oTpl->set_var('CORE_MSGTXT', $print_r);
            $oTpl->parse('core_info', 'core_info_block', true);
        } else {
            $oTpl->set_block('core_info_block', '');
        }

        $oTpl->set_block('main_block', 'info_message_block', 'info_message');
        $oTpl->set_block('main_block', 'success_message_block', 'success_message');
        if ($doSave) {
            $oTpl->set_block('info_message_block', '');
            if ($msgTxt != '') {
            // write message box if needed
                $oTpl->set_var('MSGTXT', $msgTxt); //$msgCls
                $oTpl->set_var('MSGCOLOR', $msgCls); //$msgCls
                $oTpl->parse('success_message', 'success_message_block', true);
            } else {
                $oTpl->set_block('success_message_block', '');
            }
        } else {
            $oTpl->set_block('success_message_block', '');
            if( $msgTxt != '') {
            // write message box if needed
                $oTpl->set_var('MSGTXT', $msgTxt);
                $oTpl->set_var('MSGCOLOR', $msgCls); //$msgCls
                $oTpl->parse('info_message', 'info_message_block', true);
            } else {
                $oTpl->set_block('info_message_block', '');
            }
       }

        $oTpl->set_block('main_block', 'submit_list_block', 'submit_list');
        $oTpl->set_var('MOD_MAIL_FILTER_WARNING', $oTrans->MOD_MAIL_FILTER_WARNING);
        $oTpl->set_var('TEXT_SAVE_LIST', $oTrans->TEXT_SAVE_LIST);
        $oTpl->set_var('TEXT_EMPTY_LIST', $oTrans->TEXT_EMPTY_LIST);
        $oTpl->set_block('submit_list_block', '');

        $oTpl->set_block('main_block', 'own_list_block', 'own_list');
        $oTpl->set_block('own_list_block', '');
        $aHiddenFilter = [
        'ScriptVars',
        'LoadOnFly',
        'Jquery',
        'SnippetJs',
        'FrontendJs',
        'SnippetBodyJs',
        'FrontendBodyJs',
        'SnippetCss',
        'FrontendCss',
        ];
        $oTpl->set_var($aFilterSettings);
        $oTpl->set_block('main_block', 'filter_block', 'filter_list');
        foreach($aFilterSettings as $sFilterName => $sFilterValue)
        {
            $sFilterAlias = ($aAliasFilterNames[$sFilterName] ?? $sFilterName);
            $sFilterAlias = (isset($aAliasFilterNames[$sFilterName]) ? $aAliasFilterNames[$sFilterName] : $sFilterName);
            $sHelpMsg = (isset($output_filter_help[$sFilterName])
                      ? ($output_filter_help[$sFilterName])
                      : $MOD_MAIL_FILTER['HELP_MISSING']);
            if (\in_array( $sFilterName, $SettingsDenied)) { continue; }
            $oTpl->set_var('TITLE', $sHelpMsg);
            $oTpl->set_var('FVALUE', $sFilterValue);
            $oTpl->set_var('FNAME', $sFilterName);
            $oTpl->set_var('RGMF', (in_array($sFilterName,$aHiddenFilter) ? 'register-mod-files' : ''));
            $oTpl->set_var('FALIAS', $sFilterAlias);
            $oTpl->set_var('FCHECKED', (($sFilterValue=='1') ? ' checked="checked"' : '') );
            $oTpl->parse('filter_list', 'filter_block', true);
        }

// enable/disable extended email filter settings
        $oTpl->set_block('main_block', 'filter_email_block', 'filter_emai');
        if (isset($aFilterSettings['Email']) && $aFilterSettings['Email']) {
            $oTpl->set_var('EMAIL_FILTER_CHECK',  (($aFilterSettings['email_filter']) ? ' checked="checked"' : '') );
            $oTpl->set_var('MAILTO_FILTER_CHECK', (($aFilterSettings['mailto_filter']) ? ' checked="checked"' : '') );
            $oTpl->parse('filter_emai', 'filter_email_block', true);
        } else {
//            $oTpl->set_block('filter_email_block', '');
            $oTpl->set_var('EMAIL_FILTER_CHECK',  (($aEmailDefaults['email_filter']) ? ' checked="checked"' : ''));
            $oTpl->set_var('MAILTO_FILTER_CHECK', (($aEmailDefaults['mailto_filter']) ? ' checked="checked"' : ''));
        }
//        $oTpl->set_block('main_block', 'filter_email_block', 'filter_email');
        if (isset($aFilterSettings['W3Css']) && $aFilterSettings['W3Css']) {
            $oTpl->set_var('W3Css_force_FILTER_CHECK',  (($aFilterSettings['W3Css_force']) ? ' checked="checked"' : '') );
//            $oTpl->parse('filter_emai', 'filter_email_block', true);
        } else {
//            $oTpl->set_block('filter_email_block', '');
            $oTpl->set_var('W3Css_force_FILTER_CHECK',  (($aExentedDefaults['W3Css_force']) ? ' checked="checked"' : '') );
        }

        $oTpl->set_var($oTrans->getLangArray());

        // write out header if needed
        if(!$admin_header) { $admin->print_header(); }
    // Parse template objects output
            $oTpl->parse('main', 'main_block', true);
            $oTpl->pparse('output', 'page');
    }
