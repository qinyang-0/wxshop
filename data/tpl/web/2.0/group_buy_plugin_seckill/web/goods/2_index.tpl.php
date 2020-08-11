<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">秒杀商品管理</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form class="toolbar-form" action="./index.php">
								<input type="hidden" name="c" value="site">
					            <input type="hidden" name="a" value="entry">
					            <input type="hidden" name="m" value="group_buy_plugin_seckill">
					            <input type="hidden" name="do" value="goods">
								<div class="am-u-sm-12 ">
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="专题名称/会场名称/商品名称" style="border-radius: 4px;width: 240px;">
										<!--<input type="text" class="am-form-field" name="keyword" placeholder="请输入关键词" value="<?php  echo $_GPC['keyword'];?>" style="border-radius: 4px;width: 240px;">-->
									</div>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
									<select name="time" class='form-control' data-am-selected="{ btnSize: 'sm',placeholder:'请选择时间段', maxHeight: 400}">
										<option value="" <?php  if($_GPC['time'] === '') { ?> selected<?php  } ?>>时间段</option>
										<?php  if(is_array($alltimes)) { foreach($alltimes as $i) { ?>
										<option value="<?php  echo $i;?>" <?php  if($_GPC['time']== $i) { ?>selected<?php  } ?>><?php  echo $i;?></option>
										<?php  } } ?>
									</select>
									</div>


									<!-- 查询按钮样式 -->
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<div class="zx-but-check">
										<button type="submit" >
											<i class="fa fa-search"></i> 查询
										</button>

									</div>

								</div>

							</form>
						</div>

						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
								<thead>
									<tr>
										<th>商品</th>
										<th  style="">&nbsp;</th>
										<th>秒杀价格</th>
										<th>已付款/未付款/库存</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<?php  if(!empty($list)) { ?>
										<?php  if(is_array($list)) { foreach($list as $row) { ?>
											<tr>
												<td class="am-text-middle ">
													<img src="<?php  echo tomedia($row['g_icon'])?>" width="70" style="padding:1px;border:1px solid #ccc;"/>
												</td>
												<td class='full am-text-middle' style="overflow-x: hidden;width: 300px;">

													<span><?php  echo $row['g_name'];?></span><br/>
													<a href="<?php  echo $this->createWebUrl('index',array('id'=>$row['taskid'],'op'=>'add'))?>" target="_blank"><span class="label label-primary"><?php  echo $row['tasktitle'];?></span></a>
													<a href="<?php  echo $this->createWebUrl('room',array('id'=>$row['roomid'],'taskid'=>$row['taskid'],'op'=>'add'))?>" target="_blank"><span class="label label-warning"><?php  echo $row['roomtitle'];?></span></a>
													<span class="label label-danger"><?php  echo $row['time'];?>点</span>
												</td>
												<td class="am-text-middle">
													<span class="text text-danger" style="font-size:14px">&yen; <?php  echo $row['price'];?></span><br />
													<span style="text-decoration: line-through;color:#666;">&yen;<?php  echo $row['g_price'];?></span>
												</td>
												<td>
													<?php  echo $row['count']-$row['notpay']?>&nbsp;/&nbsp;<?php  echo $row['notpay'];?>&nbsp;/&nbsp;<?php  echo $row['total'];?>
												</td>


												<td class="am-text-middle">

													<a href="javascript:;" data-id="<?php  echo $row['id'];?>" class="btn btn-danger btn-xs item-delete">
														<i class="am-icon-trash"></i> 删除
													</a>

												</td>
											</tr>
										<?php  } } ?>
									<?php  } else { ?>
										<tr><td colspan="10" style="text-align: center;">暂无数据</td></tr>
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
	<script>
		$(function() {
			// 删除元素
			$('.item-delete').click(function(){
				var id = $(this).data('id');
				layer.confirm('一但删除将无法恢复，确定删除吗？', {
					title: '友情提示'
				}, function(index) {
					$.post("<?php  echo $this->createWebUrl('goods',array('op'=>'delete'))?>", {
						id: id,
					}, function(result) {
						result.status === 0 ? layer.msg(result.msg, {icon: 1}) :layer.msg(result.msg, {icon: 2});
						setTimeout(function () {
                            location.reload();
                        },1500);

					},"JSON");
				})
			});

			$(document).on("click",".setState",function () {
                $.post("<?php  echo $this->createWebUrl('index',array('op'=>'state'))?>", {
                    id: $(this).attr("data-id"),
                    val: $(this).attr("data-val"),
                    field: $(this).attr("data-field"),
                }, function (result) {
                    result.status === 0 ? layer.msg(result.msg, {
                        icon: 1
                    }) : layer.msg(result.msg, {
                        icon: 2
                    });
                    setTimeout(function () {
                        location.reload();
                    },1500);

                }, "JSON");
            })
		});
	</script>

</div>
<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>