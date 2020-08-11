<?php
/**
 * 团长推广
 */
 
switch($in){
	case 'index':
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        //当从小区过来并设置团长时
        $act = $_GPC['act'];
        $vg = $_GPC['vg_id'];
        /******/
        $where = "  ";
        //逻辑：昵称是模糊查询
        if(isset($_GPC['key']) && !empty($_GPC['key']) ) {
            $where .= " and (m_id like '%".trim($_GPC['key'])."%' or m_nickname like '%".trim($_GPC['key'])."%' or m_name like '%".trim($_GPC['key'])."%' or m_phone like '%".trim($_GPC['key'])."%')";
        }
        //逻辑：昵称是模糊查询
//        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
//            $where .= " and m_nickname like '%".trim($_GPC['title'])."%' ";
//        }
//        //逻辑：姓名是模糊查询
//        if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
//            $where .= " and m_name like '%".trim($_GPC['name'])."%' ";
//        }
//        //逻辑：手机是模糊查询
//        if(isset($_GPC['phone']) && !empty($_GPC['phone']) ) {
//            $where .= " and m_phone like '%".trim($_GPC['name'])."%' ";
//        }
        //当小区来选择团长时
        if (!empty($vg)){
            $where .= " and v.openid is null ";
        }
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(*) from '.tablename($this->member)." as m left join ".tablename($this->vg)." as v on v.openid=m.m_openid left join ".tablename($this->rg)." as rg on rg.rg_id = v.vg_rg_id where m_status = 1  and m_is_head =2 ".$where." and m.weid=".$weid."  order by m_id desc ");
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename($this->member)." as m left join ".tablename($this->vg)." as v on v.openid=m.m_openid left join ".tablename($this->rg)." as rg on rg.rg_id = v.vg_rg_id where m_status = 1  and m_is_head =2 ".$where." and m.weid=".$weid."  order by m_id desc ".$contion;
		$info = pdo_fetchall($sql);
		//var_dump($info);exit;
	break;
	case 'add':
		if($_GPC['submit'] == '提交'){
			//提交数据
            //团长数据
			$phone = trim($_GPC['phone']);
			$name = trim($_GPC['name']);
			$commission = floatval($_GPC['commission']);
            $account = trim($_GPC['account']);
            $info = trim($_GPC['info']);
            $m_is_have_limit_pay = trim($_GPC['m_is_have_limit_pay']);
            $m_limit_pay = trim($_GPC['m_limit_pay']);

            if(empty($name) ){
                $this->message_info('请填写姓名');exit;
            }
            if(!preg_match("/^1[3456789]\d{9}$/", $phone)){
                $this->message_info('请填写正确的手机号');exit;
            }
            if((empty($commission) && $commission!=0) || $commission < 0 || $commission > 100 ){
                $this->message_info('请输入1到100正确的数，最多保留2位小数');exit;
            }

            //小区数据
            $team_name = trim($_GPC['team_name']);
            $address = trim($_GPC['address']);
            $lng = trim($_GPC['lng']);
            $lat = trim($_GPC['lat']);
            $vg_id = trim($_GPC['vg_id']);
//            $self_address = trim($_GPC['self_address']);

            if(empty($team_name) ){
                $this->message_info('请输入店铺/小区名称');exit;
            }
            if(empty($address) || empty($lng) ||empty($lat) ){
                $this->message_info('请拾取输入小区地址');exit;
            }

            //区域数据
            $province_name = trim($_GPC['province_name']);
            $city_name = trim($_GPC['city_name']);
            $area_name = trim($_GPC['area_name']);
            $province = Intval($_GPC['province']);
            $city = Intval($_GPC['city']);
            $area = Intval($_GPC['area']);
            $rg_id = trim($_GPC['rg_id']);
            //验证
            if(empty($province) ){
                $this->message_info('请选择省份');exit;
            }
            if(empty($city) ){
                $this->message_info('请选择城市');exit;
            }
            if(empty($area) ){
                $this->message_info('请选择区/县');exit;
            }
            $data_rg = [
                'rg_province_id'=>$province,
                'rg_city_id'=>$city,
                'rg_area_id'=>$area,
                'rg_status'=>1,
                'weid'=>$weid,
            ];

			$data_team = [
				'm_phone'=>$phone,
				'm_name'=>$name,
				'm_commission'=>$commission,
                'm_wx_account'=>$account,
                'm_comment'=>$info,
                'weid'=>$weid,
                'm_head_shop_name'=>$team_name,
                'm_head_address'=>$address,
                'm_head_lng'=>$lng,
                'm_head_lat'=>$lat,
                'm_is_have_limit_pay'=>$m_is_have_limit_pay,
                'm_limit_pay'=>$m_limit_pay
			];

            if( !empty($province_name) and !empty($city_name) and !empty($area_name) ){
                $data_rg['rg_all_area'] = $province_name.','.$city_name.','.$area_name;
                $data_team['m_last_location'] = $province_name.','.$city_name.','.$area_name;
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



            pdo_begin();
            //团长
			if($id){
				$res_m = pdo_update($this->member,$data_team,array('m_id'=>$id));

			}else{
			    pdo_rollback();
                $this->message_info('无法新增用户');
			}
			$head_info = pdo_get($this->member,array('m_id'=>$id));
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
            if($vg_id){
                $data_vg['vg_update_time']=time();
                $data_vg['vg_rg_id']=$rg_id;
                $data_vg['openid']=$head_info['m_openid'];
                $res_vg = pdo_update($this->vg,$data_vg,array('vg_id'=>$vg_id));
            }else{
                $data_vg['vg_add_time']=time();
                $data_vg['vg_rg_id']=$rg_id;
                $data_vg['openid']=$head_info['m_openid'];
                $res_vg = pdo_insert($this->vg,$data_vg);
                if(empty($res_vg)){
                    pdo_rollback();
                    $this->message_info('操作失败');
                }
            }

            //推荐团长相关和建立团队
            $pid = trim($_GPC['pid']);

            if(!empty($pid)){
                //读取配置
                $head_recommend_open = pdo_get($this->config,array('key'=>'head_recommend_open','weid'=>$weid));
                if(isset($head_recommend_open['value']) && $head_recommend_open['value']==1){
                    //组成分销团队
                    $uid = $id;
                    //当有推荐团长时，
                    $bind_res = $this->headbingteam($uid,$pid);
                    if($bind_res['code']==0){
                        //绑定成功,记录推荐
                        $this->commond_set_log($uid,$pid);
                    }

                    //存日志
                    $file  = dirname(__FILE__).'/headbing.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
                    if(file_exists($file) && filesize($file) > 100000){
                        unlink($file);//这里是直接删除，
                    }
                    $content = date('Y-m-d H:i:s');
                    $content .= "编辑详情改变推荐,pid={$pid},uid={$uid}\n";
                    foreach ($bind_res as $k=>$v){
                        $content .= "{$k}={$v}\n";
                        if($k == 'data'){
                            foreach ($bind_res[$k] as $kk=>$vv){
                                $content .= "{$kk}={$vv}\n";
                            }
                        }

                    }
                    $content .= "------\n";
                    file_put_contents($file,$content.PHP_EOL,FILE_APPEND);
                }

            }

            //自己建立团队
            $team_info = pdo_get("gpb_head_group",['weid'=>$this->weid,'status'=>1,'leader_id'=>$id]);
            if(empty($team_info)){
                pdo_insert("gpb_head_group",['weid'=>$this->weid,'leader_id'=>$id,'create_time'=>time(),'update_time'=>time(),'status'=>1]);
            }
			if(empty($res_m) && empty($res_rg) && empty($res_vg) ){
			    pdo_rollback();
                $this->message_info('操作失败');
			}else{
			    pdo_commit();
                $this->message_info('操作成功', $this->createWebUrl('plsugins',array('op'=>'extension')), 'success');
			}
		}else{
            $act_title='新增';
            //读取是否开启推荐团长选项
            $head_recommend_open = pdo_get($this->config,array('key'=>'head_recommend_open','weid'=>$weid));
            $recommend_open = isset($head_recommend_open['value'])?$head_recommend_open['value']:2;//默认关闭
			if($id){
                $act_title='修改';
				$info = pdo_get($this->member,array('m_id'=>$id,'weid'=>$weid));
				$vg = pdo_get($this->vg,array('weid'=>$weid,'openid'=>$info['m_openid']));
				if(!empty($vg)){
				    $rg = pdo_get($this->rg,array('weid'=>$weid,'rg_id'=>$vg['vg_rg_id']));
                    $city = pdo_getall("gpb_area",array('pid'=>$rg['rg_province_id']));
                    $area = pdo_getall("gpb_area",array('pid'=>$rg['rg_city_id']));
                }
                //查是否有关联团长
                $head_recommend_log = pdo_get('gpb_head_commond_log',array('weid'=>$weid,'uid'=>$id));
				if(!empty($head_recommend_log)){
                    $head_recommend = pdo_get($this->member,array('m_id'=>$head_recommend_log['pid'],'weid'=>$weid));
                }
                $head_group = pdo_get('gpb_head_group',array('leader_id'=>$id));
				if(!empty($head_group)){
                    $recommend_open =2;
                }
			}
            $province = pdo_getall("gpb_area",array('pid'=>0));

		}
	break;
    case 'getRecommedHead':
        //选择推荐团长的查询
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
        if(isset($_GPC['code']) && !empty($_GPC['code']) ) {
            $where .= " and  m_recommend_code =".trim($_GPC['code'])." ";
        }
        $ids = trim($_GPC['ids'],',');
        $mid = trim($_GPC['mid'],',');
        if(!empty($mid)){
            $where .= " and m_id <>".$mid." ";
        }
        $ids_arr =array();
        if(!empty($ids) ) {
            $ids_arr = explode(",",$ids);
        }
//        var_dump($ids_arr);exit;
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->member)." where weid=".$weid." and m_status = 1 and m_nickname is not null and m_is_head=2  ".$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select * from '.tablename($this->member)." where weid=".$weid." and m_status = 1  ".$where." and m_nickname is not null and m_is_head=2 order by m_id desc ".$contion;
        $info = pdo_fetchall($sql);
        break;
    case 'getArea':
        //获取地区
        $id = $_GPC['area_id'];
        $rs = $this->getArea($id);
        echo json_encode($rs,JSON_UNESCAPED_UNICODE);
        exit;
        break;
    case 'wantHead':
        //申请团长列表
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //逻辑：昵称是模糊查询
        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
            $where .= " and m_nickname like '%".trim($_GPC['title'])."%' ";
        }
        //逻辑：姓名是模糊查询
        if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
            $where .= " and m_name like '%".trim($_GPC['name'])."%' ";
        }
        //逻辑：手机是模糊查询
        if(isset($_GPC['phone']) && !empty($_GPC['phone']) ) {
            $where .= " and m_phone like '%".trim($_GPC['name'])."%' ";
        }
        //逻辑：编号是确定查询
        if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
            $where .= " and m_id = '".trim($_GPC['num'])."' ";
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->ah).' as a left join '. tablename($this->member) .' as m on  m.m_openid = a.openid where a.weid='.$weid.' and m_status = 1 and ah_status = 1 '.$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select * from ' . tablename($this->ah).' as a left join '. tablename($this->member) .' as m on  m.m_openid = a.openid where a.weid='.$weid.' and m_status = 1 and ah_status = 1'.$where."  order by ah_result desc,ah_id asc ".$contion;
        $info = pdo_fetchall($sql);
        //var_dump($sql);exit;
        break;
    case 'deal':
        if($_GPC['submit'] == '提交'){
            //提交数据
            $status = trim($_GPC['status']);
            $info = trim($_GPC['info']);
            $openid = $_GPC['openid'];
            if(empty($info) ){
                $this->message_info('请输入审核说明，方便用户查看');exit;
            }
            $data = [
                'ah_result'=>$status,
                'ah_message'=>$info,
                'ah_updatetime'=>time(),
                'weid'=>$weid,
            ];
            $old_ah = pdo_get($this->ah,array('ah_id'=>$id));
            pdo_begin();
            if($id){
                $res = pdo_update($this->ah,$data,['ah_id'=>$id]);
            }
            if(empty($res)){
                $this->message_info('操作失败');
            }else{
                $info = pdo_get($this->ah,array('ah_id'=>$id,'weid'=>$weid));
                //发送模板消息
                $sms = new Sms();
                $sms->weid=$weid;
                $this->Tokens();
                if($status==-1){
                    $result = "拒绝成为团长";
                    $sub_msg = '申请被拒';
                }elseif($status == -2){
                    $result = "申请团长成功";
                    $sub_msg = '申请成功';
                }
                $dass = $sms->send_out('apply_head_template',array('1'=>$info['ah_name'],'2'=>$info['ah_phone'],'3'=>$info['ah_wx_account'],'4'=>$result,'5'=>$info['ah_message'],'6'=>date('Y-m-d H:i:s',$info['ah_add_time']),'7'=>$info['ah_shop_name']),$_W['account']['access_tokne'],$openid,'',$info['form_id'],$sms->weid,'AT0330');

                //新增订阅消息 周龙 2020-02-27
                $submsg = new \SubMsg();
                $submsg_arr = [
                    $info['ah_name'],
                    $info['ah_phone'],
                    $sub_msg,
                    date('Y-m-d H:i:s',$info['ah_add_time']),
                    mb_substr($info['ah_shop_name'],0,20)
                ];
                $submsg->sendmsg("team_leader",$openid,$submsg_arr);

                $commission = pdo_get($this->config,array("key"=>'commission_ratio','weid'=>$weid));
                //当审核通过可以直接设置为团长
                if( $status == -2 ){
                    //查询是否之前有小区
                    $old_vg = pdo_get($this->vg,array('weid'=>$weid,'openid'=>$openid));
                    if(!empty($old_vg)){
                        $res_vg =  pdo_update($this->vg,array('vg_status'=>1),array('weid'=>$weid,'vg_id'=>$old_vg['vg_id']));
                        $res_rg =  pdo_update($this->rg,array('rg_status'=>1),array('weid'=>$weid,'rg_id'=>$old_vg['vg_rg_id']));
//                        if(empty($res_rg) || empty($res_vg)){
//                            pdo_rollback();
//                            $this->message_info('操作失败');
//                        }
                    }
                    $head_info = pdo_get($this->ah,['ah_id'=>$id]);
                    $head_data = [
                        'm_head_lng'=>$head_info['ah_lng'],
                        'm_head_lat'=>$head_info['ah_lat'],
                        'm_head_address'=>$head_info['ah_address'],
                        'm_head_shop_name'=>$head_info['ah_shop_name'],
                        'm_name'=>$head_info['ah_name'],
                        'm_phone'=>$head_info['ah_phone'],
                        'm_is_head'=>2,
                        'weid'=>$weid,
                        'm_commission'=>$commission['value'],
                    ];
                    $res = pdo_update($this->member,$head_data,['m_openid'=>$openid]);
                    if(empty($res)){
                        pdo_rollback();
                        $this->message_info('操作失败');
                    }else{
                        //读取配置
                        $head_recommend_open = pdo_get($this->config,array('key'=>'head_recommend_open','weid'=>$weid));
                        if(isset($head_recommend_open['value']) && $head_recommend_open['value']==1){
                            //组成分销团队
                            $u_arr = pdo_get($this->member,array('m_openid'=>$old_ah['openid'],'weid'=>$weid));
                            $uid = isset($u_arr['m_id'])?$u_arr['m_id']:0;
                            //当有推荐团长时，
                            $bind_res = array();
                            if(!empty($old_ah['ah_recommend_openid'])){
                                $p_arr = pdo_get($this->member,array('m_openid'=>$old_ah['ah_recommend_openid'],'weid'=>$weid));
                                $pid = isset($p_arr['m_id'])?$p_arr['m_id']:0;
                                $bind_res = $this->headbingteam($uid,$pid);
                                if($bind_res['code']==0){
                                    //绑定成功,记录推荐
                                   $this->commond_set_log($uid,$pid);
                                }
                            }
                            //自己建立团队
                            $team_info = pdo_get("gpb_head_group",['weid'=>$this->weid,'status'=>1,'leader_id'=>$uid]);
                            if(empty($team_info)){
                                pdo_insert("gpb_head_group",['weid'=>$this->weid,'leader_id'=>$uid,'create_time'=>time(),'update_time'=>time(),'status'=>1]);
                            }
                            //存日志
                            $file  = dirname(__FILE__).'/headbing.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
                            if(file_exists($file) && filesize($file) > 100000){
                                unlink($file);//这里是直接删除，
                            }
                            $content = date('Y-m-d H:i:s');
                            $content .= "处理申请,pid={$pid},uid={$uid}\n";
                            foreach ($bind_res as $k=>$v){
                                $content .= "{$k}={$v}\n";
                                if($k == 'data'){
                                    foreach ($bind_res[$k] as $kk=>$vv){
                                        $content .= "{$kk}={$vv}\n";
                                    }
                                }

                            }
                            $content .= "------\n";
                            file_put_contents($file,$content.PHP_EOL,FILE_APPEND);
                        }

                        pdo_commit();
                        $this->message_info('操作成功', $this->createWebUrl('plsugins',['op'=>'extension']), 'success');
                    }

                }else{
                    $this->message_info('操作成功', $this->createWebUrl('plsugins',['op'=>'extension','in'=>'wantHead']), 'success');
                }

            }
        }else{
            if($id){
                $info = pdo_get($this->ah,['ah_id'=>$id,'weid'=>$weid]);
            }
        }
        break;
    case 'info':
        if($_GPC['submit'] == '提交'){
            //提交数据
            $title = trim($_GPC['title']);
            $account = trim($_GPC['account']);
            $phone= trim($_GPC['phone']);
            $shop_name = trim($_GPC['shop_name']);
            $address = trim($_GPC['address']);
            if(empty($title) ){
                $this->message_info('姓名必须');exit;
            }
            if(empty($account) ){
                $this->message_info('微信号必须');exit;
            }
            if(empty($phone) ){
                $this->message_info('电话必须');exit;
            }
            if(empty($shop_name) ){
                $this->message_info('店铺名必须');exit;
            }
            if(empty($address) ){
                $this->message_info('地址必须');exit;
            }
            $data = [
                'ah_name'=>$title,
                'ah_wx_account'=>$account,
                'ah_phone'=>$phone,
                'ah_shop_name'=>$shop_name,
                'ah_address'=>$address,
                'weid'=>$weid,
            ];
            if($id){
                $res = pdo_update($this->ah,$data,['ah_id'=>$id]);
            }
            if(empty($res)){
                $this->message_info('操作失败');
            }else{
                $this->message_info('操作成功', $this->createWebUrl('plsugins',['op'=>'extension','in'=>'wantHead']), 'success');
            }
        }else{
            if($id){
                $sql = " select * from ".tablename($this->ah)." as ah left join ".tablename($this->member)." as m on m.m_openid = ah.openid where ah.weid=".$weid." and ah_id=".$id;
                $info = pdo_fetch($sql);
            }else{
                echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
            }
        }

        break;
    case 'del':
        if($id){
            $res = pdo_update($this->ah,['ah_status'=>-1],['ah_id'=>$id,'weid'=>$weid]);
            if($res){
                echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
    case 'seeIncome':
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //逻辑：团长openid
        if(!isset($_GPC['openid']) || empty($_GPC['openid']) ) {
            $this->message_info('非法进入');
        }
        $openid =trim($_GPC['openid']);
        $team = pdo_get($this->member,array("m_openid"=>$openid,"weid"=>$weid));
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        //$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->ah).' as a left join '. tablename($this->member) .' as m on  m.m_openid = a.openid where m_status = 1 and ah_status = 1 '.$where);
        //$page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        //$sql = "select DATE_FORMAT(go_add_time,'%Y-%m-%d') as days,count(*) as count  from ibt_shop_order group by days;";
        $sql="SELECT FROM_UNIXTIME(go_pay_time,'%Y-%m-%d') AS days,COUNT(*) AS num ,SUM(go_real_price) AS total,m.*,o.*
FROM ".tablename($this->order)." AS o  JOIN ".tablename($this->member)." AS m ON o.go_team_openid = m.m_openid 
WHERE m_is_head =2 AND m.m_status=1 and  o.go_team_openid='".$openid."' and o.go_pay_time >0  and o.weid=".$weid." GROUP BY days order by go_pay_time desc ".$contion;
        $total= pdo_fetchall("SELECT FROM_UNIXTIME(go_pay_time,'%Y-%m-%d') AS days,COUNT(*) AS num ,SUM(go_real_price) AS total,m.*,o.*
FROM ".tablename($this->order)." AS o  JOIN ".tablename($this->member)." AS m ON o.go_team_openid = m.m_openid 
WHERE m_is_head =2 AND m.m_status=1 and  o.go_team_openid='".$openid."' and o.go_pay_time >0  and o.weid=".$weid." GROUP BY days order by go_pay_time desc");
        $total = count($total);
        $page = pagination($total,$pageIndex,$pageSize);
        //$sql = "select DATE_FORMAT(go_add_time,'%Y-%m-%d') as days,count(*) as count,* from ".tablename($this->order)." as o left join ".tablename($this->member)." as m on o.go_team_openid = m.m_openid where m_is_head =2 and m.m_status=1 order by days desc group by days ".$contion;
        $info = pdo_fetchall($sql);
//        echo "<pre>";
//var_dump("select count(*) from ".tablename($this->order)." where go_team_openid='".$openid."'");
        //查询订单总数
        $all_order_num = pdo_fetchcolumn("select count(*) from ".tablename($this->order)." where weid=".$weid." and go_team_openid='".$openid."' and go_pay_time >0  ");
//        //查询商品总量
        $all_goods_num = pdo_fetchcolumn("select count(*) from ".tablename($this->snapshot)." as s left join ".tablename($this->order)." as o on s.oss_go_code=o.go_code where o.weid=".$weid." and oss_head_openid='".$openid."' and go_pay_time >0  ");
//        //查询营业额
        $all_money = pdo_fetch("select sum(oss_g_num*oss_g_price) as total from ".tablename($this->snapshot)." as s left join ".tablename($this->order)." as o on s.oss_go_code=o.go_code where o.weid=".$weid." and oss_head_openid='".$openid."' and go_pay_time >0 ");
        $all_money = $all_money['total'];
//        //查询退款订单
        $all_back_order = pdo_fetchcolumn("select count(*)  from ".tablename($this->order)." where weid=".$weid." and go_team_openid='".$openid."' and go_status = 70 and  go_pay_time >0  ");
//        //查询退款订单金额
        $all_back_order_money = pdo_fetch("select sum(oss_g_num*oss_g_price) as total from ".tablename($this->snapshot)." as s left join ".tablename($this->order)." as o on o.go_code = s.oss_go_code where o.weid=".$weid." and oss_head_openid='".$openid."' and go_status =70 ");
        $all_back_order_money = $all_back_order_money['total'];
//        ///查询配送费 todo ...
        $all_send_money = pdo_fetch("select sum(go_send_pay) as total  from ".tablename($this->order)."  where weid=".$weid." and go_team_openid='".$openid."' and go_status = 100  ");
        $all_send_money= $all_send_money['total'];
//        var_dump($sql);
//        var_dump($info);
//        exit;
        break;
    case 'commission':
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $openid =trim($_GPC['openid']);
        $user = pdo_get($this->member,['m_openid'=>$openid],'*');
        if($user['m_nickname']==base64_encode(base64_decode($user['m_nickname']))){
            $user['m_nickname'] = base64_decode($user['m_nickname']);
        }

        $sql = "select * from ".tablename($this->order)." where weid=".$weid." and go_team_openid='".$openid."' and go_status = 100 order by go_add_time desc ".$contion;
        $info = pdo_fetchall($sql);
        $total= pdo_fetchcolumn("select count(*) from ".tablename($this->order)." where weid=".$weid." and go_team_openid='".$openid."' and go_status = 100 order by go_add_time desc ");
        $page = pagination($total,$pageIndex,$pageSize);
        //查询审核中
        $review_sql = "select sum(go_commission) as total from ".tablename($this->order)." where weid=".$weid." and go_team_openid='".$openid."' and go_status = 100 and go_is_cash=-1";
//        var_dump($review_sql);
        $review = pdo_fetch($review_sql);
        $review_money = $review['total'];
        //查询未提现
        $cash_sql = "select sum(go_commission) as total from ".tablename($this->order)." where weid=".$weid." and go_team_openid='".$openid."' and go_status = 100 and go_is_cash=1";
//        var_dump($cash_sql);
        $cash = pdo_fetch($cash_sql);
        $cash_money = $cash['total'];
        //查询已提现
        $is_cash_sql = "select sum(ggc_money) as total from ".tablename($this->get_cash)." where weid=".$weid." and openid='".$openid."' and ggc_type = 20 ";
//        var_dump($is_cash_sql);
        $is_cash = pdo_fetch($is_cash_sql);
        $is_cash_money = $is_cash['total'];

        break;
    case 'setCommission':
        //逻辑：团长openid
        if(!isset($_GPC['openid']) || empty($_GPC['openid']) ||!isset($_GPC['id']) || empty($_GPC['id']) ) {
            $this->message_info('非法进入');
        }
        $openid = trim($_GPC['openid']);
        $id = trim($_GPC['id']);
        $act = trim($_GPC['act']);
        if($_GPC['submit'] == '提交'){
            //提交数据
            $status = trim($_GPC['status']);
            $info = trim($_GPC['info']);
            $openid = $_GPC['openid'];
            if(empty($info) ){
                $this->message_info('请输入审核说明，方便用户查看');exit;
            }
            $data = [
                'go_is_cash'=>$status,
                'go_commission_comment'=>$info,
                'go_commission_time'=>time(),
            ];
            $old = pdo_get($this->order,array('go_id'=>$id,"weid"=>$weid));//var_dump($old);exit;
            if(empty($old)){
                $this->message_info('订单有误');exit;
            }
            if($id){
                $res = pdo_update($this->order,$data,['go_id'=>$id]);

                if(empty($res)){
                    $this->message_info('操作失败');
                }else{
                    if($status ==1 and $old['go_is_cash']==-1){
                        //审核通过
                        pdo_update($this->member,array('m_money +='=>$old['go_commission']),array('m_openid'=>$old['go_team_openid'],'weid'=>$weid));
                        //修改流水
                        $old_stream = pdo_get($this->stream,array('gos_go_code'=>$old['go_code'],'gos_stream_type'=>3));
                        if(!empty($old_stream)){
                            $data_stream = array(
                                'gos_real_money'=>$old['go_commission'],
                                'gos_status'=>2,
                                'gos_commet'=>'用户自己确认收货产生佣金,后审核通过该佣金,',
                                'gos_sure_pay_time'=>time(),
                            );
                        }
                        pdo_update($this->stream,$data_stream,array('gos_id'=>$old_stream['gos_id']));
                    }elseif ($status ==-1 and $old['go_is_cash']==1){
                        //审核不通过
                        pdo_update($this->member,array('m_money -='=>$old['go_commission']),array('m_openid'=>$old['go_team_openid'],'weid'=>$weid));
                        //修改流水
                        $old_stream = pdo_get($this->stream,array('gos_go_code'=>$old['go_code'],'gos_stream_type'=>3));
                        if(!empty($old_stream)){
                            $data_stream = array(
                                'gos_real_money'=>0,
                                'gos_status'=>-1,
                                'gos_commet'=>'佣金审核未通过',
                                'gos_sure_pay_time'=>time(),
                            );
                            pdo_update($this->stream,$data_stream,array('gos_id'=>$old_stream['gos_id']));
                        }

                    }
                    if($act=="stream"){
                        $this->message_info('操作成功', $this->createWebUrl('finance',['op'=>'stream_commission']), 'success');
                    }else{
                        $this->message_info('操作成功', $this->createWebUrl('plsugins',['op'=>'extension','in'=>'commission','openid'=>$openid]), 'success');
                    }

                }
            }
        }else{
            $act = trim($_GPC['act']);
            if($id){
                $info = pdo_get($this->order,['go_id'=>$id,'weid'=>$weid]);
            }
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
                $this->message_info("修改配置成功",$this->createWebUrl('plsugins',array('op'=>'extension','in'=>'config')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
//            $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'commission')), 'success');
        }else{
            //总体佣金设置
            $commission_ratio = pdo_get($this->config,array('key'=>'commission_ratio','weid'=>$weid));
            if(empty($commission_ratio) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('佣金比例设置','','3',".time().",".$weid.",1,'commission_ratio');");
            }
            //团长提现门槛设置
            $get_cash_limit_money = pdo_get($this->config,array('key'=>'get_cash_limit_money','weid'=>$weid));
            if(empty($get_cash_limit_money) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('团长提现门槛设置','0','3',".time().",".$weid.",1,'get_cash_limit_money');");
            }
            //申请团长时的申请条款
            $apply_head_text =  pdo_get($this->config,array('key'=>'apply_head_text','weid'=>$weid));
            if(empty($apply_head_text) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('申请团长时申请条款','','3',".time().",".$weid.",1,'apply_head_text');");
            }
            //申请团长时引导优化图片显示
            $apply_head_img =  pdo_get($this->config,array('key'=>'apply_head_img','weid'=>$weid));
            if(empty($apply_head_img) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('引导申请广告图','','3',".time().",".$weid.",1,'apply_head_img');");
            }
            //首页是否开启上一次购物时团长提醒
            $last_head_notice =  pdo_get($this->config,array('key'=>'last_head_notice','weid'=>$weid));
            if(empty($last_head_notice) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('选择上次购物团长弹窗开关','','3',".time().",".$weid.",1,'last_head_notice');");
            }
            $info = pdo_getall($this->config,['status'=>1,'type'=>3,'weid'=>$weid],array(),"key");
        }
        break;
    case 'recommend_config':
        //推荐团长分销设置
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
                $this->message_info("修改配置成功",$this->createWebUrl('plsugins',array('op'=>'extension','in'=>'recommend_config')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
//            $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'commission')), 'success');
        }else{
            //是否开启团长推荐
            $head_recommend_open = pdo_get($this->config,array('key'=>'head_recommend_open','weid'=>$weid));
            if(empty($head_recommend_open) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启团长推荐','2','15',".time().",".$weid.",1,'head_recommend_open');");
            }
            //设置团长推荐奖
            $head_recommend_price = pdo_get($this->config,array('key'=>'head_recommend_price','weid'=>$weid));
            if(empty($head_recommend_price) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('设置团长推荐奖','0','15',".time().",".$weid.",1,'head_recommend_price');");
            }
            //是否开启推广代理团长
            $head_agent_open = pdo_get($this->config,array('key'=>'head_agent_open','weid'=>$weid));
            if(empty($head_agent_open) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启推广代理团长','2','15',".time().",".$weid.",1,'head_agent_open');");
            }
            //设置推广代理团长等级
            $head_agent_level = pdo_get($this->config,array('key'=>'head_agent_level','weid'=>$weid));
            if(empty($head_agent_level) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('设置推广代理团长等级','1','15',".time().",".$weid.",1,'head_agent_level');");
            }
            //设置推广代理团长抽成方式
            $head_agent_get_type = pdo_get($this->config,array('key'=>'head_agent_get_type','weid'=>$weid));
            if(empty($head_agent_get_type) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('设置推广代理团长抽成方式','1','15',".time().",".$weid.",1,'head_agent_get_type');");
            }
            //推广代理团长一级
            $head_agent_lever_one = pdo_get($this->config,array('key'=>'head_agent_lever_one','weid'=>$weid));
            if(empty($head_agent_lever_one) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('推广代理团长一级','0','15',".time().",".$weid.",1,'head_agent_lever_one');");
            }
            //推广代理团长二级
            $head_agent_lever_two = pdo_get($this->config,array('key'=>'head_agent_lever_two','weid'=>$weid));
            if(empty($head_agent_lever_two) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('推广代理团长二级','0','15',".time().",".$weid.",1,'head_agent_lever_two');");
            }
            //推广代理团长三级
            $head_agent_lever_three = pdo_get($this->config,array('key'=>'head_agent_lever_three','weid'=>$weid));
            if(empty($head_agent_lever_three) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('推广代理团长三级','0','15',".time().",".$weid.",1,'head_agent_lever_three');");
            }
            //团长分销提现限额
            $head_agent_limit_cash = pdo_get($this->config,array('key'=>'head_agent_limit_cash','weid'=>$weid));
            if(empty($head_agent_limit_cash) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('团长分销提现限额','0','15',".time().",".$weid.",1,'head_agent_limit_cash');");
            }
            //团长推荐分销规则
            $str = '<p><img src="'.tomedia('./addons/group_buy/public/bg/agent_rule.png').'" width="100%" alt="团长推荐分销规则"/></p>';
            $head_agent_rule = pdo_get($this->config,array('key'=>'head_agent_rule','weid'=>$weid));
            if(empty($head_agent_rule) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('团长推荐分销规则','{$str}','15',".time().",".$weid.",1,'head_agent_rule');");
            }
            $info = pdo_getall($this->config,['status'=>1,'type'=>15,'weid'=>$weid],array(),"key");
        }
        break;
    case 'openSend':
        $code = trim($_GPC['code']);
        if(empty($code) || empty($id)){
            echo json_encode(array('status'=>1,'msg'=>'请求无效'));exit;
        }else{
            $res = pdo_update($this->member,array('m_is_send'=>$code),array('m_id'=>$id));
            if(!empty($res)){
                echo json_encode(array('status'=>0,'msg'=>'操作成功'));exit;
            }else{
                echo json_encode(array('status'=>1,'msg'=>'操作失败'));exit;
            }
        }
        break;
    case 'state':
        $id = $_GPC['id'];//用户
        if(empty($id)){
            echo json_encode(['status'=>1,'msg'=>'请传入用户id','data'=>array()]);exit;
        }
        $val = $_GPC['val'];
//        var_dump($val);exit;
        if(empty($val) && $val!=0){
            echo json_encode(['status'=>1,'msg'=>'请传入修改的状态码','data'=>array()]);exit;
        }
        $res = pdo_update($this->member,array($_GPC['type']=>$val),array('m_id'=>$id));
        if($res){
            echo json_encode(['status'=>0,'msg'=>'更新成功','data'=>array()]);exit;
        }else{
            echo json_encode(['status'=>1,'msg'=>'更新失败','data'=>array()]);exit;
        }
        break;
    case 'old_data_set':
    //对原来的团长进行建立团队的操作
        $all = pdo_getall($this->member,array('m_is_head'=>2));
        foreach ( $all as $k =>$v){
            $team_info = pdo_get("gpb_head_group",['weid'=>$v['weid'],'status'=>1,'leader_id'=>$v['m_id']]);
            if(empty($team_info)){
                pdo_insert("gpb_head_group",['weid'=>$v['weid'],'leader_id'=>$v['m_id'],'create_time'=>time(),'update_time'=>time(),'status'=>1]);
            }
        }
        break;
    case 'head_team':
        //团长的下级
        $uid = $_GPC['uid'];
        $nick_name = pdo_get("gpb_member", ['weid'=>$this->weid,'m_id'=>$uid], 'm_nickname');
        if(empty($uid) || empty($nick_name)){
            $this->message_info("团长信息有误");
        }
        $nick_name = $nick_name['m_nickname'];
        if($nick_name==base64_encode(base64_decode($nick_name))){
            $nick_name = base64_decode($nick_name);
        }
        $team = pdo_get("gpb_head_group",['leader_id'=>$uid,'weid'=>$this->weid]);
        if(!empty($team['lv1'])){
            $team['lv1'] = trim($team['lv1'],',');
            $sql1 = "select * from ".tablename("gpb_member")." where `m_id` in ({$team['lv1']})";
//            exit($sql1);
            $lv1 = pdo_fetchall($sql1);
            foreach ($lv1 as $k=>$v){

                if($v['m_nickname']==base64_encode(base64_decode($v['m_nickname']))){
                    $lv1[$k]['m_nickname'] = base64_decode($v['m_nickname']);
                }
                $lv1[$k]['m_add_time'] = date("Y-m-d H:i:s",$v['m_add_time']);
                $log = pdo_get("gpb_head_group_log",['weid'=>$this->weid,'uid'=>$v['m_id']]);
                $lv1[$k]['c_time'] = date("Y-m-d H:i:s",$log['create_time']);
//                $lv1[$k]['is_dis'] = ['is_dis']==1?'是':'否';
            }
        }else{
            $lv1 = [];
        }
        if(!empty($team['lv2'])) {
            $team['lv2'] = trim($team['lv2'],',');
            $sql2 = "select * from " . tablename("gpb_member") . " where `m_id` in ({$team['lv2']})";
            $lv2 = pdo_fetchall($sql2);
            foreach ($lv2 as $k=>$v){
                if($v['m_nickname']==base64_encode(base64_decode($v['m_nickname']))){
                    $lv2[$k]['m_nickname'] = base64_decode($v['m_nickname']);
                }
                $lv2[$k]['m_add_time'] = date("Y-m-d H:i:s",$v['m_add_time']);
                $log = pdo_get("gpb_head_group_log",['weid'=>$this->weid,'uid'=>$v['m_id']]);
                $lv2[$k]['c_time'] = date("Y-m-d H:i:s",$log['create_time']);
//                $lv2[$k]['is_dis'] = $log['is_dis']==1?'是':'否';
            }
        }else{
            $lv2 = [];
        }
        if(!empty($team['lv3'])) {
            $team['lv3'] = trim($team['lv3'],',');
            $sql3 = "select * from " . tablename("gpb_member") . " where `m_id` in ({$team['lv3']})";
            $lv3 = pdo_fetchall($sql3);
            foreach ($lv3 as $k=>$v){
                if($v['m_nickname']==base64_encode(base64_decode($v['m_nickname']))){
                    $lv3[$k]['m_nickname'] = base64_decode($v['m_nickname']);
                }
                $lv3[$k]['m_add_time'] = date("Y-m-d H:i:s",$v['m_add_time']);
                $log = pdo_get("gpb_head_group_log",['weid'=>$this->weid,'uid'=>$v['m_id']]);
                $lv3[$k]['c_time'] = date("Y-m-d H:i:s",$log['create_time']);
//                $lv3[$k]['is_dis'] = $log['is_dis']==1?'是':'否';
            }
        }else{
            $lv3 = [];
        }
        $list = ['1'=>$lv1,'2'=>$lv2,'3'=>$lv3];
//        var_dump($list);exit;
        break;
    case 'team_log':
        if(!empty($_POST)){
            exit("999");
        }
//        var_dump($_GPC['time']);exit;
        $uid = $_GPC['uid'];
        $time_range='';
        $nick_name = pdo_get("gpb_member", ['weid'=>$this->weid,'m_id'=>$uid], 'm_nickname');
        $nick_name = $nick_name['m_nickname'];
        if($nick_name==base64_encode(base64_decode($nick_name))){
            $nick_name = base64_decode($nick_name);
        }

        $type = trim($_GPC['type']);
        if(empty($type)){
            $where = " and `uid`='{$uid}' and `status`=1";
        }else{
            $where = " and `uid`='{$uid}' and `status`=1 and `type`='{$type}'";
        }
        if(!empty($_GPC['time'])){
            if(!empty($_GPC['time_start']) && !empty($_GPC['time_end'])){
                $time_range = $_GPC['time_start'].' - '.$_GPC['time_end'];
                $where .=' and  create_time >=  '.strtotime($_GPC['time_start']).' and create_time <='.strtotime($_GPC['time_end']);
            }
        }
        if(!empty($_GPC['key'])){
            $where .=' and `info` like "%'.$_GPC['key'].'%"';
        }
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;

        $total= pdo_fetchcolumn('select count(*) from '.tablename('gpb_head_money_log').' where weid ='.$this->weid.'  '.$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select * from '.tablename('gpb_head_money_log').' where weid ='.$this->weid.'  '.$where.' order by id desc '.$contion;
        $log = pdo_fetchall($sql);
//        pdo_debug();
//        $list = $this->getList("gpb_distribution_money_log",$where,$pageIndex,'create_time desc');
//        $list =$this->dis->getlog($uid,$pageIndex);

//
//        $log = $list['list'];
//        $total = $list['total'];
//        $page = $list['page'];
        break;
}
?>