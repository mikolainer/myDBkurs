-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 05 2021 г., 22:21
-- Версия сервера: 5.6.47
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `my_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `delo`
--

CREATE TABLE `delo` (
  `place` varchar(255) NOT NULL,
  `descr` text NOT NULL,
  `uch` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `mero` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dattime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `descr` text NOT NULL,
  `num` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `merop`
--

CREATE TABLE `merop` (
  `id` int(11) NOT NULL,
  `org` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `descr` text,
  `dattime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `merop`
--

INSERT INTO `merop` (`id`, `org`, `name`, `descr`, `dattime`) VALUES
(1, 'mikolainer', 'kek', '', '0000-00-00 00:00:00'),
(2, 'mikolainer', 'lol', '123', '1999-01-01 01:01:00'),
(3, 'mikolainer', '123', '15632', '2021-05-12 19:49:00'),
(4, 'mikolainer', 'zaz', '', '0000-00-00 00:00:00'),
(5, 'mikolainer', 'za', NULL, NULL),
(6, 'mikolainer', 'mda', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `oborud`
--

CREATE TABLE `oborud` (
  `place` varchar(255) NOT NULL,
  `inv_num` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `descr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `organizator`
--

CREATE TABLE `organizator` (
  `name` varchar(255) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `pwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `organizator`
--

INSERT INTO `organizator` (`name`, `mail`, `phone`, `pwd`) VALUES
(NULL, 'azazazel', NULL, ''),
(NULL, 'azazazel1234', NULL, '1234'),
('Nikolay', 'mikolainer', '123', '1'),
(NULL, 'test', NULL, 'test'),
('test testovich', 'test1111', '12354', '321');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `name` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `ev` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `uchastnik`
--

CREATE TABLE `uchastnik` (
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `delo`
--
ALTER TABLE `delo`
  ADD PRIMARY KEY (`uch`,`role`);

--
-- Индексы таблицы `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `merop`
--
ALTER TABLE `merop`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oborud`
--
ALTER TABLE `oborud`
  ADD PRIMARY KEY (`inv_num`);

--
-- Индексы таблицы `organizator`
--
ALTER TABLE `organizator`
  ADD PRIMARY KEY (`mail`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `uchastnik`
--
ALTER TABLE `uchastnik`
  ADD PRIMARY KEY (`mail`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `merop`
--
ALTER TABLE `merop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `oborud`
--
ALTER TABLE `oborud`
  MODIFY `inv_num` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
