<?php
class jw
{
	//松田本科教务系统curl函数
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
		
		//printf("<pre>%s</pre>\n",var_export( $headers ,TRUE));
		//echo "urls=".$urls;echo"<br>";
		//echo "urls=".$referers;echo"<br>";
		
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

	//松田专科教务系统curl函数
	function st2_jiaowu_curl($url,$data = null,$cookie = null,$referer = null){

		global $cookie_file; 
		
		$ip_address="jwxt.sontanedu.cn";//ip地址

		$port="80";//端口
		
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
		
		//printf("<pre>%s</pre>\n",var_export( $headers ,TRUE));
		//echo "urls=".$urls;echo"<br>";
		//echo "urls=".$referers;echo"<br>";
		
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
echo $jw->st2_jiaowu_curl($url,$data = null,$cookie = null,$referer);



//post登录帐号密码

$user="201502020146";
$pwd="aa142536";
$data="TextBox1=201502020146&TextBox2=aa142536&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";
$url="default_vsso.aspx";
$referer="default_vsso.htm";
echo $str=$jw->st2_jiaowu_curl($url,$data,$cookie = null,$referer);

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
echo $str=$jw->st2_jiaowu_curl($url,$data = null,$cookie,$referer);

$pattern = '/<table class="formlist" width="100%" align="center">[\s\S]*?<\/table>/i';//选取表格table
preg_match($pattern, $str, $matches);
$temp = strtolower($matches[0]);//该函数将传入的字符串参数所有的字符都转换成小写
$xsgrxx=$jw->get_td_array($temp);
printf("<pre>%s</pre>\n",var_export( $xsgrxx ,TRUE));

echo json_encode($xsgrxx,JSON_UNESCAPED_UNICODE);


//进入成绩页面
$referer="xscjcx.aspx?xh=$user&xm=$name&gnmkdm=N121605";
$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";
$url="xscjcx.aspx?xh=$user&xm=$name&gnmkdm=N121605";
echo $str=$jw->st2_jiaowu_curl($url,$data = null,$cookie,$referer);

$pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/i';
preg_match($pattern, $str, $matches);
$newview = urlencode($matches[1]);

//<input type="hidden" name="__VIEWSTATE" value="" />



$data="__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=$newview&ddlXN=&ddlXQ=&ddl_kcxz=&btn_zcj=%C0%FA%C4%EA%B3%C9%BC%A8";
$url="xscjcx.aspx?xh=$user&xm=$name&gnmkdm=N121605";
echo $str=$jw->st2_jiaowu_curl($url,$data,$cookie,$referer);


$pattern = '/<table class="datelist" cellspacing="0" cellpadding="3" border="0" id="Datagrid1" style="DISPLAY:block">[\s\S]*?<\/table>/i';
preg_match($pattern, $str, $matches);	    
$r = $jw->get_td_array($matches[0]);
printf("<pre>%s</pre>\n",var_export( $r ,TRUE));
$size=sizeof($r);
$xuenian=$r[1][0];//学年
$xueqi=$r[1][1];//学期

$shuchu="--- $xuenian 学年 第 $xueqi 学期 ---\n\n";
$fd="--";
$hh="\n";  
$zongjd=0;
$pingjunjd=0;
$zongfen=0;
$all_gpa=0;
$all_zongfen=0;
$j=0;
for($i=1;$i<$size;$i++){
	if($r[$i][0]==$xuenian&&$r[$i][1]==$xueqi){   
		$j++;
		$xuenian=$r[$i][0];//学年
		$xueqi= $r[$i][1];//学分
		$ke=$r[$i][3];//课程
		$xf=$r[$i][6];//学分
		$jd=$r[$i][7];//绩点
		$fs=$r[$i][8];//分数
		$zongjd=$zongjd+$jd;
		$gpa=$gpa+($jd*$xf);
		$zongxf=$zongxf+$xf;
		$shuchu=$shuchu.$ke.$fd.$jd.$fd.$fs.$hh;
	}else{
		$xuenian=$r[$i][0];//学年
		$xueqi= $r[$i][1];//学分
		
		//平均绩点
		$pingjunjd=$zongjd/$j;
		$pingjunjd=round($pingjunjd, 2);
		
		//学分绩点
		$xfjd=$gpa/$zongxf;
		$xfjd=round($xfjd, 2);
		
		$shuchu=$shuchu."\n";
		$shuchu=$shuchu."本学期平均绩点：".$pingjunjd."\n";
		$shuchu=$shuchu."本学期学分绩点：".$xfjd."\n\n";
		$shuchu=$shuchu."--- $xuenian 学年 第 $xueqi 学期 ---\n\n";
		
		$j=0;
		$gpa=0;
		$zongjd=0;
		$zongxf=0;
		$i=$i-1;
		continue;
		
	}
	$all_jidian=$all_jidian+$jd=$r[$i][7];
	$all_gpa=$all_gpa+($r[$i][7]*$r[$i][6]);
	$all_zongfen=$all_zongfen+$r[$i][6];
}


//平均绩点
$pingjunjd=$zongjd/$j;
$pingjunjd=round($pingjunjd, 2);

//学分绩点
$xfjd=$gpa/$zongxf;
$xfjd=round($xfjd, 2);

$shuchu=$shuchu."\n";
$shuchu=$shuchu."本学期平均绩点：".$pingjunjd."\n";
$shuchu=$shuchu."本学期学分绩点：".$xfjd."\n\n";
//$shuchu=$shuchu."--- $xuenian 学年 第 $xueqi 学期 ---\n\n";


$all_pingjunjd=$all_jidian/$i;
$all_pingjunjd=round($all_pingjunjd, 2);

$all_gpa=$all_gpa/$all_zongfen;
$all_gpa=round($all_gpa, 2);




//$shuchu=$shuchu."\n本学期平均绩点：".$pingjunjd."\n本学期学分绩点：".$gpa."\n【全部学年】总学分绩点：".$all_gpa."\nGPA=Σ（课程绩点*课程学分）/Σ课程学分";
$shuchu=$shuchu."【全部学年】\n总平均绩点：".$all_pingjunjd."\n总学分绩点：".$all_gpa."\n平均绩点=Σ课程绩点/课程数量\n学分绩点=Σ(课程绩点*课程学分)/Σ课程学分";
echo $shuchu;
?>