<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;

class PostController extends BaseController {
    
     // view all posts
    public function list() {
        $postModel = new PostModel();
        $posts = $postModel->getPosts();
        echo $this->twig->render('./postPage.html.twig', ['posts' => $posts]);  	
    }

     // view One post
    public function show($id) {

        $postModel = new PostModel();
        $commentModel = new CommentModel();

        $post = $postModel->getOnePost($id);
        $comments = $commentModel->getComments($id);

        echo $this->twig->render('./postOnePage.html.twig', ['post' => $post], ['comments' => $comments]);
    }  
    
}