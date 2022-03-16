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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * DbRepair
 *
 * @category     name
 * @package      Core package
 * @copyright    Manuela v.d.Decken <manuela@isteam.de>
 * @author       Manuela v.d.Decken <manuela@isteam.de>
 * @author       Manuela v.d.Decken <manuela@isteam.de>
 * @license      GNU General Public License 2.0
 * @version      0.0.1 $Rev: $
 * @revision     $Id: $
 * @since        File available since 06.04.2021
 * @deprecated   no / since 0000/00/00
 * @description  xxx
 */


use bin\{WbAdaptor,SecureTokens,Sanitize};
use bin\helpers\{PreCheck};
use addon\WBLingual\Lingual;

use App\DbRepair;

    if (!\defined('SYSTEM_RUN')) {require( (\dirname(\dirname((__DIR__)))).'/config.php');}
    $sMessage = 'Repair Response!'."\n";
    $iPages   = 0;
    $sMessage = '';
    $aJsonRespond = [];
    $aJsonRespond['message'] = 'Error Repair Pages Link Structure';
    $aJsonRespond['success'] = false;
    try {
    // check autentification
        $admin = new admin('Pages', 'pages_settings',false);
        $oReg  = WbAdaptor::getInstance();
        $oDb   = $oReg->getDatabase();
        if (!$admin->is_authenticated()  || !$admin->ami_group_member('1')) {
            $sMessage .= \sprintf('%s', $oDb->get_error());
            throw new \Exception($sMessage);
        }
        $sSqlPages    = 'SELECT COUNT(*) FROM `'.$oReg->TablePrefix.'pages`';
        if (!($iPages = $oDb->get_one($sSqlPages))){
            throw new \Exception(\sprintf('Access denied'));
        }
/* */
        $oR = new DbRepair($oDb);
        $oR->buildLinkFromTrail('pages');
        $sMessage .= \sprintf('Repair %d Pages Link Structure', $iPages);
        $aJsonRespond['success'] = true;

    } catch (\Exception $e) {
        $sMessage .= 'Repair pages link structure failed:: '.$e->getMessage().'!'."\n";
        $aJsonRespond['success'] = false;
    }

    $aJsonRespond['message'] = PreCheck::xnl2br($sMessage);
    exit(\json_encode($aJsonRespond));
