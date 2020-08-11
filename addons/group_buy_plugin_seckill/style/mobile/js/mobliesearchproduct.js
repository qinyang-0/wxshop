var page = 2;
var status = 1;
function getKey() {
	var frontPath = $("#frontPath").text();
	var serchKeywords = $(".top_search").val();
  	if(event.keyCode==13){
  		if(serchKeywords != ""){
			window.location.href=frontPath+'/mobile/exchange/productList.jhtml?keyword='+serchKeywords+"&exchangeChannel=client";
		}else{
			return;
		}
  		
    }
}
function getKey2() {
	var frontPath = $("#frontPath").text();
	var serchKeywords = $(".top_search").val();
//	window.location.href = "";
//	window.location.href=frontPath+'/mobile/exchange/productList.jhtml?keyword='+serchKeywords+"&exchangeChannel=client";
}
var isLoading = false;
$(window).on('scroll',function(){
   if($(window).scrollTop()>=$(document).height()-$(window).height()-200){
		if(!isLoading) {
			toNext();
		}
   }

});

function toNext() {
	if(parseInt($('#pageIndex').val()) >= parseInt($("#pageCount").val())) {
		$('#lastPage').show();
		//window.setTimeout("$('#lastPage').hide()", 1000);
	}else {
		 doAjax(true,1);
	 }
}

function gotoProductDetail(productId) {
	window.location.href = $("#frontPath").text() + "/mobile/exchange/productDetail.jhtml?productId=" + productId;
}

//function getFilterProductList(obj){
//	var idValue = $(obj).attr("id");
//	if($(obj).css("background-color") == "rgb(255, 0, 0)"){    //红色
//		$("#"+idValue).css("background-color" ,"rgb(240, 239, 240)").siblings().css("background-color" ,"rgb(240, 239, 240)");
//		if(idValue == "pScore"){ 
//			$("#scoreScope").val("");
//		}else if(idValue == "payMethod"){
//			$("#exchangeMethod").val("");
//		}else if(idValue == "ptype"){
//			$("#categoryPram").val("");
//		}
//	}else{
//		$("#"+idValue).css("background-color" ,"rgb(240, 239, 240)").siblings().css("background-color" ,"rgb(240, 239, 240)");
//		$(obj).css("background-color","#ff00006b");
//		if(idValue == "pScore"){ 
//			$("#scoreScope").val($(obj).html());
//			$("#searchMin").val("");
//			$("#searchMax").val("");
//		}else if(idValue == "payMethod"){
//			$("#exchangeMethod").val($(obj).attr("value"));
//		}else if(idValue == "ptype"){
//			$("#categoryPram").val($(obj).attr("value"));
//		}
//	}
//}




//确认筛选
function confirmFilterProductList(){
	// scoreRegion
	var minValue = $.trim($("#searchMin").val());
	var maxValue = $.trim($("#searchMax").val());
	if((minValue == "" || minValue == null) && (maxValue == "" || maxValue == null)){	//没有填写积分范围,不再发送请求
		doAjax(false);
	}else{																				//填写了积分范围
//		if(isNaN(minValue) || isNaN(maxValue)){
//			sweetAlert({
//	  			  title: '',
//	  			  text: "输入积分范围必须为数值！",
//	  			  type: null,
//	  			  showCancelButton: false,
//	  			  confirmButtonColor: "rgba(231, 83, 74, 0.77)",
//	  			  confirmButtonText: "确定",
//	  			  closeOnConfirm: false
//	  			});
//	    	return ;
//		}
//		var scoreRegion = "";
//		if(minValue == ""){
//			if(maxValue == ""){
//				return;
//			}
//			else{
//				scoreRegion = "0～" + maxValue;
//			}
//		}
//		else{
//			if(maxValue == ""){
//				scoreRegion = minValue + "以上";
//			}
//			else if(maxValue - minValue < 0){
//				sweetAlert({
//		  			  title: '',
//		  			  text: "积分范围输入有误！",
//		  			  type: null,
//		  			  showCancelButton: false,
//		  			  confirmButtonColor: "rgba(231, 83, 74, 0.77)",
//		  			  confirmButtonText: "确定",
//		  			  closeOnConfirm: false
//		  			});
//				return;
//			}
//			else{
//				scoreRegion = minValue + "～" + maxValue;
//			}
//		}
		//删除选择的积分样式
		$("#pScore").css("background-color" ,"rgb(240, 239, 240)").siblings().css("background-color" ,"rgb(240, 239, 240)");
		// 更新隐藏域
//		$("#scoreScope").val(scoreRegion);
		doAjax(false);
	}
}

//重置筛选
function resetFilterProductList(){
	$("#pScore").css("background-color" ,"rgb(240, 239, 240)").siblings().css("background-color" ,"rgb(240, 239, 240)");
	$("#payMethod").css("background-color" ,"rgb(240, 239, 240)").siblings().css("background-color" ,"rgb(240, 239, 240)");
	$("#ptype").css("background-color" ,"rgb(240, 239, 240)").siblings().css("background-color" ,"rgb(240, 239, 240)");
	$("#exchangeMethod").val("");
	$("#categoryPram").val("");
	$("#scoreScope").val("");
	$("#strSortField").val("");
	$("#strOrderType").val("");
//	doAjax(false);
}

