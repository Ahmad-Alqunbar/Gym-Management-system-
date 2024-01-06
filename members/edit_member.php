<?php
include_once '../layouts/header.php';
require_once '../config/Database.php';
require_once '../controllers/Member.php';
require_once '../controllers/Package.php';
// Create instances of the Member and Package classes
$memberManager = new Member($db);
$package = new Package($db);

// Get the member details based on the provided ID
if (isset($_GET['id'])) {
    $memberId = $_GET['id'];
    $memberDetails = $memberManager->getMemberDetails($memberId);
} else {
    // Redirect to members list if no ID is provided
    // header('Location: members.php');
    // exit();
    echo "test faild";
}



// Get all packages for the dropdown
$packages = $package->getAllPackages();
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $memberId = $_POST['id'];  // Change 'member_id' to 'id'
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $gender = $_POST['gender']; // Make sure this is coming from the correct form field
    $packageId = $_POST['package'];
    $status = $_POST['status'];
    $date_start = $_POST['date_start'];

    

    // Update member details in the database
    $result = $memberManager->updateMember($memberId,$name,$email,$phone,$age,$gender,$packageId,$status,$date_start);

    // Display success or error messages
    if ($result === true) {
        ?>
    <script>  window.location.replace("members_list.php?edit_success=" + encodeURIComponent("Member Updated successfully")); </script>
<?php 
    } 
    else 
    {
        $errorMessage = ($result) ? $result : 'Failed to update member.';
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
}
?>

<!-- main content -->
<main class="container-fluid">
    <div class="container mt-5">
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Edit Member</h2>
            </div>
            <div class="card-body text-dark">
            <form action="edit_member.php?id=<?= $memberDetails['id']; ?>" method="post">
            <input type="hidden" name="id" value="<?= $memberDetails['id']; ?>">

                    <div class="row">
                        <!-- Member Information -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $memberDetails['name'] ?>" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?= $memberDetails['email'] ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= $memberDetails['phone'] ?>" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= $memberDetails['phone'] ?>" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" name="age" value="<?= $memberDetails['age'] ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Member Information -->
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= ($memberDetails['gender'] == 'male') ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= ($memberDetails['gender'] == 'female') ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="age">Date Start</label>
                                <input type="date" class="form-control" id="date_start" name="date_start" value="<?= $memberDetails['date_start'] ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Package Selection -->
                            <div class="form-group">
                                <label for="package">Select Package</label>
                                <select class="form-control" id="package" name="package" required>
                                    <?php foreach ($packages as $package) { ?>
                                        <option value="<?= $package['package_id'] ?>" <?= ($package['package_id'] == $memberDetails['package_id']) ? 'selected' : '' ?>>
                                            <?= $package['name'] . '  ' ?>price :<?= $package['price'] . ' ' ?>$
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Status Selection -->
                            <div class="form-group">
                                <label for="status">Select Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="1" <?= ($memberDetails['status'] == 1) ? 'selected' : '' ?>>Active</option>
                                    <option value="2" <?= ($memberDetails['status'] == 2) ? 'selected' : '' ?>>Not Active</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>

                      



                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn_setting">Update Member</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include_once '../layouts/footer.php'; ?>
