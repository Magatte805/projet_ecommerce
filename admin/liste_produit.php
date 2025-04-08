<?php
// Ce fichier affiche la liste de tous les produits dans la base de données.
// Il récupère tous les produits via la méthode getAll() de la classe Produit.
// On permet à l'administrateur de modifier ou de supprimer un produit à partir de cette liste.

require_once '../config/base.php';
require_once '../classe/produit.php';

$db = new Database();
$conn = $db->getConnection();
$produit = new Produit($conn);
$produits = $produit->getAll()->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si la suppression a réussi
$success = isset($_GET['success']) ? $_GET['success'] : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des produits - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Liste des Parfums</h2>
        
        <!--Affichage du message de succès ou d'erreur-->
        <?php if ($success === '1'): ?>
            <div class="alert alert-success">
                ✅ Le produit a été supprimé avec succès !
            </div>
        <?php elseif ($success === '0'): ?>
            <div class="alert alert-danger">
                ❌ Une erreur est survenue lors de la suppression du produit.
            </div>
        <?php endif; ?>
        
        <a href="ajouter_produit.php" class="btn btn-success mb-3">+ Ajouter un produit</a>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $prod): ?>
                    <tr>
                        <td><img src="../asset/images/<?= $prod['image'] ?>" alt="<?= $prod['nom'] ?>" width="80"></td>
                        <td><?= htmlspecialchars($prod['nom']) ?></td>
                        <td><?= number_format($prod['prix'], 2) ?> €</td>
                        <td>
                            <a href="modifier_produit.php?id=<?= $prod['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="Supprimer_produit.php?id=<?= $prod['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
