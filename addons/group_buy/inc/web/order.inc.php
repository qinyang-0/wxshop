<?php
/**
 * 订单管理相关
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
if( ($op == 'index' || $op == 'afterSale') and isset($_GPC['out-all-check']) and $_GPC['out-all-check']==1){
    $old_op = $op;
    $op='outXlsx';
}
//团长送货
if( ($op == 'index') and isset($_GPC['batch-send-goods']) and $_GPC['batch-send-goods']==3){
    $old_op = $op;
    $op='send';
}
//采购单
if( ($op == 'index') and isset($_GPC['out_purchase-goods']) and $_GPC['out_purchase-goods']==4){
    $old_op = $op;
    $op='out_purchase';
}
switch($op){
    case 'index':
        $supplier_role = pdo_get('gpb_supplier',array('weid'=>$weid,'uid'=>$_W['uid'],'gsp_status'=>1));
        /*echo "<pre/>";
        var_dump($supplier_role);
        die;*/
        if(!empty($supplier_role)){
            $this->supplier_role=1;
        }else{
            $this->supplier_role = 0;
        }
		$stime=microtime(true); 
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //关键词类型
        $key_field = trim($_GPC['key_field']);
        //key关键词
        $key = trim($_GPC['key']);
        //配送方式
        $send_type = trim($_GPC['send_type']);
        if(!empty($send_type)){
            $where .= " and  go_send_type = ".$send_type." ";
        }
        if(!empty($key_field)){
            switch ($key_field){
                case 'order_num':
                    $where .= " and  oss_go_code like '%".$key."%' ";
                    break;
                case 'action_name':
                    $where .= " and  oss_ac_name like '%".$key."%' ";
                    break;
                case 'vg_name':
                    $where .= " and  oss_v_name like '%".$key."%' ";
                    break;
                case 'header':
                    $where .= " and ( oss_head_name like '%".$key."%' or  oss_head_name like '%".base64_encode($key)."%') ";
                    break;
                case 'buyer':
                    $where .= " and ( oss_buy_name like '%".$key."%' or oss_buy_name like '%".base64_encode($key)."%') ";
                    break;
                case 'receiver':
                    $where .= " and ( oss_buy_name like '%".$key."%' or  oss_buy_name like '%".base64_encode($key)."%') ";
                    break;
                case 'g_name':
                    $where .= " and  oss_g_name like '%".$key."%' ";
                    break;
				case 'sekill':
					$where .= " and  oss_is_seckill = 1";
				break;
				case 'bargain':
					$where .= " and  oss_is_seckill = 2";
				break;
            }
        }
        //逻辑：配送方式是确定查询
//        if( isset($_GPC['send_type']) and !empty($_GPC['send_type']) ) {
//            $where .= " and  go_send_type = '".trim($_GPC['send_type'])."' ";
//        }
        //逻辑：订单号是模糊查询
//        if( isset($_GPC['num']) and !empty($_GPC['num']) ) {
//            $where .= " and  go_code like '%".trim($_GPC['num'])."%' ";
//        }
        //逻辑：活动名称是模糊查询
//        if( isset($_GPC['action']) and !empty($_GPC['action']) ) {
//            $where .= " and  oss_ac_name like '%".trim($_GPC['action'])."%' ";
//        }
        //逻辑：小区名称是模糊查询
//        if( isset($_GPC['village']) and !empty($_GPC['village']) ) {
//            $where .= " and  oss_v_name like '%".trim($_GPC['village'])."%' ";
//        }
        //逻辑：团长名称是模糊查询
//        if( isset($_GPC['head']) and !empty($_GPC['head']) ) {
//            $where .= " and  oss_head_name like '%".trim($_GPC['head'])."%' ";
//        }
        //逻辑：买家名称是模糊查询
//        if( isset($_GPC['buy_people']) and !empty($_GPC['buy_people']) ) {
//            $where .= " and  oss_buy_name like '%".trim($_GPC['buy_people'])."%' ";
//        }
        //逻辑：收货人名称是模糊查询
//        if( isset($_GPC['get_name']) and !empty($_GPC['get_name']) ) {
//            $where .= " and  oss_buy_name like '%".trim($_GPC['get_name'])."%' ";
//        }
        //逻辑：订单状态是确定查询
        $status = $_GPC['status'];
        if( isset($_GPC['status']) and !empty($_GPC['status']) ) {
            $where .= " and  go_status = '".trim($_GPC['status'])."' ";
        }
        //时间类型
        $time_type = trim($_GPC['time_type']);
        if(!empty($time_type)){
            switch ($time_type){
                case 'add_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_add_time >= ".strtotime($_GPC['time']['start'])." and go_add_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_add_time >= ".strtotime(date('Y-m-d',time()))." and go_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'pay_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_pay_time >= ".strtotime($_GPC['time']['start'])." and go_pay_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_pay_time >= ".strtotime(date('Y-m-d',time()))." and go_pay_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'send_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_send_goods_time >= ".strtotime($_GPC['time']['start'])." and go_send_goods_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_send_goods_time >= ".strtotime(date('Y-m-d',time()))." and go_send_goods_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
            }
        }
        //逻辑：时间是范围查询
//        if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
//            if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
//                $where .= " and  go_add_time >= ".strtotime($_GPC['time']['start'])." and go_add_time <=".(strtotime($_GPC['time']['end'])+24*60*60);
//            }else{
//                $where .= " and  go_add_time >= ".strtotime(date('Y-m-d',time()))." and go_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
//            }
//
//        }

        if($this->supplier_role==1){
            //是供应商 增加条件
            $where = " and g.g_supplier_id={$supplier_role['gsp_id']}";
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total_sql = 'select count(*) from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1  ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t
        left join (
            select pa.state as pastate,po.osn as order_sn from ".tablename("gpb_pteam_order")." as po left join ".tablename("gpb_pteam_activity")." as pa on po.aid=pa.id where pa.state=10 and pa.weid={$weid} and po.state=2
        ) 
        as pteam on t.oss_go_code = pteam.order_sn where (t.oss_is_seckill=3 and pteam.order_sn!='' and pteam.order_sn is not null ) or (t.oss_is_seckill!=3 and (pteam.order_sn='' or pteam.order_sn is null) )
        ";
        $total= pdo_fetchcolumn($total_sql);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
    /**
     * 2019-11-13
     * 查询订单列表改为子查询 子查询后进行 limit计算分组
     */
        $sql = "select o.*,os.*,g.`g_id`,g.`g_name`,g.`g_cid`,g.`g_brief`,g.`g_old_price`,g.`g_price`,g.`g_sale_num`,g.`g_icon`,g.`g_info`,g.`g_is_online`,g.`g_is_del`,g.`g_add_time`,g.`g_update_time`,g.`g_order`,g.`g_thumb`,g.`g_video`,g.`g_is_recommand`,g.`g_is_hot`,g.`g_real_sale_num`,g.`g_product_num`,g.`g_limit_num`,g.`g_start_sale_time`,g.`g_end_sale_time`,g.`g_is_sale_time`,g.`g_arrival_time`,g.`g_is_new`,g.`g_arrival_time_text`,g.`g_supplier_id`,g.`g_has_option`,g.`send_points`,g.`g_day_limit_num`,g.`g_commission`,g.`g_send_type`,g.`g_send_price_sample`,g.`g_express_shipping_id`,g.`g_only_weight`,g.`g_stock_notice`,g.`g_is_top`,g.`g_is_full_reduce`,g.`g_history_limit_num`,g.`g_is_near_recommend`,g.`g_virtual_people`,g.`g_virtual_max_buy`,g.`g_virtual_min_buy`,g.`member_card_discount`,g.`dis_type`,g.`dis_rule`,
sum(oss_total_price) as total,
group_concat(oss_g_name separator '||') as gname,
group_concat(oss_g_icon separator '||') as gicon,
group_concat(oss_g_price separator '||') as gprice,
group_concat(oss_g_num separator '||') as gnum,
group_concat(g_brief separator '||') as gbrief,
group_concat(oss_ggo_title separator '||') as ggotitle 
from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code  left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where go_is_del = 1  ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) group by o.go_code  order by go_id desc ";
        $sql = "select t.* from ({$sql}) as t left join (
         select pa.state as pastate,po.osn as order_sn from ".tablename("gpb_pteam_order")." as po left join ".tablename("gpb_pteam_activity")." as pa on po.aid=pa.id where pa.state=10 and pa.weid={$weid} and po.state=2
)  as pteam on t.oss_go_code = pteam.order_sn where (t.oss_is_seckill=3 and pteam.order_sn!='' and pteam.order_sn is not null ) or (t.oss_is_seckill!=3 and (pteam.order_sn='' or pteam.order_sn is null) ) {$contion}";
        if(!empty($_GPC['debug'])){
            echo $total_sql;
            echo "<br/>";
            echo $sql;
        }
