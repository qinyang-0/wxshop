<?php
/**
 * Created by PhpStorm.
 * User: orichi
 * Date: 2019/10/12
 * Time: 16:18
 */
global $_W,$_GPC;
include_once '../addons/group_buy_plugin_team/function.php';
$op = !empty($_GPC['op'])?$_GPC['op']:'list';
switch($op){
    case 'list':
        /*$state = trim($_GPC['states']);
        $where = "o.weid={$this->weid} and oss_is_seckilloss_is_seckill=3";
        if($state===1){
            //待付款
            $where .= " and os.`oss_ggo_status`=1";
        }
        if($state==2){
            //已付款
            $where .= " and os.`oss_ggo_status`=2";
        }
        if($state===-1){
            //拼团失败
            $where .= " and os.`oss_ggo_status`=-1";
        }

        $total = pdo_fetchcolumn("select count(*) from ".tablename("gpb_order_snapshot")." as os left join ".tablename("gpb_order")." as o on o.osn=os.oss_go_code where {$where} ");
        $page = !empty($_GPC['page'])?$_GPC['page']:1;
        $size = 15;
        $limit = ($page-1)*$size;
        $limit = " limit {$limit},{$size}";
        $pager = pagination($total, $page, $size);
        $list = pdo_fetchall("select * from ".tablename("gpb_order_snapshot")." as os left join ".tablename("gpb_order")." as o on o.osn=os.oss_go_code where {$where} ");*/
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
        $status = $_GPC['states'];
        if( isset($_GPC['states']) and !empty($_GPC['states']) ) {
            $where .= " and  go_status = '".trim($_GPC['states'])."' ";
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
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        if($status!=0){
            $total= pdo_fetchcolumn('select count(*) from (select os.*,o.*,g.g_id  from '.tablename("gpb_order_snapshot")." as os join ".tablename("gpb_order")." as o on o.go_code = os.oss_go_code left join ".tablename("gpb_goods")." as g on g.g_id = os.oss_gid  where os.oss_is_seckill=3 and go_is_del = 1  ".$where." and o.weid=".$this->weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t join (select po.*,pa.state as pastate from ".tablename("gpb_pteam_activity")." as pa left join ".tablename("gpb_pteam_order")." as po on pa.id=po.aid where pa.state=10 and pa.weid={$this->weid}) as p  on t.go_code=p.osn");
            $sql = "select *,sum(oss_total_price) as total,group_concat(oss_g_name separator '||') as gname,group_concat(oss_g_icon separator '||') as gicon,group_concat(oss_g_price separator '||') as gprice,oss_is_seckill,group_concat(oss_g_price separator '||') as gprice,group_concat(oss_g_num separator '||') as gnum,group_concat(g_brief separator '||') as gbrief,group_concat(oss_ggo_title separator '||') as ggotitle from ".tablename("gpb_order_snapshot")." as os join ".tablename("gpb_order")." as o on o.go_code = os.oss_go_code  left join ".tablename("gpb_goods")." as g on g.g_id = os.oss_gid JOIN (
SELECT pa.state as pastate,pa.id as actid,pa.pl_id as plid,po.osn FROM 
".tablename("gpb_pteam_activity")." AS pa 
LEFT JOIN ".tablename("gpb_pteam_order")." AS po 
ON pa.id=po.aid
WHERE pa.state=10 AND pa.weid={$this->weid}
) AS pt ON os.`oss_go_code`=pt.osn where os.oss_is_seckill=3 and go_is_del = 1  ".$where." and o.weid=".$this->weid." and (g.`type`<>2 or g.`type` is null ) group by o.go_code  order by go_id desc ".$contion;
        }else{
            $total = pdo_fetchcolumn('select count(*) from (select os.*,o.*,g.g_id  from '.tablename("gpb_order_snapshot")." as os join ".tablename("gpb_order")." as o on o.go_code = os.oss_go_code left join ".tablename("gpb_goods")." as g on g.g_id = os.oss_gid  where os.oss_is_seckill=3 and go_is_del = 1  ".$where." and o.weid=".$this->weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
            $sql = "select *,sum(oss_total_price) as total,group_concat(oss_g_name separator '||') as gname,group_concat(oss_g_icon separator '||') as gicon,group_concat(oss_g_price separator '||') as gprice,oss_is_seckill,group_concat(oss_g_price separator '||') as gprice,group_concat(oss_g_num separator '||') as gnum,group_concat(g_brief separator '||') as gbrief,group_concat(oss_ggo_title separator '||') as ggotitle from ".tablename("gpb_order_snapshot")." as os join ".tablename("gpb_order")." as o on o.go_code = os.oss_go_code  left join ".tablename("gpb_goods")." as g on g.g_id = os.oss_gid  where os.oss_is_seckill=3 and go_is_del = 1  ".$where." and o.weid=".$this->weid." and (g.`type`<>2 or g.`type` is null ) group by o.go_code  order by go_id desc ".$contion;
        }

        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息

//        exit($sql);
//        exit(dump($sql));
        $info = pdo_fetchall($sql);
        /*dump($sql);
        exit(dump($info));*/
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
//        exit;
//		var_dump($sql);exit;
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
            $status[intval($v)] = pdo_fetchcolumn('select count(*) from (select os.*,o.*,g.g_id  from '.tablename("gpb_order_snapshot")." as os join ".tablename("gpb_order")." as o on o.go_code = os.oss_go_code left join ".tablename("gpb_goods")." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where_s." and o.weid=".$this->weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
            $total_money[intval($v)] = pdo_fetch('select sum(go_real_price) as a from (select os.*,o.*,g.g_id  from '.tablename("gpb_order_snapshot")." as os join ".tablename("gpb_order")." as o on o.go_code = os.oss_go_code left join ".tablename("gpb_goods")." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where_s." and o.weid=".$this->weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
            $back_money[intval($v)] = pdo_fetch('select sum(oss_g_price*oss_g_num) as a from (select os.*,o.*,g.g_id  from '.tablename("gpb_order_snapshot")." as os join ".tablename("gpb_order")." as o on o.go_code = os.oss_go_code left join ".tablename("gpb_goods")." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where_s." and o.weid=".$this->weid." and (g.`type`<>2 or g.`type` is null ) and os.oss_ggo_status =70  order by go_id desc) as t");
            $res_money[intval($v)]  =sprintf('%01.2f',($total_money[intval($v)]['a']-floatval($back_money[intval($v)]['a'])));
        }
        $now_total_money = pdo_fetch('select sum(go_real_price) as a from (select os.*,o.*,g.g_id  from '.tablename("gpb_order_snapshot")." as os join ".tablename("gpb_order")." as o on o.go_code = os.oss_go_code left join ".tablename("gpb_goods")." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$this->weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
        $now_back_money = pdo_fetch('select sum(oss_g_price*oss_g_num) as a from (select os.*,o.*,g.g_id  from '.tablename("gpb_order_snapshot")." as os join ".tablename("gpb_order")." as o on o.go_code = os.oss_go_code left join ".tablename("gpb_goods")." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$this->weid." and (g.`type`<>2 or g.`type` is null ) and os.oss_ggo_status =70  order by go_id desc) as t");
        $now_money  =sprintf('%01.2f',($now_total_money['a']-floatval($now_back_money['a'])));

        //读取后台是否加入配送流程
        $order_back_send_type= pdo_get("gpb_config",array('key'=>'order_back_send_type','weid'=>$this->weid));
        $order_back_send_type = isset($order_back_send_type['value'])?$order_back_send_type['value']:1;
        //是否开启平台确认收货
        $is_open_manger_sure_order = pdo_get("gpb_config",array('key'=>'is_open_manger_sure_order','weid'=>$this->weid));
        $is_open_manger_sure_order = isset($is_open_manger_sure_order['value'])?intval($is_open_manger_sure_order['value']):2;
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
include $this -> template('web/teambuy/order_' . $op);