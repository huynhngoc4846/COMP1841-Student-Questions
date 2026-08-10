<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private $host = 'localhost';
    private $databaseName = 'post_database';
    private $username = 'root';
    private $password = '';
    private $connection;

    public function connect()
    {
        $this->connection = null;

        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->databaseName . ';charset=utf8mb4';
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            die('Database connection failed: ' . $exception->getMessage());
        }

        return $this->connection;
    }
}
