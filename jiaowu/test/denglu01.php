<?php
$ip_address="121.8.214.66";//ip地址

$port="81";//端口

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

$cookie_file = tempnam('./temp','cookie'); 

$_w_count_date = date('Y/m/j');
$_w_last_rule_time = time();

//进入登录页面
$url=$url_default;	
$ch = curl_init();// 启动一个CURL会话
curl_setopt($ch, CURLOPT_URL, $url);// 要访问的地址
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);// 获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//允许被抓取的链接跳转
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
$str=curl_exec($ch);// 执行一个curl会话
curl_close($ch);// 关闭CURL会话
$str = mb_convert_encoding($str, 'UTF-8', 'gb2312');// 转码
echo $str;

//post登录帐号密码
$user="1402040106";
$pwd="9596,yq";
$data="TextBox1=1402040106&TextBox2=9596%2Cyq&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";
$url=$urls."default_vsso.aspx";
$ch = curl_init();// 启动一个CURL会话
curl_setopt($ch, CURLOPT_URL, $url);// 要访问的地址
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);// 获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//允许被抓取的链接跳转
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POST, 1);// 发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//要传送的所有数据
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
$str=curl_exec($ch);// 执行一个curl会话

//获取cookie
preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
printf("<pre>%s</pre>\n",var_export( $results ,TRUE));
$cookie_SessionId=$results[0][0];

curl_close($ch);// 关闭CURL会话
$str = mb_convert_encoding($str, 'UTF-8', 'gb2312');// 转码
echo $str;



//
$cookie=$cookie_SessionId;
$headers['Cookie']=$cookie;

$url=$urls."xs_main.aspx?xh=$user";
$ch = curl_init();// 启动一个CURL会话
curl_setopt($ch, CURLOPT_URL, $url);// 要访问的地址
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);// 获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//允许被抓取的链接跳转
curl_setopt($ch, CURLOPT_HEADER, 1);
//curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
$str=curl_exec($ch);// 执行一个curl会话



curl_close($ch);// 关闭CURL会话
$str = mb_convert_encoding($str, 'UTF-8', 'gb2312');// 转码
echo $str;



printf("<pre>%s</pre>\n",var_export( $headers ,TRUE));

//
$headers['Referer']="http://121.8.214.66:81/xs_main.aspx?xh=$user";

$url=$urls."content.aspx";
$ch = curl_init();// 启动一个CURL会话
curl_setopt($ch, CURLOPT_URL, $url);// 要访问的地址
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);// 获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//允许被抓取的链接跳转
curl_setopt($ch, CURLOPT_HEADER, 1);
$str=curl_exec($ch);// 执行一个curl会话

curl_close($ch);// 关闭CURL会话
$str = mb_convert_encoding($str, 'UTF-8', 'gb2312');// 转码
echo $str;

printf("<pre>%s</pre>\n",var_export( $headers ,TRUE));

//进入课表页面

$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";
$headers['Cookie']=$cookie;

$url=$urls."xskbcx.aspx?xh=$user&xm=%B3%C2%D8%B9%DB%DF&gnmkdm=N121603";
$ch = curl_init();// 启动一个CURL会话
curl_setopt($ch, CURLOPT_URL, $url);// 要访问的地址
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);// 获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//允许被抓取的链接跳转
curl_setopt($ch, CURLOPT_HEADER, 1);
//curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
$str=curl_exec($ch);// 执行一个curl会话

curl_close($ch);// 关闭CURL会话
$str = mb_convert_encoding($str, 'UTF-8', 'gb2312');// 转码
echo $str;

printf("<pre>%s</pre>\n",var_export( $headers ,TRUE));
?>