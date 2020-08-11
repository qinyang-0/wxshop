<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">路线列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="distribution">
								<input type="hidden" name="op" value="route">
								<div class="am-u-sm-12 ">
									<div class="am fr">

										<div class="am-form-group am-fl">
											<div class="am-input-group am-input-group-sm tpl-form-border-form">
												<input type="text" class="am-form-field" name="title" placeholder="路线名称" value="<?php  echo $title;?>" style="border-radius: 4px;width: 240px;">
											</div>
										</div>
										<span class="zx-form-span">
										配送员：
										</span>
										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
											<input class="am-form-field zx-butInput" name="people" type="text" value="<?php  echo $people;?>" placeholder="配送员">
										</div>

										<span class="zx-form-span">
										联系电话:
										</span>
										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
											<input class="am-form-field zx-butInput" name="phone" type="text" value="<?php  echo $phone;?>" placeholder="联系电话">
										</div>

										<!-- 查询按钮样式 -->
										<div class="zx-but-check">
											<button type="submit" >
												<i class="fa fa-search"></i> 查询
											</button>
										</div>
									</div>
								</div>

								<!-- 订单导出外层Box -->
								<div class="am-u-sm-12 am-fl">

									<div class="am-btn-group am-btn-group-xs">
										<a class="zx-addBut" href="<?php  echo $this->createWebUrl('distribution',array('op'=>'routeAdd'));?>">
											<i class="fa fa-plus"></i> 新增
										</a>
									</div>
								</div>

							</form>
						</div>

						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
								<thead class="navbar-inner">
								<tr>
									<th style="width:100px;">路线名称</th>
									<th style="width:100px;">配送员</th>
									<th style="width:100px;">联系电话</th>
									<th style="width:80px;">配送店铺数</th>
									<th style="width:150px;">操作</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td><?php  echo $deafalt['dr_name'];?></td>
									<td><?php  echo $deafalt['dr_people'];?></td>
									<td><?php  echo $deafalt['dr_phone'];?></td>
									<td>
										<!--<a href="" target="_blank">-->
										<?php  echo $deafalt['dr_num'];?>
										<!--</a>-->
									</td>
									<td><!--删除可以用ajax实现-->

										<span class="text-danger">系统预定，避免没路线无法配送</span>
									</td>
								</tr>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
								<tr>
									<td><?php  echo $item['dr_name'];?></td>
									<td><?php  echo $item['dr_people'];?></td>
									<td><?php  echo $item['dr_phone'];?></td>
									<td>
										<!--<a href="" target="_blank">-->
										<?php  echo $item['dr_num'];?>
										<!--</a>-->
									</td>
									<td><!--删除可以用ajax实现-->
										<a href="<?php  echo $this->createWebUrl('distribution',array('op'=>'routeAdd','id'=>$item['dr_id']))?>"  class="btn btn-info btn-xs">修改</a>
										<a class="btn btn-danger btn-xs" onclick="if(confirm('是否删除?')){deletes('<?php  echo $item['dr_id'];?>')}else{return false;}">删除</a>

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


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
	function deletes(id){
		if(id == '' || id == undefined){
            layer.msg('非法进入',{icon:2,time:2000});
			return false;
		}
        layer.confirm("确定删除？",{icon:3,title:'提示'},function (index) {
            $.post("<?php  echo $this->createWebUrl('distribution',array('op'=>'routeDel'))?>",{id:id},function(res){
                layer.close(index);
                if(res.status == 0){
                    layer.msg(res.msg,{icon:1,time:1000});
                    setTimeout(function () {
                        location.reload();
                    },1000)
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON");
        });
	}
</script>