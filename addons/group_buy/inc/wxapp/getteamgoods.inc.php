<?php
global $_W, $_GPC;
$openid = trim($_GPC['openid']);
if (empty($openid)) {
	$this -> result(1, "未授权");
}
$index = isset($_GPC['page']) ? $_GPC['page'] : 1;
$pageIndex = $index;
$pageSize = 5;
$contion = 'limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;
$type = trim($_GPC['type']);
$data = array();
$total = 0;
if (empty($type) || $type == 0) {
	//查询正在进行的活动
	$no_limit_at = pdo_getall($this -> action, array("weid" => $this -> weid, "at_is_limit" => 1, 'at_is_del' => 1, 'at_end_time >' => time(), 'at_start_time <' => time(), 'at_is_head_open' => -1), array('at_id'));
	$limit_at = pdo_fetchall("select a.at_id from " . tablename($this -> action_village) . " as av left join " . tablename($this -> action) . " as a on a.at_id=av.gav_ac_id left join " . tablename($this -> vg) . " as vg on vg.vg_id = av.gav_v_id where a.weid=" . $this -> weid . " and a.at_is_del=1 and a.at_is_limit=-1 and vg.openid='" . $openid . "' and at_end_time > " . time() . " and a.at_is_head_open =-1 and at_start_time <" . time() . "");
	$arr = array();
	if (!empty($no_limit_at)) {
		foreach ($no_limit_at as $k => $v) {
			$arr[] = $v['at_id'];
		}
	}
	if (!empty($limit_at)) {
		foreach ($limit_at as $k => $v) {
			$arr[] = $v['at_id'];
		}
	}
	if (!empty($arr)) {
		$now_at_str = implode(",", $arr);
	}
	//由活动查活动商品
	if (!empty($now_at_str)) {
		//查总数
		$total = pdo_fetchcolumn("select count(*) from " . tablename($this -> action_goods) . " as ag left join " . tablename($this -> goods) . " as g on g.g_id = ag.gcg_g_id where gcg_at_id in (" . $now_at_str . ") and g.g_is_online=1 and g.weid=" . $this -> weid);
		//查本页
		$data = pdo_fetchall("select g.*,a.*,gs.num,gs.sale_num,gcg_id,tcg_id from " . tablename($this -> action_goods) . " as ag left join " . tablename($this -> goods) . " as g on g.g_id = ag.gcg_g_id left join " . tablename($this -> action) . " as a on a.at_id = ag.gcg_at_id left join " . tablename($this -> goods_stock) . " as gs on gs.goods_id=g.g_id left join " . $this -> pre . "gpb_team_cancel_goods as tcg on tcg.tcg_at_g_id=ag.gcg_id and tcg.openid = '" . $openid . "'  where g.weid=" . $this -> weid . " and g.g_is_online=1 and gcg_at_id in (" . $now_at_str . ") " . $contion);
		//查全部id
		$all_id_arr = pdo_fetchall("select gcg_id from " . tablename($this -> action_goods) . " as ag left join " . tablename($this -> goods) . " as g on g.g_id = ag.gcg_g_id left join " . tablename($this -> action) . " as a on a.at_id = ag.gcg_at_id left join " . tablename($this -> goods_stock) . " as gs on gs.goods_id=g.g_id left join " . $this -> pre . "gpb_team_cancel_goods as tcg on tcg.tcg_at_g_id=ag.gcg_id and tcg.openid = '" . $openid . "' where g.weid=" . $this -> weid . " and g.g_is_online=1 and gcg_at_id in (" . $now_at_str . ") ");
		$all_id = '';
		foreach ($all_id_arr as $v) {
			$all_id .= ',' . $v['gcg_id'];
		}
	}
	$test = "now";
} else {
	//查询下期的活动
	$no_limit_at_next = pdo_getall($this -> action, array("weid" => $this -> weid, "at_is_limit" => 1, 'at_is_del' => 1, 'at_start_time >' => time(), 'at_is_head_open' => -1), array('at_id'));
	$limit_at_next = pdo_fetchall("select a.at_id from " . tablename($this -> action_village) . " as av left join " . tablename($this -> action) . " as a on a.at_id=av.gav_ac_id left join " . tablename($this -> vg) . " as vg on vg.vg_id = av.gav_v_id where a.weid=" . $this -> weid . " and a.at_is_del=1 and a.at_is_limit=-1 and vg.openid='" . $openid . "' and a.at_is_head_open =-1  and at_start_time >" . time() . "");
	$arr_next = array();
	if (!empty($no_limit_at_next)) {
		foreach ($no_limit_at_next as $k => $v) {
			$arr_next[] = $v['at_id'];
		}
	}
	if (!empty($limit_at_next)) {
		foreach ($limit_at_next as $k => $v) {
			$arr_next[] = $v['at_id'];
		}
	}
	if (!empty($arr_next)) {
		$now_at_str_next = implode(",", $arr_next);
	}
	//由活动查活动商品
	if (!empty($now_at_str_next)) {
		$total = pdo_fetchcolumn("select count(*) from " . tablename($this -> action_goods) . " as ag left join " . tablename($this -> goods) . " as g on g.g_id = ag.gcg_g_id where gcg_at_id in (" . $now_at_str_next . ") and g.g_is_online=1 and g.weid=" . $this -> weid);
		$data = pdo_fetchall("select g.*,a.*,gs.num,gs.sale_num,gcg_id,tcg_id from " . tablename($this -> action_goods) . " as ag left join " . tablename($this -> goods) . " as g on g.g_id = ag.gcg_g_id left join " . tablename($this -> action) . " as a on a.at_id = ag.gcg_at_id left join " . tablename($this -> goods_stock) . " as gs on gs.goods_id=g.g_id left join " . $this -> pre . "gpb_team_cancel_goods as tcg on tcg.tcg_at_g_id=ag.gcg_id and tcg.openid = '" . $openid . "' where  g.weid=" . $this -> weid . " and g.g_is_online=1 and gcg_at_id in (" . $now_at_str_next . ") " . $contion);
		$all_id_arr = pdo_fetchall("select gcg_id from " . tablename($this -> action_goods) . " as ag left join " . tablename($this -> goods) . " as g on g.g_id = ag.gcg_g_id left join " . tablename($this -> action) . " as a on a.at_id = ag.gcg_at_id left join " . tablename($this -> goods_stock) . " as gs on gs.goods_id=g.g_id left join " . $this -> pre . "gpb_team_cancel_goods as tcg on tcg.tcg_at_g_id=ag.gcg_id and tcg.openid = '" . $openid . "' where  g.weid=" . $this -> weid . " and g.g_is_online=1 and gcg_at_id in (" . $now_at_str_next . ") ");
		$all_id = '';
		foreach ($all_id_arr as $v) {
			$all_id .= ',' . $v['gcg_id'];
		}
	}
	$test = "next";
}
if (!empty($data)) {
	foreach ($data as $k => $v) {
		$data[$k]['g_icon'] = tomedia($v['g_icon']);
	}
}
$page = ceil($total / 5);
$page_arr = array();
if ($page >= 1) {
	for ($i = 1; $i <= $page; $i++) {
		$page_arr[] = $i;
	}
} else {
	$page_arr = array(1);
}
//查已删除的
if (!empty($all_id)) {
	$del_count = pdo_fetchcolumn("select count(*) from " . tablename($this -> team_cancel_goods) . " where openid='" . $openid . "' and tcg_at_g_id in (" . trim($all_id, ',') . ")");
} else {
	$del_count = 0;
}
$this -> result("0", "查询成功", array('total' => $total, 'data' => $data, 'page' => $page_arr, 'type' => $type, 'test' => $test, 'all_id' => $all_id, 'del_count' => $del_count, 'sql' => "select g.*,a.*,gs.num,gs.sale_num,gcg_id,tcg_id from " . tablename($this -> action_goods) . " as ag left join " . tablename($this -> goods) . " as g on g.g_id = ag.gcg_g_id left join " . tablename($this -> action) . " as a on a.at_id = ag.gcg_at_id left join " . tablename($this -> goods_stock) . " as gs on gs.goods_id=g.g_id left join " . $this -> pre . "gpb_team_cancel_goods as tcg on tcg.tcg_at_g_id=ag.gcg_id  where g.weid=" . $this -> weid . " and g.g_is_online=1 and gcg_at_id in (" . $now_at_str . ") " . $contion));
exit ;
?>