<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Article;
use App\Repositories\ArticleRepository;

class ArticleService
{
    public function __construct(private ArticleRepository $articleRepository)
    {
    }

    public function getArticleData(string $slug): ?Article
    {
        /**
         * @var Article|null $article
         */
        $article = $this->articleRepository->findBySlug($slug);
        if (is_null($article)) {
            return null;
        }
        $this->articleRepository->incrementViews($article->getId());
        return $article;
    }
}