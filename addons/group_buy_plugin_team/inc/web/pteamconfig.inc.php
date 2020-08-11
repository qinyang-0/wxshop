<?php
/**
 * Created by PhpStorm.
 * User: orichi
 * Date: 2019/11/8
 * Time: 17:51
 */
global $_W,$_GPC;
include_once '../addons/group_buy_plugin_team/function.php';
$op = !empty($_GPC['op'])?$_GPC['op']:'list';
if(!empty($_POST)){
    $info = serialize($_POST);
    //修改
    $data = [
        'value'=>$info,
        'utime'=>time(),
    ];
    if(getconfig("pteam_config")===false){
        $data['ctime'] = time();
        $data['name'] = "pteam_config";
        $data['status'] = 1;
        $data['type'] = 1;
        $data['weid'] = $this->weid;
        $res = pdo_insert("gpb_pteam_config",$data);
    }else{
        $res = pdo_update("gpb_pteam_config",$data,['weid'=>$this->weid,'name'=>'pteam_config']);
    }
    $res?$this->message_info("保存成功",'','success'):$this->message_info("保存失败或未变动",'','success');
    exit;
}
//读取配置表内容
$list = getconfig("pteam_config");
//exit(dump($list));
include $this -> template('web/teambuy/pteamconfig');