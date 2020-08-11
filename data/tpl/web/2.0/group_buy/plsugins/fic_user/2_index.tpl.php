<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper no-sidebar-second">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">虚拟用户列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="market">
								<div class="am-u-sm-12 ">
									<!--<span class="zx-form-span">-->
										<!--名称：-->
									<!--</span>-->
									<!--<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">-->
										<!--<input type="text" class="am-form-field" name="name" placeholder="名称" value="<?php  echo $_GPC['name'];?>" style="border-radius: 4px;width: 240px;">-->
									<!--</div>-->
									<!--<div class="am-form-group am-fl">-->
										<!--<label class="am-form-label am-form-label" >名称</label>-->
									<!--</div>-->
									<!--<div class="am-form-group am-fl">-->
										<!--<div class="am-input-group am-input-group-sm tpl-form-border-form">-->
											<!--<input type="text" class="am-form-field" name="name" placeholder="优惠卷名称" value="<?php  echo $_GPC['title'];?>" style="border-radius: 4px;width: 240px;">-->
										<!--</div>-->
									<!--</div>-->
									<!-- 查询按钮样式 -->
									<!--<div class="zx-but-check">-->
										<!--<button type="submit" >-->
											<!--<i class="fa fa-search"></i> 查询-->
										<!--</button>-->
									<!--</div>-->
								</div>
							</form>
								<div class="am-u-sm-12 am-fl am-margin-bottom-xs">

									<div class="am-btn-group am-btn-group-xs ">
										<a class="zx-addBut" href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'fic_user','in'=>'edit'));?>">
											<i class="fa fa-plus"></i> 新增
										</a>
									</div>
								</div>
								<div class="am-scrollable-horizontal am-u-sm-12">
									<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
										<thead class="navbar-inner">
										<tr>
											<!--<th >-->
												<!--<label class="am-checkbox-inline am-success">-->
													<!--<input type="checkbox"  id="check-all" data-am-ucheck data-id="0">&nbsp;-->
												<!--</label>-->
											<!--</th>-->
											<th >编号</th>
											<th >昵称</th>
											<th >头像</th>
											<!--<th >电话</th>-->
											<th >操作</th>
										</tr>
										</thead>
										<tbody>
										<?php  if(!empty($info)) { ?>
										<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
										<tr>
											<!--<td class="am-text-middle ">-->
												<!--<label class="am-checkbox-inline am-success">-->
													<!--<input type="checkbox" data-id="<?php  echo $item['uid'];?>"  data-am-ucheck class="check-order">&nbsp;-->
												<!--</label>-->
											<!--</td>-->
											<td>
												<?php  echo $item['uid'];?>
											</td>
											<td>
												<?php  echo $item['name'];?>
											</td>
											<td>
												<?php  if(strlen($item['head'])>250) { ?>
													<img src="<?php  echo $item['head'];?>" width="50" style="border-radius: 50%;">
												<?php  } else { ?>
													<img src="<?php  echo tomedia($item['head']);?>" width="50" style="border-radius: 50%;">
												<?php  } ?>

											</td>
											<td><!--删除可以用ajax实现-->

												<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'fic_user','in'=>'edit','uid'=>$item['uid']))?>"  class="btn btn-info btn-xs">修改</a>

												<a class="btn btn-danger btn-xs" onclick="if(confirm('是否删除?')){deletes('<?php  echo $item['uid'];?>')}else{return false;}">删除</a>

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
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
	function deletes(id){
		if(id == '' || id == undefined){
            layer.msg('非法操作',{icon:2,time:2000});
			return false;
		}
		$.post("<?php  echo $this->createWebUrl('plsugins',array('op'=>'fic_user','in'=>'delete'))?>",{uid:id},function(res){
			if(res.status == 0){
                layer.msg(res.msg,{icon:1,time:1000});
                setTimeout(function () {
                    location.reload();
                },1000)
			}else{
                layer.msg(res.msg,{icon:2,time:1000});
			}
		},"JSON")
	}

</script>
