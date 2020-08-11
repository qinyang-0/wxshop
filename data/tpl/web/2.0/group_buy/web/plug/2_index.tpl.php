<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
	a {
		color: #333;
		outline: none;
		background-color: transparent;
	}
	a:hover, a:link, a:visited {
		text-decoration: none;
	}
	.pull-left {
		float: left!important;
	}
	.feed-activity-list {
		width: 100%;
		overflow: hidden;
	}
	.feed-element {
		float: left;
		width: 320px;
		height: 100px;
		margin-left: 15px;
		margin-bottom: 20px;
		border: 1px solid #efefef;
		padding: 20px;
	}
	.feed-element img.img-circle, .dropdown-messages-box img.img-circle {
		float: left;
		width: 60px;
		height: 60px;
		border-radius: 4px;
	}
	img {
		padding: 0;
		margin: 0;
		font-size: 12px;
		border: 0px;
		vertical-align: middle;
	}
	.media-body {
		margin-top: 3px;
	}
	.feed-element .title {
		font-size: 14px;
		height: 24px;
		line-height: 24px;
		vertical-align: bottom;
		color: #333;
		font-weight: bold;
		margin-left: 10px;
	}
	
	.plug_header{
		height: 45px;width: 100%;font-size: 16px;line-height: 45px;margin-left: 20px;text-align: left;font-weight: bold;display: inline-block;
	}
	.plug_bottom{
		float: left;width: 100%;display: inline-block;
	}
	.plug_div{
		height:60px;margin: 0 0 20px 20px;background: #f8f8f8;float: left;width: 23%;padding: 10px;
	}
	.float_l{
		float: left;
	}
	.h40{
		height: 40px;
	}
	.plug_bottom_top{
		font-size: 16px;margin-left: 50px;color: #000;width: auto;
	}
	.plug_bottom_tops{
		font-size: 12px;color: #a4a4a4;margin-left: 50px;width: auto;line-height: 20px;
	}
