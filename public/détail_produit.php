<?php 
// Ce fichier affiche les détails d'un produit sélectionné par l'utilisateur.
// Il permet également d'ajouter ce produit au panier via une requête JavaScript (AJAX)

session_start();

include_once '../config/base.php'; 
include_once '../classe/produit.php'; 


// Connexion à la base de données
$db = new Database();
$conn = $db->getConnection();

// On vérifie si un ID de produit a été fourni dans l'URL
if (isset($_GET['id'])) {
    $id_produit = $_GET['id'];
    //On récupère les détails du produit à partir de l'ID
    $produit = new Produit($conn);
    $produit->id = $id_produit;
    $produit_details = $produit->getOne();

    if (!$produit_details) {
        echo "Produit non trouvé!";
        exit;
    }
} else {
    echo "Aucun produit spécifié!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<?php include '../Includes/header.php'; ?>

<section class="produit-detail my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="../asset/images/<?php echo $produit_details['image']; ?>" class="img-fluid" style="height: 300px; object-fit: cover;">
            </div>
            <div class="col-md-6">
                <h2><?php echo $produit_details['nom']; ?></h2>
                <p><?php echo $produit_details['description']; ?></p>
                <p class="lead"><?php echo number_format($produit_details['prix'], 2); ?> €</p>
                <button class="btn btn-primary ajouter-panier" 
                    data-id="<?php echo $produit_details['id']; ?>" 
                    data-nom="<?php echo htmlspecialchars($produit_details['nom']); ?>" 
                    data-prix="<?php echo $produit_details['prix']; ?>" 
                    data-image="<?php echo $produit_details['image']; ?>">
                    Ajouter au panier
                </button>
            </div>
        </div>
    </div>
</section>

<?php include '../Includes/footer.php'; ?>

<script>
document.querySelector('.ajouter-panier').addEventListener('click', function () {
    const btn = this;
    //Création des données à envoyer
    const formData = new FormData();
    formData.append('id', btn.dataset.id);
    formData.append('nom', btn.dataset.nom);
    formData.append('prix', btn.dataset.prix);
    formData.append('image', btn.dataset.image);

    fetch('ajouter_panier.php', {
        method: 'POST',
        body: formData
    })
    //On récupérer le nombre d'articles dans le panier
    .then(res => res.text())  
    .then(nb => {
        //On met à jour l'icône du panier
        document.querySelector('#panier-count').textContent = nb; 
    });
});
</script>
</body>
</html>
