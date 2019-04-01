-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2019. Ápr 01. 15:18
-- Kiszolgáló verziója: 10.1.38-MariaDB
-- PHP verzió: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `library`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `publishing` date NOT NULL,
  `story` varchar(255) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `lid` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `writer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `book`
--

INSERT INTO `book` (`book_id`, `publishing`, `story`, `book_title`, `cover_image`, `lid`, `quantity`, `language_id`, `writer_id`, `category_id`) VALUES
(7, '2019-03-08', 'Jó könyv.', 'A homály visszatér - A Gyűrűk Ura históriája I.', 'hom.jpg', 'Keményfedeles', 200, 1, 2, 3),
(9, '2019-03-16', 'Ez is jó könyv.', 'A szilmarilok', 'szilm.jpg', 'Keményfedeles', 2000, 1, 2, 3),
(10, '2019-03-02', 'Nem rossz könyv.', 'Twilight - Alkonyat', 'alko.jpg', 'Keményfedeles', 200, 1, 3, 3),
(11, '2019-04-03', 'Érdekes könyv.', 'Égvilág - Az új birodalom - III. könyv', 'eg.jpg', 'Keményfedeles', 100, 1, 4, 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `category`
--

INSERT INTO `category` (`id`, `genre`) VALUES
(3, 'Fantasy'),
(4, 'Horror'),
(13, 'Krimi'),
(5, 'Romantikus'),
(11, 'Sci-fi');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `languages`
--

INSERT INTO `languages` (`id`, `language`) VALUES
(3, 'Angol'),
(1, 'Magyar'),
(4, 'Német'),
(5, 'Olasz');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `birthday`) VALUES
(1, 'admin', '1bbd886460827015e5d605ed44252251', 'admin@gmail.com', '2019-03-29');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `writer`
--

CREATE TABLE `writer` (
  `id` int(11) NOT NULL,
  `writer_name` varchar(255) NOT NULL,
  `writer_picture` varchar(255) NOT NULL,
  `writer_birthday` date NOT NULL,
  `life_story` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `writer`
--

INSERT INTO `writer` (`id`, `writer_name`, `writer_picture`, `writer_birthday`, `life_story`) VALUES
(2, 'J. R. R. Tolkien', 'tolk.jpg', '2019-03-15', 'Jó író.'),
(3, 'Stephenie Meyer', 'steph.jpg', '2019-03-07', 'Nem rossz író.'),
(4, 'Licia Troisi', 'lic.jpg', '2019-03-07', 'Érdekes író.');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `writer_id` (`writer_id`,`category_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `language_id` (`language_id`);

--
-- A tábla indexei `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genre` (`genre`);

--
-- A tábla indexei `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `language` (`language`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A tábla indexei `writer`
--
ALTER TABLE `writer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `writer_name` (`writer_name`),
  ADD UNIQUE KEY `life_story` (`life_story`),
  ADD UNIQUE KEY `writer_picture` (`writer_picture`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT a táblához `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT a táblához `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `writer`
--
ALTER TABLE `writer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`writer_id`) REFERENCES `writer` (`id`),
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `book_ibfk_3` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
