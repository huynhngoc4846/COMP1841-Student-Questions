<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\UserRepository;
use PDOException;

class UserController extends Controller
{
    public function index()
    {
        $repository = new UserRepository();
        $this->renderView('user/index', ['users' => $repository->getAll()]);
    }

    public function create()
    {
        $this->renderView('user/form', ['user' => null]);
    }

    public function edit($id)
    {
        $repository = new UserRepository();
        $this->renderView('user/form', ['user' => $repository->find($id)]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveUser();
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveUser($id);
        }
    }

    private function saveUser($id = null)
    {
        $fullName = trim($_POST['full_name'] ?? '');
        $userName = trim($_POST['user_name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($fullName) || empty($userName) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Please enter a valid name, username and email.');
        }

        $repository = new UserRepository();
        $data = ['full_name' => $fullName, 'user_name' => $userName, 'email' => $email];

        if ($id) {
            $repository->update($id, $data);
        } else {
            $repository->create($data);
        }

        header('Location: ' . BASE_URL . '/user/index');
        exit();
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $repository = new UserRepository();
                $repository->delete($id);
            } catch (PDOException $exception) {
                die('This author has questions and cannot be deleted.');
            }
            header('Location: ' . BASE_URL . '/user/index');
            exit();
        }
    }

}
