<?php
include_once "../addons/group_buy/wxapp.php";
class Sign{
	public function __construct(){
		
		$debug = debug_backtrace();
		if(!strpos($debug[0]['file'],'wxapp')){
			echo '接入地址错误';
			exit;
		}
		if($debug[1]['function'] != 'doPagePlsugins'){
			echo '接入地址错误';
			exit;
		}
	}
	
	public function index(){
		global $_W,$_GPC;
		$openid = $_GPC['openid'];
		//获取当前用户的积分
		$integ = pdo_fetch(" select integral from ".tablename('gpb_member')." where m_openid = '".$openid."'");
//		1.获取是否开启了积分签到
		$config = $this->config('sign_id');
		if(empty($config) || $config == -1){
			suc(['code'=>1,'msg'=>'暂未开启积分签到']);
		}
//		2.获取日常签到积分
		$sign_daily = $this->config('sign_daily');
//		3.获取签到时间   当前周的时间
		$w = date("w");//今天是当前周的第几天
		if($w === 0){
			$w = 7;
		}
		$today=0;
		$Thisweek = mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"));//本周开始时间
//		判断用户是否签过到了
		$first = pdo_get("gpb_member_integral_check",array('openid'=>$openid));
//		4.获取首签奖励
		$sign_first = $this->config('sign_first');
		//算出时间
		$data = [];
		for($i=1;$i<=7;$i++){
			$time = ($i-1)*86400;
			if($i-1 == $w){
				$data[$i-1]['time'] = '明天';
			}else if($i+1 == $w){
				$data[$i-1]['time'] = '昨天';
			}else if($i == $w){
				$data[$i-1]['time'] = '今天';
				$today = $i-1;
			}else{
				$data[$i-1]['time'] = date("m.d",$Thisweek+$time);
			}
			$data[$i-1]['time_chenk'] = $Thisweek+$time;//时间戳
			$data[$i-1]['chenk'] = 'false';//全部判断未签到  后面在修改
			$data[$i-1]['chenks'] = 'false';//全部判断未签到  后面在修改
			if(empty($first) && !empty($sign_first) && $i == $w){
				//获取首签奖励
				$data[$i-1]['reward'] = $sign_daily+$sign_first;
			}else{
				$data[$i-1]['reward'] = $sign_daily;
			}
		}
//		5.算这周的前几天用户是否签到了
		for($i=0;$i<$w;$i++){
			$res = pdo_get("gpb_member_integral_check",array('openid'=>$openid,'create_time'=>$data[$i]['time_chenk']),array('id'));
			if(!empty($res)){
				$data[$i]['chenk'] = 'true';//改变状态为 已签到
			}
		}
//		6.查看当前用户已经连续签到了几天
		//先判断昨天  是否签到
		$z_time = strtotime(date("Y-m-d 00:00:00",time()))-86400;
		$number = pdo_fetchcolumn(" select number from ".tablename("gpb_member_integral_check")." where openid = '".$openid."' and create_time = ".$z_time);
		if($number){
//			$number = pdo_fetch(" select number from ".tablename("gpb_member_integral_check")." where openid = '".$openid."' order by number desc ");
			$number = $number;
		}else{
			$number = 0;//昨天没有签到  代表了用户没得连签天数
		}
//		echo '<pre>';pdo_debug();print_r($number);exit;
		$nu = 0;
//		7.查询连签奖励
		$signature = '';
		$continuity = $this->config('sign_continuity');
		$sign_cycle = $this->config('sign_cycle');//签到周期
//		echo '<pre>';
//		print_r($continuity);
		if($continuity){
			foreach($continuity as $k=>$v){
				$v['contiutiy'] = $v['contiutiy']*1;
				if($sign_cycle == 1){
					//不限周期
					//判断昨天是否连签
					if($number == 0){
//						昨天没有连签
						foreach($data as $ks=>$vs){
							$as = $ks+1;
							$as = $as%$v['contiutiy'];
							if($as == 0){
								$data[$ks]['reward'] = $data[$ks]['reward']+$v['reward'];
								$data[$ks]['chenks'] = 'true';
							}
						}
					}else{
						//昨天连签了
						foreach($data as $ks=>$vs){
							$as = $ks+$number+1;
							if($vs['time_chenk'] >= strtotime(date("Ymd")) && $as%$v['contiutiy'] == 0){
								$data[$ks]['reward'] = $data[$ks]['reward']+$v['reward'];
								$data[$ks]['chenks'] = 'true';
							}
						}
					}
				}else{
					//自定义数据
					if($number == 0){
//						昨天没有连签
//						判断当前几天是否领取了连签奖励
						if($nu){
							if($nu+$v['contiutiy'] <= count($data)-1){
								$data[$nu+$v['contiutiy']]['reward'] = $sign_daily+$v['reward'];
								$data[$nu+$v['contiutiy']]['chenks'] = 'true';
							}
						}else{
							if($today+$v['contiutiy']-1 <= count($data)-1){
								$data[$today+$v['contiutiy']-1]['reward'] = $sign_daily+$v['reward'];
								$data[$today+$v['contiutiy']-1]['chenks'] = 'true';
								$nu = $v['contiutiy'];
							}
						}
					}else{
//						1.判断7天类是否
						if($nu){
							if($nu+$v['contiutiy'] <= count($data)){
								$data[$nu+$v['contiutiy']]['reward'] = $sign_daily+$v['reward'];
								$data[$nu+$v['contiutiy']]['chenks'] = 'true';
								$nu = $nu+$v['contiutiy']-1;
							}
						}else{
							foreach($data as $ks=>$vs){
								//判断本周的第一次签到是那个时候
								if($vs['time_chenk'] == strtotime(date('Y-m-d 00:00:00',time()))){
									$nu = $ks-$number;
									$data[$nu+$v['contiutiy']-1]['reward'] = $sign_daily+$v['reward'];
									$data[$nu+$v['contiutiy']-1]['chenks'] = 'true';
									$nu += $v['contiutiy']-1;
									break;
								}
								
	//							$as = $ks+$number+1;//注  当前天  也要算一天   所以要加1
	//							if($_GPC['type'] == 2){
	//								echo $as.'----'.$vs['time'].'---'.$v['contiutiy'].'........................................................................<br/>';
	//							}
	//							if($as%$v['contiutiy'] == 0){
	//								if($nu==0){
	//									$data[$ks]['reward'] = $sign_daily+$v['reward'];
	//									$data[$ks]['chenks'] = 'true';
	//									$nu = $ks+1;
	//									break;
	//								}
	//							}
							}
						}
						
					}
				}
			}
		}
//		if($_GPC['type'] == 2){
//			echo '<pre>';
//			print_r($data);exit;
//		}
		$n = $i = 0;
		$day_time = strtotime(date("Y-m-d 00:00:00",time()));
		if($data){
			foreach($data as $ks=>$vs){
				if($vs['time_chenk'] == $day_time){
					//今天或者以后
					$n = $ks;
				}
				if($vs['time_chenk'] > $day_time && $vs['reward'] != $sign_daily){
					$i = $ks-$n;
					if(!$data[$n]['chenk']){
						//今天没有签到
						$i -= 1;
					}
					$n = $vs['reward']-$sign_daily;
					break;
				}
			}
		}
		if($number == 0){
			$number = pdo_fetchcolumn(" select number from ".tablename("gpb_member_integral_check")." where openid = '".$openid."' and create_time = ".strtotime(date("Y-m-d"))." and type = 1");
		}
		$arr = ['0'=>$i,'1'=>$n];
//		if($_GPC['type'] ==1){
//			e(['arr'=>$arr,'data'=>$data,'number'=>$number]);
//		}
		//data是签到的数据
		//获取配置
		$sign_integral = $this->config('sign_integral');//积分
		$sign_integral = $sign_integral ? $sign_integral: '积分';
		$sign_in = $this->config('sign_in');//签到
		$sign_in = $sign_in ? $sign_in : '签到';
		$sign_ed = $this->config('sign_ed');//已签
		$sign_ed = $sign_ed ? $sign_ed : '已签';
		$sign_missed = $this->config('sign_missed');//漏签
		$sing_rule = $this->config('sing_rule');//签到规则
		suc(['code'=>0,'msg'=>'成功积分','data'=>['data'=>$data,'integral'=>$sign_integral,'in'=>$sign_in,'ed'=>$sign_ed,'missed'=>$sign_missed,'rule'=>$sing_rule,'number'=>$number,'str'=>$arr,'integ'=>$integ['integral']]]);
	}
	/**
	 * 签到记录
	 */
	public function sign_record(){
		global $_W,$_GPC;
		$openid = $_GPC['openid'];
		$time = $_GPC['time'];
		$where = '';
		if($time){
			$date = date("Y-m-d ",strtotime($time));
		}else{
			$date = date("Y-m-d",time());
		}
		$firstday = date('Y-m-01', strtotime($date));
		$lastday = strtotime(date('Y-m-d 23:59:59', strtotime("$firstday +1 month -1 day")));
		$firstday = strtotime($firstday);
		$where .= " and create_time >= ".$firstday." and create_time <=".$lastday;

		$page = $_GPC['page'] ? $_GPC['page'] : 1;
		$pageIndex = 10;
		$contion = " limit ".($page-1)*$pageIndex.",".$pageIndex;
		$info = pdo_fetchall(" select * from ".tablename('gpb_member_integral_check')." where openid = '".$openid."' and status = 1 ".$where." order by create_time desc ".$contion);
		if($info){
			foreach($info as $k=>$v){
				$info[$k]['specific'] = date("Y-m-d H:i",$v['specific']);
			}
		}
		suc(['code'=>0,'msg'=>'成功积分','data'=>$info]);
	}

