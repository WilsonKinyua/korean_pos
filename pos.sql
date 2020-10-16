-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2020 at 02:43 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category` varchar(24) NOT NULL,
  `item_name` varchar(95) DEFAULT NULL,
  `serial_number` varchar(33) DEFAULT NULL,
  `manufacturer` varchar(39) DEFAULT NULL,
  `capacity` varchar(10) DEFAULT NULL,
  `technical_details` varchar(576) DEFAULT NULL,
  `price` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category`, `item_name`, `serial_number`, `manufacturer`, `capacity`, `technical_details`, `price`) VALUES
(1, 'SOLAR PANELS', 'Astronergy CHSM6612M-365 Silver Mono PERC Solar Panel', 'SKU: 1977439', 'Astronergy', '310', 'Size: 76.93 x 38.98 x 1.57 in', '275'),
(2, 'SOLAR PANELS', 'Heliene 320 Black Mono Solar Panel', 'SKU: 9434325', 'Heliene', '310', '60-cell monocrystalline photovoltaic module featuring a double-webbed 1', '256'),
(3, 'SOLAR PANELS', 'Canadian Solar  Module Black Mono PERC MC4 CS3k-320MS -', 'SKU: 1931029', 'Canadian Solar', '320', 'Size: 65.9 x 39.1 x 1.38 in', '205'),
(4, 'SOLAR PANELS', 'Heliene 385 Black Mono Solar Panel 1', 'SKU: 9434371', 'Heliene', '320', 'Size: 78.2 x 39.4 x 1.6 in', '299'),
(5, 'SOLAR PANELS', 'Panasonic  Black Frame HIT Solar Panel', 'SKU: 1941901', 'Panasonic', '325', 'Size: 62.6 x 41.5 x 1.6 in', '355'),
(6, 'SOLAR PANELS', 'Panasonic 330 watt – Black Frame HIT Solar Panel', 'SKU: 1941906', 'Panasonic', '330', 'Size: 62.6 x 41.5 x 1.6 in', '390'),
(7, 'SOLAR PANELS', 'LG NeON2 LG-335N1K-V5', 'SKU: 1524631', 'LG', '335', 'Size: 66.4 x 40 x 1.57 in', '380'),
(8, 'SOLAR PANELS', 'Astronergy CHSM6612M-', 'SKU: 1977439', 'Astronergy', '365', 'Size: 76.93 x 38.98 x 1.57 in', '257'),
(9, 'SOLAR PANELS', 'Heliene 385 Black Mono Solar Panel', 'SKU: 9434371', 'Heliene', '385', 'Size: 78.2 x 39.4 x 1.6 in', '299'),
(10, 'SOLAR PANELS', 'Renogy 400-Watt 12 Volt Monocrystalline Solar Starter Kit', NULL, 'renogy', '400', '400-Watt 12 Volt Monocrystalline Solar Starter Kitwith 40A Rover MPPT Charge Controller', 'ksh 113762'),
(11, 'SOLAR PANELS', 'Mission Solar 310 Black Mono PERC Solar Panel', NULL, 'mission', '350', 'SKU: 1945508\r\nSize: 65.53 x 39.33 x 1.58 in', 'ksh 40976'),
(12, 'SOLAR PANELS', 'Renogy 400W Monocrystalline Solar RV Kit', NULL, 'renogy', '400', '400W Monocrystalline Solar RV Kit with 30A Charger Controller', 'ksh 120091'),
(13, 'Micro-inverter', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Micro-inverter', '2.19 kW Grid Tied Solar System with Enphase IQ7A Microinverters', 'SKU: 1895203', 'Astronergy', '329 kWh', '2.19 kW Grid', '4101.95'),
(15, 'Micro-inverter', '3.65 kW Grid Tied Solar System with Enphase IQ7A Microinverters', 'SKU: 1894309', 'Astronergy', '548 kWh', '3.65 kW Grid Tied Solar System', '6183.95'),
(16, 'Micro-inverter', '4.38 kW Grid Tied Solar System with Enphase', 'SKU: 1894302', 'Astronergy', '657 kWh', '4.38 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 12x Astronergy Solar 365w Panels', '7263.4'),
(17, 'Micro-inverter', '5.48 kW Grid Tied Solar System', 'SKU: 1894305', 'Astronergy', '821 kWh', '5.48 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 15x Astronergy Solar 365w Panels', '8824.9'),
(18, 'Micro-inverter', '5.84 kW Grid Tied Solar System with Enphase', 'SKU: 1894306', 'Astronergy', '876 kWh', '5.84 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 16x Astronergy Solar 365w Panels', '9347.4'),
(19, 'Micro-inverter', '7.3 kW Grid Tied Solar System with Enphase', 'SKU: 1894319', 'Astronergy', '1095 kWh', '7.3 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 20x Astronergy Solar 365w Panels', '11424.5'),
(20, 'Micro-inverter', '8.76 kW Grid Tied Solar System with Enphase', 'SKU: 1894326', 'Astronergy', '1314 kWh', '8.76 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 24x Astronergy Solar 365w Panels', '13556.85'),
(21, 'Micro-inverter', '10.95 kW Grid Tied Solar System with Enphase', 'SKU: 1894329', 'Astronergy', '1643 kWh', '10.95 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 30x Astronergy Solar 365w Panels', '16695.85'),
(22, 'Micro-inverter', '11.68 kW Grid Tied Solar System with Enphase', 'SKU: 1894342', 'Astronergy', '1752 kWh', '11.68 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 32x Astronergy Solar 365w Panels', '17757.3'),
(23, 'Micro-inverter', '13.14 kW Grid Tied Solar System with Enphase', 'SKU: 1894335', 'Astronergy', '1971 kWh', '13.14 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 36x Astronergy Solar 365w Panels', '19920.8'),
(24, 'Micro-inverter', '14.6 kW Grid Tied Solar System with Enphase', 'SKU: 1894339', 'Astronergy', '2190 kWh', '14.6 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 40x Astronergy Solar 365w Panels', '21924.3'),
(25, 'Micro-inverter', '18.25 kW Grid Tied Solar System with Enphase', 'SKU: 1894349', 'Astronergy', '2738 kWh', '18.25 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 50x Astronergy Solar 365w Panels', '26893.25'),
(26, 'Micro-inverter', '21.9 kW Grid Tied Solar System with Enphase', 'SKU: 1894359', 'Astronergy', '3285 kWh', '21.9 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 60x Astronergy Solar 365w Panels', '32077.7'),
(27, 'Micro-inverter', '29.2 kW Grid Tied Solar System with Enphase', 'SKU: 1894379', 'Astronergy', '4380 kWh', '29.2 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 80x Astronergy Solar 365w Panels', '42726.6'),
(28, 'Micro-inverter', '6.4 kW Grid Tied Solar System with Enphase', 'SKU: 1895320', 'canadian solar', '960 kWh', '6.4 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 20x Canadian Solar 320w Panels', '9752.4'),
(29, 'Micro-inverter', '7.68 kW Grid Tied Solar System with Enphase', 'SKU: 1895324', 'canadian solar', '1152 kWh', '7.68 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 24x Canadian Solar 320w Panels', '11540.85'),
(30, 'Micro-inverter', '9.6 kW Grid Tied Solar System with Enphase', 'SKU: 1895330', 'canadian solar', '1440 kWh', '9.6 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 30x Canadian Solar 320w Panels', '14160.85'),
(31, 'Micro-inverter', '10.24 kW Grid Tied Solar System with Enphase', 'SKU: 1895332', 'canadian solar', '1536 kWh', '10.24 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 32x Canadian Solar 320w Panels', '15069.3'),
(32, 'Micro-inverter', '11.52 kW Grid Tied Solar System with Enphase', 'SKU: 1895336', 'canadian solar', '1728 kWh', '11.52 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 36x Canadian Solar 320w Panels', '16,811.00'),
(33, 'Micro-inverter', '12.8 kW Grid Tied Solar System with Enphase', 'SKU: 1895340', 'canadian solar', '1920 kWh', '12.8 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 40x Canadian Solar 320w Panels', '18569.3'),
(34, 'Micro-inverter', '16 kW Grid Tied Solar System with Enphase', 'SKU: 1895350', 'canadian solar', '2400 kWh', '16 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 50x Canadian Solar 320w Panels', '22,703.25'),
(35, 'Micro-inverter', '19.2 kW Grid Tied Solar System with Enphase', 'SKU: 1895360', 'canadian solar', '2880 kWh', '19.2 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 60x Canadian Solar 320w Panels', '27092.7'),
(36, 'Micro-inverter', '25.6 kW Grid Tied Solar System with Enphase', 'SKU: 1895380', 'canadian solar', '3840 kWh', '25.6 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 80x Canadian Solar 320w Panels', '35871.6'),
(37, 'Micro-inverter', '3.84 kW Grid Tied Solar System with Enphase', 'SKU: 1895313', 'HELIENE', '576 kWh', '3.84 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 12x Heliene 320w Panels', '6828.95'),
(38, 'Micro-inverter', '4.62 kW Grid Tied Solar System with Enphase', 'SKU: 1894402', 'Heliene', '693 kWh', '4.62 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 12x Heliene 385w Panels', '7768'),
(39, 'Micro-inverter', '4.8 kW Grid Tied Solar System with Enphase', 'SKU: 1895314', 'Heliene', '720 kWh', '4.8 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 15x Heliene 320w Panels', '8334.9'),
(40, 'Micro-inverter', '5.12 kW Grid Tied Solar System with Enphase', 'SKU: 1895317', 'Heliene', '768 kWh', '5.12 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 16x Heliene 320w Panels', '8,824.40'),
(41, 'Micro-inverter', '5.78 kW Grid Tied Solar System with Enphase', 'SKU: 1894405', 'Heliene', '866 kWh', '5.78 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 15x Heliene 385w Panels', '9455'),
(42, 'Micro-inverter', '6.16 kW Grid Tied Solar System with Enphase', 'SKU: 1894406', 'Heliene', '924 kWh', '6.16 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 16x Heliene 385w Panels', '10020'),
(43, 'Micro-inverter', '6.4 kW Grid Tied Solar System with Enphase', 'SKU: 1895321', 'Heliene', '960 kWh', '6.4 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 20x Heliene 320w Panels', '10772.4'),
(44, 'Micro-inverter', '7.7 kW Grid Tied Solar System with Enphase', 'SKU: 1894419', 'Heliene', '1155 kWh', '7.7 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 20x Heliene 385w Panels', '12268'),
(45, 'Micro-inverter', '7.68 kW Grid Tied Solar System with Enphase', 'SKU: 1895325', 'Heliene', ': 1152 kWh', '7.68 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 24x Heliene 320w Panels', '12769.85'),
(46, 'Micro-inverter', '9.24 kW Grid Tied Solar System with Enphase', 'SKU: 1894426', 'Heliene', '1386 kWh', '9.24 kW Grid Tied Solar System with Enphase IQ7A Microinverters and 24x Heliene 385w Panels', '14565'),
(47, 'Micro-inverter', '9.6 kW Grid Tied Solar System with Enphase', 'SKU: 1895331', 'Heliene', '1440 kWh', '9.6 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 30x Heliene 320w Panels', '15690.85'),
(48, 'Micro-inverter', '10.24 kW Grid Tied Solar System with Enphase', 'SKU: 1895333', 'Heliene', '1536 kWh', '10.24 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 32x Heliene 320w Panels', '16711.3'),
(49, 'Inverters & Electrical', 'Enphase IQ7X Micro Inverter', 'SKU: 2977248', 'Enphase Energy', '320W', 'Compatible with 96-cell modules\r\n    320-460 W+ commonly used module pairings', '175'),
(50, 'Inverters & Electrical', 'Enphase IQ7A Micro Inverter', 'SKU: 2977249', 'Enphase Energy', '349W', 'Can be paired with half-cut cell and bifacial PV modules\r\nPower Point Tracking Range (Operating Range): 18 V58 V', '179'),
(51, 'Batteries and Backup', 'Crown CR430, 6V Flooded L16 Battery', 'SKU: 9960100', 'Crown', '6V', 'Deep Cycle\r\n    Flooded lead-acid\r\n    Snap Caps included\r\n    6Vdc\r\n    430ah @ 20 Hr. rate\r\n    Pre-attached handles for ease of installation', '332'),
(52, 'Batteries and Backup', 'Fullriver DC400-6 AGM Sealed 6V 415Ah Battery', 'SKU: 9949467', 'Fullriver', '6V', '6 volts\r\n    L16 group size\r\n    885 mins @ 25 amps\r\n    229 mins @ 75 amps\r\n    340 AH @ 5HR\r\n    415 AH @ 20HR', '582.49'),
(53, 'Batteries and Backup', 'Crown 6CRV220, 220Ah 6V AGM Battery', 'SKU: 9960101', 'Crown', '6V', 'Made in USA\r\n    Durable, high quality battery design\r\n    6VDC Group GC2 AGM\r\n    220aH @ 20 Hr. Rate    Made in USA\r\n    Durable, high quality battery design\r\n    6VDC Group GC2 AGM\r\n    220aH @ 20 Hr. Rate', '260'),
(54, 'Batteries and Backup', 'Cotek CX-1215 Battery Charger', 'SKU: 2915336', 'Cotex', '12', 'Universal AC input with active PFC\r\n    Compatible with Lead Acid, Li-ion Gel, and AGM batteries\r\n    Support optional remote controller CR-1\r\n    Optional voltage / temperature compensation with battery temp sensor', '141'),
(55, 'Batteries and Backup', 'Ameresco VL-BB-1 Aluminum Battery Box NEMA3R', 'SKU: 9900425', 'Ameresco', NULL, 'Mill finish Aluminum\r\n    Overall Dimensions (HxWxD): 22\" x 16\" x 10\"\r\n    Back Panel Dimensions (HxW): 13.5\" x 19\"', '234'),
(56, 'Batteries and Backup', 'Fullriver DC105-12 AGM Sealed 12V 105Ah Battery', 'SKU: 9949472', 'Fullriver', '12Volts', '12 volts\r\n    27 group size\r\n    175 mins @ 25 amps\r\n    43 mins @ 75 amps\r\n    86 AH @ 5HR\r\n    105 AH @ 20HR', '314.99'),
(57, 'Batteries and Backup', 'Fullriver DC150-12 AGM Sealed 12V 150Ah Battery', 'SKU: 9949465', 'Fullriver', '12Volts', '12 volts\r\n    GC12 group size\r\n    295 mins @ 25 amps\r\n    80 mins @ 75 amps\r\n    130 AH @ 5HR\r\n    150 AH @ 20HR', '447.49'),
(58, 'Batteries and Backup', 'Fullriver FR1-RT Battery Charger', 'SKU: 9949499', 'Fullriver', '12Volts', '12 / 24 / 36 / 48V\r\n    DC Output Connetor: 3/8\" ring terminals\r\n    Battery type: Lead acid (Wet / AGM / GEL), Lithium ion\r\n    IP30 enclosure\r\n    Shelf, wall, bulkhead or on-board installation\r\n    Reverse Polarity Protection with Auto-Reset\r\n    Short Circuit protection\r\n    Requires WiFi Dongle accessory for programming (sold separately)', '385'),
(59, 'Batteries and Backup', 'Crown CR305, 6V Flooded Battery', 'SKU: 9960167', 'Crown', '6Volts', 'Deep Cycle\r\n    Flooded lead-acid\r\n    Snap Caps included\r\n    6Vdc\r\n    305ah @ 20 Hr. rate\r\n    Pre-attached handles for ease of installation', '235'),
(60, 'Batteries and Backup', 'Crown 6CRV390, 390Ah 6V AGM L16 Battery', 'SKU: 9960105', 'Crown', '6Volts', 'Durable, high quality battery design\r\n    6VDC Group 903 L-16 AGM\r\n    390aH @ 20 Hr. Rate\r\n    Pre-attached handles for ease of installation', '557'),
(61, 'Batteries and Backup', 'Schneider Conext Battery Monitor 24/48V Battery Monitor', 'SKU: 2430068', 'Schneider', NULL, 'Includes 500A/50mW shunt', '480'),
(62, 'Energy Management System', 'Enphase IQ Commercial Envoy, 3 Phase', 'SKU: 2930645', 'Enphase Energy', NULL, 'Power requirements: 208Y/120 or 220Y/127 three-phase\r\n    Monitors up to 600 microinverters', '875'),
(63, 'Energy Management System', 'Discover Battery 260AH 48VDC w/ Xanbus 14,800 Wh (2) Lithium Battery Bank', 'SKU: 1898861', 'Discover', '48V', 'Includes (2) Discover 7.4kWh batteries and #4/0 parallel interconnect cables\r\n    260 amp hours at 48Vdc', '13024'),
(64, 'Energy Management System', 'Outback Power Skybox SBX5048-120/240 5,000W 48V Inverter', 'SKU: 2550550', 'Outback power', '48V', 'Easy and fast to install\r\nClean balance-of-systems, all in one box', '3694'),
(65, 'Energy Management System', 'Fortress Power eFlex 5.4 kWh Lithium Ferro Phosphate (LFP) Battery', 'SKU: 9989910', 'Fortress power', '51.2V', '98% Roundtrip efficiency\r\n    High durability & long lasting\r\n    Safe Lithium Iron Phosphate technology (LiFePO4)', '3850'),
(66, 'Energy Management System', 'Outback Power Radian GS7048E Export 7,000W 48V Inverter', 'SKU: 2550099', 'Outback power', '48V', 'Dual AC inputs\r\n    High surge capacity\r\n    Field serviceable modular design', '4500'),
(67, 'Energy Management System', 'Outback Power FPR-8048A-01 FLEXpower Radian Power Center', 'SKU: 5500081', 'Outback power', NULL, 'Factory tested, pre-wired and pre-configured\r\n    Fast installation with a pre-assembled system and fully integrated GS load center\r\n    Optimized system foorprint', '8598'),
(68, 'Energy Management System', 'Outback Power FPR-4048A-01 FLEXpower Radian Power Center', 'SKU: 5500086', 'Outback power', NULL, 'Factory tested, pre-wired and pre-configured\r\n    Fast installation with a pre-assembled system and fully integrated GS load center\r\n    Optimized system foorprint', '6250'),
(69, 'solar cables', 'Polar Wire 2/0 – 72″ UL Cable (Red)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 72\" UL Cable, Battery/inverter (red)', '58'),
(70, 'solar cables', 'Polar Wire 2/0 – 24″ UL Cable (white)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 24\" Cable, Battery/Inverter (white)', '29'),
(71, 'solar cables', 'None 2/0 - 120\" Battery Cable - WHT Cable 1', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 – 120″ Battery Cable – WHT', '92'),
(72, 'solar cables', 'Polar Wire 4/0 – 96″ UL Cable (White)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 96\" UL Cable, Battery Interconnect - (White)', '115'),
(73, 'solar cables', 'Polar Wire 2/0 – 72″ UL Cable (white)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 72\" Cable, Battery/Inverter (white)', '59'),
(74, 'solar cables', 'Polar Wire 2/0 – 12″ UL Cable (White)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 12\" UL Cable, Battery Interconnect (white)', '15'),
(75, 'solar cables', 'Polar Wire 4/0 – 12″ UL Cable (white)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 12\" UL Cable, Battery Interconnect (white)', '22'),
(76, 'solar cables', 'Polar Wire 4/0 – 48″ UL Cable (white)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 48\" UL Cable, Battery/Inverter (white)', '63'),
(77, 'solar cables', 'Polar Wire 2/0 – 48″ UL Cable (red)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 48\" Cable, Battery/Inverter (red)', '45'),
(78, 'solar cables', 'Polar Wire 4/0 – 60″ UL Cable (Red)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 60\" UL Cable, Battery Interconnect (Red)', '79'),
(79, 'solar cables', 'Polar Wire 4/0 – 60″ Battery Cable – WHT', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 60\" UL Cable, Battery Interconnect - (White)', '79'),
(80, 'solar cables', 'Polar Wire 4/0 – 12″ UL Cable (Red/White)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 12\" UL Cable, Battery Interconnect (red/white)', '22'),
(81, 'solar cables', 'Polar Wire 4/0 – 24″ UL Cable (White)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 24\" UL Cable, Battery/Inverter (White)', '40'),
(82, 'solar cables', 'Polar Wire 2/0 – 48″ UL Cable (White)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 48\" UL Cable, Battery/Inverter (White)', '45'),
(83, 'solar cables', 'Polar Wire 2/0 – 18″ UL Cable (White)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 18\" Cable, Battery Interconnect (white)', '25'),
(84, 'solar cables', 'Polar Wire 2/0 – 24″ UL Cable (Red)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 24\" Cable, Battery/Inverter (red)', '29'),
(85, 'solar cables', 'Polar Wire 4/0 – 18″ UL Cable (White)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 18\" UL Cable, Battery Interconnect (White)', '33'),
(86, 'solar cables', 'Polar Wire 2/0 – 60″ UL Cable (Red)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 60\" Cable, Battery/Inverter (red)', '54'),
(87, 'solar cables', 'Polar Wire 4/0 – 72″ UL Cable (white)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 72\" UL Cable, Battery/Inverter (white)', '90'),
(88, 'solar cables', 'Polar Wire 2/0 – 120″ Battery Cable – RED', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 120\" UL Cable, Battery Interconnect - (Red)', '92'),
(89, 'solar cables', 'Polar Wire 4/0 – 48″ UL Cable (red)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 48\" UL Cable, Battery/Inverter (red)', '63'),
(90, 'solar cables', 'Polar Wire 4/0 – 18″ UL Cable (Red)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 18\" UL Cable, Battery/Inverter (red)', '33'),
(91, 'solar cables', 'Polar Wire 4/0 – 120″ UL Cable (White)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 120\" UL Cable, Battery Interconnect (White)', '140'),
(92, 'solar cables', 'Polar Wire 4/0 – 120″ UL Cable (Red)', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 120\" UL Cable, Battery Interconnect (Red)', '140'),
(93, 'solar cables', 'Polar Wire 2/0 – 60″ UL Cable (White)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 60\" Cable, Battery/Inverter (white)', '$54.00'),
(94, 'solar cables', 'Polar Wire 4/0 – 96″ Battery Cable – Red', NULL, 'Polar Wire', NULL, 'Polar Wire 4/0 - 96\" UL Cable, Battery Interconnect - (Red)', '115'),
(95, 'solar cables', 'Link Solar ABS Double Entry Gland for All Cables for RV & Boat', NULL, 'Polar Wire', NULL, 'Link Solar ABS Double Entry Gland for All Cables for RV & Boat', '25'),
(96, 'solar cables', 'Polar Wire 2/0 – 12″ UL Cable (Red/White)', NULL, 'Polar Wire', NULL, 'Polar Wire 2/0 - 12\" UL Cable, Battery Interconnect (red/white)', '15'),
(97, 'solar cables', 'SolarEdge 40a Level 2 Electric Vehicle J1772 Charge Connector w/ 25 ft Cable & Holder', NULL, 'SolarEdge', NULL, 'SolarEdge 40 amp Level 2 EV J1772 Charge Connector w/ 25 ft cable & Holder', '425'),
(98, 'solar cables', 'Dual MC4 10 AWG – 50′ Cable 1 Male – 1 Female', NULL, NULL, NULL, 'Wholesale Solar MC4 10 AWG - DUAL 50\' Cable (1 Male - 1 Female)', '88'),
(99, 'solar cables', 'MC4 10 AWG – 100′ Cable Extension', NULL, NULL, NULL, 'Wholesale Solar MC4 10 AWG-PV Wire - 100\' cable extension', '80'),
(100, 'solar cables', 'MC4 10 AWG – 15′ Cable Extension', NULL, NULL, NULL, 'Wholesale Solar MC4 10 AWG-PV Wire - 15\' cable extension', '28'),
(101, 'solar cables', 'MC4 10 AWG – 50′ Cable Extension', NULL, NULL, NULL, 'Wholesale Solar MC4 10 AWG-PV Wire - 50\' cable extension', '45'),
(102, 'solar cables', '10/2 Tray Cable', NULL, NULL, NULL, '10/2 Tray Cable 10/2 per foot THHN/THWN sunlight resistant', '1.4'),
(103, 'solar cables', 'MC4 10 AWG – 30′ Cable Extension', NULL, NULL, NULL, 'Wholesale Solar MC4 10 AWG-PV Wire - 30\' cable extension', '31'),
(104, 'solar cables', 'Dual MC4 10 AWG – 100′ Cable Extension', NULL, NULL, NULL, 'Wholesale Solar MC4 10 AWG - DUAL 100\' Cable Extensions (1 Male - 1 Female)', '150'),
(105, 'solar cables', 'MC4 10 AWG – 150′ Cable Extension', NULL, NULL, NULL, 'Wholesale Solar MC4 10 AWG-PV Wire - 150\' cable extension', '120'),
(106, 'solar cables', '4/0 – 72″ Battery Cable (Red)', NULL, NULL, NULL, 'Polar Wire 4/0 - 72\" Battery Cable (Red)', '90'),
(107, 'solar cables', 'Titan Wire #10 AWG 2000 VDC Titan PV Wire – per foot Black', NULL, 'Titan Wire', NULL, '#10 AWG 2000 VDC Titan PV Wire - per foot Black', '0.6'),
(108, 'solar cables', 'MC4 10 AWG – 6′ Cable Extension', NULL, NULL, NULL, 'Wholesale Solar MC4 10 AWG-PV Wire - 6\' cable extension', '20'),
(109, 'solar cables', '2/0 – 9″ UL Cable (Red) (White)', NULL, NULL, NULL, 'Wholesale Solar 2/0 - 9\" UL Cable, Battery/Inverter (red/white)', '15'),
(110, 'solar cables', '1.92 kW 6-Panel Heliene Off-Grid Solar System', NULL, NULL, NULL, 'WSS Off-Grid Schneider System for 6 Heliene 60 Cell Modules', '7,447.00'),
(111, 'solar cables', '24″ UL Cable, Battery/Inverter (red)', NULL, NULL, NULL, 'Polar Wire 4/0 - 24\" UL Cable, Battery/Inverter (red)', '40'),
(112, 'solar cables', 'SolarEdge Rapid Shutdown Kit', NULL, 'SolarEdge', NULL, 'SolarEdge Rapid Shutdown Kit - SE1000-RSD-S1 - Single Cable', '38'),
(113, 'solar cables', '2.88 kW 9-Panel Heliene Off-Grid Solar System', NULL, NULL, NULL, 'WSS Off-Grid Schneider System for 9 Heliene 60 Cell Modules', '8,462.00'),
(114, 'solar cables', '25.6 kW Grid Tied Solar System with Enphase IQ7+ Microinverters and 80x Canadian Solar w Panels', NULL, 'Crown', NULL, 'WSS Enphase IQ7+ Inverter Gridtie System for 80 Astronergy 60 Cell Modules', NULL),
(115, 'solar cables', 'Crown AGM 440 Ah 48 VDC 21,120 Wh (16) Battery Bank', NULL, 'Crown', NULL, 'WSS Battery Bank Crown AGM 440 Ah 48 VDC 21,120 Wh (16)', '4,534.00'),
(116, 'solar cables', 'Commercial 100kW 480V Three Phase Gridtie System for 300 Astronergy 72 Cell Module', NULL, NULL, NULL, 'WSS Commercial 100kW 480V Three Phase Gridtie System for 300 72 Cell Astronergy Modules', '83,725.00'),
(117, 'solar cables', 'Midnite Solar MNEDC-125', NULL, NULL, NULL, 'Midnite Breaker DC Panel Mount MNEDC-125RT amp 125VDC, 1\"', '44'),
(118, 'solar cables', 'Crown 430AH 24VDC 10,320 Wh (4) Battery Bank', NULL, 'Crown', NULL, 'WSS Battery Bank Crown 430AH 24VDC 10,320 watt hrs (4)', '1,471.00'),
(119, 'solar cables', 'Crown AGM 220 Ah 48 VDC 10,560 Wh (8) Battery Bank', NULL, NULL, NULL, 'WSS Battery Bank Crown AGM 220 Ah 48VDC 10,560 Wh (8)', '2,185.00'),
(120, 'solar cables', 'MS4448PAE Single Magnum w/ PT-100 Power Center Power Center', NULL, NULL, NULL, 'Wholesale Solar MS4448PAE Single Magnum w/ PT-100 Power Center', '5,255.00'),
(121, 'solar cables', 'Magnum Single MS2812 w/ 2 Classic 150s Power Center', NULL, 'Crown', NULL, 'Wholesale Solar MS2812 Single Magnum w/ 2 Classic 150s Power Center', '5,895.00'),
(122, 'solar cables', 'Outback Power GSLC175-PV1-120/240', NULL, 'Outback Power', NULL, 'Outback GSLC Pre-wired 175A PV1 GFDI 120/240 VAC for Radian 4048A', '1,276.00'),
(123, 'solar cables', 'Ameresco BSP1-12 1w Silver Poly 12 Volt Solar Panel', NULL, NULL, NULL, 'Ameresco Solar BSP Panel Series - BSP-1-12 1w Solar Module', '22.5'),
(124, 'solar cables', 'Magnum Single MS4024 w/ TS-60 MPPT Power Center', NULL, NULL, NULL, 'Wholesale Solar MS4024 Single Magnum w/ TS-MPPT-60 Power Center', '4,610.00'),
(125, 'solar cables', 'Magnum Single MS4348PE w/ Classic 150 Export Power Center', NULL, NULL, NULL, 'Wholesale Solar MS4348PE Single Magnum w/ Classic 150 Export Power Center', '4,956.00'),
(126, 'solar cables', 'Crown 860AH 24VDC 20,640 Wh (8) Battery Bank', NULL, 'Crown', NULL, 'WSS Battery Bank Crown 860AH 24VDC 20,640 watt hrs (8)', '2,903.00'),
(127, 'solar cables', 'Crown 860AH 12 VDC 10,320 Wh (4) Battery Bank', NULL, 'Crown', NULL, 'WSS Battery Bank Crown 860AH 12VDC 10,320 watt hrs (4)', '1,515.00'),
(128, 'solar cables', 'Other Manufacturer Connector AC', NULL, 'Solarland', NULL, 'Harness, 6 #10 Misc', '50'),
(129, 'solar cables', 'Crown AGM 440 Ah 24 VDC 10,560 Wh (8) Battery Bank', NULL, 'Crown', NULL, 'WSS Battery Bank Crown AGM 440 Ah 24 VDC 10,560 Wh (8)', '2,278.00'),
(130, 'solar cables', 'Crown AGM 440 Ah 12 VDC 5,280 Wh (4) Battery Bank', NULL, NULL, NULL, 'WSS Battery Bank Crown AGM 440 Ah 12 VDC 5,280 Wh (4)', '1,150.00'),
(131, 'solar cables', 'MS4024 Single Magnum with PT-100 Power Center', NULL, NULL, NULL, 'Wholesale Solar MS4024 Single Magnum w/ PT-100 Power Center', '4,889.00'),
(132, 'solar cables', 'Magnum Single MS2812 w/ Classic 150 Power Center', NULL, NULL, NULL, 'Wholesale Solar MS2812 Single Magnum w/ Classic 150 Power Center', '4,478.00'),
(133, 'solar cables', 'Outback Power GSLC175-PV-120/240', NULL, 'Outback Power', NULL, 'Outback GSLC Pre-wired 175A PV GFDI 120/240 VAC for Radian', '1,243.00'),
(134, 'solar cables', 'Midnite Solar MNEDC-250', NULL, 'Midnite Solar', NULL, 'Midnite Breaker DC Panel Mount MNEDC-250 amp 125VDC, 1.5\"', '95'),
(135, 'solar cables', 'Magnum Single MS2012 w/ Classic 150 Power Center', NULL, NULL, NULL, 'Wholesale Solar MS2012 Single Magnum w/ Classic 150 Power Center', '4,355.00'),
(136, 'solar cables', 'Crown 860AH 48VDC 41,280 Wh (16) Battery Bank', NULL, 'Crown', NULL, 'WSS Battery Bank Crown 860AH 48VDC 41,280 watt hrs (16)', '5,679.00'),
(137, 'solar cables', '4 in 4 Out Solar DC Distribution Box,', NULL, NULL, NULL, '4 in 4 Out Solar DC Distribution Box, Voltage: 1000 V Power: 15-20 kW\r\nFrequency: 50 Hz', 'Rs 12,224/ Piece'),
(138, 'SOLAR PANELS', '32 A 50 Hz Solar Inverter ACDB & DCDB,', NULL, 'GOODWE', NULL, 'Voltage: 220-240 V Current: 32 A\r\nFrequency: 50 Hz Type: AC, DC\r\nPower: 1-6 KW', 'Rs 40,000/ Piece'),
(139, 'SOLAR PANELS', '50 Hz Solar DCDB Box', NULL, 'GOODWE', NULL, 'Voltage: 1000V DC   Frequency: 50 Hz Number of Core: 1C    Power: 25-30 kw  Temperature range: 40 Deg C UV Protected: Yes', 'Rs 7,000/ Unit'),
(140, 'SOLAR PANELS', 'Solar DCDB, For Solar Panel,', NULL, 'GOODWE', NULL, 'Brand: AR   Voltage: 1000 VDC\r\nFrequency: 50 Hz                                      Degree Of Protection: IP 65', 'Rs 3,000/ Piece'),
(141, 'SOLAR PANELS', 'ACDB and DCDB for Roof Top Solar', NULL, 'Havells, Schneider, Siemens, EATON, C&S', NULL, 'Voltage: 230V and 440V \r\nFrequency: 50Hz \r\nCurrent: upto 1000A', 'Rs 2,475/ pair'),
(142, 'SOLAR PANELS', 'Square Solar DCDB', NULL, 'Havells, Schneider, Siemens, EATON, C&S', NULL, 'Dimensions: 280*280*130\r\nIP Rating: IP 65\r\nShape: Square\r\nVoltage (Volts): 1000 VDC\r\nFeature: Waterproof, Weatherproof, Flameproof', 'Rs 8,500/ Piece'),
(143, 'SOLAR PANELS', 'ACDB and DCDB for Roof Top Solar', NULL, 'Havells, Schneider, Siemens, EATON', NULL, 'Voltage: 230V and 440V   Frequency: 50Hz\r\nCurrent: upto 1000A', 'Rs 2,475/ pair'),
(144, 'SOLAR PANELS', '9a Each String 50 Hz Solar DCDB', NULL, 'Havells, Schneider, Siemens, EATON', NULL, 'Voltage: 1000V DC\r\nCurrent: 9A each String\r\nFrequency: 50 Hz\r\nDegree Of Protection: IP 65', 'Rs 5,000/ Piece'),
(145, 'SOLAR PANELS', 'Solar DCDB Box, For Inverter Protection', NULL, 'Havells, Schneider, Siemens, EATON', NULL, 'Usage/Application: Inverter Protection\r\nVoltage: 250 V and above\r\nIP Rating: IP67', 'Rs 3,000/ Unit'),
(146, 'SOLAR PANELS', 'Solar DCDB Box', NULL, 'Havells, Schneider, Siemens, EATON', NULL, 'Voltage: DC 500-1500 V\r\nCurrent: 8A-400A DC\r\nFrequency: 50 Hz\r\nUsage/Application: Solar Panel', 'Rs 35,000/ Piece'),
(147, 'SOLAR PANELS', 'Solar ACDB 1-5 KW Single Phase with SPD, Automatic Grade', NULL, 'Advanced Electric Company', NULL, 'Voltage: 230 V AC\r\nPackaging Type: Box\r\nNumber of Core: 1\r\nAutomatic Grade: Automatic', 'Rs 2,400/ Unit'),
(148, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM60M-HC Series (158.75)', 'AstroSemiTM', '335W~350W', 'STC rated output (Pmpp)* 335 Wp 340 Wp 345 Wp 350 Wp\r\nRated voltage (Vmpp) at STC 34.44 V 34.69 V 34.96 V 35.22 V\r\nRated current (lmpp) at STC 9.73 A 9.80 A 9.87 A 9.94 A\r\nOpen circuit voltage (Voc) at STC 41.61 V 41.88 V 42.16 V 42.44 V', NULL),
(149, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM60M(BL)-HC Series (158.75)', 'AstroSemiTM', '320W~335W', 'STC rated output (Pmpp)* 320 Wp 325 Wp 330 Wp 335 Wp\r\nRated voltage (Vmpp) at STC 33.68 V 33.93 V 34.17 V 34.44 V\r\nRated current (lmpp) at STC 9.50 A 9.58 A 9.66 A 9.73 A', NULL),
(150, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM60M-HC Series (166)', 'AstroSemiTM', '405W~420W', 'STC rated output (Pmpp)* 405 Wp 410 Wp 415 Wp 420 Wp\r\nRated voltage (Vmpp) at STC 41.59 V 41.85 V 42.11 V 42.35 V\r\nRated current (lmpp) at STC 9.74 A 9.80 A 9.86 A 9.92 A\r\nOpen circuit voltage (Voc) at STC 49.53 V 49.80 V 50.06 V 50.32 V', NULL),
(151, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM60M-HC Series (166)', 'AstroSemiTM', '370W~380W', 'STC rated output (Pmpp)* 370 Wp 375 Wp 380 Wp\r\nRated voltage (Vmpp) at STC 33.98 V 34.28 V 34.51 V\r\nRated current (lmpp) at STC 10.89 A 10.94 A 11.01 A\r\nOpen circuit voltage (Voc) at STC 40.75 V 41.05 V 41.34 V\r\nShort circuit current (Isc) at STC', NULL),
(152, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM60M(BL)-HC Series (166)', 'AstroSemiTM', '355W~365W', 'STC rated output (Pmpp)* 355 Wp 360 Wp 365 Wp\r\nRated voltage (Vmpp) at STC 33.24 V 33.49 V 33.73 V\r\nRated current (lmpp) at STC 10.68 A 10.75 A 10.82 A\r\nOpen circuit voltage (Voc) at STC 39.80 V 40.14 V 40.41 V\r\nShort circuit current (Isc) at STC 11.15 A 11.21 A 11.29 A\r\nModule efficiency 19.2% 19.5% 19.7%\r\nRated output (Pmpp) at NMOT 264.7 Wp 268.5 Wp 272.2 Wp\r\nRated voltage (Vmpp) at NMOT 30.99 V 31.22 V 31.45 V\r\nRated current (Impp) at NMOT 8.54 A 8.60 A 8.65 A\r\nOpen circuit voltage (Voc) at NMOT 37.42 V 37.74 V 37.99 V\r\nShort circuit current (Isc) at NMOT 8.97 A 9.0', NULL),
(153, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM72M-HC Series (166)', 'AstroSemiTM', '445W~455W', 'STC rated output (Pmpp)* 445 Wp 450 Wp 455 Wp\r\nRated voltage (Vmpp) at STC 41.05 V 41.32 V 41.51 V\r\nRated current (lmpp) at STC 10.84 A 10.89 A 10.96 A\r\nOpen circuit voltage (Voc) at STC 48.80 V 49.05 V 49.35 V\r\nShort circuit current (Isc) at STC 11.30 A 11.37 A 11.44 A\r\nModule efficiency 20.1% 20.4% 20.6%\r\nRated output (Pmpp) at NMOT 330.8 Wp 334.5 Wp 338.2 Wp\r\nRated voltage (Vmpp) at NMOT 38.12 V 38.37 V 38.55 V\r\nRated current (Impp) at NMOT 8.68 A 8.72 A 8.78 A\r\nOpen circuit voltage (Voc) at NMOT 45.70 V 45.94 V 46.22 V', NULL),
(154, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM60M(DG)/F-BH Series (158.75)', 'AstroSemiTM', '335W~350W', 'Power rating (front) 335 Wp 340 Wp 345 Wp 350 Wp\r\nTesting Condition Front Back Front Back Front Back Front Back\r\nSTC rated output (Pmpp/Wp)* 335 236 340 239 345 243 350 247\r\nRated voltage (Vmpp/V) at STC 34.44 34.62 34.67 34.85 34.90 35.08 35.13 35.31\r\nRated current (lmpp/A) at STC 9.73 6.82 9.81 6.87 9.89 6.93 9.97 6.98\r\nOpen circuit voltage (Voc/V) at STC 40.80 39.60 40.99 39.78 41.18 39.96 41.37 40.15\r\nShort circuit current (Isc/A) at STC 10.14 7.11 10.21 7.16 10.28 7.21 10.35 7.26\r\nModule efficiency 19.4% 13.6% 19.6% 13.8% 19.9% 14.0% 20.2% 14.3%', NULL),
(155, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM60M(DGT)/F-BH Series (158.75)', 'AstroSemiTM', '325W~340W', 'Power rating (front) 325 Wp 330 Wp 335 Wp 340 Wp\r\nTesting Condition Front Back Front Back Front Back Front Back\r\nSTC rated output (Pmpp/Wp)* 325 244 330 248 335 251 340 255\r\nRated voltage (Vmpp/V) at STC 34.15 34.61 34.39 34.86 34.62 35.09', NULL),
(156, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM72M(DG)/F-BH Series (158.75)', 'AstroSemiTM', '400W~415W', 'Power rating (front) 400 Wp 405 Wp 410 Wp 415 Wp\r\nTesting Condition Front Back Front Back Front Back Front Back\r\nSTC rated output (Pmpp/Wp)* 400 282 405 285 410 289 415 292\r\nRated voltage (Vmpp/V) at STC 40.67 40.88 40.89 41.10 41.10 41.31 41.31 41.52\r\nRated current (lmpp/A) at STC 9.84 6.89 9.91 6.94 9.98 6.99 10.05 7.04\r\nOpen circuit voltage (Voc/V) at STC 48.24 46.82 48.42 46.99 48.60 47.17 48.78 47.34\r\nShort circuit current (Isc/A) at STC 10.30 7.22 10.38 7.28 10.46 7.33 10.54 7.39\r\nModule efficiency 19.4% 13.7% 19.7% 13.8% 19.9% 14.0% 20.2% 14.2%', NULL),
(157, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM72M(DGT)/F-BH Series (158.75)', 'AstroSemiTM', '390W~405W', 'Power rating (front) 390 Wp 395 Wp 400 Wp 405 Wp\r\nTesting Condition Front Back Front Back Front Back Front Back\r\nSTC rated output (Pmpp/Wp)* 390 293 395 296 400 300 405 304', NULL),
(158, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM60M(DG)/F-BH Series (166)', 'AstroSemiTM', '365W~380W', 'Power rating (front) 365 Wp 370 Wp 375 Wp 380 Wp\r\nTesting Condition Front Back Front Back Front Back Front Back\r\nSTC rated output (Pmpp/Wp)* 365 255 370 259 375 262 380 266\r\nRated voltage (Vmpp/V) at STC 34.11 34.65 34.39 35.00 34.66 35.17 .2% 14.1%', NULL),
(159, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM60M(DGT)/F-BH Series (166)', 'AstroSemiTM', '355W~370W', 'Power rating (front) 355 Wp 360 Wp 365 Wp 370 Wp\r\nTesting Condition Front Back Front Back Front Back Front Back\r\nSTC rated output (Pmpp/Wp)* 355 266 360 270 365 273 370 277\r\nRated voltage (Vmpp/V) at STC 33.24 30.12 33.52 30.37 33.77 30.54 34.04 30.74\r\nRated current (lmpp/A) at STC 10.68 8.83 10.74 8.89 10.81 8.94 10.87', NULL),
(160, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM72M(DG)/F-BH Series (166)', 'AstroSemiTM', '435W~450W', 'Power rating (front) 435 Wp 440 Wp 445 Wp 450 Wp\r\nTesting Condition Front Back Front Back Front Back Front Back\r\nSTC rated output (Pmpp/Wp)* 435 304 440 308 445 311 450 315\r\nRated voltage (Vmpp/V) at STC 40.85 41.64 41.12 41.85 41.36 42.03', NULL),
(161, 'SOLAR PANELS', 'AstroSemiTM', 'CHSM72M(DGT)/F-BH Series (166)', 'AstroSemiTM', '425W~440W', 'Power rating (front) 425 Wp 430 Wp 435 Wp 440 Wp\r\nTesting Condition Front Back Front Back Front Back Front Back\r\nSTC rated output (Pmpp/Wp)* 425 318 430 322 435 326 440 330\r\nRated voltage (Vmpp/V) at STC', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
