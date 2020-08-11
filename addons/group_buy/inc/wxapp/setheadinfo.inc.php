<?php
global $_W, $_GPC;
$openid = trim($_GPC['openid']);

if (empty($openid)) {

	$this -> result(1, "未授权");

}

$name = trim($_GPC['name']);

$phone = trim($_GPC['phone']);

$shop_name = trim($_GPC['shop_name']);

$account = trim($_GPC['account']);

$addresss = trim($_GPC['address']);

$lng = trim($_GPC['lng']);

$lat = trim($_GPC['lat']);

$form_id = trim($_GPC['formId']);

$region = trim($_GPC['region'], ',');

$region_arr = explode(',', $region);

$sheng = $region_arr[0];

$city = $region_arr[1];

$area = $region_arr[2];

$is_send = trim($_GPC['is_send']);

$send_price = trim($_GPC['send_price']);

$adrdetail = trim($_GPC['adrdetail']);

$reason = trim($_GPC['reason']);

$close = trim($_GPC['close']);

if (!isset($name) || $name == "" || $name == null) {

	$this -> result("1", "请输入姓名");

	exit ;

}

if (!isset($phone) || $phone == "" || $phone == null) {

	$this -> result("1", "请输入手机号");

	exit ;

}

//        if( !isset($account) || $account == "" || $account ==null   ){

//            $this->result("1","请输入微信号");exit;

//

//        }

if (!isset($shop_name) || $shop_name == "" || $shop_name == null) {

	$this -> result("1", "请输入店铺名");

	exit ;

}

if (!isset($openid) || $openid == "" || $openid == null) {

	$this -> result("1", "未授权");

	exit ;

}

if (!isset($addresss) || $addresss == "" || $addresss == null || empty($lng) || empty($lat)) {

	$this -> result("1", "请输入地址");

	exit ;

}

if ($close == 2 && ($reason == '' || $reason == null)) {

	$this -> result("1", "请填写打烊原因");

	exit ;

}

//        if(empty($region)){

//            $this->result("1","请选择所在地区");exit;

//        }

//        $old = pdo_getall($this->ah,array('weid'=>$this->weid,'openid'=>$openid));

pdo_begin();

//查询省市区的code

//暂无 台湾  香港  澳门  如需则要升级数据库

$sheng_arr = pdo_get('gpb_area', array('pid' => 0, 'name' => $sheng));

if (!empty($sheng_arr)) {

	$city_arr = pdo_get('gpb_area', array('pid' => $sheng_arr['ad_code'], 'name' => $city));

	if (!empty($city_arr)) {

		$area_arr = pdo_get('gpb_area', array('pid' => $city_arr['ad_code'], 'name' => $area));

	}

}

$old_vg = pdo_fetch("select * from " . tablename($this -> vg) . " where weid =" . $this -> weid . " and openid = '" . $openid . "'");

//如果没有之前的小区数据

if (empty($old_vg)) {

	$data_rg = array('rg_name' => $shop_name, 'rg_province_id' => empty($sheng_arr) ? "" : $sheng_arr['ad_code'], 'rg_city_id' => empty($city_arr) ? "" : $city_arr['ad_code'], 'rg_area_id' => empty($area_arr) ? "" : $area_arr['ad_code'], 'rg_add_time' => time(), 'weid' => $this -> weid, 'rg_all_area' => $region, 'rg_status' => 1);

	$res_rg = pdo_insert($this -> rg, $data_rg);

	if (!empty($res_rg)) {

		$res_rg_id = pdo_insertid();

	} else {

		pdo_rollback();

		$this -> result("1", "修改失败.");

		exit ;

	}

	$data_vg = array('vg_name' => $shop_name, 'vg_rg_id' => $res_rg_id, 'vg_team_name' => $shop_name, 'vg_address' => $addresss . $adrdetail, 'vg_longitude' => $lng, 'vg_latitude' => $lat, 'vg_add_time' => time(), 'vg_pick_address' => $addresss . $adrdetail, 'weid' => $this -> weid, 'openid' => $openid, 'vg_status' => 1);

	$res_vg = pdo_insert($this -> vg, $data_vg);

	if (!empty($res_vg)) {

		$res_vg_id = pdo_insertid();

	} else {

		pdo_rollback();

		$this -> result("1", "修改失败..");

		exit ;

	}

} else {

	//如果之前有申请人的小区记录

	$data_rg = array('rg_name' => $shop_name, 'rg_province_id' => empty($sheng_arr) ? "" : $sheng_arr['ad_code'], 'rg_city_id' => empty($city_arr) ? "" : $city_arr['ad_code'], 'rg_area_id' => empty($area_arr) ? "" : $area_arr['ad_code'], 'rg_update_time' => time(), 'rg_all_area' => $region, 'rg_status' => 1);

	$res_rg = pdo_update($this -> rg, $data_rg, array('weid' => $this -> weid, 'rg_id' => $old_vg['vg_rg_id']));

	if (!empty($res_rg)) {

	} else {

		pdo_rollback();

		$this -> result("1", "修改失败...");

		exit ;

	}

	$data_vg = array('vg_name' => $shop_name, 'vg_team_name' => $shop_name, 'vg_address' => $addresss, 'vg_longitude' => $lng, 'vg_latitude' => $lat, 'vg_update_time' => time(), 'vg_pick_address' => $addresss, 'vg_status' => 1);

	$res_vg = pdo_update($this -> vg, $data_vg, array('weid' => $this -> weid, 'openid' => $openid, 'vg_id' => $old_vg['vg_id']));

	if (!empty($res_vg)) {

	} else {

		pdo_rollback();

		$this -> result("1", " 修改失败");

		exit ;

	}

}

$member = pdo_get($this -> member, array("m_openid" => $openid, 'weid' => $this -> weid));

if (empty($member)) {

	pdo_rollback();

	$this -> result("1", " 获取用户失败");

	exit ;

}

if ($this -> check_base64_out_json($member['m_nickname'])) {

	$member['m_nickname'] = base64_decode($member['m_nickname']);

}

$data_mb = array('m_send_price' => $send_price, 'm_is_send' => $is_send, 'm_head_shop_name' => $shop_name, 'm_head_lng' => $lng, 'm_head_lat' => $lat, 'm_head_address' => $addresss, 'm_head_house_address' => $adrdetail, 'm_last_location' => $region, 'm_name' => $name, 'closes' => $close, 'reason' => $reason, );

$res = pdo_update($this -> member, $data_mb, array("m_id" => $member['m_id']));

if (empty($member)) {

	pdo_rollback();

	$this -> result("1", " 修改信息失败");

	exit ;

} else {

	pdo_commit();

	$this -> result("0", " 修改成功");

	exit ;

}
?>