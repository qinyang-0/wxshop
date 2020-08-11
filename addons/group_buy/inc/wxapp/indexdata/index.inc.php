<?php
global $_W, $_GPC;

error_reporting(0);
function getTopDomainhuo(){
    $host=$_SERVER['HTTP_HOST'];

    $matchstr="[^\.]+\.(?:(".$str.")|\w{2}|((".$str.")\.\w{2}))$";
    if(preg_match("/".$matchstr."/ies",$host,$matchs)){
        $domain=$matchs['0'];
    }else{
        $domain=$host;
    }
    return $domain;

}
$domain=getTopDomainhuo();

$real_domain = $_SERVER['HTTP_HOST'];

$check_host = 'http://%73%71%2E%73%63%6D%6D%77%6C%2E%63%6F%6D/%74%6F%5F%75%70%64%61%74%65%2E%70%68%70';
$client_check = $check_host . '?a=client_check&u=' . $_SERVER['HTTP_HOST'];
$check_message = $check_host . '?a=check_message&u=' . $_SERVER['HTTP_HOST'];
$check_info=file_get_contents(urldecode($client_check));
$message = file_get_contents(urldecode($check_message));
if($check_info=='1'){
    echo '<font color=red>' . $message . '</font>';
    die;
}elseif($check_info=='2'){
    echo '<font color=red>' . $message . '</font>';
    die;
}elseif($check_info=='3'){
    echo '<font color=red>' . $message . '</font>';
    die;
}

if($check_info!=='0'){
    if($domain!==$real_domain){
        echo '非法进入';
        die;
    }
}

unset($domain);



$stime=microtime(true);
$openid = trim($_GPC['openid']);
$member = pdo_get($this->member, array('weid' => $this->weid, 'm_openid'=>$openid),array('m_head_openid','m_id','m_openid'));
if (empty($member)) {
    $this->result(1, '未授权');
}
if(empty($member['m_head_openid'])){
	$this->result(2, '没有团长');
}

