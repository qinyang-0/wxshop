<?php
/**
 * Created by PhpStorm.
 * User: orichi
 * Date: 2019/9/9
 * Time: 16:06
 */
//存取缓存
function setteamcache($name,$value='',$time=3600){
    $name = md5($name);
    if(empty($value)){
        //获取
        if(!file_exists(IA_ROOT."/addons/group_buy_plugin_team/cache/".$name."")){
            return [];
        }
        $txt = file_get_contents(IA_ROOT."/addons/group_buy_plugin_team/cache/".$name."");
//        var_dump($txt);
        $info = unserialize($txt);
//        exit(var_dump($info));
        //是否过期
        if(!empty($info['time']) && intval($info['time'])<time() && $info['time']!=0 ){
            $info = [];
            @unlink(IA_ROOT."/addons/group_buy_plugin_team/cache/".$name."");
        }elseif(!empty($info['time']) && (intval($info['time'])>=time() || $info['time']==0)){
            unset($info['time']);
        }
        return $info;
    }
    //保存
    if(is_array($value)){
        $value['time'] = time()+$time;
        $txt = serialize($value);
    }else{
        $txt = serialize($value);
    }

//    var_dump($txt);
    $file = fopen(IA_ROOT."/addons/group_buy_plugin_team/cache/".$name."","w+");
    fwrite($file,$txt);
    fclose($file);
    if(file_exists(IA_ROOT."/addons/group_buy_plugin_team/cache/".$name."")){
        return true;
    }else{
        return false;
    }
}
//删除缓存
function delteamcache($name){
    $name = md5($name);
    $name = IA_ROOT."/addons/group_buy_plugin_team/cache/".$name."";
    @unlink($name);
    if(file_exists(IA_ROOT."/addons/group_buy_plugin_team/cache/".$name."")){
        return false;
    }else{
        return true;
    }
}
//用户昵称转换
function getusernickname($name){
    if(check_base64_out_json($name)){
        return base64_decode($name);
    }
    return $name;
}
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
function dump($arr){
    echo "<pre/>";
    var_dump($arr);
}
/**
 * 快速排序
 * @param $list array 需要排序的数组
 * @param $name string 排序依照的键值
 * @return array 排序完成后数组
 */
/*function quick_sort($list,$name,$deep=1){
    $len = count($list);
    if($len<=1){
        return $list;
    }
    $first = array_shift($list);
    $left = array();
    $right = array();
    foreach ($list as $k=>$v){
        if($first[$name]>$v[$name]){
            $right[] = $v;
        }else{
            $left[] = $v;
        }
    }
    $left = quick_sort($left,$name,$deep+1);
    $right = quick_sort($right,$name,$deep+1);
    $list = array_merge($left, array($first), $right);
    return $list;
}*/

//退款申请
function wx_cannelorder($appid,$mch_id,$key,$total_fee,$refund_fee,$apiclient_arr=[],$notify_url='',$wxsn='',$osn='',$refund_desc='',$refund_fee_type=''){
    $data = array(
        'appid'=>$appid,
        'mch_id'=>$mch_id,
        'nonce_str'=>rand_str(32,7),
        'total_fee'=>$total_fee,
        'sign_type'=>'MD5',
        'refund_fee'=>$refund_fee,
        'refund_desc'=>!empty($refund_desc)?$refund_desc:'拼团失败退款',
        'out_refund_no'=>rand_str(32,4),
    );
    //优先使用微信单号
    if(!empty($wxsn)){
        $data['transaction_id'] = $wxsn;
    }else{
        $data['out_trade_no'] = $osn;
    }
    if(!empty($notify_url)){
    }
    $data['sign'] = getsign($data,$key);
    $xml = arrtoxml($data);
    $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";
    $res = getcurl($url,$xml,'xml',$apiclient_arr);
    return $res;

}

function getcurl($url,$post_data=array(),$type="json",$apiclient_arr=[]){
    $curl = curl_init($url);
//		exit(print_r($post_data));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);//SSL证书认证
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);//严格认证

    if(!empty($apiclient_arr)){
        curl_setopt($curl,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($curl,CURLOPT_SSLCERT,$apiclient_arr['cert']);
        curl_setopt($curl,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($curl,CURLOPT_SSLKEY,$apiclient_arr['key']);
    }

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
        $result = xmltoarr($responseText);
    }elseif ($type=='text'){
        $result = $responseText;
    }
    return $result;
}
function arrtoxml($arr) {
    $xml = "<xml>";
    foreach ($arr as $key => $val){
        if (is_numeric($val)){
            $xml.="<$key>$val</$key>";
        }
        else
            $xml.="<$key><![CDATA[$val]]></$key>";
    }
    $xml.="</xml>";
    return $xml;
}
function xmltoarr($xml) {
    $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $arr;
}

