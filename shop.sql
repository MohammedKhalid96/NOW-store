-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2018 at 12:44 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` int(11) NOT NULL DEFAULT '0',
  `Allow_Ads` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Watches', '', 1, 0, 0, 0),
(5, 'Bags', '', 2, 0, 0, 0),
(6, 'Sunglusses', '', 3, 0, 0, 0),
(7, 'Perfumes', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Comment_Date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `Status`, `Comment_Date`, `item_id`, `user_id`) VALUES
(3, 'This item is amazing', 1, '2017-09-13', 10, 8),
(4, 'Test Again', 1, '2017-09-20', 14, 15),
(5, 'Testing', 1, '2017-09-20', 14, 15),
(6, 'This is Me ', 1, '2017-09-20', 14, 15),
(7, 'انا اشتريت الساعة دي اول امبارح بجد تحفة ووصلتني في اقل من يومين بجد شكرا جدا وانصح الكل انه يشتريها جودة وخدمة وشكل ممتاز الصراحة ', 1, '2017-09-20', 14, 15),
(8, 'Good', 1, '2017-09-22', 10, 15),
(9, 'wooow', 1, '2018-06-13', 16, 21),
(11, 'شكرا جدا الجودة ممتازة والتوصيل سريع', 1, '2018-07-26', 20, 23),
(12, 'ميرسي جدا البرفيوم جميل اوي', 1, '2018-07-26', 25, 23);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `created_at`) VALUES
('cus_D4wNA7mabVnacB', 'mohamed', 'khalid', 'mohamednaser.mn91@gmail.com', '2018-06-19 18:16:01');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Image`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(9, 'TAG', 'Classic watch', '110 EGP', '2017-09-11', '', 0, 1, 1, 8),
(10, 'Mini Coper', 'Good watch', '200 EGP', '2017-09-11', '', 0, 1, 1, 8),
(11, 'MVMT', 'Cool', '500 EGP', '2017-09-11', '', 0, 1, 1, 8),
(14, 'Ice Watch', 'This watch Is Amazing', '100 EGP', '2017-09-16', '', 0, 1, 1, 15),
(15, 'LV Bag', 'A relly Good Bag I Loved So Much Every One Could Buy IT Very Easy', '111 EGP', '2017-09-21', '', 0, 1, 5, 15),
(16, 'Lather bag', 'This Bag Is Hand Maded In Egypt', '458 EGP', '2017-09-21', '', 0, 1, 5, 15),
(19, 'Casio', 'This watch Is Ralley Amazing', '100 EGP', '2017-09-23', '', 0, 1, 1, 15),
(20, 'New item', 'Orignal', '200 EGP', '2018-06-18', '', 0, 1, 6, 21),
(21, 'XL', 'Men perfume', '232 EGP', '2018-06-18', '', 0, 1, 7, 21),
(23, 'Ray-Ban', 'One size fits for all faces', '2000 EGP', '2018-07-26', '', 0, 1, 6, 12),
(24, 'SOJOS Round', 'One size fits for all faces', '3000 EGP', '2018-07-26', '', 0, 1, 6, 8),
(25, 'FOGO', 'For men', '500 EGP', '2018-07-26', '', 0, 1, 7, 12),
(26, 'cscscscsc', 'wdccsdcsdcsdcsdcscs', '3432434', '2018-07-26', '', 0, 0, 7, 23);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `customer_id`, `product`, `amount`, `currency`, `status`, `created_at`) VALUES
('ch_1CemUxLthCkHRQbmNHZmWvTA', 0, 0, '5000', 'usd', 'succeeded', '2018-06-19 18:16:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Phone_Number` varchar(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `TrustStatus` int(11) NOT NULL DEFAULT '0',
  `RegStatus` int(11) NOT NULL DEFAULT '0',
  `Date` date NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Email`, `FullName`, `Phone_Number`, `Address`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'MohammedKhalid9896', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mohamednaser.mn91@gmail.com', 'Mohammed Khaled', '', '', 1, 1, 1, '0000-00-00', ''),
(8, 'kareem', 'c4b5c86bd577da3d93fea7c89cba61c78b48e589', 'karem@gmail.com', 'Karem Abd ELnabi', '01064086435', '25 first gate giza ', 0, 0, 1, '2017-08-17', ''),
(11, 'Testing', '11904a4e8b77f6242e2d288705023adad00a9310', 'test@info.com', 'testingg', '01064086435', '', 0, 0, 0, '2017-09-12', ''),
(12, 'Mohammed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mohamed@gmail.com', '', '', '', 0, 0, 0, '2017-09-14', ''),
(15, 'khalid', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'khalid@gmail.com', '', '01234567891', '', 0, 0, 1, '2017-09-16', ''),
(18, 'eslamm', 'c4b5c86bd577da3d93fea7c89cba61c78b48e589', 'elfvrlkf@gamil.com', 'fadyyy', '01064086435', '25 first gate', 0, 0, 1, '2017-09-25', '_images.jpg'),
(19, 'Mohammed Khalid', '5189af014f412d3b199d657520423ed8a6ed5a6d', 'eslam@info.com', 'Eslam mohammed', '01064086435', '25 first gate', 0, 0, 1, '2017-09-27', '_malecostume-512.png'),
(20, 'eferfre', 'fffb8e85796e61b713c68833d9f84ef0958681aa', 'rfr@gmail.com', '', '231434', '', 0, 0, 0, '2018-05-30', ''),
(21, 'testagain', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'mohamed.etch.me@gmail.com', '', '0935804275', '', 0, 0, 0, '2018-06-13', ''),
(22, 'Noww', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'now@gmail.com', '', '01064086435', '', 0, 0, 0, '2018-07-25', ''),
(23, 'Mohammedkhalid', '3acd0be86de7dcccdbf91b20f94a68cea535922d', 'Mohammedkhalid96@outlook.com', '', '01064086435', '', 0, 0, 0, '2018-07-26', ''),
(24, 'moahmmmmed', '3acd0be86de7dcccdbf91b20f94a68cea535922d', 'mo@gamil.com', '', '343243243', '', 0, 0, 0, '2018-07-26', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD UNIQUE KEY `Item_ID` (`Item_ID`),
  ADD KEY `cat_1` (`Cat_ID`),
  ADD KEY `member_1` (`Member_ID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer` (`customer_id`),
  ADD KEY `item` (`product`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
