var opts = {
	type :'image',
	direct : false,
	multiple : true,
	tabs : {
		'upload' : 'active',
		'browser' : '',
		'crawler' : ''
	},
	path : '',
	dest_dir : '',
	global : false,
	thumb : false,
	width : 0
};
UE.registerUI('myinsertimage',function(editor,uiName){
	editor.registerCommand(uiName, {
		execCommand:function(){
			require(['fileUploader'], function(uploader){
				uploader.show(function(imgs){
					if (imgs.length == 0) {
						return;
					} else if (imgs.length == 1) {
						editor.execCommand('insertimage', {
							'src' : imgs[0]['url'],
							'_src' : imgs[0]['attachment'],
							'width' : '100%',
							'alt' : imgs[0].filename
						});
					} else {
						var imglist = [];
						for (i in imgs) {
							imglist.push({
								'src' : imgs[i]['url'],
								'_src' : imgs[i]['attachment'],
								'width' : '100%',
								'alt' : imgs[i].filename
							});
						}
						editor.execCommand('insertimage', imglist);
					}
				}, opts);
			});
		}
	});
	var btn = new UE.ui.Button({
		name: '插入图片',
		title: '插入图片',
		cssRules :'background-position: -726px -77px',
		onclick:function () {
			editor.execCommand(uiName);
		}
	});
	editor.addListener('selectionchange', function () {
		var state = editor.queryCommandState(uiName);
		if (state == -1) {
			btn.setDisabled(true);
			btn.setChecked(false);
		} else {
			btn.setDisabled(false);
			btn.setChecked(state);
		}
	});
	return btn;
}, 19);
UE.registerUI('myinsertvideo',function(editor,uiName){
	editor.registerCommand(uiName, {
		execCommand:function(){
			require(['fileUploader'], function(uploader){
				uploader.show(function(video){
					if (!video) {
						return;
					} else {
						var videoType = video.isRemote ? 'iframe' : 'video';
						editor.execCommand('insertvideo', {
							'url' : video.url,
							'width' : 300,
							'height' : 200
						}, videoType);
					}
				}, {type : 'video', allowUploadVideo : 'true'});
			});
		}
	});
	var btn = new UE.ui.Button({
		name: '插入视频',
		title: '插入视频',
		cssRules :'background-position: -320px -20px',
		onclick:function () {
			editor.execCommand(uiName);
		}
	});
	editor.addListener('selectionchange', function () {
		var state = editor.queryCommandState(uiName);
		if (state == -1) {
			btn.setDisabled(true);
			btn.setChecked(false);
		} else {
			btn.setDisabled(false);
			btn.setChecked(state);
		}
	});
	return btn;
}, 20);



