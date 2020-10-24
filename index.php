<?php
require_once 'helpers.php';

$is_auth = rand(0, 1);

$user_name = 'Inna Suknovalnik'; // укажите здесь ваше имя
$popular_posts = [
    [
    'title' => 'Цитата',
    'type' => 'post-quote',
    'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
    'author' => 'Лариса',
    'avatar' => 'userpic-larisa-small.jpg'
    ],
    [
    'title' => 'Игра престолов',
    'type' => 'post-text',
    'content' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
    'author' => 'Владик',
    'avatar' => 'userpic.jpg'
    ],
    [
    'title' => 'Наконец, обработал фотки!',
    'type' => 'post-photo',
    'content' => 'rock-medium.jpg',
    'author' => 'Виктор',
    'avatar' => 'userpic-mark.jpg'
    ],
    [
    'title' => 'Моя мечта',
    'type' => 'post-photo',
    'content' => 'coast-medium.jpg',
    'author' => 'Лариса',
    'avatar' => 'userpic-larisa-small.jpg'
    ],
    [
    'title' => 'Лучшие курсы',
    'type' => 'post-link',
    'content' => 'www.htmlacademy.ru',
    'author' => 'Владик',
    'avatar' => 'userpic.jpg'
    ],
];

function cut_post($text, $num_letters  = 300) {
    $words = explode (" ", $text);
    $total_words_length = 0;
    $words_count = 0;
    $is_cut = false;
    foreach ($words as $word) {
        $total_words_length += iconv_strlen($word);
        $words_count++;
        if ($total_words_length > $num_letters) {
            $is_cut = true;
            break;
        } else {
            ++$total_words_length;
        };
    }

    if ($is_cut) {
        $text = implode(" ", array_slice($words, 0, $words_count));
        $post_content = '<p>' . $text . '...</p><a class="post-text__more-link" href="#">Читать далее</a>';
    } else {
        $post_content = '<p>' . $text . '</p>';
    }

    return $post_content;
}

$page_content = include_template('main.php', ['popular_posts' => $popular_posts]);

$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'user_name' => $user_name]);

print($layout_content);
?>
