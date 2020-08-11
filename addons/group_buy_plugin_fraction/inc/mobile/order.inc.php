<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$user = $_SESSION['user'];
$id = $_GPC['id'];//商品id
$add = $_GPC['address'];//商品id
if(empty($user)){
	header('Location:'.$this->createMobileUrl('login'));
}
$user = pdo_get($this->gpb_member,array('m_id'=>$user['m_id']));
switch($op){
	case 'index':
		//根据用户的id去查找用户的地址
		if(empty($add)){
			$address = pdo_get($this->gpb_address,array('m_id'=>$user['m_id'],'mr'=>2,'weid'=>$this->weid));
			if(empty($address)){
				$address = pdo_get($this->gpb_address,array('m_id'=>$user['m_id'],'weid'=>$this->weid));
			}
		}else{
			$address = pdo_get($this->gpb_address,array('id'=>$add));
		}
		//获取商品信息
		$goods = pdo_get($this->gpb_goods,array('g_id'=>$id));
		//一次只能兑换一个
	break;
	case 'add':
		if(empty($add)){
			$this->res(1,'请选择收货地址');
		}
		$address = pdo_get($this->gpb_address,array('id'=>$add));
		if(empty($address)){
			$this->res(1,'该地址不存在');
		}
		$goods = pdo_get($this->gpb_goods,array('g_id'=>$id));
		if(empty($goods)){
			$this->res(1,'该商品不存在');
		}
		//获取规格
		$num = pdo_get($this->gpb_goods_stock,array('goods_id'=>$id));
		if(empty($num) || $num['num'] <= 0){
			$this->res(1,'库存错误');
		}
		//获取积分
		if($user['integral'] <= 0 || $user['integral'] <= $goods['g_price']){
			$this->res(1,'余额不足');
		}
		$count = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_order)." where go_vid = ".$user['m_id']." and go_gid = ".$goods['g_id']);
		if($goods['limit'] > 0 && $goods['limit'] <= $count){
			$this->res(1,'你已经兑换过'.$goods['limit']."次了，不能再兑换了!");
		}
		//生成订单号
		$create = $this->creat_on();
		//添加商品表
		$data = [];
		$data['go_code'] = $create;
		$data['go_gid'] = $id;
		$data['go_adress_id'] = $add;
		$data['openid'] = $_W['openid'];
		$data['go_vid']  = $user['m_id'];
		$data['go_status'] = 10;
		$data['go_add_time'] = time();
		$data['go_num'] = 1;
		$data['go_all_old_price'] = 1*$goods['g_price'];
		$data['go_all_price'] = 1*$goods['g_price'];
		$data['go_real_price'] = 1*$goods['g_price'];
		$data['type'] = 2;
		$data['go_status'] = 20;
		$data['weid'] = $this->weid;
		$res = pdo_insert($this->gpb_order,$data);
		$uid = pdo_insertid();
		$data = [];
		//快照
		$data['oss_go_id'] = $uid;
		$data['oss_go_code'] = $create;
		$data['oss_gid'] = $id;
		$data['oss_g_price'] = $goods['g_price'];
		$data['oss_g_old_price'] = $goods['g_price'];
		$data['oss_g_num'] = 1;
		$data['oss_g_name'] = $goods['g_name'];
		$data['oss_g_icon'] = $goods['g_icon'];
		$data['oss_buy_openid'] = $_W['openid'];
		$data['oss_buy_name'] = $user['m_name'];
		$data['oss_buy_phone'] = $user['m_phone'];
		$data['oss_address_id'] = $add;
		$data['oss_address'] = $address['address'];
		$data['oss_address_name'] = $address['name'];
		$data['oss_address_phone'] = $address['phone'];
		$data['oss_total_price'] = 1*$goods['g_price'];
		$res = pdo_insert($this->gpb_order_snapshot,$data);
		//减少库存,增加销量
		pdo_update($this->gpb_goods_stock,array('num -='=>1),array('goods_id'=>$id,'weid'=>$this->weid));
		pdo_update($this->gpb_goods,array('g_real_sale_num +='=>1),array('g_id'=>$id,'weid'=>$this->weid));
		//扣除积分
		pdo_update($this->gpb_member,array('integral -='=>$goods['g_price']),array('m_id'=>$user['m_id']));
		$member = pdo_get($this->gpb_member,array('m_id'=>$user['m_id']));
		if($res){
			$str = '你兑换的商品'.$goods['g_name'].'成功，请及时查看信息，及时取货.';
			$this->mails($user['m_id'],$str,$_W['openid']);
			$str = "兑换礼品：".$goods['g_name']."，消费积分:".$goods['g_price'].",剩余积分:".$member['integral'];
			$data = ['gol_uid'=>$user['m_id'],'gol_add_time'=>time(),'gol_comment'=>$str,'gol_des'=>'积分减少'];
			pdo_insert($this->gpb_order_log,$data);
			$this->res(0,'兑换成功');
		}else{
			$this->res(1,'兑换失败');
		}
	break;
}
include $this->template($do.'/'.$op);
?>