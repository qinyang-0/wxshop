<?php
//内容管理

global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
$_GPC['do']='config';

switch($op){
	case 'index':
        $name = $_GPC['name'];
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        //逻辑：文章名称是模糊查询
        if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
            $where .= " and  a.title like '%".trim($_GPC['name'])."%' ";
        }
        $class = trim($_GPC['class']);
        if(isset($class) && !empty($class) ) {
            $where .= " and  ac.id = ".$class." ";
        }
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->article)." as a left join ".tablename($this->article_class)." as ac on a.pid =ac.id   where a.is_del = 1 and a.weid=".$weid.$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select a.title,a.id,a.body,a.pid,a.sort,a.createtime,a.status,ac.title as ac_title  from '.tablename($this->article)." as a left join ".tablename($this->article_class)." as ac on a.pid =ac.id  where a.is_del = 1 and a.weid=".$weid.$where." order by sort asc,id desc ".$contion;
		$info = pdo_fetchall($sql);
        $class_info = pdo_fetchall( 'select * from '.tablename($this->article_class)." as ac where is_del = 1 and ac.weid=".$weid." order by  sort asc,id desc ");
        $count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_article_class')." where weid=".$weid);
        if($count<=0){
            pdo_run("INSERT  INTO ".tablename('gpb_article_class')." (`title`,`status`,`time`,`push`,`weid`,`pid`,`is_del`,`sort`,`addtime`,`type`,`icon`) VALUES 
('常见问题','-1','','1',$weid,'0','1','1','1550735868','1','/addons/group_buy/public/bg/qualification_certification.png'),
('资质规则','-1','','1',$weid,'0','1','2','1550736410','2','/addons/group_buy/public/bg/frequently_asked_questions.png');");
        }
	break;
	case 'add':
		if($_GPC['submit'] == '提交'){
			//提交数据
			$name = trim($_GPC['name']);//标题
			$classs = trim($_GPC['classs']);//分类
			$order = trim($_GPC['order']);
            $is_show = trim($_GPC['is_show']);
            $time = trim($_GPC['time']);
            $content = trim($_GPC['content']);
//            var_dump($_GPC);exit;
			if(empty($name) ){
				$this->message_info('请填写标题名称');exit;
			}
            if( empty($classs)){
                $this->message_info('请选择文章分类');exit;
            }

			$data = [
				'weid'=>$weid,
				'status'=>$is_show,
				'title'=>$name,
				'body'=>$content,
				'sort'=>$order,
				'createtime'=>strtotime($time),
				'pid'=>$classs,
                'is_del'=>1,
			];
			if($id){
				$res = pdo_update($this->article,$data,['id'=>$id]);
			}else{
                $data['addtime'] = time();
				$res = pdo_insert($this->article,$data);
			}
			if(empty($res)){
				$this->message_info('操作失败');
			}else{
				$this->message_info('操作成功', $this->createWebUrl('content',array('op'=>'index')), 'success');
			}
		}else{
            $act_title ="新增";
			if($id){
                $act_title ="修改";
				$info = pdo_get($this->article,array('id'=>$id));
			}
            $sql = 'select * from '.tablename($this->article_class)." as ac where is_del = 1 and ac.weid=".$weid.$where." order by  sort asc,id desc ".$contion;
            $class = pdo_fetchall($sql);
		}
	break;
	case 'del':
		if($id){
			$res = pdo_update($this->article,['is_del'=>-1],['id'=>$id,'weid'=>$weid]);
			if($res){
				echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
			}else{
				echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
			}
		}else{
			echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
		}
	break;
    case 'class':
        $name = $_GPC['name'];
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        //逻辑：文章名称是模糊查询
        if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
            $where .= " and  title like '%".trim($_GPC['name'])."%' ";
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn('select count(*) from ' . tablename($this->article_class)." where is_del = 1 and weid=".$weid.$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = 'select * from '.tablename($this->article_class)." as ac where is_del = 1 and ac.weid=".$weid.$where." order by  sort asc,id desc ".$contion;
        $info = pdo_fetchall($sql);
        break;
    case 'classAdd':
        if($_GPC['submit'] == '提交'){
            //提交数据
            $name = trim($_GPC['name']);//分类名称
            $order = trim($_GPC['order']);
            $is_show = trim($_GPC['is_show']);
            $icon = trim($_GPC['icon']);
            if(empty($name) ){
                $this->message_info('请填写分类名称');exit;
            }
            if(empty($icon) ){
                $this->message_info('请上传图标');exit;
            }

            $data = [
                'weid'=>$weid,
                'status'=>$is_show,
                'title'=>$name,
                'sort'=>$order,
                'icon'=>$icon,
                'is_del'=>1,
            ];
            if($id){
                $res = pdo_update($this->article_class,$data,['id'=>$id]);
            }else{
                $data['addtime'] = time();
                $res = pdo_insert($this->article_class,$data);
            }
            if(empty($res)){
                $this->message_info('操作失败');
            }else{
                $this->message_info('操作成功', $this->createWebUrl('content',array('op'=>'class')), 'success');
            }
        }else{
            $act_title ="新增";
            if($id){
                $act_title ="修改";
                $info = pdo_get($this->article_class,array('id'=>$id));
            }
        }
        break;
    case 'classDel':
        if($id){
            $count = pdo_fetchcolumn("select count(*) from ".tablename('gpb_article')." where is_del=1 and pid=".$id);
            if($count>0){
                echo json_encode(['status'=>1,'msg'=>'有相关文章无法删除']);exit;
            }
            $res = pdo_update($this->article_class,['is_del'=>-1],['id'=>$id,'weid'=>$weid]);
            if($res){
                echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
    case 'setClassStatus':
        if($id){
            $status = pdo_getcolumn('gpb_article_class',['id'=>$id,'weid'=>$weid],'status');
            $res = pdo_update('gpb_article_class',['status'=>-$status],['id'=>$id,'weid'=>$weid]);
            if($res and $status ==-1 ){
                echo json_encode(['status'=>0,'msg'=>'显示成功']);exit;
            }else if( $res and $status ==1 ){
                echo json_encode(['status'=>0,'msg'=>'隐藏成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'操作失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
    case 'setAstatus':
        if($id){
            $status = pdo_getcolumn($this->article,['id'=>$id,'weid'=>$weid],'status');
            $res = pdo_update($this->article,['status'=>-$status],['id'=>$id,'weid'=>$weid]);
            if($res and $status ==-1 ){
                echo json_encode(['status'=>0,'msg'=>'显示成功']);exit;
            }else if( $res and $status ==1 ){
                echo json_encode(['status'=>0,'msg'=>'隐藏成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'操作失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
}
include $this -> template('web/' . $do . '/' . $op);
?>