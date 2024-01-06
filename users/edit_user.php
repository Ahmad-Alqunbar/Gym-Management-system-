<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/User.php';
include_once '../controllers/Role.php';
$db = new Database();
$user = new User($db);
$role = new Role($db);
// Fetch user details based on user_id from the URL parameter
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$userDetails = $user->getUserDetails($user_id);
// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role_id = $_POST['role_id'];

    // Call the updateUser function
    $user->updateUser($user_id, $name, $email, $phone, $address, $role_id,$password);

    // Redirect back to user_list.php with a success message
    $encodedMessage = urlencode('User updated successfully.');
?>
    <script>
        window.location.replace("user_list.php?edit_success=" + encodeURIComponent("User updated successfully."));
    </script>

<?php
}
?>
<!-- Your HTML form for editing user details goes here -->
<main class="container-fluid">
    <div class="container mt-5">
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Edit User</h2>
            </div>
            <div class="card-body text-dark">
                <form action="edit_user.php?user_id=<?= $user_id ?>" method="post">
                    <!-- User Information -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $userDetails['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $userDetails['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="">
                        <!-- <?= $userDetails['password'] ?> -->
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $userDetails['phone'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address"><?= $userDetails['address'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            <?php
                            // Fetch roles from the database
                            $roles = $role->getRolesWithPermissions();

                            // Iterate through roles and create options
                            foreach ($roles as $roleItem) {
                                $selected = ($roleItem['role_id'] == $userDetails['role_id']) ? 'selected' : '';
                                echo '<option value="' . $roleItem['role_id'] . '" ' . $selected . '>' . $roleItem['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Submit Button -->
                    <button class="btn btn_setting" type="submit" name="edit_user">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include_once '../layouts/footer.php';
?>