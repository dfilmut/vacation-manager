-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Czas generowania: 15 Lut 2023, 19:42
-- Wersja serwera: 10.5.18-MariaDB-10+deb11u1
-- Wersja PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `dfilmut`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `php_users`
--

CREATE TABLE `php_users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `position` varchar(40) NOT NULL,
  `department` varchar(40) NOT NULL,
  `role` varchar(40) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `vacation_days_avaliable` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Zrzut danych tabeli `php_users`
--

INSERT INTO `php_users` (`user_id`, `login`, `password`, `email`, `name`, `surname`, `position`, `department`, `role`, `manager_id`, `vacation_days_avaliable`) VALUES
(33, 'kierownik1', '4a8e415057b6a07fcc83399d82527802', 'kierownik1@dfilmut.com', 'Kierownik1', 'Kierownik1', 'Kierownik IT', 'IT', 'kierownik', 1, 10),
(12, 'dfilmut', '202cb962ac59075b964b07152d234b70', '', 'Damian', 'Filmut', 'Team Leader', 'IT', 'administrator', 1, 32),
(34, 'kierownik2', 'a94b8531efebb6fd5690e019b94764d2', 'kierownik2@dfilmut.com', 'Kierownik2', 'Kierownik2', 'Kierownik Biznes', 'Biznes', 'kierownik', 2, 26),
(35, 'kierownik3', 'c6b8bbfb3f8a677c9b5239fdbcaaa4ab', 'kierownik3@dfilmut.com', 'Kierownik3', 'Kierownik3', 'Kierownik Kadry', 'Kadry', 'kadry', 3, 12),
(32, 'pracownik1', 'a03d603193c93860b74fb3839bc62716', 'pracownik1@dfilmut.com', 'Pracownik1', 'Pracownik1', 'Programista PHP', 'IT', 'pracownik', 1, 10),
(31, 'kadry', 'c92f83808f86e22b53d8858bc1563596', 'kadry@dfilmut.com', 'Kadry', 'Kadry', 'Kadry', 'Kadry', 'kadry', 3, 100),
(36, 'pracownik2', 'b6d6eaef51cbe3abd95cdc336edd5086', 'pracownik2@dfilmut.com', 'Pracownik2', 'Pracownik2', 'Administrator Systemu', 'IT', 'pracownik', 2, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `php_vacations`
--

CREATE TABLE `php_vacations` (
  `vacation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vacation_date_from` date NOT NULL,
  `vacation_date_to` date NOT NULL,
  `vacation_days_count` int(11) NOT NULL,
  `status` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Zrzut danych tabeli `php_vacations`
--

INSERT INTO `php_vacations` (`vacation_id`, `user_id`, `vacation_date_from`, `vacation_date_to`, `vacation_days_count`, `status`) VALUES
(64, 12, '2023-02-14', '2023-02-19', 4, 'Odrzucony'),
(63, 12, '2023-02-20', '2023-02-20', 1, 'Odrzucony'),
(74, 32, '2023-03-02', '2023-03-02', 1, 'WysÅ‚any'),
(73, 32, '2023-02-14', '2023-02-19', 4, 'WysÅ‚any'),
(72, 32, '2023-02-08', '2023-02-10', 3, 'WysÅ‚any'),
(71, 32, '2023-02-27', '2023-03-05', 5, 'WysÅ‚any'),
(70, 12, '2023-02-13', '2023-02-21', 7, 'Zaakceptowany'),
(69, 12, '2023-02-13', '2023-02-21', 7, 'Odrzucony'),
(68, 27, '2023-02-13', '2023-02-17', 5, 'Odrzucony'),
(67, 27, '2023-02-13', '2023-02-21', 7, 'Odrzucony'),
(66, 12, '2023-02-13', '2023-02-13', 1, 'Odrzucony'),
(65, 12, '2023-02-13', '2023-02-16', 4, 'Odrzucony');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `php_users`
--
ALTER TABLE `php_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeksy dla tabeli `php_vacations`
--
ALTER TABLE `php_vacations`
  ADD PRIMARY KEY (`vacation_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `php_users`
--
ALTER TABLE `php_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT dla tabeli `php_vacations`
--
ALTER TABLE `php_vacations`
  MODIFY `vacation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
