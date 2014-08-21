<?php
      require('wechatHelper.php');
	 $wcHelper=new wechatHelper();
	 echo json_encode( $wcHelper->getNoPrintPics());
?>