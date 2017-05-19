<?php
require '../../config.php';
require '../../class/wx.class.php';
require '../../class/db.class.php';
class jw
{
	//华商教务系统curl函数
	public function hs_jiaowu_curl($url,$data = null){
	
	    global $headers;
		
		//global $cookie_file; 
		
		global $cookie_SessionId;
		
		$ch = curl_init();// 启动一个CURL会话
		curl_setopt($ch, CURLOPT_URL, $url);// 要访问的地址
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);// 获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//允许被抓取的链接跳转
		curl_setopt($ch, CURLOPT_HEADER, 1);
		if (!empty($data)){
			curl_setopt($ch, CURLOPT_POST, 1);// 发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//要传送的所有数据
		}
		if(!empty($cookie_file)) {
		    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
		} else {
		    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
		}
		$str=curl_exec($ch);// 执行一个curl会话
		
		preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
		printf("<pre>%s</pre>\n",var_export( $results ,TRUE));
		$cookie_SessionId=$results[1];

		curl_close($ch);// 关闭CURL会话
		$str = mb_convert_encoding($str, 'UTF-8', 'gb2312');// 转码
		return $str;
	}
	//把表格转换成数组的函数
	public function get_td_array($table) {
		
		$table = preg_replace("'<table[^>]*?>'si", "", $table);
		$table = preg_replace("'<tr[^>]*?>'si", "", $table);
		$table = preg_replace("'<td[^>]*?>'si", "", $table);
		$table = str_replace("</tr>", "{tr}", $table);
		$table = str_replace("</td>", "{td}", $table);
		
		$table = preg_replace("'<[\/\!]*?[^<>]*?>'si", "", $table);
		
		$table = preg_replace("'([\r\n])[\s]+'", "", $table);
		$table = str_replace(" ", "", $table);
		$table = str_replace(" ", "", $table);
		
		$table = explode('{tr}', $table);
		array_pop($table);
		foreach ($table as $key => $tr) {
			$td = explode('{td}', $tr);
			array_pop($td);
			$td_array[] = $td;
		} 
		return $td_array;
	}
	//把表格转换成数组的函数，仅用于华商的课表
	public function get_kb_array($table) {
		$table = preg_replace("/<table[^>]*?>/is","",$table);
		$table = preg_replace("/<tr[^>]*?>/si","",$table);
		$table = preg_replace("/<td[^>]*?>/si","",$table);
		$table = str_replace("</tr>","{tr}",$table);
		$table = str_replace("</td>","{td}",$table);
		$table = str_replace("<br><br>","\n\n",$table);
		$table = str_replace("<br>","\n",$table);
		$table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table);
		$table = preg_replace("'([rn])[s]+'","",$table);
		$table = str_replace(" ","",$table);
		$table = str_replace(" ","",$table);
		$table = str_replace("&nbsp;","",$table);
		
		$table = explode('{tr}', $table);
		array_pop($table);
		foreach ($table as $key=>$tr) {
			$td = explode('{td}', $tr);
			$td = explode('{td}', $tr);
			array_pop($td);
			$td_array[] = $td;
		}
		return $td_array;
	}
}
$wx = new wx();
$db = new db();
$jw = new jw();
printf("<pre>%s</pre>\n",var_export( $headers ,TRUE));

$ip_address="121.8.214.66";//ip地址

$port="81";//端口

//$default="default2.aspx";

$default="default_vsso.htm";

$urls="http://".$ip_address.":".$port."/";//用户登陆地址

$url_default=$urls.$default;

$cookie_SessionId="";

$ua="Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.154 Safari/537.36 LBBROWSER";


$headers=array (
	'Host'=>$urls,
	'Connection'=>' keep-alive',
	'Content-Length'=>'80',
	'Cache-Control'=>'max-age=0',
	'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*//*;q=0.8',
	'Origin'=>$urls,
	'User-Agent'=>$ua,
	'Content-Type'=>'application/x-www-form-urlencoded',
	'Referer'=>$url_default,
	'Accept-Encoding'=>'gzip, deflate',
	'Accept-Language'=>'zh-CN,zh;q=0.8',
	'Cookie'=>''
);
/*
$headers=array (
'Host'=>'121.8.214.66:81',
'Connection'=>' keep-alive',
'Content-Length'=>'80',
'Cache-Control'=>' max-age=0',
'Accept'=>' text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*//*;q=0.8',
'Origin'=>' http://121.8.214.66:81',
'User-Agent'=>' Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.154 Safari/537.36 LBBROWSER',
'Content-Type'=>' application/x-www-form-urlencoded',
'Referer'=>' http://121.8.214.66:81/default_vsso.htm',
'Accept-Encoding'=>' gzip, deflate',
'Accept-Language'=>' zh-CN,zh;q=0.8',
'Cookie'=>'ASP.NET_SessionId=wcm3hr45akzppkmasbrbzcm3; _w_count_date=2016/6/12; _w_count_=5; _w_today_count=4; _w_last_rule_time=1465744514; _w_today_pop_count=5'
);
*/
$cookie_file = tempnam('./temp','cookie'); 

$_w_count_date = date('Y/m/j');
$_w_last_rule_time = time();


$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";
//array_push($headers,$cookie);
$headers['Cookie']=$cookie;

$user="1402040106";
$pwd="9596,yq";

//$user="1508010137";
//$pwd="duo123456.";

$openid="asdqwe";
echo"$url_default";
$str=$jw->hs_jiaowu_curl($url_default);
echo $str;


$url=$urls."CheckCode.aspx";


$url=$urls."default_vsso.aspx";

//$data="TextBox1=$user&TextBox2=$pwd&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";

$data="TextBox1=1402040106&TextBox2=9596%2Cyq&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";


//$data="__VIEWSTATE=dDwyODE2NTM0OTg7Oz4%3D&txtUserName=1402040106&TextBox2=9596%2Cyq&txtSecretCode=wgse&RadioButtonList1=%D1%A7%C9%FA&Button1=&lbLanguage=&hidPdrs=&hidsc=";
echo $url;echo"<br>";
echo $data;echo"<br>";
$str=$jw->hs_jiaowu_curl($url,$data);echo"cs";
echo $str;echo"cs";

$url=$urls."xs_main.aspx?xh=$user";
$str=$jw->hs_jiaowu_curl($url);
echo $str;
$url=$urls."content.aspx";
$str=$jw->hs_jiaowu_curl($url);
echo $str;
$url=$urls."xskbcx.aspx?xh=$user&xm=%B3%C2%D8%B9%DB%DF&gnmkdm=N121603";
$str=$jw->hs_jiaowu_curl($url);
echo $str;
printf("<pre>%s</pre>\n",var_export( $cookie_file ,TRUE));

printf("<pre>%s</pre>\n",var_export( file_get_contents($cookie_file),TRUE));
?>