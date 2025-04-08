<?php
//Ce fichier affiche le contenu du panier de l'utilisateur.
// Il permet aussi de supprimer des articles du panier et affiche le total de la commande.

session_start();

//On vérifie si l'on doit supprimer un produit
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    // On vérifie si le produit existe dans le panier
    if (isset($_SESSION['panier'][$id])) {
        //On supprime le produit du panier
        unset($_SESSION['panier'][$id]);
    }
    //On redirige vers la page du panier après suppression
    header('Location: panier.php');
    exit;
}
$panier = $_SESSION['panier'] ?? [];
$total = 0;

// Calcul du total du panier
foreach ($panier as $article) {
    $total += $article['prix'] * $article['quantite'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<?php include '../Includes/header.php'; ?>

<section class="panier my-5">
    <div class="container">
        <h2 class="mb-4">🛒 Votre Panier</h2>

        <?php if (empty($panier)) : ?>
            <div class="alert alert-info">Votre panier est vide.</div>
        <?php else : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($panier as $id => $article) : ?>
                        <tr>
                            <td><img src="../asset/images/<?php echo $article['image']; ?>" style="height: 60px;"></td>
                            <td><?php echo htmlspecialchars($article['nom']); ?></td>
                            <td><?php echo number_format($article['prix'], 2); ?> €</td>
                            <td><?php echo $article['quantite']; ?></td>
                            <td><?php echo number_format($article['prix'] * $article['quantite'], 2); ?> €</td>
                            <td>
                                <!--Supprimer un produit dans le panier -->
                                <a href="panier.php?supprimer=<?php echo $id; ?>" class="btn btn-sm btn-danger">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-end">
                <h4>Total : <?php echo number_format($total, 2); ?> €</h4>
                <a href="commander.php" class="btn btn-success mt-3">✅ Passer la commande</a>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php include '../Includes/footer.php'; ?>
</body>
</html>
