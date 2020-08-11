<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
    #check_layer,#check_layer_step2,#change_money_layer{

        display: none;
    }
    .check_list{
        text-align: center;
    }
    .check_list li{
        margin-top: 10px;
        text-align: center;
    }
</style>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
    <div class="row-content am-cf">
        <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                <div class="widget am-cf">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-cf">分销用户申请列表</div>
                    </div>
                    <div class="widget-body am-fr">
                        <!-- 工具栏 -->
                        <div class="page_toolbar am-margin-bottom-xs am-cf">
                            <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">

                        <div class="am-scrollable-horizontal am-u-sm-12">
                            <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
                                <thead class="navbar-inner">
                                <tr>
                                    <th style="width:120px;">昵称</th>
                                    <th style="width:90px;">申请分销时间</th>
                                    <th>申请说明</th>
                                    <th style="width:80px;">审核状态</th>
                                    <th style="width:160px;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  if(!empty($user)) { ?>
                                <?php  if(is_array($user)) { foreach($user as $k => $v) { ?>
                                <tr>
                                    <td><?php  echo $v['m_nickname'];?></td>
                                    <td><?php  echo date("Y-m-d H:i:s",$v['ctime']);?></td>
                                    <td><?php  echo $v['up_comment'];?></td>
                                    <td><?php echo $v['check_state']==1?'审核通过':($v['check_state']==0?'未审核':'审核未通过')?></td>
                                    <td>
                                        <?php  if($v['check_state']!=0) { ?>
                                        <a class="btn btn-success btn-xs" onclick="check_state('<?php  echo $v['uid'];?>','<?php  echo $v['check_state'];?>')">
                                            已审核
                                        </a>
                                        <?php  } else { ?>
                                        <a class="btn btn-warning btn-xs" onclick="check_state('<?php  echo $v['uid'];?>','<?php  echo $v['check_state'];?>')">
                                            未审核
                                        </a>
                                        <?php  } ?>
                                    </td>
                                </tr>
                                <?php  } } ?>
                                <?php  } else { ?>
                                <tr>
                                    <td colspan="999">
                                        暂无数据
                                    </td>
                                </tr>
                                <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="am-u-lg-12 am-cf">
                            <div class="am-fr" style="float: left;">
                                <a class="zx-addBut" href="javascript:window.history.go(-1) ;">返回</a>
                            </div>

                            <?php  echo $page;?>
                            <div class="am-fr pagination-total am-margin-right">
                                <div class="am-vertical-align-middle">总记录：<?php  echo $total;?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="check_layer">
    <ul class="check_list">
        <li>用户申请说明<textarea class="up_comment"></textarea></li>
        <li><button class="agree btn btn-info btn-xs">通过</button>&nbsp;<button class="refuse btn btn-danger btn-xs">拒绝</button></li>
    </ul>
</div>
<div id="check_layer_step2">
    <ul class="check_list">
        <li><span class="comment_title"></span>理由<textarea class="comment"></textarea></li>
        <li><button class="sub btn btn-info btn-xs">确认提交</button></li>
    </ul>
</div>
<div id="change_money_layer">
    <ul class="check_list">
        <li>变动金额<input class="tpl-form-input money_change" type="text" name="money"/></li>
        <li>变动理由<textarea class="change_comment"></textarea></li>
        <li><a class="addmoney btn btn-success btn-xs">增加资金</a>
            <a  class="frize btn btn-info btn-xs">冻结资金</a>
            <a class="unfrize btn btn-danger btn-xs">解冻资金</a>
        </li>
    </ul>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
    function check_state(uid,check_state){
        if(check_state!=0){
            layer.msg("该用户已审核过");
            return false;
        }
        var load = layer.msg('加载中', {
            icon: 16
            ,shade: 0.3
        });
        $.post(
            "<?php  echo $this->createWebUrl('Getuserinfo')?>",
            {uid:uid},
            function(res){
                // console.log(res);
                if(res.status==0 || res.code==0){
                    var info = res.data;
                    var layer_info = $("#check_layer").html();
                    layer.open({
                        title:'审核',
                        type: 1,
                        skin: 'layui-layer-rim', //加上边框
                        area: ['40%', '20%'], //宽高
                        content: layer_info,
                    });
                    $(".up_comment").val(info.up_comment);
                    layer.close(load);
                    $(".agree").click(function(){
                        check_info(info.uid,1);
                    });
                    $(".refuse").click(function(){
                        check_info(info.uid,-1);
                    });
                }
            },'JSON'
        );
    }
    function check_info(uid,state){
        layer.closeAll();
        var title = '';
        if(state==1){
            title = '同意';
        }
        if(state==-1){
            title = '拒绝';
        }
        layer.open({
            title:title+'理由',
            type: 1,
            skin: 'layui-layer-rim', //加上边框
            area: ['40%', '20%'], //宽高
            content: $("#check_layer_step2").html(),
        });
        $(".layui-layer-content").find(".comment_title").text(title);
        $(".sub").click(function(){
            var comment = $(".layui-layer-content").find(".comment").val();
            $.post(
                "<?php  echo $this->createWebUrl('User_exa')?>",
                {uid:uid,state:state,comment:comment},
                function(res){
                    layer.msg(res.msg);
                    if(res.status==0 || res.code==0){
                        location.reload();
                    }
                },'JSON'
            );
        });
    }
    function money_change(uid){
        layer.open({
            title:'资金变动',
            type: 1,
            skin: 'layui-layer-rim', //加上边框
            area: ['40%', '20%'], //宽高
            content: $("#change_money_layer").html(),
        });
        $(".addmoney").click(function(){
            var comment = $(".layui-layer-content").find(".change_comment").val();
            var money = $(".layui-layer-content").find(".money_change").val();
            money = parseFloat(money);
            var data = {uid:uid,type:1,money:money,comment:comment};
            console.log(data);
            $.post(
                "<?php  echo $this->createWebUrl('Change_user_money')?>",
                data,
                function(res){
                    console.log(res);
                },'JSON'
            );
        });
        $(".frize").click(function(){
            var comment = $(".layui-layer-content").find(".change_comment").val();
            var money = $(".layui-layer-content").find(".money_change").val();
            money = parseFloat(money);
            var data = {uid:uid,type:2,money:money,comment:comment};
            console.log(data);
            $.post(
                "<?php  echo $this->createWebUrl('Change_user_money')?>",
                data,
                function(res){
                    console.log(res);
                },'JSON'
            );
        });
        $(".unfrize").click(function(){
            var comment = $(".layui-layer-content").find(".change_comment").val();
            var money = $(".layui-layer-content").find(".money_change").val();
            money = parseFloat(money);
            var data = {uid:uid,type:3,money:money,comment:comment};
            console.log(data);
            $.post(
                "<?php  echo $this->createWebUrl('Change_user_money')?>",
                data,
                function(res){
                    console.log(res);
                    layer.msg(res.msg);
                    if(res.status==0 || res.code==0){
                        location.reload();
                    }
                },'JSON'
            );
        });
    }
</script>
