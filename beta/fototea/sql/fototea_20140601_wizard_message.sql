ALTER TABLE  `user` ADD  `wizard_contact_creative_completed` BOOLEAN NOT NULL DEFAULT FALSE;

ALTER TABLE  `notificaciones` CHANGE  `url`  `url` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

ALTER TABLE  `notificaciones` CHANGE  `type`  `type` VARCHAR( 2 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;