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

    .todayboxs  {
        color: #747474;
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

    .mypanel {
        position: relative;
        background-color: #fff;
        padding: 0 20px;
        box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.05);
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

    .rank .flex-item {
        background-color: #fff;
        width: 100%;
        padding: 20px;
/*        display: flex;*/
        align-items: center;
        margin-right: 24px;
        color: #333;
        box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.05);
        position: relative;
        margin-top: 65px;
    }

    .rank .flex-item .top-title {
        position: absolute;
        left: 0;
        top: -65px;
        width: 100%;
        height: 128px;
        text-align: center;
        display: block;
        margin: 0 auto;
        background: #fff;

    }


    .rank .flex-item .top-title  div:first-child {
       /* margin-top: 28px;*/
    }

    .rank .flex-item .top-title  div:last-child {
   /*     margin-top: 6px;*/
    }

    .rank .flex-item table {
        width: 100%;
        text-align: center;
        margin-top: 50px;
        color: #747474;

    }

    .tr{
        color: #000;
        justify-content: space-between;

    }
    .tr th{
        text-align: center;
    }

    .rank .flex-item table tr th, td {
        max-width: 100px;
        line-height: 42px;
        overflow: hidden; /*超出部分隐藏*/
        white-space: nowrap; /*不换行*/
        text-overflow: ellipsis; /*超出部分文字以...显示*/
        border-bottom: 1px dashed #eee;

    }

    .rank .flex-item table tr th:last-child, td:last-child {
        width: 10%;
    }

    .rank .flex-item table tr:first-child th, td {
        /*border-top: 0;*/
    }

    table tr th:first-child, td {
        width: 10%;
    }

    #head_bg{
        background: -webkit-linear-gradient(left,#39A5D9,#43ADD0,#4AB3CA,#53BAC3 );
    }
    .details{
        width:70px;
        height: 25px;
    }
    .num_one{
        font-size: 14px;
        width: 30%;
        float: left;
        margin-top: 20px;
    }

    .fresh img{
        width: 20px;
        height: 20px;
    }
    #shop_bg{
        background: -webkit-linear-gradient(left,#FC498C,#FD5888,#FE6983,#FF767F );
    }
    #sale_bg{
        background: -webkit-linear-gradient(left,#FC498C,#FD5888,#FE6983,#FF767F );
    }
    #member_bg{
        background: -webkit-linear-gradient(left,#A553CB,#AA50CD,#B84AD3,#BF46D5 );
    }
    .sale_price{
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
        <!--<div class="row">-->
        <!--顶部-->
        <div class="flex-items todayboxs">
            <?php  if($this->supplier_role==0 ) { ?>
            <a class="flex-item" href="<?php  echo $this->createWebUrl('member')?>">
                <img class="icon" src="../addons/group_buy/public/bg/Block-1.png">
                <div class="text">
                    <div class="num"><?php  echo $today_new_member;?></div>
                    <div class="title">今日新增会员</div>
                </div>
            </a>
            <?php  } ?>
            <!--<a class="flex-item" href="<?php  echo $this->createWebUrl('order',array('time[start]'=>date('Y-m-d',time()),'time[end]'=>date('Y-m-d',time())))?>">-->
            <!--<img class="icon" src="../addons/group_buy/public/bg/Block-2.png">-->
            <!--<div class="text">-->
            <!--<div class="num"><?php  echo $today_new_head;?></div>-->
            <!--<div class="title">今日审核通过团长数</div>-->
            <!--</div>-->
            <!--</a>-->

            <a class="flex-item"
               href="<?php  echo $this->createWebUrl('order',array('time[start]'=>date('Y-m-d',time()),'time[end]'=>date('Y-m-d',time())))?>">
                <img class="icon" src="../addons/group_buy/public/bg/Block-3.png">
                <div class="text">
                    <div class="num"><?php echo empty($today_order_num)?'0':$today_order_num;?></div>
                    <div class="title">今日订单数</div>
                </div>
            </a>
            <?php  if($this->supplier_role==0 ) { ?>
            <!--<a class="flex-item" href="<?php  echo $this->createWebUrl('finance',array('op'=>'stream_commission'))?>">-->
                <!--<img class="icon" src="../addons/group_buy/public/bg/Block-4.png">-->
                <!--<div class="text">-->
                    <!--<div class="num"><span>￥</span><?php echo empty($today_commission['total'])?'0.00':$today_commission['total'];?>-->
                    <!--</div>-->
                    <!--<div class="title">今日审核佣金</div>-->
                <!--</div>-->
            <!--</a>-->


				<?php  } ?>
				<a class="flex-item" href="<?php  echo $this->createWebUrl('order',array('time[start]'=>date('Y-m-d',time()),'time[end]'=>date('Y-m-d',time())))?>">
					<img class="icon" src="../addons/group_buy/public/bg/Block-6.png">
					<div class="text">
						<div class="num"><span>￥</span><?php echo empty($today_pay_money['total'])?'0.00':$today_pay_money['total'];?></div>
						<div class="title">今日销售额</div>
					</div>
				</a>
				<a class="flex-item" href="<?php  echo $this->createWebUrl('plsugins',array('op'=>'markrting','in'=>'markrting_recharge'))?>">
					<img class="icon" src="../addons/group_buy/public/bg/Block-6.png">
					<div class="text">
						<div class="num"><span>￥</span><?php echo empty($today_recharge_money['total'])?'0.00':$today_recharge_money['total'];?></div>
						<div class="title">今日充值</div>
					</div>
				</a>
				<?php  if($this->supplier_role==0 ) { ?>
					<a class="flex-item" href="<?php  echo $this->createWebUrl('finance',array('op'=>'back_money'))?>">
						<img class="icon" src="../addons/group_buy/public/bg/Block-7.png">
						<div class="text">
							<div class="num"><span>￥</span><?php echo empty($today_back_money['total'])?'0.00':$today_back_money['total'];?></div>
							<div class="title">今日退款额</div>
						</div>
					</a>
	                <a class="flex-item" href="<?php  echo $this->createWebUrl('finance',array('op'=>'get_cash'))?>">
	                    <img class="icon" src="../addons/group_buy/public/bg/Block-5.png">
	                    <div class="text">
	                        <div class="num"><span>￥</span><?php echo empty($today_get_cash['total'])?'0.00':$today_get_cash['total'];?></div>
	                        <div class="title">今日审核提现</div>
	                    </div>
	                </a>
				<?php  } ?>
				
			</div>
			<!--中部-->
			<div class="row-panel">
				<div class="row-panel-7">
					<div class="mypanel tasks-panel" style="min-height:240px; ">
						<div class="mypanel-heading">待处理事务</div>
						<div class="mypanel-body">
							<div class="flex-items tasks">
								<!--<div class="flex-item">-->
									<!--<div>商品库存报警</div>-->
									<!--<a class="num hasnum" href="/Admin/product/management?isSafeStock=true">4</a>-->
								<!--</div>-->
								<div class="flex-item">
									<div>仓库中商品</div>
									<a class="num <?php  if(!empty($all_goods)) { ?>hasnum<?php  } ?>" href="<?php  echo $this->createWebUrl('goods')?>"><?php  echo $all_goods;?></a>
								</div>
                                <?php  if($this->supplier_role==0 ) { ?>
								<div class="flex-item">
									<div>待付款订单</div>
									<a class="num <?php  if(!empty($no_pay_order)) { ?>hasnum<?php  } ?> no-pay-order" href="<?php  echo $this->createWebUrl('order',array('status'=>'10'))?>"><?php  echo $no_pay_order;?></a>
								</div>
								<div class="flex-item">
									<div>待发货订单</div>
									<a class="num <?php  if(!empty($no_send_order)) { ?>hasnum<?php  } ?>" href="<?php  echo $this->createWebUrl('order',array('status'=>'20'))?>"><?php  echo $no_send_order;?></a>
								</div>
                                <?php  } ?>
							</div>
							<?php  if($this->supplier_role==0 ) { ?>
							<div class="flex-items tasks">
								<div class="flex-item">
									<div>待处理退款</div>
									<a class="num <?php  if(!empty($no_deal_back)) { ?>hasnum<?php  } ?>" href="<?php  echo $this->createWebUrl('finance',array('op'=>'back_money'))?>"><?php  echo $no_deal_back;?></a>
								</div>
								<div class="flex-item">
									<div>提现申请</div>
									<a class="num <?php  if(!empty($get_cash_apply)) { ?>hasnum<?php  } ?>" href="<?php  echo $this->createWebUrl('finance')?>"><?php  echo $get_cash_apply;?></a>
								</div>
								<div class="flex-item">
									<div>供应商申请</div>
									<a class="num <?php  if(!empty($supplier_apply)) { ?>hasnum<?php  } ?>" href="<?php  echo $this->createWebUrl('supplier')?>"><?php  echo $supplier_apply;?></a>
								</div>
								<!--<div class="flex-item">-->
									<!--<div>待回复评价</div>-->
									<!--<a class="num hasnum" href="/Admin/ProductComment/management?isReply=1&amp;isHome=1">37</a>-->
								<!--</div>-->
							</div>
							<div class="flex-items tasks">

                            <!--<div class="flex-item">-->
                            <!--<div>待处理退货</div>-->
                            <!--<a class="num " href="/Admin/OrderRefund/management?type=2&amp;status=1">0</a>-->
                            <!--</div>-->
                            <div class="flex-item">
                                <div>团长申请</div>
                                <a class="num <?php  if(!empty($head_apply)) { ?>hasnum<?php  } ?>"
                                   href="<?php  echo $this->createWebUrl('head')?>"><?php  echo $head_apply;?></a>
                            </div>
                            <div class="flex-item">
                                <div>
                                    <?php  if(!empty($distribution) && !empty($share_apply) ) { ?>
                                    分销申请
                                    <?php  } ?>

                                </div>
                                <a class="num <?php  if(!empty($share_apply)) { ?>hasnum<?php  } ?>" <?php  if(!empty($fraction)) { ?> href="./index.php?c=site&a=entry&do=exalist&m=group_buy_plugin_distribution&pid=2" <?php  } ?>>
                                <?php  if(!empty($distribution) && !empty($share_apply)) { ?>
                                <?php  echo $share_apply;?>
                                <?php  } ?>
                                </a>
                            </div>
                            <div class="flex-item">
                                <div></div>
                                <a class="num " href=""></a>
                            </div>
                        </div>
                        <?php  } ?>
                    </div>
                </div>
            </div>

            <div class="row-panel-5">
                <div class="mypanel">
                    <div class="mypanel-heading">交易统计</div>
                    <div class="mypanel-body">
                        <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
                        <div id="main" style="height:192px"></div>
                        <!-- ECharts单文件引入 -->
                        <script src="https://echarts.baidu.com/build/dist/echarts-all.js"></script>
                        <script type="text/javascript">
                            // 基于准备好的dom，初始化echarts图表
                            var myChart = echarts.init(document.getElementById('main'));
                            var days = <?php  echo $days;?>;
                            var data = <?php  echo $data;?>;
                            var option = {
                                tooltip: {
                                    trigger: 'axis'
                                },
                                toolbox: {
                                    show: true,
                                    feature: {
                                        mark: {show: false},
                                        dataView: {show: false, readOnly: false},
                                        magicType: {show: true, type: ['line', 'bar']},
                                        restore: {show: true},
                                        saveAsImage: {show: true}
                                    }
                                },
                                calculable: true,
                                xAxis: [
                                    {
                                        type: 'category',
                                        boundaryGap: false,
                                        //data : ['周一','周二','周三','周四','周五','周六','周日']
                                        data: days,
                                        // axisLine:,
                                    }
                                ],
                                yAxis: [
                                    {
                                        type: 'value',
                                        axisLabel: {
                                            formatter: '￥{value}'
                                        }
                                    }
                                ],
                                //  图表距边框的距离,可选值：'百分比'¦ {number}（单位px）
                                grid: {
                                    x2: '15%',
                                    y: "40%",
                                    y2: "12%"
                                },
                                series: [
                                    {
                                        name: '金额',
                                        type: 'line',
                                        data: data,
                                        symbolSize: 4,
                                        showSymbol: true,
                                        symbol: 'circle',     //设定为实心点
                                        markPoint: {
                                            symbolSize: 500,
                                            data: [
                                                {type: 'max', name: '最大值'},
                                                {type: 'min', name: '最小值'}
                                            ]
                                        },
                                        markLine: {
                                            data: [
                                                {type: 'average', name: '平均值'}
                                            ]
                                        }
                                    }
                                ]
                            };
                            // 为echarts对象加载数据
                            myChart.setOption(option);
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <!--底部-->
        <div class="row-panel">
            <div class="row-panel-7">
                <div class="mypanel total-panel">
                    <div class="mypanel-heading">商城信息统计</div>
                    <div class="mypanel-body">
                        <?php  if($this->supplier_role==0 ) { ?>
                        <div class="flex-items total-mes">

                            <div class="flex-item">
                                <div class="num"><?php  echo $all_member;?></div>
                                <div>会员总数</div>
                            </div>
                            <div class="flex-item">
                                <div class="num"><?php  echo $all_head;?></div>
                                <div>团长总数</div>
                            </div>
                            <div class="flex-item">
                                <div class="num"><?php echo empty($all_sale['total'])?0:$all_sale['total'];?></div>
                                <div>总销售额（元）</div>
                            </div>

                        </div>
                        <div class="flex-items total-mes">
                            <div class="flex-item">
                                <div class="num"><?php  echo $last_seven_order;?></div>
                                <div>近七天订单数</div>
                            </div>
                            <div class="flex-item">
                                <div class="num"><?php echo empty($last_seven_sale['total'])?0:$last_seven_sale['total'];?>
                                </div>
                                <div>近7天销售额（元）</div>
                            </div>
                            <div class="flex-item">
                                <div class="num"><?php echo empty($last_seven_back['total'])?0:$last_seven_back['total'];?>
                                </div>
                                <div>近7天退款金额（元）</div>
                            </div>
                        </div>
                        <?php  } else { ?>

                        <div class="flex-items total-mes">
                            <div class="flex-item">
                                <div class="num"><?php  echo $all_goods;?></div>
                                <div>商品总数</div>
                            </div>
                            <div class="flex-item">
                                <div class="num"><?php  echo $last_seven_order;?></div>
                                <div>近七天订单数</div>
                            </div>
                            <div class="flex-item">
                                <div class="num"><?php echo empty($last_seven_sale['total'])?0:$last_seven_sale['total'];?>
                                </div>
                                <div>近7天销售额（元）</div>
                            </div>
                        </div>

                        <?php  } ?>
                    </div>
                </div>
            </div>
            <div class="row-panel-5">
                <div class="mypanel quick-panel">
                    <div class="mypanel-heading">快捷入口</div>
                    <div class="mypanel-body">
                        <div class="flex-items quick-nav">
                            <a href="<?php  echo $this->createWebUrl('goods',array('op'=>'add'))?>" class="flex-item">
                                <i class="fa fa-shopping-bag"></i>
                                <div>新增商品</div>
                            </a>
                            <?php  if($this->supplier_role==0 ) { ?>
                            <a href="<?php  echo $this->createWebUrl('order')?>" class="flex-item">
                                <i class="fa fa-file-text-o"></i>
                                <div>订单列表</div>
                            </a>

                            <a href="<?php  echo $this->createWebUrl('member')?>" class="flex-item">
                                <i class="fa fa-users"></i>
                                <div>会员管理</div>
                            </a>
                            <a href="<?php  echo $this->createWebUrl('head',array('op'=>'index'))?>" class="flex-item">
                                <i class="fa fa-user"></i>
                                <div>团长管理</div>
                            </a>
                            <a href="<?php  echo $this->createWebUrl('distribution')?>" class="flex-item">
                                <i class="fa fa-truck"></i>
                                <div>配送单管理</div>
                            </a>
                        </div>
                        <div class="flex-items quick-nav">
                            <a href="<?php  echo $this->createWebUrl('market')?>" class="flex-item">
                                <i class="fa fa-line-chart"></i>
                                <div>优惠券</div>
                            </a>
                            <!--<a href="/Admin/FullDiscount/Index" class="flex-item">-->
                            <!--<i class="iconfont icon-p6"></i>-->
                            <!--<div>满额减</div>-->
                            <!--</a>-->
                            <!--<a href="<?php  echo $this->createWebUrl('market')?>" class="flex-item">-->
                            <!--<i class="iconfont icon&#45;&#45;coin-yen"></i>-->
                            <!--<div>财务管理</div>-->
                            <!--</a>-->
                            <!--<a href="/Admin/Statistics/TradeStatistic" class="flex-item">-->
                            <!--<i class="iconfont icon&#45;&#45;stats-bars1"></i>-->
                            <!--<div>统计报表</div>-->
                            <!--</a>-->
                            <a href="<?php  echo $this->createWebUrl('config')?>" class="flex-item">
                                <i class="fa fa-cogs"></i>
                                <div>基本设置</div>
                            </a>
                            <?php  if(empty($fraction)) { ?>
                            <?php  if(empty($distribution)) { ?>
                            <a class="flex-item">

                            </a>
                            <?php  } else { ?>
                            <a href="./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_distribution&version_id=0"
                               class="flex-item">
                                <i class="fa fa-cogs"></i>
                                <div>分销商城</div>
                            </a>
                            <?php  } ?>
                            <a class="flex-item">

                            </a>
                            <?php  } else { ?>
                            <a href="./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_fraction&version_id=0"
                               class="flex-item">
                                <i class="fa fa-database"></i>
                                <div>积分商城</div>
                            </a>
                            <?php  if(empty($distribution)) { ?>
                            <a class="flex-item">

                            </a>
                            <?php  } else { ?>
                            <a href="./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_distribution&version_id=0"
                               class="flex-item">
                                <i class="fa fa-share-alt"></i>
                                <div>分销商城</div>
                            </a>
                            <?php  } ?>
                            <?php  } ?>

                            <a class="flex-item">

                            </a>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--排行榜-->
        <?php  if($this->supplier_role==0 ) { ?>
             <div class="flex-items rank">
                <div class="flex-item head_rank">
                    <div class="top-title " id="head_bg">
                        <div   class="title">
                            <div  class="title1 num_one"  >团长销售第一名</div>
                            <div  class="data details"  ><a href="<?php  echo $this->createWebUrl('overview',array('op'=>'head'))?>">数据详情</a></div>
                            <div  class="title1 total"  ><?php echo $head_rank[0]['total']>0?$head_rank[0]['total']:0;?></div>
                            <div  class="title1" style="font-size: 14px;margin-top: 5px">
                                <span class="title2" style="max-width: 100px;"><?php echo $head_rank[0]['total']>0?$head_rank[0]['title']:0;?></span>
                               <span class="title2" style="max-width: 80px;"> 小区&nbsp<?php  echo  $head_rank[0]['shop_name']; ?></span>
                            </div>

                            <div class="fresh" >
                                <a href="<?php  echo $this->createWebUrl('overview',array('op'=>'index','fresh'=>1))?>" >
                                    <img   src="<?php  echo MODULE_URL?>public/bg/fresh.png">
                                    <img  class="img" src="<?php  echo MODULE_URL?>public/bg/fresh.png" style="display:none">
                                </a>
                            </div>
                        </div>

                    </div>
                    <table>
                        <tr class="tr">
                            <th>销售榜单</th>
                            <th style="width: 20%">团长名称</th>
                            <th>销售额</th>
                        </tr>
                        <?php  if(!empty($head_rank)) { ?>
                            <?php  if(is_array($head_rank)) { foreach($head_rank as $k => $v) { ?>
                                <tr class="tr">
                                <td><?php  echo intval($k)+1;?></td>
                                <td><a href="<?php  echo $this->createWebUrl('member',array('op'=>'add','id'=>$v['m_id']))?>"><?php  echo $v['title'];?></a></td>
                                <td>￥<?php  echo $v['total'];?></td>
                            </tr>
                            <?php  } } ?>
                        <?php  } else { ?>
                            <tr class="tr">
                                <td>暂无数据</td>
                            </tr>
                        <?php  } ?>
                    </table>
                </div>

                <div class="flex-item shop">
                    <div class="top-title  " id="shop_bg"  >
                        <div class="title" >
                            <div  class="title1 num_one"   >商品销售额第一名</div>
                            <div  class="data details"  ><a href="<?php  echo $this->createWebUrl('overview',array('op'=>'sale_price'))?>">数据详情</a></div>
                            <div  class="data sale_price" ><a href="javasrcpit:;">查询销售量</a></div>
                            <div  class="title1 total" ><?php echo $goods_sale_price[0]['price']>0?$goods_sale_price[0]['price']:0;?></div>
                            <div   class="title1" style="font-size: 14px;margin-top: 5px">
                                <span  class="title2" style="max-width: 150px;"><?php  echo $goods_sale_price[0]['g_name']?></span>
                                <span class="title2" style="max-width: 80px; "> 供应商  <?php echo $goods_sale_price[0]['gsp_shop_name']?$goods_sale_price[0]['gsp_shop_name']:无?></span>
                            </div>

                            <div class="fresh"  >
                                <a href="<?php  echo $this->createWebUrl('overview',array('op'=>'index','fresh'=>1))?>" >
                                    <img   src="<?php  echo MODULE_URL?>public/bg/fresh.png">
                                    <img  class="img" src="<?php  echo MODULE_URL?>public/bg/fresh.png" style="display:none">
                                </a>
                            </div>
                        </div>
                    </div>

                    <table>
                        <tr class="tr">
                            <th>销售榜单</th>
                            <th style="width: 20%">商品名称</th>
                            <th>销售额</th>
                        </tr>
                        <?php  if(!empty($goods_sale_price)) { ?>
                            <?php  if(is_array($goods_sale_price)) { foreach($goods_sale_price as $k => $v) { ?>
                                <tr class="tr">
                                    <td><?php  echo intval($k)+1;?></td>
                                    <td><a href="<?php  echo $this->createWebUrl('goods',array('op'=>'add','id'=>$v['g_id']))?>"><?php  echo $v['g_name'];?></a></td>
                                    <td>￥<?php  echo $v['price'];?></td>
                                </tr>
                            <?php  } } ?>
                        <?php  } else { ?>
                            <tr class="tr">
                                <td>暂无数据</td>
                            </tr>
                        <?php  } ?>
                    </table>
                </div>
                <div class="flex-item sale_num" style="display: none">
                    <div class="top-title" id="sale_bg"  >
                         <div class="title" >
                                <div  class="title1 num_one"  >商品销售第一名</div>
                                <div class="data details" ><a href="<?php  echo $this->createWebUrl('overview',array('op'=>'sale_num'))?>">数据详情</a></div>
                                <div  class="data sale_goods_num"  ><a href="javascript:;">查询销售额</a></div>
                                <div  class="title1 total" ><?php echo $goods_sale_num[0]['sale_num']>0? $goods_sale_num[0]['sale_num']:0;?></div>

                              <div   class="title1" style="font-size: 14px;margin-top: 5px">
                                <span  class="title2" style="max-width: 150px;"><?php  echo $goods_sale_num[0]['g_name']?></span>
                                <span class="title2" style="max-width: 150px; "> 供应商 &nbsp <?php echo $goods_sale_num[0]['gsp_shop_name']?$goods_sale_num[0]['gsp_shop_name']:无?></span>
                            </div>
                             <div class="fresh" >
                                    <a href="<?php  echo $this->createWebUrl('overview',array('op'=>'index','fresh'=>1))?>" >
                                        <img src="<?php  echo MODULE_URL?>public/bg/fresh.png">
                                        <img  class="img" src="<?php  echo MODULE_URL?>public/bg/fresh.png" style="display:none">
                                    </a>
                             </div>
                         </div>
                    </div>
                     <table>
                         <tr class="tr">
                             <th>销售榜单</th>
                             <th style="width: 20%">商品名称</th>
                             <th>销售量</th>
                         </tr>
                         <?php  if(!empty($goods_sale_num)) { ?>
                             <?php  if(is_array($goods_sale_num)) { foreach($goods_sale_num as $k => $v) { ?>
                                 <tr class="tr">
                                     <td><?php  echo intval($k)+1;?></td>
                                     <td><a href="<?php  echo $this->createWebUrl('goods',array('op'=>'add','id'=>$v['g_id']))?>"><?php  echo $v['g_name'];?></a></td>
                                     <td><?php  echo $v['sale_num'];?></td>
                                 </tr>
                             <?php  } } ?>
                         <?php  } else { ?>
                             <tr class="tr">
                                 <td>暂无数据</td>
                             </tr>
                         <?php  } ?>
                     </table>
                </div>
                <div class="flex-item member">
                    <div class="top-title "   id="member_bg" >
                        <div class="title" >
                            <div class="title1 num_one"  >会员消费第一名</div>
                            <div class="data details"  ><a  href="<?php  echo $this->createWebUrl('overview',array('op'=>'member'))?>">数据详情</a></div>
                            <div class="title1 total" ><?php echo $member_rank[0]['total']>0? $member_rank[0]['total']:0;?></div>

                            <div class="title1" style="font-size: 14px;margin-top: 5px;"  >
                                <span class="title2" style="max-width: 100px;">  <?php echo $member_rank[0]['title']? $member_rank[0]['title']:0;?></span>
                                <span class="title2" style="max-width: 80px;">小区&nbsp<?php echo $member_rank[0]['shop_name']?$member_rank[0]['shop_name']:0;?></span>
                            </div>
                            <div class="fresh"  >
                                <a href="<?php  echo $this->createWebUrl('overview',array('op'=>'index','fresh'=>1))?>" >
                                    <img  src="<?php  echo MODULE_URL?>public/bg/fresh.png">
                                    <img  class="img" src="<?php  echo MODULE_URL?>public/bg/fresh.png" style="display:none">
                                </a>
                            </div>
                        </div>
                    </div>
                    <table>
                        <tr class="tr">
                            <th>销售榜单</th>
                            <th style="width: 20%">会员名称</th>
                            <th>消费金额</th>
                        </tr>
                        <?php  if(!empty($member_rank)) { ?>
                            <?php  if(is_array($member_rank)) { foreach($member_rank as $k => $v) { ?>
                                <tr class="tr">
                                    <td><?php  echo intval($k)+1;?></td>
                                    <td><a href="<?php  echo $this->createWebUrl('member',array('op'=>'add','id'=>$v['m_id']))?>"><?php  echo $v['title'];?></a></td>
                                    <td>￥<?php  echo $v['total'];?></td>
                                </tr>
                            <?php  } } ?>
                        <?php  } else { ?>
                            <tr class="tr">
                                <td>暂无数据</td>
                            </tr>
                        <?php  } ?>
                    </table>
                </div>
            </div>
        <?php  } ?>
        <!--</div>-->
    </div>
</div>

<script>
    //查询待付款订单
    $.post("<?php  echo $this->createWebUrl('overview',array('op'=>'check_order_status'))?>", {"tset": 1}, function (res) {
        if (res.status === 0) {
            $('.no-pay-order').html(res.data.count);
            if (res.data.count == 0) {
                $('.no-pay-order').removeClass('hasnum');
            }
        }
    }, "JSON");
    //查询商品量
    $(".sale_goods_num").find("a").click(function () {

        $(".shop").css("display","block");
        $(".sale_num").css("display","none");
    });
    //查询商品额
    $(".sale_price").find("a").click(function () {

        $(".shop").css("display","none");
        $(".sale_num").css("display","block");
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