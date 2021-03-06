<?php
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';

const SORTING_TYPES = ['views', 'likes', 'date'];
$sql = "SELECT * FROM posts_types";

if ($res = mysqli_query($con, $sql)) {
    $posts_types = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $filters_type = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $sorting_type = filter_input(INPUT_GET, 'sorting', FILTER_SANITIZE_STRING);
    $sorting_order = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_STRING);
    if (!in_array($filters_type, array_column($posts_types, 'id'))) {
        $filters_type = NULL;
    }
    if (!in_array($sorting_type, SORTING_TYPES)) {
        $sorting_type = 'views';
    }
    if ($sorting_order !== 'asc') {
        $sorting_order = 'desc';
    }

    $popular_posts = get_popular_posts($con, $filters_type, $sorting_type, $sorting_order);
    $posts_content = include_template('posts', [
        'popular_posts' => $popular_posts
    ]);
    $page_content = include_template('popular-layout', [
        'content' => $posts_content, 'posts_types' => $posts_types, 'filters_type' => $filters_type, 'sorting_type' => $sorting_type, 'sorting_order' => $sorting_order
    ]);
    $page_title = 'readme: популярное';
    show_page($page_content, $page_title, $user_name);
} else {
    show_error(true, $con, false);
}

