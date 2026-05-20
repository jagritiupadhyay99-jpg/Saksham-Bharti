CREATE DATABASE IF NOT EXISTS saksham_db;
USE saksham_db;

CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS volunteers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    interest VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Default admin user: admin / Saksham@Secure#2026
INSERT INTO admins (username, password) 
VALUES ('admin', '$2y$10$PrVAqBoClRLybIAAy76RbeaOBz6jymN4gr/RtayUo8xCFkM0Uc/yO') 
ON DUPLICATE KEY UPDATE username=username;

CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_email VARCHAR(255) NOT NULL,
    contact_phone VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    notification_email VARCHAR(255) NOT NULL,
    facebook_url VARCHAR(255),
    twitter_url VARCHAR(255),
    instagram_url VARCHAR(255),
    linkedin_url VARCHAR(255),
    auto_reply_emails TINYINT(1) NOT NULL DEFAULT 1,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Default site settings
INSERT INTO site_settings (id, contact_email, contact_phone, address, notification_email, facebook_url, twitter_url, instagram_url, linkedin_url)
VALUES (
    1,
    'info@sakshambharti.org',
    '+91 98765 43210',
    'E-36/13, UG Floor, Rajouri Garden, New Delhi-110027',
    'admin@sakshambharti.org',
    'https://www.facebook.com/ngosakshambharti/',
    'https://x.com/bhartisaksham',
    'https://www.instagram.com/ngosakshambharti/',
    'https://in.linkedin.com/in/sakshambharti'
) ON DUPLICATE KEY UPDATE id=id;

-- Blogs table (managed separately from activities)
CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Programs table
CREATE TABLE IF NOT EXISTS programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(100) DEFAULT 'fas fa-star',
    image VARCHAR(255) NOT NULL,
    features TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add read_status to contacts for admin read/unread tracking
ALTER TABLE contacts ADD COLUMN IF NOT EXISTS read_status TINYINT(1) NOT NULL DEFAULT 0;
