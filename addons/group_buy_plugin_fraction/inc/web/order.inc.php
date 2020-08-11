<?php
header("Content-type:text/html;charset=utf-8");
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$status = $_GPC['status'];
$index=isset($_GPC['page'])?$_GPC['page']:1;
$id = $_GPC['id'];
switch($op){
	case 'index':
		$where = ' and `type`=2 ';
		if(!empty($_GPC['order_status'])){
			$where .= " and o.go_status = ".$_GPC['order_status'];
		}
		if(!empty($status)){
			$where .= " and o.go_status = ".$status;
		}
		if(!empty($_GPC['level'])){
			$where .= " and m.level_id = ".$_GPC['level'];
		}
		if(!empty($_GPC['star_time'])){
			$where .= " and o.go_add_time >= ".strtotime($_GPC['star_time']);
		}
		if(!empty($_GPC['end_time'])){
			$where .= " and o.go_add_time <= ".strtotime($_GPC['end_time']);
		}
		if(!empty($_GPC['order'])){
			$where .= " and o.go_code = ".$_GPC['order'];
		}
		$pageIndex = $index;
        $pageSize = $this->pageSize;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_order)." o  where o.weid = ".$this->weid.$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select o.* from '.tablename($this->gpb_order)." o where o.weid = ".$this->weid.$where." order by o.go_add_time desc ".$contion;
		$info = pdo_fetchall($sql);
		if(!empty($info)){
			foreach($info as $k=>$v){
				$infos = pdo_getall($this->gpb_order_snapshot,array('oss_go_code'=>$v['go_code']));
				foreach ($infos as $kk=>$vv){
                    if(is_base64($vv['oss_buy_name'])){
                        $infos[$kk]['oss_buy_name'] = base64_decode($vv['oss_buy_name']);
                    }
                    if(is_base64($vv['oss_address_name'])){
                        $infos[$kk]['oss_address_name'] = base64_decode($vv['oss_address_name']);
                    }
                    if(is_base64($vv['oss_head_name'])){
                        $infos[$kk]['oss_head_name'] = base64_decode($vv['oss_head_name']);
                    }
                }
				$info[$k]['data'] = $infos;
				//获取团长的小区的地址
				$vg = pdo_get($this->vg,array('openid'=>$v['go_team_openid'],'weid'=>$this->weid));
				$info[$k]['oss_address'] = $vg['vg_address'];
				$info[$k]['oss_address_name'] = $vg['vg_name'];
			}
		}
	break;
	case 'save':
		if(empty($id)){
			$this->res(1,'请传入id');
		}
		$info = pdo_get($this->gpb_order,array('go_id'=>$id));
		if(empty($info)){
			$this->res(1,'该订单不存在');
		}
		$goods = pdo_get($this->gpb_goods,array('g_id'=>$info['go_gid']));
		if($info['go_status'] == 30 && $_GPC['type'] == 30 ){
			$this->res(1,'该订单已经发货，无需重新发货');
		}
		if($info['go_status'] == 100 && $_GPC['type'] == 100 ){
			$this->res(1,'该订单已经收货，无需重新收货');
		}
		if($info['go_status'] == 100 && $_GPC['type'] == 30 ){
			$this->res(1,'该订单已经收货，无需重新发货');
		}
		
		$res = pdo_update($this->gpb_order,array('go_status'=>$_GPC['type'],$_GPC['time']=>time()),array('go_id'=>$id));
		if($res){
			if($_GPC['type'] == 30){
				$str = '你购买的商品'.$goods['g_name'].'已发货，请注意取货!';
			}else{
				$str = '你购买的商品'.$goods['g_name'].'已收货。';
			}
			$this->mails($info['go_vid'],$str,$info['openid']);
			$this->res(0,'操作成功');
		}else{
			$this->res(1,'操作失败');
		}
	break;
	case 'info':
		$sql = 'select * from '.tablename($this->gpb_order)." where weid = ".$this->weid." and go_id = ".$id;
		$info = pdo_fetch($sql);
		if(!empty($info)){
			$infos = pdo_getall($this->gpb_order_snapshot,array('oss_go_code'=>$info['go_code']));
			foreach ($infos as $kk=>$vv){
                if(is_base64($vv['oss_buy_name'])){
                    $infos[$kk]['oss_buy_name'] = base64_decode($vv['oss_buy_name']);
                }
                if(is_base64($vv['oss_address_name'])){
                    $infos[$kk]['oss_address_name'] = base64_decode($vv['oss_address_name']);
                }
            }
			$info['data'] = $infos;
			$vg = pdo_get($this->vg,array('openid'=>$info['go_team_openid'],'weid'=>$this->weid));
			$info['oss_address'] = $vg['vg_address'];
		}
