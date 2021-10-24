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
 * Возвращает текст названия поля перед текстом ошибки в сайдбаре
 *
 * @param string $key - поле с ошибкой
 * @param string $post_type - тип поста
 * @return string текст заголовка ошибки
 *
 */

function sidebar_error_title($key, $post_type) {
    switch ($key) {
        case 'post-heading':
            return 'Заголовок. ';
        case 'cite_author':
            return 'Автор. ';
        case 'tags':
            return 'Теги. ';
        case 'file-photo':
        case 'file-userpic':
                return 'Файл с фото. ';
        case 'reg-email':
            return 'Электронная почта. ';
        case 'login':
            return 'Логин. ';
        case 'reg-password':
            return 'Пароль. ';
        case 'password-repeat':
            return 'Повтор пароля. ';
        case 'post-text':
            switch ($post_type) {
                case 'quote':
                    return 'Цитата. ';
                case 'text':
                    return 'Текст поста. ';
        }
        case 'post-url':
            switch ($post_type) {
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
 * Переход на страницу ленты постов, если есть сессия
 *
 */

function check_session() {
    if (!empty($_SESSION['user'])) {
        header('Location: feed.php');
        exit();
    }
}

/**
 * Переход на главную страницу, если нет сессии
 *
 */

function check_no_session() {
    if (empty($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
}

/**
 * Переход на предыдущую страницу
 *
 */

function go_back() {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

/**
 * Добавляет к ссылке имя протокола, если его нет
 *
 * $url_string - ссылка, введенная пользователем
 * @return string $check_url ссылка, которая всегда начинается с имени протокола
 *
 */

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
    if ($is_err_404) {
        header("HTTP/1.1 404 Not Found");
    }
    if (!empty($_SESSION['user'])) {
        $layout_content = include_template('layout', [
            'content' => $page_content,
            'page_name' => 'readme: ошибка!',
            'user_name' => $_SESSION['user']['user_name'],
            'avatar' => $_SESSION['user']['avatar'],
            'active_page' => 'error',
            'search_form_text' => (isset($search_form_text) ?? '')
        ]);
    } else {
        $layout_content = include_template('layout', [
            'content' => $page_content,
            'page_name' => 'readme: ошибка!',
            'active_page' => 'error',
        ]);
    }
    print($layout_content);
    exit;
}

/**
 * Проверка заполнения обязательного поля формы.
 *
 * @param string $field_name - имя поля
 * @return string - текст ошибки, если поле не заполнено
 *
 */

function validateFilled($field_name) {
    if (empty($_POST[$field_name])) {
        return 'Это поле должно быть заполнено';
    }
}

/**
 * Проверка длины цитаты.
 *
 * @param string $field_name - имя поля
 * @return string - текст ошибки, если цитата слишком длинная
 *
 */

function validateQuoteLength($field_name) {
    if (strlen($_POST[$field_name]) > 70) {
        return 'Цитата не должна превышать 70 знаков.';
    }
}

/**
 * Проверка, является ли текст в поле ссылкой.
 *
 * @param string $field_name - имя поля
 * @return string - текст ошибки, если в поле не ссылка
 *
 */

function validateUrl($field_name) {
    if (!filter_var(make_link($_POST[$field_name]), FILTER_VALIDATE_URL)) {
        return 'Текст в поле не является ссылкой';
    }
    return false;
}

/**
 * Проверяет, является ли текст в поле корректным e-mail-адресом
 *
 * @param string $field_name - имя поля
 * @return string - текст ошибки, если в поле не e-mail
 *
 */

function validateEmailCorrect($field_name) {
    if (!filter_var($_POST[$field_name], FILTER_VALIDATE_EMAIL)) {
        return 'Значение поля не является корректным email-адресом';
    }
    return false;
}

/**
 * Проверяет e-mail на уникальность
 *
 * @param string $field_name - имя поля
 * @param $con - ресурс соединения
 * @return string - текст ошибки, если e-mail найден в базе
 *
 */

function validateEmailUnique($field_name, $con) {
    $email = mysqli_real_escape_string($con, $_POST[$field_name]);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);
    if (mysqli_num_rows($res) > 0) {
        return 'Пользователь с этим email-адресом уже существует';
    }
    return false;
}

/**
 * Проверка длины пароля.
 *
 * @param string $field_name - имя поля
 * @return string - текст ошибки, если пароль слишком короткий
 *
 */

function validatePasswordLength($field_name) {
    if (strlen($_POST[$field_name]) < 5) {
        return 'Пароль должен быть не менее 5 знаков';
    }
}

/**
 * Проверка совпадения паролей в двух полях ввода.
 *
 * @param string $field_name - имя поля
 * @param string $add_field - имя второго поля
 * @return string - текст ошибки, если пароли не совпадают
 *
 */

function validatePassword($field_name, $add_field) {
    if ($_POST[$field_name] !== $_POST[$add_field]) {
        return 'Пароли не совпадают';
    }
    return false;
}

/**
 * Валидация формы, запуск всех проверок всех полей
 *
 * @param string $form - имя формы
 * @param $con - ресурс соединения, для проверки уникальности e-mail'а
 * @return array - $errors массив ошибок для всех полей, кроме фото
 * для фото: двумерный массив, 0 элемент $errors массив ошибок, 1 элемент $isPhotoAtLink bool фото берется по ссылке или загружено
 * для фото по ссылке добавляется 2 элемент "ссылка", т.к. ссылка при проверке модифицируется
 *
 */

function validate_form($form, $con) {
    $errors = [];
    $add_field_name = '';
    $complex_validation_field = '';
    foreach ($form['fields'] as $field) {
        if (isset($field['validations_field'])) {
            $add_field_name = $field['name'];
            $complex_validation_field = $field['validations_field'];
        } else {
            if ($field['name'] === $complex_validation_field) {
                $photo_result = validatePhoto($field['name'], $add_field_name);
                $temp_errors = $photo_result[0];
                $isPhotoAtLink = $photo_result[1];
                $errors = array_merge($errors, $temp_errors);
                $complex_validation_field = '';
                $add_field_name = '';
            } else {
                validate_field($field, $errors, $con);
            }
        }
    }
    if (isset($isPhotoAtLink)) {
        if ($isPhotoAtLink) {
            return [$errors, $isPhotoAtLink, $photo_result[2]];
        }
        return [$errors, $isPhotoAtLink];
    }
    return $errors;
}

/**
 * Валидация поля по всем проверкам, если не используется совместная валидация двух полей.
 *
 * @param $field - поле
 * @param &$errors - массив с ошибками функции validate_form
 * @param $con - ресурс соединения, для проверки уникальности e-mail'а
 *
 */

function validate_field($field, &$errors, $con) {
    foreach ($field['validations'] as $key => $validation) {
        if (!isset($errors[$field['name']])) {
            if (($field['name'] === 'reg-email') && ($key === 2)) {
                $error = $validation($field['name'], $con);
            } else {
                $error = $validation($field['name']);
            }
            if ($error) {
                $errors[$field['name']] = $error;
            }
        }
    }
    return false;
}

/**
 * Валидация фото, загруженного пользователем или по ссылке.
 *
 * @param string $field_name - имя поля (загруженный файл фото)
 * @param string $add_field - имя второго поля (ссылка на фото)
 * @return array 0 элемент $temp_errors временный массив ошибок, который будет добавлен к основному вызывающей функцией
 * 1 элемент $isPhotoAtLink bool фото берется по ссылке или загружено
 * для фото по ссылке добавляется 2 элемент "ссылка", т.к. ссылка при проверке модифицируется
 *
 */

function validatePhoto($field_name, $add_field) {
    $temp_errors = [];
    if ($_FILES[$field_name]['size'] > 0) {
        $pictureValidation = validateUploadedPicture($field_name);
        if ($pictureValidation) {
            $temp_errors[$field_name] = $pictureValidation;
        } else {
            $isPhotoAtLink = false;
        }
    } else {
        $photo_url = filter_var(make_link($_POST[$add_field]), FILTER_VALIDATE_URL);
        if ($photo_url) {
            $photo_file = file_get_contents($photo_url);
            if ($photo_file) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file_type = finfo_buffer($finfo, $photo_file);
                if (($file_type !== 'image/jpeg') && ($file_type !== 'image/gif') && ($file_type !== 'image/png')) {
                    $temp_errors[$add_field] = 'По ссылке отсутствует изображение в формате jpeg, png или gif';
                } else {
                    $isPhotoAtLink = true;
                }
            } else {
                $temp_errors[$add_field] = 'Невозможно загрузить изображение по ссылке';
            }
        } else {
            $temp_errors[$add_field] = 'Загрузите изображение или укажите ссылку на него';
            $temp_errors[$field_name] = 'Загрузите изображение или укажите ссылку на него';
        }
    }
    if ($isPhotoAtLink) {
        return [$temp_errors, $isPhotoAtLink, $photo_url];
    }
    return [$temp_errors, false];
}

/**
 * Проверка фото, загруженного пользователем.
 *
 * @param string $field_name - имя поля
 * @return string|bool строка ошибки или false, если нет ошибки
 *
 */

function validateUploadedPicture($field_name) {
    if ($_FILES[$field_name]['size'] > 0) {
        $tmp_name = $_FILES[$field_name]['tmp_name'];
        $file_size = $_FILES[$field_name]['size'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if (($file_type !== 'image/jpeg') && ($file_type !== 'image/gif') && ($file_type !== 'image/png')) {
            return 'Загрузите изображение в формате jpeg, png или gif';
        }
    }
    return false;
}
