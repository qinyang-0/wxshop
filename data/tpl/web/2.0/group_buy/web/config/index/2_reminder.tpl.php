<?php defined('IN_IA') or exit('Access Denied');?><div class="am-form-group reminders">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['index_reminder_status']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="1" name="<?php  echo $info['index_reminder_status']['id'];?>" data-am-ucheck <?php echo $info['index_reminder_status']['value']!=2?"checked":''; ?>>
			否
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="2" name="<?php  echo $info['index_reminder_status']['id'];?>" data-am-ucheck <?php echo $info['index_reminder_status']['value']==2?"checked":''; ?>>
			是
		</label>
		<br>
		<span class="color-9">是否开启催单</span>
	</div>
</div>
<div class="<?php  if($info['index_reminder_status']['value']!=2) { ?>nones<?php  } ?>" id="reminders">
	<div class="am-form-group">
		<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['index_reminder_platform_status']['name'];?> </label>
		<div class="am-u-sm-9 am-u-end">
			<label class="am-checkbox-inline am-success">
				<input type="radio"  value="1" name="<?php  echo $info['index_reminder_platform_status']['id'];?>" data-am-ucheck <?php echo $info['index_reminder_platform_status']['value']!=2?"checked":''; ?>>
				否
			</label>
			<label class="am-checkbox-inline am-success">
				<input type="radio"  value="2" name="<?php  echo $info['index_reminder_platform_status']['id'];?>" data-am-ucheck <?php echo $info['index_reminder_platform_status']['value']==2?"checked":''; ?>>
				是
			</label>
			<br>
			<span class="color-9">催单是否给平台发送短信</span>
		</div>
	</div>
</div>
