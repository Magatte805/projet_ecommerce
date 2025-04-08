<?php
// Ce fichier permet de supprimer un produit de la base de données.
// On vérifie d’abord si l’ID du produit est passé dans l’URL (via $_GET).
// Ensuite, on récupère le produit dans la base pour s’assurer qu’il existe bien.
// Si tout est bon, on utilise la méthode delete() de la classe Produit pour le supprimer.
// Après la suppression, on redirige vers la page de liste des produits.

require_once '../config/base.php';
require_once '../classe/produit.php';

$db = new Database();
$conn = $db->getConnection();

// Vérifier si un ID de produit est passé en paramètre
if (isset($_GET['id'])) {
    $produit = new Produit($conn);
    $produit->id = $_GET['id'];

    // Récupérer le produit à supprimer
    $stmt = $conn->prepare("SELECT * FROM produits WHERE id = :id");
    $stmt->execute(['id' => $produit->id]);
    $produitData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produitData) {
        die("Produit non trouvé");
    }

    // Suppression du produit
    if ($produit->delete()) {
        // Rediriger après la suppression
        header("Location: liste_produit.php?success=1");
        exit;
    } else {
        // Afficher un message d'erreur si la suppression échoue
        echo "❌ Erreur lors de la suppression du produit.";
    }
} else {
    die("ID du produit non fourni");
}
