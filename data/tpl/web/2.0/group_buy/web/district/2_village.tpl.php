<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">小区列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="district">
								<input type="hidden" name="op" value="village">
								<input type="hidden" name="mid" value="<?php  echo $mid;?>">
								<input type="hidden" name="openid" value="<?php  echo $openid;?>">
								<div class="am-u-sm-12 ">
									<div class="am fr">
										<span class="zx-form-span">
										小区名称：
										</span>
										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
											<input type="text" class="am-form-field" name="title" placeholder="小区名称" value="<?php  echo $_GPC['title'];?>" style="border-radius: 4px;width: 240px;">
										</div>
										<span class="zx-form-span">
										团长：
										</span>
										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
											<input class="am-form-field zx-butInput" name="team" type="text" value="<?php  echo $team;?>" placeholder="团长名称">
										</div>

										<span class="zx-form-span">
										区域：
										</span>
										<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
											<input class="am-form-field zx-butInput" name="location" type="text" value="<?php  echo $location;?>" placeholder="区域关键字">
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
								<!--<div class="am-u-sm-12 am-fl">
									<div class="am-btn-group am-btn-group-xs">
										<a class="zx-addBut" href="<?php  echo $this->createWebUrl('district',array('op'=>'villageAdd'));?>">
											<i class="fa fa-plus"></i> 新增
										</a>
									</div>
								</div>-->
							</form>
						</div>

						<div class="am-scrollable-horizontal am-u-sm-12">
							<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
								<thead class="navbar-inner">
								<tr>
									<th>小区/店铺</th>
									<th>团长</th>
									<th>区域</th>
									<th>详细地址</th>
									<!--<th>添加时间</th>-->
									<th>操作</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(!empty($info)) { ?>
								<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
								<tr>
									<td>
										<span class="text-error"><?php  echo $item['vg_name'];?></span>

									</td>
									<td>
										<span class="text-error"><?php  echo $item['m_nickname'];?></span>
										<!--&nbsp;&nbsp;&nbsp; <?php  echo $item['m_name'];?>-->
									</td>
									<td >
										<div style="text-overflow: ellipsis;white-space:nowrap;overflow:hidden;width: 160px;vertical-align: middle;cursor:pointer;" title="<?php  echo $item['rg_all_area'];?>"><?php  echo $item['rg_all_area'];?></div>
									</td>
									<td >
										<div style="text-overflow: ellipsis;white-space:nowrap;overflow:hidden;width: 160px;vertical-align: middle;cursor:pointer;" title="<?php  echo $item['vg_address'];?>"><?php  echo $item['vg_address'];?></div>
									</td>

									<td><!--删除可以用ajax实现-->
										<?php  if(!empty($openid) ) { ?>
										<a onclick="if(confirm('确定设置?')){setHead('<?php  echo $mid;?>','<?php  echo $item["vg_id"];?>','<?php  echo $openid;?>')}else{return false;}"  class="btn btn-info btn-xs">选取</a>
										<?php  } else { ?>
										<a href="<?php  echo $this->createWebUrl('district',array('op'=>'villageAdd','id'=>$item['vg_id']))?>"  class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> 修改</a>

										<!--删除保留-->
										<!--<a class="btn btn-danger btn-xs" onclick="if(confirm('是否删除?')){deletes('<?php  echo $item['vg_id'];?>')}else{return false;}"><i class="fa fa-trash-o"></i> 删除</a>-->
										<?php  if(!empty($item['openid'])) { ?>
										<!--<a onclick="if(confirm('确定取消?')){cancelHead('<?php  echo $item['vg_id'];?>')}else{return false;}"  class="btn btn-default btn-xs">取消关联</a>-->
										<?php  } else { ?>
										<a href="<?php  echo $this->createWebUrl('head',array('op'=>'index','vg_id'=>$item['vg_id'],'act'=>'linkHead') )?>"  class="btn btn-warning btn-xs">关联团长</a>
										<?php  } ?>
										<?php  } ?>
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
			alert('非法进入');
			return false;
		}
		$.post("<?php  echo $this->createWebUrl('district',array('op'=>'villageDel'))?>",{id:id},function(res){
			if(res.status == 0){
				alert(res.msg);
				location.reload();
			}else{
				alert(res.msg);
			}
		},"JSON")
	}

    function cancelHead(id){
        if(id == '' || id == undefined){
            // $("#modal-communicate .modal-content").html( '非法操作' );
            // $("#modal-communicate").modal("show");
            alert('非法操作');
            return false;
        }

        $.post("<?php  echo $this->createWebUrl('district',array('op'=>'cancelHead'))?>",{id:id},function(res){
            if(res.status == 0){
                alert(res.msg);
                // $("#modal-communicate .modal-content").html(res.msg );
                location.reload();
            }else{
                // $("#modal-communicate .modal-content").html(res.msg );
                //alert(res.msg);
                layer.msg(res.msg);
            }
            // $("#modal-communicate").modal("show");
        },"JSON")
    }
    //关闭模态窗口时清空内容
    $(document).on("hide.bs.modal","#modal-communicate",function(){
        $(".modal-content").html( "" );
    });

    function setHead(id,vg_id,openid){
        if(id == '' || id == undefined){
            // $("#modal-communicate .modal-content").html( '非法操作' );
            // $("#modal-communicate").modal("show");
            alert('非法操作');
            return false;
        }
        console.log(id);
        console.log(vg_id);
        console.log(openid);
        $.post("<?php  echo $this->createWebUrl('member',array('op'=>'setHead'))?>",{id:id,vg_id:vg_id,openid:openid},function(res){
            if(res.status == 0){
                alert(res.msg);
                // $("#modal-communicate .modal-content").html(res.msg );
                location.href="<?php  echo $this->createWebUrl('district',array('op'=>'village'))?>";
            }else{
                // $("#modal-communicate .modal-content").html(res.msg );
                alert(res.msg);
            }
            // $("#modal-communicate").modal("show");
        },"JSON")
    }
</script>
