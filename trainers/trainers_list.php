<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Trainer.php';

$db = new Database();
$trainer = new Trainer($db);

// Get all trainers
$trainers = $trainer->getAllTrainers();
?>

<!-- Main content -->
<main class="container-fluid">
    <div class="container mt-5">
        <?php
        // Your existing code for success messages here...
        ?>

        <a href="add_trainer.php" class="btn btn_setting mb-2"> Add Trainer</a>

        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Trainer List</h2>
            </div>
            <div class="card-body text-dark">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Hire Date</th>
                            <th>Expertise</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trainers as $trainer) : ?>
                            <tr>
                                <td><?= $trainer['id'] ?></td>
                                <td><?= $trainer['name'] ?></td>
                                <td><?= $trainer['age'] ?></td>
                                <td><?= $trainer['gender'] ?></td>
                                <td><?= $trainer['hire_date'] ?></td>
                                <td><?= $trainer['expertise'] ?></td>
                                <td>
                                    <?php if (!empty($trainer['image_url'])) : ?>
                                        <img src="<?= $trainer['image_url'] ?>" alt="<?= $trainer['name'] ?>" style="max-width: 100px; max-height: 100px;">
                                    <?php else : ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_trainer.php?id=<?= $trainer['id'] ?>" class="btn btn_setting btn-sm">Edit</a>
                                    <form action="delete_trainer.php" method="post" style="display: inline;" onsubmit="return confirmDelete(<?= $trainer['id'] ?>)">
                                        <input type="hidden" name="trainer_id" value="<?= $trainer['id'] ?>">
                                        <button type="submit" class="btn btn_setting btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script>
    function confirmDelete(trainerId) {
        return confirm('Are you sure you want to delete this trainer?');
    }
</script>

<?php include_once '../layouts/footer.php'; ?>
