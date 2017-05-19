        <?php
function curl_get($url)
{
    
    $refer = "http://music.163.com/";
    $header[] = "Cookie: " . "appver=1.5.0.75771;";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_REFERER, $refer);
    $output = curl_exec($ch);
    curl_close($ch);
    
    return $output;
}


function get_music_info($music_id)
{
    $url = "http://music.163.com/api/song/detail/?id=" . $music_id . "&ids=%5B" . $music_id . "%5D";
    
    return curl_get($url);
}

$play_info=json_decode(get_music_info("3190030"), true);

        ?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>
        <? echo $name;?>的毕业邀请函</title>
    <link type="text/css" rel="stylesheet" href="dgut_goodbye2.css">

    <script src="js/hm.js"></script>
    <script src="http://code.jquery.com/jquery-1.8.3.min.js" integrity="sha256-YcbK69I5IXQftf/mYD8WY0/KmEDCv1asggHpJk1trM8=" crossorigin="anonymous"></script>
    <script src="js/jquery.event.move.js"></script>
    <script src="js/jquery.event.swipe.js"></script>
    <script src="js/goodbyesysu.js"></script>
    <style>
        #shareBoxBg {
            display: none;
            z-index: 100;
            position: absolute;
            background: #000;
            width: 100%;
            height: 180%;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
            opacity: 0.7
        }
        
        #shareBox {
            display: none;
            right: 0;
            text-align: center;
            font-size: 18px;
            color: #fff;
            z-index: 1001;
            position: absolute;
            max-width: 320px;
            margin: 0 0 0 auto;
            width: 100%;
        }
        
        button {
            color: rgb(255, 255, 255);
            font: bold 14px Verdana, "微软雅黑", sans-serif;
            font-weight: 900;
            padding-top: 9px;
            padding-bottom: 9px;
            padding-left: 20px;
            padding-right: 20px;
            border-width: 0px;
            border-color: rgb(255, 255, 255);
            border-style: solid;
            border-radius: 8px;
            background-color: #339933;
            width: 200px;
            margin: 5px;
        }
    </style>
    <style>
        @charset "utf-8";
        html,
        body,
        div,
        span,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        samp,
        small,
        strong,
        b,
        i,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        table,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td,
        article,
        aside,
        footer,
        header,
        nav,
        section {
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: transparent;
        }
        
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block;
        }
        
        a:hover,
        a:active {
            outline: none;
        }
        
        select,
        input,
        textarea,
        button {
            font: 99% sans-serif;
        }
        
        input,
        select {
            vertical-align: middle;
        }
        
        ul,
        ol,
        li {
            list-style: none;
        }
        
        img {
            border: 0;
            max-width: 100%;
        }
        
        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #ccc;
            margin: 1em 0;
            padding: 0;
        }
        
        .nocallout {
            -webkit-touch-callout: none;
        }
        /* prevent callout */
        
        table {
            margin: 0;
            padding: 0;
            clear: left;
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        
        table td {
            vertical-align: top;
            margin: 0;
        }
        
        html {
            height: 100%;
        }
        
        body {
            font: 13px/1.4 sans-serif;
            *font-size: small;
            word-wrap: break-word;
            margin: 0 auto;
            -webkit-text-size-adjust: none;
            color: #3c3c3c;
            font-family: 'Helvetica Neue', Helvetica, Arial, Verdana, sans-serif;
            height: 100%;
        }
        
        a {
            color: #1191C3;
            text-decoration: none;
        }
        
        .bodyindex {
            background: #707070;
        }
        
        .pr {
            position: relative;
        }
        
        .pa {
            position: absolute;
        }
        
        .fx {
            position: fixed;
        }
        
        .tc {
            text-align: center;
        }
        
        .yel {
            color: #fcb314;
        }
        
        .tl {
            text-align: left;
        }
        
        .tc {
            text-align: center;
        }
        
        .tr {
            text-align: right;
        }
        
        .fl {
            float: left;
        }
        
        .fr {
            float: right;
        }
        
        .cf {
            clear: both;
        }
        
        .cur {
            cursor: pointer;
        }
        
        body {
            overflow: hidden;
            background: #085827;
        }
        
        #firstpage {
            height: 100%;
            background: url(http://i1.piimg.com/501024/0a8070efb5b93e2as.gif) #096d31 repeat center bottom;
            background-size: 100%;
            position: relative;
        }
        
        #secondpage {
            height: 100%;
            background: url(http://i1.piimg.com/501024/fe8a7aa99c1ef4f1.jpg) #096d31 repeat center bottom;
            background-size: 100%;
            position: relative;
        }
        
        #thirdpage {
            height: 100%;
            background: url(http://i1.piimg.com/501024/3e784e861cd2164a.jpg) #096d31 repeat center bottom;
            background-size: 100%;
            position: relative;
        }
        
        #fourpage {
            height: 100%;
            background: url(http://i4.buimg.com/501024/6f464631d080bc49.jpg) #096d31 repeat center bottom;
            background-size: 120%;
            position: relative;
        }
        
        .nextpage {
            display: block;
            background: url(http://ameiity-asd.stor.sinaapp.com/biye%2Fdgut_go.gif) no-repeat;
            width: 33px;
            height: 33px;
            background-size: 100% 100%;
            position: absolute;
            right: 15px;
            bottom: 15px;
            cursor: pointer;
            opacity: 0;
            z-index: 3;
        }
        
        .part01-first {
            left: 0;
            top: 0;
            width: 100%;
            text-align: center;
            opacity: 0;
            padding-top: 14px;
            height: 51px;
        }
        
        .part01-first img {
            margin: 0 auto;
        }
        
        .part02-first {
            left: 42px;
            top: 10px;
            opacity: 0;
        }
        
        .part03-first {
            left: 0;
            bottom: 94px;
            width: 100%;
            text-align: right;
            opacity: 0;
        }
        
        .part03-first img {
            margin-right: 26px;
        }
        
        .part04-first {
            left: 0;
            bottom: 150px;
            width: 100%;
            text-align: right;
            opacity: 0;
        }
        
        .part06-first {
            left: 42px;
            top: 70px;
            opacity: 0;
            position: absolute;
            z-index: 99
        }
        
        .part01-second {
            padding-top: 50px;
            margin-bottom: 18px;
            opacity: 0;
            font-size: 12px;
        }
        
        .grp01-second {
            margin: 0 30px;
            padding-bottom: 5px;
            text-align: left;
            color: #fff;
            line-height: 20px;
        }
        
        .grp01-second p {
            text-indent: 2em;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .grp01-second h3 {
            font-size: 14px;
            padding-bottom: 10px;
        }
        
        .grp02-second {
            width: 100%;
            text-align: right;
            color: #fff;
            padding-top: 10px;
        }
        
        .grp02-second p {
            margin-right: 30px;
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .grp03-second {
            margin: 0 30px;
            text-align: left;
            color: #fff;
            line-height: 20px;
        }
        
        .grp03-second a {
            padding-left: 8px;
        }
        
        .grp01-second,
        .grp02-second,
        .grp03-second {
            opacity: 0;
        }
        
        .part03-second {
            bottom: 50px;
            right: 0;
            opacity: 0;
        }
        
        .map {
            width: 110px;
            height: 110px;
            border: 3px solid #085827;
            border-radius: 55px;
        }
        
        .maptitle {
            margin-bottom: 5px;
            margin-right: 4px;
        }
        
        .part01-third {
            padding-top: 10px;
            padding-left: 24px;
        }
        
        .part01-third p {
            margin-bottom: 30px;
            opacity: 0;
        }
        
        .part02-third {
            right: 2px;
            bottom: 168px;
            z-index: 10;
            opacity: 0;
        }
        
        .part03-third {
            left: 0;
            bottom: 80px;
            width: 100%;
            text-align: left;
        }
        
        .schedulein {
            margin-right: 28px;
            background: #085827;
        }
        
        .schedulebg {
            padding: 51px 0 15px 0;
            height: 67px;
        }
        
        .textbox {
            opacity: 0;
            position: absolute;
            width: 100%;
        }
        
        .textbox h4 {
            font-size: 15px;
            margin-bottom: 7px;
            color: #fff;
        }
        
        .textbox h4 strong {
            font-size: 21px;
            padding-right: 3px;
        }
        
        .intro em {
            padding-right: 3px;
        }
        
        .intro {
            line-height: 24px;
            color: #fff;
        }
        
        .schedule {
            cursor: pointer;
            margin-right: 12px;
            text-indent: -999em;
            outline: none;
            display: inline-block;
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_btn_schedular.png) no-repeat;
            width: 135px;
            height: 45px;
            background-size: 100% 100%;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }
        
        .messagebtn2 {
            cursor: pointer;
            text-indent: -999em;
            display: inline-block;
            outline: none;
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_btn_message.png) no-repeat;
            width: 135px;
            height: 45px;
            background-size: 100% 100%;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }
        
        .contacttable {
            cursor: pointer;
            display: inline-block;
            text-indent: -999em;
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_btn_contact.png) no-repeat;
            width: 135px;
            height: 45px;
            background-size: 100% 100%;
        }
        
        .schedulebox {
            height: 100%;
            position: absolute;
            overflow: hidden;
            left: 0;
            bottom: -200%;
            z-index: 12;
            width: 100%;
        }
        
        .schedule-inbox {
            margin: 11px 6px 0 6px;
            height: 100%;
            position: relative;
            background: #eee;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .header-schedule {
            height: 46px;
            font-size: 14px;
            text-align: center;
            font-weight: bold;
            color: #09471b;
            line-height: 46px;
        }
        
        .header-schedule h4 {
            font-weight: bold;
            font-size: 14px;
        }
        
        .close {
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_close.png) no-repeat;
            position: absolute;
            top: 14px;
            cursor: pointer;
            left: 12px;
            width: 16px;
            height: 16px;
            background-size: 100% 100%;
            display: block;
        }
        
        .timebox {
            height: 0;
            position: absolute;
            overflow: hidden;
            left: 0;
            bottom: 0;
            z-index: 12;
            width: 100%;
        }
        
        .close {
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_close.png) no-repeat;
            position: absolute;
            top: 14px;
            cursor: pointer;
            left: 12px;
            width: 16px;
            height: 16px;
            background-size: 100% 100%;
            display: block;
        }
        
        #wrapper {
            position: absolute;
            z-index: 1;
            top: 46px;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: auto;
        }
        
        #scroller {
            position: absolute;
            z-index: 1;
            width: 100%;
        }
        
        #scroller ul {
            width: 100%;
            text-align: center
        }
        
        .fold {
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_fold_icon.png) no-repeat;
            width: 22px;
            height: 133px;
            background-size: 100% 100%;
            right: 6px;
            bottom: 0;
        }
        
        .part01-four {
            bottom: 189px;
            text-align: center;
            width: 100%;
        }
        
        .part01-four img {
            margin: 0 auto;
            width: 0;
        }
        
        .back {
            bottom: 114px;
            width: 100%;
            opacity: 0;
        }
        
        .copyright {
            bottom: 74px;
            width: 100%;
            opacity: 0;
            font-size: 9px;
            color: #fff;
            position: absolute;
        }
        
        .copyright p {
            line-height: 18px;
        }
        
        .weixinlogo {
            position: absolute;
            left: -999em;
        }
        
        .ftbox {
            width: 100%;
            position: absolute;
            left: 0;
            bottom: 8px;
        }
        /*����*/
        
        .messagebg {
            background: #000;
            opacity: 0.8;
            left: 0;
            top: 0;
            position: absolute;
            display: none;
            height: 100%;
            width: 100%;
        }
        
        .messagebox {
            height: 100%;
            position: fixed;
            z-index: 20;
            overflow: hidden;
            left: 0;
            bottom: -200%;
            width: 100%;
        }
        
        .messicon {
            display: block;
            z-index: 100;
            cursor: pointer;
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_mess_icon.png) no-repeat;
            width: 26px;
            height: 17px;
            background-size: 100% 100%;
            position: absolute;
            right: 15px;
            top: 15px;
        }
        
        .closemess {
            display: block;
            cursor: pointer;
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_closemess.png) no-repeat;
            width: 16px;
            height: 16px;
            background-size: 100% 100%;
            position: absolute;
            left: 22px;
            top: 15px;
        }
        
        .areawrap {
            margin-right: 7px;
        }
        
        #wrapper2 {
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_topbg.png) no-repeat center top #eee;
            position: absolute;
            z-index: 13;
            top: 46px;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: auto;
        }
        
        #scroller2 {
            position: absolute;
            z-index: 1;
            width: 100%;
        }
        
        #scroller2 ul {
            width: 100%;
            text-align: center
        }
        
        .box01-message {
            margin: 0 12px;
            z-index: 14;
        }
        
        .messarea {
            width: 100%;
            height: 84px;
            text-align: left;
            border: 1px solid #fff;
            border: 1px solid #d0d0d0;
            border-radius: 5px;
            margin-top: 12px;
            margin-bottom: 8px;
            font-size: 14px;
            color: #999;
        }
        
        .sendbtn {
            display: block;
            border: none;
            text-indent: -999em;
            cursor: pointer;
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_sendbtn.png)no-repeat;
            width: 102px;
            height: 34px;
            background-size: 100% 100%;
            position: absolute;
            right: 0;
            top: 0;
        }
        
        .part01-message p {
            margin-right: 121px;
        }
        
        .part01-message .usertext {
            width: 100%;
            border: 1px solid #d0d0d0;
            height: 28px;
            line-height: 28px;
            line-height: normal;
            border-radius: 5px;
            text-indent: 8px;
        }
        
        .box02-message {
            margin: 0 10px;
            text-align: left;
        }
        
        .top-message {
            position: relative;
            height: 42px;
            line-height: 34px;
            border-bottom: 1px solid #d0d0d0;
            padding-top: 5px;
            border-bottom: 1px solid #d0d0d0;
        }
        
        .top-message strong {
            font-size: 15px;
            left: 38px;
            position: absolute;
            top: 14px;
        }
        
        .top-message span {
            color: #919191;
            right: 0;
            top: 14px;
        }
        
        .refresh {
            left: 0;
            top: 15px;
            cursor: pointer;
            display: block;
            position: absolute;
            width: 32px;
            height: 30px;
        }
        
        .grp-message {
            padding: 6px 0;
            color: #3d494f;
            border-bottom: 1px solid #d0d0d0;
        }
        
        .grp-message:last-child {
            border-bottom: none;
        }
        
        .arr01-message {
            height: 24px;
        }
        
        .arr01-message span {
            float: right;
            font-size: 10px;
            color: #d0d0d0;
            padding-top: 2px;
        }
        
        .arr01-message strong {
            color: #032510;
            font-size: 14px;
            display: block;
            width: 210px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        
        .arr02-message {
            clear: both;
        }
        
        .getmore {
            width: 100%;
            padding-bottom: 10px;
            cursor: pointer;
            padding-top: 5px;
        }
        
        .sendbtn_disabled {
            background: url(http://7xi4a6.com2.z0.glb.qiniucdn.com/dgut_post_disable.png) no-repeat;
            width: 102px;
            height: 34px;
            background-size: 100% 100%;
            cursor: ne-resize;
        }
        
        .newstip {
            padding: 6px 0;
            text-align: center;
        }
        
        @media screen and (min-width:1024px) {
            .page,
            .schedulebox,
            .messagebox {
                width: 640px;
                margin: 0 auto;
            }
            .schedulebox,
            .messagebox {
                left: 50%;
                margin-left: -320px;
            }
            body {
                background: none;
            }
        }
    </style>
</head>

<body>
    <div style="right:42px; top:70px;opacity:1;position:absolute;z-index:99">
        <audio id="music" src="a.mp3" autoplay="autoplay" preload="auto" loop="loop"></audio>
        <a id="audio_btn"><img src="pause.png" width="38" id="music_btn" border="0"></a>
    </div>
    <section class="page" id="firstpage">
        <!--<div class="part01-first pa" style="opacity: 1;">
                <img width="186" src="http://i4.buimg.com/501024/da58fb5c89fe34dc.png">
            </div>-->
        <div class="part02-first pa" style="opacity: 1;top:100px;">
            <img width="300" src="http://i1.piimg.com/501024/9413cc651ab16274.png">
        </div>
        <div id="touchgodown">
            <div class="part04-first pa" style="opacity: 1;">
                <img width="303" src="http://ameiity-asd.stor.sinaapp.com/biye%2Fdgut_pg_04.png">
            </div>
            <span class="nextpage" style="opacity: 1;">&nbsp;</span>
        </div>
    </section>
    <section class="page tc" id="secondpage">
        <div class="part01-second">
            <img width="264" src="http://ameiity-asd.stor.sinaapp.com/biye%2Fdgut_pg_2_01.png">
        </div>
        <div class="part02-second">
            <div class="grp01-second">
                <h3>亲爱的朋友：</h3>
                <p>
                    <? echo $content;?><br><br>时间：
                        <? echo $time_biye;?><br>地点：广州大学松田学院</p>
            </div>
            <div class="grp02-second">
                <p>即将毕业的
                    <? echo $name;?> 于 广州大学松田学院</p>
                <p>
                    <? echo $time;?>
                </p>
            </div>
        </div>
        <span class="nextpage" style="opacity: 1;">&nbsp;</span>
        <div class="ftbox"><img width="134" src="top.png"><img width="33" height="33" src="logo.gif"></div>
    </section>
    <section class="page tc" id="thirdpage">
        <div class="part01-third tl">
            <!--<p class="p1txt"><img width="154" src="http://ameiity-asd.stor.sinaapp.com/biye%2Fdgut_pg_3_01.png"></p>-->
            <p class="p1txt"><img width="280" src="http://i4.buimg.com/501024/9145954011a4fded.png"></p>
        </div>
        <div class="part02-third pa">
            <!--http://map.sogou.com/?pid=sogou-site-664dd858db942cad&ie=utf8&lq=%E5%B9%BF%E4%B8%9C%E8%B4%A2%E7%BB%8F%E5%A4%A7%E5%AD%A6%E5%8D%8E%E5%95%86%E5%AD%A6%E9%99%A2&searchRadio=on#c=12665421,2646353,15&lq=%u5E7F%u4E1C%u8D22%u7ECF%u5927%u5B66%u534E%u5546%u5B66%u9662&where=12662414.0625,2644710.9375,12668421.875,2648000,0&page=1,10-->
            <a href="" target="_blank" class="openLocation">
                <!--<a href="http://map.baidu.com/mobile/webapp/search/search/qt=inf&uid=bfaf36a5e6e8c0e979b55c12/newmap=1&t=1401780464" target="_blank">-->
                <img class="map" src="map.jpg">
            </a>
        </div>
        <div class="part03-third pa">
            <div class="schedulein">

            </div>
        </div>
        <span class="nextpage" style="opacity: 1;">&nbsp;</span>
        <div class="ftbox"><img width="134" src="top.png"><img width="33" height="33" src="logo.gif"></div>
    </section>
    <section class="page tc" id="fourpage">
        <!--<div class="part02-first pa" style="opacity: 1;">
            <img width="219" src="http://i4.buimg.com/501024/fcc8c68e64edcd4d.png">
        </div>-->
        <div class="part01-four tc pa">
            <!--<img width="186" src="http://ameiity-asd.stor.sinaapp.com/biye%2Fdgut_pg_4_01.png">-->
            <img width="333" src="http://i4.buimg.com/501024/fcc8c68e64edcd4d.png">
        </div>
        <div class="back cur tc pa" id="back">
            <a href="http://mp.weixin.qq.com/s?__biz=MzAwOTcyNzIzNw==&mid=503603929&idx=1&sn=e762900f2a2df5e5c8fa0f4840b3731e&chksm=00abfeb337dc77a59d59ca020edf26a45ee24fefdba241bb28bc47bd1e2cfcb87a74b01c4c07&mpshare=1&scene=1&srcid=0410zadjZRuGaaQC6deec8jP#rd"> <img src="http://ameiity-asd.stor.sinaapp.com/biye%2Fdgut_back.png" width="150"></a>
            <img src="http://ameiity-asd.stor.sinaapp.com/biye%2Fdgut_back3.png" width="150" onclick="shareWeixin('1')">

        </div>

        <div class="copyright cur tc pa">

        </div>
        <div class="ftbox"><img width="134" src="top.png"><img width="33" height="33" src="logo.gif"></div>
    </section>

    <div id="shareBoxBg" onclick="shareWeixin('0')">
        <div id="shareBox" style="margin-top: 20px; padding-left:30px;line-height:1.7">
            <img width="100%" src="http://ameiity-asd.stor.sinaapp.com/share_page_without_word.png" /> 点击右上角分享
            <br />给你想见到的ta<br /><br />
            <small><a href="#" style="color:#ff9900 " onclick="return shareWeixin(false)">关闭</a></small>
        </div>
    </div>
</body>
<script>
    $("#audio_btn").click(function() {
        var music = document.getElementById("music");
        if (music.paused) {
            music.play();
            $("#music_btn").attr("src", "pause.png");
        } else {
            music.pause();
            $("#music_btn").attr("src", "play.png");
        }
    });
</script>
<script>
    function shareWeixin(flg) {

        var shareboxBg = document.getElementById("shareBoxBg");
        var sharebox = document.getElementById("shareBox");
        //alert(flg);



        if (flg == 1) {

            sharebox.style.display = "block";
            shareboxBg.style.display = "block";
        } else {

            sharebox.style.display = "none";
            shareboxBg.style.display = "none";
        }

    }
</script>

</html>