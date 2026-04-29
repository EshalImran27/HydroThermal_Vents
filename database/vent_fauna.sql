-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2026 at 01:09 AM
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
-- Database: `vent_fauna`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `first_name`, `last_name`, `phone`, `email`, `message`) VALUES
(1, 'eshal', 'imran', '12344567', 'example@gmail.com', 'this is sample text.'),
(2, 'eshal', 'imran', '12344567', 'example@gmail.com', 'this is sample text 2. '),
(3, 'Sara', 'Ali', '12344567', 'SARA@gmail.com', 'I want some info on one of the vents'),
(4, 'imran', 'qadri', '3213123', 'aa@hmail.com', 'f43rf32efd34f34r'),
(5, 'wefwef', 'edwedwe', '231231231', 'dwe@fwef.com', 'efewfwefwdwdf'),
(6, 'eqweqw', 'wefef', '31231231', 'wdwd@ewrwe.co', 'fwefwgfwefwrger'),
(7, 'vfdvdf', 'fgrd', '321412312', 'ferf@rtger.v', 'werwefewgfre'),
(8, 'frefer', 'fef', '41314234', 'ger@efe.fdg', 'wefwefrwefqefw'),
(9, 'testing', 'tt', '2323123123', 'hi@gmail.com', 'this is a test.'),
(10, 'testing', 'tt', '2323123123', 'hi@gmail.com', 'this is a test.'),
(11, 'testing', 'tt', '2323123123', 'hi@gmail.com', 'this is a test msg'),
(12, 'testing', 'tt', '2323123123', 'hi@gmail.com', 'this is a test msg'),
(13, 'testing', 'tt', '2323123123', 'hi@gmail.com', 'this is a test msg'),
(14, 'testing', 'tt', '2323123123', 'hi@gmail.com', 'this is test'),
(15, 'testing', 'tt', '2323123123', 'hi@gmail.com', 'this is test');

-- --------------------------------------------------------

--
-- Table structure for table `fauna`
--

