<?php
require '../config.php';
require '../class/wx.class.php';
require '../class/db.class.php';
require '../class/jw.class.php';



$wx = new wx();
$db = new db();
$jw = new jw();

define("TOKEN", "kebiao");//设置token

//$wx->checkSignature();//验证签名

        $signature = $_GET["signature"];//微信加密签名
        $timestamp = $_GET["timestamp"];//时间戳
        $nonce = $_GET["nonce"];//随机数	
        $echoStr = $_GET["echostr"];//随机字符串
		
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
		    if (!isset($echoStr)) {
                return true;
            }else{
                echo $echoStr;
                exit;
            }
        }


$postObj = $wx->receiveMessage();//接受来自微信的消息
$openid = $postObj->FromUserName;//获取openid


	
		$content=array();
		$content[] = array(
			"Title"=>"课表获取失败",
			"Description"=>"教务系统没有课表数据",
			"PicUrl"=>"",
			"Url"=>""   
		);
	

$resultStr = $wx->transmitNews($postObj,$content);
echo $resultStr;
?>