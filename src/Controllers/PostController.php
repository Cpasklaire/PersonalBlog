<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;

class PostController extends BaseController
{

    //show all posts
    public function list()
    {
        $postModel = new PostModel();
        $posts = $postModel->getPosts();

        $this->render('./postPage.html.twig', ['posts' => $posts]);
    }
    public function listAdmin()
    {
        $request = new RequestController();
        $userId = $request->session['userId'];
        $admin = $request->session['admin'];
        if (!$userId) {
            header('Location: /login');
        } elseif ($admin == 0) {
            header('Location: /');
        } else {
            $postModel = new PostModel();
            $posts = $postModel->getPosts();
            $this->render('./admin/postPage.html.twig', ['posts' => $posts]);
        }
    }

    //show One post
    public function show($postId)
    {

        $postModel = new PostModel();
        $commentModel = new CommentModel();

        $post = $postModel->getOnePost($postId);
        $comments = $commentModel->getAllComments($postId);

        $this->render('./postOnePage.html.twig', ['post' => $post], ['comments' => $comments]);
    }
    public function showAdmin($postId)
    {
        $request = new RequestController();
        $userId = $request->session['userId'];
        $admin = $request->session['admin'];
        if (!$userId) {
            header('Location: /login');
        } elseif ($admin == 0) {
            header('Location: /');
        } else {
            $postModel = new PostModel();
            $commentModel = new CommentModel();

            $post = $postModel->getOnePostAllComment($postId);
            $comments = $commentModel->getAllComments($postId);

            $this->render('./admin/postOnePage.html.twig', ['post' => $post], ['comments' => $comments]);
        }
    }

    //create post
    public function create()
    {
        $request = new RequestController();
        $userId = $request->session['userId'];
        $admin = $request->session['admin'];
        if (!$userId) {
            header('Location: /login');
        } elseif ($admin == 0) {
            header('Location: /');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $request = new RequestController();
                $title = $request->post['title'];
                $chapo = $request->post['chapo'];
                $content = $request->post['content'];

                if (isset($title) && isset($chapo) && isset($content)) {
                    
                    $userId = $request->session['userId'];
                    $author = $request->session['pseudo'];

                    $postModel = new PostModel();
                    $success = $postModel->createPost($userId, $title, $chapo, $content, $author);

                    if ($success) {
                        header('Location: /admin');
                    } else {
                        header('Location: /admin/createPost?error=fail_creation');
                    }
                } else {
                    header('Location: /admin/createPost?error=invalid_form');
                }
            } else {
                return $this->render('./admin/createPost.html.twig');
            }
        }
    }

    //modify post
    public function modify($postId)
    {
        $request = new RequestController();
        $userId = $request->session['userId'];
        $admin = $request->session['admin'];
        if (!$userId) {
            header('Location: /login');
        } elseif ($admin == 0) {
            header('Location: /');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $request = new RequestController();
                $title = $request->post['title'];
                $chapo = $request->post['chapo'];
                $content = $request->post['content'];

                if (isset($title) && isset($chapo) && isset($content)) {

                    $postModel = new PostModel();
                    $success = $postModel->putPost($title, $chapo, $content, $postId);

                    if ($success) {
                        header('Location: /admin');
                    } else {
                        //l'article n'as pas pu étre modifier
                        header('Location: /admin/modify/:postId');
                    }
                } else {
                    //formulaire incomplet
                    header('Location: /admin/modify/:postId');
                }
            } else {
                $postModel = new PostModel();
                $post = $postModel->getOnePost($postId);
                $this->render('./admin/modify.html.twig', ['post' => $post]);
            }
        }
    }

    //delete post
    public function delete($postId)
    {
        $request = new RequestController();
        $userId = $request->session['userId'];
        $admin = $request->session['admin'];
        if (!$userId) {
            header('Location: /login');
        } elseif ($admin == 0) {
            header('Location: /');
        } else {
            $postModel = new PostModel();
            $success = $postModel->deletePost($postId);

            if ($success) {
                header('Location: /admin');
            } else {
                header('Location: /admin?error=fail_delete');
            }
        }
    }
}
