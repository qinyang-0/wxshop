<?php
/**
 * [WeEngine System] Copyright (c) 20190705170434 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
header("Content-type: text/html; charset=utf-8");
if(version_compare(PHP_VERSION,'5.4.0', '<')){  
    echo '当前版本为'.phpversion().'小于5.4.0';
	echo'<br />';
	echo '请先升级版本';
	exit;
}

if(!file_exists('./data/install.lock')){
	header('Location: ./install');
} else {
	require './framework/bootstrap.inc.php';
	$host = $_SERVER['HTTP_HOST'];
	if (!empty($host)) {
		$bindhost = pdo_fetch("SELECT * FROM ".tablename('site_multi')." WHERE bindhost = :bindhost", array(':bindhost' => $host));
		if (!empty($bindhost)) {
			header("Location: ". $_W['siteroot'] . 'app/index.php?i='.$bindhost['uniacid'].'&t='.$bindhost['id']);
			exit;
		}
	}
	if($_W['os'] == 'mobile' && (!empty($_GPC['i']) || !empty($_SERVER['QUERY_STRING']))) {
		header('Location: ./app/index.php?' . $_SERVER['QUERY_STRING']);
	} else {
		header('Location: ./web/index.php?' . (!empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'c=account&a=display'));
	}
}