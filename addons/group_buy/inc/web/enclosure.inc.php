<?php
/**
 * 附件设置
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];
//主键id
empty($op) ? $op = 'index' : $op;
switch($op) {
	case 'index' :
		if (empty($_W['setting']['upload'])) {
			$upload = $_W['config']['upload'];
		} else {
			$upload = $_W['setting']['upload'];
		}
		$post_max_size = ini_get('post_max_size');
		$post_max_size = $post_max_size > 0 ? bytecount($post_max_size) / 1024 : 0;
		$upload_max_filesize = ini_get('upload_max_filesize');
		if ($_GPC['token'] == 'submit') {
			$harmtype = array('asp','php','jsp','js','css','php3','php4','php5','ashx','aspx','exe','cgi');
			$data = $_POST;
			if($data){
				foreach($data as $k=>$v){
					switch ($k) {
						case 'attachment_limit':
							$upload['attachment_limit'] = max(0, intval($v)); 				break;
						case 'image_thumb':
							$upload['image']['thumb'] = empty($v) ? 0 : 1;
							break;
						case 'image_width':
							$upload['image']['width'] = intval($v); 				break;
						case 'image_extentions':
							$upload['image']['extentions'] = array();
							$image_extentions = explode("\n", safe_gpc_string($v));
							foreach ($image_extentions as $item) {
								$item = safe_gpc_string(trim($item));
								if (!empty($item) && !in_array($item, $harmtype) && !in_array($item, $upload['image']['extentions'])) {
									$upload['image']['extentions'][] = $item;
								}
							}
							break;
						case 'image_limit':
							$upload['image']['limit'] = max(0, min(intval($v), $post_max_size));break;
						case 'image_zip_percentage':
							$zip_percentage = intval($v);
							$upload['image']['zip_percentage'] = $zip_percentage;
							if ($zip_percentage <= 0 || $zip_percentage > 100) {
								$upload['image']['zip_percentage'] = 100;				}
							break;
						case 'audio_extentions':
							$upload['audio']['extentions'] = array();
							$audio_extentions = explode("\n", safe_gpc_string($v));
							foreach ($audio_extentions as $item) {
								$item = safe_gpc_string(trim($item));
								if (!empty($item) && !in_array($item, $harmtype) && !in_array($item, $upload['audio']['extentions'])) {
									$upload['audio']['extentions'][] = $item;
								}
							}
							break;
						case 'audio_limit':
							$upload['audio']['limit'] = max(0, min(intval($v), $post_max_size));break;
					}
				}
			}
			setting_save($upload, 'upload');
			iajax(0, '更新设置成功', url('system/attachment'));
		}
		if (empty($upload['image']['thumb'])) {
			$upload['image']['thumb'] = 0;
		} else {
			$upload['image']['thumb'] = 1;
		}
		$upload['image']['width'] = intval($upload['image']['width']);
		if (empty($upload['image']['width'])) {
			$upload['image']['width'] = 800;
		}
		if (!empty($upload['image']['extentions']) && is_array($upload['image']['extentions'])) {
			$upload['image']['extentions'] = implode("\n", $upload['image']['extentions']);
		}
		if (!empty($upload['audio']['extentions']) && is_array($upload['audio']['extentions'])) {
			$upload['audio']['extentions'] = implode("\n", $upload['audio']['extentions']);
		}
		if(empty($upload['image']['zip_percentage'])) {
			$upload['image']['zip_percentage'] = 100;
		}
//		echo '<pre>';
//		print_r($upload);exit;
	break;
	case 'add' :
		load() -> func('communication');
		load() -> model('attachment');
		load() -> model('miniapp');
		$remote = uni_setting_load('remote');
		$remote = empty($remote['remote']) ? array() : $remote['remote'];
//		echo '<pre>';
//		print_r($remote);exit;
//		if($remote['type'] == 2){
			//用的是阿里云的oss  获取区
			if($remote['alioss']['key'] && $remote['alioss']['secret']){
				$buckets = attachment_alioss_buctkets($remote['alioss']['key'], $remote['alioss']['secret']);
				$bucket_datacenter = attachment_alioss_datacenters();
				$bucket = array();
				foreach ($buckets as $key => $value) {
					$value['loca_name'] = $key. '@@'. $bucket_datacenter[$value['location']];
					$bucket[] = $value;
				}
			}
//		}
		break;
	case 'upload_remote' :
		if (!empty($remote['type'])) {
			if (empty($_W['setting']['remote']['type'])) {
				iajax(3, '未开启全局远程附件');
			}
			$result = file_dir_remote_upload(ATTACHMENT_ROOT . 'images/' . $_W['uniacid']);
			if (is_error($result)) {
				iajax(1, $result['message']);
			} else {
				iajax(0, '上传成功!');
			}
		} else {
			iajax(1, '请先填写并开启远程附件设置。');
		}
		break;
}
if ($op == 'save' || $op == 'test_setting') {
	$type_sign = array( ATTACH_OSS => 'alioss', ATTACH_QINIU => 'qiniu', ATTACH_COS => 'cos');
	$type = intval($_GPC['type']);
	$op_type = intval($_GPC['operate_type']);
	$op_sign = $type_sign[$op_type];
	$op_data = array();
	$post = safe_gpc_array($_GPC[$op_sign]);
	if (!in_array($op_type, array_keys($type_sign))) {
		iajax(-1, '参数有误');
	}
	if ($type != 0 && !in_array($type, array_keys($type_sign))) {
		iajax(-1, '附件类型有误');
	}
	switch ($op_type) {
		case ATTACH_QINIU :
			$op_data = array('accesskey' => trim($post['accesskey']), 'secretkey' => strexists($post['secretkey'], '*') ? $remote['qiniu']['secretkey'] : trim($post['secretkey']), 'bucket' => trim($post['bucket']), 'url' => trim(trim($post['url']), '/'), );
			if ($op_data['url']) {
				$op_data['url'] = strexists($op_data['url'], 'http') ? $op_data['url'] : 'http://' . $op_data['url'];
			}
			if (empty($op_data['accesskey'])) {
				iajax(-1, '请填写Accesskey');
			}
			if (empty($op_data['secretkey'])) {
				iajax(-1, 'secretkey');
			}
			if (empty($op_data['bucket'])) {
				iajax(-1, '请填写bucket');
			}
			if (empty($op_data['url'])) {
				iajax(-1, '请填写url');
			}
			break;
		case ATTACH_OSS :
			$op_data = array('key' => trim($post['key']), 'secret' => strexists($post['secret'], '*') ? $remote['alioss']['secret'] : $post['secret'], 'internal' => intval($post['internal']), 'bucket' => trim($post['bucket']), 'url' => trim(trim($post['url']), '/'), );
			if (!empty($op_data['url']) && !strexists($op_data['url'], 'http://') && !strexists($op_data['url'], 'https://')) {
				$op_data['url'] = 'http://' . $op_data['url'];
			}
			if (empty($op_data['key'])) {
				iajax(-1, 'Access Key ID不能为空');
			}
			if (empty($op_data['secret'])) {
				iajax(-1, 'Access Key Secret不能为空');
			}
			if (empty($op_data['bucket'])) {
				iajax(-1, 'Bucket不能为空');
			}
			break;
		case ATTACH_COS :
			$op_data = array('appid' => trim($post['appid']), 'secretid' => trim($post['secretid']), 'secretkey' => strexists(trim($post['secretkey']), '*') ? $remote['cos']['secretkey'] : trim($post['secretkey']), 'bucket' => trim($post['bucket']), 'local' => trim($post['local']), 'url' => trim(trim($post['url']), '/'));
			$op_data['bucket'] = str_replace("-{$post['appid']}", '', $post['bucket']);
			if (empty($op_data['url'])) {
				$op_data['url'] = sprintf('https://%s-%s.cos%s.myqcloud.com', $op_data['bucket'], $op_data['appid'], $op_data['local']);
			}
			if (empty($op_data['appid'])) {
				iajax(-1, '请填写APPID');
			}
			if (empty($op_data['secretid'])) {
				iajax(-1, '请填写SECRETID');
			}
			if (empty($op_data['secretkey'])) {
				iajax(-1, '请填写SECRETKEY');
			}
			if (empty($op_data['bucket'])) {
				iajax(-1, '请填写BUCKET');
			}
			break;
		case ATTACH_FTP :
			$op_data = array('ssl' => intval($post['ssl']), 'host' => $post['host'], 'port' => empty($post['port']) ? 21 : $post['port'], 'username' => $post['username'], 'password' => strexists($post['password'], '*') ? $remote['ftp']['password'] : $post['password'], 'pasv' => intval($post['pasv']), 'dir' => $post['dir'], 'url' => $post['url'], 'overtime' => intval($post['overtime']), );
			if (empty($op_data['host'])) {
				iajax(-1, 'FTP服务器地址为必填项.');
			}
			if (empty($op_data['username'])) {
				iajax(-1, 'FTP帐号为必填项.');
			}
			if (empty($op_data['password'])) {
				iajax(-1, 'FTP密码为必填项.');
			}
			break;
	}
	if ($op == 'test_setting') {
		$test_type = $op_type;
	} elseif ($type == $op_type) {
		$test_type = $type;
	}
	if ($test_type) {
		switch ($test_type) {
			case ATTACH_QINIU :
				$title = '七牛';
				$auth = attachment_qiniu_auth($op_data['accesskey'], $op_data['secretkey'], $op_data['bucket']);
				if (is_error($auth)) {
					$message = $auth['message']['error'] == 'bad token' ? 'Accesskey或Secretkey填写错误， 请检查后重新提交' : 'bucket填写错误或是bucket所对应的存储区域选择错误，请检查后重新提交';
					iajax(-1, $message);
				}
				break;
			case ATTACH_OSS :
				$title = '阿里云OSS';
				$buckets = attachment_alioss_buctkets($op_data['key'], $op_data['secret']);
				if (is_error($buckets)) {
					iajax(-1, 'Access Key ID 或 OSS-Access Key Secret错误，请重新填写');
				}
				if (empty($buckets[$op_data['bucket']])) {
					iajax(-1, 'Bucket不存在或是已经被删除');
				}
				if (empty($op_data['url'])) {
					$op_data['url'] = 'http://' . $op_data['bucket'] . '.' . $buckets[$op_data['bucket']]['location'] . '.aliyuncs.com';
				}
				$op_data['ossurl'] = $buckets[$op_data['bucket']]['location'] . '.aliyuncs.com';
				$result = attachment_newalioss_auth($op_data['key'], $op_data['secret'], $op_data['bucket'], $op_data['internal']);
				if (is_error($result)) {
					iajax(-1, 'OSS-Access Key ID 或 OSS-Access Key Secret错误，请重新填写');
				}
				break;
			case ATTACH_COS :
				$title = '腾讯cos';
				$auth = attachment_cos_auth($op_data['bucket'], $op_data['appid'], $op_data['secretid'], $op_data['secretkey'], $op_data['local']);
				if (is_error($auth)) {
					iajax(-1, '配置失败，请检查配置：' . $auth['message']);
				}
				break;
			case ATTACH_FTP :
				$title = 'FTP';
				load() -> library('ftp');
				$ftp = new Ftp($op_data);
				if (true !== $ftp -> connect()) {
					iajax(-1, 'FTP服务器连接失败，请检查配置');
				}
				$filename = 'MicroEngine.ico';
				if (!$ftp -> upload(ATTACHMENT_ROOT . 'images/global/' . $filename, $filename)) {
					iajax(-1, '上传图片失败，请检查配置');
				}
				break;
		}
		$response = ihttp_request($op_data['url'] . '/MicroEngine.ico', array(), array('CURLOPT_REFERER' => $_SERVER['SERVER_NAME']));
		if (is_error($response)) {
			iajax(-1, '配置失败，' . $title . '访问url错误');
		}
		if (intval($response['code']) != 200) {
			iajax(-1, '配置失败，' . $title . '访问url错误,请保证bucket为公共读取的');
		}
		$image = getimagesizefromstring($response['content']);
		if (empty($image) || !strexists($image['mime'], 'image')) {
			iajax(-1, '配置失败，' . $title . '访问url错误');
		}
	}
	if ($op == 'test_setting') {
		iajax(0, '配置成功');
	}
	if ($op == 'save') {
		$remote['type'] = $type;
		$remote[$op_sign] = $op_data;
		uni_setting_save('remote', $remote);
		iajax(0, '保存成功', url('profile/remote'));
	}
}
include $this -> template('web/' . $do . '/' . $op);
?>