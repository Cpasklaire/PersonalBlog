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
        $comments = $commentModel->getComments($id);

        echo $this->twig->render('./postOnePage.html.twig', ['post' => $post], ['comments' => $comments]);
    }  
    
        /*create post*/
        public function create() {

            $userId = $this->getCurrentUserId();
    
            if(
                (isset($_POST['title']) && $_POST['title'] !== "" && preg_match('/^[a-zA-Zé èà]*$/', $_POST['title'])) && 
                (isset($_POST['imageURL']) && $_POST['imageURL'] !== "" && preg_match('/^[a-zA-Zé èà]*$/', $_POST['imageURL'])) && 
                (isset($_POST['content']) && $_POST['content'] !== "" && preg_match("/^[a-zA-Zé èà0-9\s,.'-]{3,}$/", $_POST['content'])) 
            ) {
      
                $title = $_POST['title'];
                $imageURL = $_POST['imageURL'];
                $content = $_POST['content'];
                
                $postModel = new PostModel();
                
                $success = $postModel->createPost($title, $imageURL, $content, $userId);
                
                if($success) {
                    echo $this->twig->render('./adminPage.html.twig');
                } else {
                    echo "pas ok";
                }
                
            } else {
                
                echo $this->twig->render('./CreatModifyPost.html.twig');
            
            }
        }
            /*modify one post*/
    public function modify($id) {

        if(
            (isset($_POST['title']) && $_POST['title'] !== "" && preg_match('/^[a-zA-Zé èà]*$/', $_POST['title'])) && 
            (isset($_POST['imageURL']) && $_POST['imageURL'] !== "" && preg_match('/^[a-zA-Zé èà]*$/', $_POST['imageURL'])) && 
            (isset($_POST['content']) && $_POST['content'] !== "" && preg_match("/^[a-zA-Zé èà0-9\s,.'-]{3,}$/", $_POST['content'])) 
        ) {
 
            $title = $_POST['title'];
            $content = $_POST['content'];
            $imageURL = $_POST['imageURL'];
            
            $postModel = new PostModel();
            
            $success = $postModel->putPost($title, $imageURL, $id, $content);
            
            if($success) {
                echo $this->twig->render('./adminPage.html.twig');
            } else {
                echo "pas ok";
            }
            
        } else {

            echo $this->twig->render('./adminPage.html.twig');
            
        }
    } 
        /*delete one post*/
        public function delete($id) {
            echo "article $id delete et ses commentaires"; 
        }
}