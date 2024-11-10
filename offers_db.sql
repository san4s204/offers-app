-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 10 2024 г., 15:37
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `offers_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `offers`
--

INSERT INTO `offers` (`id`, `name`, `email`, `phone`, `created_at`) VALUES
(15, 'Blaack Friday Exclusive', 'representative3@example.com', '2234567890', '2024-11-09 06:34:30'),
(18, 'Spring Blossom Promotion', 'representative6@example.com', '', '2024-11-09 06:34:30'),
(19, 'Back to School Special', 'representative7@example.com', '4234567890', '2024-11-09 06:34:30'),
(20, 'Cybeer Monday Offers', 'representative8@example.com', '', '2024-11-09 06:34:30'),
(22, 'Limited Time Flash Sale', 'representative30@example.com', '0987654321', '2024-11-09 06:34:30'),
(23, 'Summer Sale 2024', 'san4s228@yandex.ru', '7777', '2024-11-09 07:18:30'),
(26, 'Safes 33%', 'san4s2280@yandex.ru', '79098437121', '2024-11-09 15:47:12'),
(27, 'Summer Getaway Deals', 'summerdeals@example.com', '1234567890', '2024-11-10 10:15:00'),
(28, 'Exclusive Members Discount', 'membersale@example.com', '0987654321', '2024-11-10 10:16:30'),
(29, 'Weekend Flash Sale', 'flashsale@example.com', '2345678901', '2024-11-10 10:18:00'),
(30, 'Holiday Season Offers', 'holidayoffers@example.com', '4567890123', '2024-11-10 10:20:45'),
(31, 'Mid-Year Clearance Sale', 'clearance@example.com', '5678901234', '2024-11-10 10:22:00'),
(32, 'Exclusive Online Promo', 'onlinepromo@example.com', '6789012345', '2024-11-10 10:23:30'),
(33, 'Free Shipping Weekend', 'freeshipping@example.com', '7890123456', '2024-11-10 10:25:00'),
(34, 'Loyalty Program Rewards', 'loyaltyrewards@example.com', '8901234567', '2024-11-10 10:26:45'),
(35, 'Winter Wonderland Specials', 'winterwonder@example.com', '9012345678', '2024-11-10 10:28:00'),
(36, 'Buy One Get Two Free', 'holidayoffers1@example.com', '4567990123', '2024-11-10 03:48:35');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
