<?php

/**
 * 微信订阅消息 
 */
//			'AT0229',//订单支付成功  通知		 订单编号,订单金额,订单状态,下单时间,备注 √ 
//			'AT0330',//申请团长通知   申请中	姓名,手机,微信号,结果,备注,申请时间,店铺名称
//			'AT0324',//提现		审核中	姓名,订单号,提现金额,提现时间,提现费率,提现状态,提现方式
//			'AT0787',//退款				订单号,退款时间,退款金额,商品详情,备注  √
//			'AT0423',//订单核销			核销时间,商品名称,订单金额,客户姓名,手机号,订单号,备注
//			'AT1122',//发货通知			订单编号,货物,数量,订单金额,备注,收货人,收件人电话
//			'AT0016',//充值成功通知			账号，充值金额，充值时间，交易单号
//			'AT2266',//会员卡开卡成功通知		账号，充值金额，充值时间，交易单号
//			'AT1179',//砍价进度通知			商品名称,砍价进度,剩余时间,砍价金额,温馨提示
//			'AT0051',//拼团成功通知
//			'AT0310',//拼团失败通知

class subscribe{
	public $access_token;
	public $weid;
	/**
	 * 发送消息
	 * @param $type string 发送订阅消息id 的标题 id
	 */
	public function send($openid='oLf4B0bm-0PiHMtR1ycmWARlcTTU',$data = [],$page='/pages/template/index'){
//		if(empty($type)){
//			return FALSE;
//		}
//		$key = "subscribe_".$type;
//		$data = $this->template($key);
		if(empty($data)){
			$data = ['1'=>'201948498465156165','2'=>'0.01元','3'=>'已支付','4'=>'2019-10-16 00:00:00','5'=>'您的订单已支付成功，请到小程序查看详情。'];
		}
		if(empty($openid)){
			return 'openid不存在';
		}
		
		$url = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=".$this->access_token;
		$array = "订单号码{{number5.DATA}}订单金额{{amount2.DATA}}订单状态{{phrase7.DATA}}支付时间{{time4.DATA}}温馨提示{{thing8.DATA}}";
		$template = "cRhDbhhgOCmpEGPSLrxHdkH-9qrBpQ-hXsJ96Lhlf9U";
		$array_data = $this->template_array($array,$data);//发送数据中的一部分
		if($array_data['status'] == 1){
			return $array_data['verification'];
		}
		$array_data = $array_data['data'];
		$data = array(
			'touser'=>$openid,
			'template_id'=>$template,
			'page'=>$page,
			'data'=>$array_data,
		);
//		echo '<pre>';
//		var_dump($data);exit;
		$code_msg = $this->post_curls($url,json_encode($data));
		$this->filename('../addons/group_buy/api/log/',$openid,json_encode($code_msg));
		return $code_msg;
	}
	private function filename($filename,$id,$str){
		if(!file_exists($filename)){
			mkdir($filename);
		}
		$filename .= $id.".txt";
		if(!file_exists($filename)){
			//文件存在
			$myfile = fopen($filename,'w');
		}else{
			$myfile = fopen($filename,'a');
		}
		fwrite($myfile,$str."\r\n");
		fclose($myfile);
		return true;
	}
	/**
	 * 解析数据
	 */
	public function template_array($arr,$datas){
		if(!$arr){
			return '';
		}
		$i = explode('{{',$arr);
		unset($i[0]);
		foreach($i as $kk=>$vv){
			$s =explode('.DATA', $vv);
			$data[$kk] = $s[0];
		}
		$array = $ver = [];
		foreach($data as $k=>$v){
//			这里要做验证  妈的   sb微信
			$vers = $this->verification($v,$datas[$k]);
			if(!empty($vers)){
				$ver[] = $vers;
			}
			$array[$v] = ['value'=>$datas[$k]];
		}
		if($ver){
			return ['status'=>1,'verification'=>$ver];
		}
		return ['status'=>0,'data'=>$array];
	}
	private function verification($string,$data){
		$str=preg_replace("/\\d+/",'', $string);//去除数字
		$arr = [];
		switch($str){
			case 'thing':
//				事物   		限制：20个以内字符      	说明：可汉字、数字、字母或符号组合
				$arrs = mb_strlen($data,'utf-8');
				if($arrs > 20){
					$arr = ['string'=>$string,'msg'=>'长度超过20个字符了'];
				}
			break;
			case 'number':
//				数字   		限制：32位以内数字      	说明：只能数字，可带小数
				if(!is_numeric($data)){
					$arr = ['string'=>$string,'msg'=>'不是数字'];
				}
				if(strlen($data) > 32){
					$arr = ['string'=>$string,'msg'=>'长度超过了32位'];
				}
			break;
			case 'letter':
//				字母   		限制：32位以内字母  		说明：只能字母
				if(!preg_match("^[A-Za-z]+$",$data)){
					$arr = ['string'=>$string,'msg'=>'不全是字母'];
				}
				if(mb_strlen($data) > 32){
					$arr = ['string'=>$string,'msg'=>'长度超过了32位'];
				}
			break;
			case 'symbol':
//				符号		限制：5位以内符号			说明：只能符号
//				if(preg_match("/[\]@/'\"$%&^*{}<>\\\\[:\;]+/")){
//					
//				}
			break;
			case 'character_string':
//				字符串	限制：32位以内数字、字母或符号	说明：可数字、字母或符号组合
				if(preg_match('/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{32}$/',$data)){
					$arr = ['string'=>$string,'msg'=>'字符串验证失败'];
				}
			break;
			case 'time':
//				时间		限制：24小时制时间格式（支持+年月日）		例如：15:01，或：2019年10月1日 15:01
				if(!is_numeric(strtotime($data))){
					$arr = ['string'=>$string,'msg'=>'时间验证失败'];
				}
			break;
			case 'date':
//				日期		限制：年月日格式（支持+24小时制时间）		例如：2019年10月1日，或：2019年10月1日 15:01
				if(!is_numeric(strtotime($data))){
					$arr = ['string'=>$string,'msg'=>'时间验证失败'];
				}
			break;
			case 'amount':
//				金额		限制：1个币种符号+10位以内纯数字，可带小数，结尾可带“元”		说明：可带小数
				
			break;
			case 'phone_number':
//				电话		限制：17位以内，数字、符号		说明：电话号码，例：+86-0766-66888866

			break;
			case 'car_number':
//				车牌		限制：8位以内，第一位与最后一位可为汉字，其余为字母或数字		说明：车牌号码：粤A8Z888挂

			break;
			case 'name':
//				姓名		限制：10个以内纯汉字或20个以内纯字母或符号		说明：中文名10个汉字内；纯英文名20个字母内；中文和字母混合按中文名算，10个字内
				$preg_name='/^[\x{4e00}-\x{9fa5}]{2,10}$|^[a-zA-Z\s]*[a-zA-Z\s]{2,20}$/isu';
				if(!preg_match($preg_name,$data)){
					$arr = ['string'=>$string,'msg'=>'名称验证失败'];
				}
			break;
			case 'phrase':
				//汉字	限制：5个以内汉字			说明：5个以内纯汉字，例如：配送中
				if (preg_match("/^[A-Za-z0-9]+$/", $data) != false) {
            		$arr = ['string'=>$string,'msg'=>'汉字验证失败'];
        		}
				if(mb_strlen($data) > 5){
					$arr = ['string'=>$string,'msg'=>'汉字必须小于5位'];
				}
			break;
		}
		return $arr;
	}
	/**
	 * 获取发送消息内容
	 */
	public function template($key){
		$arr = pdo_get("gpb_config",array('key'=>$key,'weid'=>$this->weid));
		if($arr){
			return ['code'=>0,'data'=>unserialize($arr['value'])];
		}else{
			$data = $this->send_data($key);
			if(empty($data)){
				return ['code'=>1,'msg'=>'模板不存在'];
			}
//			$access_token = substr($this->access_token,0,strlen($this->access_token)-2);
			$url = "https://api.weixin.qq.com/wxaapi/newtmpl/addtemplate?access_token=".$this->access_token;
			if($data['content']){
				$str = '';
				foreach($data['content'] as $k=>$v){
					$str .= $v.",";
				}
				$str = trim($str,',');
			}
			$tempnew = "{".'"tid":"'.$data['id'].'",'.'"kidList":['.$str.']'.',"sceneDesc":'.'"'.$data['name'].'"'."}";
//			echo $tempnew;
//			echo '<br/>';
//			echo $this->access_token;
//			echo '<br/>';
			$json = $this->http_request($url,$tempnew);
			var_dump($json);
			exit;
		}
	}
	/**
	 * 订阅消息模板
	 */
	public function send_data($type){
		$array = array(
			'429'=>[1,2,3],//好友帮砍成功通知
		);
		$data = [];
		switch($type){
			case 'subscribe_429':
				//订单支付成功  通知
				$data = array('id'=>'429','content'=>[1,2,3],'name'=>'好友助力成功通知');
				//依次为:订单编号,订单金额,订单状态,下单时间,备注
			break;
		}
		return $data;
	}
	
	/**
     * 调用接口， $data是数组参数
     * @return 签名
     */
    private function http_request($url,$data = null,$headers=array())
    {
    	$headers = array(
			"Content-type: application/x-www-form-urlencoded;charset=utf-8",
			"Accept: application/json",
			"Cache-Control: no-cache",
			"Pragma: no-cache"
		);
        $curl = curl_init();
        if( count($headers) >= 1 ){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
    
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
		$data = curl_error($curl);
		if($data){
			var_dump($data);exit;
		}
        curl_close($curl);
        return $output;
    }
	public function post_curls($url,$post) {
		$ch = curl_init($url);
		$headers = array(
			"Content-type: application/x-www-form-urlencoded;charset=utf-8",
			"Accept: application/json",
			"Cache-Control: no-cache",
			"Pragma: no-cache"
		);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($ch, CURLOPT_POST, 1);
		// post的变量
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$output = curl_exec($ch);
		$arr = curl_error($ch);
		
		curl_close($ch);
		$as = json_decode($output, true);
		return $as;
	}
	
	
}
 
 
?>