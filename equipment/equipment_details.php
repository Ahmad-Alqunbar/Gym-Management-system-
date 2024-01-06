<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");

if (isset($_GET['id'])) {
    $equipmentId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM equipment WHERE equipment_id = :id");
    $stmt->bindParam(':id', $equipmentId);
    $stmt->execute();
    $equipment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($equipment) {
        // Display equipment details
        echo "<div class='container mt-5'>";
        echo "<h2>Equipment Details</h2>";
        echo "<p><strong>Name:</strong> {$equipment['name']}</p>";
        echo "<p><strong>Description:</strong> {$equipment['description']}</p>";
        echo "<p><strong>Purchase Date:</strong> {$equipment['purchase_date']}</p>";
        echo "<p><strong>Condition:</strong> {$equipment['equipment_condition']}</p>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'><p>Equipment not found.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Invalid equipment ID.</p></div>";
}

include '../layouts/footer.php';
?>
