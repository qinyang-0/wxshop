<?php


switch($in){
	case 'index':
		//配送
		$info = pdo_getall($this->config,['status'=>1,'type'=>30,'weid'=>$weid]);
		if($info){
			$data = [];
			foreach($info as $k=>$v){
				if($v['value'] == serialize(unserialize($v['value']))){
					$data[$v['key']] = unserialize($v['value']);
				}else{
					$data[$v['key']] = $v['value'];
				}
			}
		}
		$info = $data;
	break;
	case 'add':
		$data = $_POST;
		$str = [];
		if($data['star_time']){
			foreach($data['star_time'] as $k=>$v){
				$str[$k]['star_time'] = $v;
				$str[$k]['end_time'] = $data['end_time'][$k];
			}
		}
		$data['delivery_time'] = array(
			'value'=>serialize($str),
			'name'=>'配送具体时间'
		); 
		unset($data['star_time']);
		unset($data['end_time']);
		unset($data['submit']);
		if($data){
			foreach($data as $k=>$v){
				$config = pdo_get($this->config,array('status'=>1,'type'=>30,'weid'=>$weid,'key'=>$k),array(),'id');
				if($config){
					pdo_update($this->config,array('status'=>1,'type'=>30,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()),array('id'=>$config['id']));
				} else {
					pdo_insert($this->config,array('status'=>1,'type'=>30,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()));
				}
			}
			$this->message_info('操作成功', $this->createWebUrl('plsugins',['op'=>'delivery']), 'success');
		} else {
			$this->message_info('未做出任何修改');
		}
	break;
}
?>