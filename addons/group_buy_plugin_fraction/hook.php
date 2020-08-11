<?php

/**
 * 钩子
 */
include_once "../addons/group_buy/wxapp.php";
include_once "../addons/group_buy/sms.php";
include_once "../addons/group_buy/SubMsg.php";
class Group_buy_plugin_fractionModuleHook extends WeModuleHook {
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
    public $action_village     = 'gpb_action_village';//活动小区关系表
    public $action_goods       = 'gpb_action_goods';//活动商品关系表
    public $cart               = 'gpb_cart';//购物车表
    public $get_cash           = 'gpb_get_cash';//提现表
    public $back_money         = 'gpb_back_money';//退款表
    public $distribution       = 'gpb_distribution_list';//配送表
    public $distribution_route = 'gpb_distribution_route';//配送路线表
    public $supplier           = 'gpb_supplier';//供应商
    public $spec               = 'gpb_goods_spec';//规格表
    public $spec_item          = 'gpb_goods_spec_item';//规格下参数表
    public $goods_option       = 'gpb_goods_option';//参数规格erp
    public $diy_page           = 'gpb_diy_page';//diy页面信息
    public $diy_temp           = 'gpb_diy_temp';//diy模版信息
    public $menu               = 'gpb_menu';//菜单权限
    public $menu_list          = 'gpb_menu_list';//菜单权限
    public $plug               = 'gpb_plug';//菜单权限
	public $pageSize           = 10;//每页显示的条数
	public $http;
	public function __construct(){
		global $_W,$_GPC;
		$this->weid = $_W['uniacid'];
		$this->http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
	}
	
