<?php
global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (!isset($openid) || empty($openid)) {

            $this->result("1", "未传入openid,请重试");

        }

        $this->userSeePay($openid);

        //充值释放金额

        $markrting = new Markrting();

        $markrting->get_member_wxapp($openid);

        /***/

        $sql = "select * from " . tablename($this->member) . " where m_status = 1 and m_openid = '" . $openid . "'";

        $res = pdo_fetch($sql);

        if (empty($res)) {

            $this->result("1", "用户有误");

        }

        //将用户的核销码进行分割

        //判断积分商城是否存在

        $distribution = '';

        $fraction = "";

        if (file_exists("../addons/group_buy_plugin_fraction")) {

            //是否开启积分商城配置

            $member_sroce_show = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'member_sroce_show'));

            if (isset($member_sroce_show['value']) && $member_sroce_show['value'] == 2) {

                $fraction = 0;

            } else {

                $fraction = 1;

            }



        } else {

            $fraction = 0;

        }

        //判断分销商城是否存在

        if (file_exists("../addons/group_buy_plugin_distribution")) {

            $member_distribution_show = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'member_distribution_show'));

            if (isset($member_distribution_show['value']) && $member_distribution_show['value'] == 2) {

                $distribution = 0;

            } else {

                $distribution = 1;

            }

        } else {

            $distribution = 0;

        }

        //判断充值开启？

        $res['over_day_num'] = 0;

        if ($res['level']) {

            $member_card = pdo_get("gpb_member_card", array('id' => $res['level']));

            if ($res['end_level_time'] == 0 && !empty($res['level'])) {

                //永久

                $time = "永久";

                $res['over_day_num'] = '永不';

            } else {

                $time = date("Y-m-d H:i", $res['end_level_time']);

                $res['over_day_num'] = ceil(($res['end_level_time'] - time()) / (24 * 60 * 60));

            }

            $res['member_card'] = $member_card;

            $res['is_show_time'] = $time;

        }

        //是否开启会员卡

        $card_id = pdo_get("gpb_config", array('key' => 'card_id', 'weid' => $this->weid, 'status' => 1));

        //是否开启会员充值

        $mearkrting_id = pdo_get("gpb_config", array('key' => 'markrting_id', 'weid' => $this->weid, 'status' => 1));

	    //是否开启余额充值

        $markrting_release_gold = pdo_get("gpb_config", array('key' => 'markrting_release_gold', 'weid' => $this->weid, 'status' => 1));

        if (!isset($card_id['value']) || empty($card_id['value'])) {

            $card_id = -1;

        } else {

            $card_id = $card_id['value'];

        }

		

        if (!isset($mearkrting_id['value']) || empty($mearkrting_id['value'])) {

            $mearkrting_id = -1;

        } else {

            $mearkrting_id = $mearkrting_id['value'];

        }

		if($mearkrting_id ==-1){

	        if((empty($markrting_release_gold['value']) || $markrting_release_gold['value'] == 2 )){

	            $mearkrting_id = -1;

	        }else{

	            $mearkrting_id = $markrting_release_gold['value'];

	        }

		}

        $res['is_show_card'] = $card_id;

        $res['is_show_mearkrt'] = $mearkrting_id;

        //释放金名字

        $markrting_rebate = pdo_get("gpb_config", array('key' => 'markrting_rebate', 'weid' => $this->weid, 'status' => 1));

        if (empty($markrting_rebate) || !isset($markrting_rebate['value']) || empty($markrting_rebate['value'])) {

            $markrting_rebate = '释放金';

        } else {

            $markrting_rebate = $markrting_rebate['value'];

        }

        $res['markrting_rebate'] = $markrting_rebate;

        $release = pdo_fetch(" select sum(money) as moneys from " . tablename("gpb_recharge_list") . " where openid = '" . $openid . "' and weid = " . $this->weid . " and `time` = " . strtotime(date("Y-m-d 00:00:00", time())));

        $markrting_privilege = pdo_get("gpb_config", array('key' => 'markrting_privilege', 'weid' => $this->weid, 'status' => 1));



        if (empty($markrting_privilege) || empty($markrting_privilege['value'])) {

            $markrting_privilege = tomedia("/addons/group_buy/public/bg/huX2tThAkHTzxx7P2KXhF4hwAUr2HR.png");

        } else {

            $markrting_privilege = tomedia($markrting_privilege['value']);

        }

