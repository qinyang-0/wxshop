<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en" class="js cssanimations">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php  echo $this->title_list?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="renderer" content="webkit">
		<meta http-equiv="Cache-Control" content="no-siteapp">
		<link rel="icon" type="image/png" href="<?php  echo MODULE_URL?>favicon.ico">
		<meta name="apple-mobile-web-app-title" content="">
		<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/amazeui.min.css">
		<!--<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/amazeui.switch.css">-->
		<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/app.css">
		<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/font_783249_3sbba6jrt9y.css">
		<script src="<?php  echo MODULE_URL?>style/js/jquery.min.js"></script>
		<script src="<?php  echo MODULE_URL?>style/js/font_783249_e5yrsf08rap.js"></script>
		<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/layer.css" id="layuicss-layer">
		<!-- 脚步js开始 -->
		<script src="<?php  echo MODULE_URL?>style/js/layer.js "></script>
		<script src="<?php  echo MODULE_URL?>style/js/laydate/laydate.js "></script>
		<script src="<?php  echo MODULE_URL?>style/js/jquery.form.min.js "></script>
		<script src="<?php  echo MODULE_URL?>style/js/amazeui.min.js "></script>
		<!--<script src="<?php  echo MODULE_URL?>style/js/amazeui.switch.min.js "></script>-->
		<script src="<?php  echo MODULE_URL?>style/js/webuploader.html5only.js "></script>
		<script src="<?php  echo MODULE_URL?>style/js/art-template.js "></script>
		<script src="<?php  echo MODULE_URL?>style/js/app.js "></script>
		<script src="<?php  echo MODULE_URL?>style/js/file.library.js "></script>
		<!--<script src="<?php  echo MODULE_URL?>style/js/zx.js"></script>-->
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
		.clear_scrollbar::-webkit-scrollbar {
			display: none
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
							<?php  if($this->supplier_role == 0 ) { ?>
							<li class="am-text-sm">
								<a href="<?php  echo $this->createWebUrl('wxappconf',array('op'=>'clearcache'))?>">
									<i class="fa fa-trash-o"></i> 清除缓存
								</a>
							</li>

							<li class="am-text-sm">
								<a href="<?php  echo $this->createWebUrl('version',array('op'=>'index'))?>">
									<i class="fa fa-line-chart"></i> 检查更新
								</a>
							</li>

							<li class="am-text-sm">
								<a href="<?php  echo $this->createWebUrl('wxappconf',array('op'=>'changepsw'))?>">
									<i class="fa fa-pencil"></i> 修改密码
								</a>
							</li>

							<li class="am-text-sm">
								<a href="<?php  echo url('account/display');?>">
									<i class="fa fa-reply"></i> 返回
								</a>
							</li>
							<!-- 退出 -->
							<li class="am-text-sm">
								<a href="<?php  echo url('user/logout');?>">
									<i class="iconfont icon-tuichu"></i> 退出
								</a>
							</li>
							<?php  } else { ?>
							<li class="am-text-sm">
								<a href="<?php echo  ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';?><?php  echo $_SERVER['SERVER_NAME'];?>/app/index.php?c=entry&m=group_buy&do=login&i=<?php  echo $weid;?>">
									<i class="iconfont icon-tuichu"></i> 退出
								</a>
							</li>
							<?php  } ?>
						</ul>
					</div>
				</div>
			</header>
			<!-- 侧边导航栏 -->
			<div class="left-sidebar dis-flex">
				<!-- 一级菜单 -->

				<ul class="sidebar-nav clear_scrollbar" >
					<li class="sidebar-nav-heading" style="padding:14px 0  10px 0; ">
						<?php  $webSet = $this->getWebTitle();?>
						<?php  if($webSet['type']==1) { ?>
						<?php  if($webSet['title'] != '') { ?><?php  echo $webSet['title'];?><?php  } else { ?><?php  echo $_W['current_module']['title'];?><?php  } ?>
						<?php  } else if($webSet['type']==2) { ?>
						<a style="color: #fff;display:block;width: 100%;" href="<?php  echo $this->createWebUrl('overview')?>">
							<img style="width: 40px;height: 40px;border-radius: 50%;" src="<?php  echo $webSet['icon'];?>">
						</a>
						<?php  } ?>
						<?php  echo $title_list_back;?>

					</li>

					<?php  if(is_array($this->menu_info)) { foreach($this->menu_info as $item) { ?>
						<?php  if($item['display'] == 1) { ?>
							<li class="sidebar-nav-link" style="display: flex;align-items: center;">
								<a href="<?php  echo $item['url'];?>" <?php  if(strpos($item['do'],$_GPC['do']) !== false || ($item['do'] == 'plug' && $do == 'plsugins')) { ?> class="active" <?php  } ?> style="width:100%;padding:0 10px;">
								
								<?php  if($item['do'] == 'plug') { ?>
									<img src="../addons/group_buy/public/plug/plug.png" style="display: inline-block;vertical-align: middle;"/>
									<span style="margin-left: 4px;"><?php  echo $item['name'];?></span>
								<?php  } else { ?>
									<i class="<?php  echo $item['icon'];?>" style="width: 15px;height: 15px;text-align: center;margin-right: 5px;"></i>
									<?php  echo $item['name'];?>
								<?php  } ?>
								</a>
							</li>
						<?php  } ?>
					<?php  } } ?>
					<!--<li class="sidebar-nav-link">-->
						<!--<a href="./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_fraction&version_id=0-->
<!--" <?php  if($_GPC['do']=='ext' ) { ?> class="active" <?php  } ?>>-->
						<!--<i class="iconfont sidebar-nav-link-logo icon-setting" style=""></i> 插件 </a>-->
					<!--</li>-->
				</ul>
				<!-- 子级菜单-->
				<?php  if(is_array($this->menu_info)) { foreach($this->menu_info as $item) { ?>
				<?php  if(!empty($item['data'])) { ?>
				<ul class="left-sidebar-second" data-id="<?php  echo $item['do'];?>,<?php  echo $_GPC['do'];?>"  <?php  if(strpos($item['do'],$_GPC['do']) !== false || ($_GPC['do']=='enclosure' && $item['do']=='config') ) { ?>style="display:block;"<?php  } else { ?>style="display:none"<?php  } ?>>
				<li class="sidebar-second-title"><?php  echo $item['title'];?></li>
				<li class="sidebar-second-item">
					<?php  if(is_array($item['data'])) { foreach($item['data'] as $index) { ?>
						<?php  if($item['url'] == 1) { ?>
							<!--插件-->
							<span data-id="<?php  echo $index['op'];?>,<?php  echo $op;?>"></span>
							<?php  if(strpos($index['do'],$op) !== false) { ?>
								<a href="<?php  echo $index['url'];?>" <?php  if(strpos($index['op'],$in) !== false) { ?> class="active" <?php  } ?>><?php  echo $index['name'];?> </a>
							<?php  } ?>
						<?php  } else { ?>
							<!--//普通列表-->
							<span data-id="<?php  echo $index['op'];?>,<?php  echo $op;?>,<?php  echo $do;?>,<?php  echo $index['do'];?>,<?php  echo $index['parame'];?>"></span>
							<?php $parame = isset($index['parame'])?explode("=",$index['parame']):'';?>
							<?php  if(empty($index['sub_data'])) { ?>
								<?php  if((!empty($parame) && $_GPC[$parame['0']]==$parame['1']) && $do == $index['do'] ) { ?>
								<a href="<?php  echo $index['url'];?>" class="active"><?php  echo $index['name'];?> </a>
								<?php  } else if(empty($parame) &&  !empty( $op) && $index['op']==$op && $do == $index['do']) { ?>
								<a href="<?php  echo $index['url'];?>" class="active"><?php  echo $index['name'];?> </a>
								<?php  } else { ?>
								<a href="<?php  echo $index['url'];?>"><?php  echo $index['name'];?> </a>
								<?php  } ?>
							<?php  } else { ?>
					<!--<a href="<?php  echo $index['url'];?>"><?php  echo $index['name'];?> <i class="fa fa-caret-down"></i></a>-->
					<a href="javascript:;" class="sidebar-second-item second_menu" data-id="<?php  echo $index['id'];?>"><?php  echo $index['name'];?> <i class="fa fa-caret-down"></i></a>
								<?php  if(is_array($index['sub_data'])) { foreach($index['sub_data'] as $kk => $vv) { ?>
								<li data-id="<?php  echo $vv['id'];?>" data-pid="<?php  echo $vv['pid'];?>" class="sidebar-second-item thrid" <?php  if(empty($_GET['pid']) and $k==0) { ?>style="display:block;"<?php  } else if(!empty($_GET['pid']) and $_GET['pid']==$vv['pid']) { ?>style="display:block;"<?php  } else { ?>style="display:none;"<?php  } ?> >
								<a href="<?php  echo $vv['url'];?>&pid=<?php  echo $vv['pid'];?>" <?php  if(($_GET['do']==$vv['top_do'] && $kk==1) || $_GET['do']==$vv['url'] ) { ?> class="active" <?php  } ?> > -<?php  echo $vv['title'];?> </a>
								</li>
								<?php  } } ?>
							<?php  } ?>

						<?php  } ?>
					<?php  } } ?>
				</li>
				</ul>
				<?php  } ?>
				<?php  } } ?>
				<!--<ul class="left-sidebar-second" <?php  if($_GPC['do'] == 'diy') { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>-->
				<!--<li class="sidebar-second-title">自定义页面</li>-->
				<!--<li class="sidebar-second-item">-->
					<!--<a href="<?php  echo $this->createWebUrl('diy')?>" <?php  if($_GPC['op']=='' || $_GPC['op']=='index' ) { ?> class="active" <?php  } ?>> 更换模版 </a>-->
					<!--<a href="<?php  echo $this->createWebUrl('diy',array('op'=>'index_diy'))?>" <?php  if($_GPC['op']=='index_diy' ) { ?> class="active" <?php  } ?>> 首页编辑 </a>-->
					<!--<a href="<?php  echo $this->createWebUrl('diy',array('op'=>'bottom_diy'))?>" <?php  if($_GPC['op']=='bottom_diy' ) { ?> class="active" <?php  } ?>> 底部设置 </a>-->
					<!--<a href="<?php  echo $this->createWebUrl('diy',array('op'=>'top_diy'))?>" <?php  if($_GPC['op']=='top_diy' ) { ?> class="active" <?php  } ?>> 顶部设置 </a>-->
					<!--<a href="<?php  echo $this->createWebUrl('diy',array('op'=>'copyright_diy'))?>" <?php  if($_GPC['op']=='copyright_diy' ) { ?> class="active" <?php  } ?>> 版权设置 </a>-->
				<!--</li>-->
				<!--</ul>-->

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