	public function hookPageFraction_data($hook) {
		global $_GPC,$_W;
		echo $_SERVER['QUERY_STRING'];exit;
		echo '<pre>';
		print_r($_W);
		exit;
    }
	/**
	 * 积分商城获取首页配置
	 */
	public function hookPageFraction_index($hook){
		global $_W;
		$openid = $hook['openid'];
		$pageIndex = $hook['page'] ? $hook['page'] : 1 ; 
		//获取首页banner图和推荐积分商品
		$banner = $this->sc('tumb');
		if($banner){
			foreach($banner as $k=>$v){
				$banner[$k]['img'] = tomedia($v['img']);
			}
			//排序
//			$banner = 
			array_multisort(array_column($banner,'sort'),SORT_ASC,$banner);
			if($hook['type'] == 1){
				echo '<pre>';
				print_r($banner);
				exit;
			}
		}
		
		//获取首页推荐积分商品
		$pageSize = $this->pageSize;
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$list = pdo_fetchall(" select * from ".tablename($this->gpb_goods)." where weid = ".$this->weid." and g_is_del = 1 and type = 2 and g_is_recommand = 1 and g_is_online = 1 order by g_order asc ".$contion);
		if(!empty($list)){
			foreach($list as $k=>$v){
				$list[$k]['g_icon'] = tomedia($v['g_icon']);
				///获取每个商品的库存
				$stock = pdo_get($this->gpb_goods_stock,array('goods_id'=>$v['g_id']));
				if($stock['num'] > 999){
					$list[$k]['stock'] = '999+';
				}else{
					$list[$k]['stock'] = $stock['num'];
				}
				$list[$k]['sale_num'] = $stock['sale_num'];
				$list[$k]['g_sale_num'] = $v['g_sale_num']+$v['g_real_sale_num'];
			}
		}
		//获取分类
		$cate = pdo_fetchall(" select gc_id,gc_name,gc_icon from ".tablename($this->gpb_goods_cate)." where gc_status = 1 and type = 2 and gc_is_del = 1 and gc_pid = 0 and weid = ".$this->weid." order by gc_order asc");
		if($cate){
			foreach($cate as $k=>$v){
				if($v['gc_icon']){
					$cate[$k]['gc_icon'] = tomedia($v['gc_icon']);
				}
			}
		}
		$member = $this->member($openid);
		//获取是否显示导航配置
		$nav = $this->sc('integral_nav');
		$bj = $this->sc('integral_bj');
		$bj = $bj ? tomedia($bj) : $this->http.$_SERVER['HTTP_HOST']."/addons/group_buy_plugin_fraction/style/img/topbg.png";
		$lm = $this->sc('inter_name');
		$lm = $lm ? $lm : '热门兑换' ;
		$out = tomedia("/addons/group_buy_plugin_fraction/style/img/out_of_stock.png");
		$data = array(
			'banner'=>$banner,
			'list'=>$list,
			'cate'=>$cate,
			'member'=>$member,
			'nav'=>$nav,
			'bj'=>$bj,
			'lm'=>$lm,
			'out'=>$out,
		);
		
		$this->result(0,'',array('status'=>0,'data'=>$data));
	}
	/**
	 * 根据分类id获取商品信息
	 */
	public function hookPageFraction_shop_list($hook){
		$id = $hook['pid'];
		if(empty($id)){
			$this->result(0,'',array('status'=>1,'data'=>'请传入分类id'));
		}
		$pageIndex = $hook['page'] ? $hook['page'] : 1;
		$pageSize = $this->pageSize;
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$list = pdo_fetchall(" select * from ".tablename($this->gpb_goods)." where weid = ".$this->weid." and g_is_del = 1 and type = 2 and g_is_online = 1 and g_cid = ".$id." order by g_order asc ".$contion);
		if(!empty($list)){
			foreach($list as $k=>$v){
				$list[$k]['g_icon'] = tomedia($v['g_icon']);
				//获取每个商品的库存
				$stock = pdo_get($this->gpb_goods_stock,array('goods_id'=>$v['g_id']));
				if($stock['num'] > 999){
					$list[$k]['stock'] = '999+';
				}else{
					$list[$k]['stock'] = $stock['num'];
				}
				$list[$k]['sale_num'] = $stock['sale_num'];
			}
		}
		$this->result(0,'',array('status'=>0,'data'=>$list));
	}
	/**
	 * 商品详情
	 */
	public function hookPageFraction_info($hook){
		$id = $hook['id'];
		if(empty($id)){
			$this->result(0,'',array('status'=>'1','msg'=>'请传入商品id'));
		}
		$info = pdo_get($this->gpb_goods,array('weid'=>$this->weid,'type'=>2,'g_is_online'=>1,'g_id'=>$id));
		if(empty($info)){
			$this->result(0,'',array('status'=>1,'msg'=>'该商品已下架'));
		}
		//解析
		$info['g_icon'] = tomedia($info['g_icon']);
		if($info['g_thumb']){
			$thumb = explode(',',$info['g_thumb']);
			if($thumb){
				foreach($thumb as $k=>$v){
					$thumb[$k] = tomedia($v);
				}
			}
			$info['g_thumb'] = $thumb;
		}
		//获取库存
		$stock = pdo_get($this->gpb_goods_stock,array('goods_id'=>$info['g_id']));
		$info['stock'] = $stock['num'];
		$info['sale_num'] = $stock['sale_num'];
		$info['g_info'] = htmlspecialchars_decode($info['g_info']);
		$this->result(0,'',array('status'=>0,'data'=>$info));
	}
	/**
	 * 积分明细
	 */
	public function hookPageFraction_Inter($hook){
		$openid = $hook['openid'];
		if(empty($openid)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入openid'));
		}
		//获取该openid下面的uid
		$uid = pdo_get($this->gpb_member,array('m_openid'=>$openid));
		$type = $hook['type'] ? $hook['type'] :	1;
		if($type == 1){
			//收入积分
			$where = " and intage > 0 ";
		}else{
			//支出积分
			$where = " and intage <= 0 ";
		}
		$where .= " and `type` = 2";
		$pageIndex = $hook['page'] ? $hook['page'] : 1;
		$pageSize = $this->pageSize;
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$list = pdo_fetchall(" select * from ".tablename($this->gpb_order_log)." where gol_uid = ".$uid['m_id'].$where." order by gol_add_time desc ".$contion);
		if($list){
			foreach($list as $k=>$v){
				$list[$k]['gol_add_time'] = date('Y-m-d H:i',$v['gol_add_time']);
			}
		}
		$this->result(0,'',array('status'=>0,'msg'=>'','data'=>$list));
	}
	/**
	 * 积分订单
	 */
	public function hookPageFraction_order($hook){
		$status = $hook['status'] ? $hook['status'] : 10;
		$openid = $hook['openid'];
		if(empty($openid)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入openid'));
		}
		$this->member_order($openid);
		$pageIndex = $hook['page'] ? $hook['page'] : 1;
		$pageSize = $this->pageSize;
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$sql = " select * from ".tablename($this->gpb_order)." where go_status = ".$status." and openid = '".$openid."' and type = 2 order by go_add_time desc ".$contion;
		$list = pdo_fetchall($sql);
		if($list){
			foreach($list as $k=>$v){
				//获取订单的商品
				$goods = pdo_getall($this->gpb_order_snapshot,array('oss_go_code'=>$v['go_code']));			
				if($goods){
					foreach($goods as $kk=>$vv){
						$goods[$kk]['oss_g_icon'] = tomedia($vv['oss_g_icon']);
					}
				}
				$list[$k]['goods'] = $goods;
				$list[$k]['go_add_time'] = date('Y-m-d H:i',$v['go_add_time']);
			}
		}
		$this->result(0,'',array('status'=>0,'data'=>$list));
	}
	/**
	 * 积分订单详情
	 */
	public function hookPageFraction_order_details($hook){
		$id = $hook['id'];//订单id
		$openid = $hook['openid'];//openid
		if(empty($id)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入订单id'));
		}
		if(empty($openid)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入用户openid'));
		}
		$order = pdo_get($this->gpb_order,array('go_id'=>$id,'openid'=>$openid));//订单信息
		if(empty($order)){
			$this->result(0,'',array('status'=>1,'msg'=>'该订单不存在'));
		}
		//根据团长的openid  获取用户提货的地址
		$vg = pdo_get($this->vg,array('openid'=>$order['go_team_openid']));//小区信息
		$order['vg'] = $vg['vg_address'];
		//获取用户订单快照
		$snpace = pdo_getall($this->gpb_order_snapshot,array('oss_go_id'=>$id,'oss_go_code'=>$order['go_code']));
		if($snpace){
			foreach($snpace as $k=>$v){
				$snpace[$k]['oss_g_icon'] = tomedia($v['oss_g_icon']);
			}
		}
		$order['goods'] = $snpace;
		$order['go_add_time'] = date('Y-m-d H:i',$order['go_add_time']);
		$this->result(0,'',array('status'=>0,'data'=>$order));
	}
	/**
	 * 用户取消订单  将积分返回到用户的头上,如果计算了库存，将修改库存状态
	 */
	public function hookPageFraction_order_info($hook){
		$id = $hook['id'];//订单id
		$openid = $hook['openid'];//openid
		if(empty($id)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入订单id'));
		}
		if(empty($openid)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入openid'));
		}
		$order = pdo_get($this->gpb_order,array('go_id'=>$id,'openid'=>$openid));
		if(empty($order)){
			$this->result(0,'',array('status'=>1,'msg'=>'该订单不存在'));
		}
		//获取订单的详情        （快照表获取信息）
		$snpaec = pdo_get($this->gpb_order_snapshot,array('oss_go_id'=>$order['go_id'],'oss_go_code'=>$order['go_code']));
		//获取商品信息
		$goods = pdo_get($this->gpb_goods,array('g_id'=>$order['go_gid'],'weid'=>$this->weid));
		if($goods['spec_type'] == 10){
			//下单减库存   恢复库存数量  并将积分恢复
			$num = 0-$order['go_num'];
			$this->stock($order['go_gid'], $num);
		}
		// 将积分恢复
		$res = pdo_update($this->gpb_member,array('integral +='=>$order['go_all_price']),array('m_openid'=>$openid));
		//更改订单状态
		$is = pdo_update($this->gpb_order,array('go_status'=>120),array('go_id'=>$id));
		if($res && $is){
			$this->result(0,'',array('status'=>0,'msg'=>'取消成功'));
		}else{
			$this->result(0,'',array('status'=>1,'msg'=>'取消失败'));
		}
	}
	/**
	 * 用户确认取货
	 */
	public function hookPageFraction_pick_up_goods($hook){
		$id = $hook['id'];//订单id
		$openid = $hook['openid'];//openid
		if(empty($id)){
			$this->result(0,'',array('status'=>1,'mag'=>'请传入订单id'));
		}
		if(empty($openid)){
			$this->result(0,'',array('status'=>1,'mag'=>'请传入用户openid'));
		}
		$order= pdo_get($this->gpb_order,array('go_id'=>$id,'openid'=>$openid,'go_status'=>30));
		if(empty($order)){
			$this->result(0,'',array('status'=>1,'mag'=>'该订单不存在'));	
		}
		$res = pdo_update($this->gpb_order,array('go_status'=>100,'time2'=>time()),array('go_id'=>$id));
		$res ? $this->result(0,'',array('status'=>0,'msg'=>'收货成功')) : $this->result(0,'',array('status'=>1,'msg'=>'收货失败')) ; 	
	}
	/**
	 * 用户进入获取积分商品信息和团长信息
	 */
	public function hookPageFraction_shopping_info($hook){
		$data = [];
		$id = $hook['id'];//商品id
		$openid = $hook['openid'];//自己的openid
		if(empty($id)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入商品id'));
		}
		if(empty($openid)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入openid'));
		}
		//获取商品信息
		$info = pdo_get($this->gpb_goods,array('g_id'=>$id,'g_is_online'=>1));
		if(empty($info)){
			$this->result(0,'',array('status'=>1,'msg'=>'商品，已下架'));
		}
		$info['g_icon'] = tomedia($info['g_icon']);//商品封面
		//获取团长信息和自己的信息
		$member = pdo_get($this->gpb_member,array('m_openid'=>$openid));
		if(!empty($member['m_head_openid'])){
			//获取团长的信息
			$arr = pdo_get($this->gpb_member,array('m_openid'=>$member['m_head_openid'],'m_is_head'=>2));
			//获取团长关联的小区
			$village = pdo_get($this->vg,array('openid'=>$member['m_head_openid'],'weid'=>$this->weid));
			$arr['m_head_shop_name'] = $village['vg_name'];
			$arr['m_head_address'] = $village['vg_address'];
			$data['commander'] = $arr;
			$data['is'] = 'true';
		}else{
			//尚未选择团长
			$data['is'] = 'false';
		}
		$data['info'] = $info;
		$data['member'] = $member;
		
		$this->result(0,'',array('status'=>0,'msg'=>'','data'=>$data));
	}
	/**
	 * 用户下单兑换积分商品
	 */
	public function hookPageFraction_shopping($hook){
		$id = $hook['id'];//商品id
		$group_buy = new Group_buyModuleWxapp();
		if(empty($id)){
			$this->result(0,'',array('status'=>1,'msg'=>'请存入商品id'));
		}
		if($hook['num'] <= 0){
			$this->result(0,'',array('status'=>1,'msg'=>'兑换数量不能小于0'));
		}
		$openid = $hook['openid'];
		if(empty($openid)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入openid'));
		}
		$member = pdo_get($this->gpb_member,array('m_openid'=>$openid));
		if(empty($member)){
			$this->result(0,'',array('status'=>1,'msg'=>'传入的openid错误'));
		}
		//判断商品库存是否足够，是否上架
		$goods = pdo_get($this->gpb_goods,array('g_id'=>$id));
		if(empty($goods)){
			$this->result(0,'',array('status'=>1,'msg'=>'商品id错误'));
		}
		//判断该商品是否是积分商品
		if($goods['type'] != 2){
			$this->result(0,'',array('status'=>1,'msg'=>'该商品，不是积分商品'));
		}
		if($goods['g_is_online'] != 1){
			$this->result(0,'',array('status'=>1,'msg'=>'商品暂未上架，不能购买'));
		}
		//判断积分是否足够
		if($member['integral'] < $goods['integral']){
			$this->result(0,'',array('status'=>1,'msg'=>'积分不足，无法兑换'));
		}
		//判断是否兑换过了
		$order = pdo_fetchcolumn(" select count(*) from ".tablename($this->gpb_order)." where go_gid = ".$id." and openid = '".$openid."'");
		if($order >= $goods['limit'] && $goods['limit'] != 0){
			$this->result(0,'',array('status'=>1,'msg'=>'该商品限制兑换'.$goods['limit']."个，你已兑换过了"));
		}
		//查找库存
		$stock = pdo_get($this->gpb_goods_stock,array('goods_id'=>$id));
		if($stock['num'] == 0){
			$this->result(0,'',array('status'=>1,'msg'=>'商品库存不足，不能购买'));
		}
		//判断库存是否减去库存是否小于0
		if($stock['num'] - 1 < 0){
			$this->result(0,'',array('status'=>1,'msg'=>'商品不足，不能购买'));
		}
		if(empty($hook['oss_openid'])){
			$this->result(0,'',array('status'=>1,'msg'=>'请选择团长'));
		}
		//获取团长的信息
		$oss_member = pdo_get($this->gpb_member,array('m_openid'=>$hook['oss_openid']));
		if($oss_member['m_is_head'] != 2){
			$this->result(0,'',array('status'=>1,'msg'=>'该用户不是团长,请重新选择'));
		}
		//找到小区信息
		$village = pdo_get($this->vg,array('openid'=>$hook['oss_openid'],'weid'=>$this->weid));
		if(empty($village)){
			$this->result(0,'',array('status'=>1,'msg'=>'尚未找到团长的小区,无法购买'));
		}
		//开始购买
		$this->begin();//开始事务
		$data = array();
		$order = $group_buy->nextId();//订单号
		$data['go_code'] = $order;//订单号
		$data['go_gid'] = $id;//商品id
		$data['go_status'] = 10;//状态
		$data['openid'] = $openid;//openid
		$data['go_vid'] = $village['vg_id'];//小区id
		$data['go_team_openid'] = $hook['oss_openid'];//团长openid
		$data['go_add_time'] = time();//添加时间
		$data['go_num'] = $hook['num'];//购买数量
		$data['go_all_old_price'] = $goods['g_price'];//人民币售价
		$data['go_all_price'] = $goods['integral'];//积分售价
		$data['go_comment'] = $hook['comment'];//订单备注
		$data['go_send_type'] = 1;//配送方式1门店自取 2 商家配送
		$data['weid'] = $this->weid;
		$data['spec_type'] = $goods['spec_type'];
		$data['type'] = 2;//订单类型
		$res = pdo_insert($this->gpb_order,$data);
		if(empty($res)){
			$this->result(0,'',array('status'=>1,'msg'=>'下单失败，请重试'));
		}
		$uid = pdo_insertid();//才添加数据的主键id
		//添加商品快照
		$data = array();
		$data['oss_go_id'] = $uid;
		$data['oss_go_code'] = $order;//订单号
		$data['oss_gid'] = $id;//商品id
		$data['oss_g_price'] = $goods['g_price'];//人民币售价
		$data['oss_g_old_price'] = $goods['integral'];//积分售价
		$data['oss_g_num'] = $hook['num'];//购买数量
		$data['oss_g_name'] = $goods['g_name'];//商品名称
		$data['oss_g_icon'] = $goods['g_icon'];//商品封面
		$data['oss_v_id'] = $village['vg_id'];//小区id
		$data['oss_v_name'] = $village['vg_name'];//小区地址
		$data['oss_head_openid'] = $hook['oss_openid'];//团长的openid
		$data['oss_head_name'] = $oss_member['m_name'] ? $oss_member['m_name'] :  $oss_member['m_nickname'];//团长名称
		$data['oss_head_phone'] = $oss_member['m_phone'];//团长电话
		$data['oss_buy_openid'] = $openid;//买家openid
		$data['oss_buy_name'] = $member['m_name'] ? $member['m_name'] :  $member['m_nickname'];//买家名称
		$data['oss_buy_phone'] = $member['m_phone'];//买家电话
		$data['oss_address_name'] = $hook['name'];//收货人姓名
		$data['oss_address_phone'] = $hook['phone'];//收货人电话
		$res = pdo_insert($this->gpb_order_snapshot,$data);//增加快照
		//直接扣除用户的积分
		$res = pdo_update($this->gpb_member,array('integral -='=>$goods['integral']),array('m_openid'=>$openid));
		if(!empty($res)){
			//事务提交
			$this->commit();//提交事务
			//记录日志
		}else{
			//事务回滚
			$this->rollback();
			$this->result(0,'',array('status'=>1,'msg'=>'下单失败，请重试'));
		}
		//下一步 开始判断是否需要支付   ，调取支付  进行结算
		if($goods['spec_type'] == 10){
			$this->stock($id, $hook['num']);
		}
		if($goods['g_price'] != 0){
			//查看商品是否需要微信支付  (需要)
//			$pay = $group_buy->pays(0.01,$openid,$order,$uid,'');
			$pay = $group_buy->pays($goods['g_price'],$openid,$order,$uid,'');
			if($pay['status'] == 1){
				//调取支付失败
				$this->result(0,'',array('status'=>1,'msg'=>'调取支付失败','data'=>$pay));
			}else{
				//调取支付成功
				//将支付的payid存入订单中  用于发送模板消息
				pdo_update($this->gpb_order,array('prepay_id'=>$pay['packages']),array('go_id'=>$uid));
				$this->result(0,'',array('status'=>0,'msg'=>'调取支付成功','data'=>$pay));
			}
		}else{
			//不需要  直接修改订单状态
			$res = pdo_update($this->gpb_order,array('go_status'=>20),array('go_id'=>$uid));
			$price = 0-$goods['integral'];
			$str = '兑换积分商品'.$goods['g_name'].",使用".$goods['integral']."积分";
			$this->Detailed($member['m_id'],$price , $str, $order);//记录积分日志
			if($res){
				$this->result(0,'',array('status'=>0,'msg'=>'兑换成功'));
			}
		}
		$this->result(0,'',array('status'=>1,'msg'=>'兑换失败'));
	}
	/**
	 * 支付成功回调接口
	 */
	public function hookPageFraction_shopping_order($hook){
		$id = $hook['id'];
		$openid = $hook['openid'];
		if(!$id){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入订单id'));
		}
		if(empty($openid)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入订单openid'));
		}
		$member = pdo_get($this->gpb_member,array('m_openid'=>$openid));
		$info = pdo_get($this->gpb_order,array('go_id'=>$id));
		//获取商品信息    
		$goods = pdo_fetch(" select g_id,g_name,spec_type from ".tablename($this->gpb_goods)." where g_id = ".$info['go_gid']." and weid = ".$this->weid);
		if(empty($info)){
			$this->result(0,'',array('status'=>1,'msg'=>'该订单不存在'));
		}
		$group_buy = new Group_buyModuleWxapp();
		$bool = $this->wxorder($info['go_code']);
		if($bool){
			//成功  修改订单状态   将go_status改为20
			$res = pdo_update($this->gpb_order,array('go_status'=>20,'go_pay_time'=>time()),array('go_id'=>$id));
			if($res){
				//获取订单快照表的信息
				$snap = pdo_get($this->gpb_order_snapshot,array('oss_go_id'=>$id));
				//发送模板消息
				$sms = new Sms();
				$group_buy->Token();
				$data = array(
					'1'=>$snap['oss_address_name'],
					'2'=>$snap['oss_address_phone'],
					'3'=>$snap['oss_g_name'],
					'4'=>date('Y-m-d H:i',$info['go_add_time']),
					'5'=>$info['go_all_old_price']."元 + ".$info['go_all_price']."积分",
					'6'=>$member['integral'],
					'7'=>$info['go_num'],
					'8'=>$info['go_buy_msg'],
				);
				
				$dass = $sms->send_out('inter_success',$data,$_W['account']['access_tokne'],$openid,'pages/order-details/order-details?id='.$info['go_id'],$info['prepay_id'],$sms->weid,'AT0229');

                //新增订阅消息 周龙 2020-02-27
                $submsg = new \SubMsg();
                $sub_arr = [
                    mb_substr($info['go_code'],0,20),
                    '￥'.$info['go_real_price'],
                    '支付成功',
                    date('Y-m-d H:i',time()),
                    $info['go_all_old_price']."元 + ".$info['go_all_price']."积分"
                ];
                $submsg->sendmsg("pay_suc",$info['openid'],$sub_arr,'pages/order-details/order-details?id='.$info['go_id']);

				$data = $sms->config('sms_template');
				
				$price = 0-$info['go_all_price'];
				$str = '兑换积分商品'.$snap['oss_g_name'].",使用".$info['go_all_price']."积分";
				$this->Detailed($member['m_id'],$price , $str, $info['go_code']);//记录积分日志
				if($goods['spec_type'] == 20){
					$this->stock($goods['g_id'], $info['go_num']);
				}
				$this->result(0,'',array('status'=>0,'msg'=>'兑换成功'));
			}else{
				$this->result(0,'',array('status'=>1,'msg'=>'修改订单状态失败!'));
			}
		}else{
			//失败
			$this->result(0,'',array('status'=>1,'msg'=>'订单支付错误'));
		}
	}
	/**
	 * 积分说明
	 */
	public function hookPageFraction_explain($hook){
		$explain = $this->sc('pay_explain');
		$this->result(0,'',array('status'=>0,'data'=>$explain));
	}
	/**
	 * 在订单中心调取支付
	 */
	public function hookPageFraction_order_pay($hook){
		$id = $hook['id'];
		$openid = $hook['openid'];
		if(empty($id)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入订单id'));
		}
		if(empty($openid)){
			$this->result(0,'',array('status'=>1,'msg'=>'请传入用户openid'));
		}
		$order = pdo_get($this->gpb_order,array('go_id'=>$id));
		if(empty($order)){
			$this->result(0,'',array('status'=>1,'msg'=>'该订单不存在'));
		}
		$group_buy = new Group_buyModuleWxapp();
		$order_code = $group_buy->nextId();//订单号
		pdo_update($this->gpb_order,array('go_code'=>$order_code),array('go_id'=>$id));
		pdo_update($this->gpb_order_snapshot,array('oss_go_code'=>$order_code),array('oss_go_id'=>$id));
		$pay = $group_buy->pays(0.01,$openid,$order_code,$id,'');
//		$pay = $group_buy->pays($goods['g_price'],$openid,$order,$uid,'');
		if($pay['status'] == 1){
			//调取支付失败
			$this->result(0,'',array('status'=>1,'msg'=>'调取支付失败','data'=>$pay));
		}else{
			//调取支付成功
			//将支付的payid存入订单中  用于发送模板消息
			pdo_update($this->gpb_order,array('prepay_id'=>$pay['packages']),array('go_id'=>$id));
			$this->result(0,'',array('status'=>0,'msg'=>'调取支付成功','data'=>$pay));
		}
	}
	/**
	 * 根据订单号  查询支付状态
	 * @param order 订单号
	 * return bool
	 */
	public function wxorder($order){
		global $_W,$_GPC;
		if(empty($order)){
			return FALSE;
		}
        $group_buy = new Group_buyModuleWxapp();
		$list = $group_buy->wx_order_status($order);
		if($list['trade_state']=='SUCCESS' && $list['return_code']=='SUCCESS'){
			return true;
		}else{
			return FALSE;
		}
	}
	/**
	 * 查询用户订单  查看是否支付
	 */
	public function member_order($openid){
		$list = pdo_fetchall(" select go_id,go_code,go_add_time,go_all_price,spec_type,go_num,go_gid from ".tablename($this->gpb_order)." where openid = '".$openid."' and go_status = 10 limit 0,5");
		$member = pdo_get($this->gpb_member,array('m_openid'=>$openid));
		$config = pdo_get($this->gpb_config,array('key'=>'order_over_cancle','weid'=>$this->weid));
		if(empty($config)){
			$config['value'] = 30;
		}
		if($list){
			foreach($list as $k=>$v){
				$res = $this->wxorder($v['go_code']);//查看订单是否支付成功
				$goods = pdo_get($this->gpb_goods,array('g_id'=>$v['go_gid'],'weid'=>$this->weid));
				if($res){
					//支付成功
					//修改订单状态  发送模板消息
					$res = pdo_update($this->gpb_order,array('go_status'=>20,'go_pay_time'=>time()),array('go_id'=>$v['go_id']));
					if($res){
						//获取订单快照表的信息
						$snap = pdo_get($this->gpb_order_snapshot,array('oss_go_id'=>$v['go_id']));
						//发送模板消息
						$sms = new Sms();
						$group_buy = new Group_buyModuleWxapp();
						$group_buy->Token();
						$data = array(
							'1'=>$snap['oss_address_name'],
							'2'=>$snap['oss_address_phone'],
							'3'=>$snap['oss_g_name'],
							'4'=>date('Y-m-d H:i',$goods['go_add_time']),
							'5'=>$goods['go_all_old_price']."元 + ".$goods['go_all_price']."积分",
							'6'=>$member['integral'],
							'7'=>$goods['go_num'],
							'8'=>$goods['go_buy_msg'],
						);
						$dass = $sms->send_out('inter_success',$data,$_W['account']['access_tokne'],$openid,'pages/order-details/order-details?id='.$goods['go_id'],$goods['prepay_id'],$sms->weid,'AT0229');

                        //新增订阅消息 周龙 2020-02-27
                        $submsg = new \SubMsg();
                        $sub_arr = [
                            mb_substr($res['go_code'],0,20),
                            '￥'.$res['go_real_price'],
                            '支付成功',
                            date('Y-m-d H:i',time()),
                            $goods['go_all_old_price']."元 + ".$goods['go_all_price']."积分"
                        ];
                        $submsg->sendmsg("pay_suc",$openid,$sub_arr,'pages/order-details/order-details?id='.$goods['go_id']);

						pdo_insert("sis_config",array('value'=>serialize($dass)));
						$data = $sms->config('sms_template');
						$price = 0-$goods['go_all_price'];
						$str = '兑换积分商品'.$snap['oss_g_name'].",使用".$goods['go_all_price']."积分";
						$this->Detailed($member['m_id'],$price , $str, $goods['go_code']);//记录积分日志
						if($goods['spec_type'] == 20){
							$this->stock($goods['g_id'], $goods['go_num']);
						}
					}
				}else{
					//支付失败  超过一定时间没有支付  关闭订单  返回积分    
					$item = $v['go_add_time'] + (60*$config['value']);
//					echo $item;
//					echo $config['value'];
//					exit;
					if($item < time()){
						//修改订单状态
						if($v['spec_type'] == 10){
							//下单减库存   恢复库存数量  并将积分恢复
							$num = $v['go_num'];
//							$this->stock($v['go_gid'], $num);/
							pdo_update($this->gpb_goods_stock,array('num +='=>$num),array('goods_id'=>$v['go_gid'],'weid'=>$this->weid));
							pdo_update($this->gpb_goods,array('g_real_sale_num -='=>$num),array('g_id'=>$v['go_gid']));
						}
						// 将积分恢复
						$res = pdo_update($this->gpb_member,array('integral +='=>$v['go_all_price']),array('m_openid'=>$openid));
						//更改订单状态
						$is = pdo_update($this->gpb_order,array('go_status'=>110),array('go_id'=>$v['go_id']));
					}
				}
			}
		}
		return '';
	}
	/**
	 * 根据用户openid  返回用户信息
	 */
	public function member($openid){
		if(empty($openid)){
			return '';
		}
		$member = pdo_get($this->gpb_member,array('m_openid'=>$openid));
		if(is_base64($member['m_nickname'])){
            $member['m_nickname'] = base64_decode($member['m_nickname']);
        }
		return $member;
	}
	/**
	 * 魔术方法
	 */
	public function __call($function,$data){
		$this->result(1,'你访问的'.$function."方法不存在,请核实");
	}
	/**
	 * 定义返回数据格式
	 */
	public function result($code,$message='',$data=array()){
		echo json_encode(array('errno'=>$code,'message'=>$message,'data'=>$data));
		exit;
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
	 * 记录用户的积分信息  增加
	 * @param openid 用户标识
	 * @param $str 积分说明
	 * @param $inter 积分  获得用正数 ，反之用负数
	 * @param $order 订单号
	 * return
	 */
	public function hookPageFraction_integral($hook){
		$member = pdo_get($this->gpb_member,array('m_openid'=>$hook['openid']));
		$uid = $member['m_id'];
		if(empty($uid)){
			return array('status'=>1,'msg'=>'该用户不存在');exit();
		}
		$data = array(
			'gol_uid'=>$uid,
			'gol_add_time'=>time(),
			'gol_comment'=>$hook['str'],
			'gol_go_code'=>$hook['order'],
			'type'=>2,
			'intage'=>$hook['inter']
		);
		$res = pdo_insert($this->gpb_order_log,$data);
		if($res){
			return array('status'=>0,'msg'=>'添加成功');
		}else{
			return array('status'=>1,'msg'=>'添加失败');
		}
	}
	/**
	 * 减少库存
	 * @param $id 商品id
	 * @param $num 购买数量
	 */
	public function stock($id,$num){
		$goods = pdo_get($this->gpb_goods,array('g_id'=>$id));
		if(empty($goods)){
			return array('status'=>1,'msg'=>'商品不存在');
		}
//		if($goods['spec_type'] == 10){
//			//下单减库存
//		}else{
//			//付款减库存
//		}
		$res = pdo_update($this->gpb_goods_stock,array('num -='=>$num),array('goods_id'=>$id,'weid'=>$this->weid));
		if($res){
			//增加销售量
			pdo_update($this->gpb_goods,array('g_real_sale_num +='=>$num),array('g_id'=>$id));
			return array('status'=>0,'msg'=>'减少库存成功');
		}else{
			return array('status'=>1,'msg'=>'减少库存失败');
		}
	}
	/**
	 * 根据订单金额算积分
	 * 需要参数 order 订单号
	 */
//	 $this->hookPageFraction_order_Detailed($order);
	public function hookPageFraction_order_Detailed($hook){
		$order = $hook[0]['order'];
//		echo '<pre>';
//		print_r($hook);exit;
		if(empty($order)){
			return array('status'=>1,'msg'=>'该订单号不存在');
		}
		//根据商品积分  算
		//获取订单信息
		$info = pdo_get($this->gpb_order,array('go_code'=>$order));
		if(empty($info)){
			return array('status'=>1,'msg'=>'该订单不存在');
		}
		if($info['points'] == 2){
			return array('status'=>1,'msg'=>'该订单的积分已经算了，无须重复计算');
		}
		$snaps = pdo_getall($this->gpb_order_snapshot,array('oss_go_code'=>$order));
//		$id = $order['go_gid'];
		//获取商品信息
//		$goods = pdo_get($this->gpb_goods,array('g_id'=>$id,'type'=>1));
//		if(empty($goods)){
//			return array('status'=>1,'msg'=>'商品不存在');
//		}
		//判断订单是否是完成了的
		if($info['go_status'] != 100){
			return array('status'=>1,'msg'=>'商品未完成，不能获得积分');
		}
		$goods = [];
		if(!empty($snaps)){
			foreach($snaps as $k=>$v){
				$infos = pdo_get($this->gpb_goods,array('g_id'=>$v['oss_gid']));
				$infos['oss_g_num'] = $v['oss_g_num'];
				$goods[$k] = $infos;
			}
		}
		$integ = 0;
		$str = '购买商品';
		if($goods){
			//查看是否开启系统配置
			if($this->sc('pay_sign_status') == 1){
				//开启系统配置  优先使用系统配置的
				$pay_sign = $this->sc('pay_sign');
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
//		if($goods){
//			foreach($goods as $k=>$v){
//				if($v['send_points'] == -1){
//					//使用系统配置积分
//					$pay_sign_status = $this->sc('pay_sign_status');
//					if($pay_sign_status == 2){
//						//没有开启消费换积分
//						continue;
//					}
//					$pay_sign = $this->sc('pay_sign');
//					if($pay_sign <= 0){
//						continue;
//					}
//					$number = $v['g_price']/$pay_sign;
//					$number = round($number,0);
//					$integ += $number;
//					$str .= $v['g_name']."、";
//				}else if($v['send_points'] == 0){
//					//不给积分
//				}else{
//					$integ += $v['send_points'];
//					$str .= $v['g_name']."、";
//				}
//			}
//		}
		if($integ){
			$res = pdo_update($this->gpb_member,array('integral +='=>$integ),array('m_openid'=>$info['openid']));
			$member = pdo_get($this->gpb_member,array('m_openid'=>$info['openid']));
			if(!empty($res)){
				$this->Detailed($member['m_id'],$integ,$str, $order);
				pdo_update($this->gpb_order,array('points'=>2),array('go_code'=>$order));
				return array('status'=>0,'msg'=>'获取积分成功,'.$integ."积分");
			}else{
				return array('status'=>1,'msg'=>'获取积分失败,'.$integ."积分");
			}
		}else{
			return array('status'=>1,'msg'=>'添加积分为0');
		}
	}
	/**
	 * 分享获得积分
	 */
	public function hookPageFraction_share_integral($hook){
		global $_W;
		$openid = $hook['openid'];
		$weid = $this->weid;
		if(empty($openid)){
			$this->result(1,'请传入openid');
		}
		$member = pdo_fetch("select m_id,m_nickname,m_name from ".tablename('gpb_member')." where m_openid = '".$openid."'");
		//记录 积分订单
		$time = strtotime(date('Y-m-d 00:00:00',time()));
		$config = pdo_get("gpb_config",array('key'=>'pay_sign_status','weid'=>$weid),array('value'));
		$share_sign = pdo_get("gpb_config",array('key'=>'share_sign','weid'=>$weid),array('value'));
		$highest_sign = pdo_get("gpb_config",array('key'=>'highest_sign','weid'=>$weid),array('value'));
		$config['value'] = unserialize($config['value']);
		$share_sign['value'] = unserialize($share_sign['value']);
		$highest_sign['value'] = unserialize($highest_sign['value']);
		
		if($config['value'] != 1){
			$this->result(1,'暂未开启获取积分');
		}
		if($share_sign['value'] <= 0){
			$this->result(1,'获取积分配置错误');
		}
		if($highest_sign['value'] != 0){
			$arr = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_order_log)." where share = 2 and gol_add_time = '".$time."' and gol_uid = ".$member['m_id']);
			if($arr >= $highest_sign['value']){
				$this->result(0,'你今天已经分享了'.$arr.'次,请明天再来!');
			}
		}
		//获得积分
		$this->begin();//开启事务
		$res = pdo_update("gpb_member",array('integral +='=>$share_sign['value']),array('m_openid'=>$openid));
		if(empty($res)){
			$this->rollback();
			$this->result(1,'获得积分失败');
		}
		$str = "用户于".date('Y-m-d H:i',time())."分享获得积分".$share_sign['value'];
		$data = [];
		$data['gol_uid'] = $member['m_id'];
		$data['gol_add_time'] = $time;
		$data['gol_comment'] = $str;
		$data['gol_u_name'] = $member['m_name'];
		$data['type'] = 2;
		$data['intage'] = $share_sign['value'];
		$data['share'] = 2;
		$res = pdo_insert($this->gpb_order_log,$data);
		
		if($res){
			$this->commit();
			$this->result(0,'获得'.$share_sign['value']."个积分");
		}
		$this->result(1,'获得积分失败');
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
		$member = pdo_fetch(' select m_name from '.tablename($this->gpb_member)." where m_id = ".$id." and weid = ".$this->weid);
		$data = array();
		$data['gol_uid'] = $id;
		$data['gol_add_time'] = time();
		$data['gol_comment'] = $str;
		$data['gol_go_code'] = $order;
		$data['gol_u_name'] = $member['m_name'];
		$data['type'] = 2;
		$data['intage'] = $inter;
		$data['gol_status'] = 1;
		$res = pdo_insert($this->gpb_order_log,$data);
		if($res){
			return true;
		}else{
			return FALSE;
		}
	}
	/**
	 * 事务处理
	 */
	public function begin(){
		//开始事务
		pdo_query("begin");
	}
	public function commit(){
		//提交事务
		pdo_query("commit");
	}
	public function rollback(){
		//事务回滚
		pdo_query("rollback");
	}
	
	
	
	
	
}
?>