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
		{
			name:'高级组件',
			type:3,
		}
	];
	$scope.modules = [
		{
			name : 'slide',
			title : '幻灯片',
			type:1,
			params : {
				ischange : 0,
				changetime : 3,
				changelast : 500,
				pointcolor : '#dddddd',
				actcolor : '#585656',
				showpoint : 0,
				height:'150',
				data : [
					{
						id : '00000001',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/stemp.png',
						type : 'url',
					}
					
				]
			}
		},
		{
			name : 'nav',
			title : '导航',
			type:1,
			params : {
				num : 4,
				radius : 0,
				padding : 5,
				bgcolor : '#ffffff',
				fontcolor : '#000',
				data : [
					{
						id : '00000001',
						title : '导航名称',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						type : 'url',
						url : ''
					},
					{
						id : '00000002',
						title : '导航名称',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						type : 'url',
						url : ''
					},
					{
						id : '00000003',
						title : '导航名称',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						type : 'url',
						url : ''
					},
					{
						id : '00000004',
						title : '导航名称',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						type : 'url',
						url : ''
					},
					{
						id : '00000005',
						title : '导航名称',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						type : 'url',
						url : ''
					},																		
				]
			}
		},
		{
			name : 'bars',
			title : '脚步导航',
			type:1,
			bgcolor : '#fff',
			color : '#fff',
			actcolor : '#dd4f43',
			params : {
				radius : 0,
				padding : 5,
				bgcolor : '#ffffff',
				fontcolor : '#000',
				actcolor : '#dd4f43',
				num : 5,
				data : [
					{
						id : '00000001',
						title : '导航名称',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						actimg: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						type : 'url',
						url : ''
					},
					{
						id : '00000002',
						title : '导航名称',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						actimg: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						type : 'url',
						url : ''
					},
					{
						id : '00000003',
						title : '导航名称',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						actimg: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						type : 'url',
						url : ''
					},
					{
						id : '00000004',
						title : '导航名称',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						actimg: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						type : 'url',
						url : ''
					},
					{
						id : '00000005',
						title : '导航名称',
						img: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						actimg: window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
						type : 'url',
						url : ''
					},
				]
			}
		},
		{
			name : 'image',
			title : '广告',
			type:1,
			params : {
				padding : 1,
				type : 1,
				istext : 0,
				fontsize : 14,
				fontcolor : '#333',
				bgcolor : '#ffffff',
				data : [
					{
						id : '00000001',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/stemp.png',
						url : '',
						title : '',
						type : 'url',
					}
				]

			}
		},
		{
			name : 'headlines',
			title : '装修头条',
			type:1,
			params : {
				padding : 1,
				type : 1,
				istext : 1,
				automatic:1,
				fontsize : 14,
				fontcolor : '#333',
				bgcolor : '#ffffff',
				color:'#00cc99',
				names:'',
				ids:'',
				nums:2,
				img : window.sysinfo.siteroot+'addons/sister_renovation/public/diyimages/333.jpg',
				imgs: window.sysinfo.siteroot+'addons/sister_renovation/public/diyimages/44.jpg',
				datas : [
					{
						id : '00000001',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/stemp.png',
						text: '装修',
						url : '',
						title : '购房合同差个字就多...',
						type : 'url',
					},
					{
						id : '00000002',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/stemp.png',
						text: '装修',
						url : '',
						title : '购房合同差个字就多...',
						type : 'url',
					}
				],
				data:[
					{
						'id':00025,
						'img':window.sysinfo.siteroot+'addons/sister_renovation/public/diyimages/333.jpg',
					}
				]
			}
		},
		{
			name : 'site',
			title : '工地',
			type:1,
			params : {
				padding : 1,
				type : 1,
				istext : 0,
				fontsize : 14,
				fontcolor : '#333',
				bgcolor : 1,
				isenable:1,
				code:1,
				data : [
					{
						id : '00000001',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/site.png',
						imgs: window.sysinfo.siteroot+'addons/sister_renovation/public/images/sites.jpg',
//						bg_imgs: window.sysinfo.siteroot+'addons/sister_renovation/public/images/55.png',
						url : '',
						title : '',
						type : 'url',
					}
				]
			}
		},
		{
			name:'quarters',
			title : '小区',
			type:1,
			params : {
				is_text : 1,//是否自动获取数据
				padding : 1,//间距
				fontsize : 14,//字体大小
				fontcolor : '#333',//字体颜色
				show:'5',
				data : [
					{
						id : '00000001',
						name : '凤凰小区',
						address: '中国四川省成都市金牛区',
						site : '6个工地',
						site_color:'#00cc99',
						type : 'url',
						url : '',
					},
					{
						id : '00000002',
						name : '凤凰小区',
						address: '中国四川省成都市金牛区',
						site : '6个工地',
						site_color:'#00cc99',
						type : 'url',
						url : '',
					},
					{
						id : '00000003',
						name : '凤凰小区',
						address: '中国四川省成都市金牛区',
						site : '6个工地',
						site_color:'#00cc99',
						type : 'url',
						url : '',
					},
					
				]
			}
		},
		{
			name : 'card',
			title : '卡片',
			type:2,
			params : {
				margin : 5,
				bgcolor : '#ffffff',
				ishead : 0,
				isbot : 0,
				headsize : 14,
				headcontent : '卡头',
				headcolor : '#333',
				headalign : 'center',

				botcontent : '卡尾',
				botcolor : '#333',
				botsize : 14,
				botalign : 'center',

				content : '卡片内容',
				fontsize : 14,
			}
		},
		{
			name : 'list',
			title : '列表',
			type:2,
			params : {
				bgcolor : '#ffffff',
				color : '#333',
				titlesize : 14,
				descsize : 14,
				padding : 5,
				istext : 0,
				data : [
					{
						id : '00000001',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/stemp.png',
						type : 'url',
						url : '',
						title : '标题',
						desc : '副标题',
					}
				]
			}
		},
		{
			name : 'text',
			title : '富文本',
			type:2,
			params : {
				bgcolor : '#ffffff',
				margin : 0,
				padding : 5,
				content : '请输入'
			}
		},
		{
			name : 'space',
			title : '空白',
			type:2,
			params : {
				height : '10',
				bgcolor : '#f3f4f5'
			}
		},
		{
			name : 'titles',
			title : '标题',
			type:2,
			params : {
				content : '标题内容',
				right_content:'副标题',
				text_content:'更多',
				paddingv : '10',
				paddingh : '10',
				bgcolor : '#ffffff',
				color : '#333',
				right_color : '#ccc',
				text_color : '#ccc',
				size : 14,
				right_size : 14,
				text_size : 14,
				pos : 'left',
				lefticon : 0,
				leftimg : '',
				lwidth : 20,
				righticon : 0,
				rightimg : '',
				rwidth : 20,
				type : 'url',
				url : '',
			}
		},
		{
			name : 'newstitle',
			title : '新闻头',
			type:2,
			params : {
				padding : '10',
				size : 18,
				bgcolor : '#ffffff',
				color2 : '#999',
				color : '#333',
				content : '请修改标题',
				time : new Date().getFullYear() +'-'+ new Date().getMonth() +'-'+ new Date().getDate(),
				author : ''
			}
		},
		{
			name : 'video',
			title : '视频',
			type:2,
			params : {
				bgcolor : '#ffffff',
				padding : 5,
				url : '',
				type : 1,
				isauto : 0,
			}
		},
		{
			name : 'btn',
			title : '按钮',
			type:2,
			params : {
				mbg : '#ffffff',
				padding : 0,
				bgcolor : '#ed414a',
				color : '#ffffff',
				height : 40,
				width : 90,
				size  : 14,
				radius : 2,
				type : 'url',
				text : '按钮',
			}
		},
		{
			name : 'fix',
			title : '悬浮',
			type:2,
			params : {
				img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/thank.png',
				mbg : 'rgba(255, 255, 255, 0)',
				padding : 0,
				height : 40,
				width : 40,
				type : 'url',
				top : 65,
				right : 0,
			}
		},
//		{
//			name : 'article',
//			title : '文章列表',
//			params : {
//				title : '行业新闻',
//				botfont : '更多内容',
//				bgcolor : '#ffffff',
//				paddingv : 10,
//				paddings : 10,
//				topcolor : '#44b549',
//				topsize : 20,
//				botcolor : '#44b549',
//				botbord : '#44b549',
//				titlecolor : '#333333',
//				timecolor : '#8c8c8c',
//			}
//		},
		{
			name : 'graph',
			title : '三方图',
			type:2,
			params : {
				padding : 1,
				type : 1,
				istext : 0,
				fontsize : 14,
				fontcolor : '#333',
				bgcolor : '#fff',
				data : [
					{
						id : '00000001',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/11red.PNG',
						url : '',
						title : '',
						type : 'url',
					},
					{
						id : '00000002',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/21blue.PNG',
						url : '',
						title : '',
						type : 'url',
					},
					{
						id : '00000003',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/21blue.PNG',
						url : '',
						title : '',
						type : 'url',
					}
				]

			}
		},
		{
			name : 'webview',
			title : '网页容器',
			type:2,
			params : {
				url : '',
			}
		},
//		{
//			name:'phone',
//			title:'电话表单',
//			params:{
//				title : '最新优惠',
//				input_title : '输入号码,优惠详情发送至手机',
//				btn_text : '一键查询',
//				title_size : 14,
//				input_size : 12,
//				btn_size : 13,
//				title_color : '#000',
//				input_color : '#666',
//				btn_color : '#fff',
//				background:'#fff',
//				btn_backgornd : '#0c9',
//				url:'',
//			}
//		},
		{
			name : 'desigerss',
			title : '团队',
			type:1,
			params : {
				bgcolor : '#ffffff',//背景颜色
				framewidth:'33',//边框宽度
				framecolor:'#ccc',//边框颜色
				framefillet:'5',//边框圆角
				padding : 5,//边距
				istext : 0,//是否滑动
				istextauto:0,//自动获取
				size:'16',
				onsize:'12',
				code:1,
				data : [
					{
						id : '00000001',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/stemp.png',
						imgfillet:'50',
						type : 'url',
						url : '',
						title : '姓名1',
						titlecolor:'#000',
						titlesize:'15',
						desc : '简介1',
						desccolor:'#000',
						descsize:'13',
						btn:'查看作品',
						btncolor:'#fff',
						btnsize:'13',
						btnbg:'#00cc99',
						btnwidth:'90',
					},
					{
						id : '00000002',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/stemp.png',
						imgfillet:'50',
						type : 'url',
						url : '',
						title : '姓名2',
						titlecolor:'#000',
						titlesize:'15',
						desc : '简介2',
						desccolor:'#000',
						descsize:'13',
						btn:'查看作品',
						btncolor:'#fff',
						btnsize:'13',
						btnbg:'#00cc99',
						btnwidth:'90',
					},
					{
						id : '00000003',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/stemp.png',
						imgfillet:'50',
						type : 'url',
						url : '',
						title : '姓名3',
						titlecolor:'#000',
						titlesize:'15',
						desc : '简介3',
						desccolor:'#000',
						descsize:'13',
						btn:'查看作品',
						btncolor:'#fff',
						btnsize:'13',
						btnbg:'#00cc99',
						btnwidth:'90',
					}
				]
			}
		},
		{
			name : 'translate',
			title : '案例',
			type:1,
			params : {
				bgcolor : '#ffffff',//背景颜色
				framefillet:'5',//图片圆角
				padding : 5,//边距
				istext : 0,//是否滑动
				istextauto:0,//自动获取
				data : [
					{
						id : '00000001',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/o.png',
						type : 'url',
						url : '',
						title:'欧式风格',
						vice_title:'1200套',
						title_color:'#000',
					},
					{
						id : '00000002',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/z.png',
						type : 'url',
						url : '',
						title:'简约风格',
						vice_title:'1200套',
						title_color:'#000',
					},
					{
						id : '00000003',
						img : window.sysinfo.siteroot+'addons/sister_renovation/public/images/os.png',
						type : 'url',
						url : '',
						title:'中式风格',
						vice_title:'1200套',
						title_color:'#000',
					},
				],
				title:[
					{
						id:'10000000',
						title:'按风格',
						color:'#fff',
						title_size:'14',
						bag:'#00cc99',
						width:'50',
					},
					{
						id:'20000000',
						title:'按户型',
						color:'#000',
						title_size:'14',
						bag:'#fff',
						width:'50',
					}
				],
			}
		},
		{
			name : 'fans',
			title : '围观粉丝',
			type :2,
			params : {
				bgcolor : '#ffffff',//背景颜色
				padding : 5,//边距
				wods : '围观粉丝',
				btncolor : '#00cc99',//文字背景颜色
				btn_color:'#ffffff',
				btnrdeis:'5',
				img_redios:'#ffffff',
				size:'14',
				right_color:'#cccccc',
				num:10,//显示头像数量
				img:[
					{
						img:window.sysinfo.siteroot+'addons/sister_renovation/public/images/dd_n2.png',
					},
					{
						img:window.sysinfo.siteroot+'addons/sister_renovation/public/images/dd_n2.png',
					},
					{
						img:window.sysinfo.siteroot+'addons/sister_renovation/public/images/dd_n2.png',
					},
					{
						img:window.sysinfo.siteroot+'addons/sister_renovation/public/images/dd_n2.png',
					},
					{
						img:window.sysinfo.siteroot+'addons/sister_renovation/public/images/dd_n2.png',
					},
					{
						img:window.sysinfo.siteroot+'addons/sister_renovation/public/images/dd_n2.png',
					}
				],
				data : [
					{
						id : '00000001',
						name : '名称',
						type : 'url',
						url : '',
					}
				]
			}
		},
		{
			name : 'form',
			title : '表单',
			type :2,
			params : {
				bgcolor : '#ffffff',
				padding : 5,
				btnbg : '#ed414a',
				btncolor : '#fff',
				img:window.sysinfo.siteroot+'addons/sister_renovation/public/images/from.png',
			}
		},
	];

