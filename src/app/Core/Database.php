<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOStatement;

class Database
{
    private static $instance = null;
    private PDO $pdo;
    private function __construct(){
        $config = require __DIR__ . '/../../config/database.php';
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";
        // Инициализация подключения к базе данных
        $this->pdo = new PDO($dsn, $config['user'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    private function __clone(){}
    public function __destruct()
    {
        unset($this->pdo);
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}