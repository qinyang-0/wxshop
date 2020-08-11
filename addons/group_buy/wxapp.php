<?php

defined('IN_IA') or exit('Access Denied');

define('QRCODEPATH','/addons/group_buy/public/images/');

include_once '../addons/group_buy/sms.php';

include_once '../addons/group_buy/SubMsg.php';

include_once '../addons/group_buy/SubWechat.php';

include_once '../addons/group_buy/print_sn.php';

include_once "../addons/group_buy/markrting.php";

ini_set('date.timezone','Asia/Shanghai');

class Group_buyModuleWxapp extends WeModuleWxapp{
    public $member = 'gpb_member';//用户表
    public $ah = 'gpb_application_header';//申请团长表
    public $rg = 'gpb_region';//地区表
    public $vg = 'gpb_village';//小区表
    public $goods = 'gpb_goods';//商品表
    public $goods_cate = 'gpb_goods_cate';//商品分类表
    public $goods_stock = 'gpb_goods_stock';//商品库存
    public $goods_stock_logs = 'gpb_goods_stock_logs';//商品库存日志
    public $adv = 'gpb_banner';//banner

    public $coupon = 'gpb_ticket';//优惠卷

    public $user_coupon = 'gpb_user_ticket';//用户领取的优惠券

    public $order = 'gpb_order';//用户订单表

    public $order_log = 'gpb_order_log';//用户订单日志表

    public $action = 'gpb_action';//活动表

    public $address = 'gpb_receiving_address';//收获地址表

    public $snapshot = 'gpb_order_snapshot';//订单商品快照表

    public $ban = 'gpb_banner';//banner广告

    public $sure_order = 'gpb_sure_order';//订单核销表

    public $action_village = 'gpb_action_village';//活动小区关系表

    public $action_goods = 'gpb_action_goods';//活动商品关系表

    public $cart = 'gpb_cart';//购物车表

    public $config = 'gpb_config';//配置表

    public $get_cash = 'gpb_get_cash';//提现表

    public $back_money = 'gpb_back_money';//退款表

    public $distribution = 'gpb_distribution_list';//配送表

    public $distribution_route = 'gpb_distribution_route';//配送路线表

    public $supplier = 'gpb_supplier';//供应商

    public $spec = 'gpb_goods_spec';//规格表

    public $spec_item = 'gpb_goods_spec_item';//规格下参数表

    public $goods_option = 'gpb_goods_option';//参数规格erp

    public $diy_page = 'gpb_diy_page';//diy页面信息

    public $diy_temp = 'gpb_diy_temp';//diy模版信息

    public $stream = 'gpb_order_stream';//流水

    public $article = 'gpb_article';//文章表

    public $article_class = 'gpb_article_class';//文章分类

    public $team_cancel_goods = 'gpb_team_cancel_goods';//团长未开启的商品记录

    public $head_history = 'gpb_head_history';//团长未开启的商品记录

    public $pay_setting;



    public $weid, $http, $https, $http_type, $https_type;

    public $pageindex = 10;

    //开始时间,固定一个小于当前时间的毫秒数即可

    const twepoch = 1474990000000;//2016/9/28 0:0:0

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

    public function __construct($workId = 0, $datacenterId = 0){
        global $_W, $_GPC;
        if (!isset($_W['account']['key']) || empty($_W['account']['key'])) {
            $this->result("1", "小程序appid有误");
        }
        if (!isset($_W['account']['secret']) || empty($_W['account']['secret'])) {
            $this->result("1", "小程序secret有误");
        }
        $this->appid = $_W['account']['key'];//小程序appid
        $this->secret = $_W['account']['secret'];//小程序secret
        if (is_array($_W['account'])) {
            $is_true = true;
            if (!isset($_W['account']['setting']['payment']['wechat']['mchid']) || empty($_W['account']['setting']['payment']['wechat']['mchid'])) {
                //$this->result("1","商户号有误");
                $is_true = false;
            }
            if (!isset($_W['account']['setting']['payment']['wechat']['signkey']) || empty($_W['account']['setting']['payment']['wechat']['signkey'])) {
                //$this->result("1","支付密钥有误");
                $is_true = false;
            }
            if ($is_true) {
                $pay = [
                    'wechat' => [
                        'mchid' => $_W['account']['setting']['payment']['wechat']['mchid'],
                        'signkey' => $_W['account']['setting']['payment']['wechat']['signkey'],
                    ]
                ];
            }
        } else {
            $is_true = true;
            if (!isset($_W['account']->setting['payment']['wechat']['mchid']) || empty($_W['account']->setting['payment']['wechat']['mchid'])) {
//                $this->result("1","商户号有误");
                $is_true = false;
            }
            if (!isset($_W['account']->setting['payment']['wechat']['signkey']) || empty($_W['account']->setting['payment']['wechat']['signkey'])) {
//                $this->result("1","支付密钥有误");
                $is_true = false;
            }
            if ($is_true) {
                $pay = [
                    'wechat' => [
                        'mchid' => $_W['account']->setting['payment']['wechat']['mchid'],
                        'signkey' => $_W['account']->setting['payment']['wechat']['signkey'],
                    ]
                ];
            }
        }
        $this->pay_setting = $pay;
        $this->weid = !empty($_GPC['uniacid'])?$_GPC['uniacid']:$_GPC['__uniacid'];

        if(empty($this->weid)){
            $this->weid = !empty($_W['uniacid'])?$_W['uniacid']:$_GPC['i'];
        }
        $this->pre = $_W['config']['db']['tablepre'];
        //获取是否是对象储存
        //判断当前是HTTP还是https
        $this->http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        //获取是否是对象储存 tomedia解决
        //机器ID范围判断
        $maxWorkerId = -1 ^ (-1 << self::workerIdBits);
        if ($workId > $maxWorkerId || $workId < 0) {
            throw new \Exception("workerId can't be greater than " . $this->maxWorkerId . " or less than 0");
        }
        //数据中心ID范围判断
        $maxDatacenterId = -1 ^ (-1 << self::datacenterIdBits);
        if ($datacenterId > $maxDatacenterId || $datacenterId < 0) {
            throw new \Exception("datacenter Id can't be greater than " . $maxDatacenterId . " or less than 0");
        }
        //赋值
        $this->workId = $workId;
        $this->datacenterId = $datacenterId;
		$this->doPageLowdown();//触发活动商品下架

    }



    //生成一个ID

    public function nextId()

    {

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



        $id = str_pad(abs($nextId), 2, '', STR_PAD_LEFT);

//        echo date('mdhi'). $id;;exit;

        return date('mdhi') . substr($id, 3);

        //return time().$id;

    }

    //取当前时间毫秒

    protected function timeGen()

    {

        $timestramp = (float)sprintf("%.0f", microtime(true) * 1000);

//        $timestramp = (float)sprintf("%.0f", time(true) *1000);

        return $timestramp;

    }



    //取下一毫秒

    protected function tilNextMillis($lastTimestamp)

    {

        $timestamp = $this->timeGen();

        while ($timestamp <= $lastTimestamp) {

            $timestamp = $this->timeGen();

        }

        return $timestamp;

    }



    /*

     * 测试参数

     */

    public function doPageDelCache()

    {

        global $_W, $_GPC;

        //设置需要删除的文件夹

//      $a = $this->doPageDistribution_goods_commiosn(array('id'=>119,'openid'=>'oLf4B0RKRvsOPND25hNm4cCiz_Lg','num'=>3,'ggo_id'=>0,'order_code'=>'10091059199975310'));

//  	var_dump($a);exit;

	}

	/**

	 * 判断当前商品状态

	 */

	public function doPageGoods_status(){
		global $_W, $_GPC;
		$id = $_GPC['gid'];
		$goods = pdo_get("gpb_goods",array('g_id'=>$id));
		if(empty($goods)){
			$this->result("1", "商品不存在");
		}
		$temp = pdo_get($this->diy_page, array('system' => 3, 'status' => 2, 'weid' => $this->weid));
        if (empty($temp)) {
            //先获取使用的系统模板
            $sql = " select t.id,content from " . tablename($this->diy_temp) . " t join " . tablename($this->diy_page) . " p on t.id = p.tempid where t.isact = 1 and (t.weid = " . $this->weid . " or t.system =2)";
            $temp = pdo_fetch($sql);
            if (empty($temp)) {
                $sql = " select t.id,content from " . tablename($this->diy_temp) . " t join " . tablename($this->diy_page) . " p on t.id = p.tempid where t.isact = 1 and t.weid = 0 ";
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
		//先判断是否是秒杀  里面的商品
		if (!extension_loaded("redis")) {
        	$ts = 1;
        }
        if (!isset($_W["config"]["setting"]["redis"])) {
        	$ts = 1;
        }
		if($ts == 2){
			$return = $this->doPageSeckill_get_goods_info();
		}
		if($return) {
//			直接重redis中取出当天的任务  看看
//				$meckil_goods = pdo_get('gpb_shop_seckill_task_goods',array('goodsid'=>$id,'uniacid'=>$this->weid));
			$_GPC['types'] = '2';
			$json = $this->doPageSeckill_index();
			if(empty($json['currentgoods'])){
				if(!empty($json['aftergoods'])){
					$arr = [];
					foreach($json['aftergoods'] as $k=>$v){
						foreach($v['goods'] as $kk=>$vv){
							if($id == $vv['g_id']){
								$arr = $v;
								break;
							}
						}
						if($arr){
							break;
						}
					}
					if($arr){
						$json = $arr;
					}else{
						$json = [];
					}
				}else{
					$json = [];
				}
			} else {
				$json = $json['currentgoods'];
			}
			if($json){
				$_GPC['taskid'] = $json['taskid'];
				$_GPC['roomid'] = $json['goods'][0]['roomid'];
				$goods = pdo_get("gpb_shop_seckill_task_goods",array('taskid'=>$json['taskid'],'roomid'=>$json['goods'][0]['roomid'],'goodsid'=>$id));
				//判断是否过期抢购
				$old = 0;
				$return = 0;
				$task_time = pdo_fetch("select time from ".tablename('gpb_shop_seckill_task_time')." where id = ".$goods['timeid']);
				if(date("H") > $task_time['time']){
					//当前时间已过期
					$oldshow = pdo_fetch("select oldshow from ".tablename('gpb_shop_seckill_task_room')." where id = ".$goods['roomid']);
					if($oldshow['oldshow'] == 1){
						$old = 1;$return = 1;
					}
				}else{
					$old = 1;$return = 1;
				}
				if($old){
					$_GPC['timeid'] = $goods['timeid'];
					//判断秒杀是否开始
					$itms = pdo_get("gpb_shop_seckill_task_time",array('id'=>$goods['timeid']),array('time'));
					if(date('H',time()) >= $itms['time']){
						$this->doPageSeckill_get_goods();
					}
					if(date('H',time()) <= $itms['time'] && $_GPC['endtype'] == 1){
						$this->doPageSeckill_get_goods();
					}
				}
			}
		}
		if($return && $ts == 2){
			$_GPC['sekill'] = 1;
		}
		$action_goods = pdo_fetchall("select gcg_at_id from ".tablename('gpb_action_goods')." where gcg_g_id = ".$id.' and weid = '.$this->weid);
		if(count($action_goods) <= 1){
			$_GPC['at_id'] = $action_goods[0]['gcg_at_id'];
		}else{
			$str = '';
			foreach($action_goods as $k=>$v){
				$str .= $v['gcg_at_id'].",";
			}
			$str = trim($str,',');
			$time = time();
			$arr = pdo_fetch("select at_id from ".tablename('gpb_action')." where at_id in (".$str.") and at_is_del = 1 and at_start_time <= ".$time." and at_end_time > ".$time);
			if(!empty($arr)){
				$_GPC['at_id'] = $arr['at_id'];
			}
		}

		$arr = $this->doPagegetGoods();
	}





    /*
	 * 请求微信得openid
	 */
//  public function doPagegetopenid(){}
    /**
     * 前台授权后传入用户信息
     */
    public function doPageinsertUserInfo(){

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        $lng = trim($_GPC['lng']);

        $lat = trim($_GPC['lat']);

        $avatarUrl = trim($_GPC['avatarUrl']);

        $nickName = $_GPC['nickName'];

        $sessionkey = trim($_GPC['sessionkey']);

        $location = trim($_GPC['location']);

        $unionid = trim($_GPC['unionid']);

        if (!isset($openid) || empty($openid) || $openid == 'undefined') {

            $this->result("1", "请传入用户openid");

        }

        $data = array();

        $data['m_openid'] = $openid;

        if (!empty($lng)) {

            $data['m_last_longitude'] = $lng;

        }

        if (!empty($lat)) {

            $data['m_last_latitude'] = $lat;

        }

        if (!empty($avatarUrl)) {

            $data['m_photo'] = $avatarUrl;

        }

        if (!empty($nickName)) {

            $data['m_nickname'] = base64_encode($nickName);

        }

        if (!empty($sessionkey)) {

            $data['sessionkey'] = $sessionkey;

        }

        if (!empty($location)) {

            $data['m_last_location'] = $location;

        }

        if (!empty($unionid)) {

            $data['unionid'] = $unionid;

        }



//        $data = [

//            'm_openid'=>$openid,

//            'm_nickname'=>$nickName,

//            'm_photo'=>$avatarUrl,

//            'm_last_longitude'=>$lng,

//            'm_last_latitude'=>$lat,

//            'm_add_time'=>time(),

//            'sessionkey'=>$sessionkey,

//            'weid'=>$this->weid

//        ];

        $count = pdo_fetchcolumn('select count(*) from ' . tablename($this->member) . " where  weid=" . $this->weid . " and m_openid = '" . $openid . "'");

        if ($count > 0) {

            $res = pdo_update($this->member, $data, array('m_openid' => $openid, 'weid' => $this->weid));

        } else {

            $data['weid'] = $this->weid;

            $data['m_add_time'] = time();

            $res = pdo_insert($this->member, $data);

        }

        if (!empty($res)) {

            $this->result("0", "传入数据成功");

        } else {

            $this->result("1", "传入数据失败,请重试");

        }

    }
    /**
     * 获取商品列表信息
     */
    public function doPagegetGoods(){
        global $_W, $_GPC;
        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        $contion = 'limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;
        //逻辑：商品货号是模糊查询
        $member = pdo_get("gpb_member",array('m_openid'=>$_GPC['openid']));

		if($member['level']){
			$member_card = pdo_get("gpb_member_card",array('id'=>$member['level']));
		}
        $get_num = trim($_GPC['num']);
        $openid = trim($_GPC['openid']);
        if (isset($_GPC['num']) && !empty($get_num)) {
            $where .= " and  g_product_num like '%" . trim($_GPC['num']) . "%' ";
        }
        //逻辑：商品名称是模糊查询
        if (isset($_GPC['title']) and !empty($_GPC['title'])) {
            $where .= " and  g_name like '%" . trim($_GPC['title']) . "%' ";
        }
        //逻辑：商品分类是确定查询
        if (isset($_GPC['pid']) and !empty($_GPC['pid'])) {
            $where .= " and  g_cid = '" . intval($_GPC['pid']) . "' ";
        }
        //逻辑：商品id是确定查询
        $at_id = trim($_GPC['at_id']);
        if (isset($_GPC['gid']) and !empty($_GPC['gid'])) {
            $where .= " and  g_id = '" . intval($_GPC['gid']) . "'";
        }
        if (!empty($at_id) and $at_id != 'undefined') {
            $where .= " and gcg_at_id = " . $at_id;
        }
        if (!empty($at_id) and $at_id != 'undefined') {
            $where .= " and gcg_at_id = " . $at_id;
        }
        if($member['m_is_head'] != 2){
            //不是团长
            $where .= " and  g_is_head_enjoy != 1 ";
        }
        $sql = 'select ag.*,g.*,c.gc_name,c.gc_id,group_concat(s.num) as `sum`,s.sale_num as sum_sale,s.num as `actual` from ' . tablename($this->goods) . " as g left join " . tablename('gpb_goods_to_category') . " as gtc on gtc.`goods_id` = g.`g_id` left join " . tablename($this->goods_cate) . " as c on c.`gc_id`=gtc.`cate_id`  left join " . tablename($this->goods_stock) . " as s on s.goods_id = g.g_id left join " . $this->pre . "gpb_action_goods as ag on ag.gcg_g_id = g.g_id  where g_is_del = 1 and g_is_online = 1 " . $where . " and (g.`type`<>2 or g.`type` is null) and g.weid=" . $this->weid . " group by s.goods_id order by g_is_online desc,g_order asc,g_id desc " . $contion;


        $info = pdo_fetchall($sql);



		$all_order_commission_open = pdo_get($this->config, array('key' => 'all_order_commission_open', 'weid' => $this->weid));

        if (isset($all_order_commission_open['value']) && $all_order_commission_open['value'] == 1) {

        	$all_order_commission_same = pdo_get($this->config, array('key' => 'all_order_commission_same', 'weid' => $this->weid));

			$all_order_commission_same = $all_order_commission_same['value'];

        }

		//判断是否开启了会员卡

		$card_id = pdo_get("gpb_config",array('key'=>'card_id','weid'=>$this->weid),array('value'));

        foreach ($info as $k => $v) {
        	$info[$k]['card_id'] = $card_id['value'];

			//判断是否参与了活动

//			判断活动是否开启了显示

			$configs = pdo_get('gpb_config',array('key'=>'goods_cate_show_type'));

				//判断当前商品是否在当前的活动中

			$o = pdo_fetch('select at_id,at_end_time from '.tablename('gpb_action')." ac join ".tablename('gpb_action_goods')." ag on ac.at_id = ag.gcg_at_id where ag.gcg_g_id = ".$v['g_id']." and ac.at_start_time <= ".time()." and at_end_time > ".time());

			if(empty($o)){



			}else{

				$info[$k]['at_id'] = $o['at_id'];

				$info[$k]['at_end_time'] = $o['at_end_time'];

			}

            $info[$k]['g_icon'] = tomedia($v['g_icon']);

            $info[$k]['g_video'] = tomedia($v['g_video']);

            $info[$k]['g_video_open'] = empty($v['g_video']) ? 0 : 1;

            $info[$k]['priceArry'] = explode('.', $v['g_price']);

            $info[$k]['g_info'] = htmlspecialchars_decode($v['g_info']);

            $info[$k]['g_icon_bak'] = tomedia($v['g_icon_bak']);

            $info[$k]['g_thumb'] = explode(',', $v['g_thumb']);

            $buy_people_limit=9;

            //商品详情页面能否点击进入购买记录页

            $open_see_buypeople_info =  pdo_get($this->config,array('key'=>'open_see_buypeople_info','weid'=>$this->weid));

            if(!isset($open_see_buypeople_info['value'])){

                $buy_people_limit=9;
            }else{
                if($open_see_buypeople_info['value']!=2){
                    $buy_people_limit=9;
                } else {
                    $buy_people_limit=10;
                }
            }
			$buy_people = pdo_fetchall("select DISTINCT m_photo from " . tablename('gpb_order_snapshot') . " as s left join " . tablename('gpb_member') . " as m on m.m_openid =s.oss_buy_openid where s.oss_gid =" . $v['g_id'] . " and m.weid=".$_W['uniacid']." limit 0,".$buy_people_limit);
//var_dump($buy_people_limit);exit;
//          $buy_people_num = pdo_fetchcolumn("select count(*) from (select count(*) from " . tablename($this->snapshot)." as s left join ".tablename($this->member)." as m on m.m_openid =s.oss_buy_openid left join ".tablename("gpb_order")." as o on o.go_code=s.oss_go_code where o.go_status >10 and o.go_status<=100 and  s.oss_gid =" . $v['g_id'] . " and m.weid=" . $this->weid . " group by m_openid ) as temp");
			$buy_people_num = pdo_fetchcolumn("select count(*) from (select count(*) as num from " . tablename($this->snapshot) . " as s left join " . tablename($this->member) . " as m on m.m_openid =s.oss_buy_openid left join " . tablename($this->order) . " as go on s.oss_go_code = go.go_code where m.weid=" . $this->weid . " and go.`type`=1 and s.oss_gid =" . $v['g_id'] . " and go.go_pay_time >0 and m.m_photo is not null group by m_openid) as temp");
//			var_dump($buy_people_num);exit;
            if($v['g_sale_num']>0 && $buy_people_limit>$buy_people_num){
                $short_num = $buy_people_limit-$buy_people_num;
                $short_people = pdo_fetchall("select vu.head as m_photo from ".tablename('gpb_activity_plugin_virtual_buy_list')." as bl left join ".tablename('gpb_activity_plugin_virtual_users')." as vu on bl.virtual_uid=vu.uid where bl.gid=".$v['g_id']." and vu.head is not null order by virtual_buytime desc limit ".$short_num);
                $buy_people = array_merge($buy_people,$short_people);
            }
            if(is_array($buy_people)){

                foreach ($buy_people as $buy_people_k =>$buy_people_v){

                    if(empty($buy_people_v['m_photo'])){

                        $buy_people_v['m_photo'] = '';

                    }elseif(strlen( $buy_people_v['m_photo'])<255){

                        $buy_people_v['m_photo'] = tomedia($buy_people_v['m_photo']);

                    }

                }



            }

            $info[$k]['buy_people'] = $buy_people;

            //9开10不开

            $info[$k]['open_see_buypeople_info'] = $buy_people_limit;

            $info[$k]['buy_people_num'] = $buy_people_num+intval($v['g_virtual_people']);
//          $info[$k]['buy_people_num'] = $buy_people_num+intval($v['g_sale_num']);
            if (!empty($at_id) and $at_id != 'undefined') {

                $action = pdo_fetch("select * from " . tablename($this->action) . " where weid=" . $this->weid ." and at_id=" . $at_id);

                $info[$k]['action'] = $action;

            }

            //获取该用户的当前购物车中的该商品数

            $info[$k]['curGoodsNum'] = 0;

            $info[$k]['isshowbtn'] = 1;

            if (!empty($openid)) {

                $goods_cart = pdo_fetch("select c_count,c_id from " . tablename($this->cart) . " where openid='" . $openid . "' and c_is_del =1 and c_status =1 and c_g_id = " . $v['g_id']);

                if (empty($goods_cart)) {

                    $info[$k]['isshowbtn'] = 1;

                    $info[$k]['curGoodsNum'] = 0;

                    $info[$k]['cart_id'] = 0;

                } else {

                    $info[$k]['isshowbtn'] = 2;

                    $info[$k]['curGoodsNum'] = $goods_cart['c_count'];

                    $info[$k]['cart_id'] = $goods_cart['c_id'];

                }

            }

            //获取库存和销售数量

            foreach ($info[$k]['g_thumb'] as $key => $val) {

                $info[$k]['g_thumb'][$key] = tomedia($val);

            }

            //预计几天后到达

            $info[$k]["arrival_time"] = date("m月d日", (time() + ($info[$k]["g_arrival_time"] * 24 * 60 * 60)));

            $info[$k]['sale_is_over'] = 0;

            if ($info[$k]['g_end_sale_time'] < time()) {

                $info[$k]['sale_is_over'] = 1;

            }

            //读取多规格

            if ($v['g_has_option'] == 1) {

                $info[$k]['spec'] = pdo_getall($this->spec, array('weid' => $this->weid, 'g_id' => $v['g_id']));

                $ids = "";

                foreach ($info[$k]['spec'] as $spec_k => $spec_v) {

                    $ids = ',' . $spec_v['content'];

                    if (!empty($ids)) {

                        $info[$k]['spec'][$spec_k]['spec_item'] = pdo_fetchall("select * from " . tablename($this->spec_item) . " where weid = " . $this->weid . " and gsi_id in (" . trim($ids, ',') . ")");

                    }

                }

                $info[$k]['option'] = pdo_getall($this->goods_option, array('weid' => $this->weid, 'ggo_g_id' => $v['g_id']));

            }

			//获取当前用户的当前商品的会员价格

			$minimum_price = 0;

			if($v['member_card_discount'] != 1 && !empty($member['level']) && !empty($v['member_card_discount'])){

				if($v['member_card_discount'] == 2){

					//单价格

					$discount_unified = pdo_fetch("select price from ".tablename("gpb_goods_dicount_unified")." where goods_id = ".$v['g_id']." and card = ".$member['level']." and weid = ".$this->weid);

					if($discount_unified['price']){

						$info[$k]['dicount_unified'] = "￥".(number_format($discount_unified['price']/100, 2, '.', ''));

						$info[$k]['g_price'] = $v['g_price'];//原价

					} else {

//						下面这种情况 是发生在用户开启的会员价  但是有没有设置会员价格  就根据平台的统一配置来

						//判断商品是否是多规格

						if($v['g_has_option'] == 1){

							$iso = pdo_fetch("select max(ggo_market_price) as max_price,min(ggo_market_price) as min_price from ".tablename("gpb_goods_option")." where weid = ".$this->weid." and ggo_g_id = ".$v['g_id']);

							$card = pdo_get('gpb_member_card',array('id'=>$member['level']),array('id','discount'));

							$info[$k]['dicount_unified'] = number_format($iso['min_price']*($card['discount']/10), 2, '.', '');

							$info[$k]['g_price'] = $v['g_price'];//原价

						}else{

							$info[$k]['dicount_unified'] = "￥".(number_format($v['g_price']*($member_card['discount']/10), 2, '.', ''));

							$info[$k]['g_price'] = $v['g_price'];//原价

						}

					}

				}else if($v['member_card_discount'] == 3){

					//多规格

					//获取最大的和最小的两个价格

					$detailed = pdo_fetch(" select max(price) as max_price,min(price) as min_price from ".tablename('gpb_goods_discount_detailed')." where goods_id = ".$v['g_id']." and weid = ".$this->weid." and caid = ".$member['level']);

					if($detailed['min_price'] || $detailed['max_price']){

						$info[$k]['dicount_unified'] = number_format($detailed['min_price']/100, 2, '.', '');

						$info[$k]['g_price'] = $v['g_price'];//原价

					}else{

						//获取最大和最小的价格

						$iso = pdo_fetch("select max(ggo_market_price) as max_price,min(ggo_market_price) as min_price from ".tablename("gpb_goods_option")." where weid = ".$this->weid." and ggo_g_id = ".$v['g_id']);

						$info[$k]['dicount_unified'] = number_format($iso['min_price']*($member_card['discount']/10), 2, '.', '');

						$info[$k]['g_price'] = $iso['min_price'];//原价

					}

				}

			} else {

				//判断用户是否需要执行平台统一折扣

				if(!empty($member['level'])){

					$card = pdo_get('gpb_member_card',array('id'=>$member['level']),array('id','discount'));

					if($v['g_has_option'] == 1){

						$iso = pdo_fetch("select max(ggo_market_price) as max_price,min(ggo_market_price) as min_price from ".tablename("gpb_goods_option")." where weid = ".$this->weid." and ggo_g_id = ".$v['g_id']);

						$info[$k]['dicount_unified'] = number_format($iso['min_price']*($card['discount']/10), 2, '.', '');

						$info[$k]['g_price'] = $iso['min_price'];

					} else {

						$info[$k]['dicount_unified'] = "￥".(number_format($v['g_price']*($card['discount']/10), 2, '.', ''));

						$info[$k]['g_price'] = $v['g_price'];

					}

				} else {

					if($v['g_has_option'] == 1) {

						$is = pdo_fetch(" select max(ggo_market_price) as max_price,min(ggo_market_price) as min_price from ".tablename('gpb_goods_option')." where ggo_g_id = ".$v['g_id']." and weid = ".$this->weid);

						$info[$k]['g_price'] = number_format($is['min_price'], 2, '.', '');

//						$info[$k]['g_price'] = "￥".(number_format($is['min_price'], 2, '.', ''))."~￥".(number_format($is['max_price'], 2, '.', ''));

					} else {

						$info[$k]['g_price'] = $v['g_price'];

					}

				}

			}

			$discount = pdo_fetch("select min(discount) as discount from ".tablename('gpb_member_card')." where weid = ".$this->weid." and status = 1");

			if($v['g_has_option'] == 1){

				//多规格

				if($v['member_card_discount'] == 2){

					$minmis = pdo_fetch("select min(price) as price from ".tablename('gpb_goods_dicount_unified')." where goods_id = ".$v['g_id']." and weid = ".$this->weid);

					if($minmis['price']){

						$minimum_price = $minmis['price'];

					}else{

						$is = pdo_fetch(" select min(g_price) as price from ".tablename('gpb_goods')." where g_id = ".$v['g_id']." and weid = ".$this->weid);

						if($discount){

							$minimum_price = $is['price']*$discount['discount']/10;

						}else{

							$minimum_price = $is['price'];

						}

					}

				}else if($v['member_card_discount'] == 3){

					$minmis = pdo_fetch("select min(price) as price from ".tablename('gpb_goods_discount_detailed')." where goods_id = ".$v['g_id']." and price != 0 and weid = ".$this->weid);

					if($minmis['price']){

						$minimum_price = $minmis['price']/100;

					}else{

						$is = pdo_fetch(" select min(ggo_market_price) as price from ".tablename('gpb_goods_option')." where ggo_g_id = ".$v['g_id']." and weid = ".$this->weid);

						if($discount){

							$minimum_price = $is['price']*$discount['discount']/10;

						}else{

							$minimum_price = $is['price'];

						}

					}

				}else{

					//按照平台最低折扣来

					$is = pdo_fetch(" select min(ggo_market_price) as price from ".tablename('gpb_goods_option')." where ggo_g_id = ".$v['g_id']." and weid = ".$this->weid);

					if($discount){

						$minimum_price = $is['price']*$discount['discount']/10;

					}else{

						$minimum_price = $is['price'];

					}

				}

			} else {

				//单规格

				if($v['member_card_discount'] == 2){

					$minmis = pdo_fetch("select min(price) as price from ".tablename('gpb_goods_dicount_unified')." where goods_id = ".$v['g_id']." and weid = ".$this->weid);

					if($minmis['price']){

						$minimum_price = $minmis['price']/100;

					}else{

						$is = pdo_fetch(" select min(g_price) as price from ".tablename('gpb_goods')." where g_id = ".$v['g_id']." and weid = ".$this->weid);

						if($discount){

							$minimum_price = $is['price']*$discount['discount']/10;

						}else{

							$minimum_price = $is['price'];

						}

					}

				}else{

					$is = pdo_fetch(" select min(g_price) as price from ".tablename('gpb_goods')." where g_id = ".$v['g_id']." and weid = ".$this->weid);

					if($discount){

						$minimum_price = $is['price']*$discount['discount']/10;

					}else{

						$minimum_price = $is['price'];

					}

				}

			}

			$info[$k]['minimum_price'] = number_format($minimum_price, 2, '.', '');

			if($all_order_commission_same){

				$info[$k]['commission_goods'] = $all_order_commission_same;

			} else {

				if($v['g_has_option'] == 1){

					$is = pdo_fetch(" select max(ggo_market_price) as max_price,min(ggo_market_price) as min_price from ".tablename('gpb_goods_option')." where ggo_g_id = ".$v['g_id']." and weid = ".$this->weid);

					$info[$k]['commission_goods_top']  = $is['min_price']*$v['g_commission']/100 <= 0.01 ? 0 : number_format($is['min_price']*$v['g_commission']/100, 2, '.', '');



					$info[$k]['commission_goods_botton']  = $is['max_price']*$v['g_commission']/100 <= 0.01 ? 0 : (number_format($is['max_price']*$v['g_commission']/100, 2, '.', ''));

				} else {

					$info[$k]['commission_goods_top']  = $v['g_price']*$v['g_commission']/100;

					$info[$k]['commission_goods_botton']  = 0;

				}

			}

			//判断是否是砍价商品

			if(file_exists('../addons/group_buy_plugin_bargain/hook.php')){
				$bargaion = pdo_fetch("select id from ".tablename('gpb_bargaion_goods')." where status_time <= ".time()." and end_time > ".time()." and g_id = ".$v['g_id']." and weid = ".$this->weid);
				$info[$k]['bargaion'] = $bargaion ? true : false;
				$info[$k]['bargaion_id'] = $bargaion['id'];
				if($bargaion){
					$time = time();
					$where = " and bg.status_time < ".$time." and bg.end_time > ".$time;
					$after_goods = pdo_fetch("select bg.id,ba.status as ba_status from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id left join ".tablename('gpb_bargain_action')." ba on ba.action_goods = bg.id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and st.num > 0 and bg.status = 1 and ba.status < 3  and ba.id > 0 ".$where." and bg.id = ".$bargaion['id']." and ba.openid = '".$openid."'");//这个是当前用户正在砍价的商品或者是已经砍价完成的商品
					$str = '';
					//下面这个循环是根据用户 判断当前用户的状态是也砍价 在砍价  等  ，并且判断商品是否在活动中  在活动中就获取活动上id和活动的结束时间 并且将砍价中的商品  中的也砍价商品id取出
					if($after_goods){
						$str = $after_goods['id'];
					}
					//获取当前用户没有砍价的商品
					if($str){
						$gpb_bargaion_goods = pdo_fetch("select bg.id,g.g_id,g.g_name,g.g_price,bg.end_time,bg.end_price,bg.price_cutting_times,bg.low_price,st.num from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where bg.id not in (".$str.") and g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 ".$where);

					} else {
						$gpb_bargaion_goods = pdo_fetch("select bg.id,g.g_id,g.g_name,g.g_price,bg.end_time,bg.end_price,bg.price_cutting_times,bg.low_price,st.num from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 ".$where);
					}
					if($after_goods && $after_goods['ba_status'] != 3){
						$gpb_bargaion_goods['action_status'] = 2;
					}else if($after_goods['ba_status'] == 3 && $after_goods['price_cutting_times'] == 1){
						$gpb_bargaion_goods['action_status'] = 3;
					}else if($after_goods['ba_status'] == 3 && $after_goods['price_cutting_times'] != 1){
						$gpb_bargaion_goods['action_status'] = 1;
					}
					$action = pdo_fetch("select a.id from ".tablename('gpb_bargain_action')." a join ".tablename('gpb_bargaion_goods')." g on a.action_goods = g.id where a.goods_id = :gid and a.openid = '".$openid."' and (a.status = -1 or a.status = 2) order by id desc",array(':gid'=>$v['g_id']));
					if($action){
						$gpb_bargaion_goods['bargaion_id'] = $action['id'];
						$info[$k]['bargaion_id'] = $action['id'];
					}
					$info[$k]['gpb_bargaion_goods'] = $gpb_bargaion_goods;
				}
			} else {
				$info[$k]['bargaion'] = false;
			}
        }
//		if($openid == 'oLf4B0bm-0PiHMtR1ycmWARlcTTU'){
//			echo '<pre>';
//			var_dump($info);exit;
//		}
        if (empty($info)) {
            $this->result("1", "查询失败，暂无数据", $sql);
        } else {
        	if($_GPC['sekill']){
        		echo json_encode(array('errno'=>0,'message'=>'查询成功','data'=>$info,'sekill'=>$_GPC['sekill']));exit;
        	}else{
	            $this->result("0", "查询商品成功", $info);
        	}
        }
        exit;
    }



    /**
     * 获取商品详情页配置
     */
    public function doPagegetGoodsInfoSet()
    {
        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (!isset($openid) || empty($openid) || $openid == 'undefined') {

            $this->result("1", "未授权");

        }

        //读取商品详情页设置

        $config = pdo_getall($this->config, array('status' => 1, 'type' => 10, 'weid' => $this->weid), array(), "key");

        if (!empty($config)) {

            if (empty($config['goods_info_action_price_bg']['value'])) {

                $config['goods_info_action_price_bg']['value'] = tomedia("/addons/group_buy/public/bg/goods_bg.png");

            } else {

                $config['goods_info_action_price_bg']['value'] = tomedia($config['goods_info_action_price_bg']['value']);

            }

        } else {

            $config['goods_info_action_price_bg']['value'] = tomedia("/addons/group_buy/public/bg/goods_bg.png");

        }

        $info['config'] = $config;

        //商品详情页微信分享的背景图

        $goods_info_share_bg = pdo_get($this->config, array('key' => 'goods_info_share_bg', 'weid' => $this->weid));

        $info['share_img'] = (isset($goods_info_share_bg['value']) && !empty($goods_info_share_bg['value'])) ? tomedia($goods_info_share_bg['value']) : tomedia('/addons/group_buy/public/bg/goods_info_share_bg.jpg');



        //商品详情页微信分享的背景图

        $goods_info_playbill_bg = pdo_get($this->config, array('key' => 'goods_info_playbill_bg', 'weid' => $this->weid));

        $info['share_playbill_img'] = (isset($goods_info_playbill_bg['value']) && !empty($goods_info_playbill_bg['value'])) ? tomedia($goods_info_playbill_bg['value']) : tomedia('/addons/group_buy/public/bg/goods_info_playbill_bg.jpg');

        if (empty($config)) {

            $this->result("1", "查询失败，暂无数据");

        } else {

            $this->result("0", "查询成功", $info);

        }

    }



    /*
     * 获取活动信息
     */
    public function doPagegetAction(){
        global $_W, $_GPC;
        $at_id = intval($_GPC['at_id']);
        if (empty($at_id)) {
            $this->result("1", "查询失败，请传入活动at_id");
        }
        $sql = "select * from " . tablename($this->action) . " where weid = " . $this->weid . " and at_id= " . $at_id . " and at_is_del= 1";
        $res = pdo_fetch($sql);
        $res["arrival_time"] = date("m月d日", (time() + ($res["at_arrival_time"] * 24 * 60 * 60)));
        if (empty($res)) {
            $this->result("1", "查询失败，暂无数据");
        } else {
            $this->result("0", "查询成功", $res);
        }
    }
    /*
     * 获取活动商品
     */
//  public function doPagegetActionGoods(){}
    /*
     * 由商品id查询全部购买人
     */
    public function doPagegetAllBuyPeople()

    {

        global $_W, $_GPC;

        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 10;

        $contion = ' limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;

        $gid = trim($_GPC['gid']);

        if (empty($gid)) {

            $this->result("1", "请传入商品id");

        }

//        $this->generate_virtual_sales_data($gid);

        $count = pdo_fetchcolumn("select count(*) from " . tablename($this->snapshot) . " as s left join " . tablename($this->member) . " as m on m.m_openid =s.oss_buy_openid left join " . tablename($this->order) . " as go on s.oss_go_code = go.go_code where m.weid=" . $this->weid . " and go.`type`=1 and s.oss_gid =" . $gid . " and go.go_pay_time >0 and m.m_photo is not null group by m_openid");

        $sql = "select *,sum(oss_g_num) as num from " . tablename($this->snapshot) . " as s left join " . tablename($this->member) . " as m on m.m_openid =s.oss_buy_openid left join " . tablename($this->order) . " as go on s.oss_go_code = go.go_code where m.weid=" . $this->weid . " and go.`type`=1 and s.oss_gid =" . $gid . " and go.go_pay_time >0 and m.m_photo is not null group by m_openid order by oss_id desc " . $contion;

        $res = pdo_fetchall($sql);

        foreach ($res as $k => $v) {

            $res[$k]["go_add_time"] = date("Y-m-d", $v['go_add_time']);

            if($this->check_base64_out_json( $v['m_nickname'] )){

                $res[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );

            }

        }

        if (!empty($res)) {

            $this->result("0", "查询成功", $res);

        } else {

            //当真实数据读取完了后来读取虚拟数据

            $start = ceil($count / $pageSize);

			$num = ($pageIndex - $start - 1);

			$num = $num < 0 ? 0 : $num;

            $contion = ' limit ' .$num* $pageSize . ',' . $pageSize;

            $sql = "select virtual_buytime as go_add_time,`name` as m_nickname,phone,head as m_photo,virtual_sale as num from " . tablename('gpb_activity_plugin_virtual_buy_list') . " as bl left join " . tablename('gpb_activity_plugin_virtual_users') . " as vu on bl.virtual_uid=vu.uid where gid=" . $gid . " order by virtual_buytime desc " . $contion;

            $res = pdo_fetchall($sql);

            if (is_array($res)) {

                foreach ($res as $k => $v) {

                    if (empty($v['m_photo'])) {

                        $res[$k]['m_photo'] = '';

                    } elseif (strlen($v['m_photo']) < 255) {

                        $res[$k]['m_photo'] = tomedia($v['m_photo']);

                    }

                    if(empty($v['m_nickname'])){

                        $len = rand(1,8);

                        $res[$k]['m_nickname'] = $this->randStr($len);

                    }

                    $res[$k]["go_add_time"] = date("Y-m-d", $v['go_add_time']);

                }



            }
            if (!empty($res)) {
                $this->result("0", "查询成功", $res);
            }else{
                $this->result("1", "暂无更多数据");
            }
        }
    }
    /**
     * 申请当团长
     */
//  public function doPagewantHead(){}
    /**
     * 下订单qorder
     */
//  public function doPageOrder(){}
    /*
     * 打印订单
     *  int $go_code 订单号
     */
    public function order_print($go_code = '')
    {
        if (empty($go_code)) {
            return;
        }
        //查看是否开启自动订单打印
        $order_print_auto_open = pdo_get($this->config, array('key' => 'order_print_auto_open', 'weid' => $this->weid));
        $order_print_auto_open_val = isset($order_print_auto_open['value']) ? $order_print_auto_open['value'] : 2;
        $order_print_auto_num = pdo_get($this->config, array('key' => 'order_print_auto_num', 'weid' => $this->weid));
        $order_print_auto_num_val = isset($order_print_auto_num['value']) ? $order_print_auto_num['value'] : 1;
        if ($order_print_auto_open_val == 1) {
            //开启
            //查询打印机配置
            $print_set = pdo_get($this->config, array('key' => 'print_set', 'weid' => $this->weid));
            $config = unserialize($print_set['value']);
            if (empty($config) || count($config) <= 0) {
//                                echo json_encode(array('status'=>1,'msg'=>'请在配置中设置打印机'));exit;
            } else {
                //调用打印机类
                $print_class = new print_sn();
                //查询打印机状态
                $res_select = $print_class->select_print($config['print_sn']);
                if ($res_select["ret"] !== 0 || $res_select["data"] == '离线。') {
//                                    echo json_encode(array('status'=>1,'msg'=>$res_select['msg'].','.$res_select['data']));exit;
                } else {
                    $goods = array();
                    $order = pdo_fetchall("select * from " . tablename($this->order) . " as o left join " . tablename($this->snapshot) . " as sn on sn.oss_go_code = o.go_code left join " . tablename($this->vg) . " as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=" . $go_code . " and o.weid=" . $this->weid);
                    foreach ($order as $k => $v_order) {
                        $goods[$k]['title'] = $v_order['oss_g_name'];
                        $goods[$k]['price'] = $v_order['oss_g_price'];
                        $goods[$k]['num'] = $v_order['oss_g_num'];
                        $goods[$k]['spec'] = trim($v_order['oss_ggo_title']);
                    }
                    $adr = $order[0]['vg_address'];
                    if (!empty($order[0]['oss_address']) && $order[0]['oss_address'] != 'undefined') {
                        $adr = $order[0]['oss_address'];
                    }

                    $lead_info = array(

                        'name' => $order[0]['oss_head_name'],

                        'phone' => $order[0]['oss_head_phone'],

                    );

                    $reduce_price = 0;

                    if ($order[0]['go_fdc_price'] > 0) {
                        $reduce_price += $order[0]['go_fdc_price'];
                    }
                    if ($order[0]['go_full_reduce_price'] > 0) {
                        $reduce_price += $order[0]['go_full_reduce_price'];
                    }
                    $send_price = 0;
                    if ($order[0]['go_send_pay'] > 0) {
                        $send_price += $order[0]['go_send_pay'];
                    }
                    switch ($order[0]['go_send_type']) {
                        case '1':
                            $send_type = '自提';
                            break;
                        case '2':
                            $send_type = '团长送货';
                            break;
                        case '3':
                            $send_type = '快递';
                            break;
                        default:
                            $send_type = '自提';
                            break;
                    }
                    switch ($order[0]['go_pay_type']) {
                        case '1':
                            $pay_type = '微信支付';
                            break;
                        case '2':
                            $pay_type = '余额支付';
                            break;
                        case '3':
                            $pay_type = '余额+微信支付';
                            break;
                        default:
                            $pay_type = '微信支付';
                            break;
                    }
                    if($this->check_base64_out_json($order[0]['oss_address_name'])){
                        $order[0]['oss_address_name']= base64_decode($order[0]['oss_address_name']);
                    }
                    $res = $print_class->print_info($config['print_sn'], $go_code, $order[0]['oss_v_name'], $goods, $adr, $order[0]['oss_address_phone'], $order[0]['oss_address_name'], $order[0]['go_real_price'], $lead_info, $order[0]['go_comment'] = '', $qrcode = '', $order[0]['go_add_time'], '', $pay_type, $order_print_auto_num_val, $reduce_price, $send_price, $send_type);
					sleep(1);
                }
            }
        }
        return;
    }

    /*
     * 立即购买下单
     */
//	public function dopagebuyIntimeOrder(){
//
//  }
    /**
     * 获取团长
     */
    public function doPageGetHead(){
        global $_GPC;
        $limit = intval($_GPC['limit']) ? intval($_GPC['limit']) : 1;//请求个数
        $where = " ";
        $openid = trim($_GPC['openid']);
        if (!empty($openid)) {
            $where .= " and openid = '" . $openid . "'";
        }
        $name = trim($_GPC['name']);
        if (!empty($name)) {
            $where .= " and (m_name = '" . $name . "' or m_nickname = '" . $name . "' or vg_name = '" . $name . "') ";
        }
        $village = trim($_GPC['village']);
        $where .= " limit " . $limit;
        $sql = "select * from " . tablename($this->member) . " as m left join " . tablename($this->vg) . " as vg on vg.openid = m.m_openid where m.weid=" . $this->weid . " and m_is_head = 2 and m_status = 1" . $where;
        $info = pdo_fetchall($sql);
        foreach($info as $k=>$v){
            if($this->check_base64_out_json($v['m_nickname'])){
                $info[$k]=base64_decode($v['m_nickname']);
            }
        }
        if (empty($info)) {
            $this->result("1", "查询失败，暂无数据");
        } else {
            $this->result("0", "查询团长成功", $info);
        }
        exit;
    }
    /**
     *计算某个经纬度的周围某段距离的正方形的四个点
     *
     * @param lng float 经度
     * @param lat float 纬度
     * @param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
     * @return array 正方形的四个点的经纬度坐标
     */
    protected function returnSquarePoint($lng, $lat, $distance = 0.5)
    {
        $dlng = 2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));

        $dlng = rad2deg($dlng);



        $dlat = $distance / EARTH_RADIUS;

        $dlat = rad2deg($dlat);

        return array(

            'left-top' => array('lat' => $lat + $dlat, 'lng' => $lng - $dlng),

            'right-top' => array('lat' => $lat + $dlat, 'lng' => $lng + $dlng),

            'left-bottom' => array('lat' => $lat - $dlat, 'lng' => $lng - $dlng),

            'right-bottom' => array('lat' => $lat - $dlat, 'lng' => $lng + $dlng)

        );

    }



    /**

     * @desc 根据两点间的经纬度计算距离

     * @param float $lat 纬度值

     * @param float $lng 经度值

     */

    protected function getDistance($lat1, $lng1, $lat2, $lng2){
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
     * 获取最近的团长信息
     */
//  public function doPagegetNearestHead(){
//
//  }



    /**

     * 获取小区名搜索信息

     */

    public function doPageGetVillageInfo()

    {

        global $_GPC;

        $cid = trim($_GPC['cid']);

        $city = trim($_GPC['city']);

        $key = trim($_GPC['key']);

        $lng = trim($_GPC['lng']);

        $lat = trim($_GPC['lat']);

        if (empty($cid)) {

            $this->result("1", "请传入城市");

        }

        if (empty($key)) {

            $this->result("1", "请传入小区名");

        }

        if (empty($lat) || empty($lng)) {

            $this->result("1", "请传入用户定位的经纬度");

        }

        $sql = "select * from " . tablename($this->vg) . " as vg join " . tablename($this->rg) . " as rg on vg.vg_rg_id = rg.rg_id left join  " . tablename($this->member) . " as m on vg.openid = m.m_openid left join " . $this->pre . "gpb_area as a on a.ad_code = rg.rg_city_id where m.weid=" . $this->weid . " and m_is_head = 2 and m_status = 1 and vg.vg_id>0 and a.id = " . $cid . " and vg.vg_name like '%" . $key . "%'";

        $info = pdo_fetchall($sql);

        foreach ($info as $k => $v) {

            $info[$k]['m'] = $this->getDistance($lat, $lng, $v['vg_latitude'], $v['vg_longitude']) / 1000;

            if($this->check_base64_out_json( $v['m_nickname'] )){

                $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );

            }

        }

        $m = array_column($info, 'm');//先用array_column 多维数组按照纵向（列）取出

        array_multisort($m, SORT_ASC, $info);//再用array_multisort  结合array_column得到的结果对$arr进行排序

        if (empty($info)) {

            $this->result("1", "查询失败，暂无数据");

        } else {

            $this->result("0", "查询小区成功", $info);

        }

        exit;

    }



    /*

     * 选择团长

     */

    public function doPageselectHead(){
        global $_GPC;
        $openid = trim($_GPC['openid']);

        $head_openid = trim($_GPC['head_openid']);

        if (empty($openid) || empty($head_openid) || $openid == "undefined" || $head_openid == 'undefined') {

            $this->result("1", "未授权");

        }

        $info = pdo_get($this->member, ['m_openid' => $openid, 'weid' => $this->weid]);

        if ($info['m_head_openid'] != $head_openid) {

            $data = [

                "m_head_openid" => $head_openid,

                "weid" => $this->weid

            ];

            $res = pdo_update($this->member, $data, ['m_openid' => $openid]);

            if (empty($res)) {

                $this->result("1", "选择团长失败");

            }

        }



        $res = pdo_get($this->member, ['m_openid' => $head_openid, 'weid' => $this->weid]);//返回团长信息可以存前端缓存备用

//      if(empty($res)){

//      	$this->result("1", "团长不存在");

//      }

		if(!empty($res)){

	        if($this->check_base64_out_json( $res['m_nickname'] )){

	            $res['m_nickname'] = base64_decode( $res['m_nickname'] );

	        }

		}

        $res['checked'] = true;

        if (empty($res)) {

            pdo_update($this->member, ["m_head_openid" => ''], ['m_openid' => $openid, 'weid' => $this->weid]);

            $this->result("1", "选择团长信息失败");

        } else {

//      	if($openid == 'otEnX5aRuT43g9tfP5FPgcxtXgeI'){

				//存入文件当中

				$filename = "../addons/group_buy/public/".$openid.".txt";

				if(file_exists($filename)){

					//文件存在  修改

					$myfile = fopen($filename,'a');

				}else{

					$myfile = fopen($filename,'w');

				}

				$string = date('Y-m-d H:i:s',time())."更改自己上面的团长为:".$res['m_nickname'].".自己的openid为：".$openid.",团长的openid:".$head_openid."接口来自:selectHead"."\r\n";

				fwrite($myfile, $string);

				fclose($myfile);

//			}

            //将选择团长的操作记录在历史记录表内

//          $old = pdo_get($this->head_history, array('hh_head_openid' => $head_openid, 'openid' => $openid));

//          if (!empty($old)) {

//              $r = pdo_update($this->head_history, array('hh_head_openid' => $head_openid, 'hh_last_time' => time()), array("hh_id" => $old['hh_id'], 'weid' => $this->weid));

//          } else {

                $data_in = array(

                    'hh_head_openid' => $head_openid,

                    'openid' => $openid,

                    'weid' => $this->weid,

                    'hh_add_time' => time(),

                    'hh_last_time' => time()

                );

                $r = pdo_insert($this->head_history, $data_in);

//          }

            $this->result("0", "选择团长成功", $res);

        }

    }



    /**

     * 分享用户自动关联团长

     */

    public function doPageselectShareHead()

    {

        global $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "请传入openid");

        }

        $share_mid = trim($_GPC['head_mid']);

        if (empty($share_mid)) {

            $this->result("1", "请传入团长信息");

        }



        $head = pdo_get($this->member, array('m_id' => $share_mid, 'weid' => $this->weid));

        if (empty($head)) {

            $this->result("1", "团长信息错误");

        }

        $user = pdo_get($this->member, array('m_openid' => $openid, 'weid' => $this->weid));

        if (empty($user)) {

            $this->result("1", "用户信息错误");

        }

        if ($user['m_head_openid'] != $head['m_openid']) {

            $data = [

                "m_head_openid" => $head['m_openid'],

                "weid" => $this->weid

            ];

            $res = pdo_update($this->member, $data, array('m_openid' => $user['m_openid']));

            if (empty($res)) {

                $this->result("1", "选择团长失败.");

            }

        }

        $head['checked'] = true;

        if (empty($head)) {

            $this->result("1", "选择团长失败");

        } else {

        	if($openid == 'otEnX5aRuT43g9tfP5FPgcxtXgeI'){

				//存入文件当中

				$filename = "../addons/group_buy/public/".$openid.".txt";

				if(file_exists($filename)){

					//文件存在  修改

					$myfile = fopen($filename,'a');

				} else {

					$myfile = fopen($filename,'w');

				}

				$string = date('Y-m-d H:i:s',time())."更改自己上面的团长为:".$head['m_nickname'].".自己的openid为：".$openid.",团长的openid:".$share_mid."接口来自:selectShareHead"."\r\n";

				fwrite($myfile, $string);

				fclose($myfile);

			}

            //将选择团长的操作记录在历史记录表内

//          $old = pdo_get($this->head_history, array('hh_head_openid' => $head['m_openid'], 'openid' => $user['m_openid']));

//          if (!empty($old)) {

//              pdo_update($this->head_history, array('hh_head_openid' => $head['m_openid'], 'hh_last_time' => time()), array("hh_id" => $old['hh_id'], 'weid' => $this->weid,'type'=>2));

//          } else {

                $data_in = array(

                    'hh_head_openid' => $head['m_openid'],

                    'openid' => $user['m_openid'],

                    'weid' => $this->weid,

                    'hh_add_time' => time(),

                    'hh_last_time' => time(),

                    'type'=>2,

                );

                pdo_insert($this->head_history, $data_in);

//          }

            if($this->check_base64_out_json( $head['m_nickname'] )){

                $head['m_nickname'] = base64_decode( $head['m_nickname'] );

            }

            $this->result("0", "选择团长成功", $head);

        }

    }

    //订单相关

    /*

     * 添加购物车

     */

    public function doPageaddCart()

    {

        global $_W, $_GPC;

        $num = $_GPC['num'];//数量

        $openid = trim($_GPC['openid']);

        $gid = $_GPC['gid'];//商品id

        $at_id = $_GPC['at_id'];//活动id

        if (empty($num)) {

            $this->result("1", "请传入商品数量");

        }

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        if (empty($gid)) {

            $this->result("1", "请传入商品id");

        }

        $goods = pdo_fetch("select * from " . tablename($this->goods) . " as g where g_id = " . $gid . " and (g.`type`<>2 or g.`type` is null) and weid =" . $this->weid);

		if (!empty($goods['g_limit_num']) and $num > $goods['g_limit_num']) {

            $this->result("1", "抱歉单次限购" . $goods['g_limit_num']) . "件";

        }

        $stock = pdo_fetch("select * from " . tablename($this->goods_stock) . " where weid=" . $this->weid . " and goods_id=" . $gid);

        if ($stock['num'] <= 0) {

            $this->result("1", "商品已售罄");

        }

        $count_sql = "select * from " . tablename($this->cart) . " where openid='" . $openid . "' and weid =" . $this->weid . " and c_g_id = " . $gid . " and c_status=1 and c_is_del = 1";

        $info = pdo_fetchall($count_sql);

        if (count($info) > 0) {

        	if($goods['g_has_option'] == 1){

				//开启多规格  判断多规格的商品库存是否足够

				$goods_option = pdo_get("gpb_goods_option",array('ggo_id'=>$info[0]['c_ggo_id']));

				if(empty($goods_option)){

					$this->result("1", "该规格不存在");

				}

				//已经有购物车了

				$nus = $info[0]['c_count']+$num;

				if($nus > $goods_option['ggo_stock'] && $goods_option['ggo_stock'] != -1){

					$this->result("1", "库存不足，无法添加!");

				}

			}

            if (($info[0]['c_count'] + $num) <= $goods['g_limit_num'] || $goods['g_limit_num'] <= 0) {

                $data = [

                    'c_count ' => $info[0]['c_count'] + $num,

                ];

                $res = pdo_update($this->cart, $data, ['openid' => $openid, 'c_g_id' => $gid, 'c_status' => 1, 'c_is_del' => 1, 'weid' => $this->weid]);

            } else {

                $res = 1;

            }



            $id = pdo_get($this->cart, ['openid' => $openid, 'c_g_id' => $gid, 'c_status' => 1, 'c_is_del' => 1, 'weid' => $this->weid]);

//          $count_sql = "select sum(c_count) from " . tablename($this->cart) . " where openid = '" . $openid . "'  and c_status=1 and c_is_del = 1";

			$count_sql = "select sum(c_count) from ".tablename($this->cart)." c left join ".tablename('gpb_goods')." g on c.c_g_id = g.g_id where c.openid = '" . $openid . "' and c.weid =" . $this->weid . " and c.c_status=1 and c.c_is_del = 1 and g.g_is_online = 1 and g.g_is_del = 1";

            $count = pdo_fetchcolumn($count_sql);



            if (!empty($res)) {

                $this->result("0", "新增购物车成功", array('count' => $count, 'id' => $id['c_id']));

            } else {

                $this->result("1", "参数错误", ['openid' => $openid, 'c_g_id' => $gid, 'c_status' => 1, 'c_is_del' => 1, 'res' => $res]);

            }

        } else {

            if (!empty($num) and !empty($gid)) {

                $data = [

                    'c_g_id' => trim($gid),

                    'c_count' => trim($num),

                    'c_at_id' => trim($at_id),

                    'openid' => $openid,

                    'c_add_time' => time(),

                    'weid' => $this->weid

                ];

                $res = pdo_insert($this->cart, $data);

                $id = pdo_insertid();

            } else {

                $this->result("1", "参数错误");

            }

            if (!empty($res)) {

                $count_sql = "select sum(c_count) from ".tablename($this->cart)." c left join ".tablename('gpb_goods')." g on c.c_g_id = g.g_id where c.openid = '" . $openid . "' and c.weid =" . $this->weid . " and c.c_status=1 and c.c_is_del = 1 and g.g_is_online = 1 and g.g_is_del = 1";

                $count = pdo_fetchcolumn($count_sql);

                $this->result("0", "添加购物车成功", array('count' => $count, 'id' => $id));

            }

        }





    }



    /*

     * 查询最近下单的数据，展示

     */

    public function doPageshowLastOrder()

    {

        global $_GPC;

        $limit = intval($_GPC['limit']);

        $limit = empty($limit) ? 20 : $limit;//默认20条

        $sql = "select * from " . tablename($this->order) . " where weid=" . $this->weid . " and `type`=1 and go_is_del = 1 and type =1 order by go_id desc limit " . $limit;

        $res = pdo_fetchall($sql);

        if (empty($res)) {

            $this->$this->result("1", "查询最近下单失败");

        } else {

            $this->result("0", "查询最近下单成功", $res);

        }

    }



    /*

    * 修改购物车数量

    */

    public function doPageeditCartNum()

    {

        global $_GPC;

        $num = trim($_GPC['num']);

        $id = trim($_GPC['id']);

        $act = trim($_GPC['act']);

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        $num = intval($num);

        if (empty($num)) {

            $this->result("1", "请正确输入购物车数量");

        }

        if (empty($id)) {

            $this->result("1", "请传入购物车id");

        }

        if ($act == 'up') {

            $cart = pdo_get($this->cart, array("c_id" => $id, "weid" => $this->weid));

            $goods = pdo_fetch("select * from " . tablename($this->goods) . " as g where g_id = " . $cart['c_g_id'] . " and (g.`type`<>2 or g.`type` is null) and weid =" . $this->weid);

            if (!empty($goods['g_limit_num']) and $num > $goods['g_limit_num']) {

                $this->result("1", "商品单次购买限制数量为" . $goods['g_limit_num'], $goods['g_limit_num']);

            }

			//判断库存是否足够  多规格判断库存

			if($goods['g_has_option'] == 1){

				//获取多规格的库存

				$ggo_get = pdo_get("gpb_goods_option",array('ggo_id'=>$cart['c_ggo_id']));

				if($ggo_get['ggo_stock'] <= 0){

					$this->result("1", "库存不足");

				}

				if($num > $ggo_get['ggo_stock']){

					$this->result("1", "商品库存不足");

				}

			}

        }



        $res = pdo_update($this->cart, ['c_count' => $num], ['c_id' => $id, 'weid' => $this->weid]);

        if (!empty($res)) {

            $sql = "select sum(c_count) from " . tablename($this->cart) . " c left join ".tablename('gpb_goods')." g on c.c_g_id = g.g_id where c.weid= " . $this->weid . " and c.openid='" . $openid . "' and c.c_status=1 and c.c_is_del = 1 and g.g_is_online = 1 and g.g_is_del = 1";

            $res = pdo_fetchcolumn($sql);

            $this->result("0", "购物车数量改变成功", $res);

        } else {

            $this->result("1", "你的操作太频繁了!!");

        }

    }



    /*

     * 删除购物车中数据

     */

    public function doPagecartGoodsDel()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "请传入openid");

        }

        $id = intval($_GPC['id']);

        $ids = $_GPC['ids'];

        if (empty($id) && empty($ids)) {

            $this->result("1", "请传入购物车id");

        }

        if (!is_array($ids)) {

            $ids = trim($ids, ',');

            $ids_arr = explode(',', $ids);

        } else {

            $ids_arr = $ids;

        }

        if (is_array($ids_arr) && empty($id)) {

            foreach ($ids_arr as $v) {

                $res = pdo_delete($this->cart, ['c_id' => $v, 'weid' => $this->weid]);

            }

        }

        if (!empty($id) && empty($ids)) {

            $res = pdo_delete($this->cart, ['c_id' => $id, 'weid' => $this->weid]);

        }

        if (empty($res)) {

            $this->result("1", "删除购物车失败，请重试", $res);

        } else {

//            $sql = "select sum(c_count) from ".tablename($this->cart)." where  weid= ".$this->weid." and openid='".$openid."' and c_status=1";

            $sql = "select sum(c_count) from " . tablename($this->cart) . " c join ".tablename('gpb_goods')." g on c.c_g_id = g.g_id where  c.weid= " . $this->weid . " and c.openid='" . $openid . "' and c.c_status=1 and c.c_is_del = 1 and g.g_is_online = 1 and g.g_is_del = 1";

            $res = pdo_fetchcolumn($sql);

            $this->result("0", "删除购物车成功", $res);

        }

    }



    /*
     * 查询用户自己的购物车
     */
//  public function doPagegetCart()
//  {
//  }

    /*
     * 用户立即购买
     */
//  public function doPagebuyIntime(){
//
//  }
    /*
     * 获取购物车数量
     */
    public function doPagegetCartNum(){

        global $_GPC, $_W;

        $openid = $_GPC['openid'];

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        //7-9 zl 修改购物车数量为所有已上架商品去除下架商品

//        $sql = "select sum(c_count) from " . tablename($this->cart) . " where  weid= " . $this->weid . " and openid='" . $openid . "' and c_status=1 and c_is_del = 1";

        $sql = "select sum(c.c_count) from ".tablename($this->cart)." as c left join ".tablename($this->goods)." as g on c.c_g_id=g.g_id where c.weid='{$this->weid}' and c.openid='{$openid}' and c.c_status=1 and c.c_is_del=1 and g.g_is_del=1 and g.g_is_online=1";

//        exit($sql);

        $res = pdo_fetchcolumn($sql);

        if (empty($res)) {

            $this->result("1", "无购物车数据", 0);

        } else {

            $this->result("0", "查询购物车数量成功", $res);

        }

    }



    /*
     * 用户查询订单
     */
//  public function doPagegetOrder(){
//
//  }



    //用户自己触发来判断是否把待付款的支付了

    public function userSeePay($openid)
    {
        global $_W, $_GPC;
        $list = pdo_fetchall(" select go_code,go_fdc_id,go_release_price,go_add_time,go_balance_price,openid from " . tablename($this->order) . " where openid = '" . $openid . "' and weid = " . $this->weid . " and `type`=1 and go_is_del = 1 and go_status = 10 order by go_add_time desc limit 0,10");
        $min = 30;
        //读取配置
        $order_over_cancle = pdo_get($this->config, array('key' => 'order_over_cancle', 'weid' => $this->weid));

        if (!empty($order_over_cancle) && !empty($order_over_cancle['value'])) {

            $min = $order_over_cancle['value'];

        }

        if (!empty($list)) {

            foreach ($list as $v) {

                $order_status = $this->wx_order_status($v['go_code']);

                if ($order_status['trade_state'] == 'SUCCESS' && $order_status['return_code'] == 'SUCCESS') {

//                    pdo_update($this->order,['go_status'=>20,'go_pay_time'=>time()],["go_code"=>$v["go_code"],"weid"=>$this->weid,'type'=>1]);

                    $des = "小程序自动确认用户已支付，改变状态为已支付";



                    $rownum = pdo_update($this->order, ['go_status' => 20, 'go_pay_time' => time()], array('go_code' => $v["go_code"], 'weid' => $this->weid, 'openid' => $openid, 'type' => 1));
                    //查询订单是否为拼团订单
                    $is_pteam = pdo_fetchcolumn("select oss_is_seckill from ".tablename($this->snapshot)." where oss_go_code='{$v['go_code']}' and oss_is_seckill=3");
                    if($is_pteam && $is_pteam==3){
                        //更新拼团订单和活动
                        //查询对应订单活动
                        $pteam_order = pdo_fetch("select * from ".tablename("gpb_pteam_order")." where osn='{$v['go_code']}'");
                        pdo_update("gpb_pteam_order",array('state'=>2,'utime'=>time()),array('osn'=>$v['go_code']));
                        //对比支付时间是否过期
                        $pay_time = strtotime($order_status['time_end']);
                        if($pay_time>(intval($pteam_order['ctime'])+600)){
                            //超时支付 进入退款流程
                           // $sql = "select po.*,o.openid,o.go_id,o.go_wx_price from ".tablename("gpb_pteam_order")." as po join ".tablename("gpb_order")." as o on po.osn=o.go_code where osn='{$v['go_code']}' and po.`state`>=1 and po.state!=5";
                            $sql = "select po.*,o.openid,o.go_id,o.go_wx_price,o.go_code from ".tablename("gpb_pteam_order")." as po join ".tablename("gpb_order")." as o on po.osn=o.go_code where osn='{$v['go_code']}' and po.`state`>=1 and po.state!=5";
                            $tk_order = pdo_fetch($sql);
                            //用户退款
                            $openid = $tk_order['openid'];
                            $sn = !empty($tk_order['pay_sn'])?$tk_order['pay_sn']:$tk_order['osn'];
                            $money = doubleval($tk_order['money']);
                            $money = $money*100;
                            //获取用户信息
                            $member = pdo_get("gpb_member",array('weid'=>$this->weid,'m_openid'=>$tk_order['openid']));
                            if($tk_order['go_wx_price']>0){
                                //获取当前公众号信息
                                $wxapp = pdo_get("account_wxapp",array('uniacid'=>$_W['uniacid']));
                                $appid = $wxapp['key'];
                                $secret = $wxapp['secret'];
                                //获取支付信息
                                $payment =  pdo_get("uni_settings",array('uniacid'=>$_W['uniacid']));
                                $payment = unserialize($payment['payment']);
                                $payment = $payment['wechat'];
                                $mchid = $payment['mchid'];
                                $key = $payment['signkey'];
                                //是否上传统一证书配置
                                if(!empty($payment['wechat_refund']['cert']) && !empty($payment['wechat_refund']['key'])){
                                    $apiclient_arr = array(
                                        'cert'=>$payment['wechat_refund']['cert'],
                                        'key'=>$payment['wechat_refund']['key'],
                                    );
                                }else{
                                    //获取单独配置
                                    $cert = pdo_fetch("select value from ".tablename("gpb_config")." where `weid`='{$_W['uniacid']}' and `key`='cert_address'");
                                    $keypem = pdo_fetch("select value from ".tablename("gpb_config")." where `weid`='{$_W['uniacid']}' and `key`='key_address'");
                                    $apiclient_arr = array(
                                        'cert'=>"..".$cert['value'],
                                        'key'=>"..".$keypem['value'],
                                    );
                                }
                                //微信支付退款
                                $res = wx_cannelorder($appid,$mchid,$key,$money,$money,$apiclient_arr,$_W['siteroot']."addons/group_buy_plugin_team/return.php",'',$sn);
                                $recharge_log_data = array(
                                    'st'=>1,
                                    'uid'=>$member['m_id'],
                                    'openid'=>$member['m_openid'],
                                    'info'=>'拼团订单支付超时'.$tk_order['money'].'退还至微信',
                                    'type'=>3,
                                    'status'=>1,
                                    'create_time'=>time(),
                                    'weid'=>$this->weid,
                                    'money'=>$tk_order['money'],
                                    'l_type'=>1,
                                    'remarks'=>'订单号：'.$tk_order['go_code'],
                                    'pay_f'=>3
                                );
                                if($res['return_code']=='SUCCESS' && $res['return_msg']=='OK' ){
                                    $res = true;
                                }else{
                                    $res = false;
                                }
                                if($res){
                                    //退款成功更新订单状态
                                    //修改订单状态
                                    $update = array(
                                        'state'=>'-2',
                                        'utime'=>time(),
                                    );
                                    //日志存入
                                    $recharge_log_data_res = pdo_insert('gpb_recharge_log',$recharge_log_data);
                                    pdo_update('gpb_pteam_order',$update,array('id'=>$tk_order['id']));
                                    //修改公共订单
                                    $order_update = [
                                        'go_status'=>'120'
                                    ];
                                    pdo_update('gpb_order',$order_update,array('go_id'=>$tk_order['go_id']));
                                    //检查是否未开团用户支付超时
                                    $is_lader_order = pdo_fetch("select po.*,pa.state as pastate,pa.star_time,pa.end_time,pa.leader_openid as pa_openid from ".tablename("gpb_pteam_order")." as po join ".tablename("gpb_pteam_activity")." as pa on po.aid=pa.id where po.osn='{$v['go_code']}' ");
                                    if($is_lader_order['openid']==$is_lader_order['pa_openid']){
                                        //是团长订单，取消拼团
                                        pdo_update("gpb_pteam_activity",array('state'=>-1,'utime'=>time()),array('id'=>$is_lader_order['id']));
                                    }
                                }
                            }
                        }else{
                            //查询是否为开团订单
                            $pteam_act = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where id={$pteam_order['aid']}");
                            if($pteam_act['state']==1){
                                //开团订单修改开团状态
                                pdo_update("gpb_pteam_activity",array('state'=>2),array('id'=>$pteam_order['aid']));
                            }
                        }
                    }

                    if (empty($rownum)) {



                    } else {

                        //获取商品信息

                        $snapshot = pdo_getall($this->snapshot, array('oss_go_code' => $v["go_code"]));

                        $go_code = $v["go_code"];

                        $buy_phone = $snapshot[0]['oss_buy_phone'];

                        if (!empty($snapshot)) {

                            foreach ($snapshot as $k => $val_snapshot) {

                                $stcok = pdo_get($this->goods_stock, array('goods_id' => $val_snapshot['oss_gid']));//获取库存

                                $num = $stcok['num'] - $val_snapshot['oss_g_num'];

                                $num = $num <= 0 ? 0 : $num;

                                $is = $stcok['sale_num'] + $val_snapshot['oss_g_num'];

                                //获取减少库存方式

                                $reduce_stock_type = pdo_get($this->config, array('key' => 'reduce_stock_type', 'weid' => $this->weid));

                                //修改库存和添加销量

                                if ($reduce_stock_type['value'] == 2) {

                                    pdo_update($this->goods_stock, array('sale_num' => $is), array('goods_id' => $val_snapshot['oss_gid'], 'weid' => $this->weid));

                                } else {

                                    pdo_update($this->goods_stock, array('num' => $num, 'sale_num' => $is), array('goods_id' => $val_snapshot['oss_gid'], 'weid' => $this->weid));

                                }

                                //修改完销量  去查看商品的销量是为0  为0 下架

                                if ($is === 0) {

                                    $res = pdo_update($this->goods, array('g_is_online' => -1), array('g_id' => $val_snapshot['oss_gid'], 'weid' => $this->weid));

                                }

                                //修改虚拟销售数量

                                $sql = "update " . tablename($this->goods) . " set `g_sale_num` = `g_sale_num`+1 WHERE weid=" . $this->weid . " and `g_id` = " . $val_snapshot['oss_gid'];

                                pdo_query($sql);



                            }

                        }

                        //查看是否开启自动订单打印

                        $order_print_auto_open = pdo_get($this->config, array('key' => 'order_print_auto_open', 'weid' => $this->weid));

                        $order_print_auto_open_val = isset($order_print_auto_open['value']) ? $order_print_auto_open['value'] : 2;

                        $order_print_auto_num = pdo_get($this->config, array('key' => 'order_print_auto_num', 'weid' => $this->weid));

                        $order_print_auto_num_val = isset($order_print_auto_num['value']) ? $order_print_auto_num['value'] : 1;

                        if ($order_print_auto_open_val == 1) {

                            //开启

                            //查询打印机配置

                            $print_set = pdo_get($this->config, array('key' => 'print_set', 'weid' => $this->weid));

                            $config = unserialize($print_set['value']);

                            if (empty($config) || count($config) <= 0) {

//                                echo json_encode(array('status'=>1,'msg'=>'请在配置中设置打印机'));exit;

                            } else {

                                //调用打印机类

                                $print_class = new print_sn();

                                //查询打印机状态

                                $res_select = $print_class->select_print($config['print_sn']);

//                                if( $res_select["ret"]!==0 || $res_select["data"]=='离线。'){

////                                    echo json_encode(array('status'=>1,'msg'=>$res_select['msg'].','.$res_select['data']));exit;

//                                }else{

                                $goods = array();

                                $order = pdo_fetchall("select * from " . tablename($this->order) . " as o left join " . tablename($this->snapshot) . " as sn on sn.oss_go_code = o.go_code left join " . tablename($this->vg) . " as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=" . $go_code . " and o.weid=" . $this->weid);

                                foreach ($order as $k => $val) {

                                    $goods[$k]['title'] = $val['oss_g_name'];

                                    $goods[$k]['price'] = $val['oss_g_price'];

                                    $goods[$k]['num'] = $val['oss_g_num'];

                                    $goods[$k]['spec'] = trim($val['oss_ggo_title']);

                                }

                                $adr = $order[0]['vg_address'];

                                if (!empty($order[0]['oss_address']) && $order[0]['oss_address'] != 'undefined') {

                                    $adr = $order[0]['oss_address'];

                                }

                                $lead_info = array(

                                    'name' => $order[0]['oss_head_name'],

                                    'phone' => $order[0]['oss_head_phone'],

                                );

                                $reduce_price = 0;

                                if ($order[0]['go_fdc_price'] > 0) {

                                    $reduce_price += $order[0]['go_fdc_price'];

                                }

                                if ($order[0]['go_full_reduce_price'] > 0) {

                                    $reduce_price += $order[0]['go_full_reduce_price'];

                                }

                                $send_price = 0;

                                if ($order[0]['go_send_pay'] > 0) {

                                    $send_price += $order[0]['go_send_pay'];

                                }

                                switch ($order[0]['go_send_type']) {

                                    case '1':

                                        $send_type = '自提';

                                        break;

                                    case '2':

                                        $send_type = '团长送货';

                                        break;

                                    case '3':

                                        $send_type = '快递';

                                        break;

                                    default:

                                        $send_type = '自提';

                                        break;

                                }

                                switch ($order[0]['go_pay_type']) {

                                    case '1':

                                        $pay_type = '微信支付';

                                        break;

                                    case '2':

                                        $pay_type = '余额支付';

                                        break;

                                    case '3':

                                        $pay_type = '余额+微信支付';

                                        break;

                                    default:

                                        $pay_type = '微信支付';

                                        break;

                                }

                                if($this->check_base64_out_json($order[0]['oss_address_name'])){

                                    $order[0]['oss_address_name']=base64_decode($order[0]['oss_address_name']);

                                }
                                if(!$is_pteam){
                                    $res = $print_class->print_info($config['print_sn'], $go_code, $order[0]['oss_v_name'], $goods, $adr, $order[0]['oss_address_phone'], $order[0]['oss_address_name'], $order[0]['go_real_price'], $lead_info, $order[0]['go_comment'] = '', $qrcode = '', $order[0]['go_add_time'], '', $pay_type, $order_print_auto_num_val, $reduce_price, $send_price, $send_type);
                                }elseif($is_pteam && $is_pteam==3){
                                    //检查拼团是否成功
                                    $pteam_order = pdo_fetch("select * from ".tablename("gpb_pteam_order")." where `osn`='{$v['go_code']}' and `status`=1");
                                    $pteam_act = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where id={$pteam_order['aid']}");
                                    if(($pteam_act['now_num']+1)>=$pteam_act['all_num']){
                                        //拼团成功
                                        //处理拼团为成功状态
                                        update("gpb_pteam_activity",array('state'=>10,'utime'=>time()),array('id'=>$pteam_act['id']));
                                        //发送该拼团所有订单成功消息
                                        $pteam_order_list = pdo_fetch("select osn from ".tablename("gpb_pteam_order")." where aid={$pteam_act['id']} and `state`=2 and `status`=1");
                                        foreach ($pteam_order_list as $k=>$v){
                                            $this->order_print($v['osn']);
                                        }
                                    }
                                }


								sleep(1);

//                                }

                            }

                        }

                        $info = pdo_get($this->order, array('go_code' => $go_code, 'weid' => $this->weid, 'type' => 1));

                        //发送模板消息

                        $sms = new Sms();

                        $sms->weid = $this->weid;

                        $this->Token();

//                        send_out($key,$data,$access_token,$openid,$page,$form_id,$weid,$item);

                        $sms_array = array('1' => $info['go_code'], '2' => "￥" . $info['go_real_price'], '3' => '支付成功', '4' => date('Y-m-d H:i', $info['go_add_time']), '5' => '如有疑问，请拨打客户热线:');

                        $form_id = empty($info['prepay_id']) ? $info['go_order_formid'] : $info['prepay_id'];

                        $dass = $sms->send_out('sms_template', $sms_array, $_W['account']['access_tokne'], $info['openid'], 'pages/order/orderDetail?id=' . $info['go_id'], $form_id, $sms->weid, 'AT0229');

                        //新增订阅消息 周龙 2020-02-27
                        $submsg = new \SubMsg();
                        $submsg->sendmsg("pay_suc",$info['openid'],[$info['go_code'],"￥" . $info['go_real_price'],'支付成功',date('Y-m-d H:i', $info['go_add_time']),'如有疑问，请拨打客户热线'],'pages/order/orderDetail?id=' . $info['go_id']);

                        //新增公众号消息 周龙 2020-03-05
                        $openids = pdo_fetchcolumn("select `value` from ".tablename("gpb_config")." where `key`='refund_msg_openid' and `weid`={$this->weid} and `status`=1");
                        if(!empty($openids)){
                            //设置的有才发送
                            //是否多个
                            $subwechat = new \SubWechat();
                            $arr = explode(",",$openids);
                            if(is_array($arr) && count($arr)>1){
                                $subwechat_arr = [
                                    '您有新的订单请及时处理',
                                    $info['go_code'],
                                    '',
                                    date('Y-m-d H:i', $info['go_add_time']),
                                    "￥" . $info['go_real_price'],
                                    '请及时进入后台处理'
                                ];
                                foreach ($arr as $k=>$v){
                                    $subwechat->sendunimsg("tmp_paymsg",$v,$subwechat_arr);
                                }
                            }else{
                                //只有一个直接发送
                                $subwechat_arr = [
                                    '您有新的订单请及时处理',
                                    $info['go_code'],
                                    '',
                                    date('Y-m-d H:i', $info['go_add_time']),
                                    "￥" . $info['go_real_price'],
                                    '请及时进入后台处理'
                                ];
                                $subwechat->sendunimsg("tmp_paymsg",$openids,$subwechat_arr);
                            }

                        }

                        $log_content = date('Y-m-d H:i:s') . '，订单支付成功模版消息日志（userSeePay）' . PHP_EOL;

                        if (is_array($dass)) {

                            foreach ($dass as $dass_k => $dass_v) {

                                $log_content .= 'key:' . $dass_k . ',value:' . $dass_v . PHP_EOL;

                            }

                        }

                        $log_content .= json_encode(array('sms_template', $sms_array, $_W['account']['access_tokne'], $openid, 'pages/order/orderDetail?id=' . $info['go_id'], $form_id, $sms->weid, 'AT0229'), JSON_UNESCAPED_UNICODE);

                        $log_content .= '----------end------------' . PHP_EOL;

                        $this->txt_logging_fun('sms_AT0229_log.txt', $log_content);

//                        pdo_insert('gpb_config',array('value'=>serialize($dass),'name'=>$info['prepay_id'].'****'));

                        //模板消息结束

//						$sms->sms(50,array('0'=>'15883788928','1'=>'20181203180953'));



                        //短信通知管理员

                        //$account = pdo_get($this->member,array('m_openid'=>$openid,'weid'=>$this->weid));

                        $type = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_type'));

                        $set = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_pay'));

                        $phone = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_admin'));

                        $data = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_data'));

                        $phone = unserialize($phone['value']);

                        $data = unserialize($data['value']);

                        $set = unserialize($set['value']);

                        $sms = new Sms();

                        $weid = $sms->weid = $this->weid;

                        if ($type['value'] == 1) {

                            //阿里云

                            if (is_array($phone)) {

                                foreach ($phone as $k => $v_phone_sms) {

                                    $res = $sms->alicloud($v_phone_sms, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), array('0' => $buy_phone, '1' => $go_code));

                                }

                            }

                        } elseif ($type['value'] == 2) {

                            //创瑞 todo 不一定成

                            if (is_array($phone)) {

                                foreach ($phone as $k => $v_phone_sms) {

                                    $res = $sms->chui($v_phone_sms, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), $go_code);

                                }

                            }

                        }

                        //修改流水表

                        $old_stream = pdo_get($this->stream, array("weid" => $this->weid, 'gos_go_code' => $v["go_code"], 'gos_stream_type' => 1, 'gos_status' => 1));

//                        if( $openid=="oLf4B0YnQULf9ZfUT8qmnI8q7xeI" or $openid=="oLf4B0RKRvsOPND25hNm4cCiz_Lg" or $openid=='oLf4B0ZsYqyFXGeuNb1QgwMzspkk'){

//                            $total_fee = "0.01";

//                        }else{

                        $total_fee = $info['go_real_price'];

//                        }

                        if (empty($old_stream)) {

                            //存入订单流水

                            $order_snapshot = pdo_fetchall("select * from " . tablename($this->snapshot) . " where oss_go_code =" . $info['go_code']);

                            $data_stream = array(

                                'gos_code' => date('Ymd', time()) . $this->nextId(),//流水号

                                'gos_go_code' => $info['go_code'],//订单号

                                'gos_stream_type' => 1,

                                'gos_type' => 1,

                                'gos_commet' => '.进入订单页确定支付完成',

                                'gos_owner' => '平台',

                                'gos_order_money' => $total_fee,

                                'gos_payer' => $order_snapshot[0]['oss_buy_name'],

                                'gos_real_money' => $total_fee,

                                'gos_sure_pay_time' => time(),

                                'gos_status' => 2,

                                'gos_add_time' => time(),

                                'weid' => $this->weid,

                                'gos_pay_type' => 1,

                                'gos_team' => $order_snapshot[0]['oss_head_name'],

                                'gos_payer_openid' => $order_snapshot[0]['oss_buy_openid'],

                                'gos_team_openid' => $order_snapshot[0]['oss_head_openid']

                            );

                            pdo_insert($this->stream, $data_stream);

                        } else {

                            $data_stream = array(

                                'gos_real_money' => $total_fee,

                                'gos_sure_pay_time' => time(),

                                'gos_commet' => $old_stream['gos_commet'] . ',小程序确定支付完成',

                                'gos_status' => 2

                            );

                            pdo_update($this->stream, $data_stream, array('gos_id' => $old_stream['gos_id']));

                        }

                        $info['go_add_time'] = date('Y-m-d', $info['go_add_time']);

                        //todo  cccc

                        $this->pay_success_send_official_account_msg($info['go_code']);





                    }

                } else {

                    $cancle_sn = pdo_getall('gpb_order_snapshot', array('oss_go_code' => $v["go_code"]));

                    if ($v['go_add_time'] + ($min * 60) < time() && $cancle_sn[0]['oss_is_seckill'] == 0) {

                        $res_order = pdo_update($this->order, ['go_status' => 110], ["go_code" => $v["go_code"], "weid" => $this->weid, 'type' => 1]);

                        if (!empty($res_order)) {

                            $des = "小程序在微信商户后台查询到该订单未支付，修改状态为已取消";



                            $member = pdo_get('gpb_member', array('m_openid' => $v['openid']));

                            if ($v['go_fdc_id'] > 0) {

                                pdo_update('gpb_user_ticket', array('is_use' => 0), array('id' => $v['go_fdc_id']));

                            }



                            if ($v['go_balance_price'] > 0) {

                                //退还余额

                                pdo_update('gpb_member', array('m_money_balance +=' => $v['go_balance_price']), array('m_openid' => $v['openid']));

                                $back_balance_log_arr = array(

                                    'openid' => $v['openid'],

                                    'info' => '订单未支付，后台管理员退回余额￥' . $v['go_balance_price'],

                                    'type' => 1,

                                    'status' => 1,

                                    'create_time' => time(),

                                    'weid' => $this->weid,

                                    'money' => $v['go_balance_price'], 'l_type' => 1, 'st' => 1, 'remarks' => '订单号：' . $v['go_code'], 'pay_f' => 2

                                );

                                pdo_insert('gpb_recharge_log', $back_balance_log_arr);

                            }

                            if ($v['go_release_price'] > 0) {

                                //退还返利金

                                //获取当前每日反的奖金

                                $release_today_list = pdo_fetchall(" select * from " . tablename("gpb_recharge_list") . " where openid = '" . $openid . "' and overdue =1 and weid = " . $this->weid . " and `time`=" . strtotime(date('Ymd', $v['go_add_time'])));

                                pdo_update('gpb_recharge_list', array('money +=' => $v['go_release_price'], 'use_money -=' => $v['go_release_price']), array('id' => $release_today_list[0]['id']));

                            }

                        }



                    }

                    $min_seckill = pdo_get('gpb_shop_seckill_task', array('id' => $cancle_sn[0]['oss_seckill_taskid']));

                    if (!empty($min_seckill) && isset($min_seckill['closesec'])) {

                        $min_seckill_sec = $min_seckill['closesec'];

                    } else {

                        $min_seckill_sec = $min * 60;

                    }

                    if ($cancle_sn[0]['oss_is_seckill'] == 1 && $v['go_add_time'] + $min_seckill_sec < time()) {

                        $res_order = pdo_update($this->order, ['go_status' => 110], ["go_code" => $v["go_code"], "weid" => $this->weid, 'type' => 1]);

                        if (!empty($res_order)) {

                            $des = "小程序在微信商户后台查询到该订单未支付，修改状态为已取消";

                            //如果是秒杀取消恢复库存

//                            pdo_update('gpb_shop_seckill_task_goods',array('total +='=>$cancle_sn[0]['oss_g_num'],'sale_num -='=>$cancle_sn[0]['oss_g_num']),array('taskid'=>$cancle_sn[0]['oss_seckill_taskid'],'roomid'=>$cancle_sn[0]['oss_seckill_roomid'],'timeid'=>$cancle_sn[0]['oss_seckill_timeid'],'goodsid'=>$cancle_sn[0]['oss_gid']));

                            if (!empty($res_order)) {

                                pdo_query('UPDATE ' . tablename('gpb_shop_seckill_task_goods') . ' SET total = total+' . intval($cancle_sn[0]['oss_g_num']) . ',sale_num=sale_num-' . intval($cancle_sn[0]['oss_g_num']) . ' WHERE taskid=' . $cancle_sn[0]['oss_seckill_taskid'] . ' AND roomid=' . $cancle_sn[0]['oss_seckill_roomid'] . ' AND timeid=' . $cancle_sn[0]['oss_seckill_timeid'] . ' AND goodsid=' . $cancle_sn[0]['oss_gid']);

//                            pdo_update('gpb_goods_stock',array('num +='=>$cancle_sn[0]['oss_g_num'],'sale_num -='=>$cancle_sn[0]['oss_g_num']),array('goods_id'=>$cancle_sn[0]['oss_gid']));

                                pdo_query('UPDATE ' . tablename('gpb_goods_stock') . ' SET num = num+' . intval($cancle_sn[0]['oss_g_num']) . ',sale_num=sale_num-' . intval($cancle_sn[0]['oss_g_num']) . ' WHERE goods_id=' . $cancle_sn[0]['oss_gid']);

                            }



                            if ($v['go_balance_price'] > 0) {

                                //退还余额

                                pdo_update('gpb_member', array('m_money_balance +=' => $v['go_balance_price']), array('m_openid' => $v['openid']));

                                $back_balance_log_arr = array(

                                    'openid' => $v['openid'],

                                    'info' => '订单未支付，后台管理员退回余额￥' . $v['go_balance_price'],

                                    'type' => 1,

                                    'status' => 1,

                                    'create_time' => time(),

                                    'weid' => $this->weid,

                                    'money' => $v['go_balance_price'], 'l_type' => 1, 'st' => 1, 'remarks' => '订单号：' . $v['go_code'], 'pay_f' => 2

                                );

                                pdo_insert('gpb_recharge_log', $back_balance_log_arr);

                            }

                            if ($v['go_release_price'] > 0) {

                                //退还返利金

                                //获取当前每日反的奖金

                                $release_today_list = pdo_fetchall(" select * from " . tablename("gpb_recharge_list") . " where openid = '" . $openid . "' and overdue =1 and weid = " . $this->weid . " and `time`=" . strtotime(date('Ymd', $v['go_add_time'])));

                                pdo_update('gpb_recharge_list', array('money +=' => $v['go_release_price'], 'use_money -=' => $v['go_release_price']), array('id' => $release_today_list[0]['id']));

                            }

                        }



                    } else {

                        if ($v['go_fdc_id'] > 0) {

                            pdo_update('gpb_user_ticket', array('is_use' => 0), array('id' => $v['go_fdc_id']));

                        }

                    }



                }

                if (!empty($des) && !empty($res_order)) {

                    $data = array(

                        'gol_add_time' => time(),

                        'gol_des' => $des,

                        'gol_go_code' => $v["go_code"],

                        'gol_u_name' => '用户自己'

                    );

                    pdo_insert($this->order_log, $data);

                    //更新订单流水表

                    pdo_update($this->stream, array('gos_real_money' => $v['go_real_price']), array("gos_status" => 1, 'gos_go_code' => $v["go_code"], 'gos_stream_type' => 1, 'weid' => $this->weid, 'gos_type' => 1));



                }

            }

        }

		return '';

    }



    /*

    * 团长查询订单

    */

    public function doPagegetTeamOrder()
    {
        global $_GPC, $_W;
        $openid = trim($_GPC['openid']);
        if (empty($openid)) {
            $this->result("1", "请传入openid");
        }
        $where = " ";
        //逻辑：订单状态是确定查询
        if (isset($_GPC['status']) and !empty($_GPC['status']) and $_GPC['status'] != 40) {
            if ($_GPC['status'] == 20) {
                $where .= " and  (go_status = 20 or go_status = 25 or go_status = 28  ) ";
            } else {
                $where .= " and  go_status = '" . trim($_GPC['status']) . "' ";
            }
        } elseif (isset($_GPC['status']) and !empty($_GPC['status']) and $_GPC['status'] == 40) {
            $where .= " and  go_status >40 and  go_status<=70 ";
        }
        $type = trim($_GPC['type']);
        if (!empty($type)) {
            $where .= " and go_send_type=" . $type;
        }
        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;
        $pageIndex = $index;
        $pageSize = 10;
        $contion = 'limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;
        $sql = " select * from " . tablename($this->order) . " as o where go_team_openid = '" . $openid . "' " . $where . " and weid = " . $this->weid . " and (o.`type`=1) and go_is_del = 1 and go_status <>10 and go_status <> 110 and go_status <> 120 order by go_add_time desc " . $contion;
//		$sql = " select * from ".tablename($this->order)." as o join ".tablename('gpb_distribution_list_order')." lo on o.go_id = lo.go_id join ".tablename('gpb_distribution_list')." l ON lo.l_id = l.dl_id where o.go_team_openid = '".$openid."' ".$where." and o.weid = ".$this->weid." and l.dl_status >= 30 and (o.`type`=1) and o.go_is_del = 1 and o.go_status <>10 and o.go_status <> 110 and o.go_status <> 120 order by o.go_add_time desc ".$contion;
//		echo '<pre>';
//		print_r($sql);
//		exit;
        $list = pdo_fetchall($sql);
//        $list = pdo_query($sql);
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $info = pdo_fetchall(" select a.*,m.m_photo from " . tablename($this->member) . " as m join " . tablename($this->snapshot) . " as a on m.m_openid = a.oss_head_openid where m.weid = " . $this->weid . " and a.oss_go_code = '" . $v['go_code'] . "'");
//                $info = pdo_getall($this->snapshot,array('oss_go_code = '.$v['go_code']));
                if (!empty(($info))) {
                    $money = 0;
                    foreach ($info as $i => $j) {
//                        $info[$i]['oss_g_icon'] = $this->http.$j['oss_g_icon'];
                        $info[$i]['oss_g_icon'] = tomedia($j['oss_g_icon']);
                        $ins = $j['oss_g_num'] * $j['oss_g_price'];
                        $money += $ins;
                        if($this->check_base64_out_json( $j['m_nickname'] )){
                            $info[$i]['m_nickname'] = base64_decode( $j['m_nickname'] );
                        }
                        if($this->check_base64_out_json( $j['oss_address_name'] )){
                            $info[$i]['oss_address_name'] = base64_decode( $j['oss_address_name'] );
                        }
                    }
                }
                $list[$k]['go_add_time'] = date("Y-m-d H:i", $v['go_add_time']);
                $list[$k]['item_goods'] = $info;
                $list[$k]['oss_head_name'] = $info[0]['oss_head_name'];
                $list[$k]['oss_head_phone'] = $info[0]['oss_head_phone'];
                $list[$k]['m_photo'] = $info[0]['m_photo'];
                $list[$k]['oss_v_name'] = $info[0]['oss_v_name'];
                $list[$k]['total_money'] = $money;
                $list[$k]['number'] = count($info);
            }
        }
        if (empty($list)) {
            $this->result("1", "查询订单失败，请重试", $sql);
        } else {
            $this->result("0", "查询订单成功", $list);
        }
    }



    //随机六位数密码

    public function randStr($len = 6, $format = 'ALL')

    {

        switch ($format) {

            case 'ALL':

                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';

                break;

            case 'CHAR':

                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~';

                break;

            case 'NUMBER':

                $chars = '0123456789';

                break;

            default :

                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';

                break;

        }

        mt_srand((double)microtime() * 1000000 * getmypid());

        $password = "";

        while (strlen($password) < $len)

            $password .= substr($chars, (mt_rand() % strlen($chars)), 1);

        return $password;

    }



    //二进制转图片image/png

    public function data_uri($contents, $mime)

    {

        $base64 = base64_encode($contents);

        return ('data:' . $mime . ';base64,' . $base64);

    }



    /*

     * 取消订单接口

     */

//    public function doPagedelOrder(){

//        global $_GPC;

//        $id = trim($_GPC['id']);

//        if( empty($id)){

//            $this->result("1","请传入订单id");

//        }

//        $openid = trim($_GPC['openid']);

//        if( empty($openid)){

//            $this->result("1","未授权");

//        }

//        $info = pdo_get($this->order,array("go_id"=>$id,'openid'=>$openid,'weid'=>$this->weid,'type'=>1));

//        if($info['go_fdc_id']>0){

//            pdo_update($this->user_coupon,array('is_use'=>0),array('id'=>$info['go_fdc_id']));

//        }

//        $res = pdo_update($this->order,array("go_status"=>110),array("go_id"=>$id,'openid'=>$openid,'weid'=>$this->weid,'type'=>1));

//        if(empty($res)){

//            $this->result("1","取消订单失败，请重试");

//        }else{

//            if(empty($info['go_pay_time']) && $info['go_reduce_stock']==2 ){

//                $sn = pdo_getall($this->snapshot,array('oss_go_code'=>$info['go_code']));

//                foreach ($sn as $v){

//                    pdo_update($this->goods_stock,array('num +='=>$v['oss_g_num']),array('goods_id'=>$v['oss_gid']));

//                }

//            }

//            $this->result("0","取消订单成功");

//        }

//    }

    /*

     * 用户取消订单接口,之前设计让用户可以删除订单，之后又改取消了

     */

//    public function doPageuserdelOrder(){

//        global $_GPC;

//        $id = trim($_GPC['id']);

//        if( empty($id)){

//            $this->result("1","请传入订单id");

//        }

//        $openid = trim($_GPC['openid']);

//        if( empty($openid)){

//            $this->result("1","未授权");

//        }

//        $info = pdo_get($this->order,array("go_id"=>$id,'openid'=>$openid,'weid'=>$this->weid,'type'=>1));

//        if($info['go_fdc_id']>0){

//            pdo_update($this->user_coupon,array('is_use'=>0),array('id'=>$info['go_fdc_id']));

//        }

//        $res = pdo_update($this->order,array("go_status"=>110),array("go_id"=>$id,'openid'=>$openid,'weid'=>$this->weid,'type'=>1));

//        if(empty($res)){

//            $this->result("1","用户删除订单失败，请重试");

//        }else{

//            if(empty($info['go_pay_time']) && $info['go_reduce_stock']==2 ){

//                $sn = pdo_getall($this->snapshot,array('oss_go_code'=>$info['go_code']));

//                foreach ($sn as $v){

//                    pdo_update($this->goods_stock,array('num +='=>$v['oss_g_num']),array('goods_id'=>$v['oss_gid']));

//                }

//            }

//            $this->result("0","用户删除订单成功");

//        }

//    }

    /**

     * 用户在订单页面    进行支付

     */

    public function doPagegetorder_pay()

    {

        global $_GPC, $_W;

        $id = $_GPC['id'];

        $openid = $_GPC['openid'];

        if (empty($openid)) {

            $this->result('1', '请传入用户openid');

        }

        if (empty($id)) {

            $this->result(1, '该订单不存在');

        }

        $info = pdo_get($this->order, array('go_id' => $id, 'type' => 1, 'weid' => $this->weid));

        if (empty($info)) {

            $this->result(1, '该订单不存在');

        }

        $list = $this->wx_order_status($info['go_code']);

        if ($list['trade_state'] == 'SUCCESS' && $list['return_code'] == 'SUCCESS') {



            $this->result(1, '该订单已支付');

        }

		if($info['go_status'] == 110){

			$this->result(1, '该订单已取消，请重新下单');

		}

		//2020-03-06 周龙 添加支付前判断订单是否已过期
        $over_time = pdo_fetchcolumn("select `value` from ".tablename($this->order)." where weid={$this->weid} and `key` ='order_over_cancle' and `status`=1");
        $over_time = intval($over_time)*60;
        $now_time = time();

        if(intval($now_time)-intval($info['go_add_time'])>=$over_time){
            //处理超时订单
            pdo_update($this->order,array('go_status'=>110),array("go_id"=>$info['go_id']));

            $order_log = [
                'gol_uid'=>0,
                'gol_add_time'=>time(),
                'gol_comment'=>'订单超时未支付已由系统自动取消',
                'gol_des'=>'订单超时未支付已由系统自动取消',
                'gol_go_code'=>$info['go_code'],
                'gol_status'=>1,
                'gol_u_name'=>'系统',
                'type'=>1,
                'intage'=>'0.00',
                'share'=>1
            ];

            $res = pdo_insert($this->order_log,$order_log);

            if(empty($res)){
                //加入之日不成功 写入文件日志
                $f = fopen("./order_log.log","a+");
                $content = serialize($order_log);
                $content = "\n".date("Y-m-d H:i:s")."\n插入日志不成功,{$res}\n".$content;
                fwrite($f,$content);
                fclose($f);
            }

            //阻止继续支付 返回订单取消
            $this->result(1, '订单超时未支付系统已自动取消，请重新下单购买');
        }

        //判断是否使用优惠券   ，判断库存是否足够  判断是否是活动  活动结束没

        if (!empty($info['go_fdc_id']) and $info['go_fdc_id'] != 0) {

            //使用了      优惠券

            $user_coupon = pdo_fetch("select * from " . tablename($this->user_coupon) . " where weid=" . $this->weid . " and id = " . $info['go_fdc_id'] . " and openid = '" . $openid . "'");

            if ($user_coupon["over_time"] < time() || $user_coupon['is_over'] == 1) {

                $this->result(1, '优惠券过期，请重新下单');

            }

            if ($user_coupon["is_use"] == 0) {

                $this->result(1, '优惠券已被使用，请重新下单');

            }

        }

        $order_snapshot = pdo_fetchall("select * from " . tablename($this->snapshot) . " where oss_go_code =" . $info['go_code']);

        //判断是否活动过期

        if (!empty($order_snapshot) and !empty($order_snapshot[0]['oss_ac_id']) and $info[0]['oss_ac_id'] != 0) {

            $action = pdo_fetch("select * from " . tablename($this->action) . " where weid=" . $this->weid . " and at_id = " . $order_snapshot[0]['oss_ac_id']);

            if ($action['at_end_time'] < time() || $action['at_is_del'] == -1) {

                $this->result(1, '活动已结束，请选择新的活动商品');

            }

        }

        //判断库存

        //判断库存是否扣了

        $reduce_stock_type = pdo_get("gpb_config",array('key'=>'reduce_stock_type','weid'=>$this->weid));

        if($reduce_stock_type['value'] == 1){

        	foreach ($order_snapshot as $k => $v) {

	            $stock = pdo_fetch("select * from " . tablename($this->goods_stock) . " where weid=" . $this->weid . " and goods_id =" . $v['oss_gid']);

	            if (!empty($stock)) {

	                if ($stock['num'] <= 0) {

	                    $this->result(1, '商品已售罄，请重新下单');

	                }

	            } else {

	                $this->result(1, '库存查询失败，请重试');

	            }

	        }

        }

        $total_prcie = $info['go_wx_price'];
        //2020-02-24 周龙 修复修改订单号支付导致无法对应回调信息
//        $code = $this->nextId();
        $code = $info['go_code'];
        pdo_begin();

        //为了能第二次付款就生成新订单号

        /*$res = pdo_update($this->order, array('go_code' => $code), array("go_id" => $info['go_id'], 'weid' => $this->weid, 'type' => 1));

        if($res===false){

			$this->result(1, '订单号变更失败，请重试!');

        }

        //并且同步新订单号到快照表

        foreach ($order_snapshot as $k => $v) {

            pdo_update($this->snapshot, array('oss_go_code' => $code), array("oss_id" => $v['oss_id']));

        }*/



        $total_fee = sprintf("%.2f", $total_prcie);
        //判断是否下过单
        if(!empty($info['prepay_id'])){
            $res = $this->pays($total_fee, $openid, $code, $info['go_id'], '');
        }else{
            //2020-02-24 周龙 直接调用之前的下单不进行重新下单

            /*$res = $this->pays($total_fee, $openid, $code, $info['go_id'], '');
            if ($res['status'] == 0) {*/

            $time = date('YmdHis',time());

            $appid = $_W['oauth_account']['key'];//如果是公众号 就是公众号的appid;小程序就是小程序的appid

            $body = '在线支付';

            $mch_id = $this->pay_setting['wechat']['mchid'];//商户号

            $KEY = $this->pay_setting['wechat']['signkey'];//支付密匙



            $nonce_str = $this->randomkeys(32);//随机字符串

            $notify_url = $_SERVER['SERVER_NAME'];//;  //支付完成回调地址url,不能带参数

            $out_trade_no = $code;//商户订单号

            $spbill_create_ip = $_SERVER['SERVER_ADDR'];//服务器端ip

            $trade_type = 'JSAPI';

            $tmp['appId'] = $appid;

            $tmp['nonceStr'] = $nonce_str;

            $tmp['package'] = 'prepay_id=' . $info['prepay_id'];

            $tmp['signType'] = 'MD5';

            $tmp['timeStamp'] = (string)$time . "";



            $data['status'] = 0;

            $data['id'] = $info['go_id'];

            $data['packages'] = $info['prepay_id'];

            $data['timeStamp'] = "{$time}";           //时间戳

            $data['nonceStr'] = $nonce_str;         //随机字符串

            $data['signType'] = 'MD5';              //签名算法，暂支持 MD5

            $data['package'] = 'prepay_id=' . $info['prepay_id'];   //统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*

            $data['paySign'] = $this->MakeSign($tmp, $KEY);       //签名,具体签名方案参见微信公众号支付帮助文档;

            $data['out_trade_no'] = $out_trade_no;

            $res = $data;
        }

            if ($res['status'] == 0) {

                $res['gid'] = $code;
                if (!empty($info['go_fdc_id']) and $info['go_fdc_id'] != 0) {

                    pdo_update($this->user_coupon, ['is_use' => 1, 'update_time' => time()], ['id' => $info['go_fdc_id'], 'weid' => $this->weid]);

                }

                //获取原来的流水是否存在

                $old_stream = pdo_get($this->stream, array("weid" => $this->weid, 'gos_go_code' => $info['go_code'], 'gos_stream_type' => 1, 'gos_status' => 1));

                if (empty($old_stream)) {

                    //存入订单流水

                    $data_stream = array(

                        'gos_code' => date('Ymd', time()) . $this->nextId(),//流水号

                        'gos_go_code' => $code,//订单号

                        'gos_stream_type' => 1,

                        'gos_type' => 1,

                        'gos_commet' => '在订单页重新支付',

                        'gos_owner' => '平台',

                        'gos_order_money' => $total_fee,

                        'gos_payer' => $order_snapshot[0]['oss_buy_name'],

                        'gos_real_money' => 0,

                        'gos_status' => 1,

                        'gos_add_time' => time(),

                        'weid' => $this->weid,

                        'gos_pay_type' => 1,

                        'gos_team' => $order_snapshot[0]['oss_head_name'],

                        'gos_payer_openid' => $order_snapshot[0]['oss_buy_openid'],

                        'gos_team_openid' => $order_snapshot[0]['oss_head_openid']

                    );

                    pdo_insert($this->stream, $data_stream);

                } else {

                    $data_stream = array(

                        'gos_go_code' => $code,//订单号

                        'gos_commet' => $old_stream['gos_commet'] . ',后在订单页重新支付',

                        'gos_order_money' => $total_fee,

                        'gos_two_add_time' => time(),

                    );

                    pdo_update($this->stream, $data_stream, array('gos_id' => $old_stream['gos_id']));

                }



                pdo_commit();

                $this->result("0", "调取支付成功", $res);

                exit;

        } else {

            pdo_rollback();

            $this->result("1", "调取支付失败", $res);

            exit;

        }



    }



    /*

     * 新增收货地址

     */

    public function doPageaddAddress()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "请传入openid");

        }

        $name = trim($_GPC['name']);

        if (empty($name)) {

            $this->result("1", "请传入收货人姓名");

        }

        $phone = trim($_GPC['phone']);

        if (empty($phone)) {

            $this->result("1", "请传入收货人电话");

        }

        $province = trim($_GPC['province']);



        $city = trim($_GPC['city']);



        $area = trim($_GPC['area']);



        $info = trim($_GPC['info']);



        $data = [

            'openid' => $openid,

            'ra_name' => base64_encode($name),

            'ra_phone' => $phone,

            'ra_province' => $province,

            'ra_city' => $city,

            'ra_area' => $area,

            'ra_info' => $info,

            'ra_mail_code' => trim($_GPC['mail']),

            'ra_all_address' => trim($_GPC['province']) . trim($_GPC['city']) . trim($_GPC['area']) . $info,

            'ra_is_default' => 1,

            'weid' => $this->weid



        ];

        pdo_update($this->address, ['ra_is_default' => -1], ['openid' => $openid, 'weid' => $this->weid]);

        $res = pdo_insert($this->address, $data);

        if (empty($res)) {

            $this->result("1", "新增地址失败，请重试");

        } else {

            $this->result("0", "新增地址成功", $info);

        }

    }



    /*

     * 查询团长管理页

     */

    public function doPageseeTeam()

    {

        global $_GPC, $_W;

        $openid = $_GPC['openid'];//当前团长的openid

        if (empty($openid)) {

            $this->result(1, '请传入openid');

        }

        $team = pdo_get($this->member, array('m_openid' => $openid));

        $vg = pdo_get($this->vg, array('openid' => $openid));



        $today = date("Y-m-d", time());

        $start_today = strtotime($today . " 00:00:00");

        $end_today = strtotime($today . " 23:59:59");

        //查询今日销售额

        $today_all_money_sql = "select sum(go_real_price) as total from " . tablename($this->order) . " where weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "'  and go_pay_time >" . $start_today . " and go_pay_time < " . $end_today;

        $today_all_money_arr = pdo_fetch($today_all_money_sql);

        $today_all_money = $today_all_money_arr['total'];

        $today_all_money = empty($today_all_money) ? 0 : $today_all_money;



        //查询今天有效订单

        $today_all_order = pdo_fetchcolumn("select count(*)  from " . tablename($this->order) . " where weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and go_status>10 and go_status!=110 and go_status!=120 and go_pay_time >" . $start_today . " and go_pay_time < " . $end_today);

        $today_all_order = empty($today_all_order) ? 0 : $today_all_order;

        //获取今日预计佣金

        $today_commission_sql = "select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and go_pay_time >" . $start_today . " and go_pay_time < " . $end_today;

        $today_commission_arr = pdo_fetch($today_commission_sql);

        $today_commission = $today_commission_arr['total'];

        $today_commission = empty($today_commission) ? 0 : $today_commission;



        //获取待结算佣金
		$all_commission_no_pay = pdo_fetch("SELECT SUM(go_commission) AS total FROM ".tablename('gpb_order')." WHERE weid = ".$this->weid." AND go_team_openid='".$openid."' AND go_status = 100 and go_is_cash = -1");
		$all_commission_no_pay = $all_commission_no_pay['total'] ? $all_commission_no_pay['total'] : 0;

//      $all_commission_no_pay = pdo_fetch("select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $this->weid . " and go_status =100 and `type`=1 and go_team_openid='" . $openid . "' and go_pay_time >0 and sn.oss_ggo_status=1 and o.go_is_cash=-1");
//      $all_commission_no_pay = empty($all_commission_no_pay['total']) ? 0 : $all_commission_no_pay['total'];

        //获取累计佣金

        $all_commission = pdo_fetch("select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and go_pay_time >0 and sn.oss_ggo_status=1");

        $all_commission = empty($all_commission['total']) ? 0 : $all_commission['total'];

        //团长提现门槛设置

        $get_cash_limit_money = pdo_get($this->config, array('key' => 'get_cash_limit_money', 'weid' => $this->weid));



        //查看是否开启团长推荐

        $head_recommend_open_arr = pdo_get($this->config, array('key' => 'head_recommend_open', 'weid' => $this->weid));

        $head_recommend_open = isset($head_recommend_open_arr['value']) ? $head_recommend_open_arr['value'] : 2;

        if ($head_recommend_open == 1) {

            //开启推荐

            //查询推荐人数

            $recommend_people_num = pdo_fetchcolumn('select count(*) from ' . tablename('gpb_head_commond_log') . ' where status =1 and weid=' . $this->weid . ' and pid = ' . $team['m_id']);



            //推荐奖励累计

            $recommend_money = pdo_fetch('select sum(`get_money`) as total from ' . tablename('gpb_head_commond_log') . 'where status =1 and weid=' . $this->weid . ' and pid = ' . $team['m_id']);

            $recommend_money = isset($recommend_money['total']) ? floatval($recommend_money['total']) : '0.00';

            //查询今日分销

            $today_recommend_dis = pdo_fetch('select sum(`money`) as total from ' . tablename('gpb_head_money_log') . 'where status =1 and weid=' . $this->weid . ' and type =1 and type_from=1 and create_time >=' . $start_today . ' and create_time <=' . $end_today . ' and uid = ' . $team['m_id']);

            $today_recommend_dis = isset($today_recommend_dis['total']) ? floatval($today_recommend_dis['total']) : '0.00';

            //查询历史分销

            $history_recommend_dis = pdo_fetch('select sum(`money`) as total from ' . tablename('gpb_head_money_log') . 'where status =1 and weid=' . $this->weid . ' and type =1 and type_from=1 and uid = ' . $team['m_id']);

            $history_recommend_dis = isset($history_recommend_dis['total']) ? floatval($history_recommend_dis['total']) : '0.00';

        }

        //是否开启推广代理团长

        $head_agent_open_arr = pdo_get($this->config, array('key' => 'head_agent_open', 'weid' => $this->weid));

        $head_agent_open = isset($head_agent_open_arr['value']) ? $head_agent_open_arr['value'] : 2;



        //查询自提数量

        $num_self_get = pdo_fetchcolumn(" select count(*) from " . tablename($this->order) . " as o left join " . tablename('gpb_distribution_list_order') . " as dlo on dlo.go_id =o.go_id left join " . tablename('gpb_distribution_list') . " as dl on dl.dl_id = dlo.l_id left join " . tablename('gpb_order_snapshot') . " as sn on sn.oss_go_code = o.go_code  where go_team_openid = '" . $openid . "' and  go_status = 30 and go_send_type =1 and o.weid = " . $this->weid . " and (o.`type`=1) and go_is_del = 1 and dl.dl_status=30    order by go_add_time desc ");

        //查询团长配送数量

        $num_head_send = pdo_fetchcolumn("select count(*) from " . tablename($this->order) . " as o left join " . tablename('gpb_distribution_list_order') . " as dlo on dlo.go_id =o.go_id left join " . tablename('gpb_distribution_list') . " as dl on dl.dl_id = dlo.l_id left join " . tablename('gpb_order_snapshot') . " as sn on sn.oss_go_code = o.go_code  where go_team_openid = '" . $openid . "' and  go_status = 30 and go_send_type =2 and o.weid = " . $this->weid . " and (o.`type`=1) and go_is_del = 1 and dl.dl_status=30   order by go_add_time desc ");
        if($this->check_base64_out_json( $team['m_nickname'] )){
            $team['m_nickname'] = base64_decode( $team['m_nickname'] );
        }
        //是否开启团长收货
        $is_open_header_sure_order = pdo_get($this->config,array('key'=>'is_open_header_sure_order','weid'=>$this->weid));
		$is_open_header_sure_order = isset($is_open_header_sure_order['value'])?intval($is_open_header_sure_order['value']):2;
		$already_cash_commission = pdo_fetch("select sum(ggc_money) as total from" . tablename('gpb_get_cash') . "as ggc where ggc_type=20 and openid= '" . $openid . "'");
//        "select sum(oss_commission) as total from ".tablename($this->snapshot)." as sn left join   ".tablename($this->order)." as o on o.go_code=sn.oss_go_code where o.weid=".$this->weid." and `type`=1 and go_team_openid='".$openid."' and go_pay_time >0 and sn.oss_ggo_status=1 and go_is_cash =2";
        $already_cash_commission = empty($already_cash_commission['total']) ? 0 : $already_cash_commission['total'];
		$all_commission = $all_commission_no_pay+$team['m_money']+$already_cash_commission;
		//查询当前团长是否有可收货的订单
		$blid =pdo_fetch("select bl.dl_id from ".tablename('gpb_distribution_list')." bl join ".tablename('gpb_distribution_list_order')." blo on bl.dl_id = blo.l_id join ".tablename('gpb_order')." o on o.go_id = blo.go_id where bl.dl_status = 20 and o.go_status = 30 and go_team_openid = '".$openid."'");
		if($blid){
			$blid = true;
		}else{
			$blid = false;
		}
		//团长管理页面显示隐藏
		$management =  pdo_get($this->config,array('key'=>'select_management','weid'=>$this->weid));
        $data = [
            'today_all_money' => $today_all_money,
            'today_all_order' => $today_all_order,
            'today_commission' => $today_commission,
            'all_commission_no_pay' => $all_commission_no_pay,
            'all_commission' => $all_commission,
            'team' => $team,
            'vg' => $vg,
            'get_cash_limit_money' => isset($get_cash_limit_money['value']) ? floatval($get_cash_limit_money['value']) : 0,
            'head_recommend_open' => $head_recommend_open,//是否推荐
            'recommend_people_num' => empty($recommend_people_num) ? 0 : $recommend_people_num,//推荐人数
            'recommend_money' => empty($recommend_money) ? '0.00' : $recommend_money,//推荐金额
            'today_recommend_dis' => empty($today_recommend_dis) ? '0.00' : $today_recommend_dis,//今日分销
            'history_recommend_dis' => empty($history_recommend_dis) ? '0.00' : $history_recommend_dis,//历史分销
            'head_agent_open' => $head_agent_open,//是否有分销
            'num_self_get' => $num_self_get,
            'num_head_send' => $num_head_send,
            'is_open_header_sure_order'=>$is_open_header_sure_order,
            'blid'=>$blid,
            'management'=>empty($management['value']) ? 2 : $management['value'],
        ];
        $this->result("0", "团长管理页查询成功", $data);
    }



    /**

     *查看团长推荐数据中心

     */

    public function doPageseeTeamRecommend()

    {

        global $_GPC, $_W;

        $openid = $_GPC['openid'];//当前团长的openid

        if (empty($openid)) {

            $this->result(1, '请传入openid');

        }

        $team = pdo_get($this->member, array('m_openid' => $openid));

//        $vg = pdo_get($this->vg,array('openid'=>$openid));



        $today = date("Y-m-d", time());

        $start_today = strtotime($today . " 00:00:00");

        $end_today = strtotime($today . " 23:59:59");

        //查看是否开启团长推荐

        $head_recommend_open_arr = pdo_get($this->config, array('key' => 'head_recommend_open', 'weid' => $this->weid));

        $head_recommend_open = isset($head_recommend_open_arr['value']) ? $head_recommend_open_arr['value'] : 2;

        if ($head_recommend_open == 1) {

            //开启推荐

            //查询推荐人数

            $recommend_people_num = pdo_fetchcolumn('select count(*) from ' . tablename('gpb_head_commond_log') . ' where status =1 and weid=' . $this->weid . ' and pid = ' . $team['m_id']);



            //推荐奖励累计

            $recommend_money = pdo_fetch('select sum(`get_money`) as total from ' . tablename('gpb_head_commond_log') . 'where status =1 and weid=' . $this->weid . ' and pid = ' . $team['m_id']);

            $recommend_money = isset($recommend_money['total']) ? floatval($recommend_money['total']) : '0.00';



        }

        //是否开启推广代理团长

        $head_agent_open_arr = pdo_get($this->config, array('key' => 'head_agent_open', 'weid' => $this->weid));

        $head_agent_open = isset($head_agent_open_arr['value']) ? $head_agent_open_arr['value'] : 2;

        if ($head_agent_open == 1) {

            //今日有效订单

//            $today_recommend_order_num = pdo_fetchcolumn('select count(*) from ' . tablename('gpb_head_money_log') . 'where status =1 and weid=' . $this->weid . ' and `type` =1 and type_from=1 and create_time >=' . $start_today . ' and create_time <=' . $end_today . ' and uid = ' . $team['m_id']);

            //2020-03-11 周龙 优化有效订单计算方式
            $all_order = pdo_fetchall("select order_code from ".tablename("gpb_head_money_log")." where status =1 and weid={$this->weid} and `type`=1 and type_from=1 and create_time >={$start_today} and create_time<={$end_today} and uid={$team['m_id']} group by order_code");
            if(!empty($all_order)){
                $sn = [];
                foreach ($all_order as $k=>$v){
                    $sn[] = $v['order_code'];
                }
                $sn = implode(",",$sn);
                $today_recommend_order_num = pdo_fetchcolumn("select count(*) from ".tablename($this->order)." where go_code in ({$sn}) and go_status=100");
            }else{
                $today_recommend_order_num = 0;
            }

            $today_recommend_order_num = empty($today_recommend_order_num) ? 0 : $today_recommend_order_num;



            //预估佣金

            $today_recommend_order_commission = pdo_fetch('select sum(money) as total from ' . tablename('gpb_head_money_log') . 'where status =1 and weid=' . $this->weid . ' and `type` =1 and type_from=1 and create_time >=' . $start_today . ' and create_time <=' . $end_today . ' and uid = ' . $team['m_id']);

            $today_recommend_order_commission_dec = pdo_fetch('select sum(money) as total from ' . tablename('gpb_head_money_log') . 'where status =1 and weid=' . $this->weid . ' and `type` =2 and type_from=1 and create_time >=' . $start_today . ' and create_time <=' . $end_today . ' and uid = ' . $team['m_id']);
            if(empty($today_recommend_order_commission['total'])){
                $today_recommend_order_commission['total'] = 0;
            }else{
                $today_recommend_order_commission['total'] -= !empty($today_recommend_order_commission_dec['total'])?$today_recommend_order_commission_dec['total']:0;
            }

            $today_recommend_order_commission = !isset($today_recommend_order_commission['total']) ? '0.00' : $today_recommend_order_commission['total'];



            //今日成交额

            $today_recommend_order_money = pdo_fetch('select sum(go_real_price) as total from ' . tablename('gpb_head_money_log') . ' as hml left join ' . tablename('gpb_order') . ' as o on o.go_code = hml.order_code where status =1 and hml.weid=' . $this->weid . ' and hml.`type` =1 and type_from=1 and create_time >=' . $start_today . ' and create_time <=' . $end_today . ' and uid = ' . $team['m_id']);

            $today_recommend_order_money = !isset($today_recommend_order_money['total']) ? '0.00' : $today_recommend_order_money['total'];



            //累计佣金

            $history_recommend_order_commission = pdo_fetch('select `money` as total from ' . tablename('gpb_head_money') . 'where status =1 and weid=' . $this->weid . ' and uid = ' . $team['m_id']);

            $history_recommend_order_commission = !isset($history_recommend_order_commission['total']) ? '0.00' : $history_recommend_order_commission['total'];

        }

        //团长分销提现限额

        $head_agent_limit_cash = pdo_get($this->config, array('key' => 'head_agent_limit_cash', 'weid' => $this->weid));

        $head_agent_limit_cash = !isset($head_agent_limit_cash['value']) ? '0.00' : $head_agent_limit_cash['value'];





        //团长分销提现限额

        $head_agent_rule = pdo_get($this->config, array('key' => 'head_agent_rule', 'weid' => $this->weid));

        $head_agent_rule = !isset($head_agent_rule['value']) ? '请设置相关规则说明' : $head_agent_rule['value'];

        if($this->check_base64_out_json($team['m_nickname'])){

            $team['m_nickname'] = base64_decode($team['m_nickname']);

        }

        $data = [

            'team' => $team,

            'head_recommend_open' => $head_recommend_open,//是否推荐

            'recommend_people_num' => empty($recommend_people_num) ? 0 : $recommend_people_num,//推荐人数

            'recommend_money' => empty($recommend_money) ? '0.00' : $recommend_money,//推荐金额

            'today_recommend_dis' => empty($today_recommend_dis) ? '0.00' : $today_recommend_dis,//今日分销

            'history_recommend_dis' => empty($history_recommend_dis) ? '0.00' : $history_recommend_dis,//历史分销

            'head_agent_open' => $head_agent_open,//是否有分销

            'today_recommend_order_num' => $today_recommend_order_num,//今日订单数

            'today_recommend_order_commission' => $today_recommend_order_commission,//预告佣金

            'today_recommend_order_money' => $today_recommend_order_money,//今天成交额

            'history_recommend_order_commission' => $history_recommend_order_commission,//累计佣金

            'head_agent_limit_cash' => $head_agent_limit_cash,//团长提现限额

            'head_agent_rule' => $head_agent_rule,

        ];

        $this->result("0", "团长推荐中心查询成功", $data);

    }



    /*

     * 团长提现到余额

     */

    public function doPageheadGetMoneyToBalance()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);//当前团长的openid

        if (empty($openid)) {

            $this->result(1, '请传入openid');

        }

        $head = pdo_get('gpb_member', array('m_openid' => $openid, 'm_is_head' => 2, 'weid' => $this->weid));

        if (empty($head)) {

            $this->result(1, '团长信息有误');

        }

        $type = trim($_GPC['type']);

        if (empty($type)) {

            $this->result(1, '未传入提现类型');

        }

        $money = trim($_GPC['money']);

        if (empty($money)) {

            $this->result(1, '提现金额有误');

        }

        switch ($type) {

            case '1':

                //团长分销佣金提现到余额

                $head_recommed_money = pdo_get('gpb_head_money', array('weid' => $this->weid, 'uid' => $head['m_id'], 'check_state' => 1));

                if (empty($head_recommed_money)) {

                    $this->result(1, '团长分销推荐数据异常');

                }

                $head_recommed_money_num = !isset($head_recommed_money['money']) ? 0 : $head_recommed_money['money'];

                //查看是否开启团长推荐

                $head_recommend_open_arr = pdo_get($this->config, array('key' => 'head_recommend_open', 'weid' => $this->weid));

                if (!isset($head_recommend_open_arr['value']) || $head_recommend_open_arr['value'] != 1) {

                    $this->result(1, '未开启团长推荐分销');

                }

                //团长分销提现限额

                $head_agent_limit_cash = pdo_get($this->config, array('key' => 'head_agent_limit_cash', 'weid' => $this->weid));

                $head_agent_limit_cash = !isset($head_agent_limit_cash['value']) ? '0.00' : $head_agent_limit_cash['value'];

                if ($money < $head_agent_limit_cash) {

                    $this->result(1, '未达到提现标准');

                }

                if ($money > floatval($head_recommed_money_num)) {

                    $this->result(1, '超过可提现金额');

                }

                if($this->check_base64_out_json( $head['m_nickname'] )){

                    $head['m_nickname'] = base64_decode( $head['m_nickname'] );

                }

                $data_log = array(

                    'uid' => $head['m_id'],

                    'info' => "团长{$head['m_nickname']}提款{$money}元到个人余额",

                    'weid' => $this->weid,

                    'create_time' => time(),

                    'update_time' => time(),

                    'status' => 1,

                    'type' => 4,

                    'order_code' => $this->nextId(),

                    'type_from' => 3

                );

                $res = pdo_insert('gpb_head_money_log', $data_log);

                $log_id = pdo_insertid();

                if (empty($res)) {

                    $this->result(1, '提现失败');

                }

                $res_head_money = pdo_update('gpb_head_money', array('money' => (floatval($head_recommed_money['money'] - floatval($money)))), array('uid' => $head['m_id']));

                if (empty($res_head_money)) {

                    pdo_delete('gpb_head_money_log', array('id' => $log_id));

                    $this->result(1, '提现失败');

                }

                $res_member = pdo_update('gpb_member', array('m_money' => (floatval($head['m_money'] + floatval($money)))), array('m_id' => $head['m_id']));

                if (empty($res_member)) {

                    pdo_delete('gpb_head_money_log', array('id' => $log_id));

                    pdo_update('gpb_head_money', array('money' => (floatval($head_recommed_money['money']))), array('uid' => $head['m_id']));

                    $this->result(1, '提现失败');

                }

                $this->result(0, '提现成功');

                break;

        }

        $this->result(1, '参数有误');

    }



    /*

    * 团长管理详细数据页

    */

    public function doPageseeTeamData()
    {
        global $_GPC, $_W;
        $openid = $_GPC['openid'];//当前团长的openid
        if (empty($openid)) {
            $this->result(1, '请传入openid');
        }
        $team = pdo_get($this->member, array('m_openid' => $openid));
        $today = date("Y-m-d", time());
        $start_today = strtotime($today . " 00:00:00");
        $end_today = strtotime($today . " 23:59:59");
        //总收入（佣金）
//      $all_commission = pdo_fetch("select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and go_pay_time >0 and sn.oss_ggo_status=1");
//      $all_commission = empty($all_commission['total']) ? 0 : $all_commission['total'];

        //总订单
        $all_order = pdo_fetchcolumn("select count(*) from " . tablename($this->order) . " where weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and go_status>10 and go_status!=110 and go_status!=120 and go_pay_time >0");
        $all_order = empty($all_order) ? 0 : $all_order;
        //总会员
        $all_member = pdo_fetchcolumn("select count(*) from " . tablename($this->member) . " as m where m_head_openid ='" . $openid . "'");
        $all_member = empty($all_member) ? 0 : $all_member;
        //查询今日销售额
        $today_all_money_sql = "select sum(go_real_price) as total from " . tablename($this->order) . " where weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "'  and go_pay_time >" . $start_today . " and go_pay_time < " . $end_today;
        $today_all_money_arr = pdo_fetch($today_all_money_sql);
        $today_all_money = $today_all_money_arr['total'];
        $today_all_money = empty($today_all_money) ? 0 : $today_all_money;
        //查询今天订单总数
        $today_all_order = pdo_fetchcolumn("select count(*)  from " . tablename($this->order) . " where weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "'and go_pay_time >" . $start_today . " and go_pay_time < " . $end_today);
        $today_all_order = empty($today_all_order) ? 0 : $today_all_order;
        //查询今天有效订单
        $today_all_order_pay = pdo_fetchcolumn("select count(*)  from " . tablename($this->order) . " where weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and go_status>10 and go_status!=110 and go_status!=120 and go_pay_time >" . $start_today . " and go_pay_time < " . $end_today);
        $today_all_order_pay = empty($today_all_order_pay) ? 0 : $today_all_order_pay;
        //查询今天有效订单
        $today_all_order_pay_people = pdo_fetchcolumn("select count(t.openid)  from ( select openid from " . tablename($this->order) . " where weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and go_status>10 and go_status!=110 and go_status!=120 and go_pay_time >" . $start_today . " and go_pay_time < " . $end_today . " group by openid) as t");
        $today_all_order_pay_people = empty($today_all_order_pay_people) ? 0 : $today_all_order_pay_people;
        //获取今日预计佣金
        $today_commission_sql = "select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and go_pay_time >" . $start_today . " and go_pay_time < " . $end_today;
        $today_commission_arr = pdo_fetch($today_commission_sql);
        $today_commission = $today_commission_arr['total'];
        $today_commission = empty($today_commission) ? 0 : $today_commission;
        //获取待结算佣金
        $all_commission_no_pay = pdo_fetch("select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and go_pay_time >0 and sn.oss_ggo_status=1 and o.go_is_cash=-1");
        $all_commission_no_pay = empty($all_commission_no_pay['total']) ? 0 : $all_commission_no_pay['total'];
        //查询团长订单数量
        //获取每个状态的订单数量
        $num1 = pdo_fetch(" select count(*) as count from " . tablename($this->order) . " where go_status = 20 and `type`=1 and go_team_openid = '" . $openid . "'");
        $num2 = pdo_fetch(" select count(*) as count from " . tablename($this->order) . " where go_status = 30 and `type`=1 and go_team_openid = '" . $openid . "'");
        $num3 = pdo_fetch(" select count(*) as count from " . tablename('gpb_back_money') . " as bk left join " . tablename($this->order) . " as o on o.go_code = bk.gbm_go_code where gbm_status = 10 or gbm_status=30 and o.`type`=1 and go_team_openid = '" . $openid . "'");
        //团长今日配送费
        $today_head_send_price = pdo_fetch('select sum(`go_send_pay`) as total from ' . tablename($this->order) . ' where go_status = 100 and `type`=1 and go_team_openid="' . $openid . '" and go_send_price_status=2 and go_pay_time >=' . $start_today . ' and go_pay_time <' . $end_today);
        $today_head_send_price = empty($today_head_send_price['total']) ? 0 : $today_head_send_price['total'];
        //团长累计配送费
        $all_head_send_price = pdo_fetch('select sum(`go_send_pay`) as total from ' . tablename($this->order) . ' where go_status = 100 and `type`=1 and go_team_openid="' . $openid . '" and go_send_price_status=2 and go_pay_time >=0 ');
        $all_head_send_price = empty($all_head_send_price['total']) ? 0 : $all_head_send_price['total'];
        /**2019-11-29*/
        //总收入（佣金）
        $all_commission = pdo_fetch("SELECT SUM(go_commission) AS total FROM ".tablename('gpb_order')." WHERE weid = ".$this->weid." AND go_team_openid='".$openid."' AND go_status = 100");
        $all_commission = empty($all_commission['total']) ? 0 : $all_commission['total'];

        /**2019-11-29结束*/
        if($this->check_base64_out_json( $team['m_nickname'] )){
            $team['m_nickname'] = base64_decode( $team['m_nickname'] );
        }
//      $all_commission = $all_commission_no_pay+$team['m_money'];

        $data = [

            'today_all_money' => $today_all_money,//查询今日销售额

            'today_all_order' => $today_all_order,//查询今天订单总数

            'today_commission' => $today_commission,//获取今日预计佣金

            'today_all_order_pay' => $today_all_order_pay,//查询今天有效订单

            'today_all_order_pay_people' => $today_all_order_pay_people,//查询今天有效订单

            'all_commission_no_pay' => $all_commission_no_pay,//获取待结算佣金

            'all_commission' => $all_commission,//总收入

            'all_member' => $all_member,//总会员

            'all_order' => $all_order,//总订单

            'team' => $team,//团长信息

            'cash' => $team['m_money'],//可提现金额

            'num1' => $num1,//待发货订单数

            'num2' => $num2,//待收货/核销订单数

            'num3' => $num3,//正在售后、售后失败总数

            'today_head_send_price' => $today_head_send_price,

            'all_head_send_price' => $all_head_send_price,

        ];

        $this->result("0", "团长管理页查询成功", $data);

    }



    /*

     * 团长-我的钱包

     */

    public function doPageTeamWallet()
    {
        global $_GPC, $_W;
        $openid = $_GPC['openid'];//当前团长的openid

        if (empty($openid)) {

            $this->result(1, '请传入openid');

        }

		$team = pdo_get("gpb_member",array('m_openid'=>$openid));

        //查询本月收入

        $today = date("Y-m-d", time());

        $start_today = strtotime($today . " 00:00:00");

        $end_today = strtotime($today . " 23:59:59");

        $beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));

        $endThismonth = mktime(23, 59, 59, date('m'), date('t'), date('Y'));



        //获取今日预计佣金

        $today_commission = pdo_fetch("select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $this->weid . " and  (o.go_status = 100 or o.go_status = 20 or o.go_status = 30) and `type`=1 and go_team_openid='" . $openid . "' and go_pay_time >" . $start_today . " and go_pay_time < " . $end_today);

        $today_commission = empty($today_commission['total']) ? 0 : $today_commission['total'];



        //本月收入

        $month_commission = pdo_fetch("select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and sn.oss_ggo_status = 1 and go_pay_time >" . $beginThismonth . " and go_pay_time < " . $endThismonth);

        $month_commission = empty($month_commission['total']) ? 0 : $month_commission['total'];



        //总收入（佣金）

        $all_commission = pdo_fetch("select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $this->weid . " and `type`=1 and go_team_openid='" . $openid . "' and go_pay_time >0 and sn.oss_ggo_status=1");

        $all_commission = empty($all_commission['total']) ? 0 : $all_commission['total'];



        //待确认/结算（佣金）

//      $wait_commission = pdo_fetch("select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $this->weid . " and o.go_status = 100 and `type`=1 and go_team_openid='" . $openid . "' and go_pay_time >0 and sn.oss_ggo_status=1 and go_is_cash =-1");

		/**2019-11-29*/
		$wait_commission = pdo_fetch("SELECT SUM(go_commission) AS total FROM ".tablename('gpb_order')." WHERE weid = ".$this->weid." AND go_team_openid='".$openid."' AND go_status = 100 and go_is_cash = -1");
		$wait_commission = $wait_commission['total'] ? $wait_commission['total'] : 0;
//      $wait_commission =  pdo_fetch("SELECT SUM(gos_order_money) as total FROM ".tablename('gpb_order_stream')." s WHERE weid= ".$this->weid." AND s.gos_team_openid = '".$openid."' AND s.gos_stream_type = 3 AND gos_status = 1");
//      $wait_commission = empty($wait_commission['total']) ? 0 : $wait_commission['total'];

        //可提现（佣金）

//        $wait_cash_commission= pdo_fetch("select sum(oss_commission) as total from ".tablename($this->snapshot)." as sn left join   ".tablename($this->order)." as o on o.go_code=sn.oss_go_code where o.weid=".$this->weid." and `type`=1 and go_team_openid='".$openid."' and go_pay_time >0 and sn.oss_ggo_status=1 and go_is_cash =1");

//        $wait_cash_commission = empty($wait_cash_commission['total'])?0:$wait_cash_commission['total'];

        //已打款金额

        $already_cash_commission = pdo_fetch("select sum(ggc_money) as total from " . tablename('gpb_get_cash') ." as ggc where ggc_type=20 and openid= '".$openid."'");

//        "select sum(oss_commission) as total from ".tablename($this->snapshot)." as sn left join   ".tablename($this->order)." as o on o.go_code=sn.oss_go_code where o.weid=".$this->weid." and `type`=1 and go_team_openid='".$openid."' and go_pay_time >0 and sn.oss_ggo_status=1 and go_is_cash =2";

        $already_cash_commission = empty($already_cash_commission['total']) ? 0 : $already_cash_commission['total'];

		$all_commission = $wait_commission+$team['m_money']+$already_cash_commission;//2019-8-15

        $data = [

            'today_commission' => $today_commission,//获取今日预计佣金

            'month_commission' => $month_commission,//本月收入

            'all_commission' => $all_commission,//总收入

            'wait_commission' => $wait_commission,//待确认/结算（佣金）

//            'wait_cash_commission'=>$wait_cash_commission,//可提现（佣金）

            'already_cash_commission' => $already_cash_commission,//已打款金额

        ];

        $this->result("0", "团长管理页查询成功", $data);

        exit;

    }



    /*

     * 团长分佣中心

     */

    public function doPageTeamCommissionCenter()

    {

        global $_GPC, $_W;

        $openid = $_GPC['openid'];//当前团长的openid

        if (empty($openid)) {

            $this->result(1, '请传入openid');

        }

        //查询今日销售额

        $today = date("Y-m-d", time());

        $start_today = strtotime($today . " 00:00:00");

        $end_today = strtotime($today . " 23:59:59");

        //查已结算

        $sql_old = "select sum(go_commission) as total from " . tablename($this->order) . " where weid=" . $this->weid . " and go_team_openid='" . $openid . "' and `type`=1 and  go_is_cash in (1,2) ";

        $old_commission_arr = pdo_fetch($sql_old);

        $old_commission = $old_commission_arr['total'];

        $old_commission = empty($old_commission) ? 0 : $old_commission;



        //查未结算

        $sql_new = "select sum(go_commission) as total from " . tablename($this->order) . " where weid=" . $this->weid . " and go_team_openid='" . $openid . "' and `type`=1 and  go_is_cash =-1 ";

        $new_commission_arr = pdo_fetch($sql_new);

        $new_commission = $new_commission_arr['total'];

        $new_commission = empty($new_commission) ? 0 : $new_commission;



        $user = pdo_get($this->member, array("m_openid" => $openid));

        if($this->check_base64_out_json( $user['m_nickname'] )){

            $user['m_nickname'] = base64_decode( $user['m_nickname'] );

        }

        $data = [

            'old_commission' => $old_commission,

            'new_commission' => $new_commission,

            'user' => $user

        ];

        $this->result("0", "分佣中心数据获取成功", $data);

    }



    /*

     * 团长最近7天营业额

     */

    public function doPageTeamLastSenvenMoney()

    {

        global $_GPC, $_W;

        $openid = $_GPC['openid'];//当前团长的openid

        if (empty($openid)) {

            $this->result(1, '请传入openid');

        }

        //查询7天前

        $day = date("Y-m-d", time() - 7 * 24 * 60 * 60);

        $start_today = strtotime($day . " 00:00:00");

        $sql = "SELECT FROM_UNIXTIME(go_add_time,'%m-%d') AS days,COUNT(*) AS num ,SUM(go_real_price) AS total FROM " . tablename($this->order) . " AS o WHERE      weid=" . $this->weid . " and o.go_team_openid='" . $openid . "' and go_pay_time > '" . $start_today . "' and `type`=1 GROUP BY days order by go_pay_time desc ";

        $res = pdo_fetchall($sql);

        $data = $money = [];

        $day = 0;

        if (!empty($res)) {

            foreach ($res as $k => $v) {

                $data[$k] = $v['days'];

                $money[$k] = $v['total'];

                $day += $v['total'];

            }

        }



        $this->result("0", "最近7天销售额统计查询成功", ['data' => $data, 'money' => $money, 'day' => $day]);

    }



    /**

     * 团长输入核销码查询订单//todo  未算佣金

     */

    public function doPageWatir()

    {

        global $_GPC, $_W;

        $id = $_GPC['id'];//核销码

        if (empty($id)) {

            $this->result(1, '请输入提货码');

        }

        $is_arr = explode(",", $id);

//        var_dump($is_arr);exit;

        if (count($is_arr) > 1) {

            //扫码来的

            $id = $is_arr[0];

            $time = $is_arr[1];

        } else {

            //输入码来的

            $id = $is_arr[0];

        }

        $openid = $_GPC['openid'];//当前输入提货码的人的openid

        if (empty($openid)) {

            $this->result(1, '请传入openid');

        }

        $member = pdo_get($this->member, array('m_get_good_code' => $id));



        if (empty($member)) {

            $this->result(1, '提货码不存在，请重新在试');

        }

        //获取团长的信息

        $team = pdo_get($this->member, array('m_openid' => $openid));

        if (empty($team)) {

            $this->result(1, '查找不到团长信息');

        }

        //查询该提货码下面的订单 并且在这个团长下面的订单

        $sql = " select * from " . tablename($this->order) . " where weid=" . $this->weid . " and `type`=1 and openid = '" . $member['m_openid'] . "' and go_team_openid = '" . $openid . "' and go_status = 30 ";

//        var_dump($sql);exit;



        $list = pdo_fetchall($sql);

//		$list = pdo_getall($this->order,array('openid'=>$member['m_openid'],'go_team_openid'=>$openid,'go_status'=>''));

        if (!empty($list)) {

            foreach ($list as $k => $v) {

                //获取商品信息

                $info = pdo_getall($this->snapshot, array('oss_go_code' => $v['go_code']));

                foreach ($info as $kk => $vv) {

//                    $info[$kk]['oss_g_icon'] = $this->http.$vv['oss_g_icon'];

                    $info[$kk]['oss_g_icon'] = tomedia($vv['oss_g_icon']);

                    $photo = pdo_fetch("select m_photo from " . tablename($this->member) . " where weid=" . $this->weid . " and m_openid ='" . $vv['oss_buy_openid'] . "'");

                    $info[$kk]['m_photo'] = $photo['m_photo'];

					if($this->check_base64_out_json( $info[$kk]['oss_address_name'] )){

			        	$info[$kk]['oss_address_name'] = base64_decode( $info[$kk]['oss_address_name'] );

			        }

                }

                $list[$k]['item'] = $info;

                $list[$k]['checked'] = false;



            }

        }

        $this->result(0, '', $list);

    }



    /**

     * 团长核销订单

     */

    public function doPageWatirorders()

    {

        global $_GPC, $_W;



        $openid = $_GPC['openid'];

        $id = trim($_GPC['id'], ',');//订单id   可以是数字  也可以是字符串

        if (empty($openid)) {

            $this->result('1', '请传入openid');

        }

//        $is_arr = explode(",",$id);

//        if(count($is_arr)>1){

//            //扫码来的

//            $id = $is_arr[0];

//            $time = $is_arr[1];

//        }else{

//            //输入码来的

//            $id =$is_arr;

//        }

        if (empty($id)) {

            $this->result(1, '请选择要核销的订单');

        }

        $team = pdo_get($this->member, array('m_openid' => $openid, "weid" => $this->weid));

        if($this->check_base64_out_json( $team['m_nickname'] )){

            $team['m_nickname'] = base64_decode( $team['m_nickname'] );

        }

        $id = trim($id, ',');

//        $parsent = $team['m_commission']/100;//佣金比例



//        if(empty($team['m_commission']) || $team['m_commission']<=0){

//            $this->result(1,'请联系管理员设置分佣比例',[]);

//        }





        //订单详情

        $order_info = pdo_fetchall("select * from " . tablename($this->order) . " where weid=" . $this->weid . " and `type`=1 and `go_id` in (" . $id . ")");
        if(empty($order_info)){
            $this->result(1, '订单不存在', []);
        }
        $order_sn = [];
        foreach ($order_info as $k=>$v){
            $order_sn[] = $v['go_code'];
        }
        $order_sn = count($order_sn)>1?implode(",",$order_sn):$order_sn[0];
        //2020-02-25 先检查是否已核销 周龙
        $has = pdo_fetchcolumn("select count(*) from ".tablename($this->sure_order)." where we_id={$this->weid} and so_is_del=1 and so_status=1 and so_go_code in ({$order_sn})");
        if($has>0){

            $this->result(1, '该订单已核销', []);
        }

        pdo_begin();

        foreach ($order_info as $k => $v) {

            //查找商品快照表,计算总佣金

            $snapshot_list = pdo_fetchall("select * from " . tablename($this->snapshot) . " as sn where sn.oss_go_code =" . $v['go_code'] . " ");

            $go_commission = 0;

            foreach ($snapshot_list as $key => $val) {

                $go_commission += floatval($val['oss_commission']);

            }

            $order = pdo_get($this->order, array('go_id' => $v["go_id"], 'type' => 1, 'weid' => $this->weid));

            $user = pdo_get($this->member, array('m_openid' => $order['openid']));

            if($this->check_base64_out_json( $user['m_nickname'] )){

                $user['m_nickname'] = base64_decode( $user['m_nickname'] );

            }

            $head_price = '';

            if ($order['go_send_type'] == 2) {

                $head_price .= ',go_send_price_status=2';

            }

            if ($order['go_status'] == 30) {

                $sql = "update " . tablename($this->order) . " set `go_status` = '100' , `go_commission` = '" . $go_commission . "',`go_commission_num`=0,go_commission_time=" . time() . $head_price . " where weid=" . $this->weid . " and `type`=1 and `go_id`=" . $v['go_id'];

                $res = pdo_query($sql);

                //核销记录   todo

                if (empty($res)) {

                    pdo_rollback();

                    $this->result(1, '核销失败', []);

                } else {

                    pdo_update($this->member, array('m_send_price_total' => (floatval($order['go_send_pay']) + floatval($user['m_send_price_total'])), 'm_money' => (floatval($user['m_money']) + floatval($order['go_send_pay']))), array('m_id' => $user['m_id']));

                    $data = [


                        'so_buy_people' => $order['openid'],

                        'so_sure_people' => $team['m_openid'],

                        'so_add_time' => time(),

                        'so_status' => 1,

                        'so_buy_name' => $team['m_nickname'],

                        'so_sure_name' => $user['m_nickname'],

                        'so_go_code' => $order['go_code'],

                        'we_id' => $this->weid

                    ];

                    $res = pdo_insert($this->sure_order, $data);

                    if (empty($res)) {

                        pdo_rollback();

                        $this->result(1, '核销失败', []);

                    }

                }

                //生成流水表-佣金

                $order_snapshot = pdo_fetchall("select * from " . tablename($this->snapshot) . " where oss_go_code =" . $order['go_code']);

                $data_stream = array(

                    'gos_code' => date('Ymd', time()) . $this->nextId(),//流水号

                    'gos_go_code' => $order['go_code'],//订单号

                    'gos_stream_type' => 3,

                    'gos_type' => 2,

                    'gos_pay_type' => 1,

                    'gos_owner' => '平台',

                    'gos_payer' => $order_snapshot[0]['oss_buy_name'],

                    'gos_team' => $order_snapshot[0]['oss_head_name'],

                    'gos_commet' => '团长核销后确认收货产生佣金',

                    'gos_order_money' => $go_commission,

                    'gos_real_money' => 0,

                    'gos_sure_pay_time' => time(),

                    'gos_status' => 1,

                    'gos_add_time' => time(),

                    'weid' => $this->weid,

                    'gos_payer_openid' => $order_snapshot[0]['oss_buy_openid'],

                    'gos_team_openid' => $order_snapshot[0]['oss_head_openid']

                );

                //开启自动审核佣金后

                $auto_sure_head_commission = pdo_get($this->config, array('key' => 'auto_sure_head_commission', 'weid' => $this->weid));

                $auto_sure_head_commission = isset($auto_sure_head_commission['value']) ? $auto_sure_head_commission['value'] : 2;

                if ($auto_sure_head_commission == 1) {

                    $data_stream['gos_real_money'] = $go_commission;

                    $data_stream['gos_status'] = 2;

                    $data_stream['gos_commet'] = '团长核销后确认收货产生佣金,自动审核通过该佣金';

                    $data_stream['gos_sure_pay_time'] = time();



                    //订单佣金自动审核

                    pdo_update('gpb_order', array('go_is_cash' => 1), array('go_id' => $order['go_id']));

                    pdo_update($this->member, array('m_money +=' => $go_commission), array('m_openid' => $order['go_team_openid'], 'weid' => $this->weid));

                }

				$i = pdo_fetch(" select * from ".tablename("gpb_order_stream")." where gos_stream_type = 3 and gos_go_code = ".$order['go_code']);

		        if(empty($i)){

			        pdo_insert($this->stream, $data_stream);

		        }

            } else {

                unset($order_info[$k]);

            }



        }



        pdo_commit();





//    $sql = "update ".tablename($this->order)." set `go_status` = 100 WHERE `go_id` in (".$id.")";

//

//

//    $res = pdo_query($sql);

        if (empty($res)) {

            $this->result(1, '核销失败', []);

        } else {


            foreach ($order_info as $k => $v) {

 if(!empty(WeUtility::createModuleHook("group_buy_plugin_fraction"))) {

                    @$this->doPageFraction_order_Detailed(array('order' => $v['go_code']));

                }
                if(!empty(WeUtility::createModuleHook("group_buy_plugin_distribution"))) {
                    //分销佣金计算qdis

                    $distribution = pdo_get($this->config, ['weid' => $this->weid, 'key' => 'distribution_state']);

                    if (!empty($distribution) && $distribution['value'] == 1) {

                        //存在并开启

                        @$resutl = $this->doPageDistribution_user_cost(['osn' => $v['go_code']]);

//            echo "<pre/>";

//            exit(var_dump($resutl));

                    }
                }

                //团长推荐分销

                $resutl_log = $this->headcost($v['go_code']);

                //存日志

                $file = dirname(__FILE__) . '/headrecommedmomey.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个

                if (file_exists($file) && filesize($file) > 100000) {

                    unlink($file);//这里是直接删除，

                }

                $content = date('Y-m-d H:i:s');

                $content .= "团长核销计算推荐分销佣金,oid={$v['go_code']}\n";

                foreach ($resutl_log as $k => $v) {

                    $content .= "{$k}={$v}\n";

                    if ($k == 'data') {

                        foreach ($resutl_log[$k] as $kk => $vv) {

                            $content .= "{$kk}={$vv}\n";

                        }

                    }


                }

                $content .= "------\n";

                file_put_contents($file, $content . PHP_EOL, FILE_APPEND);

            }
            $this->result(0, '核销成功', []);

        }



    }



    /*

     * 用户自己确认收货

     */

    public function doPageuserSureGoods()

    {



        global $_GPC, $_W;

        $id = $_GPC['id'];

        $openid = $_GPC['openid'];

        if (empty($id)) {

            $this->result(1, '非法进入');

        }

        if (empty($openid)) {

            $this->result(1, '用户未授权');

        }

        $user = pdo_get('gpb_member', array('m_openid' => $openid));

        if (empty($user)) {

            $this->result(1, '用户有误');

        }



        //获取订单信息

        $info = pdo_get($this->order, array('go_id' => $id, 'weid' => $this->weid, 'type' => 1));
        if (empty($info)) {

            $this->result(1, '该订单不存在');

        }

        if ($info['go_status'] != 30) {

            $this->result(1, '该订单已被处理');

        }

        //查找商品快照表,计算总佣金

        $snapshot_list = pdo_fetchall("select * from " . tablename($this->snapshot) . " as sn where sn.oss_go_code =" . $info['go_code'] . " ");

        $go_commission = 0;

        foreach ($snapshot_list as $key => $val) {

            $go_commission += floatval($val['oss_commission']);

        }

//        $team = pdo_get($this->member,array('m_openid'=>$info['go_team_openid'],"weid"=>$this->weid));

//        $parsent = $team['m_commission']/100;//佣金比例

//        $go_commission = $parsent*$info['go_real_price'];

//        $go_commission_num = $parsent*100;

        $head_price = '';

        if ($info['go_send_type'] == 2) {

            $head_price .= ',go_send_price_status=2';

        }

        $sql = "update " . tablename($this->order) . " set `go_status` = '100' , `go_commission` = '" . $go_commission . "',`go_commission_num`=0,go_commission_time=" . time() . $head_price . " where weid=" . $this->weid . " and `type`=1 and `go_id`=" . $info['go_id'];

        $res = pdo_query($sql);

        //2020-04-01 周龙 如果配送方式为自提货这快递 给团长的配送费为0
        if(intval($info['go_send_type'])===3 || intval($info['go_send_type'])===1){
            $info['go_send_pay'] = 0;
        }

        pdo_update($this->member, array('m_send_price_total' => (floatval($info['go_send_pay']) + floatval($user['m_send_price_total'])), 'm_money' => (floatval($user['m_money']) + floatval($info['go_send_pay']))), array('m_id' => $user['m_id']));

        //生成流水表-佣金

        $order_snapshot = pdo_fetchall("select * from " . tablename($this->snapshot) . " where oss_go_code =" . $info['go_code']);

        $data_stream = array(

            'gos_code' => date('Ymd', time()) . $this->nextId(),//流水号

            'gos_go_code' => $info['go_code'],//订单号

            'gos_stream_type' => 3,

            'gos_type' => 2,

            'gos_pay_type' => 1,

            'gos_owner' => '平台',

            'gos_payer' => $order_snapshot[0]['oss_buy_name'],

            'gos_team' => $order_snapshot[0]['oss_head_name'],

            'gos_commet' => '用户自己确认收货产生佣金',

            'gos_order_money' => $go_commission,

            'gos_real_money' => 0,

            'gos_sure_pay_time' => time(),

            'gos_status' => 1,

            'gos_add_time' => time(),

            'weid' => $this->weid,

            'gos_payer_openid' => $order_snapshot[0]['oss_buy_openid'],

            'gos_team_openid' => $order_snapshot[0]['oss_head_openid']

        );

        //开启自动审核佣金后

        $auto_sure_head_commission = pdo_get($this->config, array('key' => 'auto_sure_head_commission', 'weid' => $this->weid));

        $auto_sure_head_commission = isset($auto_sure_head_commission['value']) ? $auto_sure_head_commission['value'] : 2;

        if ($auto_sure_head_commission == 1) {

            $data_stream['gos_real_money'] = $go_commission;

            $data_stream['gos_status'] = 2;

            $data_stream['gos_commet'] = '用户自己确认收货产生佣金,自动审核通过该佣金';

            $data_stream['gos_sure_pay_time'] = time();

			if(!empty($go_commission)){

				pdo_update('gpb_order', array('go_is_cash' => 1), array('go_id' => $info['go_id']));

	            $ress = pdo_update($this->member, array('m_money +=' => $go_commission), array('m_openid' => $info['go_team_openid'], 'weid' => $this->weid));

				if(empty($ress)){

					$data_stream['gos_status'] = 1;

					$file = dirname(__FILE__) . '/order_money.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个

			        if (file_exists($file) && filesize($file) > 100000) {

			            unlink($file);//这里是直接删除，

			        }

					$content .= "用户自己确认收货后团长佣金没有到账,oid={$info['go_code']}\n";

					$content.= "money = {$go_commission},\nteam_openid={$info['go_team_openid']}\n";

					file_put_contents($file, $content . PHP_EOL, FILE_APPEND);

				}

			}

            //订单佣金自动审核



        }

        pdo_insert($this->stream, $data_stream);


         if(!empty(WeUtility::createModuleHook("group_buy_plugin_distribution"))) {
            //分销佣金计算

            $distribution = pdo_get($this->config, ['weid' => $this->weid, 'key' => 'distribution_state']);

            if (!empty($distribution) && $distribution['value'] == 1) {

                //存在并开启qdis

                @$resutl = $this->doPageDistribution_user_cost(['osn' => $info['go_code']]);

                @$resutl = $this->doPageDistribution_commoneds(['openid' => $openid, 'go_code' => $info['go_code']]);

        //			echo '1A';exit;

            }
        }
        //团长推荐分销

        $resutl_log = $this->headcost($info['go_code']);
        //存日志

        $file = dirname(__FILE__) . '/headrecommedmomey.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个

        if (file_exists($file) && filesize($file) > 100000) {

            unlink($file);//这里是直接删除，

        }

        $content = date('Y-m-d H:i:s');

        $content .= "用户自己确认收货后团长算佣金,oid={$info['go_code']}\n";

        foreach ($resutl_log as $k => $v) {

            $content .= "{$k}={$v}\n";

            if ($k == 'data') {

                foreach ($resutl_log[$k] as $kk => $vv) {

                    $content .= "{$kk}={$vv}\n";

                }

            }

        }

        $content .= "------\n";

        file_put_contents($file, $content . PHP_EOL, FILE_APPEND);



        if (empty($res)) {

            $this->result(1, '确认收货失败', []);

        } else {
            //积分插件 先判断是否安装插件
            if(!empty(WeUtility::createModuleHook("group_buy_plugin_fraction"))){
                @$this->doPageFraction_order_Detailed(array('order' => $info["go_code"]));
            }


            $this->result(0, '确认收货成功', []);

        }

    }



    /**

     * 根据订单id获取订单信息

     */

    public function doPagegetorderDetails()
    {
        global $_GPC, $_W;
        $id = $_GPC['id'];
        if (empty($id)) {
            $this->result(1, '非法进入');
        }

        //获取订单信息

        $info = pdo_get($this->order, array('go_id' => $id, 'weid' => $this->weid));

        if (empty($info)) {

            $this->result(1, '该订单不存在');

        }

        //获取订单商品

//		$list = pdo_getall($this->snapshot,array('oss_go_code'=>$info['go_code']));

        $list = pdo_fetchall("select * from " . tablename($this->snapshot) . " as sn  left join " . tablename($this->action) . " as a on sn.oss_ac_id = a.at_id where oss_go_code=" . $info['go_code']);

        if (!empty($list)) {

            foreach ($list as $k => $v) {

//				$list[$k]['oss_g_icon'] = $this->http.$v['oss_g_icon'];

                $list[$k]['oss_g_icon'] = tomedia($v['oss_g_icon']);

                $list[$k]['arrival_time'] = date('Y-m-d', $info['go_add_time'] + intval($v['at_arrival_time']) * 24 * 60 * 60);

                if($this->check_base64_out_json( $v['oss_buy_name'] )){

                    $list[$k]['oss_buy_name'] = base64_decode( $v['oss_buy_name'] );

                }

                if($this->check_base64_out_json( $v['oss_address_name'] )){

                    $list[$k]['oss_address_name'] = base64_decode( $v['oss_address_name'] );

                }

            }

            if($list[0]['oss_is_seckill']==3){

                //是拼团订单获取对应拼团团队信息

                //查询订单所属团队

                $porder = pdo_fetch("select * from ".tablename("gpb_pteam_order")." where `osn`='{$info['go_code']}'");

                $pteam = pdo_fetch("select a.*,pl.star_time as act_star_time,pl.end_time as act_end_time from ".tablename("gpb_pteam_activity")." as a join ".tablename("gpb_pteam_list")." as pl on pl.id=a.pl_id where a.`id`={$porder['aid']}");

                if(!empty($pteam)){

                    $pteam_time = time();

                    if($pteam['end_time']<$pteam_time && $pteam['now_num']<$pteam['all_num']){

                        //拼团失败状态修改

                        $pteam_update = [

                            'state'=>-1,

                            'utime'=>$pteam_time,

                        ];

                        $res = pdo_update("gpb_pteam_activity",$pteam_update,['id'=>$pteam['id']]);

                        $pteam['state'] = -1;

                    }

                    $info['pteam'] = $pteam;

                    //获取开团人员信息

                    $pteam_ladder = pdo_fetch("select m_nickname,m_photo from ".tablename($this->member)." where m_openid='{$pteam['leader_openid']}' and weid={$this->weid}");

                    $pteam_ladder['m_nickname'] = $this->check_base64_out_json($pteam_ladder['m_nickname'])?base64_decode($pteam_ladder['m_nickname']):$pteam_ladder['m_nickname'];

                    $info['pteam']['leader_nickname'] = $pteam_ladder['m_nickname'];

                    $info['pteam']['leader_avatar'] = $pteam_ladder['m_photo'];

                }

            }

            $info['item'] = $list;

        }

        //获取团长的信息

        $team = pdo_get($this->member, array('m_openid' => $info['go_team_openid'], 'weid' => $this->weid));

        if($this->check_base64_out_json( $team['m_nickname'] )){

            $team['m_nickname'] = base64_decode( $team['m_nickname'] );

        }

        $info['team'] = $team;

        $info['date'] = date('Y-m-d H:i', $info['go_add_time']);

        $info['number'] = count($list);

        $info['shipping_traces'] = unserialize($info['shipping_traces']);

        //当是快递运输时，查询快递信息

        if ($info['go_send_type'] == 3 && $info['go_status'] > 20 && $info['go_status'] < 100) {

            $shipping_traces = $this->goods_express($info['go_code']);

            if (!empty($shipping_traces)) {

                $info['shipping_traces'] = unserialize($shipping_traces);

            }

        }

        $order_info_recommed_goods_open = pdo_get($this->config, array('key' => 'order_info_recommed_goods_open', 'weid' => $this->weid));

        if (isset($order_info_recommed_goods_open['value']) && $order_info_recommed_goods_open['value'] == 1) {

            $order_info_recommed_goods_open = 1;

        } else {

            $order_info_recommed_goods_open = 2;

        }

        $info['recommed_goods_open'] = $order_info_recommed_goods_open;
		//获取是否开启催单功能
		$reminder_status = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'index_reminder_status'));
		$info['index_reminder_status'] = $reminder_status['value'] ? $reminder_status['value'] : 1;
		//获取团长的电话号码
		$member_tel = pdo_get("gpb_member",array('m_openid'=>$info['go_team_openid']),array('m_phone','tel'));
		if($member_tel['m_phone']){
			$info['member_phone'] = $member_tel['m_phone'];
		}else{
			if($member_tel['tel']){
				$tel = unserialize($member_tel['tel']);
				$info['member_phone'] = $tel[0];
			}
		}
        $this->result(0, '', $info);

    }



    /*

     * 获取收货地址

     */

    public function doPagegetAddress()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "error,请传入openid");

        }

        $sql = "select * from " . tablename($this->address) . " where weid=" . $this->weid . " and openid='" . $openid . "' and ra_is_del=1";

        $res = pdo_fetchall($sql);

        if (empty($res)) {

            $this->result("1", "error,读取地址失败，请重试");

        } else {

            $this->result("0", "success,读取地址成功", $res);

        }

    }



    /*

     * 获取省市区

     */

    public function doPagegetArea()

    {

        global $_GPC, $_W;

        $pid = intval($_GPC['pid']) ? intval($_GPC['pid']) : 0;

        $res = pdo_fetchall('select ad_code,name from ' . tablename("gpb_area") . ' where pid = ' . $pid);

        if (empty($res)) {

            $this->result("1", "读取失败，请重试");

        } else {

            $this->result("0", "读取成功", $res);

        }

    }



    /*

     * 获取全部可领取优惠卷

     */

    public function doPagegetAllTicket()

    {

        global $_GPC, $_W;

        $openid = $_GPC["openid"];

        if (empty($openid)) {

            $this->result("1", "请传入openid");

        }

        $type = trim($_GPC['type']);

        $where = ' and number>now_num ';

        if (!empty($type) && $type == 1) {

            $where = '';

        }

        $member = pdo_get('gpb_member', array('m_openid' => $openid));

        $sql = "select * from " . tablename($this->coupon) . " where weid=" . $this->weid . " and  end_time > " . time() . $where . " and status=1 and status=1";

        $res = pdo_fetchall($sql);

        $is_use = array();

        $no_use = array();

        $normal = array();

        $is_get = array();

        $is_over = array();

        //查询新人卷

        $new_member_ticket_open = pdo_get($this->config, array('key' => 'new_member_ticket_open', 'weid' => $this->weid));

        $new_member_ticket_id_arr = pdo_get($this->config, array('key' => 'new_member_ticket_id', 'weid' => $this->weid));

        $new_member_ticket_id = 0;

        $new_member_is_open = 0;

        //查询是否有交易记录

//        $buy_count = pdo_fetchcolumn('select count(*) from ' . tablename('gpb_order') . ' where  go_pay_time>0 and openid ="' . $openid . '"');

        $buy_count = pdo_fetchcolumn("select count(*) from " . tablename('gpb_order') . " where  go_pay_time>0 and openid ='" . $openid ." '");

        //后台设置是否显示新人卷

        if (isset($new_member_ticket_open['value']) && $new_member_ticket_open['value'] == 1) {

            if (isset($new_member_ticket_id_arr['value']) && $new_member_ticket_id_arr['value'] > 0) {

                $new_member_ticket_id = $new_member_ticket_id_arr['value'];

                $new_member_is_open = 1;

            }

        }

        //用户是否具备新人卷条件

        if ($buy_count > 0) {

            $new_member_is_open = 0;

        }

        //查询

        foreach ($res as $k => $v) {

            $user_get = pdo_fetch("select * from " . tablename($this->user_coupon) . " where weid=" . $this->weid . " and openid='" . $openid . "' and tid=" . $v['id'] . " and status=1");

            //查询指定人的卷

            $point_ticket = pdo_fetch('select * from ' . tablename('gpb_send_ticket_set') . ' as sts where cpid=' . $v['id'] . ' ');

            if (!empty($point_ticket)) {

                $m_str = $point_ticket['value'];//

                if (!empty($m_str)) {

                    $m_arr = explode(',', $point_ticket['value']);

                    if (!in_array($member['m_id'], $m_arr)) {

                        unset($res[$k]);

                        continue;

                    } else {

                        //指定卷类型

                        $res[$k]['type'] = -1;

                    }

                }

            }



            if ($new_member_ticket_id == $v['id']) {

                //新人卷类型

                if ($new_member_is_open == 1) {

                    $res[$k]['type'] = -2;

                } else {

                    unset($res[$k]);

                    continue;

                }



            }

            $res[$k]['range'] = array();//领卷范围初始

            if (empty($user_get)) {



                //未领取

                $res[$k]['start_time'] = date("Y\.m\.d H:i:s", $v['start_time']);

                $res[$k]['end_time'] = date("Y\.m\.d H:i:s", $v['end_time']);

                $res[$k]['sql'] = $sql;

                $res[$k]['sql2'] = "select * from " . tablename($this->user_coupon) . " where weid=" . $this->weid . " and openid='" . $openid . "' and tid=" . $v['id'];

                $res[$k]['time'] = $v['end_time'];

                $res[$k]['is_use'] = $user_get['is_use'];

                $res[$k]['is_over'] = $user_get['is_over'];

                $res[$k]['coupon_status'] = 0;



                //如果是分类

                if ($res[$k]['type'] == 5) {



                    if (!empty($v['limitgoodcateids'])) {

//                        $old_cates = explode(',',$info['limitgoodcateids']);

                        $old_cates = pdo_fetchall('select * from ' . tablename('gpb_goods_cate') . ' where weid=' . $this->weid . ' and  gc_id in (' . $v['limitgoodcateids'] . ')');

                        $res[$k]['range'] = $old_cates;

                    }

                }

                //如果是商品

                if ($v['type'] == 6) {

                    if (!empty($v['limitgoodids'])) {

                        $old_goods = pdo_fetchall('select * from ' . tablename('gpb_goods') . ' where weid=' . $this->weid . ' and  g_id in (' . $v['limitgoodids'] . ')');

                        $res[$k]['range'] = $old_goods;

                    }

                }

                $normal[] = $res[$k];

            } elseif ($user_get['is_use'] == 0) {

                //未使用

                $res[$k]['start_time'] = date("Y\.m\.d H:i:s", $v['start_time']);

                $res[$k]['end_time'] = date("Y\.m\.d H:i:s", $v['end_time']);

                $res[$k]['sql'] = $sql;

                $res[$k]['sql2'] = "select * from " . tablename($this->user_coupon) . " where weid=" . $this->weid . " and openid='" . $openid . "' and tid=" . $v['id'];

                $res[$k]['time'] = $v['end_time'];

                $res[$k]['is_use'] = $user_get['is_use'];

                $res[$k]['is_over'] = $user_get['is_over'];

                $res[$k]['coupon_status'] = 0;



                //如果是分类

                if ($res[$k]['type'] == 5) {



                    if (!empty($v['limitgoodcateids'])) {

                        $old_cates = pdo_fetchall('select * from ' . tablename('gpb_goods_cate') . ' where weid=' . $this->weid . ' and  gc_id in (' . $v['limitgoodcateids'] . ')');

                        $res[$k]['range'] = $old_cates;

                    }

                }

                //如果是商品

                if ($res[$k]['type'] == 6) {

                    if (!empty($v['limitgoodids'])) {

                        $old_goods = pdo_fetchall('select * from ' . tablename('gpb_goods') . ' where weid=' . $this->weid . ' and  g_id in (' . $v['limitgoodids'] . ')');

                        $res[$k]['range'] = $old_goods;

                    }

                }

                $no_ues[] = $res[$k];

            }

            $is_get[] = $res[$k];

        }

        //已使用的优惠卷

        $is_use = pdo_fetchall("select c.*,uc.is_use,uc.is_over,uc.update_time as use_time from " . tablename($this->user_coupon) . " as uc left join " . tablename($this->coupon) . " as c on uc.tid = c.id where uc.weid=" . $this->weid . " and uc.is_use = 1 and uc.is_over = 0  and uc.openid='" . $openid . "' and c.status=1 and uc.status=1");

        if (is_array($is_use)) {

            foreach ($is_use as $key => $val) {

                $is_use[$key]['start_time'] = date("Y\.m\.d H:i:s", $val['start_time']);

                $is_use[$key]['end_time'] = date("Y\.m\.d H:i:s", $val['end_time']);

                $is_use[$key]['time'] = $val['end_time'];

                $is_use[$key]['coupon_status'] = 0;

                //查询指定人的卷

                $point_ticket = pdo_fetch('select * from ' . tablename('gpb_send_ticket_set') . ' as sts where cpid=' . $val['id'] . ' ');

                if (!empty($point_ticket)) {

                    //指定卷类型

                    $is_use[$key]['type'] = -1;

                }



                if ($new_member_ticket_id == $val['id']) {

                    //新人卷类型

                    $is_use[$key]['type'] = -2;

                }

                $is_use[$key]['range'] = array();//领卷范围初始

                //如果是分类

                if ($is_use[$key]['type'] == 5) {



                    if (!empty($val['limitgoodcateids'])) {

//                        $old_cates = explode(',',$info['limitgoodcateids']);

                        $old_cates = pdo_fetchall('select * from ' . tablename('gpb_goods_cate') . ' where weid=' . $this->weid . ' and  gc_id in (' . $val['limitgoodcateids'] . ')');

                        $is_use[$key]['range'] = $old_cates;

                    }

                }

                //如果是商品

                if ($val['type'] == 6) {

                    if (!empty($val['limitgoodids'])) {

                        $old_goods = pdo_fetchall('select * from ' . tablename('gpb_goods') . ' where weid=' . $this->weid . ' and  g_id in (' . $val['limitgoodids'] . ')');

                        $is_use[$key]['range'] = $old_goods;

                    }

                }

                if ($is_use[$key]['is_use'] == 1) {

                    $is_use[$key]['update_time'] = date("Y\.m\.d H:i:s", $is_use[$key]['use_time']);

                }

            }

        }

        //查询已过期

        $is_over_all = pdo_fetchall("select c.*,uc.update_time as use_coupon_time,uc.is_use from " . tablename($this->user_coupon) . " as uc left join " . tablename($this->coupon) . " as c on c.id = uc.tid where c.weid=" . $this->weid . " and  c.end_time < " . time() . " and c.status=1 and uc.status=1 and uc.openid = '".$openid."'");

        foreach ($is_over_all as $key => $val) {

            $is_over_all[$key]['start_time'] = date("Y\.m\.d H:i:s", $val['start_time']);

            $is_over_all[$key]['end_time'] = date("Y\.m\.d H:i:s", $val['end_time']);

            $is_over_all[$key]['time'] = $val['end_time'];

            $is_over_all[$key]['coupon_status'] = 0;

            //查询指定人的卷

            $point_ticket = pdo_fetch('select * from ' . tablename('gpb_send_ticket_set') . ' as sts where cpid=' . $val['id'] . ' ');

            if (!empty($point_ticket)) {

                //指定卷类型

                $is_over_all[$key]['type'] = -1;

            }



            if ($new_member_ticket_id == $val['id']) {

                //新人卷类型

                $is_over_all[$key]['type'] = -2;

            }

            $is_over_all[$key]['range'] = array();//领卷范围初始

            //如果是分类

            if ($is_over_all[$key]['type'] == 5) {



                if (!empty($val['limitgoodcateids'])) {

//                        $old_cates = explode(',',$info['limitgoodcateids']);

                    $old_cates = pdo_fetchall('select * from ' . tablename('gpb_goods_cate') . ' where weid=' . $this->weid . ' and  gc_id in (' . $val['limitgoodcateids'] . ')');

                    $is_over_all[$key]['range'] = $old_cates;

                }

            }

            //如果是商品

            if ($val['type'] == 6) {

                if (!empty($val['limitgoodids'])) {

                    $old_goods = pdo_fetchall('select * from ' . tablename('gpb_goods') . ' where weid=' . $this->weid . ' and  g_id in (' . $val['limitgoodids'] . ')');

                    $is_over_all[$key]['range'] = $old_goods;

                }

            }

            if ($is_over_all[$key]['is_use'] == 1) {

                $is_over_all[$key]['update_time'] = date("Y\.m\.d H:i:s", $val['update_time']);

            }



            $is_over[] = $is_over_all[$key];

        }

        $return = array('use' => $is_use, 'normal' => $normal, 'get' => $is_get, 'over' => $is_over, 'no_ues' => $no_ues);



        if (empty($res)) {

            $this->result("1", "暂无可用优惠券");

        } else {

            $this->result("0", "优惠券读取成功", $return);

        }

    }



    /*

     * 查看用户全部优惠卷

     */

    public function doPageseeUserTicket()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        $gid = trim($_GPC['gid'], ',');

		$ggo_id = $_GPC['ggo_id'];

		$num = $_GPC['num'];

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        if (empty($gid)) {

            $this->result("1", "商品有误");

        }

        //由商品查询分类情况

        $cates = pdo_fetchall('select cate_id from' . tablename('gpb_goods_to_category') . ' where goods_id in (' . $gid . ') ');

        $cates_ids = '';

        if (is_array($cates)) {

            foreach ($cates as $val) {

                $cates_ids .= ',' . $val['cate_id'];

            }

        }

        $cates_ids = trim($cates_ids, ',');

		//购物车里面的商品信息

//		$cart = pdo_fetchall(" select c.*,g.g_has_option,g.g_price from ".tablename("gpb_cart")." c join ".tablename("gpb_goods")." g on c.c_g_id = g.g_id where c.c_is_del = 1 and c.c_status = 1 and c.weid = ".$this->weid." and c.openid = '".$openid."'");

////		gpb_goods_to_category

//		if(empty($cart)){

//			$this->result("1", "购物车商品信息错误");

//		}

        $sql = "select uc.id AS user_id,uc.grant_time as start_time,uc.over_time as end_time,uc.tid,c.* from " . tablename($this->user_coupon) . " as uc left join " . tablename($this->coupon) . " as c on uc.tid = c.id   where uc.openid= '" . $openid . "' and uc.weid=" . $this->weid . "  and uc.is_use =0 and uc.is_over= 0 and c.end_time >" . time() . " and  uc.over_time >" . time() . " and uc.status=1 and c.status=1 order by c.end_time desc,over_time desc";

        $res = pdo_fetchall($sql);



        if (empty($res)) {

            $this->result("1", "优惠券读取失败", $sql);

        } else {

            //查询新人卷

            $new_member_ticket_open = pdo_get($this->config, array('key' => 'new_member_ticket_open', 'weid' => $this->weid));

            $new_member_ticket_id_arr = pdo_get($this->config, array('key' => 'new_member_ticket_id', 'weid' => $this->weid));

            $new_member_ticket_id = 0;

            $new_member_is_open = 0;

            //查询是否有交易记录

            $buy_count = pdo_fetchcolumn('select count(*) from ' . tablename('gpb_order') . ' where  go_pay_time>0 and openid ="' . $openid . '"');

            //后台设置是否显示新人卷

            if (isset($new_member_ticket_open['value']) && $new_member_ticket_open['value'] == 1) {

                if (isset($new_member_ticket_id_arr['value']) && $new_member_ticket_id_arr['value'] > 0) {

                    $new_member_ticket_id = $new_member_ticket_id_arr['value'];

                    $new_member_is_open = 1;

                }

            }

            //用户是否具备新人卷条件

            if ($buy_count > 0) {

                $new_member_is_open = 0;

            }

            $data = array();

            foreach ($res as $k => $v) {

            	//判断时间是否开始

            	$gpb_ticket = pdo_get("gpb_ticket",array('id'=>$v['tid'],'weid'=>$this->weid));

				if($gpb_ticket['start_time'] > time()){

					unset($res[$k]);

                    continue;

				}

                $res[$k]['old_start_time'] = $v['start_time'];

                $res[$k]['old_end_time'] = $v['end_time'];

                $res[$k]['start_time'] = date("Y\.m\.d H:i:s", $v['start_time']);

                $res[$k]['end_time'] = date("Y\.m\.d H:i:s", $v['end_time']);

                //查询指定人的卷

                $point_ticket = pdo_fetch('select * from ' . tablename('gpb_send_ticket_set') . ' as sts where cpid=' . $v['id'] . ' ');

                if (!empty($point_ticket)) {

                    //指定卷类型

                    $res[$k]['type'] = -1;

                }



                if ($new_member_ticket_id == $v['id']) {

                    //新人卷类型

                    if ($new_member_is_open == 1) {

                        $res[$k]['type'] = -2;

                    } elseif ($new_member_is_open == 0) {

                        unset($res[$k]);

                        continue;

                    }

                }

                $res[$k]['range'] = array();//领卷范围初始

                //如果是分类

                if ($res[$k]['type'] == 5) {

                    if (!empty($v['limitgoodcateids'])) {

                        $old = explode(',', $v['limitgoodcateids']);

                        $old_cates = pdo_fetchall('select * from ' . tablename('gpb_goods_cate') . ' where weid=' . $this->weid . ' and  gc_id in (' . $v['limitgoodcateids'] . ')');

                        $cates_ids_num = 0;

                        $cates_ids_arr = explode(',', $cates_ids);

                        foreach ($old as $cate_val) {

                        	//还需要判断用户的订单里面的分类商品价格是否满足

                            if (in_array($cate_val, $cates_ids_arr)) {

								//分类满足要求    接下来判断金额是否满足要求

								//获取当前商品下面的分类

								$ticket = pdo_get("gpb_ticket",array('id'=>$v['tid']));

//								var_dump($ticket);echo '<br/>';

								if($ticket['use_limit'] > 0){

									//查看是否有使用要求   有使用金额限制  查看是否满足金额限制

									$goods = pdo_fetchall(" select * from ".tablename("gpb_goods")." g join ".tablename('gpb_goods_to_category')." gtc on g.g_id = gtc.goods_id where g.g_id in (".trim($gid).") and g.g_is_del = 1 and g.g_is_online = 1 and g.weid = ".$this->weid." and gtc.cate_id = ".$cate_val);

									$money = 0;

									if($goods){

										foreach($goods as $kk=>$vv){

											if($num){

												//立即购买

												$cart['c_ggo_id'] = $ggo_id;

												$cart['c_count'] = $num;

											}else{

												//购物车购买

												$cart = pdo_get("gpb_cart",array('openid'=>$openid,'c_is_del'=>1,'c_status'=>1,'c_g_id'=>$vv['g_id']));

											}

											if($vv['g_has_option'] == 1){

												//多规格商品

												//查找多规格

												$option = pdo_get("gpb_goods_option",array('ggo_id'=>$cart['c_ggo_id']));

												$money += $option['ggo_market_price']*$cart['c_count'];

											}else{

												$money += $vv['g_price'] * $cart['c_count'];

											}

										}

									}

									if($money >= $ticket['use_limit']){

										$cates_ids_num++;

									}

								}else{

									$cates_ids_num++;

								}

                                continue;

                            }

                        }

                        if ($cates_ids_num <= 0) {

                            unset($res[$k]);

                            continue;

                        }

                        $res[$k]['range'] = $old_cates;

                    }

                }

                //如果是商品 (单品券)

                if ($v['type'] == 6) {

                    if (!empty($v['limitgoodids'])) {

                        $old = explode(',', $v['limitgoodids']);

                        $old_goods = pdo_fetchall('select * from ' . tablename('gpb_goods') . ' where weid=' . $this->weid . ' and  g_id in (' . $v['limitgoodids'] . ')');

                        $goods_ids_num = 0;

                        $goods_ids_arr = explode(',', $gid);

                        foreach ($old as $goods_val) {

                            if (in_array($goods_val, $goods_ids_arr)) {

                                $goods_ids_num++;

                                continue;

                            }

                        }

                        if ($goods_ids_num <= 0) {

                            unset($res[$k]);

                            continue;

                        }

                        $res[$k]['range'] = $old_goods;

                    }

                }

//              $res[$k]['sql']=$sql;

                $res[$k]['timee'] = $v['end_time'];

                $data[] = $res[$k];

            }

            $this->result("0", "优惠券读取成功", $data);

        }

    }



    /*

     * 用户领取优惠卷

     */

    public function doPageuserGetTicket()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "请传入openid");

        }

        $tid = trim($_GPC['tid']);;

        if (empty($tid)) {

            $this->result("1", "请传入要领取的优惠券id");

        }

        $ticket = pdo_get($this->coupon, ['id' => $tid]);

        if (empty($ticket)) {

            $this->result("1", "读取优惠券错误");

        }

        if ($ticket['end_time'] <= time()) {

            $this->result("1", "优惠券已过期");

        }

        if ($ticket['number'] <= $ticket['now_num']) {

            $this->result("1", "优惠券已全发放完");

        }

        $count_sql = "select count(*) from " . tablename($this->user_coupon) . " where  weid=" . $this->weid . " and openid ='" . $openid . "' and tid=" . $tid;

        $count = pdo_fetchcolumn($count_sql);

        if ($count >= $ticket['num_limit']) {

            $this->result("1", "超过优惠券领取限制");

        }

//        $user_coupon;

        $data = [

            'openid' => $openid,

            'tid' => $tid,

            'grant_time' => time(),

            'over_time' => $ticket['end_time'],

            'weid' => $this->weid,

        ];

        //todo 当后台优惠卷改后同时要改这 待完成

        $res = pdo_insert($this->user_coupon, $data);

        if (empty($res)) {

            $this->result("1", "领取优惠券失败");

        } else {

            //当成功领取后记录发放次数

            pdo_query("update " . tablename($this->coupon) . " set now_num =now_num+1 where id =" . $tid . ' and weid =' . $this->weid);

            $this->result("0", "领取优惠券成功");

        }



    }



    /*

     * 获取团长关联小区信息

     */

    public function doPagegetHeadLinkVillage()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['head_openid']);

        if (empty($openid)) {

            $this->result("1", "请传入openid");

        }

        $sql = "select * from " . tablename($this->vg) . " where weid=" . $this->weid . " and openid = '" . $openid . "' and vg_status=1";

        $res = pdo_fetch($sql);

        if (empty($res)) {

            $this->result("1", "读取团长相关小区失败");

        } else {

            $this->result("0", "读取团长相关小区成功", $res);

        }

    }

//    public function payResult($code,$over_time=900) {

//        ini_set('max_execution_time',$over_time);

//        error_reporting(0);

//        ignore_user_abort();//关闭浏览器后，继续执行php代码

//        set_time_limit(0);//程序执行时间无限制

//        $sleep_time = 10;//多长时间执行一次

//        $switch = include '../addons/group_buy/switch.php';

//        while($switch){

//            $switch = include '../addons/group_buy/switch.php';

//            $msg=date("Y-m-d H:i:s").$switch.'\n';

//            file_put_contents("../addons/group_buy/log1.log",$msg,FILE_APPEND);//记录日志

//            sleep($sleep_time);//等待时间，进行下一次操作。

//        }

//        exit();

//    }

//    public function doPagePay() {

//        global $_GPC, $_W;

//        //获取订单号，保证在业务模块中唯一即可

//        $orderid = intval($_GPC['orderid']);

//        //构造支付参数

//        $order = array(

//            'tid' => $orderid,

//            'user' => $_W['openid'], //用户OPENID

//            'fee' => floatval(100), //金额

//            'title' => '小程序支付示例',

//        );

//        //生成支付参数，返回给小程序端

//        $pay_params = $this->pay($order);

//        if (is_error($pay_params)) {

//            return $this->result(1, '支付失败，请重试');

//        }

//        return $this->result(0, '', $pay_params);

//    }

    public function doPageiss()

    {

        global $_GPC, $_W;

//    	$order = $_GPC['order'];

//        $is = $this->doPageFraction_order_Detailed(array('order'=>$order));

//        echo '<pre>';

//        print_r($is);exit;

        $rs = $this->pays('0.01', 'oLf4B0Ya88-es3qWE03bpxp-MeOc', '123123213213213213', '22', '');

        var_dump($rs);

        exit;





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

    public function pays($total_fee, $openid, $order, $id, $notify_url)

    {

        global $_GPC, $_W;
        if (empty($total_fee)) {

            $this->result(-1, '金额有误');

        }

        //判断用户是否正确

        if (empty($openid)) {

            $this->result(-1, '登录失效，请重新登录(openid参数有误)');

        }

		$order_over = pdo_get('gpb_config',array('key'=>'order_over_cancle','weid'=>$this->weid));

		if(empty($order_over) || ( $order_over['value'] > 10 || $order_over['value'] < 5)){

			$time = time()+700;

		} else {

			$time = time()+($order_over['value']*60)+1;

		}
		//先检查下单是否过期 周龙 2020-03-06
        $order_info = pdo_get($this->order,['weid'=>$this->weid,'go_code'=>$order,'go_status'=>10]);
        $card_order = pdo_get("gpb_member_card_order",['weid'=>$this->weid,'card_order'=>$order]);
        $recharget_order = pdo_get("gpb_recharge_info",['order_code'=>$order,'weid'=>$this->weid]);
		if(empty($order_info) && empty($card_order) && empty($recharget_order)){
            $data['status'] = 1;

            $data['text'] = "订单不存在或超时未支付";
            return $data;
        }
        if(!empty($order_info)){
            //是商品订单 检查订单是否超时未支付
            $now_time = time();
            $over_time = $order_over['value'];
            if(intval($over_time)<=0){
                $over_time = 1;
            }
            $over_time = intval($over_time)*60;
            if(intval($now_time)-intval($order_info['go_add_time'])>=intval($over_time)){
                //超时未支付
                pdo_update($this->order,array('go_status'=>110),array("go_id"=>$order_info['go_id']));

                $order_log = [
                    'gol_uid'=>0,
                    'gol_add_time'=>time(),
                    'gol_comment'=>'订单超时未支付已由系统自动取消',
                    'gol_des'=>'订单超时未支付已由系统自动取消',
                    'gol_go_code'=>$order_info['go_code'],
                    'gol_status'=>1,
                    'gol_u_name'=>'系统',
                    'type'=>1,
                    'intage'=>'0.00',
                    'share'=>1
                ];

                $res = pdo_insert($this->order_log,$order_log);

                if(empty($res)){
                    //加入之日不成功 写入文件日志
                    $f = fopen("./order_log.log","a+");
                    $content = serialize($order_log);
                    $content = "\n".date("Y-m-d H:i:s")."\n插入日志不成功,{$res}\n".$content;
                    fwrite($f,$content);
                    fclose($f);
                }

                //阻止继续支付 返回订单取消
                $data['status'] = 1;

                $data['text'] = "订单超时未支付,请重新下单购买";
                return $data;
            }
        }




		$time = date('YmdHis',$time);

        $appid = $_W['oauth_account']['key'];//如果是公众号 就是公众号的appid;小程序就是小程序的appid

        $body = '在线支付';

        $mch_id = $this->pay_setting['wechat']['mchid'];//商户号

        $KEY = $this->pay_setting['wechat']['signkey'];//支付密匙



        $nonce_str = $this->randomkeys(32);//随机字符串

        $notify_url = $_SERVER['SERVER_NAME'];//;  //支付完成回调地址url,不能带参数

        $out_trade_no = $order;//商户订单号

        $spbill_create_ip = $_SERVER['SERVER_ADDR'];//服务器端ip

        $trade_type = 'JSAPI';//交易类型 默认JSAPI

//		if($openid == 'oLf4B0RKRvsOPND25hNm4cCiz_Lg'){

//			$notify_url = 'https://test12.scmmwl.com/addons/group_buy/block/pay.php';

//		}

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

        $post['total_fee'] = $total_fee * 100;        //总金额 最低为一分钱 必须是整数  单位是分  所以乘100

        $post['trade_type'] = $trade_type;

        //2020-02-24 周龙添加过期时间
        $weid = !empty($this->weid)?$this->weid:$_W['uniacid'];
        if(empty($weid)){
            $weid = $_GPC['i'];
        }
        $order_over_cancle = pdo_fetchcolumn("select `value` from ".tablename($this->config)." where weid={$weid} and `key`='order_over_cancle'");
        if(intval($order_over_cancle)<1){
            $order_over_cancle = 1;
        }
        $order_over_cancle = $order_over_cancle*60;

        $post['time_start'] = date("YmdHis",time());
        $post['time_expire'] = date("YmdHis",intval(time())+$order_over_cancle);

		$post['time_expire'] = $time;

        $sign = $this->MakeSign($post, $KEY);              //签名



        $post_xml = $this->array_xml($post, $sign);        //字典序将数组转xml格式

//        var_dump($post);

//        var_dump($KEY);

//        var_dump($sign);

//		echo '<pre>';

//		print_r($post_xml);

//		echo '<br/>1<br/>';

        //统一下单接口prepay_id

        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';

        $xml = $this->http_request($url, $post_xml);     //POST方式请求http

        $array = $this->xml2array($xml);               //将【统一下单】api返回xml数据转换成数组，全要大写

//        var_dump($array);

        if ($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS') {

            $time = time();

            $tmp = [];                            //临时数组用于签名

            $tmp['appId'] = $appid;

            $tmp['nonceStr'] = $nonce_str;

            $tmp['package'] = 'prepay_id=' . $array['PREPAY_ID'];

            $tmp['signType'] = 'MD5';

            $tmp['timeStamp'] = $time . "";



            $data['status'] = 0;

            $data['id'] = $id;

            $data['packages'] = $array['PREPAY_ID'];

            $data['timeStamp'] = "{$time}";           //时间戳

            $data['nonceStr'] = $nonce_str;         //随机字符串

            $data['signType'] = 'MD5';              //签名算法，暂支持 MD5

            $data['package'] = 'prepay_id=' . $array['PREPAY_ID'];   //统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*

            $data['paySign'] = $this->MakeSign($tmp, $KEY);       //签名,具体签名方案参见微信公众号支付帮助文档;

            $data['out_trade_no'] = $out_trade_no;

        } else {

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

    private function randomkeys($length = 32)

    {

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

    public function MakeSign($params, $KEY)

    {

//  	return $params;

//      //签名步骤一：按字典序排序数组参数

        ksort($params);

        $string = $this->ToUrlParams($params);  //参数进行拼接key=value&k=v

        //签名步骤二：在string后加入KEY

        $string = $string . "&key=" . $KEY;

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

    public function ToUrlParams($params)

    {

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

    public function array_xml($array, $sign)

    {

        ksort($array);

        $xml = '<xml>';

        foreach ($array as $k => $v) {

            if (!is_array($v)) {

                $xml .= '<' . $k . '>' . $v . '</' . $k . '>';

            }

        }

        $xml .= '<sign>' . $sign . '</sign>';

        $xml .= '</xml>';

        return $xml;

    }



    /**

     * 获取xml里面数据，转换成array

     * @param $xml XML格式数据

     * retrun array 数据

     */

    private function xml2array($xml)

    {

        $parser = xml_parser_create();

        // 将 XML 数据解析到数组中

        xml_parse_into_struct($parser, $xml, $vals, $index);

        // 释放解析器

        xml_parser_free($parser);

        // 数组处理

        $arr = array();

        $t = 0;

        foreach ($vals as $value) {

            $type = $value['type'];

            $tag = $value['tag'];

            $level = $value['level'];

            $attributes = isset($value['attributes']) ? $value['attributes'] : "";

            $val = isset($value['value']) ? $value['value'] : "";

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

    private function http_request($url, $data = null, $headers = array())

    {

        $curl = curl_init();

        if (count($headers) >= 1) {

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        }

        curl_setopt($curl, CURLOPT_URL, $url);



        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);



        if (!empty($data)) {

            curl_setopt($curl, CURLOPT_POST, 1);

            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($curl);

        curl_close($curl);

        return $output;

    }



    /**
     * 获取微信订单号查询订单状态
     * @param $openid 用户的openid
     * @param $type 订单类型
     * return ''
     */
    public function doPageorder_status_info()
    {
        global $_W, $_GPC;
        $openid = trim($_GPC['openid']);
        $gid = trim($_GPC['gid']);//go_code
//        $cid = trim($_GPC['cid']);
        if (empty($openid) || empty($gid)) {
            return 0;
        }
        //获取该用户的微信支付的订单信息(支付未成功的)
        //$sql = " select * from ".tablename($this->order)." where or_openid=:openid and go_status=10 and or_pay_mode= 1 limit 0,10";
        //$info = pdo_fetch($sql,array(':openid'=>$openid));
        //if(!empty($info)){
        //获取该订单
        $order_info = pdo_get('gpb_order', array('go_code' => $gid));
        $member_info = pdo_get('gpb_member', array('m_openid' => $openid));
        if (empty($order_info) || empty($member_info)) {
            return 0;
        }
        if($order_info['go_status'] != 10 && $order_info['go_status'] == 20){
            $this->result("0", "订单已支付");
        }
        if ($order_info['go_pay_type'] == 1 || $order_info['go_pay_type'] == 3) {
            //当有微信支付参与时
            $list = $this->wx_order_status($gid);

            if ($list['trade_state'] == 'SUCCESS' && $list['return_code'] == 'SUCCESS') {
                //支付成功  改变订单状态,并且发送模板消息 todo....
                $rownum = pdo_update($this->order, ['go_status' => 20, 'go_pay_time' => time()], array('go_code' => $gid, 'weid' => $this->weid, 'openid' => $openid, 'type' => 1));
                if (empty($rownum)) {
                    $this->result("1", "支付失败");
                    exit();
                }
            } else {
                $this->result("1", "支付失败", array($gid, $list));
                exit();
            }
        } elseif ($order_info['go_pay_type'] == 2) {
            //余额支付直接是成功
        } else {
            $this->result("1", "支付失败,支付方式有误");
            exit();
        }
        //获取商品信息
        $info_snapshot = pdo_getall($this->snapshot, array('oss_go_code' => $gid));

        $phone = $info_snapshot[0]['oss_buy_phone'];

        if (!empty($info_snapshot)) {

            foreach ($info_snapshot as $k => $v) {
                if($v['oss_is_seckill'] != 1 ){
                    $stcok = pdo_get($this->goods_stock, array('goods_id' => $v['oss_gid']));//获取库存
                    $num = $stcok['num'] - $v['oss_g_num'];
                    $num = $num <= 0 ? 0 : $num;
                    $is = $stcok['sale_num'] + $v['oss_g_num'];
                    //获取减少库存方式
                    $reduce_stock_type = pdo_get($this->config, array('key' => 'reduce_stock_type', 'weid' => $this->weid));
                    //修改库存和添加销量
                    if ($reduce_stock_type['value'] == 2) {
                        //	                    pdo_update($this->goods_stock, array('sale_num' => $is), array('goods_id' => $v['oss_gid'], 'weid' => $this->weid));
                    } else {
                        pdo_update($this->goods_stock, array('num' => $num, 'sale_num' => $is), array('goods_id' => $v['oss_gid'], 'weid' => $this->weid));
                    }
                }
                //修改完销量  去查看商品的销量是为0  为0 下架
                if ($is === 0) {
                    $res = pdo_update($this->goods, array('g_is_online' => -1), array('g_id' => $v['oss_gid'], 'weid' => $this->weid));
                }
                //修改虚拟销售数量
                $sql = "update " . tablename($this->goods) . " set `g_sale_num` = `g_sale_num`+1 WHERE weid=" . $this->weid . " and `g_id` = " . $v['oss_gid'];
                pdo_query($sql);
            }
        }
        //查看是否开启自动订单打印
        $order_print_auto_open = pdo_get($this->config, array('key' => 'order_print_auto_open', 'weid' => $this->weid));
        $order_print_auto_open_val = isset($order_print_auto_open['value']) ? $order_print_auto_open['value'] : 2;

        $order_print_auto_num = pdo_get($this->config, array('key' => 'order_print_auto_num', 'weid' => $this->weid));

        $order_print_auto_num_val = isset($order_print_auto_num['value']) ? $order_print_auto_num['value'] : 1;

        if ($order_print_auto_open_val == 1) {


            //开启

            //查询打印机配置

            $print_set = pdo_get($this->config, array('key' => 'print_set', 'weid' => $this->weid));

            $config = unserialize($print_set['value']);

            if (empty($config) || count($config) <= 0) {

//                                echo json_encode(array('status'=>1,'msg'=>'请在配置中设置打印机'));exit;

            } else {

                //调用打印机类

                $print_class = new print_sn();

                //查询打印机状态

                $res_select = $print_class->select_print($config['print_sn']);

                if ($res_select["ret"] !== 0 || $res_select["data"] == '离线。') {

//                                    echo json_encode(array('status'=>1,'msg'=>$res_select['msg'].','.$res_select['data']));exit;

                } else {

                    $goods = array();

                    $order = pdo_fetchall("select * from " . tablename($this->order) . " as o left join " . tablename($this->snapshot) . " as sn on sn.oss_go_code = o.go_code left join " . tablename($this->vg) . " as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=" . $gid . " and o.weid=" . $this->weid);

                    foreach ($order as $k => $v_order) {

                        $goods[$k]['title'] = $v_order['oss_g_name'];

                        $goods[$k]['price'] = $v_order['oss_g_price'];

                        $goods[$k]['num'] = $v_order['oss_g_num'];

                        $goods[$k]['spec'] = trim($v_order['oss_ggo_title']);

                    }

                    $adr = $order[0]['vg_address'];

                    if (!empty($order[0]['oss_address']) && $order[0]['oss_address'] != 'undefined') {

                        $adr = $order[0]['oss_address'];

                    }

                    $lead_info = array(

                        'name' => $order[0]['oss_head_name'],

                        'phone' => $order[0]['oss_head_phone'],

                    );

                    $reduce_price = 0;

                    if ($order[0]['go_fdc_price'] > 0) {

                        $reduce_price += $order[0]['go_fdc_price'];

                    }

                    if ($order[0]['go_full_reduce_price'] > 0) {

                        $reduce_price += $order[0]['go_full_reduce_price'];

                    }

                    $send_price = 0;

                    if ($order[0]['go_send_pay'] > 0) {

                        $send_price += $order[0]['go_send_pay'];

                    }

                    switch ($order[0]['go_send_type']) {

                        case '1':

                            $send_type = '自提';

                            break;

                        case '2':

                            $send_type = '团长送货';

                            break;

                        case '3':

                            $send_type = '快递';

                            break;

                        default:

                            $send_type = '自提';

                            break;

                    }

                    switch ($order[0]['go_pay_type']) {

                        case '1':

                            $pay_type = '微信支付';

                            break;

                        case '2':

                            $pay_type = '余额支付';

                            break;

                        case '3':

                            $pay_type = '余额+微信支付';

                            break;

                        default:

                            $pay_type = '微信支付';

                            break;

                    }

                    if($this->check_base64_out_json($order[0]['oss_address_name'])){

                        $order[0]['oss_address_name']=  base64_decode($order[0]['oss_address_name']);

                    }

                    //查询订单是否为拼团订单
                    if($order['oss_is_seckill']!=3){
                        $res = $print_class->print_info($config['print_sn'], $gid, $order[0]['oss_v_name'], $goods, $adr, $order[0]['oss_address_phone'], $order[0]['oss_address_name'], $order[0]['go_real_price'], $lead_info, $order[0]['go_comment'] = '', $qrcode = '', $order[0]['go_add_time'], '', $pay_type, $order_print_auto_num_val, $reduce_price, $send_price, $send_type);

                        sleep(1);
                    }else{
                        //拼团订单查询是否成团
                        $osn = $order['go_code'];
                        $p_order = pdo_fetch("select * from ".tablename("gpb_pteam_order")." where weid={$this->weid} and osn='{$osn}'");
                        if(!empty($p_order)){
                            //获取对应活动id
                            $aid = $p_order['aid'];
                            $pteam_active = pdo_get("gpb_pteam_activity",array('id'=>$aid,'weid'=>$this->weid));
                            if(($pteam_active['state']==10) || ($pteam_active['state']==2 && intval($pteam_active['now_num'])+1==$pteam_active['all_num'])){
                                $pteam_active_order = pdo_fetchall("select o.go_code from ".tablename("gpb_pteam_order")." as po join ".tablename("gpb_order_snapshot")." as os on os.oss_go_code=po.osn join ".tablename("gpb_order")." as o on o.go_code=po.osn where os.oss_is_seckill=3 and po.weid={$this->weid} and po.aid={$aid} and o.go_status in (20,30) ");
                                foreach ($pteam_active_order as $k=>$v){
                                    $this->order_print($v['go_code']);
                                }
                                if(count($pteam_active_order)<$pteam_active['all_num']){
                                    $res = $print_class->print_info($config['print_sn'], $gid, $order[0]['oss_v_name'], $goods, $adr, $order[0]['oss_address_phone'], $order[0]['oss_address_name'], $order[0]['go_real_price'], $lead_info, $order[0]['go_comment'] = '', $qrcode = '', $order[0]['go_add_time'], '', $pay_type, $order_print_auto_num_val, $reduce_price, $send_price, $send_type);
                                }
                            }

                        }
                    }



                }



            }



        }

        $info = pdo_get($this->order, array('go_code' => $gid, 'weid' => $this->weid, 'type' => 1));

        //发送模板消息

        $sms = new Sms();

        $sms->weid = $this->weid;

        $this->Token();

//      send_out($key,$data,$access_token,$openid,$page,$form_id,$weid,$item);

        $sms_array = array('1' => $info['go_code'], '2' => "￥" . $info['go_real_price'], '3' => '支付成功', '4' => date('Y-m-d H:i', $info['go_add_time']), '5' => '如有疑问，请拨打客户热线:');

        $form_id = empty($info['prepay_id']) ? $info['go_order_formid'] : $info['prepay_id'];

        $dass = $sms->send_out('sms_template', $sms_array, $_W['account']['access_tokne'], $openid, 'pages/order/orderDetail?id=' . $info['go_id'], $form_id, $sms->weid, 'AT0229');

        //新增订阅消息 周龙 2020-02-27
        $submsg = new \SubMsg();
        $submsg_arr = [
            $info['go_code'],
            "￥" . $info['go_real_price'],
            '支付成功',
            date('Y-m-d H:i', $info['go_add_time']),
            '如有疑问，请拨打客户热线'
        ];
        $submsg->sendmsg("pay_suc",$openid,$submsg_arr,'pages/order/orderDetail?id=' . $info['go_id']);

        //新增公众号消息 周龙 2020-03-05
        $openids = pdo_fetchcolumn("select `value` from ".tablename("gpb_config")." where `key`='refund_msg_openid' and `weid`={$this->weid} and `status`=1");
        if(!empty($openids)){
            //设置的有才发送
            //是否多个
            $subwechat = new \SubWechat();
            $arr = explode(",",$openids);
            if(is_array($arr) && count($arr)>1){
                $subwechat_arr = [
                    '您有新的订单请及时处理',
                    $info['go_code'],
                    '',
                    date('Y-m-d H:i', $info['go_add_time']),
                    "￥" . $info['go_real_price'],
                    '请及时进入后台处理'
                ];
                foreach ($arr as $k=>$v){
                    $subwechat->sendunimsg("tmp_paymsg",$v,$subwechat_arr);
                }
            }else{
                //只有一个直接发送
                $subwechat_arr = [
                    '您有新的订单请及时处理',
                    $info['go_code'],
                    '',
                    date('Y-m-d H:i', $info['go_add_time']),
                    "￥" . $info['go_real_price'],
                    '请及时进入后台处理'
                ];
                $subwechat->sendunimsg("tmp_paymsg",$openids,$subwechat_arr);
            }

        }

        $log_content = date('Y-m-d H:i:s') . '，订单支付成功模版消息日志（order_status_info）' . PHP_EOL;

        if (is_array($dass)) {

            foreach ($dass as $dass_k => $dass_v) {

                $log_content .= 'key:' . $dass_k . ',value:' . $dass_v . PHP_EOL;

            }

        }

        $log_content .= json_encode(array('sms_template', $sms_array, $_W['account']['access_tokne'], $openid, 'pages/order/orderDetail?id=' . $info['go_id'], $form_id, $sms->weid, 'AT0229'), JSON_UNESCAPED_UNICODE);

        $log_content .= '----------end------------' . PHP_EOL;

        $this->txt_logging_fun('sms_AT0229_log.txt', $log_content);

        //短信通知管理员

        //$account = pdo_get($this->member,array('m_openid'=>$openid,'weid'=>$this->weid));

        $type = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_type'));

        $set = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_pay'));

        $phone = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_admin'));

        $data = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_data'));

        $phone = unserialize($phone['value']);

        $data = unserialize($data['value']);

        $set = unserialize($set['value']);

        $sms = new Sms();

        $weid = $sms->weid = $this->weid;

        if ($type['value'] == 1) {

            //阿里云

            if (is_array($phone)) {

                foreach ($phone as $k => $v) {

                    $res = $sms->alicloud($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), array('0' => $member_info['m_phone'], '1' => $gid));

                }

            }

        } elseif ($type['value'] == 2) {

            //创瑞 todo 不一定成

            if (is_array($phone)) {

                foreach ($phone as $k => $v) {

                    $res = $sms->chui($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), $gid);

                }

            }

        }

        $total_fee = $info['go_real_price'];

        //修改流水表

        $old_stream = pdo_get($this->stream, array("weid" => $this->weid, 'gos_go_code' => $order_info['go_code'], 'gos_stream_type' => 1, 'gos_status' => 1));

        if (empty($old_stream)) {

            //存入订单流水

            $order_snapshot = pdo_fetchall("select * from " . tablename($this->snapshot) . " where oss_go_code =" . $order_info['go_code']);

            $data_stream = array(

                'gos_code' => date('Ymd', time()) . $this->nextId(),//流水号

                'gos_go_code' => $gid,//订单号

                'gos_stream_type' => 1,

                'gos_type' => 1,

                'gos_commet' => '进入订单页确定支付完成.',

                'gos_owner' => '平台',

                'gos_order_money' => $order_info['go_real_price'],

                'gos_payer' => $order_snapshot[0]['oss_buy_name'],

                'gos_real_money' => $order_info['go_real_price'],

                'gos_sure_pay_time' => time(),

                'gos_status' => 2,

                'gos_add_time' => time(),

                'weid' => $this->weid,

                'gos_pay_type' => $order_info['go_pay_type'],

                'gos_team' => $order_snapshot[0]['oss_head_name'],

                'gos_payer_openid' => $order_snapshot[0]['oss_buy_openid'],

                'gos_team_openid' => $order_snapshot[0]['oss_head_openid'],

                'gos_balance_pay' => $order_info['go_balance_price'],

                'gos_release_pay' => $order_info['go_release_price'],

                'gos_wx_pay' => $order_info['go_wx_price'],

            );

            pdo_insert($this->stream, $data_stream);

        } else {

            $data_stream = array(

                'gos_real_money' => $total_fee,

                'gos_sure_pay_time' => time(),

                'gos_commet' => $old_stream['gos_commet'] . ',后进入订单页确定支付完成',

                'gos_pay_type' => $order_info['go_pay_type'],

                'gos_status' => 2,

                'gos_balance_pay' => $order_info['go_balance_price'],

                'gos_release_pay' => $order_info['go_release_price'],

                'gos_wx_pay' => $order_info['go_wx_price'],

            );

            pdo_update($this->stream, $data_stream, array('gos_id' => $old_stream['gos_id']));

        }

        //todo cccc

        $this->pay_success_send_official_account_msg($info['go_code']);

        $order_info['go_add_time'] = date('Y-m-d', $info['go_add_time']);

        $this->result("0", "支付成功", [$order_info, $res]);

        exit();



        // }

        //}

        //return TRUE;

    }



    /*
     * 请求查询订单支付状态
     * @param string $gid
     * @return array
     */
    public function wx_order_status($gid){

        global $_W, $_GPC;

        $data['appid'] = $_W['account']['key'];//appid

        $data['mch_id'] = $this->pay_setting['wechat']['mchid'];//商户号

        $data['nonce_str'] = $this->randomkeys(32);//随机字符串

        $urls = 'https://api.mch.weixin.qq.com/pay/orderquery';

        //foreach($info as $k=>$v){

        $data['out_trade_no'] = $gid; //拿到订单号
        ihttp_request($_W['siteroot']."/app/index.php?i={$_W['uniacid']}&from=wxapp&m=group_buy&a=wxapp&c=entry&do=Team_orderchange&go_code={$gid}");

        $sign = $this->MakeSign($data, $this->pay_setting['wechat']['signkey']);//算签名

        $post_xml = $this->array_xml($data, $sign);//数组转xml

        $list = $this->http_request($urls, $post_xml);//请求

        $list = $this->xml_to_array($list);//将返回的数据转成数组

        return $list;

    }



    /**

     * 将xml转为array

     * @param string $xml

     * return array

     */

    public function xml_to_array($xml)

    {

        if (!$xml) {

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

    public function Token()
    {
        global $_GPC, $_W;
        if (( !empty($_W['account']['access_time']) && time() > $_W['account']['access_time']) || empty($_W['account']['access_time'])) {
            //获取access_token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $_W['account']['key'] . "&secret=" . $_W['account']['secret'];
            $list = $this->http_request($url);
            $list = json_decode($list, true);
//			echo '<pre>';
//			print_r($list);exit;
            $_W['account']['access_tokne'] = $list['access_token'];

            $_W['account']['access_time'] = time() + 7150;

            return true;

        } else {

            return true;

        }

    }



    public function doPageindesssf()

    {

        global $_GPC, $_W;

        $this->Token();

        $sms = new Sms();

        $sms->uniformMessage_send($_W['account']['access_tokne']);

//      $this->refund_info('wxd638314c68886fa2','1482977942','15433032630455692672','15433032630455692671','1','1');

    }



    /**

     * 退款 (公告函数)

     * @param $appid 小程序appid

     * @param $mcid 商户号

     * @param $out_trade_no 商户订单号

     * @param $out_refund_no 退款订单号

     * @param $total_fee 订单金额

     * @param $refund_fee 退款金额

     */

    public function refund_info($appid, $mcid, $out_trade_no, $out_refund_no, $total_fee, $refund_fee)

    {

        global $_W, $_GPC;

        $appid = $_W['oauth_account']['key'];//如果是公众号 就是公众号的appid;小程序就是小程序的appid

        $mcid = $_W['oauth_account']['key'];//商户号

        $KEY = $this->pay_setting['wechat']['signkey'];//支付密匙



        $nonce_str = $this->randomkeys(32);//随机字符串

        $notify_url = '';  //支付完成回调地址url,不能带参数



        //这里是按照顺序的 因为下面的签名是按照(字典序)顺序 排序错误 肯定出错



        $post['appid'] = $appid;

        $post['mch_id'] = $mcid;

        $post['nonce_str'] = $nonce_str;//随机字符串

        $post['notify_url'] = $notify_url;

        $post['out_trade_no'] = $out_trade_no;

        $post['out_refund_no'] = $out_refund_no;

        $post['total_fee'] = $total_fee * 100;

        $post['refund_fee'] = $refund_fee * 100;//服务器终端的ip



        $sign = $this->MakeSign($post, $KEY);              //签名

        $post_xml = $this->array_xml($post, $sign);        //字典序将数组转xml格式



        //统一退款接口 todo 退款未读配置

        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';

        $data = ['pem' => '../addons/group_buy/cert/1482977942_20181012_cert.pem', 'key' => '../addons/group_buy/cert/1482977942_20181012_key.pem'];

        $xml = $this->curpost($url, $post_xml, $data['pem'], $data['key']);     //POST方式请求http

        $array = $this->xml2array($xml);               //将【统一下单】api返回xml数据转换成数组，全要大写

        echo '<pre>';

        print_r($array);

    }



    /**

     * cur请求

     * $url 请求地址

     * $post post数据

     */

    private function curpost($url = '', $postData = '', $cert, $key)

    {

        if (is_array($postData)) {

            $postData = http_build_query($postData);

        }

        $get = getcwd();

        $get = substr($get, 0, strlen($get) - 3);

//		$get = "";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数

        //https请求 不验证证书和host

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //第一种方法，cert 与 key 分别属于两个.pem文件

//		$a = getcwd().'/extend/wxpay/cert/apiclient_cert.pem';

        //默认格式为PEM，可以注释

        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');

        curl_setopt($ch, CURLOPT_SSLCERT, $cert);

//      curl_setopt($ch,CURLOPT_SSLCERT,'../addons/wl_appointment/cert/1482977942_20181012_cert.pem');

        //默认格式为PEM，可以注释

        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');

        curl_setopt($ch, CURLOPT_SSLKEY, $key);

//      curl_setopt($ch,CURLOPT_SSLKEY,'../addons/wl_appointment/cert/1482977942_20181012_key.pem');

        //第二种方式，两个文件合成一个.pem文件

//        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

        $data = curl_exec($ch);

        if ($data === false) {

            echo 'Curl error: ' . curl_error($ch);

            exit();

        }

        curl_close($ch);

        return $data;

    }



    /*

     * 获取小程序二维码

     */

    public function doPagegetQRCode()

    {

        global $_GPC, $_W;

        $openid = $_GPC['openid'];

        $id = $_GPC['id'];

        $scene = $_GPC['scene'];

        if (empty($scene)) {

            $this->result("1", "请传入scene");

            exit();

        }

        $src = $_GPC['url'];

        $src = empty($src) ? "pages/template/index" : $src;



        $a_id = $_GPC['a_id'];

        $actEndTime = $_GPC['actEndTime'];

        $user = pdo_fetch("select * from " . tablename($this->member) . " where weid=" . $this->weid . " and m_openid = '" . $openid . "'");

        if ($user['m_is_head'] == 2) {

            $team = $openid;

        } else {

            if (empty($user['m_head_openid'])) {

                $team = "";//todo 暂时没传入定位，无法推荐最近

            } else {

                $team = $user['m_head_openid'];

            }

        }

        $scene = empty($src) ? "" : $scene;

        $savePath = QRCODEPATH . $openid . time() . "-qr_code.jpg";

        if (!file_exists($savePath)) {

            $tokne = $this->Token();

            $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $_W['account']['access_tokne'];

            //$url ="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$_W['account']['access_tokne'];



            $data = [

                'scene' => $scene,//.'&at_id='.$a_id,

                'width' => 300,

                'auto_color' => false,

                'page' => $src,

            ];

            //$data = array("path"=>"pages/show/show?id=".$id,"width"=> 150);

            $data = json_encode($data);

            $data_img = $this->http_request($url, $data);



            $res = file_put_contents('..' . $savePath, $data_img);

            if ($res === false) {

                $this->result("1", "生成二维码失败");

            }

        }

//        $this->result("0","生成二维码成功",[$this->http_type.$_SERVER['HTTP_HOST'].$savePath,'xx'=>$tokne,'sss'=>$data_img,'url'=>$src]);

//        $this->result("0","生成二维码成功",$this->http_type.$_SERVER['HTTP_HOST'].$savePath);

        $this->result("0", "生成二维码成功", 'https://' . $_SERVER['HTTP_HOST'] . $savePath);

    }

    /*

     * 下单发送模版消息

     */

//    public function order_send_msg($openid,$prepay_id,$code){

//        $data_arr = array(

//            'keyword1' => array( "value" =>"订单号", "color" => "#173177" ),

//            'keyword2' => array( "value" =>$code, "color" => "#173177" ),

//            'keyword3' => array( "value" =>"下单成功", "color" => "#173177" ),

//        );

//

//        $post_data = array (

//            // 用户的 openID，可用过 wx.getUserInfo 获取

//            "touser"           => $openid,

//            // 小程序后台申请到的模板编号

//            "template_id"      => 1,//$templateid,微信后台申请的模版id

//            // 点击模板消息后跳转到的页面，可以传递参数

//            "page"             => "/pages/index/index",

//            // 第一步里获取到的 formID

//            "prepay_id"          => $prepay_id,

//            // 数据

//            "data"             => $data_arr,

//            // 需要强调的关键字，会加大居中显示

//            "emphasis_keyword" => "keyword2.DATA"

//

//        );

//        $url = "api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$this->Token();

//        $res = $this->http_request($url,$post_data);





//    }

    /**

     * 检验数据的真实性，并且获取解密后的明文.

     * @param $encryptedData string 加密的用户数据

     * @param $iv string 与用户数据一同返回的初始向量

     * @return int 成功0，失败返回对应的错误码

     */

    public function decryptData($encryptedData, $iv, $sessionKey)

    {

        //检查密匙是否是24位

        if (strlen($sessionKey) != 24) {

            return;

        }

        //base64位解密

        $aesKey = base64_decode($sessionKey);

        //查看初始向量是否是24位

        if (strlen($iv) != 24) {

            return;

        }

        //base64位解密初始向量

        $aesIV = base64_decode($iv);

        //base64位解密用户数据

        $aesCipher = base64_decode($encryptedData);

        //openssl  解密  参数:加密明文  加密方法    解密密匙   数据格式选项  解密初始化向量 (一一对应)

        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        //将解密出来的json数据转成array

        $dataObj = json_decode($result, true);



        if ($dataObj == NULL) {

            return;

        }

        //判断解密出来的appid是否和自己的appid相同

        if ($dataObj['watermark']['appid'] != $this->appid) {

            return;

        }

        $data = $result;

        return $data;

    }



    /*

     * 发送获取绑定手机

     */

    public function doPageget_wx_phone()

    {

        global $_W, $_GPC;

        $openid = $_GPC['openid'];

        if (empty($openid)) {

            $this->result(0, '请传入openid');

        }

        $info = $_GPC['info'];

        $iv = $_GPC['iv'];

        if (empty($info)) {

            $this->result(0, '非法进入');

        }

        //拉取手机号

        $user = pdo_get($this->member, array('m_openid' => $openid));

        $is = $this->decryptData($info, $iv, $user['sessionkey']);

        $is = json_decode($is, true);

        $phone = $is['purePhoneNumber'];

//        var_dump($user);



        $res = pdo_update($this->member, array('m_phone' => $phone), array('m_openid' => $openid, 'weid' => $this->weid));

//        var_dump($openid);exit;

        if ($is) {

            $this->result(0, "获取手机号成功", $is);

        } else {

            $this->result(1, "获取手机号失败", array('res' => $res, $is));

        }

        //https://api.weixin.qq.com/sns/jscode2session?appid=固定的appid&secret=固定的secret&js_code=每次小程序传参&grant_type=authorization_code



    }



    /*

     * 获取团长的openid

     */

    public function doPagegetTeamOpenid()

    {

        global $_W, $_GPC;

//			if($_GPC['openid'] == 'ouMNK5OH676ZgJdsFtZvIXY5jcNU'){

//				$stime=microtime(true);

//			}

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result(0, "请传入openid");

        }

        $sql = "select * from " . tablename($this->member) . " where weid=" . $this->weid . " and m_openid = '" . $openid . "'";

        $user = pdo_fetch($sql);

//			if($_GPC['openid'] == 'ouMNK5OH676ZgJdsFtZvIXY5jcNU'){

//				$etime=microtime(true);//获取程序执行结束的时间

//				$total=$etime-$stime;  //计算差值

//				echo "<br />当前页面执行时间为：{$total} 秒";exit;

//			}

        $head = pdo_fetch("select * from " . tablename($this->member) . " where weid=" . $this->weid . " and m_openid = '" . $user['m_head_openid'] . "'");

        $head_info = pdo_fetch("select * from " . tablename($this->member) . " as m left join " . tablename($this->vg) . " as vg on m.m_openid = vg.openid where m.weid=" . $this->weid . " and m_openid = '" . $head['m_openid'] . "'");

        $group_info_bg_img = pdo_get($this->config, array('key' => 'group_info_bg_img', 'weid' => $this->weid),array('value'));

        $group_info_bg_img = isset($group_info_bg_img['value']) ? $group_info_bg_img['value'] : '/addons/group_buy/public/bg/group_info_img.png';

        $head_info['group_info_bg_img'] = tomedia($group_info_bg_img);

        if($this->check_base64_out_json($user['m_nickname'])){

            $user['m_nickname'] = base64_decode($user['m_nickname']);

        }

        if($this->check_base64_out_json($head['m_nickname'])){

            $head['m_nickname'] = base64_decode($head['m_nickname']);

        }

        if($this->check_base64_out_json($head_info['m_nickname'])){

            $head_info['m_nickname'] = base64_decode($head_info['m_nickname']);

        }

		$open_commodity = pdo_get('gpb_config',array('key'=>'open_commodity','weid'=>$this->weid),array('value'));

		$open_commodity = $open_commodity['value'] ? $open_commodity['value'] : 1;

		$arr = array('user' => $user, 'head' => $head, 'head_info' => $head_info,'open_commodity'=>$open_commodity);

//			if($_GPC['openid'] == 'ouMNK5OH676ZgJdsFtZvIXY5jcNU'){

//				$etime=microtime(true);//获取程序执行结束的时间

//				$total=$etime-$stime;  //计算差值

//				echo "<br />当前页面执行时间为：{$total} 秒";exit;

//			}

        if (empty($user) and empty($head)) {

            $this->result(0, "查无数据",$arr);

        } else {

            $this->result(0, "查询成功", $arr);

        }

    }

    /*

     * 获取客服电话

     */

    public function doPagegetSeverPhone()

    {

        global $_W, $_GPC;

        $sql = "select * from " . tablename($this->config) . "  where weid=" . $this->weid . " and " . tablename($this->config) . ".key ='sever_phone'";

        $res = pdo_fetch($sql);

        if (empty($res)) {

            $this->result(0, "查询客服电话失败");

        } else {

            $this->result(1, "查询成功", $res);

        }

    }



    /*

     * 提现请求

     */

    public function doPageapplyGetCash()

    {

        global $_W, $_GPC;

        $openid = $_GPC['openid'];

        $money = $_GPC['money'];

        $form_id = $_GPC['form_id'];

        $type = trim($_GPC['type']);

//        var_dump($form_id);exit();

        if (empty($openid)) {

            $this->result(0, "请传入openid");

        }

        if (empty($money)) {

            $this->result(0, "请传入提现金额");

        }

        if ($money < 1 or $money > 5000) {

            $this->result(0, "单笔提现大于1元小于5000元");

        }

        if (empty($form_id)) {

            $this->result(0, "请传入form_id");

        }

        $info = pdo_get($this->get_cash, array("openid" => $openid, "ggc_type" => 10, "weid" => $this->weid));

        if (!empty($info)) {

            $this->result(0, "提现申请还未审核，请在上次提现处理完成后再申请");

        }

        $account = pdo_get($this->member, array('m_openid' => $openid, "weid" => $this->weid));

        if ($account['m_money'] < $money) {

            $this->result(0, "帐号余额小于提现金额，不能提现");

        }

        if($this->check_base64_out_json( $account['m_nickname'] )){

            $account['m_nickname'] = base64_decode( $account['m_nickname'] );

        }

        $get_cash_limit_money = pdo_get($this->config, array('key' => 'get_cash_limit_money', 'weid' => $this->weid));

        if (isset($get_cash_limit_money['value']) && $money < floatval($get_cash_limit_money['value'])) {

            $this->result(0, "满" . $get_cash_limit_money['value'] . "元才能提现");

        }



        $data = array(

            "openid" => $openid,

            "ggc_money" => $money,

            "ggc_form_id" => $form_id,

            "ggc_type" => 10,

            "ggc_add_time" => time(),

            "ggc_code" => $this->nextId(),

            "weid" => $this->weid

        );

        switch ($type) {

            case 1:

                $data['ggc_pay_type'] = 1;

                break;

            case 2:

                $ggc_pay_account = trim($_GPC['account']);

                if (empty($ggc_pay_account)) {

                    $this->result(0, "请输入支付宝收款帐号");

                }

                $name = trim($_GPC['name']);

                if (empty($name)) {

                    $this->result(0, "请输入支付宝收款人姓名");

                }

                $data['ggc_pay_type'] = 2;

                $data['ggc_pay_account'] = $ggc_pay_account;

                $data['ggc_pay_name'] = $name;

                break;

            case 3:

                $ggc_pay_account = trim($_GPC['account']);

                if (empty($ggc_pay_account)) {

                    $this->result(0, "请输入银行卡号");

                }

                $name = trim($_GPC['name']);

                if (empty($name)) {

                    $this->result(0, "请输入银行卡收款人姓名");

                }

                $bankName = trim($_GPC['bankName']);

                if (empty($bankName)) {

                    $this->result(0, "请输入银行卡开户行地址");

                }

                $data['ggc_pay_type'] = 3;

                $data['ggc_pay_account'] = $ggc_pay_account;

                $data['ggc_pay_name'] = $name;

                $data['ggc_open_account_name'] = $bankName;

                break;

        }

        $res = pdo_insert($this->get_cash, $data);

        if (!empty($res)) {

            //短信通知管理员

            $type = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_type'));

            $set = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_get_cash'));

            $phone = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_admin'));

            $data = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_data'));

            $phone = unserialize($phone['value']);

            $data = unserialize($data['value']);

            $set = unserialize($set['value']);

            $sms = new Sms();

            $weid = $sms->weid = $this->weid;

            if ($type['value'] == 1) {

                //阿里云

                if (is_array($phone)) {

                    foreach ($phone as $k => $v) {

                        $res = $sms->alicloud($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), array('0' => $account['m_nickname'], '1' => $account['m_phone']));

                    }

                }

            } elseif ($type['value'] == 2) {

                //创瑞 todo 不一定成

                if (is_array($phone)) {

                    foreach ($phone as $k => $v) {

                        $res = $sms->chui($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), $account['m_nickname']);

                    }

                }

            }

            //新增公众号消息 周龙 2020-03-05
            $openids = pdo_fetchcolumn("select `value` from ".tablename("gpb_config")." where `key`='refund_msg_openid' and `weid`={$this->weid} and `status`=1");
            if(!empty($openids)){
                //设置的有才发送
                //是否多个
                $subwechat = new \SubWechat();
                $arr = explode(",",$openids);
                if(is_array($arr) && count($arr)>1){
                    $subwechat_arr = [
                        '您有新的提现申请，请及时处理',
                        $account['m_name'],
                        date("Y-m-d H:i:s",time()),
                        $money."元",
                        $data['ggc_pay_type']==1?'微信提现':($data['ggc_pay_type']==2?'支付宝提现':'银行卡提现'),
                        "请及时登录后台审核处理"
                    ];
                    foreach ($arr as $k=>$v){
                        $subwechat->sendunimsg("tmp_cashmsg",$v,$subwechat_arr);
                    }
                }else{
                    //只有一个直接发送
                    $subwechat_arr = [
                        '您有新的提现申请，请及时处理',
                        $account['m_name'],
                        date("Y-m-d H:i:s",time()),
                        $money."元",
                        $data['ggc_pay_type']==1?'微信提现':($data['ggc_pay_type']==2?'支付宝提现':'银行卡提现'),
                        "请及时登录后台审核处理"
                    ];
                    $subwechat->sendunimsg("tmp_cashmsg",$openids,$subwechat_arr);
                }

            }

            $this->result(1, "提现申请成功");

        } else {

            $this->result(0, "提现申请失败，请稍候再试");

        }



    }



    /*

     * 查看是否开启首页秒杀 todo 配置要改

     */

    public function doPageseeIndexSeckill()

    {

        $res = pdo_get($this->config, array("key" => 'index_seckill', 'weid' => $this->weid));

        if (!empty($res)) {

            $this->result(1, "查看是否开启首页秒杀成功", array('status' => $res['value']));

        } else {

            $this->result(0, "查看是否开启首页秒杀失败");

        }

    }



    /*

     * 查看页面标题设置

     */

    public function doPageseeTitleSet()

    {

        $res = pdo_get($this->config, array("key" => 'title_set', 'weid' => $this->weid));

        if (!empty($res)) {

            $res = unserialize($res['value']);

            $this->result(1, "查看页面标题设置成功",$res);

        } else {

            $this->result(0, "查看页面标题设置失败");

        }

    }



    /**

     * 获取团长相关的佣金记录

     */

    public function doPagegetUserCommission()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result(0, "未授权");

        }

        $sql = "select * from " . tablename($this->order) . " where weid=" . $this->weid . " and go_team_openid='" . $openid . "' and go_status != 90 and go_status !=10 and `type`=1 order by go_add_time desc";

        $info = pdo_fetchall($sql);

        if (empty($info)) {

            $this->result(0, "无数据");

        } else {

            foreach ($info as $k => $v) {

                $info[$k]['go_add_time'] = date("Y-m-d H:i:s", $v['go_add_time']);

            }

            $this->result(1, "查询成功", $info);

        }

    }



    /**

     * 获取团长相关的佣金记录

     */

    public function doPagegetUserGetCash()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result(0, "未授权");

        }

        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 10;



        $contion = 'limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;

        $total = pdo_fetchcolumn('select count(*) from ' . tablename($this->get_cash) . " where  weid =" . $this->weid);

        $page = pagination($total, $pageIndex, $pageSize);

        //获取分页信息

        $sql = 'select * from ' . tablename($this->get_cash) . " as gc left join " . tablename($this->member) . " as m on m.m_openid =gc.openid where gc.weid =" . $this->weid . " and m.m_openid ='" . $openid . "'   order by ggc_add_time desc " . $contion;



        $info = pdo_fetchall($sql);

        if (empty($info)) {

            $this->result(0, "无数据");

        } else {

            foreach ($info as $k => $v) {

                $info[$k]['ggc_add_time'] = date("Y-m-d H:i:s", $v['ggc_add_time']);

                if($this->check_base64_out_json( $v['m_nickname'] )){

                    $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );

                }

            }

            $this->result(1, "查询成功", $info);

        }

    }



    /*

     * 获取退款订单商品信息

     */

    public function doPagebackGoodsInfo()

    {

        global $_W, $_GPC;

        $id = trim($_GPC['id']);

        $gid = trim($_GPC['gid']);

        $ossid = trim($_GPC['ossid']);

        if (empty($id)) {

            $this->result(0, "未传入订单信息");

        }

        if (empty($gid)) {

            $this->result(0, "未传入商品信息");

        }

        if (empty($ossid)) {

            $this->result(0, "未传入商品详情信息");

        }

        $order = pdo_get($this->order, array('go_id' => $id, 'weid' => $this->weid, 'type' => 1));

        if (empty($order)) {

            $this->result(0, "查询订单信息失败");

        }

        //$goods = pdo_get($this->goods,array('g_id'=>$gid,'weid'=>$this->weid,'`type` !='=>2));

        $goods = pdo_fetch("select * from " . tablename($this->goods) . " as g where g_id =" . $gid . " and weid =" . $this->weid . " and  (g.`type`<>2 or g.`type` is null)");

        $goods['g_icon'] = tomedia($goods['g_icon']);

        $gs = pdo_get($this->snapshot, array('oss_id' => $ossid));

		if($gs['oss_member_price'] > 0){
			$gs['oss_total_price'] = $gs['oss_member_price'];
		}

        if (empty($gs)) {

            $this->result(0, "查询商品信息失败");

        } else {

            $this->result(1, "查询成功", array("order" => $order, "goods" => $goods, 'gs' => $gs));

        }

        exit();

    }



    /*

     * 申请退款

     */

    public function doPageapplyBackMoney()
    {
        global $_W, $_GPC;
        $openid = trim($_GPC['openid']);
        $id = trim($_GPC['id']);
        $gid = trim($_GPC['gid']);
        $ossid = trim($_GPC['ossid']);
        $phone = trim($_GPC['orderUserPhone']);
        $refundSign = trim($_GPC['refundSign']);
        $refundReason = trim($_GPC['refundReason']);
        $refundRemark = trim($_GPC['refundRemark']);
        $orderType = trim($_GPC['orderType']);//1退款2退款退货
        $formId = trim($_GPC['formId']);
        if (empty($openid)) {
            $this->result(0, "未授权");
        }
        if (empty($id)) {
            $this->result(0, "未传入订单信息");
        }
        if (empty($gid)) {
            $this->result(0, "未传入商品信息");
        }
        if (empty($ossid)) {
            $this->result(0, "未传入商品详情信息");
        }
        if (empty($phone)) {
            $this->result(0, "未传入电话");
        }
        if (empty($refundReason)) {
            $this->result(0, "未选择退款理由");
        }
        if (empty($refundSign)) {
            $this->result(0, "未选择收货状态");
        }
        if (empty($refundRemark)) {
            $this->result(0, "未输入退款说明");
        }
        $order = pdo_get($this->order, array("go_id" => $id, "weid" => $this->weid));
        if (empty($order)) {
            $this->result(0, "订单信息错误");
        }
        $oss = pdo_get($this->snapshot, array('oss_id' => $ossid));
        if (empty($oss)) {
            $this->result(0, "商品详情信息错误");
        }
		if($oss['oss_member_price'] > 0){
    		$oss['oss_total_price'] = $oss['oss_member_price'];
    	}
        $old = pdo_get($this->back_money, array("openid" => $openid, 'gbm_go_code' => $order['go_code'], 'gbm_oss_id' => $oss['oss_id']));
        $account = pdo_get($this->member, array('m_openid' => $openid, "weid" => $this->weid));
        if (!empty($old) && $old['gbm_status'] == 10) {
            $this->result(0, "您的退款申请还在审核中，请勿重复提交");
        }
        if($this->check_base64_out_json( $account['m_nickname'] )){
            $account['m_nickname'] = base64_decode( $account['m_nickname'] );
        }
        /*退款金额确定*/
        $back_money = 0;
        //判断是否满减,我们只有满减卷，暂时不判断
        //情况1：未使用满减卷
        if ($order['go_fdc_id'] == 0) {
            $goods_count = pdo_fetchcolumn("select count(*) from " . tablename($this->snapshot) . " where oss_go_code=" . $order['go_code'] . " and (oss_ggo_status=1 or oss_ggo_status=60)");
            //是否是最后一件商品
            if ($goods_count == 1) {
                $back_money = $oss['oss_total_price'] + $order['go_send_pay'];
            } else {
                $back_money = $oss['oss_total_price'];
            }
        }
        //情况2：当使用了满减卷
        if ($order['go_fdc_id'] > 0) {
            //查询优惠卷
            $coupon = pdo_fetch("select t.use_limit,t.cut_price from " . tablename($this->user_coupon) . " as ut left join " . tablename($this->coupon) . " as t on t.id =ut.tid where ut.openid='" . $openid . "' and ut.weid=" . $this->weid . " and ut.id = " . $order['go_fdc_id']);

//            //情况2-1：当该商品退款后，余下商品不满足满减时

//            if($order['go_real_price']-$oss['oss_total_price'] < $coupon['use_limit']){

//                $back_money=$oss['oss_total_price']-$coupon['cut_price'];

//            }else{

//                //情况2-2：当该商品退款后，余下商品满足满减时,按比例退

//                $back_money=$oss['oss_total_price']-$coupon['cut_price']*$oss['oss_total_price']/$order['go_real_price'];

//            }



            //按淘宝的做法来：订单单价分摊算法，且邮费不参与分摊，只是加到最后一笔退款订单上

            $goods_count = pdo_fetchcolumn("select count(*) from " . tablename($this->snapshot) . " where oss_go_code=" . $order['go_code'] . " and (oss_ggo_status=1 or oss_ggo_status=60)");

            if ($goods_count <= 0) {

                $this->result(0, "退款失效");

            }

            //是否是最后一件商品

            if ($goods_count == 1) {

                //最后一件

                $alerdy_back = pdo_fetch('select sum(gbm_money) as total from ' . tablename('gpb_back_money') . ' as bm left join ' . tablename($this->snapshot) . ' as sn on sn.oss_id=bm.gbm_oss_id and sn.oss_go_code=bm.gbm_go_code where sn.oss_go_code=' . $order['go_code'] . ' and bm.gbm_status != 30 and (sn.oss_ggo_status = 70 or sn.oss_ggo_status = 50) and bm.weid=' . $this->weid);

                $alerdy_back = empty($alerdy_back['total']) ? 0 : $alerdy_back['total'];

                $back_money = $order['go_real_price'] - $alerdy_back;

                //$back_money=$oss['oss_total_price']-($coupon['cut_price']+$order['go_full_reduce_price'])*$oss['oss_total_price']/($order['go_real_price']) + $order['go_send_pay'];

            } else {

                $back_money = $oss['oss_total_price'] - ($coupon['cut_price'] + $order['go_full_reduce_price']) * $oss['oss_total_price'] / ($order['go_real_price']);

            }

        }

		//判断订单是否采用积分抵扣

		if($order['integral'] > 0 && $order['go_fdc_id'] == 0){

			//使用了积分抵扣    按淘宝的做法来：订单单价分摊算法，

			$goods_count = pdo_fetchcolumn("select count(*) from " . tablename($this->snapshot) . " where oss_go_code=" . $order['go_code'] . " and (oss_ggo_status=1 or oss_ggo_status=60)");

			if ($goods_count <= 0) {

                $this->result(0, "退款失效");

            }

			if ($goods_count == 1) {

				//最后一件

				 $alerdy_back = pdo_fetch('select sum(gbm_money) as total from ' . tablename('gpb_back_money') . ' as bm left join ' . tablename($this->snapshot) . ' as sn on sn.oss_id=bm.gbm_oss_id and sn.oss_go_code=bm.gbm_go_code where sn.oss_go_code=' . $order['go_code'] . ' and bm.gbm_status != 30 and (sn.oss_ggo_status = 70 or sn.oss_ggo_status = 50) and bm.weid=' . $this->weid);

                $alerdy_back = empty($alerdy_back['total']) ? 0 : $alerdy_back['total'];

                $back_money = $order['go_real_price'] - $alerdy_back;

			} else {

				//不是最后一件

				$back_money = $oss['oss_total_price'] - ($oss['oss_total_price']/$order['go_real_price']*$order['integral']);

			}

		}

        if ($back_money < 0) {

            $back_money = 0.01;

        }

        $data = array(

            'gbm_code' => $this->nextId(),

            'gbm_money' => sprintf("%.2f", $back_money),

            'gbm_go_code' => $order['go_code'],

            'gbm_go_money' => $order['go_real_price'],

            'gbm_status' => 10,

            'gbm_content' => $refundReason,

            'gbm_comment' => $refundRemark,

            'gbm_form_id' => $formId,

            'openid' => $openid,

            'gbm_add_time' => time(),

            'weid' => $this->weid,

            'gbm_oss_id' => $oss['oss_id'],

            'gbm_type' => $orderType,

            'gbm_goods_type' => $refundSign,

            'gbm_phone' => $phone,

            'gpb_head_money'=>$oss['oss_commission'],

        );

//        var_dump($data);exit;

        if (!empty($old)) {

            $res = pdo_update($this->back_money, $data, array('gbm_id' => $old['gbm_id']));

        } else {

            $res = pdo_insert($this->back_money, $data);

        }





        if (!empty($res)) {

            //如果是最后一件商品且状态为未发货时，订单变为取消,状态大于已发货时 要在审核后改变

//            if($goods_count == 1 && $order['go_status']== 20){

//                pdo_update($this->order,array("go_status"=>110),array('go_id'=>$order['go_id'],'weid'=>$this->weid));

//            }

            pdo_update($this->snapshot, array("oss_ggo_status" => 50), array('oss_id' => $ossid));

            //短信通知管理员

            $type = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_type'));

            $set = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_refud'));

            $phone = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_admin'));

            $data = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_data'));

            $phone = unserialize($phone['value']);

            $data = unserialize($data['value']);

            $set = unserialize($set['value']);

            $sms = new Sms();

            $sms->weid = $this->weid;

            if ($type['value'] == 1) {

                //阿里云

                if (is_array($phone)) {

                    foreach ($phone as $k => $v) {

                        $res = $sms->alicloud($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), array('0' => $account['m_nickname'], '1' => $account['m_phone']));

                    }

                }

            } elseif ($type['value'] == 2) {

                //创瑞 todo 不一定成

                if (is_array($phone)) {

                    foreach ($phone as $k => $v) {

                        $res = $sms->chui($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), $account['m_nickname']);

                    }

                }

            }

//            $this->result(1,"提现申请成功",array('sms_var'=>trim($set['content']['value']),'sms_key'=>trim($data['key']['value']),'sms_serect'=>trim($data['serect']['value']),'sms_sign'=>trim($data['sign']['value']),'sms_id'=>trim($set['id']['value']),'phone'=>$phone,'res'=>$res,'type'=>$type));
            //2020-03-02 周龙 申请退款公众号发送消息给管理员
            $openids = pdo_fetchcolumn("select `value` from ".tablename("gpb_config")." where `key`='refund_msg_openid' and `weid`={$this->weid} and `status`=1");
            if(!empty($openids)){
                //设置的有才发送
                //是否多个
                $subwechat = new \SubWechat();
                $arr = explode(",",$openids);
                if(is_array($arr) && count($arr)>1){
                    foreach ($arr as $k=>$v){
                        $wechat_arr = [
                            '平台有退款申请，请你进入后台完成审核',
                            $order['go_code'],
                            sprintf("%.2f", $back_money).'元',
                            '退款理由:'.$refundReason.'/n退款备注:'.$refundRemark
                        ];
                        $subwechat->sendunimsg("tmp_refund",$v,$wechat_arr);
                    }
                }else{
                    //只有一个直接发送
                    $wechat_arr = [
                        '平台有退款申请，请你进入后台完成审核',
                        $order['go_code'],
                        sprintf("%.2f", $back_money).'元',
                        '退款理由:'.$refundReason.',退款备注:'.$refundRemark
                    ];
                    $subwechat->sendunimsg("tmp_refund",$openids,$wechat_arr);
                }

            }

            $this->result('1', "申请退款成功，请等待审核");

        } else {

            $this->result('0', "申请退款失败，请重试");

        }





    }



    /**

     * 查询退款订单和退款商品

     */

    public function doPagegetBackMoneyOrder()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "请传入openid");

        }

        $where = " ";

        //逻辑：订单状态是确定查询

        if (isset($_GPC['status']) and !empty($_GPC['status'])) {

            if ($_GPC['status'] == "back_money") {

                $where .= " and  oss_ggo_status  >40 and oss_ggo_status<=70  ";

            } else {

                $where .= " and  oss_ggo_status = '" . trim($_GPC['status']) . "' ";

            }

        }

        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 10;



        $contion = 'limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;



        $sql = "select * from " . tablename($this->back_money) . " as bk left join " . tablename($this->snapshot) . " as sn on sn.oss_id = bk.gbm_oss_id left join " . tablename($this->order) . " as o on o.go_code=bk.gbm_go_code left join " . tablename($this->member) . " as m on m.m_openid=bk.openid where `type`=1 and o.go_is_del=1 and o.weid=" . $this->weid . $where . " and m.m_openid = '" . $openid . "' order by gbm_add_time desc " . $contion;

        $list = pdo_fetchall($sql);



        if (empty($list)) {

            $this->result("1", "查询订单失败，请重试");

        } else {

            foreach ($list as $k => $v) {

                $list[$k]['gbm_add_time'] = date("Y-m-d H:i:s", $v['gbm_add_time']);

                $list[$k]['oss_g_icon'] = tomedia($v['oss_g_icon']);

                if($this->check_base64_out_json( $v['m_nickname'] )){

                    $list[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );

                }

            }

            $this->result("0", "查询订单成功", $list);

        }

    }



    /**

     * 查询退款详情

     */

    public function doPagegetBackMoneyInfo()

    {

        global $_W, $_GPC;

        $oid = trim($_GPC['oid']);

        $id = trim($_GPC['id']);

        if (empty($id)) {

            $this->result("1", "未传入退款信息");

        }

        if (empty($oid)) {

            $this->result("1", "未传入订单信息");

        }

        $order = pdo_get($this->order, array('go_id' => $oid, 'weid' => $this->weid, 'type' => 1));

        if (empty($order)) {

            $this->result("1", "订单信息获取失败");

        }

        $back = pdo_fetch("select * from " . tablename($this->back_money) . " as bk join " . tablename($this->member) . " as m on m.m_openid=bk.openid join " . tablename($this->snapshot) . " as s on s.oss_id = bk.gbm_oss_id where gbm_id = " . $id);

        $back['gbm_add_time'] = date("Y-m-d H:i:s", $back['gbm_add_time']);

        if($this->check_base64_out_json( $back['m_nickname'] )){

            $back['m_nickname'] = base64_decode( $back['m_nickname'] );

        }

        if (empty($back)) {

            $this->result("1", "退款信息获取失败");

        } else {

            $this->result("0", "退款信息获取成功", array('order' => $order, 'back' => $back));

        }

        exit();

    }



    /**

     * 腾讯地图请求sn md5加密

     */

    public function doPageGetSnMd5()

    {



        global $_W, $_GPC;

        $lat = trim($_GPC['lat']);

        $lng = trim($_GPC['lng']);

        if (empty($lat) || empty($lng)) {

            $this->result("1", "未传入坐标", array($_GPC['lat'], $_GPC['lng']));

        } else {

            //todo 后期加配置让用户用自己的腾讯地图接口

            $sn = "kxCOUOuyI5fG2d6kKnl7bCNEG5XqA74";

            $key = "UOMBZ-SZLRW-6XMR4-OUGPZ-EPL5O-TBFTS";

            $sig = md5("/ws/geocoder/v1?key=" . $key . "&location=" . $lat . "," . $lng . $sn);

            $res = $this->http_request(

                "https://apis.map.qq.com/ws/geocoder/v1?key=" . $key . "&location=" . $lat . "," . $lng . "&sig=" . $sig);

            $info = json_decode($res);

            $city = $info->result->ad_info->city;

            $province = $info->result->ad_info->province;

            $area = $info->result->ad_info->district;

            $city_arr = pdo_get('gpb_area', array('name' => $city, 'level' => 'city'));

            $area_arr = pdo_get('gpb_area', array('name' => $area, 'level' => 'area'));

            $province_arr = pdo_get('gpb_area', array('name' => $province, 'level' => 'province'));

//            if(isset($area_arr['ad_code']) && !empty($area_arr['ad_code']) ){

//

//            }

            if ($_GPC['test'] == 1) {

                var_dump($city);

                var_dump($province);

                var_dump($area);

                var_dump($city = $info->result->ad_info);

                exit;

            }

            //查询

            $this->result("0", "SN加密成功", array('data' => $res, 'cid' => $city_arr['id'], 'area' => $area_arr, 'city' => $city_arr, 'province' => $province_arr));

        }

    }



    /**

     * 获取全国城市信息

     */

    public function doPageGetCityList()

    {

        global $_W, $_GPC;

        $all_city = cache_load('all_city' . $this->weid);

        if (empty($all_city)) {

            $sql = "select * from " . $this->pre . "gpb_area where level = 'city'";

            $list = pdo_fetchall($sql);

            foreach ($list as $k => $v) {

                $list[$k]['initial'] = $this->getFirstChar($v['name']);

                $list[$k]['city'] = $v['name'];

            }

            foreach ($list as $v) {

                $res[$v['initial']]['cityInfo'][] = $v;

                $res[$v['initial']]['initial'] = $v['initial'];

            }

            ksort($res, SORT_NATURAL);

            cache_write('all_city' . $this->weid, $res);

        }

        $this->result("0", "城市读取成功", cache_load('all_city' . $this->weid));

    }



    /**

     * 取汉字的第一个字的首字母

     * @param string $str

     * @return string|null

     */

    private function getFirstChar($str)

    {

        if (empty($str)) {

            return '';

        }

        //生僻字特殊返回

        if ($str == '亳州市') {

            return 'B';

        }

        if ($str == "衢州市") {

            return 'Q';

        }

        if ($str == '濮阳市') {

            return 'P';

        }

        if ($str == '漯河市') {

            return 'L';

        }

        if ($str == '儋州市') {

            return 'D';

        }

        if ($str == '泸州市') {

            return 'L';

        }

        $fir = $fchar = ord($str[0]);

        if ($fchar >= ord('A') && $fchar <= ord('z')) {

            return strtoupper($str[0]);

        }



        $s1 = @iconv('UTF-8', 'gb2312', $str);

        $s2 = @iconv('gb2312', 'UTF-8', $s1);

        $s = $s2 == $str ? $s1 : $str;

        if (!isset($s[0]) || !isset($s[1])) {

            return '';

        }



        $asc = ord($s[0]) * 256 + ord($s[1]) - 65536;



        if (is_numeric($str)) {

            return $str;

        }



        if ($asc >= -20319 && $asc <= -20284) return 'A';

        if ($asc >= -20283 && $asc <= -19776) return 'B';

        if ($asc >= -19775 && $asc <= -19219) return 'C';

        if ($asc >= -19218 && $asc <= -18711) return 'D';

        if ($asc >= -18710 && $asc <= -18527) return 'E';

        if ($asc >= -18526 && $asc <= -18240) return 'F';

        if ($asc >= -18239 && $asc <= -17923) return 'G';

        if ($asc >= -17922 && $asc <= -17418) return 'H';

        if ($asc >= -17417 && $asc <= -16475) return 'J';

        if ($asc >= -16474 && $asc <= -16213) return 'K';

        if ($asc >= -16212 && $asc <= -15641) return 'L';

        if ($asc >= -15640 && $asc <= -15166) return 'M';

        if ($asc >= -15165 && $asc <= -14923) return 'N';

        if ($asc >= -14922 && $asc <= -14915) return 'O';

        if ($asc >= -14914 && $asc <= -14631) return 'P';

        if ($asc >= -14630 && $asc <= -14150) return 'Q';

        if ($asc >= -14149 && $asc <= -14091) return 'R';

        if ($asc >= -14090 && $asc <= -13319) return 'S';

        if ($asc >= -13318 && $asc <= -12839) return 'T';

        if ($asc >= -12838 && $asc <= -12557) return 'W';

        if ($asc >= -12556 && $asc <= -11848) return 'X';

        if ($asc >= -11847 && $asc <= -11056) return 'Y';

        if ($asc >= -11055 && $asc <= -10247) return 'Z';



        return '';

    }

//	public function doPageIst(){

//		global $_W, $_GPC;

//		if (!extension_loaded("redis")) {

//			echo 'redis没有开启';exit;

//		}

//		$config = $_W["config"]["setting"]["redis"];

//		$redis = new Redis();

//		if ($config["pconnect"]) {

//          $connect = $redis->pconnect($config["server"], $config["port"], $config["timeout"]);

//      } else {

//          $connect = $redis->connect($config["server"], $config["port"], $config["timeout"]);

//      }

//		$arr = array(1,2,3,4,5,6,7,8,9);

//		foreach($arr as $k=>$v){

//	  		$redis->rpush("mylist",$v);

//		}

//		echo '完成';exit;

//	}

//	public function doPageAsd(){

//		global $_W, $_GPC;

//		if (!extension_loaded("redis")) {

//			echo 'redis没有开启';exit;

//		}

//		$config = $_W["config"]["setting"]["redis"];

//		$redis = new Redis();

//		if ($config["pconnect"]) {

//          $connect = $redis->pconnect($config["server"], $config["port"], $config["timeout"]);

//      } else {

//          $connect = $redis->connect($config["server"], $config["port"], $config["timeout"]);

//      }

////		$redis->ltrim('mylist',0,0);

//		$value = $redis->lpop('mylist');

//		if($value){

//			echo "出队的值".$value;

//		}else{

//			echo "出队完成";exit;

//		}

//	}

    //商品检查，在购买前的每一步都检查该商品是否能被购买

    public function doPageCheckGoods()

    {

        global $_W, $_GPC;

        $id = trim($_GPC['id']);

        if (empty($id)) {

            $this->result("1", "未传入商品信息");

        }

//		判断是否是秒杀商品

		if($_GPC['type'] === 'spike'){

			//秒杀商品   先采用消息队列  在采用文件锁的形式来  先将进入数量进行分流  在进行文件锁  进行下单

			if (!extension_loaded("redis")){

				//没有安装reedis扩展

			}else{

				//查找库存是好多     就进入好多人

				$config = $_W["config"]["setting"]["redis"];

				$redis = new Redis();

				if ($config["pconnect"]) {

            		$connect = $redis->pconnect($config["server"], $config["port"], $config["timeout"]);

        		} else {

            		$connect = $redis->connect($config["server"], $config["port"], $config["timeout"]);

        		}

				$value = $redis->lpop('goods_'.$id);

				if(!$value){

					$this->result("1", "秒杀商品也抢完了");

				}

			}

		}



        $id = explode(",", $id);
        $member = pdo_get("gpb_member",array('m_openid'=>$_GPC['openid']));

        if (is_array($id)) {

            foreach ($id as $k => $v) {

                $goods = pdo_fetch("select * from " . tablename($this->goods) . " as g left join " . tablename($this->goods_stock) . " as gs on gs.goods_id = g.g_id where g_id=" . $v . " and (g.`type`<>2 or g.`type` is null) and g.weid=" . $this->weid);

                if (empty($goods)) {

                    $this->result("1", "商品信息有误");

                }

                if ($goods['g_is_online'] == -1) {

                    $this->result("1", "商品(" . $goods['g_name'] . ")已下架");

                }

                if ($goods['g_is_del'] == -1) {

                    $this->result("1", "商品(" . $goods['g_name'] . ")已被取消");

                }

                if ($goods['num'] <= 0) {

                    $this->result("1", "商品(" . $goods['g_name'] . ")已售罄");

                }
                if($member['m_is_head'] !=2 && $goods['g_is_head_enjoy']==1){
                    $this->result("1", "商品(" . $goods['g_name'] . ")限购");
                }


            }

            $this->result("0", "");

        } else {

            $goods = pdo_fetch("select * from " . tablename($this->goods) . " as g left join " . tablename($this->goods_stock) . " as gs on gs.goods_id = g.g_id where g_id=" . $id . " and (g.`type`<>2 or g.`type` is null) and g.weid=" . $this->weid);



            if (empty($goods)) {

                $this->result("1", "商品信息有误");

            }

            if ($goods['g_is_online'] == -1) {

                $this->result("1", "商品(" . $goods['g_name'] . ")已下架");

            }

            if ($goods['g_is_del'] == -1) {

                $this->result("1", "商品(" . $goods['g_name'] . ")已被取消");

            }

            if ($goods['num'] <= 0) {

                $this->result("1", "商品(" . $goods['g_name'] . ")已售罄");

            }
            if($member['m_is_head'] !=2 && $goods['g_is_head_enjoy']==1){
                $this->result("1", "商品(" . $goods['g_name'] . ")限购");
            }
            $this->result("0", "");

        }

    }



    //团长管理页面，团长排行获取

    public function doPageGetTeamRank(){
        global $_GPC, $_W;
        $openid = trim($_GPC['openid']);
        $status = trim($_GPC['status']);
        $rand = rand(0, 100);
        if ($rand > 80) {
            $_GPC['fresh'] = 1;
        }
        if (empty($openid)) {
            $this->result("1", "未授权");
        }
        $today = date('Y-m-d', time());
        $where = '';
        $today = strtotime(date('Y-m-d 00:00:00', time()));
		$e_today = $today-1;
        $today = strtotime(date('Y-m-d 00:00:00', $e_today));
        if (empty($status) && $status != 0) {
            $this->result("1", "查询排名失败");
        } elseif ($status == 0) {

        	cache_delete('head_rank_days_wxapp' . $this->weid);
            $head_rank_days = cache_load('head_rank_days_wxapp' . $this->weid);
            if (empty($head_rank_days) || $_GPC['fresh'] == 1 || (isset($head_rank_days['value'])) || (isset($head_rank_days['data']))) {

                $head_rank_days = pdo_fetchall("select m.m_nickname AS `name`,m.m_name ,m.m_photo AS img,sum(gos_real_money) as money from " . tablename('gpb_order_stream') ." as os left join " . tablename('gpb_member') . " as m on m.m_openid = os.gos_team_openid join ".tablename('gpb_order')." ors on ors.go_code = os.gos_go_code where ors.go_status != 110 and gos_stream_type=1 and gos_real_money >0 and gos_type =1 and os.weid =" . $this->weid . " and gos_sure_pay_time >=" . $today . " and gos_sure_pay_time <= ".$e_today."  group by gos_team_openid  order by money desc  limit 10");

                if (is_array($head_rank_days)) {

                    foreach ($head_rank_days as $k => $v) {

                        $reduce = pdo_fetch("select sum(gos_real_money) as total from  " . tablename('gpb_order_stream') . " as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_team_openid ='" . $v['gos_team_openid'] . "' group by gos_team_openid");

                        $after_reduce = floatval($v['money']) - floatval($reduce['total']);

                        if ($after_reduce <= 0) {

                            unset($head_rank_days['$k']);

                        } else {

                            $head_rank_days[$k]['money'] = $after_reduce;

                        }

                    }

                    if (is_array($head_rank_days)) {

                        $head_rank_days = array_slice($head_rank_days, 0, 10);  //获取键值0-10的数组元素

                    }

                }

                if (empty($head_rank_days)) {

                    $head_rank_days = array();

                }

                cache_write('head_rank_days_wxapp' . $this->weid, $head_rank_days, 24 * 60 * 60);

            }

            $data = $head_rank_days;

        } elseif ($status == 10) {

            $head_rank_week = cache_load('head_rank_week_wxapp' . $this->weid);

            if (empty($head_rank_week) || $_GPC['fresh'] == 1 || (isset($head_rank_days['value'])) || (isset($head_rank_days['data']))) {

                $head_rank_week = pdo_fetchall("select m.m_nickname AS `name`,m.m_name ,m.m_photo AS img,sum(gos_real_money) as money from " . tablename('gpb_order_stream') . " as os left join " . tablename('gpb_member') . " as m on m.m_openid = os.gos_team_openid join ".tablename('gpb_order')." ors on ors.go_code = os.gos_go_code where ors.go_status != 110 and gos_stream_type=1 and gos_real_money >0 and gos_type =1 and os.weid =" . $this->weid . " and gos_sure_pay_time >=" . ($today - 7 * 24 * 60 * 60) . " group by gos_team_openid  order by money desc  limit 20");

                if (is_array($head_rank_week)) {

                    foreach ($head_rank_week as $k => $v) {

                        $reduce = pdo_fetch("select sum(gos_real_money) as total from  " . tablename('gpb_order_stream') . " as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_team_openid ='" . $v['gos_team_openid'] . "' group by gos_team_openid");

                        $after_reduce = floatval($v['money']) - floatval($reduce['total']);

                        if ($after_reduce <= 0) {

                            unset($head_rank_week['$k']);

                        } else {

                            $head_rank_week[$k]['money'] = $after_reduce;

                        }

                    }



                    if (is_array($head_rank_week)) {

                        $head_rank_week = array_slice($head_rank_week, 0, 10);  //获取键值0-10的数组元素

                    }

                }

                if (empty($head_rank_week)) {

                    $head_rank_week = array();

                }

                cache_write('head_rank_week_wxapp' . $this->weid, $head_rank_week, 7 * 24 * 60 * 60);

            }

            $data = $head_rank_week;

        } elseif ($status == 20) {

            $head_rank_mon = cache_load('head_rank_mon_wxapp' . $this->weid);

            if (empty($head_rank_mon) || $_GPC['fresh'] == 1 || (isset($head_rank_days['value'])) || (isset($head_rank_days['data']))) {

                $head_rank_mon = pdo_fetchall("select m.m_nickname AS `name`,m.m_name ,m.m_photo AS img,sum(gos_real_money) as money from " . tablename('gpb_order_stream') . " as os left join " . tablename('gpb_member') . " as m on m.m_openid = os.gos_team_openid join ".tablename('gpb_order')." ors on ors.go_code = os.gos_go_code where ors.go_status != 110 and gos_stream_type=1 and gos_real_money >0 and gos_type =1 and os.weid =" . $this->weid . " and gos_sure_pay_time >=" . ($today - 31 * 24 * 60 * 60) . " group by gos_team_openid  order by money desc  limit 30");

                if (is_array($head_rank_mon)) {

                    foreach ($head_rank_mon as $k => $v) {

                        $reduce = pdo_fetch("select sum(gos_real_money) as total from  " . tablename('gpb_order_stream') . " as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_team_openid ='" . $v['gos_team_openid'] . "' group by gos_team_openid");

                        $after_reduce = floatval($v['money']) - floatval($reduce['total']);

                        if ($after_reduce <= 0) {

                            unset($head_rank_mon['$k']);

                        } else {

                            $head_rank_mon[$k]['money'] = $after_reduce;

                        }

                    }

                    if (is_array($head_rank_mon)) {

                        $head_rank_mon = array_slice($head_rank_mon, 0, 10);  //获取键值0-10的数组元素

                    }

                }

                if (empty($head_rank_mon)) {

                    $head_rank_mon = array();

                }

                cache_write('head_rank_mon_wxapp' . $this->weid, $head_rank_mon, 7 * 24 * 60 * 60);

            }

            $data = $head_rank_mon;

        } elseif ($status == 30) {
//      	年榜
            $head_rank_year = cache_load('head_rank_year_wxapp' . $this->weid);
            if (empty($head_rank_year) || $_GPC['fresh'] == 1) {
            	$sql = "SELECT m.m_nickname AS `name`,m.m_name ,m.m_photo AS img,os.money FROM ( SELECT SUM(gos_real_money) AS money,gos_team_openid,gos_go_code FROM ims_gpb_order_stream AS os JOIN `ims_gpb_order` ors ON ors.go_code = os.gos_go_code WHERE gos_stream_type=1 AND gos_real_money >0 AND gos_type =1 AND os.weid =" . $this->weid . " AND gos_sure_pay_time >=" . ($today - 365 * 24 * 60 * 60) . " AND ors.go_status != 110 GROUP BY gos_team_openid ORDER BY money DESC LIMIT 100 ) AS os JOIN `ims_gpb_member` AS m ON m.m_openid = os.gos_team_openid";
                $head_rank_year = pdo_fetchall($sql);
//              $head_rank_year = pdo_fetchall("select m.m_nickname AS `name`,m.m_name ,m.m_photo AS img,sum(gos_real_money) as money from " . tablename('gpb_order_stream') . " as os left join " . tablename('gpb_member') . " as m on m.m_openid = os.gos_team_openid join ".tablename('gpb_order')." ors on ors.go_code = os.gos_go_code where ors.go_status != 110 and gos_stream_type=1 and gos_real_money >0 and gos_type =1 and os.weid =" . $this->weid . " and gos_sure_pay_time >=" . ($today - 365 * 24 * 60 * 60) . " group by gos_team_openid  order by money desc  limit 100");
                if (is_array($head_rank_year)) {
                    foreach ($head_rank_year as $k => $v) {
                        $reduce = pdo_fetch("select sum(gos_real_money) as total from  " . tablename('gpb_order_stream') . " as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_team_openid ='".$v['gos_team_openid']);
                        $after_reduce = floatval($v['money']) - floatval($reduce['total']);
                        if ($after_reduce <= 0) {
                            unset($head_rank_year[$k]);
                        } else {
                            $head_rank_year[$k]['money'] = $after_reduce;
                        }
                    }
                    if (is_array($head_rank_year)) {
                        $head_rank_year = array_slice($head_rank_year, 0, 10);  //获取键值0-10的数组元素
                    }
                }
                if (empty($head_rank_year)) {
                    $head_rank_year = array();
                }
                cache_write('head_rank_year_wxapp' . $this->weid, $head_rank_year, 7 * 24 * 60 * 60);
            }
            $data = $head_rank_year;
        }
        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 10;

        $contion = 'limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;

//        $sql = "SELECT t.total AS money,t.go_team_openid,t.m_nickname AS name,t.m_name ,t.m_photo AS img,CASE WHEN @rowtotal = t.total THEN @rownum WHEN @rowtotal := t.total THEN @rownum :=@rownum + 1 WHEN @rowtotal = 0 THEN @rownum:=@rownum + 1 END AS rownum FROM (SELECT @rownum := 0) r, (SELECT SUM(go_commission) AS total,go_team_openid,m_nickname,m_name,m_photo FROM ".$this->pre."gpb_order AS o LEFT JOIN ".$this->pre."gpb_member AS m ON m.m_openid = o.go_team_openid WHERE m.weid=".$this->weid." AND go_status = 100 AND (go_is_cash=1  OR go_is_cash=2) ".$where." GROUP BY go_team_openid ORDER BY total DESC) AS t;";

//        $res = pdo_fetchall($sql);

//        var_dump("select m.m_nickname AS name,m.m_name ,m.m_photo AS img,sum(gos_real_money) as money from ".tablename('gpb_order_stream')." as os left join ".tablename('gpb_member')." as m on m.m_openid = os.gos_team_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =".$this->weid." and gos_sure_pay_time >=".($today-7*24*60*60)." group by gos_team_openid  order by money desc  limit 20");exit;

        if (!empty($data)) {

            if (isset($data['expire']) && isset($data['data']) && empty($data['data'])) {

                $data = array();

            } else {

                foreach ($data as $k => $v) {

                    $data[$k]['ranking'] = $k + 1;

                    if($this->check_base64_out_json($v['name'])){

                        $data[$k]['name'] = base64_decode($v['name']);

                    }

                }

            }



            $this->result("0", "查询排名成功", $data);

        } else {

            $this->result("1", "查询排名失败");

        }



    }



    //团长管理读取排行榜设置

    public function doPageGetTeamRankSet()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        $config = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'team_rank'));



        if (empty($config)) {

            $this->result("1", "查询排名配置失败");

        } else {

            $this->result("0", "查询排名配置成功", unserialize($config['value']));

        }

    }



    //申请供应商

    public function doPageApplaySupplier()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        $shop_name = trim($_GPC['shop_name']);

        if (empty($shop_name)) {

            $this->result("1", "请输入供应商名称");

        }

        $name = trim($_GPC['name']);

        if (empty($name)) {

            $this->result("1", "请输入负责人名称");

        }

        $phone = trim($_GPC['phone']);

        if (empty($phone)) {

            $this->result("1", "请输入负责人电话");

        }

        $comment = trim($_GPC['comment']);



        $old = pdo_get($this->supplier, array('openid' => $openid, 'weid' => $this->weid));

        if (!empty($old) && $old['gsp_status'] == -1 && $old['gsp_is_del'] != -1) {

            $this->result("1", "上传的申请正在审核，请等待");

        }

        if (!empty($old) && $old['gsp_status'] == 1 && $old['gsp_is_del'] != -1) {

            $this->result("1", "申请的供应商帐号正常使用中，无法重复申请");

        }

        $data = array(

            'openid' => $openid,

            'gsp_status' => -1,

            'weid' => $this->weid,

            'gsp_name' => $name,

            'gsp_shop_name' => $shop_name,

            'gsp_phone' => $phone,

            'gsp_comment' => $comment,

            'gsp_apply_time' => time(),

            'gsp_add_time' => time(),

            'gsp_is_del' => 1

        );

        if (empty($old)) {

            $res = pdo_insert($this->supplier, $data);

        } else {

            $res = pdo_update($this->supplier, $data, array("gsp_id" => $old['gsp_id']));

        }

        if (!empty($res)) {

            $this->result("0", "申请成功请等待审核");

        } else {

            $this->result("1", "申请失败，请重试");

        }

    }





    public function __call($function, $data){
        global $_GPC, $_W;
        //获取数据
        if (empty($data)) {
            $data = $_GPC;
        }
        //解析方法名
        $fun = substr($function, 6);
        if (empty($fun)) {
            $this->result(1,'方法不存在');
        }
        //获取模块名
        $list = explode('_', $fun);
        if (empty($list[0])) {
            $this->result(1,'插件不存在');
        }
        //大写转小写
        $name = strtolower($list[0]);
		$plug = 'group_buy_plugin_'.$name;
		if(file_exists("../addons/".$plug)){
			$plugin_module = WeUtility::createModuleHook($plug);
			if($plugin_module){
		        $arr = call_user_func_array(array($plugin_module, 'hookpage' . $fun), array('params' => $data));
				return $arr;
			} else {
				$this->result(2,'插件不存在');
			}
		} else {
			$arr = explode('_',strtolower($fun));
			if(is_array($arr) && count($arr) > 1){
				$str = "";
				foreach($arr as $ks=>$vs){
					$str .= $vs."/";
				}
				$str = trim($str,'/');
			}else{
				$str = $name;
			}
			$url = '../addons/group_buy/inc/wxapp/'.$str.".inc.php";
			$file_url = '../addons/group_buy/inc/wxapp/'.$str;
			if(is_dir($file_url) && !file_exists($url)){
				$url = '../addons/group_buy/inc/wxapp/'.$str."/index.inc.php";
			}
			if(file_exists($url)){
				//引入
				require_once $url;
			} else {
				$this->result(3,'function is not found~~~',$url);
			}
		}
    }



    //获取二维码

    public function doPageqrcode()
    {
        global $_GPC, $_W;
        $openid = trim($_GPC['openid']);
        if (empty($openid)) {
            $this->result("1", "请传入openid");
        }
        $user = pdo_fetch("select * from " . tablename($this->member) . " where weid=" . $_GPC['i'] . " and m_openid ='" . $openid . "'");

        $id = intval($user['m_get_good_code']);

//@unlink('..'.$user['qr_code']);//二维码提货码有误 ，先暂时这样每次生成

        $time = time();

        $old = $user['qr_code'];

        if (empty($user['qr_code']) || !file_exists('..' . $user['qr_code']) || $user['m_time'] + 43200 < $time) {

            $num = $this->randStr(6, 'NUMBER');

            $url = $num . ',' . time();

            require_once IA_ROOT . '/framework/library/qrcode/phpqrcode.php';

            $savePath = "../addons/group_buy/public/images/" . $openid . "_" . $user['m_id'] . '_' . $time . '.jpg';

            $us = "/addons/group_buy/public/images/" . $openid . "_" . $user['m_id'] . '_' . $time . '.jpg';

            QRcode::png($url, $savePath, QR_ECLEVEL_H, 10, 0);

            $res = false;

            if (file_exists($savePath)) {

                $res = true;

            }

            if ($res === false) {

                $this->result("1", "生成二维码失败");

            }

            $nums = str_split($num);

            $result = pdo_update($this->member, array("qr_code" => $us, 'm_get_good_code' => $num, 'm_time' => $time), array("m_openid" => $openid, 'weid' => $this->weid));

            if (empty($result)) {

                $this->result("1", "存入二维码失败，请重试");

            } else {

                @unlink('..' . $user['qr_code']);

//                $this->result("0","查询二维码成功",['data'=>$this->http_type.$_SERVER['HTTP_HOST'].$us,'num'=>$nums,'sql'=>"select * from ".tablename($this->member)." where weid=".$_GPC['i']." and m_openid ='".$openid."'",'url'=>$url]);

                $this->result("0", "查询二维码成功", ['data' => 'https://' . $_SERVER['HTTP_HOST'] . $us, 'num' => $nums, 'sql' => "select * from " . tablename($this->member) . " where weid=" . $_GPC['i'] . " and m_openid ='" . $openid . "'", 'url' => $url]);

            }

        } else {

            $nums = str_split($user['m_get_good_code']);

//            $this->result("0","查询二维码成功",['data'=>$this->http_type.$_SERVER['HTTP_HOST'].$user['qr_code'],'num'=>$nums]);

            $this->result("0", "查询二维码成功", ['data' => 'https://' . $_SERVER['HTTP_HOST'] . $user['qr_code'], 'num' => $nums]);

        }

    }

    //递归商品分类
    public function getcategroychild($list){
        $child_list = [];
        foreach ($list as $k=>$v){
            $child = pdo_fetchall("select gc_id,gc_name from " . tablename($this->goods_cate) . " where weid=" . $this->weid . " and (`type`<>2 or `type` is null) and gc_is_del = 1 and gc_status=1 and gc_pid ={$v['gc_id']}");

            $child_list[] = $v;
            if(!empty($child)){
                $child = $this->getcategroychild($child);
                $child_list = array_merge($child_list,$child);
            }
        }
        return $child_list;
    }


    //获取分类

    public function doPagegetgoodscate(){
        /*ini_set('display_errors',1);
        error_reporting(E_ALL);*/
        global $_W, $_GPC;
        $pid = !empty($_GPC['pid'])?trim($_GPC['pid']):'';//当前点击的分类id
        $openid = trim($_GPC['openid']);
        $pageSize = !empty($_GPC['pageSize'])?trim($_GPC['pageSize']):10;
        $type = !empty($_GPC['type'])?trim($_GPC['type']):'';
		$cutting = $this->custting_order_time(3,$openid);
//        if(empty($openid)){
//            $this->result("1","未授权");
//        }
        $member = pdo_get($this->member, array('m_openid' => $openid),array('m_openid','m_is_head'));
        if (empty($member)) {
            $this->result("1", "获取用户信息失败");
        }
        //获取当前分类
        $p_date = pdo_get($this->goods_cate, array('weid' => $this->weid, 'gc_id' => $pid),array('gc_pid'));
        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;
        $pageIndex = $index;
        $pageSize = empty($pageSize) ? 10 : $pageSize;
        $contion = 'limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;
        //查询全部一级分类
        $all_one_cate = pdo_fetchall("select gc_id,gc_name from " . tablename($this->goods_cate) . " where weid=" . $this->weid . " and gc_is_del = 1 and gc_status=1 and gc_pid=0 and (`type`=1 or `type` is null) order by gc_order asc,gc_pid asc");
        if (empty($all_one_cate)) {
            $this->result("1", "暂无一级分类");
        }
        $cid = 0;
        foreach ($all_one_cate as $k => $v) {
          	// 2 == 2
            if ($pid == $v['gc_id'] || (!empty($p_date) && $v['gc_id'] == $p_date['gc_pid'])) {
                $all_one_cate[0]['select'] = false;
                $all_one_cate[$k]['select'] = true;
                $cid = $all_one_cate[$k]['gc_id'];
            } else {
                $all_one_cate[$k]['select'] = false;
            }
        }
        //查询全部二级分类
        $all_two_cate = pdo_fetchall("select gc_id,gc_name from " . tablename($this->goods_cate) . " where weid=" . $this->weid . " and gc_is_del = 1 and gc_status=1 and gc_pid=" . $cid . " and (`type`=1 or `type` is null) order by gc_order asc,gc_pid asc");
        $two_cid = 0;
        foreach ($all_two_cate as $k => $v) {
            if ($pid == $v['gc_id']) {
                $all_two_cate[0]['select'] = false;
                $all_two_cate[$k]['select'] = true;
                $two_cid = $all_two_cate[$k]['gc_id'];
                $two_select = $v;
            } else {
                $all_two_cate[$k]['select'] = false;
            }
        }
        //如果pid 不存在 给默认值第一个分类为
        if (empty($pid) or $pid == 0) {
            $all_one_cate[0]['select'] = true;
            $all_two_cate[0]['select'] = true;
        }
        if (!empty($p_date) && empty($two_select)) {
            $all_two_cate[0]['select'] = true;
        }
        //商品分类页面显示内容
        $goods_cate_show_type = pdo_get($this->config, array('key' => 'goods_cate_show_type', 'weid' => $this->weid));


        if (!isset($goods_cate_show_type['value']) || $goods_cate_show_type['value'] != 2) {
            $goods_cate_show_type = 1;
	            if (!empty($type) && $type == 2) {
	                //获取全部商品
	                if(!$cutting){
//	                	$goods = pdo_fetchall('select g.*,c.gc_name,c.gc_id,s.num as `sum`,s.sale_num as sum_sale  from ' . tablename($this->goods) . " as g left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id = g.g_id left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id  left join " . tablename($this->goods_stock) . " as s on s.goods_id = g.g_id  where g.weid=" . $this->weid . " and (g.`type`<>2 or g.`type` is null) and g_is_online = 1 and g_is_del = 1  and (c.`type`=1 or c.`type` is null) and c.gc_id>0 and c.gc_id is not null and c.gc_is_del=1 and c.gc_status =1 group by g.g_id order by g.g_order asc,s.num !=0 desc,g_is_top desc,`sum` desc,gc_id asc,g.g_is_online desc,g.g_id desc " . $contion);
                        //2020-05-22 周龙 调整商品排序
                        $goods = pdo_fetchall('select g.*,c.gc_name,c.gc_id,s.num as `sum`,s.sale_num as sum_sale  from ' . tablename($this->goods) . " as g left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id = g.g_id left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id  left join " . tablename($this->goods_stock) . " as s on s.goods_id = g.g_id  where g.weid=" . $this->weid . " and (g.`type`<>2 or g.`type` is null) and g_is_online = 1 and g_is_del = 1  and (c.`type`=1 or c.`type` is null) and c.gc_id>0 and c.gc_id is not null and c.gc_is_del=1 and c.gc_status =1 group by g.g_id order by g.g_is_top desc,g_is_del asc,g_order asc,g_is_online desc,g_id desc " . $contion);
	                	//order by g.g_is_top desc,g_is_del asc,g_order asc,g_is_online desc,g_id desc
					}
				} else {
	                $cate = "";
	                $next_cate = [];
	                $goods = [];
	                //    $limit = 10;
                    //2020-03-14 周龙 增加区分 当二级id不为空时才进行拼接否则会导致拼接上0 将所有商品查询出来
                    if(  !empty($two_cid) ){
                        $cids = $cid . ',' . $two_cid;
                    }else{
                        $cids = $cid;
                    }

	                if (!empty($two_select)) {
	                    $cids = $two_cid;
	                }

                    //2020-03-09 周龙 所有商品模式增加递归分类

                    $cagory_ids = '';
                    if(!empty($cids)){
                        /*echo "<pre/>";
                        var_dump($cids);
                        die;*/
	                    if(strpos($cids,',') !== false){
	                        $arr = pdo_fetchall("select gc_id,gc_name from " . tablename($this->goods_cate) . " where weid=" . $this->weid . " and (`type`<>2 or `type` is null) and gc_is_del = 1 and gc_status=1 and gc_pid in ({$cids})");
                        }else{
                            $arr = pdo_fetchall("select gc_id,gc_name from " . tablename($this->goods_cate) . " where weid=" . $this->weid . " and (`type`<>2 or `type` is null) and gc_is_del = 1 and gc_status=1 and gc_pid={$cids}");
                        }
                        /*echo "<pre/>";
	                    var_dump($arr);
	                    var_dump($cids);
	                    die;*/
                        $cagory_ids = $this->getcategroychild($arr);

	                    if(!empty($_GPC['debug'])) {
                            echo "<pre/>";
                            var_dump($arr);
                            var_dump($cagory_ids);
                        }
	                    $tmp = [];
	                    if(!empty($cagory_ids)){
	                        foreach ($cagory_ids as $k=>$v){
                                $tmp[] = $v['gc_id'];
                            }
                        }
                        /*echo "<pre/>";
                        var_dump($tmp);
                        die;*/
                        if(count($tmp)>0){
                            $cagory_ids = implode(",",$tmp);
                            $cagory_ids = ','.$cagory_ids;
                        }else{
                            $cagory_ids = '';
                        }
                    }

                    if(!empty($_GPC['debug'])){
                        echo "<pre/>";
                        echo 'select g.*,c.gc_name,c.gc_id,s.num as `sum`,s.sale_num as sum_sale  
from ' . tablename($this->goods) . " as g 
left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id = g.g_id 
left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id  
left join " . tablename($this->goods_stock) . " as s on s.goods_id = g.g_id  
where g.weid=" . $this->weid . " 
and (g.`type`<>2 or g.`type` is null) 
and g_is_online = 1 and g_is_del = 1 
and (gc_id in (" . trim($cids, ',').$cagory_ids . ") or gc_pid in (" . trim($cids, ',') . ")) 
and (c.`type`=1 or c.`type` is null) 
and c.gc_is_del=1 and c.gc_status =1 
group by g.g_id 
order by g.g_order asc,s.num !=0 desc,g_is_top desc,`sum` desc,gc_id asc,g.g_is_online desc,g.g_id desc " . $contion;
//                        die;
                    }

					if(!$cutting){
	                	/*$goods = pdo_fetchall('select g.*,c.gc_name,c.gc_id,s.num as `sum`,s.sale_num as sum_sale
from ' . tablename($this->goods) . " as g 
left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id = g.g_id 
left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id  
left join " . tablename($this->goods_stock) . " as s on s.goods_id = g.g_id  
where g.weid=" . $this->weid . " 
and (g.`type`<>2 or g.`type` is null) 
and g_is_online = 1 and g_is_del = 1 
and (gc_id in (" . trim($cids, ',').$cagory_ids . ") or gc_pid in (" . trim($cids, ',') . ")) 
and (c.`type`=1 or c.`type` is null) 
and c.gc_is_del=1 and c.gc_status =1 
group by g.g_id 
order by g.g_order asc,s.num !=0 desc,g_is_top desc,`sum` desc,gc_id asc,g.g_is_online desc,g.g_id desc " . $contion);*/
	                	//周龙 2020-05-22 调整排序方式
	                	$goods = pdo_fetchall('select g.*,c.gc_name,c.gc_id,s.num as `sum`,s.sale_num as sum_sale  
from ' . tablename($this->goods) . " as g 
left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id = g.g_id 
left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id  
left join " . tablename($this->goods_stock) . " as s on s.goods_id = g.g_id  
where g.weid=" . $this->weid . " 
and (g.`type`<>2 or g.`type` is null) 
and g_is_online = 1 and g_is_del = 1 
and (gc_id in (" . trim($cids, ',').$cagory_ids . ") or gc_pid in (" . trim($cids, ',') . ")) 
and (c.`type`=1 or c.`type` is null) 
and c.gc_is_del=1 and c.gc_status =1 
group by g.g_id 
order by g.g_is_top desc,g_is_del asc,g_order asc,g_is_online desc,g_id desc " . $contion);
					}
				}
        } else {
            $goods_cate_show_type = 2;
            $cid = $pid;
//	            if ($_GPC['t'] == 1) {
//	                var_dump($cid);
//	                exit;
//	            }
            $where = "";
            if (!empty($cid)) {
                //目前就二级分类，查下级就行
                $cate_id = pdo_fetchall("select gc_id,gc_name from " . tablename($this->goods_cate) . " where weid=" . $this->weid . " and (`type`<>2 or `type` is null) and gc_is_del = 1 and gc_status=1 and gc_pid =" . $cid);
                //2020-03-06 周龙 递归分类下所有商品
                if(!empty($cate_id)){
                    $cate_id = $this->getcategroychild($cate_id);
                }

                if(!empty($_GPC['debug'])){
                    echo "<pre/>";
                    echo "cate_id<br/>";
                    var_dump($cate_id);
//                    die;
                }


                if (empty($cate_id)) {
                    $where .= " and c.gc_id = " . $cid;
                } else {
                    $id_str = $cid;
                    foreach ($cate_id as $val) {
                        $id_str .= ',' . $val['gc_id'];
                    }
                    $where .= " and c.gc_id in (" . $id_str . ") ";
                }
            }
            if(!$cutting){
            	/*$sql = " select * from " . tablename($this->action_goods) . " as ag
            	join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  
            	join " . tablename($this->goods) . "  as g on g.g_id =ag.gcg_g_id 
            	left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id =g.g_id  
            	left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id  
            	join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id 
            	left join " . tablename($this->action_village) . " as av on av.gav_ac_id = at_id 
            	left join " . tablename($this->vg) . " as vg on vg.vg_id = av.gav_v_id 
            	where (at_is_limit=1 or (at_is_limit=-1 and vg.openid='" . $member['m_head_openid'] . "')) 
            	and at_is_del=1 
            	and  at_is_index_show=1 
            	and g_is_online=1 
            	and g_is_head_enjoy=-1 
            	and g_is_del = 1 
            	and at_end_time > " . time() . " 
            	and at_start_time < " . time() . " 
            	and (g.`type`<>2 or g.`type` is null) 
            	and ag.weid=" . $this->weid . $where . " 
            	and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL ) 
            	GROUP BY g.g_id order by g_order desc,gs.num !=0 desc,g_is_top desc,g_is_recommand desc,at_start_time desc " . $contion;*/
                //周龙 2020-05-22 修改排序方式与后台一致
            	$sql = " select * from " . tablename($this->action_goods) . " as ag  
            	join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  
            	join " . tablename($this->goods) . "  as g on g.g_id =ag.gcg_g_id 
            	left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id =g.g_id  
            	left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id  
            	join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id 
            	left join " . tablename($this->action_village) . " as av on av.gav_ac_id = at_id 
            	left join " . tablename($this->vg) . " as vg on vg.vg_id = av.gav_v_id 
            	where (at_is_limit=1 or (at_is_limit=-1 and vg.openid='" . $member['m_head_openid'] . "')) 
            	and at_is_del=1 
            	and  at_is_index_show=1 
            	and g_is_online=1 
            	and g_is_head_enjoy=-1 
            	and g_is_del = 1 
            	and at_end_time > " . time() . " 
            	and at_start_time < " . time() . " 
            	and (g.`type`<>2 or g.`type` is null) 
            	and ag.weid=" . $this->weid . $where . " 
            	and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL ) 
            	GROUP BY g.g_id order by g.g_is_top desc,g_is_del asc,g_order asc,g_is_online desc,g_id desc " . $contion;
	            $goods = pdo_fetchall($sql);
	            $goods_tmp = array();
	            foreach ($goods as $key => $val) {
	                //当前团长当前商品选择未开启，删除商品
	                $del_count = pdo_fetchcolumn("select count(*) from " . tablename($this->team_cancel_goods) . " as tcg where  tcg.openid='" . $member['m_head_openid'] . "' and tcg.tcg_at_g_id =" . $val['gcg_id']);
	                if (!empty($del_count) && $del_count >= 1) {
	                    continue;
	                }
	                $goods_tmp[] = $goods[$key];
	            }
	            $goods = $goods_tmp;
            }
        }
        //团长专享
        //是否开启分类团长专属
        $goods_info_open_enjoy =  pdo_get($this->config,array('key'=>'goods_info_open_enjoy','weid'=>$this->weid));

        if(!empty($goods_info_open_enjoy) && ($goods_info_open_enjoy['value']==1)){

            if($member['m_is_head']==2){
                $head_enjoy=[
                    "gc_id"=>"-2",
                    "gc_name"=>"团长专享",
                    "select"=>false
                ];

                if($pid==-2){
                    /*$sql = " select * from " .  tablename($this->goods) . "  as g  join " . tablename($this->goods_stock) . " as gs on gs.goods_id = g.g_id where g_is_online=1 and g_is_del = 1 and g_is_head_enjoy=1 and (g.`type`<>2 or g.`type` is null) and g.weid=" . $this->weid  . " and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL ) order by g_order desc,gs.num !=0 desc,g_is_top desc,g_is_recommand desc " . $contion;*/
                    //周龙 2020-05-22 排序规则调整与后台一致
                    $sql = " select * from " .  tablename($this->goods) . "  as g  join " . tablename($this->goods_stock) . " as gs on gs.goods_id = g.g_id where g_is_online=1 and g_is_del = 1 and g_is_head_enjoy=1 and (g.`type`<>2 or g.`type` is null) and g.weid=" . $this->weid  . " and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL ) GROUP BY g.g_id order by g.g_is_top desc,g_is_del asc,g_order asc,g_is_online desc,g_id descc " . $contion;

                    $goods = pdo_fetchall($sql);
                    $head_enjoy=[
                        "gc_id"=>"-2",
                        "gc_name"=>"团长专享",
                        "select"=>true
                    ];
                    $all_two_cate = [];
                }
                $all_one_cate[]=$head_enjoy;

            }
        }

        if (count($goods) > 0) {
            foreach ($goods as $k => $v) {
                $goods[$k]['g_icon'] = tomedia($v['g_icon']);
                $goods[$k]['g_video'] = tomedia($v['g_video']);
                $goods[$k]['g_video_open'] = empty($v['g_video']) ? 0 : 1;
                $goods[$k]['g_thumb'] = explode(',', $v['g_thumb']);
                //查询有无此商品的购物车
                $goods_cart = pdo_fetch("select c_count,c_id from " . tablename($this->cart) . " where openid='" . $openid . "' and c_is_del =1 and c_status =1 and c_g_id = " . $v['g_id']);
                if (empty($goods_cart)) {
                    $goods[$k]['isshowbtn'] = 1;
                    $goods[$k]['curGoodsNum'] = 0;
                    $goods[$k]['cart_id'] = 0;
                } else {
                    $goods[$k]['isshowbtn'] = 2;
                    $goods[$k]['curGoodsNum'] = $goods_cart['c_count'];
                    $goods[$k]['cart_id'] = $goods_cart['c_id'];
                }
                foreach ($goods[$k]['g_thumb'] as $key => $val) {
                    $goods[$k]['g_thumb'][$key] = tomedia($val);
                }
				if(empty($v['at_id'])){
					//取出活动id和结束时间
					$action = pdo_fetch("select at.at_id,at.at_end_time from ".tablename('gpb_action')." at join ".tablename('gpb_action_goods')." g on g.gcg_at_id = at.at_id where g.gcg_g_id = ".$v['g_id']." and g.weid = ".$this->weid." and at.at_start_time <= ".time()." and at.at_end_time >= ".time());
					if($action){
						$goods[$k]['at_id'] = $action['at_id'];
						$goods[$k]['at_end_time'] = $action['at_end_time'];
					}
				}
            }
        }
        //查询分类页是否开启搜索
        $goods_cate_open_search = pdo_get($this->config, array('key' => 'goods_cate_open_search', 'weid' => $this->weid),array('value'));
		$goods_cate_open_search['value'] =  $goods_cate_open_search['value'] ? $goods_cate_open_search['value'] : 1;
//        if(empty($goods)){
//            $this->result("1","暂无商品数据",array('one'=>$all_one_cate,'two'=>$all_two_cate,'goods'=>array(),'open_search'=>$goods_cate_open_search));
//        } else {
        //没商品也返回成功，至少把分类显示出来




        $this->result("0", "查询商品分类成功", array('one' => $all_one_cate, 'two' => $all_two_cate, 'goods' => $goods, 'open_search' => $goods_cate_open_search, 'goods_cate_show_type' => $goods_cate_show_type));
//        }
        exit;

    }



    //获取多规格商品的规格

    public function doPageGetSpecInfo()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        $id = trim($_GPC['id']);

        if (empty($id)) {

            $this->result("1", "读取规格失败");

        }

        //$goods = pdo_get($this->goods,array('g_id'=>$id,"weid"=>$this->weid));

        $goods = pdo_fetch("select * from" . tablename($this->goods) . " as g where g_id=" . $id . " and weid = " . $this->weid . " and (g.`type`<>2 or g.`type` is null)");

        if (empty($goods)) {

            $this->result("1", "读取商品失败");

        }

        $goods['g_icon'] = tomedia($goods['g_icon']);

		$spec = pdo_fetchall("select * from ".tablename($this->spec)." where weid = ".$this->weid." and g_id = ".$id." and status = 1 order by id desc ");

//      $spec = pdo_getall($this->spec, array('weid' => $this->weid, 'g_id' => $id, 'status' => 1));

        foreach ($spec as $k => $v) {

            $spec_item = pdo_getall($this->spec_item, array('weid' => $this->weid, 'gsi_specid' => $v['id'], 'gsi_is_del' => 1));

            $spec[$k]['item'] = $spec_item;

        }

        if (empty($spec)) {

            $this->result("1", "查询规格失败");

        } else {

            $this->result("0", "查询规格成功", array('spec' => $spec, 'goods' => $goods));

        }

    }



    ////获取不同规格的价格详情等等

    public function doPageGetSpecDeatail()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        $id_str = trim($_GPC['id_str'], ',');

        if (empty($id_str)) {

            $this->result("1", "未传入规格");

        }

        $id_arr = explode(',', $id_str);

        if (is_array($id_arr)) {

            rsort($id_arr);

            $id_str = implode(',', $id_arr);

        }

        $gid = trim($_GPC['gid']);

        if (empty($gid)) {

            $this->result("1", "未传入商品信息");

        }

        $info = pdo_get($this->goods_option, array('weid' => $this->weid, 'ggo_g_id' => $gid, 'ggo_specs' => $id_str, 'ggo_is_del' => 1));

		//判断该多规格商品是否存在会员价

		$member = pdo_get("gpb_member",array('m_openid'=>$openid));

		$member_card = pdo_get("gpb_member_card",array('id'=>$member['level']));

		if($member['level'] && $info){

			$infos = pdo_get("gpb_goods_discount_detailed",array('goods_id'=>$gid,'weid'=>$this->weid,'gos_id'=>$info['ggo_id'],'caid'=>$member['level']));

			if($infos['price']){

				$info['ggo_market_price'] = (number_format($infos['price']/100, 2, '.', ''));

			}else{

				$info['ggo_market_price'] = number_format($info['ggo_market_price']*($member_card['discount']/10), 2, '.', '');



			}



//			$info['ggo_market_price'] = (string)$info['ggo_market_price'];

		}

        if (empty($info)) {

            $this->result("1", "查询失败");

        } else {

            $this->result("0", "查询成功", $info);

        }

    }



    /*

     * 多规格添加购物车

     */

    public function doPageSpecAddCart()

    {

        global $_W, $_GPC;

        $num = trim($_GPC['num']);

        $openid = trim($_GPC['openid']);

        $gid = trim($_GPC['gid']);

        $at_id = trim($_GPC['at_id']);

        $ggoid = trim($_GPC['ggoid']);

        if (empty($num)) {

            $this->result("1", "请选择商品数量");

        }

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        if (empty($gid)) {

            $this->result("1", "请传入商品");

        }

        if (empty($ggoid)) {

            $this->result("1", "请选择规格");

        }

        $goods = pdo_fetch("select * from " . tablename($this->goods) . "as g where g_id = " . $gid . " and (g.`type`<>2 or g.`type` is null) and weid =" . $this->weid);

        if (!empty($goods['g_limit_num']) and $num > $goods['g_limit_num']) {

            $this->result("1", "添加失败，商品单次购买限制数量为" . $goods['g_limit_num']);

        }

        $stock = pdo_fetch("select * from " . tablename($this->goods_stock) . " where weid=" . $this->weid . " and goods_id=" . $gid);//原库存

        //规格库存

        $spec_stock = pdo_get($this->goods_option, array('weid' => $this->weid, 'ggo_id' => $ggoid, 'ggo_g_id' => $gid));



        if (($stock['num'] <= 0 || $spec_stock['ggo_stock'] <= 0) && $spec_stock['ggo_stock'] != -1) {

            $this->result("1", "商品已售罄.");

        }

        $count_sql = "select * from " . tablename($this->cart) . " where openid='" . $openid . "' and weid =" . $this->weid . " and c_g_id = " . $gid . " and c_status=1 and c_is_del = 1 and c_ggo_id = " . $ggoid;

        $info = pdo_fetchall($count_sql);

        if (count($info) > 0) {

            if (($info[0]['c_count'] + $num) <= $goods['g_limit_num'] && ($info[0]['c_count'] + $num) <= $spec_stock['ggo_stock'] && $spec_stock['ggo_stock'] != -1) {

                $data = [

                    'c_count ' => $info[0]['c_count'] + $num,

                    'weid' => $this->weid

                ];

                $res = pdo_update($this->cart, $data, array('openid' => $openid, 'c_g_id' => $gid, 'c_ggo_id' => $ggoid, 'c_status' => 1, 'c_is_del' => 1));

            } else {

                $res = 1;

            }



            $id = pdo_get($this->cart, array('openid' => $openid, 'c_g_id' => $gid, 'c_status' => 1, 'c_is_del' => 1, 'weid' => $this->weid, 'c_ggo_id' => $ggoid));

            $count_sql = "select sum(c_count) from " . tablename($this->cart) . " where openid = '" . $openid . "'  and c_status=1 and c_is_del = 1";

            $count = pdo_fetchcolumn($count_sql);



            if (!empty($res)) {

                $this->result("0", "新增购物车成功", array('count' => $count, 'id' => $id['c_id']));

            } else {

                $this->result("1", "参数错误", ['openid' => $openid, 'c_g_id' => $gid, 'c_status' => 1, 'c_is_del' => 1, 'res' => $res]);

            }

        } else {

//            if( is_array($num) and is_array($gid) ){

//                foreach ( $num as $k => $v ){

//                    $data = [

//                        'c_g_id' =>trim($gid[$k]),

//                        'c_count'=>trim($num[$k]),

//                        'c_at_id'=>trim($at_id[$k]),

//                        'openid'=>$openid,

//                        'c_add_time'=>time(),

//                        'weid'=>$this->weid

//                    ];

//                    $res = pdo_insert($this->cart,$data);

//                }

//

//            }else

            if (!empty($num) and !empty($gid) and !empty($ggoid)) {

                $data = [

                    'c_g_id' => trim($gid),

                    'c_count' => trim($num),

                    'c_at_id' => trim($at_id),

                    'openid' => $openid,

                    'c_add_time' => time(),

                    'weid' => $this->weid,

                    'c_ggo_id' => $ggoid

                ];

                $res = pdo_insert($this->cart, $data);

                $id = pdo_insertid();

            } else {

                $this->result("1", "参数错误");

            }

            if (!empty($res)) {

                $count_sql = "select sum(c_count) from " . tablename($this->cart) . " where openid = '" . $openid . "' and weid =" . $this->weid . " and c_status=1 and c_is_del = 1";

				$sql = "select sum(c.c_count) from ".tablename($this->cart)." as c left join ".tablename($this->goods)." as g on c.c_g_id=g.g_id where c.weid='{$this->weid}' and c.openid='{$openid}' and c.c_status=1 and c.c_is_del=1 and g.g_is_del=1 and g.g_is_online=1";

                $count = pdo_fetchcolumn($sql);

//					if($count > 1){

//						echo '<pre>';

//						exit;

//					}

                $this->result("0", "添加购物车成功", array('count' => $count, 'id' => $id));

            }

        }

    }

    /**
     * 活动商品下架触发
     */
    public function doPageLowdown(){
        global $_W,$_GPC;
        //查询已结束活动,并获取活动id合集
        $time = time();
        $sql = "select at_id from ".tablename($this->action)." where `weid`='{$this->weid}' and `at_end_time`< {$time}";
        $list = pdo_fetchall($sql);
        $action_ids = array();
        foreach ($list as $k=>$v){
            $action_ids[] = $v['at_id'];
        }
        $action_ids = trim(implode(",",$action_ids),',');
		if($action_ids){
			$action_goods_sql = "select gcg_g_id from ".tablename($this->action_goods)." where `gcg_at_id` in ({$action_ids}) and `weid`='{$this->weid}'";
       		$act_goods = pdo_fetchall($action_goods_sql);
		}
        $goods_ids = array();
		if($act_goods){
	        foreach ($act_goods as $k=>$v){
	            $goods_ids[] = $v['gcg_g_id'];
	        }
		}
		if(empty($goods_ids)){
			return false;
		}
        //查询正在活动中商品
        $act_sql = "select at_id from ".tablename($this->action)." where `weid`='{$this->weid}' and `at_end_time`> {$time} and `at_is_del`=1";
        $act_list = pdo_fetch($act_sql);
        $act_goods_list = pdo_fetchall("select gcg_g_id from ".tablename($this->action_goods)." where `gcg_at_id`={$act_list['at_id']}");
        $act_gids = array();
        foreach ($act_goods_list as $k=>$v){
            $act_gids[] = $v['gcg_g_id'];
        }
        $act_gids = implode(",",$act_gids);
        $goods_ids = implode(",",$goods_ids);
        $sql = "update ".tablename($this->goods)." set `g_is_online`='-1' where `g_id` in ({$goods_ids}) and `g_id` not in ({$act_gids})  and `g_is_online`=1 and `g_is_del`=1 ";
        $res = pdo_run($sql);
        if($list){
        	$where = "";
        	foreach($list as $k=>$v){
				if($k == (count($list)-1)){
    	    		$where .= " gcg_at_id = ".$v['at_id'];
				}else{
    	    		$where .= " gcg_at_id = ".$v['at_id']." or";
				}
        	}
			pdo_query("DELETE FROM ".tablename($this->action_goods)." WHERE ".$where);
        }
		if($res){
			return TRUE;
		}else{
			return false;
		}
    }

    //DIY首页数据
//  public function doPageIndexData()
//  {
//
//  }
    /**
	 * 首页的流加载数据
	 */
//	public function doPageIndexdata_flow(){
//
//	}
	/**
	 * 首页的分类商品
	 */
	public function doPageCate_Goods(){
		global $_W, $_GPC;
		$openid = $_GPC['openid'];
		$close = $_GPC['choose_commodity'];//是否是手动选择 1是
		$data = $_GPC['data'];//参数id   用，进行分割链接
//		if(!$data){
//			$this->result(1,'参数错误');
//		}
		$data = trim($data,',');
		$cate_id = $_GPC['source'];//分类id
		$num = $_GPC['num'];//自动选择的时候的数量

//		$openid = 'oLf4B0RKRvsOPND25hNm4cCiz_Lg';
//		$close = 1;
//		$data = '120,122,127,171,125,128';
//		$cate_id = '';
//		$num = 0;
		$time = time();
		$cutting = $this->custting_order_time(3,$openid);
		if(!$cutting){
			if($close == 1){
				//手动 选择
				if($data){
					$goods = [];
					$str = $data;
					$str = trim($str,',');
					//获取商品信息
//					$goods_list = pdo_fetchall("select g.g_id,g.g_name,g.g_icon,g.g_old_price,g.g_price,g.g_video as g_video_open,g.g_limit_num,g.g_has_option,g.g_brief,g.g_arrival_time as arrival_time,g.g_arrival_time_text as at_arrival_time_text,g.g_virtual_people as sale_num,s.num,s.sale_num as g_sale_num from ".tablename('gpb_goods')." g join ".tablename('gpb_goods_to_category')." c on g.g_id = c.goods_id join ".tablename('gpb_goods_stock')." s on g.g_id = s.goods_id where g.weid = ".$this->weid." and g.g_is_online = 1 and g.g_is_head_enjoy = -1 and g.g_is_del = 1 and g.g_id in (".$str.")");
                    //2020-05-25 周龙 修改排序
					$goods_list = pdo_fetchall("select g.g_id,g.g_name,g.g_icon,g.g_old_price,g.g_price,g.g_video as g_video_open,g.g_limit_num,g.g_has_option,g.g_brief,g.g_arrival_time as arrival_time,g.g_arrival_time_text as at_arrival_time_text,g.g_virtual_people as sale_num,s.num,s.sale_num as g_sale_num from ".tablename('gpb_goods')." g join ".tablename('gpb_goods_to_category')." c on g.g_id = c.goods_id join ".tablename('gpb_goods_stock')." s on g.g_id = s.goods_id where g.weid = ".$this->weid." and g.g_is_online = 1 and g.g_is_head_enjoy = -1 and g.g_is_del = 1 and g.g_id in (".$str.") order by g.g_is_top desc,g.g_is_del asc,g.g_order asc,g.g_is_online desc,g.g_id desc");
					//获取商品是否在活动内
					$sql = "SELECT ag.gcg_g_id,a.at_id,a.at_end_time FROM ( SELECT ag.gcg_at_id,ag.gcg_g_id FROM ".tablename('gpb_action_goods')." AS ag WHERE ag.gcg_g_id IN (".$str.") AND ag.weid = ".$_W['uniacid'].") AS ag JOIN ".tablename('gpb_action')." a ON ag.gcg_at_id = a.at_id WHERE a.at_start_time <= ".$time." AND a.at_end_time >= ".$time;
//					$sql = "select ag.gcg_g_id,a.at_id,a.at_end_time from ims_gpb_action_goods ag left join ims_gpb_action a on ag.gcg_at_id = a.at_id where a.at_start_time <= ".$time." and a.at_end_time >= ".$time." and ag.gcg_g_id in (".$str.") and ag.weid = ".$_W['uniacid'];
					$action_arr = pdo_fetchall($sql);
					//获取商品是否在购物车里面
					$cart_num = pdo_fetchall("select c_id,c_count from ".tablename('gpb_cart')." where c_is_del = 1 and c_status = 1 and openid = '".$openid."' and c_g_id in (".$str.")");
					$quick_data = [];
					$quick_arr = [];
					foreach($goods_list as $kks=>$vvs){
						$quick_data[$vvs['g_id']] = $vvs;
					}
					foreach($action_arr as $kks=>$vvs){
						$quick_arr[$vvs['gcg_g_id']] = $vvs;
					}
					$data = explode(',',trim($data,','));
					foreach($data as $lk=>$ls){
						$goodss = $quick_data[$ls];
						$action_arr = $quick_arr[$ls];
						$goods[$lk] = $goodss;
						$goods[$lk]['g_icon'] = tomedia($goodss['g_icon']);
						if($goodss['g_video_open']){
							$goods[$lk]['g_video'] = tomedia($goodss['g_video_open']);
						}
						$goods[$lk]['at_id'] = $action_arr['at_id'];
						$goods[$lk]['at_end_time'] = $action_arr['at_end_time'];
						$goods[$lk]['g_video_open'] = $goodss['g_video_open'] ? 1 : 0;
						$goods[$lk]['priceArry'] = explode('.',$goodss['g_price']);
						if($openid){
							$cart = pdo_fetch("select c_id,c_count from ".tablename('gpb_cart')." where c_is_del = 1 and c_status = 1 and openid = '".$openid."' and c_g_id = ".$ls);
							if($cart){
								$goods[$lk]['cart_id'] = $cart['c_id'];
								$goods[$lk]['isshowbtn'] = 2;
								$goods[$lk]['curGoodsNum'] = $cart['c_count'];
							} else {
								$goods[$lk]['cart_id'] = 0;
								$goods[$lk]['isshowbtn'] = 1;
								$goods[$lk]['curGoodsNum'] = 0;
							}
						}else{
							$goods[$lk]['cart_id'] = 0;
							$goods[$lk]['isshowbtn'] = 1;
							$goods[$lk]['curGoodsNum'] = 0;
						}
					}
				}
			} else {
				if($cate_id == 0 || $num <= 0){
					$this->result(1,'分类id错误');
				}
				//商品信息
//				$goods = pdo_fetchall("select g.g_id,g.g_name,g.g_icon,g.g_old_price,g.g_price,g.g_video as g_video_open,g.g_limit_num,g.g_has_option,g.g_brief,g.g_arrival_time as arrival_time,g.g_arrival_time_text as at_arrival_time_text,g.g_virtual_people as sale_num,s.num,s.sale_num as g_sale_num from ".tablename('gpb_goods')." g join ".tablename('gpb_goods_to_category')." c on g.g_id = c.goods_id join ".tablename('gpb_goods_stock')." s on g.g_id = s.goods_id where c.cate_id = ".$cate_id." and g.weid = ".$this->weid." and g.g_is_online = 1  and g.g_is_head_enjoy = -1 and g.g_is_del = 1 order by g.g_order desc limit 0,".$num);
                //2020-05-25 周龙 修改排序
				$goods = pdo_fetchall("select g.g_id,g.g_name,g.g_icon,g.g_old_price,g.g_price,g.g_video as g_video_open,g.g_limit_num,g.g_has_option,g.g_brief,g.g_arrival_time as arrival_time,g.g_arrival_time_text as at_arrival_time_text,g.g_virtual_people as sale_num,s.num,s.sale_num as g_sale_num from ".tablename('gpb_goods')." g join ".tablename('gpb_goods_to_category')." c on g.g_id = c.goods_id join ".tablename('gpb_goods_stock')." s on g.g_id = s.goods_id where c.cate_id = ".$cate_id." and g.weid = ".$this->weid." and g.g_is_online = 1  and g.g_is_head_enjoy = -1 and g.g_is_del = 1 order by g.g_is_top desc,g.g_is_del asc,g.g_order asc,g.g_is_online desc,g.g_id desc limit 0,".$num);
				if($goods){
					$str = "";
					foreach($goods as $sk=>$sv){
						$str .= $sv['g_id'].",";
					}
					$str = trim($str,',');
					$action = pdo_fetchall("select ag.gcg_g_id,a.at_id,at_end_time,a.at_arrival_time,a.at_arrival_time_text from ".tablename("gpb_action")." a join ".tablename('gpb_action_goods')." ag on a.at_id = ag.gcg_at_id where ag.gcg_g_id in (".$str.") and a.weid = ".$this->weid." and a.at_start_time <= ".$time." and a.at_end_time >= ".$time." and at_is_del = 1");
					if($action){
						$action_data = [];
						foreach($action as $lk=>$lv){
							$action_data[$lv['gcg_g_id']] = $lv;
						}
					}
					$cart = pdo_fetchall("select c_g_id,c_id,c_count from ".tablename('gpb_cart')." where c_is_del = 1 and c_status = 1 and openid = '".$openid."' and c_g_id in (".$str.")");
					if($cart){
						$cart_data = [];
						foreach($cart as $lk=>$lv){
							$cart_data[$lv['c_g_id']] = $lv;
						}
					}

					foreach($goods as $sk=>$sv){
						$goods[$sk]['g_icon'] = tomedia($sv['g_icon']);
						if($sv['g_video_open']){
							$goods[$sk]['g_video'] = tomedia($sv['g_video_open']);
						}
						$goods[$sk]['g_video_open'] = $sv['g_video_open'] ? 1 : 0;
						$goods[$sk]['priceArry'] = explode('.',$sv['g_price']);
						//获取该商品是否参加了当前的活动
						if($action_data[$sv['g_id']]){
							$goods[$sk]['at_id'] = $action_data[$sv['g_id']]['at_id'];
							$goods[$sk]['at_end_time'] = $action_data[$sv['g_id']]['at_end_time'];
							$goods[$sk]['at_arrival_time_text'] = $action_data[$sv['g_id']]['at_arrival_time_text'];
							$goods[$sk]['arrival_time'] = $action_data[$sv['g_id']]['arrival_time'];
						}else{
							$goods[$sk]['at_id'] = 0;
						}
						//判断购物车 里面是否有这个商品的信息
						if($openid){
							if($cart_data[$sv['g_id']]){
								$goods[$sk]['cart_id'] = $cart_data[$sv['g_id']]['c_id'];
								$goods[$sk]['isshowbtn'] = 2;
								$goods[$sk]['curGoodsNum'] = $cart_data[$sv['g_id']]['c_count'];
							} else {
								$goods[$sk]['cart_id'] = 0;
								$goods[$sk]['isshowbtn'] = 1;
								$goods[$sk]['curGoodsNum'] = 0;
							}
						}else{
							$goods[$sk]['cart_id'] = 0;
							$goods[$sk]['isshowbtn'] = 1;
							$goods[$sk]['curGoodsNum'] = 0;
						}
					}
				}
			}
		}
		$this->result(0,'',$goods);
	}
	/**
	 * 满减商品
	 */
	public function doPageFull_Reduce(){
		global $_W, $_GPC;
		//读取是否开启满减
		$config_array = [];
		$config_arr = pdo_fetchall("SELECT * FROM ".tablename('gpb_config')." WHERE (`key` = 'last_head_notice' OR `key` = 'index_share_img' OR `key` = 'index_share_img_type' OR `key` = 'index_share_title' OR `key` = 'index_share_title_type' OR `key` = 'open_full_reduction' OR `key` = 'full_reduction_limit_price' OR `key` = 'full_reduction_price' OR `key` = 'new_member_ticket_open' OR `key` = 'new_member_ticket_id' OR `key` = 'new_member_ticket_img')AND weid = :id",array(':id'=>$this->weid));
		if($config_arr){
			foreach($config_arr as $c=>$f){
				$config_array[$f['key']] = $f['value'];
			}
		}
        $full_reduce = array();
//      $open_full_reduction = pdo_get($this->config, array('key' => 'open_full_reduction', 'weid' => $this->weid));
//      $full_reduction_limit_price = pdo_get($this->config, array('key' => 'full_reduction_limit_price', 'weid' => $this->weid));
//      $full_reduction_price = pdo_get($this->config, array('key' => 'full_reduction_price', 'weid' => $this->weid));
        $full_reduction_goods = array();
        $is_open_full_reduction = 0;
        $full_reduction_goods_tmp = array();
        if (!empty($config_array['open_full_reduction'])) {
            $is_open_full_reduction = $config_array['open_full_reduction'];
            if ($is_open_full_reduction == 1) {
                //开启读取商品
//                $sql_full_reduction = "select * from " . tablename($this->action_goods) . " as ag  join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  join " . tablename($this->goods) . "  as g on g.g_id =ag.gcg_g_id left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id =g.g_id  left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id  join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id left join " . tablename($this->action_village) . " as av on av.gav_ac_id = at_id left join " . tablename($this->vg) . " as vg on vg.vg_id = av.gav_v_id where (at_is_limit=1 or (at_is_limit=-1 and vg.openid='" . $member['m_head_openid'] . "')) and at_is_del=1 and  at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time > " . time() . " and at_start_time < " . time() . " and (g.`type`<>2 or g.`type` is null) and g.g_is_full_reduce =1 and ag.weid=" . $this->weid . $where . " and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL ) GROUP BY g.g_id order by g_is_recommand desc,g_order desc,at_start_time desc " . $contion;
                //2020-05-25 周龙 修改排序
                $sql_full_reduction = "select * from " . tablename($this->action_goods) . " as ag  join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  join " . tablename($this->goods) . "  as g on g.g_id =ag.gcg_g_id left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id =g.g_id  left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id  join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id left join " . tablename($this->action_village) . " as av on av.gav_ac_id = at_id left join " . tablename($this->vg) . " as vg on vg.vg_id = av.gav_v_id where (at_is_limit=1 or (at_is_limit=-1 and vg.openid='" . $member['m_head_openid'] . "')) and at_is_del=1 and  at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time > " . time() . " and at_start_time < " . time() . " and (g.`type`<>2 or g.`type` is null) and g.g_is_full_reduce =1 and ag.weid=" . $this->weid . $where . " and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL ) GROUP BY g.g_id order by g.g_is_top desc,g.g_is_del asc,g.g_order asc,g.g_is_online desc,g.g_id desc " . $contion;
                $full_reduction_goods = pdo_fetchall($sql_full_reduction);
                if (is_array($full_reduction_goods)) {
                    $gid_str = '';
                    foreach ($full_reduction_goods as $kk => $vv) {
                        $full_reduction_goods[$kk]['g_icon'] = tomedia($vv['g_icon']);
                        $full_reduction_goods[$kk]['g_video'] = tomedia($vv['g_video']);
                        $full_reduction_goods[$kk]['g_video_open'] = empty($vv['g_video']) ? 0 : 1;
                        $full_reduction_goods[$kk]['priceArry'] = explode('.', $vv['g_price']);
                        //当前团长当前商品选择未开启，删除商品
                        $del_count = pdo_fetchcolumn("select count(*) from " . tablename($this->team_cancel_goods) . " as tcg where  tcg.openid='" . $member['m_head_openid'] . "' and tcg.tcg_at_g_id =" . $vv['gcg_id']);
                        if (!empty($del_count) && $del_count >= 1) {
//                            unset($full_reduction_goods[$kk]);
                            continue;
                        }
                        $gid_str .= ',' . $vv['g_id'];
                        if (empty($full_reduction_goods[$kk]['at_arrival_time']) && $full_reduction_goods[$kk]['at_arrival_time'] != 0) {
                            $full_reduction_goods[$kk]["arrival_time"] = date("m月d日", (time() + ($full_reduction_goods[$kk]["at_arrival_time"] * 24 * 60 * 60)));
                        } else {
                            $full_reduction_goods[$kk]["arrival_time"] = date("m月d日", (time() + ($full_reduction_goods[$kk]["at_arrival_time"] * 24 * 60 * 60)));
                        }
                        //查询有无此商品的购物车
                        $goods_cart = pdo_fetch("select c_count,c_id from " . tablename($this->cart) . " where openid='" . $openid . "' and c_is_del =1 and c_status =1 and c_g_id = " . $vv['g_id']);
                        if (empty($goods_cart)) {
                            $full_reduction_goods[$kk]['isshowbtn'] = 1;
                            $full_reduction_goods[$kk]['curGoodsNum'] = 0;
                            $full_reduction_goods[$kk]['cart_id'] = 0;
                        } else {
                            $full_reduction_goods[$kk]['isshowbtn'] = 2;
                            $full_reduction_goods[$kk]['curGoodsNum'] = $goods_cart['c_count'];
                            $full_reduction_goods[$kk]['cart_id'] = $goods_cart['c_id'];
                        }
                        $full_reduction_goods_tmp[] = $full_reduction_goods[$kk];
                    }
                }
            }
        }
        $full_reduce = array(
            'is_open_full_reduction' => $is_open_full_reduction,
            'full_reduction_goods' => $full_reduction_goods_tmp,
            'full_reduction_limit_price' => 0,
            'full_reduction_price' => 0,
        );
        if (!empty($config_array['full_reduction_limit_price'])) {
            $full_reduce['full_reduction_limit_price'] = $config_array['full_reduction_limit_price'];
        }
        if (!empty($config_array['full_reduction_price'])) {
            $full_reduce['full_reduction_price'] = $config_array['full_reduction_price'];
        }
		$this->result(0,'',$full_reduce);
	}
	/**

	 * 根据图片地址进行删除

	 */

	public function doPageImages_mikel(){
		global $_W, $_GPC;
		$openid = $_GPC['openid'];
		if(empty($openid)){
			$this->result('1', '非法进入');
		}
		$url = $_GPC['url'];
		if(empty($url)){
			$this->result('1', '非法进入');
		}
		$u = "../addons/group_buy/public/images/".$url;
		if(!file_exists($u)){
			$this->result('1', '文件不存在'.$u);
		}
		unlink($u);
		$this->result('0', '删除成功');
	}
    //二维数组去掉重复值
    function array_unique_fb($array2D)
    {
        foreach ($array2D as $v) {
            $v = join(",", $v);  //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[] = $v;
        }
        $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v) {
            $temp[$k] = explode(",", $v);   //再将拆开的数组重新组装
        }
        return $temp;
    }
    //检查是否已有记录的用户
    function doPageCheckUser()
    {
        global $_W, $_GPC;
        $openid = trim($_GPC['openid']);
        if (empty($openid)) {
            $this->result(1, "未授权");
        }
        $user = pdo_get($this->member, array("weid" => $this->weid, "m_openid" => $openid));

        if (empty($user)) {

            if($this->check_base64_out_json( $user['m_nickname'] )){

                $user['m_nickname'] = base64_decode( $user['m_nickname'] );

            }

            $this->result(0, "不存在", 0);

        } elseif (empty($user['m_nickname']) && empty($user['m_photo'])) {

            $this->result(0, "不存在", 0);

        } else {

            $this->result(0, "已存在", 1);

        }

    }



    /**

     *获取供应商申请配置数据

     */

    function doPageGetApplySupplierSet()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result(1, "未授权");

        }

        $info = pdo_getall($this->config, array('status' => 1, 'type' => 9, 'weid' => $this->weid), array(), "key");

        if (empty($info)) {

            $this->result(1, "未配置");

        } else {

            $this->result(0, "读取配置成功", $info);

        }

    }



    /**

     *获取团长申请配置数据

     */

    function doPageGetApplyHeadSet()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result(1, "未授权");

        }

        $member = pdo_get('gpb_member', array('m_openid' => $openid));

        if (empty($member)) {

            $this->result(1, "非法用户");

        }

        if($this->check_base64_out_json( $member['m_nickname'] )){

            $member['m_nickname'] = base64_decode( $member['m_nickname'] );

        }

        $info = pdo_getall($this->config, array('status' => 1, 'type' => 3, 'weid' => $this->weid), array(), "key");

        if (!empty($info)) {

            foreach ($info as $k => $v) {

                if (isset($v['key']) && ($v['key'] == 'apply_head_img' || $v['key'] == 'group_info_bg_img')) {

                    $info[$k]['value'] = tomedia($info[$k]['value']);

                }

            }

        }



        //判断该用户之前是否有绑定过

        $res = pdo_get('gpb_head_commond_log', array('uid' => $member['m_id']));

        if (empty($res)) {

            $info['show_recommed_code'] = 1;

        } else {

            $info['show_recommed_code'] = 0;

        }

        if (empty($info)) {

            $this->result(1, "未配置");

        } else {

            $this->result(0, "读取配置成功", $info);

        }

    }



    /*

     * 获取版权设置

     *  2019-6-22新增获取个人中心DIY数据

     */

    function doPageGetCopyrightSet()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result(1, "未授权");

        }

        $copyright_open = pdo_get($this->config, array('key' => 'copyright_open', 'weid' => $this->weid));

        $copyright_style = pdo_get($this->config, array('key' => 'copyright_style', 'weid' => $this->weid));

        $copyright_text = pdo_get($this->config, array('key' => 'copyright_text', 'weid' => $this->weid));

        $copyright_icon = pdo_get($this->config, array('key' => 'copyright_icon', 'weid' => $this->weid));

        $version_number_open = pdo_get($this->config, array('key' => 'version_number_open', 'weid' => $this->weid));

        if (!empty($copyright_icon)) {

            $copyright_icon['value'] = tomedia($copyright_icon['value']);

        }

        //读取diy的数据

        $old_member_diy =  pdo_get('gpb_config',array('key'=>'member_diys_data_set','weid'=>$this->weid,'type'=>25));

        if(empty($old_member_diy)){

            //获取系统自带

            $old_member_diy =  pdo_get('gpb_config',array('key'=>'member_diys_data_set_system','type'=>25));

        }

        $page = (isset($old_member_diy['value']) && !empty($old_member_diy['value']) )?unserialize($old_member_diy['value']):'';
        $member = pdo_get("gpb_member",array('m_openid'=>$_GPC['openid']));
        //是否开启分类团长专属
        $goods_info_open_enjoy =  pdo_get($this->config,array('key'=>'goods_info_open_enjoy','weid'=>$this->weid));
        if(empty($goods_info_open_enjoy) || ($goods_info_open_enjoy['value']==2)){
            //没有开启
            if(!empty($page)){
                //不是团长
                foreach ($page['data'][2]['params']['data'] as $k=>$val){


                    if($val['url']=="/pages/goods/activeGoods?type=head_enjoy"){

                        unset($page['data'][2]['params']['data'][$k]);

                    }
                }

            }
        }else{
            if(!empty($page) && ($member['m_is_head'] !=2)){
                //不是团长
                foreach ($page['data'][2]['params']['data'] as $k=>$val){

                    if($val['url']=="/pages/goods/activeGoods?type=head_enjoy"){

                        unset($page['data'][2]['params']['data'][$k]);

                    }
                }

            }
        }


        $data = array(

            'copyright_open' => empty($copyright_open) ? 'no' : $copyright_open,

            'copyright_style' => empty($copyright_style) ? 'no' : $copyright_style,

            'copyright_text' => empty($copyright_text) ? 'no' : $copyright_text,

            'copyright_icon' => empty($copyright_icon) ? 'no' : $copyright_icon,

            'version_number_open' => !isset($version_number_open['value']) ? '1' : $version_number_open['value'],

            'diy_page'=>$page

        );

        $this->result(1, '读取版权设置', $data);

    }



    /*
     * 团长编辑自己的资料设置是否送货
     */
//  function doPageSetHeadInfo(){}
    //获取团长管理端的商品数据
//  function doPageGetTeamGoods(){}
    //团长开启活动商品
    function doPageTeamOpenGoods(){
        global $_W, $_GPC;
        $openid = trim($_GPC['openid']);
        if (empty($openid)) {
            $this->result(1, "未授权");
        }
        $ids = trim($_GPC['ids'], ',');
        if (empty($ids)) {
            $this->result(1, "未选择商品");
        }
        $ids_arr = explode(',', $ids);
        pdo_begin();
        foreach ($ids_arr as $v) {
            $old = pdo_get($this->team_cancel_goods, array('openid' => $openid, 'tcg_at_g_id' => $v));
            if (!empty($old)) {
                $res = pdo_delete($this->team_cancel_goods, array('tcg_id' => $old['tcg_id']));
                if (empty($res)) {
                    pdo_rollback();
                    $this->result(1, "开启失败");
                }
            }
        }
        pdo_commit();
        $this->result(0, "开启成功");
    }
    //团长关闭活动商品
    function doPageTeamCLoseGoods(){

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result(1, "未授权");

        }

        $ids = trim($_GPC['ids'], ',');

        if (empty($ids)) {

            $this->result(1, "未选择商品");

        }

        $ids_arr = explode(',', $ids);

        pdo_begin();

        foreach ($ids_arr as $v) {

            $old = pdo_get($this->team_cancel_goods, array('openid' => $openid, 'tcg_at_g_id' => $v));

            if (empty($old)) {

                $data = array(

                    'openid' => $openid,

                    'tcg_at_g_id' => $v

                );

                $res = pdo_insert($this->team_cancel_goods, $data);

                if (empty($res)) {

                    pdo_rollback();

                    $this->result(1, "关闭失败");

                }

            }

        }

        pdo_commit();

        $this->result(0, "关闭成功");

    }
    //通知团长接单页面
//  function doPageGetOrderNotice(){}
    //获取全部历史记录的团长信息
    public function doPageGetAllHeadHistory(){
        global $_W, $_GPC;
        $openid = trim($_GPC['openid']);
        if (empty($openid)) {
            $this->result(1, "未授权");
        }
        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;
        $pageIndex = $index;
        $pageSize = 10;
        $contion = ' limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;
        //读取当前团长
        $member = pdo_get($this->member, array('m_openid' => $openid));
        $lat = $member['m_last_latitude'];
        $lng = $member['m_last_longitude'];
        $head_now = pdo_get($this->member, array('m_openid' => $member['m_head_openid']));
        $where = "";
        if (!empty($head_now)) {
            $where .= " and m.m_id <> '" . $head_now['m_id'] . "' ";
			if($this->check_base64_out_json( $head_now['m_nickname'] )){
	            $head_now['m_nickname'] = base64_decode( $head_now['m_nickname'] );
	        }
        }
        //查询历史社区
        $head_history = pdo_fetchall("select * from " . tablename($this->head_history) . " as hh left join " . tablename($this->member) . " as m on m.m_openid=hh.hh_head_openid left join " . tablename($this->vg) . " as vg on vg.openid =hh.hh_head_openid where hh.openid = '" . $openid . "' and hh.weid=" . $this->weid . $where . " group by m.m_openid order by hh.hh_last_time desc " . $contion);
        //现在按小区定位算
        foreach ($head_history as $k => $v) {
            $m = $this->getDistance($lat, $lng, $v['vg_latitude'], $v['vg_longitude']);
            $m = sprintf("%.2f", $m / 1000);
            $head_history[$k]['m'] = $m;
            if($this->check_base64_out_json( $v['m_nickname'] )){
                $head_history[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );
            }
        }
        $this->result(0, '读取成功', array('data' => $head_history, 'now' => $head_now, 'page' => $index));
    }
    //获取用户默认的收货地址
    function doPageGetUserDeafaultAddress()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        $cid = trim($_GPC['cid'], ',');

        if (empty($openid)) {

            $this->result(0, '未授权', array("openid" => $openid));

        }

        $info = array();

        $info = pdo_fetch("select * from " . tablename($this->address) . " where weid=" . $this->weid . " and openid='" . $openid . "' and ra_is_del=-1 and ra_is_default=1 order by ra_id desc;");

        if (!empty($info['ra_province'])) {

            $province = pdo_get("gpb_area", array('ad_code' => $info['ra_province']));

        } else {

            $province = '';

        }

        if (!empty($info['ra_city'])) {

            $city = pdo_get("gpb_area", array('ad_code' => $info['ra_city']));

        } else {

            $city = '';

        }

        if (!empty($info['ra_area'])) {

            $area = pdo_get("gpb_area", array('ad_code' => $info['ra_area']));

        } else {

            $area = '';

        }

        $info['province'] = $province;

        $info['city'] = $city;

        $info['area'] = $area;

		if($this->check_base64_out_json( $info['ra_name'] )){

            $info['ra_name'] = base64_decode( $info['ra_name'] );

        }



        $this->result(0, '成功', array("data" => $info));



    }



    //获取是否开启快递配置

    public function doPageGetOpenShipSet()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result(0, '未授权', array("openid" => $openid));

        }

        $is_open_express = pdo_get($this->config, array('key' => 'is_open_express', 'weid' => $this->weid));

        $val = 2;

        if (!empty($is_open_express) && isset($is_open_express['value']) && !empty($is_open_express['value'])) {

            $val = $is_open_express['value'];

        }

		$mention = pdo_get($this->config,array('key'=>'mention_id','weid'=> $this->weid));

		$mentions = 2;

        if (!empty($mention) && isset($mention['value']) && !empty($mention['value'])) {

            $mentions = $mention['value'];

        }

        $this->result(0, '获取成功', array("data" => $val,'ment'=>$mentions));

    }



    //计算获取运费

    public function doPageGetSendPrice()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        $cid = trim($_GPC['cid'], ',');

        $ad_code = trim($_GPC['ad_code'], ',');

        $gid = trim($_GPC['gid'], ',');

        $ggo_id = trim($_GPC['ggo_id'], ',');

        $g_num = trim($_GPC['g_num'], ',');

        if (empty($openid)) {

            $this->result(0, '未授权', array("openid" => $openid));

        }

        //通过cid去查商品 todo

        $fee = 0;

        if (!empty($cid) || !empty($gid)) {

            if (!empty($gid)) {

                if (empty($ggo_id)) {

                    $goods = pdo_fetchall("select * from " . tablename($this->goods) . " as g where g_id =" . $gid);

                } else {

                    $goods = pdo_fetchall("select * from " . tablename($this->goods) . " as g left join " . tablename($this->goods_option) . " as go on go.ggo_g_id = g.g_id where g_id =" . $gid . " and ggo_id=" . $ggo_id);

                }

            }

            if (!empty($cid)) {

                $goods = pdo_fetchall("select * from " . tablename($this->goods) . " as g join " . tablename($this->cart) . " as c on c.c_g_id =g.g_id left join " . tablename($this->goods_option) . " as go on go.ggo_id = c.c_ggo_id where c_id in(" . $cid . ")  ");

            }

			$first_price = 0;

            foreach ($goods as $k => $v) {

                if (!empty($g_num)) {

                    $c_count = $g_num;

                } else {

                    $c_count = $v['c_count'];//数量

                }

                $g_send_type = $v['g_send_type'];//运费规则

                $g_price = $v['g_price'];//单价

                if (!empty($v['ggo_id']) && !empty($v['ggo_market_price'])) {

                    $g_price = $v['ggo_market_price'];//单价

                }

                $g_only_weight = $v['g_only_weight'] * 1000;//单规格重量

                if (!empty($v['ggo_id']) && !empty($v['ggo_weight'])) {

                    $g_only_weight = $v['ggo_weight'] * 1000;//单规格重量

                }

                $g_express_shipping_id = $v['g_express_shipping_id'];

                if ($g_send_type == 2 && $g_express_shipping_id != '') {

                    //此商品有运费模版id了

                    if (isset($ad_code) && !empty($ad_code)) {

                        $fee += $this->calc_transport($g_express_shipping_id, $c_count, $g_only_weight * $c_count, $ad_code,$first_price);

						$first_price ++;

                    } else {

                        $fee += 0;

                    }

                } else if ($g_send_type == 1) {

                    $fee += floatval($v['g_send_price_sample']);

                } else {

                    $fee += 0;

                }

            }

        }

        if ($_GPC['test'] == 1) {

            var_dump($fee);

            var_dump($goods);

            var_dump($ad_code);

            exit;

        }

        $this->result(0, '成功', array('fee' => $fee));

    }
    /**
     * 计算某地区某运费模板ID下的商品总运费，如果运费模板不存在或，按免运费处理
     *
     * @param int $transport_id 运费模版id
     * @param int $quantity 商品件数
     * @param int $buy_num 商品重量
     * @param int $area_id 地区id
     * @return number/boolean
     */
    public function calc_transport($transport_id, $quantity, $buy_num, $area_id,$first_price) {

        global $_W;

        global $_GPC;

        //$good['transport_id'], $good['quantity'], $address

        if (empty($transport_id) || empty($area_id)) return 0;



        $shipping_param = array();

        $shipping_param[':weid'] = $this->weid;

        $shipping_param[':id'] = $transport_id;



        $shipping_sql = "select * from " . tablename('gpb_express_shipping') . " where weid=:weid and id=:id ";



        $extend_list = pdo_fetchall($shipping_sql, $shipping_param);



        //$extend_list = M('TransportExtend')->where('transport_id='.$transport_id)->select();



        if (empty($extend_list)) {

            return 0;

        } else {

            return $this->calc_unit($area_id, $quantity, $buy_num, $extend_list,$first_price);

        }

    }



    /**

     * 计算某个具单元的运费

     *

     * @param 配送地区 $area_id

     * @param 购买数量 $quantity

     * @param 购买重量 $weight

     * @param 运费模板内容 $extend

     * @return number 总运费

     * ($area_id,$quantity, $buy_num,$extend_list);

     */

    private function calc_unit($area_id, $quantity, $weight, $extend,$first_piece = 0){
        global $_W;
        global $_GPC;
//        $area_sql = "select * from ".tablename('lionfish_comshop_area')." where id=:id ";//后期加不送快递地区就改这
//        $area_info = pdo_fetch($area_sql, array(':id' => $area_id) );
        //$area_info [code ]
        if (!empty($extend) && is_array($extend)) {
            $calc_total = array(

                'error' => '该地区不配送！！'

            );

            $defult_extend = array();

            foreach ($extend as $v) {

                /**

                 * strpos函数返回字符串在另一个字符串中第一次出现的位置，没有该字符返回false

                 * 参数1，字符串

                 * 参数2，要查找的字符

                 * a:1:{i:0;a:6:{s:5:"citys";s:90:"福州市;厦门市;莆田市;三明市;泉州市;漳州市;南平市;龙岩市;宁德市;";

                 * s:10:"citys_code";s:63:"350100;350200;350300;350400;350500;350600;350700;350800;350900;";

                 * s:5:"frist";s:3:"500";s:11:"frist_price";s:1:"5";s:6:"second";s:3:"500";s:12:"second_price";s:1:"1";}}

                 */

                $area_price = unserialize($v['areas']);

//              $area_price = $area_price;

//              if( !empty($area_info['code']) && !empty($area_price['citys_code']) && in_array($area_info['code'], $area_price['citys_code']) )

                $count = 0;

                if (is_array($area_price)) {

                    foreach ($area_price as $key => $val) {

                        $limit_citys_array = explode(",", $val['citys_code']);

                        if (in_array($area_id, $limit_citys_array)) {

                            unset($calc_total['error']);

                            $frist = $val['frist'];

                            $frist_price = $val['frist_price'];

                            $second = $val['second'];

                            $second_price = $val['second_price'];

                            //按照重量

                            if ($v['type'] == 1) {

                            	//判断是否算首重

                            	if(empty($first_piece)){

                            		if ($weight <= $frist) {

	                                    //在首重数量范围内

	                                    $calc_total['price'] = $frist_price;

	                                } else {

	                                    //超出首重数量范围，需要计算续重

	                                    if($second){

	                                    	$calc_total['price'] = sprintf('%.2f', ($frist_price + ceil(($weight - $frist) / $second) * $second_price));

	                                    }else{

	                                    	 $calc_total['price'] = $frist_price;

	                                    }

	                                }

	                                return $calc_total['price'];

                            	}else{

									$calc_total['price'] = sprintf('%.2f', (ceil($weight/$second) * $second_price));

									return $calc_total['price'];

                            	}

                            } else if ($v['type'] == 2) {

                                //按照件数  firstnum firstnumprice  secondnum  secondnumprice

                                if(empty($first_piece)){

                                	if ($quantity <= $frist) {

	                                    //在件数数量范围内

	                                    $calc_total['price'] = $frist_price;

	                                } else {

	                                    //超出件数数量范围，需要计算续件

	//                                  echo $frist_price."--".$quantity."--".$frist.$second;exit;

	                                    if($second){

		                                    $calc_total['price'] = sprintf('%.2f', (ceil(($quantity - $frist) / $second) * $second_price));

	                                    }else{

	                                    	$calc_total['price'] = $frist_price;

	                                    }

	                                }

                                }else{

                                	if($second){

	                                    $calc_total['price'] = sprintf('%.2f', ($frist_price + ceil(($quantity) / $second) * $second_price));

                                    }else{

                                    	$calc_total['price'] = $frist_price;

                                    }

                                }

                                return $calc_total['price'];

                            }

                            $count++;

                        }

                    }

                }

                if ($count == 0 || empty($area_price['citys_code']) ) {

                    //使用默认的

                    unset($calc_total['error']);

                    //按照重量

                    if ($v['type'] == 1) {

                    	if(empty($first_piece)){

                    		//判断是否需要计算首重

                			if ($weight <= $v['firstweight']) {

	                            //在首重数量范围内

	                            $calc_total['price'] = $v['firstprice'];

	                        } else {

	                            //超出首重数量范围，需要计算续重

	                            if($v['secondweight']){

		                            $calc_total['price'] = sprintf('%.2f', ($v['firstprice'] + ceil(($weight - $v['firstweight']) / $v['secondweight']) * $v['secondprice']));

	                            }

	                        }

	                        return $calc_total['price'];

                    	}else{

                    		$calc_total['price'] = sprintf('%.2f', (ceil(($weight) / $v['secondweight']) * $v['secondprice']));

							return $calc_total['price'];

                    	}

                    } else if ($v['type'] == 2) {

                        //按照件数  firstnum firstnumprice  secondnum  secondnumprice

                        //判断是否需要计算首件

                        if(empty($first_piece)){

							//需要计算

							if ($quantity <= $v['firstnum']) {

	                            //在首重数量范围内

	                            $calc_total['price'] = $v['firstnumprice'];

//								echo $calc_total['price'];echo '<br/>';

	                        } else {

	                            //超出首件数量范围，需要计算续件

	                            if($v['secondnum']){

		                            $calc_total['price'] = sprintf('%.2f', ($v['firstnumprice'] + ceil(($quantity - $v['firstnum']) / $v['secondnum']) * $v['secondnumprice']));

//	                            	echo $calc_total['price'];echo '<br/>';

								}

	                        }

	                        return $calc_total['price'];

						}else{

							//不需要计算首件  只按照续件的方式来计算价格

							$calc_total['price'] = sprintf('%.2f',$quantity*$v['secondnumprice']);

							return $calc_total['price'];

						}

                    }

                }

                if (strpos($v['area_id'], "," . $area_id . ",") !== false) {

                    unset($calc_total['error']);

                    if ($quantity <= $v['snum']) {

                        //在首重数量范围内

                        $calc_total['price'] = $v['sprice'];

                    } else {

                        //超出首重数量范围，需要计算续重

                        $calc_total['price'] = sprintf('%.2f', ($v['sprice'] + ceil(($num - $v['snum']) / $v['xnum']) * $v['xprice']));

                    }

                    return $calc_total['price'];

                }

            }

            return 0;

        }
    }



    /*

     * 快递即时查询

     * $order_id char 订单号

     */

    public function goods_express($order_id)

    {

        global $_W;

        global $_GPC;

        $order_info = pdo_fetch("select * from " . tablename($this->order) . " where weid=:weid and go_code =:go_code ", array(':weid' => $this->weid, ':go_code' => $order_id));

        $now_time = time();



        //上次查询超过半天后

        if ($now_time - $order_info['shipping_cha_time'] >= 43200) {

            //即时查询接口

            //查询快递的类型

            $seller_express = pdo_fetch("select * from " . tablename('gpb_express') . " where id=:id ", array(':id' => $order_info['shipping_method']));

            if (!empty($seller_express['simplecode'])) {

                //887406591556327434  YTO

                //TODO...

                //读取配置快递鸟id

                $ebuss_info = pdo_get($this->config, array('key' => 'express_bird_id', 'weid' => $this->weid));

                $ebuss_info = $ebuss_info['value'];

                //读取配置快递鸟key

                $exappkey = pdo_get($this->config, array('key' => 'express_bird_key', 'weid' => $this->weid));

                $exappkey = $exappkey['value'];

                //正式地址

                $req_url = "http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx";

                //测试地址

//                $req_url = "http://sandboxapi.kdniao.com:8080/kdniaosandbox/gateway/exterfaceInvoke.json";

                $requestData = "{'OrderCode':'" . $order_id . "','ShipperCode':'" . $seller_express['simplecode'] . "','LogisticCode':'" . $order_info['shipping_no'] . "'}";



                $datas = array(



                    'EBusinessID' => $ebuss_info,



                    'RequestType' => '1002',



                    'RequestData' => urlencode($requestData),



                    'DataType' => '2',



                );

                //算签名

                $datas['DataSign'] = $this->encrypt($requestData, $exappkey);

                $result = $this->sendPost($req_url, $datas);

                $result = json_decode($result);

//                var_dump($result);exit;

                //根据公司业务处理返回的信息......

                //Traces

                if (!empty($result->Traces)) {

                    $order_info['shipping_traces'] = serialize($result->Traces);



                    $up_data = array('shipping_cha_time' => time(), 'shipping_traces' => $order_info['shipping_traces']);



                    pdo_update($this->order, $up_data, array('go_code' => $order_id, 'weid' => $this->weid));



                    return $order_info['shipping_traces'];

                }



            }



        }



//        $order_goods = pdo_fetch("select * from ".tablename('lionfish_comshop_order_goods')." where uniacid=:uniacid and order_id=:order_id ", array(':uniacid' => $_W['uniacid'],':order_id' => $order_id ));

//

//        $goods_info = array();

//

//        $goods_info = load_model_class('pingoods')->get_goods_images($order_goods['goods_id']);

//

//

//        $goods_info['image'] = tomedia($goods_info['image']);

//

//        $seller_express = pdo_fetch("select * from ".tablename('lionfish_comshop_express')." where id=:id ", array(':id' => $order_info['shipping_method'] ) );

//

//

//        $order_info['shipping_traces'] =  unserialize($order_info['shipping_traces']) ;

//

//        echo json_encode( array('code' => 0, 'seller_express' => $seller_express, 'goods_info' => $goods_info, 'order_info' => $order_info) );



        return;



    }



    /*

     * 快递查询算签名

     * $data obj 请求数据

     * $appkey char 快递鸟key

     */

    function encrypt($data, $appkey)

    {

        return urlencode(base64_encode(md5($data . $appkey)));

    }



    function sendPost($url, $datas)

    {

        $temps = array();

        foreach ($datas as $key => $value) {

            $temps[] = sprintf('%s=%s', $key, $value);

        }



        $post_data = implode('&', $temps);



        $url_info = parse_url($url);

        if (empty($url_info['port'])) {

            $url_info['port'] = 80;

        }

        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";

        $httpheader .= "Host:" . $url_info['host'] . "\r\n";

        $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";

        $httpheader .= "Content-Length:" . strlen($post_data) . "\r\n";

        $httpheader .= "Connection:close\r\n\r\n";

        $httpheader .= $post_data;

        $fd = fsockopen($url_info['host'], $url_info['port']);

        fwrite($fd, $httpheader);

        $gets = "";

        $headerFlag = true;

        while (!feof($fd)) {

            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {

                break;

            }

        }

        while (!feof($fd)) {

            $gets .= fread($fd, 128);

        }

        fclose($fd);

        return $gets;

    }



//    public function doPagettt(){

//        $res = pdo_fetchall('SELECT ROUND(RAND() * ((SELECT MAX(g_id) FROM `ims_gpb_goods`)-(SELECT MIN(g_id) FROM `ims_gpb_goods` ))+(SELECT MIN(g_id) FROM `ims_gpb_goods` )) AS round_id,`ims_gpb_goods`.* FROM `ims_gpb_goods` WHERE weid =6 LIMIT 50');

//        $str = '';

//        foreach ($res as $v){

//            $str .=','.$v['round_id'];

//        }

//        $file  = dirname(__FILE__).'/ttt.txt';//

//        if(file_exists($file) && filesize($file) > 100000){

//            unlink($file);//这里是直接删除，

//        }

//

//        $str .= "\n------\n";

//        file_put_contents($file,$str.PHP_EOL,FILE_APPEND);

//    }

    //商品详情页推荐购买

    public function doPageGoodsInfoRecommend()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid) || $openid == 'undefined') {

            $this->result("1", "未授权");

        }

		$cutting = $this->custting_order_time(3,$openid);

        $page = trim($_GPC['page']);

        $page = empty($page) ? 1 : $page;

        //当前商品

        $where = '';

        $gid = trim($_GPC['gid'], ',');

        if ($gid == 'undefined' || empty($gid)) {

            $gid = '';

        } else {

            $where .= ' and g_id not in (' . $gid . ') ';

        }

//        //团长

//        $team_openid = trim($_GPC['team_openid']);

//        if($team_openid == 'undefined'){

//            $team_openid ='';

//        }

//        $goods = pdo_fetchall($sql = "select g.* from ".tablename($this->action_goods)." as ag  join ".tablename($this->action)." as a on ag.gcg_at_id = a.at_id  join ".tablename($this->goods)."  as g on g.g_id =ag.gcg_g_id left join ".$this->pre."gpb_goods_to_category as gtc on gtc.goods_id =g.g_id  left join ".tablename($this->goods_cate)." as c on c.gc_id=gtc.cate_id  join ".tablename($this->goods_stock)." as gs on gs.goods_id = ag.gcg_g_id left join ".tablename($this->action_village)." as av on av.gav_ac_id = at_id left join ".tablename($this->vg)." as vg on vg.vg_id = av.gav_v_id where (at_is_limit=1 or (at_is_limit=-1 and vg.openid='".$team_openid."')) and at_is_del=1 and  at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time > ".time()." and at_start_time < ".time()." and (g.`type`<>2 or g.`type` is null) and ag.weid=".$this->weid." and (g.g_end_sale_time >".time()." or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL ) ".$where."  GROUP BY g.g_id order by g_is_near_recommend desc,g_is_recommand desc,g_is_new desc,g_is_hot desc,g_order desc,at_start_time desc limit 3");

		//判断当前是否有团购活动

		$gpbs = pdo_fetch(" select * from ".tablename("gpb_action")." where at_start_time <= ".time()." and at_end_time >= ".time()." and weid = ".$this->weid);

		if(!empty($gpbs)){

			$round_sql = 'SELECT * FROM ' . tablename('gpb_goods') . '  AS t1

JOIN (SELECT ROUND(RAND() * (SELECT MAX(g_id) FROM ' . tablename('gpb_goods') . ')) AS id ) AS t2 WHERE t1.g_id >= t2.id AND t1.g_is_online=1 and t1.weid=' . $this->weid . ' and t1.g_is_del=1 and t1.g_is_online=1 and (t1.g_is_hot=1 or t1.g_is_recommand=1 or t1.g_is_near_recommend=1 or t1.g_is_new=1) ' . $where . ' AND (t1.`type`=1 OR  t1.`type` IS NULL)  limit 10';

	        $rcommend_sql = 'select * from ' . tablename('gpb_goods') . ' where weid=' . $this->weid . ' and g_is_del=1 and g_is_online=1 and (g_is_hot=1 or g_is_recommand=1 or g_is_near_recommend=1 or g_is_new=1) ' . $where . ' AND (`type`=1 OR  `type` IS NULL)  order by g_is_recommand desc,g_is_near_recommend desc,g_is_hot desc,g_is_new desc limit 10';

	        if ($page == 1 && !$cutting) {

	            $goods = pdo_fetchall($rcommend_sql);

	            $sql = $rcommend_sql;

	        } elseif ($page > 1 && !$cutting) {

	            $goods = array();

	            $goods = pdo_fetchall($round_sql);

	//            $ids = pdo_fetchall($round_sql);

	//            $id_str= '';

	//            foreach ( $ids as $k=> $v){

	//                $id_str .= ','.$v['round_id'];

	//            }

	//            $id_str = trim($id_str,',');

	//            if(!empty($id_str)){

	//                $goods= pdo_fetchall('select * from '.tablename('gpb_goods').' where weid='.$this->weid.' and g_is_del=1 and g_is_online=1 and (g_is_hot=1 or g_is_recommand=1 or g_is_near_recommend=1 or g_is_new=1) and  g_id in ('.$id_str.') '.$where.' order by g_is_recommand desc,g_is_near_recommend desc,g_is_hot desc,g_is_new desc limit 10');

	//            }

	            $sql = $round_sql;

	        }

			if($goods){

		        foreach ($goods as $k => $v) {

		            $goods_cart = pdo_fetch("select c_count,c_id from " . tablename($this->cart) . " where openid='" . $openid . "' and c_is_del =1 and c_status =1 and c_g_id = " . $v['g_id']);

		            if (empty($goods_cart)) {

		                $goods[$k]['curGoodsNum'] = 0;

		            } else {

		                $goods[$k]['curGoodsNum'] = $goods_cart['c_count'];

		            }

		            $goods_stock['num'] = 0;

		            $goods_stock = pdo_get('gpb_goods_stock', array('goods_id' => $v['g_id']));

		            if (isset($goods_stock['num']) && !empty($goods_stock['num'])) {

		                $goods[$k]['num'] = $goods_stock['num'];

		            }

		            $goods[$k]['g_icon'] = tomedia($v['g_icon']);

		            $goods[$k]['g_video'] = tomedia($v['g_video']);

		            $goods[$k]['g_video_open'] = empty($v['g_video']) ? 0 : 1;

					//判断是否是秒杀商品

					$_GPC['gid'] = $v['g_id'];

					$tf = $this->doPageSeckill_get_goods_info();

		        	$goods[$k]['seckill'] = $tf;

				}

			}

		}

        $goods_info_open_near = pdo_get($this->config, array('key' => 'goods_info_open_near', 'weid' => $this->weid));

        $is_open = isset($goods_info_open_near['value']) ? $goods_info_open_near['value'] : 2;

        if (empty($goods)) {

            $is_open = 2;

        }

        $this->result("0", "附近推荐购买商品获取成功", array('data' => $goods, 'is_open' => $is_open, 'sql' => $sql));

    }



    //获取首页分享海报参数

    public function doPagesharegoods()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid) || $openid == 'undefined') {

            $this->result("1", "未授权");

        }

        $scene = $_GPC['scene'];

        if (empty($scene)) {

            $this->result("1", "请传入scene");

            exit();

        }

        $member = pdo_get('gpb_member', array('m_openid' => $openid),array('m_head_openid'));

        if (empty($member)) {

            $this->result("1", "未授权");

        }

        //背景图

        $index_playbill_img = pdo_get($this->config, array('key' => 'index_playbill_img', 'weid' => $this->weid),array('value'));

        $img = '';

        if (isset($index_playbill_img['value'])) {

            $img = tomedia($index_playbill_img['value']);

        }

        //商品

        $index_playbill_goods = pdo_get($this->config, array('key' => 'index_playbill_goods', 'weid' => $this->weid),array('value'));

        $ids = '';

        if (isset($index_playbill_goods['value'])) {

            $ids = $index_playbill_goods['value'];

        }

        if (empty($ids)) {

            $sql_goods = "select g_icon,g_name,g_old_price,g_price from " . tablename('gpb_goods') . " where g_is_online=1 and g_is_del=1 and weid=" . $this->weid . " order by g_is_top desc,g_is_near_recommend desc,g_is_recommand desc,g_order desc limit 8";

        } else {

            $sql_goods = "select g_icon,g_name,g_old_price,g_price from " . tablename('gpb_goods') . " where g_id in (" . $ids . ") and weid=" . $this->weid . " order by instr('" . $ids . "',g_id) ";

        }

        $goods = pdo_fetchall($sql_goods);

        foreach ($goods as &$v) {

            $v['g_icon'] = toimage($v['g_icon']);

            $v['priceArry'] = explode('.', $v['g_price']);

			//图片转base64

			//判断是否开启对象存储

//			$v['g_icon'] = "data:image/png;base64,".$this->cross(toimage($v['g_icon']));

        }

        //团长

        $head = pdo_get('gpb_member', array('m_openid' => $member['m_head_openid']),array('m_nickname','m_head_shop_name','m_head_address','m_name','m_openid','qr_code'));

        $savePath = QRCODEPATH . "index-playbill-qr_code" . $openid . ".jpg";

        if (!file_exists($savePath) || filesize($savePath) == 0) {

        	if(file_exists($savePath)){

        		unlink($savePath);

        	}

            $tokne = $this->Token();

            $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $_W['account']['access_tokne'];

            $data = array(

                'scene' => $scene,//.'&at_id='.$a_id,

                'width' => 300,

                'auto_color' => false,

                'page' => "pages/template/index",

            );

            $data = json_encode($data);

            $data_imgs = $this->http_request($url, $data);

            $data_img = json_encode($data_imgs,true);

            if(!$data_img){

            	$res = file_put_contents('..' . $savePath, $data_imgs);

				$url = 'https://' . $_SERVER['HTTP_HOST'] . $savePath;

            } else {

            	$url = $data_img;

            }

        }

        if($this->check_base64_out_json( $head['m_nickname'] )){

            $head['m_nickname'] = base64_decode( $head['m_nickname'] );

        }

        $this->result("0", "成功", array('goods' => $goods, 'head' => $head, 'img' => $img, 'qrcode' => $url,'datsa'=>$data_img));



    }
	/**
	 * 专门将图片转为base64位字符
	 */
	public function doPageImage_Base(){
		global $_W, $_GPC;
		$image = $_GPC['image'];
		if(empty($image)){
			$this->result(1,'没有图片',base64_decode($image));
		}
		$img = explode(',',$image);
		if( $img ){
			$data = [];
			foreach($img as $k=>$v){
				$data[] = $this->cross(base64_decode($v));
			}
			$this->result(0,'成功',$data);
		} else {
			$this->result(1,'图片错误');
		}
	}
	/***
	 * 图片转base64
	 */
	public function cross($img){
		load()->func('communication');
		$image = trim($img);
		if(empty($image)) {
			return $img;
		}
		$content = ihttp_request($image, '', array('CURLOPT_REFERER' => 'http://www.qq.com'));
		return base64_encode($content['content']);
	}



    /*

     * 获取推广码

     */

    public function make_coupon_card(){

        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $rand = $code[rand(0, 25)]

            . strtoupper(dechex(date('m')))

            . date('d') . substr(time(), -5)

            . substr(microtime(), 2, 5)

            . sprintf('%02d', rand(0, 99));

        for (

            $a = md5($rand, true),

            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV',

            $d = '',

            $f = 0;

            $f < 8;

            $g = ord($a[$f]),

            $d .= $s[($g ^ ord($a[$f + 8])) - $g & 0x1F],

            $f++

        ) ;

        return $d;

    }



    /**

     * 佣金计算

     * $osn string 订单号

     */

    public function headcost($osn = '')

    {

        //获取当前配置

        $head_agent_open = pdo_get($this->config, array('key' => 'head_agent_open', 'weid' => $this->weid));

        if (isset($head_agent_open['value']) && $head_agent_open['value'] != 1) {

            return array('msg' => '未开启团长推广代理配置', 'code' => 1);

        }

        $head_agent_get_type_arr = pdo_get($this->config, array('key' => 'head_agent_get_type', 'weid' => $this->weid));

        if (!isset($head_agent_get_type_arr['value']) || empty($head_agent_get_type_arr['value'])) {

            return array('msg' => '提成类型设置有误', 'code' => 1);

        }

        $head_agent_get_type = $head_agent_get_type_arr['value'];

        //获取当前分佣等级参数是否配置

//        for($i=1;$i<=$config['distribution_lv'];$i++){

//            switch($config['distribution_type']){

//                case 1:

//                    //百分比分佣

//                    if(empty($config["distribution_lv{$i}_parsent"])){

//                        return $this->ReturnArray("当前开启分佣等级为{$config['distribution_lv']}级，请设置{$i}级分佣比例");

//                    }

//                    break;

//                case 2:

//                    //固定分佣

//                    if(empty($config["distribution_lv{$i}_fixed"])){

//                        return $this->ReturnArray("当前开启分佣等级为{$config['distribution_lv']}级，请设置{$i}级分佣金额");

//                    }

//                    break;

//            }

//        }

        if ($osn == '' || empty($osn)) {

            return array('msg' => '订单参数错误', 'code' => 1);

        }

        $order = pdo_get("gpb_order", ['go_code' => $osn, 'weid' => $this->weid, "go_status" => 100]);

        if (empty($order)) {

            return array('msg' => '订单不存在', 'code' => 1);

        }



        $openid = $order['go_team_openid'];

        $user = pdo_get("gpb_member", ['m_openid' => $openid, 'weid' => $this->weid]);

        $buyer = pdo_get("gpb_member", ['m_openid' => $order['openid'], 'weid' => $this->weid]);

        $uid = $user['m_id'];

        //计算订单总金额

//        2020-03-10 周龙 修改 配送费邮费 不参与分佣
//        $total_money = $order['go_real_price'] + $order['go_send_pay'];
        $total_money = $order['go_real_price'];

        //获取所有团队信息从低到高找



        $all_lv2 = '';//直属上级

        $all_lv1 = '';//上级的上级

        $all_lv0 = '';//lear级

//        $all_lv4 = '';//自身



        //开启了几级分销

        $head_agent_level_arr = pdo_get($this->config, array('key' => 'head_agent_level', 'weid' => $this->weid));

        if (isset($head_agent_level_arr['value'])) {

            $head_agent_level = $head_agent_level_arr['value'];

        } else {

            $head_agent_level = 1;

        }



        if ($head_agent_level == 3) {

            //所属最低级所在团队 自身属于lv3 ；leader参与分佣

            $sql = "select * from " . tablename("gpb_head_group") . " where find_in_set('{$uid}',lv3) and `weid`='{$this->weid}'";

            $team = pdo_fetchall($sql);

            if (!empty($team[0])) {

                //存在团队

                $team = $team[0];



                $all_lv0 = $team['leader_id'];

            }

        }



        if ($head_agent_level >= 2) {

            //所属二级团队 自身所属lv2； leader 参与分佣

            $sql = "select * from " . tablename("gpb_head_group") . " where find_in_set('{$uid}',lv2) and `weid`='{$this->weid}'";

            $team2 = pdo_fetchall($sql);

            if (!empty($team2[0])) {

                //存在团队

                $team2 = $team2[0];

                $all_lv1 = $team2['leader_id'];

            }

        }



        if ($head_agent_level >= 1) {

            //所属三级团队 自身所属lv1 leader参与分佣

            $sql = "select * from " . tablename("gpb_head_group") . " where find_in_set('{$uid}',lv1) and `weid`='{$this->weid}'";

            $team3 = pdo_fetchall($sql);

            if (!empty($team3[0])) {

                $team3 = $team3[0];

                $all_lv2 = $team3['leader_id'];

            }

        }



//        if($this->config['distribution_isself']==1) {

//            //是否自身参与分佣

//            $all_lv4 = $uid;

//        }

//        $head_agent_get_type = pdo_get($this->config,array('key'=>'head_agent_get_type','weid'=>$weid));

        //获取各种等级分佣配置

        $head_agent_lever_one = pdo_get($this->config, array('key' => 'head_agent_lever_one', 'weid' => $this->weid));

        $lever_one = (isset($head_agent_lever_one['value']) && !empty($head_agent_lever_one['value'])) ? $head_agent_lever_one['value'] : 0;

        $head_agent_lever_two = pdo_get($this->config, array('key' => 'head_agent_lever_two', 'weid' => $this->weid));

        $lever_two = (isset($head_agent_lever_two['value']) && !empty($head_agent_lever_two['value'])) ? $head_agent_lever_two['value'] : 0;

        $head_agent_lever_three = pdo_get($this->config, array('key' => 'head_agent_lever_three', 'weid' => $this->weid));

        $lever_three = (isset($head_agent_lever_three['value']) && !empty($head_agent_lever_three['value'])) ? $head_agent_lever_three['value'] : 0;

        if ($head_agent_get_type == 1) {

            //百分比分佣

            //生成键值对, key 为用户id,value为佣金金额

            $arr = [];

            if (!empty($all_lv0)) {

                //最高级分佣最少

                $arr[$all_lv0] = floatval($total_money) * floatval($lever_three) / 100;

            }

            if (!empty($all_lv1)) {

                $arr[$all_lv1] = floatval($total_money) * floatval($lever_two) / 100;

            }

            if (!empty($all_lv2)) {

                $arr[$all_lv2] = floatval($total_money) * floatval($lever_one) / 100;

            }

//            if(!empty($all_lv4)){

//                $arr[$all_lv4] = $total_money*$config['distribution_leader_parsent']/100;

//            }

        } elseif ($head_agent_get_type == 2) {

            //固定金额分佣

            //生成键值对, key 为用户id,value为佣金金额

            $arr = [];

            if (!empty($all_lv0)) {

                $arr[$all_lv0] = floatval($lever_three);

            }

            if (!empty($all_lv1)) {

                $arr[$all_lv1] = floatval($lever_two);

            }

            if (!empty($all_lv2)) {

                $arr[$all_lv2] = floatval($lever_one);

            }



        } else {

            return array('msg' => '请设置提成方式', 'code' => 1);

        }

        if (empty($arr)) {

            return array('msg' => '无人参与分佣', 'code' => 1);

        }

        if($this->check_base64_out_json( $user['m_nickname'] )){

            $user['m_nickname'] = base64_decode( $user['m_nickname'] );

        }

        if($this->check_base64_out_json( $buyer['m_nickname'] )){

            $buyer['m_nickname'] = base64_decode( $buyer['m_nickname'] );

        }

        //佣金处理

        foreach ($arr as $k => $v) {

            $this->addmoney($osn, $k, $v, "因{$user['m_nickname']}团长下用户{$buyer['m_nickname']}消费{$total_money}元，获得佣金{$v}元", 1);

        }

        return array('msg' => '分佣计算完成', 'code' => 0, 'data' => $arr);

    }



    /**

     * 用户佣金增加

     * $uid int 用户id

     * $money double 增加金额

     * $msg string 增加资金途径

     */

    public function addmoney($order_code, $uid = 0, $money = 0, $msg = '', $from_type = 1)

    {

        if ($uid < 1) {

            return array('msg' => "用户不存在", 'code' => 1);

        }

        if ($money <= 0) {

            return array('msg' => "金额错误", 'code' => 1);

        }

        $user = pdo_get("gpb_head_money", ['uid' => $uid, 'weid' => $this->weid, 'check_state' => 1]);

        if (empty($user)) {

//            return array('msg'=>"该用户不是团长分销用户",'code'=>1);

            //没有记录先插入

            $user = [

                'uid' => $uid,

                'create_time' => time(),

                'update_time' => time(),

                'status' => 1,

                'weid' => $this->weid,

            ];

            pdo_insert("gpb_head_money", $user);

        }

        $sql = "update " . tablename("gpb_head_money") . " set `money` = money+{$money} where `uid`='{$uid}' ";

        $res = pdo_query($sql);

        $this->moneychangelog($order_code, $uid, 1, $money, "{$msg},佣金增加{$money}元", $from_type);

        return $res ? array('msg' => "佣金修改成功", 'code' => 0) : array('msg' => "佣金修改失败", 'code' => 1);

    }

    /**
     * 团长佣金减少
     * @param $gbm_id array 退款id一维数组
     */
    public function doPageheadrefundmoney($gbm_id=[]){
        global $_W,$_GPC;
        $gbm_id = empty($gbm_id)?$_GPC['gbm_id']:$gbm_id;
        if(empty($gbm_id)){
            if(!empty($_GPC['gbm_id'])){
                echo json_encode(['code'=>1,'参数错误']);
                die;
            }
            return ['code'=>1,'参数错误'];
        }
        //第一步 根据退款id 反查 订单id 退款商品等信息
        $gbm_ids = implode(",",$gbm_id);
        $gbm_info = pdo_fetchall("select * from ".tablename($this->back_money)." where gbm_id in ({$gbm_ids})");
        /*echo "select * from ".tablename($this->back_money)." where gbm_id in ({$gbm_ids})";
        echo "<pre/>";
        var_dump($gbm_info);*/
        /*die;*/
        if(!empty($gbm_info)){
            foreach ($gbm_info as $k=>$v){
                //获取参与分佣的总金额
                $order_pay = pdo_fetchcolumn("select `go_real_price` from ".tablename($this->order)." where weid={$this->weid} and go_code='{$v['gbm_go_code']}'");

                $order_pay = doubleval($order_pay);
                if($order_pay>0){
                    //0元订单不计算
                    $list = pdo_fetchall("select * from ".tablename("gpb_head_money_log")." where weid={$this->weid} and order_code='{$v['gbm_go_code']}' and `type`=1 and type_from=1");


                   /* echo "<pre/>";
                    var_dump($list);*/

                    if(!empty($list)){
                        //有分佣计算
                        foreach ($list as $kk=>$vv){

                            pdo_begin();
                            if(doubleval($vv['money'])>0){
                                //分佣大于0的进行处理
                                //第一步获取各级配置
                                $dis_conf = intval($vv['dis_type'])===1?unserialize($vv['percent']):unserialize($vv['fiexd']);
                                if(intval($vv['dis_type'])===1){
                                    //比例计算
                                    //计算总价比例 对比是哪个等级
                                    $parsent = unserialize($vv['percent']);
                                    $lv1 = doubleval(round($order_pay*$parsent['lv1']/100,2));
                                    $lv2 = doubleval(round($order_pay*$parsent['lv2']/100,2));
                                    $lv3 = doubleval(round($order_pay*$parsent['lv3']/100,2));


                                    if(doubleval($vv['money'])==$lv1){
                                        //一级代理
                                        //获取当前退款金额
                                        $dec_money = doubleval($v['gbm_go_money'])*$parsent['lv1']/100;
                                    }
                                    if(doubleval($vv['money'])==$lv2){
                                        //二级代理
                                        $dec_money = doubleval($v['gbm_go_money'])*$parsent['lv2']/100;
                                    }
                                    if(doubleval($vv['money'])==$lv3){
                                        //三级代理
                                        $dec_money = doubleval($v['gbm_go_money'])*$parsent['lv3']/100;
                                    }
                                    $user = pdo_fetch("select * from ".tablename("gpb_head_money")." where weid={$this->weid} and `uid`={$vv['uid']} and check_state=1");

                                    //固定金额按订单计算的 直接全部扣除
                                    $money = doubleval($dec_money);
                                    $uid = $vv['uid'];
                                    $log = [
                                        'uid'=>$uid,
                                        'type'=>2,
                                        'money'=>$money,
                                        'order_code'=>$v['gbm_go_code'],
                                        'info'=>"订单{$v['gbm_go_code']}已退款，系统回收佣金奖励",
                                        'before'=>$user['money'],
                                        'after'=>doubleval($user['money'])+doubleval($money),
                                        'percent'=>$vv['percent'],
                                        'fiexd'=>$vv['fiexd'],
                                        'dis_type'=>$vv['dis_type'],
                                        'create_time'=>time(),
                                        'update_time'=>time(),
                                        'type_from'=>1,
                                        'weid'=>$this->weid,
                                    ];

                                    $res = pdo_query("update ".tablename("gpb_head_money")." set money=money-{$money} where uid={$uid}");
                                    if($res){
                                        $result = pdo_insert("gpb_head_money_log",$log);
                                        if($result){
                                            pdo_commit();
                                        }else{
                                            pdo_rollback();
                                        }
                                    }else{
                                        pdo_rollback();
                                    }
                                }else{
                                    //固定金额

                                    //先判断是否全部退款
                                    $has_all_back = pdo_fetch("select sum(gbm_money) as back_money,gbm_go_money from ".tablename("gpb_back_money")." where weid={$this->weid} and gbm_go_code='{$v['gbm_go_code']}' and gbm_status=20 group by gbm_go_code");
                                    /*echo "<pre/>";
                                    var_dump($has_all_back);
                                    die;*/
                                    if(doubleval($has_all_back['back_money'])===doubleval($has_all_back['gbm_go_money'])){
                                        //已全部退款扣除佣金
                                        //获取用户当前余额
                                        $user = pdo_fetch("select * from ".tablename("gpb_head_money")." where weid={$this->weid} and `uid`={$vv['uid']} and check_state=1");

                                        //固定金额按订单计算的 直接全部扣除
                                        $money = doubleval($vv['money']);
                                        $uid = $vv['uid'];
                                        $log = [
                                            'uid'=>$uid,
                                            'type'=>2,
                                            'money'=>$money,
                                            'order_code'=>$v['gbm_go_code'],
                                            'info'=>"订单{$v['gbm_go_code']}已退款，系统回收佣金奖励",
                                            'before'=>$user['money'],
                                            'after'=>doubleval($user['money'])+doubleval($money),
                                            'percent'=>$vv['percent'],
                                            'fiexd'=>$vv['fiexd'],
                                            'dis_type'=>$vv['dis_type'],
                                            'create_time'=>time(),
                                            'update_time'=>time(),
                                            'type_from'=>1,
                                            'weid'=>$this->weid,
                                        ];

                                        $res = pdo_query("update ".tablename("gpb_head_money")." set money=money-{$money} where uid={$uid}");
                                        if($res){
                                            $result = pdo_insert("gpb_head_money_log",$log);
                                            if($result){
                                                pdo_commit();
                                            }else{
                                                pdo_rollback();
                                            }
                                        }else{
                                            pdo_rollback();
                                        }
                                    }

                                }
                            }

                        }
                    }
                }

            }
        }
        if(!empty($_GPC['gbm_id'])){
            echo json_encode(['code'=>0,'msg'=>'处理完成']);
            die;
        }
        return ['code'=>0,'msg'=>'处理完成'];
    }



    /**

     * 佣金变动日志记录

     * $uid int 用户id

     * $money 变动金额

     * $type 变动金额类型

     * $msg 变动信息

     */

    public function moneychangelog($order_code, $uid = 0, $type = 1, $money = 0, $msg = '', $from_type)

    {

        //2020-03-10 保存变动时分佣类型 比例、金额 周龙
        //获取当前分佣配置
        $head_agent_get_type = pdo_fetchcolumn("select `value` from ".tablename($this->config)." where weid={$this->weid} and `key`='head_agent_get_type'");
        $head_parsent = [];
        $head_parsent['lv1'] = pdo_fetchcolumn("select `value` from ".tablename($this->config)." where weid={$this->weid} and `key`='head_agent_lever_one'");
        $head_parsent['lv2'] = pdo_fetchcolumn("select `value` from ".tablename($this->config)." where weid={$this->weid} and `key`='head_agent_lever_two'");
        $head_parsent['lv3'] = pdo_fetchcolumn("select `value` from ".tablename($this->config)." where weid={$this->weid} and `key`='head_agent_lever_three'");

        $parsent = intval($head_agent_get_type)===1?$head_parsent:[];
        $fix = intval($head_agent_get_type)===2?$head_parsent:[];

        $log = [

            'uid' => $uid,

            'info' => $msg,

            'weid' => $this->weid,

            'type' => $type,

            'money' => $money,

            'create_time' => time(),

            'update_time' => time(),

            'type_from' => $from_type,
            'percent'=>serialize($parsent),
            'fiexd'=>serialize($fix),
            'dis_type'=>$head_agent_get_type

        ];

        if (!empty($order_code)) {

            $log['order_code'] = $order_code;

        }

        $res = pdo_insert("gpb_head_money_log", $log);

        return $res ? array('msg' => "日志写入成功", 'code' => 0) : array('msg' => "日志写入失败", 'code' => 1);

    }



    /*

     * 团长的团员消费排行

     */

    public function doPageheadMemberRank()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid) || $openid == 'undefined') {

            $this->result("1", "未授权");

        }

        $rand = rand(0, 100);

        if ($rand > 80) {

            $_GPC['fresh'] = 1;

        }

        $head = pdo_get($this->member, array('m_openid' => $openid));

        if (empty($head)) {

            $this->result("1", "团长信息有误");

        }

        $member_rank = cache_load('head_member_rank_wxapp' . $this->weid . $openid);

        //cache_load有时候莫名奇妙读取出一个空数组  里面有个时间和data

        if (empty($member_rank) || $_GPC['fresh'] == 1 || isset($member_rank['data'])) {

            $member_rank = pdo_fetchall("select sum(gos_real_money) as money,m.m_nickname as `name`,m.m_name,m.m_photo AS img from " . tablename('gpb_order_stream') . " as os left join " . tablename('gpb_member') . " as m on m.m_openid = os.gos_payer_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =" . $this->weid . " and gos_team_openid='" . $openid . "' group by gos_payer_openid  order by money desc ");

            if (is_array($member_rank)) {

                foreach ($member_rank as $k => $v) {

                    $reduce = pdo_fetch("select sum(gos_real_money) as money from  " . tablename('gpb_order_stream') . " as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_payer_openid ='" . $v['gos_team_openid'] . "'  and gos_team_openid='" . $openid . "' group by gos_payer_openid");

                    $after_reduce = floatval($v['money']) - floatval($reduce['money']);

                    if ($after_reduce <= 0) {

                        unset($member_rank['$k']);

                    } else {

                        $member_rank[$k]['money'] = $after_reduce;

                    }

                }

                if (is_array($member_rank)) {

                    $member_rank = array_slice($member_rank, 0, 5);  //获取键值0-5的数组元素

                }

            }

            if (empty($member_rank)) {

                $member_rank = array();

            }

            cache_write('head_member_rank_wxapp' . $this->weid . $openid, $member_rank, 24 * 60 * 60);

        }

        if ($_GPC['t'] == 1) {

            echo "select sum(gos_real_money) as money,m.m_nickname as `name`,m.m_name,m.m_photo AS img from " . tablename('gpb_order_stream') . " as os left join " . tablename('gpb_member') . " as m on m.m_openid = os.gos_payer_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =" . $this->weid . " and gos_team_openid='" . $openid . "' group by gos_payer_openid  order by money desc ";

        }



        if (!empty($member_rank) && !isset($member_rank['data'])) {

            foreach ($member_rank as $k => $v) {

                $member_rank[$k]['ranking'] = $k + 1;

                if($this->check_base64_out_json($v['name'])){

                    $member_rank[$k]['name'] = base64_decode($v['name']);

                }

            }

            $this->result("0", "查询排名成功", $member_rank);

        } else {

            $this->result("1", "暂无排名", $member_rank);

        }

    }



    /*

     * 团长佣金明细

     */

    public function doPageheadCommissionList()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid) || $openid == 'undefined') {

            $this->result("1", "未授权");

        }

        $head = pdo_get($this->member, array('m_openid' => $openid));

        if (empty($head)) {

            $this->result("1", "团长信息有误");

        }

        //分页

        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 10;

        $contion = ' limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;

        $where = '';

        $data = pdo_fetchall("select 
m.m_photo as img,
os.gos_add_time as add_time,
os.gos_go_code as code,
m.m_nickname as  `name`,
gos_real_money as money,
gos_status as `type`,
gos_stream_type as `pay_type`,
gos_type as out_type,
gos_commet as comment  
from " . tablename('gpb_order_stream') . " as os 
left join " . tablename('gpb_member') . " as m on m.m_openid = os.gos_payer_openid 
where gos_stream_type=3 
and gos_real_money >0 
and os.weid =" . $this->weid . " 
and gos_team_openid='" . $openid . $where . "'  
order by gos_id desc " . $contion);

        foreach ($data as &$v) {

            $v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);

            if($this->check_base64_out_json($v['name'])){

                $v['name'] = base64_decode($v['name']);

            }

        }

        if (!empty($data)) {

            $this->result("0", "查询成功", array('data' => $data));

        } else {

            $this->result("1", "查询失败");

        }

    }



    /*

    * 团长提现明细

    */

    public function doPageheadGetCashList()

    {

        global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid) || $openid == 'undefined') {

            $this->result("1", "未授权");

        }

        $head = pdo_get($this->member, array('m_openid' => $openid));

        if (empty($head)) {

            $this->result("1", "团长信息有误");

        }

        //分页

        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 10;

        $contion = ' limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;

        $where = '';

        $data = pdo_fetchall("select m.m_photo as img,os.ggc_update_time as get_time,os.ggc_add_time as add_time,os.ggc_code as code,m.m_nickname as  `name`,ggc_money as money,ggc_pay_type,ggc_type,ggc_content from " . tablename('gpb_get_cash') . " as os left join " . tablename('gpb_member') . " as m on m.m_openid = os.openid where ggc_pay_type<>20 and ggc_money >0 and os.weid =" . $this->weid . " and openid='" . $openid . $where . "'  order by ggc_id desc " . $contion);

		if($data){

	        foreach ($data as &$v) {

	        	if(!empty($v['get_time'])){

					$v['get_time'] = date('Y-m-d H:i:s', $v['get_time']);

	        	}else{

	        		$v['get_time'] = date('Y-m-d H:i:s', $v['add_time']);

	        	}

	            if($this->check_base64_out_json( $v['m_nickname'] )){

	                $v['m_nickname'] = base64_decode( $v['m_nickname'] );

	            }

	        }

		}

        if (!empty($data)) {

            $this->result("0", "查询成功", array('data' => $data));

        } else {

            $this->result("1", "查询失败", array('sql' => "select m.m_photo as img,os.ggc_update_time as get_time,os.ggc_code as code,m.m_nickname as  `name`,ggc_money as money,ggc_pay_type,ggc_type,ggc_content from " . tablename('gpb_get_cash') . " as os left join " . tablename('gpb_member') . " as m on m.m_openid = os.openid where ggc_pay_type<>20 and ggc_money >0 and os.weid =" . $this->weid . " and openid='" . $openid . $where . "'  order by ggc_id desc " . $contion));

        }

    }



    public function doPageMarkrting()

    {

        global $_GPC, $_W;

        if (empty($_GPC['openid'])) {

            $this->result("1", "请传入openid");

        }

        $openid = pdo_fetch(" select m_openid from " . tablename("gpb_member") . " where weid = " . $this->weid . " and m_openid = '" . $_GPC['openid'] . "'");

        if (empty($openid)) {

            $this->result("1", "openid错误");

        }

        $mark = new Markrting();

        $mark->$_GPC['op']();

    }



    public function sc($name = 'markrting_rebate')

    {

        $info = pdo_get("gpb_config", array('key' => $name, 'weid' => $this->weid, 'status' => 1));

        return $info['value'];

    }



    //团长配送清单

    public function doPageGetHeadSendOrderList()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        $member = pdo_get('gpb_member', array('m_openid' => $openid, 'm_is_head' => 2));

        if (empty($member)) {

            $this->result("1", "团长信息有误");

        }

        //分页

        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 10;

        $contion = ' limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;

        $where = '';

        $days = trim($_GPC['days'], ',');

        $type = trim($_GPC['type'], ',');

        $today = strtotime(date('Y-m-d'));

        $tomon = strtotime(date('Y-m'));

        if (!empty($days)) {

            $where .= ' and d.dl_add_time >= ' . strtotime($days) . ' and d.dl_add_time <' . (strtotime($days) + 24 * 60 * 60);

        }

        if ($type == 1) {

            $where .= ' and d.dl_add_time < ' . ($today + 24 * 60 * 60) . ' and d.dl_add_time >=' . ($today - 7 * 24 * 60 * 60);

        } elseif ($type == 2) {

            $where .= ' and d.dl_add_time < ' . ($today + 24 * 60 * 60) . ' and d.dl_add_time >=' . ($today - 30 * 24 * 60 * 60);

        } elseif ($type == 3) {

            $where .= ' and d.dl_add_time < ' . ($tomon - 30 * 24 * 60 * 60) . ' and d.dl_add_time >= ' . ($tomon - 60 * 24 * 60 * 60);

        }



//        $sql = 'SELECT tmp.days,GROUP_CONCAT(tmp.num) as nums,GROUP_CONCAT(tmp.dl_status) as status FROM (SELECT FROM_UNIXTIME(dl_add_time,"%Y-%m-%d") AS days,SUM(d.dl_goods_num) AS num,d.dl_status FROM '.tablename('gpb_distribution_list').' AS d LEFT JOIN '.tablename('gpb_head_route').' AS hr ON hr.ghr_id = d.dl_dr_id WHERE 1 AND d.weid=6 AND hr.ghr_mid =1072 AND  d.dl_status=20 OR d.dl_status=10 GROUP BY days,d.dl_status  ) AS tmp GROUP BY days ORDER BY days DESC'.$contion;

        $sql = 'SELECT tmp.days,GROUP_CONCAT(tmp.num) as nums,GROUP_CONCAT(tmp.dl_status) as `status`,GROUP_CONCAT(tmp.id) as lid  FROM (SELECT FROM_UNIXTIME(dl_add_time,"%Y-%m-%d") AS days,SUM(d.dl_goods_num) AS num,d.dl_status,GROUP_CONCAT(d.`dl_id`) AS id FROM ' . tablename('gpb_distribution_list') . ' AS d LEFT JOIN ' . tablename('gpb_head_route') . ' AS hr ON hr.ghr_id = d.dl_dr_id WHERE 1 AND d.weid=' . $this->weid . ' AND hr.ghr_mid =' . $member['m_id'] . $where . '  GROUP BY days,d.dl_status ORDER BY d.dl_status ASC ) AS tmp where 1  GROUP BY days ORDER BY days DESC' . $contion;

        /*echo $sql;
        die;*/

        $info = pdo_fetchall($sql);

//        var_dump($sql);exit;

        if (empty($info)) {

            $this->result("1", "暂无数据", array('sql' => $sql));

        }

        foreach ($info as $k => $v) {

            $status = explode(',', $v['status']);

            $nums = explode(',', $v['nums']);

            $info[$k]['send_num'] = 0;//已发货

            $info[$k]['no_send_num'] = 0;//未发货

            $info[$k]['get_send_num'] = 0;//已收货

            $info[$k]['all_num'] = 0;//已收货

            foreach ($status as $k_status => $v_status) {

                $info[$k]['all_num'] += $nums[$k_status];

                if ($v_status == 20 || $v_status == 30) {

                    $info[$k]['send_num'] += $nums[$k_status];//已发货

                } elseif ($v_status == 10) {

                    $info[$k]['no_send_num'] += $nums[$k_status];//未发货

                }

                if ($v_status == 30) {

                    $info[$k]['get_send_num'] = $nums[$k_status];//已收货

                }

            }

            $info[$k]['commission'] = 0;

            $info[$k]['money'] = 0;

            //查询订单

            $money_info = pdo_fetch('select sum(sn.oss_commission) as commission,sum(sn.oss_g_price*sn.oss_g_num) as sums from ' . tablename('gpb_order_snapshot') . ' as sn left join ' . tablename('gpb_distribution_list_order') . ' as lo on sn.oss_go_code=lo.go_code where lo.weid=' . $this->weid . ' and lo.l_id in(' . $v['lid'] . ') and sn.oss_ggo_status=1 ');

            if (!empty($money_info)) {

                $info[$k]['commission'] = $money_info['commission'];//佣金 销售额

                $info[$k]['money'] = $money_info['sums'];//佣金 销售额

            }

        }

        $return = array('data' => $info);

        $this->result("0", "查询成功", $return);

    }



    //团长确认收货

    public function doPageHeadSureSendOrderList()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        $member = pdo_get('gpb_member', array('m_openid' => $openid, 'm_is_head' => 2));

        if (empty($member)) {

            $this->result("1", "团长信息有误");

        }

        $lid = trim($_GPC['lid'], ',');

        if (empty($lid)) {

            $this->result("1", "清单有误");

        }

        $aleady_send = pdo_fetchall('select dl_id,dl_go_code from ' . tablename('gpb_distribution_list') . ' where dl_status=20 and dl_id in(' . $lid . ') and weid=' . $this->weid);

        if (empty($aleady_send)) {

            $this->result("1", "未发货无法确认收货");

        }

        $aleady_send_list = '';

        $order_list = '';

        foreach ($aleady_send as $aleady_send_k => $aleady_send_v) {

            if (!empty($aleady_send_v['dl_go_code'])) {

                $order_list .= ',' . $aleady_send_v['dl_go_code'];

                unset($aleady_send['$aleady_send_k']);

            } else {

                $aleady_send_list .= ',' . $aleady_send_v['dl_id'];

            }

        }

        $aleady_send_list = trim($aleady_send_list, ',');

        $order_list = trim($aleady_send_list, ',');

        $send_list_order = pdo_fetchall('select go_code from ' . tablename('gpb_distribution_list_order') . ' where l_id in(' . $aleady_send_list . ')');

        if (!empty($send_list_order)) {

            $send_list_order = array_column($send_list_order, 'go_code');

            $send_list_order = implode(',', $send_list_order);

            $order_list .= ',' . $send_list_order;

        }

        if (empty($aleady_send_list) || empty($order_list)) {

            $this->result("1", "未发货无法确认收货.");

        }

        $order_info = pdo_fetchall('select go_id,go_code,go_real_price,go_comment,prepay_id,go_headget_formid,openid from ' . tablename('gpb_order') . ' where go_status =30 and weid=' . $this->weid . ' and go_code in(' . $order_list . ')');



        //改变状态

        pdo_begin();

        $res = pdo_query('UPDATE ' . tablename('gpb_distribution_list') . ' SET dl_status=30 WHERE dl_id IN(' . $aleady_send_list . ')');

        if (empty($res)) {

            $this->result("1", "确认收货失败");

        }

        pdo_commit();

//        $oder_res = pdo_query('UPDATE '.tablename('gpb_order').' SET dl_status=30 WHERE dl_id IN('.$aleady_send_list.')');

        //发送模板消息

        $sms = new Sms();

        $sms->weid = $this->weid;

        $this->Token();

        if (!empty($order_info)) {

            foreach ($order_info as $order_info_v) {

                $sn = pdo_fetchall('select oss_g_name,oss_g_num,oss_address_name,oss_address_phone from ' . tablename('gpb_order_snapshot') . ' where oss_go_code=' . $order_info_v['go_code'] . ' and oss_ggo_status=1');

                $g_name_str = $sn[0]['oss_g_name'];

                $g_num = 0;

                foreach ($sn as $val) {

//                    $g_name_str .=','.$val['oss_g_name'];

                    $g_num += $val['oss_g_num'];

                }

                if($this->check_base64_out_json( $sn[0]['oss_address_name'])){

                    $sn[0]['oss_address_name'] = base64_decode( $sn[0]['oss_address_name']);

                }

                //依次为:1订单编号,2货物,3数量,4订单金额,5备注,6收货人,7收件人电话

                $sms_array = array('1' => $order_info_v['go_code'], '2' => trim($g_name_str, ','), '3' => $g_num, '4' => $order_info_v['go_real_price'], '5' => '您的货物已到团长处，请及时联系领取', '6' => $sn[0]['oss_address_name'], '7' => $sn[0]['oss_address_phone']);

                $form_id = empty($order_info_v['prepay_id']) ? $order_info_v['go_headget_formid'] : $order_info_v['prepay_id'];

                $dass = $sms->send_out('sms_send_order', $sms_array, $_W['account']['access_tokne'], $order_info_v['openid'], 'pages/order/orderDetail?id=' . $order_info_v['go_id'], $form_id, $sms->weid, 'AT1122');

                //新增订阅消息 周龙 2020-02-27
                $submsg = new \SubMsg();
                $submsg_arr = [
                    $order_info_v['go_code'],
                    trim($g_name_str, ','),
                    $g_num,
                    $order_info_v['go_real_price'],
                    '您的货物已到团长处，请及时联系领取'
                ];
                $submsg->sendmsg("deliver_msg",$order_info_v['openid'],$submsg_arr,'pages/order/orderDetail?id=' . $order_info_v['go_id']);

                $log_content = date('Y-m-d H:i:s') . '，团长确认收货后模版消息日志（HeadSureSendOrderList）' . PHP_EOL;

                if (is_array($dass)) {

                    foreach ($dass as $dass_k => $dass_v) {

                        $log_content .= 'key:' . $dass_k . ',value:' . $dass_v . PHP_EOL;

                    }

                }

//                $log_content .= json_encode(array('sms_template',$sms_array,$_W['account']['access_tokne'],$openid,'pages/order/orderDetail?id='.$order_info_v['go_id'],$order_info_v['go_headget_formid'],$sms->weid,'AT1122'),JSON_UNESCAPED_UNICODE);

                $log_content .= '----------end------------' . PHP_EOL;



                $this->txt_logging_fun('sms_AT1122_log.txt', $log_content);

            }

        }

        $this->result('0', '收货成功');

    }



    //团长收货列表点击后的商品列表

    public function doPageGetHeadSendGoodsList()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", "未授权");

        }

        $member = pdo_get('gpb_member', array('m_openid' => $openid, 'm_is_head' => 2));

        if (empty($member)) {

            $this->result("1", "团长信息有误");

        }

        $lid = trim($_GPC['lid'], ',');

        if (empty($lid)) {

            $this->result("1", "清单有误");

        }

        //查已收货订单

        $order_list = pdo_fetchall('select go_id from ' . tablename('gpb_distribution_list_order') . ' as lo left join ' . tablename('gpb_distribution_list') . ' as l on l.dl_id=lo.l_id  where lo.weid=' . $this->weid . ' and lo.l_id in(' . $lid . ') and (dl_status =10 or dl_status=20)');

        $orders_arr = array_column($order_list, 'go_id');

        $orders_str = implode(',', $orders_arr);

        $info = array();

        if (!empty($orders_str)) {

            $sql = 'select sum(o.oss_g_num) as num,g.g_name,g.g_icon,o.oss_ggo_title,sum(o.oss_g_num*o.oss_g_price) as moneys  from ' . tablename('gpb_order_snapshot') . ' as o  join ' . tablename('gpb_member') . ' as m on m.m_openid=o.oss_head_openid join ' . tablename('gpb_order') . ' as go on go.go_code=o.oss_go_code left join ' . tablename('gpb_goods') . ' as g on g.g_id=o.oss_gid where 1 and go.weid=' . $this->weid . ' and o.oss_ggo_status=1 and go.go_id in(' . $orders_str . ')  group by g.g_id,o.oss_ggo_id order by go_status asc';

            $info = pdo_fetchall($sql);

            foreach ($info as &$v) {

                $v['g_icon'] = tomedia($v['g_icon']);

            }

        }



        //未收货订单

        $order_lists = pdo_fetchall('select go_id from ' . tablename('gpb_distribution_list_order') . ' as lo left join ' . tablename('gpb_distribution_list') . ' as l on l.dl_id=lo.l_id  where lo.weid=' . $this->weid . ' and lo.l_id in(' . $lid . ') and (dl_status =30)');

        $orders_arrs = array_column($order_lists, 'go_id');

        $orders_strs = implode(',', $orders_arrs);

        $infos = array();

        if (!empty($orders_strs)) {

            $sqls = 'select sum(o.oss_g_num) as num,g.g_name,g.g_icon,o.oss_ggo_title,sum(o.oss_g_num*o.oss_g_price) as moneys from ' . tablename('gpb_order_snapshot') . ' as o  join ' . tablename('gpb_member') . ' as m on m.m_openid=o.oss_head_openid join ' . tablename('gpb_order') . ' as go on go.go_code=o.oss_go_code left join ' . tablename('gpb_goods') . ' as g on g.g_id=o.oss_gid where 1 and go.weid=' . $this->weid . ' and o.oss_ggo_status=1 and go.go_id in(' . $orders_strs . ')  group by g.g_id,o.oss_ggo_id order by go_status asc';

            $infos = pdo_fetchall($sqls);

            foreach ($infos as &$v) {

                $v['g_icon'] = tomedia($v['g_icon']);

            }

        }

        $return = array('data' => $infos, 'data_no_get' => $info);

        $this->result("0", "查询成功", $return);

    }

    /*

     * 存文本日志的函数

     *  string $filename 文件名

     *  string $content 日志文本

     */

    public function txt_logging_fun($filename, $content)
    {
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



    public function doPagePlsugins()

    {

        global $_GPC, $_W;

        $op = $_GPC['op'];

        $in = $_GPC['in'];

//		$openid = $_GPC['openid'];

//		if(empty($openid)){

//			$this->result("1",'请传入用户标识');

//		}

        if (empty($op)) {

            $this->result("1", '不知道你要进入那个插件');

        }

        $in = empty($in) ? 'index' : $in;

        require_once '../addons/group_buy/inc/plsugins/wxapp/' . $op . ".php";

        $plsugins = new $op();

        $plsugins->$in();

    }



    //获取当前公众号授权

//    public function doPageH5authorization()

//    {

//        global $_GPC, $_W;

//        $openid = trim($_GPC['openid']);

//        if (empty($openid)) {

//            $this->result("1", '未授权');

//        }

//        $member = pdo_get('gpb_member', array('m_openid' => $openid));

//        if (empty($member)) {

//            $this->result("1", '用户有误');

//        }

//        $url = $this->createMobileUrl('index');

//        $url = trim($url, '.');

//        $return = array(

//            'src' => 'https://' . $_SERVER['SERVER_NAME'] . '/app' . $url,

//            'member' => $member,

//        );

//        $this->result("0", '获取成功', $return);

//    }



    //团长收货后才显示的自提和配送信息

    public function doPageAfterHeadgetGoodsList()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", '未授权');

        }

        $member = pdo_get('gpb_member', array('m_openid' => $openid));

        if (empty($member)) {

            $this->result("1", '用户有误');

        }



        $where = " and go_status =30 ";

        $type = trim($_GPC['type']);

        $type = empty($type) ? 1 : $type;

        if (!empty($type)) {

            $where .= " and go_send_type=" . $type;

        }

        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 10;

        $contion = 'limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;



        $sql = 'select o.* from ' . tablename('gpb_order') . ' as o left join ' . tablename('gpb_distribution_list_order') . ' as dlo on dlo.go_id =o.go_id left join ' . tablename('gpb_distribution_list') . ' as dl on dl.dl_id = dlo.l_id where 1 and o.weid=' . $this->weid . $where . ' and o.go_team_openid= "' . $openid . '" and (o.`type`=1) and o.go_is_del = 1 and dl.dl_status=30 order by go_add_time desc ' . $contion;



        $list = pdo_fetchall($sql);

        if (!empty($list)) {

            foreach ($list as $k => $v) {

                $info = pdo_fetchall(" select a.*,m.m_photo from " . tablename($this->member) . " as m join " . tablename($this->snapshot) . " as a on m.m_openid = a.oss_head_openid where m.weid = " . $this->weid . " and a.oss_go_code = '" . $v['go_code'] . "'");



//                $info = pdo_getall($this->snapshot,array('oss_go_code = '.$v['go_code']));

                if (!empty(($info))) {

                    $money = 0;

                    foreach ($info as $i => $j) {

//                        $info[$i]['oss_g_icon'] = $this->http.$j['oss_g_icon'];

                        $info[$i]['oss_g_icon'] = tomedia($j['oss_g_icon']);

                        $ins = $j['oss_g_num'] * $j['oss_g_price'];

                        $money += $ins;

                        if(!empty($j['m_nickname']) && $this->check_base64_out_json( $j['m_nickname'] )){

                            $info[$i]['m_nickname'] = base64_decode( $j['m_nickname'] );

                        }

                        if(!empty($j['oss_address_name']) && $this->check_base64_out_json( $j['oss_address_name'] )){

                            $info[$i]['oss_address_name'] = base64_decode( $j['oss_address_name'] );

                        }

                    }

                }

                $list[$k]['go_add_time'] = date("Y-m-d H:i", $v['go_add_time']);

                $list[$k]['item_goods'] = $info;

                $list[$k]['oss_head_name'] = $info[0]['oss_head_name'];

                $list[$k]['oss_head_phone'] = $info[0]['oss_head_phone'];

                $list[$k]['m_photo'] = $info[0]['m_photo'];

                $list[$k]['oss_v_name'] = $info[0]['oss_v_name'];

                $list[$k]['total_money'] = $money;

                $list[$k]['number'] = count($info);

            }

        }

        if (empty($list)) {

            $this->result("1", "查询订单失败，请重试", $sql);

        } else {

            $this->result("0", "查询订单成功", $list);

        }

    }

	/**

	 * 发送公众号消息

	 */

	public function doPageIso(){

		$s = $this->pay_success_send_official_account_msg('08091052658327104');

		echo '<pre>';

		var_dump($a);exit;

	}

    /*

     * 支付成功发公众号的方法

     * param str $code 订单code

     */

    public function pay_success_send_official_account_msg($code)

    {

        //订单情况

        $order = pdo_get('gpb_order', array('go_code' => $code, 'weid' => $this->weid));

        $sn = pdo_getall('gpb_order_snapshot', array('oss_go_code' => $order['go_code'], 'oss_ggo_status' => 1));

        //@param $key 发送那个模板消息

        $key = 'wechat_deliver_pay';

        //模块

        $weid = $this->weid;

        //团长的openid

        $openid = $order['go_team_openid'];

        //买家姓名

        $buyname = empty($sn[0]['oss_buy_name']) ? $sn[0]['oss_address_name'] : $sn[0]['oss_buy_name'];

        if($this->check_base64_out_json($buyname)){

            $buyname = base64_decode($buyname);

        }

       /* $data = array(

            'first' => array('value' => '团长您好！用户(' . $buyname . ')在您处下单，请密切关注'),

            'keyword1' => array('value' => $order['go_code']),

            'keyword2' => array('value' => $sn[0]['oss_g_name'] . '...'),

            'keyword3' => array('value' => $order['go_real_price']),

            'keyword4' => array('value' => '已支付'),

            'keyword5' => array('value' => date('Y-m-d H:i:s', $order['go_add_time'])),

            'remark' => array('value' => '有任何问题请联系管理员！')

        );

        $href = 'pages/groupCenter/groupOrders';

        $sms = new Sms();

        $res = $sms->public_address_template($key, $weid, $openid, $data, $href);*/

        //2020-03-02 周龙 使用新的公众号模板消息
        $subwechat = new \SubWechat();
        $wechat_arr = [
            '团长您好！用户(' . $buyname . ')在您处下单，请密切关注',
            $order['go_code'],
            $sn[0]['oss_g_name'] . '...',
            $order['go_real_price'],
            '已支付',
            date('Y-m-d H:i:s', $order['go_add_time']),
            '有任何问题请联系管理员！'
        ];
        $subwechat->sendunimsg('tmp_leader',$openid,$wechat_arr,'','pages/groupCenter/groupOrders');



        $log_content = date('Y-m-d H:i:s') . '，支付成功发公众号模版消息日志' . PHP_EOL;

        if (is_array($res)) {

            foreach ($res as $dass_k => $dass_v) {

                $log_content .= 'key:' . $dass_k . ',value:' . $dass_v . PHP_EOL;

            }

        }

        $log_content .= 'code:' . $code . PHP_EOL;

        $log_content .= 'openid:' . $openid . PHP_EOL;

        $log_content .= '----------end------------\n' . PHP_EOL;

        $this->txt_logging_fun('official_account_' . $key . '_log.txt', $log_content);

		return $buyname;

    }



    /*

     * 查询内容文章

     */

    public function doPageGetContentArticle()

    {

        global $_GPC, $_W;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result("1", '未授权');

        }

        $member = pdo_get('gpb_member', array('m_openid' => $openid));

        if (empty($member)) {

            $this->result("1", '用户有误');

        }

        $cid = trim($_GPC['cid']);

        if (empty($openid)) {

            $this->result("1", '查询失败');

        }

        $where = '';

        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 20;

        $contion = 'limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;



        $sql = 'select a.*,ac.title as classname from ' . tablename('gpb_article') . ' as a left join ' . tablename('gpb_article_class') . ' as ac on ac.id =a.pid where 1 and a.weid=' . $this->weid . $where . ' and a.pid=' . $cid . ' and a.status=1 and a.is_del=1 and ac.status=1 and ac.is_del=1 order by a.sort asc,a.createtime desc ' . $contion;



        $list = pdo_fetchall($sql);



        if (empty($list)) {

            $this->result("1", "查询订单失败，请重试", $sql);

        } else {

            $this->result("0", "查询订单成功", $list);

        }

    }

    public function doPagexxx(){

//        $res = $this->virtualRandomDivInt(1000,800,1,3);

//        $sum = array_sum($res);

//        var_dump($res);var_dump($sum);

//        shuffle($res);

//        var_dump($res);



        var_dump("select * from ".tablename('gpb_order_stream')." as os left join ".tablename('gpb_order')." as o on o.go_code=os.gos_go_code where gos_stream_type=3 and gos_status=2 and go_is_cash=-1");

        exit;

    }

    /*

     * $total int 待划分的数字

     * $div     int 分成的份数

     * $area    int 各份数间允许的最大差值

     *(废弃)

     */

//    public function virtualRandomDivInt($total, $div,$min,$max,$arr=array())

//    {

//        $total_money= $total;

//        $total_num = $div;

//        if($min<1){

//            $min = 1;

//        }

//        if($max<1){

//            $max = 1;

//        }

//        if(empty($arr)){

//            for($i=0;$i<$total_num;$i++){

//                if($total_money<$min){

//                    $data[$i]= $total_money;

//                }else{

//                    $data[$i]= $min;

//                }

//                $total_money -= $data[$i];

//                if($total_money<=0){

//                    return $data;

//                }

//                if($total_money>0){

//                    if($i==($total_num-1)){

//                        $data =  $this->virtualRandomDivInt($total_money,$total_num,$min,$max,$data);

//                    }

//                }

//            }

//        }else{

//            foreach ($arr as $k =>$v){

//                if($total_money<$min){

//                    $arr[$k] += $total_money;

//                    $reduce = $total_money;

//                }else{

//                    $arr[$k] += $min;

//                    $reduce = $min;

//                }

//                $total_money -= $reduce;

//                if($total_money<=0){

//                    return $arr;

//                }

//                if($total_money>0){

//                    if($k==($total_num-1)){

//                       $data =  $this->virtualRandomDivInt($total_money,$total_num,$min,$max,$arr);

//                    }

//                }

//            }

//        }

//        return $data;

//    }



    /*

     * 生成虚拟销量数据（废弃）

     */

//    private function generate_virtual_sales_data($gid){

//        if(empty($gid)){

//            return;

//        }

//        //查所有  虚拟+实际

//        $goods = pdo_fetch("select (g.g_sale_num+sale_num) as `all`,g.* from " . tablename('gpb_goods') . " as g left join " . tablename('gpb_goods_stock') . " as s on s.goods_id=g.g_id where g.g_id=" . $gid);

//        $all_num = empty($goods['all']) ? 0 : $goods['all'];

//        $start_time = $goods['g_add_time'];

//        //查所有  实际

////        $all_real_info = pdo_fetchall("select m.m_openid,sum(oss_g_num) as real_num from " . tablename($this->snapshot) . " as s left join " . tablename($this->member) . " as m on m.m_openid =s.oss_buy_openid left join " . tablename($this->order) . " as go on s.oss_go_code = go.go_code where m.weid=" . $this->weid . " and go.`type`=1 and s.oss_gid =" . $gid . " and go.go_pay_time >0 group by m_openid");

////        $all_real_num = 0;

////        if (!empty($all_real_info)) {

////            $all_real_num = array_sum(array_column($all_real_info, 'real_num'));

////        }

////        $all_real_num = empty($all_real_num['real_num']) ? 0 : $all_real_num['real_num'];

//        //虚拟

//        $not_real_num = intval($goods['g_sale_num']);

//

//        if ($not_real_num > 0) {

//            $virtual_num = pdo_fetchcolumn("select sum(virtual_sale)  from " . tablename('gpb_activity_plugin_virtual_buy_list') . " where weid=" . $this->weid . " and gid=" . $gid);

//            if (empty($virtual_num) || $virtual_num == 0 || $not_real_num - $virtual_num > 0) {

//                //需要虚拟的数量为：

//                $need_virtual_num = intval($not_real_num - $virtual_num);

//                if($need_virtual_num<0){

//                    pdo_delete('gpb_activity_plugin_virtual_buy_list',array('gid'=>$gid));

//                    $need_virtual_num = $not_real_num;

//                }

//

////                if ($need_virtual_num <= 100) {

////                    $div = rand(1, 25);

////                    $div = $div > $need_virtual_num ? $need_virtual_num : $div;

////

////                } elseif ($need_virtual_num > 100 && $need_virtual_num <= 1000) {

////                    $div = rand(50, 100);

////                    $div = $div > $need_virtual_num ? $need_virtual_num : $div;

////                }

//                $div = intval($goods['g_virtual_people']);

////                $difference = (intval($goods['g_virtual_max_buy'])-intval($goods['g_virtual_min_buy']));

//                $min = intval($goods['g_virtual_min_buy']);

//                $max = intval($goods['g_virtual_max_buy']);

//                $virtual_random_arr = $this->virtualRandomDivInt($need_virtual_num, $div,$min,$max);

//                if(is_array($virtual_random_arr)){

//                    shuffle($virtual_random_arr);

//                }

////                $final_num = $need_virtual_num-array_sum($virtual_random_arr);

////                foreach ($virtual_random_arr as $key=>$val){

////                    if($final_num>0 && $val>0){

////                        $virtual_random_arr[$key] = $val+$final_num;

////                        break;

////                    }

////                    if($final_num<0 && $val>0){

////                        $virtual_random_arr[$key] = ($val-$final_num)>0?($val-$final_num):0;

////                        $final_num = ($final_num+$val)>0?0:($final_num+$val);

////                    }

////                    if($final_num==0){

////                        break;

////                    }

////                }

//                $rand_arr = pdo_fetchall("SELECT t1.* FROM " . tablename('gpb_activity_plugin_virtual_users') . " AS t1 JOIN (SELECT ROUND(RAND() * ( (SELECT MAX(uid) FROM " . tablename('gpb_activity_plugin_virtual_users') . "  )-(SELECT MIN(uid) FROM " . tablename('gpb_activity_plugin_virtual_users') . "  ))+(SELECT MIN(uid) FROM " . tablename('gpb_activity_plugin_virtual_users') . "  )) AS uid) AS t2 WHERE t1.uid >= t2.uid ORDER BY t1.uid LIMIT ".$div);

//                foreach ($rand_arr as $rand_arr_k => $rand_arr_v){

//                    $old_virtual_buy = pdo_get('gpb_activity_plugin_virtual_buy_list',array('virtual_uid'=>$rand_arr_v['uid'],'gid'=>$gid));

//                    if(empty($old_virtual_buy) && $virtual_random_arr[$rand_arr_k]>0){

//                        $data_save = array(

//                            'form'=>1,

//                            'virtual_sale'=>$virtual_random_arr[$rand_arr_k],

//                            'addtime'=>time(),

//                            'gid'=>$gid,

//                            'virtual_buytime'=>rand($start_time,time()),

//                            'virtual_uid'=>$rand_arr_v['uid'],

//                            'weid'=>$this->weid

//                        );

//                        pdo_insert('gpb_activity_plugin_virtual_buy_list',$data_save);

//                    }else{

//                        $data_save = array(

//                            'virtual_sale +='=>$virtual_random_arr[$rand_arr_k],

//                            'virtual_buytime'=>rand($start_time,time()),

//                        );

//                        pdo_update('gpb_activity_plugin_virtual_buy_list',$data_save,array('id'=>$old_virtual_buy['id']));

//                    }

//                }

//            }

//        }

//        return;

//    }

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



    /*

     * 用户自己确认收货

     */

    public function doPageheadSureGoods(){

        global $_GPC, $_W;

        $id = trim($_GPC['id'],',');

        $ids = explode(",",$id);

        $openid = $_GPC['openid'];

        if (empty($openid)) {

            $this->result(1, '用户未授权');

        }

        $head = pdo_get('gpb_member', array('m_openid' => $openid));

        if (empty($head)) {

            $this->result(1, '用户有误');

        }

        if($_GPC['type']=='all'){

        	//全部待收货的确认收货

        	$all_order = pdo_fetchall("select * from ".tablename($this->order)." where go_status=30 and `type`=1 and weid=".$this->weid." and go_team_openid ='".$openid."'");

        	$ids = array_column($all_order,'go_id');

        }else{

        	$ids = explode(",",$id);

        }

 		if(is_array($ids) && !empty($ids)){

        	pdo_begin();

        	foreach($ids as $ids_k => $ids_v){

        		//获取订单信息

		        $info = pdo_get($this->order, array('go_id' => $ids_v, 'weid' => $this->weid, 'type' => 1));

		        //获取订单信息

        		if($_GPC['type']=='all'){

		        	//全部待收货的确认收货

		        	$info = $all_order[$ids_k];

		        }else{

		        	$info = pdo_get($this->order, array('go_id' => $ids_v, 'weid' => $this->weid, 'type' => 1));

		        }

		        if (empty($info)) {

		            continue;

		        }

		        if ($info['go_status'] != 30) {

		            continue;

		        }

		        $user = pdo_get('gpb_member', array('m_openid' => $info['openid']));

		        //查找商品快照表,计算总佣金

		        $snapshot_list = pdo_fetchall("select * from " . tablename($this->snapshot) . " as sn where sn.oss_go_code =" . $info['go_code'] . " ");

		        $go_commission = 0;

		        foreach ($snapshot_list as $key => $val) {

		            $go_commission += floatval($val['oss_commission']);

		        }

		//        $team = pdo_get($this->member,array('m_openid'=>$info['go_team_openid'],"weid"=>$this->weid));

		//        $parsent = $team['m_commission']/100;//佣金比例

		//        $go_commission = $parsent*$info['go_real_price'];

		//        $go_commission_num = $parsent*100;

		        $head_price = '';

		        if ($info['go_send_type'] == 2) {

		            $head_price .= ',go_send_price_status=2';

		        }

		        $sql = "update " . tablename($this->order) . " set `go_status` = '100' , `go_commission` = '" . $go_commission . "',`go_commission_num`=0,go_commission_time=" . time() . $head_price . " where weid=" . $this->weid . " and `type`=1 and `go_id`=" . $info['go_id'];

		        $res = pdo_query($sql);



		        pdo_update($this->member, array('m_send_price_total' => (floatval($info['go_send_pay']) + floatval($user['m_send_price_total'])), 'm_money' => (floatval($user['m_money']) + floatval($info['go_send_pay']))), array('m_id' => $user['m_id']));

		        //生成流水表-佣金

		        $order_snapshot = pdo_fetchall("select * from " . tablename($this->snapshot) . " where oss_go_code =" . $info['go_code']);

		        $data_stream = array(

		            'gos_code' => date('Ymd', time()) . $this->nextId(),//流水号

		            'gos_go_code' => $info['go_code'],//订单号

		            'gos_stream_type' => 3,

		            'gos_type' => 2,

		            'gos_pay_type' => 1,

		            'gos_owner' => '平台',

		            'gos_payer' => $order_snapshot[0]['oss_buy_name'],

		            'gos_team' => $order_snapshot[0]['oss_head_name'],

		            'gos_commet' => '团长操作确认收货产生佣金',

		            'gos_order_money' => $go_commission,

		            'gos_real_money' => 0,

		            'gos_sure_pay_time' => time(),

		            'gos_status' => 1,

		            'gos_add_time' => time(),

		            'weid' => $this->weid,

		            'gos_payer_openid' => $order_snapshot[0]['oss_buy_openid'],

		            'gos_team_openid' => $order_snapshot[0]['oss_head_openid']

		        );

		        //开启自动审核佣金后

		        $auto_sure_head_commission = pdo_get($this->config, array('key' => 'auto_sure_head_commission', 'weid' => $this->weid));

		        $auto_sure_head_commission = isset($auto_sure_head_commission['value']) ? $auto_sure_head_commission['value'] : 2;

		        if ($auto_sure_head_commission == 1) {

		            $data_stream['gos_real_money'] = $go_commission;

		            $data_stream['gos_status'] = 2;

		            $data_stream['gos_commet'] = '团长操作确认收货产生佣金,自动审核通过该佣金';

		            $data_stream['gos_sure_pay_time'] = time();



		            //订单佣金自动审核

		            pdo_update('gpb_order', array('go_is_cash' => 1), array('go_id' => $info['go_id']));

		            pdo_update($this->member, array('m_money +=' => $go_commission), array('m_openid' => $info['go_team_openid'], 'weid' => $this->weid));

		        }

				$i = pdo_fetch(" select * from ".tablename("gpb_order_stream")." where gos_stream_type = 3 and  gos_go_code = ".$info['go_code']);

		        if(empty($i)){

			        pdo_insert($this->stream, $data_stream);

		        }
                if(!empty(WeUtility::createModuleHook("group_buy_plugin_distribution"))) {
                    //分销佣金计算

                    $distribution = pdo_get($this->config, ['weid' => $this->weid, 'key' => 'distribution_state']);

                    if (!empty($distribution) && $distribution['value'] == 1) {

                        //存在并开启qdis

                        @$resutl = $this->doPageDistribution_user_cost(['osn' => $info['go_code']]);

                        @$resutl = $this->doPageDistribution_commoneds(['openid' => $openid, 'go_code' => $info["go_code"]]);

                //					pdo_insert("gpb_distribution_money_log",array('info'=>$resutl));

                //					userSureGoods

                        //            echo "<pre/>";

                        //            exit(var_dump($resutl));

                    }
                }
		        //团长推荐分销

		        $resutl_log = $this->headcost($info['go_code']);

		        //存日志

		        $file = dirname(__FILE__) . '/headrecommedmomey.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个

		        if (file_exists($file) && filesize($file) > 100000) {

		            unlink($file);//这里是直接删除，

		        }

		        $content = date('Y-m-d H:i:s');

		        $content .= "用户自己确认收货后团长算佣金,oid={$info['go_code']}\n";

		        foreach ($resutl_log as $k => $v) {

		            $content .= "{$k}={$v}\n";

		            if ($k == 'data') {

		                foreach ($resutl_log[$k] as $kk => $vv) {

		                    $content .= "{$kk}={$vv}\n";

		                }

		            }



		        }

		        $content .= "------\n";

		        file_put_contents($file, $content . PHP_EOL, FILE_APPEND);

        	}

        	pdo_commit();

			if(is_array($ids) && !empty($ids)){

        		foreach($ids as $ids_k => $ids_v){

					if(file_exists("../addons/group_buy_plugin_fraction")){

						$info = pdo_fetch("select go_code from ".tablename('gpb_order').' where go_id = '.$ids_v." and weid = ".$this->weid." and type = 1");

						@$this->doPageFraction_order_Detailed(array('order' => $info["go_code"]));

					}

				}

			}

//			echo '<pre>';print_r($ids);exit;

        	if (empty($res)) {
	            $this->result(1, '确认收货失败', []);
	        } else {
	            $this->result(0, '确认收货成功', []);
	        }
        }else{
	         $this->result(1, '确认收货失败', []);
        }
    }
    /**
	 * 获取模板消息接口
	 */
	public function doPageTempalte_ID(){
		global $_W,$_GPC;
		if(time() < 1578585600){
			$this->result(0,'',[]);
		}
		$info = pdo_getall($this->config,['status'=>1,'type'=>18,'weid'=>$_W['uniacid']]);
		if($info){
			$data = [];
			foreach($info as $k=>$v){
				if($v['key'] == 'wechat_order_payment_template' || $v['key'] == 'wechat_application_for_the_regimental_commander_' || $v['key'] == 'wechat_cash_withdrawal' || $v['key'] == 'wechat_refund' || $v['key'] == 'wechat_order_cancellation' || $v['key'] == 'wechat_delivery_notice' || $v['key'] == 'wechat_recharge' || $v['key'] == 'wechat_membership_card' || $v['key'] == 'wechat_bargain' || $v['key'] == 'wechat_team_success' || $v['key'] == 'wechat_team_error'){
					$data[$v['key']] = $v['value'];
				}
			}
		}
		$info = $data;
		$this->result(0,'',$info);
	}
	/**
	 * 判断是否选择了团长
	 */
	public function doPagehead_openid(){
		global $_W,$_GPC;
		$openid = $_GPC['openid'];
		$info = pdo_get("gpb_member",array('m_openid'=>$openid),array('m_head_openid','m_nickname','m_photo'));

		if(empty($info['m_head_openid'])){
			$this->result(0,'暂无团长',array('code'=>1,'head'=>1));
		}
		if(empty($info) || empty($info['m_nickname']) || empty($info['m_nickname'])){
			$this->result(0,'暂无授权',array('code'=>1,'head'=>0));
		}
		$this->result(0,'成功',array('code'=>0,'head'=>0));
	}
	/**
	 * 获取积分抵扣设置
	 */
	public function dodeduction(){
		global $_W;
		$info = pdo_getall($this->config,['status'=>1,'type'=>29,'weid'=>$this->weid]);
		if($info){
			$data = [];
			foreach($info as $k=>$v){
				$data[$v['key']] = $v['value'];
			}
		}
		$info = $data;
		if($info['dedu'] != 1){
			return false;
		}else{
			return $info;
		}
	}

	/**
	 * 获取团长送货配送时间
	 */
	public function delivery(){
		global $_W;
		//获取配置
		$info = pdo_getall($this->config,['status'=>1,'type'=>30,'weid'=>$this->weid]);
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
			if(empty($arr)){
				$date_time[0]['time'] = date('m-d',time()+86400);
				$date_time[0]['value'] = $str;
			}else{
				$date_time[1]['time'] = date('m-d',time()+86400);
				$date_time[1]['value'] = $str;
			}
		}
		$data['delivery_time'] = $date_time;
		return $data;
	}
	/**
	 *
	 * 截单计算
	 * @param $type 类型 1直接断点返回信息  3 截单返回true ，没截单返回false
	 * @param $openid string 用户openid 判断当前用户的团长是否截单
	 * @param $arrs int 判断是否返回截单信息
	 */
	public function custting_order_time($type=1,$openid='',$arrs = ''){
		global $_W;
		$I = 1;
//		1.是不显示商品2.是显示
		$cutting_order = pdo_get("gpb_config",array('key'=>'cutting_order','weid'=>$this->weid),array('value'));
		if($cutting_order['value'] != 1){
			$I = 2;
		} else {
			$cutting_order_time = pdo_get("gpb_config",array('key'=>'cutting_order_time','weid'=>$this->weid),array('value'));
			if($type == 2) {
				return unserialize($cutting_order_time['value']);
			}
			$times = unserialize($cutting_order_time['value']);
			$time = time();
			$star_time = strtotime(date("Y-m-d ".$times['star_time'],time()));//截单开始时间
			$end_time_1 = strtotime(date("Y-m-d ".$times['end_time'],time()));//截单开始时间
			if($end_time_1 < $star_time){
				$end_time_1 += 86400;
			}
			if($star_time <= $time && $time <= $end_time_1 ){
				$cutting_info = pdo_get("gpb_config",array('key'=>'cutting_info','weid'=>$this->weid),array('value'));
				if($type == 3) {
					$I = 1;//已截单
				}else{
					if($arrs == 1){
						//返回错误信息
						return ['code'=>1,'msg'=>$cutting_info['value']];
					} else {
						$this->result(1,$cutting_info['value']);
					}
				}
			}else{
				$I = 2;
			}
		}
		if($I == 2){
			if($openid){
				$member = pdo_get("gpb_member",array('m_openid'=>$openid),array('m_head_openid'));
				$close = pdo_get("gpb_member",array('m_openid'=>$member['m_head_openid']),array('closes','reason'));
				if($close['closes'] == 2){
					if($type == 3){
						if($arrs == 1){
							$msg = $close['reason'] ? $close['reason'] : '无';
							return ['code'=>2,'msg'=>"该团长已经停止接单,原因:".$close['reason']];
						} else {
							return true;
						}
					} else {
						$msg = $close['reason'] ? $close['reason'] : '无';
						if($arrs == 1){
							//返回错误信息
							return ['code'=>2,'msg'=>"该团长已经停止接单,原因:".$close['reason']];
						} else {
							$this->result(1,"该团长已经停止接单,原因:".$close['reason']);
						}
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		}else{
			//已截单
			if($arrs == 1){
				//返回错误信息
				return ['code'=>1,'msg'=>$cutting_info['value']];
			} else {
				return true;
			}
		}
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
	 * 异步curl
	 */
	public function doPageY_curl(){
		global $_W,$_GPC;
		include_once '../addons/group_buy/api/subscribe/api.php';//微信订阅消息
		$sub = new subscribe();
		$this->Token();
		$sub->access_token = $_W['account']['access_tokne'];
		$sub->weid = $this->weid;
		$data = $sub->send();
		var_dump($data);
		exit;
	}
	/**
	 * 文件锁
	 */
	public function lock_un($filename=''){
		if(empty($filename)){
			return false;
		}
		$file_block = "../addons/group_buy/block/".$filename.".txt";
		if(file_exists($file_block)){

		}else{

		}
	}



//	/**
//	 * 异步执行函数
//	 * @param $url 请求地址
//	 * @param $param 请求参数
//	 * @param $bodyData 请求参数
//	 * @param $timeout 时间
//	 */
//	private function syncRequest($url, $param=array(),$bodyData="",$timeout =10){
//		$urlParmas = parse_url($url);
//      $host = $urlParmas['host'];
//      $path = $urlParmas['path'];
//		if($urlParmas['query']){
//			$path .= "?".$urlParmas['query'];
//		}
//      $scheme = $urlParmas['scheme'];
//      $port = isset($urlParmas['port'])? $urlParmas['port'] :80;
//      $errno = 0;
//      $errstr = '';
//      if($scheme == 'https') {
//          $host = 'ssl://'.$host;
//      }
////		echo $host;exit;
//      $fp = fsockopen($host, $port, $errno, $errstr, $timeout);
//      stream_set_blocking($fp,true);//开启了手册上说的非阻塞模式
//      if($param){
//	        $query = isset($param)? http_build_query($param) : '';
//      } else {
//      	$query = '';
//      }
//      //如果传递参数在body中,则使用
//      if(!empty($postData)) $query = $postData;
//      $out = "PUT ".$path." HTTP/1.1\r\n";
//      $out .= "host:".$host."\r\n";
//      $out .= "content-length:".strlen($query)."\r\n";
//      //传递参数为url=?p1=1&p2=2的方式,使用application/x-www-form-urlencoded方式
//      //$out .= "content-type:application/x-www-form-urlencoded\r\n";
//      //传递参数为json字符串的方式,并且在请求体的body中,使用application/json
//      $out .= "content-type:application/json\r\n";
//      $out .= "connection:close\r\n\r\n";
//      $out .= $query;
//      fputs($fp, $out);
//      //usleep(1000); // 这一句也是关键，如果没有这延时，可能在nginx服务器上就无法执行成功
//      $result = "";
//      /*
//      //获取返回结果, 如果不循环接收返回值,请求发出后直接关闭连接, 则为异步请求
//      while(!feof($fp)) {
//          $result .= fgets($fp, 1024);
//      }*/
//      //print_r($result);
//      fclose($fp);
//	}
//	public function doPageIn(){
//		$port = $_SERVER["SERVER_PORT"];//获取当前端口
//		if($port == 443){
//
//			return FALSE;
//		}else{
//			$this->syncRequest($url,"",'');
//		}
//		return true;
//	}
}

?>

