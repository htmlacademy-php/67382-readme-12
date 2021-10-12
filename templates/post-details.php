<main class="page__main page__main--publication">
  <div class="container">
    <h1 class="page__title page__title--publication"><?= htmlspecialchars($post['title']); ?></h1>
    <section class="post-details">
      <h2 class="visually-hidden">Публикация</h2>
      <div class="post-details__wrapper post-<?= $post['type']; ?>">
        <div class="post-details__main-block post post--details">

        <?php switch ($post['type']):
            case 'quote': ?>
                <div class="post__main">
                    <blockquote>
                        <p><?= htmlspecialchars($post['content']); ?></p>
                        <cite><?= ($post['cite_author']) ? htmlspecialchars($post['cite_author']) : 'Неизвестный Автор'; ?></cite>
                    </blockquote>
                </div>
                <?php break;
            case 'text': ?>
                <div class="post__main">
                    <p><?= htmlspecialchars($post['content']); ?></p>
                </div>
                <?php break;
            case 'link': ?>
                <div class="post-link__wrapper">
                    <a class="post-link__external" href="http://<?= strip_tags($post['content']); ?>" title="Перейти по ссылке" style="align-items: center!important;">
                        <div class="post-link__icon-wrapper">
                            <img src="https://www.google.com/s2/favicons?domain=<?= strip_tags($post['content']); ?>" alt="Иконка" style="min-width: 48px!important;">
                        </div>
                        <div class="post-link__info">
                            <span><?= strip_tags($post['content']); ?></span>
                        </div>
                        <svg class="post-link__arrow" width="11" height="16">
                            <use xlink:href="#icon-arrow-right-ad"></use>
                        </svg>
                    </a>
                </div>
                <?php break;
            case 'video': ?>
                <div class="post-video__block">
                    <div class="post-video__preview">
                      <?= embed_youtube_cover($post['content'], '760', '396'); ?>
                    </div>
                    <div class="post-video__control">
                      <button class="post-video__play post-video__play--paused button button--video" type="button"><span class="visually-hidden">Запустить видео</span></button>
                      <div class="post-video__scale-wrapper">
                        <div class="post-video__scale">
                          <div class="post-video__bar">
                            <div class="post-video__toggle"></div>
                          </div>
                        </div>
                      </div>
                      <button class="post-video__fullscreen post-video__fullscreen--inactive button button--video" type="button"><span class="visually-hidden">Полноэкранный режим</span></button>
                    </div>
                    <button class="post-video__play-big button" type="button">
                      <svg class="post-video__play-big-icon" width="27" height="28">
                        <use xlink:href="#icon-video-play-big"></use>
                      </svg>
                      <span class="visually-hidden">Запустить проигрыватель</span>
                    </button>
                  </div>
                <?php break;
            case 'photo': ?>
                    <div class="post-details__image-wrapper post-photo__image-wrapper">
                        <img src="uploads/<?= strip_tags($post['content']); ?>" alt="Фото от пользователя" width="760" height="507">
                    </div>
                    <?php break;
            endswitch; ?>

          <div class="post__indicators">
            <div class="post__buttons">
              <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                <svg class="post__indicator-icon" width="20" height="17">
                  <use xlink:href="#icon-heart"></use>
                </svg>
                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                  <use xlink:href="#icon-heart-active"></use>
                </svg>
                <span>250</span>
                <span class="visually-hidden">количество лайков</span>
              </a>
              <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                <svg class="post__indicator-icon" width="19" height="17">
                  <use xlink:href="#icon-comment"></use>
                </svg>
                <span>25</span>
                <span class="visually-hidden">количество комментариев</span>
              </a>
              <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                <svg class="post__indicator-icon" width="19" height="17">
                  <use xlink:href="#icon-repost"></use>
                </svg>
                <span>5</span>
                <span class="visually-hidden">количество репостов</span>
              </a>
            </div>
            <span class="post__view"><?= $post['views_total']; ?> <?= get_noun_plural_form($post['views_total'], 'просмотр', 'просмотра', 'просмотров'); ?></span>
          </div>
          <div class="comments">
            <form class="comments__form form" action="#" method="post">
              <div class="comments__my-avatar">
                <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя" style="max-width: 100%!important;">
              </div>
              <div class="form__input-section form__input-section--error">
                <textarea class="comments__textarea form__textarea form__input" placeholder="Ваш комментарий"></textarea>
                <label class="visually-hidden">Ваш комментарий</label>
                <button class="form__error-button button" type="button">!</button>
                <div class="form__error-text">
                  <h3 class="form__error-title">Ошибка валидации</h3>
                  <p class="form__error-desc">Это поле обязательно к заполнению</p>
                </div>
              </div>
              <button class="comments__submit button button--green" type="submit">Отправить</button>
            </form>
            <div class="comments__list-wrapper">
              <ul class="comments__list">
                <li class="comments__item user">
                  <div class="comments__avatar">
                    <a class="user__avatar-link" href="#">
                      <img class="comments__picture" src="img/userpic-larisa.jpg" alt="Аватар пользователя" style="max-width: 100%!important;">
                    </a>
                  </div>
                  <div class="comments__info">
                    <div class="comments__name-wrapper">
                      <a class="comments__user-name" href="#">
                        <span>Лариса Роговая</span>
                      </a>
                      <time class="comments__time" datetime="2019-03-20">1 ч назад</time>
                    </div>
                    <p class="comments__text">
                      Красота!!!1!
                    </p>
                  </div>
                </li>
                <li class="comments__item user">
                  <div class="comments__avatar">
                    <a class="user__avatar-link" href="#">
                      <img class="comments__picture" src="img/userpic-larisa.jpg" alt="Аватар пользователя" style="max-width: 100%!important;">
                    </a>
                  </div>
                  <div class="comments__info">
                    <div class="comments__name-wrapper">
                      <a class="comments__user-name" href="#">
                        <span>Лариса Роговая</span>
                      </a>
                      <time class="comments__time" datetime="2019-03-18">2 дня назад</time>
                    </div>
                    <p class="comments__text">
                      Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
                    </p>
                  </div>
                </li>
              </ul>
              <a class="comments__more-link" href="#">
                <span>Показать все комментарии</span>
                <sup class="comments__amount">45</sup>
              </a>
            </div>
          </div>
        </div>
        <div class="post-details__user user">
          <div class="post-details__user-info user__info">
            <div class="post-details__avatar user__avatar">
              <a class="post-details__avatar-link user__avatar-link" href="#">
                <img class="post-details__picture user__picture" src="<?= $post['avatar'] ? 'uploads/avatars/' . strip_tags($post['avatar']) : 'img/icon-input-user.svg'; ?>" alt="Аватар пользователя">
              </a>
            </div>
            <div class="post-details__name-wrapper user__name-wrapper">
              <a class="post-details__name user__name" href="#">
                <span><?= isset($post['user_name']) ? htmlspecialchars($post['user_name']) : 'Неопознанный Енот'; ?></span>
              </a>
              <time class="post-details__time user__time" datetime="2014-03-20"><?= convert_date($post['reg_date'], true); ?> на сайте</time>
            </div>
          </div>
          <div class="post-details__rating user__rating">
            <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
              <span class="post-details__rating-amount user__rating-amount"><?= $post['subscr_total']; ?></span>
              <span class="post-details__rating-text user__rating-text"><?= get_noun_plural_form($post['subscr_total'], 'подписчик', 'подписчика', 'подписчиков'); ?></span>
            </p>
            <p class="post-details__rating-item user__rating-item user__rating-item--publications">
              <span class="post-details__rating-amount user__rating-amount"><?= $user_posts_total; ?></span>
              <span class="post-details__rating-text user__rating-text"><?= get_noun_plural_form($user_posts_total, 'публикация', 'публикации', 'публикаций'); ?></span>
            </p>
          </div>
          <div class="post-details__user-buttons user__buttons">
            <button class="user__button user__button--subscription button button--main" type="button">Подписаться</button>
            <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>
