<?php
/**
 * Created by PhpStorm.
 * User: orichi
 * Date: 2019/9/16
 * Time: 17:53
 */
global $_W,$_GPC;
$op = !empty($_GPC['op'])?$_GPC['op']:'list';
switch ($op){
    case 'list':
            $where = "";
            if(!empty($_GPC['keywords'])){
                $keywords = $_GPC['keywords'];
                if(is_numeric($keywords)){
                    //是数字
                    $where = " and g_id = {$keywords}";
                }else{
                    //是文字
                    $where = " and g_name like '%{$keywords}%'";
                }
            }
            $page = !empty($_GPC['page'])?$_GPC['page']:1;
            $size = 10;
            $count = pdo_fetchcolumn("select count(*) from ".tablename("gpb_goods")." where `weid`={$this->weid} and g_is_online=1 and g_is_del=1 and `type`=1 {$where}");
            $pager = pagination($count, $page, $size);
            $limit = ($page-1)*$size;
            $limit = "{$limit},{$size}";
            $list = pdo_fetchall("select g_name as `goods_title`,g_id as goods_id,g_icon as goods_image,g_icon as banner,g_price as old_price,g_brief from ".tablename("gpb_goods")." where `weid`={$this->weid} and g_is_online=1 and g_is_del=1 and (`type`=1 or `type` is null ) {$where} order by g_order desc limit {$limit}");
            foreach ($list as $k=>$v){
                $has = goods_activity2($v['goods_id'],0,$this->weid);
                $list[$k]['has'] = $has===true?'':$has;
            }
        break;
    case 'spec':
        if(empty($_POST['goods_id'])){
            echo json_encode(['status'=>1,'msg'=>'请先选择商品']);
            exit;
        }
        $info = pdo_fetchall("select * from ".tablename("gpb_goods_option")." where `ggo_g_id`={$_POST['goods_id']} and `ggo_is_del`=1 order by `ggo_displayorder` asc ");
        if(empty($info)){
            echo json_encode(['status'=>1,'msg'=>'该商品没有设置多规格']);
            exit;
        }
        echo json_encode(['status'=>0,'msg'=>'获取成功','data'=>$info]);
        exit;
        break;
    case 'stock':
        //获取商品剩余库存
        $gid = intval($_GPC['goods_id']);
        $num = pdo_fetchcolumn("select sum(num) from ".tablename("gpb_goods_stock")." where goods_id={$gid} and weid={$this->weid}");
        echo json_encode(['msg'=>'获取成功','status'=>0,'data'=>['num'=>$num]]);
        exit;
        break;
}
include_once $this->template("web/teambuy/goods{$op}");