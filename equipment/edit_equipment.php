<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
    // Handle form submission to edit existing equipment
    $equipmentId = $_GET['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $purchaseDate = $_POST['purchase_date'];
    $condition = $_POST['equipment_condition'];

    $stmt = $pdo->prepare("UPDATE equipment SET name = :name, description = :description, purchase_date = :purchaseDate, equipment_condition = :condition WHERE equipment_id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':purchaseDate', $purchaseDate);
    $stmt->bindParam(':condition', $condition);
    $stmt->bindParam(':id', $equipmentId);

    if ($stmt->execute()) {
        echo "<div class='container mt-5'><p>Equipment updated successfully.</p></div>";
    } else {
        echo "<div class='container mt-5'><p>Error updating equipment.</p></div>";
    }
}

if (isset($_GET['id'])) {
    $equipmentId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM equipment WHERE equipment_id = :id");
    $stmt->bindParam(':id', $equipmentId);
    $stmt->execute();
    $equipment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$equipment) {
        echo "<div class='container mt-5'><p>Equipment not found.</p></div>";
        include '../layouts/footer.php';
        exit;
    }
} else {
    echo "<div class='container mt-5'><p>Invalid equipment ID.</p></div>";
    include '../layouts/footer.php';
    exit;
}
?>

<div class="container mt-5">
<div class="card border-dark mb-3">

<div class="card-header">
<h2>Add New Equipment</h2>
</div>
    <form method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" value="<?= $equipment['name'] ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" required><?= $equipment['description'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="purchase_date">Purchase Date:</label>
            <input type="date" name="purchase_date" class="form-control" value="<?= $equipment['purchase_date'] ?>" required>
        </div>
        <div class="form-group">
            <label for="equipment_condition">Condition:</label>
            <input type="text" name="equipment_condition" class="form-control" value="<?= $equipment['equipment_condition'] ?>" required>
        </div>
        <button type="submit" class="btn btn_setting">Update Equipment</button>
    </form>
</div>
</div>
</div>

<?php include '../layouts/footer.php'; ?>
