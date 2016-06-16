-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Creato il: Giu 16, 2016 alle 11:08
-- Versione del server: 10.1.13-MariaDB
-- Versione PHP: 5.5.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s231579`
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
(1, 'Mario', 'Rossi', 'mariorossi@gmail.com', '6f3240543cede5da63dc8d44bba868ac'),
(2, 'Francesco', 'Bianchi', 'francescobianchi@gmail.com', 'b1ef8110a5aea71eba2e1f379078906d'),
(3, 'Antonio', 'Romano', 'antonioromano@gmail.com', '8c31c795d323c71959fdc66cdca536f0');

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
  `TimeStamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `reservations`
--

INSERT INTO `reservations` (`ID`, `IDU`, `IDM`, `StartTime`, `EndTime`, `TimeStamp`) VALUES
(1, 1, 1, 420, 435, 1466067925),
(2, 1, 1, 450, 495, 1466067936),
(3, 1, 1, 1100, 1140, 1466067951),
(4, 2, 1, 540, 585, 1466067981),
(5, 2, 1, 600, 660, 1466067994),
(6, 2, 2, 1125, 1140, 1466068012),
(7, 3, 1, 740, 780, 1466068044),
(8, 3, 1, 810, 840, 1466068055);

-- --------------------------------------------------------


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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
