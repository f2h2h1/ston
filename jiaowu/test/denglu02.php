<?php
$ip_address="121.8.214.66";//ip地址

$port="81";//端口

$default="default_vsso.htm";

$urls="http://".$ip_address.":".$port."/";//用户登陆地址

$url_default=$urls.$default;

$cookie_SessionId="";

$ua="Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.154 Safari/537.36 LBBROWSER";

$headers=array (
	'Host'=>'121.8.214.66:81',
	'Connection'=>' keep-alive',
	'Content-Length'=>'80',
	'Cache-Control'=>'max-age=0',
	'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*//*;q=0.8',
	'Origin'=>'http://121.8.214.66:81',
	'User-Agent'=>"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.154 Safari/537.36 LBBROWSER",
	'Content-Type'=>'application/x-www-form-urlencoded',
	'Referer'=>'http://121.8.214.66:81/default_vsso.htm',
	'Accept-Encoding'=>'gzip, deflate',
	'Accept-Language'=>'zh-CN,zh;q=0.8',
	'Cookie'=>''
);

$cookie_file = tempnam('./temp','cookie'); 

$_w_count_date = date('Y/m/j');
$_w_last_rule_time = time();

//进入登录页面

$headers=array (
	'Host'=>'121.8.214.66:81',
	'Connection'=>' keep-alive',
	'Content-Length'=>'80',
	'Cache-Control'=>'max-age=0',
	'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*//*;q=0.8',
	'Origin'=>'http://121.8.214.66:81',
	'User-Agent'=>"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.154 Safari/537.36 LBBROWSER",
	'Content-Type'=>'application/x-www-form-urlencoded',
	'Referer'=>'http://121.8.214.66:81/default_vsso.htm',
	'Accept-Encoding'=>'gzip, deflate',
	'Accept-Language'=>'zh-CN,zh;q=0.8',
	'Cookie'=>''
);

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

//printf("<pre>%s</pre>\n",var_export( file_get_contents($cookie_file),TRUE));

//post登录帐号密码

$headers=array (
	'Host'=>'121.8.214.66:81',
	'Connection'=>' keep-alive',
	'Content-Length'=>'80',
	'Cache-Control'=>'max-age=0',
	'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*//*;q=0.8',
	'Origin'=>'http://121.8.214.66:81',
	'User-Agent'=>"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.154 Safari/537.36 LBBROWSER",
	'Content-Type'=>'application/x-www-form-urlencoded',
	'Referer'=>'http://121.8.214.66:81/default_vsso.htm',
	'Accept-Encoding'=>'gzip, deflate',
	'Accept-Language'=>'zh-CN,zh;q=0.8',
	'Cookie'=>''
);

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

printf("<pre>%s</pre>\n",var_export( file_get_contents($cookie_file),TRUE));

//

$headers=array (
	'Host'=>'121.8.214.66:81',
	'Connection'=>' keep-alive',
	'Content-Length'=>'80',
	'Cache-Control'=>'max-age=0',
	'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*//*;q=0.8',
	'Origin'=>'http://121.8.214.66:81',
	'User-Agent'=>"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.154 Safari/537.36 LBBROWSER",
	'Content-Type'=>'application/x-www-form-urlencoded',
	'Referer'=>'http://121.8.214.66:81/default_vsso.htm',
	'Accept-Encoding'=>'gzip, deflate, sdch',
	'Accept-Language'=>'zh-CN,zh;q=0.8',
	'Cookie'=>$cookie
);


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
curl_setopt($ch, CURLOPT_COOKIE, $cookie);
$str=curl_exec($ch);// 执行一个curl会话



curl_close($ch);// 关闭CURL会话
$str = mb_convert_encoding($str, 'UTF-8', 'gb2312');// 转码
echo $str;


printf("<pre>%s</pre>\n",var_export( file_get_contents($cookie_file),TRUE));
printf("<pre>%s</pre>\n",var_export( $headers ,TRUE));

//

$headers=array (
	'Host'=>'121.8.214.66:81',
	'Connection'=>' keep-alive',
	'Content-Length'=>'80',
	'Cache-Control'=>'max-age=0',
	'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*//*;q=0.8',
	'Origin'=>'http://121.8.214.66:81',
	'User-Agent'=>"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.154 Safari/537.36 LBBROWSER",
	'Content-Type'=>'application/x-www-form-urlencoded',
	'Referer'=>'http://121.8.214.66:81/xs_main.aspx?xh=$user',
	'Accept-Encoding'=>'gzip, deflate, sdch',
	'Accept-Language'=>'zh-CN,zh;q=0.8',
	'Cookie'=>$cookie
);


$headers['Referer']="http://121.8.214.66:81/xs_main.aspx?xh=$user";

