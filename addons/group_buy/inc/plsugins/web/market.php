<?php
/**
 * 优惠券
 */
switch($in){
	case 'coupon':
        $name = trim($_GPC['name']);
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        //逻辑：名称是模糊查询
        if(isset($_GPC['name']) && !empty($name) ) {
            $where .= " and  name like '%".$name."%' ";
        }
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->coupon)." where weid=".$weid." and status = 1 ".$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename($this->coupon)." where weid=".$weid." and status = 1 ".$where." order by id desc ".$contion;
		$info = pdo_fetchall($sql);

        //查询什么卷处于新人卷活动中
        //查询新人卷
        $new_member_ticket_open = pdo_get($this->config,array('key'=>'new_member_ticket_open','weid'=>$this->weid));
        $new_member_ticket_id_arr = pdo_get($this->config,array('key'=>'new_member_ticket_id','weid'=>$this->weid));
        $new_member_ticket_id =0;
        if( isset($new_member_ticket_open['value']) && $new_member_ticket_open['value'] == 1){
            if(isset($new_member_ticket_id_arr['value']) && $new_member_ticket_id_arr['value'] >0){
                $new_member_ticket_id = $new_member_ticket_id_arr['value'];
            }
        }
        foreach ($info as $k => $v){
            $use = pdo_fetchcolumn("select count(*) from ".tablename($this->user_coupon)." where tid=".$v['id']." and weid=".$weid." and is_use=1");
            $info[$k]['is_use']=$use;

            //查询指定人的卷
            $point_ticket =pdo_fetch('select * from '.tablename('gpb_send_ticket_set').' as sts where cpid='.$v['id'].' ');
            if(!empty($point_ticket)){
                $m_str = $point_ticket['value'];//
                if(!empty($m_str)){
                    $m_arr = explode(',',$point_ticket['value']);
                }
                $info[$k]['type'] = -1;
            }

            if($new_member_ticket_id == $v['id']){
                //新人卷类型
                $info[$k]['type'] = -2;
            }
        }
	break;
	case 'add':
		if($_GPC['submit'] == '提交'){
			//提交数据
//            var_dump($_GPC);
//            exit();
			$name = trim($_GPC['name']);
			$cut_price = trim($_GPC['cut_price']);
            $number =trim( $_GPC['number']);
            $use_limit = trim($_GPC['use_limit']);
			$star_time = trim($_GPC['time']['start']);
            $end_time = trim($_GPC['time']['end']);
            $is_index_show = trim($_GPC['is_index_show']);
            $num_limit = trim($_GPC['num_limit']);
            $comment = trim($_GPC['info']);
            $use_notice =  trim($_GPC['use_notice']);
			if(empty($name)){
                $this->message_info('请填写优惠券名称');exit;
			}
            if(empty($cut_price) ){
                $this->message_info('请填写面值');exit;
            }
            if(empty($number) ){
                $this->message_info('请填写发放总量');exit;
            }
            if(empty($use_limit) ){
                $this->message_info('请选择使用条件');exit;
            }
            if(empty($star_time) || empty($end_time ) ){
                $this->message_info('请填写有效期');exit;
            }
            if($star_time > $end_time ){
                $this->message_info('起始时间不能超过终止时间');exit;
            }
//            if(empty($is_index_show) ){
//                $this->message_info('请选择是否首页显示');exit;
//            }
//            if(empty($num_limit) ){
//                $this->message_info('请选择每人限领');exit;
//            }
			$data = [
				'name'=>$name,
				'cut_price'=>$cut_price,
				'start_time'=>strtotime($star_time),
				'end_time'=>strtotime($end_time),
                'number'=>$number,
				'use_limit'=>$use_limit,
                'is_index_show'=>$is_index_show,
                'num_limit'=>empty($num_limit)?1:$num_limit,
                'comment'=>$comment,
                'weid'=>$weid,
                'type'=>1,
                'use_notice'=>$use_notice
			];
			if($id){
			    $data['update_time'] = time();
				$res = pdo_update($this->coupon,$data,['id'=>$id]);
			}else{
                $data['create_time'] = time();
				$res = pdo_insert($this->coupon,$data);
			}
			if(empty($res)){
                $this->message_info('操作失败');
			}else{
                $this->message_info('操作成功', $this->createWebUrl('plsugins',array('op'=>'market','in'=>'coupon')), 'success');
			}
		}else{
		    $act_title="新增";
			if($id){
                $act_title="修改";
				$info = pdo_get($this->coupon,['id'=>$id,"weid"=>$weid]);
			}
		}
	break;
	case 'save':
	break;
	case 'del':
		if($id){
			$res = pdo_update($this->coupon,['status'=>-1],['at_id'=>$id,"weid"=>$weid]);
			if($res){
				echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
			}else{
				echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
			}
		}else{
			echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
		}
	break;
    case 'info':
        $tid = intval($_GPC['tid']);

        $name = trim($_GPC['name']);
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where= "";
        //逻辑：优惠卷id必须 要并表
        if(!isset($tid) && empty($tid) ) {
            echo json_encode(['status'=>1,'msg'=>'参数错误']);exit;
        }
        //逻辑：名称是模糊查询
        if(isset($_GPC['name']) && !empty($name) ) {
            $where .= " and  name like '%".$name."%' ";
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->user_coupon)." where weid=".$weid." and  status = 1 and  tid = ".$tid);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select *,uc.update_time as use_coupon_time from '.tablename($this->user_coupon)." as uc left join ".tablename($this->member)." as m on m.m_openid = uc.openid left join ".tablename($this->coupon)." as c on uc.tid = c.id where c.weid=".$weid." and uc.status = 1 and  tid = ".$tid.$where." order by uc.id desc ".$contion;
        $info = pdo_fetchall($sql);
        if(is_array($info)){
            foreach ($info as $k=>$v){
                if($this->check_base64_out_json( $v['m_nickname'] )){
                    $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );
                }else{
                    $info[$k]['m_nickname'] = $v['m_nickname'];
                }
            }
        }

        break;
    case "cate":
        //分类卷
        if($_GPC['submit'] == '提交'){
            //提交数据
//            var_dump($_GPC);
//            exit();
            $name = trim($_GPC['name']);
            $cut_price = trim($_GPC['cut_price']);
            $number =trim( $_GPC['number']);
            $use_limit = trim($_GPC['use_limit']);
            $star_time = trim($_GPC['time']['start']);
            $end_time = trim($_GPC['time']['end']);
            $is_index_show = trim($_GPC['is_index_show']);
            $num_limit = trim($_GPC['num_limit']);
            $comment = trim($_GPC['info']);
            $cate = $_GPC['cid'];
            $use_notice =  trim($_GPC['use_notice']);
            if(empty($cate)){
                $this->message_info('请选择优惠卷关联分类');exit;
            }
            $cates = implode(',',$cate);
            if(empty($name)){
                $this->message_info('请填写优惠券名称');exit;
            }
            if(empty($cut_price) ){
                $this->message_info('请填写面值');exit;
            }
            if(empty($number) ){
                $this->message_info('请填写发放总量');exit;
            }
            if(empty($use_limit) ){
                $this->message_info('请选择使用条件');exit;
            }
            if(empty($star_time) || empty($end_time ) ){
                $this->message_info('请填写有效期');exit;
            }
            if($star_time > $end_time ){
                $this->message_info('起始时间不能超过终止时间');exit;
            }
//            if(empty($is_index_show) ){
//                $this->message_info('请选择是否首页显示');exit;
//            }
//            if(empty($num_limit) ){
//                $this->message_info('请选择每人限领');exit;
//            }
            $data = [
                'name'=>$name,
                'cut_price'=>$cut_price,
                'start_time'=>strtotime($star_time),
                'end_time'=>strtotime($end_time),
                'number'=>$number,
                'use_limit'=>$use_limit,
                'is_index_show'=>$is_index_show,
                'num_limit'=>empty($num_limit)?1:$num_limit,
                'comment'=>$comment,
                'limitgoodcatetype'=>1,
                'limitgoodcateids'=>$cates,
                'comment'=>$comment,
                'weid'=>$weid,
                'type'=>5,
                'use_notice'=>$use_notice
            ];
            if($id){
                $data['update_time'] = time();
                $res = pdo_update($this->coupon,$data,['id'=>$id]);
            }else{
                $data['create_time'] = time();
                $res = pdo_insert($this->coupon,$data);
            }
            if(empty($res)){
                $this->message_info('操作失败');
            }else{
                $this->message_info('操作成功', $this->createWebUrl('plsugins',array('op'=>'market','in'=>'coupon')), 'success');
            }
        }else{
            $act_title="新增";
            if($id){
                $act_title="修改";
                $info = pdo_get($this->coupon,['id'=>$id,"weid"=>$weid]);
                if(!empty($info['limitgoodcateids'])){
                    $old_cates = explode(',',$info['limitgoodcateids']);
                }
//                var_dump($old_cate); var_dump($info);exit;
            }
        }
        $cate  = cache_load('goods_cate'.$weid);
        if(empty($cate)) {
            $data = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc;");
            $infos = $this->getTree($data,"gc_id","gc_pid");
            cache_write('goods_cate'.$weid,$infos);
        }
        $cate  = cache_load('goods_cate'.$weid);
        break;
    case "only_goods":
        //单品卷
        if($_GPC['submit'] == '提交'){
            //提交数据
//            var_dump($_GPC);
//            exit();
            $name = trim($_GPC['name']);
            $cut_price = trim($_GPC['cut_price']);
            $number =trim( $_GPC['number']);
            $use_limit = trim($_GPC['use_limit']);
            $star_time = trim($_GPC['time']['start']);
            $end_time = trim($_GPC['time']['end']);
            $is_index_show = trim($_GPC['is_index_show']);
            $num_limit = trim($_GPC['num_limit']);
            $comment = trim($_GPC['info']);
            $gid = $_GPC['gids'];
            $use_notice =  trim($_GPC['use_notice']);
            if(empty($gid)){
                $this->message_info('请选择优惠卷关联商品');exit;
            }
            $gids = implode(',',$gid);
            if(empty($name)){
                $this->message_info('请填写优惠券名称');exit;
            }
            if(empty($cut_price) ){
                $this->message_info('请填写面值');exit;
            }
            if(empty($number) ){
                $this->message_info('请填写发放总量');exit;
            }
//          if(empty($use_limit) ){
//              $this->message_info('请选择使用条件');exit;
//          }
            if(empty($star_time) || empty($end_time ) ){
                $this->message_info('请填写有效期');exit;
            }
            if($star_time > $end_time ){
                $this->message_info('起始时间不能超过终止时间');exit;
            }
//            if(empty($is_index_show) ){
//                $this->message_info('请选择是否首页显示');exit;
//            }
//            if(empty($num_limit) ){
//                $this->message_info('请选择每人限领');exit;
//            }
            $data = [
                'name'=>$name,
                'cut_price'=>$cut_price,
                'start_time'=>strtotime($star_time),
                'end_time'=>strtotime($end_time),
                'number'=>$number,
                'use_limit'=>$use_limit,
                'is_index_show'=>$is_index_show,
                'num_limit'=>empty($num_limit)?1:$num_limit,
                'comment'=>$comment,
                'limitgoodtype'=>1,
                'limitgoodids'=>$gids,
                'comment'=>$comment,
                'weid'=>$weid,
                'type'=>6,
                'use_notice'=>$use_notice
            ];
            if($id){
                $data['update_time'] = time();
                $res = pdo_update($this->coupon,$data,['id'=>$id]);
            }else{
                $data['create_time'] = time();
                $res = pdo_insert($this->coupon,$data);
            }
            if(empty($res)){
                $this->message_info('操作失败');
            }else{
                $this->message_info('操作成功', $this->createWebUrl('plsugins',array('op'=>'market','in'=>'coupon')), 'success');
            }
        }else{
            $act_title="新增";
            if($id){
                $act_title="修改";
                $info = pdo_get($this->coupon,['id'=>$id,"weid"=>$weid]);
                if(!empty($info['limitgoodids'])){
                    $old_goods = pdo_fetchall('select * from '.tablename('gpb_goods').' where g_id in('.$info['limitgoodids'].') ');
                }
            }
        }
        break;
    case 'get_goods':
        //单品卷获取商品弹窗
        //获取商品
        $ids = trim($_GPC['ids'],',');
        $ids_arr =array();
        if(!empty($ids) ) {
            $ids_arr = explode(",",$ids);
        }
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 5;
        $where = " ";
        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
            $where .= " and  g_name like '%".trim($_GPC['title'])."%' ";
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $sql_count = "select count(*) from ".tablename($this->goods)." as g  where g_is_del=1 and g_is_online=1 and   g.weid =".$weid.$where;
        $sql = "select * from ".tablename($this->goods)." as g  where g_is_del=1 and g_is_online=1 and   g.weid =".$weid.$where."  order by g_id ".$contion;
        $total= pdo_fetchcolumn($sql_count);
        $info = pdo_fetchall($sql);
        $page = pagination($total,$pageIndex,$pageSize);
        break;
    case "point":
        //指定发送

        if($_GPC['submit'] == '提交'){
            $name = trim($_GPC['name']);
            $cut_price = trim($_GPC['cut_price']);
//            $number =trim( $_GPC['number']);
            $gid = $_GPC['gids'];
            $number = count($gid);
            $use_limit = trim($_GPC['use_limit']);
            $star_time = trim($_GPC['time']['start']);
            $end_time = trim($_GPC['time']['end']);
            $is_index_show = trim($_GPC['is_index_show']);
            $num_limit = trim($_GPC['num_limit']);
            $comment = trim($_GPC['info']);
            $use_notice =  trim($_GPC['use_notice']);
            if(empty($name)){
                $this->message_info('请填写优惠券名称');exit;
            }
            if(empty($cut_price) ){
                $this->message_info('请填写面值');exit;
            }
//            if(empty($number) ){
//                $this->message_info('请填写发放总量');exit;
//            }
            if(empty($use_limit) ){
                $this->message_info('请选择使用条件');exit;
            }
            if(empty($star_time) || empty($end_time ) ){
                $this->message_info('请填写有效期');exit;
            }
            if($star_time > $end_time ){
                $this->message_info('起始时间不能超过终止时间');exit;
            }
//            if(empty($is_index_show) ){
//                $this->message_info('请选择是否首页显示');exit;
//            }
//            if(empty($num_limit) ){
//                $this->message_info('请选择每人限领');exit;
//            }
            $data = [
                'name'=>$name,
                'cut_price'=>$cut_price,
                'start_time'=>strtotime($star_time),
                'end_time'=>strtotime($end_time),
                'number'=>$number,
                'use_limit'=>$use_limit,
                'is_index_show'=>$is_index_show,
                'num_limit'=>empty($num_limit)?1:$num_limit,
                'comment'=>$comment,
                'weid'=>$weid,
                'type'=>1,
                'use_notice'=>$use_notice
            ];
            if($id){
                $data['update_time'] = time();
                $res = pdo_update($this->coupon,$data,['id'=>$id]);
            }else{
                $data['create_time'] = time();
                $res = pdo_insert($this->coupon,$data);
                $id = pdo_insertid();
            }
            //提交数据
//            var_dump($_GPC);
//            exit();
//            $id = trim($_GPC['cid']);
            $type = trim($_GPC['type']);
            if(empty($id)){
                $this->message_info('请选择优惠卷');exit;
            }
            $coupon_get = pdo_get($this->coupon,array('id'=>$id));
            if(empty($coupon_get)){
                $this->message_info('优惠卷有误');exit;
            }

            if(empty($type)){
                $this->message_info('请选择发送类型');exit;
            }

            $data = [
                'cpid'=>$id,
                'weid'=>$weid,
                'expiration'=>$coupon_get['over_time'],
                'starttime'=>$coupon_get['start_time'],
                'endtime'=>$coupon_get['end_time'],
                'title'=>$coupon_get['name'],
                'sendnum'=>$coupon_get['num_limit'],
                'is_show_index'=>2,
                'type'=>$type,
                'status'=>1,
            ];
            switch ($type){
                case '1':
//指定
                    $gid = $_GPC['gids'];
                    if(empty($gid)){
                        $this->message_info('请选择指定的用户发放');exit;
                    }
                    $gids = implode(',',$gid);
                    $data['value']=$gids;
                    break;
                case '2':
//全部

                    break;
            }
            $sid = trim($_GPC['sid']);
            if($sid){
                $data['updatetime'] = time();
                $res = pdo_update('gpb_send_ticket_set',$data,['id'=>$sid]);
            }else{
                $data['createtime'] = time();
                $res = pdo_insert('gpb_send_ticket_set',$data);
            }
            if(empty($res)){
                $this->message_info('操作失败');
            }else{
                $this->message_info('操作成功', $this->createWebUrl('plsugins',array('op'=>'market','in'=>'coupon')), 'success');
            }
        }else{
            $act_title="新增";
            if($id){
                $act_title="修改";
                $info = pdo_get($this->coupon,['id'=>$id,"weid"=>$weid]);
                $send_ticket = pdo_get('gpb_send_ticket_set',array('cpid'=>$id));
                if(!empty($send_ticket['value'])){
                    $send_member = pdo_fetchall('select * from '.tablename('gpb_member').' where m_id in ('.$send_ticket['value'].')');
                    if(is_array($send_member)){
                        foreach ($send_member as $k=>$v){
                            if($this->check_base64_out_json($v['m_nickname'])) {
                                $send_member[$k]['m_nickname'] = base64_decode($v['m_nickname']);
                            }
                        }
                    }
                }
                $ids = array_column($send_member,'m_id');
                $ids = implode(',',$ids);
                $where  = ' or (c.id = '.$id.')';
            }
        }
        $coupon = pdo_fetchall('select c.* from '.tablename($this->coupon)." as c left join ".tablename('gpb_send_ticket_set')." as sts on sts.cpid=c.id  where c.weid=".$weid." and c.status = 1 and (c.end_time>".time()." and (sts.cpid <= 0 or sts.cpid ='' or sts.cpid is null)) ".$where." order by c.id desc ");
        break;
    case 'get_member':
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 5;

        $where = " ";
        //逻辑：昵称是模糊查询
        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
            $where .= " and ( m_nickname like '%".trim($_GPC['title'])."%' or m_nickname like '%".base64_encode(trim($_GPC['title']))."%' or m_phone like '%".trim($_GPC['title'])."%') ";
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
                if($this->check_base64_out_json($v['m_nickname'])){
                    $info[$k]['m_nickname']= base64_decode($v['m_nickname']);
                }
            }
        }
        break;
    case "new_member":
        //新人卷
        if($_GPC['submit'] == '提交'){
            //提交数据
            unset($_POST['submit']);
            pdo_begin();
//            foreach ($_POST as $k =>$v){
//                $sql = "update ".tablename($this->config)." set value = '".$v."',time=".time()." where id =".$k;
//                $res = pdo_query($sql);
//            }
            $new_member_ticket_open = empty($_POST['new_member_ticket_open'])?2:$_POST['new_member_ticket_open'];
            pdo_update($this->config,array('value'=>$_POST['new_member_ticket_open']),array('key'=>'new_member_ticket_open','weid'=>$weid));
            $new_member_ticket_img = empty($_POST['new_member_ticket_img'])?'/addons/group_buy/public/bg/footer_nomore.png':$_POST['new_member_ticket_img'];
            pdo_update($this->config,array('value'=>$_POST['new_member_ticket_img']),array('key'=>'new_member_ticket_img','weid'=>$weid));
            $name = trim($_GPC['name']);
            $cut_price = trim($_GPC['cut_price']);
            $number =trim( $_GPC['number']);
            $use_limit = trim($_GPC['use_limit']);
            $star_time = trim($_GPC['time']['start']);
            $end_time = trim($_GPC['time']['end']);
            $is_index_show = trim($_GPC['is_index_show']);
            $num_limit = trim($_GPC['num_limit']);
            $comment = trim($_GPC['info']);
            $use_notice =  trim($_GPC['use_notice']);
            if(empty($name)){
                $this->message_info('请填写优惠券名称');exit;
            }
            if(empty($cut_price) ){
                $this->message_info('请填写面值');exit;
            }
            if(empty($number) ){
                $this->message_info('请填写发放总量');exit;
            }
            if(empty($use_limit) ){
                $this->message_info('请选择使用条件');exit;
            }
            if(empty($star_time) || empty($end_time ) ){
                $this->message_info('请填写有效期');exit;
            }
            if($star_time > $end_time ){
                $this->message_info('起始时间不能超过终止时间');exit;
            }
//            if(empty($is_index_show) ){
//                $this->message_info('请选择是否首页显示');exit;
//            }
//            if(empty($num_limit) ){
//                $this->message_info('请选择每人限领');exit;
//            }
            $data = [
                'name'=>$name,
                'cut_price'=>$cut_price,
                'start_time'=>strtotime($star_time),
                'end_time'=>strtotime($end_time),
                'number'=>$number,
                'use_limit'=>$use_limit,
                'is_index_show'=>$is_index_show,
                'num_limit'=>empty($num_limit)?1:$num_limit,
                'comment'=>$comment,
                'weid'=>$weid,
                'type'=>1,
                'use_notice'=>$use_notice
            ];
            if($id){
                $data['update_time'] = time();
                $res = pdo_update($this->coupon,$data,['id'=>$id]);
            }else{
                $data['create_time'] = time();
                $res = pdo_insert($this->coupon,$data);
                $id = pdo_insertid();
            }
            pdo_update($this->config,array('value'=>$id),array('key'=>'new_member_ticket_id','weid'=>$weid));
            pdo_commit();
            if(!empty($res)){
            	//设置成功修改  没有使用的优惠券的过期时间
            	if($id){
					pdo_update("gpb_user_ticket",array('over_time'=>strtotime($end_time)),array('tid'=>$id,'is_use'=>0,'is_over'=>0,'status'=>1,'weid'=>$this->weid));
            	}
                $this->message_info("设置成功",$this->createWebUrl('plsugins',array('op'=>'market','in'=>'new_member')), 'success');
            }else{
                $this->message_info("设置失败");
            }
        }else{
            //是否开启新人送劵
            $new_member_ticket_open = pdo_get($this->config,array('key'=>'new_member_ticket_open','weid'=>$weid));
            if(empty($new_member_ticket_open) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启新人送劵','','17',".time().",".$weid.",1,'new_member_ticket_open');");
            }
            //新人卷关联的优惠卷
            $new_member_ticket_id = pdo_get($this->config,array('key'=>'new_member_ticket_id','weid'=>$weid));
            if(empty($new_member_ticket_id) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('选择优惠券','','17',".time().",".$weid.",1,'new_member_ticket_id');");
            }
            //新人卷弹窗图
            $new_member_ticket_img = pdo_get($this->config,array('key'=>'new_member_ticket_img','weid'=>$weid));
            if(empty($new_member_ticket_img) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('新人卷弹窗图','/addons/group_buy/public/bg/new_member_ticket_img.png','17',".time().",".$weid.",1,'new_member_ticket_img');");
            }
            $new_member_ticket_open = pdo_get($this->config,array('key'=>'new_member_ticket_open','weid'=>$weid));
            $new_member_ticket_id = pdo_get($this->config,array('key'=>'new_member_ticket_id','weid'=>$weid));
            $new_member_ticket_img = pdo_get($this->config,array('key'=>'new_member_ticket_img','weid'=>$weid));
            $id = isset($new_member_ticket_id['value'])?$new_member_ticket_id['value']:0;
            $info = pdo_get($this->coupon,array('id'=>intval($id),'status'=>1,'weid'=>$this->weid));
        }
