<?php
namespace App\Models;

use App\Core\Database;

class CategoryRepository
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAll()
    {
        $sql = 'SELECT modules.*, COUNT(posts.id) AS post_count
                FROM modules LEFT JOIN posts ON posts.module_id = modules.id
                GROUP BY modules.id ORDER BY modules.name';
        return $this->db->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $statement = $this->db->prepare('SELECT * FROM modules WHERE id = :id');
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    public function create($data)
    {
        $statement = $this->db->prepare('INSERT INTO modules (name, description) VALUES (:name, :description)');
        return $statement->execute($data);
    }

    public function update($id, $data)
    {
        $statement = $this->db->prepare('UPDATE modules SET name = :name, description = :description WHERE id = :id');
        $data['id'] = $id;
        return $statement->execute($data);
    }

    public function delete($id)
    {
        $statement = $this->db->prepare('DELETE FROM modules WHERE id = :id');
        return $statement->execute(['id' => $id]);
    }
}
