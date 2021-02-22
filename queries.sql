USE readme;

-- список постов с сортировкой по популярности, с именами авторов и типом контента
SELECT p.id, post_date, u.user_name, t.type_name, title, views_total FROM posts p JOIN users u ON p.user_id = u.id JOIN posts_types t ON p.type_id = t.id ORDER BY views_total DESC;

-- список постов для конкретного пользователя
SELECT * FROM posts WHERE user_id = 2;

-- список комментариев для одного поста, в комментариях имя пользователя;
SELECT u.user_name, comment_date, c.content FROM comments c JOIN users u ON c.author_id = u.id WHERE post_id = 5;
