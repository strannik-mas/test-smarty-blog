<?php
declare(strict_types=1);

namespace App\Mappers;

use App\Models\Category;

class HomePageMapper extends Mapper
{
    public function map(array $categoriesWithArticles): array
    {
        $result = [];
        foreach ($categoriesWithArticles as $categoryData) {
            /** @var Category $curCategory */
            $curCategory = $categoryData['category'];
            $result[$curCategory->getSlug()]['category'] = $this->categoryMapper->map($curCategory);

            foreach ($categoryData['articles'] as $article) {
                $result[$curCategory->getSlug()]['articles'][] = $this->articleMapper->map($article);
            }
        }
        return $result;
    }
}