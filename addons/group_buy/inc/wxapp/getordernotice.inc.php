<?php
global $_W, $_GPC;

        $openid = trim($_GPC['openid']);

        if (empty($openid)) {

            $this->result(1, "未授权");

        }

        $goid = trim($_GPC['go_id']);

        $member = pdo_get($this->member, array("weid" => $this->weid, 'm_openid' => $openid));

        $head = pdo_get($this->member, array("weid" => $this->weid, 'm_openid' => $member['m_head_openid']));

        $order = pdo_fetch("select * from " . tablename($this->order) . " where weid=" . $this->weid . " and go_id=" . $goid);

        if (empty($order)) {

            $this->result(1, "暂无订单");

        }

        $order['add_time'] = date('Y-m-d H:i:s', $order['go_add_time']);

        $item = pdo_fetchall("select * from " . tablename($this->snapshot) . " where oss_go_code=" . $order['go_code']);

        foreach ($item as $k => $v) {

            $item[$k]['oss_g_icon'] = tomedia($v['oss_g_icon']);

        }

        $order['item'] = $item;

        //读取下单通知团长的相关配置

        $set_type = pdo_get($this->config, array('key' => 'order_notice_click', 'weid' => $this->weid));

        $text = pdo_get($this->config, array('key' => 'order_notice_title', 'weid' => $this->weid));

        $img_type = pdo_get($this->config, array('key' => 'order_notice_img_type', 'weid' => $this->weid));

        $img = pdo_get($this->config, array('key' => 'order_notice_img', 'weid' => $this->weid));

        $img['value'] = tomedia($img['value']);

        $set_comment = pdo_get($this->config, array('key' => 'order_notice_comment', 'weid' => $this->weid));

        if($this->check_base64_out_json($member['m_nickname'])){

            $member['m_nickname'] = base64_decode($member['m_nickname']);

        }

        if($this->check_base64_out_json($head['m_nickname'])){

            $head['m_nickname'] = base64_decode($head['m_nickname']);

        }

		//判断配置  是采用第几种   发送样式

		$order_sharing_style = $this->sc('order_sharing_style');

		$order_sharing_style_show = $this->sc('order_sharing_style_show');

		if($order_sharing_style == 2){

			//采用第二种分享样式

			//需要获取的参数有

//			判断当前的是今天的第几单了

			$count = pdo_fetchcolumn(" select count(*) from ".tablename("gpb_order")." where go_add_time >= ".strtotime(date("Y-m-d 00:00:00",time()))." and go_add_time < ".strtotime(date("Y-m-d 23:59:59",time())));//当前是多少单

			//获取上面两单的id

			$single = pdo_fetchall(" select go_code from ".tablename("gpb_order")." where go_add_time >= ".strtotime(date("Y-m-d 00:00:00",time()))." and go_add_time < ".strtotime(date("Y-m-d 23:59:59",time()))." order by go_add_time desc limit 0,3");	

			unset($single[0]);	

			if($single){

				foreach($single as $k=>$v){

					//获取上两个订单 买的啥

					$snapshot = pdo_fetch(" select oss_g_name from ".tablename("gpb_order_snapshot")." where oss_go_code = ".$v['go_code']);

					$single[$k]['oss_g_name'] = $snapshot['oss_g_name'];

				}

			}

		}

		$imgs = tomedia("../addons/group_buy/public/diyimages/ts.png");

        $this->result(0, "获取成功", array('member' => $member, 'head' => $head, 'order' => $order, 'set' => array('set_comment' => $set_comment, 'set_type' => $set_type, 'img_type' => $img_type, 'img' => $img, 'text' => $text),'single'=>$single,'count'=>$count,'image'=>$imgs,'order_sharing_style_show'=>$order_sharing_style_show,'order_sharing_style'=>$order_sharing_style));

?>