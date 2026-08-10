<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\CategoryRepository;
use PDOException;

class CategoryController extends Controller
{
    public function index()
    {
        $repository = new CategoryRepository();
        $this->renderView('category/index', ['modules' => $repository->getAll()]);
    }

    public function create()
    {
        $this->renderView('category/form', ['module' => null]);
    }

    public function edit($id)
    {
        $repository = new CategoryRepository();
        $this->renderView('category/form', ['module' => $repository->find($id)]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveModule();
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveModule($id);
        }
    }

    private function saveModule($id = null)
    {
        $data = ['name' => trim($_POST['name'] ?? ''), 'description' => trim($_POST['description'] ?? '')];
        if (empty($data['name'])) {
            die('Module name is required.');
        }
        $repository = new CategoryRepository();
        $id ? $repository->update($id, $data) : $repository->create($data);
        header('Location: ' . BASE_URL . '/category/index');
        exit();
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $repository = new CategoryRepository();
                $repository->delete($id);
            } catch (PDOException $exception) {
                die('This module has questions and cannot be deleted.');
            }
            header('Location: ' . BASE_URL . '/category/index');
            exit();
        }
    }
}
