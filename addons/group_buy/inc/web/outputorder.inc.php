<?php
/**
 * Created by PhpStorm.
 * User: orichi
 * Date: 2020/3/27
 * Time: 13:23
 */
ini_set('display_errors',1);
error_reporting(E_ALL);
global $_W,$_GPC;
$weid = $this->weid;
$weid = $this->weid;  //控制模块
$old_op = "index";
$op='outXlsx';
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

//第一步查询订单及买家信息
if(!empty($id)){
    $total= pdo_fetchcolumn('select count(*) from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1  ".$where." and o.weid=".$weid." and o.go_id in (".$id.") and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
    $sql = "select o.time2,o.go_code,oss_buy_name,IFNULL(os.oss_address_phone,os.oss_buy_phone) AS oss_buy_phone,o.go_status,group_concat(oss_g_name separator '||') as g_name,group_concat(oss_g_price separator '||') as g_prcie,group_concat(oss_g_num separator '||') as g_num,group_concat(oss_ggo_title separator '||') as ggo_title,group_concat(oss_ggo_status separator '||') as ggo_status,sum(oss_total_price) as total,o.go_fdc_price,o.go_send_pay,o.go_real_price,oss_v_name,o.go_commission_num,o.go_commission,os.oss_head_name,os.oss_head_phone,os.oss_address_name,os.oss_address_phone,os.oss_address,o.go_buy_msg,o.go_add_time,o.go_pay_time,o.go_send_type as send_type,o.go_pay_type as pay_type,o.go_team_openid from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code where go_is_del = 1  and go_id in (".$id.") and weid=".$weid."  and (`type`=1 or `type` is null)group by go_code  order by go_id desc ";
    $total_money = pdo_fetch('select sum(go_real_price) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) and o.go_id in (".$id.")  group by go_code  order by go_id desc) as t");
    $back_money = pdo_fetch('select sum(oss_g_price*oss_g_num) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) and o.go_id in (".$id.") and os.oss_ggo_status =70  order by go_id desc) as t");
    $res_money  =sprintf('%01.2f',($total_money['a']-floatval($back_money['a'])));
}else{
    if($old_op =='index'){
        $total= pdo_fetchcolumn('select count(*) from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1  ".$where." and o.weid=".$weid."  and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
        $sql = "select o.time2,o.go_code,oss_buy_name,IFNULL(os.oss_address_phone,os.oss_buy_phone) AS oss_buy_phone,o.go_status,group_concat(oss_g_name separator '||') as g_name,group_concat(oss_g_price separator '||') as g_prcie,group_concat(oss_g_num separator '||') as g_num,group_concat(oss_ggo_title separator '||') as ggo_title,group_concat(oss_ggo_status separator '||') as ggo_status,sum(oss_total_price) as total,o.go_fdc_price,o.go_send_pay,o.go_real_price,oss_v_name,o.go_commission_num,o.go_commission,os.oss_head_name,os.oss_head_phone,os.oss_address_name,os.oss_address_phone,os.oss_address,o.go_buy_msg,o.go_add_time,o.go_pay_time,o.go_send_type as send_type,o.go_pay_type as pay_type,o.go_team_openid from ".tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id=os.oss_gid where go_is_del = 1  and o.weid=".$weid.$where." and (o.`type`=1 or o.`type` is null) group by go_code  order by go_id desc ";


        $total_money = pdo_fetch('select sum(go_real_price) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null )  group by go_code  order by go_id desc) as t");
        $back_money = pdo_fetch('select sum(oss_g_price*oss_g_num) as a from (select os.*,o.*,g.g_id  from '.tablename($this->snapshot)." as os join ".tablename($this->order)." as o on o.go_code = os.oss_go_code left join ".tablename($this->goods)." as g on g.g_id = os.oss_gid  where  go_is_del = 1 ".$where." and o.weid=".$weid." and (g.`type`<>2 or g.`type` is null ) and os.oss_ggo_status =70  order by go_id desc) as t");
        $res_money  =sprintf('%01.2f',($total_money['a']-floatval($back_money['a'])));
    }elseif($old_op=='afterSale'){
        $total= pdo_fetchcolumn('select count(*) from '.tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as os on bm.gbm_oss_id = os.oss_id left join ".tablename($this->goods)." as g on g.g_id=os.oss_gid left join ".tablename($this->order)." as o on o.go_code = bm.gbm_go_code where bm.weid =".$weid.$where." order by gbm_add_time desc ");

        //$sql = "select o.go_code,oss_buy_name,os.oss_buy_phone,o.go_status,group_concat(oss_g_name separator '||') as g_name,group_concat(oss_g_price separator '||') as g_prcie,group_concat(oss_g_num separator '||') as g_num,group_concat(oss_ggo_title separator '||') as ggo_title,group_concat(oss_ggo_status separator '||') as ggo_status,sum(oss_total_price) as total,o.go_fdc_price,o.go_send_pay,o.go_real_price,oss_v_name,o.go_commission_num,o.go_commission,os.oss_head_name,os.oss_head_phone,os.oss_address_name,os.oss_address_phone,os.oss_address,o.go_buy_msg,o.go_add_time,o.go_pay_time from ".tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as os on bm.gbm_oss_id = os.oss_id left join ".tablename($this->goods)." as g on g.g_id=os.oss_gid left join ".tablename($this->order)." as o on o.go_code = bm.gbm_go_code where bm.weid =".$weid.$where." order by gbm_add_time desc ";
        $sql = "select o.time2,o.go_code,oss_buy_name,os.oss_buy_phone,o.go_status,oss_g_name as g_name,oss_g_price  as g_prcie,oss_g_num  as g_num,oss_ggo_title  as ggo_title,oss_ggo_status  as ggo_status,oss_total_price as total,o.go_fdc_price,o.go_send_pay,o.go_real_price,oss_v_name,o.go_commission_num,o.go_commission,os.oss_head_name,os.oss_head_phone,os.oss_address_name,os.oss_address_phone,os.oss_address,o.go_buy_msg,o.go_add_time,o.go_pay_time,o.go_send_type as send_type,o.go_pay_type as pay_type,o.go_team_openid from ".tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as os on bm.gbm_oss_id = os.oss_id left join ".tablename($this->goods)." as g on g.g_id=os.oss_gid left join ".tablename($this->order)." as o on o.go_code = bm.gbm_go_code where bm.weid =".$weid.$where." order by gbm_add_time desc ";

        $res_money = pdo_fetch( "select sum(gbm_money) as sums from ".tablename($this->back_money)." as bm left join ".tablename($this->member)." as m on m.m_openid =bm.openid left join ".tablename($this->snapshot)." as ss on bm.gbm_oss_id = ss.oss_id left join ".tablename($this->goods)." as g on g.g_id=ss.oss_gid left join ".tablename($this->order)." as o on o.go_code = ss.oss_go_code  where bm.weid =".$weid.$where." and gbm_status =20 order by gbm_add_time desc ");
        $res_money = $res_money['sums'];
    }

}

$list = pdo_fetchall($sql." limit 0,5000");
//第二步根据配送方式查询用户收货地址并将需要转换的信息转换中文
foreach ($list as $k=>$v){
    if($this->check_base64_out_json($v['oss_buy_name'])){
        $list[$k]['oss_buy_name'] = base64_decode($v['oss_buy_name']);
    }
    if($this->check_base64_out_json($v['oss_head_name'])){
        $list[$k]['oss_head_name'] = base64_decode($v['oss_head_name']);
    }
    $v['send_type'] = intval($v['send_type']);
    $list[$k]['send_type'] = $v['send_type']==1?'自提':($v['send_type']==3?'快递':'团长送货');
    $list[$k]['pay_type'] = $v['pay_type']==1?'微信支付':'余额支付';
    if($v['send_type']===1){
        //自提 地址获取团长地址
        $go_vid = pdo_fetchcolumn("select go_vid from ".tablename("gpb_order")." where `go_code`='{$v['go_code']}'");
        if(empty($go_vid)){
            //小区id为空获取团长openid 根据团长openid获取提货地址
            $go_team_openid = pdo_fetchcolumn("select go_team_openid from ".tablename("gpb_order")." where `go_code`='{$v['go_code']}'");
            $addr = pdo_fetchcolumn("select `vg_address` from ".tablename("gpb_village")." where openid='{$v['go_team_openid']}'");
        }else{
            //小区id存在 获取对应小区地址
            $addr = pdo_fetchcolumn("select `vg_address` from ".tablename("gpb_village")." where vg_id='{$go_vid}'");
        }
        if($addr == base64_encode(base64_decode($addr))){
            $addr = base64_decode($addr);
        }
        $list[$k]['oss_address'] = $addr;
        //获取配送时间及配送单号
        $lo = pdo_fetchcolumn("select l_id from ".tablename("gpb_distribution_list_order")." where go_code='{$v['go_code']}'");
        if(!empty($lo)){
            $ps_info = pdo_fetch("select * from ".tablename("gpb_distribution_list")." where dl_id={$lo}");
            $list[$k]['send_time'] = date("Y-m-d H:i:s",$ps_info['dl_send_time']);
            $list[$k]['send_order'] = $ps_info['dl_code'];
        }

    }elseif($v['send_type']===2){
        //团长送货地址
        $addr = pdo_fetchcolumn("select oss_address from ".tablename("gpb_order_snapshot")." where oss_go_code='{$v['go_code']}' group by oss_go_code");

        if($addr==base64_encode(base64_decode($addr))){
            $addr = base64_decode($addr);
        }
        $list[$k]['oss_address'] = $addr;
        //获取配送时间及配送单号
        $lo = pdo_fetchcolumn("select l_id from ".tablename("gpb_distribution_list_order")." where go_code='{$v['go_code']}'");
        if(!empty($lo)){
            $ps_info = pdo_fetch("select * from ".tablename("gpb_distribution_list")." where dl_id={$lo}");
            $list[$k]['send_time'] = pdo_fetchcolumn("select delivery_time from ".tablename("gpb_order")." where go_code='{$v['go_code']}'");
            $list[$k]['send_order'] = $ps_info['dl_code'];
        }

    }else{
        //快递
        $kd_info = pdo_fetch("select express_time,shipping_no from ".tablename("gpb_order")." where go_code='{$v['go_code']}'");
        if(!empty($kd_info['send_time']) && !empty($kd_info['shipping_no'])){
            $list[$k]['send_time'] = date('Y-m-d H:i:s',$kd_info['express_time']);
            $list[$k]['send_order'] = $kd_info['shipping_no'];
        }
    }
    $list[$k]['go_add_time'] = date("Y-m-d H:i:s",$v['go_add_time']);
    $list[$k]['go_pay_time'] = date("Y-m-d H:i:s",$v['go_pay_time']);
    $list[$k]['time2'] = !empty($v['time2'])?date("Y-m-d H:i:s",$v['time2']):'';
}

if(!empty($_GPC['debug'])){
    echo $sql;
    echo "<pre/>";
    var_dump($list);
}

$str ="<tr height='40'>";
$str .="<td>订单数：</td><td>".$total."&nbsp;</td><td>订单总价：</td><td>￥".$res_money."&nbsp;</td>";
$str .="</tr>";
$str .="<tr>";
$str .="<td>订单号</td>";
$str .="<td>配送方式</td>";
$str .="<td>收货人</td>";
$str .="<td>收货人联系方式</td>";
$str .="<td>收货地址/自提地址</td>";
$str .="<td>配送单号/快递单号</td>";
$str .="<td>发货时间</td>";
$str .="<td>完成时间</td>";
$str .="<td>支付方式</td>";
$str .="<td>支付时间</td>";
$str .= "</tr>";
foreach ($list as $k=>$v){
    $v['send_time'] = !empty($v['send_time'])?$v['send_time']:'';
    $v['send_order'] = !empty($v['send_order'])?$v['send_order']:'';
    $str .= "<tr>";
    $str .="<td>{$v['go_code']}</td>";
    $str .="<td>{$v['send_type']}</td>";
    $str .="<td>{$v['oss_address_name']}</td>";
    $str .="<td>{$v['oss_address_phone']}</td>";
    $str .="<td>{$v['oss_address']}</td>";
    $str .="<td>{$v['send_order']}</td>";
    $str .="<td>{$v['send_time']}</td>";
    $str .="<td>{$v['time2']}</td>";
    $str .="<td>{$v['pay_type']}</td>";
    $str .="<td>{$v['go_pay_time']}</td>";
    $str .= "</tr>";
}
$str .= "</table>";
$filename = "订单详情数据";
header("Content-type: application/vnd.ms-excel");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
header('Expires:0');
header('Pragma:public');

echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table border="1">'.$str.'</table></html>';
exit;
