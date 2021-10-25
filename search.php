<?php
require_once 'init.php';

check_no_session();

if (isset($_GET['search'])) {
    $search_text = trim(htmlspecialchars($_GET['search']));
    if (empty($search_text)) {
        go_back();
    }
} else {
    go_back();
}

if (substr($search_text, 0, 1) === '#') {
    $posts = get_posts_by_tag($con, substr($search_text, 1));
    $search_form_text = '';
} else {
    $posts = get_search_posts($con, $search_text);
    $search_form_text = $search_text;
}

if (!$posts) {
    $page_content = include_template('no-results', [
        'search_text' => $search_text,
        'prev_page' => $_SERVER['HTTP_REFERER']
    ]);
    $page_title = 'readme: ничего не найдено';
} else {
    $posts_content = include_template('feed-posts', [
        'posts' => $posts
    ]);
    $page_content = include_template('search-results', [
        'content' => $posts_content,
        'search_text' => $search_text
    ]);
    $page_title = 'readme: результаты поиска';
}

$layout_content = include_template('layout', [
    'content' => $page_content,
    'page_name' => $page_name,
    'user_name' => $_SESSION['user']['user_name'],
    'avatar' => $_SESSION['user']['avatar'],
    'active_page' => 'search-results',
    'search_form_text' => $search_form_text
]);
print($layout_content);
