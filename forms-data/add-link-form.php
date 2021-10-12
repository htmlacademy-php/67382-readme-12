<?php
return [
    'title_part' => 'ссылки',
    'fields' => [
        [
            'title' => 'Заголовок',
            'required' => true,
            'type' => 'text',
            'name' => 'post-heading',
            'placeholder' => 'Введите заголовок',
            'field_type' => 'input',
            'validations' => [
                0 => function ($field_name) {
                    return validateFilled($field_name);
                }
            ]
        ],
        [
            'title' => 'Ссылка',
            'required' => true,
            'type' => 'text',
            'name' => 'post-url',
            'placeholder' => 'Введите ссылку',
            'field_type' => 'input',
            'validations' => [
                0 => function ($field_name) {
                    return validateFilled($field_name);
                },
                1 => function ($field_name) {
                    return validateUrl($field_name);
                }
            ]
        ],
        [
            'title' => 'Теги',
            'required' => false,
            'type' => 'text',
            'name' => 'tags',
            'placeholder' => 'Введите теги',
            'field_type' => 'input',
            'validations' => []
        ],
    ],
];
