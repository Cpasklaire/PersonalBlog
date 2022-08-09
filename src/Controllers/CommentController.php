<?php

namespace App\Controllers;

use App\Models\CommentModel;

class CommentController extends BaseController {

    //create new comment

    public function createComment(string $id, string $userId) {

        $content = $_POST['content'];

        $commentModel = new CommentModel();
        
        $success = $commentModel->createComment($id, $userId, $content);

        if($success) {
            header('Location: /articles/' . $id);
        } else {
            echo "pas ok";
        } 
        
    }
    
    //delete one comment

    public function delete(string $id, string $commentId) {
                
        $commentModel = new CommentModel();
        
        $success = $commentModel->deleteComment($commentId);
    
        if($success) {
            header('Location: /articles/' . $id);
        } else {
            echo "pas ok";
        } 

    }

        /* display not validate comments*/
        public function showComments() {

            $commentModel = new CommentModel();
    
            $comments = $commentModel->getNotEnabledComments();
    
            echo $this->twig->render('./postOnePage.html.twig', ['comments' => $comments]); 
    
        }
    
        
        /*valid a comment*/
        public function validate($id) {
    
            $commentModel = new CommentModel();
            
            $success = $commentModel->validateComment($id);
        
            if($success) {
                echo $this->twig->render('./postOnePage.html.twig'); 
            } else {
                echo "pas ok";
            } 
    
        }
}