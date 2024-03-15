CREATE DATABASE IF NOT EXISTS "your_db_name";

USE "your_db_name";

-- Table pour stocker les informations des membres
CREATE TABLE IF NOT EXISTS espace_membre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    pseudo VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Table pour stocker les articles
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sender INT,
    FOREIGN KEY (sender) REFERENCES espace_membre(id) ON DELETE CASCADE
);

-- Table pour stocker les commentaires
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    article_id INT,
    user_id INT,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES espace_membre(id) ON DELETE CASCADE
);