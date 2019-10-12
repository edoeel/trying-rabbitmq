USE `rabbit-db`;
SET NAMES UTF8;

CREATE TABLE `event_sent`
(
  `id`         int(10) unsigned,
  `insert_date`  timestamp default current_timestamp ,
  `processed_date`  timestamp null
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

