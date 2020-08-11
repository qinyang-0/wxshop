<?php

require $_SERVER['DOCUMENT_ROOT'].'/framework/bootstrap.inc.php';

//暂不使用
$filename = $_SERVER['DOCUMENT_ROOT']."/addons/group_buy/block/inc.txt";
if(file_exists($filename)){
	$myfile = fopen($filename,'w');
} else {
	$myfile = fopen($filename,'a');
}
$data = file_get_contents("php://input");
if(xml_parser($data)){
	$data = FromXml($data);
	$str = $data['out_trade_no'].":";
	$str = str_wx_status($data,$str);
}else{
	exit('黑客?');
}
array (
  'appid' => 'wxd638314c68886fa2',
  'attach' => '2587',
  'bank_type' => 'CFT',
  'cash_fee' => '10',
  'fee_type' => 'CNY',
  'is_subscribe' => 'N',
  'mch_id' => '1482977942',
  'nonce_str' => 'OESVZYLDLAU9XE7A15E893UTKS11E3XJ',
  'openid' => 'oLf4B0RKRvsOPND25hNm4cCiz_Lg',
  'out_trade_no' => '08121157184488570',
  'result_code' => 'SUCCESS',
  'return_code' => 'SUCCESS',
  'sign' => '8A6484C373DD0BF6733DE9C8AF07388A',
  'time_end' => '20190812115738',
  'total_fee' => '10',
  'trade_type' => 'JSAPI',
  'transaction_id' => '4200000356201908122834588815',
);
fwrite($myfile, $str."\r\n");
fclose($myfile);
//echo '<pre>';
//print_r($_REQUEST);
exit;
function str_wx_status($data,$str=''){
	if($data['result_code'] == 'SUCCESS' && $data['return_code'] == 'SUCCESS'){
		//获取订单信息
		$gpb_order = $data['out_trade_no'];
		$order = pdo_get("gpb_order",array('go_code'=>$gpb_order));
		if(empty($order)){
			return $str."1";
		}
		$appid = $data['appid'];
		$weid = $order['weid'];
		//获取密匙
		$mcid = pdo_get("uni_settings",array('uniacid'=>$weid));
		if(empty($mcid['payment'])){
			return $str."3";
		}
		$payment = unserialize($mcid['payment']);
		if(empty($payment)){
			return $str.'4';
		}
		$arr = [];
		$arr['appid'] = $appid;
		$arr['mch_id'] = $payment['wechat']['mchid'];//商户号
        $arr['nonce_str'] = randomkeys(32);//随机字符串
        $urls = 'https://api.mch.weixin.qq.com/pay/orderquery';
        //foreach($info as $k=>$v){
        $arr['out_trade_no'] = $gpb_order; //拿到订单号
        $sign = MakeSign($arr, $payment['wechat']['signkey']);//算签名
        $post_xml = array_xml($data, $sign);//数组转xml
        $list = http_request($urls, $post_xml);//请求
        $list = FromXml($list);//将返回的数据转成数组
        if ($list['trade_state'] == 'SUCCESS' && $list['return_code'] == 'SUCCESS') {
        	$des = "小程序自动确认用户已支付，改变状态为已支付";	
			$min = 30;
	        //读取配置
	        $order_over_cancle = pdo_get("gpb_config", array('key' => 'order_over_cancle', 'weid' => $weid));
	        if (!empty($order_over_cancle) && !empty($order_over_cancle['value'])) {
	            $min = $order_over_cancle['value'];
	        }
			$rownum = pdo_update("gpb_order", ['go_status' => 20, 'go_pay_time' => time()], array('go_code' => $gpb_order, 'weid' => $weid,'type' => 1));
			if (empty($rownum)) {

            } else {
            	 $snapshot = pdo_getall('gpb_order_snapshot', array('oss_go_code' => $gpb_order));
				 $go_code = $gpb_order;
                 $buy_phone = $snapshot[0]['oss_buy_phone'];
				 if (!empty($snapshot)) {
	                foreach ($snapshot as $k => $val_snapshot) {
	                    $stcok = pdo_get('gpb_goods_stock', array('goods_id' => $val_snapshot['oss_gid']));//获取库存
	                    $num = $stcok['num'] - $val_snapshot['oss_g_num'];
	                    $num = $num <= 0 ? 0 : $num;
	                    $is = $stcok['sale_num'] + $val_snapshot['oss_g_num'];
	                    //获取减少库存方式
	                    $reduce_stock_type = pdo_get('gpb_config', array('key' => 'reduce_stock_type', 'weid' => $weid));
	                    //修改库存和添加销量
	                    if ($reduce_stock_type['value'] == 2) {
	                        pdo_update('gpb_goods_stock', array('sale_num' => $is), array('goods_id' => $val_snapshot['oss_gid'], 'weid' => $weid));
	                    } else {
	                        pdo_update('gpb_goods_stock', array('num' => $num, 'sale_num' => $is), array('goods_id' => $val_snapshot['oss_gid'], 'weid' => $weid));
	                    }
	                    //修改完销量  去查看商品的销量是为0  为0 下架
	                    if ($is === 0) {
	                        $res = pdo_update('gpb_goods', array('g_is_online' => -1), array('g_id' => $val_snapshot['oss_gid'], 'weid' => $weid));
	                    }
	                    //修改虚拟销售数量
	                    $sql = "update " . tablename('gpb_goods') . " set `g_sale_num` = `g_sale_num`+1 WHERE weid=" . $weid . " and `g_id` = " . $val_snapshot['oss_gid'];
	                    pdo_query($sql);
	                }
            	}
				//查看是否开启自动订单打印
                $order_print_auto_open = pdo_get('gpb_config', array('key' => 'order_print_auto_open', 'weid' => $weid));
                $order_print_auto_open_val = isset($order_print_auto_open['value']) ? $order_print_auto_open['value'] : 2;
                $order_print_auto_num = pdo_get('gpb_config', array('key' => 'order_print_auto_num', 'weid' => $weid));
                $order_print_auto_num_val = isset($order_print_auto_num['value']) ? $order_print_auto_num['value'] : 1;
				if ($order_print_auto_open_val == 1) {
                    //开启
                    //查询打印机配置
                    $print_set = pdo_get('gpb_config', array('key' => 'print_set', 'weid' => $weid));
                    $config = unserialize($print_set['value']);
                    if (empty($config) || count($config) <= 0) {
//                                echo json_encode(array('status'=>1,'msg'=>'请在配置中设置打印机'));exit;
                    } else {
                    	require $_SERVER['DOCUMENT_ROOT'].'/addons/group_buy/print_sn.php';
                        //调用打印机类
                        $print_class = new print_sn();
                        //查询打印机状态
                        $res_select = $print_class->select_print($config['print_sn']);
//                                if( $res_select["ret"]!==0 || $res_select["data"]=='离线。'){
////                                    echo json_encode(array('status'=>1,'msg'=>$res_select['msg'].','.$res_select['data']));exit;
//                                }else{
                        $goods = array();
                        $order = pdo_fetchall("select * from " . tablename('gpb_order') . " as o left join " . tablename('gpb_order_snapshot') . " as sn on sn.oss_go_code = o.go_code left join " . tablename('gpb_village') . " as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=" . $go_code . " and o.weid=" . $weid);
                        foreach ($order as $k => $val) {
                            $goods[$k]['title'] = $val['oss_g_name'];
                            $goods[$k]['price'] = $val['oss_g_price'];
                            $goods[$k]['num'] = $val['oss_g_num'];
                            $goods[$k]['spec'] = trim($val['oss_ggo_title']);
                        }
                        $adr = $order[0]['vg_address'];
                        if (!empty($order[0]['oss_address']) && $order[0]['oss_address'] != 'undefined') {
                            $adr = $order[0]['oss_address'];
                        }
                        $lead_info = array(
                            'name' => $order[0]['oss_head_name'],
                            'phone' => $order[0]['oss_head_phone'],
                        );
                        $reduce_price = 0;
                        if ($order[0]['go_fdc_price'] > 0) {
                            $reduce_price += $order[0]['go_fdc_price'];
                        }
                        if ($order[0]['go_full_reduce_price'] > 0) {
                            $reduce_price += $order[0]['go_full_reduce_price'];
                        }
                        $send_price = 0;
                        if ($order[0]['go_send_pay'] > 0) {
                            $send_price += $order[0]['go_send_pay'];
                        }
                        switch ($order[0]['go_send_type']) {
                            case '1':
                                $send_type = '自提';
                                break;
                            case '2':
                                $send_type = '团长送货';
                                break;
                            case '3':
                                $send_type = '快递';
                                break;
                            default:
                                $send_type = '自提';
                                break;
                        }
                        switch ($order[0]['go_pay_type']) {
                            case '1':
                                $pay_type = '微信支付';
                                break;
                            case '2':
                                $pay_type = '余额支付';
                                break;
                            case '3':
                                $pay_type = '余额+微信支付';
                                break;
                            default:
                                $pay_type = '微信支付';
                                break;
                        }
                        if(check_base64_out_json($order[0]['oss_address_name'])){
                            $order[0]['oss_address_name']=base64_decode($order[0]['oss_address_name']);
                        }
                        $res = $print_class->print_info($config['print_sn'], $go_code, $order[0]['oss_v_name'], $goods, $adr, $order[0]['oss_address_phone'], $order[0]['oss_address_name'], $order[0]['go_real_price'], $lead_info, $order[0]['go_comment'] = '', $qrcode = '', $order[0]['go_add_time'], '', $pay_type, $order_print_auto_num_val, $reduce_price, $send_price, $send_type);
						sleep(1);
//                                }
                    }
                }
				$info = pdo_get("gpb_order", array('go_code' => $go_code, 'weid' => $weid, 'type' => 1));
			}
		}else{
			//支付错误
			return $str."5";
		}
	}else{
		return $str."2";
	}
}
/**
 * 随机字符串
 * return string 32位随机字符串
 */
