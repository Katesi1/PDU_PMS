-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 08:30 PM
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
-- Database: `pdu_pms_db`
--
DROP DATABASE IF EXISTS `pdu_pms_db`;
CREATE DATABASE IF NOT EXISTS `pdu_pms_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pdu_pms_db`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL,
  `class_code` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `full_name`, `email`, `password`, `role`, `class_code`, `created_at`) VALUES
('admin', 'Nguyễn Văn Hưng', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '', CURRENT_TIMESTAMP),
('admin1', 'Trần Minh Quân', 'admin1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, CURRENT_TIMESTAMP),
('teacher1', 'Phạm Thị Hồng', 'teacher1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, CURRENT_TIMESTAMP),
('teacher2', 'Hoàng Văn Dũng', 'teacher2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, CURRENT_TIMESTAMP),
('teacher3', 'Vũ Thanh Tùng', 'teacher3@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, CURRENT_TIMESTAMP),
('student1', 'Nguyễn Thị Lan', 'student1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'CNTT01', CURRENT_TIMESTAMP),
('student2', 'Bùi Ngọc Huy', 'student2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'CNTT01', CURRENT_TIMESTAMP),
('student3', 'Ngô Minh Khôi', 'student3@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'CNTT02', CURRENT_TIMESTAMP),
('student4', 'Dương Thị Hạnh', 'student4@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'CNTT02', CURRENT_TIMESTAMP),
('teacher4', 'Trần Quốc Hưng', 'teacher4@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, CURRENT_TIMESTAMP);

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`name`, `description`, `created_at`) VALUES
('Phòng lý thuyết', 'Phòng học thông thường', CURRENT_TIMESTAMP),
('Phòng máy tính', 'Phòng thực hành máy tính', CURRENT_TIMESTAMP),
('Phòng đồ họa', 'Phòng thực hành thiết kế đồ họa', CURRENT_TIMESTAMP),
('Phòng thí nghiệm', 'Phòng thực hành thí nghiệm', CURRENT_TIMESTAMP),
('Phòng hội thảo', 'Phòng tổ chức hội thảo, seminar', CURRENT_TIMESTAMP),
('Phòng máy tính', 'Gồm 45 máy tính', CURRENT_TIMESTAMP),
('Phòng gym', 'Phòng tập thể thao', CURRENT_TIMESTAMP),
('Phòng dự án', 'Phòng làm việc nhóm dự án', CURRENT_TIMESTAMP),
('Phòng trình bày', 'Phòng trình bày kết quả', CURRENT_TIMESTAMP),
('Phòng đa năng', 'Phòng phục vụ nhiều mục đích', CURRENT_TIMESTAMP);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `status` enum('trống','đã đặt','bảo trì') DEFAULT 'trống',
  `room_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_type_id` (`room_type_id`),
  CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`name`, `capacity`, `status`, `room_type_id`) VALUES
('Phòng A101', 30, 'trống', 1),
('Phòng A102', 25, 'trống', 1),
('Phòng B201', 40, 'trống', 1),
('Phòng B202', 35, 'đã đặt', 2),
('Phòng C301', 50, 'bảo trì', 2),
('Phòng C302', 45, 'trống', 2),
('Phòng D401', 20, 'trống', 4),
('Phòng D402', 30, 'trống', 4),
('Phòng E501', 25, 'đã đặt', 4),
('Phòng E502', 35, 'trống', 3);

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `maintenance_period` int(11) DEFAULT NULL COMMENT 'Số ngày giữa các lần bảo trì',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`name`, `description`, `maintenance_period`, `created_at`) VALUES
('Máy tính', 'Máy tính để bàn cho sinh viên', 90, CURRENT_TIMESTAMP),
('Máy chiếu', 'Máy chiếu và màn hình', 60, CURRENT_TIMESTAMP),
('Máy in', 'Máy in laser đen trắng', 45, CURRENT_TIMESTAMP),
('Micro', 'Microphone không dây', 30, CURRENT_TIMESTAMP),
('Bảng tương tác', 'Bảng tương tác thông minh', 120, CURRENT_TIMESTAMP),
('Máy quét', 'Máy quét tài liệu', 60, CURRENT_TIMESTAMP),
('Điều hòa', 'Điều hòa nhiệt độ', 180, CURRENT_TIMESTAMP),
('Quạt trần', 'Quạt trần 4 cánh', 365, CURRENT_TIMESTAMP),
('Tủ tài liệu', 'Tủ đựng tài liệu', 0, CURRENT_TIMESTAMP),
('Loa âm thanh', 'Hệ thống loa âm thanh', 90, CURRENT_TIMESTAMP);

-- --------------------------------------------------------

--
-- Table structure for table `room_equipments`
--

CREATE TABLE `room_equipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `last_maintenance` date DEFAULT NULL,
  `next_maintenance` date DEFAULT NULL,
  `status` enum('hoạt động','bảo trì','hỏng') DEFAULT 'hoạt động',
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  KEY `equipment_id` (`equipment_id`),
  CONSTRAINT `room_equipments_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `room_equipments_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_equipments`
--

INSERT INTO `room_equipments` (`room_id`, `equipment_id`, `quantity`, `last_maintenance`, `next_maintenance`, `status`, `notes`) VALUES
(1, 1, 30, CURRENT_DATE - INTERVAL 30 DAY, CURRENT_DATE + INTERVAL 60 DAY, 'hoạt động', 'Máy tính cho sinh viên'),
(1, 2, 1, CURRENT_DATE - INTERVAL 15 DAY, CURRENT_DATE + INTERVAL 45 DAY, 'hoạt động', 'Máy chiếu mới'),
(2, 1, 25, CURRENT_DATE - INTERVAL 45 DAY, CURRENT_DATE + INTERVAL 45 DAY, 'hoạt động', 'Cần cập nhật phần mềm'),
(3, 2, 1, CURRENT_DATE - INTERVAL 30 DAY, CURRENT_DATE + INTERVAL 30 DAY, 'hoạt động', NULL),
(4, 1, 35, CURRENT_DATE - INTERVAL 10 DAY, CURRENT_DATE + INTERVAL 80 DAY, 'hoạt động', NULL),
(5, 3, 1, CURRENT_DATE - INTERVAL 20 DAY, CURRENT_DATE + INTERVAL 25 DAY, 'bảo trì', 'Đang sửa chữa'),
(6, 4, 2, CURRENT_DATE - INTERVAL 15 DAY, CURRENT_DATE + INTERVAL 15 DAY, 'hoạt động', NULL),
(7, 5, 1, CURRENT_DATE - INTERVAL 60 DAY, CURRENT_DATE + INTERVAL 60 DAY, 'hoạt động', 'Mới lắp đặt'),
(8, 1, 30, CURRENT_DATE - INTERVAL 40 DAY, CURRENT_DATE + INTERVAL 50 DAY, 'hoạt động', NULL),
(9, 2, 1, CURRENT_DATE - INTERVAL 50 DAY, CURRENT_DATE + INTERVAL 10 DAY, 'hoạt động', 'Cần thay bóng đèn');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `class_code` varchar(50) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('chờ duyệt','được duyệt','từ chối') DEFAULT 'chờ duyệt',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`),
  CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`room_id`, `teacher_id`, `student_id`, `class_code`, `start_time`, `end_time`, `status`, `created_at`) VALUES
(2, 3, NULL, 'CNTT01', CURRENT_TIMESTAMP + INTERVAL 1 DAY, CURRENT_TIMESTAMP + INTERVAL 1 DAY + INTERVAL 2 HOUR, 'được duyệt', CURRENT_TIMESTAMP),
(2, 3, NULL, 'CNTT01', CURRENT_TIMESTAMP + INTERVAL 2 DAY, CURRENT_TIMESTAMP + INTERVAL 2 DAY + INTERVAL 2 HOUR, 'chờ duyệt', CURRENT_TIMESTAMP),
(3, 4, NULL, 'KTPM01', CURRENT_TIMESTAMP + INTERVAL 3 DAY, CURRENT_TIMESTAMP + INTERVAL 3 DAY + INTERVAL 2 HOUR, 'được duyệt', CURRENT_TIMESTAMP),
(4, NULL, 7, 'KTPM02', CURRENT_TIMESTAMP + INTERVAL 4 DAY, CURRENT_TIMESTAMP + INTERVAL 4 DAY + INTERVAL 2 HOUR, 'từ chối', CURRENT_TIMESTAMP),
(5, 5, NULL, 'CNTT01', CURRENT_TIMESTAMP + INTERVAL 5 DAY, CURRENT_TIMESTAMP + INTERVAL 5 DAY + INTERVAL 2 HOUR, 'được duyệt', CURRENT_TIMESTAMP),
(6, NULL, 8, 'CNTT03', CURRENT_TIMESTAMP + INTERVAL 6 DAY, CURRENT_TIMESTAMP + INTERVAL 6 DAY + INTERVAL 2 HOUR, 'chờ duyệt', CURRENT_TIMESTAMP),
(7, 4, NULL, 'KTPM01', CURRENT_TIMESTAMP + INTERVAL 7 DAY, CURRENT_TIMESTAMP + INTERVAL 7 DAY + INTERVAL 2 HOUR, 'được duyệt', CURRENT_TIMESTAMP),
(8, NULL, 9, 'CNTT02', CURRENT_TIMESTAMP + INTERVAL 8 DAY, CURRENT_TIMESTAMP + INTERVAL 8 DAY + INTERVAL 2 HOUR, 'chờ duyệt', CURRENT_TIMESTAMP),
(9, 3, NULL, 'KTPM02', CURRENT_TIMESTAMP + INTERVAL 9 DAY, CURRENT_TIMESTAMP + INTERVAL 9 DAY + INTERVAL 2 HOUR, 'được duyệt', CURRENT_TIMESTAMP),
(10, NULL, 6, 'CNTT03', CURRENT_TIMESTAMP + INTERVAL 10 DAY, CURRENT_TIMESTAMP + INTERVAL 10 DAY + INTERVAL 2 HOUR, 'từ chối', CURRENT_TIMESTAMP);

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) DEFAULT NULL,
  `class_code` varchar(50) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `participants` int(11) NOT NULL DEFAULT 0,
  `room_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `timetables_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`),
  CONSTRAINT `timetables_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`teacher_id`, `class_code`, `subject`, `start_time`, `end_time`, `participants`, `room_id`) VALUES
(3, 'CNTT01', 'Lập trình C++', CURRENT_TIMESTAMP + INTERVAL 1 DAY, CURRENT_TIMESTAMP + INTERVAL 1 DAY + INTERVAL 2 HOUR, 22, 1),
(3, 'CNTT02', 'Cơ sở dữ liệu', CURRENT_TIMESTAMP + INTERVAL 2 DAY, CURRENT_TIMESTAMP + INTERVAL 2 DAY + INTERVAL 2 HOUR, 20, 2),
(4, 'KTPM01', 'Phân tích thiết kế hệ thống', CURRENT_TIMESTAMP + INTERVAL 3 DAY, CURRENT_TIMESTAMP + INTERVAL 3 DAY + INTERVAL 2 HOUR, 31, 3),
(4, 'KTPM02', 'Lập trình web', CURRENT_TIMESTAMP + INTERVAL 4 DAY, CURRENT_TIMESTAMP + INTERVAL 4 DAY + INTERVAL 2 HOUR, 24, NULL),
(5, 'CNTT01', 'Mạng máy tính', CURRENT_TIMESTAMP + INTERVAL 5 DAY, CURRENT_TIMESTAMP + INTERVAL 5 DAY + INTERVAL 2 HOUR, 32, 10),
(5, 'CNTT03', 'Trí tuệ nhân tạo', CURRENT_TIMESTAMP + INTERVAL 6 DAY, CURRENT_TIMESTAMP + INTERVAL 6 DAY + INTERVAL 2 HOUR, 43, 6),
(3, 'KTPM01', 'Lập trình Java', CURRENT_TIMESTAMP + INTERVAL 7 DAY, CURRENT_TIMESTAMP + INTERVAL 7 DAY + INTERVAL 2 HOUR, 26, 1),
(4, 'CNTT02', 'Hệ điều hành', CURRENT_TIMESTAMP + INTERVAL 8 DAY, CURRENT_TIMESTAMP + INTERVAL 8 DAY + INTERVAL 2 HOUR, 29, NULL),
(3, 'KTPM02', 'Kiểm thử phần mềm', CURRENT_TIMESTAMP + INTERVAL 9 DAY, CURRENT_TIMESTAMP + INTERVAL 9 DAY + INTERVAL 2 HOUR, 24, 1),
(4, 'CNTT03', 'An ninh mạng', CURRENT_TIMESTAMP + INTERVAL 10 DAY, CURRENT_TIMESTAMP + INTERVAL 10 DAY + INTERVAL 2 HOUR, 40, 6);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_requests`
--

CREATE TABLE `maintenance_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `equipment_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `issue_description` text NOT NULL,
  `priority` enum('thấp','trung bình','cao','khẩn cấp') DEFAULT 'trung bình',
  `status` enum('đang chờ','đang xử lý','đã xử lý','từ chối') DEFAULT 'đang chờ',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `maintenance_requests_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `maintenance_requests_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `maintenance_requests_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance_requests`
--

INSERT INTO `maintenance_requests` (`room_id`, `equipment_id`, `user_id`, `issue_description`, `priority`, `status`, `created_at`, `resolved_at`, `admin_notes`) VALUES
(1, 1, 6, 'Máy tính số 5 không khởi động được', 'trung bình', 'đã xử lý', CURRENT_TIMESTAMP - INTERVAL 15 DAY, CURRENT_TIMESTAMP - INTERVAL 14 DAY, 'Đã thay thế ổ cứng'),
(2, 2, 3, 'Máy chiếu hiển thị hình ảnh mờ', 'cao', 'đã xử lý', CURRENT_TIMESTAMP - INTERVAL 10 DAY, CURRENT_TIMESTAMP - INTERVAL 9 DAY, 'Vệ sinh ống kính'),
(3, NULL, 4, 'Điều hòa không hoạt động', 'cao', 'đang xử lý', CURRENT_TIMESTAMP - INTERVAL 3 DAY, NULL, 'Đang chờ thợ sửa chữa'),
(4, 1, 7, 'Máy tính số 12 chạy chậm', 'thấp', 'đang chờ', CURRENT_TIMESTAMP - INTERVAL 2 DAY, NULL, NULL),
(5, 3, 5, 'Máy in kẹt giấy', 'trung bình', 'đã xử lý', CURRENT_TIMESTAMP - INTERVAL 7 DAY, CURRENT_TIMESTAMP - INTERVAL 6 DAY, 'Đã sửa chữa'),
(6, NULL, 3, 'Đèn phòng bị hỏng', 'thấp', 'đã xử lý', CURRENT_TIMESTAMP - INTERVAL 20 DAY, CURRENT_TIMESTAMP - INTERVAL 19 DAY, 'Đã thay bóng đèn'),
(7, 5, 4, 'Bảng tương tác không phản hồi cảm ứng', 'cao', 'đang xử lý', CURRENT_TIMESTAMP - INTERVAL 4 DAY, NULL, 'Chờ linh kiện thay thế'),
(8, 1, 9, 'Bàn phím máy tính bị hỏng', 'thấp', 'đã xử lý', CURRENT_TIMESTAMP - INTERVAL 8 DAY, CURRENT_TIMESTAMP - INTERVAL 7 DAY, 'Đã thay bàn phím mới'),
(9, 2, 3, 'Màn chiếu không hạ xuống được', 'trung bình', 'đang chờ', CURRENT_TIMESTAMP - INTERVAL 1 DAY, NULL, NULL),
(10, 4, 4, 'Micro không có tiếng', 'khẩn cấp', 'đã xử lý', CURRENT_TIMESTAMP - INTERVAL 5 DAY, CURRENT_TIMESTAMP - INTERVAL 4 DAY, 'Thay pin và vệ sinh');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */; 