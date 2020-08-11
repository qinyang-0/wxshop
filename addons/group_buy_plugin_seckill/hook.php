<?php
/**
 * 
 * 
 * 
 */
defined('IN_IA') or exit('Access Denied');class Group_buy_plugin_seckillModuleHook extends WeModuleHook {
    public $weid;
    private $uid;
    private $pay_setting;

    //开始时间,固定一个小于当前时间的毫秒数即可
    const twepoch =  1474990000000;//2016/9/28 0:0:0
    //机器标识占的位数
    const workerIdBits = 0;
    //数据中心标识占的位数
    const datacenterIdBits = 0;
    //毫秒内自增数点的位数
    const sequenceBits = 1;
    protected $workId = 1;
    protected $datacenterId = 1;
    static $lastTimestamp = -1;
    static $sequence = 0;

	public function __construct($workId=0, $datacenterId=0 )
    {
        global $_W,$_GPC;
        $this->weid = $_W['uniacid'];
//        exit(var_dump($_GPC['openid']));
        if(!empty($_GPC['openid'])){
            $user_id = pdo_get("gpb_member",['weid'=>$this->weid,'m_openid'=>$_GPC['openid']]);
            $this->uid = $user_id['m_id'];
        }
        $redis = $this->redis();
        if(is_error($redis)){
            $this->apireturn("redis服务错误，请联系管理员",1);
        }

        if(is_array($_W['account'])){
            $is_true = true;
            if(!isset($_W['account']['setting']['payment']['wechat']['mchid']) || empty($_W['account']['setting']['payment']['wechat']['mchid'])){
                //$this->result("1","商户号有误");
                $is_true = false;
            }
            if(!isset($_W['account']['setting']['payment']['wechat']['signkey']) || empty($_W['account']['setting']['payment']['wechat']['signkey'])){
                //$this->result("1","支付密钥有误");
                $is_true = false;
            }
            if($is_true){
                $pay = [
                    'wechat'=>[
                        'mchid'=>$_W['account']['setting']['payment']['wechat']['mchid'],
                        'signkey'=>$_W['account']['setting']['payment']['wechat']['signkey'],
                    ]
                ];
            }

        }else{
            $is_true = true;
            if(!isset($_W['account']->setting['payment']['wechat']['mchid']) || empty($_W['account']->setting['payment']['wechat']['mchid'])){
//                $this->result("1","商户号有误");
                $is_true = false;
            }
            if(!isset($_W['account']->setting['payment']['wechat']['signkey']) || empty($_W['account']->setting['payment']['wechat']['signkey'])){
//                $this->result("1","支付密钥有误");
                $is_true = false;
            }
            if($is_true){
                $pay = [
                    'wechat'=>[
                        'mchid'=>$_W['account']->setting['payment']['wechat']['mchid'],
                        'signkey'=>$_W['account']->setting['payment']['wechat']['signkey'],
                    ]
                ];
            }
        }
        $this->pay_setting = $pay;

        //机器ID范围判断
        $maxWorkerId = -1 ^ (-1 << self::workerIdBits);

        if($workId > $maxWorkerId || $workId< 0){
            throw new \Exception("workerId can't be greater than ".$this->maxWorkerId." or 
less than 0");
        }
        //数据中心ID范围判断
        $maxDatacenterId = -1 ^ (-1 << self::datacenterIdBits);
        if ($datacenterId > $maxDatacenterId || $datacenterId < 0) {
            throw new \Exception("datacenter Id can't be greater than ".$maxDatacenterId." 
or less than 0");
        }
        //赋值
        $this->workId = $workId;
        $this->datacenterId = $datacenterId;

    }
    //生成一个ID
    public function nextId(){
        $timestamp = $this->timeGen();

        $lastTimestamp = self::$lastTimestamp;

        //判断时钟是否正常
        if ($timestamp < $lastTimestamp) {
            throw new \Exception("Clock moved backwards.  Refusing to generate id for %d 
milliseconds", ($lastTimestamp - $timestamp));
        }
        //生成唯一序列
        if ($lastTimestamp == $timestamp) {
            $sequenceMask = -1 ^ (-1 << self::sequenceBits);
            self::$sequence = (self::$sequence + 1) & $sequenceMask;
            if (self::$sequence == 0) {
                $timestamp = $this->tilNextMillis($lastTimestamp);
            }
        } else {
            self::$sequence = 0;
        }

        self::$lastTimestamp = $timestamp;

        //时间毫秒/数据中心ID/机器ID,要左移的位数
        $timestampLeftShift = self::sequenceBits + self::workerIdBits +
            self::datacenterIdBits;

        $datacenterIdShift = self::sequenceBits + self::workerIdBits;
        $workerIdShift = self::sequenceBits;

        //组合4段数据返回: 时间戳.数据标识.工作机器.序列
        $nextId = (($timestamp - self::twepoch) << $timestampLeftShift) |
            ($this->datacenterId << $datacenterIdShift) |
            ($this->workId << $workerIdShift) | self::$sequence;

        $id = str_pad(abs($nextId),2,'',STR_PAD_LEFT);
//        echo date('mdhi'). $id;;exit;
        return date('mdhi'). substr($id,3);
        //return time().$id;
    }
    //取当前时间毫秒
    protected function timeGen(){
        $timestramp = (float)sprintf("%.0f", microtime(true) * 1000);
//        $timestramp = (float)sprintf("%.0f", time(true) *1000);
        return  $timestramp;
    }
    //取下一毫秒
    protected function tilNextMillis($lastTimestamp) {
        $timestamp = $this->timeGen();
        while ($timestamp <= $lastTimestamp) {
            $timestamp = $this->timeGen();
        }
        return $timestamp;
    }
    public function hookPageSeckill_test_key($hook)
    {
        $redis = $this->redis();
        $keys = $this->redis()->keys("group_buy_*");
        $test = $redis->getKeys("group_buy_*");
        var_dump($test);
        echo "<table border='1'>";
        foreach ($keys as $v){
            echo "<tr><td>".$v."</td></tr>";
        }
        echo "</table>";
        $result = array();
        var_dump($result);
        $res = array();
        $tt = $redis->get('group_buy_6_wxd638314c68886fa2_seckill_calendar_2019_04');
        var_dump($redis->ttl('group_buy_6_wxd638314c68886fa2_seckill_calendar_2019_04'));
        echo "---<br>";
        var_dump(json_decode($tt,TRUE));
        foreach ($result as $key => $val) {
            $res[$key] = json_decode($val, TRUE);
        }
        var_dump($res);exit;
    }

    /*
     *qt
     */
    public function hookPageSeckill_test($hook){
        global $_W,$_GPC;

	    exit;
    }
    //秒杀
    /*
     * 秒杀
     * qi
     */
    public function hookPageSeckill_index($hook){
        global $_W,$_GPC;
        $openid  = trim($_GPC['openid']);
        if(empty($openid)){
            $this->apireturn("未授权",1);
        }
        $member = pdo_get('gpb_member',array('m_openid'=>$openid));
        if(empty($member)){
            $this->apireturn("未授权",1);
        }
		$temp = pdo_get('gpb_diy_page', array('system' => 3, 'status' => 2, 'weid' => $this->weid));
        if (empty($temp)) {
            //先获取使用的系统模板
            $sql = " select t.id,content from " . tablename("gpb_diy_temp") . " t join " . tablename('gpb_diy_page') . " p on t.id = p.tempid where t.isact = 1 and (t.weid = " . $this->weid . " or t.system =2)";
            $temp = pdo_fetch($sql);
            if (empty($temp)) {
                $sql = " select t.id,content from " . tablename("gpb_diy_temp") . " t join " . tablename('gpb_diy_page') . " p on t.id = p.tempid where t.isact = 1 and t.weid = 0 ";
                $temp = pdo_fetch($sql);
            }
        }
		//判断秒杀模块开启没得
		$temp = unserialize($temp['content']);
		$ts = 1;
		if($temp){
			foreach($temp['data'] as $k=>$v){
				if($v['name'] == 'seckill'){
					$ts = 2;
					break;
				}
			}
		}
		if($ts == 1){
			$this->apireturn("暂未开启秒杀~~",1);
		}
        $limit='';
        if($_GPC['type']=='index'){
            $limit = 'limit 5';
        }
//      $advs = pdo_fetchall('select * from ' . tablename('gpb_shop_seckill_adv') . ' where uniacid=:uniacid and enabled=1 order by displayorder asc', array(':uniacid' => $_W['uniacid']));
//      foreach ($advs as &$v){
//          $v['thumb']= tomedia( $v['thumb']);
//      }
//        $advs = set_medias($advs, 'thumb');
        $taskid = intval($_GPC['taskid']);
        if (empty($taskid)) {
            $taskid = $this->getTodaySeckill();
            if (empty($taskid)) {
                $this->apireturn("秒杀已结束，请关注下期~",1);
                exit();
            }
        }
        $task = $this->getTaskInfo($taskid);

        if (empty($task)) {
            $this->apireturn("秒杀已结束，请关注下期~",1);
            exit();
        }
        $rooms = $this->getRooms($taskid);
        if (empty($rooms)) {
            $this->apireturn("秒杀会场已关闭，请关注下期~",1);
            exit();
        }

        $room = false;
        $roomindex = 0;
        $roomid = intval($_GPC['roomid']);

        if (empty($roomid)) {
            foreach ($rooms as $row) {
                $room = $row;
                break;
            }
        }else {
            foreach ($rooms as $index => $row) {
                if ($row['id'] == $roomid) {
                    $room = $row;
                    $roomindex = $index;
                    break;
                }
            }
        }
        if (empty($room)) {
            $this->apireturn("秒杀会场已关闭，请关注下期~",1);
            exit();
        }
        $roomid = $room['id'];
        $timeid = 0;
        $currenttime = time();
        $timeindex = -1;
        $alltimes = $this->getTaskTimes($taskid);
        $times = array();
        $validtimes = array();
        foreach ($alltimes as $key => $time) {
            $oldshow = true;
            $timegoods = $this->getSeckillGoods($taskid, $time['time'], 'all');
            $hasGoods = false;

            foreach ($timegoods as $tg) {
                if ($tg['roomid'] == $roomid) {
                    $hasGoods = true;
                    break;
                }
            }
            if (isset($alltimes[$key + 1])) {
                $end = $alltimes[$key + 1]['time'] - 1;
                $endtime = strtotime(date('Y-m-d ' . $end . ':59:59'));
            } else if (empty($task['overtimes'])) {
                $endtime = strtotime(date('Y-m-d 23:59:59'));
            } else {
                $endtime = strtotime(date('Y-m-d ' . $task['overtimes'] . ':00:00'));
            }

            if ($endtime < $currenttime) {
                if (!$room['oldshow']) {
                    $oldshow = false;
                }
            }
            if ($hasGoods && $oldshow) {
                $validtimes[] = $time;
            }
        }
        foreach ($validtimes as $key => $time) {
            $timestr = $time['time'];

            if (strlen($timestr) == 1) {
                $timestr = '0' . $timestr;
            }

            $starttime = strtotime(date('Y-m-d ' . $timestr . ':00:00'));

            if (isset($validtimes[$key + 1])) {
                $end = $validtimes[$key + 1]['time'] - 1;
                $endtime = strtotime(date('Y-m-d ' . $end . ':59:59'));
            }else if (empty($task['overtimes'])) {
                $endtime = strtotime(date('Y-m-d 23:59:59'));
            }else {
                $endtime = strtotime(date('Y-m-d ' . $task['overtimes'] . ':00:00'));
            }

            $time['endtime'] = $endtime;
            $time['starttime'] = $starttime;
            if ($starttime <= $currenttime && $currenttime <= $endtime) {
                $time['status'] = 0;//正在进行
                $timeid = $time['id'];

                if ($timeindex == -1) {
                    $timeindex = $key;
                }
            }else if ($currenttime < $starttime) {
                $time['status'] = 1;//未开始

                if (empty($timeid)) {
                    $timeid = $time['id'];
                }
            }else {
                if ($endtime < $currenttime) {
                    $time['status'] = -1;//已结束

                    if (empty($timeid)) {
                        $timeid = $time['id'];
                    }
                }
            }

            $time['time'] = $timestr;
            $times[] = $time;
        }
        if($_GPC['test']==1){
            var_dump($times);
        }
//        获取当前小时数
        //获取商品
        //当前商品
        $currentgoods =array();
        //过期商品
        $overgoods =array();
        //未开启
        $aftergoods=array();
		//这里开始卡了
		
        if(is_array($times)){
            foreach ($times as $k=>$v){
                $sql = 'select g.*,tg.* from ' . tablename('gpb_shop_seckill_task_goods') . ' tg  
                  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id 
                  where tg.taskid=:taskid and tg.roomid=:roomid and tg.timeid=:timeid and tg.uniacid=:uniacid  group by tg.goodsid order by tg.displayorder asc  '.$limit;
                $goods = pdo_fetchall($sql, array(':taskid' => $v['taskid'], ':roomid' => $roomid, ':uniacid' => $_W['uniacid'], ':timeid' => $v['id']));
                foreach ($goods as &$g) {
                    //$seckillinfo = $this->getSeckill($g['goodsid'], $g['optionid'], false);
                    if ($g['g_has_option']) {
                        $total = 0;
                        $count = 0;
                        $options = pdo_fetchall('select tg.id,tg.goodsid,tg.optionid,tg.price,g.g_name,g.g_price,g.g_old_price,tg.commission1,tg.commission2,tg.commission3,tg.total,tg.sale_num from ' . tablename('gpb_shop_seckill_task_goods') . '  tg  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id  where tg.timeid=:timeid and tg.taskid=:taskid and tg.timeid=:timeid  and tg.goodsid=:goodsid and  tg.uniacid =:uniacid ', array(':timeid' => $v['id'], ':taskid' => $v['taskid'], ':goodsid' => $g['goodsid'], ':uniacid' => $_W['uniacid']));
                        $price = $options[0]['price'];
                        $productprice = $options[0]['g_old_price'];
                        foreach ($options as $option) {
                            $total += $option['total'];
                            if ($option['price'] < $price) {
                                $price = $option['price'];
                            }
                            if ($productprice < $option['g_old_price']) {
                                $productprice = $option['g_old_price'];
                            }
                        }
                        $g['price'] = $price;
                        $g['g_old_price'] = $productprice;
                        $g['total'] = $total;
//                        $g['count'] = $seckillinfo['count'];
//                        $g['percent'] = 100 < $seckillinfo['percent'] ? 100 : $seckillinfo['percent'];
                        $g['percent'] = intval($g['sale_num']/($g['sale_num']+$g['total'])*100);
                        $g['count'] = $g['sale_num'];
                    } else {
//                        $g['count'] = $seckillinfo['count'];
//                        $g['percent'] = 100 < $seckillinfo['percent'] ? 100 : $seckillinfo['percent'];
                        $g['percent'] = intval($g['sale_num']/($g['sale_num']+$g['total'])*100);
                        $g['count'] = $g['sale_num'];
                    }
                    $g['g_icon'] = tomedia($g['g_icon']);
                    $g['g_old_price'] = $this->price_format($g['g_old_price']);
                    $g['priceArry'] = explode('.',$g['price']);

                    $g['g_video'] = tomedia($g['g_video']);
                    $g['g_video_open'] = empty($g['g_video'])?0:1;
//                  $buy_people = pdo_fetchall("select DISTINCT m_photo from " . tablename('gpb_order_snapshot') . " as s left join " . tablename('gpb_member') . " as m on m.m_openid =s.oss_buy_openid where s.oss_gid =" . $g['g_id'] . " and m.weid=".$_W['uniacid']." limit 0,9");//耗时高
//                  
//                  $buy_people_num = pdo_fetchcolumn("select count(*) from (select count(*) from " . tablename('gpb_order_snapshot') . " as s left join " . tablename('gpb_member') . " as m on m.m_openid =s.oss_buy_openid where s.oss_gid =" . $g['g_id'] . " and m.weid=".$_W['uniacid']." group by m_openid ) as tmp");//耗时高
                    $g['buy_people'] = $buy_people;
                    $g['buy_people_num'] = $buy_people_num;
                    if ( !empty($at_id) and $at_id != 'undefined' ) {
                        $action = pdo_fetch("select * from ".tablename($this->action)." where weid=".$this->weid." and at_id=".$at_id);
                        $g['action'] = $action;
                    }
                    //获取该用户的当前购物车中的该商品数
                    $g['curGoodsNum'] = 0;
                    $g['isshowbtn'] = 1;
                    if(!empty($openid)){
                        $goods_cart = pdo_fetch("select c_count,c_id from ".tablename('gpb_cart')." where openid='".$openid."' and c_is_del =1 and c_status =1 and c_g_id = ".$g['g_id'] );
                        if(empty($goods_cart)){
                            $g['isshowbtn'] =1;
                            $g['curGoodsNum'] =0;
                            $g['cart_id'] =0;
                        }else{
                            $g['isshowbtn'] =2;
                            $g['curGoodsNum'] =$goods_cart['c_count'];
                            $g['cart_id'] =$goods_cart['c_id'];
                        }
                    }
                    //获取库存和销售数量
                    //预计几天后到达
                    $g["arrival_time"] = date("m月d日",(time()+($g["g_arrival_time"]*24*60*60)));
                    $g['sale_is_over']=0;
                    if( $g['g_end_sale_time']<time()){
                        $g['sale_is_over']=1;
                    }
                    $g['taskid'] = $v['taskid'];
                    $g['roomid'] = $roomid;
                    $g['timeid'] = $v['id'];
                    $g['num'] = $g['total'];
                    $g['oldshow'] = $room['oldshow'];
                    $g['percent'] = intval($g['sale_num']/($g['sale_num']+$g['total'])*100);
                }

                $times[$k]['goods']= $goods;
                if($v['status']==-1){
                    //过期商品
                    $overgoods[] = $times[$k];
                } elseif ($v['status']==1){
                    //未开启
                    $aftergoods[]= $times[$k];
                } elseif ($v['status']==0){
                    $currentgoods = $times[$k];
                }
            }
        }

        //分享相关
        $share_title = $room['share_title'];

        if (empty($share_title)) {
            $share_title = $room['page_title'];
        }

        if (empty($share_title)) {
            $share_title = $room['title'];
        }

        if (empty($share_title)) {
            $share_title = $task['share_title'];
        }

        if (empty($share_title)) {
            $share_title = $task['page_title'];
        }

        if (empty($share_title)) {
            $share_title = $task['title'];
        }

        $share_desc = $room['share_desc'];

        if (empty($share_desc)) {
            $share_desc = $task['share_desc'];
        }

        if ($timeindex == -1) {
            $timeindex = 0;
        }
        $count = count($times);
        if ($count - 1 <= $timeindex) {
            $timeindex = $count - 1;
        }
        $page_title = empty($task['page_title']) ? $task['title'] : $task['page_title'];
        if (!empty($room['title'])) {
            $page_title .= ' - ' . $room['title'];
        }
        $mid = $member['m_id'];
        $share_icon = empty($room['share_icon']) ? $task['share_icon'] : $room['share_icon'];
        if (empty($share_icon)) {
            $share_icon = $_W['shopset']['share']['icon'];
        }
        $_W['shopshare'] = array('title' => $share_title,'taskid'=>$taskid, 'roomid' => $roomid,'mid'=>$mid, 'imgUrl' => tomedia($share_icon), 'desc' => $share_desc);
        //查询
        $seckill_goods_list_icon = pdo_get('gpb_config',array('key'=>'seckill_goods_list_icon','weid'=>$_W['uniacid']));
        $seckill_goods_list_icon_val = isset($seckill_goods_list_icon['value'])?tomedia($seckill_goods_list_icon['value']):tomedia('/addons/group_buy/public/bg/seckill_goods_list_icon.png');
        $seckill_goods_info_price_bg = pdo_get('gpb_config',array('key'=>'seckill_goods_info_price_bg','weid'=>$_W['uniacid']));
        $seckill_goods_info_price_val = isset($seckill_goods_info_price_bg['value'])?$seckill_goods_info_price_bg['value']:'#fde529';
		if($_GPC['types'] === '2'){
			return array('currentgoods'=>$currentgoods,'aftergoods'=>$aftergoods);
		} else {
	        $this->apireturn("获取成功",0,array('share'=>$_W['shopshare'],'overgoods'=>$overgoods,'aftergoods'=>$aftergoods,'currentgoods'=>$currentgoods,'seckill_goods_list_icon'=>$seckill_goods_list_icon_val,'seckill_goods_info_price_bg'=>$seckill_goods_info_price_val));
		}
    }
	/**
	 * 判断秒杀商品是否参与
	 */
	public function hookPageSeckill_get_goods_info($hook){
		global $_W,$_GPC;
		$id = $hook['gid'];
        $taskid = $this->getTodaySeckill();
        if (empty($taskid)) {
            return FALSE;
        }
        $task = $this->getTaskInfo($taskid);
//		$taskid  //这个是当天的专题
		$info = pdo_fetchall("select g.id from ".tablename("gpb_shop_seckill_task_room")." r join ".tablename('gpb_shop_seckill_task_goods')."g on r.id = g.roomid where r.enabled = 1 and g.taskid = ".$taskid." and goodsid = ".$id);
		if($info){
			return true;
		}else{
			return FALSE;
		}
	}
    /*
     * 获取秒杀商品
     * qg
     */
    public function hookPageSeckill_get_goods($hook)
    {
        global $_W;
        global $_GPC;
        $taskid = intval($_GPC['taskid']);
        $roomid = intval($_GPC['roomid']);
        $timeid = intval($_GPC['timeid']);
        $where ='';
        $gid = intval($_GPC['gid']);
        if(!empty($gid)){
            $where = ' and tg.goodsid='.$gid.' ';
        }
        $task = $this->getTaskInfo($taskid);

        if (empty($task)) {
            $this->apireturn("秒杀已结束，请关注下期~",1);
        }

        $room = $this->getRoomInfo($taskid, $roomid);
        if (empty($room)) {
            $this->apireturn("秒杀会场已关闭，请关注下期~",1);
        }

        $time = false;
        $nexttime = false;
        $times = $this->getTaskTimes($taskid);

        foreach ($times as $key => $ctime) {
            if ($ctime['id'] == $timeid) {
                $time = $ctime;

                if (isset($times[$key + 1])) {
                    $nexttime = $times[$key + 1];
                }

                break;
            }
        }

        if (empty($time)) {
            $this->apireturn("当前时间段无秒杀，请关注下期~",1);
        }

        $currenttime = time();
        $starttime = strtotime(date('Y-m-d ' . $time['time'] . ':00:00'));

        if (!empty($nexttime)) {
            $end = $nexttime['time'] - 1;
            $endtime = strtotime(date('Y-m-d ' . $end . ':59:59'));
        } else if (empty($task['overtimes'])) {
            $endtime = strtotime(date('Y-m-d 23:59:59'));
        } else {
            $endtime = strtotime(date('Y-m-d ' . $task['overtimes'] . ':00:00'));
        }

        $time['endtime'] = $endtime;
        $time['starttime'] = $starttime;
        if ($starttime <= $currenttime && $currenttime <= $endtime) {
            $time['status'] = 0;
        } else if ($currenttime < $starttime) {
            $time['status'] = 1;
        } else {
            if ($endtime < $currenttime) {
                $time['status'] = -1;
            }
        }

        $sql = 'select tg.*,g.* from ' . tablename('gpb_shop_seckill_task_goods') . ' as tg  
                  left join ' . tablename('gpb_goods') . ' as g on tg.goodsid = g.g_id 
                  where  tg.taskid=:taskid and tg.roomid=:roomid and tg.timeid=:timeid and tg.uniacid=:uniacid '.$where.'  group by tg.goodsid order by tg.displayorder asc ';
        $goods = pdo_fetchall($sql, array(':taskid' => $taskid, ':roomid' => $roomid, ':uniacid' => $_W['uniacid'], ':timeid' => $time['id']));
//        var_dump($goods);
        foreach ($goods as &$g) {
//            if (p('offic')) {
//                $g['thumb_url'] = array_values(unserialize($g['thumb_url']));
//                $g['thumb'] = tomedia($g['thumb_url'][0]);
//            }

            $seckillinfo = $this->getSeckill($g['goodsid'], 0, false);
//            var_dump($seckillinfo);exit;
            if ($g['g_has_option']) {
                $total = 0;
                $count = 0;
                $options = pdo_fetchall('select tg.id,tg.goodsid,tg.optionid,tg.price,g.g_name,g.g_price,g.g_old_price,tg.commission1,tg.commission2,tg.commission3,tg.total,tg.sale_num from ' . tablename('gpb_shop_seckill_task_goods') . '  tg  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id  where tg.timeid=:timeid and tg.taskid=:taskid and tg.timeid=:timeid  and tg.goodsid=:goodsid and  tg.uniacid =:uniacid ', array(':timeid' => $time['id'], ':taskid' => $taskid, ':goodsid' => $g['goodsid'], ':uniacid' => $_W['uniacid']));
                $price = $options[0]['price'];
                $productprice = $options[0]['g_old_price'];

                foreach ($options as $option) {
                    $total += $option['total'];

                    if ($option['price'] < $price) {
                        $price = $option['price'];
                    }

                    if ($productprice < $option['g_old_price']) {
                        $productprice = $option['g_old_price'];
                    }
                }

                $g['price'] = $price;
                $g['g_old_price'] = $productprice;
                $g['total'] = $total;
//                $g['count'] = $seckillinfo['count'];
//                $g['percent'] = 100 < $seckillinfo['percent'] ? 100 : $seckillinfo['percent'];
				if(($g['sale_num']+$g['total'])> 0){
					$g['percent'] = intval($g['sale_num']/($g['sale_num']+$g['total'])*100);
				}else{
					$g['percent'] = 0;
				}
                $g['count'] = $g['sale_num'];
            } else {
            	if(($g['sale_num']+$g['total'])> 0){
            		$g['percent'] = intval($g['sale_num']/($g['sale_num']+$g['total'])*100);
            	}else{
					$g['percent'] = 0;
				}
                
                $g['count'] = $g['sale_num'];
//                $g['count'] = $seckillinfo['count'];
//                $g['percent'] = 100 < $seckillinfo['percent'] ? 100 : $seckillinfo['percent'];
            }
            $g['g_icon'] = tomedia($g['g_icon']);

            $thumb =explode(',', $g['g_thumb']);
            $thumb_arr = array();
            foreach ($thumb as $v){
                $thumb_arr[] = tomedia($v);
            }
            $g['g_thumb'] =$thumb_arr;
            $g['g_old_price'] = $this->price_format($g['g_old_price']);
            $g['priceArry'] = explode('.',$g['price']);

            $g['g_video'] = tomedia($g['g_video']);
            $g['g_video_open'] = empty($g['g_video'])?0:1;
            $g['g_info'] = htmlspecialchars_decode($g['g_info']);
            $g['g_icon_bak'] = tomedia($g['g_icon_bak']);
            $g['num'] = $g['total'];
            $buy_people = pdo_fetchall("select DISTINCT m_photo from " . tablename('gpb_order_snapshot') . " as s left join " . tablename('gpb_member') . " as m on m.m_openid =s.oss_buy_openid where s.oss_gid =" . $g['g_id'] . " and m.weid=".$_W['uniacid']." limit 0,9");
            
            $buy_people_num = pdo_fetchcolumn("select count(*) from ( select count(*) from " . tablename('gpb_order_snapshot') . " as s left join " . tablename('gpb_member') . " as m on m.m_openid =s.oss_buy_openid where s.oss_gid =" . $g['g_id'] . " and m.weid=".$_W['uniacid']." group by m_openid) as temp");
			
//			$sql = "";
            
//						$buy_people_num = pdo_fetchcolumn("select count(*) from (select count(*) as num from " . tablename($this->snapshot) . " as s left join " . tablename($this->member) . " as m on m.m_openid =s.oss_buy_openid left join " . tablename($this->order) . " as go on s.oss_go_code = go.go_code where m.weid=" . $this->weid . " and go.`type`=1 and s.oss_gid =" . $v['g_id'] . " and go.go_pay_time >0 and m.m_photo is not null group by m_openid) as temp");
			
			
            $g['buy_people'] = $buy_people;
            $g['buy_people_num'] = $buy_people_num;
            if ( !empty($at_id) and $at_id != 'undefined' ) {
                $action = pdo_fetch("select * from ".tablename($this->action)." where weid=".$this->weid." and at_id=".$at_id);
                $g['action'] = $action;
            }
            //获取该用户的当前购物车中的该商品数
            $g['curGoodsNum'] = 0;
            $g['isshowbtn'] = 1;
            if(!empty($openid)){
                $goods_cart = pdo_fetch("select c_count,c_id from ".tablename('gpb_cart')." where openid='".$openid."' and c_is_del =1 and c_status =1 and c_g_id = ".$g['g_id'] );
                if(empty($goods_cart)){
                    $g['isshowbtn'] =1;
                    $g['curGoodsNum'] =0;
                    $g['cart_id'] =0;
                }else{
                    $g['isshowbtn'] =2;
                    $g['curGoodsNum'] =$goods_cart['c_count'];
                    $g['cart_id'] =$goods_cart['c_id'];
                }
            }
            //获取库存和销售数量
//            $stock = pdo_get($this->goods_stock, array('goods_id' => $v['g_id'],'weid'=>$this->weid));//库存和销售量
//            $info[$k]['actual'] = $stock['num'];

            //预计几天后到达
            $g["arrival_time"] = date("m月d日",(time()+($g["g_arrival_time"]*24*60*60)));
            $g['sale_is_over']=0;
            if( $g['g_end_sale_time']<time()){
                $g['sale_is_over']=1;
            }
            $g['taskid']=$taskid;
            $g['roomid']=$roomid;
            $g['timeid']=$timeid;
            $g['oldshow']=$room['oldshow'];
            //读取多规格
//            if($v['g_has_option'] == 1){
//                $info[$k]['spec'] = pdo_getall($this->spec,array('weid'=>$this->weid,'g_id'=>$v['g_id']));
//                $ids = "";
//                foreach ($info[$k]['spec'] as $spec_k=>$spec_v){
//                    $ids = ','.$spec_v['content'];
//                    if(!empty($ids) ){
//                        $info[$k]['spec'][$spec_k]['spec_item']=pdo_fetchall("select * from ".tablename($this->spec_item)." where weid = ".$this->weid." and gsi_id in (".trim($ids,',').")");
//                    }
//                }
//                $info[$k]['option']=pdo_getall($this->goods_option,array('weid'=>$this->weid,'ggo_g_id'=>$v['g_id']));
//            }
            //读取总的出售数量
            $all_real_sale = pdo_get('gpb_goods_stock',array('weid'=>$this->weid,'goods_id'=>$g['g_id']));
            $g['all_real_sale']=isset($all_real_sale['sale_num'])?intval($all_real_sale['sale_num']):0;
			//判断当前商品  是什么时间段
			$task_time_s = pdo_get("gpb_shop_seckill_task_time",array('id'=>$g['timeid'],'taskid'=>$g['taskid']));
			//判断当前是几点了
			$H = date("H",time());
			if($H < $task_time_s['time']){
				$g['task_time_s'] = 1;//大于
			}else if($H == $task_time_s['time']){
				$g['task_time_s'] = 2;
			}else{
				$g['task_time_s'] = 3;
			}
			//获取当前商品的开始时间和结束时间
			$timeid = pdo_get('gpb_shop_seckill_task_time',array('id'=>$g['timeid']),array('time'));
			$in = pdo_fetchall("select time from ".tablename('gpb_shop_seckill_task_time')." where uniacid = ".$_W['uniacid']." and taskid = ".$g['taskid']." and `time` >= ".$timeid['time']." order by `time` asc limit 0,2");
			if(empty($in[1])){
				$g['status_time_goods'] = strtotime(date('Y-m-d '.$in[0]['time'].":00:00",time()));
				$g['end_time_goods'] = strtotime(date('Y-m-d 23:59:59',time()));
			}else{
				$g['status_time_goods'] = strtotime(date('Y-m-d '.$in[0]['time'].":00:00",time()));
				$g['end_time_goods'] = strtotime(date('Y-m-d '.$in[1]['time'].":00:00",time()));
			}
            unset($g);
        }
//var_dump($goods);exit;
//        load()->func('logging');
//        logging_run($goods);
//        $plugin_diypage = p('diypage');
//
//        if ($plugin_diypage) {
//            $diypage = $plugin_diypage->seckillPage($room['diypage']);
//        }
//
//        show_json(1, array('diypage' => $diypage, 'time' => $time, 'goods' => $goods));
        //查询详情页相关秒杀配置
        $goods_info_seckill_icon =  pdo_get('gpb_config',array('key'=>'goods_info_seckill_icon','weid'=>$_W['uniacid']));
        if(isset($goods_info_seckill_icon['value']) && !empty($goods_info_seckill_icon['value'])){
            $goods_info_seckill_icon = tomedia($goods_info_seckill_icon['value']);
        }else{
            $goods_info_seckill_icon = tomedia('/addons/group_buy/public/bg/seckill_goods_info_icon.png');
        }
        $goods_info_seckill_price_bg =  pdo_get('gpb_config',array('key'=>'goods_info_seckill_price_bg','weid'=>$_W['uniacid']));
        if(isset($goods_info_seckill_price_bg['value']) && !empty($goods_info_seckill_price_bg['value'])){
            $goods_info_seckill_price_bg = $goods_info_seckill_price_bg['value'];
        }else{
            $goods_info_seckill_price_bg = '#fde529';
        }
//		$goods[0]['total'];//库存
		//开启redis  有好多个库存 就让好多个人进去  入列
		$config = $_W["config"]["setting"]["redis"];
		$redis = new Redis();
		if ($config["pconnect"]) {
            $connect = $redis->pconnect($config["server"], $config["port"], $config["timeout"]);
        } else {
            $connect = $redis->connect($config["server"], $config["port"], $config["timeout"]);
        }
		//秒杀库存  根据后台设置  好久刷新一次
		//获取时间
		$time = $redis->get('sekill_time');
		if($time+60 > $time || empty($time)){
			$redis->ltrim("goods_".$goods[0]['goodsid'],0,0);
			$redis->ltrim("goods_".$goods[0]['goodsid'],0,0);
			$redis->set('sekill_time',time());
			for($i=0;$i<$goods[0]['total'];$i++){
				$redis->rpush("goods_".$goods[0]['goodsid'],$i+1);
			}
		}
        $this->apireturn('成功',1,array('goods'=>$goods,'time'=>$time,'seckill_img'=>$goods_info_seckill_icon,'bg_color'=>$goods_info_seckill_price_bg));
    }
    //qsec
    public function hookPageSeckill_order(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
//        $code = $this ->nextId();//订单号
        //下单时存地址
        $openid = trim($_GPC['openid']);
		$lat = $_GPC['lat'];//纬度
		$lng = $_GPC['lng'];//经度
        if(empty($openid)){
            $this->apireturn("未授权",1);
        }
        $num = trim($_GPC['num']);
        if(empty($num)){
            $this->apireturn("无购买数量",1);
        }
        $gid = trim($_GPC['gid']);
        if(empty($gid)){
            $this->apireturn("商品信息有误",1);
        }else{
            $where = ' and tg.goodsid='.$gid.' ';
        }
//        $at_id = trim($_GPC['at_id']);
        $ggo_id = trim($_GPC['ggo_id']);
        $ggo_title = trim($_GPC['ggo_title']);
        $taskid = intval($_GPC['taskid']);
        $roomid = intval($_GPC['roomid']);
        $timeid = intval($_GPC['timeid']);
        $task = $this->getTaskInfo($taskid);

        if (empty($task)) {
            $this->apireturn("秒杀已结束，请关注下期~",1);
        }

        $room = $this->getRoomInfo($taskid, $roomid);
        if (empty($room)) {
            $this->apireturn("秒杀会场已关闭，请关注下期~",1);
        }

        $time = false;
        $nexttime = false;
        $times = $this->getTaskTimes($taskid);

        foreach ($times as $key => $ctime) {
            if ($ctime['id'] == $timeid) {
                $time = $ctime;

                if (isset($times[$key + 1])) {
                    $nexttime = $times[$key + 1];
                }

                break;
            }
        }
        //比对是否未开始 zl 7-6
        $now = date("H",time());
        if($now<$time['time']){
            $this->apireturn("活动未开始",1);
        }
        //获取当前时间 并对比
        if($task['oldshow']==0){
            if($now!=$time['time']){
                $this->apireturn("当前时间段无秒杀",1,['noew'=>$now,'time'=>$time,'task'=>$task]);
            }
        }

        if (empty($time)) {
            $this->apireturn("当前时间段无秒杀",1,$time);
        }
        $currenttime = time();
        $starttime = strtotime(date('Y-m-d ' . $time['time'] . ':00:00'));

        if (!empty($nexttime)) {
            $end = $nexttime['time'] - 1;
            $endtime = strtotime(date('Y-m-d ' . $end . ':59:59'));
        }else if (empty($task['overtimes'])) {
            $endtime = strtotime(date('Y-m-d 23:59:59'));
        }else {
            $endtime = strtotime(date('Y-m-d ' . $task['overtimes'] . ':00:00'));
        }

        $time['endtime'] = $endtime;
        $time['starttime'] = $starttime;
        if ($starttime <= $currenttime && $currenttime <= $endtime) {
            $time['status'] = 0;
        } else if ($currenttime < $starttime) {
            $time['status'] = 1;
        } else {
            if ($endtime < $currenttime) {
                $time['status'] = -1;
            }
        }
        $ggo= array();
        if(!empty($ggo_id)){
            $ggo = pdo_fetch('select * from '.tablename('gpb_goods_option').' as ggo left join '.tablename('gpb_shop_seckill_task_goods').' as tg on tg.optionid=ggo.ggo_id where tg.optionid = '.$ggo_id);
        }
        $sql = 'select tg.id,tg.goodsid, tg.price, g.*,tg.commission1,tg.commission2,tg.commission3,tg.total,tg.maxbuy,tg.sale_num from ' . tablename('gpb_shop_seckill_task_goods') . ' tg  
                  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id 
                  where  tg.taskid=:taskid and tg.roomid=:roomid and tg.timeid=:timeid and tg.uniacid=:uniacid '.$where.'  group by tg.goodsid order by tg.displayorder asc ';
        $goods = pdo_fetch($sql, array(':taskid' => $taskid, ':roomid' => $roomid, ':uniacid' => $_W['uniacid'], ':timeid' => $time['id']));
        $seckillinfo = $this->getSeckill($goods['goodsid'], 0, false);

        if ($goods['g_has_option']) {
            $total = 0;
            $count = 0;
            $options = pdo_fetchall('select tg.id,tg.goodsid,tg.optionid,tg.price,g.g_name,g.g_price,g.g_old_price,tg.commission1,tg.commission2,tg.commission3,tg.total,tg.sale_num from ' . tablename('gpb_shop_seckill_task_goods') . '  tg  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id  where tg.timeid=:timeid and tg.taskid=:taskid and tg.timeid=:timeid  and tg.goodsid=:goodsid and  tg.uniacid =:uniacid and tg.optionid =:ggo_id', array(':timeid' => $time['id'], ':taskid' => $taskid, ':goodsid' => $goods['goodsid'], ':uniacid' => $_W['uniacid'],':ggo_id'=>$ggo_id));
            if(empty($options)){
                $this->apireturn("秒杀规格商品有误",1);
            }
            $price = $options[0]['price'];
            $productprice = $options[0]['g_old_price'];

            foreach ($options as $option) {
                $total += $option['total'];

                if ($option['price'] < $price) {
                    $price = $option['price'];
                }

                if ($productprice < $option['g_old_price']) {
                    $productprice = $option['g_old_price'];
                }
            }

            $goods['price'] = $price;
            $goods['g_old_price'] = $productprice;
            $goods['total'] = $total;
//            $goods['count'] = $seckillinfo['count'];
//            $goods['percent'] = 100 < $seckillinfo['percent'] ? 100 : $seckillinfo['percent'];
            $goods['percent'] = intval($goods['sale_num']/($goods['sale_num']+$goods['total'])*100);
            $goods['count'] = $goods['sale_num'];
        }else {
//            $goods['count'] = $seckillinfo['count'];
//            $goods['percent'] = 100 < $seckillinfo['percent'] ? 100 : $seckillinfo['percent'];
            $goods['percent'] = intval($goods['sale_num']/($goods['sale_num']+$goods['total'])*100);
            $goods['count'] = $goods['sale_num'];
        }
        $goods['g_icon']=tomedia($goods['g_icon']);
        $goods['taskid']=$taskid;
        $goods['roomid']=$roomid;
        $goods['timeid']=$timeid;
        $goods['g_old_price'] = $this->price_format($goods['g_old_price']);
        $goods['priceArr'] = explode('.',$goods['price']);
        //查询优惠卷
        $coupon = pdo_fetchcolumn("select count(*) from ".tablename('gpb_user_ticket')." as uc left join ".tablename('gpb_ticket')." as c on c.id = uc.tid where uc.openid='".$openid."' and uc.weid = ".$uniacid." and c.weid=".$uniacid." and use_limit <=".($goods['price']*$num)." and uc.is_use =0 and uc.over_time>".time());//todo ...
        $user =pdo_fetch("select * from ".tablename('gpb_member')." where weid= ".$uniacid." and m_openid = '".$openid."'");
        if($this->check_base64_out_json($user['m_nickname'])){
            $user['m_nickname'] = base64_decode($user['m_nickname']);
        }
        $team =pdo_fetch("select * from ".tablename('gpb_member')." where weid= ".$uniacid." and m_openid = '".$user['m_head_openid']."'");

        if(intval($goods['maxbuy']) > 0 && $goods['maxbuy'] < $num){
            $this->apireturn("超出限购数量",1);
        }
//释放金自定义名字markrting_rebate[value]
        $markrting_rebate = pdo_get('gpb_config',array('key'=>'markrting_rebate','type'=>19));
        $markrting_rebate = isset($markrting_rebate['value'])&&!empty($markrting_rebate['value'])?$markrting_rebate['value']:'释放金';
        //释放金 金额
        $release = pdo_fetch(" select sum(money) as moneys from " . tablename("gpb_recharge_list") . " where openid = '" . $openid . "' and weid = " . $this->weid . " and overdue =1 and `time` = " . strtotime(date("Y-m-d 00:00:00", time())));
        //是否折扣
        $open_member_card_discount_type =0;
        $member_reduce_open = 2;
        $open_member_card_discount_rate = 1;
        $open_member_card = pdo_get('gpb_config',array('key'=>'card_id','type'=>20));
//      if(isset($open_member_card['value']) && $open_member_card['value']==1 ){
//          //开启会员卡
//          $member_card = pdo_get('gpb_member_card',array('id'=>$user['level']));
//          if(!empty($member_card) && $member_card['c_status']){
//              //买过会员卡，并启用了会员折扣
//              $open_member_card_discount = pdo_get('gpb_config',array('key'=>'card_discount','type'=>20));
//              $open_member_card_discount_type = isset($open_member_card_discount['value'])?$open_member_card_discount['value']:2;
//              //查看先算还是后算 2先算折扣 1后算
//              $open_member_card_discount_rate = $member_card['discount']/10;
//              $member_reduce_open = 1;
//          }
//      }
		//获取页面自提 团长送货 和快递
		$delivery_express = pdo_fetch("select value from ".tablename('gpb_config')." where `key` = 'delivery_express' and weid = ".$this->weid);
		$delivery_chief = pdo_fetch("select value from ".tablename('gpb_config')." where `key` = 'delivery_chief' and weid = ".$this->weid);
		$delivery_self = pdo_fetch("select value from ".tablename('gpb_config')." where `key` = 'delivery_self' and weid = ".$this->weid);
		$delivery_express = $delivery_express['value'] ? $delivery_express['value'] : '快递';
		$delivery_chief = $delivery_chief['value'] ? $delivery_chief['value'] : '团长送货';
		$delivery_self = $delivery_self['value'] ? $delivery_self['value'] : '自提';
		//获取排序
		$delivery_express_sort = pdo_fetch("select value from ".tablename('gpb_config')." where `key` = 'delivery_express_sort' and weid = ".$this->weid);
		$delivery_chief_sort = pdo_fetch("select value from ".tablename('gpb_config')." where `key` = 'delivery_chief_sort' and weid = ".$this->weid);
		$delivery_self_sort = pdo_fetch("select value from ".tablename('gpb_config')." where `key` = 'delivery_self_sort' and weid = ".$this->weid);
		$delivery_express_sort = $delivery_express_sort['value'] ? $delivery_express_sort['value'] : '3';
		$delivery_chief_sort = $delivery_chief_sort['value'] ? $delivery_chief_sort['value'] : '2';
		$delivery_self_sort = $delivery_self_sort['value'] ? $delivery_self_sort['value'] : '1';
		$arr = [
			'0'=>array(
				'id'=>1,
				'name'=>$delivery_self,
				'sort'=>$delivery_self_sort,
			),//自提
			'1'=>array(
				'id'=>2,
				'name'=>$delivery_chief,
				'sort'=>$delivery_chief_sort,
			),//团长送货
			'2'=>array(
				'id'=>3,
				'name'=>$delivery_express,
				'sort'=>$delivery_express_sort,
			),//快递
		];
		$mention_id = pdo_fetch("select value from ".tablename('gpb_config')." where `key` = 'mention_id' and weid = ".$this->weid);
		$mention_id = $mention_id['value'] ? $mention_id['value'] : 1;
		if($mention_id == 2){
			unset($arr[0]);
		}
		$is_open_express = pdo_fetch("select value from ".tablename('gpb_config')." where `key` = 'is_open_express' and weid = ".$this->weid);
		$is_open_express = $is_open_express['value'] ? $is_open_express['value'] : 1;
		if($is_open_express == 2){
			unset($arr[2]);
		}
		$member = pdo_get("gpb_member",array('m_openid'=>$openid),array('m_head_openid'));
		$head_member = pdo_get("gpb_member",array('m_openid'=>$member['m_head_openid']),array('m_is_send'));
		if($head_member['m_is_send'] == 1){
			unset($arr[1]);
		}
		if($arr){
			//根据sort进行排序
			$arr = $this->multi_array_sort($arr,'sort');
		}
		
		//获取团长配送配置
		if($team['m_is_send'] == 2){
			$delivery = $this->delivery();
		}else{
			$delivery = false;
		}
        if(!empty($ggo_id) && !empty($ggo)){
            $array =array('data'=>$goods,'coupon'=>$coupon,'user'=>$user,'num'=>$num,'money'=>$num*$goods['price'],'head'=>$team,'ggo'=>$ggo,'release_money'=>floatval($release['moneys']),'markrting_rebate'=>$markrting_rebate, 'member_reduce_open'=>$member_reduce_open, 'open_member_card_discount_rate'=>$open_member_card_discount_rate,'open_member_card_discount_type'=>$open_member_card_discount_type,'mode'=>$arr,'delivery'=>$delivery);
        }else{
            $array = array('data'=>$goods,'coupon'=>$coupon,'user'=>$user,'num'=>$num,'money'=>$num*$goods['price'],'head'=>$team,'release_money'=>floatval($release['moneys']),'markrting_rebate'=>$markrting_rebate, 'member_reduce_open'=>$member_reduce_open, 'open_member_card_discount_rate'=>$open_member_card_discount_rate,'open_member_card_discount_type'=>$open_member_card_discount_type,'mode'=>$arr,'delivery'=>$delivery);
        }
		if($lat && $lng){
		$head_distance = pdo_get("gpb_config",array('key'=>'select_head_distance','weid'=>$this->weid),array('value'));
		if($member['m_head_openid'] && $head_distance['value'] > 0){
				$head_member = pdo_get("gpb_member",array('m_openid'=>$member['m_head_openid']),array('m_head_lng','m_head_lat'));
				//计算两个经纬度之间的距离
				$calculatedDistance = $this->getDistance($lat,$lng,$head_member['m_head_lat'],$head_member['m_head_lng']);
				//判断是否在某一个距离之内
				if($head_distance['value'] < ($calculatedDistance/1000)){
					$calculatedDistance = 2;
				}else{
					$calculatedDistance = 1;
				}
			} else {
				$calculatedDistance = 1;
			}
		}
		$array['calculatedDistance'] = $calculatedDistance;
        $this->apireturn("立即购买商品相关数据获取成功",0,$array);
    }
	private function getDistance($lat1, $lng1, $lat2, $lng2){
        $earthRadius = 6371000;
        $lat1 = floatval((floatval($lat1) * pi()) / 180);
        $lng1 = floatval((floatval($lng1) * pi()) / 180);
        $lat2 = floatval((floatval($lat2) * pi()) / 180);
        $lng2 = floatval((floatval($lng2) * pi()) / 180);
        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;
        return round($calculatedDistance);
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
    /*
     * 秒杀下单支付
     * qop
     */
    public function hookPageSeckill_order_pay($hook){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $code = $this ->nextId();//订单号
        //下单时存地址
        $openid = trim($_GPC['openid']);
        $formidstr = trim($_GPC['str_tmp'],',');//模版消息id
        $formidarr = explode(',',$formidstr);
        if(empty($openid)){
            $this->apireturn("未授权",1);
        }
        $member = pdo_get('gpb_member',array('m_openid'=>$openid));
        $num = trim($_GPC['num']);
        if(empty($num)){
            $this->apireturn("无购买数量",1);
        }
        $gid = trim($_GPC['gid']);
		$file_block = '../addons/group_buy/block/'.base64_encode('文件阻塞').".txt";
		if(file_exists($file_block)){
	    //如果不存在就新增一个  如果存在  就等待2秒在往下执行  这样是避免多个用户同时下单   但是商品库存不足的情况
	    	$myfile = fopen($file_block, "w");
	    	if(!flock($myfile,LOCK_EX|LOCK_NB)){
				$this->apireturn("请等待前面的人购买购买完成",1);
	    	}
		}else{
	    	//新建文件
	    	if(!file_exists('../addons/group_buy/block')){
	     		mkdir ('../addons/group_buy/block',0777,true);
	    	}
	    	$myfile = fopen($file_block, "w");
	    	$txt = "1";
	    	fwrite($myfile, $txt);
			fclose($myfile);
			$myfile = fopen($file_block , 'r');
			
	    	if(!flock($myfile,LOCK_EX|LOCK_NB)){
	    		$this->apireturn("请等待前面的人进行购买",1);
	    	}
		}
        $where ='';
        if(empty($gid)){
        	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("商品信息有误",1);
        }else{
            $where .= ' and tg.goodsid='.$gid.' ';

        }
        $at_id = trim($_GPC['at_id']);
        $ggo_id = trim($_GPC['ggo_id']);
        $optionid = $ggo_id;
//        $ggo= array();
        if(!empty($ggo_id)){
            $where .= ' and tg.optionid='.$optionid.' ';
//            $ggo = pdo_fetchall('select * from '.tablename('gpb_goods_option').' as ggo left join '.tablename('gpb_shop_seckill_task_goods').' as tg on tg.optionid=ggo.ggo_id');
        }
        $ggo_title = trim($_GPC['ggo_title']);
        $taskid = intval($_GPC['taskid']);
        $roomid = intval($_GPC['roomid']);
        $timeid = intval($_GPC['timeid']);
        
        $task = $this->getTaskInfo($taskid);

        if (empty($task)) {
        	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("秒杀已结束，请关注下期~",1);
        }

        $room = $this->getRoomInfo($taskid, $roomid);

        if (empty($room)) {
        	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("秒杀会场已关闭，请关注下期~",1);
        }

        $time = false;
        $nexttime = false;
        $times = $this->getTaskTimes($taskid);
        if(is_array($times)){
            foreach ($times as $key => $ctime) {
                if ($ctime['id'] == $timeid) {
                    $time = $ctime;

                    if (isset($times[$key + 1])) {
                        $nexttime = $times[$key + 1];
                    }

                    break;
                }
            }
        }

        //比对是否未开始
        $now = date("H",time());
        if($now<$time['time']){
        	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("活动未开始",1);
        }

        //获取当前时间 并对比 zl 7-3
        if($task['oldshow']==0){
            if($now!=$time['time']){
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->apireturn("当前时间段无秒杀",1);
            }
        }

        if (empty($time)) {
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("当前时间段无秒杀",1);
        }


        $currenttime = time();
        $starttime = strtotime(date('Y-m-d ' . $time['time'] . ':00:00'));

        if (!empty($nexttime)) {
            $end = $nexttime['time'] - 1;
            $endtime = strtotime(date('Y-m-d ' . $end . ':59:59'));
        }else if (empty($task['overtimes'])) {
            $endtime = strtotime(date('Y-m-d 23:59:59'));
        }else {
            $endtime = strtotime(date('Y-m-d ' . $task['overtimes'] . ':00:00'));
        }

        $time['endtime'] = $endtime;
        $time['starttime'] = $starttime;
        if ($starttime <= $currenttime && $currenttime <= $endtime) {
            $time['status'] = 0;
        } else if ($currenttime < $starttime) {
            $time['status'] = 1;
        } else {
            if ($endtime < $currenttime) {
                $time['status'] = -1;
            }
        }
//        if(!empty($ggo_id)){
//            $ggo = pdo_get($this->goods_option,array('ggo_id'=>$ggo_id,'weid'=>$this->weid));
//        }
        $sql = 'select tg.id,tg.goodsid, tg.price, g.*,tg.commission1,tg.commission2,tg.commission3,tg.total,tg.maxbuy,tg.sale_num from ' . tablename('gpb_shop_seckill_task_goods') . ' as tg  
                  left join ' . tablename('gpb_goods') . ' as g on tg.goodsid = g.g_id 
                  where  tg.taskid=:taskid and tg.roomid=:roomid and tg.timeid=:timeid and tg.uniacid=:uniacid '.$where.'  group by tg.goodsid order by tg.displayorder asc ';

        $goods = pdo_fetch($sql, array(':taskid' => $taskid, ':roomid' => $roomid, ':uniacid' => $_W['uniacid'], ':timeid' => $time['id']));
        $seckillinfo = $this->getSeckill($goods['goodsid'], 0, false);
//var_dump($goods);
//exit;
//        if ($goods['g_has_option']) {
//            $total = 0;
//            $count = 0;
//            $options = pdo_fetchall('select tg.id,tg.goodsid,tg.optionid,tg.price,g.g_name,g.g_price,g.g_old_price,tg.commission1,tg.commission2,tg.commission3,tg.total,tg.sale_num from ' . tablename('gpb_shop_seckill_task_goods') . '  tg  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id  where tg.timeid=:timeid and tg.taskid=:taskid and tg.timeid=:timeid  and tg.goodsid=:goodsid and  tg.uniacid =:uniacid ', array(':timeid' => $time['id'], ':taskid' => $taskid, ':goodsid' => $goods['goodsid'], ':uniacid' => $_W['uniacid']));
//            $price_op = $options[0]['price'];
//            $productprice = $options[0]['g_old_price'];
//
//            foreach ($options as $option) {
//                $total += $option['total'];
//
//                if ($option['price'] < $price_op) {
//                    $price_op = $option['price'];
//                }
//
//                if ($productprice < $option['g_old_price']) {
//                    $productprice = $option['g_old_price'];
//                }
//            }
//
//            $goods['price'] = $price_op;
//            $goods['g_old_price'] = $productprice;
//            $goods['total'] = $total;
//            //$goods['count'] = $seckillinfo['count'];
//            //$goods['percent'] = 100 < $seckillinfo['percent'] ? 100 : $seckillinfo['percent'];
//        }else {
//            //$goods['count'] = $seckillinfo['count'];
//            //$goods['percent'] = 100 < $seckillinfo['percent'] ? 100 : $seckillinfo['percent'];
//        }

        $goods['g_old_price'] = $this->price_format($goods['g_old_price']);

        $goods['price'] = $this->price_format($goods['price']);
        //查询优惠卷
        $coupon = pdo_fetchcolumn("select count(*) from ".tablename('gpb_user_ticket')." as uc left join ".tablename('gpb_ticket')." as c on c.id = uc.tid where uc.openid='".$openid."' and uc.weid = ".$uniacid." and c.weid=".$uniacid." and use_limit <=".($goods['price']*$num)." and uc.is_use =0 and uc.over_time>".time());//todo ...
        //$user =pdo_fetch("select * from ".tablename('gpb_member')." where weid= ".$uniacid." and m_openid = '".$openid."'");
        //$team =pdo_fetch("select * from ".tablename('gpb_member')." where weid= ".$uniacid." and m_openid = '".$user['m_head_openid']."'");
//        if($goods['maxbuy'] < $num){
//            $this->apireturn("超出限购数量",1);
//        }
//        秒杀redis有毒
//        $this->checkBuy($seckillinfo,$goods['g_name'],'');
        if( $goods['total']<=0 || ($goods['total']-intval($num))<0 ){
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("已抢完，请刷新后再试",1);
        }
        //已下单过的
        if(!empty($goods['maxbuy']) && $goods['maxbuy'] >0){
            $aleady_order_num= pdo_fetch("select sum(oss_g_num) as `sum` from ".tablename('gpb_order_snapshot')." as sn left join ".tablename('gpb_order')." as o on o.go_code = sn.oss_go_code  where sn.oss_gid=".$goods['g_id']." and oss_buy_openid = '".$openid."' and  (o.go_status !=110 and o.go_status !=120 ) and oss_is_seckill=1");
            if((intval($num)+intval($aleady_order_num['sum'])) > $goods['maxbuy']){
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->apireturn($goods['g_name']."已超出秒杀限购数量",array('sql'=>"select sum(oss_g_num) as `sum` from ".tablename('gpb_order_snapshot')." as sn left join ".tablename('gpb_order')." as o on o.go_code = sn.oss_go_code  where sn.oss_gid=".$goods['g_id']." and oss_buy_openid = '".$openid."' and  (o.go_status !=110 or o.go_status !=120 ) and oss_is_seckill=1",'x'=>$goods['maxbuy'],'s'=>$num));
            }
        }
        //历史限购
        if(!empty($goods['g_history_limit_num']) && $goods['g_history_limit_num'] !=0  ){
            $aleady_buy_num_history = pdo_fetch("select sum(oss_g_num) as `sum` from ".tablename('gpb_order_snapshot')." as sn left join ".tablename('gpb_order')." as o on o.go_code = sn.oss_go_code  where sn.oss_gid=".$goods['g_id']." and oss_buy_openid = '".$openid."'  and o.go_pay_time >= 0 ");
            if((intval($num)+intval($aleady_buy_num_history['sum'])) > $goods['g_history_limit_num']){
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->apireturn($goods['g_name']."已超出历史限购数量",1);
            }
        }


        $name = trim($_GPC['name']);
        if(empty($name)){
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("请传入收货人姓名",1);
        }
        $phone = trim($_GPC['phone']);
        if(empty($phone)){
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("请传入收货人电话",1);
        }
        $adr = trim($_GPC['adr']);//详细收货地址
        if(!empty($name) ){
            $ad_data = [
                'ra_name'=>$name,
                'ra_phone'=>$phone,
                'ra_info'=>$adr,
                'ra_is_default'=>1,
                'weid'=>$_W['uniacid']
            ];
            $adr_num =  pdo_fetchcolumn("select count(*) from ".tablename('gpb_receiving_address')." where openid = '".$openid."' and weid=".$this->weid);
            if($adr_num>1 || $adr_num<=0){
                pdo_delete('gpb_receiving_address',array('openid'=>$openid));
                $ad_data['openid']= $openid;
                $res  = pdo_insert('gpb_receiving_address',$ad_data);
                $address = pdo_insertid();
            }else{
                pdo_update('gpb_receiving_address',$ad_data,['openid'=>$openid]);
                $address = pdo_get('gpb_receiving_address',array('openid'=>$openid,'weid'=>$this->weid));
                $address = $address['ra_id'];
            }

        }
        /******收货地址完******/
        $head_openid = trim($_GPC['head_openid']);//团长
        if( empty($head_openid) ){
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("未选择团长",1);
        }
        $vg = pdo_get('gpb_village',['openid'=>$head_openid]);
        $vid=$vg['vg_id'];
        $vg_name = $vg['vg_name'];
        if( !isset($vid) || $vid == "" || $vid ==null   ){
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("请选择小区",1);
        }
        $comment = trim($_GPC['comment']);//订单备注
        $coupon  = trim($_GPC['coupon']);//todo优惠卷关联
        if(!empty($coupon)){
            $coupon_info_arr = pdo_get('gpb_user_ticket',['id'=>$coupon,'weid'=>$uniacid],['tid']);//todo 优惠卷的验证还要加强
            $coupon_info = !empty($coupon_info_arr['tid'])?$coupon_info_arr['tid']:0;//todo 优惠卷的验证还要加强
            $coupon_price_arr = pdo_get('gpb_ticket',['id'=>$coupon_info,'weid'=>$uniacid],['cut_price']);
            $coupon_price = !empty($coupon_price_arr['cut_price'])?$coupon_price_arr['cut_price']:0;//优惠价格
        }else{
            $coupon_price= 0;
        }
        $pay_type = !empty($_GPC['send_type'])?trim($_GPC['send_type']):1;//支付方式 1 微信支付
        $send_type = !empty($_GPC['is_send'])?trim($_GPC['is_send']):1;//配送方式
        $seed_pay = !empty($_GPC['send_price'])?trim($_GPC['send_price']):0;//邮费、配送费
        $sure_code = $this ->nextId();//订单核销号写这

        pdo_begin();//开启事务
        $data = [
            'go_code'=>$code,
            'openid'=>$openid,
//            'go_gid'=>$v //不是1对1关系了  不要这个
            'go_adress_id'=>$address,
            'go_vid'=>$vid,
//            'go_at_id'=>$action[$k]['gcg_at_id']  //不是1对1关系了  不要这个
            'go_fdc_id'=>$coupon,
            'go_team_openid'=>$head_openid,
            'go_status'=>10,
            'go_add_time'=>time(),
//            'go_num'=>empty($num[$k])?1:$num[$k] //不是1对1关系了  不要这个
//            'go_old_price'=>$old_price,
//            'go_price'=>$price,
            'go_fdc_price'=>$coupon_price,
//            'go_real_price'=>$real_price,
            'go_sure_code'=>$sure_code,
            'go_pay_type'=>$pay_type,
            'go_buy_msg'=>$comment,
            'go_send_type'=>$send_type,
            'weid'=>$_W['uniacid'],
            'go_send_pay'=>$seed_pay,
            'go_order_formid'=>isset($formidarr[0])?$formidarr[0]:'',
            'go_send_formid'=>isset($formidarr[1])?$formidarr[1]:'',
            'go_headget_formid'=>isset($formidarr[2])?$formidarr[2]:'',
            'delivery_time'=>$_GPC['delivery_time'],
        ];
        $res = pdo_insert('gpb_order',$data);
        $order_id = pdo_insertid();

        //var_dump();
        if (empty($res)) {
            pdo_rollback();//失败回滚
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("订单添加失败",1);
        }
        $old_price=0;
        $price =0;
//        $info = pdo_fetch("select g_id,g_old_price,g_price,g_name,g_icon,g_brief,g_commission,g_is_full_reduce from ".tablename($this->goods)." as g where weid=".$this->weid." and g_id = ".$gid." and (g.`type`<>2 or g.`type` is null) and g_is_del = 1");//单个
        if(intval($ggo_id)>0){
            $goods_option = pdo_get('gpb_goods_option',array('ggo_id'=>$ggo_id));
            $old_price = $goods_option['ggo_old_price']; //原价
            $price =$goods['price']; //秒杀价
            $total_prcie = $price*$num;//单商品总价
        }else{
            $old_price = $goods['g_old_price']; //原价
            $price = $goods['price']; //秒杀价
            $total_prcie = $price*$num;//单商品总价
        }
        // $sure_code = $idWork ->nextId();//商品核销号写这

        //开启快照
//        $action_info = pdo_get($this->action,['at_id'=>$at_id],['at_name']);//活动数据
        $head_info = pdo_get('gpb_member',['m_openid'=>$head_openid,'weid'=>$uniacid]);//团长数据
        $buy_info = pdo_get('gpb_member',['m_openid'=>$openid,'weid'=>$uniacid]);//买家数据
        $address_info = pdo_get('gpb_receiving_address',['ra_id'=>$address,'weid'=>$uniacid],['ra_name','ra_phone','ra_info']);//地址数据
        if(empty($address_info['ra_info']) || $address_info['ra_info']=='undefined'){
            $address_info['ra_info'] = $head_info['m_head_address'].$head_info['m_head_house_address'];
        }
        //计算佣金
        $commission_num = 0;
        $commission_money = 0;
        if(!empty($goods['g_commission']) && $goods['g_commission']>0){
            $commission_num = floatval($goods['g_commission']);
        }else{
            $commission_num = floatval($head_info['m_commission']);
        }

        //获取是否按订单数计算
        $all_order_commission_open = pdo_get('gpb_config',array('key'=>'all_order_commission_open','weid'=>$uniacid));
        $all_order_commission_same= pdo_get('gpb_config',array('key'=>'all_order_commission_same','weid'=>$uniacid));
        if(isset($all_order_commission_open['value']) && $all_order_commission_open['value']==1 ){
            if(isset($all_order_commission_same['value'])){
                $commission_money = sprintf("%.2f",$all_order_commission_same['value']);
            }else{
                $commission_money =0;
            }
            $commission_num = 0;
        }elseif($goods['commission1']>0){
            //秒杀单独分佣
            $commission_money = sprintf("%.2f",$goods['commission1']*$num);
            $commission_num = 0;
        }else{
            $commission_money = sprintf("%.2f",$commission_num*$total_prcie/100);
        }
        $shot_data = [
//                'oss_go_id'=>$last_add_id,
            'oss_go_code'=>$code,
            'oss_gid'=>$gid,
            'oss_g_price'=>$price,
            'oss_g_old_price'=>$old_price,
            'oss_g_num'=>$num,
            'oss_g_name'=>$goods['g_name'],
            'oss_g_icon'=>$goods['g_icon'],
            'oss_g_brief'=>$goods['g_brief'],
            'oss_ac_id'=>$at_id,
//            'oss_ac_name'=>$action_info['at_name'],
            'oss_v_id'=>$vid,
            'oss_v_name'=>$vg_name,
            'oss_head_openid'=>$head_openid,
            'oss_head_name'=>$head_info['m_nickname'],
            'oss_head_phone'=>$head_info['m_phone'],
            'oss_buy_openid'=>$openid,
            'oss_buy_name'=>$buy_info['m_nickname'],
            'oss_buy_phone'=>$buy_info['m_phone'],
            'oss_address_id'=>$address,
            'oss_address'=>$address_info['ra_info'],
            'oss_address_name'=>$address_info['ra_name'],
            'oss_address_phone'=>$address_info['ra_phone'],
            'oss_total_price'=>$total_prcie,
            'oss_ggo_id'=>$ggo_id,
            'oss_ggo_title'=>$ggo_title,
            'oss_commission_num'=>$commission_num,
            'oss_commission'=>$commission_money,
//            'oss_is_full_reduce'=>$srue_open_full_reduce,
            'oss_is_seckill'=>1,
            'oss_seckill_taskid'=>$taskid,
            'oss_seckill_roomid'=>$roomid,
            'oss_seckill_time'=>$time['time'],
            'oss_seckill_task'=>$task['title'],
            'oss_seckill_room'=>$room['title'],
            'oss_seckill_timeid'=>$timeid,
        ];
        $res = pdo_insert('gpb_order_snapshot',$shot_data);
        if (empty($res)) {
            pdo_rollback();//失败回滚
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->apireturn("订单添加失败",1);
        }else {
            $go_real_prcie = $total_prcie - $coupon_price + $seed_pay;//最终售价
            $last_go_data = array();
            //是否有开启会员卡设置了
            //默认会员折扣0元
            $member_reduce_price = 0;
            $open_member_card_discount_rate = 1;
            $open_member_card = pdo_get('gpb_config', array('key' => 'card_id', 'type' => 20));

//          if (isset($open_member_card['value']) && $open_member_card['value'] == 1) {
//              //开启会员卡
//              $member_card = pdo_get('gpb_member_card', array('id' => $buy_info['level']));
//              if (!empty($member_card) && $member_card['c_status']) {
//                  //买过会员卡，并启用了会员折扣
//                  $open_member_card_discount = pdo_get('gpb_config', array('key' => 'card_discount', 'type' => 20));
//                  $open_member_card_discount_type = isset($open_member_card_discount['value']) ? $open_member_card_discount['value'] : 2;
//                  //查看先算还是后算 2先算折扣 1后算
//                  $open_member_card_discount_rate = $member_card['discount'] / 10;
//
//              }
//          }
            if (empty($open_member_card_discount_type)) {
                //不算折扣
                $go_real_prcie = $total_prcie - $coupon_price + $seed_pay;//最终售价

            } elseif ($open_member_card_discount_type == 2) {
                //先算折扣
                $member_reduce_price = $total_prcie * (1 - $open_member_card_discount_rate);//折扣优惠金额
                $go_real_prcie = ($total_prcie * $open_member_card_discount_rate) - $coupon_price + $seed_pay;//最终售价

            } elseif ($open_member_card_discount_type == 1) {
//            后算折扣
                $go_real_prcie = $total_prcie - $coupon_price;//最终售价
                $member_reduce_price = $go_real_prcie * (1 - $open_member_card_discount_rate);//折扣优惠金额
                $go_real_prcie = $go_real_prcie * $open_member_card_discount_rate + $seed_pay;

            } else {
                pdo_rollback();
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->apireturn("折扣计算有误", 1);

//                $this->result("1", "折扣计算有误");
            }
            //当最终售价低于0时
            if ($go_real_prcie <= 0) {
                $go_real_prcie = 0;
            }
            //当设置小区限额后
            if ($head_info['m_is_have_limit_pay'] == 2) {
                if ($head_info['m_limit_pay'] > ($go_real_prcie - $seed_pay)) {
                    pdo_rollback();//失败回滚
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                    $this->apireturn("订单满" . $head_info['m_limit_pay'] . "元后才能下单", 1);
                }
                if (!empty($order_low_price) && isset($order_low_price['value']) && $order_low_price['value'] > ($go_real_prcie - $seed_pay)) {
                    pdo_rollback();//失败回滚
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                    $this->apireturn("订单满" . $order_low_price['value'] . "元后才能下单", 1);
                }
            } else {
                //当开启订单限额后
                $order_low_price_open = pdo_get('gpb_config', array('key' => 'order_low_price_open', 'weid' => $uniacid));
                if (!empty($order_low_price_open) && isset($order_low_price_open['value']) && $order_low_price_open['value'] == 1) {
                    $order_low_price = pdo_get('gpb_config', array('key' => 'order_low_price', 'weid' => $uniacid));
                    if (!empty($order_low_price) && isset($order_low_price['value']) && $order_low_price['value'] > ($go_real_prcie - $seed_pay)) {
                        pdo_rollback();//失败回滚
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                        $this->apireturn("订单满" . $order_low_price['value'] . "元后才能下单", 1);
                    }
                }
            }
            //最终售价已定，判断用什么支付
            //当最终售价低于0时
            if ($go_real_prcie <= 0) {
                $go_real_prcie = 0;
            }
            $real_price = $go_real_prcie;//记录最终售价
            $go_release_price = 0;//返利用于支付
            $go_balance_price = 0;//余额用于支付
            $go_wx_price = 0;//微信用于支付
            $spare_release_today = 0;//剩余返利
            $spare_balance_today = 0;//剩余余额
            /*-----------------*/
            //获取当前余额
            $now_member_money_balance = empty($member['m_money_balance']) ? 0 : $member['m_money_balance'];
            //获取当前每日反的奖金
            $release_today = pdo_fetch(" select sum(money) as moneys from " . tablename("gpb_recharge_list") . " where  openid = '" . $openid . "' and weid = " . $this->weid . ' and `time`=' . strtotime(date('Y-m-d 00:00:00',time()))." and overdue = 1");
            $release_today = $release_today['moneys'] ? $release_today['moneys'] : 0;
            //首先扣返利
            if (($go_real_prcie - $release_today) > 0) {
                //返利扣完
                $go_real_prcie = $go_real_prcie - $release_today;
                //记录返利用于支付
                $go_release_price = $release_today;
                //然后扣余额
                if (($go_real_prcie - $now_member_money_balance) > 0) {
                    //余额扣完
                    $go_real_prcie = $go_real_prcie - $now_member_money_balance;
                    //记录余额用于支付
                    $go_balance_price = $now_member_money_balance;
//					$arr = ['go_real_prcie'=>$go_real_prcie,'release_today'=>$release_today,'now_member_money_balance'=>$now_member_money_balance];
//					pdo_insert("gpb_config",array('value'=>serialize($arr)));
                } else {
                    //记录剩余余额
                    $spare_balance_today = $now_member_money_balance - $go_real_prcie;
                    //记录余额用于支付
                    $go_balance_price = $go_real_prcie;
                    $go_real_prcie = 0;
                }
            } else {
                //返利未扣完
                $spare_release_today = $release_today - $go_real_prcie;
                //记录返利用于支付
                $go_release_price = $go_real_prcie;
                $go_real_prcie = 0;
            }

            $go_wx_price = $go_real_prcie;//最终需要微信支付的钱
            /*--------------------*/


            $last_go_data = array(
                'go_real_price' => $real_price,
                'go_all_price' => $price,
                'go_all_old_price' => $old_price,
                'go_release_price' => $go_release_price,
                'go_balance_price' => $go_balance_price,
                'go_wx_price' => $go_wx_price,
                'go_full_reduce_price' => 0,//秒杀不满减
                'go_member_card_reduce' => $member_reduce_price,
            );
            //至少微信支付
            $last_go_data['go_pay_type'] = 1;
            if ($go_real_prcie > 0) {
                if ($go_release_price > 0 || $go_balance_price > 0) {
                    //有余额参与就是  余额和微信支付一起
                    $last_go_data['go_pay_type'] = 3;
                }
            } else {
                //余额支付
                $last_go_data['go_pay_type'] = 2;
//            $last_go_data = array(
//                'go_real_price'=>$go_real_prcie,
//                'go_all_price'=>$total_prcie,
//                'go_all_old_price'=>$old_price
//            );

            }
			$res = pdo_update('gpb_order', $last_go_data, ['go_id' => $order_id, 'weid' => $this->weid]);

            //$res = pdo_insert($this->order,$data);
            //pdo_debug();
            //存入订单流水
            $data_stream = array(
                'gos_code' => date('Ymd', time()) . $this->nextId(),//流水号
                'gos_go_code' => $code,//订单号
                'gos_stream_type' => 1,
                'gos_type' => 1,
                'gos_commet' => '秒杀立即购买下单支付',
                'gos_owner' => '平台',
                'gos_order_money' => $real_price,
                'gos_payer' => $member['m_nickname'],
                'gos_real_money' => 0,
                'gos_status' => 1,
                'gos_add_time' => time(),
                'weid' => $_W['uniacid'],
                'gos_pay_type' => $last_go_data['go_pay_type'],
                'gos_team' => $head_info['m_nickname'],
                'gos_payer_openid' => $openid,
                'gos_team_openid' => $head_openid,
                'gos_wx_pay' => $go_wx_price,
                'gos_release_pay' => $go_release_price,
                'gos_balance_pay' => $go_balance_price
            );
            pdo_insert('gpb_order_stream', $data_stream);
            $stream_id = pdo_insertid('gpb_order_stream');
            if (!empty($res)) {
                //$go_release_price 返利金
                if ($go_release_price > 0) {
                    //获取当前每日反的奖金
                    $release_today_list = pdo_fetchall(" select * from " . tablename("gpb_recharge_list") . " where  openid = '" . $openid . "' and weid = " . $this->weid . " and `time`=" . strtotime(date('Ymd'))." and overdue = 1");
                    foreach ($release_today_list as $release_today_list_v) {
                        if ($go_release_price - $release_today_list_v['money'] >= 0) {
                            //还没扣完
                            $go_release_price = $go_release_price - $release_today_list_v['money'];
                            pdo_update('gpb_recharge_list', array('list_type' => 4, 'money' => 0), array('id' => $release_today_list_v['id']));
                            $recharge_log_data = array(
                                'uid' => $member['m_id'],
                                'openid' => $member['m_openid'],
                                'info' => '秒杀购买扣除返利金' . $release_today_list_v['money'] . '元',
                                'type' => 2,
                                'status' => 1,
                                'create_time' => time(),
                                'weid' => $this->weid,
                                'money' => $release_today_list_v['money'],
                                'l_type' => 2,
                                'st' => 2,
                                'remarks' => '订单号：' . $code . '，返利金id：' . $release_today_list_v['id'],
                                'pay_f' => 3
                            );

                        } else {
                            //扣完
                            pdo_update('gpb_recharge_list', array( 'money' => $release_today_list_v['money'] - $go_release_price), array('id' => $release_today_list_v['id']));
                            $recharge_log_data = array(
                                'uid' => $member['m_id'],
                                'openid' => $member['m_openid'],
                                'info' => '秒杀购买扣除返利金' . $go_release_price . '元',
                                'type' => 2,
                                'status' => 1,
                                'create_time' => time(),
                                'weid' => $this->weid,
                                'money' => $go_release_price,
                                'l_type' => 2,
                                'st' => 2,
                                'remarks' => '订单号：' . $code . '，返利金id：' . $release_today_list_v['id'],
                                'pay_f' => 3
                            );
                            $go_release_price = $go_release_price - $release_today_list_v['money'];

                        }
                        if (!empty($recharge_log_data)) {
                            pdo_insert('gpb_recharge_log', $recharge_log_data);
                        }
                        if ($go_release_price <= 0) {
                            break;
                        }
                    }
                }
                //余额
                if ($go_balance_price > 0) {
                    //扣余额
                    $res_balance = pdo_update('gpb_member', array('m_money_balance' => $buy_info['m_money_balance'] - $go_balance_price), array('m_id' => $buy_info['m_id']));
                    if(!empty($res_balance)){
                        $recharge_balance_log_data = array(
                            'uid'=>$member['m_id'],
                            'openid'=>$member['m_openid'],
                            'info'=>'秒杀购买扣除余额'.$go_balance_price.'元',
                            'type'=>2,
                            'status'=>1,
                            'create_time'=>time(),
                            'weid'=>$this->weid,
                            'money'=>$go_balance_price,
                            'l_type'=>2,
                            'st'=>2,
                            'remarks'=>'订单号：'.$code,
                            'pay_f'=>3
                        );
                        pdo_insert('gpb_recharge_log',$recharge_balance_log_data);
                    }
                }
                $res = array();
                if ($last_go_data['go_pay_type'] == 1 || $last_go_data['go_pay_type'] == 3) {
                    $total_fee = 0;

                    $total_fee = sprintf("%.2f",$go_wx_price);
                    $res = $this->pays($total_fee, $openid, $code, $order_id, '');
                    if ($res['status'] == 0) {
                        $res['gid'] = $code;
                        //秒杀立即减少库存 2
                        $res['pay_type'] = $last_go_data['go_pay_type'];
                        pdo_update('gpb_order', array('prepay_id' => $res['packages'],'go_reduce_stock'=>2), array('go_id' => $order_id, 'type' => 1, 'weid' => $_W['uniacid']));


                    } else {
                        pdo_rollback();
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                        $this->apireturn("调取支付失败", 1);
//                        $this->result("1", "调取支付失败", $res);
                        exit;
                    }
                } elseif ($last_go_data['go_pay_type'] == 2) {

                    $res['gid'] = $code;
                    $res['id'] = $order_id;
                    //秒杀立即减少库存 2
                    $res['pay_type'] = $last_go_data['go_pay_type'];
                    pdo_update('gpb_order', array('go_reduce_stock'=>2,'prepay_id' => $res['packages'], 'go_status' => 20,'go_pay_time'=>time()), array('go_id' => $order_id, 'type' => 1, 'weid' => $_W['uniacid']));


                    //查看是否开启自动订单打印
                    $order_print_auto_open= pdo_get('gpb_config',array('key'=>'order_print_auto_open','weid'=>$_W['uniacid']));
                    $order_print_auto_open_val = isset($order_print_auto_open['value'])?$order_print_auto_open['value']:2;
                    $order_print_auto_num= pdo_get('gpb_config',array('key'=>'order_print_auto_num','weid'=>$_W['uniacid']));
                    $order_print_auto_num_val = isset($order_print_auto_num['value'])?$order_print_auto_num['value']:1;
                    if($order_print_auto_open_val ==1 ){
                        //开启
                        //查询打印机配置
                        $print_set = pdo_get('gpb_config',array('key'=>'print_set','weid'=>$_W['uniacid']));
                        $config = unserialize($print_set['value']);
                        if(empty($config) || count($config)<=0){
//                                echo json_encode(array('status'=>1,'msg'=>'请在配置中设置打印机'));exit;
                        }else{
                            //调用打印机类
                            $print_class = new print_sn();
                            //查询打印机状态
                            $res_select = $print_class->select_print($config['print_sn']);
                            if( $res_select["ret"]!==0 || $res_select["data"]=='离线。'){
//                                    echo json_encode(array('status'=>1,'msg'=>$res_select['msg'].','.$res_select['data']));exit;
                            }else{
                                $goods_info = array();
                                $order = pdo_fetchall("select * from ".tablename('gpb_order')." as o left join ".tablename('gpb_order_snapshot')." as sn on sn.oss_go_code = o.go_code left join ".tablename('gpb_village')." as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=".$code." and o.weid=".$_W['uniacid']);
                                foreach($order as $k => $v_order){
                                    $goods_info[$k]['title'] = $v_order['oss_g_name'];
                                    $goods_info[$k]['price'] = $v_order['oss_g_price'];
                                    $goods_info[$k]['num'] = $v_order['oss_g_num'];
                                    $goods_info[$k]['spec'] = trim($v_order['oss_ggo_title']);
                                }
                                $adr = $order[0]['vg_address'];
                                if(!empty($order[0]['oss_address']) && $order[0]['oss_address'] != 'undefined'){
                                    $adr = $order[0]['oss_address'];
                                }
                                $lead_info = array(
                                    'name'=>  $order[0]['oss_head_name'],
                                    'phone'=> $order[0]['oss_head_phone'],
                                );
                                $reduce_price = 0;
                                if($order[0]['go_fdc_price']>0){
                                    $reduce_price +=$order[0]['go_fdc_price'];
                                }
                                if($order[0]['go_full_reduce_price']>0){
                                    $reduce_price +=$order[0]['go_full_reduce_price'];
                                }
                                $send_price = 0;
                                if($order[0]['go_send_pay']>0){
                                    $send_price +=$order[0]['go_send_pay'];
                                }
                                $ress = $print_class->print_info($config['print_sn'],$code,$order[0]['oss_v_name'],$goods_info,$adr,$order[0]['oss_address_phone'],$order[0]['oss_address_name'],$order[0]['go_real_price'],$lead_info,$order[0]['go_comment']='',$qrcode='',$order[0]['go_add_time'],'','在线支付',$order_print_auto_num_val,$reduce_price,$send_price);
                            }

                        }

                    }
                    $info = pdo_get('gpb_order',array('go_id'=>$order_id));

                    //发送模板消息
                    $sms = new Sms();
                    $sms->weid=$_W['uniacid'];
                    $this->Token();
//                        send_out($key,$data,$access_token,$openid,$page,$form_id,$weid,$item);
                    $sms_array = array('1'=>$info['go_code'],'2'=>"￥".$info['go_real_price'],'3'=>'支付成功','4'=>date('Y-m-d H:i',$info['go_add_time']),'5'=>'如有疑问，请拨打客户热线:');
                    $form_id = empty($info['prepay_id'])?$info['go_order_formid']:$info['prepay_id'];
                    $dass = $sms->send_out('sms_template',$sms_array,$_W['account']['access_tokne'],$openid,'pages/order/orderDetail?id='.$info['go_id'],$form_id,$sms->weid,'AT0229');

                    //新增订阅消息 周龙 2020-02-27
                    $submsg = new \SubMsg();
                    $sub_arr = [
                        mb_substr($info['go_code'],0,20),
                        '￥'.$info['go_real_price'],
                        '支付成功',
                        date('Y-m-d H:i',$info['go_add_time']),
                        '如有疑问，请拨打客户热线'
                    ];
                    $submsg->sendmsg("pay_suc",$info['openid'],$sub_arr,'pages/order/orderDetail?id='.$info['go_id']);


                    $log_content = date('Y-m-d H:i:s').'，订单余额立即购买支付成功模版消息日志（buyIntimeOrder）'.PHP_EOL;
                    if(is_array($dass)){
                        foreach ($dass as $dass_k=>$dass_v){
                            $log_content .='key:'.$dass_k.',value:'.$dass_v.PHP_EOL;
                        }
                    }
                    $log_content .= json_encode(array('sms_template',$sms_array,$_W['account']['access_tokne'],$openid,'pages/order/orderDetail?id='.$info['go_id'],$form_id,$sms->weid,'AT0229'),JSON_UNESCAPED_UNICODE);
                    $log_content .= '----------end------------'.PHP_EOL;
                    $this->txt_logging_fun('sms_AT0229_log.txt',$log_content);
                    //短信通知管理员
                    //$account = pdo_get($this->member,array('m_openid'=>$openid,'weid'=>$this->weid));
                    $type = pdo_get('gpb_config',array('weid'=>$_W['uniacid'],'key'=>'sms_type'));
                    $set = pdo_get('gpb_config',array('weid'=>$_W['uniacid'],'key'=>'sms_pay'));
                    $phone = pdo_get('gpb_config',array('weid'=>$_W['uniacid'],'key'=>'sms_admin'));
                    $data = pdo_get('gpb_config',array('weid'=>$_W['uniacid'],'key'=>'sms_data'));
                    $phone = unserialize($phone['value']);
                    $data = unserialize($data['value']);
                    $set = unserialize($set['value']);
                    $sms = new Sms();
                    $weid = $sms->weid = $_W['uniacid'];
                    if($type['value'] == 1 ){
                        //阿里云
                        if(is_array($phone)){
                            foreach ( $phone as $k => $v){
                                $ress =$sms->alicloud($v,array('sms_var'=>trim($set['content']['value']),'sms_key'=>trim($data['key']['value']),'sms_serect'=>trim($data['serect']['value']),'sms_sign'=>trim($data['sign']['value']),'sms_id'=>trim($set['id']['value'])),array('0'=>$member['m_phone'],'1'=>$code));
                            }
                        }
                    }elseif($type['value']==2){
                        //创瑞 todo 不一定成
                        if(is_array($phone)) {
                            foreach ($phone as $k => $v) {
                                $ress = $sms->chui($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), $code);
                            }
                        }
                    }

                    //因为是余额支付，流水生成后就要成功
                    $data_stream_sec = array(
                        'gos_real_money'=>$real_price,
                        'gos_sure_pay_time'=>time(),
                        'gos_commet'=>'秒杀立即购买下单支付,余额支付立即确认',
                        'gos_pay_type'=>$last_go_data['go_pay_type'],
                        'gos_status'=>2,
                        'gos_balance_pay'=>$last_go_data['go_balance_price'],
                        'gos_release_pay'=>$last_go_data['go_release_price'],
                        'gos_wx_pay'=>$last_go_data['go_wx_price'],
                    );
                    pdo_update('gpb_order_stream',$data_stream_sec,array('gos_id'=>$stream_id));
                    $this ->pay_success_send_official_account_msg($info['go_code']);
                }
                //查询剩余购物车数量
                $count_sql = "select sum(c_count) from " . tablename('gpb_cart') . " where openid = '" . $openid . "' and weid=".$_W['uniacid']."  and c_status=1 and c_is_del = 1";
                $res['numbers'] = pdo_fetchcolumn($count_sql);
                $this->setSeckill($seckillinfo, $goods, $openid, $order_id, 0, time());
                //更新优惠卷使用
                pdo_update('gpb_user_ticket', array('update_time' => time(), 'is_use' => 1), array('id' => $coupon, 'weid' => $_W['uniacid']));
                //查询库存
                $stcok = pdo_get('gpb_goods_stock', array('goods_id' => $gid));//获取库存
                $num_stcok = $stcok['num'] - $num;
                $num_stcok = $num_stcok <= 0 ? 0 : $num_stcok;
                $is = $stcok['sale_num'] + $num;
                pdo_update('gpb_goods_stock', array('num' => $num_stcok, 'sale_num' => $is), array('goods_id' => $gid, 'weid' => $_W['uniacid']));//修改库存

                $num_seckill_stock = $goods['total'] - $num;
                $num_seckill_stock = $num_seckill_stock <= 0 ? 0 : $num_seckill_stock;
                pdo_update('gpb_shop_seckill_task_goods', array('total' => $num_seckill_stock, 'sale_num' => $goods['sale_num'] + $num), array('goodsid' => $gid, 'uniacid' => $_W['uniacid'], 'optionid' => intval($optionid)));
                pdo_commit();
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->apireturn("订单添加成功", 0,$res);
//                $this->result("0", "订单添加成功", $res);
                exit;


            } else {
                pdo_rollback();//失败回滚
            	if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->apireturn("订单添加失败", 1);
//            $this->result("1","订单添加失败");exit;
            }
            exit;
        }
    }
    //获取多规格商品的规格
    public function  hookPageSeckill_GetSpecInfo($hook){
        global $_GPC,$_W;
        $openid =trim($_GPC['openid']);
        if(empty($openid)){
            $this->apireturn("未授权",1);
        }
        $id = trim($_GPC['id']);
        if(empty($id)){
            $this->apireturn("读取规格失败",1);
        }
        //$goods = pdo_get($this->goods,array('g_id'=>$id,"weid"=>$this->weid));
        $goods = pdo_fetch("select * from".tablename('gpb_goods')." as g where g_id=".$id." and weid = ".$_W['uniacid']." and (g.`type`<>2 or g.`type` is null)");
        if(empty($goods)){
            $this->apireturn("读取商品失败",1);
        }
        $goods['g_icon'] = tomedia($goods['g_icon']);
        $spec = pdo_getall('gpb_goods_spec',array('weid'=>$_W['uniacid'],'g_id'=>$id,'status'=>1));
//        $sec_spec = pdo_fetchall('select * from '.tablename('gpb_goods_option').' as a  join '.tablename('gpb_shop_seckill_task_goods').' as b on b.optionid = a.ggo_id where weid='.$_W['uniacid'].' and goodsid='.$id);
//        $ids ='';
//        if(is_array($sec_spec)){
//            foreach ($sec_spec as $v){
//                $ids = ','.$v['ggo_specs'];
//            }
//        }
//        $where= '';
//        if(!empty($ids)){
//            $where = " and gsi_id in (".trim($ids,',').")";
//        }
        foreach ($spec as $k=> $v){
//            $spec_item = pdo_fetchall('select * from '.tablename('gpb_goods_option').' as a  join '.tablename('gpb_shop_seckill_task_goods').' as b on b.optionid = a.ggo_id where weid='.$_W['uniacid'].' and optionid='.$v['id']);
//            var_dump('select * from '.tablename('gpb_goods_option').' as a  join '.tablename('gpb_shop_seckill_task_goods').' as b on b.optionid = a.ggo_id where weid='.$_W['uniacid'].' and optionid='.$v['id']);
            $spec_item = pdo_fetchall('select * from '.tablename('gpb_goods_spec_item').' where weid ='.$_W['uniacid'].' and gsi_specid='.$v['id']);
//            $spec_item = pdo_getall('gpb_goods_spec',array('weid'=>$_W['uniacid'],'gsi_specid'=>$v['id'],'gsi_is_del'=>1));
//            $spec_item = pdo_getall('gpb_shop_seckill_task_goods',array('uniacid'=>$_W['uniacid'],'optionid'=>$v['id']));
            $spec[$k]['item'] = $spec_item;
        }

        if(empty($spec)){
            $this->apireturn("查询规格失败",1);
        } else {
            $this->apireturn("查询规格成功",0,array('spec'=>$spec,'goods'=>$goods));
        }
    }
    ////获取不同规格的价格详情等等
    public  function  hookPageSeckill_GetSpecDeatail($hook){
        global $_GPC,$_W;
        $openid =trim($_GPC['openid']);
        if(empty($openid)){
            $this->apireturn("未授权",1);
        }
        $id_str = trim($_GPC['id_str'],',');
        if(empty($id_str)){
            $this->apireturn("未传入规格",1);
        }
        $gid = trim($_GPC['gid']);
        if(empty($gid)){
            $this->apireturn("未传入商品信息",1);
        }
        $info = pdo_fetch('select * from '.tablename('gpb_goods_option').' as a  join '.tablename('gpb_shop_seckill_task_goods').' as b on b.optionid = a.ggo_id where weid='.$_W['uniacid'].' and ggo_g_id='.$gid.' and ggo_specs="'.$id_str.'"');
        $info =  pdo_get('gpb_goods_option',array('weid'=>$this->weid,'ggo_g_id'=>$gid,'ggo_specs'=>$id_str,'ggo_is_del'=>1));
        $sec_info = pdo_get('gpb_shop_seckill_task_goods',array('uniacid'=>$_W['uniacid'],'optionid'=>$info['ggo_id']));
        if(!empty($sec_info)){
            $info = array_merge($info,$sec_info);
            $info['is_seckill']=1;
        }else{
            $info['is_seckill']=0;
        }
        if(empty($info)){
            $this->apireturn("查询失败",1);
        }else{
            $this->apireturn("查询成功",0,$info);
        }
    }
    /**
     * api数据返回
     */
    private function apireturn($msg='',$code = 1,$data=[]){
        echo json_encode(['errno'=>$code,'message'=>$msg,'data'=>$data],JSON_UNESCAPED_UNICODE);
        exit;
    }
    //开启redis
    private function redis()
    {
        global $_W;
        static $redis = NULL;

        if (is_null($redis)) {
//            var_dump($_W);
//            var_dump(!extension_loaded("redis"));exit;
            if (!extension_loaded("redis")) {
                $this->apireturn("PHP 未安装 redis 扩展,请联系管理员",0);
                exit;
            }
            if (!isset($_W["config"]["setting"]["redis"])) {
                $this->apireturn("未配置 redis, 请检查 data/config.php 中参数设置,请联系管理员",0);
                exit;
            }
            $config = $_W["config"]["setting"]["redis"];
            if (empty($config["server"])) {
                $config["server"] = "127.0.0.1";
            }
            if (empty($config["port"])) {
                $config["port"] = "6379";
            }
            $redis_temp = new Redis();
            if ($config["pconnect"]) {
                $connect = $redis_temp->pconnect($config["server"], $config["port"], $config["timeout"]);
            } else {
                $connect = $redis_temp->connect($config["server"], $config["port"], $config["timeout"]);
            }
            if (!$connect) {
                $this->apireturn("redis 连接失败, 请检查 data/config.php 中参数设置,请联系管理员",0);
                exit;
            }
            if (!empty($config["requirepass"])) {
                $redis_temp->auth($config["requirepass"]);
            }
            try {
                $ping = $redis_temp->ping();
            } catch (ErrorException $e) {
                $this->apireturn("redis 无法正常工作，请检查 redis 服务,请联系管理员",0);
                exit;
            }
            if ($ping != "+PONG") {
                $this->apireturn("redis 无法正常工作，请检查 redis 服务,请联系管理员",0);
                exit;
            }
            $redis = $redis_temp;
        } else {
            try {
                $ping = $redis->ping();
            } catch (ErrorException $e) {
                $redis = NULL;
                $redis = $this->redis();
                $ping = $redis->ping();
            }
            if ($ping != "+PONG") {
                $redis = NULL;
                $redis =$this->redis();
            }
        }
        return $redis;
    }
    /**
     * 获取今天的秒杀任务
     * @return mixed
     */
    public function getTodaySeckill()
    {
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }

        $redis_prefix = $this->get_prefix();
        global $_W;
        $year = date('Y');
        $month = date('m');
        return $redis->hGet($redis_prefix . 'calendar_' . $year . '_' . $month, date('Y-m-d'));
    }

    public function getTaskInfo($taskid)
    {
        global $_W;
        global $_GPC;
        $redis = $this->redis();
        if (is_error($redis))
        {
            return false;
        }
        $redis_prefix = $this->get_prefix();
        $info = $redis->hGetAll($redis_prefix . 'info_' . $taskid);
        if (empty($info))
        {
            return false;
        }
        return $info;
    }
    //获取前缀
    public function get_prefix()
    {
        global $_W;
        return 'group_buy_' . $_W['uniacid'] . '_' . $_W['account']['key'] . '_seckill_';
    }
    /*
   * 获取会场信息
   * int $taskid 专题id
   */
    public function getRooms($taskid)
    {
        global $_W;
        global $_GPC;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }
        $redis_prefix = $this->get_prefix();
        $allrooms = array();
        $rooms = $redis->lGetRange($redis_prefix . 'rooms_' . $taskid, 0, -1);
        foreach ($rooms as $room) {
            $room = json_decode($room, true);
            if (is_array($room)) {
                $allrooms[] = $room;
            }
        }
        return $allrooms;
    }
    /*
     * 获取秒杀时间段
     * int $taskid 专题id
     */
    public function getTaskTimes($taskid)
    {
        global $_W;
        global $_GPC;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }
        $redis_prefix = $this->get_prefix();
        $times = $redis->lGetRange($redis_prefix . 'times_' . $taskid, 0, -1);
        $alltimes = array();
        if (empty($times)) {
            return false;
        }
        foreach ($times as $time) {
            $time = json_decode($time, true);
            if (is_array($time)) {
                $alltimes[] = $time;
            }
        }
        return $alltimes;
    }
    /*
     * 获取秒杀商品
     * int $taskid 专题id
     * char $time 时间
     * int $goodsid 商品id
     */
    public function getSeckillGoods($taskid, $time, $goodsid)
    {
        global $_W;
        global $_GPC;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }
        $redis_prefix = $this->get_prefix();
        $timegoods = array();
        $goods = $redis->hGetAll($redis_prefix . 'goods_' . $taskid);

        if (empty($goods)) {
            return false;
        }
        $goods = @json_decode($goods['time-' . $time], true);
        if (!(is_array($goods))) {
            return false;
        }
        foreach ($goods as $g) {
            if (!(is_array($g))) {
                return false;
            }
            if (($g['goodsid'] == $goodsid) || ($goodsid == 'all')) {
                $timegoods[] = $g;
            }
        }
//        var_dump($timegoods);
        return $timegoods;
    }
    public function getSeckill($goodsid, $optionid = 0, $realprice = true, $openid = '')
    {
        global $_W,$_GPC;
        $redis = $this->redis();
        if (is_error($redis))
        {
            return false;
        }
//        static $deletedSeckill;
//        if (is_null($deletedSeckill))
//        {
//            $this->deleteSeckill();
//            $deletedSeckill = true;
//        }
        $id = $this->getTodaySeckill();

        if (empty($id))
        {
            return false;
        }
        $times = $this->getTaskTimes($id);
        $options = array();
        $currenttime = time();
        $timegoods = array();
        $sktime = 0;
        $timeid = 0;
        $roomid = 0;
        $taskid = 0;
        $goods_starttime = 0;
        $goods_endtime = 0;
//        if($_GPC['t']=='t'&&$goodsid ==78){
//            var_dump($times);//exit;
//        }
//        var_dump($times);exit;
        $timegoods_tmp = array();
        foreach ($times as $key => $time )
        {

            $starttime = strtotime(date('Y-m-d ' . $time['time'] . ':00:00'));
            if (isset($times[$key + 1])){
                $end = $times[$key + 1]['time'] - 1;
                $endtime = strtotime(date('Y-m-d ' . $end . ':59:59'));
            }else{
                $endtime = strtotime(date('Y-m-d 23:59:59'));
            }
            $time['endtime'] = $endtime;
            $time['starttime'] = $starttime;
            if (($starttime <= $currenttime) && ($currenttime <= $endtime))
            {
                $timeid = $time['id'];
                $taskid = $time['taskid'];
                $goods_starttime = $starttime;
                $goods_endtime = $endtime;
                $sktime = $time['time'];
                $timegoods = $this->getSeckillGoods($id, $time['time'], $goodsid);
            }
            else if ($currenttime < $starttime)
            {
                if (empty($timegoods))
                {
                    $timeid = $time['id'];
                    $goods_starttime = $starttime;
                    $goods_endtime = $endtime;
                    $taskid = $time['taskid'];
                    $sktime = $time['time'];
                    $timegoods = $this->getSeckillGoods($id, $time['time'], $goodsid);
                }
            }else if($currenttime>=$endtime) {
                if (empty($timegoods))
                {
                    $timeid = $time['id'];
                    $goods_starttime = $starttime;
                    $goods_endtime = $endtime;
                    $taskid = $time['taskid'];
                    $sktime = $time['time'];
                    $timegoods = $this->getSeckillGoods($id, $time['time'], $goodsid);
                }
//                echo '1';
            }
            if(empty($timegoods)){
                $timegoods=$timegoods_tmp;
            }else{
                $timegoods_tmp=$timegoods;
            }
//            if($_GPC['t']=='t'&&$goodsid ==78){
//              echo "as"; var_dump($timegoods); var_dump($id);
//            }
        }
        $total = 0;
        $count = 0;
        $selfcount = 0;
        $selftotalcount = 0;
        $maxbuy = 0;
        $notpay = 0;
        $selfnotpay = 0;
        $selftotalnotpay = 0;
        $totalmaxbuy = 0;
        $percent = 0;
//var_dump($timegoods);
//        if($_GPC['t']=='t'&&$goodsid ==78){
//            var_dump($timegoods);//exit;
//        }
        if (!(empty($timegoods)))
        {

            $roomid = $timegoods[0]['roomid'];
            $total = $timegoods[0]['total'];
            $price = $timegoods[0]['price'];
            $totalmaxbuy = $timegoods[0]['totalmaxbuy'];

            if (count($timegoods) <= 1)
            {
                $counts = $this->getSeckillCount($id, $timeid, $timegoods[0]['goodsid'], 0, $openid);
                $count = $counts['count'];
//                var_dump($counts);
//                echo 'as';
                $selfcount = $counts['selfcount'];
                $selftotalcount = $counts['selftotalcount'];
                $notpay = $counts['notpay'];
                $selfnotpay = $counts['selfnotpay'];
                $selftotalnotpay = $counts['selftotalnotpay'];
                $maxbuy = $timegoods[0]['maxbuy'];
                $percent = ceil(($count / ((empty($total) ? 1 : $total))) * 100);

            } else {
                $total = 0;
                $price = $timegoods[0]['price'];
                $option_goods = NULL;
                if (!(empty($optionid)))
                {
                    foreach ($timegoods as $g )
                    {
                        if ($g['optionid'] == $optionid)
                        {
                            $total = $g['total'];
                            $counts = $this->getSeckillCount($id, $timeid, $g['goodsid'], $optionid, $openid);
                            $count = $counts['count'];
                            $selfcount = $counts['selfcount'];
                            $selftotalcount = $counts['selftotalcount'];
                            $selfnotpay = $counts['selfnotpay'];
                            $selftotalnotpay = $counts['selftotalnotpay'];
                            $notpay = $counts['notpay'];
                            $maxbuy = $g['maxbuy'];
                            $percent = ceil(($count / ((empty($g['total']) ? 1 : $g['total']))) * 100);
                            break;
                        }
                    }

                }
                else
                {
                    foreach ($timegoods as $g )
                    {
                        $total += $g['total'];
                        if ($g['price'] <= $price)
                        {
                            $price = $g['price'];
                        }
                        $options[] = $g;
                    }
                    $counts = $this->getSeckillCount($id, $timeid, $g['goodsid'], 0, $openid);
                    $count = $counts['count'];
                    $selfcount = $counts['selfcount'];
                    $selfnotpay = $counts['selfnotpay'];
                    $notpay = $counts['notpay'];
                    $selftotalcount = $counts['selftotalcount'];
                    $selftotalnotpay = $counts['selftotalnotpay'];
                    $percent = ceil(($count / ((empty($total) ? 1 : $total))) * 100);

                }
            }

            if (!($realprice))
            {
                $price = $this->price_format($price);
            }
            $tag = '';
            $taskinfo = $this->getTaskInfo($taskid);
            $roominfo = $this->getRoomInfo($taskid, $roomid);
            if (!(empty($taskinfo['tag']))) {
                $tag = $taskinfo['tag'];
            }
            if (!(empty($roominfo['tag']))) {
                $tag = $roominfo['tag'];
            }
            $status = false;
            if (($goods_starttime <= $currenttime) && ($currenttime <= $goods_endtime)) {
                $status = 0;
            } else if ($currenttime < $goods_starttime) {
                $status = 1;
            }else if ($goods_endtime < $currenttime) {
                $status = -1;
            }
            return array(
                'taskid' => $taskid,
                'roomid' => $roomid,
                'timeid' => $timeid,
                'total' => $total,
                'count' => $count,
                'selfcount' => $selfcount,
                'selftotalcount' => $selftotalcount,
                'notpay' => $notpay,
                'selfnotpay' => $selfnotpay,
                'selftotalnotpay' => $selftotalnotpay,
                'maxbuy' => $maxbuy,
                'totalmaxbuy' => $totalmaxbuy,
                'tag' => $tag,
                'time' => $sktime,
                'options' => $options,
                'starttime' => $goods_starttime,
                'endtime' => $goods_endtime,
                'price' => $price,
                'percent' => $percent,
                'status' => $status
            );
        }
        return false;
    }
    /*
     * 获取会场信息
     * int $taskid 专题id
     * int $roomid 会场id
     */
    public function getRoomInfo($taskid, $roomid)
    {
        global $_W;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }
        $rooms = $this->getRooms($taskid);
        foreach ($rooms as $room) {
            if ($room['id'] == $roomid) {
                return $room;
            }
        }
        return false;
    }
    public function price_format($price)
    {
        $prices = explode(".", $price);
        if( intval($prices[1]) <= 0 )
        {
            $price = $prices[0];
        }
        else
        {
            if( isset($prices[1][1]) && $prices[1][1] <= 0 )
            {
                $price = $prices[0] . "." . $prices[1][0];
            }
        }
        return $price;
    }
    /*
    * 获取秒杀计数
    */
    public function getSeckillCount($taskid, $timeid, $goodsid, $optionid = 0, $openid = '')
    {
        global $_W;
        global $_GPC;
        $optionid = (int) $optionid;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }

        $date = date('Y-m-d');
        $redis_prefix = $this->get_prefix();
        $keys = $redis->keys($redis_prefix . 'queue_' . $date . '_' . $taskid . '_' . $timeid . '_' . $goodsid . '_*');
