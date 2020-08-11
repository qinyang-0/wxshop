<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en" class="js cssanimations">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>后台</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp">
	<link rel="icon" type="image/png" href="<?php  echo MODULE_URL?>favicon.ico">
	<meta name="apple-mobile-web-app-title" content="">
	<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/amazeui.min.css">
	<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/app.css">
	<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/font_783249_3sbba6jrt9y.css">
	<script src="<?php  echo MODULE_URL?>style/js/jquery.min.js"></script>
	<script src="<?php  echo MODULE_URL?>style/js/font_783249_e5yrsf08rap.js"></script>
	<script>
        BASE_URL = 'https://demo.yiovo.com/';
        STORE_URL = 'index.php?s=/store';
	</script>
	<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/layer.css" id="layuicss-layer">
	<!-- 脚步js开始 -->
	<script src="<?php  echo MODULE_URL?>style/js/layer.js "></script>
	<script src="<?php  echo MODULE_URL?>style/js/jquery.form.min.js "></script>
	<script src="<?php  echo MODULE_URL?>style/js/amazeui.min.js "></script>
	<script src="<?php  echo MODULE_URL?>style/js/webuploader.html5only.js "></script>
	<script src="<?php  echo MODULE_URL?>style/js/art-template.js "></script>
	<script src="<?php  echo MODULE_URL?>style/js/app.js "></script>
	<script src="<?php  echo MODULE_URL?>style/js/file.library.js "></script>
	<script src="<?php  echo MODULE_URL?>style/js/zx.js"></script>
	<!--结束-->
	<!--微擎模板文件-->
	<link href="<?php  echo MODULE_URL?>style/css/bootstrap.css" rel="stylesheet">
	<link href="<?php  echo MODULE_URL?>style/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="./resource/css/common.css?v=20170426" rel="stylesheet">
	<script type="text/javascript">
        if(navigator.appName == 'Microsoft Internet Explorer'){
            if(navigator.userAgent.indexOf("MSIE 5.0")>0 || navigator.userAgent.indexOf("MSIE 6.0")>0 || navigator.userAgent.indexOf("MSIE 7.0")>0) {
                alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
            }
        }
        window.sysinfo = {
        <?php  if(!empty($_W['uniacid'])) { ?>'uniacid': '<?php  echo $_W['uniacid'];?>',<?php  } ?>
        <?php  if(!empty($_W['acid'])) { ?>'acid': '<?php  echo $_W['acid'];?>',<?php  } ?>
        <?php  if(!empty($_W['openid'])) { ?>'openid': '<?php  echo $_W['openid'];?>',<?php  } ?>
        <?php  if(!empty($_W['uid'])) { ?>'uid': '<?php  echo $_W['uid'];?>',<?php  } ?>
        'isfounder': <?php  if(!empty($_W['isfounder'])) { ?>1<?php  } else { ?>0<?php  } ?>,
            'family': '<?php echo IMS_FAMILY;?>',
                'siteroot': '<?php  echo $_W['siteroot'];?>',
                'siteurl': '<?php  echo $_W['siteurl'];?>',
                'attachurl': '<?php  echo $_W['attachurl'];?>',
                'attachurl_local': '<?php  echo $_W['attachurl_local'];?>',
                'attachurl_remote': '<?php  echo $_W['attachurl_remote'];?>',
                'module' : {'url' : '<?php  if(defined('MODULE_URL')) { ?><?php echo MODULE_URL;?><?php  } ?>', 'name' : '<?php  if(defined('IN_MODULE')) { ?><?php echo IN_MODULE;?><?php  } ?>'},
            'cookie' : {'pre': '<?php  echo $_W['config']['cookie']['pre'];?>'},
            'account' : <?php  echo json_encode($_W['account'])?>,
            'server' : {'php' : '<?php  echo phpversion()?>'},
        };
	</script>
	<script>var require = { urlArgs: 'v=20170426' };</script>
	<script type="text/javascript" src="./resource/js/lib/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="./resource/js/lib/bootstrap.min.js"></script>
	<script type="text/javascript" src="./resource/js/app/util.js?v=20170426"></script>
	<script type="text/javascript" src="./resource/js/app/common.min.js?v=20170426"></script>
	<!--模板文件结束-->
</head>
<style>
	.color-9{
		color: #999;
	}
