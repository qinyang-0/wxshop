<?php
/**
 * Created by PhpStorm.
 * User: orichi
 * Date: 2020/5/12
 * Time: 14:54
 */
global $_W,$_GPC;

$name = IA_ROOT."/addons/group_buy/{$_GPC['filename']}.zip";
$res = receive_stream_file($name);
$f = file_put_contents(IA_ROOT."/addons/group_buy/{$_GPC['filename']}_log.txt",serialize($res),FILE_APPEND);
echo "success";
die;
function receive_stream_file($receive_file_name)
{
    global $_GPC;
    $stream_data = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';      //  使用 $GLOBALS['HTTP_RAW_POST_DATA'] 接收数据
    if (empty($stream_data)) {      //  不存在数据则使用 file_get_contents 方式来接收
        $stream_data = file_get_contents('php://input');
    }
    $result = false;
    if ($stream_data != '') {
        if(!empty($_GPC['chunk']) && $_GPC['chunk']>1){
            $result = file_put_contents($receive_file_name, $stream_data, FILE_APPEND);        //  保存文件
        }else{
            $result = file_put_contents($receive_file_name, $stream_data, true);        //  保存文件
        }
    }
    return $result;
}