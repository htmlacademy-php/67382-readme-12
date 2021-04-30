<?php
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';

$post_type_id = (int) filter_input(INPUT_GET, 'type_id', FILTER_SANITIZE_NUMBER_INT);
if (!in_array($post_type_id, array_column($posts_types, 'id'))) {
    $post_type_id = 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $new_post = [];
    $errors = [];
    $new_post['type_id'] = (int) $_POST['post_type_id'];
    $post_type_id = $new_post['type_id'];
    $new_post['title'] = $_POST['post-heading'];
    $required = ['title'];
    if ($new_post['type_id'] !== 3) {
        array_push($required, 'content');
    }
    if ($new_post['type_id'] < 3) {
        $new_post['content'] = $_POST['post-text'];
    } else if ($new_post['type_id'] > 3) {
        $new_post['content'] = strip_tags($_POST['post-url']);
    }

    if ($new_post['type_id'] === 3) {
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
            $check_url = strip_tags($_POST['post-url']);
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

    if ($new_post['type_id'] === 2) {
        $new_post['cite_author'] = $_POST['cite-author'];
        array_push($required, 'cite_author');
    } else {
        $new_post['cite_author'] = NULL;
    }

    if (($new_post['type_id'] === 2) && (strlen($new_post['content']) > 70))  {
        $errors['content'] = 'Цитата не должна превышать 70 знаков.';
    }
    $post_tags = ($_POST['post-tags']) ? explode(' ', strip_tags($_POST['post-tags'])) : false;

    if ($new_post['type_id'] === 4) {
        $check_url = strip_tags($_POST['post-url']);
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

    if ($new_post['type_id'] === 5) {
        $check_url = strip_tags($_POST['post-url']);
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
            'posts_types' => $posts_types, 'post_type_id' => $post_type_id, 'errors' => $errors, 'previous_values' => $new_post
        ]);
    } else {
        if ($new_post['type_id'] === 3) {
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
        'posts_types' => $posts_types, 'post_type_id' => $post_type_id
    ]);
}

$page_title = 'readme: добавить пост';
show_page($page_content, $page_title, $user_name);
