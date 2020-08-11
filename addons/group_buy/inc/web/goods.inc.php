<?php

global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
$query = load()->object('query');
$pre = $_W['config']['db']['tablepre'];
$http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

switch($op){
	case 'index':
	    //为了更新，当虚拟人数为0时清理虚拟销量
        $clear_data = pdo_getall('gpb_goods',array('g_virtual_people'=>0,'g_sale_num >'=>0));
        foreach ($clear_data as $clear_data_v){
            pdo_update('gpb_goods',array('g_sale_num'=>0),array('g_id'=>$clear_data_v['g_id']));
        }
        //检查缓存
//        方案一：使用递归后缓存，
        $cate = cache_load('goods_cate'.$weid);
        if(empty($cate)) {
            $data = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc;");
            $infos = $this->getTree($data,"gc_id","gc_pid");
            cache_write('goods_cate'.$weid,$infos);
        }
        $cate  = cache_load('goods_cate'.$weid);
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //逻辑：商品货号是模糊查询
        if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
            $where .= " and  g_product_num like '%".trim($_GPC['num'])."%' ";

        }
        //商品ID
        if(isset($_GPC['ids']) && !empty($_GPC['ids']) ) {
//            $g_ids=explode(',',trim($_GPC['ids']));
//
            $where .= " and  g_id in (".trim($_GPC['ids']).") ";

        }
        //逻辑：商品名称是模糊查询
        if( isset($_GPC['title']) and !empty($_GPC['title']) ) {
            $where .= " and  g_name like '%".trim($_GPC['title'])."%' ";
        }
        //逻辑：商品分类是确定查询
        if( isset($_GPC['pid']) and !empty($_GPC['pid']) ) {
            $where .= " and  gtc.cate_id = '".trim($_GPC['pid'])."' ";
        }
        if(empty($_GPC['status'])){
            $_GPC['status'] = 0;
        }
        switch ($_GPC['status']){
            case 0:
                $where .= " ";
                break;
            case 10:
                $where .= " and g.g_is_del = 1 and g.g_is_online =1";
                break;
            case 20:
                $where .= " and  g.g_is_del = 1 and g.g_stock_notice >=s.num";
                break;
            case 30:
                $where .= " and  g.g_is_del = 1 and g.g_is_online =-1";
                break;
            case 40:
                $where .= " and  g.g_is_del = 3 ";
                break;
            case 50:
                $where .= " and  g.g_is_del = 4 ";
                break;
            case 60:
                $where .= " and  g.g_is_del = 2 ";
                break;
            default:
                $where .= " and  g.g_is_del = 1 ";
                break;
        }
        //逻辑：商品状态是确定查询
        if( isset($_GPC['online']) and !empty($_GPC['online']) ) {
            $where .= " and  g.g_is_online = '".trim($_GPC['online'])."' ";
        }
        $where_supplier='';
        //看是否是供应商进入的
        $supplier_role = pdo_get('gpb_supplier',array('weid'=>$weid,'uid'=>$_W['uid']));
        if(!empty($supplier_role)){
            $this->supplier_role=1;
        }
        if($this->supplier_role==1){
            $where_supplier .= ' and g.g_supplier_id = '.$supplier_role['gsp_id'];
        }
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from (select count(*) from '.tablename($this->goods).' as g left join '.tablename($this->goods_stock).' as s on s.goods_id = g.g_id left join '.tablename('gpb_goods_to_category').' as gtc on gtc.`goods_id` = g.g_id 
left join '.tablename('gpb_goods_cate').' as gc on gc.`gc_id` = gtc.`cate_id` where g.weid='.$weid.$where.$where_supplier.' and (g.`type`<>2 or g.`type` is null) group by g.g_id  order by g.g_is_top desc,g_is_del asc,g_order asc,g_is_online desc,g_id desc ) as tmp ');
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
        $sql = 'select *,s.num as `sum`,s.sale_num as sum_sale from '.tablename($this->goods).' as g left join '.tablename($this->goods_stock).' as s on s.goods_id = g.g_id  left join '.tablename('gpb_goods_to_category').' as gtc on gtc.`goods_id` = g.g_id 
