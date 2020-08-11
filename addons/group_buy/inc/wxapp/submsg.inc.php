<?php
/**
 * Created by PhpStorm.
 * User: orichi
 * Date: 2020/2/25
 * Time: 09:59
 */
include_once '../addons/group_buy/SubWechat.php';
global $_W,$_GPC;
echo "909090<br/>";
$submsg = new \SubWechat();
echo "22222<br/>";
$info = $submsg->sendunimsg('tmp_leader','oLf4B0bm-0PiHMtR1ycmWARlcTTU',['测试一下','123123','测试发送','20.00元','已付款','2020-03-02 09:00:00','测试说明']);
echo "33333<br/>";
echo "<pre/>";
var_dump($info);
