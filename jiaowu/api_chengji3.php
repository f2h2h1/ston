<?php
require '../config.php';
require '../class/wx.class.php';
require '../class/db.class.php';
require '../class/jw.class.php';


$wx = new wx();
//$db = new db();
$jw = new jw();

define("TOKEN", "chengji");//设置token

//$wx->checkSignature();//验证签名



$postObj = $wx->receiveMessage();//接受来自微信的消息
$openid = $postObj->FromUserName;//获取openid

//$openid="oBctks4MoH08fEfYrvD-q6TLLqMM";

//连接memcahce
$mem = new Memcache;
$mem->connect("127.0.0.1", 11211) or die ("Could not connect");

$cache = $mem->get($openid);
//print_r($cache);
if (!empty($cache)) {
    $content = $cache;
    //echo"cache";
    goto _cache;
}

$dataBaseConfig = array();
$dataBaseConfig['dataBaseHost'] = dataBaseHost;
$dataBaseConfig['dataBaseName'] = dataBaseName;
$dataBaseConfig['dataBaseServerPort'] = dataBaseServerPort;    
$dataBaseConfig['dataBaseUserName'] = dataBaseUserName;
$dataBaseConfig['dataBasePassWord'] = dataBasePassWord;

$dataSourceName="mysql:dbname={$dataBaseConfig['dataBaseName']};host={$dataBaseConfig['dataBaseHost']};port={$dataBaseConfig['dataBaseServerPort']}";
echo "cs1";
//连接数据库
$dbh = new PDO($dataSourceName, $dataBaseConfig['dataBaseUserName'], $dataBaseConfig['dataBasePassWord'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
$openid="oywbks-82NnLffsUp8NRK8bbFv5c";
$sql = "SELECT user,pwd FROM sontan_jiaowu WHERE openid ='{$openid}'";
$row = $dbh->query($sql)->fetch(PDO::FETCH_BOTH);
if(!empty($row)){//已绑定
echo "cs2";

	$cookie_file = tempnam('./temp','cookie');//这是一个全局变量 
	$cookie_SessionId="";

	$_w_count_date = date('Y/m/j');
	$_w_last_rule_time = time();
 
    $user=$row['user'];
    $pwd=$row['pwd'];
    
	$user_len=strlen($user);
echo "cs3";printf("<pre>%s</pre>\n",var_export($user_len, true));
	if($user_len==10) {//本科
	echo "cs4";
		//进入登录页面
		$url="default_vsso.htm";
		$referer=$url;
		$str = $jw->st_jiaowu_curl($url,$data = null,$cookie = null,$referer);echo "cs5";
		//preg_match('/密码/', $str, $matches);
		//printf("<pre>%s</pre>\n",var_export( $matches ,TRUE));
		if($str != false){//教务系统没有崩溃
			
			//进入学生主页
			$data="TextBox1=$user&TextBox2=$pwd&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";

			$url="default_vsso.aspx";
			$referer="default_vsso.htm";
			$str=$jw->st_jiaowu_curl($url,$data,$cookie = null,$referer);printf("<pre>%s</pre>\n",var_export($str, true));
			if($str == false) {
				goto die_bengke;
			}
			preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
			$cookie_SessionId=$results[0][0];
			printf("<pre>%s</pre>\n",var_export( $results ,TRUE));
			$cookie=$cookie_SessionId;
			preg_match('/<span id="xhxm">(?<xhxm>.*?)同学<\/span>/i', $str, $matches);
			$name=$matches['xhxm'];
			if(!empty($name)){//登录成功
            
				//进入成绩页面
				$referer="xscjcx.aspx?xh=$user&xm=$name&gnmkdm=N121605";
				$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";
				$url="xscjcx.aspx?xh=$user&xm=$name&gnmkdm=N121605";
				$str=$jw->st_jiaowu_curl($url,$data = null,$cookie,$referer);printf("<pre>%s</pre>\n",var_export($str, true));
				if($str == false) {
					goto die_bengke;
				}
				$pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/i';
				preg_match($pattern, $str, $matches);
				$newview = urlencode($matches[1]);
				$data="__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=$newview&hidLanguage=&ddlXN=&ddlXQ=&ddl_kcxz=&btn_zcj=%C0%FA%C4%EA%B3%C9%BC%A8";
				$str=$jw->st_jiaowu_curl($url,$data,$cookie,$referer);printf("<pre>%s</pre>\n",var_export($str, true));
				if($str == false) {
					goto die_bengke;
				}

				$pattern = '/<table class="datelist" cellspacing="0" cellpadding="3" border="0" id="Datagrid1" style="DISPLAY:block">[\s\S]*?<\/table>/i';
				preg_match($pattern, $str, $matches);	    
				$r = $jw->get_td_array($matches[0]);
				
				if(!empty($r)) {
				
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

					$content=array();
					$content[] = array(
						"Title"=>"成绩",
						"Description"=>"$shuchu",
						"PicUrl"=>"",
						"Url"=>""   
					);
                    
                    /*
                    $access_token=$wx->get_access_token();
                    $data = array(
                        'touser' => "$openid",
                        'msgtype' => "news",
                        'news' => array(
                            'articles' => array(
                                'title' => '成绩',
                                'description' => '...',
                                'url' => '',
                                'picurl' => ''
                            ),
                        )              
                    );
                    $data = json_encode($data);
                    $url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
                    $wx->https_request($url,$data);
                    */
                    //$mem->set($openid, $content, 800);
                
				} else {
					$content=array();
					$content[] = array(
						"Title"=>"成绩获取失败",
						"Description"=>"教务系统没有成绩数据",
						"PicUrl"=>"",
						"Url"=>""   
					);
				}
                
			}else{//输出登录失败的提示
				$content=array();
				$content[] = array(
					"Title"=>"成绩获取失败\n请重新绑定学号",
					"Description"=>"回复解绑，解除绑定\n回复绑定，绑定学号",
					"PicUrl"=>"",
					"Url"=>""   
				);
				
			}
			
		}else{//教务系统崩溃了
			
			die_bengke:
			
			$content=array();
			$content[] = array(
				"Title"=>"查询失败，系统繁忙",
				"Description"=>"查询失败，系统繁忙",
				"PicUrl"=>"",
				"Url"=>""   
			);
		}
		
    } else if($user_len==12) {//专科
	
		//进入登录页面
		$url="default_vsso.htm";
		$referer=$url;
		$str = $jw->st2_jiaowu_curl($url,$data = null,$cookie = null,$referer);
		//printf("<pre>%s</pre>\n",var_export( $str ,TRUE));
		//preg_match('/密码/', $str, $matches);
		if($str != false){//教务系统没有崩溃
			
			//进入学生主页
			$data="TextBox1=$user&TextBox2=$pwd&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";

			$url="default_vsso.aspx";
			$referer="default_vsso.htm";
			$str=$jw->st2_jiaowu_curl($url,$data,$cookie = null,$referer);
			
			if($str == false) {
				goto die_zhuanke;
			}
			
			preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
			$cookie_SessionId=$results[0][0];
			//printf("<pre>%s</pre>\n",var_export( $results ,TRUE));
			$cookie=$cookie_SessionId;
			preg_match('/<span id="xhxm">(?<xhxm>.*?)同学<\/span>/i', $str, $matches);
			$name=$matches['xhxm'];
			if(!empty($name)){//登录成功
				//进入成绩页面
				$referer="xscjcx.aspx?xh=$user&xm=$name&gnmkdm=N121605";
				$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";
				$url="xscjcx.aspx?xh=$user&xm=$name&gnmkdm=N121605";
				$str=$jw->st2_jiaowu_curl($url,$data = null,$cookie,$referer);
				if($str == false) {
					goto die_zhuanke;
				}
				$pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/i';
				preg_match($pattern, $str, $matches);
				$newview = urlencode($matches[1]);

				$data="__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=$newview&hidLanguage=&ddlXN=&ddlXQ=&ddl_kcxz=&btn_zcj=%C0%FA%C4%EA%B3%C9%BC%A8";
				$url="xscjcx.aspx?xh=$user&xm=$name&gnmkdm=N121605";
				$str=$jw->st2_jiaowu_curl($url,$data,$cookie,$referer);
				if($str == false) {
					goto die_zhuanke;
				}

				$pattern = '/<table class="datelist" cellspacing="0" cellpadding="3" border="0" id="Datagrid1" style="DISPLAY:block">[\s\S]*?<\/table>/i';
				preg_match($pattern, $str, $matches);	    
				$r = $jw->get_td_array($matches[0]);
				
				if(!empty($r)) {
				
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
					$shuchu="格式说明\n课程-绩点-分数\n\n".$shuchu."【全部学年】\n总平均绩点：".$all_pingjunjd."\n总学分绩点：".$all_gpa."\n平均绩点=Σ课程绩点/课程数量\n学分绩点=Σ(课程绩点*课程学分)/Σ课程学分";

					$content=array();
					$content[] = array(
						"Title"=>"成绩",
						"Description"=>"$shuchu",
						"PicUrl"=>"",
						"Url"=>""   
					);
                    
				
				} else {
					$content=array();
					$content[] = array(
						"Title"=>"成绩获取失败",
						"Description"=>"教务系统没有成绩数据",
						"PicUrl"=>"",
						"Url"=>""   
					);
				}
			}else{//输出登录失败的提示
				$content=array();
				$content[] = array(
					"Title"=>"成绩获取失败\n请重新绑定学号",
					"Description"=>"回复解绑，解除绑定\n回复绑定，绑定学号",
					"PicUrl"=>"",
					"Url"=>""   
				);
				
			}
			
		}else{//教务系统崩溃了
			
			die_zhuanke:
			
			$content=array();
			$content[] = array(
				"Title"=>"查询失败，系统繁忙",
				"Description"=>"查询失败，系统繁忙",
				"PicUrl"=>"",
				"Url"=>""   
			);
		}
	
	}
    
    $test_mamcache = $mem->set($openid, $content, 0, 800);
    

    
    $wx->send_custom_message_news($openid, $content);
    die();
                    
}else{//未绑定就输出绑定页面
    
    $content=array();
    $content[] = array(
        "Title"=>"您好，请先绑定学号",
        "Description"=>"点击绑定",
        "PicUrl"=>"",
        "Url"=>"http://chaotingcm.com/wechat/jiaowu/bangding.php?openid=$openid"   
    );
    
}

_cache:
$mem->close();
$resultStr = $wx->transmitNews($postObj,$content);
echo $resultStr;
?>