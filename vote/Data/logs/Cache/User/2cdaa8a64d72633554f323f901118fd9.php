<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>网站更新</title>
<link href="<?php echo STATICS;?>/simpleboot/themes/flat/theme.min.css" rel="stylesheet">
  <script src="<?php echo STATICS;?>/vote/wap/js/jquery.js"></script>
 <style>
 .upnow{
 margin-top:50px;
 padding:15px;
 text-align:center;
 }
.center{
margin:0 auto;
}
.upinfo{
 padding:15px;
}
.upinfo .infotitle{
height:30px;
margin:10px;
font-size:20px;
color:rgba(100,100,100,0.5);
text-align:center;
}
.upinfo .infocontent{
font-size:14px;
width:100%;
margin:0 auto;
}
 </style>
</head>
<body>
	<script type="text/javascript">
	function sync(obj, a, b, c, d, e)
	{
		$.post("index.php?g=User&m=Vote&a=sharesync&token=<?php echo ($token); ?>&wecha_id=<?php echo ($wecha_id); ?>", {url: "<?php echo ($url); ?>", name:a, type:b, perms:c, md5:d, active: e}, function(text){
			if (text != "") {
				alert(text);
			}
			else {
				obj.val("同步成功").parent().parent().hide('slow');
			}
		});
	}
	function syncall(a) {
		$(a).each(function(){
			$(this).click();
		});
	}
	</script>
	<table style="display:"><tr><td>文件名</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
	<?php if(is_array($needdata)): $i = 0; $__LIST__ = $needdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$needdata): $mod = ($i % 2 );++$i;?><tr>
	<td><?php echo ($needdata['name']); ?></td><td></td><td></td><td></td><td></td>
	<td><input class="r2l" type="button" onclick="sync($(this), '<?php echo ($needdata['name']); ?>', '<?php echo ($needdata['type']); ?>', '<?php echo ($needdata['perms']); ?>','<?php echo ($needdata['md5']); ?>', 'r2l');" value="同步到本地"></td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	<div class='upinfo'>
		<div class='infotitle'>更新内容</div>
		<div class='infocontent'><?php echo ($upinfo); ?></div>
	</div>
	<div class='upnow'><input type="button" class="center btn btn-primary btn_submit  J_ajax_submit_btn" onclick="syncall('.r2l')" value="下载更新"></div>
	<script>
		$("input").attr("disabled", false);
	</script>
</body></html>
<div style="display:none">
<link href="tpl/static/simpleboot/themes/flat/theme.min.css" rel="stylesheet">
</div>