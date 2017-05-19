<?php
require '../config.php';
require '../class/wx.class.php';
require '../class/db.class.php';

$wx = new wx();
$db = new db();

define("TOKEN", "jiebang");//设置token

$wx->checkSignature();//验证签名

$postObj = $wx->receiveMessage();//接收微信的消息
$openid = $postObj->FromUserName;//接收openid

$sql = "SELECT * FROM sontan_jiaowu WHERE openid ='{$openid}'";
$row = $db->fetch($sql);

if(empty($row)){    
    
    $content="解绑失败，该微信号未绑定";
    
}else{
       
    $sql = "DELETE FROM sontan_jiaowu WHERE openid ='{$openid}'";//删除用户数据 
    $db->query($sql);
    $sql = "SELECT * FROM sontan_jiaowu WHERE openid ='{$openid}'";//再次搜索以确保已经删除
    $row = $db->fetch($sql);
    
    if(empty($row)){
        
        $content="解绑成功";
        
        
    }else{
        
        $content="解绑失败，请稍后再试";    
        
    }
    
}

$resultStr = $wx->transmitText($postObj,$content);
echo $resultStr;  
?>