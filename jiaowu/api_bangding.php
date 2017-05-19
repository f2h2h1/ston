<?
require '../config.php';
require '../class/wx.class.php';
require '../class/db.class.php';

$wx = new wx();
$db = new db();


define("TOKEN", "bangding");//设置token

$wx->checkSignature();//验证签名


$postObj = $wx->receiveMessage();
$openid = $postObj->FromUserName;//接收openid

//printf("<pre>%s</pre>\n",var_export( file_get_contents("php://input") ,TRUE));
//printf("<pre>%s</pre>\n",var_export( $postObj ,TRUE));
//printf("<pre>%s</pre>\n",var_export( $_POST ,TRUE));

$sql = "SELECT * FROM sontan_jiaowu WHERE openid ='{$openid}'";
$row = $db->fetch($sql);
if(!empty($row)){
    
	$content=array();
    $content[] = array(
        "Title"=>"你已绑定学号",
        "Description"=>"回复“课表” 获取课表\n回复“成绩” 获取学年成绩绩点\n回复“解绑” 解除或更换当前绑定账号",
        "PicUrl"=>"",
        "Url"=>""   
    );
    
}else{
    
    $content=array();
    $content[] = array(
        "Title"=>"您好，请先绑定学号",
        "Description"=>"点击绑定",
        "PicUrl"=>"",
        "Url"=>"http://chaotingcm.com/wechat/jiaowu/bangding.php?openid=$openid"   
    );
    
}
$resultStr = $wx->transmitNews($postObj,$content);
echo $resultStr;
?>