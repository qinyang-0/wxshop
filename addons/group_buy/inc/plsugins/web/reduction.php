<?php
//满减
switch($in){
	case 'index':
        $name = $_GPC['name'];
		$index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        //逻辑：活动名称是模糊查询
        if(isset($_GPC['name']) && !empty($_GPC['name']) ) {
            $where .= " and  at_name like '%".trim($_GPC['name'])."%' ";

        }
		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->action)." where at_is_del = 1 and weid =".$weid);
		$page = pagination($total,$pageIndex,$pageSize);
		//获取分页信息
		$sql = 'select * from '.tablename($this->action)." where at_is_del = 1 and weid =".$weid.$where." order by at_order,at_id desc ".$contion;
//		var_dump($sql);
//		var_dump($weid);
		$info = pdo_fetchall($sql);
	break;

    case 'reduction':
        //满减
        if($_GPC['submit'] == '提交'){
            //提交数据
            unset($_POST['submit']);
            pdo_begin();
            foreach ($_POST as $k =>$v){
                $sql = "update ".tablename($this->config)." set value = '".$v."',time=".time()." where id =".$k;
                $res = pdo_query($sql);
            }
            pdo_commit();
            if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('action',array('op'=>'reduction')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
        }else{
            //是否开启满减
            $open_full_reduction = pdo_get($this->config,array('key'=>'open_full_reduction','weid'=>$weid));
            if(empty($open_full_reduction) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启满减','2','13',".time().",".$weid.",1,'open_full_reduction');");
            }
            //满足减价的限制条件
            $full_reduction_limit_price = pdo_get($this->config,array('key'=>'full_reduction_limit_price','weid'=>$weid));
            if(empty($full_reduction_limit_price) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('满足减价的限制条件','0','13',".time().",".$weid.",1,'full_reduction_limit_price');");
            }
            //减少的价格
            $full_reduction_price = pdo_get($this->config,array('key'=>'full_reduction_price','weid'=>$weid));
            if(empty($full_reduction_price) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('减少的价格','0','13',".time().",".$weid.",1,'full_reduction_price');");
            }
            $open_full_reduction = pdo_get($this->config,array('key'=>'open_full_reduction','weid'=>$weid));
            $full_reduction_limit_price = pdo_get($this->config,array('key'=>'full_reduction_limit_price','weid'=>$weid));
            $full_reduction_price = pdo_get($this->config,array('key'=>'full_reduction_price','weid'=>$weid));
        }
        break;
}

?>