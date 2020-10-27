<?php

namespace App\Controllers;

use App\Models\Article;

class CommentsController
{
    public function store(array $vars)
    {
        $articleId = (int)$vars['id'];

        if (!empty($_POST['name']) && !empty($_POST['comment'])) {
            $commentQuery = query()
                ->insert('comments')
                ->values([
                    'article_id' => '?',
                    'name' => '?',
                    'comment' => '?'
                ])
                ->setParameter(0, $articleId)
                ->setParameter(1, $_POST['name'])
                ->setParameter(2, $_POST['comment']);

            $commentQuery->execute();
        }

        header('Location: /articles/' . $articleId);
    }

    public function delete(array $vars)
    {
        $articleId = (int)$vars['id'];
        $commentId = (int)$_POST['id'];

        query()
            ->delete('comments')
            ->where('id = :id')
            ->setParameter('id', $commentId)
            ->execute();

        header('Location: /articles/' . $articleId);
    }
}