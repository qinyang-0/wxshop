<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.btn-group .active {
		background-color: #428bca;
		color: #fff;
	}
	.input-group-btn{
		display: inline-block;
	}
	/*微擎底层时间插件样式*/
	.daterangepicker select.ampmselect, .daterangepicker select.hourselect, .daterangepicker select.minuteselect{
		width: auto;
		padding-right: 40px;
	}
	.am-selected-btn{
		border-radius: 4px;
		font-size: 12px;
	}
	.goods_float{
		position: absolute;
		top: 0px;
		line-height: 25px;
		height: 25px;
		color: #fff;
		text-align: center;
		width: 100%;
		background: rgba(0,0,0,0.8);
		overflow: hidden;
	}
	.goods_item{
		position: relative;
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
					<form action="<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'point'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data" <?php  if($info['id']) { ?>onsubmit="return false;"<?php  } ?>>
						<input type="hidden" name="id" id="id" value="<?php  echo $info['id'];?>" />
						<input type="hidden" name="sid" id="sid" value="<?php  echo $send_ticket['id'];?>" />
						<input type="hidden" name="ids" id="ids" value="<?php  echo $ids;?>" />
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl"><?php  echo $act_title;?>指定发放</div>
								</div>
								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>选择优惠券 </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<div style="width: 460px;">-->
											<!--<select  name="cid" data-am-selected="{maxHeight: 250,searchBox: 1}"  placeholder="选择优惠券"  >-->
												<!--<option value=""></option>-->
												<?php  if(!empty($coupon)) { ?>
												<?php  if(is_array($coupon)) { foreach($coupon as $k => $v) { ?>
												<!--<option value="<?php  echo $v['id'];?>" <?php  if($v['id']==$id) { ?>selected<?php  } ?>><?php  echo $v['name'];?></option>-->
												<?php  } } ?>
												<?php  } ?>

											<!--</select>-->
										<!--</div>-->
									<!--</div>-->
								<!--</div>-->
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>指定优惠券名称 </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text' id='name' name='name' value="<?php  echo $info['name'];?>" class='tpl-form-input'/>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">面值 </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='cut_price' value="<?php  echo $info['cut_price'];?>" class='tpl-form-input'/>
									</div>
								</div>
								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label">发放总量 </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<input type='text'  name='number' value="<?php  echo $info['number'];?>" class='tpl-form-input'/>-->
									<!--</div>-->
								<!--</div>-->
								<div class="am-form-group  	am-form-inline">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">使用条件 </label>
									<div class="am-u-sm-9 am-u-end">
										<label class="am-radio-inline am-success" >
											<input name="use_limit_check" type="radio" value="-1" data-am-ucheck  <?php  if($info['use_limit'] < 0 || empty($info['use_limit'])) { ?>checked<?php  } ?>>
											不限制
										</label>
										<label class="am-radio-inline am-success">
											<input name="use_limit_check" type="radio"  value="100" id="use_limit_input_check" data-am-ucheck <?php  if(!empty($info['use_limit']) && $info['use_limit'] != -1) { ?>checked<?php  } ?> >满

											<input type="hidden" value="<?php echo $info['use_limit']?$info['use_limit']:-1;?>" name="use_limit">
										</label>
										<label class="inline am-success" >
											<input type='number' id='use_limit_input' name='use_limit_input' value="<?php  if($info['use_limit']>0) { ?><?php  echo $info['use_limit'];?><?php  } ?>" class='am-radio-inline' placeholder="100" style="width: 100px;" />
										</label>
										<label class="inline am-success">
											元使用<span class="color-9">(不填默认为100)</span>
										</label>
									</div>
								</div>

								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">有效期 </label>
									<div class="am-u-sm-9 am-u-end">
										<?php echo tpl_form_field_daterange('time', array('start'=> $info['start_time']?date('Y-m-d H:i',$info['start_time']):'','end'=> $info['end_time']?date('Y-m-d H:i',$info['end_time']):''),true);?>
									</div>
								</div>

								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>发送类型 </label>
									<div class="am-u-sm-9 am-u-end">
										<div style="width: 460px;">
											<label class="am-radio-inline am-success">
												<input type="radio" name="type" data-am-ucheck="" data-type='type-item-point' value="1" <?php  if($send_ticket['type'] !=1) { ?>checked<?php  } ?> class="am-ucheck-radio">指定用户

											</label>
											<!--<label class="am-radio-inline am-success">-->
												<!--<input type="radio" name="type" data-am-ucheck="" data-type='type-item-all' value="2"  class="am-ucheck-radio" <?php  if($send_ticket['type'] ==2) { ?>checked<?php  } ?>>全部用户-->

											<!--</label>-->
										</div>
									</div>
								</div>
								<div class="am-form-group type-item type-item-point" style="<?php  if($send_ticket['type'] !=1 ) { ?>display: block;<?php  } else { ?>display: none;<?php  } ?>">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>选择指定用户</label>
									<div class="am-u-sm-9 am-u-end">
										<div class="input-group ">
											<?php  if(is_array($send_member)) { foreach($send_member as $key => $val) { ?>
											<?php  $text_str .= ';'.$val['m_nickname'] ;?>
											<?php  } } ?>
											<?php  $text_str = trim($text_str,';') ;?>
											<textarea type="text" id="showGoodsName"  class="form-control" readonly style="width:460px;" rows="5" ><?php  echo $text_str;?></textarea>
											<span class="input-group-btn">
												<button class="btn btn-default select-goods" type="button" >选择用户</button>
											</span>
										</div>
										<div class="input-group multi-img-details" id="showGoodsImg" style="width: 510px;">
											<?php  if(is_array($send_member)) { foreach($send_member as $key => $val) { ?>
											<div class="multi-item goods_item" style="display: none;">
												<img src="<?php  echo tomedia($val['m_photo'])?>" class="img-responsive img-thumbnail" title="<?php  echo $val['m_nickname'];?>">
												<input type="hidden" name="gids[]" value="<?php  echo $val['m_id'];?>">
												<span class="goods_float"><?php  echo $val['m_nickname'];?></span><em class="close" title="删除" data-id="<?php  echo $val['m_id'];?>">×</em></div>
											<?php  } } ?>
										</div>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">使用说明 </label>
									<div class="am-u-sm-9 am-u-end">
										<?php  echo tpl_ueditor('use_notice',$info['use_notice']);?>
										<span class="color-9">优惠卷详情页显示使用说明</span>
									</div>
								</div>

								<div class="am-form-group">
									<div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
										<?php  if(empty($info['id'])) { ?>
											<input type="hidden" name="submit" value="提交"/>
											<button type="submit" class="j-submit zx-addBut " id="btn" value="提交" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...'}">提交</button>
										 <?php  } ?>
										<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'coupon'))?>" id="a-back-index"  ><button class="btn" type="button">返回</button></a>
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
<script>
	$('#btn').click(function(){


	});
	//s使用条件那的小交互
	$(document).on("blur","#use_limit_input",function () {
		var val = $(this).val();
		if( val == "" || val == undefined ){

		}else{
		    $("#use_limit_input_check").prop("checked",true);
		    $("input[name=use_limit]").val(val);
		}
    });
	$(document).on("change","input[name=use_limit_check]",function () {
        var val = $(this).val();
		if( val < 0 ){
            $("input[name=use_limit]").val(val);
            $("#use_limit_input").val('')
		}else{
            $("input[name=use_limit]").val($("#use_limit_input").val());
		}
    });

    //点击选择商品
    $(document).on("click",".select-goods",function () {
        var ids = $('input[name=ids]').val();
        layer.open({
            title:'选择用户',
            type: 2,
            area: ['750px', '500px'],
            fixed: false, //不固定
            maxmin: true,
            content: "<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'get_member'))?>&ids="+ids
        });
    });
    $(document).on("click",".close",function () {
        var ids = '';
        $(this).parent('.goods_item').remove();
        $(".close").each(function () {
            var did = $(this).data().id;
            ids +=','+did;
        });
        var name_str = '';
        $(".goods_float").each(function () {
            var name_each = $(this).html();
            name_str +=name_each+';';
        });
        $("input[name=ids]").val(ids);
        $("#showGoodsName").val(name_str);
	});
    //切换发送类型
	$(document).on('change','input[name=type]',function () {
		var  now_type = $(this).attr('data-type');
        $('.type-item').hide();
        $('.'+now_type).show();
    });
</script>