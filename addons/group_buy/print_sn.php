<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/15
 * Time: 17:32
 */
define("USER","327457624@qq.com");
define("UKEY","dVcmFPmpQLbQvkr9");
define("API","http://api.feieyun.cn/Api/Open/");
date_default_timezone_set("Asia/Shanghai");
class print_sn{
    //开始打印
    /**
     * int $print_sn 机器编号
     * string $order_sn 订单编号
     * string $store_name 店铺名称
     * array $goods 商品详情 title商品名称 price 商品单价 num 购买数量
     * string  $addr 送货地址
     * string $phone 联系电话
     * string $name 收货人姓名
     * string $leard_info 团长信息（电话、姓名）
     * string $pay_money 实付金额
     * string $coment 备注信息 （可选参数）
     * string $qrcode 二维码链接地址 （可选参数）
     * string $time 下单时间 (可选参数)
     * int $count 打印张数
     * string $reduce_price 优化价 (可选参数)
     * string $send_price 配送费 (可选参数)
	 * int 
     */
    public function print_info($print_sn='',$order_sn='',$store_name='',$goods = [],$addr='',$phone='',$name='',$pay_money=0.00,$leard_info=[],$coment='',$qrcode='',$add_time='',$time = '',$pay_type='在线支付',$count =1,$reduce_price='',$send_price='',$send_type='自提'){
        global $_W;
        if(empty($time) || $time<1){
            $time = time();
        }
        if(empty($print_sn)){
            return ['ret'=>'-1','msg'=>'请输入打印机编号'];
        }
        if(empty($order_sn)){
            return ['ret'=>'-1','msg'=>'请输入订单编号'];
        }
        if(empty($store_name)){
            return ['ret'=>'-1','msg'=>'请输入店铺名称'];
        }
        if(empty($goods)){
            return ['ret'=>'-1','msg'=>'请输入购买商品'];
        }
        if(empty($addr)){
            return ['ret'=>'-1','msg'=>'请输入送货地址'];
        }
        if(empty($phone)){
            return ['ret'=>'-1','msg'=>'请输入联系电话'];
        }
        $state = $this->select_print($print_sn);
        if($state['ret']!=0){
            return $state;
        }
        $content = "";
		$print_name = pdo_get("gpb_config",array('key'=>'print_set','weid'=>$_W['uniacid']),array('value'));
       /* $content .= '<C>'.$store_name.'</C><BR>';
        $content .= '<C>订单号：'.$order_sn.'</C><BR>';
        if(empty($goods[0]['spec'])){
            $content .= '名称　　　　　 单价  数量 金额<BR>';
        }else{
            $content .= '名称　　　 单价 数量 规格 金额<BR>';
        }
        $content .= '--------------------------------<BR>';
        $totle = 0;
        foreach ($goods as $k=>$v) {
            //空格位置建议就这么多
            if(empty($v['spec'])){
                $content .= $v['title']."<BR>               {$v['price']}  {$v['num']}  ￥".sprintf("%.2f",$v['num']*$v['price'])."<BR>";
            }else{
                $content .= $v['title']."<BR>　　　　　{$v['price']}  {$v['num']}  {$v['spec']}  ￥".sprintf("%.2f",$v['num']*$v['price'])."<BR>";
            }
            $totle += sprintf("%.2f",$v['num']*$v['price']);
        }
        if(!empty($coment)){
            $content .= '备注：'.$coment.'<BR>';
        }
	
        $content .= '--------------------------------<BR>';
        $content .= '合计：'.sprintf("%.2f",$totle).'元<BR>';
        $content .= '送货地点：'.$addr.'<BR>';
        $content .= '联系电话：'.$phone.'<BR>';
        $content .= '下单时间：'.date("Y-m-d H:i:s",$add_time).'<BR>';
        $content .= '出票时间：'.date("Y-m-d H:i:s",$time).'<BR>';*/
       	if($this->check_base64_out_json($leard_info['name'])){
       		$leard_info['name'] = base64_decode($leard_info['name']);
       	}
		if($print_name){
			$print_name = unserialize($print_name['value']);
			$print_name = $print_name['print_name'];
	        $content .= "<B><C>{$print_name}</C></B><BR>";
		}
		$member_order_card = pdo_get("gpb_order",array('go_code'=>$order_sn),array('go_member_card_reduce','go_comment','integral','delivery_time','go_send_type'));
		switch ($member_order_card['go_send_type']) {
        	case '1':
				$delivery_self = pdo_get("gpb_config",array('key'=>'delivery_self','weid'=>$_W['uniacid']),array('value'));
                $send_type = $delivery_self['value'] ? $delivery_self['value']:'自提';
                //周龙 2020-03-16 根据类型覆盖收货地址 自提地址为团长小区地址
                $go_vid = pdo_fetchcolumn("select go_vid from ".tablename("gpb_order")." where `go_code`='{$order_sn}'");
                if(empty($go_vid)){
                   //小区id为空获取团长openid 根据团长openid获取提货地址
                    $go_team_openid = pdo_fetchcolumn("select go_team_openid from ".tablename("gpb_order")." where `go_code`='{$order_sn}'");
                    $addr = pdo_fetchcolumn("select `vg_address` from ".tablename("gpb_village")." where openid='{$go_team_openid}'");
                }else{
                    //小区id存在 获取对应小区地址
                    $addr = pdo_fetchcolumn("select `vg_address` from ".tablename("gpb_village")." where vg_id='{$go_vid}'");
                }
                if($addr == base64_encode(base64_decode($addr))){
                    $addr = base64_decode($addr);
                }
                break;
            case '2':
				$delivery_chief = pdo_get("gpb_config",array('key'=>'delivery_chief','weid'=>$_W['uniacid']),array('value'));
                $send_type = $delivery_chief['value'] ? $delivery_chief['value']:'团长送货';

                $addr = pdo_fetchcolumn("select oss_address from ".tablename("gpb_order_snapshot")." where oss_go_code='{$order_sn}' group by oss_go_code");

                if($addr==base64_encode(base64_decode($addr))){
                    $addr = base64_decode($addr);
                }

                break;
            case '3':
				$delivery_express = pdo_get("gpb_config",array('key'=>'delivery_express','weid'=>$_W['uniacid']),array('value'));
                $send_type =  $delivery_express['value'] ? $delivery_express['value']:'快递';
                break;
        }
        $content .= "<B><C>--{$send_type}--</C></B><BR>";
        $content .= '订单时间:'.date("Y-m-d H:i:s",$add_time)."<BR>";
        $content .= '订单编号:'.$order_sn."<BR>";
        $content .= '收货小区:'.$store_name."<BR>";
        $content .= '团长姓名:'.$leard_info['name']."<BR>";
        $content .= '团长手机:'.$leard_info['phone']."<BR>";
        $content .= '--------------商品--------------'."<BR>";
        $totle = 0;
        $all_num = 0;
        $have_spec = 0;
        foreach ($goods as $k=>$v) {
            if(!empty($v['spec'])){
                $have_spec =1;
                break;
            }
        }
        if($have_spec!=1){
            $content .= '名称　　　　　 单价  数量 金额<BR>';
        }else{
            $content .= '名称　　　 单价 数量 规格 金额<BR>';
        }
        foreach ($goods as $k=>$v) {
            //空格位置建议就这么多
            if(empty($v['spec'])){
                $content .= $v['title']."<BR>               {$v['price']}  {$v['num']}  ￥".sprintf("%.2f",$v['num']*$v['price'])."<BR>";
            }else{
                $content .= $v['title']."<BR>　　　　　{$v['price']}  {$v['num']}  {$v['spec']}  ￥".sprintf("%.2f",$v['num']*$v['price'])."<BR>";
            }
            $totle += sprintf("%.2f",$v['num']*$v['price']);
            $all_num += $v['num'];
        }

        $content .= "<C>-------------总计---------------</C>";
        $content .= "商品总数:<RIGHT>{$all_num}</RIGHT>";
        $content .= "总金额:<RIGHT>{$totle}</RIGHT>";
        if(!empty($reduce_price) && $reduce_price>0) {
            $content .= "优惠:<RIGHT>-{$reduce_price}</RIGHT>";
        }
		if($member_order_card['integral'] > 0){
			$content .= "积分抵扣:<RIGHT>-".number_format($member_order_card['integral'], 2, '.', '')."元</RIGHT>";
		}
		if($member_order_card['go_member_card_reduce'] > 0){
			$content .= "会员卡优惠:<RIGHT>-".$member_order_card['go_member_card_reduce']."</RIGHT>";
		}
		if(!empty($send_price) && $send_price>0){
            $content .= "运费:<RIGHT>{$send_price}</RIGHT>";
        }
        if($this->check_base64_out_json($name)){
       		$name = base64_decode($name);
       	}
        $content .= "<C>**********</C>";
        $content .= "实付金额:<RIGHT>{$pay_money}</RIGHT>";
        $content .= "支付方式:<RIGHT>{$pay_type}</RIGHT>";
        $content .= "<C>--------------------------------</C>";
        $content .= '<CB>'.$name.'</CB>'."<BR>";
        $content .= '<CB>'.$phone.'</CB>'."<BR>";
        $content .= '<L><BOLD>收货地址:'.$addr."</BOLD></L><BR>";
		//配送时间
		if($member_order_card['delivery_time']){
			$content .= '<L><BOLD>配送时间:'.$member_order_card['delivery_time']."</BOLD></L><BR>";
		}
//      $content .= '<L><BOLD>配送方式:'.$send_type."</BOLD></L><BR>";
        if(!empty($member_order_card['go_comment'])){
            $content .= '<L><BOLD>备注：'.$member_order_card['go_comment'].'</BOLD></L><BR>';
            $content .= "<C>--------------------------------</C>";
        }

        if(!empty($qrcode)){
            $content .= '<QR>'.$qrcode.'</QR>';
            $content .= "<C>--------------------------------</C>\n";
        }

        $content .= "<CB>******完******</CB>";

        $data = [
            'user'=>USER,
            'stime'=>$time,
            'apiname'=>'Open_printMsg',
            'sig'=>$this->get_sig($time),
            'sn'=>"{$print_sn}",
            'content'=>$content,
            'times'=>$count,
            'debug'=>0,
        ];
        $res = $this->curl(API,$data);
        @usleep(500000);
        $log = [
            'data'=>serialize($data),
            'from'=>$this->getfrom(),
            'result'=>serialize($res),
            'send_state'=>$res['ret'],
            'send_time'=>time(),
            'status'=>1,
            'create_time'=>time(),
            'update_time'=>time(),
            'weid'=>$_W['uniacid'],
        ];
        @pdo_insert("gpb_print_log",$log);
        @usleep(50000);
        return $res;
    }
    //添加打印机
    /**
     * string $print_sn 机器编号
     * string $print_key 机器key
     * string $store_name 店铺名称
     */
    public function add_new($print_sn='',$print_key='',$store_name=''){
        $time = time();
        $print_content = "{$print_sn} # {$print_key} # {$store_name} ";
        $data = [
            'user'=>USER,
            'stime'=>$time,
            'sig'=>$this->get_sig($time),
            'apiname'=>"Open_printerAddlist",
            'printerContent'=>$print_content,
        ];
        $res = $this->curl(API,$data);
        return $res;
    }
    //查询打印机状态
    public function select_print($print_sn=''){
        $time = time();
        $data = [
            'user'=>USER,
            'stime'=>$time,
            'sig'=>$this->get_sig($time),
            'apiname'=>"Open_queryPrinterStatus",
            'sn'=>$print_sn,
        ];
        $res = $this->curl(API,$data);
        return $res;
    }
    //修改打印机
    public function edit_print($print_sn='',$store_name=''){
        $time = time();
        $data = [
            'user'=>USER,
            'stime'=>$time,
            'sig'=>$this->get_sig($time),
            'apiname'=>"Open_printerEdit",
            'sn'=>$print_sn,
            'name'=>$store_name
        ];
        $res = $this->curl(API,$data);
        return $res;
    }
    //删除打印机
    public function del_print($print_sn=''){
        $time = time();
        $data = [
            'user'=>USER,
            'stime'=>$time,
            'sig'=>$this->get_sig($time),
            'apiname'=>"Open_printerDelList",
            'snlist'=>$print_sn,
        ];
        $res = $this->curl(API,$data);
        return $res;
    }
//curl方法
    function curl($url,$post_data=array(),$type="json"){
        $curl = curl_init($url);
//		exit(print_r($post_data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);//SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);//严格认证
//		curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        if(!empty($post_data)){
//			exit(print_r($post_data));
            curl_setopt($curl,CURLOPT_POST,true); // post传输数据
            if($type=='xml'){
                curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type:text/xml; charset=utf-8"));
            }
            curl_setopt($curl,CURLOPT_POSTFIELDS,$post_data);// post传输数据
        }
        $responseText = curl_exec($curl);
//	    var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
//		echo $responseText;
        curl_close($curl);
        if($type=="json"){
            $result = json_decode($responseText,true);
        }elseif($type=='xml'){
            $result = xmlToArray($responseText);
        }elseif ($type=='text'){
            $result = $responseText;
        }
        return $result;
    }
    //生成秘钥
    function get_sig($time = time){
        return sha1(USER.UKEY.$time);
    }
    
     /*
     * 优化微擎底层的is_base64的判断
     * 确保字符串被base64解密后可被json加密
     * string $str 被检测的字符串
     */
    protected function check_base64_out_json($str){
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
     * 获取当前访问路径地址
     */
    private function getfrom(){
        $url = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on'?'https://':'http://';
        $url .= $_SERVER['HTTP_HOST']."/";
        if(!empty($_SERVER['REQUEST_URI'])){
            $url .= $_SERVER['REQUEST_URI'];
        }else{
            $url .= $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
        }
        return $url;
    }

}


