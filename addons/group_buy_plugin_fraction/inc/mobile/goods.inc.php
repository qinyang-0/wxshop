<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$index=isset($_GPC['page'])?$_GPC['page']:1;
//获取所有条件
$where = '';
$order = ' g_order asc ';
//名称
if($_GPC['g_name']){
	$where .= " and g_name like '%".$_GPC['g_name']."%'";
}
//积分区间
if($_GPC['searchMin']){
	$where .= " and g_price >= ".$_GPC['searchMin'];
}
if($_GPC['searchMax']){
	$where .= " and g_price <= ".$_GPC['searchMax'];
}
//类型
if($_GPC['g_cid']){
	$where .= " and g_cid = ".$_GPC['g_cid'];
}
if($_GPC['sort']){
	$order = " {$_GPC['sort']} {$_GPC['type']} ";
}
//获取所有的分类
$cate = pdo_fetchall(" select gc_id,gc_name from ".tablename($this->gpb_goods_cate)." where weid = ".$this->weid." and gc_is_del = 1 and gc_pid != 0 order by gc_order asc ");
//根据排序获取前10个商品
$pageIndex = $index;
$pageSize = $this->pageSize;
$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_goods)." where weid = ".$this->weid." and g_is_del = 1 and g_is_online = 1 and type = 2 ".$where);	
$page = pagination($total,$pageIndex,$pageSize);
$sql = "select g_id,g_name,g_price,g_icon from ".tablename($this->gpb_goods)." where weid = ".$this->weid." and g_is_del = 1 and g_is_online = 1 and type = 2 ".$where." order by ".$order.$contion;
$info = pdo_fetchall($sql);
if($_GPC['types'] == 'ajax'){
	if($info){
		foreach($info as $k=>$v){
			$info[$k]['g_icon'] = tomedia($v['g_icon']);
		}
		$this->res(0,'',$info);
	}else{
		if($index == 1){
			$this->res(0,'',[]);
		}else{
			$this->res(1,'');
		}
	}
}
include $this->template($do.'/'.$op);
?>