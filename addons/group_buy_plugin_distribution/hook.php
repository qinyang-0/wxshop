<?php
/**
 * 微商城公告模块插件定义
 *
 * @author 微擎团队
 * @url
 */

/*ini_set("display_errors", 0);
error_reporting(0);*/
defined('IN_IA') or exit('Access Denied');
if(empty(QRCODEPATH)){
    define('QRCODEPATH','/addons/group_buy/public/images/');
}
include_once '../addons/group_buy_plugin_distribution/distribution.php';
class Group_buy_plugin_distributionModuleHook extends WeModuleHook {
    public $weid;
    private $uid;
    private $dis;
	public function __construct()
    {
        global $_W,$_GPC;
        $this->weid = $_W['uniacid'];
        $this->dis = new distribution($this->weid);
        if(!empty($_GPC['openid'])){
            $user_id = pdo_get("gpb_member",['weid'=>$this->weid,'m_openid'=>$_GPC['openid']]);
            $this->uid = $user_id['m_id'];
        }
    }
//	distribution_site_name_info
	//商品计算佣金(计算单商品的佣金)
	public function hookPageDistribution_goods_commiosn($hook){
		$id = $hook[0]['id'];
		$order = $hook[0]['order_code'];
		if(empty($id) || empty($order)){
			return '';
		}
		$openid = $hook[0]['openid'];
		if(empty($openid)){
			return '';
		}
		$num = $hook[0]['num'];
		if(empty($num)){
			$num = 1;
		}
		$ggo_id = $hook[0]['ggo_id'];
		if(empty($ggo_id)){
			$ggo_id = 0;
		}
		$arr = $this->dis->user_goods_ticket($id,$openid,$num,$ggo_id,$order);
		return $arr;
	}

