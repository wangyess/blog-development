<?php
session_start();

require_once(__DIR__ . '/./article.php');
require_once(__DIR__ . '/./tag.php');
require_once(__DIR__ . '/./user.php');
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
    if (!has_permission_to($model, $action)) {
        echo json_encode(['success' => false, 'msg' => 'permission_denied']);
        return;
    }
    $kk = new $klass($pdo);
    $data = $kk->$action($params);
    echo json($data);
}

function has_permission_to($model, $action)
{
    $public = [
        'user' => ['login', 'signup', 'logout'],
    ];
    $col = [
        'article' => [
            'read'   => ['user', 'admin'],
            'add'    => ['admin'],
            'update' => ['admin'],
            'remove' => ['admin'],
            'count'  => ['user', 'admin'],
        ],
        'tag'     => [
            'read'   => ['admin'],
            'add'    => ['admin'],
            'update' => ['admin'],
            'remove' => ['admin'],
            'count' => ['user' ,'admin']
        ],
    ];
    //判断是否有传进来的model
    if (!key_exists($model, $col) && !key_exists($model, $public)) {
        return false;
    }
    $public_action_arr = @$public[ $model ];
    if ($public_action_arr && in_array($action, $public_action_arr)) {
        return true;
    }
    //判断是否有传进来的方法
    $action_arr = $col[ $model ];
    if (!key_exists($action, $action_arr)) {
        return false;
    }
    //判断你是否有权限去访问这个方法
    $permission_arr = $action_arr[ $action ];
    $user_permission = $_SESSION['user']['permission'];
    if (!in_array($user_permission, $permission_arr)) {
        return false;
    } else {
        return true;
    }
}