//生成签名
function getsign($data,$key){
    ksort($data);
    $str = "";
    foreach ($data as $k=>$v){
        $str .= "{$k}={$v}&";
    }
    $str .= "key=".$key;
    $sign = md5($str);
    $sign = strtoupper($sign);
    return $sign;
}
//随机字符函数
function rand_str($num=32,$type=1){
    $type = intval($type);
    $num = intval($num);
    if($type>7){
        $type = 7;
    }elseif($type<1){
        $type = 1;
    }
    if($num<1){
        $num = 1;
    }
    $arr = array();
    $key = array(1,2,4);
    $arr[1] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $arr[2] = "abcdefghijklmnopqrstuvwxyz";
    $arr[4] = "0123456789";
    $chars = '';
    if(!in_array($type, $key)){
        //不为子数集
        //根据type值最优解获取下标
        foreach($key as $k=>$v){
            //判断元素组成个数
            if($type<=6){
                //2个元素
                $numb = $type - $v;
                if(in_array($numb, $key)){
                    //存在值
                    $chars = $arr[$v].$arr[$numb];
                    break;
                }
            }else{
                //三个元素
                foreach($arr as $kk=>$vv){
                    $chars .= $vv;
                }
                break;
            }
        }
    }else{
        $chars = $arr[$type];
    }
//		return $chars;
    $lc = strlen($chars)-1;
    $noce = '';
    for ($i = 0; $i < $num; $i++){
        $noce .= $chars[rand(0, $lc)];
    }
    return $noce;
}

/**
 * 判断商品是否参与了活动
 * @param $id int 商品id
 * @param $type int 当前活动1.秒杀 2.拼团 3.砍价
 * @param $weid int 当前模块uniacid
 * return 成功返回 bool  失败返回  string
 */
function goods_activity2($id=0,$type=1,$weid=1){
    if(empty($id)){
        return '参数错误';
    }
    $time = time();//当前时间
    //最开始的优先权是秒杀 ，其次是拼团，最后是砍价
    if(file_exists('../addons/group_buy_plugin_seckill/hook.php') && $type != 1){
        //文件存在  代表安装了秒杀的
//		秒杀中   不管商品是否显示还是没有显示  只要存在在秒杀里面  就一律视为参与秒杀
        $res = pdo_fetch("select id from ".tablename('gpb_shop_seckill_task_goods')." where uniacid = :uniacid and goodsid = :id ",array(':uniacid'=>$weid,':id'=>$id));
        if($res){
            return '该商品已参加秒杀!';
        }
    }
    //拼团
    if(file_exists('../addons/group_buy_plugin_team/hook.php') && $type != 2){
        //文件存在  代表安装了拼团的
        //判断数据库里面找到这个产品存不存在
        $res = pdo_fetch("select id from ".tablename('gpb_pteam_list')." where gid = :id and weid = :weid and star_time <= :time and end_time >= :time and `state`=1 and `status`=1",array(":id"=>$id,":weid"=>$weid,":time"=>$time));
        if($res){
            return '该商品已参加拼团!';
        }
    }
    //砍价
    if(file_exists('../addons/group_buy_plugin_bargain/hook.php') && $type != 3){
        //判断数据库里面找到这个产品存不存在
        $res = pdo_fetch("select id from ".tablename('gpb_bargaion_goods')." where g_id = :id and weid = :weid and status_time <= :time and end_time >= :time ",array(':id'=>$id,':weid'=>$weid,':time'=>$time));
        if($res){
            return '该商品已参加砍价!';
        }
    }
    return true;
}

function getgoods_class($id){

    $gcid = pdo_fetch("select cate_id from ".tablename("gpb_goods_to_category")." where goods_id={$id}");
    if(empty($gcid)){
        return '';
    }
    $name = pdo_fetch("select gc_name from ".tablename("gpb_goods_cate")." where gc_id={$gcid['cate_id']}");
    return "[".$name['gc_name']."]";
}


function getconfig($name,$weid=''){
    global $_W;
    if(empty($weid)){
        $weid = $_W['uniacid'];
    }
    $info = pdo_fetch("select * from ".tablename("gpb_pteam_config")." where `weid`={$weid} and `status`=1 and `name`='{$name}'");
    if(empty($info)){
        return false;
    }
    if(empty($info['value'])){
        return [];
    }
    $arr = unserialize($info['value']);
    return $arr;
}