<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Trainer.php';

$trainer = new Trainer($db);

// Handle Trainer Insertion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_trainer'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $image = $_FILES['image'];
    $hire_date = $_POST['hire_date'];
    $gender = $_POST['gender'];
    $expertise = $_POST['expertise'];

    $result = $trainer->addTrainer($name, $age, $image, $hire_date, $gender, $expertise);

    if (is_numeric($result)) {
        // Trainer added successfully
        $encodedMessage = urlencode('Trainer added successfully with ID: ' . $result);
        echo '<script>window.location.replace("trainer_list.php?add_success=' . $encodedMessage . '");</script>';
        exit();
    } else {
        // Display error message
        echo '<div class="alert alert-danger">' . $result . '</div>';
    }
}
?>

<!-- Main Content -->
<main class="container-fluid">
    <div class="container mt-5">
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Add Trainer</h2>
            </div>
            <div class="card-body text-dark">
                <form action="add_trainer.php" method="post" enctype="multipart/form-data">
                    <!-- Trainer Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" name="age" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hire_date">Hire Date</label>
                                <input type="date" class="form-control" id="hire_date" name="hire_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="expertise">Expertise</label>
                                <input type="text" class="form-control" id="expertise" name="expertise" required>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn_setting" type="submit" name="add_trainer">Add Trainer</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include_once '../layouts/footer.php'; ?>