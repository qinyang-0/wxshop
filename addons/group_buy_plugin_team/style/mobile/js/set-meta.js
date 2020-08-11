/* 获得系统、分辨率等手机参数，设置meta */
var isAppCan= false;    //是否为appCan应用
var appVersion = window.navigator.appVersion;   //客户端信息
var isSystem=appVersion.indexOf("Android")>-1 || appVersion.indexOf("android")>-1?"android":false;
if(isSystem!="android") {
	isSystem=appVersion.indexOf("iPhone")>-1 || appVersion.indexOf("iPod")>-1?"iphone":false;
}
//isSystem='iphone';//在PC上模拟iphone测试的开关
var windowWidth=window.screen.width;    //屏幕分辨率
// var devicePixelRatio = window.devicePixelRatio; //屏幕分辨率与像素比
// var targetDensitydpi = 750 / windowWidth * devicePixelRatio * 160;
var sacleNum=windowWidth/750;
if (sacleNum>1) {
	document.writeln('<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1, maximum-scale=1,user-scalable=no" />');
} else {
	document.writeln('<meta name="viewport" content="width=device-width,initial-scale='+sacleNum +',minimum-scale='+sacleNum +', maximum-scale='+ sacleNum+',user-scalable=no" />');
}

switch (isSystem){
	case "android":
		// document.writeln('<meta name="viewport" content="width=device-width,target-densitydpi='+targetDensitydpi+',user-scalable=no">');
		break;
	case "iphone":
		// document.writeln('<link href="css/base-for-iphone.css" rel="stylesheet" type="text/css">');
		// document.writeln('<meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.5, maximum-scale=0.5,user-scalable=no" />');
		// document.writeln('<meta name="viewport" content="width=device-width,target-densitydpi='+targetDensitydpi+',user-scalable=no">');
		break;
	default :
}

// document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);