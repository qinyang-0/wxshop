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

include_once '../addons/group_buy_plugin_distribution/distribution.php';
//include_once '../addons/group_buy/site.php';
class Group_buy_plugin_distributionModuleSite extends WeModuleSite {
    private $dis;
    private $config;
    public $menu_lv1;
    public $menu_lv2;
    public $menu_info;
    public $menu_list     = 'gpb_menu_list';//菜单权限
    public $now_pid;
    private $menu = array(
        'config'=>array(1,0,'分销配置',NULL,'config',1,NULL,15,'icon-setting','00000000000','00000000000',1),
        'User'=>array(2,0,'分销中心',NULL,'User',1,NULL,10,'icon-user','00000000000','00000000000',1),
        'config_state'=>array(3,1,'基本设置','分销设置','config_state',2,'config',0,NULL,'00000000000','00000000000',1),
        'config_money'=>array(4,1,'佣金设置','分销设置','config_money',2,'config',0,NULL,'00000000000','00000000000',1),
        'config_exa'=>array(6,1,'审核设置','分销设置','config_exa',2,'config',0,NULL,'00000000000','00000000000',1),
        'config_exa_list'=>array(8,2,'提现审核','分销设置','config_exa_list',2,'User',10,NULL,'00000000000','00000000000',1),
        'UserList'=>array(9,2,'团队列表',NULL,'UserList',2,'User',0,NULL,'00000000000','00000000000',1),
        'exalist'=>array(10,2,'审核列表',NULL,'exalist',2,'User',0,NULL,'00000000000','00000000000',1),
        'config_commoned'=>array(7,1,'推荐奖设置','分销设置','config_commoned',2,'config',0,NULL,'00000000000','00000000000',1),
        'config_cash'=>array(11,1,'提现设置',NULL,'config_cash',2,'config',100,NULL,'00000000000','00000000000',1),
        'config_put'=>array(20,1,'申请页配置','分销设置','config_put',2,'config',0,NULL,'00000000000','00000000000',1)
    );
    private $money_kv = array(
        'id',
        'pid',
        'title',
        'long_title',
        'url',
        'deep',
        'top_do',
        'sort',
        'icon',
        'create_time',
        'update_time',
        'status',
    );
	/**
	 * 构造
     */
	public function __construct()
    {
        global $_W,$_GPC;
        foreach ($this->menu as $k=>$v){
            $info = pdo_fetch("select `url` from ".tablename("gpb_distribution_menu")." where `url`='{$k}' and `status`=1");
            if(empty($info)){
                $data = array();
                foreach ($this->money_kv as $kk=>$vv){
                    $data[$vv] = $v[$kk];
                }
//                echo "<pre/>";
//                exit(var_dump($data));
                pdo_insert("gpb_distribution_menu",$data);
            }
        }
        $this->weid = $_W['uniacid'];
        $this->dis = new distribution($this->weid);
        $this->config = $this->dis->getconfig();
        //主站菜单
        $this->menu_info = $this->menu_list($_W);
        //获取一级菜单
        $menu = pdo_getall("gpb_distribution_menu",['deep'=>1,'pid'=>0,'status'=>1],"*",'',['sort asc']);
        //获取二级菜单
        $this->menu_lv2 = $this->get_menu_lv2($menu);
        if(!empty($_GET['pid'])){
            $this->now_pid = $_GET['pid'];
        }
    }
    //index转链接
    public function doWebIndex(){
	    $url = $this->createWebUrl("UserList");
	    header("Location:{$url}");
    }
    /**
     * 默认首页
     */
    public function doWebHome(){
        $url = $this->createWebUrl("UserList");
        header("Location:{$url}");
        exit;
        $data = [];
        $data['os']             = PHP_OS;
        $data['php_version'] = PHP_VERSION;
        $data['software']       = $_SERVER['SERVER_SOFTWARE'];
        $data['mysql_version'] = pdo_fetchall("select version() as v;")[0]['v'];
//        $data['now_version'] = file_get_contents('../addons/group_buy_plugin_distribution/.version');
        $v = file_get_contents("../addons/group_buy_plugin_distribution/manifest.xml");
//        echo "<pre/>";
        $v = xml2array($v);
        $v = $v['application']['name'].$v['application']['version'];
        $data['now_version'] = $v;
//        exit("111");
//        exit(var_dump($v));
        include $this -> template('home');
    }

