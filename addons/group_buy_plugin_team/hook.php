<?php
/**
 * 团购拼团插件
 *
 * @author 微擎团队
 * @url
 */
defined('IN_IA') or exit('Access Denied');
//define('QRCODEPATH','/addons/group_buy/public/images/');
include_once '../addons/group_buy_plugin_team/teambuy.php';
include_once '../addons/group_buy_plugin_team/function.php';
include_once '../addons/group_buy/function.php';
include_once '../addons/group_buy/sms.php';
include_once '../addons/group_buy/SubMsg.php';
ini_set('date.timezone','Asia/Shanghai');
class Group_buy_plugin_teamModuleHook extends WeModuleHook {
    public $weid;
    private $uid;
    private $team;
	public function __construct()
    {
        global $_W,$_GPC;
        $this->weid = $_W['uniacid'];
//        exit(var_dump($_GPC['openid']));
        $this->team = new teambuy($this->weid);
        if(!empty($_GPC['openid'])){
            $user_id = pdo_get("gpb_member",['weid'=>$this->weid,'m_openid'=>$_GPC['openid']]);
            $this->uid = $user_id['m_id'];
        }
    }

    public function hookPageTeam_ispteam($hook){
	    global $_W;
	    $gid = $hook['g_id'];
	    //查询是否存在并在时间范围内
        $time = time();
        $has = pdo_fetch("select count(*) as has,id as plid from ".tablename("gpb_pteam_list")." where star_time< {$time} and end_time> {$time} and `status`=1 and `state`=1 and gid={$gid}");

        $this->apireturn("获取成功",0,$has);
    }

    //拼团列表
    public function hookPageTeam_list($hook){
	    global  $_W;
        $time = time();
        //处理所有过期活动
        pdo_run("update ".tablename("gpb_pteam_list")." set `state`=-1 where end_time<={$time} and `status`=1 and `state`=1");
        //列表条件组成
	    $where = "pl.weid={$this->weid} and pl.star_time<{$time} and pl.end_time>{$time} and pl.state=1 and pl.`status`=1 and g.g_is_del=1 and g.g_is_online=1";
	    //分页处理
	    $total = pdo_fetchcolumn("select count(*) from ".tablename("gpb_pteam_list")." as pl join ".tablename("gpb_goods")." as g on g.g_id=pl.gid where {$where}");
	    $page = !empty($hook['page'])?$hook['page']:1;
	    $size = 10;
        $all_page = intval($total/$size);
        if($all_page==0 && $total>0){
            $all_page = 1;
        }
	    $limit = ($page-1)*$size;
	    $limit = "{$limit},{$size}";
	    $list = pdo_fetchall("select * from ".tablename("gpb_pteam_list")." as pl join ".tablename("gpb_goods")." as g on g.g_id=pl.gid where {$where} order by pl.sort desc,pl.id desc limit {$limit}");
	    //图片处理
	    foreach ($list as $k=>$v){
//	        $list[$k]['goods_img'] = tomedia($v['goods_img']);
	        $list[$k]['goods_image'] = tomedia($v['goods_image']);
	        $banner = explode(",",$v['banner']);
	        if(is_array($banner)){
	            $tmp = [];
	            foreach ($banner as $kk=>$vv){
                    $tmp[] = tomedia($vv);
                }
                $list[$k]['banner'] = $tmp;
            }else{
                $list[$k]['banner'] = tomedia($v['banner']);
            }

        }
	    $list = array(
	        'data'=>$list,
            'total'=>$total,
            'all_page'=>$all_page,
        );
	    $this->apireturn("获取成功",0,$list);
    }







    //是否为拼团商品
    public function hookPageTeam_isactivegoods($hook){
	    $time = time();
	    $info = pdo_fetch("select * from ".tablename("gpb_pteam_list")." where `gid`={$hook['g_id']} and star_time<{$time} and end_time>{$time} and is_sale=1");
	    if(empty($info)){
            $this->apireturn('暂无拼团');
        }
        //数据重组
        $arr = [];
	    $goods_num = $info['goods_num'];
	    if($info['is_spec']==1){
	        //多规格商品
            $spec = unserialize($info['spec_info']);
            $spec = quick_sort($spec,'price');
            $first = current($spec);
            $min = $first['price'];
            $last = end($spec);
//            exit(dump($last));
            $max = $last['price'];
            if($min!=$max){
                $arr['price'] = "{$min}-{$max}";
            }else{
                $arr['price'] = $min;
            }
            $arr['goods_num'] = 0;
            foreach ($spec as $k=>$v){
                $arr['goods_num'] += $v['num'];
            }
        }
        if($info['is_ladder']==1){
	        //阶梯团
            $ladder = unserialize($info['ladder_info']);
            $ladder = quick_sort($ladder,'price');
            $first = current($ladder);
            $min = $first['price'];
            $last = end($ladder);
            $max = $last['price'];
            if($min!=$max){
                $arr['price'] = "{$min}-{$max}";
            }else{
                $arr['price'] = $min;
            }
            $arr['goods_num'] = 0;
            foreach ($ladder as $k=>$v){
                $arr['goods_num'] += $v['num'];
            }
        }
        $arr['buy_num'] = intval($info['virtual_num'])+intval($info['all_num']);
	    $arr['goods_num'] = intval($info['virtual_num'])+intval($goods_num);
	    $this->apireturn('获取成功',0,$arr);
    }



