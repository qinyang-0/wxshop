<?php
/**
 * 在线更新
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
empty($in) ? $in = 'index' : $in ;
$weid = $this->weid;  //控制模块
include '../addons/group_buy/%75%70%64%61%74%65%2E%70%68%70';
$update = new AutoUpdate();
switch($op){
    case 'index':
        //获取当前版本号
        $now_version_num_arr = pdo_get('modules',array('name'=>'group_buy','type'=>'business'));
        $now_version_num ='';
        if(isset($now_version_num_arr['version']) && !empty($now_version_num_arr['version']) ){
            $now_version_num = $now_version_num_arr['version'];
        }
        $ver = $now_version_num;
       /* switch($in){
            case 'index':
                //检查是否需要更新  并作出相应的判断   检查更新   当前版本号
                //		$ver = 0.1;
                $a = $update->doPageauthorization();
                $update->currentVersion = $ver; //版本号，整数
                $update->updateUrl = 'http://%73%71%2E%73%63%6D%6D%77%6C%2E%63%6F%6D/upgrade'; //更新服务器URL
                $latest = $update->checkUpdate($ver);//检查更新
                if ($latest !== false) {
                    if ($latest > $update->currentVersion) {
                        //有更新  更新版本是好多 1.版本号 2.版本更新内容
                        $data = [
                            'latestVersionName'=>$update->latestVersionName,
                            'content'=>$update->content,
                        ];
                    } else {
                        //没有更新
                        $data = [];
                    }
                }else{
                    exit('非法进入');
                }
                break;
            case 'wx':

        }*/
        //微信小程序准备
        //显示需要填写的备注，版本号，
        //可跳转小程序设置
//				tominiprogram
        $wxapp = pdo_get("wxapp_versions",array('uniacid'=>$this->weid));
        if($wxapp['tominiprogram']){
            $tomin = unserialize($wxapp['tominiprogram']);
        }
        break;
        break;
    case 'update':
        //文件更新分成两步走  1.下载zip文件包 2.解压  覆盖文件
        $now_version_num_arr = pdo_get('modules',array('name'=>'group_buy','type'=>'business'));
        $now_version_num ='';
        if(isset($now_version_num_arr['version']) && !empty($now_version_num_arr['version']) ){
            $now_version_num = $now_version_num_arr['version'];
        }
        $ver = $now_version_num;
        //检查是否需要更新  并作出相应的判断   检查更新   当前版本号
//		$ver = 0.1;
        $update->doPageauthorization();//判断权限
        $update->currentVersion = $ver; //版本号，整数
        $update->updateUrl = 'http://%73%71%2E%73%63%6D%6D%77%6C%2E%63%6F%6D/upgrade'; //更新服务器URL
        $latest = $update->checkUpdate($ver);//检查更新
        $bh = $update->latestVersionName;
        if ($latest !== false) {
            //判断当前版本的文件是否下载下来  第二次进入就不用重新下载了
            $zip = dirname(__FILE__).'/../../attachment/temp/'.$bh.'.zip';
            if(!file_exists($zip)){
                if (floatval($latest) > floatval($update->currentVersion)) {
                    $zip = $update->update();
                }else{
                    //暂无更新
                    exit('暂无更新');
                }
            }
        }else{
            //暂无更新
            exit('暂无更新');
        }
        break;
    case 'update_php':
        //更新版本号
        if(empty($_GPC['ver'])){
            echo json_encode(['code'=>2,'msg'=>'版本号错误']);exit;
        }
        $res = pdo_update("modules",array('version'=>$_GPC['ver']),array('name'=>'group_buy'));
        if($res) {
            echo json_encode(['code'=>1,'msg'=>'更新成功']);exit;
        } else {
            echo json_encode(['code'=>2,'msg'=>'版本号更新失败']);exit;
        }
        break;
    case 'update_rollback':
        //失败回滚



        break;
    case 'update_sql':
        //更新sql之前  需要备份当前的sql信息
        include_once '../addons/group_buy/public/backups_sql.php';
        $back = new Backup();
        $arr = $back->backupAll();
        if($arr){
            //备份成功  执行删除操作
            //获取文件夹下面的全部sql文件
            $data = $back->dirs();
            //当备份大于3份的时候  删除以前的
            //获取后台配置信息
            $backs = pdo_get("gpb_config",array("key"=>"back_sql_index",'weid'=>$this->weid));
            if($backs){
                $backs = $backs['value'];
            }else{
                $backs = 3;
            }
            if(count($data) >= 3 && $backs != 0){
                foreach($data as $k=>$v){
                    //删除文件
                    if($k+4 < count($data)){
                        unlink($v);
                    }
                }
            }
        }
