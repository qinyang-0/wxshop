<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">幻灯片管理</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form class="toolbar-form" action="./index.php">
								<input type="hidden" name="c" value="site">
					            <input type="hidden" name="a" value="entry">
					            <input type="hidden" name="m" value="group_buy_plugin_seckill">
					            <input type="hidden" name="do" value="adv">
								<div class="am-u-sm-12 ">
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="keyword" placeholder="请输入关键词" value="<?php  echo $_GPC['keyword'];?>" style="border-radius: 4px;width: 240px;">
									</div>

									<span class="zx-form-span">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;状态：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<select name="enabled" data-am-selected="{ btnSize: 'sm',placeholder:'请选择状态', maxHeight: 400}" style="display: none;">
											<option value="" <?php  if($_GPC['enabled'] == '') { ?> selected<?php  } ?>>请选择...</option>
											<option value="1" <?php  if($_GPC['enabled'] == 1) { ?>selected<?php  } ?>>显示</option>
											<option value="0" <?php  if(isset($_GPC['enabled']) && $_GPC['enabled'] === '0') { ?>selected<?php  } ?>>隐藏</option>
										</select>

									</div>
									<!-- 查询按钮样式 -->
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<div class="zx-but-check">
										<button type="submit" >
											<i class="fa fa-search"></i> 搜索
										</button>

									</div>

								</div>

							</form>
						</div>
						<div class="am-u-sm-12 am-fl am-margin-bottom-xs">
							<div class="am-btn-group am-btn-group-xs ">
								<a class="zx-addBut" href="<?php  echo $this->createWebUrl('adv',array('op'=>'add'))?>">
									<i class="fa fa-plus"></i> 添加幻灯片
								</a>
							</div>
						</div>
						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
								<thead>
									<tr>
										<!--<th style='width:50px' >-->
											<!--<label class="am-checkbox-inline am-success">-->
												<!--<input type="checkbox"  id="check-all" data-am-ucheck data-id="0">&nbsp;-->
											<!--</label>-->
										<!--</th>-->
										<th style='width:50px'>顺序</th>
										<th >标题</th>
										<th>链接</th>
										<th style='width:100px'>图</th>
										<th style='width:60px'>显示</th>
										<th style="width: 65px;">操作</th>
									</tr>
								</thead>
								<tbody>
									<?php  if(!empty($list)) { ?>
										<?php  if(is_array($list)) { foreach($list as $row) { ?>
											<tr>
												<!--<td class="am-text-middle ">-->
													<!--<label class="am-checkbox-inline am-success">-->
														<!--<input type="checkbox" data-id="<?php  echo $row['id'];?>"  data-am-ucheck class="check-order">&nbsp;-->
													<!--</label>-->
												<!--</td>-->
												<td class="am-text-middle">
													<?php  echo $row['displayorder'];?>
												</td>
												<td class="am-text-middle">
													<?php  echo $row['advname'];?>
												</td>

												<td class="am-text-middle">
													<?php  echo $row['link'];?>
												</td>
												<td class="am-text-middle" >
													<img src="<?php  echo tomedia($row['thumb'])?>" width="50">
												</td>
												<td class="am-text-middle">
													<?php  if($row['enabled']==1) { ?>
													<button type="button" class="btn btn-info btn-xs setState" data-field="enabled" data-val="0" data-id="<?php  echo $row['id'];?>">已显示</button>
													<?php  } else { ?>
													<button type="button" class="btn btn-warning btn-xs setState" data-field="enabled" data-val="1" data-id="<?php  echo $row['id'];?>">已隐藏</button>
													<?php  } ?>
												</td>
												<td class="am-text-middle">
													<a href="<?php  echo $this->createWebUrl('adv',array('op'=>'add','id'=>$row['id']))?>" class="btn btn-info btn-xs">
														<i class="am-icon-pencil"></i> 编辑
													</a>


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
					$.post("<?php  echo $this->createWebUrl('adv',array('op'=>'delete'))?>", {
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
                $.post("<?php  echo $this->createWebUrl('adv',array('op'=>'state'))?>", {
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