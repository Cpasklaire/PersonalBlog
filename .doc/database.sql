Create database blogphp;

use blogphp;

CREATE TABLE Users (
    id INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mdp VARCHAR(100) NOT NULL,
    admin BOOLEAN DEFAULT false,

    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    archivedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Posts (
    id INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    userId INT NOT NULL,
    title VARCHAR(100),
    content LONGTEXT NOT NULL,

    postId INTEGER,
    valided BOOLEAN DEFAULT false,
    author VARCHAR(100),

    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    archivedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (postId) REFERENCES Posts(id),
    FOREIGN KEY (userId) REFERENCES Users(id)
);