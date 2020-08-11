<?php defined('IN_IA') or exit('Access Denied');?><div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label "><b class="text-danger">*</b>商品名称 </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' id='name' name='name' value="<?php  echo $info['g_name'];?>" class='tpl-form-input'/>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">商品副标题</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name="info"  class='tpl-form-input' value="<?php  echo $info['g_brief'];?>"/>
		<span class="color-9">显示在标题下一行，用于提示</span>
	</div>
</div>

<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>商品分类</label>
	<div class="am-u-sm-9 am-u-end">
		<div style="width: 460px;">
			<select  name="cid[]" data-am-selected="{maxHeight: 250,searchBox: 1}"  placeholder="请选择分类" multiple >
				<!--<option value=""></option>-->
				<?php  if(!empty($cate)) { ?>
				<?php  if(is_array($cate)) { foreach($cate as $k => $v) { ?>
				<option value="<?php  echo $v['gc_id'];?>" data-level="<?php  echo $v['gc_level'];?>"  data-tree="<?php  echo $v['gc_tree'];?>" <?php  if(is_array($old_cates) && in_array($v['gc_id'],$old_cates)) { ?>selected<?php  } ?>><?php  echo str_repeat("&nbsp;&nbsp;&nbsp;",$v['gc_level'])?><?php  echo $v['gc_name'];?></option>
				<?php  } } ?>
				<?php  } ?>
			</select>
		</div>

	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label " >供应商</label>
	<div class="am-u-sm-9 am-u-end">
		<select class="tpl-form-input" name="supplier" >
			<?php  if(!empty($supplier)) { ?>
			<?php  if($this->supplier_role==0) { ?>
			<option value="">请选择..</option>
			<?php  if(is_array($supplier)) { foreach($supplier as $k => $v) { ?>
			<option value="<?php  echo $v['gsp_id'];?>" <?php  if($info['g_supplier_id'] == $v['gsp_id']) { ?>selected<?php  } ?>><?php  echo $v['gsp_shop_name'];?></option>
			<?php  } } ?>
			<?php  } else { ?>
			<option value="<?php  echo $supplier[0]['gsp_id'];?>" selected}><?php  echo $supplier[0]['gsp_shop_name'];?></option>
			<?php  } ?>
			<?php  } else { ?>
			<option value="">暂无</option>
			<?php  } ?>
		</select>
		<!--<input type='text'  name='supplier' value="<?php  echo $info['g_supplier_id'];?>" class='tpl-form-input'/>-->
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>商品售价（元）</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' id='price' name='price' value="<?php echo $info['g_price']?$info['g_price']:'0.00'?>" class='tpl-form-input' />
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>商品原价（元）</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' id='old_price' name='old_price' value="<?php echo $info['g_old_price']?$info['g_old_price']:'0.00'?>" class='tpl-form-input' />
	</div>

</div>


<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label ">商品货号</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' id='goods_num' name='goods_num' value="<?php  echo $info['g_product_num'];?>" class='tpl-form-input'/>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>商品库存</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='number' id='save' name='save' value="<?php echo $stock['num']?$stock['num']:0?>" class='tpl-form-input' />
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>商品库存警戒</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='number' id='g_stock_notice' name='g_stock_notice' value="<?php echo $info['g_stock_notice']?$info['g_stock_notice']:0?>" class='tpl-form-input' />
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">商品封面</label>
	<div class="am-u-sm-9 am-u-end">
		<?php echo tpl_form_field_image('icon',$info['g_icon']?$info['g_icon']:"");?>
		<span class="color-9">推荐上传图片尺寸为250像素*250像素，居中（显示在首页，分类页）</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">商品详情页缩略图</label>
	<div class="am-u-sm-9 am-u-end">
		<?php echo tpl_form_field_multi_image('multi-image',$info['g_thumb']?explode(",",$info['g_thumb']):"");?>
		<span class="color-9">推荐上传图片尺寸为750像素*510像素，居中（显示在详情页顶部轮播）</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">首图视频</label>
	<div class="am-u-sm-9 am-u-end">
		<?php echo tpl_form_field_video('g_video',$info['g_video']?$info['g_video']:'');?>
		<span class="color-9">设置后商品首图默认显示视频</span>
	</div>
</div>

