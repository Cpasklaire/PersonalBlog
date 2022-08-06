<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\CommentModel;

class AdminController extends BaseController{

    /*admin loggin*/
    public function log() {   

        if(
            (isset($_POST['email']) && $_POST['email'] !== "" && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) && 
            (isset($_POST['mdp']) && $_POST['mdp'] !== "") && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $_POST['mdp'])
        ) {
            
            $email = $_POST['email'];
            $mdp = "" . $_POST['mdp'] . "";

            $userModel = new UserModel();
            $userModel->connection = new DatabaseConnection();
    
            $success = $userModel->adminLogin($email, $mdp);
    
            if($success) {
               
                session_start();
                $_SESSION['name'] = "admin";
                $_SESSION['auth'] = "true";
                $_SESSION['userType'] = "admin";

                //echo $this->twig->render('', ['' => $]);  
               
            } else {
                echo $this->twig->render('./home.html.twig');  
            }
            
        } else {
            echo $this->twig->render('./home.html.twig'); 
        }
        
    }

    /*get posts list for admin panel*/
    public function list() {

        $postModel = new PostModel();
        // $postModel->connection = new DatabaseConnection();
        $posts = $postModel->getPosts();

        echo $this->twig->render('./admin/posts.html.twig', ['posts' => $posts]); 

    }

    /*get one post for admin panel*/
    public function show($id) {
        
        $postModel = new PostModel();
        $commentModel = new CommentModel();
        
        $postModel->connection = new DatabaseConnection();
        $commentModel->connection = new DatabaseConnection();

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
            // $postModel->connection = new DatabaseConnection();
            
            $success = $postModel->createPost($title, $imageURL, $content, $userId);
            
            if($success) {
                echo $this->twig->render('./adminPage.html.twig');
            } else {
                echo "pas ok";
            }
            
        } else {
            
            echo $this->twig->render('./adminPage.html.twig');
        
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
            $postModel->connection = new DatabaseConnection();
            
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

    /* display not validate comments*/
    public function showComments() {

        $commentModel = new CommentModel();
        $commentModel->connection = new DatabaseConnection();

        $comments = $commentModel->getNotEnabledComments();

        echo $this->twig->render('./postOnePage.html.twig', ['comments' => $comments]); 

    }

    /*Delete a comment*/
    public function deleteComment($id, $commentId) {
                
        $commentModel = new CommentModel();
        $commentModel->connection = new DatabaseConnection();
        
        $success = $commentModel->deleteComment($commentId, $content);
    
        if($success) {
            echo $this->twig->render('./postPage.html.twig'); 
        } else {
            echo "pas ok";
        } 
        
    }
    
    /*valid a comment*/
    public function validate($id) {

        $commentModel = new CommentModel();
        $commentModel->connection = new DatabaseConnection();
        
        $success = $commentModel->validateComment($id);
    
        if($success) {
            echo $this->twig->render('./postOnePage.html.twig'); 
        } else {
            echo "pas ok";
        } 

    }
}