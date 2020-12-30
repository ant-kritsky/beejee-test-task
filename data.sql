
CREATE TABLE `tasks` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (  `id` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `users` (
  `id` int(7) NOT NULL AUTO_INCREMENT ,
  `name` varchar(250) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `hash` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (  `id` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `users` (`id`, `name`, `email`, `password`, `hash`, `created_at`) VALUES
(1, 'admin', 'admin@delca.ru', '202cb962ac59075b964b07152d234b70', 'MRI94ECrA82tKEPqwjJgXxSjcv7q409v', '2020-11-23 16:59:16');
