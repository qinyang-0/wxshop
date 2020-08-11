<?php
/**
 * 钩子
 */
include_once "../addons/group_buy/wxapp.php";
include_once "../addons/group_buy/sms.php";
class Group_buy_plugin_bargainModuleHook extends WeModuleHook {
	/**
	 * 构造函数
	 */
	public function __construct(){
		global $_W,$_GPC;
		$this->weid = $_W['uniacid'];
		$this->http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
	}
	/**
	 * 砍价首页信息
	 */
	public function hookPageBargain_index($hook) {
		global $_GPC,$_W;
//		echo dirname(__FILE__);exit;
		$this->order();
		$Stime=microtime(true);//获取程序开始执行的时间
		$openid = $hook['openid'];
		if(empty($openid)){
			$this->suc(2,'参数错误，openid');
		}
		//获取列表信息.
		$time = time();
		$where = " and bg.status_time < ".$time." and bg.end_time > ".$time;
		$index = $hook['page'] ? $hook['page'] : 1;
		$pageIndex = $index;
        $pageSize = 10;
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		//获取当前用户全部在进行中的砍价商品
		$after_goods = pdo_fetchall("select bg.id as bg_id,g.g_id,g.g_name,g.g_price,g.g_icon,bg.end_time,bg.end_price,bg.price_cutting_times,bg.low_price,st.num,ba.id as id,ba.status as ba_status,ba.bargaion_price from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id left join ".tablename('gpb_bargain_action')." ba on ba.action_goods = bg.id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and st.num > 0 and bg.status = 1 and ba.status < 3  and ba.id > 0 ".$where." and ba.openid = '".$openid."'");//这个是当前用户正在砍价的商品或者是已经砍价完成的商品
		$str = '';
		//下面这个循环是根据用户 判断当前用户的状态是也砍价 在砍价  等  ，并且判断商品是否在活动中  在活动中就获取活动上id和活动的结束时间 并且将砍价中的商品  中的也砍价商品id取出
		if($after_goods){
			foreach($after_goods as $k=>$v){
				$after_goods[$k]['g_icon'] = tomedia($v['g_icon']);
				if($v && $v['ba_status'] != 3){
					$after_goods[$k]['action_status'] = 2;
				}else if($v['ba_status'] == 3 && $v['price_cutting_times'] == 1){
					$after_goods[$k]['action_status'] = 3;
				}else if($v['ba_status'] == 3 && $v['price_cutting_times'] != 1){
					$after_goods[$k]['action_status'] = 1;
				}
				$actions = pdo_fetch("select a.at_id,a.at_end_time from ".tablename('gpb_action')." a join ".tablename("gpb_action_goods")." ag on a.at_id = ag.gcg_at_id where ag.gcg_g_id = ".$v['g_id']." and ag.weid = ".$this->weid." and a.at_start_time <= ".time()." and at_end_time >= ".time());
				if($actions){
					$after_goods[$k]['at_id'] = $actions['at_id'];
					$after_goods[$k]['at_end_time'] = $actions['at_end_time'];
				}
				$str .= $v['bg_id'].",";
			}
			$str = trim($str,',');
		}
		//获取当前用户没有砍价的商品
		if($str){
			$info = pdo_fetchall("select bg.id,bg.launches,g.g_id,g.g_name,g.g_price,g.g_icon,bg.end_time,bg.end_price,bg.price_cutting_times,bg.low_price,st.num from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where bg.id not in (".$str.") and g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 ".$where.$contion);
//			echo "select bg.id,g.g_id,g.g_name,g.g_price,g.g_icon,bg.end_time,bg.end_price,bg.price_cutting_times,bg.low_price,st.num from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where bg.id not in (".$str.") and g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 ".$where.$contion;exit;
		} else {
			$info = pdo_fetchall("select bg.id,bg.launches,g.g_id,g.g_name,g.g_price,g.g_icon,bg.end_time,bg.end_price,bg.price_cutting_times,bg.low_price,st.num from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 ".$where.$contion);
		}
		if($info){
			foreach($info as $k=>$v){
				$info[$k]['g_icon'] = tomedia($v['g_icon']);
				$info[$k]['action_status'] = 1;//1代表没有参与该商品的砍价 2参加了
				$actions = pdo_fetch("select a.at_id,a.at_end_time from ".tablename('gpb_action')." a join ".tablename("gpb_action_goods")." ag on a.at_id = ag.gcg_at_id where ag.gcg_g_id = ".$v['g_id']." and ag.weid = ".$this->weid." and a.at_start_time <= ".time()." and at_end_time >= ".time());
				if($actions){
					$info[$k]['at_id'] = $actions['at_id'];
					$info[$k]['at_end_time'] = $actions['at_end_time'];
				}
				//判断该商品的参与次数是不是用户已经不能参与了
				$counts = pdo_fetchcolumn("select count(*) from ".tablename('gpb_bargain_action')." where action_goods = ".$v['id']." and openid = '".$openid."'");
				if($counts >= $v['launches'] && $v['launches'] != 0){
					unset($info[$k]);
				}
			}
			$info = array_values($info);//键值重组
		}
		//获取轮播图
		$config = pdo_getall('gpb_config',array('type'=>26,'weid'=>$this->weid));
		if($config){
			$arr = [];
			foreach($config as $k=>$v){
				if($v['key'] == 'beagiaon_img'){
					$arr[$v['key']] = tomedia($v['value']);
				}else{
					$arr[$v['key']] = $v['value'];
				}
			}
		}
//		$Etime=microtime(true);//获取程序执行结束的时间
//		//echo $Etime."<br/>";
//		$Ttime=$Etime-$Stime;//计算差值
//		//echo $Ttime."<br/>";
//		$str_total=var_export($Ttime,TRUE);
//		if(substr_count($str_total,"E")){ //为了避免1.28746032715E-005这种结果的出现,做了一下处理.
//			$float_total=floatval(substr($str_total,5));
//			$Ttime=$float_total/100000;
//		}
//		echo $Ttime.'秒';exit;
		$this->suc(1,'',['info'=>$info,'config'=>$arr,'after_goods'=>$after_goods]);
    }
	/**
	 * 砍价商品详情
	 */
	public function hookPageBargain_goods_info($hook){
		global $_GPC,$_W;
		$openid = $hook['openid'];
		$id = $hook['id'];//已发起砍价id
		$bargain_action = pdo_get('gpb_bargain_action',array('id'=>$id));
		if(empty($bargain_action)){
			//砍价不存在
			$this->suc(2,'砍价不存在');
		}else{
			$idg = $bargain_action['action_goods'];//砍价表的主键id
		}
		$g_id = pdo_get("gpb_bargaion_goods",array('id'=>$idg,'weid'=>$this->weid),array('g_id'));
		$g_id = $g_id['g_id'];
		if(empty($openid)){
			$this->suc(2,'参数错误，openid');
		}
		if(empty($idg)){
			$this->suc(2,'参数错误，id!');
		}
		if(empty($g_id)){
			$this->suc(2,'参数错误，id'.$idg);
		}
		$time = time();
		$where = " and status_time < ".$time." and end_time > ".$time;
		$where .= " and g.g_id = ".$g_id;
		//判断商品是否在砍价中
		$info = pdo_fetch("select bg.id,g.g_id,g.g_name,g.g_price,g.g_icon,bg.end_time,bg.end_price,st.num,bg.price_cutting_times,bg.low_price from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 ".$where);
		if(empty($info)){
			$this->suc(2,'该商品尚未参加砍价');
		}
		if($info['g_icon']){
			$info['g_icon'] = tomedia($info['g_icon']);
		}
		//判断该商品当前自己是否在砍价
		$action = pdo_fetch("select a.id,a.goods_id,a.now_price,a.end_time,a.nickname,a.head_img,a.bargaion_price,g.place_order,a.status from ".tablename('gpb_bargain_action')." a left join ".tablename('gpb_bargaion_goods')." g on a.action_goods = g.id where a.openid = '".$openid."' and a.goods_id = ".$g_id." and a.id = ".$id." and a.weid = ".$this->weid." order by a.id desc");
		if($action){
			//参与了砍价  获取砍价倒计时   ，帮忙砍价的好友
			//查找帮忙砍价的好友  直接全部查询出来  不分页
//			$record = pdo_getall('gpb_bargaion_record',array('ac_id'=>$action['id']),array('price','openid','nickname','head_img','status_time'));
			$record = pdo_fetchall("select price,openid,nickname,head_img,status_time from ".tablename('gpb_bargaion_record')." where ac_id = :ac_id order by id desc ",array(':ac_id'=>$action['id']));
			if($record){
				foreach($record as $k=>$v){
					if($this->func_is_base64($v['nickname'])){
						$record[$k]['nickname'] = base64_decode($v['nickname']);
					}
				}
			}
			$action['record'] = $record;
			if($action['place_order'] != 1 && $action['end_time'] <= time()){
				$action['place_order'] = 1;
				if($action['status'] == -1){
					//修改状态为可下单
					$res = pdo_update("gpb_bargain_action",array('status'=>2),array('id'=>$action['id']));//修改这个看见的状态为可以下单
					if($res){
						$action['status'] = 2;
					}else{
                        $this->suc(2,'状态变更失败，请重试');
                    }
				}
			}
			if($info['price_cutting_times'] != 1 && $action['status'] == 3){
				$action = false;
			}
			$info['id'] = $action['id'];
		}
		$member = pdo_get("gpb_member",array('m_openid'=>$openid),array('m_nickname','m_photo'));
		if($this->func_is_base64($member['m_nickname'])){
			$member['m_nickname'] = base64_decode($member['m_nickname']);
		}
		//判断该商品是否在活动商品里面
		$actions = pdo_fetch("select a.at_id,a.at_end_time from ".tablename('gpb_action')." a join ".tablename("gpb_action_goods")." ag on a.at_id = ag.gcg_at_id where ag.gcg_g_id = ".$g_id." and ag.weid = ".$this->weid." and a.at_start_time <= ".time()." and at_end_time >= ".time());
		if($action){
			$info['at_id'] = $actions['at_id'];
			$info['at_end_time'] = $actions['at_end_time'];
		}
		//分享配置
		$config = pdo_getall('gpb_config',array('type'=>26,'weid'=>$this->weid));
		if($config){
			$arr = [];
			foreach($config as $k=>$v){
				if($v['key'] == 'beagiaon_img' || $v['key'] == 'beagiaon_top_img' || $v['key'] == 'beagiaon_style_img'){
					$arr[$v['key']] = tomedia($v['value']);
				}else{
					$arr[$v['key']] = $v['value'];
				}
			}
		}
		$this->suc(1,'',array('info'=>$info,'action'=>$action,'config'=>$arr,'member'=>$member));
	}
	/**
	 * 参与砍价
	 */
	public function hookPageBargain_participation($hook){
		global $_GPC,$_W;
		$openid = $hook['openid'];
		$action_id = $hook['id'];//砍价商品表主键id
		$from = $_GPC['formId'];
		$time = time();
		$gid = pdo_get("gpb_bargaion_goods",array('id'=>$action_id),array('g_id','price_cutting_times'));
		$id = $gid['g_id'];//商品id
		if(empty($openid)){
			$this->suc(2,'参数错误，openid');
		}
		if(empty($id)){
			$this->suc(2,'参数错误，id!!');
		}
		//是否砍价有次数限制
        if($gid['price_cutting_times'] == 1){
		    //是否已发起过砍价
            $has = pdo_fetch("select id,status from ".tablename('gpb_bargain_action')." where openid = '".$openid."' and goods_id = ".$id." and weid = ".$this->weid." and end_time > ".time()." and action_goods = ".$action_id." and (`status`=3 ) order by id desc");
            if(!empty($has)){
                $this->suc(2,'每人限购一次');
            }
        }
		//查看是否参与了砍价
		$action = pdo_fetch("select id,status from ".tablename('gpb_bargain_action')." where openid = '".$openid."' and goods_id = ".$id." and weid = ".$this->weid." and end_time > ".time()." and action_goods = ".$action_id." and ( status = -1 or status = 2 ) order by id desc");
		if($action){
			if($action && $gid['price_cutting_times'] == 1){
				$this->suc(2,'你已经发起砍价，无效重复 发起砍价');
			}
			if($action['status'] != 3){
				$this->suc(2,'你有未砍价未完成');
			}
		}
		$member = pdo_get("gpb_member",array('m_openid'=>$openid),array('m_id','m_nickname','m_photo'));
		if(empty($member)){
			$this->suc(2,'用户信息不存在');
		}
		//获取砍价商品信息
		$where = " and status_time < ".$time." and end_time > ".$time;
		$where .= " and g.g_id = ".$id." and g.weid = ".$this->weid;
		$info = pdo_fetch("select bg.id,g.g_id,g.g_name,g.g_price,g.g_icon,bg.end_time,bg.end_price,st.num,bg.time_limit,bg.place_order,bg.own from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 and bg.id = ".$action_id.$where);
		if(empty($info)){
			echo '<pre>';
			pdo_debug();
			$this->suc(2,'砍价商品信息不存在');
		}
		//结束时间等于  当前时间加上结束小时*3600
		if($info['time_limit']){
			$end_time = $time+($info['time_limit']*3600);
			//当结束时间大于 砍价活动的结束时间时，那么结束时间就是砍价活动的结束时间
			if($end_time > $info['end_time']){
				$end_time = $info['end_time'];
			}
		}else{
			$end_time = $info['end_time'];
		}
		$data = [];
		if($info['place_order'] == 1){
			//没有到低价可以下单
			$data['status'] = 2;
		}
		$data['goods_id'] = $id;
		$data['now_price'] = $info['g_price'];
		$data['create_time'] = $time;
		$data['end_time'] = $end_time;
		$data['openid'] = $openid;
		$data['nickname'] = $member['m_nickname'];
		$data['head_img'] = $member['m_photo'];
		$data['bargaion_price'] = 0;
		$data['weid'] = $this->weid;
		$data['action_goods'] = $info['id'];
		$res = pdo_insert("gpb_bargain_action",$data);
		$ac_id = pdo_insertid();
		if($res){
			//判断自己是否可以砍价
			if($info['own'] != 1){
				//自己可以砍一刀
				$money = $this->bargaion(array('openid'=>$openid,'h_openid'=>$openid,'id'=>$id,'action_id'=>$info['id'],'aid'=>$ac_id));
//				$from
			} else {
				$money = 0;
			}
			//发送砍价信息
			if($money > 0) {
				$sms = new Sms();
                $sms->weid = $this->weid;
				$group = new Group_buyModuleWxapp();
                $group->Token();
				$money = round($money,2);
				$money = (string)$money;
				$sms_array = array('1' => $info['g_name'], '2' =>"已砍:￥".$money, '3' => date('Y-m-d H:i',$end_time), '4' =>$money, '5' => '快去邀请好友...');
//				商品名称,砍价进度,剩余时间,砍价金额,温馨提示
                $dass = $sms->send_out('AT1179', $sms_array, $_W['account']['access_tokne'], $openid, 'plugins/pages/active/cutPriceDetail?id='.$ac_id, $from, $sms->weid, 'AT1179');

                //新增订阅消息 周龙 2020-02-27
                $submsg = new \SubMsg();
                $submsg_arr = [
                    mb_substr($info['g_name'],0,20),
                    "已砍:￥".$money,
                    date('Y-m-d H:i',$end_time),
                    $money,
                    '快去邀请好友...'
                ];
                $submsg->sendmsg("bargain_msg",$openid,$submsg_arr,'plugins/pages/active/cutPriceDetail?id='.$ac_id);

				$this->txt_logging_funs('AT1179.txt',serialize($dass));
			}
			$this->suc(1,'发起砍价成功，快去邀请好友吧',array('money'=>$money,'own'=>$info['own'],'id'=>$ac_id));
		} else {
			$this->suc(2,'发起砍价失败，请重试');
		}
	}
	public function txt_logging_funs($filename, $content){
        if (empty($filename) || empty($content)) {
            return;
        }
        //存日志
        $file = dirname(__FILE__) . '/' . $filename;//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
        if (file_exists($file) && filesize($file) > 100000) {
            unlink($file);//这里是直接删除，
        }
        file_put_contents($file, $content . PHP_EOL, FILE_APPEND);
        return;
    }
	/**
	 * 好友砍价
	 */
	public function hookPageBargain_participation_good_friend($hook){
		global $_GPC,$_W;
		$openid = $hook['openid'];//发起砍价那个人的openid
		$h_openid = $hook['h_openid'];//好友进来帮忙砍价的openid
		$id = $hook['id'];//砍价中表id
		$from = $_GPC['formId'];
		$action_goods = pdo_get('gpb_bargain_action',array('id'=>$id));
		if(empty($action_goods)){
			$this->suc(2,'砍价信息不存在');
		}
		if($action_goods['status'] == 3){
			$this->suc(2,'该砍价已下单，不能继续砍价');
		}
		if($action_goods['status'] == 4){
			$this->suc(2,'该砍价已失败，不能继续砍价');
		}
		$idg = $action_goods['action_goods'];
		$bargain_action_goods = pdo_get("gpb_bargaion_goods",array('id'=>$idg,'weid'=>$this->weid));
		$goods_id = $bargain_action_goods['g_id'];
		$time = time();
		if(empty($openid)){
			$this->suc(2,'请传入那个用户发起的砍价');
		}
		if(empty($h_openid)){
			$this->suc(2,'帮砍用户未授权');
		}
		if(empty($goods_id)){
			$this->suc(2,'请传入商品id');
		}
//		获取帮忙砍价的用户的信息
		$member = pdo_get("gpb_member",array('m_openid'=>$h_openid),array('m_nickname','m_photo'));
		if(empty($member)){
			$this->suc(2,'帮砍用户信息不存在');
		}
//		获取当前价格
//		$bargain_action = pdo_get("gpb_bargain_action",array('goods_id'=>$id,'openid'=>$openid,'weid'=>$this->weid));
		$bargain_action = pdo_fetch("select * from ".tablename("gpb_bargain_action")." where id = ".$id." and openid = '".$openid."' and weid = ".$this->weid." and status != 3 and status != 4 order by id desc");
		if($openid == $h_openid&& $bargain_action['own'] == 1){
			$this->suc(2,'不允许自己给自己砍');
		}
		if(empty($bargain_action)){
			$this->suc(2,'暂无需要砍价商品');
		}
		if($bargain_action['end_time'] < $time){
			$res = pdo_update("gpb_bargain_action",array('status'=>2),array('id'=>$bargain_action['id']));
			$this->suc(2,'砍价已结束');
		}
		$money = $bargain_action['now_price'];//现在的价格     现价
		//获取砍价详情
		$where = " and status_time < ".$time." and end_time > ".$time;
		$where .= " and g.g_id = ".$bargain_action['goods_id']." and g.weid = ".$this->weid;
		$info = pdo_fetch("select bg.id,g.g_id,g.g_name,g.g_price,g.g_icon,bg.end_time,bg.end_price,bg.each_time,st.num,bg.content,bg.total_time,bg.place_order from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 ".$where);
		if(empty($info)){
			$this->suc(2,'砍价信息不存在');
		}
		$end_price = $info['end_price'];//低价
		//判断价格是否砍到最低价了
//		echo $money.'--'.$end_price;exit;
		if($money <= $end_price){
			$this->suc(2,'已经砍到最低价了，不用在砍了!!');
		}
		//帮助好友砍价  查看砍价规则
		$content = unserialize(base64_decode($info['content']));//砍价规则
		//判断可以砍价多少次
		$total_time = $info['total_time'];//可以砍价的总次数
		$total_mr = $info['each_time'];//每个用户单独能砍价好多次
		//获取当前砍了多少次
		$num = pdo_fetchcolumn("select count(*) from ".tablename('gpb_bargaion_record')." where ac_id = ".$bargain_action['id']." and openid = '".$h_openid."'");
		if($num >= $total_mr){
			$this->suc(2,'你已经帮忙砍过了，不能再砍了！');
		}
		$surplus = $total_mr - $num -1 ;
		$num = pdo_fetchcolumn("select count( DISTINCTROW openid) from ".tablename('gpb_bargaion_record')." where ac_id = ".$bargain_action['id']);
		//判断砍价总数
		if($num+1 >= $total_time && $total_time != 0){
			$truns = TRUE;
		}else{
			$truns = FALSE;
		}
		$nums = pdo_fetchcolumn("select count(*) from ".tablename('gpb_bargaion_record')." where ac_id = ".$bargain_action['id']);
		if($nums >= $total_time && $total_time != 0){
			$this->suc(2,'已经砍到底，不能再砍了'.$total_time);
		}
		//判断这次该砍好多钱
//		将砍价规则进行排序   数字大的排在前面  便于后面进行计算
		if(empty($content)){
			$this->suc(2,'尚未配置砍价规则!');
		}
		/*$content = $this->multi_array_sort($content,'probability');//排序
		foreach($content as $k=>$v){
			if($money >= $v['probability']){
				$arr = $v;
				break;
			}
		}
		if(empty($arr)){
			$this->suc(2,'砍价配置规则错误!');
		}
		$max_money = $this->rand_number($arr['min_money']*100,$arr['max_money']*100);
		$max_money = $max_money/100; //砍价金额*/
//		下一步就是判断当前价格减去砍价金额  是否小于低价

		$totalPrice = pdo_fetch("select sum(price) as sum from ".tablename('gpb_bargaion_record')." where ac_id = ".$info['id']);
		$totalPrice = $totalPrice['sum'] ? $totalPrice['sum'] : 0;
		$data_arr = $content;
		$data_arr['total_pople'] = $total_pople;
		$price_max = $money-$end_price;
		$max_money = $this->getPrice($price_max,$totalPrice,$data_arr,$num);
		$max_moneys = $money - $max_money;//减去砍价过后的金额

		if($max_moneys < $end_price){
			//砍价过后的金额小于低价了  不能砍这么多
			$max_money = $money - $end_price;
			$max_moneys = $end_price;
		}
		//判断是否是最后一个人
		if($truns){
			$max_money = $money - $end_price;
			$max_moneys = $end_price;
		}
		$this->begin();
		//新增记录
		$data = [];
		$data['ac_id'] = $bargain_action['id'];
		$data['price'] = $max_money;
		$data['openid'] = $h_openid;
		$data['nickname'] = $member['m_nickname'];
		$data['head_img'] = $member['m_photo'];
		$data['status_time'] = time();
		$res = pdo_insert('gpb_bargaion_record',$data);
		if(empty($res)){
			$this->rollback();
			$this->suc(2,'砍价失败!');
		}
		if($max_moneys == $end_price && $info['place_order'] != 1){
			$res = pdo_update("gpb_bargain_action",array("now_price -="=>$max_money,'bargaion_price +='=>$max_money,'status'=>2),array('id'=>$bargain_action['id']));
		} else {
			$res = pdo_update("gpb_bargain_action",array("now_price -="=>$max_money,'bargaion_price +='=>$max_money),array('id'=>$bargain_action['id']));
		}
		if(empty($res)){
			$this->rollback();
			$this->suc(2,'砍价失败!!');
		}
		$this->commit();
		//计算还能砍价多少次
		if($total_time - $nums <= $total_mr){
			$xxx = $total_time - $nums - $num-1;
		} else {
			$xxx = $total_mr-$num-1;
		}
		//发送模板消息
		if($max_money > 0) {
			$sms = new Sms();
            $sms->weid = $this->weid;
			$group = new Group_buyModuleWxapp();
            $group->Token();
			$sms_array = array('1' => $info['g_name'], '2' =>"已砍:￥".round($bargain_action['bargaion_price']+$max_money,2), '3' => date('Y-m-d H:i',$bargain_action['end_time']), '4' =>round($max_money,2), '5' => '快去邀请好友...');
			if($max_moneys == $end_price){
				$sms_array[5] = "砍价完成，请下单!";
			}
//				商品名称,砍价进度,剩余时间,砍价金额,温馨提示
            $dass = $sms->send_out('AT1179', $sms_array, $_W['account']['access_tokne'], $bargain_action['openid'], 'plugins/pages/active/cutPriceDetail?id='.$id, $from, $sms->weid, 'AT1179');

            //新增订阅消息 周龙 2020-02-27
            $submsg = new \SubMsg();
            $submsg_arr = [
                mb_substr($info['g_name'],0,20),
                "已砍:￥".round($bargain_action['bargaion_price']+$max_money,2),
                date('Y-m-d H:i',$bargain_action['end_time']),
                round($max_money,2),
                '快去邀请好友...'
            ];
            $submsg->sendmsg("bargain_msg",$openid,$submsg_arr,'plugins/pages/active/cutPriceDetail?id='.$id);

			$this->txt_logging_funs('AT1179.txt',serialize($dass));
		}


		$this->suc(1,array('content'=>'本次帮好友砍掉'.$max_money."元",'frequency'=>$xxx,'surplus'=>$surplus));
	}
	/**
	 * 获取最新的订单
	 */
	public function hookPageBargain_participation_order($hook){
		global $_GPC,$_W;
		$info = pdo_fetchall("select m.m_nickname,m.m_photo,s.oss_g_name,o.go_all_price from ".tablename('gpb_order')." o join ".tablename('gpb_order_snapshot')." s on o.go_code = s.oss_go_code join ".tablename('gpb_member')." m on m.m_openid = o.openid where o.weid = ".$this->weid." and s.oss_is_seckill = 2 order by o.go_add_time desc limit 0,10 ");
		if($info){
			foreach($info as $k=>$v){
				if($this->func_is_base64($v['m_nickname'])){
					$info[$k]['nickname'] = base64_decode($v['m_nickname']);
				}
			}
			$this->suc(1,'',$info);
		}else{
			$this->suc(2,'暂无订单',$info);
		}
	}
	/**
	 * 获取已砍价和未砍价
	 */
	public function hookPageBargain_goods_order($hook){
		global $_GPC,$_W;
		$openid = $hook['openid'];
		if(empty($openid)){
			$this->suc(2,'参数错误');
		}
		$status = $hook['status'] ? $hook['status'] : 2;//status 代表请求的是那个数据 1.未砍价 2.已砍价
		$index = $hook['page'] ? $hook['page'] : 1;
		$pageIndex = $index;
        $pageSize = 10;
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		if($status == 2){
			//砍价完成
			$where = " and a.status = 3 ";
		}else{
			//发起砍价了 但是没有砍价完成
			$where = " and (a.status = -1 or a.status = 4 or a.status = 2 ) and a.now_price != g.end_price ";
		}
		$where .= " and a.openid = '".$openid."'";
		$info = pdo_fetchall("select a.end_time,o.g_name,o.g_icon,g.id from ".tablename('gpb_bargain_action')." a join ".tablename('gpb_bargaion_goods')." g on a.action_goods = g.id join ".tablename('gpb_goods')." o on o.g_id = g.g_id where a.weid = ".$this->weid.$where." order by a.end_time desc ".$contion);
		if($info){
			foreach($info as &$v){
				$v['g_icon'] = tomedia($v['g_icon']);
			}
			$this->suc(1,'',array('info'=>$info));
		}else{
			$this->suc(2,'没有数据');
		}
	}
//						--直接发起砍价->每个商品只能发起一次砍价--|
//	砍价列表->砍价商品详情---|								 -----根据配置 下单(注：砍价商品只能立即购买，不能加入购物车..)
//						--继续邀请好友帮砍->能查看哪些用户帮砍了--|
	public function bargaion($hook){
		global $_GPC,$_W;
		$openid = $hook['openid'];//发起砍价那个人的openid
		$h_openid = $hook['h_openid'];//好友进来帮忙砍价的openid
		$id = $hook['id'];//商品id
		$action_id = $hook['action_id'];//活动id
		$aid = $hook['aid'];//action最新发起id
		$time = time();
		if(empty($openid)){
			return '请传入那个用户发起的砍价';
//			$this->suc(2,'请传入那个用户发起的砍价');
		}
		if(empty($h_openid)){
			return '帮砍用户未授权';
		}
		if(empty($id)){
			return '请传入商品id';
		}
//		获取帮忙砍价的用户的信息
		$member = pdo_get("gpb_member",array('m_openid'=>$h_openid),array('m_nickname','m_photo'));
		if(empty($member)){
			return '帮砍用户信息不存在';
		}
//		获取当前价格
		$bargain_action = pdo_get("gpb_bargain_action",array('goods_id'=>$id,'openid'=>$openid,'weid'=>$this->weid,'action_goods'=>$action_id,'id'=>$aid));
		if($openid == $h_openid && $bargain_action['own'] == 1){
			return '不允许自己给自己砍';
		}
		if(empty($bargain_action)){
			return '暂无需要砍价商品';
		}
		if($bargain_action['end_time'] < $time){
			$res = pdo_update("gpb_bargain_action",array('status'=>2),array('id'=>$bargain_action['id']));
			return '砍价已结束';
		}
		$money = $bargain_action['now_price'];//现在的价格     现价
		//获取砍价详情
		$where = " and status_time < ".$time." and end_time > ".$time;
		$where .= " and g.g_id = ".$id." and g.weid = ".$this->weid;
		$info = pdo_fetch("select bg.id,bg.each_time,bg.total_pople,g.g_id,g.g_name,g.g_price,g.g_icon,bg.end_time,bg.end_price,st.num,bg.content,bg.total_time,bg.place_order from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 ".$where);
		if(empty($info)){
			return '砍价信息不存在';
		}
		$end_price = $info['end_price'];//低价
		//判断价格是否砍到最低价了
		if($money == $end_price){
			return '已经砍到最低价了，不用在砍了!!';
		}
		//帮助好友砍价  查看砍价规则
		$content = unserialize(base64_decode($info['content']));//砍价规则
		//判断可以砍价多少次
//		$total_time = $info['total_time'];//可以砍价的总次数
		$each_time = $info['each_time'];//每个人可以砍价的总次数
		$total_pople = $info['total_pople'];//总共多少人砍
		//获取当前砍了多少次
		$num = pdo_fetchcolumn("select count(*) from ".tablename('gpb_bargaion_record')." where ac_id = ".$bargain_action['id']." and openid = '".$h_openid."'");
		if($num >= $each_time){
			return '你已经帮忙砍过了，不能再砍了！';
		}
		//判断砍价总数
		$num = pdo_fetchcolumn("select count( DISTINCTROW openid) as `count(*)` from ".tablename('gpb_bargaion_record')." where ac_id = ".$bargain_action['id']);
		if($num >= $total_pople && $total_pople != 0){
			return '已经砍到底，不能再砍了';
		}
		//判断这次该砍好多钱
//		将砍价规则进行排序   数字大的排在前面  便于后面进行计算
		if(empty($content)){
			return '尚未配置砍价规则!';
		}
		//开始结算砍价金额
		/**$content = $this->multi_array_sort($content,'probability');//排序
		foreach($content as $k=>$v){
			if($money >= $v['probability']){
				$arr = $v;
				break;
			}
		}
		if(empty($arr)){
			return '砍价配置规则错误!';
		}
//		第一版砍价规则
		$max_money = $this->rand_number($arr['min_money']*100,$arr['max_money']*100);
		$max_money = $max_money/100; //砍价金额*/
		//获取已砍
		$totalPrice = pdo_fetch("select sum(price) as sum from ".tablename('gpb_bargaion_record')." where ac_id = ".$info['id']);
		$totalPrice = $totalPrice['sum'] ? $totalPrice['sum'] : 0;
		$data_arr = $content;
		$data_arr['total_pople'] = $total_pople;
		$price_max = $money-$end_price;
		$max_money = $this->getPrice($price_max,$totalPrice,$data_arr,$num);
		//计算完成
//		if($max_money == 0){
//			return '砍价配置规则错误!';
//		}
//		下一步就是判断当前价格减去砍价金额  是否小于低价
		$max_moneys = $money - $max_money;//减去砍价过后的金额
		if($max_moneys < $end_price){
			//砍价过后的金额小于低价了  不能砍这么多
			$max_money = $money - $end_price;
			$max_moneys = $end_price;
		}
		$this->begin();
		//新增记录
		$data = [];
		$data['ac_id'] = $bargain_action['id'];
		$data['price'] = $max_money;
		$data['openid'] = $h_openid;
		$data['nickname'] = $member['m_nickname'];
		$data['head_img'] = $member['m_photo'];
		$data['status_time'] = time();
		$res = pdo_insert('gpb_bargaion_record',$data);
		if(empty($res)){
			$this->rollback();
			return '砍价失败';
		}
//        $max_money = number_format($max_moneys,2);
        //2020-04-30 计算错误修改 周龙 moneys代表剩余价格 不能取
        $max_money = number_format($max_money,2);
        $end_price = number_format($end_price,2);
		if($max_moneys == $end_price && $info['place_order'] != 1){
			$res = pdo_update("gpb_bargain_action",array("now_price -="=>$max_money,'bargaion_price +='=>$max_money,'status'=>2),array('id'=>$bargain_action['id']));
		} else {
			$res = pdo_update("gpb_bargain_action",array("now_price -="=>$max_money,'bargaion_price +='=>$max_money),array('id'=>$bargain_action['id']));
		}
		if(empty($res)){
			$this->rollback();
			return '砍价失败2!';
		}
		$this->commit();
		return $max_money;
	}
	/**
	 * 数组排序
	 * @param $arr 排序数组
	 * @param $shortKey 排序值
	 */
	public function multi_array_sort($arr,$shortKey,$short=SORT_DESC,$shortType=SORT_REGULAR){
		if($arr){
			foreach ($arr as $key => $data){
				$name[$key] = $data[$shortKey];
			}
			array_multisort($name,$shortType,$short,$arr);
		}
		return $arr;
	}
	/**
	 * 随机数字
	 */
	public function rand_number($min, $max){
	    return sprintf("%0".strlen($max)."d", mt_rand($min,$max));
	}
	/**
	 * 信息返回
	 */
	public function suc($erron,$msg='',$data=[]){
		echo json_encode(array('code'=>$erron,'msg'=>$msg,'data'=>$data));exit;
	}
	/**
	 * 判断字符串是否base64编码
	 */
	public function func_is_base64($str){
	    return $str == base64_encode(base64_decode($str)) ? true : false;
	}
	/**
	 * 开启事务
	 */
	public function begin(){
		pdo_begin();//开启事务
		return '';
	}
	/**
	 * 事务回滚
	 */
	public function rollback(){
		pdo_rollback();//失败回滚
		return '';
	}
	/**
	 * 事务提交
	 */
	public function commit(){
		pdo_commit();//成功提交
		return '';
	}
	/**
	 * 计算砍价价格
	 * @param $price floot 总共能砍好多钱
	 * @param $totalprice fllot 已砍好多钱
	 * @param $data array 当前商品的砍价配置
	 * @param $userCount int 已经有好多人帮砍了
	 * return int
	 */
	private function getPrice($price,$totalPrice,$data,$people){
        //$data是砍价配置
        //$people已经帮砍的人数
        //$price 低价
        //$totalPrice  已砍
        if(isset($data['total_pople'])){
//      	var_dump($data,$people);exit;
            $dataPeople = intval($data['total_pople']);//能好多人砍价
            if($dataPeople != 0){//砍价总人数不等于0
                if($people == $dataPeople - 1){//当前已经砍价人数等于总人数减1
                    $money = ($price - $totalPrice) * 100;//金额等于能砍价的金额  减去已经砍价的金额
                    return $money;
                }
                if($people == $dataPeople){//能砍价的金额等于 已经砍价的金额 返回0
                    return 0;
                }
            }
        }
        if ($people < intval($data['probability'])) {
        	//如果已经帮砍人数  小于 总参与人数
            $min = $data['min_money'] > $data['max_money'] ? $data['max_money'] : $data['min_money'];
            $max = $data['min_money'] > $data['max_money'] ? $data['min_money'] : $data['max_money'];
            $money = $this->getRand($min * 100, $max * 100);
        } else {
            $min = min($data['min_money_surplus'], $data['max_money_surplus']);
            $max = max($data['min_money_surplus'], $data['max_money_surplus']);
            $money = $this->getRand($min * 100, $max * 100);
        }
        if($money > ($price - $totalPrice) * 100){
            $money = ($price - $totalPrice) * 100;
        }
        return $this->intToFloat($money);
	}
	// 随机数
    private function getRand($min, $max)
    {
        return round(mt_rand($min, $max), 2);
    }
	// int转float
    private function intToFloat($int)
    {
        if (count($int) < 3) {
            $int = str_pad($int, 3, 0, STR_PAD_LEFT);
        }
        return round(floatval($this->ToStr($int, strlen($int) - 2, '.')), 2);
    }
	/**
     * 指定位置插入字符串
     * @param $str string  原字符串
     * @param $i  integer   插入位置
     * @param $substr string 插入字符串
     * @return string 处理后的字符串
     */
    private function ToStr($str, $i, $substr){
        //指定插入位置前的字符串
        $startstr = "";
        for ($j = 0; $j < $i; $j++) {
            $startstr .= $str[$j];
        }
        //指定插入位置后的字符串
        $laststr = "";
        for ($j = $i; $j < strlen($str); $j++) {
            $laststr .= $str[$j];
        }
        //将插入位置前，要插入的，插入位置后三个字符串拼接起来
        $str = $startstr . $substr . $laststr;
        //返回结果
        return $str;
    }
	/**
	 * 获取没有砍价完成的订单  取消
	 */
	public function order(){
		$time = time();
		$info = pdo_fetchall("select id from ".tablename('gpb_bargain_action')." where end_time < :time and status != 3 ",array(':time'=>$time));
		if($info){
			$where = "";
			foreach($info as $k=>$v){
				$where .= " id = ".$v['id'];
				if($k != count($info)-1){
					$where .= " or ";
				}
			}
			$sql = "UPDATE ".tablename('gpb_bargain_action')." SET `status` = 4 WHERE ".$where;
			if($where){
				pdo_query($sql);
			}
		}
		return true;
	}
}
?>