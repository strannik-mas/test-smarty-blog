<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Mappers\CategoryPageMapper;
use App\Services\CategoryService;

class CategoryController extends BaseController
{
    public function __construct(
        View $view,
        private CategoryService $categoryService,
        private CategoryPageMapper $categoryPageMapper
    )
    {
        parent::__construct($view);
    }

    public function show(string $slug): void
    {
        $categoryData = $this->categoryService->getCategoryData($slug);

        if (is_null($categoryData)) {
            $this->notFound();
            return;
        }

        $viewData = $this->categoryPageMapper->map($categoryData);

        $this->render('pages/category.tpl', [
            'mainTitle' => 'Main page',
            'currentSort' => $categoryData['currentSort'],
            'currentPage' => $categoryData['currentPage'],
            'totalPages' => $categoryData['totalPages'],
            'category' => $viewData['category'],
            'articles' => $viewData['articles']
        ]);
    }
}