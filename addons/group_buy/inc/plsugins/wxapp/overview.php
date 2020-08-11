<?php
include_once "../addons/group_buy/wxapp.php";
class Overview{
	public $member           = 'gpb_member';//用户表
    public $ah          = 'gpb_application_header';//申请团长表
    public $rg          = 'gpb_region';//地区表
    public $vg          = 'gpb_village';//小区表
    public $goods          = 'gpb_goods';//商品表
    public $goods_cate          = 'gpb_goods_cate';//商品分类表
    public $goods_stock          = 'gpb_goods_stock';//商品库存
    public $goods_stock_logs          = 'gpb_goods_stock_logs';//商品库存日志
    public $adv         = 'gpb_banner';//banner
    public $coupon         = 'gpb_ticket';//优惠卷
    public $user_coupon         = 'gpb_user_ticket';//用户领取的优惠券
    public $order         = 'gpb_order';//用户订单表
    public $order_log         = 'gpb_order_log';//用户订单日志表
    public $action         = 'gpb_action';//活动表
    public $address         = 'gpb_receiving_address';//收获地址表
    public $snapshot        = 'gpb_order_snapshot';//订单商品快照表
    public $ban             = 'gpb_banner';//banner广告
    public $sure_order             = 'gpb_sure_order';//订单核销表
    public $action_village     ='gpb_action_village';//活动小区关系表
    public $action_goods     ='gpb_action_goods';//活动商品关系表
    public $cart       ='gpb_cart';//购物车表
    public $config       ='gpb_config';//配置表
    public $get_cash       ='gpb_get_cash';//提现表
    public $back_money       ='gpb_back_money';//退款表
    public $distribution       ='gpb_distribution_list';//配送表
    public $distribution_route       ='gpb_distribution_route';//配送路线表
    public $supplier       ='gpb_supplier';//供应商
    public $spec       ='gpb_goods_spec';//规格表
    public $spec_item       ='gpb_goods_spec_item';//规格下参数表
    public $goods_option       ='gpb_goods_option';//参数规格erp
    public $diy_page       ='gpb_diy_page';//diy页面信息
    public $diy_temp       ='gpb_diy_temp';//diy模版信息
    public $menu          = 'gpb_menu';//菜单权限
    public $menu_list     = 'gpb_menu_list';//菜单
    public $plug     = 'gpb_plug';//插件表
    public $stream     = 'gpb_order_stream';//流水
    public $article    = 'gpb_article';//文章表
    public $article_class     = 'gpb_article_class';//文章分类
   	public $weid;
	
	public function __construct(){
		global $_W, $_GPC;
		$debug = debug_backtrace();
		if(!strpos($debug[0]['file'],'wxapp')){
			echo '接入地址错误';
			exit;
		}
		if($debug[1]['function'] != 'doPagePlsugins'){
			echo '接入地址错误';
			exit;
		}
		$this->weid = $_W['uniacid'];
	}
	
