-- phpMyAdmin SQL Dump
-- version 5.0.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Nov 2020 um 15:41
-- Server-Version: 10.4.11-MariaDB
-- PHP-Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `wb_patch_db1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `wb_mod_captcha_control`
--

DROP TABLE IF EXISTS `wb_mod_captcha_control`;
CREATE TABLE IF NOT EXISTS `wb_mod_captcha_control` (
  `captcha_type` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'calc_text',
  `enabled_captcha` int(11) NOT NULL DEFAULT 0,
  `enabled_asp` int(11) NOT NULL DEFAULT 1,
  `asp_session_min_age` int(11) NOT NULL DEFAULT 20,
  `asp_view_min_age` int(11) NOT NULL DEFAULT 10,
  `asp_input_min_age` int(11) NOT NULL DEFAULT 5,
  `ct_text` text COLLATE utf8_unicode_ci NOT NULL,
  `ct_color` int(11) NOT NULL DEFAULT 1,
  `use_sec_type` int(11) NOT NULL DEFAULT -1,
  `code_length` int(11) NOT NULL DEFAULT 5,
  `image_width` int(11) NOT NULL DEFAULT 225,
  `image_height` int(11) NOT NULL DEFAULT 85,
  `num_lines` int(11) NOT NULL DEFAULT 3,
  `noise_level` int(11) NOT NULL DEFAULT 5,
  `captcha_expiration` int(11) NOT NULL DEFAULT 900,
  `image_bg_dir` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backgrounds/',
  `image_bg_color` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'F2F2F2',
  `ttf_file` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fonts/AHGBold.ttf',
  `text_color` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '7D7D7D',
  `line_color` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '7D7D7D',
  `noise_color` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '7D7D7D',
  `signature_color` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT '777777',
  `image_signature` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `wb_mod_captcha_control`
--

INSERT INTO `wb_mod_captcha_control` (`captcha_type`, `enabled_captcha`, `enabled_asp`, `asp_session_min_age`, `asp_view_min_age`, `asp_input_min_age`, `ct_text`, `ct_color`, `use_sec_type`, `code_length`, `image_width`, `image_height`, `num_lines`, `noise_level`, `captcha_expiration`, `image_bg_dir`, `image_bg_color`, `ttf_file`, `text_color`, `line_color`, `noise_color`, `signature_color`, `image_signature`) VALUES('Securimage', 0, 1, 20, 10, 5, '', 1, 1, 5, 180, 0, 3, 5, 900, 'backgrounds/bg3.jpg', 'F2F2F2', 'fonts/FreeSerifItalicWBCaptchaCond.ttf', '072FFF', 'FFAEAE', '2F7D2D', '777777', '');
INSERT INTO `wb_mod_captcha_control` (`captcha_type`, `enabled_captcha`, `enabled_asp`, `asp_session_min_age`, `asp_view_min_age`, `asp_input_min_age`, `ct_text`, `ct_color`, `use_sec_type`, `code_length`, `image_width`, `image_height`, `num_lines`, `noise_level`, `captcha_expiration`, `image_bg_dir`, `image_bg_color`, `ttf_file`, `text_color`, `line_color`, `noise_color`, `signature_color`, `image_signature`) VALUES('Securimage', 0, 1, 20, 10, 5, '', 1, 1, 5, 180, 0, 3, 5, 900, 'backgrounds/bg3.jpg', 'F2F2F2', 'fonts/FreeSerifItalicWBCaptchaCond.ttf', '072FFF', 'FFAEAE', '2F7D2D', '777777', '');
INSERT INTO `wb_mod_captcha_control` (`captcha_type`, `enabled_captcha`, `enabled_asp`, `asp_session_min_age`, `asp_view_min_age`, `asp_input_min_age`, `ct_text`, `ct_color`, `use_sec_type`, `code_length`, `image_width`, `image_height`, `num_lines`, `noise_level`, `captcha_expiration`, `image_bg_dir`, `image_bg_color`, `ttf_file`, `text_color`, `line_color`, `noise_color`, `signature_color`, `image_signature`) VALUES('Securimage', 0, 1, 20, 10, 5, '', 1, 1, 5, 180, 0, 3, 5, 900, 'backgrounds/bg3.jpg', 'F2F2F2', 'fonts/FreeSerifItalicWBCaptchaCond.ttf', '072FFF', 'FFAEAE', '2F7D2D', '777777', '');
INSERT INTO `wb_mod_captcha_control` (`captcha_type`, `enabled_captcha`, `enabled_asp`, `asp_session_min_age`, `asp_view_min_age`, `asp_input_min_age`, `ct_text`, `ct_color`, `use_sec_type`, `code_length`, `image_width`, `image_height`, `num_lines`, `noise_level`, `captcha_expiration`, `image_bg_dir`, `image_bg_color`, `ttf_file`, `text_color`, `line_color`, `noise_color`, `signature_color`, `image_signature`) VALUES('Securimage', 0, 1, 20, 10, 5, '', 1, 1, 5, 180, 0, 3, 5, 900, 'backgrounds/bg3.jpg', 'F2F2F2', 'fonts/FreeSerifItalicWBCaptchaCond.ttf', '072FFF', 'FFAEAE', '2F7D2D', '777777', '');
INSERT INTO `wb_mod_captcha_control` (`captcha_type`, `enabled_captcha`, `enabled_asp`, `asp_session_min_age`, `asp_view_min_age`, `asp_input_min_age`, `ct_text`, `ct_color`, `use_sec_type`, `code_length`, `image_width`, `image_height`, `num_lines`, `noise_level`, `captcha_expiration`, `image_bg_dir`, `image_bg_color`, `ttf_file`, `text_color`, `line_color`, `noise_color`, `signature_color`, `image_signature`) VALUES('Securimage', 0, 1, 20, 10, 5, '', 1, 1, 5, 180, 0, 3, 5, 900, 'backgrounds/bg3.jpg', 'F2F2F2', 'fonts/FreeSerifItalicWBCaptchaCond.ttf', '072FFF', 'FFAEAE', '2F7D2D', '777777', '');
INSERT INTO `wb_mod_captcha_control` (`captcha_type`, `enabled_captcha`, `enabled_asp`, `asp_session_min_age`, `asp_view_min_age`, `asp_input_min_age`, `ct_text`, `ct_color`, `use_sec_type`, `code_length`, `image_width`, `image_height`, `num_lines`, `noise_level`, `captcha_expiration`, `image_bg_dir`, `image_bg_color`, `ttf_file`, `text_color`, `line_color`, `noise_color`, `signature_color`, `image_signature`) VALUES('Securimage', 0, 1, 20, 10, 5, '', 1, 1, 5, 180, 0, 3, 5, 900, 'backgrounds/bg3.jpg', 'F2F2F2', 'fonts/FreeSerifItalicWBCaptchaCond.ttf', '072FFF', 'FFAEAE', '2F7D2D', '777777', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