$url=$urls."content.aspx";
$ch = curl_init();// 启动一个CURL会话
curl_setopt($ch, CURLOPT_URL, $url);// 要访问的地址
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);// 获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//允许被抓取的链接跳转
curl_setopt($ch, CURLOPT_HEADER, 1);
//curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
curl_setopt($ch, CURLOPT_COOKIE, $cookie);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$str=curl_exec($ch);// 执行一个curl会话

curl_close($ch);// 关闭CURL会话
$str = mb_convert_encoding($str, 'UTF-8', 'gb2312');// 转码
echo $str;

printf("<pre>%s</pre>\n",var_export( file_get_contents($cookie_file),TRUE));
printf("<pre>%s</pre>\n",var_export( $headers ,TRUE));

//进入课表页面

$headers=array (
	'Host'=>'121.8.214.66:81',
	'Connection'=>' keep-alive',
	'Content-Length'=>'80',
	'Cache-Control'=>'max-age=0',
	'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*//*;q=0.8',
	'Origin'=>'http://121.8.214.66:81',
	'User-Agent'=>"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.154 Safari/537.36 LBBROWSER",
	'Content-Type'=>'application/x-www-form-urlencoded',
	'Referer'=>'http://121.8.214.66:81/xs_main.aspx?xh=$user',
	'Accept-Encoding'=>'gzip, deflate, sdch',
	'Accept-Language'=>'zh-CN,zh;q=0.8',
	'Cookie'=>$cookie
);
$headers['Referer']="xscjcx.aspx?xh=1402040106&xm=%B3%C2%D8%B9%DB%DF&gnmkdm=N121605";
$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";
$headers['Cookie']=$cookie;

