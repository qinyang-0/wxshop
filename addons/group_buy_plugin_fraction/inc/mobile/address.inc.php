<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$user = $_SESSION['user'];
$id = $_GPC['id'];
if(empty($user)){
	header('Location:'.$this->createMobileUrl('login'));
}
switch($op){
	case 'index':
		//列表
		$info = pdo_getall($this->gpb_address,array('m_id'=>$user['m_id'],'weid'=>$this->weid),array() , '' , 'mr DESC');
	break;
	case 'add':
		//新增或修改
		if($_GET['type'] == 'add'){
			//新增 或修改数据
			if(empty($_GPC['name'])){
				$this->res(1,'请填写姓名');
			}
			if(empty($_GPC['mobile'])){
				$this->res(1,'请填写电话');
			}
			if(empty($_GPC['address'])){
				$this->res(1,'请填写地址');
			}
			if(empty($_GPC['code'])){
				$this->res(1,'请填写邮编');
			}
			$data = [];
			$data['address'] = $_GPC['address'];
			$data['name'] = $_GPC['name'];
			$data['phone'] = $_GPC['mobile'];
			$data['code'] = $_GPC['code'];
			if($id){
				//修改
				$res = pdo_update($this->gpb_address,$data,array('id'=>$id));
			}else{
				$data['weid'] = $this->weid;
				$data['time'] = time();
				$data['openid'] = $_W['openid'];
				$data['m_id'] = $user['m_id'];
				$res = pdo_insert($this->gpb_address,$data);
			}
			if($res){
				$this->res(0,'添加成功');
			}else{
				$this->res(1,'操作失败');
			}
		}else{
			if($id){
				$info = pdo_get($this->gpb_address,array('id'=>$id));
			}
		}
	break;
	case 'delete':
		//删除
		if(empty($id)){
			$this->res(1,'非法进入');
		}
		$res = pdo_delete($this->gpb_address,array('id'=>$id));
		if($res){
			$this->res(0,'');
		}else{
			$this->res(1,'删除失败');
		}
	break;
	case 'save':
		if(empty($id)){
			$this->res(1,'非法进入');
		}
		pdo_update($this->gpb_address,array('mr'=>1),array('m_id'=>$user['m_id']));
		$res = pdo_update($this->gpb_address,array('mr'=>2),array('id'=>$id));
		
		if($res){
			$this->res(0,'');
		}else{
			$this->res(1,'修改失败');
		}
	break;
	case 'list':
		$info = pdo_getall($this->gpb_address,array('m_id'=>$user['m_id'],'weid'=>$this->weid),array() , '' , 'mr DESC');
	break;
}

include $this->template($do.'/'.$op);
?>