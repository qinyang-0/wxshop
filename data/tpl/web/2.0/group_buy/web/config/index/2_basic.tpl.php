<?php defined('IN_IA') or exit('Access Denied');?>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">导入省市区</label>
	<div class="am-u-sm-9 am-u-end">
		<a href="javascript:;" id="imp_area" style="color: white !important;" class="j-submit zx-addBut ">开始导入</a>
		<br/>
		<span class="color-9">仅首次安装后需要导入,如果已经导入过请勿重复导入</span>
	</div>
</div>
<script>
    $("#imp_area").click(function(){
        var layer_index = layer.load(0, {shadeClose: false,shade: [0.3, '#000']});
        $.get(
            "<?php  echo $this->createWebUrl('areasql')?>",
            function(res){
                console.log(res);
                layer.close(layer_index);
                layer.msg(res.msg);

            },'json'
        );

    });
</script>
<?php  if(!empty($now_version_num)) { ?>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">当前的模块版本号 </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text'  readonly value="<?php  echo $now_version_num;?>" class='tpl-form-input' />
		<span class="color-9">当前的模块版本号</span>
	</div>
</div>
<?php  } ?>

<div class="am-form-group">

	<label class="am-u-sm-3 am-u-lg-2 am-form-label">站点标题</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name="sitename" value="<?php  echo $sitename;?>" class="tpl-form-input" />
		<span class="color-9">站点标题</span>
	</div>
</div>

<div class="am-form-group">

	<label class="am-u-sm-3 am-u-lg-2 am-form-label">公司名称</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name="<?php  echo $company_name['id'];?>" value="<?php  echo $company_name['value'];?>" class="tpl-form-input" />
		<span class="color-9">公司名称登录页显示</span>
	</div>
</div>

<div class="am-form-group">

	<label class="am-u-sm-3 am-u-lg-2 am-form-label">前端是否显示库存</label>
	<div class="am-u-sm-9 am-u-end">
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="-1" name="<?php  echo $show_stock['id'];?>" data-am-ucheck <?php echo $show_stock['value']!=1?"checked":''; ?>>
			不显示
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="1" name="<?php  echo $show_stock['id'];?>"  data-am-ucheck <?php echo $show_stock['value']==1?"checked":''; ?>>
			显示
		</label>
		<br/>
		<span class="color-9">前端是否显示库存</span>
	</div>
</div>

