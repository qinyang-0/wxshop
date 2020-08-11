<?php
/*
 * 物流管理
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块

switch($op){

	case 'add':

		if($_GPC['submit'] == '提交'){
//            var_dump($_POST);exit;
			//提交数据
			$name = $_GPC['name'];
			$brief = $_GPC['brief'];
			$action_start_time = $_GPC['action_time']['start'];
            $action_end_time = $_GPC['action_time']['end'];
            $get_start_time = $_GPC['get_time']['start'];
            $get_end_time = $_GPC['get_time']['end'];
			$order = $_GPC['order'];
            $is_show = 1;//$_GPC['is_show'];
            $is_limit = $_GPC['is_limit'];
            $is_kill= $_GPC['is_kill'];
            $is_kill = -1;//没有秒杀了
            $see_num = $_GPC['see_num'];
            $at_arrival_time = $_GPC['at_arrival_time'];
            $at_arrival_time_text = $_GPC['at_arrival_time_text'];
            $at_is_head_open = $_GPC['is_head_open'];
//            var_dump($_GPC);exit;
			if(empty($name)){
                $this->message_info('请填写活动名称');exit;
//                echo json_encode(['status'=>1,'msg'=>'请填写活动名称']);exit;
			}
            if(empty($action_start_time) || empty($action_end_time)){
                $this->message_info('请填写活动时间');exit;
//                echo json_encode(['status'=>1,'msg'=>'请填写活动时间']);exit;
            }
            if($action_start_time > $action_end_time ){
                $this->message_info('活动起始时间不能超过终止时间');exit;
//                echo json_encode(['status'=>1,'msg'=>'活动起始时间不能超过终止时间']);exit;
            }
            if(empty($at_arrival_time) && $at_arrival_time!=0 ){
                $this->message_info('请填写或选择提货时间');exit;
//                echo json_encode(['status'=>1,'msg'=>'请填写或选择提货时间']);exit;
            }
//            if(empty($is_show) ){
//                $this->message_info('请选择是否首页显示');exit;
////                echo json_encode(['status'=>1,'msg'=>'请选择是否首页显示']);exit;
//            }
			$data = [
				'at_name'=>$name,
				'at_brief'=>$brief,
				'at_start_time'=>strtotime($action_start_time),
				'at_end_time'=>strtotime($action_end_time),
//				'at_start_send_time'=>strtotime($get_start_time),
//				'at_end_send_time'=>strtotime($get_end_time),
                'at_order'=>$order,
				'at_is_index_show'=>$is_show,
                'at_is_limit'=>$is_limit,
                'at_is_seckill'=>$is_kill,
                'at_see_num'=>$see_num,
                'at_arrival_time'=>$at_arrival_time,
                'at_arrival_time_text'=>$at_arrival_time_text,
                'at_is_head_open'=>$at_is_head_open,
                'weid'=>$weid
			];

			if($id){
			    $data['at_update_time'] = time();
				$res = pdo_update($this->action,$data,['at_id'=>$id]);
                $url = $this->createWebUrl('action');
            }else{
                $data['at_add_time'] = time();
				$res = pdo_insert($this->action,$data);
                $url = $this->createWebUrl('action',array('op'=>'add','id'=>$id));
            }
			if(empty($res)){
                $this->message_info('操作失败');
//                echo json_encode(array('status'=>1,'msg'=>'操作失败','url'=>''));exit;
			}else{
                $this->message_info('操作成功', $this->createWebUrl('action'), 'success');
//                echo json_encode(array('status'=>0,'msg'=>'操作成功','url'=>$url));exit;
			}
		}else{
            $act_title = '新增';
			if($id){
                $act_title = '修改';
				$info = pdo_get($this->action,['at_id'=>$id,'weid'=>$weid]);
//				var_dump($info);
			}
		}
	break;

}
include $this -> template('web/' . $do . '/' . $op);
?>