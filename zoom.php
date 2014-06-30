
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Jcrop 图像裁剪插件 &raquo; 在线演示 &raquo; 事件处理 - 前端开发仓库</title>
<link rel="stylesheet" href=""/css/jquery.Jcrop.css">

<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.Jcrop.js"></script>
<script>
jQuery(function($){
	$("#target").Jcrop({
		onChange:showCoords,
		onSelect:showCoords,
		onRelease:clearCoords
	});
});

// Simple event handler, called from onChange and onSelect
// event handlers, as per the Jcrop invocation above
function showCoords(c){
	$("#x1").val(c.x);
	$("#y1").val(c.y);
	$("#x2").val(c.x2);
	$("#y2").val(c.y2);
	$("#w").val(c.w);
	$("#h").val(c.h);
};

function clearCoords(){
	$("#coords input").val("");
	$("#h").css({color:"red"});
	window.setTimeout(function(){
		$("#h").css({color:"inherit"});
	},500);
};
</script>
</head>
<body>
<div id="outer">
	<div class="jcExample">
		<div class="article">
			<h1>Jcrop - 事件处理</h1>

			<!-- This is the image we're attaching Jcrop to -->
			<img src="http://code.ciaoca.com/jquery/jcrop/demo/demos/demo_files/flowers.jpg" id="target" alt="Flowers">

			<!-- This is the form that our event handler fills -->
			<form id="coords" class="coords" onsubmit="return false;" action="http://example.com/post.php">
				<label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
				<label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
				<label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
				<label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
				<label>W <input type="text" size="4" id="w" name="w" /></label>
				<label>H <input type="text" size="4" id="h" name="h" /></label>
			</form>
			
			<p><strong>一个基本事件处理的示例</strong></p>
			<p>这个示例里，我们使用 Jcrop 的 <em>onChange</em> 事件，实时更新在图像上裁剪的一些数值，这些数值可提供给服务端程序（例如：PHP）进行真实的裁剪。</p>
			<p>将 Jcrop 集成到表单中是多么的容易！</p>
			
			<div id="dl_links">
				<a href="../index.html">在线演示</a> |
				<a target="_blank" href="http://code.ciaoca.com/jquery/jcrop/">中文文档</a> |
				<a target="_blank" href="http://deepliquid.com/content/Jcrop.html">Jcrop Home</a> |
				<a target="_blank" href="http://deepliquid.com/content/Jcrop_Manual.html">Manual (Docs)</a>
			</div>
		</div>
	</div>
</div>
</body>
</html>