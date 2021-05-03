<?php
/**
 * Создает разметку для короткого и длинного текстового поста
 *
 * @param string $text - текст поста
 * @param int $num_letters - максимальное количество символов, которое выводится без сокращения
 *
 * @return string $post_content - готовая разметка для содержимого поста
 */

function cut_post($text, $num_letters  = 300) {
    $words_array = explode (" ", $text);
    $total_words_length = 0;
    $words_count = 0;
    $is_cut = false;
    foreach ($words_array as $word) {
        $total_words_length += mb_strlen($word);
        $words_count++;
        if ($total_words_length > $num_letters) {
            $is_cut = true;
            break;
        } else {
            ++$total_words_length;
        };
    }

    if ($is_cut) {
        $text = implode(" ", array_slice($words_array, 0, $words_count));
        return $post_content = '<p>' . $text . '...</p><a class="post-text__more-link" href="#">Читать далее</a>';
    }

    return $post_content = '<p>' . $text . '</p>';
}

/**
 * Возвращает дату в относительном формате
 *
 * @param string $date - дата
 * @return string строка с датой в относительном формате
 *
 */
const WEEK_DAYS = 7;
const MONTHS_LIMIT = 35;

function convert_date($date, $reg) {
    $diff = date_diff(date_create(), date_create($date));

    switch (true) {
        case ($diff->y > 0 && $reg):
            return $diff->y . ' ' . get_noun_plural_form($diff->y, 'год', 'года', 'лет');
        case ($diff->days > MONTHS_LIMIT):
            return $diff->m . ' ' . get_noun_plural_form($diff->m, 'месяц', 'месяца', 'месяцев');
        case ($diff->days >= WEEK_DAYS):
            $dt = ceil(($diff->days)/WEEK_DAYS);
            return $dt . ' ' . get_noun_plural_form($dt, 'неделя', 'недели', 'недель');
        case ($diff->days > 0):
            return $diff->days . ' ' . get_noun_plural_form($diff->days, 'день', 'дня', 'дней');
        case ($diff->h > 0):
            return $diff->h . ' ' . get_noun_plural_form($diff->h, 'час', 'часа', 'часов');
        default:
            return $diff->i . ' ' . get_noun_plural_form($diff->i, 'минута', 'минуты', 'минут');
    }
}

/**
 * Возвращает размеры иконок фильтра для вставки в разметку
 *
 * @param string $icon_class - тип иконки
 * @return string строка с размерами иконки
 *
 */

function icons_sizes($icon_class) {
    switch ($icon_class) {
        case 'quote':
            return 'width="21" height="20"';
        case 'text':
            return 'width="20" height="21"';
        case 'link':
            return 'width="21" height="18"';
        case 'video':
            return 'width="24" height="16"';
        case 'photo':
            return 'width="22" height="18"';
    }
}

/**
 * Возвращает тип поста для подстановки в заголовок формы добавления поста
 *
 * @param string $post_type - тип поста
 * @return string строка для заголовка
 *
 */

function types_in_heading($post_type) {
    switch ($post_type) {
        case 'quote':
            return 'цитаты';
        case 'text':
            return 'текста';
        case 'link':
            return 'ссылки';
        case 'video':
            return 'видео';
        case 'photo':
            return 'фото';
    }
}

/**
 * Возвращает текст тэга label для подстановки в форму добавления поста
 *
 * @param string $post_type - тип поста
 * @return string текст тэга label
 *
 */

function text_in_label($post_type) {
    switch ($post_type) {
        case 'quote':
            return 'Текст цитаты ';
        case 'text':
            return 'Текст поста ';
        case 'link':
            return 'Ссылка ';
        case 'video':
            return 'Ссылка youtube ';
        case 'photo':
            return 'Ссылка из интернета';
    }
}

/**
 * Возвращает текст заголовка ошибки для подстановки в форму добавления поста
 *
 * @param string $post_type - тип поста
 * @return string текст заголовка ошибки
 *
 */

function content_error_title($post_type) {
    switch ($post_type) {
        case 'quote':
            return 'Текст цитаты';
        case 'text':
            return 'Текст поста';
        case 'link':
            return 'Ссылка';
        case 'video':
            return 'Ссылка youtube ';
        case 'photo':
            return 'Ссылка на фото';
    }
}

/**
 * Возвращает текст названия поля перед текстом ошибки в сайдбаре
 *
 * @param string $key - поле с ошибкой
 * @param string $post_type - тип поста
 * @return string текст заголовка ошибки
 *
 */

function sidebar_error_title($key, $post_type) {
    switch ($key) {
        case 'title':
            return 'Заголовок. ';
        case 'cite_author':
            return 'Автор. ';
        case 'tags':
            return 'Теги. ';
        case 'photo':
            return 'Файл с фото. ';
        case 'content':
            switch ($post_type) {
                case 'quote':
                    return 'Цитата. ';
                case 'text':
                    return 'Текст поста. ';
                case 'link':
                    return 'Ссылка. ';
                case 'video':
                    return 'Ссылка youtube. ';
                case 'photo':
                    return 'Ссылка на фото. ';
        }
    }
}

/**
 * Вывод страницы
 *
 * @page_content - содержимое страницы
 * @page_name - заголовок страницы
 * @user_name - пользователь
 *
 */
function show_page($page_content, $page_name, $user_name) {
    $layout_content = include_template('layout', [
        'content' => $page_content,
        'page_name' => $page_name,
        'user_name' => $user_name
    ]);

    print($layout_content);
}

function make_link($url_string) {
    $check_url = strip_tags($url_string);
    if (!(stripos($check_url, 'http://') === 0 || stripos($check_url, 'https://') === 0)) {
        $check_url = 'http://' . $check_url;
    }
    return $check_url;
}

/**
 * Вывод страницы c ошибкой
 *
 * @is_err_mysql - ошибка mysqli_error или нет
 * @err - если это ошибка mysqli_error, передаем ресурс соединения $con
 *        если другая ошибка - передаем текст ошибки
 * @$is_err_404 - ошибка 404 или нет (возможно, позже будут обрабатываться и другие ошибки, потому пока установку заголовка делаем через проверку этого параметра)
 *
 */

function show_error($is_err_mysql, $err, $is_err_404) {
    $error = $is_err_mysql ? mysqli_error($err) : $err;
    $page_content = include_template('error-layout', [
        'error' => $error
    ]);
    $page_title = 'readme: ошибка!';
    if ($is_err_404) {
        header("HTTP/1.1 404 Not Found");
    }
    show_page($page_content, $page_title, $user_name);
    exit;
}
