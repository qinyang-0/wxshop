<?php defined('IN_IA') or exit('Access Denied');?><div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">自动取消订单地址</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='' value="<?php echo ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';?><?php  echo $_SERVER['HTTP_HOST'];?><?php echo '/app/index.php?i='.$_W['uniacid'].'&from=wxapp&m=group_buy&a=wxapp&c=entry&do=plsugins&op=overview'?>" readonly=""  class='tpl-form-input' />
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">自动收货地址</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='' value="<?php echo ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';?><?php  echo $_SERVER['HTTP_HOST'];?><?php echo '/app/index.php?i='.$_W['uniacid'].'&from=wxapp&m=group_buy&a=wxapp&c=entry&do=plsugins&op=overview&in=auto'?>"  class='tpl-form-input' readonly="" />
	</div>
</div>