	public function index(){
		global $_W, $_GPC;
		require_once '../addons/group_buy/site.php';
		include_once '../addons/group_buy/sms.php';
		include_once '../addons/group_buy/print_sn.php';
		$site = new Group_buyModuleSite();
		$weid = $this->weid;  //控制模块
		$min = 30;
        //读取配置
        $order_over_cancle = pdo_get($this->config,array('key'=>'order_over_cancle','weid'=>$weid));
        if(!empty($order_over_cancle) && !empty($order_over_cancle['value'])){
            $min = $order_over_cancle['value'];
        }
//      $list =   pdo_fetchall(" select * from ".tablename($this->order)." where  weid = ".$weid." and `type`=1 and go_is_del = 1 and go_status=10 and go_add_time <".(time()-$min*60)."  order by go_id desc limit 100");
        $list =   pdo_fetchall(" select * from ".tablename($this->order)." where  weid = ".$weid." and `type`=1 and go_is_del = 1 and go_status=10   order by go_id desc limit 100");
        if(!empty($list)){
            foreach ($list as $v){
                $order_status = $site->wx_order_status($v['go_code']);
                $des ='';
                $data = array();
                if($order_status['trade_state']=='SUCCESS' && $order_status['return_code']=='SUCCESS' && $order_status['trade_state_desc'] == '支付成功') {
                    pdo_update($this->order,array('go_status'=>20,'go_pay_time'=>time()),array("go_code"=>$v["go_code"],"weid"=>$weid,'type'=>1));
                    $go_code = $v["go_code"];
                    $des = "系统自动确认用户已支付，改变状态为已支付";
                    //获取商品信息
                    $info = pdo_getall($this->snapshot,array('oss_go_code'=>$go_code));

                    $buy_phone =$info[0]['oss_buy_phone'];
                    if(!empty($info)){
                        foreach($info as $key=>$val){
                            $stcok = pdo_get($this->goods_stock,array('goods_id'=>$val['oss_gid']));//获取库存
                            $num = $stcok['num'] - $val['oss_g_num'];
                            $num = $num<=0?0:$num;
                            $is = $stcok['sale_num'] + $val['oss_g_num'];
                            //获取减少库存方式
                            $reduce_stock_type = pdo_get($this->config,array('key'=>'reduce_stock_type','weid'=>$weid));
                            //修改库存和添加销量
                            if($reduce_stock_type['value']==2){
                                pdo_update($this->goods_stock,array('sale_num'=>$is),array('goods_id'=>$v['oss_gid'],'weid'=>$weid));
                            }else {
                                pdo_update($this->goods_stock,array('num'=>$num,'sale_num'=>$is),array('goods_id'=>$v['oss_gid'],'weid'=>$weid));
                            }
                            //修改完销量  去查看商品的销量是为0  为0 下架
                            if($is === 0){
                                $res = pdo_update($this->goods,array('g_is_online'=>-1),array('g_id'=>$val['oss_gid'],'weid'=>$weid));
                            }
                            //修改虚拟销售数量
                            $sql = "update ".tablename($this->goods)." set `g_sale_num` = `g_sale_num`+1 WHERE weid=".$weid." and `g_id` = ".$val['oss_gid'];
                            pdo_query($sql);

                        }
                    }
                    //查看是否开启自动订单打印
                    $order_print_auto_open= pdo_get($this->config,array('key'=>'order_print_auto_open','weid'=>$this->weid));
                    $order_print_auto_open_val = isset($order_print_auto_open['value'])?$order_print_auto_open['value']:2;
                    $order_print_auto_num= pdo_get($this->config,array('key'=>'order_print_auto_num','weid'=>$this->weid));
                    $order_print_auto_num_val = isset($order_print_auto_num['value'])?$order_print_auto_num['value']:1;
                    if($order_print_auto_open_val ==1 ){
                        //开启
                        //查询打印机配置
                        $print_set = pdo_get($this->config,array('key'=>'print_set','weid'=>$this->weid));
                        $config = unserialize($print_set['value']);
                        if(empty($config) || count($config)<=0){
//                      	echo json_encode(array('status'=>1,'msg'=>'请在配置中设置打印机'));exit;
                        } else {
                            //调用打印机类
                            $print_class = new print_sn();
                            //查询打印机状态
                            $res_select = $print_class->select_print($config['print_sn']);
//                                if( $res_select["ret"]!==0 || $res_select["data"]=='离线。'){
////                                    echo json_encode(array('status'=>1,'msg'=>$res_select['msg'].','.$res_select['data']));exit;
//                                }else{
                            $goods = array();
                            $order = pdo_fetchall("select * from ".tablename($this->order)." as o left join ".tablename($this->snapshot)." as sn on sn.oss_go_code = o.go_code left join ".tablename($this->vg)." as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=".$go_code." and o.weid=".$this->weid);
                            foreach($order as $k => $val){
                                $goods[$k]['title'] = $val['oss_g_name'];
                                $goods[$k]['price'] = $val['oss_g_price'];
                                $goods[$k]['num'] = $val['oss_g_num'];
                                $goods[$k]['spec'] = trim($val['oss_ggo_title']);
                            }
                            $adr = $order[0]['vg_address'];
                            if(!empty($order[0]['oss_address']) && $order[0]['oss_address'] != 'undefined'){
                                $adr = $order[0]['oss_address'];
                            }
                            $lead_info = array(
                                'name'=>  $order[0]['oss_head_name'],
                                'phone'=> $order[0]['oss_head_phone'],
                            );
                            $reduce_price = 0;
                            if($order[0]['go_fdc_price']>0){
                                $reduce_price +=$order[0]['go_fdc_price'];
                            }
                            if($order[0]['go_full_reduce_price']>0){
                                $reduce_price +=$order[0]['go_full_reduce_price'];
                            }
                            $send_price = 0;
                            if($order[0]['go_send_pay']>0){
                                $send_price +=$order[0]['go_send_pay'];
                            }
                            $res = $print_class->print_info($config['print_sn'],$go_code,$order[0]['oss_v_name'],$goods,$adr,$order[0]['oss_address_phone'],$order[0]['oss_address_name'],$order[0]['go_real_price'],$lead_info,$order[0]['go_comment']='',$qrcode='',$order[0]['go_add_time'],'','在线支付',$order_print_auto_num_val,$reduce_price,$send_price);
//                                }

                        }

                    }
                    $order_sms = pdo_get($this->order,array('go_code'=>$go_code,'weid'=>$this->weid,'type'=>1),array('go_code','go_real_price','go_add_time','go_id','prepay_id','go_order_formid','openid'));
			        //发送模板消息
			       	$sms = new Sms();
                    $sms->weid=$this->weid;
                    $site->Token();
			        $sms_array = array('1' => $order_sms['go_code'], '2' => "￥" . $order_sms['go_real_price'], '3' => '支付成功', '4' => date('Y-m-d H:i', $order_sms['go_add_time']), '5' => '如有疑问，请拨打客户热线:');
			        $form_id = empty($order_sms['prepay_id'])?$order_sms['go_order_formid']:$order_sms['prepay_id'];
			        $dass = $sms->send_out('sms_template', $sms_array, $_W['account']['access_tokne'], $order_sms['openid'], 'pages/order/orderDetail?id=' . $order_sms['go_id'], $form_id, $sms->weid, 'AT0229');

                    //新增订阅消息 周龙 2020-02-27
                    $submsg = new \SubMsg();
                    $submsg_arr = [
                        $order_sms['go_code'],
                        "￥" . $order_sms['go_real_price'],
                        '支付成功',
                        date('Y-m-d H:i', $order_sms['go_add_time']),
                        '如有疑问，请拨打客户热线'
                    ];
                    $submsg->sendmsg("pay_suc",$order_sms['openid'],$submsg_arr,'pages/order/orderDetail?id=' . $order_sms['go_id']);

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
                                $order_sms['go_code'],
                                '',
                                date('Y-m-d H:i', $order_sms['go_add_time']),
                                "￥" . $order_sms['go_real_price'],
                                '请及时进入后台处理'
                            ];
                            foreach ($arr as $k=>$v){
                                $subwechat->sendunimsg("tmp_paymsg",$v,$subwechat_arr);
                            }
                        }else{
                            //只有一个直接发送
                            $subwechat_arr = [
                                '您有新的订单请及时处理',
                                $order_sms['go_code'],
                                '',
                                date('Y-m-d H:i', $order_sms['go_add_time']),
                                "￥" . $order_sms['go_real_price'],
                                '请及时进入后台处理'
                            ];
                            $subwechat->sendunimsg("tmp_paymsg",$openids,$subwechat_arr);
                        }

                    }

					//发送公众号消息
					$this->pay_success_send_official_account_msg($go_code);
                    //短信通知管理员
                    //$account = pdo_get($this->member,array('m_openid'=>$openid,'weid'=>$this->weid));
                    $type = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'sms_type'));
                    $set = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'sms_pay'));
                    $phone = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'sms_admin'));
                    $data = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'sms_data'));
                    $phone = unserialize($phone['value']);
                    $data = unserialize($data['value']);
                    $set = unserialize($set['value']);
                    $sms = new Sms();
                    $weid = $sms->weid = $this->weid;
                    if($type['value'] == 1 ){
                        //阿里云
                        if(is_array($phone)){
                            foreach ( $phone as $k => $v_phone_sms){
                                $res =$sms->alicloud($v_phone_sms,array('sms_var'=>trim($set['content']['value']),'sms_key'=>trim($data['key']['value']),'sms_serect'=>trim($data['serect']['value']),'sms_sign'=>trim($data['sign']['value']),'sms_id'=>trim($set['id']['value'])),array('0'=>$buy_phone,'1'=>$go_code));
                            }
                        }
                    }elseif($type['value']==2){
                        //创瑞 todo 不一定成
                        if(is_array($phone)) {
                            foreach ($phone as $k => $v_phone_sms) {
                                $res = $sms->chui($v_phone_sms, array('sms_var' => trim($set['content']['value']), 'sms_key' => trim($data['key']['value']), 'sms_serect' => trim($data['serect']['value']), 'sms_sign' => trim($data['sign']['value']), 'sms_id' => trim($set['id']['value'])), $go_code);
                            }
                        }
                    }
                    //修改流水表
                    $old_stream = pdo_get($this->stream,array("weid"=>$this->weid,'gos_go_code'=>$go_code,'gos_stream_type'=>1,'gos_status'=>1));
