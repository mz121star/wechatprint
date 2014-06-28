 <?php
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
 ?>
<!DOCTYPE html>
<html>
  <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>裁剪图片</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
                              <?php


                                require('wechatHelper.php');
                                 $wcHelper=new wechatHelper();
                                $fromuser= $_GET["id"];
                                $picurl=$wcHelper->getPicByUID($fromuser);

                              //获取图片原始宽高，计算缩小比例
                              list($img_width, $img_height, $type, $attr) = getimagesize($picurl);
                              $sxbl = 1;
                              if($img_width>500){
                              $sxbl = floatval($img_width/500);
                              $width = 500;
                              }
                              ?>
      	<script src="js/jquery.min.js" type="text/javascript"></script>
      		<script src="js/jquery.Jcrop.js" type="text/javascript"></script>
      		<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

      		<script type="text/javascript">

      		jQuery(function($){

            $('#target').Jcrop({
              onChange:   showCoords,
              onSelect:   showCoords,
              onRelease:  clearCoords
            });

          });

          // Simple event handler, called from onChange and onSelect
          // event handlers, as per the Jcrop invocation above
          function showCoords(c)
          {
            $('#x1').val(c.x);
            $('#y1').val(c.y);
            $('#x2').val(c.x2);
            $('#y2').val(c.y2);
            $('#w').val(c.w);
            $('#h').val(c.h);
          };

          function clearCoords()
          {
            $('#coords input').val('');
            $('#h').css({color:'red'});
            window.setTimeout(function(){
              $('#h').css({color:'inherit'});
            },500);
          };

      		</script>
  </head>
  <body>



   <div class="container">


        <div id="outer">
        	<div class="jcExample">
        	<div class="article row">



        		<img src="<?php echo $picurl ?>" id="target" alt="Flowers"  width="<?php echo  $width ?>" />


        		<form id="coords"  class="coords"  onsubmit="return false;"   action=" ">

              <div style="display:none">
        			<label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
        			<label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
        			<label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
        			<label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
        			<label>W <input type="text" size="4" id="w" name="w" /></label>
        			<label>H <input type="text" size="4" id="h" name="h" /></label>
              </div>
        		</form>




        	</div>
        	</div>
        	</div>
  </body>
</html>