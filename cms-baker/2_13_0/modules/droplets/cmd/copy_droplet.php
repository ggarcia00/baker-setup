<?php
/**
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
 *
 * @category        modules
 * @package         droplets
 * @subpackage      copy_droplets
 * @author          Dietmar Wöllbrink
 * @copyright       WebsiteBaker Org. e.V.
 * @link            http://websitebaker.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.4
 * @requirements    PHP 5.4 and higher
 * @version         $Id: copy_droplet.php 92 2018-09-20 18:04:03Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/tags/2.12.1/modules/droplets/cmd/copy_droplet.php $
 * @lastmodified    $Date: 2018-09-20 20:04:03 +0200 (Do, 20 Sep 2018) $
 *
 */

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!\defined('SYSTEM_RUN')) {\header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; \flush(); exit;}
/* -------------------------------------------------------- */
//$sTimeStamp  = '_'.strftime('%Y%m%d_%H%M%S', time()+ TIMEZONE );

    $sTimeStamp  = '';
    if ($droplet_id === false) {
        $oApp->print_error('COPY_DROPLET_IDKEY::'.$oTrans->MESSAGE_GENERIC_SECURITY_ACCESS, $ToolUrl);
        exit();
    }
    // Get header and footer
    $sql  = '
    SELECT * FROM `'.TABLE_PREFIX.'mod_droplets`
    WHERE `id` = '.$droplet_id.'
    ';
    $oDroplet = $oDb->query($sql);
    $aCopyDroplet = $oDroplet->fetchRow(MYSQLI_ASSOC);
//    $aCopyDroplet['name'] = '';
    $content = (htmlspecialchars($aCopyDroplet['code']));
    $droplet_id = $oApp->getIDKEY(0);
