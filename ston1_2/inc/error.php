<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>error</title>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
<div class="jumbotron">
    <div class="container">
        <h1>an error occurred</h1>
        <p>code:<?php echo $error['state']."&nbsp;".$error['msg'];printf("<pre>%s</pre>\n",var_export($error, true));?></p>
    </div>
</div>
</body>
</html>