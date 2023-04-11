<?php

class Database {
    private $db;
    
    public function __construct() {
        $this->db = new SQLite3('database.db');
        $this->db->query('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, name VARCHAR(100), chat_id VARCHAR(20), created_at TEXT)');
        echo "created";
    }
    // CREATE TABLE odamlar (id INT PRIMARY KEY AUTO_INCREMENT, ismi VARCHAR(40) DEFAULT 'kiritilmagan' NOT NULL
    public function addUser($name, $chat_id) {
        $stmt = $this->db->prepare('INSERT INTO users (name, chat_id, created_at) VALUES (:name, :chat_id, :created_at)');
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->bindValue(':chat_id', $chat_id, SQLITE3_INTEGER);
        $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), SQLITE3_TEXT);
        $stmt->execute();
    }

    public function getUser($id) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE chat_id = :id');
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        return $result->fetchArray(SQLITE3_ASSOC);
    }
}
