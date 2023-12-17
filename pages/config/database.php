<?php

class Database {
  private $host = "mysql";
  private $db = "app";
  private $username = "root";
  private $password = "123456";
  private $conn;

  public function __construct() {
    $this->connect();
  }

  private function isConnected() {
    return $this->conn !== null;
  }

  public function initialize() {
    try {
      if ($this->isConnected() && !$this->isDatabaseExists()) {
        $this->conn->query("CREATE DATABASE IF NOT EXISTS $this->db");
      }
      if ($this->isConnected() && !$this->isTableExists("users")) {
        $this->createUserTable();
      }
    } catch(PDOException $e) {
      echo "Error creating database: ". $e->getMessage();
    }
  }

  private function connect() {
    try {
      $this->conn = new PDO("mysql:host=$this->host", $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo "Connection refuse: " . $e->getMessage();
    }
  }

  private function isDatabaseExists() {
    $stmt = $this->conn->query("SHOW DATABASES LIKE '$this->db'");
    return $stmt->rowCount() > 0;
  }

  private function isTableExists($tableName) {
    $stmt = $this->conn->query("USE $this->db; SHOW TABLES LIKE '$tableName'");
    return $stmt->rowCount() > 0;
  }

  private function createUserTable() {
    try {
      $query = "
        CREATE TABLE IF NOT EXISTS users (
          id CHAR(36) NOT NULL DEFAULT '',
          username VARCHAR(255) NOT NULL,
          password VARCHAR(255) NOT NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (id)
        )
      ";
      $this->conn->exec("USE $this->db; $query");
    } catch(PDOException $e) {
      echo "Error creating users table: ". $e->getMessage();
    }
  }
}