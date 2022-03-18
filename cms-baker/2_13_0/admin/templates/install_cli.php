<?php


use bin\{WbAdaptor,SecureTokens,Sanitize};
use bin\helpers\{PreCheck,msgQueue};
use src\Security\{CsfrTokens,Randomizer};
use src\Interfaces\Requester;
use bin\Requester\HttpRequester;

// Include config file and admin class file
    if (!\defined ('SYSTEM_RUN')) { require(\dirname (\dirname ((__DIR__))) . '/config.php');}
// Include the PclZip constant file (
    if (!\defined('PCLZIP_ERR_NO_ERROR')) { require(WB_PATH.'/include/pclzip/Constants.php'); }

// register addon vars
    $sAddonType         =  'template';
    $sAddonAppDir       = '/templates/';
    $aAllowedAddons     = ['template','theme'];

    $admin  = new \admin ('Addons', $sAddonType.'s_install', true);

    $oTrans->enableAddon(ADMIN_DIRECTORY.'\\addons');
    $aTrans = $oTrans->getLangArray();


    // Set temp vars
    $sArchiveFileName   = 'uel-2021.zip';
    $sUploadFile        = $oRequest->userfile->tmp_name;
    $sAppTmpPath        = WB_PATH . '/temp/';
    $sArchiveFilePath   = $sAppTmpPath;
    $sAddonMessage      = $oTrans->{'MESSAGE_GENERIC_INVALID_'.\strtoupper($sAddonType).'_FILE'};
