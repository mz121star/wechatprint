<?php
      require('wechatHelper.php');
        $wcHelper=new wechatHelper();
      if(isset($_GET["uid"]) && $_GET["uid"]){

          $uid=$_GET["uid"];
          $wcHelper->setNoPrintPics($uid);
          echo "printed";
       }
       else{


                 echo json_encode( $wcHelper->getNoPrintPics());
       }




?>