//		获取数据库名称    的第一种办法   第二张办法是直接改底层文件db类
//		$fp = fopen('../data/config.php' , 'r');
//		$database = "";
//		while (!feof($fp)) {
//			$buffer = fgets($fp);
//			if(substr_count($buffer,"ster']['database']") >= 1){
//				echo $buffer;echo '<br/>';
//				$database = substr($buffer, 39, -4);
//
//			}
//		}
        //当前页面显示的错误级别
        error_reporting(0);//关闭当前页面全部错误
        $group_buy = '../addons/group_buy/upgrade.php';
        $group_buy_plugin_distribution = '../addons/group_buy_plugin_distribution/upgrade.php';
        $group_buy_plugin_fraction = '../addons/group_buy_plugin_fraction/upgrade.php';
        $group_buy_plugin_seckill = '../addons/group_buy_plugin_seckill/upgrade.php';
        include_once $group_buy;
        include_once $group_buy_plugin_distribution;
        include_once $group_buy_plugin_fraction;
        include_once $group_buy_plugin_seckill;
        echo json_encode(['code'=>1,'msg'=>'数据库更新成功']);exit;
        break;
    case 'jump':
        if($_GPC['token'] == 'submit'){
            $appid = $_GPC['appid'];
            $name = $_GPC['name'];
            if(empty($appid)){
                echo json_encode(array('code'=>2,'msg'=>'请填写需要跳转小程序的appid'));exit;
            }
            if(empty($name)){
                echo json_encode(array('code'=>2,'msg'=>'请填写需要跳转小程序的名称'));exit;
            }
            $wxapp = pdo_get("wxapp_versions",array('uniacid'=>$this->weid));
            if($wxapp['tominiprogram']){
                $tomin = unserialize($wxapp['tominiprogram']);
            }
            $arr = array(
                $appid=>array(
                    'appid'=>$appid,
                    'app_name'=>$name,
                ),
            );
            if($tomin){
                //有appid那些了  追加
                if(count($tomin) >= 9){
                    echo json_encode(array('code'=>2,'msg'=>'只能添加10个可跳转的小程序'));exit;
                }
                //合并
                $arr = array_merge($tomin,$arr);
            }
            $res = pdo_update("wxapp_versions",array('tominiprogram'=>serialize($arr)),array('id'=>$wxapp['id']));
            if($res){
                echo json_encode(array('code'=>1,'msg'=>'添加成功'));exit;
            }else{
                echo json_encode(array('code'=>2,'msg'=>'添加失败'));exit;
            }
        }
        $wxapp = pdo_get("wxapp_versions",array('uniacid'=>$this->weid));
        if($wxapp['tominiprogram']){
            $tomin = unserialize($wxapp['tominiprogram']);
        }
        break;
    case 'jump_del':
        $wxapp = pdo_get("wxapp_versions",array('uniacid'=>$this->weid));
        if($wxapp['tominiprogram']){
            $tomin = unserialize($wxapp['tominiprogram']);
        }
        $appid = $_GPC['appid'];
        if(empty($appid)){
            echo json_encode(array('code'=>2,'msg'=>'请填写需要跳转小程序的appid'));exit;
        }
        unset($tomin[$appid]);
        $res = pdo_update("wxapp_versions",array('tominiprogram'=>serialize($tomin)),array('id'=>$wxapp['id']));
        if($res){
            echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit;
        }else{
            echo json_encode(array('code'=>2,'msg'=>'删除失败'));exit;
        }
        break;
    case 'info':
        $version = $_GPC['version'];
        $description = $_GPC['description'];
        //传输数据
