<?php
header("Content-type:text/html;charset=utf-8");
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$id = $_GPC['id'];
$index=isset($_GPC['page'])?$_GPC['page']:1;

switch($op){
	case 'index':
		$where = '';
		if($_GPC['status']){
			$where .= ' and m.code = '.$_GPC['status'];	
		}
		if($_GPC['star_time']){
			$where .= ' and m.time >= '.strtotime($_GPC['star_time']);
		}
		if($_GPC['end_time']){
			$where .= ' and m.time <= '.strtotime($_GPC['end_time']);
		}
		$pageIndex = $index;
		$pageSize = 30;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_mail)." m join ".tablename($this->gpb_member)." me on m.m_id = me.m_id where m.weid = ".$this->weid.$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select m.*,me.m_nickname,me.m_phone from ' . tablename($this->gpb_mail)." m join ".tablename($this->gpb_member)." me on m.m_id = me.m_id where m.weid = ".$this->weid.$where." order by m.time desc ".$contion;
		$info = pdo_fetchall($sql);
	break;
	case 'feedback':
		$pageIndex = $index;
		$pageSize = 30;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_feed_back)." m join ".tablename($this->gpb_member)." me on m.m_id = me.m_id where m.weid = ".$this->weid.$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select m.*,me.m_nickname,me.m_phone from ' . tablename($this->gpb_feed_back)." m join ".tablename($this->gpb_member)." me on m.m_id = me.m_id where m.weid = ".$this->weid.$where." order by m.time desc ".$contion;
		$info = pdo_fetchall($sql);
		if(!empty($info)){
			foreach($info as $k=>$v){
				$info[$k]['content'] = unserialize($v['content']);
				$info[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
			}
		}
	break;
	case 'add':
		if($_GPC['type'] == 'add'){
			$phone = $_GPC['phone'];
			$content = $_GPC['content'];
			if($phone === ''){
				$this->res(1,'请填写发送用户');
			}
			if(empty($content)){
				$this->res(1,'请填写发送内容');
			}
			$this->mail_list($phone,$content);
			$this->res(0,'发送成功');
		}
	break;
}

include $this->template('web/'.$do.'/'.$op);
?>