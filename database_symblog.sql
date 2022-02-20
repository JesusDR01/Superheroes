DROP DATABASE IF EXISTS `bd_symblog`;
CREATE DATABASE IF NOT EXISTS `bd_symblog`;
USE `bd_symblog`;

#blog es el post
CREATE TABLE IF NOT EXISTS `blog` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `title` VARCHAR(255),
  `author` VARCHAR(100),
  `blog` LONGTEXT,
  `image` VARCHAR(20),
  `tags` LONGTEXT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `comment` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `blog_id` INT NOT NULL,
  `user` VARCHAR(255),
  `comment` LONGTEXT,
  `approved` BOOLEAN,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
   CONSTRAINT `fk1_comment`
   FOREIGN KEY (`blog_id`)
   REFERENCES `bd_symblog`.`blog` (`id`)
   ON DELETE CASCADE
   ON UPDATE CASCADE
);

CREATE TRIGGER `update_updated_at1` 
BEFORE UPDATE 
ON `comment` FOR EACH ROW 
SET NEW.updated_at = CURRENT_TIMESTAMP;

CREATE TRIGGER `update_updated_at2` 
BEFORE UPDATE 
ON `blog` FOR EACH ROW 
SET NEW.updated_at = CURRENT_TIMESTAMP;