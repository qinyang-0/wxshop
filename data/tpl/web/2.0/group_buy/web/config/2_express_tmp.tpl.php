<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">快递列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form class="toolbar-form" action="./index.php">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="config">
								<input type="hidden" name="op" value="express_tmp">
								<div class="am-u-sm-12 ">
									<div class="am fr">
										<span class="zx-form-span">
										关键词：
										</span>
										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
												<input type="text" class="am-form-field" name="key" placeholder="关键词" value="<?php  echo $key;?>" style="border-radius: 4px;width: 240px;">
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
									<div class="am-btn-group am-btn-group-xs zx-end-checked-box" style="display: none;">
										<button type="button" class="btn btn-danger" id="del-all-checked" href="<?php  echo $this->createWebUrl('action',array('op'=>'add'));?>">
											<i class="fa fa-trash-o"></i> 删除
										</button>
									</div>
									<div class="am-btn-group am-btn-group-xs">
										<a class="zx-addBut" href="<?php  echo $this->createWebUrl('config',array('op'=>'express_tmp_add'));?>">
											<i class="fa fa-plus"></i> 新增
										</a>
									</div>
								</div>
							</form>
						</div>
						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
								<thead>
								<tr>
									<th><input type="checkbox" value="" name="zx-checked-all" ></th>
									<th>快递名称</th>
									<th>快递类型</th>
									<th>快递简码</th>
									<th>操作</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $item) { ?>
								<tr>
									<td class="am-text-middle">
										<?php  if($item['system']==1) { ?>

										<?php  } else if($item['system']==2) { ?>
										<input type="checkbox" value="<?php  echo $item['id'];?>" class="am-checkbox" name="zx-checked-list">
										<?php  } ?>

									</td>
									<td class="am-text-middle"><?php  echo $item['name'];?></td>
									<td class="am-text-middle">
										<?php  if($item['system']==1) { ?>
										系统快递
										<?php  } else if($item['system']==2) { ?>
										商家快递
										<?php  } ?>
									</td>
									<td class="am-text-middle"><?php  echo $item['simplecode'];?></td>

									<td class="am-text-middle"><!--删除可以用ajax实现-->
										<div class="tpl-table-black-operation">
											<?php  if($item['system']==1) { ?>

											<?php  } else if($item['system']==2) { ?>
											<a href="<?php  echo $this->createWebUrl('config',array('op'=>'express_tmp_add','id'=>$item['id']))?>" >
												<i class="am-icon-pencil"></i>
												编辑
											</a>
											<a href="javascript:;" class="item-delete tpl-table-black-operation-del" data-id="<?php  echo $item['id'];?>">
												<i class="am-icon-trash"></i>
												删除
											</a>
											<?php  } ?>

										</div>
										<!--<a href="<?php  echo $this->createWebUrl('action',array('op'=>'add','id'=>$item['at_id']))?>"  class="btn btn-info btn-xs">修改</a>-->
										<!--<a class="btn btn-danger btn-xs" onclick="if(confirm('是否删除?')){deletes('<?php  echo $item['at_id'];?>')}else{return false;}">删除</a>-->

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
                    $.post("<?php  echo $this->createWebUrl('config',array('op'=>'express_tmp_del'))?>", {
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
            //点击全文删除按钮
            $(document).on('click','#del-all-checked',function () {
                var ids = '';
                $('input[name=zx-checked-list]:checked').each(function () {
					ids += ','+$(this).val();
                });
                $.post("<?php  echo $this->createWebUrl('config',array('op'=>'express_tmp_del'))?>", {id: ids,}, function (res) {
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
                }, "JSON");
            });
            //表格第一行全选或者不全选
			$(document).on('change',"input[name=zx-checked-all]",function () {
				if($(this).is(":checked")){
				    $("input[name=zx-checked-list]").prop("checked",true);
				}else{
                    $("input[name=zx-checked-list]").prop("checked",false);
				}
                seeCheckedBox();
            });
            $(document).on('change',"input[name=zx-checked-list]",function () {
                if($(this).is(":checked")){
                    $('.zx-end-checked-box').show();
                }else{
                    seeCheckedBox();
                }
            });
			//函数，检查是否有选中的多选框，有则显示关联内容
			function seeCheckedBox() {
			    var count = 0;
                $("input[name=zx-checked-list]:checked").each(function () {
					count++;
					return false;
                });
                if( count > 0 ){
					$('.zx-end-checked-box').show();
				}else{
                    $('.zx-end-checked-box').hide();
				}
            }
            //监听可修改单元格的值编号
			$(document).on("blur",".zx-edit-td-input",function () {
			    console.log(1);
			    var id = $(this).attr("data-id");
			   var old = $(this).attr("data-val");
			   var now = $(this).val();
			   if( old == now ){
			       return false;
			   }else if( $.trim(now) != '' && $.trim(now)!=undefined ){
                    $.post("<?php  echo $this->createWebUrl('action',array('op'=>'setOrder'))?>", {id: id,val:now}, function (res) {
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
                    }, "JSON");
			   }
            })
		});
	</script>

</div>
<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
