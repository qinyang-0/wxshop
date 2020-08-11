<?php
global $_GPC;
$lng = trim($_GPC['lng']);
$lat = trim($_GPC['lat']);
$cid = trim($_GPC['cid']);
$openid = trim($_GPC['openid']);
if (empty($lat) || empty($lng)) {
    $this->result("1", "请传入用户定位的经纬度");
}
//有记录时就保存用户登录位置坐标
$data_m = array(
    'm_last_longitude' => $lng,
    'm_last_latitude' => $lat,
);
pdo_update($this->member, $data_m, array("m_openid" => $openid));
if (!empty($cid)) {
    $sql = "select * from " . tablename($this->member) . " as m left join " . tablename($this->vg) . " as vg on vg.openid = m.m_openid  left join " . tablename($this->rg) . " as rg on rg.rg_id = vg.vg_rg_id left join " . $this->pre . "gpb_area as a on a.ad_code = rg.rg_city_id where m.weid=" . $this->weid . " and m_is_head = 2 and m_status = 1 and vg.vg_id>0 and a.id = " . $cid;
} else {
    $sql = "select * from " . tablename($this->member) . " as m left join " . tablename($this->vg) . " as vg on vg.openid = m.m_openid where m.weid=" . $this->weid . " and m_is_head = 2 and m_status = 1 and vg.vg_id>0";
}
$info = pdo_fetchall($sql);
//之前是按团长的定位算
//现在按小区定位算
$new_info = array();
$select_head_num =  pdo_get($this->config,array('key'=>'select_head_num','weid'=>$this->weid));
$select_head_num = isset($select_head_num['value'])?intval($select_head_num['value']):0;
$select_head_distance =  pdo_get($this->config,array('key'=>'select_head_distance','weid'=>$this->weid));
$select_head_distance = isset($select_head_distance['value'])?intval($select_head_distance['value']):0;
if($openid == 'otEnX5cuoo_4SCg0MJbMF7Wl0H8E'){
	$select_head_distance = 0;
}
foreach ($info as $k => $v) {
    $km =$this->getDistance($lat, $lng, $v['vg_latitude'], $v['vg_longitude']);
    $info[$k]['m'] = $km;
    if($select_head_distance >0 && $km>$select_head_distance*1000){
        unset($info[$k]);
        continue;
    }else{
        $new_info[]=$info[$k];
    }
}
//查询历史社区
$head_history = pdo_fetchall("select * from " . tablename($this->head_history) . " as hh left join " . tablename($this->member) . " as m on m.m_openid=hh.hh_head_openid where hh.openid = '" . $openid . "' and hh.weid=" . $this->weid . " and m.m_is_head=2  group by m.m_openid order by hh.hh_last_time desc limit 1,5");
$m = array_column($new_info, 'm');//先用array_column 多维数组按照纵向（列）取出
array_multisort($m, SORT_ASC, $new_info);//再用array_multisort  结合array_column得到的结果对$arr进行排序
if($select_head_num>0){
    $new_info = array_slice($new_info,0,$select_head_num);
}
/*foreach ($info as $key=>$val){
    if($this->check_base64_out_json($val['m_nickname'])){
        $info[$key]['m_nickname'] = base64_decode($val['m_nickname']);
    }
}
//有站点用这个部分会json编码报错 ，先注释
*/
foreach ($head_history as $keys=>$vals){
    if($this->check_base64_out_json($vals['m_nickname'])){
        $head_history[$keys]['m_nickname'] = base64_decode($vals['m_nickname']);
    }
}
$last_head_notice = pdo_get($this->config, array('key' => 'last_head_notice', 'weid' => $this->weid));
if (empty($new_info)) {
    $this->result("1", "查询失败，暂无数据");
} else {
    $this->result("0", "查询团长成功", array('data' => $new_info, 'history' => $head_history,'last_head_notice'=>$last_head_notice));
}
exit;
?>