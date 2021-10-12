<main class="page__main page__main--registration">
    <div class="container">
        <h1 class="page__title page__title--registration">Регистрация</h1>
    </div>
    <section class="registration container">
        <h2 class="visually-hidden">Форма регистрации</h2>
        <form class="registration__form form" action="reg.php" method="post" enctype="multipart/form-data">
            <div class="form__text-inputs-wrapper">
                <div class="form__text-inputs">
                <?php foreach ($reg_form['fields'] as $field): ?>
                    <?php if ($field['field_type'] !== 'input-file'): ?>
                        <div class="registration__input-wrapper form__input-wrapper">
                            <label class="registration__label form__label" for="<?= $field['name']; ?>"><?= $field['title']; ?><?= ($field['required']) ? ' <span class="form__input-required">*</span>' : ''; ?></label>
                            <div class="form__input-section<?= ($errors[$field['name']]) ? ' form__input-section--error' : ''; ?>">
                                <input class="registration__input form__input" id="<?= $field['name']; ?>" type="<?= $field['type']; ?>" name="<?= $field['name']; ?>" placeholder="<?= $field['placeholder'] ?? ''; ?>" value="<?= ($_POST[$field['name']]) ? $_POST[$field['name']] : ''; ?>">
                                <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
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
                <div class="registration__input-file-container form__input-container form__input-container--file">
                    <div class="registration__input-file-wrapper form__input-file-wrapper js-file-error form__input-section<?= ($errors[$field['name']]) ? ' form__input-section--error' : ''; ?>"<?= ($errors[$field['name']]) ? ' style="border: 2px solid #f02323!important;border-radius: 10px!important;"' : ''; ?>>
                        <div class="registration__file-zone form__file-zone js-dropzone">
                            <input class="registration__input-file form__input-file" id="<?= $field['name']; ?>" type="file" name="<?= $field['name']; ?>">
                            <div class="form__file-zone-text">
                                <span>Перетащите фото сюда</span>
                            </div>
                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                            <div class="form__error-text">
                                <h3 class="form__error-title">Файл с фото</h3>
                                <p class="form__error-desc"><?= ($errors[$field['name']]) ? $errors[$field['name']] : ''; ?></p>
                            </div>
                        </div>
                        <label class="registration__input-file-button form__input-file-button button" for="<?= $field['name']; ?>">
                            <span>Выбрать фото</span>
                            <svg class="registration__attach-icon form__attach-icon" width="10" height="20">
                                <use xlink:href="#icon-attach"></use>
                            </svg>
                        </label>
                    </div>
                    <div class="registration__file form__file js-preview" style="max-width:360px;">

                    </div>
                </div>
            <?php endif; ?>
            <button class="registration__submit button button--main" type="submit">Отправить</button>
        </form>
    </section>
</main>
