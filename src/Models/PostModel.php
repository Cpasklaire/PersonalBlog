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
    
/*     // view all posts
    public function getPosts(): array {
        
        $statement = $this->connection->getConnection()->query(
            "SELECT id, userId, title, content, imageURL, DATE_FORMAT(updatedAt, '%d/%m/%Y à %H:%i:%s') AS updatedAt  FROM Post ORDER BY createdAt DESC"
        );

        $posts = [];

        while($row = $statement->fetch()) 
        {

            $post = new Post();
            $post->id = $row['id'];
            $post->userId = $row['userId'];
            $post->title = $row['title'];
            $post->content = $row['content'];
            $post->imageURL = $row['imageURL'] ? $row['imageURL'] : '';
            $post->updatedAt = $row['updatedAt'];

            $posts[] = $post;

        }
        return $posts;

    }

    // view One post
    public function getOnePost($postId): Post {

        $statement = $this->connection->getConnection()->query(
            "SELECT id, userId, title, 'text', imageURL, DATE_FORMAT(updatedAt, '%d/%m/%Y à %H:%i:%s') AS updatedAt  FROM Post WHERE id = $postId"
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
        $post->imageURL = $data['imageURL'] ? $row['imageURL'] : '';
        $post->updatedAt = $data['updatedAt'];

        $commentModel = new CommentModel();
        $comments = $commentModel->getComments($post->id);
        $post->comments = $comments;

        return $post;

    }

    //creat post
    public function createPost(string $title, string $imageURL, string $text, string $userId): bool  {

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO posts(title, 'text', imageURL, userId, createdAt, updatedAt) VALUES (?, ?, ?, ?, NOW(), NOW())"
        );

        $affectedLine = $statement->execute([$title, $text, $imageURL, $userId]);

        return ($affectedLine > 0);

    }

    // edit post
    public function putPost(string $title, string $imageURL, string $text): bool {

        $statement = $this->connection->getConnection()->prepare(
            "UPDATE posts SET title = ?, imageURL = ?, 'text' = ?, userId = ?, updatedAt = NOW() WHERE id = ?"
        );

        $affectedLine = $statement->execute([$title, $imageURL, $text, $userId, $id]);

        return ($affectedLine > 0);
    }
 */    
}