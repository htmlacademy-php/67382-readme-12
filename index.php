<?php
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';

date_default_timezone_set('Asia/Barnaul');
// - date_default_timezone_set('Europe/Moscow');

foreach ($popular_posts as $post_id => &$post) {
    $post['date'] = generate_random_date($post_id);
}

$posts_content = include_template('posts', [
    'popular_posts' => $popular_posts
]);

$page_content = include_template('main', [
    'content' => $posts_content,
]);

$layout_content = include_template('layout', [
    'content' => $page_content,
    'title' => 'readme: популярное',
    'user_name' => $user_name
]);

print($layout_content);
