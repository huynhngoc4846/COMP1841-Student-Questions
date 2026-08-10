<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\PostRepository;

class HomeController extends Controller
{
    public function index()
    {
        $postRepository = new PostRepository();
        $posts = $postRepository->getAll();
        $this->renderView('home/index', ['posts' => $posts]);
    }
}
