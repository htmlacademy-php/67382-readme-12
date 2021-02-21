<?php
/**
 * Получение из базы выборки популярных запросов
 *
 * @con - ресурс соединения
 * @filters_type int - фильтр
 * @return - популярные посты для вывода на страницу
 *
 */

function get_popular_posts($con, $filters_type) {
    $filter_string = $filters_type ? "WHERE p.type_id = '$filters_type' " : "";
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
    ON p.type_id = t.id " . $filter_string . "
ORDER BY views_total DESC";
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
        if (!$post['post_date']) {
            show_error(false, '404: Страница не существует', true);
        }
        return $post;
    } else {
        show_error(true, $con, false);
    }
}
