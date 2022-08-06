<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Models\CommentModel;

class CommentController extends BaseController {

    //create new comment

    public function createComment(string $id, string $userId) {

        $content = $_POST['content'];

        $commentModel = new CommentModel();
        $commentModel->connection = new DatabaseConnection();
        
        $success = $commentModel->createComment($id, $userId, $content);

        if($success) {
            header('Location: /articles/' . $id);
        } else {
            echo "pas ok";
        } 
        
    }
    
    //modify one comment

    public function update(string $id, string $commentId) {
        
        $content = $_POST['modifyContent'];
        
        $commentModel = new CommentModel();
        $commentModel->connection = new DatabaseConnection();
        
        $success = $commentModel->putComment($commentId, $content);
    
        if($success) {
            header('Location: /articles/' . $id);
        } else {
            echo "pas ok";
        } 

    }
    
    //delete one comment

    public function delete(string $id, string $commentId) {
                
        $commentModel = new CommentModel();
        $commentModel->connection = new DatabaseConnection();
        
        $success = $commentModel->deleteComment($commentId, $content);
    
        if($success) {
            header('Location: /articles/' . $id);
        } else {
            echo "pas ok";
        } 

    }

}