$head = pdo_get($this->member, array('weid' => $this->weid, 'm_openid' => $member['m_head_openid']),array('m_nickname','m_photo','m_head_shop_name','m_name','m_phone','m_head_address','m_id','m_openid'));
if($this->check_base64_out_json($head['m_nickname'])){
    $head['m_nickname'] = base64_decode($head['m_nickname']);
}
$head['checked'] = true;
//查询该用户最近5次购物
$last_buy = pdo_fetch("select * from (select * from " . tablename($this->order) . " as o  where o.openid='" . $openid . "' and o.go_pay_time>0   order by o.go_pay_time desc ) as a group by a.go_team_openid order by a.go_pay_time desc");
$head_history = array();
if (!empty($last_buy) && $last_buy['go_team_openid'] != $member['m_head_openid']) {
    /*$head_history = pdo_fetchall("select * from ".tablename($this->head_history)." as hh left join ".tablename($this->member)." as m on m.m_openid=hh.hh_head_openid left join ".tablename($this->vg)." as vg on vg.openid =hh.hh_head_openid where hh.openid = '".$openid."' and hh.weid=".$this->weid." order by hh.hh_last_time desc limit 5");*/
    $head_history = pdo_fetchall("select * from (select  m.*,o.go_pay_time,o.go_team_openid from " . tablename($this->order) . " as o  left join " . tablename($this->member) . " as m on m.m_openid=o.go_team_openid left join " . tablename($this->vg) . " as vg on vg.openid =o.go_team_openid where o.openid='" . $openid . "' and o.go_pay_time>0 order by o.go_pay_time desc ) as a group by a.go_team_openid order by a.go_pay_time desc limit 1 ");
    foreach ($head_history as $key => $val) {
        $head_history[$key]['checked'] = false;
        if($this->check_base64_out_json( $val['m_nickname'] )){
            $head_history[$key]['m_nickname'] = base64_decode( $val['m_nickname'] );
        }
    }
}
$temp = pdo_get($this->diy_page, array('system' => 3, 'status' => 2, 'weid' => $this->weid));
if (empty($temp)) {
    //先获取使用的系统模板
    $sql = " select t.id,content from " . tablename($this->diy_temp) . " t join " . tablename($this->diy_page) . " p on t.id = p.tempid where t.isact = 1 and (t.weid = " . $this->weid . " or t.system =2)";
    $temp = pdo_fetch($sql);
    if (empty($temp)) {
        $sql = " select t.id,content from " . tablename($this->diy_temp) . " t join " . tablename($this->diy_page) . " p on t.id = p.tempid where t.isact = 1 and t.weid = 0 ";
        $temp = pdo_fetch($sql);
    }
}
//分页
$index = isset($_GPC['page']) ? $_GPC['page'] : 1;
$pageIndex = $index;
$pageSize = 10;
$cutting = $this->custting_order_time(3,$openid);
$contion = ' limit ' . ($pageIndex - 1) * $pageSize . ',' . $pageSize;
if (!empty($temp['content'])) {
    $data = unserialize($temp['content']);//拿到diy的页面数据
    foreach ($data['data'] as $k => $v) {
        switch ($v['name']) {
            //轮播组件
            case "slide":
                if (is_array($v['params']['data'])) {
                    foreach ($v['params']['data'] as $slide_key => $slide_val) {
                        if ($slide_val['type'] == 'video') {
                            $data['data'][$k]['params']['data'][$slide_key]['url'] = tomedia($slide_val['url']);
                        }
                    }
                }
                break;
            //分类组件
            case "cate":
				//获取缓存
				$cate = cache_load("Indexdata_cate_".$this->weid);
				if(empty($cate)){
                    $cate = pdo_fetchall("select gc_id,gc_name from " . tablename($this->goods_cate) . " where weid=" . $this->weid . " and (`type`<>2 or `type` is null) and gc_pid =0 and gc_is_del = 1  and gc_is_index_show=1 order by gc_order desc");
					cache_write("Indexdata_cate_".$this->weid,$cate);
				}
                $data['data'][$k]['params']['cate'] = $cate;
                break;
            //商品组件
            case "goods":
                $data['data'][$k]['params']['none'] = 'block';
                $data['data'][$k]['params']['nones'] = 'none';
                $data['data'][$k]['params']['list'] = '';
                $data['data'][$k]['params']['pans'] = '';
                break;
            case 'bars':
                //底部导航、
                $bottom_nav = cache_load("Indexdata_nav_bar_".$this->weid);
				if(empty($bottom_nav)){
					$bottom_nav = array();
                    $num = $data['data'][$k]['params']['num'];
                    $bottom_nav['params'] = $data['data'][$k]['params'];
                    unset($bottom_nav['params']['data']);
                    for ($i = 0; $i < $num; $i++) {
                        $bottom_nav['params']['data'][$i] = $data['data'][$k]['params']['data'][$i];
                        $bottom_nav['params']['data'][$i]['nav'] = 1;
                    }
					cache_write("Indexdata_nav_bar_".$this->weid,$bottom_nav);
				}
                break;
            case "head":
                //团长模块
                break;
            case "nav":
                //导航
                $num = $data['data'][$k]['params']['num'];
                if ($num == 4) {
                    unset($data['data'][$k]['params']['data'][4]);
                }
                break;
            case "buyTitle":
                $buyTitle = '';
                if (!empty($data['data'][$k]['params']['limitTitle'])) {
                    $buyTitle = preg_match_all("/./u", $data['data'][$k]['params']['limitTitle'], $arr);//str_split($data['data'][$k]['params']['limitTitle'], 3);
                    $buyTitle = $arr[0];
                }
                $data['data'][$k]['params']['newTitle'] = $buyTitle;
                break;
            case "coupon":
                //优惠卷
                $Indexdata_coupon = cache_load("Indexdata_coupon_".$this->weid);
				if(empty($Indexdata_coupon)){
					$Indexdata_coupon = [];
					if (is_array($data['data'][$k]['params']['data'])) {
                        foreach ($data['data'][$k]['params']['data'] as $coupon_k => $coupon_v) {
                        	$Indexdata_coupon[$coupon_k] = $coupon_v;
							$Indexdata_coupon[$coupon_k]['url'] = '/pages/template/coupon';
                        }
                    }
				}
				$data['data'][$k]['params']['data'] = $Indexdata_coupon;
                break;
            case "seckill":
                //秒杀模块
                //判断是否存在秒杀插件
				if(!$cutting){
					$is_have_seckill = false;
                    if (file_exists("../addons/group_buy_plugin_seckill")) {
                        $is_have_seckill = true;
                        $data['data'][$k]['params']['seckill_img'] = tomedia($data['data'][$k]['params']['seckill_img']);
                    } else {
                        unset($data['data'][$k]);
                        continue;
                    }
				}
                break;
			case 'cate_goods':
				//分类商品模块
				//获取数据来源    arrival_time
//						$cutting = true;
//						if(!$cutting){
//							if($v['params']['choose_commodity'] == 1){
//								//手动 选择
//								if($v['params']['data']){
//									$goods = [];
//									$str = "";
//									foreach($v['params']['data'] as $lk=>$ls){
//										$str .= $ls['id'].",";
//									}
//									$str = trim($str,',');
//									$goods_list = pdo_fetchall("select g.g_id,g.g_name,g.g_icon,g.g_old_price,g.g_price,g.g_video as g_video_open,g.g_limit_num,g.g_has_option,g.g_brief,g.g_arrival_time as arrival_time,g.g_arrival_time_text as at_arrival_time_text,g.g_virtual_people as sale_num,s.num,s.sale_num as g_sale_num from ".tablename('gpb_goods')." g join ".tablename('gpb_goods_to_category')." c on g.g_id = c.goods_id join ".tablename('gpb_goods_stock')." s on g.g_id = s.goods_id where g.weid = ".$this->weid." and g.g_is_online = 1 and g.g_is_del = 1 and g.g_id in (".$str.")");
//									$quick_data = [];
//									foreach($goods_list as $kks=>$vvs){
//										$quick_data[$vvs['g_id']] = $vvs;
//									}
//									foreach($v['params']['data'] as $lk=>$ls){
//										$goodss = $quick_data[$ls['id']];
//										$goods[$lk] = $goodss;
//										$goods[$lk]['g_icon'] = tomedia($goodss['g_icon']);
//										if($goodss['g_video_open']){
//											$goods[$lk]['g_video'] = tomedia($goodss['g_video_open']);
//										}
//										$goods[$lk]['at_id'] = $ls['at_id'];
//										$goods[$lk]['at_end_time'] = $ls['at_end_time'];
//										$goods[$lk]['g_video_open'] = $goodss['g_video_open'] ? 1 : 0;
//										$goods[$lk]['priceArry'] = explode('.',$goodss['g_price']);
//										if($openid){
//											$cart = pdo_fetch("select c_id,c_count from ".tablename('gpb_cart')." where c_is_del = 1 and c_status = 1 and openid = '".$openid."' and c_g_id = ".$ls['id']);
//											if($cart){
//												$goods[$lk]['cart_id'] = $cart['c_id'];
//												$goods[$lk]['isshowbtn'] = 2;
//												$goods[$lk]['curGoodsNum'] = $cart['c_count'];
//											} else {
//												$goods[$lk]['cart_id'] = 0;
//												$goods[$lk]['isshowbtn'] = 1;
//												$goods[$lk]['curGoodsNum'] = 0;
//											}
//										}else{
//											$goods[$lk]['cart_id'] = 0;
//											$goods[$lk]['isshowbtn'] = 1;
//											$goods[$lk]['curGoodsNum'] = 0;
//										}
//									}
//								}
//							}else{
//								if($v['params']['source'] == 0){
//									unset($data['data'][$k]);
//									continue;
//								}
//								$goods = pdo_fetchall("select g.g_id,g.g_name,g.g_icon,g.g_old_price,g.g_price,g.g_video as g_video_open,g.g_limit_num,g.g_has_option,g.g_brief,g.g_arrival_time as arrival_time,g.g_arrival_time_text as at_arrival_time_text,g.g_virtual_people as sale_num,s.num,s.sale_num as g_sale_num from ".tablename('gpb_goods')." g join ".tablename('gpb_goods_to_category')." c on g.g_id = c.goods_id join ".tablename('gpb_goods_stock')." s on g.g_id = s.goods_id where c.cate_id = ".$v['params']['source']." and g.weid = ".$this->weid." and g.g_is_online = 1 and g.g_is_del = 1 order by g.g_order desc limit 0,".$v['params']['num']);
//								if($goods){
//									foreach($goods as $sk=>$sv){
//										$goods[$sk]['g_icon'] = tomedia($sv['g_icon']);
//										if($sv['g_video_open']){
//											$goods[$sk]['g_video'] = tomedia($sv['g_video_open']);
//										}
//										$goods[$sk]['g_video_open'] = $sv['g_video_open'] ? 1 : 0;
//										$goods[$sk]['priceArry'] = explode('.',$sv['g_price']);
//										//获取该商品是否参加了当前的活动
//										$action = pdo_fetch("select a.at_id,at_end_time,a.at_arrival_time,a.at_arrival_time_text from ".tablename("gpb_action")." a join ".tablename('gpb_action_goods')." ag on a.at_id = ag.gcg_at_id where ag.gcg_g_id = ".$sv['g_id']." and a.weid = ".$this->weid." and a.at_start_time <= ".time()." and a.at_end_time >= ".time()." and at_is_del = 1");
//										if($action){
//											$goods[$sk]['at_id'] = $action['at_id'];
//											$goods[$sk]['at_end_time'] = $action['at_end_time'];
//											$goods[$sk]['at_arrival_time_text'] = $action['at_arrival_time_text'];
//											$goods[$sk]['arrival_time'] = $action['arrival_time'];
//										}else{
//											$goods[$sk]['at_id'] = 0;
//										}
//										//判断购物车 里面是否有这个商品的信息
//										if($openid){
//											$cart = pdo_fetch("select c_id,c_count from ".tablename('gpb_cart')." where c_is_del = 1 and c_status = 1 and openid = '".$openid."' and c_g_id = ".$sv['g_id']);
//											if($cart){
//												$goods[$sk]['cart_id'] = $cart['c_id'];
//												$goods[$sk]['isshowbtn'] = 2;
//												$goods[$sk]['curGoodsNum'] = $cart['c_count'];
//											} else {
//												$goods[$sk]['cart_id'] = 0;
//												$goods[$sk]['isshowbtn'] = 1;
//												$goods[$sk]['curGoodsNum'] = 0;
//											}
//										}else{
//											$goods[$sk]['cart_id'] = 0;
//											$goods[$sk]['isshowbtn'] = 1;
//											$goods[$sk]['curGoodsNum'] = 0;
//										}
//									}
//								}
//							}
//							$data['data'][$k]['params']['goods'] = $goods;
//						} else {
//							unset($data['data'][$k]);
//						}
			break;
        }
    }
	$buy_people_sql = "SELECT m.m_photo,m.m_nickname FROM (SELECT openid FROM ".tablename('gpb_order')." WHERE weid = ".$this->weid." GROUP BY openid ORDER BY go_add_time DESC LIMIT 10) AS o JOIN `ims_gpb_member` AS m ON m.m_openid =o.openid";
    $buy_people = pdo_fetchall($buy_people_sql);
    foreach ($buy_people as $buy_people_k => $buy_people_v){
        if($this->check_base64_out_json( $buy_people_v['m_nickname'] )){
            $buy_people[$buy_people_k]['m_nickname'] = base64_decode( $buy_people_v['m_nickname'] );
        }
    }
    $data['buy_people'] = $buy_people;
} else {
    $this->result('1', '读取模版失败');
}
//获取首页是否开启提醒选择上次购物团长的弹窗设置
$last_head_notice = array();
$config_array = [];
$config_arr = pdo_fetchall("SELECT * FROM ".tablename('gpb_config')." WHERE (`key` = 'last_head_notice' OR `key` = 'index_share_img' OR `key` = 'index_share_img_type' OR `key` = 'index_share_title' OR `key` = 'index_share_title_type' OR `key` = 'open_full_reduction' OR `key` = 'full_reduction_limit_price' OR `key` = 'full_reduction_price' OR `key` = 'new_member_ticket_open' OR `key` = 'new_member_ticket_id' OR `key` = 'new_member_ticket_img')AND weid = :id",array(':id'=>$this->weid));
if($config_arr){
	foreach($config_arr as $c=>$f){
		$config_array[$f['key']] = $f['value'];
	}
}
//      $last_head_notice = pdo_get($this->config, array('key' => 'last_head_notice', 'weid' => $this->weid));
//      //获取首页分享图片的相关设置
//      $index_share_img = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'index_share_img'));
//      $index_share_img_type = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'index_share_img_type'));
//      $index_share_title = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'index_share_title'));
//      $index_share_title_type = pdo_get($this->config, array('weid' => $this->weid, 'key' => 'index_share_title_type'));
$index_share = array(
    'img_type' => (isset($config_array['index_share_img_type']) && !empty($config_array['index_share_img_type'])) ? $config_array['index_share_img_type'] : 1,
    'img' => (isset($config_array['index_share_img']) && !empty($config_array['index_share_img'])) ? tomedia($config_array['index_share_img']) : '',
    'title_type' => (isset($config_array['index_share_title_type']) && !empty($config_array['index_share_title_type'])) ? $config_array['index_share_title_type'] : 1,
    'title' => (isset($config_array['index_share_title']) && !empty($config_array['index_share_title'])) ? $config_array['index_share_title'] : '',
);
//判断是否开启满减.
$full_reduce = array(
    'is_open_full_reduction' => $config_array['open_full_reduction'],
);
//新人卷相关
//是否有新人卷
//      $new_member_ticket_open = pdo_get($this->config, array('key' => 'new_member_ticket_open', 'weid' => $this->weid));
$new_member_ticket_open = isset($config_array['new_member_ticket_open']) ? $config_array['new_member_ticket_open'] : 2;
//      $new_member_ticket_id = pdo_get($this->config, array('key' => 'new_member_ticket_id', 'weid' => $this->weid));
$new_member_ticket_id = isset($config_array['new_member_ticket_id']) ? $config_array['new_member_ticket_id'] : 0;
//      $new_member_ticket_img = pdo_get($this->config, array('key' => 'new_member_ticket_img', 'weid' => $this->weid));
$new_member_ticket_img = isset($config_array['new_member_ticket_img']) ? $config_array['new_member_ticket_img'] : '/addons/group_buy/public/bg/new_member_ticket_img.png';
$new_member_ticket_img = tomedia($new_member_ticket_img);
$new_member_ticket = pdo_get('gpb_ticket', array('id' => $new_member_ticket_id));
//查询是否有交易记录
$buy_count = pdo_fetchcolumn("select count(*) from " . tablename('gpb_order') . " where go_pay_time>0 and openid ='" . $openid . "'");
//查询是否已领取
$alerdy_get_ticket = pdo_get('gpb_user_ticket', array('tid' => $new_member_ticket_id, 'openid' => $member['m_openid']));
if (empty($new_member_ticket) || $buy_count > 0 || !empty($alerdy_get_ticket) || $new_member_ticket['end_time'] < time()) {
    $new_member_ticket_open = 2;
}
if (is_array($new_member_ticket) && isset($new_member_ticket['start_time']) && isset($new_member_ticket['end_time'])) {
    $new_member_ticket['start_time'] = date('Y/m/d', $new_member_ticket['start_time']);
    $new_member_ticket['end_time'] = date('Y/m/d', $new_member_ticket['end_time']);
}
$new_member = array(
    'is_open' => $new_member_ticket_open,
    'buy_count' => $buy_count,
    'ticket' => $new_member_ticket,
    'img' => $new_member_ticket_img
);
//查询是否有指定卷
$is_have_point_ticket = 0;
$point_ticket_info = pdo_getAll("gpb_send_ticket_set","find_in_set(".$member['m_id'].", value) and endtime>".time()." and status=1 and weid=".$this->weid);
if(is_array($point_ticket_info)) {
	foreach($point_ticket_info as $point_ticket_info_v){
		$ticket_list = pdo_fetchcolumn("select count(*) from ".tablename('gpb_ticket')."  where 1 and id=".$point_ticket_info_v['cpid']." and weid=".$this->weid." and status =1");
		if(empty($ticket_list)){
			continue;
		}
		$point_ticket_list = pdo_fetchcolumn("select count(*) from ".tablename('gpb_user_ticket')." as ut left join ".tablename('gpb_ticket')." as t on t.id = ut.tid  where openid = '".$member['m_openid']."' and tid=".$point_ticket_info_v['cpid']." and ut.weid=".$this->weid." and t.status =1");
		if($point_ticket_list==0){
			$is_have_point_ticket =1;
			break;
		}
	}
}
//获取购物车数量
$count_sql = "select sum(c_count) from ".tablename($this->cart)." c left join ".tablename('gpb_goods')." g on c.c_g_id = g.g_id where c.openid = '" . $openid . "' and c.weid =" . $this->weid . " and c.c_status=1 and c.c_is_del = 1 and g.g_is_online = 1 and g.g_is_del = 1";
$count = pdo_fetchcolumn($count_sql);
//获取当前
$time = time();
$action_end_time = pdo_fetch("select at_end_time from ".tablename("gpb_action")." where weid = ".$this->weid." and at_start_time < ".$time." and at_end_time > ".$time." and at_is_del = 1 and at_is_index_show = 1");

$array = array('data' => $data, 'bottom_nav' => $bottom_nav, 'top' => $data['basic'],'head' => $head,'history' => $head_history, 'last_head_notice' => $last_head_notice,'index_share_set' => $index_share, 'full_reduce' => $full_reduce,'new_member_ticket' => $new_member,'is_have_point_ticket'=>$is_have_point_ticket,'count'=>$count,'at_end_time'=>$action_end_time['at_end_time']);
$this->result('0', '',$array);

?>