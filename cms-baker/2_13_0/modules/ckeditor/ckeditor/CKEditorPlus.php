<?php

namespace addon\ckeditor\ckeditor;
/**
use addon\ckeditor\ckeditor\CKEditor;
 *
 * @category       modules
 * @package        ckeditor
 * @authors        WebsiteBaker Project, Michael Tenschert, Dietrich Roland Pehlke,D. Wöllbrink,Marmot
 * @copyright      WebsiteBaker Org. e.V.
 * @link           http://websitebaker.org/
 * @license        http://www.gnu.org/licenses/gpl.html
 * @platform       WebsiteBaker 2.8.3
 * @requirements   PHP 5.3.6 and higher
 * @version        $Id: CKEditorPlus.php 68 2018-09-17 16:26:08Z Luisehahne $
 * @filesource     $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/modules/ckeditor/ckeditor/CKEditorPlus.php $
 * @lastmodified   $Date: 2018-09-17 18:26:08 +0200 (Mo, 17. Sep 2018) $
 *
 */


class CKEditorPlus extends \addon\ckeditor\ckeditor\CKEditor
{
    public $pretty = false;

    private $lookup_html = [
        '&gt;'    => ">",
        '&lt;'    => "<",
        '&quot;'  => "\"",
        '&amp;'   => "&"
    ];

/**
 *    Public var to force the editor to use the given params for width and height
 *
 */
    public $force = false;

    public $paths = [
        'contentsCss' => "",
        'stylesSet' => "",
        'templates_files' => "",
        'customConfig' => ""
    ];

    private $templateFolder = '';

    public $files = [
        'contentsCss' => [
            '/editor.css',
            '/css/editor.css',
            '/editor/editor.css'
        ],
        'stylesSet' => [
            '/editor.styles.js',
            '/js/editor.styles.js',
            '/editor/editor.styles.js'
        ],
        'templates_files' => [
            '/editor.templates.js',
            '/js/editor.templates.js',
            '/editor/editor.templates.js'
        ],
        'customConfig' => [
            '/wb_ckconfig.js',
            '/js/wb_ckconfig.js',
            '/editor/wb_ckconfig.js'
        ]
    ];
/*
    public function __construct() {
    }
*/
    public function setTemplatePath ($templateFolder='')
    {
//        static $initComplete;
        if($templateFolder=='') { return; }
        $this->templateFolder = $templateFolder;
        $_config = $this->config;
        foreach($this->files as $key=>$val) {
            foreach($val as $temp_path) {
                $base = "/templates/".$this->templateFolder.$temp_path;
                if (true == file_exists(WB_PATH.$base) ){
                    $this->paths[$key] = (($key=="stylesSet") ? "wb:" : "").WB_URL.$base;
                    break;
                }
            }
        }
        $this->config = array_merge($_config, $this->paths);;
    }

/**
 *    JavaScript handels LF/LB in another way as PHP, even inside an array.
 *    So we're in the need of pre-parse the entries.
 *
 */
    public function javascript_clean_str( &$aStr) {
        $vars = [
            '"' => "\\\"",
            '\'' => "",
            "\n" => "<br />",
            "\r" => ""
        ];

        return str_replace( array_keys($vars), array_values($vars), $aStr);
    }

/**
 *    @param    string    Any HTML-Source, pass by reference
 *
        $sOutput = str_replace(
            array_keys( $this->lookup_html ),
            array_values( $this->lookup_html ),
            $html_source
        );
 */
    public function reverse_htmlentities($html_source) {
        return htmlspecialchars_decode($html_source);
    }

/**    *************************************
 *    Additional test for the wysiwyg-admin
 */

/**
 *    @var    boolean
 *
 */
    public $wysiwyg_admin_exists = false;

/**
 *    Public function to look for the wysiwyg-admin table in the used database
 *
 *    @param    object    Any DB-Connector instance. Must be able to use a "query" method inside.
 *
 */
    public function looking_for_wysiwyg_admin( $db ) {
            if ($db->query("SHOW TABLES LIKE '%mod_editor_admin'")->numRows())
                $this->wysiwyg_admin_exists = true;
        }

/**
 *    Looks for an (local) url
 *
 *    @param    string    Key for tha assoc. config array
 *    @param    string    Local file we are looking for
 *    @param    string    Optional file-default-path if it not exists
 *    @param    string    Optional a path_addition, e.g. "wb:"
 *
 */
    public function resolve_path($key= "", $aPath="", $aPath_default="", $path_addition="")
    {
        static $initComplete = [];
        if ((!(empty($key))) || (!(empty($aPath))) (!(empty($aPath_default)))){
            $temp = WB_PATH.$aPath;
            if (true === file_exists($temp)) {
                $aPath = $path_addition.WB_URL.$aPath;
            } else {
                $aPath = $path_addition.WB_URL.$aPath_default;
            }
            if (array_key_exists($key, $this->paths)) {
                $this->config[$key] = (($this->paths[$key ] == "") ? $aPath : $this->paths[$key]) ;
                $initComplete[$key] = $this->config[$key];
            } else {
                $this->config[$key] = $aPath;
            }
        }
    }

/**
 *    More or less for debugging
 *
 *    @param    string    Name
 *    @param    string    Any content. Pass by reference!
 *    @return   string    The "editor"-JS HTML code
 *
 */
    public function to_HTML( $name, &$content, $config) {
        $old_return = $this->bOutputAsBuffer;
        $this->bOutputAsBuffer = true;
        $temp_HTML = $this->editor( $name, $content, $config);
        $this->bOutputAsBuffer = $old_return;
        if (true === $this->pretty) {
            $temp_HTML = str_replace (", ", ",\n ", $temp_HTML);
            $temp_HTML = "\n\n\n".$temp_HTML."\n\n\n";
        }
        return $temp_HTML;
    }
}