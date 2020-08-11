<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];

switch($op){
	case 'index':
	break;
	case 'add':
		$data = $_POST;
		if(empty($data['name'])){
			$this->res(1,'请输入真实姓名');
		}
		if(empty($data['mobile'])){
			$this->res(1,'请输入正确的电话号码');
		}
		if(empty($data['id'])){
			$this->res(1,'请输入正确的身份证号码');
		}
		if(empty($data['address'])){
			$this->res(1,'请输入地址');
		}
		if(empty($data['pws1'])){
			$this->res(1,'请输入密码');
		}
		if(empty($data['pws2'])){
			$this->res(1,'请输入密码');
		}
		if($data['pws1'] != $data['pws2']){
			$this->res(1,'两次密码输入不一致');
		}
		//判断用户是否注册过  每个用户只能注册1次
		$info = pdo_get($this->gpb_member,array('m_phone'=>$data['mobile']));
		if($info){
			$this->res(1,'该号码已经成功注册!');
		}
		$list = [];
		$list['m_name'] = $data['name'];
		$list['m_phone'] = $data['mobile'];
		$list['m_address'] = $data['address'];
		$list['m_ids'] = $data['id'];
		$list['m_password'] = md5(md5($data['pws1'])."scmmwl");
		$status = $this->sc('status');
		if(!empty($status) && $status == 1){
			$list['status'] = 2;
		}
		if(empty($_W['openid'])){
			$res = pdo_insert($this->gpb_member,$list);
		}else{
			$res = pdo_update($this->gpb_member,$list,array('m_openid'=>$_W['openid']));
		}
		if(empty($res)){
			$this->res(1,'位置原因，注册失败');
		}else{
			$this->res(0,'注册成功，请等待审核');
		}
	break;
}


include $this->template($do.'/'.$op);
?>