    //获取所有团购商品
    public function hookPageTeam_index($hook){
	    global $_W;
	    $time = time();
	    $total = pdo_fetchcolumn("select count(*) from ".tablename("gpb_pteam_list")." where `status`=1 and `star_time`>{$time} and `end_time`<{$time}");
	    $p = !empty($hook['page'])?$hook['page']:1;
	    $pagesize = 20;
	    $limit = ($p-1)*$pagesize;
	    $limit = "{$limit},{$pagesize}";

	    $list = pdo_fetchall("select * from ".tablename("gpb_pteam_list")." where `status`=1 and `star_time`<{$time} and `end_time`>{$time} and state=1 order by utime desc limit {$limit}");
	    $list = $this->getnewlist($list);

	    $this->apireturn('获取成功',0,$list);
    }
    //获取团购详情页数据
    public function hookPageTeam_detail($hook){
	    global $_W;
	    $time = time();
	    $id = $hook['lid'];
	    //根据活动id获取活动详情
        $info = pdo_fetch("select * from ".tablename("gpb_pteam_list")." where `status`=1 and `star_time`<{$time} and `end_time`>{$time} and state=1 and id={$id}");
        if(empty($info)){
            $this->apireturn('活动不存在，或已结束');
        }
        //数据重组
        if($info['is_spec']==1){
            //多规格
            $spec = unserialize($info['spec_info']);
            $spec = quick_sort($spec,'price');
            $first = current($spec);
            $last = end($spec);
            $min = $first['price'];
            $max = $last['price'];
            $old_min = $first['old_price'];
            $old_max = $first['old_price'];
            $goods_num = 0;
            if($min!=$max){
                $info['price'] = "{$min}-{$max}";
            }else{
                $info['price'] = "{$min}";
            }
            if($old_min!=$old_max){
                $info['old_price'] = "{$old_min}-{$old_max}";
            }else{
                $info['old_price'] = $old_min;
            }
            foreach ($spec as $k=>$v){
                $goods_num +=$v['num'];
            }
            $info['spec_info'] = unserialize($info['spec_info']);
        }
        if($info['is_ladder']==1){
            //阶梯团
            $ladder = unserialize($info['ladder_info']);
//            exit(dump($ladder));
            $ladder = quick_sort($ladder,'price');
//            exit(dump($ladder));
            $first = current($ladder);
            $last = end($ladder);
            $min = $first['price'];
            $max = $last['price'];
            $old_min = $first['old_price'];
            $old_max = $first['old_price'];
            $goods_num = 0;
            if($min!=$max){
                $info['price'] = "{$min}-{$max}";
            }else{
                $info['price'] = "{$min}";
            }
            if($old_min!=$old_max){
                $info['old_price'] = "{$old_min}-{$old_max}";
            }else{
                $info['old_price'] = $old_min;
            }
            foreach ($ladder as $k=>$v){
                $goods_num += intval($v['num']);
            }
            $info['ladder_info'] = $ladder;
        }
        //剩余数量
        $info['less_num'] = intval($info['goods_num'])-intval($info['all_num']);
        //缩略图
        $info['goods_image'] = $_W['attachurl'].$info['goods_image'];
        $banner = explode(",",$info['banner']);
        foreach ($banner as $k=>$v){
            $banner[$k] = $_W['attachurl'].$v;
        }
        $info['banner'] = $banner;
        //其他商品信息
        $info['goods_infomation'] = pdo_get("gpb_goods",array('g_id'=>$info['gid']));

        $this->apireturn("获取成功",0,$info);
    }
    //获取用户订单列表
    public function hookPageTeam_orderlist($hook){
	    $openid = $hook['openid'];
	    //获取用户对应uid
        $user = pdo_get("gpb_member",array('m_openid'=>$openid,'weid'=>$this->weid));
        $uid = $user['m_id'];
        //获取订单
        $list = pdo_fetchall("select * from ".tablename("gpb_order_snapshot")." as os join ".tablename("gpb_goods")." as g on os.oss_gid=g.g_id where g.weid={$this->weid} and ");

    }
    //获取某活动已开的团
    public function hookPageTeam_activeteam($hook){
	    $aid = $hook['lid'];
	    $time = time();
	    $p = !empty($hook['page'])?$hook['page']:1;
	    $size = 10;
	    $limit = ($p-1)*$size;
	    $limit = "{$limit},{$size}";
	    $active_list = pdo_fetchall("select pa.*,pl.is_ladder,pl.spec_info,pl.ladder_info,pl.star_time as act_star_time,pl.end_time as act_end_time from ".tablename("gpb_pteam_activity")." as pa join ".tablename("gpb_pteam_list")." as pl on pa.pl_id=pl.id where pa.`pl_id`={$aid} and pa.`state`=2 and pa.end_time>{$time} and pa.`status`=1 and pl.star_time<{$time} and pl.end_time>{$time} and pl.status=1 and pl.state=1  and pl.weid={$this->weid} limit {$limit}");
	    foreach ($active_list as $k=>$v){
            $header = pdo_fetch("select * from ".tablename("gpb_member")." where `m_openid`='{$v['leader_openid']}' and weid={$this->weid}");
            $active_list[$k]['header'] = $header['m_photo'];
	        $active_list[$k]['less'] = intval($v['all_num'])-intval($v['now_num']);
	        if($v['is_spec']==1){
	            $active_list[$k]['spec_info'] = unserialize($v['spec_info']);
            }
            if($v['is_ladder']==1){
                $active_list[$k]['ladder_info'] = unserialize($v['ladder_info']);
            }
        }
	    $this->apireturn('获取成功',0,$active_list);
    }
    //生成拼团订单
    public function hookPageTeam_setorder($hook){
	    $data = [
	        'lid'=>$hook['lid'],
            'aid'=>$hook['aid'],
            'osn'=>$hook['osn'],
            'openid'=>$hook['openid'],
            'weid'=>$this->weid,
            'state'=>0,
            'leaderid'=>$hook['pid'],
            'pay_type'=>$hook['pay_type'],
            'num'=>$hook['num'],
            'money'=>$hook['money'],
        ];
	    //订单生成
        $res = pdo_insert("gpb_pteam_order",$data);
        if(!$res){
            return $this->arrayreturn('订单生成失败');
        }
        $id = pdo_insertid();
        $this->arrayreturn("订单生成成功",0,['po_id'=>$id]);
    }
    //获取拼团配置
    public function hookPageTeam_getconf($hook){
	    global $_W;
	    $conf = getconfig("pteam_config");
	    if($conf===false){
	        $conf = [];
        }
        $conf['pteam_img'] = $_W['attachurl'].$conf['pteam_img'];
        $conf['pteam_share_img'] = $_W['attachurl'].$conf['pteam_share_img'];
	    $this->apireturn("获取成功",0,$conf);
    }
    //用户发起拼团
    public function hookPageTeam_create($hook){
	    $openid = $hook['openid'];
	    $lid = $hook['lid'];
	    $gid = $hook['gid'];
	    //获取活动详情
        $info = pdo_fetch("select * from ".tablename("gpb_pteam_list")." where id={$lid}");
        //是否有正在进行中的团
        $has_team = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where pl_id={$lid} and `leader_openid`='{$openid}' and (`state`=2 or `state`=1) and `end_time`>".time());
        if($has_team){
            $this->apireturn("您已经发起了其他拼团，请完成或过期后再重新发起");
        }
        //是否参加了别的团并未结束
        $has_join = pdo_fetch("select * from ".tablename("gpb_pteam_order")." as po join ".tablename("gpb_pteam_activity")." as pa on pa.id=po.aid and pa.pl_id=po.lid where po.lid={$lid} and po.`openid`='{$openid}' and  pa.pl_id={$lid} and pa.`leader_openid`!='{$openid}' and (pa.`state`=2 or pa.`state`=1) and pa.end_time>".time());
        if($has_join){
            $this->apireturn("您还有正在参加的拼团，请完成或过期后再重新发起");
        }
	    //获取开团信息
        $num = pdo_fetchcolumn("select count(*) from ".tablename("gpb_pteam_order")." where `lid`={$lid} and `openid`='{$openid}' and weid = {$this->weid} and `state`>0 and `state`<5");
        //购买次数限制
        if($num>=$info['buy_num'] && $info['buy_num']!=0){
            $this->apireturn("已超出购买限制");
        }
        //是否已是其他未完成团团长
        $has = pdo_fetch("select * from ".tablename("gpb_pteam_order")." where lid={$lid} and leader_openid='{$openid}' and state=2");
        if(!empty($has)){
            $this->apireturn("您已经发起过拼团了");
        }
        //新增拼团
        $user = pdo_fetch("select * from ".tablename("gpb_member")." where m_openid='{$openid}' and weid='{$this->weid}'");
        $endtime = intval(time())+doubleval($info['limit_time']);
        $data = array(
            'leaderid'=>$user['m_id'],
            'pl_id'=>$lid,
            'star_time'=>time(),
            'end_time'=>$endtime,
            'state'=>1,
            'status'=>1,
            'now_num'=>0,
            'ctime'=>time(),
            'utime'=>time(),
            'weid'=>$this->weid,
            'leader_openid'=>"{$openid}",
        );
        //详情组合
        $act_info = $info;
        //是否阶梯团
        if($info['is_ladder']==1){
            //阶梯团获取选择开团人数
            $pop = trim($hook['pop']);
            //取对应阶梯团数据
            $ladder_info = unserialize($info['ladder_info']);
            //获取对应人数信息
            $now_ladder = array();
            foreach ($ladder_info as $k=>$v){
                if($v['num']==$pop){
                    $now_ladder = $v;
                }
            }
            if(empty($now_ladder)){
                $this->apireturn("您选择人数不存在！");
            }
            $act_info['goods_num'] = $now_ladder['num'];
            $act_info['price'] = $now_ladder['price'];
            $act_info['old_price'] = $now_ladder['old_price'];
            $act_info['team_num'] = $pop;
            //库存检查
            if(($now_ladder['num']-$pop)<0){
                $this->apireturn("库存不足");
            }
        }

        //是否为多规格商品
        if($info['is_spec']==1){
            //获取当前规格信息
            $spec_info = unserialize($info['spec_info']);
            $spec = trim($hook['spec']);
            $now_spec = $spec_info[$spec];
            $act_info['goods_num'] = $now_spec['num'];
            $act_info['price'] = $now_spec['price'];
            $act_info['old_price'] = $now_spec['old_price'];
            $act_info['team_num'] = $info['team_num'];
            //库存检查
            if(($info['goods_num']-$info['all_num']-$info['team_num'])<0){
                $this->apireturn("库存不足");
            }
        }

        $data['info'] = serialize($act_info);

        //团队总人数
        if(!empty($act_info)){
            $data['all_num'] = $act_info['team_num'];
        }

        $res = pdo_insert("gpb_pteam_activity",$data);
        $id = pdo_insertid();

        $this->apireturn("添加成功",0,array('id'=>$id,'info'=>$data));
    }

