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
		//余额配置信息
		$_GPC['do']= 'config';
		$info = pdo_getall($this->config,['status'=>1,'type'=>20,'weid'=>$weid]);
		if($info){
			$data = [];
			foreach($info as $k=>$v){
				$data[$v['key']] = $v['value'];
			}
		}
		$info = $data;
	break;
	case 'card_add':
		//添加余额配置
		$post = $_POST;
		unset($post['submit']);
		if($post){
			foreach($post as $k=>$v){
				$config = pdo_get($this->config,array('status'=>1,'type'=>20,'weid'=>$weid,'key'=>$k),array(),'id');
				if($config){
					pdo_update($this->config,array('status'=>1,'type'=>20,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()),array('id'=>$config['id']));
				}else{
					pdo_insert($this->config,array('status'=>1,'type'=>20,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()));
				}
			}
			$this->message_info('操作成功', $this->createWebUrl('card',['op'=>'index']), 'success');
		}else{
			$this->message_info('未做出任何修改');
		}
	break;
	case 'member_card':
		$_GPC['do']= 'markrting';
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
		$_GPC['do']= 'markrting';
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
				'sort'=>$_GPC['sort'],
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
	case 'card_save_sort':
		if(empty($id)){
			echo json_encode(['code'=>1,'msg'=>'参数错误']);exit;
		}
		$res = pdo_update("gpb_member_card",array('sort'=>$_GPC['val']),array('id'=>$id));
		echo empty($res) ? json_encode(['code'=>1,'msg'=>'操作失败']) : json_encode(['code'=>0,'msg'=>'操作成功']); 
		exit;
	break;
}

include $this -> template('web/' . $do . '/' . $op);
?>