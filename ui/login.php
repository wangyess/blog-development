<?php
session_start();
?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>这个天才又来啦❤️</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
    <style>
        .top_a{  margin-top: 80px; }
        .ddl{width: 500px;margin:0 auto;text-align: center;padding-bottom: 50px;}
        .ass{width: 500px;margin: 0 auto;}
    </style>
</head>
<body>
<div class="row">
    <div>
        <nav class="navbar navbar-default navbar-fixed-top  clearfix">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">YE</a>
                </div>
                <div class="navbar-left">
                    <ul class="nav navbar-nav">
                        <li><a href="/">Home</a></li>
                        <li><a href="/admin/tag">Tag</a></li>
                        <li><a href="/admin/article">Article</a></li>
                    </ul>
                </div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/login">Login</a></li>
                        <li><a href="/signup">Signup</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<div class="row top_a">
    <div class="container">
        <div class="ddl">
            <h2>Login</h2>
        </div>
        <div class="ass">
            <form id="login-form" >
                <div class="form-group">
                    <input type="text" class="form-control" name="username"  placeholder="UserName">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password"  placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="permission" value="user" placeholder="Password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default form-control">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
<script src="/js/login.js"></script>
</body>
</html>