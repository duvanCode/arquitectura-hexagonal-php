-- ============================================================
-- CRUD Usuarios — Arquitectura Hexagonal
-- Esquema de base de datos
-- ============================================================

CREATE DATABASE IF NOT EXISTS crud_usuarios
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE crud_usuarios;

CREATE TABLE IF NOT EXISTS users (
    id         VARCHAR(36)  NOT NULL,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    role       VARCHAR(30)  NOT NULL,
    status     VARCHAR(30)  NOT NULL,
    created_at DATETIME     NOT NULL,
    updated_at DATETIME     NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uk_users_email (email)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS movies (
    id                 VARCHAR(36)   NOT NULL,
    nombre             VARCHAR(200)  NOT NULL,
    titulo_original    VARCHAR(200)  NOT NULL,
    director           VARCHAR(150)  NOT NULL,
    genero             VARCHAR(50)   NOT NULL,
    duracion_minutos   INT           NOT NULL,
    fecha_estreno      DATE          NOT NULL,
    pais_origen        VARCHAR(100)  NOT NULL,
    idioma_original    VARCHAR(100)  NOT NULL,
    clasificacion_edad VARCHAR(30)   NOT NULL,
    productora         VARCHAR(200)  NOT NULL,
    sinopsis           TEXT          NOT NULL,
    created_at         DATETIME      NOT NULL,
    updated_at         DATETIME      NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
