DROP DATABASE IF EXISTS `lab_present`;
CREATE DATABASE `lab_present` DEFAULT CHARSET utf8;

use `lab_present`;

GRANT ALL
ON `lab_present`.*
TO `lab_db_user`@localhost IDENTIFIED BY 'lab_db_user_password';

CREATE TABLE IF NOT EXISTS `images` (
   `id`         INT(11)     NOT NULL AUTO_INCREMENT,
   `ext`        VARCHAR(5)  NOT NULL,
   `is_resized` TINYINT(4)  NOT NULL DEFAULT 0,
   PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `admin` (
   `id`       INT         NOT NULL AUTO_INCREMENT,
   `login`    VARCHAR(50) NOT NULL,
   `pass_md5` VARCHAR(50) NOT NULL,
   PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `meta` (
   `id`           INT          NOT NULL AUTO_INCREMENT,
   `head`         VARCHAR(130) NOT NULL,
   `title`        VARCHAR(200) NOT NULL,
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
   `bigphoto_id`      INT          DEFAULT NULL,
   `other_photo_id`   INT          DEFAULT NULL,
   `meta_title`       VARCHAR(130) NOT NULL,
   `meta_keywords`    TEXT,
   `meta_description` TEXT,
   `publication_date` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   UNIQUE KEY(`url`),
   FOREIGN KEY (`photo_id`)       REFERENCES `images` (`id`) ON DELETE SET NULL,
   FOREIGN KEY (`bigphoto_id`)    REFERENCES `images` (`id`) ON DELETE SET NULL,
   FOREIGN KEY (`other_photo_id`) REFERENCES `images` (`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `news_images` (
   `id`       INT NOT NULL AUTO_INCREMENT,
   `news_id`  INT NOT NULL,
   `photo_id` INT NOT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`news_id`)  REFERENCES `news`   (`id`) ON DELETE CASCADE,
   FOREIGN KEY (`photo_id`) REFERENCES `images` (`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `departments` (
   `id`               INT          NOT NULL AUTO_INCREMENT,
   `url`              VARCHAR(150) NOT NULL,
   `head`             VARCHAR(150) NOT NULL,
   `avatar_id`        INT          DEFAULT NULL,
   `photo_id`         INT          DEFAULT NULL,
   `body`             TEXT,
   `meta_title`       VARCHAR(130) NOT NULL,
   `meta_keywords`    TEXT,
   `meta_description` TEXT,
   PRIMARY KEY (`id`),
   UNIQUE KEY(`url`),
   FOREIGN KEY (`photo_id`)  REFERENCES `images` (`id`) ON DELETE SET NULL,
   FOREIGN KEY (`avatar_id`) REFERENCES `images` (`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `proposal` (
   `id`             INT          NOT NULL AUTO_INCREMENT,
   `name`           VARCHAR(180) NOT NULL,
   `email`          VARCHAR(180) NOT NULL,
   `phone`          VARCHAR(32)  NOT NULL,
   `task`           TEXT         DEFAULT '',
   `department_id`  INT          DEFAULT NULL,
   `zip_name`       TEXT,
   `date`           TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
   CHECK (`is_express` >= 0 AND `is_express` <= 1),
   PRIMARY KEY (`id`),
   FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `portfolio` (
   `id`               INT          NOT NULL AUTO_INCREMENT,
   `head`             VARCHAR(150) NOT NULL,
   `avatar_id`        INT          DEFAULT NULL,
   `photo_id`         INT          DEFAULT NULL,
   `description`      TEXT,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`photo_id`)  REFERENCES `images` (`id`) ON DELETE SET NULL,
   FOREIGN KEY (`avatar_id`) REFERENCES `images` (`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `portfolio_departments` (
   `id`            INT NOT NULL AUTO_INCREMENT,
   `portfolio_id`  INT NOT NULL,
   `department_id` INT NOT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY  (`portfolio_id`, `department_id`),
   FOREIGN KEY (`portfolio_id`)  REFERENCES `portfolio`   (`id`) ON DELETE CASCADE,
   FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `news_departments` (
   `id`            INT NOT NULL AUTO_INCREMENT,
   `news_id`       INT NOT NULL,
   `department_id` INT NOT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY  (`news_id`, `department_id`),
   FOREIGN KEY (`news_id`)       REFERENCES `news`        (`id`) ON DELETE CASCADE,
   FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `projects` (
   `id`               INT          NOT NULL AUTO_INCREMENT,
   `url`              VARCHAR(150) NOT NULL,
   `head`             VARCHAR(150) NOT NULL,
   `photo_id`         INT          DEFAULT NULL,
   `avatar_id`        INT          DEFAULT NULL,
   `body`             TEXT,
   `description`      TEXT,
   `meta_title`       VARCHAR(130) NOT NULL,
   `meta_keywords`    TEXT,
   `meta_description` TEXT,
   PRIMARY KEY (`id`),
   UNIQUE KEY(`url`),
   FOREIGN KEY (`photo_id`)  REFERENCES `images` (`id`) ON DELETE SET NULL,
   FOREIGN KEY (`avatar_id`) REFERENCES `images` (`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `projects_images` (
   `id`         INT NOT NULL AUTO_INCREMENT,
   `project_id` INT NOT NULL,
   `photo_id`   INT NOT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`photo_id`)   REFERENCES `images`   (`id`) ON DELETE CASCADE,
   FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `main_slider` (
   `id`         INT          NOT NULL AUTO_INCREMENT,
   `head`       VARCHAR(150) NOT NULL,
   `text`       TEXT,
   `color`      VARCHAR(10)  NOT NULL,
   `text_color` VARCHAR(10)  NOT NULL,
   `number`     INT          NOT NULL DEFAULT 1,
   `avatar_id`  INT          DEFAULT NULL,
   `url`        VARCHAR(300) DEFAULT '',
   CHECK (`position` >= 0 AND `position` <= 2),
   PRIMARY KEY (`id`),
   FOREIGN KEY (`avatar_id`) REFERENCES `images` (`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `resume` (
   `id`        INT          NOT NULL AUTO_INCREMENT,
   `head`      VARCHAR(200) NOT NULL,
   `number`    INT          NOT NULL DEFAULT 1,
   `photo_id`  INT          DEFAULT NULL,
   `body`      TEXT         DEFAULT '',
   PRIMARY KEY (`id`),
   FOREIGN KEY (`photo_id`) REFERENCES `images` (`id`) ON DELETE SET NULL
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

INSERT INTO `meta`(`head`, `title`, `keywords`, `description`) VALUES
   ('Главная страница', 'Lab Present - Главная', 'main page keywords', 'main page description'),
   ('Все новости', 'Lab Present - Новости', 'news page keywords', 'news page description'),
   ('Резюме', 'Lab Present - Резюме', 'resume page keywords', 'resume page description'),
   ('Контакты', 'Lab Present - Контакты', 'contacts page keywords', 'contacts page description');

INSERT INTO `departments` (`id`, `url`, `head`, `body`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
(1, 'internet', 'Интернет', 'Интернет', 'Интернет', 'Интернет', 'Интернет'),
(3, 'dizayn-i-kreativ', 'Дизайн и креатив', 'Дизайн и креатив', 'Дизайн и креатив', 'Дизайн и креатив', 'Дизайн и креатив'),
(4, 'btl', 'BTL', 'BTL', 'BTL', 'BTL', 'BTL'),
(5, 'videostudiya', 'Видеостудия', 'Видеостудия', 'Видеостудия', 'Видеостудия', 'Видеостудия'),
(6, 'outdoor-transport-media', 'Outdoor, транспорт, медиа', 'Outdoor, транспорт, медиа', 'Outdoor, транспорт, медиа', 'Outdoor, транспорт, медиа', 'Outdoor, транспорт, медиа'),
(7, 'reklamnoe-proizvodstvo', 'Рекламное производство', 'Рекламное производство', 'Рекламное производство', 'Рекламное производство', 'Рекламное производство');
