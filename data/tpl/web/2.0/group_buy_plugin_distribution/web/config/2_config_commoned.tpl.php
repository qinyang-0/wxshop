<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .btn-group .active {
        background-color: #428bca;
        color: #fff;
    }
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{
        border: 0;
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
                    <form action="<?php  echo $this->createWebUrl('config_commoned')?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
                        <!--右侧正文 from 自定义 -->
                        <div class="widget-body">
                            <!--右侧正文 规定所有边距为0 from bootstap -->
                            <fieldset>
                                <!--小标题 from 自定义-->
                                <div class="widget-head am-cf">
                                    <div class="widget-title am-fl">推荐奖设置</div>
                                </div>
                                <!--是否开启-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">推荐奖开启关闭 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline am-success" >
                                            <input type='radio'  name='distribution_commoned_state' value="1" <?php echo $config['distribution_commoned_state']==1?'checked':'';?> data-am-ucheck/>开启
                                        </label>
                                        <label class="am-radio-inline am-success" >
                                            <input type='radio'  name='distribution_commoned_state' value="0" <?php echo $config['distribution_commoned_state']==0 || empty($config['distribution_commoned_state'])?'checked':'';?> data-am-ucheck />关闭
                                        </label>
                                        <div>
                                            <em class="text-danger">是否开启推荐奖(推荐奖、佣金可同时奖励)</em>
                                        </div>
                                    </div>
                                </div>
                                <!--推荐奖金额-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">推荐奖金额(元)</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline am-success" >
                                           <input class="tpl-form-input" name="distribution_commoned_money" value="<?php  echo $config['distribution_commoned_money'];?>" type="text"/>
                                        </label>
                                        <div>
                                            <em class="text-danger">推荐奖金额设置，满足推荐条件即得奖金</em>
                                        </div>
                                    </div>
                                </div>
                                <!-- 推荐奖条件设置 -->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">推荐奖条件设置</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline am-success" >
                                            <table class="table table-hover">

                                                <?php  if(is_array($config_commoned_condition_key_value)) { foreach($config_commoned_condition_key_value as $k => $v) { ?>
                                                <tr>
                                                    <th><?php  echo $v;?></th>
                                                    <td>
                                                        <input name="distribution_commoned_value[<?php  echo $k;?>]" value="<?php echo isset($config['distribution_commoned_value'][$k])?$config['distribution_commoned_value'][$k]:'';?>" type="text" class="tpl-form-input" />
                                                    </td>
                                                </tr>
                                                <?php  } } ?>
                                            </table>
                                        </label>
                                        <div>
                                            <em class="text-danger">推荐奖条件设置，满足该条件即得推荐奖奖金,单笔交易表示下级单笔交易金额大于等于该金额计为有效，下级有效交易单数、推荐人数最小为1，交易总额、单笔交易金额最小为0</em>
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
</script>