//        $coupon = pdo_fetchall('select c.* from '.tablename($this->coupon)." as c left join ".tablename('gpb_send_ticket_set')." as sts on sts.cpid=c.id  where c.weid=".$weid." and c.status = 1 and c.end_time>".time()." and (sts.cpid <= 0 or sts.cpid ='' or sts.cpid is null) order by c.id desc ");

        break;
    case "record":
        //发放记录
        $name = trim($_GPC['name']);
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where= "";
        //逻辑：优惠卷id必须 要并表
        if(isset($tid) && !empty($tid) ) {
            $where = 'and tid ='.$tid;
        }
        $where2 = "";
        $total_where = "";
        //逻辑：名称是模糊查询
        if(isset($_GPC['name']) && !empty($name) ) {
            $where2 = " and  `name` like '%".$name."%' ";
            $ticket_list = pdo_fetchall("select id from ".tablename("gpb_ticket")." where weid = {$weid} ".$where2);
            if(!empty($ticket_list)){
                $tmp = [];
                foreach ($ticket_list as $k=>$v){
                    $tmp[] = $v['id'];
                }
                $tmp = implode(",",$tmp);
                $total_where  = " and tid in ({$tmp})";
            }

        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        /**
         * sql 优化
         * 2019-11-14
         * 周龙
         */
//        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->user_coupon)." as uc left join ".tablename($this->coupon)." as c on uc.tid = c.id where c.weid=".$weid." and  uc.status = 1 ".$where);
        $total= pdo_fetchcolumn("select count(*) from ".tablename("gpb_user_ticket")." where `status`=1 {$where} {$total_where}");
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select *,uc.update_time as use_coupon_time from '.tablename($this->user_coupon)." as uc left join ".tablename($this->member)." as m on m.m_openid = uc.openid left join ".tablename($this->coupon)." as c on uc.tid = c.id where c.weid=".$weid." and uc.status = 1    ".$where." order by uc.id desc ".$contion;
//        exit($sql);
    /**
     * sql优化
     * 2019-11-14
     * 周龙
     */
    $sql = "select 
*
from 
(
select *,update_time AS use_coupon_time  from ".tablename("gpb_user_ticket")." where `status`=1 {$where} order by id desc {$contion}
) as uc
join ".tablename("gpb_member")." as m on m.m_openid = uc.openid 
join ".tablename("gpb_ticket")." as c on uc.tid = c.id 
where c.weid={$weid} {$where2} ";
//        exit($sql);
        $info = pdo_fetchall($sql);
        if(is_array($info)){
            foreach ($info as $k=>$v){
                if($this->check_base64_out_json($v['m_nickname'])) {
                    $info[$k]['m_nickname'] = base64_decode($v['m_nickname']);
                }else{
                    $info[$k]['m_nickname'] = $v['m_nickname'];
                }
            }
        }
        break;
        case 'market_del';
        $ids = trim($_GPC['ids'],',');
        if(!empty($ids)){
            $ids_arr = explode(',',$ids);
            foreach ($ids_arr as $v){
                pdo_update('gpb_ticket',array('status'=>2),array('id'=>$v,'weid'=>$this->weid));
                pdo_update('gpb_user_ticket',array('status'=>2),array('tid'=>$v,'weid'=>$this->weid));
            }
            echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
        }else{
            echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
        }

        break;

}

 
?>