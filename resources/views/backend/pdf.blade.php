<!DOCTYPE html>
<html>
<head>
    <title>测试pdf</title>
    <meta charset="utf-8">

    <style>
        @font-face {
            font-family: 'msyh';
            font-style: normal;
            font-weight: normal;
            src: url({{ asset('font/msyh.TTF') }}) format('truetype');
        }
        /*html, body {  height: 100%;*/
            /*font-family: 'mysh';}*/
        body {  margin: 0;  padding: 0;  width: 100%;
            /*display: table;  */
            font-weight: 100;  font-family: 'msyh';  }
        .container {  text-align: center;
            /*display: table-cell; */
            vertical-align: middle;  }
        .content {  text-align: center;  display: inline-block;  }
        .title {  font-size: 96px;  }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">这是测试生成PDF</div>
    </div>
</div>
</body>
</html>