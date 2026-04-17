<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use PDO;

class MigrationService
{
    private PDO $pdo;
    private $sqlArray;
    public function __construct()
    {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();

        $files = glob(__DIR__ . "/../../database/migrations/*.sql");
        $this->sqlArray = array_map('file_get_contents', $files);
    }

    public function run()
    {
        foreach ($this->sqlArray as $sql) {
            $this->pdo->exec($sql);
        }
    }
}