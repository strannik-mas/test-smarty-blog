<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;

class HomeService
{
    public function __construct(
        private ArticleRepository $articleRepository,
        private CategoryRepository $categoryRepository
    )
    {
    }

    public function getHomePageData(): array
    {
        $categories = $this->categoryRepository->getCategories();
        $result = [];
        $categoryIds = array_map(
            fn(Category $category) => $category->getId(),
            $categories
        );
        $allArticles = $this->articleRepository->getLatestForCategories($categoryIds);

        foreach ($categories as $category) {
            $result[] = [
                'category' => $category,
                'articles' => $allArticles[$category->getId()] ?? []
            ];
        }

        return $result;
    }
}