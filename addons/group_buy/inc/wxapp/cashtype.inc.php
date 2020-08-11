<?php
/**
 * Created by PhpStorm.
 * 提现方式接口配置
 * User: 周龙
 * Date: 2020/3/9
 * Time: 09:36
 */
global $_W,$_GPC;
if(empty($this->weid)){
    $this->weid = !empty($this->weid)?$this->weid:(!empty($_W['uniacid'])?$_W['uniacid']:$_GPC['i']);
}

$type = pdo_fetchcolumn("select `value` from ".tablename("gpb_config")." where `key`='cash_type' and weid={$this->weid}");
$type = unserialize($type);
if(empty($type)){
    //无配置，默认全显示
    $type = [
        1,2,3
    ];
}
$this->result(0,'获取成功',$type);