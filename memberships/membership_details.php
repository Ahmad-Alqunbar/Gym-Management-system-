<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");

if (isset($_GET['id'])) {
    $membershipId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM membership WHERE membership_id = :id");
    $stmt->bindParam(':id', $membershipId);
    $stmt->execute();
    $membership = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($membership) {
        // Display membership details
        echo "<div class='container mt-5'>";
        echo "<h2>Membership Details</h2>";
        echo "<p><strong>Member ID:</strong> {$membership['member_id']}</p>";
        echo "<p><strong>Package ID:</strong> {$membership['package_id']}</p>";
        echo "<p><strong>Start Date:</strong> {$membership['start_date']}</p>";
        echo "<p><strong>End Date:</strong> {$membership['end_date']}</p>";
        echo "<p><strong>Payment Status:</strong> {$membership['payment_status']}</p>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'><p>Membership not found.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Invalid membership ID.</p></div>";
}

include '../layouts/footer.php';
?>
