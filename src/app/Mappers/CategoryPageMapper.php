<?php
declare(strict_types=1);

namespace App\Mappers;

use App\Models\Category;

class CategoryPageMapper extends Mapper
{
    public function map(array $categoryWithArticles): array
    {
        /**
         * @var Category $category
         */
        $category = $categoryWithArticles['category'];
        $result = [
            'category' => $this->categoryMapper->map($category),
        ];
        foreach ($categoryWithArticles['articles'] as $article) {
            $result['articles'][] = $this->articleMapper->map($article);
        }
        return $result;
    }
}