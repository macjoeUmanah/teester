-- Generation Time: Nov 23, 2020 at 04:45 AM
-- Server version: 5.7.28
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mailcarry`
--

-- --------------------------------------------------------

--
-- Table structure for table `mc_activity_logs`
--

DROP TABLE IF EXISTS `mc_activity_logs`;
CREATE TABLE IF NOT EXISTS `mc_activity_logs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `subject_id` int(11) DEFAULT NULL,
  `subject_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` int(11) DEFAULT NULL,
  `causer_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_auto_followups`
--

DROP TABLE IF EXISTS `mc_auto_followups`;
CREATE TABLE IF NOT EXISTS `mc_auto_followups` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segment_id` int(10) UNSIGNED DEFAULT NULL,
  `broadcast_id` int(10) UNSIGNED DEFAULT NULL,
  `sending_server_id` int(10) UNSIGNED DEFAULT NULL,
  `active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auto_followups_broadcast_id_foreign` (`broadcast_id`),
  KEY `auto_followups_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_auto_followup_stats`
--

DROP TABLE IF EXISTS `mc_auto_followup_stats`;
CREATE TABLE IF NOT EXISTS `mc_auto_followup_stats` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auto_followup_id` int(10) UNSIGNED DEFAULT NULL,
  `auto_followup_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_auto_followup_stat_logs`
--

