/*************************
 * 2019-07-29 18:09:16 
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
INSERT INTO `mmwl_account_wxapp` VALUES ('2', '2', 'x3fe8f8f5M3VlMO8oLelzv8NQO3Mv3Ll', 'zv58Qo4F5MmEO5olEdD8fODf8F88azFm8FANQMomFA8', '1', '', '1', 'sdafasdgdagtry4567', '3gagadfg546425werg', '麦芒团购', '', '');

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
INSERT INTO `mmwl_core_cache` VALUES ('we7:setting', 'a:6:{s:9:"copyright";a:3:{s:6:"slides";a:3:{i:0;s:58:"https://img.alicdn.com/tps/TB1pfG4IFXXXXc6XXXXXXXXXXXX.jpg";i:1;s:58:"https://img.alicdn.com/tps/TB1sXGYIFXXXXc5XpXXXXXXXXXX.jpg";i:2;s:58:"https://img.alicdn.com/tps/TB1h9xxIFXXXXbKXXXXXXXXXXXX.jpg";}s:14:"develop_status";i:2;s:8:"baidumap";a:2:{s:3:"lng";N;s:3:"lat";N;}}s:8:"authmode";i:1;s:5:"close";a:2:{s:6:"status";s:1:"0";s:6:"reason";s:0:"";}s:8:"register";a:4:{s:4:"open";i:1;s:6:"verify";i:0;s:4:"code";i:1;s:7:"groupid";i:1;}s:4:"site";a:3:{s:3:"key";i:189924;s:5:"token";s:32:"aa6f621fec30841328af01fcafb1f2cf";s:3:"url";s:16:"http://mwzxw.top";}s:7:"cloudip";a:2:{s:2:"ip";s:12:"180.96.32.96";s:6:"expire";i:1564130727;}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:userbasefields', 'a:46:{s:7:"uniacid";s:17:"同一公众号id";s:7:"groupid";s:8:"分组id";s:7:"credit1";s:6:"积分";s:7:"credit2";s:6:"余额";s:7:"credit3";s:19:"预留积分类型3";s:7:"credit4";s:19:"预留积分类型4";s:7:"credit5";s:19:"预留积分类型5";s:7:"credit6";s:19:"预留积分类型6";s:10:"createtime";s:12:"加入时间";s:6:"mobile";s:12:"手机号码";s:5:"email";s:12:"电子邮箱";s:8:"realname";s:12:"真实姓名";s:8:"nickname";s:6:"昵称";s:6:"avatar";s:6:"头像";s:2:"qq";s:5:"QQ号";s:6:"gender";s:6:"性别";s:5:"birth";s:6:"生日";s:13:"constellation";s:6:"星座";s:6:"zodiac";s:6:"生肖";s:9:"telephone";s:12:"固定电话";s:6:"idcard";s:12:"证件号码";s:9:"studentid";s:6:"学号";s:5:"grade";s:6:"班级";s:7:"address";s:6:"地址";s:7:"zipcode";s:6:"邮编";s:11:"nationality";s:6:"国籍";s:6:"reside";s:9:"居住地";s:14:"graduateschool";s:12:"毕业学校";s:7:"company";s:6:"公司";s:9:"education";s:6:"学历";s:10:"occupation";s:6:"职业";s:8:"position";s:6:"职位";s:7:"revenue";s:9:"年收入";s:15:"affectivestatus";s:12:"情感状态";s:10:"lookingfor";s:13:" 交友目的";s:9:"bloodtype";s:6:"血型";s:6:"height";s:6:"身高";s:6:"weight";s:6:"体重";s:6:"alipay";s:15:"支付宝帐号";s:3:"msn";s:3:"MSN";s:6:"taobao";s:12:"阿里旺旺";s:4:"site";s:6:"主页";s:3:"bio";s:12:"自我介绍";s:8:"interest";s:12:"兴趣爱好";s:8:"password";s:6:"密码";s:12:"pay_password";s:12:"支付密码";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:usersfields', 'a:47:{s:8:"realname";s:12:"真实姓名";s:8:"nickname";s:6:"昵称";s:6:"avatar";s:6:"头像";s:2:"qq";s:5:"QQ号";s:6:"mobile";s:12:"手机号码";s:3:"vip";s:9:"VIP级别";s:6:"gender";s:6:"性别";s:9:"birthyear";s:12:"出生生日";s:13:"constellation";s:6:"星座";s:6:"zodiac";s:6:"生肖";s:9:"telephone";s:12:"固定电话";s:6:"idcard";s:12:"证件号码";s:9:"studentid";s:6:"学号";s:5:"grade";s:6:"班级";s:7:"address";s:12:"邮寄地址";s:7:"zipcode";s:6:"邮编";s:11:"nationality";s:6:"国籍";s:14:"resideprovince";s:12:"居住地址";s:14:"graduateschool";s:12:"毕业学校";s:7:"company";s:6:"公司";s:9:"education";s:6:"学历";s:10:"occupation";s:6:"职业";s:8:"position";s:6:"职位";s:7:"revenue";s:9:"年收入";s:15:"affectivestatus";s:12:"情感状态";s:10:"lookingfor";s:13:" 交友目的";s:9:"bloodtype";s:6:"血型";s:6:"height";s:6:"身高";s:6:"weight";s:6:"体重";s:6:"alipay";s:15:"支付宝帐号";s:3:"msn";s:3:"MSN";s:5:"email";s:12:"电子邮箱";s:6:"taobao";s:12:"阿里旺旺";s:4:"site";s:6:"主页";s:3:"bio";s:12:"自我介绍";s:8:"interest";s:12:"兴趣爱好";s:7:"uniacid";s:17:"同一公众号id";s:7:"groupid";s:8:"分组id";s:7:"credit1";s:6:"积分";s:7:"credit2";s:6:"余额";s:7:"credit3";s:19:"预留积分类型3";s:7:"credit4";s:19:"预留积分类型4";s:7:"credit5";s:19:"预留积分类型5";s:7:"credit6";s:19:"预留积分类型6";s:10:"createtime";s:12:"加入时间";s:8:"password";s:12:"用户密码";s:12:"pay_password";s:12:"支付密码";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_receive_enable', 'a:0:{}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:system_frame:2', 'a:23:{s:7:"welcome";a:7:{s:5:"title";s:6:"首页";s:4:"icon";s:10:"wi wi-home";s:3:"url";s:48:"./index.php?c=home&a=welcome&do=system&page=home";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:2;}s:8:"platform";a:8:{s:5:"title";s:12:"平台入口";s:4:"icon";s:14:"wi wi-platform";s:9:"dimension";i:2;s:3:"url";s:44:"./index.php?c=account&a=display&do=platform&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:3;}s:6:"module";a:8:{s:5:"title";s:12:"应用入口";s:4:"icon";s:11:"wi wi-apply";s:9:"dimension";i:2;s:3:"url";s:53:"./index.php?c=module&a=display&do=switch_last_module&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:4;}s:14:"account_manage";a:8:{s:5:"title";s:12:"平台管理";s:4:"icon";s:21:"wi wi-platform-manage";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=account&a=manage&";s:7:"section";a:1:{s:14:"account_manage";a:2:{s:5:"title";s:12:"平台管理";s:4:"menu";a:4:{s:22:"account_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"平台列表";s:3:"url";s:31:"./index.php?c=account&a=manage&";s:15:"permission_name";s:22:"account_manage_display";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:1:{i:0;a:2:{s:5:"title";s:12:"帐号停用";s:15:"permission_name";s:19:"account_manage_stop";}}}s:22:"account_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:32:"./index.php?c=account&a=recycle&";s:15:"permission_name";s:22:"account_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"帐号删除";s:15:"permission_name";s:21:"account_manage_delete";}i:1;a:2:{s:5:"title";s:12:"帐号恢复";s:15:"permission_name";s:22:"account_manage_recover";}}}s:30:"account_manage_system_platform";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:19:" 微信开放平台";s:3:"url";s:32:"./index.php?c=system&a=platform&";s:15:"permission_name";s:30:"account_manage_system_platform";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:30:"account_manage_expired_message";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:22:" 自定义到期提示";s:3:"url";s:40:"./index.php?c=account&a=expired-message&";s:15:"permission_name";s:30:"account_manage_expired_message";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:5;}s:13:"module_manage";a:8:{s:5:"title";s:12:"应用管理";s:4:"icon";s:19:"wi wi-module-manage";s:9:"dimension";i:2;s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:7:"section";a:1:{s:13:"module_manage";a:2:{s:5:"title";s:12:"应用管理";s:4:"menu";a:5:{s:23:"module_manage_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已安装列表";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:15:"permission_name";s:23:"module_manage_installed";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:20:"module_manage_stoped";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已停用列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=1";s:15:"permission_name";s:20:"module_manage_stoped";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:27:"module_manage_not_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"未安装列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=not_installed&";s:15:"permission_name";s:27:"module_manage_not_installed";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"module_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=2";s:15:"permission_name";s:21:"module_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:23:"module_manage_subscribe";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"订阅管理";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=subscribe&";s:15:"permission_name";s:23:"module_manage_subscribe";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:6;}s:11:"user_manage";a:8:{s:5:"title";s:12:"用户管理";s:4:"icon";s:16:"wi wi-user-group";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=display&";s:7:"section";a:1:{s:11:"user_manage";a:2:{s:5:"title";s:12:"用户管理";s:4:"menu";a:6:{s:19:"user_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"普通用户";s:3:"url";s:29:"./index.php?c=user&a=display&";s:15:"permission_name";s:19:"user_manage_display";s:4:"icon";N;s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_clerk";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"店员管理";s:3:"url";s:39:"./index.php?c=user&a=display&type=clerk";s:15:"permission_name";s:17:"user_manage_clerk";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"审核用户";s:3:"url";s:39:"./index.php?c=user&a=display&type=check";s:15:"permission_name";s:17:"user_manage_check";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:19:"user_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:41:"./index.php?c=user&a=display&type=recycle";s:15:"permission_name";s:19:"user_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_fields";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户属性设置";s:3:"url";s:39:"./index.php?c=user&a=fields&do=display&";s:15:"permission_name";s:18:"user_manage_fields";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_expire";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户过期设置";s:3:"url";s:28:"./index.php?c=user&a=expire&";s:15:"permission_name";s:18:"user_manage_expire";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:7;}s:10:"permission";a:8:{s:5:"title";s:9:"权限组";s:4:"icon";s:22:"wi wi-userjurisdiction";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=module&a=group&";s:7:"section";a:1:{s:10:"permission";a:2:{s:5:"title";s:9:"权限组";s:4:"menu";a:3:{s:23:"permission_module_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"应用权限组";s:3:"url";s:29:"./index.php?c=module&a=group&";s:15:"permission_name";s:23:"permission_module_group";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:31:"permission_create_account_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"账号权限组";s:3:"url";s:34:"./index.php?c=user&a=create-group&";s:15:"permission_name";s:31:"permission_create_account_group";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"permission_user_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户权限组合";s:3:"url";s:27:"./index.php?c=user&a=group&";s:15:"permission_name";s:21:"permission_user_group";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:8;}s:6:"system";a:8:{s:5:"title";s:12:"系统功能";s:4:"icon";s:13:"wi wi-setting";s:9:"dimension";i:3;s:3:"url";s:31:"./index.php?c=article&a=notice&";s:7:"section";a:4:{s:7:"article";a:3:{s:5:"title";s:12:"站内公告";s:4:"menu";a:1:{s:14:"system_article";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站内公告";s:3:"url";s:31:"./index.php?c=article&a=notice&";s:15:"permission_name";s:14:"system_article";s:4:"icon";s:13:"wi wi-article";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"公告列表";s:15:"permission_name";s:26:"system_article_notice_list";}i:1;a:2:{s:5:"title";s:12:"公告分类";s:15:"permission_name";s:30:"system_article_notice_category";}}}}s:7:"founder";b:1;}s:15:"system_template";a:3:{s:5:"title";s:6:"模板";s:4:"menu";a:1:{s:15:"system_template";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"微官网模板";s:3:"url";s:32:"./index.php?c=system&a=template&";s:15:"permission_name";s:15:"system_template";s:4:"icon";s:17:"wi wi-wx-template";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:3:"sms";a:3:{s:5:"title";s:6:"短信";s:4:"menu";a:1:{s:16:"system_cloud_sms";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"短信管理";s:3:"url";s:26:"./index.php?c=cloud&a=sms&";s:15:"permission_name";s:16:"system_cloud_sms";s:4:"icon";s:9:"wi wi-sms";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:5:"cache";a:2:{s:5:"title";s:6:"缓存";s:4:"menu";a:1:{s:26:"system_setting_updatecache";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"更新缓存";s:3:"url";s:35:"./index.php?c=system&a=updatecache&";s:15:"permission_name";s:26:"system_setting_updatecache";s:4:"icon";s:12:"wi wi-update";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:9;}s:4:"site";a:9:{s:5:"title";s:12:"站点设置";s:4:"icon";s:17:"wi wi-system-site";s:9:"dimension";i:3;s:3:"url";s:30:"./index.php?c=cloud&a=upgrade&";s:7:"section";a:4:{s:5:"cloud";a:2:{s:5:"title";s:9:"云服务";s:4:"menu";a:3:{s:14:"system_profile";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统升级";s:3:"url";s:30:"./index.php?c=cloud&a=upgrade&";s:15:"permission_name";s:20:"system_cloud_upgrade";s:4:"icon";s:11:"wi wi-cache";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_register";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"注册站点";s:3:"url";s:30:"./index.php?c=cloud&a=profile&";s:15:"permission_name";s:21:"system_cloud_register";s:4:"icon";s:18:"wi wi-registersite";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_diagnose";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"云服务诊断";s:3:"url";s:31:"./index.php?c=cloud&a=diagnose&";s:15:"permission_name";s:21:"system_cloud_diagnose";s:4:"icon";s:14:"wi wi-diagnose";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"setting";a:2:{s:5:"title";s:6:"设置";s:4:"menu";a:9:{s:19:"system_setting_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站点设置";s:3:"url";s:28:"./index.php?c=system&a=site&";s:15:"permission_name";s:19:"system_setting_site";s:4:"icon";s:18:"wi wi-site-setting";s:12:"displayorder";i:9;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"菜单设置";s:3:"url";s:28:"./index.php?c=system&a=menu&";s:15:"permission_name";s:19:"system_setting_menu";s:4:"icon";s:18:"wi wi-menu-setting";s:12:"displayorder";i:8;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_attachment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"附件设置";s:3:"url";s:34:"./index.php?c=system&a=attachment&";s:15:"permission_name";s:25:"system_setting_attachment";s:4:"icon";s:16:"wi wi-attachment";s:12:"displayorder";i:7;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_systeminfo";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统信息";s:3:"url";s:34:"./index.php?c=system&a=systeminfo&";s:15:"permission_name";s:25:"system_setting_systeminfo";s:4:"icon";s:17:"wi wi-system-info";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_logs";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"查看日志";s:3:"url";s:28:"./index.php?c=system&a=logs&";s:15:"permission_name";s:19:"system_setting_logs";s:4:"icon";s:9:"wi wi-log";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:26:"system_setting_ipwhitelist";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:11:"IP白名单";s:3:"url";s:35:"./index.php?c=system&a=ipwhitelist&";s:15:"permission_name";s:26:"system_setting_ipwhitelist";s:4:"icon";s:8:"wi wi-ip";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:28:"system_setting_sensitiveword";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"过滤敏感词";s:3:"url";s:37:"./index.php?c=system&a=sensitiveword&";s:15:"permission_name";s:28:"system_setting_sensitiveword";s:4:"icon";s:15:"wi wi-sensitive";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_thirdlogin";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:25:"用户登录/注册设置";s:3:"url";s:33:"./index.php?c=user&a=registerset&";s:15:"permission_name";s:25:"system_setting_thirdlogin";s:4:"icon";s:10:"wi wi-user";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_setting_oauth";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"全局借用权限";s:3:"url";s:29:"./index.php?c=system&a=oauth&";s:15:"permission_name";s:20:"system_setting_oauth";s:4:"icon";s:11:"wi wi-oauth";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"utility";a:2:{s:5:"title";s:12:"常用工具";s:4:"menu";a:6:{s:24:"system_utility_filecheck";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统文件校验";s:3:"url";s:33:"./index.php?c=system&a=filecheck&";s:15:"permission_name";s:24:"system_utility_filecheck";s:4:"icon";s:10:"wi wi-file";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_optimize";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"性能优化";s:3:"url";s:32:"./index.php?c=system&a=optimize&";s:15:"permission_name";s:23:"system_utility_optimize";s:4:"icon";s:14:"wi wi-optimize";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_database";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"数据库";s:3:"url";s:32:"./index.php?c=system&a=database&";s:15:"permission_name";s:23:"system_utility_database";s:4:"icon";s:9:"wi wi-sql";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_utility_scan";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"木马查杀";s:3:"url";s:28:"./index.php?c=system&a=scan&";s:15:"permission_name";s:19:"system_utility_scan";s:4:"icon";s:12:"wi wi-safety";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:18:"system_utility_bom";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"检测文件BOM";s:3:"url";s:27:"./index.php?c=system&a=bom&";s:15:"permission_name";s:18:"system_utility_bom";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_utility_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统常规检测";s:3:"url";s:29:"./index.php?c=system&a=check&";s:15:"permission_name";s:20:"system_utility_check";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"backjob";a:2:{s:5:"title";s:12:"后台任务";s:4:"menu";a:1:{s:10:"system_job";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"后台任务";s:3:"url";s:38:"./index.php?c=system&a=job&do=display&";s:15:"permission_name";s:10:"system_job";s:4:"icon";s:9:"wi wi-job";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:10;}s:6:"myself";a:8:{s:5:"title";s:12:"我的账户";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=profile&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:11;}s:7:"message";a:8:{s:5:"title";s:12:"消息管理";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=message&a=notice&";s:7:"section";a:1:{s:7:"message";a:2:{s:5:"title";s:12:"消息管理";s:4:"menu";a:3:{s:14:"message_notice";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息提醒";s:3:"url";s:31:"./index.php?c=message&a=notice&";s:15:"permission_name";s:14:"message_notice";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:15:"message_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息设置";s:3:"url";s:42:"./index.php?c=message&a=notice&do=setting&";s:15:"permission_name";s:15:"message_setting";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:22:"message_wechat_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"微信提醒设置";s:3:"url";s:49:"./index.php?c=message&a=notice&do=wechat_setting&";s:15:"permission_name";s:22:"message_wechat_setting";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:12;}s:7:"account";a:8:{s:5:"title";s:9:"公众号";s:4:"icon";s:18:"wi wi-white-collar";s:9:"dimension";i:3;s:3:"url";s:41:"./index.php?c=home&a=welcome&do=platform&";s:7:"section";a:4:{s:8:"platform";a:4:{s:5:"title";s:12:"增强功能";s:4:"menu";a:6:{s:14:"platform_reply";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"自动回复";s:3:"url";s:31:"./index.php?c=platform&a=reply&";s:15:"permission_name";s:14:"platform_reply";s:4:"icon";s:11:"wi wi-reply";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:7:{s:22:"platform_reply_keyword";a:4:{s:5:"title";s:21:"关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=keyword";s:15:"permission_name";s:22:"platform_reply_keyword";s:6:"active";s:7:"keyword";}s:22:"platform_reply_special";a:4:{s:5:"title";s:24:"非关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=special";s:15:"permission_name";s:22:"platform_reply_special";s:6:"active";s:7:"special";}s:22:"platform_reply_welcome";a:4:{s:5:"title";s:24:"首次访问自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=welcome";s:15:"permission_name";s:22:"platform_reply_welcome";s:6:"active";s:7:"welcome";}s:22:"platform_reply_default";a:4:{s:5:"title";s:12:"默认回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=default";s:15:"permission_name";s:22:"platform_reply_default";s:6:"active";s:7:"default";}s:22:"platform_reply_service";a:4:{s:5:"title";s:12:"常用服务";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=service";s:15:"permission_name";s:22:"platform_reply_service";s:6:"active";s:7:"service";}s:22:"platform_reply_userapi";a:5:{s:5:"title";s:21:"自定义接口回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=userapi";s:15:"permission_name";s:22:"platform_reply_userapi";s:6:"active";s:7:"userapi";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"platform_reply_setting";a:4:{s:5:"title";s:12:"回复设置";s:3:"url";s:38:"./index.php?c=profile&a=reply-setting&";s:15:"permission_name";s:22:"platform_reply_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:13:"platform_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:15:"自定义菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:13:"platform_menu";s:4:"icon";s:16:"wi wi-custommenu";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:21:"platform_menu_default";a:4:{s:5:"title";s:12:"默认菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:21:"platform_menu_default";s:6:"active";s:4:"post";}s:25:"platform_menu_conditional";a:5:{s:5:"title";s:15:"个性化菜单";s:3:"url";s:47:"./index.php?c=platform&a=menu&do=display&type=3";s:15:"permission_name";s:25:"platform_menu_conditional";s:6:"active";s:7:"display";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:11:"platform_qr";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:22:"二维码/转化链接";s:3:"url";s:28:"./index.php?c=platform&a=qr&";s:15:"permission_name";s:11:"platform_qr";s:4:"icon";s:12:"wi wi-qrcode";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:2:{s:14:"platform_qr_qr";a:4:{s:5:"title";s:9:"二维码";s:3:"url";s:36:"./index.php?c=platform&a=qr&do=list&";s:15:"permission_name";s:14:"platform_qr_qr";s:6:"active";s:4:"list";}s:22:"platform_qr_statistics";a:4:{s:5:"title";s:21:"二维码扫描统计";s:3:"url";s:39:"./index.php?c=platform&a=qr&do=display&";s:15:"permission_name";s:22:"platform_qr_statistics";s:6:"active";s:7:"display";}}}s:17:"platform_masstask";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"定时群发";s:3:"url";s:30:"./index.php?c=platform&a=mass&";s:15:"permission_name";s:17:"platform_masstask";s:4:"icon";s:13:"wi wi-crontab";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:22:"platform_masstask_post";a:4:{s:5:"title";s:12:"定时群发";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=post&";s:15:"permission_name";s:22:"platform_masstask_post";s:6:"active";s:4:"post";}s:22:"platform_masstask_send";a:4:{s:5:"title";s:12:"群发记录";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=send&";s:15:"permission_name";s:22:"platform_masstask_send";s:6:"active";s:4:"send";}}}s:17:"platform_material";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:16:"素材/编辑器";s:3:"url";s:34:"./index.php?c=platform&a=material&";s:15:"permission_name";s:17:"platform_material";s:4:"icon";s:12:"wi wi-redact";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:5:{s:22:"platform_material_news";a:4:{s:5:"title";s:6:"图文";s:3:"url";s:43:"./index.php?c=platform&a=material&type=news";s:15:"permission_name";s:22:"platform_material_news";s:6:"active";s:4:"news";}s:23:"platform_material_image";a:4:{s:5:"title";s:6:"图片";s:3:"url";s:44:"./index.php?c=platform&a=material&type=image";s:15:"permission_name";s:23:"platform_material_image";s:6:"active";s:5:"image";}s:23:"platform_material_voice";a:4:{s:5:"title";s:6:"语音";s:3:"url";s:44:"./index.php?c=platform&a=material&type=voice";s:15:"permission_name";s:23:"platform_material_voice";s:6:"active";s:5:"voice";}s:23:"platform_material_video";a:5:{s:5:"title";s:6:"视频";s:3:"url";s:44:"./index.php?c=platform&a=material&type=video";s:15:"permission_name";s:23:"platform_material_video";s:6:"active";s:5:"video";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"platform_material_delete";a:3:{s:5:"title";s:6:"删除";s:15:"permission_name";s:24:"platform_material_delete";s:10:"is_display";b:0;}}}s:13:"platform_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:16:"微官网-文章";s:3:"url";s:27:"./index.php?c=site&a=multi&";s:15:"permission_name";s:13:"platform_site";s:4:"icon";s:10:"wi wi-home";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:19:"platform_site_multi";a:4:{s:5:"title";s:9:"微官网";s:3:"url";s:38:"./index.php?c=site&a=multi&do=display&";s:15:"permission_name";s:19:"platform_site_multi";s:6:"active";s:5:"multi";}s:19:"platform_site_style";a:4:{s:5:"title";s:15:"微官网模板";s:3:"url";s:39:"./index.php?c=site&a=style&do=template&";s:15:"permission_name";s:19:"platform_site_style";s:6:"active";s:5:"style";}s:21:"platform_site_article";a:4:{s:5:"title";s:12:"文章管理";s:3:"url";s:40:"./index.php?c=site&a=article&do=display&";s:15:"permission_name";s:21:"platform_site_article";s:6:"active";s:7:"article";}s:22:"platform_site_category";a:4:{s:5:"title";s:18:"文章分类管理";s:3:"url";s:41:"./index.php?c=site&a=category&do=display&";s:15:"permission_name";s:22:"platform_site_category";s:6:"active";s:8:"category";}}}}s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;}s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:4:{s:5:"title";s:6:"粉丝";s:4:"menu";a:3:{s:7:"mc_fans";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"粉丝管理";s:3:"url";s:24:"./index.php?c=mc&a=fans&";s:15:"permission_name";s:7:"mc_fans";s:4:"icon";s:16:"wi wi-fansmanage";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:15:"mc_fans_display";a:4:{s:5:"title";s:12:"全部粉丝";s:3:"url";s:35:"./index.php?c=mc&a=fans&do=display&";s:15:"permission_name";s:15:"mc_fans_display";s:6:"active";s:7:"display";}s:21:"mc_fans_fans_sync_set";a:4:{s:5:"title";s:18:"粉丝同步设置";s:3:"url";s:41:"./index.php?c=mc&a=fans&do=fans_sync_set&";s:15:"permission_name";s:21:"mc_fans_fans_sync_set";s:6:"active";s:13:"fans_sync_set";}}}s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"会员管理";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:9:"mc_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:7:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:12:"mc_member_uc";a:5:{s:5:"title";s:12:"会员中心";s:3:"url";s:34:"./index.php?c=site&a=editor&do=uc&";s:15:"permission_name";s:12:"mc_member_uc";s:6:"active";s:2:"uc";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:19:"mc_member_quickmenu";a:5:{s:5:"title";s:12:"快捷菜单";s:3:"url";s:41:"./index.php?c=site&a=editor&do=quickmenu&";s:15:"permission_name";s:19:"mc_member_quickmenu";s:6:"active";s:9:"quickmenu";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"mc_member_register_seting";a:5:{s:5:"title";s:12:"注册设置";s:3:"url";s:46:"./index.php?c=mc&a=member&do=register_setting&";s:15:"permission_name";s:25:"mc_member_register_seting";s:6:"active";s:16:"register_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}s:10:"mc_message";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"留言管理";s:3:"url";s:27:"./index.php?c=mc&a=message&";s:15:"permission_name";s:10:"mc_message";s:4:"icon";s:13:"wi wi-message";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;}s:7:"profile";a:4:{s:5:"title";s:6:"配置";s:4:"menu";a:5:{s:15:"profile_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:15:"profile_setting";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:6:{s:22:"profile_setting_remote";a:4:{s:5:"title";s:12:"远程附件";s:3:"url";s:42:"./index.php?c=profile&a=remote&do=display&";s:15:"permission_name";s:22:"profile_setting_remote";s:6:"active";s:7:"display";}s:24:"profile_setting_passport";a:5:{s:5:"title";s:12:"借用权限";s:3:"url";s:42:"./index.php?c=profile&a=passport&do=oauth&";s:15:"permission_name";s:24:"profile_setting_passport";s:6:"active";s:5:"oauth";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"profile_setting_tplnotice";a:5:{s:5:"title";s:18:"微信通知设置";s:3:"url";s:42:"./index.php?c=profile&a=tplnotice&do=list&";s:15:"permission_name";s:25:"profile_setting_tplnotice";s:6:"active";s:4:"list";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"profile_setting_notify";a:5:{s:5:"title";s:18:"邮件通知参数";s:3:"url";s:39:"./index.php?c=profile&a=notify&do=mail&";s:15:"permission_name";s:22:"profile_setting_notify";s:6:"active";s:4:"mail";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:26:"profile_setting_uc_setting";a:5:{s:5:"title";s:14:"UC站点整合";s:3:"url";s:45:"./index.php?c=profile&a=common&do=uc_setting&";s:15:"permission_name";s:26:"profile_setting_uc_setting";s:6:"active";s:10:"uc_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:27:"profile_setting_upload_file";a:5:{s:5:"title";s:20:"上传JS接口文件";s:3:"url";s:46:"./index.php?c=profile&a=common&do=upload_file&";s:15:"permission_name";s:27:"profile_setting_upload_file";s:6:"active";s:11:"upload_file";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:15:"profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:12:"支付参数";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:15:"profile_payment";s:4:"icon";s:17:"wi wi-pay-setting";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:2:{s:19:"profile_payment_pay";a:4:{s:5:"title";s:12:"支付配置";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:19:"profile_payment_pay";s:6:"active";s:7:"payment";}s:22:"profile_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:42:"./index.php?c=profile&a=refund&do=display&";s:15:"permission_name";s:22:"profile_payment_refund";s:6:"active";s:6:"refund";}}}s:23:"profile_app_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:31:"profile_app_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:18:"webapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:18:"webapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:14:"webapp_rewrite";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:9:"伪静态";s:3:"url";s:31:"./index.php?c=webapp&a=rewrite&";s:15:"permission_name";s:14:"webapp_rewrite";s:4:"icon";s:13:"wi wi-rewrite";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:13;}s:5:"wxapp";a:8:{s:5:"title";s:15:"微信小程序";s:4:"icon";s:19:"wi wi-small-routine";s:9:"dimension";i:3;s:3:"url";s:38:"./index.php?c=wxapp&a=display&do=home&";s:7:"section";a:5:{s:14:"wxapp_entrance";a:3:{s:5:"title";s:15:"小程序入口";s:4:"menu";a:1:{s:20:"module_entrance_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:1;s:5:"title";s:12:"入口页面";s:3:"url";s:36:"./index.php?c=wxapp&a=entrance-link&";s:15:"permission_name";s:19:"wxapp_entrance_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}}s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:3:{s:5:"title";s:6:"粉丝";s:4:"menu";a:1:{s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:1;s:5:"title";s:6:"会员";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:15:"mc_wxapp_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}}s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}}s:13:"wxapp_profile";a:3:{s:5:"title";s:6:"配置";s:4:"menu";a:5:{s:33:"wxapp_profile_module_link_uniacid";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:1;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:33:"wxapp_profile_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:21:"wxapp_profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:1;s:5:"title";s:12:"支付参数";s:3:"url";s:30:"./index.php?c=wxapp&a=payment&";s:15:"permission_name";s:21:"wxapp_profile_payment";s:4:"icon";s:16:"wi wi-appsetting";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:17:"wxapp_payment_pay";a:4:{s:5:"title";s:12:"支付参数";s:3:"url";s:41:"./index.php?c=wxapp&a=payment&do=display&";s:15:"permission_name";s:17:"wxapp_payment_pay";s:6:"active";s:7:"payment";}s:20:"wxapp_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:40:"./index.php?c=wxapp&a=refund&do=display&";s:15:"permission_name";s:20:"wxapp_payment_refund";s:6:"active";s:6:"refund";}}}s:28:"wxapp_profile_front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";i:1;s:10:"is_display";i:1;s:5:"title";s:15:"下载程序包";s:3:"url";s:37:"./index.php?c=wxapp&a=front-download&";s:15:"permission_name";s:28:"wxapp_profile_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:23:"wxapp_profile_domainset";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:1;s:5:"title";s:12:"域名设置";s:3:"url";s:32:"./index.php?c=wxapp&a=domainset&";s:15:"permission_name";s:23:"wxapp_profile_domainset";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:22:"profile_setting_remote";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:1;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:22:"profile_setting_remote";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}}s:10:"statistics";a:3:{s:5:"title";s:6:"统计";s:4:"menu";a:1:{s:16:"statistics_visit";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:1;s:5:"title";s:12:"访问统计";s:3:"url";s:31:"./index.php?c=statistics&a=app&";s:15:"permission_name";s:22:"statistics_visit_wxapp";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:3:{s:20:"statistics_visit_app";a:4:{s:5:"title";s:24:"app端访问统计信息";s:3:"url";s:42:"./index.php?c=statistics&a=app&do=display&";s:15:"permission_name";s:20:"statistics_visit_app";s:6:"active";s:3:"app";}s:21:"statistics_visit_site";a:4:{s:5:"title";s:24:"所有用户访问统计";s:3:"url";s:51:"./index.php?c=statistics&a=site&do=current_account&";s:15:"permission_name";s:21:"statistics_visit_site";s:6:"active";s:4:"site";}s:24:"statistics_visit_setting";a:4:{s:5:"title";s:18:"访问统计设置";s:3:"url";s:46:"./index.php?c=statistics&a=setting&do=display&";s:15:"permission_name";s:24:"statistics_visit_setting";s:6:"active";s:7:"setting";}}}}s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:14;}s:6:"webapp";a:7:{s:5:"title";s:2:"PC";s:4:"icon";s:8:"wi wi-pc";s:3:"url";s:39:"./index.php?c=webapp&a=home&do=display&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:15;}s:8:"phoneapp";a:7:{s:5:"title";s:3:"APP";s:4:"icon";s:18:"wi wi-white-collar";s:3:"url";s:41:"./index.php?c=phoneapp&a=display&do=home&";s:7:"section";a:2:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:16:"phoneapp_profile";a:4:{s:5:"title";s:6:"配置";s:4:"menu";a:2:{s:28:"profile_phoneapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:6;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:28:"profile_phoneapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:14:"front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";b:1;s:10:"is_display";i:1;s:5:"title";s:9:"下载APP";s:3:"url";s:40:"./index.php?c=phoneapp&a=front-download&";s:15:"permission_name";s:23:"phoneapp_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";b:1;s:18:"permission_display";a:1:{i:0;i:6;}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:16;}s:5:"xzapp";a:7:{s:5:"title";s:9:"熊掌号";s:4:"icon";s:11:"wi wi-xzapp";s:3:"url";s:38:"./index.php?c=xzapp&a=home&do=display&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:17;}s:6:"aliapp";a:7:{s:5:"title";s:18:"支付宝小程序";s:4:"icon";s:12:"wi wi-aliapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:18;}s:8:"baiduapp";a:7:{s:5:"title";s:15:"百度小程序";s:4:"icon";s:14:"wi wi-baiduapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:19;}s:10:"toutiaoapp";a:7:{s:5:"title";s:15:"头条小程序";s:4:"icon";s:16:"wi wi-toutiaoapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:20;}s:9:"appmarket";a:9:{s:5:"title";s:6:"市场";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:14:"http://s.w7.cc";s:7:"section";a:0:{}s:5:"blank";b:1;s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:21;}s:9:"workorder";a:9:{s:5:"title";s:6:"工单";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:44:"./index.php?c=system&a=workorder&do=display&";s:7:"section";a:1:{s:9:"workorder";a:2:{s:5:"title";s:12:"工单系统";s:4:"menu";a:1:{s:16:"system_workorder";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"工单系统";s:3:"url";s:44:"./index.php?c=system&a=workorder&do=display&";s:15:"permission_name";s:16:"system_workorder";s:4:"icon";s:17:"wi wi-system-work";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:22;}s:4:"help";a:7:{s:5:"title";s:6:"帮助";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:29:"./index.php?c=help&a=display&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:23;}s:11:"custom_help";a:7:{s:5:"title";s:12:"本站帮助";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:39:"./index.php?c=help&a=display&do=custom&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:24;}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:group_buy_plugin_seckill', 'a:36:{s:3:"mid";s:2:"16";s:4:"name";s:24:"group_buy_plugin_seckill";s:4:"type";s:8:"business";s:5:"title";s:30:"麦芒社区团购整点秒杀";s:7:"version";s:6:"1.0.13";s:7:"ability";s:30:"麦芒社区团购整点秒杀";s:11:"description";s:30:"麦芒社区团购整点秒杀";s:6:"author";s:6:"scmmwl";s:3:"url";s:22:"http://www.scmmwl.com/";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:0:{}s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"0";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:6:"a:0:{}";s:13:"title_initial";s:1:"M";s:13:"wxapp_support";s:1:"2";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"1";s:15:"account_support";s:1:"1";s:13:"xzapp_support";s:1:"1";s:14:"aliapp_support";s:1:"1";s:4:"logo";s:58:"http://127.0.0.35/addons/group_buy_plugin_seckill/icon.jpg";s:16:"baiduapp_support";s:1:"1";s:18:"toutiaoapp_support";s:1:"1";s:4:"from";s:5:"local";s:9:"isdisplay";i:1;s:7:"preview";s:74:"http://127.0.0.35/addons/group_buy_plugin_seckill/preview.jpg?v=1563421805";s:11:"main_module";s:9:"group_buy";s:16:"main_module_logo";s:43:"http://127.0.0.35/addons/group_buy/icon.jpg";s:17:"main_module_title";s:18:"麦芒社区团购";s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:group_buy_plugin_seckill:2', 'a:1:{s:6:"module";s:24:"group_buy_plugin_seckill";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:group_buy_plugin_distribution', 'a:36:{s:3:"mid";s:2:"15";s:4:"name";s:29:"group_buy_plugin_distribution";s:4:"type";s:8:"business";s:5:"title";s:36:"麦芒社区团购拼团分销插件";s:7:"version";s:6:"1.0.20";s:7:"ability";s:36:"麦芒社区团购拼团分销插件";s:11:"description";s:36:"麦芒社区团购拼团分销插件";s:6:"author";s:6:"scmmwl";s:3:"url";s:22:"http://www.scmmwl.com/";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:0:{}s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"0";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:6:"a:0:{}";s:13:"title_initial";s:1:"M";s:13:"wxapp_support";s:1:"2";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"1";s:15:"account_support";s:1:"1";s:13:"xzapp_support";s:1:"1";s:14:"aliapp_support";s:1:"1";s:4:"logo";s:63:"http://127.0.0.35/addons/group_buy_plugin_distribution/icon.jpg";s:16:"baiduapp_support";s:1:"1";s:18:"toutiaoapp_support";s:1:"1";s:4:"from";s:5:"local";s:9:"isdisplay";i:1;s:7:"preview";s:79:"http://127.0.0.35/addons/group_buy_plugin_distribution/preview.jpg?v=1563421805";s:11:"main_module";s:9:"group_buy";s:16:"main_module_logo";s:43:"http://127.0.0.35/addons/group_buy/icon.jpg";s:17:"main_module_title";s:18:"麦芒社区团购";s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:group_buy_plugin_distribution:2', 'a:1:{s:6:"module";s:29:"group_buy_plugin_distribution";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:group_buy_plugin_fraction', 'a:36:{s:3:"mid";s:2:"14";s:4:"name";s:25:"group_buy_plugin_fraction";s:4:"type";s:8:"business";s:5:"title";s:18:"积分商城插件";s:7:"version";s:5:"1.0.5";s:7:"ability";s:18:"积分商城插件";s:11:"description";s:18:"积分商城插件";s:6:"author";s:2:"zd";s:3:"url";s:22:"http://www.scmmwl.com/";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:0:{}s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"0";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:6:"a:0:{}";s:13:"title_initial";s:1:"J";s:13:"wxapp_support";s:1:"2";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"1";s:15:"account_support";s:1:"1";s:13:"xzapp_support";s:1:"1";s:14:"aliapp_support";s:1:"1";s:4:"logo";s:59:"http://127.0.0.35/addons/group_buy_plugin_fraction/icon.jpg";s:16:"baiduapp_support";s:1:"1";s:18:"toutiaoapp_support";s:1:"1";s:4:"from";s:5:"local";s:9:"isdisplay";i:1;s:7:"preview";s:75:"http://127.0.0.35/addons/group_buy_plugin_fraction/preview.jpg?v=1563421805";s:11:"main_module";s:9:"group_buy";s:16:"main_module_logo";s:43:"http://127.0.0.35/addons/group_buy/icon.jpg";s:17:"main_module_title";s:18:"麦芒社区团购";s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:group_buy_plugin_fraction:2', 'a:1:{s:6:"module";s:25:"group_buy_plugin_fraction";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:user_modules:1', 'a:4:{s:9:"group_buy";s:3:"all";s:25:"group_buy_plugin_fraction";s:3:"all";s:29:"group_buy_plugin_distribution";s:3:"all";s:24:"group_buy_plugin_seckill";s:3:"all";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:basic', 'a:35:{s:3:"mid";s:1:"1";s:4:"name";s:5:"basic";s:4:"type";s:6:"system";s:5:"title";s:18:"基本文字回复";s:7:"version";s:3:"1.0";s:7:"ability";s:24:"和您进行简单对话";s:11:"description";s:201:"一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:55:"http://127.0.0.35/addons/basic/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:basic:2', 'a:1:{s:6:"module";s:5:"basic";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:news', 'a:35:{s:3:"mid";s:1:"2";s:4:"name";s:4:"news";s:4:"type";s:6:"system";s:5:"title";s:24:"基本混合图文回复";s:7:"version";s:3:"1.0";s:7:"ability";s:33:"为你提供生动的图文资讯";s:11:"description";s:272:"一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:54:"http://127.0.0.35/addons/news/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:news:2', 'a:1:{s:6:"module";s:4:"news";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:music', 'a:35:{s:3:"mid";s:1:"3";s:4:"name";s:5:"music";s:4:"type";s:6:"system";s:5:"title";s:18:"基本音乐回复";s:7:"version";s:3:"1.0";s:7:"ability";s:39:"提供语音、音乐等音频类回复";s:11:"description";s:183:"在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:55:"http://127.0.0.35/addons/music/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:music:2', 'a:1:{s:6:"module";s:5:"music";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:userapi', 'a:35:{s:3:"mid";s:1:"4";s:4:"name";s:7:"userapi";s:4:"type";s:6:"system";s:5:"title";s:21:"自定义接口回复";s:7:"version";s:3:"1.1";s:7:"ability";s:33:"更方便的第三方接口设置";s:11:"description";s:141:"自定义接口又称第三方接口，可以让开发者更方便的接入微擎系统，高效的与微信公众平台进行对接整合。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:57:"http://127.0.0.35/addons/userapi/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:userapi:2', 'a:1:{s:6:"module";s:7:"userapi";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:recharge', 'a:35:{s:3:"mid";s:1:"5";s:4:"name";s:8:"recharge";s:4:"type";s:6:"system";s:5:"title";s:24:"会员中心充值模块";s:7:"version";s:3:"1.0";s:7:"ability";s:24:"提供会员充值功能";s:11:"description";s:0:"";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:58:"http://127.0.0.35/addons/recharge/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:recharge:2', 'a:1:{s:6:"module";s:8:"recharge";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:images', 'a:35:{s:3:"mid";s:1:"7";s:4:"name";s:6:"images";s:4:"type";s:6:"system";s:5:"title";s:18:"基本图片回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"提供图片回复";s:11:"description";s:132:"在回复规则中可选择具有图片的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝图片。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:56:"http://127.0.0.35/addons/images/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:images:2', 'a:1:{s:6:"module";s:6:"images";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:video', 'a:35:{s:3:"mid";s:1:"8";s:4:"name";s:5:"video";s:4:"type";s:6:"system";s:5:"title";s:18:"基本视频回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"提供图片回复";s:11:"description";s:132:"在回复规则中可选择具有视频的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝视频。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:55:"http://127.0.0.35/addons/video/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:video:2', 'a:1:{s:6:"module";s:5:"video";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:voice', 'a:35:{s:3:"mid";s:1:"9";s:4:"name";s:5:"voice";s:4:"type";s:6:"system";s:5:"title";s:18:"基本语音回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"提供语音回复";s:11:"description";s:132:"在回复规则中可选择具有语音的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝语音。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:55:"http://127.0.0.35/addons/voice/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:voice:2', 'a:1:{s:6:"module";s:5:"voice";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:wxcard', 'a:35:{s:3:"mid";s:2:"11";s:4:"name";s:6:"wxcard";s:4:"type";s:6:"system";s:5:"title";s:18:"微信卡券回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"微信卡券回复";s:11:"description";s:18:"微信卡券回复";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:56:"http://127.0.0.35/addons/wxcard/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:wxcard:2', 'a:1:{s:6:"module";s:6:"wxcard";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:custom', 'a:35:{s:3:"mid";s:1:"6";s:4:"name";s:6:"custom";s:4:"type";s:6:"system";s:5:"title";s:15:"多客服转接";s:7:"version";s:5:"1.0.0";s:7:"ability";s:36:"用来接入腾讯的多客服系统";s:11:"description";s:0:"";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:17:"http://bbs.we7.cc";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:6:{i:0;s:5:"image";i:1;s:5:"voice";i:2;s:5:"video";i:3;s:8:"location";i:4;s:4:"link";i:5;s:4:"text";}s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:56:"http://127.0.0.35/addons/custom/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:custom:2', 'a:1:{s:6:"module";s:6:"custom";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:chats', 'a:35:{s:3:"mid";s:2:"10";s:4:"name";s:5:"chats";s:4:"type";s:6:"system";s:5:"title";s:18:"发送客服消息";s:7:"version";s:3:"1.0";s:7:"ability";s:77:"公众号可以在粉丝最后发送消息的48小时内无限制发送消息";s:11:"description";s:0:"";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:55:"http://127.0.0.35/addons/chats/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:chats:2', 'a:1:{s:6:"module";s:5:"chats";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:store', 'a:35:{s:3:"mid";s:2:"12";s:4:"name";s:5:"store";s:4:"type";s:8:"business";s:5:"title";s:12:"站内商城";s:7:"version";s:3:"1.0";s:7:"ability";s:12:"站内商城";s:11:"description";s:12:"站内商城";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:4:"from";s:0:"";s:9:"isdisplay";i:1;s:7:"preview";s:55:"http://127.0.0.35/addons/store/preview.jpg?v=1563421805";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:store:2', 'a:1:{s:6:"module";s:5:"store";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:unisetting:2', 'a:31:{s:7:"uniacid";s:1:"2";s:8:"passport";s:0:"";s:5:"oauth";s:0:"";s:11:"jsauth_acid";s:1:"0";s:2:"uc";s:0:"";s:6:"notify";s:0:"";s:11:"creditnames";a:2:{s:7:"credit1";a:2:{s:5:"title";s:6:"积分";s:7:"enabled";i:1;}s:7:"credit2";a:2:{s:5:"title";s:6:"余额";s:7:"enabled";i:1;}}s:15:"creditbehaviors";a:2:{s:8:"activity";s:7:"credit1";s:8:"currency";s:7:"credit2";}s:7:"welcome";s:0:"";s:7:"default";s:0:"";s:15:"default_message";s:0:"";s:7:"payment";a:1:{s:6:"wechat";a:3:{s:5:"mchid";s:14:"asdf2134fads-=";s:7:"signkey";s:13:"sdfewrgm-==-a";s:7:"account";i:2;}}s:4:"stat";s:0:"";s:12:"default_site";N;s:4:"sync";s:1:"0";s:8:"recharge";s:0:"";s:9:"tplnotice";s:0:"";s:10:"grouplevel";s:1:"0";s:8:"mcplugin";s:0:"";s:15:"exchange_enable";s:1:"0";s:11:"coupon_type";s:1:"0";s:7:"menuset";s:0:"";s:10:"statistics";s:0:"";s:11:"bind_domain";s:0:"";s:14:"comment_status";s:1:"0";s:13:"reply_setting";s:1:"0";s:14:"default_module";s:0:"";s:16:"attachment_limit";N;s:15:"attachment_size";N;s:11:"sync_member";s:1:"0";s:6:"remote";s:0:"";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:uniaccount:2', 'a:13:{s:4:"acid";s:1:"2";s:7:"uniacid";s:1:"2";s:5:"token";s:32:"x3fe8f8f5M3VlMO8oLelzv8NQO3Mv3Ll";s:14:"encodingaeskey";s:43:"zv58Qo4F5MmEO5olEdD8fODf8F88azFm8FANQMomFA8";s:5:"level";s:1:"1";s:7:"account";s:0:"";s:8:"original";s:1:"1";s:3:"key";s:18:"sdafasdgdagtry4567";s:6:"secret";s:18:"3gagadfg546425werg";s:4:"name";s:12:"麦芒团购";s:9:"appdomain";s:0:"";s:18:"auth_refresh_token";s:0:"";s:11:"encrypt_key";s:18:"sdafasdgdagtry4567";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_info:group_buy', 'a:35:{s:3:"mid";s:2:"13";s:4:"name";s:9:"group_buy";s:4:"type";s:8:"business";s:5:"title";s:18:"麦芒社区团购";s:7:"version";s:6:"2.0.69";s:7:"ability";s:27:"包含社区团购等功能";s:11:"description";s:27:"包含社区团购等功能";s:6:"author";s:6:"scmmwl";s:3:"url";s:22:"http://www.scmmwl.com/";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:0:{}s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"0";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:6:"a:0:{}";s:13:"title_initial";s:1:"M";s:13:"wxapp_support";s:1:"2";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"1";s:15:"account_support";s:1:"1";s:13:"xzapp_support";s:1:"1";s:14:"aliapp_support";s:1:"1";s:4:"logo";s:43:"http://127.0.0.35/addons/group_buy/icon.jpg";s:16:"baiduapp_support";s:1:"1";s:18:"toutiaoapp_support";s:1:"1";s:4:"from";s:5:"local";s:9:"isdisplay";i:1;s:7:"preview";s:59:"http://127.0.0.35/addons/group_buy/preview.jpg?v=1563421808";s:11:"main_module";b:0;s:11:"plugin_list";a:3:{i:0;s:25:"group_buy_plugin_fraction";i:1;s:29:"group_buy_plugin_distribution";i:2;s:24:"group_buy_plugin_seckill";}s:12:"recycle_info";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:module_setting:group_buy:2', 'a:1:{s:6:"module";s:9:"group_buy";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:miniapp_version:1', 'a:19:{s:2:"id";s:1:"1";s:7:"uniacid";s:1:"2";s:7:"multiid";s:1:"0";s:7:"version";s:5:"1.0.0";s:11:"description";s:5:"1.0.0";s:7:"modules";a:1:{s:29:"group_buy_plugin_distribution";a:44:{s:3:"mid";s:2:"15";s:4:"name";s:29:"group_buy_plugin_distribution";s:4:"type";s:8:"business";s:5:"title";s:36:"麦芒社区团购拼团分销插件";s:7:"version";s:6:"1.0.20";s:7:"ability";s:36:"麦芒社区团购拼团分销插件";s:11:"description";s:36:"麦芒社区团购拼团分销插件";s:6:"author";s:6:"scmmwl";s:3:"url";s:22:"http://www.scmmwl.com/";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:0:{}s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"0";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:6:"a:0:{}";s:13:"title_initial";s:1:"M";s:13:"wxapp_support";s:1:"2";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"1";s:15:"account_support";s:1:"1";s:13:"xzapp_support";s:1:"1";s:14:"aliapp_support";s:1:"1";s:4:"logo";s:63:"http://127.0.0.35/addons/group_buy_plugin_distribution/icon.jpg";s:16:"baiduapp_support";s:1:"1";s:18:"toutiaoapp_support";s:1:"1";s:4:"from";s:5:"local";s:9:"isdisplay";i:1;s:7:"preview";s:79:"http://127.0.0.35/addons/group_buy_plugin_distribution/preview.jpg?v=1563421805";s:11:"main_module";s:9:"group_buy";s:16:"main_module_logo";s:43:"http://127.0.0.35/addons/group_buy/icon.jpg";s:17:"main_module_title";s:18:"麦芒社区团购";s:12:"recycle_info";a:0:{}s:6:"config";a:0:{}s:7:"enabled";i:1;s:12:"displayorder";N;s:8:"shortcut";N;s:15:"module_shortcut";N;s:12:"cover_entrys";a:0:{}s:12:"defaultentry";N;s:7:"newicon";N;}}s:13:"design_method";s:1:"3";s:8:"template";s:1:"0";s:9:"quickmenu";s:0:"";s:10:"createtime";s:10:"1563416812";s:4:"type";s:1:"0";s:8:"entry_id";s:1:"0";s:7:"appjson";s:0:"";s:15:"default_appjson";s:0:"";s:11:"use_default";s:1:"0";s:12:"last_modules";a:0:{}s:13:"tominiprogram";a:0:{}s:11:"upload_time";s:1:"0";s:12:"cover_entrys";a:0:{}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:user_accounts:wechats:1', 'a:0:{}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:user_accounts:wxapp:1', 'a:1:{i:2;a:8:{s:4:"acid";s:1:"2";s:7:"uniacid";s:1:"2";s:4:"name";s:12:"麦芒团购";s:4:"type";s:1:"4";s:5:"level";s:1:"1";s:3:"key";s:18:"sdafasdgdagtry4567";s:6:"secret";s:18:"3gagadfg546425werg";s:5:"token";s:32:"x3fe8f8f5M3VlMO8oLelzv8NQO3Mv3Ll";}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:user_accounts:webapp:1', 'a:0:{}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:user_accounts:phoneapp:1', 'a:0:{}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:user_accounts:xzapp:1', 'a:0:{}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:user_accounts:aliapp:1', 'a:0:{}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:user_accounts:baiduapp:1', 'a:0:{}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:user_accounts:toutiaoapp:1', 'a:0:{}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:', 'a:2:{s:6:"expire";i:1563518724;s:4:"data";a:2:{s:5:"errno";i:-1;s:7:"message";s:84:"本域名为非微擎授权域名，请更换微擎授权域名后，再进行操作";}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:uniaccount:', 'a:1:{s:11:"encrypt_key";N;}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:system_frame:0', 'a:23:{s:7:"welcome";a:7:{s:5:"title";s:6:"首页";s:4:"icon";s:10:"wi wi-home";s:3:"url";s:48:"./index.php?c=home&a=welcome&do=system&page=home";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:2;}s:8:"platform";a:8:{s:5:"title";s:12:"平台入口";s:4:"icon";s:14:"wi wi-platform";s:9:"dimension";i:2;s:3:"url";s:44:"./index.php?c=account&a=display&do=platform&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:3;}s:6:"module";a:8:{s:5:"title";s:12:"应用入口";s:4:"icon";s:11:"wi wi-apply";s:9:"dimension";i:2;s:3:"url";s:53:"./index.php?c=module&a=display&do=switch_last_module&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:4;}s:14:"account_manage";a:8:{s:5:"title";s:12:"平台管理";s:4:"icon";s:21:"wi wi-platform-manage";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=account&a=manage&";s:7:"section";a:1:{s:14:"account_manage";a:2:{s:5:"title";s:12:"平台管理";s:4:"menu";a:4:{s:22:"account_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"平台列表";s:3:"url";s:31:"./index.php?c=account&a=manage&";s:15:"permission_name";s:22:"account_manage_display";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:1:{i:0;a:2:{s:5:"title";s:12:"帐号停用";s:15:"permission_name";s:19:"account_manage_stop";}}}s:22:"account_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:32:"./index.php?c=account&a=recycle&";s:15:"permission_name";s:22:"account_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"帐号删除";s:15:"permission_name";s:21:"account_manage_delete";}i:1;a:2:{s:5:"title";s:12:"帐号恢复";s:15:"permission_name";s:22:"account_manage_recover";}}}s:30:"account_manage_system_platform";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:19:" 微信开放平台";s:3:"url";s:32:"./index.php?c=system&a=platform&";s:15:"permission_name";s:30:"account_manage_system_platform";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:30:"account_manage_expired_message";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:22:" 自定义到期提示";s:3:"url";s:40:"./index.php?c=account&a=expired-message&";s:15:"permission_name";s:30:"account_manage_expired_message";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:5;}s:13:"module_manage";a:8:{s:5:"title";s:12:"应用管理";s:4:"icon";s:19:"wi wi-module-manage";s:9:"dimension";i:2;s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:7:"section";a:1:{s:13:"module_manage";a:2:{s:5:"title";s:12:"应用管理";s:4:"menu";a:5:{s:23:"module_manage_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已安装列表";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:15:"permission_name";s:23:"module_manage_installed";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:20:"module_manage_stoped";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已停用列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=1";s:15:"permission_name";s:20:"module_manage_stoped";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:27:"module_manage_not_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"未安装列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=not_installed&";s:15:"permission_name";s:27:"module_manage_not_installed";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"module_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=2";s:15:"permission_name";s:21:"module_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:23:"module_manage_subscribe";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"订阅管理";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=subscribe&";s:15:"permission_name";s:23:"module_manage_subscribe";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:6;}s:11:"user_manage";a:8:{s:5:"title";s:12:"用户管理";s:4:"icon";s:16:"wi wi-user-group";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=display&";s:7:"section";a:1:{s:11:"user_manage";a:2:{s:5:"title";s:12:"用户管理";s:4:"menu";a:6:{s:19:"user_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"普通用户";s:3:"url";s:29:"./index.php?c=user&a=display&";s:15:"permission_name";s:19:"user_manage_display";s:4:"icon";N;s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_clerk";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"店员管理";s:3:"url";s:39:"./index.php?c=user&a=display&type=clerk";s:15:"permission_name";s:17:"user_manage_clerk";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"审核用户";s:3:"url";s:39:"./index.php?c=user&a=display&type=check";s:15:"permission_name";s:17:"user_manage_check";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:19:"user_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:41:"./index.php?c=user&a=display&type=recycle";s:15:"permission_name";s:19:"user_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_fields";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户属性设置";s:3:"url";s:39:"./index.php?c=user&a=fields&do=display&";s:15:"permission_name";s:18:"user_manage_fields";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_expire";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户过期设置";s:3:"url";s:28:"./index.php?c=user&a=expire&";s:15:"permission_name";s:18:"user_manage_expire";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:7;}s:10:"permission";a:8:{s:5:"title";s:9:"权限组";s:4:"icon";s:22:"wi wi-userjurisdiction";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=module&a=group&";s:7:"section";a:1:{s:10:"permission";a:2:{s:5:"title";s:9:"权限组";s:4:"menu";a:3:{s:23:"permission_module_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"应用权限组";s:3:"url";s:29:"./index.php?c=module&a=group&";s:15:"permission_name";s:23:"permission_module_group";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:31:"permission_create_account_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"账号权限组";s:3:"url";s:34:"./index.php?c=user&a=create-group&";s:15:"permission_name";s:31:"permission_create_account_group";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"permission_user_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户权限组合";s:3:"url";s:27:"./index.php?c=user&a=group&";s:15:"permission_name";s:21:"permission_user_group";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:8;}s:6:"system";a:8:{s:5:"title";s:12:"系统功能";s:4:"icon";s:13:"wi wi-setting";s:9:"dimension";i:3;s:3:"url";s:31:"./index.php?c=article&a=notice&";s:7:"section";a:4:{s:7:"article";a:3:{s:5:"title";s:12:"站内公告";s:4:"menu";a:1:{s:14:"system_article";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站内公告";s:3:"url";s:31:"./index.php?c=article&a=notice&";s:15:"permission_name";s:14:"system_article";s:4:"icon";s:13:"wi wi-article";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"公告列表";s:15:"permission_name";s:26:"system_article_notice_list";}i:1;a:2:{s:5:"title";s:12:"公告分类";s:15:"permission_name";s:30:"system_article_notice_category";}}}}s:7:"founder";b:1;}s:15:"system_template";a:3:{s:5:"title";s:6:"模板";s:4:"menu";a:1:{s:15:"system_template";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"微官网模板";s:3:"url";s:32:"./index.php?c=system&a=template&";s:15:"permission_name";s:15:"system_template";s:4:"icon";s:17:"wi wi-wx-template";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:3:"sms";a:3:{s:5:"title";s:6:"短信";s:4:"menu";a:1:{s:16:"system_cloud_sms";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"短信管理";s:3:"url";s:26:"./index.php?c=cloud&a=sms&";s:15:"permission_name";s:16:"system_cloud_sms";s:4:"icon";s:9:"wi wi-sms";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:5:"cache";a:2:{s:5:"title";s:6:"缓存";s:4:"menu";a:1:{s:26:"system_setting_updatecache";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"更新缓存";s:3:"url";s:35:"./index.php?c=system&a=updatecache&";s:15:"permission_name";s:26:"system_setting_updatecache";s:4:"icon";s:12:"wi wi-update";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:9;}s:4:"site";a:9:{s:5:"title";s:12:"站点设置";s:4:"icon";s:17:"wi wi-system-site";s:9:"dimension";i:3;s:3:"url";s:30:"./index.php?c=cloud&a=upgrade&";s:7:"section";a:4:{s:5:"cloud";a:2:{s:5:"title";s:9:"云服务";s:4:"menu";a:3:{s:14:"system_profile";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统升级";s:3:"url";s:30:"./index.php?c=cloud&a=upgrade&";s:15:"permission_name";s:20:"system_cloud_upgrade";s:4:"icon";s:11:"wi wi-cache";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_register";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"注册站点";s:3:"url";s:30:"./index.php?c=cloud&a=profile&";s:15:"permission_name";s:21:"system_cloud_register";s:4:"icon";s:18:"wi wi-registersite";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_diagnose";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"云服务诊断";s:3:"url";s:31:"./index.php?c=cloud&a=diagnose&";s:15:"permission_name";s:21:"system_cloud_diagnose";s:4:"icon";s:14:"wi wi-diagnose";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"setting";a:2:{s:5:"title";s:6:"设置";s:4:"menu";a:9:{s:19:"system_setting_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站点设置";s:3:"url";s:28:"./index.php?c=system&a=site&";s:15:"permission_name";s:19:"system_setting_site";s:4:"icon";s:18:"wi wi-site-setting";s:12:"displayorder";i:9;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"菜单设置";s:3:"url";s:28:"./index.php?c=system&a=menu&";s:15:"permission_name";s:19:"system_setting_menu";s:4:"icon";s:18:"wi wi-menu-setting";s:12:"displayorder";i:8;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_attachment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"附件设置";s:3:"url";s:34:"./index.php?c=system&a=attachment&";s:15:"permission_name";s:25:"system_setting_attachment";s:4:"icon";s:16:"wi wi-attachment";s:12:"displayorder";i:7;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_systeminfo";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统信息";s:3:"url";s:34:"./index.php?c=system&a=systeminfo&";s:15:"permission_name";s:25:"system_setting_systeminfo";s:4:"icon";s:17:"wi wi-system-info";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_logs";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"查看日志";s:3:"url";s:28:"./index.php?c=system&a=logs&";s:15:"permission_name";s:19:"system_setting_logs";s:4:"icon";s:9:"wi wi-log";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:26:"system_setting_ipwhitelist";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:11:"IP白名单";s:3:"url";s:35:"./index.php?c=system&a=ipwhitelist&";s:15:"permission_name";s:26:"system_setting_ipwhitelist";s:4:"icon";s:8:"wi wi-ip";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:28:"system_setting_sensitiveword";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"过滤敏感词";s:3:"url";s:37:"./index.php?c=system&a=sensitiveword&";s:15:"permission_name";s:28:"system_setting_sensitiveword";s:4:"icon";s:15:"wi wi-sensitive";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_thirdlogin";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:25:"用户登录/注册设置";s:3:"url";s:33:"./index.php?c=user&a=registerset&";s:15:"permission_name";s:25:"system_setting_thirdlogin";s:4:"icon";s:10:"wi wi-user";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_setting_oauth";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"全局借用权限";s:3:"url";s:29:"./index.php?c=system&a=oauth&";s:15:"permission_name";s:20:"system_setting_oauth";s:4:"icon";s:11:"wi wi-oauth";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"utility";a:2:{s:5:"title";s:12:"常用工具";s:4:"menu";a:6:{s:24:"system_utility_filecheck";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统文件校验";s:3:"url";s:33:"./index.php?c=system&a=filecheck&";s:15:"permission_name";s:24:"system_utility_filecheck";s:4:"icon";s:10:"wi wi-file";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_optimize";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"性能优化";s:3:"url";s:32:"./index.php?c=system&a=optimize&";s:15:"permission_name";s:23:"system_utility_optimize";s:4:"icon";s:14:"wi wi-optimize";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_database";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"数据库";s:3:"url";s:32:"./index.php?c=system&a=database&";s:15:"permission_name";s:23:"system_utility_database";s:4:"icon";s:9:"wi wi-sql";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_utility_scan";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"木马查杀";s:3:"url";s:28:"./index.php?c=system&a=scan&";s:15:"permission_name";s:19:"system_utility_scan";s:4:"icon";s:12:"wi wi-safety";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:18:"system_utility_bom";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"检测文件BOM";s:3:"url";s:27:"./index.php?c=system&a=bom&";s:15:"permission_name";s:18:"system_utility_bom";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_utility_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统常规检测";s:3:"url";s:29:"./index.php?c=system&a=check&";s:15:"permission_name";s:20:"system_utility_check";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"backjob";a:2:{s:5:"title";s:12:"后台任务";s:4:"menu";a:1:{s:10:"system_job";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"后台任务";s:3:"url";s:38:"./index.php?c=system&a=job&do=display&";s:15:"permission_name";s:10:"system_job";s:4:"icon";s:9:"wi wi-job";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:10;}s:6:"myself";a:8:{s:5:"title";s:12:"我的账户";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=profile&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:11;}s:7:"message";a:8:{s:5:"title";s:12:"消息管理";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=message&a=notice&";s:7:"section";a:1:{s:7:"message";a:2:{s:5:"title";s:12:"消息管理";s:4:"menu";a:3:{s:14:"message_notice";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息提醒";s:3:"url";s:31:"./index.php?c=message&a=notice&";s:15:"permission_name";s:14:"message_notice";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:15:"message_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息设置";s:3:"url";s:42:"./index.php?c=message&a=notice&do=setting&";s:15:"permission_name";s:15:"message_setting";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:22:"message_wechat_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"微信提醒设置";s:3:"url";s:49:"./index.php?c=message&a=notice&do=wechat_setting&";s:15:"permission_name";s:22:"message_wechat_setting";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:12;}s:7:"account";a:8:{s:5:"title";s:9:"公众号";s:4:"icon";s:18:"wi wi-white-collar";s:9:"dimension";i:3;s:3:"url";s:41:"./index.php?c=home&a=welcome&do=platform&";s:7:"section";a:4:{s:8:"platform";a:4:{s:5:"title";s:12:"增强功能";s:4:"menu";a:6:{s:14:"platform_reply";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"自动回复";s:3:"url";s:31:"./index.php?c=platform&a=reply&";s:15:"permission_name";s:14:"platform_reply";s:4:"icon";s:11:"wi wi-reply";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:7:{s:22:"platform_reply_keyword";a:4:{s:5:"title";s:21:"关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=keyword";s:15:"permission_name";s:22:"platform_reply_keyword";s:6:"active";s:7:"keyword";}s:22:"platform_reply_special";a:4:{s:5:"title";s:24:"非关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=special";s:15:"permission_name";s:22:"platform_reply_special";s:6:"active";s:7:"special";}s:22:"platform_reply_welcome";a:4:{s:5:"title";s:24:"首次访问自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=welcome";s:15:"permission_name";s:22:"platform_reply_welcome";s:6:"active";s:7:"welcome";}s:22:"platform_reply_default";a:4:{s:5:"title";s:12:"默认回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=default";s:15:"permission_name";s:22:"platform_reply_default";s:6:"active";s:7:"default";}s:22:"platform_reply_service";a:4:{s:5:"title";s:12:"常用服务";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=service";s:15:"permission_name";s:22:"platform_reply_service";s:6:"active";s:7:"service";}s:22:"platform_reply_userapi";a:5:{s:5:"title";s:21:"自定义接口回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=userapi";s:15:"permission_name";s:22:"platform_reply_userapi";s:6:"active";s:7:"userapi";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"platform_reply_setting";a:4:{s:5:"title";s:12:"回复设置";s:3:"url";s:38:"./index.php?c=profile&a=reply-setting&";s:15:"permission_name";s:22:"platform_reply_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:13:"platform_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:15:"自定义菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:13:"platform_menu";s:4:"icon";s:16:"wi wi-custommenu";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:21:"platform_menu_default";a:4:{s:5:"title";s:12:"默认菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:21:"platform_menu_default";s:6:"active";s:4:"post";}s:25:"platform_menu_conditional";a:5:{s:5:"title";s:15:"个性化菜单";s:3:"url";s:47:"./index.php?c=platform&a=menu&do=display&type=3";s:15:"permission_name";s:25:"platform_menu_conditional";s:6:"active";s:7:"display";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:11:"platform_qr";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:22:"二维码/转化链接";s:3:"url";s:28:"./index.php?c=platform&a=qr&";s:15:"permission_name";s:11:"platform_qr";s:4:"icon";s:12:"wi wi-qrcode";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:2:{s:14:"platform_qr_qr";a:4:{s:5:"title";s:9:"二维码";s:3:"url";s:36:"./index.php?c=platform&a=qr&do=list&";s:15:"permission_name";s:14:"platform_qr_qr";s:6:"active";s:4:"list";}s:22:"platform_qr_statistics";a:4:{s:5:"title";s:21:"二维码扫描统计";s:3:"url";s:39:"./index.php?c=platform&a=qr&do=display&";s:15:"permission_name";s:22:"platform_qr_statistics";s:6:"active";s:7:"display";}}}s:17:"platform_masstask";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"定时群发";s:3:"url";s:30:"./index.php?c=platform&a=mass&";s:15:"permission_name";s:17:"platform_masstask";s:4:"icon";s:13:"wi wi-crontab";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:22:"platform_masstask_post";a:4:{s:5:"title";s:12:"定时群发";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=post&";s:15:"permission_name";s:22:"platform_masstask_post";s:6:"active";s:4:"post";}s:22:"platform_masstask_send";a:4:{s:5:"title";s:12:"群发记录";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=send&";s:15:"permission_name";s:22:"platform_masstask_send";s:6:"active";s:4:"send";}}}s:17:"platform_material";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:16:"素材/编辑器";s:3:"url";s:34:"./index.php?c=platform&a=material&";s:15:"permission_name";s:17:"platform_material";s:4:"icon";s:12:"wi wi-redact";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:5:{s:22:"platform_material_news";a:4:{s:5:"title";s:6:"图文";s:3:"url";s:43:"./index.php?c=platform&a=material&type=news";s:15:"permission_name";s:22:"platform_material_news";s:6:"active";s:4:"news";}s:23:"platform_material_image";a:4:{s:5:"title";s:6:"图片";s:3:"url";s:44:"./index.php?c=platform&a=material&type=image";s:15:"permission_name";s:23:"platform_material_image";s:6:"active";s:5:"image";}s:23:"platform_material_voice";a:4:{s:5:"title";s:6:"语音";s:3:"url";s:44:"./index.php?c=platform&a=material&type=voice";s:15:"permission_name";s:23:"platform_material_voice";s:6:"active";s:5:"voice";}s:23:"platform_material_video";a:5:{s:5:"title";s:6:"视频";s:3:"url";s:44:"./index.php?c=platform&a=material&type=video";s:15:"permission_name";s:23:"platform_material_video";s:6:"active";s:5:"video";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"platform_material_delete";a:3:{s:5:"title";s:6:"删除";s:15:"permission_name";s:24:"platform_material_delete";s:10:"is_display";b:0;}}}s:13:"platform_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:16:"微官网-文章";s:3:"url";s:27:"./index.php?c=site&a=multi&";s:15:"permission_name";s:13:"platform_site";s:4:"icon";s:10:"wi wi-home";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:19:"platform_site_multi";a:4:{s:5:"title";s:9:"微官网";s:3:"url";s:38:"./index.php?c=site&a=multi&do=display&";s:15:"permission_name";s:19:"platform_site_multi";s:6:"active";s:5:"multi";}s:19:"platform_site_style";a:4:{s:5:"title";s:15:"微官网模板";s:3:"url";s:39:"./index.php?c=site&a=style&do=template&";s:15:"permission_name";s:19:"platform_site_style";s:6:"active";s:5:"style";}s:21:"platform_site_article";a:4:{s:5:"title";s:12:"文章管理";s:3:"url";s:40:"./index.php?c=site&a=article&do=display&";s:15:"permission_name";s:21:"platform_site_article";s:6:"active";s:7:"article";}s:22:"platform_site_category";a:4:{s:5:"title";s:18:"文章分类管理";s:3:"url";s:41:"./index.php?c=site&a=category&do=display&";s:15:"permission_name";s:22:"platform_site_category";s:6:"active";s:8:"category";}}}}s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;}s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:4:{s:5:"title";s:6:"粉丝";s:4:"menu";a:3:{s:7:"mc_fans";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"粉丝管理";s:3:"url";s:24:"./index.php?c=mc&a=fans&";s:15:"permission_name";s:7:"mc_fans";s:4:"icon";s:16:"wi wi-fansmanage";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:15:"mc_fans_display";a:4:{s:5:"title";s:12:"全部粉丝";s:3:"url";s:35:"./index.php?c=mc&a=fans&do=display&";s:15:"permission_name";s:15:"mc_fans_display";s:6:"active";s:7:"display";}s:21:"mc_fans_fans_sync_set";a:4:{s:5:"title";s:18:"粉丝同步设置";s:3:"url";s:41:"./index.php?c=mc&a=fans&do=fans_sync_set&";s:15:"permission_name";s:21:"mc_fans_fans_sync_set";s:6:"active";s:13:"fans_sync_set";}}}s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"会员管理";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:9:"mc_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:7:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:12:"mc_member_uc";a:5:{s:5:"title";s:12:"会员中心";s:3:"url";s:34:"./index.php?c=site&a=editor&do=uc&";s:15:"permission_name";s:12:"mc_member_uc";s:6:"active";s:2:"uc";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:19:"mc_member_quickmenu";a:5:{s:5:"title";s:12:"快捷菜单";s:3:"url";s:41:"./index.php?c=site&a=editor&do=quickmenu&";s:15:"permission_name";s:19:"mc_member_quickmenu";s:6:"active";s:9:"quickmenu";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"mc_member_register_seting";a:5:{s:5:"title";s:12:"注册设置";s:3:"url";s:46:"./index.php?c=mc&a=member&do=register_setting&";s:15:"permission_name";s:25:"mc_member_register_seting";s:6:"active";s:16:"register_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}s:10:"mc_message";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"留言管理";s:3:"url";s:27:"./index.php?c=mc&a=message&";s:15:"permission_name";s:10:"mc_message";s:4:"icon";s:13:"wi wi-message";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;}s:7:"profile";a:4:{s:5:"title";s:6:"配置";s:4:"menu";a:5:{s:15:"profile_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:15:"profile_setting";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:6:{s:22:"profile_setting_remote";a:4:{s:5:"title";s:12:"远程附件";s:3:"url";s:42:"./index.php?c=profile&a=remote&do=display&";s:15:"permission_name";s:22:"profile_setting_remote";s:6:"active";s:7:"display";}s:24:"profile_setting_passport";a:5:{s:5:"title";s:12:"借用权限";s:3:"url";s:42:"./index.php?c=profile&a=passport&do=oauth&";s:15:"permission_name";s:24:"profile_setting_passport";s:6:"active";s:5:"oauth";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"profile_setting_tplnotice";a:5:{s:5:"title";s:18:"微信通知设置";s:3:"url";s:42:"./index.php?c=profile&a=tplnotice&do=list&";s:15:"permission_name";s:25:"profile_setting_tplnotice";s:6:"active";s:4:"list";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"profile_setting_notify";a:5:{s:5:"title";s:18:"邮件通知参数";s:3:"url";s:39:"./index.php?c=profile&a=notify&do=mail&";s:15:"permission_name";s:22:"profile_setting_notify";s:6:"active";s:4:"mail";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:26:"profile_setting_uc_setting";a:5:{s:5:"title";s:14:"UC站点整合";s:3:"url";s:45:"./index.php?c=profile&a=common&do=uc_setting&";s:15:"permission_name";s:26:"profile_setting_uc_setting";s:6:"active";s:10:"uc_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:27:"profile_setting_upload_file";a:5:{s:5:"title";s:20:"上传JS接口文件";s:3:"url";s:46:"./index.php?c=profile&a=common&do=upload_file&";s:15:"permission_name";s:27:"profile_setting_upload_file";s:6:"active";s:11:"upload_file";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:15:"profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:12:"支付参数";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:15:"profile_payment";s:4:"icon";s:17:"wi wi-pay-setting";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:2:{s:19:"profile_payment_pay";a:4:{s:5:"title";s:12:"支付配置";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:19:"profile_payment_pay";s:6:"active";s:7:"payment";}s:22:"profile_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:42:"./index.php?c=profile&a=refund&do=display&";s:15:"permission_name";s:22:"profile_payment_refund";s:6:"active";s:6:"refund";}}}s:23:"profile_app_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:31:"profile_app_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:18:"webapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:18:"webapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:14:"webapp_rewrite";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:9:"伪静态";s:3:"url";s:31:"./index.php?c=webapp&a=rewrite&";s:15:"permission_name";s:14:"webapp_rewrite";s:4:"icon";s:13:"wi wi-rewrite";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:13;}s:5:"wxapp";a:8:{s:5:"title";s:15:"微信小程序";s:4:"icon";s:19:"wi wi-small-routine";s:9:"dimension";i:3;s:3:"url";s:38:"./index.php?c=wxapp&a=display&do=home&";s:7:"section";a:5:{s:14:"wxapp_entrance";a:4:{s:5:"title";s:15:"小程序入口";s:4:"menu";a:1:{s:20:"module_entrance_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"入口页面";s:3:"url";s:36:"./index.php?c=wxapp&a=entrance-link&";s:15:"permission_name";s:19:"wxapp_entrance_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;}s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:4:{s:5:"title";s:6:"粉丝";s:4:"menu";a:1:{s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:6:"会员";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:15:"mc_wxapp_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}}s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;}s:13:"wxapp_profile";a:3:{s:5:"title";s:6:"配置";s:4:"menu";a:5:{s:33:"wxapp_profile_module_link_uniacid";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:33:"wxapp_profile_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:21:"wxapp_profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"支付参数";s:3:"url";s:30:"./index.php?c=wxapp&a=payment&";s:15:"permission_name";s:21:"wxapp_profile_payment";s:4:"icon";s:16:"wi wi-appsetting";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:17:"wxapp_payment_pay";a:4:{s:5:"title";s:12:"支付参数";s:3:"url";s:41:"./index.php?c=wxapp&a=payment&do=display&";s:15:"permission_name";s:17:"wxapp_payment_pay";s:6:"active";s:7:"payment";}s:20:"wxapp_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:40:"./index.php?c=wxapp&a=refund&do=display&";s:15:"permission_name";s:20:"wxapp_payment_refund";s:6:"active";s:6:"refund";}}}s:28:"wxapp_profile_front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";i:1;s:10:"is_display";i:1;s:5:"title";s:15:"下载程序包";s:3:"url";s:37:"./index.php?c=wxapp&a=front-download&";s:15:"permission_name";s:28:"wxapp_profile_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:23:"wxapp_profile_domainset";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"域名设置";s:3:"url";s:32:"./index.php?c=wxapp&a=domainset&";s:15:"permission_name";s:23:"wxapp_profile_domainset";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:22:"profile_setting_remote";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:22:"profile_setting_remote";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}}s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}}s:10:"statistics";a:4:{s:5:"title";s:6:"统计";s:4:"menu";a:1:{s:16:"statistics_visit";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;s:5:"title";s:12:"访问统计";s:3:"url";s:31:"./index.php?c=statistics&a=app&";s:15:"permission_name";s:22:"statistics_visit_wxapp";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:3:{s:20:"statistics_visit_app";a:4:{s:5:"title";s:24:"app端访问统计信息";s:3:"url";s:42:"./index.php?c=statistics&a=app&do=display&";s:15:"permission_name";s:20:"statistics_visit_app";s:6:"active";s:3:"app";}s:21:"statistics_visit_site";a:4:{s:5:"title";s:24:"所有用户访问统计";s:3:"url";s:51:"./index.php?c=statistics&a=site&do=current_account&";s:15:"permission_name";s:21:"statistics_visit_site";s:6:"active";s:4:"site";}s:24:"statistics_visit_setting";a:4:{s:5:"title";s:18:"访问统计设置";s:3:"url";s:46:"./index.php?c=statistics&a=setting&do=display&";s:15:"permission_name";s:24:"statistics_visit_setting";s:6:"active";s:7:"setting";}}}}s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:14;}s:6:"webapp";a:7:{s:5:"title";s:2:"PC";s:4:"icon";s:8:"wi wi-pc";s:3:"url";s:39:"./index.php?c=webapp&a=home&do=display&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:15;}s:8:"phoneapp";a:7:{s:5:"title";s:3:"APP";s:4:"icon";s:18:"wi wi-white-collar";s:3:"url";s:41:"./index.php?c=phoneapp&a=display&do=home&";s:7:"section";a:2:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:16:"phoneapp_profile";a:4:{s:5:"title";s:6:"配置";s:4:"menu";a:2:{s:28:"profile_phoneapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:6;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:28:"profile_phoneapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:14:"front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";b:1;s:10:"is_display";i:1;s:5:"title";s:9:"下载APP";s:3:"url";s:40:"./index.php?c=phoneapp&a=front-download&";s:15:"permission_name";s:23:"phoneapp_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";b:1;s:18:"permission_display";a:1:{i:0;i:6;}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:16;}s:5:"xzapp";a:7:{s:5:"title";s:9:"熊掌号";s:4:"icon";s:11:"wi wi-xzapp";s:3:"url";s:38:"./index.php?c=xzapp&a=home&do=display&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:17;}s:6:"aliapp";a:7:{s:5:"title";s:18:"支付宝小程序";s:4:"icon";s:12:"wi wi-aliapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:18;}s:8:"baiduapp";a:7:{s:5:"title";s:15:"百度小程序";s:4:"icon";s:14:"wi wi-baiduapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:19;}s:10:"toutiaoapp";a:7:{s:5:"title";s:15:"头条小程序";s:4:"icon";s:16:"wi wi-toutiaoapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:20;}s:9:"appmarket";a:9:{s:5:"title";s:6:"市场";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:14:"http://s.w7.cc";s:7:"section";a:0:{}s:5:"blank";b:1;s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:21;}s:9:"workorder";a:9:{s:5:"title";s:6:"工单";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:44:"./index.php?c=system&a=workorder&do=display&";s:7:"section";a:1:{s:9:"workorder";a:2:{s:5:"title";s:12:"工单系统";s:4:"menu";a:1:{s:16:"system_workorder";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"工单系统";s:3:"url";s:44:"./index.php?c=system&a=workorder&do=display&";s:15:"permission_name";s:16:"system_workorder";s:4:"icon";s:17:"wi wi-system-work";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:22;}s:4:"help";a:7:{s:5:"title";s:6:"帮助";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:29:"./index.php?c=help&a=display&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:23;}s:11:"custom_help";a:7:{s:5:"title";s:12:"本站帮助";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:39:"./index.php?c=help&a=display&do=custom&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:24;}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:unimodules:2', 'a:4:{i:0;s:24:"group_buy_plugin_seckill";i:1;s:29:"group_buy_plugin_distribution";i:2;s:25:"group_buy_plugin_fraction";i:3;s:9:"group_buy";}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:unicount:2', 's:1:"0";');
INSERT INTO `mmwl_core_cache` VALUES ('goods_cate2', 'a:1:{i:0;a:14:{s:5:"gc_id";s:1:"1";s:7:"gc_name";s:6:"手机";s:6:"gc_pid";s:1:"0";s:9:"gc_status";s:1:"1";s:9:"gc_is_del";s:1:"1";s:7:"gc_icon";s:0:"";s:11:"gc_add_time";s:10:"1563429142";s:14:"gc_update_time";N;s:8:"gc_order";s:1:"1";s:4:"weid";s:1:"2";s:8:"gc_level";s:1:"0";s:7:"gc_tree";s:2:",0";s:4:"type";s:1:"1";s:16:"gc_is_index_show";s:1:"1";}}');
INSERT INTO `mmwl_core_cache` VALUES ('we7:cloud_transtoken', 's:39:"fde5CmegHBmdz5CQ0Yp3uZNw/Jpr4j2q7D/LSPc";');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
INSERT INTO `mmwl_core_settings` VALUES ('cloudip', 'a:2:{s:2:"ip";s:12:"180.96.32.96";s:6:"expire";i:1564130727;}');

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
-- Records of mmwl_gpb_action 
-- ----------------------------
INSERT INTO `mmwl_gpb_action` VALUES ('1', '1', '', '', '', '', '', '', '1', '1', '', '0', '0', '', '', '-1', '', '', '', '-1', '', '', '-1');

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
-- Records of mmwl_gpb_activity_plugin_virtual_buy_list 
-- ----------------------------
INSERT INTO `mmwl_gpb_activity_plugin_virtual_buy_list` VALUES ('1', '1', '2', '0', '1563429230', '1', '1563380168', '0', '0', '2');
INSERT INTO `mmwl_gpb_activity_plugin_virtual_buy_list` VALUES ('2', '1', '1', '0', '1563429230', '1', '1563410150', '0', '0', '2');

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
-- Records of mmwl_gpb_area 
-- ----------------------------
INSERT INTO `mmwl_gpb_area` VALUES ('1', '110000', '北京市', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('2', '110105', '朝阳区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('3', '110108', '海淀区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('4', '110111', '房山区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('5', '110113', '顺义区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('6', '110115', '大兴区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('7', '110114', '昌平区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('8', '110118', '密云区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('9', '110119', '延庆区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('10', '110117', '平谷区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('11', '110106', '丰台区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('12', '110101', '东城区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('13', '110116', '怀柔区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('14', '110112', '通州区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('15', '110102', '西城区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('16', '110109', '门头沟区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('17', '110107', '石景山区', 'area', '110100');
INSERT INTO `mmwl_gpb_area` VALUES ('18', '120000', '天津市', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('19', '120114', '武清区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('20', '120119', '蓟州区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('21', '120115', '宝坻区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('22', '120116', '滨海新区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('23', '120118', '静海区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('24', '120117', '宁河区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('25', '120113', '北辰区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('26', '120103', '河西区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('27', '120102', '河东区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('28', '120104', '南开区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('29', '120110', '东丽区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('30', '120106', '红桥区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('31', '120105', '河北区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('32', '120111', '西青区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('33', '120112', '津南区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('34', '120101', '和平区', 'area', '120100');
INSERT INTO `mmwl_gpb_area` VALUES ('35', '130000', '河北省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('36', '130100', '石家庄市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('37', '130131', '平山县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('38', '130121', '井陉县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('39', '130104', '桥西区', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('40', '130132', '元氏县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('41', '130102', '长安区', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('42', '130181', '辛集市', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('43', '130109', '藁城区', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('44', '130126', '灵寿县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('45', '130125', '行唐县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('46', '130105', '新华区', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('47', '130110', '鹿泉区', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('48', '130108', '裕华区', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('49', '130184', '新乐市', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('50', '130133', '赵县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('51', '130129', '赞皇县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('52', '130130', '无极县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('53', '130183', '晋州市', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('54', '130123', '正定县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('55', '130111', '栾城区', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('56', '130128', '深泽县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('57', '130127', '高邑县', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('58', '130107', '井陉矿区', 'area', '130100');
INSERT INTO `mmwl_gpb_area` VALUES ('59', '130200', '唐山市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('60', '130281', '遵化市', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('61', '130208', '丰润区', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('62', '130229', '玉田县', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('63', '130283', '迁安市', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('64', '130227', '迁西县', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('65', '130224', '滦南县', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('66', '130209', '曹妃甸区', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('67', '130207', '丰南区', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('68', '130225', '乐亭县', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('69', '130223', '滦县', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('70', '130203', '路北区', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('71', '130202', '路南区', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('72', '130205', '开平区', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('73', '130204', '古冶区', 'area', '130200');
INSERT INTO `mmwl_gpb_area` VALUES ('74', '130300', '秦皇岛市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('75', '130321', '青龙满族自治县', 'area', '130300');
INSERT INTO `mmwl_gpb_area` VALUES ('76', '130302', '海港区', 'area', '130300');
INSERT INTO `mmwl_gpb_area` VALUES ('77', '130322', '昌黎县', 'area', '130300');
INSERT INTO `mmwl_gpb_area` VALUES ('78', '130324', '卢龙县', 'area', '130300');
INSERT INTO `mmwl_gpb_area` VALUES ('79', '130306', '抚宁区', 'area', '130300');
INSERT INTO `mmwl_gpb_area` VALUES ('80', '130303', '山海关区', 'area', '130300');
INSERT INTO `mmwl_gpb_area` VALUES ('81', '130304', '北戴河区', 'area', '130300');
INSERT INTO `mmwl_gpb_area` VALUES ('82', '130400', '邯郸市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('83', '130402', '邯山区', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('84', '130481', '武安市', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('85', '130434', '魏县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('86', '130425', '大名县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('87', '130403', '丛台区', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('88', '130426', '涉县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('89', '130408', '永年区', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('90', '130423', '临漳县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('91', '130404', '复兴区', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('92', '130427', '磁县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('93', '130435', '曲周县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('94', '130424', '成安县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('95', '130407', '肥乡区', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('96', '130406', '峰峰矿区', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('97', '130433', '馆陶县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('98', '130432', '广平县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('99', '130430', '邱县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('100', '130431', '鸡泽县', 'area', '130400');
INSERT INTO `mmwl_gpb_area` VALUES ('101', '130500', '邢台市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('102', '130521', '邢台县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('103', '130528', '宁晋县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('104', '130533', '威县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('105', '130581', '南宫市', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('106', '130582', '沙河市', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('107', '130525', '隆尧县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('108', '130529', '巨鹿县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('109', '130503', '桥西区', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('110', '130523', '内丘县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('111', '130535', '临西县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('112', '130531', '广宗县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('113', '130526', '任县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('114', '130522', '临城县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('115', '130532', '平乡县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('116', '130527', '南和县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('117', '130502', '桥东区', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('118', '130530', '新河县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('119', '130534', '清河县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('120', '130524', '柏乡县', 'area', '130500');
INSERT INTO `mmwl_gpb_area` VALUES ('121', '130600', '保定市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('122', '130633', '易县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('123', '130682', '定州市', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('124', '130627', '唐县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('125', '130634', '曲阳县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('126', '130608', '清苑区', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('127', '130630', '涞源县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('128', '130606', '莲池区', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('129', '130626', '定兴县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('130', '130623', '涞水县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('131', '130684', '高碑店市', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('132', '130681', '涿州市', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('133', '130609', '徐水区', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('134', '130635', '蠡县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('135', '130624', '阜平县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('136', '130607', '满城区', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('137', '130602', '竞秀区', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('138', '130632', '安新县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('139', '130683', '安国市', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('140', '130636', '顺平县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('141', '130628', '高阳县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('142', '130638', '雄县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('143', '130631', '望都县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('144', '130629', '容城县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('145', '130637', '博野县', 'area', '130600');
INSERT INTO `mmwl_gpb_area` VALUES ('146', '130700', '张家口市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('147', '130726', '蔚县', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('148', '130705', '宣化区', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('149', '130722', '张北县', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('150', '130730', '怀来县', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('151', '130732', '赤城县', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('152', '130731', '涿鹿县', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('153', '130724', '沽源县', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('154', '130723', '康保县', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('155', '130727', '阳原县', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('156', '130725', '尚义县', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('157', '130728', '怀安县', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('158', '130708', '万全区', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('159', '130709', '崇礼区', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('160', '130703', '桥西区', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('161', '130702', '桥东区', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('162', '130706', '下花园区', 'area', '130700');
INSERT INTO `mmwl_gpb_area` VALUES ('163', '130800', '承德市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('164', '130828', '围场满族蒙古族自治县', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('165', '130825', '隆化县', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('166', '130826', '丰宁满族自治县', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('167', '130821', '承德县', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('168', '130824', '滦平县', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('169', '130822', '兴隆县', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('170', '130881', '平泉市', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('171', '130827', '宽城满族自治县', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('172', '130802', '双桥区', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('173', '130803', '双滦区', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('174', '130804', '鹰手营子矿区', 'area', '130800');
INSERT INTO `mmwl_gpb_area` VALUES ('175', '130900', '沧州市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('176', '130982', '任丘市', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('177', '130984', '河间市', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('178', '130921', '沧县', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('179', '130929', '献县', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('180', '130981', '泊头市', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('181', '130983', '黄骅市', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('182', '130925', '盐山县', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('183', '130922', '青县', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('184', '130928', '吴桥县', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('185', '130924', '海兴县', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('186', '130923', '东光县', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('187', '130927', '南皮县', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('188', '130926', '肃宁县', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('189', '130903', '运河区', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('190', '130902', '新华区', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('191', '130930', '孟村回族自治县', 'area', '130900');
INSERT INTO `mmwl_gpb_area` VALUES ('192', '131000', '廊坊市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('193', '131026', '文安县', 'area', '131000');
INSERT INTO `mmwl_gpb_area` VALUES ('194', '131081', '霸州市', 'area', '131000');
INSERT INTO `mmwl_gpb_area` VALUES ('195', '131082', '三河市', 'area', '131000');
INSERT INTO `mmwl_gpb_area` VALUES ('196', '131023', '永清县', 'area', '131000');
INSERT INTO `mmwl_gpb_area` VALUES ('197', '131003', '广阳区', 'area', '131000');
INSERT INTO `mmwl_gpb_area` VALUES ('198', '131025', '大城县', 'area', '131000');
INSERT INTO `mmwl_gpb_area` VALUES ('199', '131002', '安次区', 'area', '131000');
INSERT INTO `mmwl_gpb_area` VALUES ('200', '131022', '固安县', 'area', '131000');
INSERT INTO `mmwl_gpb_area` VALUES ('201', '131024', '香河县', 'area', '131000');
INSERT INTO `mmwl_gpb_area` VALUES ('202', '131028', '大厂回族自治县', 'area', '131000');
INSERT INTO `mmwl_gpb_area` VALUES ('203', '131100', '衡水市', 'city', '130000');
INSERT INTO `mmwl_gpb_area` VALUES ('204', '131182', '深州市', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('205', '131127', '景县', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('206', '131126', '故城县', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('207', '131102', '桃城区', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('208', '131103', '冀州区', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('209', '131121', '枣强县', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('210', '131128', '阜城县', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('211', '131122', '武邑县', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('212', '131125', '安平县', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('213', '131124', '饶阳县', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('214', '131123', '武强县', 'area', '131100');
INSERT INTO `mmwl_gpb_area` VALUES ('215', '140000', '山西省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('216', '140100', '太原市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('217', '140109', '万柏林区', 'area', '140100');
INSERT INTO `mmwl_gpb_area` VALUES ('218', '140181', '古交市', 'area', '140100');
INSERT INTO `mmwl_gpb_area` VALUES ('219', '140108', '尖草坪区', 'area', '140100');
INSERT INTO `mmwl_gpb_area` VALUES ('220', '140107', '杏花岭区', 'area', '140100');
INSERT INTO `mmwl_gpb_area` VALUES ('221', '140122', '阳曲县', 'area', '140100');
INSERT INTO `mmwl_gpb_area` VALUES ('222', '140105', '小店区', 'area', '140100');
INSERT INTO `mmwl_gpb_area` VALUES ('223', '140121', '清徐县', 'area', '140100');
INSERT INTO `mmwl_gpb_area` VALUES ('224', '140123', '娄烦县', 'area', '140100');
INSERT INTO `mmwl_gpb_area` VALUES ('225', '140106', '迎泽区', 'area', '140100');
INSERT INTO `mmwl_gpb_area` VALUES ('226', '140110', '晋源区', 'area', '140100');
INSERT INTO `mmwl_gpb_area` VALUES ('227', '140200', '大同市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('228', '140203', '矿区', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('229', '140225', '浑源县', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('230', '140227', '大同县', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('231', '140202', '城区', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('232', '140221', '阳高县', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('233', '140224', '灵丘县', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('234', '140222', '天镇县', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('235', '140211', '南郊区', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('236', '140223', '广灵县', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('237', '140226', '左云县', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('238', '140212', '新荣区', 'area', '140200');
INSERT INTO `mmwl_gpb_area` VALUES ('239', '140300', '阳泉市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('240', '140322', '盂县', 'area', '140300');
INSERT INTO `mmwl_gpb_area` VALUES ('241', '140321', '平定县', 'area', '140300');
INSERT INTO `mmwl_gpb_area` VALUES ('242', '140311', '郊区', 'area', '140300');
INSERT INTO `mmwl_gpb_area` VALUES ('243', '140303', '矿区', 'area', '140300');
INSERT INTO `mmwl_gpb_area` VALUES ('244', '140302', '城区', 'area', '140300');
INSERT INTO `mmwl_gpb_area` VALUES ('245', '140400', '长治市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('246', '140424', '屯留县', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('247', '140429', '武乡县', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('248', '140431', '沁源县', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('249', '140427', '壶关县', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('250', '140430', '沁县', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('251', '140421', '长治县', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('252', '140425', '平顺县', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('253', '140428', '长子县', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('254', '140423', '襄垣县', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('255', '140402', '城区', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('256', '140481', '潞城市', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('257', '140426', '黎城县', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('258', '140411', '郊区', 'area', '140400');
INSERT INTO `mmwl_gpb_area` VALUES ('259', '140500', '晋城市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('260', '140522', '阳城县', 'area', '140500');
INSERT INTO `mmwl_gpb_area` VALUES ('261', '140525', '泽州县', 'area', '140500');
INSERT INTO `mmwl_gpb_area` VALUES ('262', '140581', '高平市', 'area', '140500');
INSERT INTO `mmwl_gpb_area` VALUES ('263', '140521', '沁水县', 'area', '140500');
INSERT INTO `mmwl_gpb_area` VALUES ('264', '140524', '陵川县', 'area', '140500');
INSERT INTO `mmwl_gpb_area` VALUES ('265', '140502', '城区', 'area', '140500');
INSERT INTO `mmwl_gpb_area` VALUES ('266', '140600', '朔州市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('267', '140621', '山阴县', 'area', '140600');
INSERT INTO `mmwl_gpb_area` VALUES ('268', '140602', '朔城区', 'area', '140600');
INSERT INTO `mmwl_gpb_area` VALUES ('269', '140603', '平鲁区', 'area', '140600');
INSERT INTO `mmwl_gpb_area` VALUES ('270', '140622', '应县', 'area', '140600');
INSERT INTO `mmwl_gpb_area` VALUES ('271', '140624', '怀仁县', 'area', '140600');
INSERT INTO `mmwl_gpb_area` VALUES ('272', '140623', '右玉县', 'area', '140600');
INSERT INTO `mmwl_gpb_area` VALUES ('273', '140700', '晋中市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('274', '140702', '榆次区', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('275', '140729', '灵石县', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('276', '140781', '介休市', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('277', '140725', '寿阳县', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('278', '140728', '平遥县', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('279', '140724', '昔阳县', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('280', '140727', '祁县', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('281', '140723', '和顺县', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('282', '140722', '左权县', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('283', '140726', '太谷县', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('284', '140721', '榆社县', 'area', '140700');
INSERT INTO `mmwl_gpb_area` VALUES ('285', '140800', '运城市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('286', '140802', '盐湖区', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('287', '140821', '临猗县', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('288', '140822', '万荣县', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('289', '140823', '闻喜县', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('290', '140830', '芮城县', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('291', '140825', '新绛县', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('292', '140828', '夏县', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('293', '140827', '垣曲县', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('294', '140826', '绛县', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('295', '140881', '永济市', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('296', '140829', '平陆县', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('297', '140882', '河津市', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('298', '140824', '稷山县', 'area', '140800');
INSERT INTO `mmwl_gpb_area` VALUES ('299', '140900', '忻州市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('300', '140981', '原平市', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('301', '140902', '忻府区', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('302', '140922', '五台县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('303', '140925', '宁武县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('304', '140926', '静乐县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('305', '140924', '繁峙县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('306', '140931', '保德县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('307', '140930', '河曲县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('308', '140928', '五寨县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('309', '140929', '岢岚县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('310', '140923', '代县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('311', '140927', '神池县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('312', '140932', '偏关县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('313', '140921', '定襄县', 'area', '140900');
INSERT INTO `mmwl_gpb_area` VALUES ('314', '141000', '临汾市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('315', '141002', '尧都区', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('316', '141024', '洪洞县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('317', '141023', '襄汾县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('318', '141082', '霍州市', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('319', '141029', '乡宁县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('320', '141022', '翼城县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('321', '141033', '蒲县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('322', '141027', '浮山县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('323', '141028', '吉县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('324', '141031', '隰县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('325', '141034', '汾西县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('326', '141081', '侯马市', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('327', '141026', '安泽县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('328', '141032', '永和县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('329', '141025', '古县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('330', '141021', '曲沃县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('331', '141030', '大宁县', 'area', '141000');
INSERT INTO `mmwl_gpb_area` VALUES ('332', '141100', '吕梁市', 'city', '140000');
INSERT INTO `mmwl_gpb_area` VALUES ('333', '141124', '临县', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('334', '141181', '孝义市', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('335', '141123', '兴县', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('336', '141125', '柳林县', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('337', '141182', '汾阳市', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('338', '141127', '岚县', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('339', '141102', '离石区', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('340', '141121', '文水县', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('341', '141122', '交城县', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('342', '141126', '石楼县', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('343', '141129', '中阳县', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('344', '141128', '方山县', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('345', '141130', '交口县', 'area', '141100');
INSERT INTO `mmwl_gpb_area` VALUES ('346', '150000', '内蒙古自治区', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('347', '150100', '呼和浩特市', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('348', '150105', '赛罕区', 'area', '150100');
INSERT INTO `mmwl_gpb_area` VALUES ('349', '150121', '土默特左旗', 'area', '150100');
INSERT INTO `mmwl_gpb_area` VALUES ('350', '150102', '新城区', 'area', '150100');
INSERT INTO `mmwl_gpb_area` VALUES ('351', '150104', '玉泉区', 'area', '150100');
INSERT INTO `mmwl_gpb_area` VALUES ('352', '150125', '武川县', 'area', '150100');
INSERT INTO `mmwl_gpb_area` VALUES ('353', '150103', '回民区', 'area', '150100');
INSERT INTO `mmwl_gpb_area` VALUES ('354', '150123', '和林格尔县', 'area', '150100');
INSERT INTO `mmwl_gpb_area` VALUES ('355', '150124', '清水河县', 'area', '150100');
INSERT INTO `mmwl_gpb_area` VALUES ('356', '150122', '托克托县', 'area', '150100');
INSERT INTO `mmwl_gpb_area` VALUES ('357', '150200', '包头市', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('358', '150203', '昆都仑区', 'area', '150200');
INSERT INTO `mmwl_gpb_area` VALUES ('359', '150202', '东河区', 'area', '150200');
INSERT INTO `mmwl_gpb_area` VALUES ('360', '150204', '青山区', 'area', '150200');
INSERT INTO `mmwl_gpb_area` VALUES ('361', '150221', '土默特右旗', 'area', '150200');
INSERT INTO `mmwl_gpb_area` VALUES ('362', '150223', '达尔罕茂明安联合旗', 'area', '150200');
INSERT INTO `mmwl_gpb_area` VALUES ('363', '150205', '石拐区', 'area', '150200');
INSERT INTO `mmwl_gpb_area` VALUES ('364', '150207', '九原区', 'area', '150200');
INSERT INTO `mmwl_gpb_area` VALUES ('365', '150222', '固阳县', 'area', '150200');
INSERT INTO `mmwl_gpb_area` VALUES ('366', '150206', '白云鄂博矿区', 'area', '150200');
INSERT INTO `mmwl_gpb_area` VALUES ('367', '150300', '乌海市', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('368', '150302', '海勃湾区', 'area', '150300');
INSERT INTO `mmwl_gpb_area` VALUES ('369', '150304', '乌达区', 'area', '150300');
INSERT INTO `mmwl_gpb_area` VALUES ('370', '150303', '海南区', 'area', '150300');
INSERT INTO `mmwl_gpb_area` VALUES ('371', '150400', '赤峰市', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('372', '150404', '松山区', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('373', '150430', '敖汉旗', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('374', '150402', '红山区', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('375', '150422', '巴林左旗', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('376', '150426', '翁牛特旗', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('377', '150425', '克什克腾旗', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('378', '150429', '宁城县', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('379', '150421', '阿鲁科尔沁旗', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('380', '150403', '元宝山区', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('381', '150424', '林西县', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('382', '150423', '巴林右旗', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('383', '150428', '喀喇沁旗', 'area', '150400');
INSERT INTO `mmwl_gpb_area` VALUES ('384', '150500', '通辽市', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('385', '150502', '科尔沁区', 'area', '150500');
INSERT INTO `mmwl_gpb_area` VALUES ('386', '150521', '科尔沁左翼中旗', 'area', '150500');
INSERT INTO `mmwl_gpb_area` VALUES ('387', '150526', '扎鲁特旗', 'area', '150500');
INSERT INTO `mmwl_gpb_area` VALUES ('388', '150522', '科尔沁左翼后旗', 'area', '150500');
INSERT INTO `mmwl_gpb_area` VALUES ('389', '150525', '奈曼旗', 'area', '150500');
INSERT INTO `mmwl_gpb_area` VALUES ('390', '150523', '开鲁县', 'area', '150500');
INSERT INTO `mmwl_gpb_area` VALUES ('391', '150524', '库伦旗', 'area', '150500');
INSERT INTO `mmwl_gpb_area` VALUES ('392', '150581', '霍林郭勒市', 'area', '150500');
INSERT INTO `mmwl_gpb_area` VALUES ('393', '150600', '鄂尔多斯市', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('394', '150602', '东胜区', 'area', '150600');
INSERT INTO `mmwl_gpb_area` VALUES ('395', '150622', '准格尔旗', 'area', '150600');
INSERT INTO `mmwl_gpb_area` VALUES ('396', '150621', '达拉特旗', 'area', '150600');
INSERT INTO `mmwl_gpb_area` VALUES ('397', '150627', '伊金霍洛旗', 'area', '150600');
INSERT INTO `mmwl_gpb_area` VALUES ('398', '150624', '鄂托克旗', 'area', '150600');
INSERT INTO `mmwl_gpb_area` VALUES ('399', '150625', '杭锦旗', 'area', '150600');
INSERT INTO `mmwl_gpb_area` VALUES ('400', '150626', '乌审旗', 'area', '150600');
INSERT INTO `mmwl_gpb_area` VALUES ('401', '150623', '鄂托克前旗', 'area', '150600');
INSERT INTO `mmwl_gpb_area` VALUES ('402', '150603', '康巴什区', 'area', '150600');
INSERT INTO `mmwl_gpb_area` VALUES ('403', '150700', '呼伦贝尔市', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('404', '150723', '鄂伦春自治旗', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('405', '150783', '扎兰屯市', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('406', '150782', '牙克石市', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('407', '150721', '阿荣旗', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('408', '150722', '莫力达瓦达斡尔族自治旗', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('409', '150725', '陈巴尔虎旗', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('410', '150785', '根河市', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('411', '150702', '海拉尔区', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('412', '150724', '鄂温克族自治旗', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('413', '150703', '扎赉诺尔区', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('414', '150784', '额尔古纳市', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('415', '150727', '新巴尔虎右旗', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('416', '150726', '新巴尔虎左旗', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('417', '150781', '满洲里市', 'area', '150700');
INSERT INTO `mmwl_gpb_area` VALUES ('418', '150800', '巴彦淖尔市', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('419', '150802', '临河区', 'area', '150800');
INSERT INTO `mmwl_gpb_area` VALUES ('420', '150823', '乌拉特前旗', 'area', '150800');
INSERT INTO `mmwl_gpb_area` VALUES ('421', '150826', '杭锦后旗', 'area', '150800');
INSERT INTO `mmwl_gpb_area` VALUES ('422', '150824', '乌拉特中旗', 'area', '150800');
INSERT INTO `mmwl_gpb_area` VALUES ('423', '150821', '五原县', 'area', '150800');
INSERT INTO `mmwl_gpb_area` VALUES ('424', '150822', '磴口县', 'area', '150800');
INSERT INTO `mmwl_gpb_area` VALUES ('425', '150825', '乌拉特后旗', 'area', '150800');
INSERT INTO `mmwl_gpb_area` VALUES ('426', '150900', '乌兰察布市', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('427', '150981', '丰镇市', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('428', '150927', '察哈尔右翼中旗', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('429', '150929', '四子王旗', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('430', '150902', '集宁区', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('431', '150923', '商都县', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('432', '150926', '察哈尔右翼前旗', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('433', '150925', '凉城县', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('434', '150921', '卓资县', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('435', '150924', '兴和县', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('436', '150928', '察哈尔右翼后旗', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('437', '150922', '化德县', 'area', '150900');
INSERT INTO `mmwl_gpb_area` VALUES ('438', '152200', '兴安盟', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('439', '152221', '科尔沁右翼前旗', 'area', '152200');
INSERT INTO `mmwl_gpb_area` VALUES ('440', '152223', '扎赉特旗', 'area', '152200');
INSERT INTO `mmwl_gpb_area` VALUES ('441', '152201', '乌兰浩特市', 'area', '152200');
INSERT INTO `mmwl_gpb_area` VALUES ('442', '152222', '科尔沁右翼中旗', 'area', '152200');
INSERT INTO `mmwl_gpb_area` VALUES ('443', '152224', '突泉县', 'area', '152200');
INSERT INTO `mmwl_gpb_area` VALUES ('444', '152202', '阿尔山市', 'area', '152200');
INSERT INTO `mmwl_gpb_area` VALUES ('445', '152500', '锡林郭勒盟', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('446', '152502', '锡林浩特市', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('447', '152525', '东乌珠穆沁旗', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('448', '152530', '正蓝旗', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('449', '152524', '苏尼特右旗', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('450', '152522', '阿巴嘎旗', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('451', '152526', '西乌珠穆沁旗', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('452', '152527', '太仆寺旗', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('453', '152523', '苏尼特左旗', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('454', '152531', '多伦县', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('455', '152529', '正镶白旗', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('456', '152501', '二连浩特市', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('457', '152528', '镶黄旗', 'area', '152500');
INSERT INTO `mmwl_gpb_area` VALUES ('458', '152900', '阿拉善盟', 'city', '150000');
INSERT INTO `mmwl_gpb_area` VALUES ('459', '152921', '阿拉善左旗', 'area', '152900');
INSERT INTO `mmwl_gpb_area` VALUES ('460', '152922', '阿拉善右旗', 'area', '152900');
INSERT INTO `mmwl_gpb_area` VALUES ('461', '152923', '额济纳旗', 'area', '152900');
INSERT INTO `mmwl_gpb_area` VALUES ('462', '210000', '辽宁省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('463', '210100', '沈阳市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('464', '210181', '新民市', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('465', '210106', '铁西区', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('466', '210115', '辽中区', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('467', '210124', '法库县', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('468', '210111', '苏家屯区', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('469', '210123', '康平县', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('470', '210103', '沈河区', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('471', '210112', '浑南区', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('472', '210113', '沈北新区', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('473', '210104', '大东区', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('474', '210102', '和平区', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('475', '210105', '皇姑区', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('476', '210114', '于洪区', 'area', '210100');
INSERT INTO `mmwl_gpb_area` VALUES ('477', '210200', '大连市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('478', '210281', '瓦房店市', 'area', '210200');
INSERT INTO `mmwl_gpb_area` VALUES ('479', '210283', '庄河市', 'area', '210200');
INSERT INTO `mmwl_gpb_area` VALUES ('480', '210214', '普兰店区', 'area', '210200');
INSERT INTO `mmwl_gpb_area` VALUES ('481', '210213', '金州区', 'area', '210200');
INSERT INTO `mmwl_gpb_area` VALUES ('482', '210211', '甘井子区', 'area', '210200');
INSERT INTO `mmwl_gpb_area` VALUES ('483', '210212', '旅顺口区', 'area', '210200');
INSERT INTO `mmwl_gpb_area` VALUES ('484', '210204', '沙河口区', 'area', '210200');
INSERT INTO `mmwl_gpb_area` VALUES ('485', '210202', '中山区', 'area', '210200');
INSERT INTO `mmwl_gpb_area` VALUES ('486', '210203', '西岗区', 'area', '210200');
INSERT INTO `mmwl_gpb_area` VALUES ('487', '210224', '长海县', 'area', '210200');
INSERT INTO `mmwl_gpb_area` VALUES ('488', '210300', '鞍山市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('489', '210381', '海城市', 'area', '210300');
INSERT INTO `mmwl_gpb_area` VALUES ('490', '210323', '岫岩满族自治县', 'area', '210300');
INSERT INTO `mmwl_gpb_area` VALUES ('491', '210303', '铁西区', 'area', '210300');
INSERT INTO `mmwl_gpb_area` VALUES ('492', '210321', '台安县', 'area', '210300');
INSERT INTO `mmwl_gpb_area` VALUES ('493', '210304', '立山区', 'area', '210300');
INSERT INTO `mmwl_gpb_area` VALUES ('494', '210302', '铁东区', 'area', '210300');
INSERT INTO `mmwl_gpb_area` VALUES ('495', '210311', '千山区', 'area', '210300');
INSERT INTO `mmwl_gpb_area` VALUES ('496', '210400', '抚顺市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('497', '210422', '新宾满族自治县', 'area', '210400');
INSERT INTO `mmwl_gpb_area` VALUES ('498', '210423', '清原满族自治县', 'area', '210400');
INSERT INTO `mmwl_gpb_area` VALUES ('499', '210404', '望花区', 'area', '210400');
INSERT INTO `mmwl_gpb_area` VALUES ('500', '210421', '抚顺县', 'area', '210400');
INSERT INTO `mmwl_gpb_area` VALUES ('501', '210402', '新抚区', 'area', '210400');
INSERT INTO `mmwl_gpb_area` VALUES ('502', '210403', '东洲区', 'area', '210400');
INSERT INTO `mmwl_gpb_area` VALUES ('503', '210411', '顺城区', 'area', '210400');
INSERT INTO `mmwl_gpb_area` VALUES ('504', '210500', '本溪市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('505', '210522', '桓仁满族自治县', 'area', '210500');
INSERT INTO `mmwl_gpb_area` VALUES ('506', '210521', '本溪满族自治县', 'area', '210500');
INSERT INTO `mmwl_gpb_area` VALUES ('507', '210503', '溪湖区', 'area', '210500');
INSERT INTO `mmwl_gpb_area` VALUES ('508', '210502', '平山区', 'area', '210500');
INSERT INTO `mmwl_gpb_area` VALUES ('509', '210504', '明山区', 'area', '210500');
INSERT INTO `mmwl_gpb_area` VALUES ('510', '210505', '南芬区', 'area', '210500');
INSERT INTO `mmwl_gpb_area` VALUES ('511', '210600', '丹东市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('512', '210624', '宽甸满族自治县', 'area', '210600');
INSERT INTO `mmwl_gpb_area` VALUES ('513', '210682', '凤城市', 'area', '210600');
INSERT INTO `mmwl_gpb_area` VALUES ('514', '210681', '东港市', 'area', '210600');
INSERT INTO `mmwl_gpb_area` VALUES ('515', '210603', '振兴区', 'area', '210600');
INSERT INTO `mmwl_gpb_area` VALUES ('516', '210604', '振安区', 'area', '210600');
INSERT INTO `mmwl_gpb_area` VALUES ('517', '210602', '元宝区', 'area', '210600');
INSERT INTO `mmwl_gpb_area` VALUES ('518', '210700', '锦州市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('519', '210726', '黑山县', 'area', '210700');
INSERT INTO `mmwl_gpb_area` VALUES ('520', '210781', '凌海市', 'area', '210700');
INSERT INTO `mmwl_gpb_area` VALUES ('521', '210782', '北镇市', 'area', '210700');
INSERT INTO `mmwl_gpb_area` VALUES ('522', '210727', '义县', 'area', '210700');
INSERT INTO `mmwl_gpb_area` VALUES ('523', '210711', '太和区', 'area', '210700');
INSERT INTO `mmwl_gpb_area` VALUES ('524', '210703', '凌河区', 'area', '210700');
INSERT INTO `mmwl_gpb_area` VALUES ('525', '210702', '古塔区', 'area', '210700');
INSERT INTO `mmwl_gpb_area` VALUES ('526', '210800', '营口市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('527', '210881', '盖州市', 'area', '210800');
INSERT INTO `mmwl_gpb_area` VALUES ('528', '210882', '大石桥市', 'area', '210800');
INSERT INTO `mmwl_gpb_area` VALUES ('529', '210803', '西市区', 'area', '210800');
INSERT INTO `mmwl_gpb_area` VALUES ('530', '210804', '鲅鱼圈区', 'area', '210800');
INSERT INTO `mmwl_gpb_area` VALUES ('531', '210802', '站前区', 'area', '210800');
INSERT INTO `mmwl_gpb_area` VALUES ('532', '210811', '老边区', 'area', '210800');
INSERT INTO `mmwl_gpb_area` VALUES ('533', '210900', '阜新市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('534', '210921', '阜新蒙古族自治县', 'area', '210900');
INSERT INTO `mmwl_gpb_area` VALUES ('535', '210922', '彰武县', 'area', '210900');
INSERT INTO `mmwl_gpb_area` VALUES ('536', '210902', '海州区', 'area', '210900');
INSERT INTO `mmwl_gpb_area` VALUES ('537', '210911', '细河区', 'area', '210900');
INSERT INTO `mmwl_gpb_area` VALUES ('538', '210904', '太平区', 'area', '210900');
INSERT INTO `mmwl_gpb_area` VALUES ('539', '210905', '清河门区', 'area', '210900');
INSERT INTO `mmwl_gpb_area` VALUES ('540', '210903', '新邱区', 'area', '210900');
INSERT INTO `mmwl_gpb_area` VALUES ('541', '211000', '辽阳市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('542', '211021', '辽阳县', 'area', '211000');
INSERT INTO `mmwl_gpb_area` VALUES ('543', '211081', '灯塔市', 'area', '211000');
INSERT INTO `mmwl_gpb_area` VALUES ('544', '211002', '白塔区', 'area', '211000');
INSERT INTO `mmwl_gpb_area` VALUES ('545', '211011', '太子河区', 'area', '211000');
INSERT INTO `mmwl_gpb_area` VALUES ('546', '211004', '宏伟区', 'area', '211000');
INSERT INTO `mmwl_gpb_area` VALUES ('547', '211005', '弓长岭区', 'area', '211000');
INSERT INTO `mmwl_gpb_area` VALUES ('548', '211003', '文圣区', 'area', '211000');
INSERT INTO `mmwl_gpb_area` VALUES ('549', '211100', '盘锦市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('550', '211103', '兴隆台区', 'area', '211100');
INSERT INTO `mmwl_gpb_area` VALUES ('551', '211104', '大洼区', 'area', '211100');
INSERT INTO `mmwl_gpb_area` VALUES ('552', '211122', '盘山县', 'area', '211100');
INSERT INTO `mmwl_gpb_area` VALUES ('553', '211102', '双台子区', 'area', '211100');
INSERT INTO `mmwl_gpb_area` VALUES ('554', '211200', '铁岭市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('555', '211224', '昌图县', 'area', '211200');
INSERT INTO `mmwl_gpb_area` VALUES ('556', '211282', '开原市', 'area', '211200');
INSERT INTO `mmwl_gpb_area` VALUES ('557', '211223', '西丰县', 'area', '211200');
INSERT INTO `mmwl_gpb_area` VALUES ('558', '211221', '铁岭县', 'area', '211200');
INSERT INTO `mmwl_gpb_area` VALUES ('559', '211202', '银州区', 'area', '211200');
INSERT INTO `mmwl_gpb_area` VALUES ('560', '211281', '调兵山市', 'area', '211200');
INSERT INTO `mmwl_gpb_area` VALUES ('561', '211204', '清河区', 'area', '211200');
INSERT INTO `mmwl_gpb_area` VALUES ('562', '211300', '朝阳市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('563', '211381', '北票市', 'area', '211300');
INSERT INTO `mmwl_gpb_area` VALUES ('564', '211322', '建平县', 'area', '211300');
INSERT INTO `mmwl_gpb_area` VALUES ('565', '211382', '凌源市', 'area', '211300');
INSERT INTO `mmwl_gpb_area` VALUES ('566', '211321', '朝阳县', 'area', '211300');
INSERT INTO `mmwl_gpb_area` VALUES ('567', '211324', '喀喇沁左翼蒙古族自治县', 'area', '211300');
INSERT INTO `mmwl_gpb_area` VALUES ('568', '211302', '双塔区', 'area', '211300');
INSERT INTO `mmwl_gpb_area` VALUES ('569', '211303', '龙城区', 'area', '211300');
INSERT INTO `mmwl_gpb_area` VALUES ('570', '211400', '葫芦岛市', 'city', '210000');
INSERT INTO `mmwl_gpb_area` VALUES ('571', '211422', '建昌县', 'area', '211400');
INSERT INTO `mmwl_gpb_area` VALUES ('572', '211481', '兴城市', 'area', '211400');
INSERT INTO `mmwl_gpb_area` VALUES ('573', '211421', '绥中县', 'area', '211400');
INSERT INTO `mmwl_gpb_area` VALUES ('574', '211402', '连山区', 'area', '211400');
INSERT INTO `mmwl_gpb_area` VALUES ('575', '211404', '南票区', 'area', '211400');
INSERT INTO `mmwl_gpb_area` VALUES ('576', '211403', '龙港区', 'area', '211400');
INSERT INTO `mmwl_gpb_area` VALUES ('577', '220000', '吉林省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('578', '220100', '长春市', 'city', '220000');
INSERT INTO `mmwl_gpb_area` VALUES ('579', '220182', '榆树市', 'area', '220100');
INSERT INTO `mmwl_gpb_area` VALUES ('580', '220122', '农安县', 'area', '220100');
INSERT INTO `mmwl_gpb_area` VALUES ('581', '220102', '南关区', 'area', '220100');
INSERT INTO `mmwl_gpb_area` VALUES ('582', '220183', '德惠市', 'area', '220100');
INSERT INTO `mmwl_gpb_area` VALUES ('583', '220113', '九台区', 'area', '220100');
INSERT INTO `mmwl_gpb_area` VALUES ('584', '220103', '宽城区', 'area', '220100');
INSERT INTO `mmwl_gpb_area` VALUES ('585', '220105', '二道区', 'area', '220100');
INSERT INTO `mmwl_gpb_area` VALUES ('586', '220104', '朝阳区', 'area', '220100');
INSERT INTO `mmwl_gpb_area` VALUES ('587', '220106', '绿园区', 'area', '220100');
INSERT INTO `mmwl_gpb_area` VALUES ('588', '220112', '双阳区', 'area', '220100');
INSERT INTO `mmwl_gpb_area` VALUES ('589', '220200', '吉林市', 'city', '220000');
INSERT INTO `mmwl_gpb_area` VALUES ('590', '220202', '昌邑区', 'area', '220200');
INSERT INTO `mmwl_gpb_area` VALUES ('591', '220203', '龙潭区', 'area', '220200');
INSERT INTO `mmwl_gpb_area` VALUES ('592', '220283', '舒兰市', 'area', '220200');
INSERT INTO `mmwl_gpb_area` VALUES ('593', '220284', '磐石市', 'area', '220200');
INSERT INTO `mmwl_gpb_area` VALUES ('594', '220281', '蛟河市', 'area', '220200');
INSERT INTO `mmwl_gpb_area` VALUES ('595', '220204', '船营区', 'area', '220200');
INSERT INTO `mmwl_gpb_area` VALUES ('596', '220282', '桦甸市', 'area', '220200');
INSERT INTO `mmwl_gpb_area` VALUES ('597', '220211', '丰满区', 'area', '220200');
INSERT INTO `mmwl_gpb_area` VALUES ('598', '220221', '永吉县', 'area', '220200');
INSERT INTO `mmwl_gpb_area` VALUES ('599', '220300', '四平市', 'city', '220000');
INSERT INTO `mmwl_gpb_area` VALUES ('600', '220381', '公主岭市', 'area', '220300');
INSERT INTO `mmwl_gpb_area` VALUES ('601', '220322', '梨树县', 'area', '220300');
INSERT INTO `mmwl_gpb_area` VALUES ('602', '220382', '双辽市', 'area', '220300');
INSERT INTO `mmwl_gpb_area` VALUES ('603', '220323', '伊通满族自治县', 'area', '220300');
INSERT INTO `mmwl_gpb_area` VALUES ('604', '220303', '铁东区', 'area', '220300');
INSERT INTO `mmwl_gpb_area` VALUES ('605', '220302', '铁西区', 'area', '220300');
INSERT INTO `mmwl_gpb_area` VALUES ('606', '220400', '辽源市', 'city', '220000');
INSERT INTO `mmwl_gpb_area` VALUES ('607', '220421', '东丰县', 'area', '220400');
INSERT INTO `mmwl_gpb_area` VALUES ('608', '220422', '东辽县', 'area', '220400');
INSERT INTO `mmwl_gpb_area` VALUES ('609', '220402', '龙山区', 'area', '220400');
INSERT INTO `mmwl_gpb_area` VALUES ('610', '220403', '西安区', 'area', '220400');
INSERT INTO `mmwl_gpb_area` VALUES ('611', '220500', '通化市', 'city', '220000');
INSERT INTO `mmwl_gpb_area` VALUES ('612', '220581', '梅河口市', 'area', '220500');
INSERT INTO `mmwl_gpb_area` VALUES ('613', '220521', '通化县', 'area', '220500');
INSERT INTO `mmwl_gpb_area` VALUES ('614', '220524', '柳河县', 'area', '220500');
INSERT INTO `mmwl_gpb_area` VALUES ('615', '220582', '集安市', 'area', '220500');
INSERT INTO `mmwl_gpb_area` VALUES ('616', '220523', '辉南县', 'area', '220500');
INSERT INTO `mmwl_gpb_area` VALUES ('617', '220502', '东昌区', 'area', '220500');
INSERT INTO `mmwl_gpb_area` VALUES ('618', '220503', '二道江区', 'area', '220500');
INSERT INTO `mmwl_gpb_area` VALUES ('619', '220600', '白山市', 'city', '220000');
INSERT INTO `mmwl_gpb_area` VALUES ('620', '220621', '抚松县', 'area', '220600');
INSERT INTO `mmwl_gpb_area` VALUES ('621', '220681', '临江市', 'area', '220600');
INSERT INTO `mmwl_gpb_area` VALUES ('622', '220602', '浑江区', 'area', '220600');
INSERT INTO `mmwl_gpb_area` VALUES ('623', '220605', '江源区', 'area', '220600');
INSERT INTO `mmwl_gpb_area` VALUES ('624', '220622', '靖宇县', 'area', '220600');
INSERT INTO `mmwl_gpb_area` VALUES ('625', '220623', '长白朝鲜族自治县', 'area', '220600');
INSERT INTO `mmwl_gpb_area` VALUES ('626', '220700', '松原市', 'city', '220000');
INSERT INTO `mmwl_gpb_area` VALUES ('627', '220721', '前郭尔罗斯蒙古族自治县', 'area', '220700');
INSERT INTO `mmwl_gpb_area` VALUES ('628', '220702', '宁江区', 'area', '220700');
INSERT INTO `mmwl_gpb_area` VALUES ('629', '220722', '长岭县', 'area', '220700');
INSERT INTO `mmwl_gpb_area` VALUES ('630', '220781', '扶余市', 'area', '220700');
INSERT INTO `mmwl_gpb_area` VALUES ('631', '220723', '乾安县', 'area', '220700');
INSERT INTO `mmwl_gpb_area` VALUES ('632', '220800', '白城市', 'city', '220000');
INSERT INTO `mmwl_gpb_area` VALUES ('633', '220882', '大安市', 'area', '220800');
INSERT INTO `mmwl_gpb_area` VALUES ('634', '220802', '洮北区', 'area', '220800');
INSERT INTO `mmwl_gpb_area` VALUES ('635', '220881', '洮南市', 'area', '220800');
INSERT INTO `mmwl_gpb_area` VALUES ('636', '220822', '通榆县', 'area', '220800');
INSERT INTO `mmwl_gpb_area` VALUES ('637', '220821', '镇赉县', 'area', '220800');
INSERT INTO `mmwl_gpb_area` VALUES ('638', '222400', '延边朝鲜族自治州', 'city', '220000');
INSERT INTO `mmwl_gpb_area` VALUES ('639', '222403', '敦化市', 'area', '222400');
INSERT INTO `mmwl_gpb_area` VALUES ('640', '222424', '汪清县', 'area', '222400');
INSERT INTO `mmwl_gpb_area` VALUES ('641', '222404', '珲春市', 'area', '222400');
INSERT INTO `mmwl_gpb_area` VALUES ('642', '222406', '和龙市', 'area', '222400');
INSERT INTO `mmwl_gpb_area` VALUES ('643', '222426', '安图县', 'area', '222400');
INSERT INTO `mmwl_gpb_area` VALUES ('644', '222401', '延吉市', 'area', '222400');
INSERT INTO `mmwl_gpb_area` VALUES ('645', '222405', '龙井市', 'area', '222400');
INSERT INTO `mmwl_gpb_area` VALUES ('646', '222402', '图们市', 'area', '222400');
INSERT INTO `mmwl_gpb_area` VALUES ('647', '230000', '黑龙江省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('648', '230100', '哈尔滨市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('649', '230104', '道外区', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('650', '230184', '五常市', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('651', '230110', '香坊区', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('652', '230113', '双城区', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('653', '230102', '道里区', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('654', '230111', '呼兰区', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('655', '230103', '南岗区', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('656', '230112', '阿城区', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('657', '230126', '巴彦县', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('658', '230125', '宾县', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('659', '230183', '尚志市', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('660', '230128', '通河县', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('661', '230123', '依兰县', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('662', '230129', '延寿县', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('663', '230127', '木兰县', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('664', '230124', '方正县', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('665', '230108', '平房区', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('666', '230109', '松北区', 'area', '230100');
INSERT INTO `mmwl_gpb_area` VALUES ('667', '230200', '齐齐哈尔市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('668', '230281', '讷河市', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('669', '230223', '依安县', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('670', '230229', '克山县', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('671', '230231', '拜泉县', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('672', '230221', '龙江县', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('673', '230224', '泰来县', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('674', '230225', '甘南县', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('675', '230227', '富裕县', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('676', '230206', '富拉尔基区', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('677', '230204', '铁锋区', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('678', '230230', '克东县', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('679', '230202', '龙沙区', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('680', '230208', '梅里斯达斡尔族区', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('681', '230205', '昂昂溪区', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('682', '230203', '建华区', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('683', '230207', '碾子山区', 'area', '230200');
INSERT INTO `mmwl_gpb_area` VALUES ('684', '230300', '鸡西市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('685', '230382', '密山市', 'area', '230300');
INSERT INTO `mmwl_gpb_area` VALUES ('686', '230381', '虎林市', 'area', '230300');
INSERT INTO `mmwl_gpb_area` VALUES ('687', '230321', '鸡东县', 'area', '230300');
INSERT INTO `mmwl_gpb_area` VALUES ('688', '230302', '鸡冠区', 'area', '230300');
INSERT INTO `mmwl_gpb_area` VALUES ('689', '230303', '恒山区', 'area', '230300');
INSERT INTO `mmwl_gpb_area` VALUES ('690', '230306', '城子河区', 'area', '230300');
INSERT INTO `mmwl_gpb_area` VALUES ('691', '230304', '滴道区', 'area', '230300');
INSERT INTO `mmwl_gpb_area` VALUES ('692', '230305', '梨树区', 'area', '230300');
INSERT INTO `mmwl_gpb_area` VALUES ('693', '230307', '麻山区', 'area', '230300');
INSERT INTO `mmwl_gpb_area` VALUES ('694', '230400', '鹤岗市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('695', '230421', '萝北县', 'area', '230400');
INSERT INTO `mmwl_gpb_area` VALUES ('696', '230422', '绥滨县', 'area', '230400');
INSERT INTO `mmwl_gpb_area` VALUES ('697', '230406', '东山区', 'area', '230400');
INSERT INTO `mmwl_gpb_area` VALUES ('698', '230403', '工农区', 'area', '230400');
INSERT INTO `mmwl_gpb_area` VALUES ('699', '230404', '南山区', 'area', '230400');
INSERT INTO `mmwl_gpb_area` VALUES ('700', '230405', '兴安区', 'area', '230400');
INSERT INTO `mmwl_gpb_area` VALUES ('701', '230402', '向阳区', 'area', '230400');
INSERT INTO `mmwl_gpb_area` VALUES ('702', '230407', '兴山区', 'area', '230400');
INSERT INTO `mmwl_gpb_area` VALUES ('703', '230500', '双鸭山市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('704', '230524', '饶河县', 'area', '230500');
INSERT INTO `mmwl_gpb_area` VALUES ('705', '230523', '宝清县', 'area', '230500');
INSERT INTO `mmwl_gpb_area` VALUES ('706', '230522', '友谊县', 'area', '230500');
INSERT INTO `mmwl_gpb_area` VALUES ('707', '230521', '集贤县', 'area', '230500');
INSERT INTO `mmwl_gpb_area` VALUES ('708', '230506', '宝山区', 'area', '230500');
INSERT INTO `mmwl_gpb_area` VALUES ('709', '230502', '尖山区', 'area', '230500');
INSERT INTO `mmwl_gpb_area` VALUES ('710', '230503', '岭东区', 'area', '230500');
INSERT INTO `mmwl_gpb_area` VALUES ('711', '230505', '四方台区', 'area', '230500');
INSERT INTO `mmwl_gpb_area` VALUES ('712', '230600', '大庆市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('713', '230622', '肇源县', 'area', '230600');
INSERT INTO `mmwl_gpb_area` VALUES ('714', '230606', '大同区', 'area', '230600');
INSERT INTO `mmwl_gpb_area` VALUES ('715', '230621', '肇州县', 'area', '230600');
INSERT INTO `mmwl_gpb_area` VALUES ('716', '230624', '杜尔伯特蒙古族自治县', 'area', '230600');
INSERT INTO `mmwl_gpb_area` VALUES ('717', '230623', '林甸县', 'area', '230600');
INSERT INTO `mmwl_gpb_area` VALUES ('718', '230604', '让胡路区', 'area', '230600');
INSERT INTO `mmwl_gpb_area` VALUES ('719', '230602', '萨尔图区', 'area', '230600');
INSERT INTO `mmwl_gpb_area` VALUES ('720', '230603', '龙凤区', 'area', '230600');
INSERT INTO `mmwl_gpb_area` VALUES ('721', '230605', '红岗区', 'area', '230600');
INSERT INTO `mmwl_gpb_area` VALUES ('722', '230700', '伊春市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('723', '230703', '南岔区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('724', '230722', '嘉荫县', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('725', '230708', '美溪区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('726', '230704', '友好区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('727', '230713', '带岭区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('728', '230711', '乌马河区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('729', '230716', '上甘岭区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('730', '230712', '汤旺河区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('731', '230706', '翠峦区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('732', '230715', '红星区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('733', '230714', '乌伊岭区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('734', '230707', '新青区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('735', '230710', '五营区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('736', '230781', '铁力市', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('737', '230702', '伊春区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('738', '230705', '西林区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('739', '230709', '金山屯区', 'area', '230700');
INSERT INTO `mmwl_gpb_area` VALUES ('740', '230800', '佳木斯市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('741', '230881', '同江市', 'area', '230800');
INSERT INTO `mmwl_gpb_area` VALUES ('742', '230882', '富锦市', 'area', '230800');
INSERT INTO `mmwl_gpb_area` VALUES ('743', '230811', '郊区', 'area', '230800');
INSERT INTO `mmwl_gpb_area` VALUES ('744', '230822', '桦南县', 'area', '230800');
INSERT INTO `mmwl_gpb_area` VALUES ('745', '230883', '抚远市', 'area', '230800');
INSERT INTO `mmwl_gpb_area` VALUES ('746', '230826', '桦川县', 'area', '230800');
INSERT INTO `mmwl_gpb_area` VALUES ('747', '230828', '汤原县', 'area', '230800');
INSERT INTO `mmwl_gpb_area` VALUES ('748', '230805', '东风区', 'area', '230800');
INSERT INTO `mmwl_gpb_area` VALUES ('749', '230803', '向阳区', 'area', '230800');
INSERT INTO `mmwl_gpb_area` VALUES ('750', '230804', '前进区', 'area', '230800');
INSERT INTO `mmwl_gpb_area` VALUES ('751', '230900', '七台河市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('752', '230921', '勃利县', 'area', '230900');
INSERT INTO `mmwl_gpb_area` VALUES ('753', '230902', '新兴区', 'area', '230900');
INSERT INTO `mmwl_gpb_area` VALUES ('754', '230904', '茄子河区', 'area', '230900');
INSERT INTO `mmwl_gpb_area` VALUES ('755', '230903', '桃山区', 'area', '230900');
INSERT INTO `mmwl_gpb_area` VALUES ('756', '231000', '牡丹江市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('757', '231084', '宁安市', 'area', '231000');
INSERT INTO `mmwl_gpb_area` VALUES ('758', '231025', '林口县', 'area', '231000');
INSERT INTO `mmwl_gpb_area` VALUES ('759', '231083', '海林市', 'area', '231000');
INSERT INTO `mmwl_gpb_area` VALUES ('760', '231003', '阳明区', 'area', '231000');
INSERT INTO `mmwl_gpb_area` VALUES ('761', '231005', '西安区', 'area', '231000');
INSERT INTO `mmwl_gpb_area` VALUES ('762', '231085', '穆棱市', 'area', '231000');
INSERT INTO `mmwl_gpb_area` VALUES ('763', '231004', '爱民区', 'area', '231000');
INSERT INTO `mmwl_gpb_area` VALUES ('764', '231086', '东宁市', 'area', '231000');
INSERT INTO `mmwl_gpb_area` VALUES ('765', '231002', '东安区', 'area', '231000');
INSERT INTO `mmwl_gpb_area` VALUES ('766', '231081', '绥芬河市', 'area', '231000');
INSERT INTO `mmwl_gpb_area` VALUES ('767', '231100', '黑河市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('768', '231182', '五大连池市', 'area', '231100');
INSERT INTO `mmwl_gpb_area` VALUES ('769', '231121', '嫩江县', 'area', '231100');
INSERT INTO `mmwl_gpb_area` VALUES ('770', '231181', '北安市', 'area', '231100');
INSERT INTO `mmwl_gpb_area` VALUES ('771', '231102', '爱辉区', 'area', '231100');
INSERT INTO `mmwl_gpb_area` VALUES ('772', '231123', '逊克县', 'area', '231100');
INSERT INTO `mmwl_gpb_area` VALUES ('773', '231124', '孙吴县', 'area', '231100');
INSERT INTO `mmwl_gpb_area` VALUES ('774', '231200', '绥化市', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('775', '231283', '海伦市', 'area', '231200');
INSERT INTO `mmwl_gpb_area` VALUES ('776', '231202', '北林区', 'area', '231200');
INSERT INTO `mmwl_gpb_area` VALUES ('777', '231282', '肇东市', 'area', '231200');
INSERT INTO `mmwl_gpb_area` VALUES ('778', '231226', '绥棱县', 'area', '231200');
INSERT INTO `mmwl_gpb_area` VALUES ('779', '231281', '安达市', 'area', '231200');
INSERT INTO `mmwl_gpb_area` VALUES ('780', '231224', '庆安县', 'area', '231200');
INSERT INTO `mmwl_gpb_area` VALUES ('781', '231222', '兰西县', 'area', '231200');
INSERT INTO `mmwl_gpb_area` VALUES ('782', '231223', '青冈县', 'area', '231200');
INSERT INTO `mmwl_gpb_area` VALUES ('783', '231221', '望奎县', 'area', '231200');
INSERT INTO `mmwl_gpb_area` VALUES ('784', '231225', '明水县', 'area', '231200');
INSERT INTO `mmwl_gpb_area` VALUES ('785', '232700', '大兴安岭地区', 'city', '230000');
INSERT INTO `mmwl_gpb_area` VALUES ('786', '232721', '呼玛县', 'area', '232700');
INSERT INTO `mmwl_gpb_area` VALUES ('787', '232723', '漠河县', 'area', '232700');
INSERT INTO `mmwl_gpb_area` VALUES ('788', '232722', '塔河县', 'area', '232700');
INSERT INTO `mmwl_gpb_area` VALUES ('789', '232702', '松岭区', 'area', '232700');
INSERT INTO `mmwl_gpb_area` VALUES ('790', '310000', '上海市', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('791', '310100', '上海市', 'city', '310000');
INSERT INTO `mmwl_gpb_area` VALUES ('792', '310115', '浦东新区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('793', '310151', '崇明区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('794', '310117', '松江区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('795', '310106', '静安区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('796', '310104', '徐汇区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('797', '310112', '闵行区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('798', '310114', '嘉定区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('799', '310113', '宝山区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('800', '310110', '杨浦区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('801', '310118', '青浦区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('802', '310107', '普陀区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('803', '310116', '金山区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('804', '310120', '奉贤区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('805', '310105', '长宁区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('806', '310101', '黄浦区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('807', '310109', '虹口区', 'area', '310100');
INSERT INTO `mmwl_gpb_area` VALUES ('808', '320000', '江苏省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('809', '320100', '南京市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('810', '320106', '鼓楼区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('811', '320116', '六合区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('812', '320104', '秦淮区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('813', '320111', '浦口区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('814', '320115', '江宁区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('815', '320113', '栖霞区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('816', '320117', '溧水区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('817', '320118', '高淳区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('818', '320102', '玄武区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('819', '320114', '雨花台区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('820', '320105', '建邺区', 'area', '320100');
INSERT INTO `mmwl_gpb_area` VALUES ('821', '320200', '无锡市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('822', '320281', '江阴市', 'area', '320200');
INSERT INTO `mmwl_gpb_area` VALUES ('823', '320282', '宜兴市', 'area', '320200');
INSERT INTO `mmwl_gpb_area` VALUES ('824', '320213', '梁溪区', 'area', '320200');
INSERT INTO `mmwl_gpb_area` VALUES ('825', '320211', '滨湖区', 'area', '320200');
INSERT INTO `mmwl_gpb_area` VALUES ('826', '320206', '惠山区', 'area', '320200');
INSERT INTO `mmwl_gpb_area` VALUES ('827', '320205', '锡山区', 'area', '320200');
INSERT INTO `mmwl_gpb_area` VALUES ('828', '320214', '新吴区', 'area', '320200');
INSERT INTO `mmwl_gpb_area` VALUES ('829', '320300', '徐州市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('830', '320312', '铜山区', 'area', '320300');
INSERT INTO `mmwl_gpb_area` VALUES ('831', '320382', '邳州市', 'area', '320300');
INSERT INTO `mmwl_gpb_area` VALUES ('832', '320322', '沛县', 'area', '320300');
INSERT INTO `mmwl_gpb_area` VALUES ('833', '320381', '新沂市', 'area', '320300');
INSERT INTO `mmwl_gpb_area` VALUES ('834', '320324', '睢宁县', 'area', '320300');
INSERT INTO `mmwl_gpb_area` VALUES ('835', '320321', '丰县', 'area', '320300');
INSERT INTO `mmwl_gpb_area` VALUES ('836', '320311', '泉山区', 'area', '320300');
INSERT INTO `mmwl_gpb_area` VALUES ('837', '320305', '贾汪区', 'area', '320300');
INSERT INTO `mmwl_gpb_area` VALUES ('838', '320303', '云龙区', 'area', '320300');
INSERT INTO `mmwl_gpb_area` VALUES ('839', '320302', '鼓楼区', 'area', '320300');
INSERT INTO `mmwl_gpb_area` VALUES ('840', '320412', '武进区', 'area', '320400');
INSERT INTO `mmwl_gpb_area` VALUES ('841', '320481', '溧阳市', 'area', '320400');
INSERT INTO `mmwl_gpb_area` VALUES ('842', '320411', '新北区', 'area', '320400');
INSERT INTO `mmwl_gpb_area` VALUES ('843', '320404', '钟楼区', 'area', '320400');
INSERT INTO `mmwl_gpb_area` VALUES ('844', '320413', '金坛区', 'area', '320400');
INSERT INTO `mmwl_gpb_area` VALUES ('845', '320402', '天宁区', 'area', '320400');
INSERT INTO `mmwl_gpb_area` VALUES ('846', '320500', '苏州市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('847', '320508', '姑苏区', 'area', '320500');
INSERT INTO `mmwl_gpb_area` VALUES ('848', '320506', '吴中区', 'area', '320500');
INSERT INTO `mmwl_gpb_area` VALUES ('849', '320581', '常熟市', 'area', '320500');
INSERT INTO `mmwl_gpb_area` VALUES ('850', '320583', '昆山市', 'area', '320500');
INSERT INTO `mmwl_gpb_area` VALUES ('851', '320582', '张家港市', 'area', '320500');
INSERT INTO `mmwl_gpb_area` VALUES ('852', '320509', '吴江区', 'area', '320500');
INSERT INTO `mmwl_gpb_area` VALUES ('853', '320507', '相城区', 'area', '320500');
INSERT INTO `mmwl_gpb_area` VALUES ('854', '320505', '虎丘区', 'area', '320500');
INSERT INTO `mmwl_gpb_area` VALUES ('855', '320585', '太仓市', 'area', '320500');
INSERT INTO `mmwl_gpb_area` VALUES ('856', '320600', '南通市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('857', '320602', '崇川区', 'area', '320600');
INSERT INTO `mmwl_gpb_area` VALUES ('858', '320612', '通州区', 'area', '320600');
INSERT INTO `mmwl_gpb_area` VALUES ('859', '320682', '如皋市', 'area', '320600');
INSERT INTO `mmwl_gpb_area` VALUES ('860', '320623', '如东县', 'area', '320600');
INSERT INTO `mmwl_gpb_area` VALUES ('861', '320684', '海门市', 'area', '320600');
INSERT INTO `mmwl_gpb_area` VALUES ('862', '320681', '启东市', 'area', '320600');
INSERT INTO `mmwl_gpb_area` VALUES ('863', '320621', '海安县', 'area', '320600');
INSERT INTO `mmwl_gpb_area` VALUES ('864', '320611', '港闸区', 'area', '320600');
INSERT INTO `mmwl_gpb_area` VALUES ('865', '320700', '连云港市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('866', '320706', '海州区', 'area', '320700');
INSERT INTO `mmwl_gpb_area` VALUES ('867', '320722', '东海县', 'area', '320700');
INSERT INTO `mmwl_gpb_area` VALUES ('868', '320723', '灌云县', 'area', '320700');
INSERT INTO `mmwl_gpb_area` VALUES ('869', '320707', '赣榆区', 'area', '320700');
INSERT INTO `mmwl_gpb_area` VALUES ('870', '320703', '连云区', 'area', '320700');
INSERT INTO `mmwl_gpb_area` VALUES ('871', '320724', '灌南县', 'area', '320700');
INSERT INTO `mmwl_gpb_area` VALUES ('872', '320800', '淮安市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('873', '320803', '淮安区', 'area', '320800');
INSERT INTO `mmwl_gpb_area` VALUES ('874', '320812', '清江浦区', 'area', '320800');
INSERT INTO `mmwl_gpb_area` VALUES ('875', '320830', '盱眙县', 'area', '320800');
INSERT INTO `mmwl_gpb_area` VALUES ('876', '320804', '淮阴区', 'area', '320800');
INSERT INTO `mmwl_gpb_area` VALUES ('877', '320826', '涟水县', 'area', '320800');
INSERT INTO `mmwl_gpb_area` VALUES ('878', '320831', '金湖县', 'area', '320800');
INSERT INTO `mmwl_gpb_area` VALUES ('879', '320813', '洪泽区', 'area', '320800');
INSERT INTO `mmwl_gpb_area` VALUES ('880', '320900', '盐城市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('881', '320924', '射阳县', 'area', '320900');
INSERT INTO `mmwl_gpb_area` VALUES ('882', '320904', '大丰区', 'area', '320900');
INSERT INTO `mmwl_gpb_area` VALUES ('883', '320902', '亭湖区', 'area', '320900');
INSERT INTO `mmwl_gpb_area` VALUES ('884', '320922', '滨海县', 'area', '320900');
INSERT INTO `mmwl_gpb_area` VALUES ('885', '320981', '东台市', 'area', '320900');
INSERT INTO `mmwl_gpb_area` VALUES ('886', '320923', '阜宁县', 'area', '320900');
INSERT INTO `mmwl_gpb_area` VALUES ('887', '320925', '建湖县', 'area', '320900');
INSERT INTO `mmwl_gpb_area` VALUES ('888', '320903', '盐都区', 'area', '320900');
INSERT INTO `mmwl_gpb_area` VALUES ('889', '320921', '响水县', 'area', '320900');
INSERT INTO `mmwl_gpb_area` VALUES ('890', '321000', '扬州市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('891', '321003', '邗江区', 'area', '321000');
INSERT INTO `mmwl_gpb_area` VALUES ('892', '321084', '高邮市', 'area', '321000');
INSERT INTO `mmwl_gpb_area` VALUES ('893', '321023', '宝应县', 'area', '321000');
INSERT INTO `mmwl_gpb_area` VALUES ('894', '321012', '江都区', 'area', '321000');
INSERT INTO `mmwl_gpb_area` VALUES ('895', '321002', '广陵区', 'area', '321000');
INSERT INTO `mmwl_gpb_area` VALUES ('896', '321081', '仪征市', 'area', '321000');
INSERT INTO `mmwl_gpb_area` VALUES ('897', '321100', '镇江市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('898', '321183', '句容市', 'area', '321100');
INSERT INTO `mmwl_gpb_area` VALUES ('899', '321102', '京口区', 'area', '321100');
INSERT INTO `mmwl_gpb_area` VALUES ('900', '321181', '丹阳市', 'area', '321100');
INSERT INTO `mmwl_gpb_area` VALUES ('901', '321112', '丹徒区', 'area', '321100');
INSERT INTO `mmwl_gpb_area` VALUES ('902', '321111', '润州区', 'area', '321100');
INSERT INTO `mmwl_gpb_area` VALUES ('903', '321182', '扬中市', 'area', '321100');
INSERT INTO `mmwl_gpb_area` VALUES ('904', '321200', '泰州市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('905', '321281', '兴化市', 'area', '321200');
INSERT INTO `mmwl_gpb_area` VALUES ('906', '321283', '泰兴市', 'area', '321200');
INSERT INTO `mmwl_gpb_area` VALUES ('907', '321204', '姜堰区', 'area', '321200');
INSERT INTO `mmwl_gpb_area` VALUES ('908', '321202', '海陵区', 'area', '321200');
INSERT INTO `mmwl_gpb_area` VALUES ('909', '321282', '靖江市', 'area', '321200');
INSERT INTO `mmwl_gpb_area` VALUES ('910', '321203', '高港区', 'area', '321200');
INSERT INTO `mmwl_gpb_area` VALUES ('911', '321300', '宿迁市', 'city', '320000');
INSERT INTO `mmwl_gpb_area` VALUES ('912', '321322', '沭阳县', 'area', '321300');
INSERT INTO `mmwl_gpb_area` VALUES ('913', '321324', '泗洪县', 'area', '321300');
INSERT INTO `mmwl_gpb_area` VALUES ('914', '321302', '宿城区', 'area', '321300');
INSERT INTO `mmwl_gpb_area` VALUES ('915', '321323', '泗阳县', 'area', '321300');
INSERT INTO `mmwl_gpb_area` VALUES ('916', '321311', '宿豫区', 'area', '321300');
INSERT INTO `mmwl_gpb_area` VALUES ('917', '330000', '浙江省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('918', '330100', '杭州市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('919', '330109', '萧山区', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('920', '330111', '富阳区', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('921', '330127', '淳安县', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('922', '330110', '余杭区', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('923', '330185', '临安区', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('924', '330182', '建德市', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('925', '330122', '桐庐县', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('926', '330106', '西湖区', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('927', '330104', '江干区', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('928', '330105', '拱墅区', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('929', '330103', '下城区', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('930', '330102', '上城区', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('931', '330108', '滨江区', 'area', '330100');
INSERT INTO `mmwl_gpb_area` VALUES ('932', '330200', '宁波市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('933', '330212', '鄞州区', 'area', '330200');
INSERT INTO `mmwl_gpb_area` VALUES ('934', '330281', '余姚市', 'area', '330200');
INSERT INTO `mmwl_gpb_area` VALUES ('935', '330282', '慈溪市', 'area', '330200');
INSERT INTO `mmwl_gpb_area` VALUES ('936', '330226', '宁海县', 'area', '330200');
INSERT INTO `mmwl_gpb_area` VALUES ('937', '330225', '象山县', 'area', '330200');
INSERT INTO `mmwl_gpb_area` VALUES ('938', '330203', '海曙区', 'area', '330200');
INSERT INTO `mmwl_gpb_area` VALUES ('939', '330213', '奉化区', 'area', '330200');
INSERT INTO `mmwl_gpb_area` VALUES ('940', '330206', '北仑区', 'area', '330200');
INSERT INTO `mmwl_gpb_area` VALUES ('941', '330205', '江北区', 'area', '330200');
INSERT INTO `mmwl_gpb_area` VALUES ('942', '330211', '镇海区', 'area', '330200');
INSERT INTO `mmwl_gpb_area` VALUES ('943', '330300', '温州市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('944', '330382', '乐清市', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('945', '330381', '瑞安市', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('946', '330324', '永嘉县', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('947', '330328', '文成县', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('948', '330302', '鹿城区', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('949', '330304', '瓯海区', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('950', '330327', '苍南县', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('951', '330303', '龙湾区', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('952', '330326', '平阳县', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('953', '330329', '泰顺县', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('954', '330305', '洞头区', 'area', '330300');
INSERT INTO `mmwl_gpb_area` VALUES ('955', '330400', '嘉兴市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('956', '330481', '海宁市', 'area', '330400');
INSERT INTO `mmwl_gpb_area` VALUES ('957', '330402', '南湖区', 'area', '330400');
INSERT INTO `mmwl_gpb_area` VALUES ('958', '330483', '桐乡市', 'area', '330400');
INSERT INTO `mmwl_gpb_area` VALUES ('959', '330411', '秀洲区', 'area', '330400');
INSERT INTO `mmwl_gpb_area` VALUES ('960', '330421', '嘉善县', 'area', '330400');
INSERT INTO `mmwl_gpb_area` VALUES ('961', '330482', '平湖市', 'area', '330400');
INSERT INTO `mmwl_gpb_area` VALUES ('962', '330424', '海盐县', 'area', '330400');
INSERT INTO `mmwl_gpb_area` VALUES ('963', '330500', '湖州市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('964', '330502', '吴兴区', 'area', '330500');
INSERT INTO `mmwl_gpb_area` VALUES ('965', '330522', '长兴县', 'area', '330500');
INSERT INTO `mmwl_gpb_area` VALUES ('966', '330523', '安吉县', 'area', '330500');
INSERT INTO `mmwl_gpb_area` VALUES ('967', '330521', '德清县', 'area', '330500');
INSERT INTO `mmwl_gpb_area` VALUES ('968', '330503', '南浔区', 'area', '330500');
INSERT INTO `mmwl_gpb_area` VALUES ('969', '330600', '绍兴市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('970', '330681', '诸暨市', 'area', '330600');
INSERT INTO `mmwl_gpb_area` VALUES ('971', '330683', '嵊州市', 'area', '330600');
INSERT INTO `mmwl_gpb_area` VALUES ('972', '330604', '上虞区', 'area', '330600');
INSERT INTO `mmwl_gpb_area` VALUES ('973', '330602', '越城区', 'area', '330600');
INSERT INTO `mmwl_gpb_area` VALUES ('974', '330603', '柯桥区', 'area', '330600');
INSERT INTO `mmwl_gpb_area` VALUES ('975', '330624', '新昌县', 'area', '330600');
INSERT INTO `mmwl_gpb_area` VALUES ('976', '330700', '金华市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('977', '330702', '婺城区', 'area', '330700');
INSERT INTO `mmwl_gpb_area` VALUES ('978', '330727', '磐安县', 'area', '330700');
INSERT INTO `mmwl_gpb_area` VALUES ('979', '330783', '东阳市', 'area', '330700');
INSERT INTO `mmwl_gpb_area` VALUES ('980', '330723', '武义县', 'area', '330700');
INSERT INTO `mmwl_gpb_area` VALUES ('981', '330781', '兰溪市', 'area', '330700');
INSERT INTO `mmwl_gpb_area` VALUES ('982', '330726', '浦江县', 'area', '330700');
INSERT INTO `mmwl_gpb_area` VALUES ('983', '330784', '永康市', 'area', '330700');
INSERT INTO `mmwl_gpb_area` VALUES ('984', '330782', '义乌市', 'area', '330700');
INSERT INTO `mmwl_gpb_area` VALUES ('985', '330703', '金东区', 'area', '330700');
INSERT INTO `mmwl_gpb_area` VALUES ('986', '330800', '衢州市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('987', '330803', '衢江区', 'area', '330800');
INSERT INTO `mmwl_gpb_area` VALUES ('988', '330881', '江山市', 'area', '330800');
INSERT INTO `mmwl_gpb_area` VALUES ('989', '330802', '柯城区', 'area', '330800');
INSERT INTO `mmwl_gpb_area` VALUES ('990', '330825', '龙游县', 'area', '330800');
INSERT INTO `mmwl_gpb_area` VALUES ('991', '330824', '开化县', 'area', '330800');
INSERT INTO `mmwl_gpb_area` VALUES ('992', '330822', '常山县', 'area', '330800');
INSERT INTO `mmwl_gpb_area` VALUES ('993', '330900', '舟山市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('994', '330902', '定海区', 'area', '330900');
INSERT INTO `mmwl_gpb_area` VALUES ('995', '330903', '普陀区', 'area', '330900');
INSERT INTO `mmwl_gpb_area` VALUES ('996', '330922', '嵊泗县', 'area', '330900');
INSERT INTO `mmwl_gpb_area` VALUES ('997', '330921', '岱山县', 'area', '330900');
INSERT INTO `mmwl_gpb_area` VALUES ('998', '331000', '台州市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('999', '331024', '仙居县', 'area', '331000');
INSERT INTO `mmwl_gpb_area` VALUES ('1000', '331082', '临海市', 'area', '331000');
INSERT INTO `mmwl_gpb_area` VALUES ('1001', '331003', '黄岩区', 'area', '331000');
INSERT INTO `mmwl_gpb_area` VALUES ('1002', '331081', '温岭市', 'area', '331000');
INSERT INTO `mmwl_gpb_area` VALUES ('1003', '331023', '天台县', 'area', '331000');
INSERT INTO `mmwl_gpb_area` VALUES ('1004', '331083', '玉环市', 'area', '331000');
INSERT INTO `mmwl_gpb_area` VALUES ('1005', '331004', '路桥区', 'area', '331000');
INSERT INTO `mmwl_gpb_area` VALUES ('1006', '331022', '三门县', 'area', '331000');
INSERT INTO `mmwl_gpb_area` VALUES ('1007', '331002', '椒江区', 'area', '331000');
INSERT INTO `mmwl_gpb_area` VALUES ('1008', '331100', '丽水市', 'city', '330000');
INSERT INTO `mmwl_gpb_area` VALUES ('1009', '331121', '青田县', 'area', '331100');
INSERT INTO `mmwl_gpb_area` VALUES ('1010', '331127', '景宁畲族自治县', 'area', '331100');
INSERT INTO `mmwl_gpb_area` VALUES ('1011', '331123', '遂昌县', 'area', '331100');
INSERT INTO `mmwl_gpb_area` VALUES ('1012', '331126', '庆元县', 'area', '331100');
INSERT INTO `mmwl_gpb_area` VALUES ('1013', '331181', '龙泉市', 'area', '331100');
INSERT INTO `mmwl_gpb_area` VALUES ('1014', '331124', '松阳县', 'area', '331100');
INSERT INTO `mmwl_gpb_area` VALUES ('1015', '331122', '缙云县', 'area', '331100');
INSERT INTO `mmwl_gpb_area` VALUES ('1016', '331102', '莲都区', 'area', '331100');
INSERT INTO `mmwl_gpb_area` VALUES ('1017', '331125', '云和县', 'area', '331100');
INSERT INTO `mmwl_gpb_area` VALUES ('1018', '340000', '安徽省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('1019', '340100', '合肥市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1020', '340122', '肥东县', 'area', '340100');
INSERT INTO `mmwl_gpb_area` VALUES ('1021', '340181', '巢湖市', 'area', '340100');
INSERT INTO `mmwl_gpb_area` VALUES ('1022', '340124', '庐江县', 'area', '340100');
INSERT INTO `mmwl_gpb_area` VALUES ('1023', '340102', '瑶海区', 'area', '340100');
INSERT INTO `mmwl_gpb_area` VALUES ('1024', '340104', '蜀山区', 'area', '340100');
INSERT INTO `mmwl_gpb_area` VALUES ('1025', '340121', '长丰县', 'area', '340100');
INSERT INTO `mmwl_gpb_area` VALUES ('1026', '340123', '肥西县', 'area', '340100');
INSERT INTO `mmwl_gpb_area` VALUES ('1027', '340111', '包河区', 'area', '340100');
INSERT INTO `mmwl_gpb_area` VALUES ('1028', '340103', '庐阳区', 'area', '340100');
INSERT INTO `mmwl_gpb_area` VALUES ('1029', '340200', '芜湖市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1030', '340225', '无为县', 'area', '340200');
INSERT INTO `mmwl_gpb_area` VALUES ('1031', '340202', '镜湖区', 'area', '340200');
INSERT INTO `mmwl_gpb_area` VALUES ('1032', '340207', '鸠江区', 'area', '340200');
INSERT INTO `mmwl_gpb_area` VALUES ('1033', '340223', '南陵县', 'area', '340200');
INSERT INTO `mmwl_gpb_area` VALUES ('1034', '340203', '弋江区', 'area', '340200');
INSERT INTO `mmwl_gpb_area` VALUES ('1035', '340222', '繁昌县', 'area', '340200');
INSERT INTO `mmwl_gpb_area` VALUES ('1036', '340221', '芜湖县', 'area', '340200');
INSERT INTO `mmwl_gpb_area` VALUES ('1037', '340208', '三山区', 'area', '340200');
INSERT INTO `mmwl_gpb_area` VALUES ('1038', '340300', '蚌埠市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1039', '340321', '怀远县', 'area', '340300');
INSERT INTO `mmwl_gpb_area` VALUES ('1040', '340322', '五河县', 'area', '340300');
INSERT INTO `mmwl_gpb_area` VALUES ('1041', '340323', '固镇县', 'area', '340300');
INSERT INTO `mmwl_gpb_area` VALUES ('1042', '340303', '蚌山区', 'area', '340300');
INSERT INTO `mmwl_gpb_area` VALUES ('1043', '340302', '龙子湖区', 'area', '340300');
INSERT INTO `mmwl_gpb_area` VALUES ('1044', '340311', '淮上区', 'area', '340300');
INSERT INTO `mmwl_gpb_area` VALUES ('1045', '340304', '禹会区', 'area', '340300');
INSERT INTO `mmwl_gpb_area` VALUES ('1046', '340400', '淮南市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1047', '340422', '寿县', 'area', '340400');
INSERT INTO `mmwl_gpb_area` VALUES ('1048', '340421', '凤台县', 'area', '340400');
INSERT INTO `mmwl_gpb_area` VALUES ('1049', '340403', '田家庵区', 'area', '340400');
INSERT INTO `mmwl_gpb_area` VALUES ('1050', '340404', '谢家集区', 'area', '340400');
INSERT INTO `mmwl_gpb_area` VALUES ('1051', '340406', '潘集区', 'area', '340400');
INSERT INTO `mmwl_gpb_area` VALUES ('1052', '340402', '大通区', 'area', '340400');
INSERT INTO `mmwl_gpb_area` VALUES ('1053', '340405', '八公山区', 'area', '340400');
INSERT INTO `mmwl_gpb_area` VALUES ('1054', '340500', '马鞍山市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1055', '340521', '当涂县', 'area', '340500');
INSERT INTO `mmwl_gpb_area` VALUES ('1056', '340523', '和县', 'area', '340500');
INSERT INTO `mmwl_gpb_area` VALUES ('1057', '340503', '花山区', 'area', '340500');
INSERT INTO `mmwl_gpb_area` VALUES ('1058', '340522', '含山县', 'area', '340500');
INSERT INTO `mmwl_gpb_area` VALUES ('1059', '340504', '雨山区', 'area', '340500');
INSERT INTO `mmwl_gpb_area` VALUES ('1060', '340506', '博望区', 'area', '340500');
INSERT INTO `mmwl_gpb_area` VALUES ('1061', '340600', '淮北市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1062', '340621', '濉溪县', 'area', '340600');
INSERT INTO `mmwl_gpb_area` VALUES ('1063', '340603', '相山区', 'area', '340600');
INSERT INTO `mmwl_gpb_area` VALUES ('1064', '340604', '烈山区', 'area', '340600');
INSERT INTO `mmwl_gpb_area` VALUES ('1065', '340602', '杜集区', 'area', '340600');
INSERT INTO `mmwl_gpb_area` VALUES ('1066', '340700', '铜陵市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1067', '340722', '枞阳县', 'area', '340700');
INSERT INTO `mmwl_gpb_area` VALUES ('1068', '340706', '义安区', 'area', '340700');
INSERT INTO `mmwl_gpb_area` VALUES ('1069', '340711', '郊区', 'area', '340700');
INSERT INTO `mmwl_gpb_area` VALUES ('1070', '340705', '铜官区', 'area', '340700');
INSERT INTO `mmwl_gpb_area` VALUES ('1071', '340800', '安庆市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1072', '340828', '岳西县', 'area', '340800');
INSERT INTO `mmwl_gpb_area` VALUES ('1073', '340826', '宿松县', 'area', '340800');
INSERT INTO `mmwl_gpb_area` VALUES ('1074', '340822', '怀宁县', 'area', '340800');
INSERT INTO `mmwl_gpb_area` VALUES ('1075', '340824', '潜山县', 'area', '340800');
INSERT INTO `mmwl_gpb_area` VALUES ('1076', '340881', '桐城市', 'area', '340800');
INSERT INTO `mmwl_gpb_area` VALUES ('1077', '340825', '太湖县', 'area', '340800');
INSERT INTO `mmwl_gpb_area` VALUES ('1078', '340803', '大观区', 'area', '340800');
INSERT INTO `mmwl_gpb_area` VALUES ('1079', '340827', '望江县', 'area', '340800');
INSERT INTO `mmwl_gpb_area` VALUES ('1080', '340802', '迎江区', 'area', '340800');
INSERT INTO `mmwl_gpb_area` VALUES ('1081', '340811', '宜秀区', 'area', '340800');
INSERT INTO `mmwl_gpb_area` VALUES ('1082', '341000', '黄山市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1083', '341021', '歙县', 'area', '341000');
INSERT INTO `mmwl_gpb_area` VALUES ('1084', '341022', '休宁县', 'area', '341000');
INSERT INTO `mmwl_gpb_area` VALUES ('1085', '341024', '祁门县', 'area', '341000');
INSERT INTO `mmwl_gpb_area` VALUES ('1086', '341003', '黄山区', 'area', '341000');
INSERT INTO `mmwl_gpb_area` VALUES ('1087', '341002', '屯溪区', 'area', '341000');
INSERT INTO `mmwl_gpb_area` VALUES ('1088', '341004', '徽州区', 'area', '341000');
INSERT INTO `mmwl_gpb_area` VALUES ('1089', '341023', '黟县', 'area', '341000');
INSERT INTO `mmwl_gpb_area` VALUES ('1090', '341100', '滁州市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1091', '341125', '定远县', 'area', '341100');
INSERT INTO `mmwl_gpb_area` VALUES ('1092', '341126', '凤阳县', 'area', '341100');
INSERT INTO `mmwl_gpb_area` VALUES ('1093', '341182', '明光市', 'area', '341100');
INSERT INTO `mmwl_gpb_area` VALUES ('1094', '341181', '天长市', 'area', '341100');
INSERT INTO `mmwl_gpb_area` VALUES ('1095', '341102', '琅琊区', 'area', '341100');
INSERT INTO `mmwl_gpb_area` VALUES ('1096', '341122', '来安县', 'area', '341100');
INSERT INTO `mmwl_gpb_area` VALUES ('1097', '341103', '南谯区', 'area', '341100');
INSERT INTO `mmwl_gpb_area` VALUES ('1098', '341124', '全椒县', 'area', '341100');
INSERT INTO `mmwl_gpb_area` VALUES ('1099', '341200', '阜阳市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1100', '341222', '太和县', 'area', '341200');
INSERT INTO `mmwl_gpb_area` VALUES ('1101', '341221', '临泉县', 'area', '341200');
INSERT INTO `mmwl_gpb_area` VALUES ('1102', '341225', '阜南县', 'area', '341200');
INSERT INTO `mmwl_gpb_area` VALUES ('1103', '341226', '颍上县', 'area', '341200');
INSERT INTO `mmwl_gpb_area` VALUES ('1104', '341282', '界首市', 'area', '341200');
INSERT INTO `mmwl_gpb_area` VALUES ('1105', '341202', '颍州区', 'area', '341200');
INSERT INTO `mmwl_gpb_area` VALUES ('1106', '341203', '颍东区', 'area', '341200');
INSERT INTO `mmwl_gpb_area` VALUES ('1107', '341204', '颍泉区', 'area', '341200');
INSERT INTO `mmwl_gpb_area` VALUES ('1108', '341300', '宿州市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1109', '341302', '埇桥区', 'area', '341300');
INSERT INTO `mmwl_gpb_area` VALUES ('1110', '341322', '萧县', 'area', '341300');
INSERT INTO `mmwl_gpb_area` VALUES ('1111', '341323', '灵璧县', 'area', '341300');
INSERT INTO `mmwl_gpb_area` VALUES ('1112', '341321', '砀山县', 'area', '341300');
INSERT INTO `mmwl_gpb_area` VALUES ('1113', '341324', '泗县', 'area', '341300');
INSERT INTO `mmwl_gpb_area` VALUES ('1114', '341500', '六安市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1115', '341522', '霍邱县', 'area', '341500');
INSERT INTO `mmwl_gpb_area` VALUES ('1116', '341524', '金寨县', 'area', '341500');
INSERT INTO `mmwl_gpb_area` VALUES ('1117', '341502', '金安区', 'area', '341500');
INSERT INTO `mmwl_gpb_area` VALUES ('1118', '341503', '裕安区', 'area', '341500');
INSERT INTO `mmwl_gpb_area` VALUES ('1119', '341523', '舒城县', 'area', '341500');
INSERT INTO `mmwl_gpb_area` VALUES ('1120', '341525', '霍山县', 'area', '341500');
INSERT INTO `mmwl_gpb_area` VALUES ('1121', '341504', '叶集区', 'area', '341500');
INSERT INTO `mmwl_gpb_area` VALUES ('1122', '341600', '亳州市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1123', '341602', '谯城区', 'area', '341600');
INSERT INTO `mmwl_gpb_area` VALUES ('1124', '341621', '涡阳县', 'area', '341600');
INSERT INTO `mmwl_gpb_area` VALUES ('1125', '341623', '利辛县', 'area', '341600');
INSERT INTO `mmwl_gpb_area` VALUES ('1126', '341622', '蒙城县', 'area', '341600');
INSERT INTO `mmwl_gpb_area` VALUES ('1127', '341700', '池州市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1128', '341702', '贵池区', 'area', '341700');
INSERT INTO `mmwl_gpb_area` VALUES ('1129', '341721', '东至县', 'area', '341700');
INSERT INTO `mmwl_gpb_area` VALUES ('1130', '341723', '青阳县', 'area', '341700');
INSERT INTO `mmwl_gpb_area` VALUES ('1131', '341722', '石台县', 'area', '341700');
INSERT INTO `mmwl_gpb_area` VALUES ('1132', '341800', '宣城市', 'city', '340000');
INSERT INTO `mmwl_gpb_area` VALUES ('1133', '341802', '宣州区', 'area', '341800');
INSERT INTO `mmwl_gpb_area` VALUES ('1134', '341881', '宁国市', 'area', '341800');
INSERT INTO `mmwl_gpb_area` VALUES ('1135', '341824', '绩溪县', 'area', '341800');
INSERT INTO `mmwl_gpb_area` VALUES ('1136', '341823', '泾县', 'area', '341800');
INSERT INTO `mmwl_gpb_area` VALUES ('1137', '341821', '郎溪县', 'area', '341800');
INSERT INTO `mmwl_gpb_area` VALUES ('1138', '341825', '旌德县', 'area', '341800');
INSERT INTO `mmwl_gpb_area` VALUES ('1139', '341822', '广德县', 'area', '341800');
INSERT INTO `mmwl_gpb_area` VALUES ('1140', '350000', '福建省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('1141', '350100', '福州市', 'city', '350000');
INSERT INTO `mmwl_gpb_area` VALUES ('1142', '350181', '福清市', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1143', '350122', '连江县', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1144', '350125', '永泰县', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1145', '350182', '长乐市', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1146', '350124', '闽清县', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1147', '350121', '闽侯县', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1148', '350128', '平潭县', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1149', '350104', '仓山区', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1150', '350123', '罗源县', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1151', '350102', '鼓楼区', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1152', '350103', '台江区', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1153', '350111', '晋安区', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1154', '350105', '马尾区', 'area', '350100');
INSERT INTO `mmwl_gpb_area` VALUES ('1155', '350200', '厦门市', 'city', '350000');
INSERT INTO `mmwl_gpb_area` VALUES ('1156', '350212', '同安区', 'area', '350200');
INSERT INTO `mmwl_gpb_area` VALUES ('1157', '350203', '思明区', 'area', '350200');
INSERT INTO `mmwl_gpb_area` VALUES ('1158', '350211', '集美区', 'area', '350200');
INSERT INTO `mmwl_gpb_area` VALUES ('1159', '350205', '海沧区', 'area', '350200');
INSERT INTO `mmwl_gpb_area` VALUES ('1160', '350213', '翔安区', 'area', '350200');
INSERT INTO `mmwl_gpb_area` VALUES ('1161', '350206', '湖里区', 'area', '350200');
INSERT INTO `mmwl_gpb_area` VALUES ('1162', '350300', '莆田市', 'city', '350000');
INSERT INTO `mmwl_gpb_area` VALUES ('1163', '350322', '仙游县', 'area', '350300');
INSERT INTO `mmwl_gpb_area` VALUES ('1164', '350303', '涵江区', 'area', '350300');
INSERT INTO `mmwl_gpb_area` VALUES ('1165', '350305', '秀屿区', 'area', '350300');
INSERT INTO `mmwl_gpb_area` VALUES ('1166', '350302', '城厢区', 'area', '350300');
INSERT INTO `mmwl_gpb_area` VALUES ('1167', '350304', '荔城区', 'area', '350300');
INSERT INTO `mmwl_gpb_area` VALUES ('1168', '350400', '三明市', 'city', '350000');
INSERT INTO `mmwl_gpb_area` VALUES ('1169', '350425', '大田县', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1170', '350424', '宁化县', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1171', '350426', '尤溪县', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1172', '350481', '永安市', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1173', '350427', '沙县', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1174', '350428', '将乐县', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1175', '350423', '清流县', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1176', '350430', '建宁县', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1177', '350421', '明溪县', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1178', '350429', '泰宁县', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1179', '350403', '三元区', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1180', '350402', '梅列区', 'area', '350400');
INSERT INTO `mmwl_gpb_area` VALUES ('1181', '350500', '泉州市', 'city', '350000');
INSERT INTO `mmwl_gpb_area` VALUES ('1182', '350583', '南安市', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1183', '350524', '安溪县', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1184', '350525', '永春县', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1185', '350582', '晋江市', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1186', '350526', '德化县', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1187', '350521', '惠安县', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1188', '350581', '石狮市', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1189', '350503', '丰泽区', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1190', '350502', '鲤城区', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1191', '350505', '泉港区', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1192', '350504', '洛江区', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1193', '350527', '金门县', 'area', '350500');
INSERT INTO `mmwl_gpb_area` VALUES ('1194', '350600', '漳州市', 'city', '350000');
INSERT INTO `mmwl_gpb_area` VALUES ('1195', '350623', '漳浦县', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1196', '350681', '龙海市', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1197', '350624', '诏安县', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1198', '350628', '平和县', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1199', '350602', '芗城区', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1200', '350622', '云霄县', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1201', '350627', '南靖县', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1202', '350629', '华安县', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1203', '350625', '长泰县', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1204', '350626', '东山县', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1205', '350603', '龙文区', 'area', '350600');
INSERT INTO `mmwl_gpb_area` VALUES ('1206', '350700', '南平市', 'city', '350000');
INSERT INTO `mmwl_gpb_area` VALUES ('1207', '350702', '延平区', 'area', '350700');
INSERT INTO `mmwl_gpb_area` VALUES ('1208', '350722', '浦城县', 'area', '350700');
INSERT INTO `mmwl_gpb_area` VALUES ('1209', '350781', '邵武市', 'area', '350700');
INSERT INTO `mmwl_gpb_area` VALUES ('1210', '350783', '建瓯市', 'area', '350700');
INSERT INTO `mmwl_gpb_area` VALUES ('1211', '350703', '建阳区', 'area', '350700');
INSERT INTO `mmwl_gpb_area` VALUES ('1212', '350721', '顺昌县', 'area', '350700');
INSERT INTO `mmwl_gpb_area` VALUES ('1213', '350725', '政和县', 'area', '350700');
INSERT INTO `mmwl_gpb_area` VALUES ('1214', '350782', '武夷山市', 'area', '350700');
INSERT INTO `mmwl_gpb_area` VALUES ('1215', '350724', '松溪县', 'area', '350700');
INSERT INTO `mmwl_gpb_area` VALUES ('1216', '350723', '光泽县', 'area', '350700');
INSERT INTO `mmwl_gpb_area` VALUES ('1217', '350800', '龙岩市', 'city', '350000');
INSERT INTO `mmwl_gpb_area` VALUES ('1218', '350803', '永定区', 'area', '350800');
INSERT INTO `mmwl_gpb_area` VALUES ('1219', '350823', '上杭县', 'area', '350800');
INSERT INTO `mmwl_gpb_area` VALUES ('1220', '350802', '新罗区', 'area', '350800');
INSERT INTO `mmwl_gpb_area` VALUES ('1221', '350821', '长汀县', 'area', '350800');
INSERT INTO `mmwl_gpb_area` VALUES ('1222', '350825', '连城县', 'area', '350800');
INSERT INTO `mmwl_gpb_area` VALUES ('1223', '350824', '武平县', 'area', '350800');
INSERT INTO `mmwl_gpb_area` VALUES ('1224', '350881', '漳平市', 'area', '350800');
INSERT INTO `mmwl_gpb_area` VALUES ('1225', '350900', '宁德市', 'city', '350000');
INSERT INTO `mmwl_gpb_area` VALUES ('1226', '350981', '福安市', 'area', '350900');
INSERT INTO `mmwl_gpb_area` VALUES ('1227', '350982', '福鼎市', 'area', '350900');
INSERT INTO `mmwl_gpb_area` VALUES ('1228', '350902', '蕉城区', 'area', '350900');
INSERT INTO `mmwl_gpb_area` VALUES ('1229', '350924', '寿宁县', 'area', '350900');
INSERT INTO `mmwl_gpb_area` VALUES ('1230', '350921', '霞浦县', 'area', '350900');
INSERT INTO `mmwl_gpb_area` VALUES ('1231', '350922', '古田县', 'area', '350900');
INSERT INTO `mmwl_gpb_area` VALUES ('1232', '350923', '屏南县', 'area', '350900');
INSERT INTO `mmwl_gpb_area` VALUES ('1233', '350926', '柘荣县', 'area', '350900');
INSERT INTO `mmwl_gpb_area` VALUES ('1234', '350925', '周宁县', 'area', '350900');
INSERT INTO `mmwl_gpb_area` VALUES ('1235', '360000', '江西省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('1236', '360100', '南昌市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1237', '360112', '新建区', 'area', '360100');
INSERT INTO `mmwl_gpb_area` VALUES ('1238', '360121', '南昌县', 'area', '360100');
INSERT INTO `mmwl_gpb_area` VALUES ('1239', '360124', '进贤县', 'area', '360100');
INSERT INTO `mmwl_gpb_area` VALUES ('1240', '360111', '青山湖区', 'area', '360100');
INSERT INTO `mmwl_gpb_area` VALUES ('1241', '360102', '东湖区', 'area', '360100');
INSERT INTO `mmwl_gpb_area` VALUES ('1242', '360103', '西湖区', 'area', '360100');
INSERT INTO `mmwl_gpb_area` VALUES ('1243', '360123', '安义县', 'area', '360100');
INSERT INTO `mmwl_gpb_area` VALUES ('1244', '360104', '青云谱区', 'area', '360100');
INSERT INTO `mmwl_gpb_area` VALUES ('1245', '360105', '湾里区', 'area', '360100');
INSERT INTO `mmwl_gpb_area` VALUES ('1246', '360200', '景德镇市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1247', '360281', '乐平市', 'area', '360200');
INSERT INTO `mmwl_gpb_area` VALUES ('1248', '360222', '浮梁县', 'area', '360200');
INSERT INTO `mmwl_gpb_area` VALUES ('1249', '360202', '昌江区', 'area', '360200');
INSERT INTO `mmwl_gpb_area` VALUES ('1250', '360203', '珠山区', 'area', '360200');
INSERT INTO `mmwl_gpb_area` VALUES ('1251', '360300', '萍乡市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1252', '360321', '莲花县', 'area', '360300');
INSERT INTO `mmwl_gpb_area` VALUES ('1253', '360313', '湘东区', 'area', '360300');
INSERT INTO `mmwl_gpb_area` VALUES ('1254', '360302', '安源区', 'area', '360300');
INSERT INTO `mmwl_gpb_area` VALUES ('1255', '360323', '芦溪县', 'area', '360300');
INSERT INTO `mmwl_gpb_area` VALUES ('1256', '360322', '上栗县', 'area', '360300');
INSERT INTO `mmwl_gpb_area` VALUES ('1257', '360400', '九江市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1258', '360424', '修水县', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1259', '360428', '都昌县', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1260', '360481', '瑞昌市', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1261', '360425', '永修县', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1262', '360423', '武宁县', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1263', '360421', '柴桑区', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1264', '360430', '彭泽县', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1265', '360483', '庐山市', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1266', '360426', '德安县', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1267', '360429', '湖口县', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1268', '360402', '濂溪区', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1269', '360403', '浔阳区', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1270', '360482', '共青城市', 'area', '360400');
INSERT INTO `mmwl_gpb_area` VALUES ('1271', '360500', '新余市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1272', '360502', '渝水区', 'area', '360500');
INSERT INTO `mmwl_gpb_area` VALUES ('1273', '360521', '分宜县', 'area', '360500');
INSERT INTO `mmwl_gpb_area` VALUES ('1274', '360600', '鹰潭市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1275', '360681', '贵溪市', 'area', '360600');
INSERT INTO `mmwl_gpb_area` VALUES ('1276', '360622', '余江县', 'area', '360600');
INSERT INTO `mmwl_gpb_area` VALUES ('1277', '360602', '月湖区', 'area', '360600');
INSERT INTO `mmwl_gpb_area` VALUES ('1278', '360700', '赣州市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1279', '360732', '兴国县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1280', '360730', '宁都县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1281', '360731', '于都县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1282', '360703', '南康区', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1283', '360733', '会昌县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1284', '360704', '赣县区', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1285', '360726', '安远县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1286', '360781', '瑞金市', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1287', '360727', '龙南县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1288', '360722', '信丰县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1289', '360725', '崇义县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1290', '360702', '章贡区', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1291', '360724', '上犹县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1292', '360734', '寻乌县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1293', '360723', '大余县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1294', '360729', '全南县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1295', '360735', '石城县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1296', '360728', '定南县', 'area', '360700');
INSERT INTO `mmwl_gpb_area` VALUES ('1297', '360800', '吉安市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1298', '360830', '永新县', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1299', '360827', '遂川县', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1300', '360826', '泰和县', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1301', '360825', '永丰县', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1302', '360821', '吉安县', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1303', '360829', '安福县', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1304', '360881', '井冈山市', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1305', '360822', '吉水县', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1306', '360828', '万安县', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1307', '360824', '新干县', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1308', '360823', '峡江县', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1309', '360802', '吉州区', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1310', '360803', '青原区', 'area', '360800');
INSERT INTO `mmwl_gpb_area` VALUES ('1311', '360900', '宜春市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1312', '360981', '丰城市', 'area', '360900');
INSERT INTO `mmwl_gpb_area` VALUES ('1313', '360902', '袁州区', 'area', '360900');
INSERT INTO `mmwl_gpb_area` VALUES ('1314', '360983', '高安市', 'area', '360900');
INSERT INTO `mmwl_gpb_area` VALUES ('1315', '360982', '樟树市', 'area', '360900');
INSERT INTO `mmwl_gpb_area` VALUES ('1316', '360922', '万载县', 'area', '360900');
INSERT INTO `mmwl_gpb_area` VALUES ('1317', '360924', '宜丰县', 'area', '360900');
INSERT INTO `mmwl_gpb_area` VALUES ('1318', '360921', '奉新县', 'area', '360900');
INSERT INTO `mmwl_gpb_area` VALUES ('1319', '360923', '上高县', 'area', '360900');
INSERT INTO `mmwl_gpb_area` VALUES ('1320', '360925', '靖安县', 'area', '360900');
INSERT INTO `mmwl_gpb_area` VALUES ('1321', '360926', '铜鼓县', 'area', '360900');
INSERT INTO `mmwl_gpb_area` VALUES ('1322', '361000', '抚州市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1323', '361002', '临川区', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1324', '361003', '东乡区', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1325', '361024', '崇仁县', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1326', '361022', '黎川县', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1327', '361025', '乐安县', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1328', '361026', '宜黄县', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1329', '361023', '南丰县', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1330', '361027', '金溪县', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1331', '361030', '广昌县', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1332', '361021', '南城县', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1333', '361028', '资溪县', 'area', '361000');
INSERT INTO `mmwl_gpb_area` VALUES ('1334', '361100', '上饶市', 'city', '360000');
INSERT INTO `mmwl_gpb_area` VALUES ('1335', '361128', '鄱阳县', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1336', '361121', '上饶县', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1337', '361127', '余干县', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1338', '361103', '广丰区', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1339', '361123', '玉山县', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1340', '361124', '铅山县', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1341', '361130', '婺源县', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1342', '361126', '弋阳县', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1343', '361181', '德兴市', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1344', '361129', '万年县', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1345', '361125', '横峰县', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1346', '361102', '信州区', 'area', '361100');
INSERT INTO `mmwl_gpb_area` VALUES ('1347', '370000', '山东省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('1348', '370100', '济南市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1349', '370112', '历城区', 'area', '370100');
INSERT INTO `mmwl_gpb_area` VALUES ('1350', '370114', '章丘区', 'area', '370100');
INSERT INTO `mmwl_gpb_area` VALUES ('1351', '370103', '市中区', 'area', '370100');
INSERT INTO `mmwl_gpb_area` VALUES ('1352', '370105', '天桥区', 'area', '370100');
INSERT INTO `mmwl_gpb_area` VALUES ('1353', '370104', '槐荫区', 'area', '370100');
INSERT INTO `mmwl_gpb_area` VALUES ('1354', '370102', '历下区', 'area', '370100');
INSERT INTO `mmwl_gpb_area` VALUES ('1355', '370126', '商河县', 'area', '370100');
INSERT INTO `mmwl_gpb_area` VALUES ('1356', '370113', '长清区', 'area', '370100');
INSERT INTO `mmwl_gpb_area` VALUES ('1357', '370125', '济阳县', 'area', '370100');
INSERT INTO `mmwl_gpb_area` VALUES ('1358', '370124', '平阴县', 'area', '370100');
INSERT INTO `mmwl_gpb_area` VALUES ('1359', '370200', '青岛市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1360', '370211', '黄岛区', 'area', '370200');
INSERT INTO `mmwl_gpb_area` VALUES ('1361', '370203', '市北区', 'area', '370200');
INSERT INTO `mmwl_gpb_area` VALUES ('1362', '370283', '平度市', 'area', '370200');
INSERT INTO `mmwl_gpb_area` VALUES ('1363', '370282', '即墨市', 'area', '370200');
INSERT INTO `mmwl_gpb_area` VALUES ('1364', '370202', '市南区', 'area', '370200');
INSERT INTO `mmwl_gpb_area` VALUES ('1365', '370281', '胶州市', 'area', '370200');
INSERT INTO `mmwl_gpb_area` VALUES ('1366', '370285', '莱西市', 'area', '370200');
INSERT INTO `mmwl_gpb_area` VALUES ('1367', '370213', '李沧区', 'area', '370200');
INSERT INTO `mmwl_gpb_area` VALUES ('1368', '370214', '城阳区', 'area', '370200');
INSERT INTO `mmwl_gpb_area` VALUES ('1369', '370212', '崂山区', 'area', '370200');
INSERT INTO `mmwl_gpb_area` VALUES ('1370', '370300', '淄博市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1371', '370303', '张店区', 'area', '370300');
INSERT INTO `mmwl_gpb_area` VALUES ('1372', '370302', '淄川区', 'area', '370300');
INSERT INTO `mmwl_gpb_area` VALUES ('1373', '370305', '临淄区', 'area', '370300');
INSERT INTO `mmwl_gpb_area` VALUES ('1374', '370323', '沂源县', 'area', '370300');
INSERT INTO `mmwl_gpb_area` VALUES ('1375', '370306', '周村区', 'area', '370300');
INSERT INTO `mmwl_gpb_area` VALUES ('1376', '370304', '博山区', 'area', '370300');
INSERT INTO `mmwl_gpb_area` VALUES ('1377', '370322', '高青县', 'area', '370300');
INSERT INTO `mmwl_gpb_area` VALUES ('1378', '370321', '桓台县', 'area', '370300');
INSERT INTO `mmwl_gpb_area` VALUES ('1379', '370400', '枣庄市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1380', '370481', '滕州市', 'area', '370400');
INSERT INTO `mmwl_gpb_area` VALUES ('1381', '370402', '市中区', 'area', '370400');
INSERT INTO `mmwl_gpb_area` VALUES ('1382', '370406', '山亭区', 'area', '370400');
INSERT INTO `mmwl_gpb_area` VALUES ('1383', '370403', '薛城区', 'area', '370400');
INSERT INTO `mmwl_gpb_area` VALUES ('1384', '370404', '峄城区', 'area', '370400');
INSERT INTO `mmwl_gpb_area` VALUES ('1385', '370405', '台儿庄区', 'area', '370400');
INSERT INTO `mmwl_gpb_area` VALUES ('1386', '370500', '东营市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1387', '370502', '东营区', 'area', '370500');
INSERT INTO `mmwl_gpb_area` VALUES ('1388', '370523', '广饶县', 'area', '370500');
INSERT INTO `mmwl_gpb_area` VALUES ('1389', '370522', '利津县', 'area', '370500');
INSERT INTO `mmwl_gpb_area` VALUES ('1390', '370505', '垦利区', 'area', '370500');
INSERT INTO `mmwl_gpb_area` VALUES ('1391', '370503', '河口区', 'area', '370500');
INSERT INTO `mmwl_gpb_area` VALUES ('1392', '370600', '烟台市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1393', '370682', '莱阳市', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1394', '370683', '莱州市', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1395', '370686', '栖霞市', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1396', '370685', '招远市', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1397', '370687', '海阳市', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1398', '370612', '牟平区', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1399', '370681', '龙口市', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1400', '370684', '蓬莱市', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1401', '370602', '芝罘区', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1402', '370611', '福山区', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1403', '370613', '莱山区', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1404', '370634', '长岛县', 'area', '370600');
INSERT INTO `mmwl_gpb_area` VALUES ('1405', '370700', '潍坊市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1406', '370783', '寿光市', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1407', '370782', '诸城市', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1408', '370781', '青州市', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1409', '370784', '安丘市', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1410', '370724', '临朐县', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1411', '370785', '高密市', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1412', '370705', '奎文区', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1413', '370786', '昌邑市', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1414', '370725', '昌乐县', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1415', '370703', '寒亭区', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1416', '370704', '坊子区', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1417', '370702', '潍城区', 'area', '370700');
INSERT INTO `mmwl_gpb_area` VALUES ('1418', '370800', '济宁市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1419', '370811', '任城区', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1420', '370883', '邹城市', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1421', '370829', '嘉祥县', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1422', '370826', '微山县', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1423', '370830', '汶上县', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1424', '370832', '梁山县', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1425', '370828', '金乡县', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1426', '370831', '泗水县', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1427', '370881', '曲阜市', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1428', '370812', '兖州区', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1429', '370827', '鱼台县', 'area', '370800');
INSERT INTO `mmwl_gpb_area` VALUES ('1430', '370900', '泰安市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1431', '370982', '新泰市', 'area', '370900');
INSERT INTO `mmwl_gpb_area` VALUES ('1432', '370911', '岱岳区', 'area', '370900');
INSERT INTO `mmwl_gpb_area` VALUES ('1433', '370923', '东平县', 'area', '370900');
INSERT INTO `mmwl_gpb_area` VALUES ('1434', '370983', '肥城市', 'area', '370900');
INSERT INTO `mmwl_gpb_area` VALUES ('1435', '370921', '宁阳县', 'area', '370900');
INSERT INTO `mmwl_gpb_area` VALUES ('1436', '370902', '泰山区', 'area', '370900');
INSERT INTO `mmwl_gpb_area` VALUES ('1437', '371000', '威海市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1438', '371082', '荣成市', 'area', '371000');
INSERT INTO `mmwl_gpb_area` VALUES ('1439', '371002', '环翠区', 'area', '371000');
INSERT INTO `mmwl_gpb_area` VALUES ('1440', '371003', '文登区', 'area', '371000');
INSERT INTO `mmwl_gpb_area` VALUES ('1441', '371083', '乳山市', 'area', '371000');
INSERT INTO `mmwl_gpb_area` VALUES ('1442', '371100', '日照市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1443', '371122', '莒县', 'area', '371100');
INSERT INTO `mmwl_gpb_area` VALUES ('1444', '371102', '东港区', 'area', '371100');
INSERT INTO `mmwl_gpb_area` VALUES ('1445', '371121', '五莲县', 'area', '371100');
INSERT INTO `mmwl_gpb_area` VALUES ('1446', '371103', '岚山区', 'area', '371100');
INSERT INTO `mmwl_gpb_area` VALUES ('1447', '371200', '莱芜市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1448', '371202', '莱城区', 'area', '371200');
INSERT INTO `mmwl_gpb_area` VALUES ('1449', '371203', '钢城区', 'area', '371200');
INSERT INTO `mmwl_gpb_area` VALUES ('1450', '371300', '临沂市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1451', '371323', '沂水县', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1452', '371324', '兰陵县', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1453', '371327', '莒南县', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1454', '371321', '沂南县', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1455', '371326', '平邑县', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1456', '371322', '郯城县', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1457', '371325', '费县', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1458', '371302', '兰山区', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1459', '371312', '河东区', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1460', '371328', '蒙阴县', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1461', '371329', '临沭县', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1462', '371311', '罗庄区', 'area', '371300');
INSERT INTO `mmwl_gpb_area` VALUES ('1463', '371400', '德州市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1464', '371481', '乐陵市', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1465', '371425', '齐河县', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1466', '371427', '夏津县', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1467', '371403', '陵城区', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1468', '371426', '平原县', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1469', '371422', '宁津县', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1470', '371424', '临邑县', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1471', '371402', '德城区', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1472', '371482', '禹城市', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1473', '371423', '庆云县', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1474', '371428', '武城县', 'area', '371400');
INSERT INTO `mmwl_gpb_area` VALUES ('1475', '371500', '聊城市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1476', '371522', '莘县', 'area', '371500');
INSERT INTO `mmwl_gpb_area` VALUES ('1477', '371502', '东昌府区', 'area', '371500');
INSERT INTO `mmwl_gpb_area` VALUES ('1478', '371525', '冠县', 'area', '371500');
INSERT INTO `mmwl_gpb_area` VALUES ('1479', '371521', '阳谷县', 'area', '371500');
INSERT INTO `mmwl_gpb_area` VALUES ('1480', '371581', '临清市', 'area', '371500');
INSERT INTO `mmwl_gpb_area` VALUES ('1481', '371523', '茌平县', 'area', '371500');
INSERT INTO `mmwl_gpb_area` VALUES ('1482', '371526', '高唐县', 'area', '371500');
INSERT INTO `mmwl_gpb_area` VALUES ('1483', '371524', '东阿县', 'area', '371500');
INSERT INTO `mmwl_gpb_area` VALUES ('1484', '371600', '滨州市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1485', '371626', '邹平县', 'area', '371600');
INSERT INTO `mmwl_gpb_area` VALUES ('1486', '371621', '惠民县', 'area', '371600');
INSERT INTO `mmwl_gpb_area` VALUES ('1487', '371602', '滨城区', 'area', '371600');
INSERT INTO `mmwl_gpb_area` VALUES ('1488', '371623', '无棣县', 'area', '371600');
INSERT INTO `mmwl_gpb_area` VALUES ('1489', '371625', '博兴县', 'area', '371600');
INSERT INTO `mmwl_gpb_area` VALUES ('1490', '371603', '沾化区', 'area', '371600');
INSERT INTO `mmwl_gpb_area` VALUES ('1491', '371622', '阳信县', 'area', '371600');
INSERT INTO `mmwl_gpb_area` VALUES ('1492', '371700', '菏泽市', 'city', '370000');
INSERT INTO `mmwl_gpb_area` VALUES ('1493', '371721', '曹县', 'area', '371700');
INSERT INTO `mmwl_gpb_area` VALUES ('1494', '371702', '牡丹区', 'area', '371700');
INSERT INTO `mmwl_gpb_area` VALUES ('1495', '371722', '单县', 'area', '371700');
INSERT INTO `mmwl_gpb_area` VALUES ('1496', '371725', '郓城县', 'area', '371700');
INSERT INTO `mmwl_gpb_area` VALUES ('1497', '371726', '鄄城县', 'area', '371700');
INSERT INTO `mmwl_gpb_area` VALUES ('1498', '371724', '巨野县', 'area', '371700');
INSERT INTO `mmwl_gpb_area` VALUES ('1499', '371728', '东明县', 'area', '371700');
INSERT INTO `mmwl_gpb_area` VALUES ('1500', '371723', '成武县', 'area', '371700');
INSERT INTO `mmwl_gpb_area` VALUES ('1501', '371703', '定陶区', 'area', '371700');
INSERT INTO `mmwl_gpb_area` VALUES ('1502', '410000', '河南省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('1503', '410100', '郑州市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1504', '410181', '巩义市', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1505', '410183', '新密市', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1506', '410122', '中牟县', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1507', '410105', '金水区', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1508', '410184', '新郑市', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1509', '410185', '登封市', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1510', '410103', '二七区', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1511', '410104', '管城回族区', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1512', '410182', '荥阳市', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1513', '410102', '中原区', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1514', '410108', '惠济区', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1515', '410106', '上街区', 'area', '410100');
INSERT INTO `mmwl_gpb_area` VALUES ('1516', '410200', '开封市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1517', '410221', '杞县', 'area', '410200');
INSERT INTO `mmwl_gpb_area` VALUES ('1518', '410223', '尉氏县', 'area', '410200');
INSERT INTO `mmwl_gpb_area` VALUES ('1519', '410225', '兰考县', 'area', '410200');
INSERT INTO `mmwl_gpb_area` VALUES ('1520', '410212', '祥符区', 'area', '410200');
INSERT INTO `mmwl_gpb_area` VALUES ('1521', '410202', '龙亭区', 'area', '410200');
INSERT INTO `mmwl_gpb_area` VALUES ('1522', '410222', '通许县', 'area', '410200');
INSERT INTO `mmwl_gpb_area` VALUES ('1523', '410203', '顺河回族区', 'area', '410200');
INSERT INTO `mmwl_gpb_area` VALUES ('1524', '410204', '鼓楼区', 'area', '410200');
INSERT INTO `mmwl_gpb_area` VALUES ('1525', '410205', '禹王台区', 'area', '410200');
INSERT INTO `mmwl_gpb_area` VALUES ('1526', '410300', '洛阳市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1527', '410328', '洛宁县', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1528', '410327', '宜阳县', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1529', '410325', '嵩县', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1530', '410381', '偃师市', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1531', '410311', '洛龙区', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1532', '410326', '汝阳县', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1533', '410329', '伊川县', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1534', '410324', '栾川县', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1535', '410323', '新安县', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1536', '410322', '孟津县', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1537', '410303', '西工区', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1538', '410302', '老城区', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1539', '410305', '涧西区', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1540', '410304', '瀍河回族区', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1541', '410306', '吉利区', 'area', '410300');
INSERT INTO `mmwl_gpb_area` VALUES ('1542', '410400', '平顶山市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1543', '410423', '鲁山县', 'area', '410400');
INSERT INTO `mmwl_gpb_area` VALUES ('1544', '410482', '汝州市', 'area', '410400');
INSERT INTO `mmwl_gpb_area` VALUES ('1545', '410422', '叶县', 'area', '410400');
INSERT INTO `mmwl_gpb_area` VALUES ('1546', '410425', '郏县', 'area', '410400');
INSERT INTO `mmwl_gpb_area` VALUES ('1547', '410402', '新华区', 'area', '410400');
INSERT INTO `mmwl_gpb_area` VALUES ('1548', '410421', '宝丰县', 'area', '410400');
INSERT INTO `mmwl_gpb_area` VALUES ('1549', '410481', '舞钢市', 'area', '410400');
INSERT INTO `mmwl_gpb_area` VALUES ('1550', '410403', '卫东区', 'area', '410400');
INSERT INTO `mmwl_gpb_area` VALUES ('1551', '410411', '湛河区', 'area', '410400');
INSERT INTO `mmwl_gpb_area` VALUES ('1552', '410404', '石龙区', 'area', '410400');
INSERT INTO `mmwl_gpb_area` VALUES ('1553', '410500', '安阳市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1554', '410526', '滑县', 'area', '410500');
INSERT INTO `mmwl_gpb_area` VALUES ('1555', '410522', '安阳县', 'area', '410500');
INSERT INTO `mmwl_gpb_area` VALUES ('1556', '410581', '林州市', 'area', '410500');
INSERT INTO `mmwl_gpb_area` VALUES ('1557', '410527', '内黄县', 'area', '410500');
INSERT INTO `mmwl_gpb_area` VALUES ('1558', '410502', '文峰区', 'area', '410500');
INSERT INTO `mmwl_gpb_area` VALUES ('1559', '410523', '汤阴县', 'area', '410500');
INSERT INTO `mmwl_gpb_area` VALUES ('1560', '410505', '殷都区', 'area', '410500');
INSERT INTO `mmwl_gpb_area` VALUES ('1561', '410506', '龙安区', 'area', '410500');
INSERT INTO `mmwl_gpb_area` VALUES ('1562', '410503', '北关区', 'area', '410500');
INSERT INTO `mmwl_gpb_area` VALUES ('1563', '410600', '鹤壁市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1564', '410611', '淇滨区', 'area', '410600');
INSERT INTO `mmwl_gpb_area` VALUES ('1565', '410621', '浚县', 'area', '410600');
INSERT INTO `mmwl_gpb_area` VALUES ('1566', '410622', '淇县', 'area', '410600');
INSERT INTO `mmwl_gpb_area` VALUES ('1567', '410602', '鹤山区', 'area', '410600');
INSERT INTO `mmwl_gpb_area` VALUES ('1568', '410603', '山城区', 'area', '410600');
INSERT INTO `mmwl_gpb_area` VALUES ('1569', '410700', '新乡市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1570', '410782', '辉县市', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1571', '410727', '封丘县', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1572', '410725', '原阳县', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1573', '410728', '长垣县', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1574', '410724', '获嘉县', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1575', '410781', '卫辉市', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1576', '410726', '延津县', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1577', '410702', '红旗区', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1578', '410711', '牧野区', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1579', '410721', '新乡县', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1580', '410703', '卫滨区', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1581', '410704', '凤泉区', 'area', '410700');
INSERT INTO `mmwl_gpb_area` VALUES ('1582', '410800', '焦作市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1583', '410811', '山阳区', 'area', '410800');
INSERT INTO `mmwl_gpb_area` VALUES ('1584', '410823', '武陟县', 'area', '410800');
INSERT INTO `mmwl_gpb_area` VALUES ('1585', '410882', '沁阳市', 'area', '410800');
INSERT INTO `mmwl_gpb_area` VALUES ('1586', '410883', '孟州市', 'area', '410800');
INSERT INTO `mmwl_gpb_area` VALUES ('1587', '410825', '温县', 'area', '410800');
INSERT INTO `mmwl_gpb_area` VALUES ('1588', '410803', '中站区', 'area', '410800');
INSERT INTO `mmwl_gpb_area` VALUES ('1589', '410821', '修武县', 'area', '410800');
INSERT INTO `mmwl_gpb_area` VALUES ('1590', '410802', '解放区', 'area', '410800');
INSERT INTO `mmwl_gpb_area` VALUES ('1591', '410822', '博爱县', 'area', '410800');
INSERT INTO `mmwl_gpb_area` VALUES ('1592', '410804', '马村区', 'area', '410800');
INSERT INTO `mmwl_gpb_area` VALUES ('1593', '410900', '濮阳市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1594', '410928', '濮阳县', 'area', '410900');
INSERT INTO `mmwl_gpb_area` VALUES ('1595', '410922', '清丰县', 'area', '410900');
INSERT INTO `mmwl_gpb_area` VALUES ('1596', '410902', '华龙区', 'area', '410900');
INSERT INTO `mmwl_gpb_area` VALUES ('1597', '410923', '南乐县', 'area', '410900');
INSERT INTO `mmwl_gpb_area` VALUES ('1598', '410926', '范县', 'area', '410900');
INSERT INTO `mmwl_gpb_area` VALUES ('1599', '410927', '台前县', 'area', '410900');
INSERT INTO `mmwl_gpb_area` VALUES ('1600', '411000', '许昌市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1601', '411081', '禹州市', 'area', '411000');
INSERT INTO `mmwl_gpb_area` VALUES ('1602', '411025', '襄城县', 'area', '411000');
INSERT INTO `mmwl_gpb_area` VALUES ('1603', '411082', '长葛市', 'area', '411000');
INSERT INTO `mmwl_gpb_area` VALUES ('1604', '411003', '建安区', 'area', '411000');
INSERT INTO `mmwl_gpb_area` VALUES ('1605', '411002', '魏都区', 'area', '411000');
INSERT INTO `mmwl_gpb_area` VALUES ('1606', '411024', '鄢陵县', 'area', '411000');
INSERT INTO `mmwl_gpb_area` VALUES ('1607', '411100', '漯河市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1608', '411122', '临颍县', 'area', '411100');
INSERT INTO `mmwl_gpb_area` VALUES ('1609', '411121', '舞阳县', 'area', '411100');
INSERT INTO `mmwl_gpb_area` VALUES ('1610', '411103', '郾城区', 'area', '411100');
INSERT INTO `mmwl_gpb_area` VALUES ('1611', '411104', '召陵区', 'area', '411100');
INSERT INTO `mmwl_gpb_area` VALUES ('1612', '411102', '源汇区', 'area', '411100');
INSERT INTO `mmwl_gpb_area` VALUES ('1613', '411200', '三门峡市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1614', '411224', '卢氏县', 'area', '411200');
INSERT INTO `mmwl_gpb_area` VALUES ('1615', '411282', '灵宝市', 'area', '411200');
INSERT INTO `mmwl_gpb_area` VALUES ('1616', '411203', '陕州区', 'area', '411200');
INSERT INTO `mmwl_gpb_area` VALUES ('1617', '411221', '渑池县', 'area', '411200');
INSERT INTO `mmwl_gpb_area` VALUES ('1618', '411202', '湖滨区', 'area', '411200');
INSERT INTO `mmwl_gpb_area` VALUES ('1619', '411281', '义马市', 'area', '411200');
INSERT INTO `mmwl_gpb_area` VALUES ('1620', '411300', '南阳市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1621', '411381', '邓州市', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1622', '411324', '镇平县', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1623', '411303', '卧龙区', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1624', '411328', '唐河县', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1625', '411323', '西峡县', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1626', '411326', '淅川县', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1627', '411325', '内乡县', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1628', '411321', '南召县', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1629', '411322', '方城县', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1630', '411330', '桐柏县', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1631', '411302', '宛城区', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1632', '411327', '社旗县', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1633', '411329', '新野县', 'area', '411300');
INSERT INTO `mmwl_gpb_area` VALUES ('1634', '411400', '商丘市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1635', '411481', '永城市', 'area', '411400');
INSERT INTO `mmwl_gpb_area` VALUES ('1636', '411425', '虞城县', 'area', '411400');
INSERT INTO `mmwl_gpb_area` VALUES ('1637', '411426', '夏邑县', 'area', '411400');
INSERT INTO `mmwl_gpb_area` VALUES ('1638', '411424', '柘城县', 'area', '411400');
INSERT INTO `mmwl_gpb_area` VALUES ('1639', '411422', '睢县', 'area', '411400');
INSERT INTO `mmwl_gpb_area` VALUES ('1640', '411402', '梁园区', 'area', '411400');
INSERT INTO `mmwl_gpb_area` VALUES ('1641', '411421', '民权县', 'area', '411400');
INSERT INTO `mmwl_gpb_area` VALUES ('1642', '411403', '睢阳区', 'area', '411400');
INSERT INTO `mmwl_gpb_area` VALUES ('1643', '411423', '宁陵县', 'area', '411400');
INSERT INTO `mmwl_gpb_area` VALUES ('1644', '411500', '信阳市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1645', '411525', '固始县', 'area', '411500');
INSERT INTO `mmwl_gpb_area` VALUES ('1646', '411503', '平桥区', 'area', '411500');
INSERT INTO `mmwl_gpb_area` VALUES ('1647', '411526', '潢川县', 'area', '411500');
INSERT INTO `mmwl_gpb_area` VALUES ('1648', '411528', '息县', 'area', '411500');
INSERT INTO `mmwl_gpb_area` VALUES ('1649', '411524', '商城县', 'area', '411500');
INSERT INTO `mmwl_gpb_area` VALUES ('1650', '411522', '光山县', 'area', '411500');
INSERT INTO `mmwl_gpb_area` VALUES ('1651', '411521', '罗山县', 'area', '411500');
INSERT INTO `mmwl_gpb_area` VALUES ('1652', '411502', '浉河区', 'area', '411500');
INSERT INTO `mmwl_gpb_area` VALUES ('1653', '411527', '淮滨县', 'area', '411500');
INSERT INTO `mmwl_gpb_area` VALUES ('1654', '411523', '新县', 'area', '411500');
INSERT INTO `mmwl_gpb_area` VALUES ('1655', '411600', '周口市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1656', '411623', '商水县', 'area', '411600');
INSERT INTO `mmwl_gpb_area` VALUES ('1657', '411628', '鹿邑县', 'area', '411600');
INSERT INTO `mmwl_gpb_area` VALUES ('1658', '411627', '太康县', 'area', '411600');
INSERT INTO `mmwl_gpb_area` VALUES ('1659', '411625', '郸城县', 'area', '411600');
INSERT INTO `mmwl_gpb_area` VALUES ('1660', '411622', '西华县', 'area', '411600');
INSERT INTO `mmwl_gpb_area` VALUES ('1661', '411624', '沈丘县', 'area', '411600');
INSERT INTO `mmwl_gpb_area` VALUES ('1662', '411681', '项城市', 'area', '411600');
INSERT INTO `mmwl_gpb_area` VALUES ('1663', '411626', '淮阳县', 'area', '411600');
INSERT INTO `mmwl_gpb_area` VALUES ('1664', '411621', '扶沟县', 'area', '411600');
INSERT INTO `mmwl_gpb_area` VALUES ('1665', '411602', '川汇区', 'area', '411600');
INSERT INTO `mmwl_gpb_area` VALUES ('1666', '411700', '驻马店市', 'city', '410000');
INSERT INTO `mmwl_gpb_area` VALUES ('1667', '411722', '上蔡县', 'area', '411700');
INSERT INTO `mmwl_gpb_area` VALUES ('1668', '411702', '驿城区', 'area', '411700');
INSERT INTO `mmwl_gpb_area` VALUES ('1669', '411729', '新蔡县', 'area', '411700');
INSERT INTO `mmwl_gpb_area` VALUES ('1670', '411721', '西平县', 'area', '411700');
INSERT INTO `mmwl_gpb_area` VALUES ('1671', '411726', '泌阳县', 'area', '411700');
INSERT INTO `mmwl_gpb_area` VALUES ('1672', '411724', '正阳县', 'area', '411700');
INSERT INTO `mmwl_gpb_area` VALUES ('1673', '411723', '平舆县', 'area', '411700');
INSERT INTO `mmwl_gpb_area` VALUES ('1674', '411728', '遂平县', 'area', '411700');
INSERT INTO `mmwl_gpb_area` VALUES ('1675', '411727', '汝南县', 'area', '411700');
INSERT INTO `mmwl_gpb_area` VALUES ('1676', '411725', '确山县', 'area', '411700');
INSERT INTO `mmwl_gpb_area` VALUES ('1677', '419001', '济源市', 'area', '419000');
INSERT INTO `mmwl_gpb_area` VALUES ('1678', '420000', '湖北省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('1679', '420100', '武汉市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1680', '420115', '江夏区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1681', '420116', '黄陂区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1682', '420102', '江岸区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1683', '420106', '武昌区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1684', '420111', '洪山区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1685', '420103', '江汉区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1686', '420114', '蔡甸区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1687', '420117', '新洲区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1688', '420105', '汉阳区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1689', '420107', '青山区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1690', '420112', '东西湖区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1691', '420104', '硚口区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1692', '420113', '汉南区', 'area', '420100');
INSERT INTO `mmwl_gpb_area` VALUES ('1693', '420200', '黄石市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1694', '420222', '阳新县', 'area', '420200');
INSERT INTO `mmwl_gpb_area` VALUES ('1695', '420281', '大冶市', 'area', '420200');
INSERT INTO `mmwl_gpb_area` VALUES ('1696', '420204', '下陆区', 'area', '420200');
INSERT INTO `mmwl_gpb_area` VALUES ('1697', '420202', '黄石港区', 'area', '420200');
INSERT INTO `mmwl_gpb_area` VALUES ('1698', '420203', '西塞山区', 'area', '420200');
INSERT INTO `mmwl_gpb_area` VALUES ('1699', '420205', '铁山区', 'area', '420200');
INSERT INTO `mmwl_gpb_area` VALUES ('1700', '420300', '十堰市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1701', '420325', '房县', 'area', '420300');
INSERT INTO `mmwl_gpb_area` VALUES ('1702', '420381', '丹江口市', 'area', '420300');
INSERT INTO `mmwl_gpb_area` VALUES ('1703', '420304', '郧阳区', 'area', '420300');
INSERT INTO `mmwl_gpb_area` VALUES ('1704', '420323', '竹山县', 'area', '420300');
INSERT INTO `mmwl_gpb_area` VALUES ('1705', '420322', '郧西县', 'area', '420300');
INSERT INTO `mmwl_gpb_area` VALUES ('1706', '420324', '竹溪县', 'area', '420300');
INSERT INTO `mmwl_gpb_area` VALUES ('1707', '420303', '张湾区', 'area', '420300');
INSERT INTO `mmwl_gpb_area` VALUES ('1708', '420302', '茅箭区', 'area', '420300');
INSERT INTO `mmwl_gpb_area` VALUES ('1709', '420500', '宜昌市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1710', '420506', '夷陵区', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1711', '420527', '秭归县', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1712', '420528', '长阳土家族自治县', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1713', '420582', '当阳市', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1714', '420581', '宜都市', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1715', '420502', '西陵区', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1716', '420583', '枝江市', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1717', '420529', '五峰土家族自治县', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1718', '420526', '兴山县', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1719', '420525', '远安县', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1720', '420504', '点军区', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1721', '420503', '伍家岗区', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1722', '420505', '猇亭区', 'area', '420500');
INSERT INTO `mmwl_gpb_area` VALUES ('1723', '420600', '襄阳市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1724', '420607', '襄州区', 'area', '420600');
INSERT INTO `mmwl_gpb_area` VALUES ('1725', '420683', '枣阳市', 'area', '420600');
INSERT INTO `mmwl_gpb_area` VALUES ('1726', '420606', '樊城区', 'area', '420600');
INSERT INTO `mmwl_gpb_area` VALUES ('1727', '420684', '宜城市', 'area', '420600');
INSERT INTO `mmwl_gpb_area` VALUES ('1728', '420625', '谷城县', 'area', '420600');
INSERT INTO `mmwl_gpb_area` VALUES ('1729', '420624', '南漳县', 'area', '420600');
INSERT INTO `mmwl_gpb_area` VALUES ('1730', '420626', '保康县', 'area', '420600');
INSERT INTO `mmwl_gpb_area` VALUES ('1731', '420682', '老河口市', 'area', '420600');
INSERT INTO `mmwl_gpb_area` VALUES ('1732', '420602', '襄城区', 'area', '420600');
INSERT INTO `mmwl_gpb_area` VALUES ('1733', '420700', '鄂州市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1734', '420704', '鄂城区', 'area', '420700');
INSERT INTO `mmwl_gpb_area` VALUES ('1735', '420703', '华容区', 'area', '420700');
INSERT INTO `mmwl_gpb_area` VALUES ('1736', '420702', '梁子湖区', 'area', '420700');
INSERT INTO `mmwl_gpb_area` VALUES ('1737', '420800', '荆门市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1738', '420821', '京山县', 'area', '420800');
INSERT INTO `mmwl_gpb_area` VALUES ('1739', '420881', '钟祥市', 'area', '420800');
INSERT INTO `mmwl_gpb_area` VALUES ('1740', '420822', '沙洋县', 'area', '420800');
INSERT INTO `mmwl_gpb_area` VALUES ('1741', '420802', '东宝区', 'area', '420800');
INSERT INTO `mmwl_gpb_area` VALUES ('1742', '420804', '掇刀区', 'area', '420800');
INSERT INTO `mmwl_gpb_area` VALUES ('1743', '420900', '孝感市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1744', '420984', '汉川市', 'area', '420900');
INSERT INTO `mmwl_gpb_area` VALUES ('1745', '420902', '孝南区', 'area', '420900');
INSERT INTO `mmwl_gpb_area` VALUES ('1746', '420922', '大悟县', 'area', '420900');
INSERT INTO `mmwl_gpb_area` VALUES ('1747', '420982', '安陆市', 'area', '420900');
INSERT INTO `mmwl_gpb_area` VALUES ('1748', '420981', '应城市', 'area', '420900');
INSERT INTO `mmwl_gpb_area` VALUES ('1749', '420921', '孝昌县', 'area', '420900');
INSERT INTO `mmwl_gpb_area` VALUES ('1750', '420923', '云梦县', 'area', '420900');
INSERT INTO `mmwl_gpb_area` VALUES ('1751', '421000', '荆州市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1752', '421023', '监利县', 'area', '421000');
INSERT INTO `mmwl_gpb_area` VALUES ('1753', '421083', '洪湖市', 'area', '421000');
INSERT INTO `mmwl_gpb_area` VALUES ('1754', '421087', '松滋市', 'area', '421000');
INSERT INTO `mmwl_gpb_area` VALUES ('1755', '421022', '公安县', 'area', '421000');
INSERT INTO `mmwl_gpb_area` VALUES ('1756', '421081', '石首市', 'area', '421000');
INSERT INTO `mmwl_gpb_area` VALUES ('1757', '421002', '沙市区', 'area', '421000');
INSERT INTO `mmwl_gpb_area` VALUES ('1758', '421003', '荆州区', 'area', '421000');
INSERT INTO `mmwl_gpb_area` VALUES ('1759', '421024', '江陵县', 'area', '421000');
INSERT INTO `mmwl_gpb_area` VALUES ('1760', '421100', '黄冈市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1761', '421181', '麻城市', 'area', '421100');
INSERT INTO `mmwl_gpb_area` VALUES ('1762', '421127', '黄梅县', 'area', '421100');
INSERT INTO `mmwl_gpb_area` VALUES ('1763', '421126', '蕲春县', 'area', '421100');
INSERT INTO `mmwl_gpb_area` VALUES ('1764', '421125', '浠水县', 'area', '421100');
INSERT INTO `mmwl_gpb_area` VALUES ('1765', '421122', '红安县', 'area', '421100');
INSERT INTO `mmwl_gpb_area` VALUES ('1766', '421124', '英山县', 'area', '421100');
INSERT INTO `mmwl_gpb_area` VALUES ('1767', '421123', '罗田县', 'area', '421100');
INSERT INTO `mmwl_gpb_area` VALUES ('1768', '421182', '武穴市', 'area', '421100');
INSERT INTO `mmwl_gpb_area` VALUES ('1769', '421121', '团风县', 'area', '421100');
INSERT INTO `mmwl_gpb_area` VALUES ('1770', '421102', '黄州区', 'area', '421100');
INSERT INTO `mmwl_gpb_area` VALUES ('1771', '421200', '咸宁市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1772', '421281', '赤壁市', 'area', '421200');
INSERT INTO `mmwl_gpb_area` VALUES ('1773', '421202', '咸安区', 'area', '421200');
INSERT INTO `mmwl_gpb_area` VALUES ('1774', '421224', '通山县', 'area', '421200');
INSERT INTO `mmwl_gpb_area` VALUES ('1775', '421222', '通城县', 'area', '421200');
INSERT INTO `mmwl_gpb_area` VALUES ('1776', '421223', '崇阳县', 'area', '421200');
INSERT INTO `mmwl_gpb_area` VALUES ('1777', '421221', '嘉鱼县', 'area', '421200');
INSERT INTO `mmwl_gpb_area` VALUES ('1778', '421300', '随州市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1779', '421321', '随县', 'area', '421300');
INSERT INTO `mmwl_gpb_area` VALUES ('1780', '421381', '广水市', 'area', '421300');
INSERT INTO `mmwl_gpb_area` VALUES ('1781', '421303', '曾都区', 'area', '421300');
INSERT INTO `mmwl_gpb_area` VALUES ('1782', '422800', '恩施土家族苗族自治州', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1783', '422801', '恩施市', 'area', '422800');
INSERT INTO `mmwl_gpb_area` VALUES ('1784', '422802', '利川市', 'area', '422800');
INSERT INTO `mmwl_gpb_area` VALUES ('1785', '422823', '巴东县', 'area', '422800');
INSERT INTO `mmwl_gpb_area` VALUES ('1786', '422826', '咸丰县', 'area', '422800');
INSERT INTO `mmwl_gpb_area` VALUES ('1787', '422828', '鹤峰县', 'area', '422800');
INSERT INTO `mmwl_gpb_area` VALUES ('1788', '422822', '建始县', 'area', '422800');
INSERT INTO `mmwl_gpb_area` VALUES ('1789', '422825', '宣恩县', 'area', '422800');
INSERT INTO `mmwl_gpb_area` VALUES ('1790', '422827', '来凤县', 'area', '422800');
INSERT INTO `mmwl_gpb_area` VALUES ('1791', '429005', '潜江市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1792', '429004', '仙桃市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1793', '429005', '潜江市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1794', '429006', '天门市', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1795', '429021', '神农架林区', 'city', '420000');
INSERT INTO `mmwl_gpb_area` VALUES ('1796', '430000', '湖南省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('1797', '430100', '长沙市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1798', '430181', '浏阳市', 'area', '430100');
INSERT INTO `mmwl_gpb_area` VALUES ('1799', '430182', '宁乡市', 'area', '430100');
INSERT INTO `mmwl_gpb_area` VALUES ('1800', '430121', '长沙县', 'area', '430100');
INSERT INTO `mmwl_gpb_area` VALUES ('1801', '430104', '岳麓区', 'area', '430100');
INSERT INTO `mmwl_gpb_area` VALUES ('1802', '430112', '望城区', 'area', '430100');
INSERT INTO `mmwl_gpb_area` VALUES ('1803', '430105', '开福区', 'area', '430100');
INSERT INTO `mmwl_gpb_area` VALUES ('1804', '430102', '芙蓉区', 'area', '430100');
INSERT INTO `mmwl_gpb_area` VALUES ('1805', '430111', '雨花区', 'area', '430100');
INSERT INTO `mmwl_gpb_area` VALUES ('1806', '430103', '天心区', 'area', '430100');
INSERT INTO `mmwl_gpb_area` VALUES ('1807', '430200', '株洲市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1808', '430281', '醴陵市', 'area', '430200');
INSERT INTO `mmwl_gpb_area` VALUES ('1809', '430223', '攸县', 'area', '430200');
INSERT INTO `mmwl_gpb_area` VALUES ('1810', '430224', '茶陵县', 'area', '430200');
INSERT INTO `mmwl_gpb_area` VALUES ('1811', '430225', '炎陵县', 'area', '430200');
INSERT INTO `mmwl_gpb_area` VALUES ('1812', '430221', '株洲县', 'area', '430200');
INSERT INTO `mmwl_gpb_area` VALUES ('1813', '430203', '芦淞区', 'area', '430200');
INSERT INTO `mmwl_gpb_area` VALUES ('1814', '430204', '石峰区', 'area', '430200');
INSERT INTO `mmwl_gpb_area` VALUES ('1815', '430202', '荷塘区', 'area', '430200');
INSERT INTO `mmwl_gpb_area` VALUES ('1816', '430211', '天元区', 'area', '430200');
INSERT INTO `mmwl_gpb_area` VALUES ('1817', '430300', '湘潭市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1818', '430381', '湘乡市', 'area', '430300');
INSERT INTO `mmwl_gpb_area` VALUES ('1819', '430321', '湘潭县', 'area', '430300');
INSERT INTO `mmwl_gpb_area` VALUES ('1820', '430302', '雨湖区', 'area', '430300');
INSERT INTO `mmwl_gpb_area` VALUES ('1821', '430304', '岳塘区', 'area', '430300');
INSERT INTO `mmwl_gpb_area` VALUES ('1822', '430382', '韶山市', 'area', '430300');
INSERT INTO `mmwl_gpb_area` VALUES ('1823', '430400', '衡阳市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1824', '430481', '耒阳市', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1825', '430421', '衡阳县', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1826', '430422', '衡南县', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1827', '430426', '祁东县', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1828', '430482', '常宁市', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1829', '430424', '衡东县', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1830', '430423', '衡山县', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1831', '430405', '珠晖区', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1832', '430407', '石鼓区', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1833', '430406', '雁峰区', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1834', '430408', '蒸湘区', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1835', '430412', '南岳区', 'area', '430400');
INSERT INTO `mmwl_gpb_area` VALUES ('1836', '430500', '邵阳市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1837', '430521', '邵东县', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1838', '430524', '隆回县', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1839', '430523', '邵阳县', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1840', '430525', '洞口县', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1841', '430527', '绥宁县', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1842', '430581', '武冈市', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1843', '430528', '新宁县', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1844', '430522', '新邵县', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1845', '430503', '大祥区', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1846', '430502', '双清区', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1847', '430529', '城步苗族自治县', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1848', '430511', '北塔区', 'area', '430500');
INSERT INTO `mmwl_gpb_area` VALUES ('1849', '430600', '岳阳市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1850', '430626', '平江县', 'area', '430600');
INSERT INTO `mmwl_gpb_area` VALUES ('1851', '430681', '汨罗市', 'area', '430600');
INSERT INTO `mmwl_gpb_area` VALUES ('1852', '430602', '岳阳楼区', 'area', '430600');
INSERT INTO `mmwl_gpb_area` VALUES ('1853', '430621', '岳阳县', 'area', '430600');
INSERT INTO `mmwl_gpb_area` VALUES ('1854', '430624', '湘阴县', 'area', '430600');
INSERT INTO `mmwl_gpb_area` VALUES ('1855', '430623', '华容县', 'area', '430600');
INSERT INTO `mmwl_gpb_area` VALUES ('1856', '430682', '临湘市', 'area', '430600');
INSERT INTO `mmwl_gpb_area` VALUES ('1857', '430611', '君山区', 'area', '430600');
INSERT INTO `mmwl_gpb_area` VALUES ('1858', '430603', '云溪区', 'area', '430600');
INSERT INTO `mmwl_gpb_area` VALUES ('1859', '430700', '常德市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1860', '430725', '桃源县', 'area', '430700');
INSERT INTO `mmwl_gpb_area` VALUES ('1861', '430723', '澧县', 'area', '430700');
INSERT INTO `mmwl_gpb_area` VALUES ('1862', '430703', '鼎城区', 'area', '430700');
INSERT INTO `mmwl_gpb_area` VALUES ('1863', '430722', '汉寿县', 'area', '430700');
INSERT INTO `mmwl_gpb_area` VALUES ('1864', '430726', '石门县', 'area', '430700');
INSERT INTO `mmwl_gpb_area` VALUES ('1865', '430702', '武陵区', 'area', '430700');
INSERT INTO `mmwl_gpb_area` VALUES ('1866', '430721', '安乡县', 'area', '430700');
INSERT INTO `mmwl_gpb_area` VALUES ('1867', '430724', '临澧县', 'area', '430700');
INSERT INTO `mmwl_gpb_area` VALUES ('1868', '430781', '津市市', 'area', '430700');
INSERT INTO `mmwl_gpb_area` VALUES ('1869', '430800', '张家界市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1870', '430822', '桑植县', 'area', '430800');
INSERT INTO `mmwl_gpb_area` VALUES ('1871', '430821', '慈利县', 'area', '430800');
INSERT INTO `mmwl_gpb_area` VALUES ('1872', '430802', '永定区', 'area', '430800');
INSERT INTO `mmwl_gpb_area` VALUES ('1873', '430811', '武陵源区', 'area', '430800');
INSERT INTO `mmwl_gpb_area` VALUES ('1874', '430900', '益阳市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1875', '430923', '安化县', 'area', '430900');
INSERT INTO `mmwl_gpb_area` VALUES ('1876', '430981', '沅江市', 'area', '430900');
INSERT INTO `mmwl_gpb_area` VALUES ('1877', '430903', '赫山区', 'area', '430900');
INSERT INTO `mmwl_gpb_area` VALUES ('1878', '430922', '桃江县', 'area', '430900');
INSERT INTO `mmwl_gpb_area` VALUES ('1879', '430921', '南县', 'area', '430900');
INSERT INTO `mmwl_gpb_area` VALUES ('1880', '430902', '资阳区', 'area', '430900');
INSERT INTO `mmwl_gpb_area` VALUES ('1881', '431000', '郴州市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1882', '431021', '桂阳县', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1883', '431022', '宜章县', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1884', '431002', '北湖区', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1885', '431023', '永兴县', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1886', '431003', '苏仙区', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1887', '431026', '汝城县', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1888', '431028', '安仁县', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1889', '431025', '临武县', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1890', '431081', '资兴市', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1891', '431024', '嘉禾县', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1892', '431027', '桂东县', 'area', '431000');
INSERT INTO `mmwl_gpb_area` VALUES ('1893', '431100', '永州市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1894', '431121', '祁阳县', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1895', '431124', '道县', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1896', '431103', '冷水滩区', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1897', '431126', '宁远县', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1898', '431129', '江华瑶族自治县', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1899', '431123', '双牌县', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1900', '431122', '东安县', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1901', '431127', '蓝山县', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1902', '431102', '零陵区', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1903', '431125', '江永县', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1904', '431128', '新田县', 'area', '431100');
INSERT INTO `mmwl_gpb_area` VALUES ('1905', '431200', '怀化市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1906', '431224', '溆浦县', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1907', '431281', '洪江市', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1908', '431223', '辰溪县', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1909', '431222', '沅陵县', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1910', '431226', '麻阳苗族自治县', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1911', '431225', '会同县', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1912', '431228', '芷江侗族自治县', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1913', '431221', '中方县', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1914', '431230', '通道侗族自治县', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1915', '431229', '靖州苗族侗族自治县', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1916', '431227', '新晃侗族自治县', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1917', '431202', '鹤城区', 'area', '431200');
INSERT INTO `mmwl_gpb_area` VALUES ('1918', '431300', '娄底市', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1919', '431322', '新化县', 'area', '431300');
INSERT INTO `mmwl_gpb_area` VALUES ('1920', '431382', '涟源市', 'area', '431300');
INSERT INTO `mmwl_gpb_area` VALUES ('1921', '431321', '双峰县', 'area', '431300');
INSERT INTO `mmwl_gpb_area` VALUES ('1922', '431381', '冷水江市', 'area', '431300');
INSERT INTO `mmwl_gpb_area` VALUES ('1923', '431302', '娄星区', 'area', '431300');
INSERT INTO `mmwl_gpb_area` VALUES ('1924', '433100', '湘西土家族苗族自治州', 'city', '430000');
INSERT INTO `mmwl_gpb_area` VALUES ('1925', '433127', '永顺县', 'area', '433100');
INSERT INTO `mmwl_gpb_area` VALUES ('1926', '433130', '龙山县', 'area', '433100');
INSERT INTO `mmwl_gpb_area` VALUES ('1927', '433123', '凤凰县', 'area', '433100');
INSERT INTO `mmwl_gpb_area` VALUES ('1928', '433125', '保靖县', 'area', '433100');
INSERT INTO `mmwl_gpb_area` VALUES ('1929', '433122', '泸溪县', 'area', '433100');
INSERT INTO `mmwl_gpb_area` VALUES ('1930', '433124', '花垣县', 'area', '433100');
INSERT INTO `mmwl_gpb_area` VALUES ('1931', '433101', '吉首市', 'area', '433100');
INSERT INTO `mmwl_gpb_area` VALUES ('1932', '433126', '古丈县', 'area', '433100');
INSERT INTO `mmwl_gpb_area` VALUES ('1933', '440000', '广东省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('1934', '440100', '广州市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('1935', '440103', '荔湾区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1936', '440111', '白云区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1937', '440106', '天河区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1938', '440105', '海珠区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1939', '440104', '越秀区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1940', '440113', '番禺区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1941', '440112', '黄埔区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1942', '440118', '增城区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1943', '440114', '花都区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1944', '440115', '南沙区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1945', '440117', '从化区', 'area', '440100');
INSERT INTO `mmwl_gpb_area` VALUES ('1946', '440200', '韶关市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('1947', '440282', '南雄市', 'area', '440200');
INSERT INTO `mmwl_gpb_area` VALUES ('1948', '440281', '乐昌市', 'area', '440200');
INSERT INTO `mmwl_gpb_area` VALUES ('1949', '440224', '仁化县', 'area', '440200');
INSERT INTO `mmwl_gpb_area` VALUES ('1950', '440222', '始兴县', 'area', '440200');
INSERT INTO `mmwl_gpb_area` VALUES ('1951', '440204', '浈江区', 'area', '440200');
INSERT INTO `mmwl_gpb_area` VALUES ('1952', '440232', '乳源瑶族自治县', 'area', '440200');
INSERT INTO `mmwl_gpb_area` VALUES ('1953', '440205', '曲江区', 'area', '440200');
INSERT INTO `mmwl_gpb_area` VALUES ('1954', '440229', '翁源县', 'area', '440200');
INSERT INTO `mmwl_gpb_area` VALUES ('1955', '440203', '武江区', 'area', '440200');
INSERT INTO `mmwl_gpb_area` VALUES ('1956', '440233', '新丰县', 'area', '440200');
INSERT INTO `mmwl_gpb_area` VALUES ('1957', '440300', '深圳市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('1958', '440307', '龙岗区', 'area', '440300');
INSERT INTO `mmwl_gpb_area` VALUES ('1959', '440304', '福田区', 'area', '440300');
INSERT INTO `mmwl_gpb_area` VALUES ('1960', '440303', '罗湖区', 'area', '440300');
INSERT INTO `mmwl_gpb_area` VALUES ('1961', '440305', '南山区', 'area', '440300');
INSERT INTO `mmwl_gpb_area` VALUES ('1962', '440306', '宝安区', 'area', '440300');
INSERT INTO `mmwl_gpb_area` VALUES ('1963', '440309', '龙华区', 'area', '440300');
INSERT INTO `mmwl_gpb_area` VALUES ('1964', '440310', '坪山区', 'area', '440300');
INSERT INTO `mmwl_gpb_area` VALUES ('1965', '440308', '盐田区', 'area', '440300');
INSERT INTO `mmwl_gpb_area` VALUES ('1966', '440400', '珠海市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('1967', '440402', '香洲区', 'area', '440400');
INSERT INTO `mmwl_gpb_area` VALUES ('1968', '440403', '斗门区', 'area', '440400');
INSERT INTO `mmwl_gpb_area` VALUES ('1969', '440404', '金湾区', 'area', '440400');
INSERT INTO `mmwl_gpb_area` VALUES ('1970', '440500', '汕头市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('1971', '440511', '金平区', 'area', '440500');
INSERT INTO `mmwl_gpb_area` VALUES ('1972', '440513', '潮阳区', 'area', '440500');
INSERT INTO `mmwl_gpb_area` VALUES ('1973', '440515', '澄海区', 'area', '440500');
INSERT INTO `mmwl_gpb_area` VALUES ('1974', '440514', '潮南区', 'area', '440500');
INSERT INTO `mmwl_gpb_area` VALUES ('1975', '440512', '濠江区', 'area', '440500');
INSERT INTO `mmwl_gpb_area` VALUES ('1976', '440507', '龙湖区', 'area', '440500');
INSERT INTO `mmwl_gpb_area` VALUES ('1977', '440523', '南澳县', 'area', '440500');
INSERT INTO `mmwl_gpb_area` VALUES ('1978', '440600', '佛山市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('1979', '440606', '顺德区', 'area', '440600');
INSERT INTO `mmwl_gpb_area` VALUES ('1980', '440607', '三水区', 'area', '440600');
INSERT INTO `mmwl_gpb_area` VALUES ('1981', '440605', '南海区', 'area', '440600');
INSERT INTO `mmwl_gpb_area` VALUES ('1982', '440608', '高明区', 'area', '440600');
INSERT INTO `mmwl_gpb_area` VALUES ('1983', '440604', '禅城区', 'area', '440600');
INSERT INTO `mmwl_gpb_area` VALUES ('1984', '440700', '江门市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('1985', '440781', '台山市', 'area', '440700');
INSERT INTO `mmwl_gpb_area` VALUES ('1986', '440783', '开平市', 'area', '440700');
INSERT INTO `mmwl_gpb_area` VALUES ('1987', '440705', '新会区', 'area', '440700');
INSERT INTO `mmwl_gpb_area` VALUES ('1988', '440785', '恩平市', 'area', '440700');
INSERT INTO `mmwl_gpb_area` VALUES ('1989', '440784', '鹤山市', 'area', '440700');
INSERT INTO `mmwl_gpb_area` VALUES ('1990', '440703', '蓬江区', 'area', '440700');
INSERT INTO `mmwl_gpb_area` VALUES ('1991', '440704', '江海区', 'area', '440700');
INSERT INTO `mmwl_gpb_area` VALUES ('1992', '440800', '湛江市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('1993', '440882', '雷州市', 'area', '440800');
INSERT INTO `mmwl_gpb_area` VALUES ('1994', '440881', '廉江市', 'area', '440800');
INSERT INTO `mmwl_gpb_area` VALUES ('1995', '440825', '徐闻县', 'area', '440800');
INSERT INTO `mmwl_gpb_area` VALUES ('1996', '440883', '吴川市', 'area', '440800');
INSERT INTO `mmwl_gpb_area` VALUES ('1997', '440823', '遂溪县', 'area', '440800');
INSERT INTO `mmwl_gpb_area` VALUES ('1998', '440803', '霞山区', 'area', '440800');
INSERT INTO `mmwl_gpb_area` VALUES ('1999', '440802', '赤坎区', 'area', '440800');
INSERT INTO `mmwl_gpb_area` VALUES ('2000', '440804', '坡头区', 'area', '440800');
INSERT INTO `mmwl_gpb_area` VALUES ('2001', '440811', '麻章区', 'area', '440800');
INSERT INTO `mmwl_gpb_area` VALUES ('2002', '440981', '高州市', 'area', '440900');
INSERT INTO `mmwl_gpb_area` VALUES ('2003', '440900', '茂名市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2004', '440982', '化州市', 'area', '440900');
INSERT INTO `mmwl_gpb_area` VALUES ('2005', '440904', '电白区', 'area', '440900');
INSERT INTO `mmwl_gpb_area` VALUES ('2006', '440983', '信宜市', 'area', '440900');
INSERT INTO `mmwl_gpb_area` VALUES ('2007', '440902', '茂南区', 'area', '440900');
INSERT INTO `mmwl_gpb_area` VALUES ('2008', '441200', '肇庆市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2009', '441224', '怀集县', 'area', '441200');
INSERT INTO `mmwl_gpb_area` VALUES ('2010', '441204', '高要区', 'area', '441200');
INSERT INTO `mmwl_gpb_area` VALUES ('2011', '441225', '封开县', 'area', '441200');
INSERT INTO `mmwl_gpb_area` VALUES ('2012', '441223', '广宁县', 'area', '441200');
INSERT INTO `mmwl_gpb_area` VALUES ('2013', '441226', '德庆县', 'area', '441200');
INSERT INTO `mmwl_gpb_area` VALUES ('2014', '441284', '四会市', 'area', '441200');
INSERT INTO `mmwl_gpb_area` VALUES ('2015', '441203', '鼎湖区', 'area', '441200');
INSERT INTO `mmwl_gpb_area` VALUES ('2016', '441202', '端州区', 'area', '441200');
INSERT INTO `mmwl_gpb_area` VALUES ('2017', '441300', '惠州市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2018', '441302', '惠城区', 'area', '441300');
INSERT INTO `mmwl_gpb_area` VALUES ('2019', '441322', '博罗县', 'area', '441300');
INSERT INTO `mmwl_gpb_area` VALUES ('2020', '441323', '惠东县', 'area', '441300');
INSERT INTO `mmwl_gpb_area` VALUES ('2021', '441303', '惠阳区', 'area', '441300');
INSERT INTO `mmwl_gpb_area` VALUES ('2022', '441324', '龙门县', 'area', '441300');
INSERT INTO `mmwl_gpb_area` VALUES ('2023', '441400', '梅州市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2024', '441481', '兴宁市', 'area', '441400');
INSERT INTO `mmwl_gpb_area` VALUES ('2025', '441403', '梅县区', 'area', '441400');
INSERT INTO `mmwl_gpb_area` VALUES ('2026', '441423', '丰顺县', 'area', '441400');
INSERT INTO `mmwl_gpb_area` VALUES ('2027', '441422', '大埔县', 'area', '441400');
INSERT INTO `mmwl_gpb_area` VALUES ('2028', '441424', '五华县', 'area', '441400');
INSERT INTO `mmwl_gpb_area` VALUES ('2029', '441426', '平远县', 'area', '441400');
INSERT INTO `mmwl_gpb_area` VALUES ('2030', '441427', '蕉岭县', 'area', '441400');
INSERT INTO `mmwl_gpb_area` VALUES ('2031', '441402', '梅江区', 'area', '441400');
INSERT INTO `mmwl_gpb_area` VALUES ('2032', '441500', '汕尾市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2033', '441581', '陆丰市', 'area', '441500');
INSERT INTO `mmwl_gpb_area` VALUES ('2034', '441521', '海丰县', 'area', '441500');
INSERT INTO `mmwl_gpb_area` VALUES ('2035', '441502', '城区', 'area', '441500');
INSERT INTO `mmwl_gpb_area` VALUES ('2036', '441523', '陆河县', 'area', '441500');
INSERT INTO `mmwl_gpb_area` VALUES ('2037', '441600', '河源市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2038', '441622', '龙川县', 'area', '441600');
INSERT INTO `mmwl_gpb_area` VALUES ('2039', '441625', '东源县', 'area', '441600');
INSERT INTO `mmwl_gpb_area` VALUES ('2040', '441621', '紫金县', 'area', '441600');
INSERT INTO `mmwl_gpb_area` VALUES ('2041', '441624', '和平县', 'area', '441600');
INSERT INTO `mmwl_gpb_area` VALUES ('2042', '441623', '连平县', 'area', '441600');
INSERT INTO `mmwl_gpb_area` VALUES ('2043', '441602', '源城区', 'area', '441600');
INSERT INTO `mmwl_gpb_area` VALUES ('2044', '441700', '阳江市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2045', '441781', '阳春市', 'area', '441700');
INSERT INTO `mmwl_gpb_area` VALUES ('2046', '441702', '江城区', 'area', '441700');
INSERT INTO `mmwl_gpb_area` VALUES ('2047', '441704', '阳东区', 'area', '441700');
INSERT INTO `mmwl_gpb_area` VALUES ('2048', '441721', '阳西县', 'area', '441700');
INSERT INTO `mmwl_gpb_area` VALUES ('2049', '441800', '清远市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2050', '441881', '英德市', 'area', '441800');
INSERT INTO `mmwl_gpb_area` VALUES ('2051', '441823', '阳山县', 'area', '441800');
INSERT INTO `mmwl_gpb_area` VALUES ('2052', '441882', '连州市', 'area', '441800');
INSERT INTO `mmwl_gpb_area` VALUES ('2053', '441803', '清新区', 'area', '441800');
INSERT INTO `mmwl_gpb_area` VALUES ('2054', '441802', '清城区', 'area', '441800');
INSERT INTO `mmwl_gpb_area` VALUES ('2055', '441825', '连山壮族瑶族自治县', 'area', '441800');
INSERT INTO `mmwl_gpb_area` VALUES ('2056', '441826', '连南瑶族自治县', 'area', '441800');
INSERT INTO `mmwl_gpb_area` VALUES ('2057', '441821', '佛冈县', 'area', '441800');
INSERT INTO `mmwl_gpb_area` VALUES ('2058', '441900', '东莞市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2059', '442000', '中山市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2060', '445100', '潮州市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2061', '445122', '饶平县', 'area', '445100');
INSERT INTO `mmwl_gpb_area` VALUES ('2062', '445103', '潮安区', 'area', '445100');
INSERT INTO `mmwl_gpb_area` VALUES ('2063', '445102', '湘桥区', 'area', '445100');
INSERT INTO `mmwl_gpb_area` VALUES ('2064', '445200', '揭阳市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2065', '445281', '普宁市', 'area', '445200');
INSERT INTO `mmwl_gpb_area` VALUES ('2066', '445224', '惠来县', 'area', '445200');
INSERT INTO `mmwl_gpb_area` VALUES ('2067', '445222', '揭西县', 'area', '445200');
INSERT INTO `mmwl_gpb_area` VALUES ('2068', '445202', '榕城区', 'area', '445200');
INSERT INTO `mmwl_gpb_area` VALUES ('2069', '445203', '揭东区', 'area', '445200');
INSERT INTO `mmwl_gpb_area` VALUES ('2070', '445300', '云浮市', 'city', '440000');
INSERT INTO `mmwl_gpb_area` VALUES ('2071', '445381', '罗定市', 'area', '445300');
INSERT INTO `mmwl_gpb_area` VALUES ('2072', '445322', '郁南县', 'area', '445300');
INSERT INTO `mmwl_gpb_area` VALUES ('2073', '445321', '新兴县', 'area', '445300');
INSERT INTO `mmwl_gpb_area` VALUES ('2074', '445302', '云城区', 'area', '445300');
INSERT INTO `mmwl_gpb_area` VALUES ('2075', '445303', '云安区', 'area', '445300');
INSERT INTO `mmwl_gpb_area` VALUES ('2076', '450000', '广西壮族自治区', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('2077', '450100', '南宁市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2078', '450127', '横县', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2079', '450126', '宾阳县', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2080', '450110', '武鸣区', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2081', '450107', '西乡塘区', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2082', '450124', '马山县', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2083', '450125', '上林县', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2084', '450123', '隆安县', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2085', '450105', '江南区', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2086', '450103', '青秀区', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2087', '450108', '良庆区', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2088', '450102', '兴宁区', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2089', '450109', '邕宁区', 'area', '450100');
INSERT INTO `mmwl_gpb_area` VALUES ('2090', '450200', '柳州市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2091', '450225', '融水苗族自治县', 'area', '450200');
INSERT INTO `mmwl_gpb_area` VALUES ('2092', '450226', '三江侗族自治县', 'area', '450200');
INSERT INTO `mmwl_gpb_area` VALUES ('2093', '450206', '柳江区', 'area', '450200');
INSERT INTO `mmwl_gpb_area` VALUES ('2094', '450224', '融安县', 'area', '450200');
INSERT INTO `mmwl_gpb_area` VALUES ('2095', '450222', '柳城县', 'area', '450200');
INSERT INTO `mmwl_gpb_area` VALUES ('2096', '450205', '柳北区', 'area', '450200');
INSERT INTO `mmwl_gpb_area` VALUES ('2097', '450223', '鹿寨县', 'area', '450200');
INSERT INTO `mmwl_gpb_area` VALUES ('2098', '450203', '鱼峰区', 'area', '450200');
INSERT INTO `mmwl_gpb_area` VALUES ('2099', '450204', '柳南区', 'area', '450200');
INSERT INTO `mmwl_gpb_area` VALUES ('2100', '450202', '城中区', 'area', '450200');
INSERT INTO `mmwl_gpb_area` VALUES ('2101', '450300', '桂林市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2102', '450324', '全州县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2103', '450331', '荔浦县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2104', '450323', '灵川县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2105', '450312', '临桂区', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2106', '450325', '兴安县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2107', '450328', '龙胜各族自治县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2108', '450330', '平乐县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2109', '450327', '灌阳县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2110', '450332', '恭城瑶族自治县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2111', '450321', '阳朔县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2112', '450326', '永福县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2113', '450329', '资源县', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2114', '450311', '雁山区', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2115', '450305', '七星区', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2116', '450304', '象山区', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2117', '450303', '叠彩区', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2118', '450302', '秀峰区', 'area', '450300');
INSERT INTO `mmwl_gpb_area` VALUES ('2119', '450422', '藤县', 'area', '450400');
INSERT INTO `mmwl_gpb_area` VALUES ('2120', '450481', '岑溪市', 'area', '450400');
INSERT INTO `mmwl_gpb_area` VALUES ('2121', '450403', '万秀区', 'area', '450400');
INSERT INTO `mmwl_gpb_area` VALUES ('2122', '450421', '苍梧县', 'area', '450400');
INSERT INTO `mmwl_gpb_area` VALUES ('2123', '450423', '蒙山县', 'area', '450400');
INSERT INTO `mmwl_gpb_area` VALUES ('2124', '450400', '梧州市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2125', '450405', '长洲区', 'area', '450400');
INSERT INTO `mmwl_gpb_area` VALUES ('2126', '450406', '龙圩区', 'area', '450400');
INSERT INTO `mmwl_gpb_area` VALUES ('2127', '450500', '北海市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2128', '450521', '合浦县', 'area', '450500');
INSERT INTO `mmwl_gpb_area` VALUES ('2129', '450502', '海城区', 'area', '450500');
INSERT INTO `mmwl_gpb_area` VALUES ('2130', '450503', '银海区', 'area', '450500');
INSERT INTO `mmwl_gpb_area` VALUES ('2131', '450512', '铁山港区', 'area', '450500');
INSERT INTO `mmwl_gpb_area` VALUES ('2132', '450600', '防城港市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2133', '450603', '防城区', 'area', '450600');
INSERT INTO `mmwl_gpb_area` VALUES ('2134', '450621', '上思县', 'area', '450600');
INSERT INTO `mmwl_gpb_area` VALUES ('2135', '450602', '港口区', 'area', '450600');
INSERT INTO `mmwl_gpb_area` VALUES ('2136', '450681', '东兴市', 'area', '450600');
INSERT INTO `mmwl_gpb_area` VALUES ('2137', '450700', '钦州市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2138', '450721', '灵山县', 'area', '450700');
INSERT INTO `mmwl_gpb_area` VALUES ('2139', '450702', '钦南区', 'area', '450700');
INSERT INTO `mmwl_gpb_area` VALUES ('2140', '450722', '浦北县', 'area', '450700');
INSERT INTO `mmwl_gpb_area` VALUES ('2141', '450703', '钦北区', 'area', '450700');
INSERT INTO `mmwl_gpb_area` VALUES ('2142', '450800', '贵港市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2143', '450881', '桂平市', 'area', '450800');
INSERT INTO `mmwl_gpb_area` VALUES ('2144', '450821', '平南县', 'area', '450800');
INSERT INTO `mmwl_gpb_area` VALUES ('2145', '450804', '覃塘区', 'area', '450800');
INSERT INTO `mmwl_gpb_area` VALUES ('2146', '450803', '港南区', 'area', '450800');
INSERT INTO `mmwl_gpb_area` VALUES ('2147', '450802', '港北区', 'area', '450800');
INSERT INTO `mmwl_gpb_area` VALUES ('2148', '450900', '玉林市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2149', '450923', '博白县', 'area', '450900');
INSERT INTO `mmwl_gpb_area` VALUES ('2150', '450981', '北流市', 'area', '450900');
INSERT INTO `mmwl_gpb_area` VALUES ('2151', '450921', '容县', 'area', '450900');
INSERT INTO `mmwl_gpb_area` VALUES ('2152', '450922', '陆川县', 'area', '450900');
INSERT INTO `mmwl_gpb_area` VALUES ('2153', '450924', '兴业县', 'area', '450900');
INSERT INTO `mmwl_gpb_area` VALUES ('2154', '450902', '玉州区', 'area', '450900');
INSERT INTO `mmwl_gpb_area` VALUES ('2155', '450903', '福绵区', 'area', '450900');
INSERT INTO `mmwl_gpb_area` VALUES ('2156', '451000', '百色市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2157', '451081', '靖西市', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2158', '451031', '隆林各族自治县', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2159', '451029', '田林县', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2160', '451023', '平果县', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2161', '451024', '德保县', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2162', '451021', '田阳县', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2163', '451022', '田东县', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2164', '451002', '右江区', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2165', '451026', '那坡县', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2166', '451028', '乐业县', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2167', '451030', '西林县', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2168', '451027', '凌云县', 'area', '451000');
INSERT INTO `mmwl_gpb_area` VALUES ('2169', '451100', '贺州市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2170', '451102', '八步区', 'area', '451100');
INSERT INTO `mmwl_gpb_area` VALUES ('2171', '451123', '富川瑶族自治县', 'area', '451100');
INSERT INTO `mmwl_gpb_area` VALUES ('2172', '451122', '钟山县', 'area', '451100');
INSERT INTO `mmwl_gpb_area` VALUES ('2173', '451121', '昭平县', 'area', '451100');
INSERT INTO `mmwl_gpb_area` VALUES ('2174', '451103', '平桂区', 'area', '451100');
INSERT INTO `mmwl_gpb_area` VALUES ('2175', '451228', '都安瑶族自治县', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2176', '451203', '宜州区', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2177', '451229', '大化瑶族自治县', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2178', '451224', '东兰县', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2179', '451226', '环江毛南族自治县', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2180', '451200', '河池市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2181', '451202', '金城江区', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2182', '451221', '南丹县', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2183', '451225', '罗城仫佬族自治县', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2184', '451227', '巴马瑶族自治县', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2185', '451222', '天峨县', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2186', '451223', '凤山县', 'area', '451200');
INSERT INTO `mmwl_gpb_area` VALUES ('2187', '451300', '来宾市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2188', '451302', '兴宾区', 'area', '451300');
INSERT INTO `mmwl_gpb_area` VALUES ('2189', '451321', '忻城县', 'area', '451300');
INSERT INTO `mmwl_gpb_area` VALUES ('2190', '451322', '象州县', 'area', '451300');
INSERT INTO `mmwl_gpb_area` VALUES ('2191', '451323', '武宣县', 'area', '451300');
INSERT INTO `mmwl_gpb_area` VALUES ('2192', '451324', '金秀瑶族自治县', 'area', '451300');
INSERT INTO `mmwl_gpb_area` VALUES ('2193', '451381', '合山市', 'area', '451300');
INSERT INTO `mmwl_gpb_area` VALUES ('2194', '451400', '崇左市', 'city', '450000');
INSERT INTO `mmwl_gpb_area` VALUES ('2195', '451424', '大新县', 'area', '451400');
INSERT INTO `mmwl_gpb_area` VALUES ('2196', '451425', '天等县', 'area', '451400');
INSERT INTO `mmwl_gpb_area` VALUES ('2197', '451422', '宁明县', 'area', '451400');
INSERT INTO `mmwl_gpb_area` VALUES ('2198', '451423', '龙州县', 'area', '451400');
INSERT INTO `mmwl_gpb_area` VALUES ('2199', '451402', '江州区', 'area', '451400');
INSERT INTO `mmwl_gpb_area` VALUES ('2200', '451421', '扶绥县', 'area', '451400');
INSERT INTO `mmwl_gpb_area` VALUES ('2201', '451481', '凭祥市', 'area', '451400');
INSERT INTO `mmwl_gpb_area` VALUES ('2202', '460000', '海南省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('2203', '460100', '海口市', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2204', '460108', '美兰区', 'area', '460100');
INSERT INTO `mmwl_gpb_area` VALUES ('2205', '460107', '琼山区', 'area', '460100');
INSERT INTO `mmwl_gpb_area` VALUES ('2206', '460106', '龙华区', 'area', '460100');
INSERT INTO `mmwl_gpb_area` VALUES ('2207', '460105', '秀英区', 'area', '460100');
INSERT INTO `mmwl_gpb_area` VALUES ('2208', '460200', '三亚市', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2209', '460201', '三亚市', 'area', '460200');
INSERT INTO `mmwl_gpb_area` VALUES ('2210', '460202', '海棠区', 'area', '460200');
INSERT INTO `mmwl_gpb_area` VALUES ('2211', '460205', '崖州区', 'area', '460200');
INSERT INTO `mmwl_gpb_area` VALUES ('2212', '460204', '天涯区', 'area', '460200');
INSERT INTO `mmwl_gpb_area` VALUES ('2213', '460203', '吉阳区', 'area', '460200');
INSERT INTO `mmwl_gpb_area` VALUES ('2214', '460321', '西沙群岛', 'area', '460300');
INSERT INTO `mmwl_gpb_area` VALUES ('2215', '460322', '南沙群岛', 'area', '460300');
INSERT INTO `mmwl_gpb_area` VALUES ('2216', '460323', '中沙群岛', 'area', '460300');
INSERT INTO `mmwl_gpb_area` VALUES ('2217', '469002', '琼海市', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2218', '460400', '儋州市', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2219', '469001', '五指山市', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2220', '469002', '琼海市', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2221', '469005', '文昌市', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2222', '469006', '万宁市', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2223', '469007', '东方市', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2224', '469021', '定安县', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2225', '469022', '屯昌县', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2226', '469023', '澄迈县', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2227', '469024', '临高县', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2228', '469025', '白沙黎族自治县', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2229', '469026', '昌江黎族自治县', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2230', '469027', '乐东黎族自治县', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2231', '469028', '陵水黎族自治县', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2232', '469029', '保亭黎族苗族自治县', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2233', '469030', '琼中黎族苗族自治县', 'city', '460000');
INSERT INTO `mmwl_gpb_area` VALUES ('2234', '500000', '重庆市', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('2235', '500100', '重庆市', 'city', '500000');
INSERT INTO `mmwl_gpb_area` VALUES ('2236', '500101', '万州区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2237', '500154', '开州区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2238', '500119', '南川区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2239', '500155', '梁平区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2240', '500114', '黔江区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2241', '500112', '渝北区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2242', '500110', '綦江区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2243', '500117', '合川区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2244', '500116', '江津区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2245', '500151', '铜梁区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2246', '500111', '大足区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2247', '500156', '武隆区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2248', '500106', '沙坪坝区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2249', '500102', '涪陵区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2250', '500118', '永川区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2251', '500152', '潼南区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2252', '500113', '巴南区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2253', '500153', '荣昌区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2254', '500107', '九龙坡区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2255', '500115', '长寿区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2256', '500109', '北碚区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2257', '500120', '璧山区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2258', '500108', '南岸区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2259', '500105', '江北区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2260', '500103', '渝中区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2261', '500104', '大渡口区', 'area', '500100');
INSERT INTO `mmwl_gpb_area` VALUES ('2262', '500235', '云阳县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2263', '500243', '彭水苗族土家族自治县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2264', '500242', '酉阳土家族苗族自治县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2265', '500238', '巫溪县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2266', '500236', '奉节县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2267', '500240', '石柱土家族自治县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2268', '500230', '丰都县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2269', '500233', '忠县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2270', '500241', '秀山土家族苗族自治县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2271', '500237', '巫山县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2272', '500231', '垫江县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2273', '500229', '城口县', 'area', '500200');
INSERT INTO `mmwl_gpb_area` VALUES ('2274', '510000', '四川省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('2275', '510100', '成都市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2276', '510185', '简阳市', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2277', '510184', '崇州市', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2278', '510116', '双流区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2279', '510183', '邛崃市', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2280', '510121', '金堂县', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2281', '510129', '大邑县', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2282', '510182', '彭州市', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2283', '510181', '都江堰市', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2284', '510107', '武侯区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2285', '510104', '锦江区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2286', '510117', '郫都区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2287', '510106', '金牛区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2288', '510105', '青羊区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2289', '510108', '成华区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2290', '510114', '新都区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2291', '510132', '新津县', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2292', '510131', '蒲江县', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2293', '510112', '龙泉驿区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2294', '510113', '青白江区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2295', '510115', '温江区', 'area', '510100');
INSERT INTO `mmwl_gpb_area` VALUES ('2296', '510300', '自贡市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2297', '510321', '荣县', 'area', '510300');
INSERT INTO `mmwl_gpb_area` VALUES ('2298', '510322', '富顺县', 'area', '510300');
INSERT INTO `mmwl_gpb_area` VALUES ('2299', '510304', '大安区', 'area', '510300');
INSERT INTO `mmwl_gpb_area` VALUES ('2300', '510311', '沿滩区', 'area', '510300');
INSERT INTO `mmwl_gpb_area` VALUES ('2301', '510302', '自流井区', 'area', '510300');
INSERT INTO `mmwl_gpb_area` VALUES ('2302', '510303', '贡井区', 'area', '510300');
INSERT INTO `mmwl_gpb_area` VALUES ('2303', '510400', '攀枝花市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2304', '510422', '盐边县', 'area', '510400');
INSERT INTO `mmwl_gpb_area` VALUES ('2305', '510411', '仁和区', 'area', '510400');
INSERT INTO `mmwl_gpb_area` VALUES ('2306', '510421', '米易县', 'area', '510400');
INSERT INTO `mmwl_gpb_area` VALUES ('2307', '510402', '东区', 'area', '510400');
INSERT INTO `mmwl_gpb_area` VALUES ('2308', '510403', '西区', 'area', '510400');
INSERT INTO `mmwl_gpb_area` VALUES ('2309', '510500', '泸州市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2310', '510522', '合江县', 'area', '510500');
INSERT INTO `mmwl_gpb_area` VALUES ('2311', '510525', '古蔺县', 'area', '510500');
INSERT INTO `mmwl_gpb_area` VALUES ('2312', '510524', '叙永县', 'area', '510500');
INSERT INTO `mmwl_gpb_area` VALUES ('2313', '510521', '泸县', 'area', '510500');
INSERT INTO `mmwl_gpb_area` VALUES ('2314', '510502', '江阳区', 'area', '510500');
INSERT INTO `mmwl_gpb_area` VALUES ('2315', '510503', '纳溪区', 'area', '510500');
INSERT INTO `mmwl_gpb_area` VALUES ('2316', '510504', '龙马潭区', 'area', '510500');
INSERT INTO `mmwl_gpb_area` VALUES ('2317', '510600', '德阳市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2318', '510623', '中江县', 'area', '510600');
INSERT INTO `mmwl_gpb_area` VALUES ('2319', '510683', '绵竹市', 'area', '510600');
INSERT INTO `mmwl_gpb_area` VALUES ('2320', '510681', '广汉市', 'area', '510600');
INSERT INTO `mmwl_gpb_area` VALUES ('2321', '510603', '旌阳区', 'area', '510600');
INSERT INTO `mmwl_gpb_area` VALUES ('2322', '510682', '什邡市', 'area', '510600');
INSERT INTO `mmwl_gpb_area` VALUES ('2323', '510626', '罗江区', 'area', '510600');
INSERT INTO `mmwl_gpb_area` VALUES ('2324', '510700', '绵阳市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2325', '510722', '三台县', 'area', '510700');
INSERT INTO `mmwl_gpb_area` VALUES ('2326', '510781', '江油市', 'area', '510700');
INSERT INTO `mmwl_gpb_area` VALUES ('2327', '510723', '盐亭县', 'area', '510700');
INSERT INTO `mmwl_gpb_area` VALUES ('2328', '510725', '梓潼县', 'area', '510700');
INSERT INTO `mmwl_gpb_area` VALUES ('2329', '510704', '游仙区', 'area', '510700');
INSERT INTO `mmwl_gpb_area` VALUES ('2330', '510727', '平武县', 'area', '510700');
INSERT INTO `mmwl_gpb_area` VALUES ('2331', '510703', '涪城区', 'area', '510700');
INSERT INTO `mmwl_gpb_area` VALUES ('2332', '510726', '北川羌族自治县', 'area', '510700');
INSERT INTO `mmwl_gpb_area` VALUES ('2333', '510705', '安州区', 'area', '510700');
INSERT INTO `mmwl_gpb_area` VALUES ('2334', '510800', '广元市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2335', '510823', '剑阁县', 'area', '510800');
INSERT INTO `mmwl_gpb_area` VALUES ('2336', '510824', '苍溪县', 'area', '510800');
INSERT INTO `mmwl_gpb_area` VALUES ('2337', '510821', '旺苍县', 'area', '510800');
INSERT INTO `mmwl_gpb_area` VALUES ('2338', '510822', '青川县', 'area', '510800');
INSERT INTO `mmwl_gpb_area` VALUES ('2339', '510811', '昭化区', 'area', '510800');
INSERT INTO `mmwl_gpb_area` VALUES ('2340', '510812', '朝天区', 'area', '510800');
INSERT INTO `mmwl_gpb_area` VALUES ('2341', '510802', '利州区', 'area', '510800');
INSERT INTO `mmwl_gpb_area` VALUES ('2342', '510900', '遂宁市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2343', '510921', '蓬溪县', 'area', '510900');
INSERT INTO `mmwl_gpb_area` VALUES ('2344', '510922', '射洪县', 'area', '510900');
INSERT INTO `mmwl_gpb_area` VALUES ('2345', '510903', '船山区', 'area', '510900');
INSERT INTO `mmwl_gpb_area` VALUES ('2346', '510904', '安居区', 'area', '510900');
INSERT INTO `mmwl_gpb_area` VALUES ('2347', '510923', '大英县', 'area', '510900');
INSERT INTO `mmwl_gpb_area` VALUES ('2348', '511000', '内江市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2349', '511025', '资中县', 'area', '511000');
INSERT INTO `mmwl_gpb_area` VALUES ('2350', '511011', '东兴区', 'area', '511000');
INSERT INTO `mmwl_gpb_area` VALUES ('2351', '511002', '市中区', 'area', '511000');
INSERT INTO `mmwl_gpb_area` VALUES ('2352', '511024', '威远县', 'area', '511000');
INSERT INTO `mmwl_gpb_area` VALUES ('2353', '511083', '隆昌市', 'area', '511000');
INSERT INTO `mmwl_gpb_area` VALUES ('2354', '511100', '乐山市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2355', '511102', '市中区', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2356', '511123', '犍为县', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2357', '511124', '井研县', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2358', '511126', '夹江县', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2359', '511133', '马边彝族自治县', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2360', '511129', '沐川县', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2361', '511132', '峨边彝族自治县', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2362', '511181', '峨眉山市', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2363', '511111', '沙湾区', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2364', '511112', '五通桥区', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2365', '511113', '金口河区', 'area', '511100');
INSERT INTO `mmwl_gpb_area` VALUES ('2366', '511300', '南充市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2367', '511321', '南部县', 'area', '511300');
INSERT INTO `mmwl_gpb_area` VALUES ('2368', '511324', '仪陇县', 'area', '511300');
INSERT INTO `mmwl_gpb_area` VALUES ('2369', '511322', '营山县', 'area', '511300');
INSERT INTO `mmwl_gpb_area` VALUES ('2370', '511381', '阆中市', 'area', '511300');
INSERT INTO `mmwl_gpb_area` VALUES ('2371', '511325', '西充县', 'area', '511300');
INSERT INTO `mmwl_gpb_area` VALUES ('2372', '511304', '嘉陵区', 'area', '511300');
INSERT INTO `mmwl_gpb_area` VALUES ('2373', '511323', '蓬安县', 'area', '511300');
INSERT INTO `mmwl_gpb_area` VALUES ('2374', '511303', '高坪区', 'area', '511300');
INSERT INTO `mmwl_gpb_area` VALUES ('2375', '511302', '顺庆区', 'area', '511300');
INSERT INTO `mmwl_gpb_area` VALUES ('2376', '511400', '眉山市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2377', '511421', '仁寿县', 'area', '511400');
INSERT INTO `mmwl_gpb_area` VALUES ('2378', '511402', '东坡区', 'area', '511400');
INSERT INTO `mmwl_gpb_area` VALUES ('2379', '511423', '洪雅县', 'area', '511400');
INSERT INTO `mmwl_gpb_area` VALUES ('2380', '511403', '彭山区', 'area', '511400');
INSERT INTO `mmwl_gpb_area` VALUES ('2381', '511425', '青神县', 'area', '511400');
INSERT INTO `mmwl_gpb_area` VALUES ('2382', '511424', '丹棱县', 'area', '511400');
INSERT INTO `mmwl_gpb_area` VALUES ('2383', '511500', '宜宾市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2384', '511521', '宜宾县', 'area', '511500');
INSERT INTO `mmwl_gpb_area` VALUES ('2385', '511502', '翠屏区', 'area', '511500');
INSERT INTO `mmwl_gpb_area` VALUES ('2386', '511525', '高县', 'area', '511500');
INSERT INTO `mmwl_gpb_area` VALUES ('2387', '511527', '筠连县', 'area', '511500');
INSERT INTO `mmwl_gpb_area` VALUES ('2388', '511524', '长宁县', 'area', '511500');
INSERT INTO `mmwl_gpb_area` VALUES ('2389', '511523', '江安县', 'area', '511500');
INSERT INTO `mmwl_gpb_area` VALUES ('2390', '511526', '珙县', 'area', '511500');
INSERT INTO `mmwl_gpb_area` VALUES ('2391', '511529', '屏山县', 'area', '511500');
INSERT INTO `mmwl_gpb_area` VALUES ('2392', '511528', '兴文县', 'area', '511500');
INSERT INTO `mmwl_gpb_area` VALUES ('2393', '511503', '南溪区', 'area', '511500');
INSERT INTO `mmwl_gpb_area` VALUES ('2394', '511600', '广安市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2395', '511623', '邻水县', 'area', '511600');
INSERT INTO `mmwl_gpb_area` VALUES ('2396', '511621', '岳池县', 'area', '511600');
INSERT INTO `mmwl_gpb_area` VALUES ('2397', '511602', '广安区', 'area', '511600');
INSERT INTO `mmwl_gpb_area` VALUES ('2398', '511622', '武胜县', 'area', '511600');
INSERT INTO `mmwl_gpb_area` VALUES ('2399', '511681', '华蓥市', 'area', '511600');
INSERT INTO `mmwl_gpb_area` VALUES ('2400', '511603', '前锋区', 'area', '511600');
INSERT INTO `mmwl_gpb_area` VALUES ('2401', '511700', '达州市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2402', '511725', '渠县', 'area', '511700');
INSERT INTO `mmwl_gpb_area` VALUES ('2403', '511703', '达川区', 'area', '511700');
INSERT INTO `mmwl_gpb_area` VALUES ('2404', '511722', '宣汉县', 'area', '511700');
INSERT INTO `mmwl_gpb_area` VALUES ('2405', '511781', '万源市', 'area', '511700');
INSERT INTO `mmwl_gpb_area` VALUES ('2406', '511724', '大竹县', 'area', '511700');
INSERT INTO `mmwl_gpb_area` VALUES ('2407', '511702', '通川区', 'area', '511700');
INSERT INTO `mmwl_gpb_area` VALUES ('2408', '511723', '开江县', 'area', '511700');
INSERT INTO `mmwl_gpb_area` VALUES ('2409', '511800', '雅安市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2410', '511823', '汉源县', 'area', '511800');
INSERT INTO `mmwl_gpb_area` VALUES ('2411', '511802', '雨城区', 'area', '511800');
INSERT INTO `mmwl_gpb_area` VALUES ('2412', '511822', '荥经县', 'area', '511800');
INSERT INTO `mmwl_gpb_area` VALUES ('2413', '511803', '名山区', 'area', '511800');
INSERT INTO `mmwl_gpb_area` VALUES ('2414', '511824', '石棉县', 'area', '511800');
INSERT INTO `mmwl_gpb_area` VALUES ('2415', '511825', '天全县', 'area', '511800');
INSERT INTO `mmwl_gpb_area` VALUES ('2416', '511826', '芦山县', 'area', '511800');
INSERT INTO `mmwl_gpb_area` VALUES ('2417', '511827', '宝兴县', 'area', '511800');
INSERT INTO `mmwl_gpb_area` VALUES ('2418', '511900', '巴中市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2419', '511921', '通江县', 'area', '511900');
INSERT INTO `mmwl_gpb_area` VALUES ('2420', '511922', '南江县', 'area', '511900');
INSERT INTO `mmwl_gpb_area` VALUES ('2421', '511923', '平昌县', 'area', '511900');
INSERT INTO `mmwl_gpb_area` VALUES ('2422', '511902', '巴州区', 'area', '511900');
INSERT INTO `mmwl_gpb_area` VALUES ('2423', '511903', '恩阳区', 'area', '511900');
INSERT INTO `mmwl_gpb_area` VALUES ('2424', '512000', '资阳市', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2425', '512021', '安岳县', 'area', '512000');
INSERT INTO `mmwl_gpb_area` VALUES ('2426', '512002', '雁江区', 'area', '512000');
INSERT INTO `mmwl_gpb_area` VALUES ('2427', '512022', '乐至县', 'area', '512000');
INSERT INTO `mmwl_gpb_area` VALUES ('2428', '513200', '阿坝藏族羌族自治州', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2429', '513224', '松潘县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2430', '513226', '金川县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2431', '513223', '茂县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2432', '513227', '小金县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2433', '513231', '阿坝县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2434', '513232', '若尔盖县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2435', '513228', '黑水县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2436', '513225', '九寨沟县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2437', '513201', '马尔康市', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2438', '513222', '理县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2439', '513221', '汶川县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2440', '513230', '壤塘县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2441', '513233', '红原县', 'area', '513200');
INSERT INTO `mmwl_gpb_area` VALUES ('2442', '513300', '甘孜藏族自治州', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2443', '513330', '德格县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2444', '513334', '理塘县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2445', '513332', '石渠县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2446', '513328', '甘孜县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2447', '513326', '道孚县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2448', '513301', '康定市', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2449', '513335', '巴塘县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2450', '513329', '新龙县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2451', '513324', '九龙县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2452', '513333', '色达县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2453', '513325', '雅江县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2454', '513331', '白玉县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2455', '513327', '炉霍县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2456', '513323', '丹巴县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2457', '513337', '稻城县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2458', '513338', '得荣县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2459', '513336', '乡城县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2460', '513322', '泸定县', 'area', '513300');
INSERT INTO `mmwl_gpb_area` VALUES ('2461', '513400', '凉山彝族自治州', 'city', '510000');
INSERT INTO `mmwl_gpb_area` VALUES ('2462', '513437', '雷波县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2463', '513425', '会理县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2464', '513431', '昭觉县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2465', '513401', '西昌市', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2466', '513434', '越西县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2467', '513433', '冕宁县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2468', '513436', '美姑县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2469', '513428', '普格县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2470', '513423', '盐源县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2471', '513430', '金阳县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2472', '513429', '布拖县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2473', '513422', '木里藏族自治县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2474', '513435', '甘洛县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2475', '513427', '宁南县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2476', '513432', '喜德县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2477', '513426', '会东县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2478', '513424', '德昌县', 'area', '513400');
INSERT INTO `mmwl_gpb_area` VALUES ('2479', '520000', '贵州省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('2480', '520100', '贵阳市', 'city', '520000');
INSERT INTO `mmwl_gpb_area` VALUES ('2481', '520102', '南明区', 'area', '520100');
INSERT INTO `mmwl_gpb_area` VALUES ('2482', '520111', '花溪区', 'area', '520100');
INSERT INTO `mmwl_gpb_area` VALUES ('2483', '520103', '云岩区', 'area', '520100');
INSERT INTO `mmwl_gpb_area` VALUES ('2484', '520121', '开阳县', 'area', '520100');
INSERT INTO `mmwl_gpb_area` VALUES ('2485', '520122', '息烽县', 'area', '520100');
INSERT INTO `mmwl_gpb_area` VALUES ('2486', '520181', '清镇市', 'area', '520100');
INSERT INTO `mmwl_gpb_area` VALUES ('2487', '520123', '修文县', 'area', '520100');
INSERT INTO `mmwl_gpb_area` VALUES ('2488', '520112', '乌当区', 'area', '520100');
INSERT INTO `mmwl_gpb_area` VALUES ('2489', '520113', '白云区', 'area', '520100');
INSERT INTO `mmwl_gpb_area` VALUES ('2490', '520115', '观山湖区', 'area', '520100');
INSERT INTO `mmwl_gpb_area` VALUES ('2491', '520200', '六盘水市', 'city', '520000');
INSERT INTO `mmwl_gpb_area` VALUES ('2492', '520221', '水城县', 'area', '520200');
INSERT INTO `mmwl_gpb_area` VALUES ('2493', '520281', '盘州市', 'area', '520200');
INSERT INTO `mmwl_gpb_area` VALUES ('2494', '520203', '六枝特区', 'area', '520200');
INSERT INTO `mmwl_gpb_area` VALUES ('2495', '520201', '钟山区', 'area', '520200');
INSERT INTO `mmwl_gpb_area` VALUES ('2496', '520300', '遵义市', 'city', '520000');
INSERT INTO `mmwl_gpb_area` VALUES ('2497', '520322', '桐梓县', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2498', '520330', '习水县', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2499', '520382', '仁怀市', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2500', '520302', '红花岗区', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2501', '520304', '播州区', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2502', '520324', '正安县', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2503', '520381', '赤水市', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2504', '520326', '务川仡佬族苗族自治县', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2505', '520323', '绥阳县', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2506', '520328', '湄潭县', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2507', '520327', '凤冈县', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2508', '520325', '道真仡佬族苗族自治县', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2509', '520303', '汇川区', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2510', '520329', '余庆县', 'area', '520300');
INSERT INTO `mmwl_gpb_area` VALUES ('2511', '520400', '安顺市', 'city', '520000');
INSERT INTO `mmwl_gpb_area` VALUES ('2512', '520402', '西秀区', 'area', '520400');
INSERT INTO `mmwl_gpb_area` VALUES ('2513', '520423', '镇宁布依族苗族自治县', 'area', '520400');
INSERT INTO `mmwl_gpb_area` VALUES ('2514', '520424', '关岭布依族苗族自治县', 'area', '520400');
INSERT INTO `mmwl_gpb_area` VALUES ('2515', '520425', '紫云苗族布依族自治县', 'area', '520400');
INSERT INTO `mmwl_gpb_area` VALUES ('2516', '520422', '普定县', 'area', '520400');
INSERT INTO `mmwl_gpb_area` VALUES ('2517', '520403', '平坝区', 'area', '520400');
INSERT INTO `mmwl_gpb_area` VALUES ('2518', '520500', '毕节市', 'city', '520000');
INSERT INTO `mmwl_gpb_area` VALUES ('2519', '520502', '七星关区', 'area', '520500');
INSERT INTO `mmwl_gpb_area` VALUES ('2520', '520526', '威宁彝族回族苗族自治县', 'area', '520500');
INSERT INTO `mmwl_gpb_area` VALUES ('2521', '520521', '大方县', 'area', '520500');
INSERT INTO `mmwl_gpb_area` VALUES ('2522', '520524', '织金县', 'area', '520500');
INSERT INTO `mmwl_gpb_area` VALUES ('2523', '520522', '黔西县', 'area', '520500');
INSERT INTO `mmwl_gpb_area` VALUES ('2524', '520527', '赫章县', 'area', '520500');
INSERT INTO `mmwl_gpb_area` VALUES ('2525', '520525', '纳雍县', 'area', '520500');
INSERT INTO `mmwl_gpb_area` VALUES ('2526', '520523', '金沙县', 'area', '520500');
INSERT INTO `mmwl_gpb_area` VALUES ('2527', '520600', '铜仁市', 'city', '520000');
INSERT INTO `mmwl_gpb_area` VALUES ('2528', '520628', '松桃苗族自治县', 'area', '520600');
INSERT INTO `mmwl_gpb_area` VALUES ('2529', '520624', '思南县', 'area', '520600');
INSERT INTO `mmwl_gpb_area` VALUES ('2530', '520627', '沿河土家族自治县', 'area', '520600');
INSERT INTO `mmwl_gpb_area` VALUES ('2531', '520626', '德江县', 'area', '520600');
INSERT INTO `mmwl_gpb_area` VALUES ('2532', '520623', '石阡县', 'area', '520600');
INSERT INTO `mmwl_gpb_area` VALUES ('2533', '520625', '印江土家族苗族自治县', 'area', '520600');
INSERT INTO `mmwl_gpb_area` VALUES ('2534', '520602', '碧江区', 'area', '520600');
INSERT INTO `mmwl_gpb_area` VALUES ('2535', '520621', '江口县', 'area', '520600');
INSERT INTO `mmwl_gpb_area` VALUES ('2536', '520603', '万山区', 'area', '520600');
INSERT INTO `mmwl_gpb_area` VALUES ('2537', '520622', '玉屏侗族自治县', 'area', '520600');
INSERT INTO `mmwl_gpb_area` VALUES ('2538', '522300', '黔西南布依族苗族自治州', 'city', '520000');
INSERT INTO `mmwl_gpb_area` VALUES ('2539', '522301', '兴义市', 'area', '522300');
INSERT INTO `mmwl_gpb_area` VALUES ('2540', '522322', '兴仁县', 'area', '522300');
INSERT INTO `mmwl_gpb_area` VALUES ('2541', '522328', '安龙县', 'area', '522300');
INSERT INTO `mmwl_gpb_area` VALUES ('2542', '522324', '晴隆县', 'area', '522300');
INSERT INTO `mmwl_gpb_area` VALUES ('2543', '522327', '册亨县', 'area', '522300');
INSERT INTO `mmwl_gpb_area` VALUES ('2544', '522326', '望谟县', 'area', '522300');
INSERT INTO `mmwl_gpb_area` VALUES ('2545', '522325', '贞丰县', 'area', '522300');
INSERT INTO `mmwl_gpb_area` VALUES ('2546', '522323', '普安县', 'area', '522300');
INSERT INTO `mmwl_gpb_area` VALUES ('2547', '522600', '黔东南苗族侗族自治州', 'city', '520000');
INSERT INTO `mmwl_gpb_area` VALUES ('2548', '522631', '黎平县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2549', '522633', '从江县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2550', '522632', '榕江县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2551', '522601', '凯里市', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2552', '522627', '天柱县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2553', '522628', '锦屏县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2554', '522625', '镇远县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2555', '522629', '剑河县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2556', '522626', '岑巩县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2557', '522622', '黄平县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2558', '522624', '三穗县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2559', '522630', '台江县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2560', '522623', '施秉县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2561', '522634', '雷山县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2562', '522636', '丹寨县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2563', '522635', '麻江县', 'area', '522600');
INSERT INTO `mmwl_gpb_area` VALUES ('2564', '522700', '黔南布依族苗族自治州', 'city', '520000');
INSERT INTO `mmwl_gpb_area` VALUES ('2565', '522725', '瓮安县', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2566', '522727', '平塘县', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2567', '522701', '都匀市', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2568', '522731', '惠水县', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2569', '522728', '罗甸县', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2570', '522726', '独山县', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2571', '522722', '荔波县', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2572', '522723', '贵定县', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2573', '522702', '福泉市', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2574', '522729', '长顺县', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2575', '522732', '三都水族自治县', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2576', '522730', '龙里县', 'area', '522700');
INSERT INTO `mmwl_gpb_area` VALUES ('2577', '530000', '云南省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('2578', '530100', '昆明市', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2579', '530128', '禄劝彝族苗族自治县', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2580', '530129', '寻甸回族彝族自治县', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2581', '530112', '西山区', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2582', '530111', '官渡区', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2583', '530103', '盘龙区', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2584', '530102', '五华区', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2585', '530114', '呈贡区', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2586', '530181', '安宁市', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2587', '530113', '东川区', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2588', '530125', '宜良县', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2589', '530115', '晋宁区', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2590', '530127', '嵩明县', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2591', '530124', '富民县', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2592', '530126', '石林彝族自治县', 'area', '530100');
INSERT INTO `mmwl_gpb_area` VALUES ('2593', '530300', '曲靖市', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2594', '530381', '宣威市', 'area', '530300');
INSERT INTO `mmwl_gpb_area` VALUES ('2595', '530326', '会泽县', 'area', '530300');
INSERT INTO `mmwl_gpb_area` VALUES ('2596', '530324', '罗平县', 'area', '530300');
INSERT INTO `mmwl_gpb_area` VALUES ('2597', '530325', '富源县', 'area', '530300');
INSERT INTO `mmwl_gpb_area` VALUES ('2598', '530302', '麒麟区', 'area', '530300');
INSERT INTO `mmwl_gpb_area` VALUES ('2599', '530322', '陆良县', 'area', '530300');
INSERT INTO `mmwl_gpb_area` VALUES ('2600', '530303', '沾益区', 'area', '530300');
INSERT INTO `mmwl_gpb_area` VALUES ('2601', '530321', '马龙县', 'area', '530300');
INSERT INTO `mmwl_gpb_area` VALUES ('2602', '530323', '师宗县', 'area', '530300');
INSERT INTO `mmwl_gpb_area` VALUES ('2603', '530400', '玉溪市', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2604', '530427', '新平彝族傣族自治县', 'area', '530400');
INSERT INTO `mmwl_gpb_area` VALUES ('2605', '530402', '红塔区', 'area', '530400');
INSERT INTO `mmwl_gpb_area` VALUES ('2606', '530428', '元江哈尼族彝族傣族自治县', 'area', '530400');
INSERT INTO `mmwl_gpb_area` VALUES ('2607', '530423', '通海县', 'area', '530400');
INSERT INTO `mmwl_gpb_area` VALUES ('2608', '530426', '峨山彝族自治县', 'area', '530400');
INSERT INTO `mmwl_gpb_area` VALUES ('2609', '530425', '易门县', 'area', '530400');
INSERT INTO `mmwl_gpb_area` VALUES ('2610', '530403', '江川区', 'area', '530400');
INSERT INTO `mmwl_gpb_area` VALUES ('2611', '530422', '澄江县', 'area', '530400');
INSERT INTO `mmwl_gpb_area` VALUES ('2612', '530424', '华宁县', 'area', '530400');
INSERT INTO `mmwl_gpb_area` VALUES ('2613', '530500', '保山市', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2614', '530581', '腾冲市', 'area', '530500');
INSERT INTO `mmwl_gpb_area` VALUES ('2615', '530502', '隆阳区', 'area', '530500');
INSERT INTO `mmwl_gpb_area` VALUES ('2616', '530521', '施甸县', 'area', '530500');
INSERT INTO `mmwl_gpb_area` VALUES ('2617', '530524', '昌宁县', 'area', '530500');
INSERT INTO `mmwl_gpb_area` VALUES ('2618', '530523', '龙陵县', 'area', '530500');
INSERT INTO `mmwl_gpb_area` VALUES ('2619', '530600', '昭通市', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2620', '530627', '镇雄县', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2621', '530602', '昭阳区', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2622', '530622', '巧家县', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2623', '530625', '永善县', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2624', '530628', '彝良县', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2625', '530621', '鲁甸县', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2626', '530629', '威信县', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2627', '530623', '盐津县', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2628', '530624', '大关县', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2629', '530626', '绥江县', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2630', '530630', '水富县', 'area', '530600');
INSERT INTO `mmwl_gpb_area` VALUES ('2631', '530700', '丽江市', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2632', '530721', '玉龙纳西族自治县', 'area', '530700');
INSERT INTO `mmwl_gpb_area` VALUES ('2633', '530724', '宁蒗彝族自治县', 'area', '530700');
INSERT INTO `mmwl_gpb_area` VALUES ('2634', '530722', '永胜县', 'area', '530700');
INSERT INTO `mmwl_gpb_area` VALUES ('2635', '530702', '古城区', 'area', '530700');
INSERT INTO `mmwl_gpb_area` VALUES ('2636', '530723', '华坪县', 'area', '530700');
INSERT INTO `mmwl_gpb_area` VALUES ('2637', '530800', '普洱市', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2638', '530828', '澜沧拉祜族自治县', 'area', '530800');
INSERT INTO `mmwl_gpb_area` VALUES ('2639', '530822', '墨江哈尼族自治县', 'area', '530800');
INSERT INTO `mmwl_gpb_area` VALUES ('2640', '530823', '景东彝族自治县', 'area', '530800');
INSERT INTO `mmwl_gpb_area` VALUES ('2641', '530824', '景谷傣族彝族自治县', 'area', '530800');
INSERT INTO `mmwl_gpb_area` VALUES ('2642', '530825', '镇沅彝族哈尼族拉祜族自治县', 'area', '530800');
INSERT INTO `mmwl_gpb_area` VALUES ('2643', '530821', '宁洱哈尼族彝族自治县', 'area', '530800');
INSERT INTO `mmwl_gpb_area` VALUES ('2644', '530829', '西盟佤族自治县', 'area', '530800');
INSERT INTO `mmwl_gpb_area` VALUES ('2645', '530826', '江城哈尼族彝族自治县', 'area', '530800');
INSERT INTO `mmwl_gpb_area` VALUES ('2646', '530802', '思茅区', 'area', '530800');
INSERT INTO `mmwl_gpb_area` VALUES ('2647', '530827', '孟连傣族拉祜族佤族自治县', 'area', '530800');
INSERT INTO `mmwl_gpb_area` VALUES ('2648', '530900', '临沧市', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2649', '530921', '凤庆县', 'area', '530900');
INSERT INTO `mmwl_gpb_area` VALUES ('2650', '530922', '云县', 'area', '530900');
INSERT INTO `mmwl_gpb_area` VALUES ('2651', '530923', '永德县', 'area', '530900');
INSERT INTO `mmwl_gpb_area` VALUES ('2652', '530902', '临翔区', 'area', '530900');
INSERT INTO `mmwl_gpb_area` VALUES ('2653', '530927', '沧源佤族自治县', 'area', '530900');
INSERT INTO `mmwl_gpb_area` VALUES ('2654', '530926', '耿马傣族佤族自治县', 'area', '530900');
INSERT INTO `mmwl_gpb_area` VALUES ('2655', '530924', '镇康县', 'area', '530900');
INSERT INTO `mmwl_gpb_area` VALUES ('2656', '530925', '双江拉祜族佤族布朗族傣族自治县', 'area', '530900');
INSERT INTO `mmwl_gpb_area` VALUES ('2657', '532300', '楚雄彝族自治州', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2658', '532301', '楚雄市', 'area', '532300');
INSERT INTO `mmwl_gpb_area` VALUES ('2659', '532331', '禄丰县', 'area', '532300');
INSERT INTO `mmwl_gpb_area` VALUES ('2660', '532326', '大姚县', 'area', '532300');
INSERT INTO `mmwl_gpb_area` VALUES ('2661', '532329', '武定县', 'area', '532300');
INSERT INTO `mmwl_gpb_area` VALUES ('2662', '532328', '元谋县', 'area', '532300');
INSERT INTO `mmwl_gpb_area` VALUES ('2663', '532324', '南华县', 'area', '532300');
INSERT INTO `mmwl_gpb_area` VALUES ('2664', '532325', '姚安县', 'area', '532300');
INSERT INTO `mmwl_gpb_area` VALUES ('2665', '532322', '双柏县', 'area', '532300');
INSERT INTO `mmwl_gpb_area` VALUES ('2666', '532327', '永仁县', 'area', '532300');
INSERT INTO `mmwl_gpb_area` VALUES ('2667', '532323', '牟定县', 'area', '532300');
INSERT INTO `mmwl_gpb_area` VALUES ('2668', '532500', '红河哈尼族彝族自治州', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2669', '532528', '元阳县', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2670', '532524', '建水县', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2671', '532529', '红河县', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2672', '532530', '金平苗族瑶族傣族自治县', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2673', '532504', '弥勒市', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2674', '532503', '蒙自市', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2675', '532501', '个旧市', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2676', '532531', '绿春县', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2677', '532525', '石屏县', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2678', '532527', '泸西县', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2679', '532502', '开远市', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2680', '532523', '屏边苗族自治县', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2681', '532532', '河口瑶族自治县', 'area', '532500');
INSERT INTO `mmwl_gpb_area` VALUES ('2682', '532600', '文山壮族苗族自治州', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2683', '532627', '广南县', 'area', '532600');
INSERT INTO `mmwl_gpb_area` VALUES ('2684', '532601', '文山市', 'area', '532600');
INSERT INTO `mmwl_gpb_area` VALUES ('2685', '532625', '马关县', 'area', '532600');
INSERT INTO `mmwl_gpb_area` VALUES ('2686', '532628', '富宁县', 'area', '532600');
INSERT INTO `mmwl_gpb_area` VALUES ('2687', '532626', '丘北县', 'area', '532600');
INSERT INTO `mmwl_gpb_area` VALUES ('2688', '532624', '麻栗坡县', 'area', '532600');
INSERT INTO `mmwl_gpb_area` VALUES ('2689', '532622', '砚山县', 'area', '532600');
INSERT INTO `mmwl_gpb_area` VALUES ('2690', '532623', '西畴县', 'area', '532600');
INSERT INTO `mmwl_gpb_area` VALUES ('2691', '532800', '西双版纳傣族自治州', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2692', '532801', '景洪市', 'area', '532800');
INSERT INTO `mmwl_gpb_area` VALUES ('2693', '532822', '勐海县', 'area', '532800');
INSERT INTO `mmwl_gpb_area` VALUES ('2694', '532823', '勐腊县', 'area', '532800');
INSERT INTO `mmwl_gpb_area` VALUES ('2695', '532900', '大理白族自治州', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2696', '532901', '大理市', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2697', '532924', '宾川县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2698', '532929', '云龙县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2699', '532923', '祥云县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2700', '532927', '巍山彝族回族自治县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2701', '532932', '鹤庆县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2702', '532930', '洱源县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2703', '532922', '漾濞彝族自治县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2704', '532926', '南涧彝族自治县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2705', '532931', '剑川县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2706', '532925', '弥渡县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2707', '532928', '永平县', 'area', '532900');
INSERT INTO `mmwl_gpb_area` VALUES ('2708', '533100', '德宏傣族景颇族自治州', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2709', '533123', '盈江县', 'area', '533100');
INSERT INTO `mmwl_gpb_area` VALUES ('2710', '533103', '芒市', 'area', '533100');
INSERT INTO `mmwl_gpb_area` VALUES ('2711', '533122', '梁河县', 'area', '533100');
INSERT INTO `mmwl_gpb_area` VALUES ('2712', '533124', '陇川县', 'area', '533100');
INSERT INTO `mmwl_gpb_area` VALUES ('2713', '533102', '瑞丽市', 'area', '533100');
INSERT INTO `mmwl_gpb_area` VALUES ('2714', '533300', '怒江傈僳族自治州', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2715', '533301', '泸水市', 'area', '533300');
INSERT INTO `mmwl_gpb_area` VALUES ('2716', '533325', '兰坪白族普米族自治县', 'area', '533300');
INSERT INTO `mmwl_gpb_area` VALUES ('2717', '533323', '福贡县', 'area', '533300');
INSERT INTO `mmwl_gpb_area` VALUES ('2718', '533324', '贡山独龙族怒族自治县', 'area', '533300');
INSERT INTO `mmwl_gpb_area` VALUES ('2719', '533400', '迪庆藏族自治州', 'city', '530000');
INSERT INTO `mmwl_gpb_area` VALUES ('2720', '533401', '香格里拉市', 'area', '533400');
INSERT INTO `mmwl_gpb_area` VALUES ('2721', '533423', '维西傈僳族自治县', 'area', '533400');
INSERT INTO `mmwl_gpb_area` VALUES ('2722', '533422', '德钦县', 'area', '533400');
INSERT INTO `mmwl_gpb_area` VALUES ('2723', '540000', '西藏自治区', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('2724', '540100', '拉萨市', 'city', '540000');
INSERT INTO `mmwl_gpb_area` VALUES ('2725', '540102', '城关区', 'area', '540100');
INSERT INTO `mmwl_gpb_area` VALUES ('2726', '540121', '林周县', 'area', '540100');
INSERT INTO `mmwl_gpb_area` VALUES ('2727', '540122', '当雄县', 'area', '540100');
INSERT INTO `mmwl_gpb_area` VALUES ('2728', '540123', '尼木县', 'area', '540100');
INSERT INTO `mmwl_gpb_area` VALUES ('2729', '540127', '墨竹工卡县', 'area', '540100');
INSERT INTO `mmwl_gpb_area` VALUES ('2730', '540103', '堆龙德庆区', 'area', '540100');
INSERT INTO `mmwl_gpb_area` VALUES ('2731', '540126', '达孜县', 'area', '540100');
INSERT INTO `mmwl_gpb_area` VALUES ('2732', '540124', '曲水县', 'area', '540100');
INSERT INTO `mmwl_gpb_area` VALUES ('2733', '540200', '日喀则市', 'city', '540000');
INSERT INTO `mmwl_gpb_area` VALUES ('2734', '540222', '江孜县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2735', '540227', '谢通门县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2736', '540226', '昂仁县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2737', '540221', '南木林县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2738', '540223', '定日县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2739', '540232', '仲巴县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2740', '540202', '桑珠孜区', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2741', '540225', '拉孜县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2742', '540224', '萨迦县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2743', '540228', '白朗县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2744', '540231', '定结县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2745', '540230', '康马县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2746', '540229', '仁布县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2747', '540236', '萨嘎县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2748', '540235', '聂拉木县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2749', '540233', '亚东县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2750', '540234', '吉隆县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2751', '540237', '岗巴县', 'area', '540200');
INSERT INTO `mmwl_gpb_area` VALUES ('2752', '540300', '昌都市', 'city', '540000');
INSERT INTO `mmwl_gpb_area` VALUES ('2753', '540328', '芒康县', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2754', '540302', '卡若区', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2755', '540326', '八宿县', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2756', '540324', '丁青县', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2757', '540321', '江达县', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2758', '540325', '察雅县', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2759', '540322', '贡觉县', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2760', '540329', '洛隆县', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2761', '540330', '边坝县', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2762', '540323', '类乌齐县', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2763', '540327', '左贡县', 'area', '540300');
INSERT INTO `mmwl_gpb_area` VALUES ('2764', '540400', '林芝市', 'city', '540000');
INSERT INTO `mmwl_gpb_area` VALUES ('2765', '540424', '波密县', 'area', '540400');
INSERT INTO `mmwl_gpb_area` VALUES ('2766', '540421', '工布江达县', 'area', '540400');
INSERT INTO `mmwl_gpb_area` VALUES ('2767', '540423', '墨脱县', 'area', '540400');
INSERT INTO `mmwl_gpb_area` VALUES ('2768', '540422', '米林县', 'area', '540400');
INSERT INTO `mmwl_gpb_area` VALUES ('2769', '540425', '察隅县', 'area', '540400');
INSERT INTO `mmwl_gpb_area` VALUES ('2770', '540402', '巴宜区', 'area', '540400');
INSERT INTO `mmwl_gpb_area` VALUES ('2771', '540426', '朗县', 'area', '540400');
INSERT INTO `mmwl_gpb_area` VALUES ('2772', '540500', '山南市', 'city', '540000');
INSERT INTO `mmwl_gpb_area` VALUES ('2773', '540529', '隆子县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2774', '540531', '浪卡子县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2775', '540530', '错那县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2776', '540522', '贡嘎县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2777', '540528', '加查县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2778', '540502', '乃东区', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2779', '540527', '洛扎县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2780', '540521', '扎囊县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2781', '540525', '曲松县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2782', '540526', '措美县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2783', '540524', '琼结县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2784', '540523', '桑日县', 'area', '540500');
INSERT INTO `mmwl_gpb_area` VALUES ('2785', '542400', '那曲地区', 'city', '540000');
INSERT INTO `mmwl_gpb_area` VALUES ('2786', '542430', '尼玛县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2787', '542425', '安多县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2788', '542421', '那曲县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2789', '542424', '聂荣县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2790', '542429', '巴青县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2791', '542427', '索县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2792', '542423', '比如县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2793', '542428', '班戈县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2794', '542422', '嘉黎县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2795', '542426', '申扎县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2796', '542431', '双湖县', 'area', '542400');
INSERT INTO `mmwl_gpb_area` VALUES ('2797', '542500', '阿里地区', 'city', '540000');
INSERT INTO `mmwl_gpb_area` VALUES ('2798', '542526', '改则县', 'area', '542500');
INSERT INTO `mmwl_gpb_area` VALUES ('2799', '542522', '札达县', 'area', '542500');
INSERT INTO `mmwl_gpb_area` VALUES ('2800', '542527', '措勤县', 'area', '542500');
INSERT INTO `mmwl_gpb_area` VALUES ('2801', '542525', '革吉县', 'area', '542500');
INSERT INTO `mmwl_gpb_area` VALUES ('2802', '542523', '噶尔县', 'area', '542500');
INSERT INTO `mmwl_gpb_area` VALUES ('2803', '542524', '日土县', 'area', '542500');
INSERT INTO `mmwl_gpb_area` VALUES ('2804', '542521', '普兰县', 'area', '542500');
INSERT INTO `mmwl_gpb_area` VALUES ('2805', '610000', '陕西省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('2806', '610100', '西安市', 'city', '610000');
INSERT INTO `mmwl_gpb_area` VALUES ('2807', '610116', '长安区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2808', '610115', '临潼区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2809', '610124', '周至县', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2810', '610122', '蓝田县', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2811', '610118', '鄠邑区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2812', '610112', '未央区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2813', '610104', '莲湖区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2814', '610102', '新城区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2815', '610111', '灞桥区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2816', '610103', '碑林区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2817', '610113', '雁塔区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2818', '610114', '阎良区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2819', '610117', '高陵区', 'area', '610100');
INSERT INTO `mmwl_gpb_area` VALUES ('2820', '610200', '铜川市', 'city', '610000');
INSERT INTO `mmwl_gpb_area` VALUES ('2821', '610204', '耀州区', 'area', '610200');
INSERT INTO `mmwl_gpb_area` VALUES ('2822', '610203', '印台区', 'area', '610200');
INSERT INTO `mmwl_gpb_area` VALUES ('2823', '610222', '宜君县', 'area', '610200');
INSERT INTO `mmwl_gpb_area` VALUES ('2824', '610202', '王益区', 'area', '610200');
INSERT INTO `mmwl_gpb_area` VALUES ('2825', '610300', '宝鸡市', 'city', '610000');
INSERT INTO `mmwl_gpb_area` VALUES ('2826', '610304', '陈仓区', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2827', '610322', '凤翔县', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2828', '610303', '金台区', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2829', '610327', '陇县', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2830', '610302', '渭滨区', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2831', '610323', '岐山县', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2832', '610330', '凤县', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2833', '610326', '眉县', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2834', '610324', '扶风县', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2835', '610328', '千阳县', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2836', '610329', '麟游县', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2837', '610331', '太白县', 'area', '610300');
INSERT INTO `mmwl_gpb_area` VALUES ('2838', '610400', '咸阳市', 'city', '610000');
INSERT INTO `mmwl_gpb_area` VALUES ('2839', '610424', '乾县', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2840', '610423', '泾阳县', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2841', '610481', '兴平市', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2842', '610402', '秦都区', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2843', '610425', '礼泉县', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2844', '610404', '渭城区', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2845', '610429', '旬邑县', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2846', '610422', '三原县', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2847', '610427', '彬县', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2848', '610428', '长武县', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2849', '610431', '武功县', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2850', '610430', '淳化县', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2851', '610426', '永寿县', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2852', '610403', '杨陵区', 'area', '610400');
INSERT INTO `mmwl_gpb_area` VALUES ('2853', '610500', '渭南市', 'city', '610000');
INSERT INTO `mmwl_gpb_area` VALUES ('2854', '610502', '临渭区', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2855', '610523', '大荔县', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2856', '610526', '蒲城县', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2857', '610528', '富平县', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2858', '610524', '合阳县', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2859', '610525', '澄城县', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2860', '610503', '华州区', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2861', '610581', '韩城市', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2862', '610527', '白水县', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2863', '610522', '潼关县', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2864', '610582', '华阴市', 'area', '610500');
INSERT INTO `mmwl_gpb_area` VALUES ('2865', '610600', '延安市', 'city', '610000');
INSERT INTO `mmwl_gpb_area` VALUES ('2866', '610602', '宝塔区', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2867', '610622', '延川县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2868', '610623', '子长县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2869', '610626', '吴起县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2870', '610629', '洛川县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2871', '610603', '安塞区', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2872', '610621', '延长县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2873', '610625', '志丹县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2874', '610628', '富县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2875', '610631', '黄龙县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2876', '610630', '宜川县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2877', '610632', '黄陵县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2878', '610627', '甘泉县', 'area', '610600');
INSERT INTO `mmwl_gpb_area` VALUES ('2879', '610700', '汉中市', 'city', '610000');
INSERT INTO `mmwl_gpb_area` VALUES ('2880', '610721', '南郑区', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2881', '610728', '镇巴县', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2882', '610723', '洋县', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2883', '610726', '宁强县', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2884', '610725', '勉县', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2885', '610727', '略阳县', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2886', '610722', '城固县', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2887', '610724', '西乡县', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2888', '610702', '汉台区', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2889', '610729', '留坝县', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2890', '610730', '佛坪县', 'area', '610700');
INSERT INTO `mmwl_gpb_area` VALUES ('2891', '610800', '榆林市', 'city', '610000');
INSERT INTO `mmwl_gpb_area` VALUES ('2892', '610802', '榆阳区', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2893', '610825', '定边县', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2894', '610824', '靖边县', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2895', '610826', '绥德县', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2896', '610881', '神木市', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2897', '610803', '横山区', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2898', '610822', '府谷县', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2899', '610828', '佳县', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2900', '610831', '子洲县', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2901', '610830', '清涧县', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2902', '610827', '米脂县', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2903', '610829', '吴堡县', 'area', '610800');
INSERT INTO `mmwl_gpb_area` VALUES ('2904', '610900', '安康市', 'city', '610000');
INSERT INTO `mmwl_gpb_area` VALUES ('2905', '610902', '汉滨区', 'area', '610900');
INSERT INTO `mmwl_gpb_area` VALUES ('2906', '610928', '旬阳县', 'area', '610900');
INSERT INTO `mmwl_gpb_area` VALUES ('2907', '610924', '紫阳县', 'area', '610900');
INSERT INTO `mmwl_gpb_area` VALUES ('2908', '610925', '岚皋县', 'area', '610900');
INSERT INTO `mmwl_gpb_area` VALUES ('2909', '610929', '白河县', 'area', '610900');
INSERT INTO `mmwl_gpb_area` VALUES ('2910', '610922', '石泉县', 'area', '610900');
INSERT INTO `mmwl_gpb_area` VALUES ('2911', '610923', '宁陕县', 'area', '610900');
INSERT INTO `mmwl_gpb_area` VALUES ('2912', '610926', '平利县', 'area', '610900');
INSERT INTO `mmwl_gpb_area` VALUES ('2913', '610921', '汉阴县', 'area', '610900');
INSERT INTO `mmwl_gpb_area` VALUES ('2914', '610927', '镇坪县', 'area', '610900');
INSERT INTO `mmwl_gpb_area` VALUES ('2915', '611000', '商洛市', 'city', '610000');
INSERT INTO `mmwl_gpb_area` VALUES ('2916', '611002', '商州区', 'area', '611000');
INSERT INTO `mmwl_gpb_area` VALUES ('2917', '611024', '山阳县', 'area', '611000');
INSERT INTO `mmwl_gpb_area` VALUES ('2918', '611021', '洛南县', 'area', '611000');
INSERT INTO `mmwl_gpb_area` VALUES ('2919', '611025', '镇安县', 'area', '611000');
INSERT INTO `mmwl_gpb_area` VALUES ('2920', '611022', '丹凤县', 'area', '611000');
INSERT INTO `mmwl_gpb_area` VALUES ('2921', '611023', '商南县', 'area', '611000');
INSERT INTO `mmwl_gpb_area` VALUES ('2922', '611026', '柞水县', 'area', '611000');
INSERT INTO `mmwl_gpb_area` VALUES ('2923', '620000', '甘肃省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('2924', '620100', '兰州市', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('2925', '620102', '城关区', 'area', '620100');
INSERT INTO `mmwl_gpb_area` VALUES ('2926', '620123', '榆中县', 'area', '620100');
INSERT INTO `mmwl_gpb_area` VALUES ('2927', '620121', '永登县', 'area', '620100');
INSERT INTO `mmwl_gpb_area` VALUES ('2928', '620103', '七里河区', 'area', '620100');
INSERT INTO `mmwl_gpb_area` VALUES ('2929', '620104', '西固区', 'area', '620100');
INSERT INTO `mmwl_gpb_area` VALUES ('2930', '620105', '安宁区', 'area', '620100');
INSERT INTO `mmwl_gpb_area` VALUES ('2931', '620122', '皋兰县', 'area', '620100');
INSERT INTO `mmwl_gpb_area` VALUES ('2932', '620111', '红古区', 'area', '620100');
INSERT INTO `mmwl_gpb_area` VALUES ('2933', '620201', '嘉峪关市', 'area', '620200');
INSERT INTO `mmwl_gpb_area` VALUES ('2934', '620300', '金昌市', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('2935', '620321', '永昌县', 'area', '620300');
INSERT INTO `mmwl_gpb_area` VALUES ('2936', '620302', '金川区', 'area', '620300');
INSERT INTO `mmwl_gpb_area` VALUES ('2937', '620400', '白银市', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('2938', '620422', '会宁县', 'area', '620400');
INSERT INTO `mmwl_gpb_area` VALUES ('2939', '620421', '靖远县', 'area', '620400');
INSERT INTO `mmwl_gpb_area` VALUES ('2940', '620403', '平川区', 'area', '620400');
INSERT INTO `mmwl_gpb_area` VALUES ('2941', '620423', '景泰县', 'area', '620400');
INSERT INTO `mmwl_gpb_area` VALUES ('2942', '620402', '白银区', 'area', '620400');
INSERT INTO `mmwl_gpb_area` VALUES ('2943', '620500', '天水市', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('2944', '620502', '秦州区', 'area', '620500');
INSERT INTO `mmwl_gpb_area` VALUES ('2945', '620503', '麦积区', 'area', '620500');
INSERT INTO `mmwl_gpb_area` VALUES ('2946', '620521', '清水县', 'area', '620500');
INSERT INTO `mmwl_gpb_area` VALUES ('2947', '620522', '秦安县', 'area', '620500');
INSERT INTO `mmwl_gpb_area` VALUES ('2948', '620525', '张家川回族自治县', 'area', '620500');
INSERT INTO `mmwl_gpb_area` VALUES ('2949', '620523', '甘谷县', 'area', '620500');
INSERT INTO `mmwl_gpb_area` VALUES ('2950', '620524', '武山县', 'area', '620500');
INSERT INTO `mmwl_gpb_area` VALUES ('2951', '620600', '武威市', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('2952', '620602', '凉州区', 'area', '620600');
INSERT INTO `mmwl_gpb_area` VALUES ('2953', '620622', '古浪县', 'area', '620600');
INSERT INTO `mmwl_gpb_area` VALUES ('2954', '620623', '天祝藏族自治县', 'area', '620600');
INSERT INTO `mmwl_gpb_area` VALUES ('2955', '620621', '民勤县', 'area', '620600');
INSERT INTO `mmwl_gpb_area` VALUES ('2956', '620702', '甘州区', 'area', '620700');
INSERT INTO `mmwl_gpb_area` VALUES ('2957', '620722', '民乐县', 'area', '620700');
INSERT INTO `mmwl_gpb_area` VALUES ('2958', '620725', '山丹县', 'area', '620700');
INSERT INTO `mmwl_gpb_area` VALUES ('2959', '620724', '高台县', 'area', '620700');
INSERT INTO `mmwl_gpb_area` VALUES ('2960', '620721', '肃南裕固族自治县', 'area', '620700');
INSERT INTO `mmwl_gpb_area` VALUES ('2961', '620723', '临泽县', 'area', '620700');
INSERT INTO `mmwl_gpb_area` VALUES ('2962', '620800', '平凉市', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('2963', '620826', '静宁县', 'area', '620800');
INSERT INTO `mmwl_gpb_area` VALUES ('2964', '620802', '崆峒区', 'area', '620800');
INSERT INTO `mmwl_gpb_area` VALUES ('2965', '620825', '庄浪县', 'area', '620800');
INSERT INTO `mmwl_gpb_area` VALUES ('2966', '620821', '泾川县', 'area', '620800');
INSERT INTO `mmwl_gpb_area` VALUES ('2967', '620822', '灵台县', 'area', '620800');
INSERT INTO `mmwl_gpb_area` VALUES ('2968', '620824', '华亭县', 'area', '620800');
INSERT INTO `mmwl_gpb_area` VALUES ('2969', '620823', '崇信县', 'area', '620800');
INSERT INTO `mmwl_gpb_area` VALUES ('2970', '620900', '酒泉市', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('2971', '620902', '肃州区', 'area', '620900');
INSERT INTO `mmwl_gpb_area` VALUES ('2972', '620981', '玉门市', 'area', '620900');
INSERT INTO `mmwl_gpb_area` VALUES ('2973', '620922', '瓜州县', 'area', '620900');
INSERT INTO `mmwl_gpb_area` VALUES ('2974', '620921', '金塔县', 'area', '620900');
INSERT INTO `mmwl_gpb_area` VALUES ('2975', '620982', '敦煌市', 'area', '620900');
INSERT INTO `mmwl_gpb_area` VALUES ('2976', '620923', '肃北蒙古族自治县', 'area', '620900');
INSERT INTO `mmwl_gpb_area` VALUES ('2977', '620924', '阿克塞哈萨克族自治县', 'area', '620900');
INSERT INTO `mmwl_gpb_area` VALUES ('2978', '621000', '庆阳市', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('2979', '621022', '环县', 'area', '621000');
INSERT INTO `mmwl_gpb_area` VALUES ('2980', '621027', '镇原县', 'area', '621000');
INSERT INTO `mmwl_gpb_area` VALUES ('2981', '621026', '宁县', 'area', '621000');
INSERT INTO `mmwl_gpb_area` VALUES ('2982', '621023', '华池县', 'area', '621000');
INSERT INTO `mmwl_gpb_area` VALUES ('2983', '621021', '庆城县', 'area', '621000');
INSERT INTO `mmwl_gpb_area` VALUES ('2984', '621024', '合水县', 'area', '621000');
INSERT INTO `mmwl_gpb_area` VALUES ('2985', '621002', '西峰区', 'area', '621000');
INSERT INTO `mmwl_gpb_area` VALUES ('2986', '621025', '正宁县', 'area', '621000');
INSERT INTO `mmwl_gpb_area` VALUES ('2987', '621100', '定西市', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('2988', '621102', '安定区', 'area', '621100');
INSERT INTO `mmwl_gpb_area` VALUES ('2989', '621121', '通渭县', 'area', '621100');
INSERT INTO `mmwl_gpb_area` VALUES ('2990', '621124', '临洮县', 'area', '621100');
INSERT INTO `mmwl_gpb_area` VALUES ('2991', '621126', '岷县', 'area', '621100');
INSERT INTO `mmwl_gpb_area` VALUES ('2992', '621122', '陇西县', 'area', '621100');
INSERT INTO `mmwl_gpb_area` VALUES ('2993', '621123', '渭源县', 'area', '621100');
INSERT INTO `mmwl_gpb_area` VALUES ('2994', '621125', '漳县', 'area', '621100');
INSERT INTO `mmwl_gpb_area` VALUES ('2995', '621200', '陇南市', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('2996', '621202', '武都区', 'area', '621200');
INSERT INTO `mmwl_gpb_area` VALUES ('2997', '621226', '礼县', 'area', '621200');
INSERT INTO `mmwl_gpb_area` VALUES ('2998', '621223', '宕昌县', 'area', '621200');
INSERT INTO `mmwl_gpb_area` VALUES ('2999', '621224', '康县', 'area', '621200');
INSERT INTO `mmwl_gpb_area` VALUES ('3000', '621225', '西和县', 'area', '621200');
INSERT INTO `mmwl_gpb_area` VALUES ('3001', '621222', '文县', 'area', '621200');
INSERT INTO `mmwl_gpb_area` VALUES ('3002', '621221', '成县', 'area', '621200');
INSERT INTO `mmwl_gpb_area` VALUES ('3003', '621227', '徽县', 'area', '621200');
INSERT INTO `mmwl_gpb_area` VALUES ('3004', '621228', '两当县', 'area', '621200');
INSERT INTO `mmwl_gpb_area` VALUES ('3005', '622900', '临夏回族自治州', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('3006', '622921', '临夏县', 'area', '622900');
INSERT INTO `mmwl_gpb_area` VALUES ('3007', '622926', '东乡族自治县', 'area', '622900');
INSERT INTO `mmwl_gpb_area` VALUES ('3008', '622927', '积石山保安族东乡族撒拉族自治县', 'area', '622900');
INSERT INTO `mmwl_gpb_area` VALUES ('3009', '622923', '永靖县', 'area', '622900');
INSERT INTO `mmwl_gpb_area` VALUES ('3010', '622922', '康乐县', 'area', '622900');
INSERT INTO `mmwl_gpb_area` VALUES ('3011', '622925', '和政县', 'area', '622900');
INSERT INTO `mmwl_gpb_area` VALUES ('3012', '622901', '临夏市', 'area', '622900');
INSERT INTO `mmwl_gpb_area` VALUES ('3013', '622924', '广河县', 'area', '622900');
INSERT INTO `mmwl_gpb_area` VALUES ('3014', '623000', '甘南藏族自治州', 'city', '620000');
INSERT INTO `mmwl_gpb_area` VALUES ('3015', '623023', '舟曲县', 'area', '623000');
INSERT INTO `mmwl_gpb_area` VALUES ('3016', '623021', '临潭县', 'area', '623000');
INSERT INTO `mmwl_gpb_area` VALUES ('3017', '623022', '卓尼县', 'area', '623000');
INSERT INTO `mmwl_gpb_area` VALUES ('3018', '623027', '夏河县', 'area', '623000');
INSERT INTO `mmwl_gpb_area` VALUES ('3019', '623024', '迭部县', 'area', '623000');
INSERT INTO `mmwl_gpb_area` VALUES ('3020', '623001', '合作市', 'area', '623000');
INSERT INTO `mmwl_gpb_area` VALUES ('3021', '623025', '玛曲县', 'area', '623000');
INSERT INTO `mmwl_gpb_area` VALUES ('3022', '623026', '碌曲县', 'area', '623000');
INSERT INTO `mmwl_gpb_area` VALUES ('3023', '630000', '青海省', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('3024', '630100', '西宁市', 'city', '630000');
INSERT INTO `mmwl_gpb_area` VALUES ('3025', '630121', '大通回族土族自治县', 'area', '630100');
INSERT INTO `mmwl_gpb_area` VALUES ('3026', '630122', '湟中县', 'area', '630100');
INSERT INTO `mmwl_gpb_area` VALUES ('3027', '630123', '湟源县', 'area', '630100');
INSERT INTO `mmwl_gpb_area` VALUES ('3028', '630102', '城东区', 'area', '630100');
INSERT INTO `mmwl_gpb_area` VALUES ('3029', '630104', '城西区', 'area', '630100');
INSERT INTO `mmwl_gpb_area` VALUES ('3030', '630103', '城中区', 'area', '630100');
INSERT INTO `mmwl_gpb_area` VALUES ('3031', '630105', '城北区', 'area', '630100');
INSERT INTO `mmwl_gpb_area` VALUES ('3032', '630200', '海东市', 'city', '630000');
INSERT INTO `mmwl_gpb_area` VALUES ('3033', '630222', '民和回族土族自治县', 'area', '630200');
INSERT INTO `mmwl_gpb_area` VALUES ('3034', '630223', '互助土族自治县', 'area', '630200');
INSERT INTO `mmwl_gpb_area` VALUES ('3035', '630202', '乐都区', 'area', '630200');
INSERT INTO `mmwl_gpb_area` VALUES ('3036', '630224', '化隆回族自治县', 'area', '630200');
INSERT INTO `mmwl_gpb_area` VALUES ('3037', '630225', '循化撒拉族自治县', 'area', '630200');
INSERT INTO `mmwl_gpb_area` VALUES ('3038', '630203', '平安区', 'area', '630200');
INSERT INTO `mmwl_gpb_area` VALUES ('3039', '632200', '海北藏族自治州', 'city', '630000');
INSERT INTO `mmwl_gpb_area` VALUES ('3040', '632221', '门源回族自治县', 'area', '632200');
INSERT INTO `mmwl_gpb_area` VALUES ('3041', '632222', '祁连县', 'area', '632200');
INSERT INTO `mmwl_gpb_area` VALUES ('3042', '632224', '刚察县', 'area', '632200');
INSERT INTO `mmwl_gpb_area` VALUES ('3043', '632223', '海晏县', 'area', '632200');
INSERT INTO `mmwl_gpb_area` VALUES ('3044', '632321', '同仁县', 'area', '632300');
INSERT INTO `mmwl_gpb_area` VALUES ('3045', '632322', '尖扎县', 'area', '632300');
INSERT INTO `mmwl_gpb_area` VALUES ('3046', '632323', '泽库县', 'area', '632300');
INSERT INTO `mmwl_gpb_area` VALUES ('3047', '632324', '河南蒙古族自治县', 'area', '632300');
INSERT INTO `mmwl_gpb_area` VALUES ('3048', '632521', '共和县', 'area', '632500');
INSERT INTO `mmwl_gpb_area` VALUES ('3049', '632525', '贵南县', 'area', '632500');
INSERT INTO `mmwl_gpb_area` VALUES ('3050', '632523', '贵德县', 'area', '632500');
INSERT INTO `mmwl_gpb_area` VALUES ('3051', '632524', '兴海县', 'area', '632500');
INSERT INTO `mmwl_gpb_area` VALUES ('3052', '632522', '同德县', 'area', '632500');
INSERT INTO `mmwl_gpb_area` VALUES ('3053', '632600', '果洛藏族自治州', 'city', '630000');
INSERT INTO `mmwl_gpb_area` VALUES ('3054', '632624', '达日县', 'area', '632600');
INSERT INTO `mmwl_gpb_area` VALUES ('3055', '632622', '班玛县', 'area', '632600');
INSERT INTO `mmwl_gpb_area` VALUES ('3056', '632621', '玛沁县', 'area', '632600');
INSERT INTO `mmwl_gpb_area` VALUES ('3057', '632623', '甘德县', 'area', '632600');
INSERT INTO `mmwl_gpb_area` VALUES ('3058', '632625', '久治县', 'area', '632600');
INSERT INTO `mmwl_gpb_area` VALUES ('3059', '632626', '玛多县', 'area', '632600');
INSERT INTO `mmwl_gpb_area` VALUES ('3060', '632700', '玉树藏族自治州', 'city', '630000');
INSERT INTO `mmwl_gpb_area` VALUES ('3061', '632725', '囊谦县', 'area', '632700');
INSERT INTO `mmwl_gpb_area` VALUES ('3062', '632701', '玉树市', 'area', '632700');
INSERT INTO `mmwl_gpb_area` VALUES ('3063', '632722', '杂多县', 'area', '632700');
INSERT INTO `mmwl_gpb_area` VALUES ('3064', '632723', '称多县', 'area', '632700');
INSERT INTO `mmwl_gpb_area` VALUES ('3065', '632724', '治多县', 'area', '632700');
INSERT INTO `mmwl_gpb_area` VALUES ('3066', '632726', '曲麻莱县', 'area', '632700');
INSERT INTO `mmwl_gpb_area` VALUES ('3067', '632800', '海西蒙古族藏族自治州', 'city', '630000');
INSERT INTO `mmwl_gpb_area` VALUES ('3068', '632801', '格尔木市', 'area', '632800');
INSERT INTO `mmwl_gpb_area` VALUES ('3069', '632823', '天峻县', 'area', '632800');
INSERT INTO `mmwl_gpb_area` VALUES ('3070', '632822', '都兰县', 'area', '632800');
INSERT INTO `mmwl_gpb_area` VALUES ('3071', '632802', '德令哈市', 'area', '632800');
INSERT INTO `mmwl_gpb_area` VALUES ('3072', '632821', '乌兰县', 'area', '632800');
INSERT INTO `mmwl_gpb_area` VALUES ('3073', '632859', '茫崖行政委员会', 'area', '632800');
INSERT INTO `mmwl_gpb_area` VALUES ('3074', '632857', '大柴旦行政委员会', 'area', '632800');
INSERT INTO `mmwl_gpb_area` VALUES ('3075', '632858', '冷湖行政委员会', 'area', '632800');
INSERT INTO `mmwl_gpb_area` VALUES ('3076', '640000', '宁夏回族自治区', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('3077', '640100', '银川市', 'city', '640000');
INSERT INTO `mmwl_gpb_area` VALUES ('3078', '640104', '兴庆区', 'area', '640100');
INSERT INTO `mmwl_gpb_area` VALUES ('3079', '640181', '灵武市', 'area', '640100');
INSERT INTO `mmwl_gpb_area` VALUES ('3080', '640122', '贺兰县', 'area', '640100');
INSERT INTO `mmwl_gpb_area` VALUES ('3081', '640105', '西夏区', 'area', '640100');
INSERT INTO `mmwl_gpb_area` VALUES ('3082', '640121', '永宁县', 'area', '640100');
INSERT INTO `mmwl_gpb_area` VALUES ('3083', '640106', '金凤区', 'area', '640100');
INSERT INTO `mmwl_gpb_area` VALUES ('3084', '640200', '石嘴山市', 'city', '640000');
INSERT INTO `mmwl_gpb_area` VALUES ('3085', '640205', '惠农区', 'area', '640200');
INSERT INTO `mmwl_gpb_area` VALUES ('3086', '640221', '平罗县', 'area', '640200');
INSERT INTO `mmwl_gpb_area` VALUES ('3087', '640202', '大武口区', 'area', '640200');
INSERT INTO `mmwl_gpb_area` VALUES ('3088', '640300', '吴忠市', 'city', '640000');
INSERT INTO `mmwl_gpb_area` VALUES ('3089', '640302', '利通区', 'area', '640300');
INSERT INTO `mmwl_gpb_area` VALUES ('3090', '640324', '同心县', 'area', '640300');
INSERT INTO `mmwl_gpb_area` VALUES ('3091', '640381', '青铜峡市', 'area', '640300');
INSERT INTO `mmwl_gpb_area` VALUES ('3092', '640323', '盐池县', 'area', '640300');
INSERT INTO `mmwl_gpb_area` VALUES ('3093', '640303', '红寺堡区', 'area', '640300');
INSERT INTO `mmwl_gpb_area` VALUES ('3094', '640400', '固原市', 'city', '640000');
INSERT INTO `mmwl_gpb_area` VALUES ('3095', '640422', '西吉县', 'area', '640400');
INSERT INTO `mmwl_gpb_area` VALUES ('3096', '640423', '隆德县', 'area', '640400');
INSERT INTO `mmwl_gpb_area` VALUES ('3097', '640402', '原州区', 'area', '640400');
INSERT INTO `mmwl_gpb_area` VALUES ('3098', '640425', '彭阳县', 'area', '640400');
INSERT INTO `mmwl_gpb_area` VALUES ('3099', '640424', '泾源县', 'area', '640400');
INSERT INTO `mmwl_gpb_area` VALUES ('3100', '640500', '中卫市', 'city', '640000');
INSERT INTO `mmwl_gpb_area` VALUES ('3101', '640522', '海原县', 'area', '640500');
INSERT INTO `mmwl_gpb_area` VALUES ('3102', '640502', '沙坡头区', 'area', '640500');
INSERT INTO `mmwl_gpb_area` VALUES ('3103', '640521', '中宁县', 'area', '640500');
INSERT INTO `mmwl_gpb_area` VALUES ('3104', '650000', '新疆维吾尔自治区', 'province', '0');
INSERT INTO `mmwl_gpb_area` VALUES ('3105', '650100', '乌鲁木齐市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3106', '650104', '新市区', 'area', '650100');
INSERT INTO `mmwl_gpb_area` VALUES ('3107', '650109', '米东区', 'area', '650100');
INSERT INTO `mmwl_gpb_area` VALUES ('3108', '650102', '天山区', 'area', '650100');
INSERT INTO `mmwl_gpb_area` VALUES ('3109', '650103', '沙依巴克区', 'area', '650100');
INSERT INTO `mmwl_gpb_area` VALUES ('3110', '650107', '达坂城区', 'area', '650100');
INSERT INTO `mmwl_gpb_area` VALUES ('3111', '650105', '水磨沟区', 'area', '650100');
INSERT INTO `mmwl_gpb_area` VALUES ('3112', '650106', '头屯河区', 'area', '650100');
INSERT INTO `mmwl_gpb_area` VALUES ('3113', '650121', '乌鲁木齐县', 'area', '650100');
INSERT INTO `mmwl_gpb_area` VALUES ('3114', '650200', '克拉玛依市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3115', '650203', '克拉玛依区', 'area', '650200');
INSERT INTO `mmwl_gpb_area` VALUES ('3116', '650205', '乌尔禾区', 'area', '650200');
INSERT INTO `mmwl_gpb_area` VALUES ('3117', '650202', '独山子区', 'area', '650200');
INSERT INTO `mmwl_gpb_area` VALUES ('3118', '650204', '白碱滩区', 'area', '650200');
INSERT INTO `mmwl_gpb_area` VALUES ('3119', '650400', '吐鲁番市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3120', '650402', '高昌区', 'area', '650400');
INSERT INTO `mmwl_gpb_area` VALUES ('3121', '650421', '鄯善县', 'area', '650400');
INSERT INTO `mmwl_gpb_area` VALUES ('3122', '650422', '托克逊县', 'area', '650400');
INSERT INTO `mmwl_gpb_area` VALUES ('3123', '650500', '哈密市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3124', '650502', '伊州区', 'area', '650500');
INSERT INTO `mmwl_gpb_area` VALUES ('3125', '650521', '巴里坤哈萨克自治县', 'area', '650500');
INSERT INTO `mmwl_gpb_area` VALUES ('3126', '650522', '伊吾县', 'area', '650500');
INSERT INTO `mmwl_gpb_area` VALUES ('3127', '652300', '昌吉回族自治州', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3128', '652325', '奇台县', 'area', '652300');
INSERT INTO `mmwl_gpb_area` VALUES ('3129', '652324', '玛纳斯县', 'area', '652300');
INSERT INTO `mmwl_gpb_area` VALUES ('3130', '652301', '昌吉市', 'area', '652300');
INSERT INTO `mmwl_gpb_area` VALUES ('3131', '652323', '呼图壁县', 'area', '652300');
INSERT INTO `mmwl_gpb_area` VALUES ('3132', '652302', '阜康市', 'area', '652300');
INSERT INTO `mmwl_gpb_area` VALUES ('3133', '652327', '吉木萨尔县', 'area', '652300');
INSERT INTO `mmwl_gpb_area` VALUES ('3134', '652328', '木垒哈萨克自治县', 'area', '652300');
INSERT INTO `mmwl_gpb_area` VALUES ('3135', '652700', '博尔塔拉蒙古自治州', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3136', '652701', '博乐市', 'area', '652700');
INSERT INTO `mmwl_gpb_area` VALUES ('3137', '652723', '温泉县', 'area', '652700');
INSERT INTO `mmwl_gpb_area` VALUES ('3138', '652722', '精河县', 'area', '652700');
INSERT INTO `mmwl_gpb_area` VALUES ('3139', '652702', '阿拉山口市', 'area', '652700');
INSERT INTO `mmwl_gpb_area` VALUES ('3140', '652800', '巴音郭楞蒙古自治州', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3141', '652801', '库尔勒市', 'area', '652800');
INSERT INTO `mmwl_gpb_area` VALUES ('3142', '652827', '和静县', 'area', '652800');
INSERT INTO `mmwl_gpb_area` VALUES ('3143', '652825', '且末县', 'area', '652800');
INSERT INTO `mmwl_gpb_area` VALUES ('3144', '652822', '轮台县', 'area', '652800');
INSERT INTO `mmwl_gpb_area` VALUES ('3145', '652826', '焉耆回族自治县', 'area', '652800');
INSERT INTO `mmwl_gpb_area` VALUES ('3146', '652824', '若羌县', 'area', '652800');
INSERT INTO `mmwl_gpb_area` VALUES ('3147', '652823', '尉犁县', 'area', '652800');
INSERT INTO `mmwl_gpb_area` VALUES ('3148', '652828', '和硕县', 'area', '652800');
INSERT INTO `mmwl_gpb_area` VALUES ('3149', '652829', '博湖县', 'area', '652800');
INSERT INTO `mmwl_gpb_area` VALUES ('3150', '652900', '阿克苏地区', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3151', '652923', '库车县', 'area', '652900');
INSERT INTO `mmwl_gpb_area` VALUES ('3152', '652922', '温宿县', 'area', '652900');
INSERT INTO `mmwl_gpb_area` VALUES ('3153', '652926', '拜城县', 'area', '652900');
INSERT INTO `mmwl_gpb_area` VALUES ('3154', '652901', '阿克苏市', 'area', '652900');
INSERT INTO `mmwl_gpb_area` VALUES ('3155', '652927', '乌什县', 'area', '652900');
INSERT INTO `mmwl_gpb_area` VALUES ('3156', '652928', '阿瓦提县', 'area', '652900');
INSERT INTO `mmwl_gpb_area` VALUES ('3157', '652924', '沙雅县', 'area', '652900');
INSERT INTO `mmwl_gpb_area` VALUES ('3158', '652925', '新和县', 'area', '652900');
INSERT INTO `mmwl_gpb_area` VALUES ('3159', '652929', '柯坪县', 'area', '652900');
INSERT INTO `mmwl_gpb_area` VALUES ('3160', '653000', '克孜勒苏柯尔克孜自治州', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3161', '653022', '阿克陶县', 'area', '653000');
INSERT INTO `mmwl_gpb_area` VALUES ('3162', '653024', '乌恰县', 'area', '653000');
INSERT INTO `mmwl_gpb_area` VALUES ('3163', '653001', '阿图什市', 'area', '653000');
INSERT INTO `mmwl_gpb_area` VALUES ('3164', '653023', '阿合奇县', 'area', '653000');
INSERT INTO `mmwl_gpb_area` VALUES ('3165', '653100', '喀什地区', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3166', '653125', '莎车县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3167', '653126', '叶城县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3168', '653122', '疏勒县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3169', '653101', '喀什市', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3170', '653123', '英吉沙县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3171', '653124', '泽普县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3172', '653129', '伽师县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3173', '653131', '塔什库尔干塔吉克自治县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3174', '653130', '巴楚县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3175', '653127', '麦盖提县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3176', '653121', '疏附县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3177', '653128', '岳普湖县', 'area', '653100');
INSERT INTO `mmwl_gpb_area` VALUES ('3178', '653200', '和田地区', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3179', '653222', '墨玉县', 'area', '653200');
INSERT INTO `mmwl_gpb_area` VALUES ('3180', '653223', '皮山县', 'area', '653200');
INSERT INTO `mmwl_gpb_area` VALUES ('3181', '653226', '于田县', 'area', '653200');
INSERT INTO `mmwl_gpb_area` VALUES ('3182', '653221', '和田县', 'area', '653200');
INSERT INTO `mmwl_gpb_area` VALUES ('3183', '653201', '和田市', 'area', '653200');
INSERT INTO `mmwl_gpb_area` VALUES ('3184', '653224', '洛浦县', 'area', '653200');
INSERT INTO `mmwl_gpb_area` VALUES ('3185', '653225', '策勒县', 'area', '653200');
INSERT INTO `mmwl_gpb_area` VALUES ('3186', '653227', '民丰县', 'area', '653200');
INSERT INTO `mmwl_gpb_area` VALUES ('3187', '659009', '昆玉市', 'area', '653200');
INSERT INTO `mmwl_gpb_area` VALUES ('3188', '654000', '伊犁哈萨克自治州', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3189', '654021', '伊宁县', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3190', '654002', '伊宁市', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3191', '654026', '昭苏县', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3192', '654022', '察布查尔锡伯自治县', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3193', '654028', '尼勒克县', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3194', '654023', '霍城县', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3195', '654024', '巩留县', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3196', '654025', '新源县', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3197', '654027', '特克斯县', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3198', '654003', '奎屯市', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3199', '654004', '霍尔果斯市', 'area', '654000');
INSERT INTO `mmwl_gpb_area` VALUES ('3200', '654200', '塔城地区', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3201', '654202', '乌苏市', 'area', '654200');
INSERT INTO `mmwl_gpb_area` VALUES ('3202', '654223', '沙湾县', 'area', '654200');
INSERT INTO `mmwl_gpb_area` VALUES ('3203', '654221', '额敏县', 'area', '654200');
INSERT INTO `mmwl_gpb_area` VALUES ('3204', '654201', '塔城市', 'area', '654200');
INSERT INTO `mmwl_gpb_area` VALUES ('3205', '654226', '和布克赛尔蒙古自治县', 'area', '654200');
INSERT INTO `mmwl_gpb_area` VALUES ('3206', '654225', '裕民县', 'area', '654200');
INSERT INTO `mmwl_gpb_area` VALUES ('3207', '654224', '托里县', 'area', '654200');
INSERT INTO `mmwl_gpb_area` VALUES ('3208', '654300', '阿勒泰地区', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3209', '654301', '阿勒泰市', 'area', '654300');
INSERT INTO `mmwl_gpb_area` VALUES ('3210', '654322', '富蕴县', 'area', '654300');
INSERT INTO `mmwl_gpb_area` VALUES ('3211', '654324', '哈巴河县', 'area', '654300');
INSERT INTO `mmwl_gpb_area` VALUES ('3212', '654323', '福海县', 'area', '654300');
INSERT INTO `mmwl_gpb_area` VALUES ('3213', '654326', '吉木乃县', 'area', '654300');
INSERT INTO `mmwl_gpb_area` VALUES ('3214', '654321', '布尔津县', 'area', '654300');
INSERT INTO `mmwl_gpb_area` VALUES ('3215', '654325', '青河县', 'area', '654300');
INSERT INTO `mmwl_gpb_area` VALUES ('3216', '659001', '石河子市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3217', '659002', '阿拉尔市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3218', '659003', '图木舒克市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3219', '659004', '五家渠市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3220', '659005', '北屯市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3221', '659007', '双河市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3222', '659008', '可克达拉市', 'city', '650000');
INSERT INTO `mmwl_gpb_area` VALUES ('3223', '110100', '北京市', 'city', '110000');
INSERT INTO `mmwl_gpb_area` VALUES ('3224', '120100', '天津市', 'city', '120000');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  PRIMARY KEY (`gbm_id`)
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
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_config 
-- ----------------------------
INSERT INTO `mmwl_gpb_config` VALUES ('1', '是否开启分销', '', '8', '1563416832', '2', '1', 'distribution_state');
INSERT INTO `mmwl_gpb_config` VALUES ('2', '自身购买佣金比例(%)', '', '8', '1563416832', '2', '1', 'distribution_leader_parsent');
INSERT INTO `mmwl_gpb_config` VALUES ('3', '一级佣金比例(%)', '', '8', '1563416832', '2', '1', 'distribution_lv1_parsent');
INSERT INTO `mmwl_gpb_config` VALUES ('4', '二级佣金比例(%)', '', '8', '1563416832', '2', '1', 'distribution_lv2_parsent');
INSERT INTO `mmwl_gpb_config` VALUES ('5', '三级佣金比例(%)', '', '8', '1563416832', '2', '1', 'distribution_lv3_parsent');
INSERT INTO `mmwl_gpb_config` VALUES ('6', '自身佣金固定金额(元)', '', '8', '1563416832', '2', '1', 'distribution_leader_fixed');
INSERT INTO `mmwl_gpb_config` VALUES ('7', '一级佣金固定金额(元)', '', '8', '1563416832', '2', '1', 'distribution_lv1_fixed');
INSERT INTO `mmwl_gpb_config` VALUES ('8', '二级佣金固定金额(元)', '', '8', '1563416832', '2', '1', 'distribution_lv2_fixed');
INSERT INTO `mmwl_gpb_config` VALUES ('9', '三级佣金固定金额(元)', '', '8', '1563416832', '2', '1', 'distribution_lv3_fixed');
INSERT INTO `mmwl_gpb_config` VALUES ('10', '推荐奖是否开启', '', '8', '1563416832', '2', '1', 'distribution_commoned_state');
INSERT INTO `mmwl_gpb_config` VALUES ('11', '推荐奖条件', 's:0:"";', '8', '1563416832', '2', '1', 'distribution_commoned_condition');
INSERT INTO `mmwl_gpb_config` VALUES ('12', '推荐奖满足条件', 's:0:"";', '8', '1563416832', '2', '1', 'distribution_commoned_value');
INSERT INTO `mmwl_gpb_config` VALUES ('13', '分销等级', '', '8', '1563416832', '2', '1', 'distribution_lv');
INSERT INTO `mmwl_gpb_config` VALUES ('14', '分佣类型', '', '8', '1563416832', '2', '1', 'distribution_type');
INSERT INTO `mmwl_gpb_config` VALUES ('15', '自身是否分佣', '', '8', '1563416832', '2', '1', 'distribution_isself');
INSERT INTO `mmwl_gpb_config` VALUES ('16', '推荐奖金额', '', '8', '1563416832', '2', '1', 'distribution_commoned_money');
INSERT INTO `mmwl_gpb_config` VALUES ('17', '审核设置', '', '8', '1563416832', '2', '1', 'distribution_exa');
INSERT INTO `mmwl_gpb_config` VALUES ('18', '提现说明', '', '8', '1563416832', '2', '1', 'distribution_cash_comment');
INSERT INTO `mmwl_gpb_config` VALUES ('19', '提现手续费', '', '8', '1563416832', '2', '1', 'distribution_cash_charge');
INSERT INTO `mmwl_gpb_config` VALUES ('20', '后台名称', '', '8', '1563416832', '2', '1', 'distribution_site_name');
INSERT INTO `mmwl_gpb_config` VALUES ('21', '分销推广海报背景图', '/addons/group_buy/public/bg/distribution_playbill_img.jpg', '8', '1563416832', '2', '1', 'distribution_playbill_img');
INSERT INTO `mmwl_gpb_config` VALUES ('22', '分销申请顶部图片', '', '8', '1563416832', '2', '1', 'distribution_put_pic');
INSERT INTO `mmwl_gpb_config` VALUES ('23', '分销申请按钮', '', '8', '1563416832', '2', '1', 'distribution_put_btn');
INSERT INTO `mmwl_gpb_config` VALUES ('24', '分销申请', '', '8', '1563416832', '2', '1', 'distribution_put_comment');
INSERT INTO `mmwl_gpb_config` VALUES ('25', '用户中心自定义diy系统数据', 'a:2:{s:5:"basic";a:5:{s:2:"id";s:7:"0000000";s:4:"name";s:14:"memberdiybasic";s:5:"title";s:12:"用户中心";s:11:"head_bg_img";s:56:"https://127.0.0.35/addons/group_buy/public/bg/topbg1.png";s:5:"order";a:5:{s:5:"icon1";s:61:"https://127.0.0.35/addons/group_buy/public/bg/needPayIcon.png";s:5:"icon2";s:56:"https://127.0.0.35/addons/group_buy/public/bg/undeli.png";s:5:"icon3";s:66:"https://127.0.0.35/addons/group_buy/public/bg/distributionIcon.png";s:5:"icon4";s:62:"https://127.0.0.35/addons/group_buy/public/bg/completeIcon.png";s:5:"icon5";s:60:"https://127.0.0.35/addons/group_buy/public/bg/refundIcon.png";}}s:4:"data";a:2:{i:0;a:5:{s:2:"id";s:7:"0000000";s:4:"name";s:14:"memberdiybasic";s:5:"title";s:12:"用户中心";s:11:"head_bg_img";s:56:"https://127.0.0.35/addons/group_buy/public/bg/topbg1.png";s:5:"order";a:5:{s:5:"icon1";s:61:"https://127.0.0.35/addons/group_buy/public/bg/needPayIcon.png";s:5:"icon2";s:56:"https://127.0.0.35/addons/group_buy/public/bg/undeli.png";s:5:"icon3";s:66:"https://127.0.0.35/addons/group_buy/public/bg/distributionIcon.png";s:5:"icon4";s:62:"https://127.0.0.35/addons/group_buy/public/bg/completeIcon.png";s:5:"icon5";s:60:"https://127.0.0.35/addons/group_buy/public/bg/refundIcon.png";}}i:1;a:3:{s:2:"id";s:14:"m1561703606318";s:4:"name";s:10:"membermenu";s:6:"params";a:2:{s:4:"type";s:1:"1";s:4:"data";a:13:{i:0;a:6:{s:2:"id";s:8:"00000001";s:3:"img";s:56:"https://127.0.0.35/addons/group_buy/public/bg/coupon.png";s:4:"type";s:3:"url";s:3:"key";s:6:"coupon";s:8:"url_name";s:15:"优惠卷大厅";s:3:"url";s:26:"/pages/template/couponHall";}i:1;a:6:{s:2:"id";s:14:"g1561704309626";s:3:"img";s:59:"https://127.0.0.35/addons/group_buy/public/bg/my_coupon.png";s:3:"url";s:22:"/pages/template/coupon";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:15:"我的优惠卷";}i:2;a:6:{s:2:"id";s:14:"g1561704323041";s:3:"img";s:61:"https://127.0.0.35/addons/group_buy/public/bg/select_head.png";s:3:"url";s:22:"/pages/group/groupList";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"选择团长";}i:3;a:6:{s:2:"id";s:14:"g1561704329201";s:3:"img";s:61:"https://127.0.0.35/addons/group_buy/public/bg/head_mannge.png";s:3:"url";s:24:"/pages/groupCenter/index";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"团长管理";}i:4;a:6:{s:2:"id";s:14:"g1561704543879";s:3:"img";s:61:"https://127.0.0.35/addons/group_buy/public/bg/head_mannge.png";s:3:"url";s:23:"/pages/group/groupApply";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"申请团长";}i:5;a:6:{s:2:"id";s:14:"g1561704558086";s:3:"img";s:59:"https://127.0.0.35/addons/group_buy/public/bg/head_info.png";s:3:"url";s:25:"/pages/personal/groupInfo";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"团长信息";}i:6;a:6:{s:2:"id";s:14:"g1561704564270";s:3:"img";s:65:"https://127.0.0.35/addons/group_buy/public/bg/fraction_center.png";s:3:"url";s:31:"/pages/integralMall/index/index";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"积分商城";}i:7;a:6:{s:2:"id";s:14:"g1561704576351";s:3:"img";s:69:"https://127.0.0.35/addons/group_buy/public/bg/distribution_center.png";s:3:"url";s:23:"/pages/commission/index";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"分销中心";}i:8;a:6:{s:2:"id";s:14:"g1561704588007";s:3:"img";s:64:"https://127.0.0.35/addons/group_buy/public/bg/apply_suppiler.png";s:3:"url";s:27:"/pages/personal/supplierInt";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:15:"供应商招募";}i:9;a:6:{s:2:"id";s:14:"g1561704598063";s:3:"img";s:76:"https://127.0.0.35/addons/group_buy/public/bg/frequently_asked_questions.png";s:3:"url";s:25:"/pages/personal/questions";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"常见问题";}i:10;a:6:{s:2:"id";s:14:"g1561704607175";s:3:"img";s:69:"https://127.0.0.35/addons/group_buy/public/bg/qualification_rules.png";s:3:"url";s:29:"/pages/personal/qualification";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"资质规则";}i:11;a:6:{s:2:"id";s:14:"g1561704642238";s:3:"img";s:61:"https://127.0.0.35/addons/group_buy/public/bg/link_custom.png";s:3:"url";s:12:"跳转客服";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"联系客服";}i:12;a:6:{s:2:"id";s:14:"g1561704653854";s:3:"img";s:64:"https://127.0.0.35/addons/group_buy/public/bg/integral_check.png";s:3:"url";s:20:"/pages/checkIn/index";s:5:"title";s:0:"";s:4:"type";s:3:"url";s:8:"url_name";s:12:"积分签到";}}}}}}', '25', '1563416849', '0', '1', 'member_diys_data_set_system');
INSERT INTO `mmwl_gpb_config` VALUES ('26', '后台左上角标题设置', '', '6', '1563421805', '2', '1', 'back_title_set');
INSERT INTO `mmwl_gpb_config` VALUES ('27', '后台左上角显示类型', '1', '6', '1563421805', '2', '1', 'back_set_type');
INSERT INTO `mmwl_gpb_config` VALUES ('28', '后台左上角图标设置', '', '6', '1563421805', '2', '1', 'back_icon_set');
INSERT INTO `mmwl_gpb_config` VALUES ('29', '客服电话', '', '1', '1563421805', '2', '1', 'sever_phone');
INSERT INTO `mmwl_gpb_config` VALUES ('30', '支付商户号', 'asdf2134fads-=', '1', '1563421805', '2', '1', 'pay_mchid');
INSERT INTO `mmwl_gpb_config` VALUES ('31', 'API密钥', 'sdfewrgm-==-a', '1', '1563421805', '2', '1', 'app_key');
INSERT INTO `mmwl_gpb_config` VALUES ('32', '证书路径', '', '1', '1563416868', '2', '1', 'cert_address');
INSERT INTO `mmwl_gpb_config` VALUES ('33', '密钥路径', '', '1', '1563416868', '2', '1', 'key_address');
INSERT INTO `mmwl_gpb_config` VALUES ('34', '团长排行榜', 'a:1:{i:0;a:2:{s:6:"status";i:10;s:4:"name";s:6:"周榜";}}', '1', '1563421805', '2', '1', 'team_rank');
INSERT INTO `mmwl_gpb_config` VALUES ('35', '首页分享出去的标题类型', '1', '1', '1563421805', '2', '1', 'index_share_title_type');
INSERT INTO `mmwl_gpb_config` VALUES ('36', '首页分享出去的自定义标题内容', '', '1', '1563421805', '2', '1', 'index_share_title');
INSERT INTO `mmwl_gpb_config` VALUES ('37', '首页分享出去的图片类型', '1', '1', '1563421805', '2', '1', 'index_share_img_type');
INSERT INTO `mmwl_gpb_config` VALUES ('38', '首页分享出去的自定义图片', '', '1', '1563421805', '2', '1', 'index_share_img');
INSERT INTO `mmwl_gpb_config` VALUES ('39', '是否显示首页分类页数据加载完的底部图片', '1', '1', '1563421805', '2', '1', 'data_end_show_img_open');
INSERT INTO `mmwl_gpb_config` VALUES ('40', '首页分类页数据加载完的底部图', '/addons/group_buy/public/bg/footer_nomore.png', '1', '1563421805', '2', '1', 'data_end_show_img');
INSERT INTO `mmwl_gpb_config` VALUES ('41', '加载未完成时的默认图片（大）', '/addons/group_buy/public/bg/tmp_big.png', '1', '1563421805', '2', '1', 'default_big_img');
INSERT INTO `mmwl_gpb_config` VALUES ('42', '加载未完成时的默认图片（小）', '/addons/group_buy/public/bg/tmp_small.png', '1', '1563421805', '2', '1', 'default_small_img');
INSERT INTO `mmwl_gpb_config` VALUES ('43', '个人中心是否显示积分商城', '1', '1', '1563421805', '2', '1', 'member_sroce_show');
INSERT INTO `mmwl_gpb_config` VALUES ('44', '个人中心是否显示分销商城', '1', '1', '1563421805', '2', '1', 'member_distribution_show');
INSERT INTO `mmwl_gpb_config` VALUES ('45', '自定义社区或小区名称', '社区', '1', '1563421805', '2', '1', 'diy_community_name');
INSERT INTO `mmwl_gpb_config` VALUES ('46', '支付成功通知模版id及内容', '', '2', '1563416943', '2', '1', 'sms_pay');
INSERT INTO `mmwl_gpb_config` VALUES ('47', '短信的key,serect,签名', '', '2', '1563416943', '2', '1', 'sms_data');
INSERT INTO `mmwl_gpb_config` VALUES ('48', '退款通知模版id及内容', '', '2', '1563416943', '2', '1', 'sms_refud');
INSERT INTO `mmwl_gpb_config` VALUES ('49', '短信接受管理员', '', '2', '1563416943', '2', '1', 'sms_admin');
INSERT INTO `mmwl_gpb_config` VALUES ('50', '申请团长通知模版id及内容', '', '2', '1563416943', '2', '1', 'sms_watir');
INSERT INTO `mmwl_gpb_config` VALUES ('51', '短信类型', '1', '2', '1563416943', '2', '1', 'sms_code');
INSERT INTO `mmwl_gpb_config` VALUES ('52', '是否启用短信', '1', '2', '1563416943', '2', '1', 'sms_type');
INSERT INTO `mmwl_gpb_config` VALUES ('53', '提现通知模版id及内容', '', '2', '1563416943', '2', '1', 'sms_get_cash');
INSERT INTO `mmwl_gpb_config` VALUES ('54', '打印机设置', '', '8', '1563416948', '2', '1', 'print_set');
INSERT INTO `mmwl_gpb_config` VALUES ('55', '首页海报分享背景图', '/addons/group_buy/public/bg/index_playbill_bg.jpg', '11', '1564129140', '2', '1', 'index_playbill_img');
INSERT INTO `mmwl_gpb_config` VALUES ('56', '首页海报分享商品', '0', '11', '1564129140', '2', '1', 'index_playbill_goods');
INSERT INTO `mmwl_gpb_config` VALUES ('57', '详情页活动及价格背景', '', '10', '1564129147', '2', '1', 'goods_info_action_price_bg');
INSERT INTO `mmwl_gpb_config` VALUES ('58', '是否开启首图视频显示', '1', '10', '1564129147', '2', '1', 'is_open_goods_video');
INSERT INTO `mmwl_gpb_config` VALUES ('59', '详情页服务说明描述', '', '10', '1564129147', '2', '1', 'goods_info_sever_des');
INSERT INTO `mmwl_gpb_config` VALUES ('60', '商品分类页是否开启搜索', '', '10', '1564129147', '2', '1', 'goods_cate_open_search');
INSERT INTO `mmwl_gpb_config` VALUES ('61', '商品详情页是否显示邻居购买', '1', '10', '1564129147', '2', '1', 'goods_info_open_near');
INSERT INTO `mmwl_gpb_config` VALUES ('62', '商品详情页微信分享的背景图', '/addons/group_buy/public/bg/goods_info_share_bg.jpg', '10', '1564129147', '2', '1', 'goods_info_share_bg');
INSERT INTO `mmwl_gpb_config` VALUES ('63', '商品详情页海报分享的背景图', '/addons/group_buy/public/bg/goods_info_playbill_bg.jpg', '10', '1564129147', '2', '1', 'goods_info_playbill_bg');
INSERT INTO `mmwl_gpb_config` VALUES ('64', '商品详情页秒杀图标', '/addons/group_buy/public/bg/seckill_goods_info_icon.png', '10', '1564129147', '2', '1', 'goods_info_seckill_icon');
INSERT INTO `mmwl_gpb_config` VALUES ('65', '商品详情页秒杀价格背景色', '#fde529', '10', '1564129147', '2', '1', 'goods_info_seckill_price_bg');
INSERT INTO `mmwl_gpb_config` VALUES ('66', '商品分类页面显示内容', '1', '10', '1564129147', '2', '1', 'goods_cate_show_type');
INSERT INTO `mmwl_gpb_config` VALUES ('67', '商品详情页面能否点击进入购买记录页', '1', '10', '1564129147', '2', '1', 'open_see_buypeople_info');
INSERT INTO `mmwl_gpb_config` VALUES ('68', '快递鸟商户ID', '', '12', '1564218208', '2', '1', 'express_bird_id');
INSERT INTO `mmwl_gpb_config` VALUES ('69', '快递鸟API KEY', '', '12', '1564218208', '2', '1', 'express_bird_key');
INSERT INTO `mmwl_gpb_config` VALUES ('70', '是否开启快递', '2', '12', '1564218208', '2', '1', 'is_open_express');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_diy_page 
-- ----------------------------
INSERT INTO `mmwl_gpb_diy_page` VALUES ('1', '0', 'a:2:{s:4:"data";a:6:{i:0;a:3:{s:2:"id";s:14:"m1548983827233";s:4:"name";s:4:"head";s:6:"params";a:11:{s:11:"head_module";s:1:"3";s:7:"content";s:0:"";s:11:"showAddress";s:1:"0";s:9:"rightTpye";s:1:"1";s:7:"incolor";s:7:"#eeeeee";s:12:"border_color";s:7:"#eeeeee";s:7:"bgcolor";s:7:"#ffffff";s:4:"text";s:12:"搜索商品";s:10:"text_color";s:7:"#cccccc";s:13:"border_radius";s:2:"12";s:12:"search_width";s:2:"76";}}i:1;a:3:{s:2:"id";s:14:"m1548983995047";s:4:"name";s:5:"slide";s:6:"params";a:14:{s:8:"ischange";s:1:"0";s:10:"changetime";s:1:"3";s:10:"changelast";s:3:"500";s:10:"pointcolor";s:7:"#dddddd";s:8:"actcolor";s:7:"#22c397";s:9:"showpoint";s:1:"0";s:6:"height";s:3:"150";s:4:"data";a:3:{i:0;a:5:{s:2:"id";s:8:"00000001";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/supplier";s:8:"url_name";s:18:"申请供应商页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/y89ThvIIA6tc2HSSHY5JKvavCsJ8eV.png";}i:1;a:5:{s:2:"id";s:14:"g1548984006208";s:4:"type";s:3:"url";s:3:"url";s:23:"/pages/group/groupApply";s:8:"url_name";s:15:"申请团长页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/g6jLASziZnIII6nwNw1nI08i6daaIN.png";}i:2;a:5:{s:2:"id";s:14:"g1555306830375";s:4:"type";s:3:"url";s:3:"url";s:0:"";s:8:"url_name";s:0:"";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/kdIon18nF117DdgQDyYZdqU1UI8D1Y.png";}}s:6:"radius";s:2:"10";s:10:"margin_top";s:1:"5";s:14:"margin_boottom";s:1:"5";s:11:"margin_left";s:1:"5";s:12:"margin_right";s:1:"5";s:10:"point_type";s:1:"2";}}i:2;a:3:{s:2:"id";s:14:"m1548983841984";s:4:"name";s:8:"buyTitle";s:6:"params";a:13:{s:6:"module";s:1:"3";s:5:"color";s:7:"#ffffff";s:7:"bgcolor";s:7:"#ff4848";s:9:"timeColor";s:7:"#ffffff";s:11:"timeBgcolor";s:7:"#505050";s:10:"limitTitle";s:12:"正在抢购";s:14:"limitTitleDown";s:12:"每日更新";s:9:"nextTitle";s:12:"下期预告";s:13:"nextTitleDown";s:12:"限时开抢";s:7:"nocolor";s:4:"#333";s:9:"nobgcolor";s:4:"#eee";s:3:"pic";s:77:"http://127.0.0.35/addons/group_buy/public/diyimages/index-tab-left-active.png";s:5:"nopic";s:79:"http://127.0.0.35/addons/group_buy/public/diyimages/index-tab-left-disabled.png";}}i:3;a:3:{s:2:"id";s:14:"m1548983843177";s:4:"name";s:4:"cate";s:6:"params";a:4:{s:12:"border_color";s:7:"#000000";s:5:"color";s:4:"#000";s:7:"mrcolor";s:7:"#b0b0b0";s:7:"bgcolor";s:7:"#ff4848";}}i:4;a:3:{s:2:"id";s:14:"m1548984145632";s:4:"name";s:5:"goods";s:6:"params";a:7:{s:18:"goods_title_module";s:1:"0";s:12:"goods_module";s:1:"2";s:8:"is_class";s:1:"0";s:3:"num";s:2:"10";s:6:"is_hot";s:1:"0";s:6:"is_new";s:1:"1";s:6:"margin";s:1:"4";}}i:5;a:3:{s:2:"id";s:14:"m1548836775341";s:4:"name";s:4:"bars";s:6:"params";a:8:{s:6:"radius";s:1:"0";s:7:"padding";s:1:"5";s:7:"bgcolor";s:7:"#ffffff";s:9:"fontcolor";s:4:"#000";s:8:"actcolor";s:7:"#dd4f43";s:3:"num";s:1:"4";s:4:"data";a:5:{i:0;a:7:{s:2:"id";s:8:"00000001";s:5:"title";s:6:"首页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/YXCycWx3HB7wuz3C7c8IZ0xxxzX95w.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/I36l1Jm8529V6vvnSV65YhY1Smy69h.png";s:4:"type";s:3:"url";s:3:"url";s:21:"/pages/template/index";s:8:"url_name";s:6:"首页";}i:1;a:7:{s:2:"id";s:8:"00000004";s:5:"title";s:6:"分类";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/AEvTQbe0hthcEaZBBB0HTJbDBj8h7C.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/zZcZcD08wZccwtB0cac0VB7t7TZc7B.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:8:"url_name";s:18:"产品分类列表";}i:2;a:7:{s:2:"id";s:8:"00000002";s:5:"title";s:9:"购物车";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/ZJX3jtCnc3VONHT3jyWd7Vnt32VtbV.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/All52tonUZ6J4dO2TCCBgsYGOLON61.png";s:4:"type";s:3:"url";s:3:"url";s:20:"/pages/template/cart";s:8:"url_name";s:9:"购物车";}i:3;a:7:{s:2:"id";s:8:"00000003";s:5:"title";s:6:"我的";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/OyuF58qu8oVGZ3Zfx1oX5f8c5xWW4U.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/gZmmdWt3WPvAJ9RbVfwhzaQBggTmdP.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/personal";s:8:"url_name";s:12:"个人中心";}i:4;a:6:{s:2:"id";s:8:"00000005";s:5:"title";s:12:"导航名称";s:3:"img";s:58:"http://127.0.0.35/addons/group_buy/public/diyimages/no.png";s:6:"actimg";s:58:"http://127.0.0.35/addons/group_buy/public/diyimages/no.png";s:4:"type";s:3:"url";s:3:"url";s:0:"";}}s:7:"content";s:0:"";}}}s:5:"basic";a:9:{s:2:"id";s:7:"0000000";s:4:"name";s:0:"";s:5:"title";s:19:"团购演示风格1";s:10:"sharetitle";s:0:"";s:8:"shareimg";s:0:"";s:5:"isbar";s:1:"0";s:5:"topbg";s:7:"#ffffff";s:8:"topcolor";s:7:"#000000";s:5:"allbg";s:7:"#ffffff";}}', '1548836757', '', '1', '1', '2');
INSERT INTO `mmwl_gpb_diy_page` VALUES ('2', '0', 'a:2:{s:4:"data";a:7:{i:0;a:3:{s:2:"id";s:14:"m1548816385107";s:4:"name";s:5:"slide";s:6:"params";a:14:{s:8:"ischange";s:1:"0";s:10:"changetime";s:1:"3";s:10:"changelast";s:3:"500";s:10:"pointcolor";s:7:"#dddddd";s:8:"actcolor";s:7:"#22c397";s:9:"showpoint";s:1:"0";s:6:"height";s:3:"150";s:4:"data";a:2:{i:0;a:5:{s:2:"id";s:8:"00000001";s:4:"type";s:3:"url";s:3:"url";s:23:"/pages/group/groupApply";s:8:"url_name";s:15:"申请团长页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/zGTO48664tgooR46tsHShmYTE48Trg.jpg";}i:1;a:5:{s:2:"id";s:14:"g1548816397444";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/supplier";s:8:"url_name";s:18:"申请供应商页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/QFfpl126JMBlNlAL6FLP7SekkL2PMS.jpg";}}s:6:"radius";s:1:"0";s:6:"margin";s:1:"4";s:10:"margin_top";s:1:"0";s:14:"margin_boottom";s:1:"0";s:11:"margin_left";s:1:"0";s:12:"margin_right";s:1:"0";}}i:1;a:3:{s:2:"id";s:14:"m1548469872895";s:4:"name";s:4:"head";s:6:"params";a:4:{s:4:"type";s:1:"1";s:11:"head_module";s:1:"1";s:6:"margin";s:1:"5";s:6:"radius";s:2:"10";}}i:2;a:3:{s:2:"id";s:14:"m1548913537421";s:4:"name";s:6:"coupon";s:6:"params";a:7:{s:7:"padding";s:1:"0";s:4:"type";s:1:"1";s:6:"istext";s:1:"0";s:8:"fontsize";s:2:"14";s:9:"fontcolor";s:4:"#333";s:7:"bgcolor";s:7:"#ffffff";s:4:"data";a:1:{i:0;a:5:{s:2:"id";s:8:"00000001";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/t8Ic5L1T99cIEiItZ3UwDlneGC8Ino.png";s:3:"url";s:22:"/pages/template/coupon";s:5:"title";s:0:"";s:4:"type";s:3:"url";}}}}i:3;a:3:{s:2:"id";s:14:"m1548897284424";s:4:"name";s:8:"buyTitle";s:6:"params";a:6:{s:6:"module";s:1:"2";s:5:"color";s:7:"#ffffff";s:7:"bgcolor";s:7:"#000000";s:9:"timeColor";s:7:"#ffffff";s:11:"timeBgcolor";s:7:"#ff0000";s:10:"limitTitle";s:12:"限时抢购";}}i:4;a:3:{s:2:"id";s:14:"m1548469535713";s:4:"name";s:5:"goods";s:6:"params";a:8:{s:4:"type";s:1:"2";s:8:"is_class";s:1:"0";s:3:"num";s:2:"10";s:12:"goods_module";s:1:"3";s:7:"content";s:0:"";s:18:"goods_title_module";s:1:"0";s:6:"is_new";s:1:"0";s:6:"is_hot";s:1:"1";}}i:5;a:3:{s:2:"id";s:14:"m1548656059308";s:4:"name";s:5:"space";s:6:"params";a:3:{s:6:"height";s:2:"11";s:7:"bgcolor";s:7:"#f3f4f5";s:7:"content";s:0:"";}}i:6;a:3:{s:2:"id";s:14:"m1548654541438";s:4:"name";s:4:"bars";s:6:"params";a:7:{s:6:"radius";s:1:"0";s:7:"padding";s:1:"0";s:7:"bgcolor";s:7:"#ffffff";s:9:"fontcolor";s:4:"#000";s:8:"actcolor";s:7:"#f1646b";s:3:"num";s:1:"4";s:4:"data";a:5:{i:0;a:7:{s:2:"id";s:8:"00000001";s:5:"title";s:6:"首页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/dm16wMz81LFtct8TcC54F1cZcfTRWM.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/CPVpAyVPAfUoZSNpAOaaeVYNoPPnMa.png";s:4:"type";s:3:"url";s:3:"url";s:21:"/pages/template/index";s:8:"url_name";s:6:"首页";}i:1;a:7:{s:2:"id";s:8:"00000002";s:5:"title";s:6:"分类";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/PBeZG4zP0lG34BA0B6GYP0G9YbLyp9.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/cKqTkKievkt4e3eN2UlkV4e4k2QKiq.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:8:"url_name";s:18:"产品分类列表";}i:2;a:7:{s:2:"id";s:8:"00000003";s:5:"title";s:9:"购物车";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/KOCmmVbQzoCTO4oYbDBYe4DsJEQcmD.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/Mqa61tk6jGZ6zZ3K67kjjZQ4J54K6g.png";s:4:"type";s:3:"url";s:3:"url";s:20:"/pages/template/cart";s:8:"url_name";s:9:"购物车";}i:3;a:7:{s:2:"id";s:8:"00000004";s:5:"title";s:6:"我的";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/Dw8260M5E7Swqs64EMS896ss653w4Z.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/XngrYHNK7KKNZ5aHoon9EdZZhr93R5.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/personal";s:8:"url_name";s:12:"个人中心";}i:4;a:6:{s:2:"id";s:8:"00000005";s:5:"title";s:12:"导航名称";s:3:"img";s:58:"http://127.0.0.35/addons/group_buy/public/diyimages/no.png";s:6:"actimg";s:58:"http://127.0.0.35/addons/group_buy/public/diyimages/no.png";s:4:"type";s:3:"url";s:3:"url";s:0:"";}}}}}s:5:"basic";a:9:{s:2:"id";s:7:"0000000";s:4:"name";s:0:"";s:5:"title";s:6:"首页";s:10:"sharetitle";s:0:"";s:8:"shareimg";s:0:"";s:5:"isbar";s:1:"0";s:5:"topbg";s:7:"#fc4443";s:8:"topcolor";s:7:"#ffffff";s:5:"allbg";s:7:"#ffffff";}}', '1548294695', '', '2', '1', '2');
INSERT INTO `mmwl_gpb_diy_page` VALUES ('3', '0', 'a:2:{s:4:"data";a:7:{i:0;a:3:{s:2:"id";s:14:"m1548983827233";s:4:"name";s:4:"head";s:6:"params";a:11:{s:11:"head_module";s:1:"2";s:7:"content";s:0:"";s:11:"showAddress";s:1:"0";s:9:"rightTpye";s:1:"1";s:7:"incolor";s:7:"#eeeeee";s:12:"border_color";s:7:"#eeeeee";s:7:"bgcolor";s:7:"#ffffff";s:4:"text";s:12:"搜索商品";s:10:"text_color";s:7:"#cccccc";s:13:"border_radius";s:2:"12";s:12:"search_width";s:2:"72";}}i:1;a:3:{s:2:"id";s:14:"m1548983843177";s:4:"name";s:4:"cate";s:6:"params";a:4:{s:12:"border_color";s:7:"#000000";s:5:"color";s:3:"#ff";s:7:"mrcolor";s:7:"#b0b0b0";s:7:"bgcolor";s:7:"#ffec33";}}i:2;a:3:{s:2:"id";s:14:"m1548983995047";s:4:"name";s:5:"slide";s:6:"params";a:15:{s:8:"ischange";s:1:"0";s:10:"changetime";s:1:"3";s:10:"changelast";s:3:"500";s:10:"pointcolor";s:7:"#dddddd";s:8:"actcolor";s:7:"#ffffff";s:9:"showpoint";s:1:"1";s:6:"height";s:3:"150";s:4:"data";a:3:{i:0;a:5:{s:2:"id";s:8:"00000001";s:4:"type";s:3:"url";s:3:"url";s:22:"/pages/template/coupon";s:8:"url_name";s:15:"优惠券列表";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/kdIon18nF117DdgQDyYZdqU1UI8D1Y.png";}i:1;a:5:{s:2:"id";s:14:"g1548984006208";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/supplier";s:8:"url_name";s:18:"申请供应商页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/y89ThvIIA6tc2HSSHY5JKvavCsJ8eV.png";}i:2;a:5:{s:2:"id";s:14:"g1554693075613";s:4:"type";s:3:"url";s:3:"url";s:23:"/pages/group/groupApply";s:8:"url_name";s:15:"申请团长页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/g6jLASziZnIII6nwNw1nI08i6daaIN.png";}}s:6:"radius";s:2:"10";s:10:"margin_top";s:1:"5";s:14:"margin_boottom";s:1:"5";s:11:"margin_left";s:1:"5";s:12:"margin_right";s:1:"5";s:10:"point_type";s:1:"2";s:11:"point_align";s:1:"3";}}i:3;a:3:{s:2:"id";s:14:"m1555300800045";s:4:"name";s:5:"image";s:6:"params";a:7:{s:7:"padding";s:1:"1";s:4:"type";s:1:"1";s:6:"istext";s:1:"0";s:8:"fontsize";s:2:"14";s:9:"fontcolor";s:4:"#333";s:7:"bgcolor";s:7:"#ffffff";s:4:"data";a:1:{i:0;a:5:{s:2:"id";s:8:"00000001";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/iZWQ6dXAd1rqQQPD31dAx2n261kwZ7.png";s:3:"url";s:0:"";s:5:"title";s:0:"";s:4:"type";s:3:"url";}}}}i:4;a:3:{s:2:"id";s:14:"m1548983841984";s:4:"name";s:8:"buyTitle";s:6:"params";a:13:{s:6:"module";s:1:"1";s:5:"color";s:2:"#f";s:7:"bgcolor";s:7:"#ffec33";s:9:"timeColor";s:7:"#ffffff";s:11:"timeBgcolor";s:7:"#505050";s:10:"limitTitle";s:12:"正在抢购";s:14:"limitTitleDown";s:12:"每日更新";s:9:"nextTitle";s:12:"下期预告";s:13:"nextTitleDown";s:12:"限时开抢";s:7:"nocolor";s:4:"#333";s:9:"nobgcolor";s:4:"#eee";s:3:"pic";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/f1YPhXplYyxsoNiNa8EnS3ZYEaXa5P.png";s:5:"nopic";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/Dhlm5HFF7rF07lDoZU45zHsd0oH4OM.png";}}i:5;a:3:{s:2:"id";s:14:"m1548984145632";s:4:"name";s:5:"goods";s:6:"params";a:7:{s:18:"goods_title_module";s:1:"0";s:12:"goods_module";s:1:"2";s:8:"is_class";s:1:"0";s:3:"num";s:2:"10";s:6:"is_hot";s:1:"1";s:6:"is_new";s:1:"0";s:6:"margin";s:1:"0";}}i:6;a:3:{s:2:"id";s:14:"m1548836775341";s:4:"name";s:4:"bars";s:6:"params";a:8:{s:6:"radius";s:1:"0";s:7:"padding";s:1:"5";s:7:"bgcolor";s:7:"#ffffff";s:9:"fontcolor";s:7:"#9f9f9f";s:8:"actcolor";s:4:"#000";s:3:"num";s:1:"3";s:4:"data";a:5:{i:0;a:7:{s:2:"id";s:8:"00000001";s:5:"title";s:6:"首页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/T2k4X2E2rnO9oK92I1e6R9i099D4o2.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/BKRlXqq7f7xa6l78QrLS6gK2g2LDdT.png";s:4:"type";s:3:"url";s:3:"url";s:21:"/pages/template/index";s:8:"url_name";s:6:"首页";}i:1;a:7:{s:2:"id";s:8:"00000002";s:5:"title";s:9:"购物车";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/V44oge8NSeqJO3gkWNeWQy4OYLn45Y.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/hc3G3TpNZPn3pNPggGiJg6ZcXxgcGX.png";s:4:"type";s:3:"url";s:3:"url";s:20:"/pages/template/cart";s:8:"url_name";s:9:"购物车";}i:2;a:7:{s:2:"id";s:8:"00000003";s:5:"title";s:6:"我的";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/TX8tu28bP8oZPxOjZ8FNo88P228u2o.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/UR4t42e855812OdunnPI1r40v2PuaZ.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/personal";s:8:"url_name";s:12:"个人中心";}i:3;a:7:{s:2:"id";s:8:"00000004";s:5:"title";s:12:"导航名称";s:3:"img";s:58:"http://127.0.0.35/addons/group_buy/public/diyimages/no.png";s:6:"actimg";s:58:"http://127.0.0.35/addons/group_buy/public/diyimages/no.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:8:"url_name";s:18:"产品分类列表";}i:4;a:6:{s:2:"id";s:8:"00000005";s:5:"title";s:12:"导航名称";s:3:"img";s:58:"http://127.0.0.35/addons/group_buy/public/diyimages/no.png";s:6:"actimg";s:58:"http://127.0.0.35/addons/group_buy/public/diyimages/no.png";s:4:"type";s:3:"url";s:3:"url";s:0:"";}}s:7:"content";s:0:"";}}}s:5:"basic";a:9:{s:2:"id";s:7:"0000000";s:4:"name";s:0:"";s:5:"title";s:19:"团购演示风格2";s:10:"sharetitle";s:0:"";s:8:"shareimg";s:0:"";s:5:"isbar";s:1:"0";s:5:"topbg";s:7:"#ffffff";s:8:"topcolor";s:7:"#000000";s:5:"allbg";s:7:"#ffffff";}}', '1548985346', '', '3', '1', '2');
INSERT INTO `mmwl_gpb_diy_page` VALUES ('4', '2', 'a:2:{s:4:"data";a:7:{i:0;a:3:{s:2:"id";s:14:"m1548816385107";s:4:"name";s:5:"slide";s:6:"params";a:14:{s:8:"ischange";s:1:"0";s:10:"changetime";s:1:"3";s:10:"changelast";s:3:"500";s:10:"pointcolor";s:7:"#dddddd";s:8:"actcolor";s:7:"#22c397";s:9:"showpoint";s:1:"0";s:6:"height";s:3:"150";s:4:"data";a:2:{i:0;a:5:{s:2:"id";s:8:"00000001";s:4:"type";s:3:"url";s:3:"url";s:23:"/pages/group/groupApply";s:8:"url_name";s:15:"申请团长页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/zGTO48664tgooR46tsHShmYTE48Trg.jpg";}i:1;a:5:{s:2:"id";s:14:"g1548816397444";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/supplier";s:8:"url_name";s:18:"申请供应商页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/QFfpl126JMBlNlAL6FLP7SekkL2PMS.jpg";}}s:6:"radius";s:1:"0";s:6:"margin";s:1:"4";s:10:"margin_top";s:1:"0";s:14:"margin_boottom";s:1:"0";s:11:"margin_left";s:1:"0";s:12:"margin_right";s:1:"0";}}i:1;a:3:{s:2:"id";s:14:"m1548469872895";s:4:"name";s:4:"head";s:6:"params";a:4:{s:4:"type";s:1:"1";s:11:"head_module";s:1:"1";s:6:"margin";s:1:"5";s:6:"radius";s:2:"10";}}i:2;a:3:{s:2:"id";s:14:"m1548913537421";s:4:"name";s:6:"coupon";s:6:"params";a:7:{s:7:"padding";s:1:"0";s:4:"type";s:1:"1";s:6:"istext";s:1:"0";s:8:"fontsize";s:2:"14";s:9:"fontcolor";s:4:"#333";s:7:"bgcolor";s:7:"#ffffff";s:4:"data";a:1:{i:0;a:5:{s:2:"id";s:8:"00000001";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/t8Ic5L1T99cIEiItZ3UwDlneGC8Ino.png";s:3:"url";s:22:"/pages/template/coupon";s:5:"title";s:0:"";s:4:"type";s:3:"url";}}}}i:3;a:3:{s:2:"id";s:14:"m1548897284424";s:4:"name";s:8:"buyTitle";s:6:"params";a:6:{s:6:"module";s:1:"2";s:5:"color";s:7:"#ffffff";s:7:"bgcolor";s:7:"#000000";s:9:"timeColor";s:7:"#ffffff";s:11:"timeBgcolor";s:7:"#ff0000";s:10:"limitTitle";s:12:"限时抢购";}}i:4;a:3:{s:2:"id";s:14:"m1548469535713";s:4:"name";s:5:"goods";s:6:"params";a:8:{s:4:"type";s:1:"2";s:8:"is_class";s:1:"0";s:3:"num";s:2:"10";s:12:"goods_module";s:1:"3";s:7:"content";s:0:"";s:18:"goods_title_module";s:1:"0";s:6:"is_new";s:1:"0";s:6:"is_hot";s:1:"1";}}i:5;a:3:{s:2:"id";s:14:"m1548656059308";s:4:"name";s:5:"space";s:6:"params";a:3:{s:6:"height";s:2:"11";s:7:"bgcolor";s:7:"#f3f4f5";s:7:"content";s:0:"";}}i:6;a:3:{s:2:"id";s:14:"m1548654541438";s:4:"name";s:4:"bars";s:6:"params";a:7:{s:6:"radius";s:1:"0";s:7:"padding";s:1:"0";s:7:"bgcolor";s:7:"#ffffff";s:9:"fontcolor";s:4:"#000";s:8:"actcolor";s:7:"#f1646b";s:3:"num";s:1:"4";s:4:"data";a:5:{i:0;a:7:{s:2:"id";s:8:"00000001";s:5:"title";s:6:"首页";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/dm16wMz81LFtct8TcC54F1cZcfTRWM.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/CPVpAyVPAfUoZSNpAOaaeVYNoPPnMa.png";s:4:"type";s:3:"url";s:3:"url";s:21:"/pages/template/index";s:8:"url_name";s:6:"首页";}i:1;a:7:{s:2:"id";s:8:"00000002";s:5:"title";s:6:"分类";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/PBeZG4zP0lG34BA0B6GYP0G9YbLyp9.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/cKqTkKievkt4e3eN2UlkV4e4k2QKiq.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/template/classify";s:8:"url_name";s:18:"产品分类列表";}i:2;a:7:{s:2:"id";s:8:"00000003";s:5:"title";s:9:"购物车";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/KOCmmVbQzoCTO4oYbDBYe4DsJEQcmD.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/Mqa61tk6jGZ6zZ3K67kjjZQ4J54K6g.png";s:4:"type";s:3:"url";s:3:"url";s:20:"/pages/template/cart";s:8:"url_name";s:9:"购物车";}i:3;a:7:{s:2:"id";s:8:"00000004";s:5:"title";s:6:"我的";s:3:"img";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/Dw8260M5E7Swqs64EMS896ss653w4Z.png";s:6:"actimg";s:86:"http://127.0.0.35/addons/group_buy/public/diyimages/XngrYHNK7KKNZ5aHoon9EdZZhr93R5.png";s:4:"type";s:3:"url";s:3:"url";s:24:"/pages/personal/personal";s:8:"url_name";s:12:"个人中心";}i:4;a:6:{s:2:"id";s:8:"00000005";s:5:"title";s:12:"导航名称";s:3:"img";s:58:"http://127.0.0.35/addons/group_buy/public/diyimages/no.png";s:6:"actimg";s:58:"http://127.0.0.35/addons/group_buy/public/diyimages/no.png";s:4:"type";s:3:"url";s:3:"url";s:0:"";}}}}}s:5:"basic";a:9:{s:2:"id";s:7:"0000000";s:4:"name";s:0:"";s:5:"title";s:6:"首页";s:10:"sharetitle";s:0:"";s:8:"shareimg";s:0:"";s:5:"isbar";s:1:"0";s:5:"topbg";s:7:"#fc4443";s:8:"topcolor";s:7:"#ffffff";s:5:"allbg";s:7:"#ffffff";}}', '', '', '', '2', '3');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_diy_temp 
-- ----------------------------
INSERT INTO `mmwl_gpb_diy_temp` VALUES ('2', '0', '风格3', '1', '1', '1', '/addons/group_buy/public/bg/sys_temp5.jpg', '1548985632', '2');
INSERT INTO `mmwl_gpb_diy_temp` VALUES ('1', '0', '风格1', '-1', '1', '1', '/addons/group_buy/public/bg/sys_temp1.jpg', '1548985899', '2');
INSERT INTO `mmwl_gpb_diy_temp` VALUES ('3', '0', '风格2', '-1', '1', '1', '/addons/group_buy/public/bg/sys_temp4.jpg', '1548985883', '2');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`g_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mmwl_gpb_goods 
-- ----------------------------
INSERT INTO `mmwl_gpb_goods` VALUES ('1', '华为手机', '', '华为手机 真他妈好用', '100.00', '20.00', '3', '', '&lt;p&gt;10&lt;/p&gt;', '1', '1', '1563429230', '', '1', '', '', '1', '1', '0', '2', '110', '1', '', '', '0', '0', '1', '1', '', '', '', '0', '0', '', '20', '0.00', '1', '10.00', '1', '1.00', '0', '10.00', '1', '0', '0', '1', '0', '2', '2', '1');

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
-- Records of mmwl_gpb_goods_cate 
-- ----------------------------
INSERT INTO `mmwl_gpb_goods_cate` VALUES ('1', '手机', '0', '1', '1', '', '1563429142', '', '1', '2', '0', ',0', '1', '1');

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
-- Records of mmwl_gpb_goods_stock 
-- ----------------------------
INSERT INTO `mmwl_gpb_goods_stock` VALUES ('1', '', '', '2', '0', '1', '1', '2');

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
-- Records of mmwl_gpb_goods_stock_logs 
-- ----------------------------
INSERT INTO `mmwl_gpb_goods_stock_logs` VALUES ('1', '', '0', '', '2', '1', '1563429230', '1', '2');

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
-- Records of mmwl_gpb_goods_to_category 
-- ----------------------------
INSERT INTO `mmwl_gpb_goods_to_category` VALUES ('1', '2', '1', '1');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  `display` int(2) DEFAULT '1' COMMENT '是否隐藏',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
INSERT INTO `mmwl_gpb_menu_list` VALUES ('64', '配置', './index.php?c=site&a=entry&do=config&m=group_buy', '0', 'fa fa-cog', '1', 'config,update', '', '配置管理', '60', '', '1');
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
INSERT INTO `mmwl_gpb_menu_list` VALUES ('143', '在线更新', './index.php?c=site&a=entry&op=index&do=update&m=group_buy', '64', 'fa fa-cog', '1', 'update', 'index', '', '299', '', '1');

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
  `integral` int(3) DEFAULT NULL COMMENT '支付的积分',
  `limit` varchar(25) COLLATE utf8_bin DEFAULT NULL COMMENT '积分商品限制兑换数量',
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
  PRIMARY KEY (`go_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
INSERT INTO `mmwl_gpb_plug` VALUES ('1', '0', '积分商城', '', '/addons/group_buy/public/bg/fraction.png', '', '1', '1', '1', 'group_buy_plugin_fraction', './index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_fraction&version_id=0', 'https://s.w7.cc/module-17917.html');
INSERT INTO `mmwl_gpb_plug` VALUES ('2', '0', '分销商城', '', '/addons/group_buy/public/bg/distribution.png', '', '2', '1', '1', 'group_buy_plugin_distribution', './index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_distribution&version_id=0', 'https://s.w7.cc/module-18137.html');
INSERT INTO `mmwl_gpb_plug` VALUES ('3', '0', '整点秒杀', '', '/addons/group_buy/public/bg/seckill.png', '', '3', '1', '1', 'group_buy_plugin_seckill', './index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_seckill&version_id=0', 'https://s.w7.cc/module-19790.html');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
INSERT INTO `mmwl_modules` VALUES ('13', 'group_buy', 'business', '麦芒社区团购', '1.0', '包含社区团购等功能', '包含社区团购等功能', 'scmmwl', 'http://www.scmmwl.com/', '0', 'a:0:{}', 'a:0:{}', '0', '0', '0', '0', 'a:0:{}', 'M', '2', '1', '1', '1', '1', '1', '1', '1', 'addons/group_buy/icon.jpg', '1', '1', 'local');
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_modules_rank 
-- ----------------------------
INSERT INTO `mmwl_modules_rank` VALUES ('1', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('2', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('3', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('4', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('5', 'group_buy_plugin_distribution', '0', '0', '2');
INSERT INTO `mmwl_modules_rank` VALUES ('6', 'group_buy_plugin_distribution', '1', '1', '2');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

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
INSERT INTO `mmwl_stat_visit` VALUES ('12', '0', '', '1', '20190729', 'web', '1');
INSERT INTO `mmwl_stat_visit` VALUES ('13', '2', '', '56', '20190729', 'web', '0');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
INSERT INTO `mmwl_uni_group` VALUES ('1', '0', '体验套餐服务', 'N;', 'N;', '0', '0');
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
INSERT INTO `mmwl_uni_settings` VALUES ('2', '', '', '0', '', '', 'a:2:{s:7:"credit1";a:2:{s:5:"title";s:6:"积分";s:7:"enabled";i:1;}s:7:"credit2";a:2:{s:5:"title";s:6:"余额";s:7:"enabled";i:1;}}', 'a:2:{s:8:"activity";s:7:"credit1";s:8:"currency";s:7:"credit2";}', '', '', '', 'a:1:{s:6:"wechat";a:3:{s:5:"mchid";s:14:"asdf2134fads-=";s:7:"signkey";s:13:"sdfewrgm-==-a";s:7:"account";i:2;}}', '', '', '0', '', '', '0', '', '0', '0', '', '', '', '0', '0', '', '', '', '0', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_users 
-- ----------------------------
INSERT INTO `mmwl_users` VALUES ('1', '0', '1', '1', 'admin', 'b472a0a5dae4a6ad899837e9a236ae1da3aac268', 'L2crx6ky', '0', '2', '1563415812', '', '1564384517', '127.0.0.1', '', '0', '0', '0', '', '0', '');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mmwl_users_lastuse 
-- ----------------------------
INSERT INTO `mmwl_users_lastuse` VALUES ('1', '1', '2', '', 'account_display');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
INSERT INTO `mmwl_wxapp_versions` VALUES ('1', '2', '0', '1.0.0', '1.0.0', 'a:1:{s:29:"group_buy_plugin_distribution";a:2:{s:4:"name";s:29:"group_buy_plugin_distribution";s:7:"version";s:6:"1.0.20";}}', '3', '0', '', '1563416812', '0', '0', '', '', '0', '', '', '0');

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

