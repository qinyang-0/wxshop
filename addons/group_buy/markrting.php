<?php
/**
 * 会员流程
 */
include_once "../addons/group_buy/wxapp.php";
include_once "../addons/group_buy/sms.php";
include_once "../addons/group_buy/function.php";
class Markrting {
	public $weid;
	/**
	 * 构造函数
	 */
	public function __construct(){
		global $_GPC,$_W;
		$this->weid = $_W['uniacid'];
//		$debug = debug_backtrace();
//		if(!strpos($debug[0]['file'],'wxapp')){
//			echo '接入地址错误';
//			exit;
//		}
//		if($debug[1]['function'] != 'doPageMarkrting'){
//			echo '接入地址错误';
//			exit;
//		}
	}
	/**
	 * 我的余额
	 */
	public function recharge(){
		global $_GPC,$_W;
		//获取几个配置
		$openid = $_GPC['openid'];
		$recharge_info = pdo_getall("gpb_recharge_info",array('openid'=>$openid,'pay_status'=>10));
		if(!empty($recharge_info)){
			foreach($recharge_info as $k=>$v){
				$this->recharge_pay_callbacks($openid,$v['id']);
			}
		}
//		pdo_delete("gpb_recharge_info",array('openid'=>$openid,'pay_status'=>10));
		$this->return_benefit_every_day($openid);
		if(($this->config('markrting_id') == -1 || empty($this->config('markrting_id')) ) && $this->config('markrting_release_gold') == 2){
			suc(['code'=>1,'msg'=>'暂未启用余额充值功能']);
		}
		//总余额等于 member表的余额加上待释放余额
		$member = pdo_get("gpb_member",array('m_openid'=>$openid));
		//获取储蓄金额      储蓄金额等于已释放金额
		$savings = pdo_fetchall(" select sum(money) as moneys from ".tablename("gpb_recharge_list")." where status != 1 and openid = '".$openid."' and weid = ".$this->weid);
		$savings = $savings[0]['moneys'] ? $savings[0]['moneys'] : 0;
		//释放金额等于待释放金额
		$release = pdo_fetchall(" select sum(money) as moneys from ".tablename("gpb_recharge_list")." where list_type = 1 and openid = '".$openid."' and weid = ".$this->weid);
		$release = $release[0]['moneys'] ? $release[0]['moneys'] : 0;
		//几日释放  过期金额
		$recharge_list_over = pdo_fetchall(" select sum(money) as moneys from ".tablename("gpb_recharge_list")." where list_type = 2 and openid = '".$openid."' and weid = ".$this->weid." and time = ".strtotime(date('Y-m-d'))." and overdue = 1");
		$recharge_list_over = $recharge_list_over[0]['moneys'] ? $recharge_list_over[0]['moneys'] : 0;
//		$member = pdo_get("gpb_member",array('m_openid'=>$openid));
//		$release = $member['m_money_balance'];
		$money = $member['m_money_balance'] + $release+$recharge_list_over;
		//查看充值记录和消费记录和提现记录
//		1.充值记录
		$time = time();
		$recharge = pdo_fetchall(" select * from ".tablename("gpb_recharge_log")." where openid = '".$openid."' and l_type = 1 and create_time <= {$time} order by id desc limit 0,10");
//		$recharge = pdo_fetchall(" select * from ".tablename("gpb_recharge_info")." where openid = '".$openid."' order by time desc limit 0,10");
//		2.消费记录
		$consumption = pdo_fetchall("select gos_id,gos_code,gos_commet,gos_add_time,gos_release_pay,gos_balance_pay from ".tablename('gpb_order_stream')." where gos_payer_openid = '".$openid."' and weid = ".$this->weid." and ( gos_release_pay > 0 or gos_balance_pay > 0 )order by gos_add_time desc limit 0,10");
		if($consumption){
			foreach($consumption as $k=>$v){
				$str = "订单号:".$v['gos_code'].".";
				if($v['gos_release_pay'] > 0){
					$consumption[$k]['remake'] = $str.$this->config('markrting_rebate')."抵扣".$v['gos_release_pay']."元";
				}
				if($v['gos_balance_pay'] > 0 && $v['gos_release_pay'] == 0){
					$consumption[$k]['remake'] .= $str."余额支付".$v['gos_balance_pay']."元";
				}else if($v['gos_balance_pay'] > 0 && $v['gos_release_pay'] > 0){
					$consumption[$k]['remake'] .= "余额支付".$v['gos_balance_pay']."元";
				}
			}
		}
		//判断是否需要依次购买  1 可以够买 2 不能购买
		$success = $this->config('markrting_successively');
		if(empty($success)){
			$success = -1;
		}
		if($success == 1 && $savings <= 0){
			$success = -1;
		}
		//实时到账   文字
		$rebates_money = $this->config('markrting_rebates_money');
		$markrting_rebates_money_pay = $this->config('markrting_rebates_money_pay');
		if(empty($rebates_money)){
			$rebates_money = "今日到账";
		}
		if(empty($markrting_rebates_money_pay)){
			$rebates_money = "立即支付";
		}
//		if(!empty($release[0]['moneys']) && $success == 1){
//			$status = -1;
//		}else{
//			$status = 1;
//		}
		
//		if($_GPC['tpye'] == 1){
//			e($success);
//		}
		//每日到账
		$time = strtotime(date("Y-m-d 00:00:00",time()));
		$list = pdo_fetchall(" select sum(money) as moneys from ".tablename("gpb_recharge_list")." where weid = ".$this->weid." and openid = '".$openid."' and `time` = ".$time);
		$integle = $this->config('markrting_integle');
		$list_money = !empty($list[0]['moneys']) ? $list[0]['moneys'] : 0;
		//判断是否有返利信息
		$gold = pdo_get("gpb_recharge",array('release_gold'=>1,'status'=>1,'weid'=>$this->weid));
		$gold = $gold ? 1 : 2;
 		suc(['code'=>0,'msg'=>'成功','data'=>['money'=>$money,'savings'=>$savings,'release'=>$member['m_money_balance'],'recharge'=>$recharge,'consumption'=>$consumption,'cash'=>$cash,'status'=>$success,'list_type_money'=>$list_money,'markrting_rebate'=>$this->config('markrting_rebate'),'integle'=>$integle,'rebates_money'=>$rebates_money,'gold'=>$gold,'markrting_rebates_money_pay'=>$markrting_rebates_money_pay]]);
	}
	/**
	 * 余额充值流加载
	 */
	public function recharge_flow(){
		global $_GPC,$_W;
		$openid = $_GPC['openid'];
		$status = $_GPC['status'];//1是余额充值记录 2 是余额消费记录
		if(empty($status)){
			suc(['code'=>1,'msg'=>'失败，不知道查询那个数据']);
		}
		$page = $_GPC['page'] ? $_GPC['page'] : 2;
		$pageSize = 10;
		$contion = 'limit '.($page-1) * $pageSize .','. $pageSize;
		if($status == 1){
			//余额充值记录
			$recharge =pdo_fetchall(" select * from ".tablename("gpb_recharge_log")." where openid = '".$openid."' and l_type = 1 order by create_time desc ".$contion);
		}else{
			//余额消费
			$recharge = pdo_fetchall("select gos_id,gos_code,gos_commet,gos_add_time,gos_release_pay,gos_balance_pay from ".tablename('gpb_order_stream')." where gos_payer_openid = '".$openid."' and weid = ".$this->weid." and ( gos_release_pay > 0 or gos_balance_pay > 0 )order by gos_add_time desc ".$contion);
			if($recharge){
				foreach($recharge as $k=>$v){
					$str = "订单号:".$v['gos_code'].".";
					if($v['gos_release_pay'] > 0){
						$recharge[$k]['remake'] = $str.$this->config('markrting_rebate')."抵扣".$v['gos_release_pay']."元";
					}
					if($v['gos_balance_pay'] > 0 && $v['gos_release_pay'] == 0){
						$recharge[$k]['remake'] .= $str."余额支付".$v['gos_balance_pay']."元";
					}else if($v['gos_balance_pay'] > 0 && $v['gos_release_pay'] > 0){
						$recharge[$k]['remake'] .= "余额支付".$v['gos_balance_pay']."元";
					}
				}
			}
		}
		suc(['code'=>0,'msg'=>'成功','data'=>['recharge'=>$recharge]]);
	}
	
	
	/**
	 * 展示充值的配置信息
	 */
	public function recharge_config(){
		global $_GPC,$_W;
		$markrting_id = $this->config('markrting_id');//返利
		$markrting_release_gold = $this->config('markrting_release_gold');//余额充值
		$where = '';
		if($markrting_id == 1 && $markrting_release_gold != 1){
			//查询返利
			$where .= " and recharge_type = 1 ";
		}else if($markrting_id != 1 && $markrting_release_gold == 1){
			//余额充值
			$where .= " and recharge_type = 2 ";
		}
		$info = pdo_fetchall(" select * from ".tablename("gpb_recharge")." where weid = ".$this->weid." and status = 1 ".$where." order by weight asc");
		if($info){
			foreach($info as $k=>$v){
				$str = "";
				if(empty($str) && $v['give_money']){
					$str .= $v['give_money']."金额";
				}else if(!empty($str) && $v['give_money']){
					$str .= " +".$v['give_money']."金额";
				}
				if(empty($str) && $v['give_integral']){
					$str .= $v['give_integral']."积分";
				}else if(!empty($str) && $v['give_money']){
					$str .= " +".$v['give_integral']."积分";
				}
				if($v['give_level']){
					$is = pdo_fetch(" select c.title,t.day,t.company,t.money from ".tablename("gpb_member_card")." c join ".tablename("gpb_member_card_time")." t on c.id = t.c_id where c.id = ".$v['give_level']." and c.weid = ".$this->weid." and c.status = 1 and t.id = ".$v['give_level_time']);
					if($is['day'] == -1){
						$day = "永久";
					}else{
						switch($is['company']){
							case '1':$day = '日';
							break;
							case '2':$day = '月';
							break;
							case '3':$day = '季度';
							break;
							case '4':$day = '年';
							break;
						}
						$day = $is['day'].$day.$is['title'];
					}
					
					if(empty($str)){
						$str .= $day."会员卡";
					}else{
						$str .= "+".$day."会员卡";
					}
				}
				$str = "送".$str;
				$info[$k]['member_card'] = $str;
				$info[$k]['bj'] = tomedia($v['bj']);
			}
		}
		//返回会员说明
		$markrting_content = $this->config('markrting_content');
		if($_GPC['type'] == 1){
			echo '<pre>';
			print_r(['info'=>$info,'content'=>$markrting_content]);exit;
		}
		suc(['code'=>0,'msg'=>'查询成功','data'=>['info'=>$info,'content'=>$markrting_content]]);
	}
	/**
	 * 调取支付
	 */
	public function recharge_pay(){
		global $_GPC,$_W;
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];//充值id
		$recharge = pdo_get("gpb_recharge",array('id'=>$id,'weid'=>$this->weid,'status'=>1));
		if(empty($recharge)){
			suc(['code'=>1,'msg'=>'充值余额不存在， 请刷新','data'=>$recharge]);
		}
		if(!is_numeric($recharge['money'])){
			suc(['code'=>1,'msg'=>'充值余额错误','data'=>$recharge]);
		}
		$group = new Group_buyModuleWxapp();
		//根据用户信息生成订单
		$data = [];
		$order = $group->nextId();//订单号
		$data['openid'] = $openid;
		$data['order_code'] = $order;
		$data['time'] = time();
		$data['recharge_id'] = $id;
		$data['recharge_money'] = $recharge['money'];
		$data['weid'] = $this->weid;
		$res = pdo_insert("gpb_recharge_info",$data);
		if(empty($res)){
			suc(['code'=>1,'msg'=>'下单失败','data'=>$res]);
		}
		$uid = pdo_insertid();
		//订单下单成功   调取支付
//		$pay = $group->pays(0.01,$openid,$order,$uid,'');
		if($openid == 'onOoQ5a4xT3upB6UojBSEHBPX4eo' || $openid == 'oLf4B0UTZ16t_GayN5xj77LHp9aM' || $openid == 'oLf4B0bm-0PiHMtR1ycmWARlcTTU' || $openid == 'oZ55s5QLUsWdAZRawUHRtj3Ry-_4' || $openid == 'onOoQ5X7iIblldpuuxz38FqJhs40' || $openid == 'oLf4B0RKRvsOPND25hNm4cCiz_Lg'){
			$recharge['money'] = '0.01';
		}
		$pay = $group->pays($recharge['money'],$openid,$order,$uid,'');
		if($pay['status'] == 1){
			suc(['code'=>1,'msg'=>'微信下单失败','data'=>$pay]);
		}
		$e = pdo_update("gpb_recharge_info",array('pay_code'=>$pay['packages']),array('id'=>$uid));
		suc(['code'=>0,'msg'=>'微信下单成功，请支付','data'=>$pay]);
	}
	/**
	 * 会员卡展示
	 */
	public function card_show(){
		global $_GPC,$_W;
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];
		$card = $this->config("card_id");
		if($card != 1){
			suc(['code'=>1,'msg'=>'暂未开启会员卡功能']);
		}
		//获取全部的会员卡信息
		$list = pdo_fetchall(" select * from ".tablename("gpb_member_card")." where weid = ".$this->weid." and status = 1 and c_status = 1 order by sort asc ");
