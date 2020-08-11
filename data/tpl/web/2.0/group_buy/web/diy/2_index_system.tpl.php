<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.infos {
		width: 11%;
		margin: 0 2%;
		float: left;
		height: 370px;
		overflow: hidden;
		position: relative;
	}
	
	.infos img {
		width: 100%;
	}
	
	.botns {
		width: 100%;
		float: left;
		position: absolute;
		color: #ffffff;
		background: rgba(0, 0, 0, 0.5);
		z-index: 5;
	}
	
	.top30 {
		bottom: 0;
		height: 32px;
	}
	
	.tops30 {
		top: 22px;
		text-align: center;
		line-height: 22px;
	}
	
	.botns div {
		float: left;
		padding: 0 7%;
		font-size: 12px;
		width: 33%;
		height: 32px;
		line-height: 32px;
	}
	
	.tos {
		content: '';
		position: absolute;
		height: 398px;
		width: 100%;
		/*/background: url(../addons/group_buy/public/bg/using.png) no-repeat;*/
		background-size: 25px;
		background-position: center;
		background-color: rgba(0, 0, 0, .5);
		z-index: 1;
		top: 0;
		left: 0;
		border-top-left-radius: 10px;
		border-top-right-radius: 10px;
		border-radius: 10px;
	}
	.fl {
    float: left;
}
.content-right {
    width: 959px;
    /*min-height: 660px;*/
    padding: 0px 0;
}
.programCode {
    width: 225px;
    height: 400px;
    border: 1px solid rgb(205, 219, 238);
    float: left;
    margin: 20px;
    /*cursor: pointer;*/
    box-shadow: 2px 2px 2px rgb(209, 224, 243);
    transition: all 0.1s ease 0s;
}
.programCode img {
    width: 100%;
}
	.programCode .tso {
		display: none;

		transition-duration: 3s;
	}
	.programCode:hover .tso{
		display: block;

	}
.tso_middle{
	position: absolute;
	left:50%;
	top:50%;
	margin-left:-40px;
	margin-top:-50px;
	width:80px;
	height:100px;
	text-align: center;
}
.tso_middle button{
	margin: 8px 0;
	width: 80px;
}
</style>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper ">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title am-cf">模板市场</div>
					</div>
					<div class="widget-body am-fr">
						<form action="#" method="post">

							<!--<div class="am-u-sm-12 am-fl am-margin-bottom">-->
								<!--<div class="am-btn-group am-btn-group-xs">-->
									<!--<a class="zx-addBut" href="<?php  echo $this->createWebUrl('diy',array('op'=>'add'));?>">-->
										<!--<i class="fa fa-plus"></i> 新增-->
									<!--</a>-->
								<!--</div>-->
							<!--</div>-->
							<div class="content-right fl" style="width: 100%">
								<div id="3D">
									<?php  if(!empty($info)) { ?>
									<?php  if(is_array($info)) { foreach($info as $key => $item) { ?>
										<div class="programCode" style="position: relative;border-radius: 10px;">
											<dl>
												<dt>
													<div style="max-width: 225px; position: relative; overflow: hidden; height: 398px;">
														<!--<a href="" target="_top">-->
														<img src="<?php  if(empty($item['img'])) { ?>/addons/group_buy/public/bg/sys_temp5.jpg<?php  } else { ?><?php  echo tomedia($item['img'])?><?php  } ?>" alt="" title="" style="border-radius: 10px;">
														<!--</a>-->
													</div>

								            			<div class="tos tso" >
															<div class="tso_middle">

																<!--<a href="<?php  echo $this->createWebUrl('diy',array('op'=>'index_diy','tid'=>$item['id']))?>">-->
																	<button class="btn btn-success select-tmp" type="button" onclick="useTmp(<?php  echo $item['id'];?>);return false;" >
																		选择模版
																	</button>
																<!--</a>-->

															</div>
														</div>
												</dt>

												<dd>
													<!--<a href="<?php  echo $this->createWebUrl('diy',array('op'=>'diy','id'=>$item['id']))?>" class="btn btn-success radius" style="z-index:1000;margin-left: 26px">装修</a>-->
													<!--<a href="<?php  echo $this->createWebUrl('diy',array('op'=>'add','id'=>$item['id']))?>" class="btn btn-info radius" style="z-index:1000;">封面</a>-->
													<!--<button onclick="if(confirm('是否删除?')){deletes('<?php  echo $item['id'];?>')}else{return false;}" class="btn btn-danger radius" style="z-index:1000;border-radius: 3px;">删除</button>-->
												</dd>
											</dl>
										</div>
									<?php  } } ?>
									<?php  } else { ?>
									<!-- 订单导出外层Box -->
									<div class="am-u-sm-12 am-fl">
										您暂时没有已保存的模板，请在首页管理中编辑完成后保存到我的模板！
									</div>
									<?php  } ?>
								</div>
								<div class="n_page_no" style="clear: both; float: right; margin-right: 15px; margin-top: 10px;">
									<?php  echo $page;?>
								</div>
							</div>

						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
	<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
</div>
<!-- 内容区域 end -->
</div>


<script type="text/javascript">
	//快捷删除
	function deletes(id) {
		if(id == '' || id == undefined) {
			alert('非法进入');
			return false;
		}
		layer.confirm("确定删除该模版？",{icon:3,title:'提示'},function (index) {
            $.post("<?php  echo $this->createWebUrl('diy',array('op'=>'del'))?>", {
                id: id
            }, function(res) {
                layer.close(index);
                if(res.status == 0){
                    location.reload();
                }else{
                    layer.msg(res.msg)
                }
            }, "JSON");
        })
	}

    function useTmp(id) {

        layer.confirm("选择模版会清空原有小程序设置！请谨慎操作！",{icon:3,title:'提示'},function (index) {
            location.href = "<?php  echo $this->createWebUrl('diy',array('op'=>'index_diy'))?>&tid="+id;
        })
    }
</script>