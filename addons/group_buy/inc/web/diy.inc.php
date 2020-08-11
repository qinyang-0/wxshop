<?php
/*
 * diy管理
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index_diy' : $op ;
$weid = $this->weid;  //控制模块
$pre = $_W['config']['db']['tablepre'];
switch($op){
    //我的模版列表
	case 'index':
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize; //var_dump($this->diy_tmp);exit;
//		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->diy_temp)." where status = 1 and system=1 and weid =".$weid);
//		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息

//		$sql = 'select * from '.tablename($this->diy_temp)." where status = 1 and (weid =".$weid.")  and system=1 order by isact desc,store desc,id desc ".$contion;
        $sql = 'select * from '.tablename($this->diy_temp)." where status = 1 and (weid =".$weid.")  and `system`=1 order by isact desc,store desc,id desc ";
		$info = pdo_fetchall($sql);
	break;
    //模版市场列表
    case 'index_system':
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize; //var_dump($this->diy_tmp);exit;
        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->diy_temp)." where status = 1 and system=2 and weid =".$weid);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息

        $sql = 'select * from '.tablename($this->diy_temp)." where status = 1 and  system=2 order by id desc,store desc ".$contion;
        $info = pdo_fetchall($sql);
        break;
	//新增/修改模版
	case 'add':
		if($_GPC['submit'] == '提交'){
//            var_dump($_POST);exit;
			//提交数据
            $name = trim($_GPC['name']);
            $img= trim($_GPC['img']);
            $isact = trim($_GPC['isact']);
            $store = trim($_GPC['store']);

			if(empty($name)){
                $this->message_info('请填写模版名称');exit;
//                echo json_encode(['status'=>1,'msg'=>'请填写活动名称']);exit;
			}
            if(empty($img) ){
                $this->message_info('请上传封面图');exit;
//                echo json_encode(['status'=>1,'msg'=>'请填写活动时间']);exit;
            }
            if(empty($isact) ){
                $this->message_info('请选择是否启用模版');exit;
//                echo json_encode(['status'=>1,'msg'=>'活动起始时间不能超过终止时间']);exit;
            }
			$data = [
				'name'=>$name,
				'isact'=>$isact,
                'store'=>$store,
                'img'=>$img,
                'time'=>time(),
                'weid'=>$weid
			];
            pdo_begin();
            if($isact ==1){
                $ress = pdo_update($this->diy_temp,array('isact'=>-1),array('weid'=>$weid,'status'=>1,'isact'=>1));
            }
			if($id){
				$res = pdo_update($this->diy_temp,$data,array('id'=>$id));
//                $url = $this->createWebUrl('diy');
            }else{
				$res = pdo_insert($this->diy_temp,$data);
//                $url = $this->createWebUrl('diy',array('op'=>'add'));
            }
			if(empty($res)){
			    pdo_rollback();
                $this->message_info('操作失败');
//                echo json_encode(array('status'=>1,'msg'=>'操作失败','url'=>''));exit;
			}else{
			    pdo_commit();
                $this->message_info('操作成功', $this->createWebUrl('diy'), 'success');
//                echo json_encode(array('status'=>0,'msg'=>'操作成功','url'=>$url));exit;
			}
		}else{
			if($id){
				$info = pdo_get($this->diy_temp,array('id'=>$id,'weid'=>$weid));
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
	    //删除模版
	case 'del':
		if($id){
		    $id = trim($id,',');
		    $id_arr = explode(",",$id);
		    if(count($id_arr) > 1){
		        $old = pdo_get($this->diy_temp,array('id'=>$id,'weid'=>$weid));
		        if($old['system'] == 2){
                    echo json_encode(['status'=>1,'msg'=>'系统模版,不能删除']);exit;
                }
                $res = pdo_update($this->diy_temp,array('status'=>0),array('id'=>$id,'weid'=>$weid));
            }else{
                $old = pdo_getall($this->diy_temp,array('id in'=>$id,'weid'=>$weid));
                foreach ( $old as $v ){
                    if($v['system'] == 2){
                        echo json_encode(['status'=>1,'msg'=>'系统模版,不能删除']);exit;
                    }
                }
                $res = pdo_update($this->diy_temp,array('status'=>0),array('id in'=>$id,'weid'=>$weid));
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
		//快速设置使用该模版
    case "use_temp":
        if($id){
            $id = trim($id,',');
            pdo_begin();
//            pdo_update($this->diy_temp,array('isact'=>-1),array('weid'=>$weid,'isact'=>1));
//            pdo_update($this->diy_temp,array('isact'=>-1),array('system'=>2,'isact'=>1));
//            pdo_update($this->diy_temp,array('isact'=>-1),array('system'=>2,'isact'=>1));
//            $res = pdo_update($this->diy_temp,array('isact'=>1),array('id'=>$id));
//            $temp = pdo_get($this->diy_temp,array('id'=>$id));
            $page = pdo_get($this->diy_page,array('system'=>1,'weid'=>$weid,'tempid'=>$id));
            $page_tmp = pdo_get($this->diy_page,array('system'=>3,'status'=>2,'weid'=>$weid));
            //是否存在临时page
            if(empty($page_tmp)){
                $data_tmp = array(
                    'weid'=>$weid,
                    'system'=>3,
                    'status'=>2,
                    'content'=>$page['content'],
                    'createtime'=>time()
                );
                $res = pdo_insert('gpb_diy_page',$data_tmp);
            }else{
                $data_tmp = array(
                    'content'=>$page['content'],
                    'createtime'=>time()
                );
                $res = pdo_update('gpb_diy_page',$data_tmp,array('id'=>$page_tmp['id']));
            }
            if($res){
                pdo_commit();
                if($_GPC['type']==2){
                    $this->message_info('操作成功', $this->createWebUrl('diy',array('op'=>'index_diy')), 'success');exit;
                }
                echo json_encode(['status'=>0,'msg'=>'使用成功']);exit;
            }else{
                pdo_rollback();
                if($_GPC['type']==2){
                    $this->message_info('使用失败');exit;
                }
                echo json_encode(['status'=>1,'msg'=>'使用失败']);exit;
            }
        }else{
            if($_GPC['type']==2){
                $this->message_info('非法进入');exit;
            }
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
        //首页模版编辑
    case "adLinkUrl":
        $type = trim($_GPC['type']);
        $dataid = trim($_GPC['dataid']);
        switch ($type){
            case "page":
                //判断积分商城是否存在
                $distribution= '';
                $fraction="";
                if(file_exists("../addons/group_buy_plugin_fraction")){
                    $fraction = 1;
                }else{
                    $fraction = 0;
                }
                //判断分销商城是否存在
                if(file_exists("../addons/group_buy_plugin_distribution")){
                    $distribution = 1;
                }else{
                    $distribution = 0;
                }
				//判断砍价是否存在
                if(file_exists("../addons/group_buy_plugin_bargain")){
                    $bargain = 1;
                }else{
                    $bargain = 0;
                }
				//判断砍价是否存在
                if(file_exists("../addons/group_buy_plugin_team")){
                    $team = 1;
                }else{
                    $team = 0;
                }
                //判断余额充值
                $markrting_id = pdo_get('gpb_config',array('key'=>'markrting_id','type'=>19));
                $markrting_id = isset($markrting_id['value'])?$markrting_id['value']:-1;
                //判断会员卡
                $card_id = pdo_get('gpb_config',array('key'=>'card_id','type'=>20));
                $card_id = isset($card_id['value'])?$card_id['value']:-1;
                //判断积分签到 1是 -1不是
                $sign_id = pdo_get('gpb_config',array('key'=>'sign_id','type'=>21));
                $sign_id = isset($sign_id['value'])?$sign_id['value']:-1;


                break;
            case "cate":
                //查询分类
                $cate = cache_load('goods_cate'.$weid);
                if(empty($cate)) {
                    $data = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc;");
                    $infos = $this->getTree($data,"gc_id","gc_pid");
                    cache_write('goods_cate'.$weid,$infos);
                }
                $cate  = cache_load('goods_cate'.$weid);

                foreach ($cate as $k=>$v){
                    if($v['gc_status']==-1){
                        unset($cate[$k]);
                    }
                }
                break;
            case "goods":
                $index=isset($_GPC['page'])?$_GPC['page']:1;
                $pageIndex = $index;
                $pageSize =8;
                $where = "";

                if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
                    $where .= " and  g_name like '%".trim($_GPC['title'])."%' ";
                }
                if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
                    $where .= " and  g_product_num like '%".trim($_GPC['num'])."%' ";
                }
                $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
                $sql_count = "select count(*) from ".tablename($this->goods)." as g where g_is_del=1 and g_is_online=1 and g.weid =".$weid.$where;
                $sql = "select * from ".tablename($this->goods)." as g where g_is_del=1 and g_is_online=1 and g.type = 1 and g.weid =".$weid.$where."  order by g_id ".$contion;
                $total= pdo_fetchcolumn($sql_count);
                $goods = pdo_fetchall($sql);
                $page = pagination($total,$pageIndex,$pageSize);
                break;
            case "action_goods":
                $index=isset($_GPC['page'])?$_GPC['page']:1;
                $pageIndex = $index;
                $pageSize = 8;
                $where = "";

                if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
                    $where .= " and  g.g_name like '%".trim($_GPC['title'])."%' ";
                }
                if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
                    $where .= " and  g.g_product_num like '%".trim($_GPC['num'])."%' ";
                }
                if(isset($_GPC['action']) && !empty($_GPC['action']) ) {
                    $where .= " and  a.at_name like '%".trim($_GPC['action'])."%' ";
                }
                $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
                $sql_count = "select count(*) from ".tablename($this->action_goods)." as ag  left join ".tablename($this->action)." as a on ag.gcg_at_id = a.at_id left join ".tablename($this->goods)." as g on g.g_id =ag.gcg_g_id left join ".tablename($this->goods_stock)." as gs on gs.goods_id = ag.gcg_g_id where at_is_del=1  and at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time > ".time()." and ag.weid=".$this->weid.$where;
                $sql  =  "select * from ".tablename($this->action_goods)." as ag  left join ".tablename($this->action)." as a on ag.gcg_at_id = a.at_id left join ".tablename($this->goods)." as g on g.g_id =ag.gcg_g_id left join ".tablename($this->goods_stock)." as gs on gs.goods_id = ag.gcg_g_id where at_is_del=1  and at_is_index_show=1 and g_is_online=1 and g.type = 1 and g_is_del = 1 and at_end_time > ".time()." and ag.weid=".$this->weid.$where."   order by at_start_time desc ".$contion;
                $total= pdo_fetchcolumn($sql_count);
                $action_goods = pdo_fetchall($sql);
                $page = pagination($total,$pageIndex,$pageSize);
                break;
            case "action_list":
                $index=isset($_GPC['page'])?$_GPC['page']:1;
                $pageIndex = $index;
                $pageSize = 8;
                $where = "";

                if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
                    $where .= " and  at_name like '%".trim($_GPC['title'])."%' ";
                }

                $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
                $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->action)." where at_is_del = 1 and weid =".$weid);
                $page = pagination($total,$pageIndex,$pageSize);
                //获取分页信息
                $sql = 'select * from '.tablename($this->action)." where at_is_del = 1 and weid =".$weid.$where." order by at_order,at_id desc ".$contion;

                $action_list = pdo_fetchall($sql);
                $page = pagination($total,$pageIndex,$pageSize);
                break;

            case "out_link":

                break;
        }
        break;
	case 'cate_goods':
		$type = trim($_GPC['type']);
        $dataid = trim($_GPC['dataid']);
        switch ($type){
            case "goods":
                $index=isset($_GPC['page'])?$_GPC['page']:1;
                $pageIndex = $index;
                $pageSize =8;
                $where = "";

                if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
                    $where .= " and  g_name like '%".trim($_GPC['title'])."%' ";
                }
                if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
                    $where .= " and  g_product_num like '%".trim($_GPC['num'])."%' ";
                }
                $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
                $sql_count = "select count(*) from ".tablename($this->goods)." as g where g_is_del=1 and g_is_online=1 and g.type = 1 and g.weid =".$weid.$where;
                $sql = "select g_id,g_name,g_old_price,g_price,g_icon from ".tablename($this->goods)." as g where g_is_del=1 and g_is_online=1 and g.type = 1 and  g.weid =".$weid.$where."  order by g_id ".$contion;
                $total= pdo_fetchcolumn($sql_count);
                $goods = pdo_fetchall($sql);
                $page = pagination($total,$pageIndex,$pageSize);
                break;
            case "action_goods":
                $index=isset($_GPC['page'])?$_GPC['page']:1;
                $pageIndex = $index;
                $pageSize = 8;
                $where = "";

                if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
                    $where .= " and  g.g_name like '%".trim($_GPC['title'])."%' ";
                }
                if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
                    $where .= " and  g.g_product_num like '%".trim($_GPC['num'])."%' ";
                }
                if(isset($_GPC['action']) && !empty($_GPC['action']) ) {
                    $where .= " and  a.at_name like '%".trim($_GPC['action'])."%' ";
                }
                $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
                $sql_count = "select count(*) from ".tablename($this->action_goods)." as ag  left join ".tablename($this->action)." as a on ag.gcg_at_id = a.at_id left join ".tablename($this->goods)." as g on g.g_id =ag.gcg_g_id left join ".tablename($this->goods_stock)." as gs on gs.goods_id = ag.gcg_g_id where at_is_del=1  and g.type = 1 and at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time > ".time()." and ag.weid=".$this->weid.$where;
                $sql  =  "select at_id,at_end_time,g_id,g_name,g_old_price,g_price,g_icon from ".tablename($this->action_goods)." as ag  left join ".tablename($this->action)." as a on ag.gcg_at_id = a.at_id left join ".tablename($this->goods)." as g on g.g_id =ag.gcg_g_id left join ".tablename($this->goods_stock)." as gs on gs.goods_id = ag.gcg_g_id where at_is_del=1 and g.type = 1 and at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time > ".time()." and ag.weid=".$this->weid.$where."   order by at_start_time desc ".$contion;
                $total= pdo_fetchcolumn($sql_count);
                $action_goods = pdo_fetchall($sql);
                $page = pagination($total,$pageIndex,$pageSize);
            break;
        }
	break;
    case "index_diy":
    	$url_js = "../web/resource/components/zclip/jquery.zclip.min.js";
//  	var_dump(file_exists($url_js));exit;
    	if(!file_exists($url_js)){
    		//没有该js文件     复制一个
    		$as = copy("../addons/group_buy/style/web_js/jquery.zclip.min.js",$url_js);
//  		echo '<pre>';
//			var_dump($as);exit;
		}
        //获取活动
        $action = pdo_fetchall('select * from '.tablename($this->action)." where at_is_del = 1 and at_is_index_show=1 and weid =".$weid." order by at_order,at_id desc ");
        $tid = $_GPC['tid'];
        if(!empty($tid)){

            $temp = pdo_get('gpb_diy_temp',array('id'=>$tid));
			$page = pdo_get('gpb_diy_page',array('tempid'=>$tid,'status'=>1));
//			echo '<pre>';
//			$page = pdo_fetchall("select * from ".tablename('gpb_diy_page'));
//			print_r($page);
//			exit;
//            var_dump($page);exit;
            //如果为系统模版
            if($page['system']==2){
                //是否存在临时page
                $page_tmp = pdo_get('gpb_diy_page',array('system'=>3,'status'=>2,'weid'=>$weid));
                if(empty($page_tmp)){
                    $data_tmp = array(
                        'weid'=>$weid,
                        'system'=>3,
                        'status'=>2,
                        'content'=>$page['content']
                    );
                    pdo_insert('gpb_diy_page',$data_tmp);
                }else{
                    $data_tmp = array(
                        'content'=>$page['content']
                    );
                    pdo_update('gpb_diy_page',$data_tmp,array('id'=>$page_tmp['id']));
                }
            }
		} else {
            //看有没有临时的首页
            $page = pdo_get('gpb_diy_page',array('system'=>3,'status'=>2,'weid'=>$weid));
            if(empty($page)){
                $is_act = pdo_get('gpb_diy_temp',array('status'=>1,'isact'=>1));
                $tid = $is_act['id'];
                $page = pdo_get('gpb_diy_page',array('tempid'=>$tid,'status'=>1));
                //新增临时首页
                $data_tmp = array(
                    'weid'=>$weid,
                    'system'=>3,
                    'status'=>2,
                    'content'=>$page['content']
                );
                pdo_insert('gpb_diy_page',$data_tmp);
            }
        }
		$cate  = cache_load('goods_cate'.$weid);
        if(empty($cate)) {
            $data = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc;");
            if(empty($data)){
                $data = [
                    'gc_name'=>'水果',
                    'gc_pid'=>0,
                    'gc_level'=>0,
                    'gc_tree'=>'0,0',
                    'gc_status'=>1,
                    'gc_icon'=>'',
                    'gc_order'=>1,
                    'weid'=>$weid,
                    'gc_is_del'=>1,
                    'gc_update_time'=>time(),
                    'gc_is_index_show'=>1
                ];
                $data["gc_add_time"] = time();
                $res = pdo_insert($this->goods_cate,$data);
                $res = pdo_insert($this->goods_cate,$data);
                $data = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc;");
            }
            $infos = $this->getTree($data,"gc_id","gc_pid");
			if($infos){
				foreach($infos as $ks=>$vs){
					$infos[$ks]['gc_name'] = str_repeat("　　",$vs['gc_level']).$vs['gc_name'];
				}
			}
            cache_write('goods_cate'.$weid,$infos);
        }
		$options = cache_load('goods_cate'.$weid);

        /*echo "<pre/>";
        echo "11";
        var_dump($options);
        die;*/
		
