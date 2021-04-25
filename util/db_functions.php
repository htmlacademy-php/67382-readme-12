<?php
/**
 * Получение из базы выборки популярных запросов
 *
 * @con - ресурс соединения
 * @filters_type int - фильтр
 * @sorting_type string - тип сортировки
 * @sorting_order string - порядок сортировки
 * @return - популярные посты для вывода на страницу
 *
 */

function get_popular_posts($con, $filters_type, $sorting_type, $sorting_order) {
    $filter_string = $filters_type ? "WHERE p.type_id = '$filters_type' " : "";
    switch (true) {
        case ($sorting_type === 'likes'):
            $sorting_type_string = ' likes_total';
            break;
        case ($sorting_type === 'date'):
            $sorting_type_string = ' post_date';
            break;
        default:
            $sorting_type_string = ' views_total';
    }
    $sorting_order_string = ($sorting_order === 'asc') ? ' ASC' : ' DESC';
    $sql = "SELECT post_date,
    u.user_name,
    u.avatar,
    t.type_name,
    t.alias,
    p.id,
    title,
    content,
    cite_author,
    views_total,
    (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.id) AS likes_total,
    (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comments_total
FROM posts p
JOIN users u
    ON p.user_id = u.id
JOIN posts_types t
    ON p.type_id = t.id " . $filter_string . "
ORDER BY " . $sorting_type_string . $sorting_order_string;
    if ($res = mysqli_query($con, $sql)) {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        show_error(true, $con, false);
    }
}

/**
 * Получение из базы выборки популярных запросов
 *
 * @con - ресурс соединения
 * @post_id int - id поста
 * @return - пост
 *
 */

function get_post($con, $post_id) {
    $sql = "SELECT post_date,
    u.user_name,
    u.avatar,
    u.reg_date,
    t.type_name,
    t.alias,
    p.user_id,
    title,
    content,
    cite_author,
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
        if (!$post['post_date']) {
            show_error(false, '404: Страница не существует', true);
        }
        return $post;
    } else {
        show_error(true, $con, false);
    }
}

/**
 * Добавление нового поста
 *
 * @con - ресурс соединения
 * @new_post - пост, который добавляем
 * @post_tags - тэги поста или false, если нету
 * @return - id нового поста
 *
 */

function add_new_post($con, $new_post, $post_tags) {
    $sql = 'INSERT INTO posts (post_date, type_id, title, content, cite_author, user_id, is_repost, views_total) VALUES (NOW(), ?, ?, ?, ?, ?, ?, 1)';

    $stmt = db_get_prepare_stmt($con, $sql, $new_post);
    if ($res_post = mysqli_stmt_execute($stmt)) {
        $new_post_id = mysqli_insert_id($con);
        if ($post_tags) {
            foreach ($post_tags as $tag) {
                $sql = "SELECT * from tags WHERE tag_name = '$tag'";
                $res_tag = mysqli_query($con, $sql);
                $tag_entry = mysqli_fetch_all($res_tag, MYSQLI_ASSOC);
                if (!empty($tag_entry)) {
                    $tag_id = $tag_entry[0]['id'];
                } else {
                    $sql = "INSERT INTO tags SET tag_name = '$tag'";
                    if ($res_tag_add = mysqli_query($con, $sql)) {
                        $tag_id = mysqli_insert_id($con);
                    } else {
                        continue;
                        // - ошибки добавления тэгов не будут выводиться на страницу ошибок
                        // - если пост успешно добавлен, он будет показан без тэгов
                        // - show_error(true, $con, false);
                    }
                }
                $sql = "INSERT INTO post_tags SET post_id = '$new_post_id', tag_id = '$tag_id'";
                $res_post_tags = mysqli_query($con, $sql);
                if (!$res_post_tags) {
                    continue;
                    // - show_error(true, $con, false);
                }
            }
        }
    } else {
        show_error(true, $con, false);
    }
    return $new_post_id;
}

/**
 * Получение из базы количества постов пользователя
 *
 * @con - ресурс соединения
 * @user_id int - id пользователя
 * @return - количество постов пользователя
 *
 */

function count_user_posts($con, $user_id) {
    $sql = "SELECT
    COUNT(id) AS user_posts_total
FROM posts
WHERE user_id = '$user_id'";
    if ($res = mysqli_query($con, $sql)) {
        $posts_total = mysqli_fetch_array($res, MYSQLI_ASSOC);
        return $posts_total['user_posts_total'];
    } else {
        show_error(true, $con, false);
    }
}
