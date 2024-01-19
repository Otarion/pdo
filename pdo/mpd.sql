-- Création de la base de données
CREATE DATABASE IF NOT EXISTS blog;

-- Utilisation de la base de données
USE blog;

-- Création de la table "categories"
CREATE TABLE IF NOT EXISTS categories (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Création d'entrées dans la table "categories"
INSERT INTO categories (name) VALUES ('Films');
INSERT INTO categories (name) VALUES ('Livres');
INSERT INTO categories (name) VALUES ('Jeux-vidéo');

-- Création de la table "posts"
CREATE TABLE IF NOT EXISTS posts (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(100) NOT NULL,
  body TEXT NOT NULL,
  excerpt VARCHAR(150) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  category_id BIGINT UNSIGNED,
  FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL
);

-- Création d'entrées dans la table "posts"
INSERT INTO posts (title, body, excerpt, category_id) VALUES ('Titre 1', 'Contenu 1', 'Extrait 1', NULL);
INSERT INTO posts (title, body, excerpt, category_id) VALUES ('Titre 2', 'Contenu 2', 'Extrait 2', 1);
INSERT INTO posts (title, body, excerpt, category_id) VALUES ('Titre 3', 'Contenu 3', 'Extrait 3', 2);
INSERT INTO posts (title, body, excerpt, category_id) VALUES ('Titre 4', 'Contenu 4', 'Extrait 4', 2);
INSERT INTO posts (title, body, excerpt, category_id) VALUES ('Titre 5', 'Contenu 5', 'Extrait 5', 1);

-- Création de la table "comments"
CREATE TABLE IF NOT EXISTS comments (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  content VARCHAR(50) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  post_id BIGINT UNSIGNED,
  FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE
);

-- Création d'entrées dans la table "posts"
INSERT INTO comments (content, post_id) VALUES ('Commentaire 1', 2);
INSERT INTO comments (content, post_id) VALUES ('Commentaire 2', 1);
INSERT INTO comments (content, post_id) VALUES ('Commentaire 3', 5);
INSERT INTO comments (content, post_id) VALUES ('Commentaire 4', 4);
INSERT INTO comments (content, post_id) VALUES ('Commentaire 5', 1);
INSERT INTO comments (content, post_id) VALUES ('Commentaire 6', 4);
INSERT INTO comments (content, post_id) VALUES ('Commentaire 7', 3);
INSERT INTO comments (content, post_id) VALUES ('Commentaire 8', 3);
