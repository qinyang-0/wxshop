<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">商品分类</div>
					</div>
					<div class="am-alert am-alert-success"><strong>注：</strong>排序从小到大排列，单击可查看下属分类。</div>
					<div class="am-u-sm-12 am-fl am-margin-bottom-xs">

						<div class="am-btn-group am-btn-group-xs">
							<a class="zx-addBut" href="<?php  echo $this->createWebUrl('goods',array('op'=>'cateAdd'));?>">
								<i class="fa fa-plus"></i> 新增
							</a>
						</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
								<thead class="navbar-inner">
									<tr>
										<th style="width: 100px;">展开(点击)</th>
										<th style="width:200px;">分类名称</th>
										<!--<th style="width:50px;">编号</th>-->
										<!--<th style="width:50px;">图标</th>-->

										<th style="width:100px;">排序</th>
										<th style="width:100px;">分类页显示</th>
										<th style="width:100px;">首页页显示</th>
										<th style="width:150px;">操作</th>
									</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
									<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
									<tr class="show-<?php  echo $item['gc_pid'];?>">
										<td class="get-sub text-info" data-id="<?php  echo $item['gc_id'];?>"><i class="fa fa-plus-square "></i></td>
										<td>
											<?php  if($item['gc_level'] == 1) { ?>
											<b class='line clear-m4'>└─</b>
											<?php  } else if($item['gc_level'] > 1) { ?>
											<b class='line clear-m4'>└─</b><?php  echo str_repeat("<b class='line clear-m4'>&nbsp;──</b>",$item['gc_level']-1)?>
											<?php  } ?>
											<?php  echo $item['gc_name'];?>
										</td>
										<!--<td>-->
											<!--<a href="<?php  echo tomedia($item['gc_icon'])?>" target="_blank"><img src="<?php  echo tomedia($item['gc_icon'])?>" width="50"/></a>-->
											<!--&lt;!&ndash;<img src="/attachment/<?php  echo $item['gc_icon'];?>" width="50"/>&ndash;&gt;-->
										<!--</td>-->

										<td><?php  echo $item['gc_order'];?></td>
										<td>
											<?php  if($item['gc_status']== 1 ) { ?>
											<span class="text-info">√</span>
											<?php  } else { ?>
											<span class="text-danger">×</span>
											<?php  } ?>
										</td>
										<td>
											<?php  if($item['gc_is_index_show']== 1 ) { ?>
											<span class="text-info">√</span>
											<?php  } else { ?>
											<span class="text-danger">×</span>
											<?php  } ?>
										</td>
										<td><!--删除可以用ajax实现-->
											<a href="<?php  echo $this->createWebUrl('goods',array('op'=>'cateAdd','id'=>$item['gc_id']))?>"  class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> 修改</a>
											<a class="btn btn-danger btn-xs" onclick="deletes('<?php  echo $item['gc_id'];?>')"><i class="fa fa-trash-o"></i>删除</a>
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
			layer.msg('非法进入',{icon:2,time: 1000});
			return false;
		}
		layer.confirm("确定删除？",{icon:3,title:"提示"},function (index) {
            $.post("<?php  echo $this->createWebUrl('goods',array('op'=>'cateDel'))?>",{id:id},function(res){
                if(res.status == 0){
                    layer.msg(res.msg,{icon:1,time: 1000});
                    //location.reload();
                    $("td[data-id="+id+"]").parent("tr").remove();
                }else{
                    layer.msg(res.msg,{icon:2,time: 1000});
                }
            },"JSON")
        });

	}
	//点击展开，异步查询下级,展开写了，收还没有写
	$(document).on("click",".get-sub",function () {
		var pid = $(this).attr("data-id");
		if($(this).hasClass("text-info")){
			//$(this).removeClass("fa-plus-square").removeClass("text-info").addClass("text-danger").addClass("fa-minus-square");
            $(this).removeClass("text-info");
			var that = $(this);
			$.post("<?php  echo $this->createWebUrl('goods',array('op'=>'getSub'))?>",{pid:pid,act:'cate'},function (res) {
				if(res.status == 0){
					that.parent("tr").after(res.data);
					//alert(res.msg);
				}else{
					layer.msg(res.msg,{icon:2,time:1000})
				}
			},'JSON');
        }else{
            $(this).addClass("text-info");
            $(".show-"+pid).remove();
            console.log($(".show-"+pid));
            //$(".show-"+pid).remove();
		}
    })
</script>
