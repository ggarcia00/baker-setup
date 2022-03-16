-- <?php header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; flush(); exit;?>
-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 14. Aug 2014 um 10:46
-- Server Version: 5.5.32
-- PHP-Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- --------------------------------------------------------
-- Database structure for module 'news'
--
-- Replacements: {TABLE_PREFIX}, {TABLE_ENGINE}, {FIELD_COLLATION}
--
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `addons`
--
DROP TABLE IF EXISTS `{TABLE_PREFIX}addons`;
CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}addons` (
  `addon_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `directory` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `name` varchar(250){FIELD_COLLATION} NOT NULL DEFAULT '',
  `description` text{FIELD_COLLATION} NOT NULL,
  `function` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `version` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `platform` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `author` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `license` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  PRIMARY KEY (`addon_id`)
){TABLE_ENGINE};

ALTER TABLE `{TABLE_PREFIX}addons` DROP INDEX `ident`;
ALTER TABLE `{TABLE_PREFIX}addons` DROP INDEX `ident_addons`;
ALTER TABLE `{TABLE_PREFIX}addons` {XTABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}addons` CHANGE `type` `type` VARCHAR(20) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}addons` CHANGE `directory` `directory` VARCHAR(140) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}addons` CHANGE `name` `name` varchar(250){FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}addons` CHANGE `description` `description` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}addons` CHANGE `function` `function` VARCHAR(96) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}addons` CHANGE `version` `version` VARCHAR(200) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}addons` CHANGE `platform` `platform` VARCHAR(200) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}addons` CHANGE `author` `author` VARCHAR(500) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}addons` CHANGE `license` `license` VARCHAR(500) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}addons` ADD UNIQUE `ident_addons` (`function`, `directory`) USING BTREE;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `groups`
--
DROP TABLE IF EXISTS `{TABLE_PREFIX}groups`;
CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250){FIELD_COLLATION} NOT NULL DEFAULT '',
  `system_permissions` text{FIELD_COLLATION} NOT NULL,
  `module_permissions` text{FIELD_COLLATION} NOT NULL,
  `template_permissions` text{FIELD_COLLATION} NOT NULL,
  PRIMARY KEY (`group_id`)
){TABLE_ENGINE};

