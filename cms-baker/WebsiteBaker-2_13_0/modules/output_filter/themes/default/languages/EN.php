<?php
/**
 *
 * @category        modules
 * @package         output_filter
 * @author          WebsiteBaker Project
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2011, Website Baker Org. e.V.
 * @link            http://www.websitebaker2.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.x
 * @requirements    PHP 5.6.x and higher
 * @version         $Id: EN.php 93 2018-09-20 18:09:30Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/modules/output_filter/themes/default/languages/EN.php $
 * @lastmodified    $Date: 2018-09-20 20:09:30 +0200 (Do, 20. Sep 2018) $
 *
 */

// Deutsche Modulbeschreibung
$module_description  = 'This module allows filtering of content before it is displayed in the frontend area. Supports filtering of email addresses in mailto links and text.';
$module_description .= '<span id="help-modfiles" style="visibility:hidden;"> <b>Attention!</b> RegisterModfiles is activated, some filters can therefore not be changed. To be able to set all filters individually, RegisterModfiles must be deactivated.</span>';
// Ueberschriften und Textausgaben
$MOD_MAIL_FILTER['HEADING']             = 'Options: Output Filtering';
$MOD_MAIL_FILTER['HOWTO']               = 'Output filtering can be configured via the following options.<b>Tip: </b>Mailto links can be encrypted with a Javascript routine!';
$MOD_MAIL_FILTER['W3CSS']               = 'With the following options the filter W3Css can be configured. <b>The external w3.css can be loaded permanently with this setting!</b>.';
$MOD_MAIL_FILTER['WARNING']             = 'Enter your own filters in the order in which they should be processed. This private list is optional and is not overwritten during the upgrade and is appended to the list of default filters. Note: In case of an empty private filter list, the default filters are retained.';
// Text von Form Elementen
$MOD_MAIL_FILTER['SET_ACTIVE']          = 'Activate/deactivate filter';
$MOD_MAIL_FILTER['CLICK_HELP']          = 'Click on label for help';
$MOD_MAIL_FILTER['BASIC_CONF']          = 'Default settings';
$MOD_MAIL_FILTER['SYS_REL']             = 'Frontend output with relative urls';
$MOD_MAIL_FILTER['opf']                 = 'Output filter Dashboard';
$MOD_MAIL_FILTER['EMAIL_FILTER']        = 'Filter email addresses in the text';
$MOD_MAIL_FILTER['MAILTO_FILTER']       = 'Filter email addresses in mailto';
$MOD_MAIL_FILTER['ENABLED']             = 'Enabled';
$MOD_MAIL_FILTER['DISABLED']            = 'Disabled';
$MOD_MAIL_FILTER['LOAD_W3CSS']          = 'Load W3CSS permanently';
$MOD_MAIL_FILTER['REPLACEMENT_CONF']    = 'Email replacements';
$MOD_MAIL_FILTER['AT_REPLACEMENT']      = 'Replace "@" with';
$MOD_MAIL_FILTER['DOT_REPLACEMENT']     = 'Replace "." with';
$MOD_MAIL_FILTER['ACTIVE_MODFILES'] = "Attention! RegisterModfiles is activated, therefore some filters cannot be changed. To be able to set all filters individually, RegisterModfiles must be deactivated.";
$TEXT['SAVE_LIST']  = 'Save list';
$TEXT['ADD_LIST']   = 'Create List';
$TEXT['EMPTY_LIST'] = 'Empty list';

