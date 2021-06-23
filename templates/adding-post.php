<main class="page__main page__main--adding-post">
    <div class="page__main-section">
    <div class="container">
        <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
    </div>
    <div class="adding-post container">
        <div class="adding-post__tabs-wrapper tabs">
        <div class="adding-post__tabs filters">
            <ul class="adding-post__tabs-list filters__list tabs__list">

            <?php if ($posts_types): ?>
                <?php foreach ($posts_types as $post_type): ?>
                <li class="adding-post__tabs-item filters__item">
                    <a class="adding-post__tabs-link filters__button filters__button--<?= $post_type['type']; ?><?=($post_type['type'] === $adding_type) ? ' filters__button--active' : ''; ?> tabs__item <?=($post_type['type'] === $adding_type) ? ' tabs__item--active' : ''; ?> button" href="add.php?type=<?= $post_type['type']; ?>">
                        <svg class="filters__icon" <?= icons_sizes($post_type['type']); ?>>
                            <use xlink:href="#icon-filter-<?= $post_type['type']; ?>"></use>
                        </svg>
                        <span><?= $post_type['type_name']; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            <?php endif; ?>
            </ul>
        </div>
        <div class="adding-post__tab-content">
            <section class="adding-post__<?= $posts_types[$adding_type]['type']; ?> tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления <?= $adding_form['title_part']; ?></h2>
                <form class="adding-post__form form" action="add.php?type=<?= $adding_type; ?>" method="post"<?=($adding_type === 'photo') ? ' enctype="multipart/form-data"' : ''; ?>>
                    <input type="hidden" name="adding_type" value="<?= $adding_type; ?>" id="adding_type">

                    <div class="form__text-inputs-wrapper">
                        <div class="form__text-inputs">

                        <?php foreach ($adding_form['fields'] as $field): ?>
                            <?php if ($field['field_type'] !== 'input-file'): ?>
                                <div class="adding-post__<?= $field['field_type']; ?>-wrapper form__<?= $field['field_type']; ?>-wrapper">
                                    <label class="adding-post__label form__label" for="<?= $field['name']; ?>"><?= $field['title']; ?><?= ($field['required']) ? ' <span class="form__input-required">*</span>' : ''; ?></label>
                                    <div class="form__input-section<?= ($errors[$field['name']]) ? ' form__input-section--error' : ''; ?>">
                                    <?php if ($field['field_type'] === 'textarea'): ?>
                                        <textarea class="adding-post__textarea<?= ($adding_type === 'quote') ? ' adding-post__textarea--quote' : ''; ?> form__textarea form__input" id="<?= $field['name']; ?>" name="<?= $field['name']; ?>" placeholder="<?= $field['placeholder'] ?? ''; ?>"><?= ($_POST[$field['name']]) ? ($_POST[$field['name']]) : ''; ?></textarea>
                                    <?php elseif ($field['field_type'] === 'input'): ?>
                                        <input class="adding-post__input form__input" id="<?= $field['name']; ?>" type="<?= $field['type']; ?>" name="<?= $field['name']; ?>" placeholder="<?= $field['placeholder'] ?? ''; ?>" value="<?= ($_POST[$field['name']]) ? $_POST[$field['name']] : ''; ?>">
                                    <?php endif; ?>
                                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>                                        </button>
                                        <div class="form__error-text">
                                            <h3 class="form__error-title"><?= $field['title']; ?></h3>
                                            <p class="form__error-desc"><?= ($errors[$field['name']]) ? $errors[$field['name']] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </div>
                        <?php if (isset($errors)): ?>
                            <div class="form__invalid-block">
                                <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                                <ul class="form__invalid-list">
                                    <?php foreach ($errors as $key => $error_text): ?>
                                        <li class="form__invalid-item"><?= sidebar_error_title($key, $adding_type) . $error_text; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($field['field_type'] === 'input-file'): ?>
                        <div class="adding-post__input-file-container form__input-container form__input-container--file">
                            <div class="adding-post__input-file-wrapper form__input-file-wrapper js-file-error form__input-section<?= ($errors[$field['name']]) ? ' form__input-section--error' : ''; ?>"<?= ($errors[$field['name']]) ? ' style="border: 2px solid #f02323!important;border-radius: 10px!important;"' : ''; ?>>
                                <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone js-dropzone">
                                    <input class="adding-post__input-file form__input-file" id="<?= $field['name']; ?>" type="file" name="<?= $field['name']; ?>">
                                    <div class="form__file-zone-text">
                                        <span>Перетащите фото сюда</span>
                                    </div>
                                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                    <div class="form__error-text">
                                        <h3 class="form__error-title">Файл с фото</h3>
                                        <p class="form__error-desc"><?= ($errors[$field['name']]) ? $errors[$field['name']] : ''; ?></p>
                                    </div>
                                </div>
                                <label class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" for="<?= $field['name']; ?>">
                                    <span>Выбрать фото</span>
                                    <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                                        <use xlink:href="#icon-attach"></use>
                                    </svg>
                                </label>
                            </div>
                            <div class="adding-post__file adding-post__file--photo form__file js-preview" style="max-width:360px;">

                            </div>
                        </div>

                    <?php endif; ?>
                    <div class="adding-post__buttons">
                        <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                        <a class="adding-post__close" href="index.php">Закрыть</a>
                    </div>
                </form>
            </section>

        </div>
        </div>
    </div>
    </div>
</main>
