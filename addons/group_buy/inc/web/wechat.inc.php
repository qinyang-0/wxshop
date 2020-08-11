<?php

/*
 * 微信公众管理
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
$_GPC['do'] = 'config';
//echo '<a href="'.$this->createMobileUrl('index').'" target="_blank">跳转</a>';exit;

switch($op){
	case 'index':
		$info = pdo_getall($this->config,['status'=>1,'type'=>18,'weid'=>$weid]);
		if($info){
			$data = [];
			foreach($info as $k=>$v){
				$data[$v['key']] = $v['value'];
			}
		}
		$info = $data;
	break;
	case 'add':
		$post = $_POST;
		unset($post['submit']);
		if($post){
			foreach($post as $k=>$v){
				$config = pdo_get($this->config,array('status'=>1,'type'=>18,'weid'=>$weid,'key'=>$k),array(),'id');
				if($config){
					pdo_update($this->config,array('status'=>1,'type'=>18,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()),array('id'=>$config['id']));
				}else{
					pdo_insert($this->config,array('status'=>1,'type'=>18,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()));
				}
			}
			$this->message_info('操作成功', $this->createWebUrl('wechat'), 'success');
		}else{
			$this->message_info('未做出任何修改');
		}
	break;
}

include $this -> template('web/' . $do . '/' . $op);		
?>