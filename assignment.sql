-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Creato il: Giu 09, 2016 alle 10:27
-- Versione del server: 10.1.13-MariaDB
-- Versione PHP: 5.5.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment`
--

-- --------------------------------------------------------

DROP TABLE IF EXISTS `reservations`;

DROP TABLE IF EXISTS `machines`;

DROP TABLE IF EXISTS `users`;

--
-- Struttura della tabella `machines`
--

CREATE TABLE `machines` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `machines`
--

INSERT INTO `machines` (`ID`, `Name`) VALUES
(1, 'Printer1'),
(2, 'Printer2'),
(3, 'Printer3'),
(4, 'Printer4');

-- --------------------------------------------------------

--
-- Struttura della tabella `reservations`
--

CREATE TABLE `reservations` (
  `ID` int(11) NOT NULL,
  `IDU` int(11) NOT NULL,
  `IDM` int(11) NOT NULL,
  `StartTime` int(5) NOT NULL,
  `EndTime` int(5) NOT NULL,
  `TimeStamp` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `reservations`
--

INSERT INTO `reservations` (`ID`, `IDU`, `IDM`, `StartTime`, `EndTime`, `TimeStamp`) VALUES
(3, 1, 1, 480, 540, 617),
(4, 1, 1, 1140, 1200, 618),
(5, 1, 2, 480, 540, 619),
(6, 2, 1, 600, 660, 619),
(7, 2, 1, 660, 720, 620),
(8, 2, 2, 1170, 1200, 621),
(9, 3, 1, 720, 780, 621),
(10, 3, 3, 1170, 1230, 621);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(34) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`ID`, `Name`, `Surname`, `Email`, `Password`) VALUES
(1, 'Marilisa', 'Montemurro', 'marilisamontemurro@gmail.com', '2a0c185dd3595236bf78d5b5edcabbf7'),
(2, 'Mario', 'Rossi', 'mariorossi@gmail.com', '6f3240543cede5da63dc8d44bba868ac'),
(3, 'Francesco', 'Bianchi', 'francescobianchi@gmail.com', 'b1ef8110a5aea71eba2e1f379078906d');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDU` (`IDU`),
  ADD KEY `IDM` (`IDM`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `machines`
--
ALTER TABLE `machines`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `reservations`
--
ALTER TABLE `reservations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`IDU`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`IDM`) REFERENCES `machines` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
