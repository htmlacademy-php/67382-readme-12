<?php
require_once 'util/helpers.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';

session_start();

date_default_timezone_set('Asia/Barnaul');
// - date_default_timezone_set('Europe/Moscow');

$con = mysqli_connect('localhost', 'root', '','readme');
if (!$con) {
    $error = mysqli_connect_error();
    show_error(false, $error, false);
}
mysqli_set_charset($con, 'utf8');
$sql = "SELECT * FROM posts_types";
if ($res = mysqli_query($con, $sql)) {
    $posts_types = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    show_error(true, $con, false);
}
