<?php
namespace App\Core;

class Controller
{
    protected function renderView($viewPath, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

        $mainViewFile = ROOT_PATH . '/app/Views/' . $viewPath . '.php';

        if (file_exists($mainViewFile)) {
            require ROOT_PATH . '/app/Views/partials/header.php';
            require $mainViewFile;
            require ROOT_PATH . '/app/Views/partials/footer.php';
        } else {
            die('View not found: ' . $mainViewFile);
        }
    }

}
