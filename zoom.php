<?php
 require("imageHelper.php");
                           require('wechatHelper.php');
                            $wcHelper=new wechatHelper();
                            $fromuser= $_GET["id"];
                          //  echo "执行getPicByUID:".date("Y-m-d H:i:s",time());
                             $picurl=$wcHelper->getPicByUID($fromuser);
       // $picurl=$_GET["pic"];
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
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.Jcrop.js"></script>
  <link rel="stylesheet" href="demo_files/main.css" type="text/css" />
  <link rel="stylesheet" href="demo_files/demos.css" type="text/css" />
  <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
     aspectRatio: 16 / 9,
      onSelect: updateCoords
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
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
<ul class="breadcrumb first">
  <li><a href="../index.html">Jcrop</a> <span class="divider">/</span></li>
  <li><a href="../index.html">Demos</a> <span class="divider">/</span></li>
  <li class="active">Live Demo (Requires PHP)</li>
</ul>
<h1>Server-based Cropping Behavior</h1>
</div>

		<!-- This is the image we're attaching Jcrop to -->

       <img src="<?php echo $picurl ?>" id="cropbox" width="<?php echo $width ?>"/>

		<form action="crop.php" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
		</form>



	</div>
	</div>
	</div>
	</div>
	</body>

</html>