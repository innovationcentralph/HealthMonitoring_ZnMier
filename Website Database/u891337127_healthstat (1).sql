-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 09, 2023 at 01:51 PM
-- Server version: 10.6.10-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u891337127_healthstat`
--

-- --------------------------------------------------------

--
-- Table structure for table `nurselist`
--

CREATE TABLE `nurselist` (
  `Nurse` varchar(6) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Age` varchar(11) NOT NULL,
  `DeviceID` varchar(255) NOT NULL,
  `Photo` varchar(255) NOT NULL,
  `PhotoPath` varchar(255) NOT NULL,
  `activePatient` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nurselist`
--

INSERT INTO `nurselist` (`Nurse`, `Name`, `Age`, `DeviceID`, `Photo`, `PhotoPath`, `activePatient`) VALUES
('FED548', 'Nurse 2', '37', 'ABC123', 'image 3.png', 'image 31671377855.png', 'KVA557'),
('FVR025', 'Nurse 5', '32', 'ABC125', 'logo_bg.png', 'logo_bg1676303744.png', ''),
('QVF754', 'Sample Nurse 3', '29', 'ABC124', 'CPLOGO.png', 'CPLOGO1676467664.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `patientlist`
--

CREATE TABLE `patientlist` (
  `Index` int(11) NOT NULL,
  `Patient` varchar(255) NOT NULL,
  `PatientName` varchar(255) NOT NULL,
  `PatientAge` varchar(3) NOT NULL,
  `PatientAddress` varchar(255) NOT NULL,
  `PatientGuardian` varchar(255) NOT NULL,
  `PatientDependent` varchar(255) NOT NULL,
  `Photo` varchar(255) NOT NULL,
  `PatientPhotoPath` varchar(255) NOT NULL,
  `DoctorName` varchar(255) NOT NULL,
  `DoctorNumber` varchar(255) NOT NULL,
  `DoctorEmail` varchar(255) NOT NULL,
  `PatientNurse` varchar(255) NOT NULL,
  `PatientAdmitDate` varchar(255) NOT NULL,
  `isActiveScan` int(11) NOT NULL DEFAULT 0,
  `HeartRateAlert` int(11) NOT NULL DEFAULT 0,
  `OxygenSaturationAlert` int(11) NOT NULL DEFAULT 0,
  `DiastolicAlert` int(11) NOT NULL DEFAULT 0,
  `SystolicAlert` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patientlist`
--

