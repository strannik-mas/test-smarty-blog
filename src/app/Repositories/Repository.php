<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

class Repository
{
    protected PDO $pdo;
    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }
}