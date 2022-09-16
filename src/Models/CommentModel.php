<?php

namespace App\Models;

class Comment {
    public string $commentId;
    public string $userId;
    public string $author;
    public string $content;
    public string $valided;
    public string $updatedAt;
}

class CommentModel extends BaseModel{

    //show comments valided for one post
    public function getComments($postId): array {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM Posts INNER JOIN Users ON Posts.userId = users.id WHERE Posts.postId = $postId AND valided = 1 ORDER BY Posts.createdAt DESC; "
        );

        $comments = [];

        while($row = $statement->fetch()) {
            $comment = new Comment();
            // TODO SAM virer le code duploqué comme ca a ete fait dans post
            $comment->commentId = $row['id'];
            $comment->userId = $row['userId'];
            $comment->author = $row['author'];
            $comment->content = $row['content'];
            $comment->updatedAt = $row['updatedAt'];

            $comments[] = $comment;
        }
        return $comments;
    }

    //show all comments for one post
    public function getAllComments($postId): array {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM Posts WHERE Posts.postId = $postId ORDER BY Posts.createdAt DESC; "
        );

        $comments = [];

        while($row = $statement->fetch()) {
            $comment = new Comment();
            // TODO SAM virer le code duploqué comme ca a ete fait dans post
            $comment->commentId = $row['id'];
            $comment->userId = $row['userId'];
            $comment->author = $row['author'];
            $comment->content = $row['content'];
            $comment->valided = $row['valided'];
            $comment->updatedAt = $row['updatedAt'];

            $comments[] = $comment;
        }
        return $comments;
    }

    //create a comment 
    public function createComment(string $userId, string $postId, string $content, string $author): bool {

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO posts(postId, userId, content, author, valided) VALUES (?, ?, ?, ?, 0)"
        );

        $affectedLine = $statement->execute([$postId, $userId, $content, $author]);
        return ($affectedLine > 0);
    }

    //delete one comment 
    public function deleteComment(string $commentId): bool {

        $statement = $this->connection->getConnection()->prepare(
            "DELETE FROM posts WHERE id = ?"
        );

        $affectedLine = $statement->execute([$commentId]);
        return ($affectedLine > 0);
    }

    //create a list of not valided comments
    public function getNotEnabledComments(): array {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM posts WHERE valided = 0 and postId > 1"
        );

        $comments = [];

        while($row = $statement->fetch()) {
            $comment = new Comment();
            // TODO SAM virer le code duploqué comme ca a ete fait dans post
            $comment->commentId = $row['id'];
            $comment->userId = $row['userId'];
            $comment->postId = $row['postId'];
            $comment->author = $row['author'];
            $comment->content = $row['content'];
            $comment->updatedAt = $row['updatedAt'];

            $comments[] = $comment;
        }
        return $comments;
    }

    //valid one comment
    public function validateComment(string $commentId): bool {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE posts SET valided = true WHERE id = ?"
        );
        
        $affectedLine = $statement->execute([$commentId]);
        return ($affectedLine > 0);
    }

}