$output_filter_help = [
                'Droplets'=>'Executes Droplets',
                'Email'=>'Makes e-mail links more difficult to read and spy out.',
                'SnippetCss'=>'Loads external snippet/tool style files with <code>register_frontend_modfiles("css")</code> into the HEAD',
                'FrontendCss'=>'Loads external page module style files with <code>register_frontend_modfiles("css")</code> into the HEAD',
                'ScriptVars'=>'Sets Javascript variables for further processing in the HEAD',
                'FrontendJs'=>'Loads external page module script files into HEAD',
                'SnippetBodyJs'=>'Loads external snippet/tool script files with <code>register_frontend_modfiles_body("js")</code> before BODY end.<br />'
                                . 'It is not necessary to switch on the filter RegisterModFiles',
                'LoadOnFly'=>'Loads DomReady and LoadOnFLy script into HEAD for dynamic loading of external styles',
                'Jquery'=>'Enables the integration of jQuery<br />'
                        . '<ol start="1">'
                        . '<li>1) RegisterModFiles turned on old procedure</li>'
                        . '<ul style="padding-left: 1.525em;">'
                        . '<li>Loading jQuery into the HEAD with <code>register_frontend_modfiles("jquery")</code></li>'
                        . '<li>Loading jQuery before BODY end with <code>register_frontend_modfiles_body("jquery")</code></li>'
                        . '<li>Setting the jQuery checkbox is not required</li>'
                        . '</ul>'
                        . '<li>2) RegisterModFiles switched off new procedure</li>'
                        . '<ul style="padding-left: 1.525em;">'
                        . '<li>load jQuery into HEAD with </li>'
                        . '<li><code>register_frontend_modfiles("css")</code></li>'
                        . '<li>Setting the jQuery checkbox is required</li>'
                        . '</ul>'
                        . '</ol>'
                        . '',

                'JqueryUI'=>'Activates jQueryUi for jQuery',
                'SnippetJs'=>'Loads external snippet/tool script files into HEAD',
                'FrontendBodyJs'=>'Loads external page module script files with <code>register_frontend_modfiles_body("js")</code> before BODY end.<br />'
                                . 'It is not necessary to enable the RegisterModFiles',
                'OpF'=>'Output filter Dashboard',
                'RegisterModFiles'=>'<p>To support older templates and backward compatibility<br />'
                                  . 'the <code>register_frontend_modfiles...functions...</code> </p>'
                                  . '<ol>'
                                  . '<li style="font-weight:bold;">1) RegisterModFiles turned on old procedure</li>'
                                  . '<ul style="padding-left: 1.525em;">'
                                  . 'Setting the checkboxes is not required and will not affect the inclusion<br />'
                                  . '<li>Load the external styles with <code>register_frontend_modfiles("css")</code>.'
                                  . '<li>Loading the external scripts with <code>register_frontend_modfiles("js")</code>.'
                                  . '<li>Loading jQuery with <code>register_frontend_modfiles("jquery")</code>.'
                                  . '<li>additionally load <code>ScriptVar,domReady.js and LoadOnFly.js</code>.'
                                  . '<li>&nbsp;</li>'
                                  . '<li>'
                                  . 'Loading front_body.js scripts before BODY end <br />'
                                  . '<code>register_frontend_modfiles_body("jquery")</code> and<br />'
                                  . '<code>register_frontend_modfiles_body("js")</code><br />'
                                  . '</li>'
                                  . '<li>&nbsp;</li>'
                                  . '</ul>'
                                  . '<li style="font-weight:bold;">2) RegisterModFiles switched off new procedure</li>'
                                  . '<ul style="padding-left: 1.525em;">'
                                  . '<li>Loads all external styles/scripts into the HEAD via <code>register_frontend_modfiles("css")</code></li>'
                                  . '<li>By setting the checkboxes you determine yourself what should be included</li>'
                                  . '</ul>'
                                  . '</ol>'

                ,'at_replacement' => '',
                'dot_replacement' => '',
                'RelUrl' => 'Changes absolute to relative urls',
                'OutputFilterMode' => '',
                'ReplaceSysvar' => '',
                'WbLink' => 'Changes wblink placeholder to absolute urls',
                'email_filter' =>'',
                'mailto_filter' =>'',
                'CssToHead' => 'Searches the content for style blocks and link CSS tags'
                            . ' and moves it into the HEAD area!',
                'W3Css' => 'Valid for non-W3Css compliant templates, for modules styled with W3Css<br />'
                              . 'Searches the content for the first W3Css class selector'
                              . ' and loads the required external w3.css into the HEAD area!<br />'
                              . '</b>If the filter is activated, If the parameter is activated, it can influence the frontend output!</b>',

        ];
$MOD_MAIL_FILTER['HELP_MISSING'] = 'There is no help for this filter yet';
