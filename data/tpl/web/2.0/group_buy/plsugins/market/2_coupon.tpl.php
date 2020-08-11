<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">优惠券列表</div>
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
									<span class="zx-form-span">
										优惠券名称：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="name" placeholder="优惠券名称" value="<?php  echo $_GPC['name'];?>" style="border-radius: 4px;width: 240px;">
									</div>
									<!--<div class="am-form-group am-fl">-->
										<!--<label class="am-form-label am-form-label" >名称</label>-->
									<!--</div>-->
									<!--<div class="am-form-group am-fl">-->
										<!--<div class="am-input-group am-input-group-sm tpl-form-border-form">-->
											<!--<input type="text" class="am-form-field" name="name" placeholder="优惠卷名称" value="<?php  echo $_GPC['title'];?>" style="border-radius: 4px;width: 240px;">-->
										<!--</div>-->
									<!--</div>-->
									<!-- 查询按钮样式 -->
									<div class="zx-but-check">
										<button type="submit" >
											<i class="fa fa-search"></i> 查询
										</button>
									</div>
								</div>
							</form>
								<!--<div class="am-u-sm-12 am-fl am-margin-bottom-xs">-->

									<!--<div class="am-btn-group am-btn-group-xs ">-->
										<!--<a class="zx-addBut" href="<?php  echo $this->createWebUrl('market',array('op'=>'add'))?>">-->
											<!--<i class="fa fa-plus"></i> 新增-->
										<!--</a>-->
									<!--</div>-->
								<!--</div>-->
							<div class="am-u-sm-12 am-fl am-margin-bottom-xs">
								<div class="am-btn-group am-btn-group-xs">
									<button type="button" class="btn btn-danger" id="all-del">
										<i class="fa fa-close"></i> 批量删除
									</button>
								</div>
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
											<th >优惠券名称</th>
											<!--<th style="width:80px;">首页显示</th>-->
											<th >面值</th>
											<th >有效时间</th>
											<th >领取限制</th>
											<th>使用条件</th>
											<th >库存</th>
											<th >领取次数</th>
											<th >已使用</th>
											<th >操作</th>
										</tr>
										</thead>
										<tbody>
										<?php  if(!empty($info)) { ?>
										<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
										<tr>
											<td class="am-text-middle ">
												<label class="am-checkbox-inline am-success">
													<input type="checkbox" data-id="<?php  echo $item['id'];?>"  data-am-ucheck class="check-order">&nbsp;
												</label>
											</td>
											<td>
												<?php  echo $item['name'];?>
												<?php  if($item['type'] == 1 ) { ?>
												<span class="am-badge am-badge-primary">通用券</span>
												<?php  } else if($item['type'] == 5) { ?>
												<span class="am-badge am-badge-secondary">分类券</span>
												<?php  } else if($item['type'] == 6) { ?>
												<span class="am-badge am-badge-success">单品券</span>
												<?php  } else if($item['type'] == -1) { ?>
												<span class="am-badge am-badge-warning">指定券</span>
												<?php  } else if($item['type'] == -2) { ?>
												<span class="am-badge am-badge-danger">新人券</span>
												<?php  } ?>
											</td>
											<!--<td>-->
												<?php  if($item['is_index_show'] == 1 ) { ?>
												<!--<span class="text-success">是</span>-->
												<?php  } else { ?>
												<!--<span>否</span>-->
												<?php  } ?>
											<!--</td>-->
											<td><?php  echo $item['cut_price'];?></td>
											<td><?php  echo date('Y-m-d H:i:s',$item['start_time']);?>
												<br><?php  echo date('Y-m-d H:i:s',$item['end_time']);?>
											</td>
											<td><?php  if($item['num_limit'] > 0 ) { ?>
												<?php  echo $item['num_limit'];?>
												<?php  } else { ?>
												无限制
												<?php  } ?>
											</td>
											<td><?php  if($item['use_limit'] > 0 ) { ?>
												满<?php  echo $item['use_limit'];?>使用
												<?php  } else { ?>
												无限制
												<?php  } ?>
											</td>
											<td><?php  echo $item['number']-$item['now_num'];?></td>
											<td><?php  echo $item['now_num'];?></td>
											<td><?php  echo $item['is_use'];?></td>
											<td><!--删除可以用ajax实现-->
												<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'info','tid'=>$item['id']))?>"  class="btn btn-warning btn-xs">领取详情</a>
												<?php  if($item['type'] == 1  ) { ?>
												<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'add','id'=>$item['id']))?>"  class="btn btn-info btn-xs">查看</a>
												<?php  } else if($item['type'] == 5) { ?>
												<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'cate','id'=>$item['id']))?>"  class="btn btn-info btn-xs">查看</a>
												<?php  } else if($item['type'] == 6) { ?>
												<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'only_goods','id'=>$item['id']))?>"  class="btn btn-info btn-xs">查看</a>
												<?php  } ?>
												<?php  if($item['type'] == -1) { ?>
												<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'point','id'=>$item['id']))?>"  class="btn btn-info btn-xs">查看</a>
												<!--<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'point','id'=>$item['id']))?>"  class="btn btn-warning btn-xs">指定</a>-->
												<?php  } ?>
												<?php  if($item['type'] == -2) { ?>
												<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'new_member'))?>"  class="btn btn-info btn-xs">查看</a>
												<?php  } ?>

												<!--<a class="btn btn-danger" onclick="if(confirm('是否删除?')){deletes('<?php  echo $item['id'];?>')}else{return false;}">删除</a>-->

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
		$.post("<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'del'))?>",{id:id},function(res){
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
    //勾选本页全部
    $(document).on("click","#check-all",function () {
        if($(this).is(':checked')){
            $(".check-order").prop("checked",true);
        }else{
            $(".check-order").prop("checked",false);
        }
    });
    //批量删除
    $(document).on("click","#all-del",function () {
        var id = '';
        $(".check-order:checked").each(function () {
            id +=$(this).attr("data-id")+',';
        });
        // var acid =  $(".check-order:checked").attr("data-atid");
        layer.confirm('删除会导致用户无法使用此优惠卷，确定删除吗？', {title: '友情提示'}, function (index) {
            $.post("<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'market_del'))?>",{ids:id},function(res){
                if(res.status == 0){
                    layer.msg(res.msg)
                    setTimeout(function () {
                        location.href = "<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'coupon','page'=>$_GPC['page']))?>";
                    },1500)
                }else{
                    layer.msg(res.msg)
                }
            },"JSON");
		})

        return false;
    });
</script>
