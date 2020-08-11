<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<style>
	/*微擎底层时间插件样式*/
	.daterangepicker select.ampmselect, .daterangepicker select.hourselect, .daterangepicker select.minuteselect{
		width: auto;
		padding-right: 40px;
	}
	.am-ucheck-icons{
		top: -12px;
	}
</style>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">配送单列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
        					<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="distribution">
								<div class="am-u-sm-12 ">

										<span class="zx-form-span">
										&nbsp;配送单号：
										</span>
											<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
												<!--<input class="form-control" name="name" id="" type="text" value="<?php  echo $name;?>" placeholder="活动名称">-->
												<input type="text" class="am-form-field" name="num" placeholder="配送单号" value="<?php  echo $num;?>" style="border-radius: 4px;width: 240px;">
											</div>

									<!--<span class="zx-form-span">-->
										<!--配送路线:-->
										<!--</span>-->
									<!--<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">-->
										<!--<select name="route" class="am-form-field zx-butInput">-->
											<!--<option value="">请选择...</option>-->
											<?php  if(is_array($route)) { foreach($route as $item) { ?>
											<!--<option value="<?php  echo $item['dr_id'];?>" <?php echo $route_check == $item['dr_id'] ?'selected':'';?>><?php  echo $item['dr_name'];?></option>-->
											<?php  } } ?>
										<!--</select>-->
									<!--</div>-->
									<span class="zx-form-span">
										小区：
										</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input class="am-form-field zx-butInput" name="title" type="text" value="<?php  echo $title;?>" placeholder="小区/店铺名">
									</div>
									<span class="zx-form-span">
										时间:
										</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<?php echo tpl_form_field_daterange('time', array('start'=> empty($_GPC['time']['start'])?date('Y-m-d',(time()-31*24*60*60)):$_GPC['time']['start'],'end'=>date('Y-m-d',time())),true);?>
									</div>
									</div>

									<div class="am-u-sm-12">

										<span class="zx-form-span">
										&nbsp;配送状态：
										</span>
										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
											<select name="status" class="am-form-field zx-butInput">
												<option value="0" <?php echo empty($status)?'selected':'';?>>全部</option>
												<option value="10" <?php echo $status == '10' ?'selected':'';?>>未配送</option>
												<option value="20" <?php echo $status == '20' ?'selected':'';?>>已配送</option>
												<option value="30" <?php echo $status == '30' ?'selected':'';?>>已签收</option>
											</select>
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
								<div class="am-u-sm-12 am-fl am-margin-bottom-xs" >
									<div class="am-btn-group am-btn-group-xs zx-end-checked-box show_down" >
										<!--<span class="btn btn-info down-buy-goods"><i class="fa  fa-download"></i> 按商品导出</span>-->
										<!--<span class="btn btn-info down-buy-vg"><i class="fa  fa-download"></i> 按小区/店铺导出</span>-->
										<!--<span class="btn btn-info down-buy-order"><i class="fa  fa-download"></i> 按订单导出</span>-->
										<span class="btn btn-info all-send"><i class="fa  fa-download"></i> 批量出票配送</span>
										<span class="btn btn-info all-send-no"><i class="fa  fa-download"></i> 批量配送</span>
										<span class="btn btn-info all-send-ps"><i class="fa  fa-download"></i> 批量导出配送清单</span>
										<input type="hidden" class="checked-val" value="">
									</div>
								</div>
							</form>
						</div>

						<div class="am-scrollable-horizontal am-u-sm-12">
							<form action="" method="post" >
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
								<thead class="navbar-inner">
								<tr>
									<th style="width:15px;">
										<label class="am-success am-checkbox-inline"><input type="checkbox" id="check-all" data-am-ucheck data-id="0"></label>
									</th>
									<th >配送单号</th>
									<!--<th style="width:100px;">链接类型</th>-->
									<th >店铺/小区</th>
									<th >团长</th>
									<th >配送路线</th>
									<th >配送员</th>

									<th >生成时间/配送时间</th>
									<th >商品总数</th>
									<th >操作</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
								<tr>
									<td class="am-text-middle">
										<label class="am-success am-checkbox-inline">
										<input type="checkbox" data-id="<?php  echo $item['dl_id'];?>" class="check-order" data-am-ucheck>
										</label>
									</td>
									<td class="am-text-middle"><?php  echo $item['dl_code'];?></td>
									<td class="am-text-middle" title="<?php  echo $item['dl_shop_address'];?>"><?php  echo $item['dl_shop_name'];?></td>
									<td class="am-text-middle"><?php  echo $item['m_nickname'];?><br/><?php  echo $item['m_phone'];?></td>
									<td class="am-text-middle"><?php  echo $item['dr_name'];?></td>
									<td class="am-text-middle"><?php  echo $item['dr_people'];?><br/><?php  echo $item['dr_phone'];?></td>

									<td class="am-text-middle">
										<span class="text-info">生成：<?php echo empty($item['dl_add_time'])?'':date('Y-m-d H:i:s',$item['dl_add_time'])?></span>
										<br/>
										<span class="text-success">配送：<?php echo empty($item['dl_send_time'])?'':date('Y-m-d H:i:s',$item['dl_send_time'])?></span>
									</td>
									<td class="am-text-middle"><?php  echo $item['dl_goods_num'];?></td>
									<td class="am-text-middle"><!--删除可以用ajax实现-->
										<?php  if($item['dl_status'] == 10) { ?>
										<a class="btn btn-danger btn-xs" onclick="send('<?php  echo $item['dl_id'];?>')">出票配送</a>
										<a class="btn btn-warning btn-xs" onclick="sendno('<?php  echo $item['dl_id'];?>')">配送</a>
										<?php  } else if($item['dl_status'] == 20) { ?>
										<span class="text-warning"><b>配送中</b></span>
										<?php  } else if($item['dl_status'] == 30) { ?>
										<span class="text-success"><b>已送达</b></span>
										<?php  } ?>
										<span href="<?php  echo $this->createWebUrl('distribution',array('op'=>'goods_list','id'=>$item['dl_id']))?>"  class="btn btn-info btn-xs see-goods-info" data-id="<?php  echo $item['dl_id'];?>">商品清单</span>
										<span class="btn btn-warning btn-xs out-send-list" data-id="<?php  echo $item['dl_id'];?>">导出配送清单</span>
										<span class="btn btn-info btn-xs out-link-order" data-id="<?php  echo $item['dl_id'];?>">导出相关订单</span>
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
							</form>
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
	function send(id){
		if(id == '' || id == undefined){
			layer.msg('非法进入',{icon:2,time:2000});
			return false;
		}
		layer.confirm("确定开始配送？",{icon:3,title:'提示'},function (index) {
			layer.load(0, {shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('distribution',array('op'=>'sureSend','type'=>1))?>",{id:id},function(res){
                layer.closeAll();
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
    function sendno(id){
        if(id == '' || id == undefined){
            layer.msg('非法进入',{icon:2,time:2000});
            return false;
        }
        layer.confirm("确定开始配送？",{icon:3,title:'提示'},function (index) {
        	layer.load(0, {shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('distribution',array('op'=>'sureSend','type'=>2))?>",{id:id},function(res){
                layer.closeAll();
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
    //勾选本页全部
    $(document).on("click","#check-all",function () {
        if($(this).is(':checked')){
            $(".check-order").prop("checked",true);
        }else{
            $(".check-order").prop("checked",false);
        }
        is_show_down();
    });
    //勾选单项
    $(document).on("click",".check-order",function () {
        is_show_down();
    });
    //检查本页全部勾选
    function is_show_down() {
        var count = 0 ;
        var id = '';
		$('.check-order').each(function () {
            if($(this).is(':checked')){
                count++;
                id +=','+$(this).attr('data-id');
            }
        });
		if(count>0){
		    $('.show_down').show();
		}else{
		    $('.show_down').hide();
            $("#check-all").prop("checked",false);
		}
		$('.checked-val').val(id);
    }
    //按商品导出
	$(document).on('click','.down-buy-goods',function () {
		var id = $('.checked-val').val();
        window.location.href="<?php  echo $this->createWebUrl('distribution',array('op'=>'downBuyGoods'))?>&id="+id;

    });
    //按订单导出
    $(document).on('click','.down-buy-order',function () {
        var id = $('.checked-val').val();
        window.location.href="<?php  echo $this->createWebUrl('distribution',array('op'=>'downBuyOrder'))?>&id="+id;
    });
    //按店铺/小区导出
    $(document).on('click','.down-buy-vg',function () {
        var id = $('.checked-val').val();
        window.location.href="<?php  echo $this->createWebUrl('distribution',array('op'=>'downBuyVg'))?>&id="+id;
    });
    //批量出票配送
    $(document).on('click','.all-send',function () {
        var ids = '';
        $('.check-order:checked').each(function () {
			ids  +=','+$(this).attr('data-id');
        });
        if(ids == '' || ids == undefined){
            layer.msg('未选择任何订单',{icon:2,time:2000});
            return false;
        }
        layer.confirm("确定开始配送？",{icon:3,title:'提示'},function (index) {
        	layer.load(0, {shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('distribution',array('op'=>'sureSend','type'=>1))?>",{id:ids},function(res){
                layer.closeAll();
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
	});
    //批量配送
    $(document).on('click','.all-send-no',function () {
        var ids = '';
        $('.check-order:checked').each(function () {
            ids  +=','+$(this).attr('data-id');
        });
        if(ids == '' || ids == undefined){
            layer.msg('未选择任何订单',{icon:2,time:2000});
            return false;
        }
        layer.confirm("确定开始配送？",{icon:3,title:'提示'},function (index) {
        	layer.load(0, {shade: [0.5,'#000']});
            $.post("<?php  echo $this->createWebUrl('distribution',array('op'=>'sureSend','type'=>2))?>",{id:ids},function(res){
                layer.closeAll();
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
    });
    //查看商品清单
    $(document).on('click','.see-goods-info',function () {
        var lid = $(this).attr('data-id');
        layer.open({
            title:'商品清单',
            type: 2,
            area: ['750px', '500px'],
            fixed: false, //不固定
            maxmin: true,
            content: "<?php  echo $this->createWebUrl('distribution',array('op'=>'see_goods_info'))?>&lid="+lid+"&type=2"
        });
    });
    //导出配送清单
    $(document).on('click','.out-send-list',function () {
        var lid = $(this).attr('data-id');
        var url = "<?php  echo $this->createWebUrl('distribution',array('op'=>'out_send_list'))?>&lid="+lid;
		location.href=url;
	});
	//批量导出配送清单
	$(document).on('click','.all-send-ps',function () {
        var ids = '';
        $('.check-order:checked').each(function () {
            ids  += ','+$(this).attr('data-id');
        });
        if(ids == '' || ids == undefined){
            layer.msg('未选择任何订单',{icon:2,time:2000});
            return false;
        }
       	var url = "<?php  echo $this->createWebUrl('distribution',array('op'=>'out_send_list'))?>&lid="+ids;
		location.href=url;
    });
    //导出相关订单
    $(document).on('click','.out-link-order',function () {
        var lid = $(this).attr('data-id');
        var url = "<?php  echo $this->createWebUrl('distribution',array('op'=>'out_link_order'))?>&lid="+lid;
        location.href=url;
    });
</script>
