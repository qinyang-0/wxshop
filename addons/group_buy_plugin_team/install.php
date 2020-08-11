<?php
if(!pdo_tableexists("gpb_pteam_activity")){
    pdo_run("
CREATE TABLE ".tablename("gpb_pteam_activity")." (
 `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '发起拼团',
  `leaderid` int(11) NOT NULL COMMENT '发起人（团长）',
  `pl_id` int(11) NOT NULL COMMENT '对应拼团信息id',
  `state` int(2) NOT NULL DEFAULT '2' COMMENT '状态，1未开始，2已开始，-1已过期',
  `star_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000' COMMENT '开始时间',
  `end_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000' COMMENT '结束时间',
  `status` int(1) NOT NULL DEFAULT '1',
  `ctime` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `utime` varbinary(11) NOT NULL DEFAULT '00000000000',
  `weid` int(11) NOT NULL,
  `now_num` int(11) NOT NULL DEFAULT '1' COMMENT '当前人数',
  `all_num` int(11) NOT NULL COMMENT '团人数',
  `info` text COLLATE utf8_bin COMMENT '参团相关信息锁定',
  `leader_openid` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
}
if(!pdo_tableexists("gpb_pteam_config")){
    pdo_run("
CREATE TABLE ".tablename("gpb_pteam_config")." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '拼团配置',
  `weid` int(11) NOT NULL COMMENT '模块id',
  `name` text COLLATE utf8_bin NOT NULL COMMENT '名称',
  `value` text COLLATE utf8_bin NOT NULL COMMENT '内容',
  `type` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT 'input' COMMENT '类型',
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(1) NOT NULL DEFAULT '1',
  `ctime` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `utime` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
}
if(!pdo_tableexists("gpb_pteam_list")){
    pdo_run("
CREATE TABLE ".tablename("gpb_pteam_list")." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '拼团列表',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `is_spec` int(1) NOT NULL DEFAULT '0' COMMENT '是否多规格',
  `spec_info` text COMMENT '多规格序列化',
  `old_price` double(20,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `price` double(20,2) NOT NULL DEFAULT '0.00' COMMENT '现价',
  `is_ladder` int(1) NOT NULL DEFAULT '0' COMMENT '是否阶梯价格',
  `ladder_info` text COMMENT '阶梯价格详情',
  `team_num` int(2) NOT NULL COMMENT '拼团人数',
  `comment` text COMMENT '拼团说明',
  `banner` text NOT NULL COMMENT '拼团轮播',
  `buy_num` int(11) NOT NULL DEFAULT '0' COMMENT '每人限购',
  `star_time` varchar(11) NOT NULL DEFAULT '00000000000' COMMENT '开始时间',
  `end_time` varchar(11) DEFAULT '00000000000' COMMENT '结束时间',
  `limit_time` int(11) NOT NULL DEFAULT '60' COMMENT '拼团时间',
  `is_sale` int(1) NOT NULL DEFAULT '1' COMMENT '是否上架',
  `goods_num` int(11) NOT NULL COMMENT '商品数量',
  `virtual_num` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟拼团人数',
  `utime` varchar(11) NOT NULL DEFAULT '00000000000',
  `weid` int(11) DEFAULT NULL,
  `all_num` int(11) NOT NULL DEFAULT '0' COMMENT '拼团售卖库存',
  `status` int(1) NOT NULL DEFAULT '1',
  `ctime` varchar(11) NOT NULL DEFAULT '00000000000',
  `goods_title` varchar(255) NOT NULL COMMENT '商品标题',
  `goods_image` varchar(255) NOT NULL COMMENT '商品图片',
  `state` int(2) NOT NULL DEFAULT '1' COMMENT '活动状态 1 上架 -1下架',
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `unit` varchar(100) NOT NULL COMMENT '显示单位',
  `goods_btitle` varchar(255) NOT NULL COMMENT '副标题',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
}
if(!pdo_tableexists("gpb_pteam_menu")){
    pdo_run("
CREATE TABLE ".tablename("gpb_pteam_menu")." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '拼团菜单',
  `title` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '菜单名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `url` text COLLATE utf8_bin COMMENT '菜单链接',
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `deep` int(2) NOT NULL DEFAULT '1' COMMENT '深度',
  `icon` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '图标',
  `status` int(2) NOT NULL DEFAULT '1',
  `op` text COLLATE utf8_bin COMMENT '附加参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
insert  into `ims_gpb_pteam_menu`(`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (1,'拼团管理',0,'teaminfo',20,1,'',1,NULL);
insert  into `ims_gpb_pteam_menu`(`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (2,'订单管理',0,'order',10,1,'',1,'states=20');
insert  into `ims_gpb_pteam_menu`(`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (3,'商品管理',0,'home',0,1,'',1,NULL);
insert  into `ims_gpb_pteam_menu`(`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (5,'待收货',2,'order',10,2,'',-1,'state=20');
insert  into `ims_gpb_pteam_menu`(`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (4,'待发货',2,'order',0,2,'',-1,'state=30');
insert  into `ims_gpb_pteam_menu`(`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (6,'待付款',2,'order',20,2,'',-1,'state=10');
insert  into `ims_gpb_pteam_menu`(`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (7,'已完成',2,'order',30,2,'',-1,'state=100');
insert  into `ims_gpb_pteam_menu`(`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (8,'全部订单',2,'order',40,2,'',-1,'state=0');
insert  into `ims_gpb_pteam_menu`(`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (9,'拼团设置',0,'pteamconfig',50,1,'',1,NULL);
");
}
if(!pdo_tableexists("gpb_pteam_order")){
    pdo_run("
CREATE TABLE ".tablename("gpb_pteam_order")." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '拼团订单',
  `lid` int(11) NOT NULL COMMENT '对应拼团',
  `aid` int(11) NOT NULL COMMENT '对应团活动',
  `osn` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '平台订单号',
  `state` int(2) NOT NULL DEFAULT '0' COMMENT '订单状态 0未付款,1已付款,2已发货,3已出库，4已收货，5退款中，6已退款，-1已取消',
  `wx_log` text COLLATE utf8_bin COMMENT '微信返回信息',
  `money` double(20,2) NOT NULL DEFAULT '0.00' COMMENT '付款金额',
  `pay_sn` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '商户订单号',
  `pay_type` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'wxpay' COMMENT '支付类型 默认微信支付',
  `pay_time` varchar(11) COLLATE utf8_bin DEFAULT NULL COMMENT '支付时间',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '购买数量',
  `uid` int(11) NOT NULL COMMENT '用户主键',
  `openid` varchar(32) COLLATE utf8_bin NOT NULL COMMENT '用户openid',
  `weid` int(11) NOT NULL COMMENT '模块id',
  `status` int(1) NOT NULL DEFAULT '1',
  `ctime` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `utime` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `leaderid` int(11) NOT NULL COMMENT '团长id',
  `parsent` int(3) NOT NULL DEFAULT '0' COMMENT '团长分佣比例',
  `pay_money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '实付金额',
  `leader_openid` varchar(32) COLLATE utf8_bin NOT NULL COMMENT '团长openid',
  `suc_form` text COLLATE utf8_bin NOT NULL COMMENT '成功formid',
  `fail_form` text COLLATE utf8_bin NOT NULL COMMENT '失败formid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
}