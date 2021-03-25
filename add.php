<?php
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

} else {
    $sql = "SELECT * FROM posts_types";

    if ($res = mysqli_query($con, $sql)) {
        $posts_types = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $filters_type = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (!in_array($filters_type, array_column($posts_types, 'id'))) {
            $filters_type = 1;
        }
        $page_content = include_template('adding-post', [
            'posts_types' => $posts_types, 'filters_type' => $filters_type
        ]);
        $page_title = 'readme: добавить пост';
        show_page($page_content, $page_title, $user_name);
    } else {
        show_error(true, $con, false);
    }
}

