<?php
require_once(__DIR__ . '/./helper/helper.php');
require_once(__DIR__ . '/./api/gateway.php');
$uri = $_SERVER['REQUEST_URI'];
if (strpos($uri, '/a/') !== false) {
    echo get_page_input($uri);
    return;
}
if(strpos($uri,'/detail') !==false){
    tpl('detail');
    return;
}
if(strpos($uri,'/tag_page') !==false){
    tpl('tag_page');
    return;
}
switch ($uri) {
    case '/';
        tpl('home');
        break;
    case '/admin/article';
        tpl('article');
        break;
    case '/admin/tag';
        tpl('tag');
        break;
    case '/login';
        tpl('login');
        break;
    case '/logout';
        tpl('logout');
        break;
    case '/signup';
        tpl('signup');
        break;
}