// reset variable declared in info.php
    $sAddonFunc         = 'load_' . $sAddonType;
    $show_block         = isset($oRequest->advanced)&&(int)$oRequest->advanced;
    $sAddonBackUrl      = WB_URL.'/'.ADMIN_DIRECTORY.'/'.\basename(__DIR__).'/index.php'.($show_block?'?advanced='.$show_block:'');
    $sErrorMsg          = '';
    $sAddonDirectory    = '';
    $sAddonPlatform     = '';
    $sAddonVersion      = '';
    $sAddonName         = '';
    $sAddonFunction     = '';
    $sInfoFile          = '';
    $new_module_version = '';

    $aFile          = [];
    $aFiles         = [];
    // Setup the PclZip object
    $oArchive       = new \vendor\pclzip\PclZip ($sArchiveFilePath . $sArchiveFileName);
    $aFilesInArchiv = $oArchive->listContent ();

    foreach ($aFilesInArchiv as $index => $aFileInArchiv) {
        if ($aFileInArchiv['filename'] == 'info.php') {
            $aFiles = $oArchive->extract (
                PCLZIP_OPT_BY_NAME, $aFileInArchiv['filename'], PCLZIP_OPT_EXTRACT_AS_STRING
            );
            $aFile[$aFiles['0']['filename']] = $aFiles['0']['content'];
            break;
        }
    }
    if (!isset ($aFile['info.php'])) {
        throw new \Exception (\vsprintf($oTrans->MESSAGE_GENERIC_INVALID_ADDON_FILE,$sArchiveFileName));
    }
    $sData = $aFile['info.php'];
    // Check if uploaded file is a valid Add-On zip
    if ($sData) {
        $aNewModule['common']                = [];
        $aNewModule['common']['directory']   = get_variable_content ($sAddonType . '_directory', $sData);
        $aNewModule['common']['name']        = get_variable_content ($sAddonType . '_name', $sData);
        $aNewModule['common']['version']     = get_variable_content ($sAddonType . '_version', $sData);
        $aNewModule['common']['platform']    = get_variable_content ($sAddonType . '_platform', $sData);
        $aNewModule['common']['phpversion']  = get_variable_content ($sAddonType . '_phpversion', $sData);
        $aNewModule['common']['function']    = get_variable_content ($sAddonType . '_function', $sData);
        $aNewModule['common']['description'] = get_variable_content ($sAddonType . '_description', $sData);
        $aNewModule['common']['author']      = get_variable_content ($sAddonType . '_author', $sData);
        $aNewModule['common']['license']     = get_variable_content ($sAddonType . '_license', $sData);
        $sAddonName                        = $aNewModule['common']['name'];
        $sAddonFunction                    = ($aNewModule['common']['function'] ? : 'template');
        $new_module_version                = $aNewModule['common']['version'];
        $sAddonDirectory                   = $aNewModule['common']['directory'];
        $sInfoFile                         = WB_PATH . $sAddonAppDir . $sAddonDirectory . '/info.php';
        if (!\preg_match('/^[a-z_][a-z0-9_-]+$/i',$sAddonDirectory) || ($sAddonDirectory==='')){
            $sAddonDirectory = (($sAddonDirectory=='') ? '?????' : $sAddonDirectory);
            $sInfoRelPath =  $sAddonAppDir.$sAddonDirectory.'/info.php';
            throw new \Exception (\sprintf('Template directory %s</b> not exists or has invalide chars',$sInfoRelPath));
        }
    }
    if (!($aNewModule['common']['function'])){
        \trigger_error('Missing Template-Parameter [$'.$sAddonType.'_function] in '.$sAddonDirectory.'/info.php!', E_USER_NOTICE);
    }

    if (\is_readable ($sInfoFile)) {
        $aAddon = $admin->getContentFromInfoPhp ($sInfoFile);
        $sAddonVersion = $aAddon['common']['version'];
        $sAddonPlatform = (\defined(WB_VERSION) ? WB_VERSION : $aNewModule['common']['platform']);
        $sWbVersion = (\defined('VERSION') ? VERSION : $sAddonPlatform);
        if (\version_compare ($sWbVersion, $sAddonPlatform, '<')){
            throw new \Exception (\sprintf($oTrans->MESSAGE_GENERIC_INVALID_PLATFORM, $sWbVersion));
        }
    }
    if (!$aFilesInArchiv) {
        throw new \Exception ($oTrans->MESSAGE_GENERIC_INVALID_ADDON_FILE);
    }
    else
    if (!\in_array ($sAddonFunction, $aAllowedAddons)) {
        throw new \Exception ($sAddonMessage);
    }

    $sAction      = "install";

    // Check if this module is already installed
    // and compare versions if so
    // Set module directory
    $sAddonAbsDir = WB_PATH . $sAddonAppDir . $sAddonDirectory;
    if (\is_dir ($sAddonAbsDir)) {
        if (\is_readable ($sAddonAbsDir . '/info.php')) {
            $aTemp = [
                'type' => \ucfirst($sAddonType),
                'short' => $sAddonDirectory,
                'name' => $sAddonName
            ];
            // Version to be installed is older than currently installed version
            $iSteps = \version_compare ($new_module_version, $sAddonVersion);
            switch ($iSteps):
                case 1:  //  second is lower than the first
                    $sAction = 'upgrade';
                    break;
                case 0: //  they are equal
                    $sAction = 'upgrade';
                    //                    throw new \Exception (\vsprintf($oTrans->MESSAGE_GENERIC_ALREADY_INSTALLED,$aTemp));
                    break;
                case -1: //  first version is lower than the second
                    throw new \Exception (\vsprintf($oTrans->MESSAGE_GENERIC_NOT_UPGRADED,$aTemp));
                    break;
                default:
            endswitch;
        }
    }

    // Make sure the module dir exists, and chmod if needed
    make_dir ($sAddonAbsDir);
    if (\is_writeable ($sAddonAbsDir)) {
    // Unzip module to the module dir
        if (isset ($oRequest->overwrite)) {
            $iExtract = (int) $oArchive->extract (PCLZIP_OPT_PATH, $sAddonAbsDir, PCLZIP_OPT_REPLACE_NEWER);
        }
        else {
            $iExtract = (int) $oArchive->extract (PCLZIP_OPT_PATH, $sAddonAbsDir);
        }
    }
    // Delete the temp zip file
    if ($iExtract == 0) {
        throw new \Exception ( $oArchive->errorInfo (true)."\n".$oTrans->MESSAGE_GENERIC_CANNOT_UNZIP);
    }
    $sActionScript = $sAddonAbsDir . '/' . $sAction . '.php';
    // Run the modules install // upgrade script if there is one
    if (\file_exists ($sActionScript)) {require($sActionScript);}
    // Print success message
    //    $aTemp = ['ACTION' => $sAction, 'name' => $sAddonName, 'type' => ucfirst($sAddonType) ];
            $aTemp = [
                'type' => \ucfirst($sAddonType),
                'short' => $sAddonDirectory,
                'name' => $sAddonName,
            ];
            
    if (\function_exists($sAddonFunc)){
        if ($sAction == "install") {
            // Load module info into addons DB
            // throw new \Exception (\sprintf('Linha: (%s, true, %s).', $sAddonAbsDir, $aNewModule));
            if (!$sAddonFunc($sAddonAbsDir, true, $aNewModule)){
                throw new \Exception (\vsprintf($oTrans->MESSAGE_GENERIC_MODULE_VERSION_ERROR,$aTemp));
            }
            $sMsg = \vsprintf($oTrans->MESSAGE_GENERIC_INSTALLED,$aTemp);
        }
        else
        if ($sAction == "upgrade") {
            // update module info in addons DB
            if (!$sAddonFunc($sAddonAbsDir, true, $aNewModule)){
                throw new \Exception (\vsprintf($oTrans->MESSAGE_GENERIC_MODULE_VERSION_ERROR,$aTemp));
            }
            $sMsg = \vsprintf($oTrans->MESSAGE_GENERIC_UPGRADED,$aTemp);
        }
    }
    if ($sArchiveFileName && \is_writable ($sArchiveFilePath . $sArchiveFileName)) {
    \unlink ($sArchiveFilePath . $sArchiveFileName);
    }

    $admin->print_success ($sMsg, $sAddonBackUrl);
    ?>