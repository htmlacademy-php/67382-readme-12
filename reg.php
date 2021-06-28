<?php
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';

$reg_form = [
    'fields' => [
        [
            'title' => 'Электронная почта',
            'required' => true,
            'type' => 'email',
            'name' => 'reg-email',
            'placeholder' => 'Укажите эл.почту',
            'field_type' => 'input',
            'validations' => [
                0 => function ($field_name) {
                    return validateFilled($field_name);
                },
                1 => function ($field_name) {
                    return validateEmailCorrect($field_name);
                },
                2 => function ($field_name, $con) {
                    return validateEmailUnique($field_name, $con);
                }
            ]
        ],
        [
            'title' => 'Логин',
            'required' => true,
            'type' => 'text',
            'name' => 'login',
            'placeholder' => 'Укажите логин',
            'field_type' => 'input',
            'validations' => [
                0 => function ($field_name) {
                    return validateFilled($field_name);
                }
            ]
        ],
        [
            'title' => 'Пароль',
            'required' => true,
            'type' => 'password',
            'name' => 'reg-password',
            'placeholder' => 'Придумайте пароль',
            'field_type' => 'input',
            'validations' => [
                0 => function ($field_name) {
                    return validateFilled($field_name);
                },
                1 => function ($field_name) {
                    return validatePasswordLength($field_name);
                }
            ]
        ],
        [
            'title' => 'Повтор пароля',
            'required' => true,
            'type' => 'password',
            'name' => 'password-repeat',
            'placeholder' => 'Повторите пароль',
            'field_type' => 'input',
            'validations' => [
                0 => function ($field_name) {
                    return validateFilled($field_name);
                },
                1 => function ($field_name) {
                    return validatePassword($field_name, 'reg-password');
                }
            ]
        ],
        [
            'required' => false,
            'type' => 'file',
            'name' => 'file-userpic',
            'field_type' => 'input-file',
            'validations' => [
                0 => function ($field_name) {
                    return validateUploadedPicture($field_name);
                }
            ]
        ]
    ],
];

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
show_page($page_content, $page_title, '', true);