//		var_dump($sql);exit;
        $info = pdo_fetchall($sql);
        if(is_array($info)){
            foreach ($info as $k=>$v){
                if($this->check_base64_out_json( $v['oss_address_name'] )){
                    $info[$k]['oss_address_name'] = base64_decode( $v['oss_address_name'] );
                }
                if($this->check_base64_out_json( $v['oss_buy_name'] )){
                    $info[$k]['oss_buy_name'] = base64_decode( $v['oss_buy_name'] );
                }
                if($this->check_base64_out_json( $v['oss_head_name'] )){
                    $info[$k]['oss_head_name'] = base64_decode( $v['oss_head_name'] );
                }
            }
        }
        //查询各个状态下的数量
        $status_arr = array(
            "",
            10,
            20,
            30,
            100,
            110,
            120
        );
        $status = array();
        $total_money = array();
        $back_money = array();
        foreach ($status_arr as  $v){
            $where_s = "";
            if(!empty($v)){
                $where_s .= " and  go_status = '".$v."' ";
            }
            if($this->supplier_role==1){
                //是供应商 增加条件
                $where_s .= " and g.g_supplier_id={$supplier_role['gsp_id']}";
            }
            $sel_sql = 'select COUNT(DISTINCT go_code) from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where_s." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null )";
//            echo $sel_sql."<br/>";
            $status[intval($v)] = pdo_fetchcolumn($sel_sql);

            //2020-03-12 周龙 添加 拼团订单未完成排除
            if(WeUtility::createModuleHook("group_buy_plugin_team")){
                //有安装插件
                $sql = "SELECT count(*) FROM ".tablename("gpb_pteam_order")." AS po
LEFT JOIN ".tablename("gpb_pteam_activity")." AS pa ON po.aid=pa.`id`
JOIN ".tablename("gpb_order")." AS o ON po.osn=o.go_code
JOIN ".tablename("gpb_order_snapshot")." AS oss ON o.go_code=oss.oss_go_code
WHERE pa.`all_num`!=pa.`now_num` ".$where;
                if(!empty($v)){
                    $sql .= " and o.go_status={$v}";
                }
                $pteam_order_count = pdo_fetchcolumn($sql);
                $status[intval($v)] -=$pteam_order_count;
            }


            //10-16优化 sql 优化
//          $status[intval($v)] = pdo_fetchcolumn('select count(*) from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where_s." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
//			echo 'select count(*) from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where_s." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t";exit;
//          $total_money[intval($v)] = pdo_fetch('select sum(go_real_price) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where_s." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
//          $back_money[intval($v)] = pdo_fetch('select sum(oss_g_price*oss_g_num) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where_s." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) and os.oss_ggo_status =70  order by go_id desc) as t");
//          $res_money[intval($v)]  =sprintf('%01.2f',($total_money[intval($v)]['a']-floatval($back_money[intval($v)]['a'])));
        }
       /* if(!empty($_GPC['status'])){
            $s_array = [20,30,40];
            if(in_array($_GPC['status'],$s_array)){

            }
        }*/
        $now_total_money = pdo_fetch('select sum(go_real_price) as a from (select  DISTINCT go_code,go_real_price  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) ) as t");




//      $now_total_money = pdo_fetch('select sum(go_real_price) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");

//        $now_back_money = pdo_fetch('select sum(oss_g_price*oss_g_num) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) and os.oss_ggo_status =70  order by go_id desc) as t");
        $now_back_money['a'] = 0;

        //2020-03-12 周龙 添加去除拼团失败及未成团订单
        if(WeUtility::createModuleHook("group_buy_plugin_team")){
            $sql = "SELECT SUM(o.go_real_price) FROM ".tablename("gpb_pteam_order")." AS po 
                    LEFT JOIN ".tablename("gpb_pteam_activity")." AS pa ON po.aid=pa.id
                    JOIN ".tablename("gpb_order")." AS o ON po.osn=o.go_code
                    JOIN ".tablename("gpb_order_snapshot")." AS oss ON o.go_code=oss.oss_go_code
                    WHERE o.weid={$this->weid}
                    AND o.go_is_del=1
                    AND pa.`all_num`!=pa.`now_num`".$where;
            $pteam_money = pdo_fetchcolumn($sql);
            if(!empty($_GPC['debug'])){
                echo "<br/>";
                echo $sql;
                echo "<pre/>";
                var_dump($pteam_money);
                die;
            }
            $pteam_money = !empty($pteam_money)?doubleval($pteam_money):0;
            $now_total_money['a'] -= $pteam_money;
        }
		
        $now_money  =sprintf('%01.2f',($now_total_money['a']-floatval($now_back_money['a'])));



        //读取后台是否加入配送流程
        $order_back_send_type= pdo_get($this->config,array('key'=>'order_back_send_type','weid'=>$weid));
        $order_back_send_type = isset($order_back_send_type['value'])?$order_back_send_type['value']:1;
		 //是否开启平台确认收货
        $is_open_manger_sure_order = pdo_get($this->config,array('key'=>'is_open_manger_sure_order','weid'=>$weid));
        $is_open_manger_sure_order = isset($is_open_manger_sure_order['value'])?intval($is_open_manger_sure_order['value']):2;
		
        break;
    case 'add':
        if($_GPC['submit'] == '提交'){

        }else{
            if($id){
                $sql = 'select * from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code  where o.weid=".$weid." and go_is_del = 1 and go_code='".$id."'  order by go_id desc ";
                /*echo $sql;
                die;*/

                $info = pdo_fetchall($sql);
                if($info[0]['go_send_type']!=1){
                    //非自提
                    if(is_array($info)){
                        foreach ($info as $k=>$v){
                            if($this->check_base64_out_json( $v['oss_address_name'] )){
                                $info[$k]['oss_address_name'] = base64_decode( $v['oss_address_name'] );
                            }
                            if($this->check_base64_out_json( $v['oss_buy_name'] )){
                                $info[$k]['oss_buy_name'] = base64_decode( $v['oss_buy_name'] );
                            }
                            if($this->check_base64_out_json( $v['oss_head_name'] )){
                                $info[$k]['oss_head_name'] = base64_decode( $v['oss_head_name'] );
                            }

                        }
                    }
                }else{
                    //自提获取对应团长地址
                    $add = pdo_fetch("select * from ".tablename($this->member)." where weid={$weid} and m_status=1 and m_openid='{$info[0]['oss_head_openid']}' order by m_id desc");
                    /*echo "select * from ".tablename($this->member)." where weid={$weid} and status=1 and m_openid='{$info[0]['oss_head_openid']}' order by ah_id desc";
                    echo "<pre/>";
                    var_dump($add);
                    die;*/
                    if(is_array($info)){
                        foreach ($info as $k=>$v){
                            if($this->check_base64_out_json( $v['oss_address_name'] )){
                                $info[$k]['oss_address_name'] = base64_decode( $v['oss_address_name'] );
                            }
                            if($this->check_base64_out_json( $v['oss_buy_name'] )){
                                $info[$k]['oss_buy_name'] = base64_decode( $v['oss_buy_name'] );
                            }
                            if($this->check_base64_out_json( $v['oss_head_name'] )){
                                $info[$k]['oss_head_name'] = base64_decode( $v['oss_head_name'] );
                            }
                            $info[$k]['oss_address'] = $add['m_head_address'];
                        }
                    }
                }

				//获取地址
				$str = "";
				$address = pdo_get("gpb_receiving_address",array('openid'=>$info[0]['openid']));
				if($address['ra_province']){
					$name = pdo_get("gpb_area",array('ad_code'=>$address['ra_province']),array('name'));
					$str .= $name['name']."-";
				}
				if($address['ra_city']){
					$name = pdo_get("gpb_area",array('ad_code'=>$address['ra_city']),array('name'));
					$str .= $name['name']."-";
				}
				if($address['ra_area']){
					$name = pdo_get("gpb_area",array('ad_code'=>$address['ra_area']),array('name'));
					$str .= $name['name'];
				}
//				var_dump($info);
                // 获取操作记录
                $log = pdo_getall($this->order_log,["gol_go_code"=>$info[0]['go_code'] ]);
            }
        }
        break;
    case 'save':
        break;
    case 'del':
        if($id){
            $res = pdo_update($this->order,['m_status'=>-1],['m_id'=>$id,'weid'=>$weid]);
            if($res){
                echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
    case 'setStatus':
        $id = trim($_GPC['id'],',');
        $id_arr = explode(',',$id);
        if($id){
            $code = intval($_GPC['code']);
            pdo_begin();
            $ship_send_count=0;
            switch ($code){
                case  25:
                    $des = "配送并进入待配送列表";
                    $data_order = array('go_status'=>$code,'go_send_goods_time'=>time());
					//查询是否还有需要快递发货的订单
					$ship_send_count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_order')." where go_status=20 and go_send_type=3 and weid=".$this->weid." and `type`=1");
                    break;
                case  30:
                    $des = "确认后直接发货";
                    $data_order = array('go_status'=>$code,'go_send_goods_time'=>time());
                    //查询是否还有需要快递发货的订单
					$ship_send_count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_order')." where go_status=20 and go_send_type=3 and weid=".$this->weid." and `type`=1");
                    break;
                case 120:
                    $des = "交易关闭";
                    $data_order = array('go_status'=>$code);
                    break;
                default:
                    echo json_encode(['status'=>1,'msg'=>'非法操作'.$code]);exit;
                    break;
            }


            foreach ( $id_arr as $v ) {

                if($code==30){
                    //直接发货
                    $order_info_v = pdo_get('gpb_order',array('go_code'=>$v));

                    $sms = new Sms();
                    $sms->weid=$this->weid;
                    $this->Tokens();
                    $sn = pdo_fetchall('select oss_go_code,oss_g_name,oss_g_num,oss_address_name,oss_address_phone from '.tablename('gpb_order_snapshot').' where   oss_go_code='.$order_info_v['go_code'].' and oss_ggo_status=1');
                    $g_name_str =$sn[0]['oss_g_name'].'...';
                    $g_num=0;
                    foreach ($sn as $val){
//                            $g_name_str .=','.$val['oss_g_name'];
                        $g_num =intval($g_num) + intval($val['oss_g_num']);
                    }
                    //依次为:1订单编号,2货物,3数量,4订单金额,5备注,6收货人,7收件人电话
                    $sms_array=array('1'=>$order_info_v['go_code'],'2'=>trim($g_name_str,','),'3'=>$g_num,'4'=>$order_info_v['go_real_price'],'5'=>'您的货物已发货，请密切关注','6'=>$sn[0]['oss_address_name'],'7'=>$sn[0]['oss_address_phone']);
                    $form_id = empty($order_info_v['prepay_id'])?$order_info_v['go_send_formid']:$order_info_v['prepay_id'];
                    $dass = $sms->send_out('sms_send_order',$sms_array,$_W['account']['access_tokne'],$order_info_v['openid'],'pages/order/orderDetail?id='.$order_info_v['go_id'],$form_id,$sms->weid,'AT1122');

                    //新增订阅消息 周龙 2020-02-27
                    $submsg = new \SubMsg();
                    $submsg_arr = [
                        $order_info_v['go_code'],
                        trim($g_name_str,','),
                        $g_num,
                        $order_info_v['go_real_price'],
                        '您的货物已发货，请密切关注'
                    ];
                    $submsg->sendmsg("deliver_msg",$order_info_v['openid'],$submsg_arr,'pages/order/orderDetail?id='.$order_info_v['go_id']);

                    $log_content = date('Y-m-d H:i:s').'，后台订单直接发货后模版消息日志（setStatus）'.PHP_EOL;
                    if(is_array($dass)){
                        foreach ($dass as $dass_k=>$dass_v){
                            $log_content .='key:'.$dass_k.',value:'.$dass_v.PHP_EOL;
                        }
                    }
                    $log_content .= json_encode(array('sms_send_order',$sms_array,$_W['account']['access_tokne'],$order_info_v['openid'],'pages/order/orderDetail?id='.$order_info_v['go_id'],$form_id,$sms->weid,'AT1122'),JSON_UNESCAPED_UNICODE);
                    $log_content .= '----------end------------'.PHP_EOL;
                    $this->txt_logging_fun('sms_AT0229_log.txt',$log_content);
					$this->pay_success_send_official_account_msgs($sn[0]['oss_go_code']);
                }
                if($code==120){
                    //交易关闭,
                    $order_info_v = pdo_get('gpb_order',array('go_code'=>$v));

                    //交易关闭库存退回

                    //step1获取扣库存类型
                    $reduce_stock_type = intval($order_info_v['go_reduce_stock']);
                    if( ($reduce_stock_type===1 && $order_info_v['go_status']>10) || ($reduce_stock_type===2) ){
                        //step2 查询订单商品及数量
                        $snapshot_info = pdo_fetchall("select oss_gid,oss_g_num,oss_ggo_id from ".tablename("gpb_order_snapshot")." where oss_go_code='{$v}'");
                        //step3 库存销量退回
                        foreach ($snapshot_info as $ke=>$va){
                            if(empty($va['oss_ggo_id'])){
                                //单规格返还库存及销量
                                $back_sql = "update ".tablename("gpb_goods_stock")." set num=num+{$va['oss_g_num']},sale_num=sale_num-{$va['oss_g_num']} where goods_id={$va['oss_gid']}";
                                pdo_query($back_sql);
//                        exit($back_sql);
                            }else{
                                //先查询是否长期售卖
                                $is_long_sale = pdo_fetchcolumn("select ggo_stock from ".tablename("gpb_goods_option")." where ggo_id={$va['oss_ggo_id']}");
                                $is_long_sale = intval($is_long_sale);
                                if($is_long_sale!==-1){
                                    //非长期售卖多规格返还库存
                                    $back_sql = "update ".tablename("gpb_goods_option")." set ggo_stock=ggo_stock+{$va['oss_g_num']} where ggo_id={$va['oss_ggo_id']}";
                                    pdo_query($back_sql);
                                    $back_sql = "update ".tablename("gpb_goods_stock")." set num=num+{$va['oss_g_num']} where goods_id={$va['oss_gid']}";
                                    pdo_query($back_sql);
                                }
                                //退还销量
                                $back_sql = "update ".tablename("gpb_goods_stock")." set sale_num=sale_num-{$va['oss_g_num']} where goods_id={$va['oss_gid']}";
                                pdo_query($back_sql);
                            }

                        }
                    }


                    /*echo "<pre/>";
                    var_dump($snapshot_info);
                    exit();*/
                    if($order_info_v['go_status'] ==20 || $order_info_v['go_status'] ==25 ){
                        //当确认支付了，且货还没由平台真正发出去时，关闭交易要退款
                        $des = '后台管理员操作交易关闭，未发货直接退款';
                        $account = pdo_get($this->member,array('m_openid'=>$order_info_v['openid'],'weid'=>$weid));
                        $head_info = pdo_get($this->member,array('m_openid'=>$order_info_v['go_team_openid'],'weid'=>$weid));
                        $openid = $account['m_openid'];
//                            $goods = pdo_get($this->snapshot,array("oss_go_code"=>$order_info_v['gbm_oss_id']));
                        if($order_info_v['go_pay_type'] ==1 or $order_info_v['go_pay_type']==3){
                            //当有微信支付参与时 准备微信退款
                            $mchid = $_W['account']['setting']['payment']['wechat']['mchid'];
                            $appid = $_W['account']['key'];
                            $signkey = $_W['account']['setting']['payment']['wechat']['signkey'];

                            $pem_cert = pdo_get($this->config,array('key'=>'cert_address','weid'=>$weid));
                            $pem_cert = $pem_cert['value'];
                            if(empty($pem_cert)){
                                continue;
                            }
                            $pem_key = pdo_get($this->config,array('key'=>'key_address','weid'=>$weid));
                            $pem_key = $pem_key['value'];
                            if(empty($pem_key)){
                                continue;
                            }
                            $res = $this -> refund_info($appid,$mchid,$signkey,$order_info_v['go_code'],$this->nextId(),$order_info_v['go_wx_price'],$order_info_v['go_wx_price'],"..".$pem_cert,"..".$pem_key);
                            $str = serialize($res);
                            @$this->logger('退款时-ERR_CODE_DES:'.$res['data']['ERR_CODE_DES'].',ERR_CODE:'.$res['data']['ERR_CODE'].','.$str);
                            if($res['status']==1 and $res['data']['RETURN_CODE'] == 'SUCCESS' and $res['data']['RETURN_MSG']=='OK' and $res['data']['RESULT_CODE']!='FAIL'){

                                //发送模版消息 todo+++++++++++++++++++++++
                                $sms = new Sms();
                                $sms->weid = $weid;
                                $msg_arr = array(
                                    "1"=>$order_info_v['go_code'],
                                    "2"=>date("Y-m-d H:i:s",time()),
                                    "3"=>$order_info_v['go_wx_price'],
                                    "4"=>'全部商品',
                                    "5"=>'退款成功',
                                );
                                $this->Tokens();
                                $form_id = empty($order_info_v['prepay_id'])?$order_info_v['go_headget_formid']:$order_info_v['prepay_id'];
                                $infos = $sms->send_out('back_money_tmp',$msg_arr,$_W['account']['access_tokne'],$order_info_v['openid'],'',$form_id,$weid,'AT0787');

                                //新增订阅消息 周龙 2020-02-27
                                $submsg = new \SubMsg();
                                $submsg_arr = [
                                    $order_info_v['go_code'],
                                    date("Y-m-d H:i:s",time()),
                                    $order_info_v['go_wx_price'].'元',
                                    '全部商品',
                                    '退款成功'
                                ];
                                $submsg->sendmsg("refund_msg",$order_info_v['openid'],$submsg_arr);


                            }elseif ($res['status']==1 and $res['data']['return_code'] == 'SUCCESS' and $res['data']['result_code']=='FAIL' and !empty($res['data']['err_code_des']) ){
                                continue;
                            }else{
                                continue;
                            }
                        }
                        if($order_info_v['go_balance_price']>0){
                            //当有余额参与时,退余额
                            pdo_update($this->member,array("m_money_balance +="=>$order_info_v['go_balance_price']),array("m_openid"=>$order_info_v['openid'],'weid'=>$weid));
                            //存入日志
                            $recharge_log_data = array(
                                'st'=>1,
                                'uid'=>$account['m_id'],
                                'openid'=>$account['m_openid'],
                                'info'=>'退款，退还余额'.$order_info_v['go_balance_price'],
                                'type'=>3,
                                'status'=>1,
                                'create_time'=>time(),
                                'weid'=>$weid,
                                'money'=>$order_info_v['go_balance_price'],
                                'l_type'=>1,
                                'remarks'=>'订单号：'.$order_info_v['go_code'],
                                'pay_f'=>3
                            );

                            //新增订阅消息 周龙 2020-02-27
                            $submsg = new \SubMsg();
                            $submsg_arr = [
                                $order_info_v['go_code'],
                                date("Y-m-d H:i:s",time()),
                                $order_info_v['go_balance_price'].'元',
                                '退款，退还余额'.$order_info_v['go_balance_price'],
                                '退款成功'
                            ];
                            $submsg->sendmsg("refund_msg",$order_info_v['openid'],$submsg_arr);

                            pdo_insert('gpb_recharge_log',$recharge_log_data);
                        }

                        if($order_info_v['go_release_price']>0 && $order_info_v['go_add_time']>strtotime(date('Ymd')) && $order_info_v['go_add_time']<(strtotime(date('Ymd')+24*60*60))){
                            //当有返利金参与时并没有超过当天时,退返利金
                            $recharge_list = pdo_get('gpb_recharge_list',array('list_type'=>1,'openid'=>$order_info_v['openid'],'weid'=>$weid,'overdue'=>1,'time'=>strtotime(date('Ymd'))) );
                            pdo_update('gpb_recharge_list',array('money +='=>$order_info_v['go_release_price'],'use_money -='=>$order_info_v['go_release_price']),array('id'=>$recharge_list['id']));
                            //存入日志
                            $recharge_log_data = array(
                                'st'=>1,
                                'uid'=>$account['m_id'],
                                'openid'=>$account['m_openid'],
                                'info'=>'当天退款，退还返利金'.$order_info_v['go_release_price'],
                                'type'=>3,
                                'status'=>1,
                                'create_time'=>time(),
                                'weid'=>$weid,
                                'money'=>$order_info_v['go_release_price'],
                                'l_type'=>1,
                                'remarks'=>'订单号：'.$order_info_v['go_code'],
                                'pay_f'=>3
                            );

                            //新增订阅消息 周龙 2020-02-27
                            $submsg = new \SubMsg();
                            $submsg_arr = [
                                $order_info_v['go_code'],
                                date("Y-m-d H:i:s",time()),
                                $order_info_v['go_release_price'].'元',
                                '当天退款，退还返利金'.$order_info_v['go_release_price'],
                                '退款成功'
                            ];
                            $sub_res = $submsg->sendmsg("refund_msg",$order_info_v['openid'],$submsg_arr);

                            pdo_insert('gpb_recharge_log',$recharge_log_data);
                        }
                        //退款成功需要生成流水
                        //存入退款流水
                        $data_stream = array(
                            'gos_code'=>date('Ymd',time()).$this->nextId(),//流水号
                            'gos_go_code'=>$order_info_v['go_code'],//订单号
                            'gos_stream_type'=>2,
                            'gos_type'=>2,
                            'gos_commet'=>'系统交易关闭退款成功',
                            'gos_owner'=>'平台',
                            'gos_order_money'=>$order_info_v['go_real_price'],
                            'gos_real_money'=>$order_info_v['go_real_price'],
                            'gos_payer'=>$account['m_nickname'],
                            'gos_status'=>2,
                            'gos_add_time'=>time(),
                            'gos_sure_pay_time'=>time(),
                            'weid'=>$this->weid,
                            'gos_pay_type'=>1,
                            'gos_team'=>$head_info['m_nickname'],
                            'gos_payer_openid'=>$account['m_openid'],
                            'gos_team_openid'=>$order_info_v['go_team_openid']
                        );
                        pdo_insert($this->stream,$data_stream);
                        //有优惠卷的时候释放
                        if($order_info_v['go_fdc_id']>0){
                            $goods_count = pdo_fetchcolumn("select count(*) from ".tablename($this->snapshot)." where oss_go_code=".$order_info_v['go_code']." and oss_ggo_status=1");
                            //是否是最后一件商品
                            if($goods_count <1 ){
                                pdo_update($this->user_coupon,array('is_use'=>0),array('id'=>$order_info_v['go_fdc_id']));
                            }
                        }



                    }elseif($order_info_v['go_status'] ==10){

                        /*//获取扣库存方式
                        $dec_order = pdo_fetchcolumn("select `value` from ".tablename($this->config)." where weid={$this->weid} and `key`='reduce_stock_type' and `status`=1");
                        if(intval($dec_order)===2){
                            //下单扣库存 库存归还处理

                            //第一步 根据订单号查询订单快照
                            $order_list = pdo_fetchall("select oss_gid,oss_g_num from ".tablename($this->snapshot)." where oss_go_code='{$order_info_v['go_code']}' ");
                            $sql = "";
                            foreach ($order_list as $k=>$v){
                                $sql .= "update ".tablename($this->goods);
                            }
                            echo "<pre/>";
                            var_dump($order_info_v);
                            die;
                        }*/

                        $des = '后台管理员操作交易关闭';
                    }else{
                        continue;
                    }
                }

                pdo_update($this->order,$data_order,array('go_code'=>$v,'weid'=>$weid) );

                $data = [
                    'gol_uid' => $_GPC['__uid'],
                    'gol_add_time' => time(),
                    'gol_des' => $des,
                    'gol_go_code' => $v,
                    'gol_u_name' => $_W['username']
                ];
                $res = pdo_insert($this->order_log, $data);
            }

            if(!empty($res)){
                pdo_commit();
                echo json_encode(['status'=>0,'msg'=>'操作成功','data'=>array('count'=>$ship_send_count)]);
                exit;
            }else{
                pdo_rollback();
                echo json_encode(['status'=>1,'msg'=>'操作失败']);exit;
            }
            exit();
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法操作']);exit;
        }
        break;
    case 'orderSure':
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //逻辑：订单号是模糊查询
        if( isset($_GPC['num']) and !empty($_GPC['num']) ) {
            $where .= " and  so_go_code like '%".trim($_GPC['num'])."%' ";
        }
        //逻辑：活动名称是模糊查询
        if( isset($_GPC['code']) and !empty($_GPC['code']) ) {
            $where .= " and  so_code like '%".trim($_GPC['code'])."%' ";
        }
        //逻辑：团长名称是模糊查询
        if( isset($_GPC['head']) and !empty($_GPC['head']) ) {
            $where .= " and  so_sure_name like '%".trim($_GPC['head'])."%' ";
        }
        //逻辑：买家名称是模糊查询
        if( isset($_GPC['buy_people']) and !empty($_GPC['buy_people']) ) {
            $where .= " and  so_buy_name like '%".trim($_GPC['buy_people'])."%' ";
        }
        //逻辑：时间是范围查询
        if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
            if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                $where .= " and  so_add_time >= ".strtotime($_GPC['time']['start'])." and so_add_time <=".strtotime($_GPC['time']['end']);
            }

        }

//var_dump($_GPC);
//        var_dump($where);

        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select * from '.tablename($this->sure_order)."  where so_is_del = 1 and  we_id =".$weid.$where." order by so_add_time desc ");
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select * from '.tablename($this->sure_order)."  where so_is_del = 1 and we_id =".$weid.$where." order by so_add_time desc ".$contion;
        $info = pdo_fetchall($sql);
        break;
    case "outXlsx":
        $id = trim($_GPC['id'],",");
        $where = " ";
        //关键词类型
        $key_field = trim($_GPC['key_field']);
        //key关键词
        $key = trim($_GPC['key']);
        //配送方式
        $send_type = trim($_GPC['send_type']);
        if(!empty($send_type)){
            $where .= " and  go_send_type = ".$send_type." ";
        }
        if(!empty($key_field)){
            switch ($key_field){
                case 'order_num':
                    $where .= " and  oss_go_code like '%".$key."%' ";
                    break;
                case 'action_name':
                    $where .= " and  oss_ac_name like '%".$key."%' ";
                    break;
                case 'vg_name':
                    $where .= " and  oss_v_name like '%".$key."%' ";
                    break;
                case 'header':
                    $where .= " and  (oss_head_name like '%".$key."%' or oss_head_name like '%".base64_encode($key)."%' )";
                    break;
                case 'buyer':
                    $where .= " and  oss_buy_name like '%".$key."%' ";
                    break;
                case 'receiver':
                    $where .= " and  oss_buy_name like '%".$key."%' ";
                    break;
				case 'g_name':
                    $where .= " and  oss_g_name like '%".$key."%' ";
                    break;
				case 'sekill':
					$where .= " and  oss_is_seckill = 1";
				break;
				case 'bargain':
					$where .= " and  oss_is_seckill = 2";
				break;
            }
        }
        //逻辑：订单状态是确定查询
        $status = $_GPC['status'];
        if( isset($_GPC['status']) and !empty($_GPC['status']) ) {
            $where .= " and  go_status = '".trim($_GPC['status'])."' ";
        }
        //时间类型
        $time_type = trim($_GPC['time_type']);
        if(!empty($time_type)){
            switch ($time_type){
                case 'add_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_add_time >= ".strtotime($_GPC['time']['start'])." and go_add_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_add_time >= ".strtotime(date('Y-m-d',time()))." and go_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'pay_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_pay_time >= ".strtotime($_GPC['time']['start'])." and go_pay_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_pay_time >= ".strtotime(date('Y-m-d',time()))." and go_pay_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'send_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_send_goods_time >= ".strtotime($_GPC['time']['start'])." and go_send_goods_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_send_goods_time >= ".strtotime(date('Y-m-d',time()))." and go_send_goods_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'apply_back':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  gbm_add_time >= ".strtotime($_GPC['time']['start'])." and gbm_add_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  gbm_add_time >= ".strtotime(date('Y-m-d',time()))." and gbm_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
            }
        }

        $supplier_role = pdo_get('gpb_supplier',array('weid'=>$weid,'uid'=>$_W['uid'],'gsp_status'=>1));
        /*echo "<pre/>";
        var_dump($supplier_role);
        die;*/
        if(!empty($supplier_role)){
            $where .= " and g.g_supplier_id={$supplier_role['gsp_id']} ";
        }

        if(!empty($id)){
            $total= pdo_fetchcolumn('select count(*) from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1  ".$where." and o.weid=".$weid." and o.go_id in (".$id.") and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
            $sql = "select o.go_code,oss_buy_name,IFNULL(os.oss_address_phone,os.oss_buy_phone) AS oss_buy_phone,o.go_status,group_concat(oss_g_name separator '||') as g_name,group_concat(oss_g_price separator '||') as g_prcie,group_concat(oss_g_num separator '||') as g_num,group_concat(oss_ggo_title separator '||') as ggo_title,group_concat(oss_ggo_status separator '||') as ggo_status,sum(oss_total_price) as total,o.go_fdc_price,o.go_send_pay,o.go_real_price,oss_v_name,o.go_commission_num,o.go_commission,os.oss_head_name,os.oss_head_phone,os.oss_address_name,os.oss_address_phone,os.oss_address,o.go_comment,o.go_add_time,o.go_pay_time from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code where go_is_del = 1  and go_id in (".$id.") and weid=".$weid."  and (`type`=1 or `type` is null)group by go_code  order by go_id desc ";
            $total_money = pdo_fetch('select sum(go_real_price) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) and o.go_id in (".$id.")  group by go_code  order by go_id desc) as t");
            $back_money = pdo_fetch('select sum(oss_g_price*oss_g_num) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) and o.go_id in (".$id.") and os.oss_ggo_status =70  order by go_id desc) as t");
            $res_money  =sprintf('%01.2f',($total_money['a']-floatval($back_money['a'])));
        }else{
            if($old_op =='index'){
                $total= pdo_fetchcolumn('select count(*) from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1  ".$where." and o.weid=".$weid."  and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
                $sql = "select o.go_code,oss_buy_name,IFNULL(os.oss_address_phone,os.oss_buy_phone) AS oss_buy_phone,o.go_status,group_concat(oss_g_name separator '||') as g_name,group_concat(oss_g_price separator '||') as g_prcie,group_concat(oss_g_num separator '||') as g_num,group_concat(oss_ggo_title separator '||') as ggo_title,group_concat(oss_ggo_status separator '||') as ggo_status,sum(oss_total_price) as total,o.go_fdc_price,o.go_send_pay,o.go_real_price,oss_v_name,o.go_commission_num,o.go_commission,os.oss_head_name,os.oss_head_phone,os.oss_address_name,os.oss_address_phone,os.oss_address,o.go_comment,o.go_add_time,o.go_pay_time from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id=os.oss_gid where go_is_del = 1  and o.weid=".$weid.$where." and (o.`type`=1 or o.`type` is null) group by go_code  order by go_id desc ";


                $total_money = pdo_fetch('select sum(go_real_price) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
                $back_money = pdo_fetch('select sum(oss_g_price*oss_g_num) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) and os.oss_ggo_status =70  order by go_id desc) as t");
                $res_money  =sprintf('%01.2f',($total_money['a']-floatval($back_money['a'])));
            }elseif($old_op=='afterSale'){
                $total= pdo_fetchcolumn('select count(*) from '.tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as os on bm.gbm_oss_id = os.oss_id left join ".tablename($this->goods)." as g on g.g_id=os.oss_gid left join ".tablename($this->order)." as o on o.go_code = bm.gbm_go_code where bm.weid =".$weid.$where." order by gbm_add_time desc ");

                //$sql = "select o.go_code,oss_buy_name,os.oss_buy_phone,o.go_status,group_concat(oss_g_name separator '||') as g_name,group_concat(oss_g_price separator '||') as g_prcie,group_concat(oss_g_num separator '||') as g_num,group_concat(oss_ggo_title separator '||') as ggo_title,group_concat(oss_ggo_status separator '||') as ggo_status,sum(oss_total_price) as total,o.go_fdc_price,o.go_send_pay,o.go_real_price,oss_v_name,o.go_commission_num,o.go_commission,os.oss_head_name,os.oss_head_phone,os.oss_address_name,os.oss_address_phone,os.oss_address,o.go_buy_msg,o.go_add_time,o.go_pay_time from ".tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as os on bm.gbm_oss_id = os.oss_id left join ".tablename($this->goods)." as g on g.g_id=os.oss_gid left join ".tablename($this->order)." as o on o.go_code = bm.gbm_go_code where bm.weid =".$weid.$where." order by gbm_add_time desc ";
                $sql = "select o.go_code,oss_buy_name,os.oss_buy_phone,o.go_status,oss_g_name as g_name,oss_g_price  as g_prcie,oss_g_num  as g_num,oss_ggo_title  as ggo_title,oss_ggo_status  as ggo_status,oss_total_price as total,o.go_fdc_price,o.go_send_pay,o.go_real_price,oss_v_name,o.go_commission_num,o.go_commission,os.oss_head_name,os.oss_head_phone,os.oss_address_name,os.oss_address_phone,os.oss_address,o.go_comment,o.go_add_time,o.go_pay_time from ".tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as os on bm.gbm_oss_id = os.oss_id left join ".tablename($this->goods)." as g on g.g_id=os.oss_gid left join ".tablename($this->order)." as o on o.go_code = bm.gbm_go_code where bm.weid =".$weid.$where." order by gbm_add_time desc ";

                $res_money = pdo_fetch( "select sum(gbm_money) as sums from ".tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as ss on bm.gbm_oss_id = ss.oss_id left join ".tablename($this->goods)." as g on g.g_id=ss.oss_gid left join ".tablename($this->order)." as o on o.go_code = ss.oss_go_code  where bm.weid =".$weid.$where." and gbm_status =20 order by gbm_add_time desc ");
                $res_money = $res_money['sums'];
            }

        }
        if(!empty($_GPC['debug'])){
            echo $sql;
            die;
        }
        /*echo $sql;
        die;*/
        $res = pdo_fetchall($sql);
//		echo '<pre>';
//      var_dump($res);exit;
        $title_arr = array('订单号','购买人昵称','购买人电话','订单状态','商品名称','商品单价(元)','商品数量','商品规格','商品状态','订单原价（元）','优惠卷优惠金额（元）','邮（运）费（元）','最终售价（元）','所属小区','团长佣金比例（%）','订单分佣金额（元）','团长昵称','团长电话','收货人昵称','收货人电话','收货地址','买家备注','下单时间','付款时间');

        $str ="<tr height='40'>";
        $str .="<td>订单数：</td><td>".$total."&nbsp;</td><td>订单总价：</td><td>￥".$res_money."&nbsp;</td>";
        $str .="</tr>";
        $str .="<tr>";
        foreach ($title_arr as $k => $v){
            $str .="<td>".$v."</td>";
        }
        $str .="</tr>";
        foreach ($res as $k => $v){
            if($this->check_base64_out_json($v['oss_buy_name'])){
                $res[$k]['oss_buy_name']=$v['oss_buy_name'] = base64_decode($v['oss_buy_name']);
            }
            if($this->check_base64_out_json($v['oss_head_name'])){
                $res[$k]['oss_head_name']=$v['oss_head_name'] = base64_decode($v['oss_head_name']);
            }
            if($this->check_base64_out_json($v['oss_address_name'])){
                $res[$k]['oss_address_name']=$v['oss_address_name'] = base64_decode($v['oss_address_name']);
            }
            $v['oss_buy_name'] = filterNickname($v['oss_buy_name']);
            $v['oss_head_name'] = filterNickname($v['oss_head_name']);
            $v['oss_address_name'] = filterNickname($v['oss_address_name']);
            $g_name_arr = explode('||',$v['g_name']);
            $g_prcie_arr = explode('||',$v['g_prcie']);
            $g_num_arr = explode('||',$v['g_num']);
            $ggo_title_arr = explode('||',$v['ggo_title']);
            $ggo_status_arr = explode('||',$v['ggo_status']);
            $count =1;
            if(is_array($g_name_arr)){
                $count = count($g_name_arr);
            }
            $str .= "<tr>";
            foreach ($v as $key => $val) {
                if ($key == 'g_name' || $key == 'g_prcie' || $key == "g_num" || $key == "ggo_title" ) {
                    $val_arr = explode('||', $val);
                    $str .= "<td >" . $val_arr[0] . "&nbsp;</td>";
                }elseif ($key == 'go_add_time' || $key == 'go_pay_time' ){
                    $str .= "<td rowspan='" . $count . "'>" . (!empty($val)?date("Y-m-d H:i:s",$val):'') . "&nbsp;</td>";
                }elseif($key=="go_status" ){
                    $value ="";
                    switch ($val){
                        case "10":
                            $value ="待付款";
                            break;
                        case 20:
                            $value ="备货中";
                            break;
                        case 30:
                            $value ="待核销";
                            break;
                        case 50:
                            $value ="退款中";
                            break;
                        case 60:
                            $value ="拒绝退款";
                            break;
                        case 70:
                            $value ="已退款";
                            break;
                        case 110:
                            $value ="已取消";
                            break;
                        case 120:
                            $value ="交易关闭";
                            break;
                        case 100:
                            $value ="交易完成";
                            break;
                    }
                    $str .= "<td rowspan='" . $count . "'>" . $value . "&nbsp;</td>";
                } elseif( $key=='ggo_status'){
                    $val_arr = explode('||', $val);
                    $value ='';
                    switch ($val_arr[0]){
                        case 1:
                            $value =" ";
                            break;
                        case 40:
                            $value ="售后";
                            break;
                        case 50:
                            $value ="退款中";
                            break;
                        case 60:
                            $value ="拒绝退款";
                            break;
                        case 70:
                            $value ="已退款";
                            break;
                    }
                    $str .= "<td >" . $value . "&nbsp;</td>";
                } elseif( $key=='oss_address'){
                    if(empty($val) ||$val=='undefined'){
                        $val_adr = pdo_fetch('select m.m_head_house_address,m.m_head_address from '.tablename('gpb_member').' as m left join '.tablename('gpb_order').' as o on o.go_team_openid = m.m_openid where go_code='.$v['go_code']);
                        $str .= "<td rowspan='" . $count . "'>" . $val_adr['m_head_address'].$val_adr['m_head_house_addressfrom'] . "&nbsp;</td>";
                    }else{
                        $str .= "<td rowspan='" . $count . "'>" . $val . "&nbsp;</td>";
                    }
                } else {
                    $str .= "<td rowspan='" . $count . "'>" . $val . "&nbsp;</td>";
                }
//                        $str .="<td rowspan='".$count."'>".$val."&nbsp;</td>";
            }
            $str .= "</tr>";
            for($j = 1;$j<$count;$j++){
                //商品状态
                $goods_status = '';
                switch ($ggo_status_arr[$j]){
                    case 1:
                        $goods_status =" ";
                        break;
                    case 40:
                        $goods_status ="售后";
                        break;
                    case 50:
                        $goods_status ="退款中";
                        break;
                    case 60:
                        $goods_status ="拒绝退款";
                        break;
                    case 70:
                        $goods_status ="已退款";
                        break;
                }
                $str .="<tr>";
                $str .="<td>".$g_name_arr[$j]."&nbsp;</td><td>".$g_prcie_arr[$j]."&nbsp;</td><td>".$g_num_arr[$j]."&nbsp;</td><td>".$ggo_title_arr[$j]."&nbsp;</td><td>".$goods_status."&nbsp;</td>";
                $str .="</tr>";
            }

//            }
//            $str .="<tr>";
//            foreach ( $v as $key=>$val){
//                if($key=='g_name' || $key=='g_prcie' || $key =="g_num" ){
//                    $str .="<td >".$val."&nbsp;</td>";
//                }else{
//                    $str .="<td rowspan='".$count."'>".$val."&nbsp;</td>";
//                }
//
//            }
//            $str .="</tr>";
        }
        $filename = "订单";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
        header('Expires:0');
        header('Pragma:public');

        echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table border="1">'.$str.'</table></html>';
        exit;
        break;
    case "send":
		//团长出货单
        $where = " ";
        //关键词类型
        $key_field = trim($_GPC['key_field']);
        //key关键词
        $key = trim($_GPC['key']);
        //配送方式
        $send_type = trim($_GPC['send_type']);
        if(!empty($send_type)){
            $where .= " and  go_send_type = ".$send_type." ";
        }
		$order_print_font_size = pdo_get($this->config,array('key'=>'order_print_font_size','weid'=>$weid));
        if(!empty($key_field)){
            switch ($key_field){
                case 'order_num':
                    $where .= " and  oss_go_code like '%".$key."%' ";
                    break;
                case 'action_name':
                    $where .= " and  oss_ac_name like '%".$key."%' ";
                    break;
                case 'vg_name':
                    $where .= " and  oss_v_name like '%".$key."%' ";
                    break;
                case 'header':
                    $where .= " and  oss_head_name like '%".$key."%' ";
                    break;
                case 'buyer':
                    $where .= " and  oss_buy_name like '%".$key."%' ";
                    break;
                case 'receiver':
                    $where .= " and  oss_buy_name like '%".$key."%' ";
                case 'g_name':
                	$where .= " and  oss_g_name like '%".$key."%' ";
                break;
                case 'sekill':
					$where .= " and  oss_is_seckill = 1";
				break;
				case 'bargain':
					$where .= " and  oss_is_seckill = 2";
				break;
            }
        }
        //逻辑：订单状态是确定查询
        $status = $_GPC['status'];
        if( isset($_GPC['status']) and !empty($_GPC['status']) ) {
            $where .= " and  go_status = '".trim($_GPC['status'])."' ";
        }
        //时间类型
        $time_type = trim($_GPC['time_type']);
        if(!empty($time_type)){
            switch ($time_type){
                case 'add_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_add_time >= ".strtotime($_GPC['time']['start'])." and go_add_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_add_time >= ".strtotime(date('Y-m-d',time()))." and go_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'pay_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_pay_time >= ".strtotime($_GPC['time']['start'])." and go_pay_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_pay_time >= ".strtotime(date('Y-m-d',time()))." and go_pay_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'send_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_send_goods_time >= ".strtotime($_GPC['time']['start'])." and go_send_goods_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_send_goods_time >= ".strtotime(date('Y-m-d',time()))." and go_send_goods_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'apply_back':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  gbm_add_time >= ".strtotime($_GPC['time']['start'])." and gbm_add_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  gbm_add_time >= ".strtotime(date('Y-m-d',time()))." and gbm_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
            }
        }
        $head_note = pdo_get($this->config, array('key' => 'head_note', 'weid' => $weid));
        $head_note = isset($head_note['value']) && !empty($head_note['value'])?$head_note['value']:'备注';
        $head_title_note = pdo_get($this->config, array('key' => 'head_title_note', 'weid' => $weid));
        $head_title_note = isset($head_title_note['value']) && !empty($head_title_note['value'])?$head_title_note['value']:'社区团购出货单';
        /*echo "select oss_head_openid,oss_head_name,go_buy_msg,oss_head_phone,oss_v_name from
      (select os.oss_head_openid,os.oss_head_name,o.go_buy_msg,oss_head_phone,oss_v_name from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code where go_is_del = 1  and weid=".$weid.$where." group by go_code  order by go_id desc) as a group by oss_head_openid";
        die;*/
        $ret=pdo_fetchall("select oss_head_openid,oss_head_name,go_comment,oss_head_phone,oss_v_name from
      (select os.oss_head_openid,os.oss_head_name,o.go_comment,oss_head_phone,oss_v_name from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code where go_is_del = 1  and weid=".$weid.$where." group by go_code  order by go_id desc) as a group by oss_head_openid");
        $str="";
        foreach ($ret as $k=>$v){
//          $sql = "select o.go_code,oss_buy_name,oss_address_name,IFNULL(os.oss_address_phone,os.oss_buy_phone) as oss_buy_phone,group_concat(oss_g_name separator '||') as g_name,group_concat(oss_ggo_id separator '||') as oss_ggo_id,
//         group_concat(oss_g_num separator '||') as g_num,group_concat(oss_g_price separator '||') as g_prcie,sum(oss_total_price) as total,o.go_buy_msg from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code 
//          where go_is_del = 1  and  os.oss_head_openid='".$v['oss_head_openid']."' and weid=".$weid.$where." and (`type`=1 or `type` is null) AND (os.oss_ggo_status  = 1 OR os.oss_ggo_status  = 60) group by go_code  order by go_id desc ";
			$sql = "select o.go_code,oss_buy_name,oss_address_name,IFNULL(os.oss_address_phone,os.oss_buy_phone) as oss_buy_phone,group_concat(oss_g_name separator '||') as g_name,group_concat(oss_ggo_id separator '||') as oss_ggo_id,
           group_concat(oss_g_num separator '||') as g_num,group_concat(oss_g_price separator '||') as g_prcie,sum(oss_total_price) as total,o.go_comment from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code join ".tablename('gpb_member')." m on m.m_openid = o.openid where go_is_del = 1  and  os.oss_head_openid='".$v['oss_head_openid']."' and o.weid=".$weid.$where." and (`type`=1 or `type` is null) AND (os.oss_ggo_status  = 1 OR os.oss_ggo_status  = 60) group by go_code  order by m.m_id desc ";
			
            $total_money = pdo_fetch('select sum(go_real_price) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null )  and  os.oss_head_openid='".$v['oss_head_openid']."' group by go_code  order by go_id desc) as t");
            $back_money = pdo_fetch('select sum(oss_g_price*oss_g_num) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) and os.oss_ggo_status =70  and  os.oss_head_openid='".$v['oss_head_openid']."' order by go_id desc) as t");
            $res_money  =sprintf('%01.2f',($total_money['a']-floatval($back_money['a'])));
            $member = pdo_get('gpb_member',array('m_openid'=>$v['oss_head_openid']));
            if(!empty($v['oss_head_openid'])){
                $address = pdo_fetch("select * from ".tablename("gpb_member")." where m_head_shop_name='".$v['oss_v_name']."' and m_is_head=2 ");
            }
            $res= pdo_fetchall($sql);
            if(empty($res)){
        		continue;
        	}
            $title_arr = array('订单号','购买人昵称','购买人电话','商品名称','规格','数量','单价','订单总额','备注');
			$send_number = array('1',1,1,2,1,1,1,1,1);
            $str .="<table border='1' style='font-size:10px;'>" ;
            $str.="<tr height='50'>";
            $str .="<td colspan='10'>".$head_title_note."</td>";
            $str .="</tr>";
            $str .="<tr height='20' style='border: none'>";
            $str .="<td colspan='10'  border='0px'>导出团长出货单时间:".date('Y')."年".date('m')."月".date('d')."日".date('h')."时".date('i')."分".date('s')."秒</td>";
            $str .="</tr>";
            $str .="<tr height='30' >";
            if(empty($v['oss_head_phone'])){
                $v['oss_head_phone'] = $member['m_phone'];
            }
            if($this->check_base64_out_json($v['oss_head_name'])){
                $ret[$k]['oss_head_name'] = $v['oss_head_name'] = base64_decode($v['oss_head_name']);
            }
            $str .="<td colspan='3'>团长名称:".$v['oss_head_name']."</td><td colspan='4'>联系电话:".$v['oss_head_phone']."</td><td colspan='3'>订单总额:".$res_money."</td>";
            $str .="</tr>";
            $str .="<tr height='30' >";
            if(empty($v['oss_v_name'])){
                $v['oss_v_name'] = $member['m_head_shop_name'];
            }
            $str .="<td colspan='3'>小区:".$v['oss_v_name']."</td><td colspan='7'>收货地址:".$address['m_head_address'].$address['m_head_house_address']."</td>";
            $str .="</tr>";
            $str .="<tr height='30' >";
            foreach ($title_arr as $k => $val){
                $str .="<td colspan='".$send_number[$k]."'>".$val."</td>";
            }
            $str .="</tr>";
			$is = 0;
            foreach ($res as $k=>$vl){
            	if($vl['oss_ggo_id']){
            		//获取多规格
            		$oss_ggo_id = explode('||', $vl['oss_ggo_id']);
					if($oss_ggo_id){
						$strs = "";
						foreach($oss_ggo_id as $ks=>$vs){
							if($vs != 0){
								$info = pdo_fetch("select ggo_title from ".tablename('gpb_goods_option')." where ggo_id = ".$vs);
								$strs .= $info['ggo_title']."||";
							}else{
								$strs .= "　||";
							}
						}
						$strs = trim($strs,'||');
						$vl['oss_ggo_id'] = $strs;
					}
//          		$vl['oss_ggo_id'] = $info['ggo_title'];
            	}else{
            		$vl['oss_ggo_id'] = '';
            	}
                if($this->check_base64_out_json($vl['oss_buy_name'])){
                    $res[$k]['oss_buy_name'] = $vl['oss_buy_name'] = filterNickname(base64_decode($vl['oss_buy_name']));
                }
                if($this->check_base64_out_json($vl['oss_address_name'])){
                    $res[$k]['oss_address_name'] = $vl['oss_address_name'] = filterNickname(base64_decode($vl['oss_address_name']));
                }
                $g_name_arr = explode('||',$vl['g_name']);
                $g_prcie_arr = explode('||',$vl['g_prcie']);
                $g_num_arr = explode('||',$vl['g_num']);
				$g_oss_gid = explode('||',$vl['oss_ggo_id']);
                $count =0;
                if(is_array($g_name_arr)){
                    $count = count($g_name_arr);
                }
                $str .="<tr>";
                foreach ($vl as $key => $value) {
                    if($key == 'g_name' || $key == 'g_prcie' || $key == "g_num" || $key == 'oss_ggo_id' ){
                        $val_arr = explode('||', $value);
						if($key == 'g_name'){
							$str .= "<td colspan='".$send_number[3]."' style='font-size:".$order_print_font_size['value']."px'>" . $val_arr[0] . "</td>";
						}else{
							$str .= "<td >" . $val_arr[0] . "&nbsp;</td>";
						}
                    }elseif($key == "total"){
                        $str .= "<td rowspan='" . $count . "'>" . $value . "&nbsp;</td>";
                    }elseif($key=='oss_buy_name'){
                        if($value != $vl['oss_address_name'] && !empty($vl['oss_address_name'])){
                            $str .= "<td rowspan='" . $count . "'>" . $value ."/{$vl['oss_address_name']}" . "&nbsp;</td>";
                        }else{
                            $str .= "<td rowspan='" . $count . "'>" . $value . "&nbsp;</td>";
                        }
                    }elseif($key=='oss_address_name'){

                    }else{
                        $str .= "<td rowspan='" . $count . "' colspan='1'>" . $value . "&nbsp;</td>";
                    }
                }
                $str .="</tr>";
				//商品
                for($j = 1;$j<$count;$j++){
                    //商品状态
                    $str .="<tr>";
                    $str .="<td colspan='".$send_number[3]."' style='font-size:".$order_print_font_size['value']."px'>".$g_name_arr[$j]."</td><td>".$g_oss_gid[$j]."</td><td>".$g_num_arr[$j]."&nbsp;</td><td>".$g_prcie_arr[$j]."&nbsp;</td>";
                    $str .="</tr>";
					$is++;
                }
				$is++;
            }
			$order_print_sales = pdo_get("gpb_config",array('key'=>'order_print_sales','weid'=>$this->weid));
			if($order_print_sales['value'] == 1){
				if($is < 40){
	            	$as = 40-$is;
	            	for($i = 0;$i<$as;$i++){
	                	$str .="<tr><td colspan='10'></td></tr>";
	            	}
	            }else{
	            	$n = $is-42;
					$n = intval($n/50);
		            if($n >= 1){
		            	//还有一页的情况
		            	$item = $is-42-($n*50);
						$as = 50 - $item;
						for($i = 0;$i<$as;$i++){
		                	$str .="<tr><td colspan='10'></td></tr>";
		            	}
		            }else{
		            	//没有一页的情况了
		            	$n = $is-42;
						$as = 50 - $n;
	//	            	直接添加上去
		            	for($i = 0;$i<$as;$i++){
		                	$str .="<tr><td colspan='10'></td></tr>";
		            	}
		            }
	            }
			}
            $str .="<tr border='0' >";
            $str .="<td colspan='10' rowspan='2'  border='0'>".$head_note."</td>";
            $str .="</tr>";
        }
        $str .="</table>" ;
        $filename = "订单";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
        header('Expires:0');
        header('Pragma:public');
        echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$str.'</html>';
        exit;
        break;
    case 'print_order':
        $code = trim($_GPC['code']);
        if(empty($code)){
            echo json_encode(array('status'=>1,'msg'=>'非法操作'));exit;
        }
        //查询打印机配置
        $print_set = pdo_get($this->config,array('key'=>'print_set','weid'=>$weid));
        $config = unserialize($print_set['value']);
        if(empty($config) || count($config)<=0){
            echo json_encode(array('status'=>1,'msg'=>'请在配置中设置打印机'));exit;
        }
        //读取订单信息
        $order = pdo_fetchall("select * from ".tablename($this->order)." as o left join ".tablename($this->snapshot)." as sn on sn.oss_go_code = o.go_code left join ".tablename($this->vg)." as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=".$code." and o.weid=".$weid);
        if(empty($order)){
            echo json_encode(array('status'=>1,'msg'=>'订单数据异常'));exit;
        }
        if($order[0]['go_status'] <30 ){
            echo json_encode(array('status'=>1,'msg'=>'订单未发货，无法打印'));exit;
        }
        //调用打印机类
        $print_class = new print_sn();
        //查询打印机状态
        $res_select = $print_class->select_print($config['print_sn']);
//        var_dump($res_select);
        if( $res_select["ret"]!==0 ){
            echo json_encode(array('status'=>1,'msg'=>$res_select['msg'].','.$res_select['data']));exit;
        }
        $goods = array();
        foreach($order as $k => $v){
            $goods[$k]['title'] = $v['oss_g_name'];
            $goods[$k]['price'] = $v['oss_g_price'];
            $goods[$k]['num'] = $v['oss_g_num'];
            $goods[$k]['spec'] = trim($v['oss_ggo_title']);
        }
        $adress = $order[0]['vg_address'];
        if(!empty($order[0]['gpb_order_snapshot']) && $order[0]['gpb_order_snapshot']!='undefined'){
            $adress = $order[0]['gpb_order_snapshot'];
        }
        $leard_info =array(
            'name'=>$order[0]['oss_head_name'],
            'phone'=>$order[0]['oss_head_phone'],
        );
//        $res = $print_class->print_info($config['print_sn'],$code,$order[0]['oss_v_name'],$goods,$order[0]['vg_address'],$order[0]['oss_address_phone'],$order[0]['go_comment']='',$qrcode='',$order[0]['go_add_time'],'',$count =1);
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
        switch ($order[0]['go_send_type']){
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
        switch ($order[0]['go_pay_type']){
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
        $res = $print_class->print_info($config['print_sn'],$code,$order[0]['oss_v_name'],$goods,$adress,$order[0]['oss_address_phone'],$order[0]['oss_address_name'],$order[0]['go_real_price'],$leard_info,$order[0]['go_comment']='',$qrcode='',$order[0]['go_add_time'],'',$pay_type,$count =1,$reduce_price,$send_price,$send_type);
        if($res['ret']==0){
            echo json_encode(array('status'=>0,'msg'=>'开始打印'));exit;
        }else{
            echo json_encode(array('status'=>1,'msg'=>$res['msg'].','.$res['data']));exit;
        }
        break;
    //售后订单
    case "afterSale":
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //关键词类型
        $key_field = trim($_GPC['key_field']);
        //key关键词
        $key = trim($_GPC['key']);
        //配送方式
        $send_type = trim($_GPC['send_type']);
        if(!empty($send_type)){
            $where .= " and  go_send_type = ".$send_type." ";
        }
        if(!empty($key_field)){
            switch ($key_field){
                case 'order_num':
                    $where .= " and  oss_go_code like '%".$key."%' ";
                    break;
                case 'action_name':
                    $where .= " and  oss_ac_name like '%".$key."%' ";
                    break;
                case 'vg_name':
                    $where .= " and  oss_v_name like '%".$key."%' ";
                    break;
                case 'header':
                    $where .= " and ( oss_head_name like '%".$key."%' or oss_head_name like '%".base64_encode($key)."%') ";
                    break;
                case 'buyer':
                    $where .= " and ( oss_buy_name like '%".$key."%' or oss_buy_name like '%".base64_encode($key)."%') ";
                    break;
                case 'receiver':
                    $where .= " and ( oss_buy_name like '%".$key."%' or oss_buy_name like '%".base64_encode($key)."%') ";
                    break;
				case 'sekill':
					$where .= " and  oss_is_seckill = 1";
				break;
				case 'bargain':
					$where .= " and  oss_is_seckill = 2";
				break;
            }
        }
        //时间类型
        $time_type = trim($_GPC['time_type']);
        if(!empty($time_type)){
            switch ($time_type){
                case 'add_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_add_time >= ".strtotime($_GPC['time']['start'])." and go_add_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_add_time >= ".strtotime(date('Y-m-d',time()))." and go_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'pay_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_pay_time >= ".strtotime($_GPC['time']['start'])." and go_pay_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_pay_time >= ".strtotime(date('Y-m-d',time()))." and go_pay_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'send_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_send_goods_time >= ".strtotime($_GPC['time']['start'])." and go_send_goods_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_send_goods_time >= ".strtotime(date('Y-m-d',time()))." and go_send_goods_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'apply_back':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  gbm_add_time >= ".strtotime($_GPC['time']['start'])." and gbm_add_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  gbm_add_time >= ".strtotime(date('Y-m-d',time()))." and gbm_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;

            }

        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;


        $total= pdo_fetchcolumn('select count(*) from '.tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as ss on bm.gbm_oss_id = ss.oss_id left join ".tablename($this->goods)." as g on g.g_id=ss.oss_gid left join ".tablename($this->order)." as o on o.go_code = bm.gbm_go_code where bm.weid =".$weid.$where);
        //获取分页信息
        $page = pagination($total,$pageIndex,$pageSize);
        //2020-03-24 周龙 发现bug 未按照退款订单号归类导致可能同一个退款订单显示多条
		if($where){
			$sql = 'select m_nickname,oss_address_name,oss_buy_name,oss_head_name,go_add_time,go_code,go_id,oss_g_icon,oss_g_name,oss_g_brief,oss_g_price,oss_g_num,oss_v_name,oss_head_phone,go_status,go_pay_type,go_send_type,go_send_pay,go_fdc_price,gbm_money,oss_buy_phone,gbm_add_time,gbm_status,gbm_id,gbm_go_code from '.tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as ss on bm.gbm_oss_id = ss.oss_id left join ".tablename($this->goods)." as g on g.g_id=ss.oss_gid left join ".tablename($this->order)." as o on o.go_code = bm.gbm_go_code where bm.weid =".$weid.$where." group by bm.gbm_id order by gbm_add_time desc ".$contion;
		}else{
				$sql = "SELECT m_nickname,oss_address_name,oss_buy_name,oss_head_name,go_add_time,go_code,go_id,oss_g_icon,oss_g_name,oss_g_brief,oss_g_price,oss_g_num,oss_v_name,oss_head_phone,o_status,go_pay_type,go_send_type,go_send_pay,go_fdc_price,gbm_money,oss_buy_phone,gbm_add_time,gbm_status,gbm_id,gbm_go_code
FROM ( SELECT bm.gbm_money,bm.gbm_add_time,bm.gbm_status,bm.gbm_id,bm.gbm_oss_id,bm.gbm_go_code,bm.openid FROM ims_gpb_back_money AS bm WHERE weid = ".$weid." ORDER BY gbm_add_time DESC ".$contion.") AS bm LEFT JOIN `ims_gpb_member` AS m ON m.m_openid =bm.openid LEFT JOIN `ims_gpb_order_snapshot` AS ss ON bm.gbm_oss_id = ss.oss_id LEFT JOIN `ims_gpb_goods` AS g ON g.g_id=ss.oss_gid LEFT JOIN `ims_gpb_order` AS o ON o.go_code = bm.gbm_go_code group by bm.gbm_id ";
		}
		
        $info = pdo_fetchall($sql);
        if(is_array($info)){
            foreach ($info as &$v){
                if($this->check_base64_out_json( $v['m_nickname'] )){
                    $v['m_nickname'] = base64_decode( $v['m_nickname'] );
                }
                if($this->check_base64_out_json( $v['oss_address_name'] )){
                    $v['oss_address_name'] = base64_decode( $v['oss_address_name'] );
                }
                if($this->check_base64_out_json( $v['oss_buy_name'] )){
                    $v['oss_buy_name'] = base64_decode( $v['oss_buy_name'] );
                }
                if($this->check_base64_out_json( $v['oss_head_name'] )){
                    $v['oss_head_name'] = base64_decode( $v['oss_head_name'] );
                }
            }
        }
		
		
        $back_money = pdo_fetch( "select sum(gbm_money) as sums from ".tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as ss on bm.gbm_oss_id = ss.oss_id left join ".tablename($this->goods)." as g on g.g_id=ss.oss_gid left join ".tablename($this->order)." as o on o.go_code = ss.oss_go_code  where bm.weid =".$weid.$where." and gbm_status =20 order by gbm_add_time desc ");
        break;
    //订单设置
    case 'order_set':
        if($_GPC['submit'] == '提交'){
            //提交数据
//            var_dump($_POST);exit;
            unset($_POST['submit']);
            pdo_begin();
            foreach ($_POST as $k =>$v){
                if($k=='order_auto_get_goods_time'){
                    $sql = "update ".tablename($this->config)."  set `value` = '".serialize(array('order_auto_get_goods_time'=>$v))."',time=".time()." where `key` ='order_set' and weid=".$weid;
                }else{
                    $sql = "update ".tablename($this->config)." set `value` = '".$v."',time=".time()." where id =".$k;

                }
                $res = pdo_query($sql);
            }
            pdo_commit();
//            unset($_POST['submit']);
//            $data =serialize($_POST);
//            $sql = "update ".tablename($this->config)." set value = '".$data."',time=".time()." where status = 1 and type =7 and ".tablename($this->config).".key='order_set' and weid=".$weid;
//            $res = pdo_query($sql);
            if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('order',array('op'=>'order_set')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }

        }else{
            //自动收货天 设置
            $order_set = pdo_get($this->config,array('key'=>'order_set','weid'=>$weid));
            if(empty($order_set) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('订单设置','','7',".time().",".$weid.",1,'order_set');");
            }
            //下单超时取消订单设置
            $order_over_cancle = pdo_get($this->config,array('key'=>'order_over_cancle','weid'=>$weid));
            if(empty($order_over_cancle) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('下单超时取消订单设置(分钟数)','30','7',".time().",".$weid.",1,'order_over_cancle');");
            }
            //下单通知团长文本提示 设置
            $order_notice_title = pdo_get($this->config,array('key'=>'order_notice_title','weid'=>$weid));
            if(empty($order_notice_title) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('下单通知团长文本提示','','7',".time().",".$weid.",1,'order_notice_title');");
            }
            //启用下单通知团长分享图片类型 设置
            $order_notice_img_type = pdo_get($this->config,array('key'=>'order_notice_img_type','weid'=>$weid));
            if(empty($order_notice_img_type) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('启用下单通知团长分享图片类型','','7',".time().",".$weid.",1,'order_notice_img_type');");
            }
            //下单通知团长分享图片 设置
            $order_notice_img = pdo_get($this->config,array('key'=>'order_notice_img','weid'=>$weid));
            if(empty($order_notice_img) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('下单通知团长分享图片','','7',".time().",".$weid.",1,'order_notice_img');");
            }
            //下单通知团长分享图片 设置
            $order_notice_comment = pdo_get($this->config,array('key'=>'order_notice_comment','weid'=>$weid));
            if(empty($order_notice_comment) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('通知老板接单按钮使用说明','','7',".time().",".$weid.",1,'order_notice_comment');");
            }
            //减库存的方式 设置
            $reduce_stock_type = pdo_get($this->config,array('key'=>'reduce_stock_type','weid'=>$weid));
            if(empty($reduce_stock_type) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('减库存的方式','2','7',".time().",".$weid.",1,'reduce_stock_type');");
            }
            //下单通知团长触发方式 设置
            $order_notice_click = pdo_get($this->config,array('key'=>'order_notice_click','weid'=>$weid));
            if(empty($order_notice_click) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('下单通知团长触发方式','','7',".time().",".$weid.",1,'order_notice_click');");
            }
            //下单金额限额开关 设置
            $order_low_price_open = pdo_get($this->config,array('key'=>'order_low_price_open','weid'=>$weid));
            if(empty($order_low_price_open) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('下单金额限额开关','0','7',".time().",".$weid.",1,'order_low_price_open');");
            }
            //下单金额下限 设置
            $order_low_price = pdo_get($this->config,array('key'=>'order_low_price','weid'=>$weid));
            if(empty($order_low_price) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('下单金额下限','0','7',".time().",".$weid.",1,'order_low_price');");
            }
            //确认收货后多久不再显示申请退款 设置
            $order_no_back_day = pdo_get($this->config,array('key'=>'order_no_back_day','weid'=>$weid));
            if(empty($order_no_back_day) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('收货后多久不能申请退款','15','7',".time().",".$weid.",1,'order_no_back_day');");
            }
            //是否开启全部订单统一佣金
            $all_order_commission_open = pdo_get($this->config,array('key'=>'all_order_commission_open','weid'=>$weid));
            if(empty($all_order_commission_open) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启全部订单统一佣金','2','7',".time().",".$weid.",1,'all_order_commission_open');");
            }
            //全部订单统一佣金
            $all_order_commission_same= pdo_get($this->config,array('key'=>'all_order_commission_same','weid'=>$weid));
            if(empty($all_order_commission_same) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('全部订单统一佣金','0','7',".time().",".$weid.",1,'all_order_commission_same');");
            }
            //团长出货标头设置
            $head_title_note = pdo_get($this->config, array('key' => 'head_title_note', 'weid' => $weid));
            if (empty($head_title_note)) {
                pdo_query("INSERT  INTO " . tablename('gpb_config') . " (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('团长出货表表头信息','社区团购出货单','23'," . time() . "," . $weid . ",1,'head_title_note');");
            }
            //团长出货注释设置
            $head_note = pdo_get($this->config, array('key' => 'head_note', 'weid' => $weid));
            if (empty($head_note)) {
                pdo_query("INSERT  INTO " . tablename('gpb_config') . " (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('团长出货表注释信息','备注','24'," . time() . "," . $weid . ",1,'head_note');");
            }
            //是否显示订单详情页推荐商品
            $order_info_recommed_goods_open= pdo_get($this->config,array('key'=>'order_info_recommed_goods_open','weid'=>$weid));
            if(empty($order_info_recommed_goods_open) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否显示订单详情页推荐商品','2','7',".time().",".$weid.",1,'order_info_recommed_goods_open');");
            }
            //是否开启订单自动打印
            $order_print_auto_open= pdo_get($this->config,array('key'=>'order_print_auto_open','weid'=>$weid));
            if(empty($order_print_auto_open) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启订单自动打印','2','7',".time().",".$weid.",1,'order_print_auto_open');");
            }
            $order_print_sales = pdo_get($this->config,array('key'=>'order_print_sales','weid'=>$weid));
			if(empty($order_print_sales) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启订单打印自动填充','2','7',".time().",".$weid.",1,'order_print_sales');");
            }
            //订单自动打印份数
            $order_print_auto_num= pdo_get($this->config,array('key'=>'order_print_auto_num','weid'=>$weid));
            if(empty($order_print_auto_num) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('订单自动打印份数','1','7',".time().",".$weid.",1,'order_print_auto_num');");
            }
            //订单后台发货类型
            $order_back_send_type= pdo_get($this->config,array('key'=>'order_back_send_type','weid'=>$weid));
            if(empty($order_back_send_type) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('订单后台发货类型','1','7',".time().",".$weid.",1,'order_back_send_type');");
            }
            //订单后台直接发货是否打印小票
            $order_only_send_print_open= pdo_get($this->config,array('key'=>'order_only_send_print_open','weid'=>$weid));
            if(empty($order_only_send_print_open) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('订单后台直接发货是否打印小票','1','7',".time().",".$weid.",1,'order_only_send_print_open');");
            }
            //是否开启平台确认收货
            $is_open_manger_sure_order = pdo_get($this->config,array('key'=>'is_open_manger_sure_order','weid'=>$weid));
            if(empty($is_open_manger_sure_order) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启平台确认收货','2','7',".time().",".$weid.",1,'is_open_manger_sure_order');");
            }
            //是否开启团长确认收货
            $is_open_header_sure_order = pdo_get($this->config,array('key'=>'is_open_header_sure_order','weid'=>$weid));
            if(empty($is_open_header_sure_order) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启团长确认收货','2','7',".time().",".$weid.",1,'is_open_header_sure_order');");
            }
            //订单分享样式
			$diy_community_name = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'order_sharing_style'));
            if(empty($diy_community_name) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('订单分享样式','1','1',".time().",".$weid.",1,'order_sharing_style');");
            }
			$diy_community_name = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'order_sharing_style_show'));
            if(empty($diy_community_name) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('第二种样式是否显示上两单购买','1','1',".time().",".$weid.",1,'order_sharing_style_show');");
            }
			$order_print_font_size = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'order_print_font_size'));
            if(empty($order_print_font_size) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('订单打印商品字体大小','10','1',".time().",".$weid.",1,'order_print_font_size');");
            }
            $info = pdo_get($this->config,array('key'=>'order_set','weid'=>$weid));
            if(!empty($info['value'])){
                $info['value'] = unserialize($info['value']);
            }
			$order_sharing_style = pdo_get($this->config, array('key' => 'order_sharing_style', 'weid' => $weid));
			$order_sharing_style_show = pdo_get($this->config, array('key' => 'order_sharing_style_show', 'weid' => $weid));
            $head_note = pdo_get($this->config, array('key' => 'head_note', 'weid' => $weid));
            $head_title_note = pdo_get($this->config, array('key' => 'head_title_note', 'weid' => $weid));
            $order_notice_title = pdo_get($this->config,array('key'=>'order_notice_title','weid'=>$weid));
            $order_notice_img = pdo_get($this->config,array('key'=>'order_notice_img','weid'=>$weid));
            $order_notice_click = pdo_get($this->config,array('key'=>'order_notice_click','weid'=>$weid));
            $order_notice_comment = pdo_get($this->config,array('key'=>'order_notice_comment','weid'=>$weid));
            $order_over_cancle = pdo_get($this->config,array('key'=>'order_over_cancle','weid'=>$weid));
            $reduce_stock_type = pdo_get($this->config,array('key'=>'reduce_stock_type','weid'=>$weid));
            $order_low_price = pdo_get($this->config,array('key'=>'order_low_price','weid'=>$weid));
            $order_low_price_open = pdo_get($this->config,array('key'=>'order_low_price_open','weid'=>$weid));
            $all_order_commission_open = pdo_get($this->config,array('key'=>'all_order_commission_open','weid'=>$weid));
            $all_order_commission_same= pdo_get($this->config,array('key'=>'all_order_commission_same','weid'=>$weid));
            $order_info_recommed_goods_open= pdo_get($this->config,array('key'=>'order_info_recommed_goods_open','weid'=>$weid));
            $order_print_auto_open= pdo_get($this->config,array('key'=>'order_print_auto_open','weid'=>$weid));
            $order_print_auto_num= pdo_get($this->config,array('key'=>'order_print_auto_num','weid'=>$weid));
            $order_only_send_print_open= pdo_get($this->config,array('key'=>'order_only_send_print_open','weid'=>$weid));
            $is_open_manger_sure_order = pdo_get($this->config,array('key'=>'is_open_manger_sure_order','weid'=>$weid));
            $is_open_header_sure_order = pdo_get($this->config,array('key'=>'is_open_header_sure_order','weid'=>$weid));
            $order_print_sales = pdo_get($this->config,array('key'=>'order_print_sales','weid'=>$weid));
            $order_print_font_size = pdo_get($this->config,array('key'=>'order_print_font_size','weid'=>$weid));
        }
        break;
    case 'shipSendTpl':
        $code = trim($_GPC['code']);
        if($_GPC['submit'] == '提交'){
            $id = trim($_GPC['id']);
            $express = trim($_GPC['express']);
            $express_arr = pdo_get("gpb_express",array('id'=>$express));
            if(empty($express)){
                echo json_encode(array('status'=>1,'msg'=>'快递公司有误'));exit();
            }
            $num = trim($_GPC['num']);
            if(empty($num)){
                echo json_encode(array('status'=>1,'msg'=>'请输入快递单号'));exit();
            }
            $data=array(
                'shipping_method'=>$express_arr['id'],
                'dispatchname'=>$express_arr['name'],
                'shipping_no'=>$num,
                'express_time'=>time(),
                'go_status'=>30
            );
            $res = pdo_update($this->order,$data,array('go_id'=>$id,'weid'=>$weid));
            if(!empty($res)){
                echo json_encode(array('status'=>0,'msg'=>'快递发货成功'));exit();
            }else{
                echo json_encode(array('status'=>1,'msg'=>'快递发货失败'));exit();
            }
        }else{
            $id = trim($_GPC['id']);
            //订单
            $order = pdo_get($this->order,array("go_code"=>$code));
            //快照
            $sn = pdo_getall($this->snapshot,array("oss_go_code"=>$code));
            //查询快递
            $express = pdo_fetchall("select * from ".tablename('gpb_express')." where (weid=0 or weid=".$weid.") and is_del=1 and start=1");
			if($this->check_base64_out_json($sn[0]['oss_buy_name'] )){
                $sn[0]['oss_buy_name'] = base64_decode( $sn[0]['oss_buy_name'] );
            }
        }
        break;
    case 'all_send':
        //全部发货
//        $order_only_send_print_open= pdo_get($this->config,array('key'=>'order_only_send_print_open','weid'=>$weid));
//        $order_only_send_print_open = isset($order_only_send_print_open['value'])?$order_only_send_print_open['value']:1;
//
//        if($order_only_send_print_open==1){
        $orders = pdo_fetchall('select * from '.tablename('gpb_order').' where weid='.$weid.' and (go_send_type=1 or go_send_type=2) and  go_status=20 and `type`=1');

        if(empty($orders)){
            echo json_encode(array('status'=>1,'msg'=>'暂无订单需发货，快递发货需单独设置'));exit();
        }
        foreach ($orders as $order_info_v){
            $sms = new Sms();
            $sms->weid=$this->weid;
            $this->Tokens();
            $sn = pdo_fetchall('select oss_g_name,oss_g_num,oss_address_name,oss_address_phone from '.tablename('gpb_order_snapshot').' where   oss_go_code='.$order_info_v['go_code'].' and oss_ggo_status=1');
            $g_name_str =$sn[0]['oss_g_name'].'...';
            $g_num=0;
            foreach ($sn as $val){
//                            $g_name_str .=','.$val['oss_g_name'];
                $g_num =intval($g_num) + intval($val['oss_g_num']);
            }
            //依次为:1订单编号,2货物,3数量,4订单金额,5备注,6收货人,7收件人电话
            $sms_array=array('1'=>$order_info_v['go_code'],'2'=>trim($g_name_str,','),'3'=>$g_num,'4'=>$order_info_v['go_real_price'],'5'=>'您的货物已发货，请密切关注','6'=>$sn[0]['oss_address_name'],'7'=>$sn[0]['oss_address_phone']);
            $form_id = empty($order_info_v['prepay_id'])?$order_info_v['go_send_formid']:$order_info_v['prepay_id'];
            $dass = $sms->send_out('sms_send_order',$sms_array,$_W['account']['access_tokne'],$order_info_v['openid'],'pages/order/orderDetail?id='.$order_info_v['go_id'],$form_id,$sms->weid,'AT1122');

            //新增订阅消息 周龙 2020-02-27
            $submsg = new \SubMsg();
            $submsg_arr = [
                $order_info_v['go_code'],
                trim($g_name_str,','),
                $g_num,
                '￥'.$order_info_v['go_real_price'],
                '您的货物已发货，请密切关注'
            ];
            $submsg->sendmsg("deliver_msg",$order_info_v['openid'],$submsg_arr,'pages/order/orderDetail?id='.$order_info_v['go_id']);

            $log_content = date('Y-m-d H:i:s').'，后台订单直接发货后模版消息日志（setStatus）'.PHP_EOL;
            if(is_array($dass)){
                foreach ($dass as $dass_k=>$dass_v){
                    $log_content .='key:'.$dass_k.',value:'.$dass_v.PHP_EOL;
                }
            }
            $log_content .= json_encode(array('sms_send_order',$sms_array,$_W['account']['access_tokne'],$openid,'pages/order/orderDetail?id='.$order_info_v['go_id'],$form_id,$sms->weid,'AT1122'),JSON_UNESCAPED_UNICODE);
            $log_content .= '----------end------------'.PHP_EOL;
            $this->txt_logging_fun('sms_AT0229_log.txt',$log_content);
        }
//        }
        $sql = 'update '.tablename('gpb_order').' set go_status =30 where weid='.$weid.' and (go_send_type=1 or go_send_type=2) and  go_status=20 and `type`=1';
        $res = pdo_query($sql);

        if(empty($res)){
            echo json_encode(array('status'=>1,'msg'=>'失败'));exit();
        }else{
           //查询是否还有需要快递发货的订单
			$ship_send_count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_order')." where go_status=20 and go_send_type=3 and weid=".$this->weid." and `type`=1");
            echo json_encode(array('status'=>0,'msg'=>'成功',array('data'=>intval($ship_send_count))));exit();
        }
        break;
    case 'all_distribution':
        //全部配送
        $sql = 'update '.tablename('gpb_order').' set go_status =25 where weid='.$weid.' and (go_send_type=1 or go_send_type=2) and  go_status=20 and `type`=1';
        $res = pdo_query($sql);
        if(empty($res)){
            echo json_encode(array('status'=>1,'msg'=>'失败'));exit();
        }else{
        	//查询是否还有需要快递发货的订单
			$ship_send_count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_order')." where go_status=20 and go_send_type=3 and weid=".$this->weid." and `type`=1");
            echo json_encode(array('status'=>0,'msg'=>'成功','data'=>intval($ship_send_count)));exit();
        }
        break;
    case "out_purchase":
        //采购单
        $where = " ";
        //关键词类型
        $key_field = trim($_GPC['key_field']);
        //key关键词
        $key = trim($_GPC['key']);
        //配送方式
        $send_type = trim($_GPC['send_type']);
        if(!empty($send_type)){
            $where .= " and  go_send_type = ".$send_type." ";
        }
        if(!empty($key_field)){
            switch ($key_field){
                case 'order_num':
                    $where .= " and  oss_go_code like '%".$key."%' ";
                    break;
                case 'action_name':
                    $where .= " and  oss_ac_name like '%".$key."%' ";
                    break;
                case 'vg_name':
                    $where .= " and  oss_v_name like '%".$key."%' ";
                    break;
                case 'header':
                    $where .= " and  oss_head_name like '%".$key."%' ";
                    break;
                case 'buyer':
                    $where .= " and  oss_buy_name like '%".$key."%' ";
                    break;
                case 'receiver':
                    $where .= " and  oss_buy_name like '%".$key."%' ";
				break;
				case 'sekill':
					$where .= " and  oss_is_seckill = 1";
				break;
				case 'bargain':
					$where .= " and  oss_is_seckill = 2";
				break;
            }
        }
        //逻辑：订单状态是确定查询
        $status = $_GPC['status'];
        if( isset($_GPC['status']) and !empty($_GPC['status']) ) {
            $where .= " and  go_status = '".trim($_GPC['status'])."' ";
        }
        //时间类型
        $time_type = trim($_GPC['time_type']);
        //时间区间
        $time_zone = "";
        if(!empty($time_type)){
            switch ($time_type){
                case 'add_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_add_time >= ".strtotime($_GPC['time']['start'])." and go_add_time <=".(strtotime($_GPC['time']['end']));
                            $time_zone = "下单时间：".$_GPC['time']['start']." ~ ".$_GPC['time']['end'];
                        }else{
                            $where .= " and  go_add_time >= ".strtotime(date('Y-m-d',time()))." and go_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                            $time_zone = "下单时间：".date('Y-m-d',time())." 0:0:0 ~".date('Y-m-d',time())." 23:59:59";
                        }
                    }

                    break;
                case 'pay_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_pay_time >= ".strtotime($_GPC['time']['start'])." and go_pay_time <=".(strtotime($_GPC['time']['end']));
                            $time_zone = "支付时间：".$_GPC['time']['start']." ~ ".$_GPC['time']['end'];
                        }else{
                            $where .= " and  go_pay_time >= ".strtotime(date('Y-m-d',time()))." and go_pay_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                            $time_zone = "支付时间：".date('Y-m-d',time())." 0:0:0 ~".date('Y-m-d',time())." 23:59:59";
                        }
                    }
                    break;
                case 'send_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go_send_goods_time >= ".strtotime($_GPC['time']['start'])." and go_send_goods_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go_send_goods_time >= ".strtotime(date('Y-m-d',time()))." and go_send_goods_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'apply_back':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  gbm_add_time >= ".strtotime($_GPC['time']['start'])." and gbm_add_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  gbm_add_time >= ".strtotime(date('Y-m-d',time()))." and gbm_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
            }
        }
//        $head_note = pdo_get($this->config, array('key' => 'head_note', 'weid' => $weid));
//        $head_note = isset($head_note['value']) && !empty($head_note['value'])?$head_note['value']:'备注';
//        $head_title_note = pdo_get($this->config, array('key' => 'head_title_note', 'weid' => $weid));
//        $head_title_note = isset($head_title_note['value']) && !empty($head_title_note['value'])?$head_title_note['value']:'社区团购采购单';
    //周龙 2020-03-07 调整 分类排序 可能存在一个商品多个分类导致数量重复计算 已修复
        $head_title_note='社区团购采购单';
        $ret=pdo_fetchall("select  g.g_product_num,oss_g_name,oss_is_seckill,oss_ggo_title,sum(oss_g_num) as all_g_num,oss_g_price,sum(oss_g_num*oss_g_price) as total 
from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o   on o.go_code = os.oss_go_code 
left join ".tablename('gpb_goods')." as g on g.g_id=os.oss_gid 
join ( select goods_id,cate_id from ".tablename("gpb_goods_to_category")." where weid={$weid} group by goods_id ) as gtc on g.g_id=gtc.goods_id or gtc.goods_id is null 
where go_is_del = 1 
and (oss_ggo_status=1 or oss_ggo_status = 60)  
and o.weid=".$weid.$where." 
group by oss_gid,oss_ggo_id,oss_is_seckill 
order by gtc.cate_id asc");
        if(!empty($_GPC['debug'])){
            echo "select  g.g_product_num,oss_g_name,oss_is_seckill,oss_ggo_title,sum(oss_g_num) as all_g_num,oss_g_price,sum(oss_g_num*oss_g_price) as total 
from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o   on o.go_code = os.oss_go_code 
left join ".tablename('gpb_goods')." as g on g.g_id=os.oss_gid 
join ( select goods_id,cate_id from ".tablename("gpb_goods_to_category")." where weid={$weid} group by goods_id ) as gtc on g.g_id=gtc.goods_id or gtc.goods_id is null 
where go_is_del = 1 
and (oss_ggo_status=1 or oss_ggo_status = 60)  
and o.weid=".$weid.$where." 
group by oss_gid,oss_ggo_id,oss_is_seckill 
order by gtc.cate_id asc";
        }
        $str="";
        $title_arr = array('商品货号','商品名称','规格','价格','销量','小计（销量*价格）');

        $str .="<table border='1'>" ;
        $str .="<tr height='50'><th colspan='7'>".$head_title_note."</th></tr>" ;
        $str .="<tr><td colspan='7'>采购单生成时间：".date('Y-m-d H:i:s',time())."</td></tr>" ;
        $str .="<tr><td colspan='7'>订单下单区间：".(empty($time_zone)?'全部未发货的订单':$time_zone)."</td></tr>" ;
        $str .= "<tr><th>商品货号</th><th>商品名称</th><th>商品规格</th><th>数量合计</th><th>单价</th><th>小计（销量*价格）</th><th>备注</th></tr>";
        foreach ($ret as $k=>$vl){
            $str .="<tr>";
            foreach ($vl as $key => $value) {
                $count=1;
                if($key == "oss_is_seckill"){
//                  $value = ($value==1)?'是':'否';
//                  $str .= "<td rowspan='" . $count . "'>" . $value . "&nbsp;</td>";
                }elseif($key=="oss_g_name"){
                    //秒杀加在商品名称前面
                    $seckill_str  = "";
                    if($vl['oss_is_seckill']==1){
                        $seckill_str = "【秒杀】";
                    }
					if($vl['oss_is_seckill']==2){
                        $seckill_str = "【砍价】";
                    }
                    $str .= "<td rowspan='" . $count . "'>" . $seckill_str.$value . "&nbsp;</td>";
                }elseif($key == "total"){
                    //最后一列加一个空白给备注
                    $value =empty($value)?'':$value;
                    $str .= "<td rowspan='" . $count . "'>" . $value . "&nbsp;</td><td></td>";
                } else {
                    $value =empty($value)?'':$value;
                    $str .= "<td rowspan='" . $count . "'>" . $value . "&nbsp;</td>";
                }
            }
            $str .= "</tr>";
        }
        $all_g_num=0;
        $all_total=0;
        if(is_array($ret)){
            $all_g_num = array_sum(array_column($ret,'all_g_num'));
            $all_total = array_sum(array_column($ret,'total'));
        }
        $str .="<tr><td >总计</td><td ></td><td ></td><td >".$all_g_num."&nbsp;</td><td ></td><td >".$all_total."&nbsp;</td><td ></td></tr>" ;
        $str .="<tr><td >采购人</td><td ></td><td >采购时间</td><td ></td><td >采购确认人</td><td ></td><td ></td></tr>" ;
        $str .="</table>" ;
        if(!empty($_GPC['debug'])){
            echo $str;
            die;
        }
        $filename = "采购单";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
        header('Expires:0');
        header('Pragma:public');

        echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table  border="1">'.$str.'</table></html>';
        exit;

        break;
    case "sure_order":
        //确认收货
        $id = trim($_GPC['id'],',');
        $ids = array();
        if($_GPC['type']=='all'){
        	//全部待收货的确认收货
        	$all_order = pdo_fetchall("select * from ".tablename($this->order)." where go_status=30 and `type`=1 and weid=".$this->weid);
        	$ids = array_column($all_order,'go_code');
        }else{
        	$ids = explode(",",$id);
        }
        if(is_array($ids) && !empty($ids)){
        	pdo_begin();
        	foreach($ids as $ids_k => $ids_v){
        		//获取订单信息
        		if($_GPC['type']=='all'){
		        	//全部待收货的确认收货
		        	$info = $all_order[$ids_k];
		        }else{
		        	$info = pdo_get($this->order, array('go_code' => $ids_v, 'weid' => $this->weid, 'type' => 1));
		        }
		        if (empty($info)) {
		           continue;
		        }
		        if ($info['go_status'] != 30) {
		            continue;
		        }
		        //查找商品快照表,计算总佣金
		        $snapshot_list = pdo_fetchall("select * from " . tablename($this->snapshot) . " as sn where sn.oss_go_code =" . $info['go_code'] . " ");
		        $go_commission = 0;
		        foreach ($snapshot_list as $key => $val) {
		            $go_commission += floatval($val['oss_commission']);
		        }
		//        $team = pdo_get($this->member,array('m_openid'=>$info['go_team_openid'],"weid"=>$this->weid));
		//        $parsent = $team['m_commission']/100;//佣金比例
		//        $go_commission = $parsent*$info['go_real_price'];
		//        $go_commission_num = $parsent*100;
		        $head_price = '';
		        if ($info['go_send_type'] == 2) {
		            $head_price .= ',go_send_price_status=2';
		        }
		        $sql = "update " . tablename($this->order) . " set `go_status` = '100' , `go_commission` = '" . $go_commission . "',`go_commission_num`=0,go_commission_time=" . time() . $head_price . " where weid=" . $this->weid . " and `type`=1 and `go_id`=" . $info['go_id'];
		        $res = pdo_query($sql);
//		        $res = pdo_update($this->member, array('m_send_price_total' => (floatval($info['go_send_pay']) + floatval($user['m_send_price_total'])), 'm_money' => (floatval($user['m_money']) + floatval($info['go_send_pay']))), array('m_id' => $user['m_id']));

                //2020-04-01 周龙 配送方式为自提或者快递不给团长计算佣金
                if(intval($info['go_send_type'])===3 || intval($info['go_send_type'])===1){
                    $info['go_send_pay'] = 0;
                }

				pdo_update($this->member,array('m_send_price_total +='=>floatval($info['go_send_pay']),'m_money +='=>floatval($info['go_send_pay'])),array('m_openid' => $info['go_team_openid']));
		        //生成流水表-佣金
		        $order_snapshot = pdo_fetchall("select * from " . tablename($this->snapshot) . " where oss_go_code =" . $info['go_code']);
		        $data_stream = array(
		            'gos_code' => date('Ymd', time()) . $this->nextId(),//流水号
		            'gos_go_code' => $info['go_code'],//订单号
		            'gos_stream_type' => 3,
		            'gos_type' => 2,
		            'gos_pay_type' => 1,
		            'gos_owner' => '平台',
		            'gos_payer' => $order_snapshot[0]['oss_buy_name'],
		            'gos_team' => $order_snapshot[0]['oss_head_name'],
		            'gos_commet' => '管理员后台确认收货产生佣金',
		            'gos_order_money' => $go_commission,
		            'gos_real_money' => 0,
		            'gos_sure_pay_time' => time(),
		            'gos_status' => 1,
		            'gos_add_time' => time(),
		            'weid' => $this->weid,
		            'gos_payer_openid' => $order_snapshot[0]['oss_buy_openid'],
		            'gos_team_openid' => $order_snapshot[0]['oss_head_openid']
		        );
		        //开启自动审核佣金后
		        $auto_sure_head_commission = pdo_get($this->config, array('key' => 'auto_sure_head_commission', 'weid' => $this->weid));
		        $auto_sure_head_commission = isset($auto_sure_head_commission['value']) ? $auto_sure_head_commission['value'] : 2;
		        if ($auto_sure_head_commission == 1) {
		            $data_stream['gos_real_money'] = $go_commission;
		            $data_stream['gos_status'] = 2;
		            $data_stream['gos_commet'] = '管理员后台确认收货产生佣金,自动审核通过该佣金';
		            $data_stream['gos_sure_pay_time'] = time();
		
		            //订单佣金自动审核
		            pdo_update('gpb_order', array('go_is_cash' => 1), array('go_id' => $info['go_id']));
		            pdo_update($this->member, array('m_money +=' => $go_commission), array('m_openid' => $info['go_team_openid'], 'weid' => $this->weid));
		        }
				$i = pdo_fetch(" select * from ".tablename("gpb_order_stream")." where gos_stream_type = 3 AND gos_go_code = ".$info['go_code']);
		        if(empty($i)){
			        pdo_insert($this->stream, $data_stream);
		        }
                if(!empty(WeUtility::createModuleHook("group_buy_plugin_distribution"))) {
                    //分销佣金计算
                    $distribution = pdo_get($this->config, ['weid' => $this->weid, 'key' => 'distribution_state']);
                    if (!empty($distribution) && $distribution['value'] == 1) {
                        //存在并开启qdis
                        @require_once('../addons/group_buy_plugin_distribution/distribution.php');
                        @$new_distribution = new distribution($this->weid);
                        @$resutl = $new_distribution->usercost($info['go_code']);
//		        	@$resutl = $this->doPageDistribution_user_cost(['osn' => $info['go_code']]);
                    }
                }
		        //团长推荐分销
		        $resutl_log = $this->headcost($info['go_code']);
		        //存日志
		        $file = dirname(__FILE__) . '/headrecommedmomey.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
		        if (file_exists($file) && filesize($file) > 100000) {
		            unlink($file);//这里是直接删除，
		        }
		        $content = date('Y-m-d H:i:s');
		        $content .= "用户自己确认收货后团长算佣金,oid={$info['go_code']}\n";
		        foreach ($resutl_log as $k => $v) {
		            $content .= "{$k}={$v}\n";
		            if ($k == 'data') {
		                foreach ($resutl_log[$k] as $kk => $vv) {
		                    $content .= "{$kk}={$vv}\n";
		                }
		            }
		
		        }
		        $content .= "------\n";
		        file_put_contents($file, $content . PHP_EOL, FILE_APPEND);
        	}
        	pdo_commit();
			foreach($ids as $ids_k => $ids_v){
				$this->order_Detailed(array('order' => $ids_v));
			}
        	echo json_encode(array('status'=>0,'msg'=>'确认收货成功'));exit();
        }else{
        	echo json_encode(array('status'=>1,'msg'=>'操作有误'));exit();
        }
        break;
		case 'remake_content':
			if(empty($id)){
				echo json_encode(array('status'=>1,'msg'=>'id错误'));exit();
			}
			$res = pdo_update("gpb_order",array('remarks_content'=>$_GPC['content']),array('go_id'=>$id));
			if($res){
				echo json_encode(array('status'=>0,'msg'=>'操作成功'));exit();
			}else{
				echo json_encode(array('status'=>1,'msg'=>'操作失败'));exit();
			}
		break;
}
function filterNickname($str)

{
    $str = preg_replace_callback(
        '/./u',
        function (array $match) {
            return strlen($match[0]) >= 4 ? '' : $match[0];
        },
        $str);

    return $str;
}
include $this -> template('web/' . $do . '/' . $op);

?>