-- ====================================================================
-- SQL Setup untuk InfinityFree (phpMyAdmin)
-- Aplikasi BUTAGI — Buku Tamu Digital SMKN 1 Subang
-- ====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Tabel Admins (untuk login admin)
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Akun Default Admin: username = admin | password = admin123
INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`) 
VALUES (1, 'admin', '$2y$12$lCdpm1DNmaPqkM/YOkA5neXmHq9OIznJ4d0zhFtLwK3SF/KZ/JPFm', NOW(), NOW())
ON DUPLICATE KEY UPDATE `username` = `username`;

-- 2. Tabel Tamu (untuk menyimpan data buku tamu)
CREATE TABLE IF NOT EXISTS `tamu` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `status` enum('instansi','sekolah') NOT NULL,
  `instansi` varchar(150) DEFAULT NULL,
  `asal_sekolah` varchar(150) DEFAULT NULL,
  `ulasan` enum('senang','biasa','sedih') NOT NULL DEFAULT 'senang',
  `foto` varchar(255) NOT NULL,
  `tanda_tangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabel Sessions (opsional jika SESSION_DRIVER=database)
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