    //支付成功后加入拼团并扣库存
    public function hookPageTeam_jointeam($hook){
	    global $_W;
	    $openid = $hook['openid'];
	    $aid = $hook['aid'];
	    $oss_ggo_id = $hook['oss_ggo_id'];
	    $osn = $hook['osn'];
	    $buy_num = $hook['buy_num'];
	    $time = intval(time());
	    //2020-02-09 周龙 添加判断订单是否已处理
        $has_over = pdo_get('gpb_pteam_order',array('osn'=>$osn,'weid'=>$this->weid,'openid'=>$openid,'state'=>2));
        if(!empty($has_over)){
            $this->apireturn("参加成功",0);
        }

	    //查询活动是否存在
        $activ = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where `id`={$aid} and weid={$this->weid} and end_time>{$time} and all_num>now_num");
        if(empty($activ)){
            $this->apireturn("拼团不存在，或已满员");
        }
        //是否有正在进行中的团
        $has_team = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where id != {$aid} and pl_id={$activ['pl_id']} and (`state`=2 or `state`=1 ) and `end_time`>".time()." and leader_openid='{$openid}'");
        if($has_team){
            $this->apireturn("您已经发起了其他拼团!");
        }
        //是否参加了别的团并未结束
        $has_join = pdo_fetch("select * from ".tablename("gpb_pteam_order")." as po join ".tablename("gpb_pteam_activity")." as pa on pa.id=po.aid and pa.pl_id=po.lid where po.lid={$activ['pl_id']} and po.aid!={$aid} and po.`openid`='{$openid}' and  pa.pl_id={$activ['pl_id']} and pa.`leader_openid`!='{$openid}' and (pa.`state`=2 or pa.`state`=1) and pa.end_time>".time());
        if($has_join){
            $this->apireturn("您还有正在参加的拼团！");
        }
        //是否团长支付
        if($activ['state']===1 || $activ['state']==='1'){
            if($activ['leader_openid']!=$openid){
                $this->apireturn("团队不存在");
            }
            pdo_update("gpb_pteam_activity",array('state'=>2),array('id'=>$aid,'weid'=>$this->weid));
        }

        //验证订单是否已处理
        $has_over = pdo_get('gpb_pteam_order',array('osn'=>$osn,'weid'=>$this->weid,'openid'=>$openid,'state'=>2));
        if(!empty($has_over)){
            $this->apireturn("参加成功",0);
        }


        //活动存在
        //销量+1
        if(($activ['now_num']+1)<$activ['all_num']){
            $sql = "update ".tablename("gpb_pteam_activity")." set  now_num = now_num + 1 where `id`={$aid} and `weid`={$this->weid}";
        }else{
            //拼团成功
            $sql = "update ".tablename("gpb_pteam_activity")." set  now_num = now_num + 1,`state`=10 where `id`={$aid} and `weid`={$this->weid}";
        }
        pdo_run($sql);
        $actlist = pdo_fetch("select * from ".tablename("gpb_pteam_list")." where id={$activ['pl_id']}");
        if(!empty($oss_ggo_id) && $actlist['is_spec']==1){
            //多规格 库存扣除
            $spec_info = unserialize($actlist['spec_info']);
            foreach ($spec_info as $k=>$v){
                if($k==$oss_ggo_id){
                    //减少库存
                    $spec_info[$k]['num']--;
                }
            }
            $spec_info = serialize($spec_info);
            pdo_run("update ".tablename("gpb_pteam_list")." set `spec_info`='{$spec_info}' where id={$activ['pl_id']}");
        }
        //库存-1
        $sql = "update ".tablename("gpb_pteam_list")." set `all_num`=`all_num`-1,`goods_num`=`goods_num`-1 where `id`={$activ['pl_id']} and weid={$this->weid}";
        pdo_run($sql);
        //拼团订单生成
        $p_oder = pdo_get("gpb_order",array('go_code'=>$osn,'weid'=>$this->weid));
        $user = pdo_get("gpb_member",array('m_openid'=>$openid,'weid'=>$this->weid));
        //是否存在拼团订单
        $pteam_order = pdo_get('gpb_pteam_order',array('osn'=>$osn,'weid'=>$this->weid,'openid'=>$openid));
        /*echo "<pre/>";
        pdo_debug();
        exit(dump($pteam_order));*/
        if(!empty($pteam_order)){
            //更新订单状态
            $data = [
                'state'=>2,
                'utime'=>time(),
            ];
            pdo_update("gpb_pteam_order",$data,['id'=>$pteam_order['id']]);
            if(($activ['now_num']+1)==$activ['all_num']){
                //发送模板消息
                $order_list = pdo_fetchall("select * from ".tablename("gpb_pteam_order")." where weid={$this->weid} and aid={$activ['id']} and `state`=2");
                $gid = pdo_fetchcolumn("select gid from ".tablename("gpb_pteam_list")." where id={$activ['pl_id']}");
                foreach ($order_list as $k=>$v){
                    $msg_goods_name = pdo_fetchcolumn("select g_name from ".tablename("gpb_goods")." where g_id={$gid} and weid={$this->weid}");
                    $msg_nickname = pdo_fetchcolumn("select m_nickname from ".tablename("gpb_member")." where m_openid='{$activ['leader_openid']}' and `weid`={$this->weid}");

                    $msg_nickname = base64_encode(base64_decode($msg_nickname))==$msg_nickname ? base64_decode($msg_nickname) : $msg_nickname;

                    $msg = [
                        '1'=>$v['osn'],
                        '2'=>$msg_goods_name,
                        '3'=>$msg_nickname,
                        '4'=>"{$v['money']}元",
                        '5'=>$activ['all_num']
                    ];
                    $v['openid'] = pdo_fetchcolumn("select openid from ".tablename("gpb_order")." where go_code='{$v['osn']}'");
                    //发送成团通知
                    $sms = new \sms();
                    $this->Token();
                    $msg_return = $sms->send_out('AT0051',$msg, $_W['account']['access_tokne'],$v['openid'],'',$v['suc_form'],$this->weid,'AT0051');

                    //新增订阅消息 周龙 2020-02-27
                    $submsg = new \SubMsg();
                    $sub_arr = [
                        mb_substr($v['osn'],0,20),
                        $msg_goods_name,
                        '团长:'.$msg_nickname,
                        "{$v['money']}元",
                        '成团人数:'.$activ['all_num']
                    ];
                    $submsg->sendmsg("pteam_suc",$v['openid'],$sub_arr);


//                    exit(dump($msg_return));
                }
            }
        }else{
            $order = array(
                'aid'=>$activ['id'],
                'lid'=>$activ['pl_id'],
                'osn'=>$osn,
                'state'=>2,
                'num'=>$buy_num,
                'uid'=>$user['m_id'],
                'openid'=>$openid,
                'weid'=>$this->weid,
                'status'=>1,
                'ctime'=>$time,
                'utime'=>$time,
                'suc_form'=>!empty($_GPC['suc_form'])?$_GPC['suc_form']:'',
                'fail_form'=>!empty($_GPC['fail_form'])?$_GPC['fail_form']:'',
                'money'=>$p_oder['go_real_price']-$p_oder['go_send_pay'],
            );
            pdo_insert("gpb_pteam_order",$order);
        }
        $this->apireturn("参加成功",0);
    }

