<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
$stmt = $pdo->query("SELECT * FROM equipment");
?>

<div class="container mt-5">
    <h2>Gym Equipment List</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Purchase Date</th>
            <th>Condition</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['description']}</td>";
                echo "<td>{$row['purchase_date']}</td>";
                echo "<td>{$row['equipment_condition']}</td>";
                echo "<td>
                        <a href='equipment_details.php?id={$row['equipment_id']}' class='btn btn_setting btn-sm'>Details</a>
                        <a href='edit_equipment.php?id={$row['equipment_id']}' class='btn btn_setting btn-sm'>Edit</a>
                     </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="add_equipment.php" class="btn btn_setting">Add New Equipment</a>
</div>

<?php include '../layouts/footer.php'; ?>
