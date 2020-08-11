<?php
/*
 * 供应商管理
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块

switch($op){
	case 'index':
        $name = $_GPC['name'];
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        //名称模糊查询
        if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
            $where .= " and  (gsp_name like '%".trim($_GPC['name'])."%' or gsp_shop_name like '%".trim($_GPC['name'])."%' )";
        }
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->supplier)." where gsp_is_del = 1 and weid =".$weid.$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
        $supplier_role = pdo_get('gpb_supplier',array('weid'=>$weid,'uid'=>$_W['uid']));
        if(!empty($supplier_role)){
            $this->supplier_role=1;
        }
        if( $this->supplier_role==1 ){
            $sql = 'select * from '.tablename($this->supplier)." as s left join ".tablename($this->member)." as m on m.m_openid = s.openid where gsp_is_del = 1 and s.weid =".$weid.$where." and s.uid={$_W['uid']} order by gsp_order,gsp_id desc ".$contion;
        }else{
            $sql = 'select * from '.tablename($this->supplier)." as s left join ".tablename($this->member)." as m on m.m_openid = s.openid where gsp_is_del = 1 and s.weid =".$weid.$where." order by gsp_order,gsp_id desc ".$contion;
        }

		$info = pdo_fetchall($sql);
		foreach ($info as $k =>$v){
            $info[$k]['count']  = pdo_fetchcolumn("select count(*) from ".tablename($this->goods)." where g_supplier_id=".$v['gsp_id']);

                    if($this->check_base64_out_json( $v['m_nickname'] )){
                        $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );
                    }

        }
	break;
	case 'add':
//获取分页信息
        $supplier_role = pdo_get('gpb_supplier',array('weid'=>$weid,'uid'=>$_W['uid']));
        if(!empty($supplier_role)){
            $this->supplier_role=1;
        }
		if($_GPC['submit'] == '提交'){
			//提交数据
            $name = trim($_GPC['name']);
            $shop_name = trim($_GPC['shop_name']);
            $phone = trim($_GPC['phone']);
//            $comment = trim($_GPC['comment']);
            $is_show = trim($_GPC['is_show']);
//            $order = trim($_GPC['order']);
            $gsp_server_fee = trim($_GPC['gsp_server_fee']);
            $gsp_account = trim($_GPC['gsp_account']);
            $gsp_pwd = trim($_GPC['gsp_pwd']);
            $repassword = trim($_GPC['repassword']);
            $gsp_icon = trim($_GPC['gsp_icon']);
            $openid = $_GPC['openid'];
            $ids = $_GPC['ids'];
			if(empty($shop_name)){
                $this->message_info('请填写供应商名称');exit;
			}
            if(empty($name) ){
                $this->message_info('请输入负责人名称');exit;
            }
            if(empty($phone) ){
                $this->message_info('请输入联系电话');exit;
            }
            if(empty($is_show) ){
                $this->message_info('请选择是否冻结');exit;
            }
            if( $this->supplier_role !=1){
                if(empty($gsp_server_fee) && $gsp_server_fee!=0){
                    $this->message_info('请输入平台技术费');exit;
                }
            }
            if(empty($gsp_account) ){
                $this->message_info('请输入登录帐号');exit;
            }

			$data = [
				'gsp_name'=>$name,
				'gsp_shop_name'=>$shop_name,
				'gsp_phone'=>$phone,
//				'gsp_comment'=>$comment,
                'gsp_status'=>$is_show,
//                'gsp_order'=>$order,
                'gsp_account'=>$gsp_account,
                'gsp_icon'=>$gsp_icon,
                'weid'=>$weid
			];
            if( $this->supplier_role !=1){
                $data['gsp_server_fee']=$gsp_server_fee;
            }
            pdo_begin();
			if($id){
			    $data['gsp_update_time'] = time();
			    $data_wq['username'] = $gsp_account;
			    $old = pdo_get($this->supplier,array('gsp_id'=>$id));
                if(!empty($gsp_pwd)  ){
                    if($gsp_pwd == $repassword){
                        $data['gsp_pwd'] = $gsp_pwd;
                        $user = pdo_get('users',array('uid'=>$old['uid']));
                        $newpwd = user_hash($gsp_pwd, $user['salt']);
                        $data_wq['password'] = $newpwd;
//                        var_dump($user);var_dump($gsp_pwd);var_dump($repassword);var_dump($data_wq);exit;
                    }else{
                        $this->message_info('两次输入的密码不匹配');exit;
                    }
                }
                //微擎帐号修改
                if(empty($old['uid'])){
                    $user_founder = array(
                        'username' => $gsp_account, //帐号
                        'password' => $gsp_pwd, //密码
                        'repassword' => $_GPC['repassword'],//重复密码
                        'remark' => '社区团购供应商帐号',
                        'groupid' => 0,
                        'starttime' => TIMESTAMP,
                    );
                    $user_add = user_info_save($user_founder);
                    if (is_error($user_add)) {
                        pdo_rollback();
                        $this->message_info($user_add['message']);exit;
                    }
                    $data['uid']=$user_add['uid'];
                }else{
                    $result = pdo_update('users', $data_wq, array('uid' => $old['uid']));
                }
				$res = pdo_update($this->supplier,$data,['gsp_id'=>$id]);
                $url = $this->createWebUrl('supplier');

            }else{
                $data['gsp_add_time'] =$data['gsp_deal_time'] = time();
                if(empty($gsp_pwd) ){
                    $this->message_info('请输入登录密码');exit;
                }
                if(!empty($gsp_pwd) && $gsp_pwd != $repassword ){
                    $this->message_info('两次输入的密码不匹配');exit;
                }
                $data['gsp_pwd'] = $gsp_pwd;

                $url = $this->createWebUrl('supplier',array('op'=>'add','gsp_id'=>$id));
                //微擎帐号新增
                $user_founder = array(
                    'username' => $gsp_account, //帐号
                    'password' => $gsp_pwd, //密码
                    'repassword' => $_GPC['repassword'],//重复密码
                    'remark' => '社区团购供应商帐号',
                    'groupid' => 0,
                    'starttime' => TIMESTAMP,
//                'endtime' => intval(strtotime($_GPC['endtime'])),//到期时间
//                'owner_uid' => !empty($vice_founder_name) ? $vice_founder_info['uid'] : !user_is_vice_founder($_W['uid']) ? 0 : $_W['uid'],
                );
                $user_add = user_info_save($user_founder);




                if (is_error($user_add)) {
                    pdo_rollback();
                    $this->message_info($user_add['message']);exit;
                }
                $data['uid']=$user_add['uid'];
                $res = pdo_insert($this->supplier,$data);
                $id = pdo_insertid();
            }
            if( is_array($ids) ){
                pdo_delete('gpb_supplier_manger',array('gsp_id'=>$id));
                foreach ($ids as $k=> $v){
                    $data_manger = array(
                        'openid'=>isset($openid[$k])?$openid[$k]:'',
                        'm_id'=>$v,
                        'gsp_id'=>$id,
                        'weid'=>$weid,
                    );
                    pdo_insert('gpb_supplier_manger',$data_manger);
                }
            }
            //存入微擎的用户 todo
            //加微擎权限
            $old_auth = pdo_get('uni_account_users',array('uniacid'=>$weid,'uid'=>$user_add['uid']));
            if(empty($old_auth)){
                pdo_insert('uni_account_users',array('uniacid'=>$weid,'uid'=>$user_add['uid'],'role'=>'operator','rank'=>0));
            }else{
                pdo_update('uni_account_users',array('uniacid'=>$weid,'uid'=>$user_add['uid'],'role'=>'operator','rank'=>0),array('id'=>$old_auth['id']));
            }
            //加平台权限
            $old_auth_app = pdo_get('gpb_menu',array('uid'=>$user_add['uid']));
            if(empty($old_auth_app)){
                pdo_insert('gpb_menu',array('uid'=>$user_add['uid'],'value'=>'82,50,51,58,59','time'=>time(),'status'=>1));

            }else{
                pdo_update('gpb_menu',array('uid'=>$user_add['uid'],'role'=>'82,50,51,58,59','time'=>time(),'status'=>1),array('id'=>$old_auth_app['id']));
            }
			if(empty($res)){
			    pdo_rollback();
                $this->message_info('操作失败');
//                echo json_encode(array('status'=>1,'msg'=>'操作失败','url'=>''));exit;
			}else{
			    //当修改冻结供应商时，要同步清理相关的 商品数据
                if($id && $is_show == 2){
                    pdo_update($this->goods,array('g_supplier_id'=>''),array('weid'=>$weid,'g_supplier_id'=>$id));
                }
                pdo_commit();
                $this->message_info('操作成功', $this->createWebUrl('supplier'), 'success');
//                echo json_encode(array('status'=>0,'msg'=>'操作成功','url'=>$url));exit;
			}
		}else{
            $act_title = '新增';
			if($id){
                $act_title = '修改';
				$info = pdo_get($this->supplier,['gsp_id'=>$id,'weid'=>$weid]);
				$manger = pdo_fetchall("select m.* from ".tablename('gpb_supplier_manger')." as sm left join ".tablename($this->member)." as m on m.m_id=sm.m_id where sm.gsp_id=".$info['gsp_id']);

				$ids = '';
				if(is_array($manger)){
				    foreach ($manger as $v){
                        $ids .=','.$v['m_id'];
                        if($this->check_base64_out_json( $v['m_nickname'] )){
                            $manger[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );
                        }
                    }
                }
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
        $res = pdo_update($this->supplier,['gsp_order'=>$val],['gsp_id'=>$id,'weid'=>$weid]);
        if(empty($res)){
            echo json_encode(['status'=>1,'msg'=>'快捷设置排序失败']);exit;
        }else{
            echo json_encode(['status'=>0,'msg'=>'快捷设置排序成功']);exit;
        }
	break;
    case 'deal_action':
        if($id){
            $val = trim($_GPC['val']);
            $old_status =  trim($_GPC['status']);
            $data['gsp_status'] = $val;
            if($old_status ==-1){
                $data['gsp_deal_time'] = time();
            }
            $res = pdo_update($this->supplier,$data,array('gsp_id'=>$id,'weid'=>$weid));
            if($res){
                echo json_encode(['status'=>0,'msg'=>'设置成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'设置失败']);exit;
            }

        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
    case 'all_deal_action':
        if($id){
            $id = trim($_GPC['id'],',');
            $val = trim($_GPC['val'],',');
            $old_status =  trim($_GPC['status'],',');
            $id_arr = explode(',',$id);
            $old_status_arr = explode(',',$old_status);
            foreach ($id_arr as $k =>$v){
                $data['gsp_status'] = $val;
                if($old_status_arr[$k] ==-1){
                    $data['gsp_deal_time'] = time();
                }
                $res = pdo_update($this->supplier,$data,array('gsp_id'=>$v,'weid'=>$weid));
            }
            if($res){
                echo json_encode(['status'=>0,'msg'=>'设置成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'设置失败']);exit;
            }

        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
	    //删除活动
	case 'del':
		if($id){
		    $id = trim($id,',');
		    $id_arr = explode(",",$id);
		    if(count($id_arr) > 1){
                $res = pdo_update($this->supplier,['gsp_is_del'=>-1],['gsp_id'=>$id,'weid'=>$weid]);
            }else{
                $res = pdo_update($this->supplier,['gsp_is_del'=>-1],['gsp_id in'=>$id,'weid'=>$weid]);
            }
			if($res){
				echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
			}else{
				echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
			}
		}else{
			echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
		}
	break;
    case 'config':
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
                $this->message_info("修改配置成功",$this->createWebUrl('supplier',array('op'=>'config')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
//            $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'commission')), 'success');
        }else{
            //申请团长时的申请条款
            $apply_supplier_text =  pdo_get($this->config,array('key'=>'apply_supplier_text','weid'=>$weid));
            if(empty($apply_supplier_text) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('申请供应商时申请条款','','9',".time().",".$weid.",1,'apply_supplier_text');");
            }
            //申请团长时引导优化图片显示
            $apply_supplier_img =  pdo_get($this->config,array('key'=>'apply_supplier_img','weid'=>$weid));
            if(empty($apply_supplier_img) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('引导申请广告图','','9',".time().",".$weid.",1,'apply_supplier_img');");
            }
            //设置是否审核添加商品
            $open_supplier_add_goods =  pdo_get($this->config,array('key'=>'open_supplier_add_goods','weid'=>$weid));
            if(empty($open_supplier_add_goods) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否审核添加商品','1','9',".time().",".$weid.",1,'open_supplier_add_goods');");
            }
            //设置是否审核编辑商品
            $open_supplier_edit_goods =  pdo_get($this->config,array('key'=>'open_supplier_edit_goods','weid'=>$weid));
            if(empty($open_supplier_edit_goods) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否审核编辑商品','1','9',".time().",".$weid.",1,'open_supplier_edit_goods');");
            }
            $info = pdo_getall($this->config,['status'=>1,'type'=>9,'weid'=>$weid],array(),"key");
        }
        break;
    case 'getUser':
        //选取操作管理员
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 5;

        $where = " ";
        //逻辑：昵称是模糊查询
        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
            $where .= " and ( m_nickname like '%".trim($_GPC['title'])."%'  or m_phone like '%".trim($_GPC['title'])."%') ";
        }
        if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
            $where .= " and  m_id =".trim($_GPC['num'])." ";
        }
        $ids = trim($_GPC['ids'],',');
        $ids_arr =array();
        if(!empty($ids) ) {
           $ids_arr = explode(",",$ids);
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->member)." where weid=".$weid." and m_status = 1 and m_nickname is not null ".$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select * from '.tablename($this->member)." where weid=".$weid." and m_status = 1  ".$where." and m_nickname is not null  order by m_id desc ".$contion;
        $info = pdo_fetchall($sql);
        if(is_array($info)){
            foreach ($info as $k=>$v){
                if($this->check_base64_out_json( $v['m_nickname'] )){
                    $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );
                }
            }
        }
        break;

}
include $this -> template('web/' . $do . '/' . $op);
?>