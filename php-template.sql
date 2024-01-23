CREATE TABLE IF NOT EXISTS `users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`username` varchar(50) NOT NULL,
	`password` text NOT NULL,
	PRIMARY KEY (`id`)
);