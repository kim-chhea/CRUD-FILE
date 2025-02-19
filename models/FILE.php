<?php 
class File {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function StoreFile($query, $params) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return ['message' => 'Query executed successfully', 'status' => true];  
        } catch (PDOException $e) { 
            return ['message' => $e->getMessage(), 'status' => false];
        }
    }

    public function Show() {
        $query = " SELECT users.user_id, users.user_name, users.email, image.paths, image.file_name
        FROM users
        LEFT JOIN image ON users.user_id = image.user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function Checkimage($param){
        $query = 'SELECT * FROM image WHERE file_name = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return false; 
        } else {
            return true; 
        }
    }
    public function StoreUser($param){
        $query = "INSERT INTO users (user_name, email) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($param);

        
    }

    }

?>
