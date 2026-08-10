<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\PostRepository;
use App\Models\UserRepository;
use App\Models\CategoryRepository;

class PostController extends Controller
{
    public function index()
    {
        $postRepository = new PostRepository();
        $this->renderView('post/index', ['posts' => $postRepository->getAll()]);
    }

    public function create()
    {
        $this->showForm();
    }

    public function edit($id)
    {
        $postRepository = new PostRepository();
        $this->showForm($postRepository->find($id));
    }

    private function showForm($post = null)
    {
        $userRepository = new UserRepository();
        $categoryRepository = new CategoryRepository();
        $this->renderView('post/form', [
            'post' => $post,
            'users' => $userRepository->getAll(),
            'modules' => $categoryRepository->getAll()
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->savePost();
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->savePost($id);
        }
    }

    private function savePost($id = null)
    {
        $title = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        $moduleId = filter_input(INPUT_POST, 'module_id', FILTER_VALIDATE_INT);

        if (empty($title) || empty($content) || !$userId || !$moduleId) {
            die('Please complete all required fields.');
        }

        $postRepository = new PostRepository();
        $oldPost = $id ? $postRepository->find($id) : null;
        $imageName = $oldPost['image'] ?? null;

        if (!empty($_FILES['image']['name'])) {
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $temporaryPath = $_FILES['image']['tmp_name'];
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($extension, $allowedExtensions) || $fileSize > 2 * 1024 * 1024) {
                die('The image must be JPG, PNG or WEBP and no larger than 2 MB.');
            }

            $imageName = uniqid() . '.' . $extension;
            move_uploaded_file($temporaryPath, ROOT_PATH . '/public/uploads/' . $imageName);
        }

        $data = [
            'title' => $title,
            'summary' => $summary,
            'content' => $content,
            'image' => $imageName,
            'user_id' => $userId,
            'module_id' => $moduleId
        ];

        if ($id) {
            $postRepository->update($id, $data);
        } else {
            $postRepository->create($data);
        }

        header('Location: ' . BASE_URL . '/post/index');
        exit();
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postRepository = new PostRepository();
            $postRepository->delete($id);
            header('Location: ' . BASE_URL . '/post/index');
            exit();
        }
    }
}
