<?php
declare(strict_types=1);

namespace Database\Seeders;

use PDO;

class ArticleCategorySeeder
{
    public function run(PDO $pdo): void
    {
        $acricleIds = $pdo->query('SELECT id FROM articles')->fetchAll(PDO::FETCH_COLUMN);
        $categoryIds = $pdo->query('SELECT id FROM categories')->fetchAll(PDO::FETCH_COLUMN);

        $statement = $pdo->prepare(
            'INSERT IGNORE INTO article_category (article_id, category_id) VALUES (:article_id, :category_id)'
        );

        foreach ($acricleIds as $articleId) {
            shuffle($categoryIds);

            $count = min(rand(1, 3), count($categoryIds));

            $randomCategoryIds = $categoryIds;
            shuffle($randomCategoryIds);
            $selectedCategoryIds = array_slice($randomCategoryIds, 0, $count);

            foreach ($selectedCategoryIds as $selectedCategoryId) {
                $statement->execute([
                    ':article_id' => (int) $articleId,
                    ':category_id' => (int) $selectedCategoryId
                ]);
            }
        }
    }
}