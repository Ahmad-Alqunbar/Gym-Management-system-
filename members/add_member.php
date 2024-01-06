<?php
include_once '../layouts/header.php';

// Include the necessary files and classes
require_once '../config/Database.php'; // Assuming you have a Database class
require_once '../controllers/Member.php'; // Assuming you have a Member class
require_once '../controllers/Package.php'; 

// Create an instance of the Database class

// Create an instance of the Member class
$memberManager = new Member($db);
$package=new Package($db);
$packages=$package->getAllPackages();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];


    // $date_start = $_POST['date_start'];
    $packageId = $_POST['package']; // Assuming 'package' is the name attribute of the package dropdown
    $status = $_POST['status'];

    // Add member to the database
    $memberManager->addMember($name, $email, $phone, $gender, $age, $packageId, $status);
    ?>
    <script>  window.location.replace("members_list.php?add_success=" + encodeURIComponent("Member Added successfully")); </script>
<?php }?>

<!-- main content -->
<main class="container-fluid">
    <div class="container mt-5">
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Register Member</h2>
            </div>
            <div class="card-body text-dark">
                <form action="add_member.php" method="post">
                    <!-- Member Information -->

                    <div class="row">

                        <div class="col-lg-6">

                            <div class="form-group">
                                <label for="emergencyContact">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="emergencyContact">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="emergencyContact">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="emergencyContact">Age:</label>
                                <input type="text" class="form-control" id="age" name="age" required>
                            </div>

                        </div>

                        <div class="col-lg-6">
                            <!-- Member Information -->
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="col-lg-6">
                            <div class="form-group">
                                <label for="emergencyContact">Date Start</label>
                                <input type="date" class="form-control" id="date_start" name="date_start" required>
                            </div>
                        </div> -->
                        <div class="col-lg-6">
                            <!-- Package Selection -->
                            <div class="form-group">
                                <label for="package">Select Package</label>
                                <select class="form-control" id="package" name="package" required>
                                    <?php 
                                    foreach ($packages as $packag) { ?>

                                        <option value="<?=$packag['package_id']?>"><?= $packag['name'].'  ' ?>price :<?=$packag['price'].' '?>$</option>

                                   <?php } ?> 
                                    
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                        </div>

                        <div class="col-lg-6">
                            <!-- Package Selection -->
                            <div class="form-group">
                                <label for="package">Select Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="2">Not Active</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn_setting">Register Member</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include_once '../layouts/footer.php';
?>