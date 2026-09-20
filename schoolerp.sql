-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2026 at 05:09 AM
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
-- Database: `schoolerp`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_sections`
--

CREATE TABLE `about_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `feature_1_title` varchar(255) DEFAULT NULL,
  `feature_1_desc` text DEFAULT NULL,
  `feature_2_title` varchar(255) DEFAULT NULL,
  `feature_2_desc` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) NOT NULL DEFAULT 'Details',
  `button_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `academicyears`
--

CREATE TABLE `academicyears` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academicyears`
--

INSERT INTO `academicyears` (`id`, `school_id`, `name`, `start_date`, `end_date`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '2026', '2026-01-01', '2026-12-31', 1, NULL, '2026-08-21 12:05:53', '2026-08-21 12:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `admission_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `previous_school` varchar(255) DEFAULT NULL,
  `previous_class` varchar(255) DEFAULT NULL,
  `fathers_name` varchar(255) NOT NULL,
  `mothers_name` varchar(255) NOT NULL,
  `father_nid` varchar(255) DEFAULT NULL,
  `mother_nid` varchar(255) DEFAULT NULL,
  `student_birth_nid` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assign_classes`
--

CREATE TABLE `assign_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `school_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `full_mark` varchar(255) DEFAULT NULL,
  `pass_mark` varchar(255) DEFAULT NULL,
  `theory_full_mark` decimal(8,2) DEFAULT NULL,
  `theory_pass_mark` decimal(8,2) DEFAULT NULL,
  `practical_full_mark` decimal(8,2) DEFAULT NULL,
  `practical_pass_mark` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assign_classes`
--

INSERT INTO `assign_classes` (`id`, `school_id`, `school_category_id`, `school_sub_category_id`, `class_id`, `subject_id`, `full_mark`, `pass_mark`, `theory_full_mark`, `theory_pass_mark`, `practical_full_mark`, `practical_pass_mark`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, '100', '33', NULL, NULL, NULL, NULL, '2026-08-21 12:11:12', '2026-08-21 12:11:12'),
(2, 1, 1, 1, 1, 2, '100', '33', NULL, NULL, NULL, NULL, '2026-08-21 12:11:32', '2026-08-21 12:11:32'),
(3, 1, 1, 1, 1, 3, '100', '33', NULL, NULL, NULL, NULL, '2026-08-21 12:11:47', '2026-08-21 12:11:47'),
(4, 1, 1, 1, 2, 1, '100', '33', NULL, NULL, NULL, NULL, '2026-08-21 12:12:04', '2026-08-21 12:12:04'),
(5, 1, 1, 1, 2, 2, '100', '33', NULL, NULL, NULL, NULL, '2026-08-21 12:16:18', '2026-08-21 12:16:18'),
(6, 1, 2, 2, 6, 1, '100', '33', NULL, NULL, NULL, NULL, '2026-08-21 13:43:22', '2026-08-21 13:43:22'),
(7, 1, 2, 2, 6, 4, '50', '17', NULL, NULL, NULL, NULL, '2026-08-21 13:43:38', '2026-08-21 13:43:38'),
(8, 1, 2, 2, 6, 2, '100', '33', NULL, NULL, NULL, NULL, '2026-08-21 13:43:54', '2026-08-21 13:43:54'),
(9, 1, 2, 2, 6, 5, '50', '17', NULL, NULL, NULL, NULL, '2026-08-21 13:44:15', '2026-08-21 13:44:15'),
(10, 1, 2, 2, 6, 3, '100', '33', NULL, NULL, NULL, NULL, '2026-08-21 13:44:32', '2026-08-21 13:44:32'),
(11, 1, 2, 2, 6, 6, '100', '33', NULL, NULL, NULL, NULL, '2026-08-21 14:43:32', '2026-08-21 14:43:32'),
(12, 1, 3, NULL, 9, 1, '100', '33', NULL, NULL, NULL, NULL, '2026-08-22 18:47:26', '2026-08-22 18:47:26'),
(13, 1, 3, NULL, 9, 2, '100', '33', NULL, NULL, NULL, NULL, '2026-08-22 18:47:42', '2026-08-22 18:47:42'),
(14, 1, 3, NULL, 9, 3, '100', '33', NULL, NULL, NULL, NULL, '2026-08-22 18:47:55', '2026-08-22 18:47:55'),
(15, 1, 3, 3, 9, 11, '100', '33', NULL, NULL, NULL, NULL, '2026-08-22 18:50:36', '2026-08-22 18:50:36'),
(16, 1, 3, 3, 9, 8, '100', '33', NULL, NULL, NULL, NULL, '2026-08-22 18:50:52', '2026-08-22 18:50:52'),
(17, 1, 3, 3, 9, 7, '100', '33', NULL, NULL, NULL, NULL, '2026-08-22 18:51:09', '2026-08-22 18:51:09'),
(18, 1, 3, 4, 9, 6, '100', '33', NULL, NULL, NULL, NULL, '2026-08-22 18:51:23', '2026-08-22 18:51:23'),
(19, 1, 3, 4, 9, 9, '100', '33', NULL, NULL, NULL, NULL, '2026-08-22 18:51:36', '2026-08-22 18:51:36'),
(20, 1, 3, 4, 9, 10, '100', '33', NULL, NULL, NULL, NULL, '2026-08-22 18:51:51', '2026-08-22 18:51:51');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `blog_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `author` varchar(255) NOT NULL DEFAULT 'Admin',
  `content` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `image`, `blog_category_id`, `category`, `author`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 'স্মার্ট স্কুল ম্যানেজমেন্ট সিস্টেমের সুবিধা ও কার্যকারিতা', 'smart-school-management-system-benefits', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop', 1, 'শিক্ষা প্রযুক্তি', 'এডমিন', 'একটি আধুনিক ও প্রযুক্তি নির্ভর শিক্ষা প্রতিষ্ঠান পরিচালনায় ইআরপি সফটওয়্যারের ভূমিকা অপরিসীম। এটি শিক্ষক, শিক্ষার্থী এবং অভিভাবকদের কাজের সমন্বয় সহজ করে। ডিজিটাল অ্যাটেনডেন্স থেকে শুরু করে অনলাইন ফি আদায়, রেজাল্ট শিট প্রস্তুত করা সহ স্কুলের প্রতিদিনের কার্যক্রমকে স্বয়ংক্রিয় ও নির্ভুল করে তোলে।', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(2, 'শিক্ষার্থীদের মনোযোগ বৃদ্ধিতে শিক্ষকদের ভূমিকা', 'teachers-role-in-boosting-student-focus', 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=800&auto=format&fit=crop', 2, 'পরামর্শ', 'ফারহানা রহমান', 'শ্রেণীকক্ষে শিক্ষার্থীদের মনোযোগ আকর্ষণ ও তা ধরে রাখা প্রতিটি শিক্ষকের জন্যই একটি বড় চ্যালেঞ্জ। আধুনিক শিক্ষা পদ্ধতিতে মুখস্থ বিদ্যার চেয়ে ইন্টারেক্টিভ লার্নিং বা প্রশ্নোত্তরের মাধ্যমে পাঠদান করা বেশি কার্যকর। এছাড়া মাঝে মাঝে ছোট গ্রুপ স্টাডি বা কুইজের আয়োজন করলে শিক্ষার্থীরা পড়ালেখায় বেশি মনোযোগী হয়।', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(3, 'নতুন শিক্ষাবর্ষের বার্ষিক ক্রীড়া প্রতিযোগিতা ও পুরষ্কার বিতরণী', 'annual-sports-competition-new-academic-year', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800&auto=format&fit=crop', 3, 'ইভেন্ট', 'ক্রীড়া শিক্ষক', 'উৎসাহ ও উদ্দীপনার মধ্য দিয়ে উদযাপিত হলো আমাদের প্রতিষ্ঠানের বার্ষিক ক্রীড়া প্রতিযোগিতা। শিক্ষার্থীরা বিভিন্ন খেলাধূলায় অংশ নিয়ে তাদের প্রতিভা প্রদর্শন করেছে। প্রতিযোগিতা শেষে স্কুলের অধ্যক্ষ মহোদয় বিজয়ী শিক্ষার্থীদের হাতে মেডেল ও চ্যাম্পিয়ন ট্রফি তুলে দেন।', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(4, 'ডিজিটাল ক্লাসরুম যেভাবে পাঠদানকে সহজ করছে', 'how-digital-classrooms-simplify-teaching', 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop', 4, 'ডিজিটাল শিক্ষা', 'সাকিব আল হাসান', 'প্রজেক্টর ও মাল্টিমিডিয়া ক্লাসরুমের ব্যবহার শিক্ষার্থীদের পড়া সহজে বুঝতে এবং দীর্ঘক্ষণ মনে রাখতে দারুণ সহায়তা করছে। জটিল বৈজ্ঞানিক ফর্মুলা বা ঐতিহাসিক ঘটনাগুলো ভিডিও চিত্রের মাধ্যমে দেখানোর ফলে শিক্ষার্থীরা ক্লাসের পড়া দ্রুত আত্মস্থ করতে পারছে, যা ঐতিহ্যবাহী পাঠদানের চেয়ে অনেক বেশি কার্যকর।', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(5, 'অভিভাবক-শিক্ষক সভা: শিক্ষার্থীদের সার্বিক উন্নয়ন নিশ্চিতকরণ', 'parent-teacher-meeting-ensuring-student-growth', 'https://images.unsplash.com/photo-1544531516-a5e34e2d3df3?q=80&w=800&auto=format&fit=crop', 5, 'নোটিশ', 'অধ্যক্ষ', 'শিক্ষার্থীদের পড়ালেখার মানোন্নয়ন ও আচরণগত উন্নতির লক্ষ্যে অভিভাবক ও শিক্ষক মতবিনিময় সভার আয়োজন করা হয়েছিল। সভায় শিক্ষকদের পক্ষ থেকে শিক্ষার্থীদের দুর্বলতা ও শক্তিগুলো তুলে ধরা হয় এবং অভিভাবকেরা তাদের মূল্যবান মতামত শেয়ার করেন। সম্মিলিত প্রচেষ্টায় শিক্ষার্থীদের আগামী দিনে এগিয়ে নেওয়ার সিদ্ধান্ত গৃহীত হয়।', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(6, 'পরীক্ষার ভীতি দূর করার ৫টি সহজ বৈজ্ঞানিক উপায়', '5-scientific-ways-to-reduce-exam-fear', 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800&auto=format&fit=crop', 6, 'শিক্ষার্থী কর্নার', 'ডা. আরমান হোসেন', 'পরীক্ষার আগে মানসিক চাপ কমানো এবং স্মৃতিশক্তি বৃদ্ধির জন্য কার্যকরী কিছু বৈজ্ঞানিক টিপস রয়েছে। প্রথমত, নিয়মিত ও পর্যাপ্ত ঘুম নিশ্চিত করা। দ্বিতীয়ত, পড়ার মাঝে ছোট বিরতি (পোমোডোরো টেকনিক) নেওয়া। তৃতীয়ত, গ্রুপ ডিসকাশন করা এবং quarto, রিভিশনের জন্য ফ্ল্যাশকার্ড ব্যবহার করা।', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'শিক্ষা প্রযুক্তি (EdTech)', 'edtech', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(2, 'পরামর্শ (Tips/Guides)', 'tips-guides', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(3, 'ইভেন্ট (Events)', 'events', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(4, 'ডিজিটাল শিক্ষা (Digital Learning)', 'digital-learning', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(5, 'নোটিশ (Announcements)', 'announcements', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(6, 'শিক্ষার্থী কর্নার (Student Corner)', 'student-corner', 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('educorexa-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:7:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"group_name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";s:1:\"j\";s:9:\"role_type\";s:1:\"m\";s:9:\"school_id\";}s:11:\"permissions\";a:82:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:20:\"academic-year.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:15:\"category.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:19:\"sub-category.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"class.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:14:\"section.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:14:\"subject.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"assign.subject\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:13:\"class.routine\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"syllabus.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:11:\"lesson.view\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:13:\"lesson.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:15:\"homework.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:13:\"syllabus.view\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"syllabus.download\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:15:\"syllabus.upload\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"syllabus.delete\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"syllabus.approve\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:15:\"syllabus.reject\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:22:\"syllabus.view_rejected\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:22:\"syllabus.view_approved\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:16:\"admission.manage\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:13:\"student.index\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:14:\"student.create\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"student.edit\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:14:\"student.delete\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:14:\"student.manage\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:14:\"student.idcard\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:17:\"student.promotion\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:14:\"teacher.manage\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:29;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:14:\"assign.teacher\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:15:\"employee.manage\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:18:\"designation.manage\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:14:\"payroll.manage\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:12:\"leave.manage\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:34;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:17:\"attendance.manage\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:35;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:17:\"attendance.report\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:36;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"payroll.report\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:37;a:5:{s:1:\"a\";i:38;s:1:\"b\";s:12:\"staff.report\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:38;a:5:{s:1:\"a\";i:39;s:1:\"b\";s:12:\"staff.idcard\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:39;a:5:{s:1:\"a\";i:40;s:1:\"b\";s:15:\"staff.promotion\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:40;a:5:{s:1:\"a\";i:41;s:1:\"b\";s:14:\"staff.transfer\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:41;a:5:{s:1:\"a\";i:42;s:1:\"b\";s:17:\"staff.termination\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:42;a:5:{s:1:\"a\";i:43;s:1:\"b\";s:11:\"staff.leave\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:43;a:5:{s:1:\"a\";i:44;s:1:\"b\";s:16:\"staff.attendance\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:44;a:5:{s:1:\"a\";i:45;s:1:\"b\";s:13:\"staff.payroll\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:45;a:5:{s:1:\"a\";i:46;s:1:\"b\";s:20:\"attendance.analytics\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:46;a:5:{s:1:\"a\";i:47;s:1:\"b\";s:14:\"holiday.manage\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:47;a:5:{s:1:\"a\";i:48;s:1:\"b\";s:11:\"exam.manage\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:48;a:5:{s:1:\"a\";i:49;s:1:\"b\";s:11:\"mark.manage\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:49;a:5:{s:1:\"a\";i:50;s:1:\"b\";s:15:\"exam.admit_card\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:50;a:5:{s:1:\"a\";i:51;s:1:\"b\";s:10:\"fee.manage\";s:1:\"c\";s:14:\"Finance (Fees)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:51;a:5:{s:1:\"a\";i:52;s:1:\"b\";s:11:\"fee.collect\";s:1:\"c\";s:14:\"Finance (Fees)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:52;a:5:{s:1:\"a\";i:53;s:1:\"b\";s:10:\"fee.report\";s:1:\"c\";s:14:\"Finance (Fees)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:53;a:5:{s:1:\"a\";i:54;s:1:\"b\";s:13:\"notice.manage\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:54;a:5:{s:1:\"a\";i:55;s:1:\"b\";s:13:\"slider.manage\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:55;a:5:{s:1:\"a\";i:56;s:1:\"b\";s:14:\"gallery.manage\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:56;a:5:{s:1:\"a\";i:57;s:1:\"b\";s:14:\"message.manage\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:57;a:5:{s:1:\"a\";i:58;s:1:\"b\";s:8:\"sms.send\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:58;a:5:{s:1:\"a\";i:59;s:1:\"b\";s:10:\"email.send\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:59;a:5:{s:1:\"a\";i:60;s:1:\"b\";s:13:\"whatsapp.send\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:60;a:5:{s:1:\"a\";i:61;s:1:\"b\";s:17:\"newsletter.manage\";s:1:\"c\";s:8:\"Settings\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:61;a:5:{s:1:\"a\";i:62;s:1:\"b\";s:15:\"system.settings\";s:1:\"c\";s:8:\"Settings\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:62;a:5:{s:1:\"a\";i:63;s:1:\"b\";s:13:\"school.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:9;}}i:63;a:5:{s:1:\"a\";i:64;s:1:\"b\";s:13:\"school.create\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:9;}}i:64;a:5:{s:1:\"a\";i:65;s:1:\"b\";s:14:\"school.approve\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:5:{s:1:\"a\";i:66;s:1:\"b\";s:15:\"frontend.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:5:{s:1:\"a\";i:67;s:1:\"b\";s:13:\"school.reject\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:5:{s:1:\"a\";i:68;s:1:\"b\";s:13:\"school.delete\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:5:{s:1:\"a\";i:69;s:1:\"b\";s:15:\"settings.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:5:{s:1:\"a\";i:70;s:1:\"b\";s:18:\"super.roles.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:5:{s:1:\"a\";i:71;s:1:\"b\";s:21:\"contact.messages.view\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:5:{s:1:\"a\";i:72;s:1:\"b\";s:19:\"testimonial.approve\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:5:{s:1:\"a\";i:73;s:1:\"b\";s:14:\"support.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:5:{s:1:\"a\";i:74;s:1:\"b\";s:18:\"support.bot.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:12:\"batch.manage\";s:1:\"c\";s:15:\"Coaching Center\";s:1:\"d\";s:3:\"web\";}i:75;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:23:\"coaching.student.manage\";s:1:\"c\";s:15:\"Coaching Center\";s:1:\"d\";s:3:\"web\";}i:76;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:23:\"coaching.teacher.manage\";s:1:\"c\";s:15:\"Coaching Center\";s:1:\"d\";s:3:\"web\";}i:77;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:26:\"coaching.attendance.manage\";s:1:\"c\";s:15:\"Coaching Center\";s:1:\"d\";s:3:\"web\";}i:78;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:20:\"coaching.exam.manage\";s:1:\"c\";s:15:\"Coaching Center\";s:1:\"d\";s:3:\"web\";}i:79;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:20:\"coaching.mark.manage\";s:1:\"c\";s:15:\"Coaching Center\";s:1:\"d\";s:3:\"web\";}i:80;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:19:\"coaching.fee.manage\";s:1:\"c\";s:15:\"Coaching Center\";s:1:\"d\";s:3:\"web\";}i:81;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:22:\"coaching.notice.manage\";s:1:\"c\";s:15:\"Coaching Center\";s:1:\"d\";s:3:\"web\";}}s:5:\"roles\";a:3:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super_admin\";s:1:\"d\";s:3:\"web\";s:1:\"j\";s:8:\"employee\";s:1:\"m\";N;}i:1;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"school_admin\";s:1:\"d\";s:3:\"web\";s:1:\"j\";s:12:\"school_staff\";s:1:\"m\";N;}i:2;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:14:\"Representative\";s:1:\"d\";s:3:\"web\";s:1:\"j\";s:8:\"employee\";s:1:\"m\";N;}}}', 1789233040);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `school_id`, `name`, `code`, `description`, `created_at`, `updated_at`, `school_category_id`) VALUES
(1, 1, 'One', '01', NULL, '2026-08-21 12:07:21', '2026-08-21 12:07:21', 1),
(2, 1, 'Two', '02', NULL, '2026-08-21 12:07:46', '2026-08-21 12:07:46', 1),
(3, 1, 'Three', '03', NULL, '2026-08-21 12:07:57', '2026-08-21 12:07:57', 1),
(4, 1, 'Four', '04', NULL, '2026-08-21 12:08:16', '2026-08-21 12:08:16', 1),
(5, 1, 'Five', '05', NULL, '2026-08-21 12:08:29', '2026-08-21 12:08:29', 1),
(6, 1, 'Six', '06', NULL, '2026-08-21 12:08:48', '2026-08-21 12:09:10', 2),
(7, 1, 'Seven', '07', NULL, '2026-08-21 12:09:02', '2026-08-21 12:09:02', 2),
(8, 1, 'Eight', '08', NULL, '2026-08-21 12:09:22', '2026-08-21 12:09:22', 2),
(9, 1, 'Nine', '09', NULL, '2026-08-22 18:47:07', '2026-08-22 18:47:07', 3);

-- --------------------------------------------------------

--
-- Table structure for table `communication_settings`
--

CREATE TABLE `communication_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `event` varchar(255) NOT NULL,
  `email_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `sms_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `whatsapp_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `email_template` text DEFAULT NULL,
  `sms_template` text DEFAULT NULL,
  `whatsapp_template` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `communication_settings`
--

INSERT INTO `communication_settings` (`id`, `school_id`, `event`, `email_enabled`, `sms_enabled`, `whatsapp_enabled`, `email_template`, `sms_template`, `whatsapp_template`, `created_at`, `updated_at`) VALUES
(1, 1, 'fee_reminder', 0, 0, 0, 'Dear [student_name],\n\nThis is a friendly reminder that your [fee_name] for the month of [month] amounting to ৳[fee_amount] is currently unpaid.\n\nPlease pay at your earliest convenience.\n\nThank you,\n[school_name]', 'Dear [student_name], your [fee_name] of ৳[fee_amount] for [month] is unpaid. Please pay soon. - [school_name]', 'Dear [student_name],\nYour [fee_name] of ৳[fee_amount] for [month] is unpaid.\nPlease pay soon.\n- [school_name]', '2026-08-21 21:44:38', '2026-08-21 21:44:38'),
(2, 1, 'attendance', 0, 0, 0, 'Dear Parent,\n\nYour child [student_name] was marked [status] today ([date]).\n\nRegards,\n[school_name]', 'Dear Parent, [student_name] is [status] today ([date]). - [school_name]', 'Dear Parent,\n[student_name] is [status] today ([date]).\n- [school_name]', '2026-08-21 21:44:38', '2026-08-21 21:44:38'),
(3, 1, 'notice', 0, 0, 0, 'Dear [student_name],\n\nNotice: [notice_title]\n\nPlease check the portal for more details.\n\nRegards,\n[school_name]', 'Notice: [notice_title]. Check portal for details. - [school_name]', 'Dear [student_name],\n*Notice:* [notice_title]\nPlease check the portal for details.\n- [school_name]', '2026-08-21 21:44:38', '2026-08-21 21:44:38'),
(4, 1, 'result_published', 0, 0, 0, 'Dear [student_name],\n\nThe result for [exam_name] has been published. Please check the student portal.\n\nRegards,\n[school_name]', 'Result for [exam_name] of [student_name] has been published. Please check the portal. - [school_name]', 'Dear [student_name],\nThe result for [exam_name] has been published. Please check the portal.\n- [school_name]', '2026-09-03 16:58:07', '2026-09-03 16:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `phone_personal` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `salary` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commission_type` enum('flat','percentage') NOT NULL DEFAULT 'flat',
  `commission_rate` decimal(8,2) NOT NULL DEFAULT 0.00,
  `monthly_commission_type` enum('flat','percentage') NOT NULL DEFAULT 'flat',
  `monthly_commission_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `employee_id`, `designation`, `phone_personal`, `address`, `joining_date`, `salary`, `commission_type`, `commission_rate`, `monthly_commission_type`, `monthly_commission_rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 16, 'REP-2026001', 'Sales Representative', '01766236788', 'জেলা: Nilphamari | ঠিকানা: sff we ff | কারণ: ffsfwf dvv', '2026-09-10', 0.00, 'flat', 0.00, 'flat', 0.00, 'active', '2026-09-10 04:54:11', '2026-09-10 04:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_time` time DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT 'blue',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `school_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `school_id`, `school_category_id`, `year_id`, `name`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `is_published`, `published_at`) VALUES
(1, 1, 2, 1, 'Half Yearly Exam', '2026-07-01', '2026-07-16', 0, '2026-08-21 12:25:04', '2026-08-21 13:48:31', 1, NULL),
(2, 1, 1, 1, 'First Term Exam', '2026-04-18', '2026-04-29', 0, '2026-08-21 12:28:28', '2026-08-21 12:46:57', 1, NULL),
(3, 1, 1, 1, 'প্রাক-নির্বাচনী পরীক্ষা (Pre-Test Exam)', '2026-07-22', '2026-07-30', 0, '2026-08-21 12:34:28', '2026-08-21 12:46:34', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_categories`
--

CREATE TABLE `exam_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `school_category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_categories`
--

INSERT INTO `exam_categories` (`id`, `exam_id`, `school_category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2026-08-28 19:19:06', '2026-08-28 19:19:06'),
(2, 2, 1, '2026-08-28 19:19:06', '2026-08-28 19:19:06'),
(3, 3, 1, '2026-08-28 19:19:06', '2026-08-28 19:19:06'),
(4, 1, 3, '2026-08-28 19:24:50', '2026-08-28 19:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `exam_routines`
--

CREATE TABLE `exam_routines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `exam_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_routines`
--

INSERT INTO `exam_routines` (`id`, `school_id`, `academic_year_id`, `exam_id`, `class_id`, `subject_id`, `exam_date`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 1, 6, 1, '2026-08-22', NULL, NULL, '2026-08-22 14:42:38', '2026-08-22 14:42:38'),
(5, 1, 1, 1, 6, 4, '2026-08-23', NULL, NULL, '2026-08-22 14:42:38', '2026-08-22 14:42:38'),
(6, 1, 1, 1, 6, 2, '2026-08-24', NULL, NULL, '2026-08-22 14:42:38', '2026-08-22 14:42:38'),
(7, 1, 1, 1, 6, 5, '2026-08-25', NULL, NULL, '2026-08-22 14:42:38', '2026-08-22 14:42:38'),
(8, 1, 1, 1, 6, 3, '2026-08-26', NULL, NULL, '2026-08-22 14:42:38', '2026-08-22 14:42:38'),
(9, 1, 1, 1, 6, 6, '2026-08-27', NULL, NULL, '2026-08-22 14:42:38', '2026-08-22 14:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_amounts`
--

CREATE TABLE `fee_amounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `fee_head_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `school_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_amounts`
--

INSERT INTO `fee_amounts` (`id`, `school_id`, `fee_head_id`, `class_id`, `school_category_id`, `school_sub_category_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, NULL, 200.00, '2026-08-30 07:47:53', '2026-08-30 07:47:53'),
(2, 1, 1, 2, 1, NULL, 200.00, '2026-08-30 07:47:53', '2026-08-30 07:47:53'),
(3, 1, 1, 3, 1, NULL, 250.00, '2026-08-30 07:47:53', '2026-08-30 07:47:53'),
(4, 1, 1, 4, 1, NULL, 250.00, '2026-08-30 07:47:53', '2026-08-30 07:47:53'),
(5, 1, 1, 5, 1, NULL, 300.00, '2026-08-30 07:47:53', '2026-08-30 07:47:53'),
(6, 1, 2, 1, 1, NULL, 1000.00, '2026-09-04 16:22:01', '2026-09-04 16:22:01'),
(7, 1, 2, 2, 1, NULL, 1000.00, '2026-09-04 16:22:01', '2026-09-04 16:22:01'),
(8, 1, 2, 3, 1, NULL, 1200.00, '2026-09-04 16:22:01', '2026-09-04 16:22:01'),
(9, 1, 2, 4, 1, NULL, 1300.00, '2026-09-04 16:22:01', '2026-09-04 16:22:01'),
(10, 1, 2, 5, 1, NULL, 1500.00, '2026-09-04 16:22:01', '2026-09-04 16:22:01');

-- --------------------------------------------------------

--
-- Table structure for table `fee_heads`
--

CREATE TABLE `fee_heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('monthly','once','recurring') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_heads`
--

INSERT INTO `fee_heads` (`id`, `school_id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 'Exam Fee', 'recurring', '2026-08-30 07:47:08', '2026-08-30 07:47:08'),
(2, 1, 'Admission Fee', 'recurring', '2026-09-02 11:35:52', '2026-09-02 11:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `footer_settings`
--

CREATE TABLE `footer_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `newsletter_text` text DEFAULT NULL,
  `copyright_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_sections`
--

CREATE TABLE `frontend_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontend_sections`
--

INSERT INTO `frontend_sections` (`id`, `key`, `title`, `status`, `content`, `order`, `created_at`, `updated_at`) VALUES
(1, 'hero', 'Hero Section', 1, NULL, 1, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(2, 'features', 'Features Section', 1, NULL, 2, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(3, 'why_choose_us', 'Why Choose Us', 1, NULL, 3, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(4, 'setup-section', 'Setup Section', 1, NULL, 4, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(5, 'pricing', 'Pricing Table', 1, NULL, 5, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(6, 'about', 'About Us', 1, NULL, 6, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(7, 'testimonials', 'Testimonials', 1, NULL, 7, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(8, 'contact', 'Contact Section', 1, NULL, 8, '2026-08-21 11:51:41', '2026-08-21 11:51:41'),
(9, 'blogs', 'Blog Slider', 1, '\"{\\\"badge_text\\\":\\\"\\\\u0986\\\\u09ae\\\\u09be\\\\u09a6\\\\u09c7\\\\u09b0 \\\\u09ac\\\\u09cd\\\\u09b2\\\\u0997 \\\\u0993 \\\\u0996\\\\u09ac\\\\u09b0\\\",\\\"title\\\":\\\"\\\\u09b8\\\\u09b0\\\\u09cd\\\\u09ac\\\\u09b6\\\\u09c7\\\\u09b7 \\\\u0986\\\\u09aa\\\\u09a1\\\\u09c7\\\\u099f \\\\u0993 \\\\u09b6\\\\u09bf\\\\u0995\\\\u09cd\\\\u09b7\\\\u09be\\\\u09ae\\\\u09c2\\\\u09b2\\\\u0995 \\\\u09aa\\\\u09cd\\\\u09b0\\\\u09ac\\\\u09a8\\\\u09cd\\\\u09a7\\\",\\\"description\\\":\\\"\\\\u0986\\\\u09ae\\\\u09be\\\\u09a6\\\\u09c7\\\\u09b0 \\\\u09aa\\\\u09cd\\\\u09b0\\\\u09a4\\\\u09bf\\\\u09b7\\\\u09cd\\\\u09a0\\\\u09be\\\\u09a8\\\\u09c7\\\\u09b0 \\\\u09b8\\\\u09b0\\\\u09cd\\\\u09ac\\\\u09b6\\\\u09c7\\\\u09b7 \\\\u0996\\\\u09ac\\\\u09b0, \\\\u0998\\\\u099f\\\\u09a8\\\\u09be \\\\u098f\\\\u09ac\\\\u0982 \\\\u09b6\\\\u09bf\\\\u0995\\\\u09cd\\\\u09b7\\\\u09be\\\\u09ae\\\\u09c2\\\\u09b2\\\\u0995 \\\\u09ac\\\\u09cd\\\\u09b2\\\\u0997 \\\\u09aa\\\\u09cb\\\\u09b8\\\\u09cd\\\\u099f\\\\u0997\\\\u09c1\\\\u09b2\\\\u09cb \\\\u098f\\\\u0996\\\\u09be\\\\u09a8\\\\u09c7 \\\\u09aa\\\\u09dc\\\\u09c1\\\\u09a8\\\\u0964\\\"}\"', 9, '2026-08-21 11:51:41', '2026-08-21 11:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `id_card_designs`
--

CREATE TABLE `id_card_designs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `header_shape` varchar(255) DEFAULT NULL,
  `gradient_bar` varchar(255) DEFAULT NULL,
  `pattern` varchar(255) DEFAULT NULL,
  `primary_color` varchar(255) NOT NULL DEFAULT '#6a1b9a',
  `badge_color` varchar(255) NOT NULL DEFAULT '#6a1b9a',
  `label_color` varchar(255) NOT NULL DEFAULT '#7b1fa2',
  `photo_border_color` varchar(255) NOT NULL DEFAULT '#ab47bc',
  `back_header_bg` varchar(255) NOT NULL DEFAULT '#f3e5f5',
  `back_header_text` varchar(255) NOT NULL DEFAULT '#6a1b9a',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `id_card_designs`
--

INSERT INTO `id_card_designs` (`id`, `name`, `slug`, `header_shape`, `gradient_bar`, `pattern`, `primary_color`, `badge_color`, `label_color`, `photo_border_color`, `back_header_bg`, `back_header_text`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Classic Purple', 'purple_classic', 'assets/images/id_card/designs/purple_classic/header_shape.png', 'assets/images/id_card/designs/purple_classic/gradient_bar.png', 'assets/images/id_card/designs/purple_classic/pattern.png', '#6a1b9a', '#841778', '#6a1b9a', '#6a1b9a', '#f3e8ff', '#6a1b9a', 1, 1, '2026-09-05 06:29:03', '2026-09-05 06:32:27'),
(2, 'Royal Navy & Gold', 'navy_gold', 'assets/images/id_card/designs/navy_gold/header_shape.png', 'assets/images/id_card/designs/navy_gold/gradient_bar.png', 'assets/images/id_card/designs/navy_gold/pattern.png', '#1e40af', '#0f172a', '#1e40af', '#1e40af', '#e0e7ff', '#1e3a8a', 1, 2, '2026-09-05 06:29:03', '2026-09-05 06:29:03'),
(3, 'Emerald Academic', 'emerald_wave', 'assets/images/id_card/designs/emerald_wave/header_shape.png', 'assets/images/id_card/designs/emerald_wave/gradient_bar.png', 'assets/images/id_card/designs/emerald_wave/pattern.png', '#059669', '#065f46', '#047857', '#059669', '#ecfdf5', '#065f46', 1, 3, '2026-09-05 06:29:03', '2026-09-05 06:29:03'),
(4, 'Modern Cyan & Indigo', 'cyan_modern', 'assets/images/id_card/designs/cyan_modern/header_shape.png', 'assets/images/id_card/designs/cyan_modern/gradient_bar.png', 'assets/images/id_card/designs/cyan_modern/pattern.png', '#0284c7', '#0369a1', '#0284c7', '#0284c7', '#e0f2fe', '#0369a1', 1, 4, '2026-09-05 06:29:03', '2026-09-05 06:29:03'),
(5, 'Regal Maroon & Ruby', 'maroon_regal', 'assets/images/id_card/designs/maroon_regal/header_shape.png', 'assets/images/id_card/designs/maroon_regal/gradient_bar.png', 'assets/images/id_card/designs/maroon_regal/pattern.png', '#be123c', '#881337', '#9f1239', '#be123c', '#ffe4e6', '#9f1239', 1, 5, '2026-09-05 06:29:03', '2026-09-05 06:29:03');

-- --------------------------------------------------------

--
-- Table structure for table `inbound_messages`
--

CREATE TABLE `inbound_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mailbox_type` varchar(20) NOT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `message_id` varchar(255) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `sender_email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body_text` longtext DEFAULT NULL,
  `body_html` longtext DEFAULT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`headers`)),
  `received_at` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_plans`
--

CREATE TABLE `lesson_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `lesson_description` text NOT NULL,
  `homework` text DEFAULT NULL,
  `submission_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_contact_msgs`
--

CREATE TABLE `main_contact_msgs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_newsletters`
--

CREATE TABLE `main_newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `marks` int(11) NOT NULL,
  `cq` decimal(8,2) DEFAULT NULL,
  `mcq` decimal(8,2) DEFAULT NULL,
  `practical` decimal(8,2) DEFAULT NULL,
  `status` enum('present','absent') NOT NULL DEFAULT 'present',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `school_id`, `academic_year_id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `marks`, `cq`, `mcq`, `practical`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 2, 1, 80, 56.00, 24.00, NULL, 'present', '2026-08-21 12:47:17', '2026-08-21 21:16:45'),
(2, 1, 1, 4, 1, 1, 6, 80, 61.00, 19.00, NULL, 'present', '2026-08-21 13:48:19', '2026-08-21 15:38:09'),
(3, 1, 1, 4, 2, 1, 6, 78, 78.00, NULL, NULL, 'present', '2026-08-21 13:48:19', '2026-08-21 15:38:09'),
(4, 1, 1, 4, 3, 1, 6, 79, 56.00, 23.00, NULL, 'present', '2026-08-21 13:48:19', '2026-08-21 15:38:09'),
(5, 1, 1, 5, 1, 1, 6, 79, 54.00, 25.00, NULL, 'present', '2026-08-21 13:48:19', '2026-08-21 15:38:09'),
(6, 1, 1, 5, 2, 1, 6, 80, 80.00, NULL, NULL, 'present', '2026-08-21 13:48:19', '2026-08-21 15:38:09'),
(7, 1, 1, 5, 3, 1, 6, 71, 51.00, 20.00, NULL, 'present', '2026-08-21 13:48:19', '2026-08-21 15:38:09'),
(8, 1, 1, 4, 4, 1, 6, 34, 23.00, 11.00, NULL, 'present', '2026-08-21 13:55:17', '2026-08-21 15:38:09'),
(9, 1, 1, 4, 5, 1, 6, 43, NULL, NULL, NULL, 'present', '2026-08-21 13:55:17', '2026-08-21 13:56:51'),
(10, 1, 1, 5, 4, 1, 6, 38, 26.00, 12.00, NULL, 'present', '2026-08-21 13:56:51', '2026-08-21 15:38:09'),
(11, 1, 1, 5, 5, 1, 6, 42, NULL, NULL, NULL, 'present', '2026-08-21 13:56:51', '2026-08-21 13:56:51'),
(12, 1, 1, 4, 6, 1, 6, 76, 55.00, 21.00, NULL, 'present', '2026-08-21 14:44:55', '2026-08-21 14:44:58'),
(13, 1, 1, 5, 6, 1, 6, 80, 57.00, 23.00, NULL, 'present', '2026-08-21 14:45:02', '2026-08-21 14:45:06'),
(14, 1, 1, 3, 1, 2, 1, 89, 67.00, 22.00, NULL, 'present', '2026-08-21 21:10:25', '2026-08-21 21:17:14'),
(15, 1, 1, 2, 1, 2, 1, 78, 57.00, 21.00, NULL, 'present', '2026-08-21 21:16:31', '2026-08-21 21:16:36'),
(16, 1, 1, 1, 2, 2, 1, 84, 84.00, NULL, NULL, 'present', '2026-08-21 21:22:46', '2026-08-21 21:22:47'),
(17, 1, 1, 2, 2, 2, 1, 79, 79.00, NULL, NULL, 'present', '2026-08-21 21:22:51', '2026-08-21 21:22:52'),
(18, 1, 1, 3, 2, 2, 1, 68, 68.00, NULL, NULL, 'present', '2026-08-21 21:22:54', '2026-08-21 21:22:55'),
(19, 1, 1, 1, 3, 2, 1, 89, 89.00, NULL, NULL, 'present', '2026-08-21 21:23:19', '2026-08-21 21:23:19'),
(20, 1, 1, 2, 3, 2, 1, 85, 85.00, NULL, NULL, 'present', '2026-08-21 21:23:20', '2026-08-21 21:23:21'),
(21, 1, 1, 3, 3, 2, 1, 86, 86.00, NULL, NULL, 'present', '2026-08-21 21:23:23', '2026-08-21 21:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_10_023650_create_schools_table', 1),
(5, '2026_02_16_162809_create_permission_tables', 1),
(6, '2026_02_16_171720_add_school_id_to_roles_table', 1),
(7, '2026_02_18_075134_create_academicyears_table', 1),
(8, '2026_02_18_183745_create_classes_table', 1),
(9, '2026_02_19_094931_create_sections_table', 1),
(10, '2026_02_19_101922_create_subjects_table', 1),
(11, '2026_02_20_180302_create_assign_class_table', 1),
(12, '2026_02_21_155724_create_admissions_table', 1),
(13, '2026_02_23_053852_create_teachers_table', 1),
(14, '2026_02_24_080924_student', 1),
(15, '2026_02_24_194633_add_admission_date_column_students_table', 1),
(16, '2026_02_24_200631_add_created_by_column_students_table', 1),
(17, '2026_02_25_133615_add_section_student_table', 1),
(18, '2026_02_27_100157_add_assign_column_table', 1),
(19, '2026_03_03_112741_create_teacher_assign_subjects_table', 1),
(20, '2026_03_03_170817_create_exams_table', 1),
(21, '2026_03_05_152640_create_marks_table', 1),
(22, '2026_03_06_163531_add_status_column_marks_table', 1),
(23, '2026_03_13_153040_create_attendances_table', 1),
(24, '2026_03_13_164218_add_section_id_to_teacher_assign_subjects_table', 1),
(25, '2026_03_14_075742_add_teacher_id_to_users_table', 1),
(26, '2026_03_15_223123_create_fee_heads_table', 1),
(27, '2026_03_15_234202_create_fee_amounts_table', 1),
(28, '2026_03_16_001031_create_student_fees_table', 1),
(29, '2026_03_16_014757_add_payment_method_to_student_fees_table', 1),
(30, '2026_03_17_153744_add_collected_by_to_student_fees_table', 1),
(31, '2026_03_18_015337_add_extra_fields_to_schools_table', 1),
(32, '2026_03_19_013111_add_phone_and_photo_to_users_table', 1),
(33, '2026_03_23_211008_create_notices_table', 1),
(34, '2026_03_23_222037_create_sliders_table', 1),
(35, '2026_03_25_235630_create_about_sections_table', 1),
(36, '2026_03_26_002759_add_social_links_and_designation_to_teachers_table', 1),
(37, '2026_03_26_145312_add_social_links_to_users_table', 1),
(38, '2026_03_26_215558_create_school_overviews_table', 1),
(39, '2026_03_27_004908_create_footer_settings_table', 1),
(40, '2026_03_27_090713_create_newsletters_table', 1),
(41, '2026_03_28_205805_add_roll_to_students_table', 1),
(42, '2026_03_29_124222_create_site_settings_table', 1),
(43, '2026_03_30_115022_create_student_sessions_table', 1),
(44, '2026_03_31_145655_add_is_published_exams_table', 1),
(45, '2026_03_31_211155_create_lesson_plans_table', 1),
(46, '2026_04_01_133435_add_student_user_id_column_in_table', 1),
(47, '2026_04_03_150218_add_email_to_admissions_table', 1),
(48, '2026_04_05_230338_create_notifications_table', 1),
(49, '2026_04_07_222842_create_school_categories_table', 1),
(50, '2026_04_07_231547_create_school_sub_categories_table', 1),
(51, '2026_04_08_232456_update_exam_and_fees_for_categories', 1),
(52, '2026_04_08_234213_add_category_columns_to_students_table', 1),
(53, '2026_04_10_091540_add_category_columns_to_fee_amounts_table', 1),
(54, '2026_04_10_092639_update_unique_key_in_fee_amounts_table', 1),
(55, '2026_04_11_143217_create_holidays_table', 1),
(56, '2026_04_13_230301_create_contact_messages_table', 1),
(57, '2026_04_21_125404_add_seo_fields_to_site_settings_table', 1),
(58, '2026_04_21_135100_add_group_name_to_permissions_table', 1),
(59, '2026_04_21_141414_create_employees_table', 1),
(60, '2026_04_22_004115_add_role_type_to_roles_table', 1),
(61, '2026_04_22_223909_add_employee_to_users_role', 1),
(62, '2026_04_25_134129_frontend_sections', 1),
(63, '2026_04_26_232459_create_main_contact_msgs_table', 1),
(64, '2026_04_30_000000_create_subscription_packages_table', 1),
(65, '2026_04_30_000001_create_testimonials_table', 1),
(66, '2026_04_30_000002_add_user_id_to_testimonials_table', 1),
(67, '2026_05_01_014102_create_events_table', 1),
(68, '2026_05_01_021749_create_routines_table', 1),
(69, '2026_05_03_000602_add_category_columns_to_subjects_table', 1),
(70, '2026_05_03_164612_add_category_to_subject_assign_to_class', 1),
(71, '2026_05_13_152500_add_api_settings_to_schools_table', 1),
(72, '2026_05_13_211000_add_professional_email_fields_to_schools_table', 1),
(73, '2026_05_15_000000_add_mail_columns_to_site_settings_table', 1),
(74, '2026_05_15_015200_create_support_tickets_table', 1),
(75, '2026_05_15_020700_add_attachment_to_support_tables', 1),
(76, '2026_05_15_042700_update_schools_and_packages_table', 1),
(77, '2026_05_16_143500_create_communication_settings_table', 1),
(78, '2026_05_27_000000_create_main_newsletters_table', 1),
(79, '2026_06_05_132630_add_receipt_no_to_student_fees_table', 1),
(80, '2026_06_23_000000_create_blogs_table', 1),
(81, '2026_06_23_000001_create_blog_categories_table', 1),
(82, '2026_06_23_000002_add_blog_category_id_to_blogs_table', 1),
(83, '2026_08_06_000001_add_app_code_to_schools_table', 1),
(84, '2026_08_08_000001_update_unique_key_in_teachers_table', 1),
(85, '2026_08_09_233003_add_admission_settings_and_ref_columns', 1),
(86, '2026_08_10_000001_add_admission_academic_year_id_to_schools_table', 1),
(87, '2026_08_21_150305_add_cq_mcq_practical_to_marks_table', 2),
(88, '2026_08_22_132638_create_exam_routines_table', 3),
(89, '2026_08_22_000000_create_exam_routines_table', 4),
(90, '2026_08_28_201308_create_exam_categories_table', 5),
(91, '2026_08_30_000001_add_bangla_columns_to_students_table', 6),
(92, '2026_08_30_000002_make_teacher_id_nullable_in_attendances_table', 7),
(93, '2026_08_30_000003_update_unique_key_in_students_table', 8),
(94, '2026_08_30_230444_create_email_logs_table', 8),
(95, '2026_08_31_190321_add_detailed_marks_to_assign_classes_table', 9),
(96, '2026_09_02_175050_fix_fee_heads_unique_constraint', 10),
(97, '2026_09_03_000001_add_sms_settings_to_schools_table', 11),
(98, '2026_09_03_000002_create_inbound_messages_table', 12),
(99, '2026_09_03_000003_add_inbound_webhook_settings', 13),
(100, '2026_09_03_000004_add_imap_settings', 14),
(101, '2026_09_03_000005_add_profile_to_subscription_packages', 15),
(102, '2026_09_04_000001_make_student_section_nullable', 16),
(103, '2026_09_04_000003_add_institution_database_metadata', 16),
(104, '2026_09_04_000004_add_provisioning_status_to_schools', 17),
(105, '2026_09_04_000006_add_coaching_permissions', 18),
(106, '2026_09_04_000007_create_school_subscriptions_table', 19),
(107, '2026_09_04_000008_add_manual_payment_fields_to_school_subscriptions', 20),
(108, '2026_09_04_000009_add_payment_settings_to_site_settings', 21),
(109, '2026_09_04_000010_add_location_fields_to_schools_table', 22),
(110, '2026_09_04_000009_create_student_fee_concessions_and_update_student_fees', 23),
(111, '2026_09_05_103042_add_signature_to_schools_and_users_tables', 24),
(112, '2026_09_05_122133_create_id_card_designs_table', 25),
(113, '2026_09_10_000001_add_representative_id_to_schools_table', 26),
(114, '2026_09_10_000002_add_commission_fields_to_employees_table', 26),
(115, '2026_09_10_000003_create_school_delete_requests_table', 26),
(116, '2026_09_11_230500_add_commission_setup_to_packages_and_employees', 27),
(117, '2026_09_12_000001_add_ip_address_to_main_contact_msgs_table', 28);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 3),
(6, 'App\\Models\\User', 4),
(7, 'App\\Models\\User', 6),
(7, 'App\\Models\\User', 7),
(7, 'App\\Models\\User', 8),
(7, 'App\\Models\\User', 9),
(7, 'App\\Models\\User', 10),
(7, 'App\\Models\\User', 13),
(7, 'App\\Models\\User', 14),
(8, 'App\\Models\\User', 2),
(8, 'App\\Models\\User', 15),
(9, 'App\\Models\\User', 16);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `notice_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `school_id`, `title`, `description`, `file`, `notice_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'testinng', 'gfdgsgdsg  frghrhgdfg', 'uploads/schools/demo/notices/1787331968_testinng.pdf', '2026-08-21', 1, '2026-08-21 22:06:08', '2026-08-21 22:06:08');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('252424af-4ef6-4ee9-9f12-8ac3387f14c9', 'App\\Notifications\\SuperAdminNotification', 'App\\Models\\User', 1, '{\"message\":\"New School Registered: Study Point Coaching Center\",\"icon\":\"home\",\"link\":\"http:\\/\\/schoolerp.test\\/manage\\/schools\\/pending\"}', NULL, '2026-09-03 18:57:30', '2026-09-03 18:57:30');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'academic-year.manage', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(2, 'category.manage', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(3, 'sub-category.manage', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(4, 'class.manage', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(5, 'section.manage', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(6, 'subject.manage', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(7, 'assign.subject', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(8, 'class.routine', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(9, 'syllabus.manage', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(10, 'lesson.view', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(11, 'lesson.manage', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(12, 'homework.manage', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(13, 'syllabus.view', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(14, 'syllabus.download', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(15, 'syllabus.upload', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(16, 'syllabus.delete', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(17, 'syllabus.approve', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(18, 'syllabus.reject', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(19, 'syllabus.view_rejected', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(20, 'syllabus.view_approved', 'Academic', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(21, 'admission.manage', 'Students & Admissions', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(22, 'student.index', 'Students & Admissions', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(23, 'student.create', 'Students & Admissions', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(24, 'student.edit', 'Students & Admissions', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(25, 'student.delete', 'Students & Admissions', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(26, 'student.manage', 'Students & Admissions', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(27, 'student.idcard', 'Students & Admissions', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(28, 'student.promotion', 'Students & Admissions', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(29, 'teacher.manage', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(30, 'assign.teacher', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(31, 'employee.manage', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(32, 'designation.manage', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(33, 'payroll.manage', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(34, 'leave.manage', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(35, 'attendance.manage', 'Attendance & Exams', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(36, 'attendance.report', 'Attendance & Exams', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(37, 'payroll.report', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(38, 'staff.report', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(39, 'staff.idcard', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(40, 'staff.promotion', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(41, 'staff.transfer', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(42, 'staff.termination', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(43, 'staff.leave', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(44, 'staff.attendance', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(45, 'staff.payroll', 'Staff & HR', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(46, 'attendance.analytics', 'Attendance & Exams', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(47, 'holiday.manage', 'Attendance & Exams', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(48, 'exam.manage', 'Attendance & Exams', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(49, 'mark.manage', 'Attendance & Exams', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(50, 'exam.admit_card', 'Attendance & Exams', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(51, 'fee.manage', 'Finance (Fees)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(52, 'fee.collect', 'Finance (Fees)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(53, 'fee.report', 'Finance (Fees)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(54, 'notice.manage', 'Website & Communication', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(55, 'slider.manage', 'Website & Communication', 'web', '2026-08-21 11:51:40', '2026-09-05 04:01:12'),
(56, 'gallery.manage', 'Website & Communication', 'web', '2026-08-21 11:51:40', '2026-09-05 04:01:12'),
(57, 'message.manage', 'Website & Communication', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(58, 'sms.send', 'Website & Communication', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(59, 'email.send', 'Website & Communication', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(60, 'whatsapp.send', 'Website & Communication', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(61, 'newsletter.manage', 'Settings', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(62, 'system.settings', 'Settings', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(63, 'school.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(64, 'school.create', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(65, 'school.approve', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(66, 'frontend.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(67, 'school.reject', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(68, 'school.delete', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(69, 'settings.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(70, 'super.roles.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(71, 'contact.messages.view', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(72, 'testimonial.approve', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(73, 'support.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(74, 'support.bot.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(83, 'batch.manage', 'Coaching Center', 'web', '2026-09-03 18:50:35', '2026-09-03 18:50:35'),
(84, 'coaching.student.manage', 'Coaching Center', 'web', '2026-09-03 18:50:35', '2026-09-03 18:50:35'),
(85, 'coaching.teacher.manage', 'Coaching Center', 'web', '2026-09-03 18:50:35', '2026-09-03 18:50:35'),
(86, 'coaching.attendance.manage', 'Coaching Center', 'web', '2026-09-03 18:50:35', '2026-09-03 18:50:35'),
(87, 'coaching.exam.manage', 'Coaching Center', 'web', '2026-09-03 18:50:35', '2026-09-03 18:50:35'),
(88, 'coaching.mark.manage', 'Coaching Center', 'web', '2026-09-03 18:50:35', '2026-09-03 18:50:35'),
(89, 'coaching.fee.manage', 'Coaching Center', 'web', '2026-09-03 18:50:35', '2026-09-03 18:50:35'),
(90, 'coaching.notice.manage', 'Coaching Center', 'web', '2026-09-03 18:50:35', '2026-09-03 18:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `role_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `role_type`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 'super_admin', 'web', 'employee', '2026-08-21 11:51:40', '2026-08-21 11:51:41', NULL),
(2, 'HR', 'web', 'employee', '2026-08-21 11:51:41', '2026-08-21 11:51:41', NULL),
(3, 'Marketing', 'web', 'employee', '2026-08-21 11:51:41', '2026-08-21 11:51:41', NULL),
(4, 'Support', 'web', 'employee', '2026-08-21 11:51:41', '2026-08-21 11:51:41', NULL),
(5, 'Accountant', 'web', 'employee', '2026-08-21 11:51:41', '2026-08-21 11:51:41', NULL),
(6, 'teacher', 'web', 'school_staff', '2026-08-21 11:51:41', '2026-08-21 11:51:41', NULL),
(7, 'student', 'web', 'school_staff', '2026-08-21 11:51:41', '2026-08-21 11:51:41', NULL),
(8, 'school_admin', 'web', 'school_staff', '2026-08-21 11:51:41', '2026-08-21 11:51:41', NULL),
(9, 'Representative', 'web', 'employee', '2026-09-11 16:38:14', '2026-09-11 16:38:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 8),
(2, 1),
(2, 8),
(3, 1),
(3, 8),
(4, 1),
(4, 8),
(5, 1),
(5, 8),
(6, 1),
(6, 8),
(7, 1),
(7, 8),
(8, 1),
(8, 8),
(9, 1),
(9, 8),
(10, 1),
(10, 8),
(11, 1),
(11, 8),
(12, 1),
(12, 8),
(13, 1),
(13, 8),
(14, 1),
(14, 8),
(15, 1),
(15, 8),
(16, 1),
(16, 8),
(17, 1),
(17, 8),
(18, 1),
(18, 8),
(19, 1),
(19, 8),
(20, 1),
(20, 8),
(21, 1),
(21, 8),
(22, 1),
(22, 8),
(23, 1),
(23, 8),
(24, 1),
(24, 8),
(25, 1),
(25, 8),
(26, 1),
(26, 8),
(27, 1),
(27, 8),
(28, 1),
(28, 8),
(29, 1),
(29, 8),
(30, 1),
(30, 8),
(31, 1),
(31, 8),
(32, 1),
(32, 8),
(33, 1),
(33, 8),
(34, 1),
(34, 8),
(35, 1),
(35, 8),
(36, 1),
(36, 8),
(37, 1),
(37, 8),
(38, 1),
(38, 8),
(39, 1),
(39, 8),
(40, 1),
(40, 8),
(41, 1),
(41, 8),
(42, 1),
(42, 8),
(43, 1),
(43, 8),
(44, 1),
(44, 8),
(45, 1),
(45, 8),
(46, 1),
(46, 8),
(47, 1),
(47, 8),
(48, 1),
(48, 8),
(49, 1),
(49, 8),
(50, 1),
(50, 8),
(51, 1),
(51, 8),
(52, 1),
(52, 8),
(53, 1),
(53, 8),
(54, 1),
(54, 8),
(55, 1),
(55, 8),
(56, 1),
(56, 8),
(57, 1),
(57, 8),
(58, 1),
(58, 8),
(59, 1),
(59, 8),
(60, 1),
(60, 8),
(61, 1),
(61, 8),
(62, 1),
(62, 8),
(63, 1),
(63, 9),
(64, 1),
(64, 9),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1);

-- --------------------------------------------------------

--
-- Table structure for table `routines`
--

CREATE TABLE `routines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `day` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `representative_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `institution_type` varchar(20) NOT NULL DEFAULT 'school',
  `database_group` varchar(20) NOT NULL DEFAULT 'school',
  `database_mode` varchar(20) NOT NULL DEFAULT 'shared',
  `provisioning_status` varchar(20) NOT NULL DEFAULT 'shared',
  `logo` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `mail_mailer` varchar(255) NOT NULL DEFAULT 'smtp',
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(255) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_encryption` varchar(255) DEFAULT NULL,
  `mail_from_address` varchar(255) DEFAULT NULL,
  `mail_from_name` varchar(255) DEFAULT NULL,
  `whatsapp_api_provider` varchar(255) DEFAULT NULL,
  `whatsapp_api_key` varchar(255) DEFAULT NULL,
  `whatsapp_api_instance_id` varchar(255) DEFAULT NULL,
  `sms_api_provider` varchar(255) DEFAULT NULL,
  `sms_api_url` varchar(255) DEFAULT NULL,
  `sms_api_key` varchar(255) DEFAULT NULL,
  `sms_api_secret` varchar(255) DEFAULT NULL,
  `sms_sender_id` varchar(255) DEFAULT NULL,
  `inbound_webhook_secret` varchar(255) DEFAULT NULL,
  `inbound_webhook_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `imap_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `imap_host` varchar(255) DEFAULT NULL,
  `imap_port` smallint(5) UNSIGNED NOT NULL DEFAULT 993,
  `imap_username` varchar(255) DEFAULT NULL,
  `imap_password` text DEFAULT NULL,
  `imap_encryption` varchar(255) NOT NULL DEFAULT 'ssl',
  `imap_folder` varchar(255) NOT NULL DEFAULT 'INBOX',
  `favicon` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `app_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `ein_number` varchar(255) DEFAULT NULL,
  `emis_code` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `upazila` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `is_admission_open` tinyint(1) NOT NULL DEFAULT 1,
  `admission_closed_message` text DEFAULT NULL,
  `admission_close_date` datetime DEFAULT NULL,
  `admission_academic_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subscription_package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pro_email_status` enum('none','pending','approved','rejected') NOT NULL DEFAULT 'none',
  `pro_email_address` varchar(255) DEFAULT NULL,
  `pro_email_password` varchar(255) DEFAULT NULL,
  `pro_email_prefix` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `representative_id`, `name`, `institution_type`, `database_group`, `database_mode`, `provisioning_status`, `logo`, `signature`, `mail_mailer`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `whatsapp_api_provider`, `whatsapp_api_key`, `whatsapp_api_instance_id`, `sms_api_provider`, `sms_api_url`, `sms_api_key`, `sms_api_secret`, `sms_sender_id`, `inbound_webhook_secret`, `inbound_webhook_enabled`, `imap_enabled`, `imap_host`, `imap_port`, `imap_username`, `imap_password`, `imap_encryption`, `imap_folder`, `favicon`, `slug`, `email`, `app_code`, `phone`, `ein_number`, `emis_code`, `address`, `division`, `district`, `upazila`, `status`, `is_admission_open`, `admission_closed_message`, `admission_close_date`, `admission_academic_year_id`, `subscription_package_id`, `is_active`, `created_at`, `updated_at`, `pro_email_status`, `pro_email_address`, `pro_email_password`, `pro_email_prefix`) VALUES
(1, NULL, 'Demo International School College', 'school', 'school', 'shared', 'shared', 'uploads/schools/demo/logo/logo_1787403957.png', 'uploads/schools/demo/signatures/sig_1788583083_6a9b9caba6e67.jpg', 'smtp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 993, NULL, NULL, 'ssl', 'INBOX', NULL, 'demo', 'demo@schoolerp.test', 'SCH0001', NULL, '123456', '123456', NULL, 'Rangpur', 'Nilphamari', 'Nilphamari Sadar', 'approved', 1, NULL, NULL, NULL, 1, 1, '2026-08-21 11:53:08', '2026-09-05 05:52:49', 'none', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school_categories`
--

CREATE TABLE `school_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `exams_per_year` int(11) NOT NULL DEFAULT 3,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_categories`
--

INSERT INTO `school_categories` (`id`, `school_id`, `name`, `exams_per_year`, `created_at`, `updated_at`) VALUES
(1, 1, 'Primary', 3, '2026-08-21 12:06:26', '2026-08-21 12:06:26'),
(2, 1, 'Junior Secondary', 2, '2026-08-21 12:06:42', '2026-08-21 12:06:42'),
(3, 1, 'Secondary', 3, '2026-08-22 18:46:00', '2026-08-22 18:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `school_delete_requests`
--

CREATE TABLE `school_delete_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `admin_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_overviews`
--

CREATE TABLE `school_overviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL,
  `order_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_subscriptions`
--

CREATE TABLE `school_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `subscription_package_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','trialing','active','expired','cancelled') NOT NULL DEFAULT 'pending',
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'BDT',
  `payment_method` varchar(255) DEFAULT NULL,
  `sender_number` varchar(20) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `payment_submitted_at` timestamp NULL DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_subscriptions`
--

INSERT INTO `school_subscriptions` (`id`, `school_id`, `subscription_package_id`, `status`, `amount`, `currency`, `payment_method`, `sender_number`, `trial_ends_at`, `starts_at`, `ends_at`, `paid_at`, `payment_reference`, `payment_submitted_at`, `reviewed_by`, `reviewed_at`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 'pending', 0.00, 'BDT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-04 07:45:16', '2026-09-04 07:45:16'),
(4, 1, 1, 'active', 0.00, 'BDT', 'bkash', '01977325525', NULL, '2026-09-04 12:05:56', '2027-09-04 12:05:56', '2026-09-04 12:05:56', 'FDFFASQ2', '2026-09-04 08:09:00', 1, '2026-09-04 12:05:56', NULL, '2026-09-04 12:04:24', '2026-09-04 12:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `school_sub_categories`
--

CREATE TABLE `school_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `school_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_sub_categories`
--

INSERT INTO `school_sub_categories` (`id`, `school_id`, `school_category_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'General', '2026-08-21 12:06:54', '2026-08-21 12:06:54'),
(2, 1, 2, 'General', '2026-08-21 12:07:05', '2026-08-21 12:07:05'),
(3, 1, 3, 'Science', '2026-08-22 18:46:42', '2026-08-22 18:46:42'),
(4, 1, 3, 'Humanities', '2026-08-22 18:46:50', '2026-08-22 18:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `school_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'A', NULL, '2026-08-21 12:09:34', '2026-08-21 12:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qxvyFHh8XLlh2j29aDhkAN6Nd8EWopkx7GcjXU99', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOWE2YXh0YnA3azBJRU5RbW5pZkNQa3NpdktwOWNKSnlZUGpha1FJeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9zY2hvb2xlcnAudGVzdC8/dj0xNzg5MjAwMDE0IjtzOjU6InJvdXRlIjtzOjk6Im1haW4uaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1789200015),
('T4GEMeg5Qn37tvgdNpalvWRQdBsTtRvDn53PMC9u', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNVJXaUpJMkl0TVNUZEFKd0VlcTNDNE5NTlhUM3RKWW1LT0FHT2hSMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjQ6Imh0dHA6Ly9kZW1vLnNjaG9vbGVycC50ZXN0L2J1bGstbWFya3NoZWV0LzEvMj9hY2FkZW1pY195ZWFyX2lkPTEiO3M6NToicm91dGUiO3M6MjA6Im1hcmtzLmJ1bGstbWFya3NoZWV0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1789204343);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) NOT NULL DEFAULT 'EduCorexa',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `logo_wide` varchar(255) DEFAULT NULL,
  `logo_square` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `mail_mailer` varchar(255) NOT NULL DEFAULT 'smtp',
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` int(11) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_encryption` varchar(255) DEFAULT NULL,
  `mail_from_address` varchar(255) DEFAULT NULL,
  `mail_from_name` varchar(255) DEFAULT NULL,
  `inbound_webhook_secret` varchar(255) DEFAULT NULL,
  `inbound_webhook_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `imap_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `imap_host` varchar(255) DEFAULT NULL,
  `imap_port` smallint(5) UNSIGNED NOT NULL DEFAULT 993,
  `imap_username` varchar(255) DEFAULT NULL,
  `imap_password` text DEFAULT NULL,
  `imap_encryption` varchar(255) NOT NULL DEFAULT 'ssl',
  `imap_folder` varchar(255) NOT NULL DEFAULT 'INBOX',
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(255) NOT NULL DEFAULT 'personal',
  `bkash_personal_number` varchar(255) DEFAULT NULL,
  `nagad_personal_number` varchar(255) DEFAULT NULL,
  `bkash_merchant_number` varchar(255) DEFAULT NULL,
  `bkash_merchant_id` varchar(255) DEFAULT NULL,
  `bkash_api_key` text DEFAULT NULL,
  `bkash_api_secret` text DEFAULT NULL,
  `nagad_merchant_number` varchar(255) DEFAULT NULL,
  `nagad_merchant_id` varchar(255) DEFAULT NULL,
  `nagad_api_key` text DEFAULT NULL,
  `nagad_api_secret` text DEFAULT NULL,
  `manual_payment_instructions` text DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `meta_title`, `meta_description`, `meta_keywords`, `logo_wide`, `logo_square`, `favicon`, `og_image`, `mail_mailer`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `inbound_webhook_secret`, `inbound_webhook_enabled`, `imap_enabled`, `imap_host`, `imap_port`, `imap_username`, `imap_password`, `imap_encryption`, `imap_folder`, `address`, `phone`, `email`, `payment_mode`, `bkash_personal_number`, `nagad_personal_number`, `bkash_merchant_number`, `bkash_merchant_id`, `bkash_api_key`, `bkash_api_secret`, `nagad_merchant_number`, `nagad_merchant_id`, `nagad_api_key`, `nagad_api_secret`, `manual_payment_instructions`, `footer_text`, `facebook_url`, `twitter_url`, `instagram_url`, `linkedin_url`, `created_at`, `updated_at`) VALUES
(1, 'EduCorexa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'smtp', NULL, 465, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'mail.educorexa.com', 993, 'info@educorexa.com', 'eyJpdiI6InpkMHU4OGRLZGtESGpnak5aTDNiSkE9PSIsInZhbHVlIjoiRUlKSkVsRjFlUm1RWURGdGY0NHA0aml2NWJpVVVBRjVoTW5RZ2lEaEVzRT0iLCJtYWMiOiJkYjVlNGFlN2YwMmY4NmVmZjlkMzg0MjcyNzJlYWYyYzhjYWQ2ZTVhM2QwY2VhNzAyYzNlMDg2NTBiM2FhZWUzIiwidGFnIjoiIn0=', 'ssl', 'INBOX', NULL, NULL, 'support@educorexa.com', 'personal', '01846295608', '01846295608', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Testing', 'All Rights Reserved', NULL, NULL, NULL, NULL, '2026-08-21 11:51:41', '2026-09-04 07:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `order_by` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `school_id`, `title`, `subtitle`, `image`, `order_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 'uploads/schools/demo/sliders/1788450588_6a99971c9cf0e.jpg', 0, 1, '2026-09-03 15:49:48', '2026-09-03 15:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `admission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `school_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `student_id` varchar(255) NOT NULL,
  `roll` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `name_bn` varchar(255) DEFAULT NULL,
  `previous_school` varchar(255) DEFAULT NULL,
  `previous_school_bn` varchar(255) DEFAULT NULL,
  `previous_class` varchar(255) DEFAULT NULL,
  `previous_class_bn` varchar(255) DEFAULT NULL,
  `fathers_name` varchar(255) DEFAULT NULL,
  `fathers_name_bn` varchar(255) DEFAULT NULL,
  `mothers_name` varchar(255) DEFAULT NULL,
  `mothers_name_bn` varchar(255) DEFAULT NULL,
  `father_nid` varchar(255) DEFAULT NULL,
  `mother_nid` varchar(255) DEFAULT NULL,
  `student_birth_nid` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `address_bn` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `school_id`, `admission_id`, `academic_year_id`, `class_id`, `school_category_id`, `section_id`, `student_id`, `roll`, `name`, `name_bn`, `previous_school`, `previous_school_bn`, `previous_class`, `previous_class_bn`, `fathers_name`, `fathers_name_bn`, `mothers_name`, `mothers_name_bn`, `father_nid`, `mother_nid`, `student_birth_nid`, `contact_number`, `password`, `photo`, `status`, `created_by`, `religion`, `gender`, `date_of_birth`, `admission_date`, `blood_group`, `address`, `address_bn`, `created_at`, `updated_at`, `school_sub_category_id`) VALUES
(1, 6, 1, NULL, 1, 1, 1, 1, '261001', 1, 'Sumon Roy', NULL, NULL, NULL, NULL, NULL, 'Srinibas', NULL, 'Suborna', NULL, NULL, NULL, NULL, '1835625627', '$2y$12$Og15fxuU8j1jj2sQ8U1xie4zqojSkzaxRdHgtgvaz48Pn/VEhFxWW', NULL, 'active', 1, 'Hindu', 'Male', '2019-01-12', NULL, 'O+', 'Nilphamari', NULL, '2026-08-21 12:45:06', '2026-08-21 12:45:06', 1),
(2, 7, 1, NULL, 1, 1, 1, 1, '261002', 2, 'Choin Roy', NULL, NULL, NULL, NULL, NULL, 'Binoy Roy', NULL, 'Sima Rani', NULL, NULL, NULL, NULL, '1735625627', '$2y$12$bj32oDA53ijSeNNYVcLSL.ewtuXzW1orLRZ/UZzPRhLDDuyYHFAMq', NULL, 'active', 1, 'Hindu', 'Male', '2019-01-12', NULL, 'O+', 'Nilphamari', NULL, '2026-08-21 13:06:23', '2026-08-21 13:06:23', 1),
(3, 8, 1, NULL, 1, 1, 1, 1, '261003', 3, 'Sagor Hoassain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01712452422', '$2y$12$0qwUhC4JoepF1raVqDfT9ulP7k0aElRXMbS1VWx5x9E5k2URP4uaK', NULL, 'active', 1, 'Islam', 'male', '2020-02-13', NULL, 'A+', 'Nilphamari', NULL, '2026-08-21 13:06:24', '2026-08-21 13:07:13', 1),
(4, 9, 1, NULL, 1, 6, 2, 1, '261004', 1, 'Sagor Ray', NULL, NULL, NULL, NULL, NULL, 'Binoy Roy', NULL, 'Sima Rani', NULL, NULL, NULL, NULL, '1735626727', '$2y$12$nfkgLNBpowdjEqFNKASEUOmPD6T9HFNtPEPbzn0nx5itUyQMTuqwS', NULL, 'active', 2, 'Hindu', 'Male', '2019-01-12', NULL, 'O+', 'Nilphamari', NULL, '2026-08-21 13:46:24', '2026-08-21 13:46:24', 2),
(5, 10, 1, NULL, 1, 6, 2, 1, '261005', 2, 'Shahinur Islam', NULL, NULL, NULL, NULL, NULL, 'Abul Islam', NULL, 'Aminaa Begum', NULL, NULL, NULL, NULL, '1712455422', '$2y$12$QOiVPs5AbrX2Rb01Yd2w6ePtiAa.7t4VaU6WkHj1dTJ0yJA1Ryg8m', NULL, 'active', 2, 'Islam', 'Male', '2020-02-13', NULL, 'A+', 'Nilphamari', NULL, '2026-08-21 13:46:24', '2026-08-21 13:46:24', 2),
(8, 13, 1, NULL, 1, 9, 3, 1, '261006', 1, 'Simu Rani', NULL, NULL, NULL, NULL, NULL, 'Binoy Roy', NULL, 'Sima Rani', NULL, NULL, NULL, NULL, '1735626727', '$2y$12$t1/HZemhUM5YJKl.bXS5/.jCb../KoyulE3oMffAaV78SF/sWLBLu', NULL, 'active', 2, 'Hinduism', 'male', '2013-01-12', '2026-08-28', 'O+', 'Nilphamari', NULL, '2026-08-28 18:50:34', '2026-08-28 18:58:08', 4),
(9, 14, 1, NULL, 1, 9, 3, 1, '261007', 2, 'Saiful Islam', 'সাইফুল ইসলাম', NULL, NULL, NULL, NULL, 'Abul Islam', 'আবুল ইসলাম', 'Aminaa Begum', 'আমিনা বেগম', NULL, NULL, NULL, '1712455422', '$2y$12$8VoXzaxgzXjo2ke030vmVeBE8obdYWVKu5CS1SYsC24bLP.BRfYCS', NULL, 'active', 2, 'Islam', 'male', '2013-02-13', '2026-08-28', 'A+', 'Nilphamari', 'নীলফামারী', '2026-08-28 18:50:34', '2026-08-30 08:02:36', 3);

-- --------------------------------------------------------

--
-- Table structure for table `student_fees`
--

CREATE TABLE `student_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `school_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `fee_head_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `original_amount` decimal(10,2) DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `discount_note` varchar(255) DEFAULT NULL,
  `month` varchar(255) NOT NULL,
  `status` enum('paid','unpaid','partial') NOT NULL DEFAULT 'unpaid',
  `payment_method` varchar(255) DEFAULT 'cash',
  `receipt_no` varchar(255) DEFAULT NULL,
  `collected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fee_type_limit` varchar(255) NOT NULL DEFAULT 'global'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_fees`
--

INSERT INTO `student_fees` (`id`, `school_id`, `school_category_id`, `school_sub_category_id`, `student_id`, `fee_head_id`, `amount`, `original_amount`, `discount_amount`, `discount_percent`, `paid_amount`, `discount_note`, `month`, `status`, `payment_method`, `receipt_no`, `collected_by`, `due_date`, `created_at`, `updated_at`, `fee_type_limit`) VALUES
(1, 1, 1, 1, 1, 1, 200.00, NULL, 0.00, 0.00, NULL, NULL, 'August-2026', 'unpaid', 'cash', NULL, NULL, '2026-08-31', '2026-08-30 07:48:23', '2026-08-30 07:48:23', 'global'),
(2, 1, 1, 1, 2, 1, 135.00, 200.00, 65.00, 10.00, 135.00, 'taka nai', 'August-2026', 'paid', 'cash', 'R0904-DB45', 2, '2026-08-31', '2026-08-30 07:48:23', '2026-09-04 12:34:07', 'global'),
(3, 1, 1, 1, 3, 1, 200.00, NULL, 0.00, 0.00, NULL, NULL, 'August-2026', 'unpaid', 'cash', NULL, NULL, '2026-08-31', '2026-08-30 07:48:23', '2026-08-30 07:48:23', 'global'),
(6, 1, 1, 1, 1, 2, 850.00, 1000.00, 150.00, 15.00, NULL, 'Test Merit Scholarship', 'June-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-09-04 16:22:37', '2026-09-04 16:22:37', 'global'),
(7, 1, 1, 1, 2, 2, 1000.00, 1000.00, 0.00, 0.00, NULL, NULL, 'June-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-09-04 16:22:37', '2026-09-04 16:22:37', 'global'),
(8, 1, 1, 1, 3, 2, 1000.00, 1000.00, 0.00, 0.00, NULL, NULL, 'June-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-09-04 16:22:37', '2026-09-04 16:22:37', 'global');

-- --------------------------------------------------------

--
-- Table structure for table `student_fee_concessions`
--

CREATE TABLE `student_fee_concessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `fee_head_id` bigint(20) UNSIGNED NOT NULL,
  `discount_type` enum('fixed_amount','percentage','custom_fee') NOT NULL DEFAULT 'fixed_amount',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `custom_amount` decimal(10,2) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_fee_concessions`
--

INSERT INTO `student_fee_concessions` (`id`, `school_id`, `student_id`, `fee_head_id`, `discount_type`, `discount_amount`, `discount_percent`, `custom_amount`, `note`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'fixed_amount', 150.00, 0.00, NULL, 'Test Merit Scholarship', 1, '2026-09-04 12:26:52', '2026-09-04 12:26:52'),
(2, 1, 2, 1, 'fixed_amount', 50.00, 25.00, 150.00, 'Poor student', 1, '2026-09-04 12:30:44', '2026-09-04 12:30:44');

-- --------------------------------------------------------

--
-- Table structure for table `student_sessions`
--

CREATE TABLE `student_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `old_student_id` varchar(255) NOT NULL,
  `old_roll` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `school_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `school_id`, `school_category_id`, `school_sub_category_id`, `name`, `code`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 'Bangla', '101', 'theory', NULL, '2026-08-21 12:09:49', '2026-08-21 12:09:49'),
(2, 1, NULL, NULL, 'English', '103', 'theory', NULL, '2026-08-21 12:10:40', '2026-08-21 12:10:40'),
(3, 1, NULL, NULL, 'Mathematics', '105', 'theory', NULL, '2026-08-21 12:10:53', '2026-08-21 12:10:53'),
(4, 1, NULL, NULL, 'Bangla Second Paper', '102', 'theory', NULL, '2026-08-21 13:42:36', '2026-08-21 13:42:36'),
(5, 1, NULL, NULL, 'English Second Paper', '104', 'theory', NULL, '2026-08-21 13:42:59', '2026-08-21 13:42:59'),
(6, 1, NULL, NULL, 'Science', '127', 'theory', NULL, '2026-08-21 14:12:26', '2026-08-21 14:12:26'),
(7, 1, NULL, NULL, 'Physics', '211', 'theory', NULL, '2026-08-22 18:48:18', '2026-08-22 18:48:18'),
(8, 1, NULL, NULL, 'Bangladesh and Global Studies', '132', 'theory', NULL, '2026-08-22 18:48:51', '2026-08-22 18:48:51'),
(9, 1, NULL, NULL, 'History', '201', 'theory', NULL, '2026-08-22 18:49:05', '2026-08-22 18:49:05'),
(10, 1, NULL, NULL, 'Civies and  Citizen', '207', 'theory', NULL, '2026-08-22 18:49:34', '2026-08-22 18:49:34'),
(11, 1, NULL, NULL, 'Higher Math', '255', 'theory_practical', NULL, '2026-08-22 18:49:55', '2026-08-31 13:13:50'),
(12, 1, NULL, NULL, 'Agricultural', '245', 'theory_practical', NULL, '2026-08-22 18:50:10', '2026-08-31 13:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_packages`
--

CREATE TABLE `subscription_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL DEFAULT 'school',
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `registration_commission_type` enum('flat','percentage') NOT NULL DEFAULT 'flat',
  `registration_commission_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `monthly_commission_type` enum('flat','percentage') NOT NULL DEFAULT 'flat',
  `monthly_commission_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `duration` varchar(255) NOT NULL DEFAULT 'monthly',
  `student_limit` int(11) DEFAULT NULL,
  `teacher_limit` int(11) DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_packages`
--

INSERT INTO `subscription_packages` (`id`, `name`, `profile`, `description`, `price`, `registration_commission_type`, `registration_commission_rate`, `monthly_commission_type`, `monthly_commission_rate`, `duration`, `student_limit`, `teacher_limit`, `features`, `permissions`, `is_popular`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Starter', 'school', NULL, 0.00, 'flat', 50.00, 'flat', 0.00, 'yearly', NULL, NULL, '[]', '{\"0\":\"academic-year.manage\",\"1\":\"category.manage\",\"2\":\"sub-category.manage\",\"3\":\"class.manage\",\"4\":\"section.manage\",\"5\":\"subject.manage\",\"6\":\"assign.subject\",\"7\":\"class.routine\",\"8\":\"syllabus.manage\",\"9\":\"lesson.view\",\"10\":\"lesson.manage\",\"11\":\"homework.manage\",\"12\":\"syllabus.view\",\"13\":\"syllabus.download\",\"14\":\"syllabus.upload\",\"15\":\"syllabus.delete\",\"16\":\"syllabus.approve\",\"17\":\"syllabus.reject\",\"18\":\"syllabus.view_rejected\",\"19\":\"syllabus.view_approved\",\"20\":\"admission.manage\",\"21\":\"student.index\",\"22\":\"student.create\",\"23\":\"student.edit\",\"24\":\"student.delete\",\"25\":\"student.manage\",\"26\":\"student.idcard\",\"27\":\"student.promotion\",\"28\":\"teacher.manage\",\"29\":\"assign.teacher\",\"30\":\"employee.manage\",\"31\":\"designation.manage\",\"32\":\"payroll.manage\",\"33\":\"leave.manage\",\"34\":\"staff.attendance\",\"35\":\"staff.leave\",\"36\":\"staff.payroll\",\"37\":\"payroll.report\",\"38\":\"staff.report\",\"39\":\"staff.idcard\",\"40\":\"staff.promotion\",\"41\":\"staff.transfer\",\"42\":\"staff.termination\",\"43\":\"attendance.manage\",\"44\":\"attendance.analytics\",\"45\":\"attendance.report\",\"46\":\"holiday.manage\",\"47\":\"exam.manage\",\"48\":\"mark.manage\",\"49\":\"fee.manage\",\"50\":\"fee.collect\",\"51\":\"fee.report\",\"52\":\"notice.manage\",\"53\":\"slider.manage\",\"54\":\"gallery.manage\",\"55\":\"newsletter.manage\",\"56\":\"system.settings\",\"60\":\"profile.manage\"}', 0, 1, '2026-08-21 13:24:53', '2026-09-11 17:12:11'),
(2, 'Coaching Center', 'coaching', NULL, 500.00, 'flat', 0.00, 'flat', 0.00, 'monthly', NULL, NULL, '[]', '[\"student.create\",\"student.edit\",\"student.delete\",\"student.manage\",\"student.idcard\",\"teacher.manage\",\"assign.teacher\",\"employee.manage\",\"attendance.manage\",\"attendance.analytics\",\"attendance.report\",\"exam.manage\",\"mark.manage\",\"exam.admit_card\",\"fee.manage\",\"fee.collect\",\"fee.report\",\"batch.manage\",\"coaching.student.manage\",\"coaching.teacher.manage\",\"coaching.attendance.manage\",\"coaching.exam.manage\",\"coaching.notice.manage\",\"notice.manage\",\"system.settings\",\"profile.manage\",\"student.index\",\"class.manage\",\"subject.manage\",\"coaching.mark.manage\",\"coaching.fee.manage\"]', 0, 1, '2026-09-03 18:56:14', '2026-09-03 18:56:14');

-- --------------------------------------------------------

--
-- Table structure for table `support_replies`
--

CREATE TABLE `support_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `status` enum('open','pending','resolved','closed') NOT NULL DEFAULT 'open',
  `is_read_by_super` tinyint(1) NOT NULL DEFAULT 0,
  `is_read_by_school` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `nid` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `insta` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `school_id`, `teacher_id`, `name`, `subject_id`, `designation`, `father_name`, `mother_name`, `nid`, `date_of_birth`, `gender`, `email`, `phone`, `blood_group`, `joining_date`, `qualification`, `photo`, `facebook`, `twitter`, `linkedin`, `insta`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, 'TCH-261001', 'Rahim Uddin', 3, NULL, 'Karim Uddin', 'Fatema Begum', '1234567890', '1985-06-15', 'male', 'rahim@school.com', '01712345678', 'B+', '2024-01-10', 'M.Sc in Mathematics', NULL, NULL, NULL, NULL, NULL, 'Dhaka, Bangladesh', '2026-08-21 12:18:30', '2026-08-21 12:18:30'),
(2, 1, 'TCH-261002', 'Salma Khatun', 2, NULL, 'Alam Hossain', 'Roksana Begum', '98765432101234567', '1990-03-22', 'female', 'salma@school.com', '01812345679', 'O+', '2024-02-15', 'M.A. in English', NULL, NULL, NULL, NULL, NULL, 'Chittagong, Bangladesh', '2026-08-21 12:18:30', '2026-08-21 12:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_assign_subjects`
--

CREATE TABLE `teacher_assign_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_assign_subjects`
--

INSERT INTO `teacher_assign_subjects` (`id`, `school_id`, `teacher_id`, `class_id`, `section_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, '2026-08-21 12:19:15', '2026-08-21 12:19:15'),
(2, 1, 1, 2, 1, 1, '2026-08-21 12:19:38', '2026-08-21 12:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `institution_name` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `insta` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `school_id`, `teacher_id`, `name`, `role`, `email`, `phone`, `facebook`, `twitter`, `linkedin`, `insta`, `photo`, `signature`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Super Admin', 'super_admin', 'superadmin@schoolerp.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$C73dNG0oFDqnmZQv7/9y8e0EFG9BC0fdcAxbKzR5esTaw8AWNdLF6', NULL, '2026-08-21 11:51:40', '2026-08-21 11:51:40'),
(2, 1, NULL, 'Demo', 'school_admin', 'demo@schoolerp.test', NULL, NULL, NULL, NULL, NULL, NULL, 'uploads/schools/demo/signatures/sig_1788583083_6a9b9caba6e67.jpg', NULL, '$2y$12$MQwCn.fg.FCe666zfi8PY.8PCHEHhnZjHw.b8ycMb9B3qHYgl40g.', NULL, '2026-08-21 11:53:09', '2026-09-05 04:38:03'),
(3, 1, NULL, 'Rahim Uddin', 'teacher', 'rahim@school.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$BEHBEJYVKHcRU5tB9NeTkuh9fjyldAhxv.cu/zAFIsCtDNTN00aHq', NULL, '2026-08-21 12:18:30', '2026-08-21 12:18:30'),
(4, 1, NULL, 'Salma Khatun', 'teacher', 'salma@school.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$utzosoV332ETVumWeh1ZY.w4iwtXocsNLWVcKpgNgCFcO83J263me', NULL, '2026-08-21 12:18:31', '2026-08-21 12:18:31'),
(6, 1, NULL, 'Sumon Roy', 'student', 'STD-261001@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$x7eLEZ4ejBzyZRUlXN8Wi.z.MhxO6xAkrZN4iIiEUUKKhpuwnoweq', NULL, '2026-08-21 12:45:06', '2026-08-21 12:45:06'),
(7, 1, NULL, 'Choin Roy', 'student', 'STD-261002@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$jVAdRS5hhOc8L7EwJl6a1uimkK9WIoBKKahkJVJywrzqeJoff3oFm', NULL, '2026-08-21 13:06:23', '2026-08-21 13:06:23'),
(8, 1, NULL, 'Sagor Hoassain', 'student', 'STD-261003@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$HGV5u.T76HJ0TrxRbWRBSuGaFkjSThPQdv3H/WiNfHGTk5HkGcfSq', NULL, '2026-08-21 13:06:24', '2026-08-21 13:06:24'),
(9, 1, NULL, 'Sagor Ray', 'student', 'STD-261004@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$wLpsgRBDqPg4lT/Qd0i65eYhAk.4AIp3JcFHXSf2t5Ug.9qTFkafi', NULL, '2026-08-21 13:46:23', '2026-08-21 13:46:23'),
(10, 1, NULL, 'Shahinur Islam', 'student', 'STD-261005@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$3NnFjFeGpauk0h5DF0Kr3ujo9L5l/.Z9DgeuPSCJm0eA.yGmtt2tO', NULL, '2026-08-21 13:46:24', '2026-08-21 13:46:24'),
(13, 1, NULL, 'Simu Rani', 'student', 'STD-261006@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$PTLHx34mqZbOTkboZPT/CuPy1Ic3nBczmnj27zF2YSybxETAX4Rze', NULL, '2026-08-28 18:50:33', '2026-08-28 18:50:33'),
(14, 1, NULL, 'Saiful Islam', 'student', 'STD-261007@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$5QnM3ny2wOx4Gsv1.fkh0eywUlnuObFlSMdil/u2Pxr5ACyV47r1i', NULL, '2026-08-28 18:50:34', '2026-08-28 18:50:34'),
(16, NULL, NULL, 'Sagor Roy', 'Representative', 'kajolray2171@gmail.com', '01766236788', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$o.or/NobOt6GalbI7r8LWOYDMExalXEGn1ZnJ2MTLIr9MEHTxwlQ6', NULL, '2026-09-10 04:54:11', '2026-09-11 16:38:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_sections`
--
ALTER TABLE `about_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `about_sections_school_id_foreign` (`school_id`);

--
-- Indexes for table `academicyears`
--
ALTER TABLE `academicyears`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `academicyears_school_id_name_unique` (`school_id`,`name`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admissions_admission_number_unique` (`admission_number`),
  ADD KEY `admissions_school_id_foreign` (`school_id`),
  ADD KEY `admissions_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `admissions_class_id_foreign` (`class_id`);

--
-- Indexes for table `assign_classes`
--
ALTER TABLE `assign_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_assignment` (`school_id`,`class_id`,`subject_id`),
  ADD KEY `assign_classes_class_id_foreign` (`class_id`),
  ADD KEY `assign_classes_subject_id_foreign` (`subject_id`),
  ADD KEY `assign_classes_school_category_id_foreign` (`school_category_id`),
  ADD KEY `assign_classes_school_sub_category_id_foreign` (`school_sub_category_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_student_id_date_unique` (`student_id`,`date`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`),
  ADD KEY `blogs_blog_category_id_foreign` (`blog_category_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `classes_school_id_code_unique` (`school_id`,`code`),
  ADD KEY `classes_school_category_id_foreign` (`school_category_id`);

--
-- Indexes for table `communication_settings`
--
ALTER TABLE `communication_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `communication_settings_school_id_event_unique` (`school_id`,`event`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_messages_school_id_foreign` (`school_id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_employee_id_unique` (`employee_id`),
  ADD KEY `employees_user_id_foreign` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exams_school_id_year_id_name_unique` (`school_id`,`year_id`,`name`),
  ADD KEY `exams_year_id_foreign` (`year_id`);

--
-- Indexes for table `exam_categories`
--
ALTER TABLE `exam_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_categories_exam_id_school_category_id_unique` (`exam_id`,`school_category_id`),
  ADD KEY `exam_categories_school_category_id_foreign` (`school_category_id`);

--
-- Indexes for table `exam_routines`
--
ALTER TABLE `exam_routines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_routines_school_id_foreign` (`school_id`),
  ADD KEY `exam_routines_exam_id_foreign` (`exam_id`),
  ADD KEY `exam_routines_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fee_amounts`
--
ALTER TABLE `fee_amounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_fee_setup_v2` (`school_id`,`fee_head_id`,`class_id`,`school_category_id`,`school_sub_category_id`),
  ADD KEY `fee_amounts_school_category_id_foreign` (`school_category_id`),
  ADD KEY `fee_amounts_school_sub_category_id_foreign` (`school_sub_category_id`);

--
-- Indexes for table `fee_heads`
--
ALTER TABLE `fee_heads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fee_heads_school_id_name_unique` (`school_id`,`name`);

--
-- Indexes for table `footer_settings`
--
ALTER TABLE `footer_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `footer_settings_school_id_foreign` (`school_id`);

--
-- Indexes for table `frontend_sections`
--
ALTER TABLE `frontend_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `frontend_sections_key_unique` (`key`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `id_card_designs`
--
ALTER TABLE `id_card_designs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_card_designs_slug_unique` (`slug`);

--
-- Indexes for table `inbound_messages`
--
ALTER TABLE `inbound_messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inbound_messages_message_id_unique` (`message_id`),
  ADD KEY `inbound_messages_school_id_mailbox_type_status_index` (`school_id`,`mailbox_type`,`status`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_plans`
--
ALTER TABLE `lesson_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_plans_school_id_foreign` (`school_id`),
  ADD KEY `lesson_plans_class_id_foreign` (`class_id`),
  ADD KEY `lesson_plans_section_id_foreign` (`section_id`),
  ADD KEY `lesson_plans_subject_id_foreign` (`subject_id`),
  ADD KEY `lesson_plans_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `main_contact_msgs`
--
ALTER TABLE `main_contact_msgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_newsletters`
--
ALTER TABLE `main_newsletters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `main_newsletters_email_unique` (`email`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marks_student_id_exam_id_subject_id_unique` (`student_id`,`exam_id`,`subject_id`),
  ADD KEY `marks_school_id_foreign` (`school_id`),
  ADD KEY `marks_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `marks_subject_id_foreign` (`subject_id`),
  ADD KEY `marks_exam_id_foreign` (`exam_id`),
  ADD KEY `marks_class_id_foreign` (`class_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newsletters_school_id_foreign` (`school_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notices_school_id_foreign` (`school_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `roles_school_id_foreign` (`school_id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `routines`
--
ALTER TABLE `routines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `routines_school_id_foreign` (`school_id`),
  ADD KEY `routines_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `routines_class_id_foreign` (`class_id`),
  ADD KEY `routines_section_id_foreign` (`section_id`),
  ADD KEY `routines_subject_id_foreign` (`subject_id`),
  ADD KEY `routines_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schools_slug_unique` (`slug`),
  ADD UNIQUE KEY `schools_app_code_unique` (`app_code`),
  ADD KEY `schools_subscription_package_id_foreign` (`subscription_package_id`),
  ADD KEY `schools_admission_academic_year_id_foreign` (`admission_academic_year_id`),
  ADD KEY `schools_representative_id_foreign` (`representative_id`);

--
-- Indexes for table `school_categories`
--
ALTER TABLE `school_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_categories_school_id_foreign` (`school_id`);

--
-- Indexes for table `school_delete_requests`
--
ALTER TABLE `school_delete_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_delete_requests_school_id_foreign` (`school_id`),
  ADD KEY `school_delete_requests_requested_by_foreign` (`requested_by`),
  ADD KEY `school_delete_requests_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `school_overviews`
--
ALTER TABLE `school_overviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_overviews_school_id_foreign` (`school_id`);

--
-- Indexes for table `school_subscriptions`
--
ALTER TABLE `school_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school_subscriptions_payment_reference_unique` (`payment_reference`),
  ADD KEY `school_subscriptions_subscription_package_id_foreign` (`subscription_package_id`),
  ADD KEY `school_subscriptions_school_id_status_index` (`school_id`,`status`),
  ADD KEY `school_subscriptions_payment_reference_index` (`payment_reference`),
  ADD KEY `school_subscriptions_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `school_sub_categories`
--
ALTER TABLE `school_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_sub_categories_school_id_foreign` (`school_id`),
  ADD KEY `school_sub_categories_school_category_id_foreign` (`school_category_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_school_id_foreign` (`school_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_school_id_student_id_unique` (`school_id`,`student_id`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_school_sub_category_id_foreign` (`school_sub_category_id`),
  ADD KEY `students_school_category_id_foreign` (`school_category_id`),
  ADD KEY `students_admission_id_foreign` (`admission_id`);

--
-- Indexes for table `student_fees`
--
ALTER TABLE `student_fees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_billing` (`student_id`,`fee_head_id`,`month`);

--
-- Indexes for table `student_fee_concessions`
--
ALTER TABLE `student_fee_concessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_head_concession` (`school_id`,`student_id`,`fee_head_id`),
  ADD KEY `student_fee_concessions_student_id_foreign` (`student_id`),
  ADD KEY `student_fee_concessions_fee_head_id_foreign` (`fee_head_id`);

--
-- Indexes for table `student_sessions`
--
ALTER TABLE `student_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_sessions_student_id_foreign` (`student_id`),
  ADD KEY `student_sessions_class_id_foreign` (`class_id`),
  ADD KEY `student_sessions_academic_year_id_foreign` (`academic_year_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjects_school_id_code_unique` (`school_id`,`code`),
  ADD KEY `subjects_school_category_id_foreign` (`school_category_id`),
  ADD KEY `subjects_school_sub_category_id_foreign` (`school_sub_category_id`);

--
-- Indexes for table `subscription_packages`
--
ALTER TABLE `subscription_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_replies`
--
ALTER TABLE `support_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_replies_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `support_tickets_ticket_id_unique` (`ticket_id`),
  ADD KEY `support_tickets_school_id_foreign` (`school_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_school_id_teacher_id_unique` (`school_id`,`teacher_id`),
  ADD UNIQUE KEY `teachers_school_id_email_unique` (`school_id`,`email`),
  ADD UNIQUE KEY `teachers_nid_unique` (`nid`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`),
  ADD UNIQUE KEY `teachers_phone_unique` (`phone`),
  ADD KEY `teachers_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `teacher_assign_subjects`
--
ALTER TABLE `teacher_assign_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_assign_subjects_school_id_foreign` (`school_id`),
  ADD KEY `teacher_assign_subjects_teacher_id_foreign` (`teacher_id`),
  ADD KEY `teacher_assign_subjects_class_id_foreign` (`class_id`),
  ADD KEY `teacher_assign_subjects_subject_id_foreign` (`subject_id`),
  ADD KEY `teacher_assign_subjects_section_id_foreign` (`section_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonials_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_sections`
--
ALTER TABLE `about_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `academicyears`
--
ALTER TABLE `academicyears`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_classes`
--
ALTER TABLE `assign_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `communication_settings`
--
ALTER TABLE `communication_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exam_categories`
--
ALTER TABLE `exam_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exam_routines`
--
ALTER TABLE `exam_routines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_amounts`
--
ALTER TABLE `fee_amounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fee_heads`
--
ALTER TABLE `fee_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `footer_settings`
--
ALTER TABLE `footer_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_sections`
--
ALTER TABLE `frontend_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `id_card_designs`
--
ALTER TABLE `id_card_designs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inbound_messages`
--
ALTER TABLE `inbound_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lesson_plans`
--
ALTER TABLE `lesson_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_contact_msgs`
--
ALTER TABLE `main_contact_msgs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_newsletters`
--
ALTER TABLE `main_newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `routines`
--
ALTER TABLE `routines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `school_categories`
--
ALTER TABLE `school_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `school_delete_requests`
--
ALTER TABLE `school_delete_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_overviews`
--
ALTER TABLE `school_overviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_subscriptions`
--
ALTER TABLE `school_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `school_sub_categories`
--
ALTER TABLE `school_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student_fees`
--
ALTER TABLE `student_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_fee_concessions`
--
ALTER TABLE `student_fee_concessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_sessions`
--
ALTER TABLE `student_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `subscription_packages`
--
ALTER TABLE `subscription_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `support_replies`
--
ALTER TABLE `support_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher_assign_subjects`
--
ALTER TABLE `teacher_assign_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `about_sections`
--
ALTER TABLE `about_sections`
  ADD CONSTRAINT `about_sections_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `academicyears`
--
ALTER TABLE `academicyears`
  ADD CONSTRAINT `academicyears_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admissions`
--
ALTER TABLE `admissions`
  ADD CONSTRAINT `admissions_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academicyears` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admissions_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admissions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assign_classes`
--
ALTER TABLE `assign_classes`
  ADD CONSTRAINT `assign_classes_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assign_classes_school_category_id_foreign` FOREIGN KEY (`school_category_id`) REFERENCES `school_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assign_classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assign_classes_school_sub_category_id_foreign` FOREIGN KEY (`school_sub_category_id`) REFERENCES `school_sub_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assign_classes_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_school_category_id_foreign` FOREIGN KEY (`school_category_id`) REFERENCES `school_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `communication_settings`
--
ALTER TABLE `communication_settings`
  ADD CONSTRAINT `communication_settings_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `academicyears` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_categories`
--
ALTER TABLE `exam_categories`
  ADD CONSTRAINT `exam_categories_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_categories_school_category_id_foreign` FOREIGN KEY (`school_category_id`) REFERENCES `school_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_routines`
--
ALTER TABLE `exam_routines`
  ADD CONSTRAINT `exam_routines_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_routines_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_routines_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_amounts`
--
ALTER TABLE `fee_amounts`
  ADD CONSTRAINT `fee_amounts_school_category_id_foreign` FOREIGN KEY (`school_category_id`) REFERENCES `school_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_amounts_school_sub_category_id_foreign` FOREIGN KEY (`school_sub_category_id`) REFERENCES `school_sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `footer_settings`
--
ALTER TABLE `footer_settings`
  ADD CONSTRAINT `footer_settings_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inbound_messages`
--
ALTER TABLE `inbound_messages`
  ADD CONSTRAINT `inbound_messages_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `lesson_plans`
--
ALTER TABLE `lesson_plans`
  ADD CONSTRAINT `lesson_plans_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `lesson_plans_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `lesson_plans_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `lesson_plans_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `lesson_plans_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academicyears` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD CONSTRAINT `newsletters_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `notices_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `routines`
--
ALTER TABLE `routines`
  ADD CONSTRAINT `routines_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academicyears` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `routines_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `routines_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `routines_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `routines_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `routines_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `schools_admission_academic_year_id_foreign` FOREIGN KEY (`admission_academic_year_id`) REFERENCES `academicyears` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `schools_representative_id_foreign` FOREIGN KEY (`representative_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `schools_subscription_package_id_foreign` FOREIGN KEY (`subscription_package_id`) REFERENCES `subscription_packages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `school_categories`
--
ALTER TABLE `school_categories`
  ADD CONSTRAINT `school_categories_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `school_delete_requests`
--
ALTER TABLE `school_delete_requests`
  ADD CONSTRAINT `school_delete_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `school_delete_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `school_delete_requests_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `school_overviews`
--
ALTER TABLE `school_overviews`
  ADD CONSTRAINT `school_overviews_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `school_subscriptions`
--
ALTER TABLE `school_subscriptions`
  ADD CONSTRAINT `school_subscriptions_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `school_subscriptions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `school_subscriptions_subscription_package_id_foreign` FOREIGN KEY (`subscription_package_id`) REFERENCES `subscription_packages` (`id`);

--
-- Constraints for table `school_sub_categories`
--
ALTER TABLE `school_sub_categories`
  ADD CONSTRAINT `school_sub_categories_school_category_id_foreign` FOREIGN KEY (`school_category_id`) REFERENCES `school_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `school_sub_categories_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_school_category_id_foreign` FOREIGN KEY (`school_category_id`) REFERENCES `school_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_school_sub_category_id_foreign` FOREIGN KEY (`school_sub_category_id`) REFERENCES `school_sub_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_fee_concessions`
--
ALTER TABLE `student_fee_concessions`
  ADD CONSTRAINT `student_fee_concessions_fee_head_id_foreign` FOREIGN KEY (`fee_head_id`) REFERENCES `fee_heads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_fee_concessions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_fee_concessions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_sessions`
--
ALTER TABLE `student_sessions`
  ADD CONSTRAINT `student_sessions_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academicyears` (`id`),
  ADD CONSTRAINT `student_sessions_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `student_sessions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_school_category_id_foreign` FOREIGN KEY (`school_category_id`) REFERENCES `school_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subjects_school_sub_category_id_foreign` FOREIGN KEY (`school_sub_category_id`) REFERENCES `school_sub_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `support_replies`
--
ALTER TABLE `support_replies`
  ADD CONSTRAINT `support_replies_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teachers_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_assign_subjects`
--
ALTER TABLE `teacher_assign_subjects`
  ADD CONSTRAINT `teacher_assign_subjects_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_assign_subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_assign_subjects_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_assign_subjects_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_assign_subjects_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
