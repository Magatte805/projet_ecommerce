<?php
// Ce fichier permet d'ajouter un produit au panier. Il gère la création du panier en session si nécessaire, 
// l'ajout d'un produit dans le panier
// et renvoie le nombre total d'articles dans le panier pour mettre à jour l'icône du panier sur le site.

session_start();

// Récupérer les données envoyées par la requête
$id = $_POST['id'];
$nom = $_POST['nom'];
$prix = $_POST['prix'];
$image = $_POST['image'];

// Vérifier si le panier existe déjà en session, sinon le créer
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Vérifier si le produit est déjà dans le panier
if (isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id]['quantite'] += 1;
} else {
    // Si le produit n'existe pas, l'ajouter avec une quantité de 1
    $_SESSION['panier'][$id] = [
        'nom' => $nom,
        'prix' => $prix,
        'image' => $image,
        'quantite' => 1
    ];
}
// Calculer le nombre total d'articles dans le panier
$total_articles = 0;
foreach ($_SESSION['panier'] as $item) {
    $total_articles += $item['quantite'];
}

// Retourner le nombre d'articles pour mettre à jour l'icône du panier
echo $total_articles;
?>
