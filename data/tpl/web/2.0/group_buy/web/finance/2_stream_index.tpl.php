<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">交易流水列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form class="toolbar-form" action="./index.php">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="finance">
								<input type="hidden" name="op" value="stream_index">
								<div class="am-u-sm-12 ">

									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 90px;">
										<select name="key_field" data-am-selected="{searchBox: 1, btnSize: 'sm',placeholder:'请选择查询的关键词', maxHeight: 400}" style="display: none;">
											<option value="order" <?php  if($_GPC['key_field'] =='order') { ?>selected<?php  } ?>>订单号</option>
											<option value="num" <?php  if($_GPC['key_field'] =='num') { ?>selected<?php  } ?>>流水号</option>
											<option value="team" <?php  if($_GPC['key_field'] =='team') { ?>selected<?php  } ?>>团长信息</option>
										</select>

									</div>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" >
										<input class="am-form-field" name="key" type="text" value="<?php  echo $_GPC['key'];?>" placeholder="请输入关键词">
									</div>
									<!--<span class="zx-form-span">-->
										<!--订单号：-->
									<!--</span>-->
									<!--<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">-->
										<!--<input type="text" class="am-form-field" name="order" placeholder="订单号" value="<?php  echo $order;?>" style="border-radius: 4px;width: 240px;">-->
									<!--</div>-->
									<!--<span class="zx-form-span">-->
										<!--流水号：-->
									<!--</span>-->
									<!--<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">-->
										<!--<input type="text" class="am-form-field" name="num" placeholder="流水号" value="<?php  echo $num;?>" style="border-radius: 4px;width: 240px;">-->
									<!--</div>-->
									<!--<span class="zx-form-span">-->
										<!--团长：-->
									<!--</span>-->
									<!--<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">-->
										<!--<input type="text" class="am-form-field" name="team" placeholder="团长" value="<?php  echo $team;?>" style="border-radius: 4px;width: 240px;">-->
									<!--</div>-->
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 130px;">
										<select name="time_type" data-am-selected="{searchBox: 1, btnSize: 'sm',placeholder:'不按时间查询', maxHeight: 400}" style="display: none;">
											<option value=" ">不按时间查询</option>
											<option value="add_time" <?php  if($_GPC['time_type'] =='add_time') { ?>selected<?php  } ?>>流水生成时间</option>
										</select>
									</div>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 265px">
										<?php echo tpl_form_field_daterange('time', array('start'=> empty($_GPC['time']['start'])?date('Y-m-d',(time()-31*24*60*60)):$_GPC['time']['start'],'end'=> empty($_GPC['time']['end'])?date('Y-m-d',time()):$_GPC['time']['end']),true);?>
									</div>

										<!-- 查询按钮样式 -->
										<div class="zx-but-check">
											<button type="submit" >
												<i class="fa fa-search"></i> 查询
											</button>
										</div>
								</div>

							</form>
						</div>

						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
								<thead>
								<tr>
									<th>订单号</th>
									<th>流水号</th>
									<th>类型</th>
									<th>订单总额</th>
									<th>实收金额</th>
									<th>团长</th>
									<th>买家</th>
									<th>状态</th>
									<th>生成时间</th>
									<th>备注</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $item) { ?>
								<tr>
									<td class="am-text-middle"><?php  echo $item['gos_go_code'];?></td>
									<td class="am-text-middle">
										<?php  echo $item['gos_code'];?>
									</td>
									<td class="am-text-middle">
										<?php  if($item['gos_type']==1) { ?>
										<span class="am-text-success">收入</span>
										<?php  } else if($item['gos_status']==2) { ?>
										<span class="am-text-warning">支出</span>
										<?php  } ?>
									</td>
									<td class="am-text-middle">
										<?php  echo $item['gos_order_money'];?>
									</td>
									<td class="am-text-middle">
										<?php  if($item['gos_type']==1) { ?>
										<span class="am-text-success">+<?php  echo $item['gos_real_money'];?></span>
										<?php  } else if($item['gos_status']==2) { ?>
										<span class="am-text-warning">-<?php  echo $item['gos_real_money'];?></span>
										<?php  } ?>
									</td>
									<td class="am-text-middle">
										<?php  echo $item['gos_team'];?>
									</td>
									<td class="am-text-middle">
										<?php  echo $item['gos_payer'];?>
									</td>
									<td class="am-text-middle">
										<?php  if($item['gos_status']==1) { ?>
											开始
										<?php  } else if($item['gos_status']==-1) { ?>
										<span class="am-text-danger">失败</span>
										<?php  } else if($item['gos_status']==2) { ?>
										<span class="am-text-success">成功</span>
										<?php  } ?>
									</td>
									<td class="am-text-middle">
										<?php  echo date("Y-m-d H:i:s",$item['gos_add_time']);?>
									</td>
									<td class="am-text-middle">
										<?php  echo $item['gos_commet'];?>
									</td>
								</tr>

								<?php  } } ?>
								<?php  } else { ?>
								<tr>
									<td colspan="10" style="text-align: center;">暂无数据</td>
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
<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