function randomkeys($length = 32)
{
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return strtoupper($str);
}
/*
 * 优化微擎底层的is_base64的判断
 * 确保字符串被base64解密后可被json加密
 * string $str 被检测的字符串
 */
function check_base64_out_json($str){
    if(!is_string($str)){
        return false;
    }
    $str_base64_decode = base64_decode($str);
    $str_base64_decode_json_encode = json_encode($str_base64_decode);
    $error_code = json_last_error();
    if($error_code > 0 ){
        return false;
    }
    return $str == base64_encode(base64_decode($str));
}
/**
 * 生成签名, $KEY就是支付key
 * @param $params array 需要签名的数组
 * @param $KEY string 密匙
 * @return 签名
 */
function MakeSign($params, $KEY)
{
//  	return $params;
//      //签名步骤一：按字典序排序数组参数
    ksort($params);
    $string = ToUrlParams($params);  //参数进行拼接key=value&k=v
    //签名步骤二：在string后加入KEY
    $string = $string . "&key=" . $KEY;
    //签名步骤三：MD5加密
    $string = md5($string);
    //签名步骤四：所有字符转为大写
    $result = strtoupper($string);
    return $result;
}
/**
 * 将参数拼接为url: key=value&key=value
 * @param $params array 需要转换的数据
 * @return string 返回拼接成功的字符串
 */