$data="__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=dDw2NDI3MTcwOTk7dDxwPGw8U29ydEV4cHJlcztzZmRjYms7ZGczO2R5YnlzY2o7U29ydERpcmU7eGg7c3RyX3RhYl9iamc7Y2pjeF9sc2I7enhjamN4eHM7PjtsPGtjbWM7XGU7YmpnO1xlO2FzYzsxNDAyMDQwMTA2O3pmX2N4Y2p0al8xNDAyMDQwMTA2OzswOz4%2BO2w8aTwxPjs%2BO2w8dDw7bDxpPDQ%2BO2k8MTA%2BO2k8MTk%2BO2k8MjQ%2BO2k8MzI%2BO2k8MzQ%2BO2k8MzY%2BO2k8Mzg%2BO2k8NDA%2BO2k8NDI%2BO2k8NDQ%2BO2k8NDY%2BO2k8NDg%2BO2k8NTI%2BO2k8NTQ%2BO2k8NTY%2BOz47bDx0PHQ8cDxwPGw8RGF0YVRleHRGaWVsZDtEYXRhVmFsdWVGaWVsZDs%2BO2w8WE47WE47Pj47Pjt0PGk8Mz47QDxcZTsyMDE1LTIwMTY7MjAxNC0yMDE1Oz47QDxcZTsyMDE1LTIwMTY7MjAxNC0yMDE1Oz4%2BOz47Oz47dDx0PHA8cDxsPERhdGFUZXh0RmllbGQ7RGF0YVZhbHVlRmllbGQ7PjtsPGtjeHptYztrY3h6ZG07Pj47Pjt0PGk8Nz47QDzlhazlhbHlv4Xkv67or7475YWs5YWx6YCJ5L%2Bu6K%2B%2BO%2BS4k%2BS4muW%2FheS%2FruivvjvkuJPkuJrpgInkv67or7475a6e6Le15pWZ5a2m546v6IqCO%2BivvuWkluWfueWFu%2BWtpuWIhjtcZTs%2BO0A8MDE7MDI7MDM7MDQ7MDU7MDY7XGU7Pj47Pjs7Pjt0PHA8cDxsPFZpc2libGU7PjtsPG88Zj47Pj47Pjs7Pjt0PHA8cDxsPFZpc2libGU7PjtsPG88Zj47Pj47Pjs7Pjt0PHA8cDxsPFZpc2libGU7PjtsPG88Zj47Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPFxlOz4%2BOz47Oz47dDxwPHA8bDxUZXh0O1Zpc2libGU7PjtsPOWtpuWPt%2B%2B8mjE0MDIwNDAxMDY7bzx0Pjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDtWaXNpYmxlOz47bDzlp5PlkI3vvJrpmYjmr5PlnLs7bzx0Pjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDtWaXNpYmxlOz47bDzlrabpmaLvvJrnrqHnkIblrabns7s7bzx0Pjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDtWaXNpYmxlOz47bDzkuJPkuJrvvJo7bzx0Pjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDtWaXNpYmxlOz47bDzotKLliqHnrqHnkIY7bzx0Pjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDs%2BO2w85LiT5Lia5pa55ZCROuS8geS4mui0ouWKoeeuoeeQhjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDtWaXNpYmxlOz47bDzooYzmlL%2Fnj63vvJoxNOi0ouWKoeeuoeeQhu%2B8iDHvvInnj607bzx0Pjs%2BPjs%2BOzs%2BO3Q8QDA8cDxwPGw8VmlzaWJsZTs%2BO2w8bzxmPjs%2BPjs%2BOzs7Ozs7Ozs7Oz47Oz47dDw7bDxpPDE%2BO2k8Mz47aTw1PjtpPDc%2BO2k8OT47aTwxMz47aTwxNT47aTwxOT47aTwyMT47aTwyMj47aTwyMz47aTwyNT47aTwyNz47aTwyOT47aTwzMT47aTwzMz47aTw0MT47aTw0Nz47aTw0OT47aTw1MD47PjtsPHQ8cDxwPGw8VmlzaWJsZTs%2BO2w8bzxmPjs%2BPjs%2BOzs%2BO3Q8QDA8cDxwPGw8VmlzaWJsZTs%2BO2w8bzxmPjs%2BPjtwPGw8c3R5bGU7PjtsPERJU1BMQVk6bm9uZTs%2BPj47Ozs7Ozs7Ozs7Pjs7Pjt0PDtsPGk8MTM%2BOz47bDx0PEAwPDs7Ozs7Ozs7Ozs%2BOzs%2BOz4%2BO3Q8cDxwPGw8VGV4dDtWaXNpYmxlOz47bDzoh7Pku4rmnKrpgJrov4for77nqIvmiJDnu6nvvJo7bzx0Pjs%2BPjs%2BOzs%2BO3Q8QDA8cDxwPGw8UGFnZUNvdW50O18hSXRlbUNvdW50O18hRGF0YVNvdXJjZUl0ZW1Db3VudDtEYXRhS2V5czs%2BO2w8aTwxPjtpPDQ%2BO2k8ND47bDw%2BOz4%2BO3A8bDxzdHlsZTs%2BO2w8RElTUExBWTpibG9jazs%2BPj47Ozs7Ozs7Ozs7PjtsPGk8MD47PjtsPHQ8O2w8aTwxPjtpPDI%2BO2k8Mz47aTw0Pjs%2BO2w8dDw7bDxpPDA%2BO2k8MT47aTwyPjtpPDM%2BO2k8ND47aTw1Pjs%2BO2w8dDxwPHA8bDxUZXh0Oz47bDxXSzAwMDU7Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPOWIm%2BaWsOWIm%2BS4mjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDs%2BO2w85YWs5YWx6YCJ5L%2Bu6K%2B%2BOz4%2BOz47Oz47dDxwPHA8bDxUZXh0Oz47bDwyLjA7Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPDAuMDs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDs%2BO2w8Jm5ic3BcOzs%2BPjs%2BOzs%2BOz4%2BO3Q8O2w8aTwwPjtpPDE%2BO2k8Mj47aTwzPjtpPDQ%2BO2k8NT47PjtsPHQ8cDxwPGw8VGV4dDs%2BO2w8VzBGNTA5Oz4%2BOz47Oz47dDxwPHA8bDxUZXh0Oz47bDzliJvkuJrliJvmlrDpooblr7zlips7Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPOWFrOWFsemAieS%2Fruivvjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDs%2BO2w8Mi4wOz4%2BOz47Oz47dDxwPHA8bDxUZXh0Oz47bDw1OC4yOz4%2BOz47Oz47dDxwPHA8bDxUZXh0Oz47bDwmbmJzcFw7Oz4%2BOz47Oz47Pj47dDw7bDxpPDA%2BO2k8MT47aTwyPjtpPDM%2BO2k8ND47aTw1Pjs%2BO2w8dDxwPHA8bDxUZXh0Oz47bDxXT0U1MDk7Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPOS6uuWKm%2Bi1hOa6kOaLm%2BiBmOS4jumAieaLlDs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDs%2BO2w85YWs5YWx6YCJ5L%2Bu6K%2B%2BOz4%2BOz47Oz47dDxwPHA8bDxUZXh0Oz47bDwyLjA7Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPDQ3LjM7Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPCZuYnNwXDs7Pj47Pjs7Pjs%2BPjt0PDtsPGk8MD47aTwxPjtpPDI%2BO2k8Mz47aTw0PjtpPDU%2BOz47bDx0PHA8cDxsPFRleHQ7PjtsPDAyMzAzRjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDs%2BO2w85Lit57qn6LSi5Yqh5Lya6K6h5a2mKDIpOz4%2BOz47Oz47dDxwPHA8bDxUZXh0Oz47bDzkuJPkuJrlv4Xkv67or747Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPDQuMDs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDs%2BO2w8NTE7Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPCZuYnNwXDs7Pj47Pjs7Pjs%2BPjs%2BPjs%2BPjt0PEAwPHA8cDxsPFZpc2libGU7PjtsPG88Zj47Pj47cDxsPHN0eWxlOz47bDxESVNQTEFZOm5vbmU7Pj4%2BOzs7Ozs7Ozs7Oz47Oz47dDxAMDxwPHA8bDxWaXNpYmxlOz47bDxvPGY%2BOz4%2BO3A8bDxzdHlsZTs%2BO2w8RElTUExBWTpub25lOz4%2BPjs7Ozs7Ozs7Ozs%2BOzs%2BO3Q8QDA8Ozs7Ozs7Ozs7Oz47Oz47dDxAMDxwPHA8bDxWaXNpYmxlOz47bDxvPGY%2BOz4%2BO3A8bDxzdHlsZTs%2BO2w8RElTUExBWTpub25lOz4%2BPjs7Ozs7Ozs7Ozs%2BOzs%2BO3Q8QDA8cDxwPGw8VmlzaWJsZTs%2BO2w8bzxmPjs%2BPjtwPGw8c3R5bGU7PjtsPERJU1BMQVk6bm9uZTs%2BPj47Ozs7Ozs7Ozs7Pjs7Pjt0PEAwPHA8cDxsPFZpc2libGU7PjtsPG88Zj47Pj47Pjs7Ozs7Ozs7Ozs%2BOzs%2BO3Q8QDA8cDxwPGw8VmlzaWJsZTs%2BO2w8bzxmPjs%2BPjtwPGw8c3R5bGU7PjtsPERJU1BMQVk6bm9uZTs%2BPj47Ozs7Ozs7Ozs7Pjs7Pjt0PEAwPHA8cDxsPFZpc2libGU7PjtsPG88Zj47Pj47cDxsPHN0eWxlOz47bDxESVNQTEFZOm5vbmU7Pj4%2BOzs7Ozs7Ozs7Oz47Oz47dDxAMDw7QDA8OztAMDxwPGw8SGVhZGVyVGV4dDs%2BO2w85Yib5paw5YaF5a65Oz4%2BOzs7Oz47QDA8cDxsPEhlYWRlclRleHQ7PjtsPOWIm%2BaWsOWtpuWIhjs%2BPjs7Ozs%2BO0AwPHA8bDxIZWFkZXJUZXh0Oz47bDzliJvmlrDmrKHmlbA7Pj47Ozs7Pjs7Oz47Ozs7Ozs7Ozs%2BOzs%2BO3Q8cDxwPGw8VGV4dDtWaXNpYmxlOz47bDzmnKzkuJPkuJrlhbE5OOS6ujtvPGY%2BOz4%2BOz47Oz47dDxwPHA8bDxWaXNpYmxlOz47bDxvPGY%2BOz4%2BOz47Oz47dDxwPHA8bDxWaXNpYmxlOz47bDxvPGY%2BOz4%2BOz47Oz47dDxwPHA8bDxWaXNpYmxlOz47bDxvPGY%2BOz4%2BOz47Oz47dDxwPHA8bDxUZXh0Oz47bDxaRjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8SW1hZ2VVcmw7PjtsPC4vZXhjZWwvMTQwMjA0MDEwNi5qcGc7Pj47Pjs7Pjs%2BPjt0PDtsPGk8Mz47PjtsPHQ8QDA8Ozs7Ozs7Ozs7Oz47Oz47Pj47Pj47Pj47Pg%3D%3D&hidLanguage=&ddlXN=&ddlXQ=&ddl_kcxz=&btn_zcj=%C0%FA%C4%EA%B3%C9%BC%A8";

$url=$urls."xscjcx.aspx?xh=1402040106&xm=%B3%C2%D8%B9%DB%DF&gnmkdm=N121605";
$ch = curl_init();// 启动一个CURL会话
curl_setopt($ch, CURLOPT_URL, $url);// 要访问的地址
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);// 获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//允许被抓取的链接跳转
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POST, 1);// 发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//要传送的所有数据
//curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
curl_setopt($ch, CURLOPT_COOKIE, $cookie);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$str=curl_exec($ch);// 执行一个curl会话

curl_close($ch);// 关闭CURL会话
$str = mb_convert_encoding($str, 'UTF-8', 'gb2312');// 转码
echo $str;

printf("<pre>%s</pre>\n",var_export( file_get_contents($cookie_file),TRUE));
printf("<pre>%s</pre>\n",var_export( $headers ,TRUE));
?>