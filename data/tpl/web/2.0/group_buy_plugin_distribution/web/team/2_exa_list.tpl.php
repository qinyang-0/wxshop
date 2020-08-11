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
                        <div class="widget-title am-cf">用户提现申请列表</div>
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
                                            <th style="width:90px;">申请时间</th>
                                            <th>提现金额</th>
                                            <th>手续费</th>
                                            <th>打款类型</th>
                                            <th>打款信息</th>
                                            <th style="width:80px;">审核状态</th>
                                            <th style="width:160px;">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php  if(!empty($list)) { ?>
                                        <?php  if(is_array($list)) { foreach($list as $k => $v) { ?>
                                        <tr>
                                            <td><?php  echo $v['m_nickname'];?></td>
                                            <td><?php  echo date("Y-m-d H:i:s",$v['ctime']);?></td>
                                            <td><?php  echo $v['money'];?>元</td>
                                            <td><?php  echo $v['charge_money'];?>元</td>
                                            <td>
                                            	<?php  if($v['cash_type'] == 1) { ?>
                                            		<span class="btn btn-success btn-xs">微信打款</span>
                                            	<?php  } else if($v['cash_type'] == 2) { ?>
                                            		<span class="btn btn-warning btn-xs">支付宝</span>
                                            	<?php  } else if($v['cash_type'] == 3) { ?>
                                            		<span class="btn btn-danger btn-xs">网银</span>
                                            	<?php  } ?>
                                            </td>
                                            <td>
                                            	<?php  if($v['cash_type'] != 1) { ?>
                                            		<?php  
                                            			$types = unserialize($v['case_value']);
                                            			foreach($types as $kk=>$vv){
                                            				echo $vv['name'].":"."<span style='color:red;'>".$vv['value']."</span>".'<br/>';
                                            			}
                                            		?>
                                            	<?php  } ?>
                                            </td>
                                            <td><?php echo $v['check_state']==1?'<span class="btn btn-success btn-xs">审核通过</span>':($v['check_state']==0?'<span class="btn btn-warning btn-xs">未审核</span>':'<span class="btn btn-danger btn-xs">审核未通过</span>')?></td>
                                            <td>
                                                <?php  if($v['check_state'] ==0) { ?>
                                                	<?php  if($v['cash_type'] != 1) { ?>
                                                		<a class="btn btn-success btn-xs" data-id="<?php  echo $v['id'];?>" onclick="aggres(<?php  echo $v['id'];?>)">提现</a>
                                                	<?php  } else { ?>
                                                		<a class="btn btn-success btn-xs" onclick="aggre('<?php  echo $v['id'];?>','<?php  echo $v['check_state'];?>')">同意</a>
                                                	<?php  } ?>
	                                                <a class="btn btn-success btn-xs" onclick="refuse('<?php  echo $v['id'];?>','<?php  echo $v['check_state'];?>')">拒绝</a>
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
    	
        function aggre(id){
        	layer.confirm('确认提现吗?', {icon: 1, title:'提示'}, function(index){
				$.post(
	                "<?php  echo $this->createWebUrl('Cashcheck')?>",
	                {cid:id,state:1},
	                function(res){
	                	layer.closeAll();
	                    console.log(res);
	                    layer.msg(res.data.msg);
	                    if(res.data.code==0){
	                        setTimeout(function(){
	                            location.reload();
	                        },'1000')
	                        return false;
	                    }
	                },'JSON'
	            );
			});
        }
        function aggres(id){
        	layer.confirm('确认提现吗?', {icon: 1, title:'提示'}, function(index){
				$.post(
	                "<?php  echo $this->createWebUrl('Cashchecks')?>",
	                {cid:id,state:1},
	                function(res){
	                	layer.closeAll();
	                    console.log(res);
	                    layer.msg(res.msg);
	                    if(res.code==0){
	                        setTimeout(function(){
	                            location.reload();
	                        },'1000')
	                        return false;
	                    }
	                },'JSON'
	            );
			});
        }
        function refuse(id){
        	layer.confirm('确认拒绝吗?', {icon: 2, title:'提示'}, function(index){
	            $.post(
	                "<?php  echo $this->createWebUrl('Cashcheck')?>",
	                {cid:id,state:-1},
	                function(res){
	                    layer.msg(res.data.msg);
	                    if(res.data.code==0){
	                        setTimeout(function(){
	                            location.reload();
	                        },'1000')
	                        return false;
	                    }
	                },'JSON'
	            );
            })
        }
    </script>
