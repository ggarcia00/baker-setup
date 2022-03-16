<?php
/**
 *
 * @category        admin
 * @package         interface
 * @author          WebsiteBaker Project
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2011, Website Baker Org. e.V.
 * @link            http://www.websitebaker2.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.x
 * @requirements    PHP 5.2.2 and higher
 * @version         $Id: timezones.php 66 2018-09-17 15:48:07Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/admin/interface/timezones.php $
 * @lastmodified    $Date: 2018-09-17 17:48:07 +0200 (Mo, 17. Sep 2018) $
 *
 * Timezone list file
 * This file is used to generate a list of timezones for the user to select
 *
 */

use bin\{WbAdaptor,SecureTokens,Sanitize};

if (!\defined('SYSTEM_RUN')) {header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 File not found'; flush(); exit;}

    $oReg = (is_object($oReg) ? $oReg : WbAdaptor::getInstance());
    $oApp = $oReg->getApplication();

    $sTimezone = ($userTimezone ?? $oReg->Timezone);
    $sDefaultTimezone = ($userTimezone ?? $oReg->DefaultTimezone);
    $iActualTimezone = ((isset($user_time) && $user_time == true) ? $sTimezone : $sDefaultTimezone);

// Create array
    $TIMEZONES = [];
    $actualTimeZone = $oReg->DefaultTimezone/3600;
    $TIMEZONES['-12']  = 'GMT -12 Hours';
    $TIMEZONES['-11']  = 'GMT -11 Hours';
    $TIMEZONES['-10']  = 'GMT -10 Hours';
    $TIMEZONES['-9']   = 'GMT -9 Hours';
    $TIMEZONES['-8']   = 'GMT -8 Hours - Pacific Standard';
    $TIMEZONES['-7']   = 'GMT -7 Hours - Mountain Standard / Pacific Daylight';
    $TIMEZONES['-6']   = 'GMT -6 Hours - Central Standard / Mountain Daylight';
    $TIMEZONES['-5']   = 'GMT -5 Hours - Eastern Standard / Central Daylight';
    $TIMEZONES['-4']   = 'GMT -4 Hours - Atlantic Standard / Eastern Daylight';
    $TIMEZONES['-3.5'] = 'GMT -3.5 Hours - Newfoundland Standard';
    $TIMEZONES['-3']   = 'GMT -3 Hours - Atlantic Daylight';
    $TIMEZONES['-2.5'] = 'GMT -2.5 Hours - Newfoundland Daylight';
    $TIMEZONES['-2']  = 'GMT -2 Hours';
    $TIMEZONES['-1']  = 'GMT -1 Hour';
    $TIMEZONES['0']   = 'GMT/UTC';
    $TIMEZONES['1']   = 'GMT +1 Hour';
    $TIMEZONES['2']   = 'GMT +2 Hours';
    $TIMEZONES['3']   = 'GMT +3 Hours';
    $TIMEZONES['3.5'] = 'GMT +3.5 Hours';
    $TIMEZONES['4']   = 'GMT +4 Hours';
    $TIMEZONES['4.5'] = 'GMT +4.5 Hours';
    $TIMEZONES['5']   = 'GMT +5 Hours';
    $TIMEZONES['5.5'] = 'GMT +5.5 Hours';
    $TIMEZONES['6']   = 'GMT +6 Hours';
    $TIMEZONES['6.5'] = 'GMT +6.5 Hours';
    $TIMEZONES['7']   = 'GMT +7 Hours';
    $TIMEZONES['8']   = 'GMT +8 Hours';
    $TIMEZONES['9']   = 'GMT +9 Hours';
    $TIMEZONES['9.5'] = 'GMT +9.5 Hours';
    $TIMEZONES['10']  = 'GMT +10 Hours';
    $TIMEZONES['11']  = 'GMT +11 Hours';
    $TIMEZONES['12']  = 'GMT +12 Hours';
    $TIMEZONES['13']  = 'GMT +13 Hours';

// Add "System Default" to list (if we need to)
    if (isset($user_time) && $user_time == true)
    {
        if (isset($TEXT['SYSTEM_DEFAULT']))
        {
            $TIMEZONES['system_default'] = $TIMEZONES[$actualTimeZone].' ('.$TEXT['SYSTEM_DEFAULT'].')';
        } else {
            $TIMEZONES['system_default'] = $TIMEZONES[$actualTimeZone].' (System Default)';
        }
    }

// Reverse array so "System Default" is at the top
    $TIMEZONES = \array_reverse($TIMEZONES, true);

