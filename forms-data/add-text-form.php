<?php
return [
    'title_part' => 'текста',
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
            'title' => 'Текст поста',
            'required' => true,
            'type' => 'textarea',
            'name' => 'post-text',
            'placeholder' => 'Введите текст публикации',
            'field_type' => 'textarea',
            'validations' => [
                0 => function ($field_name) {
                    return validateFilled($field_name);
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

