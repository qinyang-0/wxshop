<?php

header("Content-type:text/html;charset=utf-8");
defined('IN_IA') or exit('Access Denied');
define("gpb", "Group_buy");
include_once '../addons/group_buy/sms.php';
include_once '../addons/group_buy/SubMsg.php';
include_once '../addons/group_buy/SubWechat.php';
include_once '../addons/group_buy/print_sn.php';
class Group_buyModuleSite extends WeModuleSite {
    //关联数据库
    public $member           = 'gpb_member';//用户表
    public $ah          = 'gpb_application_header';//申请团长表
    public $rg          = 'gpb_region';//地区表
    public $vg          = 'gpb_village';//小区表
    public $goods          = 'gpb_goods';//商品表
    public $goods_cate          = 'gpb_goods_cate';//商品分类表
    public $goods_stock          = 'gpb_goods_stock';//商品库存
    public $goods_stock_logs          = 'gpb_goods_stock_logs';//商品库存日志
    public $adv         = 'gpb_banner';//banner
    public $coupon         = 'gpb_ticket';//优惠卷
    public $user_coupon         = 'gpb_user_ticket';//用户领取的优惠券
    public $order         = 'gpb_order';//用户订单表
    public $order_log         = 'gpb_order_log';//用户订单日志表
    public $action         = 'gpb_action';//活动表
    public $address         = 'gpb_receiving_address';//收获地址表
    public $snapshot        = 'gpb_order_snapshot';//订单商品快照表
    public $ban             = 'gpb_banner';//banner广告
    public $sure_order             = 'gpb_sure_order';//订单核销表
    public $action_village     ='gpb_action_village';//活动小区关系表
    public $action_goods     ='gpb_action_goods';//活动商品关系表
    public $cart       ='gpb_cart';//购物车表
    public $config       ='gpb_config';//配置表
    public $get_cash       ='gpb_get_cash';//提现表
    public $back_money       ='gpb_back_money';//退款表
    public $distribution       ='gpb_distribution_list';//配送表
    public $distribution_route       ='gpb_distribution_route';//配送路线表
    public $supplier       ='gpb_supplier';//供应商
    public $spec       ='gpb_goods_spec';//规格表
    public $spec_item       ='gpb_goods_spec_item';//规格下参数表
    public $goods_option       ='gpb_goods_option';//参数规格erp
    public $diy_page       ='gpb_diy_page';//diy页面信息
    public $diy_temp       ='gpb_diy_temp';//diy模版信息
    public $menu          = 'gpb_menu';//菜单权限
    public $menu_list     = 'gpb_menu_list';//菜单
    public $plug     = 'gpb_plug';//插件表
    public $stream     = 'gpb_order_stream';//流水
    public $article    = 'gpb_article';//文章表
    public $article_class     = 'gpb_article_class';//文章分类
    
    public $weid;
    public $menu_info;
    public $supplier_role;

    //开始时间,固定一个小于当前时间的毫秒数即可
    const twepoch =  1474990000000;//2016/9/28 0:0:0
    //机器标识占的位数
    const workerIdBits = 2;
    //数据中心标识占的位数
    const datacenterIdBits = 2;
    //毫秒内自增数点的位数
    const sequenceBits = 3;
    protected $workId = 0;
    protected $datacenterId = 0;
    static $lastTimestamp = -1;
    static $sequence = 0;
    public $title_list='后台';

    public function __construct(){
        //构造函数
        global $_W,$_GPC;
        $this->weid = $_W['uniacid'];
//		var_dump($_W['uniacid']);exit();
        $this->autoSureGoods();
        //获取是否是对象储存
        $this->https = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        //检查是否有菜单数据
        $this->menu_info=$this->menu_list($_W);
        //检查是否有diy系统数据
        if($_GPC['do'] == 'diy'){
            $this->checkDiyData();
        }
        $title_info = pdo_get($this->menu_list,array('do'=>$_GPC['do'],'pid'=>0));
        if(!empty($title_info)){
            $this->title_list = $title_info['name'].'-'.$_W['current_module']['title'];
        }else{
            $this->title_list  .='-'.$_W['current_module']['title'] ;
        }
        //判断是否是供应商
        $this->supplier_role = 0;
        if($_GPC['do'] == 'supplier'){
            $this->checkIsHaveSupplierLogin();
        }
        //删迪哥瞎上传的文件
        $this->DelCacheFile();
        //判断是否有系统自带的用户中心数据，没有就新增
        $this->checkHaveMemberCenterDiy();
		$this->distrtion_money();//分销佣金重新计算
    }
    //生成一个ID
    public function nextId(){
        $timestamp = $this->timeGen();
        $lastTimestamp = self::$lastTimestamp;
        //判断时钟是否正常
        if ($timestamp < $lastTimestamp) {
            throw new \Exception("Clock moved backwards.  Refusing to generate id for %d 
milliseconds", ($lastTimestamp - $timestamp));
        }
        //生成唯一序列
        if ($lastTimestamp == $timestamp) {
            $sequenceMask = -1 ^ (-1 << self::sequenceBits);
            self::$sequence = (self::$sequence + 1) & $sequenceMask;
            if (self::$sequence == 0) {
                $timestamp = $this->tilNextMillis($lastTimestamp);
            }
        } else {
            self::$sequence = 0;
        }

        self::$lastTimestamp = $timestamp;

        //时间毫秒/数据中心ID/机器ID,要左移的位数
        $timestampLeftShift = self::sequenceBits + self::workerIdBits +
            self::datacenterIdBits;
        $datacenterIdShift = self::sequenceBits + self::workerIdBits;
        $workerIdShift = self::sequenceBits;
        //组合4段数据返回: 时间戳.数据标识.工作机器.序列
        $nextId = (($timestamp - self::twepoch) << $timestampLeftShift) |
            ($this->datacenterId << $datacenterIdShift) |
            ($this->workId << $workerIdShift) | self::$sequence;

        $id = str_pad(abs($nextId),10,0,STR_PAD_LEFT);
        return date('mdhi'). substr($id,3);
        //return time() . $id;
        //return $id;
    }
    //取当前时间毫秒
    protected function timeGen(){
        $timestramp = (float)sprintf("%.0f", microtime(true) * 1000);
        return  $timestramp;
    }
	/**
     * 获取access_token
     */
    public function Token()
    {
        global $_GPC, $_W;
        if (time() > $_W['account']['access_time'] || empty($_W['account']['access_time'])) {
            //获取access_token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $_W['account']['key'] . "&secret=" . $_W['account']['secret'];
            $list = $this->http_request($url);
            $list = json_decode($list, true);
//			echo '<pre>';
//			print_r($list);exit;
            $_W['account']['access_tokne'] = $list['access_token'];
            $_W['account']['access_time'] = time() + 7150;
            return true;
        } else {
            return true;
        }
    }
    //取下一毫秒
    protected function tilNextMillis($lastTimestamp) {
        $timestamp = $this->timeGen();
        while ($timestamp <= $lastTimestamp) {
            $timestamp = $this->timeGen();
        }
        return $timestamp;
    }

    public function doWebindex(){
        global $_W,$_GPC;
		require_once '../addons/group_buy/upgrade.php';
    }

    //可当后台公共类使用

    /*
     * 查询中国省市区信息
     * @param int $id 地区编码
     * return array
     */
    public function getArea($id=0){
        $rs = array();
        $rs = pdo_fetchall('select ad_code,name from '.tablename('gpb_area').' where pid = '.$id);
        return $rs;
    }
    /*
     * 缓存数据方法
     * @param char $name 缓存名称
     * @param char $sql 缓存sql语句
     * @param char $sql 操作缓存的动作（读get，存set，更新update,检查check）
     * return
     */
    public function  cachFun($name,$act="check",$sql=""){
//        if ( empty($name) ) {
//            message("未知缓存名");exit();
//        }
//        switch ( $act ){
//            case "get":
//                if(empty(cache_load($name))){
//                    return false;
//                }else{
//                    return cache_load($name);
//                }
//                break;
//                case ""
//        }
    }
    /*
     * 递归数组并排序
     * @param array $arr 原数据数组
     * @param char $id_name 数据中主键字段名
     * @param char $id_name 数据中父级主键字段名
     * @param char $pid 数据中父级主键
     * return array
     */
    public function getTree($arr,$id_name,$pid_name,$pid=0){
        static $tree_array = array();
        foreach($arr as $k => $v)
        {
            if($v[$pid_name] == $pid) {
                $tree_array[] = $v;
                $this->getTree($arr,$id_name,$pid_name,$v[$id_name]);
            }
        }
        return $tree_array;
    }

    /*
     * 获取订单状态方法
     */
    public  function orderStatus($code){
        if( empty($code) ){
            return '';
        }
        $status = [
            '10'=> "待付款",
            '20'=> "备货中",
            '30'=> "待取货",
            '40'=> "售后",//流程改变 弃用 下沉到快照表
            '50'=> "退款中",//流程改变 弃用 下沉到快照表
            '60'=> "拒绝退款",//流程改变 弃用 下沉到快照表
            '70'=> "已退款",//流程改变 弃用 下沉到快照表
            '100'=> "交易完成",
            '110'=> "取消订单",
            '115'=> "删除订单",
            '120'=> "交易关闭",
        ];
        return $status[$code];
    }

    /**
     * 测试
     */
    public function doMobileList(){
        echo 312312312;exit;

    }
    /**
     * 退款
     * @param $appid string  appid
     * @param $mcid strig 商户号
     * @param $key string 支付密匙
     * @param $out_trade_no string 商户订单号(下单的号码)
     * @param $out_refund_no string 退款订单号
     * @param $total_fee int 订单金额 （分）
     * @param $refund_fee int 退款金额（分）
     * @param $cret int cert证书地址
     * @param $key int key 证书地址
     * return array 是否退款成功 或者失败
     */
//	 $data = ['pem'=>'../addons/group_buy/cert/1482977942_20181012_cert.pem','key'=>'../addons/group_buy/cert/1482977942_20181012_key.pem'];
    public function refund_info($appid,$mcid,$key,$out_trade_no,$out_refund_no,$total_fee,$refund_fee,$cret,$keys){
        if(empty($appid)){
            return array('status'=>0,'msg'=>'请传入appid');
        }
        if(empty($mcid)){
            return array('status'=>0,'msg'=>'请传入商户号');
        }
        if(empty($key)){
            return array('status'=>0,'msg'=>'请传入商户密匙');
        }
        if(empty($out_trade_no)){
            return array('status'=>0,'msg'=>'请传入退款订单下单时的订单号');
        }
        if(empty($out_refund_no)){
            return array('status'=>0,'msg'=>'请传入退款单号');
        }
        if(empty($total_fee)){
            return array('status'=>0,'msg'=>'请传入退款订单下单时的订单金额');
        }
        if(empty($cret)){
            return array('status'=>0,'msg'=>'请传入pem证书地址');
        }
        if(empty($keys)){
            return array('status'=>0,'msg'=>'请传入key证书地址');
        }
        if(!file_exists($cret)){
            return array('status'=>0,'msg'=>'pem证书地址错误');
        }
        if(!file_exists($keys)){
            return array('status'=>0,'msg'=>'key证书地址错误');
        }
        $appid    =       $appid;//如果是公众号 就是公众号的appid;小程序就是小程序的appid
        $mcid     =       $mcid;//商户号
        $KEY      =       $key;//支付密匙
        $nonce_str =    $this->randomkeys(32);//随机字符串
        $notify_url =  '';  //支付完成回调地址url,不能带参数
        //这里是按照顺序的 因为下面的签名是按照(字典序)顺序 排序错误 肯定出错
        $post['appid'] = $appid;
        $post['mch_id'] = $mcid;
        $post['nonce_str'] = $nonce_str;//随机字符串
//        $post['notify_url'] = $notify_url;
        $post['out_trade_no'] = $out_trade_no;
        $post['out_refund_no'] = $out_refund_no;
        $post['total_fee'] = $total_fee*100;
        $post['refund_fee'] = $refund_fee*100;//服务器终端的ip

        $sign = $this->MakeSign($post,$KEY);              //签名
//        var_dump($post);
//        echo $sign;
//        return $sign;
        $post_xml = $this->array_xml($post,$sign);        //字典序将数组转xml格式
        //统一退款接口
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $xml = $this->curpost($url,$post_xml,$cret,$keys);     //POST方式请求http
        $array = $this->xml2array($xml);               //将【统一下单】api返回xml数据转换成数组，全要大写
        return array('status'=>1,'msg'=>'','data'=>$array);
    }
    /**
     * 提现(由于是小程序，将采用企业付款到用户零钱的形式)
     * @param $order 订单号
     * @param $openid 收钱用户openid
     * @param $money 金额
     * @param $mchid  商户号
     * @param $appid appid
     * @param $key 支付密匙
     * @param $pem_cert cert文件路径
     * @param $pem_key key文件路径
     * return array
     */
    public function cash($order,$openid,$money,$mchid,$appid,$key,$pem_cert,$pem_key){
        if(empty($order)){
            return array('status'=>0,'msg'=>'订单号错误');
        }
        if(empty($openid)){
            return array('status'=>0,'msg'=>'请传入提现用户');
        }
        if(empty($money)){
            return array('status'=>0,'msg'=>'请传入提现金额');
        }
        if(empty($mchid)){
            return array('status'=>0,'msg'=>'清传入商户号');
        }
        if(empty($appid)){
            return array('status'=>0,'msg'=>'请传入appid');
        }
        if(empty($key)){
            return array('status'=>0,'msg'=>'请传入微信支付密匙');
        }
        if(empty($pem_cert)){
            return array('status'=>0,'msg'=>'请传入pem证书路径');
        }
        if(empty($pem_key)){
            return array('status'=>0,'msg'=>'请传入key证书路径');
        }
        if(!file_exists($pem_cert)){
            return array('status'=>0,'msg'=>'pem证书路径错误');
        }
        if(!file_exists($pem_key)){
            return array('status'=>0,'msg'=>'key证书路径错误');
        }
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';//请求地址
        $data = [
            'mch_appid'=>$appid,//公众号appid
            'mchid'=>$mchid,//商户号
            'nonce_str'=>$this->randomkeys(),//随机字符串
            'partner_trade_no'=>$order,//订单号
            'openid'=>$openid,
            'check_name'=>'NO_CHECK',//是否验证姓名
            'amount'=>$money*100,  //提现金额单位（分）
            'desc'=>'提现',//说明
            'spbill_create_ip'=>$_SERVER['SERVER_ADDR'],//ip地址
        ];

        $sign = $this->MakeSign($data, $key); //算签名
        $data_xml =  $this->array_xml($data,$sign);
        $responseXml = $this->curpost($url, $this->array_xml($data,$sign),$pem_cert,$pem_key);//post提交数据
        $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);//xml转换
        //打印数据  判断是否成提现
        return array('status'=>1,'msg'=>'','data'=>$this->object_to_array($unifiedOrder));
    }

