CREATE TABLE `SITE_DB`.`item_starttopic` (
  `id` int(11) NOT NULL auto_increment,
  `item_id` int(11) NOT NULL,

  `name` varchar(100) NOT NULL,
  `description` text NOT NULL DEFAULT '',

  `html` text NOT NULL DEFAULT '',

  `fixed_url_identifier` varchar(100) DEFAULT NULL,
  `position` int(11) DEFAULT '0',

  PRIMARY KEY  (`id`),
  UNIQUE KEY `fixed_url_identifier` (`fixed_url_identifier`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `item_starttopic_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `SITE_DB`.`items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
