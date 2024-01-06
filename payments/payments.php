<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
$stmt = $pdo->query("SELECT * FROM payments");

?>

<div class="container mt-5">
    <h2>Payment Transactions List</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Payment ID</th>
            <th>Member ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['payment_id']}</td>";
                echo "<td>{$row['member_id']}</td>";
                echo "<td>{$row['payment_date']}</td>";
                echo "<td>{$row['amount']}</td>";
                echo "<td>{$row['payment_method']}</td>";
                echo "<td>
                        <a href='payment_details.php?id={$row['payment_id']}' class='btn btn_setting btn-sm'>Details</a>
                     </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../layouts/footer.php'; ?>
