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

// Récupérer les rendez-vous de l'utilisateur à partir de la base de données
// Note: Ici, vous devrez ajouter le code pour récupérer les rendez-vous depuis votre base de données
$appointments = array(); // Placeholder pour les rendez-vous

?>

<div class="container">
    <h1>Mes rendez-vous</h1>
    <div class="appointments">
        <?php if (empty($appointments)): ?>
            <p>Aucun rendez-vous trouvé.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($appointments as $appointment): ?>
                    <li><?php echo $appointment; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
