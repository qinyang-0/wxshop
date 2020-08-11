<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper ">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">账号列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form class="toolbar-form" action="./index.php">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="config">
								<input type="hidden" name="op" value="menu_index">
								<div class="am-u-sm-12 am-u-md-9">
									<div class="am fr">
										<div class="am-form-group am-fl one">
											<input class="form-control" name="username" id="" type="text" value="<?php  echo $username;?>" placeholder="账号">
										</div>
										<div class="am-form-group am-fl">
											<div class="zx-but-check" style="margin-left:8px;">
												<button type="submit">
													查询
												</button>
											</div>
											<div class="zx-but-check" style="margin-left:8px;">
												<a href="<?php  echo $this->createWebUrl('config',array('op'=>'login'))?>" style="color: #495060;">新增账号</a>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
						<form action="#" method="post">
							<div class="am-scrollable-horizontal am-u-sm-12">
								<table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
									<thead>
									<tr>
										<th>ID</th>
										<th>账号</th>
										<th>注册ip</th>
										<th>最后登录ip</th>
										<th>注册日期</th>
										<th>最后访问时间</th>
										<th>管理</th>
									</tr>
									</thead>
									<tbody>
									<?php  if(!empty($info)) { ?>
									<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
									<tr>
										<td class="am-text-middle"><?php  echo $item['uid'];?></td>
										<td class="am-text-middle">
											<?php  echo $item['username'];?>
										</td>
										<td class="am-text-middle">
											<p class="item-title"><?php  echo $item['joinip'];?></p>
										</td>
										<td class="am-text-middle">
											<p class="item-title"><?php  echo $item['lastip'];?></p>
										</td>
										<td class="am-text-middle">
											<?php  echo date('Y-m-d H:i:s',$item['joindate'])?>
										</td>
										<td class="am-text-middle">
											<?php  echo date('Y-m-d H:i:s',$item['lastvisit'])?>
										</td>
										<td class="am-text-middle">
											<div class="tpl-table-black-operation">
												<a href="<?php  echo $this->createWebUrl('config',array('op'=>'add','id'=>$item['uid']))?>">
													菜单授权
												</a>
											</div>
										</td>
									</tr>
									<?php  } } ?>
									<?php  } else { ?>
									<tr>
										<td colspan="9" style="text-align: center;">暂无数据</td>
									</tr>
									<?php  } ?>
									</tbody>
								</table>
							</div>
							<div class="am-u-lg-12 am-cf">
								<div class="am-fr pagination-total am-margin-right">
									<?php  echo $page;?>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 内容区域 end -->
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>