<?php
include '../layouts/header.php';

// Handle form submission to process a new payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submissions for new payments
    // You can add the necessary logic based on your requirements
    // For example, insert the payment record into the database
    $memberId = $_POST['member_id'];
    $paymentDate = date("Y-m-d"); // Record the current date
    $amount = $_POST['amount'];
    $paymentMethod = $_POST['payment_method'];

    $pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
    $stmt = $pdo->prepare("INSERT INTO payments (member_id, payment_date, amount, payment_method) VALUES (:member_id, :payment_date, :amount, :payment_method)");
    $stmt->bindParam(':member_id', $memberId);
    $stmt->bindParam(':payment_date', $paymentDate);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':payment_method', $paymentMethod);

    if ($stmt->execute()) {
        // Successful payment, you can redirect or display a success message
        header("Location: payments.php");
        exit();
    } else {
        echo "<p>Error processing payment.</p>";
    }
}

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
$stmt = $pdo->query("SELECT * FROM members");

?>

<div class="container mt-5">
<div class="card border-dark mb-3">

<div class="card-header">
<h2>Process New Payment</h2>


</div>
<div class="card-body text-dark">
    <form method="post">
        <div class="form-group">
            <label for="member_id">Select Member:</label>
            <select class="form-control" id="member_id" name="member_id" required>
                <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['member_id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <input type="text" class="form-control" id="payment_method" name="payment_method" required>
        </div>

        <button type="submit" class="btn btn_setting">Process Payment</button>
    </form>
</div>
</div>
</div>
<?php include '../layouts/footer.php'; ?>