CREATE TABLE `fauna` (
  `id` int(11) NOT NULL,
  `vent_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `scientific_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fauna`
--

INSERT INTO `fauna` (`id`, `vent_id`, `name`, `scientific_name`, `description`, `image_url`) VALUES
(1, 1, 'Manus Hairy Snail', 'Alviniconcha hessleri', 'Large gastropod with distinctive hairy periostracum housing chemosynthetic bacteria. Grows up to 6cm and forms dense aggregations near vent openings.', 'images/Manus Hairy Snail.jpg'),
(2, 1, 'Manus Vent Mussel', 'Bathymodiolus manusensis', 'Deep-sea mussel hosting symbiotic bacteria in its gills. Forms extensive beds around hydrothermal vents.', 'images/Manus Vent Mussel.jpg'),
(3, 1, 'Manus Vent Crab', 'Austinograea alayseae', 'White blind crab adapted to vent environments. Feeds on bacterial mats and small invertebrates.', 'images/Manus Vent Crab.jpg'),
(4, 1, 'Manus Limpet', 'Olgaconcha tufari', 'Small gastropod living on hard substrates near vents. Grazes on bacterial films.', 'images/Manus Limpet.jpg'),
(5, 2, 'Lau Basin Snail', 'Alviniconcha kojimai', 'Hairy snail species endemic to the Lau Basin. Hosts sulphur-oxidising bacterial symbionts.', 'images/Lau Basin Snail.jpg'),
(6, 2, 'Scaly-foot Snail', 'Chrysomallon squamiferum', 'Remarkable gastropod with iron-mineralised scales on its foot. The only known animal to incorporate iron into its exoskeleton.', 'images/Scaley-foot Snail.jpg'),
(7, 2, 'Lau Vent Shrimp', 'Rimicaris variabilis', 'Swarming shrimp with bacterial symbionts in enlarged gill chambers. Found in high-temperature vent fluids.', 'images/Lau Vent Shrimp.jpg'),
(8, 2, 'Lau Tubeworm', 'Lamellibrachia juni', 'Large vestimentiferan tubeworm reaching over 1 metre in length. Hosts chemosynthetic bacteria.', 'images/Lau Tubeworm.png'),
(9, 3, 'North Fiji Mussel', 'Bathymodiolus brevior', 'Smaller vent mussel species with thioautotrophic symbionts. Common in diffuse flow areas.', 'images/North Fiji Mussel.jpg'),
(10, 3, 'Fiji Squat Lobster', 'Munidopsis starmer', 'White squat lobster found around vent peripheries. Opportunistic feeder on vent detritus.', 'images/Fiji Squat Lobster.jpeg'),
(11, 3, 'Fiji Polynoid Worm', 'Branchinotogluma segonzaci', 'Scale worm living among mussel beds. Predator on smaller invertebrates.', 'images/Fiji Polynoid Worm.png'),
(12, 4, 'Mariana Vent Snail', 'Provanna variabilis', 'Small provannid gastropod found in diffuse flow habitats. Grazes on bacterial mats.', 'images/Mariana Vent Snail.jpg'),
(13, 4, 'Mariana Hesionid Worm', 'Hesiocaeca hessleri', 'Small polychaete worm living in vent sediments. Deposit feeder.', 'images/Mariana Hesionid Worm.jpg'),
(14, 4, 'Mariana Vent Shrimp', 'Alvinocaris chelys', 'Deep-water caridean shrimp with elongated claws. Found in high-temperature zones.', 'images/Mariana Vent Shrimp.png'),
(15, 4, 'Mariana Sea Anemone', 'Marianactis bythios', 'Large actiniarian anemone endemic to Mariana vents. Preys on small crustaceans.', 'images/Mariana Sea Anemone.jpg'),
(16, 5, 'Eifuku Snail', 'Provanna fenestrata', 'Provannid gastropod discovered at Northwest Eifuku volcano. Lives near carbon dioxide vents.', 'images/Eifuku Snail.png'),
(17, 5, 'Arc Vent Barnacle', 'Neolepas zevinae', 'Stalked barnacle adapted to volcanic vent environments. Filter feeder.', 'images/Arc Vent Barnacle.jpg'),
(18, 6, 'Okinawa Hairy Snail', 'Alviniconcha adamantis', 'Hairy gastropod species found in the Okinawa Trough. Harbours chemosynthetic symbionts.', 'images/Okinawa Hairy Snail.jpg'),
(19, 6, 'Okinawa Crab', 'Shinkaia crosnieri', 'Distinctive galatheid crab with bacterial filaments on its setae. Also known as the yeti crab.', 'images/Okinawa Crab.jpg'),
(20, 6, 'Okinawa Vent Limpet', 'Lepetodrilus nux', 'Small limpet found grazing on bacterial mats near vents.', 'images/Okinawa Vent Limpet.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `vents`
--

CREATE TABLE `vents` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(200) NOT NULL,
  `type` varchar(50) NOT NULL,
  `depth_metres` int(11) NOT NULL,
  `discovery_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vents`
--

INSERT INTO `vents` (`id`, `name`, `location`, `type`, `depth_metres`, `discovery_year`) VALUES
(1, 'Manus Basin', 'Bismarck Sea, Papua New Guinea (3.5S, 151.5E)', 'Back-arc basin', 1650, 1985),
(2, 'Lau Basin', 'Southwest Pacific, Tonga (20S, 176W)', 'Back-arc basin', 1900, 1989),
(3, 'North Fiji Basin', 'Southwest Pacific, Fiji (17S, 173E)', 'Back-arc basin', 2000, 1988),
(4, 'Mariana Back-arc', 'Western Pacific, Mariana Islands (18N, 144.5E)', 'Back-arc spreading centre', 3600, 1987),
(5, 'Mariana Volcanic Arc', 'Western Pacific, Mariana Islands (21N, 144E)', 'Volcanic arc', 1500, 2003),
(6, 'Okinawa Trough', 'East China Sea, Japan (27N, 127E)', 'Back-arc basin', 1400, 1988),
(9, 'test 3', 'mariana trench', 'black smoke', 1390, 2017);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fauna`
--
ALTER TABLE `fauna`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vent_id` (`vent_id`);

--
-- Indexes for table `vents`
--
ALTER TABLE `vents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `fauna`
--
ALTER TABLE `fauna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vents`
--
ALTER TABLE `vents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fauna`
--
ALTER TABLE `fauna`
  ADD CONSTRAINT `fauna_ibfk_1` FOREIGN KEY (`vent_id`) REFERENCES `vents` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
