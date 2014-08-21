<?php

   include_once('class.MySQL.php');

   define("ACCESS_TOKEN", "Ww6Vbx9s0TtoFoTBYZseeTjlXvavIxCK9S6grxOzEGl7egTT10cjQWgV5NAVUR2dqEYWEHlSZeS_VQDeGpFqvA");



   class wechatHelper{

		private   $mysql_server_name; //数据库服务器名称 
		private   $mysql_username; // 连接数据库用户名 
		private   $mysql_password; // 连接数据库密码 
		private   $mysql_database; // 数据库的名字 
		private   $conn;


	 function __construct() {
		$this->mysql_server_name="localhost"; //数据库服务器名称
		$this->mysql_username="root"; // 连接数据库用户名
		$this->mysql_password="8ecba89b81"; // 连接数据库密码
		$this->mysql_database="wxprint2"; // 数据库的名字
        $this->conn = new MySQL( $this->mysql_database,  $this->mysql_username,  $this->mysql_password, $this->mysql_server_name);
		}



      // 创建菜单
    public  function createMenu($data){
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
              curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
              curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
              curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $tmpInfo = curl_exec($ch);
              if (curl_errno($ch)) {
               return curl_error($ch);
              }
              curl_close($ch);
              return $tmpInfo;
      }
      //获取菜单
     public   function getMenu(){
      return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".ACCESS_TOKEN);
      }
      //删除菜单
    public  function deleteMenu(){
      return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".ACCESS_TOKEN);
      }




       //判断是否绑定
      public function isBindWechat($WeiXinId)
      {
 
               $selectUser="SELECT * FROM users  where id='".$WeiXinId."'";

               $result=$this->conn->ExecuteSQL($selectUser);

                if(count($result)>1){
                  print_r('yes');
                         return  true;
                } else{
                 print_r('no');
                          return false;
                }
      }
	  //绑定微信
      public function bindWechat($WeiXinId,$phone,$name){
	       // $adduser = array('name' => $name,'phone'=>$phone,'id'=>$WeiXinId);
		     $insertUser="insert into users   values ('".$WeiXinId."','".$phone."','".$name."','url')"  ;
			$result=$this->conn->ExecuteSQL($insertUser);
			return $result;
	  }

public function getPicByUID($wexinid){
           $querystr="select picurl from pics where uid='".$wexinid."'";
           $result=$this->conn->ExecuteSQL($querystr);
          return  $result["picurl"];
}
	  public function inserPic($wexinid,$picurl){
	     $querystr="select * from pics where uid='".$wexinid."'";
	     $insertstr="insert into pics   values ('".$wexinid."','".$picurl."')"  ;
	     $updatestr="update pics SET picurl = '".$picurl."' WHERE uid='".$wexinid."'";;
         $result=$this->conn->ExecuteSQL($querystr);

                        if(count($result)>1){
                                 //更新
                               $this->conn->ExecuteSQL($updatestr);
                        } else{
                                //插入
                             $this->conn->ExecuteSQL($insertstr);
                        }
	  }
      //用户上传图像，并且绑定
	  public function saveUserPic($fromuser,$picurl)
	   {
 
               $updateUser="update users SET picurl = '".$picurl."' WHERE id='".$fromuser."'";

               $this->conn->ExecuteSQL($updateUser);
 
	   }
        //绑定打印机和用户ID
	  public function bindPrintDevice($deviceid,$userid)
	   {
			$newpd = array('printpic' => $deviceid,'userid'=>$userid,'picurl'=>"url");
			  $insertpu="insert into printpic   values ('".$deviceid."','".$userid."','url')"  ;
			$result=$this->conn->ExecuteSQL($insertpu);
			//$result=$this->conn->Insert($newpd, 'printpic');
			return $result;
	   }

	   public function getPicUrlByDeviceId($deviceid)
	   {
              $sql="select u.picurl as url from printpic p join users  u on u.id=p.userid  where p.deviceid='".$deviceid."'";
			  
			  $result=$this->conn->ExecuteSQL($sql);
			  return $result;
	   }
	   	   public function getNoPrintPics()
       	   {
                $sql="select  *   from pics  where isprint=0 ";

       			  $result=$this->conn->ExecuteSQL($sql);
       			  return $result;
       	   }
       	     public function setNoPrintPics($wexinid)
          {
                           $updatestr="update pics SET isprint=1 WHERE uid='".$wexinid."'";;
                              echo  $updatestr;
                              exit;
                  			  $result=$this->conn->ExecuteSQL($sql);
                  			  return $result;
        }
   }
?>