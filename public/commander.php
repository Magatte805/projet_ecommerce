<?php
session_start();
include_once '../config/base.php';

$panier = $_SESSION['panier'] ?? [];
$total = 0;

foreach ($panier as $article) {
    $total += $article['prix'] * $article['quantite'];
}

$expedition = 0;
$montant_total = $total + $expedition;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $code_postal = $_POST['code_postal'];
    $produits_json = json_encode($panier);

    // Connexion à la base
    $db = new Database();
    $conn = $db->getConnection();

    // Insertion dans la base
    $sql = "INSERT INTO commandes (nom, prenom, email, adresse, code_postal, produits, total) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom, $prenom, $email, $adresse, $code_postal, $produits_json, $montant_total]);

    // Vider le panier
    unset($_SESSION['panier']);

    // Affichage du message de succès
    echo "<div class='container my-5 text-center'>";
    echo "<h2 class='text-success'>🎉 Merci pour votre commande, $prenom !</h2>";
    echo "<p>Montant total : <strong>" . number_format($montant_total, 2) . " €</strong></p>";
    echo "<a href='index.php' class='btn btn-primary mt-4'>Continuer à explorer</a>";
    echo "</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Passer la Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<?php include '../Includes/header.php'; ?>

<section class="commande my-5">
    <div class="container">
        <h2 class="mb-4">✅ Passer la Commande</h2>

        <!-- Résumé du panier -->
        <h4>Résumé de votre commande</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($panier as $article) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($article['nom']); ?></td>
                        <td><?php echo $article['quantite']; ?></td>
                        <td><?php echo number_format($article['prix'], 2); ?> €</td>
                        <td><?php echo number_format($article['prix'] * $article['quantite'], 2); ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-end">
            <h4>Total : <?php echo number_format($total, 2); ?> €</h4>
            <h4>Frais d'expédition : <?php echo number_format($expedition, 2); ?> €</h4>
            <h4><strong>Total de la commande : <?php echo number_format($montant_total, 2); ?> €</strong></h4>
        </div>
        <h4>Veuillez entrer vos informations :</h4>
        <form action="commander.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" required>
            </div>
            <div class="mb-3">
                <label for="code_postal" class="form-label">Code Postal</label>
                <input type="text" class="form-control" id="code_postal" name="code_postal" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Passer la commande</button>
        </form>
    </div>
</section>
<?php include '../Includes/footer.php'; ?>
</body>
</html>
