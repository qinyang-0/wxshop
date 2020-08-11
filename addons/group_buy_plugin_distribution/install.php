<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/19
 * Time: 14:13
 */
$sql = "DROP TABLE IF EXISTS ".tablename('gpb_distribution_cash_money').";

CREATE TABLE ".tablename('gpb_distribution_cash_money')." (
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
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



DROP TABLE IF EXISTS ".tablename('gpb_distribution_group').";

CREATE TABLE ".tablename('gpb_distribution_group')." (
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



DROP TABLE IF EXISTS ".tablename('gpb_distribution_group_log').";

CREATE TABLE ".tablename('gpb_distribution_group_log')." (
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



DROP TABLE IF EXISTS ".tablename('gpb_distribution_list').";

CREATE TABLE ".tablename('gpb_distribution_list')." (
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



DROP TABLE IF EXISTS ".tablename('gpb_distribution_log').";

CREATE TABLE ".tablename('gpb_distribution_log')." (
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



DROP TABLE IF EXISTS ".tablename('gpb_distribution_money').";

CREATE TABLE ".tablename('gpb_distribution_money')." (
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



DROP TABLE IF EXISTS ".tablename('gpb_distribution_money_log').";

CREATE TABLE ".tablename('gpb_distribution_money_log')." (
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



DROP TABLE IF EXISTS ".tablename('gpb_distrution_commond_log').";

CREATE TABLE ".tablename('gpb_distrution_commond_log')." (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS ".tablename('gpb_distribution_menu').";

CREATE TABLE ".tablename('gpb_distribution_menu')." (
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



insert  into ".tablename('gpb_distribution_menu')."(`id`,`pid`,`title`,`long_title`,`url`,`deep`,`top_do`,`sort`,`icon`,`create_time`,`update_time`,`status`) values (1,0,'设置',NULL,'config',1,NULL,5,'icon-setting','00000000000','00000000000',1),(2,0,'团队',NULL,'User',1,NULL,10,'icon-user','00000000000','00000000000',1),(3,1,'基本设置','分销设置','config_state',2,'config',0,NULL,'00000000000','00000000000',1),(4,1,'佣金设置','分销设置','config_money',2,'config',0,NULL,'00000000000','00000000000',1),(5,0,'首页','系统首页','home',1,NULL,0,'icon-home','00000000000','00000000000',1),(6,1,'审核设置','分销设置','config_exa',2,'config',0,NULL,'00000000000','00000000000',1),(7,1,'推荐奖设置','分销设置','config_commoned',2,'config',0,NULL,'00000000000','00000000000',1),(8,2,'提现审核','分销设置','config_exa_list',2,'User',10,NULL,'00000000000','00000000000',1),(9,2,'团队列表',NULL,'UserList',2,'User',0,NULL,'00000000000','00000000000',1),(10,2,'审核列表',NULL,'exalist',2,'User',0,NULL,'00000000000','00000000000',1),(11,1,'提现设置',NULL,'config_cash',2,'config',100,NULL,'00000000000','00000000000',1);
";
pdo_run($sql);