-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 12 2024 г., 19:05
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `Tinkov`
--

-- --------------------------------------------------------

--
-- Структура таблицы `in_messages`
--

CREATE TABLE `in_messages` (
  `id` int UNSIGNED NOT NULL,
  `message_id` varchar(11) NOT NULL,
  `chat_id` varchar(11) NOT NULL,
  `message` varchar(50) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `in_messages`
--

INSERT INTO `in_messages` (`id`, `message_id`, `chat_id`, `message`, `create_time`, `processed`) VALUES
(16, '19', '5271133713', '/start', '2024-07-03 16:31:33', 1),
(14, '17', '5073858368', 'new/', '2024-07-03 16:27:42', 1),
(15, '18', '5073858368', 'world', '2024-07-03 16:28:31', 1),
(17, '20', '5073858368', '10000', '2024-07-03 16:29:31', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `out_messages`
--

CREATE TABLE `out_messages` (
  `id` int UNSIGNED NOT NULL,
  `message_id` int NOT NULL,
  `chat_id` varchar(11) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `message` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int UNSIGNED NOT NULL,
  `message_id` varchar(11) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `ready_requests` json NOT NULL,
  `marker` int NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `message_id`, `ready_requests`, `marker`, `create_time`, `processed`) VALUES
(19, '18', '\"world\"', 0, '2024-07-16 18:55:22', 0),
(17, '17', '\"new/\"', 0, '2024-07-09 17:08:51', 0),
(18, '18', '\"world\"', 0, '2024-07-09 17:08:51', 0),
(20, '18', '\"world\"', 0, '2024-07-22 17:55:11', 0),
(21, '18', '\"world\"', 0, '2024-07-22 18:21:42', 0),
(22, '17', '\"new/\"', 0, '2024-07-22 18:35:48', 0),
(23, '19', '\"/start\"', 0, '2024-07-22 19:48:12', 0),
(24, '17', '\"new/\"', 0, '2024-07-22 19:56:32', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `responses`
--

CREATE TABLE `responses` (
  `id` int UNSIGNED NOT NULL,
  `message_id` int UNSIGNED NOT NULL,
  `response` json NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `responses`
--

INSERT INTO `responses` (`id`, `message_id`, `response`, `timestamp`, `processed`) VALUES
(1, 17, '{\"k-o-wobbler\": \"https://old.voblery.com.ua/lure-catalog/k-o-wobbler.html\", \"kastmaster-acme\": \"https://old.voblery.com.ua/lure-catalog/kastmaster-acme.html\"}', '2024-07-15 15:12:03', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `in_messages`
--
ALTER TABLE `in_messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `out_messages`
--
ALTER TABLE `out_messages`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `in_messages`
--
ALTER TABLE `in_messages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `out_messages`
--
ALTER TABLE `out_messages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
