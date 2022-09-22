<?php

namespace App\Models;

use APP\Controllers\RequestController;

class Post {
    public string $postId;
    public string $title;
    public string $chapo;
    public string $content;
    public string $author;
    public string $createDate;
    public string $updateDate;

    public function __construct ($row = null) {
        if ($row) {
            $this->postId = $row['id'];
            $this->title = $row['title'];
            $this->chapo = $row['chapo'];
            $this->content = $row['content'];
            $this->author = $row['author'];
            $this->createDate = $row['createdAt'];
            $this->updateDate = $row['updatedAt'];
        }
    }
}

class PostModel extends BaseModel {

    // view all posts
    public function getPosts(): array {
            
        $statement = $this->connection->getConnection()->query(
            " SELECT * FROM Posts WHERE ISNULL(postId) ORDER BY updatedAt DESC"
        );

        $posts = [];

        while($row = $statement->fetch()) {
            $post = new Post($row);
            $posts[] = $post;
        }
        return $posts;
    }

    // view One post
    public function getOnePost($postId): Post {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM Posts WHERE id = $postId"
        );

        $data = $statement->fetch();
        
        if(!is_array($data)) {
            $request = new \App\Request();
            return $request->redirect('/error');
        }
        $post = new Post($data);
        $post->postId = $postId;

        $commentModel = new CommentModel();
        $comments = $commentModel->getComments($post->postId);
        $post->comments = $comments;

        return $post;
    }

    // view One post and full comments
    public function getOnePostAllComment($postId): Post {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM Posts WHERE id = $postId"
        );

        $data = $statement->fetch();
        
        if(!is_array($data)) {
            $request = new \App\Request();
            return $request->redirect('/error');
        }
        $post = new Post($data);
        $post->postId = $postId;

        $commentModel = new CommentModel();
        $comments = $commentModel->getAllComments($post->postId);
        $post->comments = $comments;

        return $post;
    }

    //creat post
    public function createPost(string $userId, string $title, string $chapo, string $content, string $author): bool{

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO Posts(userId, title, chapo, content, author, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, NOW(), NOW())"
        );

        $affectedLine = $statement->execute([$userId, $title, $chapo, $content, $author]);
        return ($affectedLine > 0);
    }

    // edit post
    public function putPost(string $title, string $content, string $chapo, $postId): bool {

        $statement = $this->connection->getConnection()->prepare(
            "UPDATE posts SET title = ?,  content = ?,  chapo = ?, updatedAt = NOW() WHERE id = ?"
        );

        $affectedLine = $statement->execute([$title, $content, $chapo, $postId]);
        return ($affectedLine > 0);
    }
    
    //delete post 

    public function deletePost($postId): bool {

        $statement = $this->connection->getConnection()->prepare(
            "DELETE FROM posts WHERE id = ?"
        );

        $affectedLine = $statement->execute([$postId]);
        return ($affectedLine > 0);
    }
}