//                        if( $openid=="oLf4B0YnQULf9ZfUT8qmnI8q7xeI" or $openid=="oLf4B0RKRvsOPND25hNm4cCiz_Lg" or $openid=='oLf4B0ZsYqyFXGeuNb1QgwMzspkk'){
//                            $total_fee = "0.01";
//                        }else{
                    $total_fee =$info['go_real_price'];
//                        }
                    if(empty($old_stream)){
                        //存入订单流水
                        $order_snapshot = pdo_fetchall("select * from ".tablename($this->snapshot)." where oss_go_code =".$info['go_code']);
                        $data_stream = array(
                            'gos_code'=>date('Ymd',time()).$site->nextId(),//流水号
                            'gos_go_code'=>$info['go_code'],//订单号
                            'gos_stream_type'=>1,
                            'gos_type'=>1,
                            'gos_commet'=>'.进入订单页确定支付完成',
                            'gos_owner'=>'平台',
                            'gos_order_money'=>$total_fee,
                            'gos_payer'=>$order_snapshot[0]['oss_buy_name'],
                            'gos_real_money'=>$total_fee,
                            'gos_sure_pay_time'=>time(),
                            'gos_status'=>2,
                            'gos_add_time'=>time(),
                            'weid'=>$this->weid,
                            'gos_pay_type'=>1,
                            'gos_team'=>$order_snapshot[0]['oss_head_name'],
                            'gos_payer_openid'=>$order_snapshot[0]['oss_buy_openid'],
                            'gos_team_openid'=>$order_snapshot[0]['oss_head_openid']
                        );
                        pdo_insert($this->stream,$data_stream);
                    }else{
                        $data_stream = array(
                            'gos_real_money'=>$total_fee,
                            'gos_sure_pay_time'=>time(),
                            'gos_commet'=>$old_stream['gos_commet'].',小程序确定支付完成',
                            'gos_status'=>2
                        );
                        pdo_update($this->stream,$data_stream,array('gos_id'=>$old_stream['gos_id']));
                    }
                }else{
                    $cancle_sn = pdo_getall('gpb_order_snapshot',array('oss_go_code'=>$v["go_code"]));
                    if($v['go_add_time'] + ($min*60) < time() && $cancle_sn[0]['oss_is_seckill']==0){
                        $res_order = pdo_update($this->order,['go_status'=>110],["go_code"=>$v["go_code"],"weid"=>$weid,'type'=>1]);
                        $des = "系统未在微信商户后台查询到该订单已支付，修改状态为已取消";

                        $member = pdo_get('gpb_member',array('m_openid'=>$v['openid']));
                        if($v['go_fdc_id']>0){
                            pdo_update('gpb_user_ticket',array('is_use'=>0),array('id'=>$v['go_fdc_id']));
                        }
                    }
                    $min_seckill= $min;
                    $min_seckill = pdo_get('gpb_shop_seckill_task',array('id'=>$cancle_sn[0]['oss_seckill_taskid']));
                    if(!empty($min_seckill) && isset($min_seckill['closesec'])){
                        $min_seckill_sec = $min_seckill['closesec'];
                    }else{
                        $min_seckill_sec = $min*60;
                    }
                    if(!empty($min_seckill)  && $cancle_sn[0]['oss_is_seckill']==1 && $v['go_add_time'] + $min_seckill_sec < time()){
                        $res_order = pdo_update($this->order,['go_status'=>110],["go_code"=>$v["go_code"],"weid"=>$weid,'type'=>1]);
                        $des = "系统未在微信商户后台查询到该秒杀订单已支付，修改状态为已取消";
                        //如果是秒杀取消恢复库存
//                            pdo_update('gpb_shop_seckill_task_goods',array('total +='=>$cancle_sn[0]['oss_g_num'],'sale_num -='=>$cancle_sn[0]['oss_g_num']),array('taskid'=>$cancle_sn[0]['oss_seckill_taskid'],'roomid'=>$cancle_sn[0]['oss_seckill_roomid'],'timeid'=>$cancle_sn[0]['oss_seckill_timeid'],'goodsid'=>$cancle_sn[0]['oss_gid']));
                        if(!empty($res_order)){
                            pdo_query('UPDATE '.tablename('gpb_shop_seckill_task_goods').' SET total = total+'.intval($cancle_sn[0]['oss_g_num']).',sale_num=sale_num-'.intval($cancle_sn[0]['oss_g_num']).' WHERE taskid='.$cancle_sn[0]['oss_seckill_taskid'].' AND roomid='.$cancle_sn[0]['oss_seckill_roomid'].' AND timeid='.$cancle_sn[0]['oss_seckill_timeid'].' AND goodsid='.$cancle_sn[0]['oss_gid']);
//                            pdo_update('gpb_goods_stock',array('num +='=>$cancle_sn[0]['oss_g_num'],'sale_num -='=>$cancle_sn[0]['oss_g_num']),array('goods_id'=>$cancle_sn[0]['oss_gid']));
                            pdo_query('UPDATE '.tablename('gpb_goods_stock').' SET num = num+'.intval($cancle_sn[0]['oss_g_num']).',sale_num=sale_num-'.intval($cancle_sn[0]['oss_g_num']).' WHERE goods_id='.$cancle_sn[0]['oss_gid']);
                        }

                    }else{
                        if($v['go_fdc_id']>0){
                            pdo_update('gpb_user_ticket',array('is_use'=>0),array('id'=>$v['go_fdc_id']));
                        }
                    }

                }
                if(!empty($des) && !empty($res_order)){
                    $data = array(
                        'gol_uid'=>$_GPC['__uid'],
                        'gol_add_time'=>time(),
                        'gol_des'=>$des,
                        'gol_go_code'=>$v["go_code"],
                        'gol_u_name'=>$_W['username']
                    );
                    $res = pdo_insert($this->order_log,$data);
                    //更新订单流水表
                    pdo_update($this->stream,array('gos_real_money'=>$v['go_real_price']),array("gos_status"=>1,'gos_go_code'=>$v["go_code"],'gos_stream_type'=>1,'weid'=>$this->weid,'gos_type'=>1));
                }
            }
        }
        $count = pdo_fetchcolumn(" select count(*) from ".tablename($this->order)." where  weid = ".$weid." and `type`=1 and go_is_del = 1 and go_status=10");
        echo json_encode(array("status"=>0,"data"=>array('count'=>$count),'dass'=>$dass,'form_id'=>$form_id));
        exit;
	}
	public function auto(){
		global $_W,$_GPC;
		require_once '../addons/group_buy/site.php';;
		$site = new Group_buyModuleSite();
        //查询有无自动收货配置
        $cfg = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'order_set'));
        $arr = unserialize($cfg['value']);
        $time = $arr['order_auto_get_goods_time'];
        if(is_numeric($time) && $time>0){
            //自动收货
            $order = pdo_fetchall("select * from ".tablename($this->order)." where weid=".$this->weid." and go_status=30 and (go_send_goods_time<".(time()-$time*24*60*60)." OR (go_send_goods_time IS NULL AND  go_pay_time<".(time()-$time*24*60*60)."))  and `type`=1 order by go_id asc limit 100");

            foreach ($order as $v){
                $head_price ='';
                if($v['go_send_type']==2){
                    $user = pdo_get($this->member,array('m_openid'=>$v['go_team_openid']));
                    pdo_update($this->member,array('m_send_price_total'=>(floatval($v['go_send_pay'])+floatval($user['m_send_price_total'])),'m_money'=>(floatval($user['m_money'])+floatval($v['go_send_pay'])) ),array('m_id'=>$user['m_id']) );
                    $head_price .=',go_send_price_status=2';
                }
                //查找商品快照表,计算总佣金
                $snapshot_list = pdo_fetchall("select * from ".tablename($this->snapshot)." as sn where sn.oss_go_code =".$v['go_code']);
                $go_commission =0;
                foreach ($snapshot_list as $key =>$val){
                    $go_commission += floatval($val['oss_commission']);
                }
                $sql = "update ".tablename($this->order)." set `go_status` = '100' , `go_commission` = '".$go_commission."',`go_commission_num`=0,go_commission_time=".time().$head_price." where weid=".$this->weid." and `type`=1 and `go_id`=".$v['go_id'];
                $res = pdo_query($sql);
				$old_order_stream = pdo_get($this->order,array('go_is_cash'=>1,'go_id'=>$v['go_id']));
				//查得出就是之前已有流水 ,不进入判断
                if(!empty($res) && empty($old_order_stream) ){
//					 pdo_update('gpb_order',array('go_is_cash'=>1),array('go_id'=>$v['go_id']));
                    //生成流水表-佣金
                    $order_snapshot = pdo_fetchall("select * from ".tablename($this->snapshot)." where oss_go_code =".$v['go_code']);
                    $data_stream = array(
                        'gos_code'=>date('Ymd',time()).$site->nextId(),//流水号
                        'gos_go_code'=>$v['go_code'],//订单号v
                        'gos_stream_type'=>3,
                        'gos_type'=>2,
                        'gos_pay_type'=>1,
                        'gos_owner'=>'平台',
                        'gos_payer'=>$order_snapshot[0]['oss_buy_name'],
                        'gos_team'=>$order_snapshot[0]['oss_head_name'],
                        'gos_commet'=>'超过系统收货时间自动确认收货',
                        'gos_order_money'=>$go_commission,
                        'gos_real_money'=>0,
                        'gos_sure_pay_time'=>time(),
                        'gos_status'=>1,
                        'gos_add_time'=>time(),
                        'weid'=>$this->weid,
                        'gos_payer_openid'=>$order_snapshot[0]['oss_buy_openid'],
                        'gos_team_openid'=>$order_snapshot[0]['oss_head_openid']
                    );
                    //开启自动审核佣金后
                    $auto_sure_head_commission = pdo_get($this->config,array('key'=>'auto_sure_head_commission','weid'=>$this->weid));
                    $auto_sure_head_commission = isset($auto_sure_head_commission['value'])?$auto_sure_head_commission['value']:2;
                    if($auto_sure_head_commission == 1){
                        //查找商品快照表,计算总佣金
                         pdo_begin();
						$res = pdo_update('gpb_order',array('go_is_cash'=>1),array('go_id'=>$v['go_id']));
						if($res){
							$data_stream['gos_real_money']= $go_commission;
	                        $data_stream['gos_status']= 2;
	                        $data_stream['gos_commet']= '系统后台确认收货产生佣金,开启自动审核通过该佣金';
	                        $data_stream['gos_sure_pay_time']= time();
	                        //订单佣金自动审核
	                        $cash_member = pdo_update($this->member,array('m_money +='=>$go_commission),array('m_openid'=>$v['go_team_openid'],'weid'=>$this->weid));
						}
						if($cash_member){
							pdo_commit();
						} else {
							pdo_rollback();//失败回滚
						}
                    }
					$i = pdo_fetch(" select * from ".tablename("gpb_order_stream")." where gos_stream_type = 3 AND gos_go_code = ".$v['go_code']);
			        if(empty($i)){
				        pdo_insert($this->stream, $data_stream);
			        }

                    if(!empty(WeUtility::createModuleHook("group_buy_plugin_distribution"))) {

                        //分销佣金计算qdis
                        $distribution = pdo_get($this->config, ['weid' => $this->weid, 'key' => 'distribution_state']);
                        $res = pdo_insert($this->order_log, array('gol_add_time' => time(), 'gol_des' => '系统自动确认收货', 'gol_comment' => '订单超过设定时间未确认收货', 'gol_go_code' => $v['go_code'], 'gol_u_name' => '系统'));

                        if (!empty($distribution) && $distribution['value'] == 1) {
                            //存在并开启
                            @require_once('../addons/group_buy_plugin_distribution/distribution.php');
                            @$new_distribution = new distribution($this->weid);
                            @$resutl = $new_distribution->usercost($v['go_code']);
                        }
                    }
                    //团长推荐分销
                    $resutl_log = $site->headcost($v['go_code']);
                    //存日志
                    $file  = dirname(__FILE__).'/headrecommedmomey.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
                    if(file_exists($file) && filesize($file) > 100000){
                        unlink($file);//这里是直接删除，
                    }
                    $content = date('Y-m-d H:i:s');
                    $content .= "团长核销计算推荐分销佣金,oid={$v['go_code']}\n";
                    foreach ($resutl_log as $k=>$v){
                        $content .= "{$k}={$v}\n";
                        if($k == 'data'){
                            foreach ($resutl_log[$k] as $kk=>$vv){
                                $content .= "{$kk}={$vv}\n";
                            }
                        }
                    }
                    $content .= "------\n";
                    file_put_contents($file,$content.PHP_EOL,FILE_APPEND);
                    //                $res = pdo_update($this->order,array('go_status'=>100),array('go_id'=>$v['go_id']));
                    //                if(!empty($distribution) && $distribution['value']==1) {
                    //                    $new_distribution->doPageFraction_order_Detailed(array('order' => $v["go_code"]));
                    //                }
				}
                if(!empty(WeUtility::createModuleHook("group_buy_plugin_fraction"))) {
                    //获取积分
                    $filename = '../addons/group_buy_plugin_fraction/hook.php';
                    if (file_exists($filename)) {
                        require_once $filename;
                        $group = new Group_buy_plugin_fractionModuleHook();
//					echo '<pre>';
                        $res = $group->hookPageFraction_order_Detailed(array('0' => array('order' => $v['go_code'])));
//					print_r(array('0'=>array('order'=>$v['go_code'])));
//					print_r($res);exit;
                    }
                }
            }
        }
	}
	
	/*
	     * 支付成功发公众号的方法
	     * param str $code 订单code
	     */
	    public function pay_success_send_official_account_msg($code)
	    {
	        //订单情况
	        $order = pdo_get('gpb_order', array('go_code' => $code, 'weid' => $this->weid));
	        $sn = pdo_getall('gpb_order_snapshot', array('oss_go_code' => $order['go_code'], 'oss_ggo_status' => 1));
	        //@param $key 发送那个模板消息
	        $key = 'wechat_deliver_pay';
	        //模块
	        $weid = $this->weid;
	        //团长的openid
	        $openid = $order['go_team_openid'];
	        //买家姓名
	        $buyname = empty($sn[0]['oss_buy_name']) ? $sn[0]['oss_address_name'] : $sn[0]['oss_buy_name'];
	        if($this->check_base64_out_json($buyname)){
	            $buyname = base64_decode($buyname);
	        }
	       /* $data = array(
	            'first' => array('value' => '团长您好！用户(' . $buyname . ')在您处下单，请密切关注'),
	            'keyword1' => array('value' => $order['go_code']),
	            'keyword2' => array('value' => $sn[0]['oss_g_name'] . '...'),
	            'keyword3' => array('value' => $order['go_real_price']),
	            'keyword4' => array('value' => '已支付'),
	            'keyword5' => array('value' => date('Y-m-d H:i:s', $order['go_add_time'])),
	            'remark' => array('value' => '有任何问题请联系管理员！')
	        );
	        $href = 'pages/groupCenter/groupOrders';
	        $sms = new Sms();
	        $res = $sms->public_address_template($key, $weid, $openid, $data, $href);*/

            //2020-03-02 周龙 使用新的公众号模板消息
            $subwechat = new \SubWechat();
            $wechat_arr = [
                '团长您好！用户(' . $buyname . ')在您处下单，请密切关注',
                $order['go_code'],
                $sn[0]['oss_g_name'] . '...',
                $order['go_real_price'],
                '已支付',
                date('Y-m-d H:i:s', $order['go_add_time']),
                '有任何问题请联系管理员！'
            ];
            $res = $subwechat->sendunimsg('tmp_leader',$openid,$wechat_arr,'','pages/groupCenter/groupOrders');

			return $res;
	    }
		/**
	     * 优化微擎底层的is_base64的判断
	     * 确保字符串被base64解密后可被json加密
	     * string $str 被检测的字符串
	     */
	    protected function check_base64_out_json($str){
	        if(!is_string($str)){
	            return false;
	        }
	        $str_base64_decode = base64_decode($str);
	        $str_base64_decode_json_encode = json_encode($str_base64_decode);
	        $error_code = json_last_error();
	        if($error_code > 0 ){
	            return false;
	        }
	        return $str == base64_encode(base64_decode($str));
	    }
}

?>