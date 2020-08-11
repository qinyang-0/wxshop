<?php
//2019-9-7
//砍价
//就想当于某一个用户发起砍价   邀请好友来进行砍价  减少自己购买物品时的支付金额 
header("Content-type:text/html;charset=utf-8");
defined('IN_IA') or exit('Access Denied');
define('__STYLE__','../addons/group_buy/');
include_once '../addons/group_buy/function.php';
require_once '../addons/group_buy_plugin_bargain/function.php';
class Group_buy_plugin_bargainModuleSite extends WeModuleSite {
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
	
	public function __construct(){
		global $_W,$_GPC;
		$this->weid = $_W['uniacid'];
		$title_info = pdo_get($this->menu_list,array('do'=>$_GPC['do'],'pid'=>0));
        if(!empty($title_info)){
            $this->title_list = $title_info['name'].'-'.$_W['current_module']['title'];
        }else{
            $this->title_list  .='-'.$_W['current_module']['title'] ;
        }
		$this->menu_info=$this->menu_list($_W);
	}
	/**
     * 菜单
     */
    public function menu_list($w){
        if ($w['user']['uid'] == 1) {
            //总账号  显示全部菜单
            $info = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = 0 and status =1  order by sort asc");
        } else {
            //不是总账号
//			1.判断是否设置了权限的
            $code = pdo_get($this->menu, array('uid' => $w['uid']));
            if ($code) {
                //设置了权限   按照权限来显示菜单
                $info = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = 0 and status =1  and id in (" . $code['value'] . ") order by sort asc");
            } else {
                //没有设置权限  显示全部菜单   除开权限设置
                $info = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = 0 and status = 1  order by sort asc");
            }
        }
        return $info;
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
}