<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>是否上架</label>
	<div class="am-u-sm-9 am-u-end">
		<label class="am-radio-inline am-success">
			<input type="radio" name="show" data-am-ucheck  value="1" <?php  if($info['g_is_online'] != -1) { ?>checked<?php  } ?>> 上架

		</label>
		<label class="am-radio-inline am-success" >
			<input type="radio" name="show" data-am-ucheck  value="-1" <?php  if($info['g_is_online'] == -1) { ?>checked<?php  } ?>> 下架
		</label>
		<!--<input type="radio" name="show"  value="1" <?php  if($info['g_is_online'] != -1) { ?>checked<?php  } ?>> 上架-->
		<!--<input type="radio" name="show"  value="-1" <?php  if($info['g_is_online'] == -1) { ?>checked<?php  } ?>> 下架-->
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>团长专享</label>
	<div class="am-u-sm-9 am-u-end">

		<label class="am-radio-inline am-success">
			<input type="radio" class="g_is_head_enjoy" name="g_is_head_enjoy" data-am-ucheck  value="1" <?php  if($info['g_is_head_enjoy'] != -1) { ?>checked<?php  } ?>> 是

		</label>
		<label class="am-radio-inline am-success" >
			<input type="radio" class="g_is_head_enjoy" name="g_is_head_enjoy" data-am-ucheck  value="-1" <?php  if($info['g_is_head_enjoy'] == -1) { ?>checked<?php  } ?>> 否
		</label>

	</div>
</div>
<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
<div class="am-u-sm-9 am-u-end color-9">
	选择是，则商品标签失效,只有团长才能看到此商品
</div>

<div class="am-form-group " >
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">商品标签</label>
	<div class="am-u-sm-9 am-u-end">
		<label  class="am-checkbox am-success checkbox_goods" >
			<input type="checkbox" name="recommand" data-am-ucheck value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?>  <?php  if(!empty($info) && $info['g_is_recommand'] != -1) { ?>checked<?php  } ?> > 推荐
		</label>
		<label  class="am-checkbox am-success checkbox_goods" >
			<input type="checkbox" name="g_is_new" data-am-ucheck  value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?> <?php  if(!empty($info) && $info['g_is_new'] != -1) { ?>checked<?php  } ?>> 新品
		</label>
		<label  class="am-checkbox am-success checkbox_goods" >
			<input type="checkbox" name="hot" data-am-ucheck  value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?> <?php  if(!empty($info) && $info['g_is_hot'] != -1) { ?>checked<?php  } ?>> 热门
		</label>
		<label  class="am-checkbox am-success checkbox_goods">
			<input type="checkbox" name="g_is_full_reduce" data-am-ucheck  value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?> <?php  if(!empty($info) && $info['g_is_full_reduce'] ==1) { ?>checked<?php  } ?>> 满减
		</label>

		<label  class="am-checkbox am-success checkbox_goods">
			<input type="checkbox" name="g_is_top" data-am-ucheck  value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?> <?php  if(!empty($info) && $info['g_is_top'] == 1) { ?>checked<?php  } ?>> 置顶
		</label>
		<label  class="am-checkbox am-success checkbox_goods" >
			<input type="checkbox" name="g_is_near_recommend" data-am-ucheck  value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?>  <?php  if(!empty($info) && $info['g_is_near_recommend'] ==1) { ?>checked<?php  } ?>> 邻居在买
		</label>
	</div>
</div>

<div class="am-form-group" >
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">商品标签</label>
	<div class="am-u-sm-9 am-u-end">
		<label  class="am-checkbox am-success checkbox_goods" >
			<input type="checkbox" name="recommand" data-am-ucheck value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?>  <?php  if(!empty($info) && $info['g_is_recommand'] != -1) { ?>checked<?php  } ?> > 推荐
		</label>
		<label  class="am-checkbox am-success checkbox_goods" >
			<input type="checkbox" name="g_is_new" data-am-ucheck  value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?> <?php  if(!empty($info) && $info['g_is_new'] != -1) { ?>checked<?php  } ?>> 新品
		</label>
		<label  class="am-checkbox am-success checkbox_goods" >
			<input type="checkbox" name="hot" data-am-ucheck  value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?> <?php  if(!empty($info) && $info['g_is_hot'] != -1) { ?>checked<?php  } ?>> 热门
		</label>
		<label  class="am-checkbox am-success checkbox_goods">
			<input type="checkbox" name="g_is_full_reduce" data-am-ucheck  value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?> <?php  if(!empty($info) && $info['g_is_full_reduce'] ==1) { ?>checked<?php  } ?>> 满减
		</label>

		<label  class="am-checkbox am-success checkbox_goods">
			<input type="checkbox" name="g_is_top" data-am-ucheck  value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?> <?php  if(!empty($info) && $info['g_is_top'] == 1) { ?>checked<?php  } ?>> 置顶
		</label>
		<label  class="am-checkbox am-success checkbox_goods" >
			<input type="checkbox" name="g_is_near_recommend" data-am-ucheck  value="1" class="head_enjoy_diy_box" <?php  if($info['g_is_head_enjoy'] != -1) { ?>disabled<?php  } ?>  <?php  if(!empty($info) && $info['g_is_near_recommend'] ==1) { ?>checked<?php  } ?>> 邻居在买
		</label>
	</div>
