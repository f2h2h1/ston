<?php
//include('../limitWechatClient.php');//判断是否在微信客户端打开
require '../config.php';

require '../class/db.class.php';
require '../class/jw.class.php';


$db = new db();
$jw = new jw();

$user=$_POST['user'];
$pwd=$_POST['pwd'];
$openid=$_POST['openid'];

$pwd=urlencode($pwd);

$cookie_file = tempnam('./temp','cookie');//这是一个全局变量 
$cookie_SessionId="";

$_w_count_date = date('Y/m/j');
$_w_last_rule_time = time();

$user_len=strlen($user);

if($user_len==10) {//本科

	$xy=1;

	//进入登录页面
	$url="default_vsso.htm";
	$referer=$url;
	$jw->st_jiaowu_curl($url,$data = null,$cookie = null,$referer);
	//进入学生主页

	$data="TextBox1=$user&TextBox2=$pwd&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";

	$url="default_vsso.aspx";
	$referer="default_vsso.htm";
	$str=$jw->st_jiaowu_curl($url,$data,$cookie = null,$referer);

	preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);

	$cookie_SessionId=$results[0][0];
	$cookie=$cookie_SessionId;

	preg_match('/<span id="xhxm">(?<xhxm>.*?)同学<\/span>/i', $str, $matches);
	$name=$matches['xhxm'];

	//进入个人信息页面
	$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";

	$url="xsgrxx.aspx?xh=$user&xm=$name&gnmkdm=N121501";
	$referer="xs_main.aspx?xh=$user";
	$str=$jw->st_jiaowu_curl($url,$data = null,$cookie,$referer);

	$pattern = '/<table class="formlist" width="100%" align="center">[\s\S]*?<\/table>/i';//选取表格table
	preg_match($pattern, $str, $matches);
	$temp = strtolower($matches[0]);//该函数将传入的字符串参数所有的字符都转换成小写
	$xsgrxx=$jw->get_td_array($temp);
	//printf("<pre>%s</pre>\n",var_export( $xsgrxx ,TRUE));

	$xsgrxx = json_encode($xsgrxx,JSON_UNESCAPED_UNICODE);

} else if($user_len==12){//专科

	$xy=2;
//echo"<script>alert(2)</script>";
	//进入登录页面
	$url="default_vsso.htm";
	$referer=$url;
	$jw->st2_jiaowu_curl($url,$data = null,$cookie = null,$referer);
	//进入学生主页

	$data="TextBox1=$user&TextBox2=$pwd&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";

	$url="default_vsso.aspx";
	$referer="default_vsso.htm";
	$str=$jw->st2_jiaowu_curl($url,$data,$cookie = null,$referer);

	preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);

	$cookie_SessionId=$results[0][0];
	$cookie=$cookie_SessionId;

	preg_match('/<span id="xhxm">(?<xhxm>.*?)同学<\/span>/i', $str, $matches);
	$name=$matches['xhxm'];

	//进入个人信息页面
	$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";

	$url="xsgrxx.aspx?xh=$user&xm=$name&gnmkdm=N121501";
	$referer="xs_main.aspx?xh=$user";
	$str=$jw->st2_jiaowu_curl($url,$data = null,$cookie,$referer);

	$pattern = '/<table class="formlist" width="100%" align="center">[\s\S]*?<\/table>/i';//选取表格table
	preg_match($pattern, $str, $matches);
	$temp = strtolower($matches[0]);//该函数将传入的字符串参数所有的字符都转换成小写
	$xsgrxx=$jw->get_td_array($temp);
	//printf("<pre>%s</pre>\n",var_export( $xsgrxx ,TRUE));

	$xsgrxx = json_encode($xsgrxx,JSON_UNESCAPED_UNICODE);

}
//printf("<pre>%s</pre>\n",var_export( $xsgrxx ,TRUE));

//<script src="../../js/jscys.js"></script>
//<link rel="stylesheet" href="../../css/weui/example.css">
//<link rel="stylesheet" href="../../css/weui/weui.css">  
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <script src="../../js/jzfx.js"></script>
           
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>绑定学号</title>
        <link rel="stylesheet" href="../../css/weui/example.css">
        <link rel="stylesheet" href="../../css/weui/weui.css">
    </head>
    <body>
        <div class="container js_container">
			<div class="page">
            <?
if(!empty($name)&&!empty($xsgrxx)&&!empty($openid)){
			//echo $name;echo"<br>";
            $sql = "INSERT INTO `wechat`.`sontan_jiaowu` (`openid`, `user`, `pwd`) VALUES ('$openid', '$user', '$pwd');";
			$db->query($sql);
			//echo $sql;echo"<br>";
            ?>    
            
                <div class="hd">
                    <h1 class="page_title"style="font-size:25px;">绑定成功</h1>
                </div>
                <div class="bd">
                    <table style="margin:auto;">
                        <tr ><th>绑定成功</th></tr>
                        <tr align='left'><th>回复“课表” 获取课表</th></tr>
                        <tr align='left'><th>回复“考试” 获取考试地点安排</th></tr>  
                        <tr align='left'><th>回复“成绩” 获取学年成绩绩点</th></tr>      
                        <tr align='left'><th>回复“解绑” 解除或更换当前绑定账号</th></tr>                    
                    </table>
                </div>
            
                <?
}else if(!empty($name)&&empty($xsgrxx)){
                ?>    
				<div class="hd">
					<h1 class="page_title"style="font-size:25px;">绑定失败</h1>
				</div>
				<div class="bd">
					<table style="margin:auto;">
						<tr align='left'><th>您好，学号绑定失败</th></tr>
						<tr align='left'><th>绑定失败是由以下原因导致的</th></tr>
						<tr align='left'><th>未完成教学质量评价</th></tr>
						<tr align='left'><th>请先到教务系统完成教学质量评价</th></tr>
						<tr align='left'><th>如果已完成评教仍不能绑定，请到教务系统检查一下教学质量评价有没有点击提交按钮</th></tr>
					</table>  
				</div>
                
                <?
}else{
                ?>
				<div class="hd">
					<h1 class="page_title"style="font-size:25px;">绑定失败</h1>
				</div>
				<div class="bd">
					<table style="margin:auto;">
						<tr align='left'><th>您好，学号绑定失败</th></tr>
						<tr align='left'><th>绑定失败可能是由以下原因导致的</th></tr>
						<tr align='left'><th>1.密码错误</th></tr>
						<tr align='left'><th>2.密码过期</th></tr>
					</table>  
				</div>
                
                <?
}
                ?> 
			    <div class="weui_msg">
                    <div class="weui_extra_area" style="font-size:18px;">
                        <p>&copy;掌上松田</p>
                        <p>粤ICP备16026941号</p>
                    </div>
                </div>
			</div>
        </div>         
    </body>
</html>