CREATE DATABASE IF NOT EXISTS pdu_pms;
USE pdu_pms;

CREATE TABLE IF NOT EXISTS room_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO room_types (name, description) VALUES 
('Phòng lý thuyết', 'Phòng học thông thường'),
('Phòng máy tính', 'Phòng thực hành máy tính'),
('Phòng hội thảo', 'Phòng tổ chức hội thảo, seminar'); 