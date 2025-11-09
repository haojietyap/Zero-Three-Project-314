SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `CSRPIN_platform`

-- --------------------------------------------------------

-- Table structure for table `admin_profiles`

CREATE TABLE `admin_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(8) NOT NULL,
  `address` text NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `admin_profiles`

INSERT INTO `admin_profiles` (`profile_id`, `user_id`, `phone`, `address`, `status`) VALUES
(1, 1, '90094517', 'Boon Lay', 'active'),
(2, 4, '87651234', 'Hougang ', 'active'),
(3, 3, '82331234', 'Kovan ', 'active'),
(4, 5, '87994234', 'Pioneer', 'active');

-- --------------------------------------------------------

-- Table structure for table `CSR_profiles`


CREATE TABLE `CSR_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `experience` text NOT NULL,
  `preferred_consultation_time` enum('morning','afternoon','evening') NOT NULL,
  `consultation_frequency` enum('weekly','biweekly','monthly') NOT NULL,
  `language_preference` enum('english','mandarin','malay','tamil') NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active',
  `expertise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `CSR_profiles`

INSERT INTO `CSR_profiles` (`profile_id`, `user_id`, `phone`, `address`, `experience`, `preferred_consultation_time`, `consultation_frequency`, `language_preference`, `rating`, `status`, `expertise`) VALUES
(2, 2, '91213343', 'Sengkang Ave 12', '5 years', 'evening', 'weekly', 'tamil', 5.0, 'active', 1),
(3, 8, '87651234', 'Clementi Ave 8', '2 years', 'evening', 'monthly', 'mandarin', 3.5, 'active', 4),
(5, 9, '98761234', 'Jurong West', '3 years', 'morning', 'weekly', 'english', 4.0, 'active', 3),
(6, 10, '87651234', 'Toa Payoh', '3 years', 'evening', 'biweekly', 'english', 4.5, 'active', 2),
(7, 16, '88779901', 'Lakeside', '2.5 years', 'morning', 'weekly', 'english', 3.5, 'active', 5),
(8, 20, '90001001', 'Bishan St 23', '1 year', 'afternoon', 'monthly', 'english', 4.0, 'active', 2),
(9, 21, '89012345', 'Tampines Ctrl 1', '6 months', 'morning', 'biweekly', 'mandarin', 4.5, 'active', 3),
(10, 22, '99887766', 'Queenstown', '7 years', 'evening', 'weekly', 'tamil', 5.0, 'active', 1),
(11, 23, '87654321', 'Punggol Dr', '4 years', 'afternoon', 'monthly', 'english', 3.0, 'active', 5),
(12, 24, '90001111', 'Yishun Ave 11', '1.5 years', 'morning', 'weekly', 'malay', 4.2, 'active', 4),
(13, 25, '81234567', 'Bukit Panjang', '2 years', 'evening', 'biweekly', 'english', 4.1, 'active', 2),
(14, 26, '91112223', 'Redhill Close', '3.5 years', 'morning', 'monthly', 'mandarin', 3.8, 'active', 3),
(15, 27, '82223334', 'Kallang Bahru', '1 year', 'afternoon', 'weekly', 'english', 4.9, 'active', 1),
(16, 28, '93334445', 'Dover Crescent', '5 years', 'evening', 'biweekly', 'tamil', 4.3, 'active', 4),
(17, 29, '84445556', 'Commonwealth Dr', '8 months', 'morning', 'monthly', 'english', 3.5, 'active', 5),
(18, 30, '95556667', 'Geylang Lor 1', '4 years', 'afternoon', 'weekly', 'malay', 4.7, 'active', 3),
(19, 31, '86667778', 'Woodlands Ring Rd', '2.5 years', 'evening', 'biweekly', 'mandarin', 4.0, 'active', 2),
(20, 32, '97778889', 'Ang Mo Kio Ave 3', '6 years', 'morning', 'monthly', 'english', 5.0, 'active', 1),
(21, 33, '88889990', 'Boon Lay Place', '1 year', 'afternoon', 'weekly', 'tamil', 3.9, 'active', 4),
(22, 34, '99990001', 'Serangoon Ave 4', '3 years', 'evening', 'biweekly', 'english', 4.6, 'active', 5),
(23, 35, '80001112', 'Upper Bukit Timah', '1.5 years', 'morning', 'monthly', 'mandarin', 3.2, 'active', 2),
(24, 36, '91112220', 'Potong Pasir', '4.5 years', 'afternoon', 'weekly', 'english', 4.8, 'active', 3),
(25, 37, '82223330', 'Jalan Besar', '2 years', 'evening', 'biweekly', 'malay', 3.7, 'active', 1),
(26, 38, '93334440', 'Mountbatten Rd', '7 years', 'morning', 'monthly', 'tamil', 4.4, 'active', 4),
(27, 39, '84445550', 'Holland Village', '9 months', 'afternoon', 'weekly', 'english', 4.1, 'active', 5),
(28, 40, '95556660', 'Simei St 4', '3 years', 'evening', 'biweekly', 'mandarin', 4.2, 'active', 2),
(29, 41, '86667770', 'Bedok Reservoir', '2.5 years', 'morning', 'monthly', 'english', 3.6, 'active', 3),
(30, 42, '97778880', 'Pasir Ris Dr 1', '5 years', 'afternoon', 'weekly', 'malay', 4.9, 'active', 1),
(31, 43, '88889991', 'Tiong Bahru', '1 year', 'evening', 'biweekly', 'tamil', 3.8, 'active', 4),
(32, 44, '99990002', 'Outram Park', '6 years', 'morning', 'monthly', 'english', 5.0, 'active', 5),
(33, 45, '80001113', 'Telok Blangah', '1.5 years', 'afternoon', 'weekly', 'mandarin', 3.4, 'active', 2),
(34, 46, '91112224', 'Limbang Rd', '3 years', 'evening', 'biweekly', 'english', 4.5, 'active', 3),
(35, 47, '82223335', 'Seletar Link', '4 months', 'morning', 'monthly', 'malay', 3.0, 'active', 1),
(36, 48, '93334446', 'Joo Chiat Rd', '4 years', 'afternoon', 'weekly', 'tamil', 4.3, 'active', 4),
(37, 49, '84445557', 'Elias Road', '2 years', 'evening', 'biweekly', 'english', 4.6, 'active', 5),
(38, 50, '95556668', 'Sembawang St', '1.5 years', 'morning', 'monthly', 'mandarin', 3.9, 'active', 2),
(39, 51, '86667779', 'Yishun Ring Rd', '5 years', 'afternoon', 'weekly', 'english', 4.7, 'active', 3),
(40, 52, '97778881', 'Jurong West Ave 1', '3 years', 'evening', 'biweekly', 'malay', 4.1, 'active', 1),
(41, 53, '88889992', 'Bedok North St 3', '9 months', 'morning', 'monthly', 'tamil', 4.8, 'active', 4),
(42, 54, '99990003', 'Chai Chee Lane', '2.5 years', 'afternoon', 'weekly', 'english', 3.5, 'active', 5),
(43, 55, '80001114', 'Farrer Road', '6 years', 'evening', 'biweekly', 'mandarin', 4.4, 'active', 2),
(44, 56, '91112225', 'Punggol Field', '1 year', 'morning', 'monthly', 'english', 3.3, 'active', 3),
(45, 57, '82223336', 'Admiralty Dr', '4 years', 'afternoon', 'weekly', 'malay', 4.9, 'active', 1),
(46, 58, '93334447', 'Sengkang East Way', '2 years', 'evening', 'biweekly', 'tamil', 4.0, 'active', 4),
(47, 59, '84445558', 'Buangkok Green', '3.5 years', 'morning', 'monthly', 'english', 4.2, 'active', 5),
(48, 60, '95556669', 'Clementi West St 2', '7 months', 'afternoon', 'weekly', 'mandarin', 3.7, 'active', 2),
(49, 61, '86667770', 'Jurong East St 13', '5 years', 'evening', 'biweekly', 'english', 4.5, 'active', 3),
(50, 62, '97778882', 'Toa Payoh Lor 6', '1.5 years', 'morning', 'monthly', 'malay', 3.1, 'active', 1),
(51, 63, '88889993', 'Upper Serangoon Rd', '3 years', 'afternoon', 'weekly', 'tamil', 4.8, 'active', 4),
(52, 64, '99990004', 'Choa Chu Kang Ave 4', '2.5 years', 'evening', 'biweekly', 'english', 4.3, 'active', 5),
(53, 65, '80001115', 'Bukit Batok West', '6 months', 'morning', 'monthly', 'mandarin', 3.6, 'active', 2),
(54, 66, '91112226', 'Yishun Ave 5', '4 years', 'afternoon', 'weekly', 'english', 4.9, 'active', 3),
(55, 67, '82223337', 'Marine Terrace', '1 year', 'evening', 'biweekly', 'malay', 3.9, 'active', 1),
(56, 68, '93334448', 'Jalan Kayu', '3.5 years', 'morning', 'monthly', 'tamil', 4.4, 'active', 4),
(57, 69, '84445559', 'Chai Chee St', '2 years', 'afternoon', 'weekly', 'english', 4.7, 'active', 5),
(58, 70, '95556661', 'Ang Mo Kio St 51', '4 years', 'evening', 'biweekly', 'mandarin', 4.0, 'active', 2),
(59, 71, '86667772', 'Eunos Crescent', '1 year', 'morning', 'monthly', 'english', 3.4, 'active', 3),
(60, 72, '97778883', 'Hougang Ave 5', '2.5 years', 'afternoon', 'weekly', 'malay', 4.6, 'active', 1),
(61, 73, '88889994', 'Tampines Ave 4', '5 years', 'evening', 'biweekly', 'tamil', 4.2, 'active', 4),
(62, 74, '99990005', 'Jalan Bukit Merah', '8 months', 'morning', 'monthly', 'english', 3.8, 'active', 5),
(63, 75, '80001116', 'Punggol Central', '3 years', 'afternoon', 'weekly', 'mandarin', 4.9, 'active', 2),
(64, 76, '91112227', 'Clementi Ave 4', '1.5 years', 'evening', 'biweekly', 'english', 3.6, 'active', 3),
(65, 77, '82223338', 'Yishun St 72', '6 years', 'morning', 'monthly', 'malay', 4.7, 'active', 1),
(66, 78, '93334449', 'Sembawang Rd', '2 years', 'afternoon', 'weekly', 'tamil', 4.0, 'active', 4),
(67, 79, '84445550', 'Jurong East Ave 1', '4.5 years', 'evening', 'biweekly', 'english', 4.5, 'active', 5),
(68, 80, '95556662', 'Serangoon North Ave 1', '1 year', 'morning', 'monthly', 'mandarin', 3.5, 'active', 2),
(69, 81, '86667773', 'Toa Payoh East', '3.5 years', 'afternoon', 'weekly', 'english', 4.1, 'active', 3),
(70, 82, '97778884', 'Bukit Batok St 31', '6 months', 'evening', 'biweekly', 'malay', 3.3, 'active', 1),
(71, 83, '88889995', 'Geylang East Ave 1', '5 years', 'morning', 'monthly', 'tamil', 4.8, 'active', 4),
(72, 84, '99990006', 'Woodlands Dr 72', '2 years', 'afternoon', 'weekly', 'english', 4.3, 'active', 5),
(73, 85, '80001117', 'Kaki Bukit Ave 1', '1.5 years', 'evening', 'biweekly', 'mandarin', 3.9, 'active', 2),
(74, 86, '91112228', 'Dover Rd', '4 years', 'morning', 'monthly', 'english', 4.7, 'active', 3),
(75, 87, '82223339', 'Siglap Rd', '3 years', 'afternoon', 'weekly', 'malay', 4.1, 'active', 1),
(76, 88, '93334440', 'Boon Lay Ave', '7 years', 'evening', 'biweekly', 'tamil', 5.0, 'active', 4),
(77, 89, '84445551', 'Telok Kurau Rd', '9 months', 'morning', 'monthly', 'english', 3.0, 'active', 5),
(78, 90, '95556663', 'Choa Chu Kang North 6', '2.5 years', 'afternoon', 'weekly', 'mandarin', 4.4, 'active', 2),
(79, 91, '86667774', 'Simei Ave', '1 year', 'evening', 'biweekly', 'english', 3.2, 'active', 3),
(80, 92, '97778885', 'Jalan Eunos', '6 years', 'morning', 'monthly', 'malay', 4.9, 'active', 1),
(81, 93, '88889996', 'Tanjong Pagar Rd', '1.5 years', 'afternoon', 'weekly', 'tamil', 4.5, 'active', 4),
(82, 94, '99990007', 'Redhill Rd', '3 years', 'evening', 'biweekly', 'english', 3.7, 'active', 5),
(83, 95, '80001118', 'Ang Mo Kio Ave 1', '4 months', 'morning', 'monthly', 'mandarin', 4.2, 'active', 2),
(84, 96, '91112229', 'Bedok North Ave 4', '4 years', 'afternoon', 'weekly', 'english', 4.8, 'active', 3),
(85, 97, '82223330', 'Upper Thomson Rd', '2 years', 'evening', 'biweekly', 'malay', 4.0, 'active', 1),
(86, 98, '93334441', 'Commonwealth Ave', '3.5 years', 'morning', 'monthly', 'tamil', 4.6, 'active', 4),
(87, 99, '84445552', 'River Valley Rd', '1 year', 'afternoon', 'weekly', 'english', 3.9, 'active', 5),
(88, 100, '95556664', 'Pioneer Rd North', '5 years', 'evening', 'biweekly', 'mandarin', 4.7, 'active', 2),
(89, 101, '86667775', 'Yishun Ave 11', '2.5 years', 'morning', 'monthly', 'english', 4.1, 'active', 3),
(90, 102, '97778886', 'Jurong East St 32', '6 months', 'afternoon', 'weekly', 'malay', 3.5, 'active', 1),
(91, 103, '88889997', 'Sengkang West Way', '3 years', 'evening', 'biweekly', 'tamil', 4.3, 'active', 4),
(92, 104, '99990008', 'Tampines St 11', '1.5 years', 'morning', 'monthly', 'english', 3.8, 'active', 5),
(93, 105, '80001119', 'Bukit Merah Central', '4 years', 'afternoon', 'weekly', 'mandarin', 4.9, 'active', 2),
(94, 106, '91112220', 'Marine Parade Rd', '2 years', 'evening', 'biweekly', 'english', 4.0, 'active', 3),
(95, 107, '82223331', 'Geylang Rd', '7 months', 'morning', 'monthly', 'malay', 3.6, 'active', 1),
(96, 108, '93334442', 'Woodlands Ave 6', '5 years', 'afternoon', 'weekly', 'tamil', 4.4, 'active', 4),
(97, 109, '84445553', 'Potong Pasir Ave 1', '1 year', 'evening', 'biweekly', 'english', 4.7, 'active', 5),
(98, 110, '95556665', 'Jurong West St 41', '3.5 years', 'morning', 'monthly', 'mandarin', 3.5, 'active', 2),
(99, 111, '86667776', 'Bishan St 13', '2.5 years', 'afternoon', 'weekly', 'english', 4.3, 'active', 3),
(100, 112, '97778887', 'Tampines Ave 9', '9 months', 'evening', 'biweekly', 'malay', 3.9, 'active', 1),
(101, 113, '88889998', 'Clementi Ave 5', '4 years', 'morning', 'weekly', 'tamil', 4.5, 'active', 4),
(102, 114, '99990009', 'Jurong West St 71', '2 years', 'afternoon', 'monthly', 'english', 4.1, 'active', 5);
-- --------------------------------------------------------


-- Table structure for table `consultation_services`


CREATE TABLE `consultation_services` (
  `job_id` int(11) NOT NULL,
  `CSR_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('offered','suspended') NOT NULL DEFAULT 'offered',
  `views` int(11) NOT NULL DEFAULT 0,
  `shortlisted` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `consultation_services`


