<?php
     
	 require('wechatHelper.php');
   
	$wcHelper=new wechatHelper();
    $deviceid=$_GET["id"];
    $result= $wcHelper->getPicUrlByDeviceId($deviceid);
	print_r($result["url"]);
      
?>