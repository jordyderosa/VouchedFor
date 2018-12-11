-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 05, 2018 alle 02:27
-- Versione del server: 5.7.24
-- Versione PHP: 7.3.0RC3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vouchedfor`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_users` int(11) NOT NULL,
  `id_reviews` int(11) NOT NULL,
  `logs` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `logs`
--

INSERT INTO `logs` (`id`, `created_at`, `id_users`, `id_reviews`, `logs`) VALUES
(1, '2018-12-05 01:04:01', 1, 1, 'solicitedRule +3%'),
(2, '2018-12-05 01:04:01', 1, 1, 'fiveStarRule -2%'),
(3, '2018-12-05 01:04:12', 1, 2, 'sameHourRule -20%'),
(4, '2018-12-05 01:04:24', 1, 3, 'ReviewLenghtRule -0,5%'),
(5, '2018-12-05 01:04:44', 1, 4, 'solicitedRule +3%'),
(6, '2018-12-05 01:04:44', 1, 4, 'averageRateRule -8%'),
(7, '2018-12-05 01:07:25', 1, 5, 'solicitedRule +3%'),
(11, '2018-12-05 01:13:12', 1, 7, 'solicitedRule +3%'),
(12, '2018-12-05 01:13:12', 1, 7, 'sameDeviceRule -30%'),
(13, '2018-12-05 01:13:12', 1, 7, 'RankLessThan70Rule Warning'),
(18, '2018-12-05 01:23:10', 1, 10, 'sameMinuteRule -40%'),
(19, '2018-12-05 01:23:10', 1, 10, 'solicitedRule +3%');

-- --------------------------------------------------------

--
-- Struttura della tabella `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `id_users` int(11) NOT NULL,
  `solicited` enum('solicited','unsolicited') NOT NULL,
  `device` varchar(10) NOT NULL,
  `words` int(11) NOT NULL,
  `stars` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `reviews`
--

INSERT INTO `reviews` (`id`, `datetime`, `id_users`, `solicited`, `device`, `words`, `stars`, `created_at`) VALUES
(1, '2018-07-12 12:04:00', 1, 'solicited', 'LB3-TYU', 50, 5, '2018-12-05 02:04:01'),
(2, '2018-07-12 12:05:00', 1, 'unsolicited', 'KB3-IKU', 20, 2, '2018-12-05 02:04:12'),
(3, '2018-07-13 15:04:00', 1, 'unsolicited', 'CY8-IPK', 150, 3, '2018-12-05 02:04:24'),
(4, '2018-07-15 10:04:00', 1, 'solicited', 'BB4-IPK', 40, 5, '2018-12-05 02:04:44'),
(5, '2018-08-29 10:04:00', 1, 'solicited', 'LX2-IPK', 70, 4, '2018-12-05 02:07:25'),
(7, '2018-09-02 10:04:00', 1, 'solicited', 'KB3-IKU', 50, 4, '2018-12-05 02:13:11'),
(10, '2018-09-02 10:04:00', 1, 'solicited', 'AN9-IPK', 90, 2, '2018-12-05 02:23:10');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `professional` tinyint(1) NOT NULL,
  `rank` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `professional`, `rank`) VALUES
(1, 'Jon', 0, 13.5);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_reviews` (`id_reviews`);

--
-- Indici per le tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_users`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `reviewCascade` FOREIGN KEY (`id_reviews`) REFERENCES `reviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userCascade2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `userCascade` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
