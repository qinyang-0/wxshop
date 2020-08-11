<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$id = $_GPC['id'];
$index=isset($_GPC['page'])?$_GPC['page']:1;

switch($op){
	case 'index':
		$info = pdo_get($this->gpb_article,array('id'=>$id));
	break;
	case 'list':
		$pageIndex = $index;
		$pageSize = 20;
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_article)." where weid = ".$this->weid." and status = 1 ");	
		$page = pagination($total,$pageIndex,$pageSize);
		$sql = 'select * from ' . tablename($this->gpb_article)." where weid = ".$this->weid." and status = 1  order by sort asc ";
		$info = pdo_fetchall($sql.$contion);
		if($_GPC['code'] == 1){
			if(!empty($info)){
				foreach($info as $k=>$v){
					$info[$k]['time'] = date('Y-m-d',$v['time']);
				}
			}
			$this->res(0,$info);
		}
	break;
}
include $this->template($do.'/'.$op);
?>