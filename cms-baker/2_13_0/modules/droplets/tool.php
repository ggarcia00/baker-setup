<?php
/**
 *
 * @category        module
 * @package         droplet
 * @author          Ruud Eisinga (Ruud) John (PCWacht)
 * @author          WebsiteBaker Project
 * @copyright       Ryan Djurovich
 * @copyright       WebsiteBaker Org. e.V.
 * @link            https://websitebaker.org/
 * @license         https://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.12.1
 * @requirements    PHP 7.2 and higher
 * @version         $Id: tool.php 298 2019-03-27 08:17:24Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/modules/droplets/tool.php $
 * @lastmodified    $Date: 2019-03-27 09:17:24 +0100 (Mi, 27. Mrz 2019) $
 *
 */


use bin\{WbAdaptor,SecureTokens,Sanitize};
use bin\helpers\{PreCheck,msgQueue};
use src\Security\{CsfrTokens,Randomizer};
use src\Interfaces\Requester;


    function executeDropletTool($admin)
    {
/* -------------------------------------------------------- */
        $sAddonName = \basename(__DIR__);
        $bExcecuteCommand = false;
/*******************************************************************************************/
//      SimpleCommandDispatcher
/*******************************************************************************************/
        if (\is_readable(\dirname(__DIR__).'/SimpleCommandDispatcher.inc.php')) {
            require (\dirname(__DIR__).'/SimpleCommandDispatcher.inc.php');
        }

/*
$sDomain = \basename(__DIR__).'/'.\basename(__FILE__);
print '<pre class="w3-pre w3-border w3-white w3-small w3-container w3-padding" style="width:100%;">'.nl2br(sprintf("function: <span>%s</span> (%s) Filename: <span>%s</span> Line %d\n",(!empty(__FUNCTION__) ? __FUNCTION__ : 'global'),'myVar',$sDomain,__LINE__));
\print_r( $aRequestVars ); print "</pre>"; \flush (); // htmlspecialchars() ob_flush();;sleep(10); die();
        $aRequestVars  = [];
// get POST or GET requests, never both at once
        $aVars = $oReg->Request->getParamNames();
        foreach ($aVars as $sName) {
            $aRequestVars[$sName] = $oRequest->getParam($sName);
        }
*/
// Include the PclZip constant file (thanks to
        if (!\defined('PCLZIP_ERR_NO_ERROR')) { require(WB_PATH.'/include/pclzip/Constants.php'); }

        $database    = $oDb;
        if (!\function_exists('getUniqueName')) { require($sAddonPath.'/droplets.functions.php'); }
        $ToolRel     = '/admintools/tool.php?tool='.$sAddonName;
        $ToolQuery   = '?tool='.$sAddonName;
        $js_back     = $oReg->AcpUrl.'admintools/tool.php';
        $sActrionUrl = $oReg->AcpUrl.'admintools/tool.php';
        $ToolUrl     = $sActrionUrl.'?tool='.$sAddonName;
        $ApptoolLink = $oReg->AcpUrl.'admintools/index.php';

        // create default placeholder array for templates htt or Twig use
        $oTrans->enableAddon('modules\\'.$sAddonName);
        $aLang = $oTrans->getLangArray();
        $aTplDefaults = [
              'ADMIN_DIRECTORY' => \ADMIN_DIRECTORY,
              'ToolUrl' => $ToolUrl,
              'ToolRel' => $ToolQuery,
              'ToolQuery' => $ToolQuery,
              'ActionUrl' => $sActrionUrl,
              'sAddonUrl' => $sAddonUrl,
              'MODULE_NAME' => $sAddonName,
              'ApptoolLink' => $ApptoolLink,
              'sAddonThemeUrl'  => $sAddonThemeUrl,
              'AcpUrl' =>  $oReg->AcpUrl,
              'AppUrl' =>  $oReg->AppUrl,
              ];
        $output = '';
        msgQueue::clear();
        if (!$admin->get_permission($sAddonName,'module' ) ) {
            $admin->print_error($oTrans->MESSAGE_ADMIN_INSUFFICIENT_PRIVELLIGES, $js_back);
            exit();
        }
        $sOverviewDroplets = $oTrans->TEXT_LIST_OPTIONS.' '.$oTrans->DR_TEXT_DROPLETS;
        // prepare to get parameters (query)) from this URL string e.g. modify_droplet?droplet_id
        $aQuery = ['command'=>'overview'];
        $sql = '';
//        $aRequestVars = $_REQUEST;
        $aParseUrl  = (isset($aRequestVars['command']) ? \parse_url ($aRequestVars['command']): $aQuery );
        // sanitize command from compatibility file
        $action = \preg_replace(
            '/[^a-z\/0-1_]/siu',
            '',
            (isset($aParseUrl['path']) ? $aParseUrl['path'] : 'overview')
        );
        $sCommand = $sAddonPath.'cmd/'.$action.'.php';
        $subCommand = (isset($aRequestVars['subCommand']) ? $aRequestVars['subCommand'] : $action);
        if (isset( $aParseUrl['query'])) { \parse_str($aParseUrl['query'], $aQuery); }
//        if( !function_exists( 'make_dir' ) ) { require($oReg->AppPath.'/framework/functions.php');  }
        \ob_start();
        \extract($aQuery, EXTR_PREFIX_SAME, "dr");

        switch ($action):
            case 'backup_droplets':
                if (\is_readable($sCommand)) { include ( $sCommand ); }
                break;
            case 'import_droplets':
                if (\is_readable($sCommand)) { include ( $sCommand ); }
                $sDropletTmpDir = 'temp/modules/'.$sAddonName.'/';
                $sDropletTmpDir = $sAddonRel.'/data/tmp/';
                if (\file_exists($sDropletTmpDir)){rm_full_dir($oReg->AppPath.$sDropletTmpDir, true);}
                break;
            case 'add_droplet':
            case 'copy_droplet':
                $sCommand = $sAddonPath.'/cmd/'.'rename_droplet.php';
            case 'modify_droplet':
            case 'rename_droplet':
            case 'save_rename':
//                if ( \is_readable($sCommand)) { include ( $sCommand ); }
//                $sCommand = $sAddonPath.'cmd/'.'overview.php';
            case 'save_droplet':
//                $droplet_id = $aRequestVars['droplet_id'];
            case 'ToggleStatus':
            case 'delete_droplet':
//                $droplet_id = ($oApp->checkIDKEY($droplet_id, false, ''));
                $droplet_id = (isset($droplet_id) ? $droplet_id :'droplet_id');
                $iDropletAddId = ($oApp->getIdFromRequest($droplet_id));
                if (isset($iDropletAddId) && ($iDropletAddId >-1)) {
                    $droplet_id = $iDropletAddId;
                }
                if ( \is_readable($sCommand)) { include ( $sCommand ); }
                $sCommand = $sAddonPath.'/cmd/'.'overview.php';
                if (\is_readable($sCommand)) { include ( $sCommand ); }
                break;
            case 'restore_droplets':
            case 'call_help':
            case 'call_import':
            case 'select_archiv':
            case 'delete_archiv':
                if (\is_readable($sCommand)) { include ( $sCommand ); }
//                $iDropletAddId = ($oApp->checkIDKEY($droplet_id, false, ''));
            default:
//                if ( \is_readable($sCommand)) { include ( $sCommand ); }
                $sCommand = $sAddonPath.'/cmd/'.'overview.php';
                if (\is_readable($sCommand)) { include ( $sCommand ); }
                break;
        endswitch;
        $output = \ob_get_clean();
        print $output;

        if (!empty($msg = msgQueue::getSuccess()))
        {
            echo $oApp->format_message($msg,'ok', $ToolUrl );
//            $oApp->print_success($msg, $ToolUrl);
        }
        if (!empty($msg = msgQueue::getError()))
        {
            echo $oApp->format_message($msg,'error', $ToolUrl);
//            $oApp->print_error($msg, $ToolUrl);
        }

    } // end executeDropletTool
/* -------------------------------------------------------------------------------------------- */
//
/* -------------------------------------------------------------------------------------------- */
    if (!\defined('SYSTEM_RUN')) {require(\dirname(dirname((__DIR__))).'/config.php');}
    $admin = new \admin('admintools', 'admintools', false);
    $requestMethod = \strtoupper($_SERVER['REQUEST_METHOD']);
    $aRequestVars  = (isset(${'_'.$requestMethod})) ? ${'_'.$requestMethod} : $_REQUEST;
    executeDropletTool($admin);
        $admin->print_footer();
    exit;
// end of file
