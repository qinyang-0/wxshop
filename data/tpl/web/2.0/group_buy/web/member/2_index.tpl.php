<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">用户列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="member">
								<input type="hidden" name="vg_id" value="<?php  echo $vg;?>">

								<div class="am-u-sm-12 ">
									<span class="zx-form-span">
										微信昵称：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="title" placeholder="微信昵称" value="<?php  echo $_GPC['title'];?>" style="border-radius: 4px;width: 240px;">
									</div>
									<span class="zx-form-span">
										用户编号：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="num" placeholder="用户编号" value="<?php  echo $_GPC['num'];?>" style="border-radius: 4px;width: 240px;">
									</div>
									<!--<div class="am-form-group am-fl">-->
										<!--<label class="am-form-label am-form-label" >微信昵称</label>-->
									<!--</div>-->
									<!--<div class="am-form-group am-fl">-->
										<!--<div class="am-input-group am-input-group-sm tpl-form-border-form">-->
											<!--<input type="text" class="am-form-field" name="title" placeholder="微信昵称" value="<?php  echo $_GPC['title'];?>" style="border-radius: 4px;width: 240px;">-->
										<!--</div>-->
									<!--</div>-->

									<!--<div class="am-form-group am-fl">-->
										<!--<label class="am-form-label am-form-label" >用户编号</label>-->
									<!--</div>-->
									<!--<div class="am-form-group am-fl">-->
										<!--<div class="am-input-group am-input-group-sm tpl-form-border-form">-->
											<!--<input type="text" class="am-form-field" name="num" placeholder="用户编号" value="<?php  echo $_GPC['num'];?>" style="border-radius: 4px;width: 240px;">-->
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
							<div class="am-scrollable-horizontal am-u-sm-12">
								<table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
									<thead class="navbar-inner">
									<tr>
										<th style="width:50px;">编号</th>
										<th style="width:50px;">头像</th>
										<th style="width:100px;">昵称</th>
										<th style="width:100px;">手机号</th>
										<th style="width:100px;">余额</th>
										<th style="width:100px;">积分</th>
										<?php  if($card) { ?>
											<th style="width:100px;">会员卡</th>
											<th style="width:100px;">会员卡到期时间</th>
										<?php  } ?>
										<th style="width:120px;">关注时间</th>
										<th style="width:150px;">操作</th>
									</tr>
									</thead>
									<tbody>
									<?php  if(!empty($info)) { ?>
									<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
									<tr>
										<td><?php  echo $item['m_id'];?></td>
										<td>
											<img src="<?php  echo $item['m_photo'];?>" width="50" style="border-radius: 50%;"/>
										</td>
										<td><?php  echo $item['m_nickname'];?>
											<?php  if($item['m_is_head'] == 2 ) { ?>
											<span class="label label-success ">团长</span>
											<?php  } ?>
											<br>
											<div class="" style="position: relative;margin-top:10px; ">
												<span class="btn btn-info see-openid btn-xs" onclick="">查看openid</span>
												<div class="copy-btn" style="min-width:220px;display:none;position: absolute;top: 10px;left: 100px;z-index:100; background: white;border: 1px solid #0da3f9;border-radius:5px; padding: 4px;">
													<input type="text" disabled value="<?php  echo $item['m_openid'];?>" style="float:left;min-width: 150px;border: 0;height: 34px;" />
													<span class="btn btn-default btn-group-sm " onclick="copyText(this);return false;" data-openid="<?php  echo $item['m_openid'];?>" style="float:left;">复制</span>
												</div>
											</div>
										</td>
										<td><?php  echo $item['m_phone'];?></td>
										<td>

											<a href="<?php  echo $this->createWebUrl('member',array('op'=>'recharge_record','num'=>$item['m_id'],'type'=>0))?>"><?php  echo $item['m_money_balance'];?>
												<br/>
												查看记录
											</a>
										</td>
										<td>

											<a href="<?php  echo $this->createWebUrl('member',array('op'=>'recharge_record','num'=>$item['m_id'],'type'=>1))?>">
												<?php  echo $item['integral'];?>
												<br/>
												查看记录
											</a>
										</td>
										<?php  if($card) { ?>
											<td><?php  echo $item['card'];?></td>
											<td><?php  if($item['level'] != 0 ) { ?><?php  if($item['end_level_time'] == 0) { ?>永久<?php  } else { ?><?php  echo date('Y-m-d H:i:s',$item['end_level_time'])?><?php  } ?><?php  } else { ?><?php  } ?></td>
										<?php  } ?>
										<td><?php  echo date('Y-m-d H:i:s',$item['m_add_time'])?></td>
										<td><!--删除可以用ajax实现-->
											<a href="<?php  echo $this->createWebUrl('member',array('op'=>'add','id'=>$item['m_id']))?>"  class="btn btn-success btn-xs">详情</a>
											<?php  if($item['m_is_head'] == 2) { ?>
											<a onclick="cancelHead('<?php  echo $item['m_id'];?>')"  class="btn btn-warning btn-xs">取消团长</a>
											<?php  } else { ?>
											<a onclick="setHead('<?php  echo $item['m_id'];?>','<?php  echo $vg;?>','<?php  echo $item['m_openid'];?>')"  class="btn btn-info btn-xs">设置团长</a>
											<?php  } ?>
											<!--给用户手动添加积分和余额-->
											<a href="javascript:;" onclick="recharge(<?php  echo $item['m_id'];?>,this)" class="btn btn-danger btn-xs" data-img="<?php  echo $item['m_photo'];?>" data-name="<?php  echo $item['m_nickname'];?>" data-jf="<?php  echo $item['integral'];?>" data-inter="<?php  echo $item['m_money'];?>">充值</a>
											<!--删除保留-->
											<!--<a class="btn btn-danger" onclick="if(confirm('是否删除?')){deletes('<?php  echo $item['m_id'];?>')}else{return false;}">删除</a>-->

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
<input  id="copy_area" style="border: 0;color: #fff;background: white;width: 0.1px;height: 0.1px;outline: none;">
<script type="text/html" id="recharge_html">

</script>
<script type="text/javascript">
function showImageDialog(elm, opts, options) {
	require(["util"], function(util){
var btn = $(elm);
var ipt = btn.parent().prev();
var val = ipt.val();
var img = ipt.parent().next().children();
options = {'global':false,'class_extra':'','direct':true,'multiple':false,'fileSizeLimit':5120000};
util.image(val, function(url){
	if(url.url){
		if(img.length > 0){
			img.get(0).src = url.url;
		}
		ipt.val(url.attachment);
		ipt.attr("filename",url.filename);
	ipt.attr("url",url.url);
			}
			if(url.media_id){
				if(img.length > 0){
					img.get(0).src = url.url;
				}
				ipt.val(url.media_id);
			}
		}, options);
	});
}
function deleteImage(elm){
	$(elm).prev().attr("src", "./resource/images/nopic.jpg");
$(elm).parent().prev().find("input").val("");
}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
	function deletes(id){
		if(id == '' || id == undefined){
			layer.msg('非法进入',{icon:2,time:2000});
			return false;
		}
		$.post("<?php  echo $this->createWebUrl('member',array('op'=>'del'))?>",{id:id},function(res){
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
	//重置查询,$_GPC有毒，以后再说
	// $(document).on("click","button[type=reset]",function () {
    //     $('.form-control').val('1');
    // })
    function setHead(id,){
        if(id == '' || id == undefined){
            layer.msg('非法操作',{icon:2,time:2000});
            return false;
        }
		layer.confirm("确定设为团长？",{icon:3,title:'提示'},function (index) {
            $.post("<?php  echo $this->createWebUrl('member',array('op'=>'setHead'))?>",{id:id},function(res){
                layer.close(index);
                if(res.status == 0){
                    layer.msg(res.msg,{icon:1,time:1000});
                    setTimeout(function () {
                        location.reload();
                    },1000)
                }else if(res.status == 2){
                    layer.msg(res.msg,{icon:2,time:1000});
                    setTimeout(function () {
                        location.href="<?php  echo $this->createWebUrl('head',array('op'=>'add'))?>&id="+res.id;
                    },1000)
                }else if(res.status == 1){
                    layer.msg(res.msg,{icon:2,time:1000});
				}
            },"JSON")
        })

    }
    function cancelHead(id){
        if(id == '' || id == undefined){
            layer.msg('非法操作',{icon:2,time:2000});
            return false;
        }
        layer.confirm("确定取消团长？",{icon:3,title:'提示'},function (index) {
            $.post("<?php  echo $this->createWebUrl('member',array('op'=>'cancelHead'))?>",{id:id},function(res){
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
    function copyText(obj) {
        var text = obj.getAttribute("data-openid");
        var input = document.getElementById("copy_area");
        input.value = text; // 修改文本框的内容
        input.select(); // 选中文本
        document.execCommand("copy"); // 执行浏览器复制命令
        alert("复制成功");
    }
    $("body").click(function () {
		$(".copy-btn").hide();
    });
    $(document).on("click",".see-openid",function () {
        $(this).siblings('div').show();
        return false;
    })
	function recharge(id,obj){
		$.post("<?php  echo $this->createWebUrl('member',array('op'=>'recharge_template'))?>",{id:id},function(res){
			var str = res;
			layer.open({
				title: '充值',
				content: str,
				area:['800px', '580px'],
				yes:function(index,layers){
					var inters = $("input[name='inters']").val();
					if(inters == '' || inters == undefined){
						alert('请输入充值数目');
						return false;
					}
					var data = {};
					data['id'] = id;
					data['inters'] = inters;
					data['types'] = $("input[name='types']:checked").val();
					data['change'] = $("input[name='change']:checked").val();
					data['remarks'] = $("#remarks").val();
					$.post("<?php  echo $this->createWebUrl('member',array('op'=>'recharge'))?>",data,function(res){
						console.log(res);
						if(res.code == 1){
							layer.msg(res.msg);
						}else{
							layer.msg(res.msg,function(res){
								location.reload();
							});
						}
					},'JSON');
				}
			});
		},'text');
	}
</script>
