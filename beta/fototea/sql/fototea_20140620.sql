ALTER TABLE  `proyectos` ADD  `pro_environment` VARCHAR( 10 ) NULL;

ALTER TABLE  `proyectos` ADD  `pro_moment` VARCHAR( 10 ) NULL;

ALTER TABLE  `proyectos` ADD  `pro_deadline` DATE NULL;

ALTER TABLE  `tmp_project` ADD  `pro_environment` VARCHAR( 10 ) NULL;

ALTER TABLE  `tmp_project` ADD  `pro_moment` VARCHAR( 10 ) NULL;

ALTER TABLE  `tmp_project` ADD  `pro_deadline` DATE NULL;

ALTER TABLE  `user` ADD  `new_email` VARCHAR( 100 ) NULL AFTER  `user`;

ALTER TABLE  `user` ADD  `new_email_code` VARCHAR( 30 ) NULL AFTER  `new_email`;
