//function sync(syncIframe) {
//		$.ajax({
//			 type: "get",
//			 url: frontPath + "/exchangecenter/heartbeart/getSyncUrl.jhtml",
//			 dataType:'json',
//			 success: function(data){
//				 if(data.syncUrl){
//					 syncIframe.src = data.syncUrl;
//				 }
//			 }
//		});
//}
//
//$().ready(function() {
//	var syncIframe = document.getElementById("syncIframe");
//	sync(syncIframe);
//	
//	//setInterval(function(){sync(syncIframe);}, parseInt(150000));
//	
//});
