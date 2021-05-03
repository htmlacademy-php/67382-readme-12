<?php if ($popular_posts): ?>
    <?php foreach ($popular_posts as $post): ?>
        <article class="popular__post post post-<?= $post['type']; ?>">
            <header class="post__header">
                <a href="post.php?post_id=<?= $post['id']; ?>">
                    <h2><?= htmlspecialchars($post['title']); ?></h2>
                </a>
            </header>
            <div class="post__main">
            <?php switch ($post['type']):
                case 'quote': ?>
                    <blockquote>
                        <p><?= htmlspecialchars($post['content']); ?></p>
                        <cite><?= ($post['cite_author']) ? htmlspecialchars($post['cite_author']) : 'Неизвестный Автор'; ?></cite>
                    </blockquote>
                    <?php break;
                case 'text': ?>
                    <?= cut_post(htmlspecialchars($post['content'])); ?>
                    <?php break;
                case 'link': ?>
                    <div class="post-link__wrapper">
                        <a class="post-link__external" href="http://<?= strip_tags($post['content']); ?>" title="Перейти по ссылке">
                            <div class="post-link__info-wrapper">
                                <div class="post-link__icon-wrapper">
                                    <img src="https://www.google.com/s2/favicons?domain=<?= strip_tags($post['content']); ?>" alt="Иконка">
                                </div>
                                <div class="post-link__info">
                                    <h3><?= htmlspecialchars($post['title']); ?></h3>
                                </div>
                            </div>
                            <span><?= strip_tags($post['content']); ?></span>
                        </a>
                    </div>
                    <?php break;
                case 'video': ?>
                    <div class="post-video__block">
                        <div class="post-video__preview">
                            <?= embed_youtube_cover($post['content'], '360', '188'); ?>
                        </div>
                        <a href="post.php?post_id=<?= $post['id']; ?>" class="post-video__play-big button">
                            <svg class="post-video__play-big-icon" width="14" height="14">
                                <use xlink:href="#icon-video-play-big"></use>
                            </svg>
                            <span class="visually-hidden">Запустить проигрыватель</span>
                        </a>
                    </div>
                    <?php break;
                case 'photo': ?>
                    <div class="post-photo__image-wrapper">
                        <img src="uploads/<?= strip_tags($post['content']); ?>" alt="Фото от пользователя" width="360" height="240">
                    </div>
                    <?php break;
            endswitch; ?>
            </div>
            <footer class="post__footer">
                <div class="post__author">
                    <a class="post__author-link" href="#" title="Автор">
                        <div class="post__avatar-wrapper">
                            <img class="post__author-avatar" src="img/<?= isset($post['avatar']) ? strip_tags($post['avatar']) : 'icon-input-user.svg'; ?>" alt="Аватар пользователя" style="max-width: 40px!important;max-height: 40px!important;">
                        </div>
                        <div class="post__info">
                            <b class="post__author-name"><?= isset($post['user_name']) ? htmlspecialchars($post['user_name']) : 'Неопознанный Енот'; ?></b>
                            <time class="post__time" datetime="<?= $post['post_date']; ?>" title="<?= date('d.m.Y H:i', strtotime($post['post_date'])); ?>"><?= convert_date($post['post_date'], false); ?> назад</time>
                        </div>
                    </a>
                </div>
                <div class="post__indicators">
                    <div class="post__buttons">
                        <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                            <svg class="post__indicator-icon" width="20" height="17">
                                <use xlink:href="#icon-heart"></use>
                            </svg>
                            <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                <use xlink:href="#icon-heart-active"></use>
                            </svg>
                            <span><?= $post['likes_total']; ?></span>
                            <span class="visually-hidden">количество лайков</span>
                        </a>
                        <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                            <svg class="post__indicator-icon" width="19" height="17">
                                <use xlink:href="#icon-comment"></use>
                            </svg>
                            <span><?= $post['comments_total']; ?></span>
                            <span class="visually-hidden">количество комментариев</span>
                        </a>
                    </div>
                </div>
            </footer>
        </article>
    <?php endforeach;
else: ?>
    <p>Нет постов</p>
<?php endif; ?>
