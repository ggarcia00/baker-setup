<?php
/**
 * delete_errorlog.php
 */

    $sAppPath = \dirname(\dirname(__DIR__));
    if (\is_readable($sAppPath.'/config.php')) {require ($sAppPath.'/config.php');}
// get request method
    $oRequest = \bin\requester\HttpRequester::getInstance();
    $sErrorlogFile = \bin\Exceptions\ErrorHandler::getLogFile();
    $sErrorlogUrl  = \str_replace(WB_PATH, WB_URL, $sErrorlogFile);
    $aJsonRespond['url'] = $sErrorlogUrl;
    // initialize json_respond array  (will be sent back)
    $aJsonRespond = [];
    $aJsonRespond['content'] = '';
    $aJsonRespond['message'] = 'Load operation failed';
    $aJsonRespond['success'] = false;
    $admin = new admin('##skip##', false, false);

    if ((int)$admin->get_user_id() != 1){
        $aJsonRespond['message'] = 'Access denied. Can\'t delete errorlog';
        exit(\json_encode($aJsonRespond));
    }

    if (!$oRequest->issetParam('action')) {
        $aJsonRespond['message'] = '"action" was not set';
        exit(\json_encode($aJsonRespond));
    } elseif ($oRequest->getParam('action') == 'show') {
          $aJsonRespond['content'] = \file_get_contents($sErrorlogFile);
    } else {
        if (\is_writeable($sErrorLogFile)) {
          if (!\unlink($sErrorLogFile)){
              $aJsonRespond['message'] = "can't delete from folder";
              exit(json_encode($aJsonRespond));
          }
          if (!\file_exists($sErrorLogFile)) {
              $sTmp = '<?php header($_SERVER[\'SERVER_PROTOCOL\'].\' 404 Not Found\');echo \'404 Not Found\'; flush(); exit; ?>'
                    . 'created: ['.\date('r').']'.PHP_EOL;
              if (false === \file_put_contents($sErrorLogFile, $sTmp)) {
                  throw new \Exception('unable to create logfile \''.\str_replace(WB_PATH, '', $sErrorlogFile).'\'');
              }
          }
          if (!\is_writeable($sErrorLogFile)) {
              throw new \Exception('not writeable logfile \''.\str_replace(WB_PATH, '', $sErrorlogFile).'\'');
          }
          $aJsonRespond['message'] = 'New php_error.log successfully created';
          $aJsonRespond['content'] = \file_get_contents($sErrorlogFile);
        }
    }
// If the script is still running, set success to true
$aJsonRespond['success'] = 'true';
// and echo the answer as json to the ajax function
echo \json_encode($aJsonRespond);
