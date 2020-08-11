<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">申请团长列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="head">
								<input type="hidden" name="op" value="wantHead">

								<div class="am-u-sm-12 ">
									<span class="zx-form-span">
										审核状态：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<select name="head_status" data-am-selected="{btnSize: 'sm',placeholder:'请选择审核状态', maxHeight: 400}" style="display: none;">
											<option value="0" <?php  if($_GPC['head_status'] =='0') { ?>selected<?php  } ?>>全部</option>
											<option value="1" <?php  if($_GPC['head_status'] =='1') { ?>selected<?php  } ?>>未审核</option>
											<option value="-2" <?php  if($_GPC['head_status'] =='-2') { ?>selected<?php  } ?>>已审核</option>
										</select>
									</div>
									<!--<span class="zx-form-span">
										编号：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="num" placeholder="编号" value="<?php  echo $_GPC['num'];?>" style="border-radius: 4px;width: 240px;">
									</div>-->
									<span class="zx-form-span">
										用户名：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="title" placeholder="用户名" value="<?php  echo $_GPC['title'];?>" style="border-radius: 4px;width: 240px;">
									</div>

								</div>
								<div class="am-u-sm-12 ">
									<span class="zx-form-span">
										电　　话：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="phone" placeholder="电话" value="<?php  echo $_GPC['phone'];?>" style="border-radius: 4px;width: 240px;">
									</div>
									<span class="zx-form-span">
										姓　名：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="name" placeholder="姓名" value="<?php  echo $_GPC['name'];?>" style="border-radius: 4px;width: 240px;">
									</div>
									<!-- 查询按钮样式 -->
									<div class="zx-but-check">
										<button type="submit" >
											<i class="fa fa-search"></i> 查询
										</button>
									</div>
								</div>
							</form>
							<div class="am-scrollable-horizontal am-u-sm-12">
								<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
									<thead class="navbar-inner">
									<tr>
										<th style="width:50px;">编号</th>
										<th style="width:50px;">头像</th>
										<th style="width:60px;">昵称</th>
										<th style="width:150px;">提交信息</th>
										<th style="width:70px;">审核状态</th>
										<th style="width:120px;">备注</th>
										<th style="width:120px;">处理说明</th>
										<th style="width:150px;">操作</th>
									</tr>
									</thead>
									<tbody>
									<?php  if(!empty($info)) { ?>
									<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
									<tr>
										<td><?php  echo $item['m_id'];?></td>
										<td>
											<img src="<?php  echo $item['m_photo']?>" width="50" style="border-radius: 50%;"/>
										</td>
										<td><?php echo empty($item['m_nickname'])?"暂无":$item['m_nickname']?>
										</td>
										<td>
											姓名：<?php echo empty($item['ah_name'])?"未提交":$item['ah_name']?><br/>
											电话：<?php echo empty($item['ah_phone'])?"未提交":$item['ah_phone']?><br/>
											社区名：<?php echo empty($item['ah_shop_name'])?"未提交":$item['ah_shop_name']?><br/>
											<?php  if(!empty($item['ah_recommend_nickname'])) { ?>
											<span class="text-danger"><b>推荐团长：<?php  echo $item['ah_recommend_nickname'];?></b></span>
											<?php  } ?>
										</td>
										<td>
											<?php  if($item['ah_result'] == 1 ) { ?>
											<span class="text-danger ">未审核</span>
											<?php  } else if($item['ah_result'] == -1) { ?>
											<span class="text-info">拒绝</span>
											<?php  } else if($item['ah_result'] == -2) { ?>
											<span class="text-warning">已通过</span>
											<?php  } ?>
										</td>
										<td><?php echo empty($item['m_comment'])?"暂无":$item['m_comment']?>
										<td><?php echo empty($item['ah_message'])?"<span class='text-danger '>暂无</span>":$item['ah_message']?>
										<td><!--删除可以用ajax实现-->
											<?php  if($item['ah_result'] == 1 ) { ?>
											<a href="<?php  echo $this->createWebUrl('head',array('op'=>'deal','id'=>$item['ah_id']))?>"  class="btn btn-success btn-xs">处理</a>
											<?php  } ?>
											<a href="<?php  echo $this->createWebUrl('head',array('op'=>'info','id'=>$item['ah_id']))?>"  class="btn btn-info btn-xs">详情</a>
											<a class="btn btn-danger btn-xs" onclick="deletes('<?php  echo $item['ah_id'];?>')">删除</a>

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
			layer.msg('非法进入',{icon:2,time:1000});
			return false;
		}
		layer.confirm("确定删除吗？",{icon:3,title:"提示"},function (index) {
            $.post("<?php  echo $this->createWebUrl('head',array('op'=>'del'))?>",{id:id},function(res){
                layer.close(index);
                if(res.status == 0){
                    layer.msg(res.msg,{icon:1,time:1000});
                    setTimeout(function () {
                        location.reload();
                    },1000)
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
        })

	}
</script>