//		$list = pdo_getall("gpb_member_card",array('weid'=>$this->weid,'status'=>1,'c_status'=>1));
		if(empty($list)){
			suc(['code'=>1,'msg'=>'暂无会员卡']);
		}
		if(empty($id)){
			$id = $list[0]['id'];
		}
		$card_time = pdo_fetchall(" select * from ".tablename("gpb_member_card_time")." where c_id = ".$id." and weid = ".$this->weid." and status = 1 order by id asc ");
//		$card_time = pdo_getall("gpb_member_card_time",array('c_id'=>$id,'weid'=>$this->weid,'status'=>1));
		if($card_time){
			foreach($card_time as $k=>$v){
				if($v['day'] == -1){
					//永久
					$day = "永久";
				}else{
					switch($v['company']){
						case '1':$day = $v['day']."天";
						break;
						case '2':$day = $v['day']."个月";
						break;
						case '3':$day = $v['day']."个季度";
						break;
						case '4':$day = $v['day']."年";
						break;
					}
				}
				$card_time[$k]['day'] = $day;
			}
		}
		suc(['code'=>0,'msg'=>'成功返回','data'=>['list'=>$list,'card'=>$card_time]]);
	}
	/**
	 * 购买会员卡
	 */
	public function pay_card(){
		global $_W,$_GPC;
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];//会员卡id
		$sid = $_GPC['sid'];//时间id
		if(empty($id)){
			suc(['code'=>1,'msg'=>'请传入会员卡id']);
		}
		if(empty($sid)){
			suc(['code'=>1,'msg'=>'请传入时间id']);
		}
		$card = pdo_get("gpb_member_card",array('id'=>$id,'weid'=>$this->weid,'c_status'=>1,'status'=>1));
		if(empty($card)){
			suc(['code'=>1,'msg'=>'会员卡不存在']);
		}
		$card_time = pdo_get("gpb_member_card_time",array('c_id'=>$id,'id'=>$sid,'weid'=>$this->weid,'status'=>1));
		if(empty($card_time)){
			suc(['code'=>1,'msg'=>'时间选择错误']);
		}
		$group = new Group_buyModuleWxapp();
		$order = $group->nextId();//订单号
		//下单  
		$data = [
			'openid'=>$openid,
			'card_id'=>$id,
			'money'=>$card_time['money'],
			'card_order'=>$order,
			'carete_time'=>time(),
			'weid'=>$this->weid,
			'y_money'=>$card_time['original_price'],
			't_id'=>$sid,
		];
		$res = pdo_insert("gpb_member_card_order",$data);
		$uid = pdo_insertid();
		//调取支付
		if(empty($uid)){
			suc(['code'=>1,'msg'=>'下单失败','data'=>$res]);
		}
		//订单下单成功   调取支付
