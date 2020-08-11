
var myyapp = angular.module('myyapp',[]);
myyapp.controller('ctr',['$scope',function($scope){
	
	$scope.nav = {
		num : 2,
		padding : 5,
		bgcolor : '#ffffff',
		color : '#999',
		actcolor : '#ed414a',
		data : [
			{
				id : '00000001',
				name : '导航名称',
				img: window.sysinfo.siteroot+'/addons/zofui_sitetemp/public/images/thank.png',
				actimg: window.sysinfo.siteroot+'/addons/zofui_sitetemp/public/images/thank.png',
				url : '',
                type : 'url',
			},
			{
				id : '00000002',
				name : '导航名称',
				img: window.sysinfo.siteroot+'/addons/zofui_sitetemp/public/images/thank.png',
				actimg: window.sysinfo.siteroot+'/addons/zofui_sitetemp/public/images/thank.png',
				url : '',
                type : 'url',
			},																	
		]
	};

    $scope.otherurl = [
        {title:'查看表单数据',url:'/zofui_sitetemp/pages/form/form'},
        {title:'文章列表',url:'/zofui_sitetemp/pages/artlist/artlist'}
    ];
    
    
	$scope.items = page && page.data ? page.data : $scope.nav; // 初始数据

	$scope.changeNum = function( num ){
        var nowlength = $scope.items.data.length;
        var diff = num - nowlength;
        $scope.items.num = num;
        if( diff > 0 ) {
        	for (var i = 0; i < diff; i++) {
        		var mid = 'm'+i+new Date().getTime();
				$scope.items.data.push({
					id : mid,
					img : window.sysinfo.siteroot+'/addons/zofui_sitetemp/public/images/thank.png',
					actimg: window.sysinfo.siteroot+'/addons/zofui_sitetemp/public/images/thank.png',
					url : '',
					name : '导航名称',
                    type : 'url',
				})
        	}
        	
        }else if( diff < 0 ){
        	for (var i = -diff; i > 0; i--) {
        		$scope.items.data.splice(i,1);
        	}
        }
	};


	// 保存数据
	$scope.issaving = false;
	$scope.saveData = function(){
		if($scope.issaving) return false;
		
		$scope.issaving = true;
        $.ajax({
            type: 'POST',
            dataType : 'json',
            url: window.sysinfo.siteroot + '/web/index.php?c=site&a=entry&op=savebar&do=ajax&m=zofui_sitetemp',
            data: {data : $scope.items, tid : tempid },
            success: function(data){
                if(data.status == 200){
                    alert("已保存！");
					//location.href = window.sysinfo.siteroot + '/web/index.php?c=site&a=entry&op=list&do=bar&m=zofui_sitetemp';
            	}else{
                    alert("保存失败");
                }
            },
            error: function(){
                alert('保存失败请重试,如果站点设置了cdn加速可能被cdn拦截了。');
            },
            complete : function(){
            	$scope.issaving = false;
            }
        })
	}

    $scope.seturltype = 'page';
    $scope.pagetype = function( type ){
        $scope.seturltype = type;
    }


	// 设置链接
    $scope.setlinkdid = 0;
    $scope.allpage = null;
    $scope.allapp = null;
    $scope.allnews = null;
    $scope.urltype = '';

    $scope.setindex = 0; // 限制第一个选择其他链接
	$scope.showLink = function(dataid,type,i){
        console.log( i );
        $scope.urltype = type;
		$scope.setlinkdid = dataid;
        $scope.setindex = i;

        if( i == 0 ) {
            $scope.seturltype = 'page';
        }

		if( !$scope.allpage && type == 'my' ) {
			Http('post','json','getlink',{tid : tempid},function(data){
				//webAlert(data.res);
				if( data.obj.page.length > 0 ){
					$scope.allpage = data.obj.page;
				}
                if( data.obj.news.length > 0 ){
                    $scope.allnews = data.obj.news;
                }   
				$scope.$apply();
			},true);
		}
        // 小程序链接
        if( !$scope.allapp && type == 'app' ) {
            Http('post','json','getapp',{tid : tempid},function(data){
                //webAlert(data.res);
                if( data.obj.length > 0 ){
                    $scope.allapp = data.obj;
                }
                $scope.$apply();
            },true);
        }

		$('.my_model[url]').show();
	};


	$scope.setLink = function(url,name,uid){

	    angular.forEach($scope.items.data, function(n) {
	        if(n.id == $scope.setlinkdid){
	        	n.pageid = uid;
	            n.url = url;
	            n.urlname = name;
	            return false;
	        }
	    });
		
		$('.my_model[url]').hide();
	};	

    // 其他小程序链接
    $scope.setotherLink = function(item,initem){
        angular.forEach($scope.items.data, function(m) {
            console.log( m,$scope.setlinkdid );
            if(m.id == $scope.setlinkdid){
                m.appid = item.appid;
                m.appurl = initem.url;
            }
        }); 
        $('.my_model[url]').hide();
    };


    $scope.ismap = false;
    $scope.lng = 0;
    $scope.lat = 0;
    $scope.mapindex = -1;
    $scope.showMap = function(i){
        $scope.mapindex = i;
        //$scope.lng = $scope.lat = 0;

        if( !$scope.ismap ) {
            $scope.ismap = true;
            var map = new qq.maps.Map(document.getElementById("map"), {
                center: new qq.maps.LatLng(39.916527,116.397128),
                zoom:11,
                disableDefaultUI: true
            });
            //获取城市列表接口设置中心点
            citylocation = new qq.maps.CityService({
                complete : function(result){
                    map.setCenter(result.detail.latLng);
                }
            });
            //调用searchLocalCity();方法    根据用户IP查询城市信息。
            citylocation.searchLocalCity();

            // 点击
            var markers = [];
            qq.maps.event.addListener(map, 'click', function(e) {
                if( markers ) clearOverlays( markers );
                var pointer = new qq.maps.LatLng(e.latLng.lat,e.latLng.lng);
                var marker = new qq.maps.Marker({
                    position: pointer,
                    map: map,
                    animation: qq.maps.MarkerAnimation.BOUNCE
                });

                markers.push( marker );

                $scope.lng = e.latLng.lng;
                $scope.lat = e.latLng.lat;             
            });

            // 检索
            var latlngBounds = new qq.maps.LatLngBounds();
            //调用Poi检索类
            searchService = new qq.maps.SearchService({
                complete : function(results){

                    var pois = results.detail.pois;

                    if( pois && pois.length > 0 ) {

                        for(var i = 0,l = pois.length;i < l; i++){
                            var poi = pois[i];
                            latlngBounds.extend(poi.latLng);  
                            var marker = new qq.maps.Marker({
                                map:map,
                                position: poi.latLng
                            });
                            marker.setTitle(i+1);
                            markers.push(marker);
                        }
                        map.fitBounds(latlngBounds);
                    }else{
                        alert('没有找到');
                    }
                }
            });

            //清除地图上的marker
            function clearOverlays(overlays){
                if( !overlays ) return;
                var overlay;
                while(overlay = overlays.pop()){
                    overlay.setMap(null);
                }
            }

            geocoder = new qq.maps.Geocoder({
                complete : function(result){
                    console.log( result );
                    map.setCenter(result.detail.location);

                    clearOverlays(markers);
                    searchService.setLocation( result.detail.addressComponents.city );

                    var keyword = document.getElementById("searaddress").value;
                    searchService.search(keyword);

                }
            });


            $('#find_address').click(function(){
                var p = map.getCenter();
                var latLng = new qq.maps.LatLng(p.lat, p.lng);
                geocoder.getAddress(latLng);                
            });

        }

        $('.my_model[map]').show();
    }

    $scope.setLocation = function(){
    	console.log('321')
        if( $scope.lng <= 0 || $scope.lat <= 0 || $scope.mapindex < 0 ) {
            webAlert('请先点击选择坐标');return false;
        }
        
        $scope.items.data[ $scope.mapindex ].lng = $scope.lng;
        $scope.items.data[ $scope.mapindex ].lat = $scope.lat;
        $scope.mapindex = -1;
        
        $('.my_model[map]').hide();
    };

	// 上传图片
    $scope.uploadImage = function(id,type){
        require(['jquery', 'util'], function($, util){
            util.image('',function(data){
            	if(type == 'actimg'){
            		id.actimg = data['url'];

            	}else if(type == 'goodimg'){
            		id.img = data['url'];
            	}else{
	                var items = $scope.items;
	                angular.forEach(items, function(m,index) {
	                    if(m.id == id){
	                        m.params[type] = data['url'];
	                    }
	                }); 
            	}
				//处理图片后重置焦点到当前模块
				$scope.$apply();
                //$("div[viewid="+id+"]").trigger("click");
            });
        });
    };
  
   $scope.delItem = function(id,e){
   		e.stopPropagation();
   		if(confirm('确定要删除吗？')){
   			angular.forEach($scope.items,function(m,i){
   				if(m.id == id){
   					$scope.items.splice(i,1);
   					$scope.focus.id = '';
   					return false;
   				}
   			})
   		}
   		return false;
   };


   $scope.move = function(id){
   		$this = $('.view_item');
            $this.off("mousedown").mousedown(function(e) {
                if(e.which != 1 || $(e.target).is("textarea") || window.downing) return;
                var _this = $(this);
                e.preventDefault();
                e.stopPropagation();
                var x = e.pageX;
                var y = e.pageY;
                var w = _this.width();
                var h = _this.height();
                var w2 = w/2;
                var h2 = h/2;
                var left = _this.position().left;
                var top = _this.position().top;
                window.downing = true;

                _this.before('<div id="holder"></div>');
                var wid = $("#holder");

                wid.css({"border":"2px dashed #ccc", "height" : _this.outerHeight(true)});
               _this.css({"width":w, "height":h, "position":"absolute", opacity: 0.8, "z-index": 900, "left":left, "top":top});
                 $('body').mousemove(function(e) {
                    e.preventDefault();
                    var l = left + e.pageX - x;
                    var t = top + e.pageY - y;
                    _this.css({"left":l, "top":t});
                    var ml = l+w2;
                    var mt = t+h2;
                    _this.siblings().not(_this).not(wid).each(function(i) {
                    	
                        var obj = $(this);
                        var a1 = obj.position().left;
                        var a2 = obj.position().left + obj.width();
                        var a3 = obj.position().top;
                        var a4 = obj.position().top + obj.height();
                        if(a1 < ml && ml < a2 && a3 < mt && mt < a4) {
                            if(!obj.next("#holder").length) {
                                wid.insertAfter(this);
                            }else{
                                wid.insertBefore(this);
                            }
                            return;
                        }
                    });
                });
                $('body').mouseup(function() {
                	
                	$('body').off('mouseup').off('mousemove');
                    $('.mobile_body').each(function() {

                        var obj = $(this).children();
                        var len = obj.length;
                        if(len == 1 && obj.is(_this)) {
                            $("<div></div>").appendTo(this).attr("class", "kp_widget_block").css({"height":100});
                        }
                        else if(len == 2 && obj.is(".kp_widget_block")){
                            $(this).children(".kp_widget_block").remove();
                        }
                    });
                    var p = wid.position();
                    _this.animate({"left":p.left, "top":p.top}, 100, function() {
                        _this.removeAttr("style");
                        wid.replaceWith(_this);
                        window.downing = null;
                        /*var arr = [];
                        $(".view_item").each(function(i) {
                        	
                            arr[i] = $(this).attr('viewid');
                        });
                        var newarr = [];

                    	//var nowitem = $.extend(true,{},scope.items)
                        angular.forEach(arr, function(aid){
                            angular.forEach($scope.items, function(obj){
                                if(obj.id== aid){
                                    newarr.push(obj);
                                    return false;
                                }
                            });
                        });

                        $scope.items = newarr;*/
                    });
                });
            });
   }



}])
.directive('viewDelete',function(){
	return {
		restrict : 'A',
		link : function(scope,elem,attr){
			$(elem).on('mouseover',function(e){
				$(elem).next().show();
				e.stopPropagation();
			})
			$(elem).on('mouseleave',function(e){
				$(elem).next().hide();
				e.stopPropagation();
			})			
		}
	}
})
.directive('addModule',function($timeout){
	return {
		restrict : 'A',
		link : function(scope,elem,attr){
			$(elem).on('click',function(){
				angular.forEach(scope.modules,function(m){
					if(m.name == attr.name){
						console.log( m );
						var mid = 'm'+new Date().getTime();
						var tempobj = $.extend(true,{},m);
						
						var newitem = {id:mid,name:tempobj.name,params:tempobj.params};
						var index = -1;
						angular.forEach(scope.items,function(m,i){
							if(m.id == scope.focus.id){
								index = i;
								return false;
							}
						})
						
						scope.items.splice(index+1,0,newitem);
						
						
						scope.$apply();
						$('div[viewid='+mid+']').trigger('click');
						return false;
					}
				})
			})
		}
	}
})
.directive('stringHtml' , function(){
    return function(scope , el , attr){
        if(attr.stringHtml){
            scope.$watch(attr.stringHtml , function(html){
                el.html(html || '');
            });
        }
    };
})
.directive('mySlider',function(){
	return {
		restrict : 'A',
		link : function(scope,elem,attr){
			require(['jquery.ui'],function(){	
					$(elem).slider({
						min: parseInt( attr.min, 10 ),
						max: parseInt( attr.max, 10 ),
						value : parseInt( attr.value, 10 ) ? parseInt( attr.value, 10 ) : 0,
						slide : function(event,ui){
							if(attr.type == 2){
								scope.image[attr.name] = ui.value;
							}else{
								scope.item.params[attr.name] = ui.value;	
							}
							scope.$apply();	
						}
					});
			});
		}
	}
})
.directive("myDatePicker", function() {
        var a = {
            transclude: !0,
            template: "<span ng-transclude></span>",
            scope: {
                dateValue: "=myDateValue"
            },
            link: function(a, c, d) {	
                var e = {
                    lang: "zh",
                    step: "30",
                    format: "Y-m-d H:i:s",
                    closeOnDateSelect: !0,
                    onSelectDate: function(b, c) {
                        a.dateValue = b.dateFormat("Y-m-d H:i:s"), a.$apply("dateValue")
                    },
                    onSelectTime: function(b, c) {
                        a.dateValue = b.dateFormat("Y-m-d H:i:s"), a.$apply("dateValue")
                    }
                };
                require(['datetimepicker'], function() {
                	$(c).datetimepicker(e);
                });
            }
        };
    	return a
})
.directive('timeDesc',function($timeout){
	return {
		restrict : 'A',
		link :function(scope,elem,attr){
			setInterval(function(){
					var date = new Date();
					var time = date.getTime();  //当前时间距1970年1月1日之间的毫秒数 
					var timestr = attr.time;
					var endTime = timestr.replace(/-/g,'/'); 
					var endTime = new Date(endTime).getTime(); //结束时间字符串	
					var lag = (endTime - time); //当前时间和结束时间之间的秒数	
					if(lag > 0){
						var second = Math.floor(lag/1000%60);     
						var minite = Math.floor(lag/1000/60%60);
						var hour = Math.floor(lag/1000/60/60%24);
						var day = Math.floor(lag/1000/60/60/24);
						second = second.toString().length == 2 ? second : '0'+second;
						minite = minite.toString().length == 2 ? minite : '0'+minite;
						hour = hour.toString().length == 2 ? hour : '0'+hour;
						day = day.toString().length == 2 ? day : '0'+day;
					}else{
						var second = '00';
						var minite = '00';
						var hour = '00';
						var day = '00';
					}
					$(elem).find('.day').text(day);
					$(elem).find('.hour').text(hour);
					$(elem).find('.minite').text(minite);
					$(elem).find('.second').text(second);
			},1000)	
		}
	}
})
.directive('onSelected', function ($timeout) {
    return {
        restrict: 'A',
        scope : {
        	style : '=ngModel'
        },
        link: function (scope, elem, attr) {
            if(scope.style == $(elem).val()){
            	$(elem).parent().addClass('selected');
            }
        }
    }
})
.directive('onSelectSort', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, elem, attr) {
           	for(var i=0; i<scope.mysort.length; i++){
           		if(scope.mysort[i].sortid == scope.sort.id){
           			$(elem).prop('checked',true);
           			$(elem).parent().addClass('selected');
           		}
           	}
        }
    }
})

.directive('squareImage',function(){
    return {
        restrict: 'A',
        link: function (scope, elem, attr) {
        	var img = $(elem).find('img');
        	img.height(img.width());
        }
    }
});
