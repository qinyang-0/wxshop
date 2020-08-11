<?php
/**
 * showdoc
 * @catalog 团购/模块/inc/web
 * @title config.inc
 * @method     POST
 * @url 新增$op='wxapp'小程序配置,删除index模板中小程序支付配置
 * @param
 * @return
 * @return_param
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
$signkey = isset($_W['account']['setting']['payment']['wechat']['signkey'])?$_W['account']['setting']['payment']['wechat']['signkey']:"";
$mchid = isset($_W['account']['setting']['payment']['wechat']['mchid'])?$_W['account']['setting']['payment']['wechat']['mchid']:"";
$pre = $_W['config']['db']['tablepre'];
switch($op){
	case 'index':
        //读取当前模块版本
        $now_version_num_arr = pdo_get('modules',array('name'=>'group_buy','type'=>'business'));
        $now_version_num ='';
        if(isset($now_version_num_arr['version']) && !empty($now_version_num_arr['version']) ){
            $now_version_num = $now_version_num_arr['version'];
        }
		if($_GPC['submit'] == '提交'){
			//提交数据
            $cert_address = pdo_get($this->config,array('key'=>'cert_address','weid'=>$weid));
            $cert_id = $cert_address['id'];
            if(isset($_FILES['cert_address']) and $_FILES['cert_address']['error'] == 0 and $_FILES['cert_address']['size'] > 0 ){

                if(is_uploaded_file($_FILES['cert_address']['tmp_name'])){
                    list($f_name,$f_ext) = explode('.', $_FILES['cert_address']['name']);
                    $rand = md5(uniqid().rand(1111,9999));
                    if(!file_exists("../addons/group_buy/public/files")){
                        mkdir("../addons/group_buy/public/files");
                    }
                    $filename = '/addons/group_buy/public/files/'.$rand.'.'.$f_ext;
                    $return = move_uploaded_file($_FILES['cert_address']['tmp_name'],"..".$filename);
                    if(!$return){
                        $this->message_info('文件上传失败');
                    }else{
                        if(!empty($_POST['old_cert_address'])){
                            @unlink('..'.$_POST['old_cert_address']);
                        }
                        $_POST[$cert_id] = $filename;
                    }
                }else{
                    $this->message_info('非法文件上传');
                }
            }
            $key_address = pdo_get($this->config,array('key'=>'key_address','weid'=>$weid));
            $key_id = $key_address['id'];
            if(isset($_FILES['key_address']) and $_FILES['key_address']['error'] == 0 and $_FILES['key_address']['size'] > 0 ){
                if(is_uploaded_file($_FILES['key_address']['tmp_name'])){
                    list($f_name,$f_ext) = explode('.', $_FILES['key_address']['name']);
                    $rand = md5(uniqid().rand(1111,9999));
                    if(!file_exists("../addons/group_buy/public/files")){
                        mkdirs("../addons/group_buy/public/files");
                    }
                    $filename_2 = '/addons/group_buy/public/files/'.$rand.'.'.$f_ext;
                    $return = move_uploaded_file($_FILES['key_address']['tmp_name'],"..".$filename_2);
                    if(!$return){
                        $this->message_info('文件上传失败');
                    }else{
                        if(!empty($_POST['old_key_address'])){
                            @unlink('..'.$_POST['old_key_address']);
                        }
                        $_POST[$key_id] = $filename_2;
                    }
                }else{
                    $this->message_info('非法文件上传');
                }
            }
			if($_POST['star_time'] && $_POST['end_time']){
				$arr = [
					'star_time'=>$_POST['star_time'],
					'end_time'=>$_POST['end_time'],
//					'end_time_status'=>$_POST['end_time_status'],
				];
				$arr = serialize($arr);
				$a = pdo_get("gpb_config",array('weid'=>$this->weid,'key'=>'cutting_order_time'));
				$_POST[$a['id']] = $arr;
//				unset($_POST['end_time_status']);
				unset($_POST['star_time']);
				unset($_POST['end_time']);
			}


            //是否有站点名称
            $sitename = $_POST['sitename'];
            if(!empty($sitename)){
                $arr = [
                    'group_buy'=>'',
                    'group_buy_plugin_distribution'=>'分销',
                    'group_buy_plugin_seckill'=>'秒杀',
                    'group_buy_plugin_bargain'=>'积分商城',
                    'group_buy_plugin_team'=>'拼团',
                ];
                foreach ($arr as $k=>$v){
                    pdo_run("update ".tablename("modules")." set `title`='{$sitename}{$v}' where `name`='{$k}' ");
                }
                unset($_POST['sitename']);
            }

            unset($_POST['submit']);
            unset($_POST['old_cert_address']);
            unset($_POST['old_key_address']);
			
            pdo_begin();
            foreach ($_POST as $k =>$v){
                if($k == "team_rank"){
                    $data=array();
					if($_POST['team_rank']){
						foreach ($_POST['team_rank'] as $k =>$v){
                        	$data[] = array('status'=>$k,'name'=>$v);
                    	}
					}
					if($data){
	                    $sql = "update ".tablename($this->config)." set value = '".serialize($data)."',time=".time()." where ".tablename($this->config).".key ='team_rank'  and weid = ".$weid;
					}
                }else if($k == 'app_key' || $k == 'pay_mchid' || $k == 'appsecret' || $k == 'appid'){
                	if($k == 'app_key'){
                		$arr = [
                			'wechat'=>[
                				'mchid'=>$_POST['pay_mchid'],
                				'signkey'=>$_POST['app_key'],
                				'account'=>$this->weid,
                			]
                		];
						pdo_update("uni_settings",['payment'=>serialize($arr)],['uniacid'=>$this->weid]);
                	}else if($k == 'appid'){
                		pdo_update('account_wxapp',array('key'=>$_POST['appid'],'secret'=>$_POST['appsecret']),array('uniacid'=>$this->weid));
                	}
					$sql = "update ".tablename($this->config)." set `value` = '".$v."',`time`=".time()." where `key` = '".$k."' and weid = ".$this->weid;
                }else{
                    $sql = "update ".tablename($this->config)." set value = '".$v."',time=".time()." where id =".$k;
                }
                $res = pdo_query($sql);
            }
            if(empty($_POST['team_rank'])){
            	$sql = "update ".tablename($this->config)." set value = '',time=".time()." where ".tablename($this->config).".`key` ='team_rank'  and weid = ".$weid;
            	$res = pdo_query($sql);
            }
            pdo_commit();
			load()->model('cache');
			load()->model('setting');
			cache_updatecache();
            if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('config'), 'success');
            } else {

                $this->message_info("修改配置失败");
            }
//            $this->message_info("修改配置成功",$this->createWebUrl('config'), 'success');
		}else{
            //获取当前后台名称
            $sitename = pdo_fetchcolumn("select `title` from ".tablename("modules")." where `name`='group_buy'");
		    //进配置表先看有无此模块的的配置  
            $sever_phone =  pdo_get($this->config,array('key'=>'sever_phone','weid'=>$weid));
            if(empty($sever_phone) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('客服电话','','1',".time().",".$weid.",1,'sever_phone');");
//                $sever_phone =  pdo_get($this->config,array('key'=>'sever_phone','weid'=>$weid));
            }
            $pay_mchid = pdo_get($this->config,array('key'=>'pay_mchid','weid'=>$weid));
            if(empty($pay_mchid) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('支付商户号','','1',".time().",".$weid.",1,'pay_mchid');");
//                $pay_mchid = pdo_get($this->config,array('key'=>'pay_mchid','weid'=>$weid));
            }
            $app_key = pdo_get($this->config,array('key'=>'app_key','weid'=>$weid));
            if(empty($pay_mchid) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('API密钥','','1',".time().",".$weid.",1,'app_key');");
//                $app_key = pdo_get($this->config,array('key'=>'app_key','weid'=>$weid));
            }
            $cert_address = pdo_get($this->config,array('key'=>'cert_address','weid'=>$weid));
            if(empty($cert_address) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('证书路径','','1',".time().",".$weid.",1,'cert_address');");
//                $cert_address = pdo_get($this->config,array('key'=>'cert_address','weid'=>$weid));
            }
            $key_address = pdo_get($this->config,array('key'=>'key_address','weid'=>$weid));
            if(empty($key_address) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('密钥路径','','1',".time().",".$weid.",1,'key_address');");
//                $key_address = pdo_get($this->config,array('key'=>'key_address','weid'=>$weid));
            }
            $team_rank = pdo_get($this->config,array('key'=>'team_rank','weid'=>$weid));
            if(empty($team_rank) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('团长排行榜','','1',".time().",".$weid.",1,'team_rank');");
//                $key_address = pdo_get($this->config,array('key'=>'key_address','weid'=>$weid));
            }
            $back_title_set = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'back_title_set'));
            if(empty($back_title_set) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('后台左上角标题设置','','6',".time().",".$weid.",1,'back_title_set');");
            }
            $back_set_type = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'back_set_type'));
            if(empty($back_set_type) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('后台左上角显示类型','1','6',".time().",".$weid.",1,'back_set_type');");
            }
            $back_icon_set = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'back_icon_set'));
            if(empty($back_icon_set) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('后台左上角图标设置','','6',".time().",".$weid.",1,'back_icon_set');");
            }
            //首页分享出去的标题类型
            $index_share_title_type = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'index_share_title_type'));
            if(empty($index_share_title_type) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('首页分享出去的标题类型','','1',".time().",".$weid.",1,'index_share_title_type');");
            }
            //首页分享出去的自定义标题内容
            $index_share_title = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'index_share_title'));
            if(empty($index_share_title) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('首页分享出去的自定义标题内容','','1',".time().",".$weid.",1,'index_share_title');");
            }
            //首页分享出去的图片类型
            $index_share_img_type = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'index_share_img_type'));
            if(empty($index_share_img_type) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('首页分享出去的图片类型','','1',".time().",".$weid.",1,'index_share_img_type');");
            }
            //首页分享出去的自定义图片
            $index_share_img = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'index_share_img'));
            if(empty($index_share_img) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('首页分享出去的自定义图片','','1',".time().",".$weid.",1,'index_share_img');");
            }
            //是否显示首页分类页数据加载完的底部图片
            $data_end_show_img_open = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'data_end_show_img_open'));
            if(empty($data_end_show_img_open) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否显示首页分类页数据加载完的底部图片','1','1',".time().",".$weid.",1,'data_end_show_img_open');");
            }
            //首页分类页数据加载完的底部图片
            $data_end_show_img = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'data_end_show_img'));
            if(empty($data_end_show_img) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('首页分类页数据加载完的底部图','/addons/group_buy/public/bg/footer_nomore.png','1',".time().",".$weid.",1,'data_end_show_img');");
            }
            //加载未完成时的默认图片（大）
            $default_big_img = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'default_big_img'));
            if(empty($default_big_img) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('加载未完成时的默认图片（大）','/addons/group_buy/public/bg/tmp_big.png','1',".time().",".$weid.",1,'default_big_img');");
            }
            //加载未完成时的默认图片（小）
            $default_small_img = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'default_small_img'));
            if(empty($default_small_img) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('加载未完成时的默认图片（小）','/addons/group_buy/public/bg/tmp_small.png','1',".time().",".$weid.",1,'default_small_img');");
            }
            //个人中心是否显示积分商城
            $member_sroce_show = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'member_sroce_show'));
            if(empty($member_sroce_show) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('个人中心是否显示积分商城','1','1',".time().",".$weid.",1,'member_sroce_show');");
            }
            //个人中心是否显示分销商城
            $member_distribution_show = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'member_distribution_show'));
            if(empty($member_distribution_show) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('个人中心是否显示分销商城','1','1',".time().",".$weid.",1,'member_distribution_show');");
            }
            //自定义社区或小区名称
            $diy_community_name = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'diy_community_name'));
            if(empty($diy_community_name) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('自定义社区或小区名称','社区','1',".time().",".$weid.",1,'diy_community_name');");
            }
			$appid = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'appid'));
            if(empty($appid) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('AppId','','1',".time().",".$weid.",1,'appid');");
            }
            $appsecret = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'appsecret'));
            if(empty($appsecret) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('AppSecret','','1',".time().",".$weid.",1,'appsecret');");
            }
            $pay_mchid = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'pay_mchid'));
            if(empty($pay_mchid) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('支付密匙','','1',".time().",".$weid.",1,'pay_mchid');");
            }
            $app_key = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'app_key'));
            if(empty($app_key) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('支付商户号','','1',".time().",".$weid.",1,'app_key');");
            }
            //团购名称信息
            $group_buy_name = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'group_buy_name'));
            if(empty($group_buy_name) ) {
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('自定义团购名称','团购','1',".time().",".$weid.",1,'group_buy_name');");
            }
			//平台截单
			$cutting_order = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'cutting_order'));
            if(empty($cutting_order) ) {
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启平台截单','2','1',".time().",".$weid.",1,'cutting_order');");
            }
			//团长名称
			$commander_name = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'group_buy_commander_name'));
            if(empty($commander_name) ) {
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('团长名称','团长','1',".time().",".$weid.",1,'group_buy_commander_name');");
            }
			//选择团长页面团长名称
			$choice = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'group_buy_choice'));
            if(empty($choice) ) {
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('下单页面和选择团长页面团长名称','团长','1',".time().",".$weid.",1,'group_buy_choice');");
            }
			//平台截单时间
			$cutting_order_time = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'cutting_order_time'));
            if(empty($cutting_order_time) ) {
            	$arr = [
            		'star_time'=>'20:00',
            		'end_time'=>'23:59',
            	];
				$arr = serialize($arr);
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('平台截单时间','".$arr."','1',".time().",".$weid.",1,'cutting_order_time');");
            }
            //平台截单提示信息
            $cutting_info = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'cutting_info'));
            if(empty($cutting_info) ) {
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('平台截单提示信息','平台每天的20:00-23:59无法下单，请该时间段过后在下单','1',".time().",".$weid.",1,'cutting_info');");
            }
			//催单设置
			$reminder_status = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'index_reminder_status'));
            if(empty($reminder_status) ) {
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启催单功能','1','1',".time().",".$weid.",1,'index_reminder_status');");
            }
			//是否开启催单给管理员发送信息
			$reminder_platform_status = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'index_reminder_platform_status'));
            if(empty($reminder_platform_status) ) {
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('催单是否给平台发送短信','1','1',".time().",".$weid.",1,'index_reminder_platform_status');");
            }

            //公司名称
            $company_name = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'company_name'));
            if(empty($company_name) ) {
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('公司名称','1','1',".time().",".$weid.",1,'company_name');");
            }

            //是否显示库存
            $show_stock = pdo_get($this->config,array('weid'=>$this->weid,'key'=>'show_stock'));
            if(empty($show_stock)){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否显示库存','1','1',".time().",".$weid.",1,'show_stock');");
            }
			
            
		    $info = pdo_getall($this->config,['status'=>1,'type'=>1,'weid'=>$weid],array(),"key");
            $back_title_set = pdo_get($this->config,array('status'=>1,'type'=>6,'weid'=>$weid,'key'=>'back_title_set'));
            $team_rank_info  =  unserialize($info['team_rank']['value']);
            $team_rank = array();
			if($team_rank_info){
	            foreach ($team_rank_info as $value){
	                $team_rank[]=$value['name'];
	            }
			}
		}
	break;
    case 'commission':
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
                $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'commission')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
//            $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'commission')), 'success');
        }else{
            $commission_ratio = pdo_get($this->config,array('key'=>'commission_ratio','weid'=>$weid));
            if(empty($commission_ratio) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('佣金比例设置','','3',".time().",".$weid.",1,'commission_ratio');");
            }
            $info = pdo_getall($this->config,['status'=>1,'type'=>3,'weid'=>$weid],array(),"key");
        }
        break;
    case 'index_set':
        if($_GPC['submit'] == '提交'){
            //提交数据

//            unset($_POST['submit']);
//            pdo_begin();
//            foreach ($_POST as $k =>$v){
//                $sql = "update ".tablename($this->config)." set value = '".$v."',time=".time()." where id =".$k;
//                $res = pdo_query($sql);
//            }
//            pdo_commit();
//            if(!empty($res)){
//                $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'index_set')), 'success');
//            }else{
//                $this->message_info("修改配置失败");
//            }
        }else{
//            $index_seckill = pdo_get($this->config,array('key'=>'index_seckill','weid'=>$weid));
//            if(empty($index_seckill) ){
//                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启首页秒杀模块','1','4',".time().",".$weid.",1,'index_seckill');");
//            }
//            $info = pdo_getall($this->config,['status'=>1,'type'=>4,'weid'=>$weid],array(),"key");
        }
        break;
    case 'msg':
        if($_GPC['submit'] == '提交'){
            //提交数据
//            var_dump($_POST['pay_success']);exit();
            $sms_code =  pdo_get($this->config,array('key'=>'sms_code','weid'=>$weid));
            if($_POST[$sms_code['id']] == '1'){
                $sms_data =  pdo_get($this->config,array('key'=>'sms_data','weid'=>$weid));
                $sms_admin =  pdo_get($this->config,array('key'=>'sms_admin','weid'=>$weid));
                $sms_pay =  pdo_get($this->config,array('key'=>'sms_pay','weid'=>$weid));
                $sms_watir =  pdo_get($this->config,array('key'=>'sms_watir','weid'=>$weid));
                $sms_refud =  pdo_get($this->config,array('key'=>'sms_refud','weid'=>$weid));
                $sms_get_cash =  pdo_get($this->config,array('key'=>'sms_get_cash','weid'=>$weid));
				$sms_pay =  pdo_get($this->config,array('key'=>'sms_pay','weid'=>$weid));
				$sms_reminder =  pdo_get($this->config,array('key'=>'sms_reminder','weid'=>$weid));
				
                $value = array();
                $value['key'] = $_POST['key'];
                $value['sign'] = $_POST['sign'];
                $value['serect'] = $_POST['serect'];
                $_POST[$sms_data['id']] = serialize($value);
                $_POST[$sms_admin['id']] = serialize($_POST['manage']);
                $_POST[$sms_pay['id']] = serialize($_POST['pay_success']);
                $_POST[$sms_watir['id']] = serialize($_POST['apply_head']);
                $_POST[$sms_refud['id']] = serialize($_POST['back_cash']);
                $_POST[$sms_get_cash['id']] = serialize($_POST['get_cash']);
                $_POST[$sms_reminder['id']] = serialize($_POST['reminder_cash']);
				
                unset($_POST['submit']);
                unset($_POST['key']);
                unset($_POST['sign']);
                unset($_POST['serect']);
                unset($_POST['manage']);
                unset($_POST['pay_success']);
                unset($_POST['apply_head']);
                unset($_POST['back_cash']);
                unset($_POST['get_cash']);
                unset($_POST['reminder_cash']);
            } else {
                unset($_POST);
                $_POST[$sms_code['id']]='-1';
            }
//            var_dump($_POST);exit();
            pdo_begin();
            foreach ($_POST as $k =>$v){
                $sql = "update ".tablename($this->config)." set value = '".$v."',time=".time()." where id =".$k;
                $res = pdo_query($sql);
            }
            pdo_commit();
            if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'msg')), 'success');
            } else {
                $this->message_info("修改配置失败");
            }
//            $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'msg')), 'success');
        }else{
            $sms_pay = pdo_get($this->config,array('key'=>'sms_pay','weid'=>$weid));
            if(empty($sms_pay) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('支付成功通知模版id及内容','','2',".time().",".$weid.",1,'sms_pay');");
            }
			//催单短信
            $sms_reminder = pdo_get($this->config,array('key'=>'sms_reminder','weid'=>$weid));
            if(empty($sms_reminder) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('催单通知模版id及内容','','2',".time().",".$weid.",1,'sms_reminder');");
            }
			//结束
            $sms_data = pdo_get($this->config,array('key'=>'sms_data','weid'=>$weid));
            if(empty($sms_data) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('短信的key,serect,签名','','2',".time().",".$weid.",1,'sms_data');");
            }
            $sms_refud = pdo_get($this->config,array('key'=>'sms_refud','weid'=>$weid));
            if(empty($sms_refud) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('退款通知模版id及内容','','2',".time().",".$weid.",1,'sms_refud');");
            }
            $sms_admin = pdo_get($this->config,array('key'=>'sms_admin','weid'=>$weid));
            if(empty($sms_admin) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('短信接受管理员','','2',".time().",".$weid.",1,'sms_admin');");
            }
            $sms_watir = pdo_get($this->config,array('key'=>'sms_watir','weid'=>$weid));
            if(empty($sms_watir) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('申请团长通知模版id及内容','','2',".time().",".$weid.",1,'sms_watir');");
            }
            $sms_code = pdo_get($this->config,array('key'=>'sms_code','weid'=>$weid));
            if(empty($sms_code) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('短信类型','1','2',".time().",".$weid.",1,'sms_code');");
            }
            $sms_type = pdo_get($this->config,array('key'=>'sms_type','weid'=>$weid));
            if(empty($sms_type) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否启用短信','1','2',".time().",".$weid.",1,'sms_type');");
            }
            $sms_get_cash = pdo_get($this->config,array('key'=>'sms_get_cash','weid'=>$weid));
            if(empty($sms_get_cash) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('提现通知模版id及内容','','2',".time().",".$weid.",1,'sms_get_cash');");
            }
            $info = pdo_getall($this->config,['status'=>1,'type'=>2,'weid'=>$weid],array(),"key");
//			echo '<pre>';
//			print_r($info);exit;
            if($info['sms_code']['value'] == '1') {
                $msg = unserialize($info['sms_data']['value']);//反序列化47
                $manage = unserialize($info['sms_admin']['value']);//反序列化49
                $pay_success = unserialize($info['sms_pay']['value']);//反序列化50
                $apply_head = unserialize($info['sms_watir']['value']);//反序列化51
                $back_cash = unserialize($info['sms_refud']['value']);//反序列化52
                $get_cash = unserialize($info['sms_get_cash']['value']);
               	$sms_reminder = unserialize($info['sms_reminder']['value']);
            }

        }
        break;
//    case "cloud_save":
//        if($_GPC['submit'] == '提交'){
//            //提交数据
//
//            unset($_POST['submit']);
//            pdo_begin();
//            foreach ($_POST as $k =>$v){
//                $sql = "update ".tablename($this->config)." set value = '".$v."',time=".time()." where id =".$k;
//                $res = pdo_query($sql);
//            }
//            pdo_commit();
//            $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'cloud_save')), 'success');
//        }else{
//            $cloud_save = pdo_get($this->config,array('key'=>'cloud_save','weid'=>$weid));
//            if(empty($cloud_save) ){
//                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启了云存储','-1','5',".time().",".$weid.",1,'cloud_save');");
//            }
//            $cloud_save_name = pdo_get($this->config,array('key'=>'cloud_save_name','weid'=>$weid));
//            if(empty($cloud_save_name) ){
//                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('云存储域名','','5',".time().",".$weid.",1,'cloud_save_name');");
//            }
//            $info = pdo_getall($this->config,['status'=>1,'type'=>5],array(),"key");
//        }
//        break;
    case 'set_new_weid':
        break;
//    case 'test':
//        $res = pdo_get('gpb_config',array('id'=>42));
//        var_dump(empty($res));
//        exit();
//        break;
    case 'title_set':
        if($_GPC['submit'] == '提交'){
            //提交数据

            unset($_POST['submit']);
            $data =serialize($_POST);
            $sql = "update ".tablename($this->config)." set value = '".$data."',time=".time()." where status = 1 and type =6 and ".tablename($this->config).".key='title_set' and weid=".$weid;
            $res = pdo_query($sql);
            if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'title_set')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
//            $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'title_set')), 'success');
        }else{
            $title_set = pdo_get($this->config,array('key'=>'title_set','weid'=>$weid));
            if(empty($title_set) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('页面标题设置','','6',".time().",".$weid.",1,'title_set');");
            }
            $info = pdo_getall($this->config,['status'=>1,'type'=>6,'weid'=>$weid],array(),"key");
            if(!empty($info['title_set']['value'])){
                $info = unserialize($info['title_set']['value']);
            }

        }
        break;

    case 'print_set':
        if($_GPC['submit'] == '提交'){
            //提交数据
//            var_dump($_POST);exit;
            unset($_POST['submit']);
            foreach ($_POST as $k=>$v){
                $_POST[$k]=trim($v);
            }
            if(empty($_POST['print_type'])){
                $this->message_info("请选择打印机类型");
            }
            if(empty($_POST['print_sn'])){
                $this->message_info("请填写打印机编号SN");
            }
            if(empty($_POST['print_key'])){
                $this->message_info("请填写打印机密钥KEY");
            }
            if(empty($_POST['print_name'])){
                $this->message_info("请填写打印机备注名称");
            }

            //调用打印机类
            $print_class = new print_sn();

            if(empty($_POST['print_sn_old'])){
                //新增打印机
                $res_add = $print_class->add_new($_POST['print_sn'],$_POST['print_key'],$_POST['print_name']);
                if(isset($res_add['msg']) && isset($res_add['ret']) && $res_add['ret']==-2){
                    $this->message_info($res_add['msg']);
                }
                if(isset($res_add['no'])){
                    $this->message_info($res_add['no']);
                }
            }elseif($_POST['print_sn_old'] != $_POST['print_sn']){
                //删除之前的
                $res_del = $print_class->del_print($_POST['print_sn_old']);
                if( isset($res_del['ok']) ){
                    //新增
                    $res_add = $print_class->add_new($_POST['print_sn'],$_POST['print_key'],$_POST['print_name']);
                    if(isset($res_add['msg']) && isset($res_add['ret']) && $res_add['ret']==-2){
                        $this->message_info($res_add['msg']);
                    }
                    if(isset($res_add['no'])){
                        $this->message_info($res_add['no']);
                    }
                }
            }
            $_POST['print_sn_old'] = $_POST['print_sn'];
            $data =serialize($_POST);
            $sql = "update ".tablename($this->config)." set value = '".$data."',time=".time()." where status = 1 and type =8 and ".tablename($this->config).".key='print_set' and weid=".$weid;
            $res = pdo_query($sql);
            if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'print_set')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
        }else{
            $print_set = pdo_get($this->config,array('key'=>'print_set','weid'=>$weid));
//            var_dump($order_set);
            if(empty($print_set) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('打印机设置','','8',".time().",".$weid.",1,'print_set');");
            }
            $info = pdo_getall($this->config,array('status'=>1,'key'=>'print_set','weid'=>$weid),array(),"key");
            if(!empty($info['print_set']['value'])){
                $info = unserialize($info['print_set']['value']);
            }

        }
        break;

    case 'menu_index':
        $where = '';
        if($_GPC['username']){
            $username = $_GPC['username'];
            $where .= " and username like '%".$username."%'";
        }
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
//        SELECT u.* FROM ims_users_permission AS up JOIN ims_users  AS u ON u.uid=up.uid WHERE up.uniacid=6 GROUP BY u.uid
        $total = pdo_fetchcolumn("select count(*) from ".tablename("users")." as u join ".tablename("users_permission")." as up on u.uid=up.uid where up.uniacid={$_W['uniacid']} ".$where." group by u.uid");
//        $total= pdo_fetchcolumn('select count(*) from ' . tablename("users")." where type != 0".$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
//        $sql = 'select * from '.tablename("users")." where type != 0 ".$where." order by uid desc ".$contion;
        $sql = "select u.* from ".tablename("users")." as u join ".tablename("users_permission")." as up on u.uid=up.uid where up.uniacid={$_W['uniacid']} ".$where." group by u.uid ".$contion;

        $info = pdo_fetchall($sql);
        break;
        //菜单授权
    case 'add':
        //权限管理
        $str = '';
        if($_GPC['submit'] == '提交'){
            $value = implode(",",$_GPC['rules']);
            $data = [];
            $data['uid'] = $_GPC['uid'];
            $data['value'] = $value;
            $data['status'] = 1;
            if($id){
                //修改
                $data['update_time'] = time();
                $res = pdo_update($this->menu,$data,array('id'=>$id));
            }else{
                //新增
                $data['time'] = time();
                $res = pdo_insert($this->menu,$data);
            }
            if($res){
                //成功
                $this->message_info('操作成功',$this->createWebUrl('config',array('op'=>'add','id'=>$_GPC['uid'])),'success');
            }else{
                $this->message_info('操作失败');
            }
        }else{
            $info = pdo_get($this->menu,array('uid'=>$id));
            if($info){
                $str = explode(',',$info['value']);
            }
        }
		$sql = 'select * from '.tablename($this->plug)." where status =1 and is_del = 1 order by plug_order desc,id desc ";
		$infos = pdo_fetchall($sql);
		$filename = tomedia('/addons/group_buy/inc/api/plug.php');
		$contents = $this->http_request($filename);
		$contents = json_decode($contents,true);
		$strs = 'a,';
		if($infos){
			foreach($infos as $k=>$v){
				$strs .= $v['key'].",";
			}
			$strs = trim($strs,',');
		}
        $menu = pdo_fetchall("select * from ".tablename($this->menu_list)." where pid = 0 and status = 1 order by sort asc");
        if(!empty($menu)){
            foreach($menu as $k=>$v){
                if($str != ''){
                    foreach($str as $kk=>$vv){
                        if($v['id'] == $vv){
                            $menu[$k]['check'] = 'checked';
                            break;
                        }
                    }
                }
                $data = pdo_fetchall("select * from ".tablename($this->menu_list)." where pid = ".$v['id']." and status = 1  order by sort asc");
                
                if(!empty($data) && $str != ''){
                    foreach($data as $i=>$j){
                        foreach($str as $ii=>$jj){
                            if($j['id'] == $jj){
                                $data[$i]['check'] = 'checked';
                                break;
                            }
                        }
                    }
                }
                $menu[$k]['data'] = $data;
                
                if($v['name'] == '营销' && $v['do'] == 'plug'){
                	$menu[$k]['name'] = '营销<span style="color:red;">(请选择插件下面的全部列表)</span>';
					$data_info = [];
					$is = 9999;
					if($contents && $strs){
						foreach($contents as $ks=>$vs){
							if($vs['info']){
								foreach($vs['info'] as $kks=>$vvs){
									if(strpos($strs,$vvs['eng_name'])){
										$vvs['is_show'] = 1;
									}
									$is = $is-1;
									$vvs['id'] = $is;
									if(is_array($str)){
										foreach($str as $ii=>$jj){
											if($is == $jj){
				                               $vvs['check'] = 'checked';
				                                break;
				                            }
										}
									}
									if($vvs['is_show'] == 1){
										$data_info[count($data_info)] = $vvs;
									}
								}
							}
						}
					}
					$menu[$k]['data'] = $data_info;
				}
			}
        }
        break;
    case 'express':
        //快递设置
        if($_GPC['submit'] == '提交'){
            //提交数据
//            var_dump($_POST);exit;
            unset($_POST['submit']);
            pdo_begin();
            foreach ($_POST as $k =>$v){
                if($k=='order_auto_get_goods_time'){
                    $sql = "update ".tablename($this->config)."  set `value` = '".serialize(array('order_auto_get_goods_time'=>$v))."',time=".time()." where `key` ='order_set' and weid=".$weid;
                }else{
                    $sql = "update ".tablename($this->config)." set `value` = '".$v."',time=".time()." where id =".$k;

                }
                $res = pdo_query($sql);
            }
            pdo_commit();
            if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('config',array('op'=>'express')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
        }else{
            //快递鸟商户id 设置
            $express_bird_id = pdo_get($this->config,array('key'=>'express_bird_id','weid'=>$weid));
            if(empty($express_bird_id) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('快递鸟商户ID','','12',".time().",".$weid.",1,'express_bird_id');");
            }
            //快递鸟API KEY 设置
            $express_bird_key = pdo_get($this->config,array('key'=>'express_bird_key','weid'=>$weid));
            if(empty($express_bird_key) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('快递鸟API KEY','','12',".time().",".$weid.",1,'express_bird_key');");
            }
            //是否开启快递
            $is_open_express = pdo_get($this->config,array('key'=>'is_open_express','weid'=>$weid));
            if(empty($is_open_express) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启快递','2','12',".time().",".$weid.",1,'is_open_express');");
            }
			//自提
			$mention = pdo_get($this->config,array('key'=>'mention_id','weid'=>$weid));
            if(empty($mention) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('是否开启自提','1','12',".time().",".$weid.",1,'mention_id');");
            }
			//自提  团长送货 快递  三种送货方式的名称
			$delivery_self = pdo_get($this->config,array('key'=>'delivery_self','weid'=>$weid),array('id'));
            if(empty($delivery_self) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('自提方式名称','自提','12',".time().",".$weid.",1,'delivery_self');");
            }
			//团长送货名称
			$delivery_chief = pdo_get($this->config,array('key'=>'delivery_chief','weid'=>$weid),array('id'));
            if(empty($delivery_chief) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('团长送货方式名称','团长送货','12',".time().",".$weid.",1,'delivery_chief');");
            }
			//快递送货名称
			$delivery_express = pdo_get($this->config,array('key'=>'delivery_express','weid'=>$weid),array('id'));
            if(empty($delivery_express) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('快递方式名称','快递','12',".time().",".$weid.",1,'delivery_express');");
            }
			//自提  团长送货 快递  三种送货方式的 排序
			$delivery_self_sort = pdo_get($this->config,array('key'=>'delivery_self_sort','weid'=>$weid));
            if(empty($delivery_self_sort) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('自提排序','1','12',".time().",".$weid.",1,'delivery_self_sort');");
				$delivery_self_sort = pdo_get($this->config,array('key'=>'delivery_self_sort','weid'=>$weid));
            }
			//团长送货名称
			$delivery_chief_sort = pdo_get($this->config,array('key'=>'delivery_chief_sort','weid'=>$weid));
            if(empty($delivery_chief_sort) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('团长送货排序','2','12',".time().",".$weid.",1,'delivery_chief_sort');");
                $delivery_chief_sort = pdo_get($this->config,array('key'=>'delivery_chief_sort','weid'=>$weid));
            }
			//快递送货名称
			$delivery_express_sort = pdo_get($this->config,array('key'=>'delivery_express_sort','weid'=>$weid));
            if(empty($delivery_express_sort) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('快递排序','3','12',".time().",".$weid.",1,'delivery_express_sort');");
				$delivery_express_sort = pdo_get($this->config,array('key'=>'delivery_express_sort','weid'=>$weid));
            }
			
            $is_open_express = pdo_get($this->config,array('key'=>'is_open_express','weid'=>$weid));
            $express_bird_key = pdo_get($this->config,array('key'=>'express_bird_key','weid'=>$weid));
            $express_bird_id = pdo_get($this->config,array('key'=>'express_bird_id','weid'=>$weid));
            $mention = pdo_get($this->config,array('key'=>'mention_id','weid'=>$weid));
            
			$delivery_express = pdo_get($this->config,array('key'=>'delivery_express','weid'=>$weid));
			$delivery_chief = pdo_get($this->config,array('key'=>'delivery_chief','weid'=>$weid));
			$delivery_self = pdo_get($this->config,array('key'=>'delivery_self','weid'=>$weid));
        }
        break;

    case 'express_tmp':
        //快递管理
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //key关键词
        $key = trim($_GPC['key']);
        if(!empty($key)){
            $where .=" and ( simplecode like '%".$key."%' or name like '%".$key."%' )";
        }
        //查看系统的在不在
        $is_have = pdo_fetchcolumn("select count(*) from ".tablename('gpb_express')." where  weid =0 and is_del =1 ");
        if($is_have <=0){
            $this->create_express_system_tmp();
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn("select count(*) from ".tablename('gpb_express')." where (weid=".$weid." or weid =0) and is_del =1 ".$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = "select * from ".tablename('gpb_express')." where (weid=".$weid." or weid =0) and is_del =1 ".$where." order by `system` desc ".$contion;
        $info = pdo_fetchall($sql);
        break;
    case 'express_tmp_add':
        //新增/编辑快递
        if($_GPC['submit'] == '提交'){
            $name = trim($_GPC['name']);
            $simplecode = trim($_GPC['simplecode']);
            if(empty($name)){
                $this->message_info("请填写快递名称");
            }
            if(empty($simplecode)){
                $this->message_info("请填写快递简码");
            }
            $data = array(
                'name'=>$name,
                'simplecode'=>$simplecode,
                'start'=>$_GPC['start'],
                'system'=>2,
                'status'=>1,
            );
            if($id){
                $data['update_time'] = time();
                $res = pdo_update('gpb_express',$data,array('id'=>$id,'weid'=>$weid));
            }else{
                $data['create_time'] = time();
                $data['weid'] = $weid;
                $res = pdo_insert('gpb_express',$data);
            }
            if(!empty($res)){
                $this->message_info("操作成功",$this->createWebUrl('config',array('op'=>'express_tmp')), 'success');
            }else{
                $this->message_info("操作失败");
            }
        }else{
            $act_title = '新增';
            if($id){
                $info = pdo_get("gpb_express",array("id"=>$id,'weid'=>$weid));
                $act_title = '编辑';
            }
        }
        break;
    case "express_tmp_del":
        //删除快递
        if($id){
            $id = trim($id,',');
            $id_arr = explode(",",$id);
            if(count($id_arr) > 1){
                foreach ( $id_arr as $v ){
                    $res = pdo_update("gpb_express",array('is_del'=>2),array('id'=>$v,'weid'=>$weid));
                }
            }else{
                $res = pdo_update("gpb_express",array('is_del'=>2),array('id'=>$id,'weid'=>$weid));
            }
            if($res){
                echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;
            }else{
                echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;
            }
        }else{
            echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;
        }
        break;
    case "shipping":
        //运费模版
        $index=isset($_GPC['page'])?$_GPC['page']:1;
        $pageIndex = $index;
        $pageSize = 10;
        $where = " ";
        //key关键词
        $key = trim($_GPC['key']);
        if(!empty($key)){
            $where .=" and ( name like '%".$key."%' )";
        }
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $total= pdo_fetchcolumn("select count(*) from ".tablename('gpb_express_shipping')." where (weid=".$weid.") and is_del =1 ".$where);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        $sql = "select * from ".tablename('gpb_express_shipping')." where (weid=".$weid.") and is_del =1 ".$where." order by sort_order asc ".$contion;
        $info = pdo_fetchall($sql);
        break;
    case 'shipping_add':
        //新增/编辑运费模版
        if($_GPC['submit'] == '提交'){
            $name = trim($_GPC['name']);
            if(empty($name)){
                $this->message_info("请填写配送方式名称");
            }
//			default_secondweight
            $sort_order = trim($_GPC['sort_order']);
            $isdefault = trim($_GPC['isdefault']);
            $type = trim($_GPC['type']);
            if( $type ==1){
                $default_firstweight = trim($_GPC['default_firstweight']);
                $default_firstprice = trim($_GPC['default_firstprice']);
                $default_secondweight = trim($_GPC['default_secondweight']);
                $default_secondprice = trim($_GPC['default_secondprice']);
				if((empty($default_firstweight) && $default_firstweight != 0) || (empty($default_firstprice) && $default_firstprice != 0) || (empty($default_secondweight) && $default_secondweight != 0) || (empty($default_secondprice) && $default_secondprice != 0) ){
					$this->message_info("请填写完规则");
				}
//              if(empty($default_firstweight) || empty($default_firstprice) || empty($default_secondweight) || empty($default_secondprice)){
//                  
//              }
                $default_firstnum = 0;
                $default_firstnumprice = 0;
                $default_secondnum = 0;
                $default_secondnumprice = 0;
            }elseif($type ==2){
                $default_firstweight = 0;
                $default_firstprice = 0;
                $default_secondweight = 0;
                $default_secondprice = 0;
                $default_firstnum = trim($_GPC['default_firstnum']);
                $default_firstnumprice = trim($_GPC['default_firstnumprice']);
                $default_secondnum = trim($_GPC['default_secondnum']);
                $default_secondnumprice = trim($_GPC['default_secondnumprice']);
                if((empty($default_firstnum) && $default_firstnum != 0) || (empty($default_firstnumprice) && $default_firstnumprice !=0)|| (empty($default_secondnum) && $default_secondnum != 0) || (empty($default_secondnumprice) && $default_secondnumprice != 0)){
                    $this->message_info("请填写完规则");
                }
            }else{
                $this->message_info("请选择计费方式");
            }
            $data = array(
                'name'=>$name,
                'sort_order'=>$sort_order,
                'isdefault'=>$isdefault,
                'type'=>$type,
                'firstweight'=>$default_firstweight,
                'firstprice'=>$default_firstprice,
                'secondweight'=>$default_secondweight,
                'secondprice'=>$default_secondprice,
                'firstnum'=>$default_firstnum,
                'firstnumprice'=>$default_firstnumprice,
                'secondnum'=>$default_secondnum,
                'secondnumprice'=>$default_secondnumprice,
                'enabled'=>1,
                'is_del'=>1
            );
            $random = $_GPC['random'];
            if(is_array($random)){
                foreach ($random as $v){
                    $citys_name = trim($_GPC['citys_name'][$v]);
                    if (empty($citys_name)) {
                        continue;
                    }
                    if ($_GPC['firstnum'][$v] < 1) {
                        $_GPC['firstnum'][$v] = 1;
                    }
                    if ($_GPC['secondnum'][$v] < 1) {
                        $_GPC['secondnum'][$v] = 1;
                    }
					if($_GPC['type'] == 1){
	                    $areas[] = array('citys_name' => trim($_GPC['citys_name'][$v],','), 'citys_code' => trim($_GPC['citys_code'][$v],','), 'frist' => $_GPC['frist'][$v], 'frist_price' => max(0, $_GPC['firstprice'][$v]), 'second' => $_GPC['second'][$v],'second_price' => $_GPC['secondprice'][$v],'random'=>$v);
					}else{
						 $areas[] = array('citys_name'=> trim($_GPC['citys_name'][$v],','), 'citys_code' => trim($_GPC['citys_code'][$v],','),'frist'=>$_GPC['firstnum'][$v],'frist_price' => max(0,$_GPC['firstnumprice'][$v],','),'second'=>$_GPC['secondnum'][$v],'second_price'=>$_GPC['secondnumprice'][$v],'random'=>$v);
					}
                }
            }
            $data['areas'] = serialize($areas);
            pdo_begin();
            if($isdefault == 1){
                $res = pdo_update("gpb_express_shipping",array("isdefault"=>2),array('weid'=>$weid));
                if(empty($res)){
                    pdo_rollback();
                }
            }
            if($id){
//	            echo '<pre>';
//				print_r($data);
//				exit;
                $res = pdo_update('gpb_express_shipping',$data,array('id'=>$id,'weid'=>$weid));
            }else{
                $data['weid'] = $weid;
                $res = pdo_insert('gpb_express_shipping',$data);
            }
            if(!empty($res)){
                pdo_commit();
                $this->message_info("操作成功",$this->createWebUrl('config',array('op'=>'shipping')), 'success');
            }else{
                pdo_rollback();
                $this->message_info("操作失败");
            }
        }else{
            $act_title = '新增';
            if($id){
                $info = pdo_get("gpb_express_shipping",array("id"=>$id,'weid'=>$weid));
                $act_title = '编辑';
                $areas = unserialize($info['areas']);
//                var_dump($info);
//                var_dump($areas);exit;
            }
        }
        break;
        //改变运费模版状态
    case "setShippingStatus":
        $id = trim($_GPC['id']);
        $val = trim($_GPC['val']);
        if(!empty($id)){
           $res = pdo_update("gpb_express_shipping",array("enabled"=>$val),array('id'=>$id,'weid'=>$weid));
           if(!empty($res)){
               echo json_encode(array('status'=>0,'msg'=>'改变状态成功'));exit;
           }else{
               echo json_encode(array('status'=>1,'msg'=>'改变状态失败'));exit;
           }
        }else{
            echo json_encode(array('status'=>1,'msg'=>'改变状态失败'));exit;
        }
        break;
    //改变运费默认选择
    case "setShippingDefault":
        $id = trim($_GPC['id']);
        $val = trim($_GPC['val']);
        if(!empty($id)){
            if($val == 1){
                //改变为启用
                pdo_update("gpb_express_shipping",array("isdefault"=>2),array('weid'=>$weid));
            }
            $res = pdo_update("gpb_express_shipping",array("isdefault"=>$val),array('id'=>$id,'weid'=>$weid));
            if(!empty($res)){
                echo json_encode(array('status'=>0,'msg'=>'切换默认成功'));exit;
            }else{
                echo json_encode(array('status'=>1,'msg'=>'切换默认失败'));exit;
            }
        }else{
            echo json_encode(array('status'=>1,'msg'=>'切换默认失败'));exit;
        }
        break;
    //删除运费模版
    case "shippingDel":
        if($id){
            $id = trim($id,',');
            $id_arr = explode(",",$id);
            foreach ($id_arr as $v){
                $res = pdo_update('gpb_express_shipping',array('is_del'=>-1),array('id'=>$v,'weid'=>$weid));
            }
            if($res){
                echo json_encode(array('status'=>0,'msg'=>'删除成功'));exit;
            }else{
                echo json_encode(array('status'=>1,'msg'=>'删除失败'));exit;
            }
        }else{
            echo json_encode(array('status'=>1,'msg'=>'非法进入'));exit;
        }
        break;
    //运费模版区域运费规则
    case "shipping_tpl":
        $info['type']=trim($_GPC['type']);
        $random = date("Ymd",time()).random(5);
        $codes = trim($_GPC['codes'],',');
        $codes = explode(',',$codes);

        //检查缓存
        cache_delete('shipping_areas');
        $shipping_areas  = cache_load('shipping_areas');
        if(empty($cate)) {
            $province_t = pdo_getall("gpb_area",array('pid'=>0));
            foreach ($province_t as $k=>$v){
                $province_t[$k]['city'] = pdo_getall("gpb_area",array('pid'=>$v['ad_code']));
                foreach ( $province_t[$k]['city'] as $key =>$val){
                    $province_t[$k]['area'] = pdo_getall("gpb_area",array('pid'=>$val['ad_code']));
                }
            }
            cache_write('shipping_areas',$province_t);
        }

        $shipping_areas  = cache_load('shipping_areas');
        break;
    case 'test1':
        $info = pdo_getall('gpb_goods_to_category',array('id >='=>0));
        foreach ($info as $k => $v ){
            $goods = pdo_get("gpb_goods",array('g_id'=>$v['goods_id']));
            pdo_update('gpb_goods_to_category',array('weid'=>$goods['weid']),array('id'=>$v['id']));
        }
        exit(1);
		break;
    case 'test2':
        $distribution_group = pdo_getall('gpb_distribution_group',array('id >'=>0));
        if(is_array($distribution_group)){
            foreach ($distribution_group as $k =>$v){
                $id = $v['leader_id'];
                $v1 = explode(",",$v['lv1']);
                $v2 = explode(",",$v['lv2']);
                $v3 = explode(",",$v['lv3']);
                if(is_array($v1)){
                    foreach ($v1 as $k1=>$v1_v){
                        if($v1_v == $id){
                            unset($v1[$k1]);
                        }
                    }
                }
                if(is_array($v2)){
                    foreach ($v2 as $k2=>$v2_v){
                        if($v2_v == $id){
                            unset($v2[$k2]);
                        }
                        if(is_array($v1)){
                            if(in_array($v2_v,$v1)){
                                unset($v2[$k2]);
                                continue;
                            }
                        }
                    }
                }
                if(is_array($v3)){
                    foreach ($v3 as $k3 =>$v3_v){
                        if($v3_v == $id){
                            unset($v3[$k3]);
                            continue;
                        }
                        if(is_array($v1)){
                            if(in_array($v3_v,$v1)){
                                unset($v3[$k3]);
                                continue;
                            }
                        }
                        if(is_array($v2)){
                            if(in_array($v3_v,$v2)){
                                unset($v3[$k3]);
                                continue;
                            }
                        }
                    }
                }
                pdo_update('gpb_distribution_group',array('lv1'=>implode(',',$v1),'lv2'=>implode(',',$v2),'lv3'=>implode(',',$v3)),array('id'=>$v['id']));
                unset($v1);
                unset($v2);
                unset($v3);
            }
        }
        exit;
    case 'test3':
        $info = pdo_getall('gpb_order_snapshot',array('oss_commission_num >'=>0));
        foreach ($info as $v) {
            pdo_update('gpb_order_snapshot',array('oss_commission'=>floatval($v['oss_g_num']*$v['oss_g_price']*$v['oss_commission_num']/100)),array('oss_id'=>$v['oss_id']));
        }
        exit();
        break;
    case "test4":
        $all_send_head = pdo_getall('gpb_member',array('m_is_head'=>2,'m_add_time <'=>strtotime('2019-5-20')));
        if(is_array($all_send_head)){
            foreach ($all_send_head as $v){
                $order = pdo_getall('gpb_order',array('go_status'=>100,'go_add_time <'=>strtotime('2019-5-20'),'go_team_openid'=>$v['m_openid'],'go_send_type'=>2,'go_send_pay >'=>0,'go_send_price_status'=>1));
                if(is_array($order)){
                    $sum = 0;
                    foreach ($order as $val){
                        $sum = floatval($sum)+floatval($val['go_send_pay']);
                        pdo_update('gpb_order',array('go_send_price_status'=>2),array('go_id'=>$val['go_id']));
                    }
                    if($sum>0){
                        pdo_update('gpb_member',array('m_send_price_total'=>$sum),array('m_id'=>$v['m_id']));
                    }
                }
            }
        }
        pdo_debug();
        exit;

        break;
    case "test5":
        $res = pdo_fetchall("select * from ".tablename('gpb_order_stream')."  where gos_stream_type=3 and gos_status=2 and gos_shoudong_deal=1 group by gos_go_code order by gos_id desc limit 1");
        if(!empty($res)){
            foreach ($res as $k=>$v){
                $deal_arr = pdo_fetchall("select * from ".tablename('gpb_order_stream')."  where gos_stream_type=3 and gos_status=2 and gos_shoudong_deal=1 and gos_go_code=".$v['gos_go_code']." and gos_code <>".$v['gos_code']);
                if(!empty($deal_arr)){
                    foreach ($deal_arr as $deal_arr_k=>$deal_arr_v){
                        pdo_update('gpb_member',array('m_money -='=>$deal_arr_v['gos_real_money']),array('m_openid'=>$deal_arr_v['gos_team_openid']));
                        pdo_update('gpb_order_stream',array('gos_order_money'=>-$deal_arr_v['gos_order_money'],'gos_real_money'=>-$deal_arr_v['gos_real_money']),array('gos_id'=>$deal_arr_v['gos_id']));
                    }
                }
                pdo_update('gpb_order_stream',array('gos_shoudong_deal'=>2),array('gos_go_code'=>$v['gos_go_code']));
            }
        }
        var_dump($res);
        exit;
        break;
	case 'login':
		if($_GPC['token'] == 'submit'){
			//出入账号密码
			if(empty($_GPC['login'])){
				echo json_encode(['code'=>2,'msg'=>'请输入账号']);exit;
			}
			if(empty($_GPC['pass1'])){
				echo json_encode(['code'=>2,'msg'=>'请输入密码']);exit;
			}
			if(empty($_GPC['pass2'])){
				echo json_encode(['code'=>2,'msg'=>'请输入密码']);exit;
			}
			if($_GPC['pass2'] != $_GPC['pass1'] ){
				echo json_encode(['code'=>2,'msg'=>'两次密码不一致']);exit;
			}
			if($id){
				//修改密码
				$code = $this->randomkeys(8);
				$p = $_GPC['pass1'].'-'.$code.'-'.$_W['config']['setting']['authkey'];
				$pass = sha1($p);
				$res = pdo_update("users",array('password'=>$pass),array('id'=>$id));
				if($res){
					echo json_encode(['code'=>1,'msg'=>'密码修改成功']);exit;
				}else{
					echo json_encode(['code'=>2,'msg'=>'密码修改失败']);exit;
				}
			}else{
				//新增
					//判断该账号是否存在
				$logins = pdo_get("users",array('username'=>$_GPC['login']));
				if($logins){
					echo json_encode(['code'=>2,'msg'=>'该账号已存在']);exit;
				}
				$group = pdo_get("users_group");
				if(empty($group)){
					//添加权限组
					//判断有没有权限组
					$gs = pdo_fetch("select * from ".tablename("uni_group")." where modules like '%group_buy%'");
					$a = array (
						'modules' => array (),
					  	'wxapp' => array (
						    0=> 'group_buy',
						    1=> 'group_buy_plugin_fraction',
						    2=> 'group_buy_plugin_distribution',
						    3=> 'group_buy_plugin_seckill',
					  	),
					  	'webapp' => array (),
					  	'phoneapp' => array (),
					  	'xzapp' => array (),
					  	'aliapp' =>array (),
					  	'baiduapp' => array (),
					  	'toutiaoapp' => array (),
					);
					if(empty($gs)){
						pdo_update("uni_group",array('modules'=>serialize($a)),array('id'=>1));
					}
					//关系绑定
					pdo_insert("users_extra_group",array('uid'=>$uid,'uni_group_id'=>$gs['id'],'create_group_id'=>0));	
					$res = pdo_insert("users_group",array('owner_uid'=>0,'name'=>'用户权限组','maxaccount'=>0,'maxsubaccount'=>0,'timelimit'=>0,'maxwxapp'=>1,'maxwebapp'=>0,'maxphoneapp'=>0,'maxxzapp'=>0,'maxaliapp'=>0,'maxbaiduapp'=>0,'maxtoutiaoapp'=>0));
					if(empty($res)){
						//添加失败  请重试
						echo json_encode(['code'=>2,'msg'=>'添加失败,请重试!']);exit;
					}
				}
				//随机8位数
				$code = $this->randomkeys(8);
				$p = $_GPC['pass1'].'-'.$code.'-'.$_W['config']['setting']['authkey'];
				$pass = sha1($p);
				$data = array(
					'groupid'=>$group['id'],
					'founder_groupid'=>0,
					'username'=>$_GPC['login'],
					'password'=>$pass,
					'salt'=>$code,
					'type'=>1,
					'status'=>2,
					'joindate'=>time(),
					'joinip'=>$_SERVER["REMOTE_ADDR"],
					'lastvisit'=>time(),
					'lastip'=>$_SERVER["REMOTE_ADDR"],
					'remark'=>'',
					'starttime'=>time(),
					'endtime'=>2,
					'register_type'=>0,
					'openid'=>'',
					'welcome_link'=>0,
					'notice_setting'=>'',
				);
				$res = pdo_insert("users",$data);
				if(empty($res)){
					echo json_encode(['code'=>2,'msg'=>'添加失败,请重试!']);exit;
				}
				$uid = pdo_insertid();
				pdo_insert("uni_account_users",array("uniacid"=>$this->weid,'uid'=>$uid,'role'=>'manager','rank'=>0));
				pdo_insert("users_permission",array("uniacid"=>$this->weid,'uid'=>$uid,'type'=>'modules','permission'=>'all'));
				echo json_encode(['code'=>1,'msg'=>'添加成功!!']);exit;
			}
		}else{
			if($id){
				$info = pdo_get("users",array('id'=>$id));
			}
		}
	break;
    case 'wxapp':
        //小程序APPID serect配置

        if(!empty($_GPC['submit'])){
            /*echo "<pre/>";
            var_dump($_POST);
            die;*/
            $data = $_POST;
            $cert_address = pdo_get($this->config,array('key'=>'cert_address','weid'=>$weid));
            $cert_id = $cert_address['id'];
            if(isset($_FILES['cert_address']) and $_FILES['cert_address']['error'] == 0 and $_FILES['cert_address']['size'] > 0 ){

                if(is_uploaded_file($_FILES['cert_address']['tmp_name'])){
                    list($f_name,$f_ext) = explode('.', $_FILES['cert_address']['name']);
                    $rand = md5(uniqid().rand(1111,9999));
                    if(!file_exists("../addons/group_buy/public/files")){
                        mkdir("../addons/group_buy/public/files");
                    }
                    $filename = '/addons/group_buy/public/files/'.$rand.'.'.$f_ext;
                    $return = move_uploaded_file($_FILES['cert_address']['tmp_name'],"..".$filename);
                    if(!$return){
                        $this->message_info('文件上传失败');
                    }else{
                        if(!empty($_POST['old_cert_address'])){
                            @unlink('..'.$_POST['old_cert_address']);
                        }
                        pdo_update("gpb_config",array('value'=>$filename),array('id'=>$cert_id));
                    }
                }else{
                    $this->message_info('非法文件上传');
                }
            }
            $key_address = pdo_get($this->config,array('key'=>'key_address','weid'=>$weid));
            $key_id = $key_address['id'];
            if(isset($_FILES['key_address']) and $_FILES['key_address']['error'] == 0 and $_FILES['key_address']['size'] > 0 ){
                if(is_uploaded_file($_FILES['key_address']['tmp_name'])){
                    list($f_name,$f_ext) = explode('.', $_FILES['key_address']['name']);
                    $rand = md5(uniqid().rand(1111,9999));
                    if(!file_exists("../addons/group_buy/public/files")){
                        mkdirs("../addons/group_buy/public/files");
                    }
                    $filename_2 = '/addons/group_buy/public/files/'.$rand.'.'.$f_ext;
                    $return = move_uploaded_file($_FILES['key_address']['tmp_name'],"..".$filename_2);
                    if(!$return){
                        $this->message_info('文件上传失败');
                    }else{
                        if(!empty($_POST['old_key_address'])){
                            @unlink('..'.$_POST['old_key_address']);
                        }
                        pdo_update("gpb_config",array('value'=>$filename_2),array('id'=>$key_id));
                    }
                }else{
                    $this->message_info('非法文件上传');
                }
            }

            $data1 = [
                'key'=>$data['key'],
                'secret'=>$data['secret'],
            ];

            $payment = [
                'wechat'=>[
                    'mchid'=>$data['mchid'],
                    'signkey'=>$data['signkey'],
                    'account'=>$this->weid,
                ],
            ];
            pdo_update("gpb_config",['value'=>$data['mchid']],['key'=>'pay_mchid','weid'=>$this->weid]);
            pdo_update("gpb_config",['value'=>$data['signkey']],['key'=>'app_key','weid'=>$this->weid]);
            pdo_update("gpb_config",['value'=>$data['key']],['key'=>'appid','weid'=>$this->weid]);
            pdo_update("gpb_config",['value'=>$data['secret']],['key'=>'appsecret','weid'=>$this->weid]);

            $data2 = ['payment'=>serialize($payment)];

            $res = pdo_update("account_wxapp",$data1,array('acid'=>2));
            if($res!==false){
                $res = pdo_update("uni_settings",$data2,array('uniacid'=>$this->weid));
            }
            $res!==false? $this->message_info("保存成功",$this->createWebUrl('config',array('op'=>'wxapp')),'success'): $this->message_info("保存失败请重试");
        }else{
            $info = pdo_fetch("select * from ".tablename("account_wxapp")." where acid=2");
            //获取支付配置
            $payment = pdo_fetchcolumn("select `payment` from ".tablename("uni_settings")." where uniacid={$this->weid}");
            $payment = !empty($payment)?unserialize($payment):['wechat'=>['mchid'=>'','signkey'=>'','account'=>$this->weid]];
            $payment = $payment['wechat'];

            $cert_address = pdo_get($this->config,array('key'=>'cert_address','weid'=>$weid));
            if(empty($cert_address) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('证书路径','','1',".time().",".$weid.",1,'cert_address');");
//                $cert_address = pdo_get($this->config,array('key'=>'cert_address','weid'=>$weid));
            }
            $key_address = pdo_get($this->config,array('key'=>'key_address','weid'=>$weid));
            if(empty($key_address) ){
                pdo_query("INSERT  INTO `".$pre."gpb_config` (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('密钥路径','','1',".time().",".$weid.",1,'key_address');");
//                $key_address = pdo_get($this->config,array('key'=>'key_address','weid'=>$weid));
            }
            $pem = pdo_fetchall("select * from ".tablename("gpb_config")." where weid={$this->weid} and `key` in ('cert_address','key_address')");
            foreach ($pem as  $k=>$v){
                $pem[$v['key']] = $v;
                unset($pem[$k]);
            }
        }
        break;
}
include $this -> template('web/' . $do . '/' . $op);
?>