CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(32) NOT NULL,
  `roles` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `counter`;
CREATE TABLE `counter` (
  `userId` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `type` enum('pushups','squats','situps','jumpingjacks') NOT NULL,
  `nb` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`,`date`,`type`),
  CONSTRAINT `counter_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;