    //拼团订单查询接口
    public function hookPageTeam_orderchange($hook){
	    global $_W;
	    $gid = $hook['go_code'];
	    include_once "../addons/group_buy_plugin_team/site.php";
	    $site = new \Group_buy_plugin_teamModuleSite();
        $site->change_order_status($gid);
    }

    //拼团失败，退款流程
    public function hookPageTeam_fail($hook){
	    global $_W;
	    $aid = $hook['aid'];
	    $lid = $hook['lid'];
	    //查询是否过期
        $now_time = time();
        $active = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where `id`={$aid} and ((end_time<{$now_time} and `state`=2) or (`ctime`<".($now_time-600)." and `state`=1))");
        if(empty($active)){
            $this->apireturn("暂无活动");
        }
        //查询团长订单是否未支付



        if($active['state']==1){
            //未成团 直接取消订单
            pdo_run("update ".tablename("gpb_pteam_activity")." set `state`=-1 where id={$aid} ");
            //查询对应订单
            $porder = pdo_fetch("select * from ".tablename("gpb_pteam_order")." where aid={$aid}");
            if(!empty($porder)){
                //取消拼团订单
                pdo_run("update ".tablename("gpb_pteam_order")." set `state`=-2 where id={$porder['id']} ");
                //取消主模块订单
                pdo_run("update ".tablename("order")." set `go_sttus`=110 where go_code='{$porder['osn']}'");
            }
            $this->apireturn("执行完成");
        }

	    //获取所有该团队成员信息
        $list = pdo_fetchall("select po.*,o.openid,o.go_id,o.go_wx_price from ".tablename("gpb_pteam_order")." as po join ".tablename("gpb_order")." as o on po.osn=o.go_code where po.`aid`='{$aid}' and po.`lid`='{$lid}' and po.`state`>=1 and po.state!=5");
        //获取当前公众号信息
        $wxapp = pdo_get("account_wxapp",array('uniacid'=>$_W['uniacid']));
        $appid = $wxapp['key'];
        $secret = $wxapp['secret'];
        //获取支付信息
        $payment =  pdo_get("uni_settings",array('uniacid'=>$_W['uniacid']));
        $payment = unserialize($payment['payment']);
        $payment = $payment['wechat'];
        $mchid = $payment['mchid'];
        $key = $payment['signkey'];
        //是否上传统一证书配置
        if(!empty($payment['wechat_refund']['cert']) && !empty($payment['wechat_refund']['key'])){
            $apiclient_arr = array(
                'cert'=>$payment['wechat_refund']['cert'],
                'key'=>$payment['wechat_refund']['key'],
            );
        }else{
            //获取单独配置
            $cert = pdo_fetch("select value from ".tablename("gpb_config")." where `weid`='{$_W['uniacid']}' and `key`='cert_address'");
            $keypem = pdo_fetch("select value from ".tablename("gpb_config")." where `weid`='{$_W['uniacid']}' and `key`='key_address'");
            $apiclient_arr = array(
                'cert'=>"..".$cert['value'],
                'key'=>"..".$keypem['value'],
            );
        }
        if(empty($list)){
            $this->apireturn("数据不存在");
        }
        foreach ($list as $k=>$v){
            //用户退款
            $openid = $v['openid'];
            $sn = !empty($v['pay_sn'])?$v['pay_sn']:$v['osn'];
            $money = doubleval($v['money']);
            $money = $money*100;
            //获取用户信息
            $member = pdo_get("gpb_member",array('weid'=>$this->weid,'m_openid'=>$v['openid']));
            if($v['go_wx_price']>0){
                //微信支付退款
                $res = wx_cannelorder($appid,$mchid,$key,$money,$money,$apiclient_arr,$_W['siteroot']."addons/group_buy_plugin_team/return.php",'',$sn);
                $recharge_log_data = array(
                    'st'=>1,
                    'uid'=>$member['m_id'],
                    'openid'=>$member['m_openid'],
                    'info'=>'拼团失败退款'.$v['money'].'退还至微信',
                    'type'=>3,
                    'status'=>1,
                    'create_time'=>time(),
                    'weid'=>$this->weid,
                    'money'=>$v['money'],
                    'l_type'=>1,
                    'remarks'=>'订单号：'.$v['go_code'],
                    'pay_f'=>3
                );
                if($res['return_code']=='SUCCESS' && $res['return_msg']=='OK' ){
                    $res = true;
                }else{
                    $res = false;
                }
            }else{
                //余额支付退款
                $res = pdo_update("gpb_member",array("m_money_balance +="=>$v['money']),array("m_openid"=>$v['openid'],'weid'=>$this->weid));

                $recharge_log_data = array(
                    'st'=>1,
                    'uid'=>$member['m_id'],
                    'openid'=>$member['m_openid'],
                    'info'=>'拼团失败退款'.$v['money'].'退还至余额',
                    'type'=>3,
                    'status'=>1,
                    'create_time'=>time(),
                    'weid'=>$this->weid,
                    'money'=>$v['money'],
                    'l_type'=>1,
                    'remarks'=>'订单号：'.$v['go_code'],
                    'pay_f'=>3
                );

            }

            if($res){
                //修改订单状态
                $update = array(
                    'state'=>'-2',
                    'utime'=>time(),
                );
                //日志存入
                $recharge_log_data_res = pdo_insert('gpb_recharge_log',$recharge_log_data);
                pdo_update('gpb_pteam_order',$update,array('id'=>$v['id']));
                //修改公共订单
                $order_update = [
                    'go_status'=>'120'
                ];
                pdo_update('gpb_order',$order_update,array('go_id'=>$v['go_id']));
                if($k==count($list)-1){
                    //修改活动为失败
                    pdo_update('gpb_pteam_activity',array('state'=>-1),array('id'=>$aid));
                }
            }else{
                //自动退款失败，更改退款模式为手动退款
                $update = array(
                    'state'=>'5',
                    'utime'=>time(),
                );
                pdo_update('gpb_pteam_order',$update,array('id'=>$v['id']));
                //修改公共订单
                $order_update = [
                    'go_status'=>'120'
                ];
                pdo_update('gpb_order',$order_update,array('go_id'=>$v['go_id']));

            }
            $active_info = pdo_get("gpb_pteam_activity",array('id'=>$v['aid']));
            $list_info = pdo_get("gpb_pteam_list",array('id'=>$v['lid']));
            $pteam_time = intval($active_info['end_time'])-intval($active_info['star_time']);
            $pteam_time = $pteam_time/3600;
            //模板消息组成
            $fail_goods = pdo_fetchcolumn("select g_name from ".tablename("gpb_goods")." where g_id={$list_info['gid']}");
            $msg = [
                '1'=>$v['osn'],
                '2'=>$fail_goods,
                '3'=>"{$pteam_time}小时内未满{$v['all_num']}人",
                '4'=>"{$v['money']}元"
            ];
            //发送退款通知
            $sms = new \sms();
            $this->Token();
            $msg_return = $sms->send_out('AT0310',$msg, $_W['account']['access_tokne'],$openid,'',$v['fail_form'],$this->weid,'AT0310');

            //新增订阅消息 周龙 2020-02-27
            $submsg = new \SubMsg();
            $sub_arr = [
                mb_substr($v['osn'],0,20),
                $fail_goods,
                "{$pteam_time}小时内未满{$v['all_num']}人",
                "{$v['money']}元",
            ];
            $submsg->sendmsg("pteam_fail",$openid,$sub_arr);

//            exit(dump($msg_return));
            if($hook['debug']==1){
                dump($msg_return);
            }
            //执行后休眠1秒
            sleep(1);
        }
        $this->apireturn("执行完成");

    }

