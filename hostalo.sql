-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for hostalo
CREATE DATABASE IF NOT EXISTS `hostalo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `hostalo`;

-- Dumping structure for table hostalo.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `room_id` bigint unsigned NOT NULL,
  `booking_type` enum('per_night','weekly','monthly') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'per_night',
  `assigned_room_id` bigint unsigned DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `number_of_nights` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `outstanding_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `advance_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','confirmed','cancelled','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','advance','partial','full') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `special_requests` text COLLATE utf8mb4_unicode_ci,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `customer_details` text COLLATE utf8mb4_unicode_ci,
  `nic_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nic_image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nic_verification_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_room_id_foreign` (`room_id`),
  KEY `bookings_assigned_room_id_foreign` (`assigned_room_id`),
  KEY `bookings_created_by_foreign` (`created_by`),
  CONSTRAINT `bookings_assigned_room_id_foreign` FOREIGN KEY (`assigned_room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL,
  CONSTRAINT `bookings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hostalo.bookings: ~1 rows (approximately)
INSERT INTO `bookings` (`id`, `user_id`, `room_id`, `booking_type`, `assigned_room_id`, `check_in_date`, `check_out_date`, `number_of_nights`, `total_amount`, `outstanding_balance`, `advance_amount`, `status`, `payment_status`, `special_requests`, `admin_notes`, `customer_details`, `nic_number`, `nic_image_path`, `nic_verification_notes`, `created_at`, `updated_at`, `created_by`) VALUES
	(2, 7, 5, 'per_night', 5, '2025-09-01', '2025-09-15', 14, 6818.00, 2818.00, 4000.00, 'completed', 'partial', 'Temporibus non nobisqweqewe', 'Temporibus non nobisqweqewe', '{"name":"Constance Baldwin","email":"pecaqub@mailinator.com","phone":"+1 (821) 134-9095"}', NULL, NULL, NULL, '2025-08-31 15:04:15', '2025-08-31 15:11:52', NULL);

-- Dumping structure for table hostalo.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'website',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `additional_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hostalo.contacts: ~2 rows (approximately)
INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `message`, `subject`, `source`, `status`, `additional_data`, `created_at`, `updated_at`) VALUES
	(1, 'sd', 'sd@gmail.com', '+1 (427) 788-1266', 'fsfsdfsfd', 'Room Inquiry', 'room_inquiry', 'new', '{"room_id": "3", "ip_address": "127.0.0.1", "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36", "booking_type": "monthly", "check_in_date": "2025-08-29", "check_out_date": "2025-09-12"}', '2025-08-29 03:44:28', '2025-08-29 03:44:28'),
	(2, 'Phillip Cummings', 'holacu@mailinator.com', '+1 (675) 497-5589', 'Ut nostrum ut laudan', 'Room Inquiry', 'room_inquiry', 'new', '{"room_id": "3", "ip_address": "127.0.0.1", "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36", "booking_type": "daily", "check_in_date": "2025-08-29", "check_out_date": "2025-08-30"}', '2025-08-29 06:59:37', '2025-08-29 06:59:37'),
	(3, 'Felicia Colesdf', 'qoco@mailinator.csdfom', '+1 (191) 966-319fsf6', 'dsd', 'Room Inquiry', 'room_inquiry', 'new', '{"notes": [{"note": "hhh", "added_at": "2025-08-31T17:23:49.976630Z", "added_by": 3}, {"note": "er", "added_at": "2025-09-04T20:36:01.083432Z", "added_by": 3}, {"note": "ewrwr", "added_at": "2025-09-04T20:36:05.919384Z", "added_by": 3}], "room_id": "5", "ip_address": "127.0.0.1", "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36", "booking_type": null, "check_in_date": "2025-08-31", "check_out_date": "2025-09-18"}', '2025-08-31 08:04:56', '2025-09-04 15:36:05');

-- Dumping structure for table hostalo.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hostalo.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table hostalo.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hostalo.migrations: ~16 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_08_22_161445_add_role_to_users_table', 1),
	(6, '2025_08_22_161558_add_role_to_users_table', 1),
	(7, '2025_08_22_161606_create_rooms_table', 1),
	(8, '2025_08_22_161723_create_bookings_table', 1),
	(9, '2025_08_22_165216_add_hostel_details_to_users_table', 2),
	(10, '2025_08_29_051853_add_rules_and_entered_by_to_rooms_table', 3),
	(11, '2025_08_29_052113_add_multiple_images_to_rooms_table', 3),
	(12, '2025_08_29_054018_create_contacts_table', 4),
	(13, '2025_08_29_085610_add_assigned_room_id_to_bookings_table', 5),
	(14, '2025_08_31_160638_create_payments_table', 6),
	(15, '2025_08_31_161344_add_payment_fields_to_bookings_table', 6),
	(16, '2025_08_31_193530_add_nic_fields_to_bookings_table', 7),
	(17, '2025_08_31_194509_update_role_column_in_users_table', 8),
	(18, '2025_08_31_194909_add_missing_fields_to_bookings_table', 9);

-- Dumping structure for table hostalo.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hostalo.password_resets: ~0 rows (approximately)

