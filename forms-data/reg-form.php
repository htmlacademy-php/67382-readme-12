<?php
return [
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
