ALTER TABLE  `user` CHANGE  `gender`  `gender` VARCHAR( 1 ) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT  '';

ALTER TABLE  `user` CHANGE  `wizard_completed`  `wizard_completed` TINYINT( 1 ) NULL DEFAULT  '0';

ALTER TABLE  `user` CHANGE  `wizard_contact_creative_completed`  `wizard_contact_creative_completed` TINYINT( 1 ) NULL DEFAULT  '0';