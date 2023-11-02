ALTER TABLE `settings` ADD `meta_title` VARCHAR(255) NULL DEFAULT NULL AFTER `water_mark`, ADD `meta_description` TEXT NULL DEFAULT NULL AFTER `meta_title`, ADD `meta_keywords` TEXT NULL DEFAULT NULL AFTER `meta_description`;

ALTER TABLE `users` CHANGE `login_status` `login_status` ENUM('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0', CHANGE `user_status` `user_status` ENUM('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0';

ALTER TABLE `users` CHANGE `login_status` `login_status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0', CHANGE `user_status` `user_status` CHAR(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0';