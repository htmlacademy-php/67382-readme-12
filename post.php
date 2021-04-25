<?php
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';

$post_id = (int) filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT);
if ($post_id) {
    $post = get_post($con, $post_id);
    $user_posts_total = count_user_posts($con, $post['user_id']);
    $page_content = include_template('post-details', [
        'post' => $post, 'user_posts_total' => $user_posts_total
    ]);
    $page_title = 'readme: пост';
    show_page($page_content, $page_title, $user_name);
} else {
    show_error(false, '404: Страница не существует', true);
}
