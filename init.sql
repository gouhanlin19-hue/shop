DROP DATABASE IF EXISTS shop_db;
CREATE DATABASE shop_db;
USE shop_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user'
);

CREATE TABLE sellers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    seller_id INT,
    FOREIGN KEY (seller_id) REFERENCES sellers(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@test.com', '123456', 'admin'),
('user1', 'user1@test.com', '123456', 'user');

INSERT INTO sellers (name, description) VALUES
('Nike', 'Sports brand'),
('Apple', 'Tech company');

INSERT INTO products (name, price, description, image, seller_id) VALUES
('Running Shoes', 99.99, 'Comfortable running shoes', 'shoes.jpg', 1),
('iPhone', 999.99, 'Latest smartphone', 'iphone.jpg', 2);