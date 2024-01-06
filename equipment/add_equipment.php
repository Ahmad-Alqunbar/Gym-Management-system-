<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to add new equipment
    $name = $_POST['name'];
    $description = $_POST['description'];
    $purchaseDate = $_POST['purchase_date'];
    $condition = $_POST['equipment_condition'];

    $stmt = $pdo->prepare("INSERT INTO equipment (name, description, purchase_date, equipment_condition) VALUES (:name, :description, :purchaseDate, :condition)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':purchaseDate', $purchaseDate);
    $stmt->bindParam(':condition', $condition);

    if ($stmt->execute()) {
        echo "<div class='container mt-5'><p>New equipment added successfully.</p></div>";
    } else {
        echo "<div class='container mt-5'><p>Error adding new equipment.</p></div>";
    }
}
?>

<div class="container mt-5">
<div class="card border-dark mb-3">

<div class="card-header">
<h2>Add New Equipment</h2>
</div>
<div class="card-body text-dark">
    <form method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="purchase_date">Purchase Date:</label>
            <input type="date" name="purchase_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="equipment_condition">Condition:</label>
            <input type="text" name="equipment_condition" class="form-control" required>
        </div>
        <button type="submit" class="btn btn_setting">Add Equipment</button>
    </form>
</div>
</div>
</div>
<?php include '../layouts/footer.php'; ?>
