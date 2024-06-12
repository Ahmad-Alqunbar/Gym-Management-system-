<?php
include '../layouts/header.php';
$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
if (isset($_GET['id'])) {
    $paymentId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM payments WHERE payment_id = :id");
    $stmt->bindParam(':id', $paymentId);
    $stmt->execute();
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($payment) {
        // Display payment details
        echo "<div class='container mt-5'>";
        echo "<h2>Payment Details</h2>";
        echo "<p><strong>Payment ID:</strong> {$payment['payment_id']}</p>";
        echo "<p><strong>Member ID:</strong> {$payment['member_id']}</p>";
        echo "<p><strong>Date:</strong> {$payment['payment_date']}</p>";
        echo "<p><strong>Amount:</strong> {$payment['amount']}</p>";
        echo "<p><strong>Payment Method:</strong> {$payment['payment_method']}</p>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'><p>Payment not found.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Invalid payment ID.</p></div>";
}
include '../layouts/footer.php';
?>
