<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Permission.php';
$permission = new Permission($db);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 4; // Set your desired number of items per page
// Get data from the getAllPermissions method
$data = $permission->getAllPermissionsPagnation($page, $perPage);
$permissions = $data['permissions'];
$totalCount = $data['totalCount'];

// Calculate total pages
$totalPages = ceil($totalCount / $perPage);
?>
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

<!-- main content -->
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
        }elseif(isset($_GET['delete_error']))
        {
            $decodedMessage = urldecode($_GET['delete_error']);
            echo '<div class="alert alert-danger">' . $decodedMessage . '</div>';

        }elseif (isset($_GET['add_success'])) {
            $decodedMessage = urldecode($_GET['add_success']);
            echo '<div class="alert alert-success">' . $decodedMessage . '</div>';
        }else{
        # code...
    }


        ?>
                <a href="add_permission.php" class="btn btn_setting mb-2"> Add Permission</a>

        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Permission List</h2>
            </div>
            <div class="card-body text-dark">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($permissions as $permission) : ?>
                            <tr>
                                <td><?= $permission['permission_id'] ?></td>
                                <td><?= $permission['name'] ?></td>
                                <td><?= $permission['description'] ?></td>
                                <td>
                                   <a class="btn btn_setting btn-sm" href="edit_permission.php?permission_id=<?= $permission['permission_id'] ?>">Edit</a>

                                       <form action="delete_permission.php" method="post" onsubmit="return confirmDelete(<?= $permission['permission_id'] ?>)"style="display:inline">
                                                <input type="hidden" name="permission_id" value="<?= $permission['permission_id'] ?>">
                                                <button type="submit" class="btn btn_setting btn-sm">Delete</button>
                                        </form>

                                    

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<a href="?page=' . $i . '"' . ($page == $i ? ' class="active"' : '') . '>' . $i . '</a>';
                }
                echo '</div>';
                ?>
            </div>
        </div>
    </div>
</main>

<?php
include_once '../layouts/footer.php';
?>
<script>
    function confirmDelete(permissionId) {
        return confirm('Are you sure you want to delete this Permission ?');
    }
</script>