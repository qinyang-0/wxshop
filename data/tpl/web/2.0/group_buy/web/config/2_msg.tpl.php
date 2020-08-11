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
					<form action="<?php  echo $this->createWebUrl('config',array('op'=>'msg'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">短信配置</div>
								</div>
								<?php  if(!empty($info)) { ?>
								<!---->
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['sms_type']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<select name="<?php  echo $info['sms_type']['id'];?>" class="tpl-form-input">
											<option value="1" <?php echo $info['sms_type']['value']==='1'?selected:'';?>>是</option>
											<option value="-1" <?php echo $info['sms_type']['value']=='-1'?selected:'';?>>否</option>
										</select>
									</div>
								</div>
								<div id="is-show" class="<?php echo $info['sms_type']['value']=='-1'?hidden:'';?>">
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['sms_type']['name'];?> </label>
										<div class="am-u-sm-9 am-u-end">
											<select name="<?php  echo $info['sms_code']['id'];?>" class="tpl-form-input">
												<option value="1" <?php echo $info['sms_code']['value']=='1'?selected:'';?>>阿里云</option>
												<option value="2" <?php echo $info['sms_code']['value']=='2'?selected:'';?>>创瑞</option>
											</select>
											<span class="color-9">选择哪种短信服务商</span>
										</div>
									</div>

									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">key </label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='key[value]' value="<?php  echo $msg['key']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='key[name]' value="key" class='' />
											<span class="color-9">对应短信服务商提供的key值</span>
										</div>
									</div>

									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">serect </label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='serect[value]' value="<?php  echo $msg['serect']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='serect[name]' value="serect" class='tpl-form-input' />
											<span class="color-9">对应短信服务商提供的serect值</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">签名 </label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='sign[value]' value="<?php  echo $msg['sign']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='sign[name]' value="签名" class='tpl-form-input' />
											<span class="color-9">对应短信服务商配置的签名</span>
										</div>
									</div>

									<!--管理员-->
									<?php  if(!empty($manage)) { ?>
									<?php  if(is_array($manage)) { foreach($manage as $k => $v) { ?>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">管理员电话</label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='manage[]' value="<?php  echo $v;?>" class='tpl-form-input' />
										</div>
										<span class="btn btn-danger del-manage"><i class="fa fa-trash-o"></i> 删除</span>
									</div>
									<?php  } } ?>
									<?php  } else { ?>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">管理员电话</label>
										<div class="am-u-sm-9 am-u-end">
											<input type="text" name="manage[]" value="" class="tpl-form-input" />
										</div>
										<span class="btn btn-danger del-manage"><i class="fa fa-trash-o"></i> 删除</span>
									</div>
									<?php  } ?>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 control-label"></label>
										<div class="am-u-sm-9 am-u-end">
											<span id="add-manage" class="zx-addBut"><i class="fa fa-plus"></i> 新增管理员</span>
										</div>
									</div>

									<!--模版cdeo(模版id)-->
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">支付成功模版id<br/>(模版code)</label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='pay_success[id][value]' value="<?php  echo $pay_success['id']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='pay_success[id][name]' value="支付成功模版id(模版code)" class='tpl-form-input' />
											<div class="col-sm-12 col-xs-12">
												<span class="color-9">在短信服务商申请模版后将模版ID复制填写于此</span>
											</div>
										</div>
									</div>

									<!--模版内容-->
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">支付成功模版内容</label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='pay_success[content][value]' value="<?php  echo $pay_success['content']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='pay_success[content][name]' value="支付成功模版内容" class='tpl-form-input' />
											<div class="col-sm-12 col-xs-12">
												<span class="color-9">在短信服务商申请模版后将模版内容复制填写于此</span>
											</div>
										</div>
									</div>
									<!--模版cdeo(模版id)-->
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">申请团长模版id<br/>(模版code)</label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='apply_head[id][value]' value="<?php  echo $apply_head['id']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='apply_head[id][name]' value="申请团长模版id(模版code)" class='tpl-form-input' />
											<div class="col-sm-12 col-xs-12">
												<span class="color-9">在短信服务商申请模版后将模版ID复制填写于此</span>
											</div>
										</div>
									</div>

									<!--模版内容-->
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">申请团长模版内容</label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='apply_head[content][value]' value="<?php  echo $apply_head['content']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='apply_head[content][name]' value="申请团长模版内容" class='tpl-form-input' />
											<div class="col-sm-12 col-xs-12">
												<span class="color-9">在短信服务商申请模版后将模版内容复制填写于此</span>
											</div>
										</div>
									</div>
									<!--模版cdeo(模版id)-->
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">退款模版id<br/>(模版code)</label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='back_cash[id][value]' value="<?php  echo $back_cash['id']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='back_cash[id][name]' value="退款模版id(模版code)" class='tpl-form-input' />
											<div class="col-sm-12 col-xs-12">
												<span class="color-9">在短信服务商申请模版后将模版ID复制填写于此</span>
											</div>
										</div>
									</div>

									<!--模版内容-->
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">退款模版内容</label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='back_cash[content][value]' value="<?php  echo $back_cash['content']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='back_cash[content][name]' value="退款模版内容" class='tpl-form-input' />
											<div class="col-sm-12 col-xs-12">
												<span class="color-9">在短信服务商申请模版后将模版内容复制填写于此</span>
											</div>
										</div>
									</div>
									<!--模版cdeo(模版id)-->
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">提现模版id<br/>(模版code)</label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='get_cash[id][value]' value="<?php  echo $get_cash['id']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='get_cash[id][name]' value="提现模版id(模版code)" class='tpl-form-input' />
											<div class="col-sm-12 col-xs-12">
												<span class="color-9">在短信服务商申请模版后将模版ID复制填写于此</span>
											</div>
										</div>
									</div>

									<!--模版内容-->
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">提现模版内容</label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='get_cash[content][value]' value="<?php  echo $get_cash['content']['value'];?>" class='tpl-form-input' />
											<input type='hidden' name='get_cash[content][name]' value="提现模版内容" class='tpl-form-input' />
											<div class="col-sm-12 col-xs-12">
												<span class="color-9">在短信服务商申请模版后将模版内容复制填写于此</span>
											</div>
										</div>
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
$(document).on("click","#add-manage",function () {
	var str  = '<div class="am-form-group"><label class="am-u-sm-3 am-u-lg-2 am-form-label">管理员电话</label><div class="am-u-sm-9 am-u-end"><input type="text" name="manage[]" value="" class="tpl-form-input" /></div><span class="btn btn-danger del-manage"><i class="fa fa-trash-o"></i> 删除</span></div>';
	$(this).parent("div").parent("div").before(str);
});

$(document).on("click",".del-manage",function () {
    var length = $(".del-manage").length;
    if(length<=1){
        layer.msg("至少保留一个管理员的电话",{icon:2,time:2000});
	}else{
        $(this).parent("div").remove();
	}
});

$(document).on("change","select[name=<?php  echo $info['sms_type']['id'];?>]",function () {
	if($(this).val()=="1"){
	    $("#is-show").removeClass("hidden");
	}else{
        $("#is-show").addClass("hidden");
	}
})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
