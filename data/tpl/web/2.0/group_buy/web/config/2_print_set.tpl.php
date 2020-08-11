<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.btn-group .active {
		background-color: #428bca;
		color: #fff;
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
					<form action="<?php  echo $this->createWebUrl('config',array('op'=>'print_set'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">打印机设置</div>
								</div>
								<?php  if(!empty($info)) { ?>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">打印机类型 </label>
									<div class="am-u-sm-9 am-u-end">
										<select name="print_type">
											<option value="飞鹅云" <?php echo $info['print_type']=='飞鹅云'?'selected':'';?>>飞鹅云</option>
										</select>
									</div>
								</div>
								<!--打印机编号-->
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">打印机编号（SN） </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='print_sn' value="<?php  echo $info['print_sn'];?>" class='tpl-form-input' />
										<input type='hidden'  name='print_sn_old' value="<?php  echo $info['print_sn_old'];?>" class='tpl-form-input' />
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">打印机密钥（KEY） </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='print_key' value="<?php  echo $info['print_key'];?>" class='tpl-form-input' />
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">打印机备注名称 </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='print_name' value="<?php  echo $info['print_name'];?>" class='tpl-form-input' />
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


<script>
    $(document).on('click','#btn',function(){
        var print_type = $.trim($('select[name=print_type]').val());
        var print_sn = $.trim($('input[name=print_sn]').val());
        var print_type = $.trim($('input[name=print_type]').val());
        var print_type = $.trim($('input[name=print_type]').val());
    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>