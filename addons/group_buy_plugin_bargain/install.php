<?php 
$sql = "";
if(!pdo_tableexists('gpb_bargain_action')){
	$sql .= "CREATE TABLE ".tablename('gpb_bargain_action')." (
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
			) ENGINE=InnoDB AUTO_INCREMENT=362 DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
}
if(!pdo_tableexists('gpb_bargaion_goods')){
	$sql .= "CREATE TABLE ".tablename('gpb_bargaion_goods')." (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '砍价商品表',
			  `g_id` int(11) DEFAULT '0' COMMENT '商品id',
			  `weid` int(8) DEFAULT '0',
			  `end_price` double(10,2) DEFAULT '0.00' COMMENT '低价',
			  `status` int(2) DEFAULT '1' COMMENT '状态 1.代表能正常砍价',
			  `type` int(2) DEFAULT '1' COMMENT '类型',
			  `low_price` int(2) DEFAULT '1' COMMENT '是否显示低价 1.不显示 2.显示',
			  `time_limit` int(2) DEFAULT '1' COMMENT '砍价时间(小时)',
			  `total_time` int(5) DEFAULT '0' COMMENT '可砍价总次数',
			  `each_time` int(5) DEFAULT '1' COMMENT '每个人可以砍的次数',
			  `content` text COLLATE utf8_bin NOT NULL COMMENT '砍价详细',
			  `place_order` int(2) DEFAULT '1' COMMENT '没有砍到低价是否能够下单 1.能 2.不能',
			  `status_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '开始时间',
			  `end_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '结束时间',
			  `launches` int(8) DEFAULT '0' COMMENT '活动客发起次数',
			  `own` int(2) DEFAULT '1' COMMENT '自己是否能砍价1.不能2.能',
			  `price_cutting_times` int(2) DEFAULT '1' COMMENT '每个用户可发起活动次数',
			  `total_pople` varchar(255) COLLATE utf8_bin DEFAULT '0' COMMENT '总砍价人数',
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
}
if(!pdo_tableexists('gpb_bargaion_record')){
	$sql .= "CREATE TABLE ".tablename('gpb_bargaion_record')." (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '砍价详情表',
			  `ac_id` int(8) DEFAULT '0' COMMENT '砍价发起表id',
			  `price` double(10,2) DEFAULT '0.00' COMMENT '价格(砍了多少)',
			  `openid` varbinary(255) NOT NULL,
			  `nickname` varchar(255) COLLATE utf8_bin NOT NULL,
			  `head_img` varchar(255) COLLATE utf8_bin NOT NULL,
			  `status_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '砍价时间',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=753 DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
}
pdo_run($sql);
$bargain = pdo_get("gpb_plug",array('key'=>'group_buy_plugin_bargain'),array('key'));
if(empty($bargain)){
	pdo_run("insert  into ".tablename('gpb_plug')." (`cate`,`name`,`add_time`,`icon`,`comment`,`plug_order`,`status`,`is_del`,`key`,`url`,`buy_url`) values (0,'砍价',NULL,'../addons/group_buy_plugin_bargain/icon.jpg','',3,1,1,'group_buy_plugin_bargain','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_bargain&version_id=0','https://s.w7.cc/module-22997.html');");
}
//升级
if(!pdo_fieldexists('gpb_bargaion_goods', 'total_pople')) {
    pdo_query("ALTER TABLE ".tablename('gpb_bargaion_goods')." ADD COLUMN `total_pople` VARCHAR(255) DEFAULT '0' NULL COMMENT '总砍价人数';");
}
//2019-11-15
$bargain = pdo_get("gpb_plug",array('key'=>'group_buy_plugin_bargain'),array('key'));
if(empty($bargain)){
	pdo_run("insert  into ".tablename('gpb_plug')." (`cate`,`name`,`add_time`,`icon`,`comment`,`plug_order`,`status`,`is_del`,`key`,`url`,`buy_url`) values (0,'砍价',NULL,'../addons/group_buy_plugin_bargain/icon.jpg','',3,1,1,'group_buy_plugin_bargain','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_bargain&version_id=0','https://s.w7.cc/module-22997.html');");
}
?>