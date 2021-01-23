<?php
require_once 'config.php';
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';


if (!$con) {
    $error = mysqli_connect_error();
    $page_content = include_template('error', [
        'error' => $error
    ]);

} else {
    $sql = "SELECT type_name,
                   icon_class
              FROM posts_types";

    if ($res = mysqli_query($con, $sql)) {
        $posts_types = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $sql = "SELECT post_date,
                       u.user_name,
                       u.avatar,
                       t.type_name,
                       t.icon_class,
                       title,
                       content,
                       content_add,
                       views_total
                  FROM posts p
                  JOIN users u
                    ON p.user_id = u.id
                  JOIN posts_types t
                    ON p.type_id = t.id
              ORDER BY views_total DESC";
        if ($res = mysqli_query($con, $sql)) {
            $popular_posts = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $posts_content = include_template('posts', [
                'popular_posts' => $popular_posts
            ]);
            $page_content = include_template('main', [
                'content' => $posts_content, 'posts_types' => $posts_types
            ]);
        } else {
            $error = mysqli_error();
            $page_content = include_template('error', [
                'error' => $error
            ]);
        }
    } else {
        $error = mysqli_error();
        $page_content = include_template('error', [
            'error' => $error
        ]);
    }
}

$layout_content = include_template('layout', [
    'content' => $page_content,
    'title' => 'readme: популярное',
    'user_name' => $user_name
]);

print($layout_content);
