<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
    /*顶部部分*/
    .todayboxs {
        margin: 24px 0;
    }

    .flex-items {
        display: flex;
    }

    .todayboxs .flex-item {
        background-color: #fff;
        width: 100%;
        height: 104px;
        padding: 20px;
        display: flex;
        align-items: center;
        margin-right: 24px;
        color: #333;
        box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.05);
    }

    .flex-items .flex-item {
        flex: 1;
    }

    .todayboxs .icon {
        width: 56px;
        height: auto;
        margin-right: 16px;
    }

    img {
        vertical-align: middle;
        border: 0;
    }

    .todayboxs .num {
        font-size: 24px;
    }

    /*顶部部分结束*/
    /*中部*/
    .row-panel {
        margin-bottom: 24px;
        display: flex;
        padding-right: 24px;
    }

    .row-panel .row-panel-7 {
        width: 50%;
        flex-shrink: 1;
    }


    .mypanel .mypanel-heading {
        font-size: 15px;
        font-weight: 600;
        border-bottom: 1px solid #f0f0f0;
        height: 48px;
        line-height: 48px;
    }

    .tasks .flex-item {
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-right: 20px;
        border-bottom: 1px solid #f0f0f0;
        color: #747474;
    }

    .row-panel .row-panel-5 {
        width: 50%;
        margin-left: 24px;
        flex-shrink: 0;
    }

    .tasks .num.hasnum {
        color: #436be6;
    }

    .tasks .num {
        font-size: 15px;
        color: #9e9e9e;
        font-weight: 600;
    }


    .quick-panel .mypanel-body, .total-panel .mypanel-body {
        padding: 20px 0;
    }

    .total-mes .num {
        height: 48px;
        line-height: 48px;
        font-size: 15px;
        color: #333;
        font-weight: 600;
    }

    .quick-nav .flex-item, .total-mes .flex-item {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        height: 68px;
        margin-bottom: 20px;
        margin-right: 20px;
        color: #747474;
    }

    .quick-nav .fa {
        height: 48px;
        line-height: 48px;
        font-size: 24px;
        display: block;
        transition: all 0.3s;
    }

    .quick-nav .flex-item:hover {
        color: #22c397;
    }

    .quick-nav .flex-item:hover i {
        font-size: 40px;
    }
