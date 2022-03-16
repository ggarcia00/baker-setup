<?php
/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!defined('SYSTEM_RUN')) {header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 File not found'; flush(); exit;}
/* -------------------------------------------------------- */
?><?php

$sLayoutTitle = 'Layout_Default_Table';
$sLayoutDescription = 'The ancient layout, with new Captcha call as placeholder. To use only with table fields';

    $header     = '
    <div class="frm frm-field_table">
    ';
    $field_loop = '
    <div>
        <div class="frm-field_title">{TITLE}{REQUIRED}</div>
        <div>{FIELD}</div>
    </div>
    ';

    $extra  = '
    <div>{CALL_DSGVO_LINK}</div>
    <div class="frm-field_title">{TEXT_VERIFICATION}{REQUIRED}</div>
    <div>{CALL_CAPTCHA}</div>
';

    $footer = '
     <div class="w3-margin"></div>
     <div>
        <input class="frm-btn" type="submit" name="submit" value="{SUBMIT_FORM}" />
     </div>
</div>
<div class="w3-margin"></div>
';
/* ------------------------------------------------------------------------------ */
/*
    $sInsertTableCaptcha = '
       <tr>
            <td class="frm-field_title"><label>{TEXT_VERIFICATION}</label></td>
            <td>
               {CALL_CAPTCHA}
           </td>
      </tr>
';

    $sInsertTableDSGVO = '
       <tr>
            <td colspan="2">
               {CALL_DSGVO_LINK}
           </td>
      </tr>
';
*/
    $sInsertCaptcha = '
     <div class="frm-field_title"><label>{TEXT_VERIFICATION}</label></div>
     <div>{CALL_CAPTCHA}</div>
';

    $sInsertDSGVO = '
     <div>{CALL_DSGVO_LINK}</div>';


