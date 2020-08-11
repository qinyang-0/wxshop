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
                    <form action="<?php  echo $this->createWebUrl('config_state')?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
                        <!--右侧正文 from 自定义 -->
                        <div class="widget-body">
                            <!--右侧正文 规定所有边距为0 from bootstap -->
                            <fieldset>
                                <!--小标题 from 自定义-->
                                <div class="widget-head am-cf">
                                    <div class="widget-title am-fl">基本设置</div>
                                </div>
                                <!--后台名称设置-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">后台名称设置</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline am-success" >
                                            <input class="tpl-form-input" name="distribution_site_name" value="<?php  echo current($site_name)?>" type="text"/>
                                        </label>
                                        <div>
                                            <em class="text-danger">后台名称设置，左上角显示</em>
                                        </div>
                                    </div>
                                </div>
                                <!--是否开启-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo key($state)?> </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline am-success" >
                                            <input type='radio'  name='distribution_state' value="1" <?php echo current($state)==1?'checked':'';?> data-am-ucheck/>开启
                                        </label>
                                        <label class="am-radio-inline am-success" >
                                            <input type='radio'  name='distribution_state' value="0" <?php echo current($state)==0 || empty(current($state))?'checked':'';?> data-am-ucheck />关闭
                                        </label>
                                        <div>
                                            <em class="text-danger">是否开启分销功能</em>
                                        </div>
                                    </div>
                                </div>
                                <!--开启分销等级-->
                                <div class="am-form-group" style="display: <?php echo current($state)==='1'?'block':'none';?>;">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo key($lv)?> </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline am-success" >
                                            <input type='radio'  name='distribution_lv' value="1" <?php echo current($lv)==='1'?'checked':'';?> data-am-ucheck/>1级分销
                                        </label>
                                        <label class="am-radio-inline am-success" >
                                            <input type='radio'  name='distribution_lv' value="2" <?php echo current($lv)==='2'?'checked':'';?> data-am-ucheck/>2级分销
                                        </label>
                                        <label class="am-radio-inline am-success" >
                                            <input type='radio'  name='distribution_lv' value="3" <?php echo current($lv)==='3'?'checked':'';?> data-am-ucheck/>3级分销
                                        </label>
                                        <div>
                                            <em class="text-danger">分销等级设置，涉及到用户佣金，请勿随便修改!</em>
                                        </div>
                                    </div>
                                </div>
                                <!--分销推广海报背景图-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">分销推广海报背景图</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline am-success" >
                                            <?php echo tpl_form_field_image(distribution_playbill_img, current($distribution_playbill_img)?current($distribution_playbill_img):"");?>
                                        </label>
                                        <div>
                                            <em class="text-danger">分销推广海报背景图</em>
                                        </div>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
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


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<script>
    $("input[name='distribution_state']").change(function(){
        var va = $(this).val();
        // console.log(va);
        if(va!=1){
            $(".am-form-group").eq(2).hide();
        }else{
            $(".am-form-group").eq(2).show();
        }
    });
</script>