<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;

class CategoryService
{
    const VALID_SORT_VALUES = [
        'newest' => 'published_at DESC',
        'oldest' => 'published_at ASC',
        'popular' => 'views DESC'
    ];
    const DEFAULT_SORT = 'newest';
    const ARTICLES_PER_PAGE = 6;
    public function __construct(
        private ArticleRepository $articleRepository,
        private CategoryRepository $categoryRepository
    )
    {
    }

    public function getCategoryData(string $slug): ?array
    {
        try {
            /**
             * @var Category|null $category
             */
            $category = $this->categoryRepository->findBySlug($slug);
            if (!$category) {
                return null;
            }

            $params = [];
            $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
            if ($query) {
                parse_str($query, $params);
            }

            $currentSort = isset($params['sort']) && in_array($params['sort'], array_keys(self::VALID_SORT_VALUES)) ?
                $params['sort'] :
                self::DEFAULT_SORT;

            $sort = self::VALID_SORT_VALUES[$currentSort];

            $currentPage = isset($params['page']) && $params['page'] >=1 ? (int) $params['page'] : 1;

            $offset = ($currentPage - 1) * self::ARTICLES_PER_PAGE;
            $articles = $this->articleRepository->getLatestArticlesByCategory(
                $category->getId(),
                $sort,
                self::ARTICLES_PER_PAGE,
                $offset
            );
            $countInCategory = $this->articleRepository->countByCategory($category->getId());
            $totalPages = ceil($countInCategory / self::ARTICLES_PER_PAGE);

            if (is_null($countInCategory)) {
                return null;
            }

            return [
                'currentSort' => $currentSort,
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'category' => $category,
                'articles' => $articles
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}