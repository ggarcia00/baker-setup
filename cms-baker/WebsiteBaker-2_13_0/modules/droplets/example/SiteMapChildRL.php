//:List of pages below current page or page_id. Modified for servicelinks.
//:[[SiteMapChildRL?start=11]]
//:(optional parameter) start=page_id
$content = '';
if (isset($start) && !empty($start)) {
    $iChild = (is_numeric($start) ? $start : PAGE_ID);
    $content = show_menu2(SM2_ALLMENU,
            $iChild,
            SM2_ALL,
            SM2_ALL|SM2_ALLINFO|SM2_BUFFER,
            '[li]<span class="nav-link">[a][page_title]</a></span>',
            false,
            '<ul id="servicelinks">');
}
return $content.'';