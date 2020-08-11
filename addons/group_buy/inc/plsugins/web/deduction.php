<?php

switch($in){
	case 'index':
		//余额配置信息
		$info = pdo_getall($this->config,['status'=>1,'type'=>29,'weid'=>$weid]);
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
				$config = pdo_get($this->config,array('status'=>1,'type'=>29,'weid'=>$weid,'key'=>$k),array(),'id');
				if($config){
					pdo_update($this->config,array('status'=>1,'type'=>29,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()),array('id'=>$config['id']));
				} else {
					pdo_insert($this->config,array('status'=>1,'type'=>29,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()));
				}
			}
			$this->message_info('操作成功', $this->createWebUrl('plsugins',['op'=>'deduction']), 'success');
		} else {
			$this->message_info('未做出任何修改');
		}
	break;
}
?>