<div class="am-form-group">

	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $back_set_type['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="1" name="<?php  echo $back_set_type['id'];?>" data-am-ucheck <?php echo $back_set_type['value']!=2?"checked":''; ?>>
			标题
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="2" name="<?php  echo $back_set_type['id'];?>"  data-am-ucheck <?php echo $back_set_type['value']==2?"checked":''; ?>>
			图标
		</label>
		<br/>
		<span class="color-9">控制后台左上角显示标题还是图标</span>
	</div>
</div>



<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $back_title_set['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='<?php  echo $back_title_set['id'];?>' value="<?php  echo $back_title_set['value'];?>" class='tpl-form-input' />
		<span class="color-9">管理后台左上角标题显示</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $back_icon_set['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<?php echo tpl_form_field_image($back_icon_set['id'],$back_icon_set['value']?$back_icon_set['value']:"");?>
		<span class="color-9">管理后台左上角图标显示</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['diy_community_name']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='<?php  echo $info['diy_community_name']['id'];?>' value="<?php  echo $info['diy_community_name']['value'];?>" class='tpl-form-input' />
		<span class="color-9">自定义社区或小区名称（改为校园....）</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['group_buy_name']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='<?php  echo $info['group_buy_name']['id'];?>' value="<?php  echo $info['group_buy_name']['value'];?>" class='tpl-form-input' />
		<span class="color-9">自定义团购名称</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['group_buy_commander_name']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name="<?php  echo $info['group_buy_commander_name']['id'];?>" value="<?php  echo $info['group_buy_commander_name']['value'];?>" class='tpl-form-input' />
		<span class="color-9">团长名称自定义</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['group_buy_choice']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name="<?php  echo $info['group_buy_choice']['id'];?>" value="<?php  echo $info['group_buy_choice']['value'];?>" class='tpl-form-input' />
		<span class="color-9">下单页面和选择团长页面团长名称自定义</span>
	</div>
</div>

<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['sever_phone']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='<?php  echo $info['sever_phone']['id'];?>' value="<?php  echo $info['sever_phone']['value'];?>" class='tpl-form-input' />
		<span class="color-9">请输入正确的电话，用于前端个人中心页显示给用户</span>
	</div>
</div>
<div class="am-form-group cutting">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['cutting_order']['name'];?> </label>
	<div class="am-u-sm-10 am-u-end">
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="1" name="<?php  echo $info['cutting_order']['id'];?>" data-am-ucheck <?php  if($info['cutting_order']['value'] == 1) { ?>checked<?php  } ?>>
			开启
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="2" name="<?php  echo $info['cutting_order']['id'];?>" data-am-ucheck <?php  if($info['cutting_order']['value'] != 1) { ?>checked<?php  } ?>>
			关闭
		</label>
		<br>
		<span class="color-9">平台截单就是某一个时间段用户无法下单.</span>
	</div>
</div>
<div id="cutting" <?php  if($info['cutting_order']['value'] != 1) { ?>style="display:none;"<?php  } ?>>
	<div class="am-form-group">
		<?php  $time = unserialize($info['cutting_order_time']['value'])?>
		<label class="am-u-sm-3 am-u-lg-2 am-form-label">截单时间 </label>
		<div class="am-u-sm-9 am-u-end">
			<div class="col-sm-9 col-xs-12 m5" style="padding: 0;">
				<input type="text" name="" id="" value="开始时间" style="width: 10% !important;" readonly="" class="form-control input_left_border" />
				<?php  echo tpl_form_field_clock('star_time',$time['star_time'])?>
				<input type="text" name="" id="" value="结束时间" readonly="" style="width: 10% !important;" class="form-control input_right_border input_right_border_radius" />
				<!--<select name="end_time_status" class="form-control input_left_border">
					<option value="1" <?php  if($time['end_time_status'] == 1) { ?>selected<?php  } ?>>当天</option>
					<option value="2" <?php  if($time['end_time_status'] == 2) { ?>selected<?php  } ?>>第二天</option>
				</select>-->
				<?php  echo tpl_form_field_clock('end_time', $time['end_time'])?>
			</div>
		<div style="clear: both;"></div>
		<span class="color-9">如结束时间是00点，那么这个时间是属于第二天00点</span>
		</div>
	</div>
	<div class="am-form-group">
		<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['cutting_info']['name'];?> </label>
		<div class="am-u-sm-9 am-u-end">
			<input type='text' name='<?php  echo $info['cutting_info']['id'];?>' value="<?php  echo $info['cutting_info']['value'];?>" class='tpl-form-input' />
			<span class="color-9">平台截单提示信息	</span>
		</div>
	</div>
</div>

<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['member_sroce_show']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="1" name="<?php  echo $info['member_sroce_show']['id'];?>" data-am-ucheck <?php echo $info['member_sroce_show']['value']!=2?"checked":''; ?>>
			开启
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="2" name="<?php  echo $info['member_sroce_show']['id'];?>" data-am-ucheck <?php echo $info['member_sroce_show']['value']==2?"checked":''; ?>>
			关闭
		</label>
		<br>
		<span class="color-9">个人中心是否显示积分商城</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['member_distribution_show']['name'];?> </label>
	<div class="am-u-sm-10 am-u-end">
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="1" name="<?php  echo $info['member_distribution_show']['id'];?>" data-am-ucheck <?php echo $info['member_distribution_show']['value']!=2?"checked":''; ?>>
			开启
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="2" name="<?php  echo $info['member_distribution_show']['id'];?>" data-am-ucheck <?php echo $info['member_distribution_show']['value']==2?"checked":''; ?>>
			关闭
		</label>
		<br>
		<span class="color-9">个人中心是否显示分销商城</span>
	</div>
</div>