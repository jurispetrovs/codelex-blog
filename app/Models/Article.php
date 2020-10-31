<?php

namespace App\Models;

class Article
{
    private int $id;
    private string $title;
    private string $content;
    private string $createdAt;
    private int $likes;
    private array $tags;

    public function __construct(
        int $id,
        string $title,
        string $content,
        string $createdAt,
        int $likes,
        array $tags
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->likes = $likes;
        $this->tags = $tags;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}