<?php
date_default_timezone_set('Asia/Barnaul');
// - date_default_timezone_set('Europe/Moscow');

$con = mysqli_connect("localhost", "root", "","readme");
if (!$con) {
    $GLOBALS['error'] = mysqli_connect_error();
    header("Location: /error.php");
    exit;
}
mysqli_set_charset($con, "utf8");
