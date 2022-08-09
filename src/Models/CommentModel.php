<?php

namespace App\Models;

use \Ramsey\Uuid\Uuid;

class Comment {
    public string $id ;
    public string $userId;
    public string $content ;
    public string $valided ;
    public string $updatedAt ;
}

class CommentModel extends BaseModel{

    //get all comments for one post

    public function getComments($postId): array {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM Posts INNER JOIN Users ON Posts.userId = users.id WHERE Posts.postId = $postId AND valided = 1 ORDER BY Posts.createdAt DESC; "
        );

        $comments = [];

        while($row = $statement->fetch()) 
        {
            $comment = new Comment();
            $comment->id = $row['id'];
            $comment->userId = $row['userId'];
            $comment->content = $row['content'];
            $comment->updatedAt = $row['updatedAt'];

            $comments[] = $comment;
        }

        return $comments;
    }
        //create a comment 

        public function createComment(string $id, string $userId, string $content): bool {

            $v4 = Uuid::uuid4();
            $newId = $v4->toString();
    
            $statement = $this->connection->getConnection()->prepare(
                "INSERT INTO posts(id, postId, userId, content, valided) VALUES (?, ?, ?, ?, 0)"
            );
    
            $affectedLine = $statement->execute([$newId, $id, $userId, $content]);
    
            return ($affectedLine > 0);
    
        }

            //delete one comment 

    public function deleteComment(string $id): bool {

        $statement = $this->connection->getConnection()->prepare(
            "DELETE FROM posts WHERE id = ?"
        );

        $affectedLine = $statement->execute([$id]);

        return ($affectedLine > 0);

    }

    //create a list of not enabled comments

    public function getNotEnabledComments(): array {

        $statement = $this->connection->getConnection()->query(
            "SELECT content, id, postId, FROM posts LEFT JOIN users ON posts.userId = users.id WHERE valided = 0"
        );

        $comments = [];

        while(($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->content = $row['content'];
            $comment->id = $row['id'];
            $comment->postId = $row['postId'];

            $comments[] = $comment;
        }

        return $comments;
        
    }

    //valid one comment

    public function validateComment(string $id): bool {

        $statement = $this->connection->getConnection()->prepare(
            "UPDATE comments SET valided = 1 WHERE id = ?"
        );

        $affectedLine = $statement->execute([$id]);

        return ($affectedLine > 0);

    }

}