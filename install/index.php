<?php
/**
 * 安装向导
 */
header('Content-type:text/html;charset=utf-8');
// 检测是否安装过
//if (file_exists('../data/config.php')) {
//  echo '你已经安装过该系统，重新安装需要先删除./data/config.php 文件';
//  die;
//}
// 同意协议页面
if(@!isset($_GET['c']) || @$_GET['c']=='agreement'){
    require './agreement.html';exit;
}
// 检测环境页面
if(@!isset($_GET['c']) || @$_GET['c']=='test'){
    require './test.html';exit;
}

// 创建数据库页面
if(@$_GET['c']=='create'){
    require './create.html';exit;
}
// 安装成功页面
if(@$_GET['c']=='success'){
    // 判断是否为post
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $data=$_POST;
        // 连接数据库
        $link=@new mysqli("{$data['DB_HOST']}:{$data['DB_PORT']}",$data['DB_USER'],$data['DB_PWD']);
        // 获取错误信息
        $error=$link->connect_error;
        if (!is_null($error)) {
            // 转义防止和alert中的引号冲突
            $error=addslashes($error);
            die("<script>alert('数据库链接失败:$error');history.go(-1)</script>");
        }
        // 设置字符集
        $link->query("SET NAMES 'utf8'");
        $link->server_info>5.0 or die("<script>alert('请将您的mysql升级到5.0以上');history.go(-1)</script>");
        // 创建数据库并选中
        if(!$link->select_db($data['DB_NAME'])){
            $create_sql='CREATE DATABASE IF NOT EXISTS '.$data['DB_NAME'].' DEFAULT CHARACTER SET utf8;';
            $link->query($create_sql) or die('创建数据库失败');
            $link->select_db($data['DB_NAME']);
        }
        // 导入sql数据并创建表
        $bjyadmin_str=file_get_contents('./group_buy.sql');
        $sql_array=preg_split("/;[\r\n]+/", str_replace('mmwl_',$data['DB_PREFIX'],$bjyadmin_str));
        foreach ($sql_array as $k => $v) {
            if (!empty($v)) {
                $link->query($v);
            }
        }
        $link->close();
        $db_str = '<?php
defined("IN_IA") or exit("Access Denied");
$config = array();
$config["db"]["master"]["host"] = "'.$data["DB_HOST"].'";
$config["db"]["master"]["username"] = "'.$data["DB_USER"].'";
$config["db"]["master"]["password"] = "'.$data["DB_PWD"].'";
$config["db"]["master"]["port"] = "'.$data["DB_PORT"].'";
$config["db"]["master"]["database"] = "'.$data["DB_NAME"].'";
$config["db"]["master"]["charset"] = "utf8";
$config["db"]["master"]["pconnect"] = 0;
$config["db"]["master"]["tablepre"] = "'.$data["DB_PREFIX"].'";

$config["db"]["slave_status"] = false;
$config["db"]["slave"]["1"]["host"] = "";
$config["db"]["slave"]["1"]["username"] = "";
$config["db"]["slave"]["1"]["password"] = "";
$config["db"]["slave"]["1"]["port"] = "3307";
$config["db"]["slave"]["1"]["database"] = "";
$config["db"]["slave"]["1"]["charset"] = "utf8";
$config["db"]["slave"]["1"]["pconnect"] = 0;
$config["db"]["slave"]["1"]["tablepre"] = "ims_";
$config["db"]["slave"]["1"]["weight"] = 0;

$config["db"]["common"]["slave_except_table"] = array("core_sessions");

// --------------------------  CONFIG COOKIE  --------------------------- //
$config["cookie"]["pre"] = "beIl_";
$config["cookie"]["domain"] = "";
$config["cookie"]["path"] = "/";

// --------------------------  CONFIG SETTING  --------------------------- //
$config["setting"]["charset"] = "utf-8";
$config["setting"]["cache"] = "mysql";
$config["setting"]["timezone"] = "Asia/Shanghai";
$config["setting"]["memory_limit"] = "256M";
$config["setting"]["filemode"] = 0644;
$config["setting"]["authkey"] = "3dzPj69X";
$config["setting"]["founder"] = "1";
$config["setting"]["development"] = 0;
$config["setting"]["referrer"] = 0;

// --------------------------  CONFIG UPLOAD  --------------------------- //
$config["upload"]["image"]["extentions"] = array("gif", "jpg", "jpeg", "png");
$config["upload"]["image"]["limit"] = 5000;
$config["upload"]["attachdir"] = "attachment";
$config["upload"]["audio"]["extentions"] = array("mp3");
$config["upload"]["audio"]["limit"] = 5000;

// --------------------------  CONFIG MEMCACHE  --------------------------- //
$config["setting"]["memcache"]["server"] = "";
$config["setting"]["memcache"]["port"] = 11211;
$config["setting"]["memcache"]["pconnect"] = 1;
$config["setting"]["memcache"]["timeout"] = 30;
$config["setting"]["memcache"]["session"] = 1;

// --------------------------  CONFIG PROXY  --------------------------- //
$config["setting"]["proxy"]["host"] = "";
$config["setting"]["proxy"]["auth"] = "";

// -------------------------- CONFIG REDIS --------------------------- //
$config["setting"]["redis"]["server"] = "127.0.0.1";
$config["setting"]["redis"]["port"] = 6379;
$config["setting"]["redis"]["pconnect"] = 1;
$config["setting"]["redis"]["timeout"] = 30;
$config["setting"]["redis"]["session"] = 0;';
        // 创建数据库链接配置文件
        file_put_contents('../data/config.php', $db_str);
        @touch('../data/install.lock');
        require './success.html';
    }
}


?>