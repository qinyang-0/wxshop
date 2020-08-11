<?php
/**
 * 区域管理相关
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'village' : $op ;
$weid = $this->weid;  //控制模块
//var_dump($_GPC);exit();
$_GPC['do'] = 'head';
switch($op){
//	case 'area':
//
//
//		$index=isset($_GPC['page'])?$_GPC['page']:1;
//        $pageIndex = $index;
//        $pageSize = 10;
//        $where = "  ";
//        //逻辑：昵称是模糊查询
//        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
//            $where .= " and rg_name like '%".trim($_GPC['title'])."%' ";
//        }
//		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
//		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->rg)." where rg_status = 1 and weid=".$weid.$where);
//		$page = pagination($total,$pageIndex,$pageSize);
//		//获取分页信息
//		$sql = 'select * from '.tablename($this->rg)." where rg_status = 1 and weid=".$weid.$where."  order by rg_add_time desc ".$contion;
//		$info = pdo_fetchall($sql);
//	break;
//	case 'areaAdd':
//		if($_GPC['submit'] == '提交'){
//			//提交数据
////            var_dump($_GPC);exit();
//			$province_name = trim($_GPC['province_name']);
//			$city_name = trim($_GPC['city_name']);
//            $area_name = trim($_GPC['area_name']);
//			$province = Intval($_GPC['province']);
//            $city = Intval($_GPC['city']);
//            $area = Intval($_GPC['area']);
//            $name = trim($_GPC['name']);
//            //验证
//            if(empty($name) ){
//                $this->message_info('请输入地区名称');exit;
//            }
//            if(empty($province) ){
//                $this->message_info('请选择省份');exit;
//            }
//            if(empty($city) ){
//                $this->message_info('请选择城市');exit;
//            }
//            if(empty($area) ){
//                $this->message_info('请选择区/县');exit;
//            }
//			$data = [
//				'rg_province_id'=>$province,
//				'rg_city_id'=>$city,
//				'rg_area_id'=>$area,
//                'rg_name'=>$name,
//                'weid'=>$weid,
//			];
//            if( !empty($province_name) and !empty($city_name) and !empty($area_name) ){
//                $data['rg_all_area'] = $province_name.$city_name.$area_name;
//            }
//			if($id){
//                $data['rg_update_time']=time();
//                $res = pdo_update($this->rg,$data,['rg_id'=>$id]);
//			}else{
//                $data['rg_add_time']=time();
//                $res = pdo_insert($this->rg,$data);
//			}
//			if(empty($res)){
//				$this->message_info('操作失败');
//			}else{
//				$this->message_info('操作成功', $this->createWebUrl('district',['op'=>'area']), 'success');
//			}
//		}else{
//			if($id){
//				$info = pdo_get($this->rg,['rg_id'=>$id,'weid'=>$weid]);
//				$city = $this->getArea($info['rg_province_id']);//var_dump($city);exit();
//                $area = $this->getArea($info['rg_city_id']);
//			}
//		}
//        //首先获取省的信息
//        $province = $this->getArea();
//	break;
//    case 'areaDel':
//        if($id){
//            $res = pdo_update($this->rg,['rg_status'=>-1],['rg_id'=>$id,'weid'=>$weid]);
//            if($res){
//                echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
//            }else{
//                echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
//            }
//        }else{
//            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
//        }
//        break;
    case 'village':
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";

        //当从团长过来并关联小区时
        $act = $_GPC['act'];
        $mid = $_GPC['mid'];
        $openid = $_GPC['openid'];
        /******/

        //逻辑：小区名称是模糊查询
        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
            $where .= " and vg_name like '%".trim($_GPC['title'])."%'";
        }
        $team = trim($_GPC['team']);
        if(!empty($team) ) {
            $where .= " and (m.m_name like '%".$team."%' or m.m_nickname like '%".$team."%' or m.m_nickname  like '%".base64_encode($team)."%' )";
        }
        $location = trim($_GPC['location']);
        if(!empty($location) ) {
            $where .= " and (a.vg_address like '%".$location."%' or r.rg_all_area like '%".$location."%')";
        }

        //逻辑：上级地区是确定查询
        if(isset($_GPC['area']) && !empty($_GPC['area']) ) {
            $where .= " and vg_rg_id = '".Intval($_GPC['area'])."' ";
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->vg).' as a left join '. tablename($this->member) .' as m on  m.m_openid = a.openid and m_status = 1 left join '.tablename($this->rg).' as r on r.rg_id =  a.vg_rg_id and rg_status = 1 where a.weid='.$weid.' and  vg_status = 1 '.$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select a.*,m.m_nickname,m.m_name,m.m_openid,r.rg_id,r.* from ' . tablename($this->vg).' as a left join '. tablename($this->member) .' as m on  m.m_openid = a.openid and m_status = 1 left join '.tablename($this->rg).' as r on r.rg_id =  a.vg_rg_id and rg_status = 1 where a.weid='.$weid.' and vg_status = 1  '.$where."  order by vg_id desc ".$contion;
        $info = pdo_fetchall($sql);
        if(is_array($info)){
            foreach ($info as $k =>$v){
                if($this->check_base64_out_json( $v['m_nickname'] )){
                    $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );
                }
            }
        }
       // var_dump($sql);exit;
        //查上级地区
        $area = pdo_fetchall("select rg_name,rg_id from ".tablename($this->rg)." where weid=".$weid." and rg_status = 1 order by rg_id desc ;");
        break;
    case 'villageAdd':
        if($_GPC['submit'] == '提交'){
//var_dump($_POST);
            //提交数据
            //小区数据
            $team_name = trim($_GPC['team_name']);
            $address = trim($_GPC['address']);
            $lng = trim($_GPC['lng']);
            $lat = trim($_GPC['lat']);
//            $vg_id = trim($_GPC['vg_id']);
//            $self_address = trim($_GPC['self_address']);

            if(empty($team_name) ){
                $this->message_info('请输入店铺/小区名称');exit;
            }
            if(empty($address) || empty($lng) ||empty($lat) ){
                $this->message_info('请拾取输入小区地址');exit;
            }
            $data_vg = [
                'vg_name'=>$team_name,
                'vg_rg_id'=>$area,
                'vg_team_name'=>$team_name,
                'vg_address'=>$address,
                'vg_longitude'=>$lng,
                'vg_latitude'=>$lat,
                'vg_status'=>1,
//                'vg_pick_address'=>$self_address,
                'weid'=>$weid,
            ];
            //区域数据
            $province_name = trim($_GPC['province_name']);
            $city_name = trim($_GPC['city_name']);
            $area_name = trim($_GPC['area_name']);
            $province = Intval($_GPC['province']);
            $city = Intval($_GPC['city']);
            $areas = Intval($_GPC['areas']);
            $rg_id = trim($_GPC['rg_id']);
            //验证
            if(empty($province) ){
                $this->message_info('请选择省份');exit;
            }
            if(empty($city) ){
                $this->message_info('请选择城市');exit;
            }
            if(empty($areas) ){
                $this->message_info('请选择区/县');exit;
            }
            $data_rg = [
                'rg_province_id'=>$province,
                'rg_city_id'=>$city,
                'rg_area_id'=>$areas,
                'rg_status'=>1,
                'weid'=>$weid,
            ];
            if( !empty($province_name) and !empty($city_name) and !empty($area_name) ){
                $data_rg['rg_all_area'] = $province_name.','.$city_name.','.$area_name;
            }

            pdo_begin();
            //区域
            if($rg_id){
                $data_rg['rg_update_time']=time();
                $res_rg = pdo_update($this->rg,$data_rg,array('rg_id'=>$rg_id));
            }else{
                $data_rg['rg_add_time']=time();
                $res_rg = pdo_insert($this->rg,$data_rg,array('rg_id'=>$rg_id));
                if(empty($res_rg)){
                    pdo_rollback();
                    $this->message_info('操作失败');
                }
                $rg_id = pdo_insertid();
            }

            //小区
            if($id){
                $data_vg['vg_update_time']=time();
                $data_vg['vg_rg_id']=$rg_id;
                $res_vg = pdo_update($this->vg,$data_vg,array('vg_id'=>$id));
                $old = pdo_get($this->vg,array('vg_id'=>$id));
                if(!empty($old['openid'])){
                    pdo_update($this->vg,array('openid'=>''),array('openid'=>$old['openid']));
                    pdo_update($this->vg,array('openid'=>$old['openid']),array('vg_id'=>$id));
                    pdo_update($this->member,array('m_head_lng'=>$lng,'m_head_lat'=>$lat,'m_head_shop_name'=>$team_name,'m_head_address'=>$address),array('m_openid'=>$old['openid']));
                }

            }else{
                $data_vg['vg_add_time']=time();
                $data_vg['vg_rg_id']=$rg_id;
                $res_vg = pdo_insert($this->vg,$data_vg);
                if(empty($res_vg)){
                    pdo_rollback();
                    $this->message_info('操作失败');
                }
            }
//            var_dump($id); var_dump($res_rg);exit;
            if(empty($res_rg) && empty($res_vg) ){
                pdo_rollback();
                $this->message_info('操作失败');
            }else{
                pdo_commit();
                $this->message_info('操作成功', $this->createWebUrl('district'), 'success');
            }
        }else{
//            var_dump($id);
            $act_title='新增';
            if($id){
                $act_title='修改';
                $vg = pdo_get($this->vg,array('weid'=>$weid,'vg_id'=>$id));
                if(!empty($vg)){
                    $rg = pdo_get($this->rg,array('weid'=>$weid,'rg_id'=>$vg['vg_rg_id']));
                    $city = pdo_getall("gpb_area",array('pid'=>$rg['rg_province_id']));
                    $areas = pdo_getall("gpb_area",array('pid'=>$rg['rg_city_id']));
                }
            }
            $province = pdo_getall("gpb_area",array('pid'=>0));
        }
        //查上级地区
        $area = pdo_fetchall("select rg_name,rg_id from ".tablename($this->rg)." where weid=".$weid." and  rg_status = 1 order by rg_id desc ;");
        break;
    case 'villageDel':
        if($id){
            $res = pdo_update($this->vg,['vg_status'=>-1],['vg_id'=>$id,'weid'=>$weid]);
            if($res){
                echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
    case 'getArea':
        $id = $_GPC['area_id'];
        $rs = $this->getArea($id);
        echo json_encode($rs,JSON_UNESCAPED_UNICODE);
        exit;
        break;
    case 'cancelHead':
        if($id){
            $res = pdo_update($this->vg,['openid'=>""],['vg_id'=>$id,'weid'=>$weid]);
            if($res){
                echo json_encode(['status'=>0,'msg'=>'取消成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'取消失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法操作']);exit;
        }
        break;
}
include $this -> template('web/' . $do . '/' . $op);
?>