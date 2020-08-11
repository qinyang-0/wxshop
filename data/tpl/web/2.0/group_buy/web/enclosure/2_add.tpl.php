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
					<form action="" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data" id="from_data">
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
										<li <?php  if($op == 'index') { ?>class="am-active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('enclosure',array('op'=>'index'))?>">全局设置</a></li>
										<li <?php  if($op ==   'add') { ?>class="am-active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('enclosure',array('op'=>'add'))?>">对象存储</a></li>
									</ul>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">对象储存</label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="0" name="type" data-am-ucheck <?php echo $remote['type'] ==0 ?"checked":''; ?>>
											关闭
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="type"  data-am-ucheck <?php echo $remote['type'] ==2 ?"checked":''; ?>>
											阿里云oss
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="3" name="type"  data-am-ucheck <?php echo $remote['type'] ==3 ?"checked":''; ?>>
											七牛云储存
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="4" name="type"  data-am-ucheck <?php echo $remote['type'] ==4 ?"checked":''; ?>>
											腾讯云储存
										</label>
									</div>
								</div>
								<input type="hidden" name="operate_type" id="operate_type" value="<?php  echo $remote['type'];?>" />
								<div id="Alioss" class="enclosure_info" style="display: <?php  if($remote['type'] == 2) { ?>block<?php  } else { ?>none<?php  } ?>;">
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">Access Key ID </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="alioss[key]" value="<?php  echo $remote['alioss']['key'];?>" class="tpl-form-input">
											<span class="color-9">Access Key ID是您访问阿里云API的密钥，具有该账户完全的权限，请您妥善保管。</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">Access Key Secret </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="alioss[secret]" value="<?php  echo $remote['alioss']['secret'];?>" class="tpl-form-input">
											<span class="color-9">Access Key Secret是您访问阿里云API的密钥，具有该账户完全的权限，请您妥善保管。(填写完Access Key ID 和 Access Key Secret 后请选择bucket)</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">Bucket选择 </label>
										<div class="am-u-sm-9 am-u-end">
											<select name="alioss[bucket]" class="tpl-form-input">
												<option value="">请选择</option>
												<?php  if(is_array($bucket)) { foreach($bucket as $item) { ?>
													<option value="<?php  echo $item['name'];?>" <?php  if($item['name'] == $remote['alioss']['bucket']) { ?>selected<?php  } ?>><?php  echo $item['loca_name'];?></option>
												<?php  } } ?>
											</select>
											<span class="color-9">完善Access Key ID和Access Key Secret资料后可以选择存在的Bucket(请保证bucket为可公共读取的)，否则请手动输入。</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">自定义URL </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="alioss[url]" value="<?php  echo $remote['alioss']['url'];?>" class="tpl-form-input">
											<span class="color-9">阿里云oss支持用户自定义访问域名，如果自定义了URL则用自定义的URL，如果未自定义，则用系统生成出来的URL。注：自定义url开头加http://或https://结尾不加 ‘/’例：http://abc.com</span>
										</div>
									</div>
									
								</div>
								<div id="qiniu" class="enclosure_info" style="display: <?php  if($remote['type'] == 3) { ?>block<?php  } else { ?>none<?php  } ?>;">
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">Accesskey </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="qiniu[accesskey]" value="<?php  echo $remote['qiniu']['accesskey'];?>" class="tpl-form-input">
											<span class="color-9">用于签名的公钥</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">Secretkey </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="qiniu[secretkey]" value="<?php  echo $remote['qiniu']['secretkey'];?>" class="tpl-form-input">
											<span class="color-9">用于签名的私钥</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">Bucket </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="qiniu[bucket]" value="<?php  echo $remote['qiniu']['bucket'];?>" class="tpl-form-input">
											<span class="color-9">请保证bucket为可公共读取的</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">Url </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="qiniu[url]" value="<?php  echo $remote['qiniu']['url'];?>" class="tpl-form-input">
											<span class="color-9">七牛支持用户自定义访问域名。注：url开头加http://或https://结尾不加 ‘/’例：http://abc.com</span>
										</div>
									</div>
								</div>
								<div id="EditCos" class="enclosure_info" style="display: <?php  if($remote['type'] == 4) { ?>block<?php  } else { ?>none<?php  } ?>;">
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">APPID </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="cos[appid]" value="<?php  echo $remote['cos']['appid'];?>" class="tpl-form-input">
											<span class="color-9">APPID 是您项目的唯一ID</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">SecretID </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="cos[secretid]" value="<?php  echo $remote['cos']['secretid'];?>" class="tpl-form-input">
											<span class="color-9">SecretID 是您项目的安全密钥，具有该账户完全的权限，请妥善保管</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">SecretKEY </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="cos[secretkey]" value="<?php  echo $remote['cos']['secretkey'];?>" class="tpl-form-input">
											<span class="color-9">SecretKEY 是您项目的安全密钥，具有该账户完全的权限，请妥善保管</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">Bucket </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="cos[bucket]" value="<?php  echo $remote['cos']['bucket'];?>" class="tpl-form-input">
											<span class="color-9">请保证bucket为可公共读取的</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">bucket所在区域 </label>
										<div class="am-u-sm-9 am-u-end">
											<select name="cos[local]" id="" class="tpl-form-input">
												<option value="">无</option>
												<option value="tj" <?php  if($remote['cos']['local'] == 'tj') { ?>sselected=""<?php  } ?>>华北</option>
												<option value="sh" <?php  if($remote['cos']['local'] == 'sh') { ?>sselected=""<?php  } ?>>华东</option>
												<option value="gz" <?php  if($remote['cos']['local'] == 'gz') { ?>sselected=""<?php  } ?>>华南</option>
												<option value="cd" <?php  if($remote['cos']['local'] == 'cd') { ?>sselected=""<?php  } ?>>西南</option>
												<option value="bj" <?php  if($remote['cos']['local'] == 'bj') { ?>sselected=""<?php  } ?>>北京</option>
												<option value="cq" <?php  if($remote['cos']['local'] == 'cq') { ?>sselected=""<?php  } ?>>重庆</option>
												<option value="sgp"<?php  if($remote['cos']['local'] == 'sgp') { ?>sselected=""<?php  } ?>>新加坡</option>
												<option value="hk" <?php  if($remote['cos']['local'] == 'hk') { ?>sselected=""<?php  } ?>>香港</option>
												<option value="ca" <?php  if($remote['cos']['local'] == 'ca') { ?>sselected=""<?php  } ?>>多伦多</option>
												<option value="ger"<?php  if($remote['cos']['local'] == 'ger') { ?>sselected=""<?php  } ?>>法兰克福</option>
											</select>
											<span class="color-9">选择bucket对应的区域，如果没有选择无</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">Url </label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="cos[url]" value="<?php  echo $remote['cos']['url'];?>" class="tpl-form-input">
											<span class="color-9">腾讯云支持用户自定义访问域名。注：url开头加http://或https://结尾不加 ‘/’例：http://abc.com</span>
										</div>
									</div>
								</div>
								<div class="am-form-group">
									<div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
										<button type="button" class="j-submit zx-addBut " id="btn" value="提交" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...'}">提交</button>
										<a id="ces" href="javascript:;" id="a-back-index" style="display: <?php  if($remote['type'] != 0) { ?>inline-block<?php  } else { ?>none<?php  } ?>;"><button class="btn" type="button">测试配置(无需保存)</button></a>
									</div>
								</div>
							</fieldset>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("input[name='type']").change(function(res){
		var type = $(this).val();
		$('.enclosure_info').hide();
		$('#ces').hide();
		switch(type){
			case '2':
				$('#Alioss').show();$('#ces').show();
				$("input[name='operate_type']").val(type);
			break;
			case '3':
				$('#qiniu').show();$('#ces').show();
				$("input[name='operate_type']").val(type);
			break;
			case '4':
				$('#EditCos').show();$('#ces').show();
				$("input[name='operate_type']").val(type);
			break;
		}
	})
	$("#btn").click(function(res){
		var data = $("#from_data").serialize();
		layer.load(0,{shade: [0.5, '#000000']});
		$.post("<?php  echo $this->createWebUrl('enclosure',array('op'=>'save'))?>",data,function(res){
			layer.closeAll();
			if(res.message.errno == 0){
				layer.msg(res.message.message,{time:2000,icon:1},function(res){
					location.reload();
				})
			}else{
				layer.msg(res.message.message,{time:3000,icon:2});
			}
		},'JSON');
	})
	$('#ces').click(function(res){
		var data = $("#from_data").serialize();
		layer.load(0,{shade: [0.5, '#000000']});
		$.post("<?php  echo $this->createWebUrl('enclosure',array('op'=>'test_setting'))?>",data,function(res){
			layer.closeAll();
			if(res.message.errno == 0){
				layer.msg(res.message.message,{time:2000,icon:1},function(res){})
			}else{
				layer.msg(res.message.message,{time:3000,icon:2});
			}
		},'JSON');
	})
	//获取阿里云的Bucket
	$("input[name='alioss[key]']").blur(function(res){
		var key = $(this).val();
		var secret = $("input[name='alioss[secret]").val();
		if(key != '' && secret != '' && key != undefined && secret != ''){
			layer.load(0,{shade: [0.5, '#000000']});
			$.post("/web/index.php?c=system&a=attachment&do=buckets",{key:key,secret:secret},function(res){
				if(res.message.errno == 1){
					var str = "";
					$.each(res.message.message,function(j,i){
						str += "<option value='"+i.name+"'>"+i.loca_name+"</option>";
					})
					$("select[name='alioss[bucket]']").append(str);
				}
				layer.closeAll();
			},"JSON")
		}
	})
	//获取阿里云的Bucket
	$("input[name='alioss[secret]").blur(function(res){
		var key = $("input[name='alioss[key]").val();
		var secret = $(this).val();
		if(key != '' && secret != '' && key != undefined && secret != ''){
			layer.load(0,{shade: [0.5, '#000000']});
			$.post("/web/index.php?c=system&a=attachment&do=buckets",{key:key,secret:secret},function(res){
				if(res.message.errno == 1){
					var str = "";
					$.each(res.message.message,function(j,i){
						str += "<option value='"+i.name+"'>"+i.loca_name+"</option>";
					})
					$("select[name='alioss[bucket]']").append(str);
				}
				layer.closeAll();
			},"JSON")
		}
	})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>