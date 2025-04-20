<?php

namespace Aries\Dbmodel\Models;

use Aries\Dbmodel\Includes\Database;
use PDO;

class Post extends Database {
    private $db;

    public function __construct() {
        parent::__construct(); // Call the parent constructor to establish the connection
        $this->db = $this->getConnection(); // Get the connection instance
    }

    public function getPosts() {
        $sql = "SELECT * FROM posts";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostsByLoggedInUser($id) {
        $sql = "SELECT * FROM posts WHERE author_id = :id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentPosts($limit = 5) {
        $sql = "SELECT p.*, u.first_name, u.last_name
                    FROM posts p
                    INNER JOIN users u ON p.author_id = u.id
                    ORDER BY p.created_at DESC
                    LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPost($data) {
        $sql = "INSERT INTO posts (title, content, author_id, created_at, updated_at) VALUES (:title, :content, :author_id, NOW(), NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => $data['title'],
            'content' => $data['content'],
            'author_id' => $data['author_id']
        ]);

        header('Location: index.php');
        exit;
    }


    public function updatePost($data) { // Renamed to be specific to posts
        $sql = "UPDATE posts SET title = :title, content = :content, updated_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'title' => $data['title'],
            'content' => $data['content']
        ]);
        return "Blog post UPDATED successfully";
    }

    public function deletePost($id) { // Renamed to be specific to posts
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return "Blog post DELETED successfully";
    }
}