function ToUrlParams($params)
{
    $buff = "";
    foreach ($params as $k => $v) {
        if ($k != "sign" && $v != "" && !is_array($v)) {
            $buff .= $k . "=" . $v . "&";
        }
    }

    $buff = trim($buff, "&");
    return $buff;
}
/**
 * 将xml转为array
 * @param string $xml
 * @throws WxPayException
 */
function FromXml($xml)
{
    //将XML转为array
    return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
}
function xml_parser($str){
    $xml_parser = xml_parser_create();
    if(!xml_parse($xml_parser,$str,true)){
		xml_parser_free($xml_parser);
		return false;
    }else {
		return (json_decode(json_encode(simplexml_load_string($str)),true));
    }
}
/**
 * array转xml
 * @param string 将array转为xml
 * @param string 签名
 * return xml 数据
 */
function array_xml($array, $sign)
{
    ksort($array);
    $xml = '<xml>';
    foreach ($array as $k => $v) {
        if (!is_array($v)) {
            $xml .= '<' . $k . '>' . $v . '</' . $k . '>';
        }
    }
    $xml .= '<sign>' . $sign . '</sign>';
    $xml .= '</xml>';
    return $xml;
}

/**
 * 获取xml里面数据，转换成array
 * @param $xml XML格式数据
 * retrun array 数据
 */
function xml2array($xml)
{
    $parser = xml_parser_create();
    // 将 XML 数据解析到数组中
    xml_parse_into_struct($parser, $xml, $vals, $index);
    // 释放解析器
    xml_parser_free($parser);
    // 数组处理
    $arr = array();
    $t = 0;
    foreach ($vals as $value) {
        $type = $value['type'];
        $tag = $value['tag'];
        $level = $value['level'];
        $attributes = isset($value['attributes']) ? $value['attributes'] : "";
        $val = isset($value['value']) ? $value['value'] : "";
        switch ($type) {
            case 'open':
                if ($attributes != "" || $val != "") {
                    $arr[$tag] = $attributes;
                    $t++;
                }
                break;
            case "complete":
                if ($attributes != "" || $val != "") {
                    $arr[$tag] = $val;
                    $t++;
                }
                break;
        }
    }
    return $arr;
}
/**
 * 调用接口， $data是数组参数
 * @return 签名
 */
function http_request($url, $data = null, $headers = array())
{
    $curl = curl_init();
    if (count($headers) >= 1) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
?>