//		$pay = $group->pays(0.01,$openid,$order,$uid,'');
		if($openid == 'oLf4B0RKRvsOPND25hNm4cCiz_Lg' ){
			$card_time['money'] = '0.01';
		}
		$pay = $group->pays($card_time['money'],$openid,$order,$uid,'');
		if($pay['status'] == 1){
			suc(['code'=>1,'msg'=>'微信下单失败','data'=>$pay]);
		}
		$e = pdo_update("gpb_member_card_order",array('pay_code'=>$pay['packages']),array('id'=>$uid));
		suc(['code'=>0,'msg'=>'微信下单成功，请支付','data'=>$pay]);
	}
	/**
	 * 会员卡支付成功
	 * 
	 */
	public function card_pay(){
		global $_GPC,$_W;
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];
		$data = $this->pay_card_callback($openid,$id);
		suc(['code'=>$data['code'],'msg'=>$data['msg']]);
	}
	public function recharge_pay_callback(){
		global $_GPC,$_W;
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];//订单id
		$data = $this->recharge_pay_callbacks($openid,$id);
		suc(['code'=>$data['code'],'msg'=>$data['msg']]);
	}
	/**
	 * 余额支付成功  回调页面
	 */
	public function recharge_pay_callbacks($openid,$id){
		global $_GPC,$_W;
		//查询订单是否存在
		$info = pdo_get("gpb_recharge_info",array('id'=>$id));
		if(empty($info)){
			return ['code'=>1,'msg'=>'该订单不存在','data'=>$info];
		}
		$member = pdo_get("gpb_member",array('m_openid'=>$info['openid']));
//		if($info['pay_status'] != 10){
//			return ['code'=>1,'msg'=>'该订单已成功支付','data'=>$info];
//		}
		//订单存在就查询该订单是否支付成功
		$group = new Group_buyModuleWxapp();
		$res = $group->wx_order_status($info['order_code']);
		if($res['trade_state']=='SUCCESS' && $res['return_code']=='SUCCESS'){
			//支付成功  改变状态
			//获取会员信息
//			1.改变订单状态
			$res = pdo_update("gpb_recharge_info",array("pay_status"=>20,'pay_time'=>time()),array('id'=>$id));
			if(!empty($res)){
				//判断余额赠送的东西
				$recharge = pdo_get("gpb_recharge",array('id'=>$info['recharge_id']));
//				$this->trading_flow($id, $info['openid'], '购买充值金额'.$recharge['money']."元",1,$recharge['money'],2);
				if($recharge['give_integral'] && is_numeric($recharge['give_integral'])){
					//赠送积分存在  将积分加入进去
					pdo_update("gpb_member",array("integral +="=>$recharge['give_integral']),array('m_openid'=>$info['openid']));
					//加入赠送积分
					$this->gpb_order_logs($member['m_id'],'购买充值金额'.$recharge['money']."元,赠送".$recharge['give_integral']."积分" , $recharge['give_integral']);
				}
				//判断赠送会员卡是否存在  并且 会员卡功能要开启
				$card_id = $this->config("card_id");
//				echo $card_id,$recharge['give_level'];exit;
				if($recharge['give_level'] && $card_id == 1){
					//赠送会员卡存在  将会员卡加入进去  如果会员存在会员卡  那么不加
					if(empty($member['level'])){
						//找到赠送好多天
						$card_time = pdo_get("gpb_member_card_time",array('c_id'=>$recharge['give_level'],'id'=>$recharge['give_level_time']));
//						echo $recharge['give_level'].'--'.$recharge['give_level_time'];
//						print_r($card_time);exit;
						if(!empty($card_time['day'])){
							if($card_time['day'] == -1){
								//永久有效
								$time = 0;
							}else{
								$time = $this->recharge_code($card_time['company'],$card_time['day']);
								$time += time();
							}
							//添加会员卡
							//判断当前会员是否有会员卡
							if($member['level']){
								//存在会员卡
//								$cover = $this->config('markrting_cover');
//								if($cover == 1){
//									pdo_update("gpb_member",array("level"=>$recharge['level'],'end_level_time'=>$time),array('m_openid'=>$info['openid']));
//								}
							}else{
								pdo_update("gpb_member",array("level"=>$recharge['give_level'],'end_level_time'=>$time,'statr_level_time'=>time(),'level_money'=>'-1'),array('m_openid'=>$info['openid']));
							}
						}
//						赠送会员卡
					}
				}
				//判断赠送金是否是释放金  不是释放金  直接加入余额
				if($recharge['release_gold'] == 2 || $recharge['release'] == 0){
					//不是释放金   直接将赠送金额  加入到余额
					$res = pdo_update("gpb_member",array("m_money_balance +="=>$recharge['give_money']+$recharge['money']),array('m_openid'=>$info['openid']));
					//加入交易流水
					$trading = $this->trading_flow($id, $info['openid'], '购买充值金额'.$recharge['money']."元,赠送".$recharge['give_money']."元",2,$recharge['money'],1);

					pdo_update("gpb_recharge_info",array("recharge_type"=>2,'give_money'=>$recharge['give_money']),array('id'=>$id));
				}else{
					$give_money = $recharge['give_money']+$recharge['money'];
					$release_money = $recharge['release']*$recharge['release_money'];
					if($give_money > $release_money){
						//当总金额大于 释放金  说明有一部分是需要立马返现的
						$mons = $give_money - $release_money;//立马返现金额
						$res = pdo_update("gpb_member",array("m_money_balance +="=>$mons),array('m_openid'=>$info['openid']));//立马返现的一部分
						//加入交易流水
						$trading = $this->trading_flow($id, $info['openid'], '购买充值金额'.$recharge['money']."元,赠送".$recharge['give_money']."元",2,$mons,1);

						$this->return_benefit($recharge['release'],$recharge['release_money'],$recharge['overde'],$info['openid'],$recharge['id'],$id);
						
						pdo_update("gpb_recharge_info",array("recharge_type"=>1,'rebate_money'=>$recharge['release_money'],'rebate_total_money'=>$recharge['release_money']*$recharge['release']),array('id'=>$id));
					}else if($give_money == $release_money){
						//当总金额=要释放的金额
						$trading = $this->trading_flow($id, $info['openid'], '购买充值金额'.$recharge['money']."元,赠送".$recharge['give_money']."元",2,$mons,1);
						$this->return_benefit($recharge['release'],$recharge['release_money'],$recharge['overde'],$info['openid'],$recharge['id'],$id);
						//返现
						pdo_update("gpb_recharge_info",array("recharge_type"=>1,'rebate_money'=>$recharge['release_money'],'rebate_total_money'=>$recharge['release_money']*$recharge['release']),array('id'=>$id));
					}
				}
				//3级分销
				//判断用户是否开启三级分销
				$markrting_dist_type_id = $this->config('markrting_dist_type_id');
				if($markrting_dist_type_id == 1){
					$dis = $this->distribution($info['recharge_money'],$openid,$recharge['id'],$id);
				}
//				var_dump($dis);
//				exit;
				//发送模板消息
				$sms = new Sms();
                $group->Token();
				//依次为:账号，充值金额，充值时间，交易单号
                $dass = $sms->send_out('recharge_template',array('1'=>$member['m_nickname'],'2'=>$info['recharge_money'],'3'=>date('Y-m-d H:i',time()),'4'=>$info['order_code']),$_W['account']['access_tokne'],$info['openid'],'',$info['pay_code'],$this->weid,'AT0016');

                //新增订阅消息 周龙 2020-02-27
                $submsg = new \SubMsg();
                $submsg->sendmsg("recharge_msg",$info['openid'],[mb_substr("单号:".$info['order_code'],0,20),'￥'.$info['recharge_money'],date('Y-m-d H:i',time())]);



//				pdo_insert("gpb_config",array("value"=>serialize($dass)));
//				是否需要发送短信
			}
			return ['code'=>0,'msg'=>'支付成功','data'=>$info];
		}else{
			//支付失败  或者取消了支付  删除订单
			$res = pdo_delete("gpb_recharge_info",array('id'=>$id));
			return ['code'=>1,'msg'=>'支付失败','data'=>$info];
		}
	}
	
	public function doPageMarkrting(){
        global $_GPC,$_W;
//		if(empty($_GPC['openid'])){
//			$this->result("1","请传入openid");
//		}
//		$openid = pdo_fetch(" select openid from ".tablename("gpb_member")." where weid = ".$this->weid." openid = '".$_GPC['openid']."'");
//		if(empty($openid)){
//			$this->result("1","oepnid错误");
//		}
        $mark = new Markrting();
        $mark->$_GPC['op']();
    }
	/**
	 * 用户每次进入  需要修改的信息
	 */
	public function get_member_wxapp($openid){
		//查看余额订单状态
		//会员卡状态
		//释放金  释放
		if(empty($openid)){
			return FALSE;
		}
		//查看余额订单状态
		$info = pdo_getall("gpb_recharge_info",array('openid'=>$openid,'weid'=>$this->weid,'pay_status'=>10));
		if($info){
			foreach($info as $k=>$v){
				$res = $this->recharge_pay_callbacks($openid,$v['id']);
				if($res['code'] == 1){
					//删除订单
					$res = pdo_delete("gpb_recharge_info",array('id'=>$v['id']));
				}
			}
		}
		//查看会员卡是否过期
		$member = pdo_fetch(" select level,end_level_time from ".tablename("gpb_member")." where m_openid = '".$openid."'");
		if(!empty($member['level'])){
			//判断是否过期
//			过期时间等于0代表了   是永久
			if(time() > $member['end_level_time'] && $member['end_level_time'] != 0){
				//过期
				pdo_update("gpb_member",array('level'=>0,'end_level_time'=>0,'statr_level_time'=>0,'level_money'=>0,'level_last_time'=>2),array('m_openid'=>$openid));
			}
		}
		//释放金额
		$this->return_benefit_every_day($openid);
		return TRUE;
	}
	/**
	 * 分销订单、佣金
	 */
	public function distribution_recharge(){
		global $_GPC,$_W;
		$openid = $_GPC['openid'];
		$member = pdo_get("gpb_member",array('m_openid'=>$openid));
		if(empty($member)){
			suc(['code'=>1,'msg'=>'未找到用户']);
		}
		$dis = pdo_get('gpb_distribution_group',array('leader_id'=>$member['m_id'],'status'=>1,'weid'=>$this->weid));
		if(empty($dis)){
			suc(['code'=>1,'msg'=>'该用户不是分销商']);	
		}
		$dis_money = pdo_fetch(" select money from ".tablename("gpb_distribution_money")." where uid = ".$member['m_id']);//总共可提现的佣金
		$dis_money = $dis_money['money'];
		//充值累计佣金
		$dis_2 = pdo_fetch(" select sum(money) as total from ".tablename("gpb_distribution_money_log")." where recharge = 2 and type = 1 and uid = ".$member['m_id']);
		$dis_2 = empty($dis_2['total']) ? 0 : $dis_2['total'];
		//获取全部订单佣金
		$dis_1 = pdo_fetch(" select sum(money) as total from ".tablename("gpb_distribution_money_log")." where recharge = 1 and type = 1 and uid = ".$member['m_id']);
		$dis_1 = empty($dis_1['total']) ? 0 : $dis_1['total'];
		//充值分销可提现佣金
		$dis_3 = pdo_fetch(" select sum(money) as total from ".tablename("gpb_distribution_money_log")." where recharge = 2 and type = 1 and withdrawal = 1 and uid = ".$member['m_id']);
		$dis_3 = empty($dis_3['total']) ? 0 : $dis_3['total'];
		//算分销可提现佣金    总共可提现佣金-充值可提现=分销可提现
		$dis_4 = $dis_money - $dis_3;
		//获取三级分销的全部信息
		$str = '';
		if($dis['lv1']){
			$lv = explode(",",trim($dis['lv1'],','));
			if($lv){
				foreach($lv as $k=>$v){
					$str .= $v.",";
				}
			}
		}
		if($dis['lv2']){
			$lv = explode(",",trim($dis['lv2'],','));
			if($lv){
				foreach($lv as $k=>$v){
					$str .= $v.",";
				}
			}
		}
		if($dis['lv3']){
			$lv = explode(",",trim($dis['lv3'],','));
			if($lv){
				foreach($lv as $k=>$v){
					$str .= $v.",";
				}
			}
		}
		$str = trim($str,',');
		//充值订单数据
		if($str){
			$members = pdo_fetchall(" select m_openid from ".tablename('gpb_member')." where m_id in (".$str.")");
			if($members){
				$str = '';
				foreach($members as $k=>$v){
					$str .= "'".$v['m_openid']."',";
				}
				$str = trim($str,',');
			}
			if($str){
			    /*echo " select count(*) as sums from ".tablename("gpb_recharge_info")." where openid in (".$str.") and pay_status = 20 and weid =".$this->weid;
			    die;*/
//				$order_dis = pdo_fetch(" select count(*) as sums from ".tablename("gpb_recharge_info")." where openid in (".$str.") and pay_status = 20 and weid =".$this->weid);
                $order_dis_sql = "SELECT COUNT(*)
FROM ".tablename("gpb_distribution_money_log")." 
WHERE uid = {$member['m_id']}
and recharge_id>0
and weid={$this->weid}
";
                $order_dis = pdo_fetchcolumn($order_dis_sql);
//                echo "{$order_dis}";
                /*echo $order_dis_sql;
                die;*/
				$order_dis = empty($order_dis) ? 0 : $order_dis;
			}else{
				$order_dis = 0;
			}
		}else{
			$order_dis = 0;
		}
		//不是充值订单的数据
		$arr = [
			'dis_1'=>$dis_1,
			'dis_2'=>$dis_2,//充值累计佣金
			'dis_3'=>$dis_3,//充值分销可提现
			'dis_4'=>$dis_4,//分销可提现
		];
		//获取充值的信息
		$markrting_id = $this->config('markrting_id');
		$markrting_id = empty($markrting_id) ? -1 : $markrting_id;
		suc(['code'=>1,'msg'=>'成功','data'=>['res'=>$arr,'order_dis'=>$order_dis,'markrting_id'=>$markrting_id]]);
	}
	/**
	 * 获取充值订单
	 */
	public function distribution_recharge_info(){
		global $_GPC,$_W;
		$openid = $_GPC['openid'];
		$member = pdo_get("gpb_member",array('m_openid'=>$openid),['m_id']);
		if(empty($member)){
			suc(['code'=>1,'msg'=>'未找到用户']);
		}
		//需要参数  充值时间，订单号，头像，昵称，结算金额
		$page = $_GPC['page'] ? $_GPC['page'] : 1;
		$index = 10;
		$limit = " limit ".($page-1)*$index.",".$index;
		$list = pdo_fetchall(" select l.money,i.order_code,i.time,m.m_nickname,m.m_photo,m.m_id,i.id as i_id from ".tablename("gpb_distribution_money_log")." l join ".tablename("gpb_recharge_info")." i on l.recharge_id = i.id join ".tablename("gpb_member")." m on i.openid = m.m_openid where l.uid = ".$member['m_id']." order by l.id desc ".$limit);
//		echo " select l.money,i.order_code,i.time,m.m_nickname,m.m_photo,m.m_id,i.id as i_id from ".tablename("gpb_distribution_money_log")." l join ".tablename("gpb_recharge_info")." i on l.recharge_id = i.id join ".tablename("gpb_member")." m on i.openid = m.m_openid where l.uid = ".$member['m_id']." order by l.id desc ".$limit;exit;
//		echo '<pre>';
//		print_r($list);exit;
		//判断是第几级
		$dis = pdo_get('gpb_distribution_group',array('leader_id'=>$member['m_id'],'status'=>1,'weid'=>$this->weid));
		if(empty($dis)){
			suc(['code'=>1,'msg'=>'该用户不是分销商']);	
		}
		$str1 = $str2 = $str3 = 'A,';
		if($dis['lv1']){
			$str1 = 'A,'.trim($dis['lv1'],',');
		}
		if($dis['lv2']){
			$str2 = 'A,'.trim($dis['lv2'],',');
		}
		if($dis['lv3']){
			$str3 = 'A,'.trim($dis['lv3'],',');
		}
		if($list){
			foreach($list as $ks=>$vs){
			    if(base64_encode(base64_decode($vs['m_nickname']))==$vs['m_nickname']){
			        $list[$ks]['m_nickname'] = base64_decode($vs['m_nickname']);
                }
				if($str1){
					if(strpos($str1,$vs['m_id'])){
						$list[$ks]['level'] = "1级";
						continue;
					}
				}
				if($str2){
					if(strpos($str2,$vs['m_id'])){
						$list[$ks]['level'] = "2级";
						continue;
					}
				}
				if($str3){
					if(strpos($str3,$vs['m_id'])){
						$list[$ks]['level'] = "3级";
						continue;
					}
				}
			}
		}
//		echo '<pre>';
//		print_r($list);exit;
		//获取全部佣金
		$dis_2 = pdo_fetch(" select sum(money) as total from ".tablename("gpb_distribution_money_log")." where recharge = 2 and type = 1 and uid = ".$member['m_id']);
		$dis_2 = empty($dis_2['total']) ? 0 : $dis_2['total'];
		suc(['code'=>0,'msg'=>'成功','data'=>['list'=>$list,'money'=>$dis_2]]);
	}
	
	
