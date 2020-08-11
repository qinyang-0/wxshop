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
        $name = $_GPC['name'];
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        //逻辑：广告名称是模糊查询
        if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
            $where .= " and  ban_name like '%".trim($_GPC['name'])."%' ";

        }
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->adv)." where ban_status = 1 and weid=".$weid);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename($this->adv)." where ban_status = 1 and weid=".$weid.$where." order by ban_order asc,ban_id desc ".$contion;
		$info = pdo_fetchall($sql);
		foreach ( $info as $k => $v ){
            if($v['ban_link_type']==2){
                $info[$k]['ban_link_content']='../adv_page/adv_page?id='.$v['ban_id'];
            }
        }
	break;
	case 'add':
		if($_GPC['submit'] == '提交'){
			//提交数据
			$name = trim($_GPC['name']);
			$type = trim($_GPC['type']);
			$href = trim($_GPC['href']);
			$img = trim($_GPC['img']);
			$order = trim($_GPC['order']);
			$ban_link_type = trim($_GPC['ban_link_type']);
            $ban_link_content_1 = trim($_GPC['ban_link_content_1']);
            $ban_link_content_2 = trim($_GPC['ban_link_content_2']);
            $ban_link_content_2_title = trim($_GPC['ban_link_content_2_title']);
            $ban_link_content_3 = trim($_GPC['ban_link_content_3']);
            $ban_link_content_3 = trim($_GPC['ban_link_content_3']);
            $is_show = trim($_GPC['is_show']);

			if(empty($name) ){
				$this->message_info('请填写广告名称');exit;
			}
            if( empty($img)){
                $this->message_info('请上传图片');exit;
            }
			if( $ban_link_type != 0 && empty($ban_link_content_1)  && empty($ban_link_content_2) && empty($ban_link_content_3)){
                $this->message_info('请选择或填写链接内容');exit;
            }
            $content = "";
            if(!empty($ban_link_content_1) && empty($ban_link_content_2) && empty($ban_link_content_3) ){
                $content = $ban_link_content_1;
            }elseif (empty($ban_link_content_1) && !empty($ban_link_content_2) && empty($ban_link_content_3) ){
                $content = array('title'=>$ban_link_content_2_title,'content'=>$ban_link_content_2);
                $content = serialize($content);
            }elseif (empty($ban_link_content_1) && empty($ban_link_content_2) && !empty($ban_link_content_3) ){

                $content = $ban_link_content_3;
            }
//            var_dump($is_show);exit;
			$data = [
				'ban_name'=>$name,
				'ban_type'=>$type,
				'ban_href'=>$ban_link_content_1,
				'ban_img'=>$img,
				'weid'=>$weid,
				'ban_order'=>$order,
				'ban_is_show'=>$is_show,
                'ban_link_type'=>$ban_link_type,
                'ban_link_content'=>$content
			];
			if($id){
			    $data['ban_update_time'] = time();
				$res = pdo_update($this->adv,$data,['ban_id'=>$id]);
			}else{
                $data['ban_add_time'] = time();
				$res = pdo_insert($this->adv,$data);
			}
			if(empty($res)){
				$this->message_info('操作失败');
			}else{
				$this->message_info('操作成功', $this->createWebUrl('adv'), 'success');
			}
		}else{
			if($id){
				$info = pdo_get($this->adv,['ban_id'=>$id]);
				switch ($info['ban_link_type']){
                    case 1:
                        $ban_link_content_1 = $info['ban_link_content'];
                        break;
                    case 2:
                        $arr =  unserialize($info['ban_link_content']);
                        $ban_link_content_2 = $arr['content'];
                        $ban_link_content_2_title = $arr['title'];
                        break;
                    case 3:
                        $ban_link_content_3 = $info['ban_link_content'];
                        break;
                }
			}
		}
	break;
	case 'save':
	break;
	case 'del':
		if($id){
			$res = pdo_update($this->adv,['ban_status'=>-1],['ban_id'=>$id,'weid'=>$weid]);
			if($res){
				echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
			}else{
				echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
			}
		}else{
			echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
		}
	break;
    case "getGoodsList":
        $type = trim($_GPC['type']);
        if(empty($type)){
            echo json_encode(['status'=>1,'msg'=>'请选择类型']);exit;
        }
        switch ($type){
            case "goods":
                $index=isset($_GPC['page'])?$_GPC['page']:1;
                $pageIndex = $index;
                $pageSize =3;
                $where = "";

                if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
                    $where .= " and  g_name like '%".trim($_GPC['title'])."%' ";
                }
                if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
                    $where .= " and  g_product_num like '%".trim($_GPC['num'])."%' ";
                }
                $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
                $sql_count = "select count(*) from ".tablename($this->goods)." as g left join ".tablename($this->goods_cate)." as gc on gc.gc_id = g_cid where g_is_del=1 and g_is_online=1 and gc_status=1  and gc_is_del =1 and g.weid =".$weid.$where;
                $sql = "select * from ".tablename($this->goods)." as g left join ".tablename($this->goods_cate)." as gc on gc.gc_id = g_cid where g_is_del=1 and g_is_online=1 and gc_status=1  and gc_is_del =1 and g.weid =".$weid.$where."  order by g_id ".$contion;
                $total= pdo_fetchcolumn($sql_count);
                $res = pdo_fetchall($sql);
                $page = pagination($total,$pageIndex,$pageSize);
                if(empty($res)){
                    $str = "<tr><td colspan='999'>无相关数据</td></tr>";
                    echo json_encode(['status'=>1,'msg'=>'请选择类型','data'=>$str,'page'=>$page]);exit;
                }else{
                    $str = "";
                    foreach ($res as $k=>$v){
                        $str .="<tr><td>".$v['g_product_num']."</td><td>".$v['g_name']."</td><td><img src='".tomedia($v['g_icon'])."' width='50'/></td><td><span class='btn btn-info btn-xs content-checked' data-content='../show/show?id=".$v['g_id']."'>选取</span></td></tr>";
                    }
                    echo json_encode(['status'=>0,'msg'=>'查询成功','data'=>$str,'page'=>$page]);exit;
                }
                break;
            case "action-goods":
                $index=isset($_GPC['page'])?$_GPC['page']:1;
                $pageIndex = $index;
                $pageSize = 3;
                $where = "";

                if(isset($_GPC['title']) && !empty($_GPC['title']) ) {
                    $where .= " and  g.g_name like '%".trim($_GPC['title'])."%' ";
                }
                if(isset($_GPC['num']) && !empty($_GPC['num']) ) {
                    $where .= " and  g.g_product_num like '%".trim($_GPC['num'])."%' ";
                }
                if(isset($_GPC['action']) && !empty($_GPC['action']) ) {
                    $where .= " and  a.at_name like '%".trim($_GPC['action'])."%' ";
                }
                $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
                $sql_count = "select count(*) from ".tablename($this->action_goods)." as ag  left join ".tablename($this->action)." as a on ag.gcg_at_id = a.at_id left join ".tablename($this->goods)." as g on g.g_id =ag.gcg_g_id left join ".tablename($this->goods_stock)." as gs on gs.goods_id = ag.gcg_g_id where at_is_del=1  and at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time > ".time()." and ag.weid=".$this->weid.$where;
                $sql  =  "select * from ".tablename($this->action_goods)." as ag  left join ".tablename($this->action)." as a on ag.gcg_at_id = a.at_id left join ".tablename($this->goods)." as g on g.g_id =ag.gcg_g_id left join ".tablename($this->goods_stock)." as gs on gs.goods_id = ag.gcg_g_id where at_is_del=1  and at_is_index_show=1 and g_is_online=1 and g_is_del = 1 and at_end_time > ".time()." and ag.weid=".$this->weid.$where."   order by at_start_time desc ".$contion;
                $total= pdo_fetchcolumn($sql_count);
                $res = pdo_fetchall($sql);
                $page = pagination($total,$pageIndex,$pageSize);
                if(empty($res)){
                    $str = "<tr><td colspan='999'>无相关数据</td></tr>";
                    echo json_encode(['status'=>1,'msg'=>'请选择类型','data'=>$str,'page'=>$page]);exit;
                }else{
                    $str = "";
                    foreach ($res as $k=>$v){
                        $str .="<tr><td>".$v['at_name']."</td><td>".$v['g_product_num']."</td><td>".$v['g_name']."</td><td><img src='".tomedia($v['g_icon'])."' width='50'/></td><td><span class='btn btn-info btn-xs content-checked' data-content='../show/show?id=".$v['g_id']."&&at_id=".$v['at_id']."'>选取</span></td></tr>";
                    }
                    echo json_encode(['status'=>0,'msg'=>'查询成功','data'=>$str,'page'=>$page,'sql1'=>$sql,'sql2'=>$sql_count]);exit;
                }
                break;
        }

        echo json_encode(['status'=>1,'msg'=>'非法操作']);exit;



        break;
    case "delfile":
        $file_type='qr_code';
        $dir = MODULE_ROOT.'/public/images/';
        if(is_dir($dir)){
            $files = scandir($dir);
            //打开目录 //列出目录中的所有文件并去掉 . 和 ..
            foreach($files as $filename){
                if($filename!='.' && $filename!='..' && strlen($filename)>15){
                    //获取文件时间
                    $edittime = filemtime($dir.$filename);
                    if(time()-$edittime>24*60*60*15){
                        if(!is_dir($dir.'/'.$filename)){
                            if(empty($file_type)){
                                unlink($dir.'/'.$filename);
                            }else{
                                if(is_array($file_type)){
                                    //正则匹配指定文件
                                    if(preg_match($file_type[0],$filename)){
                                        unlink($dir.'/'.$filename);
                                    }
                                }else{
                                    //指定包含某些字符串的文件
                                    if(false!=stristr($filename,$file_type)){
                                        unlink($dir.'/'.$filename);
                                    }
                                }
                            }
                        }else{
//                            delFile($dir.'/'.$filename);
//                            rmdir($dir.'/'.$filename);
                        }
//                        echo $filename."<br/>";
                    }
                }

            }
        }else{
//            if(file_exists($dir)) unlink($dir);
        }
        exit;
        break;


}
include $this -> template('web/' . $do . '/' . $op);
?>