 <?php
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
 ?>
<!DOCTYPE html>
<html>
  <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>微信加粉平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">


  </head>
  <body>

    <?php
	        include_once('wechatHelper.php');
            $wcHelper=new wechatHelper();
            $data = '{
                "button":[
                {
                      
                     "name":"账户",
                     "sub_button":[
					 {
						 "type":"view",
						 "name":"绑定账户",
						 "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf7000e880d5563bf&redirect_uri=http://dlwebs99.jd-app.com/good.php&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect"
					 }]
			     },
                 {
                      "type":"click",
                      "name":"歌手简介",
                      "key":"V1001_TODAY_SINGER"
                 },
                 {
                      "name":"菜单",
                      "sub_button":[
                       {
                          "type":"click",
                          "name":"hello word",
                          "key":"V1001_HELLO_WORLD"
                       },
                       {
                          "type":"click",
                          "name":"赞一下我们",
                          "key":"V1001_GOOD"
                       }]
                  }]
            }';

 

      //$creatMenu = $wcHelper->createMenu($data);//创建菜单
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
            <h3>第一步：扫描二维码</h3>
			<div><img src="getqrcode.jpg" /></div>
			<hr>
			<h3>第二步：在微信中绑定账户</h3>
			<h3>第三步：发送“打印照片A51234”到微信平台</h3>
			<h3>第四步：平台确认完成，发送一张需要打印的照片到微信平台，然后等待平台确认</h3>
        </div>
        <div class="row"><img id="pimg" src="" /><button class="btn btn-success">确认打印</button></div>
      </div> <!-- /container -->


    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
	 window.setInterval(function(){
	    $.get("getpic.php?id=A51234").success(function(d){
	        if(d.indexOf("http")>-1){
			   $("#pimg").attr("src",d);
			}
	   })
	 },4000);
       
    </script>
  </body>
</html>