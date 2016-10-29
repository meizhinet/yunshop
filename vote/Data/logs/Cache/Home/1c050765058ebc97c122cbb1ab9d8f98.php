<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>微信数字投票管理系统</title>
	<meta name="keywords" content="hailaizi.com,微信投票系统,hailaizi.com" />
	<meta name="description" content="（www.hailaizi.com），简称海癞子微信投票管理系统，海癞子微信投票管理系统是一款落地式的微信公众平台管理系统，是国内最完善的移动网站及移动互联网技术解决方案。" />
	<link href="<?php echo STATICS;?>/home/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo STATICS;?>/home/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo STATICS;?>/home/css/common.css" rel="stylesheet">
	<script type="text/javascript">
	if(navigator.appName == 'Microsoft Internet Explorer'){
		if(navigator.userAgent.indexOf("MSIE 5.0")>0 || navigator.userAgent.indexOf("MSIE 6.0")>0 || navigator.userAgent.indexOf("MSIE 7.0")>0) {
			alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
		}
	}
	</script>
</head>
<body><style>
	@media screen and (max-width:767px){.login .panel.panel-default{width:90%; min-width:300px;}}
	@media screen and (min-width:768px){.login .panel.panel-default{width:70%;}}
	@media screen and (min-width:1200px){.login .panel.panel-default{width:50%;}}
</style>
<div class="login" style="background:#2ca3e9">
	<div class="logo">
		<a href="/" ></a>
	</div>
	<div class="clearfix" style="margin-bottom:4em;">
		<div class="panel panel-default container">
			<div class="panel-body">
				<form action="<?php echo U('Users/checklogin');?>" method="post" enctype="multipart/form-data" >
					<div class="form-group input-group">
						<div class="input-group-addon"><i class="fa fa-user"></i></div>
						<input name="username" type="text" class="form-control input-lg" placeholder="请输入用户名登录">
					</div>
					<div class="form-group input-group">
						<div class="input-group-addon"><i class="fa fa-unlock-alt"></i></div>
						<input name="password" type="password" class="form-control input-lg" placeholder="请输入登录密码">
					</div>
					<div class="form-group">
						<div class="pull-right">
						<input type="submit" name="submit" value="登录" class="btn btn-primary btn-lg" />
							<input name="token" value="4405cdbd" type="hidden" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="center-block footer" role="footer">
		<div class="text-center">
			<a href="http://www.hailaizi.com">微信数字投票【萌娃、摄影、微男/女神评选】</a> &nbsp;&nbsp;<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1196545447&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:1196545447:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a></p>
            </div>
		<div class="text-center">
			powered by hailaizi.com		</div>
	</div>
</div>
</body>
</html>