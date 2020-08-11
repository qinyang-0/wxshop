<?php
/**
 * 团购分销插件
 *
 * @author 麦芒网络-微擎团队
 * @url www.scmmwl.com
 * Date: 2019/1/19
 * Time: 10:23
 */
defined('IN_IA') or exit('Access Denied');

include_once '../addons/group_buy_plugin_team/teambuy.php';
include_once '../addons/group_buy_plugin_team/function.php';
//include_once '../addons/group_buy/site.php';
ini_set('date.timezone','Asia/Shanghai');
class Group_buy_plugin_teamModuleSite extends WeModuleSite {
    private $team;
    private $config;
    public $weid;
    public $menu_lv1;
    public $menu_lv2;
    public $menu_info;
    public $menu_list     = 'gpb_menu_list';//菜单权限
    public $now_pid;

	/**
	 * 构造
     */
	public function __construct()
    {
        global $_W,$_GPC;
        $this->weid = $_W['uniacid'];
        $this->team = new teambuy($this->weid);
        //主站菜单
        $this->menu_info = $this->menu_list($_W);
        //一级菜单
        $menu = pdo_getall("gpb_pteam_menu",['deep'=>1,'pid'=>0,'status'=>1],"*",'',['sort asc']);
        foreach ($menu as $k=>$v){
            if(!empty($v['op'])){
                $arr = explode(',',$v['op']);
                $temp = array();
                foreach ($arr as $kk=>$vv){
                    $arr2 = explode("=",$vv);
                    $temp[$arr2[0]] = $arr2[1];
                }
                $menu[$k]['op'] = $temp;
            }else{
                $menu[$k]['op'] = array();
            }
        }
//        echo "<pre/>";
//        exit(var_dump($menu));
        $this->menu_lv2 = $this->get_menu_lv2($menu);
        foreach ($this->menu_lv2 as $k=>$v){
            if(!empty($v['chil'])){
                foreach ($v['chil'] as $kk=>$vv){
                    if(!empty($vv['op'])){
                        $arr = explode(',',$vv['op']);
                        $temp = array();
                        foreach ($arr as $ke=>$va){
                            $arr2 = explode("=",$va);
                            $temp[$arr2[0]] = $arr2[1];
                        }
                        $this->menu_lv2[$k]['chil'][$kk]['op'] = $temp;
                    }else{
                        $this->menu_lv2[$k][$kk]['op'] = array();
                    }
                }
            }
        }
        if(!empty($_GET['pid'])){
            $this->now_pid = $_GET['pid'];
        }

        //过期处理
        $time = time();
        //取消所有未支付团
        pdo_run("update ".tablename("gpb_pteam_activity")." set `state`=-1 where  end_time<='{$time}' and `state`=1 and `status`=1");
        //获取所有过期团
        $faillist = pdo_fetchall("select * from ".tablename("gpb_pteam_activity")." where  end_time<='{$time}' and `state`=2 and `status`=1 and end_time<{$time} and `state`=2 and now_num<all_num limit 500");
        if(!empty($_GPC['debug']) && $_GPC['debug']==1){
            echo "<pre/>";
            var_dump($faillist);
        }
        if(!empty($faillist)){
            foreach ($faillist as $k=>$v){
                $url = $_W['siteroot']."/app/index.php?i={$this->weid}&from=wxapp&m=group_buy&a=wxapp&c=entry&do=Team_fail&aid={$v['id']}&lid={$v['pl_id']}";
                $res = getcurl($url);
                if(!empty($_GPC['debug']) && $_GPC['debug']==1){
                    echo "<pre/>";
                    var_dump($res);
                }
            }
        }

    }
    public function doWebIndex(){
        $url = $this->createWebUrl("home");
        header("Location:{$url}");
    }

   /* public function __call($function, $data){
        global $_GPC, $_W;
        //获取数据
        if (empty($data)) {
            $data = $_GPC;
        }
        if(strstr($function,"do")){
            $fun = substr($function, 2,strlen($function));
        }else{
            //解析方法名
            $fun = substr($function, 8,strlen($function));
        }

        if (empty($fun)) {
            $this->result('方法不存在');
        }
        //获取模块名
        $list = explode('_', $fun);
        if (empty($list[0])) {
            $this->result('插件不存在');
        }
        //大写转小写
        $name = $list[0];
        $plugin_module = WeUtility::createModuleHook('group_buy_plugin_team');
//        exit(var_dump($name));
        $arr = call_user_func_array(array($plugin_module, 'hook' . $name), array('params' => $data));
        return $arr;
    }*/

