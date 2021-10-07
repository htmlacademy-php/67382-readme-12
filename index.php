<?php
require_once 'util/helpers.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';
$login_form = require_once 'forms-data/login-form.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validate_form($login_form, $con);
    if (!count($errors)) {
        $email = mysqli_real_escape_string($con, htmlspecialchars($_POST['email']));
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) === 0) {
           $errors['email'] = 'Пользователь не найден';
        } else {
            $user = mysqli_fetch_array($res, MYSQLI_ASSOC);
            if (password_verify($_POST['$password'], $user['password'])) {
                $_SESSION['user'] = $user;
            } else {
                $errors['password'] = 'Неверный пароль';
            }
        }
    }
    if (count($errors)) {
        $page_content = include_template('main', [
            'errors' => $errors, 'login_form' => $login_form
        ]);
    } else {
        header("Location: /feed.php");
        exit();
    }
} else {
    if (isset($_SESSION['user'])) {
        header("Location: /feed.php");
        exit();
    } else {
        $page_content = include_template('main', [
            'login_form' => $login_form,
        ]);
    }
}

$page_title = 'readme: вход';
show_page($page_content, $page_title, '', true);
