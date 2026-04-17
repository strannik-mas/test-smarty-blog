<?php
declare(strict_types=1);

namespace App\Core;

use App\Controllers\ArticleController;
use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Mappers\ArticleMapper;
use App\Mappers\CategoryMapper;
use App\Mappers\CategoryPageMapper;
use App\Mappers\HomePageMapper;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Services\ArticleService;
use App\Services\CategoryService;
use App\Services\HomeService;

class Router
{
    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments = explode('/', trim($uri, '/'));
        $db = Database::getInstance();
        $articleMapper = new ArticleMapper();
        $categoryMapper = new CategoryMapper();
        $articleRepo = new ArticleRepository($db);
        $categoryRepo = new CategoryRepository($db);
        $view = new View();

        switch ($segments[0]) {
            case '':
                $controller = new HomeController(
                    new HomeService($articleRepo, $categoryRepo),
                    new HomePageMapper($articleMapper, $categoryMapper),
                    $view
                );
                $controller->index();
                break;
            case 'category':
                $controller = new CategoryController(
                    $view,
                    new CategoryService($articleRepo, $categoryRepo),
                    new CategoryPageMapper($articleMapper, $categoryMapper)
                );
                $controller->show($segments[1]);
                break;
            case 'article':
                $controller = new ArticleController(
                    $view,
                    new ArticleService($articleRepo),
                    new ArticleMapper()
                );
                $controller->show($segments[1]);
                break;
            default:
                http_response_code(404);
                echo 'Page not found';
        }
    }
}