<?php defined('IN_IA') or exit('Access Denied');?></div>
<div class="clearfix"></div>
<div class="container-fluid footer text-center" role="footer">	
	<div class="friend-link">
		<?php  if(empty($_W['setting']['copyright']['footerright'])) { ?>
			<a href="http://www.w7.cc">微信开发</a>
			<a href="http://s.w7.cc">微信应用</a>
			<a href="http://bbs.w7.cc">微擎论坛</a>
			<a href="http://s.w7.cc">小程序开发</a>
		<?php  } else { ?>
			<?php  echo $_W['setting']['copyright']['footerright'];?>
		<?php  } ?>
	</div>
	<div class="copyright"><?php  if(empty($_W['setting']['copyright']['footerleft'])) { ?>Powered by <a href="http://www.w7.cc"><b>微擎</b></a> v<?php echo IMS_VERSION;?> &copy; 2014-2018 <a href="http://www.w7.cc">www.w7.cc</a><?php  } else { ?><?php  echo $_W['setting']['copyright']['footerleft'];?><?php  } ?></div>
	
	<div>
		<?php  if(!empty($_W['setting']['copyright']['icp'])) { ?>
		备案号：<a href="http://beian.miit.gov.cn/" target="_blank"><?php  echo $_W['setting']['copyright']['icp'];?></a>
		<?php  } ?>
		<?php  if(!empty($_W['setting']['copyright']['policeicp']['policeicp_location']) && !empty($_W['setting']['copyright']['policeicp']['policeicp_code'])) { ?>
			<a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php  echo $_W['setting']['copyright']['policeicp']['policeicp_code']?>">
                &nbsp;&nbsp;<img src="./resource/images/icon-police.png" >
				<?php  echo $_W['setting']['copyright']['policeicp']['policeicp_location']?> <?php  echo $_W['setting']['copyright']['policeicp']['policeicp_code']?>号
			</a>
		<?php  } ?>
	</div>
</div>
</div>

</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer-base', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-base', TEMPLATE_INCLUDEPATH));?>

</body>
</html>