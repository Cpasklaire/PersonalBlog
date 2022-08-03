<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Models\PostModel;
use App\Models\CommentModel;

class PostController extends BaseController {
    

     // view all posts
    public function list() {
        $postModel = new PostModel();
        $postModel->connection = new DatabaseConnection();
        $posts = $postModel->getPosts();
        echo $this->twig->render('./postPage.html.twig', ['posts' => $posts]);  	
    }

    // view One post
    public function show($id) {

        $postModel = new PostModel();
        $commentModel = new CommentModel();
        
        $postModel->connection = new DatabaseConnection();
        $commentModel->connection = new DatabaseConnection();

        $post = $postModel->getOnePost($id);
        $comments = $commentModel->getComments($id);

        echo $this->twig->render('./postOnePage.html.twig', ['post' => $post]);  	
        echo $this->twig->render('./postOnePage.html.twig', ['comment' => $comments]); 
    } 
    
}