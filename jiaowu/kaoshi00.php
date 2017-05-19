<?php
require '../config.php';
require '../class/wx.class.php';
require '../class/jw.class.php';

class db {

    private $dbh = null;
    
    function init($dataBaseConfig = null) {
    
        $dataBaseConfig = array();
        $dataBaseConfig['dataBaseHost'] = dataBaseHost;
        $dataBaseConfig['dataBaseName'] = dataBaseName;
        $dataBaseConfig['dataBaseServerPort'] = dataBaseServerPort;    
        $dataBaseConfig['dataBaseUserName'] = dataBaseUserName;
        $dataBaseConfig['dataBasePassWord'] = dataBasePassWord;
        $dataSourceName="mysql:dbname={$dataBaseConfig['dataBaseName']};host={$dataBaseConfig['dataBaseHost']};port={$dataBaseConfig['dataBaseServerPort']}";
  
        try {// 创建连接
            $this->dbh = new PDO($dataSourceName, $dataBaseConfig['dataBaseUserName'], $dataBaseConfig['dataBasePassWord'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
            $result = array(
                "state" => 1,
                "msg" => "database success inint",
            );
        } catch(PDOException $e) {// 检测连接
            $result = array(
                "state" => -1,
                "msg" => "database failed inint",
                "errmsg" => array($e->getMessage(), $dataBaseConfig),
            );
        }
        return $result;
    }
    
    function sqlExce($sql, $parameter = null, $model = false, $all = false) {
        $result = array();
        if (!empty($this->dbh)) {
            if (!empty($sql)) {
                if(!is_array($parameter) && !empty($parameter)) {
                    $parameter = array($parameter);
                }
                if (!empty($parameter)) {
                    $sth = $this->dbh->prepare($sql);
                    $affectedRows = $sth->execute($parameter);
                } else {
                    $affectedRows = $this->dbh->exec($sql);
                }
                if ($affectedRows > 0) {
                    if ($model) {
                        if ($all) {
                            $row = $sth->fetchAll(PDO::FETCH_BOTH);
                        } else {
                            $row = $sth->fetch(PDO::FETCH_BOTH);
                        }
                    }
                    $result = array(
                        "state" => 1,
                        "msg" => $row,
                        "affectedRows" => $affectedRows,
                    );
                } else {
                    $result = array(
                        "state" => -3,
                        "msg" => $row,
                        "affectedRows" => $affectedRows,
                        "errormsg" => "a sql statement execution failed",
                    );
                }
            } else {
                $result = array(
                    "state" => -2,
                    "msg" => "sql is empty",
                    "sql" => $sql,
                    "parameter" => $parameter,
                );
            }
        } else {
            $result = array(
                "state" => -1,
                "msg" => "dbh is empty",
                "errormsg" => $this->dbh,
            );
        }
        return $result;
    }
    function sqlSelect($sql, $parameter = null) {
        return self::sqlExce($sql, $parameter, true, false);
    }
    function sqlSelectAll($sql, $parameter = null) {
        return self::sqlExce($sql, $parameter, true, true);
    }
    
}
function output_error($errcode = -99, $errmsg = "查询失败，系统繁忙") {
    $errmsg = $errmsg."\ncode:".$errcode;
    $content = array();
    $content[] = array(
        "Title" => "查询失败，系统繁忙",
        "Description" => $errmsg,
        "PicUrl" => "",
        "Url" => ""   
    );
    return $content;
}
$wx = new wx();
$db = new db();
$jw = new jw();

define("TOKEN", "kaoshi");//设置token

$postObj = $wx->receiveMessage();//接受来自微信的消息
$openid = $postObj->FromUserName;//获取openid
$content = array();//用于回复的数组
//判断openid是否为空
if (!empty($openid)) {//openid不为空
    //判断数据库连接是否成功
    $result = $db->init();
    if ($result['state'] == 1) {//数据库连接成功
        //判断数据库查询是否成功
        $sql = "SELECT user,pwd FROM sontan_jiaowu WHERE openid = ?";
        $sqlState = $db->sqlSelect($sql, $openid);
        if ($sqlState['state'] == 1) {//数据库查询成功
            //判断用户是否已经绑定
            if (!empty($sqlState['msg'])) {//已绑定
                $row = $sqlState['msg'];
                
            	$cookie_file = tempnam('./temp','cookie');//这是一个全局变量 
                $cookie_SessionId="";

                $_w_count_date = date('Y/m/j');
                $_w_last_rule_time = time();
             
                $user = $row['user'];
                $pwd = $row['pwd'];
                
                $user_len=strlen($user);
                //判断本科和专科
                if ($user_len == 10) {//本科
                
                    //进入登录页面
                    $url="default_vsso.htm";
                    $referer=$url;
                    $str = $jw->st_jiaowu_curl($url,$data = null,$cookie = null,$referer);
                    
                    if($str != false){//教务系统没有崩溃
                    
                        //进入主页
                        $data="TextBox1=$user&TextBox2=$pwd&RadioButtonList1_2=%D1%A7%C9%FA&Button1=";

                        $url="default_vsso.aspx";
                        $referer="default_vsso.htm";
                        $str=$jw->st_jiaowu_curl($url,$data,$cookie = null,$referer);
                        
                        if ($str != false) {//进入主页成功
                            //判断是否登录成功
                            preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
                            $cookie_SessionId=$results[0][0];
                            //printf("<pre>%s</pre>\n",var_export( $results ,TRUE));
                            $cookie=$cookie_SessionId;
                            preg_match('/<span id="xhxm">(?<xhxm>.*?)同学<\/span>/i', $str, $matches);
                            $name=$matches['xhxm'];
                            if(!empty($name)){//登录成功
                            
                                //进入考试页面
                                $referer="xskscx.aspx?xh=$user&xm=$name&gnmkdm=N121604";
                                $cookie=$cookie_SessionId." _w_count_date=$_w_count_date; _w_count_=1; _w_today_count=0; _w_last_rule_time=$_w_last_rule_time; _w_today_pop_count=1";
                                $url="xskscx.aspx?xh=$user&xm=$name&gnmkdm=N121604";
                                $str=$jw->st_jiaowu_curl($url,$data = null,$cookie,$referer);
                                if ($str != false) {//进入考试页面成功
                                    //选取表格
                                    $pattern = '/<table class="datelist" cellspacing="0" cellpadding="3" border="0" id="Datagrid1" width="100%">[\s\S]*?<\/table>/i';//选取表格table
                                    preg_match($pattern, $str, $matches);	    
                                    $r = $jw->get_td_array($matches[0]);

                                    if (!empty($r)) {//选取表格成功

                                        $size = sizeof($r);
                                        //判断考试信息是否存在
                                        if ($size > 1) {//考试信息存在
                                        
                                            //printf("<pre>%s</pre>\n",var_export($r, true));
                                            $br = "\n";
                                            $fd = "----------------------";
                                            for ($i = 1; $i < $size; $i++) {
                                                
                                                
                                                //print_r($r[$i][1]);echo"--";print_r($r[$i][3]);echo"--";print_r($r[$i][6]);echo"--";print_r($r[$i][4]);
                                                //echo"$br";
                                                
                                                $kemu = $r[$i][1];
                                                $shijian = $r[$i][3];
                                                $kaochang = $r[$i][4];
                                                $zuowei = $r[$i][6];
                                                
                                                
                                                $shuchu = $shuchu.$br.$kemu.$br.$shijian.$br."考室：".$kaochang.$br."座位号：".$zuowei.$br.$fd;
                                                
                                            }
                                            $content[] = array(
                                                "Title"=>"考试信息",
                                                "Description"=>"$shuchu",
                                                "PicUrl"=>"",
                                                "Url"=>"" 
                                            );
                                            //printf("<pre>%s</pre>\n",var_export($content, true));
                                        } else {//考试信息不存在
                                            $content[] = array(
                                                "Title"=>"查询失败",
                                                "Description"=>"考试信息未更新\n考试信息以教务系统为准",
                                                "PicUrl"=>"",
                                                "Url"=>""   
                                            );
                                        }                                    
                                    } else {//选取表格失败
                                        $content = output_error(-304);
                                    }
                                } else {//进入考试页面失败
                                    $content = output_error(-303);
                                }
                            } else {//登录失败
                                $content = output_error(-302, "请重新绑定学号\n回复解绑，解除绑定\n回复绑定，绑定学号");
                            }
                        } else {//进入主页失败
                            $content = output_error(-301);
                        }
                    } else {//教务系统崩溃了
                        $content = output_error(-300);
                    }
                } else if($user_len == 12) {//专科
                        $content = output_error(-300);
                } else {
                    $content = output_error(-400);
                }
            } else {//未绑定
                $content[] = array(
                    "Title"=>"您好，请先绑定学号",
                    "Description"=>"点击绑定",
                    "PicUrl"=>"",
                    "Url"=>"http://chaotingcm.com/wechat/jiaowu/bangding.php?openid=$openid"   
                );
            }
        } else {//数据库查询失败
            $content = output_error(-201);
        }
    } else {//连接数据库失败
        $content = output_error(-200);
    }
} else {//openid为空
    $content = output_error(-100);
}

_output:
$resultStr = $wx->transmitNews($postObj,$content);
echo $resultStr;