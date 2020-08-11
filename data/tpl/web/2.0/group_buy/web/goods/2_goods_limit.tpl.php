<?php defined('IN_IA') or exit('Access Denied');?><div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>单次限购</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='number'  name='g_limit_num' value="<?php echo !empty($info['g_limit_num'])?$info['g_limit_num']:0;?>" class='tpl-form-input' />
		<span class="color-9">用户单次购买限制购物数量，为0时表示不限制</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>单人每天限购</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='number'  name='g_day_limit_num' value="<?php echo !empty($info['g_day_limit_num'])?$info['g_day_limit_num']:0;?>" class='tpl-form-input' />
		<span class="color-9">用户单人每天购买限制购物数量，为0时表示不限制</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>历史限购</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='number'  name='g_history_limit_num' value="<?php echo !empty($info['g_history_limit_num'])?$info['g_history_limit_num']:0;?>" class='tpl-form-input' />
		<span class="color-9">用户单人历史购买限制购物数量，为0时表示不限制</span>
	</div>
</div>