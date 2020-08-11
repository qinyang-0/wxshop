<?php
/*
 * 插件管理
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块

switch($op){
	case 'index':
        $name = $_GPC['name'];
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        //迫于无赖手动写入插件和主模块关联
        $is_have_group_buy_plugin_distribution = pdo_get('modules_plugin',array('name'=>'group_buy_plugin_distribution','main_module'=>'group_buy'));
        if(empty($is_have_group_buy_plugin_distribution)){
            pdo_insert('modules_plugin',array('name'=>'group_buy_plugin_distribution','main_module'=>'group_buy'));
        }
        $is_have_group_buy_plugin_fraction = pdo_get('modules_plugin',array('name'=>'group_buy_plugin_fraction','main_module'=>'group_buy'));
        if(empty($is_have_group_buy_plugin_fraction)){
            pdo_insert('modules_plugin',array('name'=>'group_buy_plugin_fraction','main_module'=>'group_buy'));
        }
        //判断是否有插件数据
        $is_have_fraction = pdo_get('gpb_plug',array('key'=>'group_buy_plugin_fraction','status'=>1,'is_del'=>1));//积分商城
        $is_have_distribution = pdo_get('gpb_plug',array('key'=>'group_buy_plugin_distribution','status'=>1,'is_del'=>1));//分销
        $is_have_seckill = pdo_get('gpb_plug',array('key'=>'group_buy_plugin_seckill','status'=>1,'is_del'=>1));//秒杀
        $is_have_bargain = pdo_get('gpb_plug',array('key'=>'group_buy_plugin_bargain','status'=>1,'is_del'=>1));//砍价
        $is_have_team = pdo_get('gpb_plug',array('key'=>'group_buy_plugin_team','status'=>1,'is_del'=>1));//拼团

        if(empty($is_have_fraction)){
            pdo_run("insert  into ".tablename('gpb_plug')." (`cate`,`name`,`add_time`,`icon`,`comment`,`plug_order`,`status`,`is_del`,`key`,`url`,`buy_url`) values 
(0,'积分商城',NULL,'/addons/group_buy/public/bg/fraction.png','',1,1,1,'group_buy_plugin_fraction','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_fraction&version_id=0','https://s.w7.cc/module-17917.html');");
        }else{
			pdo_update($this->plug,array('buy_url'=>'https://s.w7.cc/module-17917.html'),array('id'=>$is_have_fraction['id']));
		}
        if(empty($is_have_distribution)){
            pdo_run("insert  into ".tablename('gpb_plug')." (`cate`,`name`,`add_time`,`icon`,`comment`,`plug_order`,`status`,`is_del`,`key`,`url`,`buy_url`) values 
(0,'分销商城',NULL,'/addons/group_buy/public/bg/distribution.png','',2,1,1,'group_buy_plugin_distribution','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_distribution&version_id=0',NULL);");
        }
        if(empty($is_have_seckill)){
            pdo_run("insert  into ".tablename('gpb_plug')." (`cate`,`name`,`add_time`,`icon`,`comment`,`plug_order`,`status`,`is_del`,`key`,`url`,`buy_url`) values 
(0,'整点秒杀',NULL,'/addons/group_buy/public/bg/seckill.png','',3,1,1,'group_buy_plugin_seckill','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_seckill&version_id=0','https://s.w7.cc/module-19790.html');");
        }
		if(empty($is_have_bargain) && file_exists("../addons/group_buy_plugin_bargain/hook.php")){
			 pdo_run("insert  into ".tablename('gpb_plug')." (`cate`,`name`,`add_time`,`icon`,`comment`,`plug_order`,`status`,`is_del`,`key`,`url`,`buy_url`) values 
(0,'砍价',NULL,'/addons/group_buy_plugin_bargain/icon.jpg','',3,1,1,'group_buy_plugin_bargain','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_bargain&version_id=0','https://s.w7.cc/module-22997.html');");
		}
		if(empty($is_have_team) && file_exists("../addons/group_buy_plugin_team/hook.php")){
			pdo_run("insert  into ".tablename('gpb_plug')." (`cate`,`name`,`add_time`,`icon`,`comment`,`plug_order`,`status`,`is_del`,`key`,`url`,`buy_url`) values 
(0,'拼团',NULL,'/addons/group_buy_plugin_team/icon.png','',3,1,1,'group_buy_plugin_team','./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_team&version_id=0','https://s.w7.cc/module-23139.html');");
		}
//		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
//		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->plug)." where status =1 and is_del = 1");
//		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$menus = pdo_get($this->menu,array('uid'=>$_W['uid']));
        if($menus){
        	$menus_str = explode(',',$menus['value']);
        }
		$sql = 'select * from '.tablename($this->plug)." where status = 1 and is_del = 1 order by plug_order desc,id desc ".$contion;
		$info = pdo_fetchall($sql);
        $filename = tomedia('/addons/group_buy/inc/api/plug.php');
		$contents = $this->http_request($filename);
		$contents = json_decode($contents,true);
		$str = 'a,';
		if($info){
			foreach($info as $k=>$v){
				$str .= $v['key'].",";
			}
			$str = trim($str,',');
		}
		$is = 9999;
		if($contents && $str){
			foreach($contents as $k=>$v){
				if($v['info']){
					foreach($v['info'] as $kk=>$vv){
						$is = $is-1;
						if(strpos($str,$vv['eng_name'])){
							$contents[$k]['info'][$kk]['is_show'] = 1;
						}
						if($info){
							foreach($info as $ki=>$vi){
							    if($vi['key'] == $vv['eng_name']){
	                                $contents[$k]['info'][$kk]['url'] = $vi['url'];
	                            }
	                        }
						}
						
						if($_W['uid'] != 1){
							if($menus_str){
								foreach($menus_str as $kks=>$vvs){
									if($is == $vvs){
										$contents[$k]['info'][$kk]['chenk'] = 'chencked';
										break;
									}
								}
							}
							if(empty($contents[$k]['info'][$kk]['chenk'])){
								unset($contents[$k]['info'][$kk]);
							}
						}
					}
				}
			}
		}
		foreach($contents as $k=>$v){
			if(empty($v['info'])){
				unset($contents[$k]);
			}	
		}
//		$info[$num]['id'] = 0001;
//		$info[$num]['name'] = '积分签到';
//		$info[$num]['url'] = $this->createWebUrl('plsugins',array("op"=>'sign'));
//		$info[$num]['icon'] = '/addons/group_buy/public/bg/sign.png';
//		$info[$num+1]['id'] = 0002;
//		$info[$num+1]['name'] = '会员充值';
//		$info[$num+1]['url'] = $this->createWebUrl('plsugins',array("op"=>'card'));
//		$info[$num+1]['icon'] = '/addons/group_buy/public/bg/sign.png';
	break;
    case 'setBuyUrl':
        $code = $_GPC['code'];
        $key = $_GPC['key'];
        $url = $_GPC['url'];
        if($code == 9633){
            pdo_update($this->plug,array('buy_url'=>$url),array('key'=>$key));
            $res = pdo_getall($this->plug);
            var_export($res);
            exit('success');
        }else{
            exit('no auth');
        }
        break;

}
include $this -> template('web/' . $do . '/' . $op);
?>