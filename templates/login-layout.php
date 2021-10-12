<main class="page__main page__main--login">
    <div class="container">
        <h1 class="page__title page__title--login">Вход</h1>
    </div>
    <section class="login container">
        <h2 class="visually-hidden">Форма авторизации</h2>
        <form class="login__form form" action="#" method="post">
        <?php foreach ($login_form['fields'] as $field): ?>
            <div class="login__input-wrapper form__input-wrapper">
                <label class="login__label form__label" for="<?= $field['name']; ?>"><?= $field['title']; ?></label>
                <div class="form__input-section">
                    <input class="login__input form__input" id="<?= $field['name']; ?>" type="<?= $field['type']; ?>" name="<?= $field['name']; ?>" placeholder="<?= $field['placeholder'] ?? ''; ?>" value="<?= ($_POST[$field['name']]) ? $_POST[$field['name']] : ''; ?>">
                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title"><?= $field['title']; ?></h3>
                            <p class="form__error-desc"><?= ($errors[$field['name']]) ? $errors[$field['name']] : ''; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
            <button class="login__submit button button--main" type="submit">Отправить</button>
        </form>
    </section>
</main>
