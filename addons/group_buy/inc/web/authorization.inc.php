<?php


global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
$sq = "sq.scmmwl.com";
$config = pdo_get("gpb_config",['key'=>'appid','weid'=>$this->weid]);
$appid = $config['value'];
if(empty($appid)){
	$this->message_info('请填写appid',$this->createWebUrl('config'));exit;
}
$name_title = pdo_get("gpb_config",array('key'=>'back_title_set','weid'=>$this->weid));
header("Content-type:text/html; charset=utf-8");
switch($op){
	case 'index':
		//判断是否是授权过的
		$url = $sq."/upload/third.php?op=authorization&id=".$appid;
		$info = $this->http_request($url);
		$info = json_decode($info,true);
		if($info['code'] == 1 && empty($_GPC['sq'])){
			//线上版本
			$url = $sq."/upload/third.php?op=latest_version&id=".$appid;
			$infos = $this->http_request($url);
			$infos = json_decode($infos,true);
			$infos = $infos['data'];
			//成功授权  显示线上版本和最新版本
			//获取微信版本
			$version = pdo_fetch(" select * from ".tablename('gpb_auto')." where weid = ".$this->weid." order by id desc limit 0,1");
			if($version['version'] == $infos['name']){
				unset($infos);
			}

			if($version && $version['pid'] && $version['status'] != 4 && $version['status'] != 5){
				//查看是否审核成功
				$url = $sq."/upload/third.php?op=audit&id=".$appid;
				$category = $this->http_request($url,array('code'=>$version['pid']));
				$category = json_decode($category,true);
				if($category['errcode'] == 0){
					if($category['status'] == 1){
						//审核失败
						pdo_update('gpb_auto',array('content'=>$category['reason'],'status'=>3),array('id'=>$version['id']));
					}elseif($category['status'] === 0){
						//审核成功
						pdo_update('gpb_auto',array('status'=>4),array('id'=>$version['id']));
					}
				}
				$version = pdo_fetch(" select * from ".tablename('gpb_auto')." where weid = ".$this->weid." order by id desc limit 0,1");
			}
		} else {
			$info['code'] = 2;
			//未授权  需要先进行授权
			$url = $sq."/upload/third.php?op=index&id=".$appid;
			$infos = $this->http_request($url);
			$infos = json_decode($infos,true);
			if($infos['code'] == 2){
				//授权失败
				echo $infos['msg'];exit;
			}
			$href = base64_decode($infos['url']);
		}
	break;
	case 'authorization':
		$url = $sq."/upload/third.php?op=authorization&id=".$appid;
		$info = $this->http_request($url);
		echo $info;exit;
	break;
	case 'auto':
		//上传小程序
		//需要参数 1.weid 2.域名 3.appid 4.版本号
		$weid = $this->weid;
		$host = $_SERVER['HTTP_HOST'];
		$version = $_GPC['version'];
		$desc = $_GPC['desc'];
		if(empty($version)){
			echo json_encode(array('code'=>1,'msg'=>'请输入版本号'));exit;
		}
		//获取需要提交的跳转小程序
		$wxapp = pdo_get("wxapp_versions",array('uniacid'=>$this->weid));
		if($wxapp['tominiprogram']){
			$tomin = $wxapp['tominiprogram'];
			$tomin = unserialize($tomin);
			$str = '';
			foreach($tomin as $k=>$v){
				$str .= "'".$k."',";
			}
			$str = trim($str,',');
		}
		$url = $sq."/upload/third.php?op=auto&id=".$appid;
		$arr = array(
			'weid'=>$weid,
			'host'=>$host,
			'version'=>$version,
			'desc'=>$desc,
			'appid'=>$appid,
			'str'=>$str,
		);
		$info = $this->http_request($url,$arr);
		$is = json_decode(trim($info,chr(239).chr(187).chr(191)),true);
		if($is['code'] == 1){
			$title = pdo_get('gpb_config',array('key'=>'back_title_set','weid'=>$this->weid));
			$array = array(
				'name'=>$title['value'],
				'version'=>$version,
				'desc'=>$desc,
				'time3'=>time(),
				'weid'=>$this->weid,
			);
			$res = pdo_insert("gpb_auto",$array);
			//提交审核
			$url = $sq."/upload/third.php?op=category&id=".$appid;
			$category = $this->http_request($url);
			$cate = json_decode($category,true);
			$category = $cate['msg'];
			$url = $sq."/upload/third.php?op=config&id=".$appid;
			$config = $this->http_request($url);
			$config = json_decode($config,true);
			$config = $config['msg'];

			$arr = [];
			$arr['pages'] = $config[0];
			$arr['title'] = '首页';
			$arr['category'] = $category[0]['first_id'];
			$arr['value'] = $category[0]['second_id'];
			$arr['first'] = $category[0]['first_class'];
			$arr['second'] = $category[0]['second_class'];
			$arr['id'] = $appid;
			$url = $sq."/upload/third.php?op=examine&id=".$appid;
			$res = $this->http_request($url,$arr);
			$info = json_decode($res,true);
			if($info['errcode'] != 1){
				echo $res;exit;
			} else {
				//将数据提交上去  更新表
				$infos = pdo_fetch(" select id from ".tablename('gpb_auto')." where weid = ".$this->weid." order by id desc limit 0,1");
				$res = pdo_update('gpb_auto',array('status'=>2,'time1'=>time(),'pid'=>$info['auditid']),array('id'=>$infos['id']));
			}
		}
		echo json_encode($info);exit;
	break;
	case 'examine':
		//获取已经提交审核了的  去查询审核状态
		$auto = pdo_getall('gpb_auto',array('weid'=>$this->weid,'status'=>2));
		if(!empty($auto)){
			$url = $sq."/upload/third.php?op=audit&id=".$appid;
			foreach($auto as $k=>$v){
				$category = $this->http_request($url,array('code'=>$v['pid']));
				$category = json_decode($category,true);
				if($category['errcode'] == 0){
					if($category['status'] == 1){
						//审核失败
						pdo_update('gpb_auto',array('content'=>$category['reason'],'status'=>3),array('id'=>$v['id']));
					}else{
						//审核成功
						pdo_update('gpb_auto',array('status'=>4),array('id'=>$v['id']));
					}
				}
			}
		}
		$info = pdo_fetchall(" select * from ".tablename('gpb_auto')." where weid = ".$this->weid." order by id desc limit 0,1");
	break;
	case 'release':
		//用户提交审核
		//需要参数 1.address2.tag3.first_class4.first_id5.title6.
		//提交审核
		$url = $sq."/upload/third.php?op=category&id=".$appid;
		$category = $this->http_request($url);
		$cate = json_decode($category,true);
		$category = $cate['msg'];
		$url = $sq."/upload/third.php?op=config&id=".$appid;
		$config = $this->http_request($url);
		$config = json_decode($config,true);
		$config = $config['msg'];

		$arr = [];
		$arr['pages'] = $config[0];
		$arr['title'] = '首页';
		$arr['category'] = $category[0]['first_id'];
		$arr['value'] = $category[0]['second_id'];
		$arr['first'] = $category[0]['first_class'];
		$arr['second'] = $category[0]['second_class'];
		$arr['id'] = $appid;
		$url = $sq."/upload/third.php?op=examine&id=".$appid;
		$res = $this->http_request($url,$arr);
		$info = json_decode($res,true);
		if($info['errcode'] == 0){
			//将数据提交上去  更新表
			$infos = pdo_fetch(" select id from ".tablename('gpb_auto')." where weid = ".$this->weid." order by id desc limit 0,1");
			$res = pdo_update('gpb_auto',array('status'=>2,'time1'=>time(),'pid'=>$info['auditid']),array('id'=>$infos['id']));
		}
		echo $res;exit;
	break;
	case 'preview':
		$url = $sq."/upload/third.php?op=preview&id=".$appid;
		$category = $this->http_request($url);
		echo $category;exit;
	break;
	case 'releases':
		$url = $sq."/upload/third.php?op=release&id=".$appid;
		$release = $this->http_request($url);
		$release = json_decode($release,true);
		if(!empty($release) && $release['errcode'] === 0){
			//发布成功
			$infos = pdo_fetch(" select id from ".tablename('gpb_auto')." where weid = ".$this->weid." order by id desc limit 0,1");
			$res = pdo_update('gpb_auto',array('status'=>5,'time2'=>time()),array('id'=>$infos['id']));
		}
		echo json_encode($release);exit;
	break;
}
include $this -> template('web/' . $do . '/' . $op);
?>