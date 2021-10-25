<main>
    <h1 class="visually-hidden">Главная страница сайта по созданию микроблога readme</h1>
    <div class="page__main-wrapper page__main-wrapper--intro container">
        <section class="intro">
        <h2 class="visually-hidden">Наши преимущества</h2>
        <b class="intro__slogan">Блог, каким<br> он должен быть</b>
        <ul class="intro__advantages-list">
            <li class="intro__advantage intro__advantage--ease">
            <p class="intro__advantage-text">
                Есть все необходимое для&nbsp;простоты публикации
            </p>
            </li>
            <li class="intro__advantage intro__advantage--no-excess">
            <p class="intro__advantage-text">
                Нет ничего лишнего, отвлекающего от сути
            </p>
            </li>
        </ul>
        </section>
        <section class="authorization">
            <h2 class="visually-hidden">Авторизация</h2>
            <form class="authorization__form form" action="index.php" method="post">
            <?php foreach ($login_form['fields'] as $field): ?>
                <div class="authorization__input-wrapper form__input-wrapper">
                    <div class="form__input-section<?= isset($errors[$field['name']]) ? ' form__input-section--error' : ''; ?>">
                        <input class="authorization__input form__input authorization__input--<?= ($field['type'] === 'password') ? 'password' : 'login'; ?>" id="<?= $field['name']; ?>" type="<?= $field['type']; ?>" name="<?= $field['name']; ?>" placeholder="<?= $field['title'] ?? ''; ?>" value="<?= isset($_POST[$field['name']]) ? $_POST[$field['name']] : ''; ?>">
                        <svg class="form__input-icon" <?= $field['icon-size']; ?>>
                            <use xlink:href="#icon-input-<?= $field['icon-name']; ?>"></use>
                        </svg>
                        <label class="visually-hidden"><?= $field['title']; ?>"></label>
                    </div>
                    <span class="form__error-label<?= ($field['type'] === 'email') ? ' form__error-label--login' : ''; ?>"><?= isset($errors[$field['name']]) ? $errors[$field['name']] : ''; ?></span>
                </div>
            <?php endforeach; ?>
                <a class="authorization__recovery" href="#">Восстановить пароль</a>
                <button class="authorization__submit button button--main" type="submit">Войти</button>
            </form>
        </section>
    </div>
</main>
