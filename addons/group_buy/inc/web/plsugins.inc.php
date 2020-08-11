<?php
/**
 * 插件
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
empty($in) ? $in = 'index' : $in ;
$weid = $this->weid;  //控制模块
if(!empty($op)){
	$_GPC['do'] = $op;
	require_once '../addons/group_buy/inc/plsugins/web/'.$op.".php";
}else{
	//不知道进那里
	exit('op不存在');
}
include $this -> template($do . '/' . $op.'/'.$in);
?>