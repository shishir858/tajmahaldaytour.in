-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2026 at 01:10 PM
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
-- Database: `sspsof5_tajmahal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('super_admin','admin','editor') DEFAULT 'admin',
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password`, `full_name`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@tajmahaldaytour.com', '$2y$10$AVGFFlOsiow35UpbYbWGPuybcbJzI0gHD5LnuIT5BDncrkCvbqRfG', 'Admin User', 'super_admin', 1, '2026-01-20 11:53:31', '2025-12-31 07:17:20', '2026-01-20 11:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_number` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `travel_date` date NOT NULL,
  `number_of_persons` int(11) NOT NULL,
  `number_of_days` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `final_price` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','partial','paid','refunded') DEFAULT 'pending',
  `paid_amount` decimal(10,2) DEFAULT 0.00,
  `payment_method` varchar(50) DEFAULT NULL,
  `booking_status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `special_requests` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `show_in_header` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `display_order`, `is_active`, `show_in_header`, `created_at`, `updated_at`) VALUES
(1, 'Golden Triangle', 'golden-triangle', 'Explore Delhi, Agra, and Jaipur - India\'s most iconic destinations', NULL, 1, 1, 1, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(2, 'Himachal Tours', 'himachal-tours', 'Experience the beauty of Himachal Pradesh with hill stations and adventure', NULL, 2, 1, 1, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(3, 'Rajasthan Tours', 'rajasthan-tours', 'Discover the royal heritage and desert landscapes of Rajasthan', NULL, 3, 1, 1, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(4, 'Taj Mahal Tours', 'tajmahal-tours', 'Visit the iconic Taj Mahal with same-day and multi-day packages', NULL, 4, 1, 1, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(5, 'Pilgrimage Tours', 'pilgrimage-tours', 'Spiritual journeys to sacred destinations across India', NULL, 5, 1, 1, '2025-12-31 06:57:49', '2025-12-31 06:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `country` varchar(100) DEFAULT 'India',
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'India',
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `slug`, `state`, `country`, `description`, `image`, `latitude`, `longitude`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'Delhi', 'delhi', 'Delhi', 'India', 'Capital city with rich Mughal heritage', '6954d1c682c64_1767166406.jpg', NULL, NULL, 1, 1, '2025-12-31 06:57:49', '2025-12-31 07:33:26'),
(2, 'Agra', 'agra', 'Uttar Pradesh', 'India', 'Home to the iconic Taj Mahal', NULL, NULL, NULL, 1, 2, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(3, 'Jaipur', 'jaipur', 'Rajasthan', 'India', 'The Pink City known for forts and palaces', NULL, NULL, NULL, 1, 3, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(4, 'Shimla', 'shimla', 'Himachal Pradesh', 'India', 'Popular hill station and former summer capital', NULL, NULL, NULL, 1, 4, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(5, 'Manali', 'manali', 'Himachal Pradesh', 'India', 'Adventure hub with snow-capped mountains', NULL, NULL, NULL, 1, 5, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(6, 'Dharamshala', 'dharamshala', 'Himachal Pradesh', 'India', 'Home to Dalai Lama and Tibetan culture', NULL, NULL, NULL, 1, 6, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(7, 'Kullu', 'kullu', 'Himachal Pradesh', 'India', 'Valley of Gods with scenic beauty', NULL, NULL, NULL, 1, 7, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(8, 'Dalhousie', 'dalhousie', 'Himachal Pradesh', 'India', 'Charming colonial-era hill station', NULL, NULL, NULL, 1, 8, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(9, 'Kasauli', 'kasauli', 'Himachal Pradesh', 'India', 'Peaceful hill town with colonial charm', NULL, NULL, NULL, 1, 9, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(10, 'Udaipur', 'udaipur', 'Rajasthan', 'India', 'City of Lakes with romantic palaces', NULL, NULL, NULL, 1, 10, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(11, 'Jodhpur', 'jodhpur', 'Rajasthan', 'India', 'The Blue City with Mehrangarh Fort', NULL, NULL, NULL, 1, 11, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(12, 'Jaisalmer', 'jaisalmer', 'Rajasthan', 'India', 'The Golden City in Thar Desert', NULL, NULL, NULL, 1, 12, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(13, 'Bikaner', 'bikaner', 'Rajasthan', 'India', 'Desert city famous for Junagarh Fort', NULL, NULL, NULL, 1, 13, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(14, 'Pushkar', 'pushkar', 'Rajasthan', 'India', 'Sacred town with Brahma Temple', NULL, NULL, NULL, 1, 14, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(15, 'Mount Abu', 'mount-abu', 'Rajasthan', 'India', 'Only hill station in Rajasthan', NULL, NULL, NULL, 1, 15, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(16, 'Varanasi', 'varanasi', 'Uttar Pradesh', 'India', 'Holiest city on banks of Ganges', NULL, NULL, NULL, 1, 16, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(17, 'Haridwar', 'haridwar', 'Uttarakhand', 'India', 'Gateway to God with evening Ganga Aarti', NULL, NULL, NULL, 1, 17, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(18, 'Rishikesh', 'rishikesh', 'Uttarakhand', 'India', 'Yoga capital of the world', NULL, NULL, NULL, 1, 18, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(19, 'Mathura', 'mathura', 'Uttar Pradesh', 'India', 'Birthplace of Lord Krishna', NULL, NULL, NULL, 1, 19, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(20, 'Vrindavan', 'vrindavan', 'Uttar Pradesh', 'India', 'Sacred town of Krishna temples', NULL, NULL, NULL, 1, 20, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(21, 'Amritsar', 'amritsar', 'Punjab', 'India', 'Home to the Golden Temple', NULL, NULL, NULL, 1, 21, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(22, 'Goa', 'goa', 'Goa', 'India', 'Beach paradise with Portuguese heritage', NULL, NULL, NULL, 1, 22, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(23, 'Kerala', 'kerala', 'Kerala', 'India', 'God\'s Own Country with backwaters', NULL, NULL, NULL, 1, 23, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(24, 'Mumbai', 'mumbai', 'Maharashtra', 'India', 'Financial capital and Bollywood hub', NULL, NULL, NULL, 1, 24, '2025-12-31 06:57:49', '2025-12-31 06:57:49'),
(25, 'Bangalore', 'bangalore', 'Karnataka', 'India', 'Garden City and IT capital', NULL, NULL, NULL, 1, 25, '2025-12-31 06:57:49', '2025-12-31 06:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_new`
--

CREATE TABLE `gallery_new` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `related_type` enum('package','destination','vehicle','general') DEFAULT 'general',
  `related_id` int(11) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_destinations`
--

CREATE TABLE `package_destinations` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `day_number` int(11) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_destinations`
--

INSERT INTO `package_destinations` (`id`, `package_id`, `destination_id`, `day_number`, `display_order`, `created_at`) VALUES
(1, 1, 14, NULL, 0, '2025-12-31 07:46:22'),
(4, 4, 1, NULL, 0, '2025-12-31 09:18:31'),
(5, 4, 4, NULL, 0, '2025-12-31 09:18:31'),
(6, 5, 5, NULL, 0, '2025-12-31 09:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `package_itinerary`
--

CREATE TABLE `package_itinerary` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `day_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meals` varchar(100) DEFAULT NULL,
  `accommodation` varchar(255) DEFAULT NULL,
  `activities` text DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_itinerary`
--

INSERT INTO `package_itinerary` (`id`, `package_id`, `day_number`, `title`, `description`, `meals`, `accommodation`, `activities`, `display_order`, `created_at`) VALUES
(1, 1, 1, 'Arrive in Delhi.', 'Airport and transfer to hotel and night stay in new Delhi:', NULL, NULL, NULL, 0, '2025-12-31 07:46:22'),
(2, 1, 2, 'Delhi Day Tour.', 'this day after breakfast you start Delhi guided tour and visit sights Red Fort , Jama Masjid , Raj Ghat , India Gate , Lotas Temple , Qutab Minner , Persistent House Hum-yuan Tomb and lunch and dinner in the city and night stay in Delhi.', NULL, NULL, NULL, 0, '2025-12-31 07:46:22'),
(3, 1, 3, 'Delhi- Jaipur Drive.', 'After breakfast drive to pink city of Jaipur you reach around in afternoon and check-inn in the hotel and after rest going to center city and walking tour and night stay in Jaipur.', NULL, NULL, NULL, 0, '2025-12-31 07:46:22'),
(4, 1, 4, 'Jaipur Guided Day Tour', 'After breakfast you going to amber fort with your private tour guide and see the amber fort and after water palace , City Palace , Wind Palace and local bazaars and night stay in Jaipur', NULL, NULL, NULL, 0, '2025-12-31 07:46:22'),
(5, 1, 5, 'Jaipur-Pushkar-Jaipur Day Trip', 'Early in the morning we drive to Pushkar Day Trip and you reach around 10:30 am in the morning and visit pushkar and see the holy lakes and Oldest Hindu Temples and if you have also enjoy the camel ride and after pushkar tour back to the Jaipur and night stay in Jaipur.', NULL, NULL, NULL, 0, '2025-12-31 07:46:22'),
(6, 1, 6, 'Jaipur- Agra Drive.', 'After breakfast check-out from hotel and drive to Agra and en-route you visit fathepur sikri and night stay in Agra.', NULL, NULL, NULL, 0, '2025-12-31 07:46:22'),
(7, 1, 7, 'Agra- Delhi Drive', 'Visit Taj Mahal in morning and see the nice sunrise and after back to the hotel and breakfast , check-out and visit Agra fort and drive back to new Delhi.', NULL, NULL, NULL, 0, '2025-12-31 07:46:22'),
(135, 18, 1, 'Day 01: Arrive in Delhi ', 'As per your flight schedule driver pickup you from Delhi Airport. And depart from Delhi to Agra. around 3 hours drive so late evening check in Agra hotel. overnight in Agra hotel.', NULL, NULL, NULL, 1, '2025-12-31 08:53:56'),
(136, 18, 2, 'Day - 02 Agra - Jaipur ', 'Early morning at the time of Sunrise visit the Taj Mahal. (best time to visit the Taj). after the Taj Mahal tour back to the hotel for breakfast. and visit the Agra fort and depart from Agra to Jaipur around 4 hour drive, on the Way visit Fatehpur sikri Fort (Capital city of Akbar). evening check in Jaipur hotel over night rest in Jaipur hotel. overnight in Jaipur Hotel.', NULL, NULL, NULL, 2, '2025-12-31 08:53:56'),
(137, 18, 3, 'Day 03: Jaipur- Delhi', 'After breakfast start your Guiding tour of Capital city of Rajasthan Jaipur.\r\n\r\nVisit:- Amber Fort, City Palace. Hawa Mahal, Jal Mahal, Jantar Mantar,\r\nafter the guiding tour of Jaipur visit Jaipur Bazaar and around 4 pm Depart from Jaipur to Delhi, Around 4/5 hour drive, evening around 9 pm driver transfer you to Delhi Airport/ Hotel/ Railway Station.', NULL, NULL, NULL, 3, '2025-12-31 08:53:56'),
(143, 4, 1, 'Delhi - Shimla (380 kms)', 'On Arrival in Delhi we will meet you and transfer by to Shimla (343 kms / 8 hrs).Shimla is capital of himachal former capital of Britishers also set amidst, the snow copper, shaivalik,mountains which offer some of the most beautifull view of himalaya Reach there and check in hotel Dinner and overnight at Simla.', NULL, NULL, NULL, 0, '2025-12-31 09:18:31'),
(144, 4, 2, 'Shimla', 'After breakfast,go out for a sightseeing trip to Kufri(14 kms/1 hour). Afternoon half day city tour visiting Indian Institute Of Advanced Studies, Sankat Mochan Temple and Jakhu Temple, Evening free to stroll in the famous shopping place of Shimla town - The Mall & The Ridge. Dinner and Overnight at hotel.', NULL, NULL, NULL, 0, '2025-12-31 09:18:31'),
(145, 4, 3, 'Shimla - Kasauli (80 Kms/2 hours)', 'After breakfast,transfer to Kasauli.Kasauli is a small,unspoiled hill station in Solan district of Himachal Pradesh,it is far away from the maddening crowds which you find in other cities and hill stations.Day at leisure and dinner and overnight stay at hotel in Kasauli.', NULL, NULL, NULL, 0, '2025-12-31 09:18:31'),
(146, 4, 4, 'Kasauli', 'After breakfast,go for local sightseeing in the town and near by areas,evening at leisure,one can spend evening tolling in the mall and shopping.Dinner and overnight stay at hotel in Kasauli.', NULL, NULL, NULL, 0, '2025-12-31 09:18:31'),
(147, 4, 5, 'Departure(Kasauli-Delhi)', 'After breakfast,depart for Delhi(320 kms/7 hours).Tour Ends.', NULL, NULL, NULL, 0, '2025-12-31 09:18:31'),
(160, 6, 1, 'Pick up from Delhi airport transfer to Haridwar.', 'Highlights - Ganga Aarati at Har ki Pauri\r\n\r\nMeet our assistance on arrival as per your predefined schedule and further proceed to Haridwar.\r\nUpon arrival check into the hotel and further you can proceed for Ganga Aarti at Har Ki Pouri on\r\nyour own if possible with available time and conditions. So here Har Ki pouri is the center point\r\nof Haridwar and there are several local transports available for this sight. We kept you free to\r\nexplore the local Haridwar and edge of Ganges. Overnight stay in Haridwar.', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(161, 6, 2, 'Haridwar Barkot (approx 215km / 07 hrs. drive)', 'Highlights - Mussoorie & Kempty Fall\r\n\r\nThis morning, you depart for Barkot. Barkot is a beautiful hill station which is located on the foot\r\nof Yamunotri. As you drive through Mussoorie, you can visit the famous Kempty Falls on your\r\nway. On arrival at Barkot, check-in to your hotel/camp. Rest of the day is free to relax and store\r\nyour energy for the hiII Yatra of Yamunotri Overnight stay at Barkot.', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(162, 6, 3, 'Barkot  Yamunotri Barkot (approx 42 km DRIVE / 06 km TREK)', 'Highlights - Yamunotri Temple\r\n\r\nAfter breakfast, depart for Hanumanchatti (40 Km), Janki Chatti (8 km). Here you will begin the\r\nFirst hill Yatra of Yamunotri (6 Km trek). You have an option of hiring Palki or a horse for your\r\ntrek. (Cost Not Included).\r\nThe trek passes through lush green valley, a profusion of conifers, rhododendrons, cacti and\r\nseveral species of Himalayan shrubs.', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(163, 6, 4, 'Barkot  Uttarkashi (approx DRIVE 82 km, / 04 hrs. DRIVE)', 'Highlights - Vishwanath Temple\r\n\r\nAfter breakfast check out from the Barkot hotel and drive to Uttarkashi. En route visit the famous\r\nVishwanath Temple on Uttarkashi. On arrival check in into the hotel. Uttarkashi is situated on the\r\nbanks of river Bhagirathi and is famous for its historical monuments, Temples & Ashrams. .\r\nOvernight stay at Uttarkashi.', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(164, 6, 5, 'Uttarkashi  Gangotri Uttarkashi (approx 100 km. PER WAY)', 'Highlights - Gangotri Temple\r\n\r\nEarly morning breakfast at the hotel and drive to Gangotri. Upon arrival at Gangotri take a holy\r\ndip in the sacred river Ganges which is also called Bhagirathi at its origin. Visit the Gangotri\r\nTemple. The 18th century\'s temple dedicated to Goddess Ganga is located near a sacred stone\r\nwhere King Bhagirathi worshiped Lord Shiva. Ganga is believed to have touched earth at this\r\nspot. The temple is an exquisite 20 ft. high structure made of white granite. After performing\r\nPooja, afternoon drive back to Uttarkashi. Overnight stay at Uttarkashi.', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(165, 6, 6, 'Uttarkashi  Guptkashi / Phata (approx 223 kms / 09 hrs DRIVE)', 'Highlights - Shree Kashi Vishwanath Temple and Ardhnareshwar Temple\r\n\r\nLeave for your next destination, Guptkashi after having your breakfast early in the morning. On\r\nreaching, check-in to the hotel. Guptkashi is located at a distance of 47 km from the holy shrine,\r\nKedarnath. The town holds immense religious importance as it houses famous ancient temples\r\nlike Shree Kashi Vishwanath Temple and Ardhnareshwar Temple. overnight in the hotel/camp.', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(166, 6, 7, 'Guptkashi/Phata  Kedarnath (approx 27 km DRIVE + 19 km TREK)', 'Highlights - Kedarnath Temple, Adi Shankaracharya Temple\r\n\r\nEarly morning after breakfast drive to the helipad from where, you will start to fly to Kedarnath\r\nby helicopter. Mandakini, one of the main tributaries of the Ganges originates at Kedarnath and\r\nflows through Gaurikund. \"Jai Bholenath\" chants echo in the mountains. The mists envelop the\r\nmountains and slowly lift away. When you can view the picturesque beauty you are left\r\nmesmerized. Overnight stay at Kedarnath.', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(167, 6, 8, 'Kedarnath Guptkashi / Phata (approx 27 km DRIVE + 19 km TREK)', 'Early morning after breakfast you can come back to the helipad to fly to the Sersi / Phata by\r\nhelicopter. The vehicles are waiting for you in the helipad and youï¿½ll drive to the hotel and\r\nOvernight at Guptkashi.', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(168, 6, 9, 'Guptkashi/ Phata  Pandukeshwar / Badrinath (185 kms / 7 hrs )', 'Highlights - Chopta Peak\r\n\r\nAfter having your breakfast in the morning, check out of the hotel and start driving towards your\r\nnext destination, Badrinath via Joshimath. Badrinath is an important pilgrimage site which holds\r\nimmense importance for both Hindus and Buddhists. Badrinath temple is dedicated to Lord\r\nVishnu and is set at a height of 3133 meter. On arrival check into the hotel. After some rest and\r\nrefreshments you are all set to go to Badrinath Temple for darshan in the evening. But first you\r\nhave to go to Tapt Kund (Hot Spring), take a bath and then go to the temple. Dedicated to Lord\r\nVishnu. Later back to hotel. Overnight stay at hotel.', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(169, 6, 10, 'Badrinath  Rudraprayag', 'Highlights - Mana Village - Vasudhara Falls, Satopanth Lake, Bhim Pul, Saraswati Temple,\r\nGanesh Gufa & Vyas Gufa\r\nAlso see Vishnuprayag, Nandprayag, Karnprayag\r\n\r\nThis morning if we had not visited Badrinath Temple, we could visit for Darshan. Later return to\r\nthe hotel for breakfast. After breakfast check out from the hotel and proceed to Mana Village\r\nwhich is known as the last village of India. Places to visit in Mana Village - Bhim Pool, Vyas\r\nGufa and Vasudhara Falls. Later you drive for Rudraprayag. En-route you can see\r\nVIshnuprayag, Nandprayag, Karanprayag. On reaching Rudraprayag, check-in to the hotel. You\r\ncan relax for the rest of the day.stay overnight at the hotel.', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(170, 6, 11, 'Rudraprayag  Rishikesh', 'Highlights - Rudraprayag, Dhari Devi Temple, Dev Prayag, Ram Jhula, Laxman Jhula\r\n\r\nEarly morning, after breakfast, you drive downhill to Rishikesh, a spiritual city and the Yoga\r\ncapital of the world. Enroute you can visit Mata Dhari Devi Temple. On reaching Rishikesh, go\r\nout for sightseeing. Visit Ram Jhula and Laxman Jhula. Evening you can visit Ganga Aarati at\r\nTriveni Ghat. drop to Hotel. overnight stay in hotel', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(171, 6, 12, 'Rishikesh- Delhi', 'After breakfast check out from the hotel and drive to Delhi', NULL, NULL, NULL, 0, '2025-12-31 09:18:56'),
(177, 5, 1, 'Delhi - Manali', 'On arrival at Delhi, our representative meets you and assists to transfer you to Manali 570 km/ 11 hrs. On arrival check in at hotel, freshen up and enjoy rest of the time at leisure. At night enjoy delicious dinner and overnight stay t the hotel in Manali.', NULL, NULL, NULL, 0, '2025-12-31 09:20:33'),
(178, 5, 2, 'Manali Sightseeing', 'Morning after breakfast get ready for city tour to visit some of the magnificent attractions including Hadimba Devi Temple, Tibetan Monastery, Manu Temple and Vashisht Village. Afternoon enjoy at leisure. Dinner and overnight stay will be at the hotel in Manali.', NULL, NULL, NULL, 0, '2025-12-31 09:20:33'),
(179, 5, 3, 'Manali Excursion', 'Enjoy the early morning breakfast at the hotel. Later visit to Kothi Gorge, Marhi, Rothang pass and Marhi. Rothang Pass is an important tourist spot with alluring view of the snow capped Himalayas, picturesque lakes and scintillating tranquil surrounding. After visiting to Solang Valley, return back to the hotel on time and enjoy delicious dinner and overnight stay. .( in Winter Car will be going only up to the Snow point).', NULL, NULL, NULL, 0, '2025-12-31 09:20:33'),
(180, 5, 4, 'Manali - Manikaran via Kullu - Manali', 'Morning after breakfast, check out from the hotel and drive to Manikaran 75 kms /4 hours, enroute visiting Kullu. Manikaran is located in Parvati valley amidst the river Vyaas and Parvati in the Kullu district of Himachal Pradesh. Manikaran is holy centre of both Hindu and Sikh religion. It is believed that Manu created human life again in Manikaran after the devastating flood, making the place centre of pilgrimage. After visit to Manikaran transfer to Kullu valley (45 kms/2 hours) for a half day sightseeing tour and panoramic view of the natural beauty and snow capped himalayas. Return to Manali by evening for dinner and overnight stay at the hotel.', NULL, NULL, NULL, 0, '2025-12-31 09:20:33'),
(181, 5, 5, 'Manali - Delhi', 'Morning after breakfast, check out from the hotel and transfer to Delhi 520 K M (10 hrs).', NULL, NULL, NULL, 0, '2025-12-31 09:20:33'),
(212, 10, 1, 'Sight Seeing of Delhi', 'Welcome to the Pink City! Upon arrival, you\'ll be greeted and transferred to your hotel. After check-in, explore local markets or enjoy a short sightseeing tour including Birla Mandir and Nahargarh Fort for a sunset view.', NULL, NULL, NULL, 0, '2025-12-31 09:22:02'),
(213, 10, 2, 'Delhi- Mandawa Drive', 'Check in Hotel and get ready for afternoon sightseeing tour in the fort town of Mandawa, famous for its heritage Havelis and fresco art. Thousands of tourists come here to see the Mandawa Castle, which was an important station in the silk route. Now Castle Mandawa has been converted into a beautiful heritage hotel. Night halt at Bikaner', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(214, 10, 3, 'Mandawa â€“ Bikaner Drive', 'Lalgarh-palaceCheck in Hotel & enjoy the afternoon sightseeing tour. A leisurely afternoon visit includes are the major attractions like the Lalgarh Palace, the Junagarh fort, Ganga Golden Jubilee Museum, the Bhandasar Jain Temple, The Gajner Palace, the Shiv Bari Temple including Kalibangan, a famous Harappan civilization site. Night halt at Bikaner', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(215, 10, 4, 'Bikaner â€“ Jaisalmer Drive', 'At Jaisalmer morning sightseeing tour of Jaisalmer, covering beautiful locations like the 12th century Jaisalmer Fort, Gadsisar Lake, Nathmalji-ki-Haveli, Patwon -ki-Haveli, Salim Singh-ki-Haveli and Jain Temple & in the afternoon an exciting trip to Sand dunes and camel safari, night Halt at Jaisalmer.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(216, 10, 5, 'Jaisalmer -Jodhpur Drive', 'Drive to Jodhpur and check-in at a hotel. Jodhpur has several major tourist attractions like Umaid Bhawan Palace, Girdikot and Sardar Market famous for a wide range of handicrafts. Night halt at Jodhpur.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(217, 10, 6, 'Jodhpur Tour', 'Mehrangarh-Fort Sightseeing of Jodhpur including Mehrangarh Fort and Jaswant Thada built in 1899 A.D. in memory of Maharaja Jaswant Singh II. An afternoon sightseeing trip will cover all these destinations. Night halt at Jodhpur.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(218, 10, 7, 'Jodhpur -Udaipur Drive', 'While driving to Udaipur enroute visit Ranakpur Temples, This huge temple complex is located just 90 km from Udaipur city. These are the most extensive of Jain temples in India, covering an area of around 40,000 square feet. Check-in at the hotel for overnight.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(219, 10, 8, 'Udaipur Tour', 'Jag-MahalCity sightseeing tour, Major tourist attractions in Udaipur are Lake Pichola, the largest and the most beautiful of Udaipurâ€™s lakes, City Palace, on the banks of the Lake Pichola, island palaces like Jag Mahal and Jag Niwas, Jagdish Temple, Sahelion Ki Bari, Gulab Bagh (Rose garden) and the 18th century monsoon palace, Sajjangarh. Spend leisure time during afternoon.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(220, 10, 9, 'Udaipur-Pushkar Drive', 'Sightseeing of the holy city of Pushkar, You will get an opportunity to see various religious traditions and rituals practiced in India. Pushkar has several beautiful temples like Brahma Temple, Rangaji Temple, and Savitri Temple, holy ghats and lakes like the famous Pushkar Lake and Night stay in Pushkar.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(221, 10, 10, 'Pushkar-Jaipur Drive', 'Sightseeing tour of Jaipur, visiting sprawling Havelis, serene temples and well laid out gardens of Jaipur, enjoy the architectural excellence of Amber Fort, City Palace, Jantar Mantar, Hawa Mahal and shop for the unique handicrafts of local people. Night halt at Jaipur Drive to Ranthambhore, afternoon jeep safari to view Wildlife. Ranthambore National Park is spread over in an area of 392 sq. kilometrtes.Night stay in Jaipur.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(222, 10, 11, 'Jaipur- Ranthambore Drive', 'After Jaipur sightseen you drive to Ranthambore National Park , check-inn in the hotel and night stay in ranthambore city.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(223, 10, 12, 'Ranthambhore Forest Tour', 'Ranthambore-National-ParkMorning & afternoon jeep safari to view wildlife, Ranthambore National Park is home of variety of animals like Tiger, sambhar, cheetal, wild boar, leopard, sloth bear, and jackal. Night halt at Ranthambhore.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(224, 10, 13, 'Ranthambore-Agra Drive', 'Taj-MahalSightseeing tour of Agra, visiting Taj Mahal, Agra Fort, Jehangir Mahal, Diwan-i-Khas, Diwan-i-Am and Moti Masjid experience the traditional art and craft of Agra like the famous fine marble inlay work and other handicraft products. Night halt at Agra.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(225, 10, 14, 'Agra Delhi Delhi', 'Reaching Delhi after a 204 km long comfortable drive & night stay in Delhi.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(226, 10, 15, 'Delhi Airport transfer', 'Next day after breakfast we will transfer to Airport/Railway station.\r\nPlease note that this is all flexible tour itinerary according to your comfort if you want any change or tailor made itinerary , its will be possible.', NULL, NULL, NULL, 0, '2025-12-31 09:22:03'),
(230, 8, 1, 'Delhi â€“ Haridwar', 'ickup from Delhi Railway Station, Meet & Assist further drive to Haridwar. Check in Hotel. In the evening visit Har-ki-Pauri to view the holy Ganges Aarti. This is the place where the main bathing takes place. The place is called Brahma Kund, the myths says this is the place where the nectar can dissolved in the holy water of river Ganges. If wish, have a dip here later after viewing Aarti visit the market near the place. Later back to your Hotel for night stay.', NULL, NULL, NULL, 0, '2025-12-31 09:24:01'),
(231, 8, 2, 'Haridwar â€“ Rishikesh', 'Morning visit Haridwar Local Sight Seeing i.e Daksh Prajapati Temple, Ananand Mai Ashram, Parad (Mercury) Shivling in Kankhal Region, Mansa Devi and Chandi Devi (both by ropeway), Maya Devi, Pawan Dham, Bhuma Niketan, Parmarth, Bharat Mata Mandir, Shanti Kunj, Saptrishi Ashram and others.\r\n\r\nLater drive to Rishikesh another ancient place which is famous for its Ashrams and for grand viewing of Ganges. Visit Ashrams, some of which are internationally recognized as centre of Philosophical studies, yoga and meditation. Check in Hotel. In the evening visit Triveni Ghat to view the holy Ganges Aarti. Later back to your Hotel for night stay.\r\n\r\nTriveni Ghat: A sacred bathing spot on the bank of the river Ganga where devotees take holy dips and offer prayers. Devotees bathe here with the belief that the water has the power to purify them. Triveni Ghat is also called because it is believed to be the confluence of the Ganga, the Yamuna and the legendary Saraswati river. It is an interesting place to be at dawn when people make offerings of milk to the river and feed the fish. After sunset, as a part of the Aarti ceremony, lamps are floated on the water and provide a spectacular view.', NULL, NULL, NULL, 0, '2025-12-31 09:24:01'),
(232, 8, 3, 'Rishikesh Delhi', 'After Breakfast, Visit Rishikesh Local Sight Seeing. Later drive to Delhi. Drop at Airport for your onward destination.', NULL, NULL, NULL, 0, '2025-12-31 09:24:01'),
(233, 7, 1, 'Arrival in Varanasi', 'Pickup: Arrive at Varanasi Airport and transfer to your hotel.\r\nActivities: In the evening, attend the Ganga Aarti at Dashashwamedh Ghat and enjoy a Ghat\r\nDarshan.\r\nOvernight Stay: Varanasi', NULL, NULL, NULL, 0, '2025-12-31 09:25:26'),
(234, 7, 2, 'Sarnath & Varanasi Temples Tour', 'Morning: Visit Sarnath, where Buddha delivered his first sermon. Explore the Dhamek Stupa,\r\nChaukhandi Stupa, and Sarnath Museum.\r\nAfternoon: Visit prominent Varanasi temples such as Kashi Vishwanath Temple, Annapurna\r\nTemple, and Sankat Mochan Hanuman Temple.\r\nOvernight Stay: Varanasi', NULL, NULL, NULL, 0, '2025-12-31 09:25:26'),
(235, 7, 3, 'Varanasi to Prayagraj (Allahabad)', 'Morning: Check out from your hotel and drive to Prayagraj (approximately 3 hours).\r\nActivities: Visit Triveni Sangam (confluence of Ganga, Yamuna, and Saraswati), Anand\r\nBhavan, and Allahabad Fort.\r\nOvernight Stay: Prayagraj', NULL, NULL, NULL, 0, '2025-12-31 09:25:26'),
(236, 7, 4, 'Prayagraj to Ayodhya', 'Morning: Check out from your hotel and drive to Ayodhya (approximately 4 hours).\r\nActivities: Visit Ram Janam Bhoomi, the birthplace of Lord Rama.\r\nOvernight Stay: Ayodhya', NULL, NULL, NULL, 0, '2025-12-31 09:25:26'),
(237, 7, 5, 'Ayodhya Tour', 'Activities: Explore other significant sites in Ayodhya, such as Hanuman Garhi, Kanak\r\nBhawan, and Sita Ki Rasoi.\r\nOvernight Stay: Ayodhya', NULL, NULL, NULL, 0, '2025-12-31 09:25:26'),
(238, 7, 6, 'Departure from Ayodhya', 'Check Out: Check out from your hotel.\r\nTransfer: Drop off at Ayodhya Railway Station or Airport for your next destination.', NULL, NULL, NULL, 0, '2025-12-31 09:25:26'),
(251, 11, 1, 'Pickup from airport /train station', 'Pickup from airport /train station and transfer to hotel, Refresh than after start Delhi tour by car and visit sight Old Delhi â€“Red Fort-Jama Masjid-RajGhat-Humayan tomb-India Gate-President House of India-Qutab Miner & night stay in Delhi', NULL, NULL, NULL, 0, '2025-12-31 09:26:28'),
(252, 11, 2, 'Delhi â€“Agra Drive', 'Pickup from hotel and drive to Agra, check-in in the hotel and refresh after visit Agra fort & Taj Mahal and some local area walking tour â€“Night stay in Agra.', NULL, NULL, NULL, 0, '2025-12-31 09:26:28'),
(253, 11, 3, 'Agra-Fathepur Sikri-Jaipur Drive', 'Pick from hotel and drive to Jaipur en-route visit world heritage site fathepur sikri and after continue drive to Jaipur-night stay in Jaipur.', NULL, NULL, NULL, 0, '2025-12-31 09:26:28'),
(254, 11, 4, 'Jaipur Tour', 'This morning after breakfast you visit Amber fort-Water palace-city palace-wind palace-monkey temple and some walking in bazaar-night stay in Jaipur.', NULL, NULL, NULL, 0, '2025-12-31 09:26:28'),
(255, 11, 5, 'Jaipur-Pushkar Driver', 'This day after breakfast you drive to next holy city Pushkar, arrived in Pushkar and check-in the hotel, in evening you enjoy the Pushkar city and night stay in Pushkar.', NULL, NULL, NULL, 0, '2025-12-31 09:26:29'),
(256, 11, 6, 'Pushkar-Udaipur Drive', 'Pickup from hotel and drive to Lake City Udaipur, reach around in evening and some evening tour in the city- night stay in Udaipur.', NULL, NULL, NULL, 0, '2025-12-31 09:26:29'),
(257, 11, 7, 'Udaipur â€“Jodhpur Drive', 'This morning after breakfast check-out and start sight seen and visit fathe Sagar Lake and city palace, Jagdish temple and after lunch drive to next city Jodhpur â€“night stay in jodhpur.', NULL, NULL, NULL, 0, '2025-12-31 09:26:29'),
(258, 11, 8, 'Jodhpur-Jaislmer Drive', 'Breakfast and Check-out after visit Jodhpur fort and some more sight seen after lunch drive to Next city Jaislmer-night stay in Jaislmer.', NULL, NULL, NULL, 0, '2025-12-31 09:26:29'),
(259, 11, 9, 'Jaislmer-Kuri Tour', 'This morning after breakfast check-out and sight seen in the city, visit most famous attraction after drive to Kuri Desert. Arrive in desert and after start desert tour by camel and night stay in desert camp.', NULL, NULL, NULL, 0, '2025-12-31 09:26:29'),
(260, 11, 10, 'Kuri-Bikaner Drive', 'After breakfast you drive to next city Bikaner, check inn in the hotel and after in evening you visit Bikaner fort â€“Night stay in Bikaner.', NULL, NULL, NULL, 0, '2025-12-31 09:26:29'),
(261, 11, 11, 'Bikaner-Mandwa Drive', 'Drive to heritage village Mandwa and reach in evening-night stay in Mandwa.', NULL, NULL, NULL, 0, '2025-12-31 09:26:29'),
(262, 11, 12, 'Delhi-Mandwa Drive', 'Visit Mandwa walking tour and see the many old Havali, Houses after sight seen- Night stay in Delhi.', NULL, NULL, NULL, 0, '2025-12-31 09:26:29'),
(317, 15, 1, '02:30 AM: - Pickup from Delhi', 'You will be picked up from your hotel in Delhi or any other convenient location to begin your Taj Mahal tour. Drive to Agra (243.4 km) along the Yamuna Expressway.', NULL, NULL, NULL, 0, '2025-12-31 09:31:13'),
(318, 15, 2, '06:00 AM: -Arrival in Agra', 'Reach Agra and then get ready for your visit to the Taj Mahal after a quick pit stop for some tea and refreshments.', NULL, NULL, NULL, 0, '2025-12-31 09:31:13'),
(319, 15, 3, '06:30 AM: - Visit the Taj Mahal', 'This is the highlight of your sunrise Taj Mahal tour, as you enter the historic monument that was built between 1631 and 1648 in Agra by Mughal Emperor Shah Jahan as a tribute to his wife Mumtaz Mahal. The key highlight of your visit is that you can see the UNESCO World Heritage Site at sunrise as the rays fall on the ivory-white marble faï¿½ade and create an unforgettable experience.', NULL, NULL, NULL, 0, '2025-12-31 09:31:13'),
(320, 15, 4, '08:00 AM: - Breakfast Stop', 'After youï¿½re done exploring the Taj Mahal at sunrise, the next pit-stop will be at a local restaurant near the monument for a hearty local breakfast. Savor the rich flavors of Agra as you dig into a hearty meal here.', NULL, NULL, NULL, 0, '2025-12-31 09:31:13'),
(321, 15, 5, '09:00 AM: - Journey to the Agra Fort', 'The next destination on your sunrise Taj Mahal tour from Delhi is the Agra Fort. It was built in 1565 AD by Mughal Emperor Akbar. Explore the sprawling complex which includes the Musamman Burj where Shah Jahan was imprisoned and passed away. This fort was the main residence of the Emperor until the year 1638 when the capital shifted away to Delhi.', NULL, NULL, NULL, 0, '2025-12-31 09:31:13'),
(322, 15, 6, '10:30 AM: - Trip to the Local Bazaars', 'Enjoy a unique experience on your sunrise Taj Mahal tour as you stroll through Agraï¿½s famous local bazaars. Purchase handicrafts and souvenirs along with buying the famous Petha sweets to take back home from your trip. You may choose the Sadar Bazaar near the Agra Cantonment railway station and browse leather items, shoes, souvenirs, and street food here. Another option is the Tajganj Market, which is just near the Taj Mahal and offers souvenirs, handicrafts, marble items, and gifts.', NULL, NULL, NULL, 0, '2025-12-31 09:31:13'),
(323, 15, 7, '12 PM- Return to Delhi', 'Wind up your sunrise Taj Mahal tour and get set for the drive back to Delhi, bringing the curtains down on an awe-inspiring experience.', NULL, NULL, NULL, 0, '2025-12-31 09:31:14'),
(339, 14, 1, 'Arrival Delhi Airport', 'You will be met at the airport by one of our representatives upon arrival in Delhi, who will pick you up and give you a warm welcome. Check in at the hotel after the transfer. Enjoy a walking tour of Old Delhi local market once you\'ve had a chance to freshen yourself. We will visit Sis Ganj Sikh Temple, Jama Masjid and the spice market.\r\n \r\nOvernight stay in Delhi.', NULL, NULL, NULL, 0, '2025-12-31 09:34:29'),
(340, 14, 2, 'Delhi â€“ Agra', 'After breakfast, get driven to Agra. On arrival and check in, visit Agra Fort. Later, enjoy some Mughal cuisine lunch and then visit the lovely Taj Mahal. \r\n \r\nReturn back to the hotel after a long day for overnight stay.', NULL, NULL, NULL, 0, '2025-12-31 09:34:29'),
(341, 14, 3, 'Agra â€“ Jaipur', 'oday after breakfast we will drive to the â€˜Pink Cityâ€™- Jaipur. Enroute explore the ghost city of Fatehpur Sikri. On arrival, check into the hotel and relax. Later, head out to witness the majestic Amer Fort with a photo stop at Hawa Mahal and Jal Mahal.\r\n \r\nOvernight stay in Jaipur.', NULL, NULL, NULL, 0, '2025-12-31 09:34:29'),
(342, 14, 4, 'aipur â€“ Bikaner', 'oday after breakfast we will have another exciting journey towards Bikaner. After arrival and check in, explore the Junagarh Fort and Karni Mata Temple in Deshnok. \r\n \r\nReturn back to the hotel for overnight stay.', NULL, NULL, NULL, 0, '2025-12-31 09:34:29'),
(343, 14, 5, 'Bikaner â€“ Jaisalmer', 'After having breakfast we will head off to the golden sand city of Jaisalmer. Once checked in, visit Bada Bagh at sunset. Rest of the day at leisure.\r\n \r\nOvernight stay in Jaisalmer', NULL, NULL, NULL, 0, '2025-12-31 09:34:29'),
(344, 14, 6, 'Jaisalmer â€“ Khuri', 'Drive to Khuri village and check into the resort after breakfast. Enjoy a desert camel safari in Thar. Dinner served in the evening with a customary traditional dance programme.\r\n \r\nStay for the night in Khuri.', NULL, NULL, NULL, 0, '2025-12-31 09:34:29'),
(345, 14, 7, 'Khuri â€“ Jaisalmer', 'Get driven back to Jaisalmer after breakfast. After arrival and check in, visit the grand golden fort and revisit the history.\r\n \r\nAnother overnight stay in Jaisalmer.', NULL, NULL, NULL, 0, '2025-12-31 09:34:29'),
(346, 14, 8, 'Jaisalmer â€“ Jodhpur', 'Take a drive to Jodhpur after breakfast. When you get to Jodhpur, check into your hotel. Visit the Spice Market, Jaswant Thada, and Mehrangarh Fort afterwards.\r\n \r\nOvernight stay in Jodhpur.', NULL, NULL, NULL, 0, '2025-12-31 09:34:29'),
(347, 14, 9, 'Jodhpur', 'Enjoy a full day tour in Jodhpur after breakfast. Visit Umaid Bhawan Palace and enjoy a jeep safari to Bishnoi village and learn about local culture.\r\n \r\nReturn to the hotel for overnight stay.', NULL, NULL, NULL, 0, '2025-12-31 09:34:29'),
(348, 14, 10, 'Jodhpur â€“ Udaipur', 'This morning after breakfast, get driven to â€˜City of Lakesâ€™- Udaipur. After check in, relax and enjoy the rest of the time as you may please.\r\n \r\nOvernight stay in Udaipur.', NULL, NULL, NULL, 0, '2025-12-31 09:34:29'),
(349, 14, 11, 'Udaipur', 'Full day is dedicated to sightseeing after breakfast. Visit City Palace, Jagdish temple, Gem Museum, Sahelion ki Baari and enjoy a boat ride in Lake Pichola.\r\n \r\nStay for another night in Udaipur.', NULL, NULL, NULL, 0, '2025-12-31 09:34:30'),
(350, 14, 12, 'Udaipur â€“ Mumbai Flight', 'After breakfast, board a flight to Mumbai- the commercial capital of India. On arrival, check in and head out to seek blessings at Siddhi Vinayak temple and spend the rest of the time at Juhu Beach.\r\n \r\nOvernight stay in Mumbai', NULL, NULL, NULL, 0, '2025-12-31 09:34:30'),
(351, 14, 13, 'Mumbai', 'his morning a visit to Elephanta caves is planned. After breakfast, drive to witness the Gateway of India from where we will also embark on a ferry for Elephanta Island. Once you arrive, enjoy the scenic short hike and explore the ancient caves. Return to the mainland after exploration and spend the rest of the time at leisure.\r\n \r\nHotel stay in Mumbai.', NULL, NULL, NULL, 0, '2025-12-31 09:34:30'),
(352, 14, 14, 'Bollywood Tours', 'Enjoy breakfast and Visit Bollywood the movie shooting etc \r\n \r\nStay for another night in Mumbai.', NULL, NULL, NULL, 0, '2025-12-31 09:34:30'),
(353, 14, 15, 'Drop Mumbai Airport', 'After breakfast driver drop to Mumbai Airport', NULL, NULL, NULL, 0, '2025-12-31 09:34:30'),
(354, 17, 1, 'Arrive at Delhi', 'As per your flight schedule our represntative pickup you from Delhi Airport and transfer you to Delhi hotel. over night rest in Delhi hotel.', NULL, NULL, NULL, 0, '2025-12-31 09:35:36'),
(355, 17, 2, 'Delhi Guiding Tour', 'After Breakfast for full day side sightseeing like the Red Fort, Chandni Chowk Bazaar and Khari Baoli spice market on your way to visit Jama Masjid. One of the largest mosques in the world and the largest in India, it was built by Shah Jahan to dominate the city. Then, make your way to Raj Ghat, a memorial built to commemorate the site of Mahatma Gandhi\'s cremation. Also visit the UNESCO World Heritage-listed Qutub Minar, India\'s tallest minaret, made of red sandstone and marble and inscribed with verses from the Qur\'an.', NULL, NULL, NULL, 0, '2025-12-31 09:35:36'),
(356, 17, 3, 'Delhi - Jaipur. (260 km 6 hrs)', 'After breakfast depart from Delhi to Jaipur around 6 hour drive. evening check in Jaipur hotel.\r\nOver night rest in Jaipur hotel.', NULL, NULL, NULL, 0, '2025-12-31 09:35:36'),
(357, 17, 4, 'Jaipur', 'today proceeds to \'Pink City\' Jaipur. After Breakfast, Visit Amber - the ancient capital of the Rajput Empire reaching the fort on elephant back. It is a deserted palace surrounded by majestic ramparts & the magnificent public & private room\'s evidence the splendor of the rulers of 16th & 17th century Rajasthan. Also visit City Place, Janter Mantar and Hawa Mahal in evening leisure. Overnight at Hotel.', NULL, NULL, NULL, 0, '2025-12-31 09:35:36'),
(358, 17, 5, 'Jaipur:- Agra (200 Kms / 04 hrs)', 'After breakfast drive to Agra en-route visit Fatehpur Sikri. Later continue drive to Agra. Arrive and check in at Hotel. Akbarabad, as Agra was known during the Mughal era, is home to some of the most magnificent Mughal architectures. Situated on the banks of river Yamuna, the monumental beauty of Agra has inspired countless people around the world. This third largest city of the state of Uttar Pradesh is home to three UNESCO world heritage sites. Overnight at Hotel.', NULL, NULL, NULL, 0, '2025-12-31 09:35:36'),
(359, 17, 6, 'Agra - Varanasi', 'On day 06 of Delhi Agra Jaipur Varanasi Tour, Early morning at the time of sun rise visit the Taj mahal (best time to visit the Taj Mahal). after the Taj mahal back to the hotel for breakfast and visit the Agra Fort (world heritage site, baby Taj. Sikandra (tomb of Akbar). late evening catch the night train from Agra to Varanasi.', NULL, NULL, NULL, 0, '2025-12-31 09:35:36'),
(360, 17, 7, 'Varanasi Arrival & City Tour', 'Arrive at Varanasi station. Meet and transfer to hotel for check in. Dating back to more than 3000 years, Varanasi is said to be the oldest city of the world. There are temples at every few steps here Hinduism it is believed that those who breathe their last in this city attain nirvana and get an instant gateway to liberation from the cycle of births and re-births. After Lunch proceed for tour planned for second half of the day We begin the tour of the city with the famous Banaras Hindu University.', NULL, NULL, NULL, 0, '2025-12-31 09:35:36'),
(361, 17, 8, 'Varanasi City Tour', 'Early morning proceed to morning Cruise on Ganges. The \'Ghats of Ganga\' dotted with temples or more than 100 ghats (banks) alongside the Ganges in Varanasi. The best way to cover them all is acruise. A morning cruise on the Ganges presents a very beautiful view of the ghats bathed in crimson light. After Lunch half day excursion to Sarnath. Evening explore the city. A walk through old Varanasi will be memorable experience.', NULL, NULL, NULL, 0, '2025-12-31 09:35:36'),
(362, 17, 9, 'Varanasi Departure', 'Morning catch the train or flight from Varanasi to Delhi. driver pickup you from Delhi Train station/Airport. If you left some sight in Delhi you can visit today. evening driver transfer you Airport to catch your Early morning flight from Delhi. Tour to Varanasi ends.', NULL, NULL, NULL, 0, '2025-12-31 09:35:36'),
(385, 13, 1, 'Delhi Airport Arrival', 'Meet and assist by our representative upon your arrival at the airport and drive to hotel, Rest after Delhi Private Trip-\r\n\r\nRed Fort-Old Delhi-Rajghat-India Gate-Humyun tomb-lotus temple-Qutab miner', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(386, 13, 2, 'Delhi â€“Bikaner', 'After breakfast in drive to Bikaner via Mandawa, visit Mandawa and see the local village life-stay in Bikaner', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(387, 13, 3, 'Bikaner Jaislmer', 'After breakfast drive to Jaislmer city is one of India most beautiful, colorful & fascinating place. Arrive Jaislmer check in at Hotel. Stay Jaislmer', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(388, 13, 4, 'Jaislmer Sightseen', 'After a relaxed breakfast proceed for full day sightseeing tour of The Golden City â€“ Jaislmer. It is in the heart of the Great Indian Desert. Its temple, fort and palaces are all built of yellow stone. The city is a mass of intricately carved buildings, facades and elaborate balconies. visit the Jaislmer fort-oldest living fort , Desert Camel ride etc-Stay Jaislmer', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(389, 13, 5, 'Jaislmer Jodhpur', 'After breakfast drive to Jodhpur the Gateway to the Thar Desert. Arrive Jodhpur check in at hotel. After visit Jaswant Thada and Meharangarh-Stay Jodhpur', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(390, 13, 6, 'Jodhpur Ranakpur', 'After breakfast drive to Ranakpur visit world famous 500 years old incredible jain temple with 1444 pillar, all pillar are different then each other. After jain temple visit to natural lake with very nice view of sun set-Stay Ranakpur', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(391, 13, 7, 'Ranakpur Udaipur', 'After Ranakpur drive to Udaipur â€“the city of the lakes , arrive and stay in Udaipu', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(392, 13, 8, 'Udaipur Sightseen', 'This morning after breakfast visit Udaipur and see the nice lakes and life etc-Stay in Udaipur', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(393, 13, 9, 'Udaipur Pushkar', 'After breakfast drive to Pushkar edge of the desert lies the tiny tranquil town of Pushkar along the bank of the picturesque Pushkar Lake. This is an important pilgrimage spot for the Hindus, which has the only temple of Lord Brahma in the country and one of the few in the world. Stay Pushkar', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(394, 13, 10, 'Pushkar Jaipur', 'After breakfast proceed to Jaipur the capital of Rajasthan, arrive Jaipur and check-inn and after the city tour.', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(395, 13, 11, 'Jaipur Sightseen', 'Drive  to the Hawa Mahal, Jantar Mantar, City Palace , wind Palce amber fort  and the in-house Museum. Walk along the bazaars of the â€œPink Cityâ€ and enjoy the colorful life of the city. You will be amazed at the sight of the men and the women folk dressed in the most colorful way, especially ladies adorned with heavy silver jewelry-Stay Jaipur', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(396, 13, 12, 'Jaipur Ranthambore-National Game Park', 'After breakfast drive to Ranthambore national park, arrive afternoon and relex-stay Ranthambore', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(397, 13, 13, 'Ranthambore-National Game Park Safaris', 'This morning visit game park 6:00 am â€“11:00 am Jeep safari and 2nd safari 14:00 pm to 18:00 Pm â€“\r\n\r\nHere you have chance to see many animal and Indians tigers-night stay in Ranthambore', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(398, 13, 14, 'Ranthambore-Agra via fatepur sikri', 'After breakfast check out from the hotel and drive to city of marble Agra via fatepursikri-Stay Agra', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(399, 13, 15, 'Tajmahal Visit and drive to Khajuraho', 'Visit Tajmahal morning (sunrise) after breakfast and drive to Kamasutra city Khajuraho-Stay Khajuraho.', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(400, 13, 16, 'Khajuraho Tour', 'After breakfast in hotel proceed to explore beautiful town Khajuraho. Khajuraho known for its temples built from 950 A.D to 1150 AD, by the Candela Dynasty. The group of thirty temples urahois an example of Indian architectural excellence The Western group of temples are best known for their erotic sculptures. Stay Khajuraho', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(401, 13, 17, 'Khajuraho Varanasi Flight', 'Driver drop you Khajuraho airport and flight to Varanasi , pickup Varanasi airport and move to the hotel\r\n\r\n After we take you to banks of the river Ganges where we board a boat to see the morning ablutions of the Hindus from the security of our boat.See the Kashi Vishwanath temple and the Gyanvyapi kund and the mosque attached to it. Also visit the Benares Hindu University the largest residential university in India with more than 3000 residential students', NULL, NULL, NULL, 0, '2025-12-31 10:54:14'),
(402, 12, 1, 'Sight Seeing of Delhi', 'Red-FortThis morning is at leisure. Enjoy a whole daylong extravaganza of visiting New Delhi and Old Delhi. Enjoy the delicious cuisine and visit magnificent monuments like Qutab Miner, Red Fort, India Gate, Jama Masjid, Rajghat Night halt in Delhi.', NULL, NULL, NULL, 0, '2025-12-31 10:54:33'),
(403, 12, 2, 'Delhi â€“Agra Drive', 'Pickup from hotel and drive to Agra, check-in in the hotel and refresh after visit Agra fort & Taj Mahal and some local area walking tour â€“Night stay in Agra.', NULL, NULL, NULL, 0, '2025-12-31 10:54:33'),
(404, 12, 3, 'Agra-Fathepur Sikri-Jaipur Drive:', 'Pick from hotel and drive to Jaipur en-route visit world heritage site fathepur sikri and after continue drive to Jaipur-night stay in Jaipur.', NULL, NULL, NULL, 0, '2025-12-31 10:54:33'),
(405, 12, 4, 'Jaipur Tour', 'Hawa-Mahalthis morning after breakfast you visit Amber fort-Water palace-city palace-wind palace-monkey temple and some walking in bazaar-night stay in Jaipur.', NULL, NULL, NULL, 0, '2025-12-31 10:54:33'),
(406, 12, 5, 'Jaipur-Udaipur Drive', 'Pickup from hotel and drive to Lake City Udaipur, reach around in evening and some evening tour in the city- night stay in Udaipur.', NULL, NULL, NULL, 0, '2025-12-31 10:54:33'),
(407, 12, 6, 'Udaipur â€“Jodhpur Drive', 'This morning after breakfast check-out and start sight seen and visit fate Sagar Lake and city palace, Jagdish temple and after lunch drive to next city Jodhpur â€“night stay in jodhpur.', NULL, NULL, NULL, 0, '2025-12-31 10:54:33'),
(408, 12, 7, 'Jodhpur-Jaislmer Drive', 'Breakfast and Check-out after visit Jodhpur fort and some more sight seen after lunch drive to Next city Jaislmer-night stay in Jaislmer.', NULL, NULL, NULL, 0, '2025-12-31 10:54:33'),
(409, 12, 8, 'Jaislmer-Kuri Tour', 'This morning after breakfast check-out and sight seen in the city ,visit most famous attraction after drive to Kuri Desert. Arrive in desert and after start desert tour by camel and night stay in desert camp.', NULL, NULL, NULL, 0, '2025-12-31 10:54:33'),
(410, 12, 9, 'Kuri-Jaislmer-Mandwa-Drive', 'Drive to heritage village Mandwa and reach in evening-night stay in Mandwa.', NULL, NULL, NULL, 0, '2025-12-31 10:54:33'),
(411, 12, 10, 'visit Mandwa', 'Walking tour and see the many old Havali, Houses after sight seen drive to New Delhi and night stay in Delhi.', NULL, NULL, NULL, 0, '2025-12-31 10:54:33'),
(412, 16, 1, '07:30', 'Our car will pick up you from hotel in Delhi and transfer to H Nizamuddin Railway station to board superfast air conditioned train to Agra. Our chauffer will assist you at railway station. We will E-mail you an E-ticket after booking confirmation.', NULL, NULL, NULL, 0, '2025-12-31 10:54:43'),
(413, 16, 2, '08:10', 'Gatimaan Express ( Train No 12050 ) fully air conditioned train departs H Nizamuddin Railway Station for Agra Cantt railway station\r\n\r\n1) Breakfast included in Train fare\r\n2)Distance Travelled between Delhi & Agra by train in 1 : 40 Hrs.', NULL, NULL, NULL, 0, '2025-12-31 10:54:43'),
(414, 16, 3, '09:50', 'Arriving Agra Cantt railway station. Your Tour Guide & Driver will receive you from Railway Station in Agra. Tour Start with drive to Taj Mahal by air conditioned car.', NULL, NULL, NULL, 0, '2025-12-31 10:54:43'),
(415, 16, 4, '10:15', 'Taj Mahal is a cynosure of India in global tourism arena. The monument, constructed in 16th Century hold a grand history of true love and affection of 5th Mughal King Shah Jahan towards his beloved wife Mumtaj Mahal. This edifice is finest example of Indo Islamic architecture style situated on right bank of river Yamuna.', NULL, NULL, NULL, 0, '2025-12-31 10:54:43'),
(416, 16, 5, '12:30', 'AGRA FORT After Taj Mahal drive to Agra Fort.The Fort made of red sand stone depicting glorious rule of the mighty Mughals with their lavish lifestyle. It was built in 15th century by third Mughal king Akbar. Encircled with two huge walls, this Fort has some impressive buildings like Jasmine Tower ,Khas Mahal , Diwan I Am , Diwan I Khas etc.', NULL, NULL, NULL, 0, '2025-12-31 10:54:43'),
(417, 16, 6, '14:00', 'LUNCH BREAK You reserve right to recommend restaurant of your choice in Agra on direct payment otherwise your tour guide will take you to clean & hygenic AC Restaurant .', NULL, NULL, NULL, 0, '2025-12-31 10:54:43'),
(418, 16, 7, '15:00', 'ITMAD - UD - DAULAH ( BABY TAJ ) After Lunch proceed to Itmad-Ud-Daulah tomb. Due to some of its resemblance with Taj Mahal.This edifice is popularly known as \'\'Baby Taj\'\'.This tomb is elaborately carved with pure marble & exhibit Indo Islamic architecture style. Empress Noor Jahan ordered this tomb in memory of her father, Mirza Ghiyas Beg in 1622.', NULL, NULL, NULL, 0, '2025-12-31 10:54:43'),
(419, 16, 8, '16:30', 'OPTIONAL After Baby Taj you can visit handicraft gallery of Marble inlay souvenirs in Agra city. Free to explore Agra City known for exporting marble inlay handicraft.', NULL, NULL, NULL, 0, '2025-12-31 10:54:44'),
(420, 16, 9, '17:00', 'Transfer to Railway Station to board train to Delhi..', NULL, NULL, NULL, 0, '2025-12-31 10:54:44'),
(421, 16, 10, '17:50', 'Gatimaan Express( Train No 12049 ) departs for Delhi.. Dinner served in Train.', NULL, NULL, NULL, 0, '2025-12-31 10:54:44'),
(422, 16, 11, '19:30', 'Arriving H Nizamuddin Railway Station. Our cab will transfer you back to your Hotel in Delhi. Tour End', NULL, NULL, NULL, 0, '2025-12-31 10:54:44');

-- --------------------------------------------------------

--
-- Table structure for table `package_pricing`
--

CREATE TABLE `package_pricing` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `pricing_type` enum('seasonal','group_size','accommodation') NOT NULL,
  `season_name` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `min_persons` int(11) DEFAULT NULL,
  `max_persons` int(11) DEFAULT NULL,
  `accommodation_type` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `title` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_group` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `updated_at`) VALUES
(1, 'site_name', 'tajmahaldaytour', 'site_info', '2025-12-31 08:45:42'),
(2, 'site_tagline', 'Your Trusted Travel Partner in India', 'site_info', '2025-12-31 08:45:42'),
(3, 'site_email', 'info@tajmahaldaytour.com', 'site_info', '2025-12-31 08:45:42'),
(4, 'site_phone', '+91-9876543210', 'site_info', '2025-12-31 08:45:42'),
(5, 'site_address', 'Delhi, India', 'site_info', '2025-12-31 08:45:42'),
(6, 'meta_title', 'tajmahaldaytour - Private Tours & Car Rentals', 'meta', '2025-12-31 08:45:42'),
(7, 'meta_description', 'Experience India with professional drivers and private tours. Book Golden Triangle, Rajasthan, Himachal tours.', 'meta', '2025-12-31 08:45:42'),
(8, 'meta_keywords', 'india tours, car rental, private driver, golden triangle, rajasthan tour', 'meta', '2025-12-31 08:45:42'),
(9, 'facebook_url', 'https://facebook.com/', 'social', '2025-12-31 08:45:42'),
(10, 'instagram_url', 'https://instagram.com/', 'social', '2025-12-31 08:45:42'),
(11, 'twitter_url', 'https://twitter.com/', 'social', '2025-12-31 08:45:42'),
(12, 'youtube_url', 'https://youtube.com/', 'social', '2025-12-31 08:45:42'),
(13, 'contact_email', 'contact@tajmahaldaytour.com', 'contact', '2025-12-31 08:45:42'),
(14, 'support_email', 'support@tajmahaldaytour.com', 'contact', '2025-12-31 08:45:42'),
(15, 'whatsapp_number', '+91-9876543210', 'contact', '2025-12-31 08:45:42'),
(16, 'office_hours', 'Mon-Sat: 9:00 AM - 6:00 PM', 'contact', '2025-12-31 08:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `tour_packages`
--

CREATE TABLE `tour_packages` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `duration_days` int(11) NOT NULL,
  `duration_nights` int(11) NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `price_type` enum('per_person','per_group') DEFAULT 'per_person',
  `featured_image` varchar(255) DEFAULT NULL,
  `gallery_images` text DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `max_group_size` int(11) DEFAULT 20,
  `min_age` int(11) DEFAULT 0,
  `difficulty_level` enum('easy','moderate','challenging','difficult') DEFAULT 'easy',
  `inclusions` text DEFAULT NULL,
  `exclusions` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_bestseller` tinyint(1) DEFAULT 0,
  `display_order` int(11) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_packages`
--

INSERT INTO `tour_packages` (`id`, `category_id`, `title`, `slug`, `short_description`, `description`, `duration_days`, `duration_nights`, `base_price`, `discounted_price`, `price_type`, `featured_image`, `gallery_images`, `video_url`, `max_group_size`, `min_age`, `difficulty_level`, `inclusions`, `exclusions`, `meta_title`, `meta_description`, `meta_keywords`, `is_active`, `is_featured`, `is_bestseller`, `display_order`, `views`, `created_at`, `updated_at`) VALUES
(1, 1, 'Golden Triangle with Pushkar Tour', 'golden-triangle-with-pushkar-tour', 'Experience the rich heritage of India’s Golden Triangle and the cultural charm of Pushkar in one captivating tour — ideal for couples, families, and culture seekers.', 'Embark on an unforgettable journey through India’s iconic Golden Triangle — a fascinating loop of historical and cultural landmarks that weave together the past and present in a rich tapestry of experiences. Starting in the vibrant capital of Delhi, you\'ll explore the majestic monuments and bustling markets, where old-world charm blends seamlessly with modern energy. From there, journey to Agra, home to the breathtaking Taj Mahal, one of the world’s most recognized symbols of love and an architectural marvel. In Jaipur, the “Pink City,” you’ll be immersed in royal palaces, opulent forts, and colorful bazaars, each telling the story of Rajasthan’s rich history and heritage.\r\n\r\nBut the adventure doesn’t end there — venture into the serene desert town of Pushkar, where the mystical allure of its sacred lake and temples beckon. Pushkar is an oasis of calm amidst the vast Thar Desert, famous for its annual camel fair and its deep spiritual significance. The town offers a unique blend of culture, religion, and natural beauty, with winding streets lined with vibrant bazaars, ancient ghats, and peaceful temples. Here, you\'ll have the chance to experience the soul-stirring atmosphere of one of India’s oldest pilgrimage sites, where tradition and spirituality come together in perfect harmony.\r\n\r\nThis carefully curated tour is designed for couples, families, and culture seekers alike. Whether you\'re a history enthusiast eager to explore India’s past, a family looking for a memorable adventure, or a couple in search of romance and tranquility, this journey through the Golden Triangle and Pushkar offers something for everyone. Experience the diverse colors, sounds, and flavors of India, where each moment promises to be a treasure trove of memories.', 7, 6, 0.00, NULL, 'per_person', '6954d4cde5ea6_1767167181.jpg', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Golden Triangle with Pushkar Tour', 'Experience the rich heritage of India’s Golden Triangle and the cultural charm of Pushkar in one captivating tour — ideal for couples, families, and culture seekers.\' eksa ek long discription dena', '', 1, 0, 0, 0, 0, '2025-12-31 07:46:21', '2025-12-31 07:46:21'),
(2, 2, 'Delhi Shimla Manali Delhi Tour Package 6 Days', 'delhi-shimla-manali-delhi-tour-package-6-days', '', 'Experience the beauty of Himachal Pradesh with our Manali Shimla Tour. Explore the snow-capped mountains, lush valleys, and charming colonial architecture. Begin your journey in Shimla, known for its scenic Mall Road, Jakhoo Temple, and historic landmarks. Continue to Manali, where you can visit Solang Valley, Rohtang Pass, and Hadimba Temple, and enjoy thrilling adventures like paragliding and river rafting. Perfect for couples, families, and nature lovers, this tour offers a perfect blend of relaxation and excitement amidst the serene Himalayan landscapes. Book now for an unforgettable mountain getaway.', 5, 6, 0.00, NULL, 'per_person', '6954e8e097266_1767172320.jpg', NULL, NULL, 20, 0, 'easy', '', '', 'Delhi Shimla Manali Delhi Tour Package 6 Days', '', '', 1, 1, 0, 0, 0, '2025-12-31 08:52:23', '2025-12-31 10:54:06'),
(4, 2, 'Delhi Shimla  Delhi  Tour Package 5 Days', 'delhi-shimla-delhi-tour-package-5-days', '', 'Experience the beauty of the Himalayas with our 5-day Shimla Tour. Begin your journey from Delhi and enjoy a scenic drive to Shimla, the Queen of Hills. Explore popular attractions like The Ridge, Mall Road, Jakhoo Temple, Kufri, and Chail. Breathe in the fresh mountain air, take in stunning views of snow-capped peaks, and relax in peaceful surroundings. Perfect for families, couples, and nature lovers, this tour offers a blend of sightseeing, leisure, and adventure. Create unforgettable memories with this charming escape to Shimlaï¿½s serene landscapes.', 5, 4, 0.00, NULL, 'per_person', '6954ea2e539d0_1767172654.jpg', NULL, NULL, 20, 0, 'easy', '', '', 'Delhi Shimla  Delhi  Tour Package 5 Days', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:49', '2025-12-31 09:18:30'),
(5, 2, 'Delhi Manali Delhi Tour Package 5 Days', 'delhi-manali-delhi-tour-package-5-days', '', 'Embark on a mesmerizing 5-day Manali tour and experience the breathtaking beauty of Himachal Pradesh. Begin your journey from Delhi to Manali, driving through scenic valleys and mountains. Enjoy local sightseeing at Hadimba Devi Temple, Vashisht Kund, and Manu Temple. Experience the thrill of adventure at Solang Valley with activities like paragliding and skiing. Explore the enchanting Rohtang Pass (subject to availability) and capture the snow-covered charm. Indulge in shopping at the vibrant Mall Road and enjoy cozy evenings in the hills. A perfect getaway for nature lovers and thrill-seekers.', 5, 4, 0.00, NULL, 'per_person', '6954eacd5c217_1767172813.jpg', NULL, NULL, 20, 0, 'easy', '', '', 'Delhi Manali Delhi Tour Package 5 Days', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:50', '2025-12-31 09:20:13'),
(6, 5, 'Chardham Yatra Package from Delhi', 'chardham-yatra-package-from-delhi', '', 'Chardham Yatra Tours is a sacred pilgrimage journey covering the four holy shrines of Yamunotri, Gangotri, Kedarnath, and Badrinath nestled in the majestic Himalayas. This spiritually enriching tour offers a perfect blend of devotion, adventure, and natural beauty. Pilgrims embark on a divine path through serene rivers, ancient temples, and breathtaking landscapes. From the holy Ganga Aarti in Haridwar to the tranquil vibes of Badrinath and Kedarnath, every step of this journey brings peace to the soul. Chardham Yatra is not just a tripï¿½it\'s a transformative experience that renews your spirit and deepens your connection with the divine.', 12, 11, 0.00, NULL, 'per_person', '6954ea754355e_1767172725.jpg', NULL, NULL, 20, 0, 'easy', '', '', 'Chardham Yatra Package from Delhi', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:50', '2025-12-31 09:18:55'),
(7, 5, 'Varanasi Prayagraj Ayodhya Package', 'varanasi-prayagraj-ayodhya-package', '', 'Explore the spiritual heart of India with our Varanasi, Prayagraj, and Ayodhya tour package. Begin your journey in Varanasi, the city of temples and ghats, where you can witness the mesmerizing Ganga Aarti. Next, visit Prayagraj, known for the sacred Triveni Sangam, where the Ganga, Yamuna, and Saraswati rivers meet. Conclude your pilgrimage in Ayodhya, the birthplace of Lord Rama, and visit the grand Ram Janmabhoomi temple. This thoughtfully curated package offers comfortable travel, guided tours, and spiritual experiences that connect you to Indiaï¿½s divine heritage. Book now for a soulful journey through these sacred cities.', 6, 5, 0.00, NULL, 'per_person', '6954ec05dedb5_1767173125.webp', NULL, NULL, 20, 0, 'easy', '', '', 'Varanasi Prayagraj Ayodhya Package', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:51', '2025-12-31 09:25:25'),
(8, 5, 'Delhi Haridwer Rishikesh Delhi 5 Days Package', 'delhi-haridwer-rishikesh-delhi-5-days-package', '', 'According to astrologers, the â€˜Kumbh Fairâ€™ takes place when the planet Jupiter enters Aquarius and the Sun enters Aries. According to mythology, â€˜Devasâ€™ (Gods) and â€˜Asurasâ€™ (Demons) churned the ocean to obtain Nectar and when the coveted â€˜Kumbhaâ€™ (pitcher) of Nectar (Amrita) which gave immortality was obtained from the depths of ocean, one of the â€˜Devasâ€™ whisked away the â€˜Kumbhaâ€™ from the â€˜Asurasâ€™ and evading from the â€˜Asurasâ€™, stopped at four places viz. Haridwar, Allahabad (Prayag), Nasik and Ujjain before he finally arrived into the safety of heaven. A few drops of Nectar are supposed to have spilled over on the water at these four places and sages, saints and pilgrims started periodically to flock to each of these â€˜Tirthasâ€™ to celebrate the divine event. In fact , it is a unique event that blends religious and social features alike', 5, 4, 0.00, NULL, 'per_person', '6954ebb0f3692_1767173040.jpg', NULL, NULL, 20, 0, 'easy', '', '', 'Delhi Haridwer Rishikesh Delhi 5 Days Package', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:51', '2025-12-31 09:24:01'),
(9, 5, 'Buddha Tours Package India', 'buddha-tours-package-india', '', 'Buddhism is based on the wisdom of Siddhartha Gautam borne like a prince of kapilavastu situated in Lumbini, Nepal. Gautam Buddha attained illumination sitting under the tree of Pipal.\r\n\r\nThis Buddhist tour will get you to the lots of significant Buddhist sites of India and we submit this tour the same as footsteps of Buddha. The major sites to be visiting through this tour are Bodhgaya, Patna, Kushinagar, Balrampur and Lumbini', 11, 10, 0.00, NULL, 'per_person', '6954eb6a807c4_1767172970.webp', NULL, NULL, 20, 0, 'easy', '', '', 'Buddha Tours Package India', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:51', '2025-12-31 09:22:50'),
(10, 3, '15 Days Rajasthan Tour Package', '15-days-rajasthan-tour-package', '', 'Embark on an unforgettable journey through the majestic land of Rajasthan with our 15 Days Rajasthan Tour Package. Explore the vibrant culture, royal palaces, historic forts, desert landscapes, and colorful markets across the state. This tour is a perfect blend of heritage, adventure, and relaxation, covering iconic cities such as Jaipur, Udaipur, Jodhpur, Jaisalmer, Bikaner, and more. Whether you\'re a history enthusiast, culture lover, or photography buff, this package offers the best of Rajasthan in two weeks.', 15, 14, 0.00, NULL, 'per_person', '6954eb293bb5f_1767172905.jpg', NULL, NULL, 20, 0, 'easy', '', '', '15 Days Rajasthan Tour Package', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:51', '2025-12-31 09:21:45'),
(11, 3, '12 Days Rajasthan  Private Tours', '12-days-rajasthan-private-tours', '', 'Uncover the royal legacy of Rajasthan in 12 unforgettable days filled with historic forts, royal palaces, desert adventures, and spiritual journeys. This thoughtfully curated tour offers the perfect blend of cultural richness, scenic beauty, and local experiences across iconic destinations like Jaipur, Udaipur, Jodhpur, Jaisalmer, and more. Ideal for families, couples, and culture lovers, this journey captures the true spirit of Rajasthan in less than two weeks.', 12, 11, 0.00, NULL, 'per_person', '6954ec44292b1_1767173188.jpg', NULL, NULL, 20, 0, 'easy', '', '', '12 Days Rajasthan  Private Tours', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:52', '2025-12-31 09:26:28'),
(12, 3, '10 Days Rajasthan Private Tours', '10-days-rajasthan-private-tours', '', 'Experience the majestic charm of Rajasthan in just 10 days with this carefully crafted tour that takes you through the land of kings, forts, and desert wonders. From the royal palaces of Jaipur to the golden sands of Jaisalmer, the blue houses of Jodhpur, and the serene lakes of Udaipur â€” every city tells a tale of its glorious past and vibrant culture. Ideal for those looking to explore the highlights of Rajasthan within a limited time, this tour offers history, heritage, adventure, and unforgettable local experiences.', 10, 9, 0.00, NULL, 'per_person', '6954ecbeb420a_1767173310.jpg', NULL, NULL, 20, 0, 'easy', '', '', '10 Days Rajasthan Private Tours', '', '', 1, 1, 0, 0, 0, '2025-12-31 08:53:53', '2025-12-31 10:54:33'),
(13, 3, '15 to 18 Days-Rajasthan-Varanasi -Tajmahal Tour Package', '15-to-18-days-rajasthan-varanasi-tajmahal-tour-package', '', 'Places Covered :Delhi â€“ Bikaner â€“ Jaisalmer â€“ Jodhpur â€“ Ranakpur â€“ Udaipur â€“ Pushkar â€“ Jaipur â€“ Agra  â€“ Khajuraho â€“ Varanasi â€“ Delhi', 18, 0, 0.00, NULL, 'per_person', '6954ec7c55eda_1767173244.jpg', NULL, NULL, 20, 0, 'easy', '', '', '15 to 18 Days-Rajasthan-Varanasi -Tajmahal Tour Package', '', '', 1, 1, 0, 0, 0, '2025-12-31 08:53:53', '2025-12-31 10:54:14'),
(14, 3, 'Delhi Agra Rajasthan & Mumbai Tours', 'delhi-agra-rajasthan-mumbai-tours', '', 'A tour combining Delhi, Agra, Rajasthan (Jaipur, Jaisalmer, Udaipur), and Mumbai offers a diverse experience of India\'s history, culture, and modernity. You can explore historical sites like the Taj Mahal and Red Fort, enjoy vibrant bazaars and palaces, and experience the energy of Mumbai\'s urban landscape', 20, 0, 0.00, NULL, 'per_person', '6954ee259746a_1767173669.jpg', NULL, NULL, 20, 0, 'easy', '', '', 'Delhi Agra Rajasthan & Mumbai Tours', '', '', 1, 0, 0, 0, 1, '2025-12-31 08:53:54', '2025-12-31 10:50:54'),
(15, 4, 'Tajmahal Sunrise Tours', 'tajmahal-sunrise-tours', '', 'The Taj Mahal Sunrise Tour is a magical journey that lets you witness the iconic monument in the soft glow of early morning light. As the sun rises, the white marble of the Taj Mahal shimmers with golden hues, offering a serene and unforgettable view. This early visit allows you to avoid large crowds and enjoy the peaceful ambiance of one of the world\'s most beautiful architectural wonders.', 1, 0, 0.00, NULL, 'per_person', '6954ed614402f_1767173473.jpg', NULL, NULL, 20, 0, 'easy', '', '', 'Tajmahal Sunrise Tours', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:54', '2025-12-31 09:31:13'),
(16, 4, 'Tajamhal Tour by Train', 'tajamhal-tour-by-train', '', 'The Taj Mahal Tour by Train via Gatimaan Express offers a fast, comfortable, and convenient way to explore the beauty of Agra in a single day. Departing from Delhi, the Gatimaan Express is India\'s fastest train, reaching Agra in just 100 minutes. Upon arrival, you\'ll be taken to the majestic Taj Mahal to witness its stunning architecture and learn about its rich history. The tour often includes visits to other iconic sites such as Agra Fort and Mehtab Bagh. With guided support, smooth transfers, and same-day return, this tour is perfect for travelers seeking a hassle-free and memorable experience.', 1, 0, 0.00, NULL, 'per_person', '6954eeb473975_1767173812.jpg', NULL, NULL, 20, 0, 'easy', '', '', 'Tajamhal Tour by Train', '', '', 1, 1, 0, 0, 0, '2025-12-31 08:53:55', '2025-12-31 10:54:43'),
(17, 4, 'Tajmahal Tour with Varanasi', 'tajmahal-tour-with-varanasi', '', 'The Taj Mahal Tour with Varanasi combines the grandeur of Mughal architecture with the spiritual essence of India. Begin your journey in Agra with a visit to the iconic Taj Mahal, a timeless symbol of love and architectural brilliance. Then travel to Varanasi, one of the world\'s oldest living cities, to experience the sacred Ganga Aarti, explore ancient temples, and take a serene boat ride on the Ganges. This tour offers a perfect blend of history, culture, and spirituality, giving you an unforgettable glimpse into India\'s rich and diverse heritage.', 9, 8, 0.00, NULL, 'per_person', '6954ee676fcb8_1767173735.jpg', NULL, NULL, 20, 0, 'easy', '', '', 'Tajmahal Tour with Varanasi', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:55', '2025-12-31 09:35:35'),
(18, 1, 'Tajmahal with Jaipur  Tour', 'tajmahal-with-jaipur-tour', NULL, 'Agra Jaipur a famous destinations in north India- Explore Tajmahal Agra Fort  Amber fort City Place water palace wind place and monkey temple ', 3, 2, 0.00, NULL, 'per_person', 'assets/img/tajmahal/tajmahal_1767075697_1905.webp', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Tajmahal with Jaipur  Tour', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(19, 1, 'Event Organisers For Jagran', 'event-organisers-for-jagran', NULL, 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/eventorg.webp', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Event Organisers For Jagran', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(20, 1, 'Mata Ki Chowki Organisers', 'mata-ki-chowki-organisers', NULL, 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/matakichowki.webp', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Mata Ki Chowki Organisers', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(21, 1, 'Bhajan Singers', 'bhajan-singers', NULL, 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/bhajan-singer.webp', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Bhajan Singers', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(22, 1, 'Sundar Kand Paath', 'sundar-kand-paath', NULL, 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/ban6.jpeg', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Sundar Kand Paath', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(23, 1, 'Khatu Shyam Bhajan Sandhya And Singer', 'khatu-shyam-bhajan-sandhya-and-singer', NULL, 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/khatu-shyam.jpeg', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Khatu Shyam Bhajan Sandhya And Singer', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(24, 1, 'Event Organisers For Navratri', 'event-organisers-for-navratri', NULL, 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/navratri-event.webp', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Event Organisers For Navratri', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(25, 1, 'Sai Bhajan Sandhya Organisers', 'sai-bhajan-sandhya-organisers', NULL, 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/sai-sandhya.webp', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Sai Bhajan Sandhya Organisers', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(26, 1, 'Nainital Tour', 'nainital-tour', NULL, 'Explore the charming hill station of Nainital, known for its scenic beauty, Naini Lake, and surrounding hills.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/nainital.webp', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Nainital Tour', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(27, 1, 'Mussoorie & Dhanaulti PKG', 'mussoorie-dhanaulti-pkg', NULL, 'Discover the beauty of Mussoorie and Dhanaulti, offering breathtaking views, cool weather, and a peaceful escape.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/mussorie-dhanaulti.jpg', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Mussoorie & Dhanaulti PKG', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(28, 1, 'Rishikesh Rafting Trip', 'rishikesh-rafting-trip', NULL, 'Experience the thrill of rafting on the Ganges in Rishikesh, amidst the scenic backdrop of the Himalayan foothills.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/Rishikesh-rafting.avif', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Rishikesh Rafting Trip', '', '', 1, 0, 0, 0, 1, '2025-12-31 08:53:56', '2025-12-31 09:56:00'),
(29, 1, 'Munshyari Tour PKG', 'munshyari-tour-pkg', NULL, 'Immerse yourself in the peaceful surroundings and natural beauty of Munshyari, a hidden gem in Uttarakhand.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/Munshyari.jpg', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Munshyari Tour PKG', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(30, 1, 'Vaishno Devi & Patnitop Tour PKG', 'vaishno-devi-patnitop-tour-pkg', NULL, 'Embark on a divine journey to Vaishno Devi and Patnitop, experiencing both spiritual solace and scenic landscapes.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/Vaishno-Devi.webp', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Vaishno Devi & Patnitop Tour PKG', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(31, 1, 'Amritsar Tour PKG', 'amritsar-tour-pkg', NULL, 'Discover the spiritual beauty of Amritsar, home to the sacred Golden Temple and vibrant culture.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/golden-temple-amritsar.webp', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Amritsar Tour PKG', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(32, 1, 'Mathura & Agra Tour PKG', 'mathura-agra-tour-pkg', NULL, 'Visit the birthplace of Lord Krishna in Mathura and explore the majestic Taj Mahal in Agra.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/mathura-agra.jpg', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Mathura & Agra Tour PKG', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(33, 1, 'Ayodhya & Varanasi Tour PKG', 'ayodhya-varanasi-tour-pkg', NULL, 'Explore the holy cities of Ayodhya and Varanasi, rich in history, spirituality, and culture.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/ayodhya.webp', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Ayodhya & Varanasi Tour PKG', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(34, 1, 'Jaipur & Ajmer Tour PKG', 'jaipur-ajmer-tour-pkg', NULL, 'Visit the royal city of Jaipur and the revered Dargah Sharif in Ajmer for a mix of culture and history.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/jaipur-trip.jpg', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Jaipur & Ajmer Tour PKG', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(35, 1, 'Udaipur & Jaisalmer Tour PKG', 'udaipur-jaisalmer-tour-pkg', NULL, 'Explore the lakes and palaces of Udaipur and the golden fort of Jaisalmer for an unforgettable experience.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/Udaipur-jaisalmer.jpg', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Udaipur & Jaisalmer Tour PKG', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:56', '2025-12-31 08:53:56'),
(36, 1, 'Ujjain Mahakal Tour PKG', 'ujjain-mahakal-tour-pkg', NULL, 'Visit the revered Mahakaleshwar temple in Ujjain and experience the spiritual significance of this Jyotirlinga.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/Mahakal-ujjain.jpg', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Ujjain Mahakal Tour PKG', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:57', '2025-12-31 08:53:57'),
(37, 1, 'Delhi to All India Taxi Service 24*7', 'delhi-to-all-india-taxi-service-24-7', NULL, 'Enjoy hassle-free travel with our 24/7 taxi service across India, starting from Delhi to all major cities.', 0, 0, 0.00, NULL, 'per_person', 'assets/img/packages/all-india.jpg', NULL, NULL, 20, 0, 'easy', NULL, NULL, 'Delhi to All India Taxi Service 24*7', '', '', 1, 0, 0, 0, 0, '2025-12-31 08:53:57', '2025-12-31 08:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles_new`
--

CREATE TABLE `vehicles_new` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('sedan','suv','tempo_traveller','bus','luxury') NOT NULL,
  `capacity` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL,
  `price_per_km` decimal(8,2) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_number` (`booking_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `idx_booking_number` (`booking_number`),
  ADD KEY `idx_travel_date` (`travel_date`),
  ADD KEY `idx_status` (`booking_status`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_active` (`is_active`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_active` (`is_active`);

--
-- Indexes for table `gallery_new`
--
ALTER TABLE `gallery_new`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_related` (`related_type`,`related_id`);

--
-- Indexes for table `package_destinations`
--
ALTER TABLE `package_destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_package_destination` (`package_id`,`destination_id`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `idx_package` (`package_id`);

--
-- Indexes for table `package_itinerary`
--
ALTER TABLE `package_itinerary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_package_day` (`package_id`,`day_number`);

--
-- Indexes for table `package_pricing`
--
ALTER TABLE `package_pricing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_package` (`package_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `idx_package` (`package_id`),
  ADD KEY `idx_approved` (`is_approved`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `tour_packages`
--
ALTER TABLE `tour_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `idx_featured` (`is_featured`);

--
-- Indexes for table `vehicles_new`
--
ALTER TABLE `vehicles_new`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `gallery_new`
--
ALTER TABLE `gallery_new`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_destinations`
--
ALTER TABLE `package_destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `package_itinerary`
--
ALTER TABLE `package_itinerary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=423;

--
-- AUTO_INCREMENT for table `package_pricing`
--
ALTER TABLE `package_pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tour_packages`
--
ALTER TABLE `tour_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `vehicles_new`
--
ALTER TABLE `vehicles_new`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `tour_packages` (`id`);

--
-- Constraints for table `package_destinations`
--
ALTER TABLE `package_destinations`
  ADD CONSTRAINT `package_destinations_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `tour_packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_destinations_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `package_itinerary`
--
ALTER TABLE `package_itinerary`
  ADD CONSTRAINT `package_itinerary_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `tour_packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `package_pricing`
--
ALTER TABLE `package_pricing`
  ADD CONSTRAINT `package_pricing_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `tour_packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `tour_packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_packages`
--
ALTER TABLE `tour_packages`
  ADD CONSTRAINT `tour_packages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
