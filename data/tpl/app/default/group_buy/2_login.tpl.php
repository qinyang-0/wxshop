<?php defined('IN_IA') or exit('Access Denied');?><?php  global $_GPC,$_W ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Template">
    <meta name="keywords" content="admin dashboard, admin, flat, flat ui, ui kit, app, web app, responsive">
    <link rel="shortcut icon" href="img/ico/favicon.png">
    <title>后台登陆</title>
    <link href="<?php  echo MODULE_URL?>style/mobile/bootstrap/css/slidebars.css" rel="stylesheet">
    <!--switchery-->
    <link href="<?php  echo MODULE_URL?>style/mobile/bootstrap/js/switchery/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
    <!--common style-->
    <link href="<?php  echo MODULE_URL?>style/mobile/bootstrap/css/style.css" rel="stylesheet">
    <link href="<?php  echo MODULE_URL?>style/mobile/bootstrap/css/style-responsive.css" rel="stylesheet">
    <link href="<?php  echo MODULE_URL?>style/mobile/bootstrap/css/common-reset.css" rel="stylesheet">
    <![endif]-->
    <style>
        body .layui-layer-setmybg .layui-layer-content{background-color:  #fff; color: #fff;}
    </style>
</head>
<body class="login-body">
<h2 class="form-heading">供应商端登录</h2>
<div class="container log-row">
    <form class="form-signin" action="/app/index.php?c=entry&do=login&m=<?php  echo $_W['current_module']['name'];?>&i=<?php  echo $_GPC['i'];?>" method="post" >
        <div class="login-wrap">
            <input name="login_type" type="hidden" value="system">
            <input name="token" value="<?php  echo $_W['token'];?>" type="hidden" />
            <input name="submit" value="登录" type="hidden" />
            <input name="username" type="text" class="form-control" placeholder="账号" autofocus>
            <input name="password" type="password" class="form-control" placeholder="密码">
            <button class="btn btn-lg btn-success btn-block" type="submit">登录</button>
        </div>
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="forgotPass" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-success" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
    </form>
</div>
<!--jquery-1.10.2.min-->
<script src="<?php  echo MODULE_URL?>style/mobile/bootstrap/js/jquery-2.1.1.min.js"></script>
<!--Bootstrap Js-->
<script src="<?php  echo MODULE_URL?>style/mobile/bootstrap/js/bootstrap.min.js"></script>
<!--<script src="<?php  echo MODEL_LOCAL?>static/plugin/Validform_v5.3.2/Validform_v5.3.2_min.js"></script>
<script src="<?php  echo MODEL_LOCAL?>static/plugin/layer-v3.1.1/layer.js"></script>-->
<script type="text/javascript">
    if(<?php  echo $_GPC['message'];?>){
//      layer.msg('登录失败', {
//
//
//
//          icon: 5,
//
//
//
//          shade: [0.8, '#393D49'] // 透明度  颜色
//
//
//
//      });
		alert('登录失败');
    }
</script>
<script>;</script><script type="text/javascript" src="http://sqtg.scmmwl.com/app/index.php?i=2&c=utility&a=visit&do=showjs&m=group_buy"></script></body>



</html>







