<?php

namespace App\Controllers;

use App\Models\Article;

class ArticlesController
{
    private array $articles;

    public function index()
    {
        $articlesQuery = query()
            ->select('*')
            ->from('articles')
            ->orderBy('created_at', 'desc')
            ->execute()
            ->fetchAllAssociative();

        $articles = [];

        foreach ($articlesQuery as $article) {
            $articles[] = new Article(
                (int)$article['id'],
                $article['title'],
                $article['content'],
                $article['created_at'],
                $article['likes']
            );
        }

        return require_once __DIR__ . '/../Views/ArticlesIndexView.php';
    }

    public function show(array $vars)
    {
        $articleQuery = query()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', (int)$vars['id'])
            ->execute()
            ->fetchAssociative();

        $article = new Article(
            (int)$articleQuery['id'],
            $articleQuery['title'],
            $articleQuery['content'],
            $articleQuery['created_at'],
            $articleQuery['likes']
        );

        return require_once __DIR__ . '/../Views/ArticlesShowView.php';
    }

    public function like(array $vars)
    {
        $like = (int)$_POST['like'];

        $articleQuery = query()
            ->update('articles')
            ->set("likes", "likes + {$like}")
            ->where('id = :id')
            ->setParameter('id', (int)$vars['id'])
            ->execute();

        header('Location: /');
    }
}