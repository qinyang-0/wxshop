<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<style>
		/*微擎底层时间插件样式*/
	.daterangepicker select.ampmselect, .daterangepicker select.hourselect, .daterangepicker select.minuteselect{
		width: auto;
		padding-right: 40px;
	}
</style>
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">售后订单 订单数<span class="text-danger"> <?php  echo $total;?> </span> 退款总金额 <span class="text-danger"> ￥<?php  echo $back_money['sums'];?> </span> </div>
					</div>

					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="order">
								<input type="hidden" value="afterSale" name="op">
								<div class="am-u-sm-12 ">
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 90px;">
										<select name="key_field" data-am-selected="{searchBox: 1, btnSize: 'sm',placeholder:'请选择查询的关键词', maxHeight: 400}" style="display: none;">
											<option value="order_num" <?php  if($_GPC['key_field'] =='order_num') { ?>selected<?php  } ?>>订单号</option>
											<option value="action_name" <?php  if($_GPC['key_field'] =='action_name') { ?>selected<?php  } ?>>活动信息</option>
											<option value="vg_name" <?php  if($_GPC['key_field'] =='vg_name') { ?>selected<?php  } ?>>小区信息</option>
											<option value="header" <?php  if($_GPC['key_field'] =='header') { ?>selected<?php  } ?>>团长信息</option>
											<option value="buyer" <?php  if($_GPC['key_field'] =='buyer') { ?>selected<?php  } ?>>买家信息</option>
											<option value="receiver" <?php  if($_GPC['key_field'] =='receiver') { ?>selected<?php  } ?>>收货人信息</option>
										</select>

											</div>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" >
										<input class="am-form-field" name="key" type="text" value="<?php  echo $_GPC['key'];?>" placeholder="请输入关键词">
									</div>

										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 130px;">
											<select name="send_type" data-am-selected="{searchBox: 1, btnSize: 'sm',placeholder:'请选择配送方式', maxHeight: 400}" style="display: none;">
												<option value=" ">请选择配送方式</option>
												<option value="1" <?php  if($_GPC['send_type'] ==1) { ?>selected<?php  } ?>>自取</option>
												<option value="2" <?php  if($_GPC['send_type'] ==2) { ?>selected<?php  } ?>>团长送货</option>
											</select>
										</div>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 130px;">
										<select name="time_type" data-am-selected="{searchBox: 1, btnSize: 'sm',placeholder:'不按时间查询', maxHeight: 400}" style="display: none;">
											<option value=" ">不按时间查询</option>
											<option value="apply_back" <?php  if($_GPC['time_type'] =='apply_back') { ?>selected<?php  } ?>>申请退款时间</option>
											<option value="add_time" <?php  if($_GPC['time_type'] =='add_time') { ?>selected<?php  } ?>>下单时间</option>
											<option value="pay_time" <?php  if($_GPC['time_type'] =='pay_time') { ?>selected<?php  } ?>>支付时间</option>
											<option value="send_time" <?php  if($_GPC['time_type'] =='send_time') { ?>selected<?php  } ?>>发货时间</option>
										</select>
									</div>
										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 265px">
											<?php echo tpl_form_field_daterange('time', array('start'=> empty($_GPC['time']['start'])?date('Y-m-d',(time()-31*24*60*60)):$_GPC['time']['start'],'end'=> empty($_GPC['time']['end'])?date('Y-m-d',time()):$_GPC['time']['end']),true);?>
										</div>
										<div class="zx-but-check">
											<button type="submit" >
												<i class="fa fa-search"></i> 查询
											</button>
										</div>
								</div>



								<!-- 订单导出外层Box -->
								<div class="am-u-sm-12 am-fl">
									<!-- 查询按钮样式 -->
									<!--<div class="zx-but-check" style="height: 34px;vertical-align: middle;">-->
										<!--<button type="submit" >-->
											<!--<i class="fa fa-search"></i> 查询-->
										<!--</button>-->
									<!--</div>-->
									<!--<div class="am-btn-group am-btn-group-xs zx-end-checked-box" >-->
										<!--<button class="btn btn-success" id="out-select-res" type="submit" name="select-res" value="select-res">导出查询结果</button>&nbsp;&nbsp;&nbsp;-->
									<!--</div>-->
									<div class="am-btn-group am-btn-group-xs zx-end-checked-box" style="margin-left: .5rem;">
											<span class="btn btn-info" id="out-check" >导出勾选订单</span>&nbsp;&nbsp;&nbsp;
									</div>
									<div class="am-btn-group am-btn-group-xs">
										<button type="submit" class="btn btn-warning" id="out-all-check" name="out-all-check" value="1">导出全部查询订单</button>
									</div>

								</div>
							</form>


						</div>
						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap ">
								<thead class="navbar-inner">
								<tr>
									<th >
										<label class="am-checkbox-inline am-success">
											<input type="checkbox"  id="check-all" data-am-ucheck data-id="0">&nbsp;
										</label>
									</th>
									<th width="360">商品</th>
									<th>小区/团长/活动</th>
									<th>支付/配送</th>
									<!--<th style="width:80px;">售后</th>-->
									<th>价格(￥)</th>
									<th>买家</th>
									<th>申请时间</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
								<tr style="background-color: #f4f6f9;">

									<td colspan="999">
										<b class="muted" style="color:#333;"><?php  echo date('Y-m-d H:i:s',$item['go_add_time'])?></b>
										<span class="fa fa-link fa-rotate-90"></span> &nbsp;订单号：<a href="<?php  echo $this->createWebUrl('order',array('op'=>'afterSale','key'=>$item['go_code'],'key_field'=>'order_num'))?>" class="text-info"><?php  echo $item['go_code'];?></a>
									</td>
								</tr>
								<tr >
									<td class="am-text-middle">
										<label class="am-checkbox-inline am-success">
											<input type="checkbox" data-id="<?php  echo $item['go_id'];?>"  data-am-ucheck class="check-order">&nbsp;
										</label>
									</td>
									<td  class="am-text-middle" style="display: flex;align-items: center;">
										<div class="goods-des" style="width:350px;text-align: left">

											<div style="display: -webkit-box;display: -webkit-flex;display: -ms-flexbox;display: flex;margin: 10px 0">
												<img src="<?php  echo tomedia($item['oss_g_icon'])?>" style="width:70px;height:70px;border:1px solid #efefef; padding:1px;">
												<div style="-webkit-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;margin-left: 10px;text-align: left;display: flex;align-items: center">
													<div>
														<div class="title" style="width: 180px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
															<?php  echo $item['oss_g_name'];?><br>
															<span style="color: #999;width: 180px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php  echo $item['oss_g_brief'];?></span>

														</div>
														<!--<div style="display:none;">-->
															<!--<span class="label label-danger">商品标签，先隐藏</span>-->
															<!--<span class="label label-primary">未来可以用</span>-->
														<!--</div>-->
													</div>
													<span style="float: right;text-align: right;display: inline-block;width:80px;">
														￥<?php  echo $item['oss_g_price'];?><br>
														x<?php  echo $item['oss_g_num'];?>
													</span>
												</div>
											</div>
										</div>


									</td>
									<td class="am-text-middle">
										小区：<a href="<?php  echo $this->createWebUrl('order',array('op'=>'afterSale','key'=>$item['oss_v_name'],'key_field'=>'vg_name'))?>" class="text-info"><?php  echo $item['oss_v_name'];?></a>
										<br>
										团长：<a href="<?php  echo $this->createWebUrl('order',array('op'=>'afterSale','key'=>$item['oss_head_name'],'key_field'=>'header'))?>" class="text-info"><?php  echo $item['oss_head_name'];?></a>
										<br>
										电话：<span class="text-info"><?php  echo $item['oss_head_phone'];?></span>
									</td>
									<td class="am-text-middle">

											<?php  if($item['go_status']>10 && $item['go_pay_type']==1) { ?>
											<span> <i class="fa fa-weixin" style="font-size: 14px;color: #54c952;"></i><span>微信支付</span></span>
											<br/>
											<?php  } else { ?>
											待付款
											<br/>
											<?php  } ?>

											<span class="text-danger"><?php echo $item['go_send_type']==1?'(自提)':'';?><?php echo $item['go_send_type']==2?'(团长送货)':'';?><?php echo $item['go_send_type']==3?'(快递)':'';?></span>
									</td>
									<td class="am-text-middle">
										<span style="margin-top:5px;margin-left:5px;display:block;">订单运费：+<span class="text-info">￥<?php  echo $item['go_send_pay'];?></span>
										</span>
										<span style="margin-top:5px;margin-left:5px;display:block;">订单优惠：-<span class="text-warning">￥<?php  echo $item['go_fdc_price'];?></span>
										</span>
										<span style="margin-top:5px;margin-left:5px;display:block;">商品小计：
											<span class="text-danger">￥<?php  echo sprintf('%01.2f',($item['oss_g_price']*$item['oss_g_num']));?></span>
										</span>
										<span style="margin-top:5px;margin-left:5px;display:block;">退款金额：
											<span class="text-danger">￥<?php  echo $item['gbm_money'];?></span>
										</span>
									<td class="am-text-middle"><a href="<?php  echo $this->createWebUrl('order',array('op'=>'afterSale','buy_people'=>$item['oss_buy_name']))?>" class="text-info"><?php  echo $item['oss_buy_name'];?></a>
										<br><?php  echo $item['oss_buy_phone'];?>
									</td>
									<td class="am-text-middle"><?php  echo date("Y-m-d H:i:s",$item['gbm_add_time'])?></td>
									<td class="am-text-middle">
										<?php  if($item['gbm_status'] == 10) { ?>
										<span class="text-danger">申请退款中</span>
										<?php  } else if($item['gbm_status'] == 20) { ?>
										<span class="text-info">已退款</span>
										<?php  } else if($item['gbm_status'] == 30) { ?>
										<span class="text-warning">拒绝</span>
										<?php  } else if($item['gbm_status'] == 40) { ?>
										<span class="text-warning">退款失败，请手动退款</span>
										<?php  } ?>
									</td>
									<td class="am-text-middle">
										<?php  if($item['gbm_status'] == 10) { ?>
										<a data-href="<?php  echo $this->createWebUrl('finance',array('op'=>'sure_back_money','id'=>$item['gbm_id'],'act'=>'afterSale'))?>" onclick="bts(this)" href="javascript:;" class="btn btn-warning btn-xs">同意</a>
										<a href="<?php  echo $this->createWebUrl('finance',array('op'=>'backSayNo','id'=>$item['gbm_id'],'act'=>'afterSale'))?>"  class="btn btn-danger btn-xs">拒绝</a>
										<a href="<?php  echo $this->createWebUrl('finance',array('op'=>'the_line_bank','id'=>$item['gbm_id']))?>"  class="btn btn-warning btn-xs">线下退款</a>
										<?php  } else if($item['gbm_status'] == 40) { ?>
										<a class="btn btn-danger btn-xs" onclick="downBackMoney(<?php  echo $item['gbm_id'];?>);return false;">已手动退款</a>
										<?php  } ?>

										<a href="<?php  echo $this->createWebUrl('finance',array('op'=>'seeBackInfo','id'=>$item['gbm_id']))?>"  class="btn btn-info btn-xs">退款详情</a>
										<a href="<?php  echo $this->createWebUrl('order',array('op'=>'add','id'=>$item['gbm_go_code']))?>"  class="btn btn-success btn-xs">订单详情</a>

									</td>
								</tr>
								<?php  } } ?>
								<?php  } else { ?>
								<tr>
									<td colspan="3">
										没有数据
									</td>
								</tr>
								<?php  } ?>
								</tbody>
							</table>
						</div>
						<div class="am-u-lg-12 am-cf" style="text-align: right;">
							<?php  echo $page;?>
							<div class="am-fr pagination-total am-margin-right">
								<div class="am-vertical-align-middle">总记录：<?php  echo $total;?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">

    //勾选本页全部
	$(document).on("click","#check-all",function () {
        if($(this).is(':checked')){
			$(".check-order").prop("checked",true);
		}else{
            $(".check-order").prop("checked",false);
		}
    });
	//导出勾选
    $(document).on("click","#out-check",function () {
        var id = '';
        $(".check-order:checked").each(function () {
            id +=$(this).attr("data-id")+',';
        });
        if(id ==''){
            layer.msg("未选择数据");
            return false;
		}
		window.location.href="<?php  echo $this->createWebUrl('order',array('op'=>'outXlsx'))?>&id="+id;
	});
	//downBackMoney手动线下退款
	function downBackMoney(id) {
		var  id = id ;
        layer.confirm('您确定已线下手动退款了？',{icon: 3, title:'提示'},function (index) {
            $.post("<?php  echo $this->createWebUrl('finance',array('op'=>'downBackMoney'))?>",{id:id},function(res){
                layer.close(index);
                if(res.status == 0){
                    location.reload();
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
        })
    }
	function bts(obj){
		var href = $(obj).data('href');
		layer.confirm('是否确定退款?', {icon: 1, title:'提示'}, function(index){
			layer.closeAll();
			layer.load(3, {shade: [0.8, '#393D49']});
			window.location.href = href;
		});
		return false;
	}
	
</script>
