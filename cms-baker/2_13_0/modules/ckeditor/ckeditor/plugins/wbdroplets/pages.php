<?PHP


ob_start();
if (!defined('SYSTEM_RUN')) {
    $sConfigFile = \preg_replace('/^(.*?[\\\\\/])modules[\\\\\/].*$/', "$1config.php", __FILE__, 1);
    if (\is_readable($sConfigFile)) { require $sConfigFile; }
}
$wb284 = false;
// Create new admin object
$admin = new \admin('Pages', 'pages_modify', false);
$bAdminUser = (($admin->ami_group_member('1') ) || ($admin->get_user_id() === '1'));

if(!function_exists('cleanup')) {
    function cleanup($string)
    {
        return preg_replace("/\r?\n/", "\\n", \database::getInstance()->escapeString($string));
    }
} // end function cleanup

/**
 * setPrettyArray()
 *
 * @param integer $bLinefeed
 * @param integer $iWhiteSpaces
 * @param integer $iTabs
 * @return string
 */
    function setPrettyArray ( $bLinefeed = 1, $iWhiteSpaces = 0, $iTabs = 0 ){
        $sRetVal  = "";
        if ( $bLinefeed > 0 ) { $sRetVal .= "\n"; }
        if ( $iWhiteSpaces > 0 ) { $sRetVal .= str_repeat(" ",$iWhiteSpaces); }
        if ( $iTabs >  0 ) { $sRetVal .= str_repeat("\t",$iTabs); }
        return $sRetVal;
    }

$DropletSelectBox = "var DropletSelectBox = new Array( new Array( '', '' )";
$description = "var DropletInfoBox = new Array( new Array( '', '' )";
$usage = "var DropletUsageBox = new Array( new Array( '', '' )";

$array = [];
    $sql  = 'SELECT * FROM `'.TABLE_PREFIX.'mod_droplets` '
          . 'WHERE `active`=1 '
          . ($bAdminUser ? '' : 'AND `admin_view` NOT IN (1)')
          . 'ORDER BY `name` ASC';
    if($resRec = $database->query($sql))
    {
        while(!false == ($droplet = $resRec->fetchRow()) )
        {
            $title = cleanup($droplet['name']);
            $desc = cleanup($droplet['description']);
            $comments = cleanup($droplet['comments']);

            $DropletSelectBox .=  ", new Array( '".$title."', '".$droplet['name']."')";
            $description .=  ", new Array( '".$title."', '".$desc."')";
            $usage .=  ", new Array( '".$title."', '".$comments."')";
        }
    }

echo $DropletSelectBox .= " );\n";
echo $description .= " );\n";
echo $usage .= " );\n";
$output = ob_get_clean();
\header("Cache-Control: no-store, no-cache, must-revalidate");
\header("Cache-Control: post-check=0, pre-check=0, false");
\header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
\header("Pragma: no-cache");
\header("Accept-Ranges: bytes");
\header("Content-type: application/javascript; charset: UTF-8");

echo $output;
