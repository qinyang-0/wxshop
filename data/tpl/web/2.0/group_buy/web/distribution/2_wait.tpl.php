<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<style>
	/*微擎底层时间插件样式*/
	.daterangepicker select.ampmselect, .daterangepicker select.hourselect, .daterangepicker select.minuteselect{
		width: auto;
		padding-right: 40px;
	}
</style>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">等待生成配送单</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="distribution">
								<input type="hidden" name="op" value="wait">
								<div class="am-u-sm-12 ">
									<div class="am fr">

											<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
												<!--<input class="form-control" name="name" id="" type="text" value="<?php  echo $name;?>" placeholder="活动名称">-->
												<input type="text" class="am-form-field" name="title" placeholder="店铺/小区/团长名称" value="<?php  echo $title;?>" style="border-radius: 4px;width: 240px;">

											</div>
											<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 130px;">
												<select name="time_type" data-am-selected="{searchBox: 1, btnSize: 'sm',placeholder:'不按时间查询', maxHeight: 400}" style="display: none;">
													<option value=" ">不按时间查询</option>
													<option value="add_time" <?php  if($_GPC['time_type'] =='add_time') { ?>selected<?php  } ?>>下单时间</option>
													<option value="pay_time" <?php  if($_GPC['time_type'] =='pay_time') { ?>selected<?php  } ?>>支付时间</option>
												</select>
											</div>
											<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group" style="width: 265px">
												<?php echo tpl_form_field_daterange('time', array('start'=> empty($_GPC['time']['start'])?date('Y-m-d',(time()-1*24*60*60)):$_GPC['time']['start'],'end'=> empty($_GPC['time']['end'])?date('Y-m-d',time()):$_GPC['time']['end']),true);?>
											</div>

										<!-- 查询按钮样式 -->
										<div class="zx-but-check">
											<button type="submit" >
												<i class="fa fa-search"></i> 查询
											</button>
										</div>
									</div>
								</div>
								<div class="am-u-sm-12 am-fl am-margin-bottom-xs" >
									<div class="am-btn-group am-btn-group-xs zx-end-checked-box show_down" >
										<span class="btn btn-info all-add"><i class="fa  fa-download"></i> 批量生成清单</span>
										<input type="hidden" class="checked-val" value="">

									</div>
								</div>
							</form>
						</div>

						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
								<thead class="navbar-inner">
								<tr>
									<th >
										<label class="am-checkbox-inline am-success">
											<input type="checkbox"  id="check-all" data-am-ucheck data-id="0">&nbsp;
										</label>
									</th>
									<th >店铺/小区</th>
									<th >团长</th>
									<th >配送线路</th>
									<th >商品总数</th>
									<th >操作</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
								<tr>
									<td class="">
										<label class="am-success am-checkbox-inline">
											<input type="checkbox" data-id="<?php  echo $item['m_id'];?>" class="check-order" data-am-ucheck>
										</label>
									</td>
									<td class="am-text-middle"><?php  echo $item['m_head_shop_name'];?></td>
									<td class="am-text-middle" style="display: flex;align-items: center;">
										<img src="<?php  echo tomedia($item['m_photo']);?>" style="width: 30px;border-radius: 100%;">
										&nbsp;&nbsp;
										<div>
										<?php  echo $item['m_nickname'];?><br/>/<?php  echo $item['m_phone'];?>
										</div>

									</td>
									<td class="am-text-middle"><?php  echo $item['send_route'];?></td>
									<td class="am-text-middle"><?php  echo $item['num'];?></td>

									<td class="am-text-middle"><!--删除可以用ajax实现-->
										<button type="button" class="btn btn-info btn-xs add-list" data-head="<?php  echo $item['m_id'];?>" >生成清单</button>
										<button type="button" class="btn btn-info btn-xs see-goods-info" data-head="<?php  echo $item['m_id'];?>">商品清单</button>
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
							</table>
						</div>

						<div class="am-u-lg-12 am-cf" style="text-align: right;">
							<?php  echo $page;?>
							<!--<div class="am-fr pagination-total am-margin-right">-->
								<!--<div class="am-vertical-align-middle">总记录：<?php  echo $total;?></div>-->
							<!--</div>-->
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
	//查看商品详情
	$(document).on('click','.see-goods-info',function () {
		var m_id = $(this).attr('data-head');
        layer.open({
            title:'商品清单',
            type: 2,
            area: ['750px', '500px'],
            fixed: false, //不固定
            maxmin: true,
            content: "<?php  echo $this->createWebUrl('distribution',array('op'=>'see_goods_info'))?>&m_id="+m_id
        });
    });
    //勾选本页全部
    $(document).on("click","#check-all",function () {
        if($(this).is(':checked')){
            $(".check-order").prop("checked",true);
        }else{
            $(".check-order").prop("checked",false);
        }
        is_show_down();
    });
    //生成清单
    $(document).on('click','.add-list',function () {
        var m_id = $(this).attr('data-head');
        layer.load(0, {shade: [0.5,'#000']});
        $.post("<?php  echo $this->createWebUrl('distribution',array('op'=>'add_list'))?>",{id:m_id},function(res){

        	layer.closeAll();
            if(res.status == 0){
//              layer.msg(res.msg,{icon:1,time:1000});
//              setTimeout(function () {
//                  window.location.href="<?php  echo $this->createWebUrl('distribution',array('op'=>'index'))?>";
//              },1500)
layer.open({
						  content: '<span style="text-align:center;width:100%;display:block;">'+res.msg+'</span>'
						  ,btn: ['继续生成配送单', '配送商品发货']
						  ,yes: function(index, layero){
						    //按钮【按钮一】的回调
						     window.location.reload();
						  }
						  ,btn2: function(index, layero){
						    //按钮【按钮二】的回调
							 window.location.href="<?php  echo $this->createWebUrl('distribution',array('op'=>'index'))?>";
						  }
						//return false 开启该代码可禁止点击该按钮关闭
						  ,cancel: function(){ 
						    //右上角关闭回调
						window.location.reload();
						//return false 开启该代码可禁止点击该按钮关闭
						  }
						});
            }else{
                layer.msg(res.msg,{icon:2,time:1000});
            }
        },"JSON");
	});

    //批量生成清单
    $(document).on('click','.all-add',function () {
        var ids = '';
        $('.check-order:checked').each(function () {
            ids  +=','+$(this).attr('data-id');
        });
        if(ids == '' || ids == undefined){
            layer.msg('未选择任何清单',{icon:2,time:2000});
            return false;
        }
        // layer.confirm("确定开始配送？",{icon:3,title:'提示'},function (index) {
        	layer.load(0, {shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('distribution',array('op'=>'add_list'))?>",{id:ids},function(res){
            	layer.closeAll();
                if(res.status == 0){
//                  layer.msg(res.msg,{icon:1,time:1000});
//                  setTimeout(function () {
                        // location.reload();
                       layer.open({
						  content: '<span style="text-align:center;width:100%;display:block;">'+res.msg+'</span>'
						  ,btn: ['继续生成配送单', '配送商品发货']
						  ,yes: function(index, layero){
						    //按钮【按钮一】的回调
						     window.location.reload();
						  }
						  ,btn2: function(index, layero){
						    //按钮【按钮二】的回调
							 window.location.href="<?php  echo $this->createWebUrl('distribution',array('op'=>'index'))?>";
						  }
						//return false 开启该代码可禁止点击该按钮关闭
						  ,cancel: function(){ 
						    //右上角关闭回调
						window.location.reload();
						//return false 开启该代码可禁止点击该按钮关闭
						  }
						});
                       
//                  },1500)
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON");
        // });
    });
</script>