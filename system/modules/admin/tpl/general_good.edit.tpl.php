<?php defined('G_IN_ADMIN')or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css" type="text/css">
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_PLUGIN_PATH; ?>/uploadify/api-uploadify.js" type="text/javascript"></script> 
<link rel="stylesheet" href="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar-blue.css" type="text/css"> 
<script type="text/javascript" charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar.js"></script>
 <script type="text/javascript" src="<?php echo G_PLUGIN_PATH; ?>/kindeditor/kindeditor.js"></script>
	    <!-- 编辑器源码文件 -->
	    <script type="text/javascript" src="<?php echo G_PLUGIN_PATH; ?>/kindeditor/lang/zh_CN.js"></script>
<!--
<script type="text/javascript">
var editurl=Array();
editurl['editurl']='<?php echo G_PLUGIN_PATH; ?>/ueditor/';
editurl['imageupurl']='<?php echo G_ADMIN_PATH; ?>/ueditor/upimage/';
editurl['imageManager']='<?php echo G_ADMIN_PATH; ?>/ueditor/imagemanager';
</script>
<script type="text/javascript" charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/ueditor/ueditor.all.min.js"></script>-->
<style>
	.bg{background:#fff url(<?php echo G_GLOBAL_STYLE; ?>/global/image/ruler.gif) repeat-x scroll 0 9px }
	.color_window_td a{ float:left; margin:0px 10px;}
</style>
</head>
<body>
<script>
$(document).ready(function(){

	var catid = "<?php echo $shopinfo['cateid']; ?>";
	var pro = "<?php echo $shopinfo['property']; ?>";
	var pro = pro.split(",");

	$.ajax({
		type : "get",
		url:"<?php echo WEB_PATH; ?>/admin/content/get_category_info/"+catid,
		dataType : "JSON",
		async:false,
		success:function(data){
			if(data.length && data.length > 0){
				var html = '';
				for(var a=0; a<data.length; a++){
					html += '<tr ><td align="right" style="width:120px">'+data[a]+'：</td><td><input type="text"  name="property[]" value="'+pro[a]+'" style="width:200px;" class="input-text"><span class="lr10">多个值请用 | 号分割开</span></td></tr>';
				}
				$('#property').html(html);
			}
		}
	});
});
$(function(){
	$("#category").change(function(){
		var parentId=$("#category").val(); 
		if(null!= parentId && ""!=parentId){
			$.getJSON("<?php echo WEB_PATH; ?>/api/brand/json_brand/"+parentId,{cid:parentId},function(myJSON){
				var options="";
				if(myJSON.length>0){ 			
					//options+='<option value="0">≡ 请选择品牌 ≡</option>'; 
					for(var i=0;i<myJSON.length;i++){ 
						options+="<option value="+myJSON[i].id+">"+myJSON[i].name+"</option>"; 
					} 
					$("#brand").html(options);
				} 
			});
			$.ajax({
				type : "get",
				url : '<?php echo WEB_PATH; ?>/admin/content/get_category_info/'+parentId,
				dataType : "JSON",
				async:false,
				success:function(data){
					var html = '';
					if(data.length && data.length > 0){
						for(var a=0; a<data.length; a++){
							html += '<tr ><td align="right" style="width:120px">'+data[a]+'：</td><td><input type="text"  name="property[]" style="width:200px; padding-left:0px;" class="input-text"><span class="lr10">多个值请用 | 号分割开</span></td></tr>';
						}
					}
					$('#property').html(html);
				}
			});			
		}
	});
	
});

</script>
<div class="header lr10">
	<?php echo $this->headerment();?>
    
</div>
<div class="bk10"></div>
<div class="table_form lr10">
<form method="post" action="">
	<table width="100%"  cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td align="right" style="width:120px"><font color="red">*</font>所属分类：</td>
				<td>
				 <select name="cateid" id="category" class="wid100">               
					<?php echo $categoryshtml; ?>                
				 </select> 
				</td>
			</tr>
			<tr>
				<td align="right" style="width:120px"><font color="red">*</font>所属品牌：</td>
				<td>
					<select id="brand" name="brand" class="wid100">                	
						<option value="<?php echo $shopinfo['brandid']; ?>"><?php echo $BrandList[$shopinfo['brandid']]['name']; ?></option>                    
						<?php foreach($BrandList as $brand): ?>		
						<option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>        
			<tr>
				<td align="right" style="width:120px"><font color="red">*</font>商品标题：</td>
				<td>
					<input  type="text" id="title" value="<?php echo $shopinfo['title']; ?>" name="title" onKeyUp="return gbcount(this,100,'texttitle');"  class="input-text wid400 bg" />
					<span style="margin-left:10px">还能输入<b id="texttitle">100</b>个字符</span>
				</td>
			</tr>
			<tr>
				<td align="right" style="width:120px">副标题：</td>
				<td>
					<input  type="text" value="<?php echo $shopinfo['title2']; ?>" style="<?php echo $shopinfo['title_style']; ?>" name="title2" id="title2" onKeyUp="return gbcount(this,100,'texttitle2');"  class="input-text wid400" />
					<input type="hidden"  value="<?php echo $title_color; ?>"   name="title_style_color" id="title_style_color" />
					<input type="hidden" value="<?php echo $title_bold; ?>"  name="title_style_bold" id="title_style_bold"/>
					<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/colorpicker.js"></script>
					<img src="<?php echo G_GLOBAL_STYLE; ?>/global/image/colour.png" width="15" height="16" onClick="colorpicker('title_colorpanel','set_title_color');" style="cursor:hand"/>
					<img src="<?php echo G_GLOBAL_STYLE; ?>/global/image/bold.png" onClick="set_title_bold();" style="cursor:hand"/>
					<span class="lr10">还能输入<b id="texttitle2">100</b>个字符</span>
				</td>
			</tr>
			<tr>
				<td align="right" style="width:120px"><font color="red">*</font>商品总价格：</td>
				<td><input type="text" id="money"  name="money" style="width:80px; padding-left:0px; text-align:center" class="input-text" value="<?php echo $shopinfo['money'];?>">元</td>
			</tr>
			<tr >
				<td align="right" style="width:120px"><font color="red">*</font>库存：</td>
				<td><input type="text"  name="inventory" style="width:80px; padding-left:0px; text-align:center" class="input-text" value="<?php echo $shopinfo['inventory'];?>"></td>
			</tr>
		</tbody>
		<tbody id="property">
		
		</tbody>
		<tbody>
			<tr>
				<td align="right" style="width:120px">关键字：</td>
				<td><input type="text" value="<?php echo $shopinfo['keywords']; ?>" name="keywords"  name="title"  class="input-text wid300" />
				<span class="lr10">多个关键字请用   ,  号分割开</span>
				</td>
			</tr>
			<tr>
				<td align="right" style="width:120px">商品描述：</td>
				<td><textarea name="description" class="wid400"  onKeyUp="gbcount(this,250,'textdescription');" style="height:60px"><?php echo $shopinfo['description']; ?></textarea><br /> <span>还能输入<b id="textdescription">250</b>个字符</span>
				</td>
			</tr>	
			<tr>
				<td align="right" style="width:120px"><font color="red">*</font>缩略图：</td>
				<td>
					<img src="<?php echo G_UPLOAD_PATH.'/'.$shopinfo['thumb']; ?>" style="border:1px solid #eee; padding:1px; width:50px; height:50px;" />
					<input type="text" id="imagetext" value="<?php echo $shopinfo['thumb']; ?>" name="thumb" class="input-text wid300" />
					<input type="button" class="button" onClick="GetUploadify('<?php echo WEB_PATH; ?>','uploadify','缩略图上传','image','shopimg',1,500000,'imagetext')" value="上传图片" />
				</td>
			</tr>
			<tr>
				<td align="right" style="width:120px">展示图片：</td>            
				<td>
					<fieldset class="uploadpicarr">
						<legend>列表</legend>
						<div class="picarr-title">最多可以上传<strong>10</strong> 张图片 <a onClick="GetUploadify('<?php echo WEB_PATH; ?>','uploadify','缩略图上传','image','shopimg',10,500000,'uppicarr')" style="color:#ff0000; padding:10px;">  <input type="button" class="button" value="开始上传" /></a>
						</div>
						<ul id="uppicarr" class="upload-img-list">
						<?php $picarr = unserialize($shopinfo['picarr']); ?>
						<?php foreach($picarr as $pic): ?>                       
							<li rel="<?php echo $pic; ?>">
								<input class="input-text" type="text" name="uppicarr[]" value="<?php echo $pic; ?>" />
								<a href="javascript:void(0);" onClick="ClearPicArr('<?php echo $pic; ?>','<?php echo WEB_PATH; ?>')">删除</a>
							</li>
						<?php endforeach; ?>  
						</ul>
					</fieldset>
				</td>           
			</tr>  
			<tr>
				<td height="300" style="width:120px"   align="right"><font color="red">*</font>商品内容详情：</td>
				<td>
					<style>
					.content_attr {
						border: 1px solid #CCC;
						padding: 5px 8px;
						background: #FFC;
						margin-top: 6px;
						width:915px; 
					}
					.content{
						width: 915px;
						height:300px;

					}
					</style>
					<textarea name="content" class='content' id="myeditor" type="text/plain">
					<?php echo $shopinfo['content']; ?>
					</textarea>
					<div class="content_attr">
					<label><input name="sub_text_des" type="checkbox"  value="off" checked>是否截取内容</label>
					<input type="text" name="sub_text_len" class="input-text" value="250" size="3">字符至内容摘要<label>         
					</div>
					
				</td>        
			</tr>         
		   <tr>
				<td align="right" style="width:120px">商品属性：</td>
				<td width="900">
					<input name="goods_key[pos]" value="1" type="checkbox" <?php if($shopinfo['pos']){echo "checked";} ?>/>&nbsp;推荐&nbsp;&nbsp;
					<input name="goods_key[renqi]" value="1" type="checkbox" <?php if($shopinfo['renqi']){echo "checked";} ?>/>&nbsp;人气&nbsp;&nbsp; 
					<input name="goods_key[bannershop]" value="1" type="checkbox" <?php if($shopinfo['bannershop']){echo "checked";} ?> />&nbsp;幻灯下推荐位商品&nbsp;&nbsp; 
				</td>          
			</tr>
			<tr>
				<td align="right" style="width:120px">广告位置：</td>
				<td width="900">
					<input name="goods_key[renqipos]" value="1" type="checkbox" <?php if($shopinfo['renqipos']){echo "checked";} ?> />&nbsp;热门推荐广告&nbsp;&nbsp; 
					<input name="goods_key[newpos]" value="1" type="checkbox" <?php if($shopinfo['newpos']){echo "checked";} ?> />&nbsp;新品上架广告&nbsp;&nbsp; 
					<img src="<?php echo G_UPLOAD_PATH; ?>/photo/goods.jpg" style="border:1px solid #eee; padding:1px; width:50px; height:50px;">
					<input type="text" id="posimagetext" name="posthumb" value="<?php echo $shopinfo['posthumb']; ?>" class="input-text wid300">
					<input type="button" class="button" onClick="GetUploadify('<?php echo WEB_PATH; ?>','uploadify','缩略图上传','image','shopimg',1,500000,'posimagetext')" value="上传图片"/>
				</td>          
			</tr>
			<tr height="60px">
				<td align="right" style="width:120px"></td>
				<td><input type="submit" name="dosubmit" class="button" value="修改商品" /></td>
			</tr>
		</tbody>
	</table>
</form>
</div>
 <span id="title_colorpanel" style="position:absolute; left:568px; top:155px" class="colorpanel"></span>
<script type="text/javascript">
    //实例化编辑器
     KindEditor.ready(function(K) {
		window.editor = K.create('#myeditor');
	});
	 
	var info=new Array();
    function gbcount(message,maxlen,id){
		
		if(!info[id]){
			info[id]=document.getElementById(id);
		}			
        var lenE = message.value.length;
        var lenC = 0;
        var enter = message.value.match(/\r/g);
        var CJK = message.value.match(/[^\x00-\xff]/g);//计算中文
        if (CJK != null) lenC += CJK.length;
        if (enter != null) lenC -= enter.length;		
		var lenZ=lenE+lenC;		
		if(lenZ > maxlen){
			info[id].innerHTML=''+0+'';
			return false;
		}
		info[id].innerHTML=''+(maxlen-lenZ)+'';
    }
	
function set_title_color(color) {
	$('#title2').css('color',color);
	$('#title_style_color').val(color);
}
function set_title_bold(){
	if($('#title_style_bold').val()=='bold'){
		$('#title_style_bold').val('');	
		$('#title2').css('font-weight','');
	}else{
		$('#title2').css('font-weight','bold');
		$('#title_style_bold').val('bold');
	}
}

//API JS
//window.parent.api_off_on_open('open');
</script>
</body>
</html> 