    //拼团订单状态修改
    public function checkstate($hook){
	    switch($hook['pay_type']){
            case 'wxpay':
                //微信支付
                $pay_info = json_decode($hook['wx_info'],true);
                if($pay_info['return_code']=='SUCCESS' && $pay_info['result_code']=='SUCCESS'){
                    $pay_money = $pay_info['total_fee']/100;
                    $pay_sn = $pay_info['transaction_id'];
                    $order = pdo_get("gpb_pteam_order",array('osn'=>$pay_info['out_trade_no']));
                    if(doubleval($pay_money)!=doubleval($order['money'])){
                        return $this->arrayreturn('金额不一致');
                    }
                    $pay_log = serialize($pay_info);
                }
                break;
        }
        $data = [
            'wx_log'=>$pay_log,
            'pay_type'=>$hook['pay_type'],
            'pay_time'=>time(),
            'pay_money'=>$pay_money,
            'pay_sn'=>$pay_sn,
            'state'=>1,
        ];
	    $res = pdo_update("gpb_pteam_order",$data,['osn'=>$pay_info['out_trade_no']]);

	    return $res?$this->arrayreturn("订单更新成功",0):$this->arrayreturn("订单更新失败");
    }
    //参加拼团
    public function hookPageTeam_join($hook){
	    $team_id = $hook['t_id'];
	    $time = time();
	    //获取团队信息
        $team_info = pdo_fetch("select * from ".tablename("gpb_pteam_activity")." where id={$team_id} and `state`=2 and end_time>{$time} and weid={$this->weid} and `status`=1 and now_num<all_num");
        if(empty($team_info)){
            $this->apireturn("拼团不存在或已满员");
        }


    }