INSERT INTO `consultation_services` (`job_id`, `CSR_id`, `title`, `description`, `price`, `status`, `views`, `shortlisted`, `category_id`) VALUES
(1, 2, 'Transport', 'Bring PIN to see doctor', 50.00, 'offered', 3, 0, 1),
(2, 2, 'Sing and Dance along', 'Sing song and dance with PIN', 50.00, 'offered', 2, 0, 1),
(3, 10, 'Keeping Your Brain Active', 'Count 1 to 100 with PIN', 30.00, 'offered', 3, 0, 2),
(4, 2, 'Moving About', 'Need For Wheelchair ', 30.00, 'offered', 2, 0, 5),
(5, 9, 'Staying healthy', 'Medical Visits at Home', 45.00, 'offered', 2, 0, 3),
(6, 6, 'Keeping Up To Date', 'Basic tutorial on using a smartphone for video calls', 35.00, 'offered', 1, 0, 2),
(7, 5, 'Simplifying Paperwork', 'Help filling out government assistance forms', 40.00, 'offered', 5, 0, 5);
-- --------------------------------------------------------

-- Table structure for table `confirmed_jobs`


CREATE TABLE `confirmed_jobs` (
  `match_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `CSR_id` int(11) NOT NULL,
  `PIN_id` int(11) NOT NULL,
  `matched_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `status` enum('confirmed','completed') NOT NULL DEFAULT 'confirmed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `confirmed_jobs`


INSERT INTO `confirmed_jobs` (`match_id`, `job_id`, `CSR_id`, `PIN_id`, `matched_date`, `completion_date`, `status`) VALUES
(1, 3, 10, 3, '2025-05-12', '2025-05-12', 'completed'),
(2, 2, 2, 11, '2025-05-12', '2025-05-12', 'completed'),
(3, 1, 2, 11, '2025-05-12', '2025-05-13', 'completed'),
(4, 3, 10, 11, '2025-05-12', '2025-05-13', 'completed'),
(5, 4, 2, 12, '2025-05-12', '2025-05-13', 'completed'),
(6, 3, 10, 14, '2025-05-13', '2025-05-14', 'completed'),
(7, 5, 9, 14, '2025-05-14', '2025-05-14', 'completed'),
(10, 1, 2, 3, '2025-05-15', '2025-05-15', 'completed'),
(11, 5, 9, 12, '2025-05-15', '2025-05-15', 'completed'),
(12, 5, 9, 12, '2025-05-15', NULL, 'confirmed');

-- --------------------------------------------------------

-- Table structure for table `favorites`

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `PIN_id` int(11) NOT NULL,
  `CSR_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `favorites`

INSERT INTO `favorites` (`favorite_id`, `PIN_id`, `CSR_id`) VALUES
(22, 3, 2),
(23, 3, 10),
(18, 12, 2),
(19, 12, 8),
(20, 12, 9),
(24, 14, 2),
(21, 14, 9);

-- --------------------------------------------------------

-- Table structure for table `PIN_profiles`

CREATE TABLE `PIN_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(8) NOT NULL,
  `address` varchar(50) NOT NULL,
  `preferred_consultation_time` enum('morning','afternoon','evening') NOT NULL,
  `consultation_frequency` enum('weekly','biweekly','monthly') NOT NULL,
  `language_preference` enum('english','mandarin','malay','tamil') NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `PIN_profiles`


INSERT INTO `PIN_profiles` (`profile_id`, `user_id`, `phone`, `address`, `preferred_consultation_time`, `consultation_frequency`, `language_preference`, `status`) VALUES
(6, 3, '87879090', 'Jurong east', 'afternoon', 'monthly', 'english', 'active'),
(7, 12, '90124321', 'Kallang', 'evening', 'weekly', 'english', 'active'),
(8, 11, '90124321', 'Lorong Chuan', 'evening', 'weekly', 'mandarin', 'active'),
(9, 13, '81023456', 'Tampines Ave 4', 'morning', 'biweekly', 'tamil', 'active'),
(10, 14, '92345678', 'Bedok Reservoir Rd', 'afternoon', 'monthly', 'mandarin', 'active'),
(11, 15, '83456789', 'Ang Mo Kio Ave 6', 'evening', 'weekly', 'english', 'active'),
(12, 17, '94567890', 'Yishun Ring Rd', 'morning', 'biweekly', 'malay', 'active'),
(13, 18, '85678901', 'Bishan St 13', 'afternoon', 'monthly', 'english', 'active'),
(14, 19, '96789012', 'Sengkang East Way', 'evening', 'weekly', 'tamil', 'active'),
(15, 20, '87890123', 'Toa Payoh Lor 2', 'morning', 'monthly', 'mandarin', 'active'),
(16, 22, '98901234', 'Jurong West St 42', 'afternoon', 'biweekly', 'english', 'active'),
(17, 24, '80123456', 'Pasir Ris Dr 1', 'evening', 'weekly', 'malay', 'active'),
(18, 25, '91234567', 'Clementi Ave 2', 'morning', 'monthly', 'english', 'active'),
(19, 26, '82345678', 'Woodlands Dr 14', 'afternoon', 'biweekly', 'tamil', 'active'),
(20, 27, '93456789', 'Geylang Lor 22', 'evening', 'weekly', 'mandarin', 'active'),
(21, 28, '84567890', 'Bukit Batok East', 'morning', 'monthly', 'english', 'active'),
(22, 29, '95678901', 'Punggol Field', 'afternoon', 'biweekly', 'malay', 'active'),
(23, 30, '86789012', 'Queenstown Ave 3', 'evening', 'weekly', 'english', 'active'),
(24, 31, '97890123', 'Hougang Ave 8', 'morning', 'monthly', 'tamil', 'active'),
(25, 32, '88901234', 'Marine Parade Rd', 'afternoon', 'biweekly', 'mandarin', 'active'),
(26, 33, '90012345', 'Dover Crescent', 'evening', 'weekly', 'english', 'active'),
(27, 34, '81123456', 'Choa Chu Kang Ave 4', 'morning', 'monthly', 'malay', 'active'),
(28, 35, '92234567', 'Eunos Ave 7', 'afternoon', 'biweekly', 'english', 'active'),
(29, 36, '83345678', 'Serangoon Ave 3', 'evening', 'weekly', 'tamil', 'active'),
(30, 37, '94456789', 'Tiong Bahru Rd', 'morning', 'monthly', 'mandarin', 'active'),
(31, 38, '85567890', 'Alexandra Rd', 'afternoon', 'biweekly', 'english', 'active'),
(32, 39, '96678901', 'Aljunied Rd', 'evening', 'weekly', 'malay', 'active'),
(33, 40, '87789012', 'Kembangan', 'morning', 'monthly', 'english', 'active'),
(34, 41, '98890123', 'Novena', 'afternoon', 'biweekly', 'tamil', 'active'),
(35, 42, '89901234', 'Outram Park', 'evening', 'weekly', 'mandarin', 'active'),
(36, 43, '90012345', 'Paya Lebar', 'morning', 'monthly', 'english', 'active'),
(37, 44, '81123456', 'Redhill', 'afternoon', 'biweekly', 'malay', 'active'),
(38, 45, '92234567', 'River Valley', 'evening', 'weekly', 'english', 'active'),
(39, 46, '83345678', 'Rochor', 'morning', 'monthly', 'tamil', 'active'),
(40, 47, '94456789', 'Tanah Merah', 'afternoon', 'biweekly', 'mandarin', 'active'),
(41, 48, '85567890', 'Telok Blangah', 'evening', 'weekly', 'english', 'active'),
(42, 49, '96678901', 'Upper Bukit Timah', 'morning', 'monthly', 'malay', 'active'),
(43, 50, '87789012', 'Yio Chu Kang', 'afternoon', 'biweekly', 'english', 'active'),
(44, 51, '98890123', 'Farrer Park', 'evening', 'weekly', 'tamil', 'active'),
(45, 52, '89901234', 'Jalan Besar', 'morning', 'monthly', 'mandarin', 'active'),
(46, 53, '90012345', 'Little India', 'afternoon', 'biweekly', 'english', 'active'),
(47, 54, '81123456', 'Newton', 'evening', 'weekly', 'malay', 'active'),
(48, 55, '92234567', 'Orchard Rd', 'morning', 'monthly', 'english', 'active'),
(49, 56, '83345678', 'Somerset', 'afternoon', 'biweekly', 'tamil', 'active'),
(50, 57, '94456789', 'Bugis', 'evening', 'weekly', 'mandarin', 'active'),
(51, 58, '85567890', 'Bras Basah', 'morning', 'monthly', 'english', 'active'),
(52, 59, '96678901', 'Esplanade', 'afternoon', 'biweekly', 'malay', 'active'),
(53, 60, '87789012', 'Harbourfront', 'evening', 'weekly', 'english', 'active'),
(54, 61, '98890123', 'Labrador Park', 'morning', 'monthly', 'tamil', 'active'),
(55, 62, '89901234', 'Telok Ayer', 'afternoon', 'biweekly', 'mandarin', 'active'),
(56, 63, '87789013', 'Bishan Ave 10', 'morning', 'weekly', 'english', 'active'),
(57, 64, '98890124', 'Simei St 2', 'afternoon', 'monthly', 'tamil', 'active'),
(58, 65, '89901235', 'Jurong East St 21', 'evening', 'biweekly', 'mandarin', 'active'),
(59, 66, '90012346', 'Hougang Ave 10', 'morning', 'weekly', 'english', 'active'),
(60, 67, '81123457', 'Tampines St 81', 'afternoon', 'monthly', 'malay', 'active'),
(61, 68, '92234568', 'Ang Mo Kio Ave 1', 'evening', 'biweekly', 'english', 'active'),
(62, 69, '83345679', 'Woodlands Circle', 'morning', 'weekly', 'tamil', 'active'),
(63, 70, '94456790', 'Bukit Panjang Ring Rd', 'afternoon', 'monthly', 'mandarin', 'active'),
(64, 71, '85567901', 'Yishun Ave 4', 'evening', 'biweekly', 'english', 'active'),
(65, 72, '96679012', 'Sengkang Central', 'morning', 'weekly', 'malay', 'active'),
(66, 73, '87789023', 'Bedok North Ave 3', 'afternoon', 'monthly', 'english', 'active'),
(67, 74, '98890134', 'Toa Payoh North', 'evening', 'biweekly', 'tamil', 'active'),
(68, 75, '89901245', 'Clementi West St 2', 'morning', 'weekly', 'mandarin', 'active'),
(69, 76, '90012356', 'Punggol Dr', 'afternoon', 'monthly', 'english', 'active'),
(70, 77, '81123467', 'Kallang Bahru', 'evening', 'biweekly', 'malay', 'active'),
(71, 78, '92234578', 'Jurong West St 91', 'morning', 'weekly', 'english', 'active'),
(72, 79, '83345689', 'Redhill Close', 'afternoon', 'monthly', 'tamil', 'active'),
(73, 80, '94456700', 'Commonwealth Dr', 'evening', 'biweekly', 'mandarin', 'active'),
(74, 81, '85567801', 'Dover Rd', 'morning', 'weekly', 'english', 'active'),
(75, 82, '96678902', 'Geylang East Ave 1', 'afternoon', 'monthly', 'malay', 'active'),
(76, 83, '87789013', 'Chai Chee Lane', 'evening', 'biweekly', 'english', 'active'),
(77, 84, '98890124', 'Serangoon North Ave 1', 'morning', 'weekly', 'tamil', 'active'),
(78, 85, '89901235', 'Mountbatten Rd', 'afternoon', 'monthly', 'mandarin', 'active'),
(79, 86, '90012346', 'Holland Ave', 'evening', 'biweekly', 'english', 'active'),
(80, 87, '81123457', 'Elias Rd', 'morning', 'weekly', 'malay', 'active'),
(81, 88, '92234568', 'Joo Chiat Rd', 'afternoon', 'monthly', 'english', 'active'),
(82, 89, '83345679', 'Upper Serangoon Rd', 'evening', 'biweekly', 'tamil', 'active'),
(83, 90, '94456790', 'Marsiling Dr', 'morning', 'weekly', 'mandarin', 'active'),
(84, 91, '85567901', 'Kranji Rd', 'afternoon', 'monthly', 'english', 'active'),
(85, 92, '96679012', 'Yew Tee', 'evening', 'biweekly', 'malay', 'active'),
(86, 93, '87789023', 'Admiralty Rd', 'morning', 'weekly', 'english', 'active'),
(87, 94, '98890134', 'Sungei Kadut', 'afternoon', 'monthly', 'tamil', 'active'),
(88, 95, '89901245', 'Mandai Rd', 'evening', 'biweekly', 'mandarin', 'active'),
(89, 96, '90012356', 'Lim Chu Kang Rd', 'morning', 'weekly', 'english', 'active'),
(90, 97, '81123467', 'Nee Soon Rd', 'afternoon', 'monthly', 'malay', 'active'),
(91, 98, '92234578', 'Old Choa Chu Kang Rd', 'evening', 'biweekly', 'english', 'active'),
(92, 99, '83345689', 'Jalan Kayu', 'morning', 'weekly', 'tamil', 'active'),
(93, 100, '94456700', 'Seletar West Farmway', 'afternoon', 'monthly', 'mandarin', 'active'),
(94, 101, '85567801', 'Punggol Seventeenth Ave', 'evening', 'biweekly', 'english', 'active'),
(95, 102, '96678902', 'Changi Village Rd', 'morning', 'weekly', 'malay', 'active'),
(96, 103, '87789013', 'Loyang Ave', 'afternoon', 'monthly', 'english', 'active'),
(97, 104, '98890124', 'Tuas South Ave 4', 'evening', 'biweekly', 'tamil', 'active'),
(98, 105, '89901235', 'Pioneer Rd', 'morning', 'weekly', 'mandarin', 'active'),
(99, 106, '90012346', 'Jalan Buroh', 'afternoon', 'monthly', 'english', 'active'),
(100, 107, '81123457', 'Boon Lay Way', 'evening', 'biweekly', 'malay', 'active'),
(101, 108, '92234568', 'Jurong Town Hall Rd', 'morning', 'weekly', 'english', 'active'),
(102, 109, '83345679', 'Jalan Ahmad Ibrahim', 'afternoon', 'monthly', 'tamil', 'active'),
(103, 110, '94456790', 'Penjuru Rd', 'evening', 'biweekly', 'mandarin', 'active'),
(104, 111, '85567901', 'Benoi Rd', 'morning', 'weekly', 'english', 'active'),
(105, 112, '96679012', 'Pandan Loop', 'afternoon', 'monthly', 'malay', 'active');

-- --------------------------------------------------------

-- Table structure for table `manager_profiles`

CREATE TABLE `manager_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(8) NOT NULL,
  `address` text NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `manager_profiles`


INSERT INTO `manager_profiles` (`profile_id`, `user_id`, `phone`, `address`, `status`) VALUES
(1, 4, '90890987', 'Serangoon', 'active'),
(2, 115, '81234567', 'Bishan St 24', 'active'),
(3, 116, '92345678', 'Tampines Ave 7', 'active'),
(4, 117, '83456789', 'Jurong East Ctrl', 'active'),
(5, 118, '94567890', 'Sembawang Rd', 'active');

-- --------------------------------------------------------

-- Table structure for table `service_categories`


CREATE TABLE `service_categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `service_categories`
INSERT INTO `service_categories` (`category_id`, `name`, `description`, `status`) VALUES
(1, 'Mobility', 'Bringing PIN to see doctor', 'active'),
(2, 'Entertainment', 'Sing and Dance with PIN', 'active'),
(3, 'Education', 'Count 1 to 100 with PIN', 'active'),
(4, 'Mobility', 'Offer wheelchair to PIN', 'active'),
(5, 'Health ', 'Bringing medical service to PIN ', 'active'),
(6, 'Digital Literacy', 'Basic Tutorial on Using a Smartphone', 'active'),
(7, 'Administrative', 'Help To Fill in Healthcare Related Paperwork', 'active');

-- --------------------------------------------------------


-- Table structure for table `service_views`

CREATE TABLE `service_views` (
  `view_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `PIN_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `service_views`

INSERT INTO `service_views` (`view_id`, `job_id`, `PIN_id`) VALUES
(1, 1, 3),
(3, 1, 11),
(11, 1, 14),
(2, 2, 3),
(4, 2, 11),
(5, 3, 3),
(6, 3, 11),
(8, 3, 14),
(7, 4, 12),
(12, 4, 14),
(10, 5, 12),
(9, 5, 14);

-- --------------------------------------------------------

-- Table structure for table `shortlists`


CREATE TABLE `shortlists` (
  `shortlist_id` int(11) NOT NULL,
  `PIN_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `shortlists`

INSERT INTO `shortlists` (`shortlist_id`, `PIN_id`, `job_id`) VALUES
(3, 3, 1),
(4, 3, 2),
(5, 3, 3),
(2, 11, 1),
(1, 11, 2),
(6, 12, 4),
(8, 12, 5),
(7, 14, 5);

-- --------------------------------------------------------

-- Table structure for table `users`

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','manager','CSR','PIN') NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `users`

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`) VALUES
(1, 'Sara Lee', 'saralee@gmail.com', 'Pass1234', 'admin', 'active'),
(2, 'Ben Chong', 'benchong@gmail.com', 'admin_pass', 'admin', 'active'),
(3, 'Chloe Tan', 'chloetan@gmail.com', 'manager_pwd', 'manager', 'active'),
(4, 'David Lim', 'davidlim@gmail.com', 'mgmt_pass', 'manager', 'active'),
(5, 'Emily Goh', 'emilygoh@gmail.com', 'CSR_pass1', 'CSR', 'active'),
(6, 'Frankie Ng', 'frankie_ng@gmail.com', 'PIN_pass1', 'PIN', 'active'),
(7, 'Grace Koh', 'gracekoh@gmail.com', 'CSR_pass2', 'CSR', 'active'),
(8, 'Howard Soh', 'howardsoh@gmail.com', 'PIN_pass2', 'PIN', 'active'),
(9, 'Ivy Chan', 'ivychan@gmail.com', 'CSR_pass3', 'CSR', 'active'),
(10, 'Jason Wee', 'jasonwee@gmail.com', 'PIN_pass3', 'PIN', 'active'),
(11, 'Kelly Liew', 'kellyliew@gmail.com', 'CSR_pass4', 'CSR', 'active'),
(12, 'Larry Tay', 'larrytay@gmail.com', 'PIN_pass4', 'PIN', 'active'),
(13, 'Mandy Neo', 'mandyneo@gmail.com', 'CSR_pass5', 'CSR', 'active'),
(14, 'Nathan Weng', 'nathanweng@gmail.com', 'PIN_pass5', 'PIN', 'active'),
(15, 'Olivia Pang', 'oliviapang@gmail.com', 'CSR_pass6', 'CSR', 'active'),
(16, 'Peter Khoo', 'peterkhoo@gmail.com', 'PIN_pass6', 'PIN', 'active'),
(17, 'Quincy Yeo', 'quincyyeo@gmail.com', 'CSR_pass7', 'CSR', 'active'),
(18, 'Raymond Tan', 'raymondtan@gmail.com', 'PIN_pass7', 'PIN', 'active'),
(19, 'Stella Chua', 'stellachua@gmail.com', 'CSR_pass8', 'CSR', 'active'),
(20, 'Victor Wong', 'victorwong@gmail.com', 'PIN_passwordy', 'PIN', 'active');

-- Indexes for dumped tables

-- Indexes for table `admin_profiles`

ALTER TABLE `admin_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);


-- Indexes for table `CSR_profiles`
ALTER TABLE `CSR_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_CSR_profiles_expertise` (`expertise`);


-- Indexes for table `consultation_services`
ALTER TABLE `consultation_services`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `CSR_id` (`CSR_id`),
  ADD KEY `consultation_services_ibfk_2` (`category_id`);


-- Indexes for table `confirmed_jobs`
ALTER TABLE `confirmed_jobs`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `CSR_id` (`CSR_id`),
  ADD KEY `PIN_id` (`PIN_id`);

-- Indexes for table `favorites`
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `unique_favorite` (`PIN_id`,`CSR_id`),
  ADD KEY `CSR_id` (`CSR_id`);


-- Indexes for table `PIN_profiles`
ALTER TABLE `PIN_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

-- Indexes for table `manager_profiles`
ALTER TABLE `manager_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);


-- Indexes for table `service_categories`
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`category_id`);

-- Indexes for table `service_views`
ALTER TABLE `service_views`
  ADD PRIMARY KEY (`view_id`),
  ADD UNIQUE KEY `job_id` (`job_id`,`PIN_id`),
  ADD KEY `PIN_id` (`PIN_id`);

-- Indexes for table `shortlists`
ALTER TABLE `shortlists`
  ADD PRIMARY KEY (`shortlist_id`),
  ADD UNIQUE KEY `PIN_id` (`PIN_id`,`job_id`),
  ADD KEY `shortlists_ibfk_2` (`job_id`);

-- Indexes for table `users`
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT for dumped tables
-- AUTO_INCREMENT for table `admin_profiles`

ALTER TABLE `admin_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- AUTO_INCREMENT for table `CSR_profiles`
ALTER TABLE `CSR_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;


-- AUTO_INCREMENT for table `consultation_services`
ALTER TABLE `consultation_services`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


-- AUTO_INCREMENT for table `confirmed_jobs`
ALTER TABLE `confirmed_jobs`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;


-- AUTO_INCREMENT for table `favorites`
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

-- AUTO_INCREMENT for table `PIN_profiles`
ALTER TABLE `PIN_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

-- AUTO_INCREMENT for table `manager_profiles`
ALTER TABLE `manager_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- AUTO_INCREMENT for table `service_categories`
ALTER TABLE `service_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

-- AUTO_INCREMENT for table `service_views`
ALTER TABLE `service_views`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

-- AUTO_INCREMENT for table `shortlists`
ALTER TABLE `shortlists`
  MODIFY `shortlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

-- AUTO_INCREMENT for table `users`

ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

-- Constraints for dumped tables

-- Constraints for table `admin_profiles`
ALTER TABLE `admin_profiles`
  ADD CONSTRAINT `admin_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


-- Constraints for table `CSR_profiles`
ALTER TABLE `CSR_profiles`
  ADD CONSTRAINT `CSR_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_CSR_profiles_expertise` FOREIGN KEY (`expertise`) REFERENCES `service_categories` (`category_id`) ON UPDATE CASCADE;


-- Constraints for table `consultation_services`
ALTER TABLE `consultation_services`
  ADD CONSTRAINT `consultation_services_ibfk_1` FOREIGN KEY (`CSR_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultation_services_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`category_id`) ON DELETE SET NULL;

-- Constraints for table `confirmed_jobs`
ALTER TABLE `confirmed_jobs`
  ADD CONSTRAINT `confirmed_jobs_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `consultation_services` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `confirmed_jobs_ibfk_2` FOREIGN KEY (`CSR_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `confirmed_jobs_ibfk_3` FOREIGN KEY (`PIN_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Constraints for table `favorites`
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`PIN_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`CSR_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Constraints for table `PIN_profiles`
ALTER TABLE `PIN_profiles`
  ADD CONSTRAINT `PIN_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Constraints for table `manager_profiles`
ALTER TABLE `manager_profiles`
  ADD CONSTRAINT `manager_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Constraints for table `service_views`
ALTER TABLE `service_views`
  ADD CONSTRAINT `service_views_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `consultation_services` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_views_ibfk_2` FOREIGN KEY (`PIN_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Constraints for table `shortlists`
ALTER TABLE `shortlists`
  ADD CONSTRAINT `shortlists_ibfk_1` FOREIGN KEY (`PIN_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shortlists_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `consultation_services` (`job_id`) ON DELETE CASCADE;
COMMIT;
