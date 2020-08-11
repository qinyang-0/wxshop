<?php
global $_W, $_GPC;
$code = trim($_GPC['code']);
$appid = $_W['oauth_account']['key'];
$secret = $_W['oauth_account']['secret'];
//        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
$url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $secret . '&js_code=' . $code . '&grant_type=authorization_code';
$curl = curl_init();

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl, CURLOPT_TIMEOUT, 500);

// 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

curl_setopt($curl, CURLOPT_URL, $url);

$res = curl_exec($curl);

curl_close($curl);

$json_obj = json_decode($res, true);

$openid = $json_obj["openid"];

$sessionkey = $json_obj["session_key"];

$unionid = $json_obj["unionid"];
//是否显示首页分类页数据加载完的底部图片
$data_end_show_img_open = pdo_get($this -> config, array('weid' => $this -> weid, 'key' => 'data_end_show_img_open'));
//首页分类页数据加载完的底部图片
$data_end_show_img = pdo_get($this -> config, array('weid' => $this -> weid, 'key' => 'data_end_show_img'));
//加载未完成时的默认图片（大）
$default_big_img = pdo_get($this -> config, array('weid' => $this -> weid, 'key' => 'default_big_img'));
//加载未完成时的默认图片（小）
$default_small_img = pdo_get($this -> config, array('weid' => $this -> weid, 'key' => 'default_small_img'));
//是否开启首图视频显示
$is_open_goods_video = pdo_get($this -> config, array('key' => 'is_open_goods_video', 'weid' => $this -> weid));
//自定义社区或小区名称
$diy_community_name = pdo_get($this -> config, array('weid' => $this -> weid, 'key' => 'diy_community_name'));
$group_buy_name = pdo_get($this -> config, array('weid' => $this -> weid, 'key' => 'group_buy_name'));
//自定义团长名称
$commander_name = pdo_get($this -> config, array('weid' => $this -> weid, 'key' => 'group_buy_commander_name'));
//选择团长页面团长名称
$choice = pdo_get($this -> config, array('weid' => $this -> weid, 'key' => 'group_buy_choice'));

$set = array('data_end_show_img_open' => isset($data_end_show_img_open['value']) ? $data_end_show_img_open['value'] : 2, 'data_end_show_img' => isset($data_end_show_img['value']) ? tomedia($data_end_show_img['value']) : '', 'default_big_img' => isset($default_big_img['value']) ? tomedia($default_big_img['value']) : '', 'default_small_img' => isset($default_small_img['value']) ? tomedia($default_small_img['value']) : '', 'is_open_goods_video' => isset($is_open_goods_video['value']) ? $is_open_goods_video['value'] : 2, 'diy_community_name' => isset($diy_community_name['value']) ? $diy_community_name['value'] : '社区', 'group_buy_name' => isset($group_buy_name['value']) ? $group_buy_name['value'] : '团购', 'commander_name' => isset($commander_name['value']) ? $commander_name['value'] : '团长', 'act_commander_name' => isset($choice['value']) ? $choice['value'] : '团长', );
//判断是否开启的云存储
if($_W['setting']['remote']['type']){
	$setting = 1;
}else{
	$setting = 2;
}
$json_obj['setting'] = $setting;


if (!empty($openid)) {
	$member = pdo_get('gpb_member', array('m_openid' => $openid, 'weid' => $this -> weid));
	if (!empty($member)) {
		pdo_update('gpb_member', array('unionid' => $unionid, 'sessionkey' => $sessionkey), array('m_openid' => $openid, 'm_id' => $member['m_id']));
	} else {
		pdo_insert('gpb_member', array('m_openid' => $openid, 'unionid' => $unionid, 'sessionkey' => $sessionkey, 'weid' => $this -> weid, 'm_add_time' => time()));
	}
	$this -> result("0", "获取openid成功", array('openid' => $openid, 'sessionkey' => $sessionkey, 'config' => $set, 'unionid' => $unionid,'setting'=>$setting));
} else {
	$this -> result("1", "获取openid失败,请重试", $json_obj);

}
?>