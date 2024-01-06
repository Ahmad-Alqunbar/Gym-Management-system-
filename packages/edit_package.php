<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Package.php';

$db = new Database();
$package = new Package($db);

// Handle package update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_package'])) {
    $package_id = isset($_POST['package_id']) ? (int)$_POST['package_id'] : 0;
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    // Update the package
    $updateMessage = $package->updatePackage($package_id, $name, $description, $price, $duration);

    if ($updateMessage === true) {

        ?>
            <script>  window.location.replace("packages_list.php?add_success=" + encodeURIComponent("Package updated successfully.")); </script>

      <?php
    } else {
        // Display an error message
        $encodedMessage = urlencode($updateMessage);
        header("Location: packages_list.php?edit_error=$encodedMessage");
        exit;
    }
}

// Fetch package details for editing
if (isset($_GET['package_id'])) {
    $package_id = (int)$_GET['package_id'];
    $packageDetails = $package->getPackageDetails($package_id);

    if (!$packageDetails) {
        // Package not found, redirect to packages_list.php with an error message
        $encodedMessage = urlencode('Package not found.');
        header("Location: packages_list.php?edit_error=$encodedMessage");
        exit;
    }
} else {
    // Redirect to packages_list.php if package_id is not provided
    header("Location: packages_list.php");
    exit;
}
?>

<!-- main content -->
<main class="container-fluid">
    <div class="container mt-5">
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Edit Package</h2>
            </div>
            <div class="card-body text-dark">
                <form action="edit_package.php" method="post">
                    <!-- Hidden input for package_id -->
                    <input type="hidden" name="package_id" value="<?= $packageDetails['package_id'] ?>">

                    <!-- Package Information -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $packageDetails['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" required><?= $packageDetails['description'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?= $packageDetails['price'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" value="<?= $packageDetails['duration'] ?>" required>
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn_setting" type="submit" name="update_package">Update Package</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include_once '../layouts/footer.php';
?>
