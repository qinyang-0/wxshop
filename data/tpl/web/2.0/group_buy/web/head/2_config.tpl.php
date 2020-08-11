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
					<form action="<?php  echo $this->createWebUrl('head',array('op'=>'config'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">团长相关设置</div>
								</div>
								<?php  if(!empty($info)) { ?>
								<!--佣金配置-->
								<div class="am-form-group">
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['commission_ratio']['name'];?> </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<input type='number' id='commission' name='<?php  echo $info['commission_ratio']['id'];?>' value="<?php  echo $info['commission_ratio']['value'];?>" class='tpl-form-input' />-->
											<!--<span class="color-9">请输入1-100内数字，用于给新增的团长一个默认的佣金比例，个别团长若不同，请在对应团长编辑页进行修改</span>-->
									<!--</div>-->
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['select_head_distance']['name'];?>（km） </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='number'  name='<?php  echo $info['select_head_distance']['id'];?>' value="<?php  echo $info['select_head_distance']['value'];?>" class='tpl-form-input' />
										<span class="color-9">选择团长页显示团长的距离（0则为全部）</span>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['select_head_num']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='number'  name='<?php  echo $info['select_head_num']['id'];?>' value="<?php  echo $info['select_head_num']['value'];?>" class='tpl-form-input' />
										<span class="color-9">选择团长页显示团长的数量（0则为全部）</span>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['get_cash_limit_money']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='number'  name='<?php  echo $info['get_cash_limit_money']['id'];?>' value="<?php  echo $info['get_cash_limit_money']['value'];?>" class='tpl-form-input' />
										<span class="color-9">团长提现门槛设置</span>
									</div>

									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['last_head_notice']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">

											<input type="radio"  value="1" name="<?php  echo $info['last_head_notice']['id'];?>" data-am-ucheck <?php echo $info['last_head_notice']['value']=='1'?"checked":''; ?>>
											开启弹窗
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $info['last_head_notice']['id'];?>"  data-am-ucheck <?php echo $info['last_head_notice']['value']!=1?"checked":''; ?>>
											关闭弹窗
										</label>
										<br/>
										<span class="color-9">设置首页是否开启提醒选择上次购物团长的弹窗</span>
									</div>
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['apply_head_img']['name'];?> </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<?php  /*echo tpl_ueditor($info['apply_head_img']['id'],$info['apply_head_img']['value']);*/ ?>
										<!--<span class="color-9">申请团长页进入时的引导申请广告图</span>-->
									<!--</div>-->
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['group_info_bg_img']['name'];?> </label>
										<div class="am-u-sm-9 am-u-end">
											<?php echo tpl_form_field_image($info['group_info_bg_img']['id'],$info['group_info_bg_img']['value']?$info['group_info_bg_img']['value']:"");?>
											<!--<input type='text' name='<?php  echo $copyright_icon['id'];?>' value="<?php  echo $copyright_icon['value'];?>" class='tpl-form-input' />-->
											<span class="color-9">个人中心页团长信息背景图 <a href="/addons/group_buy/public/bg/group_info_img.png" class="text-blue" target="_blank" style="color: #428bca;">点击获取默认图片</a></span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['apply_head_img']['name'];?> </label>
										<div class="am-u-sm-9 am-u-end">
											<?php echo tpl_form_field_image($info['apply_head_img']['id'],$info['apply_head_img']['value']?$info['apply_head_img']['value']:"");?>
											<!--<input type='text' name='<?php  echo $copyright_icon['id'];?>' value="<?php  echo $copyright_icon['value'];?>" class='tpl-form-input' />-->
											<span class="color-9">申请团长页进入时的引导申请广告图 <a href="/addons/group_buy/public/bg/apply_head_deafult.png" class="text-blue" target="_blank" style="color: #428bca;">点击获取默认图片</a></span>
										</div>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['apply_head_text']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<?php  echo tpl_ueditor($info['apply_head_text']['id'],$info['apply_head_text']['value']);?>
										<span class="color-9">申请团长时显示的服务条款</span>
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
    $('#btn').click(function(){
        var commission = $.trim($("#commission").val());
        if(!isOneToHundred(commission) ){
            layer.msg('请输入1到100正确的数，最多保留2位小数',{icon:2,time:2000});
            return false;
        }
    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>