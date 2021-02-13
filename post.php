<?php
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';
require_once 'init.php';

$post_id = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($post_id) {
    $sql = "SELECT post_date,
    u.user_name,
    u.avatar,
    u.reg_date,
    t.type_name,
    t.icon_class,
    title,
    content,
    content_add,
    link_icon,
    views_total,
    COUNT(s.id) AS subscr_total
FROM posts p
JOIN users u
    ON p.user_id = u.id
JOIN posts_types t
    ON p.type_id = t.id
JOIN subscribe s
    ON p.user_id = s.tracked_id
WHERE p.id = '$post_id'";
    if ($res = mysqli_query($con, $sql)) {
        $post = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $page_content = include_template('post-details', [
            'post' => $post
        ]);
    } else {
        $GLOBALS['error'] = mysqli_error($con);
        header("Location: /error.php");
        exit;
    }
} else {
    $GLOBALS['error'] = '404';
    header("Location: /error.php");
    exit;
}

show_page($page_content, 'readme: пост', $user_name);
