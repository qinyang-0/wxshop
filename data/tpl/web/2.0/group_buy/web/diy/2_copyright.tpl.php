<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.btn-group .active {
		background-color: #428bca;
		color: #fff;
	}
	.input-group-btn{
		display: block;
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
					<form action="<?php  echo $this->createWebUrl('diy',array('op'=>'copyright'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">版权设置</div>
								</div>
								<?php  if(!empty($copyright_style) && !empty($copyright_text) &&  !empty($copyright_icon) && !empty($copyright_open)) { ?>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $copyright_open['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $copyright_open['id'];?>" data-am-ucheck <?php echo $copyright_open['value']!=2?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $copyright_open['id'];?>"  data-am-ucheck <?php echo $copyright_open['value']==2?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">设置版权的开启关闭</span>
									</div>
								</div>
								<!--版权风格-->
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $copyright_style['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $copyright_style['id'];?>" data-am-ucheck <?php echo $copyright_style['value']!=2?"checked":''; ?>>
											左右排列
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $copyright_style['id'];?>"  data-am-ucheck <?php echo $copyright_style['value']==2?"checked":''; ?>>
											上下排列
										</label>
										<!--<input type='radio' name='<?php  echo $copyright_style['id'];?>' value="1" class='' />左右排列-->
										<!--<input type='radio' name='<?php  echo $copyright_style['id'];?>' value="2" class='' />上下排列-->
										<br/>
										<span class="color-9">可选择图片和文字的排列方式</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $copyright_text['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text' name='<?php  echo $copyright_text['id'];?>' value="<?php  echo $copyright_text['value'];?>" class='tpl-form-input' />
										<span class="color-9">设置版权文字（推荐15字内）</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $copyright_icon['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<?php echo tpl_form_field_image($copyright_icon['id'],$copyright_icon['value']?$copyright_icon['value']:"");?>
										<!--<input type='text' name='<?php  echo $copyright_icon['id'];?>' value="<?php  echo $copyright_icon['value'];?>" class='tpl-form-input' />-->
										<span class="color-9">上传版本小图标,推荐尺寸40*40</span>
									</div>
								</div>

								<!--是否开启版本号显示-->
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $version_number_open['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $version_number_open['id'];?>" data-am-ucheck <?php echo $version_number_open['value']!=2?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $version_number_open['id'];?>"  data-am-ucheck <?php echo $version_number_open['value']==2?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">是否开启版本号显示</span>
									</div>
								</div>
								<?php  } else { ?>
								缺少配置，请联系管理员
								<?php  } ?>
								<div class="am-form-group">
									<div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
										<input type="hidden" name="submit" value="提交"/>
										<button type="submit" class="j-submit zx-addBut " id="btn" value="提交" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...'}">提交</button>
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