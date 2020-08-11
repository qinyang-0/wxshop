<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.btn-group .active {
	    background-color: #428bca;
	    color: #fff;
	}
	.input-group-btn {
		display: block !important;
	}
	#open_div{
		background-image: url(../web/resource/components/ueditor/themes/default/images/icons.png);
		height: 20px!important;
		width: 20px!important;
		background-position: -726px -77px;
		display: block;
		margin-top: 0.8rem;
	}
	.open_commodity_img{
		position: absolute;
		width: 200px;
		left: 18px;
		display: none;
	    z-index: 999;
	}
	.open_commodity_img:hover{
		display: block;
	}
	#open_div:hover+ .open_commodity_img{
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
					<form action="<?php  echo $this->createWebUrl('goods',array('op'=>'config'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">商品页面相关设置</div>
								</div>
								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label">更新商品分类 </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<a href="<?php  echo $this->createWebUrl('goods',array('op'=>'changeCateLink'))?>"><button class="btn-xs btn btn-info" type="button">更新</button></a>-->
										<!--<br/>-->
										<!--<span class="color-9">商品分类改版，更新后可以将原来的设置的分类保留下来</span>-->
									<!--</div>-->
								<!--</div>-->
								<?php  if(!empty($info)) { ?>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['goods_cate_show_type']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $info['goods_cate_show_type']['id'];?>" data-am-ucheck <?php echo $info['goods_cate_show_type']['value']!=2?"checked":''; ?>>
											全部商品
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $info['goods_cate_show_type']['id'];?>"  data-am-ucheck <?php echo $info['goods_cate_show_type']['value']==2?"checked":''; ?>>
											活动商品
										</label>
										<br/>
										<span class="color-9"></span>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['open_see_buypeople_info']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $info['open_see_buypeople_info']['id'];?>" data-am-ucheck <?php echo $info['open_see_buypeople_info']['value']!=2?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $info['open_see_buypeople_info']['id'];?>"  data-am-ucheck <?php echo $info['open_see_buypeople_info']['value']==2?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">商品详情页面能否点击进入购买记录页</span>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['goods_info_open_near']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $info['goods_info_open_near']['id'];?>" data-am-ucheck <?php echo $info['goods_info_open_near']['value']!=2?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $info['goods_info_open_near']['id'];?>"  data-am-ucheck <?php echo $info['goods_info_open_near']['value']==2?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">商品详情页是否显示邻居购买</span>
									</div>

									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['is_open_goods_video']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $info['is_open_goods_video']['id'];?>" data-am-ucheck <?php echo $info['is_open_goods_video']['value']!=2?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $info['is_open_goods_video']['id'];?>"  data-am-ucheck <?php echo $info['is_open_goods_video']['value']==2?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">是否开启首图视频显示</span>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['open_commodity']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<div style="float: left;">
											<label class="am-checkbox-inline am-success">
												<input type="radio"  value="1" name="<?php  echo $info['open_commodity']['id'];?>" data-am-ucheck <?php echo $info['open_commodity']['value']!=2?"checked":''; ?> data-img="../addons/group_buy/public/goods/y2.png" class="input_open">
												默认
											</label>
											<label class="am-checkbox-inline am-success">
												<input type="radio"  value="2" name="<?php  echo $info['open_commodity']['id'];?>"  data-am-ucheck <?php echo $info['open_commodity']['value']==2?"checked":''; ?> data-img="../addons/group_buy/public/goods/y1.png" class="input_open">
												样式1
											</label>
										</div>
										<div style="position: relative;float: left;margin-left: 1.2rem;">
											<span id="open_div"></span>
											<img src="<?php echo $info['open_commodity']['value']!=2 ? '../addons/group_buy/public/goods/y2.png' : '../addons/group_buy/public/goods/y1.png' ?>" id="open_commodity_img" class="open_commodity_img"/>
										</div>
										<div style="clear: both;"></div>
										<span class="color-9">商品分享样式</span>
									</div>
									
									
									
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['goods_info_share_bg']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<?php echo tpl_form_field_image($info['goods_info_share_bg']['id'],$info['goods_info_share_bg']['value']?$info['goods_info_share_bg']['value']:"");?>
										<span class="color-9">商品详情页微信分享的背景图</span>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['goods_info_playbill_bg']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<?php echo tpl_form_field_image($info['goods_info_playbill_bg']['id'],$info['goods_info_playbill_bg']['value']?$info['goods_info_playbill_bg']['value']:"");?>
										<span class="color-9">商品详情页海报分享的背景图</span>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['goods_info_sever_des']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<?php  echo tpl_ueditor($info['goods_info_sever_des']['id'],$info['goods_info_sever_des']['value']);?>
										<span class="color-9">商品详情页底部的服务说明</span>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['goods_info_action_price_bg']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<?php echo tpl_form_field_image($info['goods_info_action_price_bg']['id'],$info['goods_info_action_price_bg']['value']?$info['goods_info_action_price_bg']['value']:"");?>
										<span class="color-9">商品详情页轮播图下活动时间及价格展示后的背景图片</span>
									</div>

									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['goods_cate_open_search']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $info['goods_cate_open_search']['id'];?>" data-am-ucheck <?php echo $info['goods_cate_open_search']['value']!=2?"checked":''; ?>>
											开启分类页搜索
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $info['goods_cate_open_search']['id'];?>"  data-am-ucheck <?php echo $info['goods_cate_open_search']['value']==2?"checked":''; ?>>
											关闭分类页搜索
										</label>
										<br/>
										<span class="color-9">设置是否开启分类页搜索</span>
									</div>
									<div class="widget-head am-cf">
										<div class="widget-title am-fl">商品页面秒杀相关</div>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['goods_info_seckill_icon']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<?php echo tpl_form_field_image($info['goods_info_seckill_icon']['id'],$info['goods_info_seckill_icon']['value']?$info['goods_info_seckill_icon']['value']:"");?>
										<span class="color-9">商品页面秒杀图标</span>
									</div>
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['goods_info_seckill_price_bg']['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type="color"  value="<?php  echo $info['goods_info_seckill_price_bg']['value'];?>" name="<?php  echo $info['goods_info_seckill_price_bg']['id'];?>"  >
										<span class="color-9">商品详情页底部的服务说明</span>
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
    $('.input_open').change(function(res){
    	var img =$(this).data('img');
    	$('#open_commodity_img').attr('src',img);
    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>