    //分销首页
    public function hookPageDistribution_index($hook){
        global $_W,$_GPC;
	    $config = $this->dis->getconfig();
	    //是否开启分销
        if($config['distribution_state']!=1){
            $this->apireturn("未开启分销");
        }
        $scene = $_GPC['scene'];
//        if(empty($scene)){
//            $this->apireturn("请传入scene",5);exit();
//        }
        //是否被冻结
        $is_frz = pdo_get("gpb_distribution_money",['uid'=>$this->uid,'weid'=>$this->weid,'status'=>-2,'check_state'=>1]);
        if(!empty($is_frz)){
            $this->apireturn("您的账户已被冻结!",3);
            exit;
        }
        $is_dis = pdo_get("gpb_distribution_money",['uid'=>$this->uid,'weid'=>$this->weid,'status'=>1,'check_state'=>1]);
//        exit(var_dump($is_dis));
        if(!$is_dis || $is_dis['check_state']==-1){
            $this->apireturn("您还未成为分销商!点击确定前往注册",2);
            exit;
        }
        if($is_dis['check_state']==0){
            $this->apireturn("您的申请还在审核中，请稍候",4);
            exit;
        }
        //获取用户信息
        $user = $this->dis->getuserInfo($this->uid,"dm.check_state=1");
        if(!empty($_GPC['debug'])){
            echo "<pre/>";
            var_dump($user);
            pdo_debug();
            die;
        }
//        echo "<pre/>";1024+512+256+128+64+32+16+8+4+2+1
//        exit(var_dump($user));+empty($user['data']['lv3'])?0:count(explode(",",substr($user['data']['lv3'],1,strlen($user['data']['lv3'])))) empty($user['data']['lv1'])?0:count(explode(",",substr($user['data']['lv1'],1,strlen($user['data']['lv1']))))+
        $lv1 = $config['distribution_lv']>=1?(empty($user['data']['lv1'])?0:count(explode(",",substr($user['data']['lv1'],1,strlen($user['data']['lv1']))))):0;
        $lv2 = $config['distribution_lv']>=2?(empty($user['data']['lv2'])?0:count(explode(",",substr($user['data']['lv2'],1,strlen($user['data']['lv2']))))):0;
        $lv3 = $config['distribution_lv']==3?(empty($user['data']['lv3'])?0:count(explode(",",substr($user['data']['lv3'],1,strlen($user['data']['lv3']))))):0;
        if(!empty($user['data']['lv1'])){
            $lv1 = pdo_fetchcolumn('select count(*) from '.tablename('gpb_member').' where m_id in('.trim($user['data']['lv1'],',').') and m_nickname is not null');
        }
        if(!empty($user['data']['lv2'])){
            $lv2 = pdo_fetchcolumn('select count(*) from '.tablename('gpb_member').' where m_id in('.trim($user['data']['lv2'],',').')  and m_nickname is not null');
        }
        if(!empty($user['data']['lv3'])){
            $lv3 = pdo_fetchcolumn('select count(*) from '.tablename('gpb_member').' where m_id in('.trim($user['data']['lv3'],',').')  and m_nickname is not null');
        }
        switch($config['distribution_lv']){
            case '1':
                $chil = $lv1;
                break;
            case '2':
                $chil = $lv1+$lv2;
                break;
            case '3':
                $chil = $lv1+$lv2+$lv3;
                break;
        }

//        $chil = $lv1+$lv2+$lv3;
        $user['data']['chil'] = $chil;
        $user['data']['cash_num'] = pdo_fetchcolumn("select count(*) from ".tablename("gpb_distribution_cash_money")." where `uid`='{$this->uid}' and `weid`='{$this->weid}' and `status`='1'");
        //获取所有提现手续费
        $sx_cost = pdo_fetch("select sum(charge_money) cost from ".tablename("gpb_distribution_cash_money")." where `uid`='{$this->uid}' and `weid`='{$this->weid}' and `status`='1' and `check_state`<>-1");
        $sx_cost = $sx_cost['cost'];
        $total = floatval($sx_cost) + floatval($user['data']['money']) + floatval($user['data']['cash_money']) + floatval($user['data']['used_mondey']);

        $user['data']['money_total'] = round($total,2);
//        exit(var_dump($user));

        //获取用户当前分销推广码和二维码
        if(isset($is_dis['code_num']) && empty($is_dis['code_num'])){
            $code = $this->dis->make_coupon_card();
            pdo_update('gpb_distribution_money',array('code_num'=>$code),array('id'=>$is_dis['id']));
            $user['data']['code_num'] = $code;
        }else{
            $user['data']['code_num'] = $is_dis['code_num'];
        }
        //获取背景图
        $distribution_playbill_img = pdo_get('gpb_config',array('key'=>'distribution_playbill_img','weid'=>$this->weid));
        $user['data']['img'] = isset($distribution_playbill_img['value'])?tomedia($distribution_playbill_img['value']):tomedia('/addons/group_buy/public/bg/distribution_playbill_img.jpg');
        $savePath = QRCODEPATH."distribution-playbill-qr_code-".$is_dis['code_num'].".jpg";
        if(!file_exists($savePath)){
            $tokne = $this->Token();
            $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$_W['account']['access_tokne'];

            $data=array(
                'scene'=>$scene,//.'&at_id='.$a_id,
                'width'=>300,
                'auto_color'=>false,
                'page'=>"pages/template/index",
            );
            $data=json_encode($data);
            $data_img = $this->http_request($url,$data);
            $res = file_put_contents('..'.$savePath,$data_img);
        }

        $user['data']['code_img'] = tomedia($savePath);
		$config = $this->dis->getconfig();
		$user['commission_name'] = $config['distribution_site_name_info'];
        $this->apireturn("获取成功",0,$user);
    }
    //获取用户等级-人数
    public function hookPageDistribution_getlv($hook){
	    global $_W,$_GPC;
	    $group = $this->dis->getlv($this->uid);
//	    echo "<pre/>";
//	    exit(var_dump($group));
        $this->apireturn("获取成功",0,$group);
    }
    //申请分销数据提交
    public function hookPageDistribution_exa($hook){
        global $_W,$_GPC;
        $hook['comment'] = "姓名:{$hook['name']},手机号码:{$hook['phone']}";
//        $hook['code'];
	    $res = $this->dis->setuser($this->uid,$hook['comment'],$hook['code']);
	    $this->apireturn('获取成功',0,$res);
    }
    //获取用户团队
    public function hookPageDistribution_getteam($hook){
        global $_W,$_GPC;
//        exit(var_dump($this->uid));
	    $team = $this->dis->getuserteam($this->uid);
	    $this->apireturn("获取成功",0,$team);
    }
    //获取佣金变动日志
    public function hookPageDistribution_getlog($hook){
	    global $_W,$_GPC;
	    $pageIndex = !empty($_GPC['page'])?$_GPC['page']:1;
	    $type = !empty($_GPC['type'])?$_GPC['type']:-1;
	    $log = $this->dis->getlog($this->uid,$pageIndex,$type);
	    $this->apireturn("获取成功",0,$log);
    }
    //提交提现申请
    public function hookPageDistribution_cash($hook){
	    global $_W,$_GPC;
	    if(intval($hook['type'])>1){
	        $info = [
	            ['name'=>'账号','value'=>$hook['logo']],//账号
                ['name'=>'姓名','value'=>$hook['value']],//名字
            ];
	        if($hook['type']==3){
	            $info[] = !empty($hook['address'])?['name'=>'银行','value'=>$hook['address']]:'';//银行
            }
	        $info = serialize($info);
        }else{
	        $info = '';
        }
	    $res = $this->dis->cash_money($this->uid,$hook['money'],$hook['type'],$info);
        $this->apireturn("获取成功",0,$res);
    }
    //用户推荐绑定
    public function hookPageDistribution_bingcommoned($hook){
	    global $_W,$_GPC;
	    $pid = $hook['pid'];
        $file  = dirname(__FILE__).'/commonedbing.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个

        $f = fopen($file,'w');
        $content = '';
        foreach ($hook as $k=>$v){
            $content .= "{$k}={$v}\n";
        }
        $content .= "openid={$_GPC['openid']},uid={$this->uid}";
        fwrite($f,$content);
        fclose($f);
        $info = $this->dis->commond_set_log($this->uid,$pid);
//		$this->apireturn("获取成功",0,$info);
    }
    //推荐用户消费
    public function hookPageDistribution_commoned($hook){
        global $_W,$_GPC;
        $p_info = pdo_get("gpb_distrution_commond_log",['uid'=>$this->uid,'weid'=>$this->weid]);
		if(empty($p_info)){
			$p_info['pid'] = 0;
		}
        $order = pdo_get("gpb_order",['go_code'=>$hook[0]['go_code'],'go_status'=>100]);

        if(empty($order)){
            $this->apireturn("获取成功",0,['status'=>1,'msg'=>'订单尚未完成']);
        }
        $order_money = $order['go_all_price']-$order['go_fdc_price'];
        $res = $this->dis->commond_set_log($this->uid,$p_info['pid'],1,$order_money);
		pdo_insert("gpb_distribution_money_log",array('info'=>serialize($res)));
        $this->apireturn("获取成功",0,$res);
    }
    //推荐用户消费
    public function hookPageDistribution_commoneds($hook){
        global $_W,$_GPC;
        $p_info = pdo_get("gpb_distrution_commond_log",['uid'=>$this->uid,'weid'=>$this->weid]);
		if(empty($p_info)){
			$p_info['pid'] = 0;
		}
        $order = pdo_get("gpb_order",['go_code'=>$hook[0]['go_code'],'go_status'=>100]);

        if(empty($order)){
            $this->apireturn("获取成功",0,['status'=>1,'msg'=>'订单尚未完成']);
        }
        $order_money = $order['go_all_price']-$order['go_fdc_price'];
        $res = $this->dis->commond_set_log($this->uid,$p_info['pid'],1,$order_money);
		pdo_insert("gpb_distribution_money_log",array('info'=>serialize($res)));
       	return array('code'=>1,'msg'=>'成功');
    }
    //用户推荐人员记录
    public function hookPageDistribution_commoned_log(){
	    global $_W,$_GPC;
	    $pageIndex = !empty($_GPC['page'])?$_GPC['page']:1;
	    $log = $this->dis->getcommon_log($this->uid,$pageIndex);
	    $this->apireturn('获取成功',0,$log);
    }
    //获取用户提现记录
    public function hookPageDistribution_cashlog(){
        global $_W,$_GPC;
        $pageIndex = !empty($_GPC['page'])?$_GPC['page']:1;
        $state = isset($_GPC['state'])?$_GPC['state']:-2;
        $log = $this->dis->self_cashlog($this->uid,$pageIndex,$state);
        $this->apireturn('获取成功',0,$log);
    }
    //用户资金流水
    public function hookPageDistribution_moneylog($hook){
	    global $_W,$_GPC;
	    $page = !empty($_GPC['page'])?$_GPC['page']:1;
	    $state = !empty($_GPC['state'])?$_GPC['state']:1;
	    $log = $this->dis->getuserlog($this->uid,$page,$state);
	    $this->apireturn("获取成功",0,$log);
    }
    //获取提现说明
    public function hookPageDistribution_cashcomment(){
	    global $_W,$_GPC;
	    $comment = $this->dis->getkeyvalue("distribution_cash_comment");
	    $this->apireturn('获取成功',0,$comment);
    }
    //获取分销订单
    public function hookPageDistribution_getorder($hook){
	    global $_W,$_GPC;
	    $state = isset($_GPC['state'])?$_GPC['state']:-2;
	    $page = !empty($_GPC['page'])?$_GPC['page']:1;
	    $order = $this->dis->getchil_order($this->uid,$page,$state);
        $this->apireturn('获取成功',0,$order);
    }
    //分销订单数量
    public function hookPageDistribution_getordercount($hook){
	    global $_GPC,$_W;
	    $count = $this->dis->getchil_order_count($this->uid);
//	    echo "<pre/>";
//	    exit(var_dump($count));
	    $this->apireturn("获取成功",0,$count);
    }
    //分销绑定
    public function hookPageDistribution_bing($hook){
	    global $_W,$_GPC;
	    $pid = !empty($hook['pid'])?$hook['pid']:0;
//	    echo "<pre/>";
//	    exit(var_dump($hook));
        $file  = dirname(__FILE__).'/teambing.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
//        $f = fopen($file,'w');
        if(file_exists($file) && filesize($file) > 100000){
            unlink($file);//这里是直接删除，可以做备份哈
        }
        $content = date('Y-m-d H:i:s',time()).'记录：\n';
        foreach ($hook as $k=>$v){
            $content .= "{$k}={$v}\n";
        }
        $content .= "openid={$_GPC['openid']},uid={$this->uid}\n";
	    $res = $this->dis->bingteam($this->uid,$pid);
	    foreach ($res as $k=>$v){
            $content .= "{$k}={$v}\n";
        }
        $content .= "------------------\n";
        file_put_contents($file,$content.PHP_EOL,FILE_APPEND);
//        fwrite($f,$content);
//        fclose($f);
	    $this->apireturn('获取成功',0,$res);
    }
    //获取配置信息
    public function hookPageDistribution_getconfig($hook){
	    global $_W,$_GPC;
	    if($hook['key']=='all'){
	        $info = $this->dis->getconfig();
        }else{
            $info = $this->dis->getkeyvalue($hook['key']);
        }

	    $this->apireturn("获取成功",0,$info);
    }
    //获取佣金配置
    public function hookPageDistribution_getdis_commission($hook){
	    global $_W,$_GPC;
	    $conf = $this->dis->getdis_commission();
	    $this->apireturn("获取成功",0,$conf);
    }
    //获取用户推荐详情
    public function hookPageDistribution_commoned_info($hook){
	    global $_w,$_GPC;
	    $commoned = $this->dis->getuser_commoned($this->uid);
	    $this->apireturn("获取成功",0,$commoned);
    }
    //获取推荐列表
    public function hookPageDistribution_commoned_list($hook){
	    global $_W,$_GPC;
	    $page = !empty($hook['page'])?$hook['page']:1;
//	    exit(print_r($hook['openid']));
	    $list = $this->dis->getcommon_log($this->uid,$page);
	    foreach ($list['list'] as $k=>$v){
	        $list['list'][$k]['ctime'] = date("Y-m-d H:i:s",$v['ctime']);
        }
	    $this->apireturn("获取成功",0,$list);
    }
    //分佣计算
    public function hookPageDistribution_user_cost($hook){
	    global $_W,$_GPC;
//	    return $hook;
	    $osn = $hook[0]['osn'];
//	    return $this->dis->usercost_goods($osn);
	    return $this->dis->usercost($osn);
    }
    //未审核人数
    public function hookPageDIstribution_check_num($hook){
	    global $_W,$_GPC;
	    $num = $this->dis->get_dis_num(0);
	    return $num;
    }

    /**
     * 获取申请页面数据
     */
    public function hookPageDistribution_putpage(){
        global $_W,$_GPC;
        $data = $this->dis->putpage();
        $data['distribution_put_pic'] = tomedia($data['distribution_put_pic']);
		$config = $this->dis->getconfig();
		$data['commission_name'] = $config['distribution_site_name_info'];
		
        $this->apireturn("获取成功",0,$data);
    }
    /**
     * api数据返回
     */
    private function apireturn($msg='',$code = 1,$data=[]){
        echo json_encode(['errno'=>$code,'message'=>$msg,'data'=>$data]);
        exit;
    }
    /**
     * 获取access_token
     */
    public function Token(){
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
    private function http_request($url,$data = null,$headers=array())
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
}