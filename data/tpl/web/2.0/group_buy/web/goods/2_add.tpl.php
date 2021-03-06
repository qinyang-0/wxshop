<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.btn-group .active {
	    background-color: #428bca;
	    color: #fff;
	}
	.input-group-btn {
		display: block !important;
	}
	.am-selected-btn{
		border-radius: 4px;
		font-size: 12px;
	}
	/*选项卡*/
	.am-tabs-d2 .am-tabs-nav{
		background: #fff;
		border-bottom: 1px solid #eef1f5;
	}
	.am-tabs-nav{
		display: flex;
		align-items: center;
		justify-content: flex-start;
	}
	.am-tabs .am-tabs-nav li{
		width: 120px;
		line-height: 40px;
		height: 40px;
		padding: 0;
	}
	.am-tabs .am-tabs-nav li a{
		width: 120px;
		line-height: 40px;
		height: 40px;
		padding: 0;
		display: block;
		margin: 0;
		text-align: center;
		background: #fff;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active {
		position: relative;
		background-color: #fcfcfc;
		border-bottom: 2px solid #22c397;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active a{
		color: #22c397;
	}
	.am-tabs-d2 .am-tabs-nav>.am-active:after{
		border-bottom-color: #22c397;
	}
	/*选项卡end*/
	.zx-edit-td-input:focus{
		outline: 1px  dashed #22c397;
	}
	.am-switch-success-zx>input[type=checkbox]:checked~.am-switch-checkbox{
		background: #22c397;
	}
	.modal{
		z-index: 999999 !important;
	}
	.yuan{
		float: left;
		width: 3% !important;
	    text-align: center;
	    border-radius: 0 !important;
	    border-left: 0 !important;
	    border-top-right-radius: 4px !important;
	    border-bottom-right-radius: 4px !important;
	}
</style>
<link href="./resource/css/bootstrap.min.css?v=20170426" rel="stylesheet">
<link href="./resource/css/common.css?v=20170426" rel="stylesheet">

<!-- 内容区域 start -->
<div class="tpl-content-wrapper ">
	<!--本页自定义样式-->
	<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/goods.css">
	<!--<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/umeditor.css">-->
	<!--右侧详细内容区域，灰框之内,from 妹子-->
	<div class="row-content am-cf">
		<!--2列式简单布局,from bootstap-->
		<div class="row">
			<!--12列布局,from 妹子-->
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<!--widget自定义右侧盒子 from 自定义 am-cf 清除全部浮动  from 妹子-->
				<div class="widget am-cf">
					<form action="<?php  echo $this->createWebUrl('goods',array('op'=>'add'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<input type="hidden" name="id" id="id" value="<?php  echo $info['g_id'];?>" />
						<input type="hidden" name="add_time" id="add_time" value="<?php  echo $info['g_add_time'];?>" />
							<!--右侧正文 from 自定义 -->
							<div class="widget-body">
								<!--右侧正文 规定所有边距为0 from bootstap -->
								<fieldset>
									<!--小标题 from 自定义-->
									<div class="widget-head am-cf">
										<div class="widget-title am-fl"><?php  echo $act_title;?>商品</div>
									</div>
									<div class="am-tabs am-tabs-d2">
										<ul class="am-tabs-nav am-cf" style="margin-bottom: 30px;">
											<li class="am-active" id="basic"><a href="javascript:;" class="good_nav" data-id="basic">基本 </a></li>
											<li class="" id="stock"><a href="javascript:;" class="good_nav" data-id="stock">规格</a></li>
											<li class="" id="buy_limit"><a href="javascript:;" class="good_nav" data-id="buy_limit">购买权限</a></li>
											<li class="" id="details"><a href="javascript:;" class="good_nav" data-id="details">详情</a></li>

											<?php  if(!empty($distribution)) { ?>
												<li class="" id="distribution"><a href="javascript:;" class="good_nav" data-id="distribution">分销</a></li>
											<?php  } ?>
											<?php  if(!empty($gpb_member_card)) { ?>
												<li class="" id="discount"><a href="javascript:;" class="good_nav" data-id="discount">会员折扣</a></li>
											<?php  } ?>
										</ul>
									</div>
									<div class="nav_basic nav_goods_add">
										<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/goods/goods_basic', TEMPLATE_INCLUDEPATH)) : (include template('/web/goods/goods_basic', TEMPLATE_INCLUDEPATH));?>
									</div>
									<div class="nav_stock nav_goods_add" style="display: none;">
										<!--//多规格-->
										<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/goods/goods_stock', TEMPLATE_INCLUDEPATH)) : (include template('/web/goods/goods_stock', TEMPLATE_INCLUDEPATH));?>
									</div>
									<div class="nav_buy_limit nav_goods_add" style="display: none;">
										<!--商品限购-->
										<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/goods/goods_limit', TEMPLATE_INCLUDEPATH)) : (include template('/web/goods/goods_limit', TEMPLATE_INCLUDEPATH));?>
									</div>
									<div class="nav_details nav_goods_add" style="display: none;">
										<!--商品详情-->
										<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/goods/good_info', TEMPLATE_INCLUDEPATH)) : (include template('/web/goods/good_info', TEMPLATE_INCLUDEPATH));?>
									</div>

									<!--2019-8-16新增功能 会员价格  goods_discount 如果没得会员卡的时候   这下面就不显示  -->
									<?php  if(!empty($gpb_member_card)) { ?>
										<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/goods/member_card', TEMPLATE_INCLUDEPATH)) : (include template('/web/goods/member_card', TEMPLATE_INCLUDEPATH));?>
									<?php  } ?>
									<?php  if($distribution) { ?>
										<!--商品单品分销-->
										<div class="nav_distribution nav_goods_add" style="display: none;">
											<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/goods/distribution', TEMPLATE_INCLUDEPATH)) : (include template('/web/goods/distribution', TEMPLATE_INCLUDEPATH));?>
										</div>
									<?php  } ?>
									<div class="am-form-group">
										<div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
											<input type="hidden" name="submit" value="提交"/>
											<button type="submit" class="j-submit zx-addBut " id="btn" value="提交" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...'}">提交</button>
											<a href="<?php  echo $this->createWebUrl('goods',array('op'=>'index'))?>" id="a-back-index"  ><button class="btn" type="button">返回</button></a>
										</div>
									</div>
								</fieldset>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/goods/goods_js', TEMPLATE_INCLUDEPATH)) : (include template('/web/goods/goods_js', TEMPLATE_INCLUDEPATH));?>