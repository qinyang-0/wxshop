<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/group_buy/style/css/upload.css"/>
<style type="text/css">
	.inputs{
	    float: left;
	    width: 38.8% !important;
	    border-top-right-radius: 0 !important;
	    border-bottom-right-radius: 0 !important;
	    border-right: 0 !important;
	}
	.input_bottom_input{
		float: left;
	    width: 4% !important;
	    border-top-left-radius: 0 !important;
	    border-bottom-left-radius: 0 !important;
	    border-left-width: 0 !important;
	    text-align: center;
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
					<form action="" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data" id="from_data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">附件设置</div>
								</div>
								<div class="am-tabs am-tabs-d2">
									<ul class="am-tabs-nav am-cf">
										<li <?php  if($op == 'index') { ?>class="am-active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('enclosure',array('op'=>'index'))?>">全局设置</a></li>
										<li <?php  if($op ==   'add') { ?>class="am-active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('enclosure',array('op'=>'add'))?>">对象存储</a></li>
									</ul>
								</div>
								<!--<div class="widget-head am-cf">
									<div class="widget-title am-fl">本地附件空间设置</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">空间容量</label>
									<div class="am-u-sm-9 am-u-end">
										<input type="text" name="" value="" class="tpl-form-input">
										<span class="color-9">容量单位为M, 设置为 0 时不限制空间</span>
									</div>
								</div>-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">附件缩略设置</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">缩略设置</label>
									<div class="am-u-sm-9 am-u-end">
										<select class="tpl-form-input" name="image_thumb">
											<option value="1" <?php  if($upload['image']['thumb']==1) { ?>selected<?php  } ?> >开启</option>
											<option value="0" <?php  if($upload['image']['thumb']!=1) { ?>selected<?php  } ?> 关闭</option>
										</select>
										<span class="color-9">是否启用缩略</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">缩略图最大宽度</label>
									<div class="am-u-sm-9 am-u-end">
										<input type="text" name="image_width" value="<?php  echo $upload['image']['width'];?>" class="tpl-form-input inputs">
										<input type="text" name="" readonly="" id="" value="px" class="input_bottom_input" />
										<div style="clear: both;"></div>
										<span class="color-9">请输入单位px的图片宽度</span>
									</div>
								</div>
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">图片附件设置</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">支持文件后缀</label>
									<div class="am-u-sm-9 am-u-end">
										<textarea name="image_extentions" rows="4" cols="10" class="tpl-form-input"><?php  echo $upload['image']['extentions'];?></textarea>
										<span class="color-9">填写图片后缀名称, 如: jpg, 换行输入, 一行一个后缀 (如果为空，则采用系统默认设置).</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">支持文件大小</label>
									<div class="am-u-sm-9 am-u-end">
										<input type="text" name="attachment_limit" value="<?php  echo $upload['image']['limit'];?>" class="tpl-form-input inputs">
										<input type="text" name="" readonly="" id="" value="KB" class="input_bottom_input" />
										<div style="clear: both;"></div>
										<span class="color-9">请输入单位为kb的值</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">图片压缩</label>
									<div class="am-u-sm-9 am-u-end">
										<input type="text" name="image_zip_percentage" value="<?php  echo $upload['image']['zip_percentage'];?>" class="tpl-form-input inputs">
										<input type="text" name="" readonly="" id="" value="%" class="input_bottom_input" />
										<div style="clear: both;"></div>
										<span class="color-9">请输入1到100的整数, 100为不压缩, 值越大越清晰</span>
									</div>
								</div>
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">音频视频附件设置</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">支持文件后缀</label>
									<div class="am-u-sm-9 am-u-end">
										<textarea name="audio_extentions" rows="" cols="" class="tpl-form-input"><?php  echo $upload['audio']['extentions'];?></textarea>
										<span class="color-9">填写音频视频后缀名称, 如: mp3, 换行输入, 一行一个后缀 (如果为空，则采用系统默认设置).</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">支持文件大小</label>
									<div class="am-u-sm-9 am-u-end">
										<input type="text" name="audio_limit" value="<?php  echo $upload['audio']['limit'];?>" class="tpl-form-input inputs">
										<input type="text" name="" readonly="" id="" value="KB" class="input_bottom_input" />
										<div style="clear: both;"></div>
										<span class="color-9">请输入单位为kb的值</span>
									</div>
								</div>
								<div class="am-form-group">
									<div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
										<button type="button" class="j-submit zx-addBut " id="btn" value="提交" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...'}">提交</button>
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
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
	$("#btn").click(function(res){
		console.log(res);
		var data = $("#from_data").serialize();
		console.log(data);
		$.post("<?php  echo $this->createWebUrl('enclosure',array('op'=>'index','token'=>'submit'))?>",data,function(res){
			console.log(res);
		},"JSON")
		
		
		
	})
</script>
