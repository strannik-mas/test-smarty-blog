<?php
declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Faker\Factory;
use PDO;

class CategorySeeder
{
    const NUMBER_OF_CATEGORIES = 10;
    public function run(PDO $pdo): void
    {
        $faker = Factory::create();

        $sql = 'INSERT INTO categories (
                    name,
                    slug,
                    description
                )
                VALUES (?, ?, ?)';

        $statement = $pdo->prepare($sql);

        if ($statement === false) {
            throw new Exception('Failed to prepare statement for category seeding');
        }

        for ($i = 0; $i < self::NUMBER_OF_CATEGORIES; $i++) {
            $name = ucfirst($faker->unique()->word());

            $statement->execute([
                $name,
                strtolower($name),
                $faker->sentence(10),
            ]);
        }
    }
}