<?php
date_default_timezone_set('Asia/Barnaul');
// - date_default_timezone_set('Europe/Moscow');

$con = mysqli_connect('localhost', 'root', '','readme');
if (!$con) {
    $error = mysqli_connect_error();
    $page_content = include_template('error-layout', [
        'error' => $error
    ]);
    show_page($page_content, 'readme: ошибка!', $user_name);
    exit;
}
mysqli_set_charset($con, 'utf8');
