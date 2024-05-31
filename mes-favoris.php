<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['name'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: login.php');
    exit();
}

// Récupérer l'ID de l'utilisateur connecté
$user_id = $_SESSION['id'];

// Placeholder pour les annonces favorites
$favorite_properties = array();

// Connexion à la base de données
$conn = getDbConnection();

// Requête SQL pour récupérer les annonces favorites de l'utilisateur
$sql = "SELECT properties.* FROM properties
        JOIN favorites ON properties.id = favorites.property_id
        WHERE favorites.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Parcourir les résultats et récupérer les détails des propriétés favorites
while ($row = $result->fetch_assoc()) {
    $favorite_properties[] = $row;
}

?>

<style>
    .property-link {
        text-decoration: none; /* Supprimer le soulignement du lien */
        color: inherit; /* Utiliser la couleur par défaut du texte */
        cursor: pointer; /* Changer le curseur au survol */
    }

    .property-link:hover {
        color: inherit; /* Garder la couleur par défaut du texte au survol */
        text-decoration: none; /* Assurer qu'il n'y a pas de soulignement au survol */
    }

    .property {
        padding: 10px;
        border: 1px solid #ddd;
        margin-bottom: 15px;
        border-radius: 5px;
        transition: box-shadow 0.3s;
    }

    .property:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container">
    <h1>Mes annonces favorites</h1>
    <div class="favorite-properties">
        <?php if (empty($favorite_properties)): ?>
            <p>Aucune annonce favorite trouvée.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($favorite_properties as $property): ?>
                    <div class="col-md-4">
                    <a href="property_details.php?id=<?php echo $property['id']; ?>" class="property-link">
                        <div class="property">
                            <h2><?php echo htmlspecialchars($property['title']); ?></h2>
                            <p><?php echo htmlspecialchars($property['description']); ?></p>
                            <p>Prix : <?php echo htmlspecialchars($property['price']); ?> €</p>
                            <p>Type : <?php echo htmlspecialchars($property['type']); ?></p>
                            <img src="<?php echo htmlspecialchars($property['image']); ?>" alt="Photo de la propriété">
                        </div>
                        <a href="compte.php" class="btn btn-secondary">Retour</a>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
