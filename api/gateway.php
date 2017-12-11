<?php
require_once(__DIR__ . '/./article.php');
require_once(__DIR__ . '/./tag.php');
require_once(__DIR__ . '/../helper/helper.php');

function get_page_input($uri)
{
    //获取传入的值
    $pdo = link_database();
    $params = array_merge($_GET, $_POST);
    $uri = trim($uri, '/');
    $arr_one = explode('?', $uri);
    $arr_two = explode('/', $arr_one[0]);
    $model = $arr_two[1];
    $action = $arr_two[2];
    $klass = ucfirst($model);
    //全选判断   先不写
    $kk = new $klass($pdo);
    $data = $kk->$action($params);
    echo json($data);
}


