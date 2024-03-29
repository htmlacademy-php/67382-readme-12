<?php
require_once 'init.php';

check_no_session();

$adding_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
if (!in_array($adding_type, array_column($posts_types, 'type'))) {
    $adding_type = 'text';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $adding_type = $_POST['adding_type'];
    $adding_form = require_once 'forms-data/add-' . $adding_type . '-form.php';
    if ($adding_type === 'photo') {
        $validation_result = validate_form($adding_form, $con);
        $errors = $validation_result[0];
        $isPhotoAtLink = $validation_result[1];
        $photo_url = $isPhotoAtLink ? $validation_result[2] : '';
    } else {
        $errors = validate_form($adding_form, $con);
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
    } elseif (($adding_type === 'video') || ($adding_type === 'link')) {
        $new_post['content'] = make_link($_POST['post-url']);
    }

    if ($adding_type === 'photo') {
        $new_post['content'] = '';
    }

    $new_post['cite_author'] = ($adding_type === 'quote') ? $_POST['cite_author'] : null;

    $post_tags = ($_POST['tags']) ? explode(' ', strip_tags($_POST['tags'])) : false;

    if (count($errors)) {
        $new_post['tags'] = strip_tags($_POST['tags']);
        $page_content = include_template('adding-post', [
            'posts_types' => $posts_types,
            'adding_type' => $adding_type,
            'errors' => $errors,
            'adding_form' => $adding_form
        ]);
    } else {
        if ($adding_type === 'photo') {
            $new_post['content'] = processPhoto($isPhotoAtLink, $photo_url);
        }
        $new_post['user_id'] = $_SESSION['user']['id'];
        $new_post['is_repost'] = 0;
        $new_post_id = add_new_post($con, $new_post, $post_tags);
        header("Location: post.php?post_id=" . $new_post_id);
        exit();
    }
} else {
    $adding_form = require_once 'forms-data/add-' . $adding_type . '-form.php';
    $page_content = include_template('adding-post', [
        'posts_types' => $posts_types,
        'adding_type' => $adding_type,
        'adding_form' => $adding_form
    ]);
}

$layout_content = include_template('layout', [
    'content' => $page_content,
    'page_name' => 'readme: добавить пост',
    'user_name' => $_SESSION['user']['user_name'],
    'avatar' => $_SESSION['user']['avatar'],
    'active_page' => 'add',
    'search_form_text' => (isset($search_form_text) ?? '')
]);
print($layout_content);
