<?php
global $_GPC, $_W;
$openid = trim($_GPC['openid']);
$cid = trim($_GPC['c_id']);
$lat = $_GPC['lat'];//纬度
$lng = $_GPC['lng'];//经度
$where = " ";
if (empty($openid)) {
    $this->result("1", "error,请传入openid");
}
if (!empty($cid) and $cid !== 'true') {

    $where = " and c_id in (" . trim($cid, ',') . ")";

}

$member = pdo_get("gpb_member",array('m_openid'=>$openid));

if($member['level']){

	$member_card = pdo_get("gpb_member_card",array('id'=>$member['level']));

}

//zl 7-3 增加商品是否上架、是否删除查询

$sql = "select * from ".tablename($this->cart) . " as c left join " . tablename($this->goods) . " as g on g.g_id=c.c_g_id left join " . tablename($this->goods_option) . " as go on go.ggo_id = c.c_ggo_id left join " . tablename($this->action) . " as a on a.at_id = c.c_at_id where g.g_is_online=1 and g.g_is_del=1 and c_status =1 and c.openid ='" . $openid . "' " . $where . " and (g.`type`<>2 or g.`type` is null) and c.weid =" . $this->weid . " order by g.g_is_full_reduce desc,c_add_time desc ";

$res = pdo_fetchall($sql);

$gid = array();

$goods_price = array();

foreach ($res as $k => $v) {

//            $res[$k]['g_icon'] = $this->http.'/'.$v['g_icon'];

    $res[$k]['g_icon'] = tomedia($v['g_icon']);

    $res[$k]['g_video'] = tomedia($v['g_video']);

    $res[$k]['g_video_open'] = empty($v['g_video']) ? 0 : 1;

    $res[$k]['g_thumb'] = explode(',', $v['g_thumb']);



    foreach ($res[$k]['g_thumb'] as $key => $val) {

        $res[$k]['g_thumb'][$key] = tomedia($val);

    }

    if ($v['g_has_option'] == 0 || empty($v['ggo_market_price'])) {

        $res[$k]['priceArr'] = explode(".", $v['g_price']);

    } elseif ($v['g_has_option'] == 1) {

        $res[$k]['priceArr'] = explode(".", $v['ggo_market_price']);

    }

    $res[$k]["arrival_time"] = date("m月d日", time());

    if (!empty($v['at_arrival_time']) && $v['at_arrival_time'] >= 0) {

        $res[$k]["arrival_time"] = date("m月d日", (time() + (intval($v["at_arrival_time"]) * 24 * 60 * 60)));

    }

//            if( !empty( $v['g_arrival_time'] ) && $v['g_arrival_time'] > 0 ){

//                $res[$k]["arrival_time"] = date("m月d日",(time()+($res[$k]["g_arrival_time"]*24*60*60)));

//            }

    $res[$k]['total_money'] = $v['c_count'] * $v['g_price'];

    //查询库存

    $stock = pdo_get($this->goods_stock, array('goods_id' => $v['g_id'], 'weid' => $this->weid));//库存和销售量

    $res[$k]['actual'] = $stock['num'];

    $gid[] = $v['g_id'];

    if (!empty($res[$k]['ggo_market_price'])) {

        $goods_price[$v['g_id']] = $res[$k]['ggo_market_price'];

    } else {

        $goods_price[$v['g_id']] = $res[$k]['g_price'];

    }

	//判断是否启用会员卡

	$card_ids = pdo_get("gpb_config",array('key'=>'card_id','weid'=>$this->weid),array('value'));

	if($card_ids['value'] == 1 && $v['coop_type'] != 2){

		if($v['member_card_discount'] != 1 && $member['level'] && !empty($v['member_card_discount'])){

			if($v['member_card_discount'] == 2){

				$unified = pdo_get("gpb_goods_dicount_unified",array('goods_id'=>$v['g_id'],'card'=>$member['level'],'weid'=>$this->weid));

				if($unified['price']){

					$res[$k]['g_price'] = (number_format($unified['price']/100, 2, '.', ''));

					$res[$k]['priceArr'] = explode(".",$res[$k]['g_price']);

				}else{

					//根据全场配置去  算价格

					$res[$k]['g_price'] = (number_format($v['g_price']*($member_card['discount']/10), 2, '.', ''));

					$res[$k]['priceArr'] = explode(".",$res[$k]['g_price']);

					$res[$k]['member_card_discount'] = 1;

				}

			} else if($v['member_card_discount'] == 3) {

				$unified = pdo_get("gpb_goods_discount_detailed",array('goods_id'=>$v['g_id'],'caid'=>$member['level'],'weid'=>$this->weid,'gos_id'=>$v['c_ggo_id']));

				if($unified['price']){

					$res[$k]['ggo_market_price'] = (number_format($unified['price']/100, 2, '.', ''));

					$res[$k]['priceArr'] = explode(".",$res[$k]['ggo_market_price']);

				}else{

					//根据全场配置去  算价格

					$res[$k]['ggo_market_price'] = (number_format($v['ggo_market_price']*($member_card['discount']/10), 2, '.', ''));

					$res[$k]['priceArr'] = explode(".",$res[$k]['ggo_market_price']);

					$res[$k]['member_card_discount'] = 1;

				}

			}

		} else {

			if($v['g_has_option'] == 1){

				//多规格

				if($member_card['discount']){

					$res[$k]['ggo_market_price'] = (number_format($v['ggo_market_price']*($member_card['discount']/10), 2, '.', ''));

				}else{

					$res[$k]['ggo_market_price'] = (number_format($v['ggo_market_price'], 2, '.', ''));

				}

				$res[$k]['priceArr'] = explode(".",$res[$k]['ggo_market_price']);

			} else {

				//单规格

				if($member_card['discount']){

					$res[$k]['g_price'] = (number_format($v['g_price']*($member_card['discount']/10), 2, '.', ''));

				}else{

					$res[$k]['g_price'] = (number_format($v['g_price'], 2, '.', ''));

				}

				$res[$k]['priceArr'] = explode(".",$res[$k]['g_price']);

			}

		}

		if($v['g_has_option'] == 1){

			$res[$k]['g_origin_price'] = $v['ggo_market_price'];

		}else{

			$res[$k]['g_origin_price'] = $v['g_price'];

		}

	}

}

