-- Create Database User for Laravel
-- Run this script on your production server

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS sibm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user (change password!)
CREATE USER IF NOT EXISTS 'sibm_user'@'localhost' IDENTIFIED BY 'Change_This_Password_2026!';

-- Grant all privileges on sibm database
GRANT ALL PRIVILEGES ON sibm.* TO 'sibm_user'@'localhost';

-- Flush privileges
FLUSH PRIVILEGES;

-- Show grants to verify
SHOW GRANTS FOR 'sibm_user'@'localhost';

-- Test connection (optional)
SELECT 'Database user created successfully!' AS status;
