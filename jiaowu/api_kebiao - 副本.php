<?php
require '../config.php';
require '../class/wx.class.php';
require '../class/db.class.php';
require '../class/jw.class.php';



$wx = new wx();
$db = new db();
$jw = new jw();

define("TOKEN", "kebiao");//设置token

//$wx->checkSignature();//验证签名



$postObj = $wx->receiveMessage();//接受来自微信的消息
$openid = $postObj->FromUserName;//获取openid

//$openid="oywbks-82NnLffsUp8NRK8bbFv5c";

$sql = "SELECT * FROM sontan_jiaowu WHERE openid ='{$openid}'";
$row = $db->fetch($sql);
if(!empty($row)){//已绑定
 
	$cookie_file = tempnam('./temp','cookie');//这是一个全局变量 
	$cookie_SessionId="";

	$_w_count_date = date('Y/m/j');
	$_w_last_rule_time = time();
 
    $user=$row['user'];
    $pwd=$row['pwd'];
    
	$user_len=strlen($user);

	if($user_len==10) {//本科
	
		//进入登录页面
		$url="default_vsso.htm";
		$referer=$url;
		$str = $jw->st_jiaowu_curl($url,$data = null,$cookie = null,$referer);
		//preg_match('/密码/', $str, $matches);
		if($str != false){//教务系统没有崩溃
			
			//进入学生主页
			$data="TextBox1=$user&TextBox2=$pwd&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";

			$url="default_vsso.aspx";
			$referer="default_vsso.htm";
			$str=$jw->st_jiaowu_curl($url,$data,$cookie = null,$referer);
			if($str == false) {
				goto die_bengke;
			}
			preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
			$cookie_SessionId=$results[0][0];
			//printf("<pre>%s</pre>\n",var_export( $results ,TRUE));
			$cookie=$cookie_SessionId;
			preg_match('/<span id="xhxm">(?<xhxm>.*?)同学<\/span>/i', $str, $matches);
			$name=$matches['xhxm'];
			if(!empty($name)){//登录成功
				//进入课表页面
				$cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";
				$url="xskbcx.aspx?xh=$user&xm=$name&gnmkdm=N121603";
				$referer="xs_main.aspx?xh=$user";
				$str=$jw->st_jiaowu_curl($url,$data = null,$cookie,$referer);
				if($str == false) {
					goto die_bengke;
				}
				
				
				
				$pattern = '/<table id="Table1" class="blacktab" bordercolor="Black" border="0" width="100%">[\s\S]*?<\/table>/i';//选取表格table
				preg_match($pattern, $str, $matches);

				$td=$jw->get_kb_array($matches[0]);
				
				if(!empty($td)) {
				
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

					$content=array();
					$content[] = array(
						"Title"=>"课表",
						"Description"=>"$kebiao\n课表以教务系统为准",
						"PicUrl"=>"",
						"Url"=>""   
					);
				
				} else {
					$content=array();
					$content[] = array(
						"Title"=>"课表获取失败",
						"Description"=>"教务系统没有课表数据",
						"PicUrl"=>"",
						"Url"=>""   
					);
				}
			}else{//输出登录失败的提示
				$content=array();
				$content[] = array(
					"Title"=>"课表获取失败\n请重新绑定学号",
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
	
		$content=array();
		$content[] = array(
			"Title"=>"课表获取失败",
			"Description"=>"教务系统没有课表数据",
			"PicUrl"=>"",
			"Url"=>""   
		);
	
	}
    
    
    
}else{//未绑定就输出绑定页面
    
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