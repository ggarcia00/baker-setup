//:create short url's if short.php is readable in Application Path with wblink
//:[[ShortUrl]]
global $page_id;
$oReg = WbAdaptor::getInstance();

if (is_readable($oReg->AppPath.'short.php')){
    $pattern = '/\[wblink(.+?)\]/s';
    preg_match_all($pattern,$wb_page_data,$ids);
    foreach($ids[1] AS $page_id) {
        $pattern = '/\[wblink'.$page_id.'\]/s';
        $get_link = $oReg->Db->query("SELECT `link` FROM `".$oReg->TablePrefix."pages` WHERE `page_id` = ".$page_id);
        $fetch_link = $get_link->fetchRow(MYSQLI_ASSOC);
        $link = $oReg->App->page_link($fetch_link['link'],true); // retro modus
        $wb_page_data = preg_replace($pattern,$link,$wb_page_data);
    }

    $linkstart = $oReg->AppUrl.$oReg->PagesDir;
    $linkend = $oReg->PageExtension;
    $nwlinkstart = $oReg->AppUrl;
    $nwlinkend = '/';

    preg_match_all('~'.$linkstart.'(.*?)\\'.$linkend.'~', $wb_page_data, $links);
    foreach ($links[1] as $link) {
        $wb_page_data = str_replace($linkstart.$link.$linkend, $nwlinkstart.$link.$nwlinkend, $wb_page_data);
    }
}
return true;