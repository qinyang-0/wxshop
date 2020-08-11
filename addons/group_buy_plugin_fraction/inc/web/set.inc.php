<?phpheader("Content-type:text/html;charset=utf-8");global $_W,$_GPC;$do = $_GPC['do'];$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];switch($op){	case 'index':		$tumb = $this->sc('tumb');
		$status = $this->sc('status');	break;
	case 'add':		if($_GPC['in'] == 'add'){			$this->config($_POST);			$op = 'index';		}		$tumb = $this->sc('tumb');		$status = $this->sc('status');//		header("Location :".$this->createWebUrl('set'));//		echo '<script>location.reload();</script>';	break;	case 'save':		$res = pdo_update("gpb_goods",array('send_points'=>'0'),array('weid'=>$this->weid));		if($res){			$this->res(1,'清零成功');
		}else{			$this->res(2,'清零失败，请重试');		}	break;}


include $this->template('web/'.$do.'/'.$op);
?>