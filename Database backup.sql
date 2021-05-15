-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 06, 2021 at 09:57 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_lockout` (IN `ipp` VARCHAR(256), IN `agent` LONGTEXT, IN `action` VARCHAR(50))  MODIFIES SQL DATA
BEGIN
            IF EXISTS (SELECT * FROM project.lockout WHERE ip = ipp AND useragent = agent LIMIT 1) THEN
                IF EXISTS(SELECT * FROM project.lockout WHERE ip = ipp AND useragent = agent AND attempts = 5 LIMIT 1) THEN
                    UPDATE project.lockout
                    SET
                        ip = ipp,
                        useragent = agent,
                        until = TIMESTAMPADD(MINUTE , 3 ,CURRENT_TIMESTAMP),
                        attempts = 0
                    WHERE ip = ipp AND useragent = agent;
                    SELECT message INTO @message_result FROM `log_strings` WHERE name = 'LOGIN_LOCKOUT' LIMIT 1;
                    CALL write_log(action,ipp,@message_result);
                ELSE
                    UPDATE project.lockout
                    SET
                        attempts = attempts + 1
                    WHERE ip = ipp AND useragent = agent;
                    SELECT message INTO @message_result FROM `log_strings` WHERE name = 'LOGIN_INCREMENT_ATTEMPTS' LIMIT 1;
                    CALL write_log(action,ipp,@message_result);
                END IF;
            ELSE
                INSERT INTO project.lockout
                    (`ip`, `useragent`)
                VALUES 
                    (
                        ipp,
                        agent
                    );
                    SELECT message INTO @message_result FROM `log_strings` WHERE name = 'LOGIN_CREATE_INCREMENT' LIMIT 1;
                CALL write_log(action,ipp,@message_result);
            END IF;
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `write_log` (IN `actionn` VARCHAR(50), IN `ipp` VARCHAR(256), IN `outcomee` LONGTEXT)  NO SQL
BEGIN
            CREATE TEMPORARY TABLE temp SELECT GROUP_CONCAT(CONCAT(id,action,ip,timestamp,outcome,COALESCE(hash_to_current,'null'))) as hash FROM logs;
        
            INSERT INTO logs (action,ip,timestamp,outcome,hash_to_current)
            VALUES (
                actionn,
                ipp,
                CURRENT_TIMESTAMP,
                outcomee,
                SHA2((select * from temp limit 1),512)
            );
        END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lockout`
--

CREATE TABLE `lockout` (
  `id` int(11) NOT NULL,
  `ip` varchar(256) NOT NULL,
  `useragent` longtext NOT NULL,
  `until` datetime NOT NULL DEFAULT current_timestamp(),
  `attempts` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `ip` varchar(256) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `outcome` longtext NOT NULL,
  `hash_to_current` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log_strings`
--

CREATE TABLE `log_strings` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `message` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_strings`
--

INSERT INTO `log_strings` (`id`, `name`, `message`) VALUES
(1, 'LOGIN_INCREMENT_ATTEMPTS', 'Incremented lockout attempts.'),
(2, 'LOGIN_LOCKOUT', 'Locked out user.'),
(3, 'LOGIN_CREATE_INCREMENT', 'First time useragent and IP. Incremented attempt.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(200) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `admin`) VALUES
(24, 'Admin', '09fd8bda275bdc04b9a238330e092ae14a1829d355985e95bf3a77b27fb8ad0342c7577e60953fed34aed4c714f9e3e52e7d4c24b6c1b33d12817a075257d6e4', '3fca319d2b588d00cc3822865c35d67915f9f8623249a6ebda83867e33d2e2fd171de43428d930c7d9751c250bdd79ecd322e160f7a73d519f034c69ca69e345', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lockout`
--
ALTER TABLE `lockout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_strings`
--
ALTER TABLE `log_strings`
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
-- AUTO_INCREMENT for table `lockout`
--
ALTER TABLE `lockout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;

--
-- AUTO_INCREMENT for table `log_strings`
--
ALTER TABLE `log_strings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
