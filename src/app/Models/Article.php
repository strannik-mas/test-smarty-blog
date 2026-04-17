<?php
declare(strict_types=1);

namespace App\Models;

use DateTime;

class Article
{
    public function __construct(
        private int $id,
        private string $title,
        private string $slug,
        private string $image,
        private string $description,
        private DateTime $publishedAt,
        private ?int $views = null,
        private ?string $content = null,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function getPublishedAt(): ?DateTime
    {
        return $this->publishedAt;
    }
}