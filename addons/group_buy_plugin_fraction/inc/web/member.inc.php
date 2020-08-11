<?php
header("Content-type:text/html;charset=utf-8");
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];
$id = $_GPC['id'];
$index=isset($_GPC['page'])?$_GPC['page']:1;
switch($op){
	case 'index':
		$from = $_GET;$where = '';
		if($from['status']){
			$where .= " and status = ".$from['status'];
		}
		if($from['m_nickname']){
			$where .= " and (m_nickname like '%".trim($from['m_nickname'])."%' or m_name like '%".trim($from['m_nickname'])."%' )";
		}
		if($from['star_time']){
			$where .= " and m_add_time >= ".strtotime($from['star_time']);
		}
		if($from['end_time']){
			$where .= " and m_add_time <= ".strtotime($from['end_time']);
		}
		if($from['level']){
			$where .= " and level_id = ".$from['level'];
		}
		$pageIndex = $index;
        $pageSize = $this->pageSize;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_member)." where weid = ".$this->weid." and m_status = 1 ".$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename($this->gpb_member)." where weid = ".$this->weid." and m_status = 1 ".$where." order by m_add_time desc ".$contion;
		$info = pdo_fetchall($sql);
	break;
	case 'save':
		//获取全部会员等级
		$level = pdo_getall($this->gpb_level);
		if($_GPC['types'] == 1){
			unset($_POST['types']);
			if(!empty($id)){
				//修改
				$member = pdo_get($this->gpb_member,array('m_id'=>$id));
				unset($_POST['id']);
				if(!empty($_POST['integrals'])){
					//写入日志
					$money =$member['integral']+$_POST['integrals'];
					$str = '新增积分:'.$_POST['integrals']."，剩余积分:".$money;
					$data = ['gol_uid'=>$member['m_id'],'gol_add_time'=>time(),'gol_comment'=>$str,'gol_des'=>'添加积分'];
					pdo_insert($this->gpb_order_log,$data);
				}
				$_POST['integral +='] = $_POST['integrals'];
				unset($_POST['integrals']);
				if($_POST['status'] == 2 && $member['status'] == 1){
					//第一次修改状态
					$ts = $this->msg_template($member['m_openid'],1,$id);
				}
				$res = pdo_update($this->gpb_member,$_POST,array('m_id'=>$id));
				
			}else{
				//新增
				$res = pdo_insert($this->gpb_member,$_POST);
			}
			if(empty($res)){
				$this->res(1,'操作失败');
			}else{
				$this->res(0,'操作成功');
			}
		}else{
			if(!empty($id)){
				$info = pdo_get($this->gpb_member,array('m_id'=>$id));
			}else{
				$url = url('site/entry/member', array('m'=>'group_buy_plugin_fraction'));
				header('Location :'.$url);
			}
		}
	break;
	case 'add':
		if($_GPC['types'] == 1){
			//新增或修改数据
			unset($_POST['id']);
			$_POST['weid'] = $this->weid;
			if($id){
				//修改
				$res = pdo_update($this->gpb_level,$_POST,array('id'=>$id));
			}else{
				//新增
				$_POST['time'] = time();
				$res = pdo_insert($this->gpb_level,$_POST);
			}
			if($res){
				$this->res(0,'操作成功');
			}else{
				$this->res(1,'操作失败');
			}
		}else{
			if(!empty($id)){
				$info = pdo_get($this->gpb_level,array('id'=>$id,'weid'=>$this->weid));
			}
		}
	break;
	case 'member_delete':
		if(empty($id)){
			$this->res(1,'请传入用户id');
		}
		$res = pdo_delete($this->gpb_member,array('m_id'=>$id));
		if($res){
			$this->res(0,'删除成功');
		}else{
			$this->res(1,'删除失败');
		}
	break;
	
	case 'delete':
		if(empty($id)){
			$this->res(1,'请传入等级id');
		}
		$res = pdo_update($this->gpb_level,array('status'=>-1),array('id'=>$id));
		if(!empty($res)){
			$this->res(0,'删除成功');
		}else{
			$this->res(1,'删除失败');
		}
	break;
	case 'level':
		$pageIndex = $index;
        $pageSize = $this->pageSize;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_level)." where weid = ".$this->weid." and status = 1 ");
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename($this->gpb_level)." where weid = ".$this->weid." and status = 1  order by time desc ".$contion;
		$info = pdo_fetchall($sql);
	break;
	case 'details':
		$pageIndex = $index;
        $pageSize = 20;
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->gpb_order_log)." where  gol_uid = ".$id);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename($this->gpb_order_log)." where gol_uid = ".$id." order by gol_add_time desc ".$contion;
		$info = pdo_fetchall($sql);
	break;
	case 'export':
		$from = $_GET;$where = '';
		if($from['status']){
			$where .= " and m.status = ".$from['status'];
		}
		if($from['m_nickname']){
			$where .= " and (m.m_nickname like '%".trim($from['m_nickname'])."%' or m.m_name like '%".trim($from['m_nickname'])."%' )";
		}
		if($from['star_time']){
			$where .= " and m.m_add_time >= ".strtotime($from['star_time']);
		}
		if($from['end_time']){
			$where .= " and m.m_add_time <= ".strtotime($from['end_time']);
		}
		if($from['level']){
			$where .= " and m.level_id = ".$from['level'];
		}
		$sql = 'select m.m_id,m.m_nickname,m.m_phone,m.m_name,m.m_ids,m.m_address,m.integral,m.status,m.m_add_time,l.title from '.tablename($this->gpb_member)." m  left join ".tablename($this->gpb_level)." l on m.level_id = l.id where m.weid = ".$this->weid." and m.m_status = 1 ".$where." order by m.m_add_time desc ";
		$info = pdo_fetchall($sql);
		$strTable = '';
		$strTable ='<table width="500" border="1">';
    	$strTable .= '<tr>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">序号</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">昵称</td>';
	    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">姓名</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;width:120px;">电话</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="100">身份证号码</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">地址</td>';
	    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">积分</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">审核状态</td>';
	    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">等级</td>';
	    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">注册时间</td>';
    	$strTable .= '</tr>';
		if(!empty($info)){
			foreach($info as $k=>$v){
				$strTable .= '<tr>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_id'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_nickname'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_name']."&nbsp;".'</td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_phone'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_ids'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_address'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['integral'].' </td>';
				if($v['status'] == 1){
					$strTable .= '<td style="text-align:left;font-size:12px;">未审核 </td>';
				}else{
					$strTable .= '<td style="text-align:left;font-size:12px;">已审核 </td>';
				}
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['title'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.date('Y-m-d H:i:s',$v['m_add_time']).'&nbsp;</td>';
				$strTable .= '</tr>';
			}
		}
		unset($info);
		$strTable .='</table>';
		header("Content-type: application/vnd.ms-excel");
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=用户信息_".date('Y-m-d').".xls");
		header('Expires:0');
		header('Pragma:public');
		echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$strTable.'</html>';
	break;
	case 'lis':
		$sql = 'select * from '.tablename($this->gpb_order_log)." o join ".tablename($this->gpb_member)." m on o.gol_uid = m.m_id where o.gol_uid = ".$id." order by o.gol_add_time desc ";
		$info = pdo_fetchall($sql);
		$strTable = '';
		$strTable ='<table width="500" border="1">';
    	$strTable .= '<tr>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">序号</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">昵称</td>';
	    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">姓名</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;width:120px;">电话</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="100">身份证号码</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">地址</td>';
	    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">积分</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">操作记录</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">操作时间</td>';
    	$strTable .= '</tr>';
		if(!empty($info)){
			foreach($info as $k=>$v){
				$strTable .= '<tr>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_id'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_nickname'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_name']."&nbsp;".'</td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_phone'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_ids'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['m_address'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['integral'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$v['gol_comment'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.date('Y-m-d H:i:s',$v['gol_add_time']).' </td>';
				$strTable .= '</tr>';
			}
		}
		unset($info);
		$strTable .='</table>';
		header("Content-type: application/vnd.ms-excel");
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=用户信息_".date('Y-m-d').".xls");
		header('Expires:0');
		header('Pragma:public');
		echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$strTable.'</html>';
	break;
}
$sql = 'select id,title from '.tablename($this->gpb_level)." where weid = ".$this->weid." and status = 1  order by time desc ";
$level_list = pdo_fetchall($sql);
include $this->template('web/'.$do.'/'.$op);
?>