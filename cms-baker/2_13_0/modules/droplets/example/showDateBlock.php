<?php
//:Insert Full Date and Clock
//:usage: [[showDateBlock?title=Allgemeine Termine&amp;desc=Terminänderungen bleiben vorbehalten]]
//:can be call without parameters
$sSpace = '';
$sTitle = ($title ?? '');
$sDesc  = ($desc ?? '');
$content = "";
    try {

    $sContent  = '<div id="showDate" class="w3-container w3-auto w3-center">'.PHP_EOL;
    if ($sTitle){$sContent .= '<h3>'.$sTitle .'</h3>'.PHP_EOL;}

    $sContent .= '<h4>Heute ist ';
    $sContent .= '<span id="dateStamp"></span>';
    $sContent .= '<span id="timeStamp"></span>'.PHP_EOL;
    $sContent .= '</h4>'.PHP_EOL;

    if ($sDesc){$sContent .= '<h3>'.$sDesc.'</h3>'.PHP_EOL;}

    $sContent .= '</div>'.PHP_EOL;

    } catch (\Throwable $ex) {
        /* place to insert different error/logfile messages */
        $sContent = '$scontent = '.$ex->getMessage();
    }
    return $sContent;