//		echo '<pre>';
//		print_r($options);exit;
        $page = unserialize($page['content']);
        //判断是否存在秒杀插件
        $is_have_seckill = false;
        if(file_exists("../addons/group_buy_plugin_seckill")){
            $is_have_seckill = true;
        }
        break;
	case 'savepage':
		//点保存
        if($_POST['type'] == 'save'){
            $tid = $_GPC['tid'];

            $array = $data =  [];
            if($_GPC['data']){
                //没有主体
                $array['data'] = $_GPC['data'];
            }
            if($_GPC['basic']){
                //没有头部
                $array['basic'] = $_GPC['basic'];
            }

            $act ='edit';

            if(empty($tid)){
                //没有id就只保存临时page
                //查询之前有无临时page
                $page = pdo_get('gpb_diy_page',array('status'=>2,'system'=>3,'weid'=>$weid));
                if(empty($page)){
                    $act = 'add';
                    $data['status']=2;
                    $data['system']=3;
                }

            }else{
                //如果有但是是系统temp也保存临时page
                $old_temp = pdo_get('gpb_diy_temp',array('id'=>$tid));
                if($old_temp['system']==2){
                    $page = pdo_get('gpb_diy_page',array('status'=>2,'system'=>3,'weid'=>$weid));
                    if(empty($page)){
                        $act = 'add';
                        $data['status']=2;
                        $data['system']=3;
                    }
                }else{
                    $page = pdo_get('gpb_diy_page',array('tempid'=>$tid,'status'=>1,'weid'=>$weid));
                    $data['status']=1;
                    $data['system']=1;
                    $data['tempid'] = $tid;
                }
            }

            $data['weid'] = $this->weid;
            $data['content'] = serialize($array);
            //var_dump($act);exit;
            //编辑页面
            if($act == 'edit'){
                $res = pdo_update('gpb_diy_page',$data,array('id'=>$page['id']));
                echo json_encode(['status'=>1,'msg'=>'操作成功','data'=>0]);exit;
                //有些人什么都没改就点保存，让他成功
            }elseif($act == 'add'){
                $data['createtime'] = time();
                $res = pdo_insert('gpb_diy_page',$data);
            }else{
                echo json_encode(['status'=>1,'msg'=>'无效操作',]);exit;
            }
            if($res){
                echo json_encode(['status'=>1,'msg'=>'操作成功','data'=>0]);exit;
            }else{
                echo json_encode(['status'=>0,'msg'=>'操作失败','data'=>$tid]);exit;
            }
        } else {
            //点新增到我的模版
            $tid = $_GPC['tid'];
            $array = $data =  [];
            if($_GPC['data']){
                //没有主体
                $array['data'] = $_GPC['data'];
            }
            if($_GPC['basic']){
                //没有头部
                $array['basic'] = $_GPC['basic'];
            }
            $tid = $_GPC['tid'];
            $res = pdo_insert('gpb_diy_temp',array('weid'=>$this->weid,'name'=>$array['basic']['title'],'isact'=>-1,'store'=>1,'time'=>time(),'system'=>1));
            $tid = pdo_insertid();

            //判断这个存在不
            $data['weid'] = $this->weid;
            $data['content'] = serialize($array);
            $data['status'] = 1;
            $data['tempid'] = $tid;
            //如果有但是是系统page也新增
            $act = 'add';
            $data['createtime'] = time();
            $data['system'] = 1;
            $res = pdo_insert('gpb_diy_page',$data);

            if($res){
                echo json_encode(['status'=>1,'msg'=>'操作成功','data'=>$tid,'setTitle'=>$array['basic']['title']]);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'操作失败','data'=>$tid]);exit;
            }
        }
	break;
    case 'set_title':
        $title = trim($_GPC['title']);
        $tid = trim($_GPC['tid']);
