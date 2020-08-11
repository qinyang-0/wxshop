<?php
$pre = $_W['config']['db']['tablepre'];
//安装文件
pdo_run("
	CREATE TABLE ".tablename('gpb_action')." (
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
	  `action_pic` longtext COLLATE utf8_bin COMMENT '活动图片',
	  PRIMARY KEY (`at_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_action_goods')." (
	  `gcg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品活动关系表',
	  `gcg_at_id` int(11) NOT NULL COMMENT '活动表',
	  `gcg_g_id` int(11) NOT NULL COMMENT '商品表',
	  `weid` int(11) DEFAULT NULL,
	  PRIMARY KEY (`gcg_id`,`gcg_at_id`,`gcg_g_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1291 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_action_village')." (
	  `gav_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动小区关系',
	  `gav_ac_id` int(11) NOT NULL COMMENT '活动',
	  `gav_v_id` int(11) NOT NULL COMMENT '小区',
	  `weid` int(11) DEFAULT NULL,
	  PRIMARY KEY (`gav_id`,`gav_ac_id`,`gav_v_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_activity_plugin_virtual_buy_list')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=11156 DEFAULT CHARSET=utf8;
	
	CREATE TABLE ".tablename('gpb_activity_plugin_virtual_users')." (
	  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	  `head` text NOT NULL COMMENT '头像',
	  `phone` varchar(255) NOT NULL COMMENT '电话',
	  `name` varchar(255) NOT NULL COMMENT '昵称',
	  `sex` int(2) DEFAULT '1' COMMENT '性别',
	  `aid` int(11) NOT NULL COMMENT '对应商品id',
	  PRIMARY KEY (`uid`)
	) ENGINE=MyISAM AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8;
	
	CREATE TABLE ".tablename('gpb_application_header')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=249 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_area')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `ad_code` int(6) NOT NULL DEFAULT '0' COMMENT '地理位置编码',
	  `name` varchar(36) NOT NULL,
	  `level` varchar(12) NOT NULL COMMENT '级别',
	  `pid` int(6) NOT NULL COMMENT '父级地理位置编码',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=3225 DEFAULT CHARSET=utf8 COMMENT='地区编码表';
	
	CREATE TABLE ".tablename('gpb_article')." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章表',
	  `weid` int(11) DEFAULT NULL,
	  `status` int(11) DEFAULT '1' COMMENT '状态',
	  `title` text COLLATE utf8_bin COMMENT '标题',
	  `body` text COLLATE utf8_bin COMMENT '主体内容',
	  `sort` varchar(25) COLLATE utf8_bin DEFAULT '0' COMMENT '排序',
	  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL,
	  `createtime` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '发布时间',
	  `class` varchar(255) COLLATE utf8_bin DEFAULT NULL,
	  `pid` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '分类',
	  `is_del` tinyint(1) DEFAULT '1' COMMENT '1正常2删除',
	  `addtime` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '创建时间',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_article_class')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_back_money')." (
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
	  `gpb_head_money` varchar(255) COLLATE utf8_bin DEFAULT '0.00' COMMENT '退款扣除团长佣金',
	  PRIMARY KEY (`gbm_id`),
	  KEY `gbm_go_code` (`gbm_go_code`)
	) ENGINE=MyISAM AUTO_INCREMENT=264 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_banner')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_bargain_action')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_bargaion_goods')." (
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
	
	CREATE TABLE ".tablename('gpb_bargaion_record')." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '砍价详情表',
	  `ac_id` int(8) DEFAULT '0' COMMENT '砍价发起表id',
	  `price` double(10,2) DEFAULT '0.00' COMMENT '价格(砍了多少)',
	  `openid` varbinary(255) NOT NULL,
	  `nickname` varchar(255) COLLATE utf8_bin NOT NULL,
	  `head_img` varchar(255) COLLATE utf8_bin NOT NULL,
	  `status_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '砍价时间',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_cart')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=3932 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_config')." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置表',
	  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '中文配置名称',
	  `value` text COLLATE utf8_bin COMMENT 'value',
	  `type` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '类型(1支付配置2.消息配置3.团长设置4.首页设置放弃5.云存储设置放弃6.页面标题设置放弃7.订单设置8.分销商城设置9供应商设置10商品展示设置11.公众号设置)',
	  `time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
	  `weid` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT '模块id',
	  `status` tinyint(1) DEFAULT NULL COMMENT '1使用-1未使用',
	  `key` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '英文key值',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1393 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_consumption_info')." (
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
	  `cash_type` int(3) DEFAULT '1' COMMENT '提现类型1提现到零钱2.支付宝3.网银',
	  `case_value` text COLLATE utf8_bin NOT NULL COMMENT '提现到支付宝和提现到网银的数据',
	  `from_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'fromid',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
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
	) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
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
	) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_distribution_list')." (
	  `dl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	  `dl_shop_name` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '小区/团长名',
	  `dl_shop_address` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '地址',
	  `dl_dr_id` int(11) DEFAULT NULL COMMENT '路线id',
	  `dl_add_time` char(15) COLLATE utf8_bin DEFAULT NULL,
	  `dl_update_time` char(15) COLLATE utf8_bin DEFAULT NULL,
	  `dl_status` tinyint(3) DEFAULT '10' COMMENT '状态',
	  `dl_send_time` char(15) COLLATE utf8_bin DEFAULT NULL COMMENT '发货时间',
	  `dl_goods_num` smallint(4) DEFAULT NULL COMMENT '数量',
	  `dl_is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除',
	  `dl_goods` varchar(500) COLLATE utf8_bin DEFAULT NULL COMMENT '预留之后按商品发货字段',
	  `weid` int(11) DEFAULT NULL,
	  `dl_code` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '配送单码',
	  `dl_go_code` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '订单号',
	  PRIMARY KEY (`dl_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_distribution_list_order')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `l_id` int(11) NOT NULL COMMENT '清单id',
	  `go_id` int(11) NOT NULL COMMENT '订单id',
	  `go_code` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '订单code',
	  `weid` int(11) NOT NULL,
	  PRIMARY KEY (`id`,`l_id`,`go_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=698 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
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
	) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
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
	) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
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
	  `recharge` int(3) DEFAULT '1' COMMENT '入口 充值有用',
	  `withdrawal` int(2) DEFAULT '1' COMMENT '充值拥挤是否提现1未提现2提现了',
	  `recharge_id` int(8) DEFAULT '0' COMMENT '充值订单id',
	  `change` double(10,2) DEFAULT '0.00' COMMENT '金额变动只有的金额',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1187 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_distribution_route')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	
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
	) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_diy_page')." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `weid` int(5) unsigned NOT NULL,
	  `content` longtext COLLATE utf8_bin COMMENT '内容',
	  `createtime` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
	  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
	  `tempid` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '模板id',
	  `status` int(2) DEFAULT '1' COMMENT '状态',
	  `system` int(2) DEFAULT '1' COMMENT '是否是系统模板(系统模板禁止删除)',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_diy_temp')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_express')." (
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
	  KEY `weid` (`weid`)
	) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;
	
	CREATE TABLE ".tablename('gpb_express_shipping')." (
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
	  KEY `weid` (`weid`)
	) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
	
	CREATE TABLE ".tablename('gpb_get_cash')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_goods')." (
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
	  `g_commission` varchar(255) COLLATE utf8_bin DEFAULT NULL,
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
	  `dis_type` int(2) NOT NULL DEFAULT '2' COMMENT '是否启用独立佣金 1.启用 2.不启用',
  	  `dis_rule` int(2) NOT NULL DEFAULT '1' COMMENT '佣金规则 1.统一分销佣金 2.详细设置分销佣金',
  	  `g_is_head_enjoy` int(1) DEFAULT '-1' COMMENT '团长专享',
	  PRIMARY KEY (`g_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
pdo_run("	
	CREATE TABLE ".tablename('gpb_goods_cate')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_goods_dicount_unified')." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员卡价格 统一设置',
	  `goods_id` int(8) DEFAULT '0' COMMENT '商品id',
	  `price` varchar(255) COLLATE utf8_bin DEFAULT '0' COMMENT '价格 单位:分',
	  `card` int(8) DEFAULT '0' COMMENT '会员卡等级',
	  `weid` int(8) DEFAULT '0' COMMENT '模块id',
	  `status` int(1) DEFAULT '1' COMMENT '状态码',
	  `create_time` varchar(255) COLLATE utf8_bin DEFAULT '0' COMMENT '添加时间',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_goods_discount_detailed')." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员价格 多规格价格',
	  `goods_id` int(8) DEFAULT '0' COMMENT '商品id',
	  `weid` int(8) DEFAULT '0' COMMENT '模块id',
	  `gos_id` int(8) DEFAULT '0' COMMENT '多规格id',
	  `price` int(8) DEFAULT '0' COMMENT '会员价格 单位:分',
	  `caid` int(8) DEFAULT '0' COMMENT '会员卡id',
	  `create_time` varchar(255) COLLATE utf8_bin DEFAULT '0' COMMENT '时间',
	  `status` int(5) DEFAULT '1' COMMENT '状态码',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=343 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_goods_distribution')." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品佣金表',
	  `g_id` int(8) DEFAULT '0',
	  `weid` int(8) DEFAULT '0' COMMENT '商品id',
	  `ggo_id` int(8) DEFAULT '0' COMMENT '多规格id',
	  `price` varchar(255) COLLATE utf8_bin DEFAULT '0' COMMENT '价格  如果是纯数字 代表 固定金额  如果是字符串是百分比',
	  `level` int(2) NOT NULL DEFAULT '1' COMMENT '等级 1.1级分销 2.二级分销 3.三级分销',
	  `status` int(2) NOT NULL DEFAULT '1',
	  `create_time` varchar(255) COLLATE utf8_bin DEFAULT '0' COMMENT '时间',
	  `f1` text COLLATE utf8_bin NOT NULL,
	  `f2` text COLLATE utf8_bin NOT NULL,
	  `f3` text COLLATE utf8_bin NOT NULL,
	  `f4` text COLLATE utf8_bin NOT NULL,
	  `f5` text COLLATE utf8_bin NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
	
	CREATE TABLE ".tablename('gpb_goods_option')." (
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
	  `ggo_stock_y` int(11) DEFAULT '0' COMMENT '已销售库存',
	  
	  PRIMARY KEY (`ggo_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1680 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_goods_spec')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=561 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_goods_spec_item')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=1275 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_goods_stock')." (
	  `gs_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品库存',
	  `store_id` int(10) DEFAULT NULL COMMENT '对应店铺id',
	  `product_id` int(10) DEFAULT NULL COMMENT '对应规格id',
	  `num` int(10) DEFAULT '0' COMMENT '剩余库存',
	  `sale_num` int(10) DEFAULT '0' COMMENT '销售量',
	  `goods_id` int(10) DEFAULT NULL COMMENT '对应商品id',
	  `business_id` int(11) DEFAULT '1',
	  `weid` int(11) DEFAULT NULL,
	  PRIMARY KEY (`gs_id`),
      KEY `goods_id` (`goods_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_goods_stock_logs')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=978 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_goods_to_category')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `weid` int(11) NOT NULL,
	  `cate_id` int(11) NOT NULL,
	  `goods_id` int(11) NOT NULL,
	  PRIMARY KEY (`id`),
	  KEY `weid` (`weid`,`goods_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_head_commond_log')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_head_group')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_head_group_log')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团长下级日志',
	  `uid` int(11) NOT NULL COMMENT '用户id',
	  `pid` int(11) NOT NULL COMMENT '直属父级id',
	  `weid` int(11) NOT NULL COMMENT '模块id',
	  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
	  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
	  `status` int(2) NOT NULL DEFAULT '1',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_head_history')." (
	  `hh_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团长历史记录表',
	  `hh_head_openid` char(30) COLLATE utf8_bin NOT NULL COMMENT '团长openid',
	  `openid` char(30) COLLATE utf8_bin NOT NULL COMMENT '用户openid',
	  `hh_add_time` char(15) COLLATE utf8_bin DEFAULT '0' COMMENT '第一次关联时间',
	  `hh_last_time` char(15) COLLATE utf8_bin DEFAULT '0' COMMENT '最近一次关联时间',
	  `weid` int(11) DEFAULT '0',
	  `type` tinyint(1) DEFAULT '1' COMMENT '关联类型，1用户自己主动选择2.别人分享被动关联',
	  PRIMARY KEY (`hh_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=4169 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_head_money')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_head_money_log')." (
	  REATE TABLE `ims_gpb_head_money_log` (
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
      `goods_id` int(11) NOT NULL COMMENT '商品id',
      `goods_num` int(11) NOT NULL COMMENT '商品数量',
      `before` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动前余额',
      `after` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动后余额',
      `percent` text COLLATE utf8_bin NOT NULL COMMENT '保存时分佣比例',
      `fiexd` text COLLATE utf8_bin NOT NULL COMMENT '保存时固定分佣',
      `dis_type` int(2) NOT NULL DEFAULT '1' COMMENT '保存时分佣类型',
      PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=`` DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_head_route')." (
	  `ghr_id` int(11) NOT NULL AUTO_INCREMENT,
	  `ghr_mid` int(11) DEFAULT NULL,
	  `ghr_vid` int(11) NOT NULL,
	  `ghr_rid` int(11) DEFAULT NULL,
	  `weid` int(11) DEFAULT NULL,
	  PRIMARY KEY (`ghr_id`,`ghr_vid`)
	) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_level')." (
	  `id` int(11) unsigned NOT NULL COMMENT '会员等级',
	  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '等级名称',
	  `type` int(2) DEFAULT NULL COMMENT '优惠类型 1.立减 2.折扣',
	  `money` double(10,2) DEFAULT NULL COMMENT '优惠价格（立减为优惠多少元，折扣为几折）',
	  `status` int(2) DEFAULT '1' COMMENT '状态',
	  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '时间',
	  `weid` int(11) DEFAULT NULL COMMENT '模块id',
	  `code` int(2) DEFAULT NULL COMMENT '是否自动升级',
	  `co_money` double(10,2) DEFAULT NULL COMMENT '升级购物金额'
	) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_mail')." (
	  `id` int(11) DEFAULT NULL COMMENT '站内信',
	  `openid` varchar(255) COLLATE utf8_bin DEFAULT NULL,
	  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '创建时间',
	  `content` text COLLATE utf8_bin COMMENT '内容',
	  `status` int(2) DEFAULT '1' COMMENT '状态',
	  `weid` int(11) DEFAULT NULL COMMENT '模块id',
	  `code` int(2) DEFAULT NULL COMMENT '是否查看'
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_member')." (
	  `m_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员表主键ID',
	  `m_nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '会员昵称（微信获取）',
	  `m_phone` char(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '手机号',
	  `m_name` char(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '真实姓名',
	  `m_openid` char(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '微信openid',
	  `m_photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '头像地址',
	  `m_money` decimal(10,2) DEFAULT '0.00' COMMENT '账号金额',
	  `m_last_longitude` char(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '上次定位经度',
	  `m_last_latitude` char(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '上次定位纬度',
	  `m_is_head` tinyint(1) DEFAULT '-1' COMMENT '是否是团长2是-1否',
	  `m_commission` decimal(10,2) DEFAULT '0.00' COMMENT '佣金比例1-100%',
	  `m_order_num` int(5) DEFAULT '0' COMMENT '该用户成交单数',
	  `m_order_money` decimal(10,2) DEFAULT '0.00' COMMENT '订单成交总金额',
	  `m_comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '个人说明',
	  `m_update_time` char(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '修改时间',
	  `m_status` tinyint(1) DEFAULT '1' COMMENT '状态/软删除',
	  `weid` int(11) DEFAULT NULL COMMENT '模块ID',
	  `m_add_time` char(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
	  `m_two_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '二维码',
	  `m_wx_account` char(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '微信账号',
	  `m_head_lng` char(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '0' COMMENT '申请团长时定位经度',
	  `m_head_lat` char(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '0' COMMENT '申请团长时定位纬度',
	  `m_head_shop_name` char(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '申请团长时社区/店铺名称',
	  `m_head_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '申请团长时地址',
	  `m_head_openid` char(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '选择的团长openid',
	  `qr_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '团长二维码地址',
	  `sessionkey` char(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '会话key',
	  `m_get_good_code` char(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '唯一提货码',
	  `m_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '二维码生成时间',
	  `m_get_cash_money` decimal(10,2) DEFAULT NULL COMMENT '已提现金额',
	  `m_back_money` decimal(10,2) DEFAULT NULL COMMENT '退款金额',
	  `m_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '登录密码',
	  `m_names` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '真实姓名',
	  `m_address` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT '地址',
	  `m_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '身份证号码',
	  `other` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT '其他',
	  `integral` double(10,2) DEFAULT '0.00' COMMENT '积分',
	  `status` int(2) DEFAULT NULL COMMENT '状态（是否审核）',
	  `level_id` int(5) DEFAULT NULL COMMENT '等级id',
	  `m_last_location` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '上一次定位省市区',
	  `m_is_send` tinyint(1) DEFAULT '1' COMMENT '是否团长送货 2 送1不送',
	  `m_send_price` decimal(10,2) DEFAULT '0.00' COMMENT '团长配送费',
	  `m_is_have_limit_pay` tinyint(1) DEFAULT '1' COMMENT '是否开启小区限额 1不 2开',
	  `m_limit_pay` decimal(10,2) DEFAULT '0.00' COMMENT '最低消费多少',
	  `m_recommend_code` char(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '团长推荐码',
	  `m_send_price_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团长总配送费',
	  `unionid` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '开发平台openid',
	  `wx_public_openid` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '公众号openid',
	  `whether` int(2) DEFAULT '1' COMMENT '是否购买充值活动 1.没有 2.有',
	  `level` int(8) DEFAULT '0' COMMENT '会员卡id',
	  `end_level_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '会员卡结束时间为0 是永久',
	  `m_head_house_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '团长地址某栋某单元门牌',
	  `statr_level_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '会员卡开始时间',
	  `level_money` double(10,2) DEFAULT '0.00' COMMENT '会员卡支付金额 -1是赠送会员',
	  `m_money_balance` double(10,2) DEFAULT '0.00' COMMENT '用户余额',
	  `level_last_time` int(2) DEFAULT '1' COMMENT '1.没过期 2.过期了',
	  `closes` int(2) DEFAULT '1' COMMENT '当前团长是否打烊 1.没有 2.打烊了',
	  `reason` text NOT NULL COMMENT '打烊原因',
	  `tel` text NOT NULL COMMENT '团长催单管理员电话',
	  PRIMARY KEY (`m_id`,`m_openid`)
	) ENGINE=InnoDB AUTO_INCREMENT=4164 DEFAULT CHARSET=utf8;
	
	CREATE TABLE ".tablename('gpb_member_card')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_member_card_order')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_member_card_time')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_member_integral_check')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=476 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_menu')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_menu_list')." (
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
	
	CREATE TABLE ".tablename('gpb_order')." (
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
	  `go_card_money` varchar(255) COLLATE utf8_bin DEFAULT '0.00' COMMENT '会员卡优惠金额',
	  `delivery_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '团长送货  送货时间',
	  PRIMARY KEY (`go_id`),
	  KEY `go_code` (`go_code`)
	) ENGINE=InnoDB AUTO_INCREMENT=2970 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_order_log')." (
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
	  `share` int(2) DEFAULT '1' COMMENT '1.不是分享订单积分 2.是订单积分',
	  PRIMARY KEY (`gol_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=3391 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_order_snapshot')." (
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
	  `oss_commiosn` text COLLATE utf8_bin NOT NULL COMMENT '分销佣金',
	  PRIMARY KEY (`oss_id`),
	  KEY `go_code` (`oss_go_code`),
	  KEY `oss_head_openid` (`oss_head_openid`),
	  KEY `oss_buy_openid` (`oss_buy_openid`),
	  KEY `oss_go_code` (`oss_go_code`)
	) ENGINE=InnoDB AUTO_INCREMENT=3585 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
	pdo_run("
	CREATE TABLE ".tablename('gpb_order_stream')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=3752 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_package_goods')." (
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
	
	CREATE TABLE ".tablename('gpb_plug')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_print_log')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '打印日志',
	  `data` text COLLATE utf8_bin NOT NULL COMMENT '发送消息详情',
	  `from` text COLLATE utf8_bin NOT NULL COMMENT '发送来源',
	  `result` text COLLATE utf8_bin NOT NULL COMMENT '返回信息',
	  `send_state` int(2) NOT NULL DEFAULT '0' COMMENT '发送状态',
	  `send_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
	  `status` int(2) NOT NULL DEFAULT '1',
	  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
	  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
	  `weid` int(11) DEFAULT NULL COMMENT '模块id',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=559 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	

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
  `limit_time` double(11,2) NOT NULL DEFAULT '60.00' COMMENT '拼团时间',
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


insert  into ".tablename("gpb_pteam_menu")." (`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (1,'拼团管理',0,'teaminfo',20,1,'',1,NULL);
insert  into ".tablename("gpb_pteam_menu")." (`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (2,'订单管理',0,'order',10,1,'',1,'states=20');
insert  into ".tablename("gpb_pteam_menu")." (`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (3,'商品管理',0,'home',0,1,'',1,NULL);
insert  into ".tablename("gpb_pteam_menu")." (`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (5,'待收货',2,'order',10,2,'',-1,'state=20');
insert  into ".tablename("gpb_pteam_menu")." (`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (4,'待发货',2,'order',0,2,'',-1,'state=30');
insert  into ".tablename("gpb_pteam_menu")." (`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (6,'待付款',2,'order',20,2,'',-1,'state=10');
insert  into ".tablename("gpb_pteam_menu")." (`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (7,'已完成',2,'order',30,2,'',-1,'state=100');
insert  into ".tablename("gpb_pteam_menu")." (`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (8,'全部订单',2,'order',40,2,'',-1,'state=0');
insert  into ".tablename("gpb_pteam_menu")." (`id`,`title`,`pid`,`url`,`sort`,`deep`,`icon`,`status`,`op`) values (9,'拼团设置',0,'pteamconfig',50,1,'',1,NULL);



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

CREATE TABLE ".tablename("gpb_pteam_order_detail")." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `goods_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '商品名称',
  `goods_price` double(20,2) NOT NULL COMMENT '商品原价',
  `goods_banner` text COLLATE utf8_bin NOT NULL COMMENT '商品图片',
  `status` int(1) NOT NULL DEFAULT '1',
  `ctime` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `utime` varchar(11) COLLATE utf8_bin DEFAULT '00000000000',
  `teamid` int(11) NOT NULL COMMENT '所属小区团长id',
  `team_openid` varchar(32) COLLATE utf8_bin NOT NULL COMMENT '所属小区团长openid',
  `weid` int(11) NOT NULL COMMENT '所属模块id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

	
	CREATE TABLE ".tablename('gpb_receiving_address')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=1010 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_recharge')." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '余额充值',
	  `title` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '标题',
	  `money` double(10,2) DEFAULT '0.00' COMMENT '充值金额',
	  `release_gold` int(2) DEFAULT '1' COMMENT '赠送金额是否是释放金1.是2.不是（不是释放金，每天的返钱将返到用户的余额里面去，并且不过期）',
	  `release` int(8) DEFAULT '0' COMMENT '释放天数\r\n，为0代表不需要释放天数，用户充值就将钱直接返给用户',
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
	) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_recharge_info')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_recharge_list')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=2276 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_recharge_log')." (
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
	) ENGINE=InnoDB AUTO_INCREMENT=3768 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_region')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_send_ticket_set')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
	
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
	) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
	
	CREATE TABLE ".tablename('gpb_shop_seckill_category')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uniacid` int(11) DEFAULT '0' COMMENT '模块',
	  `name` varchar(255) DEFAULT '' COMMENT '名称',
	  PRIMARY KEY (`id`),
	  KEY `idx_uniacid` (`uniacid`) USING BTREE
	) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
	
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
	) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
	
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
	  `total` int(11) unsigned DEFAULT '0',
	  `maxbuy` int(11) DEFAULT '0',
	  `totalmaxbuy` int(11) DEFAULT '0',
	  `commission1` decimal(10,2) DEFAULT '0.00',
	  `commission2` decimal(10,2) DEFAULT '0.00',
	  `commission3` decimal(10,2) DEFAULT '0.00',
	  `arrival_time` smallint(3) DEFAULT '1',
	  `sale_num` int(11) unsigned DEFAULT '0',
	  `sale_nums` int(11) unsigned DEFAULT '0',
	  PRIMARY KEY (`id`),
	  KEY `idx_uniacid` (`uniacid`) USING BTREE,
	  KEY `idx_goodsid` (`goodsid`) USING BTREE,
	  KEY `idx_optionid` (`optionid`) USING BTREE,
	  KEY `idx_displayorder` (`displayorder`) USING BTREE,
	  KEY `idx_taskid` (`taskid`) USING BTREE,
	  KEY `idx_roomid` (`roomid`) USING BTREE,
	  KEY `idx_time` (`timeid`) USING BTREE
	) ENGINE=MyISAM AUTO_INCREMENT=281 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
	
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
	) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
	
	CREATE TABLE ".tablename('gpb_shop_seckill_task_time')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uniacid` int(11) DEFAULT '0',
	  `taskid` int(11) DEFAULT '0',
	  `time` tinyint(3) DEFAULT '0',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=171 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
	
	CREATE TABLE ".tablename('gpb_spec_item')." (
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
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
	pdo_run("
	
	CREATE TABLE ".tablename('gpb_supplier')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_supplier_manger')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
	  `openid` char(30) COLLATE utf8_bin DEFAULT NULL COMMENT '用户openid',
	  `m_id` int(11) DEFAULT NULL COMMENT '用户id',
	  `gsp_id` int(11) DEFAULT NULL COMMENT '供应商id',
	  `weid` int(11) NOT NULL COMMENT 'weid',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_sure_order')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_team_cancel_goods')." (
	  `tcg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团长不开启的活动商品记录表',
	  `openid` char(50) COLLATE utf8_bin DEFAULT NULL COMMENT '团长id',
	  `tcg_at_g_id` int(11) NOT NULL COMMENT '活动商品表id',
	  PRIMARY KEY (`tcg_id`,`tcg_at_g_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=376 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_ticket')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_user_ticket')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=564 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
	
	CREATE TABLE ".tablename('gpb_village')." (
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
	) ENGINE=MyISAM AUTO_INCREMENT=162 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
/*pdo_run($sql);*/



//菜单
pdo_run("INSERT  INTO ".tablename('gpb_menu_list')." (`id`,`name`,`url`,`pid`,`icon`,`status`,`do`,`op`,`title`,`sort`,`parame`,`display`) VALUES 
(86,'团长设置','./index.php?c=site&a=entry&op=config&do=head&m=group_buy',55,'fa fa-cog','1','head','config','团长设置',60,NULL,1),
(85,'佣金流水','./index.php?c=site&a=entry&do=finance&op=stream_commission&m=group_buy',72,'fa fa-cog','1','finance','stream_commission','佣金流水',55,NULL,1),
(77,'生成配送单','./index.php?c=site&a=entry&op=wait&do=distribution&m=group_buy',75,'fa fa-cog','1','distribution','wait',NULL,44,NULL,1),
(76,'配送单','./index.php?c=site&a=entry&do=distribution&m=group_buy',75,'fa fa-cog','1','distribution','index',NULL,43,NULL,1),
(75,'配送','./index.php?c=site&a=entry&do=distribution&m=group_buy',0,'fa fa-truck','1','distribution',NULL,'配送管理',42,NULL,1),
(81,'权限设置','./index.php?c=site&a=entry&op=menu_index&do=config&m=group_buy',64,'fa fa-cog','1','config','menu_index',NULL,48,NULL,1),
(74,'退款','./index.php?c=site&a=entry&op=back_money&do=finance&m=group_buy',72,'fa fa-cog','1','finance','back_money',NULL,41,NULL,1),
(73,'提现','./index.php?c=site&a=entry&do=finance&m=group_buy',72,'fa fa-cog','1','finance','get_cash',NULL,40,NULL,1),
(72,'财务','./index.php?c=site&a=entry&do=finance&m=group_buy',0,'fa fa-bar-chart','1','finance',NULL,'财务管理',10,NULL,1),
(71,'打印机设置','./index.php?c=site&a=entry&op=print_set&do=config&m=group_buy',64,'fa fa-cog','1','config','print_set',NULL,38,NULL,1),
(41,'活动列表','./index.php?c=site&a=entry&do=action&m=group_buy',40,'fa fa-cog','1','action','index','活动列表',8,NULL,1),
(61,'会员列表','./index.php?c=site&a=entry&do=member&m=group_buy',60,'fa fa-cog','1','member','index',NULL,28,NULL,1),
(70,'订单设置','./index.php?c=site&a=entry&op=order_set&do=order&m=group_buy',42,'fa fa-cog','1','order','order_set',NULL,145,NULL,1),
(40,'活动','./index.php?c=site&a=entry&do=action&m=group_buy',0,'fa fa-flag-checkered','1','action','index','活动管理',7,NULL,1),
(69,'页面标题','./index.php?c=site&a=entry&op=title_set&do=config&m=group_buy',64,'fa fa-cog','-1','config','title_set',NULL,36,NULL,1),
(68,'首页设置','./index.php?c=site&a=entry&op=index_set&do=config&m=group_buy',64,'fa fa-cog','-1','config','index_set',NULL,35,NULL,1),
(67,'短信配置','./index.php?c=site&a=entry&op=msg&do=config&m=group_buy',64,'fa fa-cog','1','config','msg',NULL,34,NULL,1),
(66,'佣金设置','./index.php?c=site&a=entry&op=commission&do=config&m=group_buy',64,'fa fa-cog','-1','config','commission',NULL,33,NULL,1),
(65,'基本设置','./index.php?c=site&a=entry&do=config&m=group_buy',64,'fa fa-cog','1','config','index',NULL,32,NULL,1),
(64,'配置','./index.php?c=site&a=entry&do=config&m=group_buy',0,'fa fa-cog','1','config',NULL,'配置管理',60,NULL,1),
(63,'优惠券列表','./index.php?c=site&a=entry&do=market&m=group_buy',40,'fa fa-cog','2','action','coupon',NULL,30,NULL,1),
(62,'营销','./index.php?c=site&a=entry&do=market&m=group_buy',0,'fa fa-line-chart','-1','market',NULL,'营销管理',29,NULL,1),
(60,'会员','./index.php?c=site&a=entry&do=member&m=group_buy',0,'fa fa-users','1','member',NULL,'用户管理',27,NULL,1),
(59,'供应商列表','./index.php?c=site&a=entry&do=supplier&m=group_buy',58,'fa fa-cog','1','supplier','index',NULL,26,NULL,1),
(42,'订单','./index.php?c=site&a=entry&op=index&do=order&m=group_buy&status=20',0,'fa fa-file-text-o','1','order','index','订单管理',9,NULL,1),
(58,'供应','./index.php?c=site&a=entry&do=supplier&m=group_buy',0,'fa fa-user-plus','1','supplier',NULL,'供应商管理',25,NULL,1),
(43,'待发货','./index.php?c=site&a=entry&status=20&do=order&m=group_buy',42,'fa fa-cog','-1','order','','待发货订单',100,'status=20',1),
(57,'团长列表','./index.php?c=site&a=entry&op=index&do=head&m=group_buy',55,'fa fa-cog','1','head','index',NULL,24,NULL,1),
(56,'申请团长','./index.php?c=site&a=entry&do=head&m=group_buy',55,'fa fa-cog','1','head','wantHead',NULL,23,NULL,1),
(47,'核销列表','./index.php?c=site&a=entry&op=orderSure&do=order&m=group_buy',42,'fa fa-cog','1','order','orderSure','核销列表',140,NULL,1),
(44,'待收货','./index.php?c=site&a=entry&status=30&do=order&m=group_buy',42,'fa fa-cog','-1','order','','待收货订单',110,'status=30',1),
(55,'团长','./index.php?c=site&a=entry&do=head&m=group_buy',0,'fa fa-male','1','head',NULL,'团长管理',22,NULL,1),
(54,'小区列表','./index.php?c=site&a=entry&do=district&m=group_buy',55,'fa fa-cog','1','district','village',NULL,25,NULL,1),
(53,'区域','./index.php?c=site&a=entry&do=district&m=group_buy',0,'fa fa-map','-1','district',NULL,'区域管理',20,NULL,1),
(52,'商品分类','./index.php?c=site&a=entry&op=cate&do=goods&m=group_buy',50,'fa fa-cog','1','goods','cate',NULL,19,NULL,1),
(51,'商品列表','./index.php?c=site&a=entry&do=goods&m=group_buy',50,'fa fa-cog','1','goods','index',NULL,18,NULL,1),
(50,'商品','./index.php?c=site&a=entry&do=goods&m=group_buy',0,'fa fa-gift','1','goods',NULL,'商品管理',7,NULL,1),
(143,'淘宝CSV上传','./index.php?c=site&a=entry&op=taobaoCopy&do=goods&m=group_buy',50,'fa fa-cog','1','goods','taobaoCopy',NULL,20,NULL,1),
(49,'广告列表','./index.php?c=site&a=entry&do=adv&m=group_buy',48,'fa fa-cog','-1','adv','index',NULL,16,NULL,1),
(48,'广告','./index.php?c=site&a=entry&do=adv&m=group_buy',0,'fa fa-audio-description','-1','adv',NULL,'广告管理',39,NULL,1),
(46,'订单列表','./index.php?c=site&a=entry&op=index&do=order&m=group_buy&status=20',42,'fa fa-cog','1','order','index','全部订单',130,NULL,1),
(45,'已完成','./index.php?c=site&a=entry&status=100&do=order&m=group_buy',42,'fa fa-cog','-1','order','','已完成订单',120,'status=100',1),
(39,'版权设置','./index.php?c=site&a=entry&op=copyright_diy&do=diy&m=group_buy',34,'fa fa-cog','-1','diy','copyright_diy','版权设置',33,NULL,1),
(38,'顶部设置','./index.php?c=site&a=entry&op=top_diy&do=diy&m=group_buy',34,'fa fa-cog','-1','diy','top_diy','顶部设置',5,NULL,1),
(37,'底部设置','./index.php?c=site&a=entry&op=bottom_diy&do=diy&m=group_buy',34,'fa fa-cog','-1','diy','bottom_diy','底部设置',4,NULL,1),
(36,'首页管理','./index.php?c=site&a=entry&op=index_diy&do=diy&m=group_buy',34,'fa fa-cog','1','diy','index_diy','首页管理',2,NULL,1),
(34,'页面','./index.php?c=site&a=entry&do=diy&m=group_buy',0,'fa fa-clone','1','diy','index','页面管理',1,NULL,1),
(35,'我的模版','./index.php?c=site&a=entry&do=diy&op=index&m=group_buy',34,'fa fa-cog','1','diy','index','我的模版',3,NULL,1),
(78,'路线管理','./index.php?c=site&a=entry&op=route&do=distribution&m=group_buy',75,'fa fa-cog','1','distribution','route',NULL,45,NULL,1),
(79,'营销','./index.php?c=site&a=entry&do=plug&m=group_buy',0,'fa fa-plug','1','plug',NULL,'插件管理',46,NULL,1),
(82,'概览','./index.php?c=site&a=entry&do=overview&m=group_buy',0,'fa fa-tachometer','1','overview',NULL,'概览',-1,NULL,1),
(84,'交易流水','./index.php?c=site&a=entry&do=finance&op=stream_index&m=group_buy',72,'fa fa-cog','1','finance','stream_index','交易流水',50,NULL,1),
(87,'供应商设置','./index.php?c=site&a=entry&op=config&do=supplier&m=group_buy',58,'fa fa-cog','1','supplier','config','供应商设置',65,NULL,1),
(88,'商品页设置','./index.php?c=site&a=entry&op=config&do=goods&m=group_buy',50,'fa fa-cog','1','goods','config','商品页设置',70,NULL,1),
(91,'模版市场','./index.php?c=site&a=entry&do=diy&op=index_system&m=group_buy',34,'fa fa-cog','1','diy','index_system','模版市场',3,NULL,1),
(90,'版权设置','./index.php?c=site&a=entry&op=copyright&do=diy&m=group_buy',34,'fa fa-cog','1','diy','copyright','版权设置',34,NULL,1),
(92,'售后订单','./index.php?c=site&a=entry&op=afterSale&do=order&m=group_buy',42,'fa fa-cog','1','order','afterSale','售后订单',135,NULL,1),
(93,'物流配置','./index.php?c=site&a=entry&do=config&op=express&m=group_buy',64,'fa fa-cog','1','config','express','物流配置',155,NULL,1),
(94,'快递管理','./index.php?c=site&a=entry&do=config&op=express_tmp&m=group_buy',64,'fa fa-cog','1','config','express_tmp','快递管理',160,NULL,1),
(95,'运费模版','./index.php?c=site&a=entry&do=config&op=shipping&m=group_buy',64,'fa fa-cog','1','config','shipping','运费模版',165,NULL,1),
(96,'满减','./index.php?c=site&a=entry&do=action&m=group_buy&op=reduction',40,'fa fa-cog','2','action','reduction',NULL,10,NULL,1),
(97,'首页海报设置','./index.php?c=site&a=entry&do=diy&op=index_playbill&m=group_buy',34,'fa fa-cog','1','diy','index_playbill','首页海报设置',33,NULL,1),
(98,'团长推广设置','./index.php?c=site&a=entry&op=recommend_config&do=head&m=group_buy',55,'fa fa-cog','2','head','recommend_config','团长推广设置',170,NULL,1),
(99,'充值返利','./index.php?c=site&a=entry&do=member&m=group_buy&op=recharge_rebate',60,'fa fa-cog','2','member','recharge_rebate','充值返利',100,NULL,1),
(100,'会员设置','./index.php?c=site&a=entry&do=member&m=group_buy&op=config',60,'fa fa-cog','2','member','config','会员设置',150,NULL,1),
(101,'通用券','./index.php?c=site&a=entry&do=market&m=group_buy&op=add',40,'fa fa-cog','2','action','add','通用卷',100,NULL,1),
(102,'分类券','./index.php?c=site&a=entry&do=market&m=group_buy&op=cate',40,'fa fa-cog','2','action','cate','分类卷',110,NULL,1),
(103,'单品券','./index.php?c=site&a=entry&do=market&m=group_buy&op=only_goods',40,'fa fa-cog','2','action','only_goods','单品卷',120,NULL,1),
(104,'指定发送','./index.php?c=site&a=entry&do=market&m=group_buy&op=point',40,'fa fa-cog','2','action','point','指定卷',130,NULL,1),
(105,'新人券','./index.php?c=site&a=entry&do=market&m=group_buy&op=new_member',40,'fa fa-cog','2','action','new_member','新人卷',140,NULL,1),
(106,'发放记录','./index.php?c=site&a=entry&do=market&m=group_buy&op=record',40,'fa fa-cog','2','action','record','发放记录',90,NULL,1),
(107,'公众号','./index.php?c=site&a=entry&do=wechat&m=group_buy&op=index',64,'fa fa-cog','2','wechat','index','公众号',166,NULL,1),
(145,'订阅消息','./index.php?c=site&a=entry&do=templates&m=group_buy&op=index',64,'fa fa-cog','1','templates','index','订阅消息',167,NULL,2),
(108,'营销','./index.php?c=site&a=entry&do=markrting&m=group_buy&op=index',0,'fa fa-rmb','2','markrting','index','营销管理',177,NULL,2),
(109,'会员充值','./index.php?c=site&a=entry&do=markrting&m=group_buy&op=index',108,'fa fa-cog','1','markrting','index',NULL,178,NULL,1),
(110,'会员充值','./index.php?c=site&a=entry&do=markrting&m=group_buy&op=bannel',64,'fa fa-cog','2','markrting','bannel',NULL,167,NULL,1),
(111,'会员卡','./index.php?c=site&a=entry&do=card&m=group_buy&op=member_card',108,'fa fa-cog','1','card','member_card',NULL,180,NULL,1),
(113,'充值订单','./index.php?c=site&a=entry&do=markrting&m=group_buy&op=markrting_recharge',108,'fa fa-cog','1','markrting','markrting_recharge',NULL,179,NULL,1),
(112,'会员卡管理','./index.php?c=site&a=entry&do=card&m=group_buy',64,'fa fa-cog','2','card','index',NULL,168,NULL,1),
(114,'充值记录','./index.php?c=site&a=entry&do=member&m=group_buy&op=recharge_record',72,'fa fa-cog','1','member','recharge_record',NULL,188,NULL,1),
(115,'签到规则','./index.php?c=site&a=entry&op=sign&do=plsugins&m=group_buy',116,'fa fa-cog','1','sign','index',NULL,189,NULL,1),
(116,'插件管理','1',0,'fa fa-cog','1','sign,markrting,card,reduction,market,extension,recharge','plsugins','插件管理',190,NULL,2),
(117,'签到记录','./index.php?c=site&a=entry&op=sign&in=list&do=plsugins&m=group_buy',116,'fa fa-cog','1','sign','list',NULL,191,NULL,1),
(118,'会员充值','./index.php?c=site&a=entry&do=plsugins&m=group_buy&op=markrting',116,'fa fa-cog','1','markrting','index',NULL,192,NULL,1),
(120,'会员卡','./index.php?c=site&a=entry&do=plsugins&m=group_buy&op=card&in=member_card',116,'fa fa-cog','1','card','member_card',NULL,194,NULL,1),
(119,'充值订单','./index.php?c=site&a=entry&do=plsugins&m=group_buy&op=markrting&in=markrting_recharge',116,'fa fa-cog','1','markrting','markrting_recharge',NULL,193,NULL,1),
(121,'充值配置','./index.php?c=site&a=entry&do=plsugins&m=group_buy&op=markrting&in=bannel',116,'fa fa-cog','1','markrting','bannel',NULL,195,NULL,1),
(122,'会员卡配置','./index.php?c=site&a=entry&do=plsugins&m=group_buy&op=card',116,'fa fa-cog','1','card','index',NULL,196,NULL,1),
(123,'满减','./index.php?c=site&a=entry&do=plsugins&m=group_buy&op=reduction&in=reduction',116,'fa fa-cog','1','reduction','reduction',NULL,197,NULL,1),
(124,'优惠券列表 ','./index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=coupon',116,'fa fa-cog','1','market','coupon',NULL,198,NULL,1),
(125,'发放记录 ','./index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=record',116,'fa fa-cog','1','market','record',NULL,199,NULL,1),
(126,'通用券','./index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=add',116,'fa fa-cog','1','market','add',NULL,200,NULL,1),
(127,'分类券','./index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=cate',116,'fa fa-cog','1','market','cate',NULL,201,NULL,1),
(128,'单品券','./index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=only_goods',116,'fa fa-cog','1','market','only_goods',NULL,202,NULL,1),
(129,'指定发送 ','./index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=point',116,'fa fa-cog','1','market','point',NULL,203,NULL,1),
(130,'新人券','./index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=new_member',116,'fa fa-cog','1','market','new_member',NULL,204,NULL,1),
(131,'团长列表','./index.php?c=site&a=entry&op=extension&do=plsugins&m=group_buy',116,'fa fa-cog','1','extension','index',NULL,NULL,NULL,1),
(132,'团长推广','./index.php?c=site&a=entry&op=extension&do=plsugins&m=group_buy&in=recommend_config',116,'fa fa-cog','1','extension','recommend_config',NULL,NULL,NULL,1),
(133,'财务设置','./index.php?c=site&a=entry&do=finance&m=group_buy&op=config',72,'fa fa-cog','1','finance','config','财务设置',200,NULL,1),
(134,'统计','./index.php?c=site&a=entry&do=plsugins&m=group_buy&op=markrting&in=gold',116,'fa fa-cog','1','markrting','glod',NULL,201,NULL,1),
(135,'会员卡订单','./index.php?c=site&a=entry&do=plsugins&m=group_buy&op=card&in=card_order',116,'fa fa-cog','1','card','card_order',NULL,200,NULL,1),
(136,'余额充值','./index.php?c=site&a=entry&op=recharge&in=index&do=plsugins&m=group_buy',116,'fa fa-cog','1','recharge','index',NULL,201,NULL,1),
(137,'充值订单','./index.php?c=site&a=entry&op=recharge&in=markrting_recharge&do=plsugins&m=group_buy',116,'fa fa-cog','1','recharge','markrting_recharge',NULL,202,NULL,1),
(138,'余额配置','./index.php?c=site&a=entry&op=recharge&in=bannel&do=plsugins&m=group_buy',116,'fa fa-cog','1','recharge','bannel',NULL,203,NULL,1),
(139,'内容管理','./index.php?c=site&a=entry&do=content&m=group_buy',64,'fa fa-cog','1','content','index','内容管理',300,NULL,1),
(140,'内容列表','./index.php?c=site&a=entry&do=content&m=group_buy&op=index',139,'fa fa-cog','1','content','index','内容列表',1,NULL,1),
(141,'内容分类','./index.php?c=site&a=entry&do=content&m=group_buy&op=class',139,'fa fa-cog','1','content','class','内容分类',2,NULL,1),
(142,'用户中心','./index.php?c=site&a=entry&op=member_diys&do=diy&m=group_buy',34,'fa fa-cog','1','diy','member_diys','用户中心',300,NULL,1);
");
//插入新插件数据
pdo_run("insert  into ".tablename('gpb_plug')." (`id`,`cate`,`name`,`add_time`,`icon`,`comment`,`plug_order`,`status`,`is_del`,`key`,`url`,`buy_url`) values 
(1,0,'积分商城',NULL,'/addons/group_buy/public/bg/fraction.png','',1,1,1,'group_buy_plugin_fraction','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_fraction&version_id=0','https://s.w7.cc/module-17917.html'),
(2,0,'分销商城',NULL,'/addons/group_buy/public/bg/distribution.png','',2,1,1,'group_buy_plugin_distribution','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_distribution&version_id=0','https://s.w7.cc/module-18137.html'),
(3,0,'整点秒杀',NULL,'/addons/group_buy/public/bg/seckill.png','',3,1,1,'group_buy_plugin_seckill','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_seckill&version_id=0','https://s.w7.cc/module-19790.html');");

if(!pdo_tableexists("scmm_newtmpl")){
    pdo_run(" CREATE TABLE ".tablename("scmm_newtmpl")." (
                  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '新订阅消息',
                  `name` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '获取值所需名称',
                  `sceneDesc` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '标题',
                  `type` int(2) NOT NULL DEFAULT '1' COMMENT '类型,1小程序，2公众号，3公众号模板消息',
                  `module` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '所属模块',
                  `weid` int(11) NOT NULL COMMENT '所属平台id',
                  `tid` int(11) NOT NULL COMMENT '微信对应模板tid',
                  `tmpid` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '模板id',
                  `content` text COLLATE utf8_bin NOT NULL COMMENT '内容详情',
                  `params` text COLLATE utf8_bin NOT NULL COMMENT '参数序列化',
                  `is_use` int(1) NOT NULL DEFAULT '1' COMMENT '是否启用',
                  `status` int(1) NOT NULL DEFAULT '1',
                  `ctime` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
                  `utime` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
}


?>