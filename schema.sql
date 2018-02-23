CREATE DATABASE doingsdone
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE `users` (
	`id` INT NOT NULL,
	`email` VARCHAR(255) NOT NULL UNIQUE,
	`password` VARCHAR(255) NOT NULL UNIQUE,
	`first_name` VARCHAR(255) NOT NULL,
	`date_reg` DATETIME NOT NULL,
	`contacts` TEXT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `categories` (
	`id` INT NOT NULL,
	`name` VARCHAR(255) NOT NULL UNIQUE,
	`user_id` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `tasks` (
	`id` INT NOT NULL,
	`name` VARCHAR(255) NOT NULL UNIQUE,
	`date_add` DATETIME NOT NULL,
	`user_id` INT NOT NULL,
	`files_path` VARCHAR(255) NOT NULL,
	`category_id` INT NOT NULL UNIQUE,
	`date_end` DATETIME NOT NULL,
	`deadline` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `categories` ADD CONSTRAINT `categories_fk0` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `tasks` ADD CONSTRAINT `tasks_fk0` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `tasks` ADD CONSTRAINT `tasks_fk1` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`);

