<?php
namespace App\Models;

use App\Core\Database;

class UserRepository
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAll()
    {
        $sql = 'SELECT users.*, COUNT(posts.id) AS post_count
                FROM users
                LEFT JOIN posts ON posts.user_id = users.id
                GROUP BY users.id
                ORDER BY users.full_name';
        $statement = $this->db->query($sql);
        return $statement->fetchAll();
    }

    public function find($id)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $statement = $this->db->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    public function create($data)
    {
        $sql = 'INSERT INTO users (full_name, user_name, email)
                VALUES (:full_name, :user_name, :email)';
        $statement = $this->db->prepare($sql);
        return $statement->execute($data);
    }

    public function update($id, $data)
    {
        $sql = 'UPDATE users SET full_name = :full_name, user_name = :user_name, email = :email WHERE id = :id';
        $statement = $this->db->prepare($sql);
        $data['id'] = $id;
        return $statement->execute($data);
    }

    public function delete($id)
    {
        $statement = $this->db->prepare('DELETE FROM users WHERE id = :id');
        return $statement->execute(['id' => $id]);
    }
}
