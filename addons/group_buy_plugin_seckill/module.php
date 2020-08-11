<?php
/**
 * 微商城公告模块定义
 *
 * @author 微擎团队
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Group_buy_plugin_seckillModule extends WeModule
{
    public function welcomeDisplay()
    {
        header("Location:".$this->createWebUrl('index',array('op'=>'index')));exit;
    }


}