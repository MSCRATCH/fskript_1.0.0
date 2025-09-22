CREATE TABLE `activity_log` (
`activity_log_id` int(10) NOT NULL AUTO_INCREMENT,
`topic_id` int(10) NOT NULL,
`user_id` int(10) NOT NULL,
`activity_log_act` varchar(45) NOT NULL,
`activity_log_timestamp` datetime NOT NULL,
`activity_log_ip_address` varchar(45) NOT NULL,
PRIMARY KEY (`activity_log_id`),
KEY `topic_id` (`topic_id`),
KEY `user_id` (`user_id`),
CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `activity_log_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci

CREATE TABLE `categories` (
`category_id` int(10) NOT NULL AUTO_INCREMENT,
`category_name` varchar(150) NOT NULL,
PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci

CREATE TABLE `forums` (
`forum_id` int(10) NOT NULL AUTO_INCREMENT,
`forum_name` varchar(150) NOT NULL,
`forum_description` varchar(250) NOT NULL,
`category_id` int(10) NOT NULL,
PRIMARY KEY (`forum_id`),
KEY `category_id` (`category_id`),
CONSTRAINT `forums_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci

CREATE TABLE `login_protocol` (
`login_protocol_id` int(10) NOT NULL AUTO_INCREMENT,
`login_protocol_user_id` int(10) NOT NULL,
`login_protocol_ip_address` varchar(45) NOT NULL,
`login_protocol_timestamp` datetime NOT NULL,
`login_protocol_successful` tinyint(1) NOT NULL DEFAULT 0,
PRIMARY KEY (`login_protocol_id`),
KEY `login_protocol_user_id` (`login_protocol_user_id`),
CONSTRAINT `login_protocol_ibfk_1` FOREIGN KEY (`login_protocol_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci

CREATE TABLE `posts` (
`post_id` int(10) NOT NULL AUTO_INCREMENT,
`post_content` text NOT NULL,
`post_created` datetime NOT NULL,
`topic_id` int(10) NOT NULL,
`user_id` int(10) NOT NULL,
`is_removed` tinyint(1) NOT NULL DEFAULT 0,
PRIMARY KEY (`post_id`),
KEY `topic_id` (`topic_id`),
KEY `user_id` (`user_id`),
CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci

CREATE TABLE `settings` (
`setting_id` int(10) NOT NULL AUTO_INCREMENT,
`setting_key` varchar(255) NOT NULL,
`setting_value` varchar(255) NOT NULL,
PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('site_title', 'FSkript'),
('deactivate_registration', 'activated'),
('theme', 'default_template');

CREATE TABLE `topics` (
`topic_id` int(10) NOT NULL AUTO_INCREMENT,
`topic_title` varchar(150) NOT NULL,
`topic_created` datetime NOT NULL,
`topic_updated` datetime NOT NULL,
`forum_id` int(10) NOT NULL,
`user_id` int(10) NOT NULL,
`is_removed` tinyint(1) NOT NULL DEFAULT 0,
`is_locked` tinyint(1) NOT NULL DEFAULT 0,
PRIMARY KEY (`topic_id`),
KEY `user_id` (`user_id`),
KEY `topics_ibfk_1` (`forum_id`),
CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci

CREATE TABLE `users` (
`user_id` int(10) NOT NULL AUTO_INCREMENT,
`username` varchar(30) NOT NULL,
`user_password` char(255) NOT NULL,
`user_email` varchar(50) NOT NULL,
`user_level` varchar(50) NOT NULL DEFAULT 'not_activated',
`user_date` datetime NOT NULL,
`last_activity` datetime NOT NULL,
PRIMARY KEY (`user_id`),
UNIQUE KEY `username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci

CREATE TABLE `user_profiles` (
`user_profile_id` int(10) NOT NULL AUTO_INCREMENT,
`user_profile_picture` varchar(250) NOT NULL,
`user_profile_description` varchar(500) NOT NULL,
`user_id` int(10) NOT NULL,
PRIMARY KEY (`user_profile_id`),
KEY `user_id` (`user_id`),
CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci
