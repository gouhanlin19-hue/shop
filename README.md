# Online Shop Web Application

## Project Overview

This project is a simple web application developed using PHP and MySQL.  
It allows users to manage products in an online shop system.

The goal of this project is to demonstrate database design, SQL queries, and backend web development concepts.

---

## Database Structure

The database used in this project is called `shop_db`.

It contains the following tables:

### 1. users
- id (Primary Key)
- username (UNIQUE)
- email (UNIQUE)
- password
- role (admin / user)

### 2. sellers
- id (Primary Key)
- name
- description

### 3. products
- id (Primary Key)
- name
- price
- description
- image
- seller_id (Foreign Key → sellers.id)

### 4. orders
- id (Primary Key)
- user_id (Foreign Key → users.id)
- total_price
- created_at

Relationships:
- One seller can have many products (one-to-many)
- One user can have many orders (one-to-many)

---

## Main Features
### User Authentication
- Login and logout system using PHP sessions
- Role-based access control (admin / user)
- Only admin can manage products (add, edit, delete)

### Product Management (CRUD)
- Create: Add new products
- Read: Display product list
- Update: Edit existing products
- Delete: Remove products

### Pagination
- Products are displayed with pagination using LIMIT and OFFSET

### SQL Aggregation
- COUNT → total number of products
- SUM → total price of products
- AVG → average product price
- GROUP BY → number of products per seller

### User Interface
- Simple web pages built with PHP and HTML
- Basic styling with CSS

---

## How to Run the Project

### 1. Start the server
- Open MAMP
- Start Apache and MySQL

### 2. Import the database
- Open phpMyAdmin
- Import the file: sql/init.sql
### 3. Place the project
- Put the project folder inside:

/Applications/MAMP/htdocs/


### 4. Open in browser
- Products page:

http://localhost:8888/shop-project/products.php

- Add product:

http://localhost:8888/shop-project/add_product.php

- Statistics page:

http://localhost:8888/shop-project/statistics.php


---

## Technologies Used

- PHP
- MySQL
- HTML / CSS
- MAMP (local server)

---

## Author

Student project for SQL Database and PHP Web Development.

