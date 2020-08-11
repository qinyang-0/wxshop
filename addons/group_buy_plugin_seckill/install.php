<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/19
 * Time: 14:13
 */
$sql = "
DROP TABLE IF EXISTS ".tablename('gpb_package_goods').";
CREATE TABLE ".tablename('gpb_package_goods')."  (
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

DROP TABLE IF EXISTS ".tablename('gpb_package_goods_option').";
CREATE TABLE ".tablename('gpb_package_goods_option')." (
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

DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_adv').";
CREATE TABLE ".tablename('gpb_shop_seckill_adv')." (
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

DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_category').";
CREATE TABLE ".tablename('gpb_shop_seckill_category')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0' COMMENT '模块',
  `name` varchar(255) DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_task').";
CREATE TABLE ".tablename('gpb_shop_seckill_task')." (
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

DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_task_goods').";
CREATE TABLE ".tablename('gpb_shop_seckill_task_goods')." (
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


DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_task_room').";
CREATE TABLE ".tablename('gpb_shop_seckill_task_room')." (
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

DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_task_time').";
CREATE TABLE ".tablename('gpb_shop_seckill_task_time')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  `time` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;";
pdo_run($sql);

pdo_run("insert  into ".tablename('gpb_distribution_menu')." (`id`,`pid`,`title`,`long_title`,`url`,`deep`,`top_do`,`sort`,`icon`,`create_time`,`update_time`,`status`) values (1,0,'分销配置','','config',1,'',15,'icon-setting','00000000000','00000000000',1),(2,0,'分销中心','','User',1,'',10,'icon-user','00000000000','00000000000',1),(3,1,'基本设置','分销设置','config_state',2,'config',0,'','00000000000','00000000000',1),(4,1,'佣金设置','分销设置','config_money',2,'config',0,'','00000000000','00000000000',1),(5,0,'首页','系统首页','home',1,NULL,0,'icon-home','00000000000','00000000000',-1),(6,1,'审核设置','分销设置','config_exa',2,'config',0,'','00000000000','00000000000',1),(7,1,'推荐奖设置','分销设置','config_commoned',2,'config',0,NULL,'00000000000','00000000000',1),(8,2,'提现审核','分销设置','config_exa_list',2,'User',10,'','00000000000','00000000000',1),(9,2,'团队列表','','UserList',2,'User',0,'','00000000000','00000000000',1),(10,2,'审核列表','','exalist',2,'User',0,'','00000000000','00000000000',1),(11,1,'提现设置','','config_cash',2,'config',100,'','00000000000','00000000000',1),(12,0,'专题管理','专题管理','index',1,'index',0,NULL,'00000000000','00000000000',2),(13,0,'会场管理','会场管理','room',1,'room',0,NULL,'00000000000','00000000000',2),(14,0,'商品管理','商品管理','goods',1,'goods',0,NULL,'00000000000','00000000000',2),(15,0,'分类管理','分类管理','category',1,'category',0,NULL,'00000000000','00000000000',2),(16,0,'广告管理','幻灯片管理','adv',1,'adv',0,NULL,'00000000000','00000000000',2),(17,0,'设置','设置','calendar',1,'calendar',0,NULL,'00000000000','00000000000',2),(18,17,'任务设置','任务设置','calendar',2,'calendar',0,NULL,'00000000000','00000000000',2),(19,17,'入口设置','入口设置','cover',2,'cover',0,NULL,'00000000000','00000000000',2),(20,1,'申请页配置','分销设置','config_put',2,'config',0,'','00000000000','00000000000',1);");

if(!pdo_tableexists('gpb_distribution_menu')) {
    pdo_query("CREATE TABLE ".tablename('gpb_distribution_menu')." (
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
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '0表示删除 1分销插件 2整点秒杀插件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
}
$menu_sql = "insert  into ".tablename('gpb_distribution_menu')."
(`pid`,`title`,`long_title`,`url`,`deep`,`top_do`,`sort`,`icon`,`create_time`,`update_time`,`status`) values 
(0,'专题管理','专题管理','index',1,'index',0,NULL,'00000000000','00000000000',2),
(0,'会场管理','会场管理','room',1,'room',0,NULL,'00000000000','00000000000',2),
(0,'商品管理','商品管理','goods',1,'goods',0,NULL,'00000000000','00000000000',2),
(0,'分类管理','分类管理','category',1,'category',0,NULL,'00000000000','00000000000',2),
(0,'广告管理','幻灯片管理','adv',1,'adv',0,NULL,'00000000000','00000000000',2),
(0,'设置','设置','calendar',1,'calendar',0,NULL,'00000000000','00000000000',2),
(17,'任务设置','任务设置','calendar',2,'calendar',0,NULL,'00000000000','00000000000',2),
(17,'入口设置','入口设置','cover',2,'cover',0,NULL,'00000000000','00000000000',2);";
pdo_query($menu_sql);
$is_have_seckill = pdo_get('gpb_plug',array('key'=>'group_buy_plugin_seckill','status'=>1,'is_del'=>1));
if(empty($is_have_seckill)){
    pdo_run("insert  into ".tablename('gpb_plug')." (`cate`,`name`,`add_time`,`icon`,`comment`,`plug_order`,`status`,`is_del`,`key`,`url`,`buy_url`) values 
(0,'整点秒杀',NULL,'/addons/group_buy/public/bg/seckill.png','',3,1,1,'group_buy_plugin_seckill','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_seckill&version_id=0',NULL);");
}