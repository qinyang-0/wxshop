<?php
/**
 * 积分签到
 * 里面只写业务代码
 * 
 */

switch($in){
	case 'index':
		$info = pdo_getall($this->config,['status'=>1,'type'=>21,'weid'=>$weid]);
		if($info){
			$data = [];
			foreach($info as $k=>$v){
				$data[$v['key']] = $v['value'];
			}
		}
		$info = $data;
	break;
	case 'add':
		$post = $_POST;
		$data = [];
		if(!empty($post['sign_continuity']['value']) && !empty($post['sign_reward']['value'])){
			foreach($post['sign_continuity']['value'] as $k=>$v){
				if($v && $post['sign_reward']['value'][$k]){
					$data[$k]['contiutiy'] = $v;
					$data[$k]['reward'] = $post['sign_reward']['value'][$k];
				}
			}
		}
		unset($post['sign_continuity']);
		unset($post['sign_reward']);
		if($data){
			$post['sign_continuity']['value'] = serialize($data);
			$post['sign_continuity']['name'] = '连签奖励';
		}
		unset($post['submit']);
		if($post){
			foreach($post as $k=>$v){
				$config = pdo_get($this->config,array('status'=>1,'type'=>21,'weid'=>$weid,'key'=>$k),array(),'id');
				if($config){
					pdo_update($this->config,array('status'=>1,'type'=>21,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()),array('id'=>$config['id']));
				}else{
					pdo_insert($this->config,array('status'=>1,'type'=>21,'weid'=>$weid,'value'=>$v['value'],'name'=>$v['name'],'key'=>$k,'time'=>time()));
				}
			}
			$this->message_info('操作成功', $this->createWebUrl('plsugins',['op'=>'sign','in'=>'index']), 'success');
		}else{
			$this->message_info('未做出任何修改');
		}
	break;
	case 'list':
		$stime=microtime(true);
		$title = $_GPC['title'];
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 20;
        if(!empty($title)){
            $where .= " and  (m.m_nickname like '%".trim($title)."%' or m.m_nickname like '%".base64_encode($title)."%') ";
        }
		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$data = pdo_fetchall("select m_openid from ".tablename('gpb_member')." where weid = ".$weid);
		if($data){
			$str = "";
			foreach($data as $v){
				$str .= "'".$v['m_openid']."',";
			}
			$str = trim($str,',');
		}
		$total = pdo_fetchcolumn("select count(*) from ".tablename("gpb_member_integral_check")." where openid in (".$str.")");
//		$total= pdo_fetchcolumn('select count(*) from ' . tablename('gpb_member')." m join ".tablename("gpb_member_integral_check")." c on m.m_openid = c.openid where m.weid = ".$this->weid.$where);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
//		$sql = 'select c.*,m.m_nickname,m.m_photo from ' . tablename('gpb_member')." m join ".tablename("gpb_member_integral_check")." c on m.m_openid = c.openid where m.weid = ".$this->weid.$where." order by c.create_time desc ".$contion;
		$sql = "SELECT c.*,m.m_nickname as nikcname,m.m_photo  FROM (SELECT * FROM ".tablename('gpb_member_integral_check')." AS c ORDER BY c.create_time DESC ".$contion." ) AS c JOIN ".tablename('gpb_member')." m ON m.m_openid = c.openid  WHERE m.weid = ".$this->weid.$where;

		$info = pdo_fetchall($sql);
		if(is_array($info)){
            foreach ($info as $k=>$v){
                if($this->check_base64_out_json($v['m_nickname'])){
                    $info[$k]['m_nickname']=base64_decode($v['m_nickname']);
                }
            }
        }
//		$etime=microtime(true);//获取程序执行结束的时间
//		$total=$etime-$stime;   //计算差值
	break;
}
?>