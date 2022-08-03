<?php

namespace App\Models;

use App\Lib\DatabaseConnection;
use \Ramsey\Uuid\Uuid;

class Comment {
    public string $id ;
    public string $userId;
    public string $content ;
    public string $valided ;
    public string $updatedAt ;
}

class CommentModel {

    public DatabaseConnection $connection;

    //get all comments for one post

    public function getComments($postId): array {

        $statement = $this->connection->getConnection()->query(
            "SELECT Id, userId, content, DATE_FORMAT(updatedAt, '%d/%m/%Y à %H:%i:%s') AS updatedAt_fr FROM comment INNER JOIN user ON comment.userId = users.id WHERE postId = $postId AND valided = 1 ORDER BY creation_date DESC; "
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
            "INSERT INTO comment(Id, postId, userId, content, valided) VALUES (?, ?, ?, ?, 0)"
        );

        $affectedLine = $statement->execute([$newId, $id, $userId, $content]);

        return ($affectedLine > 0);

    }

    //Modify one comment

    public function putComment(string $id,string $content): bool {

        $statement = $this->connection->getConnection()->prepare(
            "UPDATE comment SET content = ?, valided = 0, updatedAt = NOW() WHERE id = ?"
        );

        $affectedLine = $statement->execute([$content, $id]);

        return ($affectedLine > 0);

    }

    //delete one comment 

    public function deleteComment(string $id): bool {

        $statement = $this->connection->getConnection()->prepare(
            "DELETE FROM comments WHERE id = ?"
        );

        $affectedLine = $statement->execute([$id]);

        return ($affectedLine > 0);

    }

    //create a list of not enabled comments

    public function getNotEnabledComments(): array {

        $statement = $this->connection->getConnection()->query(
            "SELECT content, id, postId, FROM comment LEFT JOIN user ON comment.userId = user.id WHERE valided = 0"
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