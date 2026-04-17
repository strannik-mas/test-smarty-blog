<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends Repository
{
    /**
     * Получить все категории, у которых есть хоть 1 статья, с количеством статей в каждой категории
     * @return Category[]
     */
    /*public function getCategoriesWithArticles(): array
    {
        $sql = 'SELECT c.id, c.name, c.slug, COUNT(a.id) AS articles_count
                    FROM categories c
                             JOIN article_category ac ON c.id = ac.category_id
                             JOIN articles a ON ac.article_id = a.id
                    GROUP BY c.id, c.name, c.slug';

        $rows = $this->pdo->query($sql)->fetchAll();

        return array_map(
            fn(array $row) => new Category(
                (int) $row['id'],
                $row['name'],
                $row['slug'],
                $row['articles_count']
            ),
            $rows
        );
    }*/

    public function getCategories()
    {
        $sql = 'SELECT c.id, c.name, c.slug, c.description
                    FROM categories c
                             JOIN article_category ac ON c.id = ac.category_id
                    GROUP BY c.id, c.name, c.slug';

        $rows = $this->pdo->query($sql)->fetchAll();

        return array_map(
            fn(array $row) => new Category(
                (int) $row['id'],
                $row['name'],
                $row['slug'],
                $row['description']
            ),
            $rows
        );
    }

    public function findBySlug(string $slug): ?Category
    {
        $sql = 'SELECT id, name, slug, description FROM categories WHERE slug = :slug';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();

        if ($row) {
            return new Category(
                (int) $row['id'],
                $row['name'],
                $row['slug'],
                $row['description']
            );
        }

        return null;
    }
}