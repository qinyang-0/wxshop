<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">团长列表</div>
					</div>
					<div class="widget-body am-fr">
						<!-- 工具栏 -->
						<div class="page_toolbar am-margin-bottom-xs am-cf">
        					<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
								<input type="hidden" name="c" value="site">
								<input type="hidden" name="a" value="entry">
								<input type="hidden" name="m" value="group_buy">
								<input type="hidden" name="do" value="plsugins">
								<input type="hidden" name="op" value="extension">
								<input type="hidden" name="in" value="index">
								<input type="hidden" name="vg_id" value="<?php  echo $vg;?>">
								<div class="am-u-sm-12 ">
									<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">
										<input type="text" class="am-form-field" name="key" placeholder="编号/用户名/姓名/电话" value="<?php  echo $_GPC['key'];?>" style="border-radius: 4px;width: 240px;">
									</div>
									<!--<span class="zx-form-span">-->
										<!--用户名：-->
									<!--</span>-->
									<!--<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">-->
										<!--<input type="text" class="am-form-field" name="title" placeholder="用户名" value="<?php  echo $_GPC['title'];?>" style="border-radius: 4px;width: 240px;">-->
									<!--</div>-->
									<!--<span class="zx-form-span">-->
										<!--姓名：-->
									<!--</span>-->
									<!--<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">-->
										<!--<input type="text" class="am-form-field" name="name" placeholder="姓名" value="<?php  echo $_GPC['name'];?>" style="border-radius: 4px;width: 240px;">-->
									<!--</div>-->
									<!--<span class="zx-form-span">-->
										<!--电话：-->
									<!--</span>-->
									<!--<div class="am-form-group tpl-form-border-form zx-form-input zx-display zx-group">-->
										<!--<input type="text" class="am-form-field" name="phone" placeholder="电话" value="<?php  echo $_GPC['phone'];?>" style="border-radius: 4px;width: 240px;">-->
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
										<th>编号</th>
										<th>团长</th>
										<th>手机号/姓名</th>
										<th >小区</th>
										<th >地址</th>
										<th>分佣比例(%)</th>
										<th>是否配送/配送费</th>
										<th>是否小区限额</th>
										<th>操作</th>
									</tr>
									</thead>
									<tbody>
									<?php  if(!empty($info)) { ?>
									<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
									<tr>
										<td class="am-text-middle"><?php  echo $item['m_id'];?></td>
										<td class="am-text-middle"><img src="<?php  echo $item['m_photo'];?>" width="50" style="border-radius: 100%;border: 1px solid #efefef;padding: 1px;"/>
										<?php  if($this->check_base64_out_json($item['m_nickname'])) { ?>
						                   <?php  echo base64_decode($item['m_nickname'])?>
						                <?php  } else { ?>
							                <?php echo empty($item['m_nickname'])?"暂无":trim($item['m_nickname'])?>
						                <?php  } ?>

											<!--<span class="text-info"><?php  echo $item['m_recommend_code'];?></span>-->

										</td>
										<td class="am-text-middle"><?php echo empty($item['m_phone'])?"暂无":$item['m_phone']?><br/>/<?php echo empty($item['m_name'])?"暂无":$item['m_name']?></td>
										<td class="am-text-middle" style="width: 160px;">
											<div><?php  echo $item['vg_name'];?></div>
											<div style="text-overflow: ellipsis;white-space:nowrap;overflow:hidden;width: 160px;vertical-align: middle;cursor:pointer;" title="<?php  echo $item['rg_all_area'];?>&nbsp;&nbsp;&nbsp;<?php  echo $item['vg_address'];?>">地址：<?php  echo $item['rg_all_area'];?>&nbsp;&nbsp;&nbsp;<?php  echo $item['vg_address'];?></div>
										</td>
										<td  class="am-text-middle">

										</td>
										<td class="am-text-middle"><?php  echo $item['m_commission'];?></td>
										<td class="am-text-middle">
											<?php  if($item['m_is_send'] == 1) { ?>
											<span class="btn btn-info btn-xs" onclick="openSend(<?php  echo $item['m_id'];?>,2)">去开启</span>
											<?php  } else if($item['m_is_send']==2) { ?>
											<span class="btn btn-warning btn-xs" onclick="openSend(<?php  echo $item['m_id'];?>,1)">已开启</span>
											<?php  } ?>
											<br>
											配送费：￥<?php  echo $item['m_send_price'];?>
										</td>
										<td class="am-text-middle">
											<div class="tpl-switch">
												<input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="type" data-id="<?php  echo $item['m_id'];?>" data-type="m_is_have_limit_pay" data-state="<?php  if($item['m_is_have_limit_pay']==2) { ?>1<?php  } else { ?>2<?php  } ?>" <?php  if($item['m_is_have_limit_pay']==2) { ?> checked="" <?php  } ?>>
												<div class="tpl-switch-btn-view">
													<div>

													</div>
												</div>
											</div>
										</td>
										<td>
											<?php  if(!empty($vg) ) { ?>
											<a onclick="setHead('<?php  echo $item['m_id'];?>','<?php  echo $vg;?>','<?php  echo $item['m_openid'];?>')"  class="btn btn-info btn-xs">选取</a>
											<?php  } else { ?>
											<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'extension','in'=>'add','id'=>$item['m_id']))?>"  class="btn btn-success btn-xs">编辑</a>
											<a onclick="cancelHead('<?php  echo $item['m_id'];?>')"  class="btn btn-warning btn-xs">取消</a>
											<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'extension','in'=>'commission','openid'=>$item['m_openid']))?>" class="btn btn-danger btn-xs" title="查看佣金">佣金</a>
											<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'extension','in'=>'seeIncome','openid'=>$item['m_openid']))?>"  class="btn btn-warning btn-xs" title="查看营收详情">营收</a>
											<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'extension','in'=>'head_team','uid'=>$item['m_id']))?>"  class="btn btn-info btn-xs" title="查看团长的团队">团队</a>
											<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'extension','in'=>'team_log','uid'=>$item['m_id']))?>"  class="btn btn-info btn-xs" title="查看该团长的推广流水">推广流水</a>
											<?php  } ?>
										</td>
										<!--<td>
											<?php  if(!empty($vg) ) { ?>
											<a onclick="setHead('<?php  echo $item['m_id'];?>','<?php  echo $vg;?>','<?php  echo $item['m_openid'];?>')"  class="btn btn-info btn-xs">选取</a>
											<?php  } else { ?>
											<a href="<?php  echo $this->createWebUrl('head',array('op'=>'add','id'=>$item['m_id']))?>"  class="btn btn-success btn-xs">编辑</a>
											<a onclick="cancelHead('<?php  echo $item['m_id'];?>')"  class="btn btn-warning btn-xs">取消</a>

											<a href="<?php  echo $this->createWebUrl('head',array('op'=>'commission','openid'=>$item['m_openid']))?>" class="btn btn-danger btn-xs" title="查看佣金">佣金</a>
											<a href="<?php  echo $this->createWebUrl('head',array('op'=>'seeIncome','openid'=>$item['m_openid']))?>"  class="btn btn-warning btn-xs" title="查看营收详情">营收</a>
											<a href="<?php  echo $this->createWebUrl('head',array('op'=>'head_team','uid'=>$item['m_id']))?>"  class="btn btn-info btn-xs" title="查看团长的团队">团队</a>
											<a href="<?php  echo $this->createWebUrl('head',array('op'=>'team_log','uid'=>$item['m_id']))?>"  class="btn btn-info btn-xs" title="查看该团长的推广流水">推广流水</a>
											<?php  } ?>
										</td>-->
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
	$(function () {
        //开关切换
        $(document).on("change","input[name='type']",function (res) {

            var data = $(this).data();
            $.post("<?php  echo $this->createWebUrl('plsugins',array('op'=>'extension','in'=>'state'))?>", {
                id: data.id,
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
    });

	function deletes(id){
		if(id == '' || id == undefined){
			layer.msg('非法进入',{icon:2,time:2000});
			return false;
		}
		layer.confirm("确定删除吗？",{icon:3,title:'提示'},function (index) {
            $.post("<?php  echo $this->createWebUrl('plsugins',array('op'=>'extension','in'=>'del'))?>",{id:id},function(res){
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
    function openSend(id,code){
        if(id == '' || id == undefined){
            layer.msg('非法进入',{icon:2,time:2000});
            return false;
        }
        var notice = '';
        if(code == 1){
            notice = "确定要关闭团长配送吗？"
		}else if(code ==2){
            notice = "确定要开启团长配送吗？"
		}
        layer.confirm(notice,{icon:3,title:'提示'},function (index) {
            $.post("<?php  echo $this->createWebUrl('head',array('op'=>'openSend'))?>",{id:id,code},function(res){
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
    function setHead(id,vg_id,openid){
        if(id == '' || id == undefined){
            layer.msg('非法操作',{icon:2,time:2000});
            return false;
        }
        layer.confirm("确定设为团长吗？",{icon:3,title:'提示'},function (index) {
            $.post("<?php  echo $this->createWebUrl('member',array('op'=>'setHead'))?>",{id:id,vg_id:vg_id,openid:openid},function(res){                				layer.close(index);
                if(res.status == 0){
                    layer.msg(res.msg,{icon:1,time:1000});
                    setTimeout(function () {
                        location.href="<?php  echo $this->createWebUrl('district',array('op'=>'village'))?>";
                    },1000)
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            },"JSON")
		});

    }
    function cancelHead(id){
        if(id == '' || id == undefined){
            ayer.msg('非法操作',{icon:2,time:2000});
            return false;
        }
        layer.confirm("确定取消团长吗？",{icon:3,title:'提示'},function (index) {
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
        });
    }
</script>
