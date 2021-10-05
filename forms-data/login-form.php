<?php
return [
    'fields' => [
        [
            'title' => 'Электронная почта',
            'required' => true,
            'type' => 'email',
            'name' => 'login-email',
            'placeholder' => 'Укажите эл.почту',
            'field_type' => 'input',
            'icon-name' => 'user',
            'icon-size' => 'width="19" height="18"',
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
            'title' => 'Пароль',
            'required' => true,
            'type' => 'password',
            'name' => 'login-password',
            'placeholder' => 'Введите пароль',
            'field_type' => 'input',
            'icon-name' => 'password',
            'icon-size' => 'width="16" height="20"',
            'validations' => [
                0 => function ($field_name) {
                    return validateFilled($field_name);
                },
                1 => function ($field_name) {
                    return validatePasswordLength($field_name);
                }
            ]
        ]
    ],
];
