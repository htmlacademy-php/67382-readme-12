<?php
require_once 'init.php';

check_no_session();

$page_content = '<section class="page__main"><p style="padding:100px 20px;">Здесь будет лента постов</p></section>';
$layout_content = include_template('layout', [
    'content' => $page_content,
    'page_name' => 'readme: моя лента',
    'user_name' => $_SESSION['user']['user_name'],
    'avatar' => $_SESSION['user']['avatar'],
    'active_page' => 'feed',
    'search_form_text' => (isset($search_form_text) ?? '')
]);

print($layout_content);
