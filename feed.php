<?php
require_once 'util/helpers.php';
require_once 'util/functions.php';
require_once 'util/db_functions.php';
require_once 'init.php';

check_no_session();

$page_title = 'readme: моя лента';
$page_content = '<section class="page__main"><p style="padding:100px 20px;">Здесь будет лента постов</p></section>';
show_page($page_content, $page_title, $_SESSION['user']['user_name'], $_SESSION['user']['avatar'], false, 'feed', (isset($search_form_text) ?? ''));
