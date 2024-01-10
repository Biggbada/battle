-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour bugtracker
CREATE DATABASE IF NOT EXISTS `bugtracker` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bugtracker`;

-- Listage de la structure de table bugtracker. mantis_api_token_table
CREATE TABLE IF NOT EXISTS `mantis_api_token_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `hash` varchar(128) NOT NULL,
  `date_created` int unsigned NOT NULL DEFAULT '1',
  `date_used` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_id_name` (`user_id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_bugnote_table
CREATE TABLE IF NOT EXISTS `mantis_bugnote_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `bug_id` int unsigned NOT NULL DEFAULT '0',
  `reporter_id` int unsigned NOT NULL DEFAULT '0',
  `bugnote_text_id` int unsigned NOT NULL DEFAULT '0',
  `view_state` smallint NOT NULL DEFAULT '10',
  `note_type` int DEFAULT '0',
  `note_attr` varchar(250) DEFAULT '',
  `time_tracking` int unsigned NOT NULL DEFAULT '0',
  `last_modified` int unsigned NOT NULL DEFAULT '1',
  `date_submitted` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_bug` (`bug_id`),
  KEY `idx_last_mod` (`last_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_bugnote_text_table
CREATE TABLE IF NOT EXISTS `mantis_bugnote_text_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `note` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_bug_file_table
CREATE TABLE IF NOT EXISTS `mantis_bug_file_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `bug_id` int unsigned NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `diskfile` varchar(250) NOT NULL DEFAULT '',
  `filename` varchar(250) NOT NULL DEFAULT '',
  `folder` varchar(250) NOT NULL DEFAULT '',
  `filesize` int NOT NULL DEFAULT '0',
  `file_type` varchar(250) NOT NULL DEFAULT '',
  `content` longblob,
  `date_added` int unsigned NOT NULL DEFAULT '1',
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `bugnote_id` int unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_bug_file_bug_id` (`bug_id`),
  KEY `idx_diskfile` (`diskfile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_bug_history_table
CREATE TABLE IF NOT EXISTS `mantis_bug_history_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `bug_id` int unsigned NOT NULL DEFAULT '0',
  `field_name` varchar(64) NOT NULL,
  `old_value` varchar(255) NOT NULL,
  `new_value` varchar(255) NOT NULL,
  `type` smallint NOT NULL DEFAULT '0',
  `date_modified` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_bug_history_bug_id` (`bug_id`),
  KEY `idx_history_user_id` (`user_id`),
  KEY `idx_bug_history_date_modified` (`date_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_bug_monitor_table
CREATE TABLE IF NOT EXISTS `mantis_bug_monitor_table` (
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `bug_id` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`bug_id`),
  KEY `idx_bug_id` (`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_bug_relationship_table
CREATE TABLE IF NOT EXISTS `mantis_bug_relationship_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `source_bug_id` int unsigned NOT NULL DEFAULT '0',
  `destination_bug_id` int unsigned NOT NULL DEFAULT '0',
  `relationship_type` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_relationship_source` (`source_bug_id`),
  KEY `idx_relationship_destination` (`destination_bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_bug_revision_table
CREATE TABLE IF NOT EXISTS `mantis_bug_revision_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `bug_id` int unsigned NOT NULL,
  `bugnote_id` int unsigned NOT NULL DEFAULT '0',
  `user_id` int unsigned NOT NULL,
  `type` int unsigned NOT NULL,
  `value` longtext NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_bug_rev_type` (`type`),
  KEY `idx_bug_rev_id_time` (`bug_id`,`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_bug_table
CREATE TABLE IF NOT EXISTS `mantis_bug_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int unsigned NOT NULL DEFAULT '0',
  `reporter_id` int unsigned NOT NULL DEFAULT '0',
  `handler_id` int unsigned NOT NULL DEFAULT '0',
  `duplicate_id` int unsigned NOT NULL DEFAULT '0',
  `priority` smallint NOT NULL DEFAULT '30',
  `severity` smallint NOT NULL DEFAULT '50',
  `reproducibility` smallint NOT NULL DEFAULT '10',
  `status` smallint NOT NULL DEFAULT '10',
  `resolution` smallint NOT NULL DEFAULT '10',
  `projection` smallint NOT NULL DEFAULT '10',
  `eta` smallint NOT NULL DEFAULT '10',
  `bug_text_id` int unsigned NOT NULL DEFAULT '0',
  `os` varchar(32) NOT NULL DEFAULT '',
  `os_build` varchar(32) NOT NULL DEFAULT '',
  `platform` varchar(32) NOT NULL DEFAULT '',
  `version` varchar(64) NOT NULL DEFAULT '',
  `fixed_in_version` varchar(64) NOT NULL DEFAULT '',
  `build` varchar(32) NOT NULL DEFAULT '',
  `profile_id` int unsigned NOT NULL DEFAULT '0',
  `view_state` smallint NOT NULL DEFAULT '10',
  `summary` varchar(128) NOT NULL DEFAULT '',
  `sponsorship_total` int NOT NULL DEFAULT '0',
  `sticky` tinyint NOT NULL DEFAULT '0',
  `target_version` varchar(64) NOT NULL DEFAULT '',
  `category_id` int unsigned NOT NULL DEFAULT '1',
  `date_submitted` int unsigned NOT NULL DEFAULT '1',
  `due_date` int unsigned NOT NULL DEFAULT '1',
  `last_updated` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_bug_sponsorship_total` (`sponsorship_total`),
  KEY `idx_bug_fixed_in_version` (`fixed_in_version`),
  KEY `idx_bug_status` (`status`),
  KEY `idx_project` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_bug_tag_table
CREATE TABLE IF NOT EXISTS `mantis_bug_tag_table` (
  `bug_id` int unsigned NOT NULL DEFAULT '0',
  `tag_id` int unsigned NOT NULL DEFAULT '0',
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `date_attached` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`bug_id`,`tag_id`),
  KEY `idx_bug_tag_tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_bug_text_table
CREATE TABLE IF NOT EXISTS `mantis_bug_text_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `description` longtext NOT NULL,
  `steps_to_reproduce` longtext NOT NULL,
  `additional_information` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_category_table
CREATE TABLE IF NOT EXISTS `mantis_category_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int unsigned NOT NULL DEFAULT '0',
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL DEFAULT '',
  `status` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_category_project_name` (`project_id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_config_table
CREATE TABLE IF NOT EXISTS `mantis_config_table` (
  `config_id` varchar(64) NOT NULL,
  `project_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  `access_reqd` int DEFAULT '0',
  `type` int DEFAULT '90',
  `value` longtext NOT NULL,
  PRIMARY KEY (`config_id`,`project_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_custom_field_project_table
CREATE TABLE IF NOT EXISTS `mantis_custom_field_project_table` (
  `field_id` int NOT NULL DEFAULT '0',
  `project_id` int unsigned NOT NULL DEFAULT '0',
  `sequence` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`field_id`,`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_custom_field_string_table
CREATE TABLE IF NOT EXISTS `mantis_custom_field_string_table` (
  `field_id` int NOT NULL DEFAULT '0',
  `bug_id` int NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL DEFAULT '',
  `text` longtext,
  PRIMARY KEY (`field_id`,`bug_id`),
  KEY `idx_custom_field_bug` (`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_custom_field_table
CREATE TABLE IF NOT EXISTS `mantis_custom_field_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `type` smallint NOT NULL DEFAULT '0',
  `possible_values` text,
  `default_value` varchar(255) NOT NULL DEFAULT '',
  `valid_regexp` varchar(255) NOT NULL DEFAULT '',
  `access_level_r` smallint NOT NULL DEFAULT '0',
  `access_level_rw` smallint NOT NULL DEFAULT '0',
  `length_min` int NOT NULL DEFAULT '0',
  `length_max` int NOT NULL DEFAULT '0',
  `require_report` tinyint NOT NULL DEFAULT '0',
  `require_update` tinyint NOT NULL DEFAULT '0',
  `display_report` tinyint NOT NULL DEFAULT '0',
  `display_update` tinyint NOT NULL DEFAULT '1',
  `require_resolved` tinyint NOT NULL DEFAULT '0',
  `display_resolved` tinyint NOT NULL DEFAULT '0',
  `display_closed` tinyint NOT NULL DEFAULT '0',
  `require_closed` tinyint NOT NULL DEFAULT '0',
  `filter_by` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_custom_field_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_email_table
CREATE TABLE IF NOT EXISTS `mantis_email_table` (
  `email_id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL DEFAULT '',
  `subject` varchar(250) NOT NULL DEFAULT '',
  `metadata` longtext NOT NULL,
  `body` longtext NOT NULL,
  `submitted` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_filters_table
CREATE TABLE IF NOT EXISTS `mantis_filters_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `project_id` int NOT NULL DEFAULT '0',
  `is_public` tinyint DEFAULT NULL,
  `name` varchar(64) NOT NULL DEFAULT '',
  `filter_string` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_news_table
CREATE TABLE IF NOT EXISTS `mantis_news_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int unsigned NOT NULL DEFAULT '0',
  `poster_id` int unsigned NOT NULL DEFAULT '0',
  `view_state` smallint NOT NULL DEFAULT '10',
  `announcement` tinyint NOT NULL DEFAULT '0',
  `headline` varchar(64) NOT NULL DEFAULT '',
  `body` longtext NOT NULL,
  `last_modified` int unsigned NOT NULL DEFAULT '1',
  `date_posted` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_plugin_table
CREATE TABLE IF NOT EXISTS `mantis_plugin_table` (
  `basename` varchar(40) NOT NULL,
  `enabled` tinyint NOT NULL DEFAULT '0',
  `protected` tinyint NOT NULL DEFAULT '0',
  `priority` int unsigned NOT NULL DEFAULT '3',
  PRIMARY KEY (`basename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_project_file_table
CREATE TABLE IF NOT EXISTS `mantis_project_file_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int unsigned NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `diskfile` varchar(250) NOT NULL DEFAULT '',
  `filename` varchar(250) NOT NULL DEFAULT '',
  `folder` varchar(250) NOT NULL DEFAULT '',
  `filesize` int NOT NULL DEFAULT '0',
  `file_type` varchar(250) NOT NULL DEFAULT '',
  `content` longblob,
  `date_added` int unsigned NOT NULL DEFAULT '1',
  `user_id` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_project_hierarchy_table
CREATE TABLE IF NOT EXISTS `mantis_project_hierarchy_table` (
  `child_id` int unsigned NOT NULL,
  `parent_id` int unsigned NOT NULL,
  `inherit_parent` tinyint NOT NULL DEFAULT '0',
  UNIQUE KEY `idx_project_hierarchy` (`child_id`,`parent_id`),
  KEY `idx_project_hierarchy_child_id` (`child_id`),
  KEY `idx_project_hierarchy_parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_project_table
CREATE TABLE IF NOT EXISTS `mantis_project_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `status` smallint NOT NULL DEFAULT '10',
  `enabled` tinyint NOT NULL DEFAULT '1',
  `view_state` smallint NOT NULL DEFAULT '10',
  `access_min` smallint NOT NULL DEFAULT '10',
  `file_path` varchar(250) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `category_id` int unsigned NOT NULL DEFAULT '1',
  `inherit_global` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_project_name` (`name`),
  KEY `idx_project_view` (`view_state`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_project_user_list_table
CREATE TABLE IF NOT EXISTS `mantis_project_user_list_table` (
  `project_id` int unsigned NOT NULL DEFAULT '0',
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `access_level` smallint NOT NULL DEFAULT '10',
  PRIMARY KEY (`project_id`,`user_id`),
  KEY `idx_project_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_project_version_table
CREATE TABLE IF NOT EXISTS `mantis_project_version_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int unsigned NOT NULL DEFAULT '0',
  `version` varchar(64) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `released` tinyint NOT NULL DEFAULT '1',
  `obsolete` tinyint NOT NULL DEFAULT '0',
  `date_order` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_project_version` (`project_id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_sponsorship_table
CREATE TABLE IF NOT EXISTS `mantis_sponsorship_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bug_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  `amount` int NOT NULL DEFAULT '0',
  `logo` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(128) NOT NULL DEFAULT '',
  `paid` tinyint NOT NULL DEFAULT '0',
  `date_submitted` int unsigned NOT NULL DEFAULT '1',
  `last_updated` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_sponsorship_bug_id` (`bug_id`),
  KEY `idx_sponsorship_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_tag_table
CREATE TABLE IF NOT EXISTS `mantis_tag_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `date_created` int unsigned NOT NULL DEFAULT '1',
  `date_updated` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`name`),
  KEY `idx_tag_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_tokens_table
CREATE TABLE IF NOT EXISTS `mantis_tokens_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `owner` int NOT NULL,
  `type` int NOT NULL,
  `value` longtext NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '1',
  `expiry` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_typeowner` (`type`,`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_user_pref_table
CREATE TABLE IF NOT EXISTS `mantis_user_pref_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `project_id` int unsigned NOT NULL DEFAULT '0',
  `default_profile` int unsigned NOT NULL DEFAULT '0',
  `default_project` int unsigned NOT NULL DEFAULT '0',
  `refresh_delay` int NOT NULL DEFAULT '0',
  `redirect_delay` int NOT NULL DEFAULT '0',
  `bugnote_order` varchar(4) NOT NULL DEFAULT 'ASC',
  `email_on_new` tinyint NOT NULL DEFAULT '0',
  `email_on_assigned` tinyint NOT NULL DEFAULT '0',
  `email_on_feedback` tinyint NOT NULL DEFAULT '0',
  `email_on_resolved` tinyint NOT NULL DEFAULT '0',
  `email_on_closed` tinyint NOT NULL DEFAULT '0',
  `email_on_reopened` tinyint NOT NULL DEFAULT '0',
  `email_on_bugnote` tinyint NOT NULL DEFAULT '0',
  `email_on_status` tinyint NOT NULL DEFAULT '0',
  `email_on_priority` tinyint NOT NULL DEFAULT '0',
  `email_on_priority_min_severity` smallint NOT NULL DEFAULT '10',
  `email_on_status_min_severity` smallint NOT NULL DEFAULT '10',
  `email_on_bugnote_min_severity` smallint NOT NULL DEFAULT '10',
  `email_on_reopened_min_severity` smallint NOT NULL DEFAULT '10',
  `email_on_closed_min_severity` smallint NOT NULL DEFAULT '10',
  `email_on_resolved_min_severity` smallint NOT NULL DEFAULT '10',
  `email_on_feedback_min_severity` smallint NOT NULL DEFAULT '10',
  `email_on_assigned_min_severity` smallint NOT NULL DEFAULT '10',
  `email_on_new_min_severity` smallint NOT NULL DEFAULT '10',
  `email_bugnote_limit` smallint NOT NULL DEFAULT '0',
  `language` varchar(32) NOT NULL DEFAULT 'english',
  `timezone` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_user_print_pref_table
CREATE TABLE IF NOT EXISTS `mantis_user_print_pref_table` (
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `print_pref` varchar(64) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_user_profile_table
CREATE TABLE IF NOT EXISTS `mantis_user_profile_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `platform` varchar(32) NOT NULL DEFAULT '',
  `os` varchar(32) NOT NULL DEFAULT '',
  `os_build` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table bugtracker. mantis_user_table
CREATE TABLE IF NOT EXISTS `mantis_user_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) NOT NULL DEFAULT '',
  `realname` varchar(191) NOT NULL DEFAULT '',
  `email` varchar(191) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `enabled` tinyint NOT NULL DEFAULT '1',
  `protected` tinyint NOT NULL DEFAULT '0',
  `access_level` smallint NOT NULL DEFAULT '10',
  `login_count` int NOT NULL DEFAULT '0',
  `lost_password_request_count` smallint NOT NULL DEFAULT '0',
  `failed_login_count` smallint NOT NULL DEFAULT '0',
  `cookie_string` varchar(64) NOT NULL DEFAULT '',
  `last_visit` int unsigned NOT NULL DEFAULT '1',
  `date_created` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_cookie_string` (`cookie_string`),
  UNIQUE KEY `idx_user_username` (`username`),
  KEY `idx_enable` (`enabled`),
  KEY `idx_access` (`access_level`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Les données exportées n'étaient pas sélectionnées.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
