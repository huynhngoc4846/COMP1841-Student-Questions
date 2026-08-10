<?php
namespace App\Models;

use App\Core\Database;

class PostRepository
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAll()
    {
        $sql = 'SELECT posts.*, users.full_name AS author_name, modules.name AS module_name
                FROM posts
                INNER JOIN users ON users.id = posts.user_id
                INNER JOIN modules ON modules.id = posts.module_id
                ORDER BY posts.created_at DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $sql = 'SELECT posts.*, users.full_name AS author_name, modules.name AS module_name
                FROM posts
                INNER JOIN users ON users.id = posts.user_id
                INNER JOIN modules ON modules.id = posts.module_id
                WHERE posts.id = :id';
        $statement = $this->db->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    public function create($data)
    {
        $sql = 'INSERT INTO posts (title, summary, content, image, user_id, module_id)
                VALUES (:title, :summary, :content, :image, :user_id, :module_id)';
        $statement = $this->db->prepare($sql);
        return $statement->execute($data);
    }

    public function update($id, $data)
    {
        $sql = 'UPDATE posts SET title = :title, summary = :summary, content = :content,
                image = :image, user_id = :user_id, module_id = :module_id WHERE id = :id';
        $statement = $this->db->prepare($sql);
        $data['id'] = $id;
        return $statement->execute($data);
    }

    public function delete($id)
    {
        $statement = $this->db->prepare('DELETE FROM posts WHERE id = :id');
        return $statement->execute(['id' => $id]);
    }
}
