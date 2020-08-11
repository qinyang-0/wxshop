<?php
if(!function_exists('e')){
	function e($data=[],$type = 1){
		echo '<pre>';
		var_dump($data);
		if($type){
			exit;
		}
	}
}

function sucs($erron,$msg='',$data=[]){
	echo json_encode(array('code'=>$erron,'msg'=>$msg,'data'=>$data));exit;
}
function friendlyDate($time=''){
	if(empty($time)){
		return false;
	}
	$fdate = "";
	$d = time() - intval($time);
	$ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); //得出年
	$md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); //得出月
	$byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
	$yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
	$dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天
	$td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); //明天
	$atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); //后天
	if ($d == 0) {
		$fdate = '刚刚';
	} else {
		switch ($d) {
			case $d < $atd:
				$fdate = date('Y年m月d日', $time);
				break;
			case $d < $td:
				$fdate = '后天' . date('H:i', $time);
				break;
			case $d < 0:
				$fdate = '明天' . date('H:i', $time);
				break;
			case $d < 60:
				$fdate = $d . '秒前';
				break;
			case $d < 3600:
				$fdate = floor($d / 60) . '分钟前';
				break;
			case $d < $dd:
				$fdate = floor($d / 3600) . '小时前';
				break;
			case $d < $yd:
				$fdate = '昨天' . date('H:i', $time);
				break;
			case $d < $byd:
				$fdate = '前天' . date('H:i', $time);
				break;
			case $d < $md:
				$fdate = date('m月d日 H:i', $time);
				break;
			case $d < $ld:
				$fdate = date('m月d日', $time);
				break;
			default:
				$fdate = date('Y年m月d日', $time);
				break;
		}
	}
	return $fdate;
}
/**
 * 新增日志
 */
function gpb_log($string,$type='index'){
	$time = strtotime(date("Y-m-d",time()));
	$filename = "../addons/group_buy_plugin_bargain/log/".$type.'/'.$time.".log";
	if(file_exists($filename)){
		$handle = fopen($filename, 'a+');
	} else {
		$handle = fopen($filename, 'w');
	}
	$time = date("Y-m-d H:i:s",time());
	$time .= " :".$string."\r\n";
	fwrite($handle,$time);
	fclose($handle);
	return true;
}
/**
 * 判断字符串是否base64编码
 */
function func_is_base64($str){
    return $str == base64_encode(base64_decode($str)) ? true : false;  
}



?>