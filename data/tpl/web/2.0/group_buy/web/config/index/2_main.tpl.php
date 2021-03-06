<?php defined('IN_IA') or exit('Access Denied');?><div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['index_share_title_type']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="1" name="<?php  echo $info['index_share_title_type']['id'];?>" data-am-ucheck <?php echo $info['index_share_title_type']['value']!=2?"checked":''; ?>>
			首页页面标题
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="2" name="<?php  echo $info['index_share_title_type']['id'];?>" data-am-ucheck <?php echo $info['index_share_title_type']['value']==2?"checked":''; ?>>
			自定义标题
		</label>
		<br>
		<span class="color-9">首页分享出去的标题类型</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['index_share_title']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='<?php  echo $info['index_share_title']['id'];?>' value="<?php  echo $info['index_share_title']['value'];?>" class='tpl-form-input' />
		<span class="color-9">首页分享出去的自定义标题</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['index_share_img_type']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="1" name="<?php  echo $info['index_share_img_type']['id'];?>" data-am-ucheck <?php echo $info['index_share_img_type']['value']!=2?"checked":''; ?>>
			首页页面默认截图
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="2" name="<?php  echo $info['index_share_img_type']['id'];?>" data-am-ucheck <?php echo $info['index_share_img_type']['value']==2?"checked":''; ?>>
			自定义图片
		</label>
		<br>
		<span class="color-9">首页分享出去的图片类型</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['index_share_img']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<?php echo tpl_form_field_image($info['index_share_img']['id'],$info['index_share_img']['value']?$info['index_share_img']['value']:"");?>
		<span class="color-9">首页分享出去的自定义图片</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['data_end_show_img_open']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="1" name="<?php  echo $info['data_end_show_img_open']['id'];?>" data-am-ucheck <?php echo $info['data_end_show_img_open']['value']!=2?"checked":''; ?>>
			开启
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="radio"  value="2" name="<?php  echo $info['data_end_show_img_open']['id'];?>" data-am-ucheck <?php echo $info['data_end_show_img_open']['value']==2?"checked":''; ?>>
			关闭
		</label>
		<br>
		<span class="color-9">是否显示首页分类页数据加载完的底部图</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['data_end_show_img']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<?php echo tpl_form_field_image($info['data_end_show_img']['id'],$info['data_end_show_img']['value']?$info['data_end_show_img']['value']:"");?>
		<span class="color-9">加载未完成时的默认图片（大），自定义推荐尺寸70*70或者相同比例，大小推荐10kb之内</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['default_big_img']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<?php echo tpl_form_field_image($info['default_big_img']['id'],$info['default_big_img']['value']?$info['default_big_img']['value']:"");?>
		<span class="color-9">加载未完成时的默认图片（小），自定义推荐尺寸40*40或者相同比例，大小推荐10kb之内</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['default_small_img']['name'];?> </label>
	<div class="am-u-sm-9 am-u-end">
		<?php echo tpl_form_field_image($info['default_small_img']['id'],$info['default_small_img']['value']?$info['default_small_img']['value']:"");?>
		<span class="color-9">首页分享出去的自定义图片</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">团长排行榜 </label>
	<div class="am-u-sm-9 am-u-end ">
		<label class="am-checkbox-inline am-success">
			<input type="checkbox"  value="日榜" name="team_rank[0]" data-am-ucheck <?php echo  in_array("日榜",$team_rank)?"checked":''; ?>>
			日榜
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="checkbox"  value="周榜" name="team_rank[10]" data-am-ucheck <?php echo in_array("周榜",$team_rank)?"checked":''; ?>>
			周榜
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="checkbox"  value="月榜" name="team_rank[20]" data-am-ucheck <?php echo in_array("月榜",$team_rank)?"checked":''; ?>>
			月榜
		</label>
		<label class="am-checkbox-inline am-success">
			<input type="checkbox"  value="年榜" name="team_rank[30]"  data-am-ucheck <?php echo in_array("年榜",$team_rank)?"checked":''; ?>>
			年榜
		</label>
		<br>
		<span class="color-9">控制团长管理中心的排行榜显示类型</span>
	</div>
</div>