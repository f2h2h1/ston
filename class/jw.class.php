<?php
class jw
{
	//松田本科教务系统curl函数
	function st_jiaowu_curl($url,$data = null,$cookie = null,$referer = null){

		global $cookie_file; 
		
		// $ip_address="121.8.214.66";//ip地址
		$ip_address="http://jwxt.sontan.net/";//ip地址
		
		// $port="81";//端口
		
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
				curl_setopt($ch, CURLOPT_COOKIE, $cookie);//用于发送 cookie 变量
			} else {
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);//用于保存 cookie 到文件
			}
		} else {
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);//用于将保存的 cookie 文件发送出去
		}
		$str=curl_exec($ch);// 执行一个curl会话
		
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($http_status != 200) {
		 return false;
		}
		
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
		
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($http_status != 200) {
		 return false;
		}
		
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

?>