<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">优惠卷发放记录</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
								<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
									<input type="hidden" name="c" value="site">
									<input type="hidden" name="a" value="entry">
									<input type="hidden" name="m" value="group_buy">
									<input type="hidden" name="do" value="plsugins">
									<input type="hidden" name="op" value="market">
									<input type="hidden" name="in" value="record">
									<div class="am-u-sm-12 ">
										<span class="zx-form-span">
											优惠券名称：
										</span>
										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
											<input type="text" class="am-form-field" name="name" placeholder="优惠券名称" value="<?php  echo $_GPC['name'];?>" style="border-radius: 4px;width: 240px;">
										</div>
										<!--<div class="am-form-group am-fl">-->
										<!--<label class="am-form-label am-form-label" >名称</label>-->
										<!--</div>-->
										<!--<div class="am-form-group am-fl">-->
										<!--<div class="am-input-group am-input-group-sm tpl-form-border-form">-->
										<!--<input type="text" class="am-form-field" name="name" placeholder="优惠卷名称" value="<?php  echo $_GPC['title'];?>" style="border-radius: 4px;width: 240px;">-->
										<!--</div>-->
										<!--</div>-->
										<!-- 查询按钮样式 -->
										<div class="zx-but-check">
											<button type="submit" >
												<i class="fa fa-search"></i> 查询
											</button>
										</div>
									</div>
								</form>
								<div class="am-scrollable-horizontal am-u-sm-12">
									<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
										<thead class="navbar-inner">
										<tr>
											<th style="width:120px;">优惠券名称</th>
											<th style="width:80px;">领取人</th>
											<th style="width:120px;">领取时间</th>
											<th style="width:80px;">是否使用</th>
											<th style="width:120px;">使用时间</th>
										</tr>
										</thead>
										<tbody>
										<?php  if(!empty($info)) { ?>
										<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
										<tr>
											<td><?php  echo $item['name'];?></td>
											<td style="display: flex;align-items: center;">
												<img src="<?php  echo tomedia($item['m_photo']);?>" width="50" style="border-radius: 50%;"/>&nbsp;&nbsp;
												<div style="">
													<?php  echo $item['m_nickname'];?> <br/> <?php  echo $item['m_phone'];?>
												</div>
											</td>
											<td>
												<?php  echo date('Y-m-d H:i:s',$item['grant_time'])?>
											</td>
											<td><?php  if($item['is_use'] == 1 ) { ?>
												已使用
												<?php  } else { ?>
												未使用
												<?php  } ?>
											</td>
											<td>

												<?php echo $item['use_coupon_time'] >0?date('Y-m-d H:i:s',$item['use_coupon_time']):'';?>
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
										<div class="am-vertical-align-middle">总记录：<?php  echo $total;?></div>
									</div>
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

</script>