/*排行榜*/
    .flex-item {
        background-color: #fff;
        width: 100%;
        padding: 20px;
        align-items: center;
        margin-right: 24px;
        color: #333;
        box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.05);
        position: relative;
        margin-top: 65px;
    }

    .flex-item .top-title {
        position: absolute;
        left: 0;
        top: -64px;
        width: 100%;
        height: 128px;
        text-align: center;
        display: block;
        margin: 0 auto;
    }

    .flex-item table {
        width: 100%;
        text-align: center;
        margin-top: 50px;
        color: #747474;

    }

    .flex-item table tr th, td {
        /*  width: 8%;*/
        line-height: 42px;
        overflow: hidden; /*超出部分隐藏*/
        border-bottom: 1px dashed #eee;
    }

    .flex-item table tr th:last-child, td:last-child {
        width: 10%;
    }

    .flex-item table tr:last-child{
        border-bottom: 1px solid #A553CB ;
    }

    .member_bg{
        background: -webkit-linear-gradient(left,#A553CB,#AA50CD,#B84AD3,#BF46D5 );
    }

    table tr{
       text-align: left;
    }
    table tr:first-child{
        height: 50px; border-bottom: 1px solid #A553CB ;
    }
    /*排行榜*/
    /*刷新图标样式*/
    .img{
        -webkit-animation:rotateImg 1s linear infinite;
        width: 20px ;
        height: 20px;
        vertical-align: middle;
    }

    @keyframes rotateImg {
        0% {transform : rotate(0deg);}
        100% {transform : rotate(360deg);}
    }

    @-webkit-keyframes rotateImg {
        0%{-webkit-transform : rotate(0deg);}
        100%{-webkit-transform : rotate(360deg);}
    }
    .fresh{
        margin-right: 18px;
        margin-top: -31px;
        float: right;

    }
    /*top_title 小区样式*/
    .title1{
        text-align:left;
        margin-left: 16px;
        color: white;
    }
    .title2{
        max-width: 150px;
        overflow:hidden;
        white-space:nowrap;
        text-overflow:ellipsis;
        display:inline-block
    }
    .data{
        float: right;
        border-radius:20px ;
        border: 2px solid white;
        line-height: 20px;
        margin-right: 18px;
        font-size: 12px;
        color: white;
        margin-top: 20px;
        text-align: center;
        letter-spacing:3px;
    }
    /*导出数据样式*/
    .exel{
        width:80px;
        height: 30px;
        background-color:#2589FF;
        color:white;
        text-align: center;
        line-height: 30px;
        border-radius: 5px;
        margin-top: 10px;
    }
    /*总记录样式*/
    .pages{
        width:100%;
        height:100px;
        margin-top:30px;
        right: 0;
    }
    .member_one{
        font-size: 14px;
        width: 30%;
        float: left;
        margin-top: 20px;
    }
    .total{
        font-size: 26px;
        font-weight: 600;
        clear: both;
    }
    .back{
        width:50px;
        height: 25px;
    }
    .sale_goods_num{
        width:90px;
        height: 25px;
        float: right;
    }
    /*排行榜*/
    /*刷新图标样式*/
    .img{
        -webkit-animation:rotateImg 1s linear infinite;
        width: 20px ;
        height: 20px;
        vertical-align: middle;
    }

    @keyframes rotateImg {
        0% {transform : rotate(0deg);}
        100% {transform : rotate(360deg);}
    }

    @-webkit-keyframes rotateImg {
        0%{-webkit-transform : rotate(0deg);}
        100%{-webkit-transform : rotate(360deg);}
    }
    .fresh{
        margin-right: 18px;
        margin-top: -31px;
        float: right;

    }
    /*top_title 小区样式*/
    .title1{
        text-align:left;
        margin-left: 16px;
        color: white;
    }
    .title2{
        max-width: 150px;
        overflow:hidden;
        white-space:nowrap;
        text-overflow:ellipsis;
        display:inline-block
    }
    .data{
        float: right;
        border-radius:20px ;
        border: 2px solid white;
        line-height: 20px;
        margin-right: 18px;
        font-size: 12px;
        color: white;
        margin-top: 20px;
        text-align: center;
        letter-spacing:3px;
    }
    /*导出数据样式*/
    .exel{
        width:80px;
        height: 30px;
        background-color:#2589FF;
        color:white;
        text-align: center;
        line-height: 30px;
        border-radius: 5px;
        margin-top: 10px;
    }
    /*总记录样式*/
    .pages{
        width:100%;
        height:100px;
        margin-top:30px;
        right: 0;
    }
    .member_one{
        font-size: 14px;
        width: 30%;
        float: left;
        margin-top: 20px;
    }
    .total{
        font-size: 26px;
        font-weight: 600;
        clear: both;
    }
    .back{
        width:50px;
        height: 25px;
    }
    .sale_goods_num{
        width:90px;
        height: 25px;
        float: right;
    }


</style>
<div class="tpl-content-wrapper" style="margin-left: 130px;">
    <div class="row-content am-cf" style="padding: 0;">
        <!--顶部-->
        <!--排行榜-->
        <?php  if($this->supplier_role==0 ) { ?>
            <div class="flex-item member">
            <div class="top-title member_bg"  >
                <div class="title" >
                    <div class="title1 member_one"  >会员消费第一名</div>
                    <div  class="data back"  ><a href="<?php  echo $this->createWebUrl('overview',array('op'=>'index'))?>">返回</a></div>
                    <div class="title1 total"  ><?php echo  $excel_member[0]['total']>0?  $excel_member[0]['total']:0;?></div>

                    <div   class="title1" style="font-size: 14px;margin-top: 5px">
                        <span  class="title2"  ><?php echo  $excel_member[0]['title']?  $excel_member[0]['title']:0;?></span>
                        <span class="title2" >  小区&nbsp<?php echo  $excel_member[0]['shop_name']? $excel_member[0]['shop_name']:0;?></span>
                    </div>
                    <div class="fresh" >
                        <a href="<?php  echo $this->createWebUrl('overview',array('op'=>'member','fresh'=>1))?>" >
                            <img style="width: 20px;height: 20px" src="<?php  echo MODULE_URL?>public/bg/fresh.png">
                            <img  class="img" src="<?php  echo MODULE_URL?>public/bg/fresh.png" style="display:none">
                        </a>
                    </div>
                </div>

            </div>

            <table>
                <tr  >
                                <th  style="width: 5%">消费榜单</th>
                                <th>会员名称</th>
                                <th>会员电话</th>
                                <th>会员身份</th>
                                <th style="width: 25%">所属小区 </th>
                                <th>团长名称</th>
                                <th>团长电话</th>
                                <th  style="width: 15%" >第一次消费时间</th>
                                <th  >累计消费额</th>
                </tr>

                <?php  if(!empty($get_all_member)) { ?>
                <?php  if(is_array($get_all_member)) { foreach($get_all_member as $k => $v) { ?>
                <tr  >
                                    <td><?php  echo intval($k)+1;?></td>
                                    <td><?php  echo $v["title"];?></td>
                                    <td><?php  echo $v["m_phone"];?></td>
                                    <td><?php echo $v["m_is_head"]==2?团长:会员;?></td>
                                    <td><?php  echo $v["address"];?><?php  echo $v["shop_name"]; ?></td>
                                    <td><?php  echo $v["head_name"]; ?></td>
                                    <td><?php  echo $v["phone"];?></td>
                                    <td><?php  echo date("Y-m-d h:i:s", $v["first_pay"]);?> </td>
                                    <td>￥<?php  echo $v["total"];?></td>
                   </tr>
                <?php  } } ?>

                <?php  } else { ?>
                            <tr>
                                <td>暂无数据</td>
                            </tr>
                <?php  } ?>
            </table>
            <div style="float: right;margin-top: 10px">  <?php  echo $pager;?></div>
            <div class="exel " ><a href="javascript:void(0);"  style="right:250px"  >导出表格</a></div>
            <div  class="pages"><span style="float: right;">总记录:<?php  echo $pages?></span></div>
        </div>
        <?php  } ?>
    </div>
</div>

<script>

    $(".exel").click(function () {
        var id=3;
        window.location.href="<?php  echo $this->createWebUrl('overview',array('op'=>'member'))?>&id="+id;


    });
   //刷新
    $(".fresh").click(function () {
        $(this).find("img").css("display","none");
        $(this).find(".img").css("display","block");
    });

    document.onreadystatechange = function () {
        if(document.readyState=="complete"  ) {

            $(".fresh").find(".img").each(function () {
                $(this).css("display","none");
            })
        }
    }
</script>
<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>