    /**
     * 随机字符串
     * return string 32位随机字符串
     */
    private function randomkeys($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return strtoupper($str);
    }
    /**
     * 生成签名, $KEY就是支付key
     * @param $params array 需要签名的数组
     * @param $KEY string 密匙
     * @return 签名
     */
    public function MakeSign($params,$KEY){
//  	return $params;
//      //签名步骤一：按字典序排序数组参数
        ksort($params);
        $string = $this->ToUrlParams($params);  //参数进行拼接key=value&k=v

        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$KEY;
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
    public function ToUrlParams( $params ){
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
     * array转xml
     * @param string 将array转为xml
     * @param string 签名
     * return xml 数据
     */
    public function array_xml($array,$sign){
        ksort($array);
        $xml = '<xml>';
        foreach($array as $k=>$v){
            if(!is_array($v)){
                $xml .= '<'.$k.'>'.$v.'</'.$k.'>';
            }
        }
        $xml .= '<sign>'.$sign.'</sign>';
        $xml .='</xml>';
        return $xml;
    }
    /**
     * cur请求
     * $url 请求地址
     * $post post数据
     * $cert cert证书地址
     * $key key 证书地址
     * return array
     */
    public function curpost($url='',$postData='',$cert,$key){
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $get = getcwd();
        $get = substr($get,0,strlen($get)-3);
//		$get = "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //第一种方法，cert 与 key 分别属于两个.pem文件
//		$a = getcwd().'/extend/wxpay/cert/apiclient_cert.pem';
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,$cert);
//      curl_setopt($ch,CURLOPT_SSLCERT,'../addons/wl_appointment/cert/1482977942_20181012_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,$key);
//      curl_setopt($ch,CURLOPT_SSLKEY,'../addons/wl_appointment/cert/1482977942_20181012_key.pem');
        //第二种方式，两个文件合成一个.pem文件
//        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
        $data = curl_exec($ch);
        if($data === false)
        {
            echo 'Curl error: ' . curl_error($ch);exit();
        }
        curl_close($ch);
        return $data;
    }
    /**
     * 获取xml里面数据，转换成array
     * @param $xml XML格式数据
     * retrun array 数据
     */
    private function xml2array($xml){
        $parser = xml_parser_create();
        // 将 XML 数据解析到数组中
        xml_parse_into_struct($parser, $xml, $vals, $index);
        // 释放解析器
        xml_parser_free($parser);
        // 数组处理
        $arr = array();
        $t=0;
        foreach($vals as $value) {
            $type = $value['type'];
            $tag = $value['tag'];
            $level = $value['level'];
            $attributes = isset($value['attributes'])?$value['attributes']:"";
            $val = isset($value['value'])?$value['value']:"";
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
     * 对象转数组
     */
    public function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->object_to_array($v);
            }
        }
        return $obj;
    }
    /**
     * 获取access_token
     */
    public function Tokens(){
        global $_GPC,$_W;
        if(time() > $_W['account']['access_time'] || empty($_W['account']['access_time'])){
            //获取access_token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$_W['account']['key']."&secret=".$_W['account']['secret'];
            $list = $this->http_request($url);
            $list = json_decode($list, true);
//			echo '<pre>';
//			print_r($list);exit;
            $_W['account']['access_tokne'] = $list['access_token'];
            $_W['account']['access_time'] = time()+7150;
            return true;
        }else{
            return true;
        }
    }
    /**
     * 调用接口， $data是数组参数
     * @return 签名
     */
    protected function http_request($url,$data = null,$headers=array())
    {
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
        curl_close($curl);
        return $output;
    }
    /*
     * 请求查询订单支付状态
     * @param string $gid
     * @return array
     */
    public function wx_order_status($gid){
        global $_W,$_GPC;
        $data['appid'] = $_W['account']['key'];//appid
        $data['mch_id'] = $_W['account']['setting']['payment']['wechat']['mchid'];//商户号
        $data['nonce_str'] = $this->randomkeys(32);//随机字符串
        $urls = 'https://api.mch.weixin.qq.com/pay/orderquery';
        //foreach($info as $k=>$v){
        $data['out_trade_no'] = $gid; //拿到订单号
        ihttp_request($_W['siteroot']."/app/index.php?i={$_W['uniacid']}&from=wxapp&m=group_buy&a=wxapp&c=entry&do=Team_orderchange&go_code={$gid}");
//        $data['transaction_id'] = '4200000262201903187060586658';
//        var_dump($data);
        $sign = $this->MakeSign($data,$_W['account']['setting']['payment']['wechat']['signkey']);//算签名
//        $sign = $this->MakeSign($data,'aa112253112253112253112253112253');//算签名
        $post_xml = $this->array_xml($data, $sign);//数组转xml
        $list = $this->http_request($urls,$post_xml);//请求
        $list = $this->xml_to_array($list);//将返回的数据转成数组
        return $list;
    }
    /**
     * 将xml转为array
     * @param string $xml
     * return array
     */
    public function xml_to_array($xml){
        if(!$xml){
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }
    /**
     * 取汉字的第一个字的首字母
     * @param string $str
     * @return string|null
     */
    private function getFirstChar($str) {
        if (empty($str)) {
            return '';
        }

        $fir = $fchar = ord($str[0]);
        if ($fchar >= ord('A') && $fchar <= ord('z')) {
            return strtoupper($str[0]);
        }

        $s1 = @iconv('UTF-8', 'gb2312', $str);
        $s2 = @iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        if (!isset($s[0]) || !isset($s[1])) {
            return '';
        }

        $asc = ord($s[0]) * 256 + ord($s[1]) - 65536;

        if (is_numeric($str)) {
            return $str;
        }

        if (($asc >= -20319 && $asc <= -20284) || $fir == 'A') {
            return 'A';
        }
        if (($asc >= -20283 && $asc <= -19776) || $fir == 'B') {
            return 'B';
        }
        if (($asc >= -19775 && $asc <= -19219) || $fir == 'C') {
            return 'C';
        }
        if (($asc >= -19218 && $asc <= -18711) || $fir == 'D') {
            return 'D';
        }
        if (($asc >= -18710 && $asc <= -18527) || $fir == 'E') {
            return 'E';
        }
        if (($asc >= -18526 && $asc <= -18240) || $fir == 'F') {
            return 'F';
        }
        if (($asc >= -18239 && $asc <= -17923) || $fir == 'G') {
            return 'G';
        }
        if (($asc >= -17922 && $asc <= -17418) || $fir == 'H') {
            return 'H';
        }
        if (($asc >= -17417 && $asc <= -16475) || $fir == 'J') {
            return 'J';
        }
        if (($asc >= -16474 && $asc <= -16213) || $fir == 'K') {
            return 'K';
        }
        if (($asc >= -16212 && $asc <= -15641) || $fir == 'L') {
            return 'L';
        }
        if (($asc >= -15640 && $asc <= -15166) || $fir == 'M') {
            return 'M';
        }
        if (($asc >= -15165 && $asc <= -14923) || $fir == 'N') {
            return 'N';
        }
        if (($asc >= -14922 && $asc <= -14915) || $fir == 'O') {
            return 'O';
        }
        if (($asc >= -14914 && $asc <= -14631) || $fir == 'P') {
            return 'P';
        }
        if (($asc >= -14630 && $asc <= -14150) || $fir == 'Q') {
            return 'Q';
        }
        if (($asc >= -14149 && $asc <= -14091) || $fir == 'R') {
            return 'R';
        }
        if (($asc >= -14090 && $asc <= -13319) || $fir == 'S') {
            return 'S';
        }
        if (($asc >= -13318 && $asc <= -12839) || $fir == 'T') {
            return 'T';
        }
        if (($asc >= -12838 && $asc <= -12557) || $fir == 'W') {
            return 'W';
        }
        if (($asc >= -12556 && $asc <= -11848) || $fir == 'X') {
            return 'X';
        }
        if (($asc >= -11847 && $asc <= -11056) || $fir == 'Y') {
            return 'Y';
        }
        if (($asc >= -11055 && $asc <= -10247) || $fir == 'Z') {
            return 'Z';
        }

        return '';
    }
    /**
     * 获取微信订单号查询订单状态
     */
//    public function autoColseOrder(){
    //首先查询未付款的订单
//        $no_pay = pdo_getall($this->order,array('go_status'=>10,'go_is_del'=>1,'weid'=>$this->weid));
//        foreach ($no_pay as $v){
//            file_put_contents("../addons/group_buy/log2.log",$v['go_id'].'---',FILE_APPEND);//记录日志
//            $openid = $v['openid']  ;
//            $gid = $v['go_code'];
//            if(!empty($openid) && !empty($gid) ){
//                $list = $this->wx_order_status($gid);
//                if($list['trade_state']=='SUCCESS' && $list['return_code']=='SUCCESS'){
//                    //支付成功  改变订单状态,并且发送模板消息 todo....
//                    $rownum = pdo_update($this->order,['go_status'=>20,'go_pay_time'=>time(),'weid'=>$this->weid],array('go_code'=>$gid));
//                    if(!empty($rownum)){
//                        //获取商品信息
//                        $info = pdo_getall($this->snapshot,array('oss_go_code'=>$gid));
//                        if(!empty($info)){
//                            foreach($info as $k=>$v){
//                                $stcok = pdo_get($this->goods_stock,array('goods_id'=>$v['oss_gid']));//获取库存
//                                $num = $stcok['num'] - $v['oss_g_num'];
//                                $is = $stcok['sale_num'] + $v['oss_g_num'];
//                                //修改库存和添加销量
//                                pdo_update($this->goods_stock,array('num'=>$num,'sale_num'=>$is,'weid'=>$weid),array('goods_id'=>$v['oss_gid']));
//                                //修改完销量  去查看商品的销量是为0  为0 下架
//                                if($is === 0){
//                                    $res = pdo_update($this->goods,array('g_is_online'=>-1,'weid'=>$weid),array('g_id'=>$v['oss_gid']));
//                                }
//                                //修改虚拟销售数量
//                                $sql = "update ".tablename($this->goods)." set `g_sale_num` = `g_sale_num`+1 WHERE weid=".$weid." and `g_id` = ".$v['oss_gid'];
//                                pdo_query($sql);
//
//                                //to do
//                            }
//                        }
//                        $info = pdo_get($this->order,array('go_code'=>$gid));
//                        //发送模板消息
//                        $sms = new Sms();
//                        $sms->weid=$weid;
//                        $this->Tokens();
//                        //                        send_out($key,$data,$access_token,$openid,$page,$form_id,$weid,$item);
//                        $dass = $sms->send_out('sms_template',array('1'=>$info['go_code'],'2'=>"￥".$info['go_real_price'],'3'=>'支付成功','4'=>date('Y-m-d H:i',$info['go_add_time']),'5'=>'如有疑问，请拨打客户热线:'),$_W['account']['access_tokne'],$openid,'pages/order-details/order-details?id='.$info['go_id'],$info['prepay_id'],$sms->weid,'AT0229');
//                        pdo_insert('gpb_config',array('value'=>serialize($dass),'name'=>$info['prepay_id']));
//                        //模板消息结束
//
//                        //短信通知管理员
//                        $account = pdo_get($this->member,array('m_openid'=>$openid,'weid'=>$weid));
//                        $type = pdo_get($this->config,array('weid'=>$weid,'key'=>'sms_type'));
//                        $set = pdo_get($this->config,array('weid'=>$weid,'key'=>'sms_pay'));
//                        $phone = pdo_get($this->config,array('weid'=>$weid,'key'=>'sms_admin'));
//                        $data = pdo_get($this->config,array('weid'=>$weid,'key'=>'sms_data'));
//                        $phone = unserialize($phone['value']);
//                        $data = unserialize($data['value']);
//                        $set = unserialize($set['value']);
//                        $sms = new Sms();
//                        $weid = $sms->weid = $weid;
//                        if($type['value'] == 1 ){
//                            //阿里云
//                            foreach ( $phone as $k => $v){
//                                $res =$sms->alicloud($v,array('sms_var'=>trim($set['content']['value']),'sms_key'=>trim($data['key']['value']),'sms_serect'=>trim($data['serect']['value']),'sms_sign'=>trim($data['sign']['value']),'sms_id'=>trim($set['id']['value'])),array('0'=>$account['m_nickname'],'1'=>$gid));
//                            }
//                        }elseif($type['value']==2){
//                            //创瑞 todo 不一定成
//                            foreach ( $phone as $k => $v){
//                                $res =  $sms->chui($v,array('sms_var'=>trim($set['content']['value']),'sms_key'=>trim($data['key']['value']),'sms_serect'=>trim($data['serect']['value']),'sms_sign'=>trim($data['sign']['value']),'sms_id'=>trim($set['id']['value'])),$gid);
//                            }
//
//                        }
//
//                    }
//                }
//                elseif($list['trade_state']=='NOTPAY' && $list['return_code']=='SUCCESS'){
//                    //未支付成功的  去判断下单时间  超过好久取消订单
//                    $over_time = 30*60;
//                    if($v['go_add_time']+$over_time<time()){
//                        pdo_update($this->order,['go_status'=>120,'weid'=>$weid],array('go_code'=>$gid));
//                    }
//                }elseif($list['err_code']=='ORDERNOTEXIST' && $list['result_code']=='FAIL'){
//                    //订单不存在
//                    $over_time = 30*60;
//                    if($v['go_add_time']+$over_time<time()){
//                        pdo_update($this->order,['go_status'=>120,'weid'=>$weid],array('go_code'=>$gid));
//                    }
//                }
//            }
//        }
//        $over_time = pdo_get($this->config,array('status'=>1,'type'=>7,'weid'=>$this->weid,'key'=>'order_set'));
//        $value =  unserialize($over_time['value']);
//        $over_time = !isset($value['order_auto_close_time']) || empty($value['order_auto_close_time'])?30:$value['order_auto_close_time'];
//        $goods_time = !isset($value['order_auto_get_goods_time']) || empty($value['order_auto_get_goods_time'])?7:$value['order_auto_get_goods_time'];
//        //超过规定时间的交易关闭
//        pdo_update($this->order,array("go_status"=>120),array('go_status'=>'10','go_add_time >'=>time()-$over_time*60,'weid'=>$this->weid,'go_is_del'=>1));
//        //超过规定时间自动收货的交易完成
//        $order_sure_goods = pdo_getall($this->order,array('go_status'=>'30','go_add_time >'=>time()-$goods_time*24*60*60,'weid'=>$this->weid,'go_is_del'=>1));
//        if(!empty($order_sure_goods)){
//            foreach ($order_sure_goods as $k =>$v){
//                $team = pdo_get($this->member,array('weid'=>$this->weid,'m_openid'=>$v['go_team_openid']));
//                $parsent = $team['m_commission']/100;//佣金比例
//                $go_commission = $parsent*$info['go_real_price'];
//                $go_commission_num = $parsent*100;
//                $sql = "update ".tablename($this->order)." set `go_status` = '100' , `go_commission` = '".$go_commission."',`go_commission_num`='".$go_commission_num."' where weid=".$this->weid." and `go_id`=".$info['go_id'];
//                $res = pdo_query($sql);
//            }
//        }
//    }
    /**
     * 自动确认收货
     */
    public function autoSureGoods(){
        global $_W,$_GPC;
        //查询有无自动收货配置
        $cfg = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'order_set'));
        $arr = unserialize($cfg['value']);
        $time = $arr['order_auto_get_goods_time'];
        if(is_numeric($time) && $time>0){
            //自动收货
            $order = pdo_fetchall("select * from ".tablename($this->order)." where weid=".$this->weid." and go_status=30 and (go_send_goods_time<".(time()-$time*24*60*60)." OR (go_send_goods_time IS NULL AND  go_pay_time<".(time()-$time*24*60*60)."))  and `type`=1 order by go_id asc limit 100");
            foreach ($order as $v){
                $head_price ='';
                if($v['go_send_type']==2){
                    $user = pdo_get($this->member,array('m_openid'=>$v['go_team_openid']));
                    pdo_update($this->member,array('m_send_price_total'=>(floatval($v['go_send_pay'])+floatval($user['m_send_price_total'])),'m_money'=>(floatval($user['m_money'])+floatval($v['go_send_pay'])) ),array('m_id'=>$user['m_id']) );
                    $head_price .=',go_send_price_status=2';
                }
                //查找商品快照表,计算总佣金
                $snapshot_list = pdo_fetchall("select * from ".tablename($this->snapshot)." as sn where sn.oss_go_code =".$v['go_code']);
                $go_commission =0;
                foreach ($snapshot_list as $key =>$val){
                    $go_commission += floatval($val['oss_commission']);
                }
                $sql = "update ".tablename($this->order)." set `go_status` = '100' , `go_commission` = '".$go_commission."',`go_commission_num`=0,go_commission_time=".time().$head_price." where weid=".$this->weid." and `type`=1 and `go_id`=".$v['go_id'];
                $res = pdo_query($sql);
				$old_order_stream = pdo_get($this->order,array('go_is_cash'=>1,'go_id'=>$v['go_id']));
				//查得出就是之前已有流水 ,不进入判断
                if(!empty($res) && empty($old_order_stream) ){
//					 pdo_update('gpb_order',array('go_is_cash'=>1),array('go_id'=>$v['go_id']));
                    //生成流水表-佣金
                    $order_snapshot = pdo_fetchall("select * from ".tablename($this->snapshot)." where oss_go_code =".$v['go_code']);
                    $data_stream = array(
                        'gos_code'=>date('Ymd',time()).$this->nextId(),//流水号
                        'gos_go_code'=>$v['go_code'],//订单号v
                        'gos_stream_type'=>3,
                        'gos_type'=>2,
                        'gos_pay_type'=>1,
                        'gos_owner'=>'平台',
                        'gos_payer'=>$order_snapshot[0]['oss_buy_name'],
                        'gos_team'=>$order_snapshot[0]['oss_head_name'],
                        'gos_commet'=>'超过系统收货时间自动确认收货',
                        'gos_order_money'=>$go_commission,
                        'gos_real_money'=>0,
                        'gos_sure_pay_time'=>time(),
                        'gos_status'=>1,
                        'gos_add_time'=>time(),
                        'weid'=>$this->weid,
                        'gos_payer_openid'=>$order_snapshot[0]['oss_buy_openid'],
                        'gos_team_openid'=>$order_snapshot[0]['oss_head_openid']
                    );
                    //开启自动审核佣金后
                    $auto_sure_head_commission = pdo_get($this->config,array('key'=>'auto_sure_head_commission','weid'=>$this->weid));
                    $auto_sure_head_commission = isset($auto_sure_head_commission['value'])?$auto_sure_head_commission['value']:2;
                    if($auto_sure_head_commission == 1){
                        //查找商品快照表,计算总佣金
                        pdo_begin();
						$res = pdo_update('gpb_order',array('go_is_cash'=>1),array('go_id'=>$v['go_id']));
						if($res){
							$data_stream['gos_real_money']= $go_commission;
	                        $data_stream['gos_status']= 2;
	                        $data_stream['gos_commet']= '系统后台确认收货产生佣金,开启自动审核通过该佣金';
	                        $data_stream['gos_sure_pay_time']= time();
	                        //订单佣金自动审核
	                        $cash_member = pdo_update($this->member,array('m_money +='=>$go_commission),array('m_openid'=>$v['go_team_openid'],'weid'=>$this->weid));
						}
						if($cash_member){
							pdo_commit();
						} else {
							pdo_rollback();//失败回滚
						}
                    }
					$i = pdo_fetch(" select * from ".tablename("gpb_order_stream")." where gos_stream_type = 3 AND gos_go_code = ".$v['go_code']);
			        if(empty($i)){
				        pdo_insert($this->stream, $data_stream);
			        }
					
					
					
                    //分销佣金计算qdis
                    $distribution = pdo_get($this->config,['weid'=>$this->weid,'key'=>'distribution_state']);
                    $res = pdo_insert($this->order_log,array('gol_add_time'=>time(),'gol_des'=>'系统自动确认收货','gol_comment'=>'订单超过设定时间未确认收货','gol_go_code'=>$v['go_code'],'gol_u_name'=>'系统'));

                    if(!empty($distribution) && $distribution['value']==1){
                        //存在并开启
                        @require_once ('../addons/group_buy_plugin_distribution/distribution.php');
                        @$new_distribution = new distribution($this->weid);
                        @$resutl = $new_distribution->usercost($v['go_code']);
                    }
                    //团长推荐分销
                    $resutl_log = $this->headcost($v['go_code']);
                    //存日志
                    $file  = dirname(__FILE__).'/headrecommedmomey.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
                    if(file_exists($file) && filesize($file) > 100000){
                        unlink($file);//这里是直接删除，
                    }
                    $content = date('Y-m-d H:i:s');
                    $content .= "团长核销计算推荐分销佣金,oid={$v['go_code']}\n";
                    foreach ($resutl_log as $k=>$v){
                        $content .= "{$k}={$v}\n";
                        if($k == 'data'){
                            foreach ($resutl_log[$k] as $kk=>$vv){
                                $content .= "{$kk}={$vv}\n";
                            }
                        }
                    }
                    $content .= "------\n";
                    file_put_contents($file,$content.PHP_EOL,FILE_APPEND);
                    //                $res = pdo_update($this->order,array('go_status'=>100),array('go_id'=>$v['go_id']));
                    //                if(!empty($distribution) && $distribution['value']==1) {
                    //                    $new_distribution->doPageFraction_order_Detailed(array('order' => $v["go_code"]));
                    //                }
				}
				//获取积分
                $filename = '../addons/group_buy_plugin_fraction/hook.php';
            	if(file_exists($filename)){
            		require_once $filename;
            		$group = new Group_buy_plugin_fractionModuleHook();
//					echo '<pre>';
            		$res = $group->hookPageFraction_order_Detailed(array('0'=>array('order'=>$v['go_code'])));
//					print_r(array('0'=>array('order'=>$v['go_code'])));
//					print_r($res);exit;
				}
            }
        }
    }
    /*
     * 获取网站标题
     */
    public function getWebTitle(){
        $back_title_set = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'back_title_set'));
        if(empty($back_title_set) ){
            pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('后台左上角标题设置','','6',".time().",".$this->weid.",1,'back_title_set');");
        }
        $back_set_type = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'back_set_type'));
        if(empty($back_set_type) ){
            pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('后台左上角显示类型','1','6',".time().",".$this->weid.",1,'back_set_type');");
        }
        $back_icon_set = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'back_icon_set'));
        if(empty($back_icon_set) ){
            pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('后台左上角图标设置','','6',".time().",".$this->weid.",1,'back_icon_set');");
        }
        $back_title_set = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'back_title_set'));
        $back_set_type = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'back_set_type'));
        $back_icon_set = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'back_icon_set'));
        $data = array(
            'type'=>$back_set_type['value'],
            'title'=>$back_title_set['value'],
            'icon'=>tomedia($back_icon_set['value']),
        );

