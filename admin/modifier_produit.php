<?php
// Ce fichier permet de modifier un produit déjà existant dans la base de données.
// On récupère l’ID du produit via l’URL, puis ses informations actuelles.
// Ensuite, si le formulaire est soumis, on met à jour les données du produit avec celles envoyées.
// La modification se fait grâce à la méthode update() de la classe Produit.

require_once '../config/base.php';
require_once '../classe/produit.php';

$db = new Database();
$conn = $db->getConnection();

// Vérifier si un ID de produit est passé en paramètre
if (isset($_GET['id'])) {
    $produit = new Produit($conn);
    $produit->id = $_GET['id'];

    // Récupérer les informations du produit
    $stmt = $conn->prepare("SELECT * FROM produits WHERE id = :id");
    $stmt->execute(['id' => $produit->id]);
    $produitData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produitData) {
        die("Produit non trouvé");
    }
} else {
    die("ID du produit non fourni");
}

// Si le formulaire est soumis, mettre à jour les données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produit->nom = $_POST['nom'];
    $produit->description = $_POST['description'];
    $produit->prix = $_POST['prix'];
    $produit->image = $_POST['image']; 

    // Mise à jour du produit
    if ($produit->update()) {
        echo "✅ Produit modifié avec succès ! <a href='liste_produit.php'>Retour à la liste des produits</a>";
    } else {
        echo "❌ Erreur lors de la modification du produit.";
    }
}

?>

<form action="" method="POST">
    <label for="nom">Nom</label>
    <input type="text" name="nom" value="<?= $produitData['nom']; ?>" required>

    <label for="description">Description</label>
    <textarea name="description" required><?= $produitData['description']; ?></textarea>

    <label for="prix">Prix</label>
    <input type="text" name="prix" value="<?= $produitData['prix']; ?>" required>

    <label for="image">Image (nom du fichier)</label>
    <input type="text" name="image" value="<?= $produitData['image']; ?>" required>

    <button type="submit">Modifier le produit</button>
</form>
