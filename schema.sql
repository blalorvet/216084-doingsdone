CREATE DATABASE doingsdone
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE doingsdone;
/* Создаем таблицу пользователей */
CREATE TABLE `users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(255) NOT NULL UNIQUE,
	`password` VARCHAR(255) NOT NULL,
	`first_name` VARCHAR(255) NOT NULL,
	`date_reg` DATETIME NOT NULL,
	`contacts` VARCHAR(255),
	PRIMARY KEY (`id`)
);
/* Создаем таблицу с категориями */
CREATE TABLE `categories` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`user_id` INT NOT NULL,
	PRIMARY KEY (`id`)
);
/* Создаем таблицу с задачами пользователей */
CREATE TABLE `tasks` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`date_add` DATETIME NOT NULL,
	`user_id` INT NOT NULL,
	`files_path` VARCHAR(255),
	`category_id` INT NOT NULL,
	`date_end` DATETIME,
	`deadline` DATETIME,
	PRIMARY KEY (`id`)
);

ALTER TABLE `categories` ADD CONSTRAINT `categories_fk0` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `tasks` ADD CONSTRAINT `tasks_fk0` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `tasks` ADD CONSTRAINT `tasks_fk1` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`);
/* Создаем индексы  */
CREATE INDEX user_id_index  ON categories (user_id);

CREATE INDEX name_index  ON tasks (name);
CREATE INDEX user_id_index  ON tasks (user_id);
CREATE INDEX date_end_index  ON tasks (date_end);
CREATE INDEX deadline_index  ON tasks (deadline);
CREATE INDEX category_id_index  ON tasks (category_id);







