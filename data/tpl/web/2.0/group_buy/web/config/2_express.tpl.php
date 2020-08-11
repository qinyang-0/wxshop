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
					<form action="<?php  echo $this->createWebUrl('config',array('op'=>'express'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">物流设置</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $mention['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $mention['id'];?>" data-am-ucheck <?php echo $mention['value']!=2?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $mention['id'];?>"  data-am-ucheck <?php echo $mention['value']==2?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9"></span>
									</div>
								</div>
								<?php  if(!empty($is_open_express)) { ?>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $is_open_express['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $is_open_express['id'];?>" data-am-ucheck <?php echo $is_open_express['value']!=2?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $is_open_express['id'];?>"  data-am-ucheck <?php echo $is_open_express['value']==2?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9"></span>
									</div>
								</div>
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">快递鸟设置</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $express_bird_id['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $express_bird_id['id'];?>' value="<?php  echo $express_bird_id['value'];?>" class='tpl-form-input am-fl' placeholder="" style="display: inline-block;" />
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">快递鸟商户id <a style="color:red;" href = "http://www.kdniao.com/reg">快递鸟接口申请</a></span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $express_bird_key['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $express_bird_key['id'];?>' value="<?php  echo $express_bird_key['value'];?>" class='tpl-form-input am-fl' placeholder="" style="display: inline-block;" />
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">快递鸟API KEY </span>
									</div>
								</div>
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">昵称设置</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $delivery_self['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $delivery_self['id'];?>' value="<?php  echo $delivery_self['value'];?>" class='tpl-form-input am-fl' placeholder="" style="display: inline-block;" />
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">自提方式昵称：默认'自提'</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $delivery_chief['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $delivery_chief['id'];?>' value="<?php  echo $delivery_chief['value'];?>" class='tpl-form-input am-fl' placeholder="" style="display: inline-block;" />
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">团长送货昵称：默认'团长送货'</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $delivery_express['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $delivery_express['id'];?>' value="<?php  echo $delivery_express['value'];?>" class='tpl-form-input am-fl' placeholder="" style="display: inline-block;" />
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">快递昵称：默认'快递'</span>
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