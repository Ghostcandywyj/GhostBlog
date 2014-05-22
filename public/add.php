<?php 
	$q = $_GET['q'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title>GhostBlog</title>
	
	<link rel="icon" href="./img/GhostBlog.ico" type="image/x-icon" /> 
	<link rel="shortcut icon" href="./img/GhostBlog.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="./plugin/markdown.css" />
	
	<script type="text/javascript" src="./plugin/showdown.js"></script>
	<script type="text/javascript" src="./plugin/jquery.js"></script>

<style>
body{
	background-color:rgb(225,225,225);
	margin:0px;
}
textarea{
	resize:none;
}
#tag span{
	line-height:14px;
	font-size:14px;
	background-color:#777777;
	border-radius:4px;
	padding:1px 6px 1px 6px;
	margin-left:5px;
	color:white;
}
</style>

<script>
var converter = new Showdown.converter();
$(document).ready(function(){
	var top = document.getElementById('top').offsetHeight;
	var brower = document.documentElement.clientHeight;
	$('#textleft').css('height',(brower-top-30)+'px');
	$('#textright').css('height',(brower-top-30)+'px');
	
	
	var q = $('#q').val();
	if(q != 0){
		loadArticle(q);
	}
	
	
	
	var re =new RegExp("^[ ]+$");
	
	$('#textleft').keyup(function(){
		showdown();
		
	});
	$('#textleft').keydown(function(e){
		if(e.which == 9){
			
		}
	});
	$('#tags').blur(function(){
		var tags = $('#tags').val().split(',');
		if(tags==''|| re.test(tags)){
			$('#tag').html('');
			return;
		}
		var i = 0;
		var str = '';
		for(i = 0;i<tags.length;i++){
			str += ('<span>'+tags[i]+'</span>');
		}
		$('#tag').html(str);
	});
	
	$('#title').blur(function(){
		if( re.test($('#title').val())){
			$('#title-blur').text('不要用空格来糊弄我！');
		}
		else if($('#title').val()==''){
			$('#title-blur').text('你没有输标题亲！');
		}
		else{
			$('#title-blur').text('');
		}
	});
	
	$('#submit').click(function(){
		var title = $('#title').val();
		var tag = $('#tags').val();
		var article = htmlEncode($('#textleft').val());
		
		if($('#q').val() == 0){
			$.ajax({
				type:'POST',
				url:'handle/article.php',
				data:{
					operation:'save',
					title:title,
					tags:tag,
					article:article
				},
				success:function(data){
					if(data == 1){
						alert('已保存');
						location.reload();
					}
				},
				error:function(xml,e){
					alert(e);
				}
			});
		}
		else{
			$.ajax({
				type:'POST',
				url:'handle/article.php',
				data:{
					operation:'change',
					id:$('#q').val(),
					title:title,
					tags:tag,
					article:article
				},
				success:function(data){
					if(data == 1){
						alert('已修改');
						location.reload();
					}
				},
				error:function(xml,e){
					alert(e);
				}
			});
		}
	});
});
function showdown(){
	var content = $('#textleft').val();
	$('#textright').html(converter.makeHtml(content));
}
function loadArticle(q){
	$.ajax({
		type:'POST',
		url:'handle/article.php',
		data:{
			operation:'read',
			q:q
		},
		success:function(data){
			var sp = data.split('$ge#');
			$('#title').val(sp[0]);
			$('#tags').val(sp[1]);
			$('#textleft').html(htmlDecode(sp[2]));
			
			showdown();
		},
		error:function(xml,e){
			alert(e);
		}
	});
}
function htmlEncode(str){
	var s = "";
	if(str.length == 0) return "";
	s = str.replace(/&/g,"&amp;");
	s = s.replace(/</g, "&lt;");  
	s = s.replace(/>/g, "&gt;");    
	s = s.replace(/'/g, "&apos;");  
	s = s.replace(/"/g, '&quot;');
	return s;
}
function htmlDecode(str){
	var s = "";
	if(str.length == 0) return "";
	s = str.replace(/&amp;/g,"&");
	s = s.replace(/&lt;/g, "<");  
	s = s.replace(/&gt;/g, ">");    
	s = s.replace(/&apos;/g, "'");  
	s = s.replace(/&quot;/g, '"');
	return s;
}
</script>
</head>
<body>
	<div id="top">
		<label>标题:<input type="text" id="title" style="width:300px" /><label id="title-blur" style="color:red;"></label>标题请不要留空</label>
		<button id="submit" style="float:right">保存</button>
		<br>
		<label>标签:<input type="text" id="tags" /><label id="tag"></label>标签请用英文逗号“,”隔开</label>
	</div>
	<div style="width:100%;">
		<div style="float:left;width:49%;">
			<textarea id="textleft" style="width:100%;"></textarea>
		</div>
		<div style="float:left;width:2%;height:10px;"></div>
		<div style="float:left;width:49%;">
			<div id="textright" style="background-color:white;padding:0 1% 0 1%;width:98%;overflow:scroll;">
				
			</div>
		</div>
	</div>
<input id="q" value="<?php echo $q; ?>" style="display:none;"/>
</body>
</html>