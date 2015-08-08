ALTER TABLE  `user_det` CHANGE  `description`  `description` TEXT CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL

ALTER TABLE  `user` ADD  `wizard_completed` BOOLEAN NOT NULL DEFAULT FALSE