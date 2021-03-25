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
                    <a class="adding-post__tabs-link filters__button filters__button--<?= $post_type['icon_class']; ?><?=((int) $post_type['id'] === $filters_type) ? ' filters__button--active' : ''; ?> tabs__item <?=((int) $post_type['id'] === $filters_type) ? ' tabs__item--active' : ''; ?> button" href="add.php?id=<?= $post_type['id']; ?>">
                        <svg class="filters__icon" <?= icons_sizes($post_type['icon_class']); ?>>
                            <use xlink:href="#icon-filter-<?= $post_type['icon_class']; ?>"></use>
                        </svg>
                        <span><?= $post_type['type_name']; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            <?php endif; ?>
            </ul>
        </div>
        <div class="adding-post__tab-content">
            <section class="adding-post__<?= $posts_types[$filters_type]['icon_class']; ?> tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления <?= types_in_heading($filters_type); ?></h2>
                <form class="adding-post__form form" action="add.php" method="post"<?=($filters_type === 3) ? ' enctype="multipart/form-data"' : ''; ?>>
                    <div class="form__text-inputs-wrapper">
                        <div class="form__text-inputs">
                            <div class="adding-post__input-wrapper form__input-wrapper">
                                <label class="adding-post__label form__label" for="post-heading">Заголовок <span class="form__input-required">*</span></label>
                                <div class="form__input-section">
                                    <input class="adding-post__input form__input" id="post-heading" type="text" name="post-heading" placeholder="Введите заголовок">
                                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                    <div class="form__error-text">
                                        <h3 class="form__error-title">Заголовок сообщения</h3>
                                        <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                    </div>
                                </div>
                            </div>

                            <?php if ($filters_type < 3): ?>
                            <div class="adding-post__textarea-wrapper form__textarea-wrapper">
                                <label class="adding-post__label form__label" for="post-text"><?= text_in_label($filters_type); ?><span class="form__input-required">*</span></label>
                                <div class="form__input-section">
                                    <textarea class="adding-post__textarea<?=($filters_type === 2) ? ' adding-post__textarea--quote' : ''; ?> form__textarea form__input" id="post-text" name="post-text" placeholder="<?=($filters_type === 2) ? 'Текст цитаты' : 'Введите текст публикации'; ?>"></textarea>
                            <?php else: ?>
                            <div class="adding-post__input-wrapper form__input-wrapper">
                                <label class="adding-post__label form__label" for="post-url"><?= text_in_label($filters_type); ?><?=($filters_type !== 3) ? '<span class="form__input-required">*</span>' : ''; ?></label>
                                <div class="form__input-section">
                                    <input class="adding-post__input form__input" id="post-url" type="text" name="post-url" placeholder="Введите ссылку">
                            <?php endif; ?>
                                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                    <div class="form__error-text">
                                        <h3 class="form__error-title">Заголовок сообщения</h3>
                                        <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                    </div>
                                </div>
                            </div>

                            <?php if ($filters_type === 2): ?>
                            <div class="adding-post__textarea-wrapper form__input-wrapper">
                            <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
                            <div class="form__input-section">
                                <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author">
                                <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                <div class="form__error-text">
                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                </div>
                            </div>
                            </div>
                            <?php endif; ?>

                            <div class="adding-post__input-wrapper form__input-wrapper">
                                <label class="adding-post__label form__label" for="post-tags">Теги</label>
                                <div class="form__input-section">
                                    <input class="adding-post__input form__input" id="post-tags" type="text" name="post-tags" placeholder="Введите теги">
                                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                    <div class="form__error-text">
                                        <h3 class="form__error-title">Заголовок сообщения</h3>
                                        <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form__invalid-block">
                            <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                            <ul class="form__invalid-list">
                                <li class="form__invalid-item">Заголовок. Это поле должно быть заполнено.</li>
                                <li class="form__invalid-item">Цитата. Она не должна превышать 70 знаков.</li>
                            </ul>
                        </div>

                    </div>

                    <?php if ($filters_type === 3): ?>
                    <div class="adding-post__input-file-container form__input-container form__input-container--file">
                        <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                            <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                                <input class="adding-post__input-file form__input-file" id="file-photo" type="file" name="file-photo" title=" ">
                                <div class="form__file-zone-text">
                                    <span>Перетащите фото сюда</span>
                                </div>
                            </div>
                            <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" type="button">
                                <span>Выбрать фото</span>
                                <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                                    <use xlink:href="#icon-attach"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">

                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="adding-post__buttons">
                        <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                        <a class="adding-post__close" href="#">Закрыть</a>
                    </div>

                </form>
            </section>

        </div>
        </div>
    </div>
    </div>
</main>
