
<?php
 require("imageHelper.php");
                           require('wechatHelper.php');
                            $wcHelper=new wechatHelper();
                            $fromuser= $_GET["id"];
                            echo "执行getPicByUID:".date("Y-m-d H:i:s",time());
                             $picurl=$wcHelper->getPicByUID($fromuser);
        $picurl=$_GET["pic"];
                                 echo "执行完getPicByUID:".date("Y-m-d H:i:s",time());

//获取图片原始宽高，计算缩小比例
$filename = date("YmdHis",$filetime).rand(100,999).'.jpg';
$filepath = $_SERVER['DOCUMENT_ROOT']."/uploads/";
echo "执行getImage:".date("Y-m-d H:i:s",time()) ;
//$imagename=imageHelper::getImage($picurl,'',$filepath , array('jpg', 'gif'));
$imagename=imageHelper::grabImage($picurl,'',$filepath) ;

echo "执行完getImage:".date("Y-m-d H:i:s",time()) ;
echo "执行getimagesize:".date("Y-m-d H:i:s",time()) ;
list($img_width, $img_height, $type, $attr) = getimagesize($filepath.$imagename);
echo "执行完getimagesize:".date("Y-m-d H:i:s",time());
$sxbl = 1;
if($img_width>300){
$sxbl = floatval($img_width/300);
$width = 300;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap.min.css">
<title>裁剪图片</title>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.Jcrop.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

</head>
<body>

<div style="display:none">
<label style="float:left;">原始宽度:<?php echo $img_width ?>px</label>
<input type="button" onclick="gf_crop_resize('b')" value="放大">
<input type="button" onclick="gf_crop_resize('s')" value="缩小">
<label id='cwidth' style="float:right;">当前宽度:<?php echo $width ?></label>
</div>

<img src="<?php echo $picurl ?>" id="cropbox" width="<?php echo $width ?>"/>

<div class="container" >
<form name="cropform" id="cropform" >
<input type="hidden"   name="x1" id="x1" size="3" />
<input type="hidden" id="y1"  name="y1" />
<input type="hidden" id="cropwidth"  name="cropwidth"/>
<input type="hidden" id="cropheight" name="cropheight" />
<input type="hidden" name="sxbl"  id="sxbl" value="<?php echo$sxbl ?>" /><!--当前图片缩小比例，php中用于计算裁剪-->
<input type="hidden" name="src"  id="src" value="<?php echo $picurl ?>" />
<input type="hidden" name="input"   id="input" value="<?php echo$input ?>" />
<input type="hidden" id="preview" value="<?php echo$preview ?>" />
<input type="button" class="btn btn-success" id="saveBtn"  value="确定"/>
</form>
<div id="status"></div>
</div>
<div style="display:none">
<input type="button" onclick="gf_crop_init()" value="自由裁剪">
<input type="button" onclick="gf_crop_init('160','120')" value="4:3">
<input type="button" onclick="gf_crop_init('120','180')" value="2:3">
</div>
<script language="Javascript">
//初始化拉选事件
function gf_crop_init(w,h){
$('.jcrop-holder').remove();
$('#cropbox').css('display','');
var api = $.Jcrop("#cropbox");

if(w=='' || h==''){
wh='';
w=100;
h=100;
}else{
wh = w/h;
}
api.setOptions({aspectRatio: wh,allowResize:true,onChange:showCoords,onSelect:showCoords});//设置相应配置
api.setSelect([0,0,w,h]); //设置选中区域

}
//选区位置坐标及宽高
function showCoords(c) {

$("#x1").val(c.x); //得到选中区域左上角横坐标
$("#y1").val(c.y); //得到选中区域左上角纵坐标
//$("#x2").val(c.x2); //得到选中区域右下角横坐标
//$("#y2").val(c.y2); //得到选中区域右下角纵坐标
$("#cropwidth").val(c.w); //得到选中区域的宽度
$("#cropheight").val(c.h); //得到选中区域的高度
}
//放大或缩小图片以方便裁剪出合适图片
function gf_crop_resize(act){
$('.jcrop-holder').remove();
$('#cropbox').css('display','');

img_cur_width = $('#cropbox').attr('width');
if(act=='b' && img_cur_width<800){
img_rewidth = img_cur_width + 50;
if(img_rewidth > <?php echo $img_width ?>) img_rewidth = <?php echo $img_width ?>;
}
if(act=='s' && img_cur_width>200){
img_rewidth = img_cur_width - 50;
if(img_rewidth<200) img_rewidth = 200;
}

sxbl = <?php echo $img_width ?>/img_rewidth;//放大缩小时重新计算图片缩小比例
$('#cropbox').attr('width',img_rewidth);
$('#cwidth').html('当前宽度:'+img_rewidth+'px');
$('#sxbl').val(sxbl);
}
$(function(){
gf_crop_init('160','120');
})
</script>
<script>
$(function(){
$("#saveBtn").on("click",function(){
   $("#status").html("图片处理中..") ;
  $.ajax({

                  type: "POST",
                  url:"crop.php",
                  data:$('#cropform').serialize() // 你的formid


              }).success(function(d){

                 $("#status").html("最终图片如下<img width='300' src='/uploads/"+d+"' />") ;
               })
})
}) ;
</script>
</body>
</html>