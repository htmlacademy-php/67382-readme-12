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

function convert_date($date) {
    $dt = time() - strtotime($date);

    switch (true) {
        case ($dt <= 3600):
            $dt_number = ceil($dt / 60);
            return $dt_number . ' ' . get_noun_plural_form($dt_number, 'минута', 'минуты', 'минут') . ' назад';

        case ($dt > 3600 && $dt < (60 * 60 * 24)):
            $dt_number = ceil($dt / 3600);
            return $dt_number . ' ' . get_noun_plural_form($dt_number, 'час', 'часа', 'часов') . ' назад';

        case ($dt >= (60 * 60 * 24) && $dt < (60 * 60 * 24 * 7)):
            $dt_number = ceil($dt / (60 * 60 * 24));
            return $dt_number . ' ' . get_noun_plural_form($dt_number, 'день', 'дня', 'дней') . ' назад';

        case ($dt >= (60 * 60 * 24 * 7) && $dt <= (60 * 60 * 24 * 7 * 5)):
            $dt_number = ceil($dt / (60 * 60 * 24 * 7));
            return $dt_number . ' ' . get_noun_plural_form($dt_number, 'неделя', 'недели', 'недель') . ' назад';

        default:
            $dt_number = ceil($dt / (60 * 60 * 24 * 30));
            return $dt_number . ' ' . get_noun_plural_form($dt_number, 'месяц', 'месяца', 'месяцев') . ' назад';
    }
}
