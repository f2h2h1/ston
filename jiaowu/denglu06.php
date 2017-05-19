<?php
require '../class/jw.class.php';

$jw = new jw();


$user=$_POST['user'];
$pwd=$_POST['pwd'];
$openid=$_POST['openid'];

printf("<pre>%s</pre>\n",var_export( $_POST ,TRUE));
	
$cookie_file = tempnam('./temp','cookie');//这是一个全局变量 
$cookie_SessionId="";

$_w_count_date = date('Y/m/j');
$_w_last_rule_time = time();

//进入登录页面

$url="default_vsso.htm";
$referer=$url;
echo $jw->st_jiaowu_curl($url,$data = null,$cookie = null,$referer);



//post登录帐号密码

$user="1402040106";
$pwd="9596,yq";
$data="TextBox1=$user&TextBox2=$pwd&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";
//$data="TextBox1=140204010&TextBox2=9596,yq&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";

echo $data;echo"<br>";
$url="default_vsso.aspx";
$referer="default_vsso.htm";
echo $str=$jw->st_jiaowu_curl($url,$data,$cookie = null,$referer);

preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
printf("<pre>%s</pre>\n",var_export( $results ,TRUE));
$cookie_SessionId=$results[0][0];
$cookies=$cookie_SessionId;

preg_match('/<span id="xhxm">(?<xhxm>.*?)同学<\/span>/i', $str, $matches);
$name=$matches['xhxm'];
echo $name;
//进入学生主页
/*
$url="xs_main.aspx?xh=$user";
$referer="default_vsso.htm";
echo $jw->st_jiaowu_curl($url,$data = null,$cookie,$referer);
*/

//
/*
$url="content.aspx";
$referer="xs_main.aspx?xh=$user";
echo $jw->st_jiaowu_curl($url,$data = null,$cookie,$referer);
*/

//进入个人信息页面
$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";
$url="xsgrxx.aspx?xh=$user&xm=$name&gnmkdm=N121501";
$referer="xs_main.aspx?xh=$user";
echo $str=$jw->st_jiaowu_curl($url,$data = null,$cookie,$referer);

$pattern = '/<table class="formlist" width="100%" align="center">[\s\S]*?<\/table>/i';//选取表格table
preg_match($pattern, $str, $matches);
$temp = strtolower($matches[0]);//该函数将传入的字符串参数所有的字符都转换成小写
$xsgrxx=$jw->get_td_array($temp);
printf("<pre>%s</pre>\n",var_export( $xsgrxx ,TRUE));

echo json_encode($xsgrxx,JSON_UNESCAPED_UNICODE);


//进入课表页面
$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";
$url="xskbcx.aspx?xh=$user&xm=$name&gnmkdm=N121603";
$referer="xs_main.aspx?xh=$user";
echo $str=$jw->st_jiaowu_curl($url,$data = null,$cookie,$referer);

$pattern = '/<table id="Table1" class="blacktab" bordercolor="Black" border="0" width="100%">[\s\S]*?<\/table>/i';//选取表格table
preg_match($pattern, $str, $matches);
$td=$jw->get_kb_array($matches[0]);
printf("<pre>%s</pre>\n",var_export( $td ,TRUE));

$kb=array();
for($i=1;$i<8;$i++){
	$kb[]=array($td[2][$i+1],$td[4][$i],$td[6][$i+1],$td[8][$i],$td[10][$i+1]);
}

$key=str_replace("课表","",$keyword);
$week=array("星期一","星期二","星期三","星期四","星期五","星期六","星期日");

$flg_v=0;
for($i=0;$i<5;$i++){
	$w=$week[$i];
	$kebiao .=(($i!==0)?(""):(""))."\n========={$w}========\n".(($i==6)?(""):(""));
	foreach($kb[$i] as $v){
		$v=trim($v);
		if(!empty($v)){
			$flg_v=1;
			$kebiao .= $v."\n------------------\n";
		}
	}
}

$kebiao="你本学期一周的课有：\n\n".trim($kebiao);
echo $kebiao;
?>