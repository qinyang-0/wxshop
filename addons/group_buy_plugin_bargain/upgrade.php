<?php
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
