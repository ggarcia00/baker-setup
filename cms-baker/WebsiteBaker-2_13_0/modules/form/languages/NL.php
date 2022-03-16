<?php
/**
 *
 * @category        module
 * @package         Form
 * @author          WebsiteBaker Project
 * @copyright       WebsiteBaker Org. e.V.
 * @link            http://websitebaker.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.3
 * @requirements    PHP 5.3.6 and higher
 * @version         $Id: NL.php 112 2018-09-28 11:19:49Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/modules/form/languages/NL.php $
 * @lastmodified    $Date: 2018-09-28 13:19:49 +0200 (Fr, 28. Sep 2018) $
 * @description
 */

// Must include code to stop this file being access directly
if (!\defined('SYSTEM_RUN')) {header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 File not found'; flush(); exit;}
/* -------------------------------------------------------- */

//Modul Description
$module_description = 'Deze module makt het mogelijk om aangepaste online formulieren te maken zoals een feedback formulier. Met dank aan Rudolph Lartey voor het aanpassen van deze module.';

//Variables for the  backend
$MOD_FORM['SETTINGS'] = 'Form Settings';
$MOD_FORM['CONFIRM'] = 'Confirmation';
$MOD_FORM['SUBMIT_FORM'] = 'Submit';
$MOD_FORM['EMAIL_SUBJECT'] = 'Delivering a message from {{WEBSITE_TITLE}}';
$MOD_FORM['SUCCESS_EMAIL_SUBJECT'] = 'You have submitted a message by {{WEBSITE_TITLE}}';

$MOD_FORM['SUCCESS_EMAIL_TEXT'] = 'Thank you for sending your message to {{WEBSITE_TITLE}}! ';
$MOD_FORM['SUCCESS_EMAIL_TEXT'] .= 'We will be going to contact you as soon as possible';

$MOD_FORM['SUCCESS_EMAIL_TEXT_GENERATED'] = "\n\n\n"
."****************************************************************************\n"
."This is an automatically generated e-mail. The sender address of this e-mail\n"
."is furnished only for dispatch, not to receive messages!\n"
."If you have received this e-mail by mistake, please contact us and delete this message\n"
."****************************************************************************\n";

$MOD_FORM['REPLYTO'] = 'E-Mail reply to';
$MOD_FORM['FROM'] = 'Sender';
$MOD_FORM['TO'] = 'Recipient';

$MOD_FORM['EXCESS_SUBMISSIONS'] = 'Sorry, this form has been submitted too many times so far this hour. Please retry in the next hour.';
$MOD_FORM['INCORRECT_CAPTCHA'] = 'The verification number (also known as Captcha) that you entered is incorrect. If you are having problems reading the Captcha, please email to the <a href="mailto:{{webmaster_email}}">webmaster</a>';

$MOD_FORM['PRINT']  = 'E-mail confirmation occurs only to valid e-mail address of the user announced in each case! Dispatch to unchecked addresses is not possible! ';
$MOD_FORM['PRINT'] .= 'Please print this message!';

$MOD_FORM['REQUIRED_FIELDS'] = 'You must enter details for the following fields';
$MOD_FORM['RECIPIENT'] = 'E-mail confirmation occurs only to valid e-mail address of the user announced in each case! Dispatch to unchecked addresses is not possible!';
$MOD_FORM['ERROR'] = 'E-Mail could not send!!';
$MOD_FORM['SPAM'] = 'Caution! Answering an unchecked email can be perceived as spamming and entail the risk of receiving a cease-and-desist letter! ';

$TEXT['GUEST'] = 'Guest';
$TEXT['UNKNOWN'] = 'unkown';
$TEXT['PRINT_PAGE'] = 'Print page';
$TEXT['REQUIRED_JS'] = 'Required Javascript';
$TEXT['SUBMISSIONS_PERPAGE'] = 'Show submissions rows per page';
