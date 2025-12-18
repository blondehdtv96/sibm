-- Database Backup
-- Generated: 2025-11-22 07:44:48



-- Table: audit_logs
DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE `audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `model_type` varchar(191) DEFAULT NULL,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `url` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `audit_logs_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `audit_logs_action_index` (`action`),
  KEY `audit_logs_created_at_index` (`created_at`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: audit_logs
INSERT INTO `audit_logs` VALUES ('1', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-14 05:39:19', '2025-10-14 05:39:19');
INSERT INTO `audit_logs` VALUES ('2', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-14 13:58:30', '2025-10-14 13:58:30');
INSERT INTO `audit_logs` VALUES ('3', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-15 03:28:05', '2025-10-15 03:28:05');
INSERT INTO `audit_logs` VALUES ('4', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-15 07:10:29', '2025-10-15 07:10:29');
INSERT INTO `audit_logs` VALUES ('5', '1', 'logout', NULL, NULL, '[]', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', '2025-10-15 07:55:02', '2025-10-15 07:55:02');
INSERT INTO `audit_logs` VALUES ('6', '1', 'logout', NULL, NULL, '[]', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', '2025-10-15 07:57:39', '2025-10-15 07:57:39');
INSERT INTO `audit_logs` VALUES ('7', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-15 12:54:17', '2025-10-15 12:54:17');
INSERT INTO `audit_logs` VALUES ('8', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-16 03:13:55', '2025-10-16 03:13:55');
INSERT INTO `audit_logs` VALUES ('9', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-18 06:12:54', '2025-10-18 06:12:54');
INSERT INTO `audit_logs` VALUES ('10', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-20 02:07:54', '2025-10-20 02:07:54');
INSERT INTO `audit_logs` VALUES ('11', '1', 'logout', NULL, NULL, '[]', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', '2025-10-20 02:28:55', '2025-10-20 02:28:55');
INSERT INTO `audit_logs` VALUES ('12', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-20 03:24:13', '2025-10-20 03:24:13');
INSERT INTO `audit_logs` VALUES ('13', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-22 01:03:34', '2025-10-22 01:03:34');
INSERT INTO `audit_logs` VALUES ('14', '1', 'logout', NULL, NULL, '[]', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', '2025-10-22 01:12:32', '2025-10-22 01:12:32');
INSERT INTO `audit_logs` VALUES ('15', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-22 01:12:47', '2025-10-22 01:12:47');
INSERT INTO `audit_logs` VALUES ('16', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-24 03:04:00', '2025-10-24 03:04:00');
INSERT INTO `audit_logs` VALUES ('17', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-10-27 10:10:10', '2025-10-27 10:10:10');
INSERT INTO `audit_logs` VALUES ('18', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-07 05:17:18', '2025-11-07 05:17:18');
INSERT INTO `audit_logs` VALUES ('19', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-11 01:11:00', '2025-11-11 01:11:00');
INSERT INTO `audit_logs` VALUES ('20', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-12 03:34:12', '2025-11-12 03:34:12');
INSERT INTO `audit_logs` VALUES ('21', NULL, 'login_failed', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-14 06:49:24', '2025-11-14 06:49:24');
INSERT INTO `audit_logs` VALUES ('22', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-14 06:49:29', '2025-11-14 06:49:29');
INSERT INTO `audit_logs` VALUES ('23', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-18 03:52:29', '2025-11-18 03:52:29');
INSERT INTO `audit_logs` VALUES ('24', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-18 07:28:31', '2025-11-18 07:28:31');
INSERT INTO `audit_logs` VALUES ('25', '1', 'login_success', NULL, NULL, '[]', '{\"email\":\"admin@school.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', '2025-11-22 07:07:11', '2025-11-22 07:07:11');


-- Table: chatbot_responses
DROP TABLE IF EXISTS `chatbot_responses`;
CREATE TABLE `chatbot_responses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `trigger_name` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `keywords` text NOT NULL,
  `response` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `priority` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chatbot_responses_trigger_name_unique` (`trigger_name`),
  KEY `chatbot_responses_is_active_index` (`is_active`),
  KEY `chatbot_responses_priority_index` (`priority`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: chatbot_responses
INSERT INTO `chatbot_responses` VALUES ('1', 'greeting', 'Salam & Perkenalan', '[\"halo\",\"hai\",\"hello\",\"hi\",\"assalamualaikum\"]', 'Halo! 😊 Selamat datang di SMK Bina Mandiri Bekasi. Saya asisten virtual yang siap membantu Anda. Ada yang bisa saya bantu?', '0', '100', '2025-10-15 12:53:01', '2025-10-22 01:04:00');
INSERT INTO `chatbot_responses` VALUES ('2', 'profile', 'Profil Sekolah', '[\"profil\",\"tentang sekolah\",\"tentang smk\",\"sekolah\"]', '🏫 **SMK Bina Mandiri Bekasi** adalah sekolah menengah kejuruan yang berfokus pada pengembangan keterampilan praktis dan profesional.

📍 **Alamat:** Jl. Pendidikan No. 123, Bekasi Timur, Kota Bekasi
📞 **Telepon:** (021) 1234-5678
📧 **Email:** info@smkbinamandiri.sch.id

Kami berkomitmen mencetak lulusan yang siap kerja dan berdaya saing tinggi! 💪', '1', '90', '2025-10-15 12:53:01', '2025-10-15 12:53:01');
INSERT INTO `chatbot_responses` VALUES ('3', 'visi_misi', 'Visi & Misi', '[\"visi\",\"misi\",\"visi misi\"]', '🎯 **Visi:**
Menjadi SMK unggulan yang menghasilkan lulusan berkualitas, profesional, dan berakhlak mulia.

📋 **Misi:**
1. Menyelenggarakan pendidikan berkualitas berbasis kompetensi
2. Mengembangkan kerjasama dengan dunia industri
3. Membentuk karakter siswa yang berakhlak mulia
4. Menyediakan fasilitas pembelajaran modern', '1', '85', '2025-10-15 12:53:01', '2025-10-15 12:53:01');
INSERT INTO `chatbot_responses` VALUES ('4', 'jurusan', 'Program Keahlian/Jurusan', '[\"jurusan\",\"program keahlian\",\"kompetensi\",\"tkj\",\"akuntansi\",\"dkv\"]', '📚 **Program Keahlian di SMK Bina Mandiri Bekasi:**

1. **Teknik Komputer & Jaringan (TKJ)** 💻
   - Belajar networking, programming, dan sistem komputer
   - Prospek: Network Administrator, IT Support, Web Developer

2. **Akuntansi** 💰
   - Belajar pembukuan, perpajakan, dan keuangan
   - Prospek: Akuntan, Staff Keuangan, Auditor

3. **Desain Komunikasi Visual (DKV)** 🎨
   - Belajar desain grafis, multimedia, dan animasi
   - Prospek: Graphic Designer, Video Editor, UI/UX Designer

Mau tahu lebih detail tentang jurusan tertentu? Tanya saja! 😊', '1', '95', '2025-10-15 12:53:01', '2025-10-15 12:53:01');
INSERT INTO `chatbot_responses` VALUES ('5', 'ppdb', 'PPDB (Pendaftaran)', '[\"ppdb\",\"pendaftaran\",\"daftar\",\"cara daftar\",\"syarat\"]', '📝 **Informasi PPDB SMK Bina Mandiri Bekasi:**

📅 **Jadwal Pendaftaran:**
Gelombang 1: Januari - Maret 2026
Gelombang 2: April - Juni 2026

📋 **Syarat Pendaftaran:**
✅ Ijazah/SKHUN SMP/MTs
✅ Kartu Keluarga
✅ Akta Kelahiran
✅ Pas Foto 3x4 (3 lembar)
✅ Fotocopy Rapor Semester 1-5

💻 **Cara Daftar:**
Kunjungi website kami dan klik menu \'PPDB\' atau datang langsung ke sekolah!

💰 **Biaya:** Gratis biaya pendaftaran! 🎉', '1', '95', '2025-10-15 12:53:01', '2025-10-15 12:53:01');
INSERT INTO `chatbot_responses` VALUES ('6', 'fasilitas', 'Fasilitas Sekolah', '[\"fasilitas\",\"sarana\",\"prasarana\",\"lab\",\"perpustakaan\"]', '🏢 **Fasilitas SMK Bina Mandiri Bekasi:**

✅ Ruang kelas ber-AC
✅ Laboratorium Komputer
✅ Laboratorium Akuntansi
✅ Studio Desain & Multimedia
✅ Perpustakaan Digital
✅ Masjid
✅ Kantin
✅ Lapangan Olahraga
✅ Free WiFi
✅ Parkir Luas

Semua fasilitas dirancang untuk mendukung pembelajaran optimal! 🎓', '1', '80', '2025-10-15 12:53:01', '2025-10-15 12:53:01');
INSERT INTO `chatbot_responses` VALUES ('7', 'contact', 'Alamat & Kontak', '[\"alamat\",\"lokasi\",\"dimana\",\"kontak\",\"telepon\",\"email\"]', '📍 **Alamat & Kontak SMK Bina Mandiri Bekasi:**

🏫 Jl. Pendidikan No. 123, Bekasi Timur
   Kota Bekasi, Jawa Barat 17113

📞 Telepon: (021) 1234-5678
📱 WhatsApp: 0812-3456-7890
📧 Email: info@smkbinamandiri.sch.id
🌐 Website: www.smkbinamandiri.sch.id

📍 Google Maps: [Klik di sini untuk petunjuk arah]

Kami buka Senin-Jumat: 07.00-16.00 WIB 🕐', '1', '85', '2025-10-15 12:53:01', '2025-10-15 12:53:01');
INSERT INTO `chatbot_responses` VALUES ('8', 'thanks', 'Terima Kasih', '[\"terima kasih\",\"thanks\",\"makasih\",\"thank you\"]', 'Sama-sama! 😊 Senang bisa membantu Anda. Jika ada pertanyaan lain tentang SMK Bina Mandiri Bekasi, jangan ragu untuk bertanya ya! 🏫✨', '1', '70', '2025-10-15 12:53:01', '2025-10-15 12:53:01');
INSERT INTO `chatbot_responses` VALUES ('9', 'goodbye', 'Selamat Tinggal', '[\"bye\",\"dadah\",\"sampai jumpa\",\"selamat tinggal\"]', 'Sampai jumpa! 👋 Semoga informasi yang saya berikan bermanfaat. Jangan lupa kunjungi website kami untuk info lebih lengkap. Selamat beraktivitas! 😊🏫', '1', '70', '2025-10-15 12:53:01', '2025-10-15 12:53:01');


-- Table: chats
DROP TABLE IF EXISTS `chats`;
CREATE TABLE `chats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(191) DEFAULT NULL,
  `user_message` text NOT NULL,
  `bot_reply` text NOT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `user_agent` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chats_session_id_index` (`session_id`),
  KEY `chats_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: chats
INSERT INTO `chats` VALUES ('1', 'session_1763436180945_rdt4126vj', 'A', 'Maaf, saya belum punya informasi tentang itu. 😅

Saya bisa membantu Anda dengan informasi tentang:
📚 Profil sekolah
🎓 Jurusan (TKJ, Akuntansi, DKV)
📝 PPDB (Pendaftaran)
🏢 Fasilitas
📍 Alamat & Kontak
⏰ Jadwal Pelajaran
🎯 Ekstrakurikuler

Silakan tanya hal-hal di atas ya! 😊', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-18 03:24:11', '2025-11-18 03:24:11');


-- Table: competencies
DROP TABLE IF EXISTS `competencies`;
CREATE TABLE `competencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `competencies_slug_unique` (`slug`),
  KEY `competencies_slug_index` (`slug`),
  KEY `competencies_status_index` (`status`),
  KEY `competencies_sort_order_index` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: competencies
INSERT INTO `competencies` VALUES ('10', 'Teknik Kendaraan Ringan', 'teknik-kendaraan-ringan', 'tester 2', NULL, NULL, NULL, 'competencies/xQCPjExGlZbKfweYeesTuOl3iZDZ0oKjaVFHiq3t.png', '2', 'active', '2025-11-07 07:11:15', '2025-11-07 07:11:15');
INSERT INTO `competencies` VALUES ('11', 'Teknik Sepeda Motor', 'teknik-sepeda-motor', 'tester 3', NULL, NULL, NULL, 'competencies/cLTR5YSskuOJuZT7usBTNe8RFOLKv1LQjwturm6a.jpg', '3', 'active', '2025-11-07 07:11:47', '2025-11-07 07:11:47');
INSERT INTO `competencies` VALUES ('12', 'Teknik Komputer & Jaringan', 'teknik-komputer-jaringan', '<p><strong>Visi</strong></p><p>Terwujudnya program diklat kejuruan yang berstandar nasional dan internasional serta unggul dalam keterampilan yang dilandasi iman dan taqwa.</p><p><strong>Misi</strong></p><ul><li>Mengembangkan sistem pendidikan menengah kejuruan yang reliabel dan fleksibel.</li><li>Mengembangkan sistem pendidikan menengah kejuruan yang terintegrasi antara jalur pendidikan sekolah yang sesuai tuntutan kebutuhan DUDI (Dunia Usaha Dan Dunia Industri).</li><li>Mengembangkan Sistem pembelajar berwawasan global yang berakar pada norma dan nilai budaya bangsa Indonesia.</li></ul><p><strong>Tujuan Konsentrasi Keahlian</strong></p><ol><li>Menghasilkan lulusan yang menguasai ilmu teknologi yang berkualitas, berbudi pekerti luhur dan religius.</li><li>Melatih dan mendidik siswa agar memiliki wawasan ilmu pengetahuan dan teknologi.</li><li>Mendidik siswa agar mampu memilih karir, berkompetisi dan mengembangkan sikap professional dalam program keahlian Teknik Komputer Jaringan.</li><li>Membentuk siswa yang cerdas, jujur, disiplin, kreatif, inovatif dan responsif.</li><li>Membekali siswa dengan ilmu pengetahuan dan keterampilan sebagai bekal bagi yang berminat melanjutkan ke jenjang pendidikan yang lebih tinggi.</li><li>Mendidik siswa dengan keahlian dan keterampilan dalam Kompetensi keahlian Teknik Komputer Jaringan agar dapat bekerja secara baik dan mandiri dalam Dunia Usaha/Dunia Industri (DUDI).</li></ol><p>Materi Pembelajaran</p><p><strong>Materi Kelas X</strong></p><ul><li>Proses bisnis di bidang Teknik Jaringan Komputer Dan Telekomunikasi</li><li>Perkembangan teknologi di bidang Teknik Jaringan Komputer Dan Telekomunikasi</li><li>Profesi dan Kewirausahaan (jobprofile dan technopreneur) di bidang Teknik Jaringan Komputer Dan Telekomunikasi</li><li>Keselamatan dan Kesehatan Kerja Lingkungan Hidup (K3LH) dan budaya kerja industri</li><li>Dasar-dasar Teknik Jaringan Komputer&nbsp;Dan Telekomunikasi</li><li>Media Dan Jaringan Telekomunikasi</li><li>Penggunaan Alat Ukur</li></ul><p><strong>Materi Kelas XI &amp; XII</strong></p><ul><li><strong>Perencanaan dan Pengalamatan Jaringan</strong></li></ul><p>Meliputi perencanaan topologi dan arsitektur jaringan, pengumpulan kebutuhan teknis pengguna yang menggunakan jaringan, pengumpulan data peralatan jaringan dengan teknologi yang sesuai, pengalamatan jaringan CIDR, VLSM, dan subnetting.</p><ul><li><strong>Teknologi Jaringan Kabel dan Nirkabel</strong></li></ul><p>Meliputi instalasi jaringan kabel dan nirkabel, pengujian, perawatan dan perbaikan jaringan kabel dan nirkabel, standar jaringan nirkabel, jenis-jenis teknologi jaringan nirkabel indoor dan outdoor, teknologi layanan Voice over IP (VoIP), jaringan fiber optic, jenis-jenis kabel fiber optic, fungsi alat kerja fiber optic, sambungan fiber optic, dan perbaikan jaringan fiber optic.</p><ul><li><strong>Keamanan Jaringan</strong></li></ul><p>Meliputi kebijakan penggunaan jaringan, ancaman dan serangan terhadap keamanan jaringan, penentuan sistem keamanan jaringan yang dibutuhkan, firewall pada host dan server, kebutuhan persyaratan alat-alat untuk membangun server firewall, konsep dan implementasi firewall di host dan server, fungsi dan cara kerja server autentifikasi, kebutuhan persyaratan alat-alat untuk membangun server autentifikasi, cara kerja sistem pendeteksi dan penahan ancaman/serangan yang masuk ke jaringan, analisis fungsi dan tata cara pengamanan server-server layanan pada jaringan, dan tata cara pengamanan komunikasi data menggunakan teknik kriptografi.</p><ul><li><strong>Pemasangan dan Konfigurasi Perangkat Jaringan</strong></li></ul><p>Meliputi pemasangan perangkat jaringan ke dalam sistem jaringan, penggantian perangkat jaringan sesuai dengan kebutuhan, konsep VLAN, konfigurasi dan pengujian VLAN, proses routing, jenis-jenis routing, konfigurasi, analisis permasalahan dan perbaikan konfigurasi routing statis dan routing dinamis, konfigurasi NAT, analisis permasalahan internet gateway dan perbaikan konfigurasi NAT, konfigurasi, analisis permasalahan dan perbaikan konfigurasi proxy server, manajemen bandwidth dan load balancing.</p><ul><li><strong>Administrasi Sistem Jaringan</strong></li></ul><p class=\"ql-align-justify\">Meliputi instalasi sistem operasi jaringan, konsep, instalasi services, konfigurasi, dan pengujian konfigurasi remote server, DHCP server, DNS server, FTP server, file server, web server, mail server, database server, Control Panel Hosting, Share Hosting Server, Dedicated Hosting Server, Virtual Private Server, VPN server, sistem kontrol, dan monitoring.</p><p><strong>Ruang Lingkup Kerja</strong></p><p>Lulusan SMK Bina Mandiri Kota Bekasi memiliki peluang lapangan kerja yang cukup luas, baik di lembaga-lembaga ‎pemerintah maupun swasta. Secara spesifik peluang kerja itu antara lain:</p><ol><li>Teknisi Komputer, Teknisi Jaringan, Web Developer, CCTV, Telekomunikasi</li><li>Lembaga Komputer ‎Umum, Setting dan Desainer mandiri,</li><li>Programmer, ‎dan lain-lain.‎</li><li>Lulusan SMK Bina Mandiri Kota Bekasi&nbsp;juga memiliki kesempatan yang sama untuk melanjutkan studi ke jenjang ‎pendidikan yang lebih tinggi, baik Diploma maupun Strata Satu pada jurusan yang relevan.‎ ‎</li></ol><p><br></p>', 'Zainudin, S.Pd', 'competencies/heads/x64RsMMqOS2UJsdGkbiIweBOlezb7p0ZocqbNtMD.jpg', NULL, 'competencies/SkdIXXIQqycusK8Z9VOV4rddI9QU7WqqbWJ1WSG8.jpg', '4', 'active', '2025-11-14 08:54:36', '2025-11-14 08:54:36');


-- Table: competency_images
DROP TABLE IF EXISTS `competency_images`;
CREATE TABLE `competency_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `competency_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(191) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competency_images_competency_id_order_index` (`competency_id`,`order`),
  KEY `competency_images_status_index` (`status`),
  CONSTRAINT `competency_images_competency_id_foreign` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: competency_images
INSERT INTO `competency_images` VALUES ('6', '12', 'competencies/teknik-komputer-jaringan/1763450993_0_7622635001.jpg', NULL, NULL, '1', 'active', '2025-11-18 07:29:53', '2025-11-18 07:29:53');
INSERT INTO `competency_images` VALUES ('7', '12', 'competencies/teknik-komputer-jaringan/1763450993_1_Blue-Tosca-Gradient-Futuristic-Technology-Background-Instagram-Story (1).png', NULL, NULL, '2', 'active', '2025-11-18 07:29:53', '2025-11-18 07:29:53');
INSERT INTO `competency_images` VALUES ('8', '12', 'competencies/teknik-komputer-jaringan/1763450993_2_WhatsApp Image 2025-10-27 at 08.39.35_20c5c701.jpg', NULL, NULL, '3', 'active', '2025-11-18 07:29:53', '2025-11-18 07:29:53');


-- Table: gallery_albums
DROP TABLE IF EXISTS `gallery_albums`;
CREATE TABLE `gallery_albums` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(191) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gallery_albums_slug_unique` (`slug`),
  KEY `gallery_albums_slug_index` (`slug`),
  KEY `gallery_albums_sort_order_index` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Table: gallery_items
DROP TABLE IF EXISTS `gallery_items`;
CREATE TABLE `gallery_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` bigint(20) unsigned NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `image_path` varchar(191) NOT NULL,
  `type` enum('image','video') NOT NULL DEFAULT 'image',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_items_album_id_sort_order_index` (`album_id`,`sort_order`),
  KEY `gallery_items_type_index` (`type`),
  CONSTRAINT `gallery_items_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Table: home_sliders
DROP TABLE IF EXISTS `home_sliders`;
CREATE TABLE `home_sliders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image_path` varchar(191) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `button_text` varchar(191) DEFAULT NULL,
  `button_link` varchar(191) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `home_sliders_status_order_index` (`status`,`order`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: home_sliders
INSERT INTO `home_sliders` VALUES ('2', 'sliders/xCsRKnlfOjjH93UeiFGvjeTbELLbPP9mBszsabsA.jpg', NULL, NULL, NULL, NULL, '0', 'active', '2025-11-14 08:20:09', '2025-11-14 08:20:09');
INSERT INTO `home_sliders` VALUES ('3', 'sliders/8GVj2lzS8tq6sx4mYsA0uKLIVKX9kiIbNnlQPIEk.png', NULL, NULL, NULL, NULL, '1', 'active', '2025-11-14 08:20:09', '2025-11-14 08:20:09');
INSERT INTO `home_sliders` VALUES ('4', 'sliders/28XXtPyJMDYDM0o8zciJPtXMxGRPBd1r6lPngJVn.png', NULL, NULL, NULL, NULL, '2', 'active', '2025-11-14 08:20:09', '2025-11-14 08:20:09');
INSERT INTO `home_sliders` VALUES ('5', 'sliders/MWeZoDpsJ4sa7JIhPEwMsPcTps2DxW3kRTwHHUSz.jpg', NULL, NULL, NULL, NULL, '3', 'active', '2025-11-14 08:20:09', '2025-11-14 08:20:09');


-- Table: menus
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `url` varchar(191) DEFAULT NULL,
  `route_name` varchar(191) DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `icon` varchar(191) DEFAULT NULL,
  `target` enum('_self','_blank') NOT NULL DEFAULT '_self',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_parent_id_foreign` (`parent_id`),
  CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: menus
INSERT INTO `menus` VALUES ('1', 'Beranda', NULL, 'home', NULL, '1', NULL, '_self', 'active', '2025-11-07 06:36:22', '2025-11-07 06:36:22');
INSERT INTO `menus` VALUES ('2', 'Tentang', NULL, 'info.about', NULL, '2', NULL, '_self', 'active', '2025-11-07 06:36:22', '2025-11-07 06:36:22');
INSERT INTO `menus` VALUES ('3', 'Selayang Pandang', NULL, 'info.overview', '2', '1', NULL, '_self', 'active', '2025-11-07 06:36:22', '2025-11-07 06:36:22');
INSERT INTO `menus` VALUES ('4', 'Sambutan Kepala Sekolah', NULL, 'info.principal-message', '2', '2', NULL, '_self', 'active', '2025-11-07 06:36:22', '2025-11-07 06:36:22');
INSERT INTO `menus` VALUES ('5', 'Program Keahlian', NULL, 'competencies.index', NULL, '3', NULL, '_self', 'active', '2025-11-07 06:36:22', '2025-11-07 06:36:22');
INSERT INTO `menus` VALUES ('6', 'Berita & Acara', NULL, 'news.index', NULL, '4', NULL, '_self', 'active', '2025-11-07 06:36:22', '2025-11-07 06:36:22');
INSERT INTO `menus` VALUES ('7', 'Galeri', NULL, 'gallery.index', NULL, '5', NULL, '_self', 'active', '2025-11-07 06:36:22', '2025-11-07 06:36:22');
INSERT INTO `menus` VALUES ('8', 'PPDB', NULL, 'ppdb.register', NULL, '6', NULL, '_self', 'active', '2025-11-07 06:36:22', '2025-11-07 06:36:22');
INSERT INTO `menus` VALUES ('9', 'Kontak', NULL, 'info.contact', NULL, '7', NULL, '_self', 'active', '2025-11-07 06:36:22', '2025-11-07 06:36:22');


-- Table: migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: migrations
INSERT INTO `migrations` VALUES ('1', '2019_12_14_000001_create_personal_access_tokens_table', '1');
INSERT INTO `migrations` VALUES ('2', '2024_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('3', '2024_01_01_000001_create_pages_table', '1');
INSERT INTO `migrations` VALUES ('4', '2024_01_01_000002_create_news_categories_table', '1');
INSERT INTO `migrations` VALUES ('5', '2024_01_01_000003_create_news_table', '1');
INSERT INTO `migrations` VALUES ('6', '2024_01_01_000004_create_competencies_table', '1');
INSERT INTO `migrations` VALUES ('7', '2024_01_01_000005_create_gallery_albums_table', '1');
INSERT INTO `migrations` VALUES ('8', '2024_01_01_000006_create_gallery_items_table', '1');
INSERT INTO `migrations` VALUES ('9', '2024_01_01_000007_create_ppdb_registrations_table', '1');
INSERT INTO `migrations` VALUES ('10', '2024_01_01_000008_create_ppdb_settings_table', '1');
INSERT INTO `migrations` VALUES ('11', '2024_01_15_000000_create_audit_logs_table', '1');
INSERT INTO `migrations` VALUES ('13', '2024_01_15_000000_create_visitor_logs_table', '2');
INSERT INTO `migrations` VALUES ('14', '2025_10_15_100000_create_chats_table', '3');
INSERT INTO `migrations` VALUES ('15', '2025_10_15_110000_create_chatbot_responses_table', '4');
INSERT INTO `migrations` VALUES ('16', '2025_10_15_120000_create_settings_table', '5');
INSERT INTO `migrations` VALUES ('17', '2025_01_08_100000_create_menus_table', '6');
INSERT INTO `migrations` VALUES ('18', '2025_01_08_110000_create_competency_images_table', '7');
INSERT INTO `migrations` VALUES ('19', '2025_01_08_120000_create_home_sliders_table', '8');
INSERT INTO `migrations` VALUES ('20', '2025_11_14_083213_add_head_of_program_to_competencies_table', '9');


-- Table: news
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text DEFAULT NULL,
  `featured_image` varchar(191) DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `author_id` bigint(20) unsigned NOT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`),
  KEY `news_author_id_foreign` (`author_id`),
  KEY `news_slug_index` (`slug`),
  KEY `news_status_index` (`status`),
  KEY `news_published_at_index` (`published_at`),
  KEY `news_category_id_status_index` (`category_id`,`status`),
  CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Table: news_categories
DROP TABLE IF EXISTS `news_categories`;
CREATE TABLE `news_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_categories_slug_unique` (`slug`),
  KEY `news_categories_slug_index` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: news_categories
INSERT INTO `news_categories` VALUES ('6', 'Kegiatan Sekolah', 'kegiatan-sekolah', 'Informasi SeputarKegiatan Sekolah', '2025-10-20 02:25:35', '2025-10-20 02:25:35');


-- Table: notifications
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Table: pages
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `content` longtext DEFAULT NULL,
  `banner_image` varchar(191) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`),
  KEY `pages_slug_index` (`slug`),
  KEY `pages_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Table: personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Table: ppdb_registrations
DROP TABLE IF EXISTS `ppdb_registrations`;
CREATE TABLE `ppdb_registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `verified_by` bigint(20) unsigned DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ppdb_registrations_registration_number_unique` (`registration_number`),
  KEY `ppdb_registrations_verified_by_foreign` (`verified_by`),
  KEY `ppdb_registrations_registration_number_index` (`registration_number`),
  KEY `ppdb_registrations_status_index` (`status`),
  KEY `ppdb_registrations_email_index` (`email`),
  KEY `ppdb_registrations_verified_at_index` (`verified_at`),
  CONSTRAINT `ppdb_registrations_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: ppdb_registrations
INSERT INTO `ppdb_registrations` VALUES ('18', 'PPDB20250001', 'testerppdb', 'testerppdb@gmail.com', '09898989898', '1996-01-01', 'bekasi', 'testerwali', '03890128320193', '\"[{\\\"name\\\":\\\"images.jpg\\\",\\\"path\\\":\\\"ppdb-documents\\\\\\/1PFCokF4dJUDrcIVnhlqBJb690Q3t8SZKhD4u8b3.jpg\\\"},{\\\"name\\\":\\\"images.jpg\\\",\\\"path\\\":\\\"ppdb-documents\\\\\\/SAJ4IoV09JPlSdnkYPT4XkquFhx9n7kxIHzkcQv5.jpg\\\"}]\"', 'pending', NULL, NULL, NULL, '2025-10-15 03:51:20', '2025-10-15 03:51:20');


-- Table: ppdb_settings
DROP TABLE IF EXISTS `ppdb_settings`;
CREATE TABLE `ppdb_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registration_start` date NOT NULL,
  `registration_end` date NOT NULL,
  `requirements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requirements`)),
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ppdb_settings_status_index` (`status`),
  KEY `ppdb_settings_registration_start_registration_end_index` (`registration_start`,`registration_end`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: ppdb_settings
INSERT INTO `ppdb_settings` VALUES ('1', '2025-10-10', '2026-10-10', '\"[\\\"Birth Certificate (Akta Kelahiran)\\\",\\\"Family Card (Kartu Keluarga)\\\",\\\"Student Photo 3x4 (2 sheets)\\\",\\\"Health Certificate\\\",\\\"Certificate of Good Conduct\\\",\\\"Raport Dari Sekolah Sebelumnya\\\"]\"', 'active', '2025-10-14 04:02:08', '2025-10-15 03:46:06');


-- Table: settings
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'text',
  `group` varchar(191) NOT NULL DEFAULT 'general',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: settings
INSERT INTO `settings` VALUES ('1', 'site_logo', 'logos/site_logo_1761563891.png', 'image', 'appearance', 'Logo sekolah yang ditampilkan di header', '2025-10-22 01:19:01', '2025-10-27 11:18:11');
INSERT INTO `settings` VALUES ('2', 'site_logo_dark', NULL, 'image', 'appearance', 'Logo sekolah untuk dark mode', '2025-10-22 01:19:01', '2025-10-22 01:19:01');
INSERT INTO `settings` VALUES ('3', 'site_favicon', NULL, 'image', 'appearance', 'Favicon website', '2025-10-22 01:19:01', '2025-10-22 01:19:01');
INSERT INTO `settings` VALUES ('4', 'site_name', 'SMK Bina Mandiri Kota Bekasi', 'text', 'general', 'Nama sekolah', '2025-10-22 01:19:01', '2025-10-22 01:24:58');
INSERT INTO `settings` VALUES ('5', 'site_tagline', 'Ikhlas Berkarya Pelayanan Prima', 'text', 'general', 'Tagline sekolah', '2025-10-22 01:19:01', '2025-11-22 07:29:57');
INSERT INTO `settings` VALUES ('7', 'school_overview', 'SMK Bina Mandiri Bekasi didirikan pada tahun 2005 dengan visi menjadi lembaga pendidikan kejuruan terkemuka yang menghasilkan lulusan berkualitas, kompeten, dan siap kerja.

Sekolah kami memiliki berbagai program keahlian yang disesuaikan dengan kebutuhan industri modern, didukung oleh tenaga pengajar profesional dan fasilitas pembelajaran yang lengkap.

Dengan motto \"Cerdas, Terampil, dan Berakhlak Mulia\", kami berkomitmen untuk membentuk generasi muda yang tidak hanya unggul dalam kompetensi teknis, tetapi juga memiliki karakter yang kuat dan nilai-nilai moral yang tinggi.

Fasilitas kami meliputi laboratorium komputer, workshop praktik, perpustakaan digital, dan ruang kelas ber-AC yang nyaman. Kami juga menjalin kerjasama dengan berbagai industri untuk program magang dan penempatan kerja lulusan.', 'text', 'general', NULL, '2025-11-07 06:47:14', '2025-11-07 06:47:14');
INSERT INTO `settings` VALUES ('8', 'principal_name', 'Endah Sulistiani, S.Pd M.Si', 'text', 'general', NULL, '2025-11-07 06:47:14', '2025-11-07 06:58:51');
INSERT INTO `settings` VALUES ('9', 'principal_message', 'Assalamu\'alaikum Warahmatullahi Wabarakatuh,

Puji syukur kita panjatkan kehadirat Allah SWT yang telah memberikan rahmat dan karunia-Nya kepada kita semua. Shalawat serta salam semoga senantiasa tercurah kepada Nabi Muhammad SAW, keluarga, sahabat, dan para pengikutnya hingga akhir zaman.

Selamat datang di SMK Bina Mandiri Bekasi. Sebagai Kepala Sekolah, saya merasa bangga dan bersyukur dapat memimpin lembaga pendidikan yang terus berkembang dan berinovasi dalam mencetak generasi muda yang berkualitas.

Pendidikan kejuruan memiliki peran strategis dalam mempersiapkan tenaga kerja terampil yang siap menghadapi tantangan dunia industri. Oleh karena itu, kami berkomitmen untuk memberikan pendidikan terbaik yang tidak hanya fokus pada pengembangan kompetensi teknis, tetapi juga pembentukan karakter dan akhlak mulia.

Kepada para siswa, saya mengajak kalian untuk memanfaatkan setiap kesempatan belajar dengan sebaik-baiknya. Jadilah pribadi yang disiplin, bertanggung jawab, dan selalu bersemangat dalam menuntut ilmu. Kepada para orang tua, terima kasih atas kepercayaan yang telah diberikan. Mari kita bersinergi dalam mendidik putra-putri kita menjadi generasi yang unggul.

Semoga SMK Bina Mandiri Bekasi terus menjadi pilihan terbaik dalam pendidikan kejuruan dan menghasilkan lulusan yang bermanfaat bagi bangsa dan negara.

Wassalamu\'alaikum Warahmatullahi Wabarakatuh.', 'text', 'general', NULL, '2025-11-07 06:47:14', '2025-11-07 06:58:51');
INSERT INTO `settings` VALUES ('10', 'principal_photo', 'principal/principal_1762498731.jpg', 'image', 'general', NULL, '2025-11-07 06:58:51', '2025-11-07 06:58:51');
INSERT INTO `settings` VALUES ('11', 'contact_address', 'Jl. Bintara IX No.7 4, RT.001/RW.005, Bintara, Kec. Bekasi Bar., Kota Bks, Jawa Barat 17134', 'text', 'general', NULL, '2025-11-11 01:23:19', '2025-11-12 03:36:53');
INSERT INTO `settings` VALUES ('12', 'contact_phone', '(021) 8860686', 'text', 'general', NULL, '2025-11-11 01:23:19', '2025-11-12 03:36:53');
INSERT INTO `settings` VALUES ('13', 'contact_email', 'smkbinamandiribks@gmail.com', 'text', 'general', NULL, '2025-11-11 01:23:19', '2025-11-12 03:36:53');
INSERT INTO `settings` VALUES ('14', 'contact_whatsapp', '6281292760717', 'text', 'general', NULL, '2025-11-11 01:23:19', '2025-11-12 03:36:53');
INSERT INTO `settings` VALUES ('15', 'social_facebook', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-11 01:23:19', '2025-11-11 02:21:24');
INSERT INTO `settings` VALUES ('16', 'social_instagram', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-11 01:23:19', '2025-11-11 02:21:24');
INSERT INTO `settings` VALUES ('17', 'social_twitter', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-11 01:23:19', '2025-11-11 02:21:24');
INSERT INTO `settings` VALUES ('18', 'social_youtube', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-11 01:23:19', '2025-11-11 02:21:24');
INSERT INTO `settings` VALUES ('19', 'social_tiktok', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-11 01:23:19', '2025-11-11 02:21:24');
INSERT INTO `settings` VALUES ('20', 'social_linkedin', 'https://instagram.com/smkbinamandiribekasi_official', 'text', 'general', NULL, '2025-11-11 01:23:19', '2025-11-11 02:21:24');
INSERT INTO `settings` VALUES ('21', 'stat1_value', '1000+', 'text', 'general', NULL, '2025-11-18 03:27:10', '2025-11-18 03:27:10');
INSERT INTO `settings` VALUES ('22', 'stat1_label', 'Alumni Sukses', 'text', 'general', NULL, '2025-11-18 03:27:10', '2025-11-18 03:27:10');
INSERT INTO `settings` VALUES ('23', 'stat2_value', '3', 'text', 'general', NULL, '2025-11-18 03:27:10', '2025-11-18 03:53:26');
INSERT INTO `settings` VALUES ('24', 'stat2_label', 'Program Keahlian', 'text', 'general', NULL, '2025-11-18 03:27:10', '2025-11-18 03:27:10');
INSERT INTO `settings` VALUES ('25', 'stat3_value', '100+', 'text', 'general', NULL, '2025-11-18 03:27:10', '2025-11-18 03:53:26');
INSERT INTO `settings` VALUES ('26', 'stat3_label', 'Guru Berpengalaman', 'text', 'general', NULL, '2025-11-18 03:27:10', '2025-11-18 03:27:10');
INSERT INTO `settings` VALUES ('27', 'stat4_value', '100%', 'text', 'general', NULL, '2025-11-18 03:27:10', '2025-11-18 03:53:26');
INSERT INTO `settings` VALUES ('28', 'stat4_label', 'Tingkat Kelulusan', 'text', 'general', NULL, '2025-11-18 03:27:10', '2025-11-18 03:27:10');


-- Table: users
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL DEFAULT 'student',
  `profile_image` varchar(191) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: users
INSERT INTO `users` VALUES ('1', 'Admin User', 'admin@school.com', '2025-10-14 04:02:08', '$2y$12$RWZ..Y4JIPZU.ClmOg9HKeXYS4ALF0nP8eo1EhhETsr4m7CNl/GlW', 'admin', NULL, '081234567890', NULL, '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('2', 'Mrs. Loren Hills', 'francisca71@example.com', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'teacher', NULL, '+1-425-869-5107', '8gF2c8x0jS', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('3', 'Keon Walsh DVM', 'leslie.donnelly@example.net', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'teacher', NULL, '+1-769-807-3558', 'YhW8kouOmZ', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('4', 'Diego Harber', 'jocelyn.bins@example.com', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'teacher', NULL, '+1.954.338.2014', 'P9lUlZ7fGh', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('5', 'Prof. Santa Witting Jr.', 'madaline41@example.com', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'teacher', NULL, '667.346.8325', 'k7qSrydlWT', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('6', 'Keely Kuphal', 'glenda90@example.net', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'teacher', NULL, '1-641-778-3234', 'KQ5AqeBx9O', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('7', 'Hilma Hoeger', 'araceli.dicki@example.org', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '+1.865.348.3035', 'tqo2CjoSY4', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('8', 'Berry Walker', 'mbergnaum@example.net', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '917-600-9121', 'RasPiaMArW', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('9', 'Jabari Koepp PhD', 'kristofer.wintheiser@example.org', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '+1-435-839-7135', 'CGrpN0xtsC', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('10', 'Mr. Randy Rohan', 'kathryne49@example.net', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '+1 (718) 628-9186', 'y9OgA3CD2h', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('11', 'Magdalena Pagac', 'murphy.keeley@example.com', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '(848) 790-5996', 'XixTXTZtou', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('12', 'Nora Gusikowski', 'avis.macejkovic@example.net', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '+1-954-864-4466', 'H6hwEQBbyI', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('13', 'Miss Laurianne Halvorson', 'vada31@example.org', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '478-566-4538', 'YL0EZnRJ7O', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('14', 'Jaqueline Trantow', 'cfay@example.com', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '(239) 817-3702', 'jJQh2xpUQS', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('15', 'Eloy Lowe', 'jbogan@example.net', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '+1-667-449-6572', 'txBCIufu1w', '2025-10-14 04:02:08', '2025-10-14 04:02:08');
INSERT INTO `users` VALUES ('16', 'Brown Satterfield', 'fredy46@example.net', '2025-10-14 04:02:08', '$2y$12$6fI3MgvVHauVqtA8WisP5u2JzLG.Ap.LqR2HhogrEgpRepzeNcWha', 'student', NULL, '878.493.3472', '196VN2gY1F', '2025-10-14 04:02:08', '2025-10-14 04:02:08');


-- Table: visitor_logs
DROP TABLE IF EXISTS `visitor_logs`;
CREATE TABLE `visitor_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(191) DEFAULT NULL,
  `url` varchar(500) NOT NULL,
  `referer` varchar(500) DEFAULT NULL,
  `method` varchar(10) NOT NULL DEFAULT 'GET',
  `visited_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `visitor_logs_visited_at_index` (`visited_at`),
  KEY `visitor_logs_ip_address_index` (`ip_address`),
  KEY `visitor_logs_url_index` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=288 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: visitor_logs
INSERT INTO `visitor_logs` VALUES ('1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/ppdb/check-status', 'GET', '2025-10-15 04:40:12');
INSERT INTO `visitor_logs` VALUES ('2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 07:08:36');
INSERT INTO `visitor_logs` VALUES ('3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-15 07:09:22');
INSERT INTO `visitor_logs` VALUES ('4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-15 07:57:39');
INSERT INTO `visitor_logs` VALUES ('5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 07:57:44');
INSERT INTO `visitor_logs` VALUES ('6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 07:58:47');
INSERT INTO `visitor_logs` VALUES ('7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 12:45:32');
INSERT INTO `visitor_logs` VALUES ('8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-15 12:54:04');
INSERT INTO `visitor_logs` VALUES ('9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 12:55:27');
INSERT INTO `visitor_logs` VALUES ('10', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 12:55:49');
INSERT INTO `visitor_logs` VALUES ('11', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 12:58:23');
INSERT INTO `visitor_logs` VALUES ('12', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-15 12:58:52');
INSERT INTO `visitor_logs` VALUES ('13', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-16 03:09:48');
INSERT INTO `visitor_logs` VALUES ('14', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-10-16 03:10:38');
INSERT INTO `visitor_logs` VALUES ('15', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-16 03:11:12');
INSERT INTO `visitor_logs` VALUES ('16', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/contact', 'GET', '2025-10-16 03:11:46');
INSERT INTO `visitor_logs` VALUES ('17', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-10-16 03:12:17');
INSERT INTO `visitor_logs` VALUES ('18', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/ppdb/register', 'GET', '2025-10-16 03:12:49');
INSERT INTO `visitor_logs` VALUES ('19', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/', 'GET', '2025-10-16 03:13:38');
INSERT INTO `visitor_logs` VALUES ('20', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-16 03:13:42');
INSERT INTO `visitor_logs` VALUES ('21', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-18 06:00:23');
INSERT INTO `visitor_logs` VALUES ('22', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-18 06:12:32');
INSERT INTO `visitor_logs` VALUES ('23', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-18 06:12:40');
INSERT INTO `visitor_logs` VALUES ('24', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000/about', NULL, 'GET', '2025-10-18 06:13:38');
INSERT INTO `visitor_logs` VALUES ('25', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-18 06:13:42');
INSERT INTO `visitor_logs` VALUES ('26', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-10-18 06:23:07');
INSERT INTO `visitor_logs` VALUES ('27', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-20 01:51:38');
INSERT INTO `visitor_logs` VALUES ('28', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-20 01:53:28');
INSERT INTO `visitor_logs` VALUES ('29', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-20 01:53:45');
INSERT INTO `visitor_logs` VALUES ('30', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 01:53:57');
INSERT INTO `visitor_logs` VALUES ('31', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 02:05:53');
INSERT INTO `visitor_logs` VALUES ('32', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 02:06:32');
INSERT INTO `visitor_logs` VALUES ('33', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'GET', '2025-10-20 02:06:51');
INSERT INTO `visitor_logs` VALUES ('34', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 02:07:01');
INSERT INTO `visitor_logs` VALUES ('35', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/news/velit-at-molestiae-eaque-veniam-in', 'GET', '2025-10-20 02:07:35');
INSERT INTO `visitor_logs` VALUES ('36', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-20 02:07:44');
INSERT INTO `visitor_logs` VALUES ('37', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/admin/pages', 'GET', '2025-10-20 02:28:56');
INSERT INTO `visitor_logs` VALUES ('38', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-20 02:29:01');
INSERT INTO `visitor_logs` VALUES ('39', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 02:29:14');
INSERT INTO `visitor_logs` VALUES ('40', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 02:29:16');
INSERT INTO `visitor_logs` VALUES ('41', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 02:29:17');
INSERT INTO `visitor_logs` VALUES ('42', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-20 02:29:19');
INSERT INTO `visitor_logs` VALUES ('43', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 02:29:20');
INSERT INTO `visitor_logs` VALUES ('44', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/news', 'GET', '2025-10-20 02:29:21');
INSERT INTO `visitor_logs` VALUES ('45', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/gallery', 'http://127.0.0.1:8000/news', 'GET', '2025-10-20 02:29:22');
INSERT INTO `visitor_logs` VALUES ('46', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/gallery', 'GET', '2025-10-20 02:29:23');
INSERT INTO `visitor_logs` VALUES ('47', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/contact', 'GET', '2025-10-20 02:29:25');
INSERT INTO `visitor_logs` VALUES ('48', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 02:29:26');
INSERT INTO `visitor_logs` VALUES ('49', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 02:29:34');
INSERT INTO `visitor_logs` VALUES ('50', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 02:29:53');
INSERT INTO `visitor_logs` VALUES ('51', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 02:29:55');
INSERT INTO `visitor_logs` VALUES ('52', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 02:29:56');
INSERT INTO `visitor_logs` VALUES ('53', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/news', 'GET', '2025-10-20 02:29:58');
INSERT INTO `visitor_logs` VALUES ('54', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/news', 'GET', '2025-10-20 02:34:45');
INSERT INTO `visitor_logs` VALUES ('55', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/news', 'GET', '2025-10-20 02:34:49');
INSERT INTO `visitor_logs` VALUES ('56', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 02:34:54');
INSERT INTO `visitor_logs` VALUES ('57', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 02:34:56');
INSERT INTO `visitor_logs` VALUES ('58', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-20 02:34:58');
INSERT INTO `visitor_logs` VALUES ('59', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-20 03:17:37');
INSERT INTO `visitor_logs` VALUES ('60', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-20 03:18:14');
INSERT INTO `visitor_logs` VALUES ('61', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-20 03:18:37');
INSERT INTO `visitor_logs` VALUES ('62', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/news', 'GET', '2025-10-20 03:19:02');
INSERT INTO `visitor_logs` VALUES ('63', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 03:19:05');
INSERT INTO `visitor_logs` VALUES ('64', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 03:19:07');
INSERT INTO `visitor_logs` VALUES ('65', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 03:19:09');
INSERT INTO `visitor_logs` VALUES ('66', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 03:19:10');
INSERT INTO `visitor_logs` VALUES ('67', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 03:19:12');
INSERT INTO `visitor_logs` VALUES ('68', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/contact', 'GET', '2025-10-20 03:19:34');
INSERT INTO `visitor_logs` VALUES ('69', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 03:20:07');
INSERT INTO `visitor_logs` VALUES ('70', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 03:20:23');
INSERT INTO `visitor_logs` VALUES ('71', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-20 03:20:27');
INSERT INTO `visitor_logs` VALUES ('72', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 03:20:32');
INSERT INTO `visitor_logs` VALUES ('73', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 03:20:37');
INSERT INTO `visitor_logs` VALUES ('74', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 03:23:07');
INSERT INTO `visitor_logs` VALUES ('75', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 03:23:09');
INSERT INTO `visitor_logs` VALUES ('76', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 03:23:43');
INSERT INTO `visitor_logs` VALUES ('77', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-20 03:23:48');
INSERT INTO `visitor_logs` VALUES ('78', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 03:23:52');
INSERT INTO `visitor_logs` VALUES ('79', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-10-20 03:23:58');
INSERT INTO `visitor_logs` VALUES ('80', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 03:24:05');
INSERT INTO `visitor_logs` VALUES ('81', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-20 03:24:36');
INSERT INTO `visitor_logs` VALUES ('82', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 03:24:42');
INSERT INTO `visitor_logs` VALUES ('83', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-20 03:24:50');
INSERT INTO `visitor_logs` VALUES ('84', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-20 03:27:25');
INSERT INTO `visitor_logs` VALUES ('85', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-20 03:29:09');
INSERT INTO `visitor_logs` VALUES ('86', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 03:29:12');
INSERT INTO `visitor_logs` VALUES ('87', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-20 03:29:17');
INSERT INTO `visitor_logs` VALUES ('88', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-22 00:57:34');
INSERT INTO `visitor_logs` VALUES ('89', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-22 00:58:06');
INSERT INTO `visitor_logs` VALUES ('90', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/about', 'GET', '2025-10-22 00:58:15');
INSERT INTO `visitor_logs` VALUES ('91', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/news', 'http://127.0.0.1:8000/competencies', 'GET', '2025-10-22 00:58:22');
INSERT INTO `visitor_logs` VALUES ('92', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/news', 'GET', '2025-10-22 00:58:35');
INSERT INTO `visitor_logs` VALUES ('93', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/contact', 'GET', '2025-10-22 00:58:47');
INSERT INTO `visitor_logs` VALUES ('94', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-22 01:03:14');
INSERT INTO `visitor_logs` VALUES ('95', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/admin/ppdb-settings', 'GET', '2025-10-22 01:12:32');
INSERT INTO `visitor_logs` VALUES ('96', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-10-22 01:22:35');
INSERT INTO `visitor_logs` VALUES ('97', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-22 01:25:01');
INSERT INTO `visitor_logs` VALUES ('98', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-22 01:42:54');
INSERT INTO `visitor_logs` VALUES ('99', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-10-22 01:44:11');
INSERT INTO `visitor_logs` VALUES ('100', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 01:46:11');
INSERT INTO `visitor_logs` VALUES ('101', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 01:46:17');
INSERT INTO `visitor_logs` VALUES ('102', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 02:13:46');
INSERT INTO `visitor_logs` VALUES ('103', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 02:15:51');
INSERT INTO `visitor_logs` VALUES ('104', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 04:05:45');
INSERT INTO `visitor_logs` VALUES ('105', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 04:05:51');
INSERT INTO `visitor_logs` VALUES ('106', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 04:05:51');
INSERT INTO `visitor_logs` VALUES ('107', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 04:06:53');
INSERT INTO `visitor_logs` VALUES ('108', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 04:06:53');
INSERT INTO `visitor_logs` VALUES ('109', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 04:06:53');
INSERT INTO `visitor_logs` VALUES ('110', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 04:06:54');
INSERT INTO `visitor_logs` VALUES ('111', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 04:06:54');
INSERT INTO `visitor_logs` VALUES ('112', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 04:06:55');
INSERT INTO `visitor_logs` VALUES ('113', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/chatbot-responses', 'GET', '2025-10-22 04:06:55');
INSERT INTO `visitor_logs` VALUES ('114', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/', 'GET', '2025-10-22 04:09:59');
INSERT INTO `visitor_logs` VALUES ('115', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/contact', 'GET', '2025-10-22 04:10:26');
INSERT INTO `visitor_logs` VALUES ('116', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-10-22 04:10:31');
INSERT INTO `visitor_logs` VALUES ('117', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-22 04:10:32');
INSERT INTO `visitor_logs` VALUES ('118', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-22 04:11:20');
INSERT INTO `visitor_logs` VALUES ('119', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-22 04:11:26');
INSERT INTO `visitor_logs` VALUES ('120', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-22 04:11:44');
INSERT INTO `visitor_logs` VALUES ('121', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-22 04:17:50');
INSERT INTO `visitor_logs` VALUES ('122', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-22 04:18:24');
INSERT INTO `visitor_logs` VALUES ('123', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-22 04:18:25');
INSERT INTO `visitor_logs` VALUES ('124', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-22 04:19:14');
INSERT INTO `visitor_logs` VALUES ('125', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-22 04:19:43');
INSERT INTO `visitor_logs` VALUES ('126', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-22 04:20:21');
INSERT INTO `visitor_logs` VALUES ('127', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-24 03:03:44');
INSERT INTO `visitor_logs` VALUES ('128', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-24 03:03:52');
INSERT INTO `visitor_logs` VALUES ('129', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-27 03:03:37');
INSERT INTO `visitor_logs` VALUES ('130', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-27 03:05:15');
INSERT INTO `visitor_logs` VALUES ('131', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-27 03:17:03');
INSERT INTO `visitor_logs` VALUES ('132', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-10-27 03:17:06');
INSERT INTO `visitor_logs` VALUES ('133', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-10-27 03:20:09');
INSERT INTO `visitor_logs` VALUES ('134', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/gallery', 'http://127.0.0.1:8000/', 'GET', '2025-10-27 03:20:13');
INSERT INTO `visitor_logs` VALUES ('135', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-27 03:20:18');
INSERT INTO `visitor_logs` VALUES ('136', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-27 04:57:37');
INSERT INTO `visitor_logs` VALUES ('137', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-10-27 10:09:55');
INSERT INTO `visitor_logs` VALUES ('138', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/about', 'GET', '2025-10-27 10:10:00');
INSERT INTO `visitor_logs` VALUES ('139', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-27 10:10:40');
INSERT INTO `visitor_logs` VALUES ('140', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-27 11:10:35');
INSERT INTO `visitor_logs` VALUES ('141', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-27 11:13:08');
INSERT INTO `visitor_logs` VALUES ('142', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings', 'GET', '2025-10-27 11:17:58');
INSERT INTO `visitor_logs` VALUES ('143', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-10-27 11:18:00');
INSERT INTO `visitor_logs` VALUES ('144', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-10-27 11:18:17');
INSERT INTO `visitor_logs` VALUES ('145', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-10-27 11:20:13');
INSERT INTO `visitor_logs` VALUES ('146', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', NULL, 'GET', '2025-10-27 11:22:27');
INSERT INTO `visitor_logs` VALUES ('147', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/pages/tester', 'http://127.0.0.1:8000/admin/pages', 'GET', '2025-10-27 11:24:35');
INSERT INTO `visitor_logs` VALUES ('148', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', NULL, 'GET', '2025-10-27 11:24:58');
INSERT INTO `visitor_logs` VALUES ('149', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', NULL, 'GET', '2025-10-27 11:25:00');
INSERT INTO `visitor_logs` VALUES ('150', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', NULL, 'GET', '2025-10-27 11:30:45');
INSERT INTO `visitor_logs` VALUES ('151', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/pages/nulla-laborum-eaque-veniam', 'http://127.0.0.1:8000/admin/pages', 'GET', '2025-10-27 11:38:25');
INSERT INTO `visitor_logs` VALUES ('152', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/pages/eligendi-quidem-voluptas-a', 'http://127.0.0.1:8000/admin/pages', 'GET', '2025-10-27 11:38:34');
INSERT INTO `visitor_logs` VALUES ('153', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/pages/eligendi-quidem-voluptas-a', 'GET', '2025-10-27 11:38:49');
INSERT INTO `visitor_logs` VALUES ('154', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-01 03:08:27');
INSERT INTO `visitor_logs` VALUES ('155', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'http://127.0.0.1:8000/', 'GET', '2025-11-01 03:10:39');
INSERT INTO `visitor_logs` VALUES ('156', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', NULL, 'GET', '2025-11-01 03:18:08');
INSERT INTO `visitor_logs` VALUES ('157', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'GET', '2025-11-01 03:18:21');
INSERT INTO `visitor_logs` VALUES ('158', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-01 03:18:29');
INSERT INTO `visitor_logs` VALUES ('159', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-01 03:20:56');
INSERT INTO `visitor_logs` VALUES ('160', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-01 03:31:32');
INSERT INTO `visitor_logs` VALUES ('161', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/competencies/adsadasdasd', 'GET', '2025-11-01 03:31:39');
INSERT INTO `visitor_logs` VALUES ('162', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/ppdb/register', 'GET', '2025-11-01 03:31:45');
INSERT INTO `visitor_logs` VALUES ('163', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-01 03:32:35');
INSERT INTO `visitor_logs` VALUES ('164', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-07 05:01:24');
INSERT INTO `visitor_logs` VALUES ('165', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-11-07 05:03:46');
INSERT INTO `visitor_logs` VALUES ('166', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-11-07 05:15:39');
INSERT INTO `visitor_logs` VALUES ('167', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/about', 'GET', '2025-11-07 05:15:47');
INSERT INTO `visitor_logs` VALUES ('168', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', 'http://127.0.0.1:8000/about', 'GET', '2025-11-07 05:15:53');
INSERT INTO `visitor_logs` VALUES ('169', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/about', 'GET', '2025-11-07 05:16:26');
INSERT INTO `visitor_logs` VALUES ('170', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/about', 'GET', '2025-11-07 05:17:07');
INSERT INTO `visitor_logs` VALUES ('171', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/dashboard', 'GET', '2025-11-07 05:18:34');
INSERT INTO `visitor_logs` VALUES ('172', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', 'http://127.0.0.1:8000/', 'GET', '2025-11-07 05:18:37');
INSERT INTO `visitor_logs` VALUES ('173', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', NULL, 'GET', '2025-11-07 05:25:26');
INSERT INTO `visitor_logs` VALUES ('174', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-07 06:41:10');
INSERT INTO `visitor_logs` VALUES ('175', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-07 06:48:06');
INSERT INTO `visitor_logs` VALUES ('176', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-07 06:58:58');
INSERT INTO `visitor_logs` VALUES ('177', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-07 06:59:22');
INSERT INTO `visitor_logs` VALUES ('178', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-07 06:59:33');
INSERT INTO `visitor_logs` VALUES ('179', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/about', 'GET', '2025-11-07 07:00:06');
INSERT INTO `visitor_logs` VALUES ('180', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-11-07 07:01:56');
INSERT INTO `visitor_logs` VALUES ('181', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-11-07 07:07:41');
INSERT INTO `visitor_logs` VALUES ('182', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/', 'GET', '2025-11-07 07:07:47');
INSERT INTO `visitor_logs` VALUES ('183', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-07 07:07:54');
INSERT INTO `visitor_logs` VALUES ('184', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-07 07:08:00');
INSERT INTO `visitor_logs` VALUES ('185', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-07 07:10:31');
INSERT INTO `visitor_logs` VALUES ('186', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-07 07:11:53');
INSERT INTO `visitor_logs` VALUES ('187', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-07 07:11:59');
INSERT INTO `visitor_logs` VALUES ('188', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-kendaraan-ringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-07 07:12:47');
INSERT INTO `visitor_logs` VALUES ('189', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-11 01:10:20');
INSERT INTO `visitor_logs` VALUES ('190', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-11 01:10:37');
INSERT INTO `visitor_logs` VALUES ('191', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-11 01:10:43');
INSERT INTO `visitor_logs` VALUES ('192', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-11 01:10:49');
INSERT INTO `visitor_logs` VALUES ('193', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/competencies/teknik-komputer-jaringan/images', 'GET', '2025-11-11 01:12:08');
INSERT INTO `visitor_logs` VALUES ('194', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-11 01:12:11');
INSERT INTO `visitor_logs` VALUES ('195', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-11 01:12:15');
INSERT INTO `visitor_logs` VALUES ('196', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-11 01:12:31');
INSERT INTO `visitor_logs` VALUES ('197', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-11 01:15:19');
INSERT INTO `visitor_logs` VALUES ('198', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-11 01:15:21');
INSERT INTO `visitor_logs` VALUES ('199', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-11 01:15:22');
INSERT INTO `visitor_logs` VALUES ('200', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-11 01:24:40');
INSERT INTO `visitor_logs` VALUES ('201', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-11 02:21:32');
INSERT INTO `visitor_logs` VALUES ('202', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/contact-social', 'GET', '2025-11-11 02:21:43');
INSERT INTO `visitor_logs` VALUES ('203', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-12 03:31:46');
INSERT INTO `visitor_logs` VALUES ('204', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/', 'GET', '2025-11-12 03:32:07');
INSERT INTO `visitor_logs` VALUES ('205', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-12 03:32:26');
INSERT INTO `visitor_logs` VALUES ('206', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/contact-social', 'GET', '2025-11-12 03:34:55');
INSERT INTO `visitor_logs` VALUES ('207', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/contact-social', 'GET', '2025-11-12 03:36:59');
INSERT INTO `visitor_logs` VALUES ('208', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/contact-social', 'GET', '2025-11-12 04:11:52');
INSERT INTO `visitor_logs` VALUES ('209', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/contact-social', 'GET', '2025-11-12 04:11:54');
INSERT INTO `visitor_logs` VALUES ('210', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-11-12 04:11:58');
INSERT INTO `visitor_logs` VALUES ('211', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-14 06:48:12');
INSERT INTO `visitor_logs` VALUES ('212', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-14 06:48:36');
INSERT INTO `visitor_logs` VALUES ('213', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 06:49:11');
INSERT INTO `visitor_logs` VALUES ('214', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/login', 'GET', '2025-11-14 06:49:24');
INSERT INTO `visitor_logs` VALUES ('215', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders/create', 'GET', '2025-11-14 07:19:44');
INSERT INTO `visitor_logs` VALUES ('216', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 07:20:10');
INSERT INTO `visitor_logs` VALUES ('217', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', 'http://127.0.0.1:8000/about', 'GET', '2025-11-14 07:20:19');
INSERT INTO `visitor_logs` VALUES ('218', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-14 07:20:24');
INSERT INTO `visitor_logs` VALUES ('219', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-14 07:25:52');
INSERT INTO `visitor_logs` VALUES ('220', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-14 07:25:59');
INSERT INTO `visitor_logs` VALUES ('221', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-14 07:26:00');
INSERT INTO `visitor_logs` VALUES ('222', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-14 07:26:10');
INSERT INTO `visitor_logs` VALUES ('223', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-14 08:19:08');
INSERT INTO `visitor_logs` VALUES ('224', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 08:19:15');
INSERT INTO `visitor_logs` VALUES ('225', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 08:20:14');
INSERT INTO `visitor_logs` VALUES ('226', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 08:24:06');
INSERT INTO `visitor_logs` VALUES ('227', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 08:26:22');
INSERT INTO `visitor_logs` VALUES ('228', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 08:26:24');
INSERT INTO `visitor_logs` VALUES ('229', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 08:26:32');
INSERT INTO `visitor_logs` VALUES ('230', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 08:28:50');
INSERT INTO `visitor_logs` VALUES ('231', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 08:30:51');
INSERT INTO `visitor_logs` VALUES ('232', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 08:31:00');
INSERT INTO `visitor_logs` VALUES ('233', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-14 08:34:28');
INSERT INTO `visitor_logs` VALUES ('234', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-14 08:36:14');
INSERT INTO `visitor_logs` VALUES ('235', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/dashboard', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 08:36:20');
INSERT INTO `visitor_logs` VALUES ('236', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/home-sliders', 'GET', '2025-11-14 08:41:02');
INSERT INTO `visitor_logs` VALUES ('237', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 08:41:07');
INSERT INTO `visitor_logs` VALUES ('238', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-14 08:41:14');
INSERT INTO `visitor_logs` VALUES ('239', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/competencies', 'GET', '2025-11-14 08:54:41');
INSERT INTO `visitor_logs` VALUES ('240', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/', 'GET', '2025-11-14 08:54:50');
INSERT INTO `visitor_logs` VALUES ('241', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-18 03:18:09');
INSERT INTO `visitor_logs` VALUES ('242', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-18 03:20:58');
INSERT INTO `visitor_logs` VALUES ('243', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 03:21:46');
INSERT INTO `visitor_logs` VALUES ('244', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 03:22:58');
INSERT INTO `visitor_logs` VALUES ('245', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 03:24:25');
INSERT INTO `visitor_logs` VALUES ('246', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/', 'GET', '2025-11-18 03:24:54');
INSERT INTO `visitor_logs` VALUES ('247', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/', 'GET', '2025-11-18 03:25:12');
INSERT INTO `visitor_logs` VALUES ('248', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-18 03:25:27');
INSERT INTO `visitor_logs` VALUES ('249', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', 'http://127.0.0.1:8000/', 'GET', '2025-11-18 03:25:49');
INSERT INTO `visitor_logs` VALUES ('250', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/about', 'GET', '2025-11-18 03:26:17');
INSERT INTO `visitor_logs` VALUES ('251', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-18 03:26:51');
INSERT INTO `visitor_logs` VALUES ('252', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/contact', 'GET', '2025-11-18 03:27:30');
INSERT INTO `visitor_logs` VALUES ('253', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-18 03:28:18');
INSERT INTO `visitor_logs` VALUES ('254', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-18 03:40:33');
INSERT INTO `visitor_logs` VALUES ('255', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-18 03:40:46');
INSERT INTO `visitor_logs` VALUES ('256', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-18 03:42:19');
INSERT INTO `visitor_logs` VALUES ('257', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-18 03:42:22');
INSERT INTO `visitor_logs` VALUES ('258', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-18 03:42:25');
INSERT INTO `visitor_logs` VALUES ('259', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-18 03:42:27');
INSERT INTO `visitor_logs` VALUES ('260', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-18 03:45:39');
INSERT INTO `visitor_logs` VALUES ('261', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-18 03:51:50');
INSERT INTO `visitor_logs` VALUES ('262', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-11-18 03:52:17');
INSERT INTO `visitor_logs` VALUES ('263', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-11-18 03:53:32');
INSERT INTO `visitor_logs` VALUES ('264', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-11-18 03:59:42');
INSERT INTO `visitor_logs` VALUES ('265', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-11-18 04:02:55');
INSERT INTO `visitor_logs` VALUES ('266', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-18 04:03:41');
INSERT INTO `visitor_logs` VALUES ('267', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-18 07:26:31');
INSERT INTO `visitor_logs` VALUES ('268', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 07:26:47');
INSERT INTO `visitor_logs` VALUES ('269', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/admin/settings/school-content', 'GET', '2025-11-18 07:28:19');
INSERT INTO `visitor_logs` VALUES ('270', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 07:29:58');
INSERT INTO `visitor_logs` VALUES ('271', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 07:37:32');
INSERT INTO `visitor_logs` VALUES ('272', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-18 07:39:18');
INSERT INTO `visitor_logs` VALUES ('273', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-kendaraan-ringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-18 07:39:25');
INSERT INTO `visitor_logs` VALUES ('274', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies/teknik-kendaraan-ringan', 'GET', '2025-11-18 07:39:31');
INSERT INTO `visitor_logs` VALUES ('275', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-18 07:39:38');
INSERT INTO `visitor_logs` VALUES ('276', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-18 07:52:20');
INSERT INTO `visitor_logs` VALUES ('277', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-22 07:03:26');
INSERT INTO `visitor_logs` VALUES ('278', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', NULL, 'GET', '2025-11-22 07:04:06');
INSERT INTO `visitor_logs` VALUES ('279', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-11-22 07:04:23');
INSERT INTO `visitor_logs` VALUES ('280', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/ppdb/register', 'http://127.0.0.1:8000/', 'GET', '2025-11-22 07:04:25');
INSERT INTO `visitor_logs` VALUES ('281', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/ppdb/register', 'GET', '2025-11-22 07:04:34');
INSERT INTO `visitor_logs` VALUES ('282', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies', 'http://127.0.0.1:8000/', 'GET', '2025-11-22 07:05:23');
INSERT INTO `visitor_logs` VALUES ('283', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'http://127.0.0.1:8000/competencies', 'GET', '2025-11-22 07:05:27');
INSERT INTO `visitor_logs` VALUES ('284', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/overview', 'http://127.0.0.1:8000/competencies/teknik-komputer-jaringan', 'GET', '2025-11-22 07:05:53');
INSERT INTO `visitor_logs` VALUES ('285', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/principal-message', 'http://127.0.0.1:8000/overview', 'GET', '2025-11-22 07:06:00');
INSERT INTO `visitor_logs` VALUES ('286', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'http://127.0.0.1:8000/principal-message', 'GET', '2025-11-22 07:06:15');
INSERT INTO `visitor_logs` VALUES ('287', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'http://127.0.0.1:8000/', 'GET', '2025-11-22 07:06:59');
