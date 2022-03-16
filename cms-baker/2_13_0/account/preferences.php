<?php
/**
 *
 * @category        frontend
 * @package         account
 * @author          WebsiteBaker Project
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2011, Website Baker Org. e.V.
 * @link            https://www.websitebaker.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.x
 * @requirements    PHP 5.6 and higher
 * @version         $Id: preferences.php 352 2019-05-13 12:34:35Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/account/preferences.php $
 * @lastmodified    $Date: 2019-05-13 14:34:35 +0200 (Mo, 13. Mai 2019) $
 *
 */


use bin\{WbAdaptor,Login,SecureTokens};
use bin\helpers\{PreCheck,Parentlist};
use vendor\phplib\Template;


if (!defined( 'SYSTEM_RUN')){ require(dirname(__DIR__).'/config.php'); }
//if (!class_exists('frontend')) {require(WB_PATH.'/framework/class.frontend.php');}

//if (!\function_exists('make_dir')) {require (WB_PATH.'/framework/functions.php');}

// Create new frontend object
    if (!isset($wb) || (isset($wb) && !($wb instanceof \frontend))) {$wb = new \frontend();}
    $oReg     = WbAdaptor::getInstance();
    $database = $oReg->getDatabase();
    $oTrans   = $oReg->getTranslate();
//    $wb       = $oReg->getApplication();

    $oTrans->enableAddon('templates\\DefaultTemplate');

    if (!FRONTEND_LOGIN) {
        \header('Location: '.WB_URL.'/index.php');
        exit(0);
    }

    if ($wb->is_authenticated()==false) {
        \header('Location: '.WB_URL.'/account/login.php');
        exit(0);
    }
    $redirect_url = ($_SESSION['HTTP_REFERER'] ?? WB_URL );
    $redirect_url = ( isset($redirect) && ($redirect!='') ? $redirect : $redirect_url);
    $page_id = isset($_SESSION['PAGE_ID']) ? $_SESSION['PAGE_ID'] : 0;

// Required page details
    $page_description = '';
    $page_keywords = '';
    define('PAGE_ID', $page_id);
    define('ROOT_PARENT', 0);
    define('PARENT', 0);
    define('LEVEL', 0);

    define('PAGE_TITLE', $oTrans->MENU_PREFERENCES);
    define('MENU_TITLE', $oTrans->MENU_PREFERENCES);
    define('MODULE', '');
    define('VISIBILITY', 'public');

    define('PAGE_CONTENT', WB_PATH.'/account/preferences_form.php');
    // Include the index (wrapper) file
    $no_intro = true;
    require(WB_PATH.'/index.php');
