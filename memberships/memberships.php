<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
$stmt = $pdo->query("SELECT * FROM membership WHERE payment_status = 'Paid'");

?>

<div class="container mt-5">
    <h2>Active Memberships List</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Member ID</th>
            <th>Package ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Payment Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['member_id']}</td>";
                echo "<td>{$row['package_id']}</td>";
                echo "<td>{$row['start_date']}</td>";
                echo "<td>{$row['end_date']}</td>";
                echo "<td>{$row['payment_status']}</td>";
                echo "<td>
                        <a href='membership_details.php?id={$row['membership_id']}' class='btn btn_setting btn-sm'>Details</a>
                        <a href='manage_membership.php?id={$row['membership_id']}' class='btn btn_setting btn-sm'>Manage</a>
                     </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../layouts/footer.php'; ?>
