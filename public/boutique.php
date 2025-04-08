<?php include_once '../config/base.php'; ?>
<?php include_once '../classe/produit.php'; ?>

<?php
// Ce fichier affiche la liste des produits disponibles.
// Il se connecte à la base de données, récupère tous les produits et les affiche sous forme de cartes.


// Connexion à la base de données
$db = new Database();
$conn = $db->getConnection();

// Récupérer les produits
$produit = new Produit($conn);
$produits = $produit->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<!-- Header -->
<?php include '../Includes/header.php'; ?>

<!-- Liste des produits -->
<section class="produits my-5">
    <div class="container">
        <h2 class="text-center mb-4">Nos Produits</h2>
        <div class="row">
            <?php foreach ($produits as $produit): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <a href="détail_produit.php?id=<?php echo $produit['id']; ?>" class="text-decoration-none">
                            <img src="../asset/images/<?php echo $produit['image']; ?>" alt="<?php echo $produit['nom']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $produit['nom']; ?></h5>
                                <p class="card-text"><?php echo number_format($produit['prix'], 2); ?> €</p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include '../Includes/footer.php'; ?>
</body>
</html>
