<?php

namespace App\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;

class ArticlesController
{
    private array $articles;

    public function index()
    {
        $articleTagQuery = query()
            ->select('*')
            ->from('article_tag')
            ->execute()
            ->fetchAllAssociative();

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
                $article['likes'],
                $this->getTagsIdByArticleId($articleTagQuery, $article['id'])
            );
        }

        return require_once __DIR__ . '/../Views/ArticlesIndexView.php';
    }

    private function getTagsIdByArticleId(array $articleTagQuery, $articleId): array
    {
        $tags = [];
        foreach ($articleTagQuery as $articleTags) {
            if ($articleId == $articleTags['article_id']) {
                $tags[] = $articleTags['tag_id'];
            }
        }
        return $tags;
    }

    private function getTagName(array $tagsId): array
    {
        $tagsNames = [];

        foreach ($tagsId as $tagId)
        {
            $tagsNames[] = query()
                ->select('name')
                ->from('tags')
                ->where('id = :tagId')
                ->setParameter('tagId', (int)$tagId)
                ->execute()
                ->fetchAllAssociative();
        }
        var_dump($tagsNames);
        return $tagsNames;
    }

    public function show(array $vars)
    {
        $articleTagQuery = query()
            ->select('*')
            ->from('article_tag')
            ->execute()
            ->fetchAllAssociative();

        $articleQuery = query()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', (int)$vars['id'])
            ->execute()
            ->fetchAssociative();

        $commentsQuery = query()
            ->select('*')
            ->from('comments')
            ->where('article_id = :articleId')
            ->setParameter('articleId', (int)$vars['id'])
            ->execute()
            ->fetchAllAssociative();

        $comments = [];

        foreach ($commentsQuery as $comment) {
            $comments[] = new Comment(
                (int)$comment['id'],
                $comment['article_id'],
                $comment['name'],
                $comment['comment'],
                $comment['created_at']
            );
        }

        $articlesTagsQuery = query()
            ->select('*')
            ->from('article_tag')
            ->execute()
            ->fetchAllAssociative();

        $article = new Article(
            (int)$articleQuery['id'],
            $articleQuery['title'],
            $articleQuery['content'],
            $articleQuery['created_at'],
            $articleQuery['likes'],
            $this->getTagsIdByArticleId($articleTagQuery, $articleQuery['id'])
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

    public function delete(array $vars)
    {
        query()
            ->delete('articles')
            ->where('id = :id')
            ->setParameter('id', (int)$vars['id'])
            ->execute();

        header('Location: /');
    }
}