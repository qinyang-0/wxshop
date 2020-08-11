<?php

//用户催单功能
global $_W,$_GPC;
$openid = $_GPC['openid'];//用户openid
$order = $_GPC['order'];//订单号
if(empty($order)){
	$this->result(1,'订单号错误');
}
//判断是否开启催单
$reminder_status = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'index_reminder_status'));
$reminder_status = $reminder_status['value'] ? $reminder_status['value'] : 1;
if($reminder_status == 1){
	$this->result(1,'暂未开启催单功能');
}
//开启了催单功能  获取订单信息  发送的短信的配置
require_once '../addons/group_buy/sms.php';
$sms = new Sms();

$snapshot = pdo_fetchall("select oss_g_name,oss_head_openid,oss_head_name,oss_buy_name from ".tablename('gpb_order_snapshot')." where oss_go_code = '".$order."'");
if(empty($snapshot)){
	$this->result(1,'订单错误');
}
$head_openid = $snapshot[0]['oss_head_openid'];//团长openid
$head_name = $snapshot[0]['oss_head_name'];//团长昵称
if($this->check_base64_out_json($head_name)){
	$head_name = base64_decode( $head_name );
}
$buy_name = $snapshot[0]['oss_buy_name'];//用户昵称
if($this->check_base64_out_json($buy_name)){
	$buy_name = base64_decode( $buy_name );
}
$goods = '';
foreach($snapshot as $k=>$v){
	$goods .= $v['oss_g_name'].",";
}
//当商品的长度大于20时，需要截取
if(mb_strlen($goods) > 20){
	$goods = mb_substr($goods, 0,18);
}
$goods .= "等";
$goods = trim($goods,',');//商品信息
//获取下单时间
$time = pdo_get("gpb_order",array('go_code'=>$order),array('go_add_time','go_status'));
//if($time['go_status'] != 20 || $time['go_status'] != 30){
//	$this->result(1,'订单状态错误');
//}
$time = date("Y-m-d H:i",$time['go_add_time']);
//获取电话号码那些东西
$reminder_platform_status = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'index_reminder_platform_status'));
$reminder_platform_status = $reminder_platform_status['value'] ? $reminder_platform_status['value'] : 1;
$info = pdo_getall($this->config,['status'=>1,'type'=>2,'weid'=>$this->weid],array(),"key");
$sms_reminder = unserialize($info['sms_reminder']['value']);//催单短信配置
$manage = unserialize($info['sms_admin']['value']);//管理员电话
$content = array('0' => $head_name, '1' => $buy_name,'2'=>$goods,'3'=>$time);
if($info['sms_type']['value'] != 1){
	$this->result(1,'未开启短信配置');
}
if(empty($sms_reminder)){
	$this->result(1,'催单短信未配置');
}

//获取配置信息
$data = unserialize($info['sms_data']['value']);
$arr = [];
$arr['sms_key'] = $data['key']['value'];
$arr['sms_sign'] = $data['sign']['value'];
$arr['sms_serect'] = $data['serect']['value'];
$arr['sms_id'] = $sms_reminder['id']['value'];
$arr['sms_var'] = $sms_reminder['content']['value'];

if($reminder_platform_status == 2){
	//获取平台的电话号码
	if($info['sms_admin']['value']){
		$admin = unserialize($info['sms_admin']['value']);
	}
}
//获取团长的电话
$head_tel = pdo_get("gpb_member",array('m_openid'=>$head_openid),array('m_phone','tel'));
$phone = [];
if($head_tel['tel']){
	$phone[] = unserialize($head_tel['tel']);
}
$phone[count($phone)] = $head_tel['m_phone'];
if($admin){
	$phone = array_merge($phone,$admin);
}
if(!$phone){
	$this->result(1,'没有可发送短信的电话号码');
}
$data = [];
foreach($phone as $k=>$v){
	$data[] = $sms->alicloud($v,$arr,$content);
}
$this->result(0,'发送短信成功',$data);
//$sms->alicloud();
?>