<?php
global $_W, $_GPC;
//		$stime=microtime(true);
$openid = $_GPC['openid'];
$cutting = $this->custting_order_time(3,$openid);
if(!$cutting){
    $today = strtotime(date("Ymd", time()));
    $cid = trim($_GPC['cid']);
    $ac_id = trim($_GPC['at_id']);



    $index = isset($_GPC['page']) ? $_GPC['page'] : 1;
    $member = pdo_get("gpb_member",array('m_openid'=>$openid),array('m_head_openid'));
    $pageIndex = $index;
    $pageSize = 10;
    $contion = ' limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;
    $where = "";
    if (!empty($cid)) {
        //目前就二级分类，查下级就行
        $cate_id = pdo_fetchall("select * from " . tablename($this->goods_cate) . " where weid=" . $this->weid . " and (`type`<>2 or `type` is null) and gc_is_del = 1 and gc_status=1 and gc_pid =" . $cid);
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
    $action_pic='';
    //逻辑：活动id必须
    if(isset($ac_id) && !empty($ac_id) ) {
        $sql1 = 'select * from '.tablename($this->action).' where at_is_del = 1 and at_id ='.$ac_id.' and weid ='. $this->weid;
        $action = pdo_fetch($sql1);
        $where .= " and a.at_id =".$ac_id;
        $action_pic=tomedia($action['action_pic']);
    }

    $head_openid = trim($_GPC['head_openid']);
    $goods = array();
    $sql = "select a.at_arrival_time,a.at_end_time,a.at_id,a.at_start_time,gtc.cate_id,g.g_brief,g.g_commission,g.g_has_option,g.g_icon,g.g_id,g.g_info,g.g_is_full_reduce,g.g_is_hot,g.g_is_new,g.g_video,g.g_sale_num,g.g_price,g.g_old_price,g.g_limit_num,g.g_name,c.gc_name,ag.gcg_at_id,ag.gcg_id,gs.sale_num,gs.num,g.g_is_recommand from " . tablename($this->action_goods) . " as ag  join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  join " . tablename($this->goods) . "  as g on g.g_id =ag.gcg_g_id left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id =g.g_id  left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id  join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id left join " . tablename($this->action_village) . " as av on av.gav_ac_id = at_id left join " . tablename($this->vg) . " as vg on vg.vg_id = av.gav_v_id where (SELECT COUNT(1) AS num FROM ".tablename('gpb_team_cancel_goods')." AS cancel_goods WHERE cancel_goods.tcg_at_g_id = ag.gcg_id AND cancel_goods.`openid` = '".$member['m_head_openid']."') = 0 AND (at_is_limit=1 or (at_is_limit=-1 and vg.openid='" . $member['m_head_openid'] . "')) and at_is_del=1 and  at_is_index_show=1 and g_is_online=1 and g_is_head_enjoy=-1 and g_is_del = 1 and at_end_time > " . time() . " and at_start_time < " . time() . " and (g.`type`<>2 or g.`type` is null) and ag.weid=" . $this->weid . $where . " and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL ) GROUP BY g.g_id order by g.g_is_top desc,g.g_is_del asc,g.g_order asc,g.g_is_online desc,at_start_time desc " . $contion;
    $goods = pdo_fetchall($sql);
    $cates = array();
    $gid_str = '';
    if (is_array($goods)) {
        $goods_tmp = array();
        foreach ($goods as $key => $val) {
            //当前团长当前商品选择未开启，删除商品
            $del_count = pdo_fetchcolumn("select count(*) from " . tablename($this->team_cancel_goods) . " as tcg where  tcg.openid='".$member['m_head_openid']."' and tcg.tcg_at_g_id = " . $val['gcg_id']);
            if (!empty($del_count) && $del_count >= 1) {
                continue;
            }
            $gid_str .= ',' . $val['g_id'];
            $goods[$key]['priceArry'] = explode('.', $val['g_price']);
            $goods[$key]['g_icon'] = tomedia($val['g_icon']);
            $goods[$key]['g_video'] = tomedia($val['g_video']);
            $goods[$key]['g_video_open'] = empty($val['g_video']) ? 0 : 1;
            //$buy_people = pdo_fetchall("select m.m_photo from " . tablename($this->snapshot) . " as s left join " . tablename($this->member) . " as m on m.m_openid =s.oss_buy_openid where  m.weid=" . $this->weid." and s.oss_gid =" . $val['g_id'] . " group by m_openid order by oss_id desc limit 9");
            //$goods[$key]['buy_people'] = $buy_people;
            if (empty($goods[$key]['at_arrival_time']) && $goods[$key]['at_arrival_time'] != 0) {
                $goods[$key]["arrival_time"] = date("m月d日", (time() + ($goods[$key]["at_arrival_time"] * 24 * 60 * 60)));
            } else {
                $goods[$key]["arrival_time"] = date("m月d日", (time() + ($goods[$key]["at_arrival_time"] * 24 * 60 * 60)));
            }
            //查询有无此商品的购物车
            $goods_cart = pdo_fetch("select c_count,c_id from " . tablename($this->cart) . " where openid='" . $openid . "' and c_is_del =1 and c_status =1 and c_g_id = " . $val['g_id']);
            if (empty($goods_cart)) {
                $goods[$key]['isshowbtn'] = 1;
                $goods[$key]['curGoodsNum'] = 0;
                $goods[$key]['cart_id'] = 0;
            } else {
                $goods[$key]['isshowbtn'] = 2;
                $goods[$key]['curGoodsNum'] = $goods_cart['c_count'];
                $goods[$key]['cart_id'] = $goods_cart['c_id'];
            }
            $goods_tmp[] = $goods[$key];
            $time_end_arr = $val['at_end_time']-1;//活动结束时间
        }
        $gid_str = trim($gid_str, ',');
        if (!empty($gid_str)) {
            $cates = pdo_fetchall("select gc_id,gc_name from `" . $this->pre . "gpb_goods_to_category` as gtc join " . tablename($this->goods_cate) . " as gc on gc.gc_id = gtc.cate_id where gtc.goods_id in (" . $gid_str . ") and gc.gc_is_index_show =1 ");
        }
    }
    //商品分类去重复
    $goods = $goods_tmp;
    $goods_cate = $cates;
    //查询即将开始的商品
    $sql_after = "select a.at_arrival_time,a.at_end_time,a.at_id,a.at_start_time,gtc.cate_id,g.g_brief,g.g_commission,g.g_has_option,g.g_icon,g.g_id,g.g_info,g.g_is_full_reduce,g.g_is_hot,g.g_is_new,g.g_video,g.g_sale_num,g.g_price,g.g_old_price,g.g_limit_num,g.g_name,c.gc_name,ag.gcg_at_id,ag.gcg_id,gs.sale_num,gs.num from " . tablename($this->action_goods) . " as ag  join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  join " . tablename($this->goods) . "  as g on g.g_id =ag.gcg_g_id left join " . $this->pre . "gpb_goods_to_category as gtc on gtc.goods_id =g.g_id  left join " . tablename($this->goods_cate) . " as c on c.gc_id=gtc.cate_id join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id left join " . tablename($this->action_village) . " as av on av.gav_ac_id = at_id left join " . tablename($this->vg) . " as vg on vg.vg_id = av.gav_v_id where (at_is_limit=1 or (at_is_limit=-1 and vg.openid='" . $member['m_head_openid'] . "')) and at_is_del=1 and at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_start_time > " . time() . " and (g.`type`<>2 or g.`type` is null) and ag.weid=" . $this->weid . $where . " and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL ) GROUP BY g.g_id order by gs.num !=0 desc,g_is_recommand desc,g_order desc,at_start_time desc " . $contion;
    $after_goods = pdo_fetchall($sql_after);
    //查询已有商品的分类
    $after_goods_cate = array();
    $after_gid_str = '';
    if (is_array($after_goods)) {
        $after_goods_tmp = array();
        foreach ($after_goods as $keys => $vals) {
            //当前团长当前商品选择未开启，删除商品
            $del_count = pdo_fetchcolumn("select count(*) from " . tablename($this->team_cancel_goods) . " as tcg where  tcg.openid='" . $member['m_head_openid'] . "' and tcg.tcg_at_g_id =" . $vals['gcg_id']);
            if (!empty($del_count) && $del_count >= 1) {
                //                                    unset($after_goods[$keys]);
                continue;
            }
            $after_gid_str .= ',' . $vals['g_id'];
            $after_goods_cate[$keys] = array('id' => $vals['gc_id'], 'name' => $vals['gc_name']);
            $after_goods[$keys]['priceArry'] = explode('.', $vals['g_price']);
            $after_goods[$keys]['g_icon'] = tomedia($vals['g_icon']);
            $after_goods[$keys]['g_video'] = tomedia($vals['g_video']);
            $after_goods[$keys]['g_video_open'] = empty($vals['g_video']) ? 0 : 1;
            $after_goods_tmp[] = $after_goods[$keys];
        }
        $after_gid_str = trim($gid_str, ',');
        if (!empty($after_gid_str)) {
            $after_goods_cate = pdo_fetchall("select gc_id,gc_name from `" . $this->pre . "gpb_goods_to_category` as gtc join " . tablename($this->goods_cate) . " as gc on gc.gc_id = gtc.cate_id where gtc.goods_id in (" . $after_gid_str . ") and gc.gc_is_index_show =1 group by gc_id");
        }
    }
    //商品分类去重复
    $after_goods = $after_goods;
    $after_goods_cate = $after_goods_cate;
}
$data = array('after_goods'=>$after_goods,'after_goods_cate'=>$after_goods_cate,'goods'=>$goods,'goods_cate'=>$goods_cate,'action_pic'=>$action_pic);
//		if($openid == 'onOoQ5Rf3QM1W8rOEuLu2pxxklic'){
//      	$etime=microtime(true);//获取程序执行结束的时间
//			$total=$etime-$stime;   //计算差值
//			echo "<br />当前页面执行时间为：{$total} 秒";exit;	
//      }
$this->result(0,'',$data);
?>