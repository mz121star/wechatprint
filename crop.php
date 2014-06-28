<?php
//$_GET数据：原始图片url($src)、选区左上坐标($x/$y)、选区宽高($cropwidth/$cropheight)、原图缩小比例($sxbl)
$src=$_POST["src"];
$x=$_POST["x"];
$y=$_POST["y"];
$cropwidth=$_POST["cropwidth"];
$cropheight=$_POST["cropheight"];
$sxbl= $_POST["sxbl"];
$src = trim($src);
if(!$src) die();


//根据缩小比例计算所选区域在原图上的真实坐标及真实宽高
$x = intval($x*$sxbl);
$y = intval($y*$sxbl);
$width = intval($cropwidth*$sxbl);
$height = intval($cropheight*$sxbl);


         $data = file_get_contents($src); // 读文件内容
         $filetime = time(); //得到时间戳
         $filepath = $_SERVER['DOCUMENT_ROOT']."uploads/";//图片保存的路径目录
         echo $filepath;
         if(!is_dir($filepath)){
             mkdir($filepath,655, true);
         }
         $filename = date("YmdHis",$filetime).rand(100,999).'.'.substr($src,-3,3); //生成文件名，
         $fp = @fopen($filepath.$filename,"w"); //以写方式打开文件
         @fwrite($fp,$data); //
         fclose($fp);//完工，哈


 echo $filename
?>