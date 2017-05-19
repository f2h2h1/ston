#说明
使用php7.0    

微信token    
chengji    

绑定api    
http://host/fosu/?/chengji/bangdingapi/    

查询api    
http://host/fosu/?/chengji/chaxun/    

解绑api    
http://host/fosu/?/chengji/jiebang/    

绑定页面    
http://host/fosu/?/chengji/bangdingpage/    

接入微校时如果整体评分为差，请点击继续接入    

经过测试，貌似在不同ip访问100网，获得的网页内容是不一样的，主要是首页的隐藏字段不一样    
有一种是首页只有一个隐藏字段    
另一种是首页有三个隐藏字段    
在sae的环境下，curl首页只有一个隐藏字段    
所以这份代码只能应对首页只有一个隐藏字段的情况    
    
下面是错误代码及其含义    
501    sql语句执行失败    
502    数据库连接失败    
503    openid为空    
504    token验证失败    
601    default2.aspx open failed    
603    lbxh is empty.password is not correct    
604    xstop.aspx open failed    
605    lbxh is empty    
606    xscj.aspx open failed    
607    grade is emtpy    
    
关于token验证总是失败    
token验证失败，并不影响实际使用，所以一般不用理会    
    
数据库连接配置在config.php这个文件里    
    
下面是请求流程    
    
请求网址:http://100.fosu.edu.cn/    
请求方式:GET    
远程地址:61.142.209.149:80    
版本:HTTP/1.1    
    
Host: 100.fosu.edu.cn    
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0    
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8    
Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3    
Accept-Encoding: gzip, deflate    
Connection: keep-alive    
Upgrade-Insecure-Requests: 1    
    
    
请求网址:http://100.fosu.edu.cn/default2.aspx    
请求方式:POST    
远程地址:61.142.209.149:80    
版本:HTTP/1.1    
    
Host: 100.fosu.edu.cn    
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0    
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8    
Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3    
Accept-Encoding: gzip, deflate    
Referer: http://100.fosu.edu.cn/    
Cookie: ASP.NET_SessionId=rvgfi44533wagg45c2hmvh55    
Connection: keep-alive    
Upgrade-Insecure-Requests: 1    
    
__VIEWSTATE={$VIEWSTATE}&yh={$username}&kl={$password}&RadioButtonList1=%D1%A7%C9%FA&Button1=%B5%C7++%C2%BC&CheckBox1=on    
    
    
请求网址:http://100.fosu.edu.cn/xsmainfs.aspx?xh=20150150113    
请求方式:GET    
远程地址:61.142.209.149:80    
版本:HTTP/1.1    
    
Host: 100.fosu.edu.cn    
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0    
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8    
Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3    
Accept-Encoding: gzip, deflate    
Referer: http://100.fosu.edu.cn/    
Cookie: ASP.NET_SessionId=rvgfi44533wagg45c2hmvh55    
Connection: keep-alive    
Upgrade-Insecure-Requests: 1    
    
    
请求网址:http://100.fosu.edu.cn/xstop.aspx    
请求方式:GET    
远程地址:61.142.209.149:80    
版本:HTTP/1.1    
    
Host: 100.fosu.edu.cn    
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0    
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8    
Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3    
Accept-Encoding: gzip, deflate    
Referer: http://100.fosu.edu.cn/xsmainfs.aspx?xh=20150150113    
Cookie: ASP.NET_SessionId=rvgfi44533wagg45c2hmvh55    
Connection: keep-alive    
Upgrade-Insecure-Requests: 1    
    
    
请求网址:http://100.fosu.edu.cn/xsleft.aspx    
请求方式:GET    
远程地址:61.142.209.149:80    
版本:HTTP/1.1    
    
Host: 100.fosu.edu.cn    
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0    
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8    
Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3    
Accept-Encoding: gzip, deflate    
Referer: http://100.fosu.edu.cn/xsmainfs.aspx?xh=20150150113    
Cookie: ASP.NET_SessionId=rvgfi44533wagg45c2hmvh55    
Connection: keep-alive    
Upgrade-Insecure-Requests: 1    
    
    
请求网址:http://100.fosu.edu.cn/xsbzwj.aspx    
请求方式:GET    
远程地址:61.142.209.149:80    
版本:HTTP/1.1    
    
Host: 100.fosu.edu.cn    
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0    
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8    
Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3    
Accept-Encoding: gzip, deflate    
Referer: http://100.fosu.edu.cn/xsmainfs.aspx?xh=20150150113    
Cookie: ASP.NET_SessionId=rvgfi44533wagg45c2hmvh55    
Connection: keep-alive    
Upgrade-Insecure-Requests: 1    
    
    
请求网址:http://100.fosu.edu.cn/ggxxlb.aspx?xh=20150150113&qx=1&lx=%cd%a8%d6%aa%ce%c4%bc%fe&lxdm=1    
请求方式:GET    
远程地址:61.142.209.149:80    
版本:HTTP/1.1    
    
Host: 100.fosu.edu.cn    
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0    
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8    
Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3    
Accept-Encoding: gzip, deflate    
Referer: http://100.fosu.edu.cn/xsleft.aspx    
Cookie: ASP.NET_SessionId=rvgfi44533wagg45c2hmvh55    
Connection: keep-alive    
Upgrade-Insecure-Requests: 1    
    
    
请求网址:http://100.fosu.edu.cn/xsleft_js.aspx?flag=xxcx    
请求方式:GET    
远程地址:61.142.209.149:80    
版本:HTTP/1.1    
    
Host: 100.fosu.edu.cn    
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0    
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8    
Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3    
Accept-Encoding: gzip, deflate    
Referer: http://100.fosu.edu.cn/xstop.aspx    
Cookie: ASP.NET_SessionId=rvgfi44533wagg45c2hmvh55    
Connection: keep-alive    
Upgrade-Insecure-Requests: 1    
    
    
请求网址:http://100.fosu.edu.cn/xsleft.aspx?flag=xxcx    
请求方式:GET    
远程地址:61.142.209.149:80    
版本:HTTP/1.1    
    
Host: 100.fosu.edu.cn    
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0    
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8    
Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3    
Accept-Encoding: gzip, deflate    
Referer: http://100.fosu.edu.cn/xsleft_js.aspx?flag=xxcx    
Cookie: ASP.NET_SessionId=rvgfi44533wagg45c2hmvh55    
Connection: keep-alive    
Upgrade-Insecure-Requests: 1    
    
    
请求网址:http://100.fosu.edu.cn/xscj.aspx?xh=20150150113    
请求方式:GET    
远程地址:61.142.209.149:80    
版本:HTTP/1.1    
    
Host: 100.fosu.edu.cn    
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0    
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8    
Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3    
Accept-Encoding: gzip, deflate    
Referer: http://100.fosu.edu.cn/xsleft.aspx?flag=xxcx    
Cookie: ASP.NET_SessionId=rvgfi44533wagg45c2hmvh55    
Connection: keep-alive    
Upgrade-Insecure-Requests: 1