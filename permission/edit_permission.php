<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Permission.php';
$permission = new Permission($db);
// Check if permission ID is provided in the URL
if (isset($_GET['permission_id'])) {
    $permissionId = $_GET['permission_id'];
    $existingPermission = $permission->getPermissionById($permissionId);

    // Handle Permission Update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_permission'])) {
        $permissionName = $_POST['permission_name'];
        $permissionDescription = $_POST['permission_description'];

        // Call a method to update the permission
        $permission->updatePermission($permissionId, $permissionName, $permissionDescription);
        $message = "Permission updated successfully";

        // Encode the message for safe inclusion in the URL
        $encodedMessage = urlencode($message);
        
        echo ' <script>
            // Redirect to role_list.php with the success message
            window.location.replace("permission_list.php?edit_success=" + encodeURIComponent("Permission updated successfully"));
        </script> ';
    }
} else {
    echo "Permission ID not provided.";
    exit;
}
?>
<!-- main content -->
<main class="container-fluid">

    <div class="container mt-5">
        <div class="card border-dark mb-3">

            <div class="card-header">
                <h2>Edit Permission</h2>
            </div>
            <div class="card-body text-dark">
                <form action="edit_permission.php?permission_id=<?= $permissionId ?>" method="post">
                    <!-- Permission Information -->
                    <div class="form-group">
                        <label for="permission_name">Permission Name</label>
                        <input type="text" class="form-control" id="permission_name" name="permission_name" value="<?= $existingPermission['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="permission_description">Permission Description</label>
                        <textarea class="form-control" name="permission_description" required><?= $existingPermission['description'] ?></textarea>
                    </div>
                    <!-- Submit Button -->
                    <button class="btn btn_setting" type="submit" name="update_permission">Update Permission</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include_once '../layouts/footer.php';
?>
