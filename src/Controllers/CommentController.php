<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\PostModel;

class CommentController extends BaseController
{

    //create new comment
    public function createComment($commentId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['content'])) {

                $content = $_POST['content'];
                $postId = $commentId;

                if (!$_SESSION['userId']) {
                    $userId = 42;
                    $author = 'Anonyme';
                } else {
                    $userId = $_SESSION['userId'];
                    $author = $_SESSION['pseudo'];
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
        $userId = $_SESSION['userId'];
        $admin = $_SESSION['admin'];
        if (!$userId) {
            header('Location: /login');
            exit();
        } elseif ($admin == 0) {
            header('Location: /');
            exit();
        } else {
            $commentModel = new CommentModel();
            $comments = $commentModel->getNotEnabledComments();
            $this->twig->render('./admin/noValidComment.html.twig', ['comments' => $comments]);
        }
    }

    //valid a comment
    public function validate($commentId)
    {
        $userId = $_SESSION['userId'];
        $admin = $_SESSION['admin'];
        if (!$userId) {
            header('Location: /login');
            exit();
        } elseif ($admin == 0) {
            header('Location: /');
            exit();
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
