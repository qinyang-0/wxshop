<?php
/**
 * Created by PhpStorm.
 * User: orichi
 * Date: 2020/2/27
 * Time: 16:29
 */
include_once '../addons/group_buy/SubMsg.php';
global $_W,$_GPC;
$submsg = new \SubMsg();
$op = !empty($_GPC['op'])?$_GPC['op']:'gettmpid';
switch ($op){
    case 'gettmpid':
        $tmpid = $submsg->getalltmp();
        $this -> result("0", "获取成功",['tid'=>$tmpid]);
        exit ;
        break;
}