//        $val = unserialize($arr['value']);
//        $title = isset($val['after_web_title'])?$val['after_web_title']:'';
        return $data;
    }
    /**
     * 同步提交刷新页面
     */
    public function message_info($msg, $redirect = '', $type = '', $tips = false) {
        global $_W, $_GPC;
        if($redirect == 'refresh') {
            $redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
        }
        if($redirect == 'referer') {
            $redirect = referer();
        }
        //$redirect = check_url_not_outside_link($redirect);
        if($redirect == '') {
            $type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
        } else {
            $type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
        }
        if ($_W['isajax'] || !empty($_GET['isajax']) || $type == 'ajax') {
            if($type != 'ajax' && !empty($_GPC['target'])) {
                exit("
	<script type=\"text/javascript\">
		var url = ".(!empty($redirect) ? 'parent.location.href' : "''").";
		var modalobj = util.message('".$msg."', '', '".$type."');
		if (url) {
			modalobj.on('hide.bs.modal', function(){\$('.modal').each(function(){if(\$(this).attr('id') != 'modal-message') {\$(this).modal('hide');}});top.location.reload()});
		}
	</script>");
            } else {
                $vars = array();
                $vars['message'] = $msg;
                $vars['redirect'] = $redirect;
                $vars['type'] = $type;
                exit(json_encode($vars));
            }
        }
        if (empty($msg) && !empty($redirect)) {
            header('Location: '.$redirect);
            exit;
        }
        $label = $type;
        if($type == 'error') {
            $label = 'danger';
        }
        if($type == 'ajax' || $type == 'sql') {
            $label = 'warning';
        }
        if ($tips) {
            if (is_array($msg)){
                $message_cookie['title'] = 'MYSQL 错误';
                $message_cookie['msg'] = 'php echo cutstr(' . $msg['sql'] . ', 300, 1);';
            } else{
                $message_cookie['title'] = $caption;
                $message_cookie['msg'] = $msg;
            }
            $message_cookie['type'] = $label;
            $message_cookie['redirect'] = $redirect ? $redirect : referer();
            $message_cookie['msg'] = rawurlencode($message_cookie['msg']);

            isetcookie('message', stripslashes(json_encode($message_cookie, JSON_UNESCAPED_UNICODE)));
            if (!empty($message_cookie['redirect'])) {
                header('Location: ' . $message_cookie['redirect']);
            } else {
                include $this->template('web/message/message');
            }
        } else {
            include $this->template('web/message/message');
        }
        exit;
    }
    //测试
    function doWebtest(){
        $plugin_module = WeUtility::createModuleHook('group_buy_plugin_distribution');
        call_user_func_array(array($plugin_module, 'hookwebHome'));
        return '123';
    }

    public function insert_menu_data(){
        pdo_run("INSERT  INTO ".tablename('gpb_menu_list')." (`id`,`name`,`url`,`pid`,`icon`,`status`,`do`,`op`,`title`,`sort`,`parame`) VALUES 
(86,'团长设置','./index.php?c=site&a=entry&op=config&do=head&m=group_buy',55,'fa fa-cog','1','head','config','团长设置',60,NULL),
(85,'佣金流水','./index.php?c=site&a=entry&do=finance&op=stream_commission&m=group_buy',72,'fa fa-cog','1','finance','stream_commission','佣金流水',55,NULL),
(77,'生成配送单','./index.php?c=site&a=entry&op=wait&do=distribution&m=group_buy',75,'fa fa-cog','1','distribution','wait',NULL,44,NULL),
(76,'配送单','./index.php?c=site&a=entry&do=distribution&m=group_buy',75,'fa fa-cog','1','distribution','index',NULL,43,NULL),
(75,'配送','./index.php?c=site&a=entry&do=distribution&m=group_buy',0,'fa fa-truck','1','distribution',NULL,'配送管理',42,NULL),
(81,'权限设置','./index.php?c=site&a=entry&op=menu_index&do=config&m=group_buy',64,'fa fa-cog','1','config','menu_index',NULL,48,NULL),
(74,'退款','./index.php?c=site&a=entry&op=back_money&do=finance&m=group_buy',72,'fa fa-cog','1','finance','back_money',NULL,41,NULL),
(73,'提现','./index.php?c=site&a=entry&do=finance&m=group_buy',72,'fa fa-cog','1','finance','get_cash',NULL,40,NULL),
(72,'财务','./index.php?c=site&a=entry&do=finance&m=group_buy',0,'fa fa-bar-chart','1','finance',NULL,'财务管理',10,NULL),
(71,'打印机设置','./index.php?c=site&a=entry&op=print_set&do=config&m=group_buy',64,'fa fa-cog','1','config','print_set',NULL,38,NULL),
(41,'活动列表','./index.php?c=site&a=entry&do=action&m=group_buy',40,'fa fa-cog','1','action','index','活动列表',8,NULL),
(61,'会员列表','./index.php?c=site&a=entry&do=member&m=group_buy',60,'fa fa-cog','1','member','index',NULL,28,NULL),
(70,'订单设置','./index.php?c=site&a=entry&op=order_set&do=order&m=group_buy',42,'fa fa-cog','1','order','order_set',NULL,145,NULL),
(40,'活动','./index.php?c=site&a=entry&do=action&m=group_buy',0,'fa fa-flag-checkered','1','action','index','活动管理',7,NULL),
(69,'页面标题','./index.php?c=site&a=entry&op=title_set&do=config&m=group_buy',64,'fa fa-cog','-1','config','title_set',NULL,36,NULL),
(68,'首页设置','./index.php?c=site&a=entry&op=index_set&do=config&m=group_buy',64,'fa fa-cog','-1','config','index_set',NULL,35,NULL),
(67,'短信配置','./index.php?c=site&a=entry&op=msg&do=config&m=group_buy',64,'fa fa-cog','1','config','msg',NULL,34,NULL),
(66,'佣金设置','./index.php?c=site&a=entry&op=commission&do=config&m=group_buy',64,'fa fa-cog','-1','config','commission',NULL,33,NULL),
(65,'基本设置','./index.php?c=site&a=entry&do=config&m=group_buy',64,'fa fa-cog','1','config','index',NULL,32,NULL),
(64,'配置','./index.php?c=site&a=entry&do=config&m=group_buy',0,'fa fa-cog','1','config',NULL,'配置管理',60,NULL),
(63,'优惠券列表','./index.php?c=site&a=entry&do=market&m=group_buy',40,'fa fa-cog','1','action','coupon',NULL,30,NULL),
(62,'营销','./index.php?c=site&a=entry&do=market&m=group_buy',0,'fa fa-line-chart','-1','market',NULL,'营销管理',29,NULL),
(60,'会员','./index.php?c=site&a=entry&do=member&m=group_buy',0,'fa fa-users','1','member',NULL,'用户管理',27,NULL),
(59,'供应商列表','./index.php?c=site&a=entry&do=supplier&m=group_buy',58,'fa fa-cog','1','supplier','index',NULL,26,NULL),
(42,'订单','./index.php?c=site&a=entry&do=order&m=group_buy',0,'fa fa-file-text-o','1','order','index','订单管理',9,NULL),
(58,'供应','./index.php?c=site&a=entry&do=supplier&m=group_buy',0,'fa fa-user-plus','1','supplier',NULL,'供应商管理',25,NULL),
(43,'待发货','./index.php?c=site&a=entry&status=20&do=order&m=group_buy',42,'fa fa-cog','-1','order','','待发货订单',100,'status=20'),
(57,'团长列表','./index.php?c=site&a=entry&op=index&do=head&m=group_buy',55,'fa fa-cog','1','head','index',NULL,24,NULL),
(56,'申请团长','./index.php?c=site&a=entry&do=head&m=group_buy',55,'fa fa-cog','1','head','wantHead',NULL,23,NULL),
(47,'核销列表','./index.php?c=site&a=entry&op=orderSure&do=order&m=group_buy',42,'fa fa-cog','1','order','orderSure','核销列表',140,NULL),
(44,'待收货','./index.php?c=site&a=entry&status=30&do=order&m=group_buy',42,'fa fa-cog','-1','order','','待收货订单',110,'status=30'),
(55,'团长','./index.php?c=site&a=entry&do=head&m=group_buy',0,'fa fa-male','1','head',NULL,'团长管理',22,NULL),
(54,'小区列表','./index.php?c=site&a=entry&do=district&m=group_buy',55,'fa fa-cog','1','district','village',NULL,25,NULL),
(53,'区域','./index.php?c=site&a=entry&do=district&m=group_buy',0,'fa fa-map','-1','district',NULL,'区域管理',20,NULL),
(52,'商品分类','./index.php?c=site&a=entry&op=cate&do=goods&m=group_buy',50,'fa fa-cog','1','goods','cate',NULL,19,NULL),
(51,'商品列表','./index.php?c=site&a=entry&do=goods&m=group_buy',50,'fa fa-cog','1','goods','index',NULL,18,NULL),
(50,'商品','./index.php?c=site&a=entry&do=goods&m=group_buy',0,'fa fa-gift','1','goods',NULL,'商品管理',7,NULL),
(49,'广告列表','./index.php?c=site&a=entry&do=adv&m=group_buy',48,'fa fa-cog','-1','adv','index',NULL,16,NULL),
(48,'广告','./index.php?c=site&a=entry&do=adv&m=group_buy',0,'fa fa-audio-description','-1','adv',NULL,'广告管理',39,NULL),
(46,'订单列表','./index.php?c=site&a=entry&op=index&do=order&m=group_buy',42,'fa fa-cog','1','order','index','全部订单',130,NULL),
(45,'已完成','./index.php?c=site&a=entry&status=100&do=order&m=group_buy',42,'fa fa-cog','-1','order','','已完成订单',120,'status=100'),
(39,'版权设置','./index.php?c=site&a=entry&op=copyright_diy&do=diy&m=group_buy',34,'fa fa-cog','-1','diy','copyright_diy','版权设置',33,NULL),
(38,'顶部设置','./index.php?c=site&a=entry&op=top_diy&do=diy&m=group_buy',34,'fa fa-cog','-1','diy','top_diy','顶部设置',5,NULL),
(37,'底部设置','./index.php?c=site&a=entry&op=bottom_diy&do=diy&m=group_buy',34,'fa fa-cog','-1','diy','bottom_diy','底部设置',4,NULL),
(36,'首页管理','./index.php?c=site&a=entry&op=index_diy&do=diy&m=group_buy',34,'fa fa-cog','1','diy','index_diy','首页管理',2,NULL),
(34,'页面','./index.php?c=site&a=entry&do=diy&m=group_buy',0,'fa fa-clone','1','diy','index','页面管理',1,NULL),
(35,'我的模版','./index.php?c=site&a=entry&do=diy&op=index&m=group_buy',34,'fa fa-cog','1','diy','index','我的模版',3,NULL),
(78,'路线管理','./index.php?c=site&a=entry&op=route&do=distribution&m=group_buy',75,'fa fa-cog','1','distribution','route',NULL,45,NULL),
(79,'插件','./index.php?c=site&a=entry&do=plug&m=group_buy',0,'fa fa-plug','1','plug',NULL,'插件管理',46,NULL),
(82,'概览','./index.php?c=site&a=entry&do=overview&m=group_buy',0,'fa fa-tachometer','1','overview',NULL,'概览',-1,NULL),
(84,'交易流水','./index.php?c=site&a=entry&do=finance&op=stream_index&m=group_buy',72,'fa fa-cog','1','finance','stream_index','交易流水',50,NULL),
(87,'供应商设置','./index.php?c=site&a=entry&op=config&do=supplier&m=group_buy',58,'fa fa-cog','1','supplier','config','供应商设置',65,NULL),
(88,'商品页设置','./index.php?c=site&a=entry&op=config&do=goods&m=group_buy',50,'fa fa-cog','1','goods','config','商品页设置',70,NULL),
(91,'模版市场','./index.php?c=site&a=entry&do=diy&op=index_system&m=group_buy',34,'fa fa-cog','1','diy','index_system','模版市场',3,NULL),
(90,'版权设置','./index.php?c=site&a=entry&op=copyright&do=diy&m=group_buy',34,'fa fa-cog','1','diy','copyright','版权设置',34,NULL),
(92,'售后订单','./index.php?c=site&a=entry&op=afterSale&do=order&m=group_buy',42,'fa fa-cog','1','order','afterSale','售后订单',135,NULL),
(93,'物流配置','./index.php?c=site&a=entry&do=config&op=express&m=group_buy',64,'fa fa-cog','1','config','express','物流配置',155,NULL),
(94,'快递管理','./index.php?c=site&a=entry&do=config&op=express_tmp&m=group_buy',64,'fa fa-cog','1','config','express_tmp','快递管理',160,NULL),
(95,'运费模版','./index.php?c=site&a=entry&do=config&op=shipping&m=group_buy',64,'fa fa-cog','1','config','shipping','运费模版',165,NULL),
(96,'满减','./index.php?c=site&a=entry&do=action&m=group_buy&op=reduction',40,'fa fa-cog','1','action','reduction',NULL,10,NULL),
(97,'首页海报设置','./index.php?c=site&a=entry&do=diy&op=index_playbill&m=group_buy',34,'fa fa-cog','1','diy','index_playbill','首页海报设置',33,NULL),
(98,'团长推广设置','./index.php?c=site&a=entry&op=recommend_config&do=head&m=group_buy',55,'fa fa-cog','1','head','recommend_config','团长推广设置',170,NULL),
(99,'充值返利','./index.php?c=site&a=entry&do=member&m=group_buy&op=recharge_rebate',60,'fa fa-cog','2','member','recharge_rebate','充值返利',100,NULL),
(100,'会员设置','./index.php?c=site&a=entry&do=member&m=group_buy&op=config',60,'fa fa-cog','2','member','config','会员设置',150,NULL),
(101,'通用卷','./index.php?c=site&a=entry&do=market&m=group_buy&op=add',40,'fa fa-cog','1','action','add','通用卷',100,NULL),
(102,'分类卷','./index.php?c=site&a=entry&do=market&m=group_buy&op=cate',40,'fa fa-cog','1','action','cate','分类卷',110,NULL),
(103,'单品卷','./index.php?c=site&a=entry&do=market&m=group_buy&op=only_goods',40,'fa fa-cog','1','action','only_goods','单品卷',120,NULL),
(104,'指定发送','./index.php?c=site&a=entry&do=market&m=group_buy&op=point',40,'fa fa-cog','1','action','point','指定卷',130,NULL),
(105,'新人卷','./index.php?c=site&a=entry&do=market&m=group_buy&op=new_member',40,'fa fa-cog','1','action','new_member','新人卷',140,NULL),
(106,'发放记录','./index.php?c=site&a=entry&do=market&m=group_buy&op=record',40,'fa fa-cog','1','action','record','发放记录',90,NULL),
(107,'公众号','./index.php?c=site&a=entry&do=wechat&m=group_buy&op=index',64,'fa fa-cog','2','wechat','index','公众号',166,NULL),
(110,'订阅消息','./index.php?c=site&a=entry&do=templates&m=group_buy&op=index',64,'fa fa-cog','2','templates','index','订阅消息',166,NULL),
(108,'营销','./index.php?c=site&a=entry&do=markrting&m=group_buy&op=index',0,'fa fa-rmb','2','markrting','index','营销管理',177,NULL),
(109,'会员充值','./index.php?c=site&a=entry&do=markrting&m=group_buy&op=index',108,'fa fa-cog','2','markrting','index',NULL,178,NULL);");
    }
    /**
     * 菜单
     */
    public function menu_list($w)
    {
        if ($w['user']['uid'] == 1) {
            //总账号  显示全部菜单
            $info = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = 0 and status =1  order by sort asc");
            if (!empty($info)) {
                foreach ($info as $k => $v) {
                    $data = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = " . $v['id'] . " and status =1  order by sort asc");
                    $info[$k]['data'] = $data;
                    if (!empty($data)) {
                        foreach ($data as $data_k => $data_v){
                            $sub_data = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = " . $data_v['id'] . " and status =1  order by sort asc");
                            $info[$k]['data'][$data_k]['sub_data'] = $sub_data;
                        }

                    }
                }
            }
        } else {
            //不是总账号
//			1.判断是否设置了权限的
            $code = pdo_get($this->menu, array('uid' => $w['uid']));
            if ($code) {
                //设置了权限   按照权限来显示菜单
                $info = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = 0 and status =1  and id in (" . $code['value'] . ") order by sort asc");
                if (!empty($info)) {
                    foreach ($info as $k => $v) {
                        $data = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = " . $v['id'] . " and status =1  and id in (" . $code['value'] . ") order by sort asc");
                        $info[$k]['data'] = $data;
                        if (!empty($data)) {
                            foreach ($data as $data_k => $data_v){
                                $sub_data = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = " . $data_v['id'] . " and status =1  and id in (" . $code['value'] . ") order by sort asc");
                                $info[$k]['data'][$data_k]['sub_data'] = $sub_data;
                            }

                        }
                    }
                }
            } else {
                //没有设置权限  显示全部菜单   除开权限设置
                $info = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = 0 and status = 1  order by sort asc");
                if (!empty($info)) {
                    foreach ($info as $k => $v) {
                        $data = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = " . $v['id'] . " and status = 1  order by sort asc");
                        $info[$k]['data'] = $data;
                        if (!empty($data)) {
                            foreach ($data as $data_k => $data_v){
                                $sub_data = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = " . $data_v['id'] . " and status =1  order by sort asc");
                                $info[$k]['data'][$data_k]['sub_data'] = $sub_data;
                            }

                        }
                    }
                }

            }
        }
        return $info;

    }
    /*
     * 写入日志
     */
    public function logger($content)
    {
        $logSize = 100000;//10M 
        $log = "../addons/group_buy/public/log.txt";
        if(file_exists($log) && filesize($log) > $logSize){
            unlink($log);//这里是直接删除，可以做备份哈
        }
        file_put_contents($log, date('Y-m-d H:i:s') . " " .$content .PHP_EOL,FILE_APPEND);//日志写入函数
    }
    /**
     *检查Diy系统数据是否存在
     */
    public function checkDiyData(){
//        $arr =  pdo_getall($this->diy_page);
//        foreach ($arr as $k=> $v){
//            $arr[$k]['content']=unserialize($v['content']);
//        }
        if(!pdo_tableexists('gpb_diy_temp')){
            pdo_query("CREATE TABLE ".tablename('gpb_diy_temp')." (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(5) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '模板昵称',
  `isact` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '使用状态',
  `store` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '排序',
  `status` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `img` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '图标',
  `time` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `system` tinyint(1) DEFAULT '1' COMMENT '是否是系统模板(系统模板禁止删除),一般1，系统2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
        }
        if(!pdo_tableexists('gpb_diy_page')){
            pdo_query("CREATE TABLE ".tablename('gpb_diy_page')." (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(5) unsigned NOT NULL,
  `content` longtext COLLATE utf8_bin COMMENT '内容',
  `createtime` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '添加时间',
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `tempid` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '模板id',
  `status` int(2) DEFAULT '1' COMMENT '状态',
  `system` int(2) DEFAULT '1' COMMENT '是否是系统模板(系统模板禁止删除)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
        }
        $sys_temp = pdo_getall($this->diy_temp,array('system'=>2));
        if(count($sys_temp)!=4){
            pdo_delete($this->diy_temp,array('system'=>2));
            pdo_delete($this->diy_temp,array('id'=>1));
            pdo_delete($this->diy_temp,array('id'=>2));
            pdo_delete($this->diy_temp,array('id'=>3));
            pdo_delete($this->diy_temp,array('id'=>4));
            pdo_query("insert  into ".tablename('gpb_diy_temp')." (`id`,`weid`,`name`,`isact`,`store`,`status`,`img`,`time`,`system`) values 
(2,0,'风格3','1','1',1,'/addons/group_buy/public/bg/sys_temp5.jpg','1548985632',2),
(1,0,'风格1','-1','1',1,'/addons/group_buy/public/bg/sys_temp1.jpg','1548985899',2),
(3,0,'风格2','-1','1',1,'/addons/group_buy/public/bg/sys_temp4.jpg','1548985883',2),
(4,0,'麦芒风格','-1','1',1,'/addons/group_buy/public/bg/sys_temp6.png','1548985883',2);");
        }
        $sys_page = pdo_getall($this->diy_page,array('system'=>2),array('id'));
        if(count($sys_page) != 4){
            pdo_delete($this->diy_page,array('system'=>2));
            pdo_delete($this->diy_page,array('id'=>1));
            pdo_delete($this->diy_page,array('id'=>2));
            pdo_delete($this->diy_page,array('id'=>3));
            pdo_delete($this->diy_page,array('id'=>4));
            pdo_delete($this->diy_page,array('id in'=>'1,2,3,4'));
			//获取文件中的数据
            $http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://'.$_SERVER['HTTP_HOST'] : 'http://'.$_SERVER['HTTP_HOST'];
            $url = $http.'/addons/group_buy/block/template.php';
			$http = file_get_contents($url);
			$data = json_decode(base64_decode($http),true);
            foreach ($data as $k=>$v){
                $res = pdo_insert($this->diy_page,$v);
			}
        }
    }

    /**

     * 独立登录

     */

    public function doMobilelogin()

    {
//        exit("9090909");
        global $_W,$_GPC;
        load()->model('user');
        load()->model('message');
        load()->classs('oauth2/oauth2client');
        load()->model('setting');
        $setting = $_W['setting'];
        $_GPC['login_type'] = !empty($_GPC['login_type']) ? $_GPC['login_type'] : (!empty($_W['setting']['copyright']['login_type']) ? 'mobile': 'system');
        $login_urls = user_support_urls();
        if(empty($_GPC['i'])){
            $this->message_info('参数错误，无法登录');
            exit;
        }
        if (checksubmit() || $_W['isajax']) {
            $now_url = $_SERVER['REQUEST_URI'];
            setcookie('logout_url',$now_url,time()+86400,'/');
            $this->_login('');
        }
        include $this->template('login');
    }

    public function _login($forward=''){
        global $_GPC, $_W;
        $version_id_arr = pdo_get('wxapp_versions',array('uniacid'=>$_GPC['i']));
        if (empty($_GPC['login_type'])) {
            $_GPC['login_type'] = 'system';
        }
        if (empty($_GPC['handle_type'])) {
            $_GPC['handle_type'] = 'login';
        }
		session_start();
		$key = $this->complex_authkey();
		$_SESSION['__code'] = md5(strtolower($_GPC['verify']) .$key);
        if ($_GPC['handle_type'] == 'login') {
            $member = OAuth2Client::create($_GPC['login_type'], $_W['setting']['thirdlogin'][$_GPC['login_type']]['appid'], $_W['setting']['thirdlogin'][$_GPC['login_type']]['appsecret'])->login();
        } else {
            $member = OAuth2Client::create($_GPC['login_type'], $_W['setting']['thirdlogin'][$_GPC['login_type']]['appid'], $_W['setting']['thirdlogin'][$_GPC['login_type']]['appsecret'])->bind();
        }
        if (is_error($member)) {
//            itoast($member['message'], url('user/login'), '');

            $forward = "/app/index.php?c=entry&do=login&m={$_W['current_module']['name']}&i={$_GPC['i']}&message=true";
            if(!empty($_COOKIE['logout_url'])){
                $forward = $_COOKIE['logout_url'];
            }else{
                echo "<pre/>";
                var_dump($_COOKIE);
                die;
            }
//            $forward = "/web/index.php?c=entry&m=group_buy&do=logins&i={$_GPC['i']}&message=true";
            header('location: ' . $forward);
            exit;
        }
		
        $record = user_single($member);
        if (!empty($record)) {
            if ($record['status'] == USER_STATUS_CHECK || $record['status'] == USER_STATUS_BAN) {
                itoast('您的账号正在审核或是已经被系统禁止，请联系网站管理员解决?', url('user/login'), '');
            }
            $_W['uid'] = $record['uid'];
            $_W['isfounder'] = user_is_founder($record['uid']);
            $_W['user'] = $record;
//          if (empty($_W['isfounder'])) {
//              if (!empty($record['endtime']) && $record['endtime'] < TIMESTAMP) {
//                  itoast('您的账号有效期限已过，请联系网站管理员解决！', '', '');
//              }
//          }
            if (!empty($_W['siteclose']) && empty($_W['isfounder'])) {
                itoast('站点已关闭，关闭原因:'. $_W['setting']['copyright']['reason'], '', '');
            }
            $cookie = array();
            $cookie['uid'] = $record['uid'];
            $cookie['lastvisit'] = $record['lastvisit'];
            $cookie['lastip'] = $record['lastip'];
            $cookie['hash'] = !empty($record['hash']) ? $record['hash'] : md5($record['password'] . $record['salt']);
            $session = authcode(json_encode($cookie), 'encode');
            isetcookie('__session', $session, !empty($_GPC['rember']) ? 7 * 86400 : 0, true);
            $status = array();
            $status['uid'] = $record['uid'];
            $status['lastvisit'] = TIMESTAMP;
            $status['lastip'] = CLIENT_IP;
            user_update($status);
//            $forward="/web/index.php?c=account&a=display&do=switch&module_name={$_W['current_module']['name']}&version_id={$version_id_arr['id']}&uniacid={$_GPC['i']}";
            //$forward="/web/index.php?c=home&a=welcome&do=account_ext&m={$_W['current_module']['name']}&version_id={$version_id_arr['id']}";
            //$forward="/web/index.php?c=site&a=entry&do=overview&m={$_W['current_module']['name']}&version_id={$version_id_arr['id']}";
//            if ($record['uid'] != $_GPC['__uid']) {
//                isetcookie('__uniacid', '', -7 * 86400);
//                isetcookie('__uid', '', -7 * 86400);
//            }
            isetcookie('__uniacid', $_GPC['i'], 7 * 86400);
            isetcookie('__uid', $record['uid'], 7 * 86400);

            if (!empty($failed)) {
                pdo_delete('users_failed_login', array('id' => $failed['id']));
            }
            $_W['uniacid'] = $_GPC['i'];
            $_W['is_group_buy_supplier'] = 1;
            $forward = '/web'.trim($this->createWebUrl('overview'),'.');
//            var_dump($_W);exit;
            header('location: ' . $forward);
        } else {
            if (empty($failed)) {
                pdo_insert('users_failed_login', array('ip' => CLIENT_IP, 'username' => trim($_GPC['username']), 'count' => '1', 'lastupdate' => TIMESTAMP));
            } else {
                pdo_update('users_failed_login', array('count' => $failed['count'] + 1, 'lastupdate' => TIMESTAMP), array('id' => $failed['id']));
            }
            $forward = "/app/index.php?c=entry&do=login&m={$_W['current_module']['name']}&i={$_GPC['i']}&message=true";
//            $forward = "/web/index.php?c=entry&m=group_buy&do=logins&i={$_GPC['i']}&message=true";
            header('location: ' . $forward);
            exit;
        }
    }
	public function doMobileLogin_do_header(){
		global $_GPC, $_W;
		load()->model('user');
        load()->model('message');
        load()->classs('oauth2/oauth2client');
        load()->model('setting');
		$this->_login();
	}
    /**
     * 录入系统快递模版
     */
    public function create_express_system_tmp(){
        if(!pdo_tableexists('gpb_express')) {
            pdo_query("CREATE TABLE ".tablename('gpb_express')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '快递表id',
  `simplecode` varchar(100) NOT NULL COMMENT 'code',
  `name` varchar(100) NOT NULL COMMENT '名称',
  `create_time` char(15) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` char(15) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '第三方是否支持 1即时查询',
  `start` tinyint(4) DEFAULT '0' COMMENT '是否启用',
  `weid` int(11) NOT NULL COMMENT '模块id',
  `system` tinyint(1) DEFAULT '1' COMMENT '是否是系统自带 1是 2不是',
  `is_del` tinyint(1) DEFAULT '1' COMMENT '是否删除 1不 2是',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;");
        }
        $sql = "insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('AJ','安捷快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('ANE','安能物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('AXD','安信达快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('BQXHM','北青小红帽','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('BFDF','百福东方','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('CCES','CCES快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('CITY100','城市100','0','0','1','1','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('COE','COE东方快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('CSCY','长沙创一','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('CDSTKY','成都善途速运','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('DBL','德邦','0','0','1','1','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('DSWL','D速物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('DTWL','大田物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('EMS','EMS','0','0','1','1','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('FAST','快捷速递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('FEDEX','FEDEX联邦(国内件）','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('FEDEX_GJ','FEDEX联邦(国际件）','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('FKD','飞康达','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('GDEMS','广东邮政','0','0','1','1','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('GSD','共速达','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('GTO','国通快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('GTSD','高铁速递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('HFWL','汇丰物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('HHTT','天天快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('HLWL','恒路物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('HOAU','天地华宇','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('hq568','华强物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('HXLWL','华夏龙物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('HYLSD','好来运快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('JGSD','京广速递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('JIUYE','九曳供应链','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('JJKY','佳吉快运','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('JLDT','嘉里物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('JTKD','捷特快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('JXD','急先达','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('JYKD','晋越快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('JYM','加运美','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('JYWL','佳怡物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('KYWL','跨越物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('LB','龙邦快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('LHT','联昊通速递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('MHKD','民航快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('MLWL','明亮物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('NEDA','能达速递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('PADTF','平安达腾飞快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('QCKD','全晨快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('QFKD','全峰快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('QRT','全日通快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('RFD','如风达','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('SAD','赛澳递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('SAWL','圣安物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('SBWL','盛邦物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('SDWL','上大物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('SFWL','盛丰物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('SHWL','盛辉物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('ST','速通物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('STWL','速腾快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('SURE','速尔快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('UAPEX','全一快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('UC','优速快递','0','0','1','1','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('WJWL','万家物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('WXWL','万象物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('XBWL','新邦物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('XFEX','信丰快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('XYT','希优特','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('XJ','新杰物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YADEX','源安达快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YCWL','远成物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YD','韵达快递','0','0','1','1','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YDH','义达国际物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YFEX','越丰物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YFHEX','原飞航物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YFSD','亚风快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YTKD','运通快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YTO','圆通速递','0','0','1','1','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YXKD','亿翔快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('YZPY','邮政平邮/小包','0','0','1','1','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('ZENY','增益快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('ZHQKD','汇强快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('ZJS','宅急送','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('ZTE','众通快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('ZTKY','中铁快运','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('ZTO','中通速递','0','0','1','1','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('ZTWL','中铁物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('ZYWL','中邮物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('AMAZON','亚马逊物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('SUBIDA','速必达物流','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('RFEX','瑞丰速递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('QUICK','快客快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('CJKD','城际快递','0','0','1','1','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('CNPEX','CNPEX中邮快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('HOTSCM','鸿桥供应链','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('HPTEX','海派通物流公司','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('AYCA','澳邮专线','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('PANEX','泛捷快递','0','0','1','0','0','1','1');
insert into ".tablename('gpb_express')." (`simplecode`, `name`, `create_time`, `update_time`, `status`, `start`, `weid`, `system`, `is_del`) values('PCA','PCA Express','0','0','1','0','0','1','1');
";
        pdo_run($sql);
        return;
    }

    /**
     * @return string
     */
    public function checkIsHaveSupplierLogin()
    {
        $dir_path = '../addons/group_buy/template/mobile';
        if(!file_exists($dir_path)){
            mkdir ($dir_path,0777,true);
        }
        $file_path = '../addons/group_buy/template/mobile/login.html';
        if(!file_exists($file_path)){
            $sample_path = '../addons/group_buy/template/web/sample/sample_1.html';
            $sample =fopen($sample_path,"r");
            //替换example内容，并获取内容赋值给$str
            $fp=fopen($sample_path,"r");
            $str=fread($fp,filesize($sample_path));
            fclose($fp);

            //新建空白文件，将$str写入
            $handle=fopen($file_path,"w");
            fwrite($handle,$str);
            fclose($handle);
        }
        return ;
    }
    /**
     * 团队关系建立
     * $pid int 邀请人id
     * $uid int 被邀请人id
     * return $result array 返回数组 code-0绑定成功 -1绑定失败,进入重新绑定流程
     */
    public function headbingteam($uid=0,$pid=0){
        if($uid<1){
            return array('msg'=>"用户唯一标识错误",'code'=>1);
        }
        //建立分销用户绑定
        $user = [
            'm_id'=>$uid,
            'weid'=>$this->weid,
        ];
        $user = pdo_get("gpb_member",$user);
        if(empty($user) && $pid==0){
            return array('msg'=>"您还为成为分销用户",'code'=>1);
        }
        if($pid==0){
            //是否已是其他人下级
            $group_log = pdo_get("gpb_head_group_log",array('weid'=>$this->weid,'uid'=>$uid));
            if(!empty($group_log)){
                //是其他人下级
                $pid = $group_log['pid'];
            }
        }
        if($pid==0){
            //无上级，自己成为leader
            $data = [
                'leader_id'=>$uid,
                'create_time'=>time(),
                'update_time'=>time(),
                'weid'=>$this->weid,
                'status'=>1
            ];
            $res = pdo_insert("gpb_head_group",$data);
            return $res?array('msg'=>"绑定成功",'code'=>0,'data'=>$data):array('msg'=>"绑定失败，请重试",'code'=>1);
//            return $res?$this->ReturnArray("绑定成功",0,$data):$this->ReturnArray('绑定失败，请重试');
        }else{
            //如果是自己
            if($pid == $uid){
                return array('msg'=>"无法绑定自己",'code'=>1);
            }
            //是否上级存在
            $p_info = pdo_get("gpb_member",['m_id'=>$pid,'weid'=>$this->weid]);
            if(empty($p_info)){
                //无上级返回失败
                return array('msg'=>"非法上级",'code'=>1);
            }
            //是否已是其他人下级
            $group_log = pdo_get("gpb_head_group_log",array('weid'=>$this->weid,'uid'=>$uid));
            if(!empty($group_log)){
                //是其他人下级
                return array('msg'=>"非法上级",'code'=>1);
            }
            //有上级，获取上级团队信息
            $top_team = pdo_get("gpb_head_group",['leader_id'=>$pid]);
            if(empty($top_team)){
                //不存在team
                return array('msg'=>"团队不存在",'code'=>1);
            }
            //先查询下该用户
            $u_team = pdo_get("gpb_head_group",['leader_id'=>$uid]);
            if(!empty($u_team)){
                //当该用户已经是团长分销团队里的人之后不能被推荐
                return array('msg'=>"该用户已经在团长分销团队里",'code'=>1);
            }
            $sql = "update ".tablename("gpb_head_group")." set `lv1`=CONCAT(lv1,',{$uid}') where `id`='{$top_team['id']}'";
//            exit($sql);
            $res = pdo_query($sql);
            //是否有二级团队
            $sql = "select * from ".tablename("gpb_head_group")." where find_in_set('{$pid}',lv1)";
            $mid_team = pdo_fetchall($sql);
            if(!empty($mid_team[0])){
                $mid_team = $mid_team[0];
                $sql = "update ".tablename("gpb_head_group")." set `lv2`=CONCAT(lv2,',{$uid}') where `id`='{$mid_team['id']}'";
                pdo_query($sql);
            }
            //是否有三级团队
            $sql = "select * from ".tablename("gpb_head_group")." where find_in_set('{$pid}',lv2)";
            $lv2_team = pdo_fetchall($sql);
            if(!empty($lv2_team[0])){
                $lv2_team = $lv2_team[0];
                $sql = "update ".tablename("gpb_head_group")." set `lv3`=CONCAT(lv3,',{$uid}') where `id`='{$lv2_team['id']}'";
                pdo_query($sql);
            }
            //加入日志
            $log = [
                'uid'=>$uid,
                'pid'=>$pid,
                'create_time'=>time(),
                'update_time'=>time(),
                'status'=>1,
                'weid'=>$this->weid
            ];
            pdo_insert('gpb_head_group_log',$log);
            return $res?array('msg'=>"绑定成功",'code'=>0,'data'=>$log):array('msg'=>"绑定失败，请重试",'code'=>1);
        }
    }

    /**
     * 推荐人关系确认
     * $uid int 被推荐人id
     * $pid int 推荐人id
     * $num int 购买次数
     * $order_money double 当前订单金额
     */
    public function commond_set_log($uid=0,$pid=0,$num=0,$order_money=0){
        if(empty($uid) || empty($pid)){
            return array('msg'=>"参数错误",'code'=>1);
        }
        //获取推荐奖奖金
        $head_recommend_price = pdo_get($this->config,array('key'=>'head_recommend_price','weid'=>$this->weid));
        $money = isset($head_recommend_price['value'])?$head_recommend_price['value']:0;
        $log_info = pdo_get("gpb_head_commond_log",['uid'=>$uid,'pid'=>$pid,'weid'=>$this->weid]);
        if(empty($log_info)){
            //为空 新增数据
            $log = [
                'uid'=>$uid,
                'pid'=>$pid,
                'num'=>0,
                'all_money'=>0,
                'commoned_times'=>1,
                'now_times'=>1,
                'weid'=>$this->weid,
                'create_time'=>time(),
                'update_time'=>time(),
                'get_money'=>$money
            ];
            //设置总推荐人数
//            $total_num = 1;//$this->config['distribution_commoned_value']['commoned_times'];
            //本轮第几次计算
//            $used_log = pdo_get("gpb_head_commond_log",['pid'=>$pid,'weid'=>$this->weid],'*','',['now_times desc','id desc','commoned_times desc']);
//            if($used_log['commoned_times']<$total_num){
//                $log['commoned_times'] = $used_log['commoned_times']+1;
//                $log['now_times'] = $used_log['now_times'];
//            }else{
//                $log['commoned_times'] = 1;
//                if(!empty($used_log)){
//                    $log['now_times'] = $used_log['now_times']+1;
//                }else{
//                    $log['now_times'] = 1;
//                }
//
//            }
            $res = pdo_insert("gpb_head_commond_log",$log);
        }else{
            //不为空 修改数据
//            if($order_money<=0){
//                return $this->ReturnArray("订单金额错误");
//            }
//            if($order_money<$this->config['distribution_commoned_value']['solo_money'] && $this->config['distribution_commoned_value']['solo_money']!=0){
//                return $this->ReturnArray("不满足条件",0);
//            }
//            $sql = "update ".tablename("gpb_distrution_commond_log")." set `all_money` = `all_money` + {$order_money} `num` = `num`+1 where `id` = '{$log_info['id']}'";
//            $res = pdo_query($sql);
            return array('msg'=>"失败，已有推荐奖数据",'code'=>1);
        }
        //数据处理完成，进入流程是否有满足条件的发放奖金
        $this->commondmoney($pid);
        return $res?array('msg'=>"增加成功",'code'=>0):array('msg'=>"增加失败",'code'=>1);
    }
    /**
     * 推荐奖
     * $commoned_log array 推荐日志详情
     */
    public function commondmoney($pid=0){
        if($pid<1){
            return array('msg'=>"参数错误",'code'=>1);
        }
        //获取推荐奖奖金
        $head_recommend_price = pdo_get($this->config,array('key'=>'head_recommend_price','weid'=>$this->weid));
        $money = isset($head_recommend_price['value'])?$head_recommend_price['value']:0;
        $res = $this->addmoney('',$pid,$money,"完成推荐奖条件",2);
//        if($res){
//            //修改用户数据、佣金
//            for($i=0;$i<$all_num;$i++){
//
//            }
//        }
        return $res['code']==0?array('msg'=>"修改成功",'code'=>0):array('msg'=>"修改失败",'code'=>1);
    }
    /**
     * 用户佣金增加
     * $uid int 用户id
     * $money double 增加金额
     * $msg string 增加资金途径
     */
    public function addmoney($order_code='',$uid=0,$money=0,$msg = '',$from_type=1){
        if($uid<1){
            return array('msg'=>"用户不存在",'code'=>1);
        }
        if($money<=0){
            return array('msg'=>"金额错误",'code'=>1);
        }
        $user = pdo_get("gpb_head_money",['uid'=>$uid,'weid'=>$this->weid,'check_state'=>1]);
        if(empty($user)){
//            return array('msg'=>"该用户不是团长分销用户",'code'=>1);
            //没有记录先插入
            $user = [
                'uid'=>$uid,
                'create_time'=>time(),
                'update_time'=>time(),
                'status'=>1,
                'weid'=>$this->weid,
            ];
            pdo_insert("gpb_head_money",$user);
        }
        $sql = "update ".tablename("gpb_head_money")." set `money` = money+{$money} where `uid`='{$uid}' ";
        $res = pdo_query($sql);
        $this->moneychangelog($order_code,$uid,1,$money,"{$msg},佣金增加{$money}元",$from_type);
        return $res?array('msg'=>"佣金修改成功",'code'=>0):array('msg'=>"佣金修改失败",'code'=>1);
    }
    /**
     * 佣金变动日志记录
     * $uid int 用户id
     * $money 变动金额
     * $type 变动金额类型
     * $msg 变动信息
     */
    public function moneychangelog($order_code='',$uid=0,$type=1,$money=0,$msg='',$from_type){

        //2020-03-10 保存变动时分佣类型 比例、金额 周龙
        //获取当前分佣配置
        $head_agent_get_type = pdo_fetchcolumn("select `value` from ".tablename($this->config)." where weid={$this->weid} and `key`='head_agent_get_type'");
        $head_parsent = [];
        $head_parsent['lv1'] = pdo_fetchcolumn("select `value` from ".tablename($this->config)." where weid={$this->weid} and `key`='head_agent_lever_one'");
        $head_parsent['lv2'] = pdo_fetchcolumn("select `value` from ".tablename($this->config)." where weid={$this->weid} and `key`='head_agent_lever_two'");
        $head_parsent['lv3'] = pdo_fetchcolumn("select `value` from ".tablename($this->config)." where weid={$this->weid} and `key`='head_agent_lever_three'");

        $parsent = intval($head_agent_get_type)===1?$head_parsent:[];
        $fix = intval($head_agent_get_type)===2?$head_parsent:[];

        $log = [

            'uid' => $uid,

            'info' => $msg,

            'weid' => $this->weid,

            'type' => $type,

            'money' => $money,

            'create_time' => time(),

            'update_time' => time(),

            'type_from' => $from_type,
            'percent'=>serialize($parsent),
            'fiexd'=>serialize($fix),
            'dis_type'=>$head_agent_get_type

        ];

        if (!empty($order_code)) {

            $log['order_code'] = $order_code;

        }

        $res = pdo_insert("gpb_head_money_log",$log);
        return $res?array('msg'=>"日志写入成功",'code'=>0):array('msg'=>"日志写入失败",'code'=>1);
    }

    /**
     * 团长分销取消订单扣除佣金
     */
    public function headcannelorder($order_sn='',$gid=''){
        if(empty($order_sn) && empty($gid)){
            return false;
        }
        //查询是否有参与该订单分销用户
        $list = pdo_fetchall("select * from ".tablename("gpb_head_money_log")." where `weid`='{$this->weid}' and order_code='{$order_sn}' and `type_from`=1 and gid={$gid}");
        if(empty($list)){
            //为空无分销订单参与
            return ['code'=>0,'msg'=>'无分销参与'];
        }
        //有分销订单餐饮业
        foreach ($list as $k=>$v){
            pdo_begin();
            $uid = $v['uid'];
            $money = $v['money'];
            $money = doubleval($money);
            $res = pdo_query("update ".tablename("gpb_head_money")." set money = money-{$money},update_time='".time()."' where `uid`={$uid} and weid={$this->weid} and gid={$gid}");
            if($res){
                //加入日志
                $log = [
                    'uid'=>$uid,
                    'info'=>"订单{$order_sn}退款,",
                    'weid'=>$this->weid,
                    'type'=>2,
                    'money'=>$money,
                    'create_time'=>time(),
                    'update_time'=>time(),
                    'type_from'=>1,
                    'order_code'=>$order_sn
                ];
                $result = pdo_insert("gpb_head_money_log",$log);
                if($result){
                    pdo_commit();
                }else{
                    pdo_rollback();
                }
            }
        }
        return ['msg'=>'处理完成','code'=>0];

    }

    /**
     * 佣金计算
     * $osn string 订单号
     */
    public function headcost($osn=''){
        //获取当前配置
        $head_agent_open = pdo_get($this->config,array('key'=>'head_agent_open','weid'=>$this->weid));
        if(isset($head_agent_open['value']) && $head_agent_open['value']!=1){
            return array('msg'=>'未开启团长推广代理配置','code'=>1);
        }
        $head_agent_get_type_arr = pdo_get($this->config,array('key'=>'head_agent_get_type','weid'=>$this->weid));
        if(!isset($head_agent_get_type_arr['value']) || empty($head_agent_get_type_arr['value'])){
            return array('msg'=>'提成类型设置有误','code'=>1);
        }
        $head_agent_get_type = $head_agent_get_type_arr['value'];
        //获取当前分佣等级参数是否配置
//        for($i=1;$i<=$config['distribution_lv'];$i++){
//            switch($config['distribution_type']){
//                case 1:
//                    //百分比分佣
//                    if(empty($config["distribution_lv{$i}_parsent"])){
//                        return $this->ReturnArray("当前开启分佣等级为{$config['distribution_lv']}级，请设置{$i}级分佣比例");
//                    }
//                    break;
//                case 2:
//                    //固定分佣
//                    if(empty($config["distribution_lv{$i}_fixed"])){
//                        return $this->ReturnArray("当前开启分佣等级为{$config['distribution_lv']}级，请设置{$i}级分佣金额");
//                    }
//                    break;
//            }
//        }
        if($osn=='' || empty($osn)){
            return array('msg'=>'订单参数错误','code'=>1);
        }
        $order = pdo_get("gpb_order",['go_code'=>$osn,'weid'=>$this->weid,"go_status"=>100]);
        if(empty($order)){
            return array('msg'=>'订单不存在','code'=>1);
        }

        $openid = $order['go_team_openid'];
        $user = pdo_get("gpb_member",['m_openid'=>$openid,'weid'=>$this->weid]);
        $buyer = pdo_get("gpb_member",['m_openid'=>$order['openid'],'weid'=>$this->weid]);
        $uid = $user['m_id'];
        //计算订单总金额
        $total_money = $order['go_real_price']+$order['go_send_pay'];
        //获取所有团队信息从低到高找

        $all_lv2 = '';//直属上级
        $all_lv1 = '';//上级的上级
        $all_lv0 = '';//lear级
//        $all_lv4 = '';//自身

        //开启了几级分销
        $head_agent_level_arr = pdo_get($this->config,array('key'=>'head_agent_level','weid'=>$this->weid));
        if(isset($head_agent_level_arr['value'])){
            $head_agent_level = $head_agent_level_arr['value'];
        }else{
            $head_agent_level=1;
        }

        if($head_agent_level==3){
            //所属最低级所在团队 自身属于lv3 ；leader参与分佣
            $sql = "select * from ".tablename("gpb_head_group")." where find_in_set('{$uid}',lv3) and `weid`='{$this->weid}'";
            $team = pdo_fetchall($sql);
            if(!empty($team[0])){
                //存在团队
                $team = $team[0];

                $all_lv0 = $team['leader_id'];
            }
        }

        if($head_agent_level>=2) {
            //所属二级团队 自身所属lv2； leader 参与分佣
            $sql = "select * from " . tablename("gpb_head_group") . " where find_in_set('{$uid}',lv2) and `weid`='{$this->weid}'";
            $team2 = pdo_fetchall($sql);
            if (!empty($team2[0])) {
                //存在团队
                $team2 = $team2[0];
                $all_lv1 = $team2['leader_id'];
            }
        }

        if($head_agent_level>=1) {
            //所属三级团队 自身所属lv1 leader参与分佣
            $sql = "select * from " . tablename("gpb_head_group") . " where find_in_set('{$uid}',lv1) and `weid`='{$this->weid}'";
            $team3 = pdo_fetchall($sql);
            if (!empty($team3[0])) {
                $team3 = $team3[0];
                $all_lv2 = $team3['leader_id'];
            }
        }

//        if($this->config['distribution_isself']==1) {
//            //是否自身参与分佣
//            $all_lv4 = $uid;
//        }
//        $head_agent_get_type = pdo_get($this->config,array('key'=>'head_agent_get_type','weid'=>$weid));
        //获取各种等级分佣配置
        $head_agent_lever_one = pdo_get($this->config,array('key'=>'head_agent_lever_one','weid'=>$this->weid));
        $lever_one = (isset($head_agent_lever_one['value']) && !empty($head_agent_lever_one['value']))?$head_agent_lever_one['value']:0;
        $head_agent_lever_two = pdo_get($this->config,array('key'=>'head_agent_lever_two','weid'=>$this->weid));
        $lever_two = (isset($head_agent_lever_two['value']) && !empty($head_agent_lever_two['value']))?$head_agent_lever_two['value']:0;
        $head_agent_lever_three = pdo_get($this->config,array('key'=>'head_agent_lever_three','weid'=>$this->weid));
        $lever_three = (isset($head_agent_lever_three['value']) && !empty($head_agent_lever_three['value']))?$head_agent_lever_three['value']:0;
        if($head_agent_get_type==1){
            //百分比分佣
            //生成键值对, key 为用户id,value为佣金金额
            $arr = [];
            if(!empty($all_lv0)){
                //最高级分佣最少
                $arr[$all_lv0] = floatval($total_money)*floatval($lever_three)/100;
            }
            if(!empty($all_lv1)){
                $arr[$all_lv1] = floatval($total_money)*floatval($lever_two)/100;
            }
            if(!empty($all_lv2)){
                $arr[$all_lv2] = floatval($total_money)*floatval($lever_one)/100;
            }
//            if(!empty($all_lv4)){
//                $arr[$all_lv4] = $total_money*$config['distribution_leader_parsent']/100;
//            }
        }elseif($head_agent_get_type==2){
            //固定金额分佣
            //生成键值对, key 为用户id,value为佣金金额
            $arr = [];
            if(!empty($all_lv0)){
                $arr[$all_lv0] =floatval($lever_three);
            }
            if(!empty($all_lv1)){
                $arr[$all_lv1] = floatval($lever_two);
            }
            if(!empty($all_lv2)){
                $arr[$all_lv2] = floatval($lever_one);
            }

        }else{
            return array('msg'=>'请设置提成方式','code'=>1);
        }
        if(empty($arr)){
            return array('msg'=>'无人参与分佣','code'=>1);
        }
        if($this->check_base64_out_json($user['m_nickname'])){
            $user['m_nickname'] = base64_decode($user['m_nickname']);
        }
        if($this->check_base64_out_json($buyer['m_nickname'])){
            $buyer['m_nickname'] = base64_decode($buyer['m_nickname']);
        }

        //佣金处理
        foreach ($arr as $k=>$v){
            $this->addmoney($osn,$k,$v,"因{$user['m_nickname']}团长下用户{$buyer['m_nickname']}消费{$total_money}元，获得佣金{$v}元",1);
        }
        return array('msg'=>'分佣计算完成','code'=>0,'data'=>$arr);
    }
    /*
     * 迪哥取配置
     */
    public function sc($name = 'markrting_rebate' ){
        $info = pdo_get("gpb_config",array('key'=>$name,'weid'=>$this->weid,'status'=>1));
        return $info['value'];
    }
    /*
     * 存文本日志的函数
     *  string $filename 文件名
     *  string $content 日志文本
     */
    public function txt_logging_fun($filename,$content){
        if(empty($filename)||empty($content)){
            return;
        }
        //存日志
        $file  = dirname(__FILE__).'/'.$filename;//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
        if(file_exists($file) && filesize($file) > 100000){
            unlink($file);//这里是直接删除，
        }
        file_put_contents($file,$content.PHP_EOL,FILE_APPEND);
        return;
    }

    public function recharge_list($time){
        $rebates = $this->sc('markrting_rebates');
        $rebates = $rebates ? $rebates : '释放';
        $data = pdo_fetchall(" select * from ".tablename("gpb_recharge_list")." where list_type = 1 and `time` <= ".$time);
        if($data){
            $str = " insert into ".tablename("gpb_recharge_log")." (`uid`,`openid`,`info`,`type`,`create_time`,`weid`,`money`,`l_type`,`ltime`) VALUES ";
//          $where = "UPDATE ".tablename("gpb_recharge_list")." SET list_type = 2,`status`=1 WHERE 1 ";
            foreach($data as $k=>$v){
                //将释放的金额  写入日志
//              if($k === 0){
//                  $where .= " and ( id = ".$v['id'];
//              }else{
//                  $where .= " or id = ".$v['id'];
//              }
				$res = pdo_update("gpb_recharge_list",array('list_type'=>2,'status'=>1),array('id'=>$v['id']));
                if($v['overdue'] == 2 && !empty($res)){
                    pdo_update("gpb_member",array("m_money_balance +="=>$v['money']),array('m_openid'=>$v['openid']));
                }
				if(!empty($res)){
					$str .= " (".$v['id'].",'".$v['openid']."','每天".$rebates.($v['money']+$v['use_money'])."元',2,".$v['time'].",".$this->weid.",".$v['money'].",1,'A".time()."'),";
				}
            }
//          $where .= " )";
            $str = trim($str,',');
            pdo_run($str);//将不需要过期的释放金加入余额  写入日志
//          pdo_run($where);//将已经加入余额的释放金改变状态
        }
        //查询需要过期的
        $data = pdo_fetchall(" select * from ".tablename("gpb_recharge_list")." where list_type = 1 and overdue = 1 and time < ".$time);
        if($data){
            $str = " insert into ".tablename("gpb_recharge_log")." (`uid`,`openid`,`info`,`type`,`create_time`,`weid`,`money`,`l_type`) VALUES ";
            $where = "UPDATE ".tablename("gpb_recharge_list")." SET list_type = 3,`status`=1 WHERE 1 ";
            foreach($data as $k=>$v){
                //过期模块  全部关闭
                $ms = $v['money']+$v['use_money'];
                $str .= " (".$v['id'].",'".$v['openid']."','每天".$rebates.$ms."元，过期扣除.',2,".$v['time'].",".$this->weid.",".$ms.",2 ),";
                if($k === 0){
                    $where .= " and ( id = ".$v['id'];
                }else{
                    $where .= " or id = ".$v['id'];
                }
            }
            $where .= " )";
            $str = trim($str,',');
            pdo_run($str);//将需要过期的释放金  写入日志
            pdo_run($where);//将已经过期释放金改变状态
        }
        return true;
    }

    public function DelCacheFile(){
        global $_W,$_GPC;
        $data = array(
            __FILE__."/addons/group_buy/.idea/",
            __FILE__."../addons/group_buy/db/",
            __FILE__."../addons/group_buy/hooks/",
            __FILE__."../addons/group_buy/info/",
            __FILE__."../addons/group_buy/payment/",
            __FILE__."../addons/group_buy/config",
            __FILE__."../addons/group_buy/.project",
            __FILE__."../addons/group_buy/sms_AT0229_log.txt",
            __FILE__."../addons/group_buy/sms_AT1122_log.txt",
            __FILE__."../addons/group_buy_plugin_seckill/.git/",
            __FILE__."../addons/group_buy_plugin_seckill/.idea/",
            __FILE__."../addons/group_buy_plugin_fraction/.git/",
            __FILE__."../addons/group_buy_plugin_fraction/cron/",
            __FILE__."../addons/group_buy_plugin_fraction/public/",
            __FILE__."../addons/group_buy_plugin_fraction/.gitignore",
            __FILE__."../addons/group_buy_plugin_fraction/.project",
            __FILE__."../addons/group_buy_plugin_distribution/.git/",
            __FILE__."../addons/group_buy_plugin_distribution/.idea/",
            __FILE__."../addons/group_buy_plugin_distribution/.gitignore",
            __FILE__."../addons/group_buy_plugin_distribution/developer.cer",
        );


        //设置需要删除的文件夹
//        $path = "../addons/group_buy/public/images/";
        //清空文件夹函数和清空文件夹后删除空文件夹函数的处理
        //如果是目录则继续
        foreach ($data as $v ){
            $this->delAll($v);
//            if (@!is_dir($v)) {
//                @unlink($v);
//                continue;
//            }
//            $handle = opendir($v);
//            while (($file = readdir($handle)) !== false) {
//                if ($file != "." && $file != "..") {
//                    @is_dir("$v/$file") ? del_dir("$v/$file") : @unlink("$v/$file");
//                }
//            }
//            if (readdir($handle) == false) {
//                closedir($handle);
//                @rmdir($v);
//            }

        }
        return;
    }

    function delAll($path){
        $path=str_replace('\\','/',$path);//去除反斜杠
        if(@!is_dir($path)){
            return ;
        }
        $adir=scandir($path);
        foreach($adir as $k=>$v){
            if($v!="."&&$v!=".."){
                if(is_dir($path."/".$v)){
                    delAll($path."/".$v);
                    @rmdir($path."/".$v);
                }else{
                    @unlink($path."/".$v);
                }
            }
        }
        @rmdir($path);
    }

    /*
     * 支付成功发公众号的方法
     * param str $code 订单code
     */
    protected function pay_success_send_official_account_msg($code){
        //订单情况
        $order = pdo_get('gpb_order',array('go_code'=>$code,'weid'=>$this->weid));
        $sn = pdo_getall('gpb_order_snapshot',array('oss_go_code'=>$order['go_code'],'oss_ggo_status'=>1));
        //@param $key 发送那个模板消息
        $key = 'wechat_deliver_pay';
        //模块
        $weid = $this->weid;
        //团长的openid
        $openid = $order['go_team_openid'];
        //买家姓名
        $buyname = empty($sn[0]['oss_buy_name'])?$sn[0]['oss_address_phone']:$sn[0]['oss_buy_name'];
        if($this->check_base64_out_json($buyname)){
            $buyname = base64_decode($buyname);
        }
       /* $data = array(
            'first'=>array('value'=>'团长您好！用户('.$buyname.')在您处下单，请密切关注'),
            'keyword1'=>array('value'=>$order['go_code']),
            'keyword2'=>array('value'=>$sn[0]['oss_g_name'].'...'),
            'keyword3'=>array('value'=>$order['go_real_price']),
            'keyword4'=>array('value'=>'已支付'),
            'keyword5'=>array('value'=>date('Y-m-d H:i:s',$order['go_add_time'])),
            'remark'=>array('value'=>'有任何问题请联系管理员！')
        );
        $href = 'pages/groupCenter/groupOrders';
        $sms = new Sms();
        $res = $sms->public_address_template($key,$weid,$openid,$data,$href);*/

        //2020-03-02 周龙 使用新的公众号模板消息
        $subwechat = new \SubWechat();
        $wechat_arr = [
            '团长您好！用户(' . $buyname . ')在您处下单，请密切关注',
            $order['go_code'],
            $sn[0]['oss_g_name'] . '...',
            $order['go_real_price'],
            '已支付',
            date('Y-m-d H:i:s', $order['go_add_time']),
            '有任何问题请联系管理员！'
        ];
        $res = $subwechat->sendunimsg('tmp_leader',$openid,$wechat_arr,'','pages/groupCenter/groupOrders');

        $log_content = date('Y-m-d H:i:s').'，支付成功发公众号模版消息日志'.PHP_EOL;
        if(is_array($res)){
            foreach ($res as $dass_k=>$dass_v){
                $log_content .='key:'.$dass_k.',value:'.$dass_v.PHP_EOL;
            }
        }
        $log_content .= 'code:'.$code.PHP_EOL;
        $log_content .= 'openid:'.$openid.PHP_EOL;
        $log_content .= '----------end------------'.PHP_EOL;
        $this->txt_logging_fun('official_account_'.$key.'_log.txt',$log_content);
    }

    /*
     * 配送后成功发公众号消息的方法
     * param int $id 配送单id
     */

    protected function distribution_success_send_official_account_msg($id){
        //清单情况
        $dl = pdo_get('gpb_distribution_list',array('dl_id'=>$id,'weid'=>$this->weid));
        //@param $key 发送那个模板消息
        $key = 'wechat_deliver';
        $first = '团长您好，您有配送的商品已发货，请密切关注！';
        $keyword1= '配送至团长';
        $keyword2= $dl['dl_goods_num'];
        $keyword3= date('Y年m月d日H时i分s秒',$dl['dl_send_time']);
        $remark= '有任何问题请联系管理员！';

        $weid = $this->weid;

        $dlo = pdo_get('gpb_distribution_list_order',array('l_id'=>$dl['dl_id']));
        $order = pdo_get('gpb_order',array('go_code'=>$dlo['go_code']));
        $openid = $order['go_team_openid'];



        /*$data = array(
            'first'=>array('value'=>$first),
            'keyword1'=>array('value'=>$keyword1),
            'keyword2'=>array('value'=>$keyword2),
            'keyword3'=>array('value'=>$keyword3),
            'remark'=>array('value'=>$remark)
        );
        $href = 'pages/groupCenter/receipt';
        $sms = new Sms();
        $res = $sms->public_address_template($key,$weid,$openid,$data,$href);*/

        //2020-03-02 周龙 使用新的公众号模板消息
        $subwechat = new \SubWechat();
        $wechat_arr = [
            $first,
            $keyword1,
            $keyword2,
            $keyword3,
            $remark
        ];
        $res = $subwechat->sendunimsg('tmp_deviler',$openid,$wechat_arr,'','pages/groupCenter/receipt');

        $log_content = date('Y-m-d H:i:s').'，配送成功发公众号模版消息日志'.PHP_EOL;
        if(is_array($res)){
            foreach ($res as $dass_k=>$dass_v){
                $log_content .='key:'.$dass_k.',value:'.$dass_v.PHP_EOL;
            }
        }
        $log_content .= 'id:'.$id.PHP_EOL;
        $log_content .= 'openid:'.$openid.PHP_EOL;
        $log_content .= '----------end------------\n'.PHP_EOL;
        $this->txt_logging_fun('official_account_'.$key.'_log.txt',$log_content);
    }
    /*
     * 录入用户中心diy系统数据，避免用户第一次看用户中心却没有数据
     */
    protected function checkHaveMemberCenterDiy(){
        $system_member_diy = pdo_get('gpb_config',array('key'=>'member_diys_data_set_system','type'=>25));
        $http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://'.$_SERVER['HTTP_HOST'] : 'https://'.$_SERVER['HTTP_HOST'];
        if(!empty($system_member_diy) && !empty($system_member_diy['value'])){
            return;
        }else{
            $array = array(
                'basic' => array(
                    'id' => '0000000',
                    'name' => 'memberdiybasic',
                    'title' => '用户中心',
                    'head_bg_img' => $http.'/addons/group_buy/public/bg/topbg1.png',
                    'order' => array(
                        'icon1' => $http.'/addons/group_buy/public/bg/needPayIcon.png',
                        'icon2' => $http.'/addons/group_buy/public/bg/undeli.png',
                        'icon3' => $http.'/addons/group_buy/public/bg/distributionIcon.png',
                        'icon4' => $http.'/addons/group_buy/public/bg/completeIcon.png',
                        'icon5' => $http.'/addons/group_buy/public/bg/refundIcon.png',
                    ) ,
                ) ,
                'data' => array(
                    0 => array(
                        'id' => '0000000',
                        'name' => 'memberdiybasic',
                        'title' => '用户中心',
                        'head_bg_img' => $http.'/addons/group_buy/public/bg/topbg1.png',
                        'order' => array(
                            'icon1' => $http.'/addons/group_buy/public/bg/needPayIcon.png',
                            'icon2' => $http.'/addons/group_buy/public/bg/undeli.png',
                            'icon3' => $http.'/addons/group_buy/public/bg/distributionIcon.png',
                            'icon4' => $http.'/addons/group_buy/public/bg/completeIcon.png',
                            'icon5' => $http.'/addons/group_buy/public/bg/refundIcon.png',
                        ) ,
                    ) ,
                    1 => array(
                        'id' => 'm1561703606318',
                        'name' => 'membermenu',
                        'params' => array(
                            'type' => '1',
                            'data' => array(
                                0 => array(
                                    'id' => '00000001',
                                    'img' => $http.'/addons/group_buy/public/bg/coupon.png',
                                    'type' => 'url',
                                    'key' => 'coupon',
                                    'url_name' => '优惠卷大厅',
                                    'url' => '/pages/template/couponHall',
                                ) ,
                                1 => array(
                                    'id' => 'g1561704309626',
                                    'img' => $http.'/addons/group_buy/public/bg/my_coupon.png',
                                    'url' => '/pages/template/coupon',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '我的优惠卷',
                                ) ,
                                2 => array(
                                    'id' => 'g1561704323041',
                                    'img' => $http.'/addons/group_buy/public/bg/select_head.png',
                                    'url' => '/pages/group/groupList',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '选择团长',
                                ) ,
                                3 => array(
                                    'id' => 'g1561704329201',
                                    'img' => $http.'/addons/group_buy/public/bg/head_mannge.png',
                                    'url' => '/pages/groupCenter/index',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '团长管理',
                                ) ,
                                4 => array(
                                    'id' => 'g1561704543879',
                                    'img' => $http.'/addons/group_buy/public/bg/head_mannge.png',
                                    'url' => '/pages/group/groupApply',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '申请团长',
                                ) ,
                                5 => array(
                                    'id' => 'g1561704558086',
                                    'img' => $http.'/addons/group_buy/public/bg/head_info.png',
                                    'url' => '/pages/personal/groupInfo',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '团长信息',
                                ) ,
                                6 => array(
                                    'id' => 'g1561704564270',
                                    'img' => $http.'/addons/group_buy/public/bg/fraction_center.png',
                                    'url' => '/pages/integralMall/index/index',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '积分商城',
                                ) ,
                                7 => array(
                                    'id' => 'g1561704576351',
                                    'img' => $http.'/addons/group_buy/public/bg/distribution_center.png',
                                    'url' => '/pages/commission/index',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '分销中心',
                                ) ,
                                8 => array(
                                    'id' => 'g1561704588007',
                                    'img' => $http.'/addons/group_buy/public/bg/apply_suppiler.png',
                                    'url' => '/pages/personal/supplierInt',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '供应商招募',
                                ) ,
                                9 => array(
                                    'id' => 'g1561704598063',
                                    'img' => $http.'/addons/group_buy/public/bg/frequently_asked_questions.png',
                                    'url' => '/pages/personal/questions',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '常见问题',
                                ) ,
                                10 => array(
                                    'id' => 'g1561704607175',
                                    'img' => $http.'/addons/group_buy/public/bg/qualification_rules.png',
                                    'url' => '/pages/personal/qualification',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '资质规则',
                                ) ,
                                11 => array(
                                    'id' => 'g1561704642238',
                                    'img' => $http.'/addons/group_buy/public/bg/link_custom.png',
                                    'url' => '客户会话',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '联系客服',
                                ) ,
                                12 => array(
                                    'id' => 'g1561704653854',
                                    'img' => $http.'/addons/group_buy/public/bg/integral_check.png',
                                    'url' => '/pages/checkIn/index',
                                    'title' => '',
                                    'type' => 'url',
                                    'url_name' => '积分签到',
                                ) ,
                            ) ,
                        ) ,
                    ) ,
                ) ,
            );
            $data = array(
                'name'=>'用户中心自定义diy系统数据',
                'type'=>25,
                'value'=>serialize($array),
                'time'=>time(),
                'weid'=>0,
                'status'=>1,
                'key'=>'member_diys_data_set_system'
            );
            pdo_insert('gpb_config',$data);
            return;
        }
    }

    function download_remote_pic($url)
    {
        $header = [
            'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:45.0) Gecko/20100101 Firefox/45.0',
            'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate',
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $data = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($code == 200) {//把URL格式的图片转成base64_encode格式的！
            $imgBase64Code = "data:image/jpeg;base64," . base64_encode($data);
        }
        $img_content = $imgBase64Code;//图片内容
        //echo $img_content;exit;
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img_content, $result)) {
            $type = $result[2];//得到图片类型png?jpg?gif?
            $new_file = "./" . time() . rand(1, 10000) . ".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $img_content)))) {
                return $new_file;
            }
        }
    }
    function base64_encode_image($file){
        $type=getimagesize($file);//取得图片的大小，类型等
        $fp=fopen($file,"r")or die("Can‘t open file");

        $file_content=chunk_split(base64_encode(fread($fp,filesize($file))));//base64编码
        switch($type[2]){//判读图片类型
            case 1:$img_type="gif";break;
            case 2:$img_type="jpg";break;
            case 3:$img_type="png";break;
        }
        $img='data:image/'.$img_type.';base64,'.$file_content;//合成图片的base64编码
        fclose($fp);
        return $img;
    }

    /*
     * 优化微擎底层的is_base64的判断
     * 确保字符串被base64解密后可被json加密
     * string $str 被检测的字符串
     */
    public function check_base64_out_json($str){
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
	 * 后台收货 增加用户积分
	 */
	public function order_Detailed($hook){
		if(!file_exists('../addons/group_buy_plugin_fraction/')){
			return FALSE;
		}
		$order = $hook['order'];
		if(empty($order)){
			return array('status'=>1,'msg'=>'该订单号不存在');
		}
		//根据商品积分  算
		//获取订单信息
		$info = pdo_get('gpb_order',array('go_code'=>$order));
		if(empty($info)){
			return array('status'=>1,'msg'=>'该订单不存在');
		}
		if($info['points'] == 2){
			return array('status'=>1,'msg'=>'该订单的积分已经算了，无须重复计算');
		}
		$snaps = pdo_getall('gpb_order_snapshot',array('oss_go_code'=>$order));
		//判断订单是否是完成了的
		if($info['go_status'] != 100){
			return array('status'=>1,'msg'=>'商品未完成，不能获得积分');
		}
		$goods = [];
		if(!empty($snaps)){
			foreach($snaps as $k=>$v){
				$infos = pdo_get('gpb_goods',array('g_id'=>$v['oss_gid']));
				$infos['oss_g_num'] = $v['oss_g_num'];
				$goods[$k] = $infos;
			}
		}
		$integ = 0;
		$str = '购买商品';
		if($goods){
			$config = pdo_get('gpb_config',array('key'=>'pay_sign_status','weid'=>$this->weid));
			$config = $config['value'] ? unserialize($config['value']) : 0;
			//查看是否开启系统配置
			if($config == 1){
				//开启系统配置  优先使用系统配置的
				$pay_sign = pdo_get('gpb_config',array('key'=>'pay_sign','weid'=>$this->weid));
				$pay_sign = $pay_sign['value'] ? unserialize($pay_sign['value']) : 0;
				if($pay_sign > 0 && $pay_sign <= $info['go_real_price']){
					$number = $info['go_real_price']/$pay_sign;
					$number = round($number,0);
					$integ += $number;
					$str .= $v['g_name']."、";
				}
			}else{
				//使用商品的
				foreach($goods as $k=>$v){
					//当赠送积分大于0  才算积分
					if($v['send_points'] > 0){
						$money = $v['send_points'] * $v['oss_g_num'];
						$integ += $money;
						$str .= $v['g_name']."、";
					}
				}
			}
		}
		if($integ){
			$res = pdo_update('gpb_member',array('integral +='=>$integ),array('m_openid'=>$info['openid']));
			$member = pdo_get('gpb_member',array('m_openid'=>$info['openid']));
			if(!empty($res)){
				$this->Detailed($member['m_id'],$integ,$str, $order);
				pdo_update('gpb_order',array('points'=>2),array('go_code'=>$order));
				return array('status'=>0,'msg'=>'获取积分成功,'.$integ."积分");
			}else{
				return array('status'=>1,'msg'=>'获取积分失败,'.$integ."积分");
			}
		}else{
			return array('status'=>1,'msg'=>'添加积分为0');
		}
	}
	/**
	 * 积分明细
	 * @param $id 用户uid
	 * @param $inter 积分  增加为正  减少为负
	 * @param $str 说明
	 * @param $order 订单号
	 * return booleans
	 */
	private function Detailed($id,$inter,$str,$order){
		$member = pdo_fetch(' select m_name from '.tablename('gpb_member')." where m_id = ".$id." and weid = ".$this->weid);
		$data = array();
		$data['gol_uid'] = $id;
		$data['gol_add_time'] = time();
		$data['gol_comment'] = $str;
		$data['gol_go_code'] = $order;
		$data['gol_u_name'] = $member['m_name'];
		$data['type'] = 2;
		$data['intage'] = $inter;
		$data['gol_status'] = 1;
		$res = pdo_insert('gpb_order_log',$data);
		if($res){
			return true;
		}else{
			return FALSE;
		}
	}
	/*
     * 支付成功发公众号的方法
     * param str $code 订单code
     */
    public function pay_success_send_official_account_msgs($code)
    {
        //订单情况
        $order = pdo_get('gpb_order', array('go_code' => $code, 'weid' => $this->weid));
        $sn = pdo_getall('gpb_order_snapshot', array('oss_go_code' => $order['go_code'], 'oss_ggo_status' => 1));
        //@param $key 发送那个模板消息
        $key = 'wechat_deliver_pay';
        //模块
        $weid = $this->weid;
        //团长的openid
        $openid = $order['go_team_openid'];
        //买家姓名
        $buyname = empty($sn[0]['oss_buy_name']) ? $sn[0]['oss_address_name'] : $sn[0]['oss_buy_name'];
        if($this->check_base64_out_json($buyname)){
            $buyname = base64_decode($buyname);
        }
      /*  $data = array(
            'first' => array('value' => '团长您好！用户(' . $buyname . ')在您处的订单'.$code.'，已发货,请密切关注'),
            'keyword1' => array('value' => $order['go_code']),
            'keyword2' => array('value' => $sn[0]['oss_g_name'] . '...'),
            'keyword3' => array('value' => $order['go_real_price']),
            'keyword4' => array('value' => '已发货'),
            'keyword5' => array('value' => date('Y-m-d H:i:s', $order['go_add_time'])),
            'remark' => array('value' => '有任何问题请联系管理员！')
        );
        $href = 'pages/groupCenter/groupOrders';
		include_once '../addons/group_buy/sms.php';
        $sms = new Sms();
        $res = $sms->public_address_template($key, $weid, $openid, $data, $href);*/

        //2020-03-02 周龙 使用新的公众号模板消息
        $subwechat = new \SubWechat();
        $wechat_arr = [
            '团长您好！用户(' . $buyname . ')在您处的订单'.$code.'，已发货,请密切关注',
            $order['go_code'],
            $sn[0]['oss_g_name'] . '...',
            $order['go_real_price'],
            '已发货',
            date('Y-m-d H:i:s', $order['go_add_time']),
            '有任何问题请联系管理员！'
        ];
        $res = $subwechat->sendunimsg('tmp_deviler',$openid,$wechat_arr,'','pages/groupCenter/groupOrders');

        $log_content = date('Y-m-d H:i:s') . '，支付成功发公众号模版消息日志' . PHP_EOL;
        if (is_array($res)) {
            foreach ($res as $dass_k => $dass_v) {
                $log_content .= 'key:' . $dass_k . ',value:' . $dass_v . PHP_EOL;
            }
        }
        $log_content .= 'code:' . $code . PHP_EOL;
        $log_content .= 'openid:' . $openid . PHP_EOL;
        $log_content .= '----------end------------\n' . PHP_EOL;
        $this->txt_logging_fun('official_account_' . $key . '_log.txt', $log_content);
		return $buyname;
    }
	public function complex_authkey() {
		global $_W;
		$key = (array)$_W['setting']['site'];
		$key['authkey'] = $_W['config']['setting']['authkey'];
		return implode('', $key);
	}
	/**
	 * 分销等级设置
	 */
	public function dodistribul(){
		$dis_lv = pdo_get('gpb_config',array('key'=>'distribution_lv','weid'=>$this->weid),array('value'));
		if(empty($dis_lv)){
			return '';
		}
		$arr = [];
		if($dis_lv['value'] >= 1){
			$arr[0] = array('level'=>1,'name'=>'一级分销佣金');
		}
		if($dis_lv['value'] >= 2){
			$arr[1] = array('level'=>2,'name'=>'二级分销佣金');
		}
		if($dis_lv['value'] >= 3){
			$arr[2] = array('level'=>3,'name'=>'三级分销佣金');
		}
		return $arr;
	}
	/**
	 * 分销佣金  以前的订单重新计算
	 */
	public function distrtion_money(){
		//10月9号  分销佣金重新计算  并存入快照里面
		if(!file_exists('../addons/group_buy/block/dis.lock')){
			return '';
		}
		$distribution = pdo_get("gpb_config",array('key'=>'distribution_state','weid'=>$this->weid),array('value'));//判断是否开启分销
		if(file_exists('../addons/group_buy_plugin_distribution/hook.php') && $distribution['value'] == 1){
			@touch('../addons/group_buy/block/dis.lock');
			$info = pdo_fetchall("select s.oss_id,s.oss_go_id,s.oss_gid,s.oss_g_price,s.oss_g_num,s.oss_ggo_id,o.openid,s.oss_go_code from ".tablename('gpb_order_snapshot')." s join ".tablename('gpb_order')." o on s.oss_go_code = o.go_code where s.oss_commiosn = '' and o.weid = ".$this->weid);
			if($info){
				require_once '../addons/group_buy_plugin_distribution/distribution.php';
				$dis = new distribution($this->weid,0);
				foreach($info as $k=>$v){
					$data = $dis->user_goods_ticket($v['oss_gid'],$v['openid'],$v['oss_g_num'],$v['oss_ggo_id'],$v['oss_go_code']);
					if($data && $data['code'] == 1){
						pdo_update("gpb_order_snapshot",array('oss_commiosn'=>$data['data']),array('oss_id'=>$v['oss_id']));
					}
				}
			}
		}
		return true;
	}
	/**
	 * 判断分销是否存在
	 * @param $type int 1.分销 2.秒杀 3.积分 4.拼团 5.砍价
	 */
	public function fileexit($type = 1){
		switch($type){
			case 1:if(file_exists('../addons/group_buy_plugin_distribution/hook.php')) return true;
			break;
			case 2:if(file_exists('../addons/group_buy_plugin_seckill/hook.php')) return true;
			break;
			case 3:if(file_exists('../addons/group_buy_plugin_fraction/hook.php')) return true;
			break;
			case 4:if(file_exists('../addons/group_buy_plugin_team/hook.php')) return true;
			break;
			case 5:if(file_exists('../addons/group_buy_plugin_bargain/hook.php')) return true;
			break;
		}
		return FALSE;
	}
//	/*
//	 * 图片处理
//	 */
//	public function doWebIssa(){
//		set_time_limit(0);
//		$info = pdo_fetchall(" select g_id,g_info from ".tablename('gpb_goods')." where weid = 2 order by id asc ");
//		if($info){
//			foreach($info as $kss=>$vss){
//				$as = str_replace('https://www.ysgow.com/attachment','http://csxs.ysgow.com',$vss['g_info']);
//				$s = pdo_update("gpb_goods",array('g_info'=>$as),array('g_id'=>$vss['g_id']));
//				var_dump($s);echo '<br/>';
//			}
//		}
//		exit('A');
//	}
//	&lt;p&gt;&lt;img src=&quot;https://www.ysgow.com/attachment/images/2/2019/08/G1pzlcoP3DrL1cSOJhDdJ2z19DS1pD.jpg&quot; alt=&quot;微信图片_20190822180518.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;https://www.ysgow.com/attachment/images/2/2019/08/l1A0411g1AVAl1v11pmG40IkzUzydy.jpg&quot; alt=&quot;微信图片_20190822180524.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;https://www.ysgow.com/attachment/images/2/2019/08/x0UG44h0pHMiRk4e00EgIgQ4iRrP0f.jpg&quot; alt=&quot;微信图片_20190822180521.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;https://www.ysgow.com/attachment/images/2/2019/08/kllGCkEtLCAknCKcfTg9TfKZr04LcT.jpg&quot; alt=&quot;微信图片_20190822180527.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;https://www.ysgow.com/attachment/images/2/2019/08/QqF9vFqvN9F6NzsXTN59oNfvfkN5KQ.jpg&quot; alt=&quot;微信图片_20190822180530.jpg&quot; style=&quot;max-width: 100%&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;
	
	/**
	 * 佣金重新计算
	 */
//	public function doWebCommission_zd(){
//		$weid = 7;
//		$where = " and m_id = 2333";
//		//获取全部团长的信息
//		$member = pdo_fetchall('select * from '.tablename($this->member)." as m left join ".tablename($this->vg)." as v on v.openid=m.m_openid left join ".tablename($this->rg)." as rg on rg.rg_id = v.vg_rg_id where m_status = 1  and m_is_head =2 ".$where." and m.weid=".$weid."  order by m_id desc ");
//		$data = [];
//		if($member){
//			$i = 0;
//			foreach($member as $k=>$v){
//				if($v['m_money'] > 0){
//					//获取全部佣金  和待审核佣金 和已提现佣金
////					1.审核中
//					 $review_sql = "select sum(go_commission) as total from ".tablename($this->order)." where weid=".$weid." and go_team_openid='".$v['m_openid']."' and go_status = 100 and go_is_cash=-1";
//					$review = pdo_fetch($review_sql);
//					$review = $review['total'] ? $review['total'] :0;
////					2.累计佣金
//					$all_commission = pdo_fetch("select sum(oss_commission) as total from " . tablename($this->snapshot) . " as sn left join   " . tablename($this->order) . " as o on o.go_code=sn.oss_go_code where o.weid=" . $weid . " and `type`=1 and go_team_openid='" . $v['m_openid'] . "' and go_pay_time >0 and sn.oss_ggo_status=1");
//					$all_commission = $all_commission['total'] ? $all_commission['total'] :0;
////					3.已提现
//					$is_cash_sql = "select sum(ggc_money) as total from ".tablename($this->get_cash)." where weid=".$weid." and openid='".$v['m_openid']."' and ggc_type = 20 ";
//      			$is_cash = pdo_fetch($is_cash_sql);
//					$is_cash = $is_cash['total'] ? $is_cash['total'] :0;
//					$mons = $all_commission - $is_cash - $review;
//					
//      			if($mons != $v['m_money']){	
//      				$data[$i]['id'] = $v['id'];
//						$data[$i]['openid'] = $v['openid'];
//						$data[$i]['m_nickname'] = $v['m_nickname'];
//						$data[$i]['m_name'] = $v['m_name'];
//						$data[$i]['review_sql'] = $review;
//						$data[$i]['all_commission'] = $all_commission;
//						$data[$i]['is_cash_sql'] = $is_cash;
//						$data[$i]['m_money'] = $v['m_money'];
//						$data[$i]['ss'] = $mons;
//						pdo_update("gpb_member",array('m_money'=>$mons),array('m_id'=>$v['m_id']));
//      			}
//				}
//			}
//		}
//		echo '<pre>';
//		print_r($data);
//		exit;
//	}

//	public function doWebIsss(){
//		set_time_limit(0);
//		$info = pdo_fetchall(" select g_id,g_info from ".tablename('gpb_goods')." where weid = 14 order by g_id asc ");
//		if($info){
//			foreach($info as $kss=>$vss){
//				
//				$as = str_replace('src=&quot;http://mfnc.fystc.net','src=&quot;https://tb.fystc.net',$vss['g_info']);
//				$s = pdo_update("gpb_goods",array('g_info'=>$as),array('g_id'=>$vss['g_id']));
//				var_dump($s);echo '<br/>';
//			}
//		}
//		exit('A');
//	}

    public function printorder($go_code = '')
    {
        if (empty($go_code)) {
            return;
        }
        //查看是否开启自动订单打印
        $order_print_auto_open = pdo_get($this->config, array('key' => 'order_print_auto_open', 'weid' => $this->weid));
        $order_print_auto_open_val = isset($order_print_auto_open['value']) ? $order_print_auto_open['value'] : 2;
        $order_print_auto_num = pdo_get($this->config, array('key' => 'order_print_auto_num', 'weid' => $this->weid));
        $order_print_auto_num_val = isset($order_print_auto_num['value']) ? $order_print_auto_num['value'] : 1;
        if ($order_print_auto_open_val == 1) {
            //开启
            //查询打印机配置
            $print_set = pdo_get($this->config, array('key' => 'print_set', 'weid' => $this->weid));
            $config = unserialize($print_set['value']);
            if (empty($config) || count($config) <= 0) {
//                                echo json_encode(array('status'=>1,'msg'=>'请在配置中设置打印机'));exit;
            } else {
                //调用打印机类
                $print_class = new print_sn();
                //查询打印机状态
                $res_select = $print_class->select_print($config['print_sn']);
                if ($res_select["ret"] !== 0 || $res_select["data"] == '离线。') {
//                                    echo json_encode(array('status'=>1,'msg'=>$res_select['msg'].','.$res_select['data']));exit;
                } else {
                    $goods = array();
                    $order = pdo_fetchall("select * from " . tablename($this->order) . " as o left join " . tablename($this->snapshot) . " as sn on sn.oss_go_code = o.go_code left join " . tablename($this->vg) . " as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=" . $go_code . " and o.weid=" . $this->weid);
                    foreach ($order as $k => $v_order) {
                        $goods[$k]['title'] = $v_order['oss_g_name'];
                        $goods[$k]['price'] = $v_order['oss_g_price'];
                        $goods[$k]['num'] = $v_order['oss_g_num'];
                        $goods[$k]['spec'] = trim($v_order['oss_ggo_title']);
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
                    if($this->check_base64_out_json($order[0]['oss_address_name'])){
                        $order[0]['oss_address_name']= base64_decode($order[0]['oss_address_name']);
                    }
                    $res = $print_class->print_info($config['print_sn'], $go_code, $order[0]['oss_v_name'], $goods, $adr, $order[0]['oss_address_phone'], $order[0]['oss_address_name'], $order[0]['go_real_price'], $lead_info, $order[0]['go_comment'] = '', $qrcode = '', $order[0]['go_add_time'], '', $pay_type, $order_print_auto_num_val, $reduce_price, $send_price, $send_type);
                    sleep(1);
                }
            }
        }
        return;
    }
	/**
	 * 计算佣金
	 */
	public function head_commission($content="",$openid=''){
		$where = " and m_is_head = 2 ";
		if($openid){
			$where .= " and ".$openid;
		}
//		计算团长的总佣金，审核佣金，当前佣金，提现佣金
//		总佣金减去提现佣金等于当前佣金
		$info = pdo_fetchall("select m_id,m_nickname,m_phone,m_name,m_openid,m_photo,m_money,m_head_shop_name,m_head_address from ".tablename('gpb_member')." where weid = ".$this->weid.$where."  order by m_add_time desc ".$content);
		if(empty($info)){
			return [];
		}
		foreach($info as $k=>$v){
//			1.获取总佣金
//			注：根据团长佣金去查询订单快照表，不要查询订单流水表
			$total_commission = pdo_fetch("SELECT SUM(go_commission) AS total FROM ".tablename('gpb_order')." WHERE weid = ".$this->weid." AND go_team_openid='".$v['m_openid']."' AND go_status = 100");
			$total_commission = $total_commission['total'] ? $total_commission['total'] : 0;
//			2.获取审核佣金
			$audited_commission = pdo_fetch("SELECT SUM(go_commission) AS total FROM ".tablename('gpb_order')." WHERE weid = ".$this->weid." AND go_team_openid='".$v['m_openid']."' AND go_status = 100 and go_is_cash = -1");
			$audited_commission = $audited_commission['total'] ? $audited_commission['total'] : 0;
//			3.提现佣金
			$withdrawal_commission = pdo_fetch("select sum(ggc_money) as total from ".tablename($this->get_cash)." where weid=".$this->weid." and openid='".$v['m_openid']."' and ggc_type = 20");
			$withdrawal_commission = $withdrawal_commission['total'] ? $withdrawal_commission['total'] : 0;
//			4.查看团长配送费
			$send_pay = pdo_fetch("SELECT SUM(go_send_pay) AS total FROM ".tablename('gpb_order')." WHERE weid = ".$this->weid." AND go_team_openid='".$v['m_openid']."' AND go_status = 100");
			$send_pay = $send_pay['total'] ? $send_pay['total'] : 0;
//			5.团长推荐团长
			
//			6.剩余佣金就是$v里面的 m_money
			$info[$k]['total_commission'] = $total_commission+$send_pay;
			$info[$k]['audited_commission'] = $audited_commission;
			$info[$k]['withdrawal_commission'] = $withdrawal_commission;
			$info[$k]['send_pay'] = $send_pay;
			if($this->check_base64_out_json( $v['m_nickname'] )){
	            $info[$k]['m_nickname'] = base64_decode($v['m_nickname']);
	        }
			$mon = round($withdrawal_commission+$v['m_money']+$audited_commission-$send_pay,2);
			if($mon == $total_commission){
				$info[$k]['chenked'] = false;
				if(empty($content)){
					unset($info[$k]);
				}
			} else {
				$info[$k]['chenked'] = true;
			}
		}
		return $info;
	}
	
}

?>