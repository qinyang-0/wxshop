<?php
/**
 * 微商城公告模块定义
 *
 * @author 微擎团队
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Group_buy_plugin_distributionModule extends WeModule {
    public function welcomeDisplay()
    {
        header("Location:".$this->createWebUrl('home'));exit;
    }


}