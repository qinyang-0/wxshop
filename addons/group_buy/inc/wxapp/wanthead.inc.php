<?php
global $_W, $_GPC;
        $openid = trim($_GPC['openid']);
        if (empty($openid)) {
            $this->result("1", "您的授权已过期，请刷新后操作");
            exit;
        }
        $count = pdo_fetchcolumn('select count(*) from ' . tablename($this->ah) . " where weid=" . $this->weid . " and ah_status = 1 and ah_result=1 and openid= '" . $openid . "'");
        if ($count > 0) {
            $this->result("1", "您提交的申请还没审核，请稍候");
            exit;
        }


        //是否已经通过了审核 2020-02-24 周龙
        $is_header = pdo_fetchcolumn("select count(*) from ".tablename($this->ah)." where weid={$this->weid} and ah_result=-2 and openid='{$openid}' and ah_status=1");
        if($is_header>0){
            $this->result("1", "您已经是团长了,请勿重复申请!");
            exit;
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
        $ah_code = trim($_GPC['recommend_code']);
        $m_head_house_address = trim($_GPC['adrdetail']);
        if (!isset($name) || $name == "" || $name == null) {
            $this->result("1", "请输入姓名");
            exit;
        }
        if (!isset($phone) || $phone == "" || $phone == null) {
            $this->result("1", "请输入手机号");
            exit;
        }
//        if( !isset($account) || $account == "" || $account ==null   ){
//            $this->result("1","请输入微信号");exit;
//        }
        if (!isset($shop_name) || $shop_name == "" || $shop_name == null) {
            $this->result("1", "请输入店铺名");
            exit;
        }
        if (!isset($openid) || $openid == "" || $openid == null) {
            $this->result("1", "未授权");
            exit;
        }
        if (!isset($addresss) || $addresss == "" || $addresss == null || empty($lng) || empty($lat)) {
            $this->result("1", "请输入地址");
            exit;
        }
//        if(empty($region)){
//            $this->result("1","请选择所在地区");exit;
//        }
//        $old = pdo_getall($this->ah,array('weid'=>$this->weid,'openid'=>$openid));
        $data = [
            "ah_name" => $name,
            "ah_phone" => $phone,
            "ah_shop_name" => $shop_name,
            "openid" => $openid,
            "ah_wx_account" => $account,
            "ah_address" => $addresss,
            "ah_head_house_address" => $m_head_house_address,
            "ah_lng" => $lng,
            "ah_lat" => $lat,
            "ah_add_time" => time(),
            'form_id' => $form_id,
            'weid' => $this->weid
        ];
        //如果是有推荐码记录
        if (!empty($ah_code)) {
            $recommend = pdo_get($this->member, array('m_recommend_code' => $ah_code, 'm_is_head' => 2));
            if (!empty($recommend)) {
                $data['ah_code'] = $recommend['m_recommend_code'];
                $data['ah_recommend_openid'] = $recommend['m_openid'];
                $data['ah_recommend_nickname'] = $recommend['m_nickname'];
            }
        }
        pdo_begin();
        $res_ah = pdo_insert($this->ah, $data);
        if (empty($res_ah)) {
            pdo_rollback();
            $this->result("1", "申请失败，请重试");
            exit;
        }
        //查询省市区的code
        //暂无 台湾  香港  澳门  如需则要升级数据库
        $sheng_arr = pdo_get('gpb_area', array('pid' => 0, 'name' => $sheng));
        if (!empty($sheng_arr)) {
            $city_arr = pdo_get('gpb_area', array('pid' => $sheng_arr['ad_code'], 'name' => $city));
            if (!empty($city_arr)) {
                $area_arr = pdo_get('gpb_area', array('pid' => $city_arr['ad_code'], 'name' => $area));
            }
        }
        $old_vg = pdo_fetch("select * from " . tablename($this->vg) . " where weid =" . $this->weid . " and openid = '" . $openid . "'");
        //如果没有之前的小区数据
        if (empty($old_vg)) {
            $data_rg = array(
                'rg_name' => $shop_name,

                'rg_province_id' => empty($sheng_arr) ? "" : $sheng_arr['ad_code'],

                'rg_city_id' => empty($city_arr) ? "" : $city_arr['ad_code'],

                'rg_area_id' => empty($area_arr) ? "" : $area_arr['ad_code'],

                'rg_add_time' => time(),

                'weid' => $this->weid,

                'rg_all_area' => $region,

                'rg_status' => -1

            );

            $res_rg = pdo_insert($this->rg, $data_rg);

            if (!empty($res_rg)) {

                $res_rg_id = pdo_insertid();

            } else {

                pdo_rollback();

                $this->result("1", "申请失败，请重新确认所在地区");

                exit;

            }

            $data_vg = array(

                'vg_name' => $shop_name,

                'vg_rg_id' => $res_rg_id,

                'vg_team_name' => $shop_name,

                'vg_address' => $addresss . $m_head_house_address,

                'vg_longitude' => $lng,

                'vg_latitude' => $lat,

                'vg_add_time' => time(),

                'vg_pick_address' => $addresss . $m_head_house_address,

                'weid' => $this->weid,

                'openid' => $openid,

                'vg_status' => -1

            );

            $res_vg = pdo_insert($this->vg, $data_vg);

            if (!empty($res_vg)) {

                $res_vg_id = pdo_insertid();

            } else {

                pdo_rollback();

                $this->result("1", "申请失败，请重新确认所在地区");

                exit;

            }

        } else {

            //如果之前有申请人的小区记录

            $data_rg = array(

                'rg_name' => $shop_name,

                'rg_province_id' => empty($sheng_arr) ? "" : $sheng_arr['ad_code'],

                'rg_city_id' => empty($city_arr) ? "" : $city_arr['ad_code'],

                'rg_area_id' => empty($area_arr) ? "" : $area_arr['ad_code'],

                'rg_update_time' => time(),

                'rg_all_area' => $region,

                'rg_status' => -1

            );

            $res_rg = pdo_update($this->rg, $data_rg, array('weid' => $this->weid, 'rg_id' => $old_vg['vg_rg_id']));

            if (!empty($res_rg)) {



            } else {

                pdo_rollback();

                $this->result("1", "申请失败，请重新确认所在地区");

                exit;

            }

            $data_vg = array(

                'vg_name' => $shop_name,

                'vg_team_name' => $shop_name,

                'vg_address' => $addresss . $m_head_house_address,

                'vg_longitude' => $lng,

                'vg_latitude' => $lat,

                'vg_update_time' => time(),

                'vg_pick_address' => $addresss . $m_head_house_address,

                'vg_status' => -1
            );
            $res_vg = pdo_update($this->vg, $data_vg, array('weid' => $this->weid, 'openid' => $openid, 'vg_id' => $old_vg['vg_id']));
            if (!empty($res_vg)) {
            } else {
                pdo_rollback();
                $this->result("1", "申请失败，请重新确认所在地区");
                exit;
            }
        }
        pdo_update($this->member, array('m_last_location' => $region), array('m_openid' => $openid));
        pdo_commit();
        if (empty($res_ah)) {
            $this->result("1", "申请失败，请重试");
            exit;
        } else {
            //短信通知管理员
            $account = pdo_get($this->member, array('m_openid' => $openid, 'weid' => $this->weid));
            $type = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_type'));
            $set = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_watir'));
            $phone = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_admin'));
            $data = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'sms_data'));
            $phone = unserialize($phone['value']);
            $data = unserialize($data['value']);
            $set = unserialize($set['value']);
            $sms = new Sms();
            $sms->weid = $this->weid;
            if ($type['value'] == 1) {
                //阿里云
                if (is_array($phone)) {
                    foreach ($phone as $k => $v) {
                        $res = $sms->alicloud($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), array('0' => $account['m_nickname'], '1' => $account['m_phone']));
                    }
                }
            } elseif ($type['value'] == 2) {
                //创瑞 todo 不一定成
                if (is_array($phone)) {
                    foreach ($phone as $k => $v) {
                        $res = $sms->chui($v, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), $account['m_nickname']);
                    }
                }
            }


            //新增公众号消息 周龙 2020-03-05
            $openids = pdo_fetchcolumn("select `value` from ".tablename("gpb_config")." where `key`='refund_msg_openid' and `weid`={$this->weid} and `status`=1");
            if(!empty($openids)){
                //设置的有才发送
                //是否多个
                $subwechat = new \SubWechat();
                $arr = explode(",",$openids);
                if(is_array($arr) && count($arr)>1){

                    $subwechat_arr = [
                        '您有新的团长申请请及时处理',
                        $_GPC['name'],
                        $account['m_phone'],
                        date('Y-m-d H:i:s',time()),
                        $addresss . $m_head_house_address
                    ];
                    foreach ($arr as $k=>$v){
                        $subwechat->sendunimsg("tmp_headmsg",$v,$subwechat_arr);
                    }
                }else{
                    //只有一个直接发送
                    $subwechat_arr = [
                        '您有新的团长申请请及时处理',
                        $_GPC['name'],
                        $account['m_phone'],
                        date('Y-m-d H:i:s',time()),
                        $addresss . $m_head_house_address
                    ];
                    $subwechat->sendunimsg("tmp_headmsg",$openids,$subwechat_arr);
                }

            }

            $this->result("0", "申请成功，请等待审核", $res);
            exit;
        }
?>