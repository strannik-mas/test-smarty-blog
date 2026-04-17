<?php
declare(strict_types=1);

namespace Database\Seeders;

use Faker\Factory;
use PDO;
use RuntimeException;

class ArticleSeeder
{
    const NUMBER_OF_ARTICLES = 50;

    public function run(PDO $pdo): void
    {
        $faker = Factory::create();

        $sql = <<<SQL
            INSERT INTO articles (
                title,
                slug,
                image,
                description,
                content,
                views,
                published_at
            )
            VALUES (:title, :slug, :image, :description, :content, :views, :published_at)
SQL;


        $statement = $pdo->prepare($sql);

        if ($statement === false) {
            throw new RuntimeException('Failed to prepare SQL statement for seeding articles.');
        }

        for ($i = 0; $i < self::NUMBER_OF_ARTICLES; $i++) {
            $statement->execute([
                ':title' => $faker->sentence(5),
                ':slug' => $faker->unique()->slug(),
                ':image' => "https://picsum.photos/800/600?random={$i}",
                ':description' => $faker->paragraph(),
                ':content' => $faker->text(2000),
                ':views' => $faker->numberBetween(0, 1000),
                ':published_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}