var myyapp = angular.module('myyapp',['ng.ueditor','ui.sortable']);
//当type为1 是基础主键，为2是辅助主键 ，为3是全局主键
myyapp.controller('ctr',['$scope',function($scope){
	$scope.modules_type = [
		{
			name:'基础组件',
			type:1,
		},
		{
			name:'辅助组件',
			type:2,
		},
		// {
		// 	name:'高级组件',
		// 	type:3,
		// }
	];
    // $scope.getScreen = function(name){
    //     return $scope.current == "'./../addons/group_buy/template/web/template/temp/edit-'"+name+"'.html'";
    // };
	$scope.modules = [
        {
            name : 'menu',
            title : '列表导航',
            type:1,
            params : {
                type:'1',
                data:[
                    {
                        id : '00000001',
                        img: window.sysinfo.siteroot+'addons/group_buy/public/bg/coupon.png',
                        type : 'url',
						url:'',
                        key:'coupon',
                        title:'优惠卷大厅',
                    },
                ]
            }
        },
	];

	$scope.params = page && page.params ? page.params : {}; // 初始数据
	$scope.name = action;
	if( page && page.params ){
	    angular.forEach($scope.params.data,function(m,i){
	       	if(m.name == 'text'){
	        	m.params.content = decodeURIComponent(m.params.content);
	        }
	    })
	}

	$scope.focus = {
		id : '00000000',
		name : 'memberbasic'
	};
	
	$scope.article = article;
	$scope.allsort = allsort;
	$scope.op = op;

	// $scope.items = page ? page.data : [];
	$scope.memberbasic =  page ? page : {
		id:'0000000',
		name : 'memberdiy',
		title : '用户中心',
		head_bg_img : window.sysinfo.siteroot+'addons/group_buy/public/bg/topbg1.png',
		order:{
            icon1:window.sysinfo.siteroot+'addons/group_buy/public/bg/needPayIcon.png',
            icon2:window.sysinfo.siteroot+'addons/group_buy/public/bg/undeli.png',
            icon3:window.sysinfo.siteroot+'addons/group_buy/public/bg/distributionIcon.png',
            icon4:window.sysinfo.siteroot+'addons/group_buy/public/bg/completeIcon.png',
            icon5:window.sysinfo.siteroot+'addons/group_buy/public/bg/refundIcon.png',
		},
		menu:{
			type:'1',
			data:[
				{
					id : '00000001',
					img: window.sysinfo.siteroot+'addons/group_buy/public/bg/coupon.png',
					type : 'url',
					key:'coupon',
					title:'优惠卷大厅',
				},
                {
                    id: '00000002',
                    img: window.sysinfo.siteroot + 'addons/group_buy/public/bg/my_coupon.png',
                    type: 'url',
                    key: 'my_coupon',
                    title: '我的优惠卷',
                },
                {
                    id : '00000003',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/select_head.png',
                    type : 'url',
                    key:'select_head',
                    title:'选择团长',
                },
                {
                    id : '00000004',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/head_mannge.png',
                    type : 'url',
                    key:'head_mannge',
                    title:'团长管理',
                },
                {
                    id : '00000005',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/head_mannge.png',
                    type : 'url',
                    key:'apply_head',
                    title:'申请团长',
                },
                {
                    id : '00000006',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/head_info.png',
                    type : 'url',
                    key:'head_info',
                    title:'团长信息',
                },
                {
                    id : '00000007',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/distribution_center.png',
                    type : 'url',
                    key:'distribution_center',
                    title:'分销中心',
                },
                {
                    id : '00000008',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/fraction_center.png',
                    type : 'url',
                    key:'fraction_center',
                    title:'积分商城',
                },
                {
                    id : '00000009',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/apply_suppiler.png',
                    type : 'url',
                    key:'apply_suppiler',
                    title:'供应商招募',
                },
                {
                    id : '00000010',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/frequently_asked_questions.png',
                    type : 'url',
                    key:'frequently_asked_questions',
                    title:'常见问题',
                },
                {
                    id : '00000011',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/qualification_rules.png',
                    type : 'url',
                    key:'qualification_rules',
                    title:'资质规则',
                },
                {
                    id : '00000012',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/link_custom.png',
                    type : 'url',
                    key:'link_custom',
                    title:'联系客服',
                },
                {
                    id : '00000013',
                    img: window.sysinfo.siteroot+'addons/group_buy/public/bg/integral_check.png',
                    type : 'url',
                    key:'integral_check',
                    title:'积分签到',
                },
			]
		}

	};

	$scope.addForm = function( id,type ){

		angular.forEach($scope.items, function(obj){
			if( obj.id == id ) {
        		var mid = 'm'+ new Date().getTime();
				obj.params.data.push({
					id : mid,
					type : type,
					name : '名称',
					pla : '',
					data : [],
				})
			}
		});
	};

	$scope.addFormIn = function(id,iid){
		angular.forEach($scope.items, function(obj){
			if( obj.id == id ) {
				angular.forEach(obj.params.data, function(objin){
					if( objin.id == iid ) {
		        		var fid = 'f'+ new Date().getTime();
						objin.data.push(
							{id : fid,name : ''}
						);
		        		
					}
				});				
			}
		});
	};


	$scope.deleteFormIn = function(id,iid,fid){
		angular.forEach($scope.items, function(obj){
			if( obj.id == id ) {
				angular.forEach(obj.params.data, function(obji){
					if( obji.id == iid ) {
						angular.forEach(obji.data, function(objf,f){
							if( objf.id == fid ) {
				        		obji.data.splice(f,1);
							}
						});
					}
				});				
			}
		});
	}

	// 保存数据
	$scope.issaving = false;
	$scope.saveData = function(type){
		if($scope.issaving) return false;
        var arr = [];
        $(".view_item,.view_item_fix").each(function(i) {
            arr[i] = $(this).attr('viewid');
        });
        var newarr = [];
        angular.forEach(arr, function(aid){
            angular.forEach($scope.items, function(obj){
                if(obj.id== aid){
                	var newdata = $.extend(true,{},obj);
                    newarr.push( newdata );
                    return false;
                }
            });
        });
        angular.forEach(newarr,function(m,i){
        	if(m.name == 'text'){
        		m.params.content = encodeURIComponent(m.params.content);
        	}
        })
        //其中items为身体内容 baseic 为头部  id page为(不知道)
		// var items = angular.toJson(newarr);
		var basic = angular.toJson($scope.memberbasic);
		// console.log(basic);
		$scope.issaving = true;
		//向后端发起请求
        $.ajax({
            type: 'POST',
            dataType : 'json',
            url: window.sysinfo.siteroot + '/web/index.php?c=site&a=entry&op=savemember&do=diy&m=group_buy',
            data: {basic : JSON.parse(basic),type:type},
            success: function(data){
            	// console.log(data)
            	if(data.status == 1){
            		if(data.setTitle != '' ){
                        //iframe层-父子操作
						console.log(data.setTitle);
					}else{
                        layer.msg(data.msg, {
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        }, function(){
                            location.href = "/web/index.php?c=site&a=entry&op=member_diy&do=diy&m=group_buy";
                        });
					}

            	}else{
                    layer.msg(data.msg);
            	}
            },
            error: function(){
                layer.msg('保存失败请重试');
            },
            complete : function(){
            	$scope.issaving = false;
            }
        })
	}

	$scope.changeS = function(type,s){
		if(type == 'status') $scope.mystatus = s;
		if(type == 'top') $scope.mytop = s;
	}


	$scope.addGoodImages = function(){
		var newitem = $.extend(true,{},$scope.imgmodule);
		newitem.id = 'i'+ new Date().getTime();
		$scope.items.push(newitem);
		$scope.imgfocus = newitem.id;
		$scope.getFocus('00000002');$scope.apply();
	};

	$scope.seturltype = 'page';
	$scope.pagetype = function( type ){
		$scope.seturltype = type;
	}

	// 导入页面
	$scope.isloaded = false;
	$scope.loadpagelist = [];
	$scope.loadpage = function(){
		if( $scope.loadpagelist.length <= 0 ) {
			Http('post','json','loadpagelist',{},function(data){
				if( data.obj.length > 0 ){
					$scope.loadpagelist = data.obj;
				}
				$scope.$apply();
			},true);
		}
		$('.my_model[loadpage]').show();
	};




	//隐藏弹窗
	$scope.cancel_hides = function(id,m_id){
		angular.forEach($scope.params.data,function(m,i){
	       	if(m.id == $scope.setlinkiid){
	        	m.params.automatic = 1;
	        }
	    })
		$('.my_model_article').hide();
	}

	
	
	//选择已有模板
	$scope.linktype = function(res){
		$scope.urltype = 'list';
//		获取已有模板
		Http('post','json','template',{tid : tempid},function(res){
			if(res.data.length > 0){
				$scope.alltempalte = res.data;
			}
			$scope.$apply();
		},true);
		$('.my_model_tempalte').show();
	};
	//确定选择
	$scope.setLinks = function(page){
		console.log(page)
		$scope.params = page ? page : {};
		if(page){
		    angular.forEach($scope.params.data,function(m,i){
		       	if(m.name == 'text'){
		        	m.params.content = decodeURIComponent(m.params.content);
		        }
		    })
		}
		$scope.items = page  ? page.data : [];
		$scope.basic =  page && page ? page.basic : {
			id:'0000000',
			name : '',
			title : '',
			sharetitle : '',
			shareimg : '',
			isbar : 0,
			topbg : '#ffffff',
			topcolor : '#000000',
		};
		$('.my_model_tempalte').hide();
	}
	$scope.settempalte = function(){
		$('.my_model_tempalte').hide();
	}

	//确定点击
	$scope.setLink = function(url,name){
	    angular.forEach($scope.items, function(m) {
	        if(m.id == $scope.setlinkiid){
	        	if( $scope.setlinkdid ) {
	        		console.log(m)
	        		if(m.name == 'headlines'){
	        			angular.forEach(m.params.datas, function(n) {
					        if(n.id == $scope.setlinkdid){
					            n.url = url;
					            n.urlname = name;
					            return false;
					        }
					    });
	        		}else{
	        			angular.forEach(m.params.data, function(n) {
					        if(n.id == $scope.setlinkdid){
					            n.url = url;
					            n.urlname = name;
					            return false;
					        }
					    });
	        		}
	        	}else{
		            m.params.url = url;
		            m.params.urlname = name;
		            return false;
	        	}
	        }
	    }); 
		$('.my_model_url').hide();
//		$('.my_model[url]').hide();
	};	


    $scope.draggable = function(){
    	$('.my_model[map]').hide();
        $('.ui-draggable').hide();
        
    };
	// 上传图片
    $scope.uploadImage = function(id,type){
        require(['jquery', 'util'], function($, util){
            util.image('',function(data){
            	if(type == 'head_bg_img'){
            		$scope.memberbasic.head_bg_img = data['url'];
            	}else if(type == 'icon1' || type == 'icon2' || type == 'icon3' || type == 'icon4' || type == 'icon5'){
            		console.log(type);
                    $scope.memberbasic.order[type] = data['url'];
				}else if(type=='goodimg'){
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

    $scope.sortableOptions = function(){
        $scope.sortableOptions = {
            update: function(e, ui) {
                console.log("update",e,ui);
                //需要使用延时方法，否则会输出原始数据的顺序，可能是BUG？
                $timeout(function() {
                    var resArr = [];
                    /*for (var i = 0; i < $scope.data.length; i++) {
                        resArr.push($scope.data[i].i);
                    }*/
                })
            },

            // 完成拖拽动作
            stop: function(e, ui) {
                console.log( 'end' );
            }
        }
    };


   	$scope.getFocus = function(id){
		$scope.focus.id = id;

		if($scope.params.arttype == 2 && id == '00000002'){
			height = 400;
		}else{
			var $this = $('div[viewid='+id+']');
       		var height = $this.offset().top;
		}

        var starttop = $('.my_article_box').offset().top;
//      $('.portable_editor').css('margin-top',height-starttop-10);
   };

   $scope.addgood = function(good){
   		var id = 'g'+new Date().getTime();
   		var newgood = $.extend(true,{},$scope.modules[0].params.data[0]);
     	console.log(newgood,$scope.modules[0].params.data[0])
   		newgood.id = id;
   		good.push(newgood);
// 		console.log(good)
   };


   	$scope.deleteItem = function(pid,cid){
   		if(cid == 'images'){
	   		angular.forEach($scope.items,function(m,i){
	   			if(pid == m.id){
	   				if($scope.items.length <= 1){
	   					alert('至少一张图片');
	   					return false;
	   				}
	   				$scope.items.splice(i,1);
	   				if(i == 0){
	   					$scope.imgfocus = $scope.items[0].id; // 焦点
	   				}else{
	   					$scope.imgfocus = $scope.items[i-1].id; // 焦点
	   				}
	   				
	   			}
	   		})
   		}else{
	   		angular.forEach($scope.items,function(m,i){
	   			if(m.id == pid){
	   				angular.forEach(m.params.data,function(cm,ci){
	   					if(cm.id == cid){
	   						m.params.data.splice(ci,1);
	   						if(m.params.data.length <= 0){
	   							$scope.items.splice(i,1);
	   						}
	   						return false;
	   					}
	   				})
	   				return false;
	   			}
	   		}) 			
   		}
   	};
  
   $scope.delItem = function(id,e){
   		e.stopPropagation();
   		var data = $scope.items;
   		var arr = [];
		for (let i in data) {
		    arr.push(data[i]);
		}
		var act = false;
		console.log(data);
		layer.open({
			type:0,
			icon:3,
			title:'提示',
			content:"确定要删除吗？",
			yes:function (index,layero) {
                for(var i in data){
                    if(data[i].id == id){
                        arr.splice(i,1);
                        console.log(arr);
                        $scope.focus.id = '';
                    }
                }
                $scope.items = arr;
                console.log($scope.items);
                layer.close(index);
                $scope.$apply();
            },
            scope  : $scope
		})

   		return false;
   };
    $scope.moveup = function(id,e){
        e.stopPropagation();
        var data = $scope.items;
        var arr = [];
        for (let i in data) {
            arr.push(data[i]);
        }
        var act = false;
        var tmp = {};
        angular.forEach(data,function(m,k){
			if(m.id == id && k>0){
                tmp = $scope.items[k-1];
                $scope.items[k-1] =  $scope.items[k];
                $scope.items[k]=tmp;
			}
		});
	},
	$scope.movedown = function(id,e){

		e.stopPropagation();
		var data = $scope.items;
		var arr = [];
		for (let i in data) {
			arr.push(data[i]);
		}
		var act = false;
		var tmp = {};
        console.log(data.length)
		var fas = true;
		angular.forEach(data,function(m,k){
			if(k<data.length-1 && m.id == id && fas ){
				console.log(k);
				tmp = $scope.items[k+1];
				$scope.items[k+1] =  $scope.items[k];
				$scope.items[k]=tmp;
                fas = false;
			}
		});
	},
	$scope.toString = function(target){
        return Object
            .keys(target)
            .map(function(key){
                var val = target[key];
                if(typeof val === 'object'){
                    return toString(val);
                }
                return val;
            })
            .join(' | ');
    },
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
				if( (scope.items.length > 0 && attr.name == 'webview') || ( scope.items[0] && scope.items[0].name == 'webview') ){
					webAlert('网页容器只能存在最外层，并且只能有1个');
					return false;
				}
				angular.forEach(scope.modules,function(m){
					if(m.name == attr.name){
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
        	
    		var v = scope.style ? scope.style : 0;
            if(v == $(elem).val()){
            	$(elem).parent().addClass('selected');
            }

        }
    }
})
.directive('onSelectSort', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, elem, attr) {
        	if( scope.$last ){
        		//console.log( attr )	
        	}
           	
        }
    }
})
.directive('onFinishRender',['$timeout', '$parse', function ($timeout, $parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
        	

            if (scope.$last === true) {
        		
            	$('.dsadasda').each(function(){
            		var _this = $(this);
            		console.log( _this.attr('model') );
            		if( _this.attr('model') == _this.attr('value') ){

            			_this.parent().addClass('selected');
            		}
            	});
            }
        }
    }
}])
.directive('squareImage',function(){
    return {
        restrict: 'A',
        link: function (scope, elem, attr) {
        	var img = $(elem).find('img');
        	img.height(img.width());
        }
    }
})
.directive('errSrc', function() {
    return {
        link: function(scope, element, attrs) {
            element.bind('error', function() {
                if (attrs.src != attrs.errSrc) {
                    attrs.$set('src', attrs.errSrc);
                }
            });
        }
    }
});
