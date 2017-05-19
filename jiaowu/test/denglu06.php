<?php
class jw
{
	//松田教务系统curl函数
	function st_jiaowu_curl($url,$data = null,$cookie = null,$referer = null){

		global $cookie_file; 
		
		$ip_address="121.8.214.66";//ip地址

		$port="81";//端口
		
		$host=$ip_address.":".$port;
		
		$origin="http://".$host;
		
		$referers=$origin."/".$referer;
		
		$urls=$origin."/".$url;
		
		$headers=array (
			'Host'=>$host,
			'Connection'=>' keep-alive',
			'Content-Length'=>'80',
			'Cache-Control'=>'max-age=0',
			'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*//*;q=0.8',
			'Origin'=>$origin,
			'User-Agent'=>"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.154 Safari/537.36 LBBROWSER",
			'Content-Type'=>'application/x-www-form-urlencoded',
			'Referer'=>$referers,
			'Accept-Encoding'=>'gzip, deflate, sdch',
			'Accept-Language'=>'zh-CN,zh;q=0.8'
		);
		
		printf("<pre>%s</pre>\n",var_export( $headers ,TRUE));
		echo "urls=".$urls;echo"<br>";
		echo "urls=".$referers;echo"<br>";
		
		$ch = curl_init();// 启动一个CURL会话
		curl_setopt($ch, CURLOPT_URL, $urls);// 要访问的地址
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);// 获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//允许被抓取的链接跳转
		curl_setopt($ch, CURLOPT_HEADER, 1);
		if (!empty($data)){
			curl_setopt($ch, CURLOPT_POST, 1);// 发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//要传送的所有数据
		}
		if(!empty($cookie_file)) {
			if(!empty($cookie)) {
				curl_setopt($ch, CURLOPT_COOKIE, $cookie);
			} else {
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
			}
		} else {
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
		}
		$str=curl_exec($ch);// 执行一个curl会话
		

		
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

$jw = new jw();
	
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
$data="TextBox1=1402040106&TextBox2=9596%2Cyq&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";
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