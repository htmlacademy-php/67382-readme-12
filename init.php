<?php
session_start();

date_default_timezone_set('Asia/Barnaul');
// - date_default_timezone_set('Europe/Moscow');

$con = mysqli_connect('localhost', 'root', '','readme');
if (!$con) {
    $error = mysqli_connect_error();
    $page_content = include_template('error-layout', [
        'error' => $error
    ]);
    if ($_SESSION['user']) {
        show_page($page_content, 'readme: ошибка!', $_SESSION['user']['user_name'], $_SESSION['user']['avatar'], false, 'error', (isset($search_form_text) ?? ''));
    } else {
        show_page($page_content, 'readme: ошибка!', '', '', true, 'error', (isset($search_form_text) ?? ''));
    }
    exit;
}
mysqli_set_charset($con, 'utf8');
$sql = "SELECT * FROM posts_types";
if ($res = mysqli_query($con, $sql)) {
    $posts_types = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    show_error(true, $con, false);
    exit;
}
