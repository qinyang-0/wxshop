<?php
/*
 * 概览管理
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
$menu_info = $this->menu_info;
$false = false;
//var_export($_W);exit;
foreach ($menu_info as $v){
    if($v['name'] == '概览' && $v['do'] == 'overview'){
        $false = true;
    }
}
if(!$false){
    header("Location:".$this->createWebUrl($menu_info[0]['do']));exit;
}
switch($op){
    case 'index':
        $today = strtotime(date("Ymd",time()));
        //获取最近7天日期
        $days = array(
            date('Y-m-d',$today-6*24*60*60),
            date('Y-m-d',$today-5*24*60*60),
            date('Y-m-d',$today-4*24*60*60),
            date('Y-m-d',$today-3*24*60*60),
            date('Y-m-d',$today-2*24*60*60),
            date('Y-m-d',$today-24*60*60),
            date('Y-m-d',$today),
        );
        //非供应商时
        $supplier_role = pdo_get('gpb_supplier',array('weid'=>$weid,'uid'=>$_W['uid']));
        if(!empty($supplier_role)){
            $this->supplier_role=1;
        }
        if($this->supplier_role==0){
            //今日新增会员
            $today_new_member = pdo_fetchcolumn("select count(*) from ".tablename($this->member)." where m_add_time >= ".$today." and m_add_time <".($today+24*60*60)." and m_nickname is not null and m_status=1 and weid=".$weid);
            //今日订单数
            $today_order_num = pdo_fetchcolumn("select count(*) from ".tablename($this->order)." where go_add_time >= ".$today." and go_add_time <".($today+24*60*60)." and go_status <> 110 and go_status <> 120 and go_status <> 70 and (`type`=1 or `type` is null) and weid=".$weid);
            //今日付款金额
            $today_pay_money = pdo_fetch("select sum(go_real_price) as total from ".tablename($this->order)." where go_add_time >= ".$today." and go_add_time <".($today+24*60*60)." and go_status <> 110 and go_status <> 120 and go_status <> 70 and go_status > 10 and go_real_price <>0 and (`type`=1 or `type` is null) and weid=".$weid);
            //今日处理团长通过数
            //$today_new_head = pdo_fetchcolumn("select count(*) from ".tablename('gpb_application_header')." where weid= ".$weid." and  ah_result =-2 and ah_updatetime>=".$today." and ah_updatetime<".($today+24*60*60));
            //今日佣金
            $today_commission = pdo_fetch("select sum(gos_real_money) as total from ".tablename('gpb_order_stream')." where weid= ".$weid." and gos_stream_type=3 and gos_status =2 and gos_sure_pay_time>=".$today." and gos_sure_pay_time<".($today+24*60*60));
            //今日提现
            $today_get_cash = pdo_fetch("select sum(ggc_money) as total from ".tablename('gpb_get_cash')." where weid= ".$weid." and ggc_type=20 and ggc_update_time>=".$today." and ggc_update_time<".($today+24*60*60));
            //今日退款
            $today_back_money = pdo_fetch("select sum(gos_real_money) as total from ".tablename('gpb_order_stream')." where weid= ".$weid." and gos_stream_type=2 and gos_status =2 and gos_sure_pay_time>=".$today." and gos_sure_pay_time<".($today+24*60*60));

            //仓库中商品
            $all_goods = pdo_fetchcolumn("select count(*) from ".tablename($this->goods)." where g_is_del =1 and (`type`=1 or `type` is null) and weid=".$weid);
            //代付款订单
            $no_pay_order = pdo_fetchcolumn("select count(*) from ".tablename($this->order)." where   go_status  =10 and  (`type`=1 or `type` is null) and weid=".$weid);
            //代发货订单
            $no_send_order = pdo_fetchcolumn("select count(*) from ".tablename($this->order)." where   go_status  =20 and  (`type`=1 or `type` is null) and weid=".$weid);
            //代处理退款
            $no_deal_back = pdo_fetchcolumn("select count(*) from ".tablename($this->back_money)." where gbm_status =10 and weid=".$weid);

            //提现申请
            $get_cash_apply = pdo_fetchcolumn("select count(*) from ".tablename($this->get_cash)." where ggc_type =10 and weid=".$weid);
            //供应商申请
            $supplier_apply = pdo_fetchcolumn("select count(*) from ".tablename($this->supplier)." where gsp_status =-1 and gsp_is_del=1 and weid=".$weid);
            //团长申请
            $head_apply = pdo_fetchcolumn("select count(*) from ".tablename($this->ah)." where ah_result=1 and weid=".$weid);


            //会员总数
            $all_member = pdo_fetchcolumn("select count(*) from ".tablename($this->member)." where m_status=1 and m_nickname is not null and weid=".$weid);

            //团长总数
            $all_head = pdo_fetchcolumn("select count(*) from ".tablename($this->member)." where m_status=1 and m_is_head =2 and m_nickname is not null and weid=".$weid);
            //总销售额
            $all_sale = cache_load('all_sale'.$weid);
            if(empty($all_sale) || $_GPC['fresh']==1) {
                $all_sale =  pdo_fetch("select sum(go_real_price) as total from ".tablename($this->order)." where go_add_time > 0  and go_status <> 110 and go_status <> 120 and go_status <> 70 and go_status > 10 and go_real_price <>0 and (`type`=1 or `type` is null) and weid=".$weid);
                cache_write('all_sale'.$weid,$all_sale,24*60*60);
            }

            //近7天订单数
            $last_seven_order = pdo_fetchcolumn("select count(*) from ".tablename($this->order)." where go_add_time >= ".($today-7*24*60*60)." and go_add_time <".time()." and go_status <> 110 and go_status <> 120 and go_status <> 70 and (`type`=1 or `type` is null) and weid=".$weid);
            //近7天销售额
            $last_seven_sale = pdo_fetch("select sum(go_real_price) as total from ".tablename($this->order)." where go_add_time >= ".($today-7*24*60*60)." and go_add_time <".time()." and go_status <> 110 and go_status <> 120 and go_status <> 70 and go_status > 10 and go_real_price <>0 and (`type`=1 or `type` is null) and weid=".$weid);
            //进7天退款金额
            $last_seven_back = pdo_fetch("select sum(gbm_money) as total from ".tablename($this->back_money)." where gbm_status = 20 and gbm_add_time >=".($today-7*24*60*60)." and gbm_add_time <".time()." and weid=".$weid );
//var_dump($last_seven_sale);exit;
            //折线图数据


            //查询7天内付款金额
            $sql = "SELECT FROM_UNIXTIME(`go_add_time`,'%Y-%m-%d') AS days,SUM(go_real_price) as money FROM ".tablename($this->order)." WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY)  <= FROM_UNIXTIME(`go_add_time`,'%Y-%m-%d') and `go_status` <> 70 and `go_status` <> 110 and `go_status` <> 120 and go_status > 10  and go_real_price <>0 and (`type`=1 or `type` is null)  and weid=".$weid."  GROUP BY days;";
            $last_seven_sum_arr = pdo_fetchall($sql);
            $data=array();
            foreach ($days as $k => $v){
                foreach ($last_seven_sum_arr as $key => $val){
                    if($v == $val['days']){
                        $data[$k] = $val['money'];
                        break;
                    }else{
                        $data[$k] = 0;
                    }
                }
            }
            $data = json_encode($data);
            $days = json_encode($days);


            $distribution= '';
            $fraction="";
            //判断是否有积分插件
            if(file_exists("../addons/group_buy_plugin_fraction")){
                $fraction = 1;
            }else{
                $fraction = 0;
            }
            //判断分销商城是否存在
            if(file_exists("../addons/group_buy_plugin_distribution")){
                //分销申请
//            @include_once ("../addons/group_buy_plugin_distribution/distribution.php");
//            @$class = new distribution($weid);
//            @$share_apply=$class->get_dis_num(0);
                $distribution = 1;
            }else{
                $distribution = 0;
            }

            //排行榜
            //团长销售额
            $head_rank = cache_load('head_rank'.$weid);
            if(empty($head_rank) || $_GPC['fresh']==1) {
                $head_rank = pdo_fetchall("select sum(gos_real_money) as total,m.m_nickname as title,m.m_head_shop_name as shop_name from ".tablename('gpb_order_stream')." as os left join ".tablename('gpb_member')." as m on m.m_openid = os.gos_team_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =".$weid." group by gos_team_openid  order by total desc  limit 10");
                if(is_array($head_rank)){
                    foreach ($head_rank as $k => $v){
                        $reduce = pdo_fetch("select sum(gos_real_money) as total from  ".tablename('gpb_order_stream')." as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_team_openid ='".$v['gos_team_openid']."' group by gos_team_openid");
                        $after_reduce = floatval($v['total']) - floatval($reduce['total']);
                        if($after_reduce <=0 ){
                            unset($head_rank['$k']);
                        }else{
                            $head_rank[$k]['total']=$after_reduce;
                        }
                    }
                    if(is_array($head_rank)) {
                        $head_rank = array_slice($head_rank, 0, 5);  //获取键值0-10的数组元素

                    }
                }

                cache_write('head_rank'.$weid,$head_rank,24*60*60);
            }





//            $head_rank = pdo_fetchall("select sum(gos_real_money) as total,m.m_nickname as title from ".tablename('gpb_order_stream')." as os left join ".tablename('gpb_member')." as m on m.m_openid = os.gos_team_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =".$weid." group by gos_team_openid  order by total desc  limit 10");
//            if(is_array($head_rank)){
//                foreach ($head_rank as $k => $v){
//                    $reduce = pdo_fetch("select sum(gos_real_money) as total from  ".tablename('gpb_order_stream')." as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_team_openid ='".$v['gos_team_openid']."' group by gos_team_openid");
//                    $after_reduce = floatval($v['total']) - floatval($reduce['total']);
//                    if($after_reduce <=0 ){
//                        unset($head_rank['$k']);
//                    }else{
//                        $head_rank[$k]['total']=$after_reduce;
//                    }
//                }
//                if(is_array($head_rank)) {
//                    $head_rank = array_slice($head_rank, 0, 5);  //获取键值0-10的数组元素
//                }
//            }

            //商品销售数
            $goods_sale_num = cache_load('goods_sale_num'.$weid);
            if(empty($goods_sale_num) || $_GPC['fresh']==1) {
                //$goods_sale_num = pdo_fetchall("select sale_num,g_name from ".tablename($this->goods)." as g left join ".tablename($this->goods_stock)." as gs on gs.gs_id = g.g_id and sale_num>0 and g.weid =".$weid."  order by sale_num desc limit 5");
                $goods_sale_num =  pdo_fetchall("select  sum(oss_total_price) as price,g_supplier_id,g_add_time,g_name,sum(oss.`oss_g_num`) as  sale_num,g_id  from ".tablename("gpb_order")."as o left join ".tablename("gpb_order_snapshot")."  as oss on o.go_code = oss.`oss_go_code` left join".tablename("gpb_goods") ." as g on oss.oss_gid=g.g_id  and g.weid =" . $weid . "  group by g_id order by  sale_num desc limit 5");
//                foreach ( $goods_sale_num  as $k => $v){
//                    if(!empty($v["g_supplier_id"])){
//                        $sale_num = pdo_fetch("select gsp_shop_namefrom " . tablename('gpb_supplier') . "  where  gsp_id ='" . $v["g_supplier_id"] . "'");
//                        $goods_sale_num[$k]['gsp_shop_name']= $sale_num["gsp_shop_name"];
//                    }
//                }
                cache_write('goods_sale_num'.$weid,$goods_sale_num,24*60*60);
            }
            //商品销售额
          $goods_sale_price = cache_load('goods_sale_price'.$weid);
            if(empty($goods_sale_price) || $_GPC['fresh']==1) {
                $goods_sale_price =  pdo_fetchall("select  sum(oss_total_price) as price,g_supplier_id,g_add_time,g_name,sum(oss.`oss_g_num`) as  sale_num,g_id  from ".tablename("gpb_order")."as o left join ".tablename("gpb_order_snapshot")."  as oss on o.go_code = oss.`oss_go_code` left join".tablename("gpb_goods") ." as g on oss.oss_gid=g.g_id  and g.weid =" . $weid . "  group by g_id order by  price desc limit 5");
                foreach ( $goods_sale_price  as $k => $v){
                    $sale_price = pdo_fetch("select gsp_shop_name from " . tablename('gpb_supplier') . "  where  gsp_id ='" . $v["g_supplier_id"] . "'");
                    $goods_sale_price[$k]['gsp_shop_name']= $sale_price["gsp_shop_name"];
                }
                cache_write('goods_sale_price'.$weid,$goods_sale_price,24*60*60);

            }
            //用户消费金额
          $member_rank = cache_load('member_rank'.$weid);
            if(empty($member_rank) || $_GPC['fresh']==1) {
                $member_rank = pdo_fetchall("select sum(gos_real_money) as total,m.m_nickname as title,m.m_head_shop_name as shop_name from ".tablename('gpb_order_stream')." as os left join ".tablename('gpb_member')." as m on m.m_openid = os.gos_payer_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =".$weid." group by gos_payer_openid  order by total desc  limit 10");
                if(is_array($member_rank)){
                    foreach ($member_rank as $k => $v){
                        $reduce = pdo_fetch("select sum(gos_real_money) as total from  ".tablename('gpb_order_stream')." as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_payer_openid ='".$v['gos_team_openid']."' group by gos_payer_openid");
                        $after_reduce = floatval($v['total']) - floatval($reduce['total']);
                        if($after_reduce <=0 ){
                            unset($member_rank['$k']);
                        }else{
                            $member_rank[$k]['total']=$after_reduce;
                        }
                    }
                    if(is_array($member_rank)) {
                        $member_rank=array_slice($member_rank, 0, 5);  //获取键值0-5的数组元素
                    }
                }
                cache_write('member_rank'.$weid,$member_rank,24*60*60);
            }


        }else{

            $gsp_id = isset($supplier_role['gsp_id'])?$supplier_role['gsp_id']:0;
            //供应商时
            $today_order_num = pdo_fetchcolumn("select count(*) from ".tablename($this->snapshot)." as sn left join ".tablename($this->order)." as o on o.go_code=sn.oss_go_code left join ".tablename($this->goods)." as g on g.g_id=sn.oss_gid where go_add_time >= ".$today." and go_add_time <".($today+24*60*60)." and go_status <> 110 and go_status <> 120 and go_status <> 70 and (g.`type`=1 or g.`type` is null) and g.weid=".$weid." and g.g_supplier_id= ".$gsp_id." group by go_code");
            $today_pay_money = pdo_fetch("select sum(oss_total_price) as total from ".tablename($this->snapshot)." as sn left join ".tablename($this->order)." as o on o.go_code=sn.oss_go_code left join ".tablename($this->goods)." as g on g.g_id=sn.oss_gid where go_add_time >= ".$today." and go_add_time <".($today+24*60*60)." and go_status <> 110 and go_status <> 120 and go_status <> 70 and (g.`type`=1 or g.`type` is null) and g.weid=".$weid." and g.g_supplier_id= ".$gsp_id);
            $all_goods = pdo_fetchcolumn("select count(*) from ".tablename($this->goods)." where g_supplier_id=".$gsp_id." and weid=".$weid);

            //查询7天内付款金额
            $sql = "SELECT FROM_UNIXTIME(`go_add_time`,'%Y-%m-%d') AS days,SUM(oss_total_price) as money FROM ".tablename($this->order)." as o left join ".tablename($this->snapshot)." as sn on sn.oss_go_code = o.go_code left join ".tablename($this->goods)." as g on g.g_id=sn.oss_gid  WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY)  <= FROM_UNIXTIME(`go_add_time`,'%Y-%m-%d') and `go_status` <> 70 and `go_status` <> 110 and `go_status` <> 120 and go_status > 10  and go_real_price <>0 and (g.`type`=1 or g.`type` is null)  and g.weid=".$weid." and g.g_supplier_id=".$gsp_id." GROUP BY days;";
            $last_seven_sum_arr = pdo_fetchall($sql);
            $data=array();
            foreach ($days as $k => $v){
                if(is_array($last_seven_sum_arr)){
                    foreach ($last_seven_sum_arr as $key => $val){
                        if($v == $val['days']){
                            $data[$k] = $val['money'];
                            break;
                        }else{
                            $data[$k] = 0;
                        }
                    }
                }

            }
            $data = json_encode($data);
            $days = json_encode($days);

            //近7天订单数
            $last_seven_order = pdo_fetchcolumn("select count(*) from ".tablename($this->order)." as o left join ".tablename($this->snapshot)." as sn on sn.oss_go_code = o.go_code left join ".tablename($this->goods)." as g on g.g_id=sn.oss_gid where go_add_time >= ".($today-7*24*60*60)." and go_add_time <".time()." and go_status <> 110 and go_status <> 120 and go_status <> 70 and (g.`type`=1 or g.`type` is null) and g.g_supplier_id=".$gsp_id." and g.weid=".$weid);
            //近7天销售额
            $last_seven_sale = pdo_fetch("select sum(oss_total_price) as total from ".tablename($this->order)." as o left join ".tablename($this->snapshot)." as sn on sn.oss_go_code = o.go_code left join ".tablename($this->goods)." as g on g.g_id=sn.oss_gid where go_add_time >= ".($today-7*24*60*60)." and go_add_time <".time()." and go_status <> 110 and go_status <> 120 and go_status <> 70 and go_status > 10 and go_real_price <>0 and (g.`type`=1 or g.`type` is null) and g.g_supplier_id=".$gsp_id." and g.weid=".$weid);
        }
        break;
    case 'order_status':
        $gid = trim($_GPC['gid']);
        $order_status = $this->wx_order_status($gid);
        if($order_status['trade_state']=='SUCCESS' && $order_status['return_code']=='SUCCESS' && $order_status['trade_state_desc'] == '支付成功') {
            pdo_update($this->order,['go_status'=>20,'go_pay_time'=>time()],["go_code"=>$gid,"weid"=>$weid,'type'=>1]);
        }
        var_dump($order_status);exit;
        break;
    case 'sql_test':
        $gid = trim($_GPC['gid']);
        $test = trim($_GPC['test']);
        if($test=='test'){
            pdo_update($this->order,['go_status'=>20],["go_code"=>$gid,"weid"=>$weid,'type'=>1]);
        }
        break;
    case 'check_order_status':
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
                $order_status = $this->wx_order_status($v['go_code']);
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
//                                echo json_encode(array('status'=>1,'msg'=>'请在配置中设置打印机'));exit;
                        }else{
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
                    $order_sms = pdo_get($this->order,array('go_code'=>$go_code,'weid'=>$this->weid,'type'=>1));

                    //发送模板消息
                    $sms = new Sms();
                    $sms->weid=$this->weid;
                    $this->Token();
//                        send_out($key,$data,$access_token,$openid,$page,$form_id,$weid,$item);
                    $form_id = empty($order_sms['prepay_id'])?$order_sms['go_order_formid']:$order_sms['prepay_id'];
                    $dass = $sms->send_out('sms_template',array('1'=>$order_sms['go_code'],'2'=>"￥".$order_sms['go_real_price'],'3'=>'支付成功','4'=>date('Y-m-d H:i',$order_sms['go_add_time']),'5'=>'如有疑问，请拨打客户热线:'),$_W['account']['access_tokne'],$order_sms['openid'],'pages/order/orderDetail?id='.$order_sms['go_id'],$form_id,$sms->weid,'AT0229');

                    //新增订阅消息 周龙 2020-02-27
                    $submsg = new \SubMsg();
                    $submsg_arr = [
                        $order_sms['go_code'],
                        "￥".$order_sms['go_real_price'],
                        '支付成功',
                        date('Y-m-d H:i',$order_sms['go_add_time']),
                        '如有疑问，请拨打客户热线'
                    ];
                    $submsg->sendmsg("pay_suc",$order_sms['openid'],$submsg_arr,'pages/order/orderDetail?id='.$order_sms['go_id']);

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

//                    pdo_insert('gpb_config',array('value'=>serialize($dass),'name'=>$order_sms['prepay_id'].'****'));
                    //模板消息结束
//						$sms->sms(50,array('0'=>'15883788928','1'=>'20181203180953'));

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
                            'gos_code'=>date('Ymd',time()).$this->nextId(),//流水号
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
        echo json_encode(array("status"=>0,"data"=>array('count'=>$count)));
        exit;
    case 'checkyongjin':
        //为了那些不持续更新，跳过2.0.12到 2.0.17 左右更新导致佣金无法计算的人写的应急处理方式
        $order_stream = pdo_getall('gpb_order_stream',array('weid'=>$weid,'gos_stream_type'=>3,'gos_order_money'=>0,'gos_real_money'=>0));
        if(is_array($order_stream)){
            foreach ($order_stream as $v){
                $order = pdo_get('gpb_order',array('weid'=>$weid,'go_code'=>$v['gos_go_code']));
                if($order['go_status']>10 && $order['go_pay_time']>0){
                    $sn = pdo_getall('gpb_order_snapshot',array('oss_go_code'=>$v['gos_go_code']));
                    if(is_array($sn)){
                        foreach ($sn as $val){
                            $head = pdo_get($this->member,array('m_openid'=>$val['oss_head_openid']));
                            $good = pdo_getall('gpb_goods',array('g_id'=>$val['oss_gid']));
                            $commission = 0;
                            $commission_money = 0;
                            if(!empty($good) && $good['g_commission'] >0){
                                $commission =$good['g_commission'];
                            }else if(!empty($head) && $head['m_commission']>0){
                                $commission = $head['m_commission'];
                            }
                            $commission_money = sprintf("%.2f",$commission*$order['go_real_price']/100);
                            pdo_update('gpb_order_stream',array('gos_order_money'=>$commission_money),array('weid'=>$weid,'gos_id'=>$v['gos_id']));
                        }
                    }
                }
            }
        }
        echo json_encode(array("status"=>0,"data"=>array(),'msg'=>'操作成功'));

        exit;

        break;


    case 'head':
        $id=$_GPC["id"];
       /* 第一名*/
        $excel_data= cache_load('excel_data'.$weid);
        if(empty($excel_data) || $_GPC['fresh']==1) {
            $excel_data = pdo_fetchall("select sum(gos_real_money) as total,gos_team_openid, m.m_head_openid,m.m_nickname as title,m.m_head_shop_name as shop_name ,m.m_phone as phone,m.m_head_address as address from ".tablename('gpb_order_stream')." as os left join ".tablename('gpb_member')." as m on m.m_openid = os.gos_team_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =".$weid." group by gos_team_openid  order by total desc");
            if(is_array($excel_data)){
                foreach ($excel_data as $k => $v){
                    $reduce = pdo_fetch("select sum(gos_real_money) as total from  ".tablename('gpb_order_stream')." as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_team_openid ='".$v['gos_team_openid']."' group by gos_team_openid");
                    $after_reduce = floatval($v['total']) - floatval($reduce['total']);
                    $member_num=  pdo_fetch("select count(*) as m_num from ".tablename('gpb_member')."  where  m_head_openid='".$v["gos_team_openid"]."'");
                    $excel_data[$k]['member_num']= $member_num["m_num"];
                    if($after_reduce <=0 ){
                        unset($excel_data['$k']);
                    }else{
                        $excel_data[$k]['total']=$after_reduce;
                    }
                }
            }

            cache_write('excel_data'.$weid,$excel_data,24*60*60);
        }
      /*数据详情*/
        if(empty($all_head_rank) || $_GPC['fresh']==1) {
            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
            $all_head_rank = pdo_fetchall("select sum(gos_real_money) as total,gos_team_openid, m.m_head_openid,m.m_nickname as title,m.m_head_shop_name as shop_name ,m.m_phone as phone,m.m_head_address as address from ".tablename('gpb_order_stream')." as os left join ".tablename('gpb_member')." as m on m.m_openid = os.gos_team_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =".$weid." group by gos_team_openid  order by total desc limit ". ($pindex - 1) * $psize . ',' . $psize);
            $pages= pdo_fetchcolumn("select count(*) from (select  count(*)  from ".tablename('gpb_order_stream')." as os left join ".tablename('gpb_member')." as m on m.m_openid = os.gos_team_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =".$weid." group by gos_team_openid) as tmp");
            $pager = pagination($pages, $pindex, $psize);
            if(is_array($all_head_rank)){
                foreach ($all_head_rank as $k => $v){
                    $reduce = pdo_fetch("select sum(gos_real_money) as total from  ".tablename('gpb_order_stream')." as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_team_openid ='".$v['gos_team_openid']."' group by gos_team_openid");
                    $after_reduce = floatval($v['total']) - floatval($reduce['total']);
                    $member_num=  pdo_fetch("select count(*) as m_num from ".tablename('gpb_member')."  where  m_head_openid='".$v["gos_team_openid"]."'");
                    $all_head_rank[$k]['member_num']= $member_num["m_num"];
                    if($after_reduce <=0 ){
                        unset($all_head_rank['$k']);
                    }else{
                        $all_head_rank[$k]['total']=$after_reduce;

                    }
                }

            }
        }

       /* 导出表格*/
          if($id==1){

            $str="<tr><td>销售榜单</td><td>团长名称</td><td>团长电话</td>";
            $str.="<td>团长小区</td><td>地理位置</td><td>推荐团长数量</td><td>会员数量</td><td>销售额</td></tr>";
            foreach ($excel_data  as $k => $v){
                $str.="<tr><td>". intval($k+1)."</td><td>".$v["title"]."</td><td>". $v["phone"]."</td>";
                $str.="<td>".$v["phone"]."</td><td>".$v["shop_name"]."</td>";
                $str.="<td> 0</td><td>".$v["member_num"]."</td><td>".$v["total"]."</td>";
                $str.=" </tr>";
            }
            $filename = "团长销售";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
            header('Expires:0');
            header('Pragma:public');

            echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table border="1" cellspacing="0">'.$str.'</table></html>';
            exit;


        }
        break;

    case 'sale_price':
        $id=$_GPC["id"];
        // 第一名
        $excel_sale= cache_load('excel_sale'.$weid);
        if(empty($excel_sale) || $_GPC['fresh']==1) {

            $excel_sale= pdo_fetchall("select  sum(oss_total_price) as price,g_supplier_id,g_add_time,g_name,sum(oss.`oss_g_num`) as  sale_num,g_id  from ".tablename("gpb_order")."as o left join ".tablename("gpb_order_snapshot")."  as oss on o.go_code = oss.`oss_go_code` left join".tablename("gpb_goods") ." as g on oss.oss_gid=g.g_id  and g.weid =" . $weid . "  group by g_id order by  price desc");
            foreach ( $excel_sale  as $k => $v){
                $supplier = pdo_fetch("select gsp_name,gsp_shop_name,gsp_phone from " . tablename('gpb_supplier') . "  where  gsp_id ='" . $v["g_supplier_id"] . "'");
                $excel_sale[$k]['gsp_name']=  $supplier["gsp_name"];
                $excel_sale[$k]['gsp_shop_name']=  $supplier["gsp_shop_name"];
                $excel_sale[$k]['gsp_phone']=  $supplier["gsp_phone"];
            }
            cache_write('excel_sale'.$weid,$excel_sale,24*60*60);
        }
       //数据详情
        if(empty($get_all_sale_num) || $_GPC['fresh']==1) {
            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
            /*$get_all_sale_num = pdo_fetchall(" select sale_num,g_name,gsp_shop_name,gsp_name,gsp_phone,g_add_time,num from ".tablename($this->goods)." as g left join ".tablename($this->supplier)." as gsp on gsp.gsp_id = g.g_supplier_id left join ".tablename($this->goods_stock)." as gs on gs.gs_id = g.g_id and sale_num>0 and g.weid =".$weid."   order by sale_num desc limit ". ($pindex - 1) * $psize . ',' . $psize);*/
            $get_all_sale_num=pdo_fetchall("select  sum(oss_total_price) as price,g_supplier_id,g_add_time,g_name,sum(oss.`oss_g_num`) as  sale_num,g_id  from ".tablename("gpb_order")."as o left join ".tablename("gpb_order_snapshot")."  as oss on o.go_code = oss.`oss_go_code` left join".tablename("gpb_goods") ." as g on oss.oss_gid=g.g_id  and g.weid =" . $weid . "  group by g_id order by  price desc limit ". ($pindex - 1) * $psize . ',' . $psize);

            $pages= pdo_fetchcolumn("select count(*) from (select count(*) from ".tablename("gpb_order")."as o left join ".tablename("gpb_order_snapshot")."  as oss on o.go_code = oss.`oss_go_code` left join".tablename("gpb_goods") ." as g on oss.oss_gid=g.g_id  and g.weid =" . $weid . "  group by g_id ) as sale_price");

            $pager = pagination($pages, $pindex, $psize);
            foreach ( $get_all_sale_num  as $k => $v){
                $supplier = pdo_fetch("select gsp_name,gsp_shop_name,gsp_phone from " . tablename('gpb_supplier') . "  where  gsp_id ='" . $v["g_supplier_id"] . "'");
                $get_all_sale_num[$k]['gsp_name']=  $supplier["gsp_name"];
                $get_all_sale_num[$k]['gsp_shop_name']=  $supplier["gsp_shop_name"];
                $get_all_sale_num[$k]['gsp_phone']=  $supplier["gsp_phone"];
            }

        }
        // 导出表格
        if($id==2){
            $str="<tr><td>销售榜单</td><td>商品名称</td><td>供应商名称</td>";
            $str.="<td>供应商负责人</td><td>供应商电话</td><td>商品数量</td><td>申请时间</td><td>销售额</td></tr>";
            foreach ($excel_sale  as $k => $v){
                $str.="<tr><td>". intval($k+1)."</td><td>".$v["g_name"]."</td><td>". (!empty($v["gsp_shop_name"])?$v["gsp_shop_name"]:'')."</td>";
                $str.="<td>". (!empty($v["gsp_name"])?$v["gsp_name"]:'') ."</td><td>".(!empty($v["gsp_phone"])?$v["gsp_phone"]:'')."</td>";
                $str.="<td> ".$v['sale_num']."</td><td>".(!empty($v["g_add_time"])?date("Y-m-d H:i:s",$v["g_add_time"]):'')."</td><td>".$v["price"]."</td>";
                $str.=" </tr>";
            }
            $filename = "商品销售金额";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
            header('Expires:0');
            header('Pragma:public');

            echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table border="1" cellspacing="0">'.$str.'</table></html>';
            exit;


        }

        break;
    case 'sale_num':
        $id=$_GPC["id"];
        // 第一名
        $excel_sale_num= cache_load('excel_sale_num'.$weid);
        if(empty($excel_sale_num) || $_GPC['fresh']==1) {
            $excel_sale_num=  pdo_fetchall("select  sum(oss_total_price) as price,g_supplier_id,g_add_time,g_name,sum(oss.`oss_g_num`) as  sale_num,g_id  from ".tablename("gpb_order")."as o left join ".tablename("gpb_order_snapshot")."  as oss on o.go_code = oss.`oss_go_code` left join".tablename("gpb_goods") ." as g on oss.oss_gid=g.g_id  and g.weid =" . $weid . "  group by g_id order by sale_num desc");
            /*$excel_sale_num=pdo_fetchall("select  sale_num,g_name,gsp_shop_name,gsp_name,gsp_phone,g_add_time,SUM(oss_total_price) as price from ".tablename($this->goods)."as g left join ".tablename($this->supplier) ."  as gsp on gsp.gsp_id = g.g_supplier_id left join ".tablename("gpb_order_snapshot")."  as oss on oss.oss_gid = g.g_id left join".tablename("gpb_goods_stock") ."as gs on gs.gs_id = g.g_id and sale_num>0 and g.weid =" . $weid . "   group by g_id order by  sale_num desc");*/
            foreach ( $excel_sale_num  as $k => $v){
                $head_data = pdo_fetch("select gsp_name,gsp_shop_name,gsp_phone from " . tablename('gpb_supplier') . "  where  gsp_id ='" . $v["g_supplier_id"] . "'");
                $excel_sale_num[$k]['gsp_name']= $head_data["gsp_name"];
                $excel_sale_num[$k]['gsp_shop_name']= $head_data["gsp_shop_name"];
                $excel_sale_num[$k]['gsp_phone']= $head_data["gsp_phone"];
            }
            cache_write('excel_sale_num'.$weid,$excel_sale_num,24*60*60);
        }
        //数据详情
        if(empty($get_all_sale_num) || $_GPC['fresh']==1) {
            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
                $get_all_sale_num = pdo_fetchall("select  sum(oss_total_price) as price,g_supplier_id,g_add_time,g_name,sum(oss.`oss_g_num`) as  sale_num,g_id  from ".tablename("gpb_order")."as o left join ".tablename("gpb_order_snapshot")."  as oss on o.go_code = oss.`oss_go_code` left join".tablename("gpb_goods") ." as g on oss.oss_gid=g.g_id  and g.weid =" . $weid . "  group by g_id order by  sale_num desc limit ". ($pindex - 1) * $psize . ',' . $psize);
           /*$get_all_sale_num=pdo_fetchall("select  sum(oss_total_price) as price,g_supplier_id,g_add_time,g_name,sum(oss.`oss_g_num`) as  sale_num,g_id  from ".tablename("gpb_order")."as o left join ".tablename("gpb_order_snapshot")."  as oss on o.go_code = oss.`oss_go_code` left join".tablename("gpb_goods") ." as g on oss.oss_gid=g.g_id  and g.weid =" . $weid . "  group by g_id order by  price desc limit ". ($pindex - 1) * $psize . ',' . $psize);*/

            $pages= pdo_fetchcolumn("select count(*) from (select count(*) from ".tablename("gpb_order")."as o left join ".tablename("gpb_order_snapshot")."  as oss on o.go_code = oss.`oss_go_code` left join".tablename("gpb_goods") ." as g on oss.oss_gid=g.g_id  and g.weid =" . $weid . "  group by g_id ) as sale_num ");

            $pager = pagination($pages, $pindex, $psize);
            foreach ( $get_all_sale_num  as $k => $v){
                $head_data = pdo_fetch("select gsp_name,gsp_shop_name,gsp_phone from " . tablename('gpb_supplier') . "  where  gsp_id ='" . $v["g_supplier_id"] . "'");
                $get_all_sale_num[$k]['gsp_name']= $head_data["gsp_name"];
                $get_all_sale_num[$k]['gsp_shop_name']= $head_data["gsp_shop_name"];
                $get_all_sale_num[$k]['gsp_phone']= $head_data["gsp_phone"];
            }

        }
        // 导出表格
        if($id==4){
            $str="<tr><td>销售榜单</td><td>商品名称</td><td>供应商名称</td>";
            $str.="<td>供应商负责人</td><td>供应商电话</td><td>申请时间</td><td>销售数量</td></tr>";
            foreach ($excel_sale_num  as $k => $v){
                $str.="<tr><td>". intval($k+1)."</td><td>".$v["g_name"]."</td><td>". (!empty($v["gsp_shop_name"])?$v["gsp_shop_name"]:'')."</td>";
                $str.="<td>". (!empty($v["gsp_name"])?$v["gsp_name"]:'') ."</td><td>".(!empty($v["gsp_phone"])?$v["gsp_phone"]:'')."</td>";
                $str.="<td>".(!empty($v["g_add_time"])?date("Y-m-d H:i:s",$v["g_add_time"]):'')."</td><td>".$v["sale_num"]."</td>";
                $str.=" </tr>";
            }
            $filename = "商品销售数量";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
            header('Expires:0');
            header('Pragma:public');

            echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table border="1" cellspacing="0">'.$str.'</table></html>';
            exit;


        }

        break;

    case 'member':
        $id=$_GPC["id"];
        /* 第一名*/
       $excel_member = cache_load('excel_member'.$weid);
        if(empty( $excel_member) || $_GPC['fresh']==1) {
            $excel_member = pdo_fetchall("select sum(gos_real_money) as total,os.gos_team_openid,m.m_nickname as title,m.m_phone,m.m_is_head,m_head_shop_name,m_openid,m_head_address,m_head_openid  from " . tablename('gpb_member') . "  as m  left join  " . tablename('gpb_order_stream') . " as os on m.m_openid = os.gos_payer_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =" . $weid . " group by gos_payer_openid  order by total desc ");
            if (is_array( $excel_member)) {
                foreach ( $excel_member as $k => $v) {
                    $reduce = pdo_fetch("select sum(gos_real_money) as total from  " . tablename('gpb_order_stream') . " as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_payer_openid ='" . $v['gos_team_openid'] . "' group by gos_payer_openid");
                    $after_reduce = floatval($v['total']) - floatval($reduce['total']);
                    $pay_time = pdo_fetch("select go_pay_time from " . tablename('gpb_order') . " where  openid='" . $v['m_openid'] . "' and go_pay_time > 0 order by go_pay_time asc limit 1");
                    $excel_member[$k]['first_pay'] = $pay_time["go_pay_time"];
                    if ($v["m_is_head"] == '-1') {
                        $head_data = pdo_fetch("select m_phone,m_head_shop_name,m_nickname,m_head_address from " . tablename('gpb_member') . "  where  m_openid ='" . $v["m_head_openid"] . "'");
                        $excel_member[$k]['phone'] = $head_data ["m_phone"];
                        $excel_member[$k]['head_name'] = $head_data ["m_nickname"];
                        $excel_member[$k]['shop_name'] = $head_data ["m_head_shop_name"];
                        $excel_member[$k]['address'] =$head_data ["m_head_address"];
                    } else if ($v["m_is_head"] == 2) {
                        $excel_member[$k]['phone'] = $v["m_phone"];
                        $excel_member[$k]['head_name'] = $v["title"];
                        $excel_member[$k]['shop_name'] = $v["m_head_shop_name"];
                        $excel_member[$k]['address'] =$v ["m_head_address"];
                    }

                    if ($after_reduce <= 0) {
                        unset( $excel_member['$k']);
                    } else {
                        $excel_member[$k]['total'] = $after_reduce;

                    }
                }
            }
            cache_write('excel_member'.$weid, $excel_member,24*60*60);
        }
        //数据详情
        if(empty($get_all_member) || $_GPC['fresh']==1) {
            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
            $get_all_member = pdo_fetchall("select sum(gos_real_money) as total,m.m_head_openid,m.m_nickname as title,m.m_phone,m.m_is_head,m.m_head_shop_name,m_head_address,m_openid  from " . tablename('gpb_member') . "  as m  left join  " . tablename('gpb_order_stream') . " as os on m.m_openid = os.gos_payer_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =" . $weid . " group by gos_payer_openid  order by total desc  limit " . ($pindex - 1) * $psize . ',' . $psize);
            $pages = pdo_fetchcolumn("select  count(*) from ( select count(*) from " . tablename('gpb_member') . "  as m  left join " . tablename('gpb_order_snapshot') . "  as oss on  m.m_head_openid= oss.oss_head_openid   left join " . tablename('gpb_order_stream') . " as os on m.m_openid = os.gos_payer_openid where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =1 and os.weid =" . $weid . " group by gos_payer_openid) as mem");
            $pager = pagination($pages, $pindex, $psize);
            if(is_array($get_all_member)) {
                foreach ($get_all_member as $k => $v) {
                    $reduce = pdo_fetch("select sum(gos_real_money) as total from  " . tablename('gpb_order_stream') . " as os where gos_stream_type=1 and gos_status=2 and gos_real_money >0 and gos_type =2 and gos_payer_openid ='" . $v['gos_team_openid'] . "' group by gos_payer_openid");
                    $after_reduce = floatval($v['total']) - floatval($reduce['total']);
                    $pay_time = pdo_fetch("select go_pay_time from " . tablename('gpb_order') . " where  openid='" . $v['m_openid'] . "' and go_pay_time > 0 order by go_pay_time asc limit 1");
                    $get_all_member[$k]['first_pay'] = $pay_time["go_pay_time"];
                    if ($v["m_is_head"] == '-1') {
                        $head_data = pdo_fetch("select m_phone,m_head_shop_name,m_nickname,m_head_address from " . tablename('gpb_member') . "  where  m_openid ='" . $v["m_head_openid"] . "'");
                        $get_all_member[$k]['phone'] = $head_data ["m_phone"];
                        $get_all_member[$k]['head_name'] = $head_data ["m_nickname"];
                        $get_all_member[$k]['shop_name'] = $head_data ["m_head_shop_name"];
                        $get_all_member[$k]['address'] =$head_data ["m_head_address"];
                    } else if ($v["m_is_head"] == 2) {
                        $get_all_member[$k]['phone'] = $v["m_phone"];
                        $get_all_member[$k]['head_name'] = $v["title"];
                        $get_all_member[$k]['shop_name'] = $v["m_head_shop_name"];
                        $get_all_member[$k]['address'] =$v ["m_head_address"];
                    }

                    if ($after_reduce <= 0) {
                        unset($get_all_member['$k']);
                    } else {
                        $get_all_member[$k]['total'] = $after_reduce;

                    }
                }
            }

            }
        //导出表格
        if($id==3){
            $str="<tr><td>销售榜单</td><td>会员名称</td><td>会员电话</td>";
            $str.="<td>会员身份</td><td>所属小区</td><td>团长名称</td><td>团长电话</td><td>第一次消费时间</td><td>累计消费额</td></tr>";
            foreach ( $excel_member  as $k => $v){
                $str.="<tr><td>". intval($k+1)."</td><td>".$v["title"]."</td><td>". $v["m_phone"]."</td>";
                $str.="<td>". ($v["m_is_head"]==2?'团长':'会员')."</td><td>".$v["address"].$v["shop_name"]."</td>";
                $str.="<td> ".$v["head_name"]."</td><td>".$v["phone"]."</td><td>". (!empty($v["first_pay"])?date("Y-m-d H:i:s",$v["first_pay"]):'')."</td>";
                $str.="<td>".$v["total"]."</td> </tr>";
            }
            $filename = "会员消费";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
            header('Expires:0');
            header('Pragma:public');

            echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table border="1" cellspacing="0">'.$str.'</table></html>';
            exit;

        }

        break;
}
include $this -> template('web/' . $do . '/' . $op);
?>