<?php

declare(strict_types=1);

use App\Services\MigrationService;
use App\Services\SeederService;

require_once __DIR__ . '/vendor/autoload.php';

$command = $argv[1] ?? null;

if (!$command) {
    echo "Usage: php cli.php <command>\n";
    echo "You can run 'php cli.php help' for more information.\n";
    exit(1);
}

function migrate(): void
{
    echo "Запуск миграций...\n";

    $migration = new MigrationService();
    $migration->run();

    echo "Миграции завершены.\n";
}

function seed(): void
{
    echo "Запуск сидинга...\n";
    $seeder = new SeederService();
    $seeder->run();
    echo "Сидинг завершен.\n";
}

switch ($command) {
    case 'help':
        echo "Available commands:\n";
        echo "  help - Show this help message\n";
        echo "  migrate - Run database migrations\n";
        echo "  seed - Seed the database with sample data\n";
        break;

    case 'migrate':
        migrate();
        break;

    case 'seed':
        seed();
        break;

    default:
        echo "Unknown command: $command\n";
        echo "Run 'php cli.php help' for more information.\n";
        exit(1);
}
