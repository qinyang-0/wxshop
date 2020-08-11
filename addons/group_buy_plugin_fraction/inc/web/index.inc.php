<?php
header("Content-type:text/html;charset=utf-8");
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$in = $_GPC['in'];
//获取商品总量
$count1 = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_goods)." where weid = ".$this->weid." and type = 2 and g_is_del = 1");
//获取用户总量
$count2 = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_member)." where weid = ".$this->weid);
//获取订单总量
$count3 = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_order)." where weid = ".$this->weid." and go_is_del = 1 and type = 2");
//等级总量
$count4 = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_goods_cate)." where weid = ".$this->weid." and type = 2");
$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));//昨日开始时间
$endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;//结束时间
//获取今日的销售积分，昨日的积分，订单数，新增用户，下单用户



//echo date('Y-m-d H:i:s',$beginYesterday).'--'.date('Y-m-d H:i:s',$endYesterday);exit;
//获取前七日的时间戳
$data = $list = [];
for($i=1;$i<=20;$i++){
	$data[$i]['star'] = mktime(0,0,0,date('m'),date('d')-$i,date('Y'));
	$data[$i]['end'] = mktime(0,0,0,date('m'),date('d'),date('Y'))-($i*86400-86399);
	$list[$i] = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-$i,date('Y')));
}
$list = json_encode($list);
//获取前七日的数据
$last = [];
foreach($data as $k=>$v){
	//获取新增用户
	$last[$k]['member'] = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_member)." where m_add_time >= ".$v['star']." and m_add_time <= ".$v['end']." and weid = ".$this->weid);
	//获取新增商品
	//$last[$k]['goods'] = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_goods)." where g_add_time >= ".$v['star']." and g_add_time <= ".$v['end']." and weid = ".$this->weid." and type = 2");
	//获取新增订单
	$last[$k]['order'] = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_order)." where go_add_time >= ".$v['star']." and go_add_time <= ".$v['end']." and weid = ".$this->weid." and type = 2");
}
$data = json_encode(['用户数量','订单数量']);
//$data = json_encode(['成交量', '成交额','订单额']);
$member = $goods = $order = $total = [];
foreach($last as $k=>$v){
	$member[$k] = $v['member'];
}
$total[0]['name'] = '用户数量';
$total[0]['type'] = 'line';
$total[0]['data'] = $member;
//foreach($last as $k=>$v){
//	$goods[$k] = $v['goods'];
//}
//$total[1]['name'] = '商品数量';
//$total[1]['type'] = 'line';
//$total[1]['data'] = $goods;
foreach($last as $k=>$v){
	$order[$k] = $v['order'];
}
$total[1]['name'] = '订单数量';
$total[1]['type'] = 'line';
$total[1]['data'] = $order;
$total = json_encode($total);
//echo '<pre>';
//print_r($data);
//exit;

include $this->template('web/'.$do.'/'.$op);
?>