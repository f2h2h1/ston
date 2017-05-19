<?php
$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);//限制微信客户端打开
if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){//判断是否在微信客户端打开
    die("<h1>请在微信客户端中打开本链接</h1>");
}
?>