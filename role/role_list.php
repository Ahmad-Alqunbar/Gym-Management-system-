<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Role.php';
// Assuming $db is your database connection
$role = new Role($db);

// Pagination settings
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 4; // Adjust the number of items per page as needed

// Fetch roles with their associated permissions for the current page
$rolesWithPermissions = $role->getRolesWithPermissionsPaginated($page, $perPage);

// Fetch total roles for pagination
$totalPages = $role->getTotalPages($perPage);
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
        if (isset($_GET['edit_success'])) {
            // Decode and display the success message
            $decodedMessage = urldecode($_GET['edit_success']);
            echo '<div class="alert alert-success">' . $decodedMessage . '</div>';
        } elseif (isset($_GET['delete_success'])) {
            $decodedMessage = urldecode($_GET['delete_success']);
            echo '<div class="alert alert-success">' . $decodedMessage . '</div>';
        }elseif (isset($_GET['add_success'])) {
            // Decode and display the success message
            $decodedMessage = urldecode($_GET['add_success']);
        }elseif (isset($_GET['delete_error'])) {
            // Decode and display the success message
            $decodedMessage = urldecode($_GET['delete_error']);

            echo '<div class="alert alert-danger">' . $decodedMessage . '</div>'; 
          }else{
            # code...
          }
        ?>
        <a href="add_role.php" class="btn btn_setting mb-2"> Add Role</a>
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Roles and Permissions</h2>
            </div>
            <div class="card-body text-dark">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Role ID</th>
                            <th>Role Name</th>
                            <th>Role Description</th>
                            <th>Permissions</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rolesWithPermissions as $role) : ?>
                            <tr>
                                <td><?= $role['role_id'] ?></td>
                                <td><?= $role['name'] ?></td>
                                <td><?= $role['description'] ?></td>
                                <td>
                                    <?php foreach ($role['permissions'] as $permission) : ?>

                                        <?php if ($role['name'] =='Admin'|| $role['name'] =='Suber admin') { 
                                            echo '<span class="badge badge-danger">'. $permission .'</span>';

                                         } else { 
                                           echo '<span class="badge badge-info">'. $permission .'</span>';

                                        } 
                                        
                                        ?>
                                        
                                        <br>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                  <a class="btn btn_setting btn-sm" href="edit_role.php?role_id=<?= $role['role_id'] ?>">Edit</a>
                                        <form action="delete_role.php" method="post" onsubmit="return confirmDelete(<?= $role['role_id'] ?>)"style="display:inline;">
                                            <input type="hidden" name="role_id" value="<?= $role['role_id'] ?>">
                                            <button type="submit" class="btn btn_setting btn-sm">Delete</button>
                                        </form>
                                    </div>

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
    function confirmDelete(roleId) {
        return confirm('Are you sure you want to delete this role?');
    }
</script>


