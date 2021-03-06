USE readme;

-- типы постов
INSERT INTO posts_types SET type_name = 'Текст', type='text';
INSERT INTO posts_types SET type_name = 'Цитата', type='quote';
INSERT INTO posts_types SET type_name = 'Фото', type='photo';
INSERT INTO posts_types SET type_name = 'Видео', type='video';
INSERT INTO posts_types SET type_name = 'Ссылка', type='link';

-- пользователи
INSERT INTO users SET reg_date = '2019-01-15 15:06:18', email = 'larisa@mail.hru', user_name='Лариса', password='$2y$10$AMILwFU.wcAHUMSv3Mc/MuZMdrAKTTj2HwebHNZ2FuRvy1zyH.xzK', avatar='userpic-larisa-small.jpg';
INSERT INTO users SET reg_date = '2019-02-08 12:24:01', email = 'vladik@mail.hru', user_name='Владик', password='$2y$10$AMILwFU.wcAHUMSv3Mc/MuZMdrAKTTj2HwebHNZ2FuRvy1zyH.xzK', avatar='userpic.jpg';
INSERT INTO users SET reg_date = '2019-03-27 23:44:35', email = 'viktor@mail.hru', user_name='Виктор', password='$2y$10$AMILwFU.wcAHUMSv3Mc/MuZMdrAKTTj2HwebHNZ2FuRvy1zyH.xzK', avatar='userpic-mark.jpg';
INSERT INTO users SET reg_date = '2019-03-31 12:00:00', email = 'elvira@mail.hru', user_name='Эльвира', password='$2y$10$AMILwFU.wcAHUMSv3Mc/MuZMdrAKTTj2HwebHNZ2FuRvy1zyH.xzK', avatar='userpic-elvira.jpg';

-- посты
INSERT INTO posts SET user_id = 1, type_id = 2, post_date = '2021-01-01 15:06:18', title = 'Цитата', content='Мы в жизни любим только раз, а после ищем лишь похожих', is_repost = 0, views_total = 3;
INSERT INTO posts SET user_id = 2, type_id = 1, post_date = '2020-12-15 15:06:18', title = 'Игра престолов', content='Не могу дождаться начала финального сезона своего любимого сериала!', is_repost = 0, views_total = 6;
INSERT INTO posts SET user_id = 3, type_id = 3, post_date = '2020-11-25 15:06:18', title = 'Наконец, обработал фотки!', content='rock-default.jpg', is_repost = 0, views_total = 10;
INSERT INTO posts SET user_id = 1, type_id = 3, post_date = '2021-10-01 15:06:18', title = 'Моя мечта', content='coast.jpg', is_repost = 0, views_total = 5;
INSERT INTO posts SET user_id = 2, type_id = 5, post_date = '2020-09-08 15:06:18', title = 'Лучшие курсы', content='http://www.htmlacademy.ru', is_repost = 0, views_total = 7;

-- комментарии
INSERT INTO comments SET author_id = 1, post_id = 3, comment_date = '2021-01-02 15:06:18', content='Красиво!';
INSERT INTO comments SET author_id = 3, post_id = 5, comment_date = '2021-01-02 18:30:11', content='Точно, лучшие!';

-- добавление лайка к посту
INSERT INTO likes SET user_id = 1, post_id = 2;

-- подписка на пользователя
INSERT INTO subscribe SET user_id = 2, tracked_id = 3;

