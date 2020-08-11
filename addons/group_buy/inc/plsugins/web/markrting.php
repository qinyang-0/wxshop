<?php
/**
 * 会员充值
 */
switch($in){
	case 'index':
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename('gpb_recharge')." where status = 1 and recharge_type = 1 and weid=".$weid);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename('gpb_recharge')." where status = 1 and recharge_type = 1 and weid=".$weid." order by weight desc ".$contion;
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
			$this->message_info('操作成功', $this->createWebUrl('plsugins',['op'=>'markrting','in'=>'bannel']), 'success');
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
		$title = $_GPC['title'];
		if($title){
			$where .= " and (m.m_nickname like '%".trim($title)."%' or m.m_nickname like '%".base64_encode(trim($title))."%')";
		}
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename('gpb_recharge_info')." i join ".tablename("gpb_member")." m on i.openid = m.m_openid where i.status = 1 and i.recharge_type = 1 and i.weid=".$weid." and i.pay_status = 20".$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select i.*,m.m_nickname,m.m_photo,m.m_money_balance from '.tablename('gpb_recharge_info')." i join ".tablename("gpb_member")." m on i.openid = m.m_openid where i.status = 1 and i.weid=".$weid." and i.recharge_type = 1 and i.pay_status = 20 ".$where." order by time desc ".$contion;
		$info = pdo_fetchall($sql);
		if($info){
			foreach($info as $k=>$v){
			    if($this->check_base64_out_json($v['m_nickname'])){
                    $info[$k]['m_nickname'] = base64_decode($v['m_nickname']);
                }
				//计算使用了多少余额   
				$moneys = pdo_fetchall(" select sum(go_balance_price) as money from ".tablename('gpb_order')." where openid = '".$v['openid']."'");
				$info[$k]['balance_price'] = $moneys[0]['money'];
				//计算应该给用户返利多少
				//查询当前  返利多少天
//				该释放多少钱
				if(empty($v['rebate_create_time'])){
					//没有开始释放时间
					//根据支付时间  算
					
					
					
				}else{
					//根据rebate_create_time 来算
					$strtotime = strtotime(date("Y-m-d",time()));
					$is = $strtotime - strtotime(date("Y-m-d 00:00:00",$v['pay_time']));
					$info[$k]['is'] = $is/86400;
				}
				//计算后台为用户充值了好多余额
				$regchar = pdo_fetch(" select sum(money) as money from ".tablename('gpb_recharge_log')." where pay_f = 2 and st = 2 and openid = '".$v['openid']."'");
				$info[$k]['regchar'] = $regchar['money'] ? $regchar['money'] :0;
			}
		}
	break;
	case 'gold':
		$time = strtotime(date("Y-m-d"));
		$this->recharge_list($time);
		$where = '';
		$title = trim($_GPC['title']);
		$type = $_GPC['type'];
		if($title){
			$where .= " and ( m.m_nickname like '%".$title."%' or m.m_nickname like '%".base64_encode($title)."%' )";
		}
		if($type){
			$where .= " and l.overdue = ".$type;
		}
		$stay = pdo_fetchall('select sum(l.money) as money from '.tablename('gpb_member')." m join ".tablename("gpb_recharge_list")." l on m.m_openid = l.openid where l.time > ".$time." and m.weid = ".$this->weid.$where);//待释放
		$already = pdo_fetchall('select sum(l.money+l.use_money) as money from '.tablename('gpb_member')." m join ".tablename("gpb_recharge_list")." l on m.m_openid = l.openid where l.time <= ".$time." and m.weid = ".$this->weid.$where);//已释放
		$money = pdo_fetchall('select sum(l.money) as money from '.tablename('gpb_member')." m join ".tablename("gpb_recharge_list")." l on m.m_openid = l.openid where l.time <= ".$time." and m.weid = ".$this->weid.$where);//已释放
		$use_money = pdo_fetchall('select sum(l.use_money) as money from '.tablename('gpb_member')." m join ".tablename("gpb_recharge_list")." l on m.m_openid = l.openid where l.time <= ".$time." and m.weid = ".$this->weid.$where);//已释放
		
		
		$where .= " and l.time <= ".$time;
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 20;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn(" select count(*) from ".tablename("gpb_member")." m join ".tablename("gpb_recharge_list")." l on m.m_openid = l.openid where m.weid = ".$this->weid.$where);
//		pdo_debug();
//		echo $total;exit;
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select l.*,m.m_nickname,m.m_photo,m.m_phone from '.tablename('gpb_member')." m join ".tablename("gpb_recharge_list")." l on m.m_openid = l.openid where m.weid = ".$this->weid.$where." order by time desc ".$contion;
//		pdo_debug();
		$info = pdo_fetchall($sql);
		if($info){
			foreach($info as $k=>$v){
				if($this->check_base64_out_json($v['m_nickname'])){
                    $info[$k]['m_nickname'] = base64_decode($v['m_nickname']);
                }	
			}
		}
	break;
	case 'recharge_indexlock':
		include_once '../addons/group_buy/function.php';
		recharge_indexlock($weid);
		echo json_encode(['code'=>1,'msg'=>'刷新成功']);exit;
	break;
	case 'markrting_del_fl':
		if(empty($id)){
			echo json_encode(['code'=>2,'msg'=>'非法进入']);exit;
		}
		//获取这个订单的用户信息
		$info = pdo_get("gpb_recharge_info",array('id'=>$id));
		if(empty($info)){
			return json_encode(array('code'=>2,'msg'=>'该用户返利已清0'));
		}
		$res = pdo_delete("gpb_recharge_list",array('openid'=>$info['openid']));
		if($res){
			pdo_update('gpb_recharge_info',array('cleraing'=>'2'),array('openid'=>$info['openid']));
		}
		echo json_encode(array('code'=>1,'msg'=>'清除成功'));exit;
	break;
}
?>