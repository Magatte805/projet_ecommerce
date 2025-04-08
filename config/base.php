<?php
// Connexion à la base de données 'projet_web' (table produits) via PDO
class Database {
    private $host = "localhost";
    private $db_name = "projet_web";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