$total_money = array_sum(array_column($res, "total_money"));



if (empty($res)) {

    $this->result("1", "查询购物车失败，请重试");

} else {

    if ($_GPC['types'] == 1) {

        $cates_goods = array();

        foreach ($gid as $v_gids) {

            $cates_goods[$v_gids] = pdo_getall('gpb_goods_to_category', array('weid' => $this->weid, 'goods_id' => $v_gids));

        }

        $coupon = pdo_fetchall("select * from " . tablename($this->user_coupon) . " as uc left join " . tablename($this->coupon) . " as c on c.id = uc.tid where uc.openid='" . $openid . "' and uc.weid = " . $this->weid . " and uc.is_use =0 and uc.over_time>" . time() . " and c.end_time>" . time() . " and c.status=1 and uc.status=1");

//              if($_GPC['t']==1) {

//              	var_dump($coupon);

//              	var_dump("select * from " . tablename($this->user_coupon) . " as uc left join " . tablename($this->coupon) . " as c on c.id = uc.tid where uc.openid='" . $openid . "' and uc.weid = " . $this->weid . " and uc.is_use =0 and uc.over_time>" . time() . " and c.end_time>" . time() . " and c.status=1 and uc.status=1");

//              	exit;

//              }

        foreach ($coupon as $k_cou => $v_cou) {

            if ($v_cou['type'] == 5) {

                //如果是分类

                if (!empty($v_cou['limitgoodcateids'])) {

                    $coupon_cate = explode(',', $v_cou['limitgoodcateids']);

                    $join_cate_goods = array();

                    $cate_all_price = 0;

                    foreach ($cates_goods as $v_cates_goods) {

                        if (in_array($v_cates_goods['goods_id'], $coupon_cate)) {

                            $join_cate_goods[] = $v_cates_goods['goods_id'];

                        }

                    }

                    if (!empty($join_cate_goods)) {

                        $join_cate_goods = array_unique($join_cate_goods);

                        foreach ($join_cate_goods as $join_cate_goods_v) {

                            $cate_all_price += $goods_price[$join_cate_goods_v];

                        }

                    } else {

                        unset($coupon[$k_cou]);

                        continue;

                    }

                    if ($cate_all_price < $v_cou['use_limit']) {

                        unset($coupon[$k_cou]);

                        continue;

                    }

                }

            }

            if ($v_cou['type'] == 6) {

                //如果是单品

                if (!empty($v_cou['limitgoodids'])) {

                    $coupon_gid = explode(',', $v_cou['id']);

                    $cate_all_price = 0;

                    foreach ($coupon_gid as $coupon_gid_key => $coupon_gid_val) {

                        if (isset($goods_price[$coupon_gid_val])) {

                            $cate_all_price += $goods_price[$coupon_gid_val];

                        } else {

                            unset($coupon[$k_cou]);

                            continue;

                        }

                    }

                    if ($cate_all_price < $v_cou['use_limit']) {

                        unset($coupon[$k_cou]);

                        continue;

                    }

                }

            }

            if ($total_money < $v_cou['use_limit']) {

                unset($coupon[$k_cou]);

                continue;

            }

        }

        $coupon_cout = count($coupon);

        //查询优惠卷

//                $coupon = pdo_fetchcolumn("select count(*) from ".tablename($this->user_coupon)." as uc left join ".tablename($this->coupon)." as c on c.id = uc.tid where uc.openid='".$openid."' and uc.weid = ".$this->weid." and c.weid= ".$this->weid." and use_limit <=".$total_money." and uc.is_use =0 and uc.over_time>".time());//todo ...

        $user = pdo_fetch("select * from " . tablename($this->member) . " where weid= " . $this->weid . " and m_openid = '" . $openid . "'");

        //释放金自定义名字markrting_rebate[value]

        $markrting_rebate = pdo_get('gpb_config', array('key' => 'markrting_rebate', 'type' => 19));

        $markrting_rebate = isset($markrting_rebate['value']) && !empty($markrting_rebate['value']) ? $markrting_rebate['value'] : '释放金';

        //释放金 金额

        $release = pdo_fetch(" select sum(money) as moneys from " . tablename("gpb_recharge_list") . " where openid = '" . $openid . "' and overdue =1 and weid = " . $this->weid . " and `time` = " . strtotime(date("Y-m-d 00:00:00", time())));

        //是否折扣
        $open_member_card_discount_type = 0;
        $member_reduce_open = 2;
        $open_member_card_discount_rate = 1;
        $open_member_card = pdo_get('gpb_config', array('key' => 'card_id', 'type' => 20));
        if (isset($open_member_card['value']) && $open_member_card['value'] == 1 && $v['coop_type'] != 2) {
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

        $array = array(

            'data' => $res,

            'coupon' => $coupon_cout,

            'user' => $user,

            'test' => $coupon,

            'release_money' => floatval($release['moneys']),

            'markrting_rebate' => $markrting_rebate,

            'member_reduce_open' => $member_reduce_open,

            'open_member_card_discount_rate' => $open_member_card_discount_rate,

            'open_member_card_discount_type' => $open_member_card_discount_type,

        );

        //是否折扣

    } else {

        $array = $res;

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

	$dode = $this->dodeduction();//积分配置

	$delivery_time = $this->delivery();//团长送货配置

	$array['mode'] = $arr;

	$array['dode'] = $dode;

	$array['delivery'] = $delivery_time;

	$array['custting'] = $this->custting_order_time(2);//平台截单

	//获取上一次的地址信息

	$order = pdo_fetch("SELECT s.oss_address FROM ".tablename('gpb_order')." o JOIN ".tablename('gpb_order_snapshot')." s ON o.go_code = s.`oss_go_code` WHERE o.go_send_type = 2 and openid = '".$openid."' ORDER BY o.go_add_time DESC ");

	$array['oss_address'] = $order['oss_address'];
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
	$array['calculatedDistance']= $calculatedDistance;
	//获取配置 订单提示信息
	$order_extracting_info = pdo_get("gpb_config",array('key'=>'order_extracting_info','weid'=>$this->weid));
    $order_extracting_info = $order_extracting_info['value'] ? $order_extracting_info['value'] : '';
    $array['order_extracting_info'] = $order_extracting_info;
    $this->result("0", "查询购物车成功", $array);

}
?>