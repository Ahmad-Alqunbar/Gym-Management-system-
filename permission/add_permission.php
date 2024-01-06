<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Permission.php';
$role = new Permission($db);
// Handle Role Insertion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_permission'])) {
    $permissionName  = $_POST['permission_name'];
    $permissionDescription  = $_POST['permission_description'];
    
    $role->addPermission($permissionName, $permissionDescription);
    // $add_success="Add New Permission Success";
    // $encodedMessage = urlencode($add_success);
    echo ' <script>
    // Redirect to permission_list.php with the success message
    window.location.replace("permission_list.php?add_success=" + encodeURIComponent("Permission Added successfully"));
</script> ';

}
?>
  <!-- main content -->
  <main class="container-fluid">

<div class="container mt-5">
    <div class="card border-dark mb-3">

        <div class="card-header">
       <h2>Add Permission</h2>
        </div>
        <div class="card-body text-dark">
            <form action="add_permission.php" method="post">
                <!-- role Information -->
                <div class="form-group">
                    <label for="name">Permission Name</label>
                    <input type="text" class="form-control" id="permission_name" name="permission_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Permission Description</label>
                    <textarea class="form-control"  name="permission_description" required></textarea>
                </div>
                <!-- Submit Button -->
                <button class="btn btn_setting"type="submit" name="add_permission">Add Permission</button>
            </form>
        </div>
    </div>
</div>
</main>
<?php
include_once '../layouts/footer.php';
?>
