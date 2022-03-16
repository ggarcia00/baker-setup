<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * cmdSave.php
 *
 * @category     Addons
 * @package
 * @copyright    Manuela v.d.Decken <manuela@isteam.de>
 * @author       Manuela v.d.Decken <manuela@isteam.de>
 * @license      http://www.gnu.org/licenses/gpl.html   GPL License
 * @version      3.0.1
 * @lastmodified $Date: 2018-09-20 20:09:30 +0200 (Do, 20 Sep 2018) $
 * @since        File available since 2015-12-17
 * @description  xyz
 */

use bin\{WbAdaptor,SecureTokens,Sanitize};

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!\defined('SYSTEM_RUN')) {\header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; \flush(); exit;}
/* -------------------------------------------------------- */

        if (\bin\SecureTokens::checkFTAN ()) {
            // take over post - arguments
            $aDatas = [];
            $oReg = WbAdaptor::getInstance();
            $oRequest = $oReg->getRequester();
            $database = $oReg->getDatabase();
            // get POST or GET requests, never both at once
            $aVars = $oRequest->getParamNames();
            $aRequestVars = [];
            foreach ($aVars as $sName) {
                $aRequestVars[$sName] = $oRequest->getParam($sName);
            }
            $aAutoFilter = [
                'WbLink' => 1,
                'ReplaceSysvar' => 1,
                'CssToHead' => 1,
                'CleanUp' => 1,
                'SnippetCss' => 1,
                'FrontendCss' => 1,
                ];

//            $aDefaultSettings = \array_intersect_key($aDatas, getOutputFilterSettings());
            foreach ( $aDefaultSettings as $key => $value ) {
                if (\in_array( $key, $aAllowedFilters) ) {
                    $aDatas[$key] = ($aAutoFilter[$key] ?? ($aRequestVars[$key] ?? $aDefaultSettings[$key]));
                }
            }
            if ($aFilterSettings['Email']) {
                $aDatas['email_filter']    = (bool)($aRequestVars['email_filter'] ?? $aDefaultSettings['email_filter']);
                $aDatas['mailto_filter']   = (bool)($aRequestVars['mailto_filter'] ?? $aDefaultSettings['mailto_filter']);
                $aDatas['at_replacement']  = ((isset($aRequestVars['at_replacement']) && !empty($aRequestVars['at_replacement']))
                                               ? \trim(\strip_tags($aRequestVars['at_replacement']))
                                               : $aDefaultSettings['at_replacement']);
                $aDatas['dot_replacement'] = ((isset($aRequestVars['dot_replacement']) && !empty($aRequestVars['dot_replacement']))
                                               ? \trim(\strip_tags($aRequestVars['dot_replacement']))
                                               : $aDefaultSettings['dot_replacement']);
            }
/*  */
            $sNameValPairs = '';
            foreach ($aDatas as $index => $val) {
                $sNameValPairs .= ',(\''.$index.'\', \''.$database->escapeString($val).'\')';
            }
            $sValues = ltrim($sNameValPairs, ',');
            $sql = 'REPLACE INTO `'.TABLE_PREFIX.'mod_output_filter` (`name`, `value`) '
                 . 'VALUES '.$sValues;
            if ($database->query($sql)) {
            //anything ok
                $msgTxt = $MESSAGE['RECORD_MODIFIED_SAVED'];
                $msgCls = 'green';
            }else {
            // database error
                $msgTxt = $MESSAGE['RECORD_MODIFIED_FAILED'];
                $msgCls = 'red';
            }
        } else {
        // FTAN error
            $msgTxt = $MESSAGE['GENERIC_SECURITY_ACCESS'];
            $msgCls = 'red';
        }
// end of file
