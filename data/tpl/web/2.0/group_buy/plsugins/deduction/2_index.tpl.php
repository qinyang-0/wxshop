<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.btn-group .active {
		background-color: #428bca;
		color: #fff;
	}
	.input_left_border{
		width: 16% !important;
		float: left;
		border-top-right-radius: 0!important;
		border-bottom-right-radius: 0!important;
		border-right: 0!important;
		text-align: center;
	}
	.input_right_border{
		width: 7% !important;float: left;border-top-left-radius: 0!important;border-bottom-left-radius: 0!important;border-left: 0!important;text-align: center;
	}
	.input_right_border_radius{
		border-top-right-radius: 0!important;
		border-bottom-right-radius: 0!important;
		border-right: 0!important;
	}
	.input_left_border_radius{
		border-top-left-radius: 0!important;border-bottom-left-radius: 0!important;border-left: 0!important;
	}
	.m5{
		margin-bottom: 10px;
	}
</style>
<!--右侧详细内容区域 from 自定义-->
<div class="tpl-content-wrapper no-sidebar-second">
	<!--本页自定义样式-->
	<!--右侧详细内容区域，灰框之内,from 妹子-->
	<div class="row-content am-cf">
		<!--2列式简单布局,from bootstap-->
		<div class="row">
			<!--12列布局,from 妹子-->
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<!--widget自定义右侧盒子 from 自定义 am-cf 清除全部浮动  from 妹子-->
				<div class="widget am-cf">
					<form action="<?php  echo $this->createWebUrl('plsugins',array('op'=>'deduction','in'=>'add'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">积分抵扣设置</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">是否启用积分抵扣 </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="dedu[value]" data-am-ucheck <?php echo $info['dedu']==1?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="dedu[value]"  data-am-ucheck <?php echo $info['dedu']!=1?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<input type="hidden" name="dedu[name]" id="" value="是否启用积分抵扣" />
										<span class="color-9">是否启用积分抵扣,注:一但开启积分抵扣,用户下单采用了积分抵扣,退款时,积分将不会退还.</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">积分抵扣比例 </label>
									<div id="proba" class="col-sm-9 col-xs-12" style="padding: 0;">
										<div class="col-sm-9 col-xs-12 m5">
											<input type="text" name="" id="" value="1个积分 抵扣" style="width: 10% !important;" readonly="" class="form-control input_left_border" />
											<input type='text' id='probability' name='deduction[value]' value="<?php  echo $info['deduction'];?>" class='form-control input_left_border input_left_border_radius'/>
											<input type='text' id='' name='' readonly="" value="元" class='form-control' style="width: 5%;border-top-left-radius: 0;border-bottom-left-radius: 0;border-left: 0;"/>
										</div>
									</div>
									<div class="col-sm-9 col-xs-12 m5" style="padding: 0;display: none;">
										<input type="hidden" name="deduction[name]" id="" value="积分抵扣比例" />
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">每笔订单最多可使用多少 </label>
									<div id="proba" class="col-sm-9 col-xs-12" style="padding: 0;">
										<div class="col-sm-9 col-xs-12 m5">
											<input type='number' id='probability' name='may_use[value]' value="<?php  echo $info['may_use'];?>" class='form-control' style="width: 31%;" />
										</div>
									</div>
									<div class="col-sm-9 col-xs-12 m5" style="padding: 0;">
										<input type="hidden" name="may_use[name]" id="" value="积分抵扣比例" />
									</div>
								</div>
								<!--<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">会员卡玩法 </label>
									<div class="am-u-sm-9 am-u-end">
										<select name="card_take[value]" class="tpl-form-input">
											<option value="1" <?php echo $info['card_take'] !='1'?selected:'';?>>购买会员卡</option>
											<option value="-1" <?php echo $info['card_take'] =='1'?selected:'';?>>根据消费金额自动升级</option>
										</select>
										<input type="hidden" name="card_take[name]" id="" value="会员卡玩法" />
									</div>
								</div>-->
								<!--<div id="is-show" class="<?php echo $info['card_id']!='1'?hidden:'';?>">
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">是否先使用会员卡折扣</label>
										<div class="am-u-sm-9 am-u-end">
											<label class="am-radio-inline am-success">
													<input type="radio" name="card_discount[value]" data-am-ucheck  value="2" <?php  if($info['card_discount'] !=1) { ?>checked<?php  } ?>> 是
												</label>
											<label class="am-radio-inline am-success">
													<input type="radio" name="card_discount[value]" data-am-ucheck  value="1" <?php  if($info['card_discount'] ==1) { ?>checked<?php  } ?>> 否
												</label>
												<input type="hidden" name="card_discount[name]" id="" value="是否先使用会员卡折扣" />
												<span class="color-9" style="display: inherit;">注：如果先使用会员卡折扣，那么用户在下单的时候，会先扣除会员卡折扣，在计算优惠券等优惠，列：用户购买100元产品，使用优惠券50元，折扣9折，那么计算公式为(100*90%)-50=40元，反之为(100-50)*90%=45元</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">重复购买会员卡是否返现</label>
										<div class="am-u-sm-9 am-u-end">
											<label class="am-radio-inline am-success">
													<input type="radio" name="card_cash[value]" data-am-ucheck  value="2" <?php  if($info['card_cash'] !=1) { ?>checked<?php  } ?>> 是
												</label>
											<label class="am-radio-inline am-success">
													<input type="radio" name="card_cash[value]" data-am-ucheck  value="1" <?php  if($info['card_cash'] ==1) { ?>checked<?php  } ?>> 否
												</label>
												<input type="hidden" name="card_cash[name]" id="" value="是否先使用会员卡折扣" />
												<span class="color-9" style="display: inherit;">注：列如当前用户已经使用500元，购买了1年的会员卡，使用了6个月过后，想升级更高等级的会员卡，那么还剩下6个月的会员卡是否按照差价补给用户.公式:(500/365)*180=246.57(保留两位小数)</span>
										</div>
									</div>
								</div>-->
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
$(document).on("change","select[name='card_id[value]']",function () {
	if($(this).val()=="1"){
	    $("#is-show").removeClass("hidden");
	}else{
        $("#is-show").addClass("hidden");
	}
})
$('#btn').click(function(res){
	layer.load(3,{shade: [0.7,'#000']});
	return true;
})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
