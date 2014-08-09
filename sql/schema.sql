DROP DATABASE IF EXISTS `lab_present`;
CREATE DATABASE `lab_present` DEFAULT CHARSET utf8;

use `lab_present`;

GRANT ALL
ON `lab_present`.*
TO `lab_db_user`@localhost IDENTIFIED BY 'lab_db_user_password';

CREATE TABLE IF NOT EXISTS `images` (
   `id`         INT(11)    NOT NULL AUTO_INCREMENT,
   `is_resized` TINYINT(4) NOT NULL DEFAULT 0,
   PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `admin` (
   `id`       INT         NOT NULL AUTO_INCREMENT,
   `login`    VARCHAR(50) NOT NULL,
   `pass_md5` VARCHAR(50) NOT NULL,
   PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `index_meta` (
   `id`           INT          NOT NULL AUTO_INCREMENT,
   `title`        VARCHAR(130) NOT NULL,
   `keywords`     TEXT,
   `description`  TEXT,
   PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `news` (
   `id`               INT          NOT NULL AUTO_INCREMENT,
   `url`              VARCHAR(150) NOT NULL,
   `head`             VARCHAR(150) NOT NULL,
   `body`             TEXT         NOT NULL,
   `description`      TEXT         NOT NULL,
   `photo_id`         INT          DEFAULT NULL,
   `meta_title`       VARCHAR(130) NOT NULL,
   `meta_keywords`    TEXT,
   `meta_description` TEXT,
   `publication_date` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   UNIQUE KEY(`url`),
   FOREIGN KEY (`photo_id`) REFERENCES `images` (`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `news_images` (
   `id`       INT NOT NULL AUTO_INCREMENT,
   `news_id`  INT NOT NULL,
   `photo_id` INT NOT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`news_id`)  REFERENCES `news`   (`id`) ON DELETE CASCADE,
   FOREIGN KEY (`photo_id`) REFERENCES `images` (`id`) ON DELETE CASCADE
);

DELIMITER //

DROP TRIGGER IF EXISTS `update_admin`//
CREATE TRIGGER `update_admin` BEFORE UPDATE ON `admin`
FOR EACH ROW BEGIN
   IF new.pass_md5 != old.pass_md5 THEN
      SET new.pass_md5 = MD5(new.pass_md5);
   END IF;
END//

DELIMITER ;

INSERT INTO `admin`(`login`, `pass_md5`) VALUES('admin', '21232f297a57a5a743894a0e4a801fc3');

INSERT INTO `index_meta`(`title`, `keywords`, `description`) VALUES('Lab Present - Главная', '', '');
