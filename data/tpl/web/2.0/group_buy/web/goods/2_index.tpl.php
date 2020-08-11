<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
	/*选项卡*/
	.am-tabs-d2 .am-tabs-nav{
		background: #fff;
		border-bottom: 1px solid #eef1f5;
	}
	.am-tabs-nav{
		display: flex;
		align-items: center;
		justify-content: flex-start;
	}
	.am-tabs .am-tabs-nav li{
		width: 120px;
		line-height: 40px;
		height: 40px;
		padding: 0;
	}
	.am-tabs .am-tabs-nav li a{
		width: 120px;
		line-height: 40px;
		height: 40px;
		padding: 0;
		display: block;
		margin: 0;
		text-align: center;
		background: #fff;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active {
		position: relative;
		background-color: #fcfcfc;
		border-bottom: 2px solid #22c397;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active a{
		color: #22c397;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active:after{
		border-bottom-color: #22c397;
	}
	/*选项卡end*/
	.zx-edit-td-input:focus{
		outline: 1px  dashed #22c397;
	}
	.am-switch-success-zx>input[type=checkbox]:checked~.am-switch-checkbox{
		background: #22c397;
	}
</style>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">商品列表</div>
					</div>
					<div  class="am-tabs am-tabs-d2">
						<ul class="am-tabs-nav am-cf">
							<li class="<?php  if(empty($_GPC['status'])) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('goods',array('op'=>'index'))?>">全部<?php  if(isset($status['0']) ) { ?> ( <?php  echo $status['0'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==10) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('goods',array('op'=>'index','status'=>10))?>">出售中<?php  if(isset($status['10']) ) { ?> ( <?php  echo $status['10'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==20) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('goods',array('op'=>'index','status'=>20))?>">库存预警<?php  if(isset($status['20']) ) { ?> ( <?php  echo $status['20'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==30) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('goods',array('op'=>'index','status'=>30))?>">已下架<?php  if(isset($status['30']) ) { ?> ( <?php  echo $status['30'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==40) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('goods',array('op'=>'index','status'=>40))?>">待审核<?php  if(isset($status['40']) ) { ?> ( <?php  echo $status['40'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==50) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('goods',array('op'=>'index','status'=>50))?>">已拒绝<?php  if(isset($status['50']) ) { ?> ( <?php  echo $status['50'];?> ) <?php  } ?></a></li>
							<li class="<?php  if($_GPC['status']==60) { ?>am-active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('goods',array('op'=>'index','status'=>60))?>">回收站<?php  if(isset($status['60']) ) { ?> ( <?php  echo $status['60'];?> ) <?php  } ?></a></li>
						</ul>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="goods">

								<div class="am-u-sm-12 ">
									<span class="zx-form-span">
										商品名称：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="title" placeholder="商品名称" value="<?php  echo $_GPC['title'];?>" style="border-radius: 4px;width: 240px;">
									</div>
									<span class="zx-form-span">
										商品分类：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<select name="pid" data-am-selected="{searchBox: 1, btnSize: 'sm'	,placeholder:'请选择商品分类', maxHeight: 400}"style="display: none;">
											<option value="">请选择...</option>
											<option value="0" data-level="-1" data-tree="" <?php  if($_GPC['pid'] == 0) { ?>selected<?php  } ?>>全部</option>
											<?php  if(!empty($cate)) { ?>
											<?php  if(is_array($cate)) { foreach($cate as $k => $v) { ?>
											<option value="<?php  echo $v['gc_id'];?>" data-level="<?php  echo $v['gc_level'];?>" data-tree="<?php  echo $v['gc_tree'];?>" <?php  if($_GPC['pid'] == $v['gc_id']) { ?>selected<?php  } ?>><?php  echo str_repeat("&nbsp;&nbsp;&nbsp;",$v['gc_level'])?><?php  echo $v['gc_name'];?></option>
											<?php  } } ?>
											<?php  } ?>
										</select>
									</div>
                                    <span class="zx-form-span">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;状态：
									</span>
                                    <div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
                                        <select name="online" data-am-selected="{ btnSize: 'sm',placeholder:'请选择状态', maxHeight: 400}" style="display: none;">
                                            <option value="">请选择...</option>
                                            <option value="1" <?php  if($_GPC['online'] == 1) { ?>selected<?php  } ?>>上架</option>
                                            <option value="-1" <?php  if($_GPC['online'] == -1) { ?>selected<?php  } ?>>下架</option>
                                        </select>

                                    </div>
                                    <!-- 查询按钮样式 -->
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="zx-but-check">
                                        <button type="submit" >
                                            <i class="fa fa-search"></i> 查询
                                        </button>

                                    </div>

								</div>

							</form>
						</div>
						<div class="am-u-sm-12 am-fl am-margin-bottom-xs">
							<div class="am-btn-group am-btn-group-xs ">
								<a class="zx-addBut" href="<?php  echo $this->createWebUrl('goods',array('op'=>'add'))?>">
									<i class="fa fa-plus"></i> 添加商品
								</a>
							</div>
							<div class="am-btn-group am-btn-group-xs">
								<button type="button" class="btn btn-info" id="all-up">
									<i class="fa fa-check"></i> 批量上架
								</button>
							</div>
							<div class="am-btn-group am-btn-group-xs">
								<button type="button"class="btn btn-warning" id="all-down">
									<i class="fa fa-close"></i> 批量下架
								</button>
							</div>
						</div>
						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap ">
								<thead class="navbar-inner">
								<tr>
									<th >
										<label class="am-checkbox-inline am-success">
											<input type="checkbox"  id="check-all" data-am-ucheck data-id="0">&nbsp;
										</label>
									</th>
									<!--<th >商品货号</th>-->
									<th style="width: 400px;">商品</th>
									<!--<th >分类</th>-->
									<th >排序</th>
									<th >库存</th>
									<th >实际销量</th>
									<th >虚拟销量</th>
									<th >预计佣金</th>
									<th >参与满减</th>
									<th >置顶</th>
									<!--<th >添加时间</th>-->
									<th >操作</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
								<tr>
									<td class="am-text-middle ">
										<label class="am-checkbox-inline am-success">
											<input type="checkbox" data-id="<?php  echo $item['g_id'];?>"  data-am-ucheck class="check-order">&nbsp;
										</label>
									</td>
									<!--<td style="word-wrap:break-spaces;word-break: break-all;"><?php  echo $item['g_product_num'];?></td>-->
									<td >
										<div style="display: flex;align-items: center;max-width: 400px;">
										<a href="<?php  echo tomedia($item['g_icon'])?>" target="_blank"><img src="<?php  echo tomedia($item['g_icon'])?>" width="70"/></a>
										<div style="margin-left: 3px;">
											<span style="width: 300px;display: block;height: 20px;line-height: 20px;" class="zx-edit-td-input">
												<input class="zx-edit-td-input" type="text" value="<?php echo empty($item['g_name'])?'':$item['g_name'];?>" class="" style="border:0;background:transparent;width: 270px;text-align: left;" data-id="<?php  echo $item['g_id'];?>" data-key="g_name" data-val="<?php  echo $item['g_name'];?>">
												<?php  if($item['g_is_near_recommend']==1) { ?>
											<span class="am-badge am-badge-success am-round">邻居</span>
												<?php  } ?>
											</span>

											<span class="text-danger">
											<?php  foreach($cate as $k => $val){ ?>
												<?php  if(in_array($val['gc_id'],explode(',',$item['cate']))) { ?>
													[<?php  echo $val['gc_name'];?>]
												<?php  } ?>
											<?php  } ?>
											</span>
											<br>
											<span style="color: #E97312;font-weight: 600;display: flex;align-items: center;">￥<input class="zx-edit-td-input" type="number" value="<?php echo empty($item['g_price'])?'0.00':$item['g_price'];?>" class="" style="border:0;background:transparent;width: 100px;text-align: left;" data-id="<?php  echo $item['g_id'];?>" data-key="g_price" data-val="<?php  echo $item['g_price'];?>"></span>
										</div>
										</div>
									</td>
									<!--<td><?php  echo $item['gc_name'];?></td>-->
									<td>
									<input class="zx-edit-td-input" type="text" value="<?php echo empty($item['g_order'])?0:$item['g_order'];?>" class="" style="border:0;background:transparent;width: 30px;text-align: left;" data-id="<?php  echo $item['g_id'];?>" data-key="g_order" data-val="<?php  echo $item['g_order'];?>">
									</td>
									<td><?php  $array_sum =  array_sum(explode(",",$item['sum']));?>

										<?php  if($array_sum <=$item['g_stock_notice'] ) { ?>
										<span class="text-danger"><?php  echo $array_sum;?> <i class="fa fa-warning" ></i></span>
										<?php  } else { ?>
											<span class="" <?php  if($item['g_has_option'] == 1) { ?> onclick="has_option(<?php  echo $item['g_id'];?>,this)" style="cursor:pointer" <?php  } ?>><?php  echo $array_sum;?></span>
										<?php  } ?>
									</td>
									<td><?php  echo $item['sum_sale'];?></td>
									<td><?php  echo $item['g_sale_num'];?>
									</td>
									<td class="text-danger">￥<?php  echo sprintf('%.2f',$item['g_price']*$item['g_commission']/100);?></td>
									<td>
										<?php  if($is_open_full_reduction ==1 ) { ?>
										<div class="tpl-switch">
											<input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="type" data-id="<?php  echo $item['g_id'];?>" data-type="g_is_full_reduce" data-state="<?php  if($item['g_is_full_reduce']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($item['g_is_full_reduce']==1) { ?> checked="" <?php  } ?>>
											<div class="tpl-switch-btn-view">
												<div>

												</div>
											</div>
										</div>
										<?php  } else { ?>
										<div class="tpl-switch">
											<input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="type" data-id="<?php  echo $item['g_id'];?>" data-type="g_is_full_reduce" data-state="<?php  if($item['g_is_full_reduce']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($item['g_is_full_reduce']==1) { ?> checked="" <?php  } ?>  onclick="layer.msg('请先开启满减活动后再设置！');return false;">
											<div class="tpl-switch-btn-view">
												<div>

												</div>
											</div>
										</div>
										<?php  } ?>
									</td>
									<td>

										<div class="tpl-switch">
											<input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="type" data-id="<?php  echo $item['g_id'];?>" data-type="g_is_top" data-state="<?php  if($item['g_is_top']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($item['g_is_top']==1) { ?> checked="" <?php  } ?>>
											<div class="tpl-switch-btn-view">
												<div>

												</div>
											</div>
										</div>
									</td>
									<!--<td><?php  echo date('Y-m-d H:i:s',$item['g_add_time'])?></td>-->
									<td><!--删除可以用ajax实现-->
                                        <a href="<?php  echo $this->createWebUrl('goods',array('op'=>'add','id'=>$item['g_id']))?>"  class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> 修改</a>
										<?php  if($_GPC['status']==60 || $item['g_is_del']==2) { ?>

										<a onclick="setOnline('<?php  echo $item['g_id'];?>')"  >
											<?php  if($item['g_is_online'] == 1) { ?>
											<span class="btn btn-info btn-xs"><i class="fa fa-chevron-down"></i> 已上架</span>
											<?php  } else { ?>
											<span class="btn btn-warning btn-xs"><i class="fa fa-chevron-up"></i> 去上架</span>
											<?php  } ?>
										</a>
                                            <?php  if($this->supplier_role==0 ) { ?>
                                            <a class="btn btn-success btn-xs" onclick="nodeletes('<?php  echo $item['g_id'];?>')"><i class="fa fa-mail-reply-all"></i> 恢复</a>
                                            <a class="btn btn-danger btn-xs" onclick="realdeletes('<?php  echo $item['g_id'];?>')"><i class="fa fa-trash"></i> 彻底删除</a>
                                            <?php  } ?>
                                        <?php  } else if(($_GPC['status']==40 || $item['g_is_del']==3 ) && $this->supplier_role==0) { ?>
                                        <a class="btn btn-success btn-xs" onclick="nodeletes('<?php  echo $item['g_id'];?>')"><i class="fa fa-check"></i> 通过</a>
                                        <a class="btn btn-warning btn-xs click-change" data-id="<?php  echo $item['g_id'];?>" data-type="g_is_del" data-state="4"><i class="fa fa-close"></i> 拒绝</a>
                                        <?php  } else if($_GPC['status']==50 || $item['g_is_del']==4 ) { ?>
                                            <?php  if($this->supplier_role==0) { ?>
                                            <a class="btn btn-success btn-xs" onclick="nodeletes('<?php  echo $item['g_id'];?>')"><i class="fa fa-check"></i> 通过</a>
                                            <?php  } ?>
                                        <a class="btn btn-danger btn-xs" onclick="deletes('<?php  echo $item['g_id'];?>')"><i class="fa fa-trash-o"></i> 删除</a>
                                        <?php  } else { ?>
										<a onclick="setOnline('<?php  echo $item['g_id'];?>')"  >
											<?php  if($item['g_is_online'] == 1) { ?>
											<span class="btn btn-info btn-xs"><i class="fa fa-chevron-down"></i>已上架</span>
											<?php  } else { ?>
											<span class="btn btn-warning btn-xs"><i class="fa fa-chevron-up"></i>去上架</span>
											<?php  } ?>
										</a>
										<a class="btn btn-danger btn-xs" onclick="deletes('<?php  echo $item['g_id'];?>')"><i class="fa fa-trash-o"></i> 删除</a>
										<?php  } ?>
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

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
	function deletes(id){
        if(id == '' || id == undefined){
            layer.msg('非法进入',{icon: 2,time:1000});
            return false;
        }
        layer.confirm('确定删除？',{icon:3,title:'提示'},function (index) {
            $.post("<?php  echo $this->createWebUrl('goods',array('op'=>'del'))?>",{id:id},function(res){
                layer.close(index);
                if(res.status == 0){
                    layer.msg(res.msg,{icon: 1,time:1000});
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                    layer.msg(res.msg,{icon: 2,time:1000});
                }
            },"JSON")
        })

    }
    function setOnline(id){
        if(id == '' || id == undefined){
            layer.msg('非法进入',{icon: 2,time:1000});
            return false;
        }
        $.post("<?php  echo $this->createWebUrl('goods',array('op'=>'setOnline'))?>",{id:id},function(res){
            if(res.status == 0){
                layer.msg(res.msg,{icon: 1,time:1000});
                setTimeout(function(){
                    location.reload();
                }, 1000);
            }else{
                layer.msg(res.msg,{icon: 2,time:1000});
            }
        },"JSON")
		return false;
    }
    //批量上架
    $(document).on("click","#all-up",function () {
        var id = '';
        $(".check-order:checked").each(function () {
            id +=$(this).attr("data-id")+',';
        });
        var acid =  $(".check-order:checked").attr("data-atid");
        $.post("<?php  echo $this->createWebUrl('goods',array('op'=>'setOnlines'))?>",{id:acid,gid:id,act:'up'},function(res){

            if(res.status == 0){
                layer.msg(res.msg)
                setTimeout(function () {
                    location.href = "<?php  echo $this->createWebUrl('goods',array('op'=>'index','page'=>$_GPC['page']))?>";
                },1500)
            }else{
                layer.msg(res.msg)
            }
        },"JSON")
        return false;
    });
    //批量下架
    $(document).on("click","#all-down",function () {
        var id = '';
        $(".check-order:checked").each(function () {
            id +=$(this).attr("data-id")+',';
        });
        $.post("<?php  echo $this->createWebUrl('goods',array('op'=>'setOnlines'))?>",{gid:id,act:'down'},function(res){

            if(res.status == 0){
                layer.msg(res.msg)
                setTimeout(function () {
                    location.href = "<?php  echo $this->createWebUrl('goods',array('op'=>'index','page'=>$_GPC['page']))?>";
                },1500)
            }else{
                layer.msg(res.msg)
            }
        },"JSON")
        return false;
    });
    //勾选本页全部
    $(document).on("click","#check-all",function () {
        if($(this).is(':checked')){
            $(".check-order").prop("checked",true);
        }else{
            $(".check-order").prop("checked",false);
        }
    });
    //监听可修改单元格的值编号
    $(document).on("blur",".zx-edit-td-input",function () {

        var id = $(this).attr("data-id");
        var old = $(this).attr("data-val");
        var now = $(this).val();
        var key = $(this).attr("data-key");
        console.log(now)
        console.log(old)
        if( old == now ){
            return false;
        }else if( $.trim(now) != '' && $.trim(now)!=undefined ){
            $.post("<?php  echo $this->createWebUrl('goods',array('op'=>'editText'))?>", {id: id,val:now,key:key}, function (res) {
                if(res.status === 0){
                    layer.msg(res.msg, {
                        icon: 1
                    });
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
					// if(key=='g_order'){
                    //     setTimeout(function(){
                    //             location.reload();
                    //         }, 1000);
					// }else{
                    //     $(this).val(res.data.val);
                    //     $(this).attr("data-val",res.data.val);
					// }

                }else if(res.status === 1){
                    layer.msg(res.msg, {
                        icon: 2
                    });
                }
            }, "JSON");
        }
    })
	//开关切换
    $(document).on("change","input[name='type']",function (res) {

        var data = $(this).data();
        $.post("<?php  echo $this->createWebUrl('goods',array('op'=>'state'))?>", {
            goods_id: data.id,
            val: data.state,
            type: data.type,
        }, function (result) {
            result.status === 0 ? layer.msg(result.msg, {
                icon: 1
            }) : layer.msg(result.msg, {
                icon: 2
            });
            setTimeout(function () {
                location.reload();
            },1500);

        }, "JSON");
    });
    //快捷改状态
    $(document).on("click",".click-change",function (res) {

        var data = $(this).data();
        $.post("<?php  echo $this->createWebUrl('goods',array('op'=>'state'))?>", {
            goods_id: data.id,
            val: data.state,
            type: data.type,
        }, function (result) {
            result.status === 0 ? layer.msg(result.msg, {
                icon: 1
            }) : layer.msg(result.msg, {
                icon: 2
            });
            setTimeout(function () {
                location.reload();
            },1500);

        }, "JSON");
    });
    //恢复
	function nodeletes(id) {
        if(id == '' || id == undefined){
            layer.msg('非法进入',{icon: 2,time:1000});
            return false;
        }
        $.post("<?php  echo $this->createWebUrl('goods',array('op'=>'state'))?>", {
            goods_id: id,
            val: 1,
            type: 'g_is_del',
        }, function (result) {
            result.status === 0 ? layer.msg(result.msg, {
                icon: 1
            }) : layer.msg(result.msg, {
                icon: 2
            });
            setTimeout(function () {
                location.reload();
            },1500);

        }, "JSON");
    }
    //彻底删除
	function  realdeletes(id) {
        if(id == '' || id == undefined){
            layer.msg('非法进入',{icon: 2,time:1000});
            return false;
        }
        layer.confirm('确定彻底删除，无法恢复？',{icon:3,title:'提示'},function (index) {
            $.post("<?php  echo $this->createWebUrl('goods',array('op'=>'realdel'))?>",{id:id},function(res){
                layer.close(index);
                if(res.status == 0){
                    layer.msg(res.msg,{icon: 1,time:1000});
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                    layer.msg(res.msg,{icon: 2,time:1000});
                }
            },"JSON")
        })
    }
	function has_option(id,obj){
		console.log(id);
		$.post("<?php  echo $this->createWebUrl('goods',array('op'=>'id_option'))?>",{id:id},function(res){
			layer.open({
			  type: 1,
			  skin: 'layui-layer-rim', //加上边框
			  area: ['1100px', '500px'], //宽高
			  content: res,
			});
		},"text");
	}
</script>