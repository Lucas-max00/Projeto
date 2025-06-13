CREATE DATABASE IF NOT EXISTS curriculo_perfeito;
USE curriculo_perfeito;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS curriculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    titulo VARCHAR(100),
    descricao TEXT,
    experiencias TEXT,
    educacao TEXT,
    habilidades TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS reset_senha_tokens (
   id INT AUTO_INCREMENT PRIMARY KEY,
   usuario_id INT NOT NULL,
   token VARCHAR(255) NOT NULL UNIQUE,
   expiracao DATETIME NOT NULL,
   usado BOOLEAN DEFAULT FALSE,
   FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);