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
					<form action="<?php  echo $this->createWebUrl('order',array('op'=>'order_set'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">订单基本设置</div>
								</div>
								<?php  if(!empty($info)) { ?>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">下单自动收货天数设置 </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='order_auto_get_goods_time' value="<?php  echo $info['value']['order_auto_get_goods_time'];?>" class='tpl-form-input am-fl' placeholder="例如:7" style="display: inline-block;" /><label class="am-u-sm-3 am-u-lg-3 am-form-label text-left" style="display: inline-block;">天后自动确认收货</label>
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">请输入整数天数，推荐设置7天,表示为发货后7天后自动确认收货，设置为0表示不开启自动收货</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $is_open_manger_sure_order['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $is_open_manger_sure_order['id'];?>" data-am-ucheck <?php echo $is_open_manger_sure_order['value']==1?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $is_open_manger_sure_order['id'];?>"  data-am-ucheck <?php echo $is_open_manger_sure_order['value']!=1?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">是否开启平台确认收货</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $is_open_header_sure_order['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $is_open_header_sure_order['id'];?>" data-am-ucheck <?php echo $is_open_header_sure_order['value']==1?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $is_open_header_sure_order['id'];?>"  data-am-ucheck <?php echo $is_open_header_sure_order['value']!=1?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">是否开启团长确认收货</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_over_cancle['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $order_over_cancle['id'];?>' value="<?php  echo $order_over_cancle['value'];?>" class='tpl-form-input am-fl' placeholder="例如:30" style="display: inline-block;" />
										<label class="am-u-sm-3 am-u-lg-3 am-form-label text-left" style="display: inline-block;">分钟后未支付取消订单</label>
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">下单后超过多少分钟后未支付取消订单</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $reduce_stock_type['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $reduce_stock_type['id'];?>" data-am-ucheck <?php echo $reduce_stock_type['value']!=2?"checked":''; ?>>
											确认支付后减少库存
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $reduce_stock_type['id'];?>"  data-am-ucheck <?php echo $reduce_stock_type['value']==2?"checked":''; ?>>
											下单减少库存
										</label>
										<br/>
										<span class="color-9">设置减少库存的方式（当选择下单减少库存时，推荐设置下单未支付取消订单时间为10分钟内，避免人恶意下单却不购买）</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_low_price_open['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $order_low_price_open['id'];?>" data-am-ucheck <?php echo $order_low_price_open['value']==1?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="0" name="<?php  echo $order_low_price_open['id'];?>"  data-am-ucheck <?php echo $order_low_price_open['value']!=1?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">开启后，下单金额满足设置的下限后才能支付</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_low_price['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										满<input type='number'  name='<?php  echo $order_low_price['id'];?>' value="<?php  echo $order_low_price['value'];?>" class='tpl-form-input ' placeholder="0" style="display: inline-block;width:200px;" />后才能下单
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">下单金额满足多少下限后才能支付</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $all_order_commission_open['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $all_order_commission_open['id'];?>" data-am-ucheck <?php echo $all_order_commission_open['value']==1?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $all_order_commission_open['id'];?>"  data-am-ucheck <?php echo $all_order_commission_open['value']!=1?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">是否开启全部订单统一佣金</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $all_order_commission_same['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $all_order_commission_same['id'];?>' value="<?php  echo $all_order_commission_same['value'];?>" class='tpl-form-input am-fl' placeholder="0" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'');return false;"/>元
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">全部订单统一佣金是多少</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_no_back_day['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										确认收货<input type='number'  name='<?php  echo $order_no_back_day['id'];?>' value="<?php  echo $order_no_back_day['value'];?>" class='tpl-form-input am-fl' placeholder="0" style="display: inline-block;width:200px;" />天后不再显示申请退款
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">确认收货多少天后不再显示申请退款</span>
									</div>
								</div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_info_recommed_goods_open['name'];?> </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-checkbox-inline am-success">
                                            <input type="radio"  value="1" name="<?php  echo $order_info_recommed_goods_open['id'];?>" data-am-ucheck <?php echo $order_info_recommed_goods_open['value']==1?"checked":''; ?>>
                                            开启
                                        </label>
                                        <label class="am-checkbox-inline am-success">
                                            <input type="radio"  value="2" name="<?php  echo $order_info_recommed_goods_open['id'];?>"  data-am-ucheck <?php echo $order_info_recommed_goods_open['value']!=1?"checked":''; ?>>
                                            关闭
                                        </label>
                                        <br/>
                                        <span class="color-9">是否显示订单详情页推荐商品</span>
                                    </div>
                                </div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_back_send_type['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $order_back_send_type['id'];?>" data-am-ucheck <?php echo $order_back_send_type['value']==1?"checked":''; ?>>
											订单列表直接确认发货
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $order_back_send_type['id'];?>"  data-am-ucheck <?php echo $order_back_send_type['value']!=1?"checked":''; ?>>
											订单列表先确认配送后发货
										</label>
										<br/>
										<span class="color-9">订单后台发货类型</span>
									</div>
								</div>

								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_only_send_print_open['name'];?> </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<label class="am-checkbox-inline am-success">-->
											<!--<input type="radio"  value="1" name="<?php  echo $order_only_send_print_open['id'];?>" data-am-ucheck <?php echo $order_only_send_print_open['value']!=2?"checked":''; ?>>-->
											<!--开启-->
										<!--</label>-->
										<!--<label class="am-checkbox-inline am-success">-->
											<!--<input type="radio"  value="2" name="<?php  echo $order_only_send_print_open['id'];?>"  data-am-ucheck <?php echo $order_only_send_print_open['value']==2?"checked":''; ?>>-->
											<!--关闭-->
										<!--</label>-->
										<!--<br/>-->
										<!--<span class="color-9">订单后台发货类型</span>-->
									<!--</div>-->
								<!--</div>-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">订单打印相关设置</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_print_auto_open['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $order_print_auto_open['id'];?>" data-am-ucheck <?php echo $order_print_auto_open['value']==1?"checked":''; ?>>
											开启
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $order_print_auto_open['id'];?>"  data-am-ucheck <?php echo $order_print_auto_open['value']!=1?"checked":''; ?>>
											关闭
										</label>
										<br/>
										<span class="color-9">是否开启订单自动打印（确认支付后打印订单）</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_print_auto_num['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='number'  name='<?php  echo $order_print_auto_num['id'];?>' value="<?php  echo $order_print_auto_num['value'];?>" class='tpl-form-input' placeholder="1"/>
										<span class="color-9">订单自动打印份数</span>
									</div>
								</div>
								<div class="widget-head am-cf">
									<div class="widget-title am-fl">下单通知消息相关</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">出货单名称</label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $head_title_note['id'];?>' value="<?php  echo $head_title_note['value'];?>" class='tpl-form-input am-fl' placeholder="例如:    小贝壳生鲜社区团购出货单！！！" style="display: inline-block;" />
									</div>
								</div>

								<div class="am-form-group">
									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label">出货单备注</label>
										<input type='text'   name="<?php  echo $head_note['id'];?>" value="<?php  echo $head_note['value'];?>" >
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_notice_click['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $order_notice_click['id'];?>" data-am-ucheck <?php echo $order_notice_click['value']!=2?"checked":''; ?>>
											点击页面按钮触发
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $order_notice_click['id'];?>"  data-am-ucheck <?php echo $order_notice_click['value']==2?"checked":''; ?>>
											点击弹窗提示按钮触发
										</label>
										<br/>
										<span class="color-9">设置下单通知团长的接单触发方式</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_sharing_style['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $order_sharing_style['id'];?>" data-am-ucheck <?php echo $order_sharing_style['value']!=2?"checked":''; ?>>
											默认分享
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $order_sharing_style['id'];?>" data-am-ucheck <?php echo $order_sharing_style['value']==2?"checked":''; ?>>
											图片
										</label>
										<br>
										<!--<span class="color-9">首页分享出去的图片类型</span>-->
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_sharing_style_show['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $order_sharing_style_show['id'];?>" data-am-ucheck <?php echo $order_sharing_style_show['value']!=2?"checked":''; ?>>
											是
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $order_sharing_style_show['id'];?>" data-am-ucheck <?php echo $order_sharing_style_show['value']==2?"checked":''; ?>>
											否
										</label>
										<br>
										<!--<span class="color-9">首页分享出去的图片类型</span>-->
									</div>
								</div>
								
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_notice_title['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $order_notice_title['id'];?>' value="<?php  echo $order_notice_title['value'];?>" class='tpl-form-input am-fl' placeholder="例如:我已下单，请接单！！！" style="display: inline-block;" />
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">下单通知团长文本提示，例如:我已下单，请接单！！！</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_notice_img_type['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="1" name="<?php  echo $order_notice_img_type['id'];?>" data-am-ucheck <?php echo $order_notice_img_type['value']!=2?"checked":''; ?>>
											使用下单的商品图
										</label>
										<label class="am-checkbox-inline am-success">
											<input type="radio"  value="2" name="<?php  echo $order_notice_img_type['id'];?>"  data-am-ucheck <?php echo $order_notice_img_type['value']==2?"checked":''; ?>>
											使用下面上传的图
										</label>
										<br/>
										<span class="color-9">设置下单通知团长的分享出去的图片</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_notice_img['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<?php echo tpl_form_field_image($order_notice_img['id'],$order_notice_img['value']?$order_notice_img['value']:"");?>
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">下单通知团长分享图片</span>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $order_notice_comment['name'];?> </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='<?php  echo $order_notice_comment['id'];?>' value="<?php  echo $order_notice_comment['value'];?>" class='tpl-form-input am-fl' placeholder="例如:点击 通知老板接单 按钮，将提醒消息发送到微信群，提醒老板及时处理您的订单" style="display: inline-block;" />
									</div>

									<div class="am-u-sm-12 am-u-end">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"></label>
										<span class="color-9">通知老板接单 按钮的使用说明；如：点击 通知老板接单 按钮，将提醒消息发送到微信群，提醒老板及时处理您的订单</span>
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

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>