<?php
/**
 * Created by PhpStorm.
 * User: orichi
 * Date: 2019/9/27
 * Time: 14:04
 */
global $_W,$_GPC;
include_once '../addons/group_buy_plugin_team/function.php';
$op = !empty($_GPC['op'])?$_GPC['op']:'list';
switch ($op){
    case 'list':
        //条件组合
        $condition = ' and a.weid='.$this->weid." and m.weid={$this->weid}";
        //团队状态
        if(isset($_GPC['state']) && $_GPC['state']!='all'){
            $condition .= " and a.`state`='{$_GPC['state']}'";
        }else{
            $condition .= " and a.`state`!='1'";
        }
        //时间区间
        if(!empty($_GPC['time'])){
            $star_time = strtotime(date("Y-m-d",strtotime($_GPC['time']['start'])));
            $end_time = strtotime(date("Y-m-d",strtotime($_GPC['time']['end'])));
            $end_time = intval($end_time)+(24*3600);
            $condition .= " and a.ctime between {$star_time} and {$end_time}";
        }
        //获取列表
        $total = pdo_fetchcolumn("select count(*) from ".tablename("gpb_pteam_activity")." as a left join ".tablename("gpb_member")." as m on m_id=a.leaderid left join ".tablename("gpb_pteam_list")." as l on a.pl_id=l.id where a.`status`=1 {$condition}");
        $p = !empty($_GPC['page'])?$_GPC['page']:1;
        $pagesize = 15;
        $limit = ($p-1)*$pagesize;
        $limit = "{$limit},{$pagesize}";
        $pager = pagination($total, $p, $pagesize);
        $list = pdo_fetchall("select a.*,l.goods_image,l.goods_title,l.is_ladder,l.is_spec,m.m_nickname,m.m_photo,l.price from ".tablename("gpb_pteam_activity")." as a left join ".tablename("gpb_member")." as m on m_id=a.leaderid left join ".tablename("gpb_pteam_list")." as l on a.pl_id=l.id where a.`status`=1 {$condition} order by a.ctime desc limit {$limit}");
        break;
    case 'infomation':
        //拼团详情
        //获取当前团详情
        $id = intval($_GPC['id']);
        if($id<1){
            $this->message_info("参数错误！");
        }
        $info = pdo_get("gpb_pteam_activity",array('id'=>$id,'status'=>1));
        if(empty($info)){
            $this->message_info("拼团不存在！");
        }
        //获取当前活动订单
        $list = pdo_fetchall("select * from ".tablename("gpb_pteam_order")." as po left join ".tablename("gpb_order_snapshot")." as os on po.osn=os.oss_go_code where po.lid={$id} and po.aid={$info['aid']} and os.oss_is_seckill=3 and os.state=2");

        break;
}

include_once $this->template("web/teambuy/team{$op}");