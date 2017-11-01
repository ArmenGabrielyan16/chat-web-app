CREATE TABLE `users` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `username` varchar(64) NOT NULL,
 `password` varchar(128) NOT NULL,
 `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8

CREATE TABLE `chat_rooms` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(64) NOT NULL,
 `image` varchar(128) DEFAULT NULL,
 `visibility` int(11) NOT NULL,
 `access_level` int(11) NOT NULL,
 `private_link` varchar(64) DEFAULT NULL,
 `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8

CREATE TABLE `messages` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `chat_room_id` int(11) NOT NULL,
 `content` text NOT NULL,
 `username` varchar(64) NOT NULL,
 `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'smith', '$2y$10$fb5eVaBAEK7gkE7nTAI37e.GGDxf3xdlr3BTh02yKHGfwdcq50B8i',
'2017-10-29 21:44:07', '2017-10-29 21:44:07'), --password = 123456 --
(2, 'bob', '$2y$10$NDtgQSS0FhpbtU9aIGExbO8KpW6oW4RwsR3dXJJ2RE8wsaiLrJam.',
'2017-10-30 19:11:17', '2017-10-30 19:11:17');   --password = qwerty --