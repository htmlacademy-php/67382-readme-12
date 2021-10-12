<?php
require_once 'util/helpers.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';

check_no_session();

const SORTING_TYPES = ['views', 'likes', 'date'];

$filters_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$sorting_type = filter_input(INPUT_GET, 'sorting', FILTER_SANITIZE_STRING);
$sorting_order = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_STRING);
if (!in_array($filters_type, array_column($posts_types, 'type'))) {
    $filters_type = NULL;
    $filters_type_id = NULL;
} else {
    foreach ($posts_types as $post_type) {
        if ($post_type['type'] === $filters_type) {
            $filters_type_id = $post_type['id'];
            break;
        }
    }
}
if (!in_array($sorting_type, SORTING_TYPES)) {
    $sorting_type = 'views';
}
if ($sorting_order !== 'asc') {
    $sorting_order = 'desc';
}

$popular_posts = get_popular_posts($con, $filters_type_id, $sorting_type, $sorting_order);
$posts_content = include_template('posts', [
    'popular_posts' => $popular_posts
]);
$popular_page_content = include_template('popular-layout', [
    'content' => $posts_content, 'posts_types' => $posts_types, 'filters_type' => $filters_type, 'sorting_type' => $sorting_type, 'sorting_order' => $sorting_order
]);
$page_content = include_template('popular-page', [
    'content' => $popular_page_content
]);
$page_title = 'readme: популярное';
show_page($page_content, $page_title, $_SESSION['user']['user_name'], $_SESSION['user']['avatar'], false, 'popular');

