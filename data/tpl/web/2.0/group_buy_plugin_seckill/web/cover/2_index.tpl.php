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
					<form action="<?php  echo $this->createWebUrl('cover',array('op'=>'index'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">秒杀入口设置</div>
								</div>

								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $seckill_cover_key['name'];?> </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<input type='text'  name='<?php  echo $seckill_cover_key['id'];?>' value="<?php  echo $seckill_cover_key['value'];?>" class='tpl-form-input am-fl' placeholder="" style="display: inline-block;" />-->

										<!--<br/>-->
										<!--<span class="color-9"></span>-->
									<!--</div>-->
								<!--</div>-->
								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $seckill_cover_title['name'];?> </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<input type='text'  name='<?php  echo $seckill_cover_title['id'];?>' value="<?php  echo $seckill_cover_title['value'];?>" class='tpl-form-input am-fl' placeholder="" style="display: inline-block;" />-->
									<!--</div>-->


								<!--</div>-->
								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $seckill_cover_img['name'];?> </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<?php /* echo tpl_form_field_image($seckill_cover_img['id'],$seckill_cover_img['value']?$seckill_cover_img['value']:"");*/ ?>
									<!--</div>-->


								<!--</div>-->
								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $seckill_cover_des['name'];?> </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<input type='text'  name='<?php  echo $seckill_cover_des['id'];?>' value="<?php  echo $seckill_cover_des['value'];?>" class='tpl-form-input am-fl' placeholder="" style="display: inline-block;" />-->
									<!--</div>-->


								<!--</div>-->

								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $seckill_cover_key_state['name'];?> </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<label class="am-checkbox-inline am-success">-->
											<!--<input type="radio"  value="1" name="<?php  echo $seckill_cover_key_state['id'];?>" data-am-ucheck <?php echo $seckill_cover_key_state['value']!=2?"checked":''; ?>>-->
											<!--开启-->
										<!--</label>-->
										<!--<label class="am-checkbox-inline am-success">-->
											<!--<input type="radio"  value="2" name="<?php  echo $seckill_cover_key_state['id'];?>"  data-am-ucheck <?php echo $seckill_cover_key_state['value']==2?"checked":''; ?>>-->
											<!--关闭-->
										<!--</label>-->
									<!--</div>-->


								<!--</div>-->
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $seckill_over_time_close['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $seckill_over_time_close['id'];?>' value="<?php  echo $seckill_over_time_close['value'];?>" class='tpl-form-input am-fl' placeholder="" style="display: inline-block;" />
										<span class="color-9">超时自动关闭订单，推荐5分钟之内</span>
									</div>


								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $seckill_goods_list_icon['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<?php echo tpl_form_field_image($seckill_goods_list_icon['id'],$seckill_goods_list_icon['value']?$seckill_goods_list_icon['value']:"");?>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $seckill_goods_info_price_bg['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type="color" value="<?php  echo $seckill_goods_info_price_bg['value'];?>" name="<?php  echo $seckill_goods_info_price_bg['id'];?>"/>
									</div>
								</div>
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