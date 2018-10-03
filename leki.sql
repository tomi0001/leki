-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Czas generowania: 29 Wrz 2018, 16:16
-- Wersja serwera: 10.1.26-MariaDB-0+deb9u1
-- Wersja PHP: 7.0.30-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `leki_film`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `grupy`
--

CREATE TABLE `grupy` (
  `id` int(20) NOT NULL,
  `nazwa` varchar(150) NOT NULL,
  `color` varchar(40) DEFAULT NULL,
  `id_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`, `id`) VALUES
('2014_10_12_000000_create_users_table', 1, 1),
('2014_10_12_100000_create_password_resets_table', 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opis`
--

CREATE TABLE `opis` (
  `id` int(20) NOT NULL,
  `data` datetime NOT NULL,
  `opis` text NOT NULL,
  `id_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id` int(20) NOT NULL,
  `nazwa` varchar(150) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_substancji` int(20) DEFAULT NULL,
  `color` varchar(40) DEFAULT NULL,
  `ile_procent` float DEFAULT NULL,
  `rodzaj_porcji` tinyint(4) NOT NULL,
  `cena` float DEFAULT NULL,
  `za_Ile` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przekierowanie_grup`
--

CREATE TABLE `przekierowanie_grup` (
  `id` int(20) NOT NULL,
  `id_grupy` int(20) NOT NULL DEFAULT '0',
  `id_substancji` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przekierowanie_opis`
--

CREATE TABLE `przekierowanie_opis` (
  `id` int(20) NOT NULL,
  `id_spozycia` int(20) NOT NULL DEFAULT '0',
  `id_opisu` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przekierowanie_substancji`
--

CREATE TABLE `przekierowanie_substancji` (
  `id` int(20) NOT NULL,
  `id_substancji` int(20) NOT NULL DEFAULT '0',
  `id_produktu` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spozycie`
--

CREATE TABLE `spozycie` (
  `id` int(21) NOT NULL,
  `porcja` float NOT NULL,
  `id_users` int(20) NOT NULL,
  `data` datetime NOT NULL,
  `id_produktu` int(20) NOT NULL,
  `cena` float NOT NULL,
  `czy_dwa` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `substancje`
--

CREATE TABLE `substancje` (
  `id` int(20) NOT NULL,
  `nazwa` varchar(150) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_grupy` int(20) DEFAULT '0',
  `rownowaznik` float(4,4) DEFAULT NULL,
  `color` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(60) NOT NULL,
  `password` varchar(120) NOT NULL,
  `data_rejestracji` datetime NOT NULL,
  `poczatek_dnia` tinyint(11) NOT NULL,
  `sciezka_style` varchar(130) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `grupy`
--
ALTER TABLE `grupy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opis`
--
ALTER TABLE `opis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `przekierowanie_grup`
--
ALTER TABLE `przekierowanie_grup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `przekierowanie_opis`
--
ALTER TABLE `przekierowanie_opis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `przekierowanie_substancji`
--
ALTER TABLE `przekierowanie_substancji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spozycie`
--
ALTER TABLE `spozycie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `substancje`
--
ALTER TABLE `substancje`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `grupy`
--
ALTER TABLE `grupy`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `opis`
--
ALTER TABLE `opis`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `przekierowanie_grup`
--
ALTER TABLE `przekierowanie_grup`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `przekierowanie_opis`
--
ALTER TABLE `przekierowanie_opis`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `przekierowanie_substancji`
--
ALTER TABLE `przekierowanie_substancji`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `spozycie`
--
ALTER TABLE `spozycie`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `substancje`
--
ALTER TABLE `substancje`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
