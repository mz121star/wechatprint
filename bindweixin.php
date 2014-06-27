<?php
  require('wechatHelper.php');
     
    $wcHelper=new wechatHelper();
 
    
    header("Content-Type: text/html; charset=utf-8");

    $WeiXinId = $_POST["weixinid"];
    $name=$_POST["name"];
    $phone=$_POST["phone"];

     echo    $WeiXinId.  $name     .$phone;
     if($WeiXinId==null||$phone==null||$name==null){
         echo '提交信息有误';
         exit;
     }
  
     // 从表中提取信息的sql语句
    $selectUser="SELECT * FROM users  where id='".$WeiXinId."'";
  
   
    if($wcHelper->isBindWechat($WeiXinId)){
         echo '您已经使用过该项服务,您的手机为'.$row['phone'];
    } else{


          $wcHelper->bindWechat($WeiXinId,$phone,$name );
          echo '恭喜您绑定成功';
    }
   
?>
