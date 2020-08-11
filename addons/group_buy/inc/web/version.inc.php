<?php
/**
 * showdoc
 * @catalog 团购/模块/inc/web
 * @title version.inc
 * @method     POST
 * @url 获取更新及更新解压
 * @param
 * @return
 * @return_param
 */
global $_W,$_GPC;
$debug = 0 ;
if(!empty($_GPC['debug'])){
    $debug = 1;
ini_set('display_errors',1);
error_reporting(E_ALL);
}
$op = !empty($_GPC['op'])?$_GPC['op']:'index';
switch($op){
    case 'index':
        //获取当前版本号
        $now_version_num_arr = pdo_get('modules',array('name'=>'group_buy','type'=>'business'));
        if(isset($now_version_num_arr['version']) && !empty($now_version_num_arr['version']) ){
            $now_version_num = $now_version_num_arr['version'];
        }
        break;
    case 'hasnew':
        //检查是否有新版本
        //第一步检查是否正版授权
        $is_check = cache_load("is_check");
        if(!$is_check){
            $domain=$_SERVER['HTTP_HOST'];
            $check_host = 'http://%73%71%2E%73%63%6D%6D%77%6C%2E%63%6F%6D/%74%6F%5F%75%70%64%61%74%65%2E%70%68%70';
            $client_check = $check_host . '?a=client_check&u=' . $_SERVER['HTTP_HOST'];
            $check_message = $check_host . '?a=check_message&u=' . $_SERVER['HTTP_HOST'];
            $check_info=file_get_contents(urldecode($client_check));
            $message = file_get_contents(urldecode($check_message));
            if($check_info!=='0'){
                echo json_encode(['status'=>-1,'msg'=>'未授权用户，请联系授权']);
                die;
            }
            cache_write("is_check",1);
        }
        //第二步获取当前版本号
        $now_version_num_arr = pdo_get('modules',array('name'=>'group_buy','type'=>'business'));
        if(isset($now_version_num_arr['version']) && !empty($now_version_num_arr['version']) ){
            $now_version_num = $now_version_num_arr['version'];
        }
        //第三步获取线上版本信息
        $url = "http://%73%71%73%2E%61%70%70%69%6F%73%2E%63%6E/%61%70%69%2E%70%68%70?m=getverssion";
        load()->func('communication');
        $info = ihttp_request($url);
        $info = $info['content'];
        if(empty($info)){
            echo json_encode(['status'=>-1,'msg'=>'未知错误']);
            die;
        }
        $info = json_decode($info,true);
        if(intval($info['status'])!==0){
            echo json_encode(['status'=>-1,'msg'=>$info['msg']]);
            die;
        }
        $info = $info['verssion'];
        if($info>$now_version_num){
            echo json_encode(['status'=>0,'msg'=>'有新版本','data'=>$info]);
            die;
        }else{
            echo json_encode(['status'=>1,'msg'=>'已是最新版']);
            die;
        }
        break;
    case 'update':
        if(empty($_GPC['new_version'])){
            echo json_encode(['stauts'=>-1,'msg'=>'参数错误']);
            die;
        }
        $now_version_num_arr = pdo_get('modules',array('name'=>'group_buy','type'=>'business'));
        if(isset($now_version_num_arr['version']) && !empty($now_version_num_arr['version']) ){
            $now_version_num = $now_version_num_arr['version'];
        }
        if($now_version_num>=$_GPC['new_version']){
            echo json_encode(['stauts'=>-1,'msg'=>'已是最新版无需升级']);
            die;
        }
        $is_check = cache_load("is_check");
        if(!$is_check){
            $domain=$_SERVER['HTTP_HOST'];
            $check_host = 'http://%73%71%2E%73%63%6D%6D%77%6C%2E%63%6F%6D/%74%6F%5F%75%70%64%61%74%65%2E%70%68%70';
            $client_check = $check_host . '?a=client_check&u=' . $_SERVER['HTTP_HOST'];
            $check_message = $check_host . '?a=check_message&u=' . $_SERVER['HTTP_HOST'];
            $check_info=file_get_contents(urldecode($client_check));
            $message = file_get_contents(urldecode($check_message));
            if($check_info!=='0'){
                echo json_encode(['status'=>-1,'msg'=>'未授权用户，请联系授权']);
                die;
            }
            cache_write("is_check",1);
        }
        $urlinfo = $_W['siteroot']."addons/group_buy/receiveupdate.php?filename={$_GPC['new_version']}";
        $urlinfo = urlencode($urlinfo);
        $url = "http://%73%71%73%2E%61%70%70%69%6F%73%2E%63%6E/update.php?verssion={$_GPC['new_version']}&urlinfo={$urlinfo}";
//        load()->func('communication');
//        $res = ihttp_request($url);
        $file = "../addons/group_buy/{$_GPC['new_version']}.zip";
        if(is_file($file)){
            @unlink($file);
        }
        /*echo "<pre/>";
        var_dump($res);
        die;*/
//        $info = decode_str($res['content']);
//        $info = $res['content'];
       /* $info = file_get_contents($url);
        $res = file_put_contents($file,$info);*/
        $info = file_get_contents($url);
        $info = json_decode($info['content'],true);
        echo json_encode(['status'=>0,'msg'=>$info['msg'],'url'=>$url,'data'=>$info]);
        die;
        break;
    case 'downloading':
        //下载进度获取
        if(empty($_GPC['new_version'])){
            echo json_encode(['stauts'=>-1,'msg'=>'参数错误']);
            die;
        }
        //第一步获取新版大小
        $version = $_GPC['new_version'];

        $size = cache_load("{$version}_size");
        if(empty($size)){
            $url = "http://%73%71%73%2E%61%70%70%69%6F%73%2E%63%6E/getsize.php?verssion={$_GPC['new_version']}";
            load()->func('communication');
            $res = ihttp_request($url);
            if($debug==1){
                echo "<pre/>";
                var_dump($size);
            }
            $res = json_decode($res['content'],true);

            if($debug==1){
                echo "<pre/>";
                var_dump($size);
            }
            if($res['status']!=0){

            }else{
                $size = $res['size'];
                cache_write("{$version}_size",$size);
            }
        }
        //获取文件大小
        $file = IA_ROOT."/addons/{$version}.zip";
        if(!file_exists($file)){
            $parent = 0;
        }else{
            $now = filesize($file);
            if($debug==1){
                echo "<pre/>";
                var_dump($now);
                var_dump($size);

            }
            $parent = $now/$size*100;
            $parent = round($parent,2);
        }
        echo json_encode(['status'=>0,'msg'=>'获取成功','parsent'=>$parent]);
        die;
        break;
    case 'unzip':
        if(empty($_GPC['install_load'])){
            echo json_encode(['stauts'=>-1,'msg'=>'参数错误']);
            die;
        }
        $version = $_GPC['new_version'];
        //第一步备份当前版本文件
        if(!is_dir(IA_ROOT.'/old_'.$version)){
            mkdir(IA_ROOT.'/old_'.$version,0755);
        }
        copy_dir(IA_ROOT.'/addons/group_buy',IA_ROOT.'/old_'.$version);
        //第二步解压文件到 addons下版本号文件夹内
        $file = IA_ROOT.'/addons/'.$version.'.zip';
        $outPath = IA_ROOT.'/addons/';
        $zip = new ZipArchive();
        $openRes = $zip->open($file);
        if ($openRes === TRUE) {
            $zip->extractTo($outPath);
            $zip->close();
        }
        echo json_encode(['status'=>0,'msg'=>'解压完成，准备安装']);
        die;
        break;
    case 'install_new':
        if(empty($_GPC['verssion'])){
            echo json_encode(['stauts'=>-1,'msg'=>'参数错误']);
            die;
        }
        $version = $_GPC['new_version'];
        //安装更新文件
        include_once IA_ROOT.'/addons/group_buy/upgrade.php';
        $res = pdo_update('modules',array('version'=>$version),array('name'=>'group_buy','type'=>'business'));
        cache_clean();
        echo $res?json_encode(['status'=>0,'msg'=>'升级成功']):json_encode(['status'=>-1,'msg'=>'升级失败，请重试']);
        die;
        break;

}
//递归复制文件夹
function copy_dir($src, $des)
{
    $dir = opendir($src);
    @mkdir($des);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copy_dir($src . '/' . $file, $des . '/' . $file);
            } else {
                copy($src . '/' . $file, $des . '/' . $file);
            }
        }
    }
    closedir($dir);
}
include $this -> template('web/version/' . $op);