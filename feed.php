<?php
require_once 'util/helpers.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';

if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit();
}
echo 'Здесь будет лента постов';
