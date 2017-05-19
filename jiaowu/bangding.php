<?
//include('../limitWechatClient.php');//判断是否在微信客户端打开
require '../config.php';

require '../class/db.class.php';
$openid=$_GET['openid'];



$db = new db();

//
//<script src="../../js/jscys.js"></script>
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <script src="../../js/jzfx.js"></script>
           
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>绑定学号</title>
        <link rel="stylesheet" href="../../css/weui/example.css">
        <link rel="stylesheet" href="../../css/weui/weui.css">
    </head>
    <body>
        <div class="container js_container">
			<div class="page">
            <?
$sql = "SELECT * FROM sontan_jiaowu WHERE openid ='{$openid}'";
$row = $db->fetch($sql);
if(!empty($row)){
            ?>    
                <div class="hd">
                    <h1 class="page_title"style="font-size:25px;">绑定成功</h1>
                </div>
                <div class="bd">
                    <table style="margin:auto;">
                        <tr ><th>绑定成功</th></tr>
                        <tr align='left'><th>回复“课表” 获取课表</th></tr>
                        <tr align='left'><th>回复“考试” 获取考试地点安排</th></tr>  
                        <tr align='left'><th>回复“成绩” 获取学年成绩绩点</th></tr>      
                        <tr align='left'><th>回复“解绑” 解除或更换当前绑定账号</th></tr>                    
                    </table>
                </div>
            
            <?
}else{
            ?>    
                <div class="hd">
                    <h1 class="page_title"style="font-size:25px;">绑定学号</h1>
                </div>
                <div class="bd">
                    <form method="post"action="bangdingpanduan.php">
                        <div class="weui_cells weui_cells_form">
                            <div class="weui_cell">
                                <div class="weui_cell_hd"><label class="weui_label">
                                    学号
                                    </label></div>
                                <div class="weui_cell_bd weui_cell_primary">
                                    <input class="weui_input" placeholder="请输入学号" type="tel" value="" name="user"required="required"maxLength="12"pattern="^\d*$"title="请输入正确的学号">
                                </div>
                            </div>
                            <div class="weui_cell">
                                <div class="weui_cell_hd"><label class="weui_label">
                                    密码
                                    </label></div>
                                <div class="weui_cell_bd weui_cell_primary">
                                    <input class="weui_input" placeholder="请输入密码" type="password" value="" name="pwd" required="required"title="请输入密码">
                                </div>
                            </div>      
                        </div>
                        <div class="weui_btn_area">
                            <input value="<? echo $openid;?>" type="hidden" name="openid">
                            <button id="check-btn" class="weui_btn weui_btn_primary" type="submit">绑定</button> 
                        </div>
                    </form>
                </div>
            <?
}
            ?> 
			    <div class="weui_msg">
                    <div class="weui_extra_area" style="font-size:18px;">
                        <p>&copy;掌上松田</p>
                        <p>粤ICP备16026941号</p>
                    </div>
                </div>
			</div>
        </div>
    </body>
</html>