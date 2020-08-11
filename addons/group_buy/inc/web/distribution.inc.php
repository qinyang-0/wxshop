<?php
/**
 * 配送管理
 */

global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块


switch($op){
    //配送单管理列表
    case 'index':
        $name = $_GPC['name'];
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where ='';
        $num = trim($_GPC['num']);
        if(!empty($num) ){
            $where .= " and  d.dl_code like '%".$num."%' ";
        }
        $title = trim($_GPC['title']);
        if(!empty($title) ){
            $where .= " and  d.dl_shop_name like '%".$title."%' ";
        }
//        $route_check = trim($_GPC['route']);
//        if(!empty($route_check) ){
//            $where .= " and  d.dl_dr_id =".$route_check." ";
//        }
        $status = trim($_GPC['status']);
        if(!empty($status) ){
            $where .= " and  d.dl_status =".$status." ";
        }

        //逻辑：时间是范围查询
        if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
            if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                $where .= " and  dl_add_time >= ".strtotime($_GPC['time']['start'])." and dl_add_time <=".strtotime($_GPC['time']['end']);
            }else{
                $where .= " and  dl_add_time >= ".strtotime(date('Y-m-d',time()))." and dl_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
            }
        }

        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->distribution)." as d where dl_is_del = 1 and weid=".$weid.$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select d.*,r.*,m.m_nickname,m.m_phone from '.tablename($this->distribution)." as d left join ".tablename('gpb_head_route')." as hr on hr.ghr_id = d.dl_dr_id left join ".tablename($this->distribution_route)." as r on hr.ghr_rid=r.dr_id   left join ".tablename('gpb_member')." as m on m_id = hr.ghr_mid where dl_is_del = 1 and d.weid=".$weid.$where." order by dl_add_time desc,dl_id desc ".$contion;
        if($_GPC['t']==1){
            var_dump($sql);exit;
        }

        $info = pdo_fetchall($sql);
        foreach ($info as $k=>$v){
            if($this->check_base64_out_json( $v['m_nickname'] )){
                $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );
            }
        }
        $route = pdo_getall($this->distribution_route, array('weid'=>$weid,'dr_is_del'=>1));
        break;
    //生成配送单表单提交
    case 'add':
