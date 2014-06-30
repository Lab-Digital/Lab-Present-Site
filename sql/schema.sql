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

DELIMITER //

DROP TRIGGER IF EXISTS `update_admin`//
CREATE TRIGGER `update_admin` BEFORE UPDATE ON `admin`
FOR EACH ROW BEGIN
   IF new.pass_md5 != old.pass_md5 THEN
      SET new.pass_md5 = MD5(new.pass_md5);
   END IF;
END//

INSERT INTO `admin`(`login`, `pass_md5`) VALUES('admin', '21232f297a57a5a743894a0e4a801fc3');
