<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<style>
    .tpl-form-line-form #zx-diy-day-text .zx-half-width-input{
        width: 120px;
    }
    .input-group-btn {
        display: block;
    }
    /*微擎底层时间插件样式*/
    .daterangepicker select.ampmselect, .daterangepicker select.hourselect, .daterangepicker select.minuteselect{
        width: auto;
        padding-right: 40px;
    }
    .tpl-form-line-form .am-checkbox-inline .am-ucheck-icons{
        line-height: 21px;
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
                    <form id="form" action="<?php  echo $this->createWebUrl('action',array('op'=>'add'))?>" class="am-form tpl-form-line-form" method="post">
                        <!--本页隐藏传值-->
                        <input type="hidden" name="id" id="id" value="<?php  echo $info['at_id'];?>" />
                        <!--右侧正文 from 自定义 -->
                        <div class="widget-body">
                            <!--右侧正文 规定所有边距为0 from bootstap -->
                            <fieldset>
                                <!--小标题 from 自定义-->
                                <div class="widget-head am-cf">
                                    <div class="widget-title am-fl"><?php  echo $act_title;?>活动</div>
                                </div>
                                <!--表单项开始 from 妹子-->
                                <div class="am-form-group">
                                    <!-- form-require表单项必填 from 自定义-->
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">活动标题 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type="text" class="tpl-form-input" name="name" value="<?php  echo $info['at_name'];?>" required="" data-validation-message="活动标题必填">
                                    </div>
                                </div>

                                <!--<div class="am-form-group">-->
                                    <!--<label class="am-u-sm-3 am-u-lg-2 am-form-label ">活动描述 </label>-->
                                    <!--<div class="am-u-sm-9 am-u-end">-->
                                        <!--<input type="text" class="tpl-form-input" name="brief" value="<?php  echo $info['at_brief'];?>">-->
                                    <!--</div>-->
                                <!--</div>-->
                                <!--<div class="am-form-group">-->
                                    <!--<label class="am-u-sm-3 am-u-lg-2 am-form-label ">排序 </label>-->
                                    <!--<div class="am-u-sm-9 am-u-end">-->
                                        <!--<input type="text" class="tpl-form-input" name="order" value="<?php  echo $info['at_order'];?>">-->
                                    <!--</div>-->
                                <!--</div>-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">活动时间 </label>
                                    <div class="am-u-sm-9 am-u-end" style="display: flex">
                                        <!--<div class="tpl-form-border-form zx-form-input zx-display zx-group am-datepicker-date am-input-group" data-am-datepicker="{format: 'dd-mm-yyyy'}">-->
                                            <!--<input type="text" autocomplete="off" name="action_time[start]" class="am-form-field" placeholder="请选择起始日期" data-am-datepicker="" value="<?php echo empty($info['at_start_time'])?'':date('Y-m-d',$info['at_start_time'])?>"  data-validation-message="请选择活动开始时间" readonly>-->
                                            <!--<span class="am-input-group-btn am-datepicker-add-on">-->
                                                <!--<button class="am-btn am-btn-default" type="button"><span class="am-icon-calendar"></span></button></span>-->
                                        <!--</div>-->
                                        <!--<span class="zx&#45;&#45; am-vertical-align">-->
											<!--<span class="am-vertical-align-middle">-->
                                                <!-- - -->
                                            <!--</span>-->
										<!--</span>-->
                                        <!--<div class="tpl-form-border-form zx-form-input zx-display zx-group am-datepicker-date am-input-group" data-am-datepicker="{format: 'yyyy-dd-mm'}">-->
                                            <!--<input type="text" autocomplete="off" name="action_time[end]" class="am-form-field" placeholder="请选择截止日期" data-am-datepicker="" value="<?php echo empty($info['at_end_time'])?'':date('Y-m-d',$info['at_end_time'])?>"  data-validation-message="请选择活动结束时间" readonly>-->
                                            <!--<span class="am-input-group-btn am-datepicker-add-on">-->
                                                <!--<button class="am-btn am-btn-default" type="button"><span class="am-icon-calendar"></span></button></span>-->
                                        <!--</div>-->
                                        <?php echo tpl_form_field_daterange('action_time', array('start'=> date('Y-m-d H:i:s',empty($info['at_start_time'])?time():$info['at_start_time']),'end'=> date('Y-m-d H:i:s',empty($info['at_end_time'])?time():$info['at_end_time']) ),true);?>
                                    </div>
                                    <br/>
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> </label>
                                    <div class="am-u-sm-9 am-u-end" style="display: flex">
                                    <span class="color-9">注：日期范围可以在弹层右下角选择分和秒</span>
                                    </div>
                                </div>

                                <div class="am-form-group am-form-success">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">几日后到货 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-checkbox-inline" style="padding-top:0; line-height: 21px;">
                                            <input type="radio" name="at_arrival_time" value="0" data-am-ucheck="" <?php  if($info['at_arrival_time']==0) { ?> checked="" <?php  } ?> class="am-ucheck-radio am-field-valid" require data-validation-message="请选择几日后到货">
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            <span class="am-ucheck-icons" >
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            当日到
                                        </label>
                                        <label class="am-checkbox-inline" style="padding-top:0; line-height: 21px;">
                                            <input type="radio" name="at_arrival_time" value="1" data-am-ucheck="" <?php  if($info['at_arrival_time']==='1' || (empty($info['at_arrival_time']) && $info['at_arrival_time']!=0)) { ?> checked="" <?php  } ?> class="am-ucheck-radio am-field-valid" >
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            次日到
                                        </label>
                                        <label class="am-checkbox-inline" style="padding-top:0;line-height: 21px; ">
                                            <input type="radio" name="at_arrival_time" value="2" data-am-ucheck="" <?php  if($info['at_arrival_time']==='2') { ?> checked="" <?php  } ?> class="am-ucheck-radio am-field-valid" >
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            隔日到
                                        </label>
                                        <label class="am-checkbox-inline" style="padding-top:0; line-height: 21px;">
                                            <input type="radio" id="zx-diy-day" name="at_arrival_time" value="<?php  if($info['at_arrival_time']>=3) { ?><?php  echo $info['at_arrival_time'];?><?php  } ?>" data-am-ucheck="" <?php  if($info['at_arrival_time']>=3) { ?> checked="" <?php  } ?> class="am-ucheck-radio am-field-valid">
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            自定义
                                        </label>
                                        <label class="am-vertical-align" style="display: <?php echo $info['at_arrival_time']>=3?'inline-block':'none'; ?>;" id="zx-diy-day-text">
                                            <input type="text" value="<?php  echo $info['at_arrival_time'];?>" id="zx-diy-day-input" class="am-u-sm-4 zx-half-width-input"/>
                                            <span class="am-vertical-align-middle am-padding-vertical-xs">天后到货</span>
                                        </label>
                                        <label class="am-checkbox-inline" style="padding-top:0; line-height: 21px;">
                                            <big><i class="fa fa-question-circle-o zx-hand-hover zx-layer-tip-r" data-tip="请选择天数，若超过3天请自定义填写"></i></big>
                                        </label>
                                        <!--<input type="text" class="tpl-form-input" name="name" value="<?php  echo $info['at_name'];?>" required="">-->
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">到货时间自定义文本 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type="text" class="tpl-form-input" name="at_arrival_time_text" value="<?php  echo $info['at_arrival_time_text'];?>" required="" data-validation-message="请填写到货时间自定义文本">
                                        <span class="color-9">首页风格3下可以显示出来，其他风格位置不够显示</span>
                                    </div>
                                </div>

                                <div class="am-form-group am-form-success">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">是否限制小区 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline">
                                            <input type="radio" name="is_limit" value="1" data-am-ucheck="" <?php  if($info['at_is_limit'] == 1 || empty($info['at_is_limit']) ) { ?>checked<?php  } ?> class="am-ucheck-radio am-field-valid">
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            不限制

                                        </label>
                                        <label class="am-radio-inline">
                                            <input type="radio" name="is_limit" value="-1" data-am-ucheck="" <?php  if($info['at_is_limit']==='-1') { ?> checked="" <?php  } ?> class="am-ucheck-radio am-field-valid">
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            限制
                                        </label>
                                        <br>
                                        <span class="color-9">限制小区后，可以去选择想开启此活动的小区，开启的小区才能看到活动商品，不限制则所有小区可看</span>
                                    </div>
                                </div>

                                <div class="am-form-group am-form-success">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">团长自动开启商品 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline">
                                            <input type="radio" name="is_head_open" value="1" data-am-ucheck="" <?php  if($info['at_is_head_open'] == 1  ) { ?>checked<?php  } ?> class="am-ucheck-radio am-field-valid">
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            开启
                                        </label>
                                        <label class="am-radio-inline">
                                            <input type="radio" name="is_head_open" value="-1" data-am-ucheck="" <?php  if($info['at_is_head_open']==='-1' || empty($info['at_is_head_open'])) { ?> checked="" <?php  } ?> class="am-ucheck-radio am-field-valid">
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            <span class="am-ucheck-icons">
                                                <i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>
                                            </span>
                                            不开启
                                        </label>
                                        <br/>
                                        <span class="color-9">
                                            开启后团长无法选择在小程序中设置自己想显示的产品
                                        </span>
                                    </div>
                                </div>
                                <!--<div class="am-form-group am-form-success">-->
                                    <!--<label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">是否首页显示 </label>-->
                                    <!--<div class="am-u-sm-9 am-u-end">-->
                                        <!--<label class="am-radio-inline">-->
                                            <!--<input type="radio" name="is_show" value="1" data-am-ucheck="" <?php  if($info['at_is_index_show'] == 1 || empty($info['at_is_index_show']) ) { ?>checked<?php  } ?> class="am-ucheck-radio am-field-valid">-->
                                            <!--<span class="am-ucheck-icons">-->
                                                <!--<i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>-->
                                            <!--</span>-->
                                            <!--<span class="am-ucheck-icons">-->
                                                <!--<i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>-->
                                            <!--</span>-->
                                            <!--启用-->
                                        <!--</label>-->
                                        <!--<label class="am-radio-inline">-->
                                            <!--<input type="radio" name="is_show" value="-1" data-am-ucheck="" <?php  if($info['at_is_index_show']==='-1') { ?> checked="" <?php  } ?> class="am-ucheck-radio am-field-valid">-->
                                            <!--<span class="am-ucheck-icons">-->
                                                <!--<i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>-->
                                            <!--</span>-->
                                            <!--<span class="am-ucheck-icons">-->
                                                <!--<i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>-->
                                            <!--</span>-->
                                            <!--禁用-->
                                        <!--</label>-->
                                    <!--</div>-->
                                <!--</div>-->
                                <!--<div class="am-form-group am-form-success">-->
                                    <!--<label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">是否为秒杀活动 </label>-->
                                    <!--<div class="am-u-sm-9 am-u-end">-->
                                        <!--<label class="am-radio-inline">-->
                                            <!--<input type="radio" name="is_kill" value="-1" data-am-ucheck="" <?php  if($info['at_is_seckill'] == -1 || empty($info['at_is_seckill']) ) { ?>checked<?php  } ?> class="am-ucheck-radio am-field-valid">-->
                                            <!--<span class="am-ucheck-icons">-->
                                                <!--<i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>-->
                                            <!--</span>-->
                                            <!--<span class="am-ucheck-icons">-->
                                                <!--<i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>-->
                                            <!--</span>-->
                                            <!--非秒杀-->
                                        <!--</label>-->
                                        <!--<label class="am-radio-inline">-->
                                            <!--<input type="radio" name="is_kill" value="1" data-am-ucheck="" <?php  if($info['at_is_seckill']==='1') { ?> checked="" <?php  } ?> class="am-ucheck-radio am-field-valid">-->
                                            <!--<span class="am-ucheck-icons">-->
                                                <!--<i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>-->
                                            <!--</span>-->
                                            <!--<span class="am-ucheck-icons">-->
                                                <!--<i class="am-icon-unchecked"></i><i class="am-icon-checked"></i>-->
                                            <!--</span>-->
                                            <!--秒杀-->
                                        <!--</label>-->
                                    <!--</div>-->
                                <!--</div>-->
                                <!--<div class="am-form-group">-->
                                    <!--<label class="am-u-sm-3 am-u-lg-2 am-form-label ">浏览量 </label>-->
                                    <!--<div class="am-u-sm-9 am-u-end">-->
                                        <!--<input type="text" class="tpl-form-input" name="see_num" value="<?php  echo $info['at_see_num'];?>">-->
                                    <!--</div>-->
                                <!--</div>-->
                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                        <input type="hidden" name="submit" value="提交"/>
                                        <button type="submit" class="j-submit zx-addBut " id="btn" value="提交" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...'}">提交</button>
                                        <a href="<?php  echo $this->createWebUrl('action')?>" id="a-back-index"  ><button class="btn" type="button">返回</button></a>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var tips = '';
        $(document).on('mouseover','.zx-layer-tip-r',function () {
            var text = $(this).attr('data-tip');
            tips = layer.tips(text,$(this));
        });
        $(document).on('mouseout','.zx-layer-tip-r',function () {
            layer.close(tips);
        })
        //选择提货时间，传入给input提交
        $(document).on("click","input[name=at_arrival_time]",function () {
            if ($('#zx-diy-day').is(':checked')) {
                $("#zx-diy-day-text").show();
                $("#zx-diy-day-input").focus();
            } else {
                $("#zx-diy-day-text").hide();
            }
        });
        //当输入自定义到货时间后
        $(document).on("input propertychange","#zx-diy-day-input",function () {
            var val =  $(this).val();
            $("#zx-diy-day").val(val);
        });
    </script>
    <script type="text/javascript">
        // $(function () {
        //     $('#form').validator({
        //
        //         submit:function() {
        //             // console.log(123);
        //             layer.close();
        //             var action_time_start = $("input[name='action_time[start]']").val(); //开始时间
        //             var action_time_end = $("input[name='action_time[end]']").val(); //结束时间
        //             var name = $("input[name=name]").val(); //活动标题
        //             var at_arrival_time_text = $("input[name=at_arrival_time_text]").val(); //到货提示文本
        //             if (name == '' || name == undefined) {
        //                 layer.msg('请填写活动标题',{icon:5});
        //                 return false;
        //             }
        //             if (action_time_start == '' || action_time_start == undefined) {
        //                 layer.msg('请选择活动开始时间',{icon:5});
        //                 return false;
        //             }
        //             if (action_time_end == '' || action_time_end == undefined) {
        //                 layer.msg('请选择活动结束时间',{icon:5});
        //                 return false;
        //             }
        //             if (at_arrival_time_text == '' || at_arrival_time_text == undefined) {
        //                 layer.msg('请填写到货提示文本',{icon:5});
        //                 return false;
        //             }
        //             $.post("<?php  echo $this->createWebUrl('action',array('op'=>'add'))?>", $('#form').serialize(), function (res) {
        //                 // return false;
        //                 console.log(res);
        //                 if (res.status == 0) {
        //                     layer.msg(res.msg,{icon:1});
        //                     setTimeout(function(){
        //                         window.location.href=res.url;
        //                     }, 1000);
        //
        //                 } else if(res.status == 1) {
        //                     layer.msg(res.msg,{icon:2});
        //                 }
        //             }, "JSON");
        //             //下面这个不能删，如果要异步
        //             return false;
        //         },
        //         onValid: function(validity) {
        //             layer.close();
        //         },
        //         onInValid: function(validity) {
        //             var $field = $(validity.field);
        //             var msg = $field.data('validationMessage') || this.getValidationMessage(validity);
        //             layer.msg(msg,{icon:5});
        //             return false;
        //         }
        //     });
        // });

    </script>
</div>
<!-- 内容区域 end -->

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
