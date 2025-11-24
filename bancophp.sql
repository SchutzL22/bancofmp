-- Passo 1
CREATE DATABASE `Bancophp`;

USE `Bancophp`;

CREATE TABLE `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `tipo_usuario` ENUM('normal', 'admin') NOT NULL DEFAULT 'normal',
  `data_cadastro` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `contas` (
  `id_usuario` INT PRIMARY KEY,
  `saldo` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `transacoes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_usuario_origem` INT NOT NULL,
  `id_usuario_destino` INT NOT NULL,
  `valor` DECIMAL(10, 2) NOT NULL,
  `taxa` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  `metodo` VARCHAR(20) NOT NULL,
  `data` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_usuario_origem`) REFERENCES `usuarios`(`id`),
  FOREIGN KEY (`id_usuario_destino`) REFERENCES `usuarios`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Passo 2
-- Tornar usuário admin
-- admin@gmail.com
-- 123456

UPDATE usuarios 
SET tipo_usuario = 'admin' 
WHERE email = 'admin@gmail.com';
