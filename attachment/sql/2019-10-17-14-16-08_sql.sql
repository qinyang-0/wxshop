/*************************
 * 2019-10-17 14:16:08 
 ************************/
SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `mmwl_account`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_account`;
CREATE TABLE `mmwl_account` (
  `acid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `hash` varchar(8) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `isconnect` tinyint(4) NOT NULL,
  `isdeleted` tinyint(3) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`acid`),
  KEY `idx_uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_account 
-- ----------------------------
INSERT INTO `mmwl_account` VALUES ('1', '1', 'uRr8qvQV', '1', '0', '1', '0');
INSERT INTO `mmwl_account` VALUES ('2', '2', 'x8Hh88ox', '4', '0', '0', '0');

-- ----------------------------
-- Table structure for `mmwl_account_aliapp`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_account_aliapp`;
CREATE TABLE `mmwl_account_aliapp` (
  `acid` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `level` tinyint(4) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `key` varchar(16) NOT NULL,
  PRIMARY KEY (`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_account_baiduapp`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_account_baiduapp`;
CREATE TABLE `mmwl_account_baiduapp` (
  `acid` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `appid` varchar(32) NOT NULL,
  `key` varchar(32) NOT NULL,
  `secret` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`acid`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_account_phoneapp`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_account_phoneapp`;
CREATE TABLE `mmwl_account_phoneapp` (
  `acid` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`acid`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_account_toutiaoapp`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_account_toutiaoapp`;
CREATE TABLE `mmwl_account_toutiaoapp` (
  `acid` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `appid` varchar(32) NOT NULL,
  `key` varchar(32) NOT NULL,
  `secret` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`acid`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_account_webapp`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_account_webapp`;
CREATE TABLE `mmwl_account_webapp` (
  `acid` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`acid`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_account_wechats`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_account_wechats`;
CREATE TABLE `mmwl_account_wechats` (
  `acid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `token` varchar(32) NOT NULL,
  `encodingaeskey` varchar(255) NOT NULL,
  `level` tinyint(4) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `account` varchar(30) NOT NULL,
  `original` varchar(50) NOT NULL,
  `signature` varchar(100) NOT NULL,
  `country` varchar(10) NOT NULL,
  `province` varchar(3) NOT NULL,
  `city` varchar(15) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL,
  `key` varchar(50) NOT NULL,
  `secret` varchar(50) NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  `subscribeurl` varchar(120) NOT NULL,
  `auth_refresh_token` varchar(255) NOT NULL,
  PRIMARY KEY (`acid`),
  KEY `idx_key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_account_wechats 
-- ----------------------------
INSERT INTO `mmwl_account_wechats` VALUES ('1', '1', 'omJNpZEhZeHj1ZxFECKkP48B5VFbk1HP', '', '1', 'we7team', '', '', '', '', '', '', '', '', '0', '', '', '1', '', '');

-- ----------------------------
-- Table structure for `mmwl_account_wxapp`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_account_wxapp`;
CREATE TABLE `mmwl_account_wxapp` (
  `acid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `token` varchar(32) NOT NULL,
  `encodingaeskey` varchar(43) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `account` varchar(30) NOT NULL,
  `original` varchar(50) NOT NULL,
  `key` varchar(50) NOT NULL,
  `secret` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `appdomain` varchar(255) NOT NULL,
  `auth_refresh_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`acid`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_account_wxapp 
-- ----------------------------
INSERT INTO `mmwl_account_wxapp` VALUES ('2', '2', 'x3fe8f8f5M3VlMO8oLelzv8NQO3Mv3Ll', 'zv58Qo4F5MmEO5olEdD8fODf8F88azFm8FANQMomFA8', '1', '', '1', 'wxd638314c68886fa2', '4ebd340075b469f19087fde400b546a5', '麦芒团购', '', '');

-- ----------------------------
-- Table structure for `mmwl_account_xzapp`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_account_xzapp`;
CREATE TABLE `mmwl_account_xzapp` (
  `acid` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `original` varchar(50) NOT NULL,
  `lastupdate` int(10) NOT NULL,
  `styleid` int(10) NOT NULL,
  `createtime` int(10) NOT NULL,
  `token` varchar(32) NOT NULL,
  `encodingaeskey` varchar(255) NOT NULL,
  `xzapp_id` varchar(30) NOT NULL,
  `level` tinyint(4) unsigned NOT NULL,
  `key` varchar(80) NOT NULL,
  `secret` varchar(80) NOT NULL,
  PRIMARY KEY (`acid`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_activity_clerk_menu`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_activity_clerk_menu`;
CREATE TABLE `mmwl_activity_clerk_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `displayorder` int(4) NOT NULL,
  `pid` int(6) NOT NULL,
  `group_name` varchar(20) NOT NULL,
  `title` varchar(20) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `permission` varchar(50) NOT NULL,
  `system` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_activity_clerks`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_activity_clerks`;
CREATE TABLE `mmwl_activity_clerks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `password` (`password`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_article_category`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_article_category`;
CREATE TABLE `mmwl_article_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `type` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_article_comment`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_article_comment`;
CREATE TABLE `mmwl_article_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `articleid` int(10) NOT NULL,
  `parentid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `content` varchar(500) DEFAULT NULL,
  `is_like` tinyint(1) NOT NULL,
  `is_reply` tinyint(1) NOT NULL,
  `like_num` int(10) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `articleid` (`articleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_article_news`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_article_news`;
CREATE TABLE `mmwl_article_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cateid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_show_home` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `click` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `cateid` (`cateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_article_notice`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_article_notice`;
CREATE TABLE `mmwl_article_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cateid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_show_home` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `click` int(10) unsigned NOT NULL,
  `style` varchar(200) NOT NULL,
  `group` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `cateid` (`cateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_article_unread_notice`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_article_unread_notice`;
CREATE TABLE `mmwl_article_unread_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notice_id` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `is_new` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `notice_id` (`notice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_attachment_group`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_attachment_group`;
CREATE TABLE `mmwl_attachment_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_basic_reply`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_basic_reply`;
CREATE TABLE `mmwl_basic_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `content` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_business`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_business`;
CREATE TABLE `mmwl_business` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `dist` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `lng` varchar(10) NOT NULL,
  `lat` varchar(10) NOT NULL,
  `industry1` varchar(10) NOT NULL,
  `industry2` varchar(10) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_lat_lng` (`lng`,`lat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_attachment`;
CREATE TABLE `mmwl_core_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `module_upload_dir` varchar(100) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_core_attachment 
-- ----------------------------
INSERT INTO `mmwl_core_attachment` VALUES ('1', '0', '1', 'icon.jpg', 'images/0/2019/07/XJn1iADuiN1BIgjioMAngACgoMmzOU.jpg', '1', '1563416769', '', '-1');

-- ----------------------------
-- Table structure for `mmwl_core_cache`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_cache`;
CREATE TABLE `mmwl_core_cache` (
  `key` varchar(100) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_core_cache 
-- ----------------------------
INSERT INTO `mmwl_core_cache` VALUES ('we7:account_ticket', 's:0:"";');
INSERT INTO `mmwl_core_cache` VALUES ('we7:setting', 'a:7:{s:9:"copyright";a:3:{s:6:"slides";a:3:{i:0;s:58:"https://img.alicdn.com/tps/TB1pfG4IFXXXXc6XXXXXXXXXXXX.jpg";i:1;s:58:"https://img.alicdn.com/tps/TB1sXGYIFXXXXc5XpXXXXXXXXXX.jpg";i:2;s:58:"https://img.alicdn.com/tps/TB1h9xxIFXXXXbKXXXXXXXXXXXX.jpg";}s:14:"develop_status";i:1;s:8:"baidumap";a:2:{s:3:"lng";N;s:3:"lat";N;}}s:8:"authmode";i:1;s:5:"close";a:2:{s:6:"status";s:1:"0";s:6:"reason";s:0:"";}s:8:"register";a:4:{s:4:"open";i:1;s:6:"verify";i:0;s:4:"code";i:1;s:7:"groupid";i:1;}s:4:"site";a:3:{s:3:"key";i:189924;s:5:"token";s:32:"aa6f621fec30841328af01fcafb1f2cf";s:3:"url";s:16:"http://mwzxw.top";}s:7:"cloudip";a:0:{}s:6:"upload";a:4:{s:5:"image";a:5:{s:10:"extentions";a:4:{i:0;s:3:"gif";i:1;s:3:"jpg";i:2;s:4:"jpeg";i:3;s:3:"png";}s:5:"limit";i:5000;s:5:"thumb";i:1;s:5:"width";i:800;s:14:"zip_percentage";i:100;}s:9:"attachdir";s:10:"attachment";s:5:"audio";a:2:{s:10:"extentions";a:2:{i:0;s:3:"mp3";i:1;s:3:"mp4";}s:5:"limit";d:8192;}s:16:"attachment_limit";i:5000;}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:userbasefields', 'a:46:{s:7:"uniacid";s:17:"同一公众号id";s:7:"groupid";s:8:"分组id";s:7:"credit1";s:6:"积分";s:7:"credit2";s:6:"余额";s:7:"credit3";s:19:"预留积分类型3";s:7:"credit4";s:19:"预留积分类型4";s:7:"credit5";s:19:"预留积分类型5";s:7:"credit6";s:19:"预留积分类型6";s:10:"createtime";s:12:"加入时间";s:6:"mobile";s:12:"手机号码";s:5:"email";s:12:"电子邮箱";s:8:"realname";s:12:"真实姓名";s:8:"nickname";s:6:"昵称";s:6:"avatar";s:6:"头像";s:2:"qq";s:5:"QQ号";s:6:"gender";s:6:"性别";s:5:"birth";s:6:"生日";s:13:"constellation";s:6:"星座";s:6:"zodiac";s:6:"生肖";s:9:"telephone";s:12:"固定电话";s:6:"idcard";s:12:"证件号码";s:9:"studentid";s:6:"学号";s:5:"grade";s:6:"班级";s:7:"address";s:6:"地址";s:7:"zipcode";s:6:"邮编";s:11:"nationality";s:6:"国籍";s:6:"reside";s:9:"居住地";s:14:"graduateschool";s:12:"毕业学校";s:7:"company";s:6:"公司";s:9:"education";s:6:"学历";s:10:"occupation";s:6:"职业";s:8:"position";s:6:"职位";s:7:"revenue";s:9:"年收入";s:15:"affectivestatus";s:12:"情感状态";s:10:"lookingfor";s:13:" 交友目的";s:9:"bloodtype";s:6:"血型";s:6:"height";s:6:"身高";s:6:"weight";s:6:"体重";s:6:"alipay";s:15:"支付宝帐号";s:3:"msn";s:3:"MSN";s:6:"taobao";s:12:"阿里旺旺";s:4:"site";s:6:"主页";s:3:"bio";s:12:"自我介绍";s:8:"interest";s:12:"兴趣爱好";s:8:"password";s:6:"密码";s:12:"pay_password";s:12:"支付密码";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:usersfields', 'a:47:{s:8:"realname";s:12:"真实姓名";s:8:"nickname";s:6:"昵称";s:6:"avatar";s:6:"头像";s:2:"qq";s:5:"QQ号";s:6:"mobile";s:12:"手机号码";s:3:"vip";s:9:"VIP级别";s:6:"gender";s:6:"性别";s:9:"birthyear";s:12:"出生生日";s:13:"constellation";s:6:"星座";s:6:"zodiac";s:6:"生肖";s:9:"telephone";s:12:"固定电话";s:6:"idcard";s:12:"证件号码";s:9:"studentid";s:6:"学号";s:5:"grade";s:6:"班级";s:7:"address";s:12:"邮寄地址";s:7:"zipcode";s:6:"邮编";s:11:"nationality";s:6:"国籍";s:14:"resideprovince";s:12:"居住地址";s:14:"graduateschool";s:12:"毕业学校";s:7:"company";s:6:"公司";s:9:"education";s:6:"学历";s:10:"occupation";s:6:"职业";s:8:"position";s:6:"职位";s:7:"revenue";s:9:"年收入";s:15:"affectivestatus";s:12:"情感状态";s:10:"lookingfor";s:13:" 交友目的";s:9:"bloodtype";s:6:"血型";s:6:"height";s:6:"身高";s:6:"weight";s:6:"体重";s:6:"alipay";s:15:"支付宝帐号";s:3:"msn";s:3:"MSN";s:5:"email";s:12:"电子邮箱";s:6:"taobao";s:12:"阿里旺旺";s:4:"site";s:6:"主页";s:3:"bio";s:12:"自我介绍";s:8:"interest";s:12:"兴趣爱好";s:7:"uniacid";s:17:"同一公众号id";s:7:"groupid";s:8:"分组id";s:7:"credit1";s:6:"积分";s:7:"credit2";s:6:"余额";s:7:"credit3";s:19:"预留积分类型3";s:7:"credit4";s:19:"预留积分类型4";s:7:"credit5";s:19:"预留积分类型5";s:7:"credit6";s:19:"预留积分类型6";s:10:"createtime";s:12:"加入时间";s:8:"password";s:12:"用户密码";s:12:"pay_password";s:12:"支付密码";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_receive_enable', 'a:0:{}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:system_frame:0', 'a:23:{s:7:"welcome";a:7:{s:5:"title";s:6:"首页";s:4:"icon";s:10:"wi wi-home";s:3:"url";s:48:"./index.php?c=home&a=welcome&do=system&page=home";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:2;}s:8:"platform";a:8:{s:5:"title";s:12:"平台入口";s:4:"icon";s:14:"wi wi-platform";s:9:"dimension";i:2;s:3:"url";s:44:"./index.php?c=account&a=display&do=platform&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:3;}s:6:"module";a:8:{s:5:"title";s:12:"应用入口";s:4:"icon";s:11:"wi wi-apply";s:9:"dimension";i:2;s:3:"url";s:53:"./index.php?c=module&a=display&do=switch_last_module&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:4;}s:14:"account_manage";a:8:{s:5:"title";s:12:"平台管理";s:4:"icon";s:21:"wi wi-platform-manage";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=account&a=manage&";s:7:"section";a:1:{s:14:"account_manage";a:2:{s:5:"title";s:12:"平台管理";s:4:"menu";a:4:{s:22:"account_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"平台列表";s:3:"url";s:31:"./index.php?c=account&a=manage&";s:15:"permission_name";s:22:"account_manage_display";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:1:{i:0;a:2:{s:5:"title";s:12:"帐号停用";s:15:"permission_name";s:19:"account_manage_stop";}}}s:22:"account_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:32:"./index.php?c=account&a=recycle&";s:15:"permission_name";s:22:"account_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"帐号删除";s:15:"permission_name";s:21:"account_manage_delete";}i:1;a:2:{s:5:"title";s:12:"帐号恢复";s:15:"permission_name";s:22:"account_manage_recover";}}}s:30:"account_manage_system_platform";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:19:" 微信开放平台";s:3:"url";s:32:"./index.php?c=system&a=platform&";s:15:"permission_name";s:30:"account_manage_system_platform";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:30:"account_manage_expired_message";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:22:" 自定义到期提示";s:3:"url";s:40:"./index.php?c=account&a=expired-message&";s:15:"permission_name";s:30:"account_manage_expired_message";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:5;}s:13:"module_manage";a:8:{s:5:"title";s:12:"应用管理";s:4:"icon";s:19:"wi wi-module-manage";s:9:"dimension";i:2;s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:7:"section";a:1:{s:13:"module_manage";a:2:{s:5:"title";s:12:"应用管理";s:4:"menu";a:5:{s:23:"module_manage_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已安装列表";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:15:"permission_name";s:23:"module_manage_installed";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:20:"module_manage_stoped";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已停用列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=1";s:15:"permission_name";s:20:"module_manage_stoped";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:27:"module_manage_not_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"未安装列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=not_installed&";s:15:"permission_name";s:27:"module_manage_not_installed";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"module_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=2";s:15:"permission_name";s:21:"module_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:23:"module_manage_subscribe";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"订阅管理";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=subscribe&";s:15:"permission_name";s:23:"module_manage_subscribe";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:6;}s:11:"user_manage";a:8:{s:5:"title";s:12:"用户管理";s:4:"icon";s:16:"wi wi-user-group";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=display&";s:7:"section";a:1:{s:11:"user_manage";a:2:{s:5:"title";s:12:"用户管理";s:4:"menu";a:6:{s:19:"user_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"普通用户";s:3:"url";s:29:"./index.php?c=user&a=display&";s:15:"permission_name";s:19:"user_manage_display";s:4:"icon";N;s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_clerk";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"店员管理";s:3:"url";s:39:"./index.php?c=user&a=display&type=clerk";s:15:"permission_name";s:17:"user_manage_clerk";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"审核用户";s:3:"url";s:39:"./index.php?c=user&a=display&type=check";s:15:"permission_name";s:17:"user_manage_check";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:19:"user_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:41:"./index.php?c=user&a=display&type=recycle";s:15:"permission_name";s:19:"user_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_fields";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户属性设置";s:3:"url";s:39:"./index.php?c=user&a=fields&do=display&";s:15:"permission_name";s:18:"user_manage_fields";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_expire";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户过期设置";s:3:"url";s:28:"./index.php?c=user&a=expire&";s:15:"permission_name";s:18:"user_manage_expire";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:7;}s:10:"permission";a:8:{s:5:"title";s:9:"权限组";s:4:"icon";s:22:"wi wi-userjurisdiction";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=module&a=group&";s:7:"section";a:1:{s:10:"permission";a:2:{s:5:"title";s:9:"权限组";s:4:"menu";a:3:{s:23:"permission_module_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"应用权限组";s:3:"url";s:29:"./index.php?c=module&a=group&";s:15:"permission_name";s:23:"permission_module_group";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:31:"permission_create_account_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"账号权限组";s:3:"url";s:34:"./index.php?c=user&a=create-group&";s:15:"permission_name";s:31:"permission_create_account_group";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"permission_user_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户权限组合";s:3:"url";s:27:"./index.php?c=user&a=group&";s:15:"permission_name";s:21:"permission_user_group";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:8;}s:6:"system";a:8:{s:5:"title";s:12:"系统功能";s:4:"icon";s:13:"wi wi-setting";s:9:"dimension";i:3;s:3:"url";s:35:"./index.php?c=system&a=updatecache&";s:7:"section";a:4:{s:7:"article";a:3:{s:5:"title";s:12:"站内公告";s:4:"menu";a:1:{s:14:"system_article";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站内公告";s:3:"url";s:31:"./index.php?c=article&a=notice&";s:15:"permission_name";s:14:"system_article";s:4:"icon";s:13:"wi wi-article";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"公告列表";s:15:"permission_name";s:26:"system_article_notice_list";}i:1;a:2:{s:5:"title";s:12:"公告分类";s:15:"permission_name";s:30:"system_article_notice_category";}}}}s:7:"founder";b:1;}s:15:"system_template";a:3:{s:5:"title";s:6:"模板";s:4:"menu";a:1:{s:15:"system_template";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"微官网模板";s:3:"url";s:32:"./index.php?c=system&a=template&";s:15:"permission_name";s:15:"system_template";s:4:"icon";s:17:"wi wi-wx-template";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:3:"sms";a:3:{s:5:"title";s:6:"短信";s:4:"menu";a:1:{s:16:"system_cloud_sms";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"短信管理";s:3:"url";s:26:"./index.php?c=cloud&a=sms&";s:15:"permission_name";s:16:"system_cloud_sms";s:4:"icon";s:9:"wi wi-sms";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:5:"cache";a:2:{s:5:"title";s:6:"缓存";s:4:"menu";a:1:{s:26:"system_setting_updatecache";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"更新缓存";s:3:"url";s:35:"./index.php?c=system&a=updatecache&";s:15:"permission_name";s:26:"system_setting_updatecache";s:4:"icon";s:12:"wi wi-update";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:9;}s:4:"site";a:9:{s:5:"title";s:12:"站点设置";s:4:"icon";s:17:"wi wi-system-site";s:9:"dimension";i:3;s:3:"url";s:30:"./index.php?c=cloud&a=upgrade&";s:7:"section";a:4:{s:5:"cloud";a:2:{s:5:"title";s:9:"云服务";s:4:"menu";a:3:{s:14:"system_profile";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统升级";s:3:"url";s:30:"./index.php?c=cloud&a=upgrade&";s:15:"permission_name";s:20:"system_cloud_upgrade";s:4:"icon";s:11:"wi wi-cache";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_register";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"注册站点";s:3:"url";s:30:"./index.php?c=cloud&a=profile&";s:15:"permission_name";s:21:"system_cloud_register";s:4:"icon";s:18:"wi wi-registersite";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_diagnose";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"云服务诊断";s:3:"url";s:31:"./index.php?c=cloud&a=diagnose&";s:15:"permission_name";s:21:"system_cloud_diagnose";s:4:"icon";s:14:"wi wi-diagnose";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"setting";a:2:{s:5:"title";s:6:"设置";s:4:"menu";a:9:{s:19:"system_setting_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站点设置";s:3:"url";s:28:"./index.php?c=system&a=site&";s:15:"permission_name";s:19:"system_setting_site";s:4:"icon";s:18:"wi wi-site-setting";s:12:"displayorder";i:9;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"菜单设置";s:3:"url";s:28:"./index.php?c=system&a=menu&";s:15:"permission_name";s:19:"system_setting_menu";s:4:"icon";s:18:"wi wi-menu-setting";s:12:"displayorder";i:8;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_attachment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"附件设置";s:3:"url";s:34:"./index.php?c=system&a=attachment&";s:15:"permission_name";s:25:"system_setting_attachment";s:4:"icon";s:16:"wi wi-attachment";s:12:"displayorder";i:7;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_systeminfo";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统信息";s:3:"url";s:34:"./index.php?c=system&a=systeminfo&";s:15:"permission_name";s:25:"system_setting_systeminfo";s:4:"icon";s:17:"wi wi-system-info";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_logs";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"查看日志";s:3:"url";s:28:"./index.php?c=system&a=logs&";s:15:"permission_name";s:19:"system_setting_logs";s:4:"icon";s:9:"wi wi-log";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:26:"system_setting_ipwhitelist";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:11:"IP白名单";s:3:"url";s:35:"./index.php?c=system&a=ipwhitelist&";s:15:"permission_name";s:26:"system_setting_ipwhitelist";s:4:"icon";s:8:"wi wi-ip";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:28:"system_setting_sensitiveword";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"过滤敏感词";s:3:"url";s:37:"./index.php?c=system&a=sensitiveword&";s:15:"permission_name";s:28:"system_setting_sensitiveword";s:4:"icon";s:15:"wi wi-sensitive";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_thirdlogin";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:25:"用户登录/注册设置";s:3:"url";s:33:"./index.php?c=user&a=registerset&";s:15:"permission_name";s:25:"system_setting_thirdlogin";s:4:"icon";s:10:"wi wi-user";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_setting_oauth";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"全局借用权限";s:3:"url";s:29:"./index.php?c=system&a=oauth&";s:15:"permission_name";s:20:"system_setting_oauth";s:4:"icon";s:11:"wi wi-oauth";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"utility";a:2:{s:5:"title";s:12:"常用工具";s:4:"menu";a:6:{s:24:"system_utility_filecheck";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统文件校验";s:3:"url";s:33:"./index.php?c=system&a=filecheck&";s:15:"permission_name";s:24:"system_utility_filecheck";s:4:"icon";s:10:"wi wi-file";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_optimize";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"性能优化";s:3:"url";s:32:"./index.php?c=system&a=optimize&";s:15:"permission_name";s:23:"system_utility_optimize";s:4:"icon";s:14:"wi wi-optimize";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_database";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"数据库";s:3:"url";s:32:"./index.php?c=system&a=database&";s:15:"permission_name";s:23:"system_utility_database";s:4:"icon";s:9:"wi wi-sql";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_utility_scan";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"木马查杀";s:3:"url";s:28:"./index.php?c=system&a=scan&";s:15:"permission_name";s:19:"system_utility_scan";s:4:"icon";s:12:"wi wi-safety";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:18:"system_utility_bom";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"检测文件BOM";s:3:"url";s:27:"./index.php?c=system&a=bom&";s:15:"permission_name";s:18:"system_utility_bom";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_utility_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统常规检测";s:3:"url";s:29:"./index.php?c=system&a=check&";s:15:"permission_name";s:20:"system_utility_check";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"backjob";a:2:{s:5:"title";s:12:"后台任务";s:4:"menu";a:1:{s:10:"system_job";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"后台任务";s:3:"url";s:38:"./index.php?c=system&a=job&do=display&";s:15:"permission_name";s:10:"system_job";s:4:"icon";s:9:"wi wi-job";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:10;}s:6:"myself";a:8:{s:5:"title";s:12:"我的账户";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=profile&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:11;}s:7:"message";a:8:{s:5:"title";s:12:"消息管理";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=message&a=notice&";s:7:"section";a:1:{s:7:"message";a:2:{s:5:"title";s:12:"消息管理";s:4:"menu";a:3:{s:14:"message_notice";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息提醒";s:3:"url";s:31:"./index.php?c=message&a=notice&";s:15:"permission_name";s:14:"message_notice";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:15:"message_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息设置";s:3:"url";s:42:"./index.php?c=message&a=notice&do=setting&";s:15:"permission_name";s:15:"message_setting";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:22:"message_wechat_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"微信提醒设置";s:3:"url";s:49:"./index.php?c=message&a=notice&do=wechat_setting&";s:15:"permission_name";s:22:"message_wechat_setting";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:12;}s:7:"account";a:8:{s:5:"title";s:9:"公众号";s:4:"icon";s:18:"wi wi-white-collar";s:9:"dimension";i:3;s:3:"url";s:41:"./index.php?c=home&a=welcome&do=platform&";s:7:"section";a:4:{s:8:"platform";a:4:{s:5:"title";s:12:"增强功能";s:4:"menu";a:6:{s:14:"platform_reply";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"自动回复";s:3:"url";s:31:"./index.php?c=platform&a=reply&";s:15:"permission_name";s:14:"platform_reply";s:4:"icon";s:11:"wi wi-reply";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:7:{s:22:"platform_reply_keyword";a:4:{s:5:"title";s:21:"关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=keyword";s:15:"permission_name";s:22:"platform_reply_keyword";s:6:"active";s:7:"keyword";}s:22:"platform_reply_special";a:4:{s:5:"title";s:24:"非关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=special";s:15:"permission_name";s:22:"platform_reply_special";s:6:"active";s:7:"special";}s:22:"platform_reply_welcome";a:4:{s:5:"title";s:24:"首次访问自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=welcome";s:15:"permission_name";s:22:"platform_reply_welcome";s:6:"active";s:7:"welcome";}s:22:"platform_reply_default";a:4:{s:5:"title";s:12:"默认回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=default";s:15:"permission_name";s:22:"platform_reply_default";s:6:"active";s:7:"default";}s:22:"platform_reply_service";a:4:{s:5:"title";s:12:"常用服务";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=service";s:15:"permission_name";s:22:"platform_reply_service";s:6:"active";s:7:"service";}s:22:"platform_reply_userapi";a:5:{s:5:"title";s:21:"自定义接口回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=userapi";s:15:"permission_name";s:22:"platform_reply_userapi";s:6:"active";s:7:"userapi";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"platform_reply_setting";a:4:{s:5:"title";s:12:"回复设置";s:3:"url";s:38:"./index.php?c=profile&a=reply-setting&";s:15:"permission_name";s:22:"platform_reply_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:13:"platform_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:15:"自定义菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:13:"platform_menu";s:4:"icon";s:16:"wi wi-custommenu";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:21:"platform_menu_default";a:4:{s:5:"title";s:12:"默认菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:21:"platform_menu_default";s:6:"active";s:4:"post";}s:25:"platform_menu_conditional";a:5:{s:5:"title";s:15:"个性化菜单";s:3:"url";s:47:"./index.php?c=platform&a=menu&do=display&type=3";s:15:"permission_name";s:25:"platform_menu_conditional";s:6:"active";s:7:"display";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:11:"platform_qr";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:22:"二维码/转化链接";s:3:"url";s:28:"./index.php?c=platform&a=qr&";s:15:"permission_name";s:11:"platform_qr";s:4:"icon";s:12:"wi wi-qrcode";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:2:{s:14:"platform_qr_qr";a:4:{s:5:"title";s:9:"二维码";s:3:"url";s:36:"./index.php?c=platform&a=qr&do=list&";s:15:"permission_name";s:14:"platform_qr_qr";s:6:"active";s:4:"list";}s:22:"platform_qr_statistics";a:4:{s:5:"title";s:21:"二维码扫描统计";s:3:"url";s:39:"./index.php?c=platform&a=qr&do=display&";s:15:"permission_name";s:22:"platform_qr_statistics";s:6:"active";s:7:"display";}}}s:17:"platform_masstask";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"定时群发";s:3:"url";s:30:"./index.php?c=platform&a=mass&";s:15:"permission_name";s:17:"platform_masstask";s:4:"icon";s:13:"wi wi-crontab";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:22:"platform_masstask_post";a:4:{s:5:"title";s:12:"定时群发";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=post&";s:15:"permission_name";s:22:"platform_masstask_post";s:6:"active";s:4:"post";}s:22:"platform_masstask_send";a:4:{s:5:"title";s:12:"群发记录";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=send&";s:15:"permission_name";s:22:"platform_masstask_send";s:6:"active";s:4:"send";}}}s:17:"platform_material";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:16:"素材/编辑器";s:3:"url";s:34:"./index.php?c=platform&a=material&";s:15:"permission_name";s:17:"platform_material";s:4:"icon";s:12:"wi wi-redact";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:5:{s:22:"platform_material_news";a:4:{s:5:"title";s:6:"图文";s:3:"url";s:43:"./index.php?c=platform&a=material&type=news";s:15:"permission_name";s:22:"platform_material_news";s:6:"active";s:4:"news";}s:23:"platform_material_image";a:4:{s:5:"title";s:6:"图片";s:3:"url";s:44:"./index.php?c=platform&a=material&type=image";s:15:"permission_name";s:23:"platform_material_image";s:6:"active";s:5:"image";}s:23:"platform_material_voice";a:4:{s:5:"title";s:6:"语音";s:3:"url";s:44:"./index.php?c=platform&a=material&type=voice";s:15:"permission_name";s:23:"platform_material_voice";s:6:"active";s:5:"voice";}s:23:"platform_material_video";a:5:{s:5:"title";s:6:"视频";s:3:"url";s:44:"./index.php?c=platform&a=material&type=video";s:15:"permission_name";s:23:"platform_material_video";s:6:"active";s:5:"video";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"platform_material_delete";a:3:{s:5:"title";s:6:"删除";s:15:"permission_name";s:24:"platform_material_delete";s:10:"is_display";b:0;}}}s:13:"platform_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:16:"微官网-文章";s:3:"url";s:27:"./index.php?c=site&a=multi&";s:15:"permission_name";s:13:"platform_site";s:4:"icon";s:10:"wi wi-home";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:19:"platform_site_multi";a:4:{s:5:"title";s:9:"微官网";s:3:"url";s:38:"./index.php?c=site&a=multi&do=display&";s:15:"permission_name";s:19:"platform_site_multi";s:6:"active";s:5:"multi";}s:19:"platform_site_style";a:4:{s:5:"title";s:15:"微官网模板";s:3:"url";s:39:"./index.php?c=site&a=style&do=template&";s:15:"permission_name";s:19:"platform_site_style";s:6:"active";s:5:"style";}s:21:"platform_site_article";a:4:{s:5:"title";s:12:"文章管理";s:3:"url";s:40:"./index.php?c=site&a=article&do=display&";s:15:"permission_name";s:21:"platform_site_article";s:6:"active";s:7:"article";}s:22:"platform_site_category";a:4:{s:5:"title";s:18:"文章分类管理";s:3:"url";s:41:"./index.php?c=site&a=category&do=display&";s:15:"permission_name";s:22:"platform_site_category";s:6:"active";s:8:"category";}}}}s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;}s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:4:{s:5:"title";s:6:"粉丝";s:4:"menu";a:3:{s:7:"mc_fans";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"粉丝管理";s:3:"url";s:24:"./index.php?c=mc&a=fans&";s:15:"permission_name";s:7:"mc_fans";s:4:"icon";s:16:"wi wi-fansmanage";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:15:"mc_fans_display";a:4:{s:5:"title";s:12:"全部粉丝";s:3:"url";s:35:"./index.php?c=mc&a=fans&do=display&";s:15:"permission_name";s:15:"mc_fans_display";s:6:"active";s:7:"display";}s:21:"mc_fans_fans_sync_set";a:4:{s:5:"title";s:18:"粉丝同步设置";s:3:"url";s:41:"./index.php?c=mc&a=fans&do=fans_sync_set&";s:15:"permission_name";s:21:"mc_fans_fans_sync_set";s:6:"active";s:13:"fans_sync_set";}}}s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"会员管理";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:9:"mc_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:7:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:12:"mc_member_uc";a:5:{s:5:"title";s:12:"会员中心";s:3:"url";s:34:"./index.php?c=site&a=editor&do=uc&";s:15:"permission_name";s:12:"mc_member_uc";s:6:"active";s:2:"uc";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:19:"mc_member_quickmenu";a:5:{s:5:"title";s:12:"快捷菜单";s:3:"url";s:41:"./index.php?c=site&a=editor&do=quickmenu&";s:15:"permission_name";s:19:"mc_member_quickmenu";s:6:"active";s:9:"quickmenu";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"mc_member_register_seting";a:5:{s:5:"title";s:12:"注册设置";s:3:"url";s:46:"./index.php?c=mc&a=member&do=register_setting&";s:15:"permission_name";s:25:"mc_member_register_seting";s:6:"active";s:16:"register_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}s:10:"mc_message";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"留言管理";s:3:"url";s:27:"./index.php?c=mc&a=message&";s:15:"permission_name";s:10:"mc_message";s:4:"icon";s:13:"wi wi-message";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;}s:7:"profile";a:4:{s:5:"title";s:6:"配置";s:4:"menu";a:5:{s:15:"profile_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:15:"profile_setting";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:6:{s:22:"profile_setting_remote";a:4:{s:5:"title";s:12:"远程附件";s:3:"url";s:42:"./index.php?c=profile&a=remote&do=display&";s:15:"permission_name";s:22:"profile_setting_remote";s:6:"active";s:7:"display";}s:24:"profile_setting_passport";a:5:{s:5:"title";s:12:"借用权限";s:3:"url";s:42:"./index.php?c=profile&a=passport&do=oauth&";s:15:"permission_name";s:24:"profile_setting_passport";s:6:"active";s:5:"oauth";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"profile_setting_tplnotice";a:5:{s:5:"title";s:18:"微信通知设置";s:3:"url";s:42:"./index.php?c=profile&a=tplnotice&do=list&";s:15:"permission_name";s:25:"profile_setting_tplnotice";s:6:"active";s:4:"list";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"profile_setting_notify";a:5:{s:5:"title";s:18:"邮件通知参数";s:3:"url";s:39:"./index.php?c=profile&a=notify&do=mail&";s:15:"permission_name";s:22:"profile_setting_notify";s:6:"active";s:4:"mail";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:26:"profile_setting_uc_setting";a:5:{s:5:"title";s:14:"UC站点整合";s:3:"url";s:45:"./index.php?c=profile&a=common&do=uc_setting&";s:15:"permission_name";s:26:"profile_setting_uc_setting";s:6:"active";s:10:"uc_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:27:"profile_setting_upload_file";a:5:{s:5:"title";s:20:"上传JS接口文件";s:3:"url";s:46:"./index.php?c=profile&a=common&do=upload_file&";s:15:"permission_name";s:27:"profile_setting_upload_file";s:6:"active";s:11:"upload_file";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:15:"profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:12:"支付参数";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:15:"profile_payment";s:4:"icon";s:17:"wi wi-pay-setting";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:2:{s:19:"profile_payment_pay";a:4:{s:5:"title";s:12:"支付配置";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:19:"profile_payment_pay";s:6:"active";s:7:"payment";}s:22:"profile_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:42:"./index.php?c=profile&a=refund&do=display&";s:15:"permission_name";s:22:"profile_payment_refund";s:6:"active";s:6:"refund";}}}s:23:"profile_app_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:31:"profile_app_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:18:"webapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:18:"webapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:14:"webapp_rewrite";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:9:"伪静态";s:3:"url";s:31:"./index.php?c=webapp&a=rewrite&";s:15:"permission_name";s:14:"webapp_rewrite";s:4:"icon";s:13:"wi wi-rewrite";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:13;}s:5:"wxapp";a:8:{s:5:"title";s:15:"微信小程序";s:4:"icon";s:19:"wi wi-small-routine";s:9:"dimension";i:3;s:3:"url";s:38:"./index.php?c=wxapp&a=display&do=home&";s:7:"section";a:5:{s:14:"wxapp_entrance";a:4:{s:5:"title";s:15:"小程序入口";s:4:"menu";a:1:{s:20:"module_entrance_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"入口页面";s:3:"url";s:36:"./index.php?c=wxapp&a=entrance-link&";s:15:"permission_name";s:19:"wxapp_entrance_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;}s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:4:{s:5:"title";s:6:"粉丝";s:4:"menu";a:1:{s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:6:"会员";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:15:"mc_wxapp_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}}s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;}s:13:"wxapp_profile";a:3:{s:5:"title";s:6:"配置";s:4:"menu";a:5:{s:33:"wxapp_profile_module_link_uniacid";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:33:"wxapp_profile_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:21:"wxapp_profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"支付参数";s:3:"url";s:30:"./index.php?c=wxapp&a=payment&";s:15:"permission_name";s:21:"wxapp_profile_payment";s:4:"icon";s:16:"wi wi-appsetting";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:17:"wxapp_payment_pay";a:4:{s:5:"title";s:12:"支付参数";s:3:"url";s:41:"./index.php?c=wxapp&a=payment&do=display&";s:15:"permission_name";s:17:"wxapp_payment_pay";s:6:"active";s:7:"payment";}s:20:"wxapp_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:40:"./index.php?c=wxapp&a=refund&do=display&";s:15:"permission_name";s:20:"wxapp_payment_refund";s:6:"active";s:6:"refund";}}}s:28:"wxapp_profile_front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";i:1;s:10:"is_display";i:1;s:5:"title";s:15:"下载程序包";s:3:"url";s:37:"./index.php?c=wxapp&a=front-download&";s:15:"permission_name";s:28:"wxapp_profile_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:23:"wxapp_profile_domainset";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"域名设置";s:3:"url";s:32:"./index.php?c=wxapp&a=domainset&";s:15:"permission_name";s:23:"wxapp_profile_domainset";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:22:"profile_setting_remote";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:22:"profile_setting_remote";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}}s:10:"statistics";a:4:{s:5:"title";s:6:"统计";s:4:"menu";a:1:{s:16:"statistics_visit";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;s:5:"title";s:12:"访问统计";s:3:"url";s:31:"./index.php?c=statistics&a=app&";s:15:"permission_name";s:22:"statistics_visit_wxapp";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:3:{s:20:"statistics_visit_app";a:4:{s:5:"title";s:24:"app端访问统计信息";s:3:"url";s:42:"./index.php?c=statistics&a=app&do=display&";s:15:"permission_name";s:20:"statistics_visit_app";s:6:"active";s:3:"app";}s:21:"statistics_visit_site";a:4:{s:5:"title";s:24:"所有用户访问统计";s:3:"url";s:51:"./index.php?c=statistics&a=site&do=current_account&";s:15:"permission_name";s:21:"statistics_visit_site";s:6:"active";s:4:"site";}s:24:"statistics_visit_setting";a:4:{s:5:"title";s:18:"访问统计设置";s:3:"url";s:46:"./index.php?c=statistics&a=setting&do=display&";s:15:"permission_name";s:24:"statistics_visit_setting";s:6:"active";s:7:"setting";}}}}s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:14;}s:6:"webapp";a:7:{s:5:"title";s:2:"PC";s:4:"icon";s:8:"wi wi-pc";s:3:"url";s:39:"./index.php?c=webapp&a=home&do=display&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:15;}s:8:"phoneapp";a:7:{s:5:"title";s:3:"APP";s:4:"icon";s:18:"wi wi-white-collar";s:3:"url";s:41:"./index.php?c=phoneapp&a=display&do=home&";s:7:"section";a:2:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:16:"phoneapp_profile";a:4:{s:5:"title";s:6:"配置";s:4:"menu";a:2:{s:28:"profile_phoneapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:6;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:28:"profile_phoneapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:14:"front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";b:1;s:10:"is_display";i:1;s:5:"title";s:9:"下载APP";s:3:"url";s:40:"./index.php?c=phoneapp&a=front-download&";s:15:"permission_name";s:23:"phoneapp_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";b:1;s:18:"permission_display";a:1:{i:0;i:6;}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:16;}s:5:"xzapp";a:7:{s:5:"title";s:9:"熊掌号";s:4:"icon";s:11:"wi wi-xzapp";s:3:"url";s:38:"./index.php?c=xzapp&a=home&do=display&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:17;}s:6:"aliapp";a:7:{s:5:"title";s:18:"支付宝小程序";s:4:"icon";s:12:"wi wi-aliapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:18;}s:8:"baiduapp";a:7:{s:5:"title";s:15:"百度小程序";s:4:"icon";s:14:"wi wi-baiduapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:19;}s:10:"toutiaoapp";a:7:{s:5:"title";s:15:"头条小程序";s:4:"icon";s:16:"wi wi-toutiaoapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:20;}s:9:"appmarket";a:9:{s:5:"title";s:6:"市场";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:14:"http://s.w7.cc";s:7:"section";a:0:{}s:5:"blank";b:1;s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:21;}s:9:"workorder";a:9:{s:5:"title";s:6:"工单";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:44:"./index.php?c=system&a=workorder&do=display&";s:7:"section";a:1:{s:9:"workorder";a:2:{s:5:"title";s:12:"工单系统";s:4:"menu";a:1:{s:16:"system_workorder";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"工单系统";s:3:"url";s:44:"./index.php?c=system&a=workorder&do=display&";s:15:"permission_name";s:16:"system_workorder";s:4:"icon";s:17:"wi wi-system-work";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:22;}s:4:"help";a:7:{s:5:"title";s:6:"帮助";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:29:"./index.php?c=help&a=display&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:23;}s:11:"custom_help";a:7:{s:5:"title";s:12:"本站帮助";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:39:"./index.php?c=help&a=display&do=custom&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:24;}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:group_buy', 'a:35:{s:3:"mid";s:2:"13";s:4:"name";s:9:"group_buy";s:4:"type";s:8:"business";s:5:"title";s:18:"麦芒社区团购";s:7:"version";s:3:"1.2";s:7:"ability";s:27:"包含社区团购等功能";s:11:"description";s:27:"包含社区团购等功能";s:6:"author";s:6:"scmmwl";s:3:"url";s:22:"http://www.scmmwl.com/";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:0:{}s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"0";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:6:"a:0:{}";s:13:"title_initial";s:1:"M";s:13:"wxapp_support";s:1:"2";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"1";s:15:"account_support";s:1:"1";s:13:"xzapp_support";s:1:"1";s:14:"aliapp_support";s:1:"1";s:4:"logo";s:48:"http://sqtg.scmmwl.com/addons/group_buy/icon.jpg";s:16:"baiduapp_support";s:1:"1";s:18:"toutiaoapp_support";s:1:"1";s:4:"from";s:5:"local";s:9:"isdisplay";i:1;s:7:"preview";s:64:"http://sqtg.scmmwl.com/addons/group_buy/preview.jpg?v=1569570125";s:11:"main_module";b:0;s:11:"plugin_list";a:3:{i:0;s:25:"group_buy_plugin_fraction";i:1;s:29:"group_buy_plugin_distribution";i:2;s:24:"group_buy_plugin_seckill";}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:uniaccount:2', 'a:13:{s:4:"acid";s:1:"2";s:7:"uniacid";s:1:"2";s:5:"token";s:32:"x3fe8f8f5M3VlMO8oLelzv8NQO3Mv3Ll";s:14:"encodingaeskey";s:43:"zv58Qo4F5MmEO5olEdD8fODf8F88azFm8FANQMomFA8";s:5:"level";s:1:"1";s:7:"account";s:0:"";s:8:"original";s:1:"1";s:3:"key";s:18:"wxd638314c68886fa2";s:6:"secret";s:32:"4ebd340075b469f19087fde400b546a5";s:4:"name";s:12:"麦芒团购";s:9:"appdomain";s:0:"";s:18:"auth_refresh_token";s:0:"";s:11:"encrypt_key";s:18:"wxd638314c68886fa2";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:unisetting:2', 'a:31:{s:7:"uniacid";s:1:"2";s:8:"passport";s:0:"";s:5:"oauth";s:0:"";s:11:"jsauth_acid";s:1:"0";s:2:"uc";s:0:"";s:6:"notify";s:0:"";s:11:"creditnames";a:2:{s:7:"credit1";a:2:{s:5:"title";s:6:"积分";s:7:"enabled";i:1;}s:7:"credit2";a:2:{s:5:"title";s:6:"余额";s:7:"enabled";i:1;}}s:15:"creditbehaviors";a:2:{s:8:"activity";s:7:"credit1";s:8:"currency";s:7:"credit2";}s:7:"welcome";s:0:"";s:7:"default";s:0:"";s:15:"default_message";s:0:"";s:7:"payment";a:1:{s:6:"wechat";a:3:{s:5:"mchid";s:10:"1482977942";s:7:"signkey";s:32:"BK16NIepSoInfywfjDTnATwoAvtdmdYm";s:7:"account";i:2;}}s:4:"stat";s:0:"";s:12:"default_site";N;s:4:"sync";s:1:"0";s:8:"recharge";s:0:"";s:9:"tplnotice";s:0:"";s:10:"grouplevel";s:1:"0";s:8:"mcplugin";s:0:"";s:15:"exchange_enable";s:1:"0";s:11:"coupon_type";s:1:"0";s:7:"menuset";s:0:"";s:10:"statistics";s:0:"";s:11:"bind_domain";s:0:"";s:14:"comment_status";s:1:"0";s:13:"reply_setting";s:1:"0";s:14:"default_module";s:0:"";s:16:"attachment_limit";N;s:15:"attachment_size";N;s:11:"sync_member";s:1:"0";s:6:"remote";a:2:{s:4:"type";i:0;s:6:"alioss";a:5:{s:3:"key";s:16:"LTAIzVbHyKhhggIb";s:6:"secret";s:30:"ar6ZHxatsS5ltiyy96eZzHnj5d03pO";s:8:"internal";i:0;s:6:"bucket";s:10:"scmmwltest";s:3:"url";s:45:"http://scmmwltest.oss-cn-beijing.aliyuncs.com";}}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:group_buy:2', 'a:7:{s:2:"id";s:1:"1";s:7:"uniacid";s:1:"2";s:6:"module";s:9:"group_buy";s:7:"enabled";s:1:"0";s:8:"settings";s:30:"a:1:{s:12:"direct_enter";i:0;}";s:8:"shortcut";s:1:"0";s:12:"displayorder";s:1:"0";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:group_buy_plugin_seckill', 'a:36:{s:3:"mid";s:2:"16";s:4:"name";s:24:"group_buy_plugin_seckill";s:4:"type";s:8:"business";s:5:"title";s:30:"麦芒社区团购整点秒杀";s:7:"version";s:6:"1.0.13";s:7:"ability";s:30:"麦芒社区团购整点秒杀";s:11:"description";s:30:"麦芒社区团购整点秒杀";s:6:"author";s:6:"scmmwl";s:3:"url";s:22:"http://www.scmmwl.com/";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:0:{}s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"0";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:6:"a:0:{}";s:13:"title_initial";s:1:"M";s:13:"wxapp_support";s:1:"2";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"1";s:15:"account_support";s:1:"1";s:13:"xzapp_support";s:1:"1";s:14:"aliapp_support";s:1:"1";s:4:"logo";s:63:"http://sqtg.scmmwl.com/addons/group_buy_plugin_seckill/icon.jpg";s:16:"baiduapp_support";s:1:"1";s:18:"toutiaoapp_support";s:1:"1";s:4:"from";s:5:"local";s:9:"isdisplay";i:1;s:7:"preview";s:79:"http://sqtg.scmmwl.com/addons/group_buy_plugin_seckill/preview.jpg?v=1569740716";s:11:"main_module";s:9:"group_buy";s:16:"main_module_logo";s:48:"http://sqtg.scmmwl.com/addons/group_buy/icon.jpg";s:17:"main_module_title";s:18:"麦芒社区团购";s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:group_buy_plugin_seckill:2', 'a:1:{s:6:"module";s:24:"group_buy_plugin_seckill";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:group_buy_plugin_distribution', 'a:36:{s:3:"mid";s:2:"15";s:4:"name";s:29:"group_buy_plugin_distribution";s:4:"type";s:8:"business";s:5:"title";s:36:"麦芒社区团购拼团分销插件";s:7:"version";s:6:"1.0.20";s:7:"ability";s:36:"麦芒社区团购拼团分销插件";s:11:"description";s:36:"麦芒社区团购拼团分销插件";s:6:"author";s:6:"scmmwl";s:3:"url";s:22:"http://www.scmmwl.com/";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:0:{}s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"0";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:6:"a:0:{}";s:13:"title_initial";s:1:"M";s:13:"wxapp_support";s:1:"2";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"1";s:15:"account_support";s:1:"1";s:13:"xzapp_support";s:1:"1";s:14:"aliapp_support";s:1:"1";s:4:"logo";s:68:"http://sqtg.scmmwl.com/addons/group_buy_plugin_distribution/icon.jpg";s:16:"baiduapp_support";s:1:"1";s:18:"toutiaoapp_support";s:1:"1";s:4:"from";s:5:"local";s:9:"isdisplay";i:1;s:7:"preview";s:84:"http://sqtg.scmmwl.com/addons/group_buy_plugin_distribution/preview.jpg?v=1569740716";s:11:"main_module";s:9:"group_buy";s:16:"main_module_logo";s:48:"http://sqtg.scmmwl.com/addons/group_buy/icon.jpg";s:17:"main_module_title";s:18:"麦芒社区团购";s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:group_buy_plugin_distribution:2', 'a:1:{s:6:"module";s:29:"group_buy_plugin_distribution";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:group_buy_plugin_fraction', 'a:36:{s:3:"mid";s:2:"14";s:4:"name";s:25:"group_buy_plugin_fraction";s:4:"type";s:8:"business";s:5:"title";s:18:"积分商城插件";s:7:"version";s:5:"1.0.5";s:7:"ability";s:18:"积分商城插件";s:11:"description";s:18:"积分商城插件";s:6:"author";s:2:"zd";s:3:"url";s:22:"http://www.scmmwl.com/";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:0:{}s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"0";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:6:"a:0:{}";s:13:"title_initial";s:1:"J";s:13:"wxapp_support";s:1:"2";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"1";s:15:"account_support";s:1:"1";s:13:"xzapp_support";s:1:"1";s:14:"aliapp_support";s:1:"1";s:4:"logo";s:64:"http://sqtg.scmmwl.com/addons/group_buy_plugin_fraction/icon.jpg";s:16:"baiduapp_support";s:1:"1";s:18:"toutiaoapp_support";s:1:"1";s:4:"from";s:5:"local";s:9:"isdisplay";i:1;s:7:"preview";s:80:"http://sqtg.scmmwl.com/addons/group_buy_plugin_fraction/preview.jpg?v=1569740716";s:11:"main_module";s:9:"group_buy";s:16:"main_module_logo";s:48:"http://sqtg.scmmwl.com/addons/group_buy/icon.jpg";s:17:"main_module_title";s:18:"麦芒社区团购";s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:group_buy_plugin_fraction:2', 'a:1:{s:6:"module";s:25:"group_buy_plugin_fraction";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:unimodules:2', 'a:4:{i:0;s:24:"group_buy_plugin_seckill";i:1;s:29:"group_buy_plugin_distribution";i:2;s:25:"group_buy_plugin_fraction";i:3;s:9:"group_buy";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:basic', 'a:35:{s:3:"mid";s:1:"1";s:4:"name";s:5:"basic";s:4:"type";s:6:"system";s:5:"title";s:18:"基本文字回复";s:7:"version";s:3:"1.0";s:7:"ability";s:24:"和您进行简单对话";s:11:"description";s:201:"一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:60:"http://sqtg.scmmwl.com/addons/basic/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:basic:2', 'a:1:{s:6:"module";s:5:"basic";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:news', 'a:35:{s:3:"mid";s:1:"2";s:4:"name";s:4:"news";s:4:"type";s:6:"system";s:5:"title";s:24:"基本混合图文回复";s:7:"version";s:3:"1.0";s:7:"ability";s:33:"为你提供生动的图文资讯";s:11:"description";s:272:"一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:59:"http://sqtg.scmmwl.com/addons/news/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:news:2', 'a:1:{s:6:"module";s:4:"news";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:music', 'a:35:{s:3:"mid";s:1:"3";s:4:"name";s:5:"music";s:4:"type";s:6:"system";s:5:"title";s:18:"基本音乐回复";s:7:"version";s:3:"1.0";s:7:"ability";s:39:"提供语音、音乐等音频类回复";s:11:"description";s:183:"在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:60:"http://sqtg.scmmwl.com/addons/music/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:music:2', 'a:1:{s:6:"module";s:5:"music";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:userapi', 'a:35:{s:3:"mid";s:1:"4";s:4:"name";s:7:"userapi";s:4:"type";s:6:"system";s:5:"title";s:21:"自定义接口回复";s:7:"version";s:3:"1.1";s:7:"ability";s:33:"更方便的第三方接口设置";s:11:"description";s:141:"自定义接口又称第三方接口，可以让开发者更方便的接入微擎系统，高效的与微信公众平台进行对接整合。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:62:"http://sqtg.scmmwl.com/addons/userapi/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:userapi:2', 'a:1:{s:6:"module";s:7:"userapi";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:recharge', 'a:35:{s:3:"mid";s:1:"5";s:4:"name";s:8:"recharge";s:4:"type";s:6:"system";s:5:"title";s:24:"会员中心充值模块";s:7:"version";s:3:"1.0";s:7:"ability";s:24:"提供会员充值功能";s:11:"description";s:0:"";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:63:"http://sqtg.scmmwl.com/addons/recharge/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:recharge:2', 'a:1:{s:6:"module";s:8:"recharge";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:images', 'a:35:{s:3:"mid";s:1:"7";s:4:"name";s:6:"images";s:4:"type";s:6:"system";s:5:"title";s:18:"基本图片回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"提供图片回复";s:11:"description";s:132:"在回复规则中可选择具有图片的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝图片。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:61:"http://sqtg.scmmwl.com/addons/images/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:images:2', 'a:1:{s:6:"module";s:6:"images";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:video', 'a:35:{s:3:"mid";s:1:"8";s:4:"name";s:5:"video";s:4:"type";s:6:"system";s:5:"title";s:18:"基本视频回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"提供图片回复";s:11:"description";s:132:"在回复规则中可选择具有视频的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝视频。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:60:"http://sqtg.scmmwl.com/addons/video/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:video:2', 'a:1:{s:6:"module";s:5:"video";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:voice', 'a:35:{s:3:"mid";s:1:"9";s:4:"name";s:5:"voice";s:4:"type";s:6:"system";s:5:"title";s:18:"基本语音回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"提供语音回复";s:11:"description";s:132:"在回复规则中可选择具有语音的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝语音。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:60:"http://sqtg.scmmwl.com/addons/voice/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:voice:2', 'a:1:{s:6:"module";s:5:"voice";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:wxcard', 'a:35:{s:3:"mid";s:2:"11";s:4:"name";s:6:"wxcard";s:4:"type";s:6:"system";s:5:"title";s:18:"微信卡券回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"微信卡券回复";s:11:"description";s:18:"微信卡券回复";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:61:"http://sqtg.scmmwl.com/addons/wxcard/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:wxcard:2', 'a:1:{s:6:"module";s:6:"wxcard";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:custom', 'a:35:{s:3:"mid";s:1:"6";s:4:"name";s:6:"custom";s:4:"type";s:6:"system";s:5:"title";s:15:"多客服转接";s:7:"version";s:5:"1.0.0";s:7:"ability";s:36:"用来接入腾讯的多客服系统";s:11:"description";s:0:"";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:17:"http://bbs.we7.cc";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:6:{i:0;s:5:"image";i:1;s:5:"voice";i:2;s:5:"video";i:3;s:8:"location";i:4;s:4:"link";i:5;s:4:"text";}s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:61:"http://sqtg.scmmwl.com/addons/custom/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:custom:2', 'a:1:{s:6:"module";s:6:"custom";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:chats', 'a:35:{s:3:"mid";s:2:"10";s:4:"name";s:5:"chats";s:4:"type";s:6:"system";s:5:"title";s:18:"发送客服消息";s:7:"version";s:3:"1.0";s:7:"ability";s:77:"公众号可以在粉丝最后发送消息的48小时内无限制发送消息";s:11:"description";s:0:"";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:60:"http://sqtg.scmmwl.com/addons/chats/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:chats:2', 'a:1:{s:6:"module";s:5:"chats";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:store', 'a:35:{s:3:"mid";s:2:"12";s:4:"name";s:5:"store";s:4:"type";s:8:"business";s:5:"title";s:12:"站内商城";s:7:"version";s:3:"1.0";s:7:"ability";s:12:"站内商城";s:11:"description";s:12:"站内商城";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:60:"http://sqtg.scmmwl.com/addons/store/preview.jpg?v=1569740716";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:store:2', 'a:1:{s:6:"module";s:5:"store";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:miniapp_version:1', 'a:19:{s:2:"id";s:1:"1";s:7:"uniacid";s:1:"2";s:7:"multiid";s:1:"0";s:7:"version";s:5:"1.0.0";s:11:"description";s:5:"1.0.0";s:7:"modules";a:1:{s:29:"group_buy_plugin_distribution";a:44:{s:3:"mid";s:2:"15";s:4:"name";s:29:"group_buy_plugin_distribution";s:4:"type";s:8:"business";s:5:"title";s:36:"麦芒社区团购拼团分销插件";s:7:"version";s:6:"1.0.20";s:7:"ability";s:36:"麦芒社区团购拼团分销插件";s:11:"description";s:36:"麦芒社区团购拼团分销插件";s:6:"author";s:6:"scmmwl";s:3:"url";s:22:"http://www.scmmwl.com/";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:0:{}s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"0";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:6:"a:0:{}";s:13:"title_initial";s:1:"M";s:13:"wxapp_support";s:1:"2";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"1";s:15:"account_support";s:1:"1";s:13:"xzapp_support";s:1:"1";s:14:"aliapp_support";s:1:"1";s:4:"logo";s:68:"http://sqtg.scmmwl.com/addons/group_buy_plugin_distribution/icon.jpg";s:16:"baiduapp_support";s:1:"1";s:18:"toutiaoapp_support";s:1:"1";s:4:"from";s:5:"local";s:9:"isdisplay";i:1;s:7:"preview";s:84:"http://sqtg.scmmwl.com/addons/group_buy_plugin_distribution/preview.jpg?v=1569740716";s:11:"main_module";s:9:"group_buy";s:16:"main_module_logo";s:48:"http://sqtg.scmmwl.com/addons/group_buy/icon.jpg";s:17:"main_module_title";s:18:"麦芒社区团购";s:12:"recycle_info";a:0:{}s:6:"config";a:0:{}s:7:"enabled";i:1;s:12:"displayorder";N;s:8:"shortcut";N;s:15:"module_shortcut";N;s:12:"cover_entrys";a:0:{}s:12:"defaultentry";N;s:7:"newicon";N;}}s:13:"design_method";s:1:"3";s:8:"template";s:1:"0";s:9:"quickmenu";s:0:"";s:10:"createtime";s:10:"1563416812";s:4:"type";s:1:"0";s:8:"entry_id";s:1:"0";s:7:"appjson";s:0:"";s:15:"default_appjson";s:0:"";s:11:"use_default";s:1:"0";s:12:"last_modules";a:0:{}s:13:"tominiprogram";a:2:{s:17:"wxasdfasdftjvb213";a:2:{s:5:"appid";s:17:"wxasdfasdftjvb213";s:8:"app_name";s:15:"微信小程序";}s:18:"wxqwerwqerqwtqeywe";a:2:{s:5:"appid";s:18:"wxqwerwqerqwtqeywe";s:8:"app_name";s:3:"111";}}s:11:"upload_time";s:1:"0";s:12:"cover_entrys";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('goods_cate2', 'a:0:{}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:system_frame:2', 'a:23:{s:7:"welcome";a:7:{s:5:"title";s:6:"首页";s:4:"icon";s:10:"wi wi-home";s:3:"url";s:48:"./index.php?c=home&a=welcome&do=system&page=home";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:2;}s:8:"platform";a:8:{s:5:"title";s:12:"平台入口";s:4:"icon";s:14:"wi wi-platform";s:9:"dimension";i:2;s:3:"url";s:44:"./index.php?c=account&a=display&do=platform&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:3;}s:6:"module";a:8:{s:5:"title";s:12:"应用入口";s:4:"icon";s:11:"wi wi-apply";s:9:"dimension";i:2;s:3:"url";s:53:"./index.php?c=module&a=display&do=switch_last_module&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:4;}s:14:"account_manage";a:8:{s:5:"title";s:12:"平台管理";s:4:"icon";s:21:"wi wi-platform-manage";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=account&a=manage&";s:7:"section";a:1:{s:14:"account_manage";a:2:{s:5:"title";s:12:"平台管理";s:4:"menu";a:4:{s:22:"account_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"平台列表";s:3:"url";s:31:"./index.php?c=account&a=manage&";s:15:"permission_name";s:22:"account_manage_display";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:1:{i:0;a:2:{s:5:"title";s:12:"帐号停用";s:15:"permission_name";s:19:"account_manage_stop";}}}s:22:"account_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:32:"./index.php?c=account&a=recycle&";s:15:"permission_name";s:22:"account_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"帐号删除";s:15:"permission_name";s:21:"account_manage_delete";}i:1;a:2:{s:5:"title";s:12:"帐号恢复";s:15:"permission_name";s:22:"account_manage_recover";}}}s:30:"account_manage_system_platform";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:19:" 微信开放平台";s:3:"url";s:32:"./index.php?c=system&a=platform&";s:15:"permission_name";s:30:"account_manage_system_platform";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:30:"account_manage_expired_message";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:22:" 自定义到期提示";s:3:"url";s:40:"./index.php?c=account&a=expired-message&";s:15:"permission_name";s:30:"account_manage_expired_message";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:5;}s:13:"module_manage";a:8:{s:5:"title";s:12:"应用管理";s:4:"icon";s:19:"wi wi-module-manage";s:9:"dimension";i:2;s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:7:"section";a:1:{s:13:"module_manage";a:2:{s:5:"title";s:12:"应用管理";s:4:"menu";a:5:{s:23:"module_manage_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已安装列表";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:15:"permission_name";s:23:"module_manage_installed";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:20:"module_manage_stoped";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已停用列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=1";s:15:"permission_name";s:20:"module_manage_stoped";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:27:"module_manage_not_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"未安装列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=not_installed&";s:15:"permission_name";s:27:"module_manage_not_installed";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"module_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=2";s:15:"permission_name";s:21:"module_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:23:"module_manage_subscribe";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"订阅管理";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=subscribe&";s:15:"permission_name";s:23:"module_manage_subscribe";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:6;}s:11:"user_manage";a:8:{s:5:"title";s:12:"用户管理";s:4:"icon";s:16:"wi wi-user-group";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=display&";s:7:"section";a:1:{s:11:"user_manage";a:2:{s:5:"title";s:12:"用户管理";s:4:"menu";a:6:{s:19:"user_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"普通用户";s:3:"url";s:29:"./index.php?c=user&a=display&";s:15:"permission_name";s:19:"user_manage_display";s:4:"icon";N;s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_clerk";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"店员管理";s:3:"url";s:39:"./index.php?c=user&a=display&type=clerk";s:15:"permission_name";s:17:"user_manage_clerk";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"审核用户";s:3:"url";s:39:"./index.php?c=user&a=display&type=check";s:15:"permission_name";s:17:"user_manage_check";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:19:"user_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:41:"./index.php?c=user&a=display&type=recycle";s:15:"permission_name";s:19:"user_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_fields";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户属性设置";s:3:"url";s:39:"./index.php?c=user&a=fields&do=display&";s:15:"permission_name";s:18:"user_manage_fields";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_expire";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户过期设置";s:3:"url";s:28:"./index.php?c=user&a=expire&";s:15:"permission_name";s:18:"user_manage_expire";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:7;}s:10:"permission";a:8:{s:5:"title";s:9:"权限组";s:4:"icon";s:22:"wi wi-userjurisdiction";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=module&a=group&";s:7:"section";a:1:{s:10:"permission";a:2:{s:5:"title";s:9:"权限组";s:4:"menu";a:3:{s:23:"permission_module_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"应用权限组";s:3:"url";s:29:"./index.php?c=module&a=group&";s:15:"permission_name";s:23:"permission_module_group";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:31:"permission_create_account_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"账号权限组";s:3:"url";s:34:"./index.php?c=user&a=create-group&";s:15:"permission_name";s:31:"permission_create_account_group";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"permission_user_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户权限组合";s:3:"url";s:27:"./index.php?c=user&a=group&";s:15:"permission_name";s:21:"permission_user_group";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:8;}s:6:"system";a:8:{s:5:"title";s:12:"系统功能";s:4:"icon";s:13:"wi wi-setting";s:9:"dimension";i:3;s:3:"url";s:31:"./index.php?c=article&a=notice&";s:7:"section";a:4:{s:7:"article";a:3:{s:5:"title";s:12:"站内公告";s:4:"menu";a:1:{s:14:"system_article";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站内公告";s:3:"url";s:31:"./index.php?c=article&a=notice&";s:15:"permission_name";s:14:"system_article";s:4:"icon";s:13:"wi wi-article";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"公告列表";s:15:"permission_name";s:26:"system_article_notice_list";}i:1;a:2:{s:5:"title";s:12:"公告分类";s:15:"permission_name";s:30:"system_article_notice_category";}}}}s:7:"founder";b:1;}s:15:"system_template";a:3:{s:5:"title";s:6:"模板";s:4:"menu";a:1:{s:15:"system_template";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"微官网模板";s:3:"url";s:32:"./index.php?c=system&a=template&";s:15:"permission_name";s:15:"system_template";s:4:"icon";s:17:"wi wi-wx-template";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:3:"sms";a:3:{s:5:"title";s:6:"短信";s:4:"menu";a:1:{s:16:"system_cloud_sms";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"短信管理";s:3:"url";s:26:"./index.php?c=cloud&a=sms&";s:15:"permission_name";s:16:"system_cloud_sms";s:4:"icon";s:9:"wi wi-sms";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:5:"cache";a:2:{s:5:"title";s:6:"缓存";s:4:"menu";a:1:{s:26:"system_setting_updatecache";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"更新缓存";s:3:"url";s:35:"./index.php?c=system&a=updatecache&";s:15:"permission_name";s:26:"system_setting_updatecache";s:4:"icon";s:12:"wi wi-update";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:9;}s:4:"site";a:9:{s:5:"title";s:12:"站点设置";s:4:"icon";s:17:"wi wi-system-site";s:9:"dimension";i:3;s:3:"url";s:30:"./index.php?c=cloud&a=upgrade&";s:7:"section";a:4:{s:5:"cloud";a:2:{s:5:"title";s:9:"云服务";s:4:"menu";a:3:{s:14:"system_profile";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统升级";s:3:"url";s:30:"./index.php?c=cloud&a=upgrade&";s:15:"permission_name";s:20:"system_cloud_upgrade";s:4:"icon";s:11:"wi wi-cache";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_register";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"注册站点";s:3:"url";s:30:"./index.php?c=cloud&a=profile&";s:15:"permission_name";s:21:"system_cloud_register";s:4:"icon";s:18:"wi wi-registersite";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_diagnose";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"云服务诊断";s:3:"url";s:31:"./index.php?c=cloud&a=diagnose&";s:15:"permission_name";s:21:"system_cloud_diagnose";s:4:"icon";s:14:"wi wi-diagnose";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"setting";a:2:{s:5:"title";s:6:"设置";s:4:"menu";a:9:{s:19:"system_setting_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站点设置";s:3:"url";s:28:"./index.php?c=system&a=site&";s:15:"permission_name";s:19:"system_setting_site";s:4:"icon";s:18:"wi wi-site-setting";s:12:"displayorder";i:9;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"菜单设置";s:3:"url";s:28:"./index.php?c=system&a=menu&";s:15:"permission_name";s:19:"system_setting_menu";s:4:"icon";s:18:"wi wi-menu-setting";s:12:"displayorder";i:8;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_attachment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"附件设置";s:3:"url";s:34:"./index.php?c=system&a=attachment&";s:15:"permission_name";s:25:"system_setting_attachment";s:4:"icon";s:16:"wi wi-attachment";s:12:"displayorder";i:7;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_systeminfo";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统信息";s:3:"url";s:34:"./index.php?c=system&a=systeminfo&";s:15:"permission_name";s:25:"system_setting_systeminfo";s:4:"icon";s:17:"wi wi-system-info";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_logs";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"查看日志";s:3:"url";s:28:"./index.php?c=system&a=logs&";s:15:"permission_name";s:19:"system_setting_logs";s:4:"icon";s:9:"wi wi-log";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:26:"system_setting_ipwhitelist";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:11:"IP白名单";s:3:"url";s:35:"./index.php?c=system&a=ipwhitelist&";s:15:"permission_name";s:26:"system_setting_ipwhitelist";s:4:"icon";s:8:"wi wi-ip";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:28:"system_setting_sensitiveword";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"过滤敏感词";s:3:"url";s:37:"./index.php?c=system&a=sensitiveword&";s:15:"permission_name";s:28:"system_setting_sensitiveword";s:4:"icon";s:15:"wi wi-sensitive";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_thirdlogin";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:25:"用户登录/注册设置";s:3:"url";s:33:"./index.php?c=user&a=registerset&";s:15:"permission_name";s:25:"system_setting_thirdlogin";s:4:"icon";s:10:"wi wi-user";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_setting_oauth";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"全局借用权限";s:3:"url";s:29:"./index.php?c=system&a=oauth&";s:15:"permission_name";s:20:"system_setting_oauth";s:4:"icon";s:11:"wi wi-oauth";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"utility";a:2:{s:5:"title";s:12:"常用工具";s:4:"menu";a:6:{s:24:"system_utility_filecheck";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统文件校验";s:3:"url";s:33:"./index.php?c=system&a=filecheck&";s:15:"permission_name";s:24:"system_utility_filecheck";s:4:"icon";s:10:"wi wi-file";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_optimize";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"性能优化";s:3:"url";s:32:"./index.php?c=system&a=optimize&";s:15:"permission_name";s:23:"system_utility_optimize";s:4:"icon";s:14:"wi wi-optimize";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_database";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"数据库";s:3:"url";s:32:"./index.php?c=system&a=database&";s:15:"permission_name";s:23:"system_utility_database";s:4:"icon";s:9:"wi wi-sql";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_utility_scan";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"木马查杀";s:3:"url";s:28:"./index.php?c=system&a=scan&";s:15:"permission_name";s:19:"system_utility_scan";s:4:"icon";s:12:"wi wi-safety";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:18:"system_utility_bom";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"检测文件BOM";s:3:"url";s:27:"./index.php?c=system&a=bom&";s:15:"permission_name";s:18:"system_utility_bom";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_utility_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统常规检测";s:3:"url";s:29:"./index.php?c=system&a=check&";s:15:"permission_name";s:20:"system_utility_check";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"backjob";a:2:{s:5:"title";s:12:"后台任务";s:4:"menu";a:1:{s:10:"system_job";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"后台任务";s:3:"url";s:38:"./index.php?c=system&a=job&do=display&";s:15:"permission_name";s:10:"system_job";s:4:"icon";s:9:"wi wi-job";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:10;}s:6:"myself";a:8:{s:5:"title";s:12:"我的账户";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=profile&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:11;}s:7:"message";a:8:{s:5:"title";s:12:"消息管理";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=message&a=notice&";s:7:"section";a:1:{s:7:"message";a:2:{s:5:"title";s:12:"消息管理";s:4:"menu";a:3:{s:14:"message_notice";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息提醒";s:3:"url";s:31:"./index.php?c=message&a=notice&";s:15:"permission_name";s:14:"message_notice";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:15:"message_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息设置";s:3:"url";s:42:"./index.php?c=message&a=notice&do=setting&";s:15:"permission_name";s:15:"message_setting";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:22:"message_wechat_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"微信提醒设置";s:3:"url";s:49:"./index.php?c=message&a=notice&do=wechat_setting&";s:15:"permission_name";s:22:"message_wechat_setting";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:12;}s:7:"account";a:8:{s:5:"title";s:9:"公众号";s:4:"icon";s:18:"wi wi-white-collar";s:9:"dimension";i:3;s:3:"url";s:41:"./index.php?c=home&a=welcome&do=platform&";s:7:"section";a:4:{s:8:"platform";a:4:{s:5:"title";s:12:"增强功能";s:4:"menu";a:6:{s:14:"platform_reply";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"自动回复";s:3:"url";s:31:"./index.php?c=platform&a=reply&";s:15:"permission_name";s:14:"platform_reply";s:4:"icon";s:11:"wi wi-reply";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:7:{s:22:"platform_reply_keyword";a:4:{s:5:"title";s:21:"关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=keyword";s:15:"permission_name";s:22:"platform_reply_keyword";s:6:"active";s:7:"keyword";}s:22:"platform_reply_special";a:4:{s:5:"title";s:24:"非关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=special";s:15:"permission_name";s:22:"platform_reply_special";s:6:"active";s:7:"special";}s:22:"platform_reply_welcome";a:4:{s:5:"title";s:24:"首次访问自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=welcome";s:15:"permission_name";s:22:"platform_reply_welcome";s:6:"active";s:7:"welcome";}s:22:"platform_reply_default";a:4:{s:5:"title";s:12:"默认回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=default";s:15:"permission_name";s:22:"platform_reply_default";s:6:"active";s:7:"default";}s:22:"platform_reply_service";a:4:{s:5:"title";s:12:"常用服务";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=service";s:15:"permission_name";s:22:"platform_reply_service";s:6:"active";s:7:"service";}s:22:"platform_reply_userapi";a:5:{s:5:"title";s:21:"自定义接口回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=userapi";s:15:"permission_name";s:22:"platform_reply_userapi";s:6:"active";s:7:"userapi";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"platform_reply_setting";a:4:{s:5:"title";s:12:"回复设置";s:3:"url";s:38:"./index.php?c=profile&a=reply-setting&";s:15:"permission_name";s:22:"platform_reply_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:13:"platform_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:15:"自定义菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:13:"platform_menu";s:4:"icon";s:16:"wi wi-custommenu";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:21:"platform_menu_default";a:4:{s:5:"title";s:12:"默认菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:21:"platform_menu_default";s:6:"active";s:4:"post";}s:25:"platform_menu_conditional";a:5:{s:5:"title";s:15:"个性化菜单";s:3:"url";s:47:"./index.php?c=platform&a=menu&do=display&type=3";s:15:"permission_name";s:25:"platform_menu_conditional";s:6:"active";s:7:"display";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:11:"platform_qr";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:22:"二维码/转化链接";s:3:"url";s:28:"./index.php?c=platform&a=qr&";s:15:"permission_name";s:11:"platform_qr";s:4:"icon";s:12:"wi wi-qrcode";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:2:{s:14:"platform_qr_qr";a:4:{s:5:"title";s:9:"二维码";s:3:"url";s:36:"./index.php?c=platform&a=qr&do=list&";s:15:"permission_name";s:14:"platform_qr_qr";s:6:"active";s:4:"list";}s:22:"platform_qr_statistics";a:4:{s:5:"title";s:21:"二维码扫描统计";s:3:"url";s:39:"./index.php?c=platform&a=qr&do=display&";s:15:"permission_name";s:22:"platform_qr_statistics";s:6:"active";s:7:"display";}}}s:17:"platform_masstask";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"定时群发";s:3:"url";s:30:"./index.php?c=platform&a=mass&";s:15:"permission_name";s:17:"platform_masstask";s:4:"icon";s:13:"wi wi-crontab";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:22:"platform_masstask_post";a:4:{s:5:"title";s:12:"定时群发";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=post&";s:15:"permission_name";s:22:"platform_masstask_post";s:6:"active";s:4:"post";}s:22:"platform_masstask_send";a:4:{s:5:"title";s:12:"群发记录";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=send&";s:15:"permission_name";s:22:"platform_masstask_send";s:6:"active";s:4:"send";}}}s:17:"platform_material";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:16:"素材/编辑器";s:3:"url";s:34:"./index.php?c=platform&a=material&";s:15:"permission_name";s:17:"platform_material";s:4:"icon";s:12:"wi wi-redact";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:5:{s:22:"platform_material_news";a:4:{s:5:"title";s:6:"图文";s:3:"url";s:43:"./index.php?c=platform&a=material&type=news";s:15:"permission_name";s:22:"platform_material_news";s:6:"active";s:4:"news";}s:23:"platform_material_image";a:4:{s:5:"title";s:6:"图片";s:3:"url";s:44:"./index.php?c=platform&a=material&type=image";s:15:"permission_name";s:23:"platform_material_image";s:6:"active";s:5:"image";}s:23:"platform_material_voice";a:4:{s:5:"title";s:6:"语音";s:3:"url";s:44:"./index.php?c=platform&a=material&type=voice";s:15:"permission_name";s:23:"platform_material_voice";s:6:"active";s:5:"voice";}s:23:"platform_material_video";a:5:{s:5:"title";s:6:"视频";s:3:"url";s:44:"./index.php?c=platform&a=material&type=video";s:15:"permission_name";s:23:"platform_material_video";s:6:"active";s:5:"video";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"platform_material_delete";a:3:{s:5:"title";s:6:"删除";s:15:"permission_name";s:24:"platform_material_delete";s:10:"is_display";b:0;}}}s:13:"platform_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:16:"微官网-文章";s:3:"url";s:27:"./index.php?c=site&a=multi&";s:15:"permission_name";s:13:"platform_site";s:4:"icon";s:10:"wi wi-home";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:19:"platform_site_multi";a:4:{s:5:"title";s:9:"微官网";s:3:"url";s:38:"./index.php?c=site&a=multi&do=display&";s:15:"permission_name";s:19:"platform_site_multi";s:6:"active";s:5:"multi";}s:19:"platform_site_style";a:4:{s:5:"title";s:15:"微官网模板";s:3:"url";s:39:"./index.php?c=site&a=style&do=template&";s:15:"permission_name";s:19:"platform_site_style";s:6:"active";s:5:"style";}s:21:"platform_site_article";a:4:{s:5:"title";s:12:"文章管理";s:3:"url";s:40:"./index.php?c=site&a=article&do=display&";s:15:"permission_name";s:21:"platform_site_article";s:6:"active";s:7:"article";}s:22:"platform_site_category";a:4:{s:5:"title";s:18:"文章分类管理";s:3:"url";s:41:"./index.php?c=site&a=category&do=display&";s:15:"permission_name";s:22:"platform_site_category";s:6:"active";s:8:"category";}}}}s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;}s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:4:{s:5:"title";s:6:"粉丝";s:4:"menu";a:3:{s:7:"mc_fans";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"粉丝管理";s:3:"url";s:24:"./index.php?c=mc&a=fans&";s:15:"permission_name";s:7:"mc_fans";s:4:"icon";s:16:"wi wi-fansmanage";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:15:"mc_fans_display";a:4:{s:5:"title";s:12:"全部粉丝";s:3:"url";s:35:"./index.php?c=mc&a=fans&do=display&";s:15:"permission_name";s:15:"mc_fans_display";s:6:"active";s:7:"display";}s:21:"mc_fans_fans_sync_set";a:4:{s:5:"title";s:18:"粉丝同步设置";s:3:"url";s:41:"./index.php?c=mc&a=fans&do=fans_sync_set&";s:15:"permission_name";s:21:"mc_fans_fans_sync_set";s:6:"active";s:13:"fans_sync_set";}}}s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"会员管理";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:9:"mc_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:7:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:12:"mc_member_uc";a:5:{s:5:"title";s:12:"会员中心";s:3:"url";s:34:"./index.php?c=site&a=editor&do=uc&";s:15:"permission_name";s:12:"mc_member_uc";s:6:"active";s:2:"uc";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:19:"mc_member_quickmenu";a:5:{s:5:"title";s:12:"快捷菜单";s:3:"url";s:41:"./index.php?c=site&a=editor&do=quickmenu&";s:15:"permission_name";s:19:"mc_member_quickmenu";s:6:"active";s:9:"quickmenu";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"mc_member_register_seting";a:5:{s:5:"title";s:12:"注册设置";s:3:"url";s:46:"./index.php?c=mc&a=member&do=register_setting&";s:15:"permission_name";s:25:"mc_member_register_seting";s:6:"active";s:16:"register_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}s:10:"mc_message";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"留言管理";s:3:"url";s:27:"./index.php?c=mc&a=message&";s:15:"permission_name";s:10:"mc_message";s:4:"icon";s:13:"wi wi-message";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;}s:7:"profile";a:4:{s:5:"title";s:6:"配置";s:4:"menu";a:5:{s:15:"profile_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:15:"profile_setting";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:6:{s:22:"profile_setting_remote";a:4:{s:5:"title";s:12:"远程附件";s:3:"url";s:42:"./index.php?c=profile&a=remote&do=display&";s:15:"permission_name";s:22:"profile_setting_remote";s:6:"active";s:7:"display";}s:24:"profile_setting_passport";a:5:{s:5:"title";s:12:"借用权限";s:3:"url";s:42:"./index.php?c=profile&a=passport&do=oauth&";s:15:"permission_name";s:24:"profile_setting_passport";s:6:"active";s:5:"oauth";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"profile_setting_tplnotice";a:5:{s:5:"title";s:18:"微信通知设置";s:3:"url";s:42:"./index.php?c=profile&a=tplnotice&do=list&";s:15:"permission_name";s:25:"profile_setting_tplnotice";s:6:"active";s:4:"list";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"profile_setting_notify";a:5:{s:5:"title";s:18:"邮件通知参数";s:3:"url";s:39:"./index.php?c=profile&a=notify&do=mail&";s:15:"permission_name";s:22:"profile_setting_notify";s:6:"active";s:4:"mail";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:26:"profile_setting_uc_setting";a:5:{s:5:"title";s:14:"UC站点整合";s:3:"url";s:45:"./index.php?c=profile&a=common&do=uc_setting&";s:15:"permission_name";s:26:"profile_setting_uc_setting";s:6:"active";s:10:"uc_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:27:"profile_setting_upload_file";a:5:{s:5:"title";s:20:"上传JS接口文件";s:3:"url";s:46:"./index.php?c=profile&a=common&do=upload_file&";s:15:"permission_name";s:27:"profile_setting_upload_file";s:6:"active";s:11:"upload_file";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:15:"profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:12:"支付参数";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:15:"profile_payment";s:4:"icon";s:17:"wi wi-pay-setting";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:2:{s:19:"profile_payment_pay";a:4:{s:5:"title";s:12:"支付配置";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:19:"profile_payment_pay";s:6:"active";s:7:"payment";}s:22:"profile_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:42:"./index.php?c=profile&a=refund&do=display&";s:15:"permission_name";s:22:"profile_payment_refund";s:6:"active";s:6:"refund";}}}s:23:"profile_app_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:31:"profile_app_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:18:"webapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:18:"webapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:14:"webapp_rewrite";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:9:"伪静态";s:3:"url";s:31:"./index.php?c=webapp&a=rewrite&";s:15:"permission_name";s:14:"webapp_rewrite";s:4:"icon";s:13:"wi wi-rewrite";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:13;}s:5:"wxapp";a:8:{s:5:"title";s:15:"微信小程序";s:4:"icon";s:19:"wi wi-small-routine";s:9:"dimension";i:3;s:3:"url";s:38:"./index.php?c=wxapp&a=display&do=home&";s:7:"section";a:5:{s:14:"wxapp_entrance";a:3:{s:5:"title";s:15:"小程序入口";s:4:"menu";a:1:{s:20:"module_entrance_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:1;s:5:"title";s:12:"入口页面";s:3:"url";s:36:"./index.php?c=wxapp&a=entrance-link&";s:15:"permission_name";s:19:"wxapp_entrance_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}}s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:3:{s:5:"title";s:6:"粉丝";s:4:"menu";a:1:{s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:1;s:5:"title";s:6:"会员";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:15:"mc_wxapp_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}}s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}}s:13:"wxapp_profile";a:3:{s:5:"title";s:6:"配置";s:4:"menu";a:5:{s:33:"wxapp_profile_module_link_uniacid";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:1;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:33:"wxapp_profile_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:21:"wxapp_profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:1;s:5:"title";s:12:"支付参数";s:3:"url";s:30:"./index.php?c=wxapp&a=payment&";s:15:"permission_name";s:21:"wxapp_profile_payment";s:4:"icon";s:16:"wi wi-appsetting";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:17:"wxapp_payment_pay";a:4:{s:5:"title";s:12:"支付参数";s:3:"url";s:41:"./index.php?c=wxapp&a=payment&do=display&";s:15:"permission_name";s:17:"wxapp_payment_pay";s:6:"active";s:7:"payment";}s:20:"wxapp_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:40:"./index.php?c=wxapp&a=refund&do=display&";s:15:"permission_name";s:20:"wxapp_payment_refund";s:6:"active";s:6:"refund";}}}s:28:"wxapp_profile_front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";i:1;s:10:"is_display";i:1;s:5:"title";s:18:"上传微信审核";s:3:"url";s:37:"./index.php?c=wxapp&a=front-download&";s:15:"permission_name";s:28:"wxapp_profile_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:23:"wxapp_profile_domainset";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:1;s:5:"title";s:12:"域名设置";s:3:"url";s:32:"./index.php?c=wxapp&a=domainset&";s:15:"permission_name";s:23:"wxapp_profile_domainset";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:22:"profile_setting_remote";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:1;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:22:"profile_setting_remote";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}}s:10:"statistics";a:3:{s:5:"title";s:6:"统计";s:4:"menu";a:1:{s:16:"statistics_visit";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:1;s:5:"title";s:12:"访问统计";s:3:"url";s:33:"./index.php?c=wxapp&a=statistics&";s:15:"permission_name";s:22:"statistics_visit_wxapp";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:3:{s:20:"statistics_visit_app";a:4:{s:5:"title";s:24:"app端访问统计信息";s:3:"url";s:42:"./index.php?c=statistics&a=app&do=display&";s:15:"permission_name";s:20:"statistics_visit_app";s:6:"active";s:3:"app";}s:21:"statistics_visit_site";a:4:{s:5:"title";s:24:"所有用户访问统计";s:3:"url";s:51:"./index.php?c=statistics&a=site&do=current_account&";s:15:"permission_name";s:21:"statistics_visit_site";s:6:"active";s:4:"site";}s:24:"statistics_visit_setting";a:4:{s:5:"title";s:18:"访问统计设置";s:3:"url";s:46:"./index.php?c=statistics&a=setting&do=display&";s:15:"permission_name";s:24:"statistics_visit_setting";s:6:"active";s:7:"setting";}}}}s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:14;}s:6:"webapp";a:7:{s:5:"title";s:2:"PC";s:4:"icon";s:8:"wi wi-pc";s:3:"url";s:39:"./index.php?c=webapp&a=home&do=display&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:15;}s:8:"phoneapp";a:7:{s:5:"title";s:3:"APP";s:4:"icon";s:18:"wi wi-white-collar";s:3:"url";s:41:"./index.php?c=phoneapp&a=display&do=home&";s:7:"section";a:2:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:16:"phoneapp_profile";a:4:{s:5:"title";s:6:"配置";s:4:"menu";a:2:{s:28:"profile_phoneapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:6;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:28:"profile_phoneapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:14:"front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";b:1;s:10:"is_display";i:1;s:5:"title";s:9:"下载APP";s:3:"url";s:40:"./index.php?c=phoneapp&a=front-download&";s:15:"permission_name";s:23:"phoneapp_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";b:1;s:18:"permission_display";a:1:{i:0;i:6;}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:16;}s:5:"xzapp";a:7:{s:5:"title";s:9:"熊掌号";s:4:"icon";s:11:"wi wi-xzapp";s:3:"url";s:38:"./index.php?c=xzapp&a=home&do=display&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:17;}s:6:"aliapp";a:7:{s:5:"title";s:18:"支付宝小程序";s:4:"icon";s:12:"wi wi-aliapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:18;}s:8:"baiduapp";a:7:{s:5:"title";s:15:"百度小程序";s:4:"icon";s:14:"wi wi-baiduapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:19;}s:10:"toutiaoapp";a:7:{s:5:"title";s:15:"头条小程序";s:4:"icon";s:16:"wi wi-toutiaoapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:20;}s:9:"appmarket";a:9:{s:5:"title";s:6:"市场";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:14:"http://s.w7.cc";s:7:"section";a:0:{}s:5:"blank";b:1;s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:21;}s:9:"workorder";a:9:{s:5:"title";s:6:"工单";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:44:"./index.php?c=system&a=workorder&do=display&";s:7:"section";a:1:{s:9:"workorder";a:2:{s:5:"title";s:12:"工单系统";s:4:"menu";a:1:{s:16:"system_workorder";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"工单系统";s:3:"url";s:44:"./index.php?c=system&a=workorder&do=display&";s:15:"permission_name";s:16:"system_workorder";s:4:"icon";s:17:"wi wi-system-work";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:22;}s:4:"help";a:7:{s:5:"title";s:6:"帮助";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:29:"./index.php?c=help&a=display&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:23;}s:11:"custom_help";a:7:{s:5:"title";s:12:"本站帮助";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:39:"./index.php?c=help&a=display&do=custom&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:24;}}');

-- ----------------------------
-- Table structure for `mmwl_core_cron`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_cron`;
CREATE TABLE `mmwl_core_cron` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cloudid` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `lastruntime` int(10) unsigned NOT NULL,
  `nextruntime` int(10) unsigned NOT NULL,
  `weekday` tinyint(3) NOT NULL,
  `day` tinyint(3) NOT NULL,
  `hour` tinyint(3) NOT NULL,
  `minute` varchar(255) NOT NULL,
  `extra` varchar(5000) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `createtime` (`createtime`),
  KEY `nextruntime` (`nextruntime`),
  KEY `uniacid` (`uniacid`),
  KEY `cloudid` (`cloudid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_cron_record`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_cron_record`;
CREATE TABLE `mmwl_core_cron_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `note` varchar(500) NOT NULL,
  `tag` varchar(5000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `tid` (`tid`),
  KEY `module` (`module`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_job`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_job`;
CREATE TABLE `mmwl_core_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `payload` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `title` varchar(22) NOT NULL,
  `handled` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_menu`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_menu`;
CREATE TABLE `mmwl_core_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL,
  `title` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `append_title` varchar(30) NOT NULL,
  `append_url` varchar(255) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `type` varchar(15) NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_system` tinyint(3) unsigned NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  `group_name` varchar(30) NOT NULL,
  `icon` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_menu_shortcut`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_menu_shortcut`;
CREATE TABLE `mmwl_core_menu_shortcut` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `position` varchar(100) NOT NULL,
  `updatetime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_paylog`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_paylog`;
CREATE TABLE `mmwl_core_paylog` (
  `plid` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `acid` int(10) NOT NULL,
  `openid` varchar(40) NOT NULL,
  `uniontid` varchar(64) NOT NULL,
  `tid` varchar(128) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `module` varchar(50) NOT NULL,
  `tag` varchar(2000) NOT NULL,
  `is_usecard` tinyint(3) unsigned NOT NULL,
  `card_type` tinyint(3) unsigned NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `card_fee` decimal(10,2) unsigned NOT NULL,
  `encrypt_code` varchar(100) NOT NULL,
  `is_wish` tinyint(1) NOT NULL,
  PRIMARY KEY (`plid`),
  KEY `idx_openid` (`openid`),
  KEY `idx_tid` (`tid`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `uniontid` (`uniontid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_performance`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_performance`;
CREATE TABLE `mmwl_core_performance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `runtime` varchar(10) NOT NULL,
  `runurl` varchar(512) NOT NULL,
  `runsql` varchar(512) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_core_performance 
-- ----------------------------
INSERT INTO `mmwl_core_performance` VALUES ('1', '2', '7', 'http://127.0.0.35/web/index.php?c=account&a=display&do=switch&uniacid=2&type=4', 'SELECT * FROM `mmwl_users_lastuse`  WHERE `uid` = :__uid_16 AND `type` = :__type_17', '1567158638');
INSERT INTO `mmwl_core_performance` VALUES ('2', '2', '10', 'http://127.0.0.35/web/index.php?c=utility&a=visit&do=showjs&type=platform', 'SELECT * FROM `mmwl_stat_visit`  WHERE `date` = :__date_5 AND `module` = :__module_6 AND `uniacid` = :__uniacid_7 AND `type` = :__type_8', '1567158641');

-- ----------------------------
-- Table structure for `mmwl_core_queue`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_queue`;
CREATE TABLE `mmwl_core_queue` (
  `qid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `message` varchar(2000) NOT NULL,
  `params` varchar(1000) NOT NULL,
  `keyword` varchar(1000) NOT NULL,
  `response` varchar(2000) NOT NULL,
  `module` varchar(50) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`qid`),
  KEY `uniacid` (`uniacid`,`acid`),
  KEY `module` (`module`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_refundlog`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_refundlog`;
CREATE TABLE `mmwl_core_refundlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `refund_uniontid` varchar(64) NOT NULL,
  `reason` varchar(80) NOT NULL,
  `uniontid` varchar(64) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` int(2) NOT NULL,
  `is_wish` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `refund_uniontid` (`refund_uniontid`),
  KEY `uniontid` (`uniontid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_resource`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_resource`;
CREATE TABLE `mmwl_core_resource` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `media_id` varchar(100) NOT NULL,
  `trunk` int(10) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `acid` (`uniacid`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_sendsms_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_sendsms_log`;
CREATE TABLE `mmwl_core_sendsms_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `result` varchar(255) NOT NULL,
  `createtime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_core_sessions`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_sessions`;
CREATE TABLE `mmwl_core_sessions` (
  `sid` char(32) NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `data` varchar(5000) NOT NULL,
  `expiretime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_core_sessions 
-- ----------------------------
INSERT INTO `mmwl_core_sessions` VALUES ('fe4a0d561b4534e1803d54e7ccc7d8d0', '2', '139.205.130.144', 'acid|s:1:"2";uniacid|i:2;token|a:1:{s:4:"tYFY";i:1569740716;}__code|s:32:"c78469509513cf2d4f026ac81d1dc039";', '1569744316');
INSERT INTO `mmwl_core_sessions` VALUES ('d797386fe3122e129b9ebd094a99edce', '2', '1.204.22.100', 'acid|s:1:"2";uniacid|i:2;token|a:1:{s:4:"QU3b";i:1569740773;}__code|s:32:"c78469509513cf2d4f026ac81d1dc039";', '1569744373');
INSERT INTO `mmwl_core_sessions` VALUES ('aeadd25ea3f58381992c4a0aa0421f7f', '2', '139.205.130.30', 'acid|s:1:"2";uniacid|i:2;token|a:4:{s:4:"BG2W";i:1570504623;s:4:"Grzr";i:1570504623;s:4:"fjkR";i:1570504635;s:4:"qgDi";i:1570504638;}__code|s:32:"c78469509513cf2d4f026ac81d1dc039";', '1570508239');
INSERT INTO `mmwl_core_sessions` VALUES ('51cd6e109c1a974c8326577987c69c76', '2', '221.202.113.234', 'acid|s:1:"2";uniacid|i:2;token|a:1:{s:4:"tbWd";i:1570504825;}__code|s:32:"c78469509513cf2d4f026ac81d1dc039";', '1570508425');
INSERT INTO `mmwl_core_sessions` VALUES ('6c0fe07dbacba1d5c7241a7f883cb8e8', '2', '101.132.177.30', 'acid|s:1:"2";uniacid|i:2;', '1570587727');
INSERT INTO `mmwl_core_sessions` VALUES ('1bd317f4da2f1884b32205244c5e5c26', '2', '47.100.51.203', 'acid|s:1:"2";uniacid|i:2;token|a:1:{s:4:"Drdb";i:1570585863;}', '1570589463');
INSERT INTO `mmwl_core_sessions` VALUES ('0ab067f9a44cb330e8f262c3b0f27940', '2', '139.205.131.234', 'acid|s:1:"2";uniacid|i:2;token|a:1:{s:4:"HSvv";i:1571189909;}__code|s:32:"c78469509513cf2d4f026ac81d1dc039";', '1571193509');
INSERT INTO `mmwl_core_sessions` VALUES ('3e123189c87e19d827f850f9c93d54f8', '2', '139.205.131.234', 'acid|s:1:"2";uniacid|i:2;token|a:1:{s:4:"Z0NE";i:1571275734;}__code|s:32:"c78469509513cf2d4f026ac81d1dc039";', '1571279334');

-- ----------------------------
-- Table structure for `mmwl_core_settings`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_core_settings`;
CREATE TABLE `mmwl_core_settings` (
  `key` varchar(200) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_core_settings 
-- ----------------------------
INSERT INTO `mmwl_core_settings` VALUES ('copyright', 'a:3:{s:6:"slides";a:3:{i:0;s:58:"https://img.alicdn.com/tps/TB1pfG4IFXXXXc6XXXXXXXXXXXX.jpg";i:1;s:58:"https://img.alicdn.com/tps/TB1sXGYIFXXXXc5XpXXXXXXXXXX.jpg";i:2;s:58:"https://img.alicdn.com/tps/TB1h9xxIFXXXXbKXXXXXXXXXXXX.jpg";}s:14:"develop_status";i:1;s:8:"baidumap";a:2:{s:3:"lng";N;s:3:"lat";N;}}');
INSERT INTO `mmwl_core_settings` VALUES ('authmode', 'i:1;');
INSERT INTO `mmwl_core_settings` VALUES ('close', 'a:2:{s:6:"status";s:1:"0";s:6:"reason";s:0:"";}');
INSERT INTO `mmwl_core_settings` VALUES ('register', 'a:4:{s:4:"open";i:1;s:6:"verify";i:0;s:4:"code";i:1;s:7:"groupid";i:1;}');
INSERT INTO `mmwl_core_settings` VALUES ('site', 'a:3:{s:3:"key";i:189924;s:5:"token";s:32:"aa6f621fec30841328af01fcafb1f2cf";s:3:"url";s:16:"http://mwzxw.top";}');
INSERT INTO `mmwl_core_settings` VALUES ('cloudip', 'a:0:{}');
INSERT INTO `mmwl_core_settings` VALUES ('upload', 'a:4:{s:5:"image";a:5:{s:10:"extentions";a:4:{i:0;s:3:"gif";i:1;s:3:"jpg";i:2;s:4:"jpeg";i:3;s:3:"png";}s:5:"limit";i:5000;s:5:"thumb";i:1;s:5:"width";i:800;s:14:"zip_percentage";i:100;}s:9:"attachdir";s:10:"attachment";s:5:"audio";a:2:{s:10:"extentions";a:2:{i:0;s:3:"mp3";i:1;s:3:"mp4";}s:5:"limit";d:8192;}s:16:"attachment_limit";i:5000;}');

-- ----------------------------
-- Table structure for `mmwl_coupon_location`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_coupon_location`;
CREATE TABLE `mmwl_coupon_location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `sid` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `category` varchar(255) NOT NULL,
  `province` varchar(15) NOT NULL,
  `city` varchar(15) NOT NULL,
  `district` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `longitude` varchar(15) NOT NULL,
  `latitude` varchar(15) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `photo_list` varchar(10000) NOT NULL,
  `avg_price` int(10) unsigned NOT NULL,
  `open_time` varchar(50) NOT NULL,
  `recommend` varchar(255) NOT NULL,
  `special` varchar(255) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  `offset_type` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_cover_reply`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_cover_reply`;
CREATE TABLE `mmwl_cover_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `module` varchar(30) NOT NULL,
  `do` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_cover_reply 
-- ----------------------------
INSERT INTO `mmwl_cover_reply` VALUES ('1', '1', '0', '7', 'mc', '', '进入个人中心', '', '', './index.php?c=mc&a=home&i=1');
INSERT INTO `mmwl_cover_reply` VALUES ('2', '1', '1', '8', 'site', '', '进入首页', '', '', './index.php?c=home&i=1&t=1');

-- ----------------------------
-- Table structure for `mmwl_custom_reply`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_custom_reply`;
CREATE TABLE `mmwl_custom_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `start1` int(10) NOT NULL,
  `end1` int(10) NOT NULL,
  `start2` int(10) NOT NULL,
  `end2` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_gpb_action`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_action`;
CREATE TABLE `mmwl_gpb_action` (
  `at_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团购活动主键',
  `at_name` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '团购活动名称',
  `at_brief` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '活动简介',
  `at_start_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '活动开始时间',
  `at_end_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '活动结束时间',
  `at_start_send_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '预计提货/配送开始时间(弃)',
  `at_end_send_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '预计提货/配送结束时间(弃)',
  `at_key_phone` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '活动负责人电话',
  `at_is_index_show` tinyint(1) DEFAULT '1' COMMENT '是否首页显示，-1不显示，1显',
  `at_is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除，-1删，1不删',
  `at_order` int(10) DEFAULT NULL COMMENT '排序',
  `at_see_num` int(7) unsigned DEFAULT '0' COMMENT '活动浏览量',
  `at_people_num` int(7) unsigned DEFAULT '0' COMMENT '活动参与人数',
  `openid` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '暂没用',
  `weid` int(11) DEFAULT NULL,
  `at_is_limit` tinyint(1) DEFAULT '-1' COMMENT '限制小区 1不限制 -1限制',
  `at_add_time` char(15) COLLATE utf8_bin DEFAULT NULL,
  `at_update_time` char(15) COLLATE utf8_bin DEFAULT NULL,
  `at_limit_num` int(7) DEFAULT NULL COMMENT '限制出售数量',
  `at_is_seckill` tinyint(1) DEFAULT '-1' COMMENT '-1不是1是',
  `at_arrival_time` smallint(3) DEFAULT NULL COMMENT '预计到达时间(天)',
  `at_arrival_time_text` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '预计到达时间(文本)',
  `at_is_head_open` tinyint(1) DEFAULT '-1' COMMENT '团长自动开启商品',
  PRIMARY KEY (`at_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_action_goods`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_action_goods`;
CREATE TABLE `mmwl_gpb_action_goods` (
  `gcg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品活动关系表',
  `gcg_at_id` int(11) NOT NULL COMMENT '活动表',
  `gcg_g_id` int(11) NOT NULL COMMENT '商品表',
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`gcg_id`,`gcg_at_id`,`gcg_g_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_action_village`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_action_village`;
CREATE TABLE `mmwl_gpb_action_village` (
  `gav_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动小区关系',
  `gav_ac_id` int(11) NOT NULL COMMENT '活动',
  `gav_v_id` int(11) NOT NULL COMMENT '小区',
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`gav_id`,`gav_ac_id`,`gav_v_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_activity_plugin_virtual_buy_list`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_activity_plugin_virtual_buy_list`;
CREATE TABLE `mmwl_gpb_activity_plugin_virtual_buy_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `form` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1来自虚拟用户 2 来自真实',
  `virtual_sale` smallint(6) NOT NULL DEFAULT '0' COMMENT '虚拟销量',
  `virtual_all_sale` smallint(6) NOT NULL DEFAULT '0' COMMENT '总的虚拟销量',
  `addtime` char(15) NOT NULL DEFAULT '0' COMMENT '虚拟记录添加时间',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `virtual_buytime` char(15) NOT NULL DEFAULT '0' COMMENT '虚拟购买记录',
  `virtual_uid` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟购买人id',
  `real_openid` char(50) NOT NULL DEFAULT '0' COMMENT '真实购买人openid',
  `weid` int(11) NOT NULL DEFAULT '0' COMMENT '模块',
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  KEY `virtual_uid` (`virtual_uid`),
  KEY `weid` (`weid`),
  KEY `real_openid` (`real_openid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_gpb_activity_plugin_virtual_users`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_activity_plugin_virtual_users`;
CREATE TABLE `mmwl_gpb_activity_plugin_virtual_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `head` text NOT NULL COMMENT '头像',
  `phone` varchar(255) NOT NULL COMMENT '电话',
  `name` varchar(255) NOT NULL COMMENT '昵称',
  `sex` int(2) DEFAULT '1' COMMENT '性别',
  `aid` int(11) NOT NULL COMMENT '对应商品id',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=500 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_gpb_application_header`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_application_header`;
CREATE TABLE `mmwl_gpb_application_header` (
  `ah_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `openid` char(50) COLLATE utf8_bin DEFAULT NULL,
  `ah_name` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '姓名（前台申请时）',
  `ah_phone` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '电话（前台申请时）',
  `ah_shop_name` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '店铺名（前台申请时）',
  `ah_address` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '具体社区地址',
  `ah_add_time` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `ah_status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `ah_result` tinyint(1) DEFAULT '1' COMMENT '申请结果-1拒绝，1未审批，通过-2',
  `ah_updatetime` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '处理时间',
  `ah_message` text COLLATE utf8_bin COMMENT '拒绝理由说明',
  `weid` int(11) DEFAULT NULL,
  `ah_wx_account` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '微信账号',
  `ah_lng` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '申请时定位经度',
  `ah_lat` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '申请时定位纬度',
  `form_id` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '发送模版消息id',
  `ah_code` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '推荐码',
  `ah_recommend_openid` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '推荐的openid',
  `ah_recommend_nickname` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '推荐人的昵称',
  `ah_head_house_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '团长地址某栋某单元门牌',
  PRIMARY KEY (`ah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_area`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_area`;
CREATE TABLE `mmwl_gpb_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_code` int(6) NOT NULL DEFAULT '0' COMMENT '地理位置编码',
  `name` varchar(36) NOT NULL,
  `level` varchar(12) NOT NULL COMMENT '级别',
  `pid` int(6) NOT NULL COMMENT '父级地理位置编码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3225 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_gpb_article`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_article`;
CREATE TABLE `mmwl_gpb_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章表',
  `weid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `title` text COLLATE utf8_bin,
  `body` text COLLATE utf8_bin,
  `sort` varchar(25) COLLATE utf8_bin DEFAULT '0',
  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `createtime` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '发布时间',
  `class` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `pid` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '1' COMMENT '1正常2删除',
  `addtime` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_article_class`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_article_class`;
CREATE TABLE `mmwl_gpb_article_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章分类表',
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '标题',
  `status` varchar(20) COLLATE utf8_bin DEFAULT '1' COMMENT '状态',
  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '时间',
  `push` varchar(255) COLLATE utf8_bin DEFAULT '1' COMMENT '是否推送 1.否 2. 是',
  `weid` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `pid` int(11) DEFAULT NULL COMMENT '父级',
  `is_del` tinyint(1) DEFAULT '1' COMMENT '1正常-1删除',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `addtime` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '创建时间',
  `type` int(5) DEFAULT '1' COMMENT '类型(显示位置,1个人中心页)',
  `icon` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '图标',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_article_class 
-- ----------------------------
INSERT INTO `mmwl_gpb_article_class` VALUES ('1', '常见问题', '-1', '', '1', '2', '0', '1', '1', '1550735868', '1', '/addons/group_buy/public/bg/qualification_certification.png');
INSERT INTO `mmwl_gpb_article_class` VALUES ('2', '资质规则', '-1', '', '1', '2', '0', '1', '2', '1550736410', '2', '/addons/group_buy/public/bg/frequently_asked_questions.png');

-- ----------------------------
-- Table structure for `mmwl_gpb_auto`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_auto`;
CREATE TABLE `mmwl_gpb_auto` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '提交信息表',
  `name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `version` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '版本号',
  `desc` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `time3` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '上传时间',
  `status` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '1' COMMENT '1.未提交审核 2.提交审核 3.审核失败 4.审核成功',
  `content` text COLLATE utf8_bin COMMENT '审核失败拒绝原因',
  `time1` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '提交审核时间',
  `time2` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '发布时间',
  `pid` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '审核id',
  `weid` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_back_money`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_back_money`;
CREATE TABLE `mmwl_gpb_back_money` (
  `gbm_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '退款主键',
  `gbm_money` decimal(10,2) DEFAULT NULL COMMENT '退款金额',
  `gbm_code` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '退款新的订单号',
  `gbm_go_code` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '原订单号',
  `gbm_go_money` decimal(10,2) DEFAULT NULL COMMENT '原订单金额',
  `gbm_status` tinyint(2) DEFAULT NULL COMMENT '状态：10待审核20已审核30拒绝',
  `gbm_content` text COLLATE utf8_bin COMMENT '理由退款',
  `gbm_comment` text COLLATE utf8_bin COMMENT '备注',
  `gbm_reason` text COLLATE utf8_bin COMMENT '拒绝原因',
  `gbm_form_id` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '模版id',
  `weid` int(11) DEFAULT NULL,
  `openid` char(30) COLLATE utf8_bin DEFAULT NULL,
  `gbm_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '申请时间',
  `gbm_oss_id` int(11) DEFAULT NULL COMMENT '商品快照ID',
  `gbm_type` tinyint(1) DEFAULT NULL COMMENT '退款类型1仅退款2退款退货',
  `gbm_goods_type` tinyint(1) DEFAULT NULL COMMENT '收货状态1未收货2已收货',
  `gbm_phone` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '退款联系人电话',
  `gbm_back_money_type` tinyint(1) DEFAULT '1' COMMENT '退款方式1微信退款2线下手动退款',
  `gbm_under_line_time` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '设置为线下退款的时间点',
  `gbm_update_time` char(15) COLLATE utf8_bin NOT NULL COMMENT '退款成功时间',
  PRIMARY KEY (`gbm_id`),
  KEY `gbm_go_code` (`gbm_go_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_banner`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_banner`;
CREATE TABLE `mmwl_gpb_banner` (
  `ban_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'banner id',
  `ban_name` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'banner名称',
  `ban_type` tinyint(1) DEFAULT NULL COMMENT 'banner类型 1首页顶部',
  `ban_href` char(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'banner跳转地址',
  `ban_param` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '附加参数，如id=1,',
  `ban_img` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT 'banner图片',
  `ban_is_show` tinyint(1) DEFAULT '1' COMMENT '显示1/隐藏-1',
  `ban_status` tinyint(1) DEFAULT '1' COMMENT '正常1/删除-1',
  `ban_order` int(10) DEFAULT NULL COMMENT '排序',
  `ban_add_time` char(20) COLLATE utf8_bin DEFAULT NULL,
  `ban_update_time` char(20) COLLATE utf8_bin DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  `ban_link_type` tinyint(1) DEFAULT NULL COMMENT '链接方式，1链接本站内容，2自定义单页，3外链',
  `ban_link_content` text COLLATE utf8_bin COMMENT '链接内容',
  PRIMARY KEY (`ban_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_bargain_action`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_bargain_action`;
CREATE TABLE `mmwl_gpb_bargain_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '砍价发起表',
  `goods_id` int(8) DEFAULT '0' COMMENT '商品信息',
  `now_price` double(10,2) DEFAULT '0.00' COMMENT '当前价格',
  `create_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '开始时间',
  `end_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '结束时间',
  `openid` varchar(255) COLLATE utf8_bin NOT NULL,
  `nickname` varchar(255) COLLATE utf8_bin NOT NULL,
  `head_img` varchar(255) COLLATE utf8_bin NOT NULL,
  `bargaion_price` double(10,2) DEFAULT '0.00' COMMENT '已砍',
  `status` int(2) DEFAULT '-1' COMMENT '状态码 -1.不可下单 2.正常下单 3.已下单 4.以取消',
  `order_id` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '订单id',
  `weid` int(8) DEFAULT '0',
  `action_goods` int(8) DEFAULT '0' COMMENT '砍价商品表id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_bargaion_goods`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_bargaion_goods`;
CREATE TABLE `mmwl_gpb_bargaion_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '砍价商品表',
  `g_id` int(11) DEFAULT '0' COMMENT '商品id',
  `weid` int(8) DEFAULT '0',
  `end_price` double(10,2) DEFAULT '0.00' COMMENT '低价',
  `status` int(2) DEFAULT '1' COMMENT '状态 1.代表能正常砍价',
  `type` int(2) DEFAULT '1' COMMENT '类型',
  `low_price` int(2) DEFAULT '1' COMMENT '是否显示低价 1.不显示 2.显示',
  `time_limit` int(2) DEFAULT '1' COMMENT '砍价时间(小时)',
  `total_time` int(5) DEFAULT '999' COMMENT '可砍价总次数',
  `each_time` int(5) DEFAULT '1' COMMENT '每个人可以砍的次数',
  `content` text COLLATE utf8_bin NOT NULL COMMENT '砍价详细',
  `place_order` int(2) DEFAULT '1' COMMENT '没有砍到低价是否能够下单 1.能 2.不能',
  `status_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '开始时间',
  `end_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '结束时间',
  `launches` int(8) DEFAULT '0' COMMENT '活动客发起次数',
  `own` int(2) DEFAULT '1' COMMENT '自己是否能砍价1.不能2.能',
  `price_cutting_times` int(2) DEFAULT '1' COMMENT '每个用户可发起活动次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_cart`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_cart`;
CREATE TABLE `mmwl_gpb_cart` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '购物车主键',
  `c_g_id` int(11) DEFAULT NULL COMMENT '关联商品主键',
  `openid` char(50) COLLATE utf8_bin DEFAULT NULL,
  `c_count` int(7) DEFAULT '1' COMMENT '数量',
  `c_unit_price` decimal(10,2) DEFAULT '0.00' COMMENT '添加记录时的单价【付款前先更新单价，再计算，再付款】',
  `c_money` decimal(10,2) DEFAULT '0.00' COMMENT '有付款回执后实收金额',
  `c_is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除了购物车,-1删，1没删',
  `weid` int(11) DEFAULT NULL,
  `c_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `c_status` tinyint(1) DEFAULT '1' COMMENT '状态1未付款2已付款',
  `c_at_id` int(11) DEFAULT NULL COMMENT '活动主键',
  `c_ggo_id` int(11) DEFAULT '-1' COMMENT '规格参数表id',
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_config`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_config`;
CREATE TABLE `mmwl_gpb_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置表',
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '中文配置名称',
  `value` text COLLATE utf8_bin COMMENT 'value',
  `type` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '类型(1支付配置2.消息配置3.团长设置4.首页设置放弃5.云存储设置放弃6.页面标题设置放弃7.订单设置8.分销商城设置9供应商设置10商品展示设置11.公众号设置)',
  `time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
  `weid` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT '模块id',
  `status` tinyint(1) DEFAULT NULL COMMENT '1使用-1未使用',
  `key` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '英文key值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=182 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_config 
-- ----------------------------
INSERT INTO `mmwl_gpb_config` VALUES ('112', '用户中心自定义diy系统数据', 'a:2:{s:5:"basic";a:5:{s:2:"id";s:7:"0000000";s:4:"name";s:14:"memberdiybasic";s:5:"title";s:12:"用户中心";s:11:"head_bg_img";s:61:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/topbg1.png";s:5:"order";a:5:{s:5:"icon1";s:66:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/needPayIcon.png";s:5:"icon2";s:61:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/undeli.png";s:5:"icon3";s:71:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/distributionIcon.png";s:5:"icon4";s:67:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/completeIcon.png";s:5:"icon5";s:65:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/refundIcon.png";}}s:4:"data";a:2:{i:0;a:5:{s:2:"id";s:7:"0000000";s:4:"name";s:14:"memberdiybasic";s:5:"title";s:12:"用户中心";s:11:"head_bg_img";s:61:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/topbg1.png";s:5:"order";a:5:{s:5:"icon1";s:66:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/needPayIcon.png";s:5:"icon2";s:61:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/undeli.png";s:5:"icon3";s:71:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/distributionIcon.png";s:5:"icon4";s:67:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/completeIcon.png";s:5:"icon5";s:65:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/refundIcon.png";}}i:1;a:3:{s:2:"id";s:14:"m1561703606318";s:4:"name";s:10:"membermenu";s:6:"params";a:2:{s:4:"type";s:1:"1";s:4:"data";a:13:{i:0;a:6:{s:2:"id";s:8:"00000001";s:3:"img";s:61:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/coupon.png";s:4:"type";s:3:"url";s:3:"key";s:6:"coupon";s:8:"url_name";s:15:"优惠卷大厅";s:3:"url";s:26:"/pages/template/couponHall";}i:1;a:6:{s:2:"id";s:14:"g1561704309626";s:3:"img";s:64:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/my_coupon.png";s:3:"url";s:22:"/pages/template/coupon";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:15:"我的优惠卷";}i:2;a:6:{s:2:"id";s:14:"g1561704323041";s:3:"img";s:66:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/select_head.png";s:3:"url";s:22:"/pages/group/groupList";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"选择团长";}i:3;a:6:{s:2:"id";s:14:"g1561704329201";s:3:"img";s:66:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/head_mannge.png";s:3:"url";s:24:"/pages/groupCenter/index";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"团长管理";}i:4;a:6:{s:2:"id";s:14:"g1561704543879";s:3:"img";s:66:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/head_mannge.png";s:3:"url";s:23:"/pages/group/groupApply";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"申请团长";}i:5;a:6:{s:2:"id";s:14:"g1561704558086";s:3:"img";s:64:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/head_info.png";s:3:"url";s:25:"/pages/personal/groupInfo";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"团长信息";}i:6;a:6:{s:2:"id";s:14:"g1561704564270";s:3:"img";s:70:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/fraction_center.png";s:3:"url";s:31:"/pages/integralMall/index/index";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"积分商城";}i:7;a:6:{s:2:"id";s:14:"g1561704576351";s:3:"img";s:74:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/distribution_center.png";s:3:"url";s:23:"/pages/commission/index";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"分销中心";}i:8;a:6:{s:2:"id";s:14:"g1561704588007";s:3:"img";s:69:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/apply_suppiler.png";s:3:"url";s:27:"/pages/personal/supplierInt";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:15:"供应商招募";}i:9;a:6:{s:2:"id";s:14:"g1561704598063";s:3:"img";s:81:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/frequently_asked_questions.png";s:3:"url";s:25:"/pages/personal/questions";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"常见问题";}i:10;a:6:{s:2:"id";s:14:"g1561704607175";s:3:"img";s:74:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/qualification_rules.png";s:3:"url";s:29:"/pages/personal/qualification";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"资质规则";}i:11;a:6:{s:2:"id";s:14:"g1561704642238";s:3:"img";s:66:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/link_custom.png";s:3:"url";s:12:"跳转客服";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"联系客服";}i:12;a:6:{s:2:"id";s:14:"g1561704653854";s:3:"img";s:69:"https://sqtg.scmmwl.com/addons/group_buy/public/bg/integral_check.png";s:3:"url";s:20:"/pages/checkIn/index";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"积分签到";}}}}}}', '25', '1569492087', '0', '1', 'member_diys_data_set_system');
INSERT INTO `mmwl_gpb_config` VALUES ('113', '后台左上角标题设置', '', '6', '1571292844', '2', '1', 'back_title_set');
INSERT INTO `mmwl_gpb_config` VALUES ('114', '后台左上角显示类型', '1', '6', '1571292844', '2', '1', 'back_set_type');
INSERT INTO `mmwl_gpb_config` VALUES ('115', '后台左上角图标设置', '', '6', '1571292844', '2', '1', 'back_icon_set');
INSERT INTO `mmwl_gpb_config` VALUES ('116', '客服电话', '', '1', '1571292844', '2', '1', 'sever_phone');
INSERT INTO `mmwl_gpb_config` VALUES ('117', '支付商户号', '', '1', '1569492094', '2', '1', 'pay_mchid');
INSERT INTO `mmwl_gpb_config` VALUES ('118', 'API密钥', '', '1', '1569492094', '2', '1', 'app_key');
INSERT INTO `mmwl_gpb_config` VALUES ('119', '证书路径', '', '1', '1569492095', '2', '1', 'cert_address');
INSERT INTO `mmwl_gpb_config` VALUES ('120', '密钥路径', '', '1', '1569492095', '2', '1', 'key_address');
INSERT INTO `mmwl_gpb_config` VALUES ('121', '团长排行榜', 'a:1:{i:0;a:2:{s:6:"status";i:10;s:4:"name";s:6:"周榜";}}', '1', '1571292844', '2', '1', 'team_rank');
INSERT INTO `mmwl_gpb_config` VALUES ('122', '首页分享出去的标题类型', '1', '1', '1571292844', '2', '1', 'index_share_title_type');
INSERT INTO `mmwl_gpb_config` VALUES ('123', '首页分享出去的自定义标题内容', '', '1', '1571292844', '2', '1', 'index_share_title');
INSERT INTO `mmwl_gpb_config` VALUES ('124', '首页分享出去的图片类型', '1', '1', '1571292844', '2', '1', 'index_share_img_type');
INSERT INTO `mmwl_gpb_config` VALUES ('125', '首页分享出去的自定义图片', '', '1', '1571292844', '2', '1', 'index_share_img');
INSERT INTO `mmwl_gpb_config` VALUES ('126', '是否显示首页分类页数据加载完的底部图片', '1', '1', '1571292844', '2', '1', 'data_end_show_img_open');
INSERT INTO `mmwl_gpb_config` VALUES ('127', '首页分类页数据加载完的底部图', '/addons/group_buy/public/bg/footer_nomore.png', '1', '1571292844', '2', '1', 'data_end_show_img');
INSERT INTO `mmwl_gpb_config` VALUES ('128', '加载未完成时的默认图片（大）', '/addons/group_buy/public/bg/tmp_big.png', '1', '1571292844', '2', '1', 'default_big_img');
INSERT INTO `mmwl_gpb_config` VALUES ('129', '加载未完成时的默认图片（小）', '/addons/group_buy/public/bg/tmp_small.png', '1', '1571292844', '2', '1', 'default_small_img');
INSERT INTO `mmwl_gpb_config` VALUES ('130', '个人中心是否显示积分商城', '1', '1', '1571292844', '2', '1', 'member_sroce_show');
INSERT INTO `mmwl_gpb_config` VALUES ('131', '个人中心是否显示分销商城', '1', '1', '1571292844', '2', '1', 'member_distribution_show');
INSERT INTO `mmwl_gpb_config` VALUES ('132', '自定义社区或小区名称', '社区', '1', '1571292844', '2', '1', 'diy_community_name');
INSERT INTO `mmwl_gpb_config` VALUES ('133', 'AppId', 'wxf301db523978065b', '1', '1571292844', '2', '1', 'appid');
INSERT INTO `mmwl_gpb_config` VALUES ('134', 'AppSecret', 'dc60eef94f136e9852154c6c90845c08', '1', '1571292844', '2', '1', 'appsecret');
INSERT INTO `mmwl_gpb_config` VALUES ('135', '支付成功通知模版id及内容', '', '2', '1569740830', '2', '1', 'sms_pay');
INSERT INTO `mmwl_gpb_config` VALUES ('136', '短信的key,serect,签名', '', '2', '1569740830', '2', '1', 'sms_data');
INSERT INTO `mmwl_gpb_config` VALUES ('137', '退款通知模版id及内容', '', '2', '1569740830', '2', '1', 'sms_refud');
INSERT INTO `mmwl_gpb_config` VALUES ('138', '短信接受管理员', '', '2', '1569740830', '2', '1', 'sms_admin');
INSERT INTO `mmwl_gpb_config` VALUES ('139', '申请团长通知模版id及内容', '', '2', '1569740830', '2', '1', 'sms_watir');
INSERT INTO `mmwl_gpb_config` VALUES ('140', '短信类型', '1', '2', '1569740830', '2', '1', 'sms_code');
INSERT INTO `mmwl_gpb_config` VALUES ('141', '是否启用短信', '1', '2', '1569740830', '2', '1', 'sms_type');
INSERT INTO `mmwl_gpb_config` VALUES ('142', '提现通知模版id及内容', '', '2', '1569740830', '2', '1', 'sms_get_cash');
INSERT INTO `mmwl_gpb_config` VALUES ('143', '打印机设置', '', '8', '1569740831', '2', '1', 'print_set');
INSERT INTO `mmwl_gpb_config` VALUES ('144', '首页海报分享背景图', '/addons/group_buy/public/bg/index_playbill_bg.jpg', '11', '1570504871', '2', '1', 'index_playbill_img');
INSERT INTO `mmwl_gpb_config` VALUES ('145', '首页海报分享商品', '0', '11', '1570504871', '2', '1', 'index_playbill_goods');
INSERT INTO `mmwl_gpb_config` VALUES ('146', '是否开启版权设置', '2', '11', '1570504874', '2', '1', 'copyright_open');
INSERT INTO `mmwl_gpb_config` VALUES ('147', '版权图标文字排列风格', '', '11', '1570504874', '2', '1', 'copyright_style');
INSERT INTO `mmwl_gpb_config` VALUES ('148', '版权文字设置', '', '11', '1570504874', '2', '1', 'copyright_text');
INSERT INTO `mmwl_gpb_config` VALUES ('149', '版权图标上传', '', '11', '1570504874', '2', '1', 'copyright_icon');
INSERT INTO `mmwl_gpb_config` VALUES ('150', '是否开启版本号显示', '1', '11', '1570504874', '2', '1', 'version_number_open');
INSERT INTO `mmwl_gpb_config` VALUES ('151', '详情页活动及价格背景', '', '10', '1570504896', '2', '1', 'goods_info_action_price_bg');
INSERT INTO `mmwl_gpb_config` VALUES ('152', '是否开启首图视频显示', '1', '10', '1570504896', '2', '1', 'is_open_goods_video');
INSERT INTO `mmwl_gpb_config` VALUES ('153', '详情页服务说明描述', '', '10', '1570504896', '2', '1', 'goods_info_sever_des');
INSERT INTO `mmwl_gpb_config` VALUES ('154', '商品分类页是否开启搜索', '', '10', '1570504896', '2', '1', 'goods_cate_open_search');
INSERT INTO `mmwl_gpb_config` VALUES ('155', '商品详情页是否显示邻居购买', '1', '10', '1570504896', '2', '1', 'goods_info_open_near');
INSERT INTO `mmwl_gpb_config` VALUES ('156', '商品详情页微信分享的背景图', '/addons/group_buy/public/bg/goods_info_share_bg.jpg', '10', '1570504896', '2', '1', 'goods_info_share_bg');
INSERT INTO `mmwl_gpb_config` VALUES ('157', '商品详情页海报分享的背景图', '/addons/group_buy/public/bg/goods_info_playbill_bg.jpg', '10', '1570504896', '2', '1', 'goods_info_playbill_bg');
INSERT INTO `mmwl_gpb_config` VALUES ('158', '商品详情页秒杀图标', '/addons/group_buy/public/bg/seckill_goods_info_icon.png', '10', '1570504896', '2', '1', 'goods_info_seckill_icon');
INSERT INTO `mmwl_gpb_config` VALUES ('159', '商品详情页秒杀价格背景色', '#fde529', '10', '1570504896', '2', '1', 'goods_info_seckill_price_bg');
INSERT INTO `mmwl_gpb_config` VALUES ('160', '商品分类页面显示内容', '1', '10', '1570504896', '2', '1', 'goods_cate_show_type');
INSERT INTO `mmwl_gpb_config` VALUES ('161', '商品详情页面能否点击进入购买记录页', '1', '10', '1570504896', '2', '1', 'open_see_buypeople_info');
INSERT INTO `mmwl_gpb_config` VALUES ('162', '商品分享样式', '1', '10', '1570504896', '2', '1', 'open_commodity');
INSERT INTO `mmwl_gpb_config` VALUES ('163', '佣金比例设置', '', '3', '1570504917', '2', '1', 'commission_ratio');
INSERT INTO `mmwl_gpb_config` VALUES ('164', '团长提现门槛设置', '0', '3', '1570504917', '2', '1', 'get_cash_limit_money');
INSERT INTO `mmwl_gpb_config` VALUES ('165', '申请团长时申请条款', '', '3', '1570504917', '2', '1', 'apply_head_text');
INSERT INTO `mmwl_gpb_config` VALUES ('166', '引导申请广告图', '', '3', '1570504917', '2', '1', 'apply_head_img');
INSERT INTO `mmwl_gpb_config` VALUES ('167', '选择上次购物团长弹窗开关', '', '3', '1570504917', '2', '1', 'last_head_notice');
INSERT INTO `mmwl_gpb_config` VALUES ('168', '个人中心页团长信息背景图', '/addons/group_buy/public/bg/group_info_img.png', '3', '1570504917', '2', '1', 'group_info_bg_img');
INSERT INTO `mmwl_gpb_config` VALUES ('169', '选择团长页显示团长的距离', '0', '3', '1570504917', '2', '1', 'select_head_distance');
INSERT INTO `mmwl_gpb_config` VALUES ('170', '选择团长页显示团长的数量', '0', '3', '1570504917', '2', '1', 'select_head_num');
INSERT INTO `mmwl_gpb_config` VALUES ('171', '申请供应商时申请条款', '', '9', '1570504926', '2', '1', 'apply_supplier_text');
INSERT INTO `mmwl_gpb_config` VALUES ('172', '引导申请广告图', '', '9', '1570504926', '2', '1', 'apply_supplier_img');
INSERT INTO `mmwl_gpb_config` VALUES ('173', '是否审核添加商品', '1', '9', '1570504926', '2', '1', 'open_supplier_add_goods');
INSERT INTO `mmwl_gpb_config` VALUES ('174', '是否审核编辑商品', '1', '9', '1570504926', '2', '1', 'open_supplier_edit_goods');
INSERT INTO `mmwl_gpb_config` VALUES ('175', '快递鸟商户ID', '', '12', '1570505005', '2', '1', 'express_bird_id');
INSERT INTO `mmwl_gpb_config` VALUES ('176', '快递鸟API KEY', '', '12', '1570505005', '2', '1', 'express_bird_key');
INSERT INTO `mmwl_gpb_config` VALUES ('177', '是否开启快递', '2', '12', '1570505005', '2', '1', 'is_open_express');
INSERT INTO `mmwl_gpb_config` VALUES ('178', '是否开启自提', '1', '12', '1570505005', '2', '1', 'mention_id');
INSERT INTO `mmwl_gpb_config` VALUES ('179', '自提方式名称', '自提', '12', '1570505005', '2', '1', 'delivery_self');
INSERT INTO `mmwl_gpb_config` VALUES ('180', '团长送货方式名称', '团长送货', '12', '1570505005', '2', '1', 'delivery_chief');
INSERT INTO `mmwl_gpb_config` VALUES ('181', '快递方式名称', '快递', '12', '1570505005', '2', '1', 'delivery_express');

-- ----------------------------
-- Table structure for `mmwl_gpb_consumption_info`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_consumption_info`;
CREATE TABLE `mmwl_gpb_consumption_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员消费明细',
  `uid` int(8) DEFAULT '0',
  `money` double(10,2) DEFAULT '0.00' COMMENT '消费金额',
  `c_i_type` int(2) DEFAULT '1' COMMENT '消费金额状态1.微信支付2.余额支付3.退款4.返佣',
  `time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '时间',
  `content` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '消费简短信息',
  `order_id` int(8) DEFAULT '0' COMMENT '订单id',
  `status` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_distribution_cash_money`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distribution_cash_money`;
CREATE TABLE `mmwl_gpb_distribution_cash_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `weid` int(11) NOT NULL,
  `money` double(10,2) NOT NULL DEFAULT '0.00',
  `check_state` int(2) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_bin,
  `admin_id` int(11) DEFAULT NULL,
  `cash_sn` varchar(32) COLLATE utf8_bin NOT NULL,
  `wx_sn` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `charge_money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `from_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'fromid',
  `cash_type` int(3) DEFAULT '1' COMMENT '提现类型1提现到零钱2.支付宝3.网银',
  `case_value` text COLLATE utf8_bin NOT NULL COMMENT '提现到支付宝和提现到网银的数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_distribution_group`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distribution_group`;
CREATE TABLE `mmwl_gpb_distribution_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leader_id` int(11) DEFAULT NULL,
  `lv1` text COLLATE utf8_bin NOT NULL,
  `lv2` text COLLATE utf8_bin NOT NULL,
  `lv3` text COLLATE utf8_bin NOT NULL,
  `weid` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_distribution_group_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distribution_group_log`;
CREATE TABLE `mmwl_gpb_distribution_group_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分销下级日志',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `pid` int(11) NOT NULL COMMENT '直属父级id',
  `weid` int(11) NOT NULL COMMENT '模块id',
  `is_dis` int(1) NOT NULL DEFAULT '0' COMMENT '是否是分销商',
  `dis_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_distribution_list`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distribution_list`;
CREATE TABLE `mmwl_gpb_distribution_list` (
  `dl_id` int(11) NOT NULL AUTO_INCREMENT,
  `dl_shop_name` char(50) COLLATE utf8_bin DEFAULT NULL,
  `dl_shop_address` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `dl_dr_id` int(11) DEFAULT NULL,
  `dl_add_time` char(15) COLLATE utf8_bin DEFAULT NULL,
  `dl_update_time` char(15) COLLATE utf8_bin DEFAULT NULL,
  `dl_status` tinyint(3) DEFAULT '10',
  `dl_send_time` char(15) COLLATE utf8_bin DEFAULT NULL,
  `dl_goods_num` smallint(4) DEFAULT NULL,
  `dl_is_del` tinyint(1) DEFAULT '1',
  `dl_goods` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  `dl_code` char(50) COLLATE utf8_bin DEFAULT NULL,
  `dl_go_code` char(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`dl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_distribution_list_order`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distribution_list_order`;
CREATE TABLE `mmwl_gpb_distribution_list_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `l_id` int(11) NOT NULL COMMENT '清单id',
  `go_id` int(11) NOT NULL COMMENT '订单id',
  `go_code` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '订单code',
  `weid` int(11) NOT NULL,
  PRIMARY KEY (`id`,`l_id`,`go_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_distribution_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distribution_log`;
CREATE TABLE `mmwl_gpb_distribution_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `dg_id` varchar(11) COLLATE utf8_bin NOT NULL,
  `order_sn` varchar(255) COLLATE utf8_bin NOT NULL,
  `all_cost` double(10,2) NOT NULL DEFAULT '0.00',
  `openid` varchar(32) COLLATE utf8_bin NOT NULL,
  `weid` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_distribution_menu`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distribution_menu`;
CREATE TABLE `mmwl_gpb_distribution_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分销菜单',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `title` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '菜单名称',
  `long_title` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '长标题',
  `url` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '跳转链接',
  `deep` int(2) NOT NULL DEFAULT '1' COMMENT '深度',
  `top_do` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '上级操作名',
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `icon` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '菜单图标',
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_distribution_menu 
-- ----------------------------
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('1', '0', '分销配置', '', 'config', '1', '', '15', 'icon-setting', '00000000000', '00000000000', '1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('2', '0', '分销中心', '', 'User', '1', '', '10', 'icon-user', '00000000000', '00000000000', '1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('3', '1', '基本设置', '分销设置', 'config_state', '2', 'config', '0', '', '00000000000', '00000000000', '1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('4', '1', '佣金设置', '分销设置', 'config_money', '2', 'config', '0', '', '00000000000', '00000000000', '1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('5', '0', '首页', '系统首页', 'home', '1', '', '0', 'icon-home', '00000000000', '00000000000', '-1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('6', '1', '审核设置', '分销设置', 'config_exa', '2', 'config', '0', '', '00000000000', '00000000000', '1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('7', '1', '推荐奖设置', '分销设置', 'config_commoned', '2', 'config', '0', '', '00000000000', '00000000000', '1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('8', '2', '提现审核', '分销设置', 'config_exa_list', '2', 'User', '10', '', '00000000000', '00000000000', '1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('9', '2', '团队列表', '', 'UserList', '2', 'User', '0', '', '00000000000', '00000000000', '1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('10', '2', '审核列表', '', 'exalist', '2', 'User', '0', '', '00000000000', '00000000000', '1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('11', '1', '提现设置', '', 'config_cash', '2', 'config', '100', '', '00000000000', '00000000000', '1');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('12', '0', '专题管理', '专题管理', 'index', '1', 'index', '0', '', '00000000000', '00000000000', '2');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('13', '0', '会场管理', '会场管理', 'room', '1', 'room', '0', '', '00000000000', '00000000000', '2');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('14', '0', '商品管理', '商品管理', 'goods', '1', 'goods', '0', '', '00000000000', '00000000000', '2');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('15', '0', '分类管理', '分类管理', 'category', '1', 'category', '0', '', '00000000000', '00000000000', '2');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('16', '0', '广告管理', '幻灯片管理', 'adv', '1', 'adv', '0', '', '00000000000', '00000000000', '2');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('17', '0', '设置', '设置', 'calendar', '1', 'calendar', '0', '', '00000000000', '00000000000', '2');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('18', '17', '任务设置', '任务设置', 'calendar', '2', 'calendar', '0', '', '00000000000', '00000000000', '2');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('19', '17', '入口设置', '入口设置', 'cover', '2', 'cover', '0', '', '00000000000', '00000000000', '2');
INSERT INTO `mmwl_gpb_distribution_menu` VALUES ('20', '1', '申请页配置', '分销设置', 'config_put', '2', 'config', '0', '', '00000000000', '00000000000', '1');

-- ----------------------------
-- Table structure for `mmwl_gpb_distribution_money`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distribution_money`;
CREATE TABLE `mmwl_gpb_distribution_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分销用户',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `frize_money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结资金',
  `used_mondey` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现资金',
  `cash_money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现中资金',
  `check_state` int(1) NOT NULL DEFAULT '1' COMMENT '审核状态,1通过，-1不通过，0待审核',
  `comment` text COLLATE utf8_bin COMMENT '不通过原因',
  `up_comment` text COLLATE utf8_bin COMMENT '提交审核参数',
  `weid` int(11) NOT NULL,
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(1) NOT NULL,
  `qr_code` text COLLATE utf8_bin COMMENT '二维码',
  `code_num` char(10) COLLATE utf8_bin NOT NULL COMMENT '推广码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_distribution_money_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distribution_money_log`;
CREATE TABLE `mmwl_gpb_distribution_money_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户分销佣金变动日志',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `info` text COLLATE utf8_bin COMMENT '操作信息',
  `money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动资金数额',
  `weid` int(11) NOT NULL COMMENT '模块id',
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(2) NOT NULL DEFAULT '1',
  `type` int(2) NOT NULL DEFAULT '1' COMMENT '类型，1增加，2减少，3冻结，4体现',
  `recharge` int(3) DEFAULT '1' COMMENT '入口 充值有用',
  `withdrawal` int(2) DEFAULT '1' COMMENT '充值拥挤是否提现1未提现2提现了',
  `recharge_id` int(8) DEFAULT '0' COMMENT '充值订单id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_distribution_route`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distribution_route`;
CREATE TABLE `mmwl_gpb_distribution_route` (
  `dr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '配送路线表主键',
  `dr_name` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '配送路线名称',
  `dr_people` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '配送人名称',
  `dr_phone` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '配送人电话',
  `dr_order` int(11) DEFAULT '1' COMMENT '排序',
  `dr_is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除 1不 -1是',
  `dr_num` smallint(4) DEFAULT NULL COMMENT '配送总的店铺数量',
  `weid` int(11) DEFAULT NULL,
  `dr_add_time` char(15) COLLATE utf8_bin DEFAULT NULL,
  `dr_update_time` char(15) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`dr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_distribution_route 
-- ----------------------------
INSERT INTO `mmwl_gpb_distribution_route` VALUES ('-1', '系统默认路线', '系统默认配送员', '', '1', '1', '0', '0', '', '');

-- ----------------------------
-- Table structure for `mmwl_gpb_distrution_commond_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_distrution_commond_log`;
CREATE TABLE `mmwl_gpb_distrution_commond_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '推荐奖领取日志',
  `uid` int(11) NOT NULL COMMENT '被推荐用户id',
  `pid` int(11) NOT NULL COMMENT '推荐用户id',
  `num` int(11) NOT NULL COMMENT '用户完成交易次数',
  `all_money` double(10,2) NOT NULL COMMENT '完成交易总金额',
  `commoned_times` int(11) NOT NULL COMMENT '当前被推荐人为本轮第N人',
  `is_over` int(11) NOT NULL COMMENT '是否已结算',
  `now_times` int(11) NOT NULL COMMENT '当前是第N轮',
  `weid` int(11) NOT NULL,
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_diy_page`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_diy_page`;
CREATE TABLE `mmwl_gpb_diy_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(5) unsigned NOT NULL,
  `content` longtext COLLATE utf8_bin COMMENT '内容',
  `createtime` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `tempid` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '模板id',
  `status` int(2) DEFAULT '1' COMMENT '状态',
  `system` int(2) DEFAULT '1' COMMENT '是否是系统模板(系统模板禁止删除)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_diy_page 
-- ----------------------------
INSERT INTO `mmwl_gpb_diy_page` VALUES ('4', '0', 'a:2:{s:4:"data";a:9:{i:0;a:3:{s:2:"id";s:14:"m1548983827233";s:4:"name";s:4:"head";s:6:"params";a:11:{s:11:"head_module";s:1:"3";s:7:"content";s:0:"";s:11:"showAddress";s:1:"0";s:9:"rightTpye";s:1:"1";s:7:"incolor";s:7:"#eeeeee";s:12:"border_color";s:7:"#eeeeee";s:7:"bgcolor";s:7:"#ffffff";s:4:"text";s:12:"搜索商品";s:10:"text_color";s:7:"#cccccc";s:13:"border_radius";s:2:"12";s:12:"search_width";s:2:"76";}}i:1;a:3:{s:2:"id";s:14:"m1548983995047";s:4:"name";s:5:"slide";s:6:"params";a:14:{s:8:"ischange";s:1:"0";s:10:"changetime";s:1:"3";s:10:"changelast";s:3:"500";s:10:"pointcolor";s:7:"#dddddd";s:8:"actcolor";s:7:"#22c397";s:9:"showpoint";s:1:"0";s:6:"height";s:3:"150";s:4:"data";a:3:{i:0;a:5:{s:2:"id";s:8:"00000001";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/supplier";s:8:"url_name";s:18:"申请供应商页";s:3:"img";s:62:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/banner3.png";}i:1;a:5:{s:2:"id";s:14:"g1548984006208";s:4:"type";s:3:"url";s:3:"url";s:23:"/pages/group/groupApply";s:8:"url_name";s:15:"申请团长页";s:3:"img";s:62:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/banner1.png";}i:2;a:5:{s:2:"id";s:14:"g1555306830375";s:4:"type";s:3:"url";s:3:"url";s:0:"";s:8:"url_name";s:0:"";s:3:"img";s:62:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/banner2.png";}}s:6:"radius";s:2:"10";s:10:"margin_top";s:1:"5";s:14:"margin_boottom";s:1:"5";s:11:"margin_left";s:1:"5";s:12:"margin_right";s:1:"5";s:10:"point_type";s:1:"2";}}i:2;a:3:{s:2:"id";s:14:"m1560562097556";s:4:"name";s:3:"nav";s:6:"params";a:6:{s:3:"num";s:1:"5";s:6:"radius";s:1:"0";s:7:"padding";s:1:"0";s:7:"bgcolor";s:7:"#ffffff";s:9:"fontcolor";s:7:"#666666";s:4:"data";a:5:{i:0;a:6:{s:2:"id";s:8:"00000001";s:5:"title";s:12:"严选鲜果";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:3:"img";s:64:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_top_1.png";s:8:"url_name";s:18:"产品分类列表";}i:1;a:6:{s:2:"id";s:8:"00000002";s:5:"title";s:12:"营养蔬菜";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:3:"img";s:64:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_top_2.png";s:8:"url_name";s:18:"产品分类列表";}i:2;a:6:{s:2:"id";s:8:"00000003";s:5:"title";s:12:"禽蛋肉类";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:3:"img";s:64:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_top_3.png";s:8:"url_name";s:18:"产品分类列表";}i:3;a:6:{s:2:"id";s:8:"00000004";s:5:"title";s:12:"水产海鲜";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:3:"img";s:64:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_top_4.png";s:8:"url_name";s:18:"产品分类列表";}i:4;a:6:{s:2:"id";s:8:"00000005";s:5:"title";s:12:"粮油调味";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:3:"img";s:64:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_top_5.png";s:8:"url_name";s:18:"产品分类列表";}}}}i:3;a:3:{s:2:"id";s:14:"m1560562491300";s:4:"name";s:3:"nav";s:6:"params";a:6:{s:3:"num";s:1:"5";s:6:"radius";s:1:"0";s:7:"padding";s:1:"0";s:7:"bgcolor";s:7:"#ffffff";s:9:"fontcolor";s:7:"#666666";s:4:"data";a:5:{i:0;a:6:{s:2:"id";s:8:"00000001";s:5:"title";s:12:"家庭副食";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:3:"img";s:67:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_bottom_1.png";s:8:"url_name";s:18:"产品分类列表";}i:1;a:6:{s:2:"id";s:8:"00000002";s:5:"title";s:12:"休闲零食";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:3:"img";s:67:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_bottom_2.png";s:8:"url_name";s:18:"产品分类列表";}i:2;a:6:{s:2:"id";s:8:"00000003";s:5:"title";s:12:"酒饮冲调";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:3:"img";s:67:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_bottom_3.png";s:8:"url_name";s:18:"产品分类列表";}i:3;a:6:{s:2:"id";s:8:"00000004";s:5:"title";s:12:"个护家清";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:3:"img";s:67:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_bottom_4.png";s:8:"url_name";s:18:"产品分类列表";}i:4;a:6:{s:2:"id";s:8:"00000005";s:5:"title";s:6:"更多";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:3:"img";s:67:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_bottom_5.png";s:8:"url_name";s:18:"产品分类列表";}}}}i:4;a:3:{s:2:"id";s:14:"m1560563188265";s:4:"name";s:5:"image";s:6:"params";a:7:{s:7:"padding";s:1:"1";s:4:"type";s:1:"2";s:6:"istext";s:1:"0";s:8:"fontsize";s:2:"14";s:9:"fontcolor";s:4:"#333";s:7:"bgcolor";s:7:"#ffffff";s:4:"data";a:2:{i:0;a:6:{s:2:"id";s:8:"00000001";s:3:"img";s:57:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/j1.png";s:3:"url";s:31:"/pages/integralMall/index/index";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:15:"积分商城页";}i:1;a:6:{s:2:"id";s:15:"m01560563191609";s:4:"type";s:3:"url";s:3:"url";s:20:"/pages/checkIn/index";s:5:"title";s:0:"";s:3:"img";s:57:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/j2.png";s:8:"url_name";s:12:"积分签到";}}}}i:5;a:3:{s:2:"id";s:14:"m1548983841984";s:4:"name";s:8:"buyTitle";s:6:"params";a:13:{s:6:"module";s:1:"3";s:5:"color";s:7:"#ffffff";s:7:"bgcolor";s:7:"#ff4848";s:9:"timeColor";s:7:"#ffffff";s:11:"timeBgcolor";s:7:"#505050";s:10:"limitTitle";s:12:"正在抢购";s:14:"limitTitleDown";s:12:"每日更新";s:9:"nextTitle";s:12:"下期预告";s:13:"nextTitleDown";s:12:"限时开抢";s:7:"nocolor";s:4:"#333";s:9:"nobgcolor";s:4:"#eee";s:3:"pic";s:57:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/y1.png";s:5:"nopic";s:57:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/y2.png";}}i:6;a:3:{s:2:"id";s:14:"m1548983843177";s:4:"name";s:4:"cate";s:6:"params";a:4:{s:12:"border_color";s:7:"#000000";s:5:"color";s:4:"#000";s:7:"mrcolor";s:7:"#b0b0b0";s:7:"bgcolor";s:7:"#ff4848";}}i:7;a:3:{s:2:"id";s:14:"m1548984145632";s:4:"name";s:5:"goods";s:6:"params";a:8:{s:18:"goods_title_module";s:1:"0";s:12:"goods_module";s:1:"5";s:8:"is_class";s:1:"0";s:3:"num";s:2:"10";s:6:"is_hot";s:1:"0";s:6:"is_new";s:1:"1";s:6:"margin";s:1:"4";s:6:"radius";s:2:"18";}}i:8;a:3:{s:2:"id";s:14:"m1548836775341";s:4:"name";s:4:"bars";s:6:"params";a:8:{s:6:"radius";s:1:"0";s:7:"padding";s:1:"5";s:7:"bgcolor";s:7:"#ffffff";s:9:"fontcolor";s:4:"#000";s:8:"actcolor";s:7:"#dd4f43";s:3:"num";s:1:"4";s:4:"data";a:5:{i:0;a:7:{s:2:"id";s:8:"00000001";s:5:"title";s:6:"首页";s:3:"img";s:65:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_main_2.png";s:6:"actimg";s:65:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_main_1.png";s:4:"type";s:3:"url";s:3:"url";s:21:"/pages/template/index";s:8:"url_name";s:6:"首页";}i:1;a:7:{s:2:"id";s:8:"00000004";s:5:"title";s:6:"分类";s:3:"img";s:66:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_class_2.png";s:6:"actimg";s:66:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_class_1.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:8:"url_name";s:18:"产品分类列表";}i:2;a:7:{s:2:"id";s:8:"00000002";s:5:"title";s:9:"购物车";s:3:"img";s:62:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_g_2.png";s:6:"actimg";s:62:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_g_1.png";s:4:"type";s:3:"url";s:3:"url";s:20:"/pages/template/cart";s:8:"url_name";s:9:"购物车";}i:3;a:7:{s:2:"id";s:8:"00000003";s:5:"title";s:6:"我的";s:3:"img";s:67:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_member_2.png";s:6:"actimg";s:67:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_member_1.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/personal";s:8:"url_name";s:12:"个人中心";}i:4;a:6:{s:2:"id";s:8:"00000005";s:5:"title";s:12:"导航名称";s:3:"img";s:67:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_member_2.png";s:6:"actimg";s:67:"http://sqtg.scmmwl.com/addons/group_buy/public/diy/nav_member_1.png";s:4:"type";s:3:"url";s:3:"url";s:0:"";}}s:7:"content";s:0:"";}}}s:5:"basic";a:9:{s:2:"id";s:7:"0000000";s:4:"name";s:0:"";s:5:"title";s:24:"麦芒社区团购模板";s:10:"sharetitle";s:0:"";s:8:"shareimg";s:0:"";s:5:"isbar";s:1:"0";s:5:"topbg";s:7:"#ffffff";s:8:"topcolor";s:7:"#000000";s:5:"allbg";s:7:"#ffffff";}}', '1548985346', '', '4', '1', '2');
INSERT INTO `mmwl_gpb_diy_page` VALUES ('5', '2', 'a:2:{s:4:"data";a:7:{i:0;a:3:{s:2:"id";s:14:"m1548816385107";s:4:"name";s:5:"slide";s:6:"params";a:14:{s:8:"ischange";s:1:"0";s:10:"changetime";s:1:"3";s:10:"changelast";s:3:"500";s:10:"pointcolor";s:7:"#dddddd";s:8:"actcolor";s:7:"#22c397";s:9:"showpoint";s:1:"0";s:6:"height";s:3:"150";s:4:"data";a:2:{i:0;a:5:{s:2:"id";s:8:"00000001";s:4:"type";s:3:"url";s:3:"url";s:23:"/pages/group/groupApply";s:8:"url_name";s:15:"申请团长页";s:3:"img";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/zGTO48664tgooR46tsHShmYTE48Trg.jpg";}i:1;a:5:{s:2:"id";s:14:"g1548816397444";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/supplier";s:8:"url_name";s:18:"申请供应商页";s:3:"img";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/QFfpl126JMBlNlAL6FLP7SekkL2PMS.jpg";}}s:6:"radius";s:1:"0";s:6:"margin";s:1:"4";s:10:"margin_top";s:1:"0";s:14:"margin_boottom";s:1:"0";s:11:"margin_left";s:1:"0";s:12:"margin_right";s:1:"0";}}i:1;a:3:{s:2:"id";s:14:"m1548469872895";s:4:"name";s:4:"head";s:6:"params";a:4:{s:4:"type";s:1:"1";s:11:"head_module";s:1:"1";s:6:"margin";s:1:"5";s:6:"radius";s:2:"10";}}i:2;a:3:{s:2:"id";s:14:"m1548913537421";s:4:"name";s:6:"coupon";s:6:"params";a:7:{s:7:"padding";s:1:"0";s:4:"type";s:1:"1";s:6:"istext";s:1:"0";s:8:"fontsize";s:2:"14";s:9:"fontcolor";s:4:"#333";s:7:"bgcolor";s:7:"#ffffff";s:4:"data";a:1:{i:0;a:5:{s:2:"id";s:8:"00000001";s:3:"img";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/t8Ic5L1T99cIEiItZ3UwDlneGC8Ino.png";s:3:"url";s:22:"/pages/template/coupon";s:5:"title";s:0:"";s:4:"type";s:3:"url";}}}}i:3;a:3:{s:2:"id";s:14:"m1548897284424";s:4:"name";s:8:"buyTitle";s:6:"params";a:6:{s:6:"module";s:1:"2";s:5:"color";s:7:"#ffffff";s:7:"bgcolor";s:7:"#000000";s:9:"timeColor";s:7:"#ffffff";s:11:"timeBgcolor";s:7:"#ff0000";s:10:"limitTitle";s:12:"限时抢购";}}i:4;a:3:{s:2:"id";s:14:"m1548469535713";s:4:"name";s:5:"goods";s:6:"params";a:8:{s:4:"type";s:1:"2";s:8:"is_class";s:1:"0";s:3:"num";s:2:"10";s:12:"goods_module";s:1:"3";s:7:"content";s:0:"";s:18:"goods_title_module";s:1:"0";s:6:"is_new";s:1:"0";s:6:"is_hot";s:1:"1";}}i:5;a:3:{s:2:"id";s:14:"m1548656059308";s:4:"name";s:5:"space";s:6:"params";a:3:{s:6:"height";s:2:"11";s:7:"bgcolor";s:7:"#f3f4f5";s:7:"content";s:0:"";}}i:6;a:3:{s:2:"id";s:14:"m1548654541438";s:4:"name";s:4:"bars";s:6:"params";a:7:{s:6:"radius";s:1:"0";s:7:"padding";s:1:"0";s:7:"bgcolor";s:7:"#ffffff";s:9:"fontcolor";s:4:"#000";s:8:"actcolor";s:7:"#f1646b";s:3:"num";s:1:"4";s:4:"data";a:5:{i:0;a:7:{s:2:"id";s:8:"00000001";s:5:"title";s:6:"首页";s:3:"img";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/dm16wMz81LFtct8TcC54F1cZcfTRWM.png";s:6:"actimg";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/CPVpAyVPAfUoZSNpAOaaeVYNoPPnMa.png";s:4:"type";s:3:"url";s:3:"url";s:21:"/pages/template/index";s:8:"url_name";s:6:"首页";}i:1;a:7:{s:2:"id";s:8:"00000002";s:5:"title";s:6:"分类";s:3:"img";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/PBeZG4zP0lG34BA0B6GYP0G9YbLyp9.png";s:6:"actimg";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/cKqTkKievkt4e3eN2UlkV4e4k2QKiq.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:8:"url_name";s:18:"产品分类列表";}i:2;a:7:{s:2:"id";s:8:"00000003";s:5:"title";s:9:"购物车";s:3:"img";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/KOCmmVbQzoCTO4oYbDBYe4DsJEQcmD.png";s:6:"actimg";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/Mqa61tk6jGZ6zZ3K67kjjZQ4J54K6g.png";s:4:"type";s:3:"url";s:3:"url";s:20:"/pages/template/cart";s:8:"url_name";s:9:"购物车";}i:3;a:7:{s:2:"id";s:8:"00000004";s:5:"title";s:6:"我的";s:3:"img";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/Dw8260M5E7Swqs64EMS896ss653w4Z.png";s:6:"actimg";s:91:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/XngrYHNK7KKNZ5aHoon9EdZZhr93R5.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/personal";s:8:"url_name";s:12:"个人中心";}i:4;a:6:{s:2:"id";s:8:"00000005";s:5:"title";s:12:"导航名称";s:3:"img";s:63:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/no.png";s:6:"actimg";s:63:"http://sqtg.scmmwl.com/addons/group_buy/public/diyimages/no.png";s:4:"type";s:3:"url";s:3:"url";s:0:"";}}}}}s:5:"basic";a:9:{s:2:"id";s:7:"0000000";s:4:"name";s:0:"";s:5:"title";s:6:"首页";s:10:"sharetitle";s:0:"";s:8:"shareimg";s:0:"";s:5:"isbar";s:1:"0";s:5:"topbg";s:7:"#fc4443";s:8:"topcolor";s:7:"#ffffff";s:5:"allbg";s:7:"#ffffff";}}', '', '', '', '2', '3');

-- ----------------------------
-- Table structure for `mmwl_gpb_diy_temp`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_diy_temp`;
CREATE TABLE `mmwl_gpb_diy_temp` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(5) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '模板昵称',
  `isact` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '使用状态',
  `store` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '排序',
  `status` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `img` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '图标',
  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `system` tinyint(1) DEFAULT '1' COMMENT '是否是系统模板(系统模板禁止删除),一般1，系统2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_diy_temp 
-- ----------------------------
INSERT INTO `mmwl_gpb_diy_temp` VALUES ('4', '0', '麦芒风格', '-1', '1', '1', '/addons/group_buy/public/bg/sys_temp6.png', '1548985883', '2');

-- ----------------------------
-- Table structure for `mmwl_gpb_express`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_express`;
CREATE TABLE `mmwl_gpb_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '快递表id',
  `simplecode` varchar(100) NOT NULL COMMENT 'code',
  `name` varchar(100) NOT NULL COMMENT '名称',
  `create_time` char(15) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` char(15) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '第三方是否支持 1即时查询',
  `start` tinyint(4) DEFAULT '0' COMMENT '是否启用',
  `weid` int(11) NOT NULL COMMENT '模块id',
  `system` tinyint(1) DEFAULT '1' COMMENT '是否是系统自带 1是 2不是',
  `is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除 1不 2是',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_gpb_express 
-- ----------------------------
INSERT INTO `mmwl_gpb_express` VALUES ('97', 'AJ', '安捷快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('98', 'ANE', '安能物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('99', 'AXD', '安信达快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('100', 'BQXHM', '北青小红帽', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('101', 'BFDF', '百福东方', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('102', 'CCES', 'CCES快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('103', 'CITY100', '城市100', '0', '0', '1', '1', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('104', 'COE', 'COE东方快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('105', 'CSCY', '长沙创一', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('106', 'CDSTKY', '成都善途速运', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('107', 'DBL', '德邦', '0', '0', '1', '1', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('108', 'DSWL', 'D速物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('109', 'DTWL', '大田物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('110', 'EMS', 'EMS', '0', '0', '1', '1', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('111', 'FAST', '快捷速递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('112', 'FEDEX', 'FEDEX联邦(国内件）', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('113', 'FEDEX_GJ', 'FEDEX联邦(国际件）', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('114', 'FKD', '飞康达', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('115', 'GDEMS', '广东邮政', '0', '0', '1', '1', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('116', 'GSD', '共速达', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('117', 'GTO', '国通快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('118', 'GTSD', '高铁速递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('119', 'HFWL', '汇丰物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('120', 'HHTT', '天天快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('121', 'HLWL', '恒路物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('122', 'HOAU', '天地华宇', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('123', 'hq568', '华强物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('124', 'HXLWL', '华夏龙物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('125', 'HYLSD', '好来运快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('126', 'JGSD', '京广速递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('127', 'JIUYE', '九曳供应链', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('128', 'JJKY', '佳吉快运', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('129', 'JLDT', '嘉里物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('130', 'JTKD', '捷特快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('131', 'JXD', '急先达', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('132', 'JYKD', '晋越快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('133', 'JYM', '加运美', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('134', 'JYWL', '佳怡物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('135', 'KYWL', '跨越物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('136', 'LB', '龙邦快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('137', 'LHT', '联昊通速递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('138', 'MHKD', '民航快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('139', 'MLWL', '明亮物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('140', 'NEDA', '能达速递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('141', 'PADTF', '平安达腾飞快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('142', 'QCKD', '全晨快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('143', 'QFKD', '全峰快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('144', 'QRT', '全日通快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('145', 'RFD', '如风达', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('146', 'SAD', '赛澳递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('147', 'SAWL', '圣安物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('148', 'SBWL', '盛邦物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('149', 'SDWL', '上大物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('150', 'SFWL', '盛丰物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('151', 'SHWL', '盛辉物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('152', 'ST', '速通物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('153', 'STWL', '速腾快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('154', 'SURE', '速尔快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('155', 'UAPEX', '全一快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('156', 'UC', '优速快递', '0', '0', '1', '1', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('157', 'WJWL', '万家物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('158', 'WXWL', '万象物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('159', 'XBWL', '新邦物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('160', 'XFEX', '信丰快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('161', 'XYT', '希优特', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('162', 'XJ', '新杰物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('163', 'YADEX', '源安达快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('164', 'YCWL', '远成物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('165', 'YD', '韵达快递', '0', '0', '1', '1', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('166', 'YDH', '义达国际物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('167', 'YFEX', '越丰物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('168', 'YFHEX', '原飞航物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('169', 'YFSD', '亚风快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('170', 'YTKD', '运通快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('171', 'YTO', '圆通速递', '0', '0', '1', '1', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('172', 'YXKD', '亿翔快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('173', 'YZPY', '邮政平邮/小包', '0', '0', '1', '1', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('174', 'ZENY', '增益快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('175', 'ZHQKD', '汇强快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('176', 'ZJS', '宅急送', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('177', 'ZTE', '众通快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('178', 'ZTKY', '中铁快运', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('179', 'ZTO', '中通速递', '0', '0', '1', '1', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('180', 'ZTWL', '中铁物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('181', 'ZYWL', '中邮物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('182', 'AMAZON', '亚马逊物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('183', 'SUBIDA', '速必达物流', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('184', 'RFEX', '瑞丰速递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('185', 'QUICK', '快客快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('186', 'CJKD', '城际快递', '0', '0', '1', '1', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('187', 'CNPEX', 'CNPEX中邮快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('188', 'HOTSCM', '鸿桥供应链', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('189', 'HPTEX', '海派通物流公司', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('190', 'AYCA', '澳邮专线', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('191', 'PANEX', '泛捷快递', '0', '0', '1', '0', '0', '1', '1');
INSERT INTO `mmwl_gpb_express` VALUES ('192', 'PCA', 'PCA Express', '0', '0', '1', '0', '0', '1', '1');

-- ----------------------------
-- Table structure for `mmwl_gpb_express_shipping`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_express_shipping`;
CREATE TABLE `mmwl_gpb_express_shipping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT '名称',
  `type` tinyint(1) NOT NULL COMMENT '计费方式 1按重量计费 2按件计费',
  `sort_order` int(10) NOT NULL COMMENT '顺序',
  `firstprice` decimal(10,2) NOT NULL COMMENT '首重价格',
  `secondprice` decimal(10,2) NOT NULL COMMENT '续重价格',
  `firstweight` int(11) NOT NULL COMMENT '首重',
  `secondweight` int(11) NOT NULL COMMENT '续重',
  `areas` longtext NOT NULL COMMENT '地区',
  `firstnum` int(11) NOT NULL COMMENT '首件',
  `secondnum` int(11) NOT NULL COMMENT '续件',
  `firstnumprice` decimal(10,2) NOT NULL COMMENT '首件价格',
  `secondnumprice` decimal(10,2) NOT NULL COMMENT '续件价格',
  `isdefault` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认 1 是 2 否',
  `enabled` tinyint(1) DEFAULT '0' COMMENT '状态1启用0禁用',
  `is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除1不 2删',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_gpb_get_cash`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_get_cash`;
CREATE TABLE `mmwl_gpb_get_cash` (
  `ggc_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '提现主键',
  `openid` char(30) COLLATE utf8_bin DEFAULT NULL,
  `ggc_money` decimal(10,2) DEFAULT NULL COMMENT '金额',
  `ggc_type` tinyint(2) DEFAULT '10' COMMENT '状态：10待审核20已审核30拒绝40余额不足',
  `ggc_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '申请时间',
  `ggc_update_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '更新时间',
  `ggc_content` text COLLATE utf8_bin COMMENT '拒绝理由(30才有)',
  `ggc_form_id` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '模版id',
  `ggc_rate` decimal(3,2) DEFAULT NULL COMMENT '税率',
  `weid` int(11) DEFAULT NULL,
  `ggc_code` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '订单号',
  `ggc_pay_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '支付方式 1微信零钱2支付宝3银行卡',
  `ggc_pay_account` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '线下处理帐号',
  `ggc_pay_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '线下处理姓名',
  `ggc_open_account_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '开户行名称',
  PRIMARY KEY (`ggc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_goods`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_goods`;
CREATE TABLE `mmwl_gpb_goods` (
  `g_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品主键',
  `g_name` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '商品名称',
  `g_cid` int(11) DEFAULT NULL COMMENT '商品分类',
  `g_brief` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '商品简介',
  `g_old_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品原价',
  `g_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品售价',
  `g_sale_num` int(7) unsigned DEFAULT '0' COMMENT '销售数量',
  `g_icon` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '商品封面',
  `g_info` text COLLATE utf8_bin COMMENT '商品详情',
  `g_is_online` tinyint(1) DEFAULT '1' COMMENT '是否上架1上-1不上',
  `g_is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除-1删1不删',
  `g_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `g_update_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
  `g_order` int(11) DEFAULT NULL COMMENT '排序',
  `g_thumb` text COLLATE utf8_bin COMMENT '图集',
  `g_video` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '视频',
  `g_is_recommand` tinyint(1) DEFAULT '-1' COMMENT '是否推荐-1否1是',
  `g_is_hot` tinyint(1) DEFAULT '-1' COMMENT '是否热门-1否1是',
  `g_real_sale_num` int(7) unsigned DEFAULT '0' COMMENT '真实销售数量',
  `weid` int(11) DEFAULT NULL,
  `g_product_num` char(40) COLLATE utf8_bin DEFAULT NULL COMMENT '商品货号',
  `g_limit_num` smallint(3) DEFAULT NULL COMMENT '商品限购数量',
  `g_start_sale_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '开始售卖时间',
  `g_end_sale_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '结束售卖时间',
  `g_is_sale_time` tinyint(1) DEFAULT NULL COMMENT '是否在限时销售',
  `g_arrival_time` smallint(3) DEFAULT NULL COMMENT '预计到达时间(天)',
  `type` int(3) DEFAULT '1' COMMENT '类型1.正常商品 2. 积分商品',
  `g_is_new` tinyint(1) DEFAULT '1' COMMENT '是否新品1是-1不是',
  `pay` int(3) DEFAULT NULL COMMENT '支付方式1.积分支付 2.积分+现金',
  `integral` int(3) DEFAULT NULL COMMENT '支付的积分',
  `g_arrival_time_text` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '预计到达时间(文本)',
  `g_supplier_id` int(11) DEFAULT NULL COMMENT '供应商id',
  `g_has_option` tinyint(1) DEFAULT '0' COMMENT '是否启用商品规则（多规格）',
  `limit` varchar(25) COLLATE utf8_bin DEFAULT NULL COMMENT '积分商品限制兑换数量',
  `spec_type` varchar(255) COLLATE utf8_bin DEFAULT '20' COMMENT '库存计算方式 10 下单减库存 20 付款减库存',
  `send_points` double(10,2) DEFAULT '0.00' COMMENT '商品送积分，默认为0',
  `g_day_limit_num` smallint(6) DEFAULT '0' COMMENT '商品单日单人限购数量 0为不限购',
  `g_commission` decimal(10,2) DEFAULT '0.00' COMMENT '商品佣金，分佣比例',
  `g_send_type` tinyint(1) DEFAULT '1' COMMENT '运费模式 1 统一运费 2运费模版',
  `g_send_price_sample` decimal(10,2) DEFAULT '0.00' COMMENT '统一运费设置（元）',
  `g_express_shipping_id` int(11) NOT NULL COMMENT '运费模版id关联',
  `g_only_weight` decimal(10,2) DEFAULT '0.00' COMMENT '单规格时商品重量用于快递计算运费',
  `g_stock_notice` smallint(5) DEFAULT '0' COMMENT '库存预警',
  `g_is_top` tinyint(1) DEFAULT '0' COMMENT '是否置顶 0 不是 1是',
  `g_is_full_reduce` tinyint(1) DEFAULT '0' COMMENT '是否满减 0 不是 1是',
  `g_history_limit_num` smallint(6) DEFAULT '0' COMMENT '历史单人限购数量',
  `g_is_near_recommend` tinyint(1) DEFAULT '0' COMMENT '是否邻居推荐 0 不是 1是',
  `g_virtual_people` smallint(6) NOT NULL DEFAULT '0' COMMENT '虚拟人数',
  `g_virtual_max_buy` smallint(6) NOT NULL DEFAULT '0' COMMENT '每人最大虚拟份数',
  `g_virtual_min_buy` smallint(6) NOT NULL DEFAULT '0' COMMENT '每人最新虚拟份数',
  `member_card_discount` int(2) DEFAULT '1' COMMENT '会员价格状态 1没有会员价 2.统一设置 3.详细设置',
  PRIMARY KEY (`g_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_goods_cate`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_goods_cate`;
CREATE TABLE `mmwl_gpb_goods_cate` (
  `gc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品分类id',
  `gc_name` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '分类名称',
  `gc_pid` int(11) DEFAULT NULL COMMENT '上级分类id',
  `gc_status` tinyint(1) DEFAULT '1' COMMENT '是否分类页显示',
  `gc_is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除',
  `gc_icon` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '分类图标',
  `gc_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `gc_update_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
  `gc_order` int(11) DEFAULT NULL COMMENT '排序',
  `weid` int(11) DEFAULT NULL,
  `gc_level` smallint(4) DEFAULT NULL COMMENT '等级',
  `gc_tree` char(80) COLLATE utf8_bin DEFAULT NULL COMMENT '树状路径',
  `type` varchar(20) COLLATE utf8_bin DEFAULT '1' COMMENT '分类1.正常商品 2.积分商品',
  `gc_is_index_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否首页显示',
  PRIMARY KEY (`gc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_goods_option`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_goods_option`;
CREATE TABLE `mmwl_gpb_goods_option` (
  `ggo_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品规格表（erp）',
  `weid` int(11) DEFAULT '0',
  `ggo_g_id` int(11) DEFAULT '0' COMMENT '商品id',
  `ggo_title` char(50) COLLATE utf8_bin DEFAULT '' COMMENT '名称（规格下属名称+分割）',
  `ggo_thumb` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '缩略图',
  `ggo_old_price` decimal(10,2) DEFAULT '0.00' COMMENT '原价',
  `ggo_market_price` decimal(10,2) DEFAULT '0.00' COMMENT '现价',
  `ggo_cost_price` decimal(10,2) DEFAULT '0.00' COMMENT '成本价',
  `ggo_stock` int(11) DEFAULT '0' COMMENT '库存（-1长期售卖）',
  `ggo_weight` decimal(10,2) DEFAULT '0.00' COMMENT '重量',
  `ggo_displayorder` int(11) DEFAULT '0' COMMENT '显示顺序，排序',
  `ggo_specs` text COLLATE utf8_bin COMMENT '规格设置（规格下属ID _分割）',
  `ggo_skuid` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '不同规格对应的ID，用来统计',
  `ggo_goodssn` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '商品编号',
  `ggo_productsn` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '商品条码',
  `ggo_virtual` int(11) DEFAULT '0' COMMENT '虚拟商品码',
  `ggo_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '新增时间',
  `ggo_update_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
  `ggo_is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除',
  `ggo_order` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`ggo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_goods_spec`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_goods_spec`;
CREATE TABLE `mmwl_gpb_goods_spec` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品规格',
  `weid` int(11) DEFAULT NULL,
  `g_id` int(11) DEFAULT NULL COMMENT '商品id',
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '标题',
  `description` varchar(500) COLLATE utf8_bin DEFAULT NULL COMMENT '描述',
  `content` text COLLATE utf8_bin COMMENT '内容',
  `status` int(2) DEFAULT '1' COMMENT '状态',
  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '时间',
  `displayorder` int(11) DEFAULT '0' COMMENT '显示顺序',
  `displaytype` tinyint(3) DEFAULT '0' COMMENT '显示类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_goods_spec_item`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_goods_spec_item`;
CREATE TABLE `mmwl_gpb_goods_spec_item` (
  `gsi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '规格下参数表',
  `weid` int(11) DEFAULT '0',
  `gsi_specid` int(11) DEFAULT '0' COMMENT '规格id 关联goods_spec',
  `gsi_title` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '参数名称',
  `gsi_thumb` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '参数图片',
  `gsi_show` int(11) DEFAULT '0' COMMENT '参数显示',
  `gsi_displayorder` int(11) DEFAULT '0' COMMENT '显示顺序',
  `gsi_virtual` int(11) DEFAULT '0' COMMENT '虚拟商品',
  `gsi_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '新增时间',
  `gsi_update_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
  `gsi_is_del` tinyint(1) DEFAULT '1' COMMENT '是否显示',
  PRIMARY KEY (`gsi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_goods_stock`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_goods_stock`;
CREATE TABLE `mmwl_gpb_goods_stock` (
  `gs_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品库存',
  `store_id` int(10) DEFAULT NULL COMMENT '对应店铺id',
  `product_id` int(10) DEFAULT NULL COMMENT '对应规格id',
  `num` int(10) DEFAULT '0' COMMENT '剩余库存',
  `sale_num` int(10) DEFAULT '0' COMMENT '销售量',
  `goods_id` int(10) DEFAULT NULL COMMENT '对应商品id',
  `business_id` int(11) DEFAULT '1',
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`gs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_goods_stock_logs`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_goods_stock_logs`;
CREATE TABLE `mmwl_gpb_goods_stock_logs` (
  `lid` int(10) NOT NULL AUTO_INCREMENT COMMENT '入库日志',
  `sid` int(10) DEFAULT NULL COMMENT '店铺id',
  `gid` int(10) DEFAULT NULL COMMENT '商品id',
  `aid` int(10) DEFAULT NULL COMMENT '规格id',
  `num` int(10) DEFAULT NULL COMMENT '数量变化',
  `uid` int(10) DEFAULT NULL COMMENT '操作用户id',
  `time` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '操作时间',
  `gs_id` int(10) DEFAULT NULL COMMENT '关联库存表',
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_goods_to_category`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_goods_to_category`;
CREATE TABLE `mmwl_gpb_goods_to_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`,`goods_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_head_commond_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_head_commond_log`;
CREATE TABLE `mmwl_gpb_head_commond_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '推荐奖领取日志',
  `uid` int(11) NOT NULL COMMENT '被推荐用户id',
  `pid` int(11) NOT NULL COMMENT '推荐用户id',
  `num` int(11) NOT NULL COMMENT '用户完成交易次数',
  `all_money` double(10,2) NOT NULL COMMENT '完成交易总金额',
  `commoned_times` int(11) NOT NULL COMMENT '当前被推荐人为本轮第N人',
  `is_over` int(11) NOT NULL COMMENT '是否已结算',
  `now_times` int(11) NOT NULL COMMENT '当前是第N轮',
  `weid` int(11) NOT NULL,
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(2) NOT NULL DEFAULT '1',
  `get_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '完成此次推荐的奖励金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_head_group`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_head_group`;
CREATE TABLE `mmwl_gpb_head_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leader_id` int(11) DEFAULT NULL,
  `lv1` text COLLATE utf8_bin NOT NULL,
  `lv2` text COLLATE utf8_bin NOT NULL,
  `lv3` text COLLATE utf8_bin NOT NULL,
  `weid` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_head_group_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_head_group_log`;
CREATE TABLE `mmwl_gpb_head_group_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团长下级日志',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `pid` int(11) NOT NULL COMMENT '直属父级id',
  `weid` int(11) NOT NULL COMMENT '模块id',
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_head_history`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_head_history`;
CREATE TABLE `mmwl_gpb_head_history` (
  `hh_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团长历史记录表',
  `hh_head_openid` char(30) COLLATE utf8_bin NOT NULL COMMENT '团长openid',
  `openid` char(30) COLLATE utf8_bin NOT NULL COMMENT '用户openid',
  `hh_add_time` char(15) COLLATE utf8_bin DEFAULT '0' COMMENT '第一次关联时间',
  `hh_last_time` char(15) COLLATE utf8_bin DEFAULT '0' COMMENT '最近一次关联时间',
  `weid` int(11) DEFAULT '0',
  `type` tinyint(1) DEFAULT '1' COMMENT '关联类型，1用户自己主动选择2.别人分享被动关联',
  PRIMARY KEY (`hh_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_head_money`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_head_money`;
CREATE TABLE `mmwl_gpb_head_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团长分销用户',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计推荐余额',
  `frize_money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结资金',
  `used_mondey` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现资金',
  `cash_money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现中资金',
  `check_state` int(1) NOT NULL DEFAULT '1' COMMENT '审核状态,1通过，-1不通过，0待审核',
  `comment` text COLLATE utf8_bin COMMENT '不通过原因',
  `up_comment` text COLLATE utf8_bin COMMENT '提交审核参数',
  `weid` int(11) NOT NULL,
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(1) NOT NULL,
  `money_downline` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计分销金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_head_money_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_head_money_log`;
CREATE TABLE `mmwl_gpb_head_money_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户分销佣金变动日志',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `info` text COLLATE utf8_bin COMMENT '操作信息',
  `money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动资金数额',
  `weid` int(11) NOT NULL COMMENT '模块id',
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(2) NOT NULL DEFAULT '1',
  `type` int(2) NOT NULL DEFAULT '1' COMMENT '类型，1增加，2减少，3冻结，4体现',
  `order_code` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '订单id',
  `type_from` tinyint(1) NOT NULL DEFAULT '1' COMMENT '来源类型，1分销所得，2推荐奖所得',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_head_route`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_head_route`;
CREATE TABLE `mmwl_gpb_head_route` (
  `ghr_id` int(11) NOT NULL AUTO_INCREMENT,
  `ghr_mid` int(11) DEFAULT NULL,
  `ghr_vid` int(11) NOT NULL,
  `ghr_rid` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`ghr_id`,`ghr_vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_level`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_level`;
CREATE TABLE `mmwl_gpb_level` (
  `id` int(11) unsigned NOT NULL COMMENT '会员等级',
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '等级名称',
  `type` int(2) DEFAULT NULL COMMENT '优惠类型 1.立减 2.折扣',
  `money` double(10,2) DEFAULT NULL COMMENT '优惠价格（立减为优惠多少元，折扣为几折）',
  `status` int(2) DEFAULT '1' COMMENT '状态',
  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '时间',
  `weid` int(11) DEFAULT NULL COMMENT '模块id',
  `code` int(2) DEFAULT NULL COMMENT '是否自动升级',
  `co_money` double(10,2) DEFAULT NULL COMMENT '升级购物金额'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_mail`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_mail`;
CREATE TABLE `mmwl_gpb_mail` (
  `id` int(11) DEFAULT NULL COMMENT '站内信',
  `openid` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '创建时间',
  `content` text COLLATE utf8_bin COMMENT '内容',
  `status` int(2) DEFAULT '1' COMMENT '状态',
  `weid` int(11) DEFAULT NULL COMMENT '模块id',
  `code` int(2) DEFAULT NULL COMMENT '是否查看'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_member`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_member`;
CREATE TABLE `mmwl_gpb_member` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员表主键ID',
  `m_nickname` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '会员昵称（微信获取）',
  `m_phone` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '手机号',
  `m_name` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '真实姓名',
  `m_openid` char(50) COLLATE utf8_bin NOT NULL COMMENT '微信openid',
  `m_photo` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '头像地址',
  `m_money` decimal(10,2) DEFAULT '0.00' COMMENT '账号金额',
  `m_last_longitude` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '上次定位经度',
  `m_last_latitude` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '上次定位纬度',
  `m_is_head` tinyint(1) DEFAULT '-1' COMMENT '是否是团长2是-1否',
  `m_commission` decimal(10,2) DEFAULT '0.00' COMMENT '佣金比例1-100%',
  `m_order_num` int(5) DEFAULT '0' COMMENT '该用户成交单数',
  `m_order_money` decimal(10,2) DEFAULT '0.00' COMMENT '订单成交总金额',
  `m_comment` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '个人说明',
  `m_update_time` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
  `m_status` tinyint(1) DEFAULT '1' COMMENT '状态/软删除',
  `weid` int(11) DEFAULT NULL COMMENT '模块ID',
  `m_add_time` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `m_two_code` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '二维码',
  `m_wx_account` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '微信账号',
  `m_head_lng` char(30) COLLATE utf8_bin DEFAULT '0' COMMENT '申请团长时定位经度',
  `m_head_lat` char(30) COLLATE utf8_bin DEFAULT '0' COMMENT '申请团长时定位纬度',
  `m_head_shop_name` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '申请团长时社区/店铺名称',
  `m_head_address` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '申请团长时地址',
  `m_head_openid` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '选择的团长openid',
  `qr_code` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '团长二维码地址',
  `sessionkey` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '会话key',
  `m_get_good_code` char(10) COLLATE utf8_bin DEFAULT NULL COMMENT '唯一提货码',
  `m_time` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '二维码生成时间',
  `m_get_cash_money` decimal(10,2) DEFAULT NULL COMMENT '已提现金额',
  `m_back_money` decimal(10,2) DEFAULT NULL COMMENT '退款金额',
  `m_password` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '登录密码',
  `m_names` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '真实姓名',
  `m_address` text COLLATE utf8_bin COMMENT '地址',
  `m_ids` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '身份证号码',
  `other` text COLLATE utf8_bin COMMENT '其他',
  `integral` double(10,2) DEFAULT '0.00' COMMENT '积分',
  `status` int(2) DEFAULT NULL COMMENT '状态（是否审核）',
  `level_id` int(5) DEFAULT NULL COMMENT '等级id',
  `m_last_location` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '上一次定位省市区',
  `m_is_send` tinyint(1) DEFAULT '1' COMMENT '是否团长送货 2 送1不送',
  `m_send_price` decimal(10,2) DEFAULT '0.00' COMMENT '团长配送费',
  `m_is_have_limit_pay` tinyint(1) DEFAULT '1' COMMENT '是否开启小区限额 1不 2开',
  `m_limit_pay` decimal(10,2) DEFAULT '0.00' COMMENT '最低消费多少',
  `m_recommend_code` char(10) COLLATE utf8_bin NOT NULL COMMENT '团长推荐码',
  `m_send_price_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团长总配送费',
  `unionid` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开发平台openid',
  `wx_public_openid` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '公众号openid',
  `whether` int(2) DEFAULT '1' COMMENT '是否购买充值活动 1.没有 2.有',
  `level` int(8) DEFAULT '0' COMMENT '会员卡id',
  `end_level_time` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '会员卡结束时间为0 是永久',
  `m_head_house_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '团长地址某栋某单元门牌',
  `statr_level_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '会员卡开始时间',
  `level_money` double(10,2) DEFAULT '0.00' COMMENT '会员卡支付金额 -1是赠送会员',
  `m_money_balance` double(10,2) DEFAULT '0.00' COMMENT '用户余额',
  `level_last_time` int(2) DEFAULT '1' COMMENT '1.没过期 2.过期了',
  PRIMARY KEY (`m_id`,`m_openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_member_card`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_member_card`;
CREATE TABLE `mmwl_gpb_member_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员卡',
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `discount` double(10,2) DEFAULT '0.00' COMMENT '等级折扣',
  `c_status` int(2) DEFAULT '1' COMMENT '是否启用',
  `status` int(2) DEFAULT '1',
  `create_time` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '255',
  `weid` int(8) DEFAULT '0',
  `content` text COLLATE utf8_bin NOT NULL COMMENT '详情',
  `sort` int(8) DEFAULT '1' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_member_card_order`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_member_card_order`;
CREATE TABLE `mmwl_gpb_member_card_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '购买会员卡',
  `openid` varchar(255) COLLATE utf8_bin NOT NULL,
  `card_id` int(255) NOT NULL COMMENT '会员卡id',
  `money` double(10,2) DEFAULT '0.00' COMMENT '购买会员卡支付金额',
  `card_order` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '订单号',
  `card_status` int(3) DEFAULT '10' COMMENT '支付状态',
  `pay_code` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '支付code发送模板消息',
  `carete_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '下单时间',
  `pay_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '支付时间',
  `end_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '会员卡到期时间',
  `weid` int(8) DEFAULT '0',
  `y_money` double(10,2) DEFAULT '0.00' COMMENT '原价',
  `t_id` int(8) DEFAULT '0' COMMENT '时间id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_member_card_time`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_member_card_time`;
CREATE TABLE `mmwl_gpb_member_card_time` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员卡时间',
  `c_id` int(8) DEFAULT '0' COMMENT '会员卡id',
  `day` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '多少天',
  `company` int(2) DEFAULT '2' COMMENT '单位1.天2.月3.季度4.年',
  `money` double(10,2) DEFAULT '0.00' COMMENT '多少钱',
  `weid` int(2) DEFAULT '0',
  `status` int(2) DEFAULT '1',
  `create_time` varchar(255) COLLATE utf8_bin NOT NULL,
  `original_price` double(10,2) DEFAULT '0.00' COMMENT '原价',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_member_integral_check`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_member_integral_check`;
CREATE TABLE `mmwl_gpb_member_integral_check` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) COLLATE utf8_bin NOT NULL,
  `create_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '签到时间',
  `info` text COLLATE utf8_bin NOT NULL,
  `status` int(2) DEFAULT '1',
  `type` int(3) DEFAULT '1' COMMENT '类型1.日常2.连签',
  `number` int(8) DEFAULT '0' COMMENT '连签天数',
  `specific` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '签到具体时间',
  `type_days` int(5) DEFAULT '0' COMMENT '第几天连签',
  `reward` int(8) DEFAULT '0' COMMENT '签到奖励',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_menu`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_menu`;
CREATE TABLE `mmwl_gpb_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(5) NOT NULL COMMENT '账号id',
  `value` text COLLATE utf8_bin COMMENT '权限信息',
  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `f1` text COLLATE utf8_bin,
  `f2` text COLLATE utf8_bin,
  `f3` text COLLATE utf8_bin,
  `f4` text COLLATE utf8_bin,
  `f5` text COLLATE utf8_bin,
  `update_time` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_menu 
-- ----------------------------
INSERT INTO `mmwl_gpb_menu` VALUES ('1', '3', '82,34,36,35,91,97,90,142,40,41,50,51,52,88,79,9998,9997,9996,9995,9994,9993,9991,9990,9989,9988,9987,64,65,67,71,81,93,94,95,107,143,139,116,131,132,115,117,118,119,120,121,122,123,124,125,126,135,127,134,136,128,137,129,138,130', '1564628826', '1', '', '', '', '', '', '', '1564629266');

-- ----------------------------
-- Table structure for `mmwl_gpb_menu_list`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_menu_list`;
CREATE TABLE `mmwl_gpb_menu_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `pid` int(5) DEFAULT '0',
  `icon` varchar(255) COLLATE utf8_bin DEFAULT 'fa fa-cog',
  `status` varchar(255) COLLATE utf8_bin DEFAULT '1',
  `do` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `op` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '节点',
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '别名',
  `sort` int(5) DEFAULT NULL COMMENT '排序',
  `parame` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '多余参数',
  `display` int(2) NOT NULL DEFAULT '1' COMMENT '是否隐藏',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=143 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_menu_list 
-- ----------------------------
INSERT INTO `mmwl_gpb_menu_list` VALUES ('86', '团长设置', './index.php?c=site&a=entry&op=config&do=head&m=group_buy', '55', 'fa fa-cog', '1', 'head', 'config', '团长设置', '60', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('85', '佣金流水', './index.php?c=site&a=entry&do=finance&op=stream_commission&m=group_buy', '72', 'fa fa-cog', '1', 'finance', 'stream_commission', '佣金流水', '55', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('77', '生成配送单', './index.php?c=site&a=entry&op=wait&do=distribution&m=group_buy', '75', 'fa fa-cog', '1', 'distribution', 'wait', '', '44', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('76', '配送单', './index.php?c=site&a=entry&do=distribution&m=group_buy', '75', 'fa fa-cog', '1', 'distribution', 'index', '', '43', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('75', '配送', './index.php?c=site&a=entry&do=distribution&m=group_buy', '0', 'fa fa-truck', '1', 'distribution', '', '配送管理', '42', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('81', '权限设置', './index.php?c=site&a=entry&op=menu_index&do=config&m=group_buy', '64', 'fa fa-cog', '1', 'config', 'menu_index', '', '48', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('74', '退款', './index.php?c=site&a=entry&op=back_money&do=finance&m=group_buy', '72', 'fa fa-cog', '1', 'finance', 'back_money', '', '41', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('73', '提现', './index.php?c=site&a=entry&do=finance&m=group_buy', '72', 'fa fa-cog', '1', 'finance', 'get_cash', '', '40', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('72', '财务', './index.php?c=site&a=entry&do=finance&m=group_buy', '0', 'fa fa-bar-chart', '1', 'finance', '', '财务管理', '10', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('71', '打印机设置', './index.php?c=site&a=entry&op=print_set&do=config&m=group_buy', '64', 'fa fa-cog', '1', 'config', 'print_set', '', '38', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('41', '活动列表', './index.php?c=site&a=entry&do=action&m=group_buy', '40', 'fa fa-cog', '1', 'action', 'index', '活动列表', '8', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('61', '会员列表', './index.php?c=site&a=entry&do=member&m=group_buy', '60', 'fa fa-cog', '1', 'member', 'index', '', '28', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('70', '订单设置', './index.php?c=site&a=entry&op=order_set&do=order&m=group_buy', '42', 'fa fa-cog', '1', 'order', 'order_set', '', '145', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('40', '活动', './index.php?c=site&a=entry&do=action&m=group_buy', '0', 'fa fa-flag-checkered', '1', 'action', 'index', '活动管理', '7', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('69', '页面标题', './index.php?c=site&a=entry&op=title_set&do=config&m=group_buy', '64', 'fa fa-cog', '-1', 'config', 'title_set', '', '36', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('68', '首页设置', './index.php?c=site&a=entry&op=index_set&do=config&m=group_buy', '64', 'fa fa-cog', '-1', 'config', 'index_set', '', '35', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('67', '短信配置', './index.php?c=site&a=entry&op=msg&do=config&m=group_buy', '64', 'fa fa-cog', '1', 'config', 'msg', '', '34', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('66', '佣金设置', './index.php?c=site&a=entry&op=commission&do=config&m=group_buy', '64', 'fa fa-cog', '-1', 'config', 'commission', '', '33', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('65', '基本设置', './index.php?c=site&a=entry&do=config&m=group_buy', '64', 'fa fa-cog', '1', 'config', 'index', '', '32', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('64', '配置', './index.php?c=site&a=entry&do=config&m=group_buy', '0', 'fa fa-cog', '1', 'config', '', '配置管理', '60', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('63', '优惠券列表', './index.php?c=site&a=entry&do=market&m=group_buy', '40', 'fa fa-cog', '2', 'action', 'coupon', '', '30', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('62', '营销', './index.php?c=site&a=entry&do=market&m=group_buy', '0', 'fa fa-line-chart', '-1', 'market', '', '营销管理', '29', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('60', '会员', './index.php?c=site&a=entry&do=member&m=group_buy', '0', 'fa fa-users', '1', 'member', '', '用户管理', '27', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('59', '供应商列表', './index.php?c=site&a=entry&do=supplier&m=group_buy', '58', 'fa fa-cog', '1', 'supplier', 'index', '', '26', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('42', '订单', './index.php?c=site&a=entry&op=index&do=order&m=group_buy&status=20', '0', 'fa fa-file-text-o', '1', 'order', 'index', '订单管理', '9', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('58', '供应', './index.php?c=site&a=entry&do=supplier&m=group_buy', '0', 'fa fa-user-plus', '1', 'supplier', '', '供应商管理', '25', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('43', '待发货', './index.php?c=site&a=entry&status=20&do=order&m=group_buy', '42', 'fa fa-cog', '-1', 'order', '', '待发货订单', '100', 'status=20', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('57', '团长列表', './index.php?c=site&a=entry&op=index&do=head&m=group_buy', '55', 'fa fa-cog', '1', 'head', 'index', '', '24', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('56', '申请团长', './index.php?c=site&a=entry&do=head&m=group_buy', '55', 'fa fa-cog', '1', 'head', 'wantHead', '', '23', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('47', '核销列表', './index.php?c=site&a=entry&op=orderSure&do=order&m=group_buy', '42', 'fa fa-cog', '1', 'order', 'orderSure', '核销列表', '140', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('44', '待收货', './index.php?c=site&a=entry&status=30&do=order&m=group_buy', '42', 'fa fa-cog', '-1', 'order', '', '待收货订单', '110', 'status=30', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('55', '团长', './index.php?c=site&a=entry&do=head&m=group_buy', '0', 'fa fa-male', '1', 'head', '', '团长管理', '22', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('54', '小区列表', './index.php?c=site&a=entry&do=district&m=group_buy', '55', 'fa fa-cog', '1', 'district', 'village', '', '25', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('53', '区域', './index.php?c=site&a=entry&do=district&m=group_buy', '0', 'fa fa-map', '-1', 'district', '', '区域管理', '20', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('52', '商品分类', './index.php?c=site&a=entry&op=cate&do=goods&m=group_buy', '50', 'fa fa-cog', '1', 'goods', 'cate', '', '19', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('51', '商品列表', './index.php?c=site&a=entry&do=goods&m=group_buy', '50', 'fa fa-cog', '1', 'goods', 'index', '', '18', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('50', '商品', './index.php?c=site&a=entry&do=goods&m=group_buy', '0', 'fa fa-gift', '1', 'goods', '', '商品管理', '7', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('49', '广告列表', './index.php?c=site&a=entry&do=adv&m=group_buy', '48', 'fa fa-cog', '-1', 'adv', 'index', '', '16', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('48', '广告', './index.php?c=site&a=entry&do=adv&m=group_buy', '0', 'fa fa-audio-description', '-1', 'adv', '', '广告管理', '39', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('46', '订单列表', './index.php?c=site&a=entry&op=index&do=order&m=group_buy&status=20', '42', 'fa fa-cog', '1', 'order', 'index', '全部订单', '130', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('45', '已完成', './index.php?c=site&a=entry&status=100&do=order&m=group_buy', '42', 'fa fa-cog', '-1', 'order', '', '已完成订单', '120', 'status=100', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('39', '版权设置', './index.php?c=site&a=entry&op=copyright_diy&do=diy&m=group_buy', '34', 'fa fa-cog', '-1', 'diy', 'copyright_diy', '版权设置', '33', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('38', '顶部设置', './index.php?c=site&a=entry&op=top_diy&do=diy&m=group_buy', '34', 'fa fa-cog', '-1', 'diy', 'top_diy', '顶部设置', '5', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('37', '底部设置', './index.php?c=site&a=entry&op=bottom_diy&do=diy&m=group_buy', '34', 'fa fa-cog', '-1', 'diy', 'bottom_diy', '底部设置', '4', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('36', '首页管理', './index.php?c=site&a=entry&op=index_diy&do=diy&m=group_buy', '34', 'fa fa-cog', '1', 'diy', 'index_diy', '首页管理', '2', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('34', '页面', './index.php?c=site&a=entry&do=diy&m=group_buy', '0', 'fa fa-clone', '1', 'diy', 'index', '页面管理', '1', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('35', '我的模版', './index.php?c=site&a=entry&do=diy&op=index&m=group_buy', '34', 'fa fa-cog', '1', 'diy', 'index', '我的模版', '3', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('78', '路线管理', './index.php?c=site&a=entry&op=route&do=distribution&m=group_buy', '75', 'fa fa-cog', '1', 'distribution', 'route', '', '45', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('79', '营销', './index.php?c=site&a=entry&do=plug&m=group_buy', '0', 'fa fa-plug', '1', 'plug', '', '插件管理', '46', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('82', '概览', './index.php?c=site&a=entry&do=overview&m=group_buy', '0', 'fa fa-tachometer', '1', 'overview', '', '概览', '-1', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('84', '交易流水', './index.php?c=site&a=entry&do=finance&op=stream_index&m=group_buy', '72', 'fa fa-cog', '1', 'finance', 'stream_index', '交易流水', '50', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('87', '供应商设置', './index.php?c=site&a=entry&op=config&do=supplier&m=group_buy', '58', 'fa fa-cog', '1', 'supplier', 'config', '供应商设置', '65', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('88', '商品页设置', './index.php?c=site&a=entry&op=config&do=goods&m=group_buy', '50', 'fa fa-cog', '1', 'goods', 'config', '商品页设置', '70', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('91', '模版市场', './index.php?c=site&a=entry&do=diy&op=index_system&m=group_buy', '34', 'fa fa-cog', '1', 'diy', 'index_system', '模版市场', '3', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('90', '版权设置', './index.php?c=site&a=entry&op=copyright&do=diy&m=group_buy', '34', 'fa fa-cog', '1', 'diy', 'copyright', '版权设置', '34', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('92', '售后订单', './index.php?c=site&a=entry&op=afterSale&do=order&m=group_buy', '42', 'fa fa-cog', '1', 'order', 'afterSale', '售后订单', '135', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('93', '物流配置', './index.php?c=site&a=entry&do=config&op=express&m=group_buy', '64', 'fa fa-cog', '1', 'config', 'express', '物流配置', '155', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('94', '快递管理', './index.php?c=site&a=entry&do=config&op=express_tmp&m=group_buy', '64', 'fa fa-cog', '1', 'config', 'express_tmp', '快递管理', '160', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('95', '运费模版', './index.php?c=site&a=entry&do=config&op=shipping&m=group_buy', '64', 'fa fa-cog', '1', 'config', 'shipping', '运费模版', '165', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('96', '满减', './index.php?c=site&a=entry&do=action&m=group_buy&op=reduction', '40', 'fa fa-cog', '2', 'action', 'reduction', '', '10', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('97', '首页海报设置', './index.php?c=site&a=entry&do=diy&op=index_playbill&m=group_buy', '34', 'fa fa-cog', '1', 'diy', 'index_playbill', '首页海报设置', '33', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('98', '团长推广设置', './index.php?c=site&a=entry&op=recommend_config&do=head&m=group_buy', '55', 'fa fa-cog', '2', 'head', 'recommend_config', '团长推广设置', '170', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('99', '充值返利', './index.php?c=site&a=entry&do=member&m=group_buy&op=recharge_rebate', '60', 'fa fa-cog', '2', 'member', 'recharge_rebate', '充值返利', '100', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('100', '会员设置', './index.php?c=site&a=entry&do=member&m=group_buy&op=config', '60', 'fa fa-cog', '2', 'member', 'config', '会员设置', '150', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('101', '通用券', './index.php?c=site&a=entry&do=market&m=group_buy&op=add', '40', 'fa fa-cog', '2', 'action', 'add', '通用卷', '100', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('102', '分类券', './index.php?c=site&a=entry&do=market&m=group_buy&op=cate', '40', 'fa fa-cog', '2', 'action', 'cate', '分类卷', '110', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('103', '单品券', './index.php?c=site&a=entry&do=market&m=group_buy&op=only_goods', '40', 'fa fa-cog', '2', 'action', 'only_goods', '单品卷', '120', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('104', '指定发送', './index.php?c=site&a=entry&do=market&m=group_buy&op=point', '40', 'fa fa-cog', '2', 'action', 'point', '指定卷', '130', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('105', '新人券', './index.php?c=site&a=entry&do=market&m=group_buy&op=new_member', '40', 'fa fa-cog', '2', 'action', 'new_member', '新人卷', '140', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('106', '发放记录', './index.php?c=site&a=entry&do=market&m=group_buy&op=record', '40', 'fa fa-cog', '2', 'action', 'record', '发放记录', '90', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('107', '公众号', './index.php?c=site&a=entry&do=wechat&m=group_buy&op=index', '64', 'fa fa-cog', '1', 'wechat', 'index', '公众号', '166', '', '2');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('108', '营销', './index.php?c=site&a=entry&do=markrting&m=group_buy&op=index', '0', 'fa fa-rmb', '2', 'markrting', 'index', '营销管理', '177', '', '2');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('109', '会员充值', './index.php?c=site&a=entry&do=markrting&m=group_buy&op=index', '108', 'fa fa-cog', '1', 'markrting', 'index', '', '178', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('110', '会员充值', './index.php?c=site&a=entry&do=markrting&m=group_buy&op=bannel', '64', 'fa fa-cog', '2', 'markrting', 'bannel', '', '167', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('111', '会员卡', './index.php?c=site&a=entry&do=card&m=group_buy&op=member_card', '108', 'fa fa-cog', '1', 'card', 'member_card', '', '180', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('113', '充值订单', './index.php?c=site&a=entry&do=markrting&m=group_buy&op=markrting_recharge', '108', 'fa fa-cog', '1', 'markrting', 'markrting_recharge', '', '179', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('112', '会员卡管理', './index.php?c=site&a=entry&do=card&m=group_buy', '64', 'fa fa-cog', '2', 'card', 'index', '', '168', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('114', '充值记录', './index.php?c=site&a=entry&do=member&m=group_buy&op=recharge_record', '72', 'fa fa-cog', '1', 'member', 'recharge_record', '', '188', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('115', '签到规则', './index.php?c=site&a=entry&op=sign&do=plsugins&m=group_buy', '116', 'fa fa-cog', '1', 'sign', 'index', '', '189', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('116', '插件管理', '1', '0', 'fa fa-cog', '1', 'sign,markrting,card,reduction,market,extension,recharge', 'plsugins', '插件管理', '190', '', '2');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('117', '签到记录', './index.php?c=site&a=entry&op=sign&in=list&do=plsugins&m=group_buy', '116', 'fa fa-cog', '1', 'sign', 'list', '', '191', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('118', '会员充值', './index.php?c=site&a=entry&do=plsugins&m=group_buy&op=markrting', '116', 'fa fa-cog', '1', 'markrting', 'index', '', '192', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('120', '会员卡', './index.php?c=site&a=entry&do=plsugins&m=group_buy&op=card&in=member_card', '116', 'fa fa-cog', '1', 'card', 'member_card', '', '194', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('119', '充值订单', './index.php?c=site&a=entry&do=plsugins&m=group_buy&op=markrting&in=markrting_recharge', '116', 'fa fa-cog', '1', 'markrting', 'markrting_recharge', '', '193', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('121', '充值配置', './index.php?c=site&a=entry&do=plsugins&m=group_buy&op=markrting&in=bannel', '116', 'fa fa-cog', '1', 'markrting', 'bannel', '', '195', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('122', '会员卡配置', './index.php?c=site&a=entry&do=plsugins&m=group_buy&op=card', '116', 'fa fa-cog', '1', 'card', 'index', '', '196', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('123', '满减', './index.php?c=site&a=entry&do=plsugins&m=group_buy&op=reduction&in=reduction', '116', 'fa fa-cog', '1', 'reduction', 'reduction', '', '197', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('124', '优惠券列表 ', './index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=coupon', '116', 'fa fa-cog', '1', 'market', 'coupon', '', '198', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('125', '发放记录 ', './index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=record', '116', 'fa fa-cog', '1', 'market', 'record', '', '199', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('126', '通用券', './index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=add', '116', 'fa fa-cog', '1', 'market', 'add', '', '200', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('127', '分类券', './index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=cate', '116', 'fa fa-cog', '1', 'market', 'cate', '', '201', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('128', '单品券', './index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=only_goods', '116', 'fa fa-cog', '1', 'market', 'only_goods', '', '202', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('129', '指定发送 ', './index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=point', '116', 'fa fa-cog', '1', 'market', 'point', '', '203', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('130', '新人券', './index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=new_member', '116', 'fa fa-cog', '1', 'market', 'new_member', '', '204', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('131', '团长列表', './index.php?c=site&a=entry&op=extension&do=plsugins&m=group_buy', '116', 'fa fa-cog', '1', 'extension', 'index', '', '', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('132', '团长推广', './index.php?c=site&a=entry&op=extension&do=plsugins&m=group_buy&in=recommend_config', '116', 'fa fa-cog', '1', 'extension', 'recommend_config', '', '', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('133', '财务设置', './index.php?c=site&a=entry&do=finance&m=group_buy&op=config', '72', 'fa fa-cog', '1', 'finance', 'config', '财务设置', '200', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('134', '统计', './index.php?c=site&a=entry&do=plsugins&m=group_buy&op=markrting&in=gold', '116', 'fa fa-cog', '1', 'markrting', 'glod', '', '201', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('135', '会员卡订单', './index.php?c=site&a=entry&do=plsugins&m=group_buy&op=card&in=card_order', '116', 'fa fa-cog', '1', 'card', 'card_order', '', '200', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('136', '余额充值', './index.php?c=site&a=entry&op=recharge&in=index&do=plsugins&m=group_buy', '116', 'fa fa-cog', '1', 'recharge', 'index', '', '201', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('137', '充值订单', './index.php?c=site&a=entry&op=recharge&in=markrting_recharge&do=plsugins&m=group_buy', '116', 'fa fa-cog', '1', 'recharge', 'markrting_recharge', '', '202', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('138', '余额配置', './index.php?c=site&a=entry&op=recharge&in=bannel&do=plsugins&m=group_buy', '116', 'fa fa-cog', '1', 'recharge', 'bannel', '', '203', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('139', '内容管理', './index.php?c=site&a=entry&do=content&m=group_buy', '64', 'fa fa-cog', '1', 'content', 'index', '内容管理', '300', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('140', '内容列表', './index.php?c=site&a=entry&do=content&m=group_buy&op=index', '139', 'fa fa-cog', '1', 'content', 'index', '内容列表', '1', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('141', '内容分类', './index.php?c=site&a=entry&do=content&m=group_buy&op=class', '139', 'fa fa-cog', '1', 'content', 'class', '内容分类', '2', '', '1');
INSERT INTO `mmwl_gpb_menu_list` VALUES ('142', '用户中心', './index.php?c=site&a=entry&op=member_diys&do=diy&m=group_buy', '34', 'fa fa-cog', '1', 'diy', 'member_diys', '用户中心', '300', '', '1');

-- ----------------------------
-- Table structure for `mmwl_gpb_order`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_order`;
CREATE TABLE `mmwl_gpb_order` (
  `go_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单主键',
  `go_code` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '订单号',
  `go_gid` int(11) DEFAULT NULL COMMENT '商品id',
  `go_adress_id` int(11) DEFAULT NULL COMMENT '收获地址id',
  `go_vid` int(11) DEFAULT NULL COMMENT '小区id',
  `openid` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '用户关联id',
  `go_at_id` int(11) DEFAULT NULL COMMENT '活动id',
  `go_fdc_id` int(11) DEFAULT '0' COMMENT '优惠卷id',
  `go_team_openid` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '团长id',
  `go_status` tinyint(1) DEFAULT '3' COMMENT '订单状态10待付款20备货中30待核销40退款80核销审核过100交易完成',
  `go_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '订单添加时间',
  `go_pay_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '订单支付完成时间',
  `go_num` int(5) DEFAULT NULL COMMENT '购买数量',
  `go_all_old_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品总原价',
  `go_all_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品总售价',
  `go_fdc_price` decimal(10,2) DEFAULT '0.00' COMMENT '优惠卷优惠价',
  `go_real_price` decimal(10,2) DEFAULT '0.00' COMMENT '最终售价',
  `go_sure_code` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '核销码',
  `go_pay_type` tinyint(1) DEFAULT '1' COMMENT '支付类型 1微信支付',
  `go_buy_msg` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '买家留言',
  `go_comment` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '订单备注',
  `go_send_type` tinyint(1) DEFAULT '1' COMMENT '配送方式1门店自取 2 商家配送',
  `weid` int(11) DEFAULT NULL,
  `go_send_pay` decimal(10,2) DEFAULT '0.00' COMMENT '配送邮费',
  `go_is_del` tinyint(1) DEFAULT '1' COMMENT '订单是否删除',
  `go_commission` decimal(10,2) DEFAULT '0.00' COMMENT '订单佣金',
  `go_commission_num` smallint(3) DEFAULT '0' COMMENT '锁定佣金比例',
  `go_is_cash` tinyint(1) DEFAULT '-1' COMMENT '是否提现了-1审核中1未提先2已提现',
  `go_commission_comment` varchar(255) COLLATE utf8_bin DEFAULT '审核中' COMMENT '审核说明',
  `go_commission_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '分佣时间',
  `prepay_id` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '支付消息模版id',
  `go_send_goods_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '发货时间',
  `type` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '1' COMMENT '订单类型 1 普通购买订单 2.积分订单',
  `time1` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '发货时间',
  `time2` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '收货时间',
  `time3` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `points` varchar(20) COLLATE utf8_bin DEFAULT '1' COMMENT '是否已经计算积分了1没有2算了',
  `types` varchar(20) COLLATE utf8_bin DEFAULT '1' COMMENT '订单类型 1 普通购买订单 2.积分订单',
  `shipping_method` char(20) COLLATE utf8_bin NOT NULL COMMENT '快递简码',
  `shipping_no` char(100) COLLATE utf8_bin NOT NULL COMMENT '快递单号',
  `dispatchname` char(50) COLLATE utf8_bin NOT NULL COMMENT '快递公司名称',
  `express_time` char(15) COLLATE utf8_bin NOT NULL COMMENT '确定快递发货时间',
  `shipping_cha_time` char(15) COLLATE utf8_bin NOT NULL COMMENT '最近一次查询物流信息的时间点',
  `shipping_traces` text COLLATE utf8_bin COMMENT '物流信息',
  `go_reduce_stock` tinyint(1) DEFAULT '1' COMMENT '减少库存方式1支付后减2下单减少',
  `go_full_reduce_price` decimal(10,2) DEFAULT '0.00' COMMENT '满减活动减少的金额',
  `pay` int(3) DEFAULT NULL COMMENT '支付方式1.积分支付 2.积分+现金',
  `integral` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '支付的积分（在普通商品中就是积分抵扣了多少钱）',
  `limit` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '积分商品限制兑换数量(在普通商品中就是使用了几个积分)',
  `spec_type` varchar(255) COLLATE utf8_bin DEFAULT '20' COMMENT '库存计算方式 10 下单减库存 20 付款减库存',
  `go_send_price_status` tinyint(1) DEFAULT '1' COMMENT '是否计算了配送费给团长 1 没 2有',
  `go_balance_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额支付的钱',
  `go_release_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日返利用于支付的钱',
  `go_wx_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '微信支付的钱',
  `go_member_card_reduce` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用会员卡优惠的金额',
  `go_order_formid` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '下单模版消息Id',
  `go_send_formid` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '发货模版消息Id',
  `go_headget_formid` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '团长收货模版消息Id',
  `go_wx_price_all` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '微信第一次退款时存入，原本微信支付的价格，为了后续退款能成功',
  `go_card_money` varchar(255) COLLATE utf8_bin DEFAULT '0.00' COMMENT '会员卡优惠金额',
  `delivery_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '团长送货  送货时间',
  PRIMARY KEY (`go_id`),
  KEY `go_code` (`go_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3024 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_order_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_order_log`;
CREATE TABLE `mmwl_gpb_order_log` (
  `gol_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单操作记录表',
  `gol_uid` int(11) DEFAULT NULL COMMENT '操作人id',
  `gol_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '操作时间',
  `gol_comment` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '操作理由说明',
  `gol_des` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '操作描述',
  `gol_go_code` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '订单表中唯一订单号',
  `gol_status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `gol_u_name` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '操作人名称',
  `type` varchar(20) COLLATE utf8_bin DEFAULT '1' COMMENT '类型1.正常订单操作 2.跟积分相关订单操作',
  `intage` double(10,2) DEFAULT '0.00' COMMENT '积分',
  PRIMARY KEY (`gol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_order_snapshot`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_order_snapshot`;
CREATE TABLE `mmwl_gpb_order_snapshot` (
  `oss_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品交易快照表',
  `oss_go_id` int(11) DEFAULT NULL COMMENT '订单id',
  `oss_go_code` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '订单号',
  `oss_gid` int(11) DEFAULT NULL COMMENT '商品id',
  `oss_g_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品售价',
  `oss_g_old_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品原价',
  `oss_g_num` int(5) DEFAULT NULL COMMENT '购买数量',
  `oss_g_name` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '商品名称',
  `oss_g_icon` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '商品封面',
  `oss_g_brief` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '商品规格简介',
  `oss_ac_id` int(11) DEFAULT NULL COMMENT '活动id',
  `oss_ac_name` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '活动名称',
  `oss_v_id` int(11) DEFAULT NULL COMMENT '小区id',
  `oss_v_name` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '小区名称',
  `oss_head_openid` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '团长',
  `oss_head_name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '团长名称',
  `oss_head_phone` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '团长电话',
  `oss_buy_openid` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '买家',
  `oss_buy_name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '买家名称',
  `oss_buy_phone` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '买家电话',
  `oss_address_id` int(11) DEFAULT NULL COMMENT '收获地址id',
  `oss_address` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '收获地址',
  `oss_address_phone` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '收货人电话',
  `oss_address_name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '收货人姓名',
  `oss_total_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品小计',
  `oss_cart` int(11) DEFAULT NULL COMMENT '关联购物车',
  `oss_ggo_id` int(11) DEFAULT NULL COMMENT '规格参数erp表id',
  `oss_ggo_title` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '规格参数名称',
  `oss_ggo_status` smallint(5) DEFAULT '1' COMMENT '状态:1正常状态,40售后,50申请退款,60拒绝退款,70退款成功',
  `oss_commission_num` double(5,2) DEFAULT '0.00' COMMENT '佣金比例',
  `oss_commission` decimal(10,2) DEFAULT '0.00' COMMENT '该商品佣金',
  `oss_is_full_reduce` tinyint(1) DEFAULT '0' COMMENT '是否参与了满减0否1是',
  `oss_is_seckill` tinyint(1) DEFAULT '0' COMMENT '是否是秒杀 1',
  `oss_seckill_taskid` int(11) DEFAULT '0',
  `oss_seckill_roomid` int(11) DEFAULT '0',
  `oss_seckill_time` smallint(3) NOT NULL,
  `oss_seckill_task` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '秒杀专题名字',
  `oss_seckill_room` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '会场名称',
  `oss_seckill_timeid` int(11) NOT NULL DEFAULT '0',
  `oss_member_price` decimal(10,2) DEFAULT '0.00' COMMENT '会员价',
  PRIMARY KEY (`oss_id`),
  KEY `go_code` (`oss_go_code`),
  KEY `oss_head_openid` (`oss_head_openid`),
  KEY `oss_buy_openid` (`oss_buy_openid`),
  KEY `oss_go_code` (`oss_go_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_order_stream`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_order_stream`;
CREATE TABLE `mmwl_gpb_order_stream` (
  `gos_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单流水表主键',
  `gos_code` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '流水号',
  `gos_go_code` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '订单号',
  `gos_stream_type` smallint(3) DEFAULT '1' COMMENT '流水类型，1订单支付，2退款，3佣金，4提现',
  `gos_type` smallint(5) DEFAULT '1' COMMENT '类型 1收入 2支出',
  `gos_pay_type` smallint(3) DEFAULT '1' COMMENT '支付方式，1微信支付，2余额支付，3.余额和微信一起，4支付宝，5银联支付，6线下支付，7其他',
  `gos_owner` varchar(255) COLLATE utf8_bin DEFAULT '平台' COMMENT '流水归属者(收款方)',
  `gos_payer` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT 'o名字(平台用户)',
  `gos_team` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '团长信息(按需传入)',
  `gos_order_money` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额',
  `gos_real_money` decimal(10,2) DEFAULT '0.00' COMMENT '实收金额',
  `gos_status` tinyint(1) DEFAULT '1' COMMENT '状态1生成流水,-1支付失败,2成功',
  `gos_commet` varchar(500) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `gos_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '新增时间',
  `gos_sure_pay_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '确认支付/到账时间',
  `gos_two_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '第二次生成流水时间',
  `weid` int(11) DEFAULT NULL,
  `gos_payer_openid` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '另一方用户openid',
  `gos_owner_openid` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '归属方openid',
  `gos_team_openid` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '团长openid',
  `gos_wx_pay` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '微信支付的金额',
  `gos_release_pay` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日返利支付的金额',
  `gos_balance_pay` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额值的金额',
  PRIMARY KEY (`gos_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_package_goods`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_package_goods`;
CREATE TABLE `mmwl_gpb_package_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `goodsid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `option` varchar(255) NOT NULL,
  `goodssn` varchar(255) NOT NULL,
  `productsn` varchar(255) NOT NULL,
  `hasoption` tinyint(3) NOT NULL DEFAULT '0',
  `marketprice` decimal(10,2) DEFAULT '0.00',
  `packageprice` decimal(10,2) DEFAULT '0.00',
  `commission1` decimal(10,2) DEFAULT '0.00',
  `commission2` decimal(10,2) DEFAULT '0.00',
  `commission3` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for `mmwl_gpb_package_goods_option`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_package_goods_option`;
CREATE TABLE `mmwl_gpb_package_goods_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `goodsid` int(11) NOT NULL DEFAULT '0',
  `optionid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `packageprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `marketprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `commission1` decimal(10,2) NOT NULL DEFAULT '0.00',
  `commission2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `commission3` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for `mmwl_gpb_plug`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_plug`;
CREATE TABLE `mmwl_gpb_plug` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '插件表主键',
  `cate` tinyint(3) DEFAULT '0' COMMENT '分类相关',
  `name` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '插件名称',
  `add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '新增时间',
  `icon` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '图标',
  `comment` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '备注',
  `plug_order` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态',
  `is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除',
  `key` char(50) COLLATE utf8_bin DEFAULT '' COMMENT '自定义key用来简单索引',
  `url` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT 'url',
  `buy_url` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '微擎商城购买路径',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_plug 
-- ----------------------------
INSERT INTO `mmwl_gpb_plug` VALUES ('3', '0', '整点秒杀', '', '/addons/group_buy/public/bg/seckill.png', '', '3', '1', '1', 'group_buy_plugin_seckill', './index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_seckill&version_id=0', 'https://s.w7.cc/module-19790.html');
INSERT INTO `mmwl_gpb_plug` VALUES ('1', '0', '积分商城', '', '/addons/group_buy/public/bg/fraction.png', '', '1', '1', '1', 'group_buy_plugin_fraction', './index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_fraction&version_id=0', 'https://s.w7.cc/module-17917.html');
INSERT INTO `mmwl_gpb_plug` VALUES ('2', '0', '分销商城', '', '/addons/group_buy/public/bg/distribution.png', '', '2', '1', '1', 'group_buy_plugin_distribution', './index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_distribution&version_id=0', 'https://s.w7.cc/module-18137.html');

-- ----------------------------
-- Table structure for `mmwl_gpb_receiving_address`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_receiving_address`;
CREATE TABLE `mmwl_gpb_receiving_address` (
  `ra_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '收货地址表主键',
  `openid` char(50) COLLATE utf8_bin DEFAULT NULL,
  `ra_name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '收货人姓名',
  `ra_phone` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '收货人电话',
  `ra_province` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '关联省名',
  `ra_city` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '关联市名',
  `ra_area` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '关联区名',
  `ra_info` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '详细地址',
  `ra_mail_code` int(7) DEFAULT NULL COMMENT '邮编',
  `ra_is_default` tinyint(1) DEFAULT '-1' COMMENT '是否默认 1是 -1否',
  `ra_is_del` tinyint(1) DEFAULT '-1' COMMENT '是否删除 1是 -1否',
  `ra_all_address` varchar(300) COLLATE utf8_bin DEFAULT NULL COMMENT '拼接后详细地址',
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`ra_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_recharge`;
CREATE TABLE `mmwl_gpb_recharge` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '余额充值',
  `title` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `money` double(10,2) DEFAULT '0.00' COMMENT '充值金额',
  `release_gold` int(2) DEFAULT '1' COMMENT '赠送金额是否是释放金1.是2.不是（不是释放金，每天的返钱将返到用户的余额里面去，并且不过期）',
  `release` int(8) DEFAULT '0' COMMENT '释放天数，为0代表不需要释放天数，用户充值就将钱直接返给用户',
  `release_money` double(10,2) DEFAULT '0.00' COMMENT '每天释放金额',
  `overde` int(2) DEFAULT '1' COMMENT '释放金额是否当天过期 1.过期2.不过期',
  `weight` int(8) DEFAULT '0' COMMENT '等级权重  数字越大  越重',
  `status` int(2) DEFAULT '1',
  `create_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '添加时间',
  `weid` int(8) DEFAULT '0',
  `give_money` double(10,2) DEFAULT '0.00' COMMENT '赠送金额',
  `give_integral` int(8) DEFAULT '0' COMMENT '赠送积分',
  `give_level` int(8) DEFAULT '0' COMMENT '赠送等级',
  `give_level_time` varchar(255) COLLATE utf8_bin DEFAULT '0' COMMENT '等级天数',
  `bj` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '背景图片',
  `lv1` double(10,2) DEFAULT '0.00' COMMENT '国定金额分销佣金',
  `lv2` double(10,2) DEFAULT '0.00',
  `lv3` double(10,2) DEFAULT '0.00',
  `content` text COLLATE utf8_bin NOT NULL,
  `recharge_type` int(2) NOT NULL DEFAULT '1' COMMENT '1充值返利 2充值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_recharge_info`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_recharge_info`;
CREATE TABLE `mmwl_gpb_recharge_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '余额充值详情',
  `uid` int(11) DEFAULT '0' COMMENT '会员id',
  `time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '下单时间',
  `recharge_id` int(8) DEFAULT '0' COMMENT '充值id',
  `recharge_status` int(2) DEFAULT '1' COMMENT '充值状态',
  `recharge_money` double(10,2) DEFAULT '0.00' COMMENT '充值金额',
  `status` int(2) DEFAULT '1',
  `weid` int(8) DEFAULT '0',
  `end_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '结束日期',
  `order_code` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '订单号',
  `pay_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '支付时间',
  `pay_code` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '支付成功 生成的模板消息id',
  `openid` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'openid',
  `pay_code_num` int(2) DEFAULT '0' COMMENT '模板消息id使用次数',
  `pay_status` int(3) DEFAULT '10' COMMENT '支付状态10待支付20成功成功',
  `recharge_type` int(2) DEFAULT '1' COMMENT '1.返利 2.充值',
  `rebate_create_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '开始返利时间',
  `rebate_end_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '结束返利时间',
  `rebate_money` double(10,2) DEFAULT '0.00' COMMENT '每天返利金额',
  `rebate_total_money` double(10,2) DEFAULT '0.00' COMMENT '总返利金额',
  `give_money` double(10,2) DEFAULT '0.00' COMMENT '充值赠送金额',
  `cleraing` int(2) DEFAULT '1' COMMENT '是否清零',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_recharge_list`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_recharge_list`;
CREATE TABLE `mmwl_gpb_recharge_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '返利详情',
  `uid` int(8) DEFAULT '0',
  `time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '时间',
  `money` double(10,2) DEFAULT '0.00' COMMENT '金额',
  `list_type` int(2) DEFAULT '1' COMMENT '使用状态1.未使用2.也使用3.已过期',
  `use_money` double(10,2) DEFAULT '0.00' COMMENT '已使用多少金额',
  `status` int(2) DEFAULT '1',
  `openid` varchar(255) COLLATE utf8_bin NOT NULL,
  `recharge_id` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '充值id',
  `overdue` int(2) DEFAULT '1' COMMENT '是否需要过期1过期2不过期',
  `reason` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '使用或者过期原因',
  `weid` int(8) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_recharge_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_recharge_log`;
CREATE TABLE `mmwl_gpb_recharge_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志信息',
  `uid` int(8) DEFAULT '0' COMMENT '关联id，有可能关联的是订单，也有可能是其他',
  `openid` varchar(255) COLLATE utf8_bin NOT NULL,
  `info` text COLLATE utf8_bin NOT NULL COMMENT '操作信息',
  `type` int(7) DEFAULT '1' COMMENT '类型 uid需要根据这个来进行判断',
  `status` int(2) DEFAULT '1',
  `create_time` varchar(255) COLLATE utf8_bin NOT NULL,
  `weid` int(8) DEFAULT '0',
  `money` double(10,2) DEFAULT '0.00',
  `l_type` int(2) DEFAULT '1',
  `st` int(2) DEFAULT '1' COMMENT '1.加2.减',
  `remarks` text COLLATE utf8_bin NOT NULL COMMENT '备注',
  `pay_f` int(2) DEFAULT '1' COMMENT '1.微信2.后台',
  `ltime` varchar(255) COLLATE utf8_bin DEFAULT '0' COMMENT '具体返利时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_region`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_region`;
CREATE TABLE `mmwl_gpb_region` (
  `rg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '区域ID',
  `rg_name` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '区域名称',
  `rg_province_id` int(11) DEFAULT NULL COMMENT '省ID',
  `rg_city_id` int(11) DEFAULT NULL COMMENT '城市ID',
  `rg_area_id` int(11) DEFAULT NULL COMMENT '区ID',
  `rg_add_time` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `rg_update_time` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '更新时间',
  `rg_status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1',
  `rg_order` int(11) DEFAULT NULL COMMENT '排序',
  `weid` int(11) DEFAULT NULL COMMENT '模块ID',
  `rg_all_area` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '拼接完整的省市区',
  PRIMARY KEY (`rg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_send_ticket_set`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_send_ticket_set`;
CREATE TABLE `mmwl_gpb_send_ticket_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL COMMENT '模块',
  `cpid` varchar(200) NOT NULL COMMENT '优惠卷id',
  `expiration` int(11) NOT NULL DEFAULT '0' COMMENT '有效期',
  `starttime` int(11) DEFAULT NULL COMMENT '开始时间',
  `endtime` int(11) DEFAULT NULL COMMENT '结束时间',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `createtime` int(11) NOT NULL COMMENT '新增时间',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `sendnum` int(11) NOT NULL COMMENT '发送数量',
  `headopenid` varchar(50) NOT NULL DEFAULT '' COMMENT '团长id',
  `type` smallint(5) NOT NULL DEFAULT '1' COMMENT '类型1指定用户2全部发送3按分销商4按会员等级5按代理...',
  `updatetime` int(11) NOT NULL COMMENT '修改时间',
  `is_show_index` tinyint(1) NOT NULL DEFAULT '2' COMMENT '是否首页提示1是2不是',
  `value` text COMMENT '值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_gpb_shop_seckill_adv`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_shop_seckill_adv`;
CREATE TABLE `mmwl_gpb_shop_seckill_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0' COMMENT '模块',
  `advname` varchar(50) DEFAULT '' COMMENT '名称',
  `link` varchar(255) DEFAULT '' COMMENT '链接',
  `thumb` varchar(255) DEFAULT '' COMMENT '图册',
  `displayorder` int(11) DEFAULT '0' COMMENT '顺序',
  `enabled` int(11) DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `idx_displayorder` (`displayorder`) USING BTREE,
  KEY `idx_enabled` (`enabled`) USING BTREE,
  KEY `idx_uniacid` (`uniacid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for `mmwl_gpb_shop_seckill_category`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_shop_seckill_category`;
CREATE TABLE `mmwl_gpb_shop_seckill_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0' COMMENT '模块',
  `name` varchar(255) DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for `mmwl_gpb_shop_seckill_task`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_shop_seckill_task`;
CREATE TABLE `mmwl_gpb_shop_seckill_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0' COMMENT '模块',
  `cateid` int(11) DEFAULT '0' COMMENT '分类',
  `title` varchar(255) DEFAULT '' COMMENT '标题',
  `enabled` tinyint(3) DEFAULT '0' COMMENT '状态',
  `page_title` varchar(255) DEFAULT '' COMMENT '页面标题',
  `share_title` varchar(255) DEFAULT '' COMMENT '分享标题',
  `share_desc` varchar(255) DEFAULT '' COMMENT '分享描述',
  `share_icon` varchar(255) DEFAULT '' COMMENT '分享图',
  `tag` varchar(10) DEFAULT '' COMMENT '标签',
  `closesec` int(11) DEFAULT '0' COMMENT '关闭',
  `oldshow` tinyint(3) DEFAULT '0',
  `times` text,
  `createtime` int(11) DEFAULT '0' COMMENT '创建时间',
  `overtimes` tinyint(2) DEFAULT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`) USING BTREE,
  KEY `idx_status` (`enabled`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for `mmwl_gpb_shop_seckill_task_goods`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_shop_seckill_task_goods`;
CREATE TABLE `mmwl_gpb_shop_seckill_task_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  `roomid` int(11) DEFAULT '0',
  `timeid` int(11) DEFAULT '0',
  `goodsid` int(11) DEFAULT '0',
  `optionid` int(11) DEFAULT '0',
  `price` decimal(10,2) DEFAULT '0.00',
  `total` int(11) DEFAULT '0',
  `maxbuy` int(11) DEFAULT '0',
  `totalmaxbuy` int(11) DEFAULT '0',
  `commission1` decimal(10,2) DEFAULT '0.00',
  `commission2` decimal(10,2) DEFAULT '0.00',
  `commission3` decimal(10,2) DEFAULT '0.00',
  `arrival_time` smallint(3) DEFAULT '1',
  `sale_num` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`) USING BTREE,
  KEY `idx_goodsid` (`goodsid`) USING BTREE,
  KEY `idx_optionid` (`optionid`) USING BTREE,
  KEY `idx_displayorder` (`displayorder`) USING BTREE,
  KEY `idx_taskid` (`taskid`) USING BTREE,
  KEY `idx_roomid` (`roomid`) USING BTREE,
  KEY `idx_time` (`timeid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Table structure for `mmwl_gpb_shop_seckill_task_room`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_shop_seckill_task_room`;
CREATE TABLE `mmwl_gpb_shop_seckill_task_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `enabled` tinyint(3) DEFAULT '0',
  `page_title` varchar(255) DEFAULT '',
  `share_title` varchar(255) DEFAULT '',
  `share_desc` varchar(255) DEFAULT '',
  `share_icon` varchar(255) DEFAULT '',
  `oldshow` tinyint(3) DEFAULT '0',
  `tag` varchar(10) DEFAULT '',
  `createtime` int(11) DEFAULT '0',
  `diypage` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_taskid` (`taskid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for `mmwl_gpb_shop_seckill_task_time`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_shop_seckill_task_time`;
CREATE TABLE `mmwl_gpb_shop_seckill_task_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  `time` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Table structure for `mmwl_gpb_spec_item`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_spec_item`;
CREATE TABLE `mmwl_gpb_spec_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `specid` int(11) DEFAULT NULL COMMENT 'goods_spec表id',
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '标题',
  `show` int(2) DEFAULT NULL COMMENT '是否使用',
  `credit` int(11) DEFAULT NULL COMMENT '兑换积分',
  `number` int(11) DEFAULT NULL COMMENT '库存',
  `createtime` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT ' 建立时间',
  `status` int(2) DEFAULT '1' COMMENT '状态',
  `weid` int(11) DEFAULT '1' COMMENT '模块id',
  `money` double(10,2) DEFAULT NULL COMMENT '支付金额（如果金额存在就代表这个礼品是采用积分加金额的兑换方式）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_supplier`;
CREATE TABLE `mmwl_gpb_supplier` (
  `gsp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `openid` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '申请人微信',
  `weid` int(11) DEFAULT NULL,
  `gsp_status` smallint(3) DEFAULT '1' COMMENT '状态 -1申请未处理1正常 2冻结',
  `gsp_name` char(100) COLLATE utf8_bin DEFAULT NULL COMMENT '负责人名称',
  `gsp_shop_name` char(100) COLLATE utf8_bin DEFAULT NULL COMMENT '供应商店铺名称',
  `gsp_phone` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '负责人电话',
  `gsp_comment` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `gsp_is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除',
  `gsp_icon` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '品牌LOgo2',
  `gsp_story` text COLLATE utf8_bin COMMENT '品牌故事2',
  `gsp_brief` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '供应商简介2',
  `gsp_like_people` int(8) DEFAULT NULL COMMENT '供应商喜爱程度2关注度',
  `gsp_sale_num` int(11) DEFAULT NULL COMMENT '供应商累计销量2',
  `gsp_bg_img` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '品牌背景图2',
  `gsp_brand_name` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '品牌名称2',
  `gsp_order` int(11) DEFAULT NULL COMMENT '排序',
  `gsp_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '新增时间',
  `gsp_update_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
  `gsp_apply_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '申请时间',
  `gsp_deal_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '处理时间',
  `gsp_server_fee` decimal(10,2) DEFAULT '0.00' COMMENT '技术服务费',
  `gsp_type` tinyint(1) DEFAULT '1' COMMENT '服务商类型 2独立供应商 1平台供应商',
  `gsp_account` char(30) COLLATE utf8_bin NOT NULL COMMENT '登录帐号',
  `gsp_pwd` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '登录密码',
  `gsp_last_login_time` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '最后一次登录时间',
  `gsp_last_ip` char(25) COLLATE utf8_bin DEFAULT NULL COMMENT '最后登录ip',
  `uid` int(11) NOT NULL COMMENT '用户在微擎中的UID',
  PRIMARY KEY (`gsp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_supplier_manger`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_supplier_manger`;
CREATE TABLE `mmwl_gpb_supplier_manger` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `openid` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '用户openid',
  `m_id` int(11) DEFAULT NULL COMMENT '用户id',
  `gsp_id` int(11) DEFAULT NULL COMMENT '供应商id',
  `weid` int(11) NOT NULL COMMENT 'weid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_sure_order`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_sure_order`;
CREATE TABLE `mmwl_gpb_sure_order` (
  `so_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '核销表id',
  `so_code` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '唯一核销码',
  `so_buy_people` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '购买人openid',
  `so_sure_people` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '核销人openid',
  `so_add_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '核销时间',
  `so_is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除 -1是 1否',
  `so_status` tinyint(1) DEFAULT '-1' COMMENT '-1未核销/1已核销',
  `we_id` int(11) DEFAULT NULL,
  `so_buy_name` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '购买人名称',
  `so_sure_name` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '核销人名称',
  `so_go_code` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '订单号',
  PRIMARY KEY (`so_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_team_cancel_goods`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_team_cancel_goods`;
CREATE TABLE `mmwl_gpb_team_cancel_goods` (
  `tcg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团长不开启的活动商品记录表',
  `openid` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '团长id',
  `tcg_at_g_id` int(11) NOT NULL COMMENT '活动商品表id',
  PRIMARY KEY (`tcg_id`,`tcg_at_g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_ticket`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_ticket`;
CREATE TABLE `mmwl_gpb_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '优惠券配置表',
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `type` int(3) NOT NULL DEFAULT '1' COMMENT '类型 1满减劵，2优惠券，3赠点券，4充值代金券，5分类卷，6单品卷',
  `use_limit` double(9,2) NOT NULL DEFAULT '0.00' COMMENT '使用最低金额限制',
  `cut_price` double(9,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `grant_type` int(3) NOT NULL DEFAULT '1' COMMENT '发放方式 1注册送，2分享送，3发放领取',
  `share_num` int(5) DEFAULT NULL,
  `start_time` char(11) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '使用有效开始时间',
  `end_time` char(11) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '使用有效结束时间',
  `over_time` int(3) NOT NULL DEFAULT '0' COMMENT '领取后N天过期',
  `number` int(10) NOT NULL DEFAULT '0' COMMENT '发放数量',
  `now_num` int(11) DEFAULT '0' COMMENT '已发放数量',
  `link` varchar(200) COLLATE utf8_bin DEFAULT NULL COMMENT '领取链接',
  `is_vip` int(2) NOT NULL DEFAULT '0' COMMENT '是否VIP每月领取',
  `create_time` char(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` char(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `weid` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `num_limit` tinyint(3) DEFAULT '1' COMMENT '限制每人领取数量',
  `is_index_show` tinyint(1) DEFAULT '-1' COMMENT '是否首页显示',
  `limitgoodtype` tinyint(1) NOT NULL DEFAULT '2' COMMENT '限制单品开关1开 2 关',
  `limitgoodids` varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '现在单品id',
  `limitgoodcatetype` tinyint(1) NOT NULL DEFAULT '2' COMMENT '限制分类开关1开 2 关',
  `limitgoodcateids` varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '现在分类id',
  `use_notice` text COLLATE utf8_bin NOT NULL COMMENT '使用说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_user_ticket`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_user_ticket`;
CREATE TABLE `mmwl_gpb_user_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户优惠券',
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `grant_time` varchar(11) COLLATE utf8_bin NOT NULL COMMENT '领取时间',
  `is_use` int(2) NOT NULL DEFAULT '0',
  `is_over` int(2) NOT NULL DEFAULT '0',
  `over_time` varchar(11) COLLATE utf8_bin DEFAULT NULL COMMENT '过期时间',
  `create_time` char(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` char(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(2) NOT NULL DEFAULT '1',
  `weid` int(11) DEFAULT NULL,
  `openid` char(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_gpb_village`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_gpb_village`;
CREATE TABLE `mmwl_gpb_village` (
  `vg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '小区主键ID',
  `vg_name` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '小区名称',
  `vg_rg_id` int(11) DEFAULT NULL COMMENT '关联区域ID',
  `vg_team_name` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '店铺/团体名称',
  `vg_address` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '详细地址',
  `vg_longitude` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '详细地址经度',
  `vg_latitude` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '详细地址纬度',
  `vg_add_time` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `vg_update_time` char(20) COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
  `vg_status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `vg_pick_address` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '自取地址（可能和小区地址不一致）',
  `vg_order` int(11) DEFAULT NULL COMMENT '排序',
  `weid` int(11) DEFAULT NULL COMMENT '模块ID',
  `openid` char(50) COLLATE utf8_bin NOT NULL COMMENT '团长的openid',
  PRIMARY KEY (`vg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for `mmwl_images_reply`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_images_reply`;
CREATE TABLE `mmwl_images_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_job`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_job`;
CREATE TABLE `mmwl_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `payload` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `title` varchar(22) NOT NULL,
  `handled` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_cash_record`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_cash_record`;
CREATE TABLE `mmwl_mc_cash_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `clerk_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `clerk_type` tinyint(3) unsigned NOT NULL,
  `fee` decimal(10,2) unsigned NOT NULL,
  `final_fee` decimal(10,2) unsigned NOT NULL,
  `credit1` int(10) unsigned NOT NULL,
  `credit1_fee` decimal(10,2) unsigned NOT NULL,
  `credit2` decimal(10,2) unsigned NOT NULL,
  `cash` decimal(10,2) unsigned NOT NULL,
  `return_cash` decimal(10,2) unsigned NOT NULL,
  `final_cash` decimal(10,2) unsigned NOT NULL,
  `remark` varchar(255) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `trade_type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_chats_record`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_chats_record`;
CREATE TABLE `mmwl_mc_chats_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `flag` tinyint(3) unsigned NOT NULL,
  `openid` varchar(32) NOT NULL,
  `msgtype` varchar(15) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`acid`),
  KEY `openid` (`openid`),
  KEY `createtime` (`createtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_credits_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_credits_recharge`;
CREATE TABLE `mmwl_mc_credits_recharge` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `tid` varchar(64) NOT NULL,
  `transid` varchar(30) NOT NULL,
  `fee` varchar(10) NOT NULL,
  `type` varchar(15) NOT NULL,
  `tag` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `backtype` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid_uid` (`uniacid`,`uid`),
  KEY `idx_tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_credits_record`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_credits_record`;
CREATE TABLE `mmwl_mc_credits_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `uniacid` int(11) NOT NULL,
  `credittype` varchar(10) NOT NULL,
  `num` decimal(10,2) NOT NULL,
  `operator` int(10) unsigned NOT NULL,
  `module` varchar(30) NOT NULL,
  `clerk_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `clerk_type` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `remark` varchar(200) NOT NULL,
  `real_uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_fans_groups`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_fans_groups`;
CREATE TABLE `mmwl_mc_fans_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `groups` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_fans_tag`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_fans_tag`;
CREATE TABLE `mmwl_mc_fans_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `fanid` int(11) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `subscribe` int(11) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `headimgurl` varchar(150) DEFAULT NULL,
  `subscribe_time` int(11) NOT NULL,
  `unionid` varchar(100) DEFAULT NULL,
  `remark` varchar(250) DEFAULT NULL,
  `groupid` varchar(100) DEFAULT NULL,
  `tagid_list` varchar(250) DEFAULT NULL,
  `subscribe_scene` varchar(100) DEFAULT NULL,
  `qr_scene_str` varchar(250) DEFAULT NULL,
  `qr_scene` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fanid` (`fanid`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_fans_tag_mapping`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_fans_tag_mapping`;
CREATE TABLE `mmwl_mc_fans_tag_mapping` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fanid` int(11) unsigned NOT NULL,
  `tagid` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mapping` (`fanid`,`tagid`),
  KEY `fanid_index` (`fanid`),
  KEY `tagid_index` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_groups`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_groups`;
CREATE TABLE `mmwl_mc_groups` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `credit` int(10) unsigned NOT NULL,
  `isdefault` tinyint(4) NOT NULL,
  PRIMARY KEY (`groupid`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_mc_groups 
-- ----------------------------
INSERT INTO `mmwl_mc_groups` VALUES ('1', '1', '默认会员组', '0', '1');

-- ----------------------------
-- Table structure for `mmwl_mc_handsel`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_handsel`;
CREATE TABLE `mmwl_mc_handsel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `touid` int(10) unsigned NOT NULL,
  `fromuid` varchar(32) NOT NULL,
  `module` varchar(30) NOT NULL,
  `sign` varchar(100) NOT NULL,
  `action` varchar(20) NOT NULL,
  `credit_value` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`touid`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_mapping_fans`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_mapping_fans`;
CREATE TABLE `mmwl_mc_mapping_fans` (
  `fanid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `groupid` varchar(60) NOT NULL,
  `salt` char(8) NOT NULL,
  `follow` tinyint(1) unsigned NOT NULL,
  `followtime` int(10) unsigned NOT NULL,
  `unfollowtime` int(10) unsigned NOT NULL,
  `tag` varchar(1000) NOT NULL,
  `updatetime` int(10) unsigned DEFAULT NULL,
  `unionid` varchar(64) NOT NULL,
  `user_from` tinyint(1) NOT NULL,
  PRIMARY KEY (`fanid`),
  UNIQUE KEY `openid_2` (`openid`),
  KEY `acid` (`acid`),
  KEY `uniacid` (`uniacid`),
  KEY `nickname` (`nickname`),
  KEY `updatetime` (`updatetime`),
  KEY `uid` (`uid`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_mapping_ucenter`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_mapping_ucenter`;
CREATE TABLE `mmwl_mc_mapping_ucenter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `centeruid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_mass_record`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_mass_record`;
CREATE TABLE `mmwl_mc_mass_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `groupname` varchar(50) NOT NULL,
  `fansnum` int(10) unsigned NOT NULL,
  `msgtype` varchar(10) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `group` int(10) NOT NULL,
  `attach_id` int(10) unsigned NOT NULL,
  `media_id` varchar(100) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `cron_id` int(10) unsigned NOT NULL,
  `sendtime` int(10) unsigned NOT NULL,
  `finalsendtime` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `msg_id` varchar(50) NOT NULL,
  `msg_data_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_member_address`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_member_address`;
CREATE TABLE `mmwl_mc_member_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(50) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `province` varchar(32) NOT NULL,
  `city` varchar(32) NOT NULL,
  `district` varchar(32) NOT NULL,
  `address` varchar(512) NOT NULL,
  `isdefault` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uinacid` (`uniacid`),
  KEY `idx_uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_member_fields`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_member_fields`;
CREATE TABLE `mmwl_mc_member_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `fieldid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_fieldid` (`fieldid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_member_property`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_member_property`;
CREATE TABLE `mmwl_mc_member_property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `property` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_members`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_members`;
CREATE TABLE `mmwl_mc_members` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `mobile` varchar(18) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` varchar(8) NOT NULL,
  `groupid` int(11) NOT NULL,
  `credit1` decimal(10,2) unsigned NOT NULL,
  `credit2` decimal(10,2) unsigned NOT NULL,
  `credit3` decimal(10,2) unsigned NOT NULL,
  `credit4` decimal(10,2) unsigned NOT NULL,
  `credit5` decimal(10,2) unsigned NOT NULL,
  `credit6` decimal(10,2) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `realname` varchar(10) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `vip` tinyint(3) unsigned NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthyear` smallint(6) unsigned NOT NULL,
  `birthmonth` tinyint(3) unsigned NOT NULL,
  `birthday` tinyint(3) unsigned NOT NULL,
  `constellation` varchar(10) NOT NULL,
  `zodiac` varchar(5) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `idcard` varchar(30) NOT NULL,
  `studentid` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `resideprovince` varchar(30) NOT NULL,
  `residecity` varchar(30) NOT NULL,
  `residedist` varchar(30) NOT NULL,
  `graduateschool` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `education` varchar(10) NOT NULL,
  `occupation` varchar(30) NOT NULL,
  `position` varchar(30) NOT NULL,
  `revenue` varchar(10) NOT NULL,
  `affectivestatus` varchar(30) NOT NULL,
  `lookingfor` varchar(255) NOT NULL,
  `bloodtype` varchar(5) NOT NULL,
  `height` varchar(5) NOT NULL,
  `weight` varchar(5) NOT NULL,
  `alipay` varchar(30) NOT NULL,
  `msn` varchar(30) NOT NULL,
  `taobao` varchar(30) NOT NULL,
  `site` varchar(30) NOT NULL,
  `bio` text NOT NULL,
  `interest` text NOT NULL,
  `pay_password` varchar(30) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `groupid` (`groupid`),
  KEY `uniacid` (`uniacid`),
  KEY `email` (`email`),
  KEY `mobile` (`mobile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_mc_oauth_fans`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mc_oauth_fans`;
CREATE TABLE `mmwl_mc_oauth_fans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oauth_openid` varchar(50) NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_oauthopenid_acid` (`oauth_openid`,`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_menu_event`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_menu_event`;
CREATE TABLE `mmwl_menu_event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `picmd5` varchar(32) NOT NULL,
  `openid` varchar(128) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `picmd5` (`picmd5`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_message_notice_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_message_notice_log`;
CREATE TABLE `mmwl_message_notice_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(3) NOT NULL,
  `uid` int(11) NOT NULL,
  `sign` varchar(22) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_message_notice_log 
-- ----------------------------
INSERT INTO `mmwl_message_notice_log` VALUES ('1', 'test12735-普通用户 2019-08-01 09:13:42注册成功--admin', '2', '1', '2', '4', '2', '1564622021', '0', '');
INSERT INTO `mmwl_message_notice_log` VALUES ('2', 'test12735 用户账号即将过期', '2', '2', '2', '7', '0', '1564623231', '2', '');

-- ----------------------------
-- Table structure for `mmwl_mobilenumber`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_mobilenumber`;
CREATE TABLE `mmwl_mobilenumber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(10) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_modules`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_modules`;
CREATE TABLE `mmwl_modules` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `version` varchar(15) NOT NULL,
  `ability` varchar(500) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `author` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `settings` tinyint(1) NOT NULL,
  `subscribes` varchar(500) NOT NULL,
  `handles` varchar(500) NOT NULL,
  `isrulefields` tinyint(1) NOT NULL,
  `issystem` tinyint(1) unsigned NOT NULL,
  `target` int(10) unsigned NOT NULL,
  `iscard` tinyint(3) unsigned NOT NULL,
  `permissions` varchar(5000) NOT NULL,
  `title_initial` varchar(1) NOT NULL,
  `wxapp_support` tinyint(1) NOT NULL,
  `welcome_support` int(2) NOT NULL,
  `oauth_type` tinyint(1) NOT NULL,
  `webapp_support` tinyint(1) NOT NULL,
  `phoneapp_support` tinyint(1) NOT NULL,
  `account_support` tinyint(1) NOT NULL,
  `xzapp_support` tinyint(1) NOT NULL,
  `aliapp_support` tinyint(1) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `baiduapp_support` tinyint(1) NOT NULL,
  `toutiaoapp_support` tinyint(1) NOT NULL,
  `from` varchar(10) NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `idx_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_modules 
-- ----------------------------
INSERT INTO `mmwl_modules` VALUES ('1', 'basic', 'system', '基本文字回复', '1.0', '和您进行简单对话', '一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '1', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('2', 'news', 'system', '基本混合图文回复', '1.0', '为你提供生动的图文资讯', '一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '1', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('3', 'music', 'system', '基本音乐回复', '1.0', '提供语音、音乐等音频类回复', '在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '1', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('4', 'userapi', 'system', '自定义接口回复', '1.1', '更方便的第三方接口设置', '自定义接口又称第三方接口，可以让开发者更方便的接入微擎系统，高效的与微信公众平台进行对接整合。', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '1', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('5', 'recharge', 'system', '会员中心充值模块', '1.0', '提供会员充值功能', '', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '0', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('6', 'custom', 'system', '多客服转接', '1.0.0', '用来接入腾讯的多客服系统', '', 'WeEngine Team', 'http://bbs.we7.cc', '0', 'a:0:{}', 'a:6:{i:0;s:5:"image";i:1;s:5:"voice";i:2;s:5:"video";i:3;s:8:"location";i:4;s:4:"link";i:5;s:4:"text";}', '1', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('7', 'images', 'system', '基本图片回复', '1.0', '提供图片回复', '在回复规则中可选择具有图片的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝图片。', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '1', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('8', 'video', 'system', '基本视频回复', '1.0', '提供图片回复', '在回复规则中可选择具有视频的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝视频。', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '1', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('9', 'voice', 'system', '基本语音回复', '1.0', '提供语音回复', '在回复规则中可选择具有语音的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝语音。', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '1', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('10', 'chats', 'system', '发送客服消息', '1.0', '公众号可以在粉丝最后发送消息的48小时内无限制发送消息', '', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '0', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('11', 'wxcard', 'system', '微信卡券回复', '1.0', '微信卡券回复', '微信卡券回复', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '1', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('12', 'store', 'business', '站内商城', '1.0', '站内商城', '站内商城', 'WeEngine Team', 'http://www.we7.cc/', '0', '', '', '0', '1', '0', '0', '', '', '1', '1', '1', '1', '0', '2', '0', '0', '', '0', '0', '');
INSERT INTO `mmwl_modules` VALUES ('13', 'group_buy', 'business', '麦芒社区团购', '1.3', '包含社区团购等功能', '包含社区团购等功能', 'scmmwl', 'http://www.scmmwl.com/', '0', 'a:0:{}', 'a:0:{}', '0', '0', '0', '0', 'a:0:{}', 'M', '2', '1', '1', '1', '1', '1', '1', '1', 'addons/group_buy/icon.jpg', '1', '1', 'local');
INSERT INTO `mmwl_modules` VALUES ('14', 'group_buy_plugin_fraction', 'business', '积分商城插件', '1.0.5', '积分商城插件', '积分商城插件', 'zd', 'http://www.scmmwl.com/', '0', 'a:0:{}', 'a:0:{}', '0', '0', '0', '0', 'a:0:{}', 'J', '2', '1', '1', '1', '1', '1', '1', '1', 'addons/group_buy_plugin_fraction/icon.jpg', '1', '1', 'local');
INSERT INTO `mmwl_modules` VALUES ('15', 'group_buy_plugin_distribution', 'business', '麦芒社区团购拼团分销插件', '1.0.20', '麦芒社区团购拼团分销插件', '麦芒社区团购拼团分销插件', 'scmmwl', 'http://www.scmmwl.com/', '0', 'a:0:{}', 'a:0:{}', '0', '0', '0', '0', 'a:0:{}', 'M', '2', '1', '1', '1', '1', '1', '1', '1', 'addons/group_buy_plugin_distribution/icon.jpg', '1', '1', 'local');
INSERT INTO `mmwl_modules` VALUES ('16', 'group_buy_plugin_seckill', 'business', '麦芒社区团购整点秒杀', '1.0.13', '麦芒社区团购整点秒杀', '麦芒社区团购整点秒杀', 'scmmwl', 'http://www.scmmwl.com/', '0', 'a:0:{}', 'a:0:{}', '0', '0', '0', '0', 'a:0:{}', 'M', '2', '1', '1', '1', '1', '1', '1', '1', 'addons/group_buy_plugin_seckill/icon.jpg', '1', '1', 'local');

-- ----------------------------
-- Table structure for `mmwl_modules_bindings`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_modules_bindings`;
CREATE TABLE `mmwl_modules_bindings` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(100) NOT NULL,
  `entry` varchar(30) NOT NULL,
  `call` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `do` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `direct` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `displayorder` tinyint(255) unsigned NOT NULL,
  `multilevel` tinyint(1) NOT NULL,
  `parent` varchar(50) NOT NULL,
  PRIMARY KEY (`eid`),
  KEY `idx_module` (`module`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_modules_bindings 
-- ----------------------------
INSERT INTO `mmwl_modules_bindings` VALUES ('1', 'group_buy', 'menu', '', '用户管理', 'member', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('2', 'group_buy', 'menu', '', '团长管理', 'head', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('3', 'group_buy', 'menu', '', '区域管理', 'district', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('4', 'group_buy', 'menu', '', '商品管理', 'goods', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('5', 'group_buy', 'menu', '', '广告管理', 'adv', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('6', 'group_buy', 'menu', '', '订单管理', 'order', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('7', 'group_buy', 'menu', '', '活动管理', 'action', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('8', 'group_buy', 'menu', '', '营销管理', 'market', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('9', 'group_buy', 'menu', '', '配置管理', 'config', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('10', 'group_buy', 'menu', '', '财务管理', 'finance', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('11', 'group_buy', 'menu', '', '配送管理', 'distribution', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('12', 'group_buy_plugin_fraction', 'cover', '', '后台入口', 'mobile', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('13', 'group_buy_plugin_distribution', 'menu', '', '分销插件', 'Home', '', '0', '', '', '0', '0', '');
INSERT INTO `mmwl_modules_bindings` VALUES ('14', 'group_buy_plugin_seckill', 'menu', '', '整点秒杀', 'index', '', '0', '', '', '0', '0', '');

-- ----------------------------
-- Table structure for `mmwl_modules_cloud`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_modules_cloud`;
CREATE TABLE `mmwl_modules_cloud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `title_initial` varchar(1) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `version` varchar(10) NOT NULL,
  `install_status` tinyint(4) NOT NULL,
  `account_support` tinyint(4) NOT NULL,
  `wxapp_support` tinyint(4) NOT NULL,
  `webapp_support` tinyint(4) NOT NULL,
  `phoneapp_support` tinyint(4) NOT NULL,
  `welcome_support` tinyint(4) NOT NULL,
  `main_module_name` varchar(50) NOT NULL,
  `main_module_logo` varchar(100) NOT NULL,
  `has_new_version` tinyint(1) NOT NULL,
  `has_new_branch` tinyint(1) NOT NULL,
  `is_ban` tinyint(4) NOT NULL,
  `lastupdatetime` int(11) NOT NULL,
  `xzapp_support` tinyint(1) NOT NULL,
  `cloud_id` int(11) NOT NULL,
  `aliapp_support` tinyint(1) NOT NULL,
  `baiduapp_support` tinyint(1) NOT NULL,
  `toutiaoapp_support` tinyint(1) NOT NULL,
  `buytime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `lastupdatetime` (`lastupdatetime`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_modules_ignore`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_modules_ignore`;
CREATE TABLE `mmwl_modules_ignore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `version` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_modules_plugin`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_modules_plugin`;
CREATE TABLE `mmwl_modules_plugin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `main_module` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `main_module` (`main_module`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_modules_plugin 
-- ----------------------------
INSERT INTO `mmwl_modules_plugin` VALUES ('1', 'group_buy_plugin_fraction', 'group_buy');
INSERT INTO `mmwl_modules_plugin` VALUES ('2', 'group_buy_plugin_distribution', 'group_buy');
INSERT INTO `mmwl_modules_plugin` VALUES ('3', 'group_buy_plugin_seckill', 'group_buy');

-- ----------------------------
-- Table structure for `mmwl_modules_plugin_rank`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_modules_plugin_rank`;
CREATE TABLE `mmwl_modules_plugin_rank` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `rank` int(10) NOT NULL,
  `plugin_name` varchar(200) NOT NULL,
  `main_module_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_modules_plugin_rank 
-- ----------------------------
INSERT INTO `mmwl_modules_plugin_rank` VALUES ('1', '2', '1', '0', 'group_buy_plugin_fraction', 'group_buy');
INSERT INTO `mmwl_modules_plugin_rank` VALUES ('2', '2', '1', '0', 'group_buy_plugin_distribution', 'group_buy');
INSERT INTO `mmwl_modules_plugin_rank` VALUES ('3', '2', '1', '0', 'group_buy_plugin_seckill', 'group_buy');

-- ----------------------------
-- Table structure for `mmwl_modules_rank`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_modules_rank`;
CREATE TABLE `mmwl_modules_rank` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) NOT NULL,
  `uid` int(10) NOT NULL,
  `rank` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_name` (`module_name`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_modules_rank 
-- ----------------------------
INSERT INTO `mmwl_modules_rank` VALUES ('1', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('2', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('3', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('4', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('5', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('6', 'group_buy_plugin_distribution', '1', '1', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('7', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('8', 'group_buy_plugin_distribution', '0', '0', '2');

-- ----------------------------
-- Table structure for `mmwl_modules_recycle`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_modules_recycle`;
CREATE TABLE `mmwl_modules_recycle` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `account_support` tinyint(1) NOT NULL,
  `wxapp_support` tinyint(1) NOT NULL,
  `welcome_support` tinyint(1) NOT NULL,
  `webapp_support` tinyint(1) NOT NULL,
  `phoneapp_support` tinyint(1) NOT NULL,
  `xzapp_support` tinyint(1) NOT NULL,
  `aliapp_support` tinyint(1) NOT NULL,
  `baiduapp_support` tinyint(1) NOT NULL,
  `toutiaoapp_support` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_music_reply`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_music_reply`;
CREATE TABLE `mmwl_music_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `url` varchar(300) NOT NULL,
  `hqurl` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_news_reply`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_news_reply`;
CREATE TABLE `mmwl_news_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `parent_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `thumb` varchar(500) NOT NULL,
  `content` mediumtext NOT NULL,
  `url` varchar(255) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `incontent` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL,
  `media_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_phoneapp_versions`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_phoneapp_versions`;
CREATE TABLE `mmwl_phoneapp_versions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `version` varchar(20) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `modules` text,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `version` (`version`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_profile_fields`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_profile_fields`;
CREATE TABLE `mmwl_profile_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field` varchar(255) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `unchangeable` tinyint(1) NOT NULL,
  `showinregister` tinyint(1) NOT NULL,
  `field_length` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_profile_fields 
-- ----------------------------
INSERT INTO `mmwl_profile_fields` VALUES ('1', 'realname', '1', '真实姓名', '', '0', '1', '1', '1', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('2', 'nickname', '1', '昵称', '', '1', '1', '0', '1', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('3', 'avatar', '1', '头像', '', '1', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('4', 'qq', '1', 'QQ号', '', '0', '0', '0', '1', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('5', 'mobile', '1', '手机号码', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('6', 'vip', '1', 'VIP级别', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('7', 'gender', '1', '性别', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('8', 'birthyear', '1', '出生生日', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('9', 'constellation', '1', '星座', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('10', 'zodiac', '1', '生肖', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('11', 'telephone', '1', '固定电话', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('12', 'idcard', '1', '证件号码', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('13', 'studentid', '1', '学号', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('14', 'grade', '1', '班级', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('15', 'address', '1', '邮寄地址', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('16', 'zipcode', '1', '邮编', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('17', 'nationality', '1', '国籍', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('18', 'resideprovince', '1', '居住地址', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('19', 'graduateschool', '1', '毕业学校', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('20', 'company', '1', '公司', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('21', 'education', '1', '学历', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('22', 'occupation', '1', '职业', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('23', 'position', '1', '职位', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('24', 'revenue', '1', '年收入', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('25', 'affectivestatus', '1', '情感状态', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('26', 'lookingfor', '1', ' 交友目的', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('27', 'bloodtype', '1', '血型', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('28', 'height', '1', '身高', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('29', 'weight', '1', '体重', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('30', 'alipay', '1', '支付宝帐号', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('31', 'msn', '1', 'MSN', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('32', 'email', '1', '电子邮箱', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('33', 'taobao', '1', '阿里旺旺', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('34', 'site', '1', '主页', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('35', 'bio', '1', '自我介绍', '', '0', '0', '0', '0', '0');
INSERT INTO `mmwl_profile_fields` VALUES ('36', 'interest', '1', '兴趣爱好', '', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `mmwl_qrcode`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_qrcode`;
CREATE TABLE `mmwl_qrcode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `extra` int(10) unsigned NOT NULL,
  `qrcid` bigint(20) NOT NULL,
  `scene_str` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `model` tinyint(1) unsigned NOT NULL,
  `ticket` varchar(250) NOT NULL,
  `url` varchar(256) NOT NULL,
  `expire` int(10) unsigned NOT NULL,
  `subnum` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_qrcid` (`qrcid`),
  KEY `uniacid` (`uniacid`),
  KEY `ticket` (`ticket`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_qrcode_stat`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_qrcode_stat`;
CREATE TABLE `mmwl_qrcode_stat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `qid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `qrcid` bigint(20) unsigned NOT NULL,
  `scene_str` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_rule`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_rule`;
CREATE TABLE `mmwl_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `displayorder` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `containtype` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_rule 
-- ----------------------------
INSERT INTO `mmwl_rule` VALUES ('1', '0', '城市天气', 'userapi', '255', '1', '');
INSERT INTO `mmwl_rule` VALUES ('2', '0', '百度百科', 'userapi', '255', '1', '');
INSERT INTO `mmwl_rule` VALUES ('3', '0', '即时翻译', 'userapi', '255', '1', '');
INSERT INTO `mmwl_rule` VALUES ('4', '0', '今日老黄历', 'userapi', '255', '1', '');
INSERT INTO `mmwl_rule` VALUES ('5', '0', '看新闻', 'userapi', '255', '1', '');
INSERT INTO `mmwl_rule` VALUES ('6', '0', '快递查询', 'userapi', '255', '1', '');
INSERT INTO `mmwl_rule` VALUES ('7', '1', '个人中心入口设置', 'cover', '0', '1', '');
INSERT INTO `mmwl_rule` VALUES ('8', '1', '微擎团队入口设置', 'cover', '0', '1', '');

-- ----------------------------
-- Table structure for `mmwl_rule_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_rule_keyword`;
CREATE TABLE `mmwl_rule_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `content` varchar(255) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_content` (`content`),
  KEY `rid` (`rid`),
  KEY `idx_rid` (`rid`),
  KEY `idx_uniacid_type_content` (`uniacid`,`type`,`content`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_rule_keyword 
-- ----------------------------
INSERT INTO `mmwl_rule_keyword` VALUES ('1', '1', '0', 'userapi', '^.+天气$', '3', '255', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('2', '2', '0', 'userapi', '^百科.+$', '3', '255', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('3', '2', '0', 'userapi', '^定义.+$', '3', '255', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('4', '3', '0', 'userapi', '^@.+$', '3', '255', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('5', '4', '0', 'userapi', '日历', '1', '255', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('6', '4', '0', 'userapi', '万年历', '1', '255', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('7', '4', '0', 'userapi', '黄历', '1', '255', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('8', '4', '0', 'userapi', '几号', '1', '255', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('9', '5', '0', 'userapi', '新闻', '1', '255', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('10', '6', '0', 'userapi', '^(申通|圆通|中通|汇通|韵达|顺丰|EMS) *[a-z0-9]{1,}$', '3', '255', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('11', '7', '1', 'cover', '个人中心', '1', '0', '1');
INSERT INTO `mmwl_rule_keyword` VALUES ('12', '8', '1', 'cover', '首页', '1', '0', '1');

-- ----------------------------
-- Table structure for `mmwl_site_article`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_article`;
CREATE TABLE `mmwl_site_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `kid` int(10) unsigned NOT NULL,
  `iscommend` tinyint(1) NOT NULL,
  `ishot` tinyint(1) unsigned NOT NULL,
  `pcate` int(10) unsigned NOT NULL,
  `ccate` int(10) unsigned NOT NULL,
  `template` varchar(300) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `incontent` tinyint(1) NOT NULL,
  `source` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `displayorder` int(10) unsigned NOT NULL,
  `linkurl` varchar(500) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `edittime` int(10) NOT NULL,
  `click` int(10) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `credit` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_iscommend` (`iscommend`),
  KEY `idx_ishot` (`ishot`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_article_comment`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_article_comment`;
CREATE TABLE `mmwl_site_article_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `articleid` int(10) NOT NULL,
  `parentid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `content` text,
  `is_read` tinyint(1) NOT NULL,
  `iscomment` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `articleid` (`articleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_category`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_category`;
CREATE TABLE `mmwl_site_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `nid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `parentid` int(10) unsigned NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL,
  `icon` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  `linkurl` varchar(500) NOT NULL,
  `ishomepage` tinyint(1) NOT NULL,
  `icontype` tinyint(1) unsigned NOT NULL,
  `css` varchar(500) NOT NULL,
  `multiid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_multi`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_multi`;
CREATE TABLE `mmwl_site_multi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  `site_info` text NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `bindhost` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `bindhost` (`bindhost`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_site_multi 
-- ----------------------------
INSERT INTO `mmwl_site_multi` VALUES ('1', '1', '微擎团队', '1', '', '1', '');

-- ----------------------------
-- Table structure for `mmwl_site_nav`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_nav`;
CREATE TABLE `mmwl_site_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `section` tinyint(4) NOT NULL,
  `module` varchar(50) NOT NULL,
  `displayorder` smallint(5) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(500) NOT NULL,
  `css` varchar(1000) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `categoryid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `multiid` (`multiid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_page`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_page`;
CREATE TABLE `mmwl_site_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `params` longtext NOT NULL,
  `html` longtext NOT NULL,
  `multipage` longtext NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `goodnum` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `multiid` (`multiid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_slide`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_slide`;
CREATE TABLE `mmwl_site_slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `displayorder` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `multiid` (`multiid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_store_cash_log`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_store_cash_log`;
CREATE TABLE `mmwl_site_store_cash_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `founder_uid` int(10) NOT NULL,
  `number` char(30) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `founder_uid` (`founder_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_store_cash_order`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_store_cash_order`;
CREATE TABLE `mmwl_site_store_cash_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `number` char(30) NOT NULL,
  `founder_uid` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `goods_id` int(10) NOT NULL,
  `order_amount` decimal(10,2) NOT NULL,
  `cash_log_id` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `founder_uid` (`founder_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_store_create_account`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_store_create_account`;
CREATE TABLE `mmwl_site_store_create_account` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `endtime` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_store_goods`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_store_goods`;
CREATE TABLE `mmwl_site_store_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `title` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  `account_num` int(10) NOT NULL,
  `wxapp_num` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(15) NOT NULL,
  `slide` varchar(1000) NOT NULL,
  `category_id` int(10) NOT NULL,
  `title_initial` varchar(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL,
  `synopsis` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `module_group` int(10) NOT NULL,
  `api_num` int(10) NOT NULL,
  `user_group_price` varchar(1000) DEFAULT NULL,
  `user_group` int(10) NOT NULL,
  `account_group` int(10) NOT NULL,
  `is_wish` tinyint(1) NOT NULL,
  `logo` varchar(300) NOT NULL,
  `platform_num` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `category_id` (`category_id`),
  KEY `price` (`price`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_store_goods_cloud`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_store_goods_cloud`;
CREATE TABLE `mmwl_site_store_goods_cloud` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cloud_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `logo` varchar(300) NOT NULL,
  `wish_branch` int(10) NOT NULL,
  `is_edited` tinyint(1) NOT NULL,
  `isdeleted` tinyint(1) NOT NULL,
  `branchs` varchar(6000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cloud_id` (`cloud_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_store_order`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_store_order`;
CREATE TABLE `mmwl_site_store_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` varchar(28) NOT NULL,
  `goodsid` int(10) NOT NULL,
  `duration` int(10) NOT NULL,
  `buyer` varchar(50) NOT NULL,
  `buyerid` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `changeprice` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `endtime` int(15) NOT NULL,
  `wxapp` int(15) NOT NULL,
  `is_wish` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `goodid` (`goodsid`),
  KEY `buyerid` (`buyerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_styles`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_styles`;
CREATE TABLE `mmwl_site_styles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `templateid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_site_styles 
-- ----------------------------
INSERT INTO `mmwl_site_styles` VALUES ('1', '1', '1', '微站默认模板_gC5C');

-- ----------------------------
-- Table structure for `mmwl_site_styles_vars`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_styles_vars`;
CREATE TABLE `mmwl_site_styles_vars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `templateid` int(10) unsigned NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  `variable` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_site_templates`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_site_templates`;
CREATE TABLE `mmwl_site_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `version` varchar(64) NOT NULL,
  `description` varchar(500) NOT NULL,
  `author` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `sections` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_site_templates 
-- ----------------------------
INSERT INTO `mmwl_site_templates` VALUES ('1', 'default', '微站默认模板', '', '由微擎提供默认微站模板套系', '微擎团队', 'http://we7.cc', '1', '0');

-- ----------------------------
-- Table structure for `mmwl_stat_fans`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_stat_fans`;
CREATE TABLE `mmwl_stat_fans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `new` int(10) unsigned NOT NULL,
  `cancel` int(10) unsigned NOT NULL,
  `cumulate` int(10) NOT NULL,
  `date` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`date`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_stat_fans 
-- ----------------------------
INSERT INTO `mmwl_stat_fans` VALUES ('1', '2', '0', '0', '0', '20190802');
INSERT INTO `mmwl_stat_fans` VALUES ('2', '2', '0', '0', '0', '20190801');
INSERT INTO `mmwl_stat_fans` VALUES ('3', '2', '0', '0', '0', '20190731');
INSERT INTO `mmwl_stat_fans` VALUES ('4', '2', '0', '0', '0', '20190730');
INSERT INTO `mmwl_stat_fans` VALUES ('5', '2', '0', '0', '0', '20190729');
INSERT INTO `mmwl_stat_fans` VALUES ('6', '2', '0', '0', '0', '20190728');
INSERT INTO `mmwl_stat_fans` VALUES ('7', '2', '0', '0', '0', '20190727');

-- ----------------------------
-- Table structure for `mmwl_stat_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_stat_keyword`;
CREATE TABLE `mmwl_stat_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` varchar(10) NOT NULL,
  `kid` int(10) unsigned NOT NULL,
  `hit` int(10) unsigned NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_createtime` (`createtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_stat_msg_history`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_stat_msg_history`;
CREATE TABLE `mmwl_stat_msg_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `kid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `type` varchar(10) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_createtime` (`createtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_stat_rule`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_stat_rule`;
CREATE TABLE `mmwl_stat_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `hit` int(10) unsigned NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_createtime` (`createtime`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_stat_visit`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_stat_visit`;
CREATE TABLE `mmwl_stat_visit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `module` varchar(100) NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `ip_count` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `module` (`module`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_stat_visit 
-- ----------------------------
INSERT INTO `mmwl_stat_visit` VALUES ('1', '0', '', '38', '20190718', 'web', '2');
INSERT INTO `mmwl_stat_visit` VALUES ('2', '2', '', '136', '20190718', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('3', '2', 'we7_account', '13', '20190718', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('4', '0', '', '2', '20190719', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('5', '2', '', '79', '20190719', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('6', '0', '', '1', '20190722', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('7', '2', '', '10', '20190722', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('8', '0', '', '1', '20190726', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('9', '2', '', '17', '20190726', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('10', '0', '', '1', '20190727', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('11', '2', '', '48', '20190727', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('12', '0', '', '9', '20190729', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('13', '2', '', '94', '20190729', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('14', '0', '', '1', '20190730', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('15', '2', '', '20', '20190730', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('16', '0', '', '15', '20190801', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('17', '2', '', '197', '20190801', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('18', '2', 'we7_account', '4', '20190801', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('19', '2', '', '137', '20190802', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('20', '0', '', '2', '20190803', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('21', '2', '', '121', '20190803', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('22', '2', 'we7_account', '10', '20190803', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('23', '2', '', '19', '20190809', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('24', '0', '', '1', '20190814', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('25', '2', '', '139', '20190814', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('26', '2', 'we7_account', '1', '20190814', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('27', '0', '', '1', '20190829', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('28', '2', '', '161', '20190829', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('29', '0', '', '1', '20190830', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('30', '2', '', '69', '20190830', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('31', '2', '', '98', '20190831', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('32', '0', '', '27', '20190831', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('33', '2', '', '18', '20190926', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('34', '0', '', '2', '20190927', 'web', '2');
INSERT INTO `mmwl_stat_visit` VALUES ('35', '0', '', '4', '20190929', 'web', '3');
INSERT INTO `mmwl_stat_visit` VALUES ('36', '2', '', '20', '20190929', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('37', '0', '', '2', '20190930', 'web', '2');
INSERT INTO `mmwl_stat_visit` VALUES ('38', '0', '', '4', '20191008', 'web', '4');
INSERT INTO `mmwl_stat_visit` VALUES ('39', '2', '', '44', '20191008', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('40', '0', '', '2', '20191009', 'web', '2');
INSERT INTO `mmwl_stat_visit` VALUES ('41', '0', '', '1', '20191014', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('42', '0', '', '1', '20191015', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('43', '0', '', '3', '20191016', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('44', '2', '', '1', '20191016', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('45', '0', '', '3', '20191017', 'web', '3');
INSERT INTO `mmwl_stat_visit` VALUES ('46', '2', '', '11', '20191017', 'web', '0');
INSERT INTO `mmwl_stat_visit` VALUES ('47', '2', 'we7_account', '1', '20191017', 'web', '0');

-- ----------------------------
-- Table structure for `mmwl_stat_visit_ip`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_stat_visit_ip`;
CREATE TABLE `mmwl_stat_visit_ip` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` bigint(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `module` varchar(100) NOT NULL,
  `date` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip_date_module_uniacid` (`ip`,`date`,`module`,`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_stat_visit_ip 
-- ----------------------------
INSERT INTO `mmwl_stat_visit_ip` VALUES ('1', '2345501873', '0', 'web', '', '20190718');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('2', '2130706433', '0', 'web', '', '20190718');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('3', '2130706433', '0', 'web', '', '20190719');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('4', '2130706433', '0', 'web', '', '20190722');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('5', '2130706433', '0', 'web', '', '20190726');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('6', '2130706433', '0', 'web', '', '20190727');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('7', '2130706433', '0', 'web', '', '20190729');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('8', '2130706433', '0', 'web', '', '20190730');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('9', '2130706433', '0', 'web', '', '20190801');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('10', '2130706433', '2', 'web', '', '20190802');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('11', '2130706433', '0', 'web', '', '20190803');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('12', '2130706433', '2', 'web', '', '20190809');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('13', '2130706433', '0', 'web', '', '20190814');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('14', '2130706433', '0', 'web', '', '20190829');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('15', '2130706433', '0', 'web', '', '20190830');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('16', '2130706433', '2', 'web', '', '20190831');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('17', '2345501328', '2', 'web', '', '20190926');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('18', '794929057', '0', 'web', '', '20190927');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('19', '795096011', '0', 'web', '', '20190927');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('20', '2345501328', '0', 'web', '', '20190929');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('21', '30152292', '0', 'web', '', '20190929');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('22', '3030637573', '0', 'web', '', '20190929');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('23', '794823693', '0', 'web', '', '20190930');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('24', '795097477', '0', 'web', '', '20190930');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('25', '2345501214', '0', 'web', '', '20191008');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('26', '720112253', '0', 'web', '', '20191008');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('27', '720112203', '0', 'web', '', '20191008');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('28', '3721032170', '0', 'web', '', '20191008');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('29', '794935342', '0', 'web', '', '20191009');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('30', '794595516', '0', 'web', '', '20191009');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('31', '1862755353', '0', 'web', '', '20191014');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('32', '794976593', '0', 'web', '', '20191015');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('33', '2345501674', '0', 'web', '', '20191016');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('34', '2345501674', '0', 'web', '', '20191017');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('35', '794942588', '0', 'web', '', '20191017');
INSERT INTO `mmwl_stat_visit_ip` VALUES ('36', '794916869', '0', 'web', '', '20191017');

-- ----------------------------
-- Table structure for `mmwl_system_stat_visit`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_system_stat_visit`;
CREATE TABLE `mmwl_system_stat_visit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `uid` int(10) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `createtime` int(10) NOT NULL,
  `updatetime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_uni_account`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_account`;
CREATE TABLE `mmwl_uni_account` (
  `uniacid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_acid` int(10) unsigned NOT NULL,
  `rank` int(10) DEFAULT NULL,
  `title_initial` varchar(1) NOT NULL,
  PRIMARY KEY (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_uni_account 
-- ----------------------------
INSERT INTO `mmwl_uni_account` VALUES ('1', '-1', '微擎团队', '一个朝气蓬勃的团队', '1', '', 'W');
INSERT INTO `mmwl_uni_account` VALUES ('2', '0', '麦芒团购', '包含社区团购等功能', '2', '', 'M');

-- ----------------------------
-- Table structure for `mmwl_uni_account_group`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_account_group`;
CREATE TABLE `mmwl_uni_account_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `groupid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_uni_account_menus`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_account_menus`;
CREATE TABLE `mmwl_uni_account_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `menuid` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `sex` tinyint(3) unsigned NOT NULL,
  `group_id` int(10) NOT NULL,
  `client_platform_type` tinyint(3) unsigned NOT NULL,
  `area` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `isdeleted` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `menuid` (`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_uni_account_modules`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_account_modules`;
CREATE TABLE `mmwl_uni_account_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL,
  `settings` text NOT NULL,
  `shortcut` tinyint(1) unsigned NOT NULL,
  `displayorder` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_module` (`module`),
  KEY `idx_uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_uni_account_modules 
-- ----------------------------
INSERT INTO `mmwl_uni_account_modules` VALUES ('1', '2', 'group_buy', '0', 'a:1:{s:12:"direct_enter";i:0;}', '0', '0');

-- ----------------------------
-- Table structure for `mmwl_uni_account_modules_shortcut`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_account_modules_shortcut`;
CREATE TABLE `mmwl_uni_account_modules_shortcut` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `url` varchar(250) NOT NULL,
  `icon` varchar(200) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `version_id` int(10) NOT NULL,
  `module_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_uni_account_users`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_account_users`;
CREATE TABLE `mmwl_uni_account_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `role` varchar(255) NOT NULL,
  `rank` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_memberid` (`uid`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_uni_account_users 
-- ----------------------------
INSERT INTO `mmwl_uni_account_users` VALUES ('1', '2', '2', 'manager', '0');
INSERT INTO `mmwl_uni_account_users` VALUES ('3', '2', '3', 'manager', '0');

-- ----------------------------
-- Table structure for `mmwl_uni_group`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_group`;
CREATE TABLE `mmwl_uni_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_uid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `modules` text NOT NULL,
  `templates` varchar(5000) NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_uni_group 
-- ----------------------------
INSERT INTO `mmwl_uni_group` VALUES ('1', '0', '体验套餐服务', 'a:8:{s:7:"modules";a:0:{}s:5:"wxapp";a:4:{i:0;s:9:"group_buy";i:1;s:25:"group_buy_plugin_fraction";i:2;s:29:"group_buy_plugin_distribution";i:3;s:24:"group_buy_plugin_seckill";}s:6:"webapp";a:0:{}s:8:"phoneapp";a:0:{}s:5:"xzapp";a:0:{}s:6:"aliapp";a:0:{}s:8:"baiduapp";a:0:{}s:10:"toutiaoapp";a:0:{}}', '', '0', '0');
INSERT INTO `mmwl_uni_group` VALUES ('2', '0', '', 'a:5:{s:7:"modules";a:0:{}s:5:"wxapp";a:4:{i:0;s:9:"group_buy";i:1;s:25:"group_buy_plugin_fraction";i:2;s:29:"group_buy_plugin_distribution";i:3;s:24:"group_buy_plugin_seckill";}s:6:"webapp";a:0:{}s:5:"xzapp";a:0:{}s:8:"phoneapp";a:0:{}}', 'a:0:{}', '2', '0');

-- ----------------------------
-- Table structure for `mmwl_uni_link_uniacid`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_link_uniacid`;
CREATE TABLE `mmwl_uni_link_uniacid` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `link_uniacid` int(10) NOT NULL,
  `version_id` int(10) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_uni_modules`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_modules`;
CREATE TABLE `mmwl_uni_modules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_uni_modules 
-- ----------------------------
INSERT INTO `mmwl_uni_modules` VALUES ('1', '2', 'group_buy_plugin_distribution');

-- ----------------------------
-- Table structure for `mmwl_uni_settings`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_settings`;
CREATE TABLE `mmwl_uni_settings` (
  `uniacid` int(10) unsigned NOT NULL,
  `passport` varchar(200) NOT NULL,
  `oauth` varchar(100) NOT NULL,
  `jsauth_acid` int(10) unsigned NOT NULL,
  `uc` varchar(700) NOT NULL,
  `notify` varchar(2000) NOT NULL,
  `creditnames` varchar(500) NOT NULL,
  `creditbehaviors` varchar(500) NOT NULL,
  `welcome` varchar(60) NOT NULL,
  `default` varchar(60) NOT NULL,
  `default_message` varchar(2000) NOT NULL,
  `payment` text NOT NULL,
  `stat` varchar(300) NOT NULL,
  `default_site` int(10) unsigned DEFAULT NULL,
  `sync` tinyint(3) unsigned NOT NULL,
  `recharge` varchar(500) NOT NULL,
  `tplnotice` varchar(2000) NOT NULL,
  `grouplevel` tinyint(3) unsigned NOT NULL,
  `mcplugin` varchar(500) NOT NULL,
  `exchange_enable` tinyint(3) unsigned NOT NULL,
  `coupon_type` tinyint(3) unsigned NOT NULL,
  `menuset` text NOT NULL,
  `statistics` varchar(100) NOT NULL,
  `bind_domain` varchar(200) NOT NULL,
  `comment_status` tinyint(1) NOT NULL,
  `reply_setting` tinyint(4) NOT NULL,
  `default_module` varchar(100) NOT NULL,
  `attachment_limit` int(11) DEFAULT NULL,
  `attachment_size` varchar(20) DEFAULT NULL,
  `sync_member` tinyint(1) NOT NULL,
  `remote` varchar(2000) NOT NULL,
  PRIMARY KEY (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_uni_settings 
-- ----------------------------
INSERT INTO `mmwl_uni_settings` VALUES ('1', 'a:3:{s:8:"focusreg";i:0;s:4:"item";s:5:"email";s:4:"type";s:8:"password";}', 'a:2:{s:6:"status";s:1:"0";s:7:"account";s:1:"0";}', '0', 'a:1:{s:6:"status";i:0;}', 'a:1:{s:3:"sms";a:2:{s:7:"balance";i:0;s:9:"signature";s:0:"";}}', 'a:5:{s:7:"credit1";a:2:{s:5:"title";s:6:"积分";s:7:"enabled";i:1;}s:7:"credit2";a:2:{s:5:"title";s:6:"余额";s:7:"enabled";i:1;}s:7:"credit3";a:2:{s:5:"title";s:0:"";s:7:"enabled";i:0;}s:7:"credit4";a:2:{s:5:"title";s:0:"";s:7:"enabled";i:0;}s:7:"credit5";a:2:{s:5:"title";s:0:"";s:7:"enabled";i:0;}}', 'a:2:{s:8:"activity";s:7:"credit1";s:8:"currency";s:7:"credit2";}', '', '', '', 'a:4:{s:6:"credit";a:1:{s:6:"switch";b:0;}s:6:"alipay";a:4:{s:6:"switch";b:0;s:7:"account";s:0:"";s:7:"partner";s:0:"";s:6:"secret";s:0:"";}s:6:"wechat";a:5:{s:6:"switch";b:0;s:7:"account";b:0;s:7:"signkey";s:0:"";s:7:"partner";s:0:"";s:3:"key";s:0:"";}s:8:"delivery";a:1:{s:6:"switch";b:0;}}', '', '1', '0', '', '', '0', '', '0', '0', '', '', '', '0', '0', '', '', '', '0', '');
INSERT INTO `mmwl_uni_settings` VALUES ('0', '', '', '0', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0', '', '0', '0', '', '', '', '0', '0', '', '', '26', '0', '');
INSERT INTO `mmwl_uni_settings` VALUES ('2', '', '', '0', '', '', 'a:2:{s:7:"credit1";a:2:{s:5:"title";s:6:"积分";s:7:"enabled";i:1;}s:7:"credit2";a:2:{s:5:"title";s:6:"余额";s:7:"enabled";i:1;}}', 'a:2:{s:8:"activity";s:7:"credit1";s:8:"currency";s:7:"credit2";}', '', '', '', 'a:1:{s:6:"wechat";a:3:{s:5:"mchid";s:10:"1482977942";s:7:"signkey";s:32:"BK16NIepSoInfywfjDTnATwoAvtdmdYm";s:7:"account";i:2;}}', '', '', '0', '', '', '0', '', '0', '0', '', '', '', '0', '0', '', '', '', '0', 'a:2:{s:4:"type";i:0;s:6:"alioss";a:5:{s:3:"key";s:16:"LTAIzVbHyKhhggIb";s:6:"secret";s:30:"ar6ZHxatsS5ltiyy96eZzHnj5d03pO";s:8:"internal";i:0;s:6:"bucket";s:10:"scmmwltest";s:3:"url";s:45:"http://scmmwltest.oss-cn-beijing.aliyuncs.com";}}');

-- ----------------------------
-- Table structure for `mmwl_uni_verifycode`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_uni_verifycode`;
CREATE TABLE `mmwl_uni_verifycode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `verifycode` varchar(6) NOT NULL,
  `total` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `failed_count` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_userapi_cache`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_userapi_cache`;
CREATE TABLE `mmwl_userapi_cache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_userapi_reply`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_userapi_reply`;
CREATE TABLE `mmwl_userapi_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `description` varchar(300) NOT NULL,
  `apiurl` varchar(300) NOT NULL,
  `token` varchar(32) NOT NULL,
  `default_text` varchar(100) NOT NULL,
  `cachetime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_userapi_reply 
-- ----------------------------
INSERT INTO `mmwl_userapi_reply` VALUES ('1', '1', '"城市名+天气", 如: "北京天气"', 'weather.php', '', '', '0');
INSERT INTO `mmwl_userapi_reply` VALUES ('2', '2', '"百科+查询内容" 或 "定义+查询内容", 如: "百科姚明", "定义自行车"', 'baike.php', '', '', '0');
INSERT INTO `mmwl_userapi_reply` VALUES ('3', '3', '"@查询内容(中文或英文)"', 'translate.php', '', '', '0');
INSERT INTO `mmwl_userapi_reply` VALUES ('4', '4', '"日历", "万年历", "黄历"或"几号"', 'calendar.php', '', '', '0');
INSERT INTO `mmwl_userapi_reply` VALUES ('5', '5', '"新闻"', 'news.php', '', '', '0');
INSERT INTO `mmwl_userapi_reply` VALUES ('6', '6', '"快递+单号", 如: "申通1200041125"', 'express.php', '', '', '0');

-- ----------------------------
-- Table structure for `mmwl_users`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users`;
CREATE TABLE `mmwl_users` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_uid` int(10) NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  `founder_groupid` tinyint(4) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL,
  `joindate` int(10) unsigned NOT NULL,
  `joinip` varchar(15) NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL,
  `lastip` varchar(15) NOT NULL,
  `remark` varchar(500) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  `register_type` tinyint(3) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `welcome_link` tinyint(4) NOT NULL,
  `notice_setting` varchar(5000) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_users 
-- ----------------------------
INSERT INTO `mmwl_users` VALUES ('1', '0', '1', '1', 'admin', 'b472a0a5dae4a6ad899837e9a236ae1da3aac268', 'L2crx6ky', '0', '2', '1563415812', '', '1571275734', '139.205.131.234', '', '0', '0', '0', '', '0', '');
INSERT INTO `mmwl_users` VALUES ('2', '0', '1', '0', 'test12735', '7ab4f36bf9252654fb506c265a353d8a689f3f8c', 'T2ztY330', '1', '2', '1564622021', '127.0.0.1', '1564623392', '127.0.0.1', 'test12735', '1564622021', '2', '0', '', '0', '');
INSERT INTO `mmwl_users` VALUES ('3', '0', '1', '0', 'test', '6081df98baf89ee30bcf9a1638b3f4e5ee40f347', 'RMBXPCLY', '1', '2', '1564626608', '127.0.0.1', '1564627772', '127.0.0.1', '', '1564626608', '2', '0', '', '0', '');

-- ----------------------------
-- Table structure for `mmwl_users_bind`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_bind`;
CREATE TABLE `mmwl_users_bind` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `bind_sign` varchar(50) NOT NULL,
  `third_type` tinyint(4) NOT NULL,
  `third_nickname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `bind_sign` (`bind_sign`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_create_group`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_create_group`;
CREATE TABLE `mmwl_users_create_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `maxaccount` int(10) NOT NULL,
  `maxwxapp` int(10) NOT NULL,
  `maxwebapp` int(10) NOT NULL,
  `maxphoneapp` int(10) NOT NULL,
  `maxxzapp` int(10) NOT NULL,
  `maxaliapp` int(10) NOT NULL,
  `createtime` int(10) NOT NULL,
  `maxbaiduapp` int(10) NOT NULL,
  `maxtoutiaoapp` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_extra_group`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_extra_group`;
CREATE TABLE `mmwl_users_extra_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `uni_group_id` int(10) NOT NULL,
  `create_group_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `uni_group_id` (`uni_group_id`),
  KEY `create_group_id` (`create_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_users_extra_group 
-- ----------------------------
INSERT INTO `mmwl_users_extra_group` VALUES ('1', '2', '1', '0');
INSERT INTO `mmwl_users_extra_group` VALUES ('2', '0', '0', '0');
INSERT INTO `mmwl_users_extra_group` VALUES ('3', '3', '0', '0');

-- ----------------------------
-- Table structure for `mmwl_users_extra_limit`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_extra_limit`;
CREATE TABLE `mmwl_users_extra_limit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `maxaccount` int(10) NOT NULL,
  `maxwxapp` int(10) NOT NULL,
  `maxwebapp` int(10) NOT NULL,
  `maxphoneapp` int(10) NOT NULL,
  `maxxzapp` int(10) NOT NULL,
  `maxaliapp` int(10) NOT NULL,
  `timelimit` int(10) NOT NULL,
  `maxbaiduapp` int(10) NOT NULL,
  `maxtoutiaoapp` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_users_extra_limit 
-- ----------------------------
INSERT INTO `mmwl_users_extra_limit` VALUES ('1', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `mmwl_users_extra_modules`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_extra_modules`;
CREATE TABLE `mmwl_users_extra_modules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `support` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `module_name` (`module_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_extra_templates`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_extra_templates`;
CREATE TABLE `mmwl_users_extra_templates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `template_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `template_id` (`template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_failed_login`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_failed_login`;
CREATE TABLE `mmwl_users_failed_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `username` varchar(32) NOT NULL,
  `count` tinyint(1) unsigned NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip_username` (`ip`,`username`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_founder_group`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_founder_group`;
CREATE TABLE `mmwl_users_founder_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `package` varchar(5000) NOT NULL,
  `maxaccount` int(10) unsigned NOT NULL,
  `maxsubaccount` int(10) unsigned NOT NULL,
  `timelimit` int(10) unsigned NOT NULL,
  `maxwxapp` int(10) unsigned NOT NULL,
  `maxwebapp` int(10) NOT NULL,
  `maxphoneapp` int(10) NOT NULL,
  `maxxzapp` int(10) NOT NULL,
  `maxaliapp` int(10) NOT NULL,
  `maxbaiduapp` int(10) NOT NULL,
  `maxtoutiaoapp` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_founder_own_create_groups`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_founder_own_create_groups`;
CREATE TABLE `mmwl_users_founder_own_create_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `founder_uid` int(10) NOT NULL,
  `create_group_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `founder_uid` (`founder_uid`),
  KEY `create_group_id` (`create_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_founder_own_uni_groups`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_founder_own_uni_groups`;
CREATE TABLE `mmwl_users_founder_own_uni_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `founder_uid` int(10) NOT NULL,
  `uni_group_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `founder_uid` (`founder_uid`),
  KEY `uni_group_id` (`uni_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_founder_own_users`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_founder_own_users`;
CREATE TABLE `mmwl_users_founder_own_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `founder_uid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `founder_uid` (`founder_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_founder_own_users_groups`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_founder_own_users_groups`;
CREATE TABLE `mmwl_users_founder_own_users_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `founder_uid` int(10) NOT NULL,
  `users_group_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `founder_uid` (`founder_uid`),
  KEY `users_group_id` (`users_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_group`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_group`;
CREATE TABLE `mmwl_users_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_uid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `package` varchar(5000) NOT NULL,
  `maxaccount` int(10) unsigned NOT NULL,
  `maxsubaccount` int(10) unsigned NOT NULL,
  `timelimit` int(10) unsigned NOT NULL,
  `maxwxapp` int(10) unsigned NOT NULL,
  `maxwebapp` int(10) NOT NULL,
  `maxphoneapp` int(10) NOT NULL,
  `maxxzapp` int(10) NOT NULL,
  `maxaliapp` int(10) NOT NULL,
  `maxbaiduapp` int(10) NOT NULL,
  `maxtoutiaoapp` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_users_group 
-- ----------------------------
INSERT INTO `mmwl_users_group` VALUES ('1', '0', '用户权限组', 'N;', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `mmwl_users_invitation`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_invitation`;
CREATE TABLE `mmwl_users_invitation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(64) NOT NULL,
  `fromuid` int(10) unsigned NOT NULL,
  `inviteuid` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_users_lastuse`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_lastuse`;
CREATE TABLE `mmwl_users_lastuse` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `modulename` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_users_lastuse 
-- ----------------------------
INSERT INTO `mmwl_users_lastuse` VALUES ('1', '1', '2', '', 'account_display');
INSERT INTO `mmwl_users_lastuse` VALUES ('4', '2', '2', '', 'account_display');
INSERT INTO `mmwl_users_lastuse` VALUES ('5', '3', '2', '', 'account_display');

-- ----------------------------
-- Table structure for `mmwl_users_permission`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_permission`;
CREATE TABLE `mmwl_users_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `type` varchar(100) NOT NULL,
  `permission` varchar(10000) NOT NULL,
  `url` varchar(255) NOT NULL,
  `modules` text NOT NULL,
  `templates` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_users_permission 
-- ----------------------------
INSERT INTO `mmwl_users_permission` VALUES ('1', '2', '2', 'wxapp', 'account_manage_display|account_manage_recycle|account_manage_system_platform|account_manage_expired_message|module_manage_installed|module_manage_stoped|module_manage_not_installed|module_manage_recycle|module_manage_subscribe|user_manage_display|user_manage_clerk|user_manage_check|user_manage_recycle|user_manage_fields|user_manage_expire|permission_module_group|permission_create_account_group|permission_user_group|system_article|system_template|system_cloud_sms|system_setting_updatecache|system_cloud_upgrade|system_cloud_register|system_cloud_diagnose|system_setting_site|system_setting_menu|system_setting_attachment|system_setting_systeminfo|system_setting_logs|system_setting_ipwhitelist|system_setting_sensitiveword|system_setting_thirdlogin|system_setting_oauth|system_utility_filecheck|system_utility_optimize|system_utility_database|system_utility_scan|system_utility_bom|system_utility_check|system_job|message_notice|message_setting|message_wechat_setting|platform_reply|platform_menu|platform_qr|platform_masstask|platform_material|platform_site|mc_fans|mc_member|mc_message|profile_setting|profile_payment|profile_app_module_link_uniacid|webapp_module_link|webapp_rewrite|wxapp_entrance_link|mc_wxapp_member|wxapp_profile_module_link_uniacid|wxapp_profile_payment|wxapp_profile_front_download|wxapp_profile_domainset|profile_setting_remote|statistics_visit_wxapp|profile_phoneapp_module_link|phoneapp_front_download|system_workorder|account_manage_stop|account_manage_delete|account_manage_recover|system_article_notice_list|system_article_notice_category|platform_reply_keyword|platform_reply_special|platform_reply_welcome|platform_reply_default|platform_reply_service|platform_reply_userapi|platform_reply_setting|platform_menu_default|platform_menu_conditional|platform_qr_qr|platform_qr_statistics|platform_masstask_post|platform_masstask_send|platform_material_news|platform_material_image|platform_material_voice|platform_material_video|platform_material_delete|platform_site_multi|platform_site_style|platform_site_article|platform_site_category|mc_fans_display|mc_fans_fans_sync_set|mc_member_diaplsy|mc_member_group|mc_member_uc|mc_member_quickmenu|mc_member_register_seting|mc_member_credit_setting|mc_member_fields|profile_setting_remote|profile_setting_passport|profile_setting_tplnotice|profile_setting_notify|profile_setting_uc_setting|profile_setting_upload_file|profile_payment_pay|profile_payment_refund|mc_member_diaplsy|mc_member_group|mc_member_credit_setting|mc_member_fields|wxapp_payment_pay|wxapp_payment_refund|statistics_visit_app|statistics_visit_site|statistics_visit_setting', '', '', '');
INSERT INTO `mmwl_users_permission` VALUES ('2', '2', '2', 'modules', 'all', '', '', '');
INSERT INTO `mmwl_users_permission` VALUES ('3', '2', '3', 'modules', 'all', '', '', '');

-- ----------------------------
-- Table structure for `mmwl_users_profile`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_users_profile`;
CREATE TABLE `mmwl_users_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `edittime` int(10) NOT NULL,
  `realname` varchar(10) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `fakeid` varchar(30) NOT NULL,
  `vip` tinyint(3) unsigned NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthyear` smallint(6) unsigned NOT NULL,
  `birthmonth` tinyint(3) unsigned NOT NULL,
  `birthday` tinyint(3) unsigned NOT NULL,
  `constellation` varchar(10) NOT NULL,
  `zodiac` varchar(5) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `idcard` varchar(30) NOT NULL,
  `studentid` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `resideprovince` varchar(30) NOT NULL,
  `residecity` varchar(30) NOT NULL,
  `residedist` varchar(30) NOT NULL,
  `graduateschool` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `education` varchar(10) NOT NULL,
  `occupation` varchar(30) NOT NULL,
  `position` varchar(30) NOT NULL,
  `revenue` varchar(10) NOT NULL,
  `affectivestatus` varchar(30) NOT NULL,
  `lookingfor` varchar(255) NOT NULL,
  `bloodtype` varchar(5) NOT NULL,
  `height` varchar(5) NOT NULL,
  `weight` varchar(5) NOT NULL,
  `alipay` varchar(30) NOT NULL,
  `msn` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `taobao` varchar(30) NOT NULL,
  `site` varchar(30) NOT NULL,
  `bio` text NOT NULL,
  `interest` text NOT NULL,
  `workerid` varchar(64) NOT NULL,
  `is_send_mobile_status` tinyint(3) NOT NULL,
  `send_expire_status` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_video_reply`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_video_reply`;
CREATE TABLE `mmwl_video_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_voice_reply`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_voice_reply`;
CREATE TABLE `mmwl_voice_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_wechat_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_wechat_attachment`;
CREATE TABLE `mmwl_wechat_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `media_id` varchar(255) NOT NULL,
  `width` int(10) unsigned NOT NULL,
  `height` int(10) unsigned NOT NULL,
  `type` varchar(15) NOT NULL,
  `model` varchar(25) NOT NULL,
  `tag` varchar(5000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `module_upload_dir` varchar(100) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `media_id` (`media_id`),
  KEY `acid` (`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_wechat_news`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_wechat_news`;
CREATE TABLE `mmwl_wechat_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned DEFAULT NULL,
  `attach_id` int(10) unsigned NOT NULL,
  `thumb_media_id` varchar(60) NOT NULL,
  `thumb_url` varchar(255) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(30) NOT NULL,
  `digest` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `content_source_url` varchar(200) NOT NULL,
  `show_cover_pic` tinyint(3) unsigned NOT NULL,
  `url` varchar(200) NOT NULL,
  `displayorder` int(2) NOT NULL,
  `need_open_comment` tinyint(1) NOT NULL,
  `only_fans_can_comment` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `attach_id` (`attach_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_wxapp_general_analysis`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_wxapp_general_analysis`;
CREATE TABLE `mmwl_wxapp_general_analysis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `session_cnt` int(10) NOT NULL,
  `visit_pv` int(10) NOT NULL,
  `visit_uv` int(10) NOT NULL,
  `visit_uv_new` int(10) NOT NULL,
  `type` tinyint(2) NOT NULL,
  `stay_time_uv` varchar(10) NOT NULL,
  `stay_time_session` varchar(10) NOT NULL,
  `visit_depth` varchar(10) NOT NULL,
  `ref_date` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `ref_date` (`ref_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mmwl_wxapp_versions`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_wxapp_versions`;
CREATE TABLE `mmwl_wxapp_versions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `version` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `modules` varchar(1000) NOT NULL,
  `design_method` tinyint(1) NOT NULL,
  `template` int(10) NOT NULL,
  `quickmenu` varchar(2500) NOT NULL,
  `createtime` int(10) NOT NULL,
  `type` int(2) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `appjson` text NOT NULL,
  `default_appjson` text NOT NULL,
  `use_default` tinyint(1) NOT NULL,
  `last_modules` varchar(1000) DEFAULT NULL,
  `tominiprogram` varchar(1000) NOT NULL,
  `upload_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `version` (`version`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_wxapp_versions 
-- ----------------------------
INSERT INTO `mmwl_wxapp_versions` VALUES ('1', '2', '0', '1.0.0', '1.0.0', 'a:1:{s:29:"group_buy_plugin_distribution";a:2:{s:4:"name";s:29:"group_buy_plugin_distribution";s:7:"version";s:6:"1.0.20";}}', '3', '0', '', '1563416812', '0', '0', '', '', '0', '', 'a:2:{s:17:"wxasdfasdftjvb213";a:2:{s:5:"appid";s:17:"wxasdfasdftjvb213";s:8:"app_name";s:15:"微信小程序";}s:18:"wxqwerwqerqwtqeywe";a:2:{s:5:"appid";s:18:"wxqwerwqerqwtqeywe";s:8:"app_name";s:3:"111";}}', '0');

-- ----------------------------
-- Table structure for `mmwl_wxcard_reply`
-- ----------------------------
DROP TABLE IF EXISTS `mmwl_wxcard_reply`;
CREATE TABLE `mmwl_wxcard_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `brand_name` varchar(30) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `success` varchar(255) NOT NULL,
  `error` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

