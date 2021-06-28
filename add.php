<?php
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';

$adding_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
if (!in_array($adding_type, array_column($posts_types, 'type'))) {
    $adding_type = 'text';
}

$add_forms = [
    'text' => [
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
    ],
    'quote' => [
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
    ],
    'photo' => [
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
    ],
    'video' => [
        'title_part' => 'видео',
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
                'title' => 'Ссылка youtube',
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
                    },
                    2 => function ($field_name) {
                        return check_youtube_url($_POST[$field_name]);
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
    ],
    'link' => [
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
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $adding_type = $_POST['adding_type'];
    $adding_form = $add_forms[$adding_type];
    if ($adding_type === 'photo') {
        $validation_result = validate_form($adding_form, $con);
        $errors = $validation_result[0];
        $isPhotoAtLink = $validation_result[1];
        if ($isPhotoAtLink) {
            $photo_url = $validation_result[2];
        }
    } else {
        $errors = validate_form($adding_form);
    }
    $new_post = [];

    foreach ($posts_types as $post_type) {
        if ($post_type['type'] === $adding_type) {
            $new_post['type_id'] = $post_type['id'];
            break;
        }
    }

    $new_post['title'] = $_POST['post-heading'];
    if (($adding_type === 'text') || ($adding_type === 'quote')) {
        $new_post['content'] = $_POST['post-text'];
    } else if (($adding_type === 'video') || ($adding_type === 'link')) {
        $new_post['content'] = make_link($_POST['post-url']);
    }

    if ($adding_type === 'photo') {
        $new_post['content'] = '';
    }

    if ($adding_type === 'quote') {
        $new_post['cite_author'] = $_POST['cite_author'];
    } else {
        $new_post['cite_author'] = NULL;
    }

    $post_tags = ($_POST['tags']) ? explode(' ', strip_tags($_POST['tags'])) : false;

    if (count($errors)) {
        $new_post['tags'] = strip_tags($_POST['tags']);
        $page_content = include_template('adding-post', [
            'posts_types' => $posts_types, 'adding_type' => $adding_type, 'errors' => $errors, 'adding_form' => $adding_form
        ]);
    } else {
        if ($adding_type === 'photo') {
            if ($isPhotoAtLink) {
                $img_path = basename($photo_url);
                $photo_file = file_get_contents($photo_url);
                file_put_contents('uploads/' . $img_path, $photo_file);
            } else {
                $img_path = $_FILES['file-photo']['name'];
                move_uploaded_file($_FILES['file-photo']['tmp_name'], 'uploads/' . $img_path);
            }
            $new_post['content'] = $img_path;
        }
        $new_post['user_id'] = 4;
        $new_post['is_repost'] = 0;
        $new_post_id = add_new_post($con, $new_post, $post_tags);
        header("Location: post.php?post_id=" . $new_post_id);
        exit();
    }
} else {
    $adding_form = $add_forms[$adding_type];
    $page_content = include_template('adding-post', [
        'posts_types' => $posts_types, 'adding_type' => $adding_type, 'adding_form' => $adding_form
    ]);
}

$page_title = 'readme: добавить пост';
show_page($page_content, $page_title, $user_name, false);
