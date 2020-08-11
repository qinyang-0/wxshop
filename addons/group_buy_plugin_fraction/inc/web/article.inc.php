<?php
header("Content-type:text/html;charset=utf-8");
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$id = $_GPC['id'];
$index=isset($_GPC['page'])?$_GPC['page']:1;
switch($op){
	case 'index':
		//列表
		$from = $_GET;$where = '';
		if($from['title']){
			$where .= " and title like '%".$from['title']."%'";
		}
		$pageIndex = $index;
        $pageSize = $this->pageSize;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_article)." where weid = ".$this->weid." and status = 1 ".$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename($this->gpb_article)." where weid = ".$this->weid." and status = 1 ".$where." order by time asc ".$contion;
		$info = pdo_fetchall($sql);
	break;
	case 'add':
		//新增修改
		if($_GPC['type'] == 10){
			//开始
			if(empty($_GPC['title'])){
				$this->res(1,'请输入文章标题');
			}
			if(empty($_GPC['body'])){
				$this->res(1,'请输入文章内容');
			}
			if(empty($_GPC['sort'])){
				$this->res(1,'请输入排序');
			}
			$create = $_GPC['createtime'];
			if($create){
				$create = strtotime($create);
			}else{
				$create = time();
			}
			$data = [
				'weid'=>$this->weid,
				'title'=>$_GPC['title'],
				'body'=>$_GPC['body'],
				'sort'=>$_GPC['sort'],
				'createtime'=>$create,
			];
			if($id){
				$res = pdo_update($this->gpb_article,$data,array('id'=>$id));
			}else{
				$data['time'] = time();
				$res = pdo_insert($this->gpb_article,$data);
			}
			if($res){
				$this->res(0,'操作成功');
			}else{
				$this->res(1,'操作失败');
			}
		}else{
			if($id){
				$info = pdo_get($this->gpb_article,array('id'=>$id,'weid'=>$this->weid));
			}
		}
	break;
	case 'delete':
		//删除
		if(empty($id)){
			$this->res(1,'请传入等级id');
		}
		$res = pdo_update($this->gpb_article,array('status'=>-1),array('id'=>$id,'weid'=>$this->weid));
		if(!empty($res)){
			$this->res(0,'删除成功');
		}else{
			$this->res(1,'删除失败');
		}
	break;
}
include $this->template('web/'.$do.'/'.$op);
?>