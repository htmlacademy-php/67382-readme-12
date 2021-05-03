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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $new_post = [];
    $errors = [];
    $adding_type = $_POST['adding_type'];
    foreach ($posts_types as $post_type) {
        if ($post_type['type'] === $adding_type) {
            $new_post['type_id'] = $post_type['id'];
            break;
        }
    }
    $new_post['title'] = $_POST['post-heading'];
    $required = ['title'];
    if ($adding_type !== 'photo') {
        array_push($required, 'content');
    }
    if (($adding_type === 'text') || ($adding_type === 'quote')) {
        $new_post['content'] = $_POST['post-text'];
    } else if (($adding_type === 'video') || ($adding_type === 'link')) {
        $check_url = make_link($_POST['post-url']);
        $new_post['content'] = $check_url;
    }

    if ($adding_type === 'photo') {
        $new_post['content'] = '';

        if ($_FILES['file-photo']['size'] > 0) {
            $tmp_name = $_FILES['file-photo']['tmp_name'];
            $file_size = $_FILES['file-photo']['size'];

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);

            if (($file_type !== 'image/jpeg') && ($file_type !== 'image/gif') && ($file_type !== 'image/png')) {
                $errors['photo'] = 'Загрузите изображение в формате jpeg, png или gif';
            } else {
                $isPhotoAtLink = false;
            }
        } else {
            $check_url = make_link($_POST['post-url']);
            $photo_url = filter_var($check_url, FILTER_VALIDATE_URL);
            if ($photo_url) {
                $photo_file = file_get_contents($photo_url);
                if ($photo_file) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $file_type = finfo_buffer($finfo, $photo_file);
                    if (($file_type !== 'image/jpeg') && ($file_type !== 'image/gif') && ($file_type !== 'image/png')) {
                        $errors['content'] = 'По ссылке отсутствует изображение в формате jpeg, png или gif';
                    } else {
                        $isPhotoAtLink = true;
                    }
                } else {
                    $errors['content'] = 'Невозможно загрузить изображение по ссылке';
                }
            } else {
                $errors['content'] = 'Загрузите изображение или укажите ссылку на него';
                $errors['photo'] = 'Загрузите изображение или укажите ссылку на него';
            }
        }
    }

    if ($adding_type === 'quote') {
        $new_post['cite_author'] = $_POST['cite-author'];
        array_push($required, 'cite_author');
    } else {
        $new_post['cite_author'] = NULL;
    }

    if (($adding_type === 'quote') && (strlen($new_post['content']) > 70))  {
        $errors['content'] = 'Цитата не должна превышать 70 знаков.';
    }
    $post_tags = ($_POST['post-tags']) ? explode(' ', strip_tags($_POST['post-tags'])) : false;

    if ($adding_type === 'video') {
        $video_url = filter_var($check_url, FILTER_VALIDATE_URL);
        if ($video_url) {
            if (check_youtube_url($video_url)) {
                $new_post['content'] = $video_url;
            } else {
                $errors['content'] = 'Видео по такой ссылке не найдено. Проверьте ссылку на видео';
            }
        } else {
            $errors['content'] = 'Укажите ссылку на видео на YouTube';
        }
    }

    if ($adding_type === 'link') {
        $link_url = filter_var($check_url, FILTER_VALIDATE_URL);
        if ($link_url) {
            $new_post['content'] = $link_url;
        } else {
            $errors['content'] = 'Текст в поле не является ссылкой';
        }
    }

    foreach ($required as $key) {
        if (empty($new_post[$key])) {
            $errors[$key] = 'Это поле должно быть заполнено.';
        }
    }

    if (count($errors)) {
        $new_post['tags'] = strip_tags($_POST['post-tags']);
        $page_content = include_template('adding-post', [
            'posts_types' => $posts_types, 'adding_type' => $adding_type, 'errors' => $errors, 'previous_values' => $new_post
        ]);
    } else {
        if ($adding_type === 'photo') {
            if ($isPhotoAtLink) {
                $img_path = basename($photo_url);
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
    $page_content = include_template('adding-post', [
        'posts_types' => $posts_types, 'adding_type' => $adding_type
    ]);
}

$page_title = 'readme: добавить пост';
show_page($page_content, $page_title, $user_name);
