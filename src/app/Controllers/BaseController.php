<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;

class BaseController
{
    public function __construct(
        private View $view
    )
    {
    }

    protected function notFound()
    {
        $this->view->render('errors/404.tpl', ['mainTitle' => 'Error 404']);
    }

    protected function render(string $template, array $data = []): void {
        $this->view->render($template, $data);
    }
}