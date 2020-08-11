<?php
global $_W, $_GPC;
		$openid = trim($_GPC['openid']);
		$this->custting_order_time(1,$openid);
        $code = $this->nextId();//订单号
        $discount = 0;
        //下单时存地址
        /*接受数据-start*/
//      echo '<pre>';
//		print_r($_REQUEST);exit;
        if (empty($openid)) {
            $this->result("1", "您的授权已过期，请刷新后操作");
            exit;
        }
        $name = trim($_GPC['name']);
        if (empty($name)) {
            $this->result("1", "请传入收货人姓名");
        }
        $phone = trim($_GPC['phone']);
        if (empty($phone)) {
            $this->result("1", "请传入收货人电话");
        }
        $adr = trim($_GPC['adr']);//详细收货地址
        $adr_province = trim($_GPC['adr_province']);//省
        $adr_city = trim($_GPC['adr_city']);//市
        $adr_area = trim($_GPC['adr_area']);//区
        $formidstr = trim($_GPC['str_tmp'], ',');//模版消息id
        $formidarr = explode(',', $formidstr);
        if (!empty($name)) {
            $ad_data = [
                'ra_name' => base64_encode($name),
                'ra_phone' => $phone,
                'ra_is_default' => 1,
                'weid' => $this->weid
            ];
            if (!empty($adr) && $adr != 'undefined') {
                $ad_data['ra_info'] = $adr;
            }
            if (!empty($adr_province) && $adr_province != 'undefined') {
                $ad_data['ra_province'] = $adr_province;
            }
            if (!empty($adr_city) && $adr_city != 'undefined') {
                $ad_data['ra_city'] = $adr_city;
            }
            if (!empty($adr_area) && $adr_area != 'undefined') {
                $ad_data['ra_area'] = $adr_area;
            }
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
        $cart = $_GPC['num'];//购物车id
        if (empty($cart)) {
            $this->result("1", "请传入购物车主键");
        }// todo ***********
        //购物车三种情况
        if ($cart == 'true') {
            $last_sql = "select *,a.at_name from " . tablename($this->cart) . " as c left join " . tablename($this->action) . " as a on a.at_id=c.c_at_id left join " . tablename($this->goods_option) . " as go on go.ggo_id=c.c_ggo_id left join ".tablename($this->goods)." as gd on gd.g_id=c.c_g_id where c.weid=" . $this->weid . " and c.openid='" . $openid . "' and c.c_is_del=1 and c.c_status=1 and gd.g_is_del=1 and gd.g_is_online=1";
            $cart_list = pdo_fetchall($last_sql);
        } elseif ($cart) {
            $last_sql = "select *,a.at_name from " . tablename($this->cart) . " as c left join " . tablename($this->action) . " as a on a.at_id=c.c_at_id left join " . tablename($this->goods_option) . " as go on go.ggo_id=c.c_ggo_id left join ".tablename($this->goods)." as gd on gd.g_id=c.c_g_id where c.weid=" . $this->weid . " and c.openid='" . $openid . "' and c.c_is_del=1 and c.c_status=1 and gd.g_is_del=1 and gd.g_is_online=1 and c.c_id in (" . trim($cart, ',') . ") order by field(c.c_id," . trim($cart, ',') . ")";
            $cart_list = pdo_fetchall($last_sql);
        }
		$ns = 1;
		if($cart_list){
			//判断是否需要阻塞
			foreach($cart_list as $ks=>$vs){
				$info = pdo_fetch("select g.g_name,g.g_has_option,num from " . tablename($this->goods) . " as g left join " . tablename($this->goods_stock) . " as gs on gs.goods_id=g.g_id   where g.weid=" . $this->weid . " and g_id = " . $vs['c_g_id'] . " and (g.`type`<>2 or g.`type` is null) and g.g_is_del = 1");
				if($info['g_has_option'] == 1){
					//多规格
					$get = pdo_get("gpb_goods_option",array('ggo_id'=>$vs['c_ggo_id']));
					if($vs['c_count'] > $get['ggo_stock'] && $get['ggo_stock'] != -1 ){
						//库存 不够
						$this->result("1",$info['g_name']."商品库存不足");
					}
					if($get['ggo_stock'] <= 10 && $get['ggo_stock'] != -1 ){
						$ns = 2;
					}
				}else{
					//获取单规格的库存
					$stock = pdo_get($this->goods_stock,array('goods_id' => $vs['c_g_id'], 'weid' => $this->weid));
					if($stock['num'] < $vs['c_count']){
						$this->result("1","商品库存不足");
					}
//					单规格
					if($info['num'] < 10){
						$ns = 2;
						break;
					}
				}
			}
		}
		if($ns === 2){
			//开启文件锁
			$file_block = "../addons/group_buy/block/".base64_encode('文件阻塞').".txt";
			if(file_exists($file_block)){
		    //如果不存在就新增一个  如果存在  就等待2秒在往下执行  这样是避免多个用户同时下单   但是商品库存不足的情况
				$myfile = fopen($file_block , 'r');
				$a = flock($myfile , LOCK_EX|LOCK_NB);
				if(!$a){
					$this->result("1", "请等待前面的人购买购买完成");
				}
		   	}else{
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
		}

        $count = array_column($cart_list, 'c_count');//关联数量

        $at_name = array_column($cart_list, 'at_name');//关联活动名称

        $gid = array_column($cart_list, 'c_g_id');//关联商品

        $gcg_id = array_column($cart_list, 'c_at_id');//关联活动

        $ggo_market_price = array_column($cart_list, 'ggo_market_price');//关联规格

        $member = pdo_get($this->member, array("m_openid" => $openid, 'weid'=>$this->weid));//读用户数据



        $head_openid = trim($_GPC['head_openid']);//团长

        if (empty($head_openid) || $head_openid == 'undefined') {

            $head_openid = $member;

            if (empty($head_openid)) {

            	//文件解锁

						if(isset($myfile)){

			    			flock($myfile,LOCK_UN);

			    			fclose($myfile);

			   			}

                $this->result("1", "未选择团长");

                exit;

            } else {

                $head_openid = $head_openid['m_head_openid'];

            }

        }

        $send_type = !empty($_GPC['is_send']) ? trim($_GPC['is_send']) : 1;//配送方式

        $vg = pdo_get($this->vg, ['openid' => $head_openid]);

        $vid = $vg['vg_id'];

        $vg_name = $vg['vg_name'];

        if (!isset($vid) || $vid == "" || $vid == null) {

        	//文件解锁

						if(isset($myfile)){

			    			flock($myfile,LOCK_UN);

			    			fclose($myfile);

			   			}

            $this->result("1", "请选择小区");

            exit;

        }



        if (!isset($gid) || empty($gid) || count($gid) <= 0) {

        	//文件解锁

						if(isset($myfile)){

			    			flock($myfile,LOCK_UN);

			    			fclose($myfile);

			   			}

            $this->result("1", "未提交商品");

            exit;

        }



        $comment = trim($_GPC['comment']);//订单备注



        $coupon = trim($_GPC['coupon']);//todo优惠卷关联



        if (!empty($coupon)) {

            $coupon_info_arr = pdo_get($this->user_coupon, ['id' => $coupon, 'weid' => $this->weid, 'status' => 1]);//todo 优惠卷的验证还要加强

            $coupon_info = !empty($coupon_info_arr['tid']) ? $coupon_info_arr['tid'] : 0;//todo 优惠卷的验证还要加强

            $coupon_price_arr = pdo_get($this->coupon, ['id' => $coupon_info, 'weid' => $this->weid, 'status' => 1]);

            $coupon_price = !empty($coupon_price_arr['cut_price']) ? $coupon_price_arr['cut_price'] : 0;//优惠价格

        } else {

            $coupon_price = 0;

        }

        //初始支付

        $pay_type = !empty($_GPC['pay_type']) ? trim($_GPC['pay_type']) : 1;//支付方式 1 微信支付 2余额支付 3余额和微信

        $seed_pay = !empty($_GPC['send_price']) ? trim($_GPC['send_price']) : 0;//邮费或配送费





        /*接受数据-end 处理数据-start*/

        $total_prcie = 0;//初始最终售价

        $sure_code = $this->nextId();//订单核销号写这

        pdo_begin();//开启事务

        $data = [
            'go_code' => $code,
            'openid' => $openid,
//            'go_gid'=>$v //不是1对1关系了  不要这个
            'go_adress_id' => $address,
            'go_vid' => $vid,
//            'go_at_id'=>$action[$k]['gcg_at_id']  //不是1对1关系了  不要这个
            'go_fdc_id' => $coupon,
            'go_team_openid' => $head_openid,
            'go_status' => 10,
            'go_add_time' => time(),
//            'go_num'=>empty($num[$k])?1:$num[$k] //不是1对1关系了  不要这个
//            'go_old_price'=>$old_price,
//            'go_price'=>$price,
            'go_fdc_price' => $coupon_price,
//            'go_real_price'=>$real_price,
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
            'go_comment'=>$_GPC['notes'],
            'delivery_time'=>$_GPC['delivery_time'],
        ];
        $res = pdo_insert($this->order, $data);
        $order_id = pdo_insertid();
        $last_add_id = pdo_insertid();
        //var_dump();
        if (empty($res)) {
            pdo_rollback();//失败回滚
            //文件解锁
			if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
            $this->result("1", "订单添加失败");
            exit;
        }
        //var_dump($cart_list[0]);exit();
        //var_dump($ggo_market_price);
        $today = date("Y-m-d", time());
        //获取减少库存方式
        $reduce_stock_type = pdo_get($this->config, array('key' => 'reduce_stock_type', 'weid' => $this->weid));
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
		//获取等级折扣
		if($member['level']){
			$member_discout = pdo_get("gpb_member_card",array('id'=>$member['level'],'weid'=>$this->weid),array('discount'));
		}
        if (count($cart_list) > 1) {
            $total_prcie = $member_reduce_price = 0;
            $price = $old_price = $num = $all_price = $all_old_price = $discount = 0;
            foreach ($cart_list as $k => $v) {
            	$oss_member_price = 0;
                $info = pdo_fetch("select g_id,g_old_price,g_price,g_name,g_icon,g_brief,g_limit_num,g_day_limit_num,g_commission,g_is_full_reduce,g_history_limit_num,num,gs.sale_num,g.spec_type,g.member_card_discount from " . tablename($this->goods) . " as g left join " . tablename($this->goods_stock) . " as gs on gs.goods_id=g.g_id   where g.weid=" . $this->weid . " and g_id = " . $v['c_g_id'] . " and (g.`type`<>2 or g.`type` is null) and g.g_is_del = 1");
				//先将商品的价格进行会员卡折扣计算	在计算其他的价格
				if($info['member_card_discount'] != 1 && $member['level'] && !empty($info['member_card_discount'])){
					if($info['member_card_discount'] == 2){
						$unified = pdo_get("gpb_goods_dicount_unified",array('goods_id'=>$info['g_id'],'card'=>$member['level'],'weid'=>$this->weid));
						if($unified['price']){
							$member_reduce_price += ($info['g_price'] - round($unified['price']/100,2))*$v['c_count'];
							$info['g_price'] = round($unified['price']/100,2);
							$oss_member_price = $info['g_price']*$v['c_count'];
						}else{
//							$discount += $info['g_price']*$v['c_count'];
							$member_reduce_price += ($info['g_price'] - round($info['g_price']*$member_discout['discount']/10,2))*$v['c_count'];
							$oss_member_price = $info['g_price']*$v['c_count']*$member_discout['discount']/10;
							$info['g_price'] = round($info['g_price']*$member_discout['discount']/10,2);
						}
					}else if($info['member_card_discount'] == 3){
						$unified = pdo_get("gpb_goods_discount_detailed",array('goods_id'=>$info['g_id'],'caid'=>$member['level'],'weid'=>$this->weid,'gos_id'=>$v['c_ggo_id']));
						if($unified['price']){
							$member_reduce_price += ($v['ggo_market_price'] -  round($unified['price']/100,2))*$v['c_count'];
							$v['ggo_market_price'] = round($unified['price']/100,2);
							$oss_member_price = $v['ggo_market_price']*$v['c_count'];
						}else{
//							$discount += $v['ggo_market_price']*$v['c_count'];
							$member_reduce_price += ($v['ggo_market_price'] -  round($v['ggo_market_price']*$member_discout['discount']/10,2))*$v['c_count'];
							$oss_member_price = $v['ggo_market_price']*$v['c_count']*$member_discout['discount']/10;
							$v['ggo_market_price'] = round($v['ggo_market_price']*$member_discout['discount']/10,2);
						}
					}
				}else{
					if ($v['c_ggo_id'] == -1) {
	                    $discount += $info['g_price']*$v['c_count'];
						if($member_discout['discount']){
							$member_reduce_price += ($info['g_price'] -  round($info['g_price']*$member_discout['discount']/10,2))*$v['c_count'];
							$oss_member_price = $info['g_price']*$v['c_count']*$member_discout['discount']/10;
							$info['g_price'] = round($info['g_price']*$member_discout['discount']/10,2);
						}
	                } else {
	                    $discount += $v['ggo_market_price']*$v['c_count'];
						if($member_discout['discount']){
							$member_reduce_price += ($v['ggo_market_price'] -  round($v['ggo_market_price']*$member_discout['discount']/10,2))*$v['c_count'];
							$oss_member_price = $v['ggo_market_price']*$v['c_count']*$member_discout['discount']/10;
							$v['ggo_market_price'] = round($v['ggo_market_price']*$member_discout['discount']/10,2);
						}
	                }
				}
                $ggo = pdo_get('gpb_goods_option', array('ggo_id' => $v['ggo_id']));
//				$info['num'] -= $info['sale_num'];
                //如果规格不存在
                if (intval($v['ggo_id']) > 0 && empty($ggo)) {
                	//文件解锁
					if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                    $this->result("1", $info['g_name'] . "规格有误，请重新加入购物车");
                    exit;
                }
                if (!empty($info['g_limit_num']) && $info['g_limit_num'] != 0 && $v['c_count'] > $info['g_limit_num']) {
                    pdo_rollback();//失败回滚
                    //文件解锁
					if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                    $this->result("1", "超过单次购买数量");
                    exit;
                }
                if (!empty($info['g_day_limit_num']) && $info['g_day_limit_num'] != 0) {
                    $aleady_buy_num = pdo_fetch("select sum(oss_g_num) as `sum` from " . tablename($this->snapshot) . " as sn left join " . tablename($this->order) . " as o on o.go_code = sn.oss_go_code  where sn.oss_gid=" . $info['g_id'] . " and oss_buy_openid = '" . $openid . "' and o.go_add_time >=" . strtotime($today) . " and o.go_add_time<" . (strtotime($today) + 24 * 60 * 60)." and o.go_status != 110 AND o.go_status != 120 ");
                    if ((intval($v['c_count']) + intval($aleady_buy_num['sum'])) > $info['g_day_limit_num']) {
                        pdo_rollback();//失败回滚
                        //文件解锁
						if(isset($myfile)){
			    			flock($myfile,LOCK_UN);
			    			fclose($myfile);
			   			}
                        $this->result("1", $info['g_name'] . "已超出今日限购数量");
                    }
                }
                if (!empty($info['g_history_limit_num']) && $info['g_history_limit_num'] != 0) {
                    $aleady_buy_num_history = pdo_fetch("select sum(oss_g_num) as `sum` from " . tablename($this->snapshot) . " as sn left join " . tablename($this->order) . " as o on o.go_code = sn.oss_go_code  where sn.oss_gid=" . $info['g_id'] . " and oss_buy_openid = '" . $openid . "'  and o.go_pay_time >= 0");
                    if ((intval($v['c_count']) + intval($aleady_buy_num_history['sum'])) > $info['g_history_limit_num']) {
                        pdo_rollback();//失败回滚
                        //文件解锁
						if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                        $this->result("1", $info['g_name'] . "已超出历史限购数量");
                    }
                }
                if (empty($info['num']) || $info['num'] < 0 || $info['num'] < $v['c_count']) {
                    pdo_rollback();//失败回滚
                    //文件解锁
					if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                    $this->result("1", $info['g_name'] . "库存不足");
                }
                if ($v['c_ggo_id'] == -1) {
                	//单规格
                    $price = $info['g_price'];
                    $old_price += $info['g_old_price'];
                } else {
                    $price = $v['ggo_market_price'];
                    $old_price += $v['ggo_old_price'];
                }
                $num = $v['c_count'];
                $each_price = $price * $num;
                //是否有满减商品
                $srue_open_full_reduce = 0;
                if ($info['g_is_full_reduce'] == 1 && $is_open_full_reduction == 1) {
                    $all_price_full_reduce += $each_price;
                    $srue_open_full_reduce = 1;
                }
                $total_prcie += $each_price;
                $all_price += $price;
                $all_old_price += $old_price;
                //开启快照
                $village_info = pdo_get($this->vg, ['vg_id' => $vid, 'weid' => $this->weid], ['vg_name']);//活动数据
                $head_info = pdo_get($this->member, ['m_openid' => $head_openid, 'weid' => $this->weid]);//团长数据
                $buy_info = pdo_get($this->member, ['m_openid' => $openid, 'weid' => $this->weid]);//买家数据
                $address_info = pdo_get($this->address, ['ra_id' => $address, 'weid' => $this->weid], ['ra_name', 'ra_phone', 'ra_all_address', 'ra_info']);//地址数据
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

                        $commission_money = floatval($all_order_commission_same['value']) / count($cart_list);

                        $commission_money = sprintf("%.2f", $commission_money);

                    } else {

                        $commission_money = 0;

                    }

                    $commission_num = 0;

                } else {

                    $commission_money = sprintf("%.2f", $commission_num * $each_price / 100);

                }

                $shot_data = array(

//                    'oss_go_id'=>$last_add_id,

                    'oss_go_code' => $code,

                    'oss_gid' => $v['c_g_id'],

                    'oss_g_price' => $price,

                    'oss_g_old_price' => $old_price,

                    'oss_g_num' => $v['c_count'],

                    'oss_g_name' => $info['g_name'],

                    'oss_g_icon' => $info['g_icon'],

                    'oss_g_brief' => $info['g_brief'],

                    'oss_ac_id' => $v['c_at_id'],

                    'oss_ac_name' => $v['at_name'],

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

                    'oss_total_price' => $each_price,

                    'oss_cart' => $v['c_id'],

                    'oss_ggo_id' => $v['ggo_id'],

                    'oss_ggo_title' => $v['ggo_title'],

                    'oss_commission_num' => $commission_num,

                    'oss_commission' => $commission_money,

                    'oss_is_full_reduce' => $srue_open_full_reduce,

                    'oss_member_price'=>$oss_member_price,

                );

                $res = pdo_insert($this->snapshot, $shot_data);

				$snaphot_id = pdo_insertid();

				//看看需不需要计算分销佣金

				if(file_exists('../addons/group_buy_plugin_distribution/hook.php')){

					$distribution_goods_commison = $this->doPageDistribution_goods_commiosn(array('id'=>$v['c_g_id'],'openid'=>$openid,'num'=>$v['c_count'],'ggo_id'=>$v['ggo_id'],'order_code'=>$snaphot_id));

					if($distribution_goods_commison['code'] == 1){

						pdo_update($this->snapshot,array('oss_commiosn'=>$distribution_goods_commison['data']),array('oss_id'=>$snaphot_id));

					}

				}

                if (empty($res)) {

                    pdo_rollback();//失败回滚

                    //文件解锁

					if(isset($myfile)){

		    			flock($myfile,LOCK_UN);

		    			fclose($myfile);

		   			}

                    $this->result("1", "订单添加失败");

                    exit;

                } else {

//                  查询库存

                    $stcok = pdo_get($this->goods_stock, array('goods_id' => $v['c_g_id'],'weid'=>$this->weid));//获取库存

                    $num_stcok = $stcok['num'] - $v['c_count'];

                    $num_stcok = $num_stcok < 0 ? 0 : $num_stcok;

                    $is = $stcok['sale_num'] + $v['c_count'];

//                  修改库存和添加销量

                    if ($reduce_stock_type['value'] == 2) {

						if($info['g_has_option'] == 1){

							//多规格

							$get = pdo_get("gpb_goods_option",array('ggo_id'=>$v['c_ggo_id']));

							if($get['ggo_stock'] != -1){

								//减库存

								$numss = $get['ggo_stock']-$v['c_count'];

								$numss = $numss < 0 ? 0 : $numss;

								pdo_update("gpb_goods_option",array('ggo_stock'=>$numss),array('ggo_id'=>$v['c_ggo_id']));

								pdo_update($this->goods_stock, array('num'=>$num_stcok, 'sale_num'=>$is), array('goods_id' => $v['c_g_id'], 'weid' => $this->weid));

							}

						}else{

	                        pdo_update($this->goods_stock, array('num'=>$num_stcok, 'sale_num' => $is), array('goods_id' => $v['c_g_id'], 'weid' => $this->weid));

						}

                    }

                }

            }
        } else {
            $info = pdo_fetch("select g_id,g_old_price,g_price,g_name,g_icon,g_brief,g_limit_num,g_day_limit_num,g_commission,g_is_full_reduce,g_history_limit_num,num,sale_num,g.g_has_option,g.member_card_discount from " . tablename($this->goods) . " as g left join " . tablename($this->goods_stock) . " as gs on gs.goods_id=g.g_id where g.weid=" . $this->weid . " and g_id = " . $cart_list[0]['c_g_id'] . " and (g.`type`<>2 or g.`type` is null) and g_is_del = 1");
            $ggo = pdo_get('gpb_goods_option', array('ggo_id' => $cart_list[0]['ggo_id']));
			if($info['member_card_discount'] != 1 && $member['level'] && !empty($info['member_card_discount'])){
				if($info['member_card_discount'] == 2){
					$unified = pdo_get("gpb_goods_dicount_unified",array('goods_id'=>$info['g_id'],'card'=>$member['level'],'weid'=>$this->weid));
					if($unified['price']){
						$member_reduce_price = ($info['g_price'] - round($unified['price']/100,2))*$cart_list[0]['c_count'];//会员卡优惠金额
						$info['g_price'] = round($unified['price']/100,2);
						$oss_member_price = $info['g_price']*$cart_list[0]['c_count'];
					}else{
						$discount += $info['g_price']; //售价
						$member_reduce_price = ($info['g_price'] - round($info['g_price']*$member_discout['discount']/10,2))*$cart_list[0]['c_count'];
						$oss_member_price = $info['g_price']*$cart_list[0]['c_count']*$member_discout['discount']/10;
						$info['g_price'] = round($info['g_price']*$member_discout['discount']/10,2);
					}
				}else if($info['member_card_discount'] == 3){
					$unified = pdo_get("gpb_goods_discount_detailed",array('goods_id'=>$info['g_id'],'caid'=>$member['level'],'weid'=>$this->weid,'gos_id'=>$cart_list[0]['c_ggo_id']));
					if($unified['price']){
						$member_reduce_price = ($info['ggo_market_price'] - round($unified['price']/100,2))*$cart_list[0]['c_count'];
						$info['ggo_market_price'] = round($unified['price']/100,2);
						$cart_list[0]['ggo_market_price'] = round($unified['price']/100,2);
						$oss_member_price = $info['ggo_market_price']*$cart_list[0]['c_count'];
					}else{
						$discount += $cart_list[0]['ggo_market_price']; //售价
						$member_reduce_price = ($cart_list[0]['ggo_market_price'] - round($cart_list[0]['ggo_market_price']*$member_discout['discount']/10,2))*$cart_list[0]['c_count'];
						$oss_member_price = $cart_list[0]['ggo_market_price']*$cart_list[0]['c_count']*$member_discout['discount']/10;
						$cart_list[0]['ggo_market_price'] = round($cart_list[0]['ggo_market_price']*$member_discout['discount']/10,2);
					}
				}
			}else{
				if (empty($cart_list[0]['c_ggo_id']) || $cart_list[0]['c_ggo_id'] == -1) {
	                $discount += $info['g_price']*$cart_list[0]['c_count']; //售价
	                if($member_discout['discount']){
	                	$oss_member_price = $info['g_price']*$cart_list[0]['c_count']*$member_discout['discount']/10;
						$member_reduce_price = ($info['g_price'] - round($info['g_price']*$member_discout['discount']/10,2))*$cart_list[0]['c_count'];
						$info['g_price'] = round($info['g_price']*$member_discout['discount']/10,2);
	                }
	            } else {
	                $discount += $cart_list[0]['ggo_market_price']*$cart_list[0]['c_count']; //售价
	                if($member_discout['discount']){
		                $oss_member_price = $cart_list[0]['ggo_market_price']*$cart_list[0]['c_count']*$member_discout['discount']/10;
						$member_reduce_price = ($cart_list[0]['ggo_market_price'] - round($cart_list[0]['ggo_market_price']*$member_discout['discount']/10,2))*$cart_list[0]['c_count'];
						$cart_list[0]['ggo_market_price'] = round($cart_list[0]['ggo_market_price']*$member_discout['discount']/10,2);
	                }
	            }
			}
//			$info['num'] -= $info['sale_num'];
            //如果规格不存在
            if (intval($cart_list[0]['ggo_id']) > 0 && empty($ggo)) {
            	//文件解锁
				if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->result("1", $info['g_name'] . "规格有误，请重新加入购物车");
                exit;
            }
            if (!empty($info['g_limit_num']) && $info['g_limit_num'] != 0 && $cart_list[0]['c_count'] > $info['g_limit_num']) {
                pdo_rollback();//失败回滚
                //文件解锁
				if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->result("1", "超过单次购买数量");
                exit;
            }
            if (!empty($info['g_day_limit_num']) && $info['g_day_limit_num'] != 0) {
                $aleady_buy_num = pdo_fetch("select sum(oss_g_num) as `sum` from " . tablename($this->snapshot) . " as sn left join " . tablename($this->order) . " as o on o.go_code = sn.oss_go_code  where sn.oss_gid=" . $info['g_id'] . " and oss_buy_openid = '" . $openid . "' and o.go_add_time >=" . strtotime($today) . " and o.go_add_time<" . (strtotime($today) + 24 * 60 * 60)." and o.go_status != 110 AND o.go_status != 120 ");
                if ((intval($cart_list[0]['c_count']) + intval($aleady_buy_num['sum'])) > $info['g_day_limit_num']) {
                    pdo_rollback();//失败回滚
                    //文件解锁
					if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                    $this->result("1", "已超出今日限购数量");
                }
            }
            if (!empty($info['g_history_limit_num']) && $info['g_history_limit_num'] != 0) {
                $aleady_buy_num_history = pdo_fetch("select sum(oss_g_num) as `sum` from " . tablename($this->snapshot) . " as sn left join " . tablename($this->order) . " as o on o.go_code = sn.oss_go_code  where sn.oss_gid=" . $info['g_id'] . " and oss_buy_openid = '" . $openid . "'  and o.go_pay_time >= 0");
                if ((intval($cart_list[0]['c_count']) + intval($aleady_buy_num_history['sum'])) > $info['g_history_limit_num']) {
                    pdo_rollback();//失败回滚
                    if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                    $this->result("1", $info['g_name'] . "已超出历史限购数量");
                }
            }
            if (empty($info['num']) || $info['num'] < 0 || $info['num'] < $cart_list[0]['c_count']) {
                pdo_rollback();//失败回滚
                //文件解锁
				if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
                $this->result("1", $info['g_name'] . "库存不足");
            }
            if (empty($cart_list[0]['c_ggo_id']) || $cart_list[0]['c_ggo_id'] == -1) {
                $old_price = $info['g_old_price']; //原价
                $price = $info['g_price']; //售价
            } else {
                $old_price = $cart_list[0]['ggo_old_price']; //原价
                $price = $cart_list[0]['ggo_market_price']; //售价
            }
            $total_prcie = $price * $cart_list[0]['c_count'];//最终售价
            //是否有满减商品 todo
            $srue_open_full_reduce = 0;
            if ($info['g_is_full_reduce'] == 1 && $is_open_full_reduction == 1) {
                $all_price_full_reduce += $total_prcie;
                $srue_open_full_reduce = 1;
            }
            //开启快照
            $village_info = pdo_get($this->vg, ['vg_id' => $vid, 'weid' => $this->weid], ['vg_name']);//

            $head_info = pdo_get($this->member, ['m_openid' => $head_openid, 'weid' => $this->weid],['m_nickname', 'm_phone', 'm_commission', 'm_is_have_limit_pay', 'm_limit_pay']);//

            $buy_info = pdo_get($this->member, ['m_openid' => $openid, 'weid' => $this->weid]);//

            $address_info = pdo_get($this->address, ['ra_id' => $address, 'weid' => $this->weid], ['ra_name', 'ra_phone', 'ra_info']);//

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

            $shot_data = array(

//                'oss_go_id'=>$last_add_id,

                'oss_go_code' => $code,

                'oss_gid' => $cart_list[0]['c_g_id'],

                'oss_g_price' => $price,

                'oss_g_old_price' => $old_price,

                'oss_g_num' => $cart_list[0]['c_count'],

                'oss_g_name' => $info['g_name'],

                'oss_g_icon' => $info['g_icon'],

                'oss_g_brief' => $info['g_brief'],

                'oss_ac_id' => $cart_list[0]['c_at_id'],

                'oss_ac_name' => $cart_list[0]['at_name'],

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

                'oss_cart' => $cart_list[0]['c_id'],

                'oss_ggo_id' => $cart_list[0]['ggo_id'],

                'oss_ggo_title' => $cart_list[0]['ggo_title'],

                'oss_commission_num' => $commission_num,

                'oss_commission' => $commission_money,

                'oss_is_full_reduce' => $srue_open_full_reduce,

				'oss_member_price'=>$oss_member_price,

            );

            $res = pdo_insert($this->snapshot, $shot_data);

			$snaphot_id = pdo_insertid();

			//看看需不需要计算分销佣金

			

			if(file_exists('../addons/group_buy_plugin_distribution/hook.php')){
				$distribution_goods_commison = $this->doPageDistribution_goods_commiosn(array('id'=>$cart_list[0]['c_g_id'],'openid'=>$openid,'num'=>$cart_list[0]['c_count'],'ggo_id'=>$cart_list[0]['ggo_id'],'order_code'=>$snaphot_id));
				if($distribution_goods_commison['code'] == 1){
					pdo_update($this->snapshot,array('oss_commiosn'=>$distribution_goods_commison['data']),array('oss_id'=>$snaphot_id));
				}
			}
//			pdo_rollback();//失败回滚

//			echo '<pre>';

//			print_r($distribution_goods_commison);

//			exit;

            if (empty($res)) {

                pdo_rollback();//失败回滚

                //文件解锁

					if(isset($myfile)){

		    			flock($myfile,LOCK_UN);

		    			fclose($myfile);

		   			}

                $this->result("1", "订单添加失败");

                exit;

            } else {

                $all_price = $price * $cart_list[0]['c_count'];

                $all_old_price = $old_price * $cart_list[0]['c_count'];



//                查询库存

                $stcok = pdo_get($this->goods_stock, array('goods_id' => $cart_list[0]['c_g_id']));//获取库存

                $num_stcok = $stcok['num'] - $cart_list[0]['c_count'];

                $num_stcok = $num_stcok < 0 ? 0 : $num_stcok;

                $is = $stcok['sale_num'] + $cart_list[0]['c_count'];

//                修改库存和添加销量

                if ($reduce_stock_type['value'] == 2) {

                	

					if($info['g_has_option'] == 1){

						//多规格

						$get = pdo_get("gpb_goods_option",array('ggo_id'=>$cart_list[0]['c_ggo_id']));

						if($get['ggo_stock'] != -1){

							//减库存

							$numss = $get['ggo_stock']-$cart_list[0]['c_count'];

							$numss = $numss < 0 ? 0 : $numss;

							pdo_update("gpb_goods_option",array('ggo_stock'=>$numss),array('ggo_id'=>$cart_list[0]['c_ggo_id']));

							pdo_update($this->goods_stock, array('num'=>$num_stcok, 'sale_num'=>$is), array('goods_id' => $v['c_g_id'], 'weid' => $this->weid));

						}

					}else{

                         pdo_update($this->goods_stock, array('num' => $num_stcok, 'sale_num' => $is), array('goods_id' => $cart_list[0]['c_g_id'], 'weid' => $this->weid));

					}

                }

            }

        }

		//获取积分抵扣
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
			if($inter_money > 0){
				$total_prcie -= $inter_money;//将总金额减下来
//				integral order表中积分抵扣字段
				$order_res = pdo_update('gpb_order',array('integral'=>$inter_money,'limit'=>$integral),array('go_id'=>$order_id));
				if($order_res){
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
//      $member_reduce_price = 0;
//      $open_member_card_discount_rate = 1;
//      $open_member_card = pdo_get('gpb_config', array('key' => 'card_id', 'type' => 20));
//      if (isset($open_member_card['value']) && $open_member_card['value'] == 1) {
//          //开启会员卡
//          $member_card = pdo_get('gpb_member_card', array('id' => $buy_info['level']));
//          if (!empty($member_card) && $member_card['c_status'] == 1) {
//              //买过会员卡，并启用了会员折扣
//              $open_member_card_discount_type = 2;
////              $open_member_card_discount = pdo_get('gpb_config', array('key' => 'card_discount', 'type' => 20));
////              $open_member_card_discount_type = isset($open_member_card_discount['value']) ? $open_member_card_discount['value'] : 2;
//              //查看先算还是后算 2先算折扣 1后算
//              $open_member_card_discount_rate = $member_card['discount'] / 10;
//          }
//      }
//      if (empty($open_member_card_discount_type)) {
            //不算折扣
            $go_real_prcie = $total_prcie - $coupon_price + $seed_pay;//最终售价
            if ($all_price_full_reduce >= $full_reduce_limit) {
                $go_real_prcie -= $full_reduce_price;
                $sure_full_reduce_price = $full_reduce_price;
            }
//      } elseif ($open_member_card_discount_type == 2) {
//          //先算折扣
////          2019-8-17改  下面这两行是最开始的会员卡的算法
////          $member_reduce_price = $total_prcie * (1 - $open_member_card_discount_rate);//折扣优惠金额
////          $go_real_prcie = ($total_prcie * $open_member_card_discount_rate) - $coupon_price + $seed_pay;//最终售价
//			$member_reduce_price = 0;
//			if($discount != 0){
//				$member_reduce_price = $discount * (1 - $open_member_card_discount_rate);//折扣优惠金额
//			}
//			$go_real_prcie = $total_prcie - $member_reduce_price - $coupon_price + $seed_pay;//最终售价
//          if ($all_price_full_reduce >= $full_reduce_limit) {
//              $go_real_prcie -= $full_reduce_price;
//              $sure_full_reduce_price = $full_reduce_price;
//          }
//      }
//		 elseif ($open_member_card_discount_type == 1) {
////            后算折扣
//          $go_real_prcie = $total_prcie - $coupon_price;//最终售价
//          if ($all_price_full_reduce >= $full_reduce_limit) {
//              $go_real_prcie -= $full_reduce_price;
//              $sure_full_reduce_price = $full_reduce_price;
//          }
//          $member_reduce_price = $go_real_prcie * (1 - $open_member_card_discount_rate);//折扣优惠金额
//          $go_real_prcie = $go_real_prcie * $open_member_card_discount_rate + $seed_pay;
//      }
//		 else {
//          pdo_rollback();
//			//文件解锁
//			if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}
//          $this->result("1", "折扣计算有误");
//      }

        //当设置小区限额后

        if ($head_info['m_is_have_limit_pay'] == 2) {

            if ($head_info['m_limit_pay'] > ($go_real_prcie - $seed_pay)) {

                pdo_rollback();//失败回滚

                //文件解锁

				if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}

                $this->result("1", "订单满" . $head_info['m_limit_pay'] . "元后才能下单".$go_real_prcie.'--'.$seed_pay);

                exit;

            }

            if (!empty($order_low_price) && isset($order_low_price['value']) && $order_low_price['value'] > ($go_real_prcie - $seed_pay)) {

                pdo_rollback();//失败回滚

                //文件解锁

				if(isset($myfile)){flock($myfile,LOCK_UN);fclose($myfile);}

                $this->result("1", "订单满" . $order_low_price['value'] . "元后才能下单");

                exit;

            }

        } else {

            //当开启订单限额后

            $order_low_price_open = pdo_get($this->config, array('key' => 'order_low_price_open', 'weid' => $this->weid));

            $order_low_price = pdo_get($this->config, array('key' => 'order_low_price', 'weid' => $this->weid));

            if (!empty($order_low_price_open) && isset($order_low_price_open['value']) && $order_low_price_open['value'] == 1) {

                if (!empty($order_low_price) && isset($order_low_price['value']) && $order_low_price['value'] > ($go_real_prcie - $seed_pay)) {

                    pdo_rollback();//失败回滚

                    //文件解锁

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

        $release_today = pdo_fetch(" select sum(money) as moneys from " . tablename("gpb_recharge_list") . " where  openid = '" . $openid . "' and weid = " . $this->weid . ' and overdue =1 and `time`=' . strtotime(date('Ymd')));

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

            'go_all_price' => $total_prcie,

            'go_all_old_price' => $all_old_price,

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

            //           $last_go_data['go_pay_type'] = 1;

            //           $real_price = $last_go_data['go_real_price']=$last_go_data['go_wx_price']=$go_wx_price=0.01;

        }



        $res = pdo_update($this->order, $last_go_data, ['go_id' => $last_add_id, 'weid' => $this->weid]);

        //查询库存

//      $stcok = pdo_get($this->goods_stock, array('goods_id' => $v['c_g_id']));//获取库存

//      $num_stcok = $stcok['num'] - $v['c_count'];

//      $num_stcok = $num_stcok < 0 ? 0 : $num_stcok;

//      $is = $stcok['sale_num'] + $v['c_count'];

//      //修改库存和添加销量

//      if ($reduce_stock_type['value'] == 2) {

//      	foreach($cart_list as $ks=>$vs){

//      		$info = pdo_fetch("select g_id,g_history_limit_num,num,sale_num,g.g_has_option from " . tablename($this->goods) . " as g left join " . tablename($this->goods_stock) . " as gs on gs.goods_id=g.g_id where g.weid=" . $this->weid . " and g_id = " . $vs['c_g_id'] . " and (g.`type`<>2 or g.`type` is null) and g_is_del = 1");

//				if($info['g_has_option'] == 1){

//					//多规格

//					$get = pdo_get("gpb_goods_option",array('ggo_id'=>$vs['c_ggo_id']));

//					if($get['ggo_stock'] != -1){

//						//减库存

//						$numss = $get['ggo_stock']-$vs['c_count'];

//						$numss = $numss < 0 ? 0 : $numss;

//						pdo_update("gpb_goods_option",array('ggo_stock'=>$numss),array('ggo_id'=>$vs['c_ggo_id']));

//						pdo_update($this->goods_stock, array('num'=>$num_stcok, 'sale_num'=>$is), array('goods_id' => $vs['c_g_id'], 'weid' => $this->weid));

//					}

//				}else{

//					$stcok = pdo_get($this->goods_stock, array('goods_id' => $vs['c_g_id']));//获取库存

//			        $num_stcok = $stcok['num'] - $vs['c_count'];

//					$num_stcok = $num_stcok < 0 ? 0 : $num_stcok;

//			        $is = $stcok['sale_num'] + $vs['c_count'];

//                  pdo_update($this->goods_stock, array('num'=>$num_stcok, 'sale_num' => $is), array('goods_id' => $vs['c_g_id'], 'weid' => $this->weid));

//				}

//      	}

//      }

        //$res = pdo_insert($this->order,$data);

        //存入订单流水

        $data_stream = array(

            'gos_code' => date('Ymd', time()) . $this->nextId(),//流水号

            'gos_go_code' => $code,//订单号

            'gos_stream_type' => 1,

            'gos_type' => 1,

            'gos_commet' => '购物车下单支付订单',

            'gos_owner' => '平台',

            'gos_order_money' => $real_price,

            'gos_payer' => $buy_info['m_nickname'],

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

                $release_today_list = pdo_fetchall(" select * from " . tablename("gpb_recharge_list") . " where  openid = '" . $openid . "' and weid = " . $this->weid . " and overdue =1 and `time`=" . strtotime(date('Ymd')));

                foreach ($release_today_list as $release_today_list_v) {

                    if ($go_release_price - $release_today_list_v['money'] >= 0) {

                        //还没扣完

                        $go_release_price = $go_release_price - $release_today_list_v['money'];

                        pdo_update('gpb_recharge_list', array('list_type' => 4, 'money' => 0, 'use_money +=' => $release_today_list_v['money']), array('id' => $release_today_list_v['id']));

                        $recharge_log_data = array(

                            'uid' => $member['m_id'],

                            'openid' => $member['m_openid'],

                            'info' => '购物车购买扣除返利金' . $release_today_list_v['money'] . '元',

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

                        pdo_update('gpb_recharge_list', array('money' => $release_today_list_v['money'] - $go_release_price, 'use_money +=' => $go_release_price), array('id' => $release_today_list_v['id']));

                        $recharge_log_data = array(

                            'uid' => $member['m_id'],

                            'openid' => $member['m_openid'],

                            'info' => '购物车购买扣除返利金' . $go_release_price . '元',

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

                        'info' => '购物车购买扣除余额' . $go_balance_price . '元',

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

            $res = array();//返回值

            if ($last_go_data['go_pay_type'] == 1 || $last_go_data['go_pay_type'] == 3) {

                //当有微信支付参与时

                $total_fee = 0;

                $total_fee = sprintf("%.2f", $go_wx_price);

                $res = $this->pays($total_fee, $openid, $code, $last_add_id, '');

                if ($res['status'] == 0) {

                    $res['gid'] = $code;

                    $res['pay_type'] = $last_go_data['go_pay_type'];

                    pdo_update($this->order, array('go_reduce_stock' => $reduce_stock_type['value'], 'prepay_id' => $res['packages']), array('go_id' => $order_id, 'type' => 1, 'weid' => $this->weid));

                } else {

                    pdo_rollback();

					//文件解锁

					if(isset($myfile)){

		    			flock($myfile,LOCK_UN);

		    			fclose($myfile);

		   			}

                    $this->result("1", "调取支付失败", $res);

                    exit;

                }

            } elseif ($last_go_data['go_pay_type'] == 2) {

//UPDATE `ims_gpb_goods_stock` SET `num` = 1 , `sale_num` = 2 WHERE `goods_id` = 158 AND `weid` = 6

                foreach ($cart_list as $stock_k => $stock_v) {

                	//获取商品信息

                	$info = pdo_fetch(" select g_id,g_has_option from ".tablename('gpb_goods')." where g_id = ".$vs['c_g_id']);

                    //查询库存

                    $stcok = pdo_get($this->goods_stock, array('goods_id' => $stock_v['c_g_id']));//获取库存

                    $num_stcok = $stcok['num'] - $stock_v['c_count'];

                    $num_stcok = $num_stcok <= 0 ? 0 : $num_stcok;

                    $is = $stcok['sale_num'] + $stock_v['c_count'];

                    //修改库存和添加销量

                    if ($reduce_stock_type['value'] != 2) {

                        //因为余额支付是直接完成，只要不是下单减少库存就可以更新

                        if($info['g_has_option'] == 1){

							//多规格

							$get = pdo_get("gpb_goods_option",array('ggo_id'=>$stock_v['c_ggo_id']));

							if($get['ggo_stock'] != -1){

								//减库存

								$numss = $get['ggo_stock']-$stock_v['c_count'];

								$numss = $numss <= 0 ? 0 : $numss;

								pdo_update("gpb_goods_option",array('ggo_stock'=>$numss),array('ggo_id'=>$stock_v['c_ggo_id']));

							}

							pdo_update($this->goods_stock, array('num'=>$num_stcok, 'sale_num'=>$is), array('goods_id' => $v['c_g_id'], 'weid' => $this->weid));

						}else{

	                          $e = pdo_update($this->goods_stock, array('num' => $num_stcok, 'sale_num' => $is), array('goods_id' => $stock_v['c_g_id'], 'weid' => $this->weid));

						}

                    }

                }

				$res['reduce_stock_type'] = $reduce_stock_type;

                $res['gid'] = $code;

                $res['id'] = $order_id;

                $res['pay_type'] = $last_go_data['go_pay_type'];



                pdo_update($this->order, array('go_reduce_stock' => $reduce_stock_type['value'], 'prepay_id' => '', 'go_status' => 20, 'go_pay_time' => time()), array('go_id' => $order_id, 'type' => 1, 'weid' => $this->weid));



                $this->order_print($code);

                $info = pdo_get($this->order, array('go_id' => $order_id));

                //发送模板消息

//                print_r(get_included_files());//打印所有加载文件

//                exit;

                $sms = new Sms();
                $sms->weid = $this->weid;
                $this->Token();
//                        send_out($key,$data,$access_token,$openid,$page,$form_id,$weid,$item);
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

                $log_content = date('Y-m-d H:i:s') . '，订单余额支付成功模版消息日志（order_status_info）' . PHP_EOL;

                if (is_array($dass)) {

                    foreach ($dass as $dass_k => $dass_v) {

                        $log_content .= 'key:' . $dass_k . ',value:' . $dass_v . PHP_EOL;

                    }

                }

                $log_content .= json_encode(array('sms_head_sure_order', $sms_array, $_W['account']['access_tokne'], $openid, 'pages/order/orderDetail?id=' . $info['go_id'], $form_id, $sms->weid, 'AT0229'), JSON_UNESCAPED_UNICODE);

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

                    'gos_commet' => '购物车下单支付订单,余额支付立即确认',

                    'gos_status' => 2,

                    'gos_pay_type' => $last_go_data['go_pay_type'],

                    'gos_balance_pay' => $last_go_data['go_balance_price'],

                    'gos_release_pay' => $last_go_data['go_release_price'],

                    'gos_wx_pay' => $last_go_data['go_wx_price'],

                );

                pdo_update($this->stream, $data_stream_sec, array('gos_id' => $stream_id));
                //todo cccc
                $this->pay_success_send_official_account_msg($code);
            }
            //下单成功 改变购物车状态
            $cid = implode(",", array_column($cart_list, "c_id"));
            $is = pdo_query("update " . tablename($this->cart) . " set  c_status = 2 where weid=" . $this->weid . " and c_id in (" . $cid . ")");
            pdo_update($this->user_coupon, ['is_use' => 1, 'update_time' => time()], ['id' => $coupon, 'weid' => $this->weid]);
            //查询剩余购物车数量
            $count_sql = "select sum(c_count) from " . tablename($this->cart) . " where openid = '" . $openid . "' and weid='.$this->weid.'  and c_status=1 and c_is_del = 1";
            $res['numbers'] = pdo_fetchcolumn($count_sql);
            pdo_commit();
			//文件解锁
			if(isset($myfile)){
    			flock($myfile,LOCK_UN);
    			fclose($myfile);
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