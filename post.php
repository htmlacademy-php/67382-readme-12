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
        if ($post['post_date']) {
            $page_content = include_template('post-details', [
                'post' => $post
            ]);
            $page_title = 'readme: пост';
        } else {
            $error = '404: Страница не существует';
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
} else {
    $error = '404: Страница не существует';
    $page_content = include_template('error-layout', [
        'error' => $error
    ]);
    $page_title = 'readme: ошибка!';
}

show_page($page_content, $page_title, $user_name);
