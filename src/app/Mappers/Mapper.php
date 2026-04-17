<?php
declare(strict_types=1);

namespace App\Mappers;

class Mapper
{
    public function __construct(protected ArticleMapper $articleMapper, protected CategoryMapper $categoryMapper)
    {
    }
}