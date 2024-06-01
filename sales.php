<?php
include 'includes/header.php';
include 'includes/db.php';

$conn = getDbConnection();
$result = $conn->query('SELECT * FROM properties WHERE type="sale"');

?>

<main>
    <div class="container">
        <h1>Biens à Vendre</h1>
        <div class="properties">
            <?php while ($property = $result->fetch_assoc()): ?>
                <div class="property" onclick="window.location.href='property.php?id=<?php echo $property['id']; ?>';">
                    <h3><?php echo $property['title']; ?></h3>
                    <img src="assets/images/<?php echo $property['image']; ?>" alt="Photo de <?php echo $property['title']; ?>">
                    <p><?php echo $property['description']; ?></p>
                    <p>Prix : <?php echo $property['price']; ?> €</p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
