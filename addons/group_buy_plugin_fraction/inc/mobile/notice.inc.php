<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$index=isset($_GPC['page'])?$_GPC['page']:1;
$user = $_SESSION['user'];
$id = $_GPC['id'];
if(empty($user)){
	header('Location:'.$this->createMobileUrl('login'));
}
$user = pdo_get($this->gpb_member,array('m_id'=>$user['m_id']));

switch($op){
	case 'index':
		$status = $_GPC['status'];
		$where = '';
		if($status){
			$where = ' and code = '.$status;
		}
		$pageIndex = $index;
		$pageSize = $this->pageSize;
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_mail)." where weid = ".$this->weid." and m_id = ".$user['m_id'].$where);	
		$page = pagination($total,$pageIndex,$pageSize);
		$sql = 'select * from ' . tablename($this->gpb_mail)." where weid = ".$this->weid." and m_id = ".$user['m_id'].$where." order by time desc ";
		$info = pdo_fetchall($sql.$contion);
		if($_GPC['type'] == 2){
			if(!empty($info)){
				foreach($info as $k=>$v){
					$info[$k]['time'] = date('m月d日 H:i',$v['time']);
				}
			}
			$this->res(0,'',$info);
		}
	break;
	case 'save':
		if(empty($id)){
			$this->res(1,'请传入id');
		}
		$res = pdo_update($this->gpb_mail,array('code'=>2),array('id'=>$id));
		if($res){
			$this->res(0,'操作成功');
		}else{
			$this->res(1,'操作失败');
		}
	break;
	case 'feedback':
		if($_GPC['code'] == '2'){
			$data['title'] = $_GPC['title'];
			$data['area'] = $_GPC['area'];
			$info = [];
			$info['content'] = serialize($data);
			$info['weid'] = $this->weid;
			$info['m_id'] = $user['m_id'];
			$info['time'] = time();
			$info['openid'] = $user['m_openid'];
			$res = pdo_insert($this->gpb_feed_back,$info);
			if(empty($res)){
				$this->res(1,'提交失败');
			}else{
				$this->res(0,'提交成功');
			}	
		}
	break;
}


include $this->template($do.'/'.$op);
?>