//        var_dump($title);var_dump($tid);exit;
        if($_GPC['submit'] == '提交'){
            $res = pdo_update('gpb_diy_temp',array('name'=>$title),array('id'=>$tid));
//            if(empty($res)){
//                echo json_encode(['status'=>0,'msg'=>'操作失败','data'=>$tid]);exit;
//            }
//            else{
                echo json_encode(['status'=>1,'msg'=>'操作成功','data'=>$tid]);exit;
//            }
        }
        break;
    case 'index_playbill':
        //首页海报
        if($_GPC['submit'] == '提交'){
            //提交数据

            unset($_POST['submit']);
            pdo_begin();
            foreach ($_POST as $k =>$v){
                if($k == 'ids'){
                    $ids = '';
                    if(!empty($v)){
                        $ids  = implode(',',$v);
                    }
                    if(!empty($ids)){
                         pdo_update($this->config,array('value'=>$ids),array('key'=>'index_playbill_goods','weid'=>$weid));
                    }else{
                        pdo_update($this->config,array('value'=>''),array('key'=>'index_playbill_goods','weid'=>$weid));
                    }
                    $res = 1;
                }else{
                    $sql = "update ".tablename($this->config)." set value = '".$v."',time=".time()." where id =".$k;
                    $res = pdo_query($sql);
                }
            }
            pdo_commit();
            if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('diy',array('op'=>'index_playbill')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
//            $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'commission')), 'success');
        }else{
            $index_playbill_img = pdo_get($this->config,array('key'=>'index_playbill_img','weid'=>$weid));
            if(empty($index_playbill_img) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('首页海报分享背景图','/addons/group_buy/public/bg/index_playbill_bg.jpg','11',".time().",".$weid.",1,'index_playbill_img');");
            }
            $index_playbill_goods = pdo_get($this->config,array('key'=>'index_playbill_goods','weid'=>$weid));
            if(empty($index_playbill_goods) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('首页海报分享商品','0','11',".time().",".$weid.",1,'index_playbill_goods');");
            }
            $index_playbill_img = pdo_get($this->config,array('key'=>'index_playbill_img','weid'=>$weid));
            $index_playbill_goods = pdo_get($this->config,array('key'=>'index_playbill_goods','weid'=>$weid));
            if(isset($index_playbill_goods['value']) && !empty($index_playbill_goods['value'])){
                $goods = pdo_fetchall("select * from ".tablename('gpb_goods')." where g_id in (".$index_playbill_goods['value'].") order by instr('".$index_playbill_goods['value']."',g_id) " );
            }
        }
        break;
    case 'getGoods':
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
    case 'copyright':
        //版权
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
                $this->message_info("修改配置成功",$this->createWebUrl('diy',array('op'=>'copyright')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
//            $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'commission')), 'success');
        }else{
            $copyright_open = pdo_get($this->config,array('key'=>'copyright_open','weid'=>$weid));
            if(empty($copyright_open) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启版权设置','2','11',".time().",".$weid.",1,'copyright_open');");
            }
            $copyright_style = pdo_get($this->config,array('key'=>'copyright_style','weid'=>$weid));
            if(empty($copyright_style) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('版权图标文字排列风格','','11',".time().",".$weid.",1,'copyright_style');");
            }
            $copyright_text = pdo_get($this->config,array('key'=>'copyright_text','weid'=>$weid));
            if(empty($copyright_text) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('版权文字设置','','11',".time().",".$weid.",1,'copyright_text');");
            }
            $copyright_icon = pdo_get($this->config,array('key'=>'copyright_icon','weid'=>$weid));
            if(empty($copyright_icon) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('版权图标上传','','11',".time().",".$weid.",1,'copyright_icon');");
            }
            $version_number_open = pdo_get($this->config,array('key'=>'version_number_open','weid'=>$weid));
            if(empty($version_number_open) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启版本号显示','1','11',".time().",".$weid.",1,'version_number_open');");
            }
            $copyright_style = pdo_get($this->config,array('key'=>'copyright_style','weid'=>$weid));
            $copyright_text = pdo_get($this->config,array('key'=>'copyright_text','weid'=>$weid));
            $copyright_icon = pdo_get($this->config,array('key'=>'copyright_icon','weid'=>$weid));
            $copyright_open = pdo_get($this->config,array('key'=>'copyright_open','weid'=>$weid));
            $version_number_open = pdo_get($this->config,array('key'=>'version_number_open','weid'=>$weid));
        }
        break;
    case "member_diy":
        //获取活动

        $old_member_diy =  pdo_get('gpb_config',array('key'=>'member_diy_data_set','weid'=>$this->weid,'type'=>25));
        if(empty($old_member_diy)){
            //获取系统自带
            $old_member_diy =  pdo_get('gpb_config',array('key'=>'member_diy_data_set_system','type'=>25));
        }
        $page = (isset($old_member_diy['value']) && !empty($old_member_diy['value']) )?unserialize($old_member_diy['value']):'';
        if($_GPC['t']==1){
            var_export($page);
            exit;
        }
        break;
    case "savemember":
        //保存用户中心数据
        if(empty($_GPC['basic'])){
            echo json_encode(['status'=>1,'msg'=>'数据保存失败',]);exit;
        }
        if(empty($_GPC['data'])){
            echo json_encode(['status'=>1,'msg'=>'数据保存失败',]);exit;
        }
        $member = array('basic'=>$_GPC['basic'],'data'=>$_GPC['data']);
      
        if(empty($member)){
            echo json_encode(['status'=>1,'msg'=>'数据保存失败',]);exit;
        }
        $member['data'][0] =  $_GPC['basic'];
        $old_member_diy =  pdo_get('gpb_config',array('key'=>'member_diys_data_set','weid'=>$this->weid,'type'=>25));
        if(empty($old_member_diy)){
            $data = array(
                'name'=>'用户中心自定义diy数据',
                'value'=>serialize($member),
                'type'=>25,
                'time'=>time(),
                'weid'=>$this->weid,
                'status'=>1,
                'key'=>'member_diys_data_set'
            );
            $res = pdo_insert('gpb_config',$data);
        }else{
            $data = array(
                'value'=>serialize($member),
            );
            $res = pdo_update('gpb_config',$data,array('id'=>$old_member_diy['id']));
        }

        echo json_encode(['status'=>0,'msg'=>'保存成功',]);exit;
        break;
    case "member_diys":
        //获取活动
        $old_member_diy =  pdo_get('gpb_config',array('key'=>'member_diys_data_set','weid'=>$this->weid,'type'=>25));
        if(empty($old_member_diy)){
            //获取系统自带
            $old_member_diy =  pdo_get('gpb_config',array('key'=>'member_diys_data_set_system','type'=>25));
        }
        $page = (isset($old_member_diy['value']) && !empty($old_member_diy['value']) )?unserialize($old_member_diy['value']):'';
        if(strpos($_W['siteroot'],'http:')!==false){
            if(!empty($page)){
                $page = json_encode($page);
                if(strpos($page,'https:')!==false){
                    $page = str_replace("https:","http:",$page);
                }
                $page = json_decode($page,true);
            }

        }
        if($_GPC['t']==1){
            var_export($page);
            exit;
        }
        break;
    case "xxx":
        $old_member_diy =  pdo_get('gpb_config',array('key'=>'member_diys_data_set','weid'=>$this->weid,'type'=>25));
        $page = (isset($old_member_diy['value']) && !empty($old_member_diy['value']) )?unserialize($old_member_diy['value']):'';
        var_export($page);
        break;
	case 'diy_goods':
		$cate  = cache_load('goods_cate'.$weid);
        if(empty($cate)) {
            $data = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc;");
            $infos = $this->getTree($data,"gc_id","gc_pid");
			if($infos){
				foreach($infos as $ks=>$vs){
					$infos[$ks]['gc_name'] = str_repeat("　　",$vs['gc_level']).$vs['gc_name'];
				}
			}
            cache_write('goods_cate'.$weid,$infos);
        }
		$options = cache_load('goods_cate'.$weid);
	break;
	case 'dis_goods_info':
		$id = $_GPC['id'];
		//获取商品
		$goods = pdo_fetchall("select g.g_id as id,g.g_name as text,g.g_icon as img,g.g_old_price as Ori_price,g.g_price as price from ".tablename('gpb_goods')." g join ".tablename('gpb_goods_to_category')." c on g.g_id = c.goods_id where c.cate_id = ".$id." and g.weid = ".$this->weid." and g.g_is_online = 1 and g.g_is_del = 1 order by g.g_order desc limit 0,4");
		if($goods){
			foreach($goods as $k=>$v){
				$goods[$k]['img'] = tomedia($v['img']);
				$goods[$k]['text'] = mb_substr($v['text'], 0, 6);
			}
		}
		echo json_encode($goods);exit;
	break;
}
include $this -> template('web/' . $do . '/' . $op);
?>