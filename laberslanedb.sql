-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2024 at 05:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laberslanedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Dept_ID` varchar(15) NOT NULL,
  `Dept_Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Dept_ID`, `Dept_Name`) VALUES
('1001', 'CAS Chemistry'),
('1002', 'CAS Physics'),
('1003', 'CAS Biology'),
('2004', 'SOTECH Food Technology'),
('2005', 'SOTECH Chemical Engineering'),
('3006', 'CFOS');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `Equip_ID` varchar(15) NOT NULL,
  `Equip_Name` varchar(255) DEFAULT NULL,
  `Equip_Con` varchar(100) DEFAULT NULL,
  `Equip_SerNum` varchar(40) DEFAULT NULL,
  `dept_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`Equip_ID`, `Equip_Name`, `Equip_Con`, `Equip_SerNum`, `dept_id`) VALUES
('100320784', 'Pipette', 'Good', 'SN1234', '1003'),
('100321801', 'Microscope', 'Good', 'SN4567', '1003'),
('300671604', 'Hot Air Oven', 'Under Repair/Maintenance', 'SN8769', '3006'),
('300673244', 'Microscope', 'Under Repair/Maintenance', 'SN1234', '3006');

-- --------------------------------------------------------

--
-- Table structure for table `laboratory`
--

CREATE TABLE `laboratory` (
  `Lab_ID` varchar(15) NOT NULL,
  `Lab_Name` varchar(255) NOT NULL,
  `Lab_Con` varchar(100) DEFAULT NULL,
  `Lab_Dept` varchar(100) DEFAULT NULL,
  `Staff_ID` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laboratory`
--

INSERT INTO `laboratory` (`Lab_ID`, `Lab_Name`, `Lab_Con`, `Lab_Dept`, `Staff_ID`) VALUES
('300666379', 'CFOS Wet Lab', 'Construction', 'CFOS', '3006-624463'),
('100137504', 'Chem23', 'Unsafe', 'CAS Chem', '1001-159825'),
('100214827', 'PL4', 'Normal', 'CAS Phy', '1002-976592');

-- --------------------------------------------------------

--
-- Table structure for table `resource`
--

CREATE TABLE `resource` (
  `Res_ID` int(11) NOT NULL,
  `Res_Name` varchar(255) DEFAULT NULL,
  `Res_Type` varchar(100) DEFAULT NULL,
  `Res_Avail` int(40) DEFAULT NULL,
  `Dept_ID` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resource`
--

INSERT INTO `resource` (`Res_ID`, `Res_Name`, `Res_Type`, `Res_Avail`, `Dept_ID`) VALUES
(100178547, 'Hydrogen Chloride', 'Solvent', 3, '1001'),
(300614839, 'Saline', 'Saline', 0, '3006');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `Sched_ID` varchar(15) NOT NULL,
  `Start_Time` time DEFAULT NULL,
  `End_Time` time DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `lab_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`Sched_ID`, `Start_Time`, `End_Time`, `start_date`, `end_date`, `lab_name`) VALUES
('1001Che3476', '09:30:00', '10:30:00', '2024-06-01', '2024-06-01', 'Chem23');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_ID` varchar(15) NOT NULL,
  `Staff_Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_ID`, `Staff_Name`) VALUES
('1001-159825', 'christinechem'),
('1002-612239', 'ChristineAdmin'),
('1002-900437', 'Christine Pagunsan'),
('1002-976592', 'christinephy'),
('1003-704264', 'christinebio'),
('2004-581941', 'christinefood'),
('2005-522966', 'christineche'),
('3006-624463', 'christinecfos');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_Name` char(50) NOT NULL,
  `User_ID` varchar(15) NOT NULL,
  `User_Password` varchar(100) NOT NULL,
  `User_Role` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_Name`, `User_ID`, `User_Password`, `User_Role`) VALUES
('christinechem', '1001-159825', '$2y$10$f3V0Yk1Rvk6vrC2c7.2RhuNHpRWSgsTojDdE7dP7vfhH/r7KKdlzO', 'staff'),
('ChristineAdmin', '1002-612239', '$2y$10$bW4BwVQy66aX1FIRYgmD/.8L2YDkrLGEOPJCEUkE3zDPZxMuwG5cu', 'staff'),
('Christine Pagunsan', '1002-900437', '$2y$10$ykD3Zo/D/dH.yU0is4O46.onN07/VAEhxBFkiu7RD41mEcobM4Vo6', 'staff'),
('christinephy', '1002-976592', '$2y$10$9Cc5RI0uD8aZqTR4mXG8Uempo5bUkt..XJ/rL6HCuFpaKNtPr60qW', 'staff'),
('christinebio', '1003-704264', '$2y$10$BD1YWntj00pxNVlHHRh4ReVIieXsGMeZX2TYcf/XVz9IkmieEoKJq', 'staff'),
('christinefood', '2004-581941', '$2y$10$Jn8IrkKWKwhopSk86TZaZ.j4MXivICh4wQPMUbo8UUyd.DzreRrUy', 'staff'),
('christineche', '2005-522966', '$2y$10$oCGbYlyTbkFpQC5xIsfwT.YyTdJQlhS91LGwSIxnS0aLWhWxM8YrO', 'staff'),
('christinecfos', '3006-624463', '$2y$10$S1dEq7psuh08azkq79x7iemVLy7WLzflanFEj9cmzaP2A1Qny45tG', 'staff'),
('miguelstudent', '832242', '$2y$10$/Iu2zQOsopSgSJPOGGZKfOLEJGq.dGbhHPBr0b9rkoa07Yb7tgPb6', 'student');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `after_insert_user` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.user_role = 'Staff' THEN
        INSERT INTO staff (staff_id, staff_name)
        VALUES (NEW.user_id, NEW.user_name);
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Dept_ID`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`Equip_ID`),
  ADD KEY `fk_dept_id` (`dept_id`);

--
-- Indexes for table `laboratory`
--
ALTER TABLE `laboratory`
  ADD PRIMARY KEY (`Lab_Name`),
  ADD UNIQUE KEY `Lab_ID` (`Lab_ID`),
  ADD KEY `FK_Lab_StaffInCharge` (`Staff_ID`);

--
-- Indexes for table `resource`
--
ALTER TABLE `resource`
  ADD PRIMARY KEY (`Res_ID`),
  ADD KEY `fk_department` (`Dept_ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`Sched_ID`),
  ADD KEY `fk_labname` (`lab_name`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `User_ID` (`User_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `fk_dept_id` FOREIGN KEY (`dept_id`) REFERENCES `department` (`Dept_ID`);

--
-- Constraints for table `laboratory`
--
ALTER TABLE `laboratory`
  ADD CONSTRAINT `FK_Lab_StaffInCharge` FOREIGN KEY (`Staff_ID`) REFERENCES `staff` (`Staff_ID`),
  ADD CONSTRAINT `FK_Staff_ID` FOREIGN KEY (`Staff_ID`) REFERENCES `staff` (`Staff_ID`);

--
-- Constraints for table `resource`
--
ALTER TABLE `resource`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`Dept_ID`) REFERENCES `department` (`Dept_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resource_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `department` (`Dept_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_labname` FOREIGN KEY (`lab_name`) REFERENCES `laboratory` (`Lab_Name`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `FK_StaffID` FOREIGN KEY (`Staff_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_StaffUser` FOREIGN KEY (`Staff_ID`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`Staff_ID`) REFERENCES `users` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
