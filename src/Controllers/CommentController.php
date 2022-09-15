<?php

namespace App\Controllers;

use App\Models\CommentModel;

class CommentController extends BaseController
{

    //create new comment
    public function createComment($commentId)
    {
        $request = new RequestController();
        $method = $request->server['REQUEST_METHOD'];

        if ($method === 'POST') {
            $content = $request->post['content'];
            $sessionId = $request->session['userId'];

            if (isset($content)) {

                $postId = $commentId;

                if (!$sessionId) {
                    $userId = 42;
                    $author = 'Anonyme';
                } else {
                    $userId = $sessionId;
                    $author = $request->session['pseudo'];
                }

                $commentModel = new CommentModel();
                $success = $commentModel->createComment($userId, $postId, $content, $author);

                if ($success) {
                    header('Location: /articles/' . $commentId);
                } else {
                    header('Location: /articles?error=fail_creation');
                }
            }
        }
    }

    //show comments not validate
    public function showComments()
    {
        $request = new RequestController();
        $userId = $request->session['userId'];
        $admin = $request->session['admin'];
        if (!$userId) {
            header('Location: /login');
        } elseif ($admin == 0) {
            header('Location: /');
        } else {
            $commentModel = new CommentModel();
            $comments = $commentModel->getNotEnabledComments();
            $this->twig->render('./admin/noValidComment.html.twig', ['comments' => $comments]);
        }
    }

    //valid a comment
    public function validate($commentId)
    {
        $request = new RequestController();
        $userId = $request->session['userId'];
        $admin = $request->session['admin'];
        if (!$userId) {
            header('Location: /login');
        } elseif ($admin == 0) {
            header('Location: /');
        } else {
            $commentModel = new CommentModel();
            $success = $commentModel->validateComment($commentId);
            if ($success) {
                header('Location: /admin/commentaires');
            } else {
                header('Location: /admin/commentaires?error=validate');
            }
        }
    }
}
