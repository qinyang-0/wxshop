<?php
//卸载执行脚本
pdo_query("
	DROP TABLE IF EXISTS ".tablename('gpb_package_goods').";
	DROP TABLE IF EXISTS ".tablename('gpb_package_goods_option').";
	DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_adv').";
	DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_category').";
	DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_task').";
	DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_task_goods').";
	DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_task_room').";
	DROP TABLE IF EXISTS ".tablename('gpb_shop_seckill_task_time').";
");
pdo_delete('gpb_distribution_menu',array('status'=>2));
?>