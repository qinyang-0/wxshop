<?php
/**
 * showdoc
 * @catalog 团购/模块/inc/web
 * @title wxappconf.inc
 * @method     POST
 * @url 清除缓存及修改密码
 * @param
 * @return
 * @return_param
 */
global $_W,$_GPC;
//ini_set('display_errors',1);
//error_reporting(E_ALL);
$op = !empty($_GPC['op'])?$_GPC['op']:'wxapp';
switch($op){

    case 'clearcache':
        cache_clean();
        $this->message_info("缓存清除成功",$this->createWebUrl('overview'),'success');
        break;

    case 'changepsw':
        //修改账号密码
        if(!empty($_POST) && !empty($_POST['submit'])){
            $post = $_POST;
            unset($post['submit']);
            $uid = $_W['user']['uid'];
            if(empty($post['old'])){
                $this->message_info("请输入旧密码",'','error');
                die;
            }
            if(empty($post['psw'])){
                $this->message_info("请输入新密码",'','error');
                die;
            }
            if(empty($post['psw2'])){
                $this->message_info("请再次输入新密码",'','error');
                die;
            }
            if($post['psw']!=$post['psw2']){
                $this->message_info("两次密码输入不一致，请重新输入",'','error');
                die;
            }
            $post_data = [
                'type'=>'password',
                'newpwd'=>$post['psw'],
                'renewpwd'=>$post['psw2'],
                'uid'=>$uid,
            ];
            $user_info = pdo_get("users",['uid'=>$uid]);
            if(empty($user_info)){
                $this->message_info("修改失败，请刷新重试",'','error');
                die;
            }
            $old = user_password($post['old'],$uid);
            if($old!=$user_info['password']){
                $this->message_info("原密码错误，请重新输入",'','error');
                die;
            }
            $new = user_password($post['psw'],$uid);
            $res = pdo_update("users",['password'=>$new],['uid'=>$uid]);
            $res?$this->message_info("修改成功"):$this->message_info("修改失败",'','error');
            die;
        }
        break;
}
include $this -> template('web/wxappconfig/' . $op);