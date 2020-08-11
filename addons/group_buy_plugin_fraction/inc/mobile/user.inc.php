<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$user = $_SESSION['user'];
if(empty($user)){
	header('Location:'.$this->createMobileUrl('login'));
}
if($_W['openid']){
	$info = pdo_get($this->gpb_member,array('m_openid'=>$_W['openid']));
	if(empty($info)){
		pdo_insert($this->gpb_member,array('m_openid'=>$_W['fans']['openid'],'m_nickname'=>$_W['fans']['nickname'],'m_photo'=>$_W['fans']['headimgurl'],'weid'=>$this->weid,'m_add_time'=>time()));
	}else{
		if($info['status'] == 2){
			//已经审核过了
			$_SESSION['user'] = $info;
		}
	}
}
$user = pdo_get($this->gpb_member,array('m_id'=>$user['m_id']));
//获取待查看信息数量
$number = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_mail)." where code = 1 and m_id = ".$user['m_id']);
//待发货
$di = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_order)." where go_vid = ".$user['m_id']." and weid = ".$this->weid." and go_status = 20");
$yi = pdo_fetchcolumn("select count(*) from ".tablename($this->gpb_order)." where go_vid = ".$user['m_id']." and weid = ".$this->weid." and go_status = 30");
//已发货
include $this->template($do.'/'.$op);
?>