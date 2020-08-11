<?php
header('X-Accel-Buffering: no');
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
ob_end_clean();
ob_implicit_flush(1);
$url = $_REQUEST['url'];
$url = base64_decode($url);
include_once '../addons/group_buy/update.php';
$update = new AutoUpdate();

$return = $update->install($url);


//while(1){
//  $data =  [
//      "id" => time(),
//      "message" => '欢迎来到helloweba，现在是北京时间'.date('Y-m-d H:i:s')
//  ];
//  returnEventData($data);
//  sleep(2);
//}
function returnEventData($code = 1, $url=' '){
    $str = '';
	$returnData = array(
		'code'=>$code,
		'url'=>$url,
	);
    $str .= "data: {$returnData}".PHP_EOL;
    $str .= PHP_EOL;
    echo $str;
}
?>