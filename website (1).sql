-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 23 2021 г., 21:25
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
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `pageCount` smallint(5) UNSIGNED NOT NULL,
  `publisher` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titleRussian` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titleOriginal` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publicationDate` date NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagePath` varchar(4096) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filePath` varchar(4096) COLLATE utf8mb4_unicode_ci NOT NULL
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
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`,`product`),
  ADD KEY `product` (`product`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
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
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

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
