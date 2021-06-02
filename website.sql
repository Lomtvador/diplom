-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 23 2021 г., 20:49
-- Версия сервера: 10.4.19-MariaDB
-- Версия PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `website`
--

-- --------------------------------------------------------

--
-- Структура таблицы `artist`
--

CREATE TABLE `artist` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `artistproduct`
--

CREATE TABLE `artistproduct` (
  `id` int(10) UNSIGNED NOT NULL,
  `artist` int(10) UNSIGNED NOT NULL,
  `product` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `author`
--

CREATE TABLE `author` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `authorproduct`
--

CREATE TABLE `authorproduct` (
  `id` int(10) UNSIGNED NOT NULL,
  `author` int(10) UNSIGNED NOT NULL,
  `product` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `product` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cartstatus`
--

CREATE TABLE `cartstatus` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `language`
--

CREATE TABLE `language` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `pageCount` smallint(5) UNSIGNED NOT NULL,
  `publisher` int(10) UNSIGNED NOT NULL,
  `titleRussian` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titleOriginal` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publicationDate` date NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` tinyint(3) UNSIGNED NOT NULL,
  `category` tinyint(3) UNSIGNED NOT NULL,
  `imagePath` varchar(4096) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filePath` varchar(4096) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `publisher`
--

CREATE TABLE `publisher` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `rating`
--

CREATE TABLE `rating` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `type`
--

CREATE TABLE `type` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `surname` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `phoneNumber` bigint(20) UNSIGNED NOT NULL,
  `login` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `userproduct`
--

CREATE TABLE `userproduct` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `product` int(10) UNSIGNED NOT NULL,
  `purchaseDate` date NOT NULL,
  `price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `artistproduct`
--
ALTER TABLE `artistproduct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist` (`artist`,`product`),
  ADD KEY `product` (`product`);

--
-- Индексы таблицы `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `authorproduct`
--
ALTER TABLE `authorproduct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`,`product`),
  ADD KEY `product` (`product`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`,`user`,`product`),
  ADD KEY `user` (`user`),
  ADD KEY `product` (`product`);

--
-- Индексы таблицы `cartstatus`
--
ALTER TABLE `cartstatus`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`,`publisher`,`rating`,`language`,`category`),
  ADD KEY `publisher` (`publisher`),
  ADD KEY `rating` (`rating`),
  ADD KEY `language` (`language`),
  ADD KEY `category` (`category`);

--
-- Индексы таблицы `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `userproduct`
--
ALTER TABLE `userproduct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`,`product`),
  ADD KEY `product` (`product`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `artistproduct`
--
ALTER TABLE `artistproduct`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `author`
--
ALTER TABLE `author`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `authorproduct`
--
ALTER TABLE `authorproduct`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cartstatus`
--
ALTER TABLE `cartstatus`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `language`
--
ALTER TABLE `language`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rating`
--
ALTER TABLE `rating`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `type`
--
ALTER TABLE `type`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `userproduct`
--
ALTER TABLE `userproduct`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `artistproduct`
--
ALTER TABLE `artistproduct`
  ADD CONSTRAINT `artistproduct_ibfk_1` FOREIGN KEY (`artist`) REFERENCES `artist` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `artistproduct_ibfk_2` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `authorproduct`
--
ALTER TABLE `authorproduct`
  ADD CONSTRAINT `authorproduct_ibfk_1` FOREIGN KEY (`author`) REFERENCES `author` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `authorproduct_ibfk_2` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`status`) REFERENCES `cartstatus` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`type`) REFERENCES `type` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`publisher`) REFERENCES `publisher` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`rating`) REFERENCES `rating` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_4` FOREIGN KEY (`language`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_5` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `userproduct`
--
ALTER TABLE `userproduct`
  ADD CONSTRAINT `userproduct_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `userproduct_ibfk_2` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
