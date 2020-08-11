<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>

	<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">内容分类管理</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form class="toolbar-form" action="./index.php">
							<input type="hidden" name="c" value="site">
							<input type="hidden" name="a" value="entry">
							<input type="hidden" name="m" value="group_buy">
							<input type="hidden" name="do" value="content">
								<input type="hidden" name="op" value="class">
							<div class="am-u-sm-12 ">
								<div class="am fr">
									<span class="zx-form-span">
										分类名称：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
											<input type="text" class="am-form-field" name="name" placeholder="分类名称" value="<?php  echo $name;?>" style="border-radius: 4px;width: 240px;">
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
									<!--<div class="am-btn-group am-btn-group-xs zx-end-checked-box" style="display: none;">
										<button type="button" class="btn btn-danger" id="del-all-checked" href="<?php  echo $this->createWebUrl('content',array('op'=>'classDel'));?>">
											<i class="fa fa-ca"></i> 删除
										</button>
									</div>-->
									<!--<div class="am-btn-group am-btn-group-xs">
										<a class="zx-addBut" href="<?php  echo $this->createWebUrl('content',array('op'=>'classAdd'));?>">
											<i class="fa fa-plus"></i> 新增
										</a>
									</div>-->
								</div>
							</form>
						</div>



						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
								<thead class="navbar-inner">
									<tr>
										<th >分类名称</th>
										<th >排序</th>
										<th >创建时间</th>
										<th >状态</th>
										<th >操作</th>
									</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
									<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
									<tr>
										<td class="am-text-middle"><a href="<?php  echo $this->createWebUrl('content',array('op'=>'index','class'=>$item['id']))?>" style="color: #22c397;" title="点击查看该分类下的文章"><?php  echo $item['title'];?></a></td>
										<td class="am-text-middle"><?php  echo $item['sort'];?></td>
										<td class="am-text-middle"><?php  echo date('Y-m-d H:i:s',$item['addtime']);?></td>
										<td class="am-text-middle">
                                            <a onclick="setStatus('<?php  echo $item['id'];?>')"  >
                                                <?php  if($item['status'] == 1) { ?>
                                                <span class="btn btn-info btn-xs"> 显示</span>
                                                <?php  } else { ?>
                                                <span class="btn btn-warning btn-xs"> 隐藏</span>
                                                <?php  } ?>
                                            </a>

                                        </td>
										<td class="am-text-middle"><!--删除可以用ajax实现-->
											<a href="<?php  echo $this->createWebUrl('content',array('op'=>'classAdd','id'=>$item['id']))?>"  class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> 修改</a>
											<!--<a class="btn btn-danger btn-xs" onclick="deletes('<?php  echo $item['id'];?>');"><i class="fa fa-trash-o"></i> 删除</a>-->
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
<script type="text/javascript">
	function deletes(id){
		if(id == '' || id == undefined){
			alert('非法进入');
			return false;
		}
        layer.confirm("确定删除？", {icon: 3, title:'提示'}, function(index) {
            $.post("<?php  echo $this->createWebUrl('content',array('op'=>'classDel'))?>",{id:id},function(res){
                layer.close(index)
                if(res.status == 0){
                    location.reload();
                }else{
                    layer.msg(res.msg)
                }
            },"JSON")
        });

	}
    function setStatus(id){
        if(id == '' || id == undefined){
            layer.msg('非法进入',{icon: 2,time:1000});
            return false;
        }
        $.post("<?php  echo $this->createWebUrl('content',array('op'=>'setClassStatus'))?>",{id:id},function(res){
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
</script>
</div>
<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>