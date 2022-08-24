<?php

namespace App\Models;

class Post {
    public string $postId;
    public string $title;
    public string $chapo;
    public string $content;
    public string $author;
    public string $createDate;
    public string $updateDate;
}

class PostModel extends BaseModel {

// view all posts
public function getPosts(): array {
        
    $statement = $this->connection->getConnection()->query(
        " SELECT * FROM Posts WHERE ISNULL(postId) ORDER BY updatedAt DESC"
    );

    $posts = [];

    while($row = $statement->fetch()) 
    {
        $post = new Post();
        $post->postId = $row['id'];
        $post->title = $row['title'];
        $post->chapo = $row['chapo'];
        $post->content = $row['content'];
        $post->author = $row['author'];
        $post->createDate = $row['createdAt'];
        $post->updateDate = $row['updatedAt'];

        $posts[] = $post;
    }
    return $posts;
}

    // view One post
    public function getOnePost($postId): Post {

        // gerer le cas où le post n'existe pas => 404

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM Posts WHERE id = $postId"
        );
        $data = $statement->fetch();
        if(!is_array($data)) {
            return header('Location: /'); 
        }

        $post = new Post();
        $post->id = $postId;
        $post->title = $data['title'];
        $post->chapo = $data['chapo'];
        $post->content = $data['content'];
        $post->author = $data['author'];
        $post->createDate = $data['createdAt'];
        $post->updateDate = $data['updatedAt'];

        $commentModel = new CommentModel();
        $comments = $commentModel->getComments($post->id);
        $post->comments = $comments;

        return $post;

    }

        // view One post
        public function getOnePostAllComment($postId): Post {

            // gerer le cas où le post n'existe pas => 404
    
            $statement = $this->connection->getConnection()->query(
                "SELECT * FROM Posts WHERE id = $postId"
            );
            $data = $statement->fetch();
            if(!is_array($data)) {
                return header('Location: /'); 
            }
    
            $post = new Post();
            $post->id = $postId;
            $post->title = $data['title'];
            $post->chapo = $data['chapo'];
            $post->content = $data['content'];
            $post->author = $data['author'];
            $post->createDate = $data['createdAt'];
            $post->updateDate = $data['updatedAt'];
    
            $commentModel = new CommentModel();
            $comments = $commentModel->getAllComments($post->id);
            $post->comments = $comments;
    
            return $post;
    
        }

    //creat post
    public function createPost(string $userId, string $title, string $chapo, string $content, string $author): bool  {

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO posts(userId, title, chapo, content, postId, author, createdAt, updatedAt) VALUES (?, ?, ?, ?, NULL, ?, NOW(), NOW())"
        );

        $affectedLine = $statement->execute([$userId, $title, $chapo, $content, $author]);

        return ($affectedLine > 0);

    }

        // edit post
    public function putPost(string $title, string $content, string $author): bool {

        $statement = $this->connection->getConnection()->prepare(
            "UPDATE posts SET title = ?,  content = ?, author = ?, userId = ?, updatedAt = NOW() WHERE id = ?"
        );

        $affectedLine = $statement->execute([$title, $content, $author]);

        return ($affectedLine > 0);
    }
    
}