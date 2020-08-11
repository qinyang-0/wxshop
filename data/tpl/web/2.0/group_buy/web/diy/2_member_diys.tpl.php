<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('template', TEMPLATE_INCLUDEPATH)) : (include template('template', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="<?php  echo MODULE_URL?>template/web/template/css/common.css">
<link rel="stylesheet" type="text/css" href="<?php  echo MODULE_URL?>template/web/template/css/tao.css">
<link rel="stylesheet" href="<?php  echo MODULE_URL?>template/web/template/css/jquery-ui.css">
<script src="<?php  echo MODULE_URL?>template/web/template/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php  echo MODULE_URL?>template/web/template/js/tao.js"></script>

<link rel="stylesheet" type="text/css" href="<?php  echo MODULE_URL?>template/web/template/css/style.css">
<script type="text/javascript" src="<?php  echo MODULE_URL?>template/web/template/js/angular.min.js"></script>
<script type="text/javascript" src="<?php  echo MODULE_URL?>template/web/template/js/angular-ueditor.js"></script>
<!--<script type="text/javascript" src="php echo MODULE_URL}template/web/template/js/ng-layer.js"></script>-->
<script type="text/javascript" src="<?php  echo MODULE_URL?>template/web/template/js/sortable.js"></script>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>

<script type="text/javascript" src="./resource/components/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="./resource/components/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="./resource/components/ueditor/ueditor.parse.min.js"></script>
<script type="text/javascript" src="./resource/components/ueditor/lang/zh-cn/zh-cn.js"></script>
<link href="<?php  echo MODULE_URL?>template/web/template/css/jquery-ui.css" rel="stylesheet">
<style type="text/css">
	a{text-decoration: none !important;}
	.nav_is{
		position: fixed;
	    right: 37px;
	    top: 174px;
	    width: 370px;
	    z-index: 100;
	}
	.nav_is span{
		margin: 5px 10px;
	    background: #000;
		color: #fff;
		min-width: 100px;
	}
	.module_box {
	    position: fixed;
	    bottom: 40px;
	    right: 850px;
	    z-index: 1000;
	}
	.btn_save{
		min-width: 100px;    
		background: #22c397;
    	border: 0;
	}
	.group{
		float: left;width: 50%;background: #fff;
	}
	.w100{
		width: 100%;
	}
	.flr{
		display: inline-block;vertical-align: middle;width:18%;text-align: right;
	}
	.w80{
		width:80%;display:inline-block;
	}
	.phone {
	  width: 100%;
	  height: 42px;
	  padding: 0 10px;
	  font-size: 0;
	}
	
	.phone .youhui {
	  font-size: 13px;
	  color: #666;
	  height: 42px;
	  line-height: 42px;
	  display: inline-block;
	  vertical-align: top;
	}
	
	.phone .input {
      width: 78%;
	    margin-top: 8px;
	    vertical-align: top;
	    float: right;
	    font-size: 0;
	}
	
	.phone .input input {
	      display: inline-block;
    width: 70%;
    /* height: 100%; */
    box-sizing: border-box;
    border: 1px solid #d2d2d2;
    padding-left: 7px;
    font-size: 12px;
    line-height: 24px;
    border-right: none;
    font-size: 12px;
	}
	
	.phone .input button {
	  width: 30%;
	    float: right;
	    height: 26px;
	    background: #0c9;
	    border-radius: 0;
	    font-size: 12px;
	    color: #fff;
	    text-align: center;
	    border: none;
	    line-height: 26px;
	}
	.pos{
		position: absolute;
		bottom: 0;
		z-index: 999;
	}
	.diy_style::-webkit-scrollbar{/*滚动条整体部分，其中的属性有width,height,background,border等（就和一个块级元素一样）（位置1）*/
			width:5px;
			height:10px;
	}
	.diy_style::-webkit-scrollbar-button{/*滚动条两端的按钮，可以用display:none让其不显示，也可以添加背景图片，颜色改变显示效果（位置2）*/
			/*background:#74D334;*/
			display: none;
	}
	.diy_style::-webkit-scrollbar-track{/*外层轨道，可以用display:none让其不显示，也可以添加背景图片，颜色改变显示效果（位置3）*/
			background:#fff;
	}
	.diy_style::-webkit-scrollbar-track-piece{/*内层轨道，滚动条中间部分（位置4）*/
			background:#fff;
	}
	.diy_style::-webkit-scrollbar-thumb{/*滚动条里面可以拖动的那部分（位置5）*/
		background:#747474;
		border-radius:4px;
	}
	.diy_style::-webkit-scrollbar-corner {/*边角（位置6）*/
		background:#82AFFF; 
	}
	.diy_style::-webkit-scrollbar-resizer  {/*定义右下角拖动块的样式（位置7）*/
		background:#FF0BEE;
	}
	.diy_style{
	    height: 596px;
		overflow: auto;
		scrollbar-arrow-color: #f4ae21; /**//*三角箭头的颜色*/ 
		scrollbar-face-color: #333; /**//*立体滚动条的颜色*/ 
		scrollbar-3dlight-color: #666; /**//*立体滚动条亮边的颜色*/ 
		scrollbar-highlight-color: #666; /**//*滚动条空白部分的颜色*/ 
		scrollbar-shadow-color: #999; /**//*立体滚动条阴影的颜色*/ 
		scrollbar-darkshadow-color: #666; /**//*立体滚动条强阴影的颜色*/ 
		scrollbar-track-color: #666; /**//*立体滚动条背景颜色*/ 
		scrollbar-base-color:#f8f8f8; /**//*滚动条的基本颜色*/ 
	}
.diy-actions {
    bottom: 0px;
    padding: 10px;
    /*border: 1px solid rgb(204, 204, 204);*/
    /*background-color: rgb(255, 255, 255);*/
    z-index: 111;
    /*box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);*/
}
.diy-actions-addModules a {
    display: block;
    float: left;
    margin: 0 0 5px 0;
    width: 82px;
    padding: 8px 5px;
    font-size: 12px;
}
.diy-actions-addModules a {
    text-decoration: none;
    text-align: center;
    background: #65c1fe;
    margin:0px 2px 10px 2px;
    color: #fff;
}
.saveBottomBar .buttonBox {
    height: 35px;
    margin: 10px auto;
}
.saveBottomBar .buttonBox .saveButon {
    width: 85px;
    background: none repeat scroll 0 0 rgba(12, 145, 237, 0.94);
    border: 1px solid #1c89d5;
    color: #fff;
}

.nav_inner, .diypage-right {
    height: 100%;
    background: #fff;
    position: relative;
    overflow: auto;
}
.page-structure, .subnav.model {
    width: 16%;
    background: #fff;
    font-size: 12px;
    color: #999;
    overflow: scroll;
}
.tool_class_name {
	border-left: 3px solid #22c397;
    height: 30px;
    line-height: 30px;
    background: #f7f7f7;
    color: #666666;
    border-bottom: 1px solid #efefef;
    padding-left: 10px;
    border-right: 1px solid #efefef;
}
.tool_box div {width:33.3333%;border-bottom:1px solid #efefef;border-right:1px solid #efefef;height:64px; display:block;
    box-sizing:border-box;
    -moz-box-sizing:border-box; /* Firefox */
    -webkit-box-sizing:border-box; /* Safari */
    text-align:center;float:left;}
.tool_box a span {
    display: block;
    height: 22px;
    line-height: 22px;
}
.tool_box a span, .tool_box a:hover span {
    color: #666 !important;
}
.tool_box a {
    padding-top: 34px;
}
.icon_pic {
    background: url(../addons/group_buy/style/img/diy.png);
    background-size: 44px 1110px;
    width: 44px;
    height: 30px;
    display: block;
    margin: 0 auto;
    margin-top: 10px;
}
.icons_1{background-position: 0 0;}
.icons_2{background-position: 0 -60px;}
.icons_3{background-position: 0 -60px;}
.icons_4{background-position: 0 -30px;}
.icons_5{background-position: 0 -120px;}
.icons_6{background-position: 0 -30px;}

.icons_7{background-position: 0 -600px;}
.icons_8{background-position: 0 -420px;}
.icons_9{background-position: 0 -450px;}
.icons_10{background-position: 0 -300px;}
.icons_11{background-position: 0 -330px;}
.icons_12{background-position: 0 -90px;}
.icons_13{background-position: 0 -120px;}
.icons_14{background-position: 0 -240px;}
.icons_15{background-position: 0 -420px;}
.icons_16{background-position: 0 -390px;}
.icons_17{background-position: 0 -180px;}
.icons_18{background-position: 0 -330px;}
.icons_19{background-position: 0 -120px;}
.icons_20{background-position: 0 -450px;}
.icons_21{background-position: 0 -630px;}
/*.icons_22{background-position: 0 -630px;}*/
.wxTabTwo {
    overflow: hidden;
}
.wxTabTwo ul li {
    float: left;
    position: relative;
    margin-right: 4px;
    padding-bottom: 5px;
}
.cur a {
    background-color: #5AC5FF;
    color: #fff;
}
.wxTabTwo ul li a {
    display: inline-block;
    padding: 0 10px;
    height: 25px;
    line-height: 25px;
    border-radius: 5em;
}
.fiexl{
	/*width: 13%;
    position: fixed;
    background: #ffff;*/
}
</style>

<div class="tpl-content-wrapper ">
	<div class="row-content am-cf">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
		<div class="my_article_box" ng-app="myyapp" ng-controller="ctr">
		  	<div class="" ng-cload>
		  		<!--左边列表-->
		  		<input type="hidden" name="ifrname_name" id="ifrname_name" value="" />
		  		<input type="hidden" name="ifrname_url" id="ifrname_url" value="" />
				<input type="hidden" name="ifrname_type" id="ifrname_type" value="" />
				<input type="hidden" name="ifrname_type" id="ifrname_img" value="" />
			    <div class="page-structure nav_inner subnav" style="float: left;height: 728px;">
			    	<div class="tool_box_li fiexl">
			    		<div class="wxTabTwo">
                            <ul>
                                <li data-class="MoType1" ng-repeat="item in modules_type">
									<a href="#list{{item.type}}">
										&nbsp;
									</a>
									<!--<a href="#list{{item.type}}">-->
										<!--&lt;!&ndash;{{item.name}}&ndash;&gt;-->
									<!--</a>-->
								</li>
                            </ul>
                        </div>
			    	</div>
			    	<div class="tool_box_li" id="list1">
			    		<!--<div class="tool_class_name">基础组件</div>-->
			    		<div class="tool_box">
			    			<div ng-repeat="item in modules" class="j-diy-addModule" ng-show="item.type == 1">
			    				<span class="icon_pic icons_{{$index+1}}"></span>
			    				<a href="javascript:;" ng-bind="item.title" name="{{item.name}}" add-module style="color: #666 !important;">
			    					{{item.name}}
			    				</a>
			    			</div>
			    		</div>
			    		<div class="clear"></div>
			    	</div>
			    	<div class="tool_box_li" id="list2">
			    		<!--<div class="tool_class_name">辅助组件</div>-->
			    		<div class="tool_box">
			    			<div ng-repeat="item in modules" class="j-diy-addModule" ng-show="item.type == 2">
			    				<span class="icon_pic icons_{{$index+1}}"></span>
			    				<a href="javascript:;" ng-bind="item.title" name="{{item.name}}" add-module style="color: #666 !important;">
			    					{{item.name}}
			    				</a>
			    			</div>
			    		</div>
			    		<div class="clear"></div>
			    	</div>
			    	<!--<div class="tool_box_li" id="list{{items.type}}" ng-repeat="items in modules_type" ng-style="{'margin-top':$index == 0 ? '33px': '0'}">
			    		<div class="tool_class_name">{{items.name}}</div>
			    		<div class="tool_box">
			    			<div ng-repeat="item in modules" class="j-diy-addModule" ng-show="item.type == items.type">
			    				<span class="icon_pic icons_{{$index+1}}"></span>
			    				<a href="javascript:;" ng-bind="item.title" name="{{item.name}}" add-module style="color: #666 !important;">
			    					{{item.name}}
			    				</a>
			    			</div>
			    		</div>
			    		<div class="clear"></div>
			    	</div>-->
			    	<div class="clear"></div>

					<br/>
					<?php $show_recommd = 0; $_SERVER['SERVER_NAME'] == 'test12.scmmwl.com' ? $show_recommd=1:'';?>
					<!--<div style="text-align: center;display: <?php echo $show_recommd==1?'block':'none';?>;">-->
					<!--<a href="<?php  echo $this->createWebUrl('diy',array('op'=>'use_temp','id'=>120,'type'=>2))?>">-->
						<!--<span>恢复到官方推荐模版</span>-->
						<!--<br/>-->
						<!--<img src="https://test12.scmmwl.com/attachment/images/6/2019/06/TyOycgWRmgdspg3VrVMSjOFpDGguDo.png" width="180">-->
					<!--</a>-->
					<!--</div>-->
		    	</div>
		  		<!--结束-->
		  		<!--主体-->
			  	<div class="item_cell_box item_display_block">
			  		<!--左边显示-->
			  		<div class="ww50">
						<div class="article_left">
							<div class="article_left_mobile">
								<!--小程序标题设置-->
								<div class="mobile_head">
									<!--<span class="title" style="color: #000;" focus-item viewid="00000000" ng-click="getFocus('00000000','basic')">{{basic.title}}</span> -->
								</div>
								<!--显示主体-->
								<div class="page-content diy_style" style="padding: 5px;position: relative;" >
									<div class="mobile_body" style="overflow: auto;">
										<div data-i="1" ng-repeat="item in items track by $index" ng-if="item.name != 'fix' && item.name != 'bars'"  ng-click="getFocus(item.id)"  class="view_item" viewid="{{item.id}}"  ng-class="{'article_view_selected' : focus.id == item.id}"  ng-if="">
											<div  view-delete ng-mouseover="move(item.id)" ng-mouseleave="moves(item.id)" ng-include="'./../addons/group_buy/template/web/template/temp/view-'+item.name+'.html'"></div>
										</div>
										<div data-i="3" ng-repeat="item in items track by $index" ng-if="item.name != 'fix' && item.name == 'bars'"  ng-click="getFocus(item.id)"  class="view_item" viewid="{{item.id}}"  ng-class="{'article_view_selected' : focus.id == item.id}" class="pos">
											<div  view-delete ng-mouseover="move(item.id)" ng-include="'./../addons/group_buy/template/web/template/temp/view-'+item.name+'.html'"></div>
										</div>
										<div data-i="2" ng-repeat="item in items track by $index" ng-if="item.name == 'fix'"  ng-click="getFocus(item.id)" class=" view_item_fix"   viewid="{{item.id}}"  ng-class="{'article_view_selected' : focus.id == item.id}" ng-style="{'background':item.params.mbg,'padding':item.params.padding+'px','top':item.params.top+'%','right':item.params.right+'%'}" >
											<div  view-delete ng-include="'./../addons/group_buy/template/web/template/temp/view-'+item.name+'.html'"></div>
										</div>
									</div>
								</div>							
								<div class="mobile_bottom"></div>
							</div>
						</div>
					</div>
					<!--右边修改页面-->
					<div style="float: left;">
						<div class="article_right item_cell_flex" style="float: right;">
						<div class="portable_editor diy_style" style="min-height: 728px;overflow: auto;">
							<div class="editor_inner" id="js_editFormContent">
								<div ng-include="'./../addons/group_buy/template/web/template/temp/edit-memberdiybasic.html'" editid="00000000" ng-show="focus.id == '00000000'"></div>
								<div ng-repeat="item in items track by $index" class="edit_item simple" editid="{{item.id}}"  ng-show="focus.id == item.id" >
									<div ng-include="'./../addons/group_buy/template/web/template/temp/edit-'+item.name+'.html'"></div>
								</div>
							</div>
							<span class="editor_arrow_wrp js_arrow">
							</span>
						</div>
					</div>
			  		</div>
			  	</div>	
			  	<!--保存-->
			  	<div class="diy-actions saveBottomBar" style="margin-top: 35px;" >
                    <!--<div class="diy-actions-addModules clearfix" style="border-bottom: 1px dotted rgb(204, 204, 204);display: block !important;" ng-show="params.showmodules" ng-mouseleave="params.showmodules = false">
                        <a ng-repeat="item in modules" class="btn btn_default btn_p20 " ng-bind="item.title" name="{{item.name}}" add-module></a>
                    </div>-->
                    <div class="buttonBox diy-actions-submit" style="width: 400px;text-align: center;">
						<span ng-click="saveData('save')" class="btn btn_primary btn_p20 btn_save">保存</span>
                    </div>
               </div>
			</div>

				<div class="mask ui-draggable" style="display: none;"></div>


				
		</div>

		<!--</div>-->
				</div>
			</div>
		</div>
	</div>
</div>

	<script type="text/javascript">
		var page = <?php  echo json_encode($page)?>;
		console.log(page)
		var tempid = <?php  echo intval( $_GPC['tid'] )?>;
		var article = <?php  echo json_encode($article)?>;
		var allsort = <?php  echo json_encode($allsort)?>;
        var action = <?php  echo json_encode($action)?>;
        var classify = <?php  echo json_encode($classify)?>;
		var adLinkUrl = "<?php  echo $this->createWebUrl('diy',array('op'=>'adLinkUrl','type'=>'page'))?>";
		var url_list = "<?php  echo $this->createWebUrl('test',array('op'=>'class'))?>";
		var op = "<?php  echo $_GPC['op'];?>";
        console.log(window.sysinfo);
	</script>
	<script type="text/javascript" src="<?php  echo MODULE_URL?>template/web/template/js/memberdiys.js?v=<?php  echo time();?>"></script>

