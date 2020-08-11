<?php
global $_GPC, $_W;
        $openid = trim($_GPC['openid']);
        if (empty($openid)) {
            $this->result("1", "请传入openid");
        }
        $where = " ";

        //逻辑：订单状态是确定查询

        if (isset($_GPC['status']) and !empty($_GPC['status'])) {

            if ($_GPC['status'] == "back_money") {

                $where .= " and  go_status  >40 and go_status<=70  ";

            } elseif ($_GPC['status'] == 20) {

                $where .= " and  ( go_status = 25 or go_status = 28 or go_status=20 )  ";

            } else {

                $where .= " and  go_status = '" . trim($_GPC['status']) . "' ";

            }

        }



        //拼团订单筛选

        if(!empty(intval($_GPC['oss_is_seckill'])) && intval($_GPC['oss_is_seckill'])==3){

            $oss_is_seckill = intval($_GPC['oss_is_seckill']);

            //修改所有已拼团失败订单

            $ntime = time();

            pdo_run("update ".tablename("gpb_pteam_activity")." set `state`=-1 where end_time<= {$ntime} and all_num>now_num and `status`=1");

            pdo_run("update ".tablename("gpb_pteam_activity")." set `state`=10 where end_time>= {$ntime} and all_num=now_num and `status`=1");



            $os = pdo_fetchall("select oss_go_code from ".tablename("gpb_order_snapshot")." where oss_buy_openid='{$openid}' group by oss_go_code ");

            if(!empty($os)){

                $pteam_state = intval($_GPC['pteam_state']);

                $pteam_condition = " and go_code in (";

                $has = 0;

                foreach ($os as $k=>$v){

                    //查找是否存在订单

                    $active_sql = "select * from ".tablename("gpb_pteam_order")." where osn ='{$v['oss_go_code']}' and `weid`={$this->weid}";

                    if($pteam_state!=0){

                        $active_sql .= " and `state`={$pteam_state}";

                    }

                    $active = pdo_fetch($active_sql);

                    if(!empty($active)){

                        $has++;

                        $pteam_condition .= "'{$v['oss_go_code']}',";

                    }

                }

                if($has>0){

                    $pteam_condition = substr($where,0,strlen($where)-1);

                    $pteam_condition = substr($where,0,strlen($where)-1);

                    if(!empty(trim($pteam_condition))){

                        $pteam_condition .= ")";

                        $where .= $pteam_condition;

                    }

                }

                

//                echo "<pre/>";

//                exit(var_dump($where));

            }else{

                $this->result("2", "暂无拼团订单");

            }

        }



        $index = isset($_GPC['page']) ? $_GPC['page'] : 1;

        $pageIndex = $index;

        $pageSize = 10;



        $contion = 'limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;



        $sql = " select * from " . tablename($this->order) . " where openid = '" . $openid . "' " . $where . " and weid = " . $this->weid . " and `type`=1 and go_is_del = 1 and go_status!=120 and go_status !=40 order by go_add_time desc " . $contion;

        if(!empty(intval($_GPC['oss_is_seckill'])) && intval($_GPC['oss_is_seckill'])==3){

            $pwhere = "";

            if(isset($_GPC['pteam_state']) && $_GPC['pteam_state']!=0){

                $pwhere = " and pa.state={$_GPC['pteam_state']}";

            }

            $sql = "select * from ".tablename("gpb_pteam_order")." as po join ".tablename($this->order)." as o on o.go_code=po.osn  join ".tablename("gpb_pteam_activity")." as pa on pa.id=po.aid where po.openid='{$openid}' and po.weid={$this->weid} and pa.status=1 and po.status=1 and o.openid='{$openid}' and o.weid={$this->weid} and o.type=1 and o.go_is_del = 1 and o.go_status not in (120,40) {$pwhere} order by pa.state=2 desc,pa.state=10 desc,pa.state=-1 desc,o.go_id desc ".$contion;

//            exit($sql);

        }

		if($_GPC['status'] == 30){

			//待收货订单 走团长送货流程  和普通的不一样

			//注：这里是配送流程的

			$order = pdo_get("gpb_config",array('key'=>'order_back_send_type','weid'=>$this->weid),array('value'));

			if($order['value'] == 2){

				//重待收货订单里面  需要重写sql	

				$sql = "select * from ".tablename($this->order)." o join ".tablename('gpb_distribution_list_order')." lo on o.go_id = lo.go_id join ".tablename('gpb_distribution_list')." l on lo.l_id = l.dl_id where o.weid = ".$this->weid." and o.type = 1 and o.go_is_del = 1 and go_status != 120 and o.go_status != 40 and o.openid = '".$openid."' and o.go_status = 30 and l.dl_status = 30";

			}

		}

        $list = pdo_fetchall($sql);

        if (!empty($list)) {

            foreach ($list as $k => $v) {

                if ($_GPC['status'] == 10 && !empty($_GPC['status']) && $v['go_status'] == 10) {

                    $order_status = $this->wx_order_status($v['go_code']);

                }



                if(intval($_GPC['oss_is_seckill'])==3 && pdo_tableexists("gpb_pteam_order")){

                    //拼团订单获取对应拼团信息

//                    echo "<pre/>";

//                    exit(var_dump($v));

                    $pteam_order = pdo_fetch("select aid,lid from ".tablename("gpb_pteam_order")." where osn='{$v['go_code']}' and weid={$this->weid} and `openid`='{$openid}'");

                    if(!empty($pteam_order)){

                        //获取对应团队

                        $active = pdo_fetch("select pa.* from ".tablename("gpb_pteam_activity")." as pa join ".tablename("gpb_pteam_list")." as pl on pa.pl_id=pl.id where pa.`id`={$pteam_order['aid']}");

                        $active['info'] = unserialize($active['info']);

                        $list[$k]['pteam'] = $active;

                    }

                }





                if ($order_status['trade_state'] == 'SUCCESS' && $order_status['return_code'] == 'SUCCESS') {

                    $rownum = pdo_update($this->order, ['go_status' => 20, 'go_pay_time' => time()], array('go_code' => $v["go_code"], 'weid' => $this->weid));

                    if (empty($rownum)) {



                    } else {

                        //获取商品信息

                        $info = pdo_getall($this->snapshot, array('oss_go_code' => $v["go_code"]));

                        $phone = $info[0]['oss_buy_phone'];

                        if (!empty($info)) {

                            foreach ($info as $k => $v) {

                                $stcok = pdo_get($this->goods_stock, array('goods_id' => $v['oss_gid']));//获取库存

                                $num = $stcok['num'] - $v['oss_g_num'];

                                $num = $num <= 0 ? 0 : $num;

                                $is = $stcok['sale_num'] + $v['oss_g_num'];

                                //获取减少库存方式

                                $reduce_stock_type = pdo_get($this->config, array('key' => 'reduce_stock_type', 'weid' => $this->weid));

                                //修改库存和添加销量

                                if ($reduce_stock_type['value'] == 2) {

                                    pdo_update($this->goods_stock, array('sale_num' => $is), array('goods_id' => $v['oss_gid'], 'weid' => $this->weid));

                                } else {

                                    pdo_update($this->goods_stock, array('num' => $num, 'sale_num' => $is), array('goods_id' => $v['oss_gid'], 'weid' => $this->weid));

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

                                    $order = pdo_fetchall("select * from " . tablename($this->order) . " as o left join " . tablename($this->snapshot) . " as sn on sn.oss_go_code = o.go_code left join " . tablename($this->vg) . " as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=" . $v["go_code"] . " and o.weid=" . $this->weid);

                                    foreach ($order as $k => $v) {

                                        $goods[$k]['title'] = $v['oss_g_name'];

                                        $goods[$k]['price'] = $v['oss_g_price'];

                                        $goods[$k]['num'] = $v['oss_g_num'];

                                        $goods[$k]['spec'] = trim($v['oss_ggo_title']);

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

                                        $order[0]['oss_address_name'] = base64_decode($order[0]['oss_address_name']);

                                    }

                                    $res = $print_class->print_info($config['print_sn'], $v["go_code"], $order[0]['oss_v_name'], $goods, $adr, $order[0]['oss_address_phone'], $order[0]['oss_address_name'], $order[0]['go_real_price'], $lead_info, $order[0]['go_comment'] = '', $qrcode = '', $order[0]['go_add_time'], '', $pay_type, $order_print_auto_num_val, $reduce_price, $send_price, $send_type);

									sleep(1);

                                }



                            }



                        }

                        $info = pdo_get($this->order, array('go_code' => $v["go_code"], 'weid' => $this->weid, 'type' => 1));

                        //发送模板消息

                        $sms = new Sms();

                        $sms->weid = $this->weid;

                        $this->Token();

//                        send_out($key,$data,$access_token,$openid,$page,$form_id,$weid,$item);

                        $sms_array = array('1' => $info['go_code'], '2' => "￥" . $info['go_real_price'], '3' => '支付成功', '4' => date('Y-m-d H:i', $info['go_add_time']), '5' => '如有疑问，请拨打客户热线:');

                        //模版id

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

                        $log_content = date('Y-m-d H:i:s') . '，订单支付成功模版消息日志（getOrder）' . PHP_EOL;

                        if (is_array($dass)) {

                            foreach ($dass as $dass_k => $dass_v) {

                                $log_content .= 'key:' . $dass_k . ',value:' . $dass_v . PHP_EOL;

                            }

                        }

                        $log_content .= json_encode(array('sms_template', $sms_array, $_W['account']['access_tokne'], $openid, 'pages/order/orderDetail?id=' . $info['go_id'], $form_id, $sms->weid, 'AT0229'), JSON_UNESCAPED_UNICODE);

                        $log_content .= '----------end------------' . PHP_EOL;

                        $this->txt_logging_fun('sms_AT0229_log.txt', $log_content);

//                            pdo_insert('gpb_config',array('value'=>serialize($dass),'name'=>$info['prepay_id']));

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

                                foreach ($phone as $k => $v_phone) {

                                    $res = $sms->alicloud($v_phone, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), array('0' => $order[0]['oss_buy_phone'], '1' => $v_phone["go_code"]));

                                }

                            }

                        } elseif ($type['value'] == 2) {

                            //创瑞 todo 不一定成

                            if (is_array($phone)) {

                                foreach ($phone as $k => $v_phone) {

                                    $res = $sms->chui($v_phone, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), $v["go_code"]);

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

                                'gos_commet' => '进入订单页确定支付完成..',

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

                                'gos_commet' => $old_stream['gos_commet'] . ',后进入订单页确定支付完成',

                                'gos_status' => 2

                            );

                            pdo_update($this->stream, $data_stream, array('gos_id' => $old_stream['gos_id']));

                        }

                        $info['go_add_time'] = date('Y-m-d', $info['go_add_time']);



                    }

                    //todo cccc

                    $this->pay_success_send_official_account_msg($info['go_code']);



                    unset($list[$k]);

                    continue;



                } else {

                    $info = pdo_fetchall(" select a.*,m.m_photo from " . tablename($this->member) . " as m join " . tablename($this->snapshot) . " as a on m.m_openid = a.oss_head_openid where m.weid=" . $this->weid . " and a.oss_go_code = '" . $v['go_code'] . "'");

                    $count = count($info);



//                $info = pdo_getall($this->snapshot,array('oss_go_code = '.$v['go_code']));

                    if (!empty(($info))) {

                        $money = 0;

                        foreach ($info as $i => $j) {

//                                $info[$i]['oss_g_icon'] = $this->http.$j['oss_g_icon'];

                            $info[$i]['oss_g_icon'] = tomedia($j['oss_g_icon']);

                            $ins = $j['oss_g_num'] * $j['oss_g_price'];

                            $money += $ins;

                            if($this->check_base64_out_json( $j['m_nickname'] )){

                                $info[$i]['m_nickname'] = base64_decode( $j['m_nickname'] );

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

                    $list[$k]['goods_count'] = $count;

                    $list[$k]['xx'] = $order_status;

                }
//                    $list_tmp = $list[$k];
            }
//                $list = array_filter($list);
        }
//        }
        if (empty($list)) {
            $this->result("1", "查询订单失败，请重试");
        } else {
            $this->result("0", "查询订单成功", $list);
        }
?>