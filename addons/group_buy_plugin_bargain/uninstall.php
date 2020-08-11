<?php
//卸载执行脚本
pdo_query("
	DROP TABLE IF EXISTS ".tablename('gpb_bargaion_record').";
	DROP TABLE IF EXISTS ".tablename('gpb_bargaion_goods').";
	DROP TABLE IF EXISTS ".tablename('gpb_bargain_action').";
");
?>