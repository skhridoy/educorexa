-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 23, 2026 at 07:03 AM
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
(1, 1, '2026', '2026-01-01', '2026-12-31', 1, NULL, '2026-06-19 14:17:01', '2026-06-19 14:17:05');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
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
(1, 'স্মার্ট স্কুল ম্যানেজমেন্ট সিস্টেমের সুবিধা ও কার্যকারিতা', 'smart-school-management-system-benefits', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop', 1, 'শিক্ষা প্রযুক্তি', 'এডমিন', 'একটি আধুনিক ও প্রযুক্তি নির্ভর শিক্ষা প্রতিষ্ঠান পরিচালনায় ইআরপি সফটওয়্যারের ভূমিকা অপরিসীম। এটি শিক্ষক, শিক্ষার্থী এবং অভিভাবকদের কাজের সমন্বয় সহজ করে। ডিজিটাল অ্যাটেনডেন্স থেকে শুরু করে অনলাইন ফি আদায়, রেজাল্ট শিট প্রস্তুত করা সহ স্কুলের প্রতিদিনের কার্যক্রমকে স্বয়ংক্রিয় ও নির্ভুল করে তোলে।', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42'),
(2, 'শিক্ষার্থীদের মনোযোগ বৃদ্ধিতে শিক্ষকদের ভূমিকা', 'teachers-role-in-boosting-student-focus', 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=800&auto=format&fit=crop', 2, 'পরামর্শ', 'ফারহানা রহমান', 'শ্রেণীকক্ষে শিক্ষার্থীদের মনোযোগ আকর্ষণ ও তা ধরে রাখা প্রতিটি শিক্ষকের জন্যই একটি বড় চ্যালেঞ্জ। আধুনিক শিক্ষা পদ্ধতিতে মুখস্থ বিদ্যার চেয়ে ইন্টারেক্টিভ লার্নিং বা প্রশ্নোত্তরের মাধ্যমে পাঠদান করা বেশি কার্যকর। এছাড়া মাঝে মাঝে ছোট গ্রুপ স্টাডি বা কুইজের আয়োজন করলে শিক্ষার্থীরা পড়ালেখায় বেশি মনোযোগী হয়।', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42'),
(3, 'নতুন শিক্ষাবর্ষের বার্ষিক ক্রীড়া প্রতিযোগিতা ও পুরষ্কার বিতরণী', 'annual-sports-competition-new-academic-year', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800&auto=format&fit=crop', 3, 'ইভেন্ট', 'ক্রীড়া শিক্ষক', 'উৎসাহ ও উদ্দীপনার মধ্য দিয়ে উদযাপিত হলো আমাদের প্রতিষ্ঠানের বার্ষিক ক্রীড়া প্রতিযোগিতা। শিক্ষার্থীরা বিভিন্ন খেলাধূলায় অংশ নিয়ে তাদের প্রতিভা প্রদর্শন করেছে। প্রতিযোগিতা শেষে স্কুলের অধ্যক্ষ মহোদয় বিজয়ী শিক্ষার্থীদের হাতে মেডেল ও চ্যাম্পিয়ন ট্রফি তুলে দেন।', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42'),
(4, 'ডিজিটাল ক্লাসরুম যেভাবে পাঠদানকে সহজ করছে', 'how-digital-classrooms-simplify-teaching', 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop', 4, 'ডিজিটাল শিক্ষা', 'সাকিব আল হাসান', 'প্রজেক্টর ও মাল্টিমিডিয়া ক্লাসরুমের ব্যবহার শিক্ষার্থীদের পড়া সহজে বুঝতে এবং দীর্ঘক্ষণ মনে রাখতে দারুণ সহায়তা করছে। জটিল বৈজ্ঞানিক ফর্মুলা বা ঐতিহাসিক ঘটনাগুলো ভিডিও চিত্রের মাধ্যমে দেখানোর ফলে শিক্ষার্থীরা ক্লাসের পড়া দ্রুত আত্মস্থ করতে পারছে, যা ঐতিহ্যবাহী পাঠদানের চেয়ে অনেক বেশি কার্যকর।', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42'),
(5, 'অভিভাবক-শিক্ষক সভা: শিক্ষার্থীদের সার্বিক উন্নয়ন নিশ্চিতকরণ', 'parent-teacher-meeting-ensuring-student-growth', 'https://images.unsplash.com/photo-1544531516-a5e34e2d3df3?q=80&w=800&auto=format&fit=crop', 5, 'নোটিশ', 'অধ্যক্ষ', 'শিক্ষার্থীদের পড়ালেখার মানোন্নয়ন ও আচরণগত উন্নতির লক্ষ্যে অভিভাবক ও শিক্ষক মতবিনিময় সভার আয়োজন করা হয়েছিল। সভায় শিক্ষকদের পক্ষ থেকে শিক্ষার্থীদের দুর্বলতা ও শক্তিগুলো তুলে ধরা হয় এবং অভিভাবকেরা তাদের মূল্যবান মতামত শেয়ার করেন। সম্মিলিত প্রচেষ্টায় শিক্ষার্থীদের আগামী দিনে এগিয়ে নেওয়ার সিদ্ধান্ত গৃহীত হয়।', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42'),
(6, 'পরীক্ষার ভীতি দূর করার ৫টি সহজ বৈজ্ঞানিক উপায়', '5-scientific-ways-to-reduce-exam-fear', 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800&auto=format&fit=crop', 6, 'শিক্ষার্থী কর্নার', 'ডা. আরমান হোসেন', 'পরীক্ষার আগে মানসিক চাপ কমানো এবং স্মৃতিশক্তি বৃদ্ধির জন্য কার্যকরী কিছু বৈজ্ঞানিক টিপস রয়েছে। প্রথমত, নিয়মিত ও পর্যাপ্ত ঘুম নিশ্চিত করা। দ্বিতীয়ত, পড়ার মাঝে ছোট বিরতি (পোমোডোরো টেকনিক) নেওয়া। তৃতীয়ত, গ্রুপ ডিসকাশন করা এবং quarto, রিভিশনের জন্য ফ্ল্যাশকার্ড ব্যবহার করা।', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42');

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
(1, 'শিক্ষা প্রযুক্তি (EdTech)', 'edtech', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42'),
(2, 'পরামর্শ (Tips/Guides)', 'tips-guides', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42'),
(3, 'ইভেন্ট (Events)', 'events', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42'),
(4, 'ডিজিটাল শিক্ষা (Digital Learning)', 'digital-learning', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42'),
(5, 'নোটিশ (Announcements)', 'announcements', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42'),
(6, 'শিক্ষার্থী কর্নার (Student Corner)', 'student-corner', 1, '2026-06-22 20:25:42', '2026-06-22 20:25:42');

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
('educorexa-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:7:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"group_name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";s:1:\"j\";s:9:\"role_type\";s:1:\"m\";s:9:\"school_id\";}s:11:\"permissions\";a:81:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:20:\"academic-year.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:15:\"category.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:19:\"sub-category.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"class.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:14:\"section.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:14:\"subject.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"assign.subject\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:13:\"class.routine\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"syllabus.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:11:\"lesson.view\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:13:\"lesson.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:15:\"homework.manage\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:13:\"syllabus.view\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"syllabus.download\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:15:\"syllabus.upload\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"syllabus.delete\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"syllabus.approve\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:15:\"syllabus.reject\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:22:\"syllabus.view_rejected\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:22:\"syllabus.view_approved\";s:1:\"c\";s:8:\"Academic\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:16:\"admission.manage\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:13:\"student.index\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:14:\"student.create\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"student.edit\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:14:\"student.delete\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:14:\"student.manage\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:14:\"student.idcard\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:17:\"student.promotion\";s:1:\"c\";s:21:\"Students & Admissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:14:\"teacher.manage\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:29;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:14:\"assign.teacher\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:15:\"employee.manage\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:18:\"designation.manage\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:14:\"payroll.manage\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:12:\"leave.manage\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:34;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:17:\"attendance.manage\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:35;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:17:\"attendance.report\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:36;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"payroll.report\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:37;a:5:{s:1:\"a\";i:38;s:1:\"b\";s:12:\"staff.report\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:38;a:5:{s:1:\"a\";i:39;s:1:\"b\";s:12:\"staff.idcard\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:39;a:5:{s:1:\"a\";i:40;s:1:\"b\";s:15:\"staff.promotion\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:40;a:5:{s:1:\"a\";i:41;s:1:\"b\";s:14:\"staff.transfer\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:41;a:5:{s:1:\"a\";i:42;s:1:\"b\";s:17:\"staff.termination\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:42;a:5:{s:1:\"a\";i:43;s:1:\"b\";s:11:\"staff.leave\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:43;a:5:{s:1:\"a\";i:44;s:1:\"b\";s:16:\"staff.attendance\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:44;a:5:{s:1:\"a\";i:45;s:1:\"b\";s:13:\"staff.payroll\";s:1:\"c\";s:10:\"Staff & HR\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:45;a:5:{s:1:\"a\";i:46;s:1:\"b\";s:14:\"holiday.manage\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:46;a:5:{s:1:\"a\";i:47;s:1:\"b\";s:11:\"exam.manage\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:47;a:5:{s:1:\"a\";i:48;s:1:\"b\";s:11:\"mark.manage\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:48;a:5:{s:1:\"a\";i:49;s:1:\"b\";s:15:\"exam.admit_card\";s:1:\"c\";s:18:\"Attendance & Exams\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:49;a:5:{s:1:\"a\";i:50;s:1:\"b\";s:10:\"fee.manage\";s:1:\"c\";s:14:\"Finance (Fees)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:50;a:5:{s:1:\"a\";i:51;s:1:\"b\";s:11:\"fee.collect\";s:1:\"c\";s:14:\"Finance (Fees)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:51;a:5:{s:1:\"a\";i:52;s:1:\"b\";s:10:\"fee.report\";s:1:\"c\";s:14:\"Finance (Fees)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:52;a:5:{s:1:\"a\";i:53;s:1:\"b\";s:13:\"notice.manage\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:53;a:5:{s:1:\"a\";i:54;s:1:\"b\";s:13:\"slider.manage\";s:1:\"c\";s:8:\"Settings\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:54;a:5:{s:1:\"a\";i:55;s:1:\"b\";s:14:\"gallery.manage\";s:1:\"c\";s:8:\"Settings\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:55;a:5:{s:1:\"a\";i:56;s:1:\"b\";s:14:\"message.manage\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:56;a:5:{s:1:\"a\";i:57;s:1:\"b\";s:8:\"sms.send\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:57;a:5:{s:1:\"a\";i:58;s:1:\"b\";s:10:\"email.send\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:58;a:5:{s:1:\"a\";i:59;s:1:\"b\";s:13:\"whatsapp.send\";s:1:\"c\";s:23:\"Website & Communication\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:59;a:5:{s:1:\"a\";i:60;s:1:\"b\";s:17:\"newsletter.manage\";s:1:\"c\";s:8:\"Settings\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:60;a:5:{s:1:\"a\";i:61;s:1:\"b\";s:15:\"system.settings\";s:1:\"c\";s:8:\"Settings\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:61;a:5:{s:1:\"a\";i:62;s:1:\"b\";s:13:\"school.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:5:{s:1:\"a\";i:63;s:1:\"b\";s:13:\"school.create\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:5:{s:1:\"a\";i:64;s:1:\"b\";s:14:\"school.approve\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:5:{s:1:\"a\";i:65;s:1:\"b\";s:15:\"frontend.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:5:{s:1:\"a\";i:66;s:1:\"b\";s:13:\"school.reject\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:5:{s:1:\"a\";i:67;s:1:\"b\";s:13:\"school.delete\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:5:{s:1:\"a\";i:68;s:1:\"b\";s:15:\"settings.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:5:{s:1:\"a\";i:69;s:1:\"b\";s:18:\"super.roles.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:5:{s:1:\"a\";i:70;s:1:\"b\";s:21:\"contact.messages.view\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:5:{s:1:\"a\";i:71;s:1:\"b\";s:19:\"testimonial.approve\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:5:{s:1:\"a\";i:72;s:1:\"b\";s:14:\"support.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:5:{s:1:\"a\";i:73;s:1:\"b\";s:18:\"support.bot.manage\";s:1:\"c\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:5:{s:1:\"a\";i:74;s:1:\"b\";s:8:\"Academic\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:74;a:5:{s:1:\"a\";i:75;s:1:\"b\";s:21:\"Students & Admissions\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:75;a:5:{s:1:\"a\";i:76;s:1:\"b\";s:10:\"Staff & HR\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:76;a:5:{s:1:\"a\";i:77;s:1:\"b\";s:18:\"Attendance & Exams\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:77;a:5:{s:1:\"a\";i:78;s:1:\"b\";s:14:\"Finance (Fees)\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:78;a:5:{s:1:\"a\";i:79;s:1:\"b\";s:23:\"Website & Communication\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:79;a:5:{s:1:\"a\";i:80;s:1:\"b\";s:8:\"Settings\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:80;a:5:{s:1:\"a\";i:81;s:1:\"b\";s:43:\"SaaS Management (Super Admin/Employee Only)\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}}s:5:\"roles\";a:2:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super_admin\";s:1:\"d\";s:3:\"web\";s:1:\"j\";s:8:\"employee\";s:1:\"m\";N;}i:1;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"school_admin\";s:1:\"d\";s:3:\"web\";s:1:\"j\";s:12:\"school_staff\";s:1:\"m\";N;}}}', 1782246865);

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
(1, 1, 'One', '01', NULL, '2026-06-19 14:29:05', '2026-06-19 14:29:05', 1);

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
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 1, 1, 1, 1, NULL, 1000.00, '2026-06-19 14:37:08', '2026-06-19 14:37:08'),
(2, 1, 2, 1, 1, 1, 500.00, '2026-06-19 14:40:24', '2026-06-19 14:40:24');

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
(1, 1, 'Admission Fee', 'recurring', '2026-06-19 14:36:55', '2026-06-19 14:36:55'),
(2, 1, 'Tution Fee', 'monthly', '2026-06-19 14:40:05', '2026-06-19 14:40:05');

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
(1, 'hero', 'Hero Section', 1, NULL, 1, '2026-06-19 07:38:47', '2026-06-19 07:38:47'),
(2, 'features', 'Features Section', 1, NULL, 2, '2026-06-19 07:38:47', '2026-06-19 07:38:47'),
(3, 'why_choose_us', 'Why Choose Us', 1, NULL, 3, '2026-06-19 07:38:47', '2026-06-19 07:38:47'),
(4, 'setup-section', 'Setup Section', 1, NULL, 4, '2026-06-19 07:38:47', '2026-06-19 07:38:47'),
(5, 'pricing', 'Pricing Table', 1, NULL, 5, '2026-06-19 07:38:47', '2026-06-19 07:38:47'),
(6, 'about', 'About Us', 1, NULL, 6, '2026-06-19 07:38:47', '2026-06-19 07:38:47'),
(7, 'testimonials', 'Testimonials', 1, NULL, 7, '2026-06-19 07:38:47', '2026-06-19 07:38:47'),
(8, 'contact', 'Contact Section', 1, NULL, 8, '2026-06-19 07:38:47', '2026-06-19 07:38:47'),
(9, 'blogs', 'Blog Slider', 1, '\"{\\\"badge_text\\\":\\\"\\\\u0986\\\\u09ae\\\\u09be\\\\u09a6\\\\u09c7\\\\u09b0 \\\\u09ac\\\\u09cd\\\\u09b2\\\\u0997 \\\\u0993 \\\\u0996\\\\u09ac\\\\u09b0\\\",\\\"title\\\":\\\"\\\\u09b8\\\\u09b0\\\\u09cd\\\\u09ac\\\\u09b6\\\\u09c7\\\\u09b7 \\\\u0986\\\\u09aa\\\\u09a1\\\\u09c7\\\\u099f \\\\u0993 \\\\u09b6\\\\u09bf\\\\u0995\\\\u09cd\\\\u09b7\\\\u09be\\\\u09ae\\\\u09c2\\\\u09b2\\\\u0995 \\\\u09aa\\\\u09cd\\\\u09b0\\\\u09ac\\\\u09a8\\\\u09cd\\\\u09a7\\\",\\\"description\\\":\\\"\\\\u0986\\\\u09ae\\\\u09be\\\\u09a6\\\\u09c7\\\\u09b0 \\\\u09aa\\\\u09cd\\\\u09b0\\\\u09a4\\\\u09bf\\\\u09b7\\\\u09cd\\\\u09a0\\\\u09be\\\\u09a8\\\\u09c7\\\\u09b0 \\\\u09b8\\\\u09b0\\\\u09cd\\\\u09ac\\\\u09b6\\\\u09c7\\\\u09b7 \\\\u0996\\\\u09ac\\\\u09b0, \\\\u0998\\\\u099f\\\\u09a8\\\\u09be \\\\u098f\\\\u09ac\\\\u0982 \\\\u09b6\\\\u09bf\\\\u0995\\\\u09cd\\\\u09b7\\\\u09be\\\\u09ae\\\\u09c2\\\\u09b2\\\\u0995 \\\\u09ac\\\\u09cd\\\\u09b2\\\\u0997 \\\\u09aa\\\\u09cb\\\\u09b8\\\\u09cd\\\\u099f\\\\u0997\\\\u09c1\\\\u09b2\\\\u09cb \\\\u098f\\\\u0996\\\\u09be\\\\u09a8\\\\u09c7 \\\\u09aa\\\\u09dc\\\\u09c1\\\\u09a8\\\\u0964\\\"}\"', 9, '2026-06-22 19:42:43', '2026-06-22 19:42:43');

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
  `status` enum('present','absent') NOT NULL DEFAULT 'present',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(80, '2026_06_23_000000_create_blogs_table', 2),
(81, '2026_06_23_000001_create_blog_categories_table', 3),
(82, '2026_06_23_000002_add_blog_category_id_to_blogs_table', 3);

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
(7, 'App\\Models\\User', 3),
(7, 'App\\Models\\User', 4),
(7, 'App\\Models\\User', 5),
(7, 'App\\Models\\User', 6),
(7, 'App\\Models\\User', 7),
(7, 'App\\Models\\User', 8),
(7, 'App\\Models\\User', 9),
(7, 'App\\Models\\User', 10),
(7, 'App\\Models\\User', 11),
(7, 'App\\Models\\User', 12),
(7, 'App\\Models\\User', 13),
(7, 'App\\Models\\User', 14),
(8, 'App\\Models\\User', 2);

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
('7448a721-9e89-4eb8-ab08-6777945b5de6', 'App\\Notifications\\SuperAdminNotification', 'App\\Models\\User', 1, '{\"message\":\"New School Registered: Demo School and College\",\"icon\":\"home\",\"link\":\"http:\\/\\/schoolerp.test\\/manage\\/schools\\/pending\"}', NULL, '2026-06-19 08:05:46', '2026-06-19 08:05:46');

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
(1, 'academic-year.manage', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(2, 'category.manage', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(3, 'sub-category.manage', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(4, 'class.manage', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(5, 'section.manage', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(6, 'subject.manage', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(7, 'assign.subject', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(8, 'class.routine', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(9, 'syllabus.manage', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(10, 'lesson.view', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(11, 'lesson.manage', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(12, 'homework.manage', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(13, 'syllabus.view', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(14, 'syllabus.download', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(15, 'syllabus.upload', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(16, 'syllabus.delete', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(17, 'syllabus.approve', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(18, 'syllabus.reject', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(19, 'syllabus.view_rejected', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(20, 'syllabus.view_approved', 'Academic', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(21, 'admission.manage', 'Students & Admissions', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(22, 'student.index', 'Students & Admissions', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(23, 'student.create', 'Students & Admissions', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(24, 'student.edit', 'Students & Admissions', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(25, 'student.delete', 'Students & Admissions', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(26, 'student.manage', 'Students & Admissions', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(27, 'student.idcard', 'Students & Admissions', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(28, 'student.promotion', 'Students & Admissions', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(29, 'teacher.manage', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(30, 'assign.teacher', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(31, 'employee.manage', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(32, 'designation.manage', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(33, 'payroll.manage', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(34, 'leave.manage', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(35, 'attendance.manage', 'Attendance & Exams', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(36, 'attendance.report', 'Attendance & Exams', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(37, 'payroll.report', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(38, 'staff.report', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(39, 'staff.idcard', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(40, 'staff.promotion', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(41, 'staff.transfer', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(42, 'staff.termination', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(43, 'staff.leave', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(44, 'staff.attendance', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(45, 'staff.payroll', 'Staff & HR', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(46, 'holiday.manage', 'Attendance & Exams', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(47, 'exam.manage', 'Attendance & Exams', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(48, 'mark.manage', 'Attendance & Exams', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(49, 'exam.admit_card', 'Attendance & Exams', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(50, 'fee.manage', 'Finance (Fees)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(51, 'fee.collect', 'Finance (Fees)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(52, 'fee.report', 'Finance (Fees)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(53, 'notice.manage', 'Website & Communication', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(54, 'slider.manage', 'Settings', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(55, 'gallery.manage', 'Settings', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(56, 'message.manage', 'Website & Communication', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(57, 'sms.send', 'Website & Communication', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(58, 'email.send', 'Website & Communication', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(59, 'whatsapp.send', 'Website & Communication', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(60, 'newsletter.manage', 'Settings', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(61, 'system.settings', 'Settings', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(62, 'school.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(63, 'school.create', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(64, 'school.approve', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(65, 'frontend.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(66, 'school.reject', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(67, 'school.delete', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(68, 'settings.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(69, 'super.roles.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(70, 'contact.messages.view', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(71, 'testimonial.approve', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(72, 'support.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(73, 'support.bot.manage', 'SaaS Management (Super Admin/Employee Only)', 'web', '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(74, 'Academic', NULL, 'web', '2026-06-19 08:10:20', '2026-06-19 08:10:20'),
(75, 'Students & Admissions', NULL, 'web', '2026-06-19 08:10:20', '2026-06-19 08:10:20'),
(76, 'Staff & HR', NULL, 'web', '2026-06-19 08:10:20', '2026-06-19 08:10:20'),
(77, 'Attendance & Exams', NULL, 'web', '2026-06-19 08:10:20', '2026-06-19 08:10:20'),
(78, 'Finance (Fees)', NULL, 'web', '2026-06-19 08:10:20', '2026-06-19 08:10:20'),
(79, 'Website & Communication', NULL, 'web', '2026-06-19 08:10:20', '2026-06-19 08:10:20'),
(80, 'Settings', NULL, 'web', '2026-06-19 08:10:20', '2026-06-19 08:10:20'),
(81, 'SaaS Management (Super Admin/Employee Only)', NULL, 'web', '2026-06-19 08:10:20', '2026-06-19 08:10:20');

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
(1, 'super_admin', 'web', 'employee', '2026-06-19 07:30:57', '2026-06-19 07:30:57', NULL),
(2, 'HR', 'web', 'employee', '2026-06-19 07:30:57', '2026-06-19 07:30:57', NULL),
(3, 'Marketing', 'web', 'employee', '2026-06-19 07:30:57', '2026-06-19 07:30:57', NULL),
(4, 'Support', 'web', 'employee', '2026-06-19 07:30:57', '2026-06-19 07:30:57', NULL),
(5, 'Accountant', 'web', 'employee', '2026-06-19 07:30:57', '2026-06-19 07:30:57', NULL),
(6, 'teacher', 'web', 'school_staff', '2026-06-19 07:30:57', '2026-06-19 07:30:57', NULL),
(7, 'student', 'web', 'school_staff', '2026-06-19 07:30:57', '2026-06-19 07:30:57', NULL),
(8, 'school_admin', 'web', 'school_staff', '2026-06-19 07:30:57', '2026-06-19 07:30:57', NULL);

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
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 8),
(75, 8),
(76, 8),
(77, 8),
(78, 8),
(79, 8),
(80, 8),
(81, 8);

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
  `name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
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
  `favicon` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `ein_number` varchar(255) DEFAULT NULL,
  `emis_code` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
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

INSERT INTO `schools` (`id`, `name`, `logo`, `mail_mailer`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `whatsapp_api_provider`, `whatsapp_api_key`, `whatsapp_api_instance_id`, `favicon`, `slug`, `email`, `phone`, `ein_number`, `emis_code`, `address`, `status`, `subscription_package_id`, `is_active`, `created_at`, `updated_at`, `pro_email_status`, `pro_email_address`, `pro_email_password`, `pro_email_prefix`) VALUES
(1, 'Demo School and College', 'uploads/schools/demo/logo/logo_1781882524.png', 'smtp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'demo', 'demo@schoolerp.com', NULL, NULL, NULL, NULL, 'approved', 1, 1, '2026-06-19 08:05:44', '2026-06-19 15:22:04', 'none', NULL, NULL, NULL);

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
(1, 1, 'Primary', 3, '2026-06-19 14:28:20', '2026-06-19 14:28:20');

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
(1, 1, 1, 'General', '2026-06-19 14:28:51', '2026-06-19 14:28:51');

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
(1, 1, 'A', 'This is demo section', '2026-06-19 14:29:20', '2026-06-19 14:29:20');

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
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
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

INSERT INTO `site_settings` (`id`, `site_name`, `meta_title`, `meta_description`, `meta_keywords`, `logo_wide`, `logo_square`, `favicon`, `og_image`, `mail_mailer`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `address`, `phone`, `email`, `footer_text`, `facebook_url`, `twitter_url`, `instagram_url`, `linkedin_url`, `created_at`, `updated_at`) VALUES
(1, 'EduCorexa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'smtp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'support@educorexa.com', 'All Rights Reserved', NULL, NULL, NULL, NULL, '2026-06-19 07:38:46', '2026-06-19 07:38:46');

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

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `school_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `roll` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `previous_school` varchar(255) DEFAULT NULL,
  `previous_class` varchar(255) DEFAULT NULL,
  `fathers_name` varchar(255) DEFAULT NULL,
  `mothers_name` varchar(255) DEFAULT NULL,
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `school_id`, `academic_year_id`, `class_id`, `school_category_id`, `section_id`, `student_id`, `roll`, `name`, `previous_school`, `previous_class`, `fathers_name`, `mothers_name`, `father_nid`, `mother_nid`, `student_birth_nid`, `contact_number`, `password`, `photo`, `status`, `created_by`, `religion`, `gender`, `date_of_birth`, `admission_date`, `blood_group`, `address`, `created_at`, `updated_at`, `school_sub_category_id`) VALUES
(1, 3, 1, 1, 1, 1, 1, 'STD-261001', 1, 'Sagor Hossain', NULL, NULL, 'Jalal Ahmed', 'Sufia Begum', NULL, NULL, NULL, '1712345678', '$2y$12$NQyaLzeYIhn2joTzfO.go.rP4b1uQPwfBdnBe73jw2slW6bXb4kc.', NULL, 'active', 2, 'Islam', 'Male', '2012-05-10', NULL, 'A+', 'Nilphamari', '2026-06-19 14:36:01', '2026-06-19 14:36:01', 1),
(2, 4, 1, 1, 1, 1, 1, 'STD-261002', 2, 'Sumaiya Akter', NULL, NULL, 'Karim Ali', 'Amena Bibi', NULL, NULL, NULL, '1812345678', '$2y$12$Q1g1wsTtIWwGdtSchNFVH.DWSsuSChgIxf4oc7nXWHntWkOZ/q4Qy', NULL, 'active', 2, 'Islam', 'Female', '2013-03-20', NULL, 'O+', 'Nilphamari', '2026-06-19 14:36:01', '2026-06-19 14:36:01', 1),
(3, 5, 1, 1, 1, 1, 1, 'STD-261003', 3, 'Manos Kumar', NULL, NULL, 'Rakib Ahmed', 'Sumi Akter', NULL, NULL, NULL, '1812345678', '$2y$12$2ZJMjzAVeEgoeUVZMnNzWuahpH9GZxHy.JpdTao3Cis09dDedfFwq', NULL, 'active', 2, 'Hinduism', 'Male', '2013-03-21', NULL, 'O+', 'Nilphamari', '2026-06-19 14:36:02', '2026-06-19 14:36:02', 1),
(4, 6, 1, 1, 1, 1, 1, 'STD-261004', 4, 'Noyon Roy', NULL, NULL, 'Puspo Roy', 'Shyamoli Rani', NULL, NULL, NULL, '1812345678', '$2y$12$pqrMkAhwobEXfD0wDNSavOffnHutLw1pVbMqiG9KxJeOUBOvdmX/m', NULL, 'active', 2, 'Hinduism', 'Male', '2013-03-22', NULL, 'O+', 'Nilphamari', '2026-06-19 14:36:02', '2026-06-19 14:36:02', 1),
(5, 7, 1, 1, 1, 1, 1, 'STD-261005', 5, 'Nobonita Rani', NULL, NULL, 'Rabbani Islam', 'Sumi Akter', NULL, NULL, NULL, '1812345678', '$2y$12$Nb.8tEtDzzL5kbx6fJTvre6BbokRevnqkPcCMdQTOUfaBrUSI56GC', NULL, 'active', 2, 'Hinduism', 'Female', '2013-03-23', NULL, 'O+', 'Nilphamari', '2026-06-19 14:36:03', '2026-06-19 14:36:03', 1),
(6, 8, 1, 1, 1, 1, 1, 'STD-261006', 6, 'Kamrun Nahar', NULL, NULL, 'Rahim', 'Sumi Akter', NULL, NULL, NULL, '1812345678', '$2y$12$seWOdR48.lFwE9RZQPNoP.5Ii3QQQBmfDXjK19dKucThUxovhT4/e', NULL, 'active', 2, 'Islam', 'Female', '2013-03-24', NULL, 'O+', 'Nilphamari', '2026-06-19 14:36:03', '2026-06-19 14:36:03', 1),
(7, 9, 1, 1, 1, 1, 1, 'STD-261007', 7, 'Manun Islam', NULL, NULL, 'Jalal Ahmed', 'Sufia Begum', NULL, NULL, NULL, '1712345678', '$2y$12$08rOeEJzkoyoQSV2ic8/M.2ZGSlj.DYfEIxh0k9b6W2YjZj4R8mty', NULL, 'active', 2, 'Islam', 'Male', '2012-05-10', NULL, 'A+', 'Nilphamari', '2026-06-19 14:36:04', '2026-06-19 14:36:04', 1),
(8, 10, 1, 1, 1, 1, 1, 'STD-261008', 8, 'Limu Akter', NULL, NULL, 'Karim Ali', 'Amena Bibi', NULL, NULL, NULL, '1812345678', '$2y$12$S4wuk.1BGuF3yIFGGm8DdOY3.a3U9NBkp8xxvFXyTYQQkXmwfl65K', NULL, 'active', 2, 'Islam', 'Female', '2013-03-20', NULL, 'O+', 'Nilphamari', '2026-06-19 14:36:04', '2026-06-19 14:36:04', 1),
(9, 11, 1, 1, 1, 1, 1, 'STD-261009', 9, 'Antor Kumar', NULL, NULL, 'Rakib Ahmed', 'Sumi Akter', NULL, NULL, NULL, '1812345678', '$2y$12$TpdclVyA.yZEqXyDBicsteYmw2cbzHlpZX2g3JEmMDW8qDoFxjgWa', NULL, 'active', 2, 'Hinduism', 'Male', '2013-03-21', NULL, 'O+', 'Nilphamari', '2026-06-19 14:36:05', '2026-06-19 14:36:05', 1),
(10, 12, 1, 1, 1, 1, 1, 'STD-261010', 10, 'Niranjan Roy', NULL, NULL, 'Puspo Roy', 'Shyamoli Rani', NULL, NULL, NULL, '1812345678', '$2y$12$4P6ehJU/89l4p4yJfUXkwOvEA4tiqwX808c9VpGagUPVMXdpzUNaO', NULL, 'active', 2, 'Hinduism', 'Male', '2013-03-22', NULL, 'O+', 'Nilphamari', '2026-06-19 14:36:05', '2026-06-19 14:36:05', 1),
(11, 13, 1, 1, 1, 1, 1, 'STD-261011', 11, 'Kabita Rani', NULL, NULL, 'Rabbani Islam', 'Sumi Akter', NULL, NULL, NULL, '1812345678', '$2y$12$EQxuvxkkSXBqaGwEzKzuI.Y0sdSMbFIwp9nq4Kq4mP/0Wlvx6lije', NULL, 'active', 2, 'Hinduism', 'Female', '2013-03-23', NULL, 'O+', 'Nilphamari', '2026-06-19 14:36:06', '2026-06-19 14:36:06', 1),
(12, 14, 1, 1, 1, 1, 1, 'STD-261012', 12, 'Ajmin Akter', NULL, NULL, 'Rahim', 'Sumi Akter', NULL, NULL, NULL, '1812345678', '$2y$12$m3pOdNiGY.hnUUrTR1CA0./rJTB.Wu2d0TZNzQS.PGL/ymB7k9KB6', NULL, 'active', 2, 'Islam', 'Female', '2013-03-24', NULL, 'O+', 'Nilphamari', '2026-06-19 14:36:06', '2026-06-19 14:36:06', 1);

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

INSERT INTO `student_fees` (`id`, `school_id`, `school_category_id`, `school_sub_category_id`, `student_id`, `fee_head_id`, `amount`, `month`, `status`, `payment_method`, `receipt_no`, `collected_by`, `due_date`, `created_at`, `updated_at`, `fee_type_limit`) VALUES
(1, 1, 1, 1, 1, 1, 1000.00, 'March-2026', 'paid', 'cash', 'R0619-67B4', 2, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:40:54', 'global'),
(2, 1, 1, 1, 2, 1, 1000.00, 'March-2026', 'paid', 'cash', 'R0619-7F3C', 2, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 15:25:05', 'global'),
(3, 1, 1, 1, 3, 1, 1000.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:37:25', 'global'),
(4, 1, 1, 1, 4, 1, 1000.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:37:25', 'global'),
(5, 1, 1, 1, 5, 1, 1000.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:37:25', 'global'),
(6, 1, 1, 1, 6, 1, 1000.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:37:25', 'global'),
(7, 1, 1, 1, 7, 1, 1000.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:37:25', 'global'),
(8, 1, 1, 1, 8, 1, 1000.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:37:25', 'global'),
(9, 1, 1, 1, 9, 1, 1000.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:37:25', 'global'),
(10, 1, 1, 1, 10, 1, 1000.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:37:25', 'global'),
(11, 1, 1, 1, 11, 1, 1000.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:37:25', 'global'),
(12, 1, 1, 1, 12, 1, 1000.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:37:25', '2026-06-19 14:37:25', 'global'),
(13, 1, 1, 1, 1, 2, 500.00, 'March-2026', 'paid', 'cash', 'R0619-67B4', 2, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:54', 'global'),
(14, 1, 1, 1, 2, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global'),
(15, 1, 1, 1, 3, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global'),
(16, 1, 1, 1, 4, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global'),
(17, 1, 1, 1, 5, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global'),
(18, 1, 1, 1, 6, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global'),
(19, 1, 1, 1, 7, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global'),
(20, 1, 1, 1, 8, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global'),
(21, 1, 1, 1, 9, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global'),
(22, 1, 1, 1, 10, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global'),
(23, 1, 1, 1, 11, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global'),
(24, 1, 1, 1, 12, 2, 500.00, 'March-2026', 'unpaid', 'cash', NULL, NULL, '2026-06-30', '2026-06-19 14:40:36', '2026-06-19 14:40:36', 'global');

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

-- --------------------------------------------------------

--
-- Table structure for table `subscription_packages`
--

CREATE TABLE `subscription_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
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

INSERT INTO `subscription_packages` (`id`, `name`, `description`, `price`, `duration`, `student_limit`, `teacher_limit`, `features`, `permissions`, `is_popular`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Production', 'Testing package', 0.00, 'yearly', NULL, NULL, '[]', '{\"0\":\"academic-year.manage\",\"1\":\"category.manage\",\"2\":\"sub-category.manage\",\"3\":\"class.manage\",\"4\":\"section.manage\",\"5\":\"subject.manage\",\"6\":\"assign.subject\",\"7\":\"class.routine\",\"8\":\"syllabus.manage\",\"9\":\"lesson.view\",\"10\":\"lesson.manage\",\"11\":\"homework.manage\",\"12\":\"syllabus.view\",\"13\":\"syllabus.download\",\"14\":\"syllabus.upload\",\"15\":\"syllabus.delete\",\"16\":\"syllabus.approve\",\"17\":\"syllabus.reject\",\"18\":\"syllabus.view_rejected\",\"19\":\"syllabus.view_approved\",\"20\":\"admission.manage\",\"21\":\"student.index\",\"22\":\"student.create\",\"23\":\"student.edit\",\"24\":\"student.delete\",\"25\":\"student.manage\",\"26\":\"student.idcard\",\"27\":\"student.promotion\",\"28\":\"teacher.manage\",\"29\":\"employee.manage\",\"30\":\"designation.manage\",\"31\":\"payroll.manage\",\"32\":\"leave.manage\",\"33\":\"attendance.manage\",\"34\":\"attendance.report\",\"35\":\"payroll.report\",\"36\":\"staff.report\",\"37\":\"staff.idcard\",\"38\":\"staff.promotion\",\"39\":\"staff.transfer\",\"40\":\"staff.termination\",\"41\":\"staff.leave\",\"42\":\"staff.attendance\",\"43\":\"staff.payroll\",\"46\":\"holiday.manage\",\"47\":\"exam.manage\",\"48\":\"mark.manage\",\"49\":\"exam.admit_card\",\"50\":\"fee.manage\",\"51\":\"fee.collect\",\"52\":\"fee.report\",\"53\":\"notice.manage\",\"54\":\"slider.manage\",\"55\":\"gallery.manage\",\"56\":\"message.manage\",\"57\":\"sms.send\",\"58\":\"email.send\",\"59\":\"whatsapp.send\",\"60\":\"newsletter.manage\",\"61\":\"system.settings\",\"67\":\"profile.manage\"}', 0, 1, '2026-06-19 08:09:58', '2026-06-19 08:09:58');

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
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `school_id`, `teacher_id`, `name`, `role`, `email`, `phone`, `facebook`, `twitter`, `linkedin`, `insta`, `photo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Super Admin', 'super_admin', 'superadmin@schoolerp.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$vfftSWuvOVReEqSR49vgJ.z4kw1UAMv6CVxx0ElzHBGXQN9287CdS', NULL, '2026-06-19 07:30:57', '2026-06-19 07:30:57'),
(2, 1, NULL, 'Demo', 'school_admin', 'demo@schoolerp.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$TbFnhsAoaanauaSI1.mij.IbKUnVnZn22CpQ.UMAreCxLtHXhpWo2', NULL, '2026-06-19 08:05:44', '2026-06-19 08:05:44'),
(3, 1, NULL, 'Sagor Hossain', 'student', 'STD-261001@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$2GEh4/YviUu/a3HZNdWhiebKsGO/tlswE/voW2xDNjZQNPH5QS7Ye', NULL, '2026-06-19 14:36:00', '2026-06-19 14:36:00'),
(4, 1, NULL, 'Sumaiya Akter', 'student', 'STD-261002@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$pkG6mLnlVabsXO0v09SwVeGdxQyaz/nAggHThRfzN/mFjiLO/kdmq', NULL, '2026-06-19 14:36:01', '2026-06-19 14:36:01'),
(5, 1, NULL, 'Manos Kumar', 'student', 'STD-261003@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$Byz8axEmVpFxT4RUIkJPRuqUa2FnAgUmW.peqmTNToNdPYitXDteS', NULL, '2026-06-19 14:36:01', '2026-06-19 14:36:01'),
(6, 1, NULL, 'Noyon Roy', 'student', 'STD-261004@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$tfrx3RscRYnPOOlPdp.V6eo9WgH5FU72xJqEFR9H/FFcl2FJPUTE.', NULL, '2026-06-19 14:36:02', '2026-06-19 14:36:02'),
(7, 1, NULL, 'Nobonita Rani', 'student', 'STD-261005@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$/EWAvuSJZEsark43e01p2OG4QlPAp3iiDLQsh0x/kJ59zYdxK0Kji', NULL, '2026-06-19 14:36:02', '2026-06-19 14:36:02'),
(8, 1, NULL, 'Kamrun Nahar', 'student', 'STD-261006@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$kzGtSLNX.52uhydhP1R98uwSDYFpXtcCDow5Mrf5LM6evpnRhnYiy', NULL, '2026-06-19 14:36:03', '2026-06-19 14:36:03'),
(9, 1, NULL, 'Manun Islam', 'student', 'STD-261007@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$Yu5QVfrI2m.9o2Bzv7aXvuhdEbRel7emNj8aTQMYzNwkFa9cPNagq', NULL, '2026-06-19 14:36:04', '2026-06-19 14:36:04'),
(10, 1, NULL, 'Limu Akter', 'student', 'STD-261008@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$FKvFsk6ctJWp2946679IPexkAtx05cqrTuYVz3HCVyITozvGCFI8.', NULL, '2026-06-19 14:36:04', '2026-06-19 14:36:04'),
(11, 1, NULL, 'Antor Kumar', 'student', 'STD-261009@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$wqs3t7WaAWeYxTNe6o32KOP2Xek/1VofqMa5oDE2Ijh/CW0pW3Rlq', NULL, '2026-06-19 14:36:05', '2026-06-19 14:36:05'),
(12, 1, NULL, 'Niranjan Roy', 'student', 'STD-261010@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$RODU7mHKAc5SZKDfXm1cdu58TGVpGPvFd0.OY3OxE7VmdoTQk5TuO', NULL, '2026-06-19 14:36:05', '2026-06-19 14:36:05'),
(13, 1, NULL, 'Kabita Rani', 'student', 'STD-261011@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$olt.YSarqPmyFa3hAVCdNu1ZDgebNvgKWLwyP5E0qgDergndD48ha', NULL, '2026-06-19 14:36:06', '2026-06-19 14:36:06'),
(14, 1, NULL, 'Ajmin Akter', 'student', 'STD-261012@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$I.KjOYpf50mwi.3zxhVsfuppw8rCZRIprKKcg2QOfSJLtdXhFQe5y', NULL, '2026-06-19 14:36:06', '2026-06-19 14:36:06');

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
  ADD UNIQUE KEY `fee_heads_school_id_name_unique` (`school_id`,`name`),
  ADD UNIQUE KEY `fee_heads_name_unique` (`name`);

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
  ADD KEY `schools_subscription_package_id_foreign` (`subscription_package_id`);

--
-- Indexes for table `school_categories`
--
ALTER TABLE `school_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_categories_school_id_foreign` (`school_id`);

--
-- Indexes for table `school_overviews`
--
ALTER TABLE `school_overviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_overviews_school_id_foreign` (`school_id`);

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
  ADD UNIQUE KEY `students_student_id_unique` (`student_id`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_school_sub_category_id_foreign` (`school_sub_category_id`),
  ADD KEY `students_school_category_id_foreign` (`school_category_id`);

--
-- Indexes for table `student_fees`
--
ALTER TABLE `student_fees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_billing` (`student_id`,`fee_head_id`,`month`);

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
  ADD UNIQUE KEY `teachers_teacher_id_unique` (`teacher_id`),
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `communication_settings`
--
ALTER TABLE `communication_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_amounts`
--
ALTER TABLE `fee_amounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fee_heads`
--
ALTER TABLE `fee_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `routines`
--
ALTER TABLE `routines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_categories`
--
ALTER TABLE `school_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_overviews`
--
ALTER TABLE `school_overviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_sub_categories`
--
ALTER TABLE `school_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student_fees`
--
ALTER TABLE `student_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `student_sessions`
--
ALTER TABLE `student_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_packages`
--
ALTER TABLE `subscription_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_assign_subjects`
--
ALTER TABLE `teacher_assign_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  ADD CONSTRAINT `schools_subscription_package_id_foreign` FOREIGN KEY (`subscription_package_id`) REFERENCES `subscription_packages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `school_categories`
--
ALTER TABLE `school_categories`
  ADD CONSTRAINT `school_categories_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `school_overviews`
--
ALTER TABLE `school_overviews`
  ADD CONSTRAINT `school_overviews_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `students_school_category_id_foreign` FOREIGN KEY (`school_category_id`) REFERENCES `school_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_school_sub_category_id_foreign` FOREIGN KEY (`school_sub_category_id`) REFERENCES `school_sub_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
