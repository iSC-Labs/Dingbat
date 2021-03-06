CREATE TABLE `cards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `cards` (`id`, `name`, `slug`)
  VALUES
  (1, 'first list', 'first-list'),
  (2, 'second list', 'second-list');


CREATE TABLE `tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `marked` tinyint(1) NOT NULL DEFAULT '0',
  `priority` varchar(6) NOT NULL DEFAULT 'normal',
  `cardId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `tasks` (`id`, `name`, `marked`, `priority`, `cardId`)
  VALUES
  (1, 'save a whale', 0, 'normal', 1),
  (2, 'kiss a chicken', 0, 'high', 1),
  (3, 'hug yourself', 0, 'low', 1);