    public function is_wechat()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {
            return false;
        } else {
            return true;
        }
    }

    //获取所有二级分类
    private function get_menu_lv2($menu){
        foreach ($menu as $k=>$v){
            $chil = pdo_getall("gpb_pteam_menu",['deep'=>2,'pid'=>$v['id'],'status'=>1],"*",'',['sort asc']);
            $menu[$k]['chil'] = $chil;
        }
        return $menu;
    }

    /**
     * json数据返回
     */
    public function result($status=0,$msg='',$data=[]){
        echo json_encode(['status'=>$status,'msg'=>$msg,'data'=>$data]);
        exit;
    }
    /**
     * 主站菜单
     */
    public function menu_list($w){
        if($w['user']['uid'] == 1){
            //总账号  显示全部菜单
            $info = pdo_fetchall("select * from ".tablename($this->menu_list)." where pid = 0 and status =1  order by sort asc");
            if(!empty($info)){
                foreach($info as $k=>$v){
                    $data = pdo_fetchall("select * from ".tablename($this->menu_list)." where pid = ".$v['id']." and status =1  order by sort asc");
                    $info[$k]['data'] = $data;
                }
            }
        }else{
            //不是总账号
//			1.判断是否设置了权限的
            $code = pdo_get('gpb_menu',array('uid'=>$w['uid']));
            if($code){
                //设置了权限   按照权限来显示菜单
                $info = pdo_fetchall("select * from ".tablename($this->menu_list)." where pid = 0 and status =1  and id in (".$code['value'].") order by sort asc");
                if(!empty($info)){
                    foreach($info as $k=>$v){
                        $data = pdo_fetchall("select * from ".tablename($this->menu_list)." where pid = ".$v['id']." and status =1  and id in (".$code['value'].") order by sort asc");
                        $info[$k]['data'] = $data;
                    }
                }
            }else{
                //没有设置权限  显示全部菜单   除开权限设置
                $info = pdo_fetchall("select * from ".tablename($this->menu_list)." where pid = 0 and status = 1  order by sort asc");
                if(!empty($info)){
                    foreach($info as $k=>$v){
                        $data = pdo_fetchall("select * from ".tablename($this->menu_list)." where pid = ".$v['id']." and status = 1  order by sort asc");
                        $info[$k]['data'] = $data;
                    }
                }
            }
        }
        return $info;
    }
    /*
     * 获取网站标题
     */
    public function getWebTitle(){
        $arr = pdo_get("gpb_config",array('weid'=>$this->weid,'key'=>'title_set'));
        if(empty($arr) ){
            pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('页面标题设置','','6',".time().",".$this->weid.",1,'title_set');");
        }
        $arr = pdo_get("gpb_config",array('weid'=>$this->weid,'key'=>'title_set'));
        $val = unserialize($arr['value']);
        $title = isset($val['after_web_title'])?$val['after_web_title']:'';
        return $title;
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
    //查询订单并改变状态
    public function change_order_status($gid){
        global $_W;
        $is_pteam = pdo_fetchcolumn("select oss_is_seckill from ".tablename("gpb_order_snapshot")." where oss_go_code='{$gid}' and oss_is_seckill=3");
        if(!$is_pteam || $is_pteam!=3){
            return false;
        }
        $order_status = $this->wx_order_status($gid);
        if($order_status['trade_state']=='SUCCESS' && $order_status['return_code']=='SUCCESS' && $order_status['trade_state_desc'] == '支付成功'){
            //处理拼团订单
            $pteam = pdo_fetch("select * from ".tablename("gpb_pteam_order")." where osn='{$gid}' and `state`>=0 and `state`!=2");
            if(!empty($pteam)) {
                //拼团订单处理
                $pteam_order = pdo_fetch("select * from " . tablename("gpb_pteam_order") . " where osn='{$gid}'");
                pdo_update("gpb_pteam_order", array('state' => 2, 'utime' => time()), array('osn' => $gid));
                //对比支付时间是否过期
                $pay_time = strtotime($order_status['time_end']);
                if ($pay_time > (intval($pteam_order['ctime']) + 600)) {
                    //超时支付 进入退款流程
                    $sql = "select po.*,o.openid,o.go_id,o.go_wx_price from " . tablename("gpb_pteam_order") . " as po join " . tablename("gpb_order") . " as o on po.osn=o.go_code where osn='{$gid}' and po.`state`>=1 and po.state!=5";
                    $tk_order = pdo_fetch($sql);
                    //用户退款
                    $openid = $tk_order['openid'];
                    $sn = !empty($tk_order['pay_sn']) ? $tk_order['pay_sn'] : $tk_order['osn'];
                    $money = doubleval($tk_order['money']);
                    $money = $money * 100;
                    //获取用户信息
                    $member = pdo_get("gpb_member", array('weid' => $this->weid, 'm_openid' => $tk_order['openid']));
                    if ($tk_order['go_wx_price'] > 0) {
                        //获取当前公众号信息
                        $wxapp = pdo_get("account_wxapp", array('uniacid' => $_W['uniacid']));
                        $appid = $wxapp['key'];
                        $secret = $wxapp['secret'];
                        //获取支付信息
                        $payment = pdo_get("uni_settings", array('uniacid' => $_W['uniacid']));
                        $payment = unserialize($payment['payment']);
                        $payment = $payment['wechat'];
                        $mchid = $payment['mchid'];
                        $key = $payment['signkey'];
                        //是否上传统一证书配置
                        if (!empty($payment['wechat_refund']['cert']) && !empty($payment['wechat_refund']['key'])) {
                            $apiclient_arr = array(
                                'cert' => $payment['wechat_refund']['cert'],
                                'key' => $payment['wechat_refund']['key'],
                            );
                        } else {
                            //获取单独配置
                            $cert = pdo_fetch("select value from " . tablename("gpb_config") . " where `weid`='{$_W['uniacid']}' and `key`='cert_address'");
                            $keypem = pdo_fetch("select value from " . tablename("gpb_config") . " where `weid`='{$_W['uniacid']}' and `key`='key_address'");
                            $apiclient_arr = array(
                                'cert' => ".." . $cert['value'],
                                'key' => ".." . $keypem['value'],
                            );
                        }
                        //微信支付退款
                        $res = wx_cannelorder($appid, $mchid, $key, $money, $money, $apiclient_arr, $_W['siteroot'] . "addons/group_buy_plugin_team/return.php", '', $sn);
                        $recharge_log_data = array(
                            'st' => 1,
                            'uid' => $member['m_id'],
                            'openid' => $member['m_openid'],
                            'info' => '拼团订单支付超时' . $tk_order['money'] . '退还至微信',
                            'type' => 3,
                            'status' => 1,
                            'create_time' => time(),
                            'weid' => $this->weid,
                            'money' => $tk_order['money'],
                            'l_type' => 1,
                            'remarks' => '订单号：' . $tk_order['go_code'],
                            'pay_f' => 3
                        );
                        if ($res['return_code'] == 'SUCCESS' && $res['return_msg'] == 'OK') {
                            $res = true;
                        } else {
                            $res = false;
                        }
                        if ($res) {
                            //退款成功更新订单状态
                            //修改订单状态
                            $update = array(
                                'state' => '-2',
                                'utime' => time(),
                            );
                            //日志存入
                            $recharge_log_data_res = pdo_insert('gpb_recharge_log', $recharge_log_data);
                            pdo_update('gpb_pteam_order', $update, array('id' => $tk_order['id']));
                            //修改公共订单
                            $order_update = [
                                'go_status' => '120'
                            ];
                            pdo_update('gpb_order', $order_update, array('go_id' => $tk_order['go_id']));
                            //检查是否未开团用户支付超时
                            $is_lader_order = pdo_fetch("select po.*,pa.state as pastate,pa.star_time,pa.end_time,pa.leader_openid as pa_openid from " . tablename("gpb_pteam_order") . " as po join " . tablename("gpb_pteam_activity") . " as pa on po.aid=pa.id where po.osn='{$gid}' ");
                            if ($is_lader_order['openid'] == $is_lader_order['pa_openid']) {
                                //是团长订单，取消拼团
                                pdo_update("gpb_pteam_activity", array('state' => -1, 'utime' => time()), array('id' => $is_lader_order['id']));
                            }
                        }
                    }
                } else {
                    $pteam_order = $pteam;
                    //查询是否为开团订单
                    $pteam_act = pdo_fetch("select * from " . tablename("gpb_pteam_activity") . " where id={$pteam_order['aid']}");
                    if ($pteam_act['state'] == 1) {
                        //开团订单修改开团状态
                        pdo_update("gpb_pteam_activity", array('state' => 2, 'now_num' => 1), array('id' => $pteam_order['aid']));
                    } elseif ($pteam_act['now_num'] >= $pteam_act['all_num']) {
                        //拼团人满
                        $sql = "select po.*,o.openid,o.go_id,o.go_wx_price from " . tablename("gpb_pteam_order") . " as po join " . tablename("gpb_order") . " as o on po.osn=o.go_code where osn='{$gid}' and po.`state`>=1 and po.state!=5";
                        $tk_order = pdo_fetch($sql);
                        //用户退款
                        $openid = $tk_order['openid'];
                        $sn = !empty($tk_order['pay_sn']) ? $tk_order['pay_sn'] : $tk_order['osn'];
                        $money = doubleval($tk_order['money']);
                        $money = $money * 100;
                        //获取用户信息
                        $member = pdo_get("gpb_member", array('weid' => $this->weid, 'm_openid' => $tk_order['openid']));
                        if ($tk_order['go_wx_price'] > 0) {
                            //获取当前公众号信息
                            $wxapp = pdo_get("account_wxapp", array('uniacid' => $_W['uniacid']));
                            $appid = $wxapp['key'];
                            $secret = $wxapp['secret'];
                            //获取支付信息
                            $payment = pdo_get("uni_settings", array('uniacid' => $_W['uniacid']));
                            $payment = unserialize($payment['payment']);
                            $payment = $payment['wechat'];
                            $mchid = $payment['mchid'];
                            $key = $payment['signkey'];
                            //是否上传统一证书配置
                            if (!empty($payment['wechat_refund']['cert']) && !empty($payment['wechat_refund']['key'])) {
                                $apiclient_arr = array(
                                    'cert' => $payment['wechat_refund']['cert'],
                                    'key' => $payment['wechat_refund']['key'],
                                );
                            } else {
                                //获取单独配置
                                $cert = pdo_fetch("select value from " . tablename("gpb_config") . " where `weid`='{$_W['uniacid']}' and `key`='cert_address'");
                                $keypem = pdo_fetch("select value from " . tablename("gpb_config") . " where `weid`='{$_W['uniacid']}' and `key`='key_address'");
                                $apiclient_arr = array(
                                    'cert' => ".." . $cert['value'],
                                    'key' => ".." . $keypem['value'],
                                );
                            }
                            //微信支付退款
                            $res = wx_cannelorder($appid, $mchid, $key, $money, $money, $apiclient_arr, $_W['siteroot'] . "addons/group_buy_plugin_team/return.php", '', $sn);
                            $recharge_log_data = array(
                                'st' => 1,
                                'uid' => $member['m_id'],
                                'openid' => $member['m_openid'],
                                'info' => '拼团订单支付超时' . $tk_order['money'] . '退还至微信',
                                'type' => 3,
                                'status' => 1,
                                'create_time' => time(),
                                'weid' => $this->weid,
                                'money' => $tk_order['money'],
                                'l_type' => 1,
                                'remarks' => '订单号：' . $tk_order['go_code'],
                                'pay_f' => 3
                            );
                            if ($res['return_code'] == 'SUCCESS' && $res['return_msg'] == 'OK') {
                                $res = true;
                            } else {
                                $res = false;
                            }
                            if ($res) {
                                //退款成功更新订单状态
                                //修改订单状态
                                $update = array(
                                    'state' => '-2',
                                    'utime' => time(),
                                );
                                //日志存入
                                $recharge_log_data_res = pdo_insert('gpb_recharge_log', $recharge_log_data);
                                pdo_update('gpb_pteam_order', $update, array('id' => $tk_order['id']));
                                //修改公共订单
                                $order_update = [
                                    'go_status' => '120'
                                ];
                                pdo_update('gpb_order', $order_update, array('go_id' => $tk_order['go_id']));
                                //检查是否未开团用户支付超时
                                $is_lader_order = pdo_fetch("select po.*,pa.state as pastate,pa.star_time,pa.end_time,pa.leader_openid as pa_openid from " . tablename("gpb_pteam_order") . " as po join " . tablename("gpb_pteam_activity") . " as pa on po.aid=pa.id where po.osn='{$gid}' ");
                                if ($is_lader_order['openid'] == $is_lader_order['pa_openid']) {
                                    //是团长订单，取消拼团
                                    pdo_update("gpb_pteam_activity", array('state' => -1, 'utime' => time()), array('id' => $is_lader_order['id']));
                                }
                            }
                        } else {
                            //余额退款
                            $res = pdo_update("gpb_member", array("m_money_balance +=" => $tk_order['money']), array("m_openid" => $member['m_openid'], 'weid' => $this->weid));

                            $recharge_log_data = array(
                                'st' => 1,
                                'uid' => $member['m_id'],
                                'openid' => $member['m_openid'],
                                'info' => '加入拼团退款' . $tk_order['money'] . '退还至余额',
                                'type' => 3,
                                'status' => 1,
                                'create_time' => time(),
                                'weid' => $this->weid,
                                'money' => $tk_order['money'],
                                'l_type' => 1,
                                'remarks' => '订单号：' . $gid,
                                'pay_f' => 3
                            );
                            $recharge_log_data_res = pdo_insert('gpb_recharge_log', $recharge_log_data);
                            //修改拼团订单
                            pdo_update("gpb_pteam_order", array('state' => -1), array('id' => $pteam_order['id']));
                            //修改公共订单
                            $order_update = [
                                'go_status' => '120'
                            ];
                            pdo_update('gpb_order', $order_update, array('go_id' => $tk_order['go_id']));
                        }

                    } else {
                        //拼团未人满
                        pdo_fetch("update " . tablename("gpb_pteam_activity") . " set now_num=now_num+1 where id='{$pteam_order['aid']}'");
                        //检查是否为团满订单
                        if (intval($pteam_act['all_num']) <= (intval($pteam_act['now_num']) + 1)) {
                            //修改团状态并发送成团通知
                            pdo_update("gpb_pteam_activity", array('state' => 10), array('id' => $pteam_order['aid']));
                            //发送拼团成功通知
                            include_once "../addons/group_buy/sms.php";
                            $activ = $pteam_act;
                            $order_list = pdo_fetchall("select * from " . tablename("gpb_pteam_order") . " where weid={$this->weid} and aid={$activ['id']} and `state`=2");
                            $gid = pdo_fetchcolumn("select gid from " . tablename("gpb_pteam_list") . " where id={$activ['pl_id']}");

                            //自动打印订单
                            $order_print_auto_open= pdo_get("gpb_config",array('key'=>'order_print_auto_open','weid'=>$this->weid));
                            $order_print_auto_open_val = isset($order_print_auto_open['value'])?$order_print_auto_open['value']:2;
                            $order_print_auto_num= pdo_get("gpb_config",array('key'=>'order_print_auto_num','weid'=>$this->weid));
                            $order_print_auto_num_val = isset($order_print_auto_num['value'])?$order_print_auto_num['value']:1;
                            foreach ($order_list as $k => $v) {
                                $msg = [
                                    '1' => $v['osn'],
                                    '2' => pdo_fetchcolumn("select g_name from " . tablename("gpb_goods") . " where g_id={$gid} and weid={$this->weid}"),
                                    '3' => pdo_fetchcolumn("select m_nickname from " . tablename("gpb_member") . " where m_openid='{$activ['leader_openid']}' and `weid`={$this->weid}"),
                                    '4' => "{$v['money']}元",
                                    '5' => $activ['all_num']
                                ];
                                $v['openid'] = pdo_fetchcolumn("select openid from " . tablename("gpb_order") . " where go_code='{$v['osn']}'");
                                //发送成团通知
                                $sms = new \sms();
                                $this->Token();
                                $msg_return = $sms->send_out('AT0051', $msg, $_W['account']['access_tokne'], $v['openid'], '', $v['suc_form'], $this->weid, 'AT0051');

                                if($order_print_auto_open_val ==1 ){
                                    $this->printorder($v['']);

                                }
                            }
                        }

                    }
                }
            }
        }
    }
    //打印订单
    private function printorder($go_code = '')
    {
        if (empty($go_code)) {
            return;
        }
        //查看是否开启自动订单打印
        $order_print_auto_open = pdo_get("gpb_config", array('key' => 'order_print_auto_open', 'weid' => $this->weid));
        $order_print_auto_open_val = isset($order_print_auto_open['value']) ? $order_print_auto_open['value'] : 2;
        $order_print_auto_num = pdo_get("gpb_config", array('key' => 'order_print_auto_num', 'weid' => $this->weid));
        $order_print_auto_num_val = isset($order_print_auto_num['value']) ? $order_print_auto_num['value'] : 1;
        if ($order_print_auto_open_val == 1) {
            //开启
            //查询打印机配置
            $print_set = pdo_get("gpb_config", array('key' => 'print_set', 'weid' => $this->weid));
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
                    $order = pdo_fetchall("select * from " . tablename("gpb_order") . " as o left join " . tablename("gpb_order_snapshot") . " as sn on sn.oss_go_code = o.go_code left join " . tablename("gpb_village") . " as vg on vg.vg_id = sn.oss_v_id  where sn.oss_go_code=" . $go_code . " and o.weid=" . $this->weid);
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

    //查询订单
    public function wx_order_status($gid){
        global $_W,$_GPC;
        $data['appid'] = $_W['account']['key'];//appid
        $data['mch_id'] = $_W['account']['setting']['payment']['wechat']['mchid'];//商户号
        $data['nonce_str'] = $this->randomkeys(32);//随机字符串
        $urls = 'https://api.mch.weixin.qq.com/pay/orderquery';
        //foreach($info as $k=>$v){
        $data['out_trade_no'] = $gid; //拿到订单号
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
}