<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.w10{
	    width: 62px;
	}
	.xu{
		border: 1px dashed !important;
	    text-align: center;
	    color: #aba4a4 !important;
	}
</style>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">会员卡列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="am-u-sm-12 am-fl am-margin-bottom-xs">
							<div class="am-btn-group am-btn-group-xs ">
								<a class="zx-addBut" href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'card','in'=>'member_card_add'))?>">
									<i class="fa fa-plus"></i> 添加会员卡
								</a>
							</div>
						</div>
						
						<div class="page_toolbar am-margin-bottom-xs am-cf">
								<div class="am-scrollable-horizontal am-u-sm-12">
									<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
										<thead class="navbar-inner">
										<tr>
											<th>标题</th>
											<th>会员卡折扣</th>
											<th>状态</th>
											<th>新增时间</th>
											<th class="w10">排序</th>
											<th>操作</th>
										</tr>
										</thead>
										<tbody>
										<?php  if(!empty($info)) { ?>
										<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
										<tr>
											<td><?php  echo $item['title'];?></td>
											<td><?php  echo $item['discount'];?></td>
											<td><?php echo $item['c_status'] == 1 ? '启用' : '未启用'?></td>
											<td><?php  echo date("Y-m-d",$item['create_time'])?></td>
											<td class="am-text-middle zx-edit-td">
												<input class="zx-edit-td-input" type="text" value="<?php  echo $item['sort'];?>" style="background: #fff;border: 1px dashed #999;width: 50px;text-align: center;" data-id="<?php  echo $item['id'];?>" data-val="<?php  echo $item['sort'];?>" name="sort">
											</td>
											<td>
												<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'card','in'=>'member_card_add','id'=>$item['id']))?>"  class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> 修改</a>
												<a class="btn btn-danger btn-xs" onclick="deletes('<?php  echo $item['id'];?>')"><i class="fa fa-trash-o"></i> 删除</a>
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
function deletes(id){
	layer.confirm('是否确定删除?', {icon: 3, title:'提示'}, function(index){
	  $.post("<?php  echo $this->createWebUrl('plsugins',array('op'=>'card','in'=>'member_card_del'))?>",{id:id},function(res){
	  	console.log(res);
	  	if(res.code != 1){
	  		layer.msg(res.msg,{icon:1,time:2000},function(res){
	  			location.reload();
	  		})
	  	}else{
	  		layer.msg(res.msg,{icon:2,time:2000});
	  	}
	  },"JSON")
	  layer.close(index);
	});
}
$("input[name='sort']").change(function(res){
	var id = $(this).data('id');
	var val = $(this).val();
	if(id == "" || id == undefined){
		layer.msg('未知错误');
		return false;
	}
	$.post("<?php  echo $this->createWebUrl('plsugins',array('op'=>'card','card_save_sort'=>'card_save_sort'))?>",{id:id,val:val},function(res){
		console.log(res);
		if(res.code == 1){
			layer.msg(res.msg);
		}else{
			layer.msg(res.msg);
		}
	},"JSON")
})
</script>
