<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<style>
    .tpl-form-line-form #zx-diy-day-text .zx-half-width-input{
        width: 120px;
    }
    .input-group-btn {
        display: block !important;
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
                    <form id="form" action="<?php  echo $this->createWebUrl('diy',array('op'=>'index_playbill'))?>" class="am-form tpl-form-line-form" method="post">
                        <!--本页隐藏传值-->
                        <input type="hidden" name="ids" id="ids" value="<?php  echo $index_playbill_goods['value'];?>" />
                        <!--右侧正文 from 自定义 -->
                        <div class="widget-body">
                            <!--右侧正文 规定所有边距为0 from bootstap -->
                            <fieldset>
                                <!--小标题 from 自定义-->
                                <div class="widget-head am-cf">
                                    <div class="widget-title am-fl">首页海报相关设置</div>
                                </div>
                                <?php  if(!empty($index_playbill_img) && !empty($index_playbill_goods)) { ?>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $index_playbill_img['name'];?> </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <?php echo tpl_form_field_image($index_playbill_img['id'],$index_playbill_img['value']?$index_playbill_img['value']:"");?>
                                        <!--<input type='text' name='<?php  echo $copyright_icon['id'];?>' value="<?php  echo $copyright_icon['value'];?>" class='tpl-form-input' />-->
                                        <span class="color-9">首页海报背景图,推荐在默认图片的基础上更改  <a href="/addons/group_buy/public/bg/index_playbill_bg.jpg" class="text-blue" target="_blank" style="color: #428bca;">点击获取默认图片</a></span>
                                    </div>
                                </div>
                                <?php  } else { ?>
                                缺少配置，请联系管理员
                                <?php  } ?>

                                <div class="widget-head am-cf">
                                    <div class="widget-title am-fl">首页海报商品设置&nbsp;&nbsp;&nbsp;<span class="zx-addBut add-manger" style="display: inline;">
                                        <i class="fa fa-plus"></i> 添加商品
                                    </span></div>

                                </div>
                                <div class="am-form-group">
                                    <!--<label class="am-u-sm-3 am-u-lg-2 am-form-label "></label>-->
                                    <div class="am-u-sm-12 am-u-end">
                                    <table class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap" id="table" >
                                        <thead>
                                        <tr>
                                            <th>名称</th>
                                            <th >封面</th>
                                            <th >原价</th>
                                            <th >现价</th>
                                            <th >操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php  if(!empty($goods)) { ?>
                                            <?php  if(is_array($goods)) { foreach($goods as $k => $v) { ?>
                                            <tr>
                                                <td><?php  echo $v['g_name'];?></td>
                                                <td><img src="<?php  echo tomedia($v['g_icon'])?>" width='25'></td>
                                                <td><s>&yen;<?php  echo $v['g_old_price'];?></s>

                                                </td>
                                                <td>&yen;<?php  echo $v['g_price'];?>

                                                </td>
                                                <td>
                                                    <span class='btn btn-xs btn-danger del-manager'  data-id='<?php  echo $v["g_id"];?>'>删除
                                                        <input type='hidden' name='ids[]' value='<?php  echo $v["g_id"];?>'/>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php  } } ?>
                                        <?php  } ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <!--<div class="am-form-group">-->
                                    <!--<label class="am-u-sm-3 am-u-lg-2 am-form-label ">备注 </label>-->
                                    <!--<div class="am-u-sm-9 am-u-end">-->
                                        <!--<textarea name="comment" style="width: 460px;" row="4" ><?php  echo $info['gsp_comment'];?></textarea>-->
                                    <!--</div>-->
                                <!--</div>-->
                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                        <input type="hidden" name="submit" value="提交"/>
                                        <button type="submit" class="j-submit zx-addBut " id="btn" value="提交" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...'}">提交</button>
                                        <a href="<?php  echo $this->createWebUrl('supplier')?>" id="a-back-index"  ><button class="btn" type="button">返回</button></a>
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
        //提交表单验证
        $(document).on("click","#btn",function () {

        })
        //点击选择商品
        $(document).on("click",".add-manger",function () {
            var ids = $('input[name=ids]').val();
            layer.open({
                title:'选择商品',
                type: 2,
                area: ['750px', '500px'],
                fixed: false, //不固定
                maxmin: true,
                content: "<?php  echo $this->createWebUrl('diy',array('op'=>'getGoods'))?>&ids="+ids
            });
        });
        //取消商品关联
        $(document).on("click",".del-manager",function () {
            $(this).parent("td").parent("tr").remove();
            var ids = '';
            $(".del-manager").each(function () {
                var did = $(this).data().id;
                ids +=','+did;
            });
            $("input[name=ids]").val(ids);
        })
    </script>


<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
</div>
