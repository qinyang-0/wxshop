<?php
include_once '../addons/group_buy/sms.php';
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块

//$a = pdo_fetchcolumn(" select count(uid) as money from ".tablename('users'));
//var_dump($a);exit;
//exit();
$config = pdo_getall('gpb_config',array('weid'=>$weid,'status'=>1,'type'=>18));
if($config){
	$data = [];
	foreach($config as $k=>$v){
		$data[$v['key']] = $v['value'];
	}
}
$config = $data;
if($config['wechat_id'] != 1){
	echo '暂未开启';exit;
}
$sms = new Sms();
$info = $sms->wechat_openid($config['wechat_appid'],$config['wechat_secert']);
if($info){
	$res = pdo_update("gpb_member",array('wx_public_openid'=>$info['openid']),array('unionid'=>$info['unionid']));
}else{
	echo '获取信息失败';exit;
}
include $this->template('index');
?>