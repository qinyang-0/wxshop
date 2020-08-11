<?php
defined('IN_IA') or exit('Access Denied');
define("sis", "sister_renovation");
class Group_buy_plugin_fractionModuleSite extends WeModuleSite {
	public $weid;
	public $gpb_goods_cate     = 'gpb_goods_cate';//商品分类表
	public $gpb_goods          = 'gpb_goods';//商品表
	public $gpb_goods_stock    = 'gpb_goods_stock';//商品库存表
	public $gpb_level          = 'gpb_level';//用户等级表
	public $gpb_member         = 'gpb_member';//用户表
	public $gpb_order          = 'gpb_order';//订单表
	public $gpb_config         = 'gpb_config';//配置表
	public $gpb_article        = 'gpb_article';//文章表
	public $gpb_address        = 'gpb_address';//地址表
	public $gpb_order_snapshot = 'gpb_order_snapshot';//订单表
	public $gpb_mail           = 'gpb_mail';//站内信表
	public $gpb_feed_back      = 'gpb_feed_back';//反馈意见
	public $gpb_order_log      = 'gpb_order_log';//日志表
	
    public $ah                 = 'gpb_application_header';//申请团长表
    public $rg                 = 'gpb_region';//地区表
    public $vg                 = 'gpb_village';//小区表
    public $goods_stock_logs   = 'gpb_goods_stock_logs';//商品库存日志
    public $adv                = 'gpb_banner';//banner
    public $coupon             = 'gpb_ticket';//优惠卷
    public $user_coupon        = 'gpb_user_ticket';//用户领取的优惠券
    public $action             = 'gpb_action';//活动表
    public $address            = 'gpb_receiving_address';//收获地址表
    public $ban                = 'gpb_banner';//banner广告
    public $sure_order         = 'gpb_sure_order';//订单核销表
    public $action_village     ='gpb_action_village';//活动小区关系表
    public $action_goods       ='gpb_action_goods';//活动商品关系表
    public $cart               ='gpb_cart';//购物车表
    public $get_cash           ='gpb_get_cash';//提现表
    public $back_money         ='gpb_back_money';//退款表
    public $distribution       ='gpb_distribution_list';//配送表
    public $distribution_route ='gpb_distribution_route';//配送路线表
    public $supplier           ='gpb_supplier';//供应商
    public $spec               ='gpb_goods_spec';//规格表
    public $spec_item          ='gpb_goods_spec_item';//规格下参数表
    public $goods_option       ='gpb_goods_option';//参数规格erp
    public $diy_page           ='gpb_diy_page';//diy页面信息
    public $diy_temp           ='gpb_diy_temp';//diy模版信息
    public $menu               = 'gpb_menu';//菜单权限
    public $menu_list          = 'gpb_menu_list';//菜单权限
    public $plug               = 'gpb_plug';//菜单权限
	
	
	public $pageSize = 10;
	public $menu_info;
	public function __construct(){
		//构造函数
		load()->func('tpl');
		global $_W,$_GPC;
		$this->weid = $_W['uniacid'];
		$this->menu_info=$this->menu_list($_W);
//		echo url('home/welcome/index', array('m'=>'group_buy_plugin_fraction','version_id'=> intval($_GPC['version_id'])));exit;
	}

