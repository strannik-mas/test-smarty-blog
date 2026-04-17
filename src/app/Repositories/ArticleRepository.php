<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article;
use DateTime;
use PDO;

class ArticleRepository extends Repository
{
    /**
     * Fetches the latest articles for a given category.
     * @param int $categoryId
     * @param int $limit
     * @return array
     * @throws \Exception
     */
    public function getLatestArticlesByCategory(
        int $categoryId,
        string $sort,
        ?int $limit = 3,
        ?int $offset = null
    ): array {
        $sql = 'SELECT a.id, a.title, a.slug, a.image, a.description, a.content, a.views, a.published_at
                    FROM articles a
                        JOIN article_category ac ON a.id = ac.article_id
                WHERE ac.category_id = :categoryId
                ORDER BY a.' . $sort;
        if ($limit > 0) {
            $sql .= " LIMIT :limit" ;
        }

        if ($offset > 0) {
            $sql .= " OFFSET :offset";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        if ($limit > 0) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        if ($offset > 0) {
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => new Article(
                id: (int)$row['id'],
                title: $row['title'],
                slug: $row['slug'],
                image: $row['image'],
                description: $row['description'],
                publishedAt: new DateTime($row['published_at']),
                views: $row['views'],
            ),
            $rows
        );
    }

    public function getLatestForCategories(array $categoryIds, int $limitPerCategory = 3): array
    {
        $results = [];
        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
        $sql = "SELECT a.id, a.title, a.slug, a.image, a.description, a.published_at, ac.category_id
                    FROM articles a
                        JOIN article_category ac ON a.id = ac.article_id
                WHERE ac.category_id IN ($placeholders)
                ORDER BY ac.category_id, a.published_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($categoryIds);
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            if (isset($results[$row['category_id']]) && count($results[$row['category_id']]) >= $limitPerCategory) {
                continue; // Skip if we've already added enough articles for this category
            }
            $results[$row['category_id']][] = new Article(
                id: (int)$row['id'],
                title: $row['title'],
                slug: $row['slug'],
                image: $row['image'],
                description: $row['description'],
                publishedAt: new DateTime($row['published_at'])
            );
        }
        return $results;
    }

    public function countByCategory(int $categoryId): ?int
    {
        $sql = "SELECT COUNT(ac.article_id) as articles_count
                    FROM article_category ac
                    WHERE ac.category_id = :categoryId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count !== false ? (int)$count : null;
    }

    public function findBySlug(string $slug): ?Article
    {
        $sql = 'SELECT id, title, slug, image, description, content, views, published_at FROM articles WHERE slug = :slug';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();

        if ($row) {
            return new Article(
                (int) $row['id'],
                $row['title'],
                $row['slug'],
                $row['image'],
                $row['description'],
                new DateTime($row['published_at']),
                $row['views'],
                $row['content']
            );
        }

        return null;
    }

    public function incrementViews(int $articleId): void
    {
        $sql = "UPDATE articles SET views = views + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $articleId]);
    }
}