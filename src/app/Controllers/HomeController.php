<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Mappers\HomePageMapper;
use App\Services\HomeService;

class HomeController extends BaseController
{
    public function __construct(
        private HomeService $homeService,
        private HomePageMapper $homePageMapper,
        View $view
    ){
        parent::__construct($view);
    }

    public function index(): void
    {
        $result = $this->homeService->getHomePageData();
//        var_dump($result);
        $viewData = $this->homePageMapper->map($result);

        $this->render(
            'pages/home.tpl',
            [
                'mainTitle' => 'Main page',
                'categories' => $viewData,
            ]
        );
    }
}