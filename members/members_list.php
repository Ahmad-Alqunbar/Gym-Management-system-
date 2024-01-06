<?php
require_once '../layouts/header.php';
require_once '../config/Database.php';
require_once '../controllers/Member.php';

$memberManager = new Member($db);

// Pagination variables
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = 3; // Adjust this value as needed

// Get paginated members
$membersData = $memberManager->getAllMembersWithPackages($currentPage, $recordsPerPage);
$members = $membersData['data'];
$totalRecords = $membersData['total_records'];

// Calculate total pages
$totalPages = ceil($totalRecords / $recordsPerPage);

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
        elseif (isset($_GET['delete_error'])) {
        $decodedMessage = urldecode($_GET['delete_error']);
        echo '<div class="alert alert-danger">' . $decodedMessage . '</div>';
    }
        ?>
        <a href="add_member.php" class="btn btn_setting mb-2"> Add Member</a>

        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Members List</h2>
            </div>
            <div class="card-body text-dark">
                <table  class="table table-responsive ">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Package Descripation</th>
                        <th>Date Start</th>
                        <th>Date End</th>
                        <th> Status </th>
                        <!-- Add additional columns as needed -->
                        <th>Action</th>
                    </tr>

                    <?php foreach ($members as $member) : ?>
                        <tr>
                            <td><?= $member['id']; ?></td>
                            <td><?= $member['name']; ?></td>
                            <td><?= $member['phone']; ?></td>
                            <td><?= $member['package_name'].'/Duration :'.$member['package_duration']. ' Day / Price :'.$member['package_price'].'$ '; ?></td>
                            <td> <span class="badge badge-success"><?= $member['date_start']; ?></span></td>
                            <td> <span class="badge badge-danger"><?= $member['date_end']; ?></span></td>
                            <!-- Add additional columns as needed -->
                            <td>
                                <?php  if($member['status']==1) { 
                                    echo '<span class="badge badge-success">Active</span>';

                            }else { 
                              echo'  <span class="badge badge-danger">Not Active </span>';

                           }
                         ?>
                            </td>

                            <td>
                            <!-- Add links or buttons for member actions (update, delete, etc.) -->
                            <a class="btn btn_setting btn-sm" href="edit_member.php?id=<?= $member['id']; ?>">Edit</a>
                            
                            <!-- Delete Form -->
                            <form action="delete_member.php" method="post" style="display: inline;">
                                <input type="hidden" name="member_id" value="<?= $member['id']; ?>">
                                <button type="submit" class="btn btn_setting btn-sm" onclick="return confirm('Are you sure you want to delete this member?')">Delete</button>
                            </form>
                        </td>

                        </tr>
                    <?php endforeach; ?>

                </table>
                  <!-- Pagination links -->
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <a href="?page=<?= $i ?>" class="<?= ($currentPage == $i) ? 'active' : ''; ?>"><?= $i ?></a>
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
    
</script>