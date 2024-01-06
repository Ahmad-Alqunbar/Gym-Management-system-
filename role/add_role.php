<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Role.php';
include_once '../controllers/Permission.php';
// Assuming $db is your database connection
$role = new Role($db);
$permission = new Permission($db);
// Handle Role Insertion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_role'])) {
    $roleName = $_POST['role_name'];
    $roleDescription = $_POST['role_description'];
    $selectedPermissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];

    $role->addRole($roleName, $roleDescription, $selectedPermissions);
    ?>
    <script>  window.location.replace("role_list.php?add_success=" + encodeURIComponent("Role Added successfully")); </script>
<?php
}
// Fetch permissions from the database
$permissions = $permission->getAllPermissions();
?>
<!-- main content -->
<main class="container-fluid">

    <div class="container mt-5">
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Add Roles</h2>
            </div>
            <div class="card-body text-dark">
                <form action="add_role.php" method="post">
                    <!-- Role Information -->
                    <div class="form-group">
                        <label for="role_name">Role Name</label>
                        <input type="text" class="form-control" id="role_name" name="role_name" required>
                    </div>
                    <div class="form-group">
                        <label for="role_description">Role Description</label>
                        <textarea class="form-control" name="role_description" required></textarea>
                    </div>
                    <!-- Permissions Dropdown -->
                    <div class="form-group">
                        <label for="permissions">Permissions</label>
                        <select class="form-control" name="permissions[]" multiple required>
                            <?php foreach ($permissions as $permission): ?>
                                <option value="<?= $permission['permission_id'] ?>"><?= $permission['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn_setting" type="submit" name="add_role">Add Role</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include_once '../layouts/footer.php';
?>