	public function object_array($array) {  
	    if(is_object($array)) {  
	        $array = (array)$array;  
	     } if(is_array($array)) {  
	         foreach($array as $key=>$value) {  
	             $array[$key] =$this->object_array($value);  
	             }  
	     }  
	     return $array;  
	}
	//ajax返回数据
	public function res($status,$msg,$data=[]){
		$arr = array(
			'code'=>$status,
			'msg'=>$msg,
			'data'=>$data,
		);
		echo json_encode($arr);exit;
	}
	//根据id查找分类
	public function goods_class($id){
		if(empty($id)){
			return '';
		}
		$info = pdo_get($this->gpb_goods_cate,array('gc_id'=>$id));
		return $info['gc_name'];
	}
	//根据会员id查找等级名称
	public function level($id){
		if(empty($id)){
			return '无';
		}
		$info = pdo_get($this->gpb_level,array('id'=>$id));
		return $info['title'];
	}
	//获取配置信息
	public function config($data){
		if(empty($data)){
			return '';
		}
//		echo '<pre>';
//		print_r($data);exit;
		foreach($data as $k=>$v){
			if(!empty($v) && $k != 'images' && $k != 'phones'){
				$info = pdo_get($this->gpb_config,array('key'=>$k,'weid'=>$this->weid));
				if(!empty($info)){
					//修改
					pdo_update($this->gpb_config,array('value'=>serialize($v)),array('id'=>$info['id']));
				}else{
					//新增
					pdo_insert($this->gpb_config,array('value'=>serialize($v),'key'=>$k,'name'=>$k,'weid'=>$this->weid,'time'=>time()));
				}
			}else{
				if($v && $k == 'images'){
					$datas = [];
					foreach($v as $kk=>$vv){
						if($vv){
							$datas[$kk] = ['img'=>$vv,'href'=>$data['phones'][$kk],'sort'=>$data['sort'][$kk]];
						}
					}
					$info = pdo_get($this->gpb_config,array('key'=>'tumb','weid'=>$this->weid));
					if(!empty($info)){
						//修改
						pdo_update($this->gpb_config,array('value'=>serialize($datas)),array('id'=>$info['id']));
					}else{
						//新增
						pdo_insert($this->gpb_config,array('value'=>serialize($datas),'key'=>'tumb','weid'=>$this->weid));
					}
				}
			}
		}
		return true;
	}
	/**
	 * 根据name获取配置信息
	 * @param $name 配置名
	 * return array
	 */
	public function sc($name){
		if(empty($name)){
			return '';
		}
		$info = pdo_get($this->gpb_config,['key'=>$name,'weid'=>$this->weid]);
		return unserialize($info['value']);
	}
	/**
	 * 流加载数据
	 */
	public function flow($data){
		if(empty($data)){
			return '';
		}
		$str = '';
		foreach($data as $k=>$v){
			if($k%2 == 0){
				$str .= '<div class="jfgoods">';
			}
			$str .= '<a href="'.url('goods',array('op'=>'info','id'=>$v['g_id'])).'" class="fl">';
			$str .= '	<div class="jf-img">';
			$str .= '		<img src="'.tomedia($v['g_icon']).'" class="scrollLoading" data-url="'.tomedia($v['g_icon']).'" />';
			$str .= '	</div>';
			$str .= '	<div class="jf-txt">';
			$str .= '		<div class="jf-name">'.$v['g_name'].'</div>';
			$str .= '		<div class="jf-pri">'.$v['g_price'].'积分</div>';
			$str .= '	</div>';
			$str .= '</a>';
			if($k%2 != 0 ){
				$str .= '</div>';
			}else{
				if(count($data) ==  1){
					$str .= '</div>';
				}
			}
		}
		return $str;
	}
	/**
	 * 获取标题
	 */
	 public function title($do){
		if(empty($do)){
			return '';
		}
		switch($do){
			case 'index':
				$name = $this->sc('name');
				return $name;
			break;
			case 'goods':
				return '商品';
			break;
			case 'user':
				return '个人中心';
			break;
			case 'login':
				return '登录';
			break;
			case 'reg':
				return '注册';
			break;
			default:
				return '';
			break;
		}
	 }
	 /**
	 * 商户订单号
	 */
	public function creat_on(){
		$str = "";
		$time = time();
		$str .= date("Ymd",$time);
		$str .= rand(0,9);
		$str .= rand(0,9);
		$str .= rand(0,9);
		$str .= rand(0,9);
		$str .= rand(0,9);
		$str .= rand(0,9);
		$str .= rand(0,9);
		$str .=date("His",$time);
		return $str;
	}
	/**
	 * 站内信发送
	 */
	public function mails($m_id,$str,$openid=''){
		$info = pdo_get($this->gpb_member,array('m_id'=>$m_id));
		if(empty($info)){
			return '';
		}
		$res = pdo_insert($this->gpb_mail,array('openid'=>$openid,'time'=>time(),'content'=>$str,'weid'=>$this->weid,'m_id'=>$m_id));
		if($res){
			return true;
		}else{
			return FALSE;
		}
	}
	/**
	 * 发送消息
	 */
	public function mail_list($phone,$content){
		$str = '';
		if($phone == 0){
			$member = pdo_fetchall("select m_id,m_openid from ".tablename($this->gpb_member)." where weid = ".$this->weid." and m_phone != ''");
			if(!empty($member)){
				foreach($member as $k=>$v){
					$str .= "INSERT INTO ".tablename($this->gpb_mail)."(openid,time,content,weid,m_id) VALUES ('".$v['m_openid']."',".time().",'".$content."',".$this->weid.",".$v['m_id'].");";
				}
			}
		}else{
			$data = explode('@',$phone);
			if(!empty($data)){
				foreach($data as $k=>$v){
					$member = pdo_fetch("select m_id,m_openid from ".tablename($this->gpb_member)." where m_phone = ".$v);
					$str .= "INSERT INTO ".tablename($this->gpb_mail)."(openid,time,content,weid,m_id) VALUES ('".$member['m_openid']."',".time().",'".$content."',".$this->weid.",".$member['m_id'].");";
				}
			}
		}
		pdo_run($str);
		return $str;
	}
	//发送模板消息
	public function msg_template($openid,$type,$m_id){
		header("Content-type:text/html;charset=utf-8");
		//获取anccess_token
		$account_api = WeAccount::create();
		$token = $account_api->getAccessToken();
		if(is_error($token)){
			//刷新access_token，并重新获取
			$account_api->clearAccessToken();
			$token = $account_api->getAccessToken();
		}
		if(is_error($token)){
//			access_token错误
			return FALSE;
		}
		$content = $this->template_class($m_id,$type);
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token;
//		$data = [
//			"touser"=>$openid,
//			"msgtype"=>"text",
//			"text"=>[
//				"content"=>"中文",
//			]
//		];
//		$data = '{"touser":"'.$openid.'","msgtype":"text","text":{"content":"<a href=\"http://www.baidu.com\">请求地址</a>"}}';
		$data = '{"touser":"'.$openid.'","msgtype":"text","text":{"content":"'.$content.'"}}';
		$res = ihttp_request($url,$data);
		return $res;
	}
	//
	/**
	 * 发送模板消息类型
	 * $id int 商品id
	 * $m_id 用户主键id
	 * $type int 发送消息类型
	 */
	public function template_class($m_id,$type,$money = 0,$id=0){
		global $_W,$_GPC;
		//发送模板消息地方有，审核通过，加钱，下单，发货，收货
		$url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		$url .= $_SERVER['HTTP_HOST'];
		$url .= '/app/index.php?i='.$_W['uniacid'].'&c=entry&do=user&m=group_buy_plugin_fraction';
		switch($type){
			case '1':
				//账号审核通过  姓名，电话，审核状态，等级
				$member = pdo_fetch(" select * from ".tablename($this->gpb_member)." m left join ".tablename($this->gpb_level)." l on m.level_id = l.id where m.m_id = ".$m_id);
//				$member = pdo_get($this->gpb_member,array('m_id'=>$m_id));
				$content = "尊敬的".$member['m_name']."先生/女士您好:\n"."你的账号为".$member['m_phone']."已通过审核。\n审核时间:".date('Y-m-d H:i',time())."\n\n";
				$url = '<a href=\"'.$url.'\">点击查看详情</a>';
				$content .= $url;
			break;
			case '2':
				//积分增加 姓名，电话，新增积分，剩余积分，时间
				
			break;
			case '3':
				//下单成功 订单号，商品名称，数量，订单积分，时间，客户电话
				
			break;
			case '4':
				//发货通知 订单号，商品名称，数量，订单积分，发货时间，客户电话，状态
				
			break;
			case '5':
				//收货通知 订单号，商品名称，数量，订单积分，发货时间，客户电话，状态
				
			break;
		}
		return $content;
		
	}
	/**
	 * 判断是否安装  插件
	 */
	public function Plug(){
		$url = '../addons/group_buy_plugin_fraction/';
		if(!file_exists($url)){
			//未安装
			return FALSE;
		}else{
			//已安装
			return true;
		}
	}
	/**
	 * 魔术方法
	 */
//	public function __call($function,$data){
//		global $_W,$_GPC;
//		echo $function;
//		exit;
//		$url = 'home/welcome/'.$_GPC['do'];
//		$url = url($url, array('m' =>'group_buy','version_id' => intval($_GPC['version_id'])));
//		header("Location: ".$url);
//		exit;
//	}
	/*
     * 获取网站标题
     */
    public function getWebTitle(){
        $arr = pdo_get($this->gpb_config,array('weid'=>$this->weid,'key'=>'title_set'));
        if(empty($arr) ){
            pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('页面标题设置','','6',".time().",".$this->weid.",1,'title_set');");
        }
        $arr = pdo_get($this->gpb_config,array('weid'=>$this->weid,'key'=>'title_set'));
        $val = unserialize($arr['value']);
        $title = isset($val['after_web_title'])?$val['after_web_title']:'';
        return $title;
    }
	/**
     * 菜单
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
            $code = pdo_get($this->menu,array('uid'=>$w['uid']));
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
	/**
	 * 记录用户的积分信息
	 * @param openid 用户标识
	 * @param $str 积分说明
	 * @param $inter 积分  获得用正数 ，反之用负数
	 * @param $order 订单号
	 * return
	 */
	public function integral($openid,$str,$inter,$order){
		$member = pdo_get($this->gpb_member,array('m_openid'=>$openid));
		echo '<pre>';
		$uid = $member['m_id'];
		if(empty($uid)){
			return array('status'=>1,'msg'=>'该用户不存在');
		}
		$data = array(
			'gol_uid'=>$uid,
			'gol_add_time'=>time(),
			'gol_comment'=>$str,
			'gol_go_code'=>$order,
			'type'=>2,
			'intage'=>$inter
		);
		$res = pdo_insert($this->gpb_order_log,$data);
		if($res){
			return array('status'=>0,'msg'=>'添加成功');
		}else{
			return array('status'=>1,'msg'=>'添加失败');
		}
	}
	
	
}
?>