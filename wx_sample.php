<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "dlwebs");


$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();

 $wechatObj->responseMsg();


class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
         /**
          * 发送post请求
          * @param string $url 请求地址
          * @param array $post_data post键值对数据
          * @return string
          */
        public function send_post($url, $post_data) {

           $postdata = http_build_query($post_data);
           $options = array(
             'http' => array(
               'method' => 'POST',
               'header' => 'Content-type:application/x-www-form-urlencoded',
               'content' => $postdata,
               'timeout' => 15 * 60 // 超时时间（单位:s）
             )
           );
           $context = stream_context_create($options);
           $result = file_get_contents($url, false, $context);

           return $result;
         }
    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
             $this->logger($postStr);
        echo  $this->send_post('http://print.wx.dlwebs.com/wx.php',$postStr);
        exit;
      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to wechat world!";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	  //日志记录
        private function logger($log_content)
        {
            if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
                sae_set_display_errors(false);
                sae_debug($log_content);
                sae_set_display_errors(true);
            }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
                $max_size = 10000;
                $log_filename = "log.xml";
                if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
                file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
            }
        }
}

?>