	/**
	 * 用户签到
	 */
	public function sign_in(){
		global $_W,$_GPC;
		$openid = $_GPC['openid'];
		if(empty($openid) || $openid == null){
			suc(['code'=>1,'msg'=>$sign_in.'失败,opneid错误']);//签到时间错误
		}
		$time = $_GPC['time'];//签到日期  时间戳
		if(empty($time)){
			suc(['code'=>1,'msg'=>$sign_in.'时间错误']);//签到时间错误
		}
		$time = strtotime(date("Y-m-d 00:00:00",$time));
		$sign_integral = $this->config('sign_integral');//积分
		$sign_integral = $sign_integral ? $sign_integral : '积分';
		$sign_in = $this->config('sign_in');//签到
		$sign_in = $sign_in ? $sign_in : '签到';
		$sign_ed = $this->config('sign_ed');//已签
		$sign_ed = $sign_ed ? $sign_ed : '已签';
		$sign_missed = $this->config('sign_missed');//漏签
		$sign_missed = $sign_missed ? $sign_missed : '漏签';
		$sign_daily = $this->config('sign_daily');
		$sign_cycle = $this->config('sign_cycle');//签到周期
		
		if($time > strtotime(date("Y-m-d",time()))){
			//不是签到今天的
			suc(['code'=>1,'msg'=>$sign_in.'时间错误']);//签到时间错误
		}
		//判断今天是否已经签到
		$info = pdo_get("gpb_member_integral_check",array('create_time'=>$time,'openid'=>$openid));
		if(!empty($info)){
			suc(['code'=>1,'msg'=>'今日'.$sign_ed]);//今日已签
		}
		$money = 0;//总签到积分   该加多少钱
		//判断是否签过到
		$z_time = strtotime(date("Y-m-d 00:00:00",time()))-86400;
		$number = pdo_fetchcolumn(" select number from ".tablename("gpb_member_integral_check")." where openid = '".$openid."' and type = 1 and create_time = ".$z_time);
		if($number){
//			$number = pdo_fetch(" select number from ".tablename("gpb_member_integral_check")." where openid = '".$openid."' and type = 1 order by number desc ");
			$number = $number;
		}else{
			$number = 0;//昨天没有签到  代表了用户没得连签天数
		}
		$type = '0';//判断是否有联系签到奖励 0没有连续签到奖励
		$continuity = '';
		$uid = pdo_fetch(" select m_id from ".tablename("gpb_member")." where m_openid = '".$openid."'");
		$uid = $uid['m_id'];
		if(empty($number)){
			//没有签过到
			//获取首次签到 积分
			$str = '日常'.$sign_in."+".$sign_daily;
			$money += $sign_daily;
			//判断是否首签
			$intergral = pdo_get("gpb_member_integral_check",array('openid'=>$openid));
			pdo_insert("gpb_member_integral_check",array('openid'=>$openid,'create_time'=>$time,'info'=>$str,'type'=>1,'number'=>1,'specific'=>time(),'reward'=>$sign_daily));
			$this->update_member_inter_order_journal($sign_daily, $uid, $str);
			if(empty($intergral)){
				$sign_first = $this->config('sign_first');//首签积分
				if($sign_first){
					$money += $sign_first;
					pdo_insert("gpb_member_integral_check",array('openid'=>$openid,'create_time'=>$time,'info'=>'首次'.$sign_in."+".$sign_first,'type'=>3,'number'=>1,'specific'=>time(),'reward'=>$sign_first));
					$this->update_member_inter_order_journal($sign_daily, '首次'.$sign_in."+".$sign_first, $str);
				}
			}
			pdo_update("gpb_member",array('integral +='=>$money),array('m_openid'=>$openid));
			//判断有没有签到一天就计算连签奖励的
			$continuity = $this->config('sign_continuity');
			if($continuity){
				//有连续签到奖励    算用户有没有连续签到奖励
				foreach($continuity as $k=>$v){
					if($sign_cycle == 1){
//						不限签到周期    不限周期   就算前两天的时间  看看 签到没  签到了  就算连签奖励  没有就只有日常
						$where = ' (';
						for($a=0;$a<$v['contiutiy'];$a++){
							$tip = 86400*$a;
							if($a != 0){
								$where .= " or create_time = ".$itme-$tip;
							}else{
								$where .= " create_time = ".$itme-$tip;
							}
						}
						$where .= " )";
						//查询前三天没得日常记录  注意是日常记录  有可能有前三天中间有连续签到
						$info = pdo_fetchall(" select * from ".tablename("gpb_member_integral_check")." where openid = '".$openid."' and ".$where);
						$info_count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_member_integral_check')." where openid = '".$openid."' and ".$where." and type = 1");
						$types = 1;
//						foreach($info as $ks=>$vs){
//							if($vs['type'] == 2 && $vs['type_days'] == $v['contiutiy']){
//								$types = 2;
//								break;
//							}
//						}
						if($types == 1 && $info_count%$v['contiutiy'] == 0){
//							满足连续签到奖励
							$money += $v['reward'];
							$continuity = '连续'.$sign_in.$v['contiutiy']."天,奖励+".$v['reward'];
							pdo_insert("gpb_member_integral_check",array('openid'=>$openid,'create_time'=>$time,'info'=>$continuity,'type'=>2,'number'=>$number+1,'specific'=>time(),'type_days'=>$v['contiutiy'],'reward'=>$v['reward']));
							pdo_update("gpb_member",array('integral +='=>$v['reward']),array('m_openid'=>$openid));
							$this->update_member_inter_order_journal($sign_daily, $uid, $continuity);
						}
					}else{
						//限制签到周期
						//判断签到周期是几天   
						$contion = "7";
						$day_7 = $contion*86400;//7天的时间戳
						$day_7 = $time - $day_7;//7天前的时间戳
						//判断当前的天数在   7天前是否领取过了
						$where = ' (';
						for($a=0;$a<$contion;$a++){
							$tip = 86400*$a;
							if($a != 0){
								$where .= " or create_time = ".($time-$tip);
							}else{
								$where .= " create_time = ".($time-$tip);
							}
						}
						$where .= " )";
						$info = pdo_fetchall(" select id,type,type_days from ".tablename("gpb_member_integral_check")." where openid = '".$openid."' and ".$where." and type = 2");
						$info_count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_member_integral_check')." where openid = '".$openid."' and ".$where." and type = 1");
						$types = 1;
						foreach($info as $ks=>$vs){
							if($vs['type'] == 2  && $vs['type_days'] == $v['contiutiy']){
								$types = 2;
								break;
							}
						}
						if($types == 1 && $info_count%$v['contiutiy'] == 0){
//						满足连续签到奖励
							$money += $v['reward'];
							$continuity = '连续'.$sign_in.$v['contiutiy']."天,奖励+".$v['reward'];
							pdo_insert("gpb_member_integral_check",array('openid'=>$openid,'create_time'=>$time,'info'=>$continuity,'type'=>2,'number'=>$number+1,'specific'=>time(),'type_days'=>$v['contiutiy'],'reward'=>$v['reward']));
							//加入积分
							pdo_update("gpb_member",array('integral +='=>$v['reward']),array('m_openid'=>$openid));
//							日志
							$this->update_member_inter_order_journal($sign_daily, $uid, $continuity);
						}
					}
				}
			}
		} else {
			//不是第一次签到
			$continuity = $this->config('sign_continuity');
			$str = '日常'.$sign_in."+".$sign_daily;
			$money += $sign_daily;
			pdo_insert("gpb_member_integral_check",array('openid'=>$openid,'create_time'=>$time,'info'=>'日常'.$sign_in."+".$sign_daily,'type'=>1,'number'=>$number+1,'specific'=>time(),'reward'=>$sign_daily));//日常签到
			pdo_update("gpb_member",array('integral +='=>$sign_daily),array('m_openid'=>$openid));
			$this->update_member_inter_order_journal($sign_daily, $uid, $str);
			if($continuity){
				//有连续签到奖励    算用户有没有连续签到奖励
				foreach($continuity as $k=>$v){
					if($sign_cycle == 1){
//						不限签到周期    不限周期   就算前两天的时间  看看 签到没  签到了  就算连签奖励  没有就只有日常
						$where = ' (';
						for($a=0;$a<$v['contiutiy'];$a++){
							$tip = 86400*$a;
							if($a != 0){
								$where .= " or create_time = ".$itme-$tip;
							}else{
								$where .= " create_time = ".$itme-$tip;
							}
						}
						$where .= " )";
						//查询前三天没得日常记录  注意是日常记录  有可能有前三天中间有连续签到
						$info = pdo_fetchall(" select * from ".tablename("gpb_member_integral_check")." where openid = '".$openid."' and ".$where);
						$info_count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_member_integral_check')." where openid = '".$openid."' and ".$where." and type = 1");
						$types = 1;
//						foreach($info as $ks=>$vs){
//							if($vs['type'] == 2 && $vs['type_days'] == $v['contiutiy']){
//								$types = 2;
//								break;
//							}
//						}
						if($types == 1 && $info_count%$v['contiutiy'] == 0){
//							满足连续签到奖励
							$money += $v['reward'];
							$continuity = '连续'.$sign_in.$v['contiutiy']."天,奖励+".$v['reward'];
							pdo_insert("gpb_member_integral_check",array('openid'=>$openid,'create_time'=>$time,'info'=>$continuity,'type'=>2,'number'=>$number+1,'specific'=>time(),'type_days'=>$v['contiutiy'],'reward'=>$v['reward']));
							pdo_update("gpb_member",array('integral +='=>$v['reward']),array('m_openid'=>$openid));
							$this->update_member_inter_order_journal($sign_daily, $uid, $continuity);
						}
					}else{
						//限制签到周期
						//判断签到周期是几天   
						$contion = "7";
						$day_7 = $contion*86400;//7天的时间戳
						$day_7 = $time - $day_7;//7天前的时间戳
						//判断当前的天数在   7天前是否领取过了
						$where = ' (';
						for($a=0;$a<$contion;$a++){
							$tip = 86400*$a;
							if($a != 0){
								$where .= " or create_time = ".($time-$tip);
							}else{
								$where .= " create_time = ".($time-$tip);
							}
						}
						$where .= " )";
						$info = pdo_fetchall(" select id,type,type_days from ".tablename("gpb_member_integral_check")." where openid = '".$openid."' and ".$where." and type = 2");
						$info_count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_member_integral_check')." where openid = '".$openid."' and ".$where." and type = 1");
						$types = 1;
						foreach($info as $ks=>$vs){
							if($vs['type'] == 2  && $vs['type_days'] == $v['contiutiy']){
								$types = 2;
								break;
							}
						}
						if($types == 1 && $info_count%$v['contiutiy'] == 0){
//						满足连续签到奖励
							$money += $v['reward'];
							$continuity = '连续'.$sign_in.$v['contiutiy']."天,奖励+".$v['reward'];
							pdo_insert("gpb_member_integral_check",array('openid'=>$openid,'create_time'=>$time,'info'=>$continuity,'type'=>2,'number'=>$number+1,'specific'=>time(),'type_days'=>$v['contiutiy'],'reward'=>$v['reward']));
							//加入积分
							pdo_update("gpb_member",array('integral +='=>$v['reward']),array('m_openid'=>$openid));
//							日志
							$this->update_member_inter_order_journal($sign_daily, $uid, $continuity);
						}
					}
				}
			}
		}
		suc(['code'=>0,'msg'=>$str,'data'=>['type'=>$type,'continuity'=>$continuity,'money'=>$money]]);
	}
	
	
/**************************************************************下面是公众函数*********************************************************************************************/
/**************************************************************下面是公众函数*********************************************************************************************/
/**************************************************************下面是公众函数*********************************************************************************************/
/**************************************************************下面是公众函数*********************************************************************************************/
/**************************************************************下面是公众函数*********************************************************************************************/

	private function config($name='',$type = 21){
		global $_W;
		if(empty($name)){
			return false;
		}
		$config = pdo_get("gpb_config",array('key'=>$name,'type'=>$type,'status'=>1,'weid'=>$_W['uniacid']));
		if(empty($config)){
			return FALSE;
		}
		if(serialize(unserialize($config['value'])) == $config['value']){
			return unserialize($config['value']);
		}else{
			return trim($config['value']);
		}
	}
	/**
	 * 写入日志
	 */
	public function update_member_inter_order_journal($number,$uid,$str){
		$res = pdo_insert("gpb_order_log",array("gol_uid"=>$uid,'gol_add_time'=>time(),'gol_comment'=>$str,'gol_des'=>$str,'gol_u_name'=>'用户自己','type'=>2,'intage'=>$number));
		return $res ? true : FALSE;
	}
	
	
}
?>