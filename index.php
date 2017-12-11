<?php
require_once (__DIR__ . '/./helper/helper.php');
require_once(__DIR__ . '/./api/gateway.php');
$uri = $_SERVER['REQUEST_URI'];
if (strpos($uri, '/a/') !== false) {
    echo get_page_input($uri);
    return;
}
switch ($uri) {
    case '/';
    tpl('home');
    break;
}