ALTER TABLE `{TABLE_PREFIX}addons` DROP INDEX `ident_groups`;
ALTER TABLE `{TABLE_PREFIX}groups` {XTABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}groups` CHANGE `name` `name` VARCHAR(200) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}groups` CHANGE `system_permissions` `system_permissions` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}groups` CHANGE `module_permissions` `module_permissions` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}groups` CHANGE `template_permissions` `template_permissions` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}groups` ADD UNIQUE `ident_groups` ( `name` ) USING BTREE;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `pages`
--
DROP TABLE IF EXISTS `{TABLE_PREFIX}pages`;
CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT '0',
  `root_parent` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `link` text{FIELD_COLLATION} NOT NULL,
  `target` varchar(7){FIELD_COLLATION} NOT NULL DEFAULT '',
  `page_title` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `menu_title` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `description` text{FIELD_COLLATION} NOT NULL,
  `keywords` text{FIELD_COLLATION} NOT NULL,
  `page_trail` text{FIELD_COLLATION} NOT NULL,
  `template` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `visibility` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `position` int(11) NOT NULL DEFAULT '0',
  `menu` int(11) NOT NULL DEFAULT '0',
  `language` varchar(5){FIELD_COLLATION} NOT NULL DEFAULT '',
  `searching` int(11) NOT NULL DEFAULT '0',
  `admin_groups` text{FIELD_COLLATION} NOT NULL,
  `admin_users` text{FIELD_COLLATION} NOT NULL,
  `viewing_groups` text{FIELD_COLLATION} NOT NULL,
  `viewing_users` text{FIELD_COLLATION} NOT NULL,
  `modified_when` int(11) NOT NULL DEFAULT '0',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
){TABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}pages` {XTABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `link` `link` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `target` `target` VARCHAR(14) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `page_title` `page_title` VARCHAR(512) {XFIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `menu_title` `menu_title` VARCHAR(512) {XFIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `description` `description` text {XFIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `keywords` `keywords` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `page_trail` `page_trail` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `template` `template` VARCHAR(255) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `visibility` `visibility` VARCHAR(255) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `language` `language` VARCHAR(64) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `admin_groups` `admin_groups` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `admin_users` `admin_users` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `viewing_groups` `viewing_groups` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `viewing_users` `viewing_users` text {FIELD_COLLATION} NOT NULL;

ALTER TABLE `{TABLE_PREFIX}pages` ADD `page_icon` varchar(512){FIELD_COLLATION} NOT NULL DEFAULT '' AFTER `page_title`;
ALTER TABLE `{TABLE_PREFIX}pages` ADD `menu_icon_0` varchar(512){FIELD_COLLATION} NOT NULL DEFAULT '' AFTER `menu_title`;
ALTER TABLE `{TABLE_PREFIX}pages` ADD `menu_icon_1` varchar(512){FIELD_COLLATION} NOT NULL DEFAULT '' AFTER `menu_icon_0`;
ALTER TABLE `{TABLE_PREFIX}pages` ADD `tooltip` varchar(512){FIELD_COLLATION} NOT NULL DEFAULT '' AFTER `menu_icon_1`;
ALTER TABLE `{TABLE_PREFIX}pages` ADD `custom01` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '' AFTER `modified_by`;
ALTER TABLE `{TABLE_PREFIX}pages` ADD `custom02` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '' AFTER `custom01`;
ALTER TABLE `{TABLE_PREFIX}pages` ADD `page_code` int(11) NOT NULL DEFAULT '0' AFTER `custom02`;

ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `page_icon` `page_icon` varchar(512){FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `menu_icon_0` `menu_icon_0` varchar(512){FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `menu_icon_1` `menu_icon_1` varchar(512){FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `tooltip` `tooltip` varchar(512){XFIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `custom01` `custom01` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}pages` CHANGE `custom02` `custom02` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '';

-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `search`
--
DROP TABLE IF EXISTS `{TABLE_PREFIX}search`;
CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}search` (
  `search_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `value` text{FIELD_COLLATION} NOT NULL,
  `extra` text{FIELD_COLLATION} NOT NULL,
  PRIMARY KEY (`search_id`)
){TABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}search` {TABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}search` CHANGE `name` `name` VARCHAR(255) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}search` CHANGE `value` `value` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}search` CHANGE `extra` `extra` text {FIELD_COLLATION} NOT NULL;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `sections`
--
DROP TABLE IF EXISTS `{TABLE_PREFIX}sections`;
CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}sections` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  `module` varchar(200){FIELD_COLLATION} NOT NULL DEFAULT '',
  `block` varchar(200){FIELD_COLLATION} NOT NULL DEFAULT '',
  `publ_start` varchar(200){FIELD_COLLATION} NOT NULL DEFAULT '0',
  `publ_end` varchar(200){FIELD_COLLATION} NOT NULL DEFAULT '0',
  PRIMARY KEY (`section_id`)
){TABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}sections` {XTABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}sections` CHANGE `module` `module` VARCHAR(200) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}sections` CHANGE `block` `block` VARCHAR(200) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}sections` CHANGE `publ_start` `publ_start` int NOT NULL DEFAULT '0';
ALTER TABLE `{TABLE_PREFIX}sections` CHANGE `publ_end` `publ_end` int NOT NULL DEFAULT '2147483647' COMMENT 'max ((2^31)-1)';
ALTER TABLE `{TABLE_PREFIX}sections` ADD `title` VARCHAR(250) {FIELD_COLLATION} NOT NULL DEFAULT '' AFTER `publ_end`;
ALTER TABLE `{TABLE_PREFIX}sections` CHANGE `title` `title` VARCHAR(250) {XFIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}sections` ADD `anchor` int(11) NOT NULL DEFAULT '0' AFTER `title`;
ALTER TABLE `{TABLE_PREFIX}sections` ADD `active` int(11) NOT NULL DEFAULT '1' AFTER `anchor`;
ALTER TABLE `{TABLE_PREFIX}sections` ADD `attribute` TEXT {FIELD_COLLATION} NOT NULL DEFAULT '' AFTER `active`;
ALTER TABLE `{TABLE_PREFIX}sections` CHANGE `attribute` `attribute` TEXT {FIELD_COLLATION} NOT NULL;
--ALTER TABLE `{TABLE_PREFIX}sections` CHANGE `attribute` `attribute` VARCHAR(255) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}sections` CHANGE `active` `active` int(11) NOT NULL DEFAULT '1';
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `settings`
--
DROP TABLE IF EXISTS `{TABLE_PREFIX}settings`;
CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}settings` (
  `name` varchar(160){FIELD_COLLATION} NOT NULL DEFAULT '',
  `value` text{FIELD_COLLATION} NOT NULL,
  PRIMARY KEY (`name`)
){TABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}settings` {XTABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}settings` MODIFY `name` VARCHAR(160) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}settings` MODIFY `value` longtext {XFIELD_COLLATION} NOT NULL;
--
DROP TABLE IF EXISTS `{TABLE_PREFIX}users`;
CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `groups_id` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `password` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `remember_key` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `last_reset` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `email` text{FIELD_COLLATION} NOT NULL,
  `timezone` int(11) NOT NULL DEFAULT '0',
  `date_format` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `time_format` varchar(255){FIELD_COLLATION} NOT NULL DEFAULT '',
  `language` varchar(8){FIELD_COLLATION} NOT NULL DEFAULT 'DE',
  `home_folder` text{FIELD_COLLATION} NOT NULL,
  `login_when` int(11) NOT NULL DEFAULT '0',
  `login_ip` varchar(15){FIELD_COLLATION} NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
){TABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}users` {XTABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `groups_id` `groups_id` VARCHAR(255) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `username` `username` VARCHAR(255) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `password` `password` VARCHAR(255) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `remember_key` `remember_key` VARCHAR(255) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `display_name` `display_name` VARCHAR(512) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `email` `email` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `date_format` `date_format` VARCHAR(255) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `time_format` `time_format` VARCHAR(255) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `language` `language` VARCHAR(64) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `login_ip` `login_ip` VARCHAR(90) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}users` CHANGE `home_folder` `home_folder` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}users` ADD `confirm_code` varchar(64){FIELD_COLLATION} NOT NULL DEFAULT '' AFTER `password`;
ALTER TABLE `{TABLE_PREFIX}users` ADD `confirm_timeout` int(11) NOT NULL DEFAULT '0' AFTER `confirm_code`;
