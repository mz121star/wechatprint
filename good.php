 <?php
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
 ?>
<!DOCTYPE html>
<html>
  <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>绑定</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">


  </head>
  <body>

  <?php
    
    require('wechatHelper.php');
    
	$accessCode=$_GET["code"];
	 
	$info_access_token=  file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf7000e880d5563bf&secret=106ea8adfdafaae1baeaa645ae7c0f6a&code='.$accessCode.'&grant_type=authorization_code');
	var_dump($info_access_token);
	$obj = json_decode($info_access_token);
	$WeiXinId =$obj->openid;  
    $wcHelper=new wechatHelper();
 
    if($wcHelper->isBindWechat($WeiXinId))
      {
        print_r("hello1:".$WeiXinId);
        echo '您已经绑定账户，无需继续绑定';
        exit;

      }
  ?>

   <div class="container">

        <!-- Static navbar -->
        <div class="navbar navbar-default" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">微信加粉平台</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">首页</a></li>
              <li><a href="#">账户信息</a></li>
              <li><a href="#">关于我们</a></li>

            </ul>

          </div><!--/.nav-collapse -->
</div>

        <!-- Main component for a primary marketing message or call to action -->
        <div class="row">
          <div>
                     
						<form class="form-horizontal" role="form" action="bindweixin.php" method="POST">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="name" name="name" placeholder="姓名">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">电话</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="phone" name="phone" placeholder="电话">
    </div>
  </div>
   <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">微信ID</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="phone"  name="weixinid" value="<?php echo $WeiXinId; ?>"  >
    </div>
  </div>
          
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">绑定</button>
    </div>
  </div>
</form>
          </div>

        </div>

      </div> <!-- /container -->


    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>