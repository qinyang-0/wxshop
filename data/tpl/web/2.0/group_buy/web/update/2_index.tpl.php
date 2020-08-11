<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.btn-group .active {
		background-color: #428bca;
		color: #fff;
	}
	.am-tabs-d2 .am-tabs-nav{
		background: #fff;
		border-bottom: 1px solid #eef1f5;
	}
	.am-tabs-nav{
		display: flex;
		align-items: center;
		justify-content: flex-start;
	}
	.am-tabs .am-tabs-nav li{
		width: 120px;
		line-height: 40px;
		height: 40px;
		padding: 0;
	}
	.am-tabs .am-tabs-nav li a{
		width: 120px;
		line-height: 40px;
		height: 40px;
		padding: 0;
		display: block;
		margin: 0;
		text-align: center;
		background: #fff;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active {
		position: relative;
		background-color: #fcfcfc;
		border-bottom: 2px solid #22c397;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active a{
		color: #22c397;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active:after{
		border-bottom-color: #22c397;
	}
	/*选项卡end*/
	.zx-edit-td-input:focus{
		outline: 1px  dashed #22c397;
	}
	.am-switch-success-zx>input[type=checkbox]:checked~.am-switch-checkbox{
		background: #22c397;
	}
</style>
<!--右侧详细内容区域 from 自定义-->
<div class="tpl-content-wrapper ">
	<!--本页自定义样式-->
	<!--<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/goods.css">-->
	<!--<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/umeditor.css">-->
	<!--右侧详细内容区域，灰框之内,from 妹子-->
	<div class="row-content am-cf">
		<!--2列式简单布局,from bootstap-->
		<div class="row">
			<!--12列布局,from 妹子-->
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<!--widget自定义右侧盒子 from 自定义 am-cf 清除全部浮动  from 妹子-->
				<div class="widget am-cf">
					<form action="" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">更新</div>
								</div>
								<div class="am-tabs am-tabs-d2">
									<ul class="am-tabs-nav am-cf">
										<li <?php  if($in == 'index') { ?>class="am-active"<?php  } ?> ><a href="<?php  echo $this->createWebUrl('update',array('op'=>'index','in'=>'index'))?>">系统升级</a></li>
										<li <?php  if($in == 'wx') { ?>class="am-active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('authorization',array('op'=>'index','in'=>'wx'))?>">版本更新</a></li>
										<!--<li <?php  if($in == 'wx') { ?>class="am-active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('update',array('op'=>'index','in'=>'wx'))?>">版本更新</a></li>-->
									</ul>
								</div>
								<?php  if($in == 'index') { ?>
								<!--//显示当前版本   和线上最新版本-->
									<div class="page-content">
										<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
										    <div class="form-group">
										        <label class="col-sm-2 control-label">当前版本</label>
										        <div class="col-sm-3 col-xs-2">
										            <div class="input-group">
										                <div class="input-group-addon" style="background:#f2f2f2"><?php  echo $ver;?>&nbsp;</div>
										            </div>
										        </div>
										    </div>
										    <?php  if($data) { ?>
											    <div class="form-group">
											        <label class="col-sm-2 control-label">线上新版</label>
											        <div class="col-sm-3 col-xs-2">
											            <div class="input-group">
											                <div class="input-group-addon" style="background:#f2f2f2"><?php  echo $data['latestVersionName'];?>&nbsp;</div>
											            </div>
											        </div>
											    </div>
											    <div class="form-group">
											        <label class="col-sm-2 control-label">线上新版</label>
											        <div class="col-sm-6 col-xs-2">
											        	<div class="input-group" style="width: 100%;display: inline-block;">
											                <div class="" style="background:#f2f2f2;padding: 8px 10px;word-break: break-all;display: inline-block;width: 100%;overflow: hidden;"><?php  echo $data['content'];?></div>
											            </div>
											        </div>
											    </div>
											<?php  } else { ?>
												<div class="form-group">
											        <label class="col-sm-2 control-label">线上新版</label>
											        <div class="col-sm-3 col-xs-2">
											        	<div class="input-group">
											                <div class="input-group-addon" style="background:#f2f2f2">暂无更新</div>
											            </div>
											        </div>
												</div>
										    <?php  } ?>
										
											<?php  if($data) { ?>
											    <div class="form-group" id="upgrade">
											        <label class="col-sm-2 control-label"></label>
											        <div class="col-sm-9 col-xs-12">
											            <div class="form-control-static">
											                <input type="button" id="upgradebtn" value="立即更新" class="btn btn-primary">
											            </div>
											        </div>
											    </div>
										    <?php  } ?>
										</form>
									</div>
								<?php  } else { ?>
									<div style="display: block;" id="submit">
										<div class="am-form-group">
									        <label class="am-u-sm-3 am-u-lg-2 am-form-label ">版本号</label>
									        <div class="col-sm-6 col-xs-2">
									        	<input type='text' id='version' name='version' readonly="" value="<?php  echo $ver;?>" class='tpl-form-input'/>
									        </div>
									    </div>
										<div class="am-form-group">
									        <label class="am-u-sm-3 am-u-lg-2 am-form-label ">版本描述</label>
									        <div class="col-sm-6 col-xs-2">
									        	<textarea name="" rows="" cols="" class="tpl-form-input" id="description"></textarea>
									        </div>
									    </div>
										<div class="am-form-group">
									        <label class="am-u-sm-3 am-u-lg-2 am-form-label ">可跳转小程序数量</label>
									        <div class="col-sm-6 col-xs-2">
									        	<input type='text' id='name' readonly="" name='name' value="<?php  echo count($tomin);?>" class='tpl-form-input' style="float: left;"/>
									        	<a href="<?php  echo $this->createWebUrl('update',array('op'=>'jump'))?>" style="line-height: 30px;margin-left: 10px;">去设置</a>
									        </div>
									    </div>
									    <div class="form-group" id="upgrade">
									        <label class="col-sm-2 control-label"></label>
									        <div class="col-sm-9 col-xs-12">
									            <div class="form-control-static">
									                <input type="button" id="tomin" value="提交" class="btn btn-primary">
									            </div>
									        </div>
									    </div>
									</div>
									<div style="display: none;" id="qrcode_top_div">
										<div style="display: block;" id="qrcode_top_div_top">
											<div class="waiting text-center" id="wait_code_token" ng-show="show_wait" style="border-top: 1px solid rgb(231, 231, 235); padding: 150px !important;">
												<div><span class="wi wi-waiting"></span></div>
												<div>正在获取二维码,请耐心等待,等待时间大约</div>
												<div class="second ng-binding" id="wait_sec">30秒</div>
											</div>
										</div>
										<div style="display: none;" id="qrcode_div">
											<div class="text-center step1" ng-show="show_step2" style="">
												<img src="../addons/group_buy/public/bg/xz.png" class="qr-img" id="qrcode" style="width: 150px;">
												<div>请扫描二维码，确认后将直接上传代码</div>
											</div>
										</div>
										<div style="display: none;" id="qrcode_divs">
											<div class="text-center step1" ng-show="show_step2" style="">
												<img src="../addons/group_buy/public/bg/xz.png" class="qr-img" id="qrcode" style="width: 150px;">
												<div>请扫描二维码，进行预览</div>
											</div>
										</div>
									</div>
								<?php  } ?>
							</fieldset>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).on("change","select[name='wechat_id[value]']",function () {
	if($(this).val()=="1"){
	    $("#is-show").removeClass("hidden");
	}else{
        $("#is-show").addClass("hidden");
	}
})
$("#upgradebtn").click(function(res){
	layer.confirm("更新请先做好文件备份和数据库备份，一但造成文件缺失，概不负责!", {icon: 2, title:'提示'}, function(index){
		layer.closeAll();
		layer.load(3, {shade: [0.5, '#393D49']});
		window.location.href = "<?php  echo $this->createWebUrl('update',array('op'=>'update'))?>";
	});
})
$("#tomin").click(function(res){
	//获取信息进行传输  获取登录二维码
	var version = $('#version').val();//版本号
	var description = $('#description').val();//版本描述
	if(version == '' || version == undefined){
		layer.msg("请填写版本号",{icon:2,time:2000});
		return false;
	}
	$("#qrcode_top_div").show();
	$("#submit").hide();
	var num = 30;
	var ins = setInterval(function () {
	    num = num-1;
	    if(num <= 0){
	    	clearInterval(ins);
	    	layer.msg('获取二维码超市超时，请重试',{icon:2,time:1000},function(res){
	    		location.reload();
	    	});
	    }
	    $('#wait_sec').html(num+'秒');
	}, 1000);
	//修改域名信息
	$.post("<?php  echo $this->createWebUrl('update',array('op'=>'info'))?>",{version:version,description:description},function(res){
		console.log(res);
		clearInterval(ins);
		if(res.code == 1){
			$("#qrcode_div img").attr("src",res.data);
			$('#qrcode_top_div_top').hide();
			$("#qrcode_div").show();
			timing(version,description);
		}else{
			layer.msg(res.msg,{icon:2,time:2000});
			return false;
		}
	},"JSON");
});
//每秒去执行查询  看看是否是登录
function timing(version,description){
	var code = 0;
	var is = setInterval(function () {
		$.post("<?php  echo $this->createWebUrl('update',array('op'=>'info_update'))?>",{version:version,description:description},function(res){
			console.log(res);
			if(res.code == 1){
				code = res.code;
				clearInterval(is);//项目打开成功  停止循环
			}
			if(code == 1){
				layer.load(1,{icon:0,shade: [0.5, '#000000']});
				$.ajax({
					type:"post",
					url:"<?php  echo $this->createWebUrl('update',array('op'=>'info_upload'))?>",
					async:true,
					data:{version:version,description:description},
					dataType:"JSON",
					success:function(res){
						console.log(res);
						layer.closeAll();
						if(res.code != 1){
							var i = JSON.parse(res.data);
							alert(i.error);
						}else{
							layer.msg("上传成功",{icon:1,time:2000},function(ress){
								$("#qrcode_divs img").attr("src",res.data);
								$('#qrcode_top_div_top').hide();
								$("#qrcode_div").hide();
								$("#qrcode_divs").show();
							});
						}
					},
				});
			}
		},"JSON");
	},2000);
//	if(code == 1){
//		layer.load(1,{icon:0,shade: [0.5, '#000000']});
//		$.post("<?php  echo $this->createWebUrl('update',array('op'=>'info_upload'))?>",{version:version,description:description},function(res){
//			console.log(res);
//			alert(res.code);
//			if(res.code != 1){
//				var i = JSON.parse(res.data);
//				alert(i.error);
//			}else{
//				layer.msg("上传成功",{icon:1,time:2000},function(res){
//					console.log(1);	
//				});
//			}
//		},"JOSN");
//	}
}
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
