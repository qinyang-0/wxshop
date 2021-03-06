<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
	.tpl-table-black tbody>tr>td{
		padding: 5px;
	}
</style>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">秒杀分类管理</div>
					</div>
					<form action="./index.php">
						<input type="hidden" name="c" value="site">
						<input type="hidden" name="a" value="entry">
						<input type="hidden" name="m" value="group_buy_plugin_seckill">
						<input type="hidden" name="do" value="category">
					<div class="widget-body am-fr">
						<!-- 工具栏 -->


						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap" id="table">
								<thead>
									<tr>
										<th style="width:60px;">ID</th>
										<th>分类名称</th>
										<th style="width: 45px;">操作</th>
									</tr>
								</thead>
								<tbody>
									<?php  if(!empty($list)) { ?>
										<?php  if(is_array($list)) { foreach($list as $row) { ?>
											<tr>
												<td class="am-text-middle"><?php  echo $row['id'];?></td>
												<td class="am-text-middle">
													<input type="text" class="form-control" name="catname[<?php  echo $row['id'];?>]" value="<?php  echo $row['name'];?>">

												</td>


												<td class="am-text-middle">

													<a href="javascript:;" data-id="<?php  echo $row['id'];?>" class="btn btn-danger btn-xs item-delete">
														<i class="am-icon-trash"></i> 删除
													</a>

												</td>
											</tr>
										<?php  } } ?>
									<?php  } else { ?>
										<tr><td colspan="10" style="text-align: center;" class="no-data">暂无数据</td></tr>
									<?php  } ?>
								</tbody>
							</table>
						</div>
						<div class="am-u-sm-12 am-fl am-margin-bottom-xs">
							<div class="am-btn-group am-btn-group-xs ">
								<a class="zx-but-check add-class" href="javascript:;" style="color: #000;">
									<i class="fa fa-plus"></i> 添加分类
								</a>
							</div>
							<div class="am-btn-group am-btn-group-xs ">
								<button class="zx-addBut" type="submit">
									<i class="fa fa-plus"></i> 保存分类
								</button>
							</div>
						</div>
					</form>
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
					$.post("<?php  echo $this->createWebUrl('category',array('op'=>'delete'))?>", {
						id: id,
					}, function(result) {
						result.status === 0 ? layer.msg(result.msg, {icon: 1}) :layer.msg(result.msg, {icon: 2});
						setTimeout(function () {
                            location.reload();
                        },1500);

					},"JSON");
				})
			});
			//添加分类
			$(document).on('click','.add-class',function () {
			    if($(".no-data")){
                    $(".no-data").parent('tr').remove();
				}
				var str = '<tr><td class="am-text-middle"><i class="fa fa-plus"></i></td><td class="am-text-middle"><input type="text" class="form-control" name="catname_new[]" value=""></td><td class="am-text-middle"><span class="btn btn-xs btn-default del-add"><i class="fa fa-close "></i></span></td></tr>';
				$('#table').children('tbody').append(str);
            });
			//删除新增分类
            $(document).on('click','.del-add',function () {
				$(this).parent('td').parent('tr').remove();
			});
		});
	</script>

</div>
<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>