//		if($_GPC['submit'] == '提交'){
//			//提交数据
//			$rid = trim($_GPC['rid']);
//            $vid = trim($_GPC['vid']);
//            if(empty($rid) ){
//                $this->message_info('配送路线错误');exit;
//            }
//            $code = trim($_GPC['code']);
//            if(empty($code) ){
//                $this->message_info('订单信息错误');exit;
//            }
//            $hr =pdo_get('gpb_head_route',array('weid'=>$weid,'ghr_rid'=>$rid));
//            if(empty($hr)){
//                $this->message_info('配送路线查询失败');exit;
//            }
//		    $village =  pdo_get($this->vg,array('vg_id'=>$vid,'weid'=>$weid));
//            if(empty($village)){
//                $this->message_info('配送小区查询失败');exit;
//            }
//            $sn = pdo_getall($this->snapshot,['oss_go_code'=>$code]);
//            if(empty($sn)){
//                $this->message_info('订单信息读取错误');exit;
//            }
//			$data = [
//                'dl_shop_name'=>$village['vg_team_name'],
//                'dl_shop_address'=>$village['vg_address'],
//                'dl_dr_id'=>$hr['ghr_id'],
//                'dl_add_time'=>time(),
//                'dl_status'=>10,
//                'dl_goods_num'=>count($sn),
//                'weid'=>$weid,
//                'dl_code'=>$this->nextId(),
//                'dl_go_code'=>$code
//			];
//
//            $res = pdo_insert($this->distribution,$data);
//			if(empty($res)){
//                $this->message_info('操作失败');
//			}else{
//                $this->message_info('操作成功', $this->createWebUrl('distribution'), 'success');
//			}
//		}else{
//			if($id){
//				$sn = pdo_getall($this->snapshot,['oss_go_code'=>$id]);
//				$vid = pdo_get('gpb_head_route',array('ghr_vid'=>$sn[0]['oss_v_id'],'weid'=>$weid));
//				$send = pdo_get($this->distribution_route,array('dr_id'=>$vid['ghr_rid'],'weid'=>$weid));
//			}else{
//                $this->message_info('参数异常');
//            }
//		}
        break;
    //路线列表页
    case 'route':
        $title = trim($_GPC['title']);
        $people = trim($_GPC['people']);
        $phone = trim($_GPC['phone']);
        $where = "";
        if(!empty($title)){
            $where .= " and dr_name like '%".$title."%' ";
        }
        if(!empty($people)){
            $where .= " and dr_people like '%".$people."%' ";
        }
        if(!empty($phone)){
            $where .= " and dr_phone like '%".$phone."%' ";
        }

        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        //逻辑：广告名称是模糊查询
        if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
            $where .= " and  ban_name like '%".trim($_GPC['name'])."%' ";
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->distribution_route)." where dr_is_del = 1 and weid=".$weid.$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select * from '.tablename($this->distribution_route)." where dr_is_del = 1 and weid=".$weid.$where." order by dr_order asc,dr_add_time desc ".$contion;
        $info = pdo_fetchall($sql);
        foreach ($info as $k => $v){
            $val = pdo_getall("gpb_head_route",array('ghr_rid'=>$v['dr_id']));
            $link_v = array_column($val, 'ghr_vid');
            $info[$k]['dr_link_head']=implode(',',$link_v);
            $info[$k]['dr_num']=count($link_v);
        }
        $deafalt =  pdo_get('gpb_distribution_route',array('dr_id'=>-1));
        if(empty($deafalt)){
            pdo_insert('gpb_distribution_route',array('dr_id'=>-1,'dr_name'=>'系统默认路线','dr_people'=>'系统默认配送员','weid'=>0,'dr_num'=>0));
            $deafalt =  pdo_get('gpb_distribution_route',array('dr_id'=>-1));
        }
        break;
    //路线新增编辑页
    case "routeAdd":
        if($_GPC['submit'] == '提交'){
//            var_dump($_GPC);exit;
            //提交数据
            $name = trim($_GPC['name']);
            $people = trim($_GPC['people']);
            $phone = trim($_GPC['phone']);
            $link_head = trim($_GPC['link_head'],',');

            if(empty($name) ){
                $this->message_info('请填写路线名称');exit;
            }
            if( empty($people)){
                $this->message_info('请填写配送员');exit;
            }
            if( empty($phone)){
                $this->message_info('请填写电话');exit;
            }
            if( empty($link_head)){
                $this->message_info('请选择该路线上的小区');exit;
            }
            $link_head_arr = explode(',',$link_head);
//            var_dump($is_show);exit;
            $data = [
                'dr_name'=>$name,
                'dr_people'=>$people,
                'dr_phone'=>$phone,
//                'dr_link_head'=>$link_head,
                'dr_num'=>count($link_head_arr),
                'weid'=>$weid
            ];
            if($id){
                $data['dr_update_time'] = time();
                $res = pdo_update($this->distribution_route,$data,['dr_id'=>$id]);
            }else{
                $data['dr_add_time'] = time();
                $res = pdo_insert($this->distribution_route,$data);
                $id = pdo_insertid();
            }
            if(empty($res)){
                $this->message_info('操作失败');
            }else{
                foreach ($link_head_arr as $v){
                    $link = pdo_get('gpb_head_route',array('weid'=>$weid,'ghr_mid'=>$v));
                    if(empty($link)){
                        pdo_insert("gpb_head_route",array('weid'=>$weid,'ghr_mid'=>$v,'ghr_rid'=>$id));
                    }else{
                        pdo_update("gpb_head_route",array('ghr_rid'=>$id),array('weid'=>$weid,'ghr_mid'=>$v));
                    }
                }
                $this->message_info('操作成功', $this->createWebUrl('distribution',array('op'=>'route')), 'success');
            }
        }else{
            $act_title ="新增";
            if($id){
                $act_title ="修改";
                $info = pdo_get($this->distribution_route,['dr_id'=>$id]);
                $v = pdo_getall("gpb_head_route",array('ghr_rid'=>$id));
                $link_v = array_column($v, 'ghr_mid');
                $info['dr_link_head']=implode(',',$link_v);
                $info['dr_num']=count($link_v);
            }
        }
        break;
    //异步获取团长小区列表
    case 'getHeadVillage':
        if($_GPC['action']=='getHeadVillage'){
            $index=isset($_GPC['page'])?$_GPC['page']:1;
            $pageIndex = $index;
            $pageSize = 10;
            $where = "";

//            if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
//                $where .= " and  g.g_name like '%".trim($_GPC['title'])."%' ";
//            }
//            if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
//                $where .= " and  g.g_product_num like '%".trim($_GPC['num'])."%' ";
//            }
//            if(isset($_GPC['action']) && !empty($_GPC['action']) ) {
//                $where .= " and  a.at_name like '%".trim($_GPC['action'])."%' ";
//            }
            $old = trim($_GPC['old'],',');
            $old_arr=array();
            $num = 0;
            if(!empty($old)){
                $old_arr = explode(',',$old);
                $num = count($old_arr);
            }

            $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
            $sql_count =  "select count(*) from ".tablename($this->member)." as m left join ".tablename($this->vg)." as vg on vg.openid = m.m_openid where m.weid=".$weid." and vg_status=1 and m.m_is_head=2 and m_status =1 ";
            $sql =  "select * from ".tablename($this->member)." as m left join ".tablename($this->vg)." as vg on vg.openid = m.m_openid  where m.weid=".$weid." and vg_status=1 and m.m_is_head=2 and m_status =1 order by m_add_time desc ".$contion;
            $info  = pdo_fetchall($sql);
            $total= pdo_fetchcolumn($sql_count);
            $page = pagination($total,$pageIndex,$pageSize);
            if(!empty($info)){
                $str = "";
                foreach ($info as $k=> $v){
                    if($this->check_base64_out_json( $v['m_nickname'] )){
                        $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );
                        $v['m_nickname']=$info[$k]['m_nickname'] ;
                    }
                    $btn= '';
//                    if(in_array($v['vg_id'],$old_arr)){
//                        $btn = "<td><span class='btn btn-warning btn-xs content-del' data-content='".$v['vg_id']."' data-index='".$pageIndex."'>删除</span></td>";
//                    }else{
//                        $btn =  "<td><span class='btn btn-info btn-xs content-checked' data-content='".$v['vg_id']."' data-index='".$pageIndex."'>选取</span></td>";
//                    }
                    if(in_array($v['m_id'],$old_arr)){
                        $btn = "<td><span class='btn btn-warning btn-xs content-del' data-content='".$v['m_id']."' data-index='".$pageIndex."'>删除</span></td>";
                    }else{
                        $btn =  "<td><span class='btn btn-info btn-xs content-checked' data-content='".$v['m_id']."' data-index='".$pageIndex."'>选取</span></td>";
                    }
                    $str .="<tr><td>".$v['m_head_shop_name']."</td><td>".$v['m_name']."</td><td>".$v['m_phone']."</td>".$btn."</tr>";
                }
                echo json_encode(['status'=>0,'msg'=>'查询成功','data'=>$str,'page'=>$page,'sql1'=>$sql,'num'=>$num]);exit;
            }else{
                $str = "<tr><td colspan='999'>无相关数据</td></tr>";
                echo json_encode(['status'=>1,'msg'=>'暂无数据','data'=>$str,'page'=>$page,'sql'=>$sql]);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入','data'=>$str,'page'=>$page,'sql1'=>$sql,'sql2'=>$sql_count]);exit;
        }
        break;
    //异步路线删除
    case 'routeDel':
        if($id){
            $res = pdo_update($this->distribution_route,['dr_is_del'=>-1],['dr_id'=>$id,'weid'=>$weid]);
            if($res){
                echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
    //等待发货列表页
    case "wait":
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $title = trim($_GPC['title']);
        $where= "";
        //时间类型
        $time_type = trim($_GPC['time_type']);
        if(!empty($time_type)){
            switch ($time_type){
                case 'add_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go.go_add_time >= ".strtotime($_GPC['time']['start'])." and go.go_add_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go.go_add_time >= ".strtotime(date('Y-m-d',time()))." and go.go_add_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
                case 'pay_time':
                    if( isset($_GPC['time']) and !empty($_GPC['time'])  ) {
                        if( !($_GPC['time']['start'] == date('Y-m-d',time()) and $_GPC['time']['end'] == date('Y-m-d',time())) ){
                            $where .= " and  go.go_pay_time >= ".strtotime($_GPC['time']['start'])." and go.go_pay_time <=".(strtotime($_GPC['time']['end']));
                        }else{
                            $where .= " and  go.sgo_pay_time >= ".strtotime(date('Y-m-d',time()))." and go.go_pay_time <=".(strtotime(date('Y-m-d',time()))+24*60*60);
                        }
                    }
                    break;
            }
        }
//        if(!empty($title)){
//            $where .= " and (os.oss_v_name like '%".$title."%' or os.oss_head_name like '%".$title."%') ";
//        }

//        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
//        $total= pdo_fetchcolumn('select count(*) from (select *  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code   where go_status = 20 and go_is_del = 1  ".$where." and weid=".$weid." group by go_code  order by go_id desc) as t");
//        $page = pagination($total,$pageIndex,$pageSize);
//        //获取分页信息
//        $sql = 'select *,count(oss_id) as total from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->distribution)." as dl on dl.dl_go_code = o.go_code where dl.dl_status is null and go_status = 20 and go_is_del = 1   and o.weid=".$weid.$where." group by go_code  order by go_id desc ".$contion;
//        $info = pdo_fetchall($sql);
//        var_dump($sql);
        //
        $sql = 'select m.m_id,m.m_openid,m.m_nickname,m.m_photo,m.m_phone,m.m_head_shop_name,sum(o.oss_g_num) as num  from '.tablename('gpb_order_snapshot').' as o  join '.tablename('gpb_member').' as m on m.m_openid=o.oss_head_openid join '.tablename('gpb_order').' as go on go.go_code=o.oss_go_code where 1 and go.weid='.$this->weid.$where.' and go.go_status =25 and o.oss_ggo_status=1 group by m_openid';
//        var_dump($sql);exit;
        $info = pdo_fetchall($sql);
        foreach ($info  as  &$v){
            if($this->check_base64_out_json( $v['m_nickname'] )){
                $v['m_nickname'] = base64_decode( $v['m_nickname'] );
            }
            $vg = pdo_get('gpb_village',array('openid'=>$v['m_openid']));
            $route = pdo_fetch('select dr_name,dr_id from '.tablename('gpb_distribution_route').' as dr join '.tablename('gpb_head_route').' as hr on hr.ghr_rid=dr.dr_id where ghr_vid='.$vg['vg_id']);
            if(empty($route)){
                //说明该小区还没配送路线
                //就新增配送系统默认配送
                $rout = pdo_get('gpb_distribution_route',array('dr_id'=>-1));
                if(empty($rout)){
                    pdo_insert('gpb_distribution_route',array('dr_id'=>-1,'dr_name'=>'系统默认路线','dr_people'=>'系统默认配送员','weid'=>0,'dr_num'=>0));
                }
                pdo_insert('gpb_head_route',array('ghr_vid'=>$vg['vg_id'],'ghr_mid'=>$v['m_id'],'ghr_rid'=>-1,'weid'=>$this->weid));
                $v['send_route'] = '系统默认路线';
            }else{
                $v['send_route'] = $route['dr_name'];
            }
            unset( $v );
        }

//        var_dump($info);var_dump($sql);exit;
        break;
    //配送单详情页
    case 'info':
        if($id){
            $info = pdo_get($this->distribution,array('dl_id'=>$id,'weid'=>$weid));
            $sn = pdo_getall($this->snapshot,['oss_go_code'=>$info['dl_go_code']]);
            $vid = pdo_get('gpb_head_route',array('ghr_vid'=>$sn[0]['oss_v_id'],'weid'=>$weid));
            $send = pdo_get($this->distribution_route,array('dr_id'=>$vid['ghr_rid'],'weid'=>$weid));
        }else{
            $this->message_info('参数异常');
        }
        break;
    //触发配送
    case 'sureSend':
        $id = trim($id,',');
        $id_arr = explode(',',$id);
        $type = trim($_GPC['type'],',');
        if($id){

            foreach ($id_arr as $val){
                $dl = pdo_get($this->distribution,array('weid'=>$weid,'dl_id'=>$val));
                if( empty($dl) || $dl['dl_status']==20  ){
                    continue;
                }
                $orders = pdo_getall('gpb_distribution_list_order',array('l_id'=>$val));
                $orders_str= '';
                if(!empty($orders)){
                    $orders_array = array_column($orders,'go_code');
                    $orders_str = implode(',',$orders_array);

                }
                //兼容之前的存订单方式
                if(empty($orders_str)){
                    $orders_str = $dl['dl_go_code'];
                    $orders_array = array($dl['dl_go_code']);
                }

                $res = pdo_update($this->distribution,array('dl_status'=>20,'dl_send_time'=>time()),array('weid'=>$weid,'dl_id'=>$val));
                if(empty($res)){
                    echo json_encode(['status'=>1,'msg'=>'配送失败，请重试']);exit;
                }else{
                    if($type==1){
                        $des ='配送成功，开始打印小票' ;
                    }else{
                        $des ='配送成功' ;
                    }
                    foreach ($orders_array as $orders_array_val){
                        $res_order = pdo_update($this->order,array('go_status'=>30,'go_send_goods_time'=>time()),array('weid'=>$weid,'go_code'=>$orders_array_val));
                        if(empty($res_order)){
                            continue;
                        }
                        $order = pdo_fetchall("select o.*,sn.*,vg.vg_address from ".tablename($this->order)." as o left join ".tablename($this->snapshot)." as sn on sn.oss_go_code = o.go_code left join ".tablename($this->vg)." as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=".$orders_array_val." and o.weid=".$weid);
                        if($type==1){
                            //打印出票
                            //查询打印机配置
                            $print_set = pdo_get($this->config,array('key'=>'print_set','weid'=>$weid));
                            $config = unserialize($print_set['value']);
                            if(empty($config) || count($config)<=0){
                                echo json_encode(array('status'=>1,'msg'=>'请在配置中设置打印机'));exit;
                            }
                            //调用打印机类
                            $print_class = new print_sn();
                            //查询打印机状态
                            $res_select = $print_class->select_print($config['print_sn']);
                            if( $res_select["ret"]!==0 || $res_select["data"]=='离线。'){
                                $res = pdo_update($this->distribution,array('dl_status'=>10,'dl_send_time'=>time()),array('weid'=>$weid,'dl_id'=>$val));
//                                pdo_rollback();
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
                            if(!empty($order[0]['oss_address']) && $order[0]['oss_address']!='undefined'){
                                $adress = $order[0]['oss_address'];
                            }
                            $leard_info =array(
                                'name'=>$order[0]['oss_head_name'],
                                'phone'=>$order[0]['oss_head_phone'],
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
                            $res = $print_class->print_info($config['print_sn'],$orders_array_val,$order[0]['oss_v_name'],$goods,$adress,$order[0]['oss_address_phone'],$order[0]['oss_address_name'],$order[0]['go_real_price'],$leard_info,$order[0]['go_comment']='',$qrcode='',$order[0]['go_add_time'],'',$pay_type,$count =1,$reduce_price,$send_price,$send_type);
//                            var_dump($order);var_dump($goods);var_dump($res);exit;
//                var_dump($res);
                            if($res['ret']==0){

                            }else{
                                continue;
                            }
//                            $order_info_v = pdo_get('gpb_order',array('go_code'=>$v));

                        }

                        $sms = new Sms();
                        $sms->weid=$this->weid;
                        $this->Tokens();
//                            $sn = pdo_fetchall('select oss_g_name,oss_g_num,oss_address_name,oss_address_phone from '.tablename('gpb_order_snapshot').' where '.$order_info_v['go_code'].' and oss_ggo_status=1');
                        $g_name_str =$order[0]['oss_g_name'].'...';
                        $g_num=0;
                        foreach ($order as $val){
//                                $g_name_str .=','.$val['oss_g_name'];
                            $g_num =intval($g_num) + intval($val['oss_g_num']);
                        }
                        //依次为:1订单编号,2货物,3数量,4订单金额,5备注,6收货人,7收件人电话
                        $sms_array=array('1'=>$order[0]['go_code'],'2'=>trim($g_name_str,','),'3'=>$g_num,'4'=>$order[0]['go_real_price'],'5'=>'您的货物已发货，请密切关注','6'=>$order[0]['oss_address_name'],'7'=>$order[0]['oss_address_phone']);

                        $form_id = empty($order[0]['prepay_id'])?$order[0]['go_send_formid']:$order[0]['prepay_id'];
                        $dass = $sms->send_out('sms_send_order',$sms_array,$_W['account']['access_tokne'],$order[0]['openid'],'pages/order/orderDetail?id='.$order[0]['go_id'],$form_id,$sms->weid,'AT1122');

                        //新增订阅消息 周龙 2020-02-27
                        $submsg = new \SubMsg();
                        $submsg_arr = [
                            $order[0]['go_code'],
                            trim($g_name_str,','),
                            $g_num,
                            $order[0]['go_real_price'],
                            '您的货物已发货，请密切关注'
                        ];
                        $submsg->sendmsg("deliver_msg",$order[0]['openid'],$submsg_arr);

                        $log_content = date('Y-m-d H:i:s').'，后台配送后发货后模版消息日志（sureSend）'.PHP_EOL;
                        if(is_array($dass)){
                            foreach ($dass as $dass_k=>$dass_v){
                                $log_content .='key:'.$dass_k.',value:'.$dass_v.PHP_EOL;
                            }
                        }
                        $log_content .= json_encode(array('sms_send_order',$sms_array,$_W['account']['access_tokne'],$order[0]['openid'],'pages/order/orderDetail?id='.$order[0]['go_id'],$form_id,$sms->weid,'AT1122'),JSON_UNESCAPED_UNICODE);
                        $log_content .= '----------end------------'.PHP_EOL;
                        $this->txt_logging_fun('sms_AT1122_log.txt',$log_content);

                    }

                }
                $this->distribution_success_send_official_account_msg($dl['dl_id']);
            }
            echo json_encode(['status'=>0,'msg'=>$des]);exit;
        }else{
            echo json_encode(['status'=>1,'msg'=>'参数异常']);exit;
        }
        break;
    //按商品导出xls
    case 'downBuyGoods':
        if($id){
            $id = trim($id,',');
            if(empty($id)){
                $this->message_info('参数异常');
            }
            $info = pdo_fetchall("select group_concat(oss_g_name separator '||') as g_name,group_concat(oss_g_price separator '||') as g_price,group_concat(oss_ggo_title separator '||') as ggo_title,group_concat(oss_g_num separator '||') as g_num,dl_shop_name from ".tablename($this->snapshot)." as os left  join ".tablename($this->distribution)." as d on d.dl_go_code = os.oss_go_code  left join ".tablename($this->goods_option)." as ggo on ggo.ggo_id = os.oss_ggo_id where dl_id in (".$id.") and d.weid=".$weid." group by dl_go_code");
            $str ="<tr><th colspan='5' align='center'  style='font-size: 28px;'>商品明细表</th></tr>
                    <tr>
                    <th width='250'>商品名称</th>
                    <th width='120'>价格</th>
                    <th width='120'>规格</th>
                    <th width='80'>数量</th>
                    <th width='200'>团长小区/店铺</th>
                    </tr>
            ";
            foreach ($info as $k => $v) {
                $g_name_arr = explode('||', $v['g_name']);
                $g_num_arr = explode('||', $v['g_num']);
                $ggo_title_arr = explode('||', $v['ggo_title']);
                $g_price_arr = explode('||', $v['g_price']);
                $count = 1;
                if (is_array($g_name_arr)) {
                    $count = count($g_name_arr);
                }
                $str .= "<tr>";
                foreach ($v as $key => $val) {
                    if ($key == 'g_name' || $key == "g_num" || $key == 'ggo_title' || $key == "g_price") {
                        $val_arr = explode('||', $val);
                        $str .= "<td >" . $val_arr[0] . "&nbsp;</td>";
                    } else {
                        $str .= "<td rowspan='" . $count . "'>" . $val . "&nbsp;</td>";
                    }
                }
                $str .= "</tr>";
                for ($j = 1; $j < $count; $j++) {
                    $str .= "<tr>";
                    $str .= "<td>" . $g_name_arr[$j] . "&nbsp;</td><td>" . $g_price_arr[$j] . "&nbsp;</td><td>" . $ggo_title_arr[$j] . "&nbsp;</td><td>" . $g_num_arr[$j] . "&nbsp;</td>";
                    $str .= "</tr>";
                }
            }
            $filename = "配送单商品";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
            header('Expires:0');
            header('Pragma:public');

            echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table border="1">'.$str.'</table></html>';
            exit;
        }else{
            $this->message_info('参数异常');
        }
        break;
    //按店铺/小区导出xls
    case 'downBuyVg':
        if($id){
            $id = trim($id,',');
            if(empty($id)){
                $this->message_info('参数异常');
            }
            $info = pdo_fetchall("select group_concat(oss_g_name separator '||') as g_name,group_concat(oss_g_num separator '||') as g_num,group_concat(oss_ggo_title separator '||') as ggo_title,os.*,d.*,dr.*,vg.*  from ".tablename($this->snapshot)." as os left  join ".tablename($this->distribution)." as d on d.dl_go_code = os.oss_go_code left join ".tablename($this->distribution_route)." as dr on dr.dr_id=d.dl_dr_id left join ".tablename($this->vg)." as vg on os.oss_v_id = vg.vg_id left join ".tablename($this->goods_option)." as go on go.ggo_id = os.oss_ggo_id where dl_id in (".$id.") and d.weid=".$weid." group by dl_go_code");
            $str='';
            foreach ($info as $k => $v) {
                $g_name_arr = explode('||', $v['g_name']);
                $g_num_arr = explode('||', $v['g_num']);
                $ggo_title_arr = explode('||', $v['ggo_title']);
                $send_time = empty($v['dl_send_time'])?'':date('Y-m-d H:i:s',$v['dl_send_time']);
                $str .="<tr><th colspan='3' align='center'  style='font-size: 28px;'>".$v['dl_shop_name']."</th></tr>
  <tr><td colspan='3' >团长：".$v['oss_head_name']."&nbsp;&nbsp;提货地址：".$v['vg_address']."&nbsp;&nbsp;联系电话：".$v['oss_head_phone']."</td></tr>
  <tr><td colspan='3' >配送单：".$v['dl_code']."&nbsp;&nbsp;配送时间：".$send_time."</td></tr>
  <tr><td colspan='3' >配送路线：".$v['dr_name']."&nbsp;&nbsp;配送员：".$v['dr_people']."&nbsp;&nbsp;联系电话：".$v['dr_phone']."</td></tr>
                    <tr>
                    <th width='500'>商品名称</th>
                    <th width='150'>数量</th>
                    <th width='150'>规格</th>
                    </tr>
            ";
                foreach ($g_name_arr as $key =>$val){
                    $str .="<tr><td>".$val."</td><td>".$g_num_arr[$key]."</td><td>".$ggo_title_arr[$key]."</td></tr>";
                }
                $str .="<tr><td></td><td></td></tr>";
            }
//            var_dump($str);exit;
            $filename = "配送单-店铺";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
            header('Expires:0');
            header('Pragma:public');

            echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table border="1">'.$str.'</table></html>';
            exit;
        }else{
            $this->message_info('参数异常');
        }
        break;
    //按订单导出xls
    case 'downBuyOrder':
        if($id){
            $id = trim($id,',');
            if(empty($id)){
                $this->message_info('参数异常');
            }
            $info = pdo_fetchall("select group_concat(oss_g_name separator '||') as g_name,group_concat(oss_g_num separator '||') as g_num,group_concat(oss_ggo_title separator '||') as ggo_title,os.*,d.*,dr.*,vg.*  from ".tablename($this->snapshot)." as os left  join ".tablename($this->distribution)." as d on d.dl_go_code = os.oss_go_code left join ".tablename($this->distribution_route)." as dr on dr.dr_id=d.dl_dr_id left join ".tablename($this->vg)." as vg on os.oss_v_id = vg.vg_id left join ".tablename($this->goods_option)." as go on go.ggo_id = os.oss_ggo_id where dl_id in (".$id.") and d.weid=".$weid." group by dl_go_code");
            $str='';
            foreach ($info as $k => $v) {
                $g_name_arr = explode('||', $v['g_name']);
                $g_num_arr = explode('||', $v['g_num']);
                $ggo_title_arr = explode('||', $v['ggo_title']);
                $send_time = empty($v['dl_send_time'])?'':date('Y-m-d H:i:s',$v['dl_send_time']);
                $str .="<tr><th colspan='5' align='center'  style='font-size: 28px;'>".$v['dl_shop_name']."消费者订单</th></tr>
  <tr><td colspan='5' >团长：".$v['oss_head_name']."&nbsp;&nbsp;提货地址：".$v['vg_address']."&nbsp;&nbsp;联系电话：".$v['oss_head_phone']."</td></tr>
  <tr><td colspan='5' >配送单：".$v['dl_code']."&nbsp;&nbsp;配送时间：".$send_time."</td></tr>
  <tr><td colspan='5' >配送路线：".$v['dr_name']."&nbsp;&nbsp;配送员：".$v['dr_people']."&nbsp;&nbsp;联系电话：".$v['dr_phone']."</td></tr>
                    <tr>
                    <th width='100'>收货人</th>
                    <th width='100'>手机号</th>
                    <th width='300'>商品名称</th>
                    <th width='150'>数量</th>
                    <th width='150'>规格</th>
                    </tr>
            ";
                foreach ($g_name_arr as $key =>$val){
                    $str .="<tr><td>".$v['oss_buy_name']."</td><td>".$v['oss_buy_phone']."</td><td>".$val."</td><td>".$g_num_arr[$key]."</td><td>".$ggo_title_arr[$key]."</td></tr>";
                }
                $str .="<tr><td></td><td></td></tr>";
            }
//            var_dump($str);exit;
            $filename = "配送单-收货人";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
            header('Expires:0');
            header('Pragma:public');

            echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table border="1">'.$str.'</table></html>';
            exit;
        }else{
            $this->message_info('参数异常');
        }
        break;
    case 'see_goods_info':
        $type = trim($_GPC['type']);
        $info =array();
        if(empty($type)){
            $m_id = trim($_GPC['m_id'],',');
            if(empty($m_id)){

            }else{
                $sql = 'select sum(o.oss_g_num) as num,g.g_name,g.g_icon,o.oss_ggo_title  from '.tablename('gpb_order_snapshot').' as o  join '.tablename('gpb_member').' as m on m.m_openid=o.oss_head_openid join '.tablename('gpb_order').' as go on go.go_code=o.oss_go_code left join '.tablename('gpb_goods').' as g on g.g_id=o.oss_gid where 1 and go.weid='.$this->weid.' and go.go_status =25 and o.oss_ggo_status=1 and m.m_id='.$m_id.' group by g.g_id,o.oss_ggo_id';
                $info = pdo_fetchall($sql);
            }
        }elseif($type==2){
            $lid = trim($_GPC['lid'],',');
            $orders = pdo_getall('gpb_distribution_list_order',array('l_id'=>$lid));
            if(!empty($orders)){
                $orders_array = array_column($orders,'go_id');

                $orders_str = implode(',',$orders_array);
                if(!empty($orders_str)){
                    $sql = 'select sum(o.oss_g_num) as num,g.g_name,g.g_icon,o.oss_ggo_title  from '.tablename('gpb_order_snapshot').' as o  join '.tablename('gpb_member').' as m on m.m_openid=o.oss_head_openid join '.tablename('gpb_order').' as go on go.go_code=o.oss_go_code left join '.tablename('gpb_goods').' as g on g.g_id=o.oss_gid where 1 and go.weid='.$this->weid.' and o.oss_ggo_status=1 and go.go_id in('.$orders_str.')  group by g.g_id,o.oss_ggo_id';
                    $info = pdo_fetchall($sql);
                }
//                var_dump($orders_array); var_dump($orders);exit;
            }
        }
        break;
    case 'add_list':
        $ids = trim($_GPC['id'],',');
        if(empty($ids)){
            echo json_encode(['status'=>1,'msg'=>'未选择清单']);exit;
        }
        $ids_arr = explode(',',$ids);

        pdo_begin();
        foreach ($ids_arr as $v){
            $sql = 'select sum(o.oss_g_num) as num,go.go_code,go.go_id,m.m_head_address,m.m_head_house_address,go.go_team_openid from '.tablename('gpb_order_snapshot').' as o  join '.tablename('gpb_member').' as m on m.m_openid=o.oss_head_openid join '.tablename('gpb_order').' as go on go.go_code=o.oss_go_code left join '.tablename('gpb_goods').' as g on g.g_id=o.oss_gid where 1 and go.weid='.$this->weid.' and go.go_status =25 and o.oss_ggo_status=1 and m.m_id='.$v.' group by go.go_code';
//            var_dump($sql);exit;
            $info = pdo_fetchall($sql);

            if(empty($info)){
                pdo_rollback();
                echo json_encode(['status'=>1,'msg'=>'清单不存在']);exit;
            }

            //查询小区名
            $vg_name = pdo_fetchcolumn("select vg_name from ".tablename("gpb_village")." where openid='{$info[0]['go_team_openid']}' and weid={$this->weid}");

            //关联路线
            $route = pdo_fetch('select dr_name,dr_id from '.tablename('gpb_distribution_route').' as dr join '.tablename('gpb_head_route').' as hr on hr.ghr_rid=dr.dr_id where ghr_mid='.$v);

            if(empty($route)){
                //说明该小区还没配送路线
                //就新增配送系统默认配送
                $rout = pdo_get('gpb_distribution_route',array('dr_id'=>-1));
                if(empty($rout)){
                    pdo_insert('gpb_distribution_route',array('dr_id'=>-1,'dr_name'=>'系统默认路线','dr_people'=>'系统默认配送员','weid'=>0,'dr_num'=>0));
                }
                pdo_insert('gpb_head_route',array('ghr_mid'=>$v,'ghr_rid'=>-1,'weid'=>$this->weid));
                $dl_dr_id = pdo_insertid();
            }else{
                $hr = pdo_get('gpb_head_route',array('ghr_rid'=>$route['dr_id'],'ghr_mid'=>$v));
                $dl_dr_id = $hr['ghr_id'];
            }
            //商品总数
            $sum = array_sum(array_column($info,'num'));
            $dl_data = array(
                'dl_shop_name'=>$vg_name.'/'.$info[0]['m_head_address'],
                'dl_shop_address'=>$info[0]['m_head_address'].$info[0]['m_head_house_address'],
                'dl_dr_id'=>$dl_dr_id,
                'dl_add_time'=>time(),
                'dl_status'=>10,
                'dl_goods_num'=>$sum,
                'dl_is_del'=>1,
                'weid'=>$this->weid,
                'dl_code'=>$this->nextId(),
            );
            $res = pdo_insert('gpb_distribution_list',$dl_data);
            $list_id =pdo_insertid();
            if(empty($res)){
                pdo_rollback();
                echo json_encode(['status'=>1,'msg'=>'生成清单失败']);exit;
            }
            foreach ($info as $val){
                //每个订单修改状态为 28已生成清单
                $res = pdo_update('gpb_order',array('go_status'=>28),array('go_code'=>$val['go_code'],'weid'=>$this->weid,'go_id'=>$val['go_id']));
                if(empty($res)){
                    pdo_rollback();
                    echo json_encode(['status'=>1,'msg'=>'生成清单失败.']);exit;
                }
                $res = pdo_insert('gpb_distribution_list_order',array('l_id'=>$list_id,'go_id'=>$val['go_id'],'go_code'=>$val['go_code'],'weid'=>$this->weid));
                if(empty($res)){
                    pdo_rollback();
                    echo json_encode(['status'=>1,'msg'=>'生成清单失败!']);exit;
                }
            }
        }
        pdo_commit();
        echo json_encode(['status'=>0,'msg'=>'生成清单成功']);exit;
        break;

    case 'test1':
        $info = pdo_fetchall('select * from '.tablename('gpb_head_route').' where ghr_mid is null ');
        foreach ($info as $v ){
            $vg = pdo_get($this->vg,array('vg_id'=>$v['ghr_vid']));
            if(empty($vg)){
                pdo_delete('gpb_head_route',array('ghr_id'=>$v['ghr_id']));
                continue;
            }
            $member = pdo_get('gpb_member',array('m_openid'=>$vg['openid']));
            pdo_update('gpb_head_route',array('ghr_mid'=>$member['m_id']),array('ghr_id'=>$v['ghr_id']));
        }
        break;
		
    case 'out_send_list':
        $lid = trim($_GPC['lid'],',');
        if(empty($lid)){
            $this->message_info('参数异常');
        }
        $lid_arr = explode(',',$lid);
        $str ='';
        foreach ($lid_arr as $k=> $lid_val){
            if( $k >0 ){
                $str .='<br/>';
            }
            $dl = pdo_get('gpb_distribution_list',array('dl_id'=>$lid_val));
            if(empty($dl)){
                continue;
            }
//            $dr = pdo_get('gpb_distribution_route',array('dr_id'=>$dl['dl_dr_id']));

            $dr = pdo_fetch("select dr.* from ".tablename('gpb_head_route')." r join ".tablename('gpb_distribution_route')." dr on dr.dr_id = r.ghr_rid where ghr_id = ".$dl['dl_dr_id']);
            $orders = pdo_getall('gpb_distribution_list_order',array('l_id'=>$lid_val));
            if(!empty($orders)){
                $orders_array = array_column($orders,'go_id');
                $orders_str = implode(',',$orders_array);
            }else{
                $orders_str = $dl['dl_go_code'];
            }
            if(!empty($orders_str)){
                $sql = 'select sum(o.oss_g_num) as num,g.g_name,g.g_icon,o.oss_ggo_title,m.m_nickname,m.m_phone,m.m_head_address,m.m_head_house_address,o.oss_head_name,o.oss_g_price,gtc.gc_name  from '.tablename('gpb_order_snapshot').' as o  
                join '.tablename('gpb_member').' as m on m.m_openid=o.oss_head_openid 
                join '.tablename('gpb_order').' as go on go.go_code=o.oss_go_code 
                left join '.tablename('gpb_goods').' as g on g.g_id=o.oss_gid 
                join (
                 select gtc.goods_id,gtc.cate_id,gc.gc_name 
                 from '.tablename("gpb_goods_to_category").' as gtc
                 join '.tablename("gpb_goods_cate").' as gc on gc.gc_id=gtc.cate_id
                 where gtc.weid='.$this->weid.' 
                 and gc.gc_is_del=1
                 group by gtc.goods_id
                 ORDER BY gtc.`cate_id` DESC
                ) as gtc on g.g_id=gtc.goods_id OR gtc.goods_id IS NULL
                where go.weid='.$this->weid.' 
                and o.oss_ggo_status=1 
                and go.go_id in('.$orders_str.')  
                group by g.g_id,o.oss_ggo_id
                order by gtc.cate_id asc
                ';
                /*echo $sql;
                die;*/

                $info = pdo_fetchall($sql);
                if(empty($info)){
                    continue;
                }
                if($this->check_base64_out_json($info[0]['oss_head_name'])){
                    $info[0]['oss_head_name'] = filterNickname(base64_decode($info[0]['oss_head_name']));
                }
                $send_time = empty($dl['dl_send_time'])?'':date('Y-m-d H:i:s',$dl['dl_send_time']);
                $str .="<tr><th colspan='6' align='center'  style='font-size: 28px;'>".$dl['dl_shop_name']."</th></tr>
  <tr><td colspan='6' >团长：".$info[0]['oss_head_name']."&nbsp;&nbsp;提货地址：".$info[0]['m_head_address'].$info[0]['m_head_house_address']."&nbsp;&nbsp;联系电话：".$info[0]['m_phone']."</td></tr>
  <tr><td colspan='6' >配送单：".$dl['dl_code']."&nbsp;&nbsp;配送时间：".$send_time."</td></tr>
  <tr><td colspan='6' >配送路线：".$dr['dr_name']."&nbsp;&nbsp;配送员：".$dr['dr_people']."&nbsp;&nbsp;联系电话：".$dr['dr_phone']."</td></tr>
                    <tr>
                    <th>商品分类</th>
                    <th colspan='1'>商品名称</th>
                    <th colspan='1'>数量</th>
                    <th colspan='1'>规格</th>
                    <th colspan='1'>单价</th>
                    <th colspan='1'>总价</th>
                    </tr>
            ";
				$is = 0;
                foreach ($info as $k => $v) {
                    $str .="<tr><td>{$v['gc_name']}</td><td colspan='1'>".$v['g_name']."　</td><td colspan='1'>".$v['num']."</td><td colspan='1'>".$v['oss_ggo_title']."</td><td colspan='1'>".$v['oss_g_price']."</td><td colspan='1'>".floatval($v['num']*$v['oss_g_price'])."</td></tr>";
					if(mb_strlen(trim($v['g_name'])) > 45){
						$is += 2;
					}else{
	                	$is += 1;
					}
				}
				if($is < 45){
	            	$as = 45-$is;
	            	for($i = 0;$i<$as;$i++){
	                	$str .="<tr><td colspan='6'></td></tr>";
	            	}
	            }
//				$str .="<tr><th colspan='5' align='center'  style='font-size: 28px;background:red;'></th></tr>";
            }else{
                continue;
            }
        }
        
//      exit;
        $filename = "清单数据";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=".$filename."_".date('Y_m_d_H_i').".xls");
        header('Expires:0');
        header('Pragma:public');
        echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table border="1" style="font-size:10px;">'.$str.'</table></html>';
        exit;
        break;
    case 'out_link_order':
        $lid = trim($_GPC['lid'],',');
        if(empty($lid)){
            $this->message_info('参数异常');
        }
        $orders = pdo_fetchall('select * from '.tablename('gpb_distribution_list_order').' where l_id in ('.$lid.')');
        if(empty($orders)){
            $this->message_info('订单有误');
        }
        $go_id = array_column($orders,'go_id');
        $go_id_str = implode(',',$go_id);
        $url = $this->createWebUrl('order',array('op'=>'outXlsx','id'=>$go_id_str));
        header('Location:'.$url);
        exit();
        break;

    /*case 'test':
        //新增订阅消息 周龙 2020-02-27
        ini_set("display_errors", "On");
        error_reporting(E_ALL);
        echo "1<br/>";
        $submsg = new \SubMsg();
        echo "2<br/>";
        $submsg_arr = [
            '123456',
            '测试订单',
            10,
            50,
            '您的货物已发货，请密切关注'
        ];
        echo "3<br/>";
        $res = $submsg->sendmsg("deliver_msg",'oLf4B0bm-0PiHMtR1ycmWARlcTTU',$submsg_arr);
        echo "4<br/>";
        echo "<pre/>";
        var_dump($res);
        die;
        break;*/
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