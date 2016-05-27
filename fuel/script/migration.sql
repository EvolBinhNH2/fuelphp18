SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `type` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL,
  `migration` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('package', 'auth', '001_auth_create_usertables');
INSERT INTO `migration` VALUES ('package', 'auth', '002_auth_create_grouptables');
INSERT INTO `migration` VALUES ('package', 'auth', '003_auth_create_roletables');
INSERT INTO `migration` VALUES ('package', 'auth', '004_auth_create_permissiontables');
INSERT INTO `migration` VALUES ('package', 'auth', '005_auth_create_authdefaults');
INSERT INTO `migration` VALUES ('package', 'auth', '006_auth_add_authactions');
INSERT INTO `migration` VALUES ('package', 'auth', '007_auth_add_permissionsfilter');
INSERT INTO `migration` VALUES ('package', 'auth', '008_auth_create_providers');
INSERT INTO `migration` VALUES ('package', 'auth', '009_auth_create_oauth2tables');
INSERT INTO `migration` VALUES ('package', 'auth', '010_auth_fix_jointables');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(100) NOT NULL,
  `post_content` text NOT NULL,
  `author_name` varchar(65) NOT NULL,
  `author_email` varchar(80) NOT NULL,
  `author_website` varchar(60) DEFAULT NULL,
  `post_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('1', '1234567890', '111', '111', 'XXXX@gmail.com', 'http://gmail.com', '1');
INSERT INTO `posts` VALUES ('2', '1234567891', '2222222', '111', 'XXXX@gmail.com', 'http://gmail.com', '1');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group` int(11) NOT NULL DEFAULT '1',
  `email` varchar(255) NOT NULL,
  `last_login` varchar(25) NOT NULL,
  `login_hash` varchar(255) NOT NULL,
  `profile_fields` text NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'truongnv169', 'WFGiZsP1aNuJ8m5HoidABYEuT6Z4D888ry/kTId2Bzk=', '1', 'truongnv169@gmail.com', '1464178499', '2b5a2d8f289008ea5c2c6b82059503a282e658e2', 'a:1:{s:8:\"fullname\";s:23:\"Trường Nguyễn Văn\";}', '1464148844', '0');

-- ----------------------------
-- Table structure for users_clients
-- ----------------------------
DROP TABLE IF EXISTS `users_clients`;
CREATE TABLE `users_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `client_secret` varchar(32) NOT NULL DEFAULT '',
  `redirect_uri` varchar(255) NOT NULL DEFAULT '',
  `auto_approve` tinyint(1) NOT NULL DEFAULT '0',
  `autonomous` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('development','pending','approved','rejected') NOT NULL DEFAULT 'development',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `notes` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_id` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_clients
-- ----------------------------

-- ----------------------------
-- Table structure for users_providers
-- ----------------------------
DROP TABLE IF EXISTS `users_providers`;
CREATE TABLE `users_providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `provider` varchar(50) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `expires` int(12) DEFAULT '0',
  `refresh_token` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_providers
-- ----------------------------
INSERT INTO `users_providers` VALUES ('1', '1', 'Google', '118257015597498728383', null, 'ya29.CjHtAqoyNWQrzEeUCowWSpEiDxREUDRCxaQq018Ku_eYlgpb6snFXtqWp6VAl7tl5CZR', '1464152443', null, '0', '1464148844', '0');

-- ----------------------------
-- Table structure for users_scopes
-- ----------------------------
DROP TABLE IF EXISTS `users_scopes`;
CREATE TABLE `users_scopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scope` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `scope` (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_scopes
-- ----------------------------

-- ----------------------------
-- Table structure for users_sessions
-- ----------------------------
DROP TABLE IF EXISTS `users_sessions`;
CREATE TABLE `users_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `redirect_uri` varchar(255) NOT NULL DEFAULT '',
  `type_id` varchar(64) NOT NULL,
  `type` enum('user','auto') NOT NULL DEFAULT 'user',
  `code` text NOT NULL,
  `access_token` varchar(50) NOT NULL DEFAULT '',
  `stage` enum('request','granted') NOT NULL DEFAULT 'request',
  `first_requested` int(11) NOT NULL,
  `last_updated` int(11) NOT NULL,
  `limited_access` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `oauth_sessions_ibfk_1` (`client_id`),
  CONSTRAINT `oauth_sessions_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users_clients` (`client_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_sessions
-- ----------------------------

-- ----------------------------
-- Table structure for users_sessionscopes
-- ----------------------------
DROP TABLE IF EXISTS `users_sessionscopes`;
CREATE TABLE `users_sessionscopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `access_token` varchar(50) NOT NULL DEFAULT '',
  `scope` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  KEY `access_token` (`access_token`),
  KEY `scope` (`scope`),
  CONSTRAINT `oauth_sessionscopes_ibfk_1` FOREIGN KEY (`scope`) REFERENCES `users_scopes` (`scope`),
  CONSTRAINT `oauth_sessionscopes_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `users_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_sessionscopes
-- ----------------------------
