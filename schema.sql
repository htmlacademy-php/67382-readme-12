CREATE DATABASE readme
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE readme;

-- Пользователи
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reg_date DATETIME,
  email VARCHAR(128),
  user_name VARCHAR(64),
  password VARCHAR(255),
  avatar VARCHAR(255),
  UNIQUE INDEX email (email)
);

-- Типы постов
CREATE TABLE posts_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type_name VARCHAR(64),
  type VARCHAR(64)
);

-- Тэги
CREATE TABLE tags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tag_name VARCHAR(64),
  UNIQUE INDEX tag_name (tag_name)
);

-- Подписки на пользователей
CREATE TABLE subscribe (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  tracked_id INT
);

-- Личные сообщения
CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_date DATETIME,
  author_id INT,
  recipient_id INT,
  content TEXT
);

-- Посты
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  type_id INT,
  post_date DATETIME,
  title VARCHAR(64),
  content TEXT,
  cite_author VARCHAR(64),
  is_repost TINYINT,
  initial_user_id INT,
  views_total INT,
  INDEX post_type (type_id),
  INDEX post_date (post_date),
  INDEX views_total (views_total),
  FULLTEXT INDEX post_text (title, content)
);

-- Комментарии
CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  comment_date DATETIME,
  content TEXT,
  author_id INT,
  post_id INT
);

-- Тэги постов
CREATE TABLE post_tags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT,
  tag_id INT
);

-- Лайки
CREATE TABLE likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  post_id INT,
  INDEX post_id (post_id)
);