//        var_dump($keys);
//        echo 1;
        if (empty($keys)) {
            return array('count' => 0, 'notpay' => 0, 'selfcount' => 0, 'selfnotpay' => 0, 'selftotalcount' => 0, 'selftotalnotpay' => 0);
        }

        $count = 0;
        $notpay = 0;
        $selfcount = 0;
        $selftotalcount = 0;
        $selfnotpay = 0;
        $selftotalnotpay = 0;

        foreach ($keys as $key) {
            $arr = explode('_', $key);
            $key_optionid = (int) $arr[11];
            $queue = $redis->lGetRange($key, 0, -1);

            foreach ($queue as $data) {
                $data = @json_decode($data, true);

                if (!is_array($data)) {
                    continue;
                }

                if (0 < $optionid && $key_optionid === $optionid) {
                    ++$count;
                }
                else {
                    if ($optionid == 0) {
                        ++$count;
                    }
                }

                if ($data['status'] <= 0) {
                    ++$notpay;
                }

                if (!empty($openid) && $data['openid'] == $openid) {
                    if ($key_optionid == $optionid) {
                        ++$selfcount;
                    }

                    ++$selftotalcount;
                }

                if ($data['status'] <= 0 && !empty($openid) && $data['openid'] == $openid) {
                    if ($key_optionid === $optionid) {
                        ++$selfnotpay;
                    }

                    ++$selftotalnotpay;
                }
            }
        }
        return array('count' => $count, 'notpay' => $notpay, 'selfcount' => $selfcount, 'selfnotpay' => $selfnotpay, 'selftotalcount' => $selftotalcount, 'selftotalnotpay' => $selftotalnotpay);
    }
    public function deleteSeckill()
    {
        global $_W;
        if (is_error($this->redis()))
        {
            return false;
        }
        $currenttime = time();
        $redis = $this->redis();
        $redis_prefix = $this->get_prefix();
        $keys = $redis->keys($redis_prefix . 'queue_*');

        $orders = array();
        foreach ($keys as $key )
        {
            $queue = $redis->lGetRange($key, 0, -1);
            $tags = explode('_', $key);
            $taskid = $tags[7];
            $task = $this->getTaskInfo($taskid);
            $closesec = $task['closesec'];
            if (!(empty($queue)))
            {
                foreach ($queue as $value )
                {
                    $data = @json_decode($value, true);
                    if (!(is_array($data)))
                    {
                        continue;
                    }
                    $seckill_over_time_close = pdo_get('gpb_config',array('key'=>'seckill_over_time_close','weid'=>$_W['uniacid']));
                    $over_time = isset($seckill_over_time_close['value']) && !empty($seckill_over_time_close['value'])? $seckill_over_time_close['value']:1;
//                    var_dump($data);exit;
                    if (($data['status'] <= 0) && ($closesec <= $currenttime - $data['createtime']))
                    {
                        $redis->lRemove($key, $value, 1);
                        if (!(in_array($data['orderid'], $orders)))
                        {
                            $orders[] = $data['orderid'];
                            continue;
                        }
                    }
                    if ( ($over_time < $currenttime - $data['createtime']))
                    {
                        $redis->lRemove($key, $value, 1);
                        if (!(in_array($data['orderid'], $orders)))
                        {
                            $orders[] = $data['orderid'];
                            continue;
                        }
                    }

                }
            }
            if ($redis->lLen($key) <= 0)
            {
                $redis->delete($key);

            }
            if (!(empty($orders)))
            {
//                $p = com('coupon');
                foreach ($orders as $orderid )
                {
                    $o = pdo_fetch('select *  from ' . tablename('gpb_order') . ' where go_id=:id  limit 1', array(':id' => $orderid));
                    if (!(empty($o)) && ($o['go_status'] == 10 || $o['go_status']==20 ))
                    {
                       //是否有优惠卷
                        if ($o['go_fdc_id']>0)
                        {
                            pdo_update('gpb_user_ticket',array('is_use'=>0),array('id'=>$o['go_fdc_id']));
                        }
                        pdo_query('update ' . tablename('gpb_order') . ' set go_status=110 where go_id=' . $o['go_id']);
                        //查询订单支付？
                        $order = pdo_fetch('select go_code from '.tablename('gpb_order').' where go_id=:id',array(':id'=>$data['orderid']));
                        $sn = pdo_getall('gpb_order_snapshot',array('oss_go_code'=>$order['go_code']));
                        if(is_array($sn)){
//                            foreach ( $sn as $v){
//                                pdo_query("update ".tablename('gpb_shop_seckill_task_goods')." set total = total+".$v['oss_g_num'].",sale_num = sale_num - ".$v['oss_g_num']." where taskid=".$v['oss_seckill_taskid']." and roomid=".$v['oss_seckill_roomid']." and timeid=".$v['oss_seckill_timeid']." and uniacid=".$_W['uniacid']);
//                            }
                        }
                    }
                }
            }
        }
        return true;
    }
    //设置订单
    public function setOrderPay($orderid)
    {
        global $_W;
        if (is_error($this->redis()))
        {
            return false;
        }
        $redis = $this->redis();
        $redis_prefix = $this->get_prefix();
        $date = date('Y-m-d');
//        $order = pdo_fetch('select id,ordersn, price,openid,status, paytype, deductcredit2, couponid,isparent,merchid,agentid,createtime from ' . tablename('gpb_order') . ' where  id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $orderid));
        $order = pdo_fetch('select go_id as id, go_real_price as price,openid,go_status as status, go_pay_type as paytype, go_fdc_id as couponid,go_add_time as createtime from ' . tablename('gpb_order') . ' where  go_id=:id and weid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $orderid));
        if (empty($order))
        {
            return '';
        }
//        $goods = pdo_fetchall('select  uniacid, total , goodsid,optionid,seckill_timeid,seckill_taskid from  ' . tablename('ewei_shop_order_goods') . ' where orderid=' . $order['id'] . ' and  seckill=1 ');
        $goods = pdo_fetchall('select  oss_total_price as total , oss_gid as goodsid,ggo_id as optionid, oss_seckill_roomid as seckill_timeid,oss_seckill_taskid as seckill_taskid from  ' . tablename('gpb_order_snapshot') . ' where oss_go_code=' . $order['go_code'] . ' and  oss_is_seckill=1 ');
        foreach ($goods as $g )
        {
            $key = $redis_prefix . 'queue_' . $date . '_' . $g['seckill_taskid'] . '_' . $g['seckill_timeid'] . '_' . $g['goodsid'] . '_' . $g['optionid'];
            $queue = $redis->lGetRange($key, 0, -1);
            $paydata = json_encode(array('orderid' => $order['id'], 'openid' => $order['openid'], 'status' => 1, 'createtime' => $order['createtime']));
            if (empty($queue))
            {
                //为空要退款
//                $this->orderRefund($order);
                return 'refund';
            }
            $has = false;
            foreach ($queue as $index => $value )
            {
                $data = @json_decode($value, true);
                if (!(is_array($data)))
                {
                    continue;
                }
                if (($data['orderid'] == $order['id']) && ($data['openid'] == $order['openid']))
                {
                    $has = true;
                    $redis->lSet($key, $index, $paydata);
                }
            }
            if (!($has))
            {
                //为空要退款
//                $this->orderRefund($order);
                return 'refund';
            }
        }
        return '';
    }

    /**
     * 设置秒杀数据
     */
    public function setSeckill($seckillinfo, $goods, $openid, $orderid, $status, $createtime)
    {
        global $_W;
        global $_GPC;

        if (is_error( $this->redis() )) {
            return false;
        }

        $taskid = $seckillinfo['taskid'];
        $timeid = $seckillinfo['timeid'];
        if (!empty($seckillinfo['options']) && $seckillinfo['options'][0]['timeid'] != $timeid) {
            $timeid = $seckillinfo['options'][0]['timeid'];
        }

        $goodsid = $goods['goodsid'];
        $optionid = intval($goods['optionid']);
        $date = date('Y-m-d');
        $redis_prefix = $this->get_prefix();
        $key = $redis_prefix . 'queue_' . $date . '_' . $taskid . '_' . $timeid . '_' . $goodsid . '_' . $optionid;
        $redis = $this->redis();

        if ($redis->ttl($key) == -1) {
            $redis->expireAt($key, $seckillinfo['endtime'] + 1);
        }

        $index = -1;
        $queue = $redis->lGetRange($key, 0, -1);

        foreach ($queue as $dindex => $data) {
            $data = @json_decode($data, true);

            if (!is_array($data)) {
                continue;
            }

            if ($data['orderid'] == $orderid && $data['openid'] == $openid) {
                $index = $dindex;
                break;
            }
        }

        $data = array('orderid' => $orderid, 'openid' => $openid, 'status' => $status, 'createtime' => $createtime);
//        var_dump($index);var_dump($queue);exit;
        if ($index == -1) {
            $i = 1;

            while ($i <= $goods['total']) {
                $push = $redis->lPush($key, json_encode($data));
                ++$i;
            }
        }
        else {
            $push = $redis->lSet($key, $index, json_encode($data));
        }

        return $key;
    }

    /**
     * 购买时检查
     * @param $seckillinfo
     * @param $title
     * @param string $unit
     * @return array|bool
     */
    public function checkBuy($seckillinfo, $title, $unit = '')
    {
        if (empty($unit))
        {
            $unit = '件';
        }
        if (100 <= $seckillinfo['percent'])
        {
            if (0 < $seckillinfo['notpay'])
            {
                $this->apireturn( $title . ' 已经抢完了 ，但还有 ' . $seckillinfo['notpay'] . ' ' . $unit . '未付款的, 抓住机会哦~',-1);
            }
            $this->apireturn( $title . '已经抢完了 !',-1);
        }
        if (0 < $seckillinfo['totalmaxbuy'])
        {
            if ($seckillinfo['totalmaxbuy'] <= $seckillinfo['selftotalcount'])
            {
                if (0 < $seckillinfo['selftotalnotpay'])
                {
                    $this->apireturn( $title . '最多抢购 ' . $seckillinfo['totalmaxbuy'] . ' ' . $unit . ',  您有' . $seckillinfo['selftotalnotpay'] . '个未付款的，抓紧付款哦~',-1);
                }
                $this->apireturn( $title . ' 您已经抢购 ' . $seckillinfo['totalmaxbuy'] . ' ' . $unit . '了哦，不能继续抢购了，看看别的吧!',-1);
            }
        }
        if (0 < $seckillinfo['maxbuy'])
        {
            if ($seckillinfo['maxbuy'] <= $seckillinfo['selfcount'])
            {
                if (0 < $seckillinfo['selfnotpay'])
                {
                    $this->apireturn( $title . ' 最多抢购 ' . $seckillinfo['maxbuy'] . ' ' . $unit . ',  您有' . $seckillinfo['selfnotpay'] . '个未付款的，抓紧付款哦~',-1);
                }
                $this->apireturn(  $title . '您已经抢购 ' . $seckillinfo['maxbuy'] . ' ' . $unit . '了哦，不能继续抢购了，看看别的吧!',-1);
            }
        }
        return true;
    }

    /**
     * 小程序支付 (原生) qpays
     * @param $total_fee 支付金额
     * @param $openid 支付用户的openid
     * @param $order 订单号
     * @param $id 表的id
     * @param $notify_url 回调地址
     * retrun array
     */
    public function pays($total_fee,$openid,$order,$id,$notify_url){
        global $_GPC,$_W;
        if(empty($total_fee)){
            $this->apireturn("金额有误", -1);

//            $this->result(-1,'金额有误');
        }
        //判断用户是否正确
        if(empty($openid)){
            $this->apireturn("登录失效，请重新登录(openid参数有误)", -1);
//            $this->result(-1,'登录失效，请重新登录(openid参数有误)');
        }

        $appid    =      $_W['oauth_account']['key'];//如果是公众号 就是公众号的appid;小程序就是小程序的appid
        $body     =       '在线支付';
        $mch_id   =       $this->pay_setting['wechat']['mchid'];//商户号
        $KEY      =       $this->pay_setting['wechat']['signkey'];//支付密匙

        $nonce_str =    $this->randomkeys(32);//随机字符串
        $notify_url =   $_SERVER['SERVER_NAME'];//;  //支付完成回调地址url,不能带参数
        $out_trade_no = $order;//商户订单号
        $spbill_create_ip = $_SERVER['SERVER_ADDR'];//服务器端ip
        $trade_type = 'JSAPI';//交易类型 默认JSAPI

        //这里是按照顺序的 因为下面的签名是按照(字典序)顺序 排序错误 肯定出错
        $post['appid'] = $appid;
        $post['attach'] = $id;
        $post['body'] = $body;
        $post['mch_id'] = $mch_id;
        $post['nonce_str'] = $nonce_str;//随机字符串
        $post['notify_url'] = $notify_url;
        $post['openid'] = $openid;
        $post['out_trade_no'] = $out_trade_no;
        $post['spbill_create_ip'] = $spbill_create_ip;//服务器终端的ip
        $post['total_fee'] = $total_fee*100;        //总金额 最低为一分钱 必须是整数  单位是分  所以乘100
        $post['trade_type'] = $trade_type;
        $sign = $this->MakeSign($post,$KEY);              //签名

        $post_xml = $this->array_xml($post,$sign);        //字典序将数组转xml格式
//        var_dump($post);
//        var_dump($KEY);
//        var_dump($sign);
//		echo '<pre>';
//		print_r($post_xml);
//		echo '<br/>1<br/>';
        //统一下单接口prepay_id
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $xml = $this->http_request($url,$post_xml);     //POST方式请求http
        $array = $this->xml2array($xml);               //将【统一下单】api返回xml数据转换成数组，全要大写
//        var_dump($array);
        if($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS'){
            $time = time();
            $tmp=[];                            //临时数组用于签名
            $tmp['appId'] = $appid;
            $tmp['nonceStr'] = $nonce_str;
            $tmp['package'] = 'prepay_id='.$array['PREPAY_ID'];
            $tmp['signType'] = 'MD5';
            $tmp['timeStamp'] = $time."";

            $data['status'] = 0;
            $data['id'] = $id;
            $data['packages'] = $array['PREPAY_ID'];
            $data['timeStamp'] = "{$time}";           //时间戳
            $data['nonceStr'] = $nonce_str;         //随机字符串
            $data['signType'] = 'MD5';              //签名算法，暂支持 MD5
            $data['package'] = 'prepay_id='.$array['PREPAY_ID'];   //统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
            $data['paySign'] = $this->MakeSign($tmp,$KEY);       //签名,具体签名方案参见微信公众号支付帮助文档;
            $data['out_trade_no'] = $out_trade_no;
        }else{
            $data['status'] = 1;
            $data['text'] = "调用支付失败";
            $data['RETURN_CODE'] = $array['RETURN_CODE'];
            $data['RETURN_MSG'] = $array['RETURN_MSG'];
            $data['info'] = $array;
        }
        return $data;
    }
    /**
     * 随机字符串
     * return string 32位随机字符串
     */
    private function randomkeys($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return strtoupper($str);
    }
    /**
     * 生成签名, $KEY就是支付key
     * @param $params array 需要签名的数组
     * @param $KEY string 密匙
     * @return 签名
     */
    public function MakeSign($params,$KEY){
//  	return $params;
//      //签名步骤一：按字典序排序数组参数
        ksort($params);
        $string = $this->ToUrlParams($params);  //参数进行拼接key=value&k=v
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$KEY;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
    /**
     * 将参数拼接为url: key=value&key=value
     * @param $params array 需要转换的数据
     * @return string 返回拼接成功的字符串
     */
    public function ToUrlParams( $params ){
        $buff = "";
        foreach ($params as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
    /**
     * array转xml
     * @param string 将array转为xml
     * @param string 签名
     * return xml 数据
     */
    public function array_xml($array,$sign){
        ksort($array);
        $xml = '<xml>';
        foreach($array as $k=>$v){
            if(!is_array($v)){
                $xml .= '<'.$k.'>'.$v.'</'.$k.'>';
            }
        }
        $xml .= '<sign>'.$sign.'</sign>';
        $xml .='</xml>';
        return $xml;
    }
    /**
     * 获取xml里面数据，转换成array
     * @param $xml XML格式数据
     * retrun array 数据
     */
    private function xml2array($xml){
        $parser = xml_parser_create();
        // 将 XML 数据解析到数组中
        xml_parse_into_struct($parser, $xml, $vals, $index);
        // 释放解析器
        xml_parser_free($parser);
        // 数组处理
        $arr = array();
        $t=0;
        foreach($vals as $value) {
            $type = $value['type'];
            $tag = $value['tag'];
            $level = $value['level'];
            $attributes = isset($value['attributes'])?$value['attributes']:"";
            $val = isset($value['value'])?$value['value']:"";
            switch ($type) {
                case 'open':
                    if ($attributes != "" || $val != "") {
                        $arr[$tag] = $attributes;
                        $t++;
                    }
                    break;
                case "complete":
                    if ($attributes != "" || $val != "") {
                        $arr[$tag] = $val;
                        $t++;
                    }
                    break;
            }
        }
        return $arr;
    }
//    private function xml2array($xml){
//        $p = xml_parser_create();
//        xml_parse_into_struct($p, $xml, $vals, $index);
//        xml_parser_free($p);
//        $data = "";
//        foreach ($index as $key=>$value) {
//            if($key == 'xml' || $key == 'XML') continue;
//            $tag = $vals[$value[0]]['tag'];
//            $value = $vals[$value[0]]['value'];
//            $data[$tag] = $value;
//        }
//        return $data;
//    }
    /**
     * 调用接口， $data是数组参数
     * @return 签名
     */
    private function http_request($url,$data = null,$headers=array())
    {
        $curl = curl_init();
        if( count($headers) >= 1 ){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /*
     * 请求查询订单支付状态
     * @param string $gid
     * @return array
     */
    public function wx_order_status($gid){
        global $_W,$_GPC;
        $data['appid'] = $_W['account']['key'];//appid
        $data['mch_id'] = $this->pay_setting['wechat']['mchid'];//商户号
        $data['nonce_str'] = $this->randomkeys(32);//随机字符串
        $urls = 'https://api.mch.weixin.qq.com/pay/orderquery';
        //foreach($info as $k=>$v){
        $data['out_trade_no'] = $gid; //拿到订单号
        $sign = $this->MakeSign($data,$this->pay_setting['wechat']['signkey']);//算签名
        $post_xml = $this->array_xml($data, $sign);//数组转xml
        $list = $this->http_request($urls,$post_xml);//请求
        $list = $this->xml_to_array($list);//将返回的数据转成数组
        return $list;
    }
    /**
     * 将xml转为array
     * @param string $xml
     * return array
     */
    public function xml_to_array($xml){
        if(!$xml){
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }

    /**
     * 获取access_token
     */
    public function Token(){
        global $_GPC,$_W;
        if(time() > $_W['account']['access_time'] || empty($_W['account']['access_time'])){
            //获取access_token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$_W['account']['key']."&secret=".$_W['account']['secret'];
            $list = $this->http_request($url);
            $list = json_decode($list, true);
//			echo '<pre>';
//			print_r($list);exit;
            $_W['account']['access_tokne'] = $list['access_token'];
            $_W['account']['access_time'] = time()+7150;
            return true;
        }else{
            return true;
        }
    }
    /*
     * 存文本日志的函数
     *  string $filename 文件名
     *  string $content 日志文本
     */
    public function txt_logging_fun($filename,$content){
        if(empty($filename)||empty($content)){
            return;
        }
        //存日志
        $file  = dirname(__FILE__).'/'.$filename;//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
        if(file_exists($file) && filesize($file) > 100000){
            unlink($file);//这里是直接删除，
        }
        file_put_contents($file,$content.PHP_EOL,FILE_APPEND);
        return;
    }

    /*
     * 支付成功发公众号的方法
     * param str $code 订单code
     */
    protected function pay_success_send_official_account_msg($code){
        //订单情况
        $order = pdo_get('gpb_order',array('go_code'=>$code,'weid'=>$this->weid));
        $sn = pdo_getall('gpb_order_snapshot',array('oss_go_code'=>$order['go_code'],'oss_ggo_status'=>1));
        //@param $key 发送那个模板消息
        $key = 'wechat_deliver_pay';
        //模块
        $weid = $this->weid;
        //团长的openid
        $openid = $order['go_team_openid'];
        //买家姓名
        $buyname = empty($sn[0]['oss_buy_name'])?$sn[0]['oss_address_phone']:$sn[0]['oss_buy_name'];
		if($this->check_base64_out_json($buyname)){
            $buyname = base64_decode($buyname);
        }
        $data = array(
            'first'=>array('value'=>'团长您好！用户('.$buyname.')在您处下单，请密切关注'),
            'keyword1'=>array('value'=>$order['go_code']),
            'keyword2'=>array('value'=>$sn[0]['oss_g_name'].'...'),
            'keyword3'=>array('value'=>$order['go_real_price']),
            'keyword4'=>array('value'=>'已支付'),
            'keyword5'=>array('value'=>date('Y-m-d H:i:s',$order['go_add_time'])),
            'remark'=>array('value'=>'有任何问题请联系管理员！')
        );
        $href = 'pages/groupCenter/groupOrders';
        $sms = new Sms();
        $res = $sms->public_address_template($key,$weid,$openid,$data,$href);
        $log_content = date('Y-m-d H:i:s').'，支付成功发公众号模版消息日志'.PHP_EOL;
        if(is_array($res)){
            foreach ($res as $dass_k=>$dass_v){
                $log_content .='key:'.$dass_k.',value:'.$dass_v.PHP_EOL;
            }
        }
        $log_content .= 'code:'.$code.PHP_EOL;
        $log_content .= 'openid:'.$openid.PHP_EOL;
        $log_content .= '----------end------------\n'.PHP_EOL;
        $this->txt_logging_fun('official_account_'.$key.'_log.txt',$log_content);
    }
    /*
     * 优化微擎底层的is_base64的判断
     * 确保字符串被base64解密后可被json加密
     * string $str 被检测的字符串
     */
    protected function check_base64_out_json($str){
        if(!is_string($str)){
            return false;
        }
        $str_base64_decode = base64_decode($str);
        $str_base64_decode_json_encode = json_encode($str_base64_decode);
        $error_code = json_last_error();
        if($error_code > 0 ){
            return false;
        }
        return $str == base64_encode(base64_decode($str));
    }
	/**
	 * 获取团长送货配送时间
	 */
	public function delivery(){
		global $_W;
		//获取配置
		$info = pdo_getall("gpb_config",['status'=>1,'type'=>30,'weid'=>$this->weid]);
		if($info){
			$data = [];
			foreach($info as $k=>$v){
				if($v['value'] == serialize(unserialize($v['value']))){
					$data[$v['key']] = unserialize($v['value']);
				}else{
					$data[$v['key']] = $v['value'];
				}
			}
		}
		if($data['delivery_de'] != 1){
			return false;
		}
		$time = date('H');
		if($time >= 24){
			$time = 0;
		}
		$date_time = $str = $arr = [];
		if($time){
			$i = 0;
			foreach($data['delivery_time'] as $k=>$v){
				$v_time = strtotime(date('Y-m-d ').$v['star_time']);//每次循环的开始时间
				if((time()+3600*$data['delivery']) < $v_time){
					$arr[$i] = $v['star_time']."-".$v['end_time'];
					$i++;
				}
				$str[$k] = $v['star_time']."-".$v['end_time'];
			}
		}
		if($arr){
			$date_time[0]['time'] = date('m-d',time()); 
			$date_time[0]['value'] = $arr; 
		}
		if(count($arr) <= 2){
			//计算明天的
			$date_time[1]['time'] = date('m-d',time()+86400); 
			$date_time[1]['value'] = $str;
		}
		$data['delivery_time'] = $date_time;
		return $data;
	}
}