-- Dumping structure for table hostalo.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_type` enum('advance','partial','full') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` enum('cash','bank_transfer','credit_card','online_payment') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','completed','failed','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_booking_id_foreign` (`booking_id`),
  KEY `payments_user_id_foreign` (`user_id`),
  CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hostalo.payments: ~2 rows (approximately)
INSERT INTO `payments` (`id`, `booking_id`, `user_id`, `amount`, `payment_type`, `payment_method`, `transaction_id`, `notes`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
	(1, 2, 3, 2000.00, 'advance', 'cash', NULL, 'Advance payment for direct booking', 'completed', NULL, '2025-08-31 15:04:15', '2025-08-31 15:04:15'),
	(2, 2, 3, 2000.00, 'partial', 'cash', NULL, NULL, 'completed', '2025-08-31 15:11:52', '2025-08-31 15:11:52', '2025-08-31 15:11:52');

-- Dumping structure for table hostalo.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hostalo.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table hostalo.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `capacity` int NOT NULL,
  `room_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `amenities` json DEFAULT NULL,
  `rules` text COLLATE utf8mb4_unicode_ci,
  `entered_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rooms_user_id_foreign` (`user_id`),
  KEY `rooms_entered_by_foreign` (`entered_by`),
  CONSTRAINT `rooms_entered_by_foreign` FOREIGN KEY (`entered_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rooms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hostalo.rooms: ~1 rows (approximately)
INSERT INTO `rooms` (`id`, `user_id`, `name`, `description`, `price_per_night`, `capacity`, `room_type`, `image`, `images`, `is_available`, `amenities`, `rules`, `entered_by`, `created_at`, `updated_at`) VALUES
	(5, 3, 'Stephen Mercado', 'Perferendis mollitia', 487.00, 14, 'private', 'uploads/rooms/1756640425_WhatsApp Image 2025-08-16 at 10.15.11 PM.jpeg', '[{}, {}, {}, {}, {}]', 1, '["WiFi", "Heater", "Fan", "Balcony", "Wardrobe", "Desk", "Laundry"]', 'Repellendus Blandit', 3, '2025-08-31 06:40:25', '2025-08-31 06:40:25');

-- Dumping structure for table hostalo.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_description` text COLLATE utf8mb4_unicode_ci,
  `hostel_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_gallery` json DEFAULT NULL,
  `business_license` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_type` enum('budget','mid-range','luxury') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_rooms` int DEFAULT NULL,
  `check_in_time` time NOT NULL DEFAULT '14:00:00',
  `check_out_time` time NOT NULL DEFAULT '11:00:00',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amenities` json DEFAULT NULL,
  `policies` json DEFAULT NULL,
  `special_offers` text COLLATE utf8mb4_unicode_ci,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verified_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hostalo.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `address`, `nic`, `hostel_name`, `hostel_description`, `hostel_address`, `hostel_phone`, `hostel_email`, `hostel_website`, `hostel_logo`, `hostel_banner`, `hostel_gallery`, `business_license`, `tax_number`, `hostel_type`, `total_rooms`, `check_in_time`, `check_out_time`, `latitude`, `longitude`, `city`, `state`, `country`, `postal_code`, `facebook_url`, `instagram_url`, `twitter_url`, `amenities`, `policies`, `special_offers`, `is_verified`, `verified_at`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'shahid', 'shahid@gmail.com', 'user', '+1 (427) 788-1266', 'asif nager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '14:00:00', '11:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$X49CO5GYUATFGV4pbc4yduvbfhA5dwOQ4seCQ1LmjDYmHFvdIGKJa', NULL, '2025-08-22 11:42:18', '2025-08-22 11:42:18'),
	(3, 'Felicia Cole', 'qoco@mailinator.com', 'user', '+1 (191) 966-3196', 'Molestiae eos sed la', '181', 'Lucy Gates', 'A veniam maiores do', 'Qui quo ipsum quos a', '+1 (508) 133-7754', 'xiqeq@mailinator.com', 'https://www.rugon.me.uk', 'uploads/hostels/logos/1755891068_logo_Cam_01_cb63194762.jpg', 'uploads/hostels/banners/1755891068_banner_Cam_10_a937e7e235.jpg', '["uploads/hostels/gallery/1755891068_gallery_68a8c57c9ccfa.jpg", "uploads/hostels/gallery/1755891068_gallery_68a8c57c9dc24.jpg", "uploads/hostels/gallery/1755891068_gallery_68a8c57c9e84b.jpg", "uploads/hostels/gallery/1755891068_gallery_68a8c57c9f191.jpg"]', '448', '161', 'luxury', 81, '04:00:00', '01:39:00', 90.00000000, -90.00000000, 'Maxime earum nobis q', 'Aut do dolorem natus', 'Expedita qui pariatu', 'Non molestiae autem', NULL, NULL, NULL, '[]', '[]', 'Et cumque culpa volu', 1, '2025-08-22 14:21:52', NULL, '$2y$10$LwRQQdR3GComy9DZ8/lwUufNrowPWZSD7gn7q6Nxk4raRSaeXcSmW', NULL, '2025-08-22 14:17:50', '2025-08-31 06:34:40'),
	(4, 'admin', 'admin@hostalo.com', 'user', '02233', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '14:00:00', '11:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$Fb14XGycnFmYEOxvmz9eY.jZOrR.DHgjDhktcCiM1wQV/ll2vhQie', NULL, '2025-08-31 06:33:00', '2025-08-31 06:33:00'),
	(7, 'Constance Baldwin', 'pecaqub@mailinator.com', 'customer', '+1 (821) 134-9095', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '14:00:00', '11:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$G0o0MGf2PBbjW3q8duDureCvxDlhsEoZzQcEHPCYpdeQky3R7ofma', NULL, '2025-08-31 15:04:15', '2025-08-31 15:04:15');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
