-- Vehicle24 Database Schema
CREATE DATABASE IF NOT EXISTS vehicle;
USE vehicles24;

-- Users table
CREATE TABLE tb_user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phonenumber VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Vehicles table
CREATE TABLE sell_vehicles (
    vehicle_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    buyer_id INT NULL,
    vehicle_type VARCHAR(50) NOT NULL,
    make VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    year VARCHAR(255) NOT NULL,
    vehicle_number VARCHAR(255) NOT NULL,
    color VARCHAR(255) NOT NULL,
    kms_driven VARCHAR(255) NOT NULL,
    condition_rating VARCHAR(255) NOT NULL,
    gear_type VARCHAR(255) NOT NULL,
    owners VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    fuel_type VARCHAR(255) NOT NULL,
    price VARCHAR(255) NOT NULL,
    insurance_valid VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    status ENUM('available', 'sold') DEFAULT 'available',
    listed_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sold_on TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES tb_user(id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id) REFERENCES tb_user(id) ON DELETE SET NULL
);

-- Scrap vehicles table
CREATE TABLE scrap_vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    vehicle_type VARCHAR(50) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    year VARCHAR(10) NOT NULL,
    vehicle_number VARCHAR(50) NOT NULL,
    kms_driven VARCHAR(50) NOT NULL,
    state VARCHAR(100) NOT NULL,
    fuel_type VARCHAR(50) NOT NULL,
    vehicle_condition VARCHAR(50) NOT NULL,
    scrap_value DECIMAL(10,2) NOT NULL,
    reason TEXT,
    image VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES tb_user(id) ON DELETE CASCADE
);

-- Insert sample data
INSERT INTO tb_user (fullname, username, email, phonenumber, password) VALUES
('John Doe', 'johndoe', 'john@example.com', '1234567890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');