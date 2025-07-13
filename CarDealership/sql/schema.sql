CREATE DATABASE CarDealership;
USE CarDealership;

CREATE TABLE manufacturers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    country VARCHAR(100),
    founded_year INT
);

CREATE TABLE cars (
    id INT PRIMARY KEY AUTO_INCREMENT,
    manufacturer_id INT NOT NULL,
    model VARCHAR(100) NOT NULL,
    year INT NOT NULL,
    price DECIMAL(10, 2),
    stock INT,
    FOREIGN KEY (manufacturer_id) REFERENCES manufacturers(id)
);

CREATE TABLE customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255)
);

CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    car_id INT NOT NULL,
    order_date DATE,
    status ENUM('pending', 'completed', 'cancelled'),
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (car_id) REFERENCES cars(id)
);

INSERT INTO manufacturers (name, country, founded_year) VALUES
('Toyota', 'Japan', 1937),
('BMW', 'Germany', 1916),
('Ford', 'USA', 1903);

INSERT INTO cars (manufacturer_id, model, year, price, stock) VALUES
(1, 'Camry', 2023, 25000.00, 10),
(2, 'X5', 2022, 60000.00, 5),
(3, 'Mustang', 2023, 45000.00, 7);

INSERT INTO customers (name, email, phone, address) VALUES
('John Doe', 'john@example.com', '123-456-7890', '123 Elm St'),
('Jane Smith', 'jane@example.com', '987-654-3210', '456 Oak St');

INSERT INTO orders (customer_id, car_id, order_date, status) VALUES
(1, 1, '2025-07-01', 'pending'),
(2, 2, '2025-07-02', 'completed');