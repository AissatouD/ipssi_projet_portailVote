-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

CREATE DATABASE `portail_vote` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `portail_vote`;

DROP TABLE IF EXISTS `meeting`;
CREATE TABLE `meeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `note_m` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `statut` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `vote`;
CREATE TABLE `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_meeting` int(11) DEFAULT NULL,
  `note` int(11) DEFAULT NULL,
  `id_user_vote` int(11) DEFAULT NULL,
  `id_meeting_vote` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id_user`,`id_meeting`),
  KEY `vote_user_FK` (`id_user_vote`),
  KEY `vote_meeting0_FK` (`id_meeting_vote`),
  CONSTRAINT `vote_meeting0_FK` FOREIGN KEY (`id_meeting_vote`) REFERENCES `meeting` (`id`),
  CONSTRAINT `vote_user_FK` FOREIGN KEY (`id_user_vote`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DELIMITER ;;

CREATE TRIGGER `noteAvg` AFTER INSERT ON `vote` FOR EACH ROW
UPDATE meeting 
    SET note_m = (SELECT ROUND(AVG(note), 1) FROM vote
                  WHERE id_meeting = (SELECT id_meeting FROM vote WHERE id =(SELECT MAX(id) FROM vote)))
                         
    WHERE meeting.id = (SELECT id_meeting FROM vote WHERE id =(SELECT MAX(id) FROM vote));;

DELIMITER ;