//        var_dump($markrting_privilege);exit;

        $res['markrting_privilege'] = $markrting_privilege;

        $rebates_money = $this->sc('markrting_rebates_money');

        if (empty($rebates_money)) {

            $rebates_money = "今日实时到账";

        }

        $res['rebates_money'] = $rebates_money;

        if (!empty($release)) {

            $res['markrting_rebate_moneys'] = $release['moneys'];

        } else {

            $res['markrting_rebate_moneys'] = 0;

        }

        //判断是否有返利信息

        $gold = pdo_get("gpb_recharge", array('release_gold' => 1, 'status' => 1, 'weid' => $this->weid));

        $res['gold'] = $gold ? 1 : 2;

        //$supplier = pdo_fetchcolumn($this->supplier,array('openid'=>$openid,'gsp_status'=>1,'weid'=>$this->weid));

        //查询未使用优惠卷的数量

        $no_use_coupon = pdo_fetchcolumn("select count(*) AS user_id,uc.grant_time as start_time,uc.over_time as end_time,c.* from " . tablename($this->user_coupon) . " as uc left join " . tablename($this->coupon) . " as c on uc.tid = c.id   where uc.openid= '" . $openid . "' and uc.weid=" . $this->weid . "  and uc.is_use =0 and uc.is_over= 0 and c.end_time >" . time() . " and  uc.over_time>" . time() . " and uc.status=1 and c.status=1 order by c.end_time desc,over_time desc");

        $res['no_use_coupon'] = empty($no_use_coupon) ? 0 : $no_use_coupon;

        $supplier = pdo_fetchcolumn("select count(*) from " . tablename($this->supplier) . " where openid='" . $openid . "' and gsp_status=1 and weid=" . $this->weid);

        if (!empty($res)) {

            if (!empty($res['m_get_good_code'])) {

                $res['m_get_good_code'] = str_split($res['m_get_good_code']);

            }

            if (!empty($res['qr_code'])) {

//                $res['qr_code'] = $this->http_type.$_SERVER['HTTP_HOST'].$res['qr_code'];

                $res['qr_code'] = 'https://' . $_SERVER['HTTP_HOST'] . $res['qr_code'];

            }

            //获取每个状态的订单数量

            $num1 = pdo_fetch(" select count(*) as count from " . tablename($this->order) . " where go_status = 10 and `type`=1 and openid = '" . $openid . "'");

            $num2 = pdo_fetch(" select count(*) as count from " . tablename($this->order) . " where go_status = 20 and `type`=1 and openid = '" . $openid . "'");

			

            $num3 = pdo_fetch(" select count(*) as count from " . tablename($this->order) . " where (go_status = 30 or go_status = 25 or go_status = 28) and `type`=1 and openid = '" . $openid . "'");//待提货  如果是团长配送  需要 团长收货

            //这里是待收货是两个数据组成的  1种  直接发货的  2种是通过团长收货的

            $order_value = pdo_get("gpb_config",array('key'=>'order_back_send_type','weid'=>$this->weid),array('value'));

			if($order_value['value'] == 2){

				//配送

				$sql = "select count(*) as count from ".tablename($this->order)." o join ".tablename('gpb_distribution_list_order')." lo on o.go_id = lo.go_id join ".tablename('gpb_distribution_list')." l on lo.l_id = l.dl_id where o.weid = ".$this->weid." and o.type = 1 and o.go_is_del = 1 and go_status != 120 and o.go_status != 40 and o.openid = '".$openid."' and o.go_status = 30 and l.dl_status = 30";

			}else{

				 $sql = " select count(*) as count from " . tablename($this->order) . " where openid = '" . $openid . "' and  go_status = '30' and weid = " . $this->weid . " and `type`=1 and go_is_del = 1 and go_status!=120 and go_status !=40 order by go_add_time desc ";

			}

            $num3 = pdo_fetch($sql);

            $num4 = pdo_fetch(" select count(*) as count from " . tablename($this->order) . " where go_status = 90 and `type`=1 and openid = '" . $openid . "'");

            $num5 = pdo_fetch(" select count(*) as count from " . tablename($this->back_money) . " where `weid`=" . $this->weid . " and gbm_status = 10 and openid = '" . $openid . "'");

            $res['order'] = ['0' => $num1, '1' => $num2, '2' => $num3, '3' => $num4, '4' => $num5];

            $res['fraction'] = $fraction;

            $res['distribution'] = $distribution;

            $res['supplier'] = $supplier;



            //如果自己是团长并且没有推荐码

            if ($res['m_is_head'] == 2 && empty($res['m_recommend_code'])) {

                //生成一个推荐码

                $res['m_recommend_code'] = $this->make_coupon_card();

                pdo_update($this->member, array('m_recommend_code' => $res['m_recommend_code']), array('m_id' => $res['m_id']));

            }



            $wechat_id = pdo_get($this->config, array('key' => 'wechat_id', 'weid' => $this->weid, 'type' => 18));

            $wechat_id = isset($wechat_id['value']) ? $wechat_id['value'] : -1;

            $res['wechat_id'] = $wechat_id;

            //查询文章分类栏目名

            $classname = pdo_fetchall('select id,title,icon,`type` from ' . tablename('gpb_article_class') . ' where is_del=1 and  status=1 and weid='.$this->weid.' order by sort asc');

            foreach ($classname as $classname_k => $classname_v) {

                $classname[$classname_k]['icon'] = tomedia($classname_v['icon']);

            }

            $res['classname'] = empty($classname) ? array() : $classname;

            if($this->check_base64_out_json($res['m_nickname'])){

                $res['m_nickname']=base64_decode($res['m_nickname']);

            }

			//获取截单信息

			$arr = $this->custting_order_time(1,$openid,1);

			$res['cuseting'] = $arr;

            $this->result("0", "获取用户信息成功", $res);

        } else {

            $this->result("1", "获取用户信息失败,请重试");

        }

        exit();
?>