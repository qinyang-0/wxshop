<?php


global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块


switch($op){
	case 'index':
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename('gpb_recharge')." where status = 1 and weid=".$weid);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename('gpb_recharge')." where status = 1 and weid=".$weid." order by weight desc ".$contion;
		$info = pdo_fetchall($sql);
	break;
	case 'add':
		if($_GPC['submit'] == '提交'){
//		if(checksubmit('submit')){
			$data = $_POST;
			if(empty($data['title'])){
				echo json_encode(['code'=>1,'msg'=>'请填写标题']);exit;
			}
			if(empty($data['money'])){
				echo json_encode(['code'=>1,'msg'=>'请填写充值金额']);exit;
			}
			unset($data['id']);
			unset($data['submit']);
			$data['weid'] = $weid;
			if($id){
				$res = pdo_update('gpb_recharge',$data,array('id'=>$id));
			}else{
				$data['create_time'] = time();
				$res = pdo_insert('gpb_recharge',$data);
			}
			echo empty($res) ? json_encode(['code'=>1,'msg'=>'操作失败']) : json_encode(['code'=>0,'msg'=>'操作成功']); 
			exit;
		}else{
			if($id){
				$info = pdo_get("gpb_recharge",array('id'=>$id));
				if($info['give_level']){
					$res = pdo_fetchall(" select * from ".tablename("gpb_member_card_time")." where weid = ".$weid." and status = 1 and c_id = ".$info['give_level']." order by id asc");
				}
			}
			$card = pdo_getall("gpb_member_card",array('weid'=>$this->weid,'status'=>1));
		}
	break;
	case 'recharge':
		$val = $_GPC['val'];
		if(empty($val)){
			echo json_encode(['code'=>1,'msg'=>'参数错误']);exit;
		}
		$res = pdo_fetchall(" select * from ".tablename("gpb_member_card_time")." where weid = ".$weid." and status = 1 and c_id = ".$val." order by id asc");
		if(empty($res)){
			echo json_encode(['code'=>1,'msg'=>'暂无数据']);exit;
		}else{
			echo json_encode(['code'=>0,'msg'=>'成功','data'=>$res]);exit;
		}
	break;
	case 'del':
		if(empty($id)){
			echo json_encode(['code'=>1,'msg'=>'参数错误']);exit;
		}
		$res = pdo_update('gpb_recharge',array('status'=>2),array('id'=>$id));
		echo empty($res) ? json_encode(['code'=>1,'msg'=>'操作失败']) : json_encode(['code'=>0,'msg'=>'操作成功']); 
		exit;
	break;
	case 'bannel':
		//余额配置信息
		$_GPC['do']= 'config';
		$info = pdo_getall($this->config,['status'=>1,'type'=>19,'weid'=>$weid]);
		if($info){
			$data = [];
			foreach($info as $k=>$v){
				$data[$v['key']] = $v['value'];
			}
		}
		$info = $data;
	break;
	case 'bannel_add':
		//添加余额配置
		$post = $_POST;
		unset($post['submit']);
		if($post){
			foreach($post as $k=>$v){
				$config = pdo_get($this->config,array('status'=>1,'type'=>19,'weid'=>$weid,'key'=>$k),array(),'id');
				if($config){
					pdo_update($this->config,array('status'=>1,'type'=>19,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()),array('id'=>$config['id']));
				}else{
					pdo_insert($this->config,array('status'=>1,'type'=>19,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()));
				}
			}
			$this->message_info('操作成功', $this->createWebUrl('markrting',['op'=>'bannel']), 'success');
		}else{
			$this->message_info('未做出任何修改');
		}
	break;
	case 'member_card':
		//会员卡
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename('gpb_member_card')." where status = 1 and weid=".$weid);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename('gpb_member_card')." where status = 1 and weid=".$weid." order by id desc ".$contion;
		$info = pdo_fetchall($sql);
	break;
	case 'member_card_add':
		if($_GPC['submit'] == '提交'){
			$data = $_POST;
			unset($data['submit']);
			unset($data['id']);
			if(empty($data['title'])){
				echo json_encode(['code'=>1,'msg'=>'请填写会员卡标题']);exit;
			}
			if(empty($data['discount']) && $data['discount'] != 0){
				echo json_encode(['code'=>1,'msg'=>'请填写会员卡折扣']);exit;
			}
			if(empty($data['card_time']) || empty($data['card_commpay']) || empty($data['card_money'])){
				echo json_encode(['code'=>1,'msg'=>'请填写会员卡状态']);exit;
			}
			$card = [
				'title'=>$data['title'],
				'discount'=>$data['discount'],
				'c_status'=>$data['c_status'],
				'weid'=>$weid,
				'content'=>$_GPC['content'],
			];
			if($id){
				//修改
				$res = pdo_update("gpb_member_card",$card,array('id'=>$id));
//				pdo_delete("gpb_member_card_time",array('c_id'=>$id));
				if(!empty($data['card_time']) && !empty($data['card_commpay']) && !empty($data['card_money']) && !empty($data['card_moneys'])){
					foreach($data['card_time'] as $k=>$v){
						if($data['card_id'][$k]){
							pdo_update("gpb_member_card_time",array('c_id'=>$id,'day'=>$v,'company'=>$data['card_commpay'][$k],'money'=>$data['card_money'][$k],'original_price'=>$data['card_moneys'][$k],'weid'=>$weid),array('id'=>$data['card_id'][$k]));
						}else{
							pdo_insert("gpb_member_card_time",array('c_id'=>$id,'day'=>$v,'company'=>$data['card_commpay'][$k],'money'=>$data['card_money'][$k],'original_price'=>$data['card_moneys'][$k],'weid'=>$weid));
						}
					}
				}
				echo json_encode(['code'=>0,'msg'=>'修改成功']);exit;
			}else{
				//新增
				$card['create_time'] = time();
				$res = pdo_insert('gpb_member_card',$card);
				if(empty($res)){
					echo json_encode(['code'=>1,'msg'=>'新增失败']);exit;
				}
				$uid = pdo_insertid();
				if(!empty($data['card_time']) && !empty($data['card_commpay']) && !empty($data['card_money'])){
					foreach($data['card_time'] as $k=>$v){
						pdo_insert("gpb_member_card_time",array('c_id'=>$uid,'day'=>$v,'company'=>$data['card_commpay'][$k],'money'=>$data['card_money'][$k],'weid'=>$weid));
					}
				}
				echo json_encode(['code'=>0,'msg'=>'新增成功']);exit;
			}
		}else{
			if($id){
				$info = pdo_get("gpb_member_card",array('weid'=>$this->weid,'status'=>1,'id'=>$id));
				$card = pdo_fetchall(" select * from ".tablename('gpb_member_card_time')." where weid = ".$this->weid." and status = 1 and c_id = ".$id." order by id asc");
//				$card = pdo_getall("gpb_member_card_time",array('weid'=>$this->weid,'status'=>1,'c_id'=>$id), array() , '' , array('id','asc'));
				if($card){
					$info['card'] = $card;
				}
			}
		}
	break;
	case 'member_card_del':
		if(empty($id)){
			echo json_encode(['code'=>1,'msg'=>'参数错误']);exit;
		}
		$res = pdo_delete('gpb_member_card',array('id'=>$id));
		$res = pdo_delete('gpb_member_card_time',array('c_id'=>$id));
		echo empty($res) ? json_encode(['code'=>1,'msg'=>'操作失败']) : json_encode(['code'=>0,'msg'=>'操作成功']); 
		exit;
	break;
	case 'markrting_recharge':
		//充值记录
		$where = '';
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename('gpb_recharge_info')." i join ".tablename("gpb_member")." m on i.openid = m.m_openid where i.status = 1 and i.weid=".$weid." and i.pay_status = 20".$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select i.*,m.m_nickname,m.m_photo from '.tablename('gpb_recharge_info')." i join ".tablename("gpb_member")." m on i.openid = m.m_openid where i.status = 1 and i.weid=".$weid." and i.pay_status = 20 ".$where." order by time desc ".$contion;
		$info = pdo_fetchall($sql);
	break;
}

include $this -> template('web/' . $do . '/' . $op);
?>