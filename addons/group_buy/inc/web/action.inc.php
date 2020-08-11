<?php
/*
 * 活动管理
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
$pre = $_W['config']['db']['tablepre'];
switch($op){
	case 'index':
        $name = $_GPC['name'];
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        //逻辑：活动名称是模糊查询
        if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
            $where .= " and  at_name like '%".trim($_GPC['name'])."%' ";
        }
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->action)." where at_is_del = 1 and weid =".$weid);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename($this->action)." where at_is_del = 1 and weid =".$weid.$where." order by at_order,at_id desc ".$contion;
//		var_dump($sql);
//		var_dump($weid);
		$info = pdo_fetchall($sql);
	break;
	case 'add':

		if($_GPC['submit'] == '提交'){
//            var_dump($_POST);exit;
			//提交数据
			$name = $_GPC['name'];
//			$brief = $_GPC['brief'];
			$action_start_time = $_GPC['action_time']['start'];
            $action_end_time = $_GPC['action_time']['end'];
            $get_start_time = $_GPC['get_time']['start'];
            $get_end_time = $_GPC['get_time']['end'];
			$order = $_GPC['order'];
            $is_show = 1;//$_GPC['is_show'];
            $is_limit = $_GPC['is_limit'];
            $is_kill= $_GPC['is_kill'];
            $is_kill = -1;//没有秒杀了
//            $see_num = $_GPC['see_num'];
            $at_arrival_time = $_GPC['at_arrival_time'];
            $at_arrival_time_text = $_GPC['at_arrival_time_text'];
            $at_is_head_open = $_GPC['is_head_open'];
            $action_pic=trim($_GPC['action_pic']);
//            var_dump($_GPC);exit;
			if(empty($name)){
                $this->message_info('请填写活动名称');exit;
//                echo json_encode(['status'=>1,'msg'=>'请填写活动名称']);exit;
			}
            if(empty($action_pic)){
                $this->message_info('请上传活动图片');exit;
//                echo json_encode(['status'=>1,'msg'=>'请填写活动名称']);exit;
            }
            if(empty($action_start_time) || empty($action_end_time)){
                $this->message_info('请填写活动时间');exit;
//                echo json_encode(['status'=>1,'msg'=>'请填写活动时间']);exit;
            }
            if($action_start_time > $action_end_time ){
                $this->message_info('活动起始时间不能超过终止时间');exit;
//                echo json_encode(['status'=>1,'msg'=>'活动起始时间不能超过终止时间']);exit;
            }
            if(empty($at_arrival_time) && $at_arrival_time!=0 ){
                $this->message_info('请填写或选择提货时间');exit;
//                echo json_encode(['status'=>1,'msg'=>'请填写或选择提货时间']);exit;
            }
//            if(empty($is_show) ){
//                $this->message_info('请选择是否首页显示');exit;
////                echo json_encode(['status'=>1,'msg'=>'请选择是否首页显示']);exit;
//            }
			$data = [
				'at_name'=>$name,
//				'at_brief'=>$brief,
				'at_start_time'=>strtotime($action_start_time),
				'at_end_time'=>strtotime($action_end_time),
//				'at_start_send_time'=>strtotime($get_start_time),
//				'at_end_send_time'=>strtotime($get_end_time),
                'at_order'=>$order,
				'at_is_index_show'=>$is_show,
                'at_is_limit'=>$is_limit,
                'at_is_seckill'=>$is_kill,
//                'at_see_num'=>$see_num,
                'at_arrival_time'=>$at_arrival_time,
                'at_arrival_time_text'=>$at_arrival_time_text,
                'at_is_head_open'=>$at_is_head_open,
                'weid'=>$weid,
                'action_pic'=>$action_pic
			];

			if($id){
			    $data['at_update_time'] = time();
			    //当活动改为不限制小区就删除掉活动小区对应关系，不然商品会重复
			    if($is_limit==1){
                    pdo_delete('gpb_action_village',array('weid'=>$weid,'gav_ac_id'=>$id));
                }
				$res = pdo_update($this->action,$data,['at_id'=>$id]);
                $url = $this->createWebUrl('action');
            }else{
                $data['at_add_time'] = time();
				$res = pdo_insert($this->action,$data);
                $url = $this->createWebUrl('action',array('op'=>'add','id'=>$id));
            }
			if(empty($res)){
                $this->message_info('操作失败');
			}else{
				cache_updatecache();//更新缓存
                $this->message_info('操作成功', $this->createWebUrl('action'), 'success');
			}
		}else{
            $act_title = '新增';
			if($id){
                $act_title = '修改';
				$info = pdo_get($this->action,['at_id'=>$id,'weid'=>$weid]);
//				var_dump($info);
			}
		}
	break;
		//快捷设置排序
	case 'setOrder':
	    $id =  trim($_GPC['id']);
	    if(empty($id)){
            echo json_encode(array('status'=>1,'msg'=>'参数错误','url'=>''));exit;
        }
        $val = trim($_GPC['val']);
        if(empty($val)){
            echo json_encode(array('status'=>1,'msg'=>'未传入修改的值','url'=>''));exit;
        }
        $res = pdo_update($this->action,['at_order'=>$val],['at_id'=>$id,'weid'=>$weid]);
        if(empty($res)){
            echo json_encode(['status'=>1,'msg'=>'快捷设置排序失败']);exit;
        }else{
            echo json_encode(['status'=>0,'msg'=>'快捷设置排序成功']);exit;
        }
	break;
	    //删除活动
	case 'del':
		if($id){
		    $id = trim($id,',');
		    $id_arr = explode(",",$id);
            foreach ($id_arr as $v){
                $res = pdo_update($this->action,array('at_is_del'=>-1),array('at_id'=>$v,'weid'=>$weid));
            }
//		    if(count($id_arr) > 1){
//                $res = pdo_update($this->action,['at_is_del'=>-1],['at_id'=>$id,'weid'=>$weid]);
//            }else{
//                $res = pdo_update($this->action,['at_is_del'=>-1],['at_id in'=>$id,'weid'=>$weid]);
//            }
			if($res){
				echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
			}else{
				echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
			}
		}else{
			echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
		}
	break;
    case 'seeVillage':
        $ac_id = $_GPC['id'];
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //逻辑：活动id必须 要并表
        if(!isset($ac_id) && empty($ac_id) ) {
            echo json_encode(['status'=>1,'msg'=>'参数错误']);exit;
        }
        //逻辑：小区名称是模糊查询
        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
            $where .= " and vg_name like '%".trim($_GPC['title'])."%' ";
        }
        if(!empty($team) ) {
            $where .= " and (m.m_name like '%".$team."%' or m.m_nickname like '%".$team."%')";
        }
        $location = trim($_GPC['location']);
        if(!empty($location) ) {
            $where .= " and (a.vg_address like '%".$location."%' or r.rg_all_area like '%".$location."%')";
        }

        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->vg).' as a left join '. tablename($this->member) .' as m on  m.m_openid = a.openid and m_status = 1 left join '.tablename($this->rg).' as r on r.rg_id =  a.vg_rg_id and rg_status = 1 where a.weid='.$weid.' and  vg_status = 1 '.$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select a.*,m.m_nickname,m.m_name,m.m_openid,r.rg_id,r.rg_name,r.rg_all_area,av.gav_ac_id,av.gav_id from ' . tablename($this->vg).' as a left join '. tablename($this->member) .' as m on  m.m_openid = a.openid and m_status = 1 left join '.tablename($this->rg).' as r on r.rg_id =  a.vg_rg_id and rg_status = 1 left join '.tablename($this->action_village).' as av  on av.gav_v_id = a.vg_id and gav_ac_id = '.$ac_id.' where a.weid='.$weid.' and vg_status = 1 '.$where."  order by gav_id desc,vg_id desc ".$contion;
        $info = pdo_fetchall($sql);
        foreach ($info as $k=>$v){
            if($this->check_base64_out_json( $v['m_nickname'] )){
                $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );
            }
        }
//         var_dump($sql);
//         exit;
        //查上级地区
        $area = pdo_fetchall("select rg_name,rg_id from ".tablename($this->rg)." where weid=".$weid." and rg_status = 1 order by rg_id desc ;");
        break;
    case 'linkVillage':
        $act = trim($_GPC['act']);
        $id = trim($_GPC['id']);
        $vid = trim($_GPC['vid'],',');

        if(empty($act) || empty($id) || empty($vid)) {
            echo json_encode(['status'=>1,'msg'=>'参数错误']);exit;
        }
        $vid = explode(",",$vid);
        pdo_begin();
        foreach ($vid as $k => $v){
            $data = [
                'gav_ac_id' => $id,
                'gav_v_id' => $v,
                'weid'=>$weid
            ];
            if( $act == 'add'){
                $res = pdo_get($this->action_village,$data);
                if(empty($res)){
                    $res = pdo_insert($this->action_village,$data);
                }
            }elseif($act == "cancel"){
                $res = pdo_get($this->action_village,$data);
                if(!empty($res)) {
                    $res = pdo_delete($this->action_village, $data);
                }
            }else{
                pdo_rollback();
                echo json_encode(['status'=>1,'msg'=>'非法操作']);exit;
            }

        }
        if(!empty($res)){
            pdo_commit();
            echo json_encode(['status'=>0,'msg'=>'操作成功']);exit;
        }

    case 'seeGoods':
        $ac_id = trim($_GPC['id']);
        //逻辑：活动id必须 要并表
        if(!isset($ac_id) && empty($ac_id) ) {
            echo json_encode(['status'=>1,'msg'=>'参数错误']);exit;
        }
        //检查缓存
//        方案一：使用递归后缓存，
        $cate  = cache_load('goods_cate'.$weid);
        if(empty($cate)) {
            $data = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$this->weid." and gc_is_del = 1 order by gc_pid asc,gc_order asc;");
            $cate = $this->getTree($data,"gc_id","gc_pid");
            cache_write('goods_cate',$cate);
        }

        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //逻辑：商品货号是模糊查询
        if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
            $where .= " and  g_product_num like '%".trim($_GPC['num'])."%' ";

        }
        //商品id
        if(isset($_GPC['g_id']) && !empty($_GPC['g_id']) ) {
            $where .= " and  g_id =".trim($_GPC['g_id']);

        }
        //逻辑：商品名称是模糊查询
        if( isset($_GPC['title']) and !empty($_GPC['title']) ) {
            $where .= " and  g_name like '%".trim($_GPC['title'])."%' ";
        }
        //逻辑：商品分类是确定查询
        if( isset($_GPC['pid']) and !empty($_GPC['pid']) ) {
            $where .= " and  gtc.cate_id = '".trim($_GPC['pid'])."' ";
        }
        //逻辑：商品状态是确定查询
        if( isset($_GPC['status']) and !empty($_GPC['status']) ) {
            $where .= " and  g_is_online = '".trim($_GPC['status'])."' ";
        }
        //商品价格
        if( isset($_GPC['min_price']) and !empty($_GPC['min_price']) ) {
            $where .= " and  g_price > '".trim($_GPC['min_price'])."' ";
        }
        if( isset($_GPC['max_price']) and !empty($_GPC['max_price']) ) {
            $where .= " and  g_price < '".trim($_GPC['max_price'])."' ";
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(t.g_id) from (select g.*  from '.tablename($this->goods)." as g left join ".tablename('gpb_goods_to_category')." as gtc on gtc.goods_id = g.g_id left join ".tablename($this->goods_cate)." as c on c.gc_id=gtc.cate_id  left join ".tablename($this->goods_stock)." as s on s.goods_id = g.g_id left join ".tablename($this->action_goods)." as ag on ag.gcg_g_id = g.g_id where g.weid=".$weid." and g_is_del = 1 and g_is_head_enjoy=-1  ".$where." and (g.`type`<>2 or g.`type` is null) group by s.goods_id ) as t");
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select g.*,c.gc_name,c.gc_id,s.num as sum,GROUP_CONCAT(gcg_at_id) AS isaction,group_concat(s.sale_num) as sum_sale,ag.gcg_at_id,ag.gcg_id  from '.tablename($this->goods)." as g left join ".tablename('gpb_goods_to_category')." as gtc on gtc.goods_id = g.g_id left join ".tablename($this->goods_cate)." as c on c.gc_id=gtc.cate_id  left join ".tablename($this->goods_stock)." as s on s.goods_id = g.g_id left join ".tablename($this->action_goods)." as ag on ag.gcg_g_id = g.g_id where g.weid=".$weid." and g_is_del = 1  and g_is_head_enjoy=-1  ".$where." and (g.`type`<>2 or g.`type` is null) group by s.goods_id order by gcg_at_id desc, g.g_id desc,g_is_online desc,g_id desc ".$contion;
//      $sql = 'select g.*,c.gc_name,c.gc_id,group_concat(s.num) as sum,GROUP_CONCAT(gcg_at_id) AS isaction,group_concat(s.sale_num) as sum_sale,ag.gcg_at_id,ag.gcg_id  from '.tablename($this->goods)." as g left join ".tablename('gpb_goods_to_category')." as gtc on gtc.goods_id = g.g_id left join ".tablename($this->goods_cate)." as c on c.gc_id=gtc.cate_id  left join ".tablename($this->goods_stock)." as s on s.goods_id = g.g_id left join ".tablename($this->action_goods)." as ag on ag.gcg_g_id = g.g_id where g.weid=".$weid." and g_is_del = 1  ".$where." and (g.`type`<>2 or g.`type` is null) group by s.goods_id order by gcg_at_id desc, g.g_id desc,g_is_online desc,g_id desc ".$contion;
//		echo $sql;exit;
        $info = pdo_fetchall($sql);
        foreach ($info as &$v){
            $cate_link = pdo_getall('gpb_goods_to_category',array('weid'=>$weid,'goods_id'=>$v['g_id']));
            $cate_str = '';
            if(is_array($cate_link)){
                foreach ($cate_link as $val){
                    $cate_str .=','.$val['cate_id'];
                }
            }
            $v['cate'] = trim($cate_str,',');
            unset($v);
        }
//        var_dump($sql);exit;
        break;
    case 'linkGoods':
        $act = trim($_GPC['act']);
        $id = trim($_GPC['id']);
        $gid = trim($_GPC['gid'],',');
        //当是一键参与时
        if ($_GPC['type']=='all'){
            $sql = 'select g.g_id  from '.tablename($this->goods)." as g where g.weid=".$weid." and g_is_del = 1   and g_is_head_enjoy=-1 and (g.`type`<>2 or g.`type` is null) ";
            $info = pdo_fetchall($sql);
            foreach ($info as $v){
                $gid .= ','.$v['g_id'];
            }
        }
        $gid = trim($gid,',');
        if(empty($act) || empty($id) || empty($gid)) {
            echo json_encode(['status'=>1,'msg'=>'参数错误']);exit;
        }
        $gid = explode(",",$gid);
        pdo_begin();
        foreach ($gid as $k => $v){
            $data = [
                'gcg_at_id' => $id,
                'gcg_g_id' => $v,
                'weid'=>$weid
            ];
            if( $act == 'add'){
                $res = pdo_get($this->action_goods,$data);
                if(empty($res)){
                    $res = pdo_insert($this->action_goods,$data);
                }
            }elseif($act == "cancel"){
                $res = pdo_get($this->action_goods,$data);
                if(!empty($res)) {
                    $res = pdo_delete($this->action_goods, $data);
                }
            }else{
                pdo_rollback();
                echo json_encode(['status'=>1,'msg'=>'非法操作']);exit;
            }
//            if(empty($res)){
//                pdo_rollback();
//                echo json_encode(['status'=>1,'msg'=>'操作失败']);exit;
//            }
        }
        if(!empty($res)){
            pdo_commit();
            echo json_encode(['status'=>0,'msg'=>'操作成功']);exit;
        }
//        else{
//            pdo_rollback();
//            echo json_encode(['status'=>1,'msg'=>'操作失败']);exit;
//        }
        exit;
        break;
    case 'setHeadOpen':
        if($id){
            $code = intval($_GPC['code']);
            $res = pdo_update($this->action,array('at_is_head_open'=>$code),array('at_id'=>$id,'weid'=>$weid) );
            if(!empty($res)){
                echo json_encode(['status'=>0,'msg'=>'操作成功']);
                exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'操作失败']);exit;
            }
            exit();
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法操作']);exit;
        }
        break;
    case 'reduction':
        //满减
        if($_GPC['submit'] == '提交'){
            //提交数据
            unset($_POST['submit']);
            pdo_begin();
            foreach ($_POST as $k =>$v){
                $sql = "update ".tablename($this->config)." set value = '".$v."',time=".time()." where id =".$k;
                $res = pdo_query($sql);
            }
            pdo_commit();
            if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('action',array('op'=>'reduction')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
        }else{
            //是否开启满减
            $open_full_reduction = pdo_get($this->config,array('key'=>'open_full_reduction','weid'=>$weid));
            if(empty($open_full_reduction) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启满减','2','13',".time().",".$weid.",1,'open_full_reduction');");
            }
            //满足减价的限制条件
            $full_reduction_limit_price = pdo_get($this->config,array('key'=>'full_reduction_limit_price','weid'=>$weid));
            if(empty($full_reduction_limit_price) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('满足减价的限制条件','0','13',".time().",".$weid.",1,'full_reduction_limit_price');");
            }
            //减少的价格
            $full_reduction_price = pdo_get($this->config,array('key'=>'full_reduction_price','weid'=>$weid));
            if(empty($full_reduction_price) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('减少的价格','0','13',".time().",".$weid.",1,'full_reduction_price');");
            }
            $open_full_reduction = pdo_get($this->config,array('key'=>'open_full_reduction','weid'=>$weid));
            $full_reduction_limit_price = pdo_get($this->config,array('key'=>'full_reduction_limit_price','weid'=>$weid));
            $full_reduction_price = pdo_get($this->config,array('key'=>'full_reduction_price','weid'=>$weid));
        }
        break;
}
include $this -> template('web/' . $do . '/' . $op);
?>