left join '.tablename('gpb_goods_cate').' as gc on gc.`gc_id` = gtc.`cate_id` where g.weid='.$weid.$where.$where_supplier.' and (g.`type`<>2 or g.`type` is null) group by g.g_id  order by g.g_is_top desc,g_is_del asc,g_order asc,g_is_online desc,g_id desc '.$contion;
//		$sql = 'select g.*,c.gc_name,c.gc_id,group_concat(s.num) as sum,group_concat(s.sale_num) as sum_sale,group_concat(gtc.cate_id) as cate  from '.tablename($this->goods)." as g left join ".tablename('gpb_goods_to_category')."as gtc on gtc.goods_id = g.g_id  left join ".tablename($this->goods_cate)." as c on c.gc_id=gtc.cate_id  left join ".tablename($this->goods_stock)." as s on s.goods_id = g.g_id  where g.weid=".$weid.$where.$where_supplier." and (g.`type`<>2 or g.`type` is null) group by s.goods_id order by g.g_is_top desc,g_is_del asc,g_order asc,g_is_online desc,g_id desc ".$contion;
//		var_dump($sql);exit();
    if($_GPC['test']==1){
        var_dump($sql);
        var_dump('select count(*) from (select count(*) from '.tablename($this->goods).' as g left join '.tablename($this->goods_stock).' as s on s.goods_id = g.g_id left join '.tablename('gpb_goods_to_category').' as gtc on gtc.`goods_id` = g.g_id 
left join '.tablename('gpb_goods_cate').' as gc on gc.`gc_id` = gtc.`cate_id` where g.weid='.$weid.$where.$where_supplier.' and (g.`type`<>2 or g.`type` is null) group by g.g_id  order by g.g_is_top desc,g_is_del asc,g_order asc,g_is_online desc,g_id desc ) as tmp ');
        exit;
    }
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
        //不同选项卡的数量
        $status = array();
        //全部
        $status[0] = pdo_fetchcolumn("select count(*) from ".tablename($this->goods)."as g where  g.weid=".$weid.$where_supplier." and (g.`type`<>2 or g.`type` is null)");
        //出售
        $status[10] = pdo_fetchcolumn("select count(*) from ".tablename($this->goods)."as g where  g.weid=".$weid.$where_supplier." and g.g_is_del=1 and g.g_is_online =1 and (g.`type`<>2 or g.`type` is null)");
        //库存预警
        $status[20] = pdo_fetchcolumn("select count(*) from ".tablename($this->goods)."as g left join ".tablename($this->goods_stock)." as s on s.goods_id = g.g_id   where  g.weid=".$weid.$where_supplier." and g.g_is_del=1  and g.g_stock_notice >=s.num and (g.`type`<>2 or g.`type` is null)");
        //已下架
        $status[30] = pdo_fetchcolumn("select count(*) from ".tablename($this->goods)."as g where  g.weid=".$weid.$where_supplier." and g.g_is_del=1 and g.g_is_online=-1 and (g.`type`<>2 or g.`type` is null)");
        //待审核
        $status[40] = pdo_fetchcolumn("select count(*) from ".tablename($this->goods)."as g where  g.weid=".$weid.$where_supplier." and g.g_is_del=3 and (g.`type`<>2 or g.`type` is null)");
        //已拒绝
        $status[50] = pdo_fetchcolumn("select count(*) from ".tablename($this->goods)."as g where  g.weid=".$weid.$where_supplier." and g.g_is_del=4 and (g.`type`<>2 or g.`type` is null)");
        //回收站
        $status[60] = pdo_fetchcolumn("select count(*) from ".tablename($this->goods)."as g where  g.weid=".$weid.$where_supplier." and g.g_is_del=2 and (g.`type`<>2 or g.`type` is null)");
        //读取是否开启满减
        $open_full_reduction = pdo_get($this->config,array('key'=>'open_full_reduction','weid'=>$weid));
        $is_open_full_reduction = 0;
        if(!empty($open_full_reduction) && !empty($open_full_reduction['value']) ){
            $is_open_full_reduction = $open_full_reduction['value'];
        }
	break;
	case 'add':
		//获取会员卡信息
		$gpb_member_card = pdo_fetchall(" select id,title from ".tablename('gpb_member_card')." where status = 1 and weid = ".$this->weid);
		$member_discounts = json_encode($gpb_member_card,JSON_UNESCAPED_UNICODE);
		//获取是否开启分销
		$distribution = pdo_get('gpb_config',array('key'=>'distribution_state','weid'=>$this->weid));
		$distribution = $distribution['value'] == 1 ? 1 : 0;
        //读取虚拟购买人数
        $virtual_people_num = pdo_fetchcolumn("select count(*) from ".tablename('gpb_activity_plugin_virtual_users')." where uid>0");
		if($_GPC['submit'] == '提交'){
			//提交数据

			$name = trim($_GPC['name']);
			$cid = $_GPC['cid'];
			$old_price = floatval($_GPC['old_price']);
            $price = floatval(round($_GPC['price'],2));
            //19-6-27取消虚拟份数的填入
            //$sale_num = intval($_GPC['sale_num']);
            //$old_sale_num = trim($_GPC['old_sale_num']);
            $save = intval($_GPC['save']);//库存写入库存表
            $icon = trim($_GPC['icon']);
            $multi_image = @implode(",",$_GPC['multi-image']);
            $info = trim($_GPC['info']);
            $show = intval($_GPC['show']);
            $video = trim($_GPC['video']);
            $order = intval($_GPC['order']);
            $content = trim($_GPC['content']);
            $hot = intval($_GPC['hot']);
            $recommand = intval($_GPC['recommand']);
            $g_product_num = trim($_GPC['goods_num']);
            $limit_time_sale = trim($_GPC['limit_time_sale']);
            $limit_time_sale_start = "";
            $limit_time_sale_end = "";
            $g_arrival_time = trim($_GPC['g_arrival_time']);
            $g_arrival_time = abs($g_arrival_time);
            $g_limit_num = trim($_GPC['g_limit_num']);
            $g_limit_num = abs($g_limit_num);
            $g_arrival_time_text = trim($_GPC['g_arrival_time_text']);
            $supplier_id = trim($_GPC['supplier']);
            $spec_type = trim($_GPC['spec_type']);
            $spec_name = $_GPC['spec_name'];
            $spec_titles = $_GPC['spec_titles'];
            $send_points = trim($_GPC['send_points']);
            $g_is_new = trim($_GPC['g_is_new']);
            $g_commission = trim($_GPC['g_commission']);
            $g_day_limit_num = trim($_GPC['g_day_limit_num']);
            $g_history_limit_num = trim($_GPC['g_history_limit_num']);
            $g_send_type = trim($_GPC['g_send_type']);
            $g_send_price_sample = trim($_GPC['g_send_price_sample']);
            $g_express_shipping_id = trim($_GPC['g_express_shipping_id']);
            $g_only_weight = trim($_GPC['g_only_weight']);
            $g_stock_notice = trim($_GPC['g_stock_notice']);
            $g_is_top = trim($_GPC['g_is_top']);
            $g_is_full_reduce = trim($_GPC['g_is_full_reduce']);
            $g_is_near_recommend = trim($_GPC['g_is_near_recommend']);
            $g_video = trim($_GPC['g_video']);
            $g_virtual_people = trim($_GPC['g_virtual_people']);
            $old_g_virtual_people = trim($_GPC['old_g_virtual_people']);
            $g_virtual_min_buy = trim($_GPC['g_virtual_min_buy']);
            $g_virtual_max_buy= trim($_GPC['g_virtual_max_buy']);
            //20-3-3 新增团长专享 勾选团长专享，其他商品标签不可选
            $g_is_head_enjoy=intval($_GPC['g_is_head_enjoy']);
            if($g_is_head_enjoy==1){
                $g_is_new=-1;
                $hot=-1;
                $recommand=-1;
                $g_is_full_reduce=0;
                $g_is_top=0;
                $g_is_near_recommend=0;
            }
            //虚拟数量
            $data_virtual_arr = array();
            $sale_num= 0;
            if($g_virtual_people>0){
                for ($i=0;$i<$g_virtual_people;$i++){
                    $data_virtual_arr[$i]=rand($g_virtual_min_buy,$g_virtual_max_buy);
                }
                $sale_num = array_sum($data_virtual_arr);
            }


            if(empty($g_limit_num) && $g_limit_num!=0 ){
                $this->message_info('请输入单次限购数量');exit;
            }
            if( empty($g_arrival_time) && $g_arrival_time!=0){
                $this->message_info('请选择到货时间');exit;
            }
            if( $limit_time_sale == 1){
                $limit_time = $_GPC['limit_time'];
                if(empty($limit_time)){
                    $this->message_info('当选择了限时抢购时，必须填写商品抢购时间');exit;
                }else{
                    $limit_time_sale_start = strtotime($limit_time['start']);
                    $limit_time_sale_end = strtotime($limit_time['end']);
                }
            }
            if(empty($name) ){
                $this->message_info('请输入商品名称');exit;
            }
            if($cid == "" || $cid ==null || !isset($cid) ){
                $this->message_info('请选择商品分类');exit;
            }
//            if(empty($old_price) ){
//                $this->message_info('请输入商品原价');exit;
//            }
            if(empty($price) ){
                $this->message_info('请选择商品售价');exit;
            }
//            if(empty($sale_num) ){
//               // $this->message_info('请输入虚拟销售数量');exit;
//            }
            if(empty($save) && $save!=0){
                $this->message_info('请输入库存数量');exit;
            }
            if(empty($show) ){
                $this->message_info('请选择是否显示');exit;
            }
//            if(empty($spec_type) && $spec_type!=0){
//                $this->message_info('请选择商品规格');exit;
//            }
//            if($spec_type === 1 && empty($spec_titles) ){
//                $this->message_info('启用多规格时，请添加规格参数');exit;
//            }
//            if($spec_type === 1 && empty($spec_name) ){
//                $this->message_info('启用多规格时，请添加规格参数');exit;
//            }

			$data = [
                'g_name'=>$name,
//                'g_cid'=>$cid,
                'g_brief'=>$info,
                'g_old_price'=>$old_price,
                'g_price'=>$price,
                'g_sale_num'=>$sale_num,
                'g_icon'=>$icon,
                'g_thumb'=>$multi_image,
                'g_is_online'=>$show,
				'g_video'=>$g_video,
				'g_order'=>$order,
                'g_info'=>$content,
                'g_is_hot'=>$hot,
                'g_is_recommand'=>$recommand,
                'g_product_num'=>$g_product_num,
                'g_limit_num'=>$g_limit_num,
                'g_is_sale_time'=>$limit_time_sale,
                'g_start_sale_time'=>$limit_time_sale_start,
                'g_end_sale_time'=>$limit_time_sale_end,
                'g_arrival_time'=>$g_arrival_time,
                'g_arrival_time_text'=>$g_arrival_time_text,
                'g_supplier_id'=>$supplier_id,
                'g_has_option'=>$spec_type,
                'send_points'=>$send_points,
                'g_is_new'=> $g_is_new,
                'g_day_limit_num'=>intval($g_day_limit_num),
                'g_commission'=>floatval($g_commission),
                'g_send_type'=>intval($g_send_type),
                'g_send_price_sample'=>sprintf("%.2f",$g_send_price_sample),
                'g_express_shipping_id'=>intval($g_express_shipping_id),
                'g_only_weight'=>$g_only_weight,
                'g_stock_notice'=>intval($g_stock_notice),
                'g_is_top'=>intval($g_is_top),
                'g_is_full_reduce'=>intval($g_is_full_reduce),
                'g_history_limit_num'=>intval($g_history_limit_num),
                'g_is_near_recommend'=>intval($g_is_near_recommend),
                'g_virtual_people'=>$g_virtual_people,
                'g_virtual_min_buy'=>$g_virtual_min_buy,
                'g_virtual_max_buy'=>$g_virtual_max_buy,
                'weid'=>$weid,
                'member_card_discount'=>$_GPC['goods_discount'],
                'dis_type'=>$_GPC['dis_type'],
                'dis_rule'=>$_GPC['dis_rule'],
                'g_is_head_enjoy'=>$g_is_head_enjoy
            ];

            //周龙 2020-04-01 添加 是否是供应商进入的
            $supplier_role = pdo_get('gpb_supplier',array('weid'=>$weid,'uid'=>$_W['uid']));
            if(!empty($supplier_role)){
                $this->supplier_role=1;
            }

            //开始事务
            pdo_begin();
			if($id){
                $open_supplier_edit_goods =  pdo_get($this->config,array('key'=>'open_supplier_edit_goods','weid'=>$weid));
                if( $_W['role']=='operator' && !empty($open_supplier_edit_goods) && isset($open_supplier_edit_goods['value']) && $open_supplier_edit_goods['value'] ==1 && $this->supplier_role==1){
                    $data['g_is_del']=3;
                }
			    $data['g_update_time']=time();
				$res = pdo_update($this->goods,$data,['g_id'=>$id]);
				$gid = $id;
			}else{
                $open_supplier_add_goods =  pdo_get($this->config,array('key'=>'open_supplier_add_goods','weid'=>$weid));
                if( $_W['role']=='operator' && !empty($open_supplier_add_goods) && isset($open_supplier_add_goods['value']) && $open_supplier_add_goods['value'] ==1 && $this->supplier_role==1){
                    $data['g_is_del']=3;
                }
			    //废弃
//			    $IdWork = new \group_buy\IdWork();
//                $goods_code = $IdWork->nextId();
                $data['g_add_time']=time();
//                $data['g_product_num']=$goods_code;
				$res = pdo_insert($this->goods,$data);
				$gid = pdo_insertid();
			}
			if(empty($res)){
			    //回滚
			    pdo_rollback();
                $this->message_info('添加商品失败');exit;
			}
			//过程1.5 存商品分类关系表 2019-04-02 修改
            if(is_array($cid)){
                $old_cates_edit = pdo_getall('gpb_goods_to_category',array('weid'=>$weid, 'goods_id'=>$gid));
                if(is_array($old_cates_edit)){
                    foreach ($old_cates_edit as $oceval){
                        if(!in_array($oceval['cate_id'],$cid)){
                            pdo_delete('gpb_goods_to_category',array( 'weid'=>$weid, 'id'=>$oceval['id']));
                        }else{
                            $key = array_search($oceval['cate_id'], $cid);
                            array_splice($cid, $key, 1);
                        }
                    }
                }
                foreach ($cid as $ckey => $cval){
                    $data_goods_to_cate = array(
                        'cate_id'=>$cval,
                        'weid'=>$weid,
                        'goods_id'=>$gid,
                    );
                    pdo_insert('gpb_goods_to_category',$data_goods_to_cate);
                }
            }else{
                pdo_rollback();
                $this->message_info('请选择商品分类');exit;
            }
			//过程2 ：存库存
            //$id = $id ? $id :pdo_insertid();
			//查以前的库存记录
			$info = pdo_fetchall('select  * from ' . tablename($this->goods_stock)." where weid=".$weid." and goods_id = ".$gid);
            $data_stock = [
                    'num' => $save,
                    'goods_id'=>$gid,
                    'weid'=>$weid,
            ];
            //var_dump($info);
            if( count($info) > 0 ){
                $res = pdo_update($this->goods_stock,$data_stock,['gs_id'=>$info[0]['gs_id']]);//todo单店铺，以后可能会改
                $sid  = $info[0]['gs_id'];
            } else {
                $res = pdo_insert($this->goods_stock,$data_stock);
                $sid  = pdo_insertid();
            }
//            var_dump($res);
//            pdo_debug();exit;
            if($res === false){
                //回滚
                pdo_rollback();
                $this->message_info('未改变数据，记录库存失败');
                exit;
            }
            //过程3：存规格
            if($spec_type == 1){
                if($id){
                    $old_spec = pdo_getall($this->spec,array("weid"=>$weid,"g_id"=>$id));
                    $old_ids ='';
                    foreach ($old_spec as $k=>$v){
                        $old_ids .=','.$v['content'];
                    }
                    if(!empty($old_ids)){
                        $old_spec_item_res = pdo_query("delete  from ".tablename($this->spec_item)." where weid = ".$weid." and gsi_id in (".trim($old_ids,',').")");
//                        if(empty($old_spec_item_res)){
//                            pdo_rollback();
//                            $this->message_info('规格参数存储失败');
//                        }

                        $old_spec_res = pdo_delete($this->spec,array('weid'=>$weid,'g_id'=>$id));
//                        if(empty($old_spec_res)){
//                            pdo_rollback();
//                            $this->message_info('规格存储失败');
//                        }
                        $old_option_res = pdo_delete($this->goods_option,array('weid'=>$weid,'ggo_g_id'=>$id));
//                        if(empty($old_option_res)){
//                            pdo_rollback();
//                            $this->message_info('规格erp存储失败');
//                        }
//                        pdo_debug();
                    }
                }
//                exit;
                    $spec_tmp_id_arr=array();
                    $spec_tmp_name_arr=array();
                    foreach ($spec_name as $k =>$v){

                        $data_spec = array(
                            'weid'=>$weid,
                            'g_id'=>$gid,
                            'title'=>$v,
                            'time'=>time(),
//                        'content'=>serialize($_GPC['spec_name_'.$v]),
//                        'displayorder'=>,
//                        'displaytype'=>
                        );
                        $res_spec = pdo_insert($this->spec,$data_spec);

                        if(empty($res_spec)){
                            pdo_rollback();
                            $this->message_info('未改变数据，规格录入失败');
                        }else{
                            $spec_tmp_id = pdo_insertid();
                            //$spec_tmp_id_arr[$spec_tmp_id] = array();
                        }
                        $spec_item_tmp_id = array();
                        //获取当前规格传参名字
                        foreach ( $_GPC['spec_name_'.$v] as $kk => $vv ){
                        	if(strpos($vv,'+') !== false){
                        		pdo_rollback();
                                $this->message_info('多规格中规格名不能出现+号');
                        	}
                            $data_spec_item = array(
                                'weid'=>$weid,
                                'gsi_specid'=>$spec_tmp_id,
                                'gsi_title'=>$vv,
                                'gsi_show'=>1,
                                'gsi_add_time'=>time(),
//                                'gsi_thumb'=>,
//                                'gsi_displayorder'=>,
//                                'gsi_virtual'=>,
                            );
                            $res_spec_item = pdo_insert($this->spec_item,$data_spec_item);
                            if(empty($res_spec_item)){
                                pdo_rollback();
                                $this->message_info('未改变数据，规格参数录入失败');
                            }else{
                                $spec_tmp_name_arr[$spec_tmp_id][] = $vv;
                                $spec_tmp_id_arr[$spec_tmp_id][] = pdo_insertid();

                            }
                        }
                        pdo_update($this->spec,array('content'=>implode(',',$spec_tmp_id_arr[$spec_tmp_id])),array('id'=>$spec_tmp_id));
                }
                //存erp表
                $spec_titles_arr = explode('|',$spec_titles);
                foreach ($spec_titles_arr as $spec_titles_key => $spec_titles_val){
                    $val_arr =explode("+",$spec_titles_val);
                    //2020-03-17 周龙 修改 增加规格增加title区分 避免值一样的两个规格重复
                    $spec_names = array_reverse($spec_name);//值相反 先生成反序数组
                    foreach ($spec_names as $sepc_name_key=>$now_spec_name){
                        $val_arr[$sepc_name_key] = [
                            'title'=>$now_spec_name,
                            'gsi_title'=>$val_arr[$sepc_name_key]
                        ];
                    }
                    $ggo_specs =array();
                    foreach ($val_arr as $val_arr_k =>$val_arr_v){
                        $val_tem = pdo_fetch("SELECT `gsi_id` FROM ".tablename($this->spec_item)." as si left join ".tablename($this->spec)." as s on s.id = si.gsi_specid WHERE si.weid = ".$weid." AND si.gsi_title = '".$val_arr_v['gsi_title']."' and title='{$val_arr_v['title']}' AND s.g_id = ".$gid);
                        if(empty($val_tem)){
                            break;
                        }else{
                            $ggo_specs[] = $val_tem['gsi_id'];
                        }
                    }

                    $data_goods_option = array(
                        'ggo_g_id'=>$gid,
                        'ggo_title'=>$spec_titles_val,//2020-03-17 周龙 修改直接用值就行了 为何频繁转换我也不懂
                        'ggo_specs'=>implode(",",$ggo_specs),
                        'ggo_market_price'=>$_GPC['spec_price'][$spec_titles_key],
                        'ggo_old_price'=>$_GPC['spec_line_price'][$spec_titles_key],
                        'ggo_stock'=>$_GPC['spec_stock'][$spec_titles_key],
                        'ggo_weight'=>$_GPC['spec_weight'][$spec_titles_key],
                        'ggo_goodssn'=>$_GPC['spec_sn'][$spec_titles_key],
                        'ggo_add_time'=>time(),
                        'weid'=>$weid
                    );
                    /*echo "<pre/>";
                    var_dump($data_goods_option);
                    die;*/
                    $res_goods_option = pdo_insert($this->goods_option,$data_goods_option);
                    if(empty($res_goods_option)){
                        pdo_rollback();
                        $this->message_info('未改变数据，规格参数erp录入失败');
                    }
                }
            }
			//会员价格
			if($_GPC['goods_discount'] != 1 && !empty($gpb_member_card)){
				if($_GPC['goods_discount'] == 2){
					//单规格
					foreach($gpb_member_card as $k=>$v){
						$goods_price = $_GPC['price_'.$v['id']];
//						if(!empty($goods_price)){
							$goods_price = $goods_price*100;
							$goods_price = (int)$goods_price;
							$unified = pdo_get("gpb_goods_dicount_unified",array('goods_id'=>$gid,'weid'=>$this->weid,'status'=>1,'card'=>$v['id']));
							if(empty($unified)){
								$res = pdo_insert("gpb_goods_dicount_unified",array('goods_id'=>$gid,'price'=>$goods_price,'card'=>$v['id'],'create_time'=>time(),'weid'=>$this->weid,'status'=>1));
							}else{
								if($unified['price'] != $goods_price){
									$res = pdo_update("gpb_goods_dicount_unified",array('price'=>$goods_price,'create_time'=>time()),array('id'=>$unified['id']));
								}else{
									$res = 1;
								}
							}
							if(empty($res)){
								pdo_rollback();
                				$this->message_info('会员价操作失败');exit;
							}
//						}
					}
				}else{
					//等于3 就是多规格了
					pdo_delete("gpb_goods_discount_detailed",array('goods_id'=>$gid,'weid'=>$this->weid));
					foreach($gpb_member_card as $k=>$v){
						$ggo = pdo_getall("gpb_goods_option",array('ggo_g_id'=>$gid,'weid'=>$this->weid));
						if($ggo && !empty($_GPC['goods_counts_'.$v['id']])){
							foreach($ggo as $ks=>$vs){
								$price = $_GPC['goods_counts_'.$v['id']][$ks]*100;
								$price = (int)$price;
								$goods_data_discount = array(
									'goods_id'=>$gid,
									'weid'=>$this->weid,
									'gos_id'=>$vs['ggo_id'],
									'price'=>$price,
									'caid'=>$v['id'],
									'create_time'=>time(),
								);
								$res = pdo_insert('gpb_goods_discount_detailed',$goods_data_discount);
							}
						}
					}
				}
			}
			//判断是否启用独立佣金
			if($_GPC['dis_type'] == 1){
				//启用了独立佣金
				if($distribution){
					$dis_config = $this->dodistribul();
				}
				
				if($dis_config){
					$goods_distribution = array();
					pdo_delete("gpb_goods_distribution",array('g_id'=>$gid,'weid'=>$this->weid));//先将以前的删除
					foreach($dis_config as $kk=>$vv){
						if($_GPC['dis_rule'] == 2){
							$ggo = pdo_getall("gpb_goods_option",array('ggo_g_id'=>$gid,'weid'=>$this->weid));
							foreach($ggo as $ks=>$vs){
								$price = $_GPC['distrib_'.$vv['level']][$ks];
								$goods_data_discount = array(
									'g_id'=>$gid,
									'weid'=>$this->weid,
									'ggo_id'=>$vs['ggo_id'],
									'price'=>$price,
									'level'=>$vv['level'],
									'create_time'=>time(),
								);
								$res = pdo_insert('gpb_goods_distribution',$goods_data_discount);
							}
						} else {
							$price = $_GPC['single_distribution_'.$vv['level']];
							$goods_data_discount = array(
								'g_id'=>$gid,
								'weid'=>$this->weid,
								'price'=>$price,
								'level'=>$vv['level'],
								'create_time'=>time(),
							);
							$res = pdo_insert('gpb_goods_distribution',$goods_data_discount);
						}
					}
				}
			}
            //过程4：存日志
            $data_log = [
                'gid'=>$id,
                'uid'=>$_W['uid'],
                'gs_id'=>$sid,
                "time"=>time(),
                'num'=>$save-$info[0]['num'],
                'weid'=>$weid,
            ];
            $res = pdo_insert($this->goods_stock_logs,$data_log);
            if(empty($res)){
                //回滚
                pdo_rollback();
                $this->message_info('记录库存操作日志失败');exit;
            }else{
                //每次修改了商品后都取消掉相关的购物车,不删除，慢，修改状态为3,此状态为修改了商品后取消购物车，避免之前添加购物车然后修改后购买有问题
                pdo_update('gpb_cart',array('c_status'=>3),array('c_status'=>1,'c_g_id'=>$id,'weid'=>$this->weid));
                //当虚拟人数或者虚拟份数有变化时，删除掉原来的虚拟购买记录
                if($old_g_virtual_people != $g_virtual_people ){
                    pdo_delete('gpb_activity_plugin_virtual_buy_list',array('gid'=>$gid));
                    //如果有虚拟数量
                    if(!empty($data_virtual_arr)){
                        if($virtual_people_num > 2.5*$g_virtual_people){
                            $rand_virtual_arr = pdo_fetchall("SELECT t1.* FROM " . tablename('gpb_activity_plugin_virtual_users') . " AS t1 JOIN (SELECT ROUND(RAND() * ( (SELECT MAX(uid) FROM " . tablename('gpb_activity_plugin_virtual_users') . "  )-(SELECT MIN(uid) FROM " . tablename('gpb_activity_plugin_virtual_users') . "  ))+(SELECT MIN(uid) FROM " . tablename('gpb_activity_plugin_virtual_users') . "  )) AS uid) AS t2 WHERE t1.uid >= t2.uid ORDER BY t1.uid LIMIT ".count($data_virtual_arr));
                        }else{
                            $rand_virtual_arr = pdo_fetchall("SELECT t1.* FROM " . tablename('gpb_activity_plugin_virtual_users') . " AS t1  LIMIT ".count($data_virtual_arr));
                        }
                        $start_time = intval($_GPC['add_time']);
                        if($start_time<=0){
                            $start_time = strtotime(date('Ymd',time()));
                        }
                        foreach ($data_virtual_arr as $data_virtual_arr_k=> $data_virtual_arr_v){
                            $data_virtual_buy_list=array(
                                'form'=>1,
                                'virtual_sale'=>$data_virtual_arr_v,
                                'addtime'=>time(),
                                'gid'=>$gid,
                                'virtual_buytime'=>rand($start_time,time()),
                                'virtual_uid'=>$rand_virtual_arr[$data_virtual_arr_k]['uid'],
                                'weid'=>$this->weid
                            );
                            pdo_insert('gpb_activity_plugin_virtual_buy_list',$data_virtual_buy_list);
                        }
                    }
                }

                pdo_commit();
                $this->message_info('操作成功', $this->createWebUrl('goods'), 'success');
			}
		}else{
            $act_title='新增';
			if($id){
				if($distribution){
					$dis_config = $this->dodistribul();
					$dis_configs = json_encode($dis_config,JSON_UNESCAPED_UNICODE);
					$distrib_goods_price = pdo_getall("gpb_goods_distribution",array('g_id'=>$id,'weid'=>$this->weid));
					$distion_arr = [];
					if($distrib_goods_price){
						$distrib_goods_arr = [];
						foreach($distrib_goods_price as $k=>$v){
							if($v['ggo_id']){
								$distrib_goods_arr[$v['ggo_id'].'_'.$v['level']] = $v['price'];
							}
							if(empty($v['ggo_id'])){
								$distion_arr[$v['level']] = $v['price'];
							}
						}
					}
				}
                $act_title = "修改";
				$info = pdo_get($this->goods,['g_id'=>$id,'weid'=>$weid]);
				$stock = pdo_get($this->goods_stock,['goods_id'=>$info['g_id'],'weid'=>$weid]);
				$goods_option = pdo_getall($this->goods_option,array("weid"=>$weid,"ggo_g_id"=>$id),array(),'',array('ggo_id asc'));
                $goods_option_str = json_encode($goods_option);
                $spec = pdo_getall($this->spec,array("weid"=>$weid,"g_id"=>$id),array(),'',array('id asc'));
                $ids ='';
                foreach ($spec as $k=>$v){
                    $ids .=','.$v['content'];
                    $spec[$k]['content'] =explode(',',$v['content']);
                }
                if(!empty($ids)){
                    $spec_id = array_column($spec,'content');
                    $spec_item = pdo_fetchall("select * from ".tablename($this->spec_item)." where weid = ".$weid." and gsi_id in (".trim($ids,',').")");
                }
//                $count = count($spec);
                $spec_titles = '';
				$discounts = "";
				$distribution_html = "";
                foreach (($goods_option) as $k =>$v){
                    $str .= "<tr>";
					$discounts .= '<tr>';
					if($distribution){
						$distribution_html .= '<tr>';
					}
//                    $count = count($spec);
//                    foreach (array_reverse($spec) as $k =>$v){
//                        $str .="<td rowspan='".$count."'>".$v['title']."<input type='hidden' name='spec[]' value='".$v['title']."' class='ipt-goods-no am-field-valid'></td>";
//                        $count--;
//                    }
                    $row = count(explode('+',$v['ggo_title']));
                    foreach (explode('+',$v['ggo_title']) as $kk=>$vv){
                        $str .='<td data-spec-id="'.$v['ggo_id'].'">'.$vv.'</td>';
                        $discounts .='<td class="td-spec-value am-text-middle" data-spec-id="'.$v['ggo_id'].'">'.$vv.'</td>';
						if($distribution){
	                        $distribution_html .='<td class="td-spec-value am-text-middle" data-spec-id="'.$v['ggo_id'].'">'.$vv.'</td>';
						}
                        $row--;
                    }
                    $spec_titles .= '|'.$v['ggo_title'];
                    $str .='
<td><input type="text" name="spec_sn[]" value="'.$v['ggo_goodssn'].'" class="ipt-goods-no " data-spec-id="'.$v['ggo_title'].'"></td>
<td><input type="number" name="spec_price[]" value="'.$v['ggo_market_price'].'" class="checkNum ipt-w80" data-spec-id="'.$v['ggo_title'].'"></td>
<td><input type="number" name="spec_line_price[]" value="'.$v['ggo_old_price'].'" class="checkNum ipt-w80" data-spec-id="'.$v['ggo_title'].'"></td>
<td><input type="number" name="spec_stock[]" value="'.$v['ggo_stock'].'" class="ipt-w80 spec_stock" data-spec-id="'.$v['ggo_title'].'"></td>
<td><input type="number" name="spec_weight[]" value="'.$v['ggo_weight'].'" class=" ipt-w80" data-spec-id="'.$v['ggo_title'].'"></td>';
                    $str .= "</tr>";
					if(!empty($gpb_member_card)){
						foreach($gpb_member_card as $c_k=>$c_v){
							$gpb_goods_discount_detailed = pdo_get("gpb_goods_discount_detailed",array('goods_id'=>$id,'weid'=>$this->weid,'caid'=>$c_v['id'],'gos_id'=>$v['ggo_id']));
							$discounts .= '<td><input type="text" name="goods_counts_'.$c_v['id'].'[]" value="'.$gpb_goods_discount_detailed['price']/100 .'" class="ipt-goods-no" data-spec-id="'.$v['ggo_title'].'"></td>';
						}
					}
					if($distribution){
						foreach($dis_config as $vq){
							$distribution_html .= '<td><input type="text" name="distrib_'.$vq['level'].'[]" value="'.$distrib_goods_arr[$v['ggo_id']."_".$vq['level']].'" class="ipt-goods-no " data-spec-id="'.$v['ggo_title'].'"></td>';
						}
//						$distribution_html .= '<td><input type="text" name="distrib_1[]" value="'.$distrib_goods_arr[$v['ggo_id']."_1"].'" class="ipt-goods-no "></td><td><input type="text" name="distrib_2[]" value="'.$distrib_goods_arr[$v['ggo_id']."_2"].'" class="ipt-goods-no "></td><td><input type="text" name="distrib_3[]" value="'.$distrib_goods_arr[$v['ggo_id']."_3"].'" class="ipt-goods-no "></td>';
						$distribution_html .= "</tr>";
					}
					
					$discounts .= "</tr>";
                }
                $spec_titles = trim($spec_titles,'|');
                //$spec_item = pdo_getall($this->spec_item,array("weid"=>$weid,"gsi_id in"=>trim($ids,',')));

                //修改时读取原来选择的分类
                $old_cates_arr = pdo_getall('gpb_goods_to_category',array('weid'=>$weid,'goods_id'=>$id));
                $old_cates = array();
                foreach ($old_cates_arr as $k =>$v){
                    $old_cates[] =  $v['cate_id'];
                }
				if($info['member_card_discount'] != 1 && $gpb_member_card){
					if($info['member_card_discount'] == 2){
						//统一设置
						if($gpb_member_card){
							foreach($gpb_member_card as $ks=>$vs){
								$cards = pdo_get('gpb_goods_dicount_unified',array('goods_id'=>$id,'weid'=>$this->weid,'card'=>$vs['id']));
								$gpb_member_card[$ks]['price'] = $cards['price'];
							}
						}
					}else if($info['member_card_discount'] == 3){
						//详细  多规格
						$discount_detailed = $discounts;//这是html代码  直接显示在页面上的
					}
				}
			}
            //读取供应商
            //看是否是供应商进入的
            $supplier_role = pdo_get('gpb_supplier',array('weid'=>$weid,'uid'=>$_W['uid']));
            if(!empty($supplier_role)){
                $this->supplier_role=1;
                $supplier = pdo_getall('gpb_supplier',array('weid'=>$weid,'gsp_is_del'=>1,'gsp_status'=>1,'uid'=>$_W['uid']));
            }else{
                $supplier = pdo_getall('gpb_supplier',array('weid'=>$weid,'gsp_is_del'=>1,'gsp_status'=>1));
            }
			//读取运费模版
            $express_shipping = pdo_getall("gpb_express_shipping",array("weid"=>$weid,"isdefault"=>1,'is_del'=>1,'is_del'=>1));
		}
        //检查缓存
        $cate  = cache_load('goods_cate'.$weid);
        if(empty($cate)) {
            $data = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc;");
            $infos = $this->getTree($data,"gc_id","gc_pid");
            cache_write('goods_cate'.$weid,$infos);
        }
        $cate  = cache_load('goods_cate'.$weid);
        //检查是否开启积分商城
        $fraction="";
        if(file_exists("../addons/group_buy_plugin_fraction")){
            $fraction = 1;
        }else{
            $fraction = 0;
        }
