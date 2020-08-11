<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/group_buy/style/css/upload.css"/>
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
										<!--<li <?php  if($op == 'examine') { ?>class="am-active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('authorization',array('op'=>'examine'))?>">开发</a></li>-->
										<!--<li <?php  if($in == 'wx') { ?>class="am-active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('update',array('op'=>'index','in'=>'wx'))?>">版本更新</a></li>-->
									</ul>
								</div>
								<?php  if($info['code'] == 1) { ?>
									<div style="display: block;" id="submit">
										<div class="alert alert-block alert-success" style="margin: 0 10rem 10px 10rem;">
											<ol>
												<li>线上版本：表示小程序已上线，可在微信通过小程序名称进行搜索;</li>
												<li>审核版本：表示小程序已提交微信进行审核，审核周期为3-4天;</li>
												<li>代码更新：小程序功能根据市场需求在不断迭代更新，一些新功能需要更新版本上线后可使用;</li>
											</ol>
										</div>
										<div class="version-item-box" style="margin: 0 10rem 20px 10rem;">
											<div class="code-version-title">
												<h3>线上版本
									                	<a href="<?php  echo $this->createWebUrl('authorization',array('op'=>'index','sq'=>1))?>" >重新授权</a>
									                
												</h3>
											</div>
											<?php  if(empty($version)) { ?>
												<div><span>暂无线上版本</span></div>
											<?php  } else { ?>
												<?php  if($version['status'] == 5) { ?>
													<div class="code-version-con">
														<div class="code-version-left">
															<label class="simple_preview_label">版本号</label>
															<p class="simple_preview_value"><?php  echo $version['version'];?></p>
														</div>
														<div class="code-version-bd">
															<div class="simple_preview_item">
																<label class="simple_preview_label">应用名称</label>
																<p class="simple_preview_value"><?php  echo $name_title['value'];?></p>
															</div>
															<div class="simple_preview_item">
																<label class="simple_preview_label">上传时间</label>
																<p class="simple_preview_value"><?php  echo date('Y-m-d H:i',$version['time3'])?></p>
															</div>
															<div class="simple_preview_item">
																<label class="simple_preview_label">应用简介</label>
																<p class="simple_preview_value"><?php  echo $version['desc'];?></p>
															</div>
														</div>
													</div>
												<?php  } else { ?>
													<div><span>暂无线上版本</span></div>
												<?php  } ?>
											<?php  } ?>
										</div>
										<div class="version-item-box" style="margin: 0 10rem 20px 10rem;">
											<div class="code-version-title">
												<h3>审核版本</h3>
											</div>
											<?php  if($version['status'] != 5) { ?>
												<div class="code-version-con">
													<div class="code-version-left">
														<label class="simple_preview_label">版本号</label>
														<p class="simple_preview_value"><?php  echo $version['version'];?></p>
													</div>
													<div class="code-version-right">
														<div class="btn-box" style="margin-bottom: 3px;">
										                		<a href="javascript:;" class="btn btn-green js_submit_check" onclick="preview(this)" style="background: #22c397;color: #fff;border-radius: 5px;">预览</a>
										                	</div>
														<?php  if($version['status'] == 2) { ?>
										                		
									                	<?php  } else if($version['status'] == 3) { ?>
										                	<div class="btn-box" style="margin-bottom: 3px;">
										                		<a href="javascript:;" class="btn btn-green js_submit_check" onclick="release(this)" style="background: #22c397;color: #fff;border-radius: 5px;">重新提交审核</a>
										                	</div>
										                	<div class="btn-box">
									                			<a href="javascript:;" class="btn btn-green js_submit_check" style="background: #22c397;color: #fff;border-radius: 5px;" data-content="<?php  echo htmlspecialchars($version['content'])?>" onclick="reason_info(this)">查看审核失败原因</a>
									                		</div>
									                	<?php  } else if($version['status'] == 4) { ?>
									                		<div class="btn-box">
									                			<a href="javascript:;" class="btn btn-green js_submit_check" style="background: #22c397;color: #fff;border-radius: 5px;" onclick="releases()">发布</a>
									                		</div>
									                	<?php  } ?>
													</div>
													<div class="code-version-bd">
														<div class="simple_preview_item">
															<label class="simple_preview_label">应用名称</label>
															<p class="simple_preview_value"><?php  echo $name_title['value'];?></p>
														</div>
														<div class="simple_preview_item">
															<label class="simple_preview_label">上传时间</label>
															<p class="simple_preview_value"><?php  echo date('Y-m-d H:i',$version['time3'])?></p>
														</div>
														<div class="simple_preview_item">
															<label class="simple_preview_label">应用简介</label>
															<p class="simple_preview_value"><?php  echo $version['desc'];?></p>
														</div>
													</div>
												</div>
											<?php  } else { ?>
										        <div>
										            <span>你暂无提交审核的版本或者版本已发布上线</span>
										        </div>
									        <?php  } ?>
									    </div>
										<?php  if(!empty($infos)) { ?>
										<div class="version-item-box" style="margin: 0 10rem 20px 10rem;">
											<div class="code-version-title">
												<h3>新版</h3>
											</div>
									        <div class="code-version-con" style="position: relative;min-height: 34px;">
								        		<div class="code-version-left">
									                <label class="simple_preview_label">版本号</label>
									                <p class="simple_preview_value"><?php  echo $infos['name'];?></p>
									            </div>
									            <div class="code-version-right">
													<div class="btn-box">
									                	<a href="javascript:;" class="btn btn-green js_submit_check" data-version="<?php  echo $infos['name'];?>" data-content="<?php  echo base64_decode($infos['content'])?>" onclick="latest_version(this)" style="background: #22c397;color: #fff;border-radius: 5px;">更新代码并提交审核</a>
									                </div>
												</div>
									            <div class="code-version-bd">
													<div class="simple_preview_item">
														<label class="simple_preview_label">应用名称</label>
														<p class="simple_preview_value"><?php  echo $name_title['value'];?></p>
													</div>
													<div class="simple_preview_item">
														<label class="simple_preview_label">更新描述</label>
														<p class="simple_preview_value"><?php  echo base64_decode($infos['content'])?></p>
													</div>
												</div>
											</div>
										</div>
										<?php  } ?>
										<!--<div class="am-form-group">
									        <label class="am-u-sm-3 am-u-lg-2 am-form-label ">版本号</label>
									        <div class="col-sm-6 col-xs-2">
									        	<input type='text' id='version' name='version' value="<?php  echo $ver;?>" class='tpl-form-input'/>
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
									    </div>-->
									</div>
								<?php  } else { ?>
									<div>
										<div class="text-center step1" ng-show="show_step2" style="">
											<img src="<?php  echo $href;?>" class="qr-img" id="qrcode" style="width: 150px;">
											<div>请扫描二维码，进行授权</div>
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
	var code = "<?php  echo $info['code'];?>";
	console.log(code);
	if(code == 2){
		timing();
	}
//每秒去执行查询  看看是否是登录
function timing(){
	var code = 0;
	var is = setInterval(function () {
		$.post("<?php  echo $this->createWebUrl('authorization',array('op'=>'authorization'))?>",{id:1},function(res){
			if(res.code == 1){
				window.location.href = "<?php  echo $this->createWebUrl('authorization',array('op'=>'index'))?>";
				clearInterval(is);//项目打开成功  停止循环
			}
		},"JSON");
	},2000);
}
$("#tomin").click(function(res){
	var version = $("input[name='version']").val();
	var desc = $("#description").val();
	if(version == '' || version == undefined){
		layer.msg('请填写版本号');
		return false;
	}
	layer.load(0,{shade: [0.5, '#000000']});
	$.post("<?php  echo $this->createWebUrl('authorization',array('op'=>'auto'))?>",{version:version,desc:desc},function(res){
		layer.closeAll();
		if(res.code == 1){
			layer.msg(res.msg,{time:2000,icon:1},function(res){
				window.location.href = "<?php  echo $this->createWebUrl('authorization',array('op'=>'examine'))?>";
			});
		}
	},"JSON");
})
function latest_version(obj){
	layer.load(0,{shade: [0.5, '#000000']});
	var version = $(obj).data('version');
	var desc = $(obj).data('content');
	$.post("<?php  echo $this->createWebUrl('authorization',array('op'=>'auto'))?>",{version:version,desc:desc},function(res){
		layer.closeAll();
		if(res.errcode == 0){
			layer.msg('提交审核成功',{time:2000,icon:1},function(res){
				location.reload();
			});
		}else{
			layer.msg(res.errmsg,{time:2000,icon:2},function(res){
				location.reload();
			});
		}
	},"JSON");
}
//重新提交审核
function release(){
	layer.load(0,{shade: [0.5, '#000000']});
	$.post("<?php  echo $this->createWebUrl('authorization',array('op'=>'release'))?>",{ids:2},function(res){
		layer.closeAll();
		if(res.errcode == 0){
			layer.msg('提交审核成功',{time:2000,icon:1},function(res){
				location.reload();
			});
		}else{
			layer.msg(res.errmsg,{time:2000,icon:2},function(res){
				location.reload();
			});
		}
	},"JSON");
}
//查看审核失败原因
function reason_info(obj){
	var content = $(obj).data('content');
	layer.msg(content,{time:5000});
}
//预览
function preview(obj){
	layer.load(0,{shade: [0.5, '#000000']});
	$.post("<?php  echo $this->createWebUrl('authorization',array('op'=>'preview'))?>",{ids:2},function(res){
		layer.closeAll();
		layer.open({
			type: 1,
		  	area: ['485px', '570px'], //宽高
		  	content: '<div style="padding:10px;"><img src="data:image/jpeg;base64,'+res+'"/></div>'
		});
	},"text");
}
//发布
function releases(obj){
	layer.load(0,{shade: [0.5, '#000000']});
	$.post("<?php  echo $this->createWebUrl('authorization',array('op'=>'releases'))?>",{ids:2},function(res){
		layer.closeAll();
		if(res.errcode == 0){
			layer.msg("发布成功",{time:2000,icon:1},function(res){
				location.reload();
			})
		}else{
			layer.msg(res.errmsg,{time:2000,icon:2});
		}
	},"JSON");
}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
