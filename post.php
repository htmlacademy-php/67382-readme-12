<?php
require_once 'init.php';

check_no_session();

$post_id = (int) filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT);
if ($post_id) {
    $post = get_post($con, $post_id);
    $user_posts_total = count_user_posts($con, $post['user_id']);
    $page_content = include_template('post-details', [
        'post' => $post,
        'user_posts_total' => $user_posts_total
    ]);
    $layout_content = include_template('layout', [
        'content' => $page_content,
        'page_name' => 'readme: пост',
        'user_name' => $_SESSION['user']['user_name'],
        'avatar' => $_SESSION['user']['avatar'],
        'active_page' => 'post',
        'search_form_text' => (isset($search_form_text) ?? '')
    ]);
    print($layout_content);
} else {
    show_error(false, '404: Страница не существует', true);
}
