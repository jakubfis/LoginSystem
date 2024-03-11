-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 06. bře 2024, 09:23
-- Verze serveru: 10.4.24-MariaDB
-- Verze PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `loginsystem`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `citaty`
--

CREATE TABLE `citaty` (
  `id` int(11) NOT NULL,
  `citat` text DEFAULT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `uzivatel_id` int(11) DEFAULT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `citaty`
--

INSERT INTO `citaty` (`id`, `citat`, `autor`, `uzivatel_id`, `datum`) VALUES
(1, '„Minecraft je život“', 'Já', 0, '2024-02-28 08:43:06'),
(35, '„Tak jako hejno krkavců snesli se na tuto zemi, aby vyklovali každé zrnko zlata a stříbra. Nemají slitování. Jejich srdce zjedovatěla touhou po bohatství. Se vším kupčí, všechno prodávají. Chceš pokřtít dítě? Zaplať! Chceš loupit a vraždit? Zaplať a bude ti odpuštěno. Ale pak, kdyby sám ďábel zaplatil, vstoupil by na nebesa? A za peníze takto vydřené z chudého lidu koně krásné chovají, čeleď nepotřebnou drží, v kostky hrají a na své kuběny drahé věší, zatímco Kristus chodil bos a neměl, kde by hlavu složil.“', 'Jan Hus', NULL, '2024-03-05 18:01:34'),
(36, '„Nevěř tomu, čemu nerozumíš, ale nezavrhuj, cos neprozkoumal.“', 'Karel Čapek', NULL, '2024-03-05 18:27:33'),
(37, '„Je těžké být dvojsmyslný v době, kdy slova nic neznamenají.“', 'Stanislaw Jerzy Lec', NULL, '2024-03-05 18:28:14'),
(38, '„Neříkej vždy, co víš, ale vždy se snaž vědět, co říkáš.“', 'Matthias Claudius', NULL, '2024-03-05 18:29:10'),
(39, '„Osel se líbí oslu, svině svini.“', 'Walter von der Vogelweide', NULL, '2024-03-05 18:30:06'),
(40, '„Víte, je smutné, co peníze dělají s lidmi.“', 'Ozzy Osbourne', NULL, '2024-03-05 18:30:47'),
(41, '„Podívejte se na mě a uvidíte blázna; podívejte se na mě a uvidíte boha; podívejte se na mě zpříma a uvidíte sebe.“', 'Charles Manson', NULL, '2024-03-05 18:31:24');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `is_admin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `create_datetime`, `is_admin`) VALUES
(0, 'kero', 'kero@kero.cz', 'e10adc3949ba59abbe56e057f20f883e', '2024-02-28 08:18:55', 1),
(25, 'jakub', 'jakub@email.cz', 'c33367701511b4f6020ec61ded352059', '2024-02-28 08:38:01', 0),
(26, 'admin', 'admin@admin.cz', '4b583376b2767b923c3e1da60d10de59', '2024-02-28 10:36:47', 1),
(27, 'panko', '', 'e10adc3949ba59abbe56e057f20f883e', '2024-02-28 17:25:26', 0),
(28, 'lol', 'lol@email.cz', 'e10adc3949ba59abbe56e057f20f883e', '2024-02-29 14:56:48', 0);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `citaty`
--
ALTER TABLE `citaty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uzivatel_id` (`uzivatel_id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `citaty`
--
ALTER TABLE `citaty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `citaty`
--
ALTER TABLE `citaty`
  ADD CONSTRAINT `citaty_ibfk_1` FOREIGN KEY (`uzivatel_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
