<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">会员充值</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="am-u-sm-12 am-fl am-margin-bottom-xs">
							<div class="am-btn-group am-btn-group-xs ">
								<a class="zx-addBut" href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'markrting','in'=>'add','type'=>1))?>">
									<i class="fa fa-plus"></i> 添加充值
								</a>
							</div>
						</div>
						
						<div class="page_toolbar am-margin-bottom-xs am-cf">
								<div class="am-scrollable-horizontal am-u-sm-12">
									<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
										<thead class="navbar-inner">
										<tr>
											<th>标题</th>
											<th>充值金额</th>
											<th>赠送金额</th>
											<th>赠送积分</th>
											<th>否是释放金</th>
											<th class="w10">权重</th>
											<th>操作</th>
										</tr>
										</thead>
										<tbody>
										<?php  if(!empty($info)) { ?>
										<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
										<tr>
											<td><?php  echo $item['title'];?></td>
											<td><?php  echo $item['money'];?></td>
											<td><?php  echo $item['give_money'];?></td>
											<td><?php  echo $item['give_integral'];?></td>
											<td><?php echo $item['release_gold'] == 1 ? '是' : '否'?></td>
											<td><?php  echo $item['weight'];?></td>
											<td>
												<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'markrting','in'=>'add','id'=>$item['id']))?>"  class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> 修改</a>
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
	  $.post("<?php  echo $this->createWebUrl('plsugins',array('op'=>'markrting','in'=>'del'))?>",{id:id},function(res){
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
</script>
