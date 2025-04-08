<?php
// Ce fichier permet d’ajouter un produit à la base de données.
// On a d'abord connecté la base grâce au fichier base.php et à la classe Produit.
// Ensuite, on a créé un formulaire pour que l’admin entre les infos du produit (nom, description, prix, image).
// Quand le formulaire est envoyé, on vérifie si le produit existe déjà (avec le même nom).
// Si ce n’est pas le cas, on l’ajoute dans la table "produits".

require_once '../config/base.php';
require_once '../classe/produit.php';

$db = new Database();
$conn = $db->getConnection();
$produit = new Produit($conn);

$message = "";

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $produit->nom = $_POST['nom'];
    $produit->description = $_POST['description'];
    $produit->prix = $_POST['prix'];
    $produit->image = $_POST['image']; 

    // Vérifier si un produit avec ce nom existe déjà
    $stmt = $conn->prepare("SELECT COUNT(*) FROM produits WHERE nom = :nom");
    $stmt->execute(['nom' => $produit->nom]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $message = "❌ Ce produit existe déjà.";
    } else {
        if ($produit->create()) {
            $message = "✅ Produit ajouté avec succès.";
        } else {
            $message = "❌ Erreur lors de l'ajout.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Ajouter un nouveau parfum</h2>
        <?php if ($message): ?>
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <div><?= $message ?></div>
            <?php if (str_contains($message, 'succès')): ?>
                <a href="liste_produit.php" class="btn btn-sm btn-success ms-3">⬅️ Retour à la liste</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Prix</label>
                <input type="number" name="prix" step="0.01" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nom de l'image</label>
                <input type="text" name="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>
</html>
