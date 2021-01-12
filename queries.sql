USE readme;

-- типы постов
INSERT INTO posts_types SET type_name = 'Текст', icon_class='text';
INSERT INTO posts_types SET type_name = 'Цитата', icon_class='quote';
INSERT INTO posts_types SET type_name = 'Фото', icon_class='photo';
INSERT INTO posts_types SET type_name = 'Видео', icon_class='video';
INSERT INTO posts_types SET type_name = 'Ссылка', icon_class='link';

-- пользователи
INSERT INTO users SET reg_date = '2019-01-15 15:06:18', email = 'larisa@mail.hru', user_name='Лариса', password='$2y$10$AMILwFU.wcAHUMSv3Mc/MuZMdrAKTTj2HwebHNZ2FuRvy1zyH.xzK', avatar='userpic-larisa-small.jpg';
INSERT INTO users SET reg_date = '2019-02-08 12:24:01', email = 'vladik@mail.hru', user_name='Владик', password='$2y$10$AMILwFU.wcAHUMSv3Mc/MuZMdrAKTTj2HwebHNZ2FuRvy1zyH.xzK', avatar='userpic.jpg';
INSERT INTO users SET reg_date = '2019-03-27 23:44:35', email = 'viktor@mail.hru', user_name='Виктор', password='$2y$10$AMILwFU.wcAHUMSv3Mc/MuZMdrAKTTj2HwebHNZ2FuRvy1zyH.xzK', avatar='userpic-mark.jpg';

-- посты
INSERT INTO posts SET user_id = 1, type_id = 2, post_date = '2021-01-01 15:06:18', title = 'Цитата', content='Мы в жизни любим только раз, а после ищем лишь похожих', is_repost = 0, views_total = 3;
INSERT INTO posts SET user_id = 2, type_id = 1, post_date = '2020-12-15 15:06:18', title = 'Игра престолов', content='Не могу дождаться начала финального сезона своего любимого сериала!', is_repost = 0, views_total = 6;
INSERT INTO posts SET user_id = 3, type_id = 3, post_date = '2020-11-25 15:06:18', title = 'Наконец, обработал фотки!', content='rock-medium.jpg', is_repost = 0, views_total = 10;
INSERT INTO posts SET user_id = 1, type_id = 3, post_date = '2021-10-01 15:06:18', title = 'Моя мечта', content='coast-medium.jpg', is_repost = 0, views_total = 5;
INSERT INTO posts SET user_id = 2, type_id = 5, post_date = '2020-09-08 15:06:18', title = 'Лучшие курсы', content='www.htmlacademy.ru', is_repost = 0, views_total = 7;

-- комментарии
INSERT INTO comments SET author_id = 1, post_id = 3, comment_date = '2021-01-02 15:06:18', content='Красиво!';
INSERT INTO comments SET author_id = 3, post_id = 5, comment_date = '2021-01-02 18:30:11', content='Точно, лучшие!';

-- список постов с сортировкой по популярности, с именами авторов и типом контента
SELECT p.id, post_date, u.user_name, t.type_name, title, views_total FROM posts p JOIN users u ON p.user_id = u.id JOIN posts_types t ON p.type_id = t.id ORDER BY views_total DESC;

-- список постов для конкретного пользователя
SELECT * FROM posts WHERE user_id = 2;

-- список комментариев для одного поста, в комментариях имя пользователя;
SELECT u.user_name, comment_date, c.content FROM comments c JOIN users u ON c.author_id = u.id WHERE post_id = 5;

-- добавление лайка к посту
INSERT INTO likes SET user_id = 1, post_id = 2;

-- подписка на пользователя
INSERT INTO subscribe SET user_id = 2, tracked_id = 3;

