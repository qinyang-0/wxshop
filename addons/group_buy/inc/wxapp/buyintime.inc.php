<?php
global $_W, $_GPC;
$openid = trim($_GPC['openid']);
$num = trim($_GPC['num']);
$price = trim($_GPC['price']);
$gid = trim($_GPC['gid']);
$at_id = trim($_GPC['at_id']);
$ggo_id = trim($_GPC['ggo_id']);
$ggo_title = trim($_GPC['ggo_title']);
$lat = $_GPC['lat'];//纬度
$lng = $_GPC['lng'];//经度
$goods = pdo_fetch("select * from " . tablename($this->goods) . " as g where g_id = " . $gid . " and (g.`type`<>2 or g.`type` is null) and weid =" . $this->weid);
$member = pdo_get("gpb_member",array('m_openid'=>$openid));
if (!empty($goods['g_limit_num']) and $num > $goods['g_limit_num']) {
    $this->result("1", "添加失败，商品单次购买限制数量为" . $goods['g_limit_num']);
}
if (empty($openid)) {
    $this->result("1", "未传入用户数据");
}
if (empty($gid)) {
    $this->result("1", "未传入商品数据");
}
if (empty($num)) {
    $this->result("1", "未传入商品数量");
}
if (!isset($price)) {
    $this->result("1", "未传入商品价格");
}
if (!empty($at_id)) {
    $at = pdo_get($this->action, array('at_id' => $at_id, 'weid' => $this->weid));
}
if (!empty($ggo_id)) {
    $ggo = pdo_get($this->goods_option, array('ggo_id' => $ggo_id, 'weid' => $this->weid));
}

$sql = "select * from " . tablename($this->goods) . " as g where g.weid =" . $this->weid . " and (g.`type`<>2 or g.`type` is null) and g_id=" . $gid;

$res = pdo_fetch($sql);

$res["arrival_time"] = "";

if (!empty($at)) {

    if (!empty($at['at_arrival_time']) && $at['at_arrival_time'] > 0) {

        $res["arrival_time"] = date("m月d日", (time() + ($at["at_arrival_time"] * 24 * 60 * 60)));

    }

}

