<?php
declare(strict_types=1);

namespace App\Core;

use Smarty\Smarty;

class View
{
    private Smarty $smarty;
    
    public function __construct()
    {
        $compileDir = __DIR__ . '/../../templates_c';
        if (!is_dir($compileDir)) {
            mkdir($compileDir, 0777, true);
        }
        if (!is_writable($compileDir)) {
            chmod($compileDir, 0777);
        }

        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../../templates');
        $this->smarty->setCompileDir($compileDir);
        $this->smarty->setCacheDir(__DIR__ . '/../../cache');
    }

    public function render(string $template, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template);
    }
}