<?php
return [
    'title_part' => 'фото',
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
            'title' => 'Ссылка из интернета',
            'required' => false,
            'type' => 'text',
            'name' => 'post-url',
            'placeholder' => 'Введите ссылку',
            'field_type' => 'input',
            'validations_field' => 'file-photo'
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
        [
            'required' => false,
            'type' => 'file',
            'name' => 'file-photo',
            'field_type' => 'input-file',
            'validations' => [
                0 => function ($field_name) {
                    return validatePhoto($field_name, $add_field);
                }
            ]
        ]
    ],
];
