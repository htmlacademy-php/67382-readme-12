<?php
require_once 'init.php';
$login_form = require_once 'forms-data/login-form.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validate_form($login_form, $con);
    if (!count($errors)) {
        $user_result = check_user($con, $_POST['email'], $_POST['password']);
        if ($user_result[0]) {
            $user = $user_result[1];
            $_SESSION['user'] = $user;
        } else {
            $errors = array_merge($errors, $temp_errors);
        }
    }
    if (count($errors)) {
        $page_content = include_template('main', [
            'errors' => $errors,
            'login_form' => $login_form
        ]);
        print($page_content);
    } else {
        header('Location: feed.php');
    }
} else {
    check_session();
    $page_content = include_template('main', [
        'login_form' => $login_form,
    ]);
    print($page_content);
}
