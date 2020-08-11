<?php

//diy  接口文件.
global $_W, $_GPC;
$op = $_GPC['op'];
$weid = $this->weid;  //控制模块
$http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
$http .= $_SERVER['HTTP_HOST'].'/attachment/';
switch($op){
	//选择模板
	case 'template':
		$sql = " select p.*,t.name from ".tablename($this->diy_page)." p right join ".tablename($this->diy_temp)." t on p.tempid = t.id where (p.weid = ".$this->weid." or p.system = 2 ) and p.status =1 ";
//		$sql = " select * from ".tablename($this->page)." where (weid = ".$this->weid." or system = 2 ) and status = 1";
		$list = pdo_fetchall($sql);
		if(!empty($list)){
			foreach($list as $k=>$v){
//				$name = pdo_get($this->temp,array('id'=>$v['tempid']));
//				$list[$k]['name'] = $name['name'];
				$list[$k]['content'] = unserialize($v['content']);
			}
		}
		echo json_encode(array('code'=>1,'msg'=>'','data'=>$list));exit;
	break;

}

?>