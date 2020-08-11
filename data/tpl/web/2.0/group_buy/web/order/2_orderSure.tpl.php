<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">核销列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="order">
								<input type="hidden" name="op" value="orderSure">
								<div class="am-u-sm-12 ">
									<div class="am-form-group am-fl">
										<label class="am-form-label am-form-label" >订单号</label>
									</div>
									<div class="am-form-group am-fl">
										<div class="am-input-group am-input-group-sm tpl-form-border-form">
											<input type="text" class="am-form-field" name="num" placeholder="订单号" value="<?php  echo $_GPC['num'];?>" style="border-radius: 4px;width: 240px;">
										</div>
									</div>
									<div class="am-form-group am-fl">
										<label class="am-form-label am-form-label" >核销人</label>
									</div>
									<div class="am-form-group am-fl">
										<div class="am-input-group am-input-group-sm tpl-form-border-form">
											<input type="text" class="am-form-field" name="head" placeholder="核销人" value="<?php  echo $_GPC['head'];?>" style="border-radius: 4px;width: 240px;">
										</div>
									</div>
									<div class="am-form-group am-fl">
										<label class="am-form-label am-form-label" >买家名</label>
									</div>
									<div class="am-form-group am-fl">
										<div class="am-input-group am-input-group-sm tpl-form-border-form">
											<input type="text" class="am-form-field" name="buy_people" placeholder="买家名" value="<?php  echo $_GPC['buy_people'];?>" style="border-radius: 4px;width: 240px;">
										</div>
									</div>
									<div class="am-form-group am-fl">
										<label class="am-form-label am-form-label" >时间</label>
									</div>
									<div class="am-form-group am-fl">
										<div class="am-input-group am-input-group-sm tpl-form-border-form">
											<?php  echo tpl_form_field_daterange('time', array('start'=> $_GPC['time']['start'],'end'=>$_GPC['time']['end']));?>
										</div>
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
								<thead class="navbar-inner">
								<tr>
									<th style="width:180px;">订单号</th>
									<!--<th style="width:120px;">核销码</th>-->
									<th style="width:80px;">核销人</th>
									<th style="width:80px;">买家</th>
									<th style="width:150px;">时间</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
								<tr>
									<td style="display: flex;align-items: center;">
										<a href="<?php  echo $this->createWebUrl('order',array('op'=>'index','num'=>$item['so_go_code']))?>" class="text-info"><?php  echo $item['so_go_code'];?></a>
									</td>
									<!--<td><?php  echo $item['so_code'];?></td>-->
									<td><?php  echo $item['so_buy_name'];?></td>
									<td><?php  echo $item['so_sure_name'];?></td>
									<td><?php  echo date('Y-m-d H:i:s',$item['so_add_time'])?>
									</td>
								</tr>
								<?php  } } ?>
								<?php  } else { ?>
								<tr>
									<td colspan="999">
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
								<div class="am-vertical-align-middle">总记录：<?php echo empty($total)?0:$total;?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