//	{
//			name : 'Jour',
//			title : '新闻',
//			params : {
//				ischange : 0,
//				changetime : 3,
//				changelast : 500,
//				pointcolor : '#dddddd',
//				actcolor : '#585656',
//				showpoint : 0,
//				data : [
//					{
//						id : '00000001',
//						img: window.sysinfo.siteroot+'/addons/sister_renovation/public/images/stemp.png',
//						type : 'url',
//					}
//					
//				]
//			}
//		},

	$scope.otherurl = [
		{title:'首页',url:'/pages/index/index'},
		{title:'表单页面',url:'/pages/order/order'},
		{title:'全景',url:'/pages/3D/3D'},
		{title:'装修计算器',url:'/pages/calculator/calculator'},
		{title:'0元设计',url:'/pages/zero/zero'},
		{title:'个人中心',url:'/pages/person/person'},
		{title:'意见反馈',url:'/pages/feedback/feedback'},
		{title:'我的收藏',url:'/pages/myCellect/myCellect'},
		{title:'我的预约',url:'/pages/myOrder/myOrder'},
	];


	$scope.params = page && page.params ? page.params : {}; // 初始数据
	
	if( page && page.params ){
	    angular.forEach($scope.params.data,function(m,i){
	       	if(m.name == 'text'){
	        	m.params.content = decodeURIComponent(m.params.content);
	        }
	    })
	}

	$scope.focus = {
		id : '00000000',
		name : 'basic'
	};
	
	$scope.article = article;
	$scope.allsort = allsort;
	$scope.op = op;

	$scope.items = page && page.params ? page.params.data : [];
	$scope.basic =  page && page.params ? page.params.basic : {
		id:'0000000',
		name : '',
		title : '',
		sharetitle : '',
		shareimg : '',
		isbar : 0,
		topbg : '#ffffff',
		topcolor : '#000000',
	};


	$scope.selectType = function(type){
		if(type == 1){
			$scope.params.arttype = 1;
		}else{
			$scope.params.arttype = 2;
			var newitem = $.extend(true,{},$scope.imgmodule);
			$scope.items.push(newitem);
			$scope.imgfocus = '00000001'; // 图片组默认焦点
		}
		$scope.params.isselect = 1;
	};

	$scope.imageType = function( tid,type ){

	    angular.forEach($scope.items, function(obj){
	        if(obj.id== tid){

	            var nowlength = obj.params.data.length;
	            var diff = type - nowlength;
	            obj.params.type = type;
	            if( diff > 0 ) {
	            	for (var i = 0; i < diff; i++) {
	            		var mid = 'm'+i+new Date().getTime();
						obj.params.data.push({
							id : mid,
							img : window.sysinfo.siteroot+'/addons/sister_renovation/public/images/stemp.png',
							type : 'url',
							url : '',
							title : '',
						})
	            	}
	            	
	            	console.log( $scope.items );
	            }else if( diff < 0 ){
	            	for (var i = -diff; i > 0; i--) {
	            		obj.params.data.splice(i,1);
	            	}
	            }
	            return false;
	        }
	    });
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
	$scope.saveData = function(){
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
		var items = angular.toJson(newarr);
		var basic = angular.toJson($scope.basic);
		$scope.issaving = true;
		//向后端发起请求
        $.ajax({
            type: 'POST',
            dataType : 'json',
            url: window.sysinfo.siteroot + '/web/index.php?c=site&a=entry&op=savepage&do=diy&m=sister_renovation',
            data: {data : JSON.parse(items),basic : JSON.parse(basic),tid : tempid,id : page && page.id ? page.id : 0 },
            success: function(data){
            	if(data.status == 1){
            		layer.msg(data.msg, {
					  icon: 1,
					  time: 2000 //2秒关闭（如果不配置，默认是3秒）
					}, function(){
					 location.href = "/web/index.php?c=site&a=entry&op=diy&do=diy&m=sister_renovation&id="+data.data;
					});
            	}else{
            		alert(data.msg);
            	}
            },
            error: function(){
                alert('保存失败请重试');
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
		$scope.getFocus('00000002');
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

	// 选择页面
	$scope.loadPageByid = function( id ){

		if( confirm('此功能是将以前设计的页面导入，可进行编辑添加页面，确定导入页面吗？') ) {
			location.href = window.sysinfo.siteroot + '/web/index.php?c=site&a=entry&op=add&do=page&m=sister_renovation'+'&tid='+tempid + '&lid='+id ;
		}

	};

	// 设置链接
	$scope.setlinkiid = 0;
	$scope.setlinkdid = 0;
	$scope.allpage = null;
	
	$scope.allstandard = null;//标准
	$scope.allsite = null;//工地
	$scope.allnews = null;//文章
	$scope.allcase = null;//案例
	$scope.alldesigner = null;//设计师
	
	$scope.alltempalte = null;//模板
	
	$scope.allapp = null;
	$scope.showhides = null;
	$scope.classify = null;
	
	$scope.urltype = '';
	//设置页面链接
	$scope.showLink = function(itemid,dataid,type){
		$scope.urltype = type;
		$scope.setlinkiid = itemid;
		if( dataid ) {
			$scope.setlinkdid = dataid;
		}else{
			$scope.setlinkdid = 0; // 来自第一级的设为0
		}
		layer.open({
		  type: 2,
		  title: '选择链接',
		  closeBtn: 1, //不显示关闭按钮
		  shade: [0.3, '#000'],
		  maxmin:true,
		  resize:false,
		  shadeClose: false,
		  area: ['800px', '600px'],
		  anim: 5,
		  content: [urls,'yes'],
		  end: function(){
		  	var index = layer.load(0, {shade: [0.3, '#000']});
		  	var name = $('#ifrname_name').val();
		  	var url = $('#ifrname_url').val();
		  	$('#ifrname_name').val('');
		    $('#ifrname_url').val('');
		    if(name != '' && url != ''){
		    	var keepGoing = true;
		    	angular.forEach($scope.items, function(m) {
//		    		console.log(m.id,m.name,$scope.setlinkiid)
			        if(m.id == $scope.setlinkiid && keepGoing){
			        	keepGoing = false;
//			        	if( $scope.setlinkdid ) {
			        		console.log(m.name)
			        		if(m.name == 'headlines'){
			        			//装修头条另外算
			        			angular.forEach(m.params.datas, function(n) {
							        if(n.id == $scope.setlinkdid){
							            n.url = url;
							            n.urlname = name;
							            return false;
							        }
							    });
			        		}else if(m.name == 'titles'){
			        			m.params.urlname = name;
			        			m.params.url = url;
//			        			console.log(m.params)
			        		}else{
			        			var lo = true;
			        			angular.forEach(m.params.data, function(n) {
							        if(n.id == $scope.setlinkdid && lo){
							        	lo = false;
							            n.url = url;
							            n.urlname = name;
							        }
							    });
			        		}
//			        	}
			        }
			    });
		    }
		    layer.closeAll();
		  },
			success:function(layero, index){
//				var body = layer.getChildFrame('body', index);
//			    var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
			}
		});

//		if( !$scope.allpage && type == 'my' ) {
//			Http('post','json','getlink',{tid : tempid},function(data){
//				console.log(data);
//				if(data.data.standard.length > 0){
//					$scope.allstandard = data.data.standard;
//				}
//				if(data.data.site.length > 0){
//					$scope.allsite = data.data.site;
//				}
//				if(data.data.news.length > 0){
//					$scope.allnews = data.data.news;
//				}
//				if(data.data.case.length > 0){
//					$scope.allcase = data.data.case;
//				}
//				if(data.data.designer.length > 0){
//					$scope.alldesigner = data.data.designer;
//				}
//				$scope.$apply();
//			},true);
//		}
//		$('.my_model_url').show();
	};
	//选择文章分类(装修头条)
	$scope.article = function(itemid,dataid){
//		$('.my_model_article').show();
		angular.forEach($scope.params.data,function(m,i){
	       	if(m.id == itemid){
	        	m.params.automatic = 2;
	        }
	    })
		$scope.setlinkiid = itemid;
//		Http('post','json','getclass',{},function(data){
//			$scope.showhides = data.data;
//			$scope.urltype = '';
//			$scope.$apply();
//		},true)
//		$('.my_model_article').show();
//		$('#draggables').show();
//		if($('#draggable').css('display') == 'none'){
//			$('#draggable').show();
//		}
console.log($scope.setlinkiid);
		layer.open({
		  type: 2,
		  title: '选择链接',
		  closeBtn: 1, //不显示关闭按钮
		  shade: [0.3, '#000'],
		  maxmin:true,
		  resize:false,
		  shadeClose: false,
		  area: ['800px', '600px'],
		  anim: 5,
		  content: [url_list,'yes'],
		  end: function(){
		  	var index = layer.load(0, {shade: [0.3, '#000']});
		  	var name = $('#ifrname_name').val();
		  	var url = $('#ifrname_url').val();
		  	$('#ifrname_name').val('');
		    $('#ifrname_url').val('');
		    if(name != '' && url != ''){
		    	angular.forEach($scope.items, function(m) {
		    		console.log(m.id,$scope.setlinkiid);
			        if(m.id == $scope.setlinkiid){
			        	console.log(m.name)
		        		if(m.name == 'headlines'){
		        			//装修头条另外算
		        			 m.params.ids = url;
		        			 m.params.automatic = 2;
		        		}else{
		        			var lo = true;
		        			angular.forEach(m.params.data, function(n) {
						        if(n.id == $scope.setlinkdid && lo){
						        	lo = false;
						            n.url = url;
						            n.urlname = name;
						        }
						    });
		        		}
			        }
			    });
		    }else{
		    	angular.forEach($scope.items, function(m) {
		    		if(m.id == $scope.setlinkiid){
		    			m.params.automatic = 1;
		    		}
		    	})
		    }
		    layer.closeAll();
		  },
			success:function(layero, index){
//				var body = layer.getChildFrame('body', index);
//			    var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
			}
		});	


	}
	//隐藏弹窗
	$scope.cancel_hides = function(id,m_id){
		angular.forEach($scope.params.data,function(m,i){
	       	if(m.id == $scope.setlinkiid){
	        	m.params.automatic = 1;
	        }
	    })
		$('.my_model_article').hide();
	}
	//选择分类
	$scope.article_setLink = function(id,name){
		var ids = id.split(',');
		if(ids[2] == 1){
			//代表没有分类了
			angular.forEach($scope.params.data,function(m,i){
		       	if(m.id == $scope.setlinkiid){
		       		m.params.ids = id;
		       		m.params.names = name;
		       	}
		    })
			$('.my_model_article').hide();
		}else{
			//有分类
			Http('post','json','get_info_class',{classify:ids[3]},function(data){
				$scope.classify = data.data;
				$scope.urltype = 'lists';
				console.log('111')
				$scope.$apply();
			},true)
		}
		
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
	//模板取消
	$scope.setmodel = function(){
		$('.my_model_url').hide();
	}
    $scope.ismap = false;
    $scope.lng = 0;
    $scope.lat = 0;
    $scope.mapaid = -1;
    $scope.mapdid = -1;

    $scope.showMap = function(aid,did){
        $scope.mapaid = aid;
        $scope.mapdid = did;

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
        $('.ui-draggable').show();
    }

    $scope.setLocation = function(){
        if( $scope.lng <= 0 || $scope.lat <= 0 || $scope.mapindex < 0 ) {
            webAlert('请先点击选择坐标');return false;
        }
        
        angular.forEach($scope.items, function(m){
        	if( m.id == $scope.mapaid ) {
        		
        		if( $scope.mapdid > 0 ) {
		            angular.forEach(m.params.data, function(n){
		                if(n.id== $scope.mapdid){
        					n.lng = $scope.lng;
        					n.lat = $scope.lat;
		                }
		            });
        		}else{
        		console.log( m,$scope.lng,$scope.lat );	
        			m.params.lng = $scope.lng;
        			m.params.lat = $scope.lat;
        		}
        	}
        });
        $scope.mapaid = -1;
        $scope.mapdid = -1;
        $('.my_model[map]').hide();
        $('.ui-draggable').hide();
    };
    $scope.draggable = function(){
    	$('.my_model[map]').hide();
        $('.ui-draggable').hide();
        
    };
	// 上传图片
    $scope.uploadImage = function(id,type){
        require(['jquery', 'util'], function($, util){
            util.image('',function(data){
            	if(type == 'shareimg'){
            		$scope.basic.shareimg = data['url'];
            	}else if(type == 'goodimg'){
            		id.img = data['url'];
            	}else if(type == 'actimg'){
            		id.actimg = data['url'];
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
    }


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
   /**
    * 自动获取后台数据
    * 新闻
    */
	$scope.automatic = function(good){
		good.istext = 1;
		console.log(good)
		if(good.istext == 1){
			/**自动获取后台的新闻信息*/
			var url = "./index.php?c=site&a=entry&op=addart&do=article&m=sister_renovation";
			var good_info = [];
			$.post(url,{id:1},function(res){
				var info = [];
				if(res.data != ''){
					var data = res.data;
					$.each(data,function(i,j){
						var id = 'g'+new Date().getTime();
						info['id'] = id;
						info['img'] = j.img;
						info['title'] = j.title;
						info['type'] = 'url';
						info['url'] = j.id;
						info['desc'] = j.body;
						good_info.push($.extend(true,{},info));
					});
				}
				if(good_info != ''){
					//添加到good里面
					good.data = good_info;
				}else{
					alert('后台还没有添加数据哦');
				}
			},"JSON")
			console.log()
		}
		
	}
   /**
    * 自动获取后台数据
    * 案例
    */
	$scope.sautomatic = function(good){
		good.istext = 1;
		console.log(good)
		if(good.istext == 1){
			/**自动获取后台的案例信息*/
			var url = "./index.php?c=site&a=entry&op=tag&do=api&m=sister_renovation";
			var good_info = [];
			$.post(url,{id:1},function(res){
				var info = [];
				if(res.data != ''){
					var data = res.data;
					$.each(data,function(i,j){
						var id = 'g'+new Date().getTime();
						info['id'] = id;
						info['img'] = j.img;
						info['title'] = j.title;
						info['type'] = 'url';
						info['url'] = j.id;
						info['vice_title'] = j.number+'套';
						info['title_color'] = '#000';
						good_info.push($.extend(true,{},info));
					});
				}
				if(good_info != ''){
					//添加到good里面
					good.data = good_info;
				}else{
					alert('后台还没有添加数据哦');
				}
			},"JSON")
		}
	}
   /**
    * 自动获取后台数据
    * 设计师
    */
	$scope.textautomatic = function(id,good){
		good.istextauto = 1;
		console.log(good.code)
		if(good.istextauto == 1){
			/**自动获取后台的设计师信息*/
			var url = "./index.php?c=site&a=entry&op=desuger&do=api&m=sister_renovation";
			var good_info = [];
			$.post(url,{id:1,code:good.code},function(res){
				var info = [];
				if(res.data != ''){
					var data = res.data;
					$.each(data,function(i,j){
						var id = 'g'+new Date().getTime();
						info['id'] = id;
						info['img'] = j.img;
						info['imgfillet'] = '50';
						info['title'] = j.name;
						info['desc'] = j.title_name;
						info['btn'] = '查看作品';
						info['titlecolor'] = '#000';
						info['titlesize'] = '15';
						info['desccolor'] = '#000';
						info['descsize'] = '13';
						info['btncolor'] = '#fff';
						info['btnsize'] = '13';
						info['btnbg'] = '#00cc99';
						info['btnwidth'] = '90';
						info['type'] = 'url';
						info['url'] = '../designer/designer?id='+j.id;
						info['urlname'] = j.name;
						good_info.push($.extend(true,{},info));
					});
				}else{
					alert('暂未添加设计师');
					return false;
				}
				if(good_info != ''){
					//添加到good里面
					good.data = good_info;
				}else{
					alert('后台还没有添加数据哦');
				}
			},"JSON")
		}
	}


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
   		if(confirm('确定要删除吗？')){
   			angular.forEach(data,function(m,i){
   				if(m.id == id){
   					arr.splice(i,1);
   					$scope.focus.id = '';
   				}
   			})
			$scope.items = arr;
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
//.directive('addModule',function($timeout){
//	return {
//		restrict : 'A',
//		link : function(scope,elem,attr){
//			console.log(elem,attr);
//			$(elem).on('click',function(){
//				if( (scope.items.length > 0 && attr.name == 'webview') || ( scope.items[0] && scope.items[0].name == 'webview') ){
//					webAlert('网页容器只能有一个，而且不能与其他元素同时存在');return false;
//				}
//				angular.forEach(scope.modules,function(m){
//					if(m.name == attr.name){
//						var mid = 'm'+new Date().getTime();
//						var tempobj = $.extend(true,{},m);
//						
//						var newitem = {id:mid,name:tempobj.name,params:tempobj.params};
//						var index = -1;
//						angular.forEach(scope.items,function(m,i){
//							if(m.id == scope.focus.id){
//								index = i;
//								return false;
//							}
//						});
//						scope.items.splice(index+1,0,newitem);
//						scope.$apply();
//						$('div[viewid='+mid+']').trigger('click');
//						return false;
//					}
//				})
//			})
//		}
//	}
//})
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
});
