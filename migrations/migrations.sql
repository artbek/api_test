
CREATE TABLE `sources` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(16) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8
;

INSERT INTO `sources` (`id`, `name`) VALUES
	(1, 'api'),
	(2, 'admin')
;


CREATE TABLE `countries` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(128) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;

CREATE TABLE `business_types` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(32) CHARACTER SET utf8 NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;


CREATE TABLE `property_types` (
 `id` int(11) NOT NULL,
 `title` varchar(64) NOT NULL,
 `description` text,
 `created_at` datetime DEFAULT NULL,
 `updated_at` datetime DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;


CREATE TABLE `images` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `thumb` tinyint(1) NOT NULL DEFAULT '0',
 `path` varchar(256) NOT NULL,
 `display_order` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;
	

CREATE TABLE `properties` (
 `uuid` char(36) CHARACTER SET ascii NOT NULL,
 `source_id` int(11) NOT NULL,
 `town` varchar(64) NOT NULL,
 `description` text,
 `address` text NOT NULL,
 `county` varchar(64) DEFAULT NULL,
 `country_id` int(11) DEFAULT NULL,
 `latitude` decimal(10,8) DEFAULT NULL,
 `longitude` decimal(11,8) DEFAULT NULL,
 `num_bedrooms` int(11) DEFAULT NULL,
 `num_bathrooms` int(11) DEFAULT NULL,
 `property_type_id` int(11) DEFAULT NULL,
 `business_type_id` int(11) DEFAULT NULL,
 `price` decimal(10,2) DEFAULT NULL,
 UNIQUE KEY `uuid` (`uuid`),
 KEY `country_id` (`country_id`),
 KEY `property_type_id` (`property_type_id`),
 KEY `business_type_id` (`business_type_id`),
 KEY `source_id` (`source_id`),
 CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
 CONSTRAINT `properties_ibfk_2` FOREIGN KEY (`property_type_id`) REFERENCES `property_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
 CONSTRAINT `properties_ibfk_3` FOREIGN KEY (`business_type_id`) REFERENCES `business_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;


CREATE TABLE `properties_images` (
 `property_id` char(36) CHARACTER SET ascii NOT NULL,
 `image_id` int(11) NOT NULL,
 KEY `property_id` (`property_id`,`image_id`),
 KEY `image_id` (`image_id`),
 CONSTRAINT `properties_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `properties_images_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;

