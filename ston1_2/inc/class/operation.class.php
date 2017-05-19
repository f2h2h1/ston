<?php
class operation extends database {
    //获取微信token参数
    public function getWechatParameter($str) {
        $parameter = explode("&", $str);
        for ($i = 1; $i < count($parameter); $i++) {
            $tempGET = explode("=", $parameter[$i]);
            $_GET[$tempGET[0]] = $tempGET[1];
        }
    }

    public function wechatApi($str) {
        //获取微信token参数
        self::getWechatParameter($str);
        //设置token
        define("TOKEN", "chengji");
        //接收来自微信的消息
        $postObj = self::receiveMessage();
        //token验证
        if (!isTOKEN or self::checkSignature()) {//通过token验证
            $openid = $postObj->FromUserName;//获取openid
            //判断openid是否为空
            if (!empty($openid)) {//openid不为空
                //判断数据库连接是否成功
                $state = parent::init();
                if ($state['state'] == 1) {//数据库连接成功
                    //判断该openid是否已绑定
                    $sql = "SELECT user,pwd FROM `".DB_TABLE."` where `openid` = ?;";
                    $state = parent::sqlSelect($sql, $openid);
                    if ($state['state'] == 1) {//sql语句执行成功
                        if ($state['msg'] == false) {//该openid未绑定
                            $result = array(
                                "state" => 2,
                                "msg" => "The user is not bound",
                            );
                        } else {////该openid已绑定
                            $result = array(
                                "state" => 1,
                                "msg" => "The user is bound",
                                "username" => $state['msg']['user'],
                                "password" => $state['msg']['pwd'],
                            );
                        }
                    } else {//sql语句执行失败
                        $content = "sql语句执行失败";
                        $result = array(
                            "state" => -1,
                            "msg" => self::transmitText($postObj, $content),
                            "errormsg" => $state,
                            "errorcode" => "501",
                        );
                    }
                } else {//数据库连接失败
                    $content = "数据库连接失败";
                    $result = array(
                        "state" => -2,
                        "msg" => self::transmitText($postObj, $content),
                        "errormsg" => $state,
                        "errorcode" => "502",
                    );
                }
            } else {//openid为空
                $content = "openid为空";
                $result = array(
                    "state" => -3,
                    "msg" => self::transmitText($postObj, $content),
                    "errormsg" => "",
                    "errorcode" => "503",
                );
            }
        } else {//未通过token验证
            $content = "token验证失败";
            $result = array(
                "state" => -4,
                "msg" => self::transmitText($postObj, $content),
                "errormsg" => "Not verified by token",
                "errorcode" => "504",
            );
        }
        $result["postObj"] = $postObj;
        return $result;
    }
    
