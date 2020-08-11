<?php
/*ini_set('display_errors',1);
error_reporting(E_ALL);*/
global $_W, $_GPC;
        $openid = trim($_GPC['openid']);
        $this->custting_order_time(1,$openid);//判断平台是否截单
        $file_block = "../addons/group_buy/block/".base64_encode('文件阻塞').".txt";
        $code = $this->nextId();//订单号
        //下单时存地址
        $num = trim($_GPC['num']);
        $gid = trim($_GPC['gid']);
        $at_id = trim($_GPC['at_id']);
        $ggo_id = !empty($_GPC['ggo_id'])?trim($_GPC['ggo_id']):'';
        /*if(!empty($ggo_id) && !empty($_GPC['pteam']) && intval($_GPC['pteam'])>0){
            //反解析规格id
        }*/
        $ggo_title = !empty($_GPC['ggo_title'])?trim($_GPC['ggo_title']):'';
        $ggo = pdo_get('gpb_goods_option', array('ggo_id' => $ggo_id));
        $member = pdo_get('gpb_member', array('m_openid' => $openid));
        $_GPC['head_openid'] = $member['m_head_openid'];
        $formidstr = trim($_GPC['str_tmp'], ',');//模版消息id
        $formidarr = explode(',', $formidstr);
        if (empty($gid)) {
            $this->result("1", "没有该商品");
            exit;
        }
        $goods = pdo_fetch("select * from " . tablename($this->goods) . "  as g left join " . tablename($this->goods_stock) . " as gs on gs.goods_id =g.g_id where g_id = " . $gid . " and (g.`type`<>2 or g.`type` is null) and g.weid =" . $this->weid);
//		if($goods['num'] <= 10){
        if(file_exists($file_block)){
            //如果不存在就新增一个  如果存在  就等待2秒在往下执行  这样是避免多个用户同时下单   但是商品库存不足的情况
            //如果有其他文件访问这个文件  进行加锁  当前的加锁操作就不能执行下去
            $myfile = fopen($file_block , 'r');
            $a = flock($myfile , LOCK_EX|LOCK_NB);
            if(!$a){
                $this->result("1", "请等待前面的人购买购买完成");
            }
//				$myfile = fopen($file_block, "w");
//				if(!flock($myfile,LOCK_EX|LOCK_NB)){
//					$this->result("1", "请等待前面的人购买购买完成");
//				}
        } else {
            //新建文件
            if(!file_exists('../addons/group_buy/block')){
                mkdir ('../addons/group_buy/block',0777,true);
            }
            $myfile = fopen($file_block , 'w');
            $txt = "1";
            fwrite($myfile, $txt);
            fclose($myfile);
            $myfile = fopen($file_block , 'r');
            $a = flock($myfile , LOCK_EX|LOCK_NB);
            if(!$a){
                $this->result("1", "请等待前面的人购买购买完成");
            }
        }
//		}
        if($goods){
            if($goods['g_has_option'] == 1){
                //多规格
                $get = pdo_get("gpb_goods_option",array('ggo_id'=>$ggo_id));
                if($get['ggo_stock'] - $num < 0){
                    if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                    //拼团取消拼团
                    if(!empty($_GPC['pteam']) && $_GPC['pteam']>0){
                        $pteam_act = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where id={$_GPC['pteam']}");
                        if($pteam_act['state']==1){
                            //开团失败
                            pdo_update("gpb_pteam_order",array('state'=>-1),array('aid'=>$_GPC['pteam']));
                            pdo_update("gpb_pteam_activity",array('state'=>-1),array('id'=>$_GPC['pteam']));
                        }
                    }
                    $this->result("1", "库存不足");
                }
            }else{
                //单规格
                //获取库存
                $stock = pdo_get("gpb_goods_stock",array('goods_id'=>$goods['g_id']));
                if($stock['num'] - $num < 0){
                    if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                    //拼团取消拼团
                    if(!empty($_GPC['pteam']) && $_GPC['pteam']>0){
                        $pteam_act = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where id={$_GPC['pteam']}");
                        if($pteam_act['state']==1){
                            //开团失败
                            pdo_update("gpb_pteam_order",array('state'=>-1),array('aid'=>$_GPC['pteam']));
                            pdo_update("gpb_pteam_activity",array('state'=>-1),array('id'=>$_GPC['pteam']));
                        }
                    }
                    $this->result("1", "库存不足");
                }
            }
        }