DROP TABLE IF EXISTS `mc_auto_followup_stat_logs`;
CREATE TABLE IF NOT EXISTS `mc_auto_followup_stat_logs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auto_followup_stat_id` int(10) UNSIGNED DEFAULT NULL,
  `message_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `list` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `broadcast` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sending_server` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Sent','Failed','Unsubscribed','Opened','Clicked','Bounced','Spammed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `afsl_id_afs_id` (`auto_followup_stat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_auto_followup_stat_log_clicks`
--

DROP TABLE IF EXISTS `mc_auto_followup_stat_log_clicks`;
CREATE TABLE IF NOT EXISTS `mc_auto_followup_stat_log_clicks` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auto_followup_stat_log_id` int(10) UNSIGNED DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `afslc_id_afsl_id` (`auto_followup_stat_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_auto_followup_stat_log_opens`
--

DROP TABLE IF EXISTS `mc_auto_followup_stat_log_opens`;
CREATE TABLE IF NOT EXISTS `mc_auto_followup_stat_log_opens` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auto_followup_stat_log_id` int(10) UNSIGNED DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `afslo_id_afsl_id` (`auto_followup_stat_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_blacklisteds`
--

DROP TABLE IF EXISTS `mc_blacklisteds`;
CREATE TABLE IF NOT EXISTS `mc_blacklisteds` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_domain` enum('ip','domain') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ip',
  `detail` longtext COLLATE utf8mb4_unicode_ci,
  `counts` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_bounces`
--

DROP TABLE IF EXISTS `mc_bounces`;
CREATE TABLE IF NOT EXISTS `mc_bounces` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `method` enum('imap','pop3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'imap',
  `host` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `port` smallint(5) UNSIGNED DEFAULT NULL,
  `encryption` enum('ssl','tls','none') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ssl',
  `validate_cert` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `delete_after_processing` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `pmta` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bounces_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_broadcasts`
--

DROP TABLE IF EXISTS `mc_broadcasts`;
CREATE TABLE IF NOT EXISTS `mc_broadcasts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `email_subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_html` longtext COLLATE utf8mb4_unicode_ci,
  `content_text` longtext COLLATE utf8mb4_unicode_ci,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `broadcasts_group_id_foreign` (`group_id`),
  KEY `broadcasts_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_client_settings`
--

DROP TABLE IF EXISTS `mc_client_settings`;
CREATE TABLE IF NOT EXISTS `mc_client_settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mail_headers` longtext COLLATE utf8mb4_unicode_ci,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_contacts`
--

DROP TABLE IF EXISTS `mc_contacts`;
CREATE TABLE IF NOT EXISTS `mc_contacts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `list_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `confirmed` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `unsubscribed` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `format` enum('HTML','Text') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Text',
  `verified` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `source` enum('app','form','api','import') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'app',
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contacts_list_id_email_unique` (`list_id`,`email`),
  KEY `contacts_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_countries`
--

DROP TABLE IF EXISTS `mc_countries`;
CREATE TABLE IF NOT EXISTS `mc_countries` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mc_countries`
--

INSERT INTO `mc_countries` (`id`, `code`, `name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AL', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'AS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua and/or Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British lndian Ocean Territory'),
(32, 'BN', 'Brunei Darussalam'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CA', 'Canada'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CG', 'Congo'),
(50, 'CK', 'Cook Islands'),
(51, 'CR', 'Costa Rica'),
(52, 'HR', 'Croatia (Hrvatska)'),
(53, 'CU', 'Cuba'),
(54, 'CY', 'Cyprus'),
(55, 'CZ', 'Czech Republic'),
(56, 'CD', 'Democratic Republic of Congo'),
(57, 'DK', 'Denmark'),
(58, 'DJ', 'Djibouti'),
(59, 'DM', 'Dominica'),
(60, 'DO', 'Dominican Republic'),
(61, 'TP', 'East Timor'),
(62, 'EC', 'Ecudaor'),
(63, 'EG', 'Egypt'),
(64, 'SV', 'El Salvador'),
(65, 'GQ', 'Equatorial Guinea'),
(66, 'ER', 'Eritrea'),
(67, 'EE', 'Estonia'),
(68, 'ET', 'Ethiopia'),
(69, 'FK', 'Falkland Islands (Malvinas)'),
(70, 'FO', 'Faroe Islands'),
(71, 'FJ', 'Fiji'),
(72, 'FI', 'Finland'),
(73, 'FR', 'France'),
(74, 'FX', 'France, Metropolitan'),
(75, 'GF', 'French Guiana'),
(76, 'PF', 'French Polynesia'),
(77, 'TF', 'French Southern Territories'),
(78, 'GA', 'Gabon'),
(79, 'GM', 'Gambia'),
(80, 'GE', 'Georgia'),
(81, 'DE', 'Germany'),
(82, 'GH', 'Ghana'),
(83, 'GI', 'Gibraltar'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'ID', 'Indonesia'),
(101, 'IR', 'Iran (Islamic Republic of)'),
(102, 'IQ', 'Iraq'),
(103, 'IE', 'Ireland'),
(104, 'IL', 'Israel'),
(105, 'IT', 'Italy'),
(106, 'CI', 'Ivory Coast'),
(107, 'JM', 'Jamaica'),
(108, 'JP', 'Japan'),
(109, 'JO', 'Jordan'),
(110, 'KZ', 'Kazakhstan'),
(111, 'KE', 'Kenya'),
(112, 'KI', 'Kiribati'),
(113, 'KP', 'Korea, Democratic People\'s Republic of'),
(114, 'KR', 'Korea, Republic of'),
(115, 'KW', 'Kuwait'),
(116, 'KG', 'Kyrgyzstan'),
(117, 'LA', 'Lao People\'s Democratic Republic'),
(118, 'LV', 'Latvia'),
(119, 'LB', 'Lebanon'),
(120, 'LS', 'Lesotho'),
(121, 'LR', 'Liberia'),
(122, 'LY', 'Libyan Arab Jamahiriya'),
(123, 'LI', 'Liechtenstein'),
(124, 'LT', 'Lithuania'),
(125, 'LU', 'Luxembourg'),
(126, 'MO', 'Macau'),
(127, 'MK', 'Macedonia'),
(128, 'MG', 'Madagascar'),
(129, 'MW', 'Malawi'),
(130, 'MY', 'Malaysia'),
(131, 'MV', 'Maldives'),
(132, 'ML', 'Mali'),
(133, 'MT', 'Malta'),
(134, 'MH', 'Marshall Islands'),
(135, 'MQ', 'Martinique'),
(136, 'MR', 'Mauritania'),
(137, 'MU', 'Mauritius'),
(138, 'TY', 'Mayotte'),
(139, 'MX', 'Mexico'),
(140, 'FM', 'Micronesia, Federated States of'),
(141, 'MD', 'Moldova, Republic of'),
(142, 'MC', 'Monaco'),
(143, 'MN', 'Mongolia'),
(144, 'MS', 'Montserrat'),
(145, 'MA', 'Morocco'),
(146, 'MZ', 'Mozambique'),
(147, 'MM', 'Myanmar'),
(148, 'NA', 'Namibia'),
(149, 'NR', 'Nauru'),
(150, 'NP', 'Nepal'),
(151, 'NL', 'Netherlands'),
(152, 'AN', 'Netherlands Antilles'),
(153, 'NC', 'New Caledonia'),
(154, 'NZ', 'New Zealand'),
(155, 'NI', 'Nicaragua'),
(156, 'NE', 'Niger'),
(157, 'NG', 'Nigeria'),
(158, 'NU', 'Niue'),
(159, 'NF', 'Norfork Island'),
(160, 'MP', 'Northern Mariana Islands'),
(161, 'NO', 'Norway'),
(162, 'OM', 'Oman'),
(163, 'PK', 'Pakistan'),
(164, 'PW', 'Palau'),
(165, 'PA', 'Panama'),
(166, 'PG', 'Papua New Guinea'),
(167, 'PY', 'Paraguay'),
(168, 'PE', 'Peru'),
(169, 'PH', 'Philippines'),
(170, 'PN', 'Pitcairn'),
(171, 'PL', 'Poland'),
(172, 'PT', 'Portugal'),
(173, 'PR', 'Puerto Rico'),
(174, 'QA', 'Qatar'),
(175, 'SS', 'Republic of South Sudan'),
(176, 'RE', 'Reunion'),
(177, 'RO', 'Romania'),
(178, 'RU', 'Russian Federation'),
(179, 'RW', 'Rwanda'),
(180, 'KN', 'Saint Kitts and Nevis'),
(181, 'LC', 'Saint Lucia'),
(182, 'VC', 'Saint Vincent and the Grenadines'),
(183, 'WS', 'Samoa'),
(184, 'SM', 'San Marino'),
(185, 'ST', 'Sao Tome and Principe'),
(186, 'SA', 'Saudi Arabia'),
(187, 'SN', 'Senegal'),
(188, 'RS', 'Serbia'),
(189, 'SC', 'Seychelles'),
(190, 'SL', 'Sierra Leone'),
(191, 'SG', 'Singapore'),
(192, 'SK', 'Slovakia'),
(193, 'SI', 'Slovenia'),
(194, 'SB', 'Solomon Islands'),
(195, 'SO', 'Somalia'),
(196, 'ZA', 'South Africa'),
(197, 'GS', 'South Georgia South Sandwich Islands'),
(198, 'ES', 'Spain'),
(199, 'LK', 'Sri Lanka'),
(200, 'SH', 'St. Helena'),
(201, 'PM', 'St. Pierre and Miquelon'),
(202, 'SD', 'Sudan'),
(203, 'SR', 'Suriname'),
(204, 'SJ', 'Svalbarn and Jan Mayen Islands'),
(205, 'SZ', 'Swaziland'),
(206, 'SE', 'Sweden'),
(207, 'CH', 'Switzerland'),
(208, 'SY', 'Syrian Arab Republic'),
(209, 'TW', 'Taiwan'),
(210, 'TJ', 'Tajikistan'),
(211, 'TZ', 'Tanzania, United Republic of'),
(212, 'TH', 'Thailand'),
(213, 'TG', 'Togo'),
(214, 'TK', 'Tokelau'),
(215, 'TO', 'Tonga'),
(216, 'TT', 'Trinidad and Tobago'),
(217, 'TN', 'Tunisia'),
(218, 'TR', 'Turkey'),
(219, 'TM', 'Turkmenistan'),
(220, 'TC', 'Turks and Caicos Islands'),
(221, 'TV', 'Tuvalu'),
(222, 'UG', 'Uganda'),
(223, 'UA', 'Ukraine'),
(224, 'AE', 'United Arab Emirates'),
(225, 'GB', 'United Kingdom'),
(226, 'US', 'United States'),
(227, 'UM', 'United States minor outlying islands'),
(228, 'UY', 'Uruguay'),
(229, 'UZ', 'Uzbekistan'),
(230, 'VU', 'Vanuatu'),
(231, 'VA', 'Vatican City State'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Virgin Islands (British)'),
(235, 'VI', 'Virgin Islands (U.S.)'),
(236, 'WF', 'Wallis and Futuna Islands'),
(237, 'EH', 'Western Sahara'),
(238, 'YE', 'Yemen'),
(239, 'YU', 'Yugoslavia'),
(240, 'ZR', 'Zaire'),
(241, 'ZM', 'Zambia'),
(242, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `mc_custom_fields`
--

DROP TABLE IF EXISTS `mc_custom_fields`;
CREATE TABLE IF NOT EXISTS `mc_custom_fields` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `type` enum('number','text','textarea','date','radio','checkbox','dropdown') COLLATE utf8mb4_unicode_ci NOT NULL,
  `values` text COLLATE utf8mb4_unicode_ci,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_fields_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_custom_field_contact`
--

DROP TABLE IF EXISTS `mc_custom_field_contact`;
CREATE TABLE IF NOT EXISTS `mc_custom_field_contact` (
  `contact_id` int(10) UNSIGNED NOT NULL,
  `custom_field_id` int(10) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  KEY `custom_field_contact_contact_id_foreign` (`contact_id`),
  KEY `custom_field_contact_custom_field_id_foreign` (`custom_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_custom_field_list`
--

DROP TABLE IF EXISTS `mc_custom_field_list`;
CREATE TABLE IF NOT EXISTS `mc_custom_field_list` (
  `list_id` int(10) UNSIGNED NOT NULL,
  `custom_field_id` int(10) UNSIGNED NOT NULL,
  KEY `custom_field_list_list_id_foreign` (`list_id`),
  KEY `custom_field_list_custom_field_id_foreign` (`custom_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_drips`
--

DROP TABLE IF EXISTS `mc_drips`;
CREATE TABLE IF NOT EXISTS `mc_drips` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `broadcast_id` int(10) UNSIGNED DEFAULT NULL,
  `active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `send` enum('Instant','After') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Instant',
  `after_minutes` int(10) UNSIGNED DEFAULT NULL,
  `send_attributes` json DEFAULT NULL,
  `send_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `drips_group_id_foreign` (`group_id`),
  KEY `drips_broadcast_id_foreign` (`broadcast_id`),
  KEY `drips_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_email_verifiers`
--

DROP TABLE IF EXISTS `mc_email_verifiers`;
CREATE TABLE IF NOT EXISTS `mc_email_verifiers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributes` json DEFAULT NULL,
  `total_verified` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'kickbox',
  `active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_failed_jobs`
--

DROP TABLE IF EXISTS `mc_failed_jobs`;
CREATE TABLE IF NOT EXISTS `mc_failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_fbls`
--

DROP TABLE IF EXISTS `mc_fbls`;
CREATE TABLE IF NOT EXISTS `mc_fbls` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `method` enum('imap','pop3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'imap',
  `host` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `port` smallint(5) UNSIGNED DEFAULT NULL,
  `encryption` enum('ssl','tls','none') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ssl',
  `validate_cert` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `delete_after_processing` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fbls_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_file_offsets`
--

DROP TABLE IF EXISTS `mc_file_offsets`;
CREATE TABLE IF NOT EXISTS `mc_file_offsets` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file` text COLLATE utf8mb4_unicode_ci,
  `offset` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_groups`
--

DROP TABLE IF EXISTS `mc_groups`;
CREATE TABLE IF NOT EXISTS `mc_groups` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` smallint(5) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groups_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_imports`
--

DROP TABLE IF EXISTS `mc_imports`;
CREATE TABLE IF NOT EXISTS `mc_imports` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('contact','suppression') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributes` json DEFAULT NULL,
  `total` int(10) UNSIGNED NOT NULL,
  `processed` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `duplicates` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `invalids` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `suppressed` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `bounced` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `imports_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_jobs`
--

DROP TABLE IF EXISTS `mc_jobs`;
CREATE TABLE IF NOT EXISTS `mc_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_lists`
--

DROP TABLE IF EXISTS `mc_lists`;
CREATE TABLE IF NOT EXISTS `mc_lists` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `sending_server_id` int(10) UNSIGNED DEFAULT NULL,
  `double_optin` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `welcome_email` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `unsub_email` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `notification` enum('Disabled','Enabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Disabled',
  `notification_attributes` json DEFAULT NULL,
  `attributes` longtext COLLATE utf8mb4_unicode_ci,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lists_group_id_foreign` (`group_id`),
  KEY `lists_user_id_foreign` (`user_id`),
  KEY `lists_sending_server_id_foreign` (`sending_server_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_migrations`
--

DROP TABLE IF EXISTS `mc_migrations`;
CREATE TABLE IF NOT EXISTS `mc_migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mc_migrations`
--

INSERT INTO `mc_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_10_100000_create_password_resets_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2018_10_10_000000_create_countries_table', 1),
(4, '2018_12_23_073603_create_permission_table', 1),
(5, '2018_12_23_195647_add_roleid_to_users_table', 1),
(6, '2018_12_25_161106_create_activity_log_table', 1),
(7, '2018_12_28_202446_create_groups_table', 1),
(8, '2018_12_29_154219_create_lists_table', 1),
(9, '2019_01_05_121517_create_custom_fields_table', 1),
(10, '2019_01_05_122710_create_custom_field_list_table', 1),
(11, '2019_01_06_081249_create_contacts_table', 1),
(12, '2019_01_18_205559_create_custom_field_contact_table', 1),
(13, '2019_01_21_035829_create_jobs_table', 1),
(14, '2019_01_26_125955_create_failed_jobs_table', 1),
(15, '2019_01_26_170627_create_notifications_table', 1),
(16, '2019_01_27_193709_create_imports_table', 1),
(17, '2019_03_09_115735_create_broadcasts_table', 1),
(18, '2019_03_16_055231_create_segments_table', 1),
(19, '2019_03_17_134718_create_spintags_table', 1),
(20, '2019_04_13_053052_create_sending_domains', 1),
(21, '2019_04_20_103403_create_settings_table', 1),
(22, '2019_04_21_050912_create_bounces_table', 1),
(23, '2019_04_21_052719_create_fbls_table', 1),
(24, '2019_04_29_024435_create_suppressions_table', 1),
(25, '2019_05_03_182653_create_sending_servers_table', 1),
(26, '2019_05_03_191006_add_sending_server_id_to_lists_table', 1),
(27, '2019_05_11_062746_create_schedule_campaigns_table', 1),
(28, '2019_05_18_095254_create_templates_table', 1),
(29, '2019_05_21_101605_add_notification_to_lists_table', 1),
(30, '2019_05_21_101904_add_notification_attributes_to_lists_table', 1),
(31, '2019_05_22_080609_create_webforms_table', 1),
(32, '2019_05_22_083630_create_pages_table', 1),
(33, '2019_06_15_090026_modify_action_to_segments_table', 1),
(34, '2019_06_19_192924_create_schedule_campaign_stats_table', 1),
(35, '2019_06_20_072656_create_schedule_campaign_stat_logs_table', 1),
(36, '2019_06_20_073449_create_schedule_campaign_stat_log_opens_table', 1),
(37, '2019_06_20_074056_create_schedule_campaign_stat_log_clicks_table', 1),
(38, '2019_06_20_074406_create_schedule_campaign_stat_log_bounces_table', 1),
(39, '2019_06_20_075937_create_schedule_campaign_stat_log_spams_table', 1),
(40, '2019_06_23_081533_create_file_offsets_table', 1),
(41, '2019_09_14_195045_create_drips_table', 1),
(42, '2019_09_14_195326_create_schedule_drips_table', 1),
(43, '2019_09_16_144851_create_schedule_drip_stats_table', 1),
(44, '2019_09_16_165410_create_schedule_drip_stat_logs_table', 1),
(45, '2019_09_17_130352_create_schedule_drip_stat_log_opens_table', 1),
(46, '2019_09_17_130507_create_schedule_drip_stat_log_clicks_table', 1),
(47, '2019_09_17_130652_create_schedule_drip_stat_log_bounces_table', 1),
(48, '2019_09_17_130732_create_schedule_drip_stat_log_spams_table', 1),
(49, '2019_09_20_204116_modify_status_to_schedule_campaigns_table', 1),
(50, '2019_10_06_185645_add_elastic_email_api_to_sending_servers_table', 1),
(51, '2019_10_16_080338_add_mailjet_api_to_sending_servers_table', 1),
(52, '2019_10_19_053744_add_sendinblue_api_to_sending_servers_table', 1),
(53, '2019_10_24_112345_add_pmta_to_settings_table', 1),
(54, '2019_10_24_114842_add_pmta_to_sending_servers_table', 1),
(55, '2019_10_24_114928_add_pmta_to_sending_domains_table', 1),
(56, '2019_10_24_115017_add_pmta_to_bounces_table', 1),
(57, '2019_11_14_180310_modify_sending_server_id_field_to_schedule_campaings_table', 1),
(58, '2019_11_20_181711_add_active_to_users_table', 1),
(59, '2019_12_08_134103_create_auto_followups_table', 1),
(60, '2019_12_09_112147_create_auto_followup_stats', 1),
(61, '2019_12_09_114846_create_auto_followup_stat_logs', 1),
(62, '2019_12_10_071444_create_auto_followup_stat_log_opens', 1),
(63, '2019_12_10_072137_create_auto_followup_stat_log_clicks', 1),
(64, '2019_12_10_072216_create_auto_followup_stat_log_bounces', 1),
(65, '2019_12_10_072234_create_auto_followup_stat_log_sapms', 1),
(66, '2019_12_22_171114_alter_bounces_password_lenght', 1),
(67, '2019_12_22_172152_alter_fbls_password_lenght', 1),
(68, '2019_12_30_065704_add_suppressed_to_imports_table', 1),
(69, '2019_12_30_071447_add_app_id_to_imports_table', 1),
(70, '2020_01_13_062243_drop_froeign_key_schedule_campaign_stat_log_bounces', 1),
(71, '2020_01_13_063943_add_section_to_schedule_campaign_stat_log_bounces', 1),
(72, '2020_01_13_121809_drop_auto_followup_stat_log_bounces_table', 1),
(73, '2020_01_13_122055_drop_schedule_drip_stat_log_bounces_table', 1),
(74, '2020_01_14_054605_drop_foriegn_key_schedule_campaign_stat_log_spams', 1),
(75, '2020_01_14_055017_add_section_to_schedule_campaign_stat_log_spams', 1),
(76, '2020_01_14_055723_drop_auto_followup_stat_log_spams_table', 1),
(77, '2020_01_14_055811_drop_schedule_drip_stat_log_spams_table', 1),
(78, '2020_02_04_055439_alter_password_resets_lenght', 1),
(79, '2020_02_26_075443_add_mail_headers_to_settings_table', 1),
(80, '2020_02_27_095000_create_email_verifiers_table', 1),
(81, '2020_03_03_064609_add_is_verified_to_contacts_table', 1),
(82, '2020_03_10_074901_create_blacklisteds_table', 1),
(83, '2020_03_19_051727_add_unsub_email_to_lists_table', 1),
(84, '2020_04_15_092703_add_is_client_and_attributes_to_users_table', 1),
(85, '2020_04_19_111706_upate_roles_default_data', 1),
(86, '2020_04_19_120621_create_client_settings_table', 1),
(87, '2020_04_20_070739_add_app_id_to_schedule_campaign_stat_log_bounces_table', 1),
(88, '2020_04_20_071106_add_app_id_to_schedule_campaign_stat_log_spams_table', 1),
(89, '2020_05_11_105429_create_packages_table', 1),
(90, '2020_05_12_105135_add_package_id_to_users_table', 1),
(91, '2020_07_09_154549_add_type_to_templates_table', 1),
(92, '2020_07_27_132303_add_verified_dmarc_to_sending_domains_table', 1),
(93, '2020_07_27_185951_add_sfp_ip_to_sending_domains_table', 1),
(94, '2020_07_28_053629_drop_foreign_key_sending_server_id_auto_followups', 1),
(95, '2020_07_28_054131_drop_foreign_key_sending_server_id_schedule_drips', 1),
(96, '2020_08_14_064617_add_tracking_domain_to_sending_servers_table', 1),
(97, '2020_08_14_122420_add_bounced_to_imports_table', 1),
(98, '2020_08_15_054956_add_general_settings_to_settings_table', 1),
(99, '2020_08_15_120920_add_email_index_to_schedule_campaign_stat_log_bounces_table', 1),
(100, '2020_09_10_052806_create_triggers_table', 1),
(101, '2020_09_15_055528_create_trigger_logs_table', 1),
(102, '2020_09_15_113233_trigger_schedules', 1),
(103, '2020_09_16_064819_add_trigger_id_to_schedule_drips_table', 1),
(104, '2020_09_18_050216_add_send_datetime_to_drips_table', 1),
(105, '2020_09_29_130005_update_action_enum_to_segments_table', 1),
(106, '2020_10_19_070759_add_current_version_to_settings_table', 1),
(107, '2020_10_19_081304_add_dkim_dmarc_selector_to_sending_domains_table', 1),
(108, '2020_10_23_054143_add_sofdelete_to_triggers_table', 1),
(109, '2020_10_29_084748_add_attributes_to_webforms_table', 1),
(110, '2020_11_04_071905_add_attributes_to_lists_table', 1),
(111, '2020_11_04_080412_alter_types_to_pages_table', 1),
(112, '2020_11_05_053653_add_execution_datetime_to_triggers_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mc_model_has_permissions`
--

DROP TABLE IF EXISTS `mc_model_has_permissions`;
CREATE TABLE IF NOT EXISTS `mc_model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_model_has_roles`
--

DROP TABLE IF EXISTS `mc_model_has_roles`;
CREATE TABLE IF NOT EXISTS `mc_model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mc_model_has_roles`
--

INSERT INTO `mc_model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mc_notifications`
--

DROP TABLE IF EXISTS `mc_notifications`;
CREATE TABLE IF NOT EXISTS `mc_notifications` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('import','export','copy','move','total','update','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `attributes` json DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_packages`
--

DROP TABLE IF EXISTS `mc_packages`;
CREATE TABLE IF NOT EXISTS `mc_packages` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `attributes` json DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_pages`
--

DROP TABLE IF EXISTS `mc_pages`;
CREATE TABLE IF NOT EXISTS `mc_pages` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Email','Notification','Page') COLLATE utf8mb4_unicode_ci DEFAULT 'Page',
  `email_subject` text COLLATE utf8mb4_unicode_ci,
  `content_html` longtext COLLATE utf8mb4_unicode_ci,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mc_pages`
--

INSERT INTO `mc_pages` (`id`, `name`, `slug`, `type`, `email_subject`, `content_html`, `app_id`, `created_at`, `updated_at`) VALUES
(1, 'Welcome Email', 'welcome-email', 'Email', 'Welcome!', '<!DOCTYPE html>\n          <html>\n          <head>\n          </head>\n          <body>\n            <!-- Page container -->\n            <div class=\"page-container \" style=\"min-height: 200px;\">\n              <div class=\"page-content\">\n                <div class=\"content-wrapper\">\n                  <div class=\"row\">\n                    <div class=\"col-sm-2 col-md-3\"></div>\n                    <div class=\"col-sm-8 col-md-6\">\n                      <h2 class=\"text-semibold mt-40 text-white\">[$list-name$]</h2>\n                      <div class=\"panel panel-body\">\n                        <h4>Your subscription to the list has been confirmed.</h4>\n                        <hr />\n                        <p>If at any time you wish to stop receiving the emails, you can: <br /> <a href=\"[$unsub-link$]\" class=\"btn btn-info bg-teal-800\">Unsubscribe here</a></p>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n              </div>\n            </div>\n            <!-- /page container -->\n          </body>\n          </html>', 1, NULL, NULL),
(2, 'Confirmation Email (Web From)', 'confirm-email-webform', 'Email', 'Registration confirmation', '<!DOCTYPE html>\n          <html>\n          <head>\n          </head>\n          <body>\n            <h2>Hello [#first-name#], welcome to MailCarry</h2>\n            <div class=\"page-container\" style=\"min-height: 249px;\">\n              <div class=\"page-content\">\n                <div class=\"content-wrapper\">\n                  <div class=\"row\">\n                    <div class=\"col-sm-8 col-md-6\">\n                      <div class=\"panel panel-body\">\n                        <h4>Please confirm your registration</h4>\n                        <hr />Click the link below to confirm your account:<br /><a href=\"[$confirm-link$]\">[$confirm-link$]</a><br /><hr />\n                        <p>&nbsp;</p>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n              </div>\n            </div>\n            <!-- /page container -->\n          </body>\n          </html>', 1, NULL, NULL),
(3, 'Confirmation Email (App)', 'confirm-email-app', 'Email', 'Registration confirmation', '<!DOCTYPE html>\n          <html>\n          <head>\n          </head>\n          <body>\n            <h2>Hello [#first-name#], welcome to MailCarry</h2>\n            <div class=\"page-container\" style=\"min-height: 249px;\">\n              <div class=\"page-content\">\n                <div class=\"content-wrapper\">\n                  <div class=\"row\">\n                    <div class=\"col-sm-8 col-md-6\">\n                      <div class=\"panel panel-body\">\n                        <h4>Please confirm your registration</h4>\n                        <hr />Click the link below to confirm your account:<br /><a href=\"[$confirm-link$]\">[$confirm-link$]</a><br /><hr />\n                        <p>&nbsp;</p>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n              </div>\n            </div>\n            <!-- /page container -->\n          </body>\n          </html>', 1, NULL, NULL),
(4, 'Notification Email (Contact Added)', 'notify-email-contact-added', 'Email', 'Contact has been added to a list', '<!DOCTYPE html>\n          <html>\n          <head>\n          </head>\n          <body>\n            <h2>[$list-name$]</h2>\n            <div class=\"page-container\" style=\"min-height: 249px;\">\n              <div class=\"page-content\">\n                <div class=\"content-wrapper\">\n                  <div class=\"row\">\n                    <div class=\"col-sm-8 col-md-6\">\n                      <div class=\"panel panel-body\">\n                        <h4>[$receiver-email$], has been added. </h4>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n              </div>\n            </div>\n            <!-- /page container -->\n          </body>\n          </html>', 1, NULL, NULL),
(5, 'Notification Email (Contact Confirmed)', 'notify-email-contact-confirm', 'Email', 'Contact has been confirmed', '<!DOCTYPE html>\n          <html>\n          <head>\n          </head>\n          <body>\n            <h2>[$list-name$]</h2>\n            <div class=\"page-container\" style=\"min-height: 249px;\">\n              <div class=\"page-content\">\n                <div class=\"content-wrapper\">\n                  <div class=\"row\">\n                    <div class=\"col-sm-8 col-md-6\">\n                      <div class=\"panel panel-body\">\n                        <h4>[$receiver-email$], has been added. </h4>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n              </div>\n            </div>\n            <!-- /page container -->\n          </body>\n          </html>', 1, NULL, NULL),
(6, 'Notification Email (Contact Unsubscribed)', 'notify-email-contact-unsub', 'Email', 'Contact has been unsubscribed', '<!DOCTYPE html>\n          <html>\n          <head>\n          </head>\n          <body>\n            <h2>[$list-name$]</h2>\n            <div class=\"page-container\" style=\"min-height: 249px;\">\n              <div class=\"page-content\">\n                <div class=\"content-wrapper\">\n                  <div class=\"row\">\n                    <div class=\"col-sm-8 col-md-6\">\n                      <div class=\"panel panel-body\">\n                        <h4>[$receiver-email$], has been added. </h4>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n              </div>\n            </div>\n            <!-- /page container -->\n          </body>\n          </html>', 1, NULL, NULL),
(7, 'Unsubscribe Email', 'unsub-email', 'Email', 'Unsubscribed', '<!DOCTYPE html>\n          <html>\n          <head>\n          </head>\n          <body>\n            <!-- Page container -->\n            <div class=\"page-container\" style=\"min-height: 200px;\">\n              <div class=\"page-content\">\n                <div class=\"content-wrapper\">\n                  <div class=\"row\">\n                    <div class=\"col-sm-2 col-md-3\"></div>\n                    <div class=\"col-sm-8 col-md-6\"><!-- form -->\n                      <h2 class=\"text-semibold mt-40 text-white\">[$list-name$]</h2>\n                      <div class=\"panel panel-body\">\n                        <h4>Your email address has been removed for the list</h4>\n                        <hr />\n                        <p>We are sorry to see you go.</p>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n              </div>\n            </div>\n            <!-- /page container -->\n          </body>\n          </html>', 1, NULL, NULL),
(8, 'Thankyou Page', 'thankyou', 'Page', NULL, '<!DOCTYPE html>\n          <html>\n          <head><title>Subscription Confirmed</title></head>\n          <body>\n          <!-- Page container -->\n          <div class=\"page-container\" style=\"min-height: 200px;\">\n            <div class=\"page-content\">\n              <div class=\"content-wrapper\">\n                <div class=\"row\">\n                  <div class=\"col-sm-2 col-md-3\"></div>\n                    <div class=\"col-sm-8 col-md-6\">\n                      <h2 class=\"text-semibold mt-40 text-white\">[$list-name$]</h2>\n                      <div class=\"panel panel-body\">\n                        <h4>Subscription Confirmed</h4>\n                        <hr />\n                        <p>Your subscription to the list has been confirmed.</p>\n                        <p>Thank you for subscribing!</p>\n                      </div>\n                    </div>\n                </div>\n              </div>\n            </div>\n          </div>\n          <!-- /page container -->\n          </body>\n          </html>', 1, NULL, NULL),
(9, 'Unsubscribe Page', 'unsub', 'Page', NULL, '<!DOCTYPE html>\n          <html>\n          <head><title>Unsubscribe</title></head>\n          <body>\n          <!-- Page container -->\n          <div class=\"page-container\" style=\"min-height: 200px;\">\n            <div class=\"page-content\">\n              <div class=\"content-wrapper\">\n                <div class=\"row\">\n                  <div class=\"col-sm-2 col-md-3\"></div>\n                    <div class=\"col-sm-8 col-md-6\">\n                      <h2 class=\"text-semibold mt-40 text-white\">[$list-name$]</h2>\n                      <div class=\"panel panel-body\">\n                        <h4>Unsubscribe Successful</h4>\n                        <hr />\n                        <p>You have been removed from [$list-name$]</p>\n                      </div>\n                    </div>\n                </div>\n              </div>\n            </div>\n          </div>\n          <!-- /page container -->\n          </body>\n          </html>', 1, NULL, NULL),
(10, 'Confirmation Page (Web From)', 'confirm', 'Page', NULL, '<!DOCTYPE html>\n          <html>\n          <head><title>Subscription Confirmed</title></head>\n          <body>\n          <!-- Page container -->\n          <div class=\"page-container\" style=\"min-height: 200px;\">\n            <div class=\"page-content\">\n              <div class=\"content-wrapper\">\n                <div class=\"row\">\n                  <div class=\"col-sm-2 col-md-3\"></div>\n                    <div class=\"col-sm-8 col-md-6\">\n                      <h2 class=\"text-semibold mt-40 text-white\">[$list-name$]</h2>\n                      <div class=\"panel panel-body\">\n                        <h4>Your subscription to the list has been confirmed.</h4>\n                        <hr />\n                        <p>Thank you for subscribing!</p>\n                      </div>\n                    </div>\n                </div>\n              </div>\n            </div>\n          </div>\n          <!-- /page container -->\n          </body>\n          </html>', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mc_password_resets`
--

DROP TABLE IF EXISTS `mc_password_resets`;
CREATE TABLE IF NOT EXISTS `mc_password_resets` (
  `email` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_permissions`
--

DROP TABLE IF EXISTS `mc_permissions`;
CREATE TABLE IF NOT EXISTS `mc_permissions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_roles`
--

DROP TABLE IF EXISTS `mc_roles`;
CREATE TABLE IF NOT EXISTS `mc_roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mc_roles`
--

INSERT INTO `mc_roles` (`id`, `name`, `guard_name`, `app_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', 'web', 1, 1, '2020-11-06 23:44:24', '2020-11-06 23:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `mc_role_has_permissions`
--

DROP TABLE IF EXISTS `mc_role_has_permissions`;
CREATE TABLE IF NOT EXISTS `mc_role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_campaigns`
--

DROP TABLE IF EXISTS `mc_schedule_campaigns`;
CREATE TABLE IF NOT EXISTS `mc_schedule_campaigns` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `broadcast_id` int(10) UNSIGNED DEFAULT NULL,
  `list_ids` text COLLATE utf8mb4_unicode_ci,
  `sending_server_ids` text COLLATE utf8mb4_unicode_ci,
  `send` enum('now','later') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'now',
  `send_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sending_speed` json DEFAULT NULL,
  `threads` tinyint(3) UNSIGNED NOT NULL DEFAULT '5',
  `thread_no` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `total_threads` int(10) UNSIGNED DEFAULT NULL,
  `total` int(10) UNSIGNED DEFAULT NULL,
  `scheduled` int(10) UNSIGNED DEFAULT NULL,
  `sent` int(10) UNSIGNED DEFAULT NULL,
  `scheduled_detail` json DEFAULT NULL,
  `status` enum('Preparing','Scheduled','Running','RunningLimit','Paused','Resume','System Paused','Completed') COLLATE utf8mb4_unicode_ci DEFAULT 'Preparing',
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule_campaigns_broadcast_id_foreign` (`broadcast_id`),
  KEY `schedule_campaigns_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_campaign_stats`
--

DROP TABLE IF EXISTS `mc_schedule_campaign_stats`;
CREATE TABLE IF NOT EXISTS `mc_schedule_campaign_stats` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_campaign_id` int(10) UNSIGNED DEFAULT NULL,
  `schedule_campaign_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `threads` tinyint(3) UNSIGNED NOT NULL DEFAULT '5',
  `total` int(10) UNSIGNED DEFAULT NULL,
  `scheduled` int(10) UNSIGNED DEFAULT NULL,
  `sent` int(10) UNSIGNED DEFAULT NULL,
  `scheduled_detail` json DEFAULT NULL,
  `sending_speed` json DEFAULT NULL,
  `start_datetime` timestamp NULL DEFAULT NULL,
  `end_datetime` timestamp NULL DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_campaign_stat_logs`
--

DROP TABLE IF EXISTS `mc_schedule_campaign_stat_logs`;
CREATE TABLE IF NOT EXISTS `mc_schedule_campaign_stat_logs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_campaign_stat_id` int(10) UNSIGNED DEFAULT NULL,
  `message_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `list` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `broadcast` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sending_server` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Sent','Failed','Unsubscribed','Opened','Clicked','Bounced','Spammed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scsl_id_scs_id` (`schedule_campaign_stat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_campaign_stat_log_bounces`
--

DROP TABLE IF EXISTS `mc_schedule_campaign_stat_log_bounces`;
CREATE TABLE IF NOT EXISTS `mc_schedule_campaign_stat_log_bounces` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_campaign_stat_log_id` int(10) UNSIGNED NOT NULL,
  `section` enum('Campaign','Drip','AutoFollowup','SplitTest','Add','Other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Campaign',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Soft','Hard') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Soft',
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` json DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `schedule_campaign_stat_log_bounces_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_campaign_stat_log_clicks`
--

DROP TABLE IF EXISTS `mc_schedule_campaign_stat_log_clicks`;
CREATE TABLE IF NOT EXISTS `mc_schedule_campaign_stat_log_clicks` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_campaign_stat_log_id` int(10) UNSIGNED DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `scslc_id_scs_id` (`schedule_campaign_stat_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_campaign_stat_log_opens`
--

DROP TABLE IF EXISTS `mc_schedule_campaign_stat_log_opens`;
CREATE TABLE IF NOT EXISTS `mc_schedule_campaign_stat_log_opens` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_campaign_stat_log_id` int(10) UNSIGNED DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `scslo_id_scs_id` (`schedule_campaign_stat_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_campaign_stat_log_spams`
--

DROP TABLE IF EXISTS `mc_schedule_campaign_stat_log_spams`;
CREATE TABLE IF NOT EXISTS `mc_schedule_campaign_stat_log_spams` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_campaign_stat_log_id` int(10) UNSIGNED NOT NULL,
  `section` enum('Campaign','Drip','AutoFollowup','SplitTest','Add','Other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Campaign',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` json DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_drips`
--

DROP TABLE IF EXISTS `mc_schedule_drips`;
CREATE TABLE IF NOT EXISTS `mc_schedule_drips` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drip_group_id` int(10) UNSIGNED DEFAULT NULL,
  `list_ids` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sending_server_id` int(10) UNSIGNED DEFAULT NULL,
  `send_to_existing` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `status` enum('Running','Paused') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Running',
  `in_progress` tinyint(1) NOT NULL DEFAULT '0',
  `trigger_id` bigint(20) UNSIGNED DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule_drips_drip_group_id_foreign` (`drip_group_id`),
  KEY `schedule_drips_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_drip_stats`
--

DROP TABLE IF EXISTS `mc_schedule_drip_stats`;
CREATE TABLE IF NOT EXISTS `mc_schedule_drip_stats` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_drip_id` int(10) UNSIGNED DEFAULT NULL,
  `schedule_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_drip_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drip_group_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_drip_stat_logs`
--

DROP TABLE IF EXISTS `mc_schedule_drip_stat_logs`;
CREATE TABLE IF NOT EXISTS `mc_schedule_drip_stat_logs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_drip_stat_id` int(10) UNSIGNED DEFAULT NULL,
  `drip_id` int(10) UNSIGNED DEFAULT NULL,
  `drip_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `list` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `broadcast` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sending_server` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Sent','Failed','Unsubscribed','Opened','Clicked','Bounced','Spammed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sdsl_id_scs_id` (`schedule_drip_stat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_drip_stat_log_clicks`
--

DROP TABLE IF EXISTS `mc_schedule_drip_stat_log_clicks`;
CREATE TABLE IF NOT EXISTS `mc_schedule_drip_stat_log_clicks` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_drip_stat_log_id` int(10) UNSIGNED DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sdslc_id_scs_id` (`schedule_drip_stat_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_schedule_drip_stat_log_opens`
--

DROP TABLE IF EXISTS `mc_schedule_drip_stat_log_opens`;
CREATE TABLE IF NOT EXISTS `mc_schedule_drip_stat_log_opens` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_drip_stat_log_id` int(10) UNSIGNED DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sdslo_id_scs_id` (`schedule_drip_stat_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_segments`
--

DROP TABLE IF EXISTS `mc_segments`;
CREATE TABLE IF NOT EXISTS `mc_segments` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('List','Campaign') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributes` json DEFAULT NULL,
  `is_running` tinyint(4) NOT NULL DEFAULT '0',
  `action` enum('Copy','Move','Export','Suppress','Keep Copying','Keep Moving') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `processed` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `list_id_action` int(10) UNSIGNED DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `segments_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_sending_domains`
--

DROP TABLE IF EXISTS `mc_sending_domains`;
CREATE TABLE IF NOT EXISTS `mc_sending_domains` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `domain` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `protocol` enum('http://','https://') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'https://',
  `active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `signing` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `public_key` text COLLATE utf8mb4_unicode_ci,
  `private_key` text COLLATE utf8mb4_unicode_ci,
  `verified_domain` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `verified_key` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `verified_spf` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `verified_dmarc` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `verified_tracking` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tracking` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'track',
  `dkim` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'mail',
  `dmarc` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'dmarc',
  `verification_type` enum('CNAME','htaccess') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CNAME',
  `spf_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `pmta` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sending_domains_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_sending_servers`
--

DROP TABLE IF EXISTS `mc_sending_servers`;
CREATE TABLE IF NOT EXISTS `mc_sending_servers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('php_mail','smtp','amazon_ses_api','mailgun_api','sparkpost_api','sendgrid_api','mandrill_api','elastic_email_api','mailjet_api','sendinblue_api') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'smtp',
  `status` enum('Active','Inactive','System Inactive','System Paused') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `notification` text COLLATE utf8mb4_unicode_ci,
  `from_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bounce_id` int(10) UNSIGNED DEFAULT NULL,
  `sending_attributes` json DEFAULT NULL,
  `speed_attributes` json DEFAULT NULL,
  `total_sent` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hourly_sent` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hourly_sent_next_timestamp` timestamp NULL DEFAULT NULL,
  `daily_sent` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `daily_sent_next_timestamp` timestamp NULL DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pmta` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sending_servers_group_id_foreign` (`group_id`),
  KEY `sending_servers_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_settings`
--

DROP TABLE IF EXISTS `mc_settings`;
CREATE TABLE IF NOT EXISTS `mc_settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `app_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `server_ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_version` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '2.5.1',
  `time_zone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Europe/London',
  `tracking` enum('enabled','disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enabled',
  `from_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sending_type` enum('php_mail','smtp','amazon_ses_api','mailgun_api','sparkpost_api','sendgrid_api','mandrill_api') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'php_mail',
  `sending_attributes` json DEFAULT NULL,
  `attributes` json DEFAULT NULL,
  `general_settings` json DEFAULT NULL,
  `mail_headers` longtext COLLATE utf8mb4_unicode_ci,
  `pmta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mc_settings`
--

INSERT INTO `mc_settings` (`id`, `app_name`, `app_url`, `license_key`, `server_ip`, `current_version`, `time_zone`, `tracking`, `from_email`, `sending_type`, `sending_attributes`, `attributes`, `general_settings`, `mail_headers`, `pmta`, `created_at`, `updated_at`) VALUES
(1, 'MailCarry', 'http://example.com', 'mailcarry-manual', '127.0.0.1', '2.5.1', 'Europe/London', 'enabled', 'admin@mailcarry.com', 'php_mail', NULL, '{\"login_html\": \"<img src=\\\"/storage/app/public/mc-logo-m.png\\\">\", \"login_image\": \"/storage/app/public/login_image.png\", \"top_left_html\": \"<img src=\\\"/storage/app/public/mc-logo.png\\\">\", \"cron_timestamp\": \"2019-08-30 17:00:05\"}', NULL, NULL, NULL, '2020-11-06 23:44:26', '2020-11-06 23:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `mc_spintags`
--

DROP TABLE IF EXISTS `mc_spintags`;
CREATE TABLE IF NOT EXISTS `mc_spintags` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `values` text COLLATE utf8mb4_unicode_ci,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spintags_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_suppressions`
--

DROP TABLE IF EXISTS `mc_suppressions`;
CREATE TABLE IF NOT EXISTS `mc_suppressions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `list_id` int(10) UNSIGNED DEFAULT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suppressions_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_templates`
--

DROP TABLE IF EXISTS `mc_templates`;
CREATE TABLE IF NOT EXISTS `mc_templates` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `templates_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_triggers`
--

DROP TABLE IF EXISTS `mc_triggers`;
CREATE TABLE IF NOT EXISTS `mc_triggers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `based_on` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sending_server_ids` text COLLATE utf8mb4_unicode_ci,
  `active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `attributes` longtext COLLATE utf8mb4_unicode_ci,
  `in_progress` tinyint(1) NOT NULL DEFAULT '0',
  `execution_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `triggers_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_trigger_logs`
--

DROP TABLE IF EXISTS `mc_trigger_logs`;
CREATE TABLE IF NOT EXISTS `mc_trigger_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `trigger_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_trigger_schedules`
--

DROP TABLE IF EXISTS `mc_trigger_schedules`;
CREATE TABLE IF NOT EXISTS `mc_trigger_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `trigger_id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `send_datetime` timestamp NULL DEFAULT NULL,
  `broadcast_id` int(10) UNSIGNED DEFAULT NULL,
  `sending_server_id` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trigger_schedules_contact_id_foreign` (`contact_id`),
  KEY `trigger_schedules_broadcast_id_foreign` (`broadcast_id`),
  KEY `trigger_schedules_sending_server_id_foreign` (`sending_server_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mc_users`
--

DROP TABLE IF EXISTS `mc_users`;
CREATE TABLE IF NOT EXISTS `mc_users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api` enum('Enabled','Disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Enabled',
  `language` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'US',
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_zone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Europe/London',
  `role_id` int(10) UNSIGNED NOT NULL,
  `package_id` int(10) UNSIGNED DEFAULT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `is_client` tinyint(4) NOT NULL DEFAULT '0',
  `attributes` json DEFAULT NULL,
  `active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mc_users`
--

INSERT INTO `mc_users` (`id`, `name`, `email`, `password`, `remember_token`, `api_token`, `api`, `language`, `address`, `country_code`, `phone`, `time_zone`, `role_id`, `package_id`, `parent_id`, `app_id`, `is_client`, `attributes`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'MailCarry', 'admin@mailcarry.com', '$2y$10$/uctrHlW7NFpuJQFe7SG8u138G9JC3ZRSA4Q45mS3gx9v8CjYtkdi', NULL, 'SRNeOgQsc5LDKcigiwHl44LqjdjvjI1DuEG2BmU0uCdNEjnGd1zBIuWjQ443', 'Enabled', 'en', NULL, 'US', NULL, 'Europe/London', 1, NULL, 0, 1, 0, NULL, 'Yes', '2020-11-06 23:44:24', '2020-11-06 23:44:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mc_webforms`
--

DROP TABLE IF EXISTS `mc_webforms`;
CREATE TABLE IF NOT EXISTS `mc_webforms` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duplicates` enum('Skip','Overwrite') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Skip',
  `list_id` int(10) UNSIGNED DEFAULT NULL,
  `custom_field_ids` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributes` longtext COLLATE utf8mb4_unicode_ci,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `webforms_list_id_foreign` (`list_id`),
  KEY `webforms_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mc_auto_followups`
--
ALTER TABLE `mc_auto_followups`
  ADD CONSTRAINT `auto_followups_broadcast_id_foreign` FOREIGN KEY (`broadcast_id`) REFERENCES `mc_broadcasts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auto_followups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_auto_followup_stat_logs`
--
ALTER TABLE `mc_auto_followup_stat_logs`
  ADD CONSTRAINT `afsl_id_afs_id` FOREIGN KEY (`auto_followup_stat_id`) REFERENCES `mc_auto_followup_stats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_auto_followup_stat_log_clicks`
--
ALTER TABLE `mc_auto_followup_stat_log_clicks`
  ADD CONSTRAINT `afslc_id_afsl_id` FOREIGN KEY (`auto_followup_stat_log_id`) REFERENCES `mc_auto_followup_stat_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_auto_followup_stat_log_opens`
--
ALTER TABLE `mc_auto_followup_stat_log_opens`
  ADD CONSTRAINT `afslo_id_afsl_id` FOREIGN KEY (`auto_followup_stat_log_id`) REFERENCES `mc_auto_followup_stat_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_bounces`
--
ALTER TABLE `mc_bounces`
  ADD CONSTRAINT `bounces_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_broadcasts`
--
ALTER TABLE `mc_broadcasts`
  ADD CONSTRAINT `broadcasts_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `mc_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `broadcasts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_contacts`
--
ALTER TABLE `mc_contacts`
  ADD CONSTRAINT `contacts_list_id_foreign` FOREIGN KEY (`list_id`) REFERENCES `mc_lists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_custom_fields`
--
ALTER TABLE `mc_custom_fields`
  ADD CONSTRAINT `custom_fields_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_custom_field_contact`
--
ALTER TABLE `mc_custom_field_contact`
  ADD CONSTRAINT `custom_field_contact_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `mc_contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_field_contact_custom_field_id_foreign` FOREIGN KEY (`custom_field_id`) REFERENCES `mc_custom_fields` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_custom_field_list`
--
ALTER TABLE `mc_custom_field_list`
  ADD CONSTRAINT `custom_field_list_custom_field_id_foreign` FOREIGN KEY (`custom_field_id`) REFERENCES `mc_custom_fields` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_field_list_list_id_foreign` FOREIGN KEY (`list_id`) REFERENCES `mc_lists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_drips`
--
ALTER TABLE `mc_drips`
  ADD CONSTRAINT `drips_broadcast_id_foreign` FOREIGN KEY (`broadcast_id`) REFERENCES `mc_broadcasts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `drips_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `mc_groups` (`id`),
  ADD CONSTRAINT `drips_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_fbls`
--
ALTER TABLE `mc_fbls`
  ADD CONSTRAINT `fbls_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_groups`
--
ALTER TABLE `mc_groups`
  ADD CONSTRAINT `groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_imports`
--
ALTER TABLE `mc_imports`
  ADD CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_lists`
--
ALTER TABLE `mc_lists`
  ADD CONSTRAINT `lists_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `mc_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lists_sending_server_id_foreign` FOREIGN KEY (`sending_server_id`) REFERENCES `mc_sending_servers` (`id`),
  ADD CONSTRAINT `lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_model_has_permissions`
--
ALTER TABLE `mc_model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `mc_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_model_has_roles`
--
ALTER TABLE `mc_model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `mc_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_notifications`
--
ALTER TABLE `mc_notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_role_has_permissions`
--
ALTER TABLE `mc_role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `mc_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `mc_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_schedule_campaigns`
--
ALTER TABLE `mc_schedule_campaigns`
  ADD CONSTRAINT `schedule_campaigns_broadcast_id_foreign` FOREIGN KEY (`broadcast_id`) REFERENCES `mc_broadcasts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_campaigns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_schedule_campaign_stat_logs`
--
ALTER TABLE `mc_schedule_campaign_stat_logs`
  ADD CONSTRAINT `scsl_id_scs_id` FOREIGN KEY (`schedule_campaign_stat_id`) REFERENCES `mc_schedule_campaign_stats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_schedule_campaign_stat_log_clicks`
--
ALTER TABLE `mc_schedule_campaign_stat_log_clicks`
  ADD CONSTRAINT `scslc_id_scs_id` FOREIGN KEY (`schedule_campaign_stat_log_id`) REFERENCES `mc_schedule_campaign_stat_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_schedule_campaign_stat_log_opens`
--
ALTER TABLE `mc_schedule_campaign_stat_log_opens`
  ADD CONSTRAINT `scslo_id_scs_id` FOREIGN KEY (`schedule_campaign_stat_log_id`) REFERENCES `mc_schedule_campaign_stat_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_schedule_drips`
--
ALTER TABLE `mc_schedule_drips`
  ADD CONSTRAINT `schedule_drips_drip_group_id_foreign` FOREIGN KEY (`drip_group_id`) REFERENCES `mc_groups` (`id`),
  ADD CONSTRAINT `schedule_drips_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_schedule_drip_stat_logs`
--
ALTER TABLE `mc_schedule_drip_stat_logs`
  ADD CONSTRAINT `sdsl_id_scs_id` FOREIGN KEY (`schedule_drip_stat_id`) REFERENCES `mc_schedule_drip_stats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_schedule_drip_stat_log_clicks`
--
ALTER TABLE `mc_schedule_drip_stat_log_clicks`
  ADD CONSTRAINT `sdslc_id_scs_id` FOREIGN KEY (`schedule_drip_stat_log_id`) REFERENCES `mc_schedule_drip_stat_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_schedule_drip_stat_log_opens`
--
ALTER TABLE `mc_schedule_drip_stat_log_opens`
  ADD CONSTRAINT `sdslo_id_scs_id` FOREIGN KEY (`schedule_drip_stat_log_id`) REFERENCES `mc_schedule_drip_stat_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_sending_domains`
--
ALTER TABLE `mc_sending_domains`
  ADD CONSTRAINT `sending_domains_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_sending_servers`
--
ALTER TABLE `mc_sending_servers`
  ADD CONSTRAINT `sending_servers_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `mc_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sending_servers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_spintags`
--
ALTER TABLE `mc_spintags`
  ADD CONSTRAINT `spintags_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_suppressions`
--
ALTER TABLE `mc_suppressions`
  ADD CONSTRAINT `suppressions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_templates`
--
ALTER TABLE `mc_templates`
  ADD CONSTRAINT `templates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_triggers`
--
ALTER TABLE `mc_triggers`
  ADD CONSTRAINT `triggers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mc_trigger_schedules`
--
ALTER TABLE `mc_trigger_schedules`
  ADD CONSTRAINT `trigger_schedules_broadcast_id_foreign` FOREIGN KEY (`broadcast_id`) REFERENCES `mc_broadcasts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trigger_schedules_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `mc_contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trigger_schedules_sending_server_id_foreign` FOREIGN KEY (`sending_server_id`) REFERENCES `mc_sending_servers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
