CREATE DATABASE readme
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE readme;

/* Пользователи */
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reg_date DATETIME,
  email CHAR(128),
  user_name CHAR(64),
  password CHAR(64),
  avatar CHAR(255)
);

CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX password ON users(password);

/* Типы постов */
CREATE TABLE posts_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type_name CHAR(64),
  icon_class CHAR(64)
);

INSERT INTO posts_types SET type_name = 'Текст', icon_class='text';
INSERT INTO posts_types SET type_name = 'Цитата', icon_class='quote';
INSERT INTO posts_types SET type_name = 'Картинка', icon_class='photo';
INSERT INTO posts_types SET type_name = 'Видео', icon_class='video';
INSERT INTO posts_types SET type_name = 'Ссылка', icon_class='link';

/* Тэги */
CREATE TABLE tags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tag_name CHAR(64)
);

CREATE UNIQUE INDEX tag_name ON tags(tag_name);

/* Подписки на пользователей */
CREATE TABLE subscribe (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  tracked_id INT
);

/* Личные сообщения */
CREATE TABLE private (
  id INT AUTO_INCREMENT PRIMARY KEY,
  msg_date DATETIME,
  author_id INT,
  recipient_id INT,
  msg_text TEXT
);

/* Посты */
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  type_id INT,
  post_date DATETIME,
  title CHAR(64),
  content TEXT,
  cite_author CHAR(64),
  is_repost TINYINT,
  initial_user_id INT,
  views_total INT
);

CREATE INDEX post_date ON posts(post_date);
CREATE INDEX views_total ON posts(views_total);
CREATE INDEX post_types ON posts(type_id);
CREATE FULLTEXT INDEX post_text ON posts(title, content);

/* Комментарии */
CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  comment_date DATETIME,
  content TEXT,
  author_id INT,
  post_id INT
);

/* Тэги постов */
CREATE TABLE post_tags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT,
  tag_id INT
);

/* Лайки */
CREATE TABLE likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  post_id INT
);

CREATE INDEX post_id ON likes(post_id);
