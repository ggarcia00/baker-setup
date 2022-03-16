<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright (C) 2018 Manuela v.d.Decken <manuela@isteam.de>
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
 * Description of IpAddress
 *
 * @package      Core
 * @subpackage   Utils
 * @copyright    Manuela v.d.Decken <manuela@isteam.de>
 * @author       Manuela v.d.Decken <manuela@isteam.de>
 * @license      This program is subject to proprietary license terms.
 * @version      0.0.1
 * @revision     $Id: IpAddress.php 16 2020-04-13 00:15:09Z Manuela $
 * @since        File available since 21.01.2018
 * @deprecated   no / since 0000/00/00
 * @description  several methods to handle IP addresses. IPv4 and IPv6 as well.
 */

declare(strict_types = 1);
//declare(encoding = 'UTF-8');

namespace src\Utils;

//use;

class IpAddress
{

    public static function sanitizeIp(string $sRawIp): string
    {
        // clean address from netmask/prefix and port
        $sPattern = '/^[{\[]?([.:a-f0-9]*)(?:\/[0-1]*)?(?:[\]}]?.*)$/im';
        $sIpAddress = \preg_replace($sPattern, '$1', $sRawIp);
        if (\strpos($sIpAddress, ':') === false) {
        // sanitize IPv4 -------------------------------------------------------------- //
            if (ip2long($sIpAddress) === false) {
                throw new \InvalidArgumentException('illegal IPv4 address given!');
            }
        } else {
            // sanitize IPv6 -------------------------------------------------------------- //
            // for backard compatibility it also check deprecated addressing where
            // IP includes a 32 bit IPv4 part and convert this into IPv6 format
            $sPattern = '/^([:a-f0-9]*?)(?:(?:\:)([0-9]{1,3}(?:\.[0-9]{1,3}){3}))?$/is';
            $aMatches = [];
            if (\preg_match($sPattern, $sIpAddress, $aMatches)) {
                $sIpAddress = $aMatches[1].(isset($aMatches[2]) ? ':'.self::convertV4ToV6($aMatches[2]) : '');
            } else {
                throw new \InvalidArgumentException('illegal IPv6 address given!');
            }
            $sIpAddress = self::expandIpV6($sIpAddress);
        }
        return $sIpAddress;
    }
/**
 * check if IP is IPv4
 * @param string $sRawIp
 * @return bool
 */
    public static function isIpV4(string $sRawIp): bool
    {
        $sIpAddress = self::sanitizeIp($sRawIp);
        return (bool) (\strpos($sIpAddress, '.') !== false);
    }

/**
 *
 * @param string $sV4Address
 * @return string
 * @description convert a IPv4 address into full size 32bit, 2 hexword string
 */
    public static function convertIpV4ToIpV6(string $sV4Address): string
    {
        // convert into 32bit binary string
        $sIpV4Bin = \str_pad((string)\decbin(\ip2long($sV4Address)), 32, '0', \STR_PAD_LEFT) ;
        // split into 2 parts of 16bit
        $aIpV6Hex = \str_split($sIpV4Bin, 16);
        // combine result string
        $sRetval = \sprintf('%04x', \bindec($aIpV6Hex[0])).':'.\sprintf('%04x', \bindec($aIpV6Hex[1]));
        return $sRetval;
    }

/**
 *
 * @param string $sIpV6Address
 * @return string
 * @description expands IPv6 addresses, shortened by :: to all 8 double words (full 128 bit)
 */
    public static function expandIpV6(string $sIpV6Address): string
    {
        $iPos = strpos($sIpV6Address, '::');
        if ($iPos !== false) {
            $iInserts     = 8 - \count(\preg_split('/:/', $sIpV6Address, -1, \PREG_SPLIT_NO_EMPTY));
            $sInsert      = $iInserts ? \implode(':', \array_fill(0, $iInserts, '0000')) : '';
            $sIpV6Address = \substr($sIpV6Address, 0, $iPos + 1)
                          . $sInsert
                          . \substr($sIpV6Address, $iPos + 1);
        }
        $sResult = '';
        foreach (\preg_split('/:/', $sIpV6Address) as $sBlock) {
            $sResult .= \str_pad($sBlock, 4, '0', \STR_PAD_LEFT);
        }
        return \trim($sResult, ':');
    }

/**
 *
 * @param string $sAddress
 * @param int $iNetmaskLength
 * @return string
 */
    public static function getMaskedIpV4(string $sAddress, int $iNetmaskLength): string
    {
        $iIpAddress = \ip2long($sAddress);
        $iIpMask    = \bindec(\str_pad(\str_repeat('1', $iNetmaskLength), 32, '0', \STR_PAD_RIGHT));
        return \long2ip($iIpAddress & $iIpMask);
    }

/**
 *
 * @param string $sAddress
 * @param int $iPrefixLength
 * @return string
 */
    public static function getMaskedIpV6(string $sAddress, int $iPrefixLength): string
    {
        // build binary netmask from iNetmaskLengthV6
        // and split all 8 parts into an array
        if ($iPrefixLength < 1) {
            $aMask = \array_fill(0, 8, \str_repeat('0', 16));
        } else {
            $aMask = \str_split(
                \str_repeat('1', $iPrefixLength).
                \str_repeat('0', 128 - $iPrefixLength),
                16
            );
        }
        $aIpV6 = \preg_split('/:/', $sAddress);
        // iterate all IP parts, apply its mask and reformat to IPv6 string notation.
        \array_walk(
            $aIpV6,
            function(& $sWord, $iIndex) use ($aMask) {
                $sWord = \sprintf('%04x', \hexdec($sWord) & \bindec($aMask[$iIndex]));
            }
        );
        // reformat to IPv6 string notation.
        return \implode(':', $aIpV6);
    }
} // end of class IpAddress