//		echo '<pre>';
//		print_r($info);exit;
	break;
	case 'export':
		//订单导出
		if(!empty($_GPC['order_status'])){
			$where .= " and o.go_status = ".$_GPC['order_status'];
		}
		if(!empty($_GPC['star_time'])){
			$where .= " and o.go_add_time >= ".strtotime($_GPC['star_time']);
		}
		if(!empty($_GPC['end_time'])){
			$where .= " and o.go_add_time <= ".strtotime($_GPC['end_time']);
		}
		if(!empty($_GPC['order'])){
			$where .= " and o.go_code = ".$_GPC['order'];
		}
		$info = pdo_fetchall("select o.go_status,oss_go_id,oss_go_code,oss_g_price,oss_g_old_price,oss_g_name,oss_buy_name,oss_buy_phone,oss_address_name,oss_address_phone,oss_address,go_add_time,v.vg_address,v.vg_name from ".tablename($this->gpb_order)." o join ".tablename($this->gpb_order_snapshot)." s on o.go_id = s.oss_go_id join ".tablename($this->vg)." v on v.openid = o.go_team_openid where o.weid = ".$this->weid." and o.type = 2 ".$where." order by o.go_add_time desc ");
		
		
//		echo "select o.go_status,oss_go_id,oss_go_code,oss_g_price,oss_g_old_price,oss_g_name,oss_buy_name,oss_buy_phone,oss_address_name,oss_address_phone,oss_address,go_add_time,v.vg_address,v.vg_name from ".tablename($this->gpb_order)." o join ".tablename($this->gpb_order_snapshot)." s on o.go_id = s.oss_go_id join ".tablename($this->gpb_member)." m on o.go_gid = m.m_id join ".tablename($this->vg)." v on v.openid = o.go_team_openid where o.weid = ".$this->weid." and o.type = 2 ".$where." order by o.go_add_time desc ";exit;
		
		$strTable = '';
		$strTable ='<table width="500" border="1">';
    	$strTable .= '<tr>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">序号</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">商品名称</td>';
	    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">订单号</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;width:120px;">价格</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;width:120px;">支付状态</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="100">日期</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">买家姓名</td>';
	    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">买家电话</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">收货人姓名</td>';
	    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">收货人电话</td>';
	    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">收货人小区</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">收货人地址</td>';
    	$strTable .= '</tr>';
    	
    	if(!empty($info)){
    		foreach($info as $k=>$v){
    			$status = $v['go_status'] == 10 ? '未支付' : '已支付'; 
    			$strTable .= '<tr>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['oss_go_id'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['oss_g_name'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['oss_go_code']."&nbsp;".'</td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['oss_g_price']."元+".$v['oss_g_old_price']."积分".' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$status.' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.date('Y-m-d H:i:s',$v['go_add_time']).'&nbsp;</td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['oss_buy_name'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['oss_buy_phone'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['oss_address_name'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['oss_address_phone'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['vg_name'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['vg_address'].' </td>';
				$strTable .= '</tr>';
    		}
    	}
		unset($info);
		$strTable .='</table>';
		header("Content-type: application/vnd.ms-excel");
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=订单_".date('Y-m-d').".xls");
		header('Expires:0');
		header('Pragma:public');
		echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$strTable.'</html>';
	break;
}
$sql = 'select id,title from '.tablename($this->gpb_level)." where weid = ".$this->weid." and status = 1  order by time desc ";
$level = pdo_fetchall($sql);
//echo '<pre>';print_r($level);exit;
include $this->template('web/'.$do.'/'.$op);
?>