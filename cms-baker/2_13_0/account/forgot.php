<?php
/**
 *
 * @category        frontend
 * @package         account
 * @author          WebsiteBaker Project
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2011, Website Baker Org. e.V.
 * @link            https://websitebaker.org/
 * @license         https://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.x
 * @requirements    PHP 5.6 and higher
 * @version         $Id: forgot.php 267 2019-03-21 16:44:22Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/account/forgot.php $
 * @lastmodified    $Date: 2019-03-21 17:44:22 +0100 (Do, 21. Mrz 2019) $
 *  defined('PAGE_ID') ? PAGE_ID : $page_id
 */

use bin\{WbAdaptor,Login,SecureTokens,Sanitize};
use bin\helpers\{PreCheck};


if (!defined( 'SYSTEM_RUN')){require(dirname(__DIR__).'/config.php');}
//  Create new frontend object
    if (!isset($wb) || (isset($wb) && !($wb instanceof \frontend))) {$wb = new \frontend();}
/*
    $aSession = [
      'display_form' => $_SESSION['display_form'],
      'PAGE_ID' => $_SESSION['PAGE_ID'],
      'HTTP_REFERER' => $_SESSION['HTTP_REFERER'],
      'submitted_when' => $_SESSION['submitted_when'],
    ];
$sDomain = \basename(__DIR__).'/'.\basename(__FILE__);
print '<pre class="w3-pre w3-medium">'.nl2br(sprintf("function: <span>%s</span> (%s) Filename: <span>%s</span> Line %d\n",(!empty(__FUNCTION__) ? __FUNCTION__ : 'global'),'myVar',$sDomain,__LINE__));
\print_r( $aSession ); print "</pre>"; \flush (); // htmlspecialchars() ob_flush();;sleep(10); die();
*/

    $page_id = $oRequest->getParam('page_id',FILTER_VALIDATE_INT);
    $page_id = (isset($_SESSION['PAGE_ID']) && ($_SESSION['PAGE_ID'] > 0) ? $_SESSION['PAGE_ID'] : $page_id);
//    $page_id = ($page_id ?? $wb->getLangPageId(LANGUAGE));
    $_SESSION['display_form'] = (!isset($_SESSION['display_form']) ? true : $_SESSION['display_form']);

    if (!FRONTEND_LOGIN) {
    //    header('Location: '.WB_URL.'/index.php');
        require(WB_PATH.'/index.php');
        exit(0);
    }

//  Required page details
    $page_description = '';
    $page_keywords = '';
    define('PAGE_ID', $page_id);
    define('ROOT_PARENT', 0);
    define('PARENT', 0);
    define('LEVEL', 0);
    define('PAGE_TITLE', $MENU['FORGOT']);
    define('MENU_TITLE', $MENU['FORGOT']);
    define('VISIBILITY', 'public');
//  Set the page content include file
    define('PAGE_CONTENT', WB_PATH.'/account/forgot_form.php');
//  Set auto authentication to false
    $auto_auth = false;
//  Include the index (wrapper) file
    require(WB_PATH.'/index.php');
