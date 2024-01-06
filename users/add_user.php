<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/User.php';
include_once '../controllers/Role.php';

// Assuming $db is your database connection
$user = new User($db);
$role = new Role($db);


// Handle User Insertion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $role_id = $_POST['role']; 


    
    // Change from multiple roles to a single role

    // Assuming you have a addUser method in your User controller
    // Replace it with the actual method you have for adding users
    $user->addUser($name, $email, $password, $phone, $address, $role_id);

    // Redirect to the user list page with a success message
    ?>
    <script>  window.location.replace("user_list.php?add_success=" + encodeURIComponent("User Added successfully")); </script>
<?php
}

// Fetch roles from the database
$roles = $role->getRolesWithPermissions();
?>
<!-- main content -->
<main class="container-fluid">

    <div class="container mt-5">
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Add User</h2>
            </div>
            <div class="card-body text-dark">
             <!-- Add User Form -->
                <form action="add_user.php" method="post">
                    <!-- User Information -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" required>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['role_id'] ?>"><?= $role['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <!-- Your role dropdown goes here -->
                    </div>
                    <!-- Submit Button -->
                    <button class="btn btn_setting" type="submit" name="add_user">Add User</button>
                </form>

            </div>
        </div>
    </div>
</main>

<?php
include_once '../layouts/footer.php';
?>
     