CREATE DATABASE IF NOT EXISTS blog_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE blog_management;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO admins (username, password_hash)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi')
ON DUPLICATE KEY UPDATE username = username;

INSERT INTO blogs (title, content, category, image, created_at) VALUES
('Railway Admit Card 2026 Released', 'The railway recruitment board has released admit cards for the upcoming examination. Candidates can download the admit card from the official portal and must carry a valid ID proof to the exam center.', 'Admit Card', NULL, '2026-05-01 10:30:00'),
('SSC Result Update', 'The staff selection result has been announced for the latest recruitment cycle. Shortlisted candidates should check their roll number and prepare documents for the next stage.', 'Result', NULL, '2026-05-02 14:15:00'),
('Teaching Job Alert for Graduates', 'Applications are open for graduate teaching posts across multiple districts. Candidates should review eligibility, important dates, and application fees before submitting the form.', 'Job Alert', NULL, '2026-05-03 09:00:00'),
('Police Constable Syllabus Overview', 'The syllabus includes general knowledge, reasoning, numerical ability, and state-specific awareness. Candidates should focus on mock tests and previous year questions.', 'Syllabus', NULL, '2026-05-04 16:45:00');