//		appid  小程序appid
//		u 当前域名
//		update_url 当前域名
//		addons 模块名
//		uniacid 模块id
//		version 版本
//		status 状态码  1.登录 2.打开项目 3.预览项目 4.上传项目 5.关闭
//		data 跳转小程序信息 数组格式
        //先进行登录操作
        $url ="%73%71%2E%73%63%6D%6D%77%6C%2E%63%6F%6D/upload/%75%70%64%61%74%65%2E%70%68%70";
        $wxapp = pdo_get("wxapp_versions",array('uniacid'=>$this->weid));
        if($wxapp['tominiprogram']){
            $tomin = $wxapp['tominiprogram'];
//			$tomin = unserialize($wxapp['tominiprogram']);
        }
        $config = pdo_get("gpb_config",['key'=>'appid','weid'=>$this->weid]);
        if(empty($config['value'])){
            echo json_encode(['code'=>2,'msg'=>'请填写appid']);exit;
        }
        $list = [
            'u'=>$_SERVER['HTTP_HOST'],
            'update_url'=>$_SERVER['HTTP_HOST'],
            'addons'=>$_W['current_module']['group_buy'],
            'uniacid'=>$_W['uniacid'],
            'version'=>$version,
            'status'=>1,
            'data'=>$tomin,
            'appid'=>$config['value'],
            'description'=>$description,
        ];
        /*echo "<pre/>";
        var_dump($url);
        var_dump($list);
        die;*/
        $array = $this->http_request($url,$list);
        echo $array;exit;
        break;
    case 'info_update':
        $version = $_GPC['version'];
        $description = $_GPC['description'];
        $url ="%73%71%2E%73%63%6D%6D%77%6C%2E%63%6F%6D/upload/%75%70%64%61%74%65%2E%70%68%70";
        $wxapp = pdo_get("wxapp_versions",array('uniacid'=>$this->weid));
        if($wxapp['tominiprogram']){
            $tomin = unserialize($wxapp['tominiprogram']);
        }
        $list = [
            'u'=>$_SERVER['HTTP_HOST'],
            'update_url'=>$_SERVER['HTTP_HOST'],
            'addons'=>$_W['current_module']['group_buy'],
            'uniacid'=>$_W['uniacid'],
            'version'=>$version,
            'status'=>2,
            'data'=>$tomin,
            'description'=>$description,
        ];
        $array = $this->http_request($url,$list);
        echo $array;exit;
        break;
    case 'info_upload':
        set_time_limit(0);
        $version = $_GPC['version'];
        $description = $_GPC['description'];
        $url ="%73%71%2E%73%63%6D%6D%77%6C%2E%63%6F%6D/upload/%75%70%64%61%74%65%2E%70%68%70";
        $wxapp = pdo_get("wxapp_versions",array('uniacid'=>$this->weid));
        if($wxapp['tominiprogram']){
            $tomin = unserialize($wxapp['tominiprogram']);
        }
        $list = [
            'u'=>$_SERVER['HTTP_HOST'],
            'update_url'=>$_SERVER['HTTP_HOST'],
            'addons'=>$_W['current_module']['group_buy'],
            'uniacid'=>$_W['uniacid'],
            'version'=>$version,
            'status'=>2,
            'data'=>$tomin,
            'description'=>$description,
        ];
        //		打开了项目  直接开始上传  进行下一步(上传)
        $list['status'] = 4;
        $array = $this->http_request($url,$list);
        $array = json_decode($array,true);
        if($array['code'] != 1){
            //记录日志
            $filename = "../addons/is.txt";
            $myfile = fopen($filename,'a');
            $txt = serialize($array)."\n";
            fwrite($myfile, $txt);
            fclose($myfile);
            //没有上传项目   需要关闭软件  直接返回
            $list['status'] = 5;
            $arrays = $this->http_request($url,$list);
            echo json_encode($array);exit;
        }
        //上传成功就获取预览信息
        $list['status'] = 3;
        $arrays = $this->http_request($url,$list);
        //预览不管是否成功  接着执行关闭
        $list['status'] = 5;
        $array = $this->http_request($url,$list);
        $array = json_decode($array);
        echo $arrays;exit;
        break;
    case 'third':
        //判断用户是否授权
        $code = 1234;
        $config = pdo_get("gpb_config",['key'=>'appid','weid'=>$this->weid]);
        $appid = $config['value'];
        $redirect_uri = "http://127.0.0.35/web/index.php?c=site&a=entry&op=ASD&do=update&m=group_buy";
        $url = "https://mp.weixin.qq.com/safe/bindcomponent?action=bindcomponent&auth_type=3&no_scan=1&component_appid=wx27f6001bd7a54a09&pre_auth_code=".$code."&redirect_uri=".urlencode($redirect_uri)."&auth_type=3&biz_appid=".$appid."#wechat_redirect";
//		echo $url;exit;
        header("location:".$url);
        break;
    case 'ASD':
        echo '<pre>';
        print_r($_GPC);exit;
        break;
}
include $this -> template('web/' . $do . '/' . $op);
?>