<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">交易流水列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form class="toolbar-form" action="./index.php">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="finance">
								<input type="hidden" name="op" value="stream_commission">
								<div class="am-u-sm-12 ">
									<span class="zx-form-span">
										订单号：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="order" placeholder="订单号" value="<?php  echo $order;?>" style="border-radius: 4px;width: 240px;">
									</div>
									<span class="zx-form-span">
										流水号：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="num" placeholder="流水号" value="<?php  echo $num;?>" style="border-radius: 4px;width: 240px;">
									</div>
									<span class="zx-form-span">
										团长：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="team" placeholder="团长" value="<?php  echo $team;?>" style="border-radius: 4px;width: 240px;">
									</div>

										<!-- 查询按钮样式 -->
										<div class="zx-but-check">
											<button type="submit" >
												<i class="fa fa-search"></i> 查询
											</button>
										</div>
								</div>

							</form>
						</div>
						<div class="am-u-sm-12 am-fl am-margin-bottom-xs">
							<div class="am-btn-group am-btn-group-xs">
								<button type="button" class="btn btn-info" id="all-sure">
									<i class="fa fa-check"></i> 批量审核
								</button>
							</div>
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
									<th>团长</th>
									<th>流水号</th>
									<th>佣金</th>
									<th>实收金额</th>
									<th>买家</th>
									<th>状态</th>
									<th>生成时间</th>
									<th>备注</th>
									<th>操作</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $item) { ?>
								<tr>
									<td class="am-text-middle ">
										<label class="am-checkbox-inline am-success">
											<input type="checkbox" data-id="<?php  echo $item['gos_id'];?>"  data-am-ucheck class="check-order">&nbsp;
										</label>
									</td>
									<td class="am-text-middle">
										<?php  echo $item['gos_team'];?>
									</td>
									<td class="am-text-middle">
										<?php  echo $item['gos_code'];?><br/>
										订单号:<?php  echo $item['gos_go_code'];?>
									</td>
									<td class="am-text-middle">
										<?php  echo $item['gos_order_money'];?>
									</td>
									<td class="am-text-middle">
										<?php  if($item['gos_status']==2) { ?>
										<?php  if($item['gos_type']==2) { ?>
										<span class="am-text-success">+<?php  echo $item['gos_real_money'];?></span>
										<?php  } else { ?>
										<span class="am-text-danger">-<?php  echo $item['gos_real_money'];?></span>
										<?php  } ?>
										<?php  } else { ?>
										0.00
										<?php  } ?>
									</td>
									<td class="am-text-middle">
										<?php  echo $item['gos_payer'];?>
									</td>
									<td class="am-text-middle">
										<?php  if($item['gos_status']==1) { ?>
											生成
										<?php  } else if($item['gos_status']==-1) { ?>
										<span class="am-text-danger">拒绝</span>
										<?php  } else if($item['gos_status']==2) { ?>
										<span class="am-text-success">成功</span>
										<?php  } ?>
									</td>
									<td class="am-text-middle">
										<?php  echo date("Y-m-d H:i:s",$item['gos_add_time']);?>
									</td>
									<td class="am-text-middle">
										<?php  echo $item['gos_commet'];?>
									</td>
									<td>
										<?php  if($item['gos_status'] == 2 || $item['gos_status'] == -1) { ?>
										<a href="javascript:;"  class="btn btn-warning btn-xs">已审核</a>
										<?php  } else if($item['gos_status'] == 1  ) { ?>
										<a href="<?php  echo $this->createWebUrl('head',array('op'=>'setCommission','id'=>$item['go_id'],'openid'=>$item['openid'],'act'=>'stream'))?>"  class="btn btn-success btn-xs">审核</a>
										<?php  } ?>
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


</div>
<script>
    //勾选本页全部
    $(document).on("click","#check-all",function () {
        if($(this).is(':checked')){
            $(".check-order").prop("checked",true);
        }else{
            $(".check-order").prop("checked",false);
        }
    });
    //批量审核
    $(document).on("click","#all-sure",function () {
        var id = '';
        $(".check-order:checked").each(function () {
            id +=$(this).attr("data-id")+',';
        });
        // var acid =  $(".check-order:checked").attr("data-atid");
        $.post("<?php  echo $this->createWebUrl('finance',array('op'=>'batchAudit'))?>",{ids:id},function(res){
            if(res.status == 0){
                layer.msg(res.msg)
                setTimeout(function () {
                    location.href = "<?php  echo $this->createWebUrl('finance',array('op'=>'stream_commission','page'=>$_GPC['page']))?>";
                },1500)
            }else{
                layer.msg(res.msg)
            }
        },"JSON")
        return false;
    });
</script>
<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