    /**
     * 设置首页
     */
    public function doWebConfig(){
        global $_W,$_GPC;
//        exit("222");
        $url = $this->createWebUrl("config_state");
        header("Location:{$url}");
    }
    /**
     * 申请分销商页面设置
     */
    public function doWebConfig_put(){
        global $_W,$_GPC;
        if(!empty($_POST)){
            $info = $this->dis->putpage($_POST);
            if($info['status']==0){

                $this->message_info("修改成功",'','success');
            }else{
                $this->message_info("修改失败",'','error');
            }
            exit;
        }
        $info = $this->dis->putpage();
        include $this->template("web/config/config_put");
    }
    /**
     * 设置保存
     * $post array 提交数据
     */
    public function saveconfig($post = [],$url=''){
        //验证是否在配置中
        $conf_arr = $this->dis->config_arr;
        foreach ($post as $k=>$v){
            if(!in_array($k,$conf_arr)){
//                echo "{$k}<br/>";
                $this->message_info("参数错误");
                exit;
            }
        }
        //开始设置
        foreach ($post as $k=>$v){
            $this->dis->setconfig($k,$v);
        }
        $this->message_info("修改配置成功",$this->createWebUrl($url),'success');
        exit;
    }
    /**
     * 基本设置(分销等级，分销开启关闭等)
     */
    public function doWebConfig_state(){
        global $_W,$_GPC;

        if(!empty($_POST)){
            $this->saveconfig($_POST,"config_state");
            exit();
        }
        $state[$this->dis->config_arr_name['distribution_state']] = $this->config['distribution_state'];
        $site_name[$this->dis->config_arr_name['distribution_site_name']] = $this->config['distribution_site_name'];
        $site_name_info[$this->dis->config_arr_name['distribution_site_name_info']] = $this->config['distribution_site_name_info'];
        $lv[$this->dis->config_arr_name['distribution_lv']] = $this->config['distribution_lv'];
        $distribution_playbill_img[$this->dis->config_arr_name['distribution_playbill_img']] = $this->config['distribution_playbill_img'];
        if(empty($this->config['distribution_playbill_img'])){
           pdo_update('gpb_config',array('value'=>'/addons/group_buy/public/bg/distribution_playbill_img.jpg'),array('key'=>'distribution_playbill_img','weid'=>$this->weid));
            $distribution_playbill_img[$this->dis->config_arr_name['distribution_playbill_img']] = $this->config['distribution_playbill_img'];
        }
        include $this->template("web/config/config_state");
    }
    /**
     * 分佣配置
     */
    public function doWebConfig_money(){
        global $_W,$_GPC;
        if(!empty($_POST)){
            $this->saveconfig($_POST,'config_money');
            exit();
        }
        $config = $this->dis->getconfig();
        include_once $this->template("web/config/sub_commition");
    }
    /**
     * 审核设置
     */
    public function doWebConfig_exa(){
        global $_W,$_GPC;
        if(!empty($_POST)){
            $this->saveconfig($_POST,'config_exa');
            exit();
        }
        $config = $this->dis->getconfig();
        include_once $this->template("web/config/config_exa");
    }
    /**
     * 推荐奖设置
     */
    public function doWebConfig_commoned(){
        global $_W,$_GPC;
        if(!empty($_POST)){
            $this->saveconfig($_POST,'config_commoned');
            exit();
        }
        $config = $this->dis->getconfig();
        $config_commoned_condition_key_value = $this->dis->config_commoned_condition_key_value;
        include_once $this->template("web/config/config_commoned");
    }
    /**
     * 用户列表
     */
    public function doWebUserList(){
        global $_W,$_GPC;
//        if(!empty($_REQUEST['uname']) || !empty($_REQUEST['time'])){
//            echo "<pre/>";
//            var_dump($_REQUEST);
//            exit("999");
//        }
//        if($_GPC['test']==1){
//            $r = $this->dis->make_coupon_card();
//            var_dump($r);exit;
//        }
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $name = tablename("gpb_distribution_money");
        $where = "{$name}.`status`<>'-1'";
        $name2 = tablename("gpb_member");
        if(!empty($_REQUEST['uname'])){
            $where .= " and ( {$name2}.`m_nickname` like '%{$_REQUEST['uname']}%'  or {$name2}.`m_nickname` like '%".base64_encode($_GPC['uname'])."%')";
//            echo $where."<br/>";
        }
        if(!empty($_REQUEST['time']['start']) && !empty($_REQUEST['time']['end'])){
            $star = strtotime($_REQUEST['time']['start']);
            $end = strtotime($_REQUEST['time']['end']);
            $where .= " and ( {$name}.`update_time`>={$star} and {$name}.`update_time`<={$end} )";
//            exit($where);
        }
        $list =$this->dis->getuserlist($pageIndex,$where);
        $user = $list['list'];
//        echo "<pre/>";
//        exit(var_dump($user));
        $total = $list['total'];
        $page = $list['page'];
        if(is_array($user)){
        	foreach($user as $k=>$v){
        		if($this->check_base64_out_json($v['m_nickname'])){
        			$user[$k]['m_nickname']=base64_decode($v['m_nickname']);
        		}
        	}
        }
       
        include_once $this->template("web/team/user_list");
    }
    /**
     * 获取用户信息
     */
    public function doWebGetuserinfo(){
        global $_W,$_GPC;
        if(empty($_POST)){
            exit("999");
        }
        $post = $_POST;
        $user = $this->dis->getAdituserInfo($post['id']);
        $this->result($user['code'],$user['msg'],$user['data']);
    }
    /**
     * 管理员审核操作
     */
    public function doWebUser_exa(){
        global $_W,$_GPC;
        $post = $_POST;
        if(empty($post)){
            $this->result(0,"参数错误");
            exit;
        }
        $uid = $post['uid'];
        $id = $post['id'];
        $state = $post['state'];
        $comment = $post['comment'];
        $res = $this->dis->update_user($uid,$id,$state,$comment);
        echo json_encode($res);
        exit;
    }
    /**
     * 用户流水查看
     */
    public function doWebUser_log(){
        global $_W,$_GPC;
        if(!empty($_POST)){
            exit("999");
        }
        $uid = $_GPC['uid'];
        $nick_name = pdo_get("gpb_member", ['weid'=>$this->weid,'m_id'=>$uid], 'm_nickname');
        $nick_name = $nick_name['m_nickname'];
        if($this->check_base64_out_json($nick_name)){
        	$nick_name = base64_decode($nick_name);
        }
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $list =$this->dis->getlog($uid,$pageIndex);
        $log = $list['list'];
        $total = $list['total'];
        $page = $list['page'];
        include_once $this->template("web/team/user_log");
    }
    /**
     * 用户团队查看
     */
    public function doWebUser_team(){
        global $_W,$_GPC;
        $uid = $_GPC['uid'];
        $nick_name = pdo_get("gpb_member", ['weid'=>$this->weid,'m_id'=>$uid], 'm_nickname');
        $nick_name = $nick_name['m_nickname'];
        if($this->check_base64_out_json($nick_name)){
        	$nick_name = base64_decode($nick_name);
        }
        $list = $this->dis->getuserteam($uid);
        //2020-04-09 周龙 新增获取配置等级 显示相应等级团队处理
        $nowlv = intval($this->config['distribution_lv']);
        if($nowlv===1){
            $list[2] = [];
            $list[3] = [];
        }
        if($nowlv===2){
            $list[3] = [];
        }
//        exit(print_r($list));
        include_once $this->template("web/team/user_team");
    }
    /**
     * 管理员操作用户资金
     *
     */
    public function doWebChange_user_money(){
        global $_W,$_GPC;
        if(empty($_POST)){
            echo json_encode(['status'=>1,'msg'=>'参数错误']);
            exit;
        }
//        echo "<pre/>";
//        exit(var_dump($_POST));
        $uid = $_POST['uid'];
        $type = $_POST['type'];
        $money = $_POST['money'];
        $comment = $_POST['comment'];
        $res = $this->dis->change_user_money($uid,$type,$money,$comment);
        echo json_encode($res);
        exit;
    }
    //用户提现列表
    public function doWebCashlist(){
        global $_W,$_GPC;
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $state = isset($_GPC['state'])?$_GPC['state']:-1;
        $cashlist = $this->dis->get_cash_list($pageIndex,$state);
    }