    //团购数据重组
    private function getnewlist($list = []){
	    global $_W;
	    $arr = [];
	    foreach ($list as $k=>$v){
	        if($v['is_spec']==1){
	            //开启多规格商品
                $spec = unserialize($v['spec_info']);
                $spec = quick_sort($spec,'price');
                $v['spec_info'] = $spec;
                $first = current($spec);
                $min = $first['price'];
                $last = end($spec);
                $max = $last['price'];
                //价格
                if($min!=$max){
                    $v['price'] = "{$min}-{$max}";
                }else{
                    $v['price'] = $min;
                }
                //原价
                $old_min = $first['old_price'];
                $old_max = $last['old_price'];
                if($old_min!=$old_max){
                    $v['old_price'] = "{$old_min}-{$old_max}";
                }else{
                    $v['old_price'] = $old_min;
                }
                //库存
                $v['goods_num'] = 0;
                foreach ($spec as $kk=>$vv){
                    $v['goods_num'] += intval($vv['num']);
                }

            }
            if($v['is_ladder']==1){
	            //开启阶梯团
                $ladder = unserialize($v['ladder_info']);
                $ladder = quick_sort($ladder,'price');
                $v['ladder_info'] = $ladder;
                $first = current($ladder);
                $min = $first['price'];
                $last = end($ladder);
                $max = $last['price'];
                if($min!=$max){
                    $v['price'] = "{$min}-{$max}";
                }else{
                    $v['price'] = $min;
                }
                $old_min = $first['old_price'];
                $old_max = $last['old_price'];
                if($old_min!=$old_max){
                    $v['old_price'] = "{$old_min}-{$old_max}";
                }else{
                    $v['old_price'] = $old_min;
                }
                //原价
                $old_min = $first['old_price'];
                $old_max = $last['old_price'];
                if($old_min!=$old_max){
                    $v['old_price'] = "{$old_min}-{$old_max}";
                }else{
                    $v['old_price'] = $old_min;
                }
                //库存
                $v['goods_num'] = 0;
                foreach ($spec as $kk=>$vv){
                    $v['goods_num'] += intval($vv['num']);
                }
            }
            //剩余数量
            $v['less_num'] = intval($v['goods_num']) - intval($v['all_num']);
            $v['goods_image'] = $_W['attachurl'].$v['goods_image'];
	        $arr[$k] = $v;
        }
        return $arr;
    }




    /**
     * api数据返回
     */
    private function apireturn($msg='',$code = 1,$data=[]){
        echo json_encode(['errno'=>$code,'message'=>$msg,'data'=>$data]);
        exit;
    }
    /**
     * 获取access_token
     */
    public function Token(){
        global $_GPC,$_W;
        if(time() > $_W['account']['access_time'] || empty($_W['account']['access_time'])){
            //获取access_token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$_W['account']['key']."&secret=".$_W['account']['secret'];
            $list = $this->http_request($url);
            $list = json_decode($list, true);
//			echo '<pre>';
//			print_r($list);exit;
            $_W['account']['access_tokne'] = $list['access_token'];
            $_W['account']['access_time'] = time()+7150;
            return true;
        }else{
            return true;
        }
    }
    //数组返回
    private function arrayreturn($msg='',$code=1,$data=[]){
        return ['errno'=>$code,'message'=>$msg,'data'=>$data];
    }
    /**
     * 调用接口， $data是数组参数
     * @return 签名
     */
    private function http_request($url,$data = null,$headers=array())
    {
        $curl = curl_init();
        if( count($headers) >= 1 ){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}