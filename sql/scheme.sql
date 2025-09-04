CREATE DATABASE IF NOT EXISTS url_compression CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE url_compression;

CREATE TABLE IF NOT EXISTS urls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    original_url VARCHAR(255) NOT NULL UNIQUE,
    short_code VARCHAR(10) NOT NULL UNIQUE,
    created_at DATETIME NOT NULL,
    INDEX idx_short_code (short_code),
    INDEX idx_original_url (original_url)
);