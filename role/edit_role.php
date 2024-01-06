<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Role.php';
include_once '../controllers/Permission.php';
?>
<?php
// Assuming $db is your database connection
$role = new Role($db);
$permission = new Permission($db);
$role = new Role($db);
// Get role_id from the URL parameter
$role_id = isset($_GET['role_id']) ? (int)$_GET['role_id'] : 0;

// Fetch role details
$roleDetails = $role->getRoleDetails($role_id);
// Fetch role details based on the role_id from the URL parameter
if (isset($_GET['role_id'])) {
    $role_id = $_GET['role_id'];
    $roleDetails = $role->getRoleDetails($role_id);

    if (!$roleDetails) {
        echo "Role not found.";
        exit;
    }
    // Handle Role Update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_role'])) {
        $newName = $_POST['role_name'];
        $newDescription = $_POST['role_description'];
        $newPermissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];

        $role->editRole($role_id, $newName, $newDescription, $newPermissions);

        $message = "Role updated successfully";

        // Encode the message for safe inclusion in the URL
        $encodedMessage = urlencode($message);
        
        echo ' <script>
            // Redirect to role_list.php with the success message
            window.location.replace("role_list.php?edit_success=" + encodeURIComponent("Role updated successfully"));
        </script> ';
    }
} else {
    echo "Role ID not provided.";
    exit;
}
?>

<!-- main content -->
<main class="container-fluid">

    <div class="container mt-5">
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Edit Role</h2>
            </div>
            <div class="card-body text-dark">
                <form action="edit_role.php?role_id=<?= $role_id ?>" method="post">
                    <!-- Role Information -->
                    <div class="form-group">
                        <label for="name">Role Name</label>
                        <input type="text" class="form-control" id="role_name" name="role_name" value="<?= $roleDetails['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Role Description</label>
                        <textarea class="form-control" name="role_description" required><?= $roleDetails['description'] ?></textarea>
                    </div>

                    <div class="form-group">
                    <label for="permissions">Permissions</label><br>
                    <select name="permissions[]" multiple class="form-control">
                        <?php
                        // Fetch all permissions from the database
                        $allPermissions = $permission->getAllPermissions();

                        // Check if $roleDetails['permissions'] is set
                        $allPermissions = $permission->getAllPermissions();

                        // Check if $roleDetails['permissions'] is set
                        $selectedPermissions = isset($roleDetails['permissions']) ? (array) $roleDetails['permissions'] : [];
                        
                        // Iterate through each permission
                        foreach ($allPermissions as $permission) {
                            $selected = in_array($permission['permission_id'], $selectedPermissions) ? 'selected' : '';
                            echo "<option value='{$permission['permission_id']}' $selected>{$permission['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                    <!-- Submit Button -->
                    <button class="btn btn_setting" type="submit" name="edit_role">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include_once '../layouts/footer.php';
?>