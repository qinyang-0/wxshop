<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$id = $_GPC['id'];
if(empty($id)){
	message('非法进入');exit;
}

switch($op){
	case 'index':
		$info = pdo_get($this->gpb_goods,array('g_id'=>$id,'g_is_del'=>1,'weid'=>$this->weid));
		$info['g_thumb'] = unserialize($info['g_thumb']);
	break;
	case 'save':
		//查询库存
		$number = pdo_get($this->gpb_goods_stock,array('goods_id'=>$id,'weid'=>$this->weid));
		$user = $_SESSION['user'];
		if(!empty($user)){
			$int = pdo_get($this->gpb_member,array('m_id'=>$user['m_id']));
		}
		$this->res(0,'',['num'=>$number['num'],'ints'=>$int['integral']]);
	break;
	case 'ceta':
		//查询库存状态
		if(empty($id)){
			$this->res(1,'非法进入');
		}
		//判断用户是否登录
		$user = $_SESSION['user'];
		if(empty($user)){
			$this->res(1,'请先登录',$this->createMobileUrl('login',array('type'=>'goods_info,'.$id)));
		}
		$num = pdo_get($this->gpb_goods_stock,array('goods_id'=>$id,'weid'=>$this->weid));
		if($num['num'] <= 0){
			$this->res(1,'库存不足,无法兑换');
		}
		//判断用户积分是否足够
		$member = pdo_get($this->gpb_member,array('m_id'=>$user['m_id']));
		//获取商品价格
		$goods = pdo_get($this->gpb_goods,array('g_id'=>$id));
		if($member['integral'] < $goods['g_price']){
			$this->res(1,'积分不足，无法兑换');
		}
		//判断是否能够兑换
		$count = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_order)." where go_vid = ".$member['m_id']." and go_gid = ".$goods['g_id']);
		if($goods['limit'] > 0 && $goods['limit'] <= $count){
			$this->res(1,'你已经兑换过'.$goods['limit']."次了，不能再兑换了!");
		}
		$this->res(0,'');
	break;
	
}

include $this->template($do.'/'.$op);
?>