<?php
// Ce fichier contient la classe Produit
// Elle sert à gérer les produits de notre site e-commerce (ajouter, modifier, supprimer...)
// Elle est liée à la table 'produits' qu'on a créée dans phpMyAdmin dans la base 'projet_web'

class Produit {
    private $conn;
    private $table = "produits";

    public $id;
    public $nom;
    public $description;
    public $prix;
    public $image;

    public function __construct($db) {
        $this->conn = $db;
    }

    //Récupèrer tous les produits de la table
    public function getAll() {
        $sql = "SELECT * FROM $this->table";
        return $this->conn->query($sql);
    }

    //Récupèrer un seul produit selon son id
    public function getOne() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->execute(['id' => $this->id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Ajouter un nouveau produit dans la base
    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (nom, description, prix, image) VALUES (:nom, :description, :prix, :image)");
        return $stmt->execute([
            'nom' => $this->nom,
            'description' => $this->description,
            'prix' => $this->prix,
            'image' => $this->image
        ]);
    }

    // Modifier un produit existant
    public function update() {
        $stmt = $this->conn->prepare("UPDATE $this->table SET nom=:nom, description=:description, prix=:prix, image=:image WHERE id=:id");
        return $stmt->execute([
            'nom' => $this->nom,
            'description' => $this->description,
            'prix' => $this->prix,
            'image' => $this->image,
            'id' => $this->id
        ]);
    }

    // Supprimer un produit grâce à son id
    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = :id");
        return $stmt->execute(['id' => $this->id]);
    }
}
?>
