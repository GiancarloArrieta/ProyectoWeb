-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS sistema_tickets;
USE sistema_tickets;

-- ==========================================================
-- 1. Tabla: roles
-- ==========================================================
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);

-- ==========================================================
-- 2. Tabla: departments
-- ==========================================================
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);

-- ==========================================================
-- 3. Tabla: users
-- ==========================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) NULL,
    role_id INT NOT NULL,
    department_id INT NOT NULL,
    position VARCHAR(100) NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    FOREIGN KEY (department_id) REFERENCES departments(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- ==========================================================
-- 4. Tabla: tickets
-- ==========================================================
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('Pendiente', 'En Progreso', 'Completado', 'Cancelado') DEFAULT 'Pendiente',
    user_id INT NOT NULL, -- Solicitante
    assigned_auxiliar_id INT NULL, -- Auxiliar asignado
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    finished_at DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (assigned_auxiliar_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

-- ==========================================================
-- Datos iniciales opcionales
-- ==========================================================
INSERT INTO roles (name) VALUES ('Administrador'), ('Auxiliar'), ('Usuario');
INSERT INTO departments (name) VALUES ('Sistemas'), ('Recursos Humanos'), ('Finanzas');