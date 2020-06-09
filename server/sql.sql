CREATE DATABASE xlsx_to_db;
ALTER DATABASE xlsx_to_db charset=utf8;

CREATE USER xlsx_to_db_user@'localhost' IDENTIFIED BY 'password123';
GRANT ALL PRIVILEGES on xlsx_to_db.* to xlsx_to_db_user@'localhost';

USE xlsx_to_db;

CREATE TABLE texts (
        id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        body TEXT,
        FULLTEXT (body)
);
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
