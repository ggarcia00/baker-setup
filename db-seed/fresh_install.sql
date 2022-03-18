-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: localhost    Database: baker
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `wb_addons`
--

DROP TABLE IF EXISTS `wb_addons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_addons` (
  `addon_id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `directory` varchar(140) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `function` varchar(96) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `version` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `platform` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `license` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`addon_id`),
  UNIQUE KEY `ident_addons` (`function`,`directory`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_addons`
--

LOCK TABLES `wb_addons` WRITE;
/*!40000 ALTER TABLE `wb_addons` DISABLE KEYS */;
INSERT INTO `wb_addons` VALUES (1,'language','BG','Български','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(2,'language','CA','Català','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(3,'language','CS','Čeština','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(4,'language','DA','Dansk','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(5,'language','DE','Deutsch','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(6,'language','EN','English','','','4.0.1','2.10.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(7,'language','ES','Español','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(8,'language','ET','Eesti','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(9,'language','FI','Suomi','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(10,'language','FR','Français','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(11,'language','HR','Hrvatski','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(12,'language','HU','Magyar','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(13,'language','IT','Italiano','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(14,'language','LV','Latviešu','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(15,'language','NL','Nederlands','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(16,'language','NO','Norsk','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(17,'language','PL','Polski','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(18,'language','PT','Portuguese (Brazil)','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(19,'language','RU','Русский','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(20,'language','SE','Svenska','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(21,'language','SK','Slovenčina','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(22,'language','TR','Türkçe','','','4.0.0','2.11.0','Manuela v.d.Decken, Dietmar Wöllbrink','GNU General Public License'),(23,'module','WBLingual','WebsiteBaker Lingual v2.0.6','This snippet switches between different languages','snippet','2.0.6','2.12.2','Luisehahne','GNU General Public License'),(24,'module','captcha_control','Captcha Spam-Protect v2.2.1','Admin-Tool to control CAPTCHA and ASP','tool','2.2.1','2.12.2','Thomas Hornik (thorn),Luisehahne','GNU General Public License'),(25,'module','ckeditor','CKEditor v4.16.0.0','includes CKEditor 4.16.0 Standard, CKE allows editing content and can be integrated in frontend and backend modules.','wysiwyg','4.16.0.0','2.13.0','Michael Tenschert, Dietrich Roland Pehlke, erpe, WebBird, Marmot, Luisehahne','<a  href=\"https://www.gnu.org/licenses/lgpl.html\">LGPL</a>'),(26,'module','code','Code v3.0.6','This module allows you to execute PHP commands (limit access to users you trust!!)','page','3.0.6','2.12.2','Ryan Djurovich','GNU General Public License'),(27,'module','droplets','Droplets v3.3.2','This tool allows you to manage your local Droplets.','tool','3.3.2','2.13.0','Ruud and pcwacht, Luisehahne','GNU General Public License'),(28,'module','form','Form Modul v3.2.4','This module allows you to create customised online forms, such as a feedback form. Thank-you to Rudolph Lartey who help enhance this module, providing code for extra field types, etc.','page','3.2.4','2.13.0','Ryan Djurovich & Rudolph Lartey - additions John Maats - PCWacht, dev-team','GNU General Public License'),(29,'module','jsadmin','Javascript Admin v2.1.1','This module adds Javascript functionality to the Website Baker Admin to improve some of the UI interactions. Uses the YahooUI library.','tool','2.1.1','2.12.2','Stepan Riha, Swen Uth','BSD License'),(30,'module','menu_link','Menu Link v3.0.0','This module allows you to insert a link into the menu.','page','3.0.0','2.12.2','Ryan Djurovich, thorn, Luisehahne','GNU General Public License'),(31,'module','news','News v3.9.16','This page type is designed for making a news page.','page','3.9.16','2.13.0','Ryan Djurovich, Rob Smith, Werner v.d.Decken','GNU General Public License'),(32,'module','output_filter','Output Filter Frontend v1.3.9','This Add-On allows to filter the output directly before it is sent to the browser. Each individual filter can be activated/deactivated by the ACP.','tool','1.3.9','2.13.0','Christian Sommer(doc), Manuela v.d. Decken(DarkViper), Dietmar Wöllbrink(Luisehahne)','GNU General Public License'),(33,'module','show_menu2','show_menu2 v4.10.1','A code snippet for the Website Baker CMS providing a complete replacement for the built-in menu functions. See <a href=\"http://code.jellycan.com/show_menu2/\" >http://code.jellycan.com/show_menu2/</a> for details or view the <a href=\"http://localhost:8080/modules/show_menu2/README.en.txt\" >readme</a> file.','snippet','4.10.1','2.11.0','Brodie Thiesfield','GNU General Public License'),(34,'module','wrapper','Wrapper v3.2.1','This module allows you to show third party sites inside an inline frame','page','3.2.1','2.12.2','DarkViper, Luisehahne','GNU General Public License'),(35,'module','wysiwyg','WYSIWYG v3.1.0','This module allows you to edit the contents of a page using a graphical editor','page','3.1.0','2.12.2','Ryan Djurovich','GNU General Public License'),(36,'template','DefaultTemplate','WebsiteBaker Default Template v1.0.14','Default template for Website Baker. This template is designed with one goal in mind: to completely control layout with CSS','template','1.0.14','2.13.0','WebsiteBaker Project','<a href=\"https://www.gnu.org/licenses/gpl.html\">GNU General Public License</a>'),(37,'template','DefaultTheme','WebsiteBaker Default Theme v1.4.5','Default desktop backend theme for WebsiteBaker 2.12.x','theme','1.4.5','2.12.1','Johannes Tassilo Gruber, WebsiteBaker Project','<a href=\"https://www.gnu.org/licenses/gpl.html\">GNU General Public License</a>');
/*!40000 ALTER TABLE `wb_addons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_groups`
--

DROP TABLE IF EXISTS `wb_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_groups` (
  `group_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `system_permissions` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `module_permissions` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `template_permissions` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `ident_groups` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_groups`
--

LOCK TABLES `wb_groups` WRITE;
/*!40000 ALTER TABLE `wb_groups` DISABLE KEYS */;
INSERT INTO `wb_groups` VALUES (1,'Administrators','access,addons,admin,admin_basic,admin_advanced,admintools,admintools_view,admintools_advanced,groups,groups_view,groups_add,groups_delete,groups_modify,languages,languages_view,languages_install,languages_uninstall,media,media_view,media_create,media_delete,media_rename,media_upload,modules,modules_view,modules_advanced,modules_install,modules_uninstall,modules_settings,pages,pages_view,pages_add,pages_add_l0,pages_delete,pages_intro,pages_modify,pages_settings,preferences,preferences_view,settings,settings_view,settings_basic,settings_advanced,templates,templates_view,templates_install,templates_uninstall,users,users_view,users_add,users_delete,users_modify','','');
/*!40000 ALTER TABLE `wb_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_captcha_control`
--

DROP TABLE IF EXISTS `wb_mod_captcha_control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_captcha_control` (
  `captcha_type` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'calc_text',
  `enabled_captcha` int NOT NULL DEFAULT '0',
  `enabled_asp` int NOT NULL DEFAULT '1',
  `asp_session_min_age` int NOT NULL DEFAULT '20',
  `asp_view_min_age` int NOT NULL DEFAULT '10',
  `asp_input_min_age` int NOT NULL DEFAULT '5',
  `ct_text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ct_color` int NOT NULL DEFAULT '1',
  `use_sec_type` int NOT NULL DEFAULT '-1',
  `code_length` int NOT NULL DEFAULT '5',
  `image_width` int NOT NULL DEFAULT '225',
  `image_height` int NOT NULL DEFAULT '85',
  `num_lines` int NOT NULL DEFAULT '3',
  `noise_level` int NOT NULL DEFAULT '5',
  `captcha_expiration` int NOT NULL DEFAULT '900',
  `image_bg_dir` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'backgrounds/',
  `image_bg_color` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'F2F2F2',
  `ttf_file` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fonts/AHGBold.ttf',
  `text_color` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '7D7D7D',
  `line_color` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '7D7D7D',
  `noise_color` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '7D7D7D',
  `signature_color` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '777777',
  `image_signature` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_captcha_control`
--

LOCK TABLES `wb_mod_captcha_control` WRITE;
/*!40000 ALTER TABLE `wb_mod_captcha_control` DISABLE KEYS */;
INSERT INTO `wb_mod_captcha_control` VALUES ('calc_image',0,1,20,10,5,'',1,-1,5,225,85,3,5,900,'backgrounds/','F2F2F2','fonts/AHGBold.ttf','7D7D7D','7D7D7D','7D7D7D','777777','');
/*!40000 ALTER TABLE `wb_mod_captcha_control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_code`
--

DROP TABLE IF EXISTS `wb_mod_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_code` (
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_code`
--

LOCK TABLES `wb_mod_code` WRITE;
/*!40000 ALTER TABLE `wb_mod_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_droplets`
--

DROP TABLE IF EXISTS `wb_mod_droplets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_droplets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `modified_when` int NOT NULL DEFAULT '0',
  `modified_by` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '0',
  `admin_edit` int NOT NULL DEFAULT '0',
  `admin_view` int NOT NULL DEFAULT '0',
  `show_wysiwyg` int NOT NULL DEFAULT '0',
  `comments` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `droplet_name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_droplets`
--

LOCK TABLES `wb_mod_droplets` WRITE;
/*!40000 ALTER TABLE `wb_mod_droplets` DISABLE KEYS */;
INSERT INTO `wb_mod_droplets` VALUES (1,'EmailFilter','return true;\n','Emailfiltering on your output - dummy Droplet',1647624001,1,1,0,0,0,'usage:  [[EmailFilter]]\n'),(2,'LastModifiedPages','\n$oReg = \\bin\\WbAdaptor::getInstance();\n$sRetval = \'\';\n$iMax = ($max ?? 10);\n//if (PAGE_ID>0) { }\n$iNow = time();\n$sSql = \'\nSELECT\n`p`.`page_title`,`p`.`modified_when`,`p`.`modified_by`,`p`.`link`\n,UNIX_TIMESTAMP() `time_now`,`u`.`display_name`\nFROM `wb_pages` `p`\nINNER JOIN `wb_users` `u`\nON `u`.`user_id` = `p`.`modified_by`\nHAVING `p`.`modified_when`<= `time_now`\nORDER BY `p`.`modified_when` DESC\nLIMIT \'.$iMax.\'\n\';\nif ($oPages = $oReg->Db->query($sSql)){}\n    while (($aPages=$oPages->fetchRow(MYSQLI_ASSOC))){\n//        $sRetval =  \"This page was last modified on \".date(\"d/m/Y\",$mod_details[0]). \" at \".date(\"H:i\",$mod_details[0]).\".\";\n    }\n    return $sRetval;\n/* ------------------------------------------------------\nglobal $database, $wb;\n$max = isset($max) ? $max : 5;\n$output = \'\';\n//$output = \"<h3>Die Liste der $max zuletzt geänderten Seiten</h3>\";\n$ergebnis = $database->query (\"SELECT\n       \" . TABLE_PREFIX . \"pages.page_title,\n       \" . TABLE_PREFIX . \"pages.modified_by,\n       \" . TABLE_PREFIX . \"pages.modified_when,\n       \" . TABLE_PREFIX . \"pages.link,\n       \" . TABLE_PREFIX . \"users.display_name\n        FROM \" . TABLE_PREFIX . \"pages, \" . TABLE_PREFIX . \"users\n        WHERE \" . TABLE_PREFIX . \"pages.modified_by = \" . TABLE_PREFIX . \"users.user_id\n        AND  \" . TABLE_PREFIX . \"pages.visibility = \'public\' ORDER BY \" . TABLE_PREFIX . \"pages.modified_when DESC LIMIT $max \");\n$heute = floor(time() / 86400);\n$bisher = -1;\nwhile ($zeile = $ergebnis ->fetchRow() )\n{\n  $tag =floor($zeile[\'modified_when\'] / 86400);\n  $aktuell = $heute - $tag;\n  if ($aktuell > 3) { $aktuell = 3; }\n  if ($aktuell < 3) {\n    $aenderungsdatum= date(\"H:i \", $zeile[\'modified_when\']+TIMEZONE);\n  } else {\n    $aenderungsdatum= date(\"d. M Y \", $zeile[\'modified_when\']+TIMEZONE);\n  }\n  $cutzeichen=strrpos($weblink,\"/\");\n  $weblinktext = substr($weblink,0,$cutzeichen);\n  if ($weblinktext == \"\")\n  {\n    $weblink_text = \"(im Hauptverzeichnis)\";\n  }\n  else\n  {\n    $weblink_text = \"(in \" .  str_replace(\'/\', \' > \', $weblinktext) . \")\";\n  }\n  $weblink = $wb->page_link($zeile[\'link\']);\n  if ($bisher <> $aktuell)\n  {\n      $bisher = $aktuell;\n      switch ($aktuell)\n      {\n         case 0: $output .= \"<b style=\'color:blue\' class=\'lastchanges\'>Änderungen von heute</b>\\n\"; break;\n         case 1: $output .= \"<b style=\'color:blue\'  class=\'lastchanges\'>Änderungen von gestern</b>\\n\"; break;\n         case 2: $output .= \"<b class=\'lastchanges\'>Änderungen von vorgestern</b>\\n\"; break;\n         case 3: $output .= \"<b class=\'lastchanges\'>Änderungen die 3 Tage und mehr zurückliegen</b>\\n\"; break;\n      }\n  }\n  $output .= \"<p class=\'lastchanges\'>\" . $aenderungsdatum .\" &nbsp; <a href=\\\"\" .  \"$weblink\\\"><b>\" . $zeile[\'page_title\'] . \"</b></a> \". $weblink_text .\"</p>\\n\";\n}\nreturn $output;\n---- */\n','Displays the last modification time of pages',1647624001,1,1,0,0,0,'Use [[LastModifiedPages?max=5]]\n'),(3,'LoginBox','\nglobal $wb;\n$database = \\database::getInstance();\n$oLang = Translate::getInstance();\n$oLang->enableAddon(\'templates\\\\\'.TEMPLATE);\n$return_value = \'<div class=\"login-box\">\'.PHP_EOL;\n$return_admin = \' \';\n// Return a system permission\n$get_permission = function ($name, $type = \'system\')use ($wb)\n{\n    // Append to permission type\n    $type .= \'_permissions\';\n    // Check if we have a section to check for\n    if ($name == \'start\') {\n        return true;\n    } else {\n        // Set system permissions var\n        $system_permissions = $wb->get_session(\'SYSTEM_PERMISSIONS\');\n        // Set module permissions var\n        $module_permissions = $wb->get_session(\'MODULE_PERMISSIONS\');\n        // Set template permissions var\n        $template_permissions = $wb->get_session(\'TEMPLATE_PERMISSIONS\');\n        // Return true if system perm = 1\n        if (isset($$type) && is_array($$type) && is_numeric(array_search($name, $$type))) {\n            if ($type == \'system_permissions\') {\n                return true;\n            } else {\n                return false;\n            }\n        } else {\n            if ($type == \'system_permissions\') {\n                return false;\n            } else {\n                return true;\n            }\n        }\n    }\n}\n;\n$get_page_permission = function ($page, $action = \'admin\')use ($database, $wb)\n{\n    if ($action != \'viewing\') {\n        $action = \'admin\';\n    }\n    $action_groups = $action.\'_groups\';\n    $action_users  = $action.\'_users\';\n    if (is_array($page)) {\n        $groups = $page[$action_groups];\n        $users = $page[$action_users];\n    } else {\n        $sql = \'SELECT \'.$action_groups.\',\'.$action_users.\' FROM \'.TABLE_PREFIX.\'pages \'.\'WHERE page_id = \\\'\'.$page.\'\\\'\';\n        if ($oResults = $database->query($sql)) {\n            $aResult  = $oResults->fetchRow(MYSQLI_ASSOC);\n            $groups   = explode(\',\', str_replace(\'_\', \'\', $aResult[$action_groups]));\n            $users    = explode(\',\', str_replace(\'_\', \'\', $aResult[$action_users]));\n        }\n    }\n    $in_group = false;\n    foreach ($wb->get_groups_id() as $cur_gid) {\n        if (in_array($cur_gid, $groups)) {\n            $in_group = true;\n        }\n    }\n    if (!$in_group && !is_numeric(array_search($wb->get_user_id(), $users))) {\n        return false;\n    }\n    return true;\n}\n;\n// Get redirect\n$redirect_url = ((isset($_SESSION[\'HTTP_REFERER\']) && $_SESSION[\'HTTP_REFERER\'] != \'\') ? $_SESSION[\'HTTP_REFERER\'] : WB_URL);\n$redirect_url = (isset($redirect) && ($redirect != \'\') ? $redirect : $redirect_url);\nif ((FRONTEND_LOGIN == \'enabled\') && (defined(\'VISIBILITY\') && (VISIBILITY != \'private\')) && ($wb->get_session(\'USER_ID\') == \'\')) {\n    $return_value .= \'<form action=\"\'.LOGIN_URL.\'\" method=\"post\" class=\"login-table\">\'.PHP_EOL;\n    $return_value .=     \'<input type=\"hidden\" name=\"redirect\" value=\"\'.$redirect_url.\'\" />\'.PHP_EOL;\n    $return_value .=     \'<input type=\"hidden\" name=\"page_id\" value=\"\'.$wb->page_id.\'\" />\'.PHP_EOL;\n    $return_value .=     \'<fieldset>\'.PHP_EOL;\n    $return_value .=         \'<h3>\'.$oLang->TEXT_LOGIN.\'</h3>\'.PHP_EOL;\n    $return_value .=         \'<label for=\"username\">\'.$oLang->TEXT_USERNAME.\':</label>\'.PHP_EOL;\n    $return_value .=         \'<p><input type=\"text\" name=\"username\" id=\"username\"  /></p>\'.PHP_EOL;\n    $return_value .=         \'<label for=\"password\">\'.$oLang->TEXT_PASSWORD.\':</label>\'.PHP_EOL;\n    $return_value .=         \'<p><input type=\"password\" name=\"password\" id=\"password\" autocomplete=\"off\"/></p>\'.PHP_EOL;\n    $return_value .=         \'<p><input type=\"submit\" id=\"submit\" value=\"\'.$oLang->TEXT_LOGIN.\'\" class=\"dbutton\" /></p>\'.PHP_EOL;\n    $return_value .=         \'<ul class=\"login-advance\">\'.PHP_EOL;\n    $return_value .=             \'<li class=\"forgot\"><a href=\"\'.FORGOT_URL.\'\"><span>\'.$oLang->TEXT_FORGOT_DETAILS.\'</span></a></li>\'.PHP_EOL;\n    if (intval(FRONTEND_SIGNUP) > 0) {\n        $return_value .=         \'<li class=\"sign\"><a href=\"\'.SIGNUP_URL.\'\">\'.$oLang->TEXT_SIGNUP.\'</a></li>\'.PHP_EOL;\n    }\n    $return_value .=         \'</ul>\'.PHP_EOL;\n    $return_value .=     \'</fieldset>\'.PHP_EOL;\n    $return_value .= \'</form>\'.PHP_EOL;\n} elseif ((FRONTEND_LOGIN == \'enabled\') && (is_numeric($wb->get_session(\'USER_ID\')))) {\n    $return_value .= \'<form action=\"\'.LOGOUT_URL.\'\" method=\"post\" class=\"login-table\">\'.PHP_EOL;\n    $return_value .=     \'<input type=\"hidden\" name=\"redirect\" value=\"\'.$redirect_url.\'\" />\'.PHP_EOL;\n    $return_value .=     \'<input type=\"hidden\" name=\"page_id\" value=\"\'.$wb->page_id.\'\" />\'.PHP_EOL;\n    $return_value .=     \'<fieldset>\'.PHP_EOL;\n    $return_value .=         \'<h3>\'.$oLang->TEXT_LOGGED_IN.\'</h3>\'.PHP_EOL;\n    $return_value .=         \'<label>\'.$oLang->TEXT_WELCOME_BACK.\', \'.$wb->get_display_name().\'</label>\'.PHP_EOL;\n    $return_value .=         \'<p><input type=\"submit\" name=\"submit\" value=\"\'.$oLang->MENU_LOGOUT.\'\" class=\"dbutton\" /></p>\'.PHP_EOL;\n    $return_value .=         \'<ul class=\"logout-advance\">\'.PHP_EOL;\n    $return_value .=             \'<li class=\"preference\"><a href=\"\'.PREFERENCES_URL.\'\" title=\"\'.$oLang->MENU_PREFERENCES.\'\">\'.$oLang->MENU_PREFERENCES.\'</a></li>\'.PHP_EOL;\n    //  change ot the group that should get special links\n    if ($wb->ami_group_member(\'1\')){\n        $return_value .=         \'<li class=\"admin\"><a href=\"\'.ADMIN_URL.\'/index.php\" title=\"\'.$oLang->TEXT_ADMINISTRATION.\'\" class=\"blank_target\">\'.$oLang->TEXT_ADMINISTRATION.\'</a></li>\'.PHP_EOL;\n        //you can add more links for your users like userpage, lastchangedpages or something\n    }\n    //change ot the group that should get special links\n    if ($get_permission(\'pages_modify\') && $get_page_permission(PAGE_ID)) {\n        $return_value .=        \'<li class=\"modify\"><a  href=\"\'.ADMIN_URL.\'/pages/modify.php?page_id=\'.PAGE_ID.\'\" title=\"\'.$oLang->HEADING_MODIFY_PAGE.\'\" class=\"blank_target\">\'.$oLang->HEADING_MODIFY_PAGE.\n            \'</a></li>\'.PHP_EOL;\n    }\n    $return_value .=         \'</ul>\'.PHP_EOL;\n    $return_value .=     \'</fieldset>\'.PHP_EOL;\n    $return_value .= \'</form>\'.PHP_EOL;\n}\n$return_value .= \'</div>\'.PHP_EOL;\nreturn $return_value;\n','Puts a Login / Logout box on your page.',1647624001,1,1,0,0,0,'Use: [[LoginBox?redirect=url]]\nAbsolute or relative url possible\nRemember to enable frontend login in your website settings!!\n'),(4,'Lorem','$lorem = array();\n$lorem[] = \"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut odio. Nam sed est. Nam a risus et est iaculis adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer ut justo. In tincidunt viverra nisl. Donec dictum malesuada magna. Curabitur id nibh auctor tellus adipiscing pharetra. Fusce vel justo non orci semper feugiat. Cras eu leo at purus ultrices tristique.<br /><br />\";\n$lorem[] = \"Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br /><br />\";\n$lorem[] = \"Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.<br /><br />\";\n$lorem[] = \"Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.<br /><br />\";\n$lorem[] = \"Cras consequat magna ac tellus. Duis sed metus sit amet nunc faucibus blandit. Fusce tempus cursus urna. Sed bibendum, dolor et volutpat nonummy, wisi justo convallis neque, eu feugiat leo ligula nec quam. Nulla in mi. Integer ac mauris vel ligula laoreet tristique. Nunc eget tortor in diam rhoncus vehicula. Nulla quis mi. Fusce porta fringilla mauris. Vestibulum sed dolor. Aliquam tincidunt interdum arcu. Vestibulum eget lacus. Curabitur pellentesque egestas lectus. Duis dolor. Aliquam erat volutpat. Aliquam erat volutpat. Duis egestas rhoncus dui. Sed iaculis, metus et mollis tincidunt, mauris dolor ornare odio, in cursus justo felis sit amet arcu. Aenean sollicitudin. Duis lectus leo, eleifend mollis, consequat ut, venenatis at, ante.<br /><br />\";\n$lorem[] = \"Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<br /><br />\";\nif (!isset($blocks)) $blocks=1;\n$blocks = (int)$blocks - 1;\nif ($blocks <= 0) $blocks = 0;\nif ($blocks > 5) $blocks = 5;\n$returnvalue = \"\";\nfor ( $i=0 ; $i<=$blocks ; $i++) {\n$returnvalue .= $lorem[$i];\n}\nreturn $returnvalue;\n','Create Lorum Ipsum text',1647624001,1,1,0,0,0,'Use: [[Lorem?blocks=6]] (max 6 paragraphs)\n'),(5,'ModifiedWhen','\nglobal $database, $wb;\nif (PAGE_ID>0) {\n$query=$database->query(\"SELECT `modified_when` FROM `\".TABLE_PREFIX.\"pages` WHERE `page_id`=\".PAGE_ID);\n$mod_details=$query->fetchRow();\nreturn \"This page was last modified on \".date(\"d/m/Y\",$mod_details[0]). \" at \".date(\"H:i\",$mod_details[0]).\".\";\n}\n','Displays the last modification time of the current page',1647624001,1,1,0,0,0,'Use [[ModifiedWhen]]\n'),(6,'NextPage','$sInfo = show_menu2(0, SM2_CURR, SM2_START, SM2_ALL|SM2_BUFFER|SM2_SHOWHIDDEN, \'[if(class==menu-current){[level] [sib] [sibCount] [parent]}]\', \'\', \'\', \'\');\n$aInfo = (empty($sInfo) ? [] : explode(\' \', $sInfo));\n$nxt = 0;\n$sRetval = \'\';\nif (sizeof($aInfo)){\n    list($nLevel, $nSib, $nSibCount, $nParent) = $aInfo;\n    $nxt = $nSib < $nSibCount ? $nSib + 1 : 0;\n}\n// show next\nif ($nxt > 0) {\n    $sRetval = show_menu2(0, SM2_CURR, SM2_START, SM2_ALL|SM2_BUFFER|SM2_SHOWHIDDEN,    \"[if(sib==$nxt){&gt;&gt; [a][menu_title]</a>}]\", \'\', \'\', \'\');\n}\nreturn $sRetval;\n','Create a next link to your page',1647624001,1,1,0,0,0,'Display a link to the next page on the same menu level\n'),(7,'Oneliner','$line = file (dirname(__FILE__).\"/example/oneliners.txt\");\nshuffle($line);\nreturn $line[0];\n','Create a random oneliner on your page',1647624001,1,1,0,0,0,'Use: [[OneLiner]].\nThe file with the oneliner data is located in /modules/droplets/example/oneliners.txt;\n'),(8,'ParentPage','$info = show_menu2(0, SM2_CURR, SM2_START, SM2_ALL|SM2_BUFFER, \'[if(class==menu-current){[level] [sib] [sibCount] [parent]}]\', \'\', \'\', \'\');\nlist($nLevel, $nSib, $nSibCount, $nParent) = explode(\' \', $info);\n// show up level\nif ($nLevel > 0) {\n$lev = $nLevel - 1;\nreturn show_menu2(0, SM2_ROOT, SM2_CURR, SM2_CRUMB|SM2_BUFFER, \"[if(level==$lev){[a][menu_title]</a>}]\", \'\', \'\', \'\');\n}\nelse\nreturn \'(no parent)\';\n','Create a parent link to your page',1647624001,1,1,0,0,0,'Display a link to the parent page of the current page\n'),(9,'PreviousPage','$sInfo = show_menu2(0, SM2_CURR, SM2_START, SM2_ALL|SM2_BUFFER|SM2_SHOWHIDDEN, \'[if(class==menu-current){[level] [sib] [sibCount] [parent]}]\', \'\', \'\', \'\');\n$aInfo = (empty($sInfo) ? [] : explode(\' \', $sInfo));\n$prv = 0;\n$sRetval = \'\';\nif (sizeof($aInfo)){\n    list($nLevel, $nSib, $nSibCount, $nParent) = $aInfo;\n    $prv = $nSib > 1 ? $nSib - 1 : 0;\n}\n// show previous\nif ($prv > 0) {\n    $sRetval = show_menu2(0, SM2_CURR, SM2_START, SM2_ALL|SM2_BUFFER|SM2_SHOWHIDDEN, \"[if(sib==$prv){[a][menu_title]</a> &lt;&lt;}]\", \'\', \'\', \'\');\n}\nreturn $sRetval;\n','Create a previous link to your page',1647624002,1,1,0,0,0,'Display a link to the previous page on the same menu level\n'),(10,'RandomImage','$dir = ((isset($dir) && ($dir != \'\'))?$dir:\'\');\n$folder = opendir(WB_PATH.MEDIA_DIRECTORY.\'/\'.$dir.\'/.\');\n$names = array();\nwhile ($file = readdir($folder)) {\n    $ext = strtolower(substr($file, -4));\n    if ($ext == \".jpg\" || $ext == \".gif\" || $ext == \".png\") {\n        $names[count($names)] = $file;\n    }\n}\nclosedir($folder);\nshuffle($names);\n$image = $names[0];\n$name = substr($image, 0, -4);\nreturn \'<img src=\"\'.WB_URL.MEDIA_DIRECTORY.\'/\'.$dir.\'/\'.$image.\'\" alt=\"\'.$name.\'\" width=\"95%\" />\';\n','Get a random image from a folder in the MEDIA folder.',1647624002,1,1,0,0,0,'Commandline to use: [[RandomImage?dir=subfolder_in_mediafolder]]\n'),(11,'SearchBox','$return_value = \'\';\nif (SHOW_SEARCH) {\n    $oTrans = Translate::getInstance();\n    if (!isset($msg)){$msg=$oTrans->TEXT_SEARCHING;}\n    $return_value  = \'<div class=\"form-wrapper cf\">\';\n    $return_value  .= \'<form action=\"\'.WB_URL.\'/search/index\'.PAGE_EXTENSION.\'\" method=\"get\" name=\"search\" class=\"searchform\" id=\"search\">\';\n    //$return_value  .= \'<input style=\"color:#b3b3b3;\" type=\"text\" name=\"string\" size=\"25\" class=\"textbox\" value=\"\'.$msg.\'\" \'.$j.\'  />&nbsp;\';\n    $return_value  .= \'<input type=\"text\" name=\"string\" placeholder=\"\'.$msg.\'\" value=\"\" required>\';\n    $return_value  .= \'<button type=\"submit\">\'.$oTrans->TEXT_SEARCH.\'</button>\';\n    $return_value  .= \'</form>\';\n    $return_value  .= \'</div>\';\n}\nreturn $return_value;\n','Create a Searchbox on the position',1647624002,1,1,0,0,0,'Usage:  [[Searchbox]]\nOptional parameter \"?msg=the search message\"\nor in HTML Templates\nOptional parameter \"?msg=\"phptag echo lang variable; \"\n'),(12,'SectionPicker','\n    $content       = true;\n    $_sFrontendCss = $_sFrontendJs  = \'\';\n    $oReg          = \\bin\\WbAdaptor::getInstance();\n    $wb            = ($oReg->getApplication() ?? $GLOBALS[\'wb\']);\n    $oTrans        = $oReg->getTranslate();\n    $database      = $oReg->getDatabase();\n    $section_id    = \\intval($sid ?? 0);\n    if ($section_id > 0) {\n        $sSql = \'SELECT `page_id` FROM `\'.$database->TablePrefix.\'sections` \'\n              . \'WHERE `section_id` = \'.$section_id;\n        if (! \\is_null($page_id = $database->get_one($sSql))) {\n            $iPageIsVisibile = $wb->isPageVisible($page_id);\n            $sSql = \'SELECT `s`.*\'\n                  .     \', `p`.`viewing_groups`\'\n                  .     \', `p`.`visibility`\'\n                  .     \', `p`.`menu_title`\'\n                  .     \', `p`.`link` \'\n                  . \'FROM `\'.$database->TablePrefix.\'sections` `s`\'\n                  . \'INNER JOIN `\'.$database->TablePrefix.\'pages` `p` \'\n                  .    \'ON `p`.`page_id`=`s`.`page_id` \'\n                  . \'WHERE `s`.`section_id` = \'.$section_id.\' \'\n                  .   \'AND (\'.\\time().\' BETWEEN `s`.`publ_start` AND `s`.`publ_end`) \'\n                  .   \'AND `active` = 1 \'\n                  .   \'AND `p`.`visibility` NOT IN (\\\'deleted\\\',\\\'none\\\')\';\n            if (($oSection = $database->query($sSql))) {\n                while ($aSection = $oSection->fetchRow(\\MYSQLI_ASSOC)) {\n                    $section_id = $aSection[\'section_id\'];\n                    $module = $aSection[\'module\'];\n                    \\ob_start();\n                    require ($oReg->AppPath.\'modules/\'.$module.\'/view.php\');\n                    $content = \\ob_get_clean();\n                    $sFrontend = \'modules/\'.$module.\'/frontend\';\n                    $_sPattern = \'/<link[^>]*?href\\s*=\\s*\\\"\'\n                               . \\preg_quote($oReg->AppUrl.$sFrontend.\'.css\', \'/\')\n                               . \'\\\".*?\\/>/si\';\n                    if (! \\preg_match($_sPattern, $content)) {\n                        $sFrontendCssFile = (\\is_readable($oReg->AppPath.$sFrontend.\'.css\') ? $oReg->AppUrl.$sFrontend.\'.css\':\'\');\n                        if ($sFrontendCssFile != \'\'){\n                            $_sFrontendCss = \'\n                              <script>\n                                  try {\n                                      var ModuleCss = \"\'.$sFrontendCssFile.\'\";\n                                      if (ModuleCss!==\"\"){\n                                          if (typeof LoadOnFly === \"undefined\"){\n                                              include_file(ModuleCss, \"css\");\n                                          } else {\n                                              LoadOnFly(\"head\", ModuleCss);\n                                          }\n                                      }\n                                  } catch(e) {\n                                   /* alert(\"An error has occurred: \"+e.message)*/\n                                  }\n                              </script>\n                              \';\n                        }\n                    }\n                    $_sPattern = \'/<script[^>]*?src\\s*=\\s*\\\"\'\n                               . \\preg_quote($oReg->AppUrl.$sFrontend.\'.js\', \'/\')\n                               . \'\\\".*?\\/>/si\';\n                    if (! \\preg_match($_sPattern, $content)) {\n                        $sFrontendJsFile  = (\\is_readable($oReg->AppPath.$sFrontend.\'.js\') ? $oReg->AppUrl.$sFrontend.\'.js\':\'\');\n                        if ($sFrontendJsFile!=\'\'){\n                            $_sFrontendJs = \'\n                              <script>\n                                  try {\n                                      var ModuleJs  = \"\'.$sFrontendJsFile.\'\";\n                                      if (ModuleJs!==\"\"){\n                                          include_file(ModuleJs, \"js\");\n                                      }\n                                  } catch(e) {\n                                   /* alert(\"An error has occurred: \"+e.message)*/\n                                  }\n                              </script>\n                              \';\n                        }\n                    }\n                }  // while\n            }\n        } // page_id\n    } // has section_id\n    if ($content === true || trim($content) == \'\') {\n        $content = true;\n    } else {\n        $content = $_sFrontendCss.$_sFrontendJs.$content;\n    }\n    return $content;\n// end of file\n','Load the view.php from any other section-module',1647624002,1,1,0,0,0,'Use [[SectionPicker?sid=123]]\nDarkViper, Lusiehahne\n'),(13,'ShortUrl','\nglobal $page_id;\n$oReg = \\bin\\WbAdaptor::getInstance();\nif (is_readable($oReg->AppPath.\'short.php\')){\n    $pattern = \'/\\[wblink(.+?)\\]/s\';\n    preg_match_all($pattern,$wb_page_data,$ids);\n    foreach($ids[1] as $page_id) {\n        $pattern = \'/\\[wblink\'.$page_id.\'\\]/s\';\n        $get_link = $oReg->Db->query(\"SELECT `link` FROM `\".$oReg->TablePrefix.\"pages` WHERE `page_id` = \".$page_id);\n        $fetch_link = $get_link->fetchRow(MYSQLI_ASSOC);\n        $link = $oReg->App->page_link($fetch_link[\'link\'],true); // retro modus\n        $wb_page_data = preg_replace($pattern,$link,$wb_page_data);\n    }\n    $linkstart = $oReg->AppUrl.$oReg->PagesDir;\n    $linkend = $oReg->PageExtension;\n    $nwlinkstart = $oReg->AppUrl;\n    $nwlinkend = \'/\';\n    preg_match_all(\'~\'.$linkstart.\'(.*?)\\\\\'.$linkend.\'~\', $wb_page_data, $links);\n    foreach ($links[1] as $link) {\n        $wb_page_data = str_replace($linkstart.$link.$linkend, $nwlinkstart.$link.$nwlinkend, $wb_page_data);\n    }\n}\nreturn true;\n','create short url\'s with wblink',1647624002,1,1,0,0,0,'use [[ShortUrl]]\n'),(14,'ShowRandomWysiwyg','global $database;\n$content = \' \';\nif (isset($section)) {\n    if( preg_match(\'/^[0-9]+(?:\\s*[\\,\\|\\-\\;\\:\\+\\#\\/]\\s*[0-9]+\\s*)*$/\', $section)) {\n        if (is_readable(WB_PATH.\'/modules/wysiwyg/view.php\')) {\n            // if valid arguments given and module wysiwyg is installed\n            // split and sanitize arguments\n            $aSections = preg_split(\'/[\\s\\,\\|\\-\\;\\:\\+\\#\\/]+/\', $section);\n            $section_id = $aSections[array_rand($aSections)]; // get random element\n            ob_start(); // generate output by wysiwyg module\n            require(WB_PATH.\'/modules/wysiwyg/view.php\');\n            $content = ob_get_clean();\n        }\n    }\n}\nreturn $content;\n','Randomly display one WYSIWYG section from a given list',1647624002,1,1,0,0,0,'Use [[ShowRandomWysiwyg?section=10,12,15,20]]\npossible Delimiters: [ ,;:|-+#/ ]\n'),(15,'ShowRootParent','\nglobal $page_id;\n$oReg    = \\bin\\WbAdaptor::getInstance();\n$oDb     = $oReg->getDatabase();\n$oApp    = $oReg->getApplication();\n$sField  = \'parent\';\n$sIndex  = \'page_title\';\n$iPageId = (($oApp->page[\'page_id\']) ?? $page_id );\n$iField  = (($oApp->page[$sField]) ? $oApp->page[$sField] : $iPageId ); //$oApp->menu_title\nif ($iField == 0) {\n    \\trigger_error(sprintf(\"[%03d] [[ShowRootParent]] (page_id==%d) not found for (%s == %d) \",__LINE__,$iPageId,$sField,$iField, E_USER_NOTICE));\n    $sField = \'page_id\';\n    $iField = $oApp->getDefaultPageId();\n}\n// @parameter root_parent default or parent\n$aRetval = $oApp->getPage($iField);\n// @return page_title or menu_title\n$sRetval = $aRetval[\'page_title\'];\nreturn $sRetval;\n','Shows the root_parent page of a page tree',1647624002,1,1,0,0,0,'Use [[ShowRootParent]]\n'),(16,'ShowWysiwyg','global $database, $section_id, $module;\n$content = \' \';\n$section = isset($section) ? intval($section) : 0;\nif ($section) {\nif (is_readable(WB_PATH.\'/modules/wysiwyg/view.php\')) {\n// if valid section is given and module wysiwyg is installed\n$iOldSectionId = intval($section_id); // save old SectionID\n$section_id = $section;\nob_start(); // generate output by regulary wysiwyg module\nrequire(WB_PATH.\'/modules/wysiwyg/view.php\');\n$content = ob_get_clean();\n$section_id = $iOldSectionId; // restore old SectionId\n}\n}\nreturn $content;\n','Display one defined WYSIWYG section',1647624002,1,1,0,0,0,'Use [[ShowWysiwyg?section=10]]\n'),(17,'SiteMapChildRL','$content = \'\';\nif (isset($start) && !empty($start)) {\n    $iChild = (is_numeric($start) ? $start : PAGE_ID);\n    $content = show_menu2(SM2_ALLMENU,\n            $iChild,\n            SM2_ALL,\n            SM2_ALL|SM2_ALLINFO|SM2_BUFFER,\n            \'[li]<span class=\"nav-link\">[a][page_title]</a></span>\',\n            false,\n            \'<ul id=\"servicelinks\">\');\n}\nreturn $content.\'\';\n','List of pages below current page or page_id. Modified for servicelinks.',1647624002,1,1,0,0,0,'[[SiteMapChildRL?start=11]]\n(optional parameter) start=page_id\n'),(18,'SiteModified','global $database, $wb;\n$retVal = \' \';\nif (PAGE_ID > 0) {\n    $query = $database->query(\"SELECT max(modified_when) FROM \".TABLE_PREFIX.\"pages\");\n    $mod_details = $query->fetchRow();\n    $retVal = \"This site was last modified on \".date(\"d/m/Y\", $mod_details[0]).\" at \".date(\"H:i\", $mod_details[0]).\".\";\n}\nreturn $retVal;\n','Create information on when your site was last updated.',1647624002,1,1,0,0,0,'Create information on when your site was last updated. Any page update counts.\n'),(19,'Text2Image','//clean up old files..\n$dir = WB_PATH.\'/temp/\';\n$dp = opendir($dir) or die (\'Could not open \'.$dir);\nwhile ($file = readdir($dp)) {\nif ((preg_match(\'/img_/\',$file)) && (filemtime($dir.$file)) <  (strtotime(\'-10 minutes\'))) {\nunlink($dir.$file);\n}\n}\nclosedir($dp);\n$imgfilename = \'img_\'.rand().\'_\'.time().\'.jpg\';\n//create image\n$padding = 0;\n$font = 3;\n$height = imagefontheight($font) + ($padding * 2);\n$width = imagefontwidth($font) * strlen($text) + ($padding * 2);\n$image_handle = imagecreatetruecolor($width, $height);\n$text_color = imagecolorallocate($image_handle, 0, 0, 0);\n$background_color = imagecolorallocate($image_handle, 255, 255, 255);\n$bg_height = imagesy($image_handle);\n$bg_width = imagesx($image_handle);\nimagefilledrectangle($image_handle, 0, 0, $bg_width, $bg_height, $background_color);\nimagestring($image_handle, $font, $padding, $padding, $text, $text_color);\nimagejpeg($image_handle,WB_PATH.\'/temp/\'.$imgfilename,100);\nimagedestroy($image_handle);\nreturn \'<img src=\"\'.WB_URL.\'/temp/\'.$imgfilename.\'\" style=\"border:0px;margin:0px;padding:0px;vertical-align:middle;\" />\';\n','Create an image from the textparameter',1647624002,1,1,0,0,0,'Use [[text2image?text=The text to create]]\n'),(20,'Zitate','$line = file (dirname(__FILE__).\"/example/oneliners.txt\");\nshuffle($line);\nreturn $line[0];\n','Create a random oneliner on your page',1647624002,1,1,0,0,0,'Use: [[Zitate]].\nThe file with the oneliner data is located in /modules/droplets/example/oneliners.txt;\n'),(21,'iEditThisPage','\n// @author: Manuela von der Decken\nglobal $wb,$database;\n$oReg   = \\bin\\WbAdaptor::getInstance();\n$oDb    = $database;\n$oTrans = Translate::getInstance();\n$returnvalue = \'\';\nif ($wb->is_authenticated()) {\n    $is_admin = false;\n    $page_id = PAGE_ID == 0 ? $wb->default_page_id : PAGE_ID;\n    $user_id = $wb->get_user_id();\n    $sql = \'SELECT `admin_users`, `admin_groups` \'\n    . \'FROM `\'.TABLE_PREFIX.\'pages` \'\n    . \'WHERE `page_id` = \'.$page_id;\n    if (($rset = $oDb->query($sql)) != null) {\n        if (($rec = $rset->fetchRow(MYSQLI_ASSOC)) != null) {\n            $is_admin = ($wb->ami_group_member($rec[\'admin_groups\']) ||\n            ($wb->is_group_match($user_id, $rec[\'admin_users\'])) );\n        }\n    }\n    if ($is_admin) {\n        $tpl  = \'<a href=\"\'.ADMIN_URL.\'/pages/%1$s.php?page_id=\'.$page_id.\'\"  title=\"%2$s\">\'\n        . \'<img src=\"\'.THEME_URL.\'/images/%3$s_16.png\" alt=\"%2$s\" style=\"margin: 0 0.325em;\" /></a>\';\n        $show = ((!isset($show) || $show == \'\') ? 7 : (int)$show);\n        $show = ($show > 7 ? 7 : (int)$show);\n        $show = ($show < 2 ? 1 : (int)$show );\n        if ($show & 1) {\n            $returnvalue .= sprintf($tpl, \'modify\', $oTrans->HEADING_MODIFY_PAGE, \'modify\');\n        }\n        $sys_perm = $wb->get_session(\'SYSTEM_PERMISSIONS\');\n        if (@is_array($sys_perm)) {\n            if (($show & 2) && (array_search(\'pages_settings\', $sys_perm)!==false)) {\n                $returnvalue .= sprintf($tpl, \'settings\', $oTrans->HEADING_MODIFY_PAGE_SETTINGS, \'edit\');\n            }\n            if (($show & 4) && (array_search(\'pages_modify\', $sys_perm)!==false)) {\n                $returnvalue .= sprintf($tpl, \'sections\', $oTrans->HEADING_MANAGE_SECTIONS, \'sections\');\n            }\n        }\n        if ($returnvalue != \'\') {\n            $returnvalue  = \'<div class=\"iEditThisPage\">\'.$returnvalue.\'</div>\';\n        }\n    }\n}\nreturn($returnvalue == \'\' ? true : $returnvalue);\n','Puts Edit-Buttons on every page you have rights for. 1=modify page, 2=modify pagesettings, 4=modify sections, or add values to combine buttons.',1647624002,1,1,0,0,0,'Use: [[iEditThisPage?show=7]].\n1=modify page, 2=modify pagesettings, 4=modify sections, or add values to combine buttons.\nYou can format the appearance using CSS-class \'div.iEditThisPage\' in your basic-css file\n'),(22,'iPageIcon','// @author: Manuela von der Decken, Dietmar Wöllbrink\n// @param int $type: 0=page_icon(default) | 1=menu_icon_0 | 2=menu_icon_1\n// @param string $icon: name of a default image placed in WB_PATH/TEMPLATE/\n// @return: a valid image-URL or empty string\n//\n$oDb = $GLOBAL[\'database\'];\n$type = !isset($type)?0:(intval($type) % 3);\n$icontypes = array(\n    0 => \'page_icon\',\n    1 => \'menu_icon_0\',\n    2 => \'menu_icon_1\');\n$icon_url = \'\';\nif (isset($icon) && is_readable(WB_PATH.\'/templates/\'.TEMPLATE.\'/\'.$icon)) {\n    $icon_url = WB_URL.\'/templates/\'.TEMPLATE.\'/\'.$icon;\n}\n$tmp_trail = array_reverse($GLOBALS[\'wb\']->page_trail);\nforeach ($tmp_trail as $pid) {\n    $sql = \'SELECT `\'.$icontypes[$type].\'` \';\n    $sql .= \'FROM `\'.TABLE_PREFIX.\'pages` \';\n    $sql .= \'WHERE `page_id`=\'.(int)$pid;\n    if (($icon = $oDb->get_one($sql)) != false) {\n        $icon = ltrim(str_replace(\'\\\\\', \'/\', $icon), \'/\');\n        if (file_exists(WB_PATH.\'/\'.$icon)) {\n            $icon_url = WB_URL.\'/\'.$icon;\n            break;\n        }\n    }\n}\nreturn $icon_url;\n','search for an image in current page. If no image is present, the image of the parent page is inherited.',1647624002,1,1,0,0,0,'Use: [[iPageIcon?type=1]]\nDisplay the page-icon(0)(default) or menu_icon_0(1) or menu_icon_1(2) if found\n'),(23,'iSectionPicker','\n/*\n * Copyright (C) 2020 Manuela von der Decken <manuela@isteam.de>\n *\n * DO NOT ALTER OR REMOVE COPYRIGHT OR THIS HEADER\n *\n * This program is distributed in the hope that it will be useful,\n * but WITHOUT ANY WARRANTY; without even the implied warranty of\n * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\n * GNU General Public License 2 for more details.\n *\n * You should have received a copy of the GNU General Public License 2\n * along with this program.  If not, see <https://www.gnu.org/licenses/>.\n */\n/**\n * iSectionPicker\n *\n * @category     Addon\n * @package      Droplet\n * @copyright    Manuela von der Decken <manuela@isteam.de>\n * @author       Manuela von der Decken <manuela@isteam.de>\n * @license      GNU General Public License 2\n * @version      0.0.1 $Rev: 12 $\n * @revision     $Id: iSectionPicker.php 12 2020-08-06 05:25:43Z Manuela $\n * @since        File available since 07.03.2020\n * @deprecated   no / since 0000/00/00\n * @description  xxx\n */\n// import global objects\n    $oReg      = \\bin\\WbAdaptor::getInstance();\n    $oWb = $wb = ($oReg->getApplication() ?? $GLOBALS[\'wb\']);\n    $oDb       = $database = $oReg->getDatabase();\n    $sContent  = true;\n// sanitize argument $sid\n    $iSectionId = \\intval($sid ?? 0);\n// try to load the section and the corresponding page\n    $sql = \'SELECT `s`.*, \'\n//         .        \'`p`.`viewing_groups`, \'\n         .        \'`p`.`visibility`, \'\n         .        \'`p`.`link`, \'\n         .        \'`p`.`page_title`, \'\n         .        \'`p`.`menu_title` \'\n         . \'FROM `\'.$oDb->TablePrefix.\'sections` `s` \'\n         . \'INNER JOIN `\'.$oDb->TablePrefix.\'pages` `p` \'\n         .    \'ON `p`.`page_id`=`s`.`page_id` \'\n         . \'WHERE `s`.`section_id` = \'.$iSectionId.\' \'\n         .   \'AND (\'.\\time().\' BETWEEN `s`.`publ_start` AND `s`.`publ_end`) \'\n         .   \'AND `active` = 1 \'\n         .   \'AND `p`.`visibility` NOT IN (\\\'deleted\\\',\\\'none\\\')\';\n    try {\n        $oResultSet = $oDb->query($sql);\n        if (($aRecord = $oResultSet->fetchRow(\\MYSQLI_ASSOC))) {\n            unset($sql);\n// if matching record found\n            $module = $sModuleName = $aRecord[\'module\'];\n            $section_id  = $aRecord[\'section_id\'];\n            $page_id     = $aRecord[\'page_id\'];\n            if (!$oWb->isPageVisible($page_id)) {\n                throw new \\InvalidArgumentException(\'no valid visibility\');\n            }\n// include the buffered view.php of the needed module\n            $sFrontendViewFile = $oReg->AppPath.\'modules/\'.$sModuleName.\'/view.php\';\n            if (\\is_readable($sFrontendViewFile)){\n                \\ob_start();\n                require $sFrontendViewFile;\n                $sContent = \\ob_get_clean();\n            } else {\n                throw new \\InvalidArgumentException(\\sprintf(\'%s/view.php not found/readable\',$sModuleName));\n            }\n// define path and url to frontend.*\n            $sFrontendPath = $oReg->AppPath.\'modules/\'.$sModuleName.\'/frontend\';\n            $sFrontendUrl  = $oReg->AppUrl.\'modules/\'.$sModuleName.\'/frontend\';\n//check out if conternt already contains a link to frontend.css\n            $sFrontendCss = \'\';\n            $sPattern = \'/<link[^>]*?src\\s*=\\s*\\\"\'.\\preg_quote($sFrontendUrl, \'/\').\'css\\\".*?\\/>/si\';\n            if (!\\preg_match($sPattern, $sContent)) {\n// if not, then try to find and include frontend.css\n                if (\\is_readable($sFrontendPath.\'.css\')) {\n                    $sFrontendCss = \'\n                    <script>\n                        try {\n                            var ModuleCss = \"\'.$sFrontendUrl.\'.css\";\n                            var UserCss   = \"\'.$sFrontendUrl.\'User.css\";\n                            if (typeof LoadOnFly === \"undefined\") {\n                                include_file(ModuleCss, \"css\");\n                                include_file(UserCss, \"css\");\n                            } else {\n                                LoadOnFly(\"head\", ModuleCss);\n                                LoadOnFly(\"head\", UserCss);\n                            }\n                        } catch(e) {\n                            /* alert(\"an error has occured: \"+e.message) */\n                        }\n                    </script>\n                    \';\n                }\n            }\n//check out if conternt already contains a <script link> to frontend.js\n            $sFrontendJs = \'\';\n            $sPattern = \'/<script[^>]*?src\\s*=\\s*\\\"\'.\\preg_quote($sFrontendUrl, \'/\').\'js\\\".*?\\/>/si\';\n            if (!\\preg_match($sPattern, $sContent)) {\n// if not, then try to find and include frontend.css\n                if (\\is_readable($sFrontendPath.\'js\')) {\n                    $sFrontendJs = \'\n                    <script>\n                        try {\n                            var ModuleJs = \"\'.$sFrontendUrl.\'js\";\n                            include_file(ModuleJs, \"js\");\n                        } catch(e) {\n                            /* alert(\"an error has occured: \"+e.message) */\n                        }\n                    </script>\n                    \';\n                }\n            }\n            $sContent = $sFrontendCss.$sFrontendJs.$sContent;\n        }//end pageisvisible\n    } catch (\\Throwable $ex) {\n        /* place to insert different error/logfile messages */\n        $sErrMessage = \'[\'.\\basename(__FILE__, \'.php\').\' :: \'.$ex->getMessage().\']\';\n        $sContent =  ($oReg->Debug ?? false) ? $sErrMessage : true;\n    }\n    return $sContent;\n','Load the view.php from any other section-module',1647624002,1,1,0,0,0,'Use [[iSectionPicker?sid=123]]\n'),(24,'showDateBlock','\n$sSpace = \'\';\n$sTitle = ($title ?? \'\');\n$sDesc  = ($desc ?? \'\');\n$content = \"\";\n    try {\n    $sContent  = \'<div id=\"showDate\" class=\"w3-container w3-auto w3-center\">\'.PHP_EOL;\n    if ($sTitle){$sContent .= \'<h3>\'.$sTitle .\'</h3>\'.PHP_EOL;}\n    $sContent .= \'<h4>Heute ist \';\n    $sContent .= \'<span id=\"dateStamp\"></span>\';\n    $sContent .= \'<span id=\"timeStamp\"></span>\'.PHP_EOL;\n    $sContent .= \'</h4>\'.PHP_EOL;\n    if ($sDesc){$sContent .= \'<h3>\'.$sDesc.\'</h3>\'.PHP_EOL;}\n    $sContent .= \'</div>\'.PHP_EOL;\n    } catch (\\Throwable $ex) {\n        /* place to insert different error/logfile messages */\n        $sContent = \'$scontent = \'.$ex->getMessage();\n    }\n    return $sContent;\n','Insert Full Date and Clock',1647624002,1,1,0,0,0,'usage: [[showDateBlock?title=Allgemeine Termine&amp;desc=Terminänderungen bleiben vorbehalten]]\ncan be call without parameters\n'),(25,'year','$datum = date(\"Y\");\nreturn \"$datum\";\n','zeigt das aktuelle Jahr an',1647624002,1,1,0,0,0,'[[year]] zeigt die Jahrezahl\n');
/*!40000 ALTER TABLE `wb_mod_droplets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_form_fields`
--

DROP TABLE IF EXISTS `wb_mod_form_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_form_fields` (
  `field_id` int NOT NULL AUTO_INCREMENT,
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `layout` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `position` int NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `required` int NOT NULL DEFAULT '0',
  `value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `extra` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_form_fields`
--

LOCK TABLES `wb_mod_form_fields` WRITE;
/*!40000 ALTER TABLE `wb_mod_form_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_form_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_form_settings`
--

DROP TABLE IF EXISTS `wb_mod_form_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_form_settings` (
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `layout` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email_to` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email_from` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email_fromname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email_subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `success_page` int NOT NULL DEFAULT '-1',
  `success_email_to` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `success_email_from` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `success_email_fromname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `success_email_text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `success_email_subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `stored_submissions` int NOT NULL DEFAULT '0',
  `max_submissions` int NOT NULL DEFAULT '0',
  `perpage_submissions` int NOT NULL DEFAULT '10',
  `use_captcha` int NOT NULL DEFAULT '0',
  `subject_email` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `captcha_action` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `divider` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `captcha_style` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data_protection_link` int NOT NULL DEFAULT '-1',
  `use_data_protection` int NOT NULL DEFAULT '0',
  `use_captcha_auth` int NOT NULL DEFAULT '0',
  `prevent_user_confirmation` int NOT NULL DEFAULT '0',
  `info_dsgvo_in_mail` int NOT NULL DEFAULT '0',
  `title_placeholder` int NOT NULL DEFAULT '0',
  `form_required` int NOT NULL DEFAULT '0',
  `frontend_css` int NOT NULL DEFAULT '0',
  `header` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `field_loop` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `extra` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `footer` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_form_settings`
--

LOCK TABLES `wb_mod_form_settings` WRITE;
/*!40000 ALTER TABLE `wb_mod_form_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_form_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_form_submissions`
--

DROP TABLE IF EXISTS `wb_mod_form_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_form_submissions` (
  `submission_id` int NOT NULL AUTO_INCREMENT,
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `submitted_when` int NOT NULL DEFAULT '0',
  `submitted_by` int NOT NULL DEFAULT '0',
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`submission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_form_submissions`
--

LOCK TABLES `wb_mod_form_submissions` WRITE;
/*!40000 ALTER TABLE `wb_mod_form_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_form_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_jsadmin`
--

DROP TABLE IF EXISTS `wb_mod_jsadmin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_jsadmin` (
  `id` int NOT NULL DEFAULT '0',
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_jsadmin`
--

LOCK TABLES `wb_mod_jsadmin` WRITE;
/*!40000 ALTER TABLE `wb_mod_jsadmin` DISABLE KEYS */;
INSERT INTO `wb_mod_jsadmin` VALUES (1,'mod_jsadmin_persist_order',1),(2,'mod_jsadmin_ajax_order_pages',1),(3,'mod_jsadmin_ajax_order_sections',1);
/*!40000 ALTER TABLE `wb_mod_jsadmin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_menu_link`
--

DROP TABLE IF EXISTS `wb_mod_menu_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_menu_link` (
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `target_page_id` int NOT NULL DEFAULT '0',
  `redirect_type` int NOT NULL DEFAULT '301',
  `anchor` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `extern` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_menu_link`
--

LOCK TABLES `wb_mod_menu_link` WRITE;
/*!40000 ALTER TABLE `wb_mod_menu_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_menu_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_news_comments`
--

DROP TABLE IF EXISTS `wb_mod_news_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_news_comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `post_id` int NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `commented_when` int NOT NULL DEFAULT '0',
  `commented_by` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_news_comments`
--

LOCK TABLES `wb_mod_news_comments` WRITE;
/*!40000 ALTER TABLE `wb_mod_news_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_news_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_news_groups`
--

DROP TABLE IF EXISTS `wb_mod_news_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_news_groups` (
  `group_id` int NOT NULL AUTO_INCREMENT,
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '0',
  `position` int NOT NULL DEFAULT '0',
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `ident_news` (`section_id`,`title`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_news_groups`
--

LOCK TABLES `wb_mod_news_groups` WRITE;
/*!40000 ALTER TABLE `wb_mod_news_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_news_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_news_layouts`
--

DROP TABLE IF EXISTS `wb_mod_news_layouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_news_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `layout` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `header` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_loop` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `footer` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_header` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_footer` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comments_header` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comments_loop` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comments_footer` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comments_page` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_news_layouts`
--

LOCK TABLES `wb_mod_news_layouts` WRITE;
/*!40000 ALTER TABLE `wb_mod_news_layouts` DISABLE KEYS */;
INSERT INTO `wb_mod_news_layouts` VALUES (1,'default_layout','\n<table class=\"loop-header\">\n    <tbody>','\n        <tr id=\"NL[POST_ID]\" class=\"post-top w3-light-gray\">\n            <td class=\"post-title\"><a href=\"[LINK]\">[TITLE]</a></td>\n            <td class=\"post-date\">[PUBLISHED_DATE], [PUBLISHED_TIME]</td>\n        </tr>\n        <tr>\n            <td class=\"post-short\" colspan=\"2\">[SHORT]\n                <span style=\"visibility:[SHOW_READ_MORE];\">\n                  <a class=\"readmore\" href=\"[LINK]\">[TEXT_READ_MORE]</a>\n                </span>\n           </td>\n        </tr>','\n    </tbody>\n</table>\n<table class=\"loop-footer\">\n    <tbody>\n        <tr>\n           <td class=\"page-left\">[PREVIOUS_PAGE_LINK]</td>\n           <td class=\"page-center\">[OF]</td>\n           <td class=\"page-right\">[NEXT_PAGE_LINK]</td>\n        </tr>\n    </tbody>\n</table>','\n<table id=\"NH[POST_ID]\" class=\"post-header\">\n    <tbody>\n        <tr>\n            <td><h3>[TITLE]</h3></td>\n            <td rowspan=\"3\" style=\"display: [DISPLAY_IMAGE]\">[GROUP_IMAGE]</td>\n        </tr>\n        <tr>\n            <td class=\"public-info\"><b>[TEXT_POSTED_BY] [DISPLAY_NAME] [TEXT_ON] [PUBLISHED_DATE]</b></td>\n        </tr>\n        <tr style=\"display: [DISPLAY_GROUP]\">\n            <td class=\"group-page\"><a href=\"[BACK]\">[PAGE_TITLE]</a> &raquo; <a href=\"[GROUP_BACK]\">[GROUP_TITLE]</a></td>\n         </tr>\n    </tbody>\n</table>','\n<p>[TEXT_LAST_CHANGED]: [MODI_DATE] [TEXT_AT] [MODI_TIME]</p>\n<a href=\"[BACK]\">[TEXT_BACK]</a>','\n\n<table class=\"comment-header\">\n    <tbody>','\n        <tr>\n            <td class=\"comment_title\">[TITLE]</td>\n            <td class=\"comment_info\">[TEXT_BY] [DISPLAY_NAME] [TEXT_ON] [DATE] [TEXT_AT] [TIME]</td>\n        </tr>\n        <tr>\n            <td colspan=\"2\" class=\"comment-text\">[COMMENT]</td>\n        </tr>','\n    </tbody>\n</table>\n<br /><a href=\"[ADD_COMMENT_URL]\">[TEXT_ADD_COMMENT]</a>','\n<h2>[TEXT_COMMENT]</h2>\n<h3>[POST_TITLE]</h3>'),(2,'div_layout','<div class=\"news-loop-header\">','\n        <div id=\"NL[POST_ID]\" class=\"post-top\">\n            <div class=\"post-title\"><a href=\"[LINK]\">[TITLE]</a></div>\n            <div class=\"post-date\">[PUBLISHED_DATE], [PUBLISHED_TIME]</div>\n        </div>\n        <div>\n            <div class=\"post-short\">[SHORT]\n                <span style=\"visibility:[SHOW_READ_MORE];\">\n                  <a class=\"readmore\" href=\"[LINK]\">[TEXT_READ_MORE]</a>\n                </span>\n           </div>\n        </div>','\n</div>\n    <div class=\"w3-display-container news-container news-loop-footer\" style=\"display:[DISPLAY_PREVIOUS_NEXT_LINKS]\">\n        <div class=\"w3-display-left news-third news-left-align\">[PREVIOUS_PAGE_LINK]</div>\n        <div class=\"w3-display-middle news-third news-center\">[OF]</div>\n        <div class=\"w3-display-right news-third news-right-align\">[NEXT_PAGE_LINK]</div>\n    </div>','\n<div id=\"NH[POST_ID]\" class=\"news-post-header\">\n    <div>\n        <div><h3>[TITLE]</h3></div>\n        <div style=\"display: [DISPLAY_IMAGE]\">[GROUP_IMAGE]</div>\n    </div>\n    <div>\n        <div class=\"public-info\">\n            <b>[TEXT_POSTED_BY] [DISPLAY_NAME] [TEXT_ON] [PUBLISHED_DATE]</b>\n        </div>\n    </div>\n    <div style=\"display: [DISPLAY_GROUP]\">\n        <div class=\"group-page\">\n            <a href=\"[BACK]\">[PAGE_TITLE]</a> &raquo; <a href=\"[GROUP_BACK]\">[GROUP_TITLE]</a>\n        </div>\n    </div>\n</div>','\n<p>[TEXT_LAST_CHANGED]: [MODI_DATE] [TEXT_AT] [MODI_TIME]</p>\n<a href=\"[BACK]\">[TEXT_BACK]</a>','\n<br /><br />\n<h2>[TEXT_COMMENTS]</h2>\n<div class=\"news-comment-header\">','\n    <div>\n        <div class=\"news-comment_title\">[TITLE] </div>\n        <div class=\"news-comment_info\">[TEXT_BY] [DISPLAY_NAME] [TEXT_ON] [DATE] [TEXT_AT] [TIME]</div>\n    </div>\n    <div>\n        <div class=\"news-comment-text\">[COMMENT]</div>\n    </div>','\n</div>\n<br /><a href=\"[ADD_COMMENT_URL]\">[TEXT_ADD_COMMENT]</a>','\n<h2>[TEXT_COMMENT]</h2>\n<h3>[POST_TITLE]</h3>'),(3,'div_new_layout','\n<div class=\"news-loop-header\">','\n        <div id=\"NL[POST_ID]\" class=\"post-top\">\n            <div class=\"post-title\"><a href=\"[LINK]\">[TITLE]</a></div>\n            <div class=\"post-date\">[PUBLISHED_DATE], [PUBLISHED_TIME]</div>\n        </div>\n        <div>\n            <div class=\"post-short\">[SHORT]\n                <span style=\"visibility:[SHOW_READ_MORE];\">\n                  <a class=\"readmore\" href=\"[LINK]\">[TEXT_READ_MORE]</a>\n                </span>\n           </div>\n        </div>','\n</div>\n    <div class=\"w3-display-container news-container news-loop-footer\" style=\"display:[DISPLAY_PREVIOUS_NEXT_LINKS]\">\n        <div class=\"w3-display-left news-third news-left-align\">[PREVIOUS_PAGE_LINK]</div>\n        <div class=\"w3-display-middle news-third news-center\">[OF]</div>\n        <div class=\"w3-display-right news-third news-right-align\">[NEXT_PAGE_LINK]</div>\n    </div>','\n<div id=\"NH[POST_ID]\" class=\"news-post-header\">\n    <div>\n        <div><h3>[TITLE]</h3></div>\n        <div style=\"display: [DISPLAY_IMAGE]\">[GROUP_IMAGE]</div>\n    </div>\n    <div>\n        <div class=\"public-info\">\n            <b>[TEXT_POSTED_BY] [DISPLAY_NAME] [TEXT_ON] [PUBLISHED_DATE]</b>\n        </div>\n    </div>\n    <div style=\"display: [DISPLAY_GROUP]\">\n        <div class=\"group-page\">\n            <a href=\"[BACK]\">[PAGE_TITLE]</a> &raquo; <a href=\"[GROUP_BACK]\">[GROUP_TITLE]</a>\n        </div>\n    </div>\n</div>','\n<p>[TEXT_LAST_CHANGED]: [MODI_DATE] [TEXT_AT] [MODI_TIME]</p>\n<a href=\"[BACK]\">[TEXT_BACK]</a>','\n<br /><br />\n<h2>[TEXT_COMMENTS]</h2>\n<div class=\"news-comment-header\">','\n    <div>\n        <div class=\"news-comment_title\">[TITLE] </div>\n        <div class=\"news-comment_info\">[TEXT_BY] [DISPLAY_NAME] [TEXT_ON] [DATE] [TEXT_AT] [TIME]</div>\n    </div>\n    <div>\n        <div class=\"news-comment-text\">[COMMENT]</div>\n    </div>','\n</div>\n<br /><a href=\"[ADD_COMMENT_URL]\">[TEXT_ADD_COMMENT]</a>','\n<h2>[TEXT_COMMENT]</h2>\n<h3>[POST_TITLE]</h3>');
/*!40000 ALTER TABLE `wb_mod_news_layouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_news_posts`
--

DROP TABLE IF EXISTS `wb_mod_news_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_news_posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `group_id` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '0',
  `position` int NOT NULL DEFAULT '0',
  `title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content_short` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_long` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `commenting` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_when` int NOT NULL DEFAULT '0',
  `created_by` int NOT NULL DEFAULT '0',
  `published_when` int NOT NULL DEFAULT '0',
  `published_until` int NOT NULL DEFAULT '0',
  `posted_when` int NOT NULL DEFAULT '0',
  `posted_by` int NOT NULL DEFAULT '0',
  `modified_when` int NOT NULL DEFAULT '0',
  `modified_by` int NOT NULL DEFAULT '0',
  `moderated` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_news_posts`
--

LOCK TABLES `wb_mod_news_posts` WRITE;
/*!40000 ALTER TABLE `wb_mod_news_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_news_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_news_settings`
--

DROP TABLE IF EXISTS `wb_mod_news_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_news_settings` (
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `posts_per_page` int NOT NULL DEFAULT '5',
  `commenting` varchar(14) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `resize` int NOT NULL DEFAULT '0',
  `use_captcha` int NOT NULL DEFAULT '1',
  `order` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'DESC',
  `layout_id` int NOT NULL DEFAULT '1',
  `layout` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default_layout',
  `order_field` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'published_when',
  `data_protection_link` int NOT NULL DEFAULT '-1',
  `use_data_protection` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_news_settings`
--

LOCK TABLES `wb_mod_news_settings` WRITE;
/*!40000 ALTER TABLE `wb_mod_news_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_news_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_output_filter`
--

DROP TABLE IF EXISTS `wb_mod_output_filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_output_filter` (
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_output_filter`
--

LOCK TABLES `wb_mod_output_filter` WRITE;
/*!40000 ALTER TABLE `wb_mod_output_filter` DISABLE KEYS */;
INSERT INTO `wb_mod_output_filter` VALUES ('at_replacement','[at]'),('CleanUp','1'),('CssToHead','1'),('dot_replacement','[dot]'),('Droplets','1'),('Email','1'),('email_filter','1'),('FrontendBodyJs','1'),('FrontendCss','1'),('FrontendJs','1'),('Jquery','1'),('JqueryUI','1'),('LoadOnFly','1'),('mailto_filter','1'),('OpF','0'),('OutputFilterMode','0'),('RegisterModFiles','1'),('RelUrl','0'),('ReplaceSysvar','1'),('ScriptVars','1'),('ShortUrl','1'),('SnippetBodyJs','1'),('SnippetCss','1'),('SnippetJs','1'),('W3Css','1'),('W3Css_force','0'),('WbLink','1'),('WbLinkXXL','1');
/*!40000 ALTER TABLE `wb_mod_output_filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_wrapper`
--

DROP TABLE IF EXISTS `wb_mod_wrapper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_wrapper` (
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `url` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `height` int NOT NULL DEFAULT '400',
  `min_height` int NOT NULL DEFAULT '400',
  `attribute` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_wrapper`
--

LOCK TABLES `wb_mod_wrapper` WRITE;
/*!40000 ALTER TABLE `wb_mod_wrapper` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_wrapper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_mod_wysiwyg`
--

DROP TABLE IF EXISTS `wb_mod_wysiwyg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_mod_wysiwyg` (
  `section_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_mod_wysiwyg`
--

LOCK TABLES `wb_mod_wysiwyg` WRITE;
/*!40000 ALTER TABLE `wb_mod_wysiwyg` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_mod_wysiwyg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_pages`
--

DROP TABLE IF EXISTS `wb_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_pages` (
  `page_id` int NOT NULL AUTO_INCREMENT,
  `parent` int NOT NULL DEFAULT '0',
  `root_parent` int NOT NULL DEFAULT '0',
  `level` int NOT NULL DEFAULT '0',
  `link` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `target` varchar(14) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_title` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `page_icon` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `menu_title` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_icon_0` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `menu_icon_1` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tooltip` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `page_trail` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `template` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `visibility` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `position` int NOT NULL DEFAULT '0',
  `menu` int NOT NULL DEFAULT '0',
  `language` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `searching` int NOT NULL DEFAULT '0',
  `admin_groups` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `admin_users` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `viewing_groups` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `viewing_users` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `modified_when` int NOT NULL DEFAULT '0',
  `modified_by` int NOT NULL DEFAULT '0',
  `custom01` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `custom02` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_code` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_pages`
--

LOCK TABLES `wb_pages` WRITE;
/*!40000 ALTER TABLE `wb_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_search`
--

DROP TABLE IF EXISTS `wb_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_search` (
  `search_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `extra` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`search_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_search`
--

LOCK TABLES `wb_search` WRITE;
/*!40000 ALTER TABLE `wb_search` DISABLE KEYS */;
INSERT INTO `wb_search` VALUES (1,'header','\n<h1>[TEXT_SEARCH]</h1>\n\n<form name=\"searchpage\" action=\"[WB_URL]/search/index.php\" method=\"get\">\n<table>\n<tr>\n<td>\n<input type=\"hidden\" name=\"search_path\" value=\"[SEARCH_PATH]\" />\n<input type=\"text\" name=\"string\" value=\"[SEARCH_STRING]\" style=\"width: 100%;\" />\n</td>\n<td width=\"150\">\n<input type=\"submit\" value=\"[TEXT_SEARCH]\" style=\"width: 100%;\" />\n</td>\n</tr>\n<tr>\n<td colspan=\"2\">\n<input type=\"radio\" name=\"match\" id=\"match_all\" value=\"all\"[ALL_CHECKED] />\n<label for=\"match_all\">[TEXT_ALL_WORDS]</label>\n<input type=\"radio\" name=\"match\" id=\"match_any\" value=\"any\"[ANY_CHECKED] />\n<label for=\"match_any\">[TEXT_ANY_WORDS]</label>\n<input type=\"radio\" name=\"match\" id=\"match_exact\" value=\"exact\"[EXACT_CHECKED] />\n<label for=\"match_exact\">[TEXT_EXACT_MATCH]</label>\n</td>\n</tr>\n</table>\n\n</form>\n\n<hr />\n    ',''),(2,'footer','',''),(3,'results_header','[TEXT_RESULTS_FOR] \'<b>[SEARCH_STRING]</b>\':\n<table style=\"padding-top: 10px;width: 100%;\">',''),(4,'results_loop','<tr style=\"background-color: #F0F0F0;\">\n<td><a href=\"[LINK]\">[TITLE]</a></td>\n<td style=\"float: right;\">[TEXT_LAST_UPDATED_BY] [DISPLAY_NAME] [TEXT_ON] [DATE]</td>\n</tr>\n<tr><td colspan=\"2\" style=\"text-align: justify; padding-bottom: 5px;\">[DESCRIPTION]</td></tr>\n<tr><td colspan=\"2\" style=\"text-align: justify; padding-bottom: 10px;\">[EXCERPT]</td></tr>',''),(5,'results_footer','</table>',''),(6,'no_results','<tr><td><p>[TEXT_NO_RESULTS]</p></td></tr>',''),(7,'module_order','faqbaker,manual,wysiwyg',''),(8,'max_excerpt','15',''),(9,'time_limit','0',''),(10,'cfg_enable_old_search','true',''),(11,'cfg_search_keywords','true',''),(12,'cfg_search_description','true',''),(13,'cfg_show_description','true',''),(14,'cfg_enable_flush','false',''),(15,'template','','');
/*!40000 ALTER TABLE `wb_search` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_sections`
--

DROP TABLE IF EXISTS `wb_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_sections` (
  `section_id` int NOT NULL AUTO_INCREMENT,
  `page_id` int NOT NULL DEFAULT '0',
  `position` int NOT NULL DEFAULT '0',
  `module` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `block` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `publ_start` int NOT NULL DEFAULT '0',
  `publ_end` int NOT NULL DEFAULT '2147483647' COMMENT 'max ((2^31)-1)',
  `title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `anchor` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `attribute` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_sections`
--

LOCK TABLES `wb_sections` WRITE;
/*!40000 ALTER TABLE `wb_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_settings`
--

DROP TABLE IF EXISTS `wb_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_settings` (
  `name` varchar(160) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_settings`
--

LOCK TABLES `wb_settings` WRITE;
/*!40000 ALTER TABLE `wb_settings` DISABLE KEYS */;
INSERT INTO `wb_settings` VALUES ('website_description',''),('website_keywords',''),('website_header',''),('website_footer',''),('website_signature',''),('wysiwyg_style','font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;'),('er_level','0'),('sec_anchor','Sec'),('default_date_format','M d Y'),('default_time_format','g:i A'),('redirect_timer','1000'),('home_folders','true'),('warn_page_leave','1'),('confirmed_registration','0'),('default_template','DefaultTemplate'),('default_theme','DefaultTheme'),('default_charset','utf-8'),('multiple_menus','true'),('page_level_limit','4'),('intro_page','false'),('page_trash','inline'),('homepage_redirection','false'),('page_languages','true'),('wysiwyg_editor','ckeditor'),('manage_sections','true'),('section_blocks','true'),('smart_login','true'),('frontend_login','false'),('frontend_signup','false'),('search','public'),('page_extension','.php'),('page_spacer','-'),('pages_directory','/pages'),('page_icon_dir','/templates/*/title_images'),('media_directory','/media'),('rename_files_on_upload','ph.*?,cgi,pl,pm,exe,com,bat,pif,cmd,src,asp,aspx,js'),('media_width','0'),('media_height','0'),('media_compress','75'),('string_dir_mode','0755'),('string_file_mode','0644'),('twig_version','3'),('jquery_version','1.9.1'),('jquery_cdn_link',''),('wbmailer_routine','phpmail'),('wbmailer_default_sendername','WB Mailer'),('wbmailer_smtp_debug','0'),('wbmailer_smtp_host',''),('wbmailer_smtp_auth',''),('wbmailer_smtp_username',''),('wbmailer_smtp_password',''),('sec_token_fingerprint','true'),('sec_token_netmask4','24'),('sec_token_netmask6','64'),('sec_token_life_time','1800'),('debug','false'),('dev_infos','false'),('sgc_excecute','false'),('system_locked','0'),('user_login','1'),('wbmailer_smtp_port','25'),('wbmailer_smtp_secure','TLS'),('mediasettings',''),('dsgvo_settings','a:3:{s:19:\"use_data_protection\";b:1;s:2:\"DE\";i:0;s:2:\"EN\";i:0;}'),('media_version','1.0.0'),('wb_version','2.13.0'),('wb_revision','63'),('wb_sp',''),('website_title','Site do bom'),('default_language','PT'),('app_name','PHPSESSID-WB-4e39d0'),('default_timezone','-10800'),('operating_system','linux'),('server_email','email@email.com');
/*!40000 ALTER TABLE `wb_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_users`
--

DROP TABLE IF EXISTS `wb_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wb_users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL DEFAULT '0',
  `groups_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` int NOT NULL DEFAULT '0',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `confirm_code` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `confirm_timeout` int NOT NULL DEFAULT '0',
  `remember_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_reset` int NOT NULL DEFAULT '0',
  `display_name` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timezone` int NOT NULL DEFAULT '0',
  `date_format` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `time_format` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `home_folder` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login_when` int NOT NULL DEFAULT '0',
  `login_ip` varchar(90) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_users`
--

LOCK TABLES `wb_users` WRITE;
/*!40000 ALTER TABLE `wb_users` DISABLE KEYS */;
INSERT INTO `wb_users` VALUES (1,1,'1',1,'administrador','202cb962ac59075b964b07152d234b70','',0,'',0,'Administrator','email@email.com',-10800,'M d Y','g:i A','PT','',1647624013,'172.20.0.1');
/*!40000 ALTER TABLE `wb_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-18 17:24:01
