<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.btn-group .active {
	    background-color: #428bca;
	    color: #fff;
	}
	.input-group-btn{
		display: block;
	}
	.input_left_border{
		width: 16% !important;
		float: left;
		border-top-right-radius: 0!important;
		border-bottom-right-radius: 0!important;
		border-right: 0!important;
		text-align: center;
	}
	.input_right_border{
		width: 7% !important;float: left;border-top-left-radius: 0!important;border-bottom-left-radius: 0!important;border-left: 0!important;text-align: center;
	}
	.input_right_border_radius{
		border-top-right-radius: 0!important;
		border-bottom-right-radius: 0!important;
		border-right: 0!important;
	}
	.input_left_border_radius{
		border-top-left-radius: 0!important;border-bottom-left-radius: 0!important;border-left: 0!important;
	}
	.clockpicker{
		width: 21% !important;
		float: left;
	}
	.clockpicker input{
		width: 100% !important;
		border-radius: 0 !important;float: left;
	}
	.nones{
		display: none;	
	}
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
</style>
<!--右侧详细内容区域 from 自定义-->
<div class="tpl-content-wrapper ">
	<!--本页自定义样式-->
	<!--<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/goods.css">-->
	<!--<link rel="stylesheet" href="<?php  echo MODULE_URL?>style/css/umeditor.css">-->
	<!--右侧详细内容区域，灰框之内,from 妹子-->
	<div class="row-content am-cf">
		<!--2列式简单布局,from bootstap-->
		<div class="row">
			<!--12列布局,from 妹子-->
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<!--widget自定义右侧盒子 from 自定义 am-cf 清除全部浮动  from 妹子-->
				<div class="widget am-cf">
					<div class="am-tabs am-tabs-d2" id="navs">
						<ul class="am-tabs-nav am-cf" style="margin-bottom: 30px;">
							<li class="am-active" id="basic">
								<a href="javascript:;" class="good_nav" data-id="basic">基本设置 </a>
							</li>
							<li class="" id="main">
								<a href="javascript:;" class="good_nav" data-id="main">首页相关设置</a>
							</li>
							<!--<li class="" id="pay">
								<a href="javascript:;" class="good_nav" data-id="pay">支付相关设置</a>
							</li>-->
							<li class="" id="reminder">
								<a href="javascript:;" class="good_nav" data-id="reminder">催单设置</a>
							</li>
							<li class="" id="address">
								<a href="javascript:;" class="good_nav" data-id="address">地址设置</a>
							</li>
						</ul>
					</div>
					<form action="<?php  echo $this->createWebUrl('config',array('op'=>'index'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<!--<div class="widget-head am-cf">
									<div class="widget-title am-fl">基本设置</div>
								</div>-->
								<?php  if(!empty($info)) { ?>
								<!--客服电话-->
									<div class="nav_basic nav_goods_add">
										<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/config/index/basic', TEMPLATE_INCLUDEPATH)) : (include template('/web/config/index/basic', TEMPLATE_INCLUDEPATH));?>
									</div>
									<div class="nav_main nav_goods_add nones">
										<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/config/index/main', TEMPLATE_INCLUDEPATH)) : (include template('/web/config/index/main', TEMPLATE_INCLUDEPATH));?>
									</div>
									<div class="nav_pay nav_goods_add nones">
										<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/config/index/pay', TEMPLATE_INCLUDEPATH)) : (include template('/web/config/index/pay', TEMPLATE_INCLUDEPATH));?>
									</div>
									<div class="nav_reminder nav_goods_add nones">
										<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/config/index/reminder', TEMPLATE_INCLUDEPATH)) : (include template('/web/config/index/reminder', TEMPLATE_INCLUDEPATH));?>
									</div>
									<div class="nav_address nav_goods_add nones">
										<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('/web/config/index/address', TEMPLATE_INCLUDEPATH)) : (include template('/web/config/index/address', TEMPLATE_INCLUDEPATH));?>
									</div>
									<!--<div class="widget-head am-cf">
										<div class="widget-title am-fl">首页相关设置</div>
									</div>-->
									<!--<div class="widget-head am-cf">
										<div class="widget-title am-fl">支付相关设置</div>
									</div>-->
									<!--支付商户号-->
									<!--<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['appid']['name'];?> </label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='<?php  echo $info['appid']['key'];?>' value="<?php  echo $info['appid']['value'];?>"  class='tpl-form-input' />
											<span class="color-9">AppId</span>
										</div>
									</div>
									<div class="am-form-group">
										<label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $info['appsecret']['name'];?> </label>
										<div class="am-u-sm-9 am-u-end">
											<input type='text' name='<?php  echo $info['appsecret']['key'];?>' value="<?php  echo $info['appsecret']['value'];?>"  class='tpl-form-input' />
											<span class="color-9">AppSecret</span>
										</div>
									</div>-->
									
									<!--<div class="widget-head am-cf">
										<div class="widget-title am-fl">地址设置</div>
									</div>-->
									
								<?php  } else { ?>
									缺少配置，请联系管理员
								<?php  } ?>
								<div class="am-form-group">
									<div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
										<input type="hidden" name="submit" value="提交"/>
										<button type="submit" class="j-submit zx-addBut " id="btn" value="提交" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...'}">提交</button>
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


