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

function convert_date($date) {
    $diff = date_diff(date_create(), date_create($date));

    switch (true) {
        case ($diff->days > MONTHS_LIMIT):
            return $diff->m . ' ' . get_noun_plural_form($diff->m, 'месяц', 'месяца', 'месяцев') . ' назад';
        case ($diff->days >= WEEK_DAYS):
            $dt = ceil(($diff->days)/WEEK_DAYS);
            return $dt . ' ' . get_noun_plural_form($dt, 'неделя', 'недели', 'недель') . ' назад';
        case ($diff->days > 0):
            return $diff->days . ' ' . get_noun_plural_form($diff->days, 'день', 'дня', 'дней') . ' назад';
        case ($diff->h > 0):
            return $diff->h . ' ' . get_noun_plural_form($diff->h, 'час', 'часа', 'часов') . ' назад';
        default:
            return $diff->i . ' ' . get_noun_plural_form($diff->i, 'минута', 'минуты', 'минут') . ' назад';
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
