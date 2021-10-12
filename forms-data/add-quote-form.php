<?php
return [
    'title_part' => 'цитаты',
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
            'title' => 'Текст цитаты',
            'required' => true,
            'type' => 'textarea',
            'name' => 'post-text',
            'placeholder' => 'Текст цитаты',
            'field_type' => 'textarea',
            'validations' => [
                0 => function ($field_name) {
                    return validateFilled($field_name);
                },
                1 => function ($field_name) {
                    return validateQuoteLength($field_name);
                }
            ]
        ],
        [
            'title' => 'Автор',
            'required' => true,
            'type' => 'text',
            'name' => 'cite_author',
            'field_type' => 'input',
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
