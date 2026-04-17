<?php
declare(strict_types=1);

namespace App\Mappers;

use App\Models\Category;

class CategoryMapper
{
    public function map(Category $category): array
    {
        return [
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'description' => $category->getDescription()
        ];
    }
}