//			$goods['num'] -= $goods['sale_num'];
        //如果规格不存在
        if (intval($ggo_id) > 0 && empty($ggo)) {
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", $goods['g_name'] . "规格有误，请重新选择购买");
            exit;
        }
        if (!empty($goods['g_limit_num']) and $num > $goods['g_limit_num']) {
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "添加失败，商品单次购买限制数量为" . $goods['g_limit_num']);
        }
        $today = date("Y-m-d", time());
        if (!empty($goods['g_day_limit_num']) && $goods['g_day_limit_num'] != 0) {
            $aleady_buy_num = pdo_fetch("select sum(oss_g_num) as `sum` from " . tablename($this->snapshot) . " as sn left join " . tablename($this->order) . " as o on o.go_code = sn.oss_go_code  where sn.oss_gid=" . $goods['g_id'] . " and  oss_buy_openid = '" . $openid . "' and o.go_add_time >=" . strtotime($today) . " and o.go_add_time<" . (strtotime($today) + 24 * 60 * 60)." and o.go_status != 110 AND o.go_status != 120 ");
            if ((intval($num) + intval($aleady_buy_num['sum'])) > $goods['g_day_limit_num']) {
                if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->result("1", "已超出今日限购数量");
            }
        }
        if (!empty($goods['g_history_limit_num']) && $goods['g_history_limit_num'] != 0) {
            $aleady_buy_num_history = pdo_fetch("select sum(oss_g_num) as `sum` from " . tablename($this->snapshot) . " as sn left join " . tablename($this->order) . " as o on o.go_code = sn.oss_go_code  where sn.oss_gid=" . $goods['g_id'] . " and oss_buy_openid = '" . $openid . "'  and o.go_pay_time >= 0");
            if ((intval($num) + intval($aleady_buy_num_history['sum'])) > $goods['g_history_limit_num']) {
                if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->result("1", $goods['g_name'] . "已超出历史限购数量");
            }
        }
        if (empty($goods['num']) || $goods['num'] <= 0 || $goods['num'] < $num) {
//          pdo_rollback();//失败回滚
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            //拼团取消拼团
            if(!empty($_GPC['pteam']) && $_GPC['pteam']>0){
                $pteam_act = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where id={$_GPC['pteam']}");
                if($pteam_act['state']==1){
                    //开团失败
                    pdo_update("gpb_pteam_order",array('state'=>-1),array('aid'=>$_GPC['pteam']));
                    pdo_update("gpb_pteam_activity",array('state'=>-1),array('id'=>$_GPC['pteam']));
                }
            }
            $this->result("1", $goods['g_name'] . "库存不足");exit;
        }
        /*接受数据-start*/
        if (empty($openid)) {
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "您的授权已过期，请刷新后操作");
            exit;
        }
        if (empty($num)) {
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "未传入商品数量");
            exit;
        }
        if (empty($gid)) {
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "未传入商品数据");
            exit;
        }
        $name = trim($_GPC['name']);
        if (empty($name)) {
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "请传入收货人姓名");
        }
        $phone = trim($_GPC['phone']);
        if (empty($phone)) {
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "请传入收货人电话");
        }
        $adr = trim($_GPC['adr']);//详细收货地址
        if (!empty($name)) {
            $ad_data = [
                'ra_name' => base64_encode($name),
                'ra_phone' => $phone,
                'ra_info' => $adr,
                'ra_is_default' => 1,
                'weid' => $this->weid
            ];
            $adr_num = pdo_fetchcolumn("select count(*) from " . tablename($this->address) . " where openid = '" . $openid . "' and weid=" . $this->weid);
            if ($adr_num > 1 || $adr_num <= 0) {
                pdo_delete($this->address, array('openid' => $openid));
                $ad_data['openid'] = $openid;
                $res = pdo_insert($this->address, $ad_data);
                $address = pdo_insertid();
            } else {
                pdo_update($this->address, $ad_data, ['openid' => $openid]);
                $address = pdo_get($this->address, array('openid' => $openid, 'weid' => $this->weid));
                $address = $address['ra_id'];
            }
        }
        /******收货地址完******/
        $head_openid = trim($_GPC['head_openid']);//团长
        if (empty($head_openid)) {
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "未选择团长");
            exit;
        }
        $vg = pdo_get($this->vg, ['openid' => $head_openid]);
        $vid = $vg['vg_id'];
        $vg_name = $vg['vg_name'];
        if (!isset($vid) || $vid == "" || $vid == null) {
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "请选择小区");
            exit;
        }
        $comment = !empty($_GPC['comment'])?trim($_GPC['comment']):'';//订单备注
        $coupon = trim($_GPC['coupon']);//todo优惠卷关联
        if (!empty($coupon)) {
            $coupon_info_arr = pdo_get($this->user_coupon, ['id' => $coupon, 'weid' => $this->weid, 'status' => 1], ['tid']);//todo 优惠卷的验证还要加强
            $coupon_info = !empty($coupon_info_arr['tid']) ? $coupon_info_arr['tid'] : 0;//todo 优惠卷的验证还要加强
            $coupon_price_arr = pdo_get($this->coupon, ['id' => $coupon_info, 'weid' => $this->weid, 'status' => 1], ['cut_price']);
            $coupon_price = !empty($coupon_price_arr['cut_price']) ? $coupon_price_arr['cut_price'] : 0;//优惠价格
        } else {
            $coupon_price = 0;
        }
        $pay_type = !empty($_GPC['pay_type']) ? trim($_GPC['pay_type']) : 1;//支付方式 1 微信支付
        $send_type = !empty($_GPC['is_send']) ? trim($_GPC['is_send']) : 1;//配送方式
        $seed_pay = !empty($_GPC['send_price']) ? trim($_GPC['send_price']) : 0;//邮费、配送费
        $sure_code = $this->nextId();//订单核销号写这
        pdo_begin();//开启事务
        $data = [
            'go_code' => $code,
            'openid' => $openid,
//          'go_gid'=>$v //不是1对1关系了  不要这个
            'go_adress_id' => $address,
            'go_vid' => $vid,
//          'go_at_id'=>$action[$k]['gcg_at_id']  //不是1对1关系了  不要这个
            'go_fdc_id' => $coupon,
            'go_team_openid' => $head_openid,
            'go_status' => 10,
            'go_add_time' => time(),
//          'go_num'=>empty($num[$k])?1:$num[$k] //不是1对1关系了  不要这个
//          'go_old_price'=>$old_price,
//          'go_price'=>$price,
            'go_fdc_price' => $coupon_price,
//          'go_real_price'=>$real_price,
            'go_sure_code' => $sure_code,
            'go_pay_type' => $pay_type,
            'go_buy_msg' => $comment,
            'go_send_type' => $send_type,
            'weid' => $this->weid,
            'go_send_pay' => $seed_pay,
            'go_send_price_status' => 1,
            'go_order_formid' => isset($formidarr[0]) ? $formidarr[0] : '',
            'go_send_formid' => isset($formidarr[1]) ? $formidarr[1] : '',
            'go_headget_formid' => isset($formidarr[2]) ? $formidarr[2] : '',
            'go_comment'=>!empty($_GPC['notes'])?$_GPC['notes']:'',
            'delivery_time'=>!empty($_GPC['delivery_time'])?$_GPC['delivery_time']:'',
        ];
        $res = pdo_insert($this->order, $data);
        $order_id = pdo_insertid();
        $last_add_id = pdo_insertid();
        //var_dump();
        if (empty($res)) {
            pdo_rollback();//失败回滚
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "订单添加失败");
            exit;
        }
        $info = pdo_fetch("select g_id,g_old_price,g_price,g_name,g_icon,g_brief,g_commission,g_is_full_reduce,member_card_discount from " . tablename($this->goods) . " as g where weid=" . $this->weid . " and g_id = " . $gid . " and (g.`type`<>2 or g.`type` is null) and g_is_del = 1");//单个
        //会员价格
        $discounts = 0;
        $goods_option = pdo_get($this->goods_option, array('ggo_id' => $ggo_id));
        //查询砍价信息
        if(!empty($_GPC['bargain'])){
            //根据商品id去获取砍价信息
            $bargaion_goods = pdo_fetch("select * from ".tablename('gpb_bargain_action').'where goods_id = '.$gid." and status = 2 and openid = '".$openid."'");
            if(empty($bargaion_goods)){
                pdo_rollback();//失败回滚
                if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->result("1", "砍价信息不存在，订单添加失败!");
            }
            $old_price = $info['g_old_price']; //原价
            $price = $bargaion_goods['now_price']; //售价
            $total_prcie = $price * $num;//单商品总价
            $bargain = 2;
            $bargain_money = $bargaion_goods['bargaion_price'];
        } elseif( !empty($_GPC['pteam']) && $_GPC['pteam']>0 ) {
            //加入已有拼团
            //获取拼团信息
            $pteam_time = time();
            $active = pdo_fetch("select pa.*,pl.gid,pl.is_spec,pl.spec_info,pl.price,pl.is_ladder,pl.ladder_info,pl.buy_num,pl.team_num,pl.all_num as buy_all_num from ".tablename("gpb_pteam_list")." as pl left join ".tablename("gpb_pteam_activity")." as pa on pa.pl_id=pl.id and pa.weid=pl.weid where pl.`weid`='{$_W['uniacid']}' and pa.id={$_GPC['pteam']} and pa.end_time>{$pteam_time} and (pa.`state`=2 or pa.state=1) and pa.now_num< pa.all_num and pl.is_sale=1 and pl.star_time<={$pteam_time} and pl.end_time>{$pteam_time}");
            //存在拼团
            if(!empty($active)){
                if($active['state']==1){
                    //对比是否为团长加入
                    if($active['leader_openid']!=$openid){
                        pdo_rollback();//失败回滚
                        if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                        //不存在拼团反回提示
                        $this->result("1", "拼团不存在或已满员!");
                    }
                }else{
                    //是否加入了其他拼团
                    if($openid==$active['leader_openid']){
                        pdo_rollback();//失败回滚
                        if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                        //不能自己参加自己的团
                        $this->result("1", "您已经参加或发起了其他拼团!");
                    }
                    $has_team = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where pl_id={$active['pl_id']} and leader_openid='{$openid}' and (`state`=2 or `state`=1)");
                    if($has_team){
                        pdo_rollback();//失败回滚
                        if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                        //不能自己参加自己的团
                        $this->result("1", "您已经发起了其他拼团，请完成或过期后再试!");
                    }
                    $has_join = pdo_fetch("select * from ".tablename("gpb_pteam_order")." as po join ".tablename("gpb_pteam_activity")." as pa on pa.id=po.aid and pa.pl_id=po.lid where po.lid={$active['pl_id']} and po.`openid`='{$openid}' and  pa.pl_id={$active['pl_id']} and pa.`leader_openid`!='{$openid}' and pa.`state`=2  and pa.end_time>".time());
                    if($has_join){
                        pdo_rollback();//失败回滚
                        if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                        //不能自己参加自己的团
                        $this->result("1", "您已经参加了其他拼团，请完成或过期后再试!");
                    }
                }
                //加入拼团
                //获取当前参团信息
                $pteam = unserialize($active['info']);
//                echo "<pre/>";
//                exit(var_dump($pteam));
                if($pteam['is_spec'] && $ggo_id>0){
                    //多规格商品
                    //获取当前购买规格
                    $spec_inf = unserialize($pteam['spec_info']);
//                    echo "<pre/>";
//                    exit(var_dump(($spec_inf)));
                    $spec_inf = $spec_inf[$ggo_id];
                    if($spec_inf['num']<1){
                        pdo_rollback();//失败回滚
                        if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                        $pteam_act = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where id={$_GPC['pteam']}");
                        if($pteam_act['state']==1){
                            //开团失败
                            pdo_update("gpb_pteam_order",array('state'=>-1),array('aid'=>$_GPC['pteam']));
                            pdo_update("gpb_pteam_activity",array('state'=>-1),array('id'=>$_GPC['pteam']));
                        }
                        //不存在拼团反回提示
                        $this->result("1", "库存不足!");
                    }
//                    echo "<pre/>";
//                    exit(var_dump(($spec_inf)));
                    $old_price = $spec_inf['old_price'];
                    $price = $spec_inf['price'];
                }elseif($pteam['is_ladder']==1){
                    //阶梯团
                    $ladder_info = unserialize($pteam['ladder_info']);
                    $old_price = 0;
                    $price = 0;
                    foreach ($ladder_info as $k=>$v){
                        if($v['num']==$active['all_num']){
                            $old_price = $v['old_price'];
                            $price = $v['price'];
                        }
                    }
                }else{
                    //非多规格商品价格
                    $old_price = $pteam['old_price'];
                    $price = $pteam['price'];
                }
                $total_prcie = $price*$num;
//		        var_dump($old_price.'--'.$price.'--'.$total_prcie);
//		        exit;
                $pteam_info = array(
                    'price'=>$price,
                    'old_price'=>$old_price
                );
            }else{
                pdo_rollback();//失败回滚
                if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                //不存在拼团反回提示
                $this->result("1", "拼团不存在或已满员!");
            }
        }else {
            //普通的立即购买商品
            $member_discount_price = pdo_get("gpb_member_card",array('id'=>$member['level'],'weid'=>$this->weid),array('discount'));
			//每个商品先计算了会员折扣	在进行计算优惠价格
            if($info['member_card_discount'] != 1 && $member['level'] && !empty($info['member_card_discount'])){
                if($info['member_card_discount'] == 2){
                    $unified = pdo_get("gpb_goods_dicount_unified",array('goods_id'=>$info['g_id'],'card'=>$member['level'],'weid'=>$this->weid));
                    if($unified['price']){
//                  	$member_reduce_price = $info['g_price'] - ($unified['price']/100);
						$member_reduce_price = ($info['g_price'] - round($unified['price']/100,2))*$_GPC['num'];//会员卡优惠金额
                        $info['g_price'] = round($unified['price']/100,2);//商品单价
                        $oss_member_price = $info['g_price']*$_GPC['num'];//会员价
                    } else {
                    	$member_reduce_price = ($info['g_price'] - round($info['g_price']*$member_discount_price['discount']/10,2))*$_GPC['num'];//会员卡优惠金额
                        $info['g_price'] = round($info['g_price']*$member_discount_price['discount']/10,2);
//                      $discounts = $info['g_price']*$_GPC['num'];
                        $oss_member_price = round($info['g_price'],2)*$_GPC['num'];
                    }
                }else if($info['member_card_discount'] == 3){
                    $unified = pdo_get("gpb_goods_discount_detailed",array('goods_id'=>$info['g_id'],'caid'=>$member['level'],'weid'=>$this->weid,'gos_id'=>$ggo_id));
                    if($unified['price']){
                    	$member_reduce_price = ($goods_option['ggo_market_price'] - round($unified['price']/100,2))*$_GPC['num'];//会员卡优惠金额
                        $goods_option['ggo_market_price'] = $unified['price']/100;
//                      $goods_option['ggo_market_price'] = $unified['price']/100;
                        $oss_member_price = $goods_option['ggo_market_price']*$_GPC['num'];
                    }else{
                    	$member_reduce_price = ($goods_option['ggo_market_price'] - round($goods_option['ggo_market_price']*$member_discount_price['discount']/10,2))*$_GPC['num'];//会员卡优惠金额
                    	$goods_option['ggo_market_price'] = round($goods_option['ggo_market_price']*$member_discount_price['discount']/10,2);
//                      $discounts = $goods_option['ggo_market_price']*$_GPC['num'];
                        $oss_member_price = round($goods_option['ggo_market_price'],2)*$_GPC['num'];
                    }
                }
            } else {
                if (intval($ggo_id) > 0) {
                    $discounts = $goods_option['ggo_market_price']*$_GPC['num'];
                    if($member_discount_price['discount']){
                    	$member_reduce_price = ($goods_option['ggo_market_price'] - round($goods_option['ggo_market_price']*$member_discount_price['discount']/10,2))*$_GPC['num'];//会员卡优惠金额
                    	$goods_option['ggo_market_price'] = round($goods_option['ggo_market_price']*$member_discount_price['discount']/10,2);
                        $oss_member_price = round($goods_option['ggo_market_price'],2)*$_GPC['num'];
                    }
                } else {
                    $discounts = $info['g_price']*$_GPC['num'];
                    if($member_discount_price['discount']){
                    	$member_reduce_price = ($info['g_price'] - round($info['g_price']*$member_discount_price['discount']/10,2))*$_GPC['num'];//会员卡优惠金额
                    	$info['g_price'] = round($info['g_price']*$member_discount_price['discount']/10,2);
                        $oss_member_price = round($info['g_price'],2)*$_GPC['num'];
                    }
                }
            }
//			$member_reduce_price  //会员卡优惠价格
            if (intval($ggo_id) > 0) {
                $old_price = $goods_option['ggo_old_price']; //原价
                $price = $goods_option['ggo_market_price']; //售价
                $total_prcie = $price * $num;//单商品总价
            } else {
                $old_price = $info['g_old_price']; //原价
                $price = $info['g_price']; //售价
                $total_prcie = $price * $num;//单商品总价
            }
        }
        // $sure_code = $idWork ->nextId();//商品核销号写这
        //开启快照
        $action_info = pdo_get($this->action, ['at_id' => $at_id], ['at_name']);//活动数据
        $head_info = pdo_get($this->member, ['m_openid' => $head_openid, 'weid' => $this->weid]);//团长数据
        $buy_info = pdo_get($this->member, ['m_openid' => $openid, 'weid' => $this->weid]);//买家数据
        $address_info = pdo_get($this->address, ['ra_id' => $address, 'weid' => $this->weid], ['ra_name', 'ra_phone', 'ra_info']);//地址数据
        if (empty($address_info['ra_info']) || $address_info['ra_info'] == 'undefined') {
            $address_info['ra_info'] = $head_info['m_head_address'] . $head_info['m_head_house_address'];
        }
        //计算佣金
        $commission_num = 0;
        $commission_money = 0;
        if (!empty($info['g_commission']) && $info['g_commission'] > 0) {
            $commission_num = intval($info['g_commission']);
        } else {
            $commission_num = intval($head_info['m_commission']);
        }
        //获取是否按订单数计算
        $all_order_commission_open = pdo_get($this->config, array('key' => 'all_order_commission_open', 'weid' => $this->weid));
        $all_order_commission_same = pdo_get($this->config, array('key' => 'all_order_commission_same', 'weid' => $this->weid));
        if (isset($all_order_commission_open['value']) && $all_order_commission_open['value'] == 1) {
            if (isset($all_order_commission_same['value'])) {
                $commission_money = sprintf("%.2f", $all_order_commission_same['value']);
            } else {
                $commission_money = 0;
            }
            $commission_num = 0;
        } else {
            $commission_money = sprintf("%.2f", $commission_num * $total_prcie / 100);
        }
        //查询是否开启满减
        $open_full_reduction = pdo_get($this->config, array('key' => 'open_full_reduction', 'weid' => $this->weid));
        $is_open_full_reduction = 0;
        if (!empty($open_full_reduction) && !empty($open_full_reduction['value'])) {
            $is_open_full_reduction = $open_full_reduction['value'];
            if ($is_open_full_reduction == 1) {
                $all_price_full_reduce = 0;
                $full_reduction_limit_price = pdo_get($this->config, array('key' => 'full_reduction_limit_price', 'weid' => $this->weid));
                $full_reduce_limit = $full_reduction_limit_price['value'];
                $full_reduction_price = pdo_get($this->config, array('key' => 'full_reduction_price', 'weid' => $this->weid));
                $full_reduce_price = $full_reduction_price['value'];
            }
        }
        //是否有满减商品
        $srue_open_full_reduce = 0;
        if ($info['g_is_full_reduce'] == 1 && $is_open_full_reduction == 1) {
            $all_price_full_reduce += $total_prcie;
            $srue_open_full_reduce = 1;
        }
        $shot_data = [
//                'oss_go_id'=>$last_add_id,
            'oss_go_code' => $code,
            'oss_gid' => $gid,
            'oss_g_price' => $price,
            'oss_g_old_price' => $old_price,
            'oss_g_num' => $num,
            'oss_g_name' => $info['g_name'],
            'oss_g_icon' => $info['g_icon'],
            'oss_g_brief' => $info['g_brief'],
            'oss_ac_id' => $at_id,
            'oss_ac_name' => $action_info['at_name'],
            'oss_v_id' => $vid,
            'oss_v_name' => $vg_name,
            'oss_head_openid' => $head_openid,
            'oss_head_name' => $head_info['m_nickname'],
            'oss_head_phone' => $head_info['m_phone'],
            'oss_buy_openid' => $openid,
            'oss_buy_name' => $buy_info['m_nickname'],
            'oss_buy_phone' => $buy_info['m_phone'],
            'oss_address_id' => $address,
            'oss_address' => $address_info['ra_info'],
            'oss_address_name' => ($address_info['ra_name']),
            'oss_address_phone' => $address_info['ra_phone'],
            'oss_total_price' => $total_prcie,
            'oss_ggo_id' => $ggo_id,
            'oss_ggo_title' => $ggo_title,
            'oss_commission_num' => $commission_num,
            'oss_commission' => $commission_money,
            'oss_is_full_reduce' => $srue_open_full_reduce,
            'oss_member_price'=>$oss_member_price,
        ];
        if(!empty($bargain)) {
            $shot_data['oss_is_seckill'] = $bargain;
            $shot_data['oss_member_price'] = $bargain_money;
        }
        //拼团价格覆盖
        if(isset($pteam_info) && !empty($pteam_info)){
            $shot_data['oss_is_seckill'] = 3;
            $shot_data['oss_member_price'] = $pteam_info['price'];
        }
        $res = pdo_insert($this->snapshot, $shot_data);
        $snaphot_id = pdo_insertid();
        //看看需不需要计算分销佣金
        if(file_exists('../addons/group_buy_plugin_distribution/hook.php')){
            $distribution_goods_commison = $this->doPageDistribution_goods_commiosn(array('id'=>$gid,'openid'=>$openid,'num'=>$num,'ggo_id'=>$ggo_id,'order_code'=>$snaphot_id));
            if($distribution_goods_commison['code'] == 1){
                pdo_update($this->snapshot,array('oss_commiosn'=>$distribution_goods_commison['data']),array('oss_id'=>$snaphot_id));
            }
        }
        //获取减少库存方式
        $reduce_stock_type = pdo_get($this->config, array('key' => 'reduce_stock_type', 'weid' => $this->weid));
        if (empty($res)) {
            pdo_rollback();//失败回滚
            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "订单添加失败!!!");
            exit;
        } else {
            if(!empty($bargain) && $bargain){
                //代表是砍价   修改砍价信息的状态
                pdo_update("gpb_bargain_action",array('order_id'=>$code,'status'=>3),array('goods_id'=>$gid,'openid'=>$openid,'status'=>2));
            }
            //获取积分抵扣
            if(empty($bargain)){
                $dode = $this->dodeduction();
                if($dode && $_GPC['dodeduction'] == 1 && $member['integral'] > 0 && !empty($dode['may_use'])){
                    //开启了积分抵扣 并且用户需要使用积分抵扣
                    //判断当前用户有多少积分
                    $integral = (int)$member['integral'];//当前用户的积分
                    //当前商品总支付价格  $total_prcie
                    if($dode['may_use'] < $integral){
                        $integral = $dode['may_use'];
                    }
                    $inter_money = $integral*$dode['deduction'];//当前的积分能抵扣多少钱
                    if($inter_money > $total_prcie){
                        //当积分能抵扣的金额大于支付金额
                        $integral = floor($total_prcie/$dode['deduction']);//整数
                        $inter_money = $integral*$dode['deduction'];//最后计算能抵扣多少金额
                    }
                    $total_prcie -= $inter_money;//将总金额减下来
//					integral order表中积分抵扣字段
                    $order_res = pdo_update('gpb_order',array('integral'=>$inter_money,'limit'=>$integral),array('go_id'=>$order_id));
                    if($order_res && $integral > 0){
                        //订单的数据修改成功  才进行下一步
                        $member_res = pdo_update('gpb_member',array('integral -='=>$integral),array('m_openid'=>$openid));
                        if(empty($member_res)){
                            pdo_rollback();
                            if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                            $this->result("1", "积分抵扣有误".$integral);
                        }
                        //记录日志
                        pdo_insert('gpb_order_log',array('gol_uid'=>$member['m_id'],'gol_add_time'=>time(),'gol_comment'=>'购买商品积分抵扣'.$inter_money.'元','gol_go_code'=>$code,'gol_u_name'=>'用户本身','type'=>2,'intage'=>'-'.$integral));
                    }
                }
            }
            $last_go_data = array();
            //是否有开启会员卡设置了
            //默认会员折扣0元
            $sure_full_reduce_price = 0;
//          $member_reduce_price = 0;
//          $open_member_card_discount_rate = 1;
//          $open_member_card = pdo_get('gpb_config', array('key' => 'card_id', 'type' => 20));
//          if (isset($open_member_card['value']) && $open_member_card['value'] == 1) {
//              //开启会员卡
//              $member_card = pdo_get('gpb_member_card', array('id' => $buy_info['level']));
//              if (!empty($member_card) && $member_card['c_status']) {
//                  $open_member_card_discount_type = 2;
//                  //买过会员卡，并启用了会员折扣
////                  $open_member_card_discount = pdo_get('gpb_config', array('key' => 'card_discount', 'type' => 20));
////                  $open_member_card_discount_type = isset($open_member_card_discount['value']) ? $open_member_card_discount['value'] : 2;
//                  //查看先算还是后算 2先算折扣 1后算
//                  $open_member_card_discount_rate = $member_card['discount'] / 10;
//              }
//          }
//          if($discounts == 0){
//              $open_member_card_discount_type = 0;
//          }
//          if (empty($open_member_card_discount_type)) {
                //不算折扣
                $go_real_prcie = $total_prcie - $coupon_price + $seed_pay;//最终售价
                if ($all_price_full_reduce >= $full_reduce_limit) {
                    $go_real_prcie -= $full_reduce_price;
                    $sure_full_reduce_price = $full_reduce_price;
                }
//          } elseif ($open_member_card_discount_type == 2) {
//              //先算折扣
//              if($discounts > 0){
//                  $member_reduce_price = $discounts * (1 - $open_member_card_discount_rate);//折扣优惠金额
//                  $go_real_prcie = $total_prcie -$member_reduce_price - $coupon_price + $seed_pay;//计算出最终售价
//              }
//              if ($all_price_full_reduce >= $full_reduce_limit) {
//                  $go_real_prcie -= $full_reduce_price;
//                  $sure_full_reduce_price = $full_reduce_price;
//              }
//          } else {
//              pdo_rollback();
//              if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
//              $this->result("1", "折扣计算有误");
//          }
//			go_card_money

//            $go_real_prcie =$total_prcie-$coupon_price+$seed_pay;//最终售价

//            if($all_price_full_reduce >= $full_reduce_limit){

//                $go_real_prcie -= $full_reduce_price;

//                $last_go_data['go_full_reduce_price'] = $full_reduce_price;

//            }

            //当最终售价低于0时

//            if($go_real_prcie<=0){

//                $go_real_prcie = 0.01;

//            }

            //当设置小区限额后

            if ($head_info['m_is_have_limit_pay'] == 2) {

                if ($head_info['m_limit_pay'] > ($go_real_prcie - $seed_pay)) {

                    pdo_rollback();//失败回滚

                    if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}

                    $this->result("1", "订单满" . $head_info['m_limit_pay'] . "元后才能下单");

                    exit;

                }

                if (!empty($order_low_price) && isset($order_low_price['value']) && $order_low_price['value'] > ($go_real_prcie - $seed_pay)) {

                    pdo_rollback();//失败回滚

                    if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}

                    $this->result("1", "订单满" . $order_low_price['value'] . "元后才能下单");

                    exit;

                }

            } else {

                //当开启订单限额后

                $order_low_price_open = pdo_get($this->config, array('key' => 'order_low_price_open', 'weid' => $this->weid));

                if (!empty($order_low_price_open) && isset($order_low_price_open['value']) && $order_low_price_open['value'] == 1) {

                    $order_low_price = pdo_get($this->config, array('key' => 'order_low_price', 'weid' => $this->weid));

                    if (!empty($order_low_price) && isset($order_low_price['value']) && $order_low_price['value'] > ($go_real_prcie - $seed_pay)) {

                        pdo_rollback();//失败回滚

                        if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}

                        $this->result("1", "订单满" . $order_low_price['value'] . "元后才能下单");

                        exit;

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

            $release_today = pdo_fetch(" select sum(money) as moneys from " . tablename("gpb_recharge_list") . " where openid = '" . $openid . "' and overdue =1 and weid = " . $this->weid . ' and `time`=' . strtotime(date('Ymd')));

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
            $go_wx_price = round($go_real_prcie, 2);//最终需要微信支付的钱
            /*--------------------*/
            $last_go_data = array(

                'go_real_price' => $real_price,

                'go_all_price' => $price,

                'go_all_old_price' => $old_price,

                'go_release_price' => $go_release_price,

                'go_balance_price' => $go_balance_price,

                'go_wx_price' => $go_wx_price,

                'go_full_reduce_price' => $sure_full_reduce_price,

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

//                $last_go_data['go_pay_type'] = 1;

//                $real_price = $last_go_data['go_real_price']=$last_go_data['go_wx_price']=$go_wx_price=0.01;

            }

//            $last_go_data = array(

//                'go_real_price'=>$go_real_prcie,

//                'go_all_price'=>$price,

//                'go_all_old_price'=>$old_price

//            );

//            echo "<pre/>";

//            var_dump(['go_id' => $last_add_id, 'weid' => $this->weid]);

//            exit(var_dump($last_go_data));

            $res = pdo_update($this->order, $last_go_data, ['go_id' => $last_add_id, 'weid' => $this->weid]);



            //查询库存

            $stcok = pdo_get($this->goods_stock, array('goods_id' => $gid));//获取库存

            $num_stcok = $stcok['num'] - $num;

            $num_stcok = $num_stcok <= 0 ? 0 : $num_stcok;

            $is = $stcok['sale_num'] + $num;

            //修改库存和添加销量

            if ($reduce_stock_type['value'] == 2) {



                if($goods['g_has_option'] == 1){

                    //多规格

                    $get = pdo_get("gpb_goods_option",array('ggo_id'=>$ggo_id));

                    if($get['ggo_stock'] != -1){

                        //减库存

                        $numss = $get['ggo_stock']-$num;

                        $numss = $numss <= 0 ? 0 : $numss;

                        pdo_update("gpb_goods_option",array('ggo_stock'=>$numss),array('ggo_id'=>$ggo_id));

                        pdo_update($this->goods_stock, array('num'=>$num_stcok, 'sale_num' => $is), array('goods_id' => $gid, 'weid' => $this->weid));

                    }

                }else{

                    pdo_update($this->goods_stock, array('num'=>$num_stcok, 'sale_num' => $is), array('goods_id' => $gid, 'weid' => $this->weid));

                }

            }

        }



        //$res = pdo_insert($this->order,$data);

        //存入订单流水

        $data_stream = array(

            'gos_code' => date('Ymd', time()) . $this->nextId(),//流水号

            'gos_go_code' => $code,//订单号

            'gos_stream_type' => 1,

            'gos_type' => 1,

            'gos_commet' => '立即购买下单支付',

            'gos_owner' => '平台',

            'gos_order_money' => $real_price,

            'gos_payer' => $member['m_nickname'],

            'gos_real_money' => 0,

            'gos_status' => 1,

            'gos_add_time' => time(),

            'weid' => $this->weid,

            'gos_pay_type' => $last_go_data['go_pay_type'],

            'gos_team' => $head_info['m_nickname'],

            'gos_payer_openid' => $openid,

            'gos_team_openid' => $head_openid,

            'gos_wx_pay' => $go_wx_price,

            'gos_release_pay' => $go_release_price,

            'gos_balance_pay' => $go_balance_price

        );

        pdo_insert($this->stream, $data_stream);

        $stream_id = pdo_insertid($this->stream);

        if (!empty($res)) {

            //$go_release_price 返利金

            if ($go_release_price > 0) {

                //获取当前每日反的奖金

                $release_today_list = pdo_fetchall(" select * from " . tablename("gpb_recharge_list") . " where openid = '" . $openid . "' and overdue =1 and weid = " . $this->weid . " and `time`=" . strtotime(date('Ymd')));

                foreach ($release_today_list as $release_today_list_v) {

                    if ($go_release_price - $release_today_list_v['money'] >= 0) {

                        //还没扣完

                        $go_release_price = $go_release_price - $release_today_list_v['money'];

                        pdo_update('gpb_recharge_list', array('list_type' => 4, 'money' => 0, 'use_money' => $release_today_list_v['money']), array('id' => $release_today_list_v['id']));

                        $recharge_log_data = array(

                            'uid' => $member['m_id'],

                            'openid' => $member['m_openid'],

                            'info' => '立即购买扣除返利金' . $release_today_list_v['money'] . '元',

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

                        pdo_update('gpb_recharge_list', array('money' => $release_today_list_v['money'] - $go_release_price, 'use_money' => $go_release_price), array('id' => $release_today_list_v['id']));

                        $recharge_log_data = array(

                            'uid' => $member['m_id'],

                            'openid' => $member['m_openid'],

                            'info' => '立即购买扣除返利金' . $go_release_price . '元',

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

                $res_balance = pdo_update('gpb_member', array('m_money_balance' => $member['m_money_balance'] - $go_balance_price), array('m_id' => $member['m_id']));

                if (!empty($res_balance)) {

                    $recharge_balance_log_data = array(

                        'uid' => $member['m_id'],

                        'openid' => $member['m_openid'],

                        'info' => '立即购买购买扣除余额' . $go_balance_price . '元',

                        'type' => 2,

                        'status' => 1,

                        'create_time' => time(),

                        'weid' => $this->weid,

                        'money' => $go_balance_price,

                        'l_type' => 2,

                        'st' => 2,

                        'remarks' => '订单号：' . $code,

                        'pay_f' => 3

                    );

                    pdo_insert('gpb_recharge_log', $recharge_balance_log_data);

                }

            }

            $res = array();

            if ($last_go_data['go_pay_type'] == 1 || $last_go_data['go_pay_type'] == 3) {

                $total_fee = 0;



                $total_fee = sprintf("%.2f", $go_wx_price);

                $res = $this->pays($total_fee, $openid, $code, $last_add_id, '');

                if ($res['status'] == 0) {

                    $res['gid'] = $code;

                    $res['pay_type'] = $last_go_data['go_pay_type'];

                    pdo_update($this->order, array('go_reduce_stock' => $reduce_stock_type['value'], 'prepay_id' => $res['packages']), array('go_id' => $last_add_id, 'type' => 1, 'weid' => $this->weid));

                } else {

                    pdo_rollback();

                    if(isset($myfile)){

                        flock($myfile,LOCK_UN);fclose($myfile);}

                    $this->result("1", "调取支付失败", $res);

                    exit;

                }

            } elseif ($last_go_data['go_pay_type'] == 2) {



                //查询库存

                $stcok = pdo_get($this->goods_stock, array('goods_id' => $gid));//获取库存

                $num_stcok = $stcok['num'] - $num;

                $num_stcok = $num_stcok <= 0 ? 0 : $num_stcok;

                $is = $stcok['sale_num'] + $num;

                //修改库存和添加销量

                if ($reduce_stock_type['value'] != 2) {

                    if($goods['g_has_option'] == 1){

                        //多规格

                        $get = pdo_get("gpb_goods_option",array('ggo_id'=>$ggo_id));

                        if($get['ggo_stock'] != -1){

                            //减库存

                            $numss = $get['ggo_stock']-$num;

                            $numss = $numss <= 0 ? 0 : $numss;

                            pdo_update("gpb_goods_option",array('ggo_stock'=>$numss),array('ggo_id'=>$ggo_id));

                            pdo_update($this->goods_stock, array('num' => $num_stcok, 'sale_num' => $is), array('goods_id' => $gid, 'weid' => $this->weid));

                        }

                    }else{

                        //因为余额支付是直接完成，只要不是下单减少库存就可以更新

                        $e = pdo_update($this->goods_stock, array('num' => $num_stcok, 'sale_num' => $is), array('goods_id' => $gid, 'weid' => $this->weid));

                    }

                }

                $res['reduce_stock_type'] = $reduce_stock_type;

                $res['gid'] = $code;

                $res['id'] = $last_add_id;

                $res['pay_type'] = $last_go_data['go_pay_type'];

                pdo_update($this->order, array('go_reduce_stock' => $reduce_stock_type['value'], 'prepay_id' => !empty($res['packages'])?$res['packages']:'', 'go_status' => 20, 'go_pay_time' => time()), array('go_id' => $last_add_id, 'type' => 1, 'weid' => $this->weid));


                if(!empty($_GPC['pteam']) && $_GPC['pteam']>0){
                    //检查拼团是否成功
                    $pteam_active = pdo_get("gpb_pteam_activity",array('id'=>$_GPC['pteam'],'weid'=>$this->weid));
                    if($pteam_active['state']==2 && (intval($pteam_active['now_num'])+1)==intval($pteam_active['all_num'])){
                        //查询对应所有订单
                        $pteam_active_order = pdo_fetchall("select o.go_code from ".tablename("gpb_pteam_order")." as po join ".tablename("gpb_order_snapshot")." as os on os.oss_go_code=po.osn join ".tablename("gpb_order")." as o on o.go_code=po.osn where os.oss_is_seckill=3 and po.weid={$this->weid} and po.aid={$_GPC['pteam']} and o.go_status in (20,30) ");
                        foreach ($pteam_active_order as $k=>$v){
                            $this->order_print($v['go_code']);
                        }
                        if(count($pteam_active_order)<$pteam_active['all_num']){
                            $this->order_print($code);
                        }
                    }
                }else{
                    $this->order_print($code);
                }


                $info = pdo_get($this->order, array('go_id' => $order_id));
                //发送模板消息
                $sms = new Sms();
                $sms->weid = $this->weid;
                $this->Token();
//                        send_out($key,$data,$access_token,$openid,$page,$form_id,$weid,$item);
                $sms_array = array('1' => $info['go_code'], '2' => "￥" . $info['go_real_price'], '3' => '支付成功', '4' => date('Y-m-d H:i', $info['go_add_time']), '5' => '如有疑问，请拨打客户热线:');
                $form_id = empty($info['prepay_id']) ? $info['go_order_formid'] : $info['prepay_id'];
                $dass = $sms->send_out('sms_template', $sms_array, $_W['account']['access_tokne'], $openid, 'pages/order/orderDetail?id=' . $info['go_id'], $form_id, $sms->weid, 'AT0229');

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

                $log_content = date('Y-m-d H:i:s') . '，订单余额立即购买支付成功模版消息日志（buyIntimeOrder）' . PHP_EOL;
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
                            $ress = $sms->alicloud($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), array('0' => $member['m_phone'], '1' => $code));
                        }
                    }
                } elseif ($type['value'] == 2) {
                    //创瑞 todo 不一定成
                    if (is_array($phone)) {
                        foreach ($phone as $k => $v) {
                            $ress = $sms->chui($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), $code);
                        }
                    }
                }
                //因为是余额支付，流水生成后就要成功
                $data_stream_sec = array(
                    'gos_real_money' => $real_price,
                    'gos_sure_pay_time' => time(),
                    'gos_commet' => '立即购买下单支付,余额支付立即确认',
                    'gos_pay_type' => $last_go_data['go_pay_type'],
                    'gos_status' => 2,
                    'gos_balance_pay' => $last_go_data['go_balance_price'],
                    'gos_release_pay' => $last_go_data['go_release_price'],
                    'gos_wx_pay' => $last_go_data['go_wx_price'],
                );
                pdo_update($this->stream, $data_stream_sec, array('gos_id' => $stream_id));
                //todo cccc
                $this->pay_success_send_official_account_msg($code);
            }
            //查询剩余购物车数量
            $count_sql = "select sum(c_count) from " . tablename($this->cart) . " where openid = '" . $openid . "' and weid='.$this->weid.'  and c_status=1 and c_is_del = 1";
            $res['numbers'] = pdo_fetchcolumn($count_sql);
            $res['osn'] = $code;
            //更新优惠卷使用
            pdo_update('gpb_user_ticket', array('update_time' => time(), 'is_use' => 1), array('id' => $coupon, 'weid' => $this->weid));
            pdo_commit();
            //文件解锁
            if(isset($myfile)){
                flock($myfile,LOCK_UN);
                fclose($myfile);
            }
            if(!empty($_GPC['pteam']) && $_GPC['pteam']>0){
                //添加拼团订单
                $user = pdo_get("gpb_member",array('m_openid'=>$openid,'weid'=>$this->weid));
//                $active_info = pdo_get("gpb_pteam_activity",array('aid'=>$_GPC['pteam']));
                $pteam_order = [
                    'lid'=>$active['pl_id'],
                    'aid'=>$_GPC['pteam'],
                    'osn'=>$code,
                    'state'=>0,
                    'money'=>$shot_data['oss_member_price'],
                    'num'=>'1',
                    'uid'=>$user['m_id'],
                    'openid'=>$openid,
                    'weid'=>$this->weid,
                    'status'=>1,
                    'ctime'=>time(),
                    'utime'=>time(),
                    'suc_form'=>!empty($_GPC['suc_form'])?$_GPC['suc_form']:'',
                    'fail_form'=>!empty($_GPC['fail_form'])?$_GPC['fail_form']:'',
                ];
                pdo_insert("gpb_pteam_order",$pteam_order);
            }
            $this->result("0", "订单添加成功", $res);
            exit;
        } else {
            //文件解锁
            if(isset($myfile)){
                flock($myfile,LOCK_UN);
                fclose($myfile);
            }
            pdo_rollback();//失败回滚
            $this->result("1", "订单添加失败");
            exit;
        }
?>