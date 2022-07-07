<?php

namespace App\Models;

use App\Lib\DatabaseConnection;

class Post {
    public string $id;
    public string $userId;
    public string $title;
    public string $text;
    public string $imageURL;
    public string $updatedAt;
}

class PostModel {

    public DatabaseConnection $connection;
    
    // view all posts
    public function getPosts(): array {
        
        $statement = $this->connection->getConnection()->query(
            "SELECT id, userId, title, text, imageURL, DATE_FORMAT(updatedAt, '%d/%m/%Y à %H:%i:%s') AS updatedAt  FROM Post ORDER BY createdAt DESC"
        );

        $posts = [];

        while(($row = $statement->fetch())) {

            $post = new Post();
            $post->id = $row['id'];
            $post->userId = $row['userId'];
            $post->title = $row['title'];
            $post->text = $row['text'];
            $post->imageURL = $row['imageURL'];
            $post->updatedAt = $row['updatedAt'];

            $posts[] = $post;

        }

        return $posts;

    }

    // view One post
    public function getOnePost($postId): Post {

        $statement = $this->connection->getConnection()->query(
            "SELECT id, userId, title, text, imageURL, DATE_FORMAT(updatedAt, '%d/%m/%Y à %H:%i:%s') AS updatedAt  FROM Post WHERE id = $postId"
        );

        $data = $statement->fetch();

        if(!is_array($data)) {
            return header('Location: /personalblog/'); 
        }

        $post = new Post();

        $post->id = $postId;
        $post->userId = $data['userId'];
        $post->title = $data['title'];
        $post->text = $data['text'];
        $post->imageURL = $data['imageURL'];
        $post->updatedAt = $data['updatedAt'];

        return $post;

    }

    //creat post
    public function createPost(string $title, string $imageURL, string $userId, string $text): bool  {

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO posts(title, text, imageURL, userId, createdAt, updatedAt) VALUES (?, ?, ?, ?, NOW(), NOW())"
        );

        $affectedLine = $statement->execute([$title, $text, $imageURL, $userId]);

        return ($affectedLine > 0);

    }

    // edit post
    public function putPost(string $title, string $imageURL, string $text, string $userId, $id): bool {

        $statement = $this->connection->getConnection()->prepare(
            "UPDATE posts SET title = ?, imageURL = ?, text = ?, userId = ?, updatedAt = NOW() WHERE id = ?"
        );

        $affectedLine = $statement->execute([$title, $imageURL, $text, $userId, $id]);

        return ($affectedLine > 0);
    }
    
}