</style>
<body data-type="" style="">
<div class="am-g tpl-g">
	<!-- 头部 -->
	<header class="tpl-header">
		<!-- 右侧内容 -->
		<div class="tpl-header-fluid">
			<!-- 侧边切换 -->
			<div class="am-fl tpl-header-button switch-button">
				<i class="iconfont icon-menufold"></i>
			</div>
			<!-- 刷新页面 -->
			<div class="am-fl tpl-header-button refresh-button">
				<i class="iconfont icon-refresh"></i>
			</div>
			<!-- 其它功能-->
			<div class="am-fr tpl-header-navbar">
				<ul>
					<!-- 欢迎语 -->
					<li class="am-text-sm tpl-header-navbar-welcome">
						<?php  if($_GPC['type'] == 1) { ?>
						<a href="<?php  echo url('user/profile');?>">欢迎你，<span><?php  echo $_W['user']['username'];?></span></a>
						<?php  } ?>
					</li>
					<!-- 退出 -->
					<li class="am-text-sm">
						<a href="<?php  echo url('user/logout');?>">
							<i class="iconfont icon-tuichu"></i> 退出
						</a>
					</li>
				</ul>
			</div>
		</div>
	</header>
	<!-- 侧边导航栏 -->
	<div class="left-sidebar dis-flex">
		<!-- 一级菜单 -->
		<ul class="sidebar-nav">
			<ul class="sidebar-nav">
				<li class="sidebar-nav-heading"><?php  if($this->config['distribution_site_name'] != '') { ?><?php  echo $this->config['distribution_site_name'];?><?php  } else { ?><?php  echo $_W['current_module']['title'];?><?php  } ?></li>

				<?php  if(is_array($this->menu_info)) { foreach($this->menu_info as $item) { ?>
				<?php  if($item['display'] == 1) { ?>					<li class="sidebar-nav-link" style="display: flex;align-items: center;">						<a href="<?php  echo $item['url'];?>" <?php  if(strpos($item['do'],$_GPC['do']) !== false || ($item['do'] == 'plug' && $do == 'plsugins')) { ?> class="active" <?php  } ?> style="width:100%;padding:0 10px;">						<?php  if($item['do'] == 'plug') { ?>							<img src="../addons/group_buy/public/plug/plug.png"/>							<span data-da="<?php  echo $item['do'];?>" style="margin-left: 4px;"><?php  echo $item['name'];?></span>						<?php  } else { ?>							<i class="<?php  echo $item['icon'];?>" style="width: 15px;height: 15px;text-align: center;margin-right: 5px;"></i>							<?php  echo $item['name'];?>						<?php  } ?>						</a>					</li>				<?php  } ?>
				<?php  } } ?>
			</ul>
		</ul>
		<!-- 子级菜单-->

		<ul class="left-sidebar-second" style="display:block">

			<li class="sidebar-second-title">整点秒杀管理</li>
			<?php  if(is_array($this->menu_lv2)) { foreach($this->menu_lv2 as $k => $v) { ?>
			<li class="sidebar-second-item second_menu" data-id="<?php  echo $v['id'];?>">
				<a href="<?php echo empty($v['chil'])?$this->createWebUrl($v['url']):'javascript:;'?>" <?php  if($_GET['do']==$v['url'] ) { ?> class="active" <?php  } ?>> <?php  echo $v['title'];?><?php  if(!empty($v['chil']) and $_GET['pid']!=$v['id']) { ?><i class="fa fa-caret-up"></i><?php  } else if($_GET['pid']==$v['id']) { ?><i class="fa fa-caret-down"></i><?php  } ?></a>
			</li>
			<?php  if(is_array($v['chil'])) { foreach($v['chil'] as $kk => $vv) { ?>
				<li data-id="<?php  echo $vv['id'];?>" data-pid="<?php  echo $vv['pid'];?>" class="sidebar-second-item thrid" <?php  if(empty($_GET['pid']) and $k==0) { ?>style="display:block;"<?php  } else if(!empty($_GET['pid']) and $_GET['pid']==$vv['pid']) { ?>style="display:block;"<?php  } else { ?>style="display:none;"<?php  } ?> >
					<a href="<?php  echo $this->createWebUrl($vv['url'])?>&pid=<?php  echo $vv['pid'];?>" <?php  if(($_GET['do']==$vv['top_do'] && $kk==1) || $_GET['do']==$vv['url'] ) { ?> class="active" <?php  } ?> > -<?php  echo $vv['title'];?> </a>
				</li>
			<?php  } } ?>
			<?php  } } ?>
		</ul>
	</div>
	<script>
		$(".second_menu").click(function(){
			var id = $(this).data("id");
			$(".thrid").hide();
            $(".thrid").find("i").removeClass("fa-caret-down");
            $(this).find("i").removeClass("fa-caret-up");
            $(this).find("i").addClass("fa-caret-down");
			$("li[data-pid='"+id+"']").show();
        });
	</script>
