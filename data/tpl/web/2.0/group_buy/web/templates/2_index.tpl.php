<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .btn-group .active {
        background-color: #428bca;
        color: #fff;
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
    .none{
        display: none;
    }
    /*controller=user.get_supply_goods*/
    .form-control2{

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
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12" style="background: white;">
                <!--widget自定义右侧盒子 from 自定义 am-cf 清除全部浮动  from 妹子-->
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">订阅消息</div>
                </div>
                <div class="widget am-cf">
                    <div class="am-tabs am-tabs-d2">
                        <ul class="am-tabs-nav am-cf" style="margin-bottom: 30px;">
                            <li class="am-active" id="order">
                                <a href="#order" class="good_nav" data-id="order">小程序消息 </a>
                            </li>
                            <li class="" id="wx">
                                <a href="#wx" class="good_nav" data-id="wx">公众号消息</a>
                            </li>
                        </ul>
                    </div>
                    <form action="<?php  echo $this->createWebUrl('wechat',array('op'=>'add'))?>" method="post" class="am-form tpl-form-line-form" enctype="multipart/form-data">
                        <!--右侧正文 from 自定义 -->
                        <div class="widget-body">
                            <!--右侧正文 规定所有边距为0 from bootstap -->
                            <fieldset>
                                <!--小标题 from 自定义-->
                                <!--//订单类-->
                                <div class="nav_order nav_goods_add">
                                    <div style="border: 1px solid #ccc; padding: .625em;line-height: 24px;margin-bottom: 30px;color:red;">
                                        <div style="color:#4c4c4c;margin-bottom: 10px;">
                                            <div>使用方法：</div>
                                            <div>
                                                <span>1. 请先确认小程序已开通订阅消息</span>
                                                <br>
                                                <span>2. 确认小程序订阅消息模板库为空以保证正常添加，如已有模板请先删除</span>
                                                <br>
                                                <span>3. 确认已添加下列类目</span>
                                                <br>
                                                <span style="color: red">商家自营 > 服装/鞋/箱包 <br/>
                                                    生活服务 > 线下超市/便利店</span>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="javascript:;" style="color: white;" class="zx-addBut" id="oneadd_btn">一键添加订阅消息</a>
                                            <a href="javascript:;" style="color: white;" class="zx-addBut btn-danger" id="onedel_btn">一键清空模板库</a>
                                        </div>
                                    </div>
                                    <div class="am-scrollable-horizontal am-u-sm-12">
                                        <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap ">
                                            <thead class="navbar-inner">
                                            <tr>
                                                <th style="width: 400px;">模板名称</th>
                                                <th >模板ID</th>
                                                <th >是否启用</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>支付成功通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['pay_suc']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="pay_suc" data-type="g_is_top" data-state="<?php  if($info['pay_suc']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['pay_suc']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>申请团长通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['team_leader']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="team_leader" data-type="g_is_top" data-state="<?php  if($info['team_leader']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['team_leader']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>提现申请通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['cash_money']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="cash_money" data-type="g_is_top" data-state="<?php  if($info['cash_money']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['cash_money']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>



                                                <tr>
                                                    <td>退款申请通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['refund_msg']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="refund_msg" data-type="g_is_top" data-state="<?php  if($info['refund_msg']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['refund_msg']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>发货通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['deliver_msg']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="deliver_msg" data-type="g_is_top" data-state="<?php  if($info['deliver_msg']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['deliver_msg']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>会员卡开通成功通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['recharge_msg']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="recharge_msg" data-type="g_is_top" data-state="<?php  if($info['recharge_msg']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['recharge_msg']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>充值成功通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['vip_msg']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="vip_msg" data-type="g_is_top" data-state="<?php  if($info['vip_msg']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['vip_msg']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>砍价进度通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['bargain_msg']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="bargain_msg" data-type="g_is_top" data-state="<?php  if($info['bargain_msg']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['bargain_msg']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>拼团成功通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['pteam_suc']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="pteam_suc" data-type="g_is_top" data-state="<?php  if($info['pteam_suc']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['pteam_suc']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>拼团失败通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['pteam_fail']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="pteam_fail" data-type="g_is_top" data-state="<?php  if($info['pteam_fail']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['pteam_fail']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="nav_wx nav_goods_add none">
                                    <div class="am-alert  notice_box" style="background-color: #fff;border-color: #22c397;color: #4c4c4c;" >
                                        <div style="line-height: 25px;">
                                            <div>使用方法：</div>
                                            <div>
                                                <span>1. 填写公众号appid secret并保存,且确保服务器ip在公众号ip白名单中</span>
                                                <br>
                                                <span>2. 请先确认公众号已开通模板消息</span>
                                                <br>
                                                <span>3. 确认认公众号模板消息模板库为空以保证正常添加，如已有模板请先删除</span>
                                                <br>
                                                <span>4. 确认已添加下列类目</span>

                                                <span style="color: red">IT科技 > 互联网|电子商务</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nav_order">
                                        <div style="border: 1px solid #ccc; padding: 25px;line-height: 24px;margin-bottom: 30px;color:red;">

                                            <div>

                                                <div class="am-form-group">
                                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">公众号appid </label>
                                                    <div class="am-u-sm-9 am-u-end">
                                                        <input type='text' name='wechat_appid' value="<?php  echo $conf['wechat_appid'];?>" class='tpl-form-input' />
                                                        <span class="color-9"></span>
                                                    </div>
                                                </div>

                                                <div class="am-form-group">
                                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">公众号secert </label>
                                                    <div class="am-u-sm-9 am-u-end">
                                                        <input type='text' name='wechat_secert' value="<?php  echo $conf['wechat_secert'];?>" class='tpl-form-input' />
                                                        <span class="color-9"></span>
                                                    </div>
                                                </div>

                                                <div class="am-form-group">
                                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">接收消息管理员openid </label>
                                                    <div class="am-u-sm-9 am-u-end">
                                                        <textarea name='refund_msg_openid' class='tpl-form-input' placeholder="请填写管理员openid,多个请用英文逗号,间隔,留空则不会发送消息"><?php  echo $conf['refund_msg_openid'];?></textarea>
                                                        <span class="color-9">请去左侧菜单-会员-查看openid,多个请用英文逗号,间隔,</span><a target="_blank" href="<?php  echo $this->createWebUrl('member')?>" style="color: red">去查看</a>
                                                    </div>
                                                </div>

                                                <div class="am-form-group">
                                                    <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                                        <a type="submit" class="j-submit zx-addBut " id="save_wechat">保存</a>
                                                    </div>
                                                </div>




                                            </div>
                                        </div>
                                        <a href="javascript:;" style="color: white;margin-bottom: 30px" class="zx-addBut" id="oneadd_wechat">一键添加公众号消息</a>
                                        <div class="am-scrollable-horizontal am-u-sm-12">
                                            <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap ">
                                                <thead class="navbar-inner">
                                                <tr>
                                                    <th style="width: 400px;">模板名称</th>
                                                    <th >模板ID</th>
                                                    <th >是否启用</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr>
                                                    <td>支付成功给团长通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['tmp_leader']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="pay_suc" data-type="g_is_top" data-state="<?php  if($info['tmp_leader']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['tmp_leader']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>发货给团长通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['tmp_deviler']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="pay_suc" data-type="g_is_top" data-state="<?php  if($info['tmp_deviler']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['tmp_deviler']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>退款给管理员通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['tmp_refund']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="pay_suc" data-type="g_is_top" data-state="<?php  if($info['tmp_refund']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['tmp_refund']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>订单付款给管理员通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['tmp_paymsg']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="tmp_paymsg" data-type="g_is_top" data-state="<?php  if($info['tmp_paymsg']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['tmp_paymsg']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>申请提现给管理员通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['tmp_cashmsg']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="tmp_cashmsg" data-type="g_is_top" data-state="<?php  if($info['tmp_cashmsg']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['tmp_cashmsg']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>团长申请给管理员通知</td>
                                                    <td>
                                                        <input name="" readonly value="<?php  echo $info['tmp_headmsg']['tmpid'];?>" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <div class="tpl-switch">
                                                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="is_use" data-name="tmp_cashmsg" data-type="g_is_top" data-state="<?php  if($info['tmp_headmsg']['is_use']==1) { ?>0<?php  } else { ?>1<?php  } ?>" <?php  if($info['tmp_headmsg']['is_use']==1) { ?> checked="" <?php  } ?>>
                                                            <div class="tpl-switch-btn-view">
                                                                <div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
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
    $(document).on("change","select[name='wechat_id[value]']",function () {
        if($(this).val()=="1"){
            $("#is-show").removeClass("hidden");
        }else{
            $("#is-show").addClass("hidden");
        }
    })
    $('.good_nav').click(function(res){
        var id = $(this).data('id');
        $(".am-tabs-nav li").removeClass('am-active');
        $("#"+id).addClass('am-active');
        $(".nav_goods_add").hide();
        $(".nav_"+id).show();
    })

    $(document).on("change","input[name='is_use']",function (res) {
        var name = $(this).data("name");
        $.post(
            "<?php  echo $this->createWebUrl('templates',array('op'=>'change_use'))?>",
            {name:name},
            function(res){
                // console.log(res);
                layer.msg(res.msg);
            },'json'
        );
    });
    //一键添加
    $("#oneadd_btn").click(function(){
        var index = layer.load(0, {shade: [0.3, '#000'],shadeClose:false});
        $.get(
            "<?php  echo $this->createWebUrl('templates',array('op'=>'onebtnadd'))?>",
            function(res){
                layer.close(index);
                console.log(res);
                layer.msg(res.msg);
                if(res.status==0 && res.err>0){
                    var error_info = "";
                    $.each(res.errlist,function(k,v){
                        error_info += v.openmsg+"<br/>";
                    });
                    //有错误信息
                    layer.open({
                        title:'添加失败信息',
                        type: 1,
                        area: ['auto', 'auto'], //宽高
                        content: error_info
                    });
                }
                if(res.status==0 && res.err<1){
                    window.location.reload();
                }
            },'json'
        );
    });
    //一键清空
    $("#onedel_btn").click(function(){
        var index = layer.load(0, {shade: [0.3, '#000'],shadeClose:false});
        $.get(
            "<?php  echo $this->createWebUrl('templates',array('op'=>'cleartemp'))?>",
            function(res){
                layer.close(index);
                console.log(res);
                layer.msg(res.msg);
                if(res.status==0 && res.err>0){
                    //有错误信息
                    var error_info = "";
                    $.each(res.errlist,function(k,v){
                        error_info += v.tmp+"删除失败，错误信息"+v.msg+"<br/>";
                    });
                    //有错误信息
                    layer.open({
                        title:'添加失败信息',
                        area: ['auto', 'auto'], //宽高
                        content: error_info
                    });
                }
                if(res.status==0 && res.err<1){
                    window.location.reload();
                }
            },'json'
        );
    });
    //一键添加 公众号模板
    $("#oneadd_wechat").click(function(){
        var index = layer.load(0, {shade: [0.3, '#000'],shadeClose:false});
        $.get(
            "<?php  echo $this->createWebUrl('templates',array('op'=>'addwechat'))?>",
            function(res){
                console.log(res);
                layer.close(index);
                console.log(res);
                layer.msg(res.errmsg);
                if(res.status==0 && res.err>0){
                    //有错误信息
                    var error_info = "";
                    $.each(res.errlist,function(k,v){
                        error_info += "模板"+k+"添加失败，错误"+v+"<br/>";
                    });
                    //有错误信息
                    layer.open({
                        title:'添加失败信息',
                        area: ['auto', 'auto'], //宽高
                        content: error_info
                    });
                }
                if(res.status==0 && res.err<1){
                    window.location.reload();
                }
            },'json'
        );
    });
    $("#save_wechat").click(function(){
        //保存appid和secret
        var data = {};
        data['wechat_appid'] = $("input[name='wechat_appid']").val();
        data['wechat_secert'] = $("input[name='wechat_secert']").val();
        data['refund_msg_openid'] = $("textarea[name='refund_msg_openid']").val();
        $.post(
            "<?php  echo $this->createWebUrl('templates',array('op'=>'savewechat'))?>",
            data,
            function(res){
                console.log(res);
                layer.msg(res.msg);
                if(res.status==0){
                    window.location.reload();
                }
            },'json'
        );
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
