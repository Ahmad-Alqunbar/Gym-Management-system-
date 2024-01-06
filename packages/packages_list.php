<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Package.php';

$db = new Database();
$package = new Package($db);

// Get all packages
$packages = $package->getAllPackages();
?>

<!-- Main content -->
<main class="container-fluid">
    <div class="container mt-5">
        <?php
        if (isset($_GET['edit_success'])) {
            // Decode and display the success message
            $decodedMessage = urldecode($_GET['edit_success']);
            echo '<div class="alert alert-success">' . $decodedMessage . '</div>';
        } elseif (isset($_GET['delete_success'])) {
            $decodedMessage = urldecode($_GET['delete_success']);
            echo '<div class="alert alert-success">' . $decodedMessage . '</div>';
        } elseif (isset($_GET['add_success'])) {
            // Decode and display the success message
            $decodedMessage = urldecode($_GET['add_success']);
            echo '<div class="alert alert-success">' . $decodedMessage . '</div>';
        } elseif (isset($_GET['delete_error'])) {
            // Decode and display the success message
            $decodedMessage = urldecode($_GET['delete_error']);
            echo '<div class="alert alert-danger">' . $decodedMessage . '</div>';
        } else {
            // Your existing code...
        }
        ?>


        <a href="add_package.php" class="btn btn_setting mb-2"> Add Package</a>

        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Package List</h2>
            </div>
            <div class="card-body text-dark">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($packages as $package) : ?>
                            <tr>
                                <td><?= $package['package_id'] ?></td>
                                <td><?= $package['name'] ?></td>
                                <td><?= $package['description'] ?></td>
                                <td><?= $package['price'] ?></td>
                                <td><?= $package['duration'] ?>  Day</td>
                                <td>
                                    <a href="edit_package.php?package_id=<?= $package['package_id'] ?>" class="btn btn_setting btn-sm">Edit</a>
                                    <form action="delete_package.php" method="post" style="display: inline;" onsubmit="return confirmDelete(<?= $package['package_id'] ?>)">
                                        <input type="hidden" name="package_id" value="<?= $package['package_id'] ?>">
                                        <button type="submit" class="btn btn_setting btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</main>
<script>
    function confirmDelete(packageId) {
        return confirm('Are you sure you want to delete this package?');
    }
</script>

<?php include_once '../layouts/footer.php'; ?>