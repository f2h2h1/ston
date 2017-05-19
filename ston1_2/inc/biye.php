<?php
require CLASS_PATH.'wechat.class.php';
class biye extends wechat {
    public $parameter;
    public function __construct($parameter) {
        $this->parameter = $parameter;
    }

    public function wechatapi() {


        //接收来自微信的消息
        $postObj = parent::receiveMessage();
        $openid = $postObj->FromUserName;

        $url = self::getUrl()."?/biye/page1/".$openid;
        $content = "<a href=\"".$url."\">点此制作毕业邀请函</a>";
        $result = parent::transmitText($postObj, $content);

        return $result;
    }
    public function page1() {
        $url = self::getUrl()."?/biye/update/";
        $openid = $this->parameter[2];
        require APP_PATH.'biyePage1.php';
    }

    public function update() {

        $openid=$_POST['openid'];
        $name=$_POST['name'];
        $content=$_POST['content'];
        $time_biye=$_POST['time'];
        

        $state = parent::init();
        if ($state['state'] == 1) {//数据库连接成功
            $sql = "SELECT * FROM  `biye` ORDER BY id DESC";
            $state = parent::sqlSelect($sql, "id");
            if ($state['state'] == 1) {//sql语句执行成功
                $id = $state['msg']['id'];
                $id++;
                $sqlParameter = array(
                    ":id" => $id,
                    ":openid" => $openid,
                    ":name" => $name,
                    ":content" => $content,
                    ":time_biye" => $time_biye,
                );
                $sql = "insert `biye`(`id`, `openid`, `name`, `content`, `time_biye`) values(:id,:openid,:name,:content,:time_biye);";
                $state = parent::sqlSelect($sql, $sqlParameter);
                if ($state['state'] == 1) {//sql语句执行成功
                    $url = self::getUrl()."?/biye/page2/".$id;
                    echo "<script>location.href = '".$url."';</script>";
                } else {
                    $error = array(
                        "state" => -5,
                        "msg" => $state['msg'],
                    );
                    errorE::outputHtml($error);
                }
            } else {
                $error = array(
                    "state" => -4,
                    "msg" => $state['errormsg'],
                );
                errorE::outputHtml($error);
            }
        } else {
            $error = array(
                "state" => -3,
                "msg" => $state['msg'],
            );
            errorE::outputHtml($error);
        }
    }
    public function page2() {
        $id = $this->parameter[2];


        $state = parent::init();
        if ($state['state'] == 1) {//数据库连接成功
            $sql = "SELECT * FROM  `biye` WHERE `id` = ?;";
            $state = parent::sqlSelect($sql, $id);
            if ($state['state'] == 1) {//sql语句执行成功
                $row = $state['msg'];

                $name = $row['name'];
                $content = $row['content'];
                $time_biye = $row['time_biye'];
                $time = $row['time'];
                $time_biye = substr($time_biye,0,-9);
                $time = substr($time,0,-9);

                require APP_PATH.'biyePage2.php';

            } else {
                $error = array(
                    "sate" => -4,
                    "msg" => $state['msg'],
                );
                errorE::outputHtml($error);
            }
        } else {
            $error = array(
                "sate" => -3,
                "msg" => $state['msg'],
            );
            errorE::outputHtml($error);
        }
    }

    // 获取当前网页的URL
    public function getUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol.$_SERVER[HTTP_HOST].$_SERVER[SCRIPT_NAME];// 当前网页的URL
        $url = substr($url, 0, -9);
        return $url;
    }
}