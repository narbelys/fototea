ALTER TABLE `user_det` ENGINE=InnoDB;

ALTER TABLE  `user` ADD  `profile_completed` SMALLINT( 1 ) NOT NULL DEFAULT  '2' AFTER  `act_code`;

UPDATE `user` SET `profile_completed`= 0;