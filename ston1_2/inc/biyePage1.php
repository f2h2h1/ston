<!DOCTYPE html>
<html>    
    <head>
        <title>填写邀请函信息</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="http://7xopbl.com1.z0.glb.clouddn.com/example.css">
        <link rel="stylesheet" href="http://7xopbl.com1.z0.glb.clouddn.com/weui.css">

    </head>


    <!-- 基础文档模型 -->
    <body >

        <div class="hd">
            <h1 class="page_title">毕业邀请函</h1>
            <form method="post"action="<?php echo $url;?>">
                <div class="weui_cells_title">输入你的名字：</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input"  name="name" type="text">
                        </div>
                    </div>
                </div>


                <div class="weui_cells_title">输入寄语：</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" name="content" placeholder="输入寄语"style="height:145px">hello~可爱的我就要从广州大学松田学院毕业啦，真诚邀请你来参加我的毕业典礼。在我的生命中，一直庆幸有你，与你相遇，是我人生的一大幸运。这一次，我想与你分享我大学旅程的喜悦与怦然。人生就一次的毕业礼，我在等你。</textarea>
                        </div>
                    </div>
                </div>

                <div class="weui_cells_title">输入毕业照或毕业典礼时间：</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="date" name="time" value="">
                        </div>
                    </div>
                </div>

                <div class="weui_btn_area">
                    <input type="hidden"name="openid"value="<? echo $openid;?>">
                    <button id="check-btn" class="weui_btn weui_btn_primary" type="submit">提交</button>
                </div>
            </form>    
            <br>


                <div class="weui_extra_area" style="font-size:18px;">&copy;掌上松田</div>

        </div>




    </body>  
</html>