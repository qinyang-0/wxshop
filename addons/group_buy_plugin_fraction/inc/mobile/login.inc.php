<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
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
switch($op){
	case 'index':
		if(!empty($_SESSION['user'])){
			header('Location:'.$this->createMobileUrl('index'));
			exit;
		}
		$_type = $_GPC['type'];
		if(!empty($_type)){
			//判断来源
			$info = explode(',',$_type);
			$url = $this->createMobileUrl($info[0],array('id'=>$info[1]));
		}
	break;
	case 'login':
		$login = $_GPC['login'];
		$pwd = $_GPC['pas'];
		if(empty($login) || empty($pwd)){
			$this->res(1,'请输入账号密码');
		}
		$info = pdo_get($this->gpb_member,array('m_phone'=>$login));
		if(empty($info)){
			$this->res(1,'账号不存在,请先注册');
		}
		if( md5(md5($pwd)."scmmwl") != $info['m_password']){
			$this->res(1,'密码错误');
		}
		if($info['status'] == 1){
			$this->res(1,'请耐心等待审核');
		}
		$_SESSION['user'] = $info;
		$this->res(0,'登录成功',$_GPC['url']);
	break;
}
include $this->template($do.'/'.$op);
?>