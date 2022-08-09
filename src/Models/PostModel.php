<?php

namespace App\Models;

class Post {
    public string $postId;
    public string $title;
    public string $content;
    public string $imageURL;
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
        $post->content = $row['content'];
        $post->imageURL = $row['imageURL'] ? $row['imageURL'] : '';
        $post->createDate = $row['createdAt'];
        $post->updateDate = $row['updatedAt'];

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
            return header('Location: /'); 
        }

        $post = new Post();
        $post->id = $postId;
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->imageURL = $data['imageURL'] ? $data['imageURL'] : '';
        $post->createDate = $data['createdAt'];
        $post->updateDate = $data['updatedAt'];

/*         $commentModel = new CommentModel();
        $comments = $commentModel->getComments($post->id);
        $post->comments = $comments; */

        return $post;

    }

        //creat post
        public function createPost(string $title, string $imageURL, string $content, string $userId): bool  {

            $statement = $this->connection->getConnection()->prepare(
                "INSERT INTO posts(userId, title, content, imageURL, postId, createdAt, updatedAt) VALUES (?, ?, ?, ?,NULL, NOW(), NOW())"
            );
    
            $affectedLine = $statement->execute([$userId, $title, $content, $imageURL]);
    
            return ($affectedLine > 0);
    
        }

            // edit post
    public function putPost(string $title, string $imageURL, string $content): bool {

        $statement = $this->connection->getConnection()->prepare(
            "UPDATE posts SET title = ?, imageURL = ?, content = ?, userId = ?, updatedAt = NOW() WHERE id = ?"
        );

        $affectedLine = $statement->execute([$title, $imageURL, $content, $userId, $id]);

        return ($affectedLine > 0);
    }
    
}