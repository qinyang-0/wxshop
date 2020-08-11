<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .btn-group .active {
        background-color: #428bca;
        color: #fff;
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
                    <form action="<?php  echo $this->createWebUrl('config_exa')?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
                        <!--右侧正文 from 自定义 -->
                        <div class="widget-body">
                            <!--右侧正文 规定所有边距为0 from bootstap -->
                            <fieldset>
                                <!--小标题 from 自定义-->
                                <div class="widget-head am-cf">
                                    <div class="widget-title am-fl">审核设置</div>
                                </div>
                                <!--是否开启-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">是否开启人工审核</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline am-success" >
                                            <input type='radio'  name='distribution_exa' value="0" <?php echo $config['distribution_exa']==0 || empty($config['distribution_exa'])?'checked':'';?> data-am-ucheck/>不人工审核
                                        </label>
                                        <label class="am-radio-inline am-success" >
                                            <input type='radio'  name='distribution_exa' value="1" <?php echo $config['distribution_exa']==1 ?'checked':'';?> data-am-ucheck />人工审核
                                        </label>
                                        <div>
                                            <em class="text-danger">是否开启人工审核功能，开启后，用户需提交审核信息才可成为分销商</em>
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