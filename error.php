<?php
require_once 'util/helpers.php';
require_once 'tmp-data.php';
require_once 'util/functions.php';

$page_content = include_template('error-layout', [
    'error' => $error
]);

show_page($page_content, 'readme: ошибка', $user_name, false);
