<?php
/**
 *
 * User: orichi
 * Date: 2019/9/16
 * Time: 15:19
 */
global $_W,$_GPC;
$op = !empty($_GPC['op'])?$_GPC['op']:'list';
switch($op){
    case 'list':
        $time = time();
        //过期自动改变未付款状态
//        pdo_run("update ".tablename("gpb_pteam_list")." set `state`=-1 where  end_time<='{$time}' and `state`=1 and `status`=1");
        //订单状态查询
        $where = "";
        $_GPC['states'] = !empty($_GPC['states'])?$_GPC['states']:1;
        switch ($_GPC['states']){
            case 1:
                //进行中
                $where .= " and  star_time <= {$time} and end_time>= {$time} and `state`=1";
            break;
            case 2:
                //已结束
                $where .= " and  (end_time<= {$time} or `state`=-1)";
            break;
            case 3:
                //未开始
                $where .= " and  star_time>= {$time} and `state`=1";
            break;
            case 4:
                //仓库中
                $where .= " and `state`=-1 and end_time>={$time} and star_time>={$time}";
            break;
        }
        $count = pdo_fetchcolumn("select count(*) from ".tablename("gpb_pteam_list")." where `status`=1 and `weid`={$this->weid} {$where}");
        $page = !empty($_GPC['page'])?$_GPC['page']:1;
        $size = 20;
        $limit = ($page-1)*$size;
        $limit = "{$limit},{$size}";
        $pager = pagination($count, $page, $size);
        $sql = "select * from ".tablename("gpb_pteam_list")." where `status`=1 and `weid`={$this->weid} {$where} order by utime desc,sort asc,ctime desc limit {$limit}";
//        exit(dump($sql));
        $list = pdo_fetchall($sql);
        //数据重组
        foreach ($list as $k=>$v){
            $list[$k]['citme'] = date("Y-m-d H:i",$v['ctime']);
            $list[$k]['uitme'] = date("Y-m-d H:i",$v['utime']);
            $list[$k]['date_star_time'] = date("Y-m-d H:i",$v['star_time']);
            $list[$k]['date_end_time'] = date("Y-m-d H:i",$v['end_time']);
//            $list[$k]['state'] = $v['state']==1?'未开始':($v['state']==2?'已开始':'已结束');
        }
//        echo "<pre/>";
//        exit(var_dump($list));
        break;
    case 'edit':
        if(!empty($_POST)){
            $data = $_POST;
//            dump($data);
            if(empty($data['weid'])){
                $data['weid'] = $this->weid;
            }

            //空数据验证
            if(empty($data['goods_title'])){
            	$this->message_info("商品标题不能为空");
            }
            if(empty($data['gid'])){
                $this->message_info("请选则商品管理");
            }
            //检查商品是否未多规格
            $goods = pdo_fetch("select * from ".tablename("gpb_goods")." where g_id={$data['gid']} and g_has_option=1");
            if(!empty($goods) && $data['is_spec']==0){
                $this->message_info("商品为多规格商品请选多规格");
            }

            if(empty($data['banner'])){
                $this->message_info("请上传至少一张图片");
            }
            /*if(empty($data['unit'])){
                message("请输入拼团单位");
            }*/
            if(empty($data['limit_time']) || doubleval($data['limit_time'])<=0){
                $this->message_info("请输入开团后时间限制");
            }
            $int_key = [
                'gid',
                'sort',
                'goods_num',
                'team_num',
                'virtual_num',
                'buy_num',
                'is_spec',
                'is_ladder',
                'state',
            ];
            $double_key = [
                'old_price',
                'price',
                'limit_time',
            ];
            //数据类型处理
            foreach ($data as $k=>$v){
                if(!empty($v) && in_array($k,$int_key)){
                    $data[$k] = intval($v);
                }
                if(!empty($v) && in_array($k,$double_key)){
                    $data[$k] = doubleval($v);
                }
            }



            //数据处理
            $data['star_time'] = strtotime($data['star_time']);
            $data['end_time'] = strtotime($data['end_time']);

            //是否阶梯团
            if($data['is_ladder']==1){
                //阶梯团数据处理
                $ladder = [];
                foreach ($data['ladder_id'] as $k=>$v){
                    $ladder[$k] = [
                        'num'=>intval($data['ladder_num'][$k]),
                        'price'=>doubleval($data['ladder_price'][$k]),
                    ];
                }
                $data['ladder_info'] = serialize($ladder);
                unset($data['ladder_id']);
                unset($data['ladder_num']);
                unset($data['ladder_price']);
            }else{
                if(!empty($data['ladder_id'])){
                    unset($data['ladder_id']);
                }
                if(!empty($data['ladder_num'])){
                    unset($data['ladder_num']);
                }
                if(!empty($data['ladder_price'])){
                    unset($data['ladder_price']);
                }

                //非阶梯团数据空处理
                if(empty($data['price']) || doubleval($data['price'])<=0){
                    $this->message_info("请输入正确的拼团价格");
                }
                if(empty($data['goods_num']) || intval($data['goods_num'])<=0){
                    $this->message_info("请输入拼团库存");
                }
                if(empty($data['team_num']) || intval($data['team_num'])<=0){
                    $this->message_info("请输入成团人数");
                }
            }
            //是否多规格
            if($data['is_spec']==1){
                //多规格数据处理
                foreach ($data['spec'] as $k=>$v){
                    if($k=='old_price' || $k=='price'){
                        $data['spec'][$k] = doubleval($v);
                    }
                    if($k=='num'){
                        $v = intval($v)<1?0:$v;
                        $data['spec'][$k] = intval($v);
                    }
                    //库存检查
                    $spec_stock = pdo_fetchcolumn("select ggo_stock from ".tablename("gpb_goods_option")." where ggo_id={$k}");
                    if($v['num']>$spec_stock){
                        message("规格{$v['title']}库存不足{$v['num']},请设置小于等于{$spec_stock}");
                    }
                }
                $data['spec_info'] = serialize($data['spec']);
                unset($data['spec']);
            }else{
                //非多规格库存处理
                $gstock = pdo_fetchcolumn("select sum(num) from ".tablename("gpb_goods_stock")." where goods_id={$data['gid']}");
                if($gstock<$data['goods_num']){
                    $this->message_info("该商品当前库存为{$gstock}，拼团库存请小于等于{$gstock}");
                }
            }
            if($data['is_spec']==1 && $data['ladder_id']==1){
                //不能同时存在
                $this->message_info("多规格和阶梯团不能同时开启");
            }
            if(is_array($data['banner'])){

                $data['goods_image'] = $data['banner'][0];
            }else{
                $data['goods_image'] = $data['banner'];
            }
            if(empty($data['goods_image'])){
                $this->message_info("请设置至少一张商品轮播图片");
            }
            $banner = implode(",",$data['banner']);
            if(!empty($banner)){
                $data['banner'] = $banner;
            }
            $data['limit_time'] = $data['limit_time']*3600;

            if(empty($data['status'])){
                $data['status'] = 1;
            }
            $data['utime'] = time();
//            exit(dump($data));
            if(empty($data['id'])){
                //新增
                //判断商品是否已上架或已有活动
                $has = pdo_fetchcolumn("select count(*) from ".tablename("gpb_pteam_list")." where gid={$data['gid']} and `state`=1 and `status`=1 and end_time>=".time());
                if($has >0){
                    $this->message_info("该商品已存在活动！请活动结束后再添加");
                }
                $data['ctime'] = time();
                $res = pdo_insert("gpb_pteam_list",$data);
            }else{
                //修改
                $id = $data['id'];
                unset($data['id']);
                $res = pdo_update("gpb_pteam_list",$data,array('id'=>$id));
            }
            $res?$this->message_info('修改成功',$this->createWebUrl('home'),'success'):$this->message_info('修改失败');
        }
        if(!empty($_GPC['aid'])){
            $info = pdo_get("gpb_pteam_list",array('id'=>$_GPC['aid']));
        }
        break;
        //上下架
    case 'online':
        //获取当前状态
        $id = $_GPC['id'];
        $info = pdo_fetch("select * from ".tablename("gpb_pteam_list")." where `id`={$id} and `status`='1'");
        if(empty($info)){
            echo json_encode(['status'=>1,'msg'=>'活动不存在或已删除']);
            exit;
        }
        $data = [];
        //是否活动开启时间内
        $time = time();
        if($info['star_time']<=$time && $info['end_time']>=$time){

        }else{
            echo json_encode(['status'=>1,'msg'=>'当前时间不在活动时间内！请修改活动时间!']);
            exit;
        }
        if($info['state']==1){
            $data['state'] = -1;
        }else{
            $data['state'] = 1;
        }
        $res = pdo_update("gpb_pteam_list",$data,['id'=>$id]);
        echo $res?json_encode(['status'=>0,'msg'=>'修改成功']):json_encode(['status'=>1,'msg'=>'修改失败或未变动']);
        exit;

        break;
    case 'delete':
        //删除商品
        $id = $_GPC['id'];
        $info = pdo_fetch("select * from ".tablename("gpb_pteam_list")." where `id`={$id} and `status`='1'");
        if(empty($info)){
            echo json_encode(['status'=>1,'msg'=>'活动不存在或已删除']);
            exit;
        }
        $data = [];
        $data['status'] = -1;
        $res = pdo_update("gpb_pteam_list",$data,['id'=>$id]);
        echo $res?json_encode(['status'=>0,'msg'=>'删除成功']):json_encode(['status'=>1,'msg'=>'活动已删除']);
        exit;
        break;
    case 'sort':
        if(empty($_POST)){
            echo json_encode(['status'=>1,'msg'=>'非法参数']);
            exit;
        }
        $id = $_POST['id'];
        $sort = $_POST['sort'];
        $info = pdo_get("gpb_pteam_list",array('id'=>$id,'weid'=>$this->weid,'status'=>1));
        if(empty($info)){
            echo json_encode(['status'=>1,'msg'=>'活动不存在或已删除']);
            exit;
        }
        if($sort==$info['sort']){
            echo json_encode(['status'=>0,'msg'=>'修改成功']);
            exit;
        }
        $res = pdo_update("gpb_pteam_list",['sort'=>$sort],array('id'=>$id,'weid'=>$this->weid,'status'=>1));
        echo $res?json_encode(['status'=>0,'msg'=>'修改成功']):json_encode(['status'=>1,'msg'=>'修改失败，请重试']);
        exit;
        break;
    case 'copy':
        //复制活动
        $id = intval($_GPC['id']);
        if($id<1){
            $this->message_info("非法参数");
        }
        //获取信息是否存在
        $info = pdo_fetch("select * from ".tablename("gpb_pteam_list")." where id={$id} and `status`=1");
        if(empty($info)){
            $this->message_info("活动不存在");
        }
        break;
}

include_once $this->template("web/teambuy/activity{$op}");