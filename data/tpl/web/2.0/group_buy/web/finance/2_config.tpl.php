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
					<form action="<?php  echo $this->createWebUrl('finance',array('op'=>'config'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">财务相关设置</div>
								</div>
								<?php  if(!empty($auto_sure_head_commission)) { ?>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $auto_sure_head_commission['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $auto_sure_head_commission['id'];?>" data-am-ucheck <?php echo $auto_sure_head_commission['value']==1?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $auto_sure_head_commission['id'];?>"  data-am-ucheck <?php echo $auto_sure_head_commission['value']!=1?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">团长佣金流水自动审核开关</span>
									</div>
								</div>
								<?php  } else { ?>
								缺少配置，请联系管理员
								<?php  } ?>

								<!--2020-03-09 周龙 新增提现配置-->
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">提现方式配置</label>
									<div class="am-u-sm-9 am-u-end">
										<label  class="am-checkbox am-success checkbox_goods" >
											<input type="checkbox" name="<?php  echo $cash_type['id'];?>[]" data-am-ucheck value="1" class="head_enjoy_diy_box" <?php  if(in_array(1,$cash_type['value'])) { ?>checked<?php  } ?> > 微信
										</label>
										<label  class="am-checkbox am-success checkbox_goods" >
											<input type="checkbox" name="<?php  echo $cash_type['id'];?>[]" data-am-ucheck value="2" class="head_enjoy_diy_box" <?php  if(in_array(2,$cash_type['value'])) { ?>checked<?php  } ?> > 支付宝
										</label>
										<label  class="am-checkbox am-success checkbox_goods" >
											<input type="checkbox" name="<?php  echo $cash_type['id'];?>[]" data-am-ucheck value="3" class="head_enjoy_diy_box" <?php  if(in_array(3,$cash_type['value'])) { ?>checked<?php  } ?> > 银行卡
										</label>
										<br/>
										<span class="color-9">前端显示的提现方式</span>
									</div>
								</div>
								<!--end提现配置-->

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