<?php defined('IN_IA') or exit('Access Denied');?><div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['pay_mchid']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='<?php  echo $info['pay_mchid']['id'];?>' value="<?php echo empty($info['pay_mchid']['value'])?$mchid:$info['pay_mchid']['value'];?>"  class='tpl-form-input' />
			<span class="color-9">支付商户号，推荐和之前微擎配置保持一致</span>
	</div>
</div>
<!--支付密钥-->
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['app_key']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='<?php  echo $info['app_key']['id'];?>' value="<?php echo empty($info['app_key']['value'])?$signkey:$info['app_key']['value'];?>"  class='tpl-form-input' />
			<span class="color-9">支付密钥，推荐和之前微擎配置保持一致</span>
	</div>
</div>

<!---->
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['cert_address']['name'];?>（apiclient_cert.pem） </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='file' name='cert_address'   class="hidden cert_real_click" />
		<span class="btn btn-warning cert_select">选择文件</span>&nbsp;&nbsp;
		<input type='hidden' name='old_cert_address' value="<?php  echo $info[31]['value'];?>"   />
		<span id="cert_select_name"><?php echo !empty($info['cert_address']['value'])?'已上传':$info['cert_address']['value'];?></span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['key_address']['name'];?>（apiclient_key.pem） </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='file' name='key_address'  class="hidden key_real_click" />
		<span class="btn btn-warning key_select">选择文件</span>&nbsp;&nbsp;
		<input type='hidden' name='old_key_address' value="<?php  echo $info['key_address']['value'];?>"   />
		<span id="key_select_name"><?php echo !empty($info['key_address']['value'])?'已上传':$info['key_address']['value'];?></span>
	</div>
</div>