<script>
	$('#btn').click(function(){

	});
	$(document).on("click",".cert_select",function () {
		$(".cert_real_click").trigger('click');
    });
    $(document).on("click",".key_select",function () {
        $(".key_real_click").trigger('click');
    });
    // $(document).on("click",".cert_click",function () {
    //     var formData = new FormData();
    //     $.ajax({
    //         url: "<?php  echo $this->createWebUrl('config',array('op'=>'upload'))?>",
    //         type: 'post',
    //         data: formData,
    //         cache: false,
    //         processData: false,
    //         contentType: false,
    //         async: false,
    //         dataType: 'json',
    //         success : function (res) {
    //             console.log(res);
    //             // if (res.code == 200) {
    //             //     console.log(data.msg);
    //             // } else {
    //             //     console.log(data.msg);
    //             // }
    //         }
    //     })
    //     console.log(formData)
        // $.post("<?php  echo $this->createWebUrl('config',array('op'=>'upload'))?>",{id:31,data:$('form').serialize()},function(res){
        //     console.log(res);
        //     if(res.status == 0){
		//
        //         location.reload();
        //     }else{
        //         alert(res.msg);
        //     }
        // },"JSON")
	// });
    function getfilename(name){
        //方法一
        var file = $(name).val();
        var pos=file.lastIndexOf("\\");
        return file.substring(pos+1);
        // //方法二：正则表达式
        // var strFileName=file.replace(/^.+?\\([^\\]+?)(\.[^\.\\]*?)?$/gi,"$1");  //正则表达式获取文件名，不带后缀
        // var FileExt=file.replace(/.+\./,"");   //正则表达式获取后缀
        // //方法三
        // var img = document.getElementById('fileid');
        // var imgName = img.files[0].name;
    }
    $(document).on("change",".cert_real_click",function () {
        var text  = getfilename('.cert_real_click');
		$("#cert_select_name").html(text)
    });
    $(document).on("change",".key_real_click",function () {
        var text  = getfilename('.key_real_click');
        $("#key_select_name").html(text)
    });
    $(".cutting input[type='radio']").change(function(res){
    	var cutting = $(this).val();
    	if(cutting == 1){
    		$('#cutting').show();
    	} else {
    		$('#cutting').hide();
    	}
    })
    $(".reminders input[type='radio']").change(function(res){
    	var reminder = $(this).val();
    	if(reminder == 2){
    		$('#reminders').show();
    	} else {
    		$('#reminders').hide();
    	}
    })
    $('.good_nav').click(function(res){
		var id = $(this).data('id');
		
		$(".am-tabs-nav li").removeClass('am-active');
		$("#"+id).addClass('am-active');
		$(".nav_goods_add").hide();
		$(".nav_"+id).show();
	})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>