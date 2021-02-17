<?php
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';
require_once 'init.php';

$sql = "SELECT * FROM posts_types";

if ($res = mysqli_query($con, $sql)) {
    $posts_types = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $filters_type = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if (in_array($filters_type, array_column($posts_types, 'id'))) {
        $sql = "SELECT post_date,
        u.user_name,
        u.avatar,
        t.type_name,
        t.icon_class,
        p.id,
        title,
        content,
        content_add,
        link_icon,
        views_total
    FROM posts p
    JOIN users u
        ON p.user_id = u.id
    JOIN posts_types t
        ON p.type_id = t.id
    WHERE p.type_id = '$filters_type'
    ORDER BY views_total DESC";
    } else {
        $filters_type = NULL;
        $sql = "SELECT post_date,
        u.user_name,
        u.avatar,
        t.type_name,
        t.icon_class,
        p.id,
        title,
        content,
        content_add,
        link_icon,
        views_total
    FROM posts p
    JOIN users u
        ON p.user_id = u.id
    JOIN posts_types t
        ON p.type_id = t.id
ORDER BY views_total DESC";
    }
    if ($res = mysqli_query($con, $sql)) {
        $popular_posts = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $posts_content = include_template('posts', [
            'popular_posts' => $popular_posts
        ]);
        $page_content = include_template('popular-layout', [
            'content' => $posts_content, 'posts_types' => $posts_types, 'filters_type' => $filters_type
        ]);
        $page_title = 'readme: популярное';
    } else {
        $error = mysqli_error($con);
        $page_content = include_template('error-layout', [
            'error' => $error
        ]);
        $page_title = 'readme: ошибка!';
    }
} else {
    $error = mysqli_error($con);
    $page_content = include_template('error-layout', [
        'error' => $error
    ]);
    $page_title = 'readme: ошибка!';
}

show_page($page_content, $page_title, $user_name);
