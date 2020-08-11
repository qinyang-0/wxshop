<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('cloud');
load()->func('communication');

$dos = array('sms', 'smsLog', 'smsSign', 'smsTrade', 'settingSign');
$do = in_array($do, $dos) ? $do : 'sms';

if ($do == 'sms') {
	$sms_info = cloud_sms_info();
	if (!empty($sms_info['sms_sign'])) {
		foreach ($sms_info['sms_sign'] as $item) {
			$cloud_sms_signs[$item] = $item;
		}
	}
	$setting_sms_sign = setting_load('site_sms_sign');
	$setting_sms_sign = !empty($setting_sms_sign['site_sms_sign']) ? $setting_sms_sign['site_sms_sign'] : array();
	$setting_sms_sign['register'] = !empty($setting_sms_sign['register']) ? $setting_sms_sign['register'] : '';
	$setting_sms_sign['find_password'] = !empty($setting_sms_sign['find_password']) ? $setting_sms_sign['find_password'] : '';
	$setting_sms_sign['user_expire'] = !empty($setting_sms_sign['user_expire']) ? $setting_sms_sign['user_expire'] : '';

	template('cloud/sms');
}

if ($do == 'smsSign') {
	iajax(0, cloud_sms_sign(intval($_GPC['parames']['page'])));
}


if ($do == 'smsTrade') {
	$params = safe_gpc_array($_GPC['params']);
	$params['page'] = empty($params['page']) ? 1 : intval($params['page']);
	if (!empty($params['time'][1])) {
		$params['time'][1] += 86400;
	} else {
		$params['time'] = array();
	}
	$data = cloud_sms_trade($params['page'], $params['time']);

	if (isset($data['data'][0]['createtime']) && is_numeric($data['data'][0]['createtime'])) {
		foreach ($data['data'] as &$item) {
			$item['createtime'] = date('Y-m-d H:i:s', $item['createtime']);
		}
	}
	iajax(0, $data);
}

if ($do == 'smsLog') {
	$params = safe_gpc_array($_GPC['params']);
	$params['page'] = empty($params['page']) ? 1 : intval($params['page']);
	$params['page_size'] = empty($params['page_size']) ? 10 : intval($params['page_size']);
	$params['mobile'] = !is_numeric($params['mobile']) || empty($params['mobile']) ? 0 : $params['mobile'];
	if (!empty($params['time'][1])) {
		$params['time'][1] += 86400;
	} else {
		$params['time'] = array();
	}

	$data = cloud_sms_log($params['mobile'], $params['time'], $params['page'], $params['page_size']);

	if (is_error($data)) {
		iajax(-1, $data['message']);
	}
	if (isset($data['data'][0]['createtime']) && is_numeric($data['data'][0]['createtime'])) {
		foreach ($data['data'] as &$item) {
			$item['createtime'] = date('Y-m-d H:i:s', $item['createtime']);
		}
	}
	iajax(0, $data);
}

if ($do == 'settingSign') {
	$setting_sms_sign = setting_load('site_sms_sign');
	$setting_sms_sign = !empty($setting_sms_sign['site_sms_sign']) ? $setting_sms_sign['site_sms_sign'] : array();

	if (isset($_GPC['register'])) {
		$setting_sms_sign['register'] = safe_gpc_string($_GPC['register']);
		$setting_sms_sign['register'] = 789;
	}
	if (isset($_GPC['find_password'])) {
		$setting_sms_sign['find_password'] = safe_gpc_string($_GPC['find_password']);
	}
	if (isset($_GPC['user_expire'])) {
		$setting_sms_sign['user_expire'] = safe_gpc_string($_GPC['user_expire']);
	}
	$result = setting_save($setting_sms_sign, 'site_sms_sign');
	if (is_error($result)) {
		iajax(-1, '设置失败', url('cloud/sms'));
	}
	iajax(0, '设置成功', url('cloud/sms'));
}



