CREATE DATABASE business_rating_system;

USE business_rating_system;

CREATE TABLE businesses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  address TEXT,
  phone VARCHAR(20),
  email VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ratings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  business_id INT,
  name VARCHAR(255),
  email VARCHAR(100),
  phone VARCHAR(20),
  rating DECIMAL(3,1),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE CASCADE
);