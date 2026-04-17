<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use Database\Seeders\ArticleCategorySeeder;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\CategorySeeder;
use PDO;

class SeederService
{
    private PDO $pdo;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function run()
    {
        //очистка всех таблиц в базе данных
        $this->truncateTables();

        $this->pdo->beginTransaction();

        try {
            (new CategorySeeder())->run($this->pdo);
            (new ArticleSeeder())->run($this->pdo);
            (new ArticleCategorySeeder())->run($this->pdo);

            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    private function truncateTables()
    {
        //получаем список всех таблиц в базе данных
        $tables = $this->pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

        //устанавливаем ограничение внешних ключей в 0, чтобы можно было очистить таблицы
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

        //очищаем каждую таблицу
        foreach ($tables as $table) {
            $this->pdo->exec("TRUNCATE TABLE `$table`");
        }

        //устанавливаем ограничение внешних ключей обратно в 1
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }
}