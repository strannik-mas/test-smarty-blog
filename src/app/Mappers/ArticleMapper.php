<?php
declare(strict_types=1);

namespace App\Mappers;

use App\Models\Article;

class ArticleMapper
{
    public function map(Article $article): array
    {
        $result = [
            'title' => $article->getTitle(),
            'slug' => $article->getSlug(),
            'description' => $article->getDescription(),
            'image' => $article->getImage(),
            'publishedAt' => $article->getPublishedAt()->format('Y-m-d H:i:s')
        ];
        if (! is_null($article->getViews())) {
            $result['views'] = $article->getViews();
        }
        if (! is_null($article->getContent())) {
            $result['content'] = $article->getContent();
        }
        return $result;
    }
}