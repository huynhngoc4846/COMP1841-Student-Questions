CREATE DATABASE IF NOT EXISTS post_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE post_database;

DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS modules;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(75) NOT NULL,
    user_name VARCHAR(75) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE modules (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL UNIQUE,
    description VARCHAR(500)
) ENGINE=InnoDB;

CREATE TABLE posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    summary VARCHAR(500),
    content TEXT NOT NULL,
    image VARCHAR(255),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id INT UNSIGNED NOT NULL,
    module_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_posts_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,
    CONSTRAINT fk_posts_module FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO users (full_name, user_name, email) VALUES
('Alex Morgan', 'alex.morgan', 'alex@example.com'),
('Sam Taylor', 'sam.taylor', 'sam@example.com'),
('Sophia Williams', 'sophia', 'sophia@example.com');

INSERT INTO modules (name, description) VALUES
('COMP1841 Web Programming 1', 'PHP, PDO and MySQL'),
('COMP1820 Introduction to Computer Science', 'Core programming concepts');

INSERT INTO posts (title, summary, content, user_id, module_id, image) VALUES
('How should PDO prepared statements be used?', 'Question about PDO.', 'How do prepared statements prevent SQL injection?', 1, 1, NULL),
('How can a foreign key prevent orphan records?', 'Question about relationships.', 'How should foreign keys connect users, modules and questions?', 2, 2, NULL),
('hello', 'hiiiii', 'hello how are u', 3, 2, '6a769318c4fa3.png');