if (empty($res)) {

    $this->result("1", "商品不存在");

} else {

	//获取会员价格

	if($res['member_card_discount'] != 1 && $member['level'] && !empty($res['member_card_discount'])){

		if($res['member_card_discount'] == 2){

			$unified = pdo_get("gpb_goods_dicount_unified",array('goods_id'=>$res['g_id'],'card'=>$member['level'],'weid'=>$this->weid));

			if($unified['price']){

				$res['g_price'] = $unified['price']/100;

			}else{

				$res['member_card_discount'] = 1;

			}

		}else if($res['member_card_discount'] == 3){

			$unified = pdo_get("gpb_goods_discount_detailed",array('goods_id'=>$res['g_id'],'caid'=>$member['level'],'weid'=>$this->weid,'gos_id'=>$ggo_id));

			if($unified['price']){

				$ggo['ggo_market_price'] = $unified['price']/100;

			}else{

				$res['member_card_discount'] = 1;

			}

		}

	}

//          $res['g_icon'] = $this->http.'/'.$res['g_icon'];

    $res['g_icon'] = tomedia($res['g_icon']);

    $res['g_video'] = tomedia($res['g_video']);

    $res['g_video_open'] = empty($res['g_video']) ? 0 : 1;

    $res['g_thumb'] = explode(',', $res['g_thumb']);



    foreach ($res['g_thumb'] as $k => $v) {

        $res['g_thumb'][$k] = tomedia($v);

    }

    //查询优惠卷

    $coupon = pdo_fetchcolumn("select count(*) from " . tablename($this->user_coupon) . " as uc left join " . tablename($this->coupon) . " as c on c.id = uc.tid where uc.openid='" . $openid . "' and uc.weid = " . $this->weid . " and c.weid=" . $this->weid . " and use_limit <=" . ($price * $num) . " and uc.is_use =0 and uc.over_time>" . time() . " and c.status=1 and uc.status=1");//todo ...
    $user = pdo_fetch("select * from " . tablename($this->member) . " where weid= " . $this->weid . " and m_openid = '" . $openid . "'");
    $team = pdo_fetch("select * from " . tablename($this->member) . " where weid= " . $this->weid . " and m_openid = '" . $user['m_head_openid'] . "'");
	if($team['m_is_send'] == 2){
		//获取时间配置
		$team['delivery'] = $this->delivery();
		//获取上一回下单的地址
		$order = pdo_fetch("SELECT s.oss_address FROM ".tablename('gpb_order')." o JOIN ".tablename('gpb_order_snapshot')." s ON o.go_code = s.`oss_go_code` WHERE o.go_send_type = 2 and o.openid = '".$openid."' ORDER BY o.go_add_time DESC ");
		$team['oss_address'] = $order['oss_address'];
	}
	//2020-05-23 周龙 判断是否购买完成过，若无购买完成订单 团长手机号脱敏
    $has_order_finish = pdo_fetchcolumn("select count(1) from ".tablename("gpb_order")." where weid='{$this->weid}' and openid='{$openid}' and go_status=100");
	if($has_order_finish<1){
	    $team['m_phone'] = substr($team['m_phone'],0,3).'*****'.substr($team['m_phone'],-3);
    }

    //释放金自定义名字markrting_rebate[value]

    $markrting_rebate = pdo_get('gpb_config', array('key' => 'markrting_rebate', 'type' => 19));

    $markrting_rebate = isset($markrting_rebate['value']) && !empty($markrting_rebate['value']) ? $markrting_rebate['value'] : '释放金';

    //释放金 金额

    $release = pdo_fetch(" select sum(money) as moneys from " . tablename("gpb_recharge_list") . " where openid = '" . $openid . "' and weid = " . $this->weid . " and overdue =1 and `time` = " . strtotime(date("Y-m-d 00:00:00", time())));

    //是否折扣

    $open_member_card_discount_type = 0;

    $member_reduce_open = 2;

    $open_member_card_discount_rate = 1;

    $open_member_card = pdo_get('gpb_config', array('key' => 'card_id', 'type' => 20));

    if (isset($open_member_card['value']) && $open_member_card['value'] == 1) {

        //开启会员卡

        $member_card = pdo_get('gpb_member_card', array('id' => $user['level']));

        if (!empty($member_card) && $member_card['c_status']) {

            //买过会员卡，并启用了会员折扣

            $open_member_card_discount = pdo_get('gpb_config', array('key' => 'card_discount', 'type' => 20));

            $open_member_card_discount_type = isset($open_member_card_discount['value']) ? $open_member_card_discount['value'] : 2;

            //查看先算还是后算 2先算折扣 1后算

            $open_member_card_discount_rate = $member_card['discount'] / 10;

			

            $member_reduce_open = 1;

        }

    }

    if($this->check_base64_out_json($user['m_nickname'])){
        $user['m_nickname'] = base64_decode($user['m_nickname']);
    }
    if($this->check_base64_out_json($team['m_nickname'])){
        $team['m_nickname'] = base64_decode($team['m_nickname']);
    }
	if($_GPC['bargain']){
		//当前是砍价商品  不能计算会员折扣  
		//根据商品的id和用户的openid 去获取砍价信息
		$bargaion_goods = pdo_fetch("select * from ".tablename('gpb_bargain_action')." where goods_id = ".$gid." and status = 2 and weid = ".$this->weid." and openid = '".$openid."'");
		/*echo "<pre/>";
		var_dump("select * from ".tablename('gpb_bargain_action')." where goods_id = ".$gid." and status = 2 and weid = ".$this->weid." and openid = '".$openid."'");
		var_dump($bargaion_goods);
		exit();*/
		$res['g_price'] = $bargaion_goods['now_price'];
		$res['bargaion_price'] = $bargaion_goods['bargaion_price'];
		if($bargaion_goods['status'] == -1){
			$this->result("1", "该砍价商品还不能下单");
		}
		if($bargaion_goods['status'] > 2){
			$this->result("1", "该商品已下单购买!");
		}
	}
	//拼团
    if(!empty($_GPC['pteam_aid'])){

        $paid = $_GPC['pteam_aid'];

        $time = time();

        //获取对应团队

        $active = pdo_fetch("select pa.*,pl.is_ladder,pl.ladder_info,pl.is_spec,pl.spec_info,pl.old_price,pl.price from ".tablename("gpb_pteam_activity")." as pa join ".tablename("gpb_pteam_list")." as pl on pa.pl_id=pl.id where pa.id={$paid} and pa.`end_time`>'{$time}' and (pa.`state`=2 or pa.`state`=1) and pa.`status`=1 and pl.state=1 and pl.weid='{$this->weid}' and pa.now_num<pa.all_num");

//                echo "<pre/>";

//                exit(var_dump($active));

        if(empty($active)){

            $this->result("1", "拼团已过期或已满员");

        }

        //是否为团长加入拼团

        if($active['state']==1){

            if($active['leader_openid']!=$openid){

                $this->result("1", "拼团已过期或已满员");

            }

        }

        //获取价格

        if($active['is_ladder']==1){

            $ladder = unserialize($active['ladder_info']);

            //获取当前阶梯人数

            $ladder_info = [];

            foreach ($ladder as $k=>$v){

                if($v['num']==$active['all_num']){

                    $ladder_info = $v;

                }

            }

            $active['price'] = $ladder_info['price'];

        }

        if($active['is_spec']){

            $spec = unserialize($active['spec_info']);

            $p_spid = $_GPC['pteam_spid'];

            $spec_info = $spec[$p_spid];

            $active['price'] = $spec_info['price'];

        }

        $res['g_price'] = $active['price'];



    }
    //拼团开团
    if(!empty($_GPC['pteam_lid'])){
        $lid = intval($_GPC['pteam_lid']);
        $time = time();

        //获取对应团队

        $active = pdo_fetch("select * from ".tablename("gpb_pteam_list")." where id={$lid} and star_time<= {$time} and end_time>= {$time} and `status`=1");

        if(empty($active)){

            $this->result("1", "拼团活动已过期");

        }

        //获取价格

        if($active['is_ladder']==1){

            $ladder = unserialize($active['ladder_info']);

            //获取当前阶梯人数

            $ladder_info = [];

            foreach ($ladder as $k=>$v){

                if($v['num']==$_GPC['pop']){

                    $ladder_info = $v;

                }

            }

            $active['price'] = $ladder_info['price'];

        }

        if($active['is_spec']){

            $spec = unserialize($active['spec_info']);

            $p_spid = $_GPC['pteam_spid'];

            $spec_info = $spec[$p_spid];

            $active['price'] = $spec_info['price'];

        }

        $res['g_price'] = $active['price'];

    }
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
		),
		'1'=>array(
			'id'=>2,
			'name'=>$delivery_chief,
			'sort'=>$delivery_chief_sort,
		),
		'2'=>array(
			'id'=>3,
			'name'=>$delivery_express,
			'sort'=>$delivery_express_sort,
		),
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
	$head_member = pdo_get("gpb_member",array('m_openid'=>$member['m_head_openid']),array('m_is_send'));
	if($head_member['m_is_send'] == 1){
		unset($arr[1]);
	}
	if($arr){
		//根据sort进行排序
		$arr = $this->multi_array_sort($arr,'sort');
	}
	
	//获取积分的配置
	$dode = $this->dodeduction();
    if (!empty($ggo_id) && !empty($ggo)) {

        $array = array('dode'=>$dode,'data' => $res, 'coupon' => $coupon, 'user' => $user, 'num' => $num, 'money' => $num * $ggo['ggo_market_price'], 'head' => $team, 'ggo' => $ggo, 'release_money' => floatval($release['moneys']), 'markrting_rebate' => $markrting_rebate, 'member_reduce_open' => $member_reduce_open, 'open_member_card_discount_rate' => $open_member_card_discount_rate, 'open_member_card_discount_type' => $open_member_card_discount_type,'mode'=>$arr);
    } else {
        $array = array('dode'=>$dode,'data' => $res, 'coupon' => $coupon, 'user' => $user, 'num' => $num, 'money' => $num * $res['g_price'], 'head' => $team, 'release_money' => floatval($release['moneys']), 'markrting_rebate' => $markrting_rebate, 'member_reduce_open' => $member_reduce_open, 'open_member_card_discount_rate' => $open_member_card_discount_rate, 'open_member_card_discount_type' => $open_member_card_discount_type,'mode'=>$arr);

    }

	//获取截单配置

	$cutting = $this->custting_order_time(2);

	$array['cutting'] = $cutting;
	//计算经纬度
	//获取团长的经纬度
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
    $this->result("0", "立即购买商品相关数据获取成功", $array);

}
?>