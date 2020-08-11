<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$user = $_SESSION['user'];
$index=isset($_GPC['page'])?$_GPC['page']:1;
if(empty($user)){
	header('Location:'.$this->createMobileUrl('login'));
}


switch($op){
	case 'index':
		$id = $user['m_id'];
		$status = $_GPC['status'];
		$where = '';
		if(!empty($status)){
			$where .= ' and go_status = '.$status;
		}
		//分页
		$pageIndex = $index;
		$pageSize = $this->pageSize;
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn(" select count(*) from ".tablename($this->gpb_order)." as o join ".tablename($this->gpb_order_snapshot)." as s on o.go_code = s.oss_go_code where o.weid = ".$this->weid." and o.type = 2 and go_vid = ".$user['m_id'].$where );	
		$page = pagination($total,$pageIndex,$pageSize);
		$sql = " select * from ".tablename($this->gpb_order)." as o join ".tablename($this->gpb_order_snapshot)." as s on o.go_code = s.oss_go_code where o.weid = ".$this->weid." and o.type = 2  and go_vid = ".$user['m_id'].$where." order by o.go_add_time desc ";
		$info = pdo_fetchall($sql.$contion);
		if($_GPC['type'] == 2){
			//ajax请求
			if(!empty($info)){
				foreach($info as $k=>$v){
					$info[$k]['oss_g_icon'] = tomedia($v['oss_g_icon']);
				}
			}
			$this->res(0,'',$info);
		}
	break;
	case 'save':
		//确认收货
		$id = $_GPC['id'];
		if(empty($id)){
			$this->res(1,'请传入id');
		}
		$info = pdo_get($this->gpb_order,array('go_id'=>$id));
		if(empty($info)){
			$this->res(1,'该订单不存在');
		}
		//收货
		$res = pdo_update($this->gpb_order,array('go_status'=>100,'time2'=>time()),array('go_id'=>$id));
		if(empty($res)){
			$this->res(1,'收货失败');
		}else{
			$this->res(0,'收货成功');
		}
	break;
}


include $this->template($do.'/'.$op);
?>