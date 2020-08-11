<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="./resource/css/login.css" />
<div class="container right-panel-active" id="container">
	<div class="form-container sign-in-container">
		<form action="" role="form" id="form1" onsubmit="return formcheck();" method="post">
			<h1 class="login_text">登录</h1>
			<input name="username" type="text" class="form-control " placeholder="请输入用户名登录">
			<input name="password" id="password" type="password" class="form-control password" placeholder="请输入登录密码">
			<input name="token" value="<?php  echo $_W['token'];?>" type="hidden" />
			<input name="login_type" type="hidden" class="form-control " value="system">
			<input name="referer" type="hidden" value="<?php  echo $_GPC['referer'];?>">
			<input type="submit" id="submit" name="submit" value="登录" class="  btn-block button" />
			<!--<button>登录</button>-->
		</form>
		<p class="banquan">版权声明：版权由<?php  if(empty($_W['setting']['copyright']['footerleft'])) { ?><a href="http://www.scmmwl.com" target="_blank" style="font-size: 12px;color: #999;">四川麦芒网络科技公司</a><?php  } else { ?><?php  echo $_W['setting']['copyright']['footerleft'];?><?php  } ?>所有</p>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>欢迎回来！</h1>
				<p>请您先登录您的个人信息，进行操作。</p>
			</div>
		</div>
		<img src="../attachment/cart_bg.png" alt="" class="cart_bg_img"/>
	</div>
</div>
<script>
	function detectCapsLock(event) {
		var e = event || window.event;
		var o = e.target || e.srcElement;
		var oTip = o.nextElementSibling;
		var keyCode = e.keyCode || e.switch;
		var isShift = e.shiftKey || (keyCode == 16) || false;
		if (((keyCode >= 65 && keyCode <= 90) && !isShift) || ((keyCode >= 97 && keyCode <= 122) && isShift)) {
			oTip.style.display = '';
		} else {
			oTip.style.display = 'none';
		}
	}
	document.getElementById('password').onkeypress = detectCapsLock;

	function formcheck() {
		if($('#remember:checked').length == 1) {
			cookie.set('remember-username', $(':text[name="username"]').val());
		} else {
			cookie.del('remember-username');
		}
		return true;
	}
	var h = document.documentElement.clientHeight;
	if($('.footer').length) {
		h = h - $('.footer').outerHeight();
	}
	$(".system-login").css('height',h);
	$('#toggle').click(function() {
		$('#imgverify').prop('src', '<?php  echo url('utility/code')?>r='+Math.round(new Date().getTime()));
		return false;
	});
	<?php  if(!empty($_W['setting']['copyright']['verifycode'])) { ?>
		$('#form1').submit(function() {
			var verify = $(':text[name="verify"]').val();
			if (verify == '') {
				alert('请填写验证码');
				return false;
			}
		});
	<?php  } ?>
</script>
