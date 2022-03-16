<?php

namespace bin\helpers;



/**
 * NativeSessionHandler
 *
 * @package
 * @author WebsiteBaker Patch mit Fix
 * @copyright WebsiteBaker
 * @version 2020
 * @access public
 *
 * @example
    $handler = new NativeSessionHandler("/var/www/foo");
    session_set_save_handler($handler, true);
    session_start();
    $a = $handler->write("aaa","bbbb");var_dump($a);exit;
 *
 */
class NativeSessionHandler extends \SessionHandler
{


    public function __construct($savePath = null)
    {
        $this->init($savePath);
    }

    public function setIniSetSession(){
    // **PREVENTING SESSION HIJACKING**
    // Prevents javascript XSS attacks aimed to steal the session ID
        \ini_set('session.cookie_httponly', true);
    // **PREVENTING SESSION FIXATION**
        \ini_set('session.use_trans_sid', false);
    // Session ID cannot be passed through URLs
        \ini_set('session.use_only_cookies', true);
    }

    protected function init($savePath){
        if (null === $savePath) {
            $savePath = ini_get('session.save_path');
        }
        $thhis->setIniSetSession();
        $baseDir = $savePath;
        if ($count = substr_count($savePath, ';')) {
            if ($count > 2) {
                throw new \InvalidArgumentException(sprintf('Invalid argument $savePath \'%s\'', $savePath));
            }
            // characters after last ';' are the path
            $baseDir = ltrim(strrchr($savePath, ';'), ';');
        }
        if (($baseDir && !is_dir($baseDir)) && (!mkdir($baseDir, 0777, true) && !is_dir($baseDir))) {
            throw new \RuntimeException(sprintf('Session Storage was not able to create directory "%s"', $baseDir));
        }
        ini_set('session.save_path', $savePath);
        ini_set('session.save_handler', 'files');
    }

} // end og class
