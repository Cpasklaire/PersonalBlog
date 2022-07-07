<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Models\PostModel;
//use App\Models\CommentModel;

class PostController {

    // view all posts
    public function list() {

        $postModel = new PostModel();
        $postModel->connection = new DatabaseConnection();
        $posts = $postModel->getPosts();

        $this->twig->display('postpage.html.twig', compact('posts')); //or ['posts'->$posts]
    }

    // view One post
    public function show($id) {

        $postModel = new PostModel();
        //$commentModel = new CommentModel();
        
        $postModel->connection = new DatabaseConnection();
        //$commentModel->connection = new DatabaseConnection();

        $post = $postModel->getOnePost($id);
        //$comments = $commentModel->getComments($id);

        require('templates/postOnePage.php');

    }
    
}