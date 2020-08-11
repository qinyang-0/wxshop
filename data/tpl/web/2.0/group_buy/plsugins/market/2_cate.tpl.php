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
					<form action="<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'cate'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data" <?php  if(!empty($info['id'])) { ?> onsubmit="return false;"<?php  } ?>>
						<input type="hidden" name="id" id="id" value="<?php  echo $info['id'];?>" />
						<!--右侧正文 from 自定义 -->
						<div class="widget-body">
							<!--右侧正文 规定所有边距为0 from bootstap -->
							<fieldset>
								<!--小标题 from 自定义-->
								<div class="widget-head am-cf">
									<div class="widget-title am-fl"><?php  echo $act_title;?>分类优惠券</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>优惠券名称 </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text' id='name' name='name' value="<?php  echo $info['name'];?>" class='tpl-form-input'/>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label"><b class="text-danger">*</b>可使用的商品分类</label>
									<div class="am-u-sm-9 am-u-end">
										<div style="width: 460px;">
											<select  name="cid[]" data-am-selected="{maxHeight: 250,searchBox: 1}"  placeholder="请选择分类" multiple >
												<option value=""></option>
												<?php  if(!empty($cate)) { ?>
												<?php  if(is_array($cate)) { foreach($cate as $k => $v) { ?>
												<option value="<?php  echo $v['gc_id'];?>"   <?php  if(is_array($old_cates) && in_array($v['gc_id'],$old_cates)) { ?>selected<?php  } ?>><?php  echo str_repeat("&nbsp;&nbsp;&nbsp;",$v['gc_level'])?><?php  echo $v['gc_name'];?></option>
												<?php  var_dump($old_cates);?>
												<?php  } } ?>
												<?php  } ?>
											</select>
										</div>

									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">面值 </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='cut_price' value="<?php  echo $info['cut_price'];?>" class='tpl-form-input'/>
									</div>
								</div>
								<div class="am-form-group">
									<label class="am-u-sm-3 am-u-lg-2 am-form-label">发放总量 </label>
									<div class="am-u-sm-9 am-u-end">
										<input type='text'  name='number' value="<?php  echo $info['number'];?>" class='tpl-form-input'/>
									</div>
								</div>
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

								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label">是否首页显示 </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<label class="am-radio-inline am-success" >-->
											<!--<input name="is_index_show" type="radio" value="1" data-am-ucheck  <?php  if($info['is_index_show'] ==='1' || empty($info['is_index_show'])) { ?>checked<?php  } ?>>-->
											<!--显示-->
										<!--</label>-->
										<!--<label class="am-radio-inline am-success">-->
											<!--<input name="is_index_show" type="radio"  value="-1" data-am-ucheck <?php  if($info['is_index_show'] == -1) { ?>checked<?php  } ?> >不显示-->

										<!--</label>-->
									<!--</div>-->
								<!--</div>-->
								<!--<div class="am-form-group">-->
									<!--<label class="am-u-sm-3 am-u-lg-2 am-form-label">备注 </label>-->
									<!--<div class="am-u-sm-9 am-u-end">-->
										<!--<textarea name="info" rows="3" style="width: 460px;"><?php  echo $info['comment'];?></textarea>-->
									<!--</div>-->
								<!--</div>-->
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
										
										<a href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'market','in'=>'cupon'))?>" id="a-back-index"  ><button class="btn" type="button">返回</button></a>
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
        var name = $.trim($("input[name='name']").val());
        var cut_price = $.trim($("input[name='cut_price']").val());
        var number = $.trim($("input[name='number']").val());
        var is_index_show = $.trim($("input[name='is_index_show']").val());
        var num_limit = $.trim($("select[name='num_limit']").val());


		if(name == '' || name == undefined){
			layer.msg('请填写优惠券名称!');
			return false;
		}
        if(cut_price == '' || cut_price == undefined){
            layer.msg('请填写面值!');
            return false;
        }
        if(number == '' || number == undefined){
            layer.msg('请填写发放总量!');
            return false;
        }
        // if(is_index_show == '' || is_index_show == undefined){
        //     alert('请选择是否首页显示!');
        //     return false;
        // }
        // if(num_limit == '' || num_limit == undefined){
        //     alert('请选择每人限领!');
        //     return false;
        // }
		return true;
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
</script>