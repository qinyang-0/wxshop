<?php
/**
 * Created by PhpStorm.
 * User: orichi
 * Date: 2020/5/25
 * Time: 10:12
 */
global $_W,$_GPC;
if(empty($this->weid)){
    return false;
}
$name = !empty($_GPC['name'])?trim($_GPC['name']):'';
if(empty($name)){
    echo json_encode(['status'=>-1,'msg'=>'参数异常']);
    die;
}
$config = pdo_fetchcolumn("select `value` from ".tablename("gpb_config")." where weid={$this->weid} and `key`='{$name}'");
echo json_encode(['status'=>0,'msg'=>'获取成功','data'=>['count'=>empty($config)?0:1,'value'=>$config]]);
die;