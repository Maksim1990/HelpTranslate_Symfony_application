-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2019 at 11:46 AM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.17-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helptranslate_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Computer Peripherals');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `user_id`, `image_name`, `image_size`, `created_at`, `updated_at`) VALUES
(6, 1, 'eQWu4AYHL70.jpg', '271081', '2017-12-23 21:55:37', '2017-12-23 21:55:37'),
(7, 2, '5.jpg', '5937', '2017-12-23 21:56:28', '2017-12-23 21:56:28'),
(8, 4, '7.jpg', '52977', '2017-12-23 22:07:55', '2017-12-23 22:07:55'),
(9, 5, '16.jpg', '78887', '2017-12-23 22:11:07', '2017-12-23 22:11:07'),
(10, 3, '10.jpg', '6417', '2017-12-23 22:12:31', '2017-12-23 22:12:31'),
(11, 7, 'Test-Logo-Circle-black-transparent.png', '53163', '2018-03-24 01:37:42', '2018-03-24 01:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_sender_id` int(11) NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_size` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_read` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_sender_id`, `message`, `image_name`, `image_size`, `created_at`, `updated_at`, `user_id`, `is_read`) VALUES
(6, 2, 'Helo Nathan', NULL, NULL, '2017-11-11 00:00:00', '2017-11-20 23:04:30', 3, '1'),
(7, 1, 'How are you?', NULL, NULL, '2017-11-12 22:06:22', '2017-11-20 23:04:39', 3, '1'),
(9, 4, 'Hello Anna!', NULL, NULL, '2017-11-12 22:15:26', '2017-11-20 23:01:25', 2, '1'),
(24, 2, 'Hello you too!', NULL, NULL, '2017-11-18 01:34:26', '2017-12-23 21:18:00', 1, '1'),
(25, 1, 'Where are you?', NULL, NULL, '2017-11-18 01:43:10', '2017-11-20 23:04:39', 3, '1'),
(35, 4, 'Hello', NULL, NULL, '2017-11-23 21:29:06', '2017-12-23 22:20:35', 5, '1'),
(36, 1, 'Hello!', NULL, NULL, '2017-11-23 22:24:29', NULL, 3, '0'),
(37, 1, 'How are you?', NULL, NULL, '2017-11-23 22:25:16', NULL, 2, '0'),
(40, 4, 'Hello Maksim!', NULL, NULL, '2017-12-23 22:08:15', NULL, 1, '0'),
(41, 5, 'Hello Richard!', NULL, NULL, '2017-12-23 22:14:48', NULL, 4, '0'),
(42, 5, 'How are you there???', NULL, NULL, '2017-12-23 22:15:31', NULL, 4, '0'),
(43, 4, 'I am fine! Everything going good!', NULL, NULL, '2017-12-23 22:16:01', '2017-12-23 22:20:35', 5, '1'),
(44, 4, 'Do you plan to visit Belarus?', NULL, NULL, '2017-12-23 22:16:37', '2017-12-23 22:20:35', 5, '1'),
(45, 5, 'Hello Anna!', NULL, NULL, '2017-12-23 22:20:20', NULL, 2, '0'),
(46, 7, 'Hello Maksim!', NULL, NULL, '2018-03-24 01:45:06', '2018-03-24 01:50:17', 1, '1'),
(47, 7, 'How are you?', NULL, NULL, '2018-03-24 01:45:29', '2018-03-24 01:50:17', 1, '1'),
(48, 7, 'Привет,Анна! Как дела?', NULL, NULL, '2018-03-24 01:46:04', NULL, 2, '0'),
(49, 1, 'Hello!', NULL, NULL, '2018-03-24 01:50:27', NULL, 7, '0'),
(50, 1, 'I am fine)how are you?', NULL, NULL, '2018-03-24 01:50:49', NULL, 7, '0'),
(51, 1, 'Nice to meet you here!', NULL, NULL, '2018-03-24 01:50:57', NULL, 7, '0');

-- --------------------------------------------------------

--
-- Table structure for table `opinion`
--

CREATE TABLE `opinion` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `opinion_text` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `opinion`
--

INSERT INTO `opinion` (`id`, `user_id`, `opinion_text`, `created_at`, `updated_at`) VALUES
(1, 1, 'Love this site sincerely!!!', '2017-11-20 21:46:01', '2017-11-20 21:46:01'),
(2, 1, '<p>I like it so much!!!!!!!<img alt=\"smiley\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /><img alt=\"yes\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/thumbs_up.png\" style=\"height:23px; width:23px\" title=\"yes\" /></p>', '2017-12-23 19:03:42', '2017-12-23 19:03:42'),
(3, 2, '<p>Nice web site!!!<img alt=\"smiley\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /></p>', '2017-12-23 19:04:28', '2017-12-23 19:04:28'),
(5, 5, '<p>So usefull and good app!<img alt=\"yes\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/thumbs_up.png\" style=\"height:23px; width:23px\" title=\"yes\" /></p>', '2017-12-23 22:22:44', '2017-12-23 22:22:44'),
(6, 7, '<p>Very useful and interesting application<img alt=\"smiley\" src=\"http://185.177.59.147/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /></p>', '2018-09-29 17:38:07', '2018-09-29 17:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `description`, `created_at`) VALUES
(1, 1, 'Keyboard', 'Ergonomic and stylish!', '2017-10-26 20:55:18');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `country`, `city`, `phone`, `status`, `birth_date`, `active`, `updated_at`, `create_date`) VALUES
(3, 1, NULL, NULL, NULL, NULL, NULL, 'Y', '2017-10-26 20:37:30', '2017-10-26 20:37:30'),
(4, 2, NULL, NULL, NULL, NULL, '11-11-1987', 'Y', '2017-10-26 21:20:35', '2017-10-26 21:20:35'),
(5, 3, NULL, NULL, NULL, NULL, NULL, 'Y', '2017-10-29 17:49:24', '2017-10-29 17:49:24'),
(6, 4, NULL, NULL, NULL, NULL, NULL, 'Y', '2017-11-18 18:18:15', '2017-11-18 18:18:15'),
(7, 5, NULL, NULL, NULL, NULL, NULL, 'Y', '2017-11-18 18:21:13', '2017-11-18 18:21:13'),
(8, 6, NULL, NULL, NULL, NULL, NULL, 'Y', '2018-01-10 10:09:06', '2018-01-10 10:09:06'),
(9, 7, 'Belarus', 'Minsk', '123-456-78', 'Hello World!', NULL, 'Y', '2018-03-24 01:35:25', '2018-03-24 01:35:25');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_profile_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rating` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `user_id`, `user_profile_id`, `rating`, `created_at`, `updated_at`) VALUES
(1, 5, '1', '4', '2017-10-26 23:34:36', '2017-10-26 23:34:36'),
(2, 2, '1', '4', '2017-10-26 23:49:24', '2017-10-26 23:49:24'),
(3, 1, '3', '4', '2017-10-29 19:04:14', '2017-10-29 19:04:14'),
(4, 1, '5', '4', '2017-11-25 17:10:53', '2017-11-25 17:10:53'),
(5, 5, '3', '4', '2017-12-23 22:21:44', '2017-12-23 22:21:44'),
(6, 2, '6', '3', '2018-01-12 00:09:59', '2018-01-12 00:09:59'),
(7, 1, '7', '4', '2018-03-24 01:51:51', '2018-03-24 01:51:51');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `background_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sidebar_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `footer_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `links_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `background_color`, `sidebar_color`, `footer_color`, `header_color`, `links_color`, `show_email`, `created_at`, `updated_at`) VALUES
(1, 1, '#008080', '#ffdab5', '#008080', '#693434', NULL, 'Y', '2018-09-28 21:04:07', NULL),
(2, 2, NULL, '#b7b7ff', NULL, '#004f9d', NULL, NULL, '2017-11-19 15:50:46', NULL),
(3, 3, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-29 17:49:24', NULL),
(4, 4, NULL, NULL, NULL, NULL, NULL, NULL, '2017-11-18 18:18:15', NULL),
(5, 5, NULL, NULL, NULL, NULL, NULL, NULL, '2017-11-18 18:21:13', NULL),
(6, 6, NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-10 10:09:06', NULL),
(7, 7, '#dbd2ea', NULL, NULL, '#f59e56', NULL, NULL, '2018-09-28 21:09:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_profile_id` int(11) NOT NULL,
  `user_profile_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`id`, `user_id`, `user_profile_id`, `user_profile_type`, `user_type`, `language_type`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'teacher', 'student', 'by', 'Reallly so good teacher! I recommend him!!', '2017-10-26 21:40:56', NULL),
(2, 1, 3, 'student', 'teacher', 'by', 'Good student!!!', '2017-10-29 19:04:35', NULL),
(3, 1, 5, 'student', 'teacher', 'by', 'Glad to be teacher of Sonya! ', '2017-11-25 17:11:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `due_date` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`id`, `user_id`, `title`, `category`, `language_type`, `description`, `priority`, `due_date`, `create_date`, `updated_at`) VALUES
(1, 1, 'New \"Home translate\"', 'text', 'by', '<p>Test home translate !!!&nbsp;<img alt=\"laugh\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/teeth_smile.png\" style=\"height:23px; width:23px\" title=\"laugh\" /></p>', 'Normal', '2018-01-01 12:00:00', '2017-10-21 00:41:59', '2017-12-23 16:37:27'),
(2, 1, 'Danish translation', 'text', 'dk', '<p>Welcome to this country and share your opinion about this interesting country!<img alt=\"sad\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/sad_smile.png\" style=\"height:23px; width:23px\" title=\"sad\" /><img alt=\"wink\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/wink_smile.png\" style=\"height:23px; width:23px\" title=\"wink\" /></p>', 'High', '2018-01-01 00:00:00', '2017-10-21 17:07:03', '2017-12-23 18:03:57'),
(3, 1, 'Finish text to translate', 'text', 'fi', '<p>Helsinki, Finland&rsquo;s southern capital, sits on a peninsula in the Gulf of Finland. Its central avenue, Mannerheimintie, is flanked by institutions including the National Museum, tracing Finnish history from the Stone Age to the present. Also on Mannerheimintie are the imposing Parliament House and Kiasma, a contemporary art museum. Ornate red-brick Uspenski Cathedral overlooks a harbor.</p>', 'Low', '2018-11-01 10:00:00', '2017-10-21 17:49:41', '2017-12-23 18:14:28'),
(4, 2, 'Urgent translation to Belarussian', 'text', 'by', '<p>Minsk, capital of Belarus,<img alt=\"smiley\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /> is a modern city dominated by monumental Stalinist architecture. Many of its museums, theaters and other cultural attractions line Independence Avenue (Praspyekt Nyezalyezhnastsi), a wide, 15km-long thoroughfare leading to vast Independence Square. Looming over this iconic plaza are massive KGB Headquarters and the neo-Romanesque Church of Saints Simon and Helena, also known as Red Church.</p>', 'Low', '2019-01-05 00:00:00', '2017-10-21 17:49:59', '2017-12-23 18:24:25'),
(5, 1, 'Espagnol translation', 'text', 'es', '<p>Madrid, <span style=\"color:#ff0000\">Spain&#39;s central capital,</span> is a city of elegant boulevards and expansive, manicured parks such as the Buen Retiro. It&rsquo;s renowned for its rich repositories of European art, including the Prado Museum&rsquo;s works by Goya, Vel&aacute;zquez and other Spanish masters. The heart of old Hapsburg Madrid is the portico-lined Plaza Mayor, and nearby is the baroque Royal Palace and Armory, displaying historic weaponry.<img alt=\"smiley\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /></p>', 'Low', '2018-07-10 09:30:00', '2017-10-21 17:50:16', '2017-12-23 18:13:07'),
(6, 1, 'Translation to Thai language', 'text', 'th', '<p>Thailand is a Southeast Asian country. It&#39;s known for tropical beaches, opulent royal palaces, ancient ruins and ornate temples displaying figures of Buddha. In Bangkok, the capital, an ultramodern cityscape rises next to quiet canalside communities and the iconic temples of Wat Arun, Wat Pho and the Emerald Buddha Temple (Wat Phra Kaew). Nearby beach resorts include bustling Pattaya and fashionable Hua Hin.<img alt=\"smiley\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /></p>', 'Low', '2018-08-01 08:15:00', '2017-10-21 17:50:36', '2017-12-23 18:11:32'),
(7, 1, 'New Afar translation', 'article', 'aa', '<p>In Eritrea, Afar is recognized as one of nine national languages which formally enjoy equal status although&nbsp;<a href=\"https://en.wikipedia.org/wiki/Tigrinya_language\" title=\"Tigrinya language\">Tigrinya</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/Arabic\" title=\"Arabic\">Arabic</a>&nbsp;are by far of greatest significance in official usage. There are daily broadcasts on the national radio and a translated version of the Eritrean constitution. In education, however, Afar speakers prefer Arabic &ndash; which many of them speak as a second language &ndash; as the language of instruction</p>', 'Low', '2018-09-01 00:00:00', '2017-10-31 22:03:06', '2017-12-23 18:07:59'),
(8, 1, 'Urgent Azerbaijani translation', 'text', 'az', '<p>Azerbaijani country welcomes new tourists and visitors to visit this friendly and beautiful country</p>', 'High', '2018-01-01 10:12:00', '2017-10-31 22:22:46', '2017-12-23 18:06:33'),
(9, 1, 'For revision NEW WORK@!!!', 'text', 'ja', '<p>Help me to trunslate it please!!!!!!<img alt=\"smiley\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /></p>', 'High', '2017-10-01 18:00:00', '2017-11-25 15:38:52', '2017-12-23 18:04:33'),
(10, 7, 'Test translation from Thai language', 'text', 'th', '<p>Help translate this current article into Thai language!<img alt=\"smiley\" src=\"http://www.discoveringworld.net/helptranslate/bundles/ivoryckeditor/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /></p>', 'Low', '2020-01-12 11:00:00', '2018-03-24 01:40:00', '2018-03-24 01:40:00'),
(11, 7, 'Translation from Russian', 'text', 'ru', '<p>Климат Таиланда&nbsp;&mdash; влажный&nbsp;<a href=\"https://ru.wikipedia.org/wiki/%D0%A2%D1%80%D0%BE%D0%BF%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B8%D0%B9_%D0%BA%D0%BB%D0%B8%D0%BC%D0%B0%D1%82\" title=\"Тропический климат\">тропический</a>&nbsp;на севере страны, и&nbsp;<a href=\"https://ru.wikipedia.org/wiki/%D0%A1%D1%83%D0%B1%D1%8D%D0%BA%D0%B2%D0%B0%D1%82%D0%BE%D1%80%D0%B8%D0%B0%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9_%D0%BA%D0%BB%D0%B8%D0%BC%D0%B0%D1%82\" title=\"Субэкваториальный климат\">субэкваториальный</a>&nbsp;в центральной и южной частях, а на границе с Малайзией&nbsp;&mdash; экваториальный. Это объясняется расположением большей части страны в тропическом и субэкваториальном поясах и влиянием юго-западного и северо-восточного&nbsp;<a href=\"https://ru.wikipedia.org/wiki/%D0%9C%D1%83%D1%81%D1%81%D0%BE%D0%BD\" title=\"Муссон\">муссонов</a>. Расстояние между крайней северной и крайней южной точками Таиланда составляет 1860&nbsp;км, а перепад широт&nbsp;&mdash; около 15 &deg;. Такая протяжённость с севера на юг делает климат Таиланда одним из самых разнообразных в&nbsp;<a href=\"https://ru.wikipedia.org/wiki/%D0%AE%D0%B3%D0%BE-%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%B0%D1%8F_%D0%90%D0%B7%D0%B8%D1%8F\" title=\"Юго-Восточная Азия\">Юго-Восточной Азии</a>. Юго-западный муссон приносит дожди и относительную прохладу в конце мая&nbsp;&mdash; середине июля. К ноябрю дожди прекращаются, и наступает &laquo;прохладный сухой&raquo; сезон, продолжающийся до середины февраля. В это время сказывается и влияние северо-восточного муссона, не задевающего Северный, Северо-Восточный и Центральный Таиланд непосредственно, однако приносящего прохладу. После ослабления муссонов, в феврале&nbsp;&mdash; мае, наступает сильная жара, причём влажность воздуха постепенно увеличивается вплоть до начала нового муссонного сезона, а затем цикл повторяется снова.</p>', 'High', '2020-10-18 10:00:00', '2018-03-24 01:41:24', '2018-03-24 01:41:24'),
(12, 7, 'Translation into Romanian!', 'text', 'ro', '<p>В Таиланде король является не только главой государства, но и покровителем, защитником всех религий. В периоды кризиса он выступает в роли примиряющего посредника, не занимая чью-либо сторону.&nbsp;<a href=\"https://ru.wikipedia.org/wiki/%D0%9A%D0%BE%D1%80%D0%BE%D0%BB%D1%8C_%D0%A2%D0%B0%D0%B8%D0%BB%D0%B0%D0%BD%D0%B4%D0%B0\" title=\"Король Таиланда\">Король Таиланда</a>&nbsp;&mdash; лидер и национальный символ, стоящий над политикой, и поэтому он вмешивается в политические дела только когда это необходимо для предотвращения кровопролития. Любовь и уважение к королевской семье носит в Таиланде&nbsp;&mdash; по утверждению официальных представителей&nbsp;&mdash; почти религиозный характер. На протяжении последнего столетия, или даже немного больше, каждому царствующему королю, так же как и членам его семьи, официально приписывается горячее участие в благополучии народа и якобы личная заинтересованность в процветании всех подданных</p>', 'High', '2019-08-05 02:12:00', '2018-03-24 01:49:31', '2018-03-24 01:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `translator`
--

CREATE TABLE `translator` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `input_lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `input_word` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `output_lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `output_word` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `translator`
--

INSERT INTO `translator` (`id`, `user_id`, `input_lang`, `input_word`, `output_lang`, `output_word`, `created_at`, `updated_at`) VALUES
(1, 1, 'en', 'hello', 'de', 'Hallo', '2017-10-24 19:13:05', NULL),
(2, 1, 'en', 'hello', 'ar', 'مرحبا', '2017-12-23 18:00:20', NULL),
(3, 1, 'en', 'hello', 'fr', 'Bonjour', '2017-12-23 18:01:09', NULL),
(4, 2, 'en', 'Many of its museums, theaters and other cultural attractions line Independence Avenue (Praspyekt Nyezalyezhnastsi), a wide, 15km-long thoroughfare leading to vast Independence Square. Looming over this iconic plaza are massive KGB Headquarters and the neo', 'de', 'Viele seiner Museen, Theater und anderen kulturellen Attraktionen säumen die Independence Avenue (Praspyekt Nyezalyezhnastsi), eine breite, 15 km lange Straße, die zum großen Unabhängigkeitsplatz führt. Über diesem ikonischen Platz erheben sich das massiv', '2017-12-23 18:30:39', NULL),
(5, 6, 'en', 'Thanks ', 'be', 'дзякуй', '2018-01-10 10:18:35', NULL),
(6, 7, 'en', 'Hello', 'th', 'สวัสดี', '2018-03-24 01:47:30', NULL),
(7, 7, 'en', 'Hello how are you?', 'th', 'สวัสดีคุณเป็นอย่างไร?', '2018-03-24 01:47:41', NULL),
(8, 7, 'en', 'Hello how are you?', 'sk', 'Ahoj ako sa máš?', '2018-03-24 01:47:49', NULL),
(9, 7, 'en', 'Hello', 'be', 'добры дзень', '2018-07-27 11:42:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `type_user`
--

CREATE TABLE `type_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_level` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_available` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `type_user`
--

INSERT INTO `type_user` (`id`, `user_id`, `user_type`, `language_type`, `language_level`, `is_available`, `create_date`, `updated_at`) VALUES
(1, 2, 'teacher', 'by', 'advanced', '1', '2017-10-31 20:13:54', '2017-10-31 20:13:54'),
(2, 2, 'teacher', 'es', 'beginner', '1', '2017-10-31 00:00:00', '2017-10-31 00:00:00'),
(3, 3, 'teacher', 'es', 'advanced', '1', '2017-10-31 00:00:00', '2017-10-31 00:00:00'),
(7, 1, 'student', 'gb', 'beginner', '1', '2017-11-11 00:00:00', '2017-11-11 00:00:00'),
(10, 1, 'student', 'ay', 'beginner', '1', '2017-11-18 21:54:51', '2017-11-18 21:54:51'),
(11, 1, 'student', 'bg', 'beginner', '1', '2017-11-25 14:49:04', '2017-11-25 14:49:04'),
(16, 1, 'teacher', 'fr', 'beginner', '1', '2017-11-25 15:26:13', '2017-11-25 15:26:13'),
(17, 1, 'student', 'hi', 'beginner', '1', '2017-11-25 15:29:44', '2017-11-25 15:29:44'),
(18, 7, 'teacher', 'ro', 'advanced', '1', '2018-03-24 01:42:19', '2018-03-24 01:42:19'),
(19, 7, 'teacher', 'ru', 'advanced', '1', '2018-03-24 01:43:38', '2018-03-24 01:43:38'),
(20, 7, 'student', 'th', 'middle', '1', '2018-03-24 01:44:24', '2018-03-24 01:44:24'),
(21, 7, 'student', 'fr', 'middle', '1', '2018-03-24 01:44:45', '2018-03-24 01:44:45');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `create_date`, `updated_at`) VALUES
(1, 'Maksim', 'maksim@gmail.com', '$2y$13$nLvxWzkAXZB3W16vZok2guqTgF9ISNrl4dhv4LrFR35qg/9rzsxJS', '2017-10-26 20:37:30', '2017-10-26 20:37:30'),
(2, 'Anna', 'anna@gmail.com', '$2y$13$HTmjIeqTdcyV6O8O1O2C7OXELGOfIZ89wFiXgqz9kN610LN5pK2Fu', '2017-10-26 21:20:35', '2017-10-26 21:20:35'),
(3, 'Nathan', 'nano@gmail.com', '$2y$13$r/d16LERb77MuTW4Uh0cyeAKPHqaoVf2/1aCZqlV5J/xZORXPFs/K', '2017-10-29 17:49:24', '2017-10-29 17:49:24'),
(4, 'Richard', 'richard@gmail.com', '$2y$13$t9QYealEPL5yRD1TZ/Zc.eU.Ol.Ks8p4edxnfJKID8PiV045ptDIS', '2017-11-18 18:18:15', '2017-11-18 18:18:15'),
(5, 'Sonya', 'sonya@gmail.com', '$2y$13$7oeeVcgZGonVYbL8KIRDruEv67xnErxUurZ2Us2PFmMWMKjlSO33a', '2017-11-18 18:21:13', '2017-11-18 18:21:13'),
(6, 'Pavel', 'pavel.habrusevich@gmail.com', '$2y$13$W2XcJFtANWbwz/QfXKwFgevrc4wG3ar6Cli5pvgFgZpOJ1iYiXtKO', '2018-01-10 10:09:06', '2018-01-10 10:09:06'),
(7, 'test', 'test@test.com', '$2y$13$ZEy7lK7ov1y7PQkO0dZ0gOFHG03EErDAGIOn9JDg.cH59qbofLSNa', '2018-03-24 01:35:25', '2018-03-24 01:35:25');

-- --------------------------------------------------------

--
-- Table structure for table `work_status`
--

CREATE TABLE `work_status` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `work_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `work_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_reviewer_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `teacher_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `work_status`
--

INSERT INTO `work_status` (`id`, `work_id`, `work_type`, `work_status`, `user_reviewer_id`, `created_at`, `updated_at`, `teacher_description`) VALUES
(5, 7, 'Text', 'Accepted', 1, '2017-11-15 20:14:18', '2017-11-15 23:06:12', 'zdvsdvsd'),
(6, 8, 'Text', 'Declined', 1, '2017-11-15 23:02:04', '2017-12-23 16:40:58', 'Not good!'),
(7, 6, 'Text', 'Accepted', 7, '2018-03-24 01:51:15', '2018-03-24 01:52:57', 'Nice work!'),
(8, 1, 'Text', 'Pending', 7, '2018-03-24 01:51:37', '2018-03-24 01:51:37', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C53D045FA76ED395` (`user_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6BD307FA76ED395` (`user_id`),
  ADD KEY `IDX_B6BD307FF6C43E79` (`user_sender_id`);

--
-- Indexes for table `opinion`
--
ALTER TABLE `opinion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AB02B027A76ED395` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D8892622A76ED395` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E6BDCDF7A76ED395` (`user_id`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translator`
--
ALTER TABLE `translator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_user`
--
ALTER TABLE `type_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Indexes for table `work_status`
--
ALTER TABLE `work_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `opinion`
--
ALTER TABLE `opinion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `translator`
--
ALTER TABLE `translator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `type_user`
--
ALTER TABLE `type_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `work_status`
--
ALTER TABLE `work_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B6BD307FF6C43E79` FOREIGN KEY (`user_sender_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `opinion`
--
ALTER TABLE `opinion`
  ADD CONSTRAINT `FK_AB02B027A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `FK_D8892622A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD CONSTRAINT `FK_E6BDCDF7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
