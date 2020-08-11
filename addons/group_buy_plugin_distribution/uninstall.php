<?php
//卸载执行脚本
pdo_query("
	DROP TABLE IF EXISTS ".tablename('gpb_distribution_cash_money').";
	DROP TABLE IF EXISTS ".tablename('gpb_distribution_group').";
	DROP TABLE IF EXISTS ".tablename('gpb_distribution_group_log').";
	DROP TABLE IF EXISTS ".tablename('gpb_distribution_list').";
	DROP TABLE IF EXISTS ".tablename('gpb_distribution_log').";
	DROP TABLE IF EXISTS ".tablename('gpb_distribution_menu').";
	DROP TABLE IF EXISTS ".tablename('gpb_distribution_money').";
	DROP TABLE IF EXISTS ".tablename('gpb_distribution_money_log').";
");
?>