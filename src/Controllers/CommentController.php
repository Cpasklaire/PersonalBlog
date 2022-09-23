<?php

namespace App\Controllers;

use App\Models\CommentModel;

class CommentController extends BaseController
{

    //create new comment
    public function createComment($commentId)
    {
        $request = new \App\Request();
        $method = $request->server['REQUEST_METHOD'];

        if ($method === 'POST') {
            $request = new \App\Request();
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
                    return $request->redirect('/articles/' . $postId);
                }
                
                return $request->redirect('/error');
            }
        }
    }

    //show comments not validate
    public function showComments()
    {
            $commentModel = new CommentModel();
            $comments = $commentModel->getNotEnabledComments();
            $this->render('./admin/noValidComment.html.twig', ['comments' => $comments]);
    }

    //valid a comment
    public function validate($commentId)
    {
        $request = new \App\Request();
        $commentModel = new CommentModel();
        $success = $commentModel->validateComment($commentId);
        if ($success) {
            return $request->redirect('/admin/commentaires');
        }
        return $request->redirect('/error');
    }
}
