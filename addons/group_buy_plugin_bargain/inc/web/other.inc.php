<?php

global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块

switch($op){
	case 'index':
//		全局砍价规则设置
		if($_GPC['token'] == 'submit'){
			pdo_begin();
            foreach($_POST as $k=>$v){
				$info = pdo_get($this->config,['name'=>$k,'weid'=>$weid]);
				if(is_array($v)){
					$value = serialize($v);
				}else{
					$value = trim($v);
				}
				if(!empty($value)){
					if(empty($info)){
						//添加
						$data = ['name'=>$k,'value'=>$value,'weid'=>$weid,'type'=>'26','key'=>$k];
						$res = pdo_insert($this->config,$data);
					}else{
						//修改
						$res = pdo_update($this->config,['value'=>$value,'key'=>$k],['name'=>$k,'weid'=>$weid]);
					}
				}
			}
            pdo_commit();
//			if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('other'), 'success');
//          } else {
//              $this->message_info("修改配置失败");
//          }
		} else {
			$info = pdo_getall($this->config,array('type'=>26,'weid'=>$weid));
			$arr = [];
			if($info){
				foreach($info as $k=>$v){
					$arr[$v['name']] = $v['value'];
				}
			}
		}
	break;
}

include $this -> template('web/' . $do . '/' . $op);
?>