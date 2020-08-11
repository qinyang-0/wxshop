<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper ">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">提现管理</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form id="form-search" class="toolbar-form" action="./index.php">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="finance">
								<div class="am-u-sm-12 am-u-md-12">
									<div class="am fr">
										<div class="am-form-group am-fl">
											<div class="am-input-group am-input-group-sm tpl-form-border-form">
												<input class="am-form-field zx-butInput" name="title" type="text" value="<?php  echo $title;?>" placeholder="提现人名称">
											</div>
										</div>


										<!-- 查询按钮样式 -->
										<div class="zx-but-check">
											<button type="submit" >
												<i class="fa fa-search"></i> 查询
											</button>
										</div>
									</div>
								</div>
							</form>
						</div>

						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
								<thead class="navbar-inner">
								<tr>
									<th style="width:50px;">编号</th>
									<!--<th style="width:100px;">链接类型</th>-->
									<th >提现人</th>
									<th >提现金额</th>
									<th >状态</th>
									<th >申请提现时间/提现打款时间</th>
									<th >提现类型</th>
									<th >打款帐号信息</th>
									<th >原因</th>
									<th >操作</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
								<tr>
									<td><?php  echo $item['ggc_id'];?></td>

									<td style="display: flex;align-items: center">
										<img src="<?php  echo $item['m_photo'];?>" width="50" style="border-radius: 50%;"/>
										<?php  echo $item['m_nickname'];?>
									</td>
									<td><?php  echo $item['ggc_money'];?></td>
									<td><?php  if($item['ggc_type'] == 10) { ?>
										<span class="text-danger">未审核</span>
										<?php  } else if($item['ggc_type'] == 20) { ?>
										<span class="text-success">已审核</span>
										<?php  } else if($item['ggc_type'] == 30) { ?>
										<span class="text-warning">拒绝</span>
										<?php  } else if($item['ggc_type'] == 40) { ?>
										<span class="text-info">余额不足</span>
										<?php  } ?>

									</td>
									<td>
										申请:<?php echo empty($item['ggc_add_time'])?'':date('Y-m-d H:i:s',$item['ggc_add_time']);?>
									<br/>
										<span class="text-success">打款:<?php echo empty($item['ggc_update_time'])?'':date('Y-m-d H:i:s',$item['ggc_update_time']);?></span>
									</td>
									<td>
										<?php  if($item['ggc_pay_type'] ==1) { ?>
										微信
										<?php  } else if($item['ggc_pay_type'] ==2) { ?>
										支付宝
										<?php  } else if($item['ggc_pay_type'] ==3) { ?>
										银行卡
										<?php  } ?>
									</td>
									<td>
										<?php  if($item['ggc_pay_type'] ==1) { ?>

										<?php  } else if($item['ggc_pay_type'] ==2) { ?>
										支付宝帐号:<span class="text-danger"><b><?php  echo $item['ggc_pay_account'];?></b></span>
										<br/>姓名:<span class="text-danger"><b><?php  echo $item['ggc_pay_name'];?></b></span>
										<?php  } else if($item['ggc_pay_type'] ==3) { ?>
										银行卡帐号:<span class="text-danger"><b><?php  echo $item['ggc_pay_account'];?></b></span>
										<br/>姓名:<span class="text-danger"><b><?php  echo $item['ggc_pay_name'];?></b></span>
										<br/>开户行地址:<span class="text-danger"><b><?php  echo $item['ggc_open_account_name'];?></b></span>
										<?php  } ?>
									</td>
									<td>
										<?php  echo $item['ggc_content'];?>
									</td>
									<td><!--删除可以用ajax实现-->
										<?php  if($item['ggc_type'] ==10 ) { ?>
											<?php  if($item['ggc_pay_type'] ==1) { ?>
											<a href="<?php  echo $this->createWebUrl('finance',array('op'=>'sure_get_cash','id'=>$item['ggc_id']))?>"  class="btn btn-info btn-xs">同意</a>
											<?php  } else if($item['ggc_pay_type'] ==2) { ?>
											<span data-href="<?php  echo $this->createWebUrl('finance',array('op'=>'sure_get_cash','id'=>$item['ggc_id']))?>"  data-type="支付宝" data-account="<?php  echo $item['ggc_pay_account'];?>"  class="btn btn-info btn-xs sure-get-cash">已支付宝打款</span>
											<?php  } else if($item['ggc_pay_type'] ==3) { ?>
											<span data-href="<?php  echo $this->createWebUrl('finance',array('op'=>'sure_get_cash','id'=>$item['ggc_id']))?>" data-type="银行卡" data-account="<?php  echo $item['ggc_pay_account'];?>"   class="btn btn-info btn-xs sure-get-cash">已银行卡打款</span>
											<?php  } ?>
										<a href="<?php  echo $this->createWebUrl('finance',array('op'=>'sayNo','id'=>$item['ggc_id']))?>"  class="btn btn-danger btn-xs">拒绝</a>
										<?php  } ?>
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

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>

<script>
	//确定打款提示
	$(document).on('click','.sure-get-cash',function () {
	    var type = $(this).attr('data-type');
	    var account = $(this).attr('data-account');
	    var notice ='确定已向<br/>';
	    var  url = $(this).attr('data-href');
        notice +='<b>'+type+'帐号：'+account+'</b><br/>';
        notice +='打款了吗？';
        layer.confirm(notice, {icon: 3, title:'友情提示'}, function(index) {
			location.href=url;
		});
    });
</script>


