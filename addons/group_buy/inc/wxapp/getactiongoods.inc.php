<?php
global $_W, $_GPC;

        $head_openid = trim($_GPC['head_openid']);

        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 10;

        $contion = ' limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;

        $where = "";

        //逻辑：商品id是确定查询

        if (isset($_GPC['gid']) and !empty($_GPC['gid'])) {

            $where .= " and  g_id = '" . intval($_GPC['gid']) . "' ";

        }

        if (empty($head_openid) || $head_openid == 'undefined') {

            //当为空时，采用默认推荐，读取不限制小区的活动商品

            $sql_old = "select * from " . tablename($this->action_goods) . " as ag   join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  join " . tablename($this->goods) . "  as g on g.g_id =ag.gcg_g_id  join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id where at_is_del=1 and (at_is_seckill = -1 or at_is_seckill = 0) and at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time < " . time() . " and ag.weid=" . $this->weid . " and (g.`type`<>2 or g.`type` is null) and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL) order by g_is_recommand desc,g_order desc,at_start_time desc " . $contion;

            $sql_now = "select * from " . tablename($this->action_goods) . " as ag   join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  join " . tablename($this->goods) . "  as g on g.g_id =ag.gcg_g_id   join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id where at_is_del=1 and (at_is_seckill = -1 or at_is_seckill = 0) and at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time > " . time() . " and ag.weid=" . $this->weid . " and (g.`type`<>2 or g.`type` is null) and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL ) order by g_is_recommand desc,g_order desc,at_start_time desc " . $contion;

            //秒杀活动

            $sql_spike = "select * from " . tablename($this->action_goods) . " as ag   join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  join " . tablename($this->goods) . " as g on g.g_id =ag.gcg_g_id  join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id where at_is_del=1 and (at_is_seckill = -1 or at_is_seckill = 0) and at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time > " . time() . " and ag.weid=" . $this->weid . " and (g.`type`<>2 or g.`type` is null) and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL  ) order by g_is_recommand desc,g_order desc,at_start_time desc " . $contion;

        } else {

            //当有团长openid时,查对应的小区

            $vid = array_column(pdo_fetchall("select vg_id from " . tablename($this->vg) . " where  weid=" . $this->weid . " and openid = '" . $head_openid . "' and vg_status=1"), 'vg_id');



            $vid_str = implode(",", $vid);

            //查小区对应的限制活动

            $limit_action = array_column(pdo_fetchall("select gav_ac_id from " . tablename($this->action_village) . " where weid=" . $this->weid . " and  gav_v_id in (" . $vid_str . ")"), 'gav_ac_id');



            $limit_action_str = implode(",", $limit_action);

            if (empty($limit_action_str)) {

                $at_where = "";

            } else {

                $at_where = " or (at_is_del=-1 and at_id in (" . $limit_action_str . "))";

            }



            $sql_old = "select * from " . tablename($this->action_goods) . " as ag   join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  join " . tablename($this->goods) . " as g on g.g_id =ag.gcg_g_id  join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id where (at_is_del=1 " . $at_where . ") and (g.`type`<>2 or g.`type` is null) and at_is_index_show=1 and (at_is_seckill = -1 or at_is_seckill = 0) and g_is_online=1 and g_is_del = 1 and at_end_time < " . time() . " and ag.weid=" . $this->weid . " and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL)  order by g_is_recommand desc,g_order desc,at_start_time desc " . $contion;

            $sql_now = "select * from " . tablename($this->action_goods) . " as ag   join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  join " . tablename($this->goods) . " as g on g.g_id =ag.gcg_g_id  join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id where (at_is_del=1 " . $at_where . ") and (g.`type`<>2 or g.`type` is null) and at_is_index_show=1 and g_is_online=1 and (at_is_seckill = -1 or at_is_seckill = 0) and g_is_del = 1 and at_end_time > " . time() . " and ag.weid=" . $this->weid . "  and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL)   order by g_is_recommand desc,g_order desc,at_start_time desc " . $contion;

            //秒杀活动

            $sql_spike = "select * from " . tablename($this->action_goods) . " as ag   join " . tablename($this->action) . " as a on ag.gcg_at_id = a.at_id  join " . tablename($this->goods) . " as g on g.g_id =ag.gcg_g_id  join " . tablename($this->goods_stock) . " as gs on gs.goods_id = ag.gcg_g_id where (at_is_del=1 " . $at_where . ") and (g.`type`<>2 or g.`type` is null) and at_is_index_show=1 and g_is_online=1 and (at_is_seckill = -1 or at_is_seckill = 0) and g_is_del = 1 and at_end_time > " . time() . " and ag.weid=" . $this->weid . "  and (g.g_end_sale_time >" . time() . " or g.g_is_sale_time <> 1 OR g.g_is_sale_time IS NULL)  order by g_is_recommand desc,g_order desc,at_start_time desc " . $contion;



        }

        $old_data = pdo_fetchall($sql_old);



        $now_data = pdo_fetchall($sql_now);

        //秒杀活动

        $spike = pdo_fetchall($sql_spike);



        foreach ($old_data as $k => $v) {

//            $old_data[$k]['at_start_send_time'] = date("Y-m-d",$v['at_start_send_time']);

//            $old_data[$k]['at_end_send_time'] = date("Y-m-d",$v['at_end_send_time']);

//            $old_data[$k]['g_icon'] = $this->http.'/'.$v['g_icon'];

            $old_data[$k]['g_icon'] = tomedia($v['g_icon']);

            $old_data[$k]['g_video'] = tomedia($v['g_video']);

            $old_data[$k]['g_video_open'] = empty($v['g_video']) ? 0 : 1;

//            $old_data[$k]['g_icon'] = file_exists($this->http.'/'.$v['g_icon'])?$this->http.'/'.$v['g_icon']:$this->https . $_SERVER['HTTP_HOST']."/addons/group_buy/public/images/attachment/".$v['g_icon'];

            $old_data[$k]['g_thumb'] = explode(',', $v['g_thumb']);

            @$buy_people1 = pdo_fetchall("select m.m_photo from " . tablename($this->snapshot) . " as s left join " . tablename($this->member) . " as m on m.m_openid =s.oss_buy_openid where  m.weid=" . $this->weid . " and s.oss_gid =" . $v['g_id'] . " group by m_openid order by oss_id desc limit 9");

            $old_data[$k]['buy_people'] = $buy_people1;



            foreach ($old_data[$k]['g_thumb'] as $key => $val) {

                $old_data[$k]['g_thumb'][$key] = tomedia($val);

            }

            //预计几天后到达

            if (empty($old_data[$k]['at_arrival_time']) && $old_data[$k]['at_arrival_time'] != 0) {

                $old_data[$k]["arrival_time"] = date("m月d日", (time() + ($old_data[$k]["at_arrival_time"] * 24 * 60 * 60)));

            } else {

                $old_data[$k]["arrival_time"] = date("m月d日", (time() + ($old_data[$k]["at_arrival_time"] * 24 * 60 * 60)));

            }

            $old_data[$k]['sale_is_over'] = 0;

            if ($old_data[$k]['g_end_sale_time'] < time()) {

                $old_data[$k]['sale_is_over'] = 1;

            }

        }



        foreach ($now_data as $kk => $vv) {

//            var_dump("select m.m_photo from ".tablename($this->snapshot)." as s left join ".tablename($this->member)." as m on m.m_openid =s.oss_buy_openid where  m.weid=".$this->weid." and s.oss_gid =".$v['g_id']."  group by m_openid order by oss_id desc limit 10");exit;

//            $now_data[$k]['at_start_send_time'] = date("Y-m-d",$v['at_start_send_time']);

//            $now_data[$k]['at_end_send_time'] = date("Y-m-d",$v['at_end_send_time']);

//            $now_data[$k]['g_icon'] = $this->http.'/'.$v['g_icon'];

            $now_data[$kk]['g_icon'] = tomedia($vv['g_icon']);

            $now_data[$kk]['g_video'] = tomedia($vv['g_video']);

            $now_data[$kk]['g_video_open'] = empty($vv['g_video']) ? 0 : 1;

//            $now_data[$k]['g_icon'] = file_exists($this->http.'/'.$v['g_icon'])?$this->http.'/'.$v['g_icon']:$this->https . $_SERVER['HTTP_HOST']."/addons/group_buy/public/images/attachment/".$v['g_icon'];

            $now_data[$kk]['g_thumb'] = explode(',', $vv['g_thumb']);

            @$buy_people2 = pdo_fetchall("select m.m_photo from " . tablename($this->snapshot) . " as s left join " . tablename($this->member) . " as m on m.m_openid =s.oss_buy_openid where  m.weid=" . $this->weid . " and s.oss_gid =" . $vv['g_id'] . "  group by m_openid order by oss_id desc limit 9");



            $now_data[$kk]['buy_people'] = $buy_people2;



            foreach ($now_data[$kk]['g_thumb'] as $key => $val) {

                $now_data[$kk]['g_thumb'][$key] = tomedia($val);

            }

            //预计几天后到达

            if (empty($now_data[$kk]['at_arrival_time']) && $now_data[$kk]['at_arrival_time'] != 0) {

                $now_data[$kk]["arrival_time"] = date("m月d日", (time() + ($now_data[$kk]["at_arrival_time"] * 24 * 60 * 60)));

            } else {

                $now_data[$kk]["arrival_time"] = date("m月d日", (time() + ($now_data[$kk]["at_arrival_time"] * 24 * 60 * 60)));

            }



            $now_data[$kk]['sale_is_over'] = 0;

            if ($now_data[$kk]['g_end_sale_time'] < time()) {

                $now_data[$kk]['sale_is_over'] = 1;

            }

        }



        if (!empty($spike)) {

            foreach ($spike as $kkk => $vvv) {

//                $spike[$k]['at_start_send_time'] = date("Y-m-d",$v['at_start_send_time']);

//                $spike[$k]['at_end_send_time'] = date("Y-m-d",$v['at_end_send_time']);

//	            $spike[$k]['g_icon'] = $this->http.'/'.$v['g_icon'];

                $spike[$kkk]['g_icon'] = tomedia($vvv['g_icon']);

                $spike[$kkk]['g_video'] = tomedia($vvv['g_video']);

                $spike[$kkk]['g_video_open'] = empty($vvv['g_video']) ? 0 : 1;

                $spike[$kkk]['g_thumb'] = explode(',', $vvv['g_thumb']);

                $spike[$kkk]['rate'] = sprintf("%.2f", $vvv['sale_num'] / ($vvv['sale_num'] + $vvv['num']));



                foreach ($spike[$kkk]['g_thumb'] as $key => $val) {

                    $spike[$kkk]['g_thumb'][$key] = tomedia($val);

                }

                //预计几天后到达

                if (empty($spike[$kkk]['at_arrival_time']) && $spike[$kkk]['at_arrival_time'] != 0) {

                    $spike[$kkk]["arrival_time"] = date("m月d日", (time() + ($spike[$kkk]["at_arrival_time"] * 24 * 60 * 60)));

                } else {

                    $spike[$kkk]["arrival_time"] = date("m月d日", (time() + ($spike[$kkk]["at_arrival_time"] * 24 * 60 * 60)));

                }

                $spike[$kkk]['sale_is_over'] = 0;

                if ($spike[$kkk]['g_end_sale_time'] < time()) {

                    $spike[$kkk]['sale_is_over'] = 1;

                }

            }

        }

//        exit;

        $data = [

            'old' => $old_data,

            'now' => $now_data,

        ];

        $list = pdo_fetchall("select m.m_nickname as name,m.m_photo as imgUrl from " . tablename($this->order) . " o join " . tablename($this->member) . " m on o.openid = m.m_openid where m.weid=" . $this->weid . " and o.go_is_del = 1 and o.`type`=1  order by go_add_time desc limit 0,10");

        foreach($list as $k=>$v){

            if($this->check_base64_out_json($v['m_nickname'])){

                $list[$k]=base64_decode($v['m_nickname']);

            }

        }

        $array = ['data' => $data, 'list' => $list, 'spike' => $spike];

        $this->result("0", "查询商品分类成功", $array);

?>