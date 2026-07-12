CREATE DATABASE IF NOT EXISTS arabic_hr_crud CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE arabic_hr_crud;

DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','user') DEFAULT 'admin',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE employees (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(50),
  department_id INT NULL,
  hire_date DATE NULL,
  salary DECIMAL(10,2) NULL,
  CONSTRAINT fk_dep FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (username, password_hash, role) VALUES ('admin', '$2b$12$eK7EWt.RV0cQ8XE/mnOvdujamnu3DCmiloMFGJL7Gwy.eIZY4d2Xm', 'admin');

INSERT INTO departments (name) VALUES ('الإدارة'),('المحاسبة'),('الموارد البشرية');

INSERT INTO employees (full_name, email, phone, department_id, hire_date, salary) VALUES
('أحمد علي', 'ahmad@example.com', '0590000001', 1, '2023-01-10', 2500.00),
('سارة يوسف', 'sara@example.com', '0590000002', 2, '2022-11-05', 2800.50);
