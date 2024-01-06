<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");

if (isset($_GET['id'])) {
    $packageId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM packages WHERE package_id = :id");
    $stmt->bindParam(':id', $packageId);
    $stmt->execute();
    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($package) {
        // Display package details
        echo "<div class='container mt-5'>";
        echo "<h2>Package Details</h2>";
        echo "<p><strong>Name:</strong> {$package['name']}</p>";
        echo "<p><strong>Description:</strong> {$package['description']}</p>";
        echo "<p><strong>Price:</strong> {$package['price']}</p>";
        echo "<p><strong>Duration:</strong> {$package['duration']}</p>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'><p>Package not found.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Invalid package ID.</p></div>";
}

include '../layouts/footer.php';
?>
