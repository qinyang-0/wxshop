<?php
/**
 * showdoc
 * @catalog 团购/模块
 * @title vreceiveupdate
 * @method     POST
 * @url 接收流推送保存文件
 * @param
 * @return
 * @return_param
 */
if(!empty($_GET['debug'])){
    ini_set('display_errors',1);
    error_reporting(E_ALL);
}
$name = "../{$_GET['filename']}.zip";
$res = receive_stream_file($name);
$f = file_put_contents("../{$_GET['filename']}_log.txt",serialize($res),FILE_APPEND);
echo "success";
die;
function receive_stream_file($receive_file_name)
{
    $stream_data = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';//使用$GLOBALS['HTTP_RAW_POST_DATA'] 接收数据
    if (empty($stream_data)) {
        //不存在数据则使用 file_get_contents 方式来接收
        $stream_data = file_get_contents('php://input');
    }
    $result = false;
    if ($stream_data != '') {
        if(!empty($_GET['chunk']) && $_GET['chunk']>1){
            $result = file_put_contents($receive_file_name, $stream_data, FILE_APPEND);//保存文件
        }else{
            $result = file_put_contents($receive_file_name, $stream_data, true);//保存文件
        }
    }
    return $result;
}