</div>
<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
<div class="am-u-sm-9 am-u-end color-9">
	（优先级高于活动设置）请输入整数
</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">到货时间自定义文本</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='g_arrival_time_text' value="<?php  echo $info['g_arrival_time_text'];?>" class='tpl-form-input' placeholder="可自定义前台显示的该商品提货时间显示"/>
		<span class="color-9">（优先级高于活动设置的）如果上面填写或选择天数后，此处对应填写，例：下单后次日到，预计到货或自提时间为</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>团长可得佣金比例（%）</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' id='g_commission' name='g_commission' value="<?php echo !empty($info['g_commission'])? (int) $info['g_commission']:'0'?>" class='tpl-form-input' />
		<span class="color-9">预计团长可得佣金￥<span id="g_commission_num" class="text-info">0</span>，将根据商品最终的成交价格来计算佣金,此处不设置或设置为0，将依据团长处设置的佣金计算</span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">虚拟购买人数</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='number' id='g_virtual_people' name='g_virtual_people' value="<?php echo $info['g_virtual_people']?$info['g_virtual_people']:0?>" class='tpl-form-input ' min="0"  />
		<span class="color-9">可用虚拟人数<?php echo empty($virtual_people_num)?0:$virtual_people_num;?>，建议请勿超过，更多人数请到<a class="text-danger" href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'fic_user','in'=>'index'))?>">【营销-虚拟用户】</a>去新增生成虚拟用户</span>
		<input type='hidden' name='old_g_virtual_people' value="<?php echo $info['g_virtual_people']?$info['g_virtual_people']:0?>" class='tpl-form-input'  />
	</div>

</div>

<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">随机生成购买份数</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='number' id='g_virtual_min_buy' name='g_virtual_min_buy' value="<?php echo $info['g_virtual_min_buy']?$info['g_virtual_min_buy']:1?>" class='tpl-form-input' min="1" style="width: 80px;display: inline-block;text-align: center;" />
		&nbsp;到&nbsp;
		<input type='number' id='g_virtual_max_buy' name='g_virtual_max_buy' value="<?php echo $info['g_virtual_max_buy']?$info['g_virtual_max_buy']:1?>" class='tpl-form-input' min="1"  style="width: 80px;display: inline-block;text-align: center;"/>
	</div>
</div>



<div class="am-form-group limit_time_class" <?php  if($info['g_is_sale_time']!=1) { ?>style="display: none;"<?php  } ?> >
	<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>限时时间</label>
	<div class="am-u-sm-9 am-u-end">
		<?php echo tpl_form_field_daterange('limit_time', array('start'=> empty($info['g_start_sale_time'])?'':date('Y-m-d H:i:s',$info['g_start_sale_time']),'end'=> empty($info['g_end_sale_time'])?'':date('Y-m-d H:i:s',$info['g_end_sale_time']) ),true);?>
	</div>
</div>



<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">运费设置</label>
	<div class="am-u-sm-9 am-u-end">
		<label class="am-checkbox am-success">
			<input type="radio" value="2" data-am-ucheck name="g_send_type" <?php echo $info['g_send_type']==2?"checked":"";?> <?php echo empty($express_shipping)?"disabled":"";?>> 运费模版
			<select class="tpl-form-input" name="g_express_shipping_id" style="display: inline-block;" >
				<option value=" "></option>
				<?php  if(is_array($express_shipping)) { foreach($express_shipping as $k => $v) { ?>
				<option value="<?php  echo $v['id'];?>" <?php echo $v['id']==$info['g_express_shipping_id']?"selected":"";?>><?php  echo $v['name'];?></option>
				<?php  } } ?>
			</select>
		</label>
		<label class="am-checkbox am-success">
			<input type="radio" value="1" data-am-ucheck name="g_send_type" <?php echo $info['g_send_type']!=2?"checked":"";?> > 统一运费
			￥<input type='number' name='g_send_price_sample' value="<?php echo empty($info['g_send_price_sample'])?'0.00':$info['g_send_price_sample'];?>" class='tpl-form-input' placeholder="" style="display: inline-block;"/>
		</label>
		<span class="color-9"></span>
	</div>
</div>
<div class="am-form-group">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">商品排序</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' id='order' name='order' value="<?php echo $info['g_order']?$info['g_order']:0?>" class='tpl-form-input'/>
	</div>
</div>


<div class="am-form-group" style="display: <?php echo empty($fraction)?'none':'block'?>;">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">商品赠送积分</label>
	<div class="am-u-sm-9 am-u-end">
		<input type='number' name='send_points' value="<?php  echo $info['send_points'];?>" class='tpl-form-input' placeholder="商品购买时送的积分"/>
		<span class="color-9">默认0为无积分，如果开启积分商城设置的“订单消费获得积分”这时积分获得规则优先执行积分商城设置</span>
	</div>
</div>