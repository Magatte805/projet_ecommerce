<?php
// Ce fichier contient l'en-tête de notre site 
// Il inclut la gestion de la session pour le panier et l'affichage du nombre d'articles dans le panier.
// Il comprend également un menu de navigation avec des liens vers les pages principales du site (Accueil, Boutique),
// ainsi qu'une icône de panier avec un badge indiquant le nombre d'articles dans le panier.

// On démarre la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//On initialise la variable pour le nombre d'articles dans le panier
$nb_articles = 0;

//On vérifie si le panier existe en session et calculer le total d'articles
if (isset($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $item) {
        $nb_articles += $item['quantite'];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUSCARIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css"> 
</head>
<body>
<header class="bg-light py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <h1 class="mb-0">MUSCARIA</h1>
        </div>
        <nav class="mx-auto d-flex justify-content-center">
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="../public/index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="../public/boutique.php">Boutique</a></li>
            </ul>
        </nav>
        <div class="panier-icon position-relative">
            <a href="../public/panier.php">
                <img src="../asset/images/panier.png" alt="Panier" style="height: 30px;">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="panier-count">
                    <?php echo $nb_articles; ?>
                </span>
            </a>
        </div>
    </div>
</header>
</body>
</html>