    //获取所有二级分类
    private function get_menu_lv2($menu){
       foreach ($menu as $k=>$v){
           $chil = pdo_getall("gpb_distribution_menu",['deep'=>2,'pid'=>$v['id'],'status'=>1],"*",'',['sort asc']);
           $menu[$k]['chil'] = $chil;
       }
       return $menu;
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
    /**
     * 提现审核列表
     */
    public function doWebConfig_exa_list(){
        global $_W,$_GPC;
//        $page = !empty($_GPC['pageIndex'])?$_GPC['pageIndex']:1;
        $page = !empty($_GPC['page'])?$_GPC['page']:1;
        $state = !empty($_GPC['state'])?$_GPC['state']:-1;
        $list = $this->dis->get_cash_list($page,$state);
        $page = $list['page'];
        $total = $list['total'];
        $list = $list['list'];
        if(is_array($list)){
        	foreach($list as $k=>$v){
        		if(!empty($v['m_nickname']) && $this->check_base64_out_json($v['m_nickname'])){
        			$list[$k]['m_nickname'] = base64_decode($v['m_nickname']);
        		}
//                $list[$k]['ctime'] = date("Y-m-d H:i:s",$v['create_time']);
                $list[$k]['ctime'] = $v['create_time'];
        	}
        }
		if($_GPC['t']==1){
			var_dump($list);
		}
        include_once $this->template("web/team/exa_list");
    }
    /**
     * 分销商申请审核
     */
    public function doWebExalist(){
        global $_W,$_GPC;
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $list =$this->dis->getcheckuserlist($pageIndex);
//        echo "<pre/>";
//        exit(var_dump($_W['user']));
        $user = $list['list'];
        $total = $list['total'];
        $page = $list['page'];
        if(is_array($user)){
			foreach($user as &$v){
				if(!empty($v['m_nickname']) && $this->check_base64_out_json($v['m_nickname'])){
					$v['m_nickname'] = base64_decode($v['m_nickname']);
				}
			}
		}
        include_once $this->template("web/team/exalist");
    }
    /**
     * 提现审核
     */
    public function doWebCashcheck(){
        global $_W,$_GPC;
        $id = $_GPC['cid'];
        $state = !empty($_GPC['state'])?$_GPC['state']:-1;
        $info = $this->dis->check_cash($id,$_W['user']['uid'],$state,$comment='');
        $this->result(0,'成功',$info);
    }
    /**
     * 提现设置
     */
    public function doWebConfig_cash(){
        global $_W,$_GPC;
        if(!empty($_POST)){
            $this->saveconfig($_POST,"config_cash");
            exit();
        }
        $comment[$this->dis->config_arr_name['distribution_cash_comment']] = $this->config['distribution_cash_comment'];
        $charge[$this->dis->config_arr_name['distribution_cash_charge']] = $this->config['distribution_cash_charge'];
        include $this->template("web/config/config_cash");
    }
    /**
     * 删除用户
     */
    public function doWebDel_user(){
        global $_W,$_GPC;
        if(empty($_GET) || empty($_GET['uid'])){
            $this->message_info("参数错误");
            exit;
        }
        $uid = $_GET['uid'];
        $res = $this->dis->set_user_status($uid);
        if($res['code']==0){
            $this->message_info($res['msg'],$this->createWebUrl('UserList'),'success');
            exit;
        }else{
            $this->message_info($res['msg']);
        }
    }
    /**
     * 冻结用户
     */
    public function doWebFrez_user(){
        global $_W,$_GPC;
        if(empty($_GET) || empty($_GET['uid'])){
            $this->message_info("参数错误");
            exit;
        }
        $uid = $_GET['uid'];
        $res = $this->dis->set_user_status($uid,-2);
        if($res['code']==0){
            $this->message_info($res['msg'],$this->createWebUrl('UserList'),'success');
            exit;
        }else{
            $this->message_info($res['msg']);
        }
    }
    /**
     * 解冻用户
     */
    public function doWebUnfrez_user(){
        global $_W,$_GPC;
        if(empty($_GET) || empty($_GET['uid'])){
            $this->message_info("参数错误");
            exit;
        }
        $uid = $_GET['uid'];
        $res = $this->dis->set_user_status($uid,1);
        if($res['code']==0){
            $this->message_info($res['msg'],$this->createWebUrl('UserList'),'success');
            exit;
        }else{
            $this->message_info($res['msg']);
        }
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
}