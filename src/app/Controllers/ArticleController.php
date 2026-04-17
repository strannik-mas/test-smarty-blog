<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Mappers\ArticleMapper;
use App\Services\ArticleService;

class ArticleController extends BaseController
{
    public function __construct(
        View $view,
        private ArticleService $articleService,
        private ArticleMapper $articleMapper
    )
    {
        parent::__construct($view);
    }

    public function show(string $slug): void
    {
        $article = $this->articleService->getArticleData($slug);
        if (is_null($article)) {
            $this->notFound();
        }

        $this->render('pages/article.tpl', [
            'mainTitle' => 'Main page',
            'article' => $this->articleMapper->map($article)
        ]);
    }
}