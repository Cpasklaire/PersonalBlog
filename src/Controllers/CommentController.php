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
                }
                $userId = $sessionId;
                $author = $request->session['pseudo'];
                
                $commentModel = new CommentModel();
                $success = $commentModel->createComment($userId, $postId, $content, $author);

                if ($success) {
                    return $request->redirect('/articles/' . $commentId);
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
        $request = new RequestController();
        $commentModel = new CommentModel();
        $success = $commentModel->validateComment($commentId);
        if ($success) {
            return $request->redirect('/admin/commentaires');
        }
        return $request->redirect('/error');
    }
}