</style>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper no-sidebar-second">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf" style="padding-left: 80px;">
						<div class="widget-title am-cf">营销中心</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<?php  if($contents) { ?>
							<?php  if(is_array($contents)) { foreach($contents as $item) { ?>
								<div class="plug_header">
									<?php  echo $item['name'];?>
								</div>
								<div class="plug_bottom">
									<?php  if(is_array($item['info'])) { foreach($item['info'] as $items) { ?>
										<?php  if($items['is_show'] == 1) { ?>
											<a href="<?php  echo $items['url'];?>">
												<div class="plug_div">
													<div class="float_l">
														<img src="<?php  echo $items['icon'];?>" class="h40" alt="<?php  echo $items['name'];?>"/>
													</div>
													<div class="plug_bottom_top"><?php  echo $items['name'];?></div>
													<div class="plug_bottom_tops"><?php  echo $items['title'];?></div>
												</div>
											</a>
										<?php  } ?>
									<?php  } } ?>
								</div>
							<?php  } } ?>
						<?php  } else { ?>
						
						<?php  } ?>
						<!--<div class="am-scrollable-horizontal am-u-sm-12">
							<?php  if($contents) { ?>
								<div class="feed-activity-list">
									<?php  if(is_array($contents)) { foreach($contents as $item) { ?>
										<?php  if(is_array($item['info'])) { foreach($item['info'] as $items) { ?>
											<?php  if($items['is_show'] == 1) { ?>
												<a class="feed-element" href="<?php  echo $items['url'];?>">
													<span class="pull-left">
														<img src="<?php  echo $items['icon'];?>" class="img-circle" alt="<?php  echo $items['name'];?>" >
													</span>	
													<div class="media-body ">
														<span class="title"><?php  echo $items['name'];?></span>
														<br>
														<small class="text-muted"></small>
													</div>
												</a>
											<?php  } ?>
										<?php  } } ?>
										
									<?php  } } ?>
								</div>
							<?php  } else { ?>
								暂无插件	
							<?php  } ?>
							<?php  if(!empty($info)) { ?>
							<div class="feed-activity-list">
								<?php  if(is_array($info)) { foreach($info as $v) { ?>
								<?php  if( file_exists("../addons/".$v['key']) ){ ?>
									<a class="feed-element" href="<?php  echo $v['url'];?>">
								<?php  }else{?>
									<a class="feed-element" href="<?php  echo $v['buy_url'];?>">
								<?php  }?>
								<span class="pull-left">
									<img src="<?php  echo $v['icon'];?>" class="img-circle" alt="<?php  echo $v['name'];?>" >
								</span>
									<div class="media-body ">
										<span class="title"><?php  echo $v['name'];?></span>
										<br>
										<small class="text-muted"></small>
									</div>
								</a>
								<?php  } } ?>
							</div>
							<?php  } else { ?>
							
							<?php  } ?>
						</div>-->
						<!--<div class="am-u-lg-12 am-cf" style="text-align: right;">
							<?php  echo $page;?>
							<div class="am-fr pagination-total am-margin-right">
								<div class="am-vertical-align-middle">总记录：<?php  echo $total;?></div>
							</div>
						</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
        $(function () {
            // 删除元素
            $(document).on('click','.item-delete',function () {
                var id = $(this).data('id');
                layer.confirm('一但删除将无法恢复，确定删除吗？', {
                    title: '友情提示'
                }, function (index) {
                    $.post("<?php  echo $this->createWebUrl('action',array('op'=>'del'))?>", {
                        id: id,
                    }, function (res) {
                        if(res.status === 0){
                            layer.msg(res.msg, {
                                icon: 1
                            });
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
						}else if(res.status === 1){
                            layer.msg(res.msg, {
                                icon: 2
                            });
						}
						layer.close(index);
                    }, "JSON");
                })
            });
            //点击全文删除按钮
            $(document).on('click','#del-all-checked',function () {
                var ids = '';
                $('input[name=zx-checked-list]:checked').each(function () {
					ids += ','+$(this).val();
                });

                $.post("<?php  echo $this->createWebUrl('action',array('op'=>'del'))?>", {id: ids,}, function (res) {
                    if(res.status === 0){
                        layer.msg(res.msg, {
                            icon: 1
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    }else if(res.status === 1){
                        layer.msg(res.msg, {
                            icon: 2
                        });
                    }
                }, "JSON");
            });
            //表格第一行全选或者不全选
			$(document).on('change',"input[name=zx-checked-all]",function () {
				if($(this).is(":checked")){
				    $("input[name=zx-checked-list]").prop("checked",true);
				}else{
                    $("input[name=zx-checked-list]").prop("checked",false);
				}
                seeCheckedBox();
            });
            $(document).on('change',"input[name=zx-checked-list]",function () {
                if($(this).is(":checked")){
                    $('.zx-end-checked-box').show();
                }else{
                    seeCheckedBox();
                }
            });
			//函数，检查是否有选中的多选框，有则显示关联内容
			function seeCheckedBox() {
			    var count = 0;
                $("input[name=zx-checked-list]:checked").each(function () {
					count++;
					return false;
                });
                if( count > 0 ){
					$('.zx-end-checked-box').show();
				}else{
                    $('.zx-end-checked-box').hide();
				}
            }
            //监听可修改单元格的值编号
			$(document).on("blur",".zx-edit-td-input",function () {
			    console.log(1);
			    var id = $(this).attr("data-id");
			   var old = $(this).attr("data-val");
			   var now = $(this).val();
			   if( old == now ){
			       return false;
			   }else if( $.trim(now) != '' && $.trim(now)!=undefined ){
                    $.post("<?php  echo $this->createWebUrl('action',array('op'=>'setOrder'))?>", {id: id,val:now}, function (res) {
                        if(res.status === 0){
                            layer.msg(res.msg, {
                                icon: 1
                            });
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
                        }else if(res.status === 1){
                            layer.msg(res.msg, {
                                icon: 2
                            });
                        }
                    }, "JSON");
			   }
            })
		});
	</script>

</div>
<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
