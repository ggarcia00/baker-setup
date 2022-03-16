<?php
//:Displays the last modification time of pages
//:Use [[LastModifiedPages?max=5]]
$oReg = \bin\WbAdaptor::getInstance();
$sRetval = '';
$iMax = ($max ?? 10);
//if (PAGE_ID>0) { }
$iNow = time();
$sSql = '
SELECT
`p`.`page_title`,`p`.`modified_when`,`p`.`modified_by`,`p`.`link`
,UNIX_TIMESTAMP() `time_now`,`u`.`display_name`
FROM `wb_pages` `p`
INNER JOIN `wb_users` `u`
ON `u`.`user_id` = `p`.`modified_by`
HAVING `p`.`modified_when`<= `time_now`
ORDER BY `p`.`modified_when` DESC
LIMIT '.$iMax.'
';

if ($oPages = $oReg->Db->query($sSql)){}
    while (($aPages=$oPages->fetchRow(MYSQLI_ASSOC))){
//        $sRetval =  "This page was last modified on ".date("d/m/Y",$mod_details[0]). " at ".date("H:i",$mod_details[0]).".";
    }
    return $sRetval;

/* ------------------------------------------------------
global $database, $wb;
$max = isset($max) ? $max : 5;
$output = '';
//$output = "<h3>Die Liste der $max zuletzt geänderten Seiten</h3>";

$ergebnis = $database->query ("SELECT
       " . TABLE_PREFIX . "pages.page_title,
       " . TABLE_PREFIX . "pages.modified_by,
       " . TABLE_PREFIX . "pages.modified_when,
       " . TABLE_PREFIX . "pages.link,
       " . TABLE_PREFIX . "users.display_name
        FROM " . TABLE_PREFIX . "pages, " . TABLE_PREFIX . "users
        WHERE " . TABLE_PREFIX . "pages.modified_by = " . TABLE_PREFIX . "users.user_id
        AND  " . TABLE_PREFIX . "pages.visibility = 'public' ORDER BY " . TABLE_PREFIX . "pages.modified_when DESC LIMIT $max ");
$heute = floor(time() / 86400);
$bisher = -1;
while ($zeile = $ergebnis ->fetchRow() )
{
  $tag =floor($zeile['modified_when'] / 86400);
  $aktuell = $heute - $tag;
  if ($aktuell > 3) { $aktuell = 3; }
  if ($aktuell < 3) {
    $aenderungsdatum= date("H:i ", $zeile['modified_when']+TIMEZONE);
  } else {
    $aenderungsdatum= date("d. M Y ", $zeile['modified_when']+TIMEZONE);
  }

  $cutzeichen=strrpos($weblink,"/");
  $weblinktext = substr($weblink,0,$cutzeichen);
  if ($weblinktext == "")
  {
    $weblink_text = "(im Hauptverzeichnis)";
  }
  else
  {
    $weblink_text = "(in " .  str_replace('/', ' > ', $weblinktext) . ")";
  }
  $weblink = $wb->page_link($zeile['link']);

  if ($bisher <> $aktuell)
  {
      $bisher = $aktuell;
      switch ($aktuell)
      {
         case 0: $output .= "<b style='color:blue' class='lastchanges'>Änderungen von heute</b>\n"; break;
         case 1: $output .= "<b style='color:blue'  class='lastchanges'>Änderungen von gestern</b>\n"; break;
         case 2: $output .= "<b class='lastchanges'>Änderungen von vorgestern</b>\n"; break;
         case 3: $output .= "<b class='lastchanges'>Änderungen die 3 Tage und mehr zurückliegen</b>\n"; break;
      }
  }

  $output .= "<p class='lastchanges'>" . $aenderungsdatum ." &nbsp; <a href=\"" .  "$weblink\"><b>" . $zeile['page_title'] . "</b></a> ". $weblink_text ."</p>\n";

}

return $output;
---- */