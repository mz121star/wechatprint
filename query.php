<?php
      require('wechatHelper.php');

      if(isset($_GET["uid"])&& $_GET["uid"]){

          $uid=$_GET["uid"];
          $wcHelper-> setNoPrintPics($uid)
       }
       else{

                 $wcHelper=new wechatHelper();
                 echo json_encode( $wcHelper->getNoPrintPics());
       }




?>