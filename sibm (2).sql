-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 06:58 AM
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
-- Database: `sibm`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `model_type` varchar(191) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `url` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `url`, `created_at`, `updated_at`) VALUES
(1, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-13 22:39:19', '2025-10-13 22:39:19'),
(2, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-14 06:58:30', '2025-10-14 06:58:30'),
(3, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-14 20:28:05', '2025-10-14 20:28:05'),
(4, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-15 00:10:29', '2025-10-15 00:10:29'),
(5, 1, 'logout', NULL, NULL, '[]', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', '2025-10-15 00:55:02', '2025-10-15 00:55:02'),
(6, 1, 'logout', NULL, NULL, '[]', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', '2025-10-15 00:57:39', '2025-10-15 00:57:39'),
(7, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-15 05:54:17', '2025-10-15 05:54:17'),
(8, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-15 20:13:55', '2025-10-15 20:13:55'),
(9, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-17 23:12:54', '2025-10-17 23:12:54'),
(10, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-19 19:07:54', '2025-10-19 19:07:54'),
(11, 1, 'logout', NULL, NULL, '[]', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', '2025-10-19 19:28:55', '2025-10-19 19:28:55'),
(12, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-19 20:24:13', '2025-10-19 20:24:13'),
(13, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-21 18:03:34', '2025-10-21 18:03:34'),
(14, 1, 'logout', NULL, NULL, '[]', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', '2025-10-21 18:12:32', '2025-10-21 18:12:32'),
(15, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-21 18:12:47', '2025-10-21 18:12:47'),
(16, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-23 20:04:00', '2025-10-23 20:04:00'),
(17, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-27 03:10:10', '2025-10-27 03:10:10'),
(18, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-06 22:17:18', '2025-11-06 22:17:18'),
(19, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-10 18:11:00', '2025-11-10 18:11:00'),
(20, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-11 20:34:12', '2025-11-11 20:34:12'),
(21, NULL, 'login_failed', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-13 23:49:24', '2025-11-13 23:49:24'),
(22, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-13 23:49:29', '2025-11-13 23:49:29'),
(23, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-17 20:52:29', '2025-11-17 20:52:29'),
(24, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-18 00:28:31', '2025-11-18 00:28:31'),
(25, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-22 00:07:11', '2025-11-22 00:07:11'),
(26, 1, 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-12-14 22:25:22', '2025-12-14 22:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_responses`
--

CREATE TABLE `chatbot_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trigger_name` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `keywords` text NOT NULL,
  `response` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `priority` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot_responses`
--

INSERT INTO `chatbot_responses` (`id`, `trigger_name`, `title`, `keywords`, `response`, `is_active`, `priority`, `created_at`, `updated_at`) VALUES
(1, 'greeting', 'Salam & Perkenalan', '[\"halo\",\"hai\",\"hello\",\"hi\",\"assalamualaikum\"]', 'Halo! 😊 Selamat datang di SMK Bina Mandiri Bekasi. Saya asisten virtual yang siap membantu Anda. Ada yang bisa saya bantu?', 0, 100, '2025-10-15 05:53:01', '2025-10-21 18:04:00'),
(2, 'profile', 'Profil Sekolah', '[\"profil\",\"tentang sekolah\",\"tentang smk\",\"sekolah\"]', '🏫 **SMK Bina Mandiri Bekasi** adalah sekolah menengah kejuruan yang berfokus pada pengembangan keterampilan praktis dan profesional.\n\n📍 **Alamat:** Jl. Pendidikan No. 123, Bekasi Timur, Kota Bekasi\n📞 **Telepon:** (021) 1234-5678\n📧 **Email:** info@smkbinamandiri.sch.id\n\nKami berkomitmen mencetak lulusan yang siap kerja dan berdaya saing tinggi! 💪', 1, 90, '2025-10-15 05:53:01', '2025-10-15 05:53:01'),
(3, 'visi_misi', 'Visi & Misi', '[\"visi\",\"misi\",\"visi misi\"]', '🎯 **Visi:**\nMenjadi SMK unggulan yang menghasilkan lulusan berkualitas, profesional, dan berakhlak mulia.\n\n📋 **Misi:**\n1. Menyelenggarakan pendidikan berkualitas berbasis kompetensi\n2. Mengembangkan kerjasama dengan dunia industri\n3. Membentuk karakter siswa yang berakhlak mulia\n4. Menyediakan fasilitas pembelajaran modern', 1, 85, '2025-10-15 05:53:01', '2025-10-15 05:53:01'),
(4, 'jurusan', 'Program Keahlian/Jurusan', '[\"jurusan\",\"program keahlian\",\"kompetensi\",\"tkj\",\"akuntansi\",\"dkv\"]', '📚 **Program Keahlian di SMK Bina Mandiri Bekasi:**\n\n1. **Teknik Komputer & Jaringan (TKJ)** 💻\n   - Belajar networking, programming, dan sistem komputer\n   - Prospek: Network Administrator, IT Support, Web Developer\n\n2. **Akuntansi** 💰\n   - Belajar pembukuan, perpajakan, dan keuangan\n   - Prospek: Akuntan, Staff Keuangan, Auditor\n\n3. **Desain Komunikasi Visual (DKV)** 🎨\n   - Belajar desain grafis, multimedia, dan animasi\n   - Prospek: Graphic Designer, Video Editor, UI/UX Designer\n\nMau tahu lebih detail tentang jurusan tertentu? Tanya saja! 😊', 1, 95, '2025-10-15 05:53:01', '2025-10-15 05:53:01'),
(5, 'ppdb', 'PPDB (Pendaftaran)', '[\"ppdb\",\"pendaftaran\",\"daftar\",\"cara daftar\",\"syarat\"]', '📝 **Informasi PPDB SMK Bina Mandiri Bekasi:**\n\n📅 **Jadwal Pendaftaran:**\nGelombang 1: Januari - Maret 2026\nGelombang 2: April - Juni 2026\n\n📋 **Syarat Pendaftaran:**\n✅ Ijazah/SKHUN SMP/MTs\n✅ Kartu Keluarga\n✅ Akta Kelahiran\n✅ Pas Foto 3x4 (3 lembar)\n✅ Fotocopy Rapor Semester 1-5\n\n💻 **Cara Daftar:**\nKunjungi website kami dan klik menu \'PPDB\' atau datang langsung ke sekolah!\n\n💰 **Biaya:** Gratis biaya pendaftaran! 🎉', 1, 95, '2025-10-15 05:53:01', '2025-10-15 05:53:01'),
(6, 'fasilitas', 'Fasilitas Sekolah', '[\"fasilitas\",\"sarana\",\"prasarana\",\"lab\",\"perpustakaan\"]', '🏢 **Fasilitas SMK Bina Mandiri Bekasi:**\n\n✅ Ruang kelas ber-AC\n✅ Laboratorium Komputer\n✅ Laboratorium Akuntansi\n✅ Studio Desain & Multimedia\n✅ Perpustakaan Digital\n✅ Masjid\n✅ Kantin\n✅ Lapangan Olahraga\n✅ Free WiFi\n✅ Parkir Luas\n\nSemua fasilitas dirancang untuk mendukung pembelajaran optimal! 🎓', 1, 80, '2025-10-15 05:53:01', '2025-10-15 05:53:01'),
(7, 'contact', 'Alamat & Kontak', '[\"alamat\",\"lokasi\",\"dimana\",\"kontak\",\"telepon\",\"email\"]', '📍 **Alamat & Kontak SMK Bina Mandiri Bekasi:**\n\n🏫 Jl. Pendidikan No. 123, Bekasi Timur\n   Kota Bekasi, Jawa Barat 17113\n\n📞 Telepon: (021) 1234-5678\n📱 WhatsApp: 0812-3456-7890\n📧 Email: info@smkbinamandiri.sch.id\n🌐 Website: www.smkbinamandiri.sch.id\n\n📍 Google Maps: [Klik di sini untuk petunjuk arah]\n\nKami buka Senin-Jumat: 07.00-16.00 WIB 🕐', 1, 85, '2025-10-15 05:53:01', '2025-10-15 05:53:01'),
(8, 'thanks', 'Terima Kasih', '[\"terima kasih\",\"thanks\",\"makasih\",\"thank you\"]', 'Sama-sama! 😊 Senang bisa membantu Anda. Jika ada pertanyaan lain tentang SMK Bina Mandiri Bekasi, jangan ragu untuk bertanya ya! 🏫✨', 1, 70, '2025-10-15 05:53:01', '2025-10-15 05:53:01'),
(9, 'goodbye', 'Selamat Tinggal', '[\"bye\",\"dadah\",\"sampai jumpa\",\"selamat tinggal\"]', 'Sampai jumpa! 👋 Semoga informasi yang saya berikan bermanfaat. Jangan lupa kunjungi website kami untuk info lebih lengkap. Selamat beraktivitas! 😊🏫', 1, 70, '2025-10-15 05:53:01', '2025-10-15 05:53:01');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(191) DEFAULT NULL,
  `user_message` text NOT NULL,
  `bot_reply` text NOT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `user_agent` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `session_id`, `user_message`, `bot_reply`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 'session_1763436180945_rdt4126vj', 'A', 'Maaf, saya belum punya informasi tentang itu. 😅\n\nSaya bisa membantu Anda dengan informasi tentang:\n📚 Profil sekolah\n🎓 Jurusan (TKJ, Akuntansi, DKV)\n📝 PPDB (Pendaftaran)\n🏢 Fasilitas\n📍 Alamat & Kontak\n⏰ Jadwal Pelajaran\n🎯 Ekstrakurikuler\n\nSilakan tanya hal-hal di atas ya! 😊', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-17 20:24:11', '2025-11-17 20:24:11');

-- --------------------------------------------------------

--
-- Table structure for table `competencies`
--

CREATE TABLE `competencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` longtext NOT NULL,
  `head_of_program_name` varchar(191) DEFAULT NULL,
  `head_of_program_photo` varchar(191) DEFAULT NULL,
  `head_of_program_message` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `competencies`
--

INSERT INTO `competencies` (`id`, `name`, `slug`, `description`, `head_of_program_name`, `head_of_program_photo`, `head_of_program_message`, `image`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(10, 'Teknik Kendaraan Ringan', 'teknik-kendaraan-ringan', 'tester 2', NULL, NULL, NULL, 'competencies/xQCPjExGlZbKfweYeesTuOl3iZDZ0oKjaVFHiq3t.png', 2, 'active', '2025-11-07 00:11:15', '2025-11-07 00:11:15'),
(11, 'Teknik Sepeda Motor', 'teknik-sepeda-motor', 'tester 3', NULL, NULL, NULL, 'competencies/cLTR5YSskuOJuZT7usBTNe8RFOLKv1LQjwturm6a.jpg', 3, 'active', '2025-11-07 00:11:47', '2025-11-07 00:11:47'),
(12, 'Teknik Komputer & Jaringan', 'teknik-komputer-jaringan', '<p><strong>Visi</strong></p><p>Terwujudnya program diklat kejuruan yang berstandar nasional dan internasional serta unggul dalam keterampilan yang dilandasi iman dan taqwa.</p><p><strong>Misi</strong></p><ul><li>Mengembangkan sistem pendidikan menengah kejuruan yang reliabel dan fleksibel.</li><li>Mengembangkan sistem pendidikan menengah kejuruan yang terintegrasi antara jalur pendidikan sekolah yang sesuai tuntutan kebutuhan DUDI (Dunia Usaha Dan Dunia Industri).</li><li>Mengembangkan Sistem pembelajar berwawasan global yang berakar pada norma dan nilai budaya bangsa Indonesia.</li></ul><p><strong>Tujuan Konsentrasi Keahlian</strong></p><ol><li>Menghasilkan lulusan yang menguasai ilmu teknologi yang berkualitas, berbudi pekerti luhur dan religius.</li><li>Melatih dan mendidik siswa agar memiliki wawasan ilmu pengetahuan dan teknologi.</li><li>Mendidik siswa agar mampu memilih karir, berkompetisi dan mengembangkan sikap professional dalam program keahlian Teknik Komputer Jaringan.</li><li>Membentuk siswa yang cerdas, jujur, disiplin, kreatif, inovatif dan responsif.</li><li>Membekali siswa dengan ilmu pengetahuan dan keterampilan sebagai bekal bagi yang berminat melanjutkan ke jenjang pendidikan yang lebih tinggi.</li><li>Mendidik siswa dengan keahlian dan keterampilan dalam Kompetensi keahlian Teknik Komputer Jaringan agar dapat bekerja secara baik dan mandiri dalam Dunia Usaha/Dunia Industri (DUDI).</li></ol><p>Materi Pembelajaran</p><p><strong>Materi Kelas X</strong></p><ul><li>Proses bisnis di bidang Teknik Jaringan Komputer Dan Telekomunikasi</li><li>Perkembangan teknologi di bidang Teknik Jaringan Komputer Dan Telekomunikasi</li><li>Profesi dan Kewirausahaan (jobprofile dan technopreneur) di bidang Teknik Jaringan Komputer Dan Telekomunikasi</li><li>Keselamatan dan Kesehatan Kerja Lingkungan Hidup (K3LH) dan budaya kerja industri</li><li>Dasar-dasar Teknik Jaringan Komputer&nbsp;Dan Telekomunikasi</li><li>Media Dan Jaringan Telekomunikasi</li><li>Penggunaan Alat Ukur</li></ul><p><strong>Materi Kelas XI &amp; XII</strong></p><ul><li><strong>Perencanaan dan Pengalamatan Jaringan</strong></li></ul><p>Meliputi perencanaan topologi dan arsitektur jaringan, pengumpulan kebutuhan teknis pengguna yang menggunakan jaringan, pengumpulan data peralatan jaringan dengan teknologi yang sesuai, pengalamatan jaringan CIDR, VLSM, dan subnetting.</p><ul><li><strong>Teknologi Jaringan Kabel dan Nirkabel</strong></li></ul><p>Meliputi instalasi jaringan kabel dan nirkabel, pengujian, perawatan dan perbaikan jaringan kabel dan nirkabel, standar jaringan nirkabel, jenis-jenis teknologi jaringan nirkabel indoor dan outdoor, teknologi layanan Voice over IP (VoIP), jaringan fiber optic, jenis-jenis kabel fiber optic, fungsi alat kerja fiber optic, sambungan fiber optic, dan perbaikan jaringan fiber optic.</p><ul><li><strong>Keamanan Jaringan</strong></li></ul><p>Meliputi kebijakan penggunaan jaringan, ancaman dan serangan terhadap keamanan jaringan, penentuan sistem keamanan jaringan yang dibutuhkan, firewall pada host dan server, kebutuhan persyaratan alat-alat untuk membangun server firewall, konsep dan implementasi firewall di host dan server, fungsi dan cara kerja server autentifikasi, kebutuhan persyaratan alat-alat untuk membangun server autentifikasi, cara kerja sistem pendeteksi dan penahan ancaman/serangan yang masuk ke jaringan, analisis fungsi dan tata cara pengamanan server-server layanan pada jaringan, dan tata cara pengamanan komunikasi data menggunakan teknik kriptografi.</p><ul><li><strong>Pemasangan dan Konfigurasi Perangkat Jaringan</strong></li></ul><p>Meliputi pemasangan perangkat jaringan ke dalam sistem jaringan, penggantian perangkat jaringan sesuai dengan kebutuhan, konsep VLAN, konfigurasi dan pengujian VLAN, proses routing, jenis-jenis routing, konfigurasi, analisis permasalahan dan perbaikan konfigurasi routing statis dan routing dinamis, konfigurasi NAT, analisis permasalahan internet gateway dan perbaikan konfigurasi NAT, konfigurasi, analisis permasalahan dan perbaikan konfigurasi proxy server, manajemen bandwidth dan load balancing.</p><ul><li><strong>Administrasi Sistem Jaringan</strong></li></ul><p class=\"ql-align-justify\">Meliputi instalasi sistem operasi jaringan, konsep, instalasi services, konfigurasi, dan pengujian konfigurasi remote server, DHCP server, DNS server, FTP server, file server, web server, mail server, database server, Control Panel Hosting, Share Hosting Server, Dedicated Hosting Server, Virtual Private Server, VPN server, sistem kontrol, dan monitoring.</p><p><strong>Ruang Lingkup Kerja</strong></p><p>Lulusan SMK Bina Mandiri Kota Bekasi memiliki peluang lapangan kerja yang cukup luas, baik di lembaga-lembaga ‎pemerintah maupun swasta. Secara spesifik peluang kerja itu antara lain:</p><ol><li>Teknisi Komputer, Teknisi Jaringan, Web Developer, CCTV, Telekomunikasi</li><li>Lembaga Komputer ‎Umum, Setting dan Desainer mandiri,</li><li>Programmer, ‎dan lain-lain.‎</li><li>Lulusan SMK Bina Mandiri Kota Bekasi&nbsp;juga memiliki kesempatan yang sama untuk melanjutkan studi ke jenjang ‎pendidikan yang lebih tinggi, baik Diploma maupun Strata Satu pada jurusan yang relevan.‎ ‎</li></ol><p><br></p>', 'Zainudin, S.Pd', 'competencies/heads/x64RsMMqOS2UJsdGkbiIweBOlezb7p0ZocqbNtMD.jpg', NULL, 'competencies/SkdIXXIQqycusK8Z9VOV4rddI9QU7WqqbWJ1WSG8.jpg', 4, 'active', '2025-11-14 01:54:36', '2025-11-14 01:54:36');

-- --------------------------------------------------------

--
-- Table structure for table `competency_images`
--

CREATE TABLE `competency_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `competency_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(191) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `competency_images`
--

INSERT INTO `competency_images` (`id`, `competency_id`, `image_path`, `title`, `description`, `order`, `status`, `created_at`, `updated_at`) VALUES
(6, 12, 'competencies/teknik-komputer-jaringan/1763450993_0_7622635001.jpg', NULL, NULL, 1, 'active', '2025-11-18 00:29:53', '2025-11-18 00:29:53'),
(7, 12, 'competencies/teknik-komputer-jaringan/1763450993_1_Blue-Tosca-Gradient-Futuristic-Technology-Background-Instagram-Story (1).png', NULL, NULL, 2, 'active', '2025-11-18 00:29:53', '2025-11-18 00:29:53'),
(8, 12, 'competencies/teknik-komputer-jaringan/1763450993_2_WhatsApp Image 2025-10-27 at 08.39.35_20c5c701.jpg', NULL, NULL, 3, 'active', '2025-11-18 00:29:53', '2025-11-18 00:29:53');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_albums`
--

CREATE TABLE `gallery_albums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(191) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_items`
--

CREATE TABLE `gallery_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `album_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `image_path` varchar(191) NOT NULL,
  `type` enum('image','video') NOT NULL DEFAULT 'image',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_sliders`
--

CREATE TABLE `home_sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(191) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `button_text` varchar(191) DEFAULT NULL,
  `button_link` varchar(191) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_sliders`
--

INSERT INTO `home_sliders` (`id`, `image_path`, `title`, `subtitle`, `button_text`, `button_link`, `order`, `status`, `created_at`, `updated_at`) VALUES
(2, 'sliders/xCsRKnlfOjjH93UeiFGvjeTbELLbPP9mBszsabsA.jpg', NULL, NULL, NULL, NULL, 0, 'active', '2025-11-14 01:20:09', '2025-11-14 01:20:09'),
(3, 'sliders/8GVj2lzS8tq6sx4mYsA0uKLIVKX9kiIbNnlQPIEk.png', NULL, NULL, NULL, NULL, 1, 'active', '2025-11-14 01:20:09', '2025-11-14 01:20:09'),
(4, 'sliders/28XXtPyJMDYDM0o8zciJPtXMxGRPBd1r6lPngJVn.png', NULL, NULL, NULL, NULL, 2, 'active', '2025-11-14 01:20:09', '2025-11-14 01:20:09'),
(5, 'sliders/MWeZoDpsJ4sa7JIhPEwMsPcTps2DxW3kRTwHHUSz.jpg', NULL, NULL, NULL, NULL, 3, 'active', '2025-11-14 01:20:09', '2025-11-14 01:20:09');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `url` varchar(191) DEFAULT NULL,
  `route_name` varchar(191) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `icon` varchar(191) DEFAULT NULL,
  `target` enum('_self','_blank') NOT NULL DEFAULT '_self',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `url`, `route_name`, `parent_id`, `order`, `icon`, `target`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Beranda', NULL, 'home', NULL, 1, NULL, '_self', 'active', '2025-11-06 23:36:22', '2025-11-06 23:36:22'),
(2, 'Tentang', NULL, 'info.about', NULL, 2, NULL, '_self', 'active', '2025-11-06 23:36:22', '2025-11-06 23:36:22'),
(3, 'Selayang Pandang', NULL, 'info.overview', 2, 1, NULL, '_self', 'active', '2025-11-06 23:36:22', '2025-11-06 23:36:22'),
(4, 'Sambutan Kepala Sekolah', NULL, 'info.principal-message', 2, 2, NULL, '_self', 'active', '2025-11-06 23:36:22', '2025-11-06 23:36:22'),
(5, 'Program Keahlian', NULL, 'competencies.index', NULL, 3, NULL, '_self', 'active', '2025-11-06 23:36:22', '2025-11-06 23:36:22'),
(6, 'Berita & Acara', NULL, 'news.index', NULL, 4, NULL, '_self', 'active', '2025-11-06 23:36:22', '2025-11-06 23:36:22'),
(7, 'Galeri', NULL, 'gallery.index', NULL, 5, NULL, '_self', 'active', '2025-11-06 23:36:22', '2025-11-06 23:36:22'),
(8, 'PPDB', NULL, 'ppdb.register', NULL, 6, NULL, '_self', 'active', '2025-11-06 23:36:22', '2025-11-06 23:36:22'),
(9, 'Kontak', NULL, 'info.contact', NULL, 7, NULL, '_self', 'active', '2025-11-06 23:36:22', '2025-11-06 23:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_01_01_000000_create_users_table', 1),
(3, '2024_01_01_000001_create_pages_table', 1),
(4, '2024_01_01_000002_create_news_categories_table', 1),
(5, '2024_01_01_000003_create_news_table', 1),
(6, '2024_01_01_000004_create_competencies_table', 1),
(7, '2024_01_01_000005_create_gallery_albums_table', 1),
(8, '2024_01_01_000006_create_gallery_items_table', 1),
(9, '2024_01_01_000007_create_ppdb_registrations_table', 1),
(10, '2024_01_01_000008_create_ppdb_settings_table', 1),
(11, '2024_01_15_000000_create_audit_logs_table', 1),
(13, '2024_01_15_000000_create_visitor_logs_table', 2),
(14, '2025_10_15_100000_create_chats_table', 3),
(15, '2025_10_15_110000_create_chatbot_responses_table', 4),
(16, '2025_10_15_120000_create_settings_table', 5),
(17, '2025_01_08_100000_create_menus_table', 6),
(18, '2025_01_08_110000_create_competency_images_table', 7),
(19, '2025_01_08_120000_create_home_sliders_table', 8),
(20, '2025_11_14_083213_add_head_of_program_to_competencies_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text DEFAULT NULL,
  `featured_image` varchar(191) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_categories`
--

CREATE TABLE `news_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_categories`
--

INSERT INTO `news_categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(6, 'Kegiatan Sekolah', 'kegiatan-sekolah', 'Informasi SeputarKegiatan Sekolah', '2025-10-19 19:25:35', '2025-10-19 19:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `content` longtext DEFAULT NULL,
  `banner_image` varchar(191) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ppdb_registrations`
--

CREATE TABLE `ppdb_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `registration_number` varchar(50) NOT NULL,
  `student_name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `birth_date` date NOT NULL,
  `address` text NOT NULL,
  `parent_name` varchar(191) NOT NULL,
  `parent_phone` varchar(20) NOT NULL,
  `documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documents`)),
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `verified_at` timestamp NULL DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ppdb_registrations`
--

INSERT INTO `ppdb_registrations` (`id`, `registration_number`, `student_name`, `email`, `phone`, `birth_date`, `address`, `parent_name`, `parent_phone`, `documents`, `status`, `verified_at`, `verified_by`, `notes`, `created_at`, `updated_at`) VALUES
(18, 'PPDB20250001', 'testerppdb', 'testerppdb@gmail.com', '09898989898', '1996-01-01', 'bekasi', 'testerwali', '03890128320193', '\"[{\\\"name\\\":\\\"images.jpg\\\",\\\"path\\\":\\\"ppdb-documents\\\\\\/1PFCokF4dJUDrcIVnhlqBJb690Q3t8SZKhD4u8b3.jpg\\\"},{\\\"name\\\":\\\"images.jpg\\\",\\\"path\\\":\\\"ppdb-documents\\\\\\/SAJ4IoV09JPlSdnkYPT4XkquFhx9n7kxIHzkcQv5.jpg\\\"}]\"', 'pending', NULL, NULL, NULL, '2025-10-14 20:51:20', '2025-10-14 20:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `ppdb_settings`
--

CREATE TABLE `ppdb_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `registration_start` date NOT NULL,
  `registration_end` date NOT NULL,
  `requirements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requirements`)),
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ppdb_settings`
--

INSERT INTO `ppdb_settings` (`id`, `registration_start`, `registration_end`, `requirements`, `status`, `created_at`, `updated_at`) VALUES
(1, '2025-10-10', '2026-10-10', '\"[\\\"Birth Certificate (Akta Kelahiran)\\\",\\\"Family Card (Kartu Keluarga)\\\",\\\"Student Photo 3x4 (2 sheets)\\\",\\\"Health Certificate\\\",\\\"Certificate of Good Conduct\\\",\\\"Raport Dari Sekolah Sebelumnya\\\"]\"', 'active', '2025-10-13 21:02:08', '2025-10-14 20:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'text',
  `group` varchar(191) NOT NULL DEFAULT 'general',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `description`, `created_at`, `updated_at`) VALUES
(1, 'site_logo', 'logos/site_logo_1761563891.png', 'image', 'appearance', 'Logo sekolah yang ditampilkan di header', '2025-10-21 18:19:01', '2025-10-27 04:18:11'),
(2, 'site_logo_dark', NULL, 'image', 'appearance', 'Logo sekolah untuk dark mode', '2025-10-21 18:19:01', '2025-10-21 18:19:01'),
(3, 'site_favicon', NULL, 'image', 'appearance', 'Favicon website', '2025-10-21 18:19:01', '2025-10-21 18:19:01'),
(4, 'site_name', 'SMK Bina Mandiri Kota Bekasi', 'text', 'general', 'Nama sekolah', '2025-10-21 18:19:01', '2025-10-21 18:24:58'),
(5, 'site_tagline', 'Ikhlas Berkarya Pelayanan Prima', 'text', 'general', 'Tagline sekolah', '2025-10-21 18:19:01', '2025-11-22 00:29:57'),
(7, 'school_overview', 'SMK Bina Mandiri Bekasi didirikan pada tahun 2005 dengan visi menjadi lembaga pendidikan kejuruan terkemuka yang menghasilkan lulusan berkualitas, kompeten, dan siap kerja.\n\nSekolah kami memiliki berbagai program keahlian yang disesuaikan dengan kebutuhan industri modern, didukung oleh tenaga pengajar profesional dan fasilitas pembelajaran yang lengkap.\n\nDengan motto \"Cerdas, Terampil, dan Berakhlak Mulia\", kami berkomitmen untuk membentuk generasi muda yang tidak hanya unggul dalam kompetensi teknis, tetapi juga memiliki karakter yang kuat dan nilai-nilai moral yang tinggi.\n\nFasilitas kami meliputi laboratorium komputer, workshop praktik, perpustakaan digital, dan ruang kelas ber-AC yang nyaman. Kami juga menjalin kerjasama dengan berbagai industri untuk program magang dan penempatan kerja lulusan.', 'text', 'general', NULL, '2025-11-06 23:47:14', '2025-11-06 23:47:14'),
(8, 'principal_name', 'Endah Sulistiani, S.Pd M.Si', 'text', 'general', NULL, '2025-11-06 23:47:14', '2025-11-06 23:58:51'),
(9, 'principal_message', 'Assalamu\'alaikum Warahmatullahi Wabarakatuh,\r\n\r\nPuji syukur kita panjatkan kehadirat Allah SWT yang telah memberikan rahmat dan karunia-Nya kepada kita semua. Shalawat serta salam semoga senantiasa tercurah kepada Nabi Muhammad SAW, keluarga, sahabat, dan para pengikutnya hingga akhir zaman.\r\n\r\nSelamat datang di SMK Bina Mandiri Bekasi. Sebagai Kepala Sekolah, saya merasa bangga dan bersyukur dapat memimpin lembaga pendidikan yang terus berkembang dan berinovasi dalam mencetak generasi muda yang berkualitas.\r\n\r\nPendidikan kejuruan memiliki peran strategis dalam mempersiapkan tenaga kerja terampil yang siap menghadapi tantangan dunia industri. Oleh karena itu, kami berkomitmen untuk memberikan pendidikan terbaik yang tidak hanya fokus pada pengembangan kompetensi teknis, tetapi juga pembentukan karakter dan akhlak mulia.\r\n\r\nKepada para siswa, saya mengajak kalian untuk memanfaatkan setiap kesempatan belajar dengan sebaik-baiknya. Jadilah pribadi yang disiplin, bertanggung jawab, dan selalu bersemangat dalam menuntut ilmu. Kepada para orang tua, terima kasih atas kepercayaan yang telah diberikan. Mari kita bersinergi dalam mendidik putra-putri kita menjadi generasi yang unggul.\r\n\r\nSemoga SMK Bina Mandiri Bekasi terus menjadi pilihan terbaik dalam pendidikan kejuruan dan menghasilkan lulusan yang bermanfaat bagi bangsa dan negara.\r\n\r\nWassalamu\'alaikum Warahmatullahi Wabarakatuh.', 'text', 'general', NULL, '2025-11-06 23:47:14', '2025-11-06 23:58:51'),
(10, 'principal_photo', 'principal/principal_1762498731.jpg', 'image', 'general', NULL, '2025-11-06 23:58:51', '2025-11-06 23:58:51'),
(11, 'contact_address', 'Jl. Bintara IX No.7 4, RT.001/RW.005, Bintara, Kec. Bekasi Bar., Kota Bks, Jawa Barat 17134', 'text', 'general', NULL, '2025-11-10 18:23:19', '2025-11-11 20:36:53'),
(12, 'contact_phone', '(021) 8860686', 'text', 'general', NULL, '2025-11-10 18:23:19', '2025-11-11 20:36:53'),
(13, 'contact_email', 'smkbinamandiribks@gmail.com', 'text', 'general', NULL, '2025-11-10 18:23:19', '2025-11-11 20:36:53'),
(14, 'contact_whatsapp', '6281292760717', 'text', 'general', NULL, '2025-11-10 18:23:19', '2025-11-11 20:36:53'),
(15, 'social_facebook', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-10 18:23:19', '2025-11-10 19:21:24'),
(16, 'social_instagram', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-10 18:23:19', '2025-11-10 19:21:24'),
(17, 'social_twitter', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-10 18:23:19', '2025-11-10 19:21:24'),
(18, 'social_youtube', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-10 18:23:19', '2025-11-10 19:21:24'),
(19, 'social_tiktok', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-10 18:23:19', '2025-11-10 19:21:24'),
(20, 'social_linkedin', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-10 18:23:19', '2025-11-10 19:21:24'),
(21, 'stat1_value', '1000+', 'text', 'general', NULL, '2025-11-17 20:27:10', '2025-11-17 20:27:10'),
(22, 'stat1_label', 'Alumni Sukses', 'text', 'general', NULL, '2025-11-17 20:27:10', '2025-11-17 20:27:10'),
(23, 'stat2_value', '3', 'text', 'general', NULL, '2025-11-17 20:27:10', '2025-11-17 20:53:26'),
(24, 'stat2_label', 'Program Keahlian', 'text', 'general', NULL, '2025-11-17 20:27:10', '2025-11-17 20:27:10'),
(25, 'stat3_value', '100+', 'text', 'general', NULL, '2025-11-17 20:27:10', '2025-11-17 20:53:26'),
(26, 'stat3_label', 'Guru Berpengalaman', 'text', 'general', NULL, '2025-11-17 20:27:10', '2025-11-17 20:27:10'),
(27, 'stat4_value', '100%', 'text', 'general', NULL, '2025-11-17 20:27:10', '2025-11-17 20:53:26'),
(28, 'stat4_label', 'Tingkat Kelulusan', 'text', 'general', NULL, '2025-11-17 20:27:10', '2025-11-17 20:27:10'),
(29, 'ppdb_brochure', 'brochures/kNSv7mhU7YCf1FkkSPBliT3bLowxnitip4vZc1lq.png', 'text', 'general', NULL, '2025-12-14 22:31:31', '2025-12-14 22:31:31'),
(30, 'ppdb_brochure_title', 'Brosur SPMB2026', 'text', 'general', NULL, '2025-12-14 22:31:31', '2025-12-14 22:31:31'),
(31, 'ppdb_brochure_description', 'Download brosur PPDB untuk informasi lengkap tentang pendaftaran siswa baru', 'text', 'general', NULL, '2025-12-14 22:31:31', '2025-12-14 22:31:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL DEFAULT 'student',
  `profile_image` varchar(191) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `profile_image`, `phone`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@school.com', '2025-10-13 21:02:08', '$2y$12$RWZ..Y4JIPZU.ClmOg9HKeXYS4ALF0nP8eo1EhhETsr4m7CNl/GlW', 'admin', NULL, '081234567890', NULL, '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(2, 'Mrs. Loren Hills', 'francisca71@example.com', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'teacher', NULL, '+1-425-869-5107', '8gF2c8x0jS', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(3, 'Keon Walsh DVM', 'leslie.donnelly@example.net', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'teacher', NULL, '+1-769-807-3558', 'YhW8kouOmZ', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(4, 'Diego Harber', 'jocelyn.bins@example.com', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'teacher', NULL, '+1.954.338.2014', 'P9lUlZ7fGh', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(5, 'Prof. Santa Witting Jr.', 'madaline41@example.com', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'teacher', NULL, '667.346.8325', 'k7qSrydlWT', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(6, 'Keely Kuphal', 'glenda90@example.net', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'teacher', NULL, '1-641-778-3234', 'KQ5AqeBx9O', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(7, 'Hilma Hoeger', 'araceli.dicki@example.org', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '+1.865.348.3035', 'tqo2CjoSY4', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(8, 'Berry Walker', 'mbergnaum@example.net', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '917-600-9121', 'RasPiaMArW', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(9, 'Jabari Koepp PhD', 'kristofer.wintheiser@example.org', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '+1-435-839-7135', 'CGrpN0xtsC', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(10, 'Mr. Randy Rohan', 'kathryne49@example.net', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '+1 (718) 628-9186', 'y9OgA3CD2h', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(11, 'Magdalena Pagac', 'murphy.keeley@example.com', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '(848) 790-5996', 'XixTXTZtou', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(12, 'Nora Gusikowski', 'avis.macejkovic@example.net', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '+1-954-864-4466', 'H6hwEQBbyI', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(13, 'Miss Laurianne Halvorson', 'vada31@example.org', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '478-566-4538', 'YL0EZnRJ7O', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(14, 'Jaqueline Trantow', 'cfay@example.com', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '(239) 817-3702', 'jJQh2xpUQS', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(15, 'Eloy Lowe', 'jbogan@example.net', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '+1-667-449-6572', 'txBCIufu1w', '2025-10-13 21:02:08', '2025-10-13 21:02:08'),
(16, 'Brown Satterfield', 'fredy46@example.net', '2025-10-13 21:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '878.493.3472', '196VN2gY1F', '2025-10-13 21:02:08', '2025-10-13 21:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_logs`
--

CREATE TABLE `visitor_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(191) DEFAULT NULL,
  `url` varchar(500) NOT NULL,
  `referer` varchar(500) DEFAULT NULL,
  `method` varchar(10) NOT NULL DEFAULT 'GET',
  `visited_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitor_logs`
--

INSERT INTO `visitor_logs` (`id`, `ip_address`, `user_agent`, `url`, `referer`, `method`, `visited_at`) VALUES
(1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/ppdb/check-status', 'GET', '2025-10-14 21:40:12'),
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 00:08:36'),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-15 00:09:22'),
(4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-15 00:57:39'),
(5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 00:57:44'),
(6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 00:58:47'),
(7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 05:45:32'),
(8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-15 05:54:04'),
(9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 05:55:27'),
(10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 05:55:49'),
(11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 05:58:23'),
(12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 05:58:52'),
(13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 20:09:48'),
(14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-10-15 20:10:38'),
(15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-15 20:11:12'),
(16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/contact', 'GET', '2025-10-15 20:11:46'),
(17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-10-15 20:12:17'),
(18, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/ppdb/register', 'GET', '2025-10-15 20:12:49'),
(19, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/', 'GET', '2025-10-15 20:13:38'),
(20, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-15 20:13:42'),
(21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-17 23:00:23'),
(22, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-17 23:12:32'),
(23, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-17 23:12:40'),
(24, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000/about', NULL, 'GET', '2025-10-17 23:13:38'),
(25, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-17 23:13:42'),
(26, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-10-17 23:23:07'),
(27, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-19 18:51:38'),
(28, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-19 18:53:28'),
(29, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-19 18:53:45'),
(30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 18:53:57'),
(31, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 19:05:53'),
(32, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 19:06:32'),
(33, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'GET', '2025-10-19 19:06:51'),
(34, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 19:07:01'),
(35, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'GET', '2025-10-19 19:07:35'),
(36, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-19 19:07:44'),
(37, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/admin/pages', 'GET', '2025-10-19 19:28:56'),
(38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-19 19:29:01'),
(39, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 19:29:14'),
(40, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 19:29:16'),
(41, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 19:29:17'),
(42, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-19 19:29:19'),
(43, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 19:29:20'),
(44, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/news', 'GET', '2025-10-19 19:29:21'),
(45, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/gallery', 'http://127.0.0.1:8000/news', 'GET', '2025-10-19 19:29:22'),
(46, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/gallery', 'GET', '2025-10-19 19:29:23'),
(47, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/contact', 'GET', '2025-10-19 19:29:25'),
(48, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 19:29:26'),
(49, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 19:29:34'),
(50, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 19:29:53'),
(51, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 19:29:55'),
(52, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 19:29:56'),
(53, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/news', 'GET', '2025-10-19 19:29:58'),
(54, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/news', 'GET', '2025-10-19 19:34:45'),
(55, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/news', 'GET', '2025-10-19 19:34:49'),
(56, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 19:34:54'),
(57, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 19:34:56'),
(58, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-19 19:34:58'),
(59, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-19 20:17:37'),
(60, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-19 20:18:14'),
(61, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-19 20:18:37'),
(62, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/news', 'GET', '2025-10-19 20:19:02'),
(63, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 20:19:05'),
(64, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 20:19:07'),
(65, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 20:19:09'),
(66, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 20:19:10'),
(67, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 20:19:12'),
(68, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/contact', 'GET', '2025-10-19 20:19:34'),
(69, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 20:20:07'),
(70, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 20:20:23'),
(71, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-19 20:20:27'),
(72, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 20:20:32'),
(73, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 20:20:37'),
(74, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 20:23:07'),
(75, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 20:23:09'),
(76, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 20:23:43'),
(77, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-19 20:23:48'),
(78, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 20:23:52'),
(79, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-19 20:23:58'),
(80, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 20:24:05'),
(81, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-19 20:24:36'),
(82, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 20:24:42'),
(83, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-19 20:24:50'),
(84, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-19 20:27:25'),
(85, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-19 20:29:09'),
(86, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 20:29:12'),
(87, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-19 20:29:17'),
(88, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-21 17:57:34'),
(89, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-21 17:58:06'),
(90, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/about', 'GET', '2025-10-21 17:58:15'),
(91, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-21 17:58:22'),
(92, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/news', 'GET', '2025-10-21 17:58:35'),
(93, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/contact', 'GET', '2025-10-21 17:58:47'),
(94, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-21 18:03:14'),
(95, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/admin/ppdb-settings', 'GET', '2025-10-21 18:12:32'),
(96, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-21 18:22:35'),
(97, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-21 18:25:01'),
(98, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-21 18:42:54'),
(99, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-10-21 18:44:11'),
(100, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 18:46:11'),
(101, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 18:46:17'),
(102, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 19:13:46'),
(103, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 19:15:51'),
(104, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 21:05:45'),
(105, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 21:05:51'),
(106, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 21:05:51'),
(107, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 21:06:53'),
(108, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 21:06:53'),
(109, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 21:06:53'),
(110, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 21:06:54'),
(111, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 21:06:54'),
(112, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 21:06:55'),
(113, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-21 21:06:55'),
(114, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/', 'GET', '2025-10-21 21:09:59'),
(115, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/contact', 'GET', '2025-10-21 21:10:26'),
(116, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-10-21 21:10:31'),
(117, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-21 21:10:32'),
(118, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-21 21:11:20'),
(119, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-21 21:11:26'),
(120, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-21 21:11:44'),
(121, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-21 21:17:50'),
(122, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-21 21:18:24'),
(123, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-21 21:18:25'),
(124, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-21 21:19:14'),
(125, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-21 21:19:43'),
(126, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-21 21:20:21'),
(127, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-23 20:03:44'),
(128, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-23 20:03:52'),
(129, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-26 20:03:37'),
(130, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-26 20:05:15'),
(131, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-26 20:17:03'),
(132, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-26 20:17:06'),
(133, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-26 20:20:09'),
(134, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/gallery', 'http://127.0.0.1:8000/', 'GET', '2025-10-26 20:20:13'),
(135, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-26 20:20:18'),
(136, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-26 21:57:37'),
(137, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-27 03:09:55'),
(138, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/about', 'GET', '2025-10-27 03:10:00'),
(139, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-27 03:10:40'),
(140, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-27 04:10:35'),
(141, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-27 04:13:08'),
(142, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-27 04:17:58'),
(143, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-10-27 04:18:00'),
(144, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-10-27 04:18:17'),
(145, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-10-27 04:20:13'),
(146, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', NULL, 'GET', '2025-10-27 04:22:27'),
(147, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/pages/tester', 'http://127.0.0.1:8000/admin/pages', 'GET', '2025-10-27 04:24:35'),
(148, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', NULL, 'GET', '2025-10-27 04:24:58'),
(149, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', NULL, 'GET', '2025-10-27 04:25:00'),
(150, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', NULL, 'GET', '2025-10-27 04:30:45'),
(151, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/pages/nulla-laborum-eaque-veniam', 'http://127.0.0.1:8000/admin/pages', 'GET', '2025-10-27 04:38:25'),
(152, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/pages/eligendi-quidem-voluptas-a', 'http://127.0.0.1:8000/admin/pages', 'GET', '2025-10-27 04:38:34'),
(153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/pages/eligendi-quidem-voluptas-a', 'GET', '2025-10-27 04:38:49'),
(154, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-31 20:08:27'),
(155, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'http://127.0.0.1:8000/', 'GET', '2025-10-31 20:10:39'),
(156, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', NULL, 'GET', '2025-10-31 20:18:08'),
(157, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'GET', '2025-10-31 20:18:21'),
(158, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-31 20:18:29'),
(159, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-31 20:20:56'),
(160, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-31 20:31:32'),
(161, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'GET', '2025-10-31 20:31:39'),
(162, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/ppdb/register', 'GET', '2025-10-31 20:31:45'),
(163, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-31 20:32:35'),
(164, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-06 22:01:24'),
(165, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-11-06 22:03:46'),
(166, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-11-06 22:15:39'),
(167, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/about', 'GET', '2025-11-06 22:15:47'),
(168, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', 'http://127.0.0.1:8000/about', 'GET', '2025-11-06 22:15:53'),
(169, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/about', 'GET', '2025-11-06 22:16:26'),
(170, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/about', 'GET', '2025-11-06 22:17:07'),
(171, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-11-06 22:18:34'),
(172, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', 'http://127.0.0.1:8000/', 'GET', '2025-11-06 22:18:37'),
(173, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', NULL, 'GET', '2025-11-06 22:25:26'),
(174, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-06 23:41:10'),
(175, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-06 23:48:06'),
(176, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-06 23:58:58'),
(177, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-06 23:59:22'),
(178, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-06 23:59:33'),
(179, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-11-07 00:00:06'),
(180, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-11-07 00:01:56'),
(181, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-11-07 00:07:41'),
(182, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/', 'GET', '2025-11-07 00:07:47'),
(183, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-07 00:07:54'),
(184, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-07 00:08:00'),
(185, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-07 00:10:31'),
(186, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-07 00:11:53'),
(187, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-07 00:11:59'),
(188, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-kendaraan-ringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-07 00:12:47'),
(189, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-10 18:10:20'),
(190, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-10 18:10:37'),
(191, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-10 18:10:43'),
(192, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-10 18:10:49'),
(193, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/competencies/teknik-komputer-jaringan/images', 'GET', '2025-11-10 18:12:08'),
(194, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-10 18:12:11'),
(195, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-10 18:12:15'),
(196, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-10 18:12:31'),
(197, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-10 18:15:19'),
(198, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-10 18:15:21'),
(199, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-10 18:15:22'),
(200, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-10 18:24:40'),
(201, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-10 19:21:32'),
(202, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/contact-social', 'GET', '2025-11-10 19:21:43'),
(203, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-11 20:31:46'),
(204, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/', 'GET', '2025-11-11 20:32:07'),
(205, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-11 20:32:26'),
(206, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/contact-social', 'GET', '2025-11-11 20:34:55'),
(207, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/contact-social', 'GET', '2025-11-11 20:36:59'),
(208, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/contact-social', 'GET', '2025-11-11 21:11:52'),
(209, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/contact-social', 'GET', '2025-11-11 21:11:54'),
(210, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-11-11 21:11:58'),
(211, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-13 23:48:12'),
(212, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-13 23:48:36'),
(213, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-11-13 23:49:11'),
(214, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/login', 'GET', '2025-11-13 23:49:24'),
(215, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders/create', 'GET', '2025-11-14 00:19:44'),
(216, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 00:20:10'),
(217, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', 'http://127.0.0.1:8000/about', 'GET', '2025-11-14 00:20:19'),
(218, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-14 00:20:24'),
(219, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-14 00:25:52'),
(220, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-14 00:25:59');
INSERT INTO `visitor_logs` (`id`, `ip_address`, `user_agent`, `url`, `referer`, `method`, `visited_at`) VALUES
(221, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-14 00:26:00'),
(222, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-14 00:26:10'),
(223, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-14 01:19:08'),
(224, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 01:19:15'),
(225, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 01:20:14'),
(226, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 01:24:06'),
(227, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 01:26:22'),
(228, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 01:26:24'),
(229, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 01:26:32'),
(230, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 01:28:50'),
(231, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 01:30:51'),
(232, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 01:31:00'),
(233, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-14 01:34:28'),
(234, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-14 01:36:14'),
(235, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 01:36:20'),
(236, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 01:41:02'),
(237, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 01:41:07'),
(238, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-14 01:41:14'),
(239, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-14 01:54:41'),
(240, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 01:54:50'),
(241, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-17 20:18:09'),
(242, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-17 20:20:58'),
(243, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-17 20:21:46'),
(244, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-17 20:22:58'),
(245, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-17 20:24:25'),
(246, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/', 'GET', '2025-11-17 20:24:54'),
(247, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/', 'GET', '2025-11-17 20:25:12'),
(248, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-17 20:25:27'),
(249, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-11-17 20:25:49'),
(250, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/about', 'GET', '2025-11-17 20:26:17'),
(251, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-17 20:26:51'),
(252, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/contact', 'GET', '2025-11-17 20:27:30'),
(253, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-17 20:28:18'),
(254, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-17 20:40:33'),
(255, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-17 20:40:46'),
(256, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-17 20:42:19'),
(257, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-17 20:42:22'),
(258, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-17 20:42:25'),
(259, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-17 20:42:27'),
(260, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-17 20:45:39'),
(261, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-17 20:51:50'),
(262, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-11-17 20:52:17'),
(263, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-11-17 20:53:32'),
(264, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-11-17 20:59:42'),
(265, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-11-17 21:02:55'),
(266, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-17 21:03:41'),
(267, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-18 00:26:31'),
(268, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 00:26:47'),
(269, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-11-18 00:28:19'),
(270, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 00:29:58'),
(271, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 00:37:32'),
(272, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-18 00:39:18'),
(273, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-kendaraan-ringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 00:39:25'),
(274, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies/teknik-kendaraan-ringan', 'GET', '2025-11-18 00:39:31'),
(275, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-18 00:39:38'),
(276, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-18 00:52:20'),
(277, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-22 00:03:26'),
(278, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-22 00:04:06'),
(279, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-11-22 00:04:23'),
(280, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-11-22 00:04:25'),
(281, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/ppdb/register', 'GET', '2025-11-22 00:04:34'),
(282, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-22 00:05:23'),
(283, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-22 00:05:27'),
(284, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-22 00:05:53'),
(285, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-22 00:06:00'),
(286, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-22 00:06:15'),
(287, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-11-22 00:06:59'),
(288, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-12-14 21:51:19'),
(289, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-12-14 21:52:36'),
(290, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/', 'GET', '2025-12-14 21:52:41'),
(291, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/gallery', 'http://127.0.0.1:8000/contact', 'GET', '2025-12-14 21:52:50'),
(292, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/gallery', 'GET', '2025-12-14 21:52:55'),
(293, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/news', 'GET', '2025-12-14 21:52:58'),
(294, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/competencies', 'GET', '2025-12-14 21:53:10'),
(295, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-12-14 21:54:30'),
(296, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-12-14 22:04:33'),
(297, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-12-14 22:04:39'),
(298, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-12-14 22:04:40'),
(299, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/ppdb/register', 'GET', '2025-12-14 22:15:04'),
(300, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-12-14 22:15:22'),
(301, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/ppdb/register', 'GET', '2025-12-14 22:18:21'),
(302, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', NULL, 'GET', '2025-12-14 22:24:25'),
(303, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-12-14 22:24:33'),
(304, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', NULL, 'GET', '2025-12-14 22:25:15'),
(305, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-12-14 22:31:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `audit_logs_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `audit_logs_action_index` (`action`),
  ADD KEY `audit_logs_created_at_index` (`created_at`);

--
-- Indexes for table `chatbot_responses`
--
ALTER TABLE `chatbot_responses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chatbot_responses_trigger_name_unique` (`trigger_name`),
  ADD KEY `chatbot_responses_is_active_index` (`is_active`),
  ADD KEY `chatbot_responses_priority_index` (`priority`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_session_id_index` (`session_id`),
  ADD KEY `chats_created_at_index` (`created_at`);

--
-- Indexes for table `competencies`
--
ALTER TABLE `competencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `competencies_slug_unique` (`slug`),
  ADD KEY `competencies_slug_index` (`slug`),
  ADD KEY `competencies_status_index` (`status`),
  ADD KEY `competencies_sort_order_index` (`sort_order`);

--
-- Indexes for table `competency_images`
--
ALTER TABLE `competency_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `competency_images_competency_id_order_index` (`competency_id`,`order`),
  ADD KEY `competency_images_status_index` (`status`);

--
-- Indexes for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gallery_albums_slug_unique` (`slug`),
  ADD KEY `gallery_albums_slug_index` (`slug`),
  ADD KEY `gallery_albums_sort_order_index` (`sort_order`);

--
-- Indexes for table `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_items_album_id_sort_order_index` (`album_id`,`sort_order`),
  ADD KEY `gallery_items_type_index` (`type`);

--
-- Indexes for table `home_sliders`
--
ALTER TABLE `home_sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `home_sliders_status_order_index` (`status`,`order`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD KEY `news_author_id_foreign` (`author_id`),
  ADD KEY `news_slug_index` (`slug`),
  ADD KEY `news_status_index` (`status`),
  ADD KEY `news_published_at_index` (`published_at`),
  ADD KEY `news_category_id_status_index` (`category_id`,`status`);

--
-- Indexes for table `news_categories`
--
ALTER TABLE `news_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_categories_slug_unique` (`slug`),
  ADD KEY `news_categories_slug_index` (`slug`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`),
  ADD KEY `pages_slug_index` (`slug`),
  ADD KEY `pages_status_index` (`status`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ppdb_registrations`
--
ALTER TABLE `ppdb_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ppdb_registrations_registration_number_unique` (`registration_number`),
  ADD KEY `ppdb_registrations_verified_by_foreign` (`verified_by`),
  ADD KEY `ppdb_registrations_registration_number_index` (`registration_number`),
  ADD KEY `ppdb_registrations_status_index` (`status`),
  ADD KEY `ppdb_registrations_email_index` (`email`),
  ADD KEY `ppdb_registrations_verified_at_index` (`verified_at`);

--
-- Indexes for table `ppdb_settings`
--
ALTER TABLE `ppdb_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ppdb_settings_status_index` (`status`),
  ADD KEY `ppdb_settings_registration_start_registration_end_index` (`registration_start`,`registration_end`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_logs_visited_at_index` (`visited_at`),
  ADD KEY `visitor_logs_ip_address_index` (`ip_address`),
  ADD KEY `visitor_logs_url_index` (`url`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `chatbot_responses`
--
ALTER TABLE `chatbot_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `competencies`
--
ALTER TABLE `competencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `competency_images`
--
ALTER TABLE `competency_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery_items`
--
ALTER TABLE `gallery_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `home_sliders`
--
ALTER TABLE `home_sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `news_categories`
--
ALTER TABLE `news_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppdb_registrations`
--
ALTER TABLE `ppdb_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ppdb_settings`
--
ALTER TABLE `ppdb_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `competency_images`
--
ALTER TABLE `competency_images`
  ADD CONSTRAINT `competency_images_competency_id_foreign` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD CONSTRAINT `gallery_items_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ppdb_registrations`
--
ALTER TABLE `ppdb_registrations`
  ADD CONSTRAINT `ppdb_registrations_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
