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
    <link rel="stylesheet" href="/css/home.css">
</head>
<body>
<div class="row">
    <div>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">YE</a>
                </div>
                <div class="navbar-left">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/">Home</a></li>
                        <li><a href="/admin/tag">Tag</a></li>
                        <li><a href="/admin/article">Article</a></li>
                    </ul>
                </div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <?php
                        if ($_SESSION['user']) {
                            echo '<li>' . '<a >' . $_SESSION['user']['username'] . '</a>' . '</li>';
                            echo '<li id="cli_on_1">' . '<a>' . 'Logout' . '</a>' . '</li>';
                        } else {
                            echo '<li>' . '<a href="/login">' . 'Login' . '</a>' . '</li>';
                        }
                        ?>
                        <li><a href="/signup">Signup</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<div class="row">
    <div class="container">
        <div class="article_page">

        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
<script src="/js/model.js"></script>
<script src="/js/tag_page.js"></script>
<script src="/js/logout.js"></script>
</body>
</html>