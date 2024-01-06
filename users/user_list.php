<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/User.php';

// Assuming $db is your database connection
$user = new User($db);

// Pagination settings
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 4; // Adjust the number of items per page as needed

// Fetch users with their associated roles for the current page
$usersWithRoles = $user->getUsersWithRolesPaginated($page, $perPage);

// Fetch total users for pagination
$totalPages = $user->getTotalPages($perPage);
?>

<!-- main content -->
<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a {
        padding: 8px 16px;
        margin: 0 4px;
        text-decoration: none;
        color: #000;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }
</style>

<main class="container-fluid">

    <div class="container mt-5">
        <?php
        // Display success or error messages
        if (isset($_GET['edit_success'])) {
            $decodedMessage = urldecode($_GET['edit_success']);
            echo '<div class="alert alert-success">' . $decodedMessage . '</div>';
        } elseif (isset($_GET['delete_success'])) {
            $decodedMessage = urldecode($_GET['delete_success']);
            echo '<div class="alert alert-success">' . $decodedMessage . '</div>';
        } elseif (isset($_GET['add_success'])) {
            $decodedMessage = urldecode($_GET['add_success']);
            echo '<div class="alert alert-success">' . $decodedMessage . '</div>';
        }
        ?>
                <a href="add_user.php" class="btn btn_setting mb-2"> Add User</a>

        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>User List</h2>
            </div>
            <div class="card-body text-dark">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usersWithRoles as $user) : ?>
                            <tr>
                                <td><?= $user['user_id'] ?></td>
                                <td><?= $user['name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['address'] ?></td>

                                <td> <span class="badge badge-success"><?= $user['role'] ?> </span></td>
                                <td>
                                        <a class="btn btn_setting btn-sm" href="edit_user.php?user_id=<?= $user['user_id'] ?>">Edit</a>
                                        <form action="delete_user.php" method="post" onsubmit="return confirmDelete(<?= $user['user_id'] ?>)"style="display:inline;">
                                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                            <button type="submit" class="btn btn_setting btn-sm">Delete</button>
                                        </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination links -->
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <a href="?page=<?= $i ?>" <?= ($page == $i) ? ' class="active"' : '' ?>><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include_once '../layouts/footer.php';
?>
<script>
    function confirmDelete(userId) {
        return confirm('Are you sure you want to delete this user?');
    }
</script>
