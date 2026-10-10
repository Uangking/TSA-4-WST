CREATE DATABASE IF NOT EXISTS pos_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;
USE pos_db;

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at DATETIME NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL
);

INSERT INTO customers (full_name, email, phone, created_at) VALUES
    ('Ariana Santos', 'ariana.santos@example.com', '+63 917 111 2233', '2026-10-03 09:00:00'),
    ('Miguel Reyes', 'miguel.reyes@example.com', '+63 918 222 3344', '2026-10-03 09:05:00'),
    ('Sofia Lim', 'sofia.lim@example.com', '+63 919 333 4455', '2026-10-03 09:10:00'),
    ('Daniel Cruz', 'daniel.cruz@example.com', '+63 920 444 5566', '2026-10-03 09:15:00'),
    ('Liza Mendoza', 'liza.mendoza@example.com', '+63 921 555 6677', '2026-10-03 09:20:00');

INSERT INTO users (username, full_name, created_at) VALUES
    ('admin01', 'Renee Bautista', '2026-10-03 10:00:00'),
    ('mgr_santos', 'Ethan Santos', '2026-10-03 10:05:00'),
    ('cashier_lee', 'Mia Lee', '2026-10-03 10:10:00'),
    ('mgr_fernandez', 'Julian Fernandez', '2026-10-03 10:15:00'),
    ('cashier_vega', 'Kyla Vega', '2026-10-03 10:20:00');