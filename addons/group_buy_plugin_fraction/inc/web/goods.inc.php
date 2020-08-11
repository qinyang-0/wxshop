<?php
header("Content-type:text/html;charset=utf-8");
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$in = empty($_GPC['in']) ? 'index' : $_GPC['in'];
$index=isset($_GPC['page'])?$_GPC['page']:1;
$id = $_GPC['id'];
$goods_cate = pdo_getall($this->gpb_goods_cate,array('gc_pid'=>0,'weid'=>$this->weid,'gc_is_del'=>1,'type'=>2));
//echo $this->weid;exit;
switch($op){
	case 'index':
		if(!empty($goods_cate)){
			foreach($goods_cate as $k=>$v){
				$data = pdo_getall($this->gpb_goods_cate,array('weid'=>$this->weid,'gc_is_del'=>1,'gc_pid'=>$v['gc_id'],'type'=>2), array() , '' , 'gc_order asc');
				$goods_cate[$k]['data'] = $data;
			}
		}
		$from = $_GET;
		$where = " ";
		if(!empty($from['g_cid'])){
			$where .= ' and g_cid = '.$from['g_cid'];
		}
		if(!empty($from['g_is_online'])){
			$where .= ' and g_is_online = '.$from['g_is_online'];
		}
		if(!empty($from['g_name'])){
			$where .= " and g_name like '%".$from['g_name']."%'";
		}
		//商品
		$pageIndex = $index;
        $pageSize = $this->pageSize;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_goods)." where weid = ".$this->weid." and type = 2 and g_is_del = 1 ".$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename($this->gpb_goods)." where weid = ".$this->weid." and type = 2 and g_is_del = 1 ".$where." order by g_order asc ".$contion;
		$info = pdo_fetchall($sql);
	break;
	case 'add':
		//新增商品
		if(!empty($goods_cate)){
			foreach($goods_cate as $k=>$v){
				$data = pdo_getall($this->gpb_goods_cate,array('weid'=>$this->weid,'gc_is_del'=>1,'gc_pid'=>$v['gc_id'],'type'=>2), array() , '' , 'gc_order asc');
				$goods_cate[$k]['data'] = $data;
			}
		}
		if($_POST['type'] == 1){
			if($_POST['integral'] <= 0){
				$this->res(1,'商品兑换积分不能小于0');
			}
			$_POST['weid'] = $this->weid;
			$_POST['type'] = 2;
			$num = $_POST['num'];
			unset($_POST['num']);
			unset($_POST['id']);
			unset($_POST['goods']);
			$_POST['g_add_time'] = time();
			if($_POST['g_thumb']){
				$_POST['g_thumb'] = implode(',', $_POST['g_thumb']);
			}
			$_POST['g_info'] = $_POST['g_info'];
			$_POST['limit'] = $_POST['limit'] ? $_POST['limit'] : 0;
			$_POST['g_express_shipping_id'] = 0;
 			if(!empty($id)){
				//修改
//				$_POST['g_update_time'] = time();
				$res = pdo_update($this->gpb_goods,$_POST,array('g_id'=>$id));
			}else{
				$go_cs = pdo_get($this->gpb_goods,array('g_product_num'=>$_POST['g_product_num'],'weid'=>$this->weid));
				if(!empty($go_cs)){
					$this->res(1,'商品货号已存在');
				}
				//新增
				$res = pdo_insert($this->gpb_goods,$_POST);
				$id = pdo_insertid();
			}
			//单规格
			//只将库存放在另一张表就行
			$rs = pdo_get($this->gpb_goods_stock,array('goods_id'=>$id,'weid'=>$this->weid));
			if($rs){
				//修改
				pdo_update($this->gpb_goods_stock,array('num'=>$num),array('gs_id'=>$rs['gs_id']));
			}else{
				//新增
				pdo_insert($this->gpb_goods_stock,array('num'=>$num,'goods_id'=>$id,'weid'=>$this->weid));
			}
			//成功  
			$this->res(0,'操作成功');

		}else{
			if(!empty($id)){
				$info = pdo_get($this->gpb_goods,array('g_id'=>$id));
				$info['g_info'] = $info['g_info'];
				if(!empty($info['g_thumb'])){
					$info['g_thumb'] = explode(',',$info['g_thumb']);
				}
				//获取库存
				$num = pdo_get($this->gpb_goods_stock,array('goods_id'=>$id,'weid'=>$this->weid));
				$info['num'] = $num['num'];
				if($_GPC['type'] == 10){
					unset($info['g_id']);
				}
			}
		}
	break;
	case 'state':
		$id = $_GPC['goods_id'];//商品id
		if(empty($id)){
			$this->res(1,'请传入商品id');
		}
		$state = $_GPC['state'];
		if(empty($state)){
			$this->res(1,'请传入修改的状态码');
		}
		$res = pdo_update($this->gpb_goods,array($_GPC['type']=>$state),array('g_id'=>$id));
		if($res){
			$this->res(0,'更新成功');
		}else{
			$this->res(1,'更新失败');
		}
	break;
	case 'delete':
		if(empty($id)){
			$this->res(1,'请传入要删除的id');
		}
		$res = pdo_update($this->gpb_goods,array('g_is_del'=>-1),array('g_id'=>$id));
		if($res){
			$this->res(0,'删除成功');
		}else{
			$this->res(1,'删除失败');
		}
	break;
	case 'class':
		//商品分类
		switch($in){
			case 'index':
		        $pageIndex = $index;
		        $pageSize = $this->pageSize;
				$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
				$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_goods_cate)." where weid = ".$this->weid." and gc_is_del = 1 and gc_pid = 0 and type =2 ");
				$page = pagination($total,$pageIndex,$pageSize);
				//获取分页信息
				$sql = 'select * from '.tablename($this->gpb_goods_cate)." where weid = ".$this->weid." and gc_is_del = 1 and gc_pid = 0 and type =2 order by gc_order asc ".$contion;
				$info = pdo_fetchall($sql);
				if(!empty($info)){
					foreach($info as $k=>$v){
						$data = pdo_getall($this->gpb_goods_cate,array('weid'=>$this->weid,'gc_is_del'=>1,'gc_pid'=>$v['gc_id'],'type'=>2), array() , '' , 'gc_order asc');
						$info[$k]['data'] = $data;
					}
				}
			break;
			case 'add':
				//新增分类
				if($_GET['type'] == 1){
					if(empty($_POST['gc_name'])){
						$this->res(1,'请填写分类名称',[]);
					}
					if(empty($_POST['gc_order'])){
						$this->res(1,'请填写排序',[]);
					}
					$id = $_POST['gc_id'];
					$_POST['gc_name'] = trim($_POST['gc_name']);
					$_POST['weid'] = $this->weid;
					$_POST['gc_add_time'] = time();
					$_POST['type'] = 2;
					$_POST['gc_pid'] = 0;
					unset($_POST['gc_id']);
//					echo '<pre>';
//					print_r($_POST);exit;
					if($id){
						//修改
						$_POST['gc_update_time'] = time();
						$res = pdo_update($this->gpb_goods_cate,$_POST,array('gc_id'=>$id));
					}else{
						//新增
						$res = pdo_insert($this->gpb_goods_cate,$_POST);
					}
					if($res){
						$this->res(0,'操作成功');
					}else{
						$this->res(1,'操作失败');
					}
				}else{
					//存在id  代表修改
					if(!empty($id)){
						$info = pdo_get($this->gpb_goods_cate,array('gc_id'=>$id,'weid'=>$this->weid,'gc_is_del'=>1));
					}
//					pdo_fetchall("select * from ".tablename($this->gpb_goods_cate)." where type = 2 and gc_pid = 0 and gc_status = 1 and gc_is_del = 1 and weid = ".$this->weid);
				}
			break;
			case 'delete':
				if(empty($id)){
					$this->res(1,'请传入要删除的id');
				}
				$res = pdo_update($this->gpb_goods_cate,array('gc_is_del'=>-1),array('gc_id'=>$id));
//				$res = pdo_delete($this->gpb_goods_cate,array('gc_id'=>$id));
				if($res){
					$this->res(0,'删除成功');
				}else{
					$this->res(1,'删除失败');
				}
			break;
		}
	break;
}
include $this->template('web/'.$do.'/'.$op.'/'.$in);
?>