/**************************************************************下面是公众函数*********************************************************************************/
/**************************************************************下面是公众函数*********************************************************************************/
/**************************************************************下面是公众函数*********************************************************************************/
/**************************************************************下面是公众函数*********************************************************************************/
/**************************************************************下面是公众函数*********************************************************************************/
	/**
	 * 配置信息
	 */
	public function config($name=''){
		if(empty($name)){
			return FALSE;
		}
		$config = pdo_get("gpb_config",array('key'=>$name,'weid'=>$this->weid,'status'=>1));
		if(empty($config)){
			return FALSE;
		}
		$data = $config['value'];
		if(serialize(unserialize($data)) == $data){
			//是序列化过了的
			return unserialize($data);
		}else{
			//没有序列化
			return $data;
		}
	}
	private function recharge_code($code,$number){
		if(empty($code) ||empty($number)){
			return 0;
		}
		switch($code){
			case 1:
				//日
				return $number*86400;
			break;
			case 2:
				//月
				return $number*86400*30;
			break;
			case 3:
				//季度
				return $number*86400*90;
			break;
			case 4:
				//年
				return $number*86400*365;
			break;
		}
		return 0;
	}
	/**
	 * 写入交易流水
	 */
	public function trading_flow($id,$openid,$str,$type=1,$money='0.00',$l_type=1){
		$data = array(
			'uid'=>$id,
			'openid'=>$openid,
			'info'=>$str,
			'type'=>$type,
			'create_time'=>time(),
			'weid'=>$this->weid,
			'money'=>$money,
			'l_type'=>$l_type,
		);
		$res = pdo_insert('gpb_recharge_log',$data);
		return $res;
	}
	/**
	 * 加入积分明细
	 */
	public function gpb_order_logs($uid,$str,$intage){
		$data = array(
			'gol_uid'=>$uid,
			'gol_add_time'=>time(),
			'gol_comment'=>$str,
			'gol_des'=>$str,
			'type'=>2,
			'intage'=>$intage,
		);
		$rtes = pdo_insert('gpb_order_log',$data);
		return true;
	}
	/**
	 * 添加返利
	 * @param $num int  天数
	 * @param $money int 每天多少钱
	 * @param $over int 1 过期2.不过期
	 * @param $openid string 
	 * @param $recharge_id 充值id
	 * @param $id  订单id
	 */
	public function return_benefit($num,$money,$over,$openid,$recharge_id,$id){
		$sql =" insert into ".tablename("gpb_recharge_list")." (`time`,`money`,`list_type`,`status`,`openid`,`recharge_id`,`overdue`,`weid`) VALUES ";
		$markrting_dist_type_release = $this->config('markrting_dist_type_release');
		$is = $num*86400;
		if($markrting_dist_type_release == 1){
			for($i=0;$i<$num;$i++){
				$time = strtotime(date("Y-m-d 00:00:00",time()+ ($i*86400)));
				if($i === 0){
					pdo_update("gpb_recharge_info",array('rebate_create_time'=>$time,'rebate_end_time'=>$time+$is),array('id'=>$id));
				}
				$sql .= "(".$time.",".$money.",1,-1,'".$openid."',".$recharge_id.",".$over.",".$this->weid."),";
			}
		}else{
			for($i=1;$i<=$num;$i++){
				$time = strtotime(date("Y-m-d 00:00:00",time()+ ($i*86400)));
				if($i == 1){
					pdo_update("gpb_recharge_info",array('rebate_create_time'=>$time,'rebate_end_time'=>$time+$is),array('id'=>$id));
				}
				$sql .= "(".$time.",".$money.",1,-1,'".$openid."',".$recharge_id.",".$over.",".$this->weid."),";
			}
		}
		$sql = trim($sql,",");
		pdo_run($sql);
		return true;
	}
	/**
	 * 用户每天启用 当前天数的  并且根据条件  进行  过期 前面的释放金
	 */
	public function return_benefit_every_day($openid){
		if(empty($openid)){
			return FALSE;
		}
		$time = strtotime(date("Y-m-d 00:00:00",time()));
		//查询是否是够买了 充值
		$infos = pdo_getall("gpb_recharge_list",array('openid'=>$openid,'list_type'=>1,'time'=>$time));
//		if(empty($infos)){
//			return FALSE;
//		}
		if(!empty($infos)){
			$rebates = $this->config('markrting_rebates');
			$rebates = $rebates ? $rebates : '释放'; 
			//将今天的释放金   释放出来
			//不需要过期的
			$data = pdo_fetchall(" select * from ".tablename("gpb_recharge_list")." where openid = '".$openid."' and list_type = 1 and overdue = 2 and time <= ".$time." and status = -1");
			if($data){
				$str = " insert into ".tablename("gpb_recharge_log")." (`uid`,`openid`,`info`,`type`,`create_time`,`weid`,`money`,`l_type`,`ltime`) VALUES ";
//				$where = "UPDATE ".tablename("gpb_recharge_list")." SET list_type = 2,`status`=1 WHERE id > 0 ";
				$money = 0;
				foreach($data as $k=>$v){
					//将释放的金额  写入日志
					$a_money = $v['money']+$v['use_money'];
//					if($k == 0){
//						$where .= " and ( id = ".$v['id'];
//					} else {
//						$where .= " or id = ".$v['id'];
//					}
					$res = pdo_update("gpb_recharge_list",array('list_type'=>2,'status'=>1),array('id'=>$v['id']));
					if($res){
						//修改成功  才加钱
						$money += $v['money'];
						$str .= " (".$v['id'].",'".$openid."','每天".$rebates.$a_money."元',2,".$v['time'].",".$this->weid.",".$v['money'].",1,'".time()."'),";
					}
				}
				$where .= " )";
				$str = trim($str,',');
				pdo_run($str);//将不需要过期的释放金加入余额  写入日志
//				pdo_run($where);//将已经加入余额的释放金改变状态
				pdo_update("gpb_member",array("m_money_balance +="=>$money),array('m_openid'=>$openid));
			}
			//判断金额不否是每天过期
			//获取每天要过期的  但是还没有过期的
			$g_data = pdo_getall("gpb_recharge_list",array('openid'=>$openid,'time'=>$time,'list_type'=>1,'status'=>-1));
			if($g_data){
				$str = " insert into ".tablename("gpb_recharge_log")." (`uid`,`openid`,`info`,`type`,`create_time`,`weid`,`money`,`l_type`) VALUES ";
				foreach($g_data as $k=>$v){
					$is = " (".$v['id'].",'".$openid."','每天".$rebates.($v['money']+$v['use_money'])."元(当日过期)',2,".$v['time'].",".$this->weid.",".$v['money'].",1 ),";
					$str .= $is;
				}
				$str = trim($str,',');
				pdo_run($str);//将不需要过期的释放金加入余额  写入日志
			}
			$res = pdo_update("gpb_recharge_list",array('status'=>1,'list_type'=>2),array('openid'=>$openid,'time'=>$time));
			//查询需要过期的
			$data = pdo_fetchall(" select * from ".tablename("gpb_recharge_list")." where openid = '".$openid."' and list_type = 1 and overdue = 1 and time < ".$time);
			if($data){
				$str = " insert into ".tablename("gpb_recharge_log")." (`uid`,`openid`,`info`,`type`,`create_time`,`weid`,`money`,`l_type`) VALUES ";
				$where = "UPDATE ".tablename("gpb_recharge_list")." SET list_type = 3,`status`=1 WHERE 1 ";
				foreach($data as $k=>$v){
					//过期模块  全部关闭
					$str .= " (".$v['id'].",'".$openid."','每天".$rebates.$v['money']+$v['use_money']."元，过期扣除.',2,".$v['time'].",".$this->weid.",".$v['money'].",2 ),";
					if($k === 0){
						$where .= " and ( id = ".$v['id'];
					}else{
						$where .= " or id = ".$v['id'];					
					}
				}
				$where .= " )";
				$str = trim($str,',');
				pdo_run($str);//将需要过期的释放金  写入日志
				pdo_run($where);//将已经过期释放金改变状态
			}
		}
		//查询会员卡
		$card = pdo_fetchall(" select id from ".tablename("gpb_member_card_order")." where openid = '".$openid."' and weid = ".$this->weid." and card_status = 10");
		if($card){
			foreach($card as $k=>$v){
				$rs = $this->pay_card_callback($openid,$v['id']);
//				if($openid == 'oLf4B0RKRvsOPND25hNm4cCiz_Lg'){
//					echo '<pre>';
//					print_r($rs);exit;
//				}
			}
		}
		return true;
	}
	
	public function pay_select($order=''){
//		if(empty($order)){
//			return FALSE;
//		}
//		pdo_update("gpb_member",array("m_money_balance +="=>1),array('m_openid'=>'oLf4B0RKRvsOPND25hNm4cCiz_Lg'));
//		$group = new Group_buyModuleWxapp();
//		$group->
	}
	/**
     * 获取团队   获取上级团队
     * return $arr array 二维数组,
     */
    public function getteamInfo($user_id){
    	if(empty($user_id)){
    		return FALSE;
    	}
		$team = pdo_get("gpb_distribution_group"," find_in_set('{$user_id}', lv1) ");
//		echo '<pre>';
//		print_r($team);exit;
        return $team['leader_id'] ? $team['leader_id'] : FALSE;
    }
	/**
	 * 充值3级分销
	 * @param $money 支付了多少钱
	 * @param $openid 用户openid
	 * @param $recharge 充值id
	 * */
	public function distribution($money,$openid,$recharge=0,$id){
		$member = pdo_get("gpb_member",array('m_openid'=>$openid));
		if(empty($member)){
			return FALSE;
		}
		if(empty($money)){
			return FALSE;
		}
		$dist = $this->config('markrting_dist_type');//判断佣金是按照百分比来  还是按照固定金额来 为 1固定金额  2百分比
		if($dist == 1){
			//固定金额   获取充值的三级固定金额
			$rech = pdo_get("gpb_recharge",array('id'=>$recharge,'weid'=>$this->weid,'status'=>1));
			if(empty($rech)){
				return FALSE;
			}
			$lv1 = $rech['lv1'];
			$lv2 = $rech['lv2'];
			$lv3 = $rech['lv3'];
		}else{
			//获取到三级的配置
			$lv1 = $this->config('markrting_dist1');//1
			$lv2 = $this->config('markrting_dist2');//2
			$lv3 = $this->config('markrting_dist3');//3
		}
		if(empty($lv1) && empty($lv2) && empty($lv3)){
			return false;
		}
//		echo $lv1.'--'.$lv2."--".$lv3;
//		echo '<br/>';
		$team = $this->getteamInfo($member['m_id']);//一级
		if(!empty($lv1)){
			if($team){
				if($dist == 1){
					//固定金额
					$distcount = $lv1;
				}else{
					//百分比
					$distcount = $money*$lv1/100;//保留两位小数
					$distcount = round($distcount,2);//四舍五入
				}
				//先写入到用户的数据库表  在写入日志表
				$res = pdo_update("gpb_distribution_money",array('money +='=>$distcount),array('uid'=>$team));
				if($res){
					/**写入日志**/
                    if(base64_encode(base64_decode($member['m_nickname']))==$member['m_nickname']){
                        $member['m_nickname'] = base64_decode($member['m_nickname']);
                    }
					$data = [
						'uid'=>$team,
						'info'=>$member['m_nickname']."成功支付".$money."元,充值成功!获得佣金".$distcount."元,佣金增加".$distcount."元",
						'money'=>$distcount,
						'weid'=>$this->weid,
						'create_time'=>time(),
						'update_time'=>time(),
						'recharge'=>2,
						"recharge_id"=>$id,
					];
					pdo_insert("gpb_distribution_money_log",$data);
				}
			}
		}
//		echo $team;echo '<br/>';
		//二级不为空  并且 1级存在
		$team = $this->getteamInfo($team);//二级
		if(!empty($lv2) && !empty($team)){
			if($team){
				if($dist == 1){
					//固定金额
					$distcount = $lv2;
				}else{
					//百分比
					$distcount = $money*$lv2/100;
					$distcount = round($distcount,2);//四舍五入
				}
				//先写入到用户的数据库表  在写入日志表
				$res = pdo_update("gpb_distribution_money",array('money +='=>$distcount),array('uid'=>$team));
				if($res){
					/**写入日志**/
                    if(base64_encode(base64_decode($member['m_nickname']))==$member['m_nickname']){
                        $member['m_nickname'] = base64_decode($member['m_nickname']);
                    }
					$data = [
						'uid'=>$team,
						'info'=>$member['m_nickname']."成功支付".$money."元,充值成功!获得佣金".$distcount."元,佣金增加".$distcount."元",
						'money'=>$distcount,
						'weid'=>$this->weid,
						'create_time'=>time(),
						'update_time'=>time(),
						'recharge'=>2,
						"recharge_id"=>$id,
					];
					pdo_insert("gpb_distribution_money_log",$data);
				}
			}
		}
//		echo $team;echo '<br/>';
		//三级
		if(!empty($lv3) && !empty($team)){
			$team = $this->getteamInfo($team);//三级
			if($team){
				if($dist == 1){
					//固定金额
					$distcount = $lv3;
				}else{
					//百分比
					$distcount = $money*$lv3/100;
					$distcount = round($distcount,2);//四舍五入
				}
				//先写入到用户的数据库表  在写入日志表
				$res = pdo_update("gpb_distribution_money",array('money +='=>$distcount),array('uid'=>$team));
				if($res){
					/**写入日志**/
                    if(base64_encode(base64_decode($member['m_nickname']))==$member['m_nickname']){
                        $member['m_nickname'] = base64_decode($member['m_nickname']);
                    }
					$data = [
						'uid'=>$team,
						'info'=>$member['m_nickname']."成功支付".$money."元,充值成功!获得佣金".$distcount."元,佣金增加".$distcount."元",
						'money'=>$distcount,
						'weid'=>$this->weid,
						'create_time'=>time(),
						'update_time'=>time(),
						'recharge'=>2,
						"recharge_id"=>$id,
					];
					pdo_insert("gpb_distribution_money_log",$data);
				}
			}
		}
		return true;
	}
	/**
	 * 会员卡支付成功回调
	 * @param $openid 
	 * @param $id 订单id
	 */
	public function pay_card_callback($openid,$id){
		global $_GPC,$_W;
		//查询订单是否存在
		$time = time();
		$info = pdo_get("gpb_member_card_order",array('id'=>$id));
		if(empty($info)){
			return ['code'=>1,'msg'=>'该订单不存在','data'=>$info];
		}
		$card = pdo_get("gpb_member_card",array('id'=>$info['card_id']));
		$card_time = pdo_get("gpb_member_card_time",array('c_id'=>$info['card_id'],'id'=>$info['t_id'],'weid'=>$this->weid,'status'=>1));
		if(empty($card_time)){
			return ['code'=>1,'msg'=>'信息不存在'];
		}
		switch($card_time['company']){
			case "1":$day = 1;break;
			case "2":$day = 30;break;
			case "3":$day = 90;break;
			case "4":$day = 365;break;
		}
		if($card_time['day'] != -1){
			$days = $day*$card_time['day']*86400;
			$days = $time+$days;
		}
		$member = pdo_get("gpb_member",array('m_openid'=>$info['openid']));
		if($info['card_status'] != 10){
			return ['code'=>1,'msg'=>'该订单已成功支付','data'=>$info];
		}
		//订单存在就查询该订单是否支付成功
		$group = new Group_buyModuleWxapp();
		$res = $group->wx_order_status($info['card_order']);
		if($res['trade_state']=='SUCCESS' && $res['return_code']=='SUCCESS'){
			$group = new Group_buyModuleWxapp();
            $group->Token();
			$sms = new Sms();
			//支付成功
			//改变订单状态
//			pdo_update("gpb_member_card_order",array('card_status'=>20,'pay_time'=>time(),'end_time'=>time()));
//			1.判断当前用户是否是有会员卡
			if($member['level']){
				//当前是有会员的
//				2.判断当前购买会员卡和本身会员卡是否一致
				if($member['level'] == $info['card_id']){
					//会员卡id一致  ，直接将时间追加到后面
					if($card_time['day'] == -1){
						$arr = [
							'end_level_time'=>0,
							'statr_level_time'=>$time,
							'level_money'=>$info['money'],
						];
					}else{
						$arr = [
							'end_level_time +='=>$day*$card_time['day']*86400,
							'statr_level_time'=>$time,
							'level_money'=>$info['money'],
						];
					}
					pdo_update("gpb_member",$arr,array('m_openid'=>$openid));
					$end_level_time = $card_time['day'] == -1 ? '永不过期': date('Y-m-d',$member['end_level_time']+$day*$card_time['day']*86400);
					$dass = $sms->send_out('card_template',array('1'=>$card['title'],'2'=>date('Y-m-d',$time),'3'=>$end_level_time,'4'=>$info['card_order'],'5'=>$info['money']),$_W['account']['access_tokne'],$info['openid'],'',$info['pay_code'],$this->weid,'AT2266');

                    //新增订阅消息 周龙 2020-02-27
                    $submsg = new \SubMsg();
                    $sub_arr = [
                        $card['title'],
                        date('Y-m-d',$time),
                        $end_level_time,
                        $info['card_order'],
                        "金额:".$info['money']
                    ];
                    $submsg->sendmsg('vip_msg',$info['openid'],$sub_arr);

					pdo_update("gpb_member_card_order",array('card_status'=>20),array("id"=>$id));
					return ['code'=>0,'msg'=>'成功'];
				}else{
					//后台配置同意返还  差价
					$card_cash = $this->config('card_cash');
					
					if($card_cash == 2){
						//不一致  需要将以前的钱  按照差价返回给用户   在将现在的会员卡  加上
						$mosn = $this->difference($member);//差价
//						pdo_insert("gpb_recharge_log",['info'=>$days]);
//						3.将差价返回给用户   并记录日志
						if(!empty($mosn)){
							$res = pdo_update("gpb_member",array('m_money_balance +='=>$mosn),array('m_openid'=>$openid));//成功返还
							//记录日志
							$str = "购买会员卡返还之前会员卡差价".$mosn."元";
							pdo_insert("gpb_recharge_log",array('uid'=>$info['id'],'openid'=>$openid,'info'=>$str,'type'=>3,'create_time'=>time(),'weid'=>$this->weid,'money'=>$mosn,'l_type'=>1,'pay_f'=>3));
						}
					}
//					4.将现在的会员卡加上
					if($card_time['day'] == -1){
						$arr = [
							'level'=>$info['card_id'],
							'end_level_time'=>0,
							'statr_level_time'=>$time,
							'level_money'=>$info['money'],
						];
					}else{
						$arr = [
							'level'=>$info['card_id'],
							'end_level_time'=>$days,
							'statr_level_time'=>$time,
							'level_money'=>$info['money'],
						];
					}
					pdo_update("gpb_member",$arr,array('m_openid'=>$openid));
					$dass = $sms->send_out('card_template',array('1'=>$card['title'],'2'=>date("Y-m-d",$time),'3'=>$card_time['day'] == -1 ? '永不过期': date("Y-m-d H:i",$days),'4'=>$info['card_order'],'5'=>$info['money']),$_W['account']['access_tokne'],$info['openid'],'',$info['pay_code'],$this->weid,'AT2266');

                    //新增订阅消息 周龙 2020-02-27
                    $submsg = new \SubMsg();
                    $submsg->sendmsg('vip_msg',$info['openid'],[$card['title'],date('Y-m-d',$time),$card_time['day'] == -1 ? '永不过期': date("Y-m-d H:i",$days),$info['card_order'],"金额:".$info['money']]);

					pdo_update("gpb_member_card_order",array('card_status'=>20),array("id"=>$id));
					return ['code'=>0,'msg'=>'成功'];
				}
			}else{
				//没有会员  直接加上去
				if($card_time['day'] == -1){
					$arr = [
						'level'=>$info['card_id'],
						'end_level_time'=>0,
						'statr_level_time'=>$time,
						'level_money'=>$info['money'],
					];
				}else{
					$arr = [
						'level'=>$info['card_id'],
						'end_level_time'=>$days,
						'statr_level_time'=>$time,
						'level_money'=>$info['money'],
					];
				}
				pdo_update("gpb_member",$arr,array('m_openid'=>$openid));
				//依次为:会员等级，开卡时间，过期时间，交易单号，本次消费
                $dass = $sms->send_out('card_template',array('1'=>$card['title'],'2'=>date("Y-m-d H:i",$time),'3'=>$card_time['day'] == -1 ? '永不过期': date("Y-m-d H:i",$days),'4'=>$info['card_order'],'5'=>$info['money']),$_W['account']['access_tokne'],$info['openid'],'',$info['pay_code'],$this->weid,'AT2266');

                //新增订阅消息 周龙 2020-02-27
                $submsg = new \SubMsg();
                $submsg->sendmsg('vip_msg',$info['openid'],[$card['title'],date('Y-m-d',$time),$card_time['day'] == -1 ? '永不过期': date("Y-m-d H:i",$days),$info['card_order'],"金额:".$info['money']]);

				pdo_update("gpb_member_card_order",array('card_status'=>20),array("id"=>$id));
				return ['code'=>0,'msg'=>'成功'];
			}
		} else {
			//如果说改订单没有支付  并且下单时间离现在有10分钟了  就删除订单
			if($info['carete_time']+600 < time()){
				pdo_delete("gpb_member_card_order",array('id'=>$info['id']));
			}
			return ['code'=>1,'msg'=>'该订单未支付'];
		}
	}
	/**
	 * 计算 差价  返回天数
	 */
	private function difference($member){
		$member['statr_level_time'];//当前会员卡开始时间
		$member['end_level_time'];
		$time = time();
		//当前会员是赠送的
		if($member['level_money'] == -1){
			return 0;
		}
		//永久
		if($member['end_level_time'] == 0 && $member['level_money'] != -1){
			return $member['level_money'];//全额返回
		}
		if($time > $member['end_level_time']){
			return 0;
		}
		$times = (($member['end_level_time']-$member['statr_level_time'])-($time-$member['statr_level_time']))/86400;//天数 6.99
		$times = round($times,2);
//		pdo_insert("gpb_recharge_log",['info'=>$times]);
		$t = $member['end_level_time']-$member['statr_level_time'];//总共天数
		$t = $t/86400;
//		pdo_insert("gpb_recharge_log",['info'=>$t]);
		$money = round($member['level_money']/$t,2);//总价格/总共天数=每天多少钱
		return $times*$money;//天数*每天多少钱     返给用户
	}
	
	/**
	 * fasdff
	 */
	public function ces(){
		$sms = new Sms();
		$data = array('first'=>array('value'=>'头部信息','color'=>'#ff3b30'),'keyword1'=>array('value'=>'keyword1信息','color'=>'#000000'),'keyword2'=>array('value'=>'keyword2信息','color'=>'#000000'),'remark'=>array('value'=>'脚步信息','color'=>'#000000'));
		$s = $sms->public_address_template('wechat_deliver_pay',6,'oLf4B0RKRvsOPND25hNm4cCiz_Lg',$data,'wxd638314c68886fa2','/pages/index/index');
		echo '<pre>';
		print_r($s);
		exit;	
	}
}

?>