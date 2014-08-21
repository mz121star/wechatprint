<?php
 require("imageHelper.php");
                           require('wechatHelper.php');
                            $wcHelper=new wechatHelper();
                            $fromuser= $_GET["id"];
                          //  echo "执行getPicByUID:".date("Y-m-d H:i:s",time());
                             $picurl=$wcHelper->getPicByUID($fromuser);
      //$picurl='http://deepliquid.com/Jcrop/demos/demo_files/pool.jpg';
                                // echo "执行完getPicByUID:".date("Y-m-d H:i:s",time());

//获取图片原始宽高，计算缩小比例
$filename = date("YmdHis",$filetime).rand(100,999).'.jpg';
$filepath = $_SERVER['DOCUMENT_ROOT']."/uploads/";
//echo "执行getImage:".date("Y-m-d H:i:s",time()) ;
$imagename=imageHelper::getImage($picurl,'',$filepath , array('jpg', 'gif'));
//$imagename=imageHelper::grabImage($picurl,'',$filepath) ;

//echo "执行完getImage:".date("Y-m-d H:i:s",time()) ;
//echo "执行getimagesize:".date("Y-m-d H:i:s",time()) ;
list($img_width, $img_height, $type, $attr) = getimagesize($filepath.$imagename);
//echo "执行完getimagesize:".date("Y-m-d H:i:s",time());
$sxbl = 1;
if($img_width>300){
$sxbl = floatval($img_width/300);
$width = 300;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Live Cropping Demo</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.Jcrop.js"></script>
  <link rel="stylesheet" href="demo_files/main.css" type="text/css" />
  <link rel="stylesheet" href="demo_files/demos.css" type="text/css" />
  <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

<script type="text/javascript">

  $(function(){
    alert("开始裁剪");
    $('#cropbox').Jcrop({
      aspectRatio: 4 / 3,
      onSelect: updateCoords,
      onChange: updateCoords
    });

  });

  function updateCoords(c)
  {
    $("#x1").val(c.x); //得到选中区域左上角横坐标
    $("#y1").val(c.y); //得到选中区域左上角纵坐标
    $("#cropwidth").val(c.w); //得到选中区域的宽度
    $("#cropheight").val(c.h); //得到选中区域的高度
  };

  function checkCoords()
  {
    if (parseInt($('#cropwidth').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>
<style type="text/css">
  #target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
  }


</style>

</head>
<body>

<div class="container">
<div class="row">
<div class="span12">
<div class="jc-demo-box">

<div class="page-header">

<h1>裁剪图片到合适大小，然后打印</h1>
</div>

		<!-- This is the image we're attaching Jcrop to -->

       <img src="<?php echo $picurl ?>" id="cropbox" width="<?php echo $width ?>"/>
       <div id="status"></div>
		<form id="cropform" >
            <input type="hidden"   name="x1" id="x1" size="3" />
            <input type="hidden" id="y1"  name="y1" />
            <input type="hidden" id="cropwidth"  name="cropwidth"/>
            <input type="hidden" id="cropheight" name="cropheight" />
            <input type="hidden" name="sxbl"  id="sxbl" value="<?php echo$sxbl ?>" /><!--当前图片缩小比例，php中用于计算裁剪-->
            <input type="hidden" name="src"  id="src" value="<?php echo $imagename ?>" />
            <input type="hidden" name="input"   id="input" value="<?php echo$input ?>" />
            <input type="hidden" id="preview" value="<?php echo$preview ?>" />
			<input type="button" value="确定裁剪"  id="saveBtn"  class="btn btn-large btn-inverse" />
		</form>



	</div>
	</div>
	</div>
	</div>
	</body>
       <script>
       $(function(){
            $("#saveBtn").on("click",function(){
                  $("#status").html("图片处理中..") ;
                  if( checkCoords()){
                   $.ajax({

                                type: "POST",
                                 url:"crop.php?id=<?php echo $_GET['id'] ?>",
                                 data:$('#cropform').serialize() // 你的formid


                             }).success(function(d){

                                $("#status").html("最终图片如下<img width='300' src='/uploads/"+d+"' />") ;
                              })
                  };
           })
       }) ;
       </script>
</html>