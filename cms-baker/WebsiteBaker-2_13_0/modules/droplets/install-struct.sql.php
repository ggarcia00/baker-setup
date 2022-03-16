-- <?php header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; flush(); exit;?>
-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 01. Feb 2016 um 19:54
-- Server-Version: 5.6.24
-- PHP-Version: 7.0.1
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `mod_droplets`
-- Replacements: {TABLE_PREFIX}, {TABLE_ENGINE}, {FIELD_COLLATION}
--
DROP TABLE IF EXISTS `{TABLE_PREFIX}mod_droplets`;
CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}mod_droplets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) {FIELD_COLLATION} NOT NULL DEFAULT '',
  `code` longtext {FIELD_COLLATION} NOT NULL,
  `description` text {FIELD_COLLATION} NOT NULL,
  `modified_when` int(11) NOT NULL DEFAULT '0',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  `comments` text {FIELD_COLLATION} NOT NULL,
  PRIMARY KEY (`id`)
){TABLE_ENGINE};

ALTER TABLE `{TABLE_PREFIX}mod_droplets` DROP INDEX `droplet_name`;
ALTER TABLE `{TABLE_PREFIX}mod_droplets` {TABLE_ENGINE};
ALTER TABLE `{TABLE_PREFIX}mod_droplets` ADD `admin_edit` INT(11) NOT NULL DEFAULT '0' AFTER `active`;
ALTER TABLE `{TABLE_PREFIX}mod_droplets` ADD `admin_view` INT(11) NOT NULL DEFAULT '0' AFTER `admin_edit`;
ALTER TABLE `{TABLE_PREFIX}mod_droplets` ADD `show_wysiwyg` INT(11) NOT NULL DEFAULT '0' AFTER `admin_view`;
ALTER TABLE `{TABLE_PREFIX}mod_droplets` CHANGE `name` `name` VARCHAR(32) {FIELD_COLLATION} NOT NULL DEFAULT '';
ALTER TABLE `{TABLE_PREFIX}mod_droplets` CHANGE `code` `code` longtext {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}mod_droplets` CHANGE `description` `description` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}mod_droplets` CHANGE `comments` `comments` text {FIELD_COLLATION} NOT NULL;
ALTER TABLE `{TABLE_PREFIX}mod_droplets` ADD UNIQUE `droplet_name` ( `name` ) USING BTREE;
