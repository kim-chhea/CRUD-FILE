<?php 
class File {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function Store($query, $params) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return ['message' => 'Query executed successfully', 'status' => true];  
        } catch (PDOException $e) { 
            return ['message' => $e->getMessage(), 'status' => false];
        }
    }

    public function Show() {
        $query = "SELECT Name_file, display_name FROM Files";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
}
?>
