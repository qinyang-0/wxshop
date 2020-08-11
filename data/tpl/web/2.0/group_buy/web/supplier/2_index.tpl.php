<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">供应商列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form class="toolbar-form" action="./index.php">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="supplier">
								<div class="am-u-sm-12 ">
									<span class="zx-form-span">
										供应商名称：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="name" placeholder="供应商名称" value="<?php  echo $name;?>" style="border-radius: 4px;width: 240px;">
									</div>
										<!--<div class="am-form-group am-fl">-->
											<!--<div class="am-input-group am-input-group-sm tpl-form-border-form">-->
												<!--<input type="text" class="am-form-field" name="name" placeholder="供应商名称" value="<?php  echo $name;?>" style="border-radius: 4px;width: 240px;">-->
											<!--</div>-->
										<!--</div>-->
										<!-- 查询按钮样式 -->
										<div class="zx-but-check">
											<button type="submit" >
												<i class="fa fa-search"></i> 查询
											</button>
										</div>
								</div>
								<!-- 订单导出外层Box -->
								<?php  if($this->supplier_role==0) { ?>
								<div class="am-u-sm-12 am-fl">
									<div class="am-btn-group am-btn-group-xs">
										<a class="zx-addBut" href="<?php  echo $this->createWebUrl('supplier',array('op'=>'add'));?>">
											<i class="fa fa-plus"></i> 新增
										</a>
									</div>
									<div class="am-btn-group am-btn-group-xs">
										<button type="button" class="btn btn-info" id="all-up">
											<i class="fa fa-check"></i> 审核通过
										</button>
									</div>
									<div class="am-btn-group am-btn-group-xs">
										<button type="button"class="btn btn-warning" id="all-down">
											<i class="fa fa-close"></i> 冻结帐号
										</button>
									</div>
								</div>
								<?php  } ?>
							</form>
						</div>

						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
								<thead>
								<tr>

									<th >
										<label class="am-checkbox-inline am-success">
											<input type="checkbox"  id="check-all" data-am-ucheck data-id="0">&nbsp;
										</label>
									</th>
									<th>供应商名称</th>
									<th>供应商图标</th>
									<!--<th>负责人</th>-->
									<!--<th>电话</th>-->
									<!--<th>备注</th>-->
									<th>商品数量</th>
									<th>排序</th>
									<th>申请人</th>
									<th>申请时间<br/>审核时间</th>
									<?php  if($this->supplier_role==0) { ?>
									<th>状态</th>
									<?php  } ?>
									<th>操作</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $item) { ?>
								<tr>
									<td class="am-text-middle ">
										<label class="am-checkbox-inline am-success">
											<input type="checkbox" data-id="<?php  echo $item['gsp_id'];?>" data-status="<?php  echo $item['gsp_status'];?>" data-am-ucheck class="check-order">&nbsp;
										</label>
									</td>
									<td class="am-text-middle">
										名称：<?php  echo $item['gsp_shop_name'];?>
										<br/>
										负责人：<?php  echo $item['gsp_name'];?>
										<br/>
										电话：<?php  echo $item['gsp_phone'];?>
										<br/>

									</td>
									<td class="am-text-middle">
										<img src="<?php  echo tomedia($item['gsp_icon'])?>" width="50"/>
									</td>
									<td class="am-text-middle">
										<?php echo empty($item['count'])?0:$item['count'];?>
									</td>
									<!--<td class="am-text-middle">-->
									<!--</td>-->
									<td class="am-text-middle zx-edit-td">
										<input class="zx-edit-td-input" type="text" value="<?php echo empty($item['gsp_order'])?0:$item['gsp_order'];?>" class="" style="background: #fff;border: 1px dashed #999;width: 50px;text-align: center;" data-id="<?php  echo $item['gsp_id'];?>" data-val="<?php  echo $item['gsp_order'];?>">
									</td>
									<td class="am-text-middle">
										<?php echo empty($item['m_nickname'])?'后台管理员':$item['m_nickname'];?>
									</td>
									<td class="am-text-middle">
										申请：<?php echo  empty($item['gsp_add_time'])?'':date("Y-m-d H:i:s",$item['gsp_add_time']);?>
										<br/>
										审核：<?php echo  empty($item['gsp_deal_time'])?'':date("Y-m-d H:i:s",$item['gsp_deal_time']);?>
									</td>
									<?php  if($this->supplier_role==0) { ?>
									<td class="am-text-middle">
										<?php  if($item['gsp_status'] == -1 ) { ?>
										<button type="button" class="btn btn-xs btn-default deal_action" data-id="<?php  echo $item['gsp_id'];?>" data-value="1" data-status="-1">未审核</button>
										<?php  } else if($item['gsp_status'] == 1 ) { ?>
										<button type="button" class="btn btn-xs btn-success deal_action" data-id="<?php  echo $item['gsp_id'];?>" data-value="2" data-status="1">已审核</button>
										<?php  } else if($item['gsp_status'] == 2 ) { ?>
										<button type="button" class="btn btn-xs btn-danger deal_action" data-id="<?php  echo $item['gsp_id'];?>" data-value="1" data-status="2">已冻结</button>
										<?php  } ?>
									</td>
									<?php  } ?>
									<td class="am-text-middle">
										<div class="tpl-table-black-operation">

											<a href="<?php  echo $this->createWebUrl('supplier',array('op'=>'add','id'=>$item['gsp_id']))?>">
											<button type="button" class="btn btn-xs btn-info"  >
												 <i class="am-icon-pencil"></i>
												编辑
											</button>
											</a>

											<?php  if($this->supplier_role==0) { ?>
											<button type="button" href="javascript:;" class="btn btn-xs btn-danger item-delete" data-id="<?php  echo $item['gsp_id'];?>">
												 <i class="am-icon-trash"></i>
												删除
											</button>
											<?php  } ?>
										</div>
										<!--&nbsp;-->
										<!--<br/>-->
										<!--<div>-->
											<?php  if($item['gsp_status'] == -1 ) { ?>
											<!--<button type="button" href="javascript:;" class="btn btn-xs btn-success deal_action" data-id="<?php  echo $item['gsp_id'];?>" data-value="1">-->
												<!--<i class="fa fa-check"></i>-->
												<!--通过-->
											<!--</button>-->
											<!--<button type="button" href="javascript:;" class="btn btn-xs btn-warning deal_action" data-id="<?php  echo $item['gsp_id'];?>" data-value="2">-->
												<!--<i class="fa fa-close"></i>-->
												<!--拒绝-->
											<!--</button>-->
											<?php  } ?>
											<!--<a class="btn btn-danger btn-xs" onclick="if(confirm('是否删除?')){deletes('<?php  echo $item['gsp_id'];?>')}else{return false;}">删除</a>-->
										<!--</div>-->
									</td>

								</tr>

								<?php  } } ?>
								<?php  } else { ?>
								<tr>
									<td colspan="10" style="text-align: center;">暂无数据</td>
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
	<script>
        $(function () {
            // 删除元素
            $(document).on('click','.item-delete',function () {
                var id = $(this).data('id');
                layer.confirm('一但删除将无法恢复，确定删除吗？', {
                    title: '友情提示'
                }, function (index) {
                    $.post("<?php  echo $this->createWebUrl('supplier',array('op'=>'del'))?>", {
                        id: id,
                    }, function (res) {
                        if(res.status === 0){
                            layer.msg(res.msg, {
                                icon: 1
                            });
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
						}else if(res.status === 1){
                            layer.msg(res.msg, {
                                icon: 2
                            });
						}
						layer.close(index);
                    }, "JSON");
                })
            });
            // 切换数据状态
            $(document).on('click','.deal_action',function () {
                var id = $(this).data('id');
                var val = $(this).attr('data-value');
                var status = $(this).attr('data-status');
				$.post("<?php  echo $this->createWebUrl('supplier',array('op'=>'deal_action'))?>", {
					id: id,val:val,status:status
				}, function (res) {
					if(res.status === 0){
						layer.msg(res.msg, {
							icon: 1
						});
						setTimeout(function(){
							location.reload();
						}, 1000);
					}else if(res.status === 1){
						layer.msg(res.msg, {
							icon: 2
						});
					}
					layer.close(index);
				}, "JSON");
            });

            //勾选本页全部
            $(document).on("click","#check-all",function () {
                if($(this).is(':checked')){
                    $(".check-order").prop("checked",true);
                }else{
                    $(".check-order").prop("checked",false);
                }
            });
            //审核通过
            $(document).on("click","#all-up",function () {
                var id = '';
                var status = '';
                $(".check-order:checked").each(function () {
                    id +=$(this).attr("data-id")+',';
					status += $(this).attr('data-status')+',';
                });
                var acid =  $(".check-order:checked").attr("data-atid");
                $.post("<?php  echo $this->createWebUrl('supplier',array('op'=>'all_deal_action'))?>",{id:id,status:status,val:1},function(res){

                    if(res.status == 0){
                        layer.msg(res.msg)
                        setTimeout(function () {
                            location.href = "<?php  echo $this->createWebUrl('supplier',array('op'=>'index','page'=>$_GPC['page']))?>";
                        },1500)
                    }else{
                        layer.msg(res.msg)
                    }
                },"JSON")
                return false;
            });
            //冻结
            $(document).on("click","#all-down",function () {
                var id = '';
                var status = '';
                $(".check-order:checked").each(function () {
                    id +=$(this).attr("data-id")+',';
                    status += $(this).attr('data-status')+',';
                });
                var acid =  $(".check-order:checked").attr("data-atid");
                $.post("<?php  echo $this->createWebUrl('supplier',array('op'=>'all_deal_action'))?>",{id:id,status:status,val:2},function(res){
                    if(res.status == 0){
                        layer.msg(res.msg)
                        setTimeout(function () {
                            location.href = "<?php  echo $this->createWebUrl('supplier',array('op'=>'index','page'=>$_GPC['page']))?>";
                        },1500)
                    }else{
                        layer.msg(res.msg)
                    }
                },"JSON")
                return false;
            });

		});
	</script>

</div>
<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