//异步请求，并把结果显示到页面
function doAjax(isPagination,pages=0){
	var data = {};
	//关键字
	var serchKeywords = $(".top_search").val();
	data['g_name'] = serchKeywords;
	//分类id
	var categoryPram = $("#categoryPram").val();
	data['g_cid'] = categoryPram;
	//积分范围
	var searchMin = $("#searchMin").val();
	var searchMax = $("#searchMax").val();
	data['searchMin'] = searchMin;
	data['searchMax'] = searchMax;
	//销量||积分
	var sortField = $("#strSortField").val();
	data['sort'] = sortField;
	//升||降
	var orderType = $("#strOrderType").val();
	//跳转地址
	var address = $('#address').val();
	data['type'] = orderType;
	var urls = $('#url').val();
	if(pages != 0){
		data['page'] = page;
	}else{
		status = 1;
	}
	if(status == 1){
		status ++;
		$.post(urls,data,function(res){
			if(res.code == 0){
				//请求成功
				var str = '';
				$.each(res.data,function(j,i){
					if(j%2 == 0){
						str += '<div class="gslist">';
					}
					str += '<a href="'+address+'&id='+i.g_id+'" class="fl">';
					str += '<div class="gs-img"><img src="'+i.g_icon+'"></div>';
					str += '<div class="gs-txt">';
					str += '	<div class="gs-name">';
					str += i.g_name;
					str += '	</div>';
					str += '	<div class="gs-pri">'+i.g_price+'积分</div>';
					str += '</div>';
					str += '</a>';
					if(j%2 != 0){
						str += '</div>';
					}
				})
				if(pages != 0){
					$('.proList').append(str);
					page++;
					status --;
				}else{
					$('.proList').html(str);
					status = 1;page = 2;
				}
			}else{
				
			}
//			console.log(res);
		},"JSON");
	}
	
	// 刷新搜索结果
//	$.ajax({type:"post",
//			url:frontPath + "/mobile/exchange/jsonProductList."+webType,
//			data:{keyword:serchKeywords, payType:exchangeMethod, categoryPram:categoryPram, scoreRegion:scoreScope,
//				exchangeChannel:exchangeChannel, pageIndex:pageIndex, strSortField:sortField, strOrderType:orderType,categoryId:categoryId },
//			success:function(data){
//				var json = jQuery.parseJSON(data);
//				if(json.length == 1 && json[0] === "error") {
//					window.location.href = frontPath + "/mobile/exchange/productList." + webType
//				}
//				$("#pageCount").val(json[0]);
//				var json1 = json[1];
//				
//				var content = "";
//				for(var i = 0; i < json1.length; i++) {
//					var obj = json1[i];
//					//因为的到的数据经常出现span标签，数据过长在截取始捞出现格式错误，所以就把所有<span>和</span>替换为""
//					var titleStyle = obj.title;
//						titleStyle = titleStyle.replace("</span>","");
//						titleStyle = titleStyle.replace("<span>","");
//					if((i+1)%2 == 0){
//							content +='<a class="fr" onclick="javascript: gotoProductDetail(\'' + obj.productId + '\');">';
//								content +='<div class="gs-img"><img src="'+obj.pictureUrl+'" alt=""></div>';
//								content +='<div class="gs-txt">';
//									content +='<div class="gs-name">';
//										if(titleStyle.length > 10){
//											content += titleStyle.substring(0,10);
//											content += "...";
//										}else{
//											content += obj.titleStyle;
//										}
//										content += '</div>';
//									content +='<div class="gs-pri">'+obj.price + pointText+'</div>';
//								content +='</div>';
//							content +='</a>';
//						content +='</div>';
//					}else{
//						content +='<div class="gslist">';
//								content +='<a class="fl" onclick="javascript: gotoProductDetail(\'' + obj.productId + '\');">';
//								content +='<div class="gs-img"><img src="'+obj.pictureUrl+'" alt=""></div>';
//								content +='<div class="gs-txt">';
//									content +='<div class="gs-name">';
//										if(titleStyle.length > 10){
//											content += titleStyle.substring(0,10);
//											content += "...";
//										}else{
//											content += obj.titleStyle;
//										}
////									content += obj.titleStyle;
//									content +='</div>';
//									content +='<div class="gs-pri">'+obj.price + pointText +'</div>';
//								content +='</div>';
//							content +='</a>';
//						if(json.length == 1 || json.length  == (i+1)){
//							content +='</div>';
//						}
//					}
//				}
//				if(isPagination){
//					$(".proList").append(content);
//				}else{
//					$(".proList").html();
//					$(".proList").html(content);
//				}
//				if(isPagination) {
//					$('#loadMore').hide();
//					isLoading = false;
//				}
//		    }
//	});
}

function confirmOrder(obj){
   var productId = $(obj).prev(".productId").val();
   var frontPath = $("#frontPath").text();
   var webtype = $("#webtype").text();
	window.location.href=frontPath+"/asiaMobile/orderConfirm."+webtype+"?productId="+productId;
}


//积分排序或销量排序
function selectSort(obj){
	if($(obj).text() == "销量优先"){
		$("#strSortField").val("g_real_sale_num");
		$("#strOrderType").val("desc");
		$(obj).text("销量降序");
	}else if($(obj).text() == "积分排序"){
		$("#strSortField").val("g_price");
		$("#strOrderType").val("desc");
		$(obj).text("积分降序");
	}else if($(obj).text() == "销量降序"){
		$("#strSortField").val("g_real_sale_num");
		$("#strOrderType").val("asc");
		$(obj).text("销量升序");
	}else if($(obj).text() == "积分降序"){
		$("#strSortField").val("g_price");
		$("#strOrderType").val("asc");
		$(obj).text("积分升序");
	}else if($(obj).text() == "销量升序"){
		$("#strSortField").val("g_real_sale_num");
		$("#strOrderType").val("desc");
		$(obj).text("销量降序");
	}else if($(obj).text() == "积分升序"){
		$("#strSortField").val("g_price");
		$("#strOrderType").val("desc");
		$(obj).text("积分降序");
	}
	doAjax(false);
}
