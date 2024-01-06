<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Package.php';

$db = new Database();
$package = new Package($db);

// Handle Package Insertion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_package'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    $package->addPackage($name, $description, $price, $duration);
    ?>
        <script>  window.location.replace("packages_list.php?add_success=" + encodeURIComponent("Package Added successfully")); </script>

<?php
}
?>

<!-- Main content -->
<main class="container-fluid">
    <div class="container mt-5">
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Add Package</h2>
            </div>
            <div class="card-body text-dark">
                <form action="add_package.php" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration (in days)</label>
                        <input type="number" class="form-control" id="duration" name="duration" required>
                    </div>
                    <button class="btn btn_setting" type="submit" name="add_package">Add Package</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include_once '../layouts/footer.php'; ?>
