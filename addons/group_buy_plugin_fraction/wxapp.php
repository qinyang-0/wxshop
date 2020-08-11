<?php
/**
 * 接口文件
 * 2018--10-19
 * 
 */
class Group_buy_plugin_fractionModuleWxapp extends WeModuleWxapp {
	public $weid,$http,$https;
	public $pageindex = 10;
	
	public function __construct(){
		global $_W,$_GPC;
		$this->weid = $_GPC['__uniacid'];
		//获取是否是对象储存
		$this->https =  ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
	}
	
	public function doPageZx(){
		echo 321;
		exit;
	}
	
}
?>