INSERT INTO `patientlist` (`Index`, `Patient`, `PatientName`, `PatientAge`, `PatientAddress`, `PatientGuardian`, `PatientDependent`, `Photo`, `PatientPhotoPath`, `DoctorName`, `DoctorNumber`, `DoctorEmail`, `PatientNurse`, `PatientAdmitDate`, `isActiveScan`, `HeartRateAlert`, `OxygenSaturationAlert`, `DiastolicAlert`, `SystolicAlert`) VALUES
(3, 'CXR287', 'Juan Dela Cruz', '25', 'Sample', 'Sample', '', 'WIN_20220620_16_00_36_Pro.jpg', 'WIN_20220620_16_00_36_Pro1674480870.jpg', 'Sample', '+639159243835', 'Sample', 'FED548', '2023-01-23 21:34', 0, 0, 0, 0, 0),
(5, 'EOO501', 'Sample Patient 12', '24', 'Sample Address of Patient 12', 'Patient 12 Guardian', '', 'CPLOGO.png', 'CPLOGO1676303353.png', 'Doctor 12', '+639561333141', 'kathlenejoy.17@gmail.com', 'FED548', '2023-02-13 23:49', 0, 0, 0, 0, 0),
(2, 'IZN268', 'Patient 2', '25', 'Patient 2 Address ', 'Patient 2 Guardian', '', '312246248_1125743714710867_7865346374980127680_n_1-removebg-preview 1.png', '312246248_1125743714710867_7865346374980127680_n_1-removebg-preview 11671813311.png', 'Doctor 1', '+639561333141', 'kathlenejoy.17@gmail.com', 'FED548', '2022-12-24 00:35', 0, 0, 0, 0, 0),
(6, 'KAN293', 'Patient Juan Dela Cruz', '29', 'Patient Juan Dela Cruz Address', 'Patient Juan Dela Cruz Guardian', '', 'LION GRANITE CONSTRUCTION SUPPY 1.png', 'LION GRANITE CONSTRUCTION SUPPY 11676303812.png', 'Doctor Strange', '+639561333141', 'kathlenejoy.17@gmail.com', 'FVR025', '2023-02-13 23:56', 0, 0, 0, 0, 0),
(4, 'KTE634', 'hsfh', '34', 'dgag', 'adgaga', '', 'logo_bg.png', 'logo_bg1675992139.png', 'dgasdg', 'sdgasdga', 'sdgasdg', 'FED548', '2023-02-10 09:22', 0, 0, 0, 0, 0),
(1, 'KVA557', 'Patient 123', '27', 'Patient 1 Address 2', 'Patient 1 Guardian 2', '', 'image 5 (1).png', 'image 5 (1)1671812761.png', 'Doctor 2', '+639123456788', 'zenmier30@gmail.com', 'FED548', '2022-12-24 00:26', 1, 0, 0, 0, 0),
(7, 'XPE931', 'Sample Patient 5', '28', 'Sample Patient 5 Address', 'Sample Patient 5 Guardian', '', 'LION GRANITE CONSTRUCTION SUPPY 1.png', 'LION GRANITE CONSTRUCTION SUPPY 11676467866.png', 'Doctor 2', '+639123456789', 'sample@gmail.com', 'FED548', '2023-02-15 21:31', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sensorlog`
--

CREATE TABLE `sensorlog` (
  `Index` int(11) NOT NULL,
  `PatientID` varchar(12) NOT NULL,
  `HeartRate` double NOT NULL,
  `OxygenSaturation` double NOT NULL,
  `Diastolic` double NOT NULL,
  `Systolic` double NOT NULL,
  `dateTime` datetime NOT NULL,
  `timeStamp` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sensorlog`
--

INSERT INTO `sensorlog` (`Index`, `PatientID`, `HeartRate`, `OxygenSaturation`, `Diastolic`, `Systolic`, `dateTime`, `timeStamp`) VALUES
(1, 'KVA557', 65, 80.25, 80, 100, '2022-12-29 17:31:17', 1672306277),
(2, 'KVA557', 65, 80.25, 80, 100, '2022-12-29 18:12:45', 1672308765),
(3, 'KVA557', 102, 98.4, 73, 129, '2022-12-29 18:18:19', 1672309099),
(4, 'KVA557', 113, 98.6, 72, 126, '2022-12-30 00:31:04', 1672331464),
(5, 'KVA557', 82, 98.9, 76, 119, '2022-12-30 04:07:20', 1672344440),
(6, 'KVA557', 85, 98.5, 75, 123, '2022-12-30 04:16:58', 1672345018),
(7, 'KVA557', 86, 98.2, 72, 122, '2022-12-30 04:19:17', 1672345157),
(8, 'KVA557', 84, 98.2, 72, 120, '2022-12-30 04:21:20', 1672345280),
(9, 'KVA557', 81, 97.7, 72, 120, '2022-12-30 05:07:10', 1672348030),
(10, 'KVA557', 85, 97.6, 73, 122, '2022-12-30 05:07:44', 1672348064),
(11, 'KVA557', 80, 97.6, 73, 121, '2022-12-30 05:09:58', 1672348198),
(12, 'KVA557', 77, 97.8, 72, 123, '2022-12-30 05:14:39', 1672348479),
(13, 'KVA557', 78, 97.8, 72, 122, '2022-12-30 05:14:59', 1672348499),
(14, 'KVA557', 79, 97.9, 73, 119, '2022-12-30 05:17:33', 1672348653),
(15, 'KVA557', 81, 97.9, 72, 119, '2022-12-30 05:20:03', 1672348803),
(16, 'KVA557', 80, 97.9, 72, 119, '2022-12-30 05:20:07', 1672348807),
(17, 'KVA557', 83, 97.9, 71, 119, '2022-12-30 05:22:37', 1672348957),
(18, 'KVA557', 83, 97.9, 71, 119, '2022-12-30 05:22:40', 1672348960),
(19, 'KVA557', 84, 97.5, 75, 121, '2022-12-30 05:28:56', 1672349336),
(20, 'KVA557', 84, 97.5, 74, 121, '2022-12-30 05:28:59', 1672349339),
(21, 'KVA557', 96, 97.3, 72, 122, '2022-12-30 05:32:42', 1672349562),
(22, 'KVA557', 82, 97.7, 78, 127, '2022-12-30 05:33:13', 1672349593),
(23, 'KVA557', 88, 97.7, 75, 125, '2022-12-30 05:36:58', 1672349818),
(24, 'KVA557', 93, 97.7, 75, 127, '2022-12-30 05:37:01', 1672349821),
(25, 'KVA557', 96, 97.7, 72, 126, '2022-12-30 05:43:43', 1672350223),
(26, 'KVA557', 98, 97.7, 73, 130, '2022-12-30 05:46:47', 1672350407),
(27, 'KVA557', 94, 97.7, 72, 132, '2022-12-30 05:49:52', 1672350592),
(28, 'KVA557', 92, 98.5, 76, 118, '2022-12-30 06:02:06', 1672351326),
(29, 'KVA557', 87, 98.5, 77, 119, '2022-12-30 06:02:12', 1672351332),
(30, 'KVA557', 88, 98.5, 73, 122, '2022-12-30 06:04:08', 1672351448),
(31, 'KVA557', 91, 97.2, 80, 120, '2022-12-30 06:07:09', 1672351629),
(32, 'KVA557', 95, 97.9, 81, 126, '2022-12-30 06:09:24', 1672351764),
(33, 'KVA557', 117, 98.8, 83, 127, '2022-12-30 14:18:19', 1672381099),
(34, 'KVA557', 104, 96.6, 78, 136, '2022-12-30 14:55:23', 1672383323),
(35, 'KVA557', 98, 98.8, 78, 126, '2022-12-30 19:30:50', 1672399850),
(36, 'KVA557', 97, 98.2, 87, 129, '2022-12-30 19:44:20', 1672400660),
(37, 'KVA557', 95, 98.4, 84, 134, '2022-12-30 21:07:20', 1672405640),
(38, 'KVA557', 65, 80.25, 80, 100, '2023-01-16 01:41:49', 1673804509),
(39, 'KVA557', 96, 98.2, 74, 122, '2023-01-22 18:04:10', 1674381850),
(40, 'KVA557', 99, 98.4, 74, 122, '2023-01-22 18:05:03', 1674381903),
(41, 'KVA557', 94, 98.4, 75, 122, '2023-01-22 18:09:15', 1674382155),
(42, 'KVA557', 104, 97.4, 79, 127, '2023-01-23 06:01:30', 1674424890),
(43, 'KVA557', 103, 99.2, 67, 120, '2023-01-23 06:06:15', 1674425175),
(44, 'KVA557', 97, 97.8, 82, 125, '2023-01-23 21:26:28', 1674480388),
(45, 'KVA557', 95, 98.3, 77, 123, '2023-01-23 21:29:06', 1674480546),
(46, 'CXR287', 95, 97.3, 91, 134, '2023-01-23 21:37:48', 1674481068),
(47, 'IZN268', 82, 98, 81, 123, '2023-01-23 21:46:23', 1674481583),
(48, 'KVA557', 84, 98, 81, 119, '2023-01-23 21:48:21', 1674481701),
(49, 'CXR287', 88, 98, 81, 117, '2023-01-23 21:51:09', 1674481869),
(50, 'CXR287', 91, 98, 80, 119, '2023-01-23 21:53:16', 1674481996),
(51, 'KVA557', 89, 98, 81, 121, '2023-01-23 21:55:05', 1674482105),
(52, 'KVA557', 98, 75, 70, 120, '2023-01-23 22:04:26', 1674482666),
(53, 'EOO501', 98, 75, 70, 120, '2023-02-13 23:51:37', 1676303497),
(54, 'EOO501', 60, 75, 70, 120, '2023-02-13 23:54:02', 1676303642),
(55, 'EOO501', 55, 75, 70, 120, '2023-02-13 23:54:34', 1676303674),
(56, 'KVA557', 55, 75, 55, 120, '2023-02-15 21:39:17', 1676468357),
(57, 'EOO501', 55, 75, 55, 120, '2023-02-15 21:41:48', 1676468508),
(58, 'EOO501', 55, 75, 55, 120, '2023-02-16 05:15:13', 1676495713),
(59, 'KVA557', 55, 75, 55, 120, '2023-02-16 05:16:15', 1676495775),
(60, 'KVA557', 55, 75, 55, 120, '2023-02-16 05:17:37', 1676495857),
(61, 'KVA557', 70, 90, 80, 120, '2023-02-16 05:18:01', 1676495881),
(62, 'KVA557', 75, 92, 78, 120, '2023-02-16 05:18:22', 1676495902);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` varchar(6) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access` varchar(20) NOT NULL,
  `token` longtext NOT NULL,
  `userApproved` int(11) NOT NULL,
  `changepwexpiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `Name`, `username`, `password`, `access`, `token`, `userApproved`, `changepwexpiry`) VALUES
('FED548', 'Nurse 2', 'nurse2', '$2y$10$tef3Vo.3SBTBx2H2Jcr3GeBpHQWfiSi2hslNzsrC.CCRFegikU/9.', 'Nurse', '', 0, '0000-00-00 00:00:00'),
('FVR025', 'Nurse 5', 'nurse5', '$2y$10$/J7iPCxW9Oqikwupb1wUVumzeDsjKF3mtxj6Qvpk4J2QMRBipqaUC', 'Nurse', '', 0, '0000-00-00 00:00:00'),
('QVF754', 'Sample Nurse 3', 'nurse 3', '$2y$10$0BPBAOyNOfmsmz.ot4QhKOxJ1c7u9/UbDe.i7MsWr.O9zBhAQ8V3e', 'Nurse', '', 0, '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nurselist`
--
ALTER TABLE `nurselist`
  ADD PRIMARY KEY (`Nurse`);

--
-- Indexes for table `patientlist`
--
ALTER TABLE `patientlist`
  ADD PRIMARY KEY (`Patient`),
  ADD KEY `Index` (`Index`);

--
-- Indexes for table `sensorlog`
--
ALTER TABLE `sensorlog`
  ADD UNIQUE KEY `Index` (`Index`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patientlist`
--
ALTER TABLE `patientlist`
  MODIFY `Index` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sensorlog`
--
ALTER TABLE `sensorlog`
  MODIFY `Index` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
