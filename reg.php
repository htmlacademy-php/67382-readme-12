<?php
require_once 'util/helpers.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';
$reg_form = require_once 'forms-data/reg-form.php';

check_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = validate_form($reg_form, $con);
    $new_user = [];
    $new_user['email'] = $_POST['reg-email'];
    $new_user['user_name'] = $_POST['login'];
    $new_user['password'] = password_hash($_POST['reg-password'], PASSWORD_DEFAULT);

    if (count($errors)) {
        $page_content = include_template('registration', [
            'errors' => $errors, 'reg_form' => $reg_form
        ]);
    } else {
        if ($_FILES['file-userpic']['size'] > 0) {
            $img_path = $_FILES['file-userpic']['name'];
            move_uploaded_file($_FILES['file-userpic']['tmp_name'], 'uploads/avatars/' . $img_path);
            $new_user['avatar'] = $img_path;
        } else {
            $new_user['avatar'] = '';
        }
        add_new_user($con, $new_user);
        header("Location: index.php");
        exit();
    }
} else {
    $page_content = include_template('registration', [
        'reg_form' => $reg_form,
    ]);
}

$page_title = 'readme: регистрация';
show_page($page_content, $page_title, '', '', true, 'reg');
