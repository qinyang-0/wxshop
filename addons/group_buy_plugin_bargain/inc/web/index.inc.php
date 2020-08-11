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
		//根据状态码显示不同信息的砍价信息
		$status = empty($_GPC['status']) ? 1 : $_GPC['status'];
//		显示是3个状态码的信息 1.砍价中，2.未开始，3.已结束
		$wherer = '';
		$time = time();
		switch($status){
			case '1':
				$where .= " and status_time < ".$time." and end_time > ".$time;
			break;
			case '2':
				$where .= " and status_time > ".$time." and end_time > ".$time;
			break;
			case '3':
				$where .= " and status_time < ".$time." and end_time < ".$time;
			break;
		}
		if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
            $where .= " and g.g_name like '%".trim($_GPC['name'])."%' ";
        }
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn("select count(*) from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 ".$where);
		$page = pagination($total,$pageIndex,$pageSize);
		$info = pdo_fetchall("select bg.id,g.g_id,g.g_name,g.g_price,g.g_icon,bg.end_time,bg.end_price,st.num,bg.status_time from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id join ".tablename('gpb_goods_stock')." st on st.goods_id = g.g_id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 ".$where.$contion);
		if($info){
			foreach($info as $k=>$v){
				$info[$k]['end_time'] = friendlyDate($v['end_time']);
				//获取每个商品的发起次数
				$count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_bargain_action')." where goods_id = ".$v['g_id'].' and weid ='.$this->weid);
				$info[$k]['count'] = $count;
			}
		}
	break;
	case 'add':
		if($_GPC['token'] == 'submit'){
			$data = $_POST;
			$data['g_id'] = $id;
			$goods = pdo_get("gpb_goods",array('g_id'=>$id),array('g_id','g_name','g_icon','g_price','g_has_option'));
			$data['status_time'] = strtotime($data['times']['start']);
			$data['end_time'] = strtotime($data['times']['end']);
			if(empty($id)){
				sucs(2,'请选择砍价商品');
			}
			$res = goods_activity($id,3,$this->weid);
			if($res !== true){
				sucs(2,$res);
			}
			if(!isset($data['end_price'])){
				sucs(2,'请填写商品低价');
			}
			if($data['end_price'] >= $goods['g_price']){
				sucs(2,'商品低价不能大于等于商品标价');
			}
			if(!isset($data['total_pople'])){
				sucs(2,'请填写砍价人数');
			}
			if(empty($data['min_money']) || empty($data['max_money']) || empty($data['probability'])){
				sucs(2,'请填写商品砍价规则');
			}
			$arr = [];
			
			if($data['min_money']){
//				probability 前多少人
//				min_money  砍多少
//				max_money  到多少
//				min_money_surplus 后面的人 看多少
//				max_money_surplus 到多少
				$arr = [
					'probability'=>$_GPC['probability'],
					'min_money'=>$_GPC['min_money'],
					'max_money'=>$_GPC['max_money'],
					'min_money_surplus'=>$_GPC['min_money_surplus'],
					'max_money_surplus'=>$_GPC['max_money_surplus'],
				];
//				foreach($data['min_money'] as $k=>$v){
//					$arr[$k]['min_money'] = $v;
//					$arr[$k]['max_money'] = $data['max_money'][$k];
//					$arr[$k]['probability'] = $data['probability'][$k];
//				}
			}
			$arr = base64_encode(serialize($arr));
			$data['content'] = $arr;
			$data['weid'] = $this->weid;
			$data['total_pople'] = empty($data['total_pople']) ? 0 : $data['total_pople'];
			$data['time_limit'] = empty($data['time_limit']) ? 0 : $data['time_limit'];
			$data['each_time'] = empty($data['each_time']) ? 1 : $data['each_time'];
			$data['launches'] = empty($data['launches']) ? 1 : $data['launches'];
			unset($data['token']);
			unset($data['min_money']);
			unset($data['max_money']);
			unset($data['min_money_surplus']);
			unset($data['max_money_surplus']);
			unset($data['probability']);
			unset($data['id']);
			unset($data['times']);
			unset($data['b_id']);
			$update = $data;
			if($_GPC['b_id']){
				//修改
				$res = pdo_update("gpb_bargaion_goods",$update,array('id'=>$_GPC['b_id']));
				if($res){
					gpb_log($_W['uid'].'修改砍价活动:id-'.$_GPC['b_id']."。参数：".base64_encode(serialize($update)));
				}
			} else {
				//新增
				$goods = pdo_get("gpb_bargaion_goods",array('g_id'=>$data['g_id'],'weid'=>$this->weid),array('id'));
				if($goods) {
					sucs(2,'该商品正在参与砍价，无需重复添加!');
				}
				$res = pdo_insert("gpb_bargaion_goods",$update);
				if($res){
					gpb_log($_W['uid'].'新增砍价活动:id-'.pdo_insertid());
				}
			}
			if($res){
				sucs(1,'操作成功');
			} else {
				echo '<pre>';
				pdo_debug();
				sucs(2,'操作失败');
			}
		}else{
			if($id){
				//编辑  注这个id是商品的id
				$goods = pdo_get("gpb_goods",array('g_id'=>$id),array('g_id','g_name','g_icon','g_price','g_has_option'));
				if($goods['g_has_option'] == 1 || empty($goods)){
					echo '<script>alert("商品信息错误");window.history.go(-1);</script>';exit;
				}
				$arr_time = [];
				if($_GPC['be_id']){
					//这个id是砍价的主键id
					$beagaion = pdo_fetch("select bg.*,g.g_id,g.g_name,g.g_price from ".tablename('gpb_goods')." g right join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and bg.status = 1 and id = ".$_GPC['be_id']);
					if($beagaion){
						$beagaion['times']['start'] = date('Y-m-d H:i:s',$beagaion['status_time']);
						$beagaion['times']['end'] = date('Y-m-d H:i:s',$beagaion['end_time']);
						$content = unserialize(base64_decode($beagaion['content']));
					}
				}
				if(empty($beagaion['times'])){
					$beagaion['times']['start'] = date('Y-m-d H:i:s',time());
					$beagaion['times']['end'] = date('Y-m-d H:i:s',time()+604800);
				}
			} else {
				//新增  新增显示上架商品
				$index=isset($_GPC['page'])?$_GPC['page']:1;
		        $pageIndex = $index;
		        $pageSize = 10;
				if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
		            $where .= " and g.g_name like '%".trim($_GPC['name'])."%' ";
		        }
//				$where .= " and g.g_has_option != 1";
				$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
				$total= pdo_fetchcolumn("select count(*) from ".tablename('gpb_goods')." g where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 ".$where);
				$page = pagination($total,$pageIndex,$pageSize);
				$info = pdo_fetchall("select bg.id,g.g_id,g.g_name,g.g_price,g.g_has_option,g.g_icon from ".tablename('gpb_goods')." g left join ".tablename('gpb_bargaion_goods')." bg on bg.g_id = g.g_id where g.g_is_online = 1 and g.g_is_del = 1 and g.type = 1 and g.weid = ".$weid.$where." order by g_order desc ".$contion);
			}
		}
	break;
	case 'del':
		if(empty($id)){
			sucs(2,'参数错误');
		}
		//判断是否还有正在进行的砍价
		$info = pdo_get('gpb_bargain_action',array('goods_id'=>$id,'status'=>0,'weid'=>$this->weid),array('id'));
		if($info){
			sucs(2,'有用户在参加该砍价活动，不能删除');
		}
		$res = pdo_delete("gpb_bargaion_goods",array('id'=>$id));
		if($res){
			gpb_log($_W['uid'].'删除砍价活动:id-'.$id);
			sucs(1,'删除成功');
		}else{
			sucs(2,'删除失败');
		}
	break;
	case 'select':
		if(empty($id)){
			$this->message_info('非法进入');
		}
		$time = time();
		//获取当前商品下面的砍价信息
		if($_GPC['name']) {
			$where .= " and ( a.nickname like '%".$_GPC['name']."%' or a.nickname like '%".base64_encode($_GPC['name'])."%')";
		}
		if($_GPC['online']){
			switch($_GPC['online']){
				case "1":
					//还在砍价中的
					$where .= " and a.end_time > ".$time;
				break;
				case "2":
					//砍价结束的  但是还没有购买的
					$where .= " and a.end_time <= ".$time." and order_id = 0";
				break;
				case "3":
					//砍价已够买的
					$where .= " and a.end_time <= ".$time." and order_id != 0";
				break;
			}
		}
		$where .= " and a.goods_id = ".$id;
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn("select count(*) from ".tablename('gpb_bargain_action')." a join ".tablename('gpb_bargaion_goods')." bg on a.goods_id = bg.g_id join ".tablename('gpb_goods')." g on g.g_id = bg.g_id where a.weid = ".$this->weid.$where);
		$page = pagination($total,$pageIndex,$pageSize);
		$info = pdo_fetchall("select a.*,g.g_name,g.g_icon,g.g_price,bg.end_price from ".tablename('gpb_bargain_action')." a join ".tablename('gpb_bargaion_goods')." bg on a.goods_id = bg.g_id join ".tablename('gpb_goods')." g on g.g_id = bg.g_id where a.weid = ".$this->weid.$where." order by a.create_time desc ".$contion);
		if($info){
			foreach($info as $k=>$v){
				$num = pdo_fetchcolumn("select count(*) from ".tablename('gpb_bargaion_record')." where ac_id = ".$v['id']);
				$info[$k]['num'] = $num;
				$nums = pdo_fetchcolumn("select count( DISTINCTROW openid ) from ".tablename('gpb_bargaion_record')." where ac_id = ".$v['id']);
				$info[$k]['nums'] = $nums;
				
			}
		}
		
		//获取已砍
		$bargaion_price = pdo_fetch("select sum(bargaion_price) as num from ".tablename('gpb_bargain_action')." where weid = ".$this->weid." and goods_id = ".$id);
		//获取已下单 数量
		$bargain_action_num = pdo_fetchcolumn("select count(*) from ".tablename('gpb_bargain_action')." where weid = ".$this->weid." and goods_id = ".$id." and status = 3 ");
		//获取总砍价次数
		$ac_id = pdo_fetch("SELECT GROUP_CONCAT(id) as id FROM ".tablename('gpb_bargain_action')." WHERE goods_id = ".$id);
		if($ac_id['id']){
			$gpb_bargaion_record = pdo_fetchcolumn("select count(*) from ".tablename('gpb_bargaion_record')." where ac_id in (".$ac_id['id'].")");
//			echo "select count(*) from ".tablename('gpb_bargaion_record')." where ac_id in (".$ac_id['id'].")";
//			var_dump($gpb_bargaion_record);exit;
		}else{
			$gpb_bargaion_record = 0;
		}
	break;
	case 'be_info';
		if(empty($id)){
			$this->message_info('非法进入');
		}
		$where = "";
		//获取当前商品下面的砍价信息
		if($_GPC['name']) {
			$where .= " and ( nickname like '%".$_GPC['name']."%' or nickname like '%".base64_encode($_GPC['name'])."%')";
		}
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn("select count(*) from ".tablename('gpb_bargaion_record')." where ac_id = ".$id.$where);
		$page = pagination($total,$pageIndex,$pageSize);
		$list = pdo_fetchall("select * from ".tablename('gpb_bargaion_record')." where ac_id = ".$id.$where." order by id desc ".$contion);
	break;
}

include $this -> template('web/' . $do . '/' . $op);

?>