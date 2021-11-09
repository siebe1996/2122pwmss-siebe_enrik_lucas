DROP DATABASE IF EXISTS `tasklist`;
CREATE DATABASE `tasklist` DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;
USE `tasklist`;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `priority` enum('high','normal','low') NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci AUTO_INCREMENT = 4;


INSERT INTO `tasks` VALUES (1, 'Een dringende taak', 'high', now());
INSERT INTO `tasks` VALUES (2, 'Een normale taak', 'normal', now());
INSERT INTO `tasks` VALUES (3, 'Een niet zo belangrijke taak', 'low', now());
INSERT INTO `tasks` VALUES (7, '🍰 Taart eten', 'normal', now());