//		echo '<pre>';
		//print_r($info);exit;
	break;
	case 'save':
	break;
	case 'del':

		if($id){
			$res = pdo_update($this->goods,['g_is_del'=>2],['g_id'=>$id,'weid'=>$weid]);
			if($res){
				echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
			}else{
				echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
			}
		}else{
			echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
		}
	break;
    case 'setOnline':
        if($id){
            $status = pdo_getcolumn($this->goods,['g_id'=>$id,'weid'=>$weid],'g_is_online');
            $res = pdo_update($this->goods,['g_is_online'=>-$status],['g_id'=>$id,'weid'=>$weid]);
            if($res and $status ==-1 ){
                echo json_encode(['status'=>0,'msg'=>'上架成功']);exit;
            }else if( $res and $status ==1 ){
                echo json_encode(['status'=>0,'msg'=>'下架成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'操作失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;

    case 'setOnlines':
        $act = trim($_GPC['act']);
        $gid = trim($_GPC['gid'],',');

        if(empty($act) || empty($gid)) {
            echo json_encode(['status'=>1,'msg'=>'参数错误']);exit;
        }
        $gid = explode(",",$gid);
        pdo_begin();
        foreach ($gid as $k => $v){
            if( $act == 'up'){
                $res = pdo_update($this->goods,['g_is_online'=>1],['g_id'=>$v,'weid'=>$weid]);
            }elseif($act == "down"){
                $res = pdo_update($this->goods,['g_is_online'=>-1],['g_id'=>$v,'weid'=>$weid]);
            }else{
                pdo_rollback();
                echo json_encode(['status'=>1,'msg'=>'非法操作']);exit;
            }
        }
        pdo_commit();
        echo json_encode(['status'=>0,'msg'=>'操作成功']);exit;
        break;
    case 'cate':
        //检查缓存
//        方案一：使用递归后缓存，
//        if(empty(cache_load('goods_cate'))) {
//            $data = pdo_fetchall("select * from ".tablename($this->goods_cate)." where gc_is_del = 1 order by gc_pid asc,gc_order asc;");
//            $info = $this->getTree($data,"gc_id","gc_pid");
//            cache_write('goods_cate',$info);
//        }
//        $info  = cache_load('goods_cate');
//      方案二：先查顶级，异步
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //逻辑：昵称是模糊查询
        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
            $where .= " and ( m_nickname like '%".trim($_GPC['title'])."%' ";
            //逻辑：编号是确定查询 和昵称是 或者关系
            if(  isset($_GPC['num']) and !empty($_GPC['num']) ) {
                $where .= " or m_id = ".trim($_GPC['num'])." )";
            } else{
                $where .= " )";
            }
        } elseif( isset($_GPC['num']) and !empty($_GPC['num']) ) {
            $where .= " and m_id = ".trim($_GPC['num']);
        }

        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and gc_level = 0 and (`type` <>2 or `type` is null)");
        //$page = pagination($total,$pageIndex,$pageSize);
        //var_dump($total);
        //获取分页信息
        $sql = "select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and gc_pid = 0 and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc;";
        $info = pdo_fetchall($sql);
        foreach ($info as $k=>$val){
            $infos = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and gc_pid =".$val['gc_id']." and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc limit 1;");
            if($infos){
               $info[$k]['child']=1;
            }else{
                $info[$k]['child']=0;
            }
        }

        //cache_delete('goods_cate');
        break;
    case 'cateAdd':
        if($_GPC['submit'] == '提交'){
            //提交数据
            $title = trim($_GPC['title']);
            $pid= trim($_GPC['pid']);
            $level= Intval($_GPC['level']);
            $tree = trim($_GPC['tree']);
            $show= Intval($_GPC['show']);
            $icon = trim($_GPC['single-image']);
            $order= Intval($_GPC['order_num']);
            $index_show= Intval($_GPC['index_show']);

            if(empty($title) ){
                $this->message_info('请输入分类名称');exit;
            }
            if($pid == "" || $pid ==null || !isset($pid) ){
                $this->message_info('请选择上级分类');exit;
            }
            if(empty($show) ){
                $this->message_info('请选择是否分类页显示');exit;
            }
            if(empty($index_show) ){
                $this->message_info('请选择是否首页显示');exit;
            }
            $data = [
                'gc_name'=>$title,
                'gc_pid'=>$pid,
                'gc_level'=>++$level,
                'gc_tree'=>$tree.",".$pid,
                'gc_status'=>$show,
                'gc_icon'=>$icon,
                'gc_order'=>$order,
                'weid'=>$weid,
                'gc_is_index_show'=>$index_show
            ];
            if($id){
                $data["gc_update_time"] = time();
                $res = pdo_update($this->goods_cate,$data,['gc_id'=>$id]);
            }else{
                $data["gc_add_time"] = time();
                $res = pdo_insert($this->goods_cate,$data);
            }
            if(empty($res)){
                $this->message_info('操作失败');
            }else{
                if($id and $pid==0 and $show==1){
                    pdo_update($this->goods_cate,array('gc_status'=>1),array('gc_pid'=>$id,'weid'=>$weid));
                }
                cache_delete('goods_cate'.$weid);
                $this->message_info('操作成功', $this->createWebUrl('goods',array("op"=>'cate')), 'success');
            }
        }else{
            if($id){
                $act = "新增分类";
//                $info = pdo_get($this->goods_cate,['gc_id'=>$GET['id']]);
                $info = pdo_fetch("  select * from ".tablename($this->goods_cate)." where weid =".$weid." and  (`type` <>2 or `type` is null) and gc_id = ".$id);
                $act = "修改分类";
            }

        }
        //检查缓存
        $cate  = cache_load('goods_cate'.$weid);
        if(empty($cate)) {
            $data = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc;");
            $cate = $this->getTree($data,"gc_id","gc_pid");
            cache_write('goods_cate'.$weid,$cate);
        }else{
	        $cate  = cache_load('goods_cate'.$weid);
        }
        break;
    case 'cateDel':
        if($id){
//            $count = $query->from(tablename($this->goods_cate),"c")->where('c.gc_pid',$id)->where('c.gc_is_del',1)->count();
//            print_r($query->getLastQuery());
            $count = pdo_fetchcolumn("select count(*) from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and (`type` <>2 or `type` is null) and gc_pid =".$id);
//            var_dump("select count(*) from ".tablename($this->goods_cate)." where gc_is_del = 1 and gc_pid =".$id);
            $goods_cate_count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_goods_to_category')." as gtc left join ".tablename('gpb_goods')." as g on g.g_id=gtc.goods_id  where gtc.weid=".$weid." and gtc.cate_id =".$id." and g.g_is_del!=1");
            if( $count > 0 || $goods_cate_count>0){
                echo json_encode(['status'=>1,'msg'=>'存在下级分类或商品，不能删除']);exit;
            }else{
                $res = pdo_update($this->goods_cate,['gc_is_del'=>-1],['gc_id'=>$id,'weid'=>$weid]);
                if($res){
                    cache_delete('goods_cate'.$weid);
                    echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
                }else{
                    echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
                }
            }

        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
    case "getSub":
        $pid = intval($_GPC['pid']);
        $act = trim($_GPC['act']);
        $info = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and gc_pid =".$pid." and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc;");
        if( !$info ) {
            echo json_encode(['status' => 1, 'msg' => '下属暂无分类']);
            exit;
        }
        foreach ($info as $k=>$val){
            $infos = pdo_fetchall("select * from ".tablename($this->goods_cate)." where weid=".$weid." and gc_is_del = 1 and gc_pid =".$val['gc_id']." and (`type` <>2 or `type` is null) order by gc_pid asc,gc_order asc limit 1;");
            if($infos){
                $info[$k]['child']=1;
            }else{
                $info[$k]['child']=0;
            }
        }
        switch ( $act ){
            case "cate":
                $str = "";
                foreach ( $info as $k => $item ){
                    $icon = empty($item['gc_icon'])?"resource/images/nopic-107.png":"/attachment/".$item['gc_icon'];
                    $fa=empty($item['child'])?'fa-minus-square':'fa-plus-square';
                    if($item['gc_level'] == 1){
                        $prefixname = "<b class='line clear-m4'>└─</b>";
                    }else if( $item['gc_level'] > 1 ){
                        $prefixname = "<b class='line clear-m4'>└─</b>".str_repeat("<b class='line clear-m4'>&nbsp;──</b>",$item['gc_level']-1);
//                        $name = str_repeat("&nbsp;",$item['gc_level']-1);
                    }


                    if(empty($item['child']) &&  $item['gc_level']){
                        $fa='';

                    }

                    $show = $item['gc_status'] == 1?'<span class="text-info">√</span>':'<span class="text-danger">×</span>';
                    $index_show = $item['gc_is_index_show'] == 1?'<span class="text-info">√</span>':'<span class="text-danger">×</span>';
                    $action = '<a href="'.$this->createWebUrl('goods',array('op'=>'cateAdd','id'=>$item['gc_id'])).'"  class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> 修改</a> <a class="btn btn-danger btn-xs" onclick="deletes('.$item['gc_id'].')"><i class="fa fa-trash-o"></i> 删除</a>';
                    $str .='<tr class="show-'.$item['gc_pid'].'"><td class="get-sub text-info" data-id="'.$item['gc_id'].'">'.$prefixname.'<i class="fa '.$fa.' text-info"></i>&nbsp;&nbsp;'.$item['gc_name'].'</td><!--<td>'.$item['gc_name'].'</td> <td><img src="'.$icon.'" width="50"/></td>--><td>'.$item['gc_order'].'</td><td>'.$show.'</td><td>'.$index_show.'</td><td>'.$action.'</td></tr>';
                }
                echo json_encode(['status'=>0,'msg'=>'删除成功','data'=>$str]);exit;
                break;
        }
        //点击确定生成规格和规格参数
        break;

    case "sureSpec":
        $spec = trim($_GPC['spec'],',');
        $spec_item = trim($_GPC['spec_item'],',');
        $spec_arr = explode(',',$spec);
//        $old =
        $str = "";
        $str = "
        <div class='goods-spec-line am-margin-top-lg am-margin-bottom-lg'></div>
            <div class='spec-batch am-form-inline'>
            </div>
            <table class='spec-sku-tabel am-table am-table-bordered am-table-centered am-margin-bottom-xs am-text-nowrap'>
                <tbody>
                    <tr>";
        foreach ($spec_arr as $k=> $v){
            $str = "<th>".$v."</th>";
        }
        $str .= "   <th>规格商品编码</th>
                    <th>销售价</th>
                    <th>划线价</th>
                    <th>库存</th>
                    <th>重量</th>
                    </tr>";
        $str .=    "</tbody>
            </table>
        ";
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
                $this->message_info("修改配置成功",$this->createWebUrl('goods',array('op'=>'config')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
        }else{
            //详情页活动及价格背景图设置
            $goods_info_action_price_bg = pdo_get($this->config,array('key'=>'goods_info_action_price_bg','weid'=>$weid));
            if(empty($goods_info_action_price_bg) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('详情页活动及价格背景','','10',".time().",".$weid.",1,'goods_info_action_price_bg');");
            }
            //是否开启首图视频显示
            $is_open_goods_video = pdo_get($this->config,array('key'=>'is_open_goods_video','weid'=>$weid));
            if(empty($is_open_goods_video) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启首图视频显示','1','10',".time().",".$weid.",1,'is_open_goods_video');");
            }
            //详情页服务说明描述
            $goods_info_sever_des =  pdo_get($this->config,array('key'=>'goods_info_sever_des','weid'=>$weid));
            if(empty($goods_info_sever_des) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('详情页服务说明描述','','10',".time().",".$weid.",1,'goods_info_sever_des');");
            }
            //商品分类页是否开启搜索
            $goods_cate_open_search =  pdo_get($this->config,array('key'=>'goods_cate_open_search','weid'=>$weid));
            if(empty($goods_cate_open_search) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('商品分类页是否开启搜索','','10',".time().",".$weid.",1,'goods_cate_open_search');");
            }
            //商品详情页是否显示邻居购买
            $goods_info_open_near =  pdo_get($this->config,array('key'=>'goods_info_open_near','weid'=>$weid));
            if(empty($goods_info_open_near) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('商品详情页是否显示邻居购买','1','10',".time().",".$weid.",1,'goods_info_open_near');");
            }
            //商品分类页是否显示团长专属
            $goods_info_open_enjoy =  pdo_get($this->config,array('key'=>'goods_info_open_enjoy','weid'=>$weid));
            if(empty($goods_info_open_enjoy) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('商品分类页是否显示团长专属','1','10',".time().",".$weid.",1,'goods_info_open_enjoy');");
            }
            //商品详情页微信分享的背景图
            $goods_info_share_bg =  pdo_get($this->config,array('key'=>'goods_info_share_bg','weid'=>$weid));
            if(empty($goods_info_share_bg) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('商品详情页微信分享的背景图','/addons/group_buy/public/bg/goods_info_share_bg.jpg','10',".time().",".$weid.",1,'goods_info_share_bg');");
            }
            //商品详情页海报分享的背景图
            $goods_info_playbill_bg =  pdo_get($this->config,array('key'=>'goods_info_playbill_bg','weid'=>$weid));
            if(empty($goods_info_playbill_bg) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('商品详情页海报分享的背景图','/addons/group_buy/public/bg/goods_info_playbill_bg.jpg','10',".time().",".$weid.",1,'goods_info_playbill_bg');");
            }
            //商品详情页秒杀图标
            $goods_info_seckill_icon =  pdo_get($this->config,array('key'=>'goods_info_seckill_icon','weid'=>$weid));
            if(empty($goods_info_seckill_icon) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('商品详情页秒杀图标','/addons/group_buy/public/bg/seckill_goods_info_icon.png','10',".time().",".$weid.",1,'goods_info_seckill_icon');");
            }
            //商品详情页秒杀价格背景色
            $goods_info_seckill_price_bg =  pdo_get($this->config,array('key'=>'goods_info_seckill_price_bg','weid'=>$weid));
            if(empty($goods_info_seckill_price_bg) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('商品详情页秒杀价格背景色','#fde529','10',".time().",".$weid.",1,'goods_info_seckill_price_bg');");
            }
            //商品分类页面显示内容
            $goods_cate_show_type =  pdo_get($this->config,array('key'=>'goods_cate_show_type','weid'=>$weid));
            if(empty($goods_cate_show_type) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('商品分类页面显示内容','1','10',".time().",".$weid.",1,'goods_cate_show_type');");
            }
            //商品详情页面能否点击进入购买记录页
            $open_see_buypeople_info =  pdo_get($this->config,array('key'=>'open_see_buypeople_info','weid'=>$weid));
            if(empty($open_see_buypeople_info) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('商品详情页面能否点击进入购买记录页','1','10',".time().",".$weid.",1,'open_see_buypeople_info');");
            }
            $is_open_commodity =  pdo_get($this->config,array('key'=>'open_commodity','weid'=>$weid));
            if(empty($is_open_commodity) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('商品分享样式','1','10',".time().",".$weid.",1,'open_commodity');");
            }
            $info = pdo_getall($this->config,['status'=>1,'type'=>10,'weid'=>$weid],array(),"key");
        }
        break;
    case "editText":
        $key = trim($_GPC['key']);
        $id = trim($_GPC['id']);
        $val = trim($_GPC['val']);
        if(empty($key)){
            echo json_encode(['status'=>1,'msg'=>'参数错误','data'=>array()]);exit;
        }
        if(empty($id)){
            echo json_encode(['status'=>1,'msg'=>'未查询到商品','data'=>array()]);exit;
        }
        if(empty($val)){
            echo json_encode(['status'=>1,'msg'=>'未改变值','data'=>array()]);exit;
        }
        $res = pdo_update($this->goods,array($key=>$val),array("g_id"=>$id,'weid'=>$weid));
        if(!empty($res)){
            echo json_encode(['status'=>0,'msg'=>'修改成功','data'=>array('val'=>sprintf("%.2f",$val))]);exit;
        }else{
            echo json_encode(['status'=>1,'msg'=>'修改失败','data'=>array()]);exit;
        }
        break;
    case "changeCateLink":
        //由于分类功能改动，将分类数据转移到关系表
        $goods = pdo_getall($this->goods,array('weid'=>$weid,'g_cid !='=>''));
        if(!empty($goods) && is_array($goods)){
            foreach ($goods  as $k => $v){
                if(!empty($v['g_cid'])){
                    $data = array('weid'=>$weid,'goods_id'=>$v['g_id'],'cate_id'=>$v['g_cid']);
                    $old = pdo_get('gpb_goods_to_category',$data);
                    if(empty($old)){
                        pdo_insert('gpb_goods_to_category',$data);
                    }
//                    pdo_update($this->goods,array('g_cid'=>''),array('g_id'=>$v['g_id']));
                }
            }
        }
        $this->message_info("更新成功",$this->createWebUrl('goods',array('op'=>'config')),'success');
        break;
    case 'state':
        $id = $_GPC['goods_id'];//商品id
        if(empty($id)){
            echo json_encode(['status'=>1,'msg'=>'请传入商品id','data'=>array()]);exit;
        }
        $val = $_GPC['val'];
//        var_dump($val);exit;
        if(empty($val) && $val!=0){
            echo json_encode(['status'=>1,'msg'=>'请传入修改的状态码','data'=>array()]);exit;
        }

        if($_GPC['type']=="g_is_full_reduce" || $_GPC['type']=="g_is_top"){
            $goods=pdo_get($this->goods,array('weid'=>$weid,'g_id'=>$id));
            if($goods['g_is_head_enjoy']==1){
                echo json_encode(['status'=>1,'msg'=>'团长专享商品不参与','data'=>array()]);exit;
            }
        }
        $res = pdo_update($this->goods,array($_GPC['type']=>$val),array('g_id'=>$id));
        if($res){
            echo json_encode(['status'=>0,'msg'=>'更新成功','data'=>array()]);exit;
        }else{
            echo json_encode(['status'=>1,'msg'=>'更新失败','data'=>array()]);exit;
        }
        break;
    case 'realdel':

        if($id){
            $res = pdo_delete($this->goods,array('g_id'=>$id,'weid'=>$weid));
            if($res){
                echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
    break;
	case 'id_option':
		//获取商品的库存
		$str = '';
		$spec = pdo_getall($this->spec,array("weid"=>$weid,"g_id"=>$id),array(),'',array('id asc'));
		if($spec){
			$str .= "<tr>";
			foreach(array_reverse($spec) as $k=>$v){
				$str .= '<th>'.$v['title'].'</th>';
			}
			$str .= '<th>规格商品编码</th>';
			$str .= '<th>销售价</th>';
			$str .= '<th>划线价</th>';
			$str .= '<th>库存</th>';
			$str .= '<th>重量(kg)</th>';
			$str .= "</tr>";
		}
		$goods_option = pdo_getall($this->goods_option,array("weid"=>$weid,"ggo_g_id"=>$id),array(),'',array('ggo_id asc'));
		$goods_option_str = json_encode($goods_option);
		foreach ($goods_option as $k =>$v){
			$str .= "<tr>";
            $row = count(explode('+',$v['ggo_title']));
            foreach (explode('+',$v['ggo_title']) as $kk=>$vv){
                $str .='<td data-spec-id="'.$v['ggo_id'].'">'.$vv.'</td>';
                $row--;
            }
            $spec_titles .= '|'.$v['ggo_title'];
            $str .='
			<td><input type="text" readonly="" name="spec_sn[]" value="'.$v['ggo_goodssn'].'" class="ipt-goods-no " data-spec-id="'.$v['ggo_title'].'"></td>
			<td><input type="number" readonly="" name="spec_price[]" value="'.$v['ggo_market_price'].'" class="checkNum ipt-w80" data-spec-id="'.$v['ggo_title'].'"></td>
			<td><input type="number" readonly="" name="spec_line_price[]" value="'.$v['ggo_old_price'].'" class="checkNum ipt-w80" data-spec-id="'.$v['ggo_title'].'"></td>
			<td><input type="number" readonly="" name="spec_stock[]" value="'.$v['ggo_stock'].'" class="ipt-w80 spec_stock" data-spec-id="'.$v['ggo_title'].'"></td>
			<td><input type="number" readonly="" name="spec_weight[]" value="'.$v['ggo_weight'].'" class=" ipt-w80" data-spec-id="'.$v['ggo_title'].'"></td>';
        	$str .= "</tr>";
		}
//		echo $str;
//		exit;
	break;
    case 'uploadGoods':
        exit(var_dump($_GPC));
    break;

    case 'taobaoCopy':
        $excelurl = $_W['siteroot'] . 'addons/group_buy/public/test.xlsx';
        $zipurl = $_W['siteroot'] . 'addons/group_buy/public/test.zip';

        if($_GPC['submit'] == '提交'){

            set_time_limit(0);
            $filename = $_FILES['excel']['name'];
            $tmpname = $_FILES['excel']['tmp_name'];

            $path = '../attachment/csv/';
            if(!file_exists('../attachment/csv/')){
                mkdir('../attachment/csv/');
            }

            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (($ext != 'xlsx') && ($ext != 'xls')) {
                $this->message_info('请上传excel文件');

            }
            $file = time() . $weid . '.' . $ext;
            $uploadfile = $path . $file;
            $result = move_uploaded_file($tmpname, $uploadfile);
            // 加载zip
            $imagePath = '../attachment/images/' . date('Y') . '/' . date('m') . '/';
            try {
                $this->get_zip_originalsize($_FILES['zip']['tmp_name'], $imagePath);
            } catch (\Exception $e) {
                unlink($uploadfile);
                $this->message_info('上传失败');

            }
            require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel/Reader/CSV.php';
            // 读取Excel文件
            $reader= PHPExcel_IOFactory::createReader(($ext == 'xls' ? 'Excel5' : 'Excel2007'));
            $excel = $reader->load($uploadfile);
            $sheet = $excel->getActiveSheet();

            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $highestColumnCount = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $row = 1;
            $colIndex = [];
            $arr = [];
            while ($row <= $highestRow) {
                $rowValue = array();
                $col = 0;
                while ($col < $highestColumnCount) {
                    $rowValue[] = (string)$sheet->getCellByColumnAndRow($col, $row)->getValue();
                    ++$col;
                }
                if(count($rowValue) == 0){
                    unlink($uploadfile);

                    $this->message_info('上传文件内容不符合规范');
                }else{
                    if($row == 1){

                    }else if($row == 2){
                        $colIndex = array_flip($rowValue);
                    }else if($row == 3){

                    }else{
                        $newItem = [
                            'title' => $rowValue[$colIndex['title']],
                            'price' => $rowValue[$colIndex['price']],
                            'num' => $rowValue[$colIndex['num']],
                            'description' => $rowValue[$colIndex['description']],
                        ];
                        $picContents = $rowValue[$colIndex['picture']];
                        $allpics = explode(';', $picContents);
                        $pics = array();
                        $optionpics = array();

                        foreach ($allpics as $imgurl) {
                            if (empty($imgurl)) {
                                continue;
                            }

                            $picDetail = explode('|', $imgurl);
                            $picDetail = explode(':', $picDetail[0]);
                            $imgRootUrl = 'images/' . date('Y') . '/' . date('m') . '/' . $picDetail[0] . '.png';
                            $imgurl = $imagePath . $picDetail[0] . '.png';
                            if (@fopen($imgurl, 'r')) {
                                if ($picDetail[1] == 1) {
                                    $pics[] = $imgRootUrl;
                                }

                                if ($picDetail[1] == 2) {
                                    $optionpics[$picDetail[0]] = $imgRootUrl;
                                }
                            }
                        }

                        $newItem['pics'] = $pics;

                            if(count($newItem) == 0){

                                $this->message_info("没有数据", $this->createWebUrl('goods'), 'success');
                            }
                            $data = [
                                'g_name'=>$newItem['title'],
                                'g_old_price'=>$newItem['price'],
                                'g_price'=>$newItem['price'],
                                'g_sale_num'=>0,
                                'g_icon'=>count($newItem['pics']) >= 1 ? $newItem['pics'][0] : '',
                                'g_thumb'=>@implode(",",$newItem['pics']),
                                'g_info'=>$newItem['description'],
                                'g_is_online'=>-1,
                                'weid'=>$weid,
                            ];
                        $data['g_add_time']=time();

                        $res = pdo_insert($this->goods,$data);
                        $gid = pdo_insertid();
                        if($gid){
                            $arr[] = $gid;
                        }
                    }
                }
                ++$row;
            }
            $count = count($arr);
            unlink($uploadfile);

            $this->message_info("共导入".$count."条数据", $this->createWebUrl('goods',array('status'=>'30')), 'success');

        }
    break;
}
include $this -> template('web/' . $do . '/' . $op);
?>