<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>


	<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">内容管理</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form class="toolbar-form" action="./index.php">
							<input type="hidden" name="c" value="site">
							<input type="hidden" name="a" value="entry">
							<input type="hidden" name="m" value="group_buy">
							<input type="hidden" name="do" value="content">
								<input type="hidden" name="op" value="index">
							<div class="am-u-sm-12 ">
								<div class="am fr">
									<span class="zx-form-span">
										文章标题：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
											<input type="text" class="am-form-field" name="name" placeholder="文章标题" value="<?php  echo $name;?>" style="border-radius: 4px;width: 240px;">
									</div>
									<span class="zx-form-span">
										分类：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<select name="class" data-am-selected="{searchBox: 1, btnSize: &#39;sm&#39;,placeholder:&#39;请选择分类&#39;, maxHeight: 400}" style="display: none;">
											<option value="">请选择...</option>
											<?php  if(is_array($class_info)) { foreach($class_info as $k => $v) { ?>
												<option value="<?php  echo $v['id'];?>" <?php  if($v['id'] == $class) { ?>selected<?php  } ?>><?php  echo $v['title'];?></option>
											<?php  } } ?>
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
								<div class="am-u-sm-12 am-fl">
									<div class="am-btn-group am-btn-group-xs zx-end-checked-box" style="display: none;">
										<button type="button" class="btn btn-danger" id="del-all-checked" href="<?php  echo $this->createWebUrl('content',array('op'=>'del'));?>">
											<i class="fa fa-ca"></i> 删除
										</button>
									</div>
									<div class="am-btn-group am-btn-group-xs">
										<a class="zx-addBut" href="<?php  echo $this->createWebUrl('content',array('op'=>'add'));?>">
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
										<th >标题</th>
										<th >分类</th>
										<!--<th >正文</th>-->
										<th >排序</th>
										<th >时间</th>
										<th >状态</th>
										<th >操作</th>
									</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
									<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
									<tr>
										<td class="am-text-middle"><?php  echo $item['title'];?></td>
										<td class="am-text-middle"><?php  echo $item['ac_title'];?></td>
										<!--<td class="am-text-middle" title="<?php  echo html_entity_decode($item['body']);?>"><?php  echo mb_substr(html_entity_decode($item['body']),0,20);?></td>-->
										<td class="am-text-middle"><?php  echo $item['sort'];?></td>
										<td class="am-text-middle"><?php  echo date('Y-m-d H:i:s',$item['createtime']);?></td>
										<td class="am-text-middle">
											<?php  if($item['status'] == 1) { ?>
											<a onclick="setOnline('<?php  echo $item['id'];?>')"  class="btn btn-info btn-xs">
												显示
											</a>
											<?php  } else if($item['status'] == -1) { ?>
											<a onclick="setOnline('<?php  echo $item['id'];?>')"  class="btn btn-warning btn-xs">
												隐藏
											</a>
											<?php  } ?>
										</td>
										<td class="am-text-middle"><!--删除可以用ajax实现-->
											<a href="<?php  echo $this->createWebUrl('content',array('op'=>'add','id'=>$item['id']))?>"  class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> 修改</a>
											<a class="btn btn-danger btn-xs" onclick="deletes('<?php  echo $item['id'];?>');"><i class="fa fa-trash-o"></i> 删除</a>
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
            $.post("<?php  echo $this->createWebUrl('content',array('op'=>'del'))?>",{id:id},function(res){
                layer.close(index)
                if(res.status == 0){
                    location.reload();
                }else{
                    layer.msg(res.msg)
                }
            },"JSON")
        });

	}
    function setOnline(id){
		console.log(11)
        if(id == '' || id == undefined){
            layer.msg('非法进入',{icon: 2,time:1000});
            return false;
        }
        $.post("<?php  echo $this->createWebUrl('content',array('op'=>'setAstatus'))?>",{id:id},function(res){
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