<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;
use App\Controllers\UserController;

class PostController extends BaseController {
    
     // view all posts
    public function list() {
        $postModel = new PostModel();
        $posts = $postModel->getPosts();
        echo $this->twig->render('./postPage.html.twig', ['posts' => $posts]);	
    }
    
    public function listAdmin() {
        $postModel = new PostModel();
        $posts = $postModel->getPosts();
        echo $this->twig->render('./admin/postPage.html.twig', ['posts' => $posts]);	
    }

     // view One post
    public function show($id) {

        $postModel = new PostModel();
        $commentModel = new CommentModel();

        $post = $postModel->getOnePost($id);
        $comments = $commentModel->getAllComments($id);

        echo $this->twig->render('./postOnePage.html.twig', ['post' => $post], ['comments' => $comments]);
    }  

    public function showAdmin($id) {

        $postModel = new PostModel();
        $commentModel = new CommentModel();

        $post = $postModel->getOnePostAllComment($id);
        $comments = $commentModel->getAllComments($id);

        echo $this->twig->render('./admin/postOnePage.html.twig', ['post' => $post], ['comments' => $comments]);
    } 
    
        /*create post*/
        public function create() {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {  

                if (isset($_POST['title']) && isset($_POST['chapo']) && isset($_POST['content'])) {                
                    
                    $userId = $_SESSION['userId'];
                    $title = $_POST['title'];
                    $chapo = $_POST['chapo'];
                    $content = $_POST['content'];
                    $author = "michel";     
                    
                    $postModel = new PostModel();           
                    $success = $postModel->createPost($userId, $title, $chapo, $content, $author);
                    if($success) {
                        echo 'post créé';
                        header('Location: /admin');
                    } else {
                        header('Location: /admin/createPost');
                    }
               } else {
                    header('Location: /admin/createPost?error=invalid_form');    
                }
             } else {
                return $this->render('./admin/createPost.html.twig');
            }   
        }
            
        
        /*modify one post*/
    public function modify($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  

        if (isset($_POST['title']) && isset($_POST['chapo']) && isset($_POST['content'])) {                

            $title = $_POST['title'];
            $chapo = $_POST['chapo'];
            $content = $_POST['content'];     
            
            $postModel = new PostModel();           
            $success = $postModel->putPost($title, $chapo, $content, $id);
            if($success) {
                echo 'post modifier';
                header('Location: /admin');
            } else {
                header('Location: /admin/modify/:id');
            }
       } else {
            header('Location: /admin/modify/:id');    
        }
    
    } else {
        return $this->render('./admin/modify.html.twig');
    }  
    } 
        /*delete one post*/
        public function delete($id) {
            $postModel = new PostModel();
            $success = $postModel->deletePost($id);
    
            if($success) {
                header('Location: /admin');
            } else {
                echo "pas ok";
            } 
        }
}