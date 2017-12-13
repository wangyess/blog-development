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
    <link rel="stylesheet" href="/css/article.css">
</head>
<body>
<div class="row">
    <div class="container ff">
        <div class=" header-image">
            <img src="/images/header2.jpg" alt="">
        </div>
        <div class="col-sm-2  left-col">
            <ul class="nav nav-pills nav-stacked  change_color">
                <li role="presentation"><a href="/">Home</a></li>
                <li role="presentation" class="active"><a href="#">Article</a></li>
                <li role="presentation"><a href="/admin/tag">Tag</a></li>
            </ul>
        </div>
        <br>
        <div class="col-sm-10">
            <div>
                <form id="my_form">
                    <input type="hidden" name='id'>
                    <input type="text" placeholder="Title" name="title" class="form-control">
                    <br>
                    <textarea name="content" cols="30" rows="10" class="form-control" placeholder="Content"></textarea>
                    <br>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">提交</button>
                </form>
            </div>
            <br>
            <div id="show_article">
                <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>author</th>
                        <th>create_time</th>
                        <th>update_time</th>
                        <th>operation</th>
                    </tr>
                    <tbody id="first-tbody">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="fan_ye">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="top-page">
                        <a aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li class="next-page">
                        <a aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
<script src="/js/model.js"></script>
<script src="/js/article.js"></script>
</body>
</html>