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
                    <form action="<?php  echo $this->createWebUrl('config',array('op'=>'wxapp'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
                        <!--右侧正文 from 自定义 -->
                        <div class="widget-body">
                            <!--右侧正文 规定所有边距为0 from bootstap -->
                            <fieldset>
                                <!--小标题 from 自定义-->
                                <div class="widget-head am-cf">
                                    <div class="widget-title am-fl">小程序配置</div>
                                </div>
                                <?php  if(!empty($info)) { ?>
                                <!--佣金配置-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">小程序APPID</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type='text'  name='key' value="<?php  echo $info['key'];?>" class='tpl-form-input' />
                                        <span class="color-9"></span>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">小程序SECRET</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type='text'  name='secret' value="<?php  echo $info['secret'];?>" class='tpl-form-input' />
                                        <span class="color-9"></span>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">微信支付商户号</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type='text'  name='mchid' value="<?php  echo $payment['mchid'];?>" class='tpl-form-input' />
                                        <span class="color-9"></span>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">微信支付密钥</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type='text'  name='signkey' value="<?php  echo $payment['signkey'];?>" class='tpl-form-input' />
                                        <span class="color-9"></span>
                                    </div>
                                </div>

                                <!---->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $pem['cert_address']['name'];?>（apiclient_cert.pem） </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type='file' name='cert_address'   class="hidden cert_real_click" />
                                        <span class="btn btn-warning cert_select">选择文件</span>&nbsp;&nbsp;
                                        <input type='hidden' name='old_cert_address' value="<?php  echo $pem[31]['value'];?>"   />
                                        <span id="cert_select_name"><?php echo !empty($pem['cert_address']['value'])?'已上传':$pem['cert_address']['value'];?></span>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"><?php  echo $pem['key_address']['name'];?>（apiclient_key.pem） </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type='file' name='key_address'  class="hidden key_real_click" />
                                        <span class="btn btn-warning key_select">选择文件</span>&nbsp;&nbsp;
                                        <input type='hidden' name='old_key_address' value="<?php  echo $pem['key_address']['value'];?>"   />
                                        <span id="key_select_name"><?php echo !empty($pem['key_address']['value'])?'已上传':$pem['key_address']['value'];?></span>
                                    </div>
                                </div>

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
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>