    //判断用户密码是否正确 本科
    public function isLegal($username, $password) {
		
        $host = JW_HOST."default_vsso.htm";
        $data = null;
        $headers = null;
        $result = parent::httpRequest($host, $data, $headers);

        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');

			$host = JW_HOST."default_vsso.aspx";
			
            $data = "TextBox1=".$username."&TextBox2=".$password."&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";
            $data_size = strlen($data);

			// $headers = array (
				// 'Host: '.JW_HOST,
				// 'Connection: keep-alive',
				// 'Content-Length: '.$data_size,
				// 'Cache-Control: max-age=0',
				// 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
				// 'Origin: '.JW_HOST,
				// 'Upgrade-Insecure-Requests: 1',
				// 'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
				// 'Content-Type: application/x-www-form-urlencoded',
				// 'Referer: '.JW_HOST.'default_vsso.htm',
				// 'Accept-Encoding: gzip, deflate',
				// 'Accept-Language: zh-CN,zh;q=0.8',
			// );

            $result = self::httpRequest($host, $data);

            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
            preg_match('/密码/', $str, $matches);
            if (empty($matches)) {//登录成功
		
				preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
				$cookie=$results[0][0];

				$host = JW_HOST."xs_main.aspx?xh=".$username;
				$data = null;
				// $headers = array (
					// 'Host: '.JW_HOST,
					// 'Connection: keep-alive',
					// 'Cache-Control: max-age=0',
					// 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
					// 'Upgrade-Insecure-Requests: 1',
					// 'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
					// 'Referer: '.JW_HOST.'default_vsso.htm',
					// 'Accept-Encoding: gzip, deflate',
					// 'Accept-Language: zh-CN,zh;q=0.8',
					// 'Cookie: '.$cookie,
				// );
				$headers = array ('Cookie: '.$cookie,);

				$result = self::httpRequest($host, $data, $headers);

				if ($result['state'] == 1) {//进入学生主页成功
					$str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
					//抓取姓名
					preg_match('/<span id="xhxm">(?<xhxm>.*?)同学<\/span>/i', $str, $matches);
					$name=$matches['xhxm'];
					if(!empty($name)){//登录成功
						$result = array(
							"state" => 1,
							"msg" => "Login success",
							"cookie" => $cookie,
							"xhxm" => $name,
						);
					} else {//登录失败
						$result = array(
							"state" => -5,
							"msg" => "Login failed",
							"errmsg" => "xhxm is empty",
							"errcode" => "605",
						);	
					}
				} else {//进入学生主页失败
					$result = array(
						"state" => -4,
						"msg" => "Login failed",
						"errmsg" => "xs_main.aspx.aspx open failed",
						"errcode" => "604",
					);	
				}
            } else {//密码错误或教务系统打开失败
                $result = array(
                    "state" => -3,
                    "msg" => "Login failed",
                    "errmsg" => "password is wrong or Default2.aspx open failed",
                    "errcode" => "603",
                );
            }
        } else {//教务系统打开失败
            $result = array(
                "state" => -1,
                "msg" => "Login failed",
                "errmsg" => "default_vsso.htm open failed",
                "errcode" => "601",
            );
        }
        return $result;
    }
    //获取成绩数据 本科
    public function getGrade($username, $password) {
        $state = self::isLegal($username, $password);
        if ($state['state'] == 1) {//进入教务系统成功
            $cookie = $state['cookie'];
			$xhxm = $state['xhxm'];
			
			$host = JW_HOST."xscjcx.aspx?xh=".$username."&xm=".$xhxm."&gnmkdm=N121605";
			$headers = array ('Cookie: '.$cookie,);
			$data = null;
			$result = self::httpRequest($host, $data, $headers);
			$pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/i';
			preg_match($pattern, $result['msg'], $matches);
			$newview = urlencode($matches[1]);
			
            $host = JW_HOST."xscjcx.aspx?xh=".$username."&xm=".$xhxm."&gnmkdm=N121605";
            $data = "__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=".$newview."&hidLanguage=&ddlXN=&ddlXQ=&ddl_kcxz=&btn_zcj=%C0%FA%C4%EA%B3%C9%BC%A8";

			
            $result = self::httpRequest($host, $data, $headers);

            if ($result['state'] == 1) {
                $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
				
				$pattern = '/<table class="datelist" cellspacing="0" cellpadding="3" border="0" id="Datagrid1" style="DISPLAY:block">[\s\S]*?<\/table>/i';//选取成绩表格
				preg_match($pattern, $str, $matches);	       
                $r = self::get_td_array($matches[0]);
				
                if (is_array($r)) {
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

                    
                    $result = array(
                        "state" => 1,
                        "msg" => "success",
                        "output" => $shuchu,
                    ); 
                } else {
                    $result = array(
                        "state" => -7,
                        "msg" => "get grade failed",
                        "errmsg" => "grade is emtpy",
                        "errcode" => "607",
                    );
                }
            } else {
                $result = array(
                    "state" => -6,
                    "msg" => "get grade failed",
                    "errmsg" => "xscj.aspx open failed",
                    "errcode" => "606",
                );
            }
        } else {//进入教务系统失败
            $result = $state;
        }
        return $result;
    }
    //获取课表数据 本科&专科
    public function getSchoolTimetable($username, $password) {
		$user_len=strlen($username);
		if($user_len==10) {//本科
			$state = self::isLegal($username, $password);
			if ($state['state'] == 1) {//进入教务系统成功
				$cookie = $state['cookie'];

				$host = JW_HOST."xskbcx.aspx?xh=".$username."&xm=%C8%F8%BE%B2%CF%CD&gnmkdm=N121603";
				$data = null;
				$headers = array ('Cookie: '.$cookie,);
				$result = self::httpRequest($host, $data, $headers);

				if ($result['state'] == 1) {
					$str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
					//printf("<pre>%s</pre>\n",var_export($str, true));
					$pattern = '/<table id="Table1" class="blacktab" bordercolor="Black" border="0" width="100%">[\s\S]*?<\/table>/i';//选取表格table
					preg_match($pattern, $str, $matches);	       
					$td = self::get_kb_array($matches[0]);
					//printf("<pre>%s</pre>\n",var_export($kb, true));
					if (is_array($td)) {
					
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
						$shuchu="你本学期一周的课有：\n\n".trim($kebiao);
					
						$result = array(
							"state" => 1,
							"msg" => "success",
							"output" => $shuchu,
						); 
					} else {
						$result = array(
							"state" => -7,
							"msg" => "get grade failed",
							"errmsg" => "grade is emtpy",
							"errcode" => "607",
						);
					}
				} else {
					$result = array(
						"state" => -6,
						"msg" => "get grade failed",
						"errmsg" => "xscj.aspx open failed",
						"errcode" => "606",
					);
				}
			} else {//进入教务系统失败
				$result = $state;
			}
		} else {//专科
			$result = array(
				"state" => 1,
				"msg" => "success",
				"output" => "课表获取失败\n教务系统没有课表数据",
			);
		}
        return $result;
    }
    //获取考试数据 本科&专科
    public function getExamTimetable($username, $password) {
		$result = array(
			"state" => 1,
			"msg" => "success",
			"output" => "考试数据未更新，请于管理员联系",
		); 
        return $result;
    }
	
	//判断用户密码是否正确 专科
	public function isLegal2($username, $password) {
		$HOST = "http://121.8.214.107/";
        $host = $HOST."default_vsso.htm";
        $data = null;
        $headers = null;
        $result = parent::httpRequest($host, $data, $headers);

        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');

			$host = $HOST."default_vsso.aspx";

            $data = "TextBox1=".$username."&TextBox2=".$password."&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";
            $data_size = strlen($data);

            $result = self::httpRequest($host, $data);

            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
            preg_match('/密码/', $str, $matches);
            if (empty($matches)) {//登录成功
		
				preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
				$cookie=$results[0][0];

				$host = $HOST."xs_main.aspx?xh=".$username;
				$data = null;

				$headers = array ('Cookie: '.$cookie,);

				$result = self::httpRequest($host, $data, $headers);

				if ($result['state'] == 1) {//进入学生主页成功
					$str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
					//抓取姓名
					preg_match('/<span id="xhxm">(?<xhxm>.*?)同学<\/span>/i', $str, $matches);
					$name=$matches['xhxm'];
					if(!empty($name)){//登录成功
						$result = array(
							"state" => 1,
							"msg" => "Login success",
							"cookie" => $cookie,
							"xhxm" => $name,
						);
					} else {//登录失败
						$result = array(
							"state" => -5,
							"msg" => "Login failed",
							"errmsg" => "xhxm is empty",
							"errcode" => "605",
						);	
					}
				} else {//进入学生主页失败
					$result = array(
						"state" => -4,
						"msg" => "Login failed",
						"errmsg" => "xs_main.aspx.aspx open failed",
						"errcode" => "604",
					);	
				}
            } else {//密码错误或教务系统打开失败
                $result = array(
                    "state" => -3,
                    "msg" => "Login failed",
                    "errmsg" => "password is wrong or Default2.aspx open failed",
                    "errcode" => "603",
                );
            }
        } else {//教务系统打开失败
            $result = array(
                "state" => -1,
                "msg" => "Login failed",
                "errmsg" => "default_vsso.htm open failed",
                "errcode" => "601",
            );
        }
        return $result;
	}
	//获取成绩数据 专科
	public function getGrade2($username, $password) {
		$HOST = "http://121.8.214.107/";
        $state = self::isLegal2($username, $password);
        if ($state['state'] == 1) {//进入教务系统成功
            $cookie = $state['cookie'];
			$xhxm = $state['xhxm'];
			
			$host = $HOST."xscjcx.aspx?xh=".$username."&xm=".$xhxm."&gnmkdm=N121605";
			$headers = array ('Cookie: '.$cookie,);
			$data = null;
			$result = self::httpRequest($host, $data, $headers);
			$pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/i';
			preg_match($pattern, $result['msg'], $matches);
			$newview = urlencode($matches[1]);
			
            $host = $HOST."xscjcx.aspx?xh=".$username."&xm=".$xhxm."&gnmkdm=N121605";
            $data = "__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=".$newview."&hidLanguage=&ddlXN=&ddlXQ=&ddl_kcxz=&btn_zcj=%C0%FA%C4%EA%B3%C9%BC%A8";

			
            $result = self::httpRequest($host, $data, $headers);

            if ($result['state'] == 1) {
                $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
				
				$pattern = '/<table class="datelist" cellspacing="0" cellpadding="3" border="0" id="Datagrid1" style="DISPLAY:block">[\s\S]*?<\/table>/i';//选取成绩表格
				preg_match($pattern, $str, $matches);	       
                $r = self::get_td_array($matches[0]);
				
                if (is_array($r)) {
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

                    
                    $result = array(
                        "state" => 1,
                        "msg" => "success",
                        "output" => $shuchu,
                    ); 
                } else {
                    $result = array(
                        "state" => -7,
                        "msg" => "get grade failed",
                        "errmsg" => "grade is emtpy",
                        "errcode" => "607",
                    );
                }
            } else {
                $result = array(
                    "state" => -6,
                    "msg" => "get grade failed",
                    "errmsg" => "xscj.aspx open failed",
                    "errcode" => "606",
                );
            }
        } else {//进入教务系统失败
            $result = $state;
        }
        return $result;
	}
	
    //验证post参数
    public function validate($openid, $username, $password) {
    
        $result = array(
            "state" => 1,
            "msg" => "passed validation",
        );
    
        return $result;
    }
    
    //当前网页的URL
    public function getUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol.$_SERVER[HTTP_HOST].$_SERVER[SCRIPT_NAME];// 当前网页的URL
        $url = substr($url, 0, -9);
        return $url;
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
    //验证签名
    public function checkSignature()
    {
        $signature = $_GET["signature"];//微信加密签名
        $timestamp = $_GET["timestamp"];//时间戳
        $nonce = $_GET["nonce"];//随机数	
        $echoStr = $_GET["echostr"];//随机字符串
        
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if ($tmpStr == $signature) {
            if (!isset($echoStr)) {
                return true;
            } else {
                echo $echoStr;
                exit;
            }
        } else {
            //die("token验证失败");
            return false;
        }
    }
    
    //接收来自微信的消息
    public function receiveMessageStr()
    {
        return file_get_contents("php://input");
    }	
    public function receiveMessage()
    {
        $postStr = $this->receiveMessageStr();
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $postObj;
    }
    
    //回复文本消息
    public function transmitText($object, $content)
    {
        if (!isset($content) || empty($content)) {
            return "";
        }
        
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        
        return $result;
    }
    
    //回复图文消息
    public function transmitNews($object, $newsArray)
    {
        if (!is_array($newsArray)) {
            return "";
        }
        $itemTpl = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
        $item_str = "";
        foreach ($newsArray as $item) {
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>
$item_str    </Articles>
</xml>";
        
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

}