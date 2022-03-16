<?php
/**
 *
 * @category       modules
 * @package        ckeditor
 * @authors        WebsiteBaker Project, Michael Tenschert, Dietrich Roland Pehlke, Dietmar Wöllbrink
 * @copyright      WebsiteBaker Org. e.V.
 * @link           https://websitebaker.org/
 * @license        https://www.gnu.org/licenses/gpl.html
 * @platform       WebsiteBaker 2.12.2
 * @requirements   PHP 7.2.x and higher
 * @version        $Id: info.php 276 2019-03-22 00:06:26Z Luisehahne $
 * @filesource     $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/modules/ckeditor/info.php $
 *
 *
 *
 */

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!defined('SYSTEM_RUN')) {\header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; flush(); exit; }
/* -------------------------------------------------------- */

$module_directory   = 'ckeditor';
$module_name        = 'CKEditor v4.16.0.0';
$module_function    = 'wysiwyg';
$module_version     = '4.16.0.0';
$module_platform    = '2.13.0';
$module_author      = 'Michael Tenschert, Dietrich Roland Pehlke, erpe, WebBird, Marmot, Luisehahne';
$module_license     = '<a  href="https://www.gnu.org/licenses/lgpl.html">LGPL</a>';
$module_description = 'includes CKEditor 4.16.0 Standard, CKE allows editing content and can be integrated in frontend and backend modules.';

/*
CHANGELOG

CKEditor 4.16
Fixed ReDoS vulnerability in the Autolink plugin.
Fixed ReDoS vulnerability in the Advanced Tab for Dialogs plugin.

CKEditor 4.15.1
CKEditor 4.15.1 fixes an XSS vulnerability in the Color History feature
(CVE‑2020‑27193). Prior to this version, it was possible to execute an
XSS-type attack conducted with a specially crafted HTML code injected by the
victim via the Color Button dialog. However, the vulnerability required the
user to manually paste the code, minimizing the risk.

CKEditor v4.11.1.2
2019-02-09
Bugfixed removed deprecated Open Paste DialogBoxes
CKEditor v4.11.1.1
2018-12-16
recoding wblink and wbdroplet plugin, for stable Content-type: application/javascript,
for working with security "header setting X-Content-Type-Options: nosniff"
Ckeditor no longer sets a absolute url after choosing a entry from an addon selectbox , after choosing an addon entry, link will be inserted by
[wblink{page_id}?addon=name&item={addon_id}]. Marking the link, the ckeditor jumps to the correct addon entry in select box

*/