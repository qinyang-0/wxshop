<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<style>
	.am-tabs-d2 .am-tabs-nav{
		background: #fff;
		border-bottom: 1px solid #eef1f5;
	}
	.am-tabs-nav{
		display: flex;
		align-items: center;
		justify-content: flex-start;
	}
	.am-tabs .am-tabs-nav li{
		width: 120px;
		line-height: 40px;
		height: 40px;
		padding: 0;
	}
	.am-tabs .am-tabs-nav li a{
		width: 120px;
		line-height: 40px;
		height: 40px;
		padding: 0;
		 display: block;
		margin: 0;
		text-align: center;
		background: #fff;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active {
		position: relative;
		background-color: #fcfcfc;
		border-bottom: 2px solid #22c397;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active a{
		color: #22c397;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active:after{
		border-bottom-color: #22c397;
	}
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
						<div class="widget-title am-cf">订单列表 订单数<span class="text-danger"> <?php  echo $total;?> </span> 订单金额 <span class="text-danger"> ￥<?php  echo $now_money;?> </span> </div>
					</div>
					<div  class="am-tabs am-tabs-d2">
						<ul class="am-tabs-nav am-cf">
							<li class="<?php  if(empty($_GPC['status'])) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('order',array('op'=>'index'))?>">全部<?php  if(isset($status['0']) ) { ?> ( <?php  echo $status['0'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==10) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','status'=>10))?>">待付款<?php  if(isset($status['10']) ) { ?> ( <?php  echo $status['10'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==20) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','status'=>20))?>">待发货<?php  if(isset($status['20']) ) { ?> ( <?php  echo $status['20'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==30) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','status'=>30))?>">待收货<?php  if(isset($status['30']) ) { ?> ( <?php  echo $status['30'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==100) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','status'=>100))?>">已完成<?php  if(isset($status['100']) ) { ?> ( <?php  echo $status['100'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==110) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','status'=>110))?>">已取消<?php  if(isset($status['110']) ) { ?> ( <?php  echo $status['110'];?> ) <?php  } ?></a></li>
							<!--<li class="<?php  if($_GPC['status']==30) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','status'=>30))?>">已退款<?php  if(isset($status['30']) ) { ?> ( <?php  echo $status['30'];?> ) <?php  } ?></a></li>-->
							<li class="<?php  if($_GPC['status']==120) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','status'=>120))?>">已关闭<?php  if(isset($status['120']) ) { ?> ( <?php  echo $status['120'];?> ) <?php  } ?></a></li>
						</ul>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="order">
								<input type="hidden" value="<?php  echo $_GPC['status'];?>" name="status">
								<div class="am-u-sm-12 ">
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 90px;">
										<select name="key_field" data-am-selected="{searchBox: 1, btnSize: 'sm',placeholder:'请选择查询的关键词', maxHeight: 400}" style="display: none;">
											<option value="order_num" <?php  if($_GPC['key_field'] =='order_num') { ?>selected<?php  } ?>>订单号</option>
											<option value="action_name" <?php  if($_GPC['key_field'] =='action_name') { ?>selected<?php  } ?>>活动信息</option>
											<option value="vg_name" <?php  if($_GPC['key_field'] =='vg_name') { ?>selected<?php  } ?>>小区信息</option>
											<option value="header" <?php  if($_GPC['key_field'] =='header') { ?>selected<?php  } ?>>团长信息</option>
											<option value="buyer" <?php  if($_GPC['key_field'] =='buyer') { ?>selected<?php  } ?>>买家信息</option>
											<option value="receiver" <?php  if($_GPC['key_field'] =='receiver') { ?>selected<?php  } ?>>收货人信息</option>
											<option value="g_name" <?php  if($_GPC['key_field'] =='g_name') { ?>selected<?php  } ?>>商品名称</option>
											<option value="sekill" <?php  if($_GPC['key_field'] =='sekill') { ?>selected<?php  } ?>>秒杀订单</option>
											<option value="bargain" <?php  if($_GPC['key_field'] =='bargain') { ?>selected<?php  } ?>>砍价订单</option>
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
												<option value="3" <?php  if($_GPC['send_type'] ==3) { ?>selected<?php  } ?>>快递</option>
											</select>
										</div>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 130px;">
										<select name="time_type" data-am-selected="{searchBox: 1, btnSize: 'sm',placeholder:'', maxHeight: 400}" style="display: none;">
											<option value=" ">不按时间查询</option>
											<option value="add_time" <?php  if($_GPC['time_type'] =='add_time') { ?>selected<?php  } ?>>下单时间</option>
											<option value="pay_time" <?php  if($_GPC['time_type'] =='pay_time') { ?>selected<?php  } ?>>支付时间</option>
											<option value="send_time" <?php  if($_GPC['time_type'] =='send_time') { ?>selected<?php  } ?>>发货时间</option>
										</select>
									</div>
										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 265px">
											<?php echo tpl_form_field_daterange('time', array('start'=> empty($_GPC['time']['start'])?date('Y-m-d',(time()-1*24*60*60)):$_GPC['time']['start'],'end'=> empty($_GPC['time']['end'])?date('Y-m-d',time()):$_GPC['time']['end']),true);?>
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
									<div class="am-btn-group am-btn-group-xs">
										<a href="javascript:;" class="btn btn-warning" id="outputorder" name="outputorder" value="1">导出全部查询订单详情</a>
									</div>
									<script>
										$("#outputorder").click(function(){
										    $("input[name='do']").val("outputorder");
										    $("form").submit();
                                            $("input[name='do']").val("order");
										});
									</script>
									<?php  if($_GPC['status']==20 && $order_back_send_type ==1) { ?>
									<div class="am-btn-group am-btn-group-xs zx-end-checked-box" style="margin-left: .5rem;">
										<span class="btn btn-success" id="batch-send" >批量发货</span>&nbsp;&nbsp;&nbsp;
									</div>
                                    <div class="am-btn-group am-btn-group-xs zx-end-checked-box" style="margin-left: .5rem;">
                                        <span class="btn btn-warning" id="all-send" >全部发货</span>&nbsp;&nbsp;&nbsp;
                                    </div>
                                    <?php  } else if($_GPC['status']==20 && $order_back_send_type ==2) { ?>
                                    <div class="am-btn-group am-btn-group-xs zx-end-checked-box" style="margin-left: .5rem;">
                                        <span class="btn btn-warning" id="batch-distribution" >勾选批量配送</span>&nbsp;&nbsp;&nbsp;
                                    </div>
                                    <div class="am-btn-group am-btn-group-xs zx-end-checked-box" style="margin-left: .5rem;">
                                        <span class="btn btn-success" id="all-distribution" >全部配送</span>&nbsp;&nbsp;&nbsp;
                                    </div>
									
									<?php  } ?>
									<?php  if($_GPC['status']==20) { ?>
										<div class="am-btn-group am-btn-group-xs zx-end-checked-box" >
											<button type="submit" class="btn btn-success" id="batch-send-goods" name="batch-send-goods" value="3">团长出货单</button>&nbsp;
										</div>
										
										<div class="am-btn-group am-btn-group-xs zx-end-checked-box" >
											<button type="submit" class="btn btn-info" id="out_purchase-goods" name="out_purchase-goods" value="4">平台采购单</button>&nbsp;
										</div>
									<?php  } ?>
									<?php  if($_GPC['status']==30 && $is_open_manger_sure_order==1) { ?>
									
									<div class="am-btn-group am-btn-group-xs zx-end-checked-box" >
										<button type="button" class="btn btn-info" id="batch-sure-order">批量确认全部收货</button>&nbsp;
									</div>
									<div class="am-btn-group am-btn-group-xs zx-end-checked-box" >
										<button type="button" class="btn btn-success" id="page-sure-order">本页确认全部收货</button>&nbsp;
									</div>
									
									<div class="am-btn-group am-btn-group-xs zx-end-checked-box" >
										<button type="button" class="btn btn-info" id="all-sure-order">确认全部收货</button>&nbsp;
									</div>
									
									<?php  } ?>						
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
										<!--<input type="checkbox" id="check-all" data-id="0">-->
									</th>
									<th width="360">商品</th>
									<th>小区/团长/活动</th>
									<th>支付/配送</th>
									<!--<th style="width:80px;">售后</th>-->
									<th>价格(￥)</th>
									<th>买家/收货人</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
								<tr style="background-color: #f4f6f9;">

									<td colspan="7">
										<b class="muted" style="color:#333;"><?php  echo date('Y-m-d H:i:s',$item['go_add_time'])?></b>
										<span class="fa fa-link fa-rotate-90"></span> &nbsp;订单号：<a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','key'=>$item['go_code'],'key_field'=>'order_num'))?>" class="text-info"><?php  echo $item['go_code'];?></a>
										<?php  if($item['oss_is_seckill']==1) { ?>
											<span>【秒杀】</span>
										<?php  } else if($item['oss_is_seckill'] == 2) { ?>
											<span>【砍价】</span>
										<?php  } else if($item['oss_is_seckill'] == 3) { ?>
										<span>【拼团】</span>
										<?php  } ?>
									</td>
									<td style="text-align: center;">
										<a href="javascript:;" data-content="<?php  echo $item['remarks_content'];?>" <?php  if($item['remarks_content']) { ?>style="color: red;"<?php  } ?> onclick="content(this,<?php  echo $item['go_id'];?>)">
											<i class="fa fa-flag-checkered" style="display: inline-block;vertical-align: middle" title="查看备注"></i>
											备注
										</a>
									</td>
								</tr>
								<tr >
									<td class="am-text-middle">
										<label class="am-checkbox-inline am-success">
											<input type="checkbox" data-id="<?php  echo $item['go_id'];?>" data-code="<?php  echo $item['go_code'];?>" data-send-type="<?php  echo $item['go_send_type'];?>"  data-am-ucheck class="check-order">&nbsp;
										</label>
										<!--<input type="checkbox" data-id="<?php  echo $item['go_id'];?>" class="check-order">-->
									</td>
									<td  class="am-text-middle" style="display: flex;align-items: center;">
										<div class="goods-des" style="width:350px;text-align: left">
										<?php 
											$gname = explode('||',$item['gname']);
											$gicon = explode('||',$item['gicon']);
											$gprice = explode('||',$item['gprice']);
											$gnum = explode('||',$item['gnum']);
											$gbrief = explode('||',$item['gbrief']);
											$ggotitle= explode('||',$item['ggotitle']);
											foreach($gname as $k=>$v){
										?>
											<div style="display: -webkit-box;display: -webkit-flex;display: -ms-flexbox;display: flex;margin: 10px 0">
												<img src="<?php  echo tomedia($gicon[$k])?>" style="width:70px;height:70px;border:1px solid #efefef; padding:1px;">
												<div style="-webkit-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;margin-left: 10px;text-align: left;display: flex;align-items: center">
													<div>
														<div class="title" style="width: 180px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
															<?php  echo $v;?><br>
															<span style="color: #999;width: 180px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php  echo $gbrief[$k];?></span>

														</div>
														<?php  if(!empty($ggotitle[$k])) { ?>
														<div style="width: 180px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
															<span class="text text-danger">规格:<?php  echo $ggotitle[$k];?></span>
															<!--<span class="label label-primary">未来可以用</span>-->
														</div>
														<?php  } ?>
													</div>
													<span style="float: right;text-align: right;display: inline-block;width:80px;">
														￥<?php  echo $gprice[$k];?><br>
														x<?php  echo $gnum[$k];?>
													</span>
												</div>
											</div>
										<?php  }?>
										</div>
										<!--<a href="<?php  echo tomedia($item['oss_g_icon'])?>" target="_blank"><img src="<?php  echo tomedia($item['oss_g_icon'])?>" width="50" style="display: block;width: 50px;height: 50px;margin-right: 5px;"/></a>-->
										<!--&lt;!&ndash;<img src="/attachment/<?php  echo $item['oss_g_icon'];?>"  style="display: block;width: 50px;height: 50px;margin-right: 5px;"/>&ndash;&gt;-->
										<!--<div>-->
											<!--<a href="javascript:;" class="text-info"><?php echo strlen($item['oss_g_name'])>15?mb_substr($item['oss_g_name'],0,9,'utf-8')."...":$item['oss_g_name']?></a>-->
											<!--<br>-->
											<!--活动：<a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','action'=>$item['oss_ac_name']))?>" class="text-info"><?php  echo $item['oss_ac_name'];?></a>-->
											<!--<br>-->


										<!--</div>-->

									</td>
									<td class="am-text-middle">
										小区：<a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','key'=>$item['oss_v_name'],'key_field'=>'vg_name'))?>" class="text-info"><?php  echo $item['oss_v_name'];?></a>
										<br>
										团长：<a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','key'=>$item['oss_head_name'],'key_field'=>'header'))?>" class="text-info"><?php  echo $item['oss_head_name'];?></a>
										<br>
										电话：<span class="text-info"><?php  echo $item['oss_head_phone'];?></span>
									</td>
									<td class="am-text-middle">

											<?php  if($item['go_status']>10 && $item['go_pay_type']==1) { ?>
											<span> <i class="fa fa-weixin" style="font-size: 14px;color: #54c952;"></i><span>微信支付</span></span>

											<?php  } else if($item['go_status']>10 && $item['go_pay_type']==2) { ?>
										<span> <span>余额支付</span></span>
										<?php  } else if($item['go_status']>10 && $item['go_pay_type']==3) { ?>
										<span> <span>余额支付+微信支付</span></span>
											<?php  } else { ?>
											待付款
											<?php  } ?>
										<?php  if($item['go_status']>10 && $item['go_release_price']>0) { ?>
											(含返利金)
										<?php  } ?>
										<br/>
											<span class="text-danger"><?php echo $item['go_send_type']==1?'(自提)':'';?><?php echo $item['go_send_type']==2?'(团长送货)':'';?><?php echo $item['go_send_type']==3?'(快递)':'';?></span>
									</td>
									<td class="am-text-middle">
										<span style="margin-top:5px;margin-left:5px;display:block;">运&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;费：+<span class="text-info">￥<?php  echo $item['go_send_pay'];?></span>
										</span>
										<span style="margin-top:5px;margin-left:5px;display:block;">优&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;惠：-<span class="text-warning">￥<?php  echo $item['go_fdc_price'];?></span>
										</span>
										<!--<span style="margin-top:5px;margin-left:5px;display:block;">商品小计：-->
											<!--<span class="text-danger">￥<?php  echo sprintf('%01.2f',$item['go_all_price'])?></span>-->
										<!--</span>-->
										<span style="margin-top:5px;margin-left:5px;display:block;">应收总款：
											<span class="text-danger">￥<?php  echo $item['go_real_price'];?></span>
										</span>
									<td class="am-text-middle">
										<a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','key'=>$item['oss_buy_name'],'key_field'=>'buyer'))?>" class="text-info"><?php  echo $item['oss_buy_name'];?></a>
										<br><?php echo empty($item['oss_buy_phone'])?$item['oss_address_phone']:$item['oss_buy_phone']; ?>
										/
										<br>
										<a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','key'=>$item['oss_buy_name'],'key_field'=>'buyer'))?>" class="text-info"><?php  echo $item['oss_address_name'];?></a>
										<br>
										<?php  echo $item['oss_address_phone'];?>
									</td>
									<td class="am-text-middle">
										<?php  $go_status =$this->orderStatus($item['go_status']);?>
										<?php  if($go_status=='待取货') { ?>
										<span class="text-danger"><?php  echo $go_status;?></span>
										<?php  } else if($go_status=='备货中') { ?>
										<span class="text-success"><?php  echo $go_status;?></span>
										<?php  } else { ?>
										<span class=""><?php  echo $go_status;?></span>
										<?php  } ?>
										<?php  if($item['go_status'] == 25) { ?>
										<span class="">等待生成配送清单中</span>
										<?php  } else if($item['go_status'] == 28) { ?>
										<span class="">已生成清单，等待发货</span>
										<?php  } ?>
									</td>
									<td class="am-text-middle">
										<a href="<?php  echo $this->createWebUrl('order',array('op'=>'add','id'=>$item['go_code']))?>"  class="btn btn-success btn-xs">详情</a>
										<?php  if($item['go_status'] == 20) { ?>
											<?php  if($item['go_send_type'] == 3) { ?>
											<a  onclick="shipSend('<?php  echo $item['go_code'];?>')"  class="btn btn-info btn-xs">快递发货</a>
											<?php  } else { ?>
												<?php  if($order_back_send_type ==1) { ?>
												<a  onclick="setStatus('<?php  echo $item['go_code'];?>',30)"  class="btn btn-info btn-xs">发货</a>
												<?php  } else if($order_back_send_type ==2) { ?>
												<a  onclick="setStatus('<?php  echo $item['go_code'];?>',25)"  class="btn btn-info btn-xs">配送</a>
												<?php  } ?>
											<?php  } ?>
										<?php  } else if($item['go_status'] == 25) { ?>
										<!--<a  onclick="setStatus('<?php  echo $item['go_code'];?>',30)"  class="btn btn-info btn-xs">发货</a>-->
										<span class="text-success">配送准备中</span>
										<?php  } else if($item['go_status'] == 28) { ?>
										<a  onclick="setStatus('<?php  echo $item['go_code'];?>',30)"  class="btn btn-info btn-xs">按清单发货</a>
										<?php  } else if($item['go_status'] == 30 && $is_open_manger_sure_order==1) { ?>
										<a class="btn btn-info btn-xs only-sure-order" data-code="<?php  echo $item['go_code'];?>">确认收货</a>
										<!--<a  onclick="if(confirm('确定售后?')){setStatus('<?php  echo $item['go_code'];?>',40)}else{return false;}"  class="btn btn-info btn-xs">售后</a>-->
										<?php  } ?>
										<?php  if($item['go_status'] == 20 || $item['go_status'] == 10 || $item['go_status'] == 25 && intval($this->supplier_role)!==1 ) { ?>
										<a  onclick="setStatus('<?php  echo $item['go_code'];?>',120)"  class="btn btn-danger btn-xs">交易关闭</a>
										<?php  } ?>
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
	//异步查询订单状态
    //查询待付款订单
    $.post("<?php  echo $this->createWebUrl('overview',array('op'=>'check_order_status'))?>", {"tset": 1}, function (res) {
        //无
    }, "JSON");
	//发货异步
    function setStatus(id,code){
        if(id == '' || id == undefined){
            layer.msg('非法操作',{icon:2,time:1000});
            return false;
        }
        if(code == '' || code == undefined){
            layer.msg('非法操作',{icon:2,time:1000});
            return false;
        }
        var notice='';
        if(code  == 120){
            notice ='确定交易关闭？';
		}else if(code==30){
            notice ='确定发货？';
        }else if(code==25){
            notice ='配送后会进入配送单？';
        }
        layer.confirm(notice,{icon: 3, title:'提示'},function (index) {
        	var index = layer.load(0, {shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('order',array('op'=>'setStatus'))?>",{id:id,code:code},function(res){
                layer.closeAll();
                if(res.status == 0){
//              	if(res.data.count >0 ){
//              		layer.confirm(res.msg+",平台还有"+res.data.count+"个订单需要快递发货，请单独发货", {
//						  btn: ['知道了'] //按钮
//						}, function(){
//
//	                       	location.reload();
//
//						});
//              	}else{
                		layer.msg(res.msg,{icon:1,time:1000},function(r){
                			if(code == 25){
                				window.location.href = "<?php  echo $this->createWebUrl('distribution',array('op'=>'wait'))?>";
                			}else{
                				location.reload();
                			}
                		});
//              	}
                    
                }else{
                    // alert(res.msg);
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
        })

    }
	//快递配送
	function shipSend(code){
        if(code == '' || code == undefined){
            layer.msg('非法操作',{icon:2,time:1000});
            return false;
        }
        layer.open({
            title:'快递信息',
            type: 2,
            area: ['750px', '500px'],
            fixed: false, //不固定
            maxmin: true,
            content: "<?php  echo $this->createWebUrl('order',array('op'=>'shipSendTpl'))?>&code="+code
        });
	}
    //交易关闭异步
    // function closeOrder(id){
    //     if(id == '' || id == undefined){
    //         layer.msg('非法操作',{icon:2,time:1000});
    //         return false;
    //     }
    //     $.post("<?php  echo $this->createWebUrl('order',array('op'=>'setStatus','code'=>'100'))?>",{id:id},function(res){
    //         if(res.status == 0){
    //             // alert(res.msg);
    //             location.reload();
    //         }else{
    //             layer.msg(res.msg,{icon:2,time:1000});
    //         }
    //     },"JSON")
    // }

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
    //查询待付款订单
    $.post("<?php  echo $this->createWebUrl('overview',array('op'=>'check_order_status'))?>", {"tset":1}, function (res) {

    }, "JSON");
    //批量发货
	$(document).on("click","#batch-send",function () {
        var id = '';
        var str  = "确定对下列订单进行发货操作？<br/>";
        var send_type = 0;
        $(".check-order:checked").each(function () {
            if(send_type !=3 && $(this).attr("data-send-type")==3){
            	send_type=3;
            }
            if($(this).attr("data-send-type")!=3){
            	id +=$(this).attr("data-code")+',';
            	str += "订单号："+$(this).attr("data-code")+"<br/>";
            }
        });
        if(id=='' && send_type==3){
        	layer.msg('快递发货的订单，请单独设置发货',{icon:2,time:1000});
        	return false;
        }
        layer.confirm(str, {title: '友情提示'}, function (index) {
            $.post("<?php  echo $this->createWebUrl('order',array('op'=>'setStatus'))?>",{id:id,code:30},function(res){
                layer.close(index);
                if(res.status == 0){
                  	if(send_type ==3 ){
                		layer.confirm(res.msg+",需要快递发货的订单，请单独发货", {
						  btn: ['马上去'] //按钮
						}, function(){

	                       	location.reload();

						});
                	}else{
                		layer.msg(res.msg,{icon:1,time:1000});
                		setTimeout(function () {
                       		location.reload();
                    	},1500);
                	}
//                  layer.msg(res.msg,{icon:1,time:1000});
//					setTimeout(function () {
//                      location.reload();
//                  },1500);
                }else{
                    // alert(res.msg);
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
		})
    });
    //批量配送
    $(document).on("click","#batch-distribution",function () {
        var id = '';
        var str  = "确定对下列订单进行配送操作？<br/>";
        var send_type = 0;
        $(".check-order:checked").each(function () {
            if(send_type !=3 && $(this).attr("data-send-type")==3){
            	send_type=3;
            }
            if($(this).attr("data-send-type")!=3){
            	id +=$(this).attr("data-code")+',';
            	str += "订单号："+$(this).attr("data-code")+"<br/>";
            }
        });
        if(id=='' && send_type==3){
        	layer.msg('快递发货的订单，请单独设置发货',{icon:2,time:1000});
        	return false;
        }
        layer.confirm(str, {title: '友情提示'}, function (index) {
            $.post("<?php  echo $this->createWebUrl('order',array('op'=>'setStatus'))?>",{id:id,code:25},function(res){
                layer.close(index);
                if(res.status == 0){
                	if(send_type ==3 ){
                		layer.confirm(res.msg+",需要快递发货的订单，请单独发货", {
						  btn: ['马上去'] //按钮
						}, function(){

	                       	location.reload();

						});
                	}else{
                		layer.msg(res.msg,{icon:1,time:1000});
                		setTimeout(function () {
                       		location.reload();
                    	},1500);
                	}
//                  layer.msg(res.msg,{icon:1,time:1000});
//                  setTimeout(function () {
//                      location.reload();
//                  },1500);
                }else{
                    // alert(res.msg);
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
        })
    });
    //全部发货
    $(document).on("click","#all-send",function () {
        var id = '';
        var str  = "确定对全部待发货订单进行发货操作？<br/>";

        layer.confirm(str, {title: '友情提示'}, function (index) {
            $.post("<?php  echo $this->createWebUrl('order',array('op'=>'all_send'))?>",{id:id},function(res){
                layer.close(index);
                if(res.status == 0){
                    if(res.data.count >0 ){
                		layer.confirm(res.msg+",平台还有"+res.data.count+"个订单需要快递发货，请单独发货", {
						  btn: ['知道了'] //按钮
						}, function(){

	                       	location.reload();

						});
                	}else{
                		layer.msg(res.msg,{icon:1,time:1000});
                		setTimeout(function () {
                       		location.reload();
                    	},1500);
                	}
                }else{
                    // alert(res.msg);
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
        })
    });
    //全部配送
    $(document).on("click","#all-distribution",function () {
        var id = '';
        var str  = "确定对全部待发货订单进行配送操作？<br/>";
        layer.confirm(str, {title: '友情提示'}, function (index) {
        	var index = layer.load(0, {shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('order',array('op'=>'all_distribution'))?>",{id:id},function(res){
                layer.closeAll();
                console.log(res);
                if(res.status == 0){
                   if(res.data > 0 ){
                		layer.confirm(res.msg+",平台还有"+res.data+"个订单需要快递发货，请单独发货", {
						  btn: ['知道了'] //按钮
						}, function(){
	                       	location.reload();
						});
                	}else{
                		layer.msg(res.msg,{icon:1,time:2000},function(e){
                			window.location.href = "<?php  echo $this->createWebUrl('distribution',array('op'=>'wait'))?>";
                		});
//              		setTimeout(function () {
//                     		location.reload();
//                  	},1500);
                	}
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
        })
    });
    //单个确认收货
    $(document).on("click",".only-sure-order",function () {
        var id = '';
        var str  = "确定对下列订单进行确认收货操作？<br/>";
            	id +=$(this).attr("data-code")+',';
            	str += "订单号："+$(this).attr("data-code")+"<br/>";
      
        layer.confirm(str, {title: '友情提示'}, function (index) {
        	layer.load(0,{shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('order',array('op'=>'sure_order'))?>",{id:id,code:100},function(res){
                layer.closeAll();
                if(res.status == 0){
            		layer.msg(res.msg,{icon:1,time:1000},function(re){
            			location.reload();
            		});
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
        })
    });
	//批量确认收货
    $(document).on("click","#batch-sure-order",function () {
        var id = '';
        var str  = "确定对下列订单进行确认收货操作？<br/>";

        $(".check-order:checked").each(function () {
           
            	id +=$(this).attr("data-code")+',';
            	str += "订单号："+$(this).attr("data-code")+"<br/>";
            
        });
        layer.confirm(str, {title: '友情提示'}, function (index) {
        	layer.load(0,{shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('order',array('op'=>'sure_order'))?>",{id:id},function(res){
                layer.closeAll();
                if(res.status == 0){
            		layer.msg(res.msg,{icon:1,time:1000},function(re){
            			location.reload();
            		});
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
        })
    });
	//本页全部确认收货
    $(document).on("click","#page-sure-order",function () {
        var id = '';
        var str  = "确定对下列订单进行确认收货操作？<br/>";

        $(".check-order").each(function () {
           
            	id +=$(this).attr("data-code")+',';
            	str += "订单号："+$(this).attr("data-code")+"<br/>";
            
        });
        layer.confirm(str, {title: '友情提示'}, function (index) {
        	layer.load(0,{shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('order',array('op'=>'sure_order'))?>",{id:id},function(res){
                layer.closeAll();
                if(res.status == 0){
            		layer.msg(res.msg,{icon:1,time:1000},function(re){
            			location.reload();
            		});
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
        })
    });
    //全部确认收货
    $(document).on("click","#all-sure-order",function () {
        var id = '';
        var str  = "确定对全部待收货订单进行确认收货操作？<br/>";
      
        layer.confirm(str, {title: '友情提示'}, function (index) {
        	layer.load(0,{shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('order',array('op'=>'sure_order'))?>",{id:id,type:'all'},function(res){
                layer.closeAll();
                if(res.status == 0){
            		layer.msg(res.msg,{icon:1,time:1000},function(re){
            			location.reload();
            		});
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
        })
    });
    function content(obj,id){
    	var content = $(obj).data('content');
    	console.log(content);
    	layer.prompt({title: '请输入备注', formType: 2,value:content,area: ['500px', '200px']}, function(pass, index){
			console.log(pass);
			if(content == pass){
				layer.clossAll();
				return false;
			}
		  	$.post("<?php  echo $this->createWebUrl('order',array('op'=>'remake_content'))?>",{id:id,content:pass},function(e){
	  			layer.msg(e.msg,{time:2000},function(){
	  				if(e.status == 0){
	  					location.reload();
	  				}
	  			});
		  	},'JSON')
		});
    }
</script>
