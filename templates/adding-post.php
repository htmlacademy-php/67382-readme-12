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
                    <a class="adding-post__tabs-link filters__button filters__button--<?= $post_type['alias']; ?><?=((int) $post_type['id'] === $post_type_id) ? ' filters__button--active' : ''; ?> tabs__item <?=((int) $post_type['id'] === $post_type_id) ? ' tabs__item--active' : ''; ?> button" href="add.php?type_id=<?= $post_type['id']; ?>">
                        <svg class="filters__icon" <?= icons_sizes($post_type['alias']); ?>>
                            <use xlink:href="#icon-filter-<?= $post_type['alias']; ?>"></use>
                        </svg>
                        <span><?= $post_type['type_name']; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            <?php endif; ?>
            </ul>
        </div>
        <div class="adding-post__tab-content">
            <section class="adding-post__<?= $posts_types[$post_type_id]['alias']; ?> tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления <?= types_in_heading($post_type_id); ?></h2>
                <form class="adding-post__form form" action="add.php?type_id=<?= $post_type_id; ?>" method="post"<?=($post_type_id === 3) ? ' enctype="multipart/form-data"' : ''; ?>>
                    <input type="hidden" name="post_type_id" value="<?= $post_type_id; ?>" id="post_type_id">
                    <div class="form__text-inputs-wrapper">
                        <div class="form__text-inputs">
                            <div class="adding-post__input-wrapper form__input-wrapper">
                                <label class="adding-post__label form__label" for="post-heading">Заголовок <span class="form__input-required">*</span></label>
                                <div class="form__input-section<?= ($errors['title']) ? ' form__input-section--error' : ''; ?>">
                                    <input class="adding-post__input form__input" id="post-heading" type="text" name="post-heading" placeholder="Введите заголовок" value="<?= ($previous_values) ? $previous_values['title'] : ''; ?>">
                                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                    <div class="form__error-text">
                                        <h3 class="form__error-title">Заголовок поста</h3>
                                        <p class="form__error-desc"><?= ($errors['title']) ? $errors['title'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>

                            <?php if ($post_type_id < 3): ?>
                            <div class="adding-post__textarea-wrapper form__textarea-wrapper">
                                <label class="adding-post__label form__label" for="post-text"><?= text_in_label($post_type_id); ?><span class="form__input-required">*</span></label>
                                <div class="form__input-section<?= ($errors['content']) ? ' form__input-section--error' : ''; ?>">
                                    <textarea class="adding-post__textarea<?= ($post_type_id === 2) ? ' adding-post__textarea--quote' : ''; ?> form__textarea form__input" id="post-text" name="post-text" placeholder="<?= ($post_type_id === 2) ? 'Текст цитаты' : 'Введите текст публикации'; ?>"><?= ($previous_values) ? $previous_values['content'] : ''; ?></textarea>
                            <?php else: ?>
                            <div class="adding-post__input-wrapper form__input-wrapper">
                                <label class="adding-post__label form__label" for="post-url"><?= text_in_label($post_type_id); ?><?= ($post_type_id !== 3) ? '<span class="form__input-required">*</span>' : ''; ?></label>
                                <div class="form__input-section<?= ($errors['content']) ? ' form__input-section--error' : ''; ?>">
                                    <input class="adding-post__input form__input" id="post-url" type="text" name="post-url" placeholder="Введите ссылку" value="<?= ($previous_values) ? $previous_values['content'] : ''; ?>">
                            <?php endif; ?>
                                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                    <div class="form__error-text">
                                        <h3 class="form__error-title"><?= content_error_title($post_type_id); ?></h3>
                                        <p class="form__error-desc"><?= ($errors['content']) ? $errors['content'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>

                            <?php if ($post_type_id === 2): ?>
                            <div class="adding-post__textarea-wrapper form__input-wrapper">
                            <label class="adding-post__label form__label" for="cite-author">Автор <span class="form__input-required">*</span></label>
                            <div class="form__input-section<?= ($errors['cite_author']) ? ' form__input-section--error' : ''; ?>">
                                <input class="adding-post__input form__input" id="cite-author" type="text" name="cite-author" value="<?= ($previous_values) ? $previous_values['cite_author'] : ''; ?>">
                                <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                <div class="form__error-text">
                                <h3 class="form__error-title">Автор цитаты</h3>
                                <p class="form__error-desc"><?= ($errors['cite_author']) ? $errors['cite_author'] : ''; ?></p>
                                </div>
                            </div>
                            </div>
                            <?php endif; ?>

                            <div class="adding-post__input-wrapper form__input-wrapper">
                                <label class="adding-post__label form__label" for="post-tags">Теги</label>
                                <div class="form__input-section<?= ($errors['tags']) ? ' form__input-section--error' : ''; ?>">
                                    <input class="adding-post__input form__input" id="post-tags" type="text" name="post-tags" placeholder="Введите теги" value="<?= ($previous_values) ? $previous_values['tags'] : ''; ?>">
                                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                    <div class="form__error-text">
                                        <h3 class="form__error-title">Теги</h3>
                                        <p class="form__error-desc"><?= ($errors['tags']) ? $errors['tags'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <?php if (isset($errors)): ?>
                        <div class="form__invalid-block">
                            <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                            <ul class="form__invalid-list">
                                <?php foreach ($errors as $key => $error_text): ?>
                                    <li class="form__invalid-item"><?= sidebar_error_title($key, $post_type_id) . $error_text; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                    </div>

                    <?php if ($post_type_id === 3): ?>
                    <div class="adding-post__input-file-container form__input-container form__input-container--file">
                        <div class="adding-post__input-file-wrapper form__input-file-wrapper js-file-error form__input-section<?= ($errors['photo']) ? ' form__input-section--error' : ''; ?>"<?= ($errors['photo']) ? ' style="border: 2px solid #f02323!important;border-radius: 10px!important;"' : ''; ?>>
                            <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone js-dropzone">
                                <input class="adding-post__input-file form__input-file" id="file-photo" type="file" name="file-photo">
                                <div class="form__file-zone-text">
                                    <span>Перетащите фото сюда</span>
                                </div>
                                <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                <div class="form__error-text">
                                    <h3 class="form__error-title">Файл с фото</h3>
                                    <p class="form__error-desc"><?= ($errors['photo']) ? $errors['photo'] : ''; ?></p>
                                </div>
                            </div>
                            <label class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" for="file-photo">
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
