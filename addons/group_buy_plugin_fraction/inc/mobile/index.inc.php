<?php
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$index=isset($_GPC['page'])?$_GPC['page']:1;
//轮播图片

$tumb = $this->sc('tumb');

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

$banner = $this->sc('thumb');
//获取文章标题
$time = time();
$sql = "select id,title,time from ".tablename($this->gpb_article)." where weid = ".$this->weid." and createtime <= ".$time." and status = 1 ";
$article = pdo_fetchall($sql);
//echo $sql;exit;
//获取推荐商品
$pageIndex = $index;
$pageSize = $this->pageSize;
$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_goods)." where weid = ".$this->weid." and g_is_del = 1 and type = 2 and g_is_recommand = 1 and g_is_online = 1");	
$page = pagination($total,$pageIndex,$pageSize);
	
$sql = 'select * from ' . tablename($this->gpb_goods)." where weid = ".$this->weid." and g_is_del = 1 and type = 2 and g_is_recommand = 1 and g_is_online = 1 order by g_order asc";
$info = pdo_fetchall($sql.$contion);
if($_GPC['code'] == 1){
	$str = $this->flow($info);
	$this->res(0,$str,$info);
}
include $this->template($do.'/'.$op);
?>