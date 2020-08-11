<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">用户充值记录</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
							<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="member">
								<input type="hidden" name="op" value="recharge_record">
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
									<span class="zx-form-span">
										充值方式：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<select name="pay"data-am-selected="{ btnSize: 'sm',placeholder:'请选择充值方式', maxHeight: 400}" style="display: none;">
											<option value="0">不限</option>
											<option value="2" <?php  if($pay == 2) { ?>selected=""<?php  } ?>>后台</option>
											<option value="1" <?php  if($pay == 1) { ?>selected=""<?php  } ?>>微信</option>
										</select>
									</div>
									<span class="zx-form-span">
										类型：
									</span>
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<select name="type"data-am-selected="{ btnSize: 'sm',placeholder:'请选择充值方式', maxHeight: 400}" style="display: none;">
											<option value="0">充值</option>
											<option value="1" <?php  if($type == 1) { ?>selected=""<?php  } ?>>积分</option>
										</select>
									</div>
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
										<th style="">手机号</th>
										<!--<th style="width:100px;">余额</th>-->
										<th style="">充值金额</th>
										<th style="">充值时间</th>
										<th >充值方式</th>
										<th >变更说明</th>
										<th >备注</th>
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
										<td><?php  echo $item['m_nickname'];?></td>
										<td><?php  echo $item['m_phone'];?></td>
										<!--<td><?php  echo $item['m_money_balance'];?></td>-->
										<td><?php echo $item['st'] == 1 ? '<font color="green">+' : '<font color="red">-';?><?php  echo $item['money'];?></font></td>
										<td><?php  echo date('Y-m-d H:i:s',$item['c_time'])?></td>
										<td><?php echo $item['pay_f'] == 1 ? '微信': '后台'?></td>
										<td><?php  echo $item['info'];?